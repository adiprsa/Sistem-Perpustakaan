<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ref_m extends CI_Model {

	public function ambil($tabel=null)
	{
		$query = $this->db->get($tabel);
		if ($query->num_rows()>0) {
			return $query->result_array();
		}
	}

}

/* End of file ref_m.php */
/* Location: ./application/models/ref_m.php */