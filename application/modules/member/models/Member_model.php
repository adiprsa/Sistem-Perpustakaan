<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model {

	var $table = 'member';
	var $column_order = array('member.nama_member','tipe_member.nama_tipe_member','member.nama_member','prodi.prodi'); //set column field database for datatable orderable
	var $column_search = array('member.nama_member','member.tipe_member_id','member.nama_member','prodi.prodi'); //set column field database for datatable searchable 
	var $order = array('member.member_id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->select('member.*,tipe_member.nama_tipe_member as nama_tipe_member, prodi.prodi as prodi');		
		$this->db->from($this->table);
		$this->db->join('tipe_member','member.tipe_member_id = tipe_member.tipe_member_id');
		$this->db->join('prodi','member.prodi_id = prodi.kd_prodi');
		$i = 0;	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
			//		$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				//if(count($this->column_search) - 1 == $i) //last loop
					//$this->db->group_end(); //close bracket
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

	function get_datatables()
	{		
		$this->_get_datatables_query();		
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		//$this->db->from($this->table);
		$this->db->select('*');		
		$this->db->from($this->table);
		$this->db->join('tipe_member','member.tipe_member_id = tipe_member.tipe_member_id');
		$this->db->join('prodi','member.prodi_id = prodi.kd_prodi');
		return $this->db->count_all_results();
	}

}
