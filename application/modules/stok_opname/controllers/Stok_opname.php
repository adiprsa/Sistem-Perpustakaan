<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_opname extends MY_Controller {

    public $url;
    public $link_add;
    public $link_edit;
    public $link_save;
    public $link_delete;

    public function __construct() {
        $this->url = 'stok_opname';
        $this->link_add = $this->url.'/add';
        $this->link_edit = $this->url.'/edit';
        $this->link_save = $this->url.'/save';
        $this->link_delete = $this->url.'/delete';

        parent::__construct();
        $this->load->model("Stok_opname_qry",'opname');
    }

    public function index() {
        $data['items'] = $this->opname->get_stok_opname();
        $data['title'] = 'Stok Opname';
        $data['link_add'] = $this->link_add;
        $this->load->view('templates/header', $data);
        $this->load->view('index',$data);
        $this->load->view('templates/footer');
    }

    public function add() {
        $data['title'] = 'Tambah Stok Opname';
        $data['link_save'] = $this->link_save;
        $this->load->view('templates/header', $data);
        $this->load->view('add',$data);
        $this->load->view('templates/footer');
    }
    public function save() {
        $id = $this->input->post('id');
        $nama_stok_opname = $this->input->post('nama_stok_opname');
        $tgl_mulai = $this->input->post('tgl_mulai');
        $tgl_selesai = $this->input->post('tgl_selesai');
        $pembuat = $this->input->post('pembuat');

        $save = $this->opname->save_data($id,$nama_stok_opname,$tgl_mulai,$tgl_selesai,$pembuat);
        if($save) {
            $resp['type'] = 'success';
            $resp['error_code'] = '201';
            $resp['messages'] = 'Data berhasil disimpan';
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

    public function edit() {
        $id = $this->uri->segment(3);
        $data['item'] = $this->opname->get_stok_opname_by_id($id);
        if($data['item'] <> '') {
            $data['title'] = 'Edit Stok Opname';
            
            $this->load->view('templates/header', $data);
            $this->load->view('edit',$data);
            $this->load->view('templates/footer');
        } else {
            redirect($this->url);
        }
        
    }

    public function delete() {
        $id = $this->uri->segment(3);
        $save = $this->opname->delete($id);
        if($save) {
            redirect('stok_opname');
        }
    }
    
}
