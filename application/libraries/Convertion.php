<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Convertion {
	
	function get_neomart($id){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('data_pelanggan','nama_lengkap',array('id' => $id));
		if($q->num_rows()>0){
			return $q->row()->nama_lengkap;			
		}else{
			return "-";
		}
	}
	
	function sum_trx_neomart($id='-'){
		$CI = & get_instance();
		$where = "";
		if($id!='-'){
			$where = " AND id_neomart='".$id."'";
		}
		$CI->load->model('Db_model');
		$paid = $CI->Db_model->get('log_neomart','SUM(nominal) as total_nominal',"status = '1'".$where);
		$unpaid = $CI->Db_model->get('log_neomart','SUM(nominal) as total_nominal',"status = '0'".$where);
		
		return array('paid' => $paid->row()->total_nominal, 'unpaid' => $unpaid->row()->total_nominal);
	}
	
	function get_wallet_members(){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('data_pin_ref','SUM(wallet) as total_wallet',array('id_data >' => 1));
		return $q->row()->total_wallet;
	}
	
	function get_wallet_member(){
		$CI = & get_instance();
		$CI->db->select('data_pin_ref.wallet');
		$CI->db->from('data_pin_ref');
		$CI->db->where('userlevel.manajemen',0);
		$CI->db->where('user.status <',2);
		$CI->db->join('user','user.id = data_pin_ref.id_user');
		$CI->db->join('userlevel','user.userlevel = userlevel.id');
		$z = $CI->db->get();
		$wallet = 0;
		foreach($z->result() as $aa => $bb){
			$wallet = $wallet + $bb->wallet;
		}
		return $wallet;
	}
	
	function sisa_smss(){
		$url = "https://alpha.zenziva.net/apps/getbalance.php?userkey=0lxn7q&passkey=Neo123**";
		
		$ch  = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$data = curl_exec($ch);
		curl_close($ch);
		$zzz = json_decode($data);
		//print_r($zzz); 
		foreach($zzz as $a => $b){
			return $b;
			//print_r($b);
		}
	}
	
	function sisa_sms(){
		$url = "https://alpha.zenziva.net/apps/getbalance.php?userkey=0lxn7q&passkey=Neo123**";
		
		$ch  = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$data = curl_exec($ch);
		curl_close($ch);
		$zzz = json_decode($data);
	//	print_r($zzz);
//		exit;
		if(!isset($zzz)){
			return "-";
		}else{
			foreach($zzz as $a => $b){
				return $b;
			}
		}
	}
	
	function get_agama($jenis){
		switch ($jenis) {
            case '1' : return 'Islam';
                break;
            case '2' : return 'Kristen';
                break;
            case '3' : return 'Katholik';
                break;
            case '4' : return 'Hindu';
                break;
			case '5' : return 'Budha';
                break;
			case '6' : return 'Konghuchu';
                break;
			case '7' : return 'Penghayat Kepercayaan';
                break;
            default : return '-';
                break;
        }
	}
	
	function get_username_by_koderef($koderef){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		
		$a = $CI->Db_model->get('data_pin_ref','id_user,wallet',array('kode_ref' => $koderef));
		$username = $CI->Db_model->get('user','username,userlevel.userlevel',array('user.id' => $a->row()->id_user),'','','','',array('table'=> 'userlevel', 'on' => 'user.userlevel = userlevel.id'));
		//echo $this->db->last_query();
		//return $username;
		if($username->num_rows()>0){
			$nama_lengkap = $this->get_nama($a->row()->id_user);
			return $username->row()->username." | ".$nama_lengkap." | ".$username->row()->userlevel." | ".$this->rupiah($a->row()->wallet);
		}else{
			return $koderef;
		}
	}
	
	function get_iduser_by_koderef($koderef){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$a = $CI->Db_model->get('data_pin_ref','id_user',array('kode_ref' => $koderef));
		if($a->num_rows()<1){
			return 1;
		}else{
			return $a->row()->id_user;			
		}
	}
	//function	
	function cek_balance_post($x='0'){
        $username   = "082143202336";        
        $apikey     = "4245beceb85c64d6424";
		$password   = "candra";
		$ref_id     = rand(0,999999);
		$signature  = md5($username.$apikey.'bl');

		$json = '{
		         "commands" : "balance",
				"username" : "'.$username.'",
				"sign"     : "'.$signature.'"
		        }';

		$url = "https://api.mobilepulsa.net/v1/legacy/index";

		$ch  = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$data = curl_exec($ch);
		curl_close($ch);
		$zzz = json_decode($data);
		foreach ($zzz as $a => $b){
			return $b->balance;
		}					
    }
	
	
	function get_parent($id_user){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$z = $CI->Db_model->get('data_pin_ref','asal_ref',array('id_user' => $id_user))->row()->asal_ref;
		$zz = $CI->Db_model->get('data_pin_ref','id_user',array('kode_ref' => $z));
		if($zz->num_rows()>0){
			$username = $this->get_username($zz->row()->id_user);
		}else{
			$username = "superadmin";
		}
		return $username;
	}
	
	function get_nama($id_user){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$z = $CI->Db_model->get('user','ref',array('id' => $id_user))->row()->ref;
		$zz = $CI->Db_model->get('data_pelanggan','nama_lengkap',array('id' => $z));
		if($zz->num_rows()>0){
			$username = $zz->row()->nama_lengkap;
		}else{
			$username = "-";
		}
		return $username;
	}
	
	function get_total_member(){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$a = $CI->Db_model->get('data_pelanggan','id');
		return $a->num_rows();
	}
	
	function get_total_member_koperasi(){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$a = $CI->Db_model->get('user','id',array('userlevel IN (3,4,5,6,98)' => NULL));
		return $a->num_rows();
	}
	
	function get_curr_wallet($id_user){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$userlevel = $CI->Db_model->get('user','userlevel',array('id' => $id_user))->row()->userlevel;
		//echo $userlevel."<br>";
		$array_admin = array('1','2','101','102');
		if(in_array($userlevel,$array_admin)){
			$id_user = 1;
		}
		$q = $CI->Db_model->get('data_pin_ref','wallet',array('id_user' => $id_user));
		//echo $CI->db->last_query();
		return $q->row()->wallet;
		
	}
	
	function get_rekening_neo($id){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('rekening_neo','*',array('id' => $id));
		if($q->num_rows()<1){
			return "-";
		}else{
			return $q->row()->no_rek." - ".$q->row()->nama_bank." - ".$q->row()->atas_nama;			
		}
		
	}
	
	function get_hubungan($id_hubungan){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('status_hubungan','*',array('id' => $id_hubungan));
		if($q->num_rows() > 0){
		$x = $q->row()->status_hubungan;}else{
		$x = "";
		}
		return $x;
	}
	
	function iterasi_upline_jstree($kode_ref,$array_downline=array(),$counter='1'){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('data_pin_ref','id_user,kode_ref,asal_ref',array('kode_ref' => $kode_ref));
		//$array_downline = array();
		if($counter<6){			
			if($q->num_rows()>0){
				foreach($q->result() as $a => $b){
					$counter = $counter++;
					$data = array(	'text' => $CI->get_username_by_koderef($b->kode_ref),
									'state' => array('selected' => 'true' ),
									'children' => $CI->iterasi_upline_jstree($b->asal_ref,$array_downline,$counter));
					$array_downline[] = $data;
				}
					
			}else{
				
			}
		}
		return $array_downline;		
	}
	
	function get_userlevel($id='1'){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('userlevel','userlevel',array('id' => $id));
		return $q->row()->userlevel;
	}
	
	/*
	function get_userlevel_by_id($id='1'){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('user','userlevel',array('id' => $id));
		if($q->num_rows()>0){
			return $q->row()->userlevel;			
		}else{
			return 0;
		}
	}
	*/
	function get_userlevel_by_id($id='1'){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('user','userlevel',array('id' => $id));
		if($q->num_rows()>0){
			return $q->row()->userlevel;			
		}else{
			return 0;
		}
	}
	
	function get_nohp_by_id($id='1'){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('user','nohp',array('id' => $id));
		if($q->num_rows()>0){
			return $q->row()->nohp;			
		}else{
			return 0;
		}
	}
	
	function jenis_dokumen($i=1){
		if($i==1){
			return "Dokumen Syarat dan Ketentuan";
		}elseif($i==2){
			return "Kebijakan Privasi";			
		}elseif($i==3){
			return "FAQ";						
		}else{
			return "-";
		}
	}
	
	function get_username($id='1'){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('user','username',array('id' => $id));
		if($q->num_rows()>0){
			return $q->row()->username;			
		}else{
			return "-";
		}
	}
	
	function get_nama_lengkap($id='1'){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('user','ref',array('id' => $id))->row()->ref;
		$q = $CI->Db_model->get('data_pelanggan','nama_lengkap',array('id' => $q));
		if($q->num_rows()>0){
			return $q->row()->nama_lengkap;			
		}else{
			return "-";
		}
	}
	
	function get_koderef(){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$id_user = $CI->session->userdata('id_user');
		$z = $CI->Db_model->get('data_pin_ref','kode_ref',array('id_user' => $id_user));
		return $z->row()->kode_ref;
	}
	
	
	function get_koderef_by_id_user($id_user){
				$CI = & get_instance();
		$CI->load->model('Db_model');

		$z = $CI->Db_model->get('data_pin_ref','kode_ref',array('id_user' => $id_user));
		return $z->row()->kode_ref;
	}
	
	function get_koderef_upline_by_id_user($id_user){
				$CI = & get_instance();
		$CI->load->model('Db_model');

		$q = $CI->Db_model->get('data_pin_ref','asal_ref',array('id_user' => $id_user));
		if($q->num_rows()>0){
			return $q->row()->asal_ref;			
		}else{
			return 0;
		}
	}
	
	function create_koderef($id_user){
		$current = strtotime(date('Y-m-d H:i:s'));
		$kode_ref = strtoupper(dechex($current + $id_user));
		return $kode_ref;
	}
	
	function get_bank($id){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('master_bank','nama_bank',array('id_bank' => $id));
		return $q->row()->nama_bank;
	}
	
	function is_has_pin(){
		$CI = & get_instance();
		$id_user = $CI->session->userdata('id_user');
		$userlevel = $CI->session->userdata('userlevel');
		$array = array(1,2,101,102,103,104);
		if(in_array($userlevel,$array)){
			return true;
		}else{
			$data = array('id_user' => $id_user);
			$query = $CI->db->get_where('data_pin_ref', $data);
			if($query->row()->pin == ""){
				return false;
			}else{
				return true;			
			}			
		}
	}
	
	
	
	function is_has_data_pelanggan(){
		$CI = & get_instance();
		$id_user = $CI->session->userdata('id_user');
		$userlevel = $CI->session->userdata('userlevel');
		$array = array(1,2,101,102,103,104);
		if(in_array($userlevel,$array)){
		
			return true;
		}else{
			$ref = $CI->session->userdata('ref');
			if($ref == 0){
				return false;
			}else{
				return true;			
			}			
		}
	}
	
	function default_pekerjaan($id_pekerjaan){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('master_pekerjaan','*',array('id_pekerjaan' => $id_pekerjaan));
		if($q->num_rows()<1){
			return "-";
		}else{
			return $q->row()->pekerjaan;			
		}
	}
	
	function default_bank($id_bank){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('master_bank','*',array('id_bank' => $id_bank));
		return $q->row()->nama_bank;
	}
	
	function get_wallet(){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$id_user = $CI->session->userdata('id_user');
		$q = $CI->Db_model->get('data_pin_ref','wallet',array('id_user' => $id_user));
		if($q->num_rows()<1){
			return 0;
		}else{
			return $q->row()->wallet;			
		}
	}
	
	function mysql_date_2_views($datetime){
		$timestamp = strtotime($datetime);
		//$day = $this->konversi_hari(date('D', $timestamp));
		
		$date = explode(' ',$datetime)[0];
		$time = explode(' ',$datetime)[1];
//		print_r($date);
		$tgl = explode('-',$date)[2];
		$bulan = $this->konversi_bulan(explode('-',$date)[1]);
		$tahun = explode('-',$date)[0];
		$tanggal_waktu = "$tgl $bulan $tahun $time";
		//$tanggal_waktu = "$tgl $bulan $tahun";
		return $tanggal_waktu;  
	}
	
	function datetime_no_time($datetime){
		$timestamp = strtotime($datetime);
		//$day = $this->konversi_hari(date('D', $timestamp));
		
		$date = explode(' ',$datetime)[0];
		$time = explode(' ',$datetime)[1];
		$tgl = explode('-',$date)[2];
//		$bulan = $this->konversi_bulan(explode('-',$date)[1]);
		$bulan = (explode('-',$date)[1]);
		$tahun = explode('-',$date)[0];
		$tanggal_waktu = "$tgl-$bulan-$tahun";
		return $tanggal_waktu;  
	}
	
	function mysql_date_2_date($date){
		$tgl = explode('-',$date)[2];
		$bulan = $this->konversi_bulan(explode('-',$date)[1]);
		$tahun = explode('-',$date)[0];
		$tanggal_waktu = "$tgl $bulan $tahun";
		//$tanggal_waktu = "$tgl $bulan $tahun";
		if($tahun=='0000'){
			return "-";
		}else{
			return $tanggal_waktu;  			
		}
	}
	
	function konversi_bulan($bulan){
		switch ($bulan) {
            case '01' : return 'Januari';
                break;
            case '02' : return 'Februari';
                break;
            case '03' : return 'Maret';
                break;
            case '04' : return 'April';
                break;
			case '05' : return 'Mei';
                break;
			case '06' : return 'Juni';
                break;
			case '07' : return 'Juli';
                break;
			case '08' : return 'Agustus';
                break;
			case '09' : return 'September';
                break;
			case '10' : return 'Oktober';
                break;
			case '11' : return 'November';
                break;
			case '12' : return 'Desember';
                break;
            default : return '-';
                break;
        }
	}
	
	function status_ppob($status){
		switch ($status) {
            case '0' : return 'Sukses';
                break;
            case '1' : return 'Gagal, sudah terbayar';
                break;
            case '2' : return 'Gagal bayar';
                break;
            case '3' : return 'Invalid Ref ID';
                break;
			case '4' : return 'Billing ID Expired';
                break;
			case '5' : return 'Gagal';
                break;
			case '6' : return 'Inquiry ID Tak ditemukan';
                break;
			case '7' : return 'Transaksi Gagal';
                break;
            default : return '-';
                break;
        }
	}
	
	function konversi_hari($hari){
		switch ($hari) {
            case 'Sun' : return 'Ahad';
                break;
            case 'Mon' : return 'Senin';
                break;
            case 'Tue' : return 'Selasa';
                break;
            case 'Wed' : return 'Rabu';
                break;
			case 'Thu' : return 'Kamis';
                break;
			case 'Fri' : return 'Jum`at';
                break;
			case 'Sat' : return 'Sabtu';
                break;
            default : return '-';
                break;
        }
	}
	
	function normal_2_mysql($dates){
		$date	= explode(' ',$dates)[0];
		$time	= explode(' ',$dates)[1];
		$tgl	= explode('-',$date);
		return $tgl[2]."-".$tgl[1]."-".$tgl[0]." ".$time;
	}
	
	function normal2mysql($dates){
		$tgl	= explode('-',$dates);
		return $tgl[2]."-".$tgl[1]."-".$tgl[0];
	}
	
	function mysql2normal($dates){
		$tgl	= explode('-',$dates);
		return $tgl[2]."-".$tgl[1]."-".$tgl[0];
		//return $tgl;
	}
	
	
	
	
	function mysql_date_2_biasa($datetime){
		$timestamp = strtotime($datetime);
		//$day = $this->konversi_hari(date('D', $timestamp));
		
		$date = explode(' ',$datetime)[0];
		//$time = explode(' ',$datetime)[1];
//		print_r($date);
		$tgl = explode('-',$date)[2];
		$bulan = $this->konversi_bulan(explode('-',$date)[1]);
		$tahun = explode('-',$date)[0];
		$tanggal_waktu = "$tgl $bulan $tahun";
		//$tanggal_waktu = "$tgl $bulan $tahun";
		return $tanggal_waktu;  
	}
	
	function rupiah($rp){
		return "Rp. ".number_format($rp,2,",",".");		
	}
	
	function rupiahs($rp){
		return "".number_format($rp,0,",",".");		
	}
	
	
	function mysql_datetime_2_view($datetime){
		$timestamp = strtotime($datetime);
		$day = $this->konversi_hari(date('D', $timestamp));
		
		$date = explode(' ',$datetime)[0];
		$time = explode(' ',$datetime)[1];
//		print_r($date);
		$tgl = explode('-',$date)[2];
		$bulan = $this->konversi_bulan(explode('-',$date)[1]);
		$tahun = explode('-',$date)[0];
		$tanggal_waktu = "$day, $tgl $bulan $tahun  <span>$time</span> WIB";
		return $tanggal_waktu; 
	}
	
	function get_jenis_ppob($jenis){
		switch ($jenis) {
            case '0' : return 'Pulsa';
                break;
            case '1' : return 'PDAM';
                break;
            case '2' : return 'TELKOM';
                break;
            case '3' : return 'PLN';
                break;
			case '4' : return 'BPJS';
                break;
			
			//case '5' : return 'Multifinance';
			case '5' : return 'Token PLN';
                break;
			case '7' : return 'Game';
                break;
            default : return '-';
                break;
        }
	}
	
	function get_last_wallet_user($id_trx,$kode_trx,$user_trx){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('trx_duit','wallet_akhir',array('id_jenis' => $id_trx, 'jenis' => $kode_trx, 'id_user_owner' => $user_trx));
		if($q->num_rows() > 0){
			return $q->row()->wallet_akhir;
		}else{
			return 0;
		}
	}
	
	function get_email_by_id_user($id_user){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('user','email',array('id' => $id_user, 'status' => 1))->row();
		if($q!=null){
			return $q->email;
		}else{
			return false;
		}
	}
	
	function get_nohp_by_id_user($id_user){
		$CI = & get_instance();
		$CI->load->model('Db_model');
		$q = $CI->Db_model->get('user','nohp',array('id' => $id_user, 'status' => 1))->row();
		if($q!=null){
			return $q->nohp;
		}else{
			return false;
		}
	}
	
	function get_bagihasil($rupiah,$periode){
		$return = 0;
		if($rupiah>=10000000 AND $rupiah<50000000){
			if($periode==1){
				$return = $rupiah*3.5*0.01;
			}elseif($periode==2){
				//$return = $rupiah*3.6*0.01;				
			}elseif($periode==3){
				$return = $rupiah*3.7*0.01;				
			}elseif($periode==4){
				$return = $rupiah*3.8*0.01;								
			}elseif($periode==5){
				$return = $rupiah*3.9*0.01;												
			}else{
				$return = 0;
			}
		}elseif($rupiah>=50000000 AND $rupiah<100000000){
			if($periode==1){
				$return = $rupiah*3.6*0.01;
			}elseif($periode==2){
				$return = $rupiah*3.7*0.01;
			}elseif($periode==3){
				$return = $rupiah*3.8*0.01;				
			}elseif($periode==4){
				$return = $rupiah*3.9*0.01;								
			}elseif($periode==5){
				$return = $rupiah*4*0.01;												
			}else{
				$return = 0;
			}
		}elseif($rupiah>=100000000 AND $rupiah<200000000){
			if($periode==1){
				$return = $rupiah*3.7*0.01;
			}elseif($periode==2){
				$return = $rupiah*3.8*0.01;
			}elseif($periode==3){
				$return = $rupiah*3.9*0.01;				
			}elseif($periode==4){
				$return = $rupiah*4*0.01;								
			}elseif($periode==5){
				$return = $rupiah*4.1*0.01;												
			}else{
				$return = 0;
			}
		}elseif($rupiah>=200000000 AND $rupiah<300000000){
			if($periode==1){
				$return = $rupiah*3.8*0.01;
			}elseif($periode==2){
				$return = $rupiah*3.9*0.01;
			}elseif($periode==3){
				$return = $rupiah*4*0.01;				
			}elseif($periode==4){
				$return = $rupiah*4.1*0.01;								
			}elseif($periode==5){
				$return = $rupiah*4.2*0.01;												
			}else{
				$return = 0;
			}
		}elseif($rupiah>=300000000 AND $rupiah<500000000){
			if($periode==1){
				$return = $rupiah*3.9*0.01;
			}elseif($periode==2){
				$return = $rupiah*4*0.01;
			}elseif($periode==3){
				$return = $rupiah*4.1*0.01;				
			}elseif($periode==4){
				$return = $rupiah*4.2*0.01;								
			}elseif($periode==5){
				$return = $rupiah*4.3*0.01;												
			}else{
				$return = 0;
			}
		}elseif($rupiah>=500000000){
			if($periode==1){
				$return = $rupiah*4*0.01;
			}elseif($periode==2){
				$return = $rupiah*4.1*0.01;
			}elseif($periode==3){
				$return = $rupiah*4.2*0.01;				
			}elseif($periode==4){
				$return = $rupiah*4.3*0.01;								
			}elseif($periode==5){
				$return = $rupiah*4.4*0.01;												
			}else{
				$return = 0;
			}
		}
		return $return;
	}
	
}
