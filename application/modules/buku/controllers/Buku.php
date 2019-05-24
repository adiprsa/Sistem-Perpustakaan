<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('username')){
			redirect('login/logout');
		}
		$this->load->model('biblio_m');
	}
	public function index()
	{
		$this->buku_list();
	}
	public function buku_list()
	{
		$data['title'] = 'Buku';
		//Header
		$this->load->view('templates/header', $data);
		// Body
		$this->load->view('buku_list',$data);
		// Footer
		$this->load->view('templates/footer');
	}
	public function form()
	{
		$this->load->model('ref_m');

		$data['title'] = 'Buku';
		$data['action'] = $this->uri->segment(3);

		if ($data['action']=='edit') {
			$id = $this->input->get('id_biblio');
			$data['buku'] = $this->biblio_m->biblio_id($id);
			$data['pengarang'] = $this->biblio_m->pengarang($id);
		}
		if ($this->input->post()) {
			$uplods = $this->upload();
			if ($uplods['status']) {
				$file = file_get_contents($uplods['data']['upload_data']['full_path']);
			}else{
				$file = '';
			}
			//print_r("<img src='data:image/png;base64,".base64_encode($file)."'>");
			if($this->validasi()){
				if ($data['action']=='edit') {
					if($this->biblio_m->edit($id,$file)){
						$data['idBaru'] = $id;
						$this->session->set_flashdata('pesan', 'Edit Buku Berhasil');
						$this->session->set_flashdata('status', TRUE);
						//redirect('buku','refresh');
					}else{
						$this->session->set_flashdata('pesan', 'Edit Buku GAGAL');
						$this->session->set_flashdata('status', FALSE);
					}
				}else{
					$data['idBaru'] = $this->biblio_m->tambah($file);
					if($data['idBaru']){
						$this->session->set_flashdata('pesan', 'Tambah Buku Berhasil');
						$this->session->set_flashdata('status', TRUE);
						//redirect('buku','refresh');
					}else{
						$this->session->set_flashdata('pesan', 'Tambah Buku GAGAL');
						$this->session->set_flashdata('status', FALSE);
					}
				}
			}
			$data['buku'] = $this->input->post();
		}

		//Referensi tabal
		$data['kategori'] = $this->ref_m->ambil('kategori');
		$data['penerbit'] = $this->ref_m->ambil('penerbit');
		$data['tempat_terbit'] = $this->ref_m->ambil('tempat_terbit');
		$data['bahasa'] = $this->ref_m->ambil('bahasa');
		$data['frekuensi'] = $this->ref_m->ambil('frekuensi_terbit');
		$data['tipe_konten'] = $this->ref_m->ambil('tipe_konten');
		$data['tipe_media'] = $this->ref_m->ambil('tipe_media');

		//Header
		$this->load->view('templates/header', $data);
		// Body
		$this->load->view('buku_form',$data);
		// Footer
		$this->load->view('templates/footer');
	}
	public function detail()
	{
		$this->load->model('item_m');

		$data['title'] = 'Buku';
		$data['action'] = 'detail';

		$id = $this->input->get('id_biblio');
		$data['buku'] = $this->biblio_m->biblio_id($id);
		$data['pengarang'] = $this->biblio_m->biblio_pengarang($id);
		$data['item'] = $this->item_m->item_biblio($id);
		if (!$data['buku']) {
			redirect('buku','refresh');
		}
		//Header
		$this->load->view('templates/header', $data);
		// Body
		$this->load->view('buku_detail',$data);
		// Footer
		$this->load->view('templates/footer');
	}	
    public function cetak()
    {
        $this->load->library('cetak');
        $jenis = $this->input->get('jenis');

        if ($jenis=='kode_item'){
            $kodeItem = $this->input->get('kode_item');
            $this->cetak->kodeItem($kodeItem);
        }else if ($jenis=='callnumber'){
            $callnumber = $this->input->get('callnumber');
            $this->cetak->callnumber($callnumber);
        }
        $data['output'] = $jenis.'_'.$this->session->userdata('username').'.pdf';
        $this->load->view('pdf',$data);

    }
	private function upload($judul=null)
	{
		$config['upload_path'] 	= './uploads/buku/';
		$config['allowed_types']= 'gif|jpg|png';
		$config['file_name']	= date('Y_m_d_His')."_".$judul;
		$config['max_size']  	= '1024';
		
		$this->load->library('upload', $config);
		
		if ( !$this->upload->do_upload('gambar')){
			$data = array('error' => $this->upload->display_errors());
			$resp = array('status'=>FALSE,'data'=>$data);
		}
		else{
			$data = array('upload_data' => $this->upload->data());
			$resp = array('status'=>TRUE,'data'=>$data);	
		}
		return $resp;
	}
	public function validasi()
	{
		return TRUE;
	}
}

/* End of file buku.php */
/* Location: ./application/controllers/buku.php */