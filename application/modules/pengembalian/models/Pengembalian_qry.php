<?php

class Pengembalian_qry extends CI_Model{
    public function __construct() {
        parent::__construct();
    }

    public function get_member_by_code($member_code) {
        $query = $this->db->get_where('member', array('member_code' => $member_code));
        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data;
            $this->db->close();
        }
        return false;
    }

    public function get_item_pinjam($item_code,$member_id) {
        $sql = "SELECT a.*
                FROM peminjaman a
                WHERE a.dikembalikan IS NULL 
                AND a.member_id='$member_id' 
                AND no_item='$item_code'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data;
            $this->db->close();
        }
        return false;
    }

    public function return_book($peminjaman_id,$tgl_kembali) {
      $data = array(
          'dikembalikan'=>1,
          'tgl_kembali'=>$tgl_kembali,
          'last_update'=>date('Y-m-d'),
      );
      $this->db->where('peminjaman_id', $peminjaman_id);
      $this->db->update('peminjaman',$data);
      return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function get_item_by_member($member_code) {
        $sql = "SELECT a.peminjaman_id,
                	a.no_item,
                	c.judul,
                	c.kolasi,
                	a.tgl_pinjam,
                	a.tgl_harus_kembali,
                	a.dikembalikan
                FROM peminjaman a
                INNER JOIN item b ON a.item_id = b.item_id
                INNER JOIN bibliografi c ON b.biblio_id = c.biblio_id
                INNER JOIN member d ON d.member_id = a.member_id
                WHERE a.dikembalikan IS NULL AND d.member_code='$member_code'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
            $this->db->close();
        }
        return false;
    }

    public function get_item_by_member_history($member_code) {
        $sql = "SELECT a.peminjaman_id,
                	a.no_item,
                	c.judul,
                	c.kolasi,
                	a.tgl_pinjam,
                	a.tgl_harus_kembali,
                	a.dikembalikan,
                    a.tgl_kembali,
                    e.total_denda,
                    e.tgl_bayar
                FROM peminjaman a
                INNER JOIN item b ON a.item_id = b.item_id
                INNER JOIN bibliografi c ON b.biblio_id = c.biblio_id
                INNER JOIN member d ON d.member_id = a.member_id
                LEFT JOIN pembayaran_denda e ON e.peminjaman_id=a.peminjaman_id
                WHERE a.dikembalikan IS NOT NULL AND d.member_code='$member_code'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->result();


            return $data;
            $this->db->close();
        }
        return false;
    }

}
