<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fakultas extends MY_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('User_model','Db_model');
		if(!$this->session->userdata('username')){
			redirect('login/logout');
		}
    }
	
	function index(){
		$data['title'] = 'Pengaturan Fakultas';
		$this->load->view('templates/header', $data);
		$this->load->view('pengaturan/main_fakultas',$data);
		$this->load->view('templates/footer');
	}
	
	function modal_form_fakultas($hash='0'){
		$q = $this->Db_model->get('fakultas','*',array('sha1(kd_fakultas)' => $hash));
		$data['title']	= "Fakultas";
		$data['datanya'] = $q;
		$data['ref'] = $hash;
		$this->load->view('pengaturan/modal_fakultas',$data);
	}
	
	function simpan_fakultas(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('pengaturan/fakultas');
		$ref			= $this->input->post('ref');	
		
		if(!$this->input->post('kd_fakultas')){
			$json['alert']	= "Kode fakultas harus diisi";
			echo json_encode($json);exit;
		}
		$kd_fakultas = $this->input->post('kd_fakultas',true);
		$z = $this->Db_model->get('fakultas','kd_fakultas',array('kd_fakultas' => $kd_fakultas, 'md5(kd_fakultas) <>' => $ref));
		if($z->num_rows()>0){
			$json['alert']	= "Kode fakultas sudah dipakai";
			echo json_encode($json);exit;
		}
		$data['kd_fakultas'] = $this->input->post('kd_fakultas',true);
		
		if(!$this->input->post('fakultas')){
			$json['alert']	= "Nama fakultas harus diisi";
			echo json_encode($json);exit;
		}
		$data['fakultas'] = $this->input->post('fakultas',true);
		
		if($ref=='0'){
			if($this->Db_model->add('fakultas',$data)){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}else{
			if($this->Db_model->update('fakultas',$data,array('md5(kd_fakultas)' => $ref))){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
			
		}
	}
	
	function fakultas_list(){
		$this->load->model('Fakultas_model');
		$list = $this->Fakultas_model->get_datatables();
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();

			$row[] = isset($rows->kd_fakultas) ? $rows->kd_fakultas : '-';
			$row[] = isset($rows->fakultas) ? $rows->fakultas : '-';
			$btn = "
			<button type='button' class='btn btn-success prodi' id='".sha1($rows->kd_fakultas)."'>Pengaturan Prodi</button>
			<button type='button' class='btn btn-warning ganti' id='".sha1($rows->kd_fakultas)."'>Ubah</button>
			<button type='button' class='btn btn-danger hapus' id='".sha1($rows->kd_fakultas)."'>Hapus</button>
			";
			$row[] = $btn;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Fakultas_model->count_all(),
						"recordsFiltered" => $this->Fakultas_model->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function hapus_fakultas($sha1){
		$this->Db_model->delete('fakultas',array('sha1(kd_fakultas)' => $sha1));
//		exit;
		?>
		<script>
		alert('Data fakultas berhasil dihapus');
		window.location.href='<?=site_url('pengaturan/fakultas')?>';
		</script>
		
		<?php	
	}
	
}

?>
