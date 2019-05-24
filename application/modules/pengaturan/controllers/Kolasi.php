<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kolasi extends MY_Controller {
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
		$json['link'] 	= site_url('pengaturan/kolasi');
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
			<button type='button' class='btn btn-warning ganti' id='".sha1($rows->tipe_kolasi_id)."'>Ubah</button>
			<button type='button' class='btn btn-danger hapus' id='".sha1($rows->tipe_kolasi_id)."'>Hapus</button>
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
		window.location.href='<?=site_url('pengaturan/kolasi')?>';
		</script>
		
		<?php	
	}
}

?>
