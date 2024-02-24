<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Xtes extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
		$data='aaa';
		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($data);
		ob_end_clean();
		$html2pdf->Output('aaa.pdf');
	}

    public function vpdf($id) {
		ob_start();
		$data='aaa';
		$this->load->view('view',$data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('aaa.pdf', 'I');
	}
}

