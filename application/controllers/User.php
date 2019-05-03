<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('User_model');
		if(!$this->session->userdata('userlevel')){
			redirect();
		}
    }
	
	public function index() {
		$data['judul']	= 'Pengguna';

		$this->load->view('layout/header', $data);
		$this->load->view('user/main');
		$this->load->view('layout/footer');
	}
	
	function ajax_list(){
		$this->load->model('User_model');
		$list = $this->User_model->get_datatables();
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();
				
			$row[] = $no;
			$row[] = isset($rows->username) ? $rows->username : '-';
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->User_model->count_all(),
						"recordsFiltered" => $this->User_model->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

}

?>
