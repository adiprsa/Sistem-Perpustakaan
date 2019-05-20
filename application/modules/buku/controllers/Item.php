<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('item_m','biblio_m'));
		$this->output->enable_profiler(TRUE);
	}
	public function index()
	{
		$this->item_list();
	}
	public function item_list()
	{
		$data['title'] = 'item';
		//Header
		$this->load->view('templates/header', $data);
		// Body
		$this->load->view('item_list',$data);
		// Footer
		$this->load->view('templates/footer');
	}
	public function cari()
	{
		$data['title'] = 'item';
		$data['action'] = 'cari';
		//Header
		$this->load->view('templates/header', $data);
		// Body
		$this->load->view('item_cari',$data);
		// Footer
		$this->load->view('templates/footer');
	}
	public function form()
	{
		$this->load->model('ref_m');

		$data['title'] 		= 'item';
		$data['action'] 	= $this->uri->segment(4);
		$data['biblio_id']	= $this->input->get('biblio_id');
		$data['buku']		= $this->biblio_m->biblio_id($data['biblio_id']);
		$data['pengarang']		= $this->biblio_m->biblio_pengarang($data['biblio_id']);
		if ($data['biblio_id']=='') {
			redirect('buku/item/cari','refresh');
		}
		if ($data['action']=='edit') {
			$id = $this->input->get('id_item');
			$data['item'] = $this->item_m->item_id($id);
		}
		if ($this->input->post()) {
			if($this->validasi()){
				if ($data['action']=='edit') {
					if($this->item_m->edit($id)){
						$this->session->set_flashdata('pesan', 'Edit item Berhasil');
						$this->session->set_flashdata('status', TRUE);
						redirect('buku/item','refresh');
					}else{
						$this->session->set_flashdata('pesan', 'Edit item GAGAL');
						$this->session->set_flashdata('status', FALSE);
					}
				}else{
					if($this->item_m->tambah()){
						$this->session->set_flashdata('pesan', 'Tambah item Berhasil');
						$this->session->set_flashdata('status', TRUE);
						redirect('buku/item','refresh');
					}else{
						$this->session->set_flashdata('pesan', 'Tambah item GAGAL');
						$this->session->set_flashdata('status', FALSE);
					}
				}
			}
			$data['item'] = $this->input->post();
		}

		//Referensi tabal

		//Header
		$this->load->view('templates/header', $data);
		// Body
		$this->load->view('item_form',$data);
		// Footer
		$this->load->view('templates/footer');
	}
	public function validasi()
	{
		return TRUE;
	}
}

/* End of file item.php */
/* Location: ./application/controllers/item.php */