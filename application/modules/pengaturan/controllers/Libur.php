<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Libur extends MY_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('User_model','Db_model');
		if(!$this->session->userdata('username')){
			redirect('login/logout');
		}
    }
	
	function index($tahun='-'){
		if(!is_int($tahun)){
			$tahun = date('Y');
		}
		$data['title'] = 'Pengaturan Hari Libur';
		$data['hari_libur']	= $this->Db_model->get('hari_libur','*',array('YEAR(tgl_libur)' => $tahun));
		$this->load->view('templates/header', $data);
		$this->load->view('pengaturan/libur',$data);
		$this->load->view('templates/footer');
	}
	
	function modal_form_libur($hash='0'){
		$q = $this->Db_model->get('hari_libur','*',array('sha1(libur_id)' => $hash));
		$data['user'] = $q;
		$data['ref'] = $hash;
		$this->load->view('pengaturan/modal_libur',$data);
	}
	
	
	function simpan_libur(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('pengaturan/libur');
		$ref			= $this->input->post('ref');
		//print_r($this->input->post());exit;
		$data['tgl_libur']	= $this->convertion->normal2mysql($this->input->post('tgl_libur'),true);
		if(!$this->input->post('hari_libur')){
			$json['alert']	= "Keterangan harus diisi";
			echo json_encode($json);exit;
		}
		$data['hari_libur']	= $this->input->post('hari_libur',true);
		if($ref=='0'){
			if($this->Db_model->add('hari_libur',$data)){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}else{
			if($this->Db_model->update('hari_libur',$data,array('md5(libur_id)' => $ref))){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
			
		}
	}
	
	function hapus_libur($sha1){
		$this->Db_model->delete('hari_libur',array('sha1(libur_id)' => $sha1));
		?>
		<script>
		alert('Hari libur berhasil dihapus');
		window.location.href='<?=site_url('pengaturan/libur')?>';
		</script>
		
		<?php
	}
	
	function modal_import_libur($hash='0'){
		$this->load->view('pengaturan/modal_import_libur');
	}
	
	function import_libur(){
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
		$filename	=	"import_libur_".date('Ymdhis').".xls";
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
            $kampret = $this->Import_model->import_libur($filename);
			$json['status'] = $kampret['status'];
            $json['alert'] = $kampret['pesan'];
            $json['link'] = site_url('pengaturan/libur');
			unlink('uploads/xls/'.$filename);
			echo json_encode($json);
			exit;
		}
	}
	
}

?>
