<?php

class Stok_opname_item_qry extends CI_Model{
    public function __construct() {
        parent::__construct();
    }

    public function get_item($stok_opname_id) {
			$sql = "SELECT a.item_code,
                        a.judul,
                        a.pengecek,
                        b.nama_status as status
                    FROM stok_opname_item a
                    INNER JOIN item_status b 
                    ON b.item_status_id=a.status
                    WHERE a.stok_opname_id='$stok_opname_id'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				$data = $query->result();
				return $data;
				$this->db->close();
			}
			return false;
    }



    public function get_item_by_code($stok_opname_id,$item_code) {
        $query = $this->db->get_where('stok_opname_item', array('stok_opname_id' => $stok_opname_id,'item_code' => $item_code));
        if ($query->num_rows() > 0) {
            $data = $query->row();
            return true;
            $this->db->close();
        }
        return false;
    }

    public function get_item_status() {
        $query = $this->db->get_where('item_status');
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
            $this->db->close();
        }
        return false;
    }

    public function update_item($stok_opname_id,$item_code,$status) {

        $row = $this->get_item_by_code($stok_opname_id,$item_code);
  
        if($row) {
            $data = array(
                'stok_opname_id'=>$stok_opname_id,
                'item_code'=>$item_code,
                'status'=>$status,
                'pengecek'=>$this->session->userdata('nama_asli')
            );
    
            $this->db->where('stok_opname_id',$stok_opname_id);
            $this->db->where('item_code',$item_code);
            $q = $this->db->update('stok_opname_item',$data);
            if($q) {
                return 'ok';;
            } else {
                return false;
            }
        } else {
            return '00000';
        }
        
    }

}
