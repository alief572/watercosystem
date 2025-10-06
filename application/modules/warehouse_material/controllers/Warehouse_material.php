<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Warehouse_material extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Warehouse_material.View';
    protected $addPermission  	= 'Warehouse_material.Add';
    protected $managePermission = 'Warehouse_material.Manage';
    protected $deletePermission = 'Warehouse_material.Delete';

   public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Warehouse_material/warehouse_material_model'
                                ));
        $this->template->title('Manage Data Supplier');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');
    }

    //==========================================================================================================
    //============================================STOCK=========================================================
    //==========================================================================================================

    public function stock(){
      $this->auth->restrict($this->viewPermission);
      $session  = $this->session->userdata('app_session');
      $this->template->page_icon('fa fa-users');
      $this->template->title('Materials Stock');
      $this->template->render('stock');
    }

    public function data_side_stock(){
  		$this->warehouse_material_model->get_json_stock();
  	}

    //==========================================================================================================
    //============================================STOCK PRO=========================================================
    //==========================================================================================================

    public function stock_pro(){
      $this->auth->restrict($this->viewPermission);
      $session  = $this->session->userdata('app_session');
      $this->template->page_icon('fa fa-users');
      $this->template->title('Materials Stock Produksi');
      $this->template->render('stock_pro');
    }

    public function data_side_stock_pro(){
  		$this->warehouse_material_model->get_json_stock_pro();
  	}

    //==========================================================================================================
    //============================================WIP=========================================================
    //==========================================================================================================

    public function wip(){
      $this->auth->restrict($this->viewPermission);
      $session  = $this->session->userdata('app_session');
      $this->template->page_icon('fa fa-users');
      $this->template->title('Material Request');
      $this->template->render('wip');
    }

    public function data_side_wip(){
  		$this->warehouse_material_model->get_json_wip();
  	}

    public function add_wip(){
      if($this->input->post()){
        $data 			= $this->input->post();
    		$session  = $this->session->userdata('app_session');
    		$detail			= $data['detail'];
        $Ym = date('ym');
        $srcMtr			  = "SELECT MAX(no_wip) as maxP FROM material_wip WHERE no_wip LIKE 'WIP".$Ym."%' ";
        $numrowMtr		= $this->db->query($srcMtr)->num_rows();
        $resultMtr		= $this->db->query($srcMtr)->result_array();
        $angkaUrut2		= $resultMtr[0]['maxP'];
        $urutan2		  = (int)substr($angkaUrut2, 7, 3);
        $urutan2++;
        $urut2			  = sprintf('%03s',$urutan2);
        $no_wip	      = "WIP".$Ym.$urut2;

        $q_header = "SELECT
                      	b.*
                      FROM
                      	produksi_planning b
                      WHERE
                      	b.no_plan = '".$data['plandate']."'";
        $resultHP = $this->db->query($q_header)->result();

        $ArrHeader = array(
          'no_wip'        => $no_wip,
          'costcenter'    => 'CC2000012',
          'date_awal'     => $resultHP[0]->date_awal,
          'date_akhir'    => $resultHP[0]->date_akhir,
          'no_plan'       => $resultHP[0]->no_plan,
          'created_by'	  => $session['id_user'],
          'created_date'	=> date('Y-m-d H:i:s')
        );

        $ArrDetail	= array();
        $ArrUpdateMat	= array();
        $ArrUpdatePro	= array();
        $ArrHist	= array();
        $SUM_QTY = 0;
        $SUM_PACK = 0;
        foreach($detail AS $val => $valx){

          $qty_packing  = str_replace(',','',$valx['qty_packing']);
          $qty_aktual   = str_replace(',','',$valx['qty_aktual']);

          $SUM_QTY  += $qty_aktual;
          $SUM_PACK += $qty_packing;

          $ArrDetail[$val]['no_wip']        = $no_wip;
          $ArrDetail[$val]['material']      = $valx['material'];
          $ArrDetail[$val]['qty_material']  = $valx['qty_material'];
          $ArrDetail[$val]['unit']          = $valx['unit'];
          $ArrDetail[$val]['qty_packing']   = $qty_packing;
          $ArrDetail[$val]['unit_packing']  = $valx['unit_packing'];
          $ArrDetail[$val]['qty_aktual'] 	  = $qty_aktual;
          $ArrDetail[$val]['unit_aktual']   = $valx['unit_aktual'];

          $sqlWhDetail	   = "SELECT b.* FROM warehouse_stock b WHERE b.id_material = '".$valx['material']."' AND b.kd_gudang = 'PRO'";
  				$restWhDetail	   = $this->db->query($sqlWhDetail)->result();

          $sqlWhDetailMat	  = "SELECT b.* FROM warehouse_stock b WHERE 	b.id_material = '".$valx['material']."' AND b.kd_gudang = 'OPC'";
  				$restWhDetailMat	= $this->db->query($sqlWhDetailMat)->result();

          //update warehouse material
  				$ArrUpdateMat[$val]['id_material']        = $valx['material'];
  				$ArrUpdateMat[$val]['kd_gudang'] 	        = 'OPC';
          $ArrUpdateMat[$val]['outgoing'] 	        = $qty_aktual;
  				$ArrUpdateMat[$val]['qty_stock'] 	        = $restWhDetailMat[0]->qty_stock - $qty_aktual;
          $ArrUpdateMat[$val]['outgoing_packing'] 	= $qty_packing;
          $ArrUpdateMat[$val]['qty_stock_packing'] 	= $restWhDetailMat[0]->qty_stock_packing - $qty_packing;
  				$ArrUpdateMat[$val]['update_by'] 	        = $session['id_user'];
  				$ArrUpdateMat[$val]['update_date']        = date('Y-m-d H:i:s');

          //update warehouse produksi
  				$ArrUpdatePro[$val]['id_material']        = $valx['material'];
  				$ArrUpdatePro[$val]['kd_gudang'] 	        = 'PRO';
          $ArrUpdatePro[$val]['incoming'] 	        = $qty_aktual;
  				$ArrUpdatePro[$val]['qty_stock'] 	        = $restWhDetail[0]->qty_stock + $qty_aktual;
          $ArrUpdatePro[$val]['incoming_packing'] 	= $qty_packing;
          $ArrUpdatePro[$val]['qty_stock_packing'] 	= $restWhDetail[0]->qty_stock_packing + $qty_packing;
  				$ArrUpdatePro[$val]['update_by'] 	        = $session['id_user'];
  				$ArrUpdatePro[$val]['update_date']        = date('Y-m-d H:i:s');

          //insert history
  				$ArrHist[$val]['id_material'] 		  = $restWhDetail[0]->id_material;
  				$ArrHist[$val]['idmaterial'] 		    = $restWhDetail[0]->idmaterial;
  				$ArrHist[$val]['nm_material'] 		  = $restWhDetail[0]->nm_material;
  				$ArrHist[$val]['kd_gudang_dari'] 	  = "OPC";
  				$ArrHist[$val]['kd_gudang_ke'] 		  = "PRO";
          $ArrHist[$val]['incoming_awal'] 	  = $restWhDetail[0]->incoming;
  				$ArrHist[$val]['incoming_akhir'] 	  = $restWhDetail[0]->incoming + $qty_aktual;
  				$ArrHist[$val]['qty_stock_awal'] 	  = $restWhDetail[0]->qty_stock;
  				$ArrHist[$val]['qty_stock_akhir'] 	= $restWhDetail[0]->qty_stock + $qty_aktual;
  				$ArrHist[$val]['qty_booking_awal'] 	= $restWhDetail[0]->qty_booking;
  				$ArrHist[$val]['qty_booking_akhir'] = $restWhDetail[0]->qty_booking;
  				$ArrHist[$val]['qty_rusak_awal'] 	  = $restWhDetail[0]->qty_rusak;
  				$ArrHist[$val]['qty_rusak_akhir'] 	= $restWhDetail[0]->qty_rusak;
  				$ArrHist[$val]['no_trans'] 			    = $no_wip;
  				$ArrHist[$val]['jumlah_mat'] 		    = $qty_aktual;
  				$ArrHist[$val]['update_by'] 		    = $session['id_user'];
  				$ArrHist[$val]['update_date'] 		  = date('Y-m-d H:i:s');
          $ArrHist[$val]['incoming_awal_packing'] 	  = $restWhDetail[0]->incoming_packing;
  				$ArrHist[$val]['incoming_akhir_packing'] 	  = $restWhDetail[0]->incoming_packing + $qty_packing;
          $ArrHist[$val]['qty_stock_awal_packing'] 	  = $restWhDetail[0]->qty_stock_packing;
  				$ArrHist[$val]['qty_stock_akhir_packing'] 	= $restWhDetail[0]->qty_stock_packing + $qty_packing;
  				$ArrHist[$val]['qty_booking_awal_packing'] 	= $restWhDetail[0]->qty_booking_packing;
  				$ArrHist[$val]['qty_booking_akhir_packing'] = $restWhDetail[0]->qty_booking_packing;
  				$ArrHist[$val]['qty_rusak_awal_packing'] 	  = $restWhDetail[0]->qty_rusak_packing;
  				$ArrHist[$val]['qty_rusak_akhir_packing'] 	= $restWhDetail[0]->qty_rusak;
          $ArrHist[$val]['jumlah_mat_packing'] 		    = $qty_packing;

        }

        //insert adjustment
        $ArrInsertH = array(
  				'no_ipp'             => $no_wip,
  				'jumlah_mat'         => $SUM_QTY,
          'jumlah_mat_packing' => $SUM_PACK,
  				'kd_gudang_dari'     => 'OPC',
  				'kd_gudang_ke'       => 'PRO',
  				// 'note' => $note,
          // 'tanda_terima' => $tanda_terima,
  				'created_by'    => $session['id_user'],
  				'created_date'  => date('Y-m-d H:i:s')
  			);

        $q_update = "SELECT
                  	a.id,
                  	a.sts_wip
                  FROM
                  	produksi_planning_data a
                  	LEFT JOIN produksi_planning b ON a.no_plan = b.no_plan
                  WHERE
                  	b.costcenter = 'CC2000012'
                    AND a.no_plan = '".$data['plandate']."'
                  	AND a.sts_wip = 'N'";
        $result_update = $this->db->query($q_update)->result_array();
        $ArrUpdate	= array();
        foreach($result_update AS $val => $valx){
          $ArrUpdate[$val]['id']          = $valx['id'];
          $ArrUpdate[$val]['sts_wip']     = 'Y';
          $ArrUpdate[$val]['updated_by']  = $session['id_user'];
          $ArrUpdate[$val]['updated_date']= date('Y-m-d H:i:s');
          $ArrUpdate[$val]['no_wip']      = $no_wip;
        }

        $ArrHeadPlan = array(
          'sts_plan' => 'Y'
        );

        $sales_header    = $this->db->query("SELECT * FROM sales_order_header WHERE delivery_date BETWEEN '".$resultHP[0]->date_awal."' AND '".$resultHP[0]->date_akhir."' ")->result_array();
        $ArrUpdSales	= array();
        foreach($sales_header AS $val => $valx){
          $ArrUpdSales[$val]['no_so']      = $valx['no_so'];
          $ArrUpdSales[$val]['sts_plan']   = 'Y';
        }

        $sales_detail    = $this->db->query("SELECT *, SUM(qty_order) AS order_plan FROM sales_order_detail WHERE delivery_date BETWEEN '".$resultHP[0]->date_awal."' AND '".$resultHP[0]->date_akhir."' GROUP BY product ")->result_array();
        $ArrUpdStockProduct	= array();
        $ArrHistProduct = array();
        foreach($sales_detail AS $val => $valx){
          $ArrUpdStockProduct[$val]['id_product']  = $valx['product'];
          $ArrUpdStockProduct[$val]['qty_order']   = $valx['order_plan'];
          $ArrUpdStockProduct[$val]['update_by']  = $session['id_user'];
          $ArrUpdStockProduct[$val]['update_date']= date('Y-m-d H:i:s');

          $sqlhistPro	   = "SELECT * FROM warehouse_product WHERE id_product = '".$valx['product']."' AND category = 'product'";
  				$resthistPro	 = $this->db->query($sqlhistPro)->result();

          //insert history
  				$ArrHistProduct[$val]['category'] 		     = 'product';
  				$ArrHistProduct[$val]['id_product'] 		 = $valx['product'];
  				$ArrHistProduct[$val]['qty_order_awal']  = $resthistPro[0]->qty_order;
  				$ArrHistProduct[$val]['qty_order_akhir'] = $resthistPro[0]->qty_order + $valx['order_plan'];
          $ArrHistProduct[$val]['no_trans'] 		   = $no_wip;
          $ArrHistProduct[$val]['update_by'] 	   = $session['id_user'];
  				$ArrHistProduct[$val]['update_date'] 	 = date('Y-m-d H:i:s');
        }


        //HISTORT STOCK

        // echo $q_update;
        // print_r($ArrHeader);
        // print_r($ArrDetail);
        // print_r($ArrUpdate);
        // print_r($ArrUpdateMat);
        // print_r($ArrUpdatePro);
        // print_r($ArrHist);
        // print_r($ArrInsertH);

        // print_r($ArrUpdStockProduct);
        // print_r($ArrHistProduct);
        // exit;

        $this->db->trans_start();
          $this->db->where('no_plan', $data['plandate']);
          $this->db->update('produksi_planning', $ArrHeadPlan);

          $this->db->insert('material_wip', $ArrHeader);
          $this->db->insert_batch('material_wip_detail', $ArrDetail);
          $this->db->update_batch('produksi_planning_data', $ArrUpdate, 'id');

          $this->db->where('kd_gudang','OPC');
          $this->db->update_batch('warehouse_stock', $ArrUpdateMat, 'id_material');

          $this->db->where('kd_gudang','PRO');
          $this->db->update_batch('warehouse_stock', $ArrUpdatePro, 'id_material');

          $this->db->insert_batch('warehouse_history', $ArrHist);
          $this->db->insert('warehouse_adjustment', $ArrInsertH);

          $this->db->update_batch('sales_order_header', $ArrUpdSales, 'no_so');

          $this->db->where('category','product');
          $this->db->update_batch('warehouse_product', $ArrUpdStockProduct, 'id_product');
          $this->db->insert_batch('warehouse_product_history', $ArrHistProduct);
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE){
          $this->db->trans_rollback();
          $Arr_Data	= array(
            'pesan'		=>'Save gagal disimpan ...',
            'status'	=> 0
          );
        }
        else{
          $this->db->trans_commit();
          $Arr_Data	= array(
            'pesan'		=>'Save berhasil disimpan. Thanks ...',
            'status'	=> 1
          );
          history("Insert Material WIP ".$no_wip);
        }
        echo json_encode($Arr_Data);
      }
      else{
        $this->template->title('Materials WIP');
        $this->template->render('add_wip');
      }
  	}

    public function get_wip_produksi(){
      $no_plan = $this->uri->segment(3);
      $query = "SELECT
                  a.*,
                  b.nm_material,
                  b.unit,
                  b.konversi,
                  b.satuan_packing
                FROM
                  get_material_wip a LEFT JOIN ms_material b ON a.code_material=b.code_material WHERE a.no_plan='".$no_plan."'";
      $result = $this->db->query($query)->result_array();
      $num_r = $this->db->query($query)->num_rows();
      $d_Header = "<div class='box box-primary'>";
        	$d_Header .= "<div class='box-body'>";
          $d_Header .= "<table class='table table-bordered table-striped'>";
          $d_Header .= "<thead>";
          $d_Header .= "<tr>";
            $d_Header .= "<th class='text-center' width='5%' style='vertical-align:middle;'>#</th>";
            $d_Header .= "<th class='text-center' width='30%' style='vertical-align:middle;'>Material Name</th>";
            $d_Header .= "<th class='text-center' width='13%' style='vertical-align:middle;'>Qty Packing</th>";
            $d_Header .= "<th class='text-center' width='13%' style='vertical-align:middle;'>Qty Material</th>";
            $d_Header .= "<th class='text-center' width='13%' style='vertical-align:middle;'>Actual Qty Packing</th>";
            $d_Header .= "<th class='text-center' width='13%' style='vertical-align:middle;'>Unit Packing</th>";
            $d_Header .= "<th class='text-center' width='13%' style='vertical-align:middle;'>Actual Qty Material (Kg)</th>";
          $d_Header .= "</tr>";
          $d_Header .= "</thead>";
          $d_Header .= "<tbody>";
          foreach ($result as $key => $value) { $key++;
            $d_Header .= "<tr>";
              $d_Header .= "<td class='text-center'>".$key."</td>";
              $d_Header .= "<td>".strtoupper($value['nm_material'])."</td>";
              $d_Header .= "<td class='text-right'>".number_format($value['weight']/$value['konversi'],2)." ".ucfirst($value['satuan_packing'])."</td>";
              $d_Header .= "<td class='text-right'>".number_format($value['weight'],2)." ".ucfirst($value['unit'])."</td>";
              $d_Header .= "<td>
                            <input type='text' name='detail[".$key."][qty_packing]' id='pack_".$key."' data-konversi='".$value['konversi']."' class='form-control input-md text-right maskM inputPacking'>
                            </td>";
              $d_Header .= "<td class='text-center'>".ucfirst($value['satuan_packing'])."</td>";
              $d_Header .= "<td>
                            <input type='text' name='detail[".$key."][qty_aktual]' id='qty_".$key."' class='form-control input-md text-right' readonly='readonly'>
                            <input type='hidden' name='detail[".$key."][material]' class='form-control input-md' value='".$value['code_material']."'>
                            <input type='hidden' name='detail[".$key."][qty_material]' class='form-control input-md' value='".$value['weight']."'>
                            <input type='hidden' name='detail[".$key."][unit]' class='form-control input-md' value='".$value['unit']."'>
                            <input type='hidden' name='detail[".$key."][unit_packing]' class='form-control input-md' value='".$value['satuan_packing']."'>
                            <input type='hidden' name='detail[".$key."][unit_aktual]' class='form-control input-md' value='".$value['unit']."'>
                            </td>";
            $d_Header .= "</tr>";
          }
          if($num_r < 1){
            $d_Header .= "<tr>";
            $d_Header .= "<td colspan='6'>Data not found ...</td>";
            $d_Header .= "</tr>";
          }
          $d_Header .= "</tbody>";
          $d_Header .= "</table>";
          $d_Header .= "</div>";
      $d_Header .= "</div>";


  		 echo json_encode(array(
  				'header'			=> $d_Header,
          'num' => $num_r
  		 ));
  	}

    public function detail_wip(){
      $no_wip     = $this->uri->segment(3);
      $created    = str_replace('sp4si',' ',$this->uri->segment(4));
      $dated      = str_replace('sp4si',' ',$this->uri->segment(5));

      $query 	= "SELECT a.*, b.nm_material FROM material_wip_detail a LEFT JOIN ms_material b ON a.material=b.code_material WHERE no_wip='".$no_wip."'";
      $result		= $this->db->query($query)->result_array();

      $data = array(
        'data' => $result
      );

      $this->template->set('results', $data);
      history("View detail wip ".$no_wip);
      $this->template->title('Materials WIP');
      $this->template->render('detail_wip');
    }

    //==========================================================================================================
    //============================================INCOMING=========================================================
    //==========================================================================================================

    public function incoming(){
      $this->auth->restrict($this->viewPermission);
      $session  = $this->session->userdata('app_session');
      $this->template->page_icon('fa fa-users');

      $query = "SELECT no_po FROM tran_material_purchase_header WHERE sts_ajuan = 'OPN' ORDER BY no_po ASC ";
      // echo $query;
  		$restQuery = $this->db->query($query)->result_array();
  		$data = array(
  			'no_po' => $restQuery
  		);

      $this->template->set('results', $data);
      $this->template->title('Materials Incoming');
      $this->template->render('incoming');
    }

    public function data_side_incoming(){
      $this->warehouse_material_model->get_json_incoming();
    }

    public function adjustment(){
      $no_po = $this->uri->segment(3);
      $gudang = $this->uri->segment(4);

      $qBQdetailHeader 	= " SELECT
                              a.*,
                              SUM(a.qty) AS qty,
                              SUM(a.qty_in) AS qty_in,
                              b.satuan_packing,
                              b.konversi,
                              b.unit
                            FROM tran_material_purchase_detail a LEFT JOIN ms_material b ON a.id_material=b.code_material
                            WHERE
                              a.no_po='".$no_po."'
                              AND complete = 'N'
                            GROUP BY id_material";
      $qBQdetailRest		= $this->db->query($qBQdetailHeader)->result_array();
      $qBQdetailNum		= $this->db->query($qBQdetailHeader)->num_rows();
      // echo $qBQdetailHeader;
      // exit;

      $data = array(
        'qBQdetailHeader' => $qBQdetailHeader,
        'qBQdetailRest' => $qBQdetailRest,
        'qBQdetailNum' => $qBQdetailNum,
        'no_po' => $no_po,
        'gudang' => $gudang
      );

      $this->template->set('results', $data);
      $this->template->title('Materials In');
      $this->template->render('adjustment');
  	}

    public function in_material(){
  		$data 			= $this->input->post();
  		$session  = $this->session->userdata('app_session');
  		$no_po			= $data['no_po'];
  		$gudang			= $data['gudang'];
  		// $note			= strtolower($data['note']);
      // $tanda_terima			= strtoupper($data['tanda_terima']);
  		$addInMat		= $data['addInMat'];
  		$adjustment 	= $data['adjustment'];

  		// echo $no_po;
  		// print_r($addInMat);
  		// exit;

  		if($adjustment == 'IN'){
  			$histHlp = "Material Adjustment In Purchase To ".$gudang." / ".$no_po;
  		}

  		if($adjustment == 'IN'){
  			$ArrUpdate		 = array();
  			$ArrInList		 = array();
  			$ArrDeatil		 = array();
  			$ArrHist		 = array();

        $ArrUpdateMat		 = array();

  			$SumMat = 0;
  			$SumRisk = 0;

        $SumMatPack = 0;
  			$SumRiskPack = 0;
  			foreach($addInMat AS $val => $valx){
  				$SumMat += $valx['qty_in'];
  				$SumRisk += $valx['qty_rusak'];

          $SumMatPack += $valx['qty_in_pack'];
  				$SumRiskPack += $valx['qty_rusak_pack'];

  				$sqlWhDetail	= "	SELECT
  									a.*,
  									b.id AS id2,
  									b.*
  								FROM
  									tran_material_purchase_detail a
  									LEFT JOIN warehouse_stock b
  										ON a.id_material=b.id_material
  								WHERE
  									a.id = '".$valx['id']."' AND b.kd_gudang = 'OPC'
  								";
  				$restWhDetail	= $this->db->query($sqlWhDetail)->result();

          // echo $sqlWhDetail;
  				//update detail purchase
  				$ArrUpdate[$val]['id'] 			= $valx['id'];
  				$ArrUpdate[$val]['qty_in'] 		= $restWhDetail[0]->qty_in + $valx['qty_in'];
  				$ArrUpdate[$val]['complete'] 	= (!empty($valx['complete']))?$valx['complete']:'N';
          $ArrUpdate[$val]['qty_in_packing'] 		= $restWhDetail[0]->qty_in_packing + $valx['qty_in_pack'];

  				$ArrInList[$val]['complete'] 	= (!empty($valx['complete']))?$valx['complete']:'N';

          //Update_mat


  				//update stock
  				$ArrDeatil[$val]['id'] 			    = $restWhDetail[0]->id2;
  				// $ArrDeatil[$val]['id_material'] = $restWhDetail[0]->id_material;
  				// $ArrDeatil[$val]['kd_gudang'] 	= $restWhDetail[0]->kd_gudang;
          $ArrDeatil[$val]['incoming'] 	  = $valx['qty_in'];
  				$ArrDeatil[$val]['qty_stock'] 	= $restWhDetail[0]->qty_stock + $valx['qty_in'];
  				$ArrDeatil[$val]['qty_rusak'] 	= $restWhDetail[0]->qty_rusak + $valx['qty_rusak'];
          $ArrDeatil[$val]['incoming_packing'] 	= $valx['qty_in_pack'];
          $ArrDeatil[$val]['qty_stock_packing'] 	= $restWhDetail[0]->qty_stock_packing + $valx['qty_in_pack'];
  				$ArrDeatil[$val]['qty_rusak_packing'] 	= $restWhDetail[0]->qty_rusak_packing + $valx['qty_rusak_pack'];
  				$ArrDeatil[$val]['update_by'] 	= $session['id_user'];
  				$ArrDeatil[$val]['update_date'] = date('Y-m-d H:i:s');

  				//insert history
  				$ArrHist[$val]['id_material'] 		= $restWhDetail[0]->id_material;
  				$ArrHist[$val]['idmaterial'] 		= $restWhDetail[0]->idmaterial;
  				$ArrHist[$val]['nm_material'] 		= $restWhDetail[0]->nm_material;
  				$ArrHist[$val]['id_category'] 		= $restWhDetail[0]->id_category;
  				$ArrHist[$val]['nm_category'] 		= $restWhDetail[0]->nm_category;
  				$ArrHist[$val]['kd_gudang_dari'] 	= "PURCHASE";
  				$ArrHist[$val]['kd_gudang_ke'] 		= $restWhDetail[0]->kd_gudang;
          $ArrHist[$val]['incoming_awal'] 	= $restWhDetail[0]->incoming;
  				$ArrHist[$val]['incoming_akhir'] 	= $restWhDetail[0]->incoming + $valx['qty_in'];
  				$ArrHist[$val]['qty_stock_awal'] 	= $restWhDetail[0]->qty_stock;
  				$ArrHist[$val]['qty_stock_akhir'] 	= $restWhDetail[0]->qty_stock + $valx['qty_in'];
  				$ArrHist[$val]['qty_booking_awal'] 	= $restWhDetail[0]->qty_booking;
  				$ArrHist[$val]['qty_booking_akhir'] = $restWhDetail[0]->qty_booking;
  				$ArrHist[$val]['qty_rusak_awal'] 	= $restWhDetail[0]->qty_rusak;
  				$ArrHist[$val]['qty_rusak_akhir'] 	= $restWhDetail[0]->qty_rusak + $valx['qty_rusak'];
  				$ArrHist[$val]['no_trans'] 			= $no_po;
  				$ArrHist[$val]['jumlah_mat'] 		= $valx['qty_in'] + $valx['qty_rusak'];
  				$ArrHist[$val]['update_by'] 		= $session['id_user'];
  				$ArrHist[$val]['update_date'] 		= date('Y-m-d H:i:s');
          $ArrHist[$val]['incoming_awal_packing'] 	= $restWhDetail[0]->incoming_packing;
  				$ArrHist[$val]['incoming_akhir_packing'] 	= $restWhDetail[0]->incoming_packing + $valx['qty_in_pack'];
          $ArrHist[$val]['qty_stock_awal_packing'] 	= $restWhDetail[0]->qty_stock_packing;
  				$ArrHist[$val]['qty_stock_akhir_packing'] 	= $restWhDetail[0]->qty_stock_packing + $valx['qty_in_pack'];
  				$ArrHist[$val]['qty_booking_awal_packing'] 	= $restWhDetail[0]->qty_booking_packing;
  				$ArrHist[$val]['qty_booking_akhir_packing'] = $restWhDetail[0]->qty_booking_packing;
  				$ArrHist[$val]['qty_rusak_awal_packing'] 	= $restWhDetail[0]->qty_rusak_packing;
  				$ArrHist[$val]['qty_rusak_akhir_packing'] 	= $restWhDetail[0]->qty_rusak + $valx['qty_rusak_pack'];
          $ArrHist[$val]['jumlah_mat_packing'] 		= $valx['qty_in_pack'] + $valx['qty_rusak_pack'];

          $ArrHist[$val]['tanda_terima'] 		= $valx['tanda_terima'];
  			}

  			$ArrInsertH = array(
  				'no_ipp' => $no_po,
  				'jumlah_mat' => $SumMat + $SumRisk,
          'jumlah_mat_packing' => $SumMatPack + $SumRiskPack,
  				'kd_gudang_dari' => 'PURCHASE',
  				'kd_gudang_ke' => $gudang,
  				// 'note' => $note,
          // 'tanda_terima' => $tanda_terima,
  				'created_by' => $session['id_user'],
  				'created_date' => date('Y-m-d H:i:s')
  			);

  			$ArrHeader = array(
  				'sts_process' => 'Y',
  			);

  			$ArrHeader2 = array(
  				'sts_ajuan' => 'CLS',
  			);


  			// print_r($ArrUpdate);
  			// print_r($ArrHist);
  			// print_r($ArrInsertH);
  			// exit;
  			$this->db->trans_start();
  				$this->db->update_batch('warehouse_stock', $ArrDeatil, 'id');
  				$this->db->update_batch('tran_material_purchase_detail', $ArrUpdate, 'id');

  				$this->db->insert_batch('warehouse_history', $ArrHist);
  				$this->db->insert('warehouse_adjustment', $ArrInsertH);

  				$this->db->where('no_po', $no_po);
  				$this->db->update('tran_material_purchase_header', $ArrHeader);

  				$qCheck = "SELECT * FROM tran_material_purchase_detail WHERE no_po='".$no_po."' AND qty_in < qty ";
  				$NumChk = $this->db->query($qCheck)->num_rows();
  				if($NumChk < 1){
  					$this->db->where('no_po', $no_po);
  					$this->db->update('tran_material_purchase_header', $ArrHeader2);
  				}
  			$this->db->trans_complete();
  		}


  		if($this->db->trans_status() === FALSE){
  			$this->db->trans_rollback();
  			$Arr_Data	= array(
  				'pesan'		=>'Save process failed. Please try again later ...',
  				'status'	=> 0
  			);
  		}
  		else{
  			$this->db->trans_commit();
  			$Arr_Data	= array(
  				'pesan'		=>'Save process success. Thanks ...',
  				'status'	=> 1
  			);
  			history($histHlp);
  		}
  		echo json_encode($Arr_Data);
  	}

    public function detail_adjustment(){
      $no_ipp     = $this->uri->segment(3);
      $created    = str_replace('sp4si',' ',$this->uri->segment(4));
      $dated      = str_replace('sp4si',' ',$this->uri->segment(5));

      $qBQdetailHeader 	= "SELECT * FROM warehouse_history WHERE no_trans='".$no_ipp."' AND update_by='".$created."' AND update_date='".$dated."' ";
      $qBQdetailRest		= $this->db->query($qBQdetailHeader)->result_array();
      $qBQdetailNum		= $this->db->query($qBQdetailHeader)->num_rows();

      $data = array(
        'qBQdetailHeader' => $qBQdetailHeader,
        'qBQdetailRest'   => $qBQdetailRest,
        'qBQdetailNum'    => $qBQdetailNum
      );

      $this->template->set('results', $data);
      history("View index detail adjustment ".$no_ipp);
      $this->template->title('Materials Adjustment In');
      $this->template->render('detail_adjustment');
    }

    //==========================================================================================================
    //============================================ADJUSTMENT MATERIAL===========================================
    //==========================================================================================================

    public function adjustment_material(){
      $this->auth->restrict($this->viewPermission);
      $session  = $this->session->userdata('app_session');
      $this->template->page_icon('fa fa-users');
	  $deleted = '0';
		$warehouse = $this->warehouse_material_model->get_data_array('warehouse');
		$material = $this->warehouse_material_model->get_data_array('ms_inventory_category3','deleted',$deleted);
		$data = [
			'warehouse' => $warehouse,
			'material' => $material,
		];
	  $this->template->set('results', $data);
      $this->template->title('Adjustment');
      $this->template->render('adjustment_material');
    }

    public function data_side_adjustment(){
  		$this->warehouse_material_model->get_json_adjustment();
  	}

    public function add_adjustment(){
      if($this->input->post()){
        $data 			  = $this->input->post();
    		$session      = $this->session->userdata('app_session');
        $kd_gudang		= $data['kd_gudang'];
        $material	    = $data['material'];
        $adjustment		= $data['adjustment'];
        $qty			    = $data['qty'];
        $stock_awal	  = $data['stock_awal'];
        $stock_akhir	= $data['stock_akhir'];
        $reason	      = strtolower($data['reason']);
        $unit_	      = $data['unit'];
        $IMP          = explode('_', $unit_);
        $ajust_by     = $IMP[1];
        $unit         = $IMP[0];

        $Ym           = date('ym');
        $srcMtr			  = "SELECT MAX(kd_adjustment) as maxP FROM warehouse_material_adjustment WHERE kd_adjustment LIKE 'AM".$Ym."%' ";
        $numrowMtr		= $this->db->query($srcMtr)->num_rows();
        $resultMtr		= $this->db->query($srcMtr)->result_array();
        $angkaUrut2		= $resultMtr[0]['maxP'];
        $urutan2		  = (int)substr($angkaUrut2, 6, 6);
        $urutan2++;
        $urut2			  = sprintf('%06s',$urutan2);
        $kd_adjustment	= "AM".$Ym.$urut2;

        $ArrHeader = array(
          'kd_adjustment'   => $kd_adjustment,
          'kd_gudang'       => $kd_gudang,
          'material'        => $material,
          'adjustment'      => $adjustment,
          'qty'             => $qty,
          'stock_awal'      => $stock_awal,
          'stock_akhir'     => $stock_akhir,
          'reason'          => $reason,
          'unit'            => $unit,
          'ajust_by'        => $ajust_by,
          'created_by'	    => $session['id_user'],
          'created_date'	  => date('Y-m-d H:i:s')
        );

        // print_r($ArrHeader); exit;

        $ArrHist	  = array();
        $ArrUpdate3	= array();

        if($ajust_by == 'packing'){
          $packing  = $stock_akhir;
          $unit     = $stock_akhir * get_name('ms_material', 'konversi', 'code_material', $material);

          $qpacking  = $qty;
          $qunit     = $qty * get_name('ms_material', 'konversi', 'code_material', $material);

          $stock_akhir_unit     = $unit;
          $qty_unit             = $qunit;
          $stock_akhir_packing  = $packing;
          $qty_packing          = $qpacking;
        }
        if($ajust_by == 'unit'){
          $packing  = $stock_akhir / get_name('ms_material', 'konversi', 'code_material', $material);
          $unit     = $stock_akhir;

          $qpacking  = $qty / get_name('ms_material', 'konversi', 'code_material', $material);
          $qunit     = $qty;

          $stock_akhir_unit     = $unit;
          $qty_unit             = $qunit;
          $stock_akhir_packing  = $packing;
          $qty_packing          = $qpacking;
        }
        $ArrUpdate3['qty_stock_packing']  = $packing;
        $ArrUpdate3['qty_stock']          = $unit;
        $ArrUpdate3['incoming_packing']   = $qty_packing;
        $ArrUpdate3['incoming']           = $qty_unit;
        $ArrUpdate3['update_by'] 	        = $session['id_user'];
				$ArrUpdate3['update_date'] 	      = date('Y-m-d H:i:s');

        //history
        $sqlWhDetail	= "	SELECT
                            b.*
                          FROM
                            warehouse_stock b
                          WHERE
                            b.id_material = '".$material."' AND b.kd_gudang = '".$kd_gudang."'
                          LIMIT 1";
        $restWhDetail	= $this->db->query($sqlWhDetail)->result();


        $ArrHist['id_material'] 		= $restWhDetail[0]->id_material;
        $ArrHist['idmaterial'] 		  = $restWhDetail[0]->idmaterial;
        $ArrHist['nm_material'] 		= $restWhDetail[0]->nm_material;
        $ArrHist['id_category'] 		= $restWhDetail[0]->id_category;
        $ArrHist['nm_category'] 		= $restWhDetail[0]->nm_category;
        $ArrHist['kd_gudang_dari'] 	= "ADJUSTMENT";
        $ArrHist['kd_gudang_ke'] 		= $restWhDetail[0]->kd_gudang;
        $ArrHist['incoming_awal'] 	= $restWhDetail[0]->incoming;
        $ArrHist['incoming_akhir'] 	= $restWhDetail[0]->incoming + $qty_unit;
        $ArrHist['qty_stock_awal'] 	= $restWhDetail[0]->qty_stock;
        $ArrHist['qty_stock_akhir'] 	= ($stock_akhir_unit <> 0)?$stock_akhir_unit:$restWhDetail[0]->qty_stock;
        $ArrHist['qty_booking_awal'] 	= $restWhDetail[0]->qty_booking;
        $ArrHist['qty_booking_akhir'] = $restWhDetail[0]->qty_booking;
        $ArrHist['qty_rusak_awal'] 	  = $restWhDetail[0]->qty_rusak;
        $ArrHist['qty_rusak_akhir'] 	= $restWhDetail[0]->qty_rusak;
        $ArrHist['no_trans'] 			    = $kd_adjustment;
        $ArrHist['jumlah_mat'] 		    = $qty_unit;
        $ArrHist['update_by'] 		    = $session['id_user'];
        $ArrHist['update_date'] 		  = date('Y-m-d H:i:s');
        $ArrHist['incoming_awal_packing'] 	  = $restWhDetail[0]->incoming_packing;
        $ArrHist['incoming_akhir_packing'] 	  = $restWhDetail[0]->incoming_packing + $qty_packing;
        $ArrHist['qty_stock_awal_packing'] 	  = $restWhDetail[0]->qty_stock_packing;
        $ArrHist['qty_stock_akhir_packing'] 	= ($stock_akhir_packing <> 0)?$stock_akhir_packing:$restWhDetail[0]->qty_stock_packing;
        $ArrHist['qty_booking_awal_packing'] 	= $restWhDetail[0]->qty_booking_packing;
        $ArrHist['qty_booking_akhir_packing'] = $restWhDetail[0]->qty_booking_packing;
        $ArrHist['qty_rusak_awal_packing'] 	  = $restWhDetail[0]->qty_rusak_packing;
        $ArrHist['qty_rusak_akhir_packing'] 	= $restWhDetail[0]->qty_rusak;
        $ArrHist['jumlah_mat_packing'] 		    = $qty_packing;

        // print_r($ArrHeader);
        // print_r($ArrUpdate3);
        // print_r($ArrHist);
        // exit;

        $this->db->trans_start();
            $this->db->insert('warehouse_material_adjustment', $ArrHeader);

            $this->db->where('id_material', $material);
            $this->db->where('kd_gudang', $kd_gudang);
            $this->db->update('warehouse_stock', $ArrUpdate3);

            $this->db->insert('warehouse_history', $ArrHist);
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE){
          $this->db->trans_rollback();
          $Arr_Data	= array(
            'pesan'		=>'Save gagal disimpan ...',
            'status'	=> 0
          );
        }
        else{
          $this->db->trans_commit();
          $Arr_Data	= array(
            'pesan'		=>'Save berhasil disimpan. Thanks ...',
            'status'	=> 1
          );
          history("Insert adjustment material ".$kd_adjustment);
        }
        echo json_encode($Arr_Data);
      }
      else{
		  	  $deleted = '0';
		$warehouse = $this->warehouse_material_model->get_data_array('warehouse');
		$material = $this->warehouse_material_model->get_data_array('ms_inventory_category3','deleted',$deleted);
		$data = [
			'warehouse' => $warehouse,
			'material' => $material,
		];
	  $this->template->set('results', $data);
        $this->template->title('Add Adjustment');
        $this->template->render('add_adjustment');
      }
  	}

    public function get_stock(){
      $material = $this->uri->segment(3);
      $gudang    = $this->uri->segment(4);
      $unit    = $this->uri->segment(5);

      $IMP = explode('_', $unit);
      // echo $IMP[1];

      if($gudang == 'OPC'){
        if(empty($unit)){
          $stock = get_stock_material_packing($material, $gudang);
        }
        if(!empty($unit)){
          if($IMP[1] == 'unit'){
            $stock = get_stock_material($material, $gudang);
          }
          if($IMP[1] == 'packing'){
            $stock = get_stock_material_packing($material, $gudang);
          }

        }

        $sqlSup		= "SELECT satuan_packing, unit FROM ms_material WHERE code_material ='".$material."' ";
    		$restSup	= $this->db->query($sqlSup)->result();

    		$option	= "<option value='".$restSup[0]->satuan_packing."_packing'>".strtoupper($restSup[0]->satuan_packing)." (Packing)</option>";
        $option	.= "<option value='".$restSup[0]->unit."_unit'>".strtoupper($restSup[0]->unit)." (Unit)</option>";

        $tanda = "packing";
      }

      if($gudang != 'OPC'){
        $stock = get_stock_material($material, $gudang);

        $sqlSup		= "SELECT unit FROM ms_material WHERE code_material ='".$material."' ";
    		$restSup	= $this->db->query($sqlSup)->result();

        $option	= "<option value='".$restSup[0]->unit."_unit'>".strtoupper($restSup[0]->unit)." (Unit)</option>";

        $tanda = "unit";
      }

  		 echo json_encode(array(
  				'stock'			=> floatval($stock),
          'option'		=> $option,
          'tanda'			=> $tanda
  		 ));
  	}

}

?>
