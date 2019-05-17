<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penerbit extends MY_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('User_model','Db_model');
		if(!$this->session->userdata('username')){
			redirect('login/logout');
		}
    }
	
	function index(){
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
		$json['link'] 	= site_url('pengaturan/penerbit');
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
			<button type='button' class='btn btn-warning ganti' id='".sha1($rows->penerbit_id)."'>Ubah</button>
			<button type='button' class='btn btn-danger hapus' id='".sha1($rows->penerbit_id)."'>Hapus</button>
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
		window.location.href='<?=site_url('pengaturan/penerbit')?>';
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
            $json['link'] = site_url('pengaturan/penerbit');
			unlink('uploads/xls/'.$filename);
			//$json['alert'] = $msg;
			echo json_encode($json);
			exit;
		}
	}
}

?>
