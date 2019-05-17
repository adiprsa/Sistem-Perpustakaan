<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aturan_pinjam extends MY_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('User_model','Db_model');
		if(!$this->session->userdata('username')){
			redirect('login/logout');
		}
    }
	
	function index(){
		$data['title'] = 'Pengaturan Peminjaman';
		$this->load->view('templates/header', $data);
		$this->load->view('pengaturan/main_aturan',$data);
		$this->load->view('templates/footer');
	}
	
	function simpan_aturan(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('pengaturan/aturan_pinjam');
		$ref			= $this->input->post('ref');
//		print_r($this->input->post());exit;
		
		if(!$this->input->post('tipe_member_id')){
			$json['alert']  = "Tipe Member harus diisi";
			echo json_encode($json);
			exit;
		}
		$data['tipe_member_id'] = $this->input->post('tipe_member_id');
		
		if(!$this->input->post('tipe_kolasi_id')){
			$json['alert']  = "Tipe Kolasi harus diisi";
			echo json_encode($json);
			exit;
		}
		$data['tipe_kolasi_id'] = $this->input->post('tipe_kolasi_id');
		
		if($this->input->post('limit_pinjam')<1){
			$json['alert']  = "Limit peminjaman harus diisi";
			echo json_encode($json);
			exit;
		}
		$data['limit_pinjam'] = $this->input->post('limit_pinjam');
		
		if($this->input->post('periode_pinjam')<1){
			$json['alert']  = "Periode peminjaman harus diisi";
			echo json_encode($json);
			exit;
		}
		$data['periode_pinjam'] = $this->input->post('periode_pinjam');
		
		if($this->input->post('limit_pinjam_ulang')<1){
			$json['alert']  = "Limit peminjaman ulang harus diisi";
			echo json_encode($json);
			exit;
		}
		$data['limit_pinjam_ulang'] = $this->input->post('limit_pinjam_ulang');
		
		if($this->input->post('bisa_tiap_hari')==""){
			$json['alert']  = "Kondisi peminjaman tiap hari harus diisi";
			echo json_encode($json);
			exit;
		}
		$data['bisa_tiap_hari'] = $this->input->post('bisa_tiap_hari');
		
		if($this->input->post('masa_tenggang')<1){
			$json['alert']  = "Masa tenggang harus diisi";
			echo json_encode($json);
			exit;
		}
		$data['masa_tenggang'] = $this->input->post('masa_tenggang');
		
		if($ref=='0'){
			if($this->Db_model->add('aturan_pinjam',$data)){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}else{
			if($this->Db_model->update('aturan_pinjam',$data,array('md5(aturan_id)' => $ref))){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
			
		}
	}
	
	
	function modal_form_aturan_pinjam($hash='0'){
		$q = $this->Db_model->get('aturan_pinjam','*',array('sha1(aturan_id)' => $hash));
		$data['title']	= "Aturan Pinjam";
		$data['datanya'] = $q;
		$data['opsi_tipe_member']	= $this->Db_model->get('tipe_member','tipe_member_id,nama_tipe_member');
		$data['opsi_tipe_kolasi']	= $this->Db_model->get('tipe_kolasi','tipe_kolasi_id,nama_tipe_kolasi');
		$data['ref'] = $hash;
		$this->load->view('pengaturan/modal_aturan',$data);
	}
	
	function simpan_aturan_pinjam(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('pengaturan/aturan_pinjam');
		$ref			= $this->input->post('ref');
		
		if(!$this->input->post('nama_bahasa')){
			$json['alert']	= "Nama bahasa harus diisi";
			echo json_encode($json);exit;
		}
		$data['nama_bahasa'] = $this->input->post('nama_bahasa',true);
		
		
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
			$row[] = isset($rows->nama_tipe_member) ? $rows->nama_tipe_member : '-';
			$row[] = isset($rows->nama_tipe_kolasi) ? $rows->nama_tipe_kolasi : '-';
			$row[] = isset($rows->limit_pinjam) ? $rows->limit_pinjam : '-';
			$row[] = isset($rows->periode_pinjam) ? $rows->periode_pinjam : '-';
			$btn = "
			<button type='button' class='btn btn-warning ganti' id='".sha1($rows->aturan_id)."'>Ubah</button>
			<button type='button' class='btn btn-danger hapus' id='".sha1($rows->aturan_id)."'>Hapus</button>
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
		window.location.href='<?=site_url('pengaturan/aturan_pinjam')?>';
		</script>
		
		<?php
	}
}

?>
