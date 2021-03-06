<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if(($this->session->userdata('username'))){
			redirect('dashboard');
		}
		$this->load->view('login');
	}

	function proses(){
		$json['status']	= 'gagal';
		$json['alert']	= 'gagal';
		$json['link'] = base_url('login/logout');
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		$user = $this->Db_model->get('user','user_id,karyawan_id,email,tipe_user,grup_id,nama_asli,username,password',array('username' => $username, 'password' => $password));
		if($user->num_rows()==1){
			$isi = $user->row();
			$session = array();
			foreach($isi as $aa => $bb){
				$session[$aa] = $bb;
			}
			if(!$this->session->set_userdata($session)){
				$json['link'] = base_url('dashboard');
				$json['status'] = 'berhasil';
				$json['alert'] = 'Selamat Datang '.$username;
				echo json_encode($json);exit;
			}else{
				$json['alert'] = 'Error, create session';
				echo json_encode($json);exit;
			}
		}else{
				$json['alert'] = 'Pengguna tak ditemukan';
				echo json_encode($json);exit;

		}
	}

	function logout(){
		$this->session->sess_destroy();
        redirect(base_url());
	}
}
