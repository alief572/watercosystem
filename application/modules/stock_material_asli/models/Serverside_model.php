<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Arwant Json
 * @copyright Copyright (c) 2021, Arwant Json
 */

class Serverside_model extends BF_Model{
    
    public function getDataJSON(){
		
		$requestData	= $_REQUEST;
		$fetch			= $this->queryDataJSON(
            $requestData['kategori'],
			$requestData['search']['value'],
			$requestData['order'][0]['column'],
			$requestData['order'][0]['dir'],
			$requestData['start'],
			$requestData['length']
		);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];
		$totalAset		= $fetch['totalAset'];

		$data	= array();
		$urut1  = 1;
        $urut2  = 0;
		$sumx	= 0;
		foreach($query->result_array() as $row)
		{
			$total_data     = $totalData;
            $start_dari     = $requestData['start'];
            $asc_desc       = $requestData['order'][0]['dir'];
            if($asc_desc == 'asc')
            {
                $nomor = $urut1 + $start_dari;
            }
            if($asc_desc == 'desc')
            {
                $nomor = ($total_data - $start_dari) - $urut2;
            }

            $SUP = "";
            //supp;ier
            $sup  = $this->db->get_where('child_inven_suplier', array('id_category3' => $row['id_category3']))->result();	
			foreach($sup AS $sp){  
                $kodesup = $sp->id_suplier;
                $sup2  = $this->db->get_where('master_supplier', array('id_suplier' => $kodesup))->result();
                foreach($sup2 AS $sp2){
                    $SUP .= strtoupper($sp2->name_suplier).",";
                }
            }

			$nestedData 	= array();
			$nestedData[]	= "<div align='center'>".$nomor."</div>";
			$nestedData[]	= "<div align='center'>".strtoupper(strtolower($row['nama_category1']))."</div>";
			$nestedData[]	= "<div align='left'>".strtoupper(strtolower($row['id_category3']))."</div>";
			$nestedData[]	= "<div align='left'>".strtoupper(strtolower($row['nama_category2'].'-'.$row['nama'].'-'.$row['hardness'].'-'.$row['nilai_dimensi'].'-'.$row['maker']))."</div>";
			$nestedData[]	= "<div align='left'>".$row['nm_bentuk']."</div>";
			$nestedData[]	= "<div align='left'>".$SUP."</div>";
			$nestedData[]	= "<div align='right'>".number_format($row['weight'],2)."</div>";
			$nestedData[]	= "<div align='center'>
                                <a class='btn btn-warning btn-sm' href='".base_url('/stock_material/detail/'.$record->id_category3)."' title='Detail' data-no_inquiry='".$record->no_inquiry."'><i class='fa fa-info-circle'></i></a>
                                </div>";
			$data[] = $nestedData;
            $urut1++;
            $urut2++;
		}

		$json_data = array(
			"draw"            	=> intval( $requestData['draw'] ),
			"recordsTotal"    	=> intval( $totalData ),
			"recordsFiltered" 	=> intval( $totalFiltered ),
			"data"            	=> $data,
			"recordsAset"		=> $totalAset,
		);

		echo json_encode($json_data);
	}

	public function queryDataJSON($kategori, $like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL){

        $where_kategori = "";
		if(!empty($kategori)){
			$where_kategori = " AND d.id_category2 = '".$kategori."' ";
		}

		$sql = "SELECT
                    a.*, 
                    b.nama AS nama_type, 
                    c.nama AS nama_category1,
                    f.nm_bentuk AS nm_bentuk, 
                    d.nama AS nama_category2, 
                    e.nilai_dimensi AS nilai_dimensi,
                    (SELECT SUM(totalweight) FROM stock_material WHERE id_category3 = a.id_category3) AS weight
                FROM
                    ms_inventory_category3 a
                    JOIN ms_inventory_type b ON b.id_type=a.id_type
                    JOIN ms_inventory_category1 c ON c.id_category1 =a.id_category1
                    JOIN ms_inventory_category2 d ON d.id_category2 =a.id_category2
                    JOIN child_inven_dimensi e ON e.id_category3 =a.id_category3
                    JOIN ms_bentuk f ON f.id_bentuk =a.id_bentuk
                WHERE 1=1
                    AND a.deleted = '0'
                    ".$where_kategori."
                    AND (
                        b.nama LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR c.nama LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR a.id_category3 LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR a.nama LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR a.hardness LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR e.nilai_dimensi LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR a.maker LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR f.nm_bentuk LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR d.nama LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR e.nilai_dimensi LIKE '%".$this->db->escape_like_str($like_value)."%'
                    )
                ";
		// echo $sql; exit;

		$Query_Sum	= "SELECT
                            SUM(( SELECT SUM( totalweight ) FROM stock_material WHERE id_category3 = a.id_category3 )) AS weight 
                        FROM
                            ms_inventory_category3 a
                            JOIN ms_inventory_type b ON b.id_type=a.id_type
                            JOIN ms_inventory_category1 c ON c.id_category1 =a.id_category1
                            JOIN ms_inventory_category2 d ON d.id_category2 =a.id_category2
                            JOIN child_inven_dimensi e ON e.id_category3 =a.id_category3
                            JOIN ms_bentuk f ON f.id_bentuk =a.id_bentuk
                        WHERE 1=1
                            AND a.deleted = '0'
                            ".$where_kategori."
                            AND (
                                b.nama LIKE '%".$this->db->escape_like_str($like_value)."%'
                                OR c.nama LIKE '%".$this->db->escape_like_str($like_value)."%'
                                OR a.id_category3 LIKE '%".$this->db->escape_like_str($like_value)."%'
                                OR a.nama LIKE '%".$this->db->escape_like_str($like_value)."%'
                                OR a.hardness LIKE '%".$this->db->escape_like_str($like_value)."%'
                                OR e.nilai_dimensi LIKE '%".$this->db->escape_like_str($like_value)."%'
                                OR a.maker LIKE '%".$this->db->escape_like_str($like_value)."%'
                                OR f.nm_bentuk LIKE '%".$this->db->escape_like_str($like_value)."%'
                                OR d.nama LIKE '%".$this->db->escape_like_str($like_value)."%'
                                OR e.nilai_dimensi LIKE '%".$this->db->escape_like_str($like_value)."%'
                            )
	                    ";
		$Total_Aset	= 0;
		$Hasil_SUM		   = $this->db->query($Query_Sum)->result_array();
		if($Hasil_SUM){
			$Total_Aset		= $Hasil_SUM[0]['weight'];
		}
		$data['totalData'] 	= $this->db->query($sql)->num_rows();
		$data['totalAset'] 	= $Total_Aset;
		$data['totalFiltered'] = $this->db->query($sql)->num_rows();
		$columns_order_by = array(
			0 => 'id',
			1 => 'nama',
			2 => 'nama',
			3 => 'nm_bentuk',
			4 => 'nama',
			5 => 'nilai_dimensi'

		);

		$sql .= " ORDER BY d.nama,  ".$columns_order_by[$column_order]." ".$column_dir." ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

    public function getDataJSON_GRW(){
		
		$requestData	= $_REQUEST;
		$fetch			= $this->queryDataJSON_GRW(
            $requestData['gudang'],
            $requestData['search']['value'],
			$requestData['order'][0]['column'],
			$requestData['order'][0]['dir'],
			$requestData['start'],
			$requestData['length']
		);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];
		$totalAset		= $fetch['totalAset'];

		$data	= array();
		$urut1  = 1;
        $urut2  = 0;
		$sumx	= 0;
		foreach($query->result_array() as $row)
		{
			$total_data     = $totalData;
            $start_dari     = $requestData['start'];
            $asc_desc       = $requestData['order'][0]['dir'];
            if($asc_desc == 'asc')
            {
                $nomor = $urut1 + $start_dari;
            }
            if($asc_desc == 'desc')
            {
                $nomor = ($total_data - $start_dari) - $urut2;
            }

            $satuan = (empty($record->length))?"Coil":"Sheet";

			$nestedData 	= array();
			$nestedData[]	= "<div align='center'>".$nomor."</div>";
			$nestedData[]	= "<div align='left'>".strtoupper(strtolower($row['id_category3']))."</div>";
			$nestedData[]	= "<div align='left'>".strtoupper(strtolower($row['lotno']." / ".$row['lot_slitting']))."</div>";
			$nestedData[]	= "<div align='left'>".strtoupper(strtolower($row['nama_material']." / ".$row['thickness']))."</div>";
			$nestedData[]	= "<div align='right'>".number_format($row['width'],2)."</div>";
			$nestedData[]	= "<div align='right'>".number_format($row['length'],2)."</div>";
			$nestedData[]	= "<div align='right'>".number_format($row['thickness'],2)."</div>";
			$nestedData[]	= "<div align='right'>".number_format($row['qty'],2)." ".$satuan."</div>";
			$nestedData[]	= "<div align='right'>".number_format($row['weight'],2)."</div>";
			$nestedData[]	= "<div align='right'>".number_format($row['totalweight'],2)."</div>";
			$nestedData[]	= "<div align='left'>".strtoupper(strtolower($row['nama_gudang']))."</div>";
			
			$data[] = $nestedData;
            $urut1++;
            $urut2++;
		}

		$json_data = array(
			"draw"            	=> intval( $requestData['draw'] ),
			"recordsTotal"    	=> intval( $totalData ),
			"recordsFiltered" 	=> intval( $totalFiltered ),
			"data"            	=> $data,
			"recordsAset"		=> $totalAset,
		);

		echo json_encode($json_data);
	}

	public function queryDataJSON_GRW($gudang, $like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL){

        $where_kategori = "";
		if(!empty($gudang)){
			$where_kategori = " AND a.id_gudang = '".$gudang."' ";
		}

		$sql = "SELECT
                    a.*, 
                    b.nama_gudang as nama_gudang
                FROM
                    stock_material a
                    JOIN ms_gudang b ON b.id_gudang =a.id_gudang
                    JOIN ms_inventory_category3 c ON a.id_category3 =c.id_category3
                    JOIN ms_inventory_type d ON c.id_type=d.id_type
                    JOIN ms_inventory_category1 e ON c.id_category1 =e.id_category1
                    JOIN ms_inventory_category2 f ON c.id_category2 =f.id_category2
                WHERE 1=1
                    ".$where_kategori." AND a.aktif='Y'
                    AND (
                        b.nama_gudang LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR a.lot_slitting LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR a.lotno LIKE '%".$this->db->escape_like_str($like_value)."%'
                        OR a.nama_material LIKE '%".$this->db->escape_like_str($like_value)."%'
						OR a.id_category3 LIKE '%".$this->db->escape_like_str($like_value)."%'
						OR a.thickness LIKE '%".$this->db->escape_like_str($like_value)."%'
                    )
                ";
		// echo $sql; exit;

		$Query_Sum	= "SELECT
                            SUM(a.totalweight) AS weight
                        FROM
                            stock_material a
                            JOIN ms_gudang b ON b.id_gudang =a.id_gudang
                            JOIN ms_inventory_category3 c ON a.id_category3 =c.id_category3
                            JOIN ms_inventory_type d ON c.id_type=d.id_type
                            JOIN ms_inventory_category1 e ON c.id_category1 =e.id_category1
                            JOIN ms_inventory_category2 f ON c.id_category2 =f.id_category2
                        WHERE 1=1
                            ".$where_kategori." AND a.aktif='Y'
                            AND (
                                b.nama_gudang LIKE '%".$this->db->escape_like_str($like_value)."%'
                                OR a.lot_slitting LIKE '%".$this->db->escape_like_str($like_value)."%'
                                OR a.lotno LIKE '%".$this->db->escape_like_str($like_value)."%'
                                OR a.nama_material LIKE '%".$this->db->escape_like_str($like_value)."%'
								OR a.id_category3 LIKE '%".$this->db->escape_like_str($like_value)."%'
                            )
                        ";
		$Total_Aset	= 0;
		$Hasil_SUM		   = $this->db->query($Query_Sum)->result_array();
		if($Hasil_SUM){
			$Total_Aset		= $Hasil_SUM[0]['weight'];
		}
		$data['totalData'] 	= $this->db->query($sql)->num_rows();
		$data['totalAset'] 	= $Total_Aset;
		$data['totalFiltered'] = $this->db->query($sql)->num_rows();
		$columns_order_by = array(
			0 => 'id_stock'

		);

		$sql .= " ORDER BY d.nama,  ".$columns_order_by[$column_order]." ".$column_dir." ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

    public function getDataJSON_booking(){
		
		$requestData	= $_REQUEST;
		$fetch			= $this->queryDataJSON_booking(
            $requestData['gudang'],
            $requestData['search']['value'],
			$requestData['order'][0]['column'],
			$requestData['order'][0]['dir'],
			$requestData['start'],
			$requestData['length']
		);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];
		$totalAset		= $fetch['totalAset'];

		$data	= array();
		$urut1  = 1;
        $urut2  = 0;
		$sumx	= 0;
		foreach($query->result_array() as $row)
		{
			$total_data     = $totalData;
            $start_dari     = $requestData['start'];
            $asc_desc       = $requestData['order'][0]['dir'];
            if($asc_desc == 'asc')
            {
                $nomor = $urut1 + $start_dari;
            }
            if($asc_desc == 'desc')
            {
                $nomor = ($total_data - $start_dari) - $urut2;
            }

			$nestedData 	= array();
			$nestedData[]	= "<div align='center'>".$nomor."</div>";
			$nestedData[]	= "<div align='left'>".$row['lotno']."</div>";
			$nestedData[]	= "<div align='left'>".$row['nama_material']."</div>";
			$nestedData[]	= "<div align='right'>".$row['width']."</div>";
			$nestedData[]	= "<div align='right'>".$row['length']."</div>";
			$nestedData[]	= "<div align='right'>".$row['qty']."</div>";
			$nestedData[]	= "<div align='right'>".$row['weight']."</div>";
			$nestedData[]	= "<div align='right'>".$row['totalweight']."</div>";
			$nestedData[]	= "<div align='left'>".$row['no_surat']."</div>";
			$nestedData[]	= "<div align='left'>".strtoupper($row['name_customer'])."</div>";
			
			$data[] = $nestedData;
            $urut1++;
            $urut2++;
		}

		$json_data = array(
			"draw"            	=> intval( $requestData['draw'] ),
			"recordsTotal"    	=> intval( $totalData ),
			"recordsFiltered" 	=> intval( $totalFiltered ),
			"data"            	=> $data,
			"recordsAset"		=> $totalAset,
		);

		echo json_encode($json_data);
	}

	public function queryDataJSON_booking($gudang, $like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL){

        // $where_kategori = "";
		// if(!empty($gudang)){
		// 	$where_kategori = " AND a.id_gudang = '".$gudang."' ";
		// }

		$sql = "SELECT
                    c.width,
					a.id_dt_spkmarketing,
					c.qty,
					c.weight,
					c.totalweight,
					c.length,
					c.lotno,
					c.nama_material,
                    b.name_customer as name_customer,
					e.no_surat
                FROM
                    stock_material_customer a
                    LEFT JOIN master_customers b ON b.id_customer =a.id_customer
                    LEFT JOIN stock_material c ON a.id_stock =c.id_stock
                    LEFT JOIN dt_spkmarketing d ON a.id_dt_spkmarketing =d.id_dt_spkmarketing
                    LEFT JOIN tr_spk_marketing e ON d.id_spkmarketing =e.id_spkmarketing
                WHERE 1=1
                    
                    AND (
                        b.name_customer LIKE '%".$this->db->escape_like_str($like_value)."%'
                    )
                ";
		// echo $sql; exit;

		$Query_Sum	= "SELECT
                            SUM(a.berat) AS weight
                        FROM
							stock_material_customer a
							LEFT JOIN master_customers b ON b.id_customer =a.id_customer
							LEFT JOIN stock_material c ON a.id_stock =c.id_stock
							LEFT JOIN dt_spkmarketing d ON a.id_dt_spkmarketing =d.id_dt_spkmarketing
							LEFT JOIN tr_spk_marketing e ON d.id_spkmarketing =e.id_spkmarketing
                        WHERE 1=1
                            
                            AND (
                                b.name_customer LIKE '%".$this->db->escape_like_str($like_value)."%'
                            )
                        ";
		$Total_Aset	= 0;
		$Hasil_SUM		   = $this->db->query($Query_Sum)->result_array();
		if($Hasil_SUM){
			$Total_Aset		= $Hasil_SUM[0]['weight'];
		}
		$data['totalData'] 	= $this->db->query($sql)->num_rows();
		$data['totalAset'] 	= $Total_Aset;
		$data['totalFiltered'] = $this->db->query($sql)->num_rows();
		$columns_order_by = array(
			0 => 'a.id'

		);

		$sql .= " ORDER BY  ".$columns_order_by[$column_order]." ".$column_dir." ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

}
