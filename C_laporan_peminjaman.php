<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_laporan_peminjaman extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model("m_laporan");
    }
	public function index()
	{
		echo "Hellow World!!!";
	}

	public function tampil_laporan_peminjaman(){
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
		$filter = $this->input->post('filter');
		$data['peminjaman'] = $this->m_laporan->laporan_peminjaman($filter,$tgl1,$tgl2);
		$this->load->view('laporan/v_laporan_peminjaman',$data);
	}

}
