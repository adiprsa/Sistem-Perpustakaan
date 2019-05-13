<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
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
		}
		if ($this->input->post()) {
			if($this->validasi()){
				if ($data['action']=='edit') {
					if($this->biblio_m->edit($id)){
						$this->session->set_flashdata('pesan', 'Edit Buku Berhasil');
						$this->session->set_flashdata('status', TRUE);
						redirect('buku','refresh');
					}else{
						$this->session->set_flashdata('pesan', 'Edit Buku GAGAL');
						$this->session->set_flashdata('status', FALSE);
					}
				}else{
					if($this->biblio_m->tambah()){
						$this->session->set_flashdata('pesan', 'Tambah Buku Berhasil');
						$this->session->set_flashdata('status', TRUE);
						redirect('buku','refresh');
					}else{
						$this->session->set_flashdata('pesan', 'Tambah Buku GAGAL');
						$this->session->set_flashdata('status', FALSE);
					}
				}
			}
			$data['buku'] = $this->input->post();
		}

		//Referensi tabal
		$data['penerbit'] = $this->ref_m->ambil('penerbit');
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
	public function validasi()
	{
		return TRUE;
	}
}

/* End of file buku.php */
/* Location: ./application/controllers/buku.php */