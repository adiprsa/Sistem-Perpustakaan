<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends MY_Controller {
	
	public function __construct() {
			parent::__construct();
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
		$data['input_date'] = date("Y-m-d H:i:s");
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
		$this->Db_model->delete('member',array('member_id' => $sha1));
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
		date_default_timezone_set("Asia/Bangkok"); //set timezone

		$json['status'] = 'gagal';
		$json['status'] = 'Gagal';
		$config['upload_path']          = './uploads/xls/';
		$config['allowed_types']        = 'xls|xlsx';
		$config['max_size']             = 10000;
		$filename						= 'import_member_'.date('j-m-y_G:i:s').'.xls';
		$config['file_name']			= $filename;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('import'))
		{
			$error = array('error' => $this->upload->display_errors());
			$json['alert'] = $error;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$import = $this->import_ke_db($filename);
			$json['status'] = $import['status'];
			$json['alert'] = $import['pesan'];		
		}
		echo json_encode($json); exit();
	}

	function import_ke_db($filename) {
		$this->load->model('member/Member_model','Member_model');
		$file = 'uploads/xls/' . $filename;
		require 'vendor/autoload.php';
		
		$status = 'gagal';
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$worksheet = $spreadsheet->getActiveSheet()->toArray(null,true,true,true);
		$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
		if(
			$worksheet[1]["A"] != "No" ||
			$worksheet[1]["B"] != "Nomor induk member" ||
			$worksheet[1]["C"] != "Tipe member" ||
			$worksheet[1]["D"] != "Nama member" ||
			$worksheet[1]["E"] != "Jenis kelamin" ||
			$worksheet[1]["F"] != "Tanggal lahir" ||
			$worksheet[1]["G"] != "Alamat" ||
			$worksheet[1]["H"] != "E-mail" ||
			$worksheet[1]["I"] != "Jurusan" ||
			$worksheet[1]["J"] != "Tanggal register"
		) {
			$msg = "Format salah";
		} else {
			for($loop=2;$loop<=$highestRow;$loop++) {
				
				//Cek nomor member
				$inputMemberCode = $worksheet[$loop]["B"]; 
				if(trim($inputMemberCode) == '') { //menghilangkan spasi pada input
					$msg = 'Nomor induk member harus diisi';
				} else {
					$query_cek_nomor_member = $this->Member_model->cek_nomor_member($inputMemberCode);
					if($query_cek_nomor_member) {
						$msg = 'Nomor induk member sudah ada'; break;
					} else {
						$data["member_code"] = $inputMemberCode;
					}
				}

				//Cek tipe member
				$inputTipeMember = $worksheet[$loop]["C"];
				if(trim($inputTipeMember) == '') { //menghilangkan spasi pada input
					$msg = 'Tipe member harus diisi';break;
				} else {
					$query_cek_tipe_member = $this->Member_model->cek_tipe_member($inputTipeMember);
					if($query_cek_tipe_member) {
						$data["tipe_member_id"] = $this->Member_model->kode_tipe_member($inputTipeMember);
					} else {
						$msg = 'Tipe member '.$inputTipeMember.' belum ada'; break;
					}
				}

				$inputNamaMember = $worksheet[$loop]["D"];
				if(trim($inputNamaMember) == '') { //cek input alamat kosong
					$msg = 'Nama member harus diisi';
				} else {
					$data["nama_member"] = $inputNamaMember;
				} 
				
				//Cek input jenis kelamin
				$inputJenisKelamin = $worksheet[$loop]["E"];
				if($inputJenisKelamin == 'L' || $inputJenisKelamin == 'P') { //menghilangkan spasi pada input
					$data["jenis_kelamin"] = $inputJenisKelamin;
				} else {
					$msg = 'Jenis kelamin harus diisi dengan L/P'; break;
				}

				//Cek tanggal lahir
				$inputTanggalLahir = $worksheet[$loop]["F"];
				if(trim($inputTanggalLahir) == '') { //menghilangkan spasi pada input
					$msg = 'Tanggal lahir tidak boleh kosong'; break;
				} else {
					if(strlen($inputTanggalLahir) == 8 || strlen($inputTanggalLahir) == 9 || strlen($inputTanggalLahir) == 10) {
						list($day, $month, $year) = explode("/",$inputTanggalLahir);
						if(checkdate($month,$day,$year)) {
							$data["tgl_lahir"] = $year . '-' . $month . '-' . $day;
						} else {
							$msg = 'Format tanggal salah'; break;
						}
					} else { $msg = 'Panjang tanggal lahir tidak sesuai';}
				}

				$inputAlamat = $worksheet[$loop]["G"];
				if(trim($inputAlamat) == '') { //cek input alamat kosong
					$msg = 'Alamat harus diisi';
				} else {
					$data["alamat"] = $inputAlamat;
				} 

				$inputEmail = $worksheet[$loop]["H"];
				if(trim($inputAlamat) == '') { //cek input email kosong
					$msg = 'Email harus diisi';
				} else {
					$data["email"] = $inputEmail;
				} 

				$inputJurusan = $worksheet[$loop]["I"];
				if(trim($inputJurusan) == '') { //menghilangkan spasi pada input
					$msg = 'Jurusan harus diisi';break;
				} else {
					$query_cek_tipe_prodi = $this->Member_model->cek_prodi($inputJurusan);
					if($query_cek_tipe_member) {
						$data["prodi_id"] = $this->Member_model->kode_prodi($inputJurusan);
					} else {
						$msg = 'Prodi '.$inputJurusan.' belum ada'; break;
					}
				}
				
				//Cek tanggal register
				$inputTanggalRegister = $worksheet[$loop]["J"];
				if(trim($inputTanggalRegister) == '') { //menghilangkan spasi pada input
					$msg = 'Tanggal register tidak boleh kosong'; break;
				} else {
					if(strlen($inputTanggalRegister) == 8 || strlen($inputTanggalRegister) == 9 || strlen($inputTanggalRegister) == 10) {
						list($day, $month, $year) = explode("/",$inputTanggalRegister);
						if(checkdate($month,$day,$year)) {
							$data["tgl_register"] = $year . '-' . $month . '-' . $day;
						} else {
							$msg = 'Format tanggal salah'; break;
						}
					} else { $msg = 'Panjang tanggal register tidak sesuai';}
				}

				//Insert member
				$data['last_update'] = date("Y-m-d H:i:s");
				$data['input_date'] = date("Y-m-d H:i:s");
				$this->Db_model->add('member',$data);
				$msg = 'Data berhasil diimport';
				$status = 'berhasil';
			}
		}
		$array = array('status' => $status, 'pesan' => $msg);
		if($status == 'gagal') {
			unlink($file); //hapus jika gagal
		} 
		return $array;
	}
}

?>
