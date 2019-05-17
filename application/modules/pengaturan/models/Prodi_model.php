<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prodi_model extends CI_Model {

	var $table = 'prodi';
	var $column_order = array('prodi.prodi','fakultas.fakultas','prodi.kd_prodi'); //set column field database for datatable orderable
	var $column_search = array('prodi.prodi','fakultas.fakultas'); //set column field database for datatable searchable 
	var $order = array('prodi.kd_prodi' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($kd_fakultas)
	{	
		$this->db->select('prodi.*,fakultas.fakultas');		
		$this->db->from($this->table);
		if($kd_fakultas!='-'){
			$this->db->where('sha1(prodi.id_fakultas)',$kd_fakultas);
		}
		$this->db->join('fakultas','fakultas.kd_fakultas = prodi.id_fakultas');
		$i = 0;	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($kd_fakultas)
	{		
		$this->_get_datatables_query($kd_fakultas);		
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($kd_fakultas)
	{
		$this->_get_datatables_query($kd_fakultas);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($kd_fakultas)
	{
		$this->db->select('prodi.*,fakultas.fakultas');		
		$this->db->from($this->table);
		if($kd_fakultas!='-'){
			$this->db->where('sha1(prodi.id_fakultas)',$kd_fakultas);
		}
		$this->db->join('fakultas','fakultas.kd_fakultas = prodi.id_fakultas');
		return $this->db->count_all_results();
	}
	
}
