<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frekuensi extends MY_Controller {
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
		$data['title'] = 'Frekuensi Terbit';
		$this->load->view('templates/header', $data);
		$this->load->view('pengaturan/main_frekuensi',$data);
		$this->load->view('templates/footer');
	}
	
	
	function modal_form_frekuensi($hash='0'){
		$q = $this->Db_model->get('frekuensi_terbit','*',array('sha1(frekuensi_id)' => $hash));
		$data['title']	= "Frekuensi Terbit";
		$data['datanya'] = $q;
		$data['ref'] = $hash;
		$this->load->view('pengaturan/modal_frekuensi',$data);
	}
	
	function simpan_frekuensi(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('pengaturan/frekuensi');
		$ref			= $this->input->post('ref');
		
		if(!$this->input->post('frekuensi')){
			$json['alert']	= "Frekuensi harus diisi";
			echo json_encode($json);exit;
		}
		$data['frekuensi'] = $this->input->post('frekuensi',true);
		
		if(!$this->input->post('bahasa')){
			$json['alert']	= "Bahasa harus diisi";
			echo json_encode($json);exit;
		}
		$data['bahasa'] = $this->input->post('bahasa',true);
		
		if(!$this->input->post('waktu')){
			$json['alert']	= "Waktu harus diisi";
			echo json_encode($json);exit;
		}
		$data['waktu'] = $this->input->post('waktu',true);
		
		if(!$this->input->post('waktu_unit')){
			$json['alert']	= "Waktu Unit harus diisi";
			echo json_encode($json);exit;
		}
		$data['waktu_unit'] = $this->input->post('waktu_unit',true);
		
		
		if($ref=='0'){
			if($this->Db_model->add('frekuensi_terbit',$data)){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}else{
			if($this->Db_model->update('frekuensi_terbit',$data,array('md5(frekuensi_id)' => $ref))){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
			
		}
	}
	
	function frekuensi_list(){
		$this->load->model('Frekuensi_model');
		$list = $this->Frekuensi_model->get_datatables();
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();

			$row[] = isset($rows->frekuensi) ? $rows->frekuensi : '-';
			$row[] = isset($rows->bahasa) ? $rows->bahasa : '-';
			$row[] = isset($rows->waktu) ? $rows->waktu : '-';
			$row[] = isset($rows->waktu_unit) ? $rows->waktu_unit : '-';
			$btn = "
			<button type='button' class='btn btn-warning ganti' id='".sha1($rows->frekuensi_id)."'>Ubah</button>
			<button type='button' class='btn btn-danger hapus' id='".sha1($rows->frekuensi_id)."'>Hapus</button>
			";
			$row[] = $btn;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Frekuensi_model->count_all(),
						"recordsFiltered" => $this->Frekuensi_model->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function hapus_frekuensi($sha1){
		$this->Db_model->delete('frekuensi_terbit',array('sha1(frekuensi_id)' => $sha1));
		?>
		<script>
		alert('Data frekuensi terbit berhasil dihapus');
		window.location.href='<?=site_url('pengaturan/frekuensi')?>';
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
