<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipe_member extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('member/tipe_member_model','tipe_member_model');
		$this->load->library('convertion');
		if(!$this->session->userdata('username')){
			redirect('login/logout');
		}
	}

	public function index() {
		$data['title'] = 'Tipe Member';
		$data['data'] = $this->tipe_member_model->get_tipe_member();
		//Header
		$this->load->view('templates/header', $data);
		// Body
		$this->load->view('member/tipe_member/tipe_member_main',$data);
		//JS
		$this->load->view('member/tipe_member/tipe_member_mainjs');
		// Footer
		$this->load->view('templates/footer');
	}

	function modal_form($hash = '0'){
		$query = $this->Db_model->get('tipe_member','*',array('sha1(tipe_member_id)' => $hash));
		$data['data'] = $query;
		$this->load->view('member/tipe_member/modal/modal_tipe_member_main', $data);
		$this->load->view('member/tipe_member/modal/modal_tipe_member_mainjs');
	}

	function simpan_tipe_member() {
		$nama_tipe_member = $this->input->post('nama_tipe_member');
		$limit_pinjam = $this->input->post('limit_pinjam');
		$lama_pinjam = $this->input->post('lama_pinjam');
		$masa_tenggang = $this->input->post('masa_tenggang');
		$denda_perhari = $this->input->post('denda_perhari');
		$result['status'] = 'gagal';
		$data = array();
		$ref = $this->input->post('ref');

		if($ref == '0') {
			if($nama_tipe_member) {
				$cek_nama_tipe_member = $this->Db_model->get(
					'tipe_member','nama_tipe_member',array('nama_tipe_member' => $nama_tipe_member));
				if($cek_nama_tipe_member->num_rows()>0){
					$result['alert'] 	= 'Nama tipe member sudah dipakai';
					echo json_encode($result); exit();
				} else {
					$data['nama_tipe_member'] = $nama_tipe_member;
				}
			} else {
				$result['alert'] = 'Nama tipe member harus diisi';
				echo json_encode($result); exit();
			}
		}
		 
		$data['limit_pinjam'] = $limit_pinjam;
		$data['lama_pinjam'] = $lama_pinjam;
		$data['boleh_reservasi'] = $this->input->post('boleh_reservasi');
		$data['bisa_tiap_hari'] = $this->input->post('bisa_tiap_hari');
		$data['masa_tenggang'] = $masa_tenggang;
		$data['denda_perhari'] = $denda_perhari;
		$data['last_update'] = date("Y-m-d H:i:s");
		$result['status'] = 'berhasil';
		
		if($ref == '0') {
			$data['input_date'] = date("Y-m-d H:i:s");
			$this->Db_model->add('tipe_member',$data);
			$result['alert']  = "Data berhasil disimpan";
		} else {
			$this->Db_model->update('tipe_member',$data,array('md5(tipe_member_id)' => $ref));
			$result['alert']  = "Data berhasil diupdate";
		}
		echo json_encode($result);
	}

	function hapus($sha1){
		$this->Db_model->delete('tipe_member',array('sha1(tipe_member_id)' => $sha1));
	}

}

?>
