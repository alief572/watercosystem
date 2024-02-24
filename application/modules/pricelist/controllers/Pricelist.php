<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Ichsan
 * @copyright Copyright (c) 2019, Ichsan
 *
 * This is controller for Master Supplier
 */

class Pricelist extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Pricelist.View';
    protected $addPermission  	= 'Pricelist.Add';
    protected $managePermission = 'Pricelist.Manage';
    protected $deletePermission = 'Pricelist.Delete';

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Pricelist/Inventory_4_model',
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
		$deleted = '0';
        $data = $this->Inventory_4_model->get_data('ms_inventory_category1','deleted',$deleted);
        $this->template->set('results', $data);
        $this->template->title('Pricelist');
        $this->template->render('index');
    }
		public function detailfr()
    {
		$id_category1 = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->Inventory_4_model->get_data_categoryfr($id_category1);
        $this->template->set('results', $data);
        $this->template->title('PRICELIST FERROUS');
        $this->template->render('listfr');
    }
			public function detailnfr()
    {
		$id_category1 = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
		$data = $this->Inventory_4_model->get_data_categorynfr($id_category1);
        $this->template->set('results', $data);
        $this->template->title('PRICELIST NON FERROUS');
        $this->template->render('listnfr');
    }
		public function editPricelistfr($id)
    {
		$id_category1 = 'I2000001';
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inventory_3 = $this->Inventory_4_model->get_data_category($id_category1);
		$pl = $this->Inventory_4_model->get_data('ms_pricelistfr','id_pricelistfr',$id);
		$scrp = '1';
		$cgs = '2';
		$operati = '3';
		$inter = '4';
		$scrap = $this->Inventory_4_model->get_data('ms_rate_ferreous','id_rate',$scrp);
		$cogs = $this->Inventory_4_model->get_data('ms_rate_ferreous','id_rate',$cgs);
		$operating_cost = $this->Inventory_4_model->get_data('ms_rate_ferreous','id_rate',$operati);
		$interest = $this->Inventory_4_model->get_data('ms_rate_ferreous','id_rate',$inter);
		$data = [
			'scrap'=> $scrap,
			'cogs'=> $cogs,
			'operating_cost'=> $operating_cost,
			'interest'=> $interest,
			'inventory_3' => $inventory_3,
			'pl' => $pl,
			
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Inventory');
        $this->template->render('edit_pricelistfr');

    }
	public function editPricelistnfr($id)
    {
		$id_category1 = 'I2000002';
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inventory_3 = $this->Inventory_4_model->get_data_category($id_category1);
		$pl = $this->Inventory_4_model->get_data('ms_pricelistnfr','id_pricelistnfr',$id);
		$scrp = '1';
		$cgs = '2';
		$operati = '3';
		$inter = '4';
		$scrap = $this->Inventory_4_model->get_data('ms_rate','id_rate',$scrp);
		$cogs = $this->Inventory_4_model->get_data('ms_rate','id_rate',$cgs);
		$operating_cost = $this->Inventory_4_model->get_data('ms_rate','id_rate',$operati);
		$interest = $this->Inventory_4_model->get_data('ms_rate','id_rate',$inter);
		$data = [
			'inventory_3' => $inventory_3,
			'pl' => $pl,
			'scrap' => $scrap,
			'cogs' => $cogs,
			'operating_cost' => $operating_cost,
			'interest' => $interest
			
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Inventory');
        $this->template->render('edit_pricelistnfr');

    }
	public function viewPricelistnfr($id)
    {
		$id_category1 = 'I2000002';
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inventory_3 = $this->Inventory_4_model->get_data_category($id_category1);
		$pl = $this->Inventory_4_model->get_viewnfr($id);
		$data = [
			'inventory_3' => $inventory_3,
			'pl' => $pl,
			
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Inventory');
        $this->template->render('view_pricelistnfr');

    }
	public function viewPricelistfr($id)
    {
		$id_category1 = 'I2000001';
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inventory_3 = $this->Inventory_4_model->get_data_category($id_category1);
		$pl = $this->Inventory_4_model->get_data('ms_pricelistfr','id_pricelistfr',$id);
		$data = [
			'inventory_3' => $inventory_3,
			'pl' => $pl,
			
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Inventory');
        $this->template->render('view_pricelistfr');

    }
	public function copyInventory($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inven = $this->Inventory_4_model->getedit($id);
		$komposisiold = $this->Inventory_4_model->get_data('child_inven_compotition','id_category3',$id);
		$komposisi = $this->Inventory_4_model->kompos($id);
		$dimensiold = $this->Inventory_4_model->get_data('child_inven_dimensi','id_category3',$id);
		$dimensi = $this->Inventory_4_model->dimensy($id);
		$supl = $this->Inventory_4_model->supl($id);
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Inventory_4_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Inventory_4_model->get_data('ms_inventory_category2','deleted',$deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk');
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier');
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$dt_suplier = $this->Inventory_4_model->get_data('child_inven_suplier','id_category3',$id);
		$data = [
			'inventory_1' => $inventory_1,
			'inventory_2' => $inventory_2,
			'inventory_3' => $inventory_3,
			'komposisi' => $komposisi,
			'dimensi' => $dimensi,
			'id_bentuk' => $id_bentuk,
			'inven' => $inven,
			'maker' => $maker,
			'supl' => $supl,
			'id_surface' => $id_surface,
			'id_supplier' => $id_supplier,
			'dt_suplier' => $dt_suplier
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('copy_inventory');

    }
	public function viewInventory($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inven = $this->Inventory_4_model->getedit($id);
		$komposisiold = $this->Inventory_4_model->get_data('child_inven_compotition','id_category3',$id);
		$komposisi = $this->Inventory_4_model->kompos($id);
		$dimensiold = $this->Inventory_4_model->get_data('child_inven_dimensi','id_category3',$id);
		$dimensi = $this->Inventory_4_model->dimensy($id);
		$supl = $this->Inventory_4_model->supl($id);
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Inventory_4_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Inventory_4_model->get_data('ms_inventory_category2','deleted',$deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk');
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier');
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$dt_suplier = $this->Inventory_4_model->get_data('child_inven_suplier','id_category3',$id);
		$data = [
			'inventory_1' => $inventory_1,
			'inventory_2' => $inventory_2,
			'inventory_3' => $inventory_3,
			'komposisi' => $komposisi,
			'dimensi' => $dimensi,
			'id_bentuk' => $id_bentuk,
			'inven' => $inven,
			'maker' => $maker,
			'supl' => $supl,
			'id_surface' => $id_surface,
			'id_supplier' => $id_supplier,
			'dt_suplier' => $dt_suplier
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('view_inventory');

    }
	public function viewBentuk($id){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$bentuk = $this->db->get_where('ms_bentuk',array('id_bentuk' => $id))->result();
		$dimensi = $this->Bentuk_model->getDimensi($id);
		$data = [
			'bentuk' => $bentuk,
			'dimensi' => $dimensi,
		];
        $this->template->set('results', $data);
		$this->template->render('view_bentuk');
	}
	
	
		public function addPricelistfr($id_category1)
    {
		$id_category1 = $this->input->post('id_category1');
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$inventory_3 = $this->Inventory_4_model->get_data_category($id_category1);
		$scrp = '1';
		$cgs = '2';
		$operati = '3';
		$inter = '4';
		$scrap = $this->Inventory_4_model->get_data('ms_rate_ferreous','id_rate',$scrp);
		$cogs = $this->Inventory_4_model->get_data('ms_rate_ferreous','id_rate',$cgs);
		$operating_cost = $this->Inventory_4_model->get_data('ms_rate_ferreous','id_rate',$operati);
		$interest = $this->Inventory_4_model->get_data('ms_rate_ferreous','id_rate',$inter);
		$data = [
			'inventory_3' => $inventory_3,
			'scrap' => $scrap,
			'cogs' => $cogs,
			'operating_cost' => $operating_cost,
			'interest' => $interest
		];
        $this->template->set('results', $data);
        $this->template->title('Add Pricelist');
        $this->template->render('add_pricelistfr');

    }
	
			public function refPricelistfr($id_category1)
    {
		$id_category1 = $this->input->post('id_category1');
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$inventory_3 = $this->Inventory_4_model->get_data_category($id_category1);
		$scrp = '1';
		$cgs = '2';
		$operati = '3';
		$inter = '4';
		$scrap = $this->Inventory_4_model->get_data('ms_rate_ferreous','id_rate',$scrp);
		$cogs = $this->Inventory_4_model->get_data('ms_rate_ferreous','id_rate',$cgs);
		$operating_cost = $this->Inventory_4_model->get_data('ms_rate_ferreous','id_rate',$operati);
		$interest = $this->Inventory_4_model->get_data('ms_rate_ferreous','id_rate',$inter);
		$data = [
			'inventory_3' => $inventory_3,
			'scrap' => $scrap,
			'cogs' => $cogs,
			'operating_cost' => $operating_cost,
			'interest' => $interest
		];
        $this->template->set('results', $data);
        $this->template->title('Add Pricelist');
        $this->template->render('refresh_pricelistfr');

    }

		public function addPricelistnfr($id_category1)
    {
		$id_category1 = $this->input->post('id_category1');
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$inventory_3 = $this->Inventory_4_model->get_data_category($id_category1);
		$scrp = '1';
		$cgs = '2';
		$operati = '3';
		$inter = '4';
		$scrap = $this->Inventory_4_model->get_data('ms_rate','id_rate',$scrp);
		$cogs = $this->Inventory_4_model->get_data('ms_rate','id_rate',$cgs);
		$operating_cost = $this->Inventory_4_model->get_data('ms_rate','id_rate',$operati);
		$interest = $this->Inventory_4_model->get_data('ms_rate','id_rate',$inter);
		$data = [
			'inventory_3' => $inventory_3,
			'scrap' => $scrap,
			'cogs' => $cogs,
			'operating_cost' => $operating_cost,
			'interest' => $interest
		];
        $this->template->set('results', $data);
        $this->template->title('Add Pricelist');
        $this->template->render('add_pricelistnfr');

    }
			public function refPricelistnfr($id_category1)
    {
		$id_category1 = $this->input->post('id_category1');
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$inventory_3 = $this->Inventory_4_model->get_data_category($id_category1);
		$scrp = '1';
		$cgs = '2';
		$operati = '3';
		$inter = '4';
		$scrap = $this->Inventory_4_model->get_data('ms_rate','id_rate',$scrp);
		$cogs = $this->Inventory_4_model->get_data('ms_rate','id_rate',$cgs);
		$operating_cost = $this->Inventory_4_model->get_data('ms_rate','id_rate',$operati);
		$interest = $this->Inventory_4_model->get_data('ms_rate','id_rate',$inter);
		$data = [
			'inventory_3' => $inventory_3,
			'scrap' => $scrap,
			'cogs' => $cogs,
			'operating_cost' => $operating_cost,
			'interest' => $interest
		];
        $this->template->set('results', $data);
        $this->template->title('Add Pricelist');
        $this->template->render('refresh_pricelistnfr');

    }
	function hitungbottomfr()
    {
        $book_price=$_GET['book_price'];
		$persentase_bookprice = $book_price/100;
		$scrap=$_GET['scrap'];
		$cogs=$_GET['cogs'];
		$operating_cost=$_GET['operating_cost'];
		$interest=$_GET['interest'];
		$profit=$_GET['profit'];
		$persentase_scrap = $scrap*$persentase_bookprice;
		$persentase_cogs = $cogs*$persentase_bookprice;
		$persentase_operating_cost = $operating_cost*$persentase_bookprice;
		$persentase_interest = $interest*$persentase_bookprice;
		$persentase_profit = $profit*$persentase_bookprice;
		$bottom_price = $book_price+$persentase_scrap+$persentase_cogs+$persentase_operating_cost+$persentase_interest+$persentase_profit;
		echo "
		<input type='text' class='form-control' id='bottom_price' value='$bottom_price' required name='bottom_price' placeholder='Bottom price (Rp/kg)'>
		";
	}
			function hitungbottomnfr1()
    {
        $book_price=$_GET['book_price'];
		$scrap=$_GET['scrap'];
		$scrappersen = $book_price*$scrap/100;
		$cogs=$_GET['cogs'];
		$cogspersen = $book_price*$cogs/100;
		$operating_cost=$_GET['operating_cost'];
		$operating_costpersen = $book_price*$operating_cost/100;
		$interest=$_GET['interest'];
		$interestpersen = $book_price*$interest/100;
		$profit=$_GET['profit'];
		$profitpersen = $book_price*$profit/100;
		$vix = number_format($book_price+$scrappersen+$cogspersen+$operating_costpersen+$interestpersen+$profitpersen,2);
		echo"<input type='text' class='form-control' id='bottom_price1' value='$vix' required name='bottom_price1' placeholder='Bottom Price (Rp/kg)' >";
	}
			function hitungbottomnfr101()
    {
        $book_price=$_GET['lme10'];
		$scrap=$_GET['scrap'];
		$scrappersen = $book_price*$scrap/100;
		$cogs=$_GET['cogs'];
		$cogspersen = $book_price*$cogs/100;
		$operating_cost=$_GET['operating_cost'];
		$operating_costpersen = $book_price*$operating_cost/100;
		$interest=$_GET['interest'];
		$interestpersen = $book_price*$interest/100;
		$profit=$_GET['profit10'];
		$profitpersen = $book_price*$profit/100;
		$vix10 = number_format($book_price+$scrappersen+$cogspersen+$operating_costpersen+$interestpersen+$profitpersen,2);
		echo"<input type='text' class='form-control' id='bottom_price101' value='$vix10' required name='bottom_price101' placeholder='Bottom Price (Rp/kg)' >";
	}
			function hitungbottomnfr301()
    {
        $book_price=$_GET['lme30'];
		$scrap=$_GET['scrap'];
		$scrappersen = $book_price*$scrap/100;
		$cogs=$_GET['cogs'];
		$cogspersen = $book_price*$cogs/100;
		$operating_cost=$_GET['operating_cost'];
		$operating_costpersen = $book_price*$operating_cost/100;
		$interest=$_GET['interest'];
		$interestpersen = $book_price*$interest/100;
		$profit=$_GET['profit30'];
		$profitpersen = $book_price*$profit/100;
		$vix30 = number_format($book_price+$scrappersen+$cogspersen+$operating_costpersen+$interestpersen+$profitpersen,2);
		echo"<input type='text' class='form-control' id='bottom_price301' value='$vix30' required name='bottom_price301' placeholder='Bottom Price (Rp/kg)' >";
	}
	function hitungbottomnfrspot1()
    {
        $book_price=$_GET['lmespot'];
		$scrap=$_GET['scrap'];
		$scrappersen = $book_price*$scrap/100;
		$cogs=$_GET['cogs'];
		$cogspersen = $book_price*$cogs/100;
		$operating_cost=$_GET['operating_cost'];
		$operating_costpersen = $book_price*$operating_cost/100;
		$interest=$_GET['interest'];
		$interestpersen = $book_price*$interest/100;
		$profit=$_GET['profitspot'];
		$profitpersen = $book_price*$profit/100;
		$vix30 = number_format($book_price+$scrappersen+$cogspersen+$operating_costpersen+$interestpersen+$profitpersen,2);
		echo"<input type='text' class='form-control' id='bottom_pricespot1' value='$vix30' required name='bottom_pricespot1' placeholder='Bottom Price (Rp/kg)' >";
	}
		function hitungbottomnfr()
    {
        $book_price=$_GET['book_price'];
		$scrap=$_GET['scrap'];
		$scrappersen = $book_price*$scrap/100;
		$cogs=$_GET['cogs'];
		$cogspersen = $book_price*$cogs/100;
		$operating_cost=$_GET['operating_cost'];
		$operating_costpersen = $book_price*$operating_cost/100;
		$interest=$_GET['interest'];
		$interestpersen = $book_price*$interest/100;
		$profit=$_GET['profit'];
		$profitpersen = $book_price*$profit/100;
		$vix = $book_price+$scrappersen+$cogspersen+$operating_costpersen+$interestpersen+$profitpersen;
		echo"<input type='text' class='form-control' id='bottom_price' value='$vix' required name='bottom_price' placeholder='Bottom Price (Rp/kg)' >";
	}
			function hitungbottomnfr10()
    {
        $book_price=$_GET['lme10'];
		$scrap=$_GET['scrap'];
		$scrappersen = $book_price*$scrap/100;
		$cogs=$_GET['cogs'];
		$cogspersen = $book_price*$cogs/100;
		$operating_cost=$_GET['operating_cost'];
		$operating_costpersen = $book_price*$operating_cost/100;
		$interest=$_GET['interest'];
		$interestpersen = $book_price*$interest/100;
		$profit=$_GET['profit10'];
		$profitpersen = $book_price*$profit/100;
		$vix10 = $book_price+$scrappersen+$cogspersen+$operating_costpersen+$interestpersen+$profitpersen;
		echo"<input type='text' class='form-control' id='bottom_price10' value='$vix10' required name='bottom_price10' placeholder='Bottom Price (Rp/kg)' >";
	}
			function hitungbottomnfr30()
    {
        $book_price=$_GET['lme30'];
		$scrap=$_GET['scrap'];
		$scrappersen = $book_price*$scrap/100;
		$cogs=$_GET['cogs'];
		$cogspersen = $book_price*$cogs/100;
		$operating_cost=$_GET['operating_cost'];
		$operating_costpersen = $book_price*$operating_cost/100;
		$interest=$_GET['interest'];
		$interestpersen = $book_price*$interest/100;
		$profit=$_GET['profit30'];
		$profitpersen = $book_price*$profit/100;
		$vix30 = $book_price+$scrappersen+$cogspersen+$operating_costpersen+$interestpersen+$profitpersen;
		echo"<input type='text' class='form-control' id='bottom_price30' value='$vix30' required name='bottom_price30' placeholder='Bottom Price (Rp/kg)' >";
	}
	function hitungbottomnfrspot()
    {
        $book_price=$_GET['lmespot'];
		$scrap=$_GET['scrap']/100;
		
		$scrappersen = $book_price*$scrap;
		$cogs=$_GET['cogs']/100;
		$cogspersen = $book_price*$cogs;
		$operating_cost=$_GET['operating_cost']/100;
		$operating_costpersen = $book_price*$operating_cost;
		$interest=$_GET['interest']/100;
		$interestpersen = $book_price*$interest;
		$profit=$_GET['profitspot']/100;
		$profitpersen = $book_price*$profit;
		$vix30 = $book_price+$scrappersen+$cogspersen+$operating_costpersen+$interestpersen+$profitpersen;
		echo"<input type='text' class='form-control' id='bottom_pricespot' value='$vix30' required name='bottom_pricespot' placeholder='Bottom Price (Rp/kg)' >";
	}
		function caribookpricefr()
    {
        $id_category3=$_GET['id_category3'];
		$bookprice	= $this->db->query("SELECT * FROM ms_bookprice_material WHERE id_category3 = '$id_category3' ")->result();
		$nilai=$bookprice[0]->nilai_bookprice;
		echo"<input type='text' class='form-control' id='book_price'  required name='book_price' placeholder='Book Price (Rp/kg)' value='$nilai'>";
	}
	
	
		function hitungharganfr()
    {
        $id_category3=$_GET['id_category3'];
		$bookprice	= $this->db->query("SELECT * FROM ms_bookprice_material WHERE id_category3 = '$id_category3' ")->result();
		$nilai_bookprice =$bookprice[0]->nilai_bookprice;
		$kandungancu	= $this->db->query("SELECT AVG(nilai_compotition) as nilai_compotition FROM child_inven_compotition WHERE id_category3='$id_category3' AND id_compotition='13' ")->result();
		$kandunganzn	= $this->db->query("SELECT AVG(nilai_compotition) as nilai_compotition FROM child_inven_compotition WHERE id_category3='$id_category3' AND id_compotition='14' ")->result();
		$kandungansn	= $this->db->query("SELECT AVG(nilai_compotition) as nilai_compotition FROM child_inven_compotition WHERE id_category3='$id_category3' AND id_compotition='15' ")->result();
		$kandunganni	= $this->db->query("SELECT AVG(nilai_compotition) as nilai_compotition FROM child_inven_compotition WHERE id_category3='$id_category3' AND id_compotition='16' ")->result();
		$kandunganag	= $this->db->query("SELECT AVG(nilai_compotition) as nilai_compotition FROM child_inven_compotition WHERE id_category3='$id_category3' AND id_compotition='17' ")->result();
		$kandunganal	= $this->db->query("SELECT AVG(nilai_compotition) as nilai_compotition FROM child_inven_compotition WHERE id_category3='$id_category3' AND id_compotition='18' ")->result();
		$persencu = $kandungancu[0]->nilai_compotition/100;
		$persenzn = $kandunganzn[0]->nilai_compotition/100;
		$persensn = $kandungansn[0]->nilai_compotition/100;
		$persenni = $kandunganni[0]->nilai_compotition/100;
		$persenag = $kandunganag[0]->nilai_compotition/100;
		$persenal = $kandunganal[0]->nilai_compotition/100;
		$dolar	= $this->db->query("SELECT * FROM mata_uang WHERE kode='USD' ")->result();
		$kurs = $dolar[0]->kurs;
		$hariini = date('Y-m-d');
		$kemarin = mktime(0,0,0,date('n'),date('j')-1,date('Y'));
		$yesterday = date("Y-m-d", $sepuluh_hari);
		$sepuluh_hari = mktime(0,0,0,date('n'),date('j')-14,date('Y'));
		$tendays = date("Y-m-d", $sepuluh_hari);
		$sebulan = mktime(0,0,0,date('n'),date('j')-30,date('Y'));
		$tirtydays = date("Y-m-d", $sebulan);
		$tglnow = date('d');
		$blnnow = date('m');
		if ($blnnow != '1'){ 
		$blnkmrn = $blnnow-1;
		$yearkemaren = date('Y');
		}else{
		$blnkmrn = "12";
		$yearnow = date('Y');
		$yearkemaren = $yearnow-1;
		}
		$lme_10haricu	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$yesterday' AND id_compotition='13' ")->result();
		$lme_10harizn	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN 	'$tendays' AND '$yesterday' AND id_compotition='14' ")->result();
		$lme_10harisn	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$yesterday' AND id_compotition='15' ")->result();
		$lme_10harini	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$yesterday' AND id_compotition='16' ")->result();
		$lme_10hariag	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$yesterday' AND id_compotition='17' ")->result();
		$lme_10harial	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$yesterday' AND id_compotition='18' ")->result();
		$lme_30haricu	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren'  AND id_compotition='13' ")->result();
		$lme_30harizn	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren'  AND id_compotition='14' ")->result();
		$lme_30harisn	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren'  AND id_compotition='15' ")->result();
		$lme_30harini	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren'  AND id_compotition='16' ")->result();
		$lme_30hariag	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren'  AND id_compotition='17' ")->result();
		$lme_30harial	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren'  AND id_compotition='18' ")->result();
		$lme_spotcu	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='13' ")->result();
		$lme_spotzn	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='14' ")->result();
		$lme_spotsn	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='15' ")->result();
		$lme_spotni	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='16' ")->result();
		$lme_spotag	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='17' ")->result();
		$lme_spotal	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='18' ")->result();
		$cu10 = $lme_10haricu[0]->nominal/1000;
		$zn10 = $lme_10harizn[0]->nominal/1000;
		$sn10 = $lme_10harisn[0]->nominal/1000;
		$ni10 = $lme_10harini[0]->nominal/1000;
		$ag10 = $lme_10hariag[0]->nominal/1000;
		$al10 = $lme_10harial[0]->nominal/1000;
		$cu30 = $lme_30haricu[0]->nominal/1000;
		$zn30 = $lme_30harizn[0]->nominal/1000;
		$sn30 = $lme_30harisn[0]->nominal/1000;
		$ni30 = $lme_30harini[0]->nominal/1000;
		$ag30 = $lme_30hariag[0]->nominal/1000;
		$al30 = $lme_30harial[0]->nominal/1000;
		$cuspot = $lme_spotcu[0]->nominal/1000;
		$znspot = $lme_spotzn[0]->nominal/1000;
		$snspot = $lme_spotsn[0]->nominal/1000;
		$nispot = $lme_spotni[0]->nominal/1000;
		$agspot = $lme_spotag[0]->nominal/1000;
		$alspot = $lme_spotal[0]->nominal/1000;
		$cu10fix = $cu10*$persencu;
		$zn10fix = $zn10*$persenzn;
		$sn10fix = $sn10*$persensn;
		$ni10fix = $ni10*$persenni;
		$ag10fix = $ag10*$persenag;
		$al10fix = $al10*$persenal;
		$cu30fix = $cu30*$persencu;
		$zn30fix = $zn30*$persenzn;
		$sn30fix = $sn30*$persensn;
		$ni30fix = $ni30*$persenni;
		$ag30fix = $ag30*$persenag;
		$al30fix = $al30*$persenal;
		$cuspotfix = $cuspot*$persencu;
		$znspotfix = $znspot*$persenzn;
		$snspotfix = $snspot*$persensn;
		$nispotfix = $nispot*$persenni;
		$agspotfix = $agspot*$persenag;
		$alspotfix = $alspot*$persenal;
		$lme10 = $cu10fix+$zn10fix+$sn10fix+$ni10fix+$ag10fix+$al10fix;
		$lme30 = $cu30fix+$zn30fix+$sn30fix+$ni30fix+$ag30fix+$al30fix;
		$lmespot = $cuspotfix+$znspotfix+$snspotfix+$nispotfix+$agspotfix+$alspotfix;
		$lme101 = number_format($cu10fix+$zn10fix+$sn10fix+$ni10fix+$ag10fix+$al10fix,2);
		$lme301 = number_format($cu30fix+$zn30fix+$sn30fix+$ni30fix+$ag30fix+$al30fix,2);
		$lmespot1 = number_format($cuspotfix+$znspotfix+$snspotfix+$nispotfix+$agspotfix+$alspotfix,2);
		echo "
		<th>Harga Satuan</th>
		<td><input type='text' class='form-control' id='book_price' value='$nilai_bookprice' required name='book_price' placeholder='Book Price (Rp/kg)' ></td>
		<td><input type='text' class='form-control' id='lme101'  value='$lme101'  readonly required name='lme101' placeholder='Book Price ($/kg)' ></td>
		<td><input type='text' class='form-control' id='lme301' value='$lme301' readonly required name='lme301' placeholder='Book Price ($/kg)' ></td>
		<td><input type='text' class='form-control' id='lmespot1' value='$lmespot1' readonly required name='lmespot1' placeholder='Book Price ($/kg)' ></td>
		<td hidden><input type='text' class='form-control' id='lme10'  value='$lme10'  readonly required name='lme10' placeholder='Book Price ($/kg)' ></td>
		<td hidden><input type='text' class='form-control' id='lme30' value='$lme30' readonly required name='lme30' placeholder='Book Price ($/kg)' ></td>
		<td hidden><input type='text' class='form-control' id='lmespot' value='$lmespot' readonly required name='lmespot' placeholder='Book Price ($/kg)' ></td>
		";
	}
	
	public function delDetail(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		// print_r($id);
		// exit();
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		
		$this->db->trans_begin();
		$this->db->where('id_dimensi',$id)->update("ms_dimensi",$data);
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);
	}

	public function deleteInventory(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];
		
		$this->db->trans_begin();
		$this->db->where('id_category3',$id)->update("ms_inventory_category3",$data);
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);
	}
		function get_inven2()
    {
        $inventory_1=$_GET['inventory_1'];
        $data=$this->Inventory_4_model->level_2($inventory_1);
        echo "<select id='inventory_2' name='hd1[1][inventory_2]' class='form-control onchange='get_inv3()'  input-sm select2'>";
        echo "<option value=''>--Pilih--</option>";
                foreach ($data as $key => $st) :
				      echo "<option value='$st->id_category1' set_select('inventory_2', $st->id_category1, isset($data->id_category1) && $data->id_category1 == $st->id_category1)>$st->nama
                    </option>";
                endforeach;
        echo "</select>";
    }
		function get_inven3()
    {
        $inventory_2=$_GET['inventory_2'];
        $data=$this->Inventory_4_model->level_3($inventory_2);
		
        // print_r($data);
        // exit();
        echo "<select id='inventory_3' name='hd1[1][inventory_3]' class='form-control input-sm select2'>";
        echo "<option value=''>--Pilih--</option>";
                foreach ($data as $key => $st) :
				      echo "<option value='$st->id_category2' set_select('inventory_3', $st->id_category2, isset($data->id_category2) && $data->id_category2 == $st->id_category2)>$st->nama
                    </option>";
                endforeach;
        echo "</select>";
    }
		public function saveNewPricelistfr()
    {
        $this->auth->restrict($this->addPermission);
        $this->auth->restrict($this->addPermission);
		
		$post = $this->input->post();
		$id_bentuk = $post['inven1'];
		$id_category3 = $post['id_category3'];
		$cek_kat3	= $this->db->query("SELECT * FROM ms_pricelistfr WHERE id_category3 = '$id_category3' ")->result();
		if(!empty($cek_kat3)){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Harga Produk Tersebut Sudah Ada',
			  'code' => $id_bentuk,
			  'status'	=> 0
			);
		} else{
		$code = $this->Inventory_4_model->generate_codefr();
		$this->db->trans_begin();
		$data = [
							'id_pricelistfr'		=> $code,
							'id_category3'			=> $post['id_category3'],
							'book_price'			=> $post['book_price'],
							'scrap'					=> $post['scrap'],
							'cogs'					=> $post['cogs'],
							'operating_cost'		=> $post['operating_cost'],
							'interest'				=> $post['interest'],
							'profit'				=> $post['profit'],
							'bottom_price'			=> $post['bottom_price'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
               $this->db->insert('ms_pricelistfr',$data);		
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 1
			);			
		}
				};
  		echo json_encode($status);


    }
	public function saveNewPricelistnfr()
    {
        $this->auth->restrict($this->addPermission);
        $this->auth->restrict($this->addPermission);
		
		$post = $this->input->post();
		$id_bentuk = $post['inven1'];
				$id_category3 = $post['id_category3'];
		$cek_kat3	= $this->db->query("SELECT * FROM ms_pricelistnfr WHERE id_category3 = '$id_category3' ")->result();
		if(!empty($cek_kat3)){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Harga Produk Tersebut Sudah Ada',
			  'code' => $id_bentuk,
			  'status'	=> 0
			);
		} else{
		$code = $this->Inventory_4_model->generate_codenfr();
		$this->db->trans_begin();
		$data = [
							'id_pricelistnfr'		=> $code,
							'id_category3'			=> $post['id_category3'],
							'book_price'			=> $post['book_price'],
							'lme10'					=> $post['lme10'],
							'lme30'					=> $post['lme30'],
							'lmespot'				=> $post['lmespot'],
							'scrap'					=> $post['scrap'],
							'cogs'					=> $post['cogs'],
							'operating_cost'		=> $post['operating_cost'],
							'interest'				=> $post['interest'],
							'profit'				=> $post['profit'],
							'profit10'				=> $post['profit10'],
							'profit30'				=> $post['profit30'],
							'profitspot'			=> $post['profitspot'],
							'bottom_price'			=> $post['bottom_price'],
							'bottom_price10'		=> $post['bottom_price10'],
							'bottom_price30'		=> $post['bottom_price30'],
							'bottom_pricespot'		=> $post['bottom_pricespot'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
               $this->db->insert('ms_pricelistnfr',$data);		
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 1
			);			
		}
		};
  		echo json_encode($status);

    }
	public function saveRefreshPricelistnfr()
    {
        $this->auth->restrict($this->addPermission);
		
		$post = $this->input->post();
		$id_bentuk = $post['inven1'];
		$this->db->trans_begin();
		$this->db->empty_table('ms_pricelistnfr');
		$numb4 =0;
		foreach($_POST['plnfr'] as $nfr){
		$code = $this->Inventory_4_model->generate_codenfr();
		$numb4++;	   
              $dms =  array(
							'id_pricelistnfr'		=> $code,
							'id_category3'=>$nfr[id_category3],
							'book_price'=>$nfr[book_price],
							'lme10'=>$nfr[lme10],
							'lme30'=>$nfr[lme30],
							'lmespot'=>$nfr[lmespot],
							'profit'=>$nfr[profit],
							'profit10'=>$nfr[profit10],
							'profit30'=>$nfr[profit30],
							'profitspot'=>$nfr[profitspot],
							'bottom_price'=>$nfr[bottom_price],
							'bottom_price10'=>$nfr[bottom_price10],
							'bottom_price30'=>$nfr[bottom_price30],
							'bottom_pricespot'=>$nfr[bottom_pricespot],
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('ms_pricelistnfr',$dms);
			
		    }			
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 1
			);			
		}
  		echo json_encode($status);

    }
	public function saveRefreshPricelistfr()
    {
        $this->auth->restrict($this->addPermission);
		
		$post = $this->input->post();
		$id_bentuk = $post['inven1'];
		$this->db->trans_begin();
		$this->db->empty_table('ms_pricelistfr');
		$numb4 =0;
		foreach($_POST['plnfr'] as $nfr){
		$code = $this->Inventory_4_model->generate_codefr();
		$numb4++;	   
              $dms =  array(
							'id_pricelistfr'		=> $code,
							'id_category3'=>$nfr[id_category3],
							'book_price'=>$nfr[book_price],
							'profit'=>$nfr[profit],
							'bottom_price'=>$nfr[bottom_price],
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('ms_pricelistfr',$dms);
			
		    }			
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 1
			);			
		}
  		echo json_encode($status);

    }
	public function saveEditPricelistnfr()
    {
        $this->auth->restrict($this->addPermission);
        $this->auth->restrict($this->addPermission);
		
		$post = $this->input->post();
		$id_bentuk = $post['inven1'];
		$id = $post['id_pricelistnfr'];
		$code = $this->Inventory_4_model->generate_codenfr();
		$this->db->trans_begin();
		$data = [
							'id_category3'			=> $post['id_category3'],
							'book_price'			=> $post['book_price'],
							'lme10'					=> $post['lme10'],
							'lme30'					=> $post['lme30'],
							'lmespot'				=> $post['lmespot'],
							'scrap'					=> $post['scrap'],
							'cogs'					=> $post['cogs'],
							'operating_cost'		=> $post['operating_cost'],
							'interest'				=> $post['interest'],
							'profit'				=> $post['profit'],
							'profit10'				=> $post['profit10'],
							'profit30'				=> $post['profit30'],
							'profitspot'			=> $post['profitspot'],
							'bottom_price'			=> $post['bottom_price'],
							'bottom_price10'		=> $post['bottom_price10'],
							'bottom_price30'		=> $post['bottom_price30'],
							'bottom_pricespot'		=> $post['bottom_pricespot'],
							'modified_on'			=> date('Y-m-d H:i:s'),
							'modified_by'			=> $this->auth->user_id()
                            ];
            //Add Data
               $this->db->where('id_pricelistnfr',$id)->update("ms_pricelistnfr",$data);			
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);

    }
	public function saveEditPricelistfr()
    {
        $this->auth->restrict($this->addPermission);
        $this->auth->restrict($this->addPermission);
		
		$post = $this->input->post();
		$id_bentuk = $post['inven1'];
		$id = $post['id_pricelistfr'];
		$code = $this->Inventory_4_model->generate_codefr();
		$this->db->trans_begin();
		$data = [
							'id_category3'			=> $post['id_category3'],
							'book_price'			=> $post['book_price'],
							'scrap'					=> $post['scrap'],
							'cogs'					=> $post['cogs'],
							'operating_cost'		=> $post['operating_cost'],
							'interest'				=> $post['interest'],
							'profit'				=> $post['profit'],
							'bottom_price'			=> $post['bottom_price'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
			$this->db->where('id_pricelistfr',$id)->update("ms_pricelistfr",$data);	
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);

    }
	public function saveEditInventory()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Inventory_4_model->generate_id();
		$this->db->trans_begin();
		$id = $_POST['hd1']['1']['id_category3'];
		$id_bentuk = $_POST['hd1']['1']['id_bentuk'];
		$numb1 =0;
		foreach($_POST['hd1'] as $h1){
		$numb1++;        
                $header1 =  array(
							'id_type'		        => $h1[inventory_1],
							'id_category1'		    => $h1[inventory_2],
							'id_category2'		    => $h1[inventory_3],
							'nama'		        	=> $h1[nm_inventory],
							'maker'		        	=> $h1[maker],
							'density'		        => $h1[density],
							'hardness'		        => $h1[hardness],
							'id_bentuk'		        => $h1[id_bentuk],
							'id_surface'		    => $h1[id_surface],
							'mountly_forecast'		=> $h1[mountly_forecast],
							'safety_stock'		    => $h1[safety_stock],
							'order_point'		    => $h1[order_point],
							'maksimum'		    	=> $h1[maksimum],
							'aktif'					=> 'aktif',
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id(),
							'deleted'			=> '0' 
                            );
                     $this->db->where('id_category3',$id)->update("ms_inventory_category3",$header1);
			
		    }
					
		if(empty($_POST['data1'])){
		}else{
		$this->db->delete('child_inven_suplier', array('id_category3' => $id));
		$numb2 =0;
		
		foreach($_POST['data1'] as $d1){
		$numb2++;	   
              $data1 =  array(
			                    'id_category3'=>$id, 
								'id_suplier'=>$d1[id_supplier],
								'lead'=>$d1[lead],
								'minimum'=>$d1[minimum],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_suplier',$data1);
			
		    }		
		}
		
		if(empty($_POST['compo'])){
		}else{
		$this->db->delete('child_inven_compotition', array('id_category3' => $id));
		$numb3 =0;
		foreach($_POST['compo'] as $c1){
		$numb3++;	   
              $comp =  array(
			                    'id_category3'=>$id, 
								'id_compotition'=>$c1[id_compotition],
								'nilai_compotition'=>$c1[jumlah_kandungan],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_compotition',$comp);
			
		    }		
		}
		
		if(empty($_POST['dimens'])){
		}else{
		$this->db->delete('child_inven_dimensi', array('id_category3' => $id));
		$numb4 =0;
		foreach($_POST['dimens'] as $dm){
		$numb4++;	   
              $dms =  array(
			                    'id_category3'=>$id, 
								'id_dimensi'=>$dm[id_dimensi],
								'nilai_dimensi'=>$dm[nilai_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_dimensi',$dms);
			
		    }		
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);

    }
		function get_compotition_new()
    {
        $inventory_2=$_GET['inventory_2'];
        $comp=$this->Inventory_4_model->compotition($inventory_2);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($comp as $key => $cmp): $numb++;
				      echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='compo[$numb][id_compotition]' readonly class='form-control'  value='$cmp->id_compotition'>
					  </td>
					  <td align='left'>
					  $cmp->name_compotition
					  </td>
					  <td align='left'>
					  <input type='text' name='compo[$numb][jumlah_kandungan]' class='form-control'>
					  </td>
					  <td align='left'>%</td>
                    </tr>";
                endforeach;
        echo "</select>";
    }
	function get_dimensi()
    {
        $id_bentuk=$_GET['id_bentuk'];
        $dim=$this->Inventory_4_model->bentuk($id_bentuk);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($dim as $key => $ensi): $numb++;
				      echo "<tr>
					  <td align='left' hidden>
					  <input type='text' name='dimens[$numb][id_dimensi]' readonly class='form-control'  value='$ensi->id_dimensi'>
					  </td>
					  <td align='left'>
					  $ensi->nm_dimensi
					  </td>
					  <td align='left'>
					  <input type='text' name='dimens[$numb][nilai_dimensi]' class='form-control'>
					  </td>
                    </tr>";
                endforeach;
        echo "</select>";
    }
	function get_compotition_old()
    {
        $inventory_2=$_GET['inventory_2'];
        $comp=$this->Inventory_4_model->compotition_edit($inventory_2);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($comp as $key => $cmp): $numb++;
				      echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='compo[$numb][id_compotition]' readonly class='form-control'  value='$cmp->id_compotition'>
					  </td>
					  <td align='left'>
					  $cmp->name_compotition
					  </td>
					  <td align='left'>
					  <input type='text' name='compo[$numb][jumlah_kandungan]' class='form-control'>
					  </td>
					  <td align='left'>%</td>
                    </tr>";
                endforeach;
        echo "</select>";
    }
	function get_dimensi_old()
    {
        $id_bentuk=$_GET['id_bentuk'];
        $dim=$this->Inventory_4_model->bentuk_edit($id_bentuk);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($dim as $key => $ensi): $numb++;
				      echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='dimens[$numb][id_dimensi]' readonly class='form-control'  value='$cmp->id_dimensi'>
					  </td>
					  <td align='left'>
					  $ensi->nm_dimensi
					  </td>
					  <td align='left'>
					  <input type='text' name='dimens[$numb][nilai_dimensi]' class='form-control'>
					  </td>
                    </tr>";
                endforeach;
        echo "</select>";
    }
	public function saveEditInventorylama()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Inventory_4_model->generate_id();
		$this->db->trans_begin();
		$id =$_POST['hd1']['1']['id_category3'];
		$numb1 =0;
		//$head = $_POST['hd1'];
		foreach($_POST['hd1'] as $h1){
		$numb1++;	
		        
                $header1 =  array(
							'id_type'		        => $h1[inventory_1],
							'id_category1'		    => $h1[inventory_2],
							'id_category2'		    => $h1[inventory_3],
							'nama'		        	=> $h1[nm_inventory],
							'maker'		        	=> $h1[maker],
							'density'		        => $h1[density],
							'hardness'		        => $h1[hardness],
							'id_bentuk'		        => $h1[id_bentuk],
							'id_surface'		    => $h1[id_surface],
							'mountly_forecast'		=> $h1[mountly_forecast],
							'safety_stock'		    => $h1[safety_stock],
							'order_point'		    => $h1[order_point],
							'maksimum'		    	=> $h1[maksimum],
							'aktif'					=> 'aktif',
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id(),
							'deleted'			=> '0' 
                            );
            //Add Data
              $this->db->where('id_category3',$id)->update("ms_inventory_category3",$data);
			
		    }	
		$this->db->delete('child_inven_suplier', array('id_category3' => $id));
		if(empty($_POST['data1'])){
		}else{
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;	   
              $data1 =  array(
			                    'id_category3'=>$code, 
								'id_suplier'=>$d1[id_supplier],
								'lead'=>$d1[lead],
								'minimum'=>$d1[minimum],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_suplier',$data1);
			
		    }		
		}	
		if(empty($_POST['compo'])){
		}else{
		$numb3 =0;
		foreach($_POST['compo'] as $c1){
		$numb3++;	   
              $comp =  array(
			                    'id_category3'=>$code, 
								'id_compotition'=>$c1[id_compotition],
								'nilai_compotition'=>$c1[jumlah_kandungan],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_compotition',$comp);
			
		    }		
		}
		if(empty($_POST['dimens'])){
		}else{
		$numb4 =0;
		foreach($_POST['dimens'] as $dm){
		$numb4++;	   
              $dms =  array(
			                    'id_category3'=>$code, 
								'id_dimensi'=>$dm[id_dimensi],
								'nilai_dimensi'=>$dm[nilai_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_dimensi',$dms);
			
		    }		
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);

    }
	public function saveEditInventoryOld()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Inventory_4_model->generate_id();
		$this->db->trans_begin();
		$id =$_POST['hd1']['1']['id_category3'];
		$numb1 =0;
		//$head = $_POST['hd1'];
		foreach($_POST['hd1'] as $h1){
		$numb1++;	
		        
                $header1 =  array(
							'id_type'		        => $h1[inventory_1],
							'id_category1'		    => $h1[inventory_2],
							'id_category2'		    => $h1[inventory_3],
							'nama'		        	=> $h1[nm_inventory],
							'maker'		        	=> $h1[maker],
							'density'		        => $h1[density],
							'hardness'		        => $h1[hardness],
							'id_bentuk'		        => $h1[id_bentuk],
							'id_surface'		    => $h1[id_surface],
							'mountly_forecast'		=> $h1[mountly_forecast],
							'safety_stock'		    => $h1[safety_stock],
							'order_point'		    => $h1[order_point],
							'maksimum'		    	=> $h1[maksimum],
							'aktif'					=> 'aktif',
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id(),
							'deleted'			=> '0' 
                            );
            //Add Data
              $this->db->where('id_category3',$id)->update("ms_inventory_category3",$data);
			
		    }		
		if(empty($_POST['data1'])){
		}else{
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;	   
              $data1 =  array(
			                    'id_category3'=>$id, 
								'id_suplier'=>$d1[id_supplier],
								'lead'=>$d1[lead],
								'minimum'=>$d1[minimum],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_suplier',$data1);
			
		    }		
		}	
		if(empty($_POST['compo'])){
		}else{
		$numb3 =0;
		foreach($_POST['compo'] as $c1){
		$numb3++;	   
              $comp =  array(
			                    'id_category3'=>$id, 
								'id_compotition'=>$c1[id_compotition],
								'nilai_compotition'=>$c1[jumlah_kandungan],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_compotition',$comp);
			
		    }		
		}
		if(empty($_POST['dimens'])){
		}else{
		$numb4 =0;
		foreach($_POST['dimens'] as $dm){
		$numb4++;	   
              $dms =  array(
			                    'id_category3'=>$id, 
								'id_dimensi'=>$dm[id_dimensi],
								'nilai_dimensi'=>$dm[nilai_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_dimensi',$dms);
			
		    }		
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);

    }
		function get_compotition()
    {
        $inventory_2=$_GET['inventory_2'];
        $comp=$this->Inventory_4_model->compotition($inventory_2);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($comp as $key => $cmp): $numb++;
				      echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='compo[$numb][id_compotition]' readonly class='form-control'  value='$cmp->id_compotition'>
					  </td>
					  <td align='left'>
					  $cmp->name_compotition
					  </td>
					  <td align='left'>
					  <input type='text' name='compo[$numb][jumlah_kandungan]' class='form-control'>
					  </td>
					  <td align='left'>%</td>
                    </tr>";
                endforeach;
        echo "</select>";
    }

	
}
