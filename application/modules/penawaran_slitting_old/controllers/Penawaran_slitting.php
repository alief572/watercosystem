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

class Penawaran_slitting extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Penawaran_Slitting.View';
    protected $addPermission  	= 'Penawaran_Slitting.Add';
    protected $managePermission = 'Penawaran_Slitting.Manage';
    protected $deletePermission = 'Penawaran_Slitting.Delete';

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Penawaran_slitting/Inventory_4_model',
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
        $data = $this->Inventory_4_model->CariPenawaran();
        $this->template->set('results', $data);
        $this->template->title('Penawaran Slitting');
        $this->template->render('index');
    }

		public function addHeader()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Inventory_4_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Inventory_4_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Inventory_4_model->get_data('mata_uang','deleted',$deleted);
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
		];
        $this->template->set('results', $data);
        $this->template->title('Add Penawaran Slitting');
        $this->template->render('AddHeader');

    }

	public function PrintHeader1($id){
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);
		$data['header'] = $this->Inventory_4_model->getHeaderPenawaran($id);
		$data['detail']  = $this->Inventory_4_model->PrintDetail($id);
		$this->load->view('PrintHeader',$data);
	}
	public function PrintHeader($id){
		ob_clean();
		ob_start();
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);
		$data['header'] = $this->Inventory_4_model->get_data('tr_penawaran_slitting','id_slitting',$id);
		$data['detail']  = $this->Inventory_4_model->get_data('dt_penawaran_slitting','id_slitting',$id);
		$this->load->view('PrintHeader',$data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(0, 0, 0, 0));
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
		$header = $this->Inventory_4_model->get_data('tr_penawaran_slitting','id_slitting',$id);
		$detail = $this->Inventory_4_model->get_data('dt_penawaran_slitting','id_slitting',$id);
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Inventory_4_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Inventory_4_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Inventory_4_model->get_data('mata_uang','deleted',$deleted);
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'header' => $header,
			'detail' => $detail
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Penawaran Slitting');
        $this->template->render('EditHeader');

    }
	
	    public function detail()
    {
		$id = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
        $detail = $this->Inventory_4_model->getpenawaran($id);
		$header = $this->Inventory_4_model->getHeaderPenawaran($id);
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
		$penawaran = $this->Inventory_4_model->get_data('child_penawaran','id_child_penawaran',$id);
		$inventory_3 = $this->Inventory_4_model->get_data_category();
		$data = [
			'penawaran' => $penawaran,
			'inventory_3' => $inventory_3,
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Penawaran');
        $this->template->render('editPenawaran');

    }



	public function ViewHeader()
    {
		$id = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$header = $this->Inventory_4_model->get_data('tr_penawaran_slitting','id_slitting',$id);
		$detail = $this->Inventory_4_model->get_data('dt_penawaran_slitting','id_slitting',$id);
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Inventory_4_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Inventory_4_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Inventory_4_model->get_data('mata_uang','deleted',$deleted);
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'header' => $header,
			'detail' => $detail
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Penawaran Slitting');
        $this->template->render('ViewHeader');

    }

			public function viewPenawaran($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$penawaran = $this->Inventory_4_model->get_data('child_penawaran','id_child_penawaran',$id);
		$inventory_3 = $this->Inventory_4_model->get_data_category();
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


	public function addPenawaran($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$headpenawaran = $this->Inventory_4_model->get_data('tr_penawaran','no_penawaran',$id);
		$inventory_3 = $this->Inventory_4_model->get_data_category();
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
		$material = $this->Inventory_4_model->CariMaterial($id_crcl);
		echo "<select id='id_produk' name='id_produk' class='form-control select' required>
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
function HitungPanjang()
    {
        $berat=$_GET['berat'];
		if(empty($berat)){
			$berat1 = '1';
		}else{
			$berat1 = $berat;
		}
		$density=$_GET['density'];
		if(empty($density)){
			$density1 = '1';
		}else{
			$density1 = $density;
		}
		$thickness=$_GET['thickness'];
		if(empty($thickness)){
			$thickness1 = '1';
		}else{
			$thickness1 = $thickness;
		}
		$lebar=$_GET['lebar'];
		if(empty($lebar)){
			$lebar1 = '1';
		}else{
			$lebar1 = $lebar;
		}
		$id=$_GET['id'];
		$rumus1 = $density1*$thickness1*$lebar1;
		$rumus_final= number_format($berat1/$rumus1*1000,2);
		echo "<input type='number' value='$rumus_final' class='form-control input-sm' readonly name='dt[$id][panjang]'  id='dt_panjang_$id' label='FALSE' div='FALSE'>";
	}
function HitungPegangan()
    {
		$id=$_GET['id'];       
	   $thickness=$_GET['thickness'];
		if($thickness>0.2){
			$rumus = '1';
		}else{
			$rumus = '2';
		}
		echo "<input type='text' class='form-control' value='$rumus' readonly id='dt_pegangan_$id' required name='dt[$id][pegangan]'>";
	}
function Hitungsisasatuan()
    {
		$id=$_GET['id'];       
	   $pegangan=$_GET['pegangan'];
	   $lebarnew=$_GET['lebarnew'];
	    $lebar=$_GET['lebar'];
		 $qty=$_GET['qty'];
		$rumus1=$lebarnew*$qty;
		$rumus2=$rumus1+$pegangan;
		$rumusfinal=$lebar-$rumus2;
		
		echo "<input type='text' class='form-control' value='$rumusfinal' readonly id='dt_sisa_$id' required name='dt[$id][sisa]'>";
	}
function HitungPisauSatuan()
    {
		$id=$_GET['id'];       
		 $qty=$_GET['qty'];
		$rumus1=2*$qty;
		$rumusfinal=$rumus1+2;
		
		echo "<input type='text' class='form-control' value='$rumusfinal' readonly id='dt_jmlpisau_$id' required name='dt[$id][jmlpisau]'>";
	}
function HitungWaktuSatuan()
    {
		$id=$_GET['id'];       
		 $panjang=$_GET['panjang'];
		 $jmlpisau=$_GET['jmlpisau'];
		$persen=60/100;
		$rumus1=$panjang*31.5;
		$rumus2=$jmlpisau*3;
		$rumus3=$rumus1+$rumus2+21;
		$rumus4=$rumus3*$persen;
		$rumusfinal=$rumus3+$rumus4;
		echo "<input type='text' class='form-control' value='$rumusfinal' readonly id='dt_waktu_$id' required name='dt[$id][waktu]'>";
	}
function HitungHargaSatuan()
    {
		$id=$_GET['id'];       
		 $panjang=$_GET['panjang'];
		 $jmlpisau=$_GET['jmlpisau'];
		$persen=60/100;
		$rumus1=$panjang*31.5;
		$rumus2=$jmlpisau*3;
		$rumus3=$rumus1+$rumus2+21;
		$rumus4=$rumus3*$persen;
		$rumus5=$rumus3+$rumus4;
		$biayapermenit=3890;
		$rumusfinal=number_format($rumus5*$biayapermenit);
		echo "<input type='text' class='form-control' value='$rumusfinal' readonly id='dt_harga_$id' required name='dt[$id][harga]'>";
	}
function HitungTotalPanjangSatuan()
    {
		$id=$_GET['id'];       
		 $panjang=$_GET['panjang'];
		 $jmlpisau=$_GET['jmlpisau'];
		 $profit=$_GET['profit']/100;
		$persen=60/100;
		$rumus1=$panjang*31.5;
		$rumus2=$jmlpisau*3;
		$rumus3=$rumus1+$rumus2+21;
		$rumus4=$rumus3*$persen;
		$rumus5=$rumus3+$rumus4;
		$biayapermenit=3890;
		$rumus6=$rumus5*$biayapermenit;
		$rumus7=$rumus6*$profit;
		$rumus8=$rumus6+$rumus7;
		$rumusfinal=number_format($rumus6+$rumus7);
		echo "<input type='text' value='$rumusfinal' class='form-control' value='$rumusfinal'  id='dt_totalpenawaran_$id' 	required name='dt[$id][totalpenawaran]' readonly>";
	}
function HitungTotalPanjang()
    {
        $berat=$_GET['berat'];
		if(empty($berat)){
			$berat1 = '1';
		}else{
			$berat1 = $berat;
		}
		$density=$_GET['density'];
		if(empty($density)){
			$density1 = '1';
		}else{
			$density1 = $density;
		}
		$thickness=$_GET['thickness'];
		if(empty($thickness)){
			$thickness1 = '1';
		}else{
			$thickness1 = $thickness;
		}
		$lebar=$_GET['lebar']; 
		if(empty($lebar)){
			$lebar1 = '1';
		}else{
			$lebar1 = $lebar;
		}
		$total_panjang=$_GET['total_panjang'];
		$id=$_GET['id'];
		$rumus1 = $density1*$thickness1*$lebar1;
		$rumus2= $berat1/$rumus1;
		$rumus_final=$total_panjang+$rumus2;
		echo "<input type='number' value='$rumus_final' class='form-control' id='total_panjang' readonly required name='total_panjang' >";
	}
function HitungQty()
    {
		$lebar=$_GET['lebar'];
		if(empty($lebar)){
			$lebar1 = '1';
		}else{
			$lebar1 = $lebar;
		}
		$lebarnew=$_GET['lebarnew'];
		if(empty($lebarnew)){
			$lebarnew1 = '1';
		}else{
			$lebarnew1 = $lebarnew;
		}
		$id=$_GET['id'];
		$rumus_final= floor($lebar1/$lebarnew1);
		echo "<input type='number' value='$rumus_final' class='form-control input-sm' readonly name='dt[$id][qty]'  id='dt_qty_$id' label='FALSE' div='FALSE'>";
	}
function HitungSisa()
    {
		$lebar=$_GET['lebar'];
		if(empty($lebar)){
			$lebar1 = '1';
		}else{
			$lebar1 = $lebar;
		}
		$lebarnew=$_GET['lebarnew'];
		if(empty(lebarnew)){
			$lebarnew1 = '1';
		}else{
			$lebarnew1 = $lebarnew;
		}
		$qty=$_GET['qty'];
		if(empty(qty)){
			$qty1 = '1';
		}else{
			$qty1 = $qty;
		}
		$pegangan=$_GET['pegangan'];
		if(empty($pegangan)){
			$pegangan1 = '1';
		}else{
			$pegangan1 = $pegangan;
		}
		$id=$_GET['id'];
		$rumus1 = $lebarnew1*$qty1;
		$rumus2 = $rumus1+$pegangan1;
		$rumus_final= $lebar1-$rumus2;
		echo "<input type='number' value='$rumus_final' class='form-control input-sm' readonly name='dt[$id][sisa]'  id='dt_sisa_$id' label='FALSE' div='FALSE'>";
	}
function HitungPisauNew()
    {
		$lebar=$_GET['lebar'];
		if(empty($lebar)){
			$lebar1 = '1';
		}else{
			$lebar1 = $lebar;
		}
		$lebarnew=$_GET['lebarnew'];
		if(empty($lebarnew)){
			$lebarnew1 = '1';
		}else{
			$lebarnew1 = $lebarnew;
		}
		$id=$_GET['id'];
		$rumus1= $lebar1/$lebarnew1;
		$rumus_final= $rumus1*2+2;
		echo "<input type='number' value='$rumus_final' class='form-control input-sm' readonly name='dt[$id][jmlpisau]'  id='dt_jmlpisau_$id' label='FALSE' div='FALSE'>";
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
function HitungWProses()
    {
        $hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish =$hasil*$fspeed;
		echo "<input type='number' class='form-control' value='$finish' id='wproses' readonly required name='wproses' >";
	}
function CariPic()
    {
        $id_customer=$_GET['id_customer'];
		$pic = $this->Inventory_4_model->get_data('child_customer_pic','id_customer',$id_customer);
		echo "<select id='pic_cutomer' name='pic_cutomer' class='form-control' required>
						<option value=''>--Pilih--</option>";
			foreach ($pic as $pic){
				echo "<option value='$pic->name_pic'>$pic->name_pic</option>";
			}
		echo "</select>";
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
function HitungSTPisau()
    {
        $jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu = '3';
		$hasil = $jml_pisau+$jumlahpisau;
		$finish=$hasil*$waktu;
		echo "<input type='number' class='form-control' value='$finish' id='spisau' readonly required name='spisau' >";
	}
function HitungJMother()
    {
        $jml_mother=$_GET['jml_mother'];
		$hasil = $jml_mother+1;
		echo "<input type='number' class='form-control' value='$hasil' id='jml_mother' readonly required name='jml_mother' >";
	}

function HitungTWProses()
    {
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$last= $finish1+$finish2+finish3;
		echo "<input type='number' class='form-control' value='$last' id='twproses' readonly required name='twproses' >";
	}
	function HitungHandling()
    {
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$persen = 60/100;
		$last= $finish1+$finish2+finish3;
		$handling = $last*$persen;
		echo "<input type='number' class='form-control' value='$handling' id='handling' readonly required name='handling' >";
	}
	function HitungTWaktu()
    {
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$persen = 60/100;
		$last= $finish1+$finish2+finish3;
		$handling = $last*$persen;
		$done = $handling+$last;
		echo "<input type='number' class='form-control' value='$done' id='twaktu' readonly required name='twaktu' >";
	}
		function HitungBProses()
    {
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$persen = 60/100;
		$last= $finish1+$finish2+finish3;
		$handling = $last*$persen;
		$done = $handling+$last;
		$rman = '2601';
		$relectrical='674';
		$rkmain='434';
		$tkinv='181';
		$jrate=$rman+$relectrical+$rkmain+$tkinv;
		$bproses=$jrate*$done ;
		echo "<input type='number' class='form-control' value='$bproses' id='bproses' readonly required name='bproses' >";
	}
			function HitungProfit()
    {
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$persen = 60/100;
		$last= $finish1+$finish2+finish3;
		$handling = $last*$persen;
		$done = $handling+$last;
		$rman = '2601';
		$relectrical='674';
		$rkmain='434';
		$tkinv='181';
		$jrate=$rman+$relectrical+$rkmain+$tkinv;
		$bproses=$jrate*$done ;
		$pestenprofit=15/100;
		$profit=$bproses*$pestenprofit;
		echo "<input type='number' class='form-control' value='$profit' id='profit' readonly required name='profit' >";
	}
	function HitungHtotal()
    {
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$persen = 60/100;
		$last= $finish1+$finish2+finish3;
		$handling = $last*$persen;
		$done = $handling+$last;
		$rman = '2601';
		$relectrical='674';
		$rkmain='434';
		$tkinv='181';
		$jrate=$rman+$relectrical+$rkmain+$tkinv;
		$bproses=$jrate*$done ;
		$pestenprofit=15/100;
		$profit=$bproses*$pestenprofit;
		$htotal=$profit+$bproses;
		echo "<input type='number' class='form-control' value='$htotal' id='ttlhgpenawaran' readonly required name='ttlhgpenawaran' >";
	}
	function HitungHRp()
    {
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$persen = 60/100;
		$last= $finish1+$finish2+finish3;
		$handling = $last*$persen;
		$done = $handling+$last;
		$rman = '2601';
		$relectrical='674';
		$rkmain='434';
		$tkinv='181';
		$jrate=$rman+$relectrical+$rkmain+$tkinv;
		$bproses=$jrate*$done ;
		$pestenprofit=15/100;
		$profit=$bproses*$pestenprofit;
		$htotal=$profit+$bproses;
		$hrp=$htotal/$done;
		echo "<input type='number' class='form-control' value='$hrp' id='hgpkgrp' readonly required name='hgpkgrp' >";
	}
		function HitungHdl()
    {
		$carikurs = $this->db->query("SELECT * FROM mata_uang WHERE kode='IDR' ")->result();
		$nilai_kurs = $carikurs[0]->kurs;
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$persen = 60/100;
		$last= $finish1+$finish2+finish3;
		$handling = $last*$persen;
		$done = $handling+$last;
		$rman = '2601';
		$relectrical='674';
		$rkmain='434';
		$tkinv='181';
		$jrate=$rman+$relectrical+$rkmain+$tkinv;
		$bproses=$jrate*$done ;
		$pestenprofit=15/100;
		$profit=$bproses*$pestenprofit;
		$htotal=$profit+$bproses;
		$hrp=$htotal/$done;
		$hdolat=number_format($hrp/$nilai_kurs,2);
		echo "<input type='number' class='form-control' value='$hdolat' id='hgpkgdl' readonly required name='hgpkgdl' >";
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
		$id_customer=$_GET['id_customer'];
		$loop=$_GET['jumlah']+1;
		$crcl = $this->db->query("SELECT * FROM tr_inquiry WHERE id_customer = '$id_customer' ")->result();
		$no_inquery = $crcl[0]->no_inquiry;
		$dtcrcl = $this->db->query("SELECT a.*, b.nama as namainven, b.hardness as hardness FROM dt_inquery_transaksi as a INNER JOIN ms_inventory_category3 as b ON a.id_category3 = b.id_category3 WHERE no_inquery = '$no_inquery'  ")->result();
		$material = $this->db->query("SELECT a.*, b.nama as alloy, c.nm_bentuk as bentuk FROM ms_inventory_category3 as a INNER JOIN ms_inventory_category2 as b ON a.id_category2 = b.id_category2 INNER JOIN ms_bentuk as c ON a.id_bentuk = c.id_bentuk WHERE a.deleted = '0'  ")->result();
		echo "
		<tr id='tr_$loop'>
		<th hidden><input type='text' class='form-control' id='dt_lotno_$loop' required name='dt[$loop][lotno]'></th>
		<th><select class='form-control' id='dt_idmaterial_$loop' name='dt[$loop][idmaterial]'	onchange ='CariProperties($loop)'>
		<option value=''>--Pilih--</option>";
		foreach ($material as $material){
		if($material->id_bentuk == 'B2000001' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '22' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3'>$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000002' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '25' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3'>$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000003' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '30' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3'>$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000004' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '8' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		$dimensi2 = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '9' ")->result();
		$thickness2 = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3'>$material->bentuk $material->alloy $material->nama $material->hardness $thickness x $thickness</option>";
		}elseif($material->id_bentuk == 'B2000005' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '11' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3'>$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000006' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '13' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3'>$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000007' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '15' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		$dimensi2 = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '16' ")->result();
		$thickness2 = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3'>$material->bentuk $material->alloy $material->nama $material->hardness $thickness $thickness2</option>";
		}elseif($material->id_bentuk == 'B2000009' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '19' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3'>$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		};
		};
		echo"</select></th>
		<th hidden><input type='text' class='form-control' id='dt_nama_material_$loop' 							required name='dt[$loop][nama_material]' 		onkeyup='HitungPanjang($loop)'></th>
		<th><input type='number' class='form-control' id='dt_berat_$loop' 							required name='dt[$loop][berat]' 		onkeyup='HitungPanjang($loop)'></th>
		<th id='slot_density_$loop'><input readonly type='number' class='form-control' id='dt_density_$loop' 				required name='dt[$loop][density]' 		onkeyup='HitungPanjang($loop)'></th>
		<th><input type='number' class='form-control' id='dt_thickness_$loop' 						required name='dt[$loop][thickness]' 	onkeyup='HitungPanjang($loop)'></th>
		<th><input type='text' class='form-control' id='dt_lebar_$loop' 							required name='dt[$loop][lebar]' 		onkeyup='HitungPanjang($loop)'></th>
		<th id='slot_panjang_$loop'><input type='text' class='form-control' id='dt_panjang_$loop' readonly 	required name='dt[$loop][panjang]'></th>
		<th><input type='text' class='form-control' id='dt_lebarnew_$loop' 							required name='dt[$loop][lebarnew]' 	onkeyup='HitungPanjang($loop)'></th>
		<th><input type='text' class='form-control' id='dt_qty_$loop'						required name='dt[$loop][qty]'      	onkeyup='HitungPanjang($loop)'></th>
		<th id='slot_pegangan_$loop' hidden><input type='text' class='form-control' readonly id='dt_pegangan_$loop' required name='dt[$loop][pegangan]'></th>
		<th id='slot_sisa_$loop'><input type='text' class='form-control' id='dt_sisa_$loop' readonly required name='dt[$loop][sisa]'></th>
		<th id='slot_pisau_$loop' hidden><input type='text' class='form-control' id='dt_jmlpisau_$loop' 	required name='dt[$loop][jmlpisau]' readonly></th>
		<th id='slot_waktu_$loop' hidden><input type='text' class='form-control' id='dt_waktu_$loop' 		required name='dt[$loop][waktu]' 	readonly	></th>
		<th id='slot_harga_$loop'><input type='text' class='form-control' id='dt_harga_$loop' 		required name='dt[$loop][harga]' 	readonly	></th>
		<th ><input type='text' class='form-control' id='dt_profit_$loop' 							required name='dt[$loop][profit]' onkeyup='HitungPanjang($loop)'></th>
		<th id='slot_totalpenawaran_$loop'><input type='text' class='form-control' id='dt_totalpenawaran_$loop' 	required name='dt[$loop][totalpenawaran]' readonly></th>
		<th ><input type='text' class='form-control' id='dt_hargadeal_$loop' 							required name='dt[$loop][hargadeal]'></th>
			<th><button type='button' class='btn btn-sm btn-success' title='Ambil' id='tambah_$loop' data-role='qtip' onClick='return TambahItem($loop);'><i class='fa fa-check'></i></button>
			<button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button></th>
		</tr>
		";
	}
function LockDetail()
    {
		$id_customer=$_GET['id_customer'];
		$lotno=$_GET['lotno'];
		$idmaterial=$_GET['idmaterial'];
		$berat=$_GET['berat'];
		$density=$_GET['density'];
		$thicknessform=$_GET['thickness'];
		$nama_material=$_GET['nama_material'];
		$lebar=$_GET['lebar'];
		$panjang=$_GET['panjang'];
		$lebarnew=$_GET['lebarnew'];
		$qty=$_GET['qty'];
		$pegangan=$_GET['pegangan'];
		$sisa=$_GET['sisa'];
		$jmlpisau=$_GET['jmlpisau'];
		$harga=$_GET['harga'];
		$waktu=$_GET['waktu'];
		$profit=$_GET['profit'];
		$totalpenawaran=$_GET['totalpenawaran'];
		$hargadeal=$_GET['hargadeal'];
		$loop=$_GET['id'];
		$crcl = $this->db->query("SELECT * FROM tr_inquiry WHERE id_customer = '$id_customer' ")->result();
		$no_inquery = $crcl[0]->no_inquiry;
		$dtcrcl = $this->db->query("SELECT a.*, b.nama as namainven, b.hardness as hardness FROM dt_inquery_transaksi as a INNER JOIN ms_inventory_category3 as b ON a.id_category3 = b.id_category3 WHERE no_inquery = '$no_inquery'  ")->result();	
		$material = $this->db->query("SELECT a.*, b.nama as alloy, c.nm_bentuk as bentuk FROM ms_inventory_category3 as a INNER JOIN ms_inventory_category2 as b ON a.id_category2 = b.id_category2 INNER JOIN ms_bentuk as c ON a.id_bentuk = c.id_bentuk WHERE a.deleted = '0' AND a.id_category3 = '$idmaterial' ")->result();echo "
		<th hidden><input type='text' 	 class='form-control' value='$lotno' id='dt_lotno_$loop' required name='dt[$loop][lotno]'></th>
		<th hidden><select readonly class='form-control' id='dt_idmaterial_$loop' name='dt[$loop][idmaterial]'	onchange ='CariProperties($loop)'>
		<option value=''>--Pilih--</option>";
		foreach ($material as $material){
		$select = $material->id_category3 == $id_material? 'selected' : '';
		if($material->id_bentuk == 'B2000001' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '22'")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000002' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '25' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000003' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '30' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000004' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '8' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		$dimensi2 = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '9' ")->result();
		$thickness2 = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness x $thickness</option>";
		}elseif($material->id_bentuk == 'B2000005' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '11' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000006' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '13' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		}elseif($material->id_bentuk == 'B2000007' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '15' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		$dimensi2 = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '16' ")->result();
		$thickness2 = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness $thickness2</option>";
		}elseif($material->id_bentuk == 'B2000009' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '19' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<option value='$material->id_category3' $select >$material->bentuk $material->alloy $material->nama $material->hardness $thickness</option>";
		};
		};
		echo"</select></th>";
		if($material->id_bentuk == 'B2000001' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '22'")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<th><input readonly type='text' class='form-control' id='dt_nama_material_$loop' required name='dt[$loop][nama_material]' value='$material->bentuk $material->alloy $material->nama $material->hardness $thickness' ></th>";
		}elseif($material->id_bentuk == 'B2000002' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '25' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<th><input readonly type='text' class='form-control' id='dt_nama_material_$loop' required name='dt[$loop][nama_material]' value='$material->bentuk $material->alloy $material->nama $material->hardness $thickness' ></th>";
		}elseif($material->id_bentuk == 'B2000003' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '30' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<th><input readonly type='text' class='form-control' id='dt_nama_material_$loop' required name='dt[$loop][nama_material]' value='$material->bentuk $material->alloy $material->nama $material->hardness $thickness' ></th>";
		}elseif($material->id_bentuk == 'B2000004' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '8' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		$dimensi2 = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '9' ")->result();
		$thickness2 = $dimensi[0]->nilai_dimensi;
		echo"<th><input readonly type='text' class='form-control' id='dt_nama_material_$loop' required name='dt[$loop][nama_material]' value='$material->bentuk $material->alloy $material->nama $material->hardness $thickness x $thickness2' ></th>";
		}elseif($material->id_bentuk == 'B2000005' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '11' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<th><input readonly type='text' class='form-control' id='dt_nama_material_$loop' required name='dt[$loop][nama_material]' value='$material->bentuk $material->alloy $material->nama $material->hardness $thickness' ></th>";
		}elseif($material->id_bentuk == 'B2000006' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '13' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<th><input readonly type='text' class='form-control' id='dt_nama_material_$loop' required name='dt[$loop][nama_material]' value='$material->bentuk $material->alloy $material->nama $material->hardness $thickness' ></th>";
		}elseif($material->id_bentuk == 'B2000007' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '15' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		$dimensi2 = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '16' ")->result();
		$thickness2 = $dimensi[0]->nilai_dimensi;
		echo"<th><input readonly type='text' class='form-control' id='dt_nama_material_$loop' required name='dt[$loop][nama_material]' value='$material->bentuk $material->alloy $material->nama $material->hardness $thickness x $thickness2' ></th>";
		}elseif($material->id_bentuk == 'B2000009' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '19' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		echo"<th><input readonly type='text' class='form-control' id='dt_nama_material_$loop' required name='dt[$loop][nama_material]' value='$material->bentuk $material->alloy $material->nama $material->hardness $thickness ' ></th>";
		};
		echo"
		<th><input type='number' class='form-control' value='$berat'  id='dt_berat_$loop' 							required name='dt[$loop][berat]' 		onkeyup='HitungPanjang($loop)'></th>
		<th><input type='number' readonly class='form-control' value='$density' id='dt_density_$loop' 						required name='dt[$loop][density]' 		onkeyup='HitungPanjang($loop)'></th>
		<th><input type='number' class='form-control' value='$thicknessform' id='dt_thickness_$loop' 						required name='dt[$loop][thickness]' 	onkeyup='HitungPanjang($loop)'></th>
		<th><input type='text' 	 class='form-control' value='$lebar' id='dt_lebar_$loop' 							required name='dt[$loop][lebar]' 		onkeyup='HitungPanjang($loop)'></th>
		<th><input type='text'	 class='form-control' value='$panjang' id='dt_panjang_$loop' readonly 	required name='dt[$loop][panjang]'></th>
		<th><input type='text'	 class='form-control' value='$lebarnew' id='dt_lebarnew_$loop' 							required name='dt[$loop][lebarnew]' 	onkeyup='HitungPanjang($loop)'></th>
		<th><input type='text'	 class='form-control' value='$qty' id='dt_qty_$loop'						required name='dt[$loop][qty]'      	onkeyup='HitungPanjang($loop)'></th>
		<th hidden><input type='text'	 class='form-control' value='$pegangan' id='dt_pegangan_$loop' required name='dt[$loop][pegangan]'></th>
		<th><input type='text'	 class='form-control' value='$sisa' id='dt_sisa_$loop' readonly required name='dt[$loop][sisa]'></th>
		<th hidden><input type='text'	 class='form-control' value='$jmlpisau' id='dt_jmlpisau_$loop' 	required name='dt[$loop][jmlpisau]' readonly></th>
		<th hidden><input type='text' class='form-control' value='$waktu' id='dt_waktu_$loop' 		required name='dt[$loop][waktu]' 	readonly	></th>
		<th><input type='text'	 class='form-control' value='$harga' id='dt_harga_$loop' 		required name='dt[$loop][harga]' 	readonly	></th>
		<th><input type='text'	 class='form-control' value='$profit' id='dt_profit_$loop' 							required name='dt[$loop][profit]' onkeyup='HitungPanjang($loop)'></th>
		<th><input type='text'	 class='form-control' value='$totalpenawaran' id='dt_totalpenawaran_$loop' 	required name='dt[$loop][totalpenawaran]' readonly></th>
		<th><input type='text'	 class='form-control' value='$hargadeal' id='dt_hargadeal_$loop' 							required name='dt[$loop][hargadeal]'></th>
		<th><button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return DeleteItem($loop);'><i class='fa fa-close'></i></button></th>
		";
	}
function CariTPanjang()
    {
		$id_customer=$_GET['id_customer'];
		$lotno=$_GET['lotno'];
		$idmaterial=$_GET['idmaterial'];
		$berat=$_GET['berat'];
		$density=$_GET['density'];
		$thickness=$_GET['thickness'];
		$lebar=$_GET['lebar'];
		$panjang=$_GET['panjang'];
		$lebarnew=$_GET['lebarnew'];
		$qty=$_GET['qty'];
		$pegangan=$_GET['pegangan'];
		$sisa=$_GET['sisa'];
		$jmlpisau=$_GET['jmlpisau'];
		$harga=$_GET['harga'];
		$total_panjang=$_GET['total_panjang'];
		$jml_pisau=$_GET['jml_pisau'];
		$jml_mother=$_GET['jml_mother'];
		$total_berat=$_GET['total_berat'];
		$loop=$_GET['id'];
		$rumus1=$panjang*$qty;
		$rumusvix = $rumus1+$total_panjang;
		echo "<input type='number' value='$rumusvix' class='form-control' id='total_panjang' readonly required name='total_panjang' >";
	}
function MinPanjang()
    {

		$panjang=$_GET['panjang'];
		$qty=$_GET['qty'];
		$total_panjang=$_GET['total_panjang'];
		$rumus1=$panjang*$qty;
		$rumusvix = $total_panjang-$rumus1;
		echo "<input type='number' value='$rumusvix' class='form-control' id='total_panjang' readonly required name='total_panjang' >";
	}
function CariMCoils()
    {
		$id_customer=$_GET['id_customer'];
		$lotno=$_GET['lotno'];
		$idmaterial=$_GET['idmaterial'];
		$berat=$_GET['berat'];
		$density=$_GET['density'];
		$thickness=$_GET['thickness'];
		$lebar=$_GET['lebar'];
		$panjang=$_GET['panjang'];
		$lebarnew=$_GET['lebarnew'];
		$qty=$_GET['qty'];
		$pegangan=$_GET['pegangan'];
		$sisa=$_GET['sisa'];
		$jmlpisau=$_GET['jmlpisau'];
		$harga=$_GET['harga'];
		$total_panjang=$_GET['total_panjang'];
		$jml_pisau=$_GET['jml_pisau'];
		$jml_mother=$_GET['jml_mother'];
		$total_berat=$_GET['total_berat'];
		$loop=$_GET['id'];
		$rumusvix = $qty+$jml_mother;
		echo "<input type='number' value='$rumusvix' class='form-control' id='jml_mother' readonly required name='jml_mother' >";
	}
function MinMother()
    {
		$qty=$_GET['qty'];
		$jml_mother=$_GET['jml_mother'];
		$rumusvix = $jml_mother-$qty;
		echo "<input type='number' value='$rumusvix' class='form-control' id='jml_mother' readonly required name='jml_mother' >";
	}
function SumHarga()
    {
		$hargadeal=$_GET['hargadeal'];
		$total_harga_penawaran=$_GET['total_harga_penawaran'];
		$rumusvix = $hargadeal+$total_harga_penawaran;
		echo "<input type='number' class='form-control' value='$rumusvix' id='total_harga_penawaran' readonly required name='total_harga_penawaran' >";
	}
function CariDensity()
    {
		$id_material=$_GET['id_material'];
		$loop=$_GET['id'];
		$material = $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_material' ")->result();
		$density = $material[0]->density;
		echo "<input type='number' readonly class='form-control' value='$density' id='dt_density_$loop' 	required name='dt[$loop][density]' 		onkeyup='HitungPanjang($loop)'>";
	}
function MinHarga()
    {
		$hargadeal=$_GET['hargadeal'];
		$total_harga_penawaran=$_GET['total_harga_penawaran'];
		$rumusvix = $total_harga_penawaran-$hargadeal;
		echo "<input type='number' class='form-control' value='$rumusvix' id='total_harga_penawaran' readonly required name='total_harga_penawaran' >";
	}
function CariJPisau()
    {
		$id_customer=$_GET['id_customer'];
		$lotno=$_GET['lotno'];
		$idmaterial=$_GET['idmaterial'];
		$berat=$_GET['berat'];
		$density=$_GET['density'];
		$thickness=$_GET['thickness'];
		$lebar=$_GET['lebar'];
		$panjang=$_GET['panjang'];
		$lebarnew=$_GET['lebarnew'];
		$qty=$_GET['qty'];
		$pegangan=$_GET['pegangan'];
		$sisa=$_GET['sisa'];
		$jmlpisau=$_GET['jmlpisau'];
		$harga=$_GET['harga'];
		$total_panjang=$_GET['total_panjang'];
		$jml_pisau=$_GET['jml_pisau'];
		$jml_mother=$_GET['jml_mother'];
		$total_berat=$_GET['total_berat'];
		$loop=$_GET['id'];
		$rumusvix = $jml_pisau+$jmlpisau;
		echo "<input type='number' value='$rumusvix' class='form-control' id='jml_pisau' readonly required name='jml_pisau' >";
	}
function MinPisau()
    {
		$jmlpisaudt=$_GET['jmlpisaudt'];
		$jml_pisau=$_GET['jml_pisau'];
		$rumusvix = $jml_pisau-$jmlpisaudt;
		echo "<input type='number' value='$rumusvix' class='form-control' id='jml_pisau' readonly required name='jml_pisau' >";
	}
function CariTBProduk()
    {
		$id_customer=$_GET['id_customer'];
		$lotno=$_GET['lotno'];
		$idmaterial=$_GET['idmaterial'];
		$berat=$_GET['berat'];
		$density=$_GET['density'];
		$thickness=$_GET['thickness'];
		$lebar=$_GET['lebar'];
		$panjang=$_GET['panjang'];
		$lebarnew=$_GET['lebarnew'];
		$qty=$_GET['qty'];
		$pegangan=$_GET['pegangan'];
		$sisa=$_GET['sisa'];
		$jmlpisau=$_GET['jmlpisau'];
		$harga=$_GET['harga'];
		$total_panjang=$_GET['total_panjang'];
		$jml_pisau=$_GET['jml_pisau'];
		$jml_mother=$_GET['jml_mother'];
		$total_berat=$_GET['total_berat'];
		$loop=$_GET['id'];
		$rumus1= $berat*$qty;
		$rumusvix = $rumus1+$total_berat;
		echo "<input type='number' value='$rumusvix' class='form-control' id='total_berat' readonly required name='total_berat' >";
	}
function MinBerat()
    {

		$berat=$_GET['berat'];
		$qty=$_GET['qty'];
		$total_berat=$_GET['total_berat'];
		$loop=$_GET['id'];
		$rumus1= $berat*$qty;
		$rumusvix = $total_berat-$rumus1;
		echo "<input type='number' value='$rumusvix' class='form-control' id='total_berat' readonly required name='total_berat' >";
	}
	function HitungWaktu()
    {
		$id_customer=$_GET['id_customer'];
		$lotno=$_GET['lotno'];
		$idmaterial=$_GET['idmaterial'];
		$berat=$_GET['berat'];
		$density=$_GET['density'];
		$thickness=$_GET['thickness'];
		$lebar=$_GET['lebar'];
		$panjang=$_GET['panjang'];
		$lebarnew=$_GET['lebarnew'];
		$qty=$_GET['qty'];
		$pegangan=$_GET['pegangan'];
		$sisa=$_GET['sisa'];
		$jmlpisau=$_GET['jmlpisau'];
		$harga=$_GET['harga'];
		$total_panjang=$_GET['total_panjang'];
		$jml_pisau=$_GET['jml_pisau'];
		$jml_mother=$_GET['jml_mother'];
		$total_berat=$_GET['total_berat'];
		$loop=$_GET['id'];
		$faktorspeed = '31,5';
		$waktugantipisau = '3';
		$waktuganticoil = '21';
		$persentasehandling = 60/100;
		$totalpisau = $jml_pisau+$jmlpisau;
		$jumlahcoil = $jml_mother+$qty;
		$tpanjang= $total_panjang*$panjang;
		
		$waktuproses= $faktorspeed*$tpanjang;
		$waktugantipisau= $totalpisau*$waktugantipisau;
		$waktuganticoil= $jumlahcoil*$waktuganticoil;
		$totalwaktuproses = $waktuproses+$waktugantipisau+$waktuganticoil;
		$handling = $totalwaktuproses*$persentasehandling;
		$totalseluruhwaktu = $totalwaktuproses+$handling;
		echo "<div class='col-md-6'>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-12'>
				<label for='email_customer'>Waktu Proses</label>
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Waktu Proses</label>
			</div>
			<div class='col-md-8'>
					<input type='number' value='$waktuproses' class='form-control' id='wproses' readonly required name='wproses' >
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Setting Pisau</label>
			</div>
			<div class='col-md-8'>
					<input type='number' value='$waktugantipisau' class='form-control' id='spisau' readonly required name='spisau' >
			</div>
		</div>
		</div>
				<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Ganti Coil dan Pengecekan</label>
			</div>
			<div class='col-md-8'>
					<input type='number' value='$waktuganticoil' class='form-control' id='gcoil' readonly required name='gcoil' >
			</div>
		</div>
		</div>
						<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Total Waktu Proses</label>
			</div>
			<div class='col-md-8'>
					<input type='number' value='$totalwaktuproses' class='form-control' id='twproses' readonly required name='twproses' >
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Handling</label>
			</div>
			<div class='col-md-8'>
					<input type='number' value='$handling' class='form-control' id='handling' readonly required name='handling' >
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Total Waktu</label>
			</div>
			<div class='col-md-8'>
					<input type='number' value='$totalseluruhwaktu' class='form-control' id='twaktu' readonly required name='twaktu' >
			</div>
		</div>
		</div>
		</div>";
	}
	function HitungBiaya()
    {
		$id_customer=$_GET['id_customer'];
		$lotno=$_GET['lotno'];
		$idmaterial=$_GET['idmaterial'];
		$berat=$_GET['berat'];
		$density=$_GET['density'];
		$thickness=$_GET['thickness'];
		$lebar=$_GET['lebar'];
		$panjang=$_GET['panjang'];
		$lebarnew=$_GET['lebarnew'];
		$qty=$_GET['qty'];
		$pegangan=$_GET['pegangan'];
		$sisa=$_GET['sisa'];
		$jmlpisau=$_GET['jmlpisau'];
		$harga=$_GET['harga'];
		$total_panjang=$_GET['total_panjang'];
		$jml_pisau=$_GET['jml_pisau'];
		$jml_mother=$_GET['jml_mother'];
		$total_berat=$_GET['total_berat'];
		$loop=$_GET['id'];
		$faktorspeed = '31,5';
		$waktugantipisau = '3';
		$waktuganticoil = '21';
		$rmanpower='2601';
		$relectrick='674';
		$rmaintnance='434';
		$rinvestasi='181';
		$trate = $rmanpower+$relectrick+$rmaintnance+$rinvestasi;
		$persentasehandling = 60/100;
		$persentaseprofit = 60/100;
		$totalpisau = $jml_pisau+$jmlpisau;
		$jumlahcoil = $jml_mother+$qty;
		$tpanjang= $total_panjang*$panjang;
		$waktuproses= $faktorspeed*$tpanjang;
		$waktugantipisau= $totalpisau*$waktugantipisau;
		$waktuganticoil= $jumlahcoil*$waktuganticoil;
		$totalwaktuproses = $waktuproses+$waktugantipisau+$waktuganticoil;
		$handling = $totalwaktuproses*$persentasehandling;
		$totalseluruhwaktu = $totalwaktuproses+$handling;
		$biayaproses=$trate*$totalseluruhwaktu;
		$biayaprofit = $biayaproses*$persentaseprofit;
		$totalbiaypenawaran = $biayaproses+$biayaprofit;
		$rumus1= $berat*$qty;
		$rumusvix = $rumus1+$total_berat;
		$biyaperkilo = $totalbiaypenawaran/$rumusvix;
		echo "<div class='col-md-6'>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-12'>
				<label for='email_customer'>Harga Proses</label>
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Biaya Proses</label>
			</div>
			<div class='col-md-8'>
					<input type='number' value='$biayaproses' class='form-control' id='bproses' readonly required name='bproses' >
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Profit</label>
			</div>
			<div class='col-md-8'>
					<input type='number' value='$biayaprofit' class='form-control' id='profit' readonly required name='profit' >
			</div>
		</div>
		</div>
				<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Total Harga Penawaran</label>
			</div>
			<div class='col-md-8'>
					<input type='number' value='$totalbiaypenawaran' class='form-control' id='ttlhgpenawaran' readonly required name='ttlhgpenawaran' >
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Harga Per Kilo(Rp)</label>
			</div>
			<div class='col-md-8'>
					<input type='number' value='$biayaperkilo' class='form-control' id='hgpkgrp' readonly required name='hgpkgrp' >
			</div>
		</div>
		</div>
		<div class='col-sm-12'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Harga Per Kilo($)</label>
			</div>
			<div class='col-md-8'>
					<input type='number' class='form-control' id='hgpkgdl' readonly required name='hgpkgdl' >
			</div>
		</div>
		</div>
		</div>";
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


	public function SaveNewHeader()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $this->Inventory_4_model->generate_code();
		$no_surat = $this->Inventory_4_model->BuatNomor();
		$this->db->trans_begin();
		$data = [
							'id_slitting'			=> $code,
							'no_surat'				=> $no_surat,
							'tgl_penawaran'			=> date('Y-m-d'),
							'id_customer'			=> $post['id_customer'],
							'mata_uang'				=> $post['mata_uang'],
							'total_panjang'			=> $post['total_panjang'],
							'pic_customer'			=> $post['pic_cutomer'],
							'valid_until'			=> $post['valid_until'],
							'jml_pisau'				=> $post['jml_pisau'],
							'jml_mother'			=> $post['jml_mother'],
							'total_berat'			=> $post['total_berat'],
							'wproses'				=> $post['wproses'],
							'spisau'				=> $post['spisau'],
							'gcoil'					=> $post['gcoil'],
							'twproses'				=> $post['twproses'],
							'total_harga_penawaran'				=> $post['total_harga_penawaran'],
							'handling'				=> $post['handling'],
							'twaktu'				=> $post['twaktu'],
							'bproses'				=> $post['bproses'],
							'ttlhgpenawaran'		=> $post['ttlhgpenawaran'],
							'hgpkgrp'				=> $post['hgpkgrp'],
							'hgpkgdl'				=> $post['hgpkgdl'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
               $this->db->insert('tr_penawaran_slitting',$data);
		$numb1 =0;
		foreach($_POST['dt'] as $use){
		$numb1++;        
                $stokpakai =  array(
							'id_slitting'		    	=> $code,
							'id_dt_slitting'			=> $code.'-'.$numb1,
							'lotno'		        		=> $use[lotno],
							'idmaterial'		        => $use[idmaterial],
							'nama_material'		        => $use[nama_material],
							'berat'		        		=> $use[berat],
							'density'		        	=> $use[density],
							'thickness'		        	=> $use[thickness],
							'lebar'						=> $use[lebar],
							'panjang'		    		=> $use[panjang],
							'lebarnew'		    		=> $use[lebarnew],
							'qty'		    			=> $use[qty],
							
							'pegangan'		    		=> $use[pegangan],
							'sisa'		    			=> $use[sisa],
							'harga'		    			=> $use[harga],
							'jmlpisau'		    		=> $use[jmlpisau],
							'waktu'		    			=> $use[waktu],
							'nama_material'		    	=> $use[nama_material],
							'profit'		    		=> $use[profit],
							'totalpenawaran'		    => $use[totalpenawaran],
							'hargadeal'		    		=> $use[hargadeal],
                            );
                    $this->db->insert('dt_penawaran_slitting',$stokpakai);
			
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
	public function SaveEditHeader()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $post['id_slitting'];
		$no_surat = $post['no_surat'];
		$this->db->trans_begin();
		$data = [
							'id_slitting'			=> $code,
							'no_surat'				=> $no_surat,
							'tgl_penawaran'			=> date('Y-m-d'),
							'id_customer'			=> $post['id_customer'],
							'mata_uang'				=> $post['mata_uang'],
							'total_panjang'			=> $post['total_panjang'],
							'pic_customer'				=> $post['pic_cutomer'],
							'valid_until'			=> $post['valid_until'],
							'jml_pisau'				=> $post['jml_pisau'],
							'jml_mother'			=> $post['jml_mother'],
							'total_berat'			=> $post['total_berat'],
							'wproses'				=> $post['wproses'],
							'spisau'				=> $post['spisau'],
							'gcoil'					=> $post['gcoil'],
							'twproses'				=> $post['twproses'],
							'total_harga_penawaran'				=> $post['total_harga_penawaran'],
							'handling'				=> $post['handling'],
							'twaktu'				=> $post['twaktu'],
							'bproses'				=> $post['bproses'],
							'ttlhgpenawaran'		=> $post['ttlhgpenawaran'],
							'hgpkgrp'				=> $post['hgpkgrp'],
							'hgpkgdl'				=> $post['hgpkgdl'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
			   	$this->db->where('id_slitting',$code)->update("tr_penawaran_slitting",$data);
			$this->db->delete('dt_penawaran_slitting', array('id_slitting' => $code));
		$numb1 =0;
		foreach($_POST['dt'] as $use){
		$numb1++;        
                $stokpakai =  array(
							'id_slitting'		    	=> $code,
							'id_dt_slitting'			=> $code.'-'.$numb1,
							'lotno'		        		=> $use[lotno],
							'idmaterial'		        => $use[idmaterial],
							'nama_material'		        => $use[nama_material],
							'berat'		        		=> $use[berat],
							'density'		        	=> $use[density],
							'thickness'		        	=> $use[thickness],
							'lebar'						=> $use[lebar],
							'panjang'		    		=> $use[panjang],
							'lebarnew'		    		=> $use[lebarnew],
							'qty'		    			=> $use[qty],
							
							'pegangan'		    		=> $use[pegangan],
							'sisa'		    			=> $use[sisa],
							'harga'		    			=> $use[harga],
							'jmlpisau'		    		=> $use[jmlpisau],
							'waktu'		    			=> $use[waktu],
							'nama_material'		    	=> $use[nama_material],
							'profit'		    		=> $use[profit],
							'totalpenawaran'		    => $use[totalpenawaran],
							'hargadeal'		    		=> $use[hargadeal],
                            );
                    $this->db->insert('dt_penawaran_slitting',$stokpakai);
			
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
		$code = $this->Inventory_4_model->generate_code();
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
