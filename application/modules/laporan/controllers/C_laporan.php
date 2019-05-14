<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_laporan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model("m_laporan");
    }
	public function index()
	{
		echo "Hellow World!!!";
	}

	public function laporan_anggota(){
		$data['anggota'] = $this->m_laporan->laporan_anggota();
		$this->load->view('v_laporan_anggota',$data);
	}

	public function laporan_buku(){
		$data['buku'] = $this->m_laporan->laporan_buku();
		$this->load->view('v_laporan_buku',$data);
	}

	public function laporan_peminjaman(){
		$data['peminjaman'] = $this->m_laporan->laporan_peminjaman();
		$this->load->view('v_laporan_peminjaman',$data);
	}

	public function test(){
		echo $this->input->post('tgl1'); 
		echo "<br>";
		echo $this->input->post('tgl2'); 
	}
}
