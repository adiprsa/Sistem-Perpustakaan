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
	public function modal_buku()
	{
		$data['act'] = $this->uri->segment(4);
		$this->load->view('modal_buku',$data);
	}
}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */