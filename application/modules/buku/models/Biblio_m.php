<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biblio_m extends CI_Model {

	public function biblio_id($id=null)
	{
		$this->db->where('biblio_id', $id);
		$this->db->join('penerbit', 'penerbit.penerbit_id = bibliografi.penerbit_id', 'left');
		$query = $this->db->get('bibliografi',1);
		if ($query->num_rows()>0) {
			foreach ($query->result_array() as $value) {
				$biblio = $value;
			}
			return $biblio;
		}
	}
	public function biblio_pengarang($id=null)
	{
		$this->db->where('biblio_id', $id);
		$this->db->join('pengarang', 'pengarang.pengarang_id = biblio_pengarang.pengarang_id', 'left');
		$query = $this->db->get('biblio_pengarang');
		if ($query->num_rows()>0) {
			return $query->result_array();			
		}
	}
	public function cari($q=null,$limit=20,$offset=0)
	{
		if ($q!=null) {
			$this->db->like('judul', $q);
		}
		$this->db->join('penerbit', 'penerbit.penerbit_id = bibliografi.penerbit_id', 'left');
		$query = $this->db->get('bibliografi', $limit, $offset);
		if ($query->num_rows()>0) {
			return $query->result();
		}
	}
	public function tambah($file=null)
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
						'tempat_terbit_id'	=> $this->input->post('tempat_terbit_id'),
						'notes'				=> $this->input->post('notes'),
						'gambar'			=> $file,
						'labels'			=> $this->input->post('labels'),
						'frekuensi_id'		=> $this->input->post('frekuensi_id'),
						'tipe_konten_id'	=> $this->input->post('tipe_konten_id'),
						'tipe_media_id'		=> $this->input->post('tipe_media_id'),
						'kategori_id'		=> $this->input->post('kategori_id'),
						'input_date'		=> date('Y-m-d H:i:s'));
		$query = $this->db->insert('bibliografi', $data);
		$insert_id = $this->db->insert_id();
		$this->tambah_pengarang($insert_id);
		return $insert_id;
	}
	public function edit($id=null,$file=null)
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
						'tempat_terbit_id'	=> $this->input->post('tempat_terbit_id'),
						'notes'				=> $this->input->post('notes'),
						'labels'			=> $this->input->post('labels'),
						'frekuensi_id'		=> $this->input->post('frekuensi_id'),
						'tipe_konten_id'	=> $this->input->post('tipe_konten_id'),
						'tipe_media_id'		=> $this->input->post('tipe_media_id'),
						'kategori_id'		=> $this->input->post('kategori_id'));
		if ($file!=''||$file!=null) {
			$data = array_merge($data,array('gambar'=>$file));
		}
		$this->db->where('biblio_id', $id);
		$query = $this->db->update('bibliografi', $data);
		$this->tambah_pengarang($id);
		return $query;
	}
	public function pengarang($biblio_id='')
	{
		$this->db->where('biblio_id', $biblio_id);
		$this->db->join('pengarang', 'pengarang.pengarang_id = biblio_pengarang.pengarang_id', 'left');
		$query = $this->db->get('biblio_pengarang');
		if ($query->num_rows()>0) {
			return $query->result_array();
		}
	}
	public function tambah_pengarang($biblio_id=null)
	{
		// hapus data pengarang sebelumnya
		$this->db->where('biblio_id', $biblio_id);
		$this->db->delete('biblio_pengarang');
		// tambah data pengarang baru

		$pengarang = $this->input->post('pengarang_id');
		foreach ($pengarang as $key => $value) {
			if ($value!='') {
				$data = array('biblio_id'		=> $biblio_id,
								'pengarang_id'	=> $value,
								'level'			=> $key);
				$this->db->insert('biblio_pengarang', $data);
			}
		}
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