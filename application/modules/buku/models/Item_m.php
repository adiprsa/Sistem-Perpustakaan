<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_m extends CI_Model {

	public function item_id($id=null)
	{
		$this->db->where('item_id', $id);
		$query = $this->db->get('item',1);
		if ($query->num_rows()>0) {
			foreach ($query->result_array() as $value) {
				$item = $value;
			}
			return $item;
		}
	}
	public function tambah()
	{
		$data = array('biblio_id'			=> $this->input->post('biblio_id'),
						'call_number'		=> $this->input->post('call_number'),
						'tipe_kolasi'		=> $this->input->post('tipe_kolasi'),
						'kode_item'			=> $this->input->post('kode_item'),
						'kode_inventaris'	=> $this->input->post('kode_inventaris'),
						'tgl_terima'		=> $this->input->post('tgl_terima'),
						'supplier_id'		=> $this->input->post('supplier_id'),
						'no_order'			=> $this->input->post('no_order'),
						'lokasi_id'			=> $this->input->post('lokasi_id'),
						'nama_rak'			=> $this->input->post('nama_rak'),
						'tgl_order'			=> $this->input->post('tgl_order'),
						'item_status_id'	=> $this->input->post('item_status_id'),
						'asal'				=> $this->input->post('asal'),
						'invoice'			=> $this->input->post('invoice'),
						'harga'				=> $this->input->post('harga')
						'input_date'		=> date('Y-m-d H:i:s'));
		$query = $this->db->insert('itemgrafi', $data);
		return $query;
	}
	public function edit($id=null)
	{
		$data = array('biblio_id'			=> $this->input->post('biblio_id'),
						'call_number'		=> $this->input->post('call_number'),
						'tipe_kolasi'		=> $this->input->post('tipe_kolasi'),
						'kode_item'			=> $this->input->post('kode_item'),
						'kode_inventaris'	=> $this->input->post('kode_inventaris'),
						'tgl_terima'		=> $this->input->post('tgl_terima'),
						'supplier_id'		=> $this->input->post('supplier_id'),
						'no_order'			=> $this->input->post('no_order'),
						'lokasi_id'			=> $this->input->post('lokasi_id'),
						'nama_rak'			=> $this->input->post('nama_rak'),
						'tgl_order'			=> $this->input->post('tgl_order'),
						'item_status_id'	=> $this->input->post('item_status_id'),
						'asal'				=> $this->input->post('asal'),
						'invoice'			=> $this->input->post('invoice'),
						'harga'				=> $this->input->post('harga'));
		$this->db->where('item_id', $id);
		$query = $this->db->update('item', $data);
		return $query;
	}
	public function hapus($id=null)
	{
		$this->db->where('item_id', $id);
		$query = $this->db->delete('item', $data);
		return $query;
	}
}

/* End of file buku_m.php */
/* Location: ./application/models/buku_m.php */