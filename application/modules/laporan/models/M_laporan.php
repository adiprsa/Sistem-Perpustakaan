<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan extends CI_Model
{
    public function laporan_anggota($tgl1,$tgl2){
        if ($tgl1!=""&&$tgl1!="") {
            $this->db->where('tgl_register>=',$tgl1);
            $this->db->where('tgl_register<=',$tgl2);
        }
        return $this->db->get('member')->result();
    } 

    public function laporan_buku($tgl1,$tgl2){
        $this->db->select('bibliografi.judul,bibliografi.edisi,bibliografi.isbn_issn,pengarang.nama_pengarang,penerbit.nama_penerbit,bibliografi.tahun_terbit,bibliografi.klasifikasi,item.tgl_terima,item_status.nama_status,lokasi.nama_lokasi,tempat_terbit.nama_tempat,item.kode_item');
        $this->db->from('bibliografi');
        $this->db->join('biblio_pengarang', 'bibliografi.biblio_id = biblio_pengarang.biblio_id');
        $this->db->join('penerbit', 'bibliografi.penerbit_id = penerbit.penerbit_id');
        $this->db->join('pengarang', 'pengarang.pengarang_id = biblio_pengarang.pengarang_id');
        $this->db->join('item', 'item.biblio_id = bibliografi.biblio_id');
        $this->db->join('lokasi', 'lokasi.lokasi_id = item.lokasi_id');
        $this->db->join('item_status', 'item.item_status_id = item_status.item_status_id');
        $this->db->join('tempat_terbit', 'bibliografi.tempat_terbit_id = tempat_terbit.tempat_terbit_id');
        if ($tgl1!=""&&$tgl1!="") {
            $this->db->where('tgl_terima>=',$tgl1);
            $this->db->where('tgl_terima<=',$tgl2);
        }
        $query = $this->db->get()->result();
        return $query;
    }

    public function laporan_peminjaman($filter,$tgl1,$tgl2){
        $this->db->select('bibliografi.judul,bibliografi.edisi,bibliografi.isbn_issn,pengarang.nama_pengarang,penerbit.nama_penerbit,bibliografi.tahun_terbit,tempat_terbit.nama_tempat,bibliografi.klasifikasi,item_status.nama_status,peminjaman.tgl_pinjam,member.nama_member,peminjaman.tgl_harus_kembali,peminjaman.tgl_kembali,item.kode_item');
        $this->db->from('bibliografi');
        $this->db->join('biblio_pengarang', 'bibliografi.biblio_id = biblio_pengarang.biblio_id');
        $this->db->join('penerbit', 'bibliografi.penerbit_id = penerbit.penerbit_id');
        $this->db->join('pengarang', 'pengarang.pengarang_id = biblio_pengarang.pengarang_id');
        $this->db->join('item', 'item.biblio_id = bibliografi.biblio_id');
        $this->db->join('item_status', 'item.item_status_id = item_status.item_status_id');
        $this->db->join('peminjaman', 'peminjaman.no_item = item.item_id');
        $this->db->join('member', 'member.member_id = peminjaman.member_id');
        $this->db->join('tempat_terbit', 'bibliografi.tempat_terbit_id = tempat_terbit.tempat_terbit_id');
        if ($filter!="" && $tgl1!=""&&$tgl1!="") {
            $this->db->where($filter.'>=',$tgl1);
            $this->db->where($filter.'<=',$tgl2);
        }
        $query = $this->db->get()->result();
        return $query;

    }

    public function laporan_denda($filter,$tgl1,$tgl2){
        $this->db->select('bibliografi.judul,bibliografi.edisi,bibliografi.isbn_issn,pengarang.nama_pengarang,penerbit.nama_penerbit,bibliografi.tahun_terbit,tempat_terbit.nama_tempat,bibliografi.klasifikasi,peminjaman.tgl_pinjam,member.nama_member,peminjaman.tgl_harus_kembali,peminjaman.tgl_kembali,item.kode_item,pembayaran_denda.total_denda');
        $this->db->from('bibliografi');
        $this->db->join('biblio_pengarang', 'bibliografi.biblio_id = biblio_pengarang.biblio_id');
        $this->db->join('penerbit', 'bibliografi.penerbit_id = penerbit.penerbit_id');
        $this->db->join('pengarang', 'pengarang.pengarang_id = biblio_pengarang.pengarang_id');
        $this->db->join('item', 'item.biblio_id = bibliografi.biblio_id');
        $this->db->join('peminjaman', 'peminjaman.no_item = item.item_id');
        $this->db->join('member', 'member.member_id = peminjaman.member_id');
        $this->db->join('tempat_terbit', 'bibliografi.tempat_terbit_id = tempat_terbit.tempat_terbit_id');
        $this->db->join('pembayaran_denda', 'peminjaman.peminjaman_id = pembayaran_denda.peminjaman_id');
        if ($filter!="" && $tgl1!=""&&$tgl1!="") {
            $this->db->where($filter.'>=',$tgl1);
            $this->db->where($filter.'<=',$tgl2);
        }
        $query = $this->db->get()->result();
        return $query;

    }

    public function laporan_stok_opname($filter,$tgl1,$tgl2){
        $this->db->select('bibliografi.judul,bibliografi.edisi,bibliografi.isbn_issn,pengarang.nama_pengarang,penerbit.nama_penerbit,bibliografi.tahun_terbit,tempat_terbit.nama_tempat,bibliografi.klasifikasi,,item.kode_item,stok_opname.tgl_mulai,stok_opname.tgl_selesai,stok_opname.nama_pembuat,stok_opname.total_item,stok_opname.total_item_hilang,stok_opname.total_item_ada,stok_opname.total_item_dipinjam,');
        $this->db->from('bibliografi');
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
        $query = $this->db->get()->result();
        return $query;

    }
    
}