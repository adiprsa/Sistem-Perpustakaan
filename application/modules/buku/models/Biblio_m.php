<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biblio_m extends CI_Model {

	public function biblio_id($id=null)
	{
		$this->db->where('biblio_id', $id);
		$query = $this->db->get('bibliografi',1);
		if ($query->num_rows()>0) {
			foreach ($query->result_array() as $value) {
				$biblio = $value;
			}
			return $biblio;
		}
	}
	public function tambah()
	{
		$data = array('judul'				=> $this->input->post('judul'),
						'edisi'				=> $this->input->post('edisi'),
						'isbn_issn'			=> $this->input->post('isbn_issn'),
						'penerbit_id'		=> $this->input->post('penerbit_id'),
						'tahun_terbit'		=> $this->input->post('tahun_terbit'),
						'kolasi'			=> $this->input->post('kolasi'),
						'judul_seri'		=> $this->input->post('judul_seri'),
						'call_number'		=> $this->input->post('call_number'),
						'bahasa_id'			=> $this->input->post('bahasa_id'),
						'asal'				=> $this->input->post('asal'),
						'tempat_terbit_id'	=> $this->input->post('tempat_terbit_id'),
						'notes'				=> $this->input->post('notes'),
						'gambar'			=> $this->input->post('gambar'),
						'labels'			=> $this->input->post('labels'),
						'frekuensi_id'		=> $this->input->post('frekuensi_id'),
						'tipe_konten_id'	=> $this->input->post('tipe_konten_id'),
						'tipe_media_id'		=> $this->input->post('tipe_media_id'),
						'klasifikasi'		=> $this->input->post('klasifikasi'),
						'input_date'		=> date('Y-m-d H:i:s'));
		$query = $this->db->insert('bibliografi', $data);
		return $query;
	}
	public function edit($id=null)
	{
		$data = array('judul'				=> $this->input->post('judul'),
						'edisi'				=> $this->input->post('edisi'),
						'isbn_issn'			=> $this->input->post('isbn_issn'),
						'penerbit_id'		=> $this->input->post('penerbit_id'),
						'tahun_terbit'		=> $this->input->post('tahun_terbit'),
						'kolasi'			=> $this->input->post('kolasi'),
						'judul_seri'		=> $this->input->post('judul_seri'),
						'call_number'		=> $this->input->post('call_number'),
						'bahasa_id'			=> $this->input->post('bahasa_id'),
						'asal'				=> $this->input->post('asal'),
						'tempat_terbit_id'	=> $this->input->post('tempat_terbit_id'),
						'notes'				=> $this->input->post('notes'),
						'gambar'			=> $this->input->post('gambar'),
						'labels'			=> $this->input->post('labels'),
						'frekuensi_id'		=> $this->input->post('frekuensi_id'),
						'tipe_konten_id'	=> $this->input->post('tipe_konten_id'),
						'tipe_media_id'		=> $this->input->post('tipe_media_id'),
						'klasifikasi'		=> $this->input->post('klasifikasi'));
		$this->db->where('biblio_id', $id);
		$query = $this->db->update('bibliografi', $data);
		return $query;
	}
	public function hapus($id=null)
	{
		$this->db->where('biblio_id', $id);
		$query = $this->db->delete('bibliografi', $data);
		return $query;
	}
}

/* End of file buku_m.php */
/* Location: ./application/models/buku_m.php */