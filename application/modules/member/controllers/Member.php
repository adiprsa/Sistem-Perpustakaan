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

	function modal_form(){
		$data['tipe_member'] = $this->Db_model->get('tipe_member');
		$data['fakultas'] = $this->Db_model->get('fakultas');
		$this->load->view('member/modal_member/modal_member_main',$data);
		$this->load->view('member/modal_member/modal_member_mainjs');
	}

	function edit_form($id){
		$query_member = $this->Db_model->get('member','*',array('member_id' => $id))->row();
		$data['member'] = $query_member;
		$data['tipe_member'] = $this->Db_model->get('tipe_member');
		$data['fakultas'] = $this->Db_model->get('fakultas');
		$query_id_fakultas = $this->Db_model->get('prodi','*',array('kd_prodi' => $query_member->prodi_id))->row();
		$data['id_fakultas'] = $query_id_fakultas->id_fakultas;
		$data['prodi'] = $this->Db_model->get('prodi','*',array('id_fakultas' => $query_id_fakultas->id_fakultas));
		
		//konversi tanggal lahir
		$tanggal_lahir = $query_member->tgl_lahir;
		$hari = substr($tanggal_lahir,-2);
		$bulan = substr($tanggal_lahir,5,2);
		$tahun = substr($tanggal_lahir,0,4);
		$tanggal_lahir = $hari.'/'.$bulan.'/'.$tahun;
		$data['tanggal_lahir'] = $tanggal_lahir;

		//konversi tanggal register
		$tanggal_register = $query_member->tgl_register;
		$hari = substr($tanggal_register,-2);
		$bulan = substr($tanggal_register,5,2);
		$tahun = substr($tanggal_register,0,4);
		$tanggal_register = $hari.'/'.$bulan.'/'.$tahun;
		$data['tanggal_register'] = $tanggal_register;
		$this->load->view('member/modal_edit_member/modal_edit_member',$data);
		$this->load->view('member/modal_edit_member/modal_edit_memberjs');
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

	function ajaxprodi_edit() {
		$id=$this->input->post('id');
		echo $this->input->post('ref');
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

		$tanggal_register = $this->input->post('tanggal_register');
		//Rubah format tanggal
		$hari = substr($tanggal_register,0,2);
		$bulan = substr($tanggal_register,3,2);
		$tahun = substr($tanggal_register,-4);
		$tanggal_register = $tahun.'-'.$bulan.'-'.$hari;

		$result['status'] = 'gagal';
		$data = array();

		if($nomor_induk_member) {
			$cek_nomor_induk_member = $this->Db_model->get(
				'member','member_code',array('member_code' => $nomor_induk_member));
			if($cek_nomor_induk_member->num_rows()>0){
				$result['alert'] 	= 'Nomor induk member sudah dipakai';
				echo json_encode($result); exit();
			} else {
				$data['member_code'] = $nomor_induk_member;
			}
		} else {
			$result['alert'] = 'Nomor induk member harus diisi';
			echo json_encode($result); exit();
		}

		if($tipe_member != 0) {
			$data['tipe_member_id'] = $tipe_member;
		} else {
			$result['alert'] = 'Tipe member harap dipilih';
			echo json_encode($result); exit();
		}

		if($nama_member) {
			$data['nama_member'] = $nama_member;
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

		if($tanggal_lahir != "") {
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

		if($prodi == 0) {
			$data['prodi_id'] = $prodi;
		} else {
			$result['alert'] = 'Prodi harus dipilih';
			echo json_encode($result); exit();
		}

		if($tanggal_register != "") {
			$data['tgl_register'] = $tanggal_register;
		} else {
			$result['alert'] = 'Tanggal harus diisi';
			echo json_encode($result); exit();
		}

		$data['last_update'] = date("Y-m-d H:i:s");
		$data['input_date'] = date("Y-m-d H:i:s");echo json_encode($data);exit();
		$this->Db_model->add('member',$data);
		$result['alert']  = "Data berhasil disimpan";
		$result['status'] = 'berhasil';
		echo json_encode($result);
	}

	function update_member() {
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

		$tanggal_register = $this->input->post('tanggal_register');
		//Rubah format tanggal
		$hari = substr($tanggal_register,0,2);
		$bulan = substr($tanggal_register,3,2);
		$tahun = substr($tanggal_register,-4);
		$tanggal_register = $tahun.'-'.$bulan.'-'.$hari;

		$tanggal_expired = $this->input->post('tanggal_expired');
		//Rubah format tanggal
		$hari = substr($tanggal_expired,0,2);
		$bulan = substr($tanggal_expired,3,2);
		$tahun = substr($tanggal_expired,-4);
		$tanggal_expired = $tahun.'-'.$bulan.'-'.$hari;

		$result['status'] = 'gagal';
		$data = array();

		if($nomor_induk_member) {
			$cek_nomor_induk_member = $this->Db_model->get(
				'member','member_code',array('member_code' => $nomor_induk_member));
			if($cek_nomor_induk_member->num_rows()>0){
				$result['alert'] 	= 'Nomor induk member sudah dipakai';
				echo json_encode($result); exit();
			} else {
				$data['member_code'] = $nomor_induk_member;
			}
		} else {
			$result['alert'] = 'Nomor induk member harus diisi';
			echo json_encode($result); exit();
		}

		if($tipe_member != 0) {
			$data['tipe_member_id'] = $tipe_member;
		} else {
			$result['alert'] = 'Tipe member harap dipilih';
			echo json_encode($result); exit();
		}

		if($nama_member) {
			$data['nama_member'] = $nama_member;
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

		if($tanggal_lahir != "") {
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

		if($prodi == 0) {
			$data['prodi_id'] = $prodi;
		} else {
			$result['alert'] = 'Prodi harus dipilih';
			echo json_encode($result); exit();
		}

		if($tanggal_register != "") {
			$data['tgl_register'] = $tanggal_register;
		} else {
			$result['alert'] = 'Tanggal harus diisi';
			echo json_encode($result); exit();
		}
		if($tanggal_expired != "") {
			$data['tgl_expired'] = $tanggal_expired;
		}

		$data['last_update'] = date("Y-m-d H:i:s");
		$ref = $this->input->post('ref');
		$this->Db_model->update('member',$data,array('member_id' => $ref));
		$result['alert']  = "Data berhasil disimpan";
		$result['status'] = 'berhasil';
		echo json_encode($result);
	}

	function hapus($sha1){
		$this->Db_model->delete('member',array('sha1(member_id)' => $sha1));
	}

	public function get_data_member() {
		$this->load->model('member/Member_model','Member_model');
		$list = $this->Member_model->get_datatables();
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();

			$row[] = isset($rows->member_code) ? $rows->member_code : '-';
			$row[] = isset($rows->nama_tipe_member) ? $rows->nama_tipe_member : '-';
			$row[] = isset($rows->nama_member) ? $rows->nama_member : '-';	
			$row[] = isset($rows->prodi) ? $rows->prodi : '-';
			$btn = "
			<button type='button' class='btn btn-warning ganti' id='".$rows->member_id."'>Ubah</button>
			<button type='button' class='btn btn-danger hapus' id='".$rows->member_id."'>Hapus</button>
			";
			$row[] = $btn;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Member_model->count_all(),
						"recordsFiltered" => $this->Member_model->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	function modal_import() {
		$this->load->view('member/modal_import/import');
	}

	function import_member() {
		$json['status'] = 'gagal';
		$json['alert'] 	= 'Gagal';
		$this->session->set_userdata('data_xx',null);
		$file = $_FILES['import'];
		$filex = $_FILES['import']['name'];
		$path = "uploads/xls/";
		if(!is_dir($path)){
			mkdir($path,0777,TRUE);
			fopen($path."/index.php", "w");
		}
		if(!$filex){
			$json['alert']	= "File XLS harus dipilih";
			echo json_encode($json);
			exit;
		}
		$this->load->model(array('Import_model'));
		$this->load->library(array('PHPExcel','convertion'));
		$filename	=	"import_member_".date('Ymdhis').".xls";
		$config['file_name']		= $filename;
		$config['upload_path']      = "uploads/xls/";
        $config['allowed_types']    = array('xls','xlsx');
		$config['max_size']         = 3000;
		$this->load->library('upload', $config);		
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload('import')){
			$msg = $this->upload->display_errors();	
			$json['alert'] = $msg;
			echo json_encode($json);
			exit;			
		}
		else{
			$data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
            //$filename = $upload_data['file_name'];
            $kampret = $this->Import_model->import_pengarang($filename);
		//	echo $this->db->last_query();
          //  print_r($kampret);exit;
			$json['status'] = $kampret['status'];
            $json['alert'] = $kampret['pesan'];
            $json['link'] = site_url('member');
			unlink('uploads/xls/'.$filename);
			//$json['alert'] = $msg;
			echo json_encode($json);
			exit;
			exit;
		}
	}
}

?>
