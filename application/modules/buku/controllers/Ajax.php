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
            $row[] = $buku->lokasi;
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
}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */