<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_laporan_buku extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model("m_laporan");
    }
	public function index()
	{
		echo "Hellow World!!!";
	}

	public function tampil_laporan_buku(){
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
		$data['buku'] = $this->m_laporan->laporan_buku($tgl1,$tgl2);
		$this->load->view('laporan/v_laporan_buku',$data);
	}
}
