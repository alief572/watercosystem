<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Progress_order extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Progress_Order.View';
    protected $addPermission  	= 'Progress_Order.Add';
    protected $managePermission = 'Progress_Order.Manage';
    protected $deletePermission = 'Progress_Order.Delete';

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Spk_produksi/Inventory_4_model',
                                 'Aktifitas/aktifitas_model',
                                ));
        $this->template->title('Manage Data Supplier');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');


    }
    public function index()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$customer = $this->input->post('customer');
		
		if($customer!=''){
		
        $where  = array ('b.id_customer'=> $customer);
        $data = $this->db
                        ->select("  b.no_surat, 
                                    b.nama_customer AS namacustomer, 
									b.id_customer AS idcustomer, 
                                    a.id_dt_spkmarketing,
                                    a.no_alloy AS nmmaterial, 
                                    a.thickness, 
                                    a.width AS weight, 
                                    a.delivery, 
                                    a.qty_produk AS totalwidth
                                ")
                        ->from('dt_spkmarketing a')
                        ->join('tr_spk_marketing b','a.id_spkmarketing=b.id_spkmarketing','left')
                        ->join('dt_spk_aktual c','a.id_dt_spkmarketing=c.no_surat','left')
						->where($where)
                        ->get()
                        ->result();
						
		}
		else{
			
		 $data = $this->db
                        ->select("  b.no_surat, 
                                    b.nama_customer AS namacustomer, 
									b.id_customer AS idcustomer, 
                                    a.id_dt_spkmarketing,
                                    a.no_alloy AS nmmaterial, 
                                    a.thickness, 
                                    a.width AS weight, 
                                    a.delivery, 
                                    a.qty_produk AS totalwidth
                                ")
                        ->from('dt_spkmarketing a')
                        ->join('tr_spk_marketing b','a.id_spkmarketing=b.id_spkmarketing','left')
                        ->join('dt_spk_aktual c','a.id_dt_spkmarketing=c.no_surat','left')
						->get()
                        ->result();
		}
        
		$this->template->set('customer', $customer);
        $this->template->set('results', $data);
        $this->template->title('Progress Order');
        $this->template->render('index');
    }
	
	
	public function get_customer(){
	    $customer	= $this->db->query("SELECT * FROM master_customers")->result();	
		
		echo" <select id='customer' name='customer' class='form-control select' onchange='CariDetail()'>
			 <option value=''>Pilih Customer</option>";
			foreach($customer as $customer){
			echo"
			
			<option value='$customer->id_customer'>$customer->name_customer</option>
			";
			}
		echo"</select>";
	    
	
	}

    public function print_progress_order(){
		ob_clean();
		ob_start();
        $this->auth->restrict($this->managePermission);

		$customer = $this->uri->segment(3);
		
		if($customer!=''){
		$where  = array ('b.id_customer'=> $customer);
        $data['detail']  =   $this->db
                        ->select("  b.no_surat, 
                                    b.nama_customer AS namacustomer, 
									b.id_customer AS idcustomer, 
                                    a.id_dt_spkmarketing,
                                    a.no_alloy AS nmmaterial, 
                                    a.thickness, 
                                    a.width AS weight, 
                                    a.delivery, 
                                    a.qty_produk AS totalwidth
                                ")
                        ->from('dt_spkmarketing a')
                        ->join('tr_spk_marketing b','a.id_spkmarketing=b.id_spkmarketing','left')
                        ->join('dt_spk_aktual c','a.id_dt_spkmarketing=c.no_surat','left')
						->where($where)
                        ->get()
                        ->result();
		}
		else{
		$data['detail']  =   $this->db
                        ->select("  b.no_surat, 
                                    b.nama_customer AS namacustomer, 
									b.id_customer AS idcustomer, 
                                    a.id_dt_spkmarketing,
                                    a.no_alloy AS nmmaterial, 
                                    a.thickness, 
                                    a.width AS weight, 
                                    a.delivery, 
                                    a.qty_produk AS totalwidth
                                ")
                        ->from('dt_spkmarketing a')
                        ->join('tr_spk_marketing b','a.id_spkmarketing=b.id_spkmarketing','left')
                        ->join('dt_spk_aktual c','a.id_dt_spkmarketing=c.no_surat','left')
						->get()
                        ->result();	
		}

		$this->template->title('Data');
		$this->load->view('print_progress_order',$data);

		$html = ob_get_contents();
		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('L','A4','en',true,'UTF-8',array(2, 10, 2, 10));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('Progress_order '.date('YmdHis').'.pdf', 'I');
	}

	

}
