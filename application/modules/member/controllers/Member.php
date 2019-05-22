<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends MY_Controller {
	
	public function __construct() {
			parent::__construct();
			$this->load->model('member/member_model');
			if(!$this->session->userdata('username')){
				redirect('login/logout');
			}
    }

	public function index() {
		$data['title'] = 'Member';
		//Header
		$this->load->view('templates/header', $data);
		// Body
		$this->load->view('member_main');
		//JS
		$this->load->view('member_mainjs');
		// Footer
		$this->load->view('templates/footer');
	}

	function modal_form($hash = '0'){
		$query = $this->Db_model->get('member','*',array('sha1(member_id)' => $hash));
		//Query for tipe member
		$query_tipe_member = $this->Db_model->get('tipe_member','*','','tipe_member_id asc');
		$query_fakultas = $this->Db_model->get('fakultas');

		if($hash != '0') {
			//Query for update member
			
			$tanggal_lahir = $query->row();
			$tanggal_lahir = $tanggal_lahir->tgl_lahir;

			//Rubah format tanggal
			$hari = substr($tanggal_lahir,-2);
			$bulan = substr($tanggal_lahir,5,2);
			$tahun = substr($tanggal_lahir,0,4);
			$tanggal_lahir = $hari.'/'.$bulan.'/'.$tahun;

			$prodi = $query->prodi;
			$query_prodi = $this->Db_model->get('prodi','*',array('kd_prodi' => $prodi));
			$kd_fakultas = $query_prodi->id_fakultas;

			
			$data['tanggal_lahir'] = $tanggal_lahir;
			$data['kd_fakultas'] = $kd_fakultas;
			$data['query_prodi'] = $query_prodi;
		} 
		$data['data'] = $query;
		
		$data['tipe_member'] = $query_tipe_member;
		$data['fakultas'] = $query_fakultas;

		$this->load->view('member/modal_member/modal_member_main', $data);
		$this->load->view('member/modal_member/modal_member_mainjs');
	}

	function ajaxprodi() {
		$id=$this->input->post('id');
		$prodi="<option value='0'>--pilih--</pilih>";
		$query_prodi = $this->Db_model->get('prodi','*',array('id_fakultas ' => $id), 'kd_prodi asc');
		foreach ($query_prodi->result() as $row) {
			$prodi.= "<option value='$row->kd_prodi'>$row->prodi</option>";
		}
		echo $prodi;
	}

	function simpan_member() {
		$nomor_induk_member = $this->input->post('nomor_induk_member');
		$tipe_member = $this->input->post('tipe_member');
		$nama_member = $this->input->post('nama_member');
		$jenis_kelamin = $this->input->post('jenis_kelamin');
		$tanggal_lahir = $this->input->post('tanggal_lahir');

		//Rubah format tanggal
		$hari = substr($tanggal_lahir,0,2);
		$bulan = substr($tanggal_lahir,3,2);
		$tahun = substr($tanggal_lahir,-4);
		$tanggal_lahir = $tahun.'-'.$bulan.'-'.$hari;

		$alamat = $this->input->post('alamat');
		$email = $this->input->post('email');
		$prodi = $this->input->post('prodi');

		$result['status'] = 'gagal';
		$data = array();
		$ref = $this->input->post('ref');

		if($ref == '0') {
			if($nomor_induk_member) {
				$cek_nomor_induk_member = $this->Db_model->get(
					'member','nomor_induk_member',array('nomor_induk_member' => $nomor_induk_member));
				if($cek_nomor_induk_member->num_rows()>0){
					$result['alert'] 	= 'Nomor induk member sudah dipakai';
					echo json_encode($result); exit();
				} else {
					$data['nomor_induk_member'] = $nomor_induk_member;
				}
			} else {
				$result['alert'] = 'Nomor induk member harus diisi';
				echo json_encode($result); exit();
			}
		}

		if($tipe_member) {
			$data['tipe_member_id'] = $tipe_member;
		} else {
			$result['alert'] = 'Tipe member harap dipilih';
			echo json_encode($result); exit();
		}

		if($nama_member) {
			$data['nama_member'] = $tipe_member;
		} else {
			$result['alert'] = 'Nama harus diisi';
			echo json_encode($result); exit();
		}

		if($jenis_kelamin) {
			$data['jenis_kelamin'] = $jenis_kelamin;
		} else {
			$result['alert'] = 'Jenis kelamin harap dipilih';
			echo json_encode($result); exit();
		}

		if($tanggal_lahir) {
			$data['tgl_lahir'] = $tanggal_lahir;
		} else {
			$result['alert'] = 'Tanggal harus diisi';
			echo json_encode($result); exit();
		}

		if($alamat) {
			$data['alamat'] = $alamat;
		} else {
			$result['alert'] = 'Alamat harus diisi';
			echo json_encode($result); exit();
		}

		if($email) {
			$data['email'] = $email;
		} else {
			$result['alert'] = 'Email harus diisi';
			echo json_encode($result); exit();
		}

		if($prodi) {
			$data['prodi'] = $prodi;
		} else {
			$result['alert'] = 'Prodi harus diisi';
			echo json_encode($result); exit();
		}

		$data['last_update'] = date("Y-m-d H:i:s");

		if($ref == '0') {
			$data['input_date'] = date("Y-m-d H:i:s");
			$this->Db_model->add('member',$data);
			$result['alert']  = "Data berhasil disimpan";
		} else {
			$this->Db_model->update('member',$data,array('md5(member_id)' => $ref));
			$result['alert']  = "Data berhasil diupdate";
		}
		echo json_encode($result);
	}

	function hapus($sha1){
		$this->Db_model->delete('member',array('sha1(member_id)' => $sha1));
	}

	function ajaxdatatable() {
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));


		$query = $this->db->get("member");


		$data = [];
		$no = 1;

		foreach($query->result() as $r) {
			$data[] = array(
					$no,
					$r->nomor_induk_member,
					$r->nama_member,
					$r->prodi,
					"<button type='button' class='btn btn-info ganti' id='".sha1($r->member_id)."'>Ubah</button>
					<button type='button' class='btn btn-warning hapus' id='".sha1($r->member_id)."'>Hapus</button>"
			); $no++;
		}


		$result = array(
				"draw" => $draw,
					"recordsTotal" => $query->num_rows(),
					"recordsFiltered" => $query->num_rows(),
					"data" => $data
				);


		echo json_encode($result);
		exit();
	}
}

?>
