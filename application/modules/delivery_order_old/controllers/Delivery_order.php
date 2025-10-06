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

class Delivery_order extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Delivery_Order.View';
    protected $addPermission  	= 'Delivery_Order.Add';
    protected $managePermission = 'Delivery_Order.Manage';
    protected $deletePermission = 'Delivery_Order.Delete';

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Delivery_order/Delivery_order_model',
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
        $data = $this->Delivery_order_model->CariDO();
        $this->template->set('results', $data);
        $this->template->title('Delivery Order');
        $this->template->render('index');
    }

		public function addHeader()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$penawaran = $this->Delivery_order_model->get_data('tr_spk_marketing');
		$karyawan = $this->Delivery_order_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Delivery_order_model->get_data('mata_uang','deleted',$deleted);
		$customer = $this->db
							->select('a.id_customer, b.name_customer')
							->from('tr_spk_marketing a')
							->join('master_customers b','a.id_customer=b.id_customer','left')
							->group_by('a.id_customer')
							->order_by('b.name_customer','asc')
							->get()
							->result();
		$data = [
			'penawaran' => $penawaran,
			'karyawan' => $karyawan,
			'customer' => $customer,
			'mata_uang' => $mata_uang,
		];
        $this->template->set('results', $data);
        $this->template->title('Add Delivery Order');
        $this->template->render('AddHeader');
    }

	public function get_penawaran(){
		$id 	= $this->input->post('id');
		$result	= $this->db->get_where('tr_spk_marketing',array('id_customer'=>$id,'status_approve'=>'1'))->result_array();
		
		$option	= "<option value='0'>--Pilih--</option>";
		foreach($result AS $val => $valx){
			$option .= "<option value='".$valx['id_spkmarketing']."'>".strtoupper($valx['no_surat'])."</option>";
		}
		$ArrJson	= array(
			'option' => $option
		);
		echo json_encode($ArrJson);
	}

	public function PrintHeader1($id){
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);
		$data['header'] = $this->Delivery_order_model->getHeaderPenawaran($id);
		$data['detail']  = $this->Delivery_order_model->PrintDetail($id);
		$this->load->view('PrintHeader',$data);
	}
	public function PrintHeader(){
		ob_clean();
		ob_start();
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);
		$data['header'] = $this->Delivery_order_model->getHeaderPenawaran($id); 
		$data['detail']  = $this->Delivery_order_model->PrintDetail($id);
		$this->load->view('PrintHeader2',$data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(10, 5, 10, 5));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('aaa.pdf', 'I');
	}
		public function EditHeader()
    {
		$id = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$tr_spk = $this->Delivery_order_model->get_data('tr_delivery_order','id_delivery_order',$id);
		// $dtspk = $this->Delivery_order_model->get_data('dt_spkmarketing',array('id_spkmarketing',$id));
		$dtspk = $this->db->query("SELECT * FROM dt_delivery_order_child WHERE id_delivery_order ='$id' AND bantuan='0'")->result();
		$penawaran = $this->Delivery_order_model->get_data('tr_penawaran');
		$karyawan = $this->Delivery_order_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Delivery_order_model->get_data('mata_uang','deleted',$deleted);
		$data = [
			'tr_spk' => $tr_spk,
			'dtspk' => $dtspk,
			'penawaran' => $penawaran,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'id' => $id
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Delivery Order');
        $this->template->render('EditHeader');

    }
	    public function detail()
    {
		$id = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
        $detail = $this->Delivery_order_model->getpenawaran($id);
		$header = $this->Delivery_order_model->getHeaderPenawaran($id);
		$data = [
			'detail' => $detail,
			'header' => $header
		];
        $this->template->set('results', $data);
        $this->template->title('Penawaran');
        $this->template->render('detail');
    }

		public function editPenawaran($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$penawaran = $this->Delivery_order_model->get_data('child_penawaran','id_child_penawaran',$id);
		$inventory_3 = $this->Delivery_order_model->get_data_category();
		$data = [
			'penawaran' => $penawaran,
			'inventory_3' => $inventory_3,
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Penawaran');
        $this->template->render('editPenawaran');

    }



		public function ViewHeader($id)
    {
		$id = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-list');
	    $header = $this->Delivery_order_model->getHeaderPenawaran($id); 
		$detail = $this->Delivery_order_model->PrintDetail($id);
		$data = [
			'header' => $header,
			'detail' => $detail,
		];
        $this->template->set('results', $data);
        $this->template->title('Detail DO');
        $this->template->render('ViewHeader');

    }

			public function viewPenawaran($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$penawaran = $this->Delivery_order_model->get_data('child_penawaran','id_child_penawaran',$id);
		$inventory_3 = $this->Delivery_order_model->get_data_category();
		$data = [
			'penawaran' => $penawaran,
			'inventory_3' => $inventory_3,
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Penawaran');
        $this->template->render('viewPenawaran');

    }
	public function copyInventory($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inven = $this->Delivery_order_model->getedit($id);
		$komposisiold = $this->Delivery_order_model->get_data('child_inven_compotition','id_category3',$id);
		$komposisi = $this->Delivery_order_model->kompos($id);
		$dimensiold = $this->Delivery_order_model->get_data('child_inven_dimensi','id_category3',$id);
		$dimensi = $this->Delivery_order_model->dimensy($id);
		$supl = $this->Delivery_order_model->supl($id);
		$inventory_1 = $this->Delivery_order_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Delivery_order_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Delivery_order_model->get_data('ms_inventory_category2','deleted',$deleted);
		$maker = $this->Delivery_order_model->get_data('negara');
		$id_bentuk = $this->Delivery_order_model->get_data('ms_bentuk');
		$id_supplier = $this->Delivery_order_model->get_data('master_supplier');
		$id_surface = $this->Delivery_order_model->get_data('ms_surface');
		$dt_suplier = $this->Delivery_order_model->get_data('child_inven_suplier','id_category3',$id);
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
		$inven = $this->Delivery_order_model->getedit($id);
		$komposisiold = $this->Delivery_order_model->get_data('child_inven_compotition','id_category3',$id);
		$komposisi = $this->Delivery_order_model->kompos($id);
		$dimensiold = $this->Delivery_order_model->get_data('child_inven_dimensi','id_category3',$id);
		$dimensi = $this->Delivery_order_model->dimensy($id);
		$supl = $this->Delivery_order_model->supl($id);
		$inventory_1 = $this->Delivery_order_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Delivery_order_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Delivery_order_model->get_data('ms_inventory_category2','deleted',$deleted);
		$maker = $this->Delivery_order_model->get_data('negara');
		$id_bentuk = $this->Delivery_order_model->get_data('ms_bentuk');
		$id_supplier = $this->Delivery_order_model->get_data('master_supplier');
		$id_surface = $this->Delivery_order_model->get_data('ms_surface');
		$dt_suplier = $this->Delivery_order_model->get_data('child_inven_suplier','id_category3',$id);
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


	public function addPenawaran($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$headpenawaran = $this->Delivery_order_model->get_data('tr_penawaran','no_penawaran',$id);
		$inventory_3 = $this->Delivery_order_model->get_data_category();
		$data = [
			'inventory_3' => $inventory_3,
			'headpenawaran' => $headpenawaran
		];
        $this->template->set('results', $data);
        $this->template->title('Add Penawaran');
        $this->template->render('AddPenawaran');

    }


function cari_pricelist()
    {
        $id_category3=$_GET['id_category3'];
		$mata_uang=$_GET['mata_uang'];
		$kurs	= $this->db->query("SELECT * FROM mata_uang WHERE kode = '$mata_uang' ")->result();
		$mu = $kurs[0]->kurs;
		$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
		$inven1 = $kategory3[0]->id_category1;
		if($inven1 == "I2000001"){
			$plquery	= $this->db->query("SELECT * FROM ms_pricelistfr WHERE id_category3 = '$id_category3' ")->result();
			if(empty($plquery)){
				echo "<div class='col-sm-12' align='center'>
					<label  for='forecast'>PRICELIST</label>
					</div>
					<div class='col-sm-12' align='center'>
					<div class='form-group row'>
					<table class='col-sm-12'>
					<tr>
						<th><center>Book Price<c/enter></th>
					</tr>
					<tr>
						<td><center>
						Price List Untuk Material Ini Belum Terinput
						</center></td>
					</tr>
					</table>
					</div>
					</div>";
			}else{
		$bottom_price = $plquery[0]->bottom_price;
			echo "	<div class='col-sm-12' align='center'>
					<label  for='forecast'>PRICELIST</label>
					</div>
					<div class='col-sm-12' align='center'>
					<div class='form-group row'>
					<table class='col-sm-12'>
					<tr>
						<th><center>Book Price<c/enter></th>
					</tr>
					<tr>
						<td><center>Rp. $bottom_price  ,-</center></td>
					</tr>
					</table>
					</div>
					</div>
					";};
		} elseif ($inven1 == "I2000002") {

			$plquery	= $this->db->query("SELECT * FROM ms_pricelistnfr WHERE id_category3 = '$id_category3' ")->result();
			if(empty($plquery)){
				echo "<div class='col-sm-12' align='center'>
					<label  for='forecast'>PRICELIST</label>
					</div>
					<div class='col-sm-12' align='center'>
					<div class='form-group row'>
					<table class='col-sm-12'>
					<tr>
						<th><center>Book Price<c/enter></th>
						<th><center>LME 10 Hari</center></th>
						<th><center>LME 30 Hari</center></th>
						<th><center>LME SPOT</center></th>
					</tr>
					<tr>
						<td colspan='4'><center>
						Price List Untuk Material Ini Belum Terinput
						</center></td>
					</tr>
					</table>
					</div>
					</div>";
			}else{
		$bottom_price = number_format($plquery[0]->bottom_price*$mu,2);
		$bottom_price10 = number_format($plquery[0]->bottom_price10*$mu,2);
		$bottom_price30 = number_format($plquery[0]->bottom_price30*$mu,2);
		$bottom_pricespot = number_format($plquery[0]->bottom_pricespot*$mu,2);
			echo "	<div class='col-sm-12' align='center'>
					<label  for='forecast'>PRICELIST</label>
					</div>
					<div class='col-sm-12' align='center'>
					<div class='form-group row'>
					<table class='col-sm-12'>
					<tr>
						<th><center>Book Price<c/enter></th>
						<th><center>LME 10 Hari</center></th>
						<th><center>LME 30 Hari</center></th>
						<th><center>LME SPOT</center></th>
					</tr>
					<tr>
						<td><center>Rp. $bottom_price  ,-</center></td>
						<td><center>Rp. $bottom_price10  ,-</center></td>
						<td><center>Rp. $bottom_price30  ,-</center></td>
						<td><center>Rp. $bottom_pricespot  ,-</center></td>
					</tr>
					</table>
					</div>
					</div>
					";};
		};

	}
function cari_bentuk()
    {
        $id_category3=$_GET['id_category3'];
		$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
		$id_bentuk = $kategory3[0]->id_bentuk;
		$bentukquery	= $this->db->query("SELECT * FROM ms_bentuk WHERE id_bentuk = '$id_bentuk' ")->result();
		$bentuk_material = $bentukquery[0]->nm_bentuk;
		echo "<div class='col-md-4'>
				<label for='customer'>Bentuk</label>
			  </div>
			  <div class='col-md-8'>
				<input type='text' class='form-control' readonly value='$bentuk_material' id='bentuk_material'  required name='bentuk_material' placeholder='Bentuk Material'>
			  </div>
			  <div class='col-md-8' hidden>
				<input type='text' class='form-control' readonly value='$id_bentuk' id='id_bentuk'  required name='id_bentuk' placeholder='Bentuk Material'>
			  </div>";
	}
function GetProduk()
    {
        $id_customer=$_GET['id_customer'];
		$dt1	= $this->db->query("SELECT * FROM tr_inquiry WHERE id_customer = '$id_customer' ")->result();
		$id_crcl = $dt1[0]->no_inquiry;
		$link = base_url('/transaksi_inquiry/');
		if(!empty($dt1)){
		$material = $this->Delivery_order_model->CariMaterial($id_crcl);
		echo "<select id='id_produk' name='id_produk' class='form-control select' onchange='get_properties()'  required>
						<option value=''>--Pilih Material--</option>";
				foreach($material as $material){
					echo"<option value='$material->id_dt_inquery'>$material->nama2-$material->nama3-$material->hardness</option>";
				}
		echo "</select>";}else{
			echo"<a class='btn btn-danger btn-sm' href='$link' title='CRCL'></i>CRCL Cusromer Ini Belum Dibuat Klik DIsini Untuk Membuat CRCL</i></a>";
		};
	}

function GetMaterial()
    {
        $id_produk=$_GET['id_produk'];
		$dt1	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE id_dt_inquery = '$id_produk' ")->result();
		$id_crcl = $dt1[0]->id_category3;
		$nm	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_crcl' ")->result();
		$nama = $nm[0]->nama;
		echo "<input type='text' class='form-control' value='$nama' readonly id='material' required name='material'>";
	}
function GetCustomer()
    {
        $no_penawaran	= $_GET['no_penawaran'];
		$dt1			= $this->db->query("SELECT * FROM tr_spk_marketing WHERE id_spkmarketing = '$no_penawaran' ")->result();
		$id_customer 	= $dt1[0]->id_customer;
		$nosurat  		= $dt1[0]->no_surat;
		$reff  			= $dt1[0]->no_po;
		$nm				= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
		$name_customer 	= strtoupper($nm[0]->name_customer);
		$ArrJson	= array(
			'name_customer' => $name_customer,
			'id_customer' => $id_customer,
			'reff' => $reff,
			'nosurat' => $nosurat
		);
		echo json_encode($ArrJson);
	}

function AddMaterial_old()
    {
        $loop=$_GET['jumlah']+1;
		$id_dt = $_GET['id_dt'];
		// $no_penawaran=$_GET['no_penawaran'];
		// $dt1	= $this->db->query("SELECT * FROM tr_spk_marketing WHERE id_spkmarketing = '$no_penawaran' ")->result();
		// $id_customer = $dt1[0]->id_customer;
		// $nm	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
		// $nama = $nm[0]->name_customer;
		// $dt	= $this->db->query("SELECT a.*, b.nama as nama3, b.hardness as hard FROM dt_spkmarketing as a inner join //ms_inventory_category3 as b on a.id_category3 = b.id_category3 WHERE a.id_spkmarketing = '$no_penawaran'  ")->result();
		$dt	= $this->db->query("SELECT a.* FROM dt_spkmarketing as a WHERE a.id_dt_spkmarketing = '$id_dt'  ")->result();
		// $cr	= $this->db->query("SELECT * FROM tr_inquiry WHERE id_customer = '$id_customer' ")->result();
		// $idcr = $cr[0]->no_inquiry;
		//$loop=0; 
		foreach($dt AS $dt){
		//$loop++;
		$id_category3=$dt->id_material;
		$crcl	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE no_inquery = '$idcr' AND id_category3='$id_category3' ")->result();	
		$lot	= $this->db->query("SELECT * FROM stock_material WHERE id_gudang = '3' AND id_category3='$id_category3' ")->result();	
		echo "
		<tr id='list_penawaran_slot_$loop'>
			<th  width='10%' hidden><input type='text' class='form-control' value='$dt->id_child_penawaran' readonly id='dt_id_child_penawaran_$loop' required name='dt[$loop][id_child_penawaran]'></th>
			
			<th  width='10%'><input type='text' class='form-control' value='$dt->id_spkmarketing' readonly id='dt_idmaterial_$loop' required name='dt[$loop][idmaterial]'></th>
			
			<th  width='10%'><input type='text' class='form-control' value='$dt->no_alloy' readonly id='dt_noalloy_$loop' required name='dt[$loop][noalloy]'></th>
			
			<th  width='10%'><input type='text' class='form-control' value='$dt->thickness' readonly id='dt_thickness_$loop' required name='dt[$loop][thickness]'></th>
			
			<th  width='10%'><input type='text' class='form-control' value='$dt->total_weight' readonly id='dt_width_$loop' required name='dt[$loop][width]'></th>
			
			<th  width='10%'><input type='text' class='form-control' value='$dt->crcl' readonly id='dt_crcl_$loop' required name='dt[$loop][crcl]'></th>
			
			<th  width='10%' ><select id='dt_lot_$loop' name='dt[$loop][lot]' class='form-control select' onchange='CariProperties(".$loop.")' required>
						<option value=''>--Pilih--</option>";
						foreach($lot AS $lot){
						$lotslit = $lot->lotno.'|'.$lot->lot_slitting;
						echo"<option value='$lot->id_stock'>$lotslit</option>";
						}
		    echo"</select></th>
			
			<th  width='10%'  id='idmaterial_".$loop."'><input type='text' class='form-control' value='0' readonly id='dt_qty_mat_$loop' required name='dt[$loop][qty_mat]'></th>
			<th   width='10%' id='weightmaterial_".$loop."'><input type='text' class='form-control' value='0' readonly id='dt_weight_mat_$loop' required name='dt[$loop][weight_mat]'></th>
			<th width='10%'  ><input type='text' class='form-control' value=' ' id='dt_remarks_$loop' required name='dt[$loop][remarks]'></th>
			<th  width='10%'><button type='button' class='btn btn-sm btn-danger' title='Ambil' id='tbh_ata' data-role='qtip' onClick='HapusItem(".$loop.");'><i class='fa fa-times'></i></button></th> 
		</tr>
		";
		};
	}
	
	function GetPenawaran(){
        $no_penawaran	= $_GET['no_penawaran'];
		$dt1			= $this->db->query("SELECT * FROM tr_spk_marketing WHERE id_spkmarketing = '$no_penawaran' ")->result();
		$id_customer 	= $dt1[0]->id_customer;
		
		$nomor			= $this->db->query("SELECT * FROM tr_spk_marketing WHERE id_spkmarketing = '$no_penawaran' ")->row();
		
		

		$dt				= $this->db->get_where('dt_spkmarketing', array('id_spkmarketing'=>$no_penawaran, 'deal'=>1, 'id_child_penawaran <>'=>NULL))->result();
		$loop			= 0; 
		foreach($dt AS $dt){
			$loop++;
			$id_category3	= $dt->id_material;
			$lot			= $this->db->query("SELECT * FROM stock_material WHERE id_gudang = '3' AND id_category3='$id_category3' AND width = $dt->width AND no_surat like '%%$nomor->no_surat%%' ")->result();	
			
			// print_r($lot);
			// exit;
			
			$child 			= $this->db->get_where('child_penawaran', array('id_child_penawaran'=>$dt->id_child_penawaran))->result();
			$child2 		= $this->db->get_where('ms_inventory_category3', array('id_category3'=>$child[0]->id_category3))->result();
			$child3 		= $this->db->get_where('ms_inventory_category2', array('id_category2'=>$child2[0]->id_category2))->result();
			// $nm_material 	= $child[0]->bentuk_material.' '.$child3[0]->nama.' '.$child2[0]->nama.' '.$child2[0]->hardness.' '.$dt->thickness;
			$nm_material 	= $child2[0]->nama; 
			
			
				
			echo "
			<tr class='baris_".$loop."'>
				<td rowspan='1' class='id_".$loop."'>
				<input type='text' class='form-control input-sm'  value='$dt->id_material' name='dp[$loop][id_material]' id='id_material_$loop' readonly>
				</td>
				<td rowspan='1' class='id_".$loop."'>					
					<input type='hidden' value='$dt->no_alloy' name='hd[$loop][no_alloy]' id='no_alloy_$loop' readonly>
					<input type='hidden' value='$dt->thickness' name='hd[$loop][thickness]' id='thickness_$loop' readonly>
					<input type='text' class='form-control input-sm' value='$nm_material' name='dp[$loop][material]' id='material_$loop'  readonly>
				</td>
				<td rowspan='1' class='id_".$loop."'><input type='text' class='form-control input-sm text-right' value='".number_format($dt->width,2)."' name='hd[$loop][width]'  id='width_$loop' readonly></td>
				<td rowspan='1' class='id_".$loop."'><input type='text' class='form-control input-sm text-right' value='".number_format($child[0]->length,2)."' name='hd[$loop][length]' id='length_$loop' readonly></td>
				<td rowspan='1' class='id_".$loop."'><input type='text' class='form-control input-sm text-right' value='".number_format($dt->qty_produk,2)."' name='hd[$loop][qty_produk]' id='qty_$loop' readonly></td>
				<td rowspan='1' class='id_".$loop."'>
					<button type='button' class='btn btn-sm btn-success pluss' title='Plus' data-id='".$loop."'>Add</button>
				</td>
				
			</tr>
			";
			
			if(!empty($lot)){
			$numb = 0;
			$totalqty =0;
			$totalberat =0;
			foreach($lot AS $lot){
				
			$totalqty += $lot->qty;
			$totalberat += $lot->weight;
			$numb++;
				
				
				echo" <tr id='row_".$loop."' class='baris_".$loop.$numb."'>
				<td rowspan='1' class='id_".$loop.$numb."'>
				<input type='text' class='form-control input-sm' id='dp_id_material_$loop$numb'  value='$dt->id_material' name='dp[$loop$numb][id_material]' readonly>
				</td>
				<td rowspan='1' class='id_".$loop.$numb."'>					
					<input type='hidden' value='$dt->no_alloy' id='dp_no_alloy_$loop$numb' name='dp[$loop$numb][no_alloy]' readonly>
					<input type='hidden' value='$dt->thickness' id='dp_thickness_$loop$numb' name='dp[$loop$numb][thickness]' readonly>
					<input type='text' class='form-control input-sm' value='$nm_material' id='dp_material_$loop$numb' name='dp[$loop][material]' readonly>
				</td>
				<td rowspan='1' class='id_".$loop.$numb."'><input type='text' class='form-control input-sm text-right' value='".number_format($dt->width,2)."' id='dp_width_$loop$numb' name='dp[$loop$numb][width]' readonly></td>
				<td rowspan='1' class='id_".$loop.$numb."'><input type='text' class='form-control input-sm text-right' value='".number_format($child[0]->length,2)."' id='dp_length_$loop$numb' name='dp[$loop$numb][length]' readonly></td>
				<td rowspan='1' class='id_".$loop.$numb."'><input type='text' class='form-control input-sm text-right' value='".number_format($dt->qty_produk,2)."'  id='dp_qty_produk_$loop$numb' name='dp[$loop$numb][qty_produk]' readonly></td>
				<td rowspan='1' class='id_".$loop.$numb."'>
				
				</td>";
				
				
				echo"<td>";
				echo"<input type='hidden' value='0' name='dp[$loop$numb][detail][1][bantuan]' readonly>
				
				<input type='text' class='form-control' value='$lot->lotno' id='dp_lot_$loop$numb' name='dp[$loop$numb][detail][1][lot]' readonly>			
				
				</td>
				<td><input type='text' class='form-control input-sm text-right autoNumeric' value='$lot->qty' placeholder='Qty' id='dp_qty_mat_$loop$numb' required name='dp[$loop$numb][detail][1][qty_mat]'></td>
				<td><input type='text' class='form-control input-sm text-right autoNumeric' placeholder='Weight' id='dp_weight_mat_$loop$numb' required name='dp[$loop$numb][detail][1][weight_mat]' value='$lot->weight'></td>
				<td><input type='text' class='form-control input-sm' placeholder='Remarks' id='dp_remarks_$loop$numb' name='dp[$loop$numb][detail][1][remarks]'></td>
				
				<td><a class='text-red' href='javascript:void(0)' title='Hapus' onClick='delRow($loop$numb,$loop)'><i class='fa fa-trash'></i>
				</a></td>
			</tr>";
			
			
			};
			echo"<td colspan='11' id='tambah_$loop'> </td>";
			
			echo" <tr  class='bg-blue'>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><input type='text' class='form-control input-sm text-right autoNumeric' id='totalqty$loop'  name='totalqty' value='$totalqty' readonly></td>
				<td><input type='text' class='form-control input-sm text-right autoNumeric' id='totalberat$loop'  name='totalberat' value='$totalberat' readonly></td>
				<td></td>				
				<td></td>
			</tr>
			";
			
		    };
		 
		}; 
	}
    
	function AddGetPenawaran(){
		$id_category3	= $_GET['id_material'];
		$width       	= $_GET['width'];
		$namamaterial 	= $_GET['nm_material'];
		$length 		= $_GET['length'];
		$qty_order 		= $_GET['qty_order'];		
       	$loop			= $_GET['nomor']; 
		$jumlah         = $_GET['jumlah']; 
		
			
		
			$lot			= $this->db->query("SELECT * FROM stock_material WHERE id_gudang = '3' AND id_category3='$id_category3' AND width = $width AND no_surat='NONSPK'")->result();	
			
				
			
			
			echo "<tr id='row_".$loop."' class='baris_".$loop.$loop.$jumlah."'>
			    <td width='8%' rowspan='1' class='id_".$loop.$loop.$jumlah."'>
				<input type='text' class='form-control input-sm' value='$id_category3' name='dp[$loop][id_material]' readonly>
				</td>
				<td width='25%' rowspan='1' class='id_".$loop.$loop.$jumlah."'>
					
					<input type='hidden' value='$dt->no_alloy' name='dp[$loop][no_alloy]' readonly>
					<input type='hidden' value='$dt->thickness' name='dp[$loop][thickness]' readonly>
					<input type='text' class='form-control input-sm' value='$namamaterial' name='dp[$loop][material]' readonly>
				</td>
				<td width='7%' rowspan='1' class='id_".$loop.$loop.$jumlah."'><input type='text' class='form-control input-sm text-right' value='".number_format($width,2)."' name='dp[$loop][width]' readonly></td>
				<td width='7%' rowspan='1' class='id_".$loop.$loop.$jumlah."'><input type='text' class='form-control input-sm text-right' value='".number_format($length,2)."' name='dp[$loop][length]' readonly></td>
				<td width='7%'rowspan='1' class='id_".$loop.$loop.$jumlah."'><input type='text' class='form-control input-sm text-right' value='".number_format($qty_order,2)."' name='dp[$loop][qty_produk]' readonly></td>
				<td width='5%'rowspan='1' class='id_".$loop.$loop.$jumlah."'>
					
				</td>
				<td width='20%'>
					<select name='dp[$loop][detail][1][lot]' class='form-control  select changeLot' data-id='".$loop."'  data-baris='".$loop.$loop.$jumlah."'  id='list_$loop$loop$jumlah'>
						<option value='0'>--Pilih--</option>";
						foreach($lot AS $lot){
							$lotslit = $lot->lotno.'|'.$lot->no_surat;
							echo"<option value='$lot->id_stock'>$lotslit</option>";
						}
				echo"</select>
				<input type='hidden' value='0' name='dp[$loop][detail][1][bantuan]' readonly>
				</td>
				<td width='5%'>
				
				<input type='text' class='form-control input-sm text-right autoNumeric qty  dp_qty_mat_$loop$loop$jumlah' placeholder='Qty' value='0' id='dp_qty_mat_$loop$loop$jumlah' required name='dp[$loop$jumlah][detail][1][qty_mat]'>
				
				</td>
				<td width='5%' ><input type='text' class='form-control input-sm text-right autoNumeric weight dp_weight_mat_$loop$loop$jumlah' placeholder='Weight' id='dp_weight_mat_$loop$loop$jumlah' value='0' required name='dp[$loop$loop$jumlah][detail][1][weight_mat]'></td>
				<td width='10%' ><input type='text' class='form-control input-sm' placeholder='Remarks' id='dp_remarks_$loop$loop$jumlah' name='dp[$loop$jumlah][detail][1][remarks]'></td>
				<td width='4%'><a class='text-red' href='javascript:void(0)' title='Hapus' onClick='delRow($loop$loop$jumlah,$loop)'><i class='fa fa-trash'></i>
				</a></td>
				</tr>
				";
			
			
			
	}


	function getStockLot(){
		$lot = $this->input->post('lot');

		$get_stock 	= $this->db->get_where('stock_material', array('id_stock'=>$lot))->result();
		$qty 		= (!empty($get_stock[0]->qty))?$get_stock[0]->qty:0;
		$berat 		= (!empty($get_stock[0]->totalweight))?$get_stock[0]->totalweight:0;

		$data = array(
			'qty' 	=> number_format($qty,2),
			'berat' => number_format($berat,2)
		);
		echo json_encode($data);
	}

	function GetPenawaranBEFORE()
    {
        $no_penawaran=$_GET['no_penawaran'];
		$dt1			= $this->db->query("SELECT * FROM tr_spk_marketing WHERE id_spkmarketing = '$no_penawaran' ")->result();
		$id_customer 	= $dt1[0]->id_customer;

		$dt		= $this->db->query("SELECT a.* FROM dt_spkmarketing a WHERE a.id_spkmarketing = '$no_penawaran'  ")->result();
		$cr		= $this->db->query("SELECT * FROM tr_inquiry WHERE id_customer = '$id_customer' ")->result();
		$idcr 	= $cr[0]->no_inquiry;
		$loop=0; 
		foreach($dt AS $dt){
			$loop++;
			$id_category3=$dt->id_material;
			$crcl	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE no_inquery = '$idcr' AND id_category3='$id_category3' ")->result();	
			$lot	= $this->db->query("SELECT * FROM stock_material WHERE id_gudang = '3' AND id_category3='$id_category3' ")->result();	
			echo "
			<tr id='tabel_penawaran_$loop'>
				<td hidden><input type='text' class='form-control input-sm nomor' value='0' readonly id='no_$loop' required name='dp[$loop][no]'></td>
				
				<td hidden><input type='text' class='form-control input-sm' value='$dt->id_dt_spkmarketing' readonly id='dp_id_dt_spkmarketing_$loop' required name='dp[$loop][id_dt_spkmarketing]'></td>
				
				<td><input type='text' class='form-control input-sm' value='$dt->id_spkmarketing' readonly id='dp_idmaterial_$loop' required name='dp[$loop][idmaterial]'></td>
				
				<td><input type='text' class='form-control input-sm' value='$dt->no_alloy' readonly id='dp_noalloy_$loop' required name='dp[$loop][noalloy]'></td>
				
				<td><input type='text' class='form-control input-sm' value='$dt->thickness' readonly id='dp_thickness_$loop' required name='dp[$loop][thickness]'></td>
				
				<td><input type='text' class='form-control input-sm' value='$dt->total_weight' readonly id='dp_width_$loop' required name='dp[$loop][width]'></td>
				
				<td hidden><select id='dp_lot_$loop' name='dp[$loop][lot]' class='form-control select' onchange='CariProperties(".$loop.")' required>
							<option value=''>--Pilih--</option>";
							foreach($lot AS $lot){
							$lotslit = $lot->lotno.'|'.$lot->lot_slitting;
							echo"<option value='$lot->id_stock'>$lotslit</option>";
							}
				echo"</select></td>
				
				<td hidden ><input type='text' class='form-control' value='0' readonly id='dp_qty_mat_$loop' required name='dp[$loop][qty_mat]'></td>
				<td hidden><input type='text' class='form-control' value='0' readonly id='dp_weight_mat_$loop' required name='dp[$loop][weight_mat]'></td>
				<td hidden><input type='text' class='form-control' value=' ' id='dp_remarks_$loop' required name='dp[$loop][remarks]'></td>
				<td>
					<input type='hidden' id='number_".$loop."' value='0'>
					<button type='button' class='btn btn-sm btn-success' title='Ambil' id='tbh_ata' data-role='qtip' onClick='addmaterial(".$loop.");' data-no='".$loop."'>Add Lot</button>
				</td>
				<td id='det_lot1_".$loop."'></td>
				<td id='det_lot2_".$loop."'></td>
				<td id='det_lot3_".$loop."'></td>
				<td id='det_lot4_".$loop."'></td>
				<td id='det_lot5_".$loop."'></td>
			</tr>
			";
		}; 
	}
	
	function AddMaterial1(){
        $loop=$_GET['nomor'].$_GET['urut'];
		$id_dt = $_GET['id_dt'];
		// $no_penawaran=$_GET['no_penawaran'];
		// $dt1	= $this->db->query("SELECT * FROM tr_spk_marketing WHERE id_spkmarketing = '$no_penawaran' ")->result();
		// $id_customer = $dt1[0]->id_customer;
		// $nm	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
		// $nama = $nm[0]->name_customer;
		// $dt	= $this->db->query("SELECT a.*, b.nama as nama3, b.hardness as hard FROM dt_spkmarketing as a inner join //ms_inventory_category3 as b on a.id_category3 = b.id_category3 WHERE a.id_spkmarketing = '$no_penawaran'  ")->result();
		$dt	= $this->db->query("SELECT a.* FROM dt_spkmarketing as a WHERE a.id_dt_spkmarketing = '$id_dt'  ")->result();
		// $cr	= $this->db->query("SELECT * FROM tr_inquiry WHERE id_customer = '$id_customer' ")->result();
		// $idcr = $cr[0]->no_inquiry;
		//$loop=0; 
		foreach($dt AS $dt){
		//$loop++;
		$id_category3=$dt->id_material;
		$crcl	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE no_inquery = '$idcr' AND id_category3='$id_category3' ")->result();	
		$lot	= $this->db->query("SELECT * FROM stock_material WHERE id_gudang = '3' AND id_category3='$id_category3' ")->result();	
		echo "
		<tr id='list_penawaran_slot_$loop'>
			<th  width='10%' ><select id='dt_lot_$loop' name='dt[$loop][lot]' class='form-control select del".$loop."' onchange='CariProperties(".$loop.")' required>
						<option value=''>--Pilih--</option>";
						foreach($lot AS $lot){
						$lotslit = $lot->lotno.'|'.$lot->lot_slitting;
						echo"<option value='$lot->id_stock'>$lotslit</option>";
						}
		    echo"</select></th>
			
		</tr>
		";
		};
	}
	function AddMaterial2(){
        $loop=$_GET['nomor'].$_GET['urut'];
		$id_dt = $_GET['id_dt'];
		// $no_penawaran=$_GET['no_penawaran'];
		// $dt1	= $this->db->query("SELECT * FROM tr_spk_marketing WHERE id_spkmarketing = '$no_penawaran' ")->result();
		// $id_customer = $dt1[0]->id_customer;
		// $nm	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
		// $nama = $nm[0]->name_customer;
		// $dt	= $this->db->query("SELECT a.*, b.nama as nama3, b.hardness as hard FROM dt_spkmarketing as a inner join //ms_inventory_category3 as b on a.id_category3 = b.id_category3 WHERE a.id_spkmarketing = '$no_penawaran'  ")->result();
		$dt	= $this->db->query("SELECT a.* FROM dt_spkmarketing as a WHERE a.id_dt_spkmarketing = '$id_dt'  ")->result();
		// $cr	= $this->db->query("SELECT * FROM tr_inquiry WHERE id_customer = '$id_customer' ")->result();
		// $idcr = $cr[0]->no_inquiry;
		//$loop=0; 
		foreach($dt AS $dt){
		//$loop++;
		$id_category3=$dt->id_material;
		$crcl	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE no_inquery = '$idcr' AND id_category3='$id_category3' ")->result();	
		$lot	= $this->db->query("SELECT * FROM stock_material WHERE id_gudang = '3' AND id_category3='$id_category3' ")->result();	
		echo "
		<tr id='list_penawaran_slot_$loop'>
			<th  width='10%'  id='idmaterial_".$loop."'><input type='text' class='form-control del".$loop."' value='0' readonly id='dt_qty_mat_$loop' required name='dt[$loop][qty_mat]'></th>
			<th hidden width='10%'  id='bentuk_".$loop."'><input type='text' class='form-control del".$loop."' value='0' readonly id='dt_bentuk_mat_$loop' required name='dt[$loop][bentuk_mat]'></th>
			<th hidden width='10%'  id='nolot_".$loop."'><input type='text' class='form-control del".$loop."' value='0' readonly id='dt_nolot_mat_$loop' required name='dt[$loop][nolot_mat]'></th>
			<th hidden width='10%'  id='noslit_".$loop."'><input type='text' class='form-control del".$loop."' value='0' readonly id='dt_noslit_mat_$loop' required name='dt[$loop][noslit_mat]'></th>
			
			<th hidden><input type='text' class='form-control del".$loop."' value='$dt->id_dt_spkmarketing' readonly id='dt_id_dt_spkmarketing2_$loop' required name='dt[$loop][id_dt_spkmarketing2]'></th>
			
			<th hidden><input type='text' class='form-control del".$loop."' value='$dt->id_spkmarketing' readonly id='dt_idmaterial2_$loop' required name='dt[$loop][idmaterial2]'></th>
			
			<th hidden><input type='text' class='form-control del".$loop."' value='$dt->no_alloy' readonly id='dt_noalloy2_$loop' required name='dt[$loop][noalloy2]'></th>
			
			<th hidden><input type='text' class='form-control del".$loop."' value='$dt->thickness' readonly id='dt_thickness2_$loop' required name='dt[$loop][thickness2]'></th>
			
			<th hidden><input type='text' class='form-control del".$loop."' value='$dt->total_weight' readonly id='dt_width2_$loop' required name='dt[$loop][width2]'></th>
			
			<th hidden><input type='text' class='form-control del".$loop."' value='$dt->crcl' readonly id='crcl2_$loop' required name='dt[$loop][crcl2]'></th>
			
		</tr>
		";
		};
	}
	function AddMaterial3(){
        $loop=$_GET['nomor'].$_GET['urut'];
		$id_dt = $_GET['id_dt'];
		// $no_penawaran=$_GET['no_penawaran'];
		// $dt1	= $this->db->query("SELECT * FROM tr_spk_marketing WHERE id_spkmarketing = '$no_penawaran' ")->result();
		// $id_customer = $dt1[0]->id_customer;
		// $nm	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
		// $nama = $nm[0]->name_customer;
		// $dt	= $this->db->query("SELECT a.*, b.nama as nama3, b.hardness as hard FROM dt_spkmarketing as a inner join //ms_inventory_category3 as b on a.id_category3 = b.id_category3 WHERE a.id_spkmarketing = '$no_penawaran'  ")->result();
		$dt	= $this->db->query("SELECT a.* FROM dt_spkmarketing as a WHERE a.id_dt_spkmarketing = '$id_dt'  ")->result();
		// $cr	= $this->db->query("SELECT * FROM tr_inquiry WHERE id_customer = '$id_customer' ")->result();
		// $idcr = $cr[0]->no_inquiry;
		//$loop=0; 
		foreach($dt AS $dt){
		//$loop++;
		$id_category3=$dt->id_material;
		$crcl	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE no_inquery = '$idcr' AND id_category3='$id_category3' ")->result();	
		$lot	= $this->db->query("SELECT * FROM stock_material WHERE id_gudang = '3' AND id_category3='$id_category3' ")->result();	
		echo "
		<tr id='list_penawaran_slot_$loop'>
			<th   width='10%' id='weightmaterial_".$loop."'><input type='text' class='form-control del".$loop."' value='0' readonly id='dt_weight_mat_$loop' required name='dt[$loop][weight_mat]'></th>
			
		</tr>
		";
		};
	}
	function AddMaterial4(){
        $loop=$_GET['nomor'].$_GET['urut'];
		$id_dt = $_GET['id_dt'];
		// $no_penawaran=$_GET['no_penawaran'];
		// $dt1	= $this->db->query("SELECT * FROM tr_spk_marketing WHERE id_spkmarketing = '$no_penawaran' ")->result();
		// $id_customer = $dt1[0]->id_customer;
		// $nm	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
		// $nama = $nm[0]->name_customer;
		// $dt	= $this->db->query("SELECT a.*, b.nama as nama3, b.hardness as hard FROM dt_spkmarketing as a inner join //ms_inventory_category3 as b on a.id_category3 = b.id_category3 WHERE a.id_spkmarketing = '$no_penawaran'  ")->result();
		$dt	= $this->db->query("SELECT a.* FROM dt_spkmarketing as a WHERE a.id_dt_spkmarketing = '$id_dt'  ")->result();
		// $cr	= $this->db->query("SELECT * FROM tr_inquiry WHERE id_customer = '$id_customer' ")->result();
		// $idcr = $cr[0]->no_inquiry;
		//$loop=0; 
		foreach($dt AS $dt){
		//$loop++;
		$id_category3=$dt->id_material;
		$crcl	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE no_inquery = '$idcr' AND id_category3='$id_category3' ")->result();	
		$lot	= $this->db->query("SELECT * FROM stock_material WHERE id_gudang = '3' AND id_category3='$id_category3' ")->result();	
		echo "
		<tr id='list_penawaran_slot_$loop'>
			<th width='10%'  ><input type='text' class='form-control del".$loop."' value=' ' id='dt_remarks_$loop' required name='dt[$loop][remarks]'></th>
		</tr>
		";
		};
	}
	function AddMaterial5(){
       $loop=$_GET['nomor'].$_GET['urut'];
		$id_dt = $_GET['id_dt'];
		// $no_penawaran=$_GET['no_penawaran'];
		// $dt1	= $this->db->query("SELECT * FROM tr_spk_marketing WHERE id_spkmarketing = '$no_penawaran' ")->result();
		// $id_customer = $dt1[0]->id_customer;
		// $nm	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
		// $nama = $nm[0]->name_customer;
		// $dt	= $this->db->query("SELECT a.*, b.nama as nama3, b.hardness as hard FROM dt_spkmarketing as a inner join //ms_inventory_category3 as b on a.id_category3 = b.id_category3 WHERE a.id_spkmarketing = '$no_penawaran'  ")->result();
		$dt	= $this->db->query("SELECT a.* FROM dt_spkmarketing as a WHERE a.id_dt_spkmarketing = '$id_dt'  ")->result();
		// $cr	= $this->db->query("SELECT * FROM tr_inquiry WHERE id_customer = '$id_customer' ")->result();
		// $idcr = $cr[0]->no_inquiry;
		//$loop=0; 
		foreach($dt AS $dt){
		//$loop++;
		$id_category3=$dt->id_material;
		$crcl	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE no_inquery = '$idcr' AND id_category3='$id_category3' ")->result();	
		$lot	= $this->db->query("SELECT * FROM stock_material WHERE id_gudang = '3' AND id_category3='$id_category3' ")->result();	
		echo "
		<tr id='list_penawaran_slot_$loop'>
			<th  width='10%'><button type='button' class='btn btn-sm btn-danger del".$loop."' title='Ambil' id='tbh_ata' data-role='qtip' onClick='HapusItem(".$loop.");'><i class='fa fa-times'></i></button></th> 
		</tr>
		";
		};
	}

	function GetThickness()
    {
        $id_produk=$_GET['id_produk'];
		$dt1	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE id_dt_inquery = '$id_produk' ")->result();
		$id_crcl = $dt1[0]->thickness;
		echo "<input type='text' class='form-control' value='$id_crcl' readonly id='thickness' required name='thickness'>";
	}
function GetDensity()
    {
        $id_produk=$_GET['id_produk'];
		$dt1	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE id_dt_inquery = '$id_produk' ")->result();
		$density = $dt1[0]->density;
		echo "<input type='text' class='form-control' value='$density' readonly id='density' required name='density'>";
	}
function GetSurface()
    {
        $id_produk=$_GET['id_produk'];
		$dt1	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE id_dt_inquery = '$id_produk' ")->result();
		$id_crcl = $dt1[0]->id_category3;
		$nm	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_crcl' ")->result();
		$nama = $nm[0]->id_surface;
		$id_surface	= $this->db->query("SELECT * FROM ms_surface WHERE id_surface = '$nama' ")->result();
		$isi_surface = $id_surface[0]->nm_surface;
		echo "<input type='text' class='form-control' value='$isi_surface' readonly id='surface' required name='surface'>";
	}
function totalw()
    {
        $hgdeal=$_GET['hgdeal'];
		$weight=$_GET['weight'];
		$qty=$_GET['qty'];
		$id=$_GET['id'];
		$twight = $weight*$qty;
		echo "<input type='text' class='form-control' value='$twight' readonly id='dp_twight_$id' required name='dp[$id][twight]'>";
	}
function totalhg()
    {
		$hgdeal=$_GET['hgdeal'];
        $qty=$_GET['qty'];
		$id=$_GET['id'];
		$thg = number_format($qty * $hgdeal,2,',','.');
		$th = $qty * $hgdeal;
		echo "<div hidden><input type='text' class='form-control' value='$th' readonly id='dp_tharga_$id' required name='dp[$id][tharga]'></div>
		<input type='text' class='form-control' value='$thg' readonly>";
	}
function HitungPisau()
    {
        $qty=$_GET['qty'];
		$id=$_GET['id'];
		$quantity = $qty+1;
		$pisau=$quantity*2;
		echo "<input type='text' class='form-control' readonly value='$pisau' id='stok_jmlpisau_$id' required name='stok[$id][jmlpisau]'>";
	}
function GetPotongan()
    {
        $id_produk=$_GET['id_produk'];
		$dt1	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE id_dt_inquery = '$id_produk' ")->result();
		$id_crcl = $dt1[0]->thickness;
		if($id_crcl > 0.2){
			$potongan='1';
		}else{
			$potongan='2';
		};
		echo "<input type='text' class='form-control' value='$potongan' readonly id='potongan_pinggir' required name='potongan_pinggir'>";
	}
function HitungTPanjang()
    {
        $hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil = $total_panjang+$hasilpanjang;
		echo "<input type='number' class='form-control' value='$hasil' id='total_panjang' readonly required name='total_panjang' >";
	}
function HitungJPisau()
    {
        $jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$hasil = $jml_pisau+$jumlahpisau;
		echo "<input type='number' class='form-control' value='$hasil' id='jml_pisau' readonly required name='jml_pisau' >";
	}
function HitungJMother()
    {
        $jml_mother=$_GET['jml_mother'];
		$hasil = $jml_mother+1;
		echo "<input type='number' class='form-control' value='$hasil' id='jml_mother' readonly required name='jml_mother' >";
	}
function HitungTBerat()
    {
         $hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$thickness=$_GET['thickness'];
		$lebarcc=$_GET['lebarcc'];
		$density=$_GET['density'];
		$hpanjang = $total_panjang+$hasilpanjang;
		$hasil= $hpanjang*$density*$lebarcc*$thickness;
		echo "<input type='number' value='$hasil' class='form-control' id='total_berat' readonly required name='total_berat' >";
	}
function GetStock()
    {
        $id_produk=$_GET['id_produk'];
		if(!empty($_GET['lebar_coil'])){
			$lebar_coil=$_GET['lebar_coil'];
			}else{
			$lebar_coil= '1';
			};
		$dt	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE id_dt_inquery = '$id_produk' ")->result();
		$thickness = $dt[0]->thickness;
		if($thickness > 0.2){
			$potongan='1';
		}else{
			$potongan='2';
		};
		$ppinggir=$potongan^2;
		$dt1	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE id_dt_inquery = '$id_produk' ")->result();
		$id_crcl = $dt1[0]->id_category3;
		$nm	= $this->Delivery_order_model->caristok($id_crcl);
		$loop=0;
		foreach( $nm as $nama){
			$loop++;
			$panjangmaterial = $nama->width*$nama->density*$thickness;
			$hasilpanjang = number_format($nama->totalweight/$panjangmaterial,2) ;
			$firstcount = $nama->width*$ppinggir;
			$jcc = $firstcount/$lebar_coil;
			$lastcount = $lebar_coil*$jcc;
			$sp= number_format($firstcount-$lastcount,2);
		echo "
		<tr id='tabel_stok_$loop'>
			<th hidden><input type='text' class='form-control' value='$nama->id_stock' readonly id='stok_idstk_$loop' required name='stok[$loop][idstk]'></th>
			<th><input type='text' class='form-control' value='$nama->lotno' readonly id='stok_lotno_$loop' required name='stok[$loop][lotno]'></th>
			<th><input type='text' class='form-control' value='$nama->nama_material' readonly id='stok_namamaterial_$loop' required name='stok[$loop][namamaterial]'></th>
			<th><input type='text' class='form-control' value='$nama->weight' readonly id='stok_weight_$loop' required name='stok[$loop][weight]'></th>
			<th><input type='text' class='form-control' value='$nama->density' readonly id='stok_density_$loop' required name='stok[$loop][density]'></th>
			<th><input type='text' class='form-control' value='$hasilpanjang' readonly id='stok_hasilpanjang_$loop' required name='stok[$loop][hasilpanjang]'></th>
			<th><input type='text' class='form-control' value='$nama->width' readonly id='stok_width_$loop' required name='stok[$loop][width]'></th>
			<th><input type='text' class='form-control' value='$lebar_coil' readonly id='stok_lebarcc_$loop' required name='stok[$loop][lebarcc]'></th>
			<th><input type='text' class='form-control' value='$jcc' readonly id='stok_jumlahcc_$loop' required name='stok[$loop][jumlahcc]'></th>
			<th><input type='text' class='form-control' value='$sp' readonly id='stok_sisapotongan_$loop' required name='stok[$loop][sisapotongan]'></th>
			<th><input type='text' class='form-control'   id='stok_qty_$loop' data-role='qtip' onkeyup='return HitungPisau($loop);' required name='stok[$loop][qty]'></th>
			<th id='pisau_$loop'><input type='text' class='form-control' readonly  id='stok_jmlpisau_$loop' required name='stok[$loop][jmlpisau]'></th>
			<th><button type='button' class='btn btn-sm btn-success' title='Ambil' id='tambah_$loop' data-role='qtip' onClick='return TambahItem($loop);'><i class='fa fa-plus-square'></i></button></th>
		</tr>
		";
		};
	}
function GetUsed()
    {
        $idstk=$_GET['idstk'];
		$lotno=$_GET['lotno'];
		$namamaterial=$_GET['namamaterial'];
		$weight=$_GET['weight'];
		$density=$_GET['density'];
		$hasilpanjang=$_GET['hasilpanjang'];
		$width=$_GET['width'];
		$lebarcc=$_GET['lebarcc'];
		$jumlahcc=$_GET['jumlahcc'];
		$sisapotongan=$_GET['sisapotongan'];
		$qtystock=$_GET['qtystock'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$loop=$_GET['jumlah']+1;
		echo "
		<tr id='tabel_stok_$loop'>
			<th hidden><input type='text' class='form-control' value='$idstk' readonly id='used_idstk_$loop' required name='used[$loop][idstk]'></th>
			<th><input type='text' class='form-control' value='$lotno' readonly id='used_lotno_$loop' required name='used[$loop][lotno]'></th>
			<th><input type='text' class='form-control' value='$namamaterial' readonly id='used_namamaterial_$loop' required name='used[$loop][namamaterial]'></th>
			<th><input type='text' class='form-control' value='$weight' readonly id='used_weight_$loop' required name='used[$loop][weight]'></th>
			<th><input type='text' class='form-control' value='$density' readonly id='used_density_$loop' required name='used[$loop][density]'></th>
			<th><input type='text' class='form-control' value='$hasilpanjang' readonly id='used_hasilpanjang_$loop' required name='used[$loop][hasilpanjang]'></th>
			<th><input type='text' class='form-control' value='$width' readonly id='used_width_$loop' required name='used[$loop][width]'></th>
			<th><input type='text' class='form-control' value='$lebarcc' readonly id='used_lebarcc_$loop' required name='used[$loop][lebarcc]'></th>
			<th><input type='text' class='form-control' value='$jumlahcc' readonly id='used_jumlahcc_$loop' required name='used[$loop][jumlahcc]'></th>
			<th><input type='text' class='form-control' value='$sisapotongan' readonly id='used_sisapotongan_$loop' required name='used[$loop][sisapotongan]'></th>
			<th><input type='text' class='form-control' value='$qtystock'  readonly id='used_qty_$loop' required name='used[$loop][qty]'></th>
			<th><input type='text' class='form-control' value='$jumlahpisau' readonly  id='used_jmlpisau_$loop' required name='used[$loop][jmlpisau]'></th>
		</tr>
		";
	}
function getsales()
    {
        $id_customer=$_GET['id_customer'];
		$kategory3	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
		$id_karyawan = $kategory3[0]->id_karyawan;
		$karyawan	= $this->db->query("SELECT * FROM ms_karyawan WHERE id_karyawan = '$id_karyawan' ")->result();
		$nama_karyawan = $karyawan[0]->nama_karyawan;
		echo "	<div class='col-md-8' hidden>
					<input type='text' class='form-control' id='nama_sales' value='$id_karyawan' required name='nama_sales' readonly placeholder='Sales Marketing'>
				</div>
				<div class='col-md-8'>
					<input type='text' class='form-control' id='id_sales' value='$nama_karyawan'  required name='id_sales' readonly placeholder='Sales Marketing'>
				</div>";
	}
function getpic()
    {
        $id_customer=$_GET['id_customer'];
		$kategory3	= $this->db->query("SELECT * FROM child_customer_pic WHERE id_customer = '$id_customer' ")->result();
		echo "<select id='pic_customer' name='pic_customer' class='form-control select' required>
				<option value=''>--Pilih--</option>";
				foreach($kategory3 as $pic){
		echo "<option value='$pic->name_pic'>$pic->name_pic</option>";
				}
		echo "</select>";
	}

function cari_thickness()
    {
        $id_category3=$_GET['id_category3'];
		$kategory3	= $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$id_category3' ")->result();
		$thickness = $kategory3[0]->nilai_dimensi;
		echo "<input type='text' class='form-control' readonly id='thickness' value='$thickness' required name='thickness' placeholder='Bentuk Material'>";
	}
function cari_density()
    {
        $id_category3=$_GET['id_category3'];
		$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
		$density = $kategory3[0]->density;
		echo "<input type='text' class='form-control' readonly id='density' value='$density' required name='density' placeholder='Bentuk Material'>";
	}
function hitung_komisi()
    {
        $bottom=$_GET['bottom'];
		$komisi=$_GET['bottom']*$_GET['komisi']/100;
		$hasil=$bottom+$komisi;
		echo "<input type='text' class='form-control' value='$hasil' id='harga_penawaran'  required name='harga_penawaran' placeholder='Bentuk Material'>";
	}
function cari_inven1()
    {
        $id_category3=$_GET['id_category3'];
		$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
		$inven1 = $kategory3[0]->id_category1;
		echo "<input type='text' class='form-control' id='inven1' value='$inven1'  required name='inven1' placeholder='Bentuk Material'>";
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

	public function Approve(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$data = [
			'status_approve' 		=> '1'
		];

		$this->db->trans_begin();
		$this->db->where('id_spkmarketing',$id)->update("tr_spk_marketing",$data);

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
        $data=$this->Delivery_order_model->level_2($inventory_1);
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
        $data=$this->Delivery_order_model->level_3($inventory_2);

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
		public function saveNewPenawaran()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$this->db->trans_begin();
		$code = $post['no_penawaran'];
		$data = [
							'id_child_penawaran'	=> $code,
							'id_category3'			=> $post['id_category3'],
							'no_penawaran'			=> $post['no_penawaran'],
							'bentuk_material'		=> $post['bentuk_material'],
							'id_bentuk'				=> $post['id_bentuk'],
							'thickness'				=> $post['thickness'],
							'density'				=> $post['density'],
							'lotno'					=> $post['lotno'],
							'width'					=> $post['width'],
							'forecast'				=> $post['forecast'],
							'inven1'				=> $post['inven1'],
							'bottom'				=> $post['bottom'],
							'dasar_harga'			=> $post['dasar_harga'],
							'komisi'				=> $post['komisi'],
							'keterangan'			=> $post['keterangan'],
							'harga_penawaran'		=> $post['harga_penawaran'],
							'status_approve'			=> '0',
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
               $this->db->insert('child_penawaran',$data);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $code,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $code,
			  'status'	=> 1
			);
		}

  		echo json_encode($status);

    }


	public function SaveNewHeader(){
        $this->auth->restrict($this->addPermission);
		$post 		= $this->input->post();\
		
		print_r($post);
		exit;
		
		$code 		= $this->Delivery_order_model->generate_code();
		$no_surat 	= $this->Delivery_order_model->BuatNomor();
		
		$data = [
					'id_delivery_order'		=> $code,
					'no_surat'				=> $no_surat,
					'tgl_delivery_order'	=> date('Y-m-d'),
					'id_customer'			=> $post['id_customer'],
					'nama_customer'			=> $post['nama_customer'],
					'no_spk_marketing'		=> $post['no_surat'],
					'reff'		            => $post['reff'],
					'driver'		        => $post['driver'],
					'nopol'		            => $post['nopol'],
					'created_on'			=> date('Y-m-d H:i:s'),
					'created_by'			=> $this->auth->user_id()
				];
               
		$numb1 =0;
		$ArrDetail =  array();
		$UpdateArr =  array();
		foreach($_POST['dp'] as $val => $dt){
			$numb1++;
			foreach($dt['detail'] AS $vaX => $value){
				if(!empty($value['qty_mat']) AND !empty($value['weight_mat'])){
					$ArrDetail[$val.$vaX]['id_delivery_order']		= $code;
					$ArrDetail[$val.$vaX]['id_dt_delivery_order']	= $code.'-'.$numb1;
					$ArrDetail[$val.$vaX]['id_material']		    = $dt['id_material'];
					$ArrDetail[$val.$vaX]['nm_material']		    = $dt['material'];
					$ArrDetail[$val.$vaX]['no_alloy']		        = $dt['no_alloy'];
					$ArrDetail[$val.$vaX]['thickness']		        = $dt['thickness'];
					$ArrDetail[$val.$vaX]['width']		        	= str_replace(',','',$dt['width']);
					$ArrDetail[$val.$vaX]['length']		        	= str_replace(',','',$dt['length']);
					$ArrDetail[$val.$vaX]['qty_order']			    = str_replace(',','',$dt['qty_produk']);

					$ArrDetail[$val.$vaX]['id_stock']			    = $value['lot'];
					$ArrDetail[$val.$vaX]['qty']			    	= str_replace(',','',$value['qty']);
					$ArrDetail[$val.$vaX]['weight']			    	= str_replace(',','',$value['weight']);
					$ArrDetail[$val.$vaX]['qty_mat']			    = str_replace(',','',$value['qty_mat']);
					$ArrDetail[$val.$vaX]['weight_mat']			    = str_replace(',','',$value['weight_mat']);
					$ArrDetail[$val.$vaX]['remark']			    	= $value['remarks'];
					$ArrDetail[$val.$vaX]['bantuan']			    = $value['bantuan'];
					$ArrDetail[$val.$vaX]['id_dt_spkmarketing']	    = $dt['id_dt_spkmarketing'];
					

					$ArrDetail[$val.$vaX]['created_by']			    = $this->auth->user_id();
					$ArrDetail[$val.$vaX]['created_on']			    = date('Y-m-d H:i:s');

					$UpdateArr[$val.$vaX]['id']			    		= $value['lot'];
					$UpdateArr[$val.$vaX]['qty']			    	= str_replace(',','',$value['qty_mat']);
					$UpdateArr[$val.$vaX]['weight']			    	= str_replace(',','',$value['weight_mat']);
				}
			}
		}

		//grouping sum
		$temp = [];
		foreach($UpdateArr as $val => $value) {
			if(!array_key_exists($value['id'], $temp)) {
				$temp[$value['id']]['qty'] 		= 0;
				$temp[$value['id']]['weight'] 	= 0;
			}
			$temp[$value['id']]['id'] 		= $value['id'];
			$temp[$value['id']]['qty'] 		+= $value['qty'];
			$temp[$value['id']]['weight'] 	+= $value['weight'];
		}

		$ArrStock = array();
		foreach ($temp as $key => $value) {
			$rest_pusat = $this->db->get_where('stock_material',array('id_gudang'=>'3', 'id_stock'=>$value['id']))->result();
			
			if(!empty($rest_pusat)){

				$QTY = $rest_pusat[0]->qty - $value['qty'];
				$TWG = $rest_pusat[0]->totalweight - $value['weight'];
				$SAT = 0;
				if($QTY > 0 AND $TWG > 0){
					$SAT = $TWG / $QTY;
				}
				$ArrStock[$key]['id_stock'] 	= $value['id'];
				$ArrStock[$key]['qty'] 			= $QTY;
				$ArrStock[$key]['totalweight'] 	= $TWG;
				$ArrStock[$key]['weight'] 		= $SAT;
			}
		}
		
		// print_r($ArrStock);
		// print_r($data);
		// print_r($ArrDetail);
		// exit;

		$this->db->trans_start();
			$this->db->insert('tr_delivery_order',$data);
			$this->db->insert_batch('dt_delivery_order_child',$ArrDetail);
			// if(!empty($ArrStock)){
			// 	$this->db->update_batch('stock_material',$ArrStock,'id_stock');
			// }
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'	=>'Gagal Save Item. Thanks ...',
			  'code' 	=> $code,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'	=>'Success Save Item. invenThanks ...',
			  'code' 	=> $code,
			  'status'	=> 1
			);
		}

  		echo json_encode($status);

    }

	public function SaveNewHeaderEdit() {
        $this->auth->restrict($this->addPermission);
		$post 			= $this->input->post();
		$id_delivery 	= $post['id_delivery'];
		
		$data 	= [
					'nopol'		            => $post['nopol'],
					'modified_on'			=> date('Y-m-d H:i:s'),
					'modified_by'			=> $this->auth->user_id()
					];

		$numb1 =0;
		$ArrDetail =  array();
		$UpdateArr =  array();
		foreach($_POST['dp'] as $val => $dt){
			$numb1++;
			foreach($dt['detail'] AS $vaX => $value){
				if(!empty($value['qty_mat']) AND !empty($value['weight_mat'])){
					$ArrDetail[$val.$vaX]['id_delivery_order']		= $id_delivery;
					$ArrDetail[$val.$vaX]['id_dt_delivery_order']	= $id_delivery.'-'.$numb1;
					$ArrDetail[$val.$vaX]['id_material']		    = $dt['id_material'];
					$ArrDetail[$val.$vaX]['nm_material']		    = $dt['material'];
					$ArrDetail[$val.$vaX]['no_alloy']		        = $dt['no_alloy'];
					$ArrDetail[$val.$vaX]['thickness']		        = $dt['thickness'];
					$ArrDetail[$val.$vaX]['width']		        	= str_replace(',','',$dt['width']);
					$ArrDetail[$val.$vaX]['length']		        	= str_replace(',','',$dt['length']);
					$ArrDetail[$val.$vaX]['qty_order']			    = str_replace(',','',$dt['qty_produk']);

					$ArrDetail[$val.$vaX]['id_stock']			    = $value['lot'];
					$ArrDetail[$val.$vaX]['qty']			    	= str_replace(',','',$value['qty']);
					$ArrDetail[$val.$vaX]['weight']			    	= str_replace(',','',$value['weight']);
					$ArrDetail[$val.$vaX]['qty_mat']			    = str_replace(',','',$value['qty_mat']);
					$ArrDetail[$val.$vaX]['weight_mat']			    = str_replace(',','',$value['weight_mat']);
					$ArrDetail[$val.$vaX]['remark']			    	= $value['remarks'];
					$ArrDetail[$val.$vaX]['bantuan']			    = $value['bantuan'];

					$ArrDetail[$val.$vaX]['created_by']			    = $this->auth->user_id();
					$ArrDetail[$val.$vaX]['created_on']			    = date('Y-m-d H:i:s');

					$UpdateArr[$val.$vaX]['id']			    		= $value['lot'];
					$UpdateArr[$val.$vaX]['qty']			    	= str_replace(',','',$value['qty_mat']);
					$UpdateArr[$val.$vaX]['weight']			    	= str_replace(',','',$value['weight_mat']);
				}
			}
		}

		//grouping sum
		$temp = [];
		foreach($UpdateArr as $val => $value) {
			if(!array_key_exists($value['id'], $temp)) {
				$temp[$value['id']]['qty'] 		= 0;
				$temp[$value['id']]['weight'] 	= 0;
			}
			$temp[$value['id']]['id'] 		= $value['id'];
			$temp[$value['id']]['qty'] 		+= $value['qty'];
			$temp[$value['id']]['weight'] 	+= $value['weight'];
		}

		$ArrStock = array();
		foreach ($temp as $key => $value) {
			$rest_pusat = $this->db->get_where('stock_material',array('id_gudang'=>'3', 'id_stock'=>$value['id']))->result();
			
			if(!empty($rest_pusat)){

				$QTY = $rest_pusat[0]->qty - $value['qty'];
				$TWG = $rest_pusat[0]->totalweight - $value['weight'];
				$SAT = 0;
				if($QTY > 0 AND $TWG > 0){
					$SAT = $TWG / $QTY;
				}
				$ArrStock[$key]['id_stock'] 	= $value['id'];
				$ArrStock[$key]['qty'] 			= $QTY;
				$ArrStock[$key]['totalweight'] 	= $TWG;
				$ArrStock[$key]['weight'] 		= $SAT;
			}
		}
		
		// print_r($ArrStock);
		// print_r($data);
		// print_r($ArrDetail);
		// exit;

		$this->db->trans_start();
			$this->db->where('id_delivery_order', $id_delivery);
			$this->db->update('tr_delivery_order',$data);

			$this->db->where('id_delivery_order', $id_delivery);
            $this->db->delete('dt_delivery_order_child');

			$this->db->insert_batch('dt_delivery_order_child',$ArrDetail);
			// if(!empty($ArrStock)){
			// 	$this->db->update_batch('stock_material',$ArrStock,'id_stock');
			// }
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $id_delivery,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $id_delivery,
			  'status'	=> 1
			);
		}

  		echo json_encode($status);
    }

	public function ReleaseDO(){

		$id 	= $this->input->post('id');
		$data 	= [
			'status_approve' => '1',
			'status_date'	=> date('Y-m-d H:i:s'),
			'status_by'		=> $this->auth->user_id()
		];

		//kurangi stock
		$get_list = $this->db->get_where('dt_delivery_order_child', array('id_delivery_order'=>$id))->result_array();
		$UpdateArr =  array();
		foreach ($get_list as $key => $value) {
			$UpdateArr[$key]['id']		= $value['id_stock'];
			$UpdateArr[$key]['qty']		= $value['qty_mat'];
			$UpdateArr[$key]['weight']	= $value['weight_mat'];
		}

		//grouping sum
		$temp = [];
		foreach($UpdateArr as $val => $value) {
			if(!array_key_exists($value['id'], $temp)) {
				$temp[$value['id']]['qty'] 		= 0;
				$temp[$value['id']]['weight'] 	= 0;
			}
			$temp[$value['id']]['id'] 		= $value['id'];
			$temp[$value['id']]['qty'] 		+= $value['qty'];
			$temp[$value['id']]['weight'] 	+= $value['weight'];
		}

		$ArrStock = array();
		foreach ($temp as $key => $value) {
			$rest_pusat = $this->db->get_where('stock_material',array('id_gudang'=>'3', 'id_stock'=>$value['id']))->result();
			
			if(!empty($rest_pusat)){

				$QTY = $rest_pusat[0]->qty - $value['qty'];
				$TWG = $rest_pusat[0]->totalweight - $value['weight'];
				$SAT = 0;
				if($QTY > 0 AND $TWG > 0){
					$SAT = $TWG / $QTY;
				}
				$ArrStock[$key]['id_stock'] 	= $value['id'];
				$ArrStock[$key]['qty'] 			= $QTY;
				$ArrStock[$key]['totalweight'] 	= $TWG;
				$ArrStock[$key]['weight'] 		= $SAT;
			}
		}

		// exit;
		$this->db->trans_start();
			$this->db->where("id_delivery_order",$id);
			$this->db->update("tr_delivery_order",$data);

			if(!empty($ArrStock)){
				$this->db->update_batch('stock_material',$ArrStock,'id_stock');
			}
		$this->db->trans_complete();

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
	
	public function SaveEditHeader()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $post['id_spkmarketing'];
		$this->db->trans_begin();
		$data = [
							'tgl_spk_marketing'		=> date('Y-m-d'),
							'id_customer'			=> $post['id_customer'],
							'nama_customer'			=> $post['nama_customer'],
							'no_penawaran'			=> $post['no_penawaran'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
			   $this->db->where('id_spkmarketing',$code)->update("tr_spk_marketing",$data);
			$this->db->delete('dt_spkmarketing', array('id_spkmarketing' => $code));
			$this->db->delete('dt_spkmarketing_loading', array('id_spkmarketing' => $code));
		$numb1 =0;
		foreach($_POST['dp'] as $dp){
		$numb1++;        
                $stokpakai =  array(
							'id_spkmarketing'		=> $code,
							'id_dt_spkmarketing'	=> $code.'-'.$numb1,
							'id_child_penawaran'	=> $dp[id_child_penawaran],
							'id_material'		    => $dp[idmaterial],
							'no_alloy'		        => $dp[noalloy],
							'thickness'		        => $dp[thickness],
							'width'		        	=> $dp[width],
							'harga_penawaran'		=> $dp[hgpenaaran],
							'harga_deal'		    => $dp[hgdeal],
							'qty_produk'			=> $dp[qty],
							'weight'		    	=> $dp[weight],
							'total_weight'		    => $dp[twight],
							'total_harga'		    => $dp[tharga],
							'delivery'		    	=> $dp[ddate],
							'deal'		    		=> $dp[deal],
							'crcl'		    		=> $dp[crcl],
                            );
                    $this->db->insert('dt_spkmarketing',$stokpakai);
					$this->db->insert('dt_spkmarketing_loading',$stokpakai);
			
		    }
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $code,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $code,
			  'status'	=> 1
			);
		}

  		echo json_encode($status);

    }
	public function SaveEditHeadercontoh()
    {
  		$this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $post['id_shearing'];
		$this->db->trans_begin();
		$data = [
							'tgl_penawaran'			=> date('Y-m-d'),
							'id_customer'			=> $post['id_customer'],
							'id_produk'				=> $post['id_produk'],
							'material'				=> $post['material'],
							'thickness'				=> $post['thickness'],
							'density'				=> $post['density'],
							'surface'				=> $post['surface'],
							'lebar_coil'			=> $post['lebar_coil'],
							'qty'					=> $post['qty'],
							'mata_uang'				=> $post['mata_uang'],
							'potongan_pinggir'		=> $post['potongan_pinggir'],
							'total_panjang'			=> $post['total_panjang'],
							'jml_pisau'				=> $post['jml_pisau'],
							'jml_mother'			=> $post['jml_mother'],
							'total_berat'			=> $post['total_berat'],
							
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
			$this->db->where('id_shearing',$code)->update("tr_penawaran_shearing",$data);
			$this->db->delete('dt_penawaran_shearing_used', array('id_shearing' => $code));
			
		$numb1 =0;
		foreach($_POST['used'] as $use){
		$numb1++;        
                $stokpakai =  array(
							'id_shearing'		    	=> $code,
							'id_used_syock_penawaran'	=> $code.'-'.$numb1,
							'idstk'		    			=> $use[idstk],
							'lotno'		        		=> $use[lotno],
							'namamaterial'		        => $use[namamaterial],
							'weight'		        	=> $use[weight],
							'density'		        	=> $use[density],
							'hasilpanjang'		        => $use[hasilpanjang],
							'width'		    			=> $use[width],
							'lebarcc'					=> $use[lebarcc],
							'jumlahcc'		    		=> $use[jumlahcc],
							'sisapotongan'		    	=> $use[sisapotongan],
							'qty'		    			=> $use[qty],
							'jmlpisau'		    		=> $use[jmlpisau]
                            );
                    $this->db->insert('dt_penawaran_shearing_used',$stokpakai);
			
		    }
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $code,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $code,
			  'status'	=> 1
			);
		}

  		echo json_encode($status);


    }
	public function saveEditPenawaran()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $this->Delivery_order_model->generate_code();
		$this->db->trans_begin();
		$id = $post['id_child_penawaran'];
		$data = [
							'id_category3'			=> $post['id_category3'],
							'bentuk_material'		=> $post['bentuk_material'],
							'id_bentuk'				=> $post['id_bentuk'],
							'thickness'				=> $post['thickness'],
							'density'				=> $post['density'],
							'forecast'				=> $post['forecast'],
							'inven1'				=> $post['inven1'],
							'bottom'				=> $post['bottom'],
							'dasar_harga'			=> $post['dasar_harga'],
							'komisi'				=> $post['komisi'],
							'keterangan'			=> $post['keterangan'],
							'harga_penawaran'		=> $post['harga_penawaran'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
               $this->db->where('id_child_penawaran',$id)->update("child_penawaran",$data);

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
public function deletePenawaran(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$this->db->trans_begin();
		$this->db->delete('child_penawaran', array('id_child_penawaran' => $id));

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

	public function saveEditInventory()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Delivery_order_model->generate_id();
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
        $comp=$this->Delivery_order_model->compotition($inventory_2);
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
        $dim=$this->Delivery_order_model->bentuk($id_bentuk);
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
        $comp=$this->Delivery_order_model->compotition_edit($inventory_2);
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
        $dim=$this->Delivery_order_model->bentuk_edit($id_bentuk);
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
		$code = $this->Delivery_order_model->generate_id();
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
		$code = $this->Delivery_order_model->generate_id();
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
        $comp=$this->Delivery_order_model->compotition($inventory_2);
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
	
	function CariIdMaterial()
    {
        $idpr=$_GET['idpr'];
		$loop=$_GET['id'];
		$material = $this->db->query("SELECT * FROM stock_material WHERE id_stock = '$idpr'  ")->result();
		$isi = $material[0]->qty; 
		//echo "<input readonly type='text' value='".$isi."' 	class='form-control' id='dt_idmaterial_".$loop."' 	required //name='dt[".$loop."][idmaterial]' >";
		echo "<input type='text' class='form-control del".$loop."' value='".$isi."' readonly id='dt_qty_mat_".$loop."' required name='dt[".$loop."][qty_mat]'>";
	}
	
	function CariWeightMaterial()
    {
        $idpr=$_GET['idpr'];
		$loop=$_GET['id'];
		$material = $this->db->query("SELECT * FROM stock_material WHERE id_stock = '$idpr'  ")->result();
		$isi = $material[0]->totalweight; 
		//echo "<input readonly type='text' value='".$isi."' 	class='form-control' id='dt_idmaterial_".$loop."' 	required //name='dt[".$loop."][idmaterial]' >";
		echo "<input type='text' class='form-control del".$loop."' value='".$isi."' readonly id='dt_weight_mat_".$loop."' required name='dt[".$loop."][weight_mat]'>";
	}
	function CariBentukMaterial()
    {
        $idpr=$_GET['idpr'];
		$loop=$_GET['id'];
		$material = $this->db->query("SELECT * FROM stock_material WHERE id_stock = '$idpr'  ")->result();
		$isi = $material[0]->id_bentuk; 
		//echo "<input readonly type='text' value='".$isi."' 	class='form-control' id='dt_idmaterial_".$loop."' 	required //name='dt[".$loop."][idmaterial]' >";
		echo "<input type='text' class='form-control del".$loop."' value='".$isi."' readonly id='dt_bentuk_mat_".$loop."' required name='dt[".$loop."][bentuk_mat]'>";
	}
	function CariNolotMaterial()
    {
        $idpr=$_GET['idpr'];
		$loop=$_GET['id'];
		$material = $this->db->query("SELECT * FROM stock_material WHERE id_stock = '$idpr'  ")->result();
		$isi = $material[0]->lotno; 
		//echo "<input readonly type='text' value='".$isi."' 	class='form-control' id='dt_idmaterial_".$loop."' 	required //name='dt[".$loop."][idmaterial]' >";
		echo "<input type='text' class='form-control del".$loop."' value='".$isi."' readonly id='dt_nolot_mat_".$loop."' required name='dt[".$loop."][nolot_mat]'>";
	}
	function CariNoslitMaterial()
    {
        $idpr=$_GET['idpr'];
		$loop=$_GET['id'];
		$material = $this->db->query("SELECT * FROM stock_material WHERE id_stock = '$idpr'  ")->result();
		$isi = $material[0]->lot_slitting; 
		//echo "<input readonly type='text' value='".$isi."' 	class='form-control' id='dt_idmaterial_".$loop."' 	required //name='dt[".$loop."][idmaterial]' >";
		echo "<input type='text' class='form-control del".$loop."' value='".$isi."' readonly id='dt_noslit_mat_".$loop."' required name='dt[".$loop."][noslit_mat]'>";
	}
	
	function GetPenawaran2()
    {
        $no_penawaran=$_GET['no_penawaran'];
		$id_delivery_order=$_GET['id_delivery_order'];
		$dt1	= $this->db->query("SELECT * FROM tr_spk_marketing WHERE no_surat = '$no_penawaran' ")->result();
		$id_customer = $dt1[0]->id_customer;
		$nm	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
		$nama = $nm[0]->name_customer;
		$noquot=$dt1[0]->id_spkmarketing;
		// $dt	= $this->db->query("SELECT a.*, b.nama as nama3, b.hardness as hard FROM dt_spkmarketing as a inner join ms_inventory_category3 as b on a.id_category3 = b.id_category3 WHERE a.id_spkmarketing = '$no_penawaran'  ")->result();
		$dt	= $this->db->query("SELECT a.* FROM dt_spkmarketing as a WHERE a.id_spkmarketing = '$noquot'  ")->result();
		$cr	= $this->db->query("SELECT * FROM tr_inquiry WHERE id_customer = '$id_customer' ")->result();
		$idcr = $cr[0]->no_inquiry;
		$loop=0; foreach($dt AS $dt){
		$loop++;
		$id_category3=$dt->id_material;
		$crcl	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE no_inquery = '$idcr' AND id_category3='$id_category3' ")->result();	
		$lot	= $this->db->query("SELECT * FROM stock_material WHERE id_gudang = '3' AND id_category3='$id_category3' ")->result();	
		
		$getChild = $this->db->get_where('dt_delivery_order_child', array('id_delivery_order'=>$id_delivery_order,'no_alloy'=>$dt->no_alloy))->result_array();
		
		echo "
		<tr id='tabel_penawaran_$loop'>
		    <th hidden><input type='text' class='form-control nomor' value='0' readonly id='no_$loop' required name='dp[$loop][no]'></th>
			
			<th hidden><input type='text' class='form-control' value='$dt->id_dt_spkmarketing' readonly id='dp_id_dt_spkmarketing_$loop' required name='dp[$loop][id_dt_spkmarketing]'></th>
			
			<th><input type='text' class='form-control' value='$dt->id_spkmarketing' readonly id='dp_idmaterial_$loop' required name='dp[$loop][idmaterial]'></th>
			
			<th><input type='text' class='form-control' value='$dt->no_alloy' readonly id='dp_noalloy_$loop' required name='dp[$loop][noalloy]'></th>
			
			<th><input type='text' class='form-control' value='$dt->thickness' readonly id='dp_thickness_$loop' required name='dp[$loop][thickness]'></th>
			
			<th><input type='text' class='form-control' value='$dt->total_weight' readonly id='dp_width_$loop' required name='dp[$loop][width]'></th>
			
			<th><input type='text' class='form-control' value='$dt->crcl' readonly id='crcl_$loop' required name='dp[$loop][crcl]'></th>
			
			<th hidden><select id='dp_lot_$loop' name='dp[$loop][lot]' class='form-control select' onchange='CariProperties(".$loop.")' required>
						<option value=''>--Pilih--</option>";
						foreach($lot AS $lotx){
						$lotslit = $lotx->lotno.'|'.$lotx->lot_slitting;
						echo"<option value='$lotx->id_stock'>$lotslit</option>";
						}
		    echo"</select></th>
			
			<th hidden ><input type='text' class='form-control' value='0' readonly id='dp_qty_mat_$loop' required name='dp[$loop][qty_mat]'></th>
			<th hidden><input type='text' class='form-control' value='0' readonly id='dp_weight_mat_$loop' required name='dp[$loop][weight_mat]'></th>
			<th hidden><input type='text' class='form-control' value=' ' id='dp_remarks_$loop' required name='dp[$loop][remarks]'></th>
			<th>
				<input type='hidden' id='number_".$loop."' value='0'>
				<button type='button' class='btn btn-sm btn-success' title='Ambil' id='tbh_ata' data-role='qtip' onClick='addmaterial(".$loop.");' data-no='".$loop."'>Add Lot</button>
			</th>";

			echo "<th id='det_lot1_".$loop."'>";
				$nox = 0;
				foreach($getChild AS $val => $valx){$nox++;
					$loop2 = $loop.$nox;
					echo "<div><select id='dt_lot_$loop2' name='dt[$loop2][lot]' class='form-control select del".$loop2."' onchange='CariProperties(".$loop2.")' required>";
							foreach($lot AS $lot2){
								$lotslit = $lot2->lotno.'|'.$lot2->lot_slitting;
								$selected = ($valx['id_stock'] == $lot2->id_stock)?'selected':'';
								echo"<option value='$lot2->id_stock' ".$selected.">$lotslit</option>";
							}
					echo "</select></div>";
				}
			echo "</th>";
			echo "<th id='det_lot2_".$loop."'>";
				$nox = 0;
				foreach($getChild AS $val => $valx){$nox++;
					$loop2 = $loop.$nox;
					echo "
						<div id='idmaterial_".$loop2."'>
							<input type='text' class='form-control del".$loop2."' value='".$valx['qty_mat']."' readonly id='dt_qty_mat_$loop2' required name='dt[$loop2][qty_mat]'>
							<input type='hidden' class='form-control del".$loop2."' value='0' readonly id='dt_bentuk_mat_$loop2' required name='dt[$loop2][bentuk_mat]'>
							<input type='hidden' class='form-control del".$loop2."' value='0' readonly id='dt_nolot_mat_$loop2' required name='dt[$loop2][nolot_mat]'>
							<input type='hidden' class='form-control del".$loop2."' value='0' readonly id='dt_noslit_mat_$loop2' required name='dt[$loop2][noslit_mat]'>
							
							<input type='hidden' class='form-control del".$loop2."' value='$dt->id_dt_spkmarketing' readonly id='dt_id_dt_spkmarketing2_$loop2' required name='dt[$loop2][id_dt_spkmarketing2]'>
							
							<input type='hidden' class='form-control del".$loop2."' value='$dt->id_spkmarketing' readonly id='dt_idmaterial2_$loop2' required name='dt[$loop2][idmaterial2]'>
							
							<input type='hidden' class='form-control del".$loop2."' value='$dt->no_alloy' readonly id='dt_noalloy2_$loop2' required name='dt[$loop2][noalloy2]'>
							
							<input type='hidden' class='form-control del".$loop2."' value='$dt->thickness' readonly id='dt_thickness2_$loop2' required name='dt[$loop2][thickness2]'>
							
							<input type='hidden' class='form-control del".$loop2."' value='$dt->total_weight' readonly id='dt_width2_$loop2' required name='dt[$loop2][width2]'>
							
							<input type='hidden' class='form-control del".$loop2."' value='$dt->crcl' readonly id='crcl2_$loop2' required name='dt[$loop2][crcl2]'>
							
						</div>
						";
				}
			echo "</th>";
			echo "<th id='det_lot3_".$loop."'>";
				$nox = 0;
				foreach($getChild AS $val => $valx){$nox++;
					$loop2 = $loop.$nox;
					echo " 
					<div id='weightmaterial_".$loop2."'>
					<input type='text' class='form-control del".$loop2."' value='".$valx['weight_mat']."' readonly id='dt_weight_mat_$loop2' required name='dt[$loop2][weight_mat]'>
					</div>";
				}
			echo "</th>";
			echo "<th id='det_lot4_".$loop."'>";
				$nox = 0;
				foreach($getChild AS $val => $valx){$nox++;
					$loop2 = $loop.$nox;
					echo "<div>
					<input type='text' class='form-control del".$loop2."' value='".$valx['remark']."' id='dt_remarks_$loop2' required name='dt[$loop2][remarks]'>
					</div>";
				}
			echo "</th>";
			echo "<th id='det_lot5_".$loop."'>";
				$nox = 0;
				foreach($getChild AS $val => $valx){$nox++;
					$loop2 = $loop.$nox;
					echo "<div >
					<button type='button' class='btn btn-sm btn-danger del".$loop2."' title='Ambil' id='tbh_ata' data-role='qtip' onClick='HapusItem(".$loop2.");'><i class='fa fa-times'></i></button>
					</div>";
				}
			echo "</th>";
		echo "</tr>";
		}; 
	}
	
	

}
