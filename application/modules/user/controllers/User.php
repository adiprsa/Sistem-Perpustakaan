<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('User_model');
		if(!$this->session->userdata('username')){
			redirect('login/logout');
		}
    }

	public function index() {
		$data['title'] = 'Pengguna';
		//Header
		$this->load->view('templates/header', $data);
		// Body
		$this->load->view('user/main',$data);
		// Footer
		$this->load->view('templates/footer');
	}

	function modal_form($hash='0'){
		$q = $this->Db_model->get('user','*',array('sha1(user.user_id)' => $hash),'','','','',
					array(
							array('on' => 'user.karyawan_id=karyawan.karyawan_id', 'table' => 'karyawan')
						));
		$data['userlevel'] = $this->Db_model->get('grup_pengguna');
		$data['user'] = $q;
		$data['ref'] = $hash;
		$this->load->view('user/modal_user',$data);
	}

	function modal_myform(){
		$hash = sha1($this->session->userdata('user_id'));
		$q = $this->Db_model->get('user','*',array('sha1(user_id)' => $hash));
		$data['user'] = $q;
		$data['ref'] = $hash;
		$this->load->view('user/modal_myuser',$data);
	}

	function simpan_myuser(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('Login/logout');
		$ref			= $this->session->userdata('user_id');
		$q = $this->Db_model->get('user','*',array('(user_id)' => $ref))->row();
		//print_r($q->password);
		$password = ((md5($this->input->post('password0'))));
		//echo $password;exit;
		if($password!=$q->password){
			$json['status'] = 'berhasil';
			$json['alert'] 	= 'Password salah, silahkan login ulang.';
			echo json_encode($json);
			exit;
		}
		$data = array();
		if($this->input->post('password1')){
			if(strlen($this->input->post('password1')) < 6){
				$json['alert'] 	= 'Panjang password baru minimal 6 karakter';
				echo json_encode($json);
				exit;
			}
			if($this->input->post('password2') !=  $this->input->post('password1')){
				$json['alert'] 	= 'Kombinasi password baru tidak sama';
				echo json_encode($json);
				exit;
			}
			$data['password'] = ((md5($this->input->post('password1'))));
		}

		if($this->input->post('username')){
			$z = $this->Db_model->get('user','user_id',array('(user_id) <>' => $ref, 'username' => $this->input->post('username')));
			if($z->num_rows()>0){
				$json['alert'] 	= 'Username sudah dipakai';
				echo json_encode($json);
				exit;
			}
			$data['username'] = $this->input->post('username');
		}else{
			$json['alert'] 	= 'Username harus diisi';
			echo json_encode($json);
			exit;
		}

		if(!$this->input->post('name')){
			$json['alert'] 	= 'Nama asli harus diisi';
			echo json_encode($json);
			exit;
		}
		$data['nama_asli'] = $this->input->post('name');

		if(!$this->input->post('email')){
			$json['alert'] 	= 'Email harus diisi';
			echo json_encode($json);
			exit;
		}
		$z = $this->Db_model->get('user','user_id',array('(user_id) <>' => $ref, 'email' => $this->input->post('email')));
		if($z->num_rows()>0){
			$json['alert'] 	= 'Email sudah dipakai';
			echo json_encode($json);
			exit;
		}
		$data['email'] = $this->input->post('email');
			if($this->Db_model->update('user',$data,array('(user_id)' => $ref))){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan, silahkan login ulang";
				echo json_encode($json);
				exit;
			}


	}
	function simpan_user(){
//		print_r($this->input->post());exit;
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('user');
		$ref			= $this->input->post('ref');
		$q = $this->Db_model->get('user','*',array('md5(user_id)' => $ref))->row();
		$password = sha1(sha1(md5($this->input->post('password'))));
		$data = array();
		$data['tipe_user'] = $this->input->post('userlevel');
		if($ref=='0'){
			if(!$this->input->post('password1')){
				$json['alert'] 	= 'Password harus diisi';
				echo json_encode($json);
				exit;
			}
		}
		if($this->input->post('password1')){
			if(strlen($this->input->post('password1')) < 6){
				$json['alert'] 	= 'Panjang password baru minimal 6 karakter';
				echo json_encode($json);
				exit;
			}
			if($this->input->post('password2') !=  $this->input->post('password1')){
				$json['alert'] 	= 'Kombinasi password baru tidak sama';
				echo json_encode($json);
				exit;
			}
			$data['password'] = ((md5($this->input->post('password1'))));
		}

		if($this->input->post('username')){
			$z = $this->Db_model->get('user','user_id',array('md5(user_id) <>' => $ref, 'username' => $this->input->post('username')));
			if($z->num_rows()>0){
				$json['alert'] 	= 'Username sudah dipakai';
				echo json_encode($json);
				exit;
			}
			$data['username'] = $this->input->post('username');
		}else{
			$json['alert'] 	= 'Username harus diisi';
			echo json_encode($json);
			exit;
		}
		
		$data['grup_id']	= $this->input->post('userlevel');

		if(!$this->input->post('name')){
			$json['alert'] 	= 'Nama asli harus diisi';
			echo json_encode($json);
			exit;
		}
		$data['nama_asli'] = $this->input->post('name');
		$datax['nama'] = $this->input->post('name');
		
		if(!$this->input->post('no_identitas')){
			$json['alert'] 	= 'No Identitas harus diisi';
			echo json_encode($json);
			exit;
		}
		$datax['no_identitas'] = $this->input->post('no_identitas');
		$datax['jenis_kelamin'] = $this->input->post('jenis_kelamin');
		$datax['alamat'] = $this->input->post('alamat');
		if(!$this->input->post('jabatan')){
			$json['alert'] 	= 'Jabatan harus diisi';
			echo json_encode($json);
			exit;
		}
		$datax['jabatan'] = $this->input->post('jabatan');
		
		if(!$this->input->post('email')){
			$json['alert'] 	= 'Email harus diisi';
			echo json_encode($json);
			exit;
		}
		$z = $this->Db_model->get('user','user_id',array('md5(user_id) <>' => $ref, 'email' => $this->input->post('email')));
		if($z->num_rows()>0){
			$json['alert'] 	= 'Email sudah dipakai';
			echo json_encode($json);
			exit;
		}
		$data['email'] = $this->input->post('email');
		if($ref=='0'){
			if($this->Db_model->add('user',$data)){
				$this->Db_model->add('karyawan',$datax);
				$max_id = $this->Db_model->get('karyawan','MAX(karyawan_id) as id_max')->row()->id_max;
				$this->Db_model->update('user',array('karyawan_id' => $max_id), array('email' => $this->input->post('email')));
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}else{
			if($this->Db_model->update('user',$data,array('md5(user_id)' => $ref))){
				$this->Db_model->update('karyawan',$datax,array('karyawan_id' => $q->karyawan_id));
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}

		}
	}

	function hapus($sha1){
		$this->Db_model->delete('user',array('sha1(user_id)' => $sha1));
		?>
		<script>
		alert('Pengguna berhasil dihapus');
		window.location.href='<?=site_url('user')?>';
		</script>

		<?php
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

			$row[] = isset($rows->username) ? $rows->username : '-';
			$row[] = isset($rows->email) ? $rows->email : '-';
			$row[] = isset($rows->nama_asli) ? $rows->nama_asli : '-';
			$btn = "
			<button type='button' class='btn btn-info ganti' id='".sha1($rows->user_id)."'>Ubah</button>
			<button type='button' class='btn btn-warning hapus' id='".sha1($rows->user_id)."'>Hapus</button>
			";
			$row[] = $btn;
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
	
	
	function log_usernya(){
		$data['title'] = 'Log Pengguna';
		$this->load->view('templates/header', $data);
		$this->load->view('user/log_usernya',$data);
		$this->load->view('templates/footer');
	}
	
	function log_list(){
		$this->load->model('Log_model');
		$list = $this->Log_model->get_datatables();
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();

			$row[] = isset($rows->username) ? $rows->username : '-';
			$row[] = isset($rows->aktifitas) ? $rows->aktifitas : '-';
			$row[] = isset($rows->waktu) ? $rows->waktu : '-';
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Log_model->count_all(),
						"recordsFiltered" => $this->Log_model->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
}

?>
