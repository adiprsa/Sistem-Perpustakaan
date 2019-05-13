<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_laporan_stok_opname extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model("m_laporan");
    }
	public function index()
	{
		echo "Hellow World!!!";
	}

	public function tampil_laporan_stok_opname(){
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
		$filter = $this->input->post('filter');
		$data['stok_opname'] = $this->m_laporan->laporan_stok_opname($filter,$tgl1,$tgl2);
		$this->load->view('laporan/v_laporan_stok_opname',$data);
		// print_r($data['stok_opname']);
	}

}
