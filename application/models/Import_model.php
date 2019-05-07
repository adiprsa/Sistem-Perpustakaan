<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_model extends CI_Model {
	
	public function __construct()
	{
            parent::__construct();
			
            if ($this->session->userdata('username')==null){
                    redirect('login');
            }            
            $this->load->model(array('Db_model'));
			$this->load->library(array('PHPExcel','convertion'));
            //$this->load->library(array('pagination','option','convertion','upload'));
			//$this->load->helper(array('form', 'url','directory','file')); 
	}
	
	
	
	function import_libur($filename){
		ini_set('memory_limit', '-1');
        $inputFileName = 'uploads/xls/'.$filename;
//		echo $inputFileName;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);
		$status = "gagal";
		$line_kosong 		= array();
		$line_bermasalah 	= array();
		$data_isi = array();
		//$msg = "Data Berhasil dihapus";
		if(
			$worksheet[1]["A"] != "No" OR $worksheet[1]["B"] != "Tanggal" OR 
			$worksheet[1]["C"] != "Deskripsi")
			{
			$msg = "format salah";
		}else{
			for ($i=2; $i < ($numRows+1) ; $i++) { 
				if($worksheet[$i]["A"] == "NO" or $worksheet[$i]["A"] == ""){
				
				}else{					
					$libur['tgl_libur'] 		= $worksheet[$i]["B"];
					$libur['hari_libur'] 		= $worksheet[$i]["C"];
					$this->Db_model->add('hari_libur',$libur);
				}	
			}
		}
		$msg = "Data berhasil disimpan";
		
		$status = "berhasil";
		$array = array('status' => $status, 'pesan' => $msg);
		return $array;
	}
	public function upload_data_pencapaian($filename){
		ini_set('memory_limit', '-1');
        $inputFileName = 'uploads/xls/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);
		$total_line = count($worksheet)-3;
		$msg = "Data Berhasil disimpan";
		if(	$worksheet[1]["A"] != "No" OR $worksheet[1]["B"] != "Username" OR $worksheet[1]["C"] != "Upline")
			{
			$msg = "Kolom A => ".$worksheet[1]["A"]."<br>
					Kolom B => ".$worksheet[1]["B"]."<br>
					Kolom C => ".$worksheet[1]["C"]."<br>
					";
		}else{
			for ($i=2; $i < ($numRows+1) ; $i++) { 
				if($worksheet[$i]["A"] == "No" or $worksheet[$i]["A"] == ""){
				}else{
					//echo $filename."<br>";
					$user['username']	= strtolower($worksheet[$i]["B"]);
					$user['password']	= sha1(sha1(md5($worksheet[$i]["D"])));
					$user['email']	= $worksheet[$i]["R"];
					$user['nohp']	= "0".$worksheet[$i]["M"];
					$user['userlevel']	= $worksheet[$i]["S"];
					$user['tanggal_reg']	= date('Y-m-d');
					$user['status']	= 1;
					
					if($this->Db_model->add('user',$user)){
						$id_user = $this->db->insert_id();
						
					}
					
					$datapinref['asal_ref'] = $this->get_kode_ref_by_username(strtolower($worksheet[$i]["C"]));
					$datapinref['id_user'] 	= $id_user;
					$datapinref['kode_ref'] = $this->convertion->create_koderef($id_user);
					$this->Db_model->add('data_pin_ref',$datapinref);
					
					if($worksheet[$i]["E"]!=""){
						$pelanggan['nama_lengkap'] 	= $worksheet[$i]["E"];
						$pelanggan['jk'] 			= $worksheet[$i]["G"];
						$pelanggan['jenis_keanggotaan'] = 1;
						$pelanggan['agama'] 		= $worksheet[$i]["H"];
						$pelanggan['tempat_lahir'] 	= explode(',' , $worksheet[$i]["U"])[0];
						/*
						$tanggal_lahir = explode(',' , $worksheet[$i]["U"])[1];
						$strtotime = str_replace('(','',$tanggal_lahir);
						$strtotime = str_replace(')','',$strtotime);
						$strtotime = strtotime($strtotime);
						*/
						$pelanggan['tempat_lahir'] 	= explode(',' , $worksheet[$i]["U"])[0];
						$pelanggan['alamat_rumah'] 	= $worksheet[$i]["J"];
						$pelanggan['nama_usaha'] 	= isset($worksheet[$i]["K"]) ? $worksheet[$i]["K"] : '-';
						$pelanggan['id_pekerjaan'] 	= $worksheet[$i]["I"];
						$pelanggan['income'] 		= $worksheet[$i]["L"];
						$pelanggan['approved'] 		= 1;
						//echo "hasem";
						if($this->Db_model->add('data_pelanggan',$pelanggan)){
							$id_pelanggan = $this->db->insert_id();
							$this->Db_model->update('user',array('ref' => $id_pelanggan),array('id' => $id_user));
						}
						
						
						//rekening
						$rekening['id_pelangan']	= $id_pelanggan;
						$rekening['id_bank']		= $worksheet[$i]["N"];
						$rekening['no_rekening']	= isset($worksheet[$i]["O"]) ? $worksheet[$i]["O"] : '-';
						$rekening['nama_rekening']	= isset($worksheet[$i]["P"]) ? $worksheet[$i]["P"] : '-';;
						$rekening['cabang']			= isset($worksheet[$i]["Q"]) ? $worksheet[$i]["Q"] : '-';
						$rekening['status']			= 1;
						$this->Db_model->add('data_rekening',$rekening);
						
					}
				}	
			}
			
			
		}
		
			return $msg;
	}
		
	function delete_user($filename){
		ini_set('memory_limit', '-1');
        $inputFileName = 'uploads/xls/'.$filename;
//		echo $inputFileName;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);
		$status = "gagal";
		$line_kosong 		= array();
		$line_bermasalah 	= array();
		$data_isi = array();
		//$msg = "Data Berhasil dihapus";
		if(
			$worksheet[1]["A"] != "No" OR $worksheet[1]["B"] != "Username" OR 
			$worksheet[1]["C"] != "Email" OR $worksheet[1]["D"] != "Level" OR 
			$worksheet[1]["E"] != "KETERANGAN")
			{
			$msg = "format salah";
		}else{
			for ($i=2; $i < ($numRows+1) ; $i++) { 
				if($worksheet[$i]["A"] == "NO" or $worksheet[$i]["A"] == ""){
				}else{					
					$userlevel  = $worksheet[$i]["D"];
					$email 		= $worksheet[$i]["C"];
					$username 	= $worksheet[$i]["B"];
					$where = array('username' => $username, 'email' => $email, 'userlevel' => $userlevel);
					$z = $this->Db_model->get('user','user.*,data_pin_ref.*',$where,'','','','',array('table' => 'data_pin_ref', 'on' => 'data_pin_ref.id_user = user.id', 'pos' => 'left'));
					if($z->num_rows()>0){
						$z = $z->row();
						$id_user = $z->id_user;
						$deleted_user	= array(
													'id_user' => $z->id_user,
													'username' => $z->username,
													'ref' => $z->ref,
													'userlevel' => $z->userlevel,
													'email' => $z->email,
													'password' => $z->password,
													'nohp' => $z->nohp,
													'tanggal_member' => $z->tanggal_member,
													'tanggal_reg' => $z->tanggal_reg,
													'asal_ref' => $z->asal_ref,
													'pin' => $z->pin,
													'kode_ref' => $z->kode_ref,
													'wallet' => $z->wallet,
													'poin' => $z->poin,
												);
						if($this->Db_model->add('deleted_user',$deleted_user)){
							$this->Db_model->delete('user',array('id' => $id_user));
							$this->Db_model->delete('data_pin_ref',array('id_user' => $id_user));
						}						
					}
				}	
			}
		}
		$msg = "Data berhasil dihapus";
		
		$status = "berhasil";
		$array = array('status' => $status, 'pesan' => $msg);
		return $array;
	}
	

}

/* echo "<br>"; exit of file Phpexcel_model.php */
/* Location: ./application/models/Phpexcel_model.php */