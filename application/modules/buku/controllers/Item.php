<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('item_m');
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

		$data['title'] = 'item';
		$data['action'] = $this->uri->segment(3);

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
						redirect('item','refresh');
					}else{
						$this->session->set_flashdata('pesan', 'Edit item GAGAL');
						$this->session->set_flashdata('status', FALSE);
					}
				}else{
					if($this->item_m->tambah()){
						$this->session->set_flashdata('pesan', 'Tambah item Berhasil');
						$this->session->set_flashdata('status', TRUE);
						redirect('item','refresh');
					}else{
						$this->session->set_flashdata('pesan', 'Tambah item GAGAL');
						$this->session->set_flashdata('status', FALSE);
					}
				}
			}
			$data['item'] = $this->input->post();
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