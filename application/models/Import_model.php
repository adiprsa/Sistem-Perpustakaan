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
				if($worksheet[$i]["A"] == "No" or $worksheet[$i]["A"] == ""){
				}else{					
					$data['hari_libur']  = $worksheet[$i]["B"];
					$data['tgl_libur']  = $worksheet[$i]["C"];
					$data['deskripsi']  = $worksheet[$i]["C"];
					$this->Db_model->add('hari_libur',$data);
				}	
			}
		}
		$msg = "Data berhasil disimpan";
		
		$status = "berhasil";
		$array = array('status' => $status, 'pesan' => $msg);
		return $array;
	}
	
	function import_bahasa($filename){
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
			$worksheet[1]["A"] != "No" OR $worksheet[1]["B"] != "Nama Bahasa")
			{
			$msg = "format salah";
		}else{
			for ($i=2; $i < ($numRows+1) ; $i++) { 
				if($worksheet[$i]["A"] == "No" or $worksheet[$i]["A"] == ""){
				}else{					
					$data['nama_bahasa']  = $worksheet[$i]["B"];
					$this->Db_model->add('bahasa',$data);
				}	
			}
		}
		$msg = "Data berhasil disimpan";
		
		$status = "berhasil";
		$array = array('status' => $status, 'pesan' => $msg);
		return $array;
	}
	
	function import_penerbit($filename){
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
			$worksheet[1]["A"] != "No" OR $worksheet[1]["B"] != "Nama Penerbit")
			{
			$msg = "format salah";
		}else{
			for ($i=2; $i < ($numRows+1) ; $i++) { 
				if($worksheet[$i]["A"] == "No" or $worksheet[$i]["A"] == ""){
				}else{					
					$data['nama_penerbit']  = $worksheet[$i]["B"];
					$this->Db_model->add('penerbit',$data);
				}	
			}
		}
		$msg = "Data berhasil disimpan";
		
		$status = "berhasil";
		$array = array('status' => $status, 'pesan' => $msg);
		return $array;
	}
	
	function import_pengarang($filename){
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
			$worksheet[1]["A"] != "No" OR $worksheet[1]["B"] != "Nama Pengarang" OR 
			$worksheet[1]["C"] != "Tahun Pengarang" OR $worksheet[1]["D"] != "Kata Kunci")
			{
			$msg = "format salah";
		}else{
			for ($i=2; $i < ($numRows+1) ; $i++) { 
				if($worksheet[$i]["A"] == "No" or $worksheet[$i]["A"] == ""){
				}else{					
					$data['nama_pengarang']  = $worksheet[$i]["B"];
					$data['tahun_pengarang']  = $worksheet[$i]["C"];
					$data['tipe_pengarang']  = 1;
					$data['kata_kunci']  = $worksheet[$i]["D"];
					$this->Db_model->add('pengarang',$data);
				}	
			}
		}
		$msg = "Data berhasil disimpan";
		
		$status = "berhasil";
		$array = array('status' => $status, 'pesan' => $msg);
		return $array;
	}
	
	
	

}

/* echo "<br>"; exit of file Phpexcel_model.php */
/* Location: ./application/models/Phpexcel_model.php */