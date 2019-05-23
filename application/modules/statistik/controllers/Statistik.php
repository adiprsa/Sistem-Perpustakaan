<?php defined('BASEPATH') OR exit('No direct script access allowed');

class statistik extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('statistik/m_statistik');
	}

	// public function tampil_statistik_pengunjung() {
	// 	$tgl1 = $this->input->post('tgl1');
	// 	$tgl2 = $this->input->post('tgl2');
	// 	$data['pengunjung'] = $this->m_statistik->statistik_pengunjung($month, $year);
	// 	//Header
	// 	$this->load->view('templates/header','');
	// 	// Body
	// 	$this->load->view('statistik/st_pengunjung_view', $data);
	// 	// Footer
	// 	$this->load->view('templates/footer');
	// }

	public function tampil_statistik_member() {
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$type = $this->input->post('type');
		$data['member'] = $this->m_statistik->statistik_member($month, $year, $type);
		//Header
		$this->load->view('templates/header','');
		// Body
		$this->load->view('statistik/st_member_view', $data);
		// Footer
		$this->load->view('templates/footer');
	}

	public function tampil_statistik_buku() {
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$data['buku'] = $this->m_statistik->statistik_buku($month, $year);
		$data['tgl'] = $this->input->post('month');
		//Header
		$this->load->view('templates/header','');
		// Body
		$this->load->view('statistik/st_buku_view', $data);
		// Footer
		$this->load->view('templates/footer');
	}

	public function tampil_statistik_peminjaman() {
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$data['peminjaman'] = $this->m_statistik->statistik_peminjaman($month, $year);
		//Header
		$this->load->view('templates/header','');
		// Body
		$this->load->view('statistik/st_peminjaman_view', $data);
		// Footer
		$this->load->view('templates/footer');
	}

	public function tampil_statistik_pembayaran_denda() {
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$data['bayar_denda'] = $this->m_statistik->statistik_pembayaran_denda($month, $year);
		//Header
		$this->load->view('templates/header','');
		// Body
		$this->load->view('statistik/st_pembayaran_denda_view', $data);
		// Footer
		$this->load->view('templates/footer');
	}

	public function tampil_statistik_stok_opname() {
		$date = $this->input->post('date');
		$data['stok_opname'] = $this->m_statistik->statistik_stok_opname($date);
		//Header
		$this->load->view('templates/header','');
		// Body
		$this->load->view('statistik/st_stok_opname_view', $data);
		// Footer
		$this->load->view('templates/footer');
	}

}