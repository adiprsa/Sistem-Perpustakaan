<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengaturan extends MY_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('User_model');
		if(!$this->session->userdata('username')){
			redirect('login/logout');
		}
    }
	
	public function index() {
		$data['title'] = 'Pengaturan';
		//Header
		$this->load->view('templates/header', $data);
		// Body
		$this->load->view('user/main',$data);
		// Footer
		$this->load->view('templates/footer');
	}
	
	function libur($tahun='-'){
		if($tahun=='-' OR !int($tahun)){
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
		$json['link'] 	= site_url('Pengaturan/libur');
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
            $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
            //$filename = $upload_data['file_name'];
            $kampret = $this->Import_model->import_libur($filename);
		//	echo $this->db->last_query();
          //  print_r($kampret);exit;
			$json['status'] = $kampret['status'];
            $json['alert'] = $kampret['pesan'];
            $json['link'] = site_url('Pengaturan/libur');
			unlink('uploads/xls/'.$filename);
			//$json['alert'] = $msg;
			echo json_encode($json);
			exit;
			exit;
		}
	}
	

	function hapus($sha1){
		$this->Db_model->delete('user',array('sha1(user_id)' => $sha1));
		?>
		<script>
		alert('Pengguna berhasil dihapus');
		window.location.href='<?=site_url('user')?>';
		</script>
		
		<?php
	}
	
	function ajax_list(){
		$this->load->model('User_model');
		$list = $this->User_model->get_datatables();
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();
				
			$row[] = isset($rows->username) ? $rows->username : '-';
			$row[] = isset($rows->email) ? $rows->email : '-';
			$row[] = isset($rows->nama_asli) ? $rows->nama_asli : '-';
			$btn = "
			<button type='button' class='btn btn-info ganti' id='".sha1($rows->user_id)."'>Ubah</button>
			<button type='button' class='btn btn-warning hapus' id='".sha1($rows->user_id)."'>Hapus</button>
			";
			$row[] = $btn;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->User_model->count_all(),
						"recordsFiltered" => $this->User_model->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

}

?>
