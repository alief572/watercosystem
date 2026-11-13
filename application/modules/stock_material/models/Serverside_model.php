<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Arwant Json
 * @copyright Copyright (c) 2021, Arwant Json
 */

class Serverside_model extends BF_Model
{

	public function getDataJSON()
	{

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
		foreach ($query->result_array() as $row) {
			$total_data     = $totalData;
			$start_dari     = $requestData['start'];
			$asc_desc       = $requestData['order'][0]['dir'];
			if ($asc_desc == 'asc') {
				$nomor = $urut1 + $start_dari;
			}
			if ($asc_desc == 'desc') {
				$nomor = ($total_data - $start_dari) - $urut2;
			}

			$SUP = "";
			//supp;ier
			$sup  = $this->db->get_where('child_inven_suplier', array('id_category3' => $row['id_category3']))->result();
			foreach ($sup as $sp) {
				$kodesup = $sp->id_suplier;
				$sup2  = $this->db->get_where('master_supplier', array('id_suplier' => $kodesup))->result();
				foreach ($sup2 as $sp2) {
					$SUP .= strtoupper($sp2->name_suplier) . ",";
				}
			}

			$nestedData 	= array();
			$nestedData[]	= "<div align='center'>" . $nomor . "</div>";
			$nestedData[]	= "<div align='center'>" . strtoupper(strtolower($row['nama_category1'])) . "</div>";
			$nestedData[]	= "<div align='left'>" . strtoupper(strtolower($row['id_category3'])) . "</div>";
			$nestedData[]	= "<div align='left'>" . strtoupper(strtolower($row['nama_category3'])) . "</div>";
			$nestedData[]	= "<div align='left'>" . $row['nm_bentuk'] . "</div>";
			$nestedData[]	= "<div align='left'>" . $SUP . "</div>";
			$nestedData[]	= "<div align='right'>" . number_format($row['weight'], 2) . "</div>";
			$nestedData[]	= "<div align='center'>
                                <a class='btn btn-warning btn-sm' href='" . base_url('/stock_material/detail/' . $row['id_category3']) . "' title='Detail' data-no_inquiry='" . $row->no_inquiry . "'><i class='fa fa-info-circle'></i></a>
                                </div>";
			$data[] = $nestedData;
			$urut1++;
			$urut2++;
		}

		$json_data = array(
			"draw"            	=> intval($requestData['draw']),
			"recordsTotal"    	=> intval($totalData),
			"recordsFiltered" 	=> intval($totalFiltered),
			"data"            	=> $data,
			"recordsAset"		=> $totalAset,
		);

		echo json_encode($json_data);
	}

	public function queryDataJSON($kategori, $like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{

		$where_kategori = "";
		if (!empty($kategori)) {
			$where_kategori = " AND d.id_category2 = '" . $kategori . "' ";
		}

		$sql = "SELECT
                    a.*, 
                    b.nama AS nama_type, 
                    c.nama AS nama_category1,
                    f.nm_bentuk AS nm_bentuk, 
                    d.nama AS nama_category2, 
                    e.nilai_dimensi AS nilai_dimensi,
					g.nama AS nama_category3,
                    (SELECT SUM(qty*sisa_spk) FROM stock_material WHERE id_category3 = a.id_category3) AS weight
                FROM
                    ms_inventory_category3 a
                    JOIN ms_inventory_type b ON b.id_type=a.id_type
                    JOIN ms_inventory_category1 c ON c.id_category1 =a.id_category1
                    JOIN ms_inventory_category2 d ON d.id_category2 =a.id_category2
                    JOIN child_inven_dimensi e ON e.id_category3 =a.id_category3
                    JOIN ms_bentuk f ON f.id_bentuk =a.id_bentuk
					JOIN ms_inventory_category3 g ON g.id_category3 =a.id_category3
                WHERE 1=1
                    AND a.deleted = '0'
                    " . $where_kategori . "
                    AND (
                        b.nama LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                        OR c.nama LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                        OR a.id_category3 LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                        OR a.nama LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                        OR a.hardness LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                        OR e.nilai_dimensi LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                        OR a.maker LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                        OR f.nm_bentuk LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                        OR d.nama LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                        OR e.nilai_dimensi LIKE '%" . $this->db->escape_like_str($like_value) . "%'
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
                            " . $where_kategori . "
                            AND (
                                b.nama LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                                OR c.nama LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                                OR a.id_category3 LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                                OR a.nama LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                                OR a.hardness LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                                OR e.nilai_dimensi LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                                OR a.maker LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                                OR f.nm_bentuk LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                                OR d.nama LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                                OR e.nilai_dimensi LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                            )
	                    ";
		$Total_Aset	= 0;
		$Hasil_SUM		   = $this->db->query($Query_Sum)->result_array();
		if ($Hasil_SUM) {
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

		$sql .= " ORDER BY d.nama,  " . $columns_order_by[$column_order] . " " . $column_dir . " ";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	public function getDataJSON_GRW()
	{

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
		foreach ($query->result_array() as $row) {
			$total_data     = $totalData;
			$start_dari     = $requestData['start'];
			$asc_desc       = $requestData['order'][0]['dir'];
			if ($asc_desc == 'asc') {
				$nomor = $urut1 + $start_dari;
			}
			if ($asc_desc == 'desc') {
				$nomor = ($total_data - $start_dari) - $urut2;
			}

			$satuan = (empty($record->length)) ? "Coil" : "Sheet";

			$nestedData 	= array();
			$nestedData[]	= "<div align='center'>" . $nomor . "</div>";
			$nestedData[]	= "<div align='left'>" . strtoupper(strtolower($row['id_category3'])) . "</div>";
			$nestedData[]	= "<div align='left'>" . $row['kode_barang'] . "</div>";
			$nestedData[]	= "<div align='left'>" . strtoupper(strtolower($row['nama_material'])) . "</div>";
			$nestedData[]	= "<div align='right'>" . number_format($row['qty'], 2) . "</div>";
			$nestedData[]	= "<div align='right'>" . number_format($row['qty_book'], 2) . "</div>";
			$nestedData[]	= "<div align='right'>" . number_format($row['qty_free'], 2) . "</div>";
			$nestedData[]	= "<div align='left'>" . ucfirst(strtolower($row['keterangan'])) . "</div>";
			$nestedData[]	= "<div align='left'>" . strtoupper(strtolower($row['nama_gudang'])) . "</div>";

			$data[] = $nestedData;
			$urut1++;
			$urut2++;
		}

		$json_data = array(
			"draw"            	=> intval($requestData['draw']),
			"recordsTotal"    	=> intval($totalData),
			"recordsFiltered" 	=> intval($totalFiltered),
			"data"            	=> $data,
			"recordsAset"		=> $totalAset,
		);

		echo json_encode($json_data);
	}

	public function queryDataJSON_GRW($gudang, $like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{

		$where_kategori = "";
		if (!empty($gudang)) {
			$where_kategori = " AND a.id_gudang = '" . $gudang . "' ";
		}

		$sql = "SELECT
                    a.*, 
                    b.nama_gudang as nama_gudang,
					c. nama as nama_material,
					c. kode_barang
                FROM
                    stock_material a
                    JOIN ms_gudang b ON b.id_gudang =a.id_gudang
                    JOIN ms_inventory_category3 c ON a.id_category3 =c.id_category3
                    JOIN ms_inventory_type d ON c.id_type=d.id_type
                    JOIN ms_inventory_category1 e ON c.id_category1 =e.id_category1
                    JOIN ms_inventory_category2 f ON c.id_category2 =f.id_category2
                WHERE 1=1
                    " . $where_kategori . " AND a.aktif='Y'
                    AND (
                        b.nama_gudang LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                        OR c.nama LIKE '%" . $this->db->escape_like_str($like_value) . "%'
						OR a.id_category3 LIKE '%" . $this->db->escape_like_str($like_value) . "%'
						OR c.kode_barang LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                    )
                ";
		// echo $sql; exit;

		$Query_Sum	= "SELECT
                            SUM(a.qty) AS weight
                        FROM
                            stock_material a
                            JOIN ms_gudang b ON b.id_gudang =a.id_gudang
                            JOIN ms_inventory_category3 c ON a.id_category3 =c.id_category3
                            JOIN ms_inventory_type d ON c.id_type=d.id_type
                            JOIN ms_inventory_category1 e ON c.id_category1 =e.id_category1
                            JOIN ms_inventory_category2 f ON c.id_category2 =f.id_category2
                        WHERE 1=1
                            " . $where_kategori . " AND a.aktif='Y'
                            AND (
                                b.nama_gudang LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                                OR c.nama LIKE '%" . $this->db->escape_like_str($like_value) . "%'
								OR a.id_category3 LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                            )
                        ";
		$Total_Aset	= 0;
		$Hasil_SUM		   = $this->db->query($Query_Sum)->result_array();
		if ($Hasil_SUM) {
			$Total_Aset		= $Hasil_SUM[0]['weight'];
		}
		$data['totalData'] 	= $this->db->query($sql)->num_rows();
		$data['totalAset'] 	= $Total_Aset;
		$data['totalFiltered'] = $this->db->query($sql)->num_rows();
		$columns_order_by = array(
			0 => 'id_stock'

		);

		$sql .= " ORDER BY d.nama,  " . $columns_order_by[$column_order] . " " . $column_dir . " ";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	public function getDataJSON_booking()
	{

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
		foreach ($query->result_array() as $row) {
			$total_data     = $totalData;
			$start_dari     = $requestData['start'];
			$asc_desc       = $requestData['order'][0]['dir'];
			if ($asc_desc == 'asc') {
				$nomor = $urut1 + $start_dari;
			}
			if ($asc_desc == 'desc') {
				$nomor = ($total_data - $start_dari) - $urut2;
			}

			$nestedData 	= array();
			$nestedData[]	= "<div align='center'>" . $nomor . "</div>";
			$nestedData[]	= "<div align='left'>" . $row['lotno'] . "</div>";
			$nestedData[]	= "<div align='left'>" . $row['nama'] . "</div>";
			$nestedData[]	= "<div align='right'>" . $row['width'] . "</div>";
			$nestedData[]	= "<div align='right'>" . $row['length'] . "</div>";
			$nestedData[]	= "<div align='right'>" . $row['qty'] . "</div>";
			$nestedData[]	= "<div align='right'>" . $row['weight'] . "</div>";
			$nestedData[]	= "<div align='right'>" . $row['totalweight'] . "</div>";
			$nestedData[]	= "<div align='left'>" . $row['no_surat'] . "</div>";
			$nestedData[]	= "<div align='left'>" . strtoupper($row['name_customer']) . "</div>";

			$data[] = $nestedData;
			$urut1++;
			$urut2++;
		}

		$json_data = array(
			"draw"            	=> intval($requestData['draw']),
			"recordsTotal"    	=> intval($totalData),
			"recordsFiltered" 	=> intval($totalFiltered),
			"data"            	=> $data,
			"recordsAset"		=> $totalAset,
		);

		echo json_encode($json_data);
	}

	public function queryDataJSON_booking($gudang, $like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{

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
					e.no_surat,
					f.nama
                FROM
                    stock_material_customer a
                    LEFT JOIN master_customers b ON b.id_customer =a.id_customer
                    LEFT JOIN stock_material c ON a.id_stock =c.id_stock
                    LEFT JOIN dt_spkmarketing d ON a.id_dt_spkmarketing =d.id_dt_spkmarketing
					LEFT JOIN ms_inventory_category3 f ON d.id_material =f.id_category3
                    LEFT JOIN tr_spk_marketing e ON d.id_spkmarketing =e.id_spkmarketing
                WHERE 1=1
                    
                    AND (
                        b.name_customer LIKE '%" . $this->db->escape_like_str($like_value) . "%'
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
                                b.name_customer LIKE '%" . $this->db->escape_like_str($like_value) . "%'
                            )
                        ";
		$Total_Aset	= 0;
		$Hasil_SUM		   = $this->db->query($Query_Sum)->result_array();
		if ($Hasil_SUM) {
			$Total_Aset		= $Hasil_SUM[0]['weight'];
		}
		$data['totalData'] 	= $this->db->query($sql)->num_rows();
		$data['totalAset'] 	= $Total_Aset;
		$data['totalFiltered'] = $this->db->query($sql)->num_rows();
		$columns_order_by = array(
			0 => 'a.id'

		);

		$sql .= " ORDER BY  " . $columns_order_by[$column_order] . " " . $column_dir . " ";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}


	public function getDataJSON_GRW2()
	{

		$requestData	= $_REQUEST;
		$fetch			= $this->queryDataJSON_GRW2(
			$requestData['tanggal'],
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
		foreach ($query->result_array() as $row) {
			$total_data     = $totalData;
			$start_dari     = $requestData['start'];
			$asc_desc       = $requestData['order'][0]['dir'];
			if ($asc_desc == 'asc') {
				$nomor = $urut1 + $start_dari;
			}
			if ($asc_desc == 'desc') {
				$nomor = ($total_data - $start_dari) - $urut2;
			}

			$satuan = (empty($record->length)) ? "Coil" : "Sheet";
			$tgl = date_create($row['tgl']);
			$date = date_format($tgl, 'd/m/Y');
			$nestedData 	= array();
			$nestedData[]	= "<div align='center'>" . $nomor . "</div>";
			$nestedData[]	= "<div align='left'>" . strtoupper(strtolower($row['id_category3'])) . "</div>";
			$nestedData[]	= "<div align='left'>" . $row['kode_barang'] . "</div>";
			$nestedData[]	= "<div align='left'>" . $row['kode_mas'] . "</div>";
			$nestedData[]	= "<div align='left'>" . strtoupper(strtolower($row['nama_material'])) . "</div>";
			$nestedData[]	= "<div align='right'>" . number_format($row['qty'], 2) . "</div>";
			$nestedData[]	= "<div align='right'>" . number_format($row['qty_book'], 2) . "</div>";
			$nestedData[]	= "<div align='right'>" . number_format($row['qty_free'], 2) . "</div>";
			$nestedData[]	= "<div align='left'>" . ucfirst(strtolower($row['keterangan'])) . "</div>";
			$nestedData[]	= "<div align='left'>" . strtoupper(strtolower($row['nama_gudang'])) . "</div>";
			$nestedData[]	= "<div align='left'>" . $date . "</div>";

			$data[] = $nestedData;
			$urut1++;
			$urut2++;
		}

		$json_data = array(
			"draw"            	=> intval($requestData['draw']),
			"recordsTotal"    	=> intval($totalData),
			"recordsFiltered" 	=> intval($totalFiltered),
			"data"            	=> $data,
			"recordsAset"		=> $totalAset,
		);

		echo json_encode($json_data);
	}

	public function queryDataJSON_GRW2($tanggal, $gudang, $like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{

		// Tanggal kosong -> snapshot terbaru, bukan semua snapshot.
		if (empty($tanggal)) {
			$max = $this->db->query("SELECT DATE(MAX(tgl)) AS tgl FROM stock_material_backup WHERE aktif='Y' AND id_gudang = ?", [(string) $gudang])->row();
			$tanggal = $max ? $max->tgl : null;
		}
		if (empty($tanggal)) {
			$tanggal = date('Y-m-d');
		}

		$like  = '%' . $this->db->escape_like_str($like_value) . '%';
		$where = " WHERE a.aktif='Y' AND a.tgl >= ? AND a.tgl < DATE_ADD(?, INTERVAL 1 DAY) ";
		$binds = [$tanggal, $tanggal];
		if (!empty($gudang)) {
			$where .= " AND a.id_gudang = ? ";
			$binds[] = $gudang;
		}
		$where .= " AND (b.nama_gudang LIKE ? OR c.nama LIKE ? OR a.id_category3 LIKE ?) ";
		array_push($binds, $like, $like, $like);

		$from = " FROM stock_material_backup a
                    JOIN ms_gudang b ON b.id_gudang = a.id_gudang
                    JOIN ms_inventory_category3 c ON a.id_category3 = c.id_category3
                    JOIN ms_inventory_type d ON c.id_type = d.id_type ";

		// Satu query untuk total baris + total qty (sebelumnya 3 query penuh).
		$agg = $this->db->query("SELECT COUNT(*) AS jml, SUM(a.qty) AS weight " . $from . $where, $binds)->row();
		$data['totalData']     = (int) $agg->jml;
		$data['totalAset']     = $agg->weight ?: 0;
		$data['totalFiltered'] = (int) $agg->jml;

		$columns_order_by = array(
			0 => 'a.id_stock'
		);
		$order_col = $columns_order_by[$column_order] ?? 'a.id_stock';
		$order_dir = (strtolower($column_dir) === 'desc') ? 'DESC' : 'ASC';

		$sql = "SELECT
                    a.*,
                    b.nama_gudang as nama_gudang,
                    c.nama as nama_material,
                    c.kode_barang,
                    c.kode_mas "
			. $from . $where
			. " ORDER BY d.nama, " . $order_col . " " . $order_dir
			. " LIMIT ?, ?";
		$binds[] = (int) $limit_start;
		$binds[] = (int) $limit_length;

		$data['query'] = $this->db->query($sql, $binds);
		return $data;
	}



	public function getDataJSON_GRW_harga()
	{
		// Validasi lewat DomainException; error dikembalikan sebagai JSON, bukan halaman 500.
		$requestData = $_REQUEST;
		$draw = filter_var($requestData['draw'] ?? 0, FILTER_VALIDATE_INT);
		$reply = array('draw' => $draw !== false && $draw >= 0 ? $draw : 0, 'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => array(), 'recordsAset' => 0, 'grand_total_nilai' => 0);
		$debug = $this->db->db_debug;
		$this->db->db_debug = false;
		try {
			$fetch = $this->queryDataJSON_GRW_harga($requestData);

			$data = array();
			$nomor = $fetch['start'];
			foreach ($fetch['rows'] as $row) {
				$nomor++;
				$date = date('d/m/Y', strtotime($row['tgl']));
				$data[] = array(
					"<div align='center'>" . $nomor . "</div>",
					"<div align='left'>" . html_escape(strtoupper($row['id_category3'])) . "</div>",
					"<div align='left'>" . html_escape($row['kode_barang']) . "</div>",
					"<div align='left'>" . html_escape($row['kode_mas']) . "</div>",
					"<div align='left'>" . html_escape(strtoupper($row['nama_material'])) . "</div>",
					"<div align='right'>" . number_format((float) $row['qty'], 2) . "</div>",
					"<div align='right'>" . number_format((float) $row['qty_book'], 2) . "</div>",
					"<div align='right'>" . number_format((float) $row['qty_free'], 2) . "</div>",
					"<div align='left'>" . html_escape(ucfirst(strtolower((string) $row['keterangan']))) . "</div>",
					"<div align='left'>" . html_escape(strtoupper($row['nama_gudang'])) . "</div>",
					"<div align='left'>" . $date . "</div>",
					"<div align='right'>" . number_format((float) $row['nilai_costbook'], 2) . "</div>",
					"<div align='right'>" . number_format((float) $row['qty'] * (float) $row['nilai_costbook']) . "</div>",
				);
			}

			$reply = array(
				"draw"              => $fetch['draw'],
				"recordsTotal"      => $fetch['totalData'],
				"recordsFiltered"   => $fetch['totalFiltered'],
				"data"              => $data,
				"recordsAset"       => $fetch['totalAset'],
				// Nilai seluruh hasil filter (bukan hanya halaman yang tampil).
				'grand_total_nilai' => $fetch['grandTotal'],
			);
		} catch (Throwable $e) {
			log_message('error', 'Nilai Inventory: ' . $e->getMessage());
			$reply['error'] = $e instanceof DomainException ? $e->getMessage() : 'Data nilai inventory tidak dapat dimuat.';
		} finally {
			$this->db->db_debug = $debug;
		}

		echo json_encode($reply);
	}

	public function queryDataJSON_GRW_harga(array $request)
	{
		$page = array();
		foreach (array('draw' => 0, 'start' => 0, 'length' => 10) as $key => $default) {
			$page[$key] = filter_var($request[$key] ?? $default, FILTER_VALIDATE_INT);
			if ($page[$key] === false || ($key === 'length' ? ($page[$key] < 1 && $page[$key] !== -1) : $page[$key] < 0)) {
				throw new DomainException('Parameter ' . $key . ' tidak valid.');
			}
		}
		$page['length'] = $page['length'] === -1 ? 100 : min(100, $page['length']);

		// Tanggal stok: Y-m-d, kosong = hari ini. Dipakai sebagai range [tgl, tgl+1 hari) agar index kolom tgl terpakai.
		$tanggal = $request['tanggal'] ?? '';
		if ($tanggal === '' || $tanggal === null) {
			$tanggal = date('Y-m-d');
		}
		$dt = is_string($tanggal) ? DateTime::createFromFormat('!Y-m-d', $tanggal) : false;
		if (!$dt || $dt->format('Y-m-d') !== $tanggal) {
			throw new DomainException('Tanggal tidak valid.');
		}
		$from = $dt->format('Y-m-d');
		$to = $dt->modify('+1 day')->format('Y-m-d');

		$search = $request['search'] ?? array();
		if (!is_array($search)) throw new DomainException('Pencarian tidak valid.');
		$search = $search['value'] ?? '';
		$size = is_string($search) ? preg_match_all('/./us', $search) : false;
		if ($size === false || $size > 255) throw new DomainException('Pencarian maksimal 255 karakter.');

		// STRAIGHT_JOIN: mulai dari stock_material_backup (range tgl via idx_tgl_aktif). Tanpa ini optimizer
		// memulai dari tabel kecil d/e/f dan memindai 1,8 juta baris (~60 detik vs ~0,7 detik).
		$joins = "FROM stock_material_backup a
			STRAIGHT_JOIN ms_gudang b ON b.id_gudang = a.id_gudang
			STRAIGHT_JOIN ms_inventory_category3 c ON a.id_category3 = c.id_category3
			STRAIGHT_JOIN ms_inventory_type d ON c.id_type = d.id_type
			STRAIGHT_JOIN ms_inventory_category1 e ON c.id_category1 = e.id_category1
			STRAIGHT_JOIN ms_inventory_category2 f ON c.id_category2 = f.id_category2
			STRAIGHT_JOIN ms_costbook_backup g ON a.id_category3 = g.id_category3";
		$where = "WHERE a.aktif = 'Y' AND a.tgl >= ? AND a.tgl < ? AND g.tgl >= ? AND g.tgl < ?";
		$binds = array($from, $to, $from, $to);

		$searchSql = '';
		$searchBinds = array();
		if ($search !== '') {
			$needle = '%' . str_replace(array('!', '%', '_'), array('!!', '!%', '!_'), $search) . '%';
			$parts = array();
			foreach (array('b.nama_gudang', 'c.nama', 'a.id_category3', 'c.maker') as $field) {
				$parts[] = $field . " LIKE ? ESCAPE '!'";
				$searchBinds[] = $needle;
			}
			$searchSql = ' AND (' . implode(' OR ', $parts) . ')';
		}

		$total = $this->hargaQuery("SELECT COUNT(*) AS n $joins $where", $binds)->row();
		$sum = $this->hargaQuery("SELECT COUNT(*) AS n, SUM(a.qty) AS qty, SUM(a.qty * g.nilai_costbook) AS nilai $joins $where" . $searchSql, array_merge($binds, $searchBinds))->row();

		// Kolom 0 (#) tidak dapat diurutkan; urut tetap = pengelompokan lama (tipe, id_stock) + tie-breaker.
		$rows = $this->hargaQuery("SELECT a.*, b.nama_gudang AS nama_gudang, c.nama AS nama_material, c.kode_barang, c.kode_mas, g.nilai_costbook, g.tgl
			$joins $where" . $searchSql . " ORDER BY d.nama, a.id_stock ASC LIMIT " . $page['length'] . " OFFSET " . $page['start'],
			array_merge($binds, $searchBinds))->result_array();

		return array(
			'draw' => $page['draw'], 'start' => $page['start'],
			'totalData' => (int) $total->n, 'totalFiltered' => (int) $sum->n,
			'totalAset' => $sum->qty === null ? 0 : (float) $sum->qty,
			'grandTotal' => $sum->nilai === null ? 0 : (float) $sum->nilai,
			'rows' => $rows,
		);
	}

	private function hargaQuery($sql, array $binds)
	{
		$query = $this->db->query($sql, $binds);
		if (!$query) throw new RuntimeException('Cannot read inventory value');
		return $query;
	}
}
