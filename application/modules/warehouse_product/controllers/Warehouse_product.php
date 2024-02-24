<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Warehouse_product extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Cycletime.View';
    protected $addPermission  	= 'Cycletime.Add';
    protected $managePermission = 'Cycletime.Manage';
    protected $deletePermission = 'Cycletime.Delete';

   public function __construct()
    {
        parent::__construct();

        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Warehouse_product/warehouse_product_model'
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
      history("View index finish good product");
      $this->template->title('Product Finish Good');
      $this->template->render('stock');
    }

    public function data_side_stock(){
  		$this->warehouse_product_model->get_json_stock();
  	}

    //==========================================================================================================
    //============================================WIP=========================================================
    //==========================================================================================================

    public function wip(){
      $this->auth->restrict($this->viewPermission);
      $session  = $this->session->userdata('app_session');
      $this->template->page_icon('fa fa-users');
      history("View index product wip");
      $this->template->title('Product WIP');
      $this->template->render('wip');
    }

    public function data_side_wip(){
  		$this->warehouse_product_model->get_json_wip();
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

        $ArrHeader = array(
          'no_wip'        => $no_wip,
          'costcenter'    => 'CC2000012',
          'created_by'	  => $session['id_user'],
          'created_date'	=> date('Y-m-d H:i:s')
        );

        $ArrDetail	= array();
        foreach($detail AS $val => $valx){
          $ArrDetail[$val]['no_wip'] = $no_wip;
          $ArrDetail[$val]['material'] = $valx['material'];
          $ArrDetail[$val]['qty_material'] = $valx['qty_material'];
          $ArrDetail[$val]['unit'] = $valx['unit'];
          $ArrDetail[$val]['qty_packing'] = $valx['qty_packing'];
          $ArrDetail[$val]['unit_packing'] = $valx['unit_packing'];
          $ArrDetail[$val]['qty_aktual'] 	      = str_replace(',','',$valx['qty_aktual']);
          $ArrDetail[$val]['unit_aktual'] = $valx['unit_aktual'];
        }

        $q_update = "SELECT
                  	a.id,
                  	a.sts_wip
                  FROM
                  	produksi_planning_data a
                  	LEFT JOIN produksi_planning b ON a.no_plan = b.no_plan
                  WHERE
                  	b.costcenter = 'CC2000012'
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

        // print_r($ArrHeader);
        // print_r($ArrDetail);
        // print_r($ArrUpdate);
        //
        // exit;
        $this->db->trans_start();
          $this->db->insert('material_wip', $ArrHeader);
          $this->db->insert_batch('material_wip_detail', $ArrDetail);
          $this->db->update_batch('produksi_planning_data', $ArrUpdate, 'id');
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

      $query = "SELECT
                  a.*,
                  b.nm_material,
                  b.unit,
                  b.konversi,
                  b.satuan_packing
                FROM
                  get_material_wip a LEFT JOIN ms_material b ON a.code_material=b.code_material";
      $result = $this->db->query($query)->result_array();
      $num_r = $this->db->query($query)->num_rows();
      $d_Header = "<div class='box box-primary'>";
        	$d_Header .= "<div class='box-body'>";
          $d_Header .= "<table class='table table-bordered table-striped'>";
          $d_Header .= "<thead>";
          $d_Header .= "<tr>";
            $d_Header .= "<th class='text-center' style='vertical-align:middle;'>#</th>";
            $d_Header .= "<th class='text-center' style='vertical-align:middle;'>Material Name</th>";
            $d_Header .= "<th class='text-center' style='vertical-align:middle;'>Qty Material</th>";
            $d_Header .= "<th class='text-center' style='vertical-align:middle;'>Qty Packing</th>";
            $d_Header .= "<th class='text-center' style='vertical-align:middle;'>Actual Qty Material</th>";
            $d_Header .= "<th class='text-center' style='vertical-align:middle;'>Unit</th>";
          $d_Header .= "</tr>";
          $d_Header .= "</thead>";
          $d_Header .= "<tbody>";
          foreach ($result as $key => $value) { $key++;
            $d_Header .= "<tr>";
              $d_Header .= "<td class='text-center'>".$key."</td>";
              $d_Header .= "<td>".strtoupper($value['nm_material'])."</td>";
              $d_Header .= "<td class='text-right'>".number_format($value['weight'],2)." ".ucfirst($value['unit'])."</td>";
              $d_Header .= "<td class='text-right'>".number_format($value['weight']/$value['konversi'],2)." ".ucfirst($value['satuan_packing'])."</td>";
              $d_Header .= "<td>
                            <input type='text' name='detail[".$key."][qty_aktual]' class='form-control input-md text-right maskM'>
                            <input type='hidden' name='detail[".$key."][material]' class='form-control input-md' value='".$value['code_material']."'>
                            <input type='hidden' name='detail[".$key."][qty_material]' class='form-control input-md' value='".$value['weight']."'>
                            <input type='hidden' name='detail[".$key."][unit]' class='form-control input-md' value='".$value['unit']."'>
                            <input type='hidden' name='detail[".$key."][qty_packing]' class='form-control input-md' value='".$value['weight']/$value['konversi']."'>
                            <input type='hidden' name='detail[".$key."][unit_packing]' class='form-control input-md' value='".$value['satuan_packing']."'>
                            <input type='hidden' name='detail[".$key."][unit_aktual]' class='form-control input-md' value='".$value['unit']."'>
                            </td>";
              $d_Header .= "<td class='text-center'>".ucfirst($value['unit'])."</td>";
            $d_Header .= "</tr>";
          }
          if($num_r < 1){
            $d_Header .= "<tr>";
            $d_Header .= "<td colspan='6'>Data not found ...</td>";
            $d_Header .= "/tr>";
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
    //============================================DELIVERY======================================================
    //==========================================================================================================

    public function delivery(){
      $this->auth->restrict($this->viewPermission);
      $session  = $this->session->userdata('app_session');
      $this->template->page_icon('fa fa-users');
      history("View index delivery product");
      $this->template->title('Product Delivery');
      $this->template->render('delivery');
    }

    public function data_side_delivery(){
  		$this->warehouse_product_model->get_json_delivery();
  	}

    public function add_delivery(){
      if($this->input->post()){
        $data 			  = $this->input->post();
    		$session      = $this->session->userdata('app_session');
    		$detail			  = $data['detail'];
        $no_so			  = $data['delivery'];

        $Ym           = date('y');
        $srcMtr			  = "SELECT MAX(no_delivery) as maxP FROM delivery_header WHERE no_delivery LIKE 'DY".$Ym."%' ";
        $numrowMtr		= $this->db->query($srcMtr)->num_rows();
        $resultMtr		= $this->db->query($srcMtr)->result_array();
        $angkaUrut2		= $resultMtr[0]['maxP'];
        $urutan2		  = (int)substr($angkaUrut2, 5, 4);
        $urutan2++;
        $urut2			  = sprintf('%04s',$urutan2);
        $no_delivery	= "DY".$Ym.$urut2;

        $ArrHeader = array(
          'no_delivery'   => $no_delivery,
          'no_so'         => $no_so,
          'code_cust'     => get_name_field('sales_order_header', 'code_cust', 'no_so', $no_so),
          'delivery_date' => get_name_field('sales_order_header', 'delivery_date', 'no_so', $no_so),
          'delivery_real' => get_name_field('sales_order_header', 'delivery_date', 'no_so', $no_so),
          'shipping'      => get_name_field('sales_order_header', 'shipping', 'no_so', $no_so),
          'created_by'	  => $session['id_user'],
          'created_date'	=> date('Y-m-d H:i:s')
        );

        $ArrDetail	= array();
        $ArrUpdate	= array();
        $ArrUpdate2	= array();
        $ArrHist2	= array();
        $ArrUpdate3	= array();
        $ArrHist3	= array();
        $ArrUpdatePro	= array();
        $ArrHist	= array();
        foreach($detail AS $val => $valx){
          if($valx['qty_delivery'] <> ''){
            $ArrDetail[$val]['no_delivery']   = $no_delivery;
            $ArrDetail[$val]['id_so_detail']  = $valx['id_so_detail'];
            $ArrDetail[$val]['product']       = $valx['product'];
            $ArrDetail[$val]['qty_order']     = $valx['qty_order'];
            $ArrDetail[$val]['qty_delivery']  = $valx['qty_delivery'];
            $ArrDetail[$val]['qty_kurang']    = $valx['qty_kurang'];

            $restLast = $this->db->query("SELECT qty_delivery FROM sales_order_detail WHERE id='".$valx['id_so_detail']."' LIMIT 1")->result();

            $ArrUpdate[$val]['id']            = $valx['id_so_detail'];
            $ArrUpdate[$val]['qty_delivery']  = $valx['qty_delivery'] + $restLast[0]->qty_delivery;


            $sql_last_pro	   = "SELECT * FROM warehouse_product WHERE id_product = '".$valx['product']."' AND costcenter = 'CC2000001' AND category = 'order' LIMIT 1";
            $rest_last_pro	 = $this->db->query($sql_last_pro)->result();
            $qty_stock       = (!empty($rest_last_pro[0]->qty_stock))?$rest_last_pro[0]->qty_stock:0;

            //insert batch
            $ArrUpdate3[$val]['id_product'] = $valx['product'];
            // $ArrUpdate3[$val]['costcenter'] = 'CC2000001';
            $ArrUpdate3[$val]['qty_stock']  = $qty_stock - $valx['qty_delivery'];
            $ArrUpdate3[$val]['update_by'] 	     = $session['id_user'];
    				$ArrUpdate3[$val]['update_date'] 	   = date('Y-m-d H:i:s');

            $ArrHist3[$val]['category'] 		   = 'order';
    				$ArrHist3[$val]['id_product'] 		 = $valx['product'];
            $ArrHist3[$val]['qty_stock_awal']  = $qty_stock;
    				$ArrHist3[$val]['qty_stock_akhir'] = $qty_stock - $valx['qty_delivery'];
            $ArrHist3[$val]['no_trans'] 		   = $no_delivery;
            $ArrHist3[$val]['update_by'] 	     = $session['id_user'];
    				$ArrHist3[$val]['update_date'] 	   = date('Y-m-d H:i:s');


            $sql_last_pro2	   = "SELECT * FROM warehouse_product WHERE id_product = '".$valx['product']."' AND category = 'product' LIMIT 1";
            $rest_last_pro2	 = $this->db->query($sql_last_pro2)->result();
            $qty_stock2       = (!empty($rest_last_pro2[0]->qty_stock))?$rest_last_pro2[0]->qty_stock:0;
            $qty_order2       = (!empty($rest_last_pro2[0]->qty_order))?$rest_last_pro2[0]->qty_order:0;

            $ArrUpdate2[$val]['id_product'] = $valx['product'];
            $ArrUpdate2[$val]['qty_stock']  = $qty_stock2 - $valx['qty_delivery'];
            $ArrUpdate2[$val]['qty_order']  = $qty_order2 - $valx['qty_delivery'];

            $ArrHist2[$val]['category'] 		   = 'product';
    				$ArrHist2[$val]['id_product'] 		 = $valx['product'];
    				$ArrHist2[$val]['qty_order_awal']  = $qty_order2;
    				$ArrHist2[$val]['qty_order_akhir'] = $qty_order2 - $valx['qty_delivery'];
            $ArrHist2[$val]['qty_stock_awal']  = $qty_stock2;
    				$ArrHist2[$val]['qty_stock_akhir'] = $qty_stock2 - $valx['qty_delivery'];
            $ArrHist2[$val]['no_trans'] 		   = $no_delivery;
            $ArrHist2[$val]['update_by'] 	     = $session['id_user'];
    				$ArrHist2[$val]['update_date'] 	   = date('Y-m-d H:i:s');

            //mengurangi material
            $sql_material = "SELECT a.id_product, b.code_material, b.weight FROM bom_header a LEFT JOIN bom_detail b ON a.no_bom=b.no_bom WHERE a.id_product= '".$valx['product']."'";
            $rest_mat = $this->db->query($sql_material)->result_array();
            foreach($rest_mat AS $val2 => $valx2){
              $sqlWhDetail	   = "SELECT b.* FROM warehouse_stock b WHERE b.id_material = '".$valx2['code_material']."' AND b.kd_gudang = 'PRO'";
      				$restWhDetail	   = $this->db->query($sqlWhDetail)->result();

              $ArrUpdatePro[$val2]['id_material']       = $valx2['code_material'];
      				$ArrUpdatePro[$val2]['kd_gudang'] 	      = 'PRO';
              $ArrUpdatePro[$val2]['outgoing'] 	        = $valx2['weight'] * $valx['qty_delivery'];
      				$ArrUpdatePro[$val2]['qty_stock'] 	      = $restWhDetail[0]->qty_stock - ($valx2['weight'] * $valx['qty_delivery']);
      				$ArrUpdatePro[$val2]['update_by'] 	      = $session['id_user'];
      				$ArrUpdatePro[$val2]['update_date']       = date('Y-m-d H:i:s');

              //insert history
      				$ArrHist[$val2]['id_material'] 		  = $restWhDetail[0]->id_material;
      				$ArrHist[$val2]['idmaterial'] 		    = $restWhDetail[0]->idmaterial;
      				$ArrHist[$val2]['nm_material'] 		  = $restWhDetail[0]->nm_material;
      				$ArrHist[$val2]['kd_gudang_dari'] 	  = "PRO";
      				$ArrHist[$val2]['kd_gudang_ke'] 		  = "DFY";
              $ArrHist[$val2]['outgoing_awal'] 	  = $restWhDetail[0]->outgoing;
      				$ArrHist[$val2]['outgoing_akhir'] 	  = $restWhDetail[0]->outgoing + ($valx2['weight'] * $valx['qty_delivery']);
      				$ArrHist[$val2]['qty_stock_awal'] 	  = $restWhDetail[0]->qty_stock;
      				$ArrHist[$val2]['qty_stock_akhir'] 	= $restWhDetail[0]->qty_stock - ($valx2['weight'] * $valx['qty_delivery']);

      				$ArrHist[$val2]['no_trans'] 			    = $no_delivery;
      				$ArrHist[$val2]['jumlah_mat'] 		    = $qty_aktual;
      				$ArrHist[$val2]['update_by'] 		    = $session['id_user'];
      				$ArrHist[$val2]['update_date'] 		  = date('Y-m-d H:i:s');
              $ArrHist[$val2]['jumlah_mat_packing'] 		    = $valx2['weight'] * $valx['qty_delivery'];
            }
          }
        }



        // print_r($ArrHeader);
        // print_r($ArrUpdate3);
        // print_r($ArrHist3);
        // print_r($ArrHist);
        // print_r($ArrUpdatePro);
        // exit;

        $this->db->trans_start();
          if(!empty($ArrDetail)){
            $this->db->insert('delivery_header', $ArrHeader);
            $this->db->insert_batch('delivery_detail', $ArrDetail);
            $this->db->update_batch('sales_order_detail', $ArrUpdate, 'id');

            $this->db->where('category', 'product');
            $this->db->update_batch('warehouse_product', $ArrUpdate2, 'id_product');
            $this->db->insert_batch('warehouse_product_history', $ArrHist2);


            $this->db->where('category', 'order');
            $this->db->where('costcenter', 'CC2000001');
            $this->db->update_batch('warehouse_product', $ArrUpdate3, 'id_product');

            $this->db->insert_batch('warehouse_product_history', $ArrHist3);

            $this->db->where('kd_gudang','PRO');
            $this->db->update_batch('warehouse_stock', $ArrUpdatePro, 'id_material');

            $this->db->insert_batch('warehouse_history', $ArrHist);
          }
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
          history("Insert Delivery Product ".$no_delivery);
        }
        echo json_encode($Arr_Data);
      }
      else{
        $this->template->title('Add Delivery');
        $this->template->render('add_delivery');
      }
  	}

    public function get_delivery(){
      $no_so = $this->uri->segment(3);
      $query = "SELECT
                  a.*,
                  b.nama
                FROM
                  sales_order_detail a LEFT JOIN ms_inventory_category2 b ON a.product=b.id_category2
                WHERE a.no_so='".$no_so."' ";
      $result = $this->db->query($query)->result_array();
      $num_r = $this->db->query($query)->num_rows();
      $d_Header = "<div class='box box-primary'>";
        	$d_Header .= "<div class='box-body'>";
          $d_Header .= "<table class='table table-bordered table-striped'>";
          $d_Header .= "<thead>";
          $d_Header .= "<tr>";
            $d_Header .= "<th class='text-center' style='vertical-align:middle;' width='5%'>#</th>";
            $d_Header .= "<th class='text-center' style='vertical-align:middle;' width='35%'>Product Name</th>";
            $d_Header .= "<th class='text-center' style='vertical-align:middle;' width='15%'>Qty Propose</th>";
            $d_Header .= "<th class='text-center' style='vertical-align:middle;' width='15%'>Available Finish Good</th>";
            $d_Header .= "<th class='text-center' style='vertical-align:middle;' width='15%'>Qty Delivery</th>";
            $d_Header .= "<th class='text-center' style='vertical-align:middle;' width='15%'>Qty Balance</th>";
          $d_Header .= "</tr>";
          $d_Header .= "</thead>";
          $d_Header .= "<tbody>";
          foreach ($result as $key => $value) { $key++;
            $qty_order = $value['qty_order'] - $value['qty_delivery'];
            $d_Header .= "<tr>";
              $d_Header .= "<td class='text-center'>".$key."</td>";
              $d_Header .= "<td>".strtoupper($value['nama'])."</td>";
              $d_Header .= "<td class='text-center'>".$qty_order."</td>";
              $d_Header .= "<td class='text-right'><input type='text' name='detail[".$key."][qty_available]' id='qty_stock_".$key."' data-no='".$key."' class='form-control input-md text-center maskM' value='".get_stock($value['product'])."' readonly data-decimal='.' data-thousand='' data-precision='0' data-allow-zero=''></td>";
              $d_Header .= "<td class='text-right'><input type='text' name='detail[".$key."][qty_delivery]' data-no='".$key."' class='form-control input-md text-center maskM qty_delivery' data-decimal='.' data-thousand='' data-precision='0' data-allow-zero=''></td>";
              $d_Header .= "<td>
                            <input type='hidden' name='detail[".$key."][id_so_detail]' class='form-control input-md' value='".$value['id']."'>
                            <input type='hidden' name='detail[".$key."][product]' class='form-control input-md' value='".$value['product']."'>
                            <input type='hidden' name='detail[".$key."][qty_order]' id='qty_order_".$key."' class='form-control input-md' value='".$qty_order."'>
                            <input type='text' name='detail[".$key."][qty_kurang]' id='qty_kurang_".$key."' class='form-control input-md text-center' readonly value='".$qty_order."'>
                            </td>";
            $d_Header .= "</tr>";
          }
          if($num_r < 1){
            $d_Header .= "<tr>";
            $d_Header .= "<td colspan='5'>Data not found ...</td>";
            $d_Header .= "/tr>";
          }
          $d_Header .= "</tbody>";
          $d_Header .= "</table>";
          $d_Header .= "</div>";
      $d_Header .= "</div>";


  		 echo json_encode(array(
  				'header'			=> $d_Header,
          'num' => $num_r,
          'plan_delivery' => strtoupper(get_name_field('sales_order_header', 'shipping', 'no_so', $no_so))
  		 ));
  	}

    public function detail_delivery(){
      // $this->auth->restrict($this->viewPermission);
      $no_delivery 	= $this->input->post('no_delivery');

      $detail = $this->db->query("SELECT * FROM delivery_detail WHERE no_delivery='".$no_delivery."'")->result_array();
      $header = $this->db->query("SELECT * FROM delivery_header WHERE no_delivery='".$no_delivery."'")->result();

      // print_r($header);
      $data = [
        'detail' => $detail,
        'header'=> $header
      ];
      $this->template->set('results', $data);
      $this->template->render('detail_delivery', $data);
    }

    //==========================================================================================================
    //============================================ADJUSTMENT====================================================
    //==========================================================================================================

    public function adjustment(){
      $this->auth->restrict($this->viewPermission);
      $session  = $this->session->userdata('app_session');
      $this->template->page_icon('fa fa-users');
      history("View index adjustment");
      $this->template->title('Adjustment');
      $this->template->render('adjustment');
    }

    public function data_side_adjustment(){
  		$this->warehouse_product_model->get_json_adjustment();
  	}

    public function add_adjustment(){
      if($this->input->post()){
        $data 			  = $this->input->post();
    		$session      = $this->session->userdata('app_session');
    		$detail			  = $data['daycode'];
        $costcenter		= $data['costcenter'];
        $id_product	  = $data['id_product'];
        $adjustment		= $data['adjustment'];
        $qty			    = $data['qty'];
        $stock_awal	  = $data['stock_awal'];
        $stock_akhir	= $data['stock_akhir'];
        $reason	      = strtolower($data['reason']);

        $Ym           = date('ym');
        $srcMtr			  = "SELECT MAX(kd_adjustment) as maxP FROM warehouse_product_adjustment WHERE kd_adjustment LIKE 'AD".$Ym."%' ";
        $numrowMtr		= $this->db->query($srcMtr)->num_rows();
        $resultMtr		= $this->db->query($srcMtr)->result_array();
        $angkaUrut2		= $resultMtr[0]['maxP'];
        $urutan2		  = (int)substr($angkaUrut2, 6, 6);
        $urutan2++;
        $urut2			  = sprintf('%06s',$urutan2);
        $kd_adjustment	= "AD".$Ym.$urut2;

        $ArrHeader = array(
          'kd_adjustment'   => $kd_adjustment,
          'id_product'      => $id_product,
          'costcenter'      => $costcenter,
          'adjustment'      => $adjustment,
          'qty'             => $qty,
          'stock_awal'      => $stock_awal,
          'stock_akhir'     => $stock_akhir,
          'reason'          => $reason,
          'created_by'	    => $session['id_user'],
          'created_date'	  => date('Y-m-d H:i:s')
        );

        $ArrDetail	= array();
        $ArrHist3	  = array();
        $ArrUpdate3	= array();
        if(!empty($detail)){
          foreach($detail AS $val => $valx){
              $ArrDetail[$val]['kd_adjustment'] = $kd_adjustment;
              $ArrDetail[$val]['id_product']    = $id_product;
              $ArrDetail[$val]['costcenter']    = $costcenter;
              $ArrDetail[$val]['product_ke']    = $val;
              $ArrDetail[$val]['daycode']       = $valx['daycode'];
              $val++;
          }
        }

        $ArrUpdate3['qty_stock']     = $stock_akhir;
        $ArrUpdate3['update_by'] 	   = $session['id_user'];
				$ArrUpdate3['update_date'] 	 = date('Y-m-d H:i:s');

        $ArrHist3['category'] 		   = 'order';
				$ArrHist3['id_product'] 		 = $id_product;
        $ArrHist3['costcenter'] 		 = $costcenter;
        $ArrHist3['qty_stock_awal']  = $stock_awal;
				$ArrHist3['qty_stock_akhir'] = $stock_akhir;
        $ArrHist3['no_trans'] 		   = $kd_adjustment;
        $ArrHist3['update_by'] 	     = $session['id_user'];
				$ArrHist3['update_date'] 	   = date('Y-m-d H:i:s');

        // print_r($ArrHeader);
        // print_r($ArrUpdate3);
        // print_r($ArrHist3);
        // print_r($ArrDetail);
        // exit;

        $this->db->trans_start();
            $this->db->insert('warehouse_product_adjustment', $ArrHeader);
            if(!empty($ArrDetail)){
              $this->db->insert_batch('warehouse_product_adjustment_daycode', $ArrDetail);
            }

            $this->db->where('category', 'order');
            $this->db->where('costcenter', $costcenter);
            $this->db->where('id_product', $id_product);
            $this->db->update('warehouse_product', $ArrUpdate3);

            $this->db->insert('warehouse_product_history', $ArrHist3);
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
          history("Insert adjustment product ".$kd_adjustment);
        }
        echo json_encode($Arr_Data);
      }
      else{
        $this->template->title('Add Adjustment');
        $this->template->render('add_adjustment');
      }
  	}

    public function get_stock(){
      $costcenter = $this->uri->segment(3);
      $product    = $this->uri->segment(4);

      $stock = get_stock_wip($product, $costcenter);
  		 echo json_encode(array(
  				'stock'			=> $stock
  		 ));
  	}

    public function get_daycode(){
      $jumlah = $this->uri->segment(3);
      $costcenter = $this->uri->segment(4);

      $daycode_ = "SELECT * FROM filter_daycode GROUP BY code ORDER BY code ASC";
      $rest_day = $this->db->query($daycode_)->result_array();
      $dtListArray = array();
      foreach($rest_day AS $val => $valx){
        $dtListArray[$val] = $valx['code'];
      }
      $dtImplode	= "('".implode("','", $dtListArray)."')";

      if($costcenter == 'CC2000012'){
        $list_daycode = $this->db->query("SELECT * FROM daycode WHERE code NOT IN ".$dtImplode." ORDER BY code ASC ")->result_array();
      }

      if($costcenter <> 'CC2000012'){
        $list_daycode = $this->db->query("SELECT * FROM daycode WHERE code IN ".$dtImplode." ORDER BY code ASC ")->result_array();
      }

      $label = ($jumlah <> '0' AND $jumlah <> '')?'':'';
      $dHeader = "";
      for($a=1; $a<=$jumlah; $a++){
        $dHeader .= "<div class='form-group row'>";
          $dHeader .= "<div class='col-md-1'>";
          $dHeader .= "<label for='customer'>Product ".$a." <span class='text-red'>*</span></label>";
          $dHeader .= "</div>";
          $dHeader .= "<div class='col-md-4'>";
          $dHeader .= "<select name='daycode[$a][daycode]' id='daycode_$a'  class='form-control input-md chosen-select'>";
          $dHeader .= "<option value='0'>Select Daycode</option>";
          foreach($list_daycode AS $val => $valx){
            $dHeader .= "<option value='".$valx['code']."'>".$valx['code']."</option>";
          }
          $dHeader .= "<select>";
          $dHeader .= "</div>";

          $dHeader .= "<div class='col-md-7'>";
          $dHeader .= "</div>";
        $dHeader .= "</div>";
      }
  		 echo json_encode(array(
  				'label'			=> $label,
          'dHeader'			=> $dHeader
  		 ));
  	}

    public function get_costcenter_adjust(){
      $product = $this->uri->segment(3);

  		$sqlSup		= "SELECT b.costcenter FROM cycletime_header a LEFT JOIN cycletime_detail_header b ON a.id_time=b.id_time WHERE a.id_product ='".$product."' ";
  		$restSup	= $this->db->query($sqlSup)->result_array();

  		$option	= "<option value='0'>Select An Costcenter</option>";
  		foreach($restSup AS $val => $valx){
  			$option .= "<option value='".$valx['costcenter']."'>".strtoupper(get_name_field('ms_costcenter', 'nama_costcenter', 'id_costcenter', $valx['costcenter']))."</option>";
  		}

  		$ArrJson	= array(
  			'option' => $option
  		);
  		echo json_encode($ArrJson);
  	}

}

?>
