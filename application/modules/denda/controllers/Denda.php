<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Denda extends MY_Controller {

  public $member_code;
  public $member_id;
  public $rule;
  public function __construct() {
    $this->member_code = $this->session->userdata('member_code');
    $this->member_id = $this->session->userdata('member_id');

    parent::__construct();
    $this->load->model("Denda_qry",'denda');
    $this->load->library('Aturan');
    $this->rule = $this->aturan->aturan_pinjam($this->member_code);
  }

  public function index() {
    $data['title'] = 'Denda Peminjaman';
    $data['items'] = $this->denda->get_denda_by_member($this->member_code);
    $this->load->view('templates/header', $data);
    if(!empty($this->member_code)) {
      $this->load->view('member_session.php',$data);
    } else {
      $this->load->view('index',$data);
    }
    $this->load->view('templates/footer');
  }

  public function find_member() {
    $data['items'] = $this->denda->get_denda_by_member($this->member_code);
    $member_code = isset($this->member_code) ? $this->member_code : $this->input->post('member_code');
    $result = $this->denda->get_member_by_code($member_code);
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
      $this->load->view('denda',$data);
    }
  }

  public function bayar() {
    $tagihan_id = $this->input->post('id');
    $result = $this->denda->bayar_denda($tagihan_id);
    if($result) {
      $resp['error_code'] = '201';
        $resp['messages'] = 'Pembayaran Denda Berhasil!';
        echo json_encode($resp);
        exit;
    }
  }

  public function remove_session() {
    $this->session->unset_userdata('member_code');
    redirect(base_url('denda'));
  }


  public function sejarah() {
    $data['items'] = $this->denda->get_history_denda_by_member($this->member_code);
    if(!empty($data['items'])) {
      $this->load->view('sejarah', $data);
    }

  }

}
