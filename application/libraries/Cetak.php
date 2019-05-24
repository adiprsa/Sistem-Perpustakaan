<?php if ( !defined('BASEPATH')) exit();
class Cetak
{
    function __construct()
    {
    	$this->_ci = &get_instance();
        $this->_ci->load->library('fpdf');
    }

	function kodeItem($kodeItem)
	{
	  if (isset($kodeItem)) {
		//print_r($pasien);
		//$this->_ci->fpdf('P','cm','legal');
		$this->_ci->fpdf->SetMargins(1,1);
		$this->_ci->fpdf->AddPage('L',array(60,30));
		$this->_ci->fpdf->SetAutoPageBreak(false);
		$this->_ci->fpdf->SetFont('Arial','B',15);
		$this->_ci->fpdf->Image(base_url()."assets/barcode.php?text=".$kodeItem,2,2,55,15,'PNG');
		$this->_ci->fpdf->SetY(20);
		$this->_ci->fpdf->Cell(60,10, $kodeItem, 0, 1, 'C', false);
		$this->_ci->fpdf->Output('temp/kode_item_'.$this->_ci->session->userdata('username').'.pdf','F');
	  }else{
	  	//$this->_ci->fpdf->fpdf('P','cm','legal');

		$this->_ci->fpdf->SetMargins(10,5,10);
		$this->_ci->fpdf->AddPage('L',array(85,55));
		$this->_ci->fpdf->SetFont('Arial','BU',15);
		$this->_ci->fpdf->Cell(8, 0.75, "DATA TIDAK ADA", '0', '1', 'L', false);

		$this->_ci->fpdf->Output('temp/kode_item_'.$this->_ci->session->userdata('username').'.pdf','F');

	  }
	}
	function callnumber($callnumber)
	{
	  if (isset($callnumber)) {
		//print_r($callnumber);
		//$this->_ci->fpdf('P','cm','legal');
		$this->_ci->fpdf->SetMargins(5,5);
		$this->_ci->fpdf->AddPage('L',array(150,70));
		$this->_ci->fpdf->SetAutoPageBreak(false);
		$this->_ci->fpdf->SetFont('Arial','',12);
		$componen = explode('/', $callnumber);
		$this->_ci->fpdf->Cell(50,10, '', 0, 0, 'C', false);
		$this->_ci->fpdf->MultiCell(50,7.5, 'Perpustakaan
			UDINUS' , 1, 'C', false);

		$this->_ci->fpdf->Cell(50,10, '', 0, 0, 'C', false);
		$this->_ci->fpdf->Cell(50,10, $componen[0], 0, 1, 'C', false);
		$this->_ci->fpdf->Cell(50,10, '', 0, 0, 'C', false);
		$this->_ci->fpdf->Cell(50,10, strtoupper($componen[1]), 0, 1, 'C', false);
		$this->_ci->fpdf->Cell(50,10, '', 0, 0, 'C', false);
		$this->_ci->fpdf->Cell(50,10, $componen[2], 0, 1, 'C', false);

		$this->_ci->fpdf->SetXY(55,5);
		$this->_ci->fpdf->Cell(50,50, '', 1, 1, 'C', false);

		$this->_ci->fpdf->Output('temp/callnumber_'.$this->_ci->session->userdata('username').'.pdf','F');
	  }else{
	  	//$this->_ci->fpdf->fpdf('P','cm','legal');

		$this->_ci->fpdf->SetMargins(10,5,10);
		$this->_ci->fpdf->AddPage('L',array(85,55));
		$this->_ci->fpdf->SetFont('Arial','BU',15);
		$this->_ci->fpdf->Cell(8, 0.75, "DATA TIDAK ADA", '0', '1', 'L', false);

		$this->_ci->fpdf->Output('temp/callnumber_'.$this->_ci->session->userdata('username').'.pdf','F');

	  }
	}
}
