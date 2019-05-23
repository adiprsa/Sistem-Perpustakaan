<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengarang extends MY_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('User_model','Db_model');
		if(!$this->session->userdata('username')){
			redirect('login/logout');
		}
		if($this->session->userdata('tipe_user')!='1'){
			redirect('');
		}
    }
	
	function index(){
		$data['title'] = 'Pengaturan Pengarang';
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
		$json['link'] 	= site_url('pengaturan/pengarang');
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
			<button type='button' class='btn btn-warning ganti' id='".sha1($rows->pengarang_id)."'>Ubah</button>
			<button type='button' class='btn btn-danger hapus' id='".sha1($rows->pengarang_id)."'>Hapus</button>
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
		window.location.href='<?=site_url('pengaturan/pengarang')?>';
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
            $json['link'] = site_url('pengaturan/pengarang');
			unlink('uploads/xls/'.$filename);
			//$json['alert'] = $msg;
			echo json_encode($json);
			exit;
			exit;
		}
	}
	
}

?>
