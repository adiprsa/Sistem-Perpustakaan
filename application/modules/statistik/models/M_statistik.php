<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_statistik extends CI_Model
{
    // public function statistik_pengunjung($tgl1, $tgl2) {
    //     $this->db->select("DATE_FORMAT(tgl_checkin, '%M') as month, COUNT(pengujung_id) as tot_pengunjung");
    //     $this->db->from('pengunjung');
    //     if ($tgl1 != "") {
    //         $this->db->where('tgl_checkin >=', $tgl1);
    //     }
    //     if ($tgl2 != "") {
    //         $this->db->where('tgl_checkin <=', $tgl2);
    //     }
    //     $this->db->group_by("DATE_FORMAT(tgl_checkin, '%M')");
    //     $this->db->order_by('tgl_checkin');
    //     $query = $this->db->get()->result();
    //     return $query;
    // }

    public function statistik_member($month, $year, $type) {
        $this->db->select("DATE_FORMAT(member.tgl_register, '%M') as month, tipe_member.nama_tipe_member as tipe, count(member.member_id) as tot_member");
        $this->db->from('member');
        $this->db->join("tipe_member", "member.tipe_member_id = tipe_member.tipe_member_id");
        if ($type != "") {
            $this->db->where("tipe_member.nama_tipe_member = ", $type);
        }
        if ($month != "") {
            $this->db->where("DATE_FORMAT(member.tgl_register, '%M') = ", $month);
        }
        if ($year != "") {
            $this->db->where("DATE_FORMAT(member.tgl_register, '%Y') = ", $year);
        }
        else {
            $this->db->where("DATE_FORMAT(member.tgl_register, '%Y') = DATE_FORMAT(NOW(), '%Y')");
        }
        $this->db->group_by("DATE_FORMAT(tgl_register, '%M'), tipe_member.nama_tipe_member");
        $this->db->order_by('member.tgl_register, tipe_member.nama_tipe_member');
        $query = $this->db->get()->result();
        return $query;
    }


    public function statistik_buku($month, $year) {
        $this->db->select("DATE_FORMAT(item.tgl_terima, '%M') as month, kategori.nama_kategori as kategori, COUNT(item.item_id) as tot_buku");
        $this->db->from('item');
        $this->db->join('bibliografi', 'item.biblio_id = bibliografi.biblio_id');
        $this->db->join('kategori', 'bibliografi.kategori_id = kategori.kategori_id');
        if ($month != "") {
            $this->db->where("DATE_FORMAT(item.tgl_terima, '%M') =", $month);
        }
        if ($year != "") {
            $this->db->where("DATE_FORMAT(item.tgl_terima, '%Y') = ".$year);
        }
        else {
            $this->db->where("DATE_FORMAT(item.tgl_terima, '%Y') = DATE_FORMAT(NOW(), '%Y')");
        }
        $this->db->group_by("DATE_FORMAT(item.tgl_terima, '%M'), kategori.nama_kategori");
        $this->db->order_by('item.tgl_terima, kategori.nama_kategori');
        $query = $this->db->get()->result();
        return $query;
    }

    public function statistik_peminjaman($month, $year) {
        $this->db->select("DATE_FORMAT(peminjaman.tgl_pinjam, '%M') as month, kategori.nama_kategori as kategori, COUNT(peminjaman.peminjaman_id) as tot_pinjam");
        $this->db->from('peminjaman');
        $this->db->join('item', 'peminjaman.no_item = item.item_id');
        $this->db->join('bibliografi', 'item.biblio_id = bibliografi.biblio_id');
        $this->db->join('kategori', 'bibliografi.kategori_id = kategori.kategori_id');
        if ($month != "") {
            $this->db->where("DATE_FORMAT(peminjaman.tgl_pinjam, '%M') =", $month);
        }
        if ($year != "") {
            $this->db->where("DATE_FORMAT(peminjaman.tgl_pinjam, '%Y') = ".$year);
        }
        else {
            $this->db->where("DATE_FORMAT(peminjaman.tgl_pinjam, '%Y') = DATE_FORMAT(NOW(), '%Y')");
        }
        $this->db->group_by("DATE_FORMAT(peminjaman.tgl_pinjam, '%M'), kategori.nama_kategori");
        $this->db->order_by('peminjaman.tgl_pinjam, kategori.nama_kategori');
        $query = $this->db->get()->result();
        return $query;
    }

    public function statistik_pembayaran_denda($month, $year) {
        $this->db->select("DATE_FORMAT(tgl_bayar, '%M') as month, SUM(total_denda) as tot_denda");
        $this->db->from('pembayaran_denda');
        if ($month != "") {
            $this->db->where("DATE_FORMAT(tgl_bayar, '%M') =", $month);
        }
        if ($year != "") {
            $this->db->where("DATE_FORMAT(tgl_bayar, '%Y') = ".$year);
        }
        else {
            $this->db->where("DATE_FORMAT(tgl_bayar, '%Y') = DATE_FORMAT(NOW(), '%Y')");
        }
        $this->db->group_by("DATE_FORMAT(tgl_bayar, '%M')");
        $this->db->order_by('tgl_bayar');
        $query = $this->db->get()->result();
        return $query;
    }

    public function statistik_stok_opname($date) {
        $this->db->select("tgl_mulai, total_item_hilang, total_item_ada, total_item_dipinjam");
        $this->db->from('stok_opname');
        if ($date != "") {
            $this->db->where("tgl_mulai =", $date);
        }
        $query = $this->db->get()->result();
        return $query;
    }


}