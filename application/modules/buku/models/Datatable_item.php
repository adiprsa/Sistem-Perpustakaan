<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Datatable_item extends CI_Model {
 
    var $table = 'item';
    var $column_order = array(null,'judul','call_number','kode_item','lokasi','nama_rak','asal');
    var $column_search =  array('judul','call_number','kode_item','lokasi','nama_rak','asal');
    var $order = array('item.item_id' => 'desc');
 
    public function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->table);
        
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
        $this->db->join('bibliografi', 'bibliografi.biblio_id = item.biblio_id', 'left');
        //$this->db->join('penerbit', 'penerbit.penerbit_id = bibliografi.penerbit_id', 'left');
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
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
}
