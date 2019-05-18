<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_m extends CI_Model {

	public function kategori_id($id=null)
	{
		$this->db->where('kategori_id', $id);
		$query = $this->db->get('kategori',1);
		if ($query->num_rows()>0) {
			foreach ($query->result_array() as $value) {
				$kategori = $value;
			}
			return $kategori;
		}
	}
	public function kategori_list()
	{
		$query = $this->db->get('kategori');
		if ($query->num_rows()>0) {
			return $query->result_array();
		}
	}
	public function tambah()
	{
		$data = array('judul'				=> $this->input->post('judul'),
						
						'input_date'		=> date('Y-m-d H:i:s'));
		$query = $this->db->insert('kategori', $data);
		return $query;
	}
	public function edit($id=null)
	{
		$data = array('judul'				=> $this->input->post('judul'),
						'klasifikasi'		=> $this->input->post('klasifikasi'));
		$this->db->where('kategori_id', $id);
		$query = $this->db->update('kategori', $data);
		return $query;
	}
	public function hapus($id=null)
	{
		$this->db->where('kategori_id', $id);
		$query = $this->db->delete('kategori', $data);
		return $query;
	}
}

/* End of file buku_m.php */
/* Location: ./application/models/buku_m.php */