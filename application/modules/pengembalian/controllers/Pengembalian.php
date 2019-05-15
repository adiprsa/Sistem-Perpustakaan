<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pengembalian extends MY_Controller {

  public $member_code;
  public $member_id;
  public $rule;
  public function __construct() {
    $this->member_code = $this->session->userdata('member_code');
    $this->member_id = $this->session->userdata('member_id');

    parent::__construct();
    $this->load->model("Pengembalian_qry",'pengembalian');
    $this->load->library('Aturan');
    $this->rule = $this->aturan->aturan_pinjam($this->member_code);
  }

  public function index() {
    $data['title'] = 'pengembalian Buku';
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
    $result = $this->pengembalian->get_member_by_code($member_code);
    if(!$result) {
      $member_sess = array(
        'member_code'  => '',
        'nama_member'     => '',
        'member_id' => '',
        'tgl_lahir'  => '',
        'tgl_register'  => '',
        'tgl_expired'  => '',
      );
      $this->session->unset_userdata($member_sess);
      echo '404';
    } else {
      $member_sess = array(
        'member_code'  => $result->member_code,
        'member_id'  => $result->member_id,
        'nama_member'     => $result->nama_member,
        'tgl_lahir'  => $result->tgl_lahir,
        'tgl_register'  => $result->tgl_register,
        'tgl_expired'  => $result->tgl_expired,
      );
      $this->session->set_userdata($member_sess);
      $data['member'] = $result;
      $this->load->view('pengembalian',$data);
    }
  }

  public function return_buku() {
    $item_code = $this->input->post('item_code');
    $member_code = $this->member_code;
    $result = $this->pengembalian->get_item_pinjam($item_code,$this->member_id);
    if($result) {
      // $tgl_kembali = date('Y-m-d');
      $tgl_kembali = '2019-05-30';
      $tgl_harus_kembali = $result->tgl_harus_kembali;
      $denda_perhari = $this->rule->denda_perhari;
      // Jika tgl kembali > tangal kembali kena denda
      if ($tgl_kembali > $tgl_harus_kembali) {
          $this->aturan->create_tagihan($result->peminjaman_id,$tgl_kembali,$tgl_harus_kembali,$denda_perhari);
      } 
      $return = $this->pengembalian->return_book($result->peminjaman_id,$tgl_kembali);
      if($return){
        $resp['error_code'] = '201';
          $resp['messages'] = 'Buku Berhasil Dikembalikan!';
          echo json_encode($resp);
          exit;
      }
    } else {
      $resp['error_code'] = '404';
        $resp['messages'] = 'Kode Buku tidak tersedia';
        echo json_encode($resp);
        exit;
    }
  }

  public function remove_session() {
    $this->session->unset_userdata('member_code');
    redirect(base_url('pengembalian'));
  }

  public function pinjam() {
    $this->load->view('pinjam');
  }

  public function saat_ini() {
    $data['items'] = $this->pengembalian->get_item_by_member($this->member_code);
    if(!empty($data['items'])) {
      $this->load->view('saat_ini', $data);
    }
  }

  public function sejarah() {
    $data['items'] = $this->pengembalian->get_item_by_member_history($this->member_code);
    if(!empty($data['items'])) {
      $this->load->view('sejarah', $data);
    }

  }

}
