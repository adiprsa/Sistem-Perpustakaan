<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lokasi extends MY_Controller {
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
		$data['title'] = 'Pengaturan lokasi';
		$this->load->view('templates/header', $data);
		$this->load->view('pengaturan/main_lokasi',$data);
		$this->load->view('templates/footer');
	}
	
	function modal_form_lokasi($hash='0'){
		$q = $this->Db_model->get('lokasi','*',array('sha1(lokasi_id)' => $hash));
		$data['title']	= "Tipe lokasi";
		$data['datanya'] = $q;
		$data['ref'] = $hash;
		$this->load->view('pengaturan/modal_lokasi',$data);
	}
	
	function simpan_lokasi(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('Pengaturan/lokasi');
		$ref			= $this->input->post('ref');
		
		if(!$this->input->post('nama_lokasi')){
			$json['alert']	= "Nama lokasi harus diisi";
			echo json_encode($json);exit;
		}
		$data['nama_lokasi'] = $this->input->post('nama_lokasi',true);
		
		if($ref=='0'){
			if($this->Db_model->add('lokasi',$data)){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}else{
			if($this->Db_model->update('lokasi',$data,array('md5(lokasi_id)' => $ref))){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
			
		}
	}
	
	function lokasi_list(){
		$this->load->model('Lokasi_model');
		$list = $this->Lokasi_model->get_datatables();
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();

			$row[] = isset($rows->nama_lokasi) ? $rows->nama_lokasi : '-';
			$btn = "
			<button type='button' class='btn btn-warning ganti' id='".sha1($rows->lokasi_id)."'>Ubah</button>
			<button type='button' class='btn btn-danger hapus' id='".sha1($rows->lokasi_id)."'>Hapus</button>
			";
			$row[] = $btn;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Lokasi_model->count_all(),
						"recordsFiltered" => $this->Lokasi_model->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function hapus_lokasi($sha1){
		$this->Db_model->delete('lokasi',array('sha1(lokasi_id)' => $sha1));
//		exit;
		?>
		<script>
		alert('Data lokasi berhasil dihapus');
		window.location.href='<?=site_url('Pengaturan/lokasi')?>';
		</script>
		
		<?php	
	}
}

?>
