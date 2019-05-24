<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model {

	var $table = 'member';
	var $column_order = array('member.nama_member','tipe_member.nama_tipe_member','member.nama_member','prodi.prodi'); //set column field database for datatable orderable
	var $column_search = array('member.nama_member','member.tipe_member_id','member.nama_member','prodi.prodi'); //set column field database for datatable searchable 
	var $order = array('member.member_id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{	
		$this->db->select('member.*,tipe_member.nama_tipe_member as nama_tipe_member, prodi.prodi as prodi');		
		$this->db->from($this->table);
		$this->db->join('tipe_member','member.tipe_member_id = tipe_member.tipe_member_id');
		$this->db->join('prodi','member.prodi_id = prodi.kd_prodi');
		$i = 0;	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
			//		$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				//if(count($this->column_search) - 1 == $i) //last loop
					//$this->db->group_end(); //close bracket
			}
			$i++;
		}		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{		
		$this->_get_datatables_query();		
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		//$this->db->from($this->table);
		$this->db->select('*');		
		$this->db->from($this->table);
		$this->db->join('tipe_member','member.tipe_member_id = tipe_member.tipe_member_id');
		$this->db->join('prodi','member.prodi_id = prodi.kd_prodi');
		return $this->db->count_all_results();
	}

	function import_member($filename){
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
			$worksheet[1]["B"] != "Nomor induk member" OR 
			$worksheet[1]["C"] != "Tipe member" OR 
			$worksheet[1]["D"] != "Nama member" OR 
			$worksheet[1]["E"] != "Jenis kelamin" OR
			$worksheet[1]["F"] != "Tanggal lahir" OR
			$worksheet[1]["G"] != "Alamat" OR
			$worksheet[1]["H"] != "E-mail" OR
			$worksheet[1]["I"] != "Fakultas" OR
			$worksheet[1]["J"] != "Jurusan" OR
			$worksheet[1]["K"] != "Tanggal register")
			{
			$msg = "format salah";
		}else{
			for ($i=2; $i < ($numRows+1) ; $i++) { 
				if($worksheet[$i]["A"] == "No" or $worksheet[$i]["A"] == ""){
				}else{					
					$data['member_code']  = $worksheet[$i]["B"];
					$data['tipe_member_id']  = $worksheet[$i]["C"];
					$data['nama_member']  = $worksheet[$i]["D"];
					$data['jenis_kelamin']  = $worksheet[$i]["E"];
					$data['tgl_lahir']  = $worksheet[$i]["F"];
					$data['alamat']  = $worksheet[$i]["G"];
					$data['email']  = $worksheet[$i]["H"];
					$data['fakultas']  = $worksheet[$i]["I"];
					$data['prodi']  = $worksheet[$i]["J"];
					$data['tgl_register']  = $worksheet[$i]["K"];
					$this->Db_model->add('member',$data);
				}	
			}
		}
		$msg = "Data berhasil disimpan";
		
		$status = "berhasil";
		$array = array('status' => $status, 'pesan' => $msg);
		return $array;
	}

}
