<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		/* AJAX check  */
		if ( $this->input->is_ajax_request()==FALSE) {
			/* special ajax here */
			redirect('buku');
		}
	}
	public function index()
	{
		redirect('buku');
	}
    public function pengarang()
    {
        $this->load->model('Ref_m');
        $pengarang = $this->Ref_m->ambil('pengarang');
        $output='<option></option>';
        foreach ($pengarang as $key => $value) {
            $output .= "<option value='".$value['pengarang_id']."'>".$value['nama_pengarang']."</option>";
        }
        echo $output;
    }
    public function cari_buku()
    {
        $q      = $this->input->get('q');
        $page   = $this->input->get('page');

        $this->load->model('biblio_m');
        $result = $this->biblio_m->cari($q);
        //print_r($result);
        foreach ($result as $key => $value) {
            $resp[] = array('judul'       => $value->judul,
                            'penerbit'  => $value->nama_penerbit,
                            //'gambar'    => $value->gambar,
                        );
        }
        $resp = array('total_count'     => count($resp),
                        'incomplete_results'    => false,
                        'items'         => $resp );
        header('Content-Type: application/json');
        print_r(json_encode($resp));
    }
	public function buku_datatable()
	{
		$this->load->model('datatable_buku');
        $list = $this->datatable_buku->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $buku) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $buku->judul;
            $row[] = $buku->isbn_issn;
            $row[] = $buku->nama_penerbit;
            $row[] = $buku->tahun_terbit;
            $row[] = $buku->call_number;
            $row[] = "<a href='".site_url('buku/form/edit?id_biblio='.$buku->biblio_id)."' class='btn btn-warning'> Edit <a><a href='".site_url('buku/detail?id_biblio='.$buku->biblio_id)."' class='btn btn-success'> Detail <a><a href='".site_url('buku/delete?id_biblio='.$buku->biblio_id)."' class='btn btn-danger'> Hapus <a>";
 
            $data[] = $row;
        } 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->datatable_buku->count_all(),
                        "recordsFiltered" => $this->datatable_buku->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
	}

	public function item_datatable()
	{
		$this->load->model('datatable_item');
        $list = $this->datatable_item->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $buku) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $buku->judul;
            $row[] = $buku->call_number;
            $row[] = $buku->kode_item;
            $row[] = $buku->nama_lokasi;
            $row[] = $buku->nama_rak;
            $row[] = $buku->asal;
            $row[] = "<a href='".site_url('buku/item/form/edit?id_item='.$buku->item_id)."' class='btn btn-warning'> Edit <a><a href='".site_url('buku/detail?id_item='.$buku->item_id)."' class='btn btn-success'> Detail <a><a href='".site_url('buku/delete?id_item='.$buku->item_id)."' class='btn btn-danger'> Hapus <a>";
 
            $data[] = $row;
        } 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->datatable_item->count_all(),
                        "recordsFiltered" => $this->datatable_item->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
	}
    public function popup()
    {
        $act    = $this->uri->segment(4);
        if ($act=='hapus') {
            $data['tabel']  = $this->input->get('tabel');
            $data['nama']   = $this->input->get('nama');
            $data['id']     = $this->input->get('id');
            
            $this->load->view('modal_delConfirm',$data);
        }elseif ($act=='tambah') {
            $data['tabel']  = $this->input->get('tabel');
            $data['action'] = $act;
            $this->load->view('modal_form'.$data['tabel'],$data);
        }elseif ($act=='edit') {
            $this->load->model('kategori_m');

            $data['tabel']  = $this->input->get('tabel');
            $data['action'] = $act;
            $data['id']     = $this->input->get('id');
            $data['kategori'] = $this->kategori_m->kategori_id($data['id']);

            $this->load->view('modal_form'.$data['tabel'],$data);
        }
    }
    public function hapus()
    {
        $tabel = $this->uri->segment(4);
        $id = $this->input->get('id');
        $this->load->model($tabel.'_m','model');
        if($this->model->hapus($id)){
            $resp = array('status'=>TRUE);
        }else{
            $resp = array('status'=>TRUE);
        }
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */