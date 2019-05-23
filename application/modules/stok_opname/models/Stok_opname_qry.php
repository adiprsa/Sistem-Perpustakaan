<?php

class Stok_opname_qry extends CI_Model{

    public function __construct() {
        parent::__construct();
    }

    public function get_stok_opname() {
        $query = $this->db->get_where('stok_opname');
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
            $this->db->close();
        }
        return false;
    }

    public function get_stok_opname_by_id($id) {
        $query = $this->db->get_where('stok_opname',array('stok_opname_id' => $id));
        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data;
            $this->db->close();
        }
        return false;
    }

    public function save_data($id,$nama_stok_opname,$tgl_mulai,$tgl_selesai,$pembuat) {

        $data = array(
            'nama_stok_opname'=>$nama_stok_opname,
            'tgl_mulai'=>date("Y-m-d", strtotime($tgl_mulai)),
            'tgl_selesai'=>date("Y-m-d", strtotime($tgl_selesai)),
            'nama_pembuat'=>$pembuat,
            'is_active'=>1,
            'pemproses'=>$this->session->userdata('nama_asli')
        );

        $this->db->where('stok_opname_id',$id);
        $q = $this->db->get('stok_opname');

        if ( $q->num_rows() > 0 ) 
        {
            $this->db->where('stok_opname_id',$id);
            $joni = $this->db->update('stok_opname',$data);
        } else {
            $this->db->set('stok_opname_id', $id);
            $this->db->insert('stok_opname',$data);
            $id = $this->db->insert_id();
            # Get Data Item
            $sql = "INSERT INTO stok_opname_item (stok_opname_id,item_id,item_code,judul,call_number,lokasi_id)
                    SELECT
                    $id, items.*
                    FROM (SELECT
                        a.item_id,
                        a.kode_item,
                        b.judul,
                        b.call_number,
                        a.lokasi_id
                    FROM item a
                    INNER JOIN bibliografi b
                    ON a.biblio_id = b.biblio_id) AS items
                    LEFT OUTER JOIN (SELECT
                                    a.item_id,
                                    a.no_item
                                    FROM peminjaman a
                                    WHERE dikembalikan IS NULL) AS pinjam
                    ON items.item_id = pinjam.item_id";
            $query = $this->db->query($sql);
            return  $query;
        }
        return $joni;
        

    }

    public function delete($id) {
        $sql = "DELETE FROM stok_opname
                WHERE stok_opname_id = '$id'";
        $query = $this->db->query($sql);
        if ($query) {
            return true;
            $this->db->close();
        }
        return false;
    }


}
