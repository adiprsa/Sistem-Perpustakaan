<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends MY_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('User_model','Db_model');
		if(!$this->session->userdata('username')){
			redirect('login/logout');
		}
    }
	
	function index(){
		$data['title'] = 'Pengaturan supplier';
		$this->load->view('templates/header', $data);
		$this->load->view('pengaturan/main_supplier',$data);
		$this->load->view('templates/footer');
	}
	
	function modal_form_supplier($hash='0'){
		$q = $this->Db_model->get('supplier','*',array('sha1(supplier_id)' => $hash));
		$data['title']	= "Supplier";
		$data['datanya'] = $q;
		$data['ref'] = $hash;
		$this->load->view('pengaturan/modal_supplier',$data);
	}
	
	function simpan_supplier(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('pengaturan/supplier');
		$ref			= $this->input->post('ref');
		
		if(!$this->input->post('nama_supplier')){
			$json['alert']	= "Nama supplier harus diisi";
			echo json_encode($json);exit;
		}
		$data['nama_supplier'] = $this->input->post('nama_supplier',true);
		
		if(!$this->input->post('alamat')){
			$json['alert']	= "Alamat supplier harus diisi";
			echo json_encode($json);exit;
		}
		$data['alamat'] = $this->input->post('alamat',true);
		
		if(!$this->input->post('kode_pos')){
			$json['alert']	= "Kode pos harus diisi";
			echo json_encode($json);exit;
		}
		$data['kode_pos'] = $this->input->post('kode_pos',true);
		
		if(!$this->input->post('telephone')){
			$json['alert']	= "Telepon supplier harus diisi";
			echo json_encode($json);exit;
		}
		$data['telephone'] = $this->input->post('telephone',true);
		
		if(!$this->input->post('kontak')){
			$json['alert']	= "Kontak supplier harus diisi";
			echo json_encode($json);exit;
		}
		$data['kontak'] = $this->input->post('kontak',true);
		
		if(!$this->input->post('akun')){
			$json['alert']	= "Akun supplier harus diisi";
			echo json_encode($json);exit;
		}
		$data['akun'] = $this->input->post('akun',true);
		
		
		if(!$this->input->post('fax')){
			$json['alert']	= "FAX supplier harus diisi";
			echo json_encode($json);exit;
		}
		$data['fax'] = $this->input->post('fax',true);
		
		if(!$this->input->post('email')){
			$json['alert']	= "Email supplier harus diisi";
			echo json_encode($json);exit;
		}
		$data['email'] = $this->input->post('email',true);
		
		
		if($ref=='0'){
			if($this->Db_model->add('supplier',$data)){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}else{
			if($this->Db_model->update('supplier',$data,array('md5(supplier_id)' => $ref))){
				$json['status'] = 'berhasil';
				$json['alert']  = "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
			
		}
	}
	
	function supplier_list(){
		$this->load->model('Supplier_model');
		$list = $this->Supplier_model->get_datatables();
		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();

			$row[] = isset($rows->nama_supplier) ? $rows->nama_supplier : '-';
			$row[] = isset($rows->kontak) ? $rows->kontak : '-';
			$row[] = isset($rows->alamat) ? $rows->alamat : '-';
			$row[] = isset($rows->telephone) ? $rows->telephone : '-';
			$row[] = isset($rows->akun) ? $rows->akun : '-';
			$row[] = isset($rows->email) ? $rows->email : '-';
			$btn = "
			<button type='button' class='btn btn-warning ganti' id='".sha1($rows->supplier_id)."'>Ubah</button>
			<button type='button' class='btn btn-danger hapus' id='".sha1($rows->supplier_id)."'>Hapus</button>
			";
			$row[] = $btn;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Supplier_model->count_all(),
						"recordsFiltered" => $this->Supplier_model->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function hapus_supplier($sha1){
		$this->Db_model->delete('supplier',array('sha1(supplier_id)' => $sha1));
//		exit;
		?>
		<script>
		alert('Data supplier berhasil dihapus');
		window.location.href='<?=site_url('pengaturan/supplier')?>';
		</script>
		
		<?php	
	}
	
}

?>
