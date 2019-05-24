<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prodi extends MY_Controller {
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
	
	function index($kd_fakultas='-'){
		if($kd_fakultas!='-'){
			$z = $this->Db_model->get('fakultas','kd_fakultas',array('sha1(kd_fakultas)' => $kd_fakultas));
			if($z->num_rows()<1){
				?>
				<script>
				alert('Fakultas tak ditemukan');
				window.location.href='<?=site_url('pengaturan/prodi/index/')?>';
				</script>
				
				<?php
				exit;
			}
		}
		$data['title'] = 'Pengaturan Prodi';
		$data['kd_fakultas'] = $kd_fakultas;
		$this->load->view('templates/header', $data);
		$this->load->view('pengaturan/main_prodi',$data);
		$this->load->view('templates/footer');
	}
	
	function modal_form_prodi($kd_fakultas='-',$hash='0'){
		$q = $this->Db_model->get('prodi','*',array('sha1(kd_prodi)' => $hash));
		$data['title']	= "Prodi";
		$data['datanya'] = $q;
		$data['form_fakultas'] = $this->Db_model->get('fakultas');
		$data['ref'] = $hash;
		$data['kd_fakultas'] = $kd_fakultas;
		$this->load->view('pengaturan/modal_prodi',$data);
	}
	
	function simpan_prodi(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('pengaturan/prodi/index/').sha1($this->input->post('kd_fakultas'));
		$ref			= $this->input->post('ref');
		if(!$this->input->post('kd_fakultas')){
			$json['alert']	= "Fakultas harus diisi";
			echo json_encode($json);exit;
		}
		$data['id_fakultas'] = $this->input->post('kd_fakultas',true);
	//	print_r($this->input->post());
		$prodi = $this->input->post('kd_prodi');
		$z = $this->Db_model->get('prodi','kd_prodi',array('kd_prodi' => $prodi, 'md5(kd_prodi) <>' => $ref));
//		echo $this->db->last_query();
		if($z->num_rows()>0){
			$json['alert']	= "Kode prodi sudah dipakai";
			echo json_encode($json);exit;
		}
		$data['kd_prodi'] = $this->input->post('kd_prodi',true);
		if(!$this->input->post('prodi')){
			$json['alert']	= "Nama prodi harus diisi";
			echo json_encode($json);exit;
		}
		$data['prodi'] = $this->input->post('prodi',true);
		
		if($ref=='0'){
			if($this->Db_model->add('prodi',$data)){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}else{
			if($this->Db_model->update('prodi',$data,array('md5(kd_prodi)' => $ref))){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
			
		}
	}
	
	function prodi_list($kd_fakultas='-'){
		$this->load->model('Prodi_model');
		$list = $this->Prodi_model->get_datatables($kd_fakultas);
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();

			$row[] = isset($rows->kd_prodi) ? $rows->kd_prodi : '-';
			$row[] = isset($rows->prodi) ? $rows->prodi : '-';
			$row[] = isset($rows->fakultas) ? $rows->fakultas : '-';
			$btn = "
			<button type='button' class='btn btn-warning ganti' id='".sha1($rows->kd_prodi)."'>Ubah</button>
			<button type='button' class='btn btn-danger hapus' id='".sha1($rows->kd_prodi)."'>Hapus</button>
			";
			$row[] = $btn;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Prodi_model->count_all($kd_fakultas),
						"recordsFiltered" => $this->Prodi_model->count_filtered($kd_fakultas),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function hapus_prodi($sha1){
		$z= $this->Db_model->get('prodi','kd_fakultas',array('sha1(kd_prodi)' => $sha1));
		if($z->num_rows()>0){
			$next = sha1($z->row()->kd_fakultas);
		}else{
			$next = '-';			
		}
		$this->Db_model->delete('prodi',array('sha1(kd_prodi)' => $sha1));
//		exit;
		?>
		<script>
		alert('Data prodi berhasil dihapus');
		window.location.href='<?=site_url('pengaturan/prodi/index/').$next?>';
		</script>
		
		<?php	
	}
	
}

?>
