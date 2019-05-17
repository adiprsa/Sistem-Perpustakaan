<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bahasa extends MY_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('User_model','Db_model');
		if(!$this->session->userdata('username')){
			redirect('login/logout');
		}
    }
	
	function index(){
		$data['title'] = 'Pengaturan Bahasa';
		$this->load->view('templates/header', $data);
		$this->load->view('pengaturan/main_bahasa',$data);
		$this->load->view('templates/footer');
	}
	
	
	function modal_form_bahasa($hash='0'){
		$q = $this->Db_model->get('bahasa','*',array('sha1(bahasa_id)' => $hash));
		$data['title']	= "bahasa";
		$data['datanya'] = $q;
		$data['ref'] = $hash;
		$this->load->view('pengaturan/modal_bahasa',$data);
	}
	
	function simpan_bahasa(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('pengaturan/bahasa');
		$ref			= $this->input->post('ref');
		
		if(!$this->input->post('nama_bahasa')){
			$json['alert']	= "Nama bahasa harus diisi";
			echo json_encode($json);exit;
		}
		$data['nama_bahasa'] = $this->input->post('nama_bahasa',true);
		
		if($ref=='0'){
			if($this->Db_model->add('bahasa',$data)){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}else{
			if($this->Db_model->update('bahasa',$data,array('md5(bahasa_id)' => $ref))){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
			
		}
	}
	
	function bahasa_list(){
		$this->load->model('Bahasa_model');
		$list = $this->Bahasa_model->get_datatables();
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();

			$row[] = isset($rows->nama_bahasa) ? $rows->nama_bahasa : '-';
			$btn = "
			<button type='button' class='btn btn-warning ganti' id='".sha1($rows->bahasa_id)."'>Ubah</button>
			<button type='button' class='btn btn-danger hapus' id='".sha1($rows->bahasa_id)."'>Hapus</button>
			";
			$row[] = $btn;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Bahasa_model->count_all(),
						"recordsFiltered" => $this->Bahasa_model->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function hapus_bahasa($sha1){
		$this->Db_model->delete('bahasa',array('sha1(bahasa_id)' => $sha1));
		?>
		<script>
		alert('Data bahasa berhasil dihapus');
		window.location.href='<?=site_url('Pengaturan/bahasa')?>';
		</script>
		
		<?php
	}
	
	function modal_import_bahasa($hash='0'){
		$this->load->view('pengaturan/modal_import_bahasa');
	}
	
	function import_bahasa(){
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
		$filename	=	"import_bahasa_".date('Ymdhis').".xls";
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
            $upload_data = $this->upload->data();
            $kampret = $this->Import_model->import_bahasa($filename);
			$json['status'] = $kampret['status'];
            $json['alert'] = $kampret['pesan'];
            $json['link'] = site_url('pengaturan/bahasa');
			unlink('uploads/xls/'.$filename);
			echo json_encode($json);
			exit;
		}
	}
}

?>
