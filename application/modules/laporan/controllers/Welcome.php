<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model("m_data");
    }
	public function index()
	{
		$data['user'] = $this->m_data->getAll();
		$this->load->view('welcome_message',$data);
	}

	public function join(){
		$data['pj'] = $this->m_data->getjoin();
		// $this->load->view('welcome_message',$data);
		var_dump($data);
	}
}
