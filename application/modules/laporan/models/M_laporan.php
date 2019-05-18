<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan extends CI_Model
{
    public function laporan_anggota($tgl1,$tgl2){
        if ($tgl1!=""&&$tgl1!="") {
            $this->db->where('tgl_register>=',$tgl1);
            $this->db->where('tgl_register<=',$tgl2);
        }
        $this->db->join('tipe_member','tipe_member.tipe_member_id = member.tipe_member_id');
        return $this->db->get('member')->result();
    } 

    public function laporan_buku($tgl1,$tgl2){
        $this->db->join('biblio_pengarang', 'bibliografi.biblio_id = biblio_pengarang.biblio_id');
        $this->db->join('penerbit', 'bibliografi.penerbit_id = penerbit.penerbit_id');
        $this->db->join('pengarang', 'pengarang.pengarang_id = biblio_pengarang.pengarang_id');
        $this->db->join('item', 'item.biblio_id = bibliografi.biblio_id');
        $this->db->join('item_status', 'item.item_status_id = item_status.item_status_id');
        $this->db->join('tempat_terbit', 'bibliografi.tempat_terbit_id = tempat_terbit.tempat_terbit_id');
        if ($tgl1!=""&&$tgl1!="") {
            $this->db->where('tgl_terima>=',$tgl1);
            $this->db->where('tgl_terima<=',$tgl2);
        }
        return  $this->db->get('bibliografi')->result();
    }

    public function laporan_peminjaman($filter,$tgl1,$tgl2){
        $this->db->join('biblio_pengarang', 'bibliografi.biblio_id = biblio_pengarang.biblio_id');
        $this->db->join('penerbit', 'bibliografi.penerbit_id = penerbit.penerbit_id');
        $this->db->join('pengarang', 'pengarang.pengarang_id = biblio_pengarang.pengarang_id');
        $this->db->join('item', 'item.biblio_id = bibliografi.biblio_id');
        $this->db->join('item_status', 'item.item_status_id = item_status.item_status_id');
        $this->db->join('tempat_terbit', 'bibliografi.tempat_terbit_id = tempat_terbit.tempat_terbit_id');
        $this->db->join('peminjaman', 'peminjaman.no_item = item.item_id');
        $this->db->join('member', 'member.member_id = peminjaman.member_id');
        if ($filter!="" && $tgl1!=""&&$tgl1!="") {
            $this->db->where($filter.'>=',$tgl1);
            $this->db->where($filter.'<=',$tgl2);
        }
        $query = $this->db->get('bibliografi')->result();
        return $query;

    }

    public function laporan_denda($filter,$tgl1,$tgl2){
        $this->db->join('biblio_pengarang', 'bibliografi.biblio_id = biblio_pengarang.biblio_id');
        $this->db->join('penerbit', 'bibliografi.penerbit_id = penerbit.penerbit_id');
        $this->db->join('pengarang', 'pengarang.pengarang_id = biblio_pengarang.pengarang_id');
        $this->db->join('item', 'item.biblio_id = bibliografi.biblio_id');
        $this->db->join('tempat_terbit', 'bibliografi.tempat_terbit_id = tempat_terbit.tempat_terbit_id');
        $this->db->join('peminjaman', 'peminjaman.no_item = item.item_id');
        $this->db->join('member', 'member.member_id = peminjaman.member_id');
        $this->db->join('pembayaran_denda', 'peminjaman.peminjaman_id = pembayaran_denda.peminjaman_id');
        if ($filter!="" && $tgl1!=""&&$tgl1!="") {
            $this->db->where($filter.'>=',$tgl1);
            $this->db->where($filter.'<=',$tgl2);
        }
        $query = $this->db->get('bibliografi')->result();
        return $query;

    }

    public function laporan_stok_opname($filter,$tgl1,$tgl2){
        $this->db->join('biblio_pengarang', 'bibliografi.biblio_id = biblio_pengarang.biblio_id');
        $this->db->join('penerbit', 'bibliografi.penerbit_id = penerbit.penerbit_id');
        $this->db->join('pengarang', 'pengarang.pengarang_id = biblio_pengarang.pengarang_id');
        $this->db->join('item', 'item.biblio_id = bibliografi.biblio_id');
        $this->db->join('tempat_terbit', 'bibliografi.tempat_terbit_id = tempat_terbit.tempat_terbit_id');
        $this->db->join('stok_opname_item', 'item.item_id = stok_opname_item.item_id');
        $this->db->join('stok_opname', 'stok_opname_item.stok_opname_id = stok_opname.stok_opname_id');
        if ($filter!="" && $tgl1!=""&&$tgl1!="") {
            $this->db->where($filter.'>=',$tgl1);
            $this->db->where($filter.'<=',$tgl2);
        }
        $query = $this->db->get('bibliografi')->result();
        return $query;

    }
    
}