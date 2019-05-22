<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipe_member_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_tipe_member() {
		return $this->db->get('tipe_member');
	}
}
