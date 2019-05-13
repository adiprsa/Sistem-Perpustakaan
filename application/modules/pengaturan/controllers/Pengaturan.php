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
		//echo is_integer($tahun);exit;
		if(!is_int($tahun)){
			$tahun = date('Y');
		}
//		echo $tahun;
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
	
	function pengarang(){
		$data['title'] = 'Pengaturan Pengarang';
		//$data['hari_libur']	= $this->Db_model->get('hari_libur','*',array('YEAR(tgl_libur)' => $tahun));
		$this->load->view('templates/header', $data);
		$this->load->view('pengaturan/main_pengarang',$data);
		$this->load->view('templates/footer');
	}
	
	
	function modal_form_pengarang($hash='0'){
		$q = $this->Db_model->get('pengarang','*',array('sha1(pengarang_id)' => $hash));
		$data['title']	= "Pengarang";
		$data['datanya'] = $q;
		$data['tipe_pengarang'] = $this->Db_model->get('tipe_pengarang');
		$data['ref'] = $hash;
		$this->load->view('pengaturan/modal_pengarang',$data);
	}
	
	function simpan_pengarang(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('Pengaturan/pengarang');
		$ref			= $this->input->post('ref');
		$tahun = $this->input->post('tahun_pengarang');
		$data['tahun_pengarang'] = $tahun;
		//$data['tahun_pengarang']	= $this->convertion->normal2mysql($this->input->post('tgl_libur'),true);
		
		if(!$this->input->post('nama_pengarang')){
			$json['alert']	= "Nama pengarang harus diisi";
			echo json_encode($json);exit;
		}
		$data['nama_pengarang'] = $this->input->post('nama_pengarang',true);
		
		
		if(!$this->input->post('tipe_pengarang')){
			$json['alert']	= "Tipe Pengarang harus diisi";
			echo json_encode($json);exit;
		}
		$data['tipe_pengarang'] = $this->input->post('tipe_pengarang',true);
		
		
		if(!$this->input->post('kata_kunci')){
			$json['alert']	= "Kata Kunci harus diisi";
			echo json_encode($json);exit;
		}
		$data['kata_kunci'] = $this->input->post('kata_kunci',true);
		if($ref=='0'){
			if($this->Db_model->add('pengarang',$data)){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}else{
			if($this->Db_model->update('pengarang',$data,array('md5(pengarang_id)' => $ref))){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
			
		}
	}
	
	function pengarang_list(){
		$this->load->model('Pengarang_model');
		$list = $this->Pengarang_model->get_datatables();
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();

			$row[] = isset($rows->nama_pengarang) ? $rows->nama_pengarang : '-';
			$row[] = isset($rows->tahun_pengarang) ? $rows->tahun_pengarang : '-';
			$row[] = isset($rows->tipe) ? $rows->tipe : '-';
			$btn = "
			<button type='button' class='btn btn-info ganti' id='".sha1($rows->pengarang_id)."'>Ubah</button>
			<button type='button' class='btn btn-warning hapus' id='".sha1($rows->pengarang_id)."'>Hapus</button>
			";
			$row[] = $btn;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Pengarang_model->count_all(),
						"recordsFiltered" => $this->Pengarang_model->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	
	}
	
	function hapus_pengarang($sha1){
		$this->Db_model->delete('pengarang',array('sha1(pengarang_id)' => $sha1));
		?>
		<script>
		alert('Data pengarang berhasil dihapus');
		window.location.href='<?=site_url('Pengaturan/pengarang')?>';
		</script>
		
		<?php
	}
	
	function modal_import_pengarang($hash='0'){
		$this->load->view('pengaturan/modal_import_pengarang');
	}
	
	function import_pengarang(){
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
		$filename	=	"import_pengarang_".date('Ymdhis').".xls";
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
            $json['link'] = site_url('Pengaturan/pengarang');
			unlink('uploads/xls/'.$filename);
			//$json['alert'] = $msg;
			echo json_encode($json);
			exit;
			exit;
		}
	}
	
	
	
	function penerbit(){
		$data['title'] = 'Pengaturan Penerbit';
		//$data['hari_libur']	= $this->Db_model->get('hari_libur','*',array('YEAR(tgl_libur)' => $tahun));
		$this->load->view('templates/header', $data);
		$this->load->view('pengaturan/main_penerbit',$data);
		$this->load->view('templates/footer');
	}
	
	
	function modal_form_penerbit($hash='0'){
		$q = $this->Db_model->get('penerbit','*',array('sha1(penerbit_id)' => $hash));
		$data['title']	= "Penerbit";
		$data['datanya'] = $q;
		$data['ref'] = $hash;
		$this->load->view('pengaturan/modal_penerbit',$data);
	}
	
	function simpan_penerbit(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('Pengaturan/penerbit');
		$ref			= $this->input->post('ref');
		
		if(!$this->input->post('nama_penerbit')){
			$json['alert']	= "Nama penerbit harus diisi";
			echo json_encode($json);exit;
		}
		$data['nama_penerbit'] = $this->input->post('nama_penerbit',true);
		
		if($ref=='0'){
			if($this->Db_model->add('penerbit',$data)){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}else{
			if($this->Db_model->update('penerbit',$data,array('md5(penerbit_id)' => $ref))){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
			
		}
	}
	
	function penerbit_list(){
		$this->load->model('Penerbit_model');
		$list = $this->Penerbit_model->get_datatables();
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();

			$row[] = isset($rows->nama_penerbit) ? $rows->nama_penerbit : '-';
			$btn = "
			<button type='button' class='btn btn-info ganti' id='".sha1($rows->penerbit_id)."'>Ubah</button>
			<button type='button' class='btn btn-warning hapus' id='".sha1($rows->penerbit_id)."'>Hapus</button>
			";
			$row[] = $btn;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Penerbit_model->count_all(),
						"recordsFiltered" => $this->Penerbit_model->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function hapus_penerbit($sha1){
		$this->Db_model->delete('penerbit',array('sha1(penerbit_id)' => $sha1));
		?>
		<script>
		alert('Data penerbit berhasil dihapus');
		window.location.href='<?=site_url('Pengaturan/penerbit')?>';
		</script>
		
		<?php
	}
	
	function modal_import_penerbit($hash='0'){
		$this->load->view('pengaturan/modal_import_penerbit');
	}
	
	function import_penerbit(){
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
		$filename	=	"import_penerbit_".date('Ymdhis').".xls";
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
            $kampret = $this->Import_model->import_penerbit($filename);
		//	echo $this->db->last_query();
          //  print_r($kampret);exit;
			$json['status'] = $kampret['status'];
            $json['alert'] = $kampret['pesan'];
            $json['link'] = site_url('Pengaturan/penerbit');
			unlink('uploads/xls/'.$filename);
			//$json['alert'] = $msg;
			echo json_encode($json);
			exit;
		}
	}
	
	
	
	function bahasa(){
		$data['title'] = 'Pengaturan Bahasa';
		//$data['hari_libur']	= $this->Db_model->get('hari_libur','*',array('YEAR(tgl_libur)' => $tahun));
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
		$json['link'] 	= site_url('Pengaturan/bahasa');
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
			<button type='button' class='btn btn-info ganti' id='".sha1($rows->bahasa_id)."'>Ubah</button>
			<button type='button' class='btn btn-warning hapus' id='".sha1($rows->bahasa_id)."'>Hapus</button>
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
            $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
            //$filename = $upload_data['file_name'];
            $kampret = $this->Import_model->import_bahasa($filename);
		//	echo $this->db->last_query();
          //  print_r($kampret);exit;
			$json['status'] = $kampret['status'];
            $json['alert'] = $kampret['pesan'];
            $json['link'] = site_url('Pengaturan/bahasa');
			unlink('uploads/xls/'.$filename);
			//$json['alert'] = $msg;
			echo json_encode($json);
			exit;
		}
	}
	
	//kolasi
	
	
	function kolasi(){
		$data['title'] = 'Pengaturan Kolasi';
		//$data['hari_libur']	= $this->Db_model->get('hari_libur','*',array('YEAR(tgl_libur)' => $tahun));
		$this->load->view('templates/header', $data);
		$this->load->view('pengaturan/main_kolasi',$data);
		$this->load->view('templates/footer');
	}
	
	function modal_form_kolasi($hash='0'){
		$q = $this->Db_model->get('tipe_kolasi','*',array('sha1(tipe_kolasi_id)' => $hash));
		$data['title']	= "Tipe Kolasi";
		$data['datanya'] = $q;
		$data['ref'] = $hash;
		$this->load->view('pengaturan/modal_kolasi',$data);
	}
	
	function simpan_kolasi(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('Pengaturan/kolasi');
		$ref			= $this->input->post('ref');
		
		if(!$this->input->post('nama_tipe_kolasi')){
			$json['alert']	= "Nama tipe kolasi harus diisi";
			echo json_encode($json);exit;
		}
		$data['nama_tipe_kolasi'] = $this->input->post('nama_tipe_kolasi',true);
		
		if($ref=='0'){
			if($this->Db_model->add('tipe_kolasi',$data)){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}else{
			if($this->Db_model->update('tipe_kolasi',$data,array('md5(tipe_kolasi_id)' => $ref))){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
			
		}
	}
	
	function kolasi_list(){
		$this->load->model('Kolasi_model');
		$list = $this->Kolasi_model->get_datatables();
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();

			$row[] = isset($rows->nama_tipe_kolasi) ? $rows->nama_tipe_kolasi : '-';
			$btn = "
			<button type='button' class='btn btn-info ganti' id='".sha1($rows->tipe_kolasi_id)."'>Ubah</button>
			<button type='button' class='btn btn-warning hapus' id='".sha1($rows->tipe_kolasi_id)."'>Hapus</button>
			";
			$row[] = $btn;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Kolasi_model->count_all(),
						"recordsFiltered" => $this->Kolasi_model->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function hapus_kolasi($sha1){
		$this->Db_model->delete('tipe_kolasi',array('sha1(tipe_kolasi_id)' => $sha1));
//		exit;
		?>
		<script>
		alert('Data tipe kolasi berhasil dihapus');
		window.location.href='<?=site_url('Pengaturan/kolasi')?>';
		</script>
		
		<?php	
	}
	
	function aturan_pinjam(){
		$data['title'] = 'Pengaturan Bahasa';
		//$data['hari_libur']	= $this->Db_model->get('hari_libur','*',array('YEAR(tgl_libur)' => $tahun));
		$this->load->view('templates/header', $data);
		$this->load->view('pengaturan/main_bahasa',$data);
		$this->load->view('templates/footer');
	}
	
	
	function modal_form_aturan_pinjam($hash='0'){
		$q = $this->Db_model->get('bahasa','*',array('sha1(bahasa_id)' => $hash));
		$data['title']	= "bahasa";
		$data['datanya'] = $q;
		$data['ref'] = $hash;
		$this->load->view('pengaturan/modal_bahasa',$data);
	}
	
	function simpan_aturan_pinjam(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('Pengaturan/aturan_pinjam');
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
	
	function aturan_pinjam_list(){
		$this->load->model('Aturan_pinjam_model');
		$list = $this->Aturan_pinjam_model->get_datatables();
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();

			$row[] = isset($rows->nama_bahasa) ? $rows->nama_bahasa : '-';
			$btn = "
			<button type='button' class='btn btn-info ganti' id='".sha1($rows->bahasa_id)."'>Ubah</button>
			<button type='button' class='btn btn-warning hapus' id='".sha1($rows->bahasa_id)."'>Hapus</button>
			";
			$row[] = $btn;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Aturan_pinjam_model->count_all(),
						"recordsFiltered" => $this->Aturan_pinjam_model->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function hapus_aturan_pinjam($sha1){
		$this->Db_model->delete('aturan_pinjam',array('sha1(aturan_id)' => $sha1));
		?>
		<script>
		alert('Data bahasa berhasil dihapus');
		window.location.href='<?=site_url('Pengaturan/aturan_pinjam')?>';
		</script>
		
		<?php
	}
	
}

?>
