<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aturan {

		public function aturan_pinjam($member_code) {
			$CI =& get_instance();
			$sql = "SELECT a.limit_pinjam,
					a.boleh_reservasi,
					a.bisa_tiap_hari,
					a.lama_pinjam,
					a.denda_perhari,
					a.masa_tenggang
			FROM tipe_member a
			INNER JOIN member b
			ON b.tipe_member_id=a.tipe_member_id
			WHERE b.member_code='$member_code'";
			$query = $CI->db->query($sql);
			if ($query->num_rows() > 0) {
				$data = $query->row();
				return $data;
				$CI->db->close();
			}
			return false;
		}

		public function check_jml_pinjam($member_code) {
			$CI =& get_instance();
			$sql = "SELECT COUNT(a.peminjaman_id) as jml_pinjam
					FROM peminjaman a
					INNER JOIN item b ON a.item_id = b.item_id
					INNER JOIN bibliografi c ON b.biblio_id = c.biblio_id
					INNER JOIN member d ON d.member_id = a.member_id
					WHERE a.dikembalikan IS NULL AND d.member_code='$member_code'";
			$query = $CI->db->query($sql);
			if ($query->num_rows() > 0) {
				$data = $query->row();
				return $data;
				$CI->db->close();
			}
			return false;
		}

		public function get_tgl_kembali($tgl_pinjam,$lama) {
			$tgl_harus_kembali = date('Y-m-d', strtotime($tgl_pinjam. ' + '.$lama.' days'));
			return $tgl_harus_kembali;
		}

		public function check_jml_item($item_code) {
			$CI =& get_instance();
			$sql = "SELECT COUNT(a.kode_item) as jml_item
					FROM item a
					WHERE a.kode_item='$item_code'";
			$query = $CI->db->query($sql);
			if ($query->num_rows() > 0) {
				$data = $query->row();
				return $data->jml_item;
				$CI->db->close();
			}
			return false;
		}

		public function check_jml_item_dipinjam($item_code) {
			$CI =& get_instance();
			$sql = "SELECT COUNT(a.no_item) as jml_item
					FROM peminjaman a
					WHERE a.dikembalikan IS NULL AND a.no_item='$item_code'";
			$query = $CI->db->query($sql);
			if ($query->num_rows() > 0) {
				$data = $query->row();
				return $data->jml_item;
				$CI->db->close();
			}
			return false;
		}

		public function create_tagihan($peminjaman_id,$tgl_kembali,$tgl_harus_kembali,$denda_perhari) {
			$CI =& get_instance();

			$kembali = new DateTime($tgl_kembali);
			$hrs_kembali = new DateTime($tgl_harus_kembali);
			$lama = $hrs_kembali->diff($kembali)->format("%a");
			$total_denda  = $lama * $denda_perhari;

			$data = array(
				'peminjaman_id'=>$peminjaman_id,
				'total_denda'=>$total_denda,
				'user_id'=>$CI->session->userdata('user_id')
			);
	  
			$result = $CI->db->insert('pembayaran_denda',$data);
			if($result) {
				$resp['type'] = 'error';
				$resp['error_code'] = '201';
				$resp['messages'] = 'Anda Terlambat: '.$lama.'Hari - Denda Sebesar: '.$total_denda;
				return json_encode($resp);
				exit;
			}
		}

		public function rupiah($nominal){
	
			$hasil_rupiah = "Rp " . number_format($nominal,2,',','.');
			return $hasil_rupiah;
		 
		}

		public function total_denda($denda){
	
			return sum($denda);
		 
		}

		public function  get_lama_pinjam($tgl_kembali,$tgl_harus_kembali) {
			$kembali = new DateTime($tgl_kembali);
			$hrs_kembali = new DateTime($tgl_harus_kembali);
			$lama = $hrs_kembali->diff($kembali)->format("%a");
			return $lama;
		}

		public function get_stok_opname() {
			$CI =& get_instance();
			$sql = "SELECT 
						a.stok_opname_id,
						a.nama_stok_opname,
						a.tgl_mulai,
						a.tgl_selesai ,
						a.nama_pembuat
					from stok_opname a
					WHERE a.is_active=1";
			$query = $CI->db->query($sql);
			if ($query->num_rows() > 0) {
				$data = $query->row();
				return $data;
				$CI->db->close();
			}
			return false;
		}







}