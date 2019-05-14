<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman extends MY_Controller {

  public $member_code;
  public $rule;
  public function __construct() {
    $this->member_code = $this->session->userdata('member_code');
    parent::__construct();
    $this->load->model("Peminjaman_qry",'peminjaman');
    $this->load->library('Aturan');
    $this->rule = $this->aturan->aturan_pinjam($this->member_code);
  }

  public function index() {
    $data['title'] = 'Peminjaman Buku';
    $this->load->view('templates/header', $data);
    if(!empty($this->member_code)) {
      $this->load->view('member_session.php',$data);
    } else {
      $this->load->view('index',$data);
    }
    $this->load->view('templates/footer');
  }

  public function find_member() {
    $member_code = isset($this->member_code) ? $this->member_code : $this->input->post('member_code');
    $result = $this->peminjaman->get_member_by_code($member_code);
    if(!$result) {
      $member_sess = array(
        'member_code'  => '',
        'nama_member'     => '',
        'tgl_lahir'  => '',
        'tgl_register'  => '',
        'tgl_expired'  => '',
      );
      $this->session->unset_userdata($member_sess);
      echo '404';
    } else {
      $member_sess = array(
        'member_code'  => $result->member_code,
        'nama_member'     => $result->nama_member,
        'tgl_lahir'  => $result->tgl_lahir,
        'tgl_register'  => $result->tgl_register,
        'tgl_expired'  => $result->tgl_expired,
      );
      $this->session->set_userdata($member_sess);
      $data['member'] = $result;
      $this->load->view('peminjaman',$data);
    }
  }

  public function pinjam_buku() {
    $item_code = $this->input->post('item_code');
    $member_code = $this->member_code;
    $result = $this->peminjaman->get_item_by_code($item_code);
    $tgl_pinjam = date('Y-m-d');
    $tgl_kembali = $this->aturan->get_tgl_kembali($tgl_pinjam,$this->rule->lama_pinjam);
    $jml_dipinjam  = count($this->peminjaman->get_item_by_member($member_code));

    if(!$result) {
      $resp['error_code'] = '404';
      $resp['messages'] = 'Data buku tidak tersedia';
      echo json_encode($resp);
      exit;
    } else {
      ########## ATURAN PEMINJAMAN ##########
      // Jika item tidak ada
      if($this->aturan->check_jml_item_dipinjam($item_code) >= $this->aturan->check_jml_item($item_code)) {
        $resp['error_code'] = '401';
        $resp['messages'] = 'Jumlah Eksemplar Habis!';
        echo json_encode($resp);
        exit;
      // Jika jumlah pinjam melebihi batas pinjam
      }else if($jml_dipinjam >= $this->rule->limit_pinjam) {
        $resp['error_code'] = '401';
        $resp['messages'] = 'Limit pinjam sudah habis!';
        echo json_encode($resp);
        exit;
      }
      $query = $this->peminjaman->simpan_pinjam_buku($member_code,$item_code,$tgl_pinjam,$tgl_kembali);
      if($query) {
        $resp['error_code'] = '201';
        $resp['messages'] = 'Buku berhasil dipinjam';
        echo json_encode($resp);
        exit;
      }
    }
  }

  public function remove_session() {
    $this->session->unset_userdata('member_code');
    redirect(base_url('peminjaman'));
  }



  public function pinjam() {
    $this->load->view('pinjam');
  }

  public function saat_ini() {
    $data['items'] = $this->peminjaman->get_item_by_member($this->member_code);
    if(!empty($data['items'])) {
      $this->load->view('saat_ini', $data);
    }
  }

  public function sejarah() {
    $data['items'] = $this->peminjaman->get_item_by_member_history($this->member_code);
    if(!empty($data['items'])) {
      $this->load->view('sejarah', $data);
    }

  }

}
