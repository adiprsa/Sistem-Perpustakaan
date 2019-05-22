<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		
		$tahun = date('Y');
		$bulan = date('m');
		$hari = date('d');
		
		$pinjaman_bulan = $this->Db_model->get('peminjaman','peminjaman_id',array('tgl_pinjam LIKE "%'.$tahun.'-'.$bulan.'%"' => null))->num_rows();
		$data['pinjaman_bulan'] = $pinjaman_bulan;
		$jumlah_member_bulan = $this->Db_model->get('member','member_id',array('tgl_register LIKE "%'.$tahun.'-'.$bulan.'%"' => null))->num_rows();
		$data['jumlah_member_bulan'] = $jumlah_member_bulan;
		$jumlah_member = $this->Db_model->get('member')->num_rows();
		$data['jumlah_member'] = $jumlah_member;
		$jumlah_denda_bulan = $this->Db_model->get('pembayaran_denda','SUM(total_denda) as denda',array('tgl_bayar LIKE "%'.$tahun.'-'.$bulan.'%"' => null))->row()->denda;
		$data['jumlah_denda_bulan'] = $jumlah_denda_bulan;
		
		$day = date('w');
		$tanggal_chart 		= array();	
		$grafik_pinjam 		= array();	
		$grafik_harus_balik = array();	
		$grafik_jadi_balik 	= array();	
		$zzzzzz = date('t');
		for($x=1;$x<=$zzzzzz;$x++){
			$tanggalku = date('Y-m-d', strtotime('+'.($x-$day).' days'));
			if($x<10){
				$x = "0".$x;
			}
			$tanggalku = date('Y')."-".date('m')."-".$x;
			$grafik_pinjam[] 		= $this->Db_model->get('peminjaman','peminjaman_id',array("tgl_pinjam" => $tanggalku))->num_rows();
			$grafik_harus_balik[] 	= $this->Db_model->get('peminjaman','peminjaman_id',array("tgl_harus_kembali" => $tanggalku))->num_rows();
			$grafik_jadi_balik[] 	= $this->Db_model->get('peminjaman','peminjaman_id',array("tgl_kembali" => $tanggalku))->num_rows();
			$tanggal_chart[] = $this->convertion->mysql_date_2_biasa($tanggalku);
		}
		$data['grafik_jadi_balik'] = $grafik_jadi_balik;
		$data['grafik_harus_balik'] = $grafik_harus_balik;
		$data['grafik_pinjam'] = $grafik_pinjam;
		$data['tanggal_chart'] = $tanggal_chart;
		
		// Store title
		$data['title'] = 'Halaman Dashboard';

		//Header
		$this->load->view('templates/header', $data);
		// Body
		$this->load->view('dashboard/main');
		// Footer
		$this->load->view('templates/footer');
	}
}
