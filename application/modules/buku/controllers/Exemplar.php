<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exemplar extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('item_m');
	}
	public function index()
	{
		$this->exemplar_list();
	}
	public function exemplar_list()
	{
		$data['title'] = 'Exemplar';
		//Header
		$this->load->view('templates/header', $data);
		// Body
		$this->load->view('exemplar_list',$data);
		// Footer
		$this->load->view('templates/footer');
	}
	public function form()
	{
		$this->load->model('ref_m');

		$data['title'] = 'Exemplar';
		$data['action'] = $this->uri->segment(3);

		if ($data['action']=='edit') {
			$id = $this->input->get('id_item');
			$data['exemplar'] = $this->item_m->item_id($id);
		}
		if ($this->input->post()) {
			if($this->validasi()){
				if ($data['action']=='edit') {
					if($this->item_m->edit($id)){
						$this->session->set_flashdata('pesan', 'Edit exemplar Berhasil');
						$this->session->set_flashdata('status', TRUE);
						redirect('exemplar','refresh');
					}else{
						$this->session->set_flashdata('pesan', 'Edit exemplar GAGAL');
						$this->session->set_flashdata('status', FALSE);
					}
				}else{
					if($this->item_m->tambah()){
						$this->session->set_flashdata('pesan', 'Tambah exemplar Berhasil');
						$this->session->set_flashdata('status', TRUE);
						redirect('exemplar','refresh');
					}else{
						$this->session->set_flashdata('pesan', 'Tambah exemplar GAGAL');
						$this->session->set_flashdata('status', FALSE);
					}
				}
			}
			$data['exemplar'] = $this->input->post();
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
		$this->load->view('exemplar_form',$data);
		// Footer
		$this->load->view('templates/footer');
	}
	public function validasi()
	{
		return TRUE;
	}
}

/* End of file exemplar.php */
/* Location: ./application/controllers/exemplar.php */