<?php

class Peminjaman_qry extends CI_Model{
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

    public function get_item_by_code($item_code) {
        $query = $this->db->get_where('item', array('kode_item' => $item_code));
        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data;
            $this->db->close();
        }
        return false;
    }

    public function simpan_pinjam_buku($member_code,$item_code) {
      $item = $this->get_item_by_code($item_code);
      $member = $this->get_member_by_code($member_code);
      $data = array(
          'item_id'=>$item->item_id,
          'no_item'=>$item_code,
          'member_id'=>$member->member_id,
          'tgl_pinjam'=>date('Y-m-d'),
          'tgl_harus_kembali'=>date('Y-m-d'),
          'aturan_pinjam_id'=>1,
          'input_date'=>date('Y-m-d'),
          'user_id'=>$this->session->userdata('user_id')
      );

      $this->db->insert('peminjaman',$data);
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
                  a.tgl_kembali
                FROM peminjaman a
                INNER JOIN item b ON a.item_id = b.item_id
                INNER JOIN bibliografi c ON b.biblio_id = c.biblio_id
                INNER JOIN member d ON d.member_id = a.member_id
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
