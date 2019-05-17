<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipe_konten extends MY_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('User_model','Db_model');
		if(!$this->session->userdata('username')){
			redirect('login/logout');
		}
    }
	
	function index(){
		$data['title'] = 'Pengaturan Tipe Konten';
		$this->load->view('templates/header', $data);
		$this->load->view('pengaturan/main_tipe_konten',$data);
		$this->load->view('templates/footer');
	}
	
	function modal_form_tipe_konten($hash='0'){
		$q = $this->Db_model->get('tipe_konten','*',array('sha1(id)' => $hash));
		$data['title']	= "Tipe Konten";
		$data['datanya'] = $q;
		$data['ref'] = $hash;
		$this->load->view('pengaturan/modal_tipe_konten',$data);
	}
	
	function simpan_tipe_konten(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('pengaturan/tipe_konten');
		$ref			= $this->input->post('ref');
		
		if(!$this->input->post('tipe_konten')){
			$json['alert']	= "Nama Tipe Konten harus diisi";
			echo json_encode($json);exit;
		}
		$data['tipe_konten'] = $this->input->post('tipe_konten',true);
		
		if(!$this->input->post('kode')){
			$json['alert']	= "Kode Tipe Konten harus diisi";
			echo json_encode($json);exit;
		}
		$data['kode'] = $this->input->post('kode',true);
		
		
		if($ref=='0'){
			if($this->Db_model->add('tipe_konten',$data)){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}else{
			if($this->Db_model->update('tipe_konten',$data,array('md5(id)' => $ref))){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
			
		}
	}
	
	function tipe_konten_list(){
		$this->load->model('Tipe_konten_model');
		$list = $this->Tipe_konten_model->get_datatables();
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();

			$row[] = isset($rows->tipe_konten) ? $rows->tipe_konten : '-';
			$row[] = isset($rows->kode) ? $rows->kode : '-';
			$btn = "
			<button type='button' class='btn btn-warning ganti' id='".sha1($rows->id)."'>Ubah</button>
			<button type='button' class='btn btn-danger hapus' id='".sha1($rows->id)."'>Hapus</button>
			";
			$row[] = $btn;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Tipe_konten_model->count_all(),
						"recordsFiltered" => $this->Tipe_konten_model->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function hapus_tipe_konten($sha1){
		$this->Db_model->delete('tipe_konten',array('sha1(id)' => $sha1));
//		exit;
		?>
		<script>
		alert('Data Tipe Konten berhasil dihapus');
		window.location.href='<?=site_url('pengaturan/tipe_konten')?>';
		</script>
		
		<?php	
	}
	
}

?>
