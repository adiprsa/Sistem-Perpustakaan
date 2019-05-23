<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_opname_item extends MY_Controller {

  public $user;
  public $stok_opname;
  public function __construct() {
    $this->user = $this->session->userdata('nama_asli');
    parent::__construct();
    $this->load->model("Stok_opname_item_qry",'opname');
    $this->load->library('Aturan');
    $this->stok_opname = $this->aturan->get_stok_opname();
  }

  public function index() {
    $data['title'] = 'Transaksi Stok Opname';
    $data['status'] = $this->opname->get_item_status();
    $data['items'] = $this->opname->get_item($this->stok_opname->stok_opname_id);
    $this->load->view('templates/header', $data);
    $this->load->view('index',$data);
    $this->load->view('templates/footer');
  }

  public function items() {
    $data['items'] = $this->opname->get_item($this->stok_opname->stok_opname_id);
    if(!empty($data['items'])) {
      $this->load->view('items',$data);
    }
  }



  public function proses() {
    $item_code = $this->input->post('item_code');
    $status = $this->input->post('status');
    $proses = $this->opname->update_item($this->stok_opname->stok_opname_id,$item_code,$status);

    if($proses=='00000') {
        $resp['type'] = 'error';
        $resp['error_code'] = '401';
        $resp['messages'] = 'Data tidak ditemukan!';
        echo json_encode($resp);
        exit;
    } else if($proses=='ok') {
        $resp['type'] = 'success';
        $resp['error_code'] = '201';
        $resp['messages'] = 'Berhasil disimpan!';
        echo json_encode($resp);
        exit;
    } else {
        $resp['type'] = 'error';
        $resp['error_code'] = '500';
        $resp['messages'] = 'Terjadi Kegagalan menyimpan!';
        echo json_encode($resp);
        exit;
    }
  }


}
