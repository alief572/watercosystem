<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Syamsudin
 * @copyright Copyright (c) 2022, Syamsudin
 *
 * This is controller for Master Supplier
 */

class Debit_note extends Admin_Controller 
{
    //Permission
    protected $viewPermission 	= 'Debit_Note.View';
    protected $addPermission  	= 'Debit_Note.Add';
    protected $managePermission = 'Debit_Note.Manage';
    protected $deletePermission = 'Debit_Note.Delete';

    public function __construct()
    {
        parent::__construct(); 
        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Debit_note/Debit_note_model',
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
        $data = $this->db->query("SELECT * FROM tr_debit_note ORDER BY created_on DESC ")->result();
        $this->template->set('results', $data);
        $this->template->title('Debit Note');
        $this->template->render('index');
    }
	public function add()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Debit_note_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Debit_note_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Debit_note_model->get_data('mata_uang','deleted'.$deleted);
		$matauang = $this->db->get_where('matauang')->result();
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'matauang' => $matauang,
		];
        $this->template->set('results', $data);
        $this->template->title('Debit Note');
        $this->template->render('Add');

    }
			public function edit()
    {
		$id = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$head = $this->db->query("SELECT * FROM tr_debit_note  WHERE no_pr = '$id' ")->result();
		$detail = $this->db->query("SELECT * FROM dt_debit_note  WHERE no_pr = '$id' ")->result();
		$customers = $this->Debit_note_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Debit_note_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Debit_note_model->get_data('mata_uang','deleted'.$deleted);
		$matauang = $this->db->get_where('matauang')->result();
		$data = [
			'head' => $head,
			'detail' => $detail,
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'matauang' => $matauang,
		];
        $this->template->set('results', $data);
        $this->template->title('Debit Note');
        $this->template->render('Edit');

    }
	public function add_pr()
    {
		$this->auth->restrict($this->viewPermission); 
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Debit_note_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Debit_note_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Debit_note_model->get_data('mata_uang','deleted'.$deleted);
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
		];
        $this->template->set('results', $data);
        $this->template->title('Debit Note');
        $this->template->render('Addpr');

    }
	public function PrintHeader1($id){
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);
		$data['header'] = $this->Debit_note_model->getHeaderPenawaran($id);
		$data['detail']  = $this->Debit_note_model->PrintDetail($id);
		$this->load->view('PrintHeader',$data);
	}
	public function PrintHeader($id){
		ob_clean();
		ob_start();
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);
		$data['header'] = $this->Debit_note_model->getHeaderPenawaran($id);
		$data['detail']  = $this->Debit_note_model->PrintDetail($id);
		$this->load->view('PrintHeader',$data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('Penawaran.pdf', 'I');
	}
		public function EditHeader($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$head = $this->Debit_note_model->get_data('tr_penawaran','no_penawaran',$id);
		$customers = $this->Debit_note_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Debit_note_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Debit_note_model->get_data('mata_uang','deleted',$deleted);
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
			'head' => $head,
			'mata_uang' => $mata_uang,
		];
        $this->template->set('results', $data);
        $this->template->title('Add Penawaran');
        $this->template->render('EditHeader');

    }
	    public function detail()
    {
		$id = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
        $detail = $this->Debit_note_model->getpenawaran($id);
		$header = $this->Debit_note_model->getHeaderPenawaran($id);
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
		$penawaran = $this->Debit_note_model->get_data('child_penawaran','id_child_penawaran',$id);
		$inventory_3 = $this->Debit_note_model->get_data_category();
		$data = [
			'penawaran' => $penawaran,
			'inventory_3' => $inventory_3,
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Penawaran');
        $this->template->render('editPenawaran');

    }



			public function View($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$header = $this->db->query("SELECT * FROM tr_debit_note WHERE no_pr = '$id' ")->result();
		$detail = $this->db->query("SELECT a.*,b.nama  FROM dt_debit_note a
		  inner join  ms_inventory_category3 b ON a.idmaterial = b.id_category3
		  WHERE a.no_pr = '$id' ")->result();
		$data = [
			'header' => $header,
			'detail' => $detail,
		];
        $this->template->set('results', $data);
        $this->template->title('View P.R');
        $this->template->render('View');

    }

			public function viewPenawaran($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$penawaran = $this->Debit_note_model->get_data('child_penawaran','id_child_penawaran',$id);
		$inventory_3 = $this->Debit_note_model->get_data_category();
		$data = [
			'penawaran' => $penawaran,
			'inventory_3' => $inventory_3,
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Penawaran');
        $this->template->render('viewPenawaran');

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
		$headpenawaran = $this->Debit_note_model->get_data('tr_penawaran','no_penawaran',$id);
		$inventory_3 = $this->Debit_note_model->get_data_category();
		$data = [
			'inventory_3' => $inventory_3,
			'headpenawaran' => $headpenawaran
		];
        $this->template->set('results', $data);
        $this->template->title('Add Penawaran');
        $this->template->render('AddPenawaran');

    }

function AddMaterial()
    {
		$loop=$_GET['jumlah']+1;
		$material = $this->db->query("SELECT a.* FROM ms_inventory_category3 as a")->result();
		echo "
		<tr id='tr_$loop'>
		<td><input type='text' class='form-control' id='dt_keterangan_$loop' 	required name='dt[$loop][keterangan]' 	></td>		
		<td align='right' ><input type='text' class='form-control maskMoney ch_jumlah' id='dt_harga_$loop' 			required name='dt[$loop][harga]' 	onblur='HitAmmount($loop)'></td>
		<td><button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button></td>
		</tr>
		";
	}
function CariBentuk()
    {
        $id_category3=$_GET['idmaterial'];
		$loop=$_GET['id'];
		$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
		$id_bentuk = $kategory3[0]->id_bentuk;
		$bentukquery	= $this->db->query("SELECT * FROM ms_bentuk WHERE id_bentuk = '$id_bentuk' ")->result();
		$bentuk_material = $bentukquery[0]->nm_bentuk;
		echo "<input readonly type='text' class='form-control' value='".$bentuk_material."' id='dt_bentuk_".$loop."' required name='dt[".$loop."][bentuk]' >";
	}
function CariIdBentuk()
    {
        $id_category3=$_GET['idmaterial'];
		$loop=$_GET['id'];
		$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
		$id_bentuk = $kategory3[0]->id_bentuk;
		echo "<input readonly type='text' class='form-control' value='".$id_bentuk."' id='dt_idbentuk_".$loop."' required name='dt[".$loop."][idbentuk]' >";
	}
function CariSupplier()
    {
        $id_category3=$_GET['idmaterial'];
		$loop=$_GET['id'];
		$supplier	= $this->db->query("SELECT a.* FROM  master_supplier a")->result();
		echo "<select class='form-control select2' id='dt_suplier_".$loop."' name='dt[".$loop."][suplier]'>
		<option value=''>Pilih</option>";
		foreach($supplier as $supplier){
			echo"<option value='".$supplier->id_suplier ."'>".$supplier->name_suplier ."</option>";
		}
		echo"</select>";
	}
function getemail()
    {
        $id_customer=$_GET['id_customer'];
		$kategory3	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
		$thickness = $kategory3[0]->email;
		echo "<input type='email' class='form-control' id='email_customer' value='$thickness' required name='email_customer' >";
	}
function HitungTwight()
    {
        $loop=$_GET['id'];
		$dt_qty=$_GET['dt_qty'];
		$dt_weight=$_GET['dt_weight'];
		$totalweight=$dt_qty*$dt_weight;
		echo "<input type='number' value='".$totalweight."' class='form-control' id='dt_totalweight_$loop' 	required name='dt[$loop][totalweight]' >";
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
		$profit=$_GET['bottom']*$_GET['profit']/100;
		$hasil=$bottom+$komisi+$profit;
		echo "<input type='text' class='form-control' value='$hasil' id='harga_penawaran'  required name='harga_penawaran' placeholder='Bentuk Material'>";
	}

function CariKodeproduk()
    {
        $id_category3=$_GET['idmaterial'];
		$loop=$_GET['id'];
		$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
		$id_bentuk = $kategory3[0]->kode_barang;
		echo "<input readonly type='text' class='form-control' value='".$id_bentuk."' id='dt_kodeproduk_".$loop."' required name='dt[".$loop."][kodeproduk]' >";
	}
function carimsprofit()
    {
        $density=$_GET['density'];
		$inven1=$_GET['inven1'];
		$thickness=$_GET['thickness'];
		$width=$_GET['width'];
		$berat = $_GET['forecast'];
		$maxprofit	= $this->db->query("SELECT max(maksimum) as maximum FROM ms_profit_material WHERE alloy = '$inven1' ")->result();
		$nilaimax = $maxprofit[0]->maximum;
		
		if($berat > $nilaimax){
		$profitaa	= $this->db->query("SELECT * FROM ms_profit_material WHERE alloy = '$inven1' AND minimum < '$berat' AND maksimum  IS NULL   ")->result();
		$nilai_profit = $profitaa[0]->profit;	
		$aaa = huhu;
		}else{
		$profitaa	= $this->db->query("SELECT * FROM ms_profit_material WHERE  alloy = '$inven1' AND minimum < '$berat' AND maksimum >= '$berat'  ")->result();
		$nilai_profit = $profitaa[0]->profit;
		$aaa = hihi;
		}
		echo "$nilai_profit %";
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

	public function Approved(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('no_pr');
		$data = [
			'status' 		=> '2',
		];

		$this->db->trans_begin();
		$this->db->where('no_pr',$id)->update("tr_debit_note",$data);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Approve P.R. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Approve P.R. Thanks ...',
			  'status'	=> 1
			);
		}

  		echo json_encode($status);
	}
		function get_inven2()
    {
        $inventory_1=$_GET['inventory_1'];
        $data=$this->Debit_note_model->level_2($inventory_1);
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
        $data=$this->Debit_note_model->level_3($inventory_2);

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
		$hariini = date('Y-m-d');
		$sepuluh_hari = mktime(0,0,0,date('n'),date('j')-10,date('Y'));
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
		$kurs_terpakai = $post['kurs_terpakai'];
		if($kurs_terpakai=='spot'){
		$kurs	= $this->db->query("SELECT * FROM mata_uang WHERE kode = 'IDR' ")->result();
		$nominal = $kurs[0]->kurs;
		}elseif($kurs_terpakai=='10'){
		$kurs	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE tanggal_ubah BETWEEN  '$tendays' AND '$hariini' AND kode_kurs='IDR' ")->result();
		$nominal = $kurs[0]->nominal;
		}elseif($kurs_terpakai=='30'){
		$kurs	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE MONTH(tanggal_ubah) =  '$blnkmrn' AND YEAR(tanggal_ubah) = '$yearkemaren' AND kode_kurs='IDR' ")->result();
		$nominal = $kurs[0]->nominal;
		}else{
		$noinal = '1';
		}
		$code = $post['no_penawaran'];
		$dolar = $post['harga_penawaran']/$nominal;
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
							'kurs_terpakai'				=> $post['kurs_terpakai'],
							'inven1'				=> $post['inven1'],
							'bottom'				=> $post['bottom'],
							'dasar_harga'			=> $post['dasar_harga'],
							'komisi'				=> $post['komisi'],
							'profit'				=> $post['profit'],
							'keterangan'			=> $post['keterangan'],
							'harga_penawaran'		=> $post['harga_penawaran'],
							'harga_dolar'			=> $dolar,
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


	public function SaveNew()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		
		$bank = explode('|',$this->input->post('id_customer'));
            $kd_bank = $bank[0];
            $nmbank = $bank[1];
		
			
		$tgl  = $post['tanggal'];
		
		$code = $this->Debit_note_model->generate_code($tgl);
		$no_surat = $this->Debit_note_model->BuatNomor($tgl);
		$this->db->trans_begin();
		$data = [
							'no_pr'				=> $code,
							'no_surat'			=> $no_surat,
							'id_customer'		=> $kd_bank,
							'nm_customer'		=> $nmbank,
							'no_surat'			=> $no_surat,
							'total_tagihan'		=> str_replace(",","",$post['totalharga']),
							'tanggal'			=> $post['tanggal'],
							'requestor'			=> $post['requestor'],
							'status'			=> '1',
							'sisa_tagihan'		=> str_replace(",","",$post['totalharga']),
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id()
                            ];
            //Add Data
               $this->db->insert('tr_debit_note',$data);
			 
		$numb1 =0;
		foreach($_POST['dt'] as $used){
		$numb1++;

		$idmat  = $used[idmaterial];
		$materials = $this->db->query("SELECT a.* FROM ms_inventory_category3 a WHERE a.id_category3 ='$idmat' ")->row();


		            $dt =  array(
							'no_pr'					=> $code,
							'id_dt_pr'				=> $code.'-'.$numb1,
							'tagihan'			=> str_replace(',','',$used[harga]),
							'tanggal'			=> $post['tanggal'],							
							'keterangan'			=> $used[keterangan],
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id()
							);
                    $this->db->insert('dt_debit_note',$dt);
			
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
	public function SaveEdit()
    {
        $this->auth->restrict($this->addPermission); 
		$post = $this->input->post();
		
		// print_r($post);
		// exit;
		
		$code = $post['no_pr'];
		$no_surat = $post['no_surat'];
		$this->db->trans_begin();
		$data = [
							'no_pr'				=> $code,
							'no_surat'			=> $no_surat,
							'tanggal'			=> $post['tanggal'],
							'requestor'			=> $post['requestor'],
							'status'			=> '1',
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id()
                            ];
            //Add Data
			$this->db->where('no_pr',$code)->update("tr_debit_note",$data);
			$this->db->delete('dt_debit_note', array('no_pr' => $code));
			 
		$numb1 =0; 
		foreach($_POST['dt'] as $used){
		$numb1++;
		
		$materials = $this->db->query("SELECT a.*, b.nama as alloy, c.nm_bentuk as bentuk FROM ms_inventory_category3 as a INNER JOIN ms_inventory_category2 as b ON a.id_category2 = b.id_category2 INNER JOIN ms_bentuk as c ON a.id_bentuk = c.id_bentuk WHERE a.id_category3 = '".$used[idmaterial]."' AND a.deleted = '0'  ")->result();
		foreach ($materials as $material){
		if($material->id_bentuk == 'B2000001' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '22' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
			$nama_material="$material->bentuk $material->alloy $material->nama $material->hardness $thickness";
		}elseif($material->id_bentuk == 'B2000002' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '25' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
			$nama_material="$material->bentuk $material->alloy $material->nama $material->hardness $thickness";
		}elseif($material->id_bentuk == 'B2000003' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '30' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
			$nama_material="$material->bentuk $material->alloy $material->nama $material->hardness $thickness";
		}elseif($material->id_bentuk == 'B2000004' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '8' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		$dimensi2 = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '9' ")->result();
		$thickness2 = $dimensi[0]->nilai_dimensi;
			$nama_material="$material->bentuk $material->alloy $material->nama $material->hardness $thickness x $thickness";
		}elseif($material->id_bentuk == 'B2000005' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '11' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
			$nama_material="$material->bentuk $material->alloy $material->nama $material->hardness $thickness";
		}elseif($material->id_bentuk == 'B2000006' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '13' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
			$nama_material="$material->bentuk $material->alloy $material->nama $material->hardness $thickness";
		}elseif($material->id_bentuk == 'B2000007' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '15' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
		$dimensi2 = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '16' ")->result();
		$thickness2 = $dimensi[0]->nilai_dimensi;
			$nama_material= "$material->bentuk $material->alloy $material->nama $material->hardness $thickness $thickness2";
		}elseif($material->id_bentuk == 'B2000009' ){
		$dimensi = $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$material->id_category3' AND id_dimensi = '19' ")->result();
		$thickness = $dimensi[0]->nilai_dimensi;
			$nama_material= "$material->bentuk $material->alloy $material->nama $material->hardness $thickness";
		};
		};
		
		
			$idmat  = $used[idmaterial];
		    $matrial = $this->db->query("SELECT a.* FROM ms_inventory_category3 a WHERE a.id_category3 ='$idmat' ")->row();
		
                $dt =  array(
							'no_pr'					=> $code,
							'id_dt_pr'				=> $code.'-'.$numb1,
							'idmaterial'			=> $used[idmaterial],
							'nama_material'			=> $matrial->nama,
							'bentuk'				=> $used[bentuk],
							'id_bentuk'				=> $used[idbentuk],
							'idameter'				=> $used[idameter],
							'odameter'				=> str_replace(',','',$used[odameter]),
							
							
							'qty'				=> $used[qty],
							'weight'			=> $used[weight],
							'totalweight'		=> str_replace(',','',$used[totalweight]),
							'width'			=> str_replace(',','',$used[width]),
							'length'			=> str_replace(',','',$used[length]),
							'suplier'			=> $used[suplier],
							'tanggal'			=> $used[tanggal],
							'keterangan'		=> $used[keterangan],							
							'kode_barang'		=> $matrial->kode_barang,
                            );
                    $this->db->insert('dt_debit_note',$dt);
			
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
		$code		= $post['no_penawaran'];
		$no_surat	= $post['no_surat'];
		$this->db->trans_begin();
		$data = [
							'no_surat'				=> $no_surat,
							'tgl_penawaran'			=> date('Y-m-d'),
							'id_customer'			=> $post['id_customer'],
							'pic_customer'			=> $post['pic_customer'],
							'mata_uang'			=> $post['mata_uang'],
							'email_customer'		=> $post['email_customer'],
							'valid_until'			=> $post['valid_until'],
							'pengiriman'			=> $post['pengiriman'],
							'terms_payment'			=> $post['terms_payment'],
							'exclude_vat'			=> $post['exclude_vat'],
							'note'					=> $post['note'],
							'id_sales'				=> $post['id_sales'],
							'nama_sales'			=> $post['nama_sales'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
			$this->db->where('no_penawaran',$code)->update("tr_penawaran",$data);

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
		
		$this->db->trans_begin();
		$hariini = date('Y-m-d');
		$sepuluh_hari = mktime(0,0,0,date('n'),date('j')-10,date('Y'));
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
		$kurs_terpakai = $post['kurs_terpakai'];
		if($kurs_terpakai=='spot'){
		$kurs	= $this->db->query("SELECT * FROM mata_uang WHERE kode = 'IDR' ")->result();
		$nominal = $kurs[0]->kurs;
		}elseif($kurs_terpakai=='10'){
		$kurs	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE tanggal_ubah BETWEEN  '$tendays' AND '$hariini' AND kode_kurs='IDR' ")->result();
		$nominal = $kurs[0]->nominal;
		}elseif($kurs_terpakai=='30'){
		$kurs	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE MONTH(tanggal_ubah) =  '$blnkmrn' AND YEAR(tanggal_ubah) = '$yearkemaren' AND kode_kurs='IDR' ")->result();
		$nominal = $kurs[0]->nominal;
		}else{
		$noinal = '1';
		}
		$id = $post['id_child_penawaran'];
		$dolar = $post['harga_penawaran']/$nominal;
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
							'profit'				=> $post['profit'],
							'kurs_terpakai'			=> $post['kurs_terpakai'],
							'keterangan'			=> $post['keterangan'],
							'harga_penawaran'		=> $post['harga_penawaran'],
							'harga_dolar'			=> $dolar,
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
		$code = $this->Debit_note_model->generate_id();
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
        $comp=$this->Debit_note_model->compotition($inventory_2);
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
        $dim=$this->Debit_note_model->bentuk($id_bentuk);
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
        $comp=$this->Debit_note_model->compotition_edit($inventory_2);
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
        $dim=$this->Debit_note_model->bentuk_edit($id_bentuk);
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
		$code = $this->Debit_note_model->generate_id();
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
		$code = $this->Debit_note_model->generate_id();
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
        $comp=$this->Debit_note_model->compotition($inventory_2);
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


	public function index_approval()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->db->query("SELECT * FROM tr_debit_note WHERE status ='1' ORDER BY created_on DESC ")->result();
        $this->template->set('results', $data);
        $this->template->title('Debit Note Approval');
        $this->template->render('index_approval');
    }
	
	public function update_dtpr(){
		
		$dtpr = $this->db->query("SELECT a.* FROM dt_debit_note as a")->result();
		foreach ($dtpr as $dt){
			$idmaterial = $dt->idmaterial;
			$material = $this->db->query("SELECT a.* FROM ms_inventory_category3 as a WHERE id_category3='$idmaterial'")->row();
			$nama = $material->kode_barang;
			$this->db->query("UPDATE dt_debit_note SET kode_barang='$nama' WHERE idmaterial='$idmaterial'");
						
		};
		
	}
	
	public function PrintDN($id){
		ob_clean();
		ob_start();
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);

		$data['header']   = $this->db->query("SELECT * FROM tr_debit_note WHERE no_pr='$id'")->result();
		$data['detail']   = $this->db->query("SELECT * FROM dt_debit_note WHERE no_pr='$id'")->result();
		$this->load->view('printDN',$data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(10, 5, 10, 5));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('Debit Note.pdf', 'I');
	}

}
