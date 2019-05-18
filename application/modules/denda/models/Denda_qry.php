<?php

class Denda_qry extends CI_Model{
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

    public function bayar_denda($denda) {

        $i = 1;
        foreach ($denda as $val) {
            $data[] = array(
                'pembnayaran_id'=>$val,
                'tgl_bayar'=>date('Y-m-d'),
            );
            $i++;
        }
        $this->db->update_batch('pembayaran_denda',$data, 'pembnayaran_id'); 
        return ($this->db->affected_rows() < 1) ? false : true;

      }

    public function get_denda_by_member($member_code) {
        $sql = "SELECT a.peminjaman_id,
                	a.no_item,
                	c.judul,
                	c.kolasi,
                	a.tgl_pinjam,
                	a.tgl_harus_kembali,
                	a.dikembalikan,
                    a.tgl_kembali,
                    e.total_denda,
                    e.tgl_bayar,
                    e.pembnayaran_id
                FROM peminjaman a
                INNER JOIN item b ON a.item_id = b.item_id
                INNER JOIN bibliografi c ON b.biblio_id = c.biblio_id
                INNER JOIN member d ON d.member_id = a.member_id
                INNER JOIN pembayaran_denda e ON e.peminjaman_id=a.peminjaman_id
                WHERE a.dikembalikan IS NOT NULL 
                AND d.member_code='$member_code'
                AND e.tgl_bayar IS NULL";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->result();


            return $data;
            $this->db->close();
        }
        return false;
    }

    public function get_history_denda_by_member($member_code) {
        $sql = "SELECT a.peminjaman_id,
                	a.no_item,
                	c.judul,
                	c.kolasi,
                	a.tgl_pinjam,
                	a.tgl_harus_kembali,
                	a.dikembalikan,
                    a.tgl_kembali,
                    e.total_denda,
                    DATE_FORMAT(e.tgl_bayar,'%d-%m-%Y') tgl_bayar,
                    e.pembnayaran_id
                FROM peminjaman a
                INNER JOIN item b ON a.item_id = b.item_id
                INNER JOIN bibliografi c ON b.biblio_id = c.biblio_id
                INNER JOIN member d ON d.member_id = a.member_id
                LEFT JOIN pembayaran_denda e ON e.peminjaman_id=a.peminjaman_id
                WHERE a.dikembalikan IS NOT NULL 
                AND d.member_code='$member_code'
                AND e.tgl_bayar IS NOT NULL";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->result();


            return $data;
            $this->db->close();
        }
        return false;
    }

}
