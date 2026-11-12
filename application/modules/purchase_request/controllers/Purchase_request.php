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

class Purchase_request extends Admin_Controller 
{
    //Permission
    protected $viewPermission 	= 'Purchase_Request.View';
    protected $addPermission  	= 'Purchase_Request.Add';
    protected $managePermission = 'Purchase_Request.Manage';
    protected $deletePermission = 'Purchase_Request.Delete';

    public function __construct()
    {
        parent::__construct(); 
        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Purchase_request/Pr_model',
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
        $data = $this->db->query("SELECT * FROM tr_purchase_request ORDER BY created_on DESC ")->result();
        $this->template->set('results', $data);
        $this->template->title('Purchase Request');
        $this->template->render('index');
    }

		public function add()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Pr_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang','deleted'.$deleted);
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
		];
        $this->template->set('results', $data);
        $this->template->title('Purchase Request');
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
		$head = $this->db->query('SELECT * FROM tr_purchase_request WHERE no_pr = ?', array($id))->result();
        if (!$head) { show_404(); return; }
        if ((string) $head[0]->status !== '1') { show_error('Hanya PR Waiting yang dapat diedit.', 409); return; }
		$detail = $this->db->query('SELECT * FROM dt_trans_pr WHERE no_pr = ? ORDER BY id_dt_pr', array($id))->result();
		$customers = $this->Pr_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang','deleted'.$deleted);
		$data = [
			'head' => $head,
			'detail' => $detail,
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
		];
        $this->template->set('results', $data);
        $this->template->title('Purchase Request');
        $this->template->render('Edit');

    }
	public function add_pr()
    {
		$this->auth->restrict($this->viewPermission); 
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Pr_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang','deleted'.$deleted);
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
		];
        $this->template->set('results', $data);
        $this->template->title('Purchase Request');
        $this->template->render('Addpr');

    }
	public function PrintHeader1($id){
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);
		$data['header'] = $this->Pr_model->getHeaderPenawaran($id);
		$data['detail']  = $this->Pr_model->PrintDetail($id);
		$this->load->view('PrintHeader',$data);
	}
	public function PrintHeader($id){
		if (ob_get_level() > 0) {
			ob_clean();
		}
		ob_start();
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);
		$data['header'] = $this->Pr_model->getHeaderPenawaran($id);
		$data['detail']  = $this->Pr_model->PrintDetail($id);
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
		$head = $this->Pr_model->get_data('tr_penawaran','no_penawaran',$id);
		$customers = $this->Pr_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Pr_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Pr_model->get_data('mata_uang','deleted',$deleted);
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
        $detail = $this->Pr_model->getpenawaran($id);
		$header = $this->Pr_model->getHeaderPenawaran($id);
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
		$penawaran = $this->Pr_model->get_data('child_penawaran','id_child_penawaran',$id);
		$inventory_3 = $this->Pr_model->get_data_category();
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
		$header = $this->db->query('SELECT * FROM tr_purchase_request WHERE no_pr = ?', array($id))->result();
        if (!$header) { show_404(); return; }
		$detail = $this->db->query('SELECT a.*, COALESCE(b.nama, a.nama_material) AS nama,
            COALESCE(s.name_suplier, a.suplier) AS name_suplier FROM dt_trans_pr a
            LEFT JOIN ms_inventory_category3 b ON a.idmaterial = b.id_category3
            LEFT JOIN master_supplier s ON a.suplier = s.id_suplier
            WHERE a.no_pr = ? ORDER BY a.id_dt_pr', array($id))->result();
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
		$penawaran = $this->Pr_model->get_data('child_penawaran','id_child_penawaran',$id);
		$inventory_3 = $this->Pr_model->get_data_category();
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
		$headpenawaran = $this->Pr_model->get_data('tr_penawaran','no_penawaran',$id);
		$inventory_3 = $this->Pr_model->get_data_category();
		$data = [
			'inventory_3' => $inventory_3,
			'headpenawaran' => $headpenawaran
		];
        $this->template->set('results', $data);
        $this->template->title('Add Penawaran');
        $this->template->render('AddPenawaran');

    }

    public function AddMaterial()
    {
        $row = $this->prFragmentRow('jumlah');
        if ($row === null) return;
        $loop = $row + 1;
        $planning = $this->input->get('planning') === '1';
        $shapeHidden = $planning ? '' : 'hidden';
        $qtyHidden = $planning ? 'hidden' : '';
        $codeHidden = $planning ? 'hidden' : '';
        $material = $this->db->query('SELECT * FROM ms_inventory_category3')->result();
        echo "<tr id='tr_$loop'><td><select class='form-control select2' id='dt_idmaterial_$loop' name='dt[$loop][idmaterial]' onchange='CariProperties($loop)'><option value=''>Pilih</option>";
        foreach ($material as $item) {
            echo "<option value='" . html_escape((string) $item->id_category3) . "'>" . html_escape($item->nama . '|' . $item->kode_barang) . '</option>';
        }
        echo "</select></td>
            <td $shapeHidden id='bentuk_$loop'><input readonly type='text' class='form-control' id='dt_bentuk_$loop' name='dt[$loop][bentuk]'></td>
            <td hidden id='idbentuk_$loop'><input readonly type='text' class='form-control' id='dt_idbentuk_$loop' name='dt[$loop][idbentuk]'></td>
            <td $codeHidden id='kodeproduk_$loop'><input readonly type='text' class='form-control' id='dt_kodeproduk_$loop' name='dt[$loop][kodeproduk]'></td>
            <td $shapeHidden><select class='form-control select2' id='dt_idameter_$loop' name='dt[$loop][idameter]'>";
        if (!$planning) echo "<option value='0'>Pilih</option>";
        foreach (array(200, 250, 300, 400, 500) as $diameter) echo "<option value='$diameter'>$diameter</option>";
        echo "</select></td>
            <td $shapeHidden><input type='text' class='form-control autoNumeric' id='dt_odameter_$loop' name='dt[$loop][odameter]'></td>
            <td $qtyHidden><input type='number' class='form-control' id='dt_qty_$loop' name='dt[$loop][qty]' onkeyup='HitungTweight($loop)'></td>
            <td hidden><input type='number' class='form-control' id='dt_weight_$loop' name='dt[$loop][weight]' onkeyup='HitungTweight($loop)'></td>
            <td $shapeHidden id='HasilTwight_$loop'><input type='text' class='form-control autoNumeric' id='dt_totalweight_$loop' name='dt[$loop][totalweight]'></td>
            <td $shapeHidden><input type='text' class='form-control autoNumeric' id='dt_width_$loop' name='dt[$loop][width]'></td>
            <td hidden><input type='text' class='form-control autoNumeric' id='dt_length_$loop' name='dt[$loop][length]'></td>
            <td id='supplier_$loop'><select class='form-control select2' id='dt_suplier_$loop' name='dt[$loop][suplier]'><option value=''>Pilih</option></select></td>
            <td><input type='text' class='form-control datepicker' readonly id='dt_tanggal_$loop' name='dt[$loop][tanggal]'></td>
            <td><input type='text' class='form-control' id='dt_keterangan_$loop' name='dt[$loop][keterangan]'></td>
            <td><button type='button' class='btn btn-sm btn-danger' title='Hapus Data' onclick='HapusItem($loop)'><i class='fa fa-close'></i></button></td></tr>";
    }
    private function prFragmentRow($key = 'id')
    {
        $row = filter_var($this->input->get($key), FILTER_VALIDATE_INT, array('options' => array('min_range' => 0, 'max_range' => 1000000)));
        if ($row === false) { $this->output->set_status_header(422); return null; }
        return $row;
    }

    private function prMaterialInput($field, $name)
    {
        $loop = $this->prFragmentRow();
        $id = $this->input->get('idmaterial');
        if ($loop === null || !is_string($id)) return;
        $material = $this->db->query('SELECT a.*, b.nm_bentuk FROM ms_inventory_category3 a
            LEFT JOIN ms_bentuk b ON a.id_bentuk = b.id_bentuk WHERE a.id_category3 = ?', array($id))->row();
        $value = html_escape((string) ($material->$field ?? ''));
        echo "<input readonly type='text' class='form-control' value='$value' id='dt_{$name}_$loop' name='dt[$loop][$name]'>";
    }

    public function CariBentuk()
    {
        $this->prMaterialInput('nm_bentuk', 'bentuk');
    }

    public function CariIdBentuk()
    {
        $this->prMaterialInput('id_bentuk', 'idbentuk');
    }

    public function CariSupplier()
    {
        $loop = $this->prFragmentRow();
        if ($loop === null) return;
        $suppliers = $this->db->query('SELECT * FROM master_supplier')->result();
        echo "<select class='form-control select2' id='dt_suplier_$loop' name='dt[$loop][suplier]'><option value=''>Pilih</option>";
        foreach ($suppliers as $supplier) {
            echo "<option value='" . html_escape((string) $supplier->id_suplier) . "'>" . html_escape((string) $supplier->name_suplier) . '</option>';
        }
        echo '</select>';
    }
function getemail()
    {
        $id_customer=$_GET['id_customer'];
		$kategory3	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
		$thickness = $kategory3[0]->email;
		echo "<input type='email' class='form-control' id='email_customer' value='$thickness' required name='email_customer' >";
	}
    public function HitungTwight()
    {
        $loop = $this->prFragmentRow();
        if ($loop === null) return;
        try {
            $row = array('qty' => $this->input->get('dt_qty') ?? '', 'weight' => $this->input->get('dt_weight') ?? '');
            $total = (float) $this->prNumber($row, 'qty') * (float) $this->prNumber($row, 'weight');
            if (!is_finite($total)) throw new DomainException('Total weight tidak valid.');
            echo "<input type='number' value='$total' class='form-control' id='dt_totalweight_$loop' name='dt[$loop][totalweight]'>";
        } catch (DomainException $error) {
            $this->output->set_status_header(422);
        }
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

    public function CariKodeproduk()
    {
        $this->prMaterialInput('kode_barang', 'kodeproduk');
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

    public function Approved()
    {
        $this->auth->restrict($this->deletePermission);
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        $transaction = false;
        try {
            $post = $this->input->post();
            if (!is_array($post)) throw new DomainException('Data approval tidak valid.');
            $id = $this->prField($post, 'id', true);
            if (!$this->db->trans_begin()) throw new RuntimeException('Cannot start approval transaction');
            $transaction = true;
            $header = $this->prQuery('SELECT * FROM tr_purchase_request WHERE no_pr = ? FOR UPDATE', array($id))->row();
            if (!$header) throw new DomainException('PR tidak ditemukan.');
            if (!in_array((string) $header->status, array('1', '2'), true)) throw new DomainException('Status PR tidak dapat diapprove.');
            if ((string) $header->status === '1' && !$this->db->where('no_pr', $id)->update('tr_purchase_request', array('status' => '2'))) {
                throw new RuntimeException('Cannot approve PR');
            }
            if (!$this->db->trans_status() || !$this->db->trans_commit()) throw new RuntimeException('Cannot commit approval');
            $transaction = false;
            $this->prReply(1, 'PR berhasil diapprove.');
        } catch (Throwable $error) {
            if ($transaction) $this->db->trans_rollback();
            if (!($error instanceof DomainException)) log_message('error', 'PR approval failed: ' . $error->getMessage());
            $this->prReply(0, $error instanceof DomainException ? $error->getMessage() : 'PR gagal diapprove. Silakan coba lagi.');
        } finally {
            $this->db->db_debug = $debug;
        }
    }
		function get_inven2()
    {
        $inventory_1=$_GET['inventory_1'];
        $data=$this->Pr_model->level_2($inventory_1);
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
        $data=$this->Pr_model->level_3($inventory_2);

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
        $this->savePr(false);
    }

    public function SaveEdit()
    {
        $this->savePr(true);
    }

    private function prField($row, $key, $required = false)
    {
        $value = $row[$key] ?? '';
        if (!is_scalar($value) || is_bool($value)) throw new DomainException('Format ' . $key . ' tidak valid.');
        $value = trim((string) $value);
        if ($required && $value === '') throw new DomainException($key . ' tidak boleh kosong.');
        return $value;
    }

    private function prNumber($row, $field)
    {
        $value = $this->prField($row, $field);
        if ($value !== '' && (!preg_match('/^(?:[0-9]+|[0-9]{1,3}(?:,[0-9]{3})+)(?:\.[0-9]+)?$/D', $value) || !is_finite((float) str_replace(',', '', $value)))) {
            throw new DomainException('Nilai ' . $field . ' tidak valid.');
        }
        return $value === '' ? '0' : str_replace(',', '', $value);
    }

    private function prDate($value, $required = false)
    {
        if ($value === '' && !$required) return '';
        $date = DateTime::createFromFormat('!Y-m-d', $value);
        if (!$date || $date->format('Y-m-d') !== $value) throw new DomainException('Tanggal tidak valid. Gunakan yyyy-mm-dd.');
        return $value;
    }

    private function prQuery($sql, $binds = array())
    {
        $result = $this->db->query($sql, $binds);
        if ($result === false) throw new RuntimeException('PR database query failed');
        return $result;
    }

    private function prReply($status, $message, $code = null)
    {
        $result = array('status' => $status, 'pesan' => $message);
        if ($code !== null) $result['code'] = $code;
        $this->output->set_content_type('application/json');
        echo json_encode($result);
    }

    private function savePr($edit)
    {
        $this->auth->restrict($this->addPermission);
        $code = '';
        $transaction = false;
        $locked = false;
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        try {
            $post = $this->input->post();
            if (!is_array($post)) throw new DomainException('Data PR tidak valid.');
            $date = $this->prDate($this->prField($post, 'tanggal', true), true);
            $requestor = $this->prField($post, 'requestor', true);
            if (empty($post['dt']) || !is_array($post['dt'])) throw new DomainException('Detail PR tidak boleh kosong.');
            if (!$edit) {
                // ponytail: covers this module only; other PR writers must adopt the same lock.
                $lock = $this->prQuery("SELECT GET_LOCK('purchase_request_numbering', 5) AS acquired")->row();
                if (!$lock || (int) $lock->acquired !== 1) throw new DomainException('Nomor PR sedang dipakai. Silakan coba lagi.');
                $locked = true;
            }
            if (!$this->db->trans_begin()) throw new RuntimeException('Cannot start PR transaction');
            $transaction = true;
            $existing = array();
            $nextDetail = 0;
            if ($edit) {
                $code = $this->prField($post, 'no_pr', true);
                $header = $this->prQuery('SELECT * FROM tr_purchase_request WHERE no_pr = ? FOR UPDATE', array($code))->row();
                if (!$header) throw new DomainException('PR tidak ditemukan.');
                if ((string) $header->status !== '1') throw new DomainException('Hanya PR Waiting yang dapat diedit.');
                foreach ($this->prQuery('SELECT * FROM dt_trans_pr WHERE no_pr = ?', array($code))->result() as $detail) {
                    $existing[$detail->id_dt_pr] = true;
                    $nextDetail = max($nextDetail, (int) substr($detail->id_dt_pr, strlen($code) + 1));
                }
            }
            $details = array();
            $usedIds = array();
            foreach ($post['dt'] as $row) {
                if (!is_array($row)) throw new DomainException('Format detail PR tidak valid.');
                $materialId = $this->prField($row, 'idmaterial', true);
                $material = $this->prQuery('SELECT * FROM ms_inventory_category3 WHERE id_category3 = ?', array($materialId))->row();
                if (!$material) throw new DomainException('Material PR tidak ditemukan.');
                $supplier = $this->prField($row, 'suplier');
                if ($supplier !== '' && !$this->prQuery('SELECT id_suplier FROM master_supplier WHERE id_suplier = ?', array($supplier))->row()) {
                    throw new DomainException('Supplier PR tidak ditemukan.');
                }
                $detail = array('idmaterial' => $materialId, 'nama_material' => $material->nama,
                    'kode_barang' => $material->kode_barang, 'id_bentuk' => $material->id_bentuk,
                    'bentuk' => $this->prField($row, 'bentuk'), 'suplier' => $supplier,
                    'tanggal' => $this->prDate($this->prField($row, 'tanggal', true), true),
                    'keterangan' => $this->prField($row, 'keterangan'));
                foreach (array('idameter', 'odameter', 'qty', 'weight', 'totalweight', 'width', 'length') as $field) {
                    $detail[$field] = $this->prNumber($row, $field);
                }
                $detailId = $this->prField($row, 'id_dt_pr');
                if ($detailId !== '' && (!$edit || !isset($existing[$detailId]) || isset($usedIds[$detailId]))) {
                    throw new DomainException('ID detail PR tidak valid.');
                }
                if ($detailId !== '') $usedIds[$detailId] = true;
                $detail['id_dt_pr'] = $detailId;
                $details[] = $detail;
            }
            if ($edit) {
                if (!$this->db->where('no_pr', $code)->update('tr_purchase_request', array('tanggal' => $date, 'requestor' => $requestor))) {
                    throw new RuntimeException('Cannot update PR');
                }
                if (!$this->db->delete('dt_trans_pr', array('no_pr' => $code))) throw new RuntimeException('Cannot replace PR details');
            } else {
                $code = $this->Pr_model->generate_code($date);
                $letter = $this->Pr_model->BuatNomor($date);
                if (!$this->db->insert('tr_purchase_request', array('no_pr' => $code, 'no_surat' => $letter,
                    'tanggal' => $date, 'requestor' => $requestor, 'status' => '1',
                    'created_on' => date('Y-m-d H:i:s'), 'created_by' => $this->auth->user_id()))) {
                    throw new RuntimeException('Cannot create PR');
                }
            }
            foreach ($details as $detail) {
                $detail['no_pr'] = $code;
                if ($detail['id_dt_pr'] === '') $detail['id_dt_pr'] = $code . '-' . (++$nextDetail);
                if (!$this->db->insert('dt_trans_pr', $detail)) throw new RuntimeException('Cannot save PR detail');
            }
            if (!$this->db->trans_status() || !$this->db->trans_commit()) throw new RuntimeException('Cannot commit PR');
            $transaction = false;
            $this->prReply(1, 'PR berhasil disimpan.', $code);
        } catch (Throwable $error) {
            if ($transaction) $this->db->trans_rollback();
            if (!($error instanceof DomainException)) log_message('error', 'PR save failed: ' . $error->getMessage());
            $this->prReply(0, $error instanceof DomainException ? $error->getMessage() : 'PR gagal disimpan. Silakan coba lagi.', $code);
        } finally {
            try {
                if ($locked) $this->db->query("SELECT RELEASE_LOCK('purchase_request_numbering') AS released");
            } catch (Throwable $error) {
                log_message('error', 'Cannot release PR number lock: ' . $error->getMessage());
            } finally {
                $this->db->db_debug = $debug;
            }
        }
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
		$code = $this->Pr_model->generate_id();
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
        $comp=$this->Pr_model->compotition($inventory_2);
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
        $dim=$this->Pr_model->bentuk($id_bentuk);
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
        $comp=$this->Pr_model->compotition_edit($inventory_2);
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
        $dim=$this->Pr_model->bentuk_edit($id_bentuk);
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
		$code = $this->Pr_model->generate_id();
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
		$code = $this->Pr_model->generate_id();
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
        $comp=$this->Pr_model->compotition($inventory_2);
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
        $data = $this->db->query("SELECT * FROM tr_purchase_request WHERE status ='1' ORDER BY created_on DESC ")->result();
        $this->template->set('results', $data);
        $this->template->title('Purchase Request');
        $this->template->render('index_approval');
    }
	
	public function update_dtpr(){
		
		$dtpr = $this->db->query("SELECT a.* FROM dt_trans_pr as a")->result();
		foreach ($dtpr as $dt){
			$idmaterial = $dt->idmaterial;
			$material = $this->db->query("SELECT a.* FROM ms_inventory_category3 as a WHERE id_category3='$idmaterial'")->row();
			$nama = $material->kode_barang;
			$this->db->query("UPDATE dt_trans_pr SET kode_barang='$nama' WHERE idmaterial='$idmaterial'");
						
		};
		
	}

}
