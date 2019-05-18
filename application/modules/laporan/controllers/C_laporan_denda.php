<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_laporan_denda extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model("m_laporan");
    }
	public function index()
	{
		echo "Hellow World!!!";
	}

	public function tampil_laporan_denda(){
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
		$data['denda'] = $this->m_laporan->laporan_denda('tgl_kembali',$tgl1,$tgl2);
		//Header
		$this->load->view('templates/header','');
		// Body
		$this->load->view('laporan/laporan/v_laporan_denda',$data);
		// Footer
		$this->load->view('templates/footer');
	}

}
