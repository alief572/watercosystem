<?php
class Penerimaan_model extends BF_Model {

	public function __construct() {
		parent::__construct(); 
	}

	public function modal_detail_invoice($id){  

		// $id    = $this->uri->segment(3);
		$getInv = $this->db->query("SELECT * FROM tr_debit_note WHERE no_pr = ?", [(string) $id])->row();
		
		$Cust = $this->db->query("SELECT a.id_customer,b.name_customer as nm_customer  FROM tr_debit_note a
											INNER JOIN master_customers b on a.id_customer=b.id_customer GROUP BY a.id_customer")->result();

		$bank1			 = $this->Jurnal_model->get_Coa_Bank_Aja('101');
		$pphpenjualan  	 = $this->Acc_model->combo_pph_penjualan(); 
		$datacoa  	     = $this->Acc_model->GetCoaCombo();
		$template  	     = $this->Acc_model->GetTemplate(); 
		
		// print_r($pphpenjualan);
		// exit;

		// $data = array(
			// 'results' => $getInv,
			// 'no_inv'  => $id,
			// 'datbank' => $bank1,
			// 'pphpenjualan'=> $pphpenjualan,
			// 'template'=> $template
			
		// );
		
		// $this->load->view('create_penerimaan', $data);
		
		$this->template->set([
		   'results' => $getInv,
			'no_inv'  => $id,
			'datbank' => $bank1,
			'pphpenjualan'=> $pphpenjualan,
			'template'=> $template,
			'customer'=>$Cust
		]);
		$this->template->render('create_penerimaan_new');
	}

	//SERVER SIDE
	public function get_data_json_inv(){
		
		$requestData	= $_REQUEST;
		$fetch			= $this->query_data_inv(
			$requestData['search']['value'],
			$requestData['order'][0]['column'],
			$requestData['order'][0]['dir'],
			$requestData['start'],
			$requestData['length']
		);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		$urut1  = 1;
        $urut2  = 0;
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
			
			$mixedStr = $row['no_ipp'];
			$searchStr = 'NP';
			$searchStr2 = 'OT';
			
			if(strpos($mixedStr,$searchStr)) {
			$class = 'print1';
			}else if(strpos($mixedStr,$searchStr2)){
			$class = 'print2';
			}else {
			$class = 'print';
			}
			
		$edit = 'edit';
			
		$jenis_invoice = $row['jenis_invoice'];
		
		if($jenis_invoice=='TR-01'){
		$jenis = 'UANG MUKA';
		}
		elseif($jenis_invoice=='TR-02'){
		$jenis = 'PROGRESS';
		}

			$nestedData 	= array(); 
			$nestedData[]	= "<div align='center'>".$nomor."</div>";
			$nestedData[]	= "<div align='left'>".$row['tgl_invoice']."</div>";
			$nestedData[]	= "<div align='left'>".$row['no_ipp']."</div>";
			$nestedData[]	= "<div align='left'>".$row['no_invoice']."</div>";
			$nestedData[]	= "<div align='left'>".$row['so_number']."</div>";
			$nestedData[]	= "<div align='left'>".$jenis."</div>";
			$nestedData[]	= "<div align='left'>".$row['nm_customer']."</div>";
			$nestedData[]	= "<div align='right'>".number_format($row['total_invoice'],2)."</div>";
					$priX	= "";
					$updX	= "";
					$ApprvX	= "";
					$Edit	= "";
					$Print	= "";
					$Hist	= "";
					$ApprvX2Edit = "";
					
					if($row['proses_print']=='1'){	
						$Terima	= "<button class='btn btn-sm btn-success terima' title='Create Penerimaan' data-inv='".$row['no_invoice']."'><i class='fa fa-list'></i></button>";
					}
			$nestedData[]	= "<div align='center'>
									".$priX."
									".$updX."
									".$viewX."
									".$ApprvX."
									".$Hist."
									".$ApprvX2Edit."
									".$Edit."
									".$Print."
									".$Jurnal."
									".$Terima."
									</div>";
			$data[] = $nestedData;
            $urut1++;
            $urut2++;
		}

		$json_data = array(
			"draw"            	=> intval( $requestData['draw'] ),
			"recordsTotal"    	=> intval( $totalData ),
			"recordsFiltered" 	=> intval( $totalFiltered ),
			"data"            	=> $data
		);

		echo json_encode($json_data);
	}

	public function query_data_inv($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL){

		$sql = "
			SELECT
				a.*
				
			FROM
				tr_invoice a
		    WHERE 1=1
                AND a.proses_print='1'
				AND (
				a.no_invoice LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.so_number LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.nm_customer LIKE '%".$this->db->escape_like_str($like_value)."%'
	        )
			
			
			GROUP BY a.nm_customer
		";
		// echo $sql; exit;

		$data['totalData'] = $this->db->query($sql)->num_rows();
		$data['totalFiltered'] = $this->db->query($sql)->num_rows(); 
		$columns_order_by = array(
			0 => 'nomor',
			1 => 'no_ipp',
			2 => 'nm_customer' 
		);

		$sql .= " ORDER BY a.created_date DESC, ".$columns_order_by[$column_order]." ".$column_dir." ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	//SERVER SIDE 
	public function get_data_json_payment(){
		
		$requestData	= $_REQUEST;
		$fetch			= $this->query_data_payment(
			$requestData['search']['value'],
			$requestData['order'][0]['column'],
			$requestData['order'][0]['dir'],
			$requestData['start'],
			$requestData['length']
		);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		$urut1  = 1;
        $urut2  = 0;
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
			$mixedStr = $row['kd_pembayaran'];
			$searchStr = 'NP';
			$searchStr2 = 'OT';
			
			if(strpos($mixedStr,$searchStr)) {
			$class = 'print1';
			}else if(strpos($mixedStr,$searchStr2)){
			$class = 'print2'; 
			}else {
			$class = 'print';
			}			
		$edit = 'edit';
			$nestedData 	= array(); 
			$nestedData[]	= "<div align='center'>".$nomor."</div>";
			$nestedData[]	= "<div align='left'>".$row['tgl_pembayaran']."</div>";
			$nestedData[]	= "<div align='left'>".$row['kd_pembayaran']."</div>";
			$nestedData[]	= "<div align='left'>".$row['nm_customer']."</div>";
			$nestedData[]	= "<div align='left'>".$row['keterangan']."</div>";
			$nestedData[]	= "<div align='left'>".$row['invoiced']."</div>";
			$nestedData[]	= "<div align='left'>".number_format($row['totalinvoiced'])."</div>";
			$nestedData[]	= "<div align='left'>".number_format($row['biaya_pph_idr'])."</div>";
			$nestedData[]	= "<div align='left'>".number_format($row['biaya_admin_idr'])."</div>";
			$nestedData[]	= "<div align='right'>".number_format($row['jumlah_pembayaran_idr'],2)."</div>";
			$priX	= "";
			$updX	= "";
			$ApprvX	= "";
			$Edit	= "";
			$Print	= "";
			$Hist	= "";
			$Buktip = "";
			$ApprvX2Edit = "";
			
			$viewX	= "<button class='btn btn-sm btn-warning detail' title='View' data-id_bq='".$row['kd_pembayaran']."'><i class='fa fa-eye'></i></button>";
			
			// print_r($row['status_jurnal']);
			// exit;
			
			$Jurnal	="";
			
			if($row['status_jurnal']==0){
				$Jurnal	= "<button class='btn btn-sm btn-primary jurnal'  title='Approval Jurnal Penerimaan' data-inv='".$row['kd_pembayaran']."'><i class='fa fa-check'></i></button>"; 
				
			}
			
					
			if($row['biaya_pph_idr']>0 && $row['bukti_potong']==''){
			$Buktip=" <button class='btn btn-sm btn-success buktip'  title='Penerimaan Bukti Potong' data-kd_pembayaran='".$row['kd_pembayaran']."'><i class='fa fa-cloud-upload'></i></button>";
			}
			

			//$Print	= "&nbsp;<a href='".base_url('print_invoice/'.$row['no_invoice'])."' target='_blank' class='btn btn-sm btn-info print' onClick='print()' title='Print Invoice' ><i class='fa fa-print'></i></a>";
			// <button class='btn btn-sm btn-primary' id='detailBQ'  title='Detail BQ' data-id_bq='".$row['id_bq']."'><i class='fa fa-eye'></i></button>
			$nestedData[]	= "<div align='center'>
									".$priX."
									".$updX."
									".$viewX."
									".$ApprvX."
									".$Hist."
									".$ApprvX2Edit."
									".$Edit."
									".$Print."
									".$Jurnal."
									".$Jurnal1."
									".$Terima."
									".$Buktip."
									</div>";
			$data[] = $nestedData;
            $urut1++;
            $urut2++;
		}

		$json_data = array(
			"draw"            	=> intval( $requestData['draw'] ),
			"recordsTotal"    	=> intval( $totalData ),
			"recordsFiltered" 	=> intval( $totalFiltered ),
			"data"            	=> $data
		);

		echo json_encode($json_data);
	}

	public function query_data_payment($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL){
		$sql = "
			SELECT a.*, c.invoiced, c.totalinvoiced FROM tr_debit_note_payment a			
			
			left outer join (
				SELECT kd_pembayaran,
				GROUP_CONCAT(no_invoice SEPARATOR ',') as invoiced,
				sum(total_bayar_idr) as totalinvoiced
				FROM tr_debit_note_payment_detail
				GROUP BY kd_pembayaran
			) c on a.kd_pembayaran=c.kd_pembayaran
		    WHERE 1=1
               	AND (
				c.invoiced LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.kd_pembayaran LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.nm_customer LIKE '%".$this->db->escape_like_str($like_value)."%' 
	        )
		";
		$data['totalData'] = $this->db->query($sql)->num_rows();
		$data['totalFiltered'] = $this->db->query($sql)->num_rows(); 
		$columns_order_by = array(
			0 => 'tgl_pembayaran',
			1 => 'kd_pembayaran',
			2 => 'nm_customer' 
		);
		$sql .= " ORDER BY a.created_on DESC, ".$columns_order_by[$column_order]." ".$column_dir." ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function generate_nopn($tgl){
      $arr_tgl = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E',6=>'F',
                       7=>'G',8=>'H',9=>'I',10=>'J',11=>'K',12=>'L'
                      );
      $bln_now = date('m',strtotime($tgl));
      $kode_bln = '';
      foreach($arr_tgl as $k=>$v){
          if($k == $bln_now){
              $kode_bln = $v;
          }
      }
      $cek ='PN-'.date('y').$kode_bln;
      /*$query_cek = $this->db->query("SELECT MAX(no_so) as max_id FROM trans_so_header
      WHERE no_so LIKE '%$cek%'")->num_rows();*/
      $this->db->select("MAX(kd_pembayaran) as max_id");
      $this->db->like('kd_pembayaran', $cek);
      $this->db->from('tr_debit_note_payment');
      $query_cek = $this->db->count_all_results();

      if ($query_cek == 0) {
        $kode = 1;
        $next_kode = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $fin ='PN-'.date('y').$kode_bln.$next_kode;
      }else {
        $query = "SELECT MAX(kd_pembayaran) as max_id
        FROM
        tr_debit_note_payment WHERE kd_pembayaran LIKE '%$cek%'";
        $q = $this->db->query($query);
        $r = $q->row();
		
		
		 $query = $this->db->query("SELECT MAX(kd_pembayaran) as max_id
        FROM
        tr_debit_note_payment WHERE kd_pembayaran LIKE '%$cek%'");
      $row = $query->row_array();
      $thn = date('T');
      $max_id = $row['max_id'];
      $max_id1 =(int) substr($max_id,-5);
      $kode = $max_id1 +1;
	  
        $next_kode = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $fin ='PN-'.date('y').$kode_bln.$next_kode;
      }
      return $fin;
    }
	
	 public function get_data($kunci,$tabel) {		 
		if($kunci !=''){
        $this->db->where($kunci);
        $query=$this->db->get($tabel);
		}
		else{
		$query=$this->db->get($tabel);	
		}
        return $query->result();
    }

    /**
     * Data serverside untuk daftar Penerimaan Debit Note. No DN dan Harga setara view_tr_debit_note_payment
     * (detail JOIN tr_debit_note ON no_pr = no_invoice), dihitung hanya untuk baris halaman.
     */
    public function get_data_pn_serverside($request){
        if (!is_array($request)) throw new DomainException('Daftar penerimaan tidak valid.');
        $page = array();
        foreach (array('draw'=>0, 'start'=>0, 'length'=>10) as $key=>$default) {
            $page[$key] = filter_var($request[$key] ?? $default, FILTER_VALIDATE_INT);
            if ($page[$key] === false || ($key === 'length' ? ($page[$key] < 1 && $page[$key] !== -1) : $page[$key] < 0)) {
                throw new DomainException('Parameter ' . $key . ' tidak valid.');
            }
        }
        $page['length'] = $page['length'] === -1 ? 100 : min(100, $page['length']);
        $search = $request['search'] ?? array();
        if (!is_array($search)) throw new DomainException('Pencarian tidak valid.');
        $search = $search['value'] ?? '';
        $size = is_string($search) ? preg_match_all('/./us', $search) : false;
        if ($size === false || $size > 255) throw new DomainException('Pencarian maksimal 255 karakter.');
        $columns = array(1=>'a.tgl_pembayaran', 2=>'a.kd_pembayaran', 3=>'a.nm_customer', 4=>'a.keterangan', 5=>'invoiced',
            6=>'totalinvoiced', 7=>'a.biaya_admin_idr', 8=>'a.jumlah_pembayaran_idr');
        $orders = $request['order'] ?? array();
        if (!is_array($orders)) throw new DomainException('Urutan tabel tidak valid.');
        $sort = array();
        foreach (array_slice($orders, 0, 6) as $order) {
            if (!is_array($order)) throw new DomainException('Urutan tabel tidak valid.');
            $column = filter_var($order['column'] ?? '', FILTER_VALIDATE_INT);
            if (!isset($columns[$column])) continue;
            if (!in_array($order['dir'] ?? '', array('asc','desc'), true)) throw new DomainException('Arah urutan tidak valid.');
            $sort[] = $columns[$column] . ' ' . strtoupper($order['dir']);
        }
        if (!$sort) $sort[] = 'a.tgl_pembayaran DESC';
        $sort[] = 'a.id DESC';
        $from = ' FROM tr_debit_note_payment a';
        $where = ''; $binds = array();
        if ($search !== '') {
            $needle = '%' . str_replace(array('!','%','_'), array('!!','!%','!_'), $search) . '%';
            $parts = array();
            foreach (array('a.kd_pembayaran', 'a.nm_customer', 'a.keterangan') as $field) {
                $parts[] = $field . " LIKE ? ESCAPE '!'";
                $binds[] = $needle;
            }
            $where = ' WHERE (' . implode(' OR ', $parts) . ')';
        }
        $sub = "(SELECT %s FROM tr_debit_note_payment_detail d JOIN tr_debit_note i ON i.no_pr = d.no_invoice WHERE d.kd_pembayaran = a.kd_pembayaran)";
        $subInvoiced = sprintf($sub, "GROUP_CONCAT(i.no_surat SEPARATOR ',')");
        $subTotal = sprintf($sub, 'SUM(d.total_bayar_idr)');
        $total = (int) $this->pnQuery('SELECT COUNT(*) AS total FROM tr_debit_note_payment')->row()->total;
        $filtered = $where === '' ? $total : (int) $this->pnQuery('SELECT COUNT(*) AS total' . $from . $where, $binds)->row()->total;
        $rows = $this->pnQuery('SELECT a.id, a.kd_pembayaran, a.tgl_pembayaran, a.nm_customer, a.keterangan, a.biaya_admin_idr, a.jumlah_pembayaran_idr, '
            . $subInvoiced . ' AS invoiced, ' . $subTotal . ' AS totalinvoiced' . $from . $where
            . ' ORDER BY ' . implode(', ', $sort) . ' LIMIT ' . $page['length'] . ' OFFSET ' . $page['start'], $binds)->result();
        return array('draw'=>$page['draw'], 'start'=>$page['start'], 'total'=>$total, 'filtered'=>$filtered, 'rows'=>$rows);
    }

    /** Data serverside modal Add Invoice (daftar Debit Note customer yang masih punya sisa tagihan). */
    public function get_data_dn_modal($idCustomer, $request){
        if (!is_array($request)) throw new DomainException('Daftar debit note tidak valid.');
        $page = array();
        foreach (array('draw'=>0, 'start'=>0, 'length'=>10) as $key=>$default) {
            $page[$key] = filter_var($request[$key] ?? $default, FILTER_VALIDATE_INT);
            if ($page[$key] === false || ($key === 'length' ? ($page[$key] < 1 && $page[$key] !== -1) : $page[$key] < 0)) {
                throw new DomainException('Parameter ' . $key . ' tidak valid.');
            }
        }
        $page['length'] = $page['length'] === -1 ? 100 : min(100, $page['length']);
        $search = $request['search'] ?? array();
        if (!is_array($search)) throw new DomainException('Pencarian tidak valid.');
        $search = $search['value'] ?? '';
        $size = is_string($search) ? preg_match_all('/./us', $search) : false;
        if ($size === false || $size > 255) throw new DomainException('Pencarian maksimal 255 karakter.');
        $columns = array(0=>'a.no_pr', 1=>'a.no_surat', 2=>'b.name_customer', 3=>'a.total_tagihan', 4=>'a.sisa_tagihan');
        $orders = $request['order'] ?? array();
        if (!is_array($orders)) throw new DomainException('Urutan tabel tidak valid.');
        $sort = array();
        foreach (array_slice($orders, 0, 6) as $order) {
            if (!is_array($order)) throw new DomainException('Urutan tabel tidak valid.');
            $column = filter_var($order['column'] ?? '', FILTER_VALIDATE_INT);
            if (!isset($columns[$column])) continue;
            if (!in_array($order['dir'] ?? '', array('asc','desc'), true)) throw new DomainException('Arah urutan tidak valid.');
            $sort[] = $columns[$column] . ' ' . strtoupper($order['dir']);
        }
        if (!$sort) $sort[] = 'a.no_pr DESC';
        $sort[] = 'a.id DESC';
        $from = ' FROM tr_debit_note a INNER JOIN master_customers b ON a.id_customer = b.id_customer';
        $where = " WHERE a.id_customer = ? AND a.sisa_tagihan > '0'";
        $baseBinds = array((string) $idCustomer);
        $searchSql = ''; $searchBinds = array();
        if ($search !== '') {
            $needle = '%' . str_replace(array('!','%','_'), array('!!','!%','!_'), $search) . '%';
            $parts = array();
            foreach (array('a.no_pr', 'a.no_surat', 'b.name_customer') as $field) {
                $parts[] = $field . " LIKE ? ESCAPE '!'";
                $searchBinds[] = $needle;
            }
            $searchSql = ' AND (' . implode(' OR ', $parts) . ')';
        }
        $total = (int) $this->pnQuery('SELECT COUNT(*) AS total' . $from . $where, $baseBinds)->row()->total;
        $filtered = $searchSql === '' ? $total : (int) $this->pnQuery('SELECT COUNT(*) AS total' . $from . $where . $searchSql, array_merge($baseBinds, $searchBinds))->row()->total;
        $rows = $this->pnQuery('SELECT a.id, a.no_pr, a.no_surat, a.total_tagihan, a.sisa_tagihan, a.status, b.name_customer AS nm_customer' . $from . $where . $searchSql
            . ' ORDER BY ' . implode(', ', $sort) . ' LIMIT ' . $page['length'] . ' OFFSET ' . $page['start'], array_merge($baseBinds, $searchBinds))->result();
        return array('draw'=>$page['draw'], 'start'=>$page['start'], 'total'=>$total, 'filtered'=>$filtered, 'rows'=>$rows);
    }

    private function pnQuery($sql, $binds = array()){
        $query = $this->db->query($sql, $binds);
        if (!$query) throw new RuntimeException('Cannot read debit note receipt list');
        return $query;
    }

    public function get_data_pn(){

        $query =  $this->db->query("SELECT a.*, c.invoiced, c.totalinvoiced FROM tr_debit_note_payment a	        
        left outer join (
            SELECT kd_pembayaran,
            GROUP_CONCAT(no_surat SEPARATOR ',') as invoiced,
            sum(total_bayar_idr) as totalinvoiced
            FROM view_tr_debit_note_payment
            GROUP BY kd_pembayaran
        ) c on a.kd_pembayaran=c.kd_pembayaran       
        ");
		
		return $query->result();
	}
	
	 public function get_data_pn_jurnal(){

        $query =  $this->db->query("SELECT a.*, c.invoiced, c.totalinvoiced FROM tr_debit_note_payment a	        
        left outer join (
            SELECT kd_pembayaran,
            GROUP_CONCAT(no_surat SEPARATOR ',') as invoiced,
            sum(total_bayar_idr) as totalinvoiced
            FROM view_tr_debit_note_payment
            GROUP BY kd_pembayaran
        ) c on a.kd_pembayaran=c.kd_pembayaran WHERE a.status_jurnal='0'   
        ");
		
		return $query->result();
	}

}
