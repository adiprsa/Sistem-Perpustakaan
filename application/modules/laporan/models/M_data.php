<?php defined('BASEPATH') OR exit('No direct script access allowed');

class m_data extends CI_Model
{
    public function getAll()
    {
        return $this->db->get("dev_user")->result();
    }

    public function getjoin()
    {
    	$this->db->select('*');
		$this->db->from('dev_management');
		$this->db->join('dev_pj_inves', 'dev_pj_inves.dev_id = dev_management.dev_id');
		$query = $this->db->get()->result();
		return $query;
    }

    
    
}