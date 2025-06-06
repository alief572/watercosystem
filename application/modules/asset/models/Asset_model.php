<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Asset_model extends BF_Model{
	
    public function __construct()
    {
        parent::__construct();
    }
	
	public function getList($table){
		$queryList = $this->db->get($table)->result_array();
		return $queryList;
	}

	function getListTable($table='',$where=''){
		$this->db->select('a.*');
		$this->db->from($table.' a');
		if($where!=''){
		$this->db->where($where);
		}
		$this->db->order_by('a.id', 'desc');
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getWhere($table, $flied, $value){
		$queryList = $this->db->get_where($table, array($flied => $value))->result_array();
		return $queryList;
	}
	
	public function saveData($table, $dataArr){
		
		$this->db->trans_start();
			$this->db->insert($table, $dataArr);
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$Arr_Data	= array(
				'pesan'		=>'Asset gagal disimpan ...',
				'status'	=> 0
			);			
		}
		else{
			$this->db->trans_commit();
			$Arr_Data	= array(
				'pesan'		=>'Asset berhasil disimpan. Thanks ...',
				'status'	=> 1
			);
		}
		
		return $Arr_Data;
	}
	
	public function getDataJSON(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		// $Arr_Akses			= getAcccesmenu($controller);
		$requestData	= $_REQUEST;
		$fetch			= $this->queryDataJSON(
			$requestData['kdcab'],
			$requestData['tgl'],
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
		$totalSusut		= $fetch['totalSusut'];
		$totalSisa		= $fetch['totalSisa'];

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

            
	    
			$idaset  = $row['kd_asset'];
			
			$search  = $this->db->query("SELECT * FROM asset_generate WHERE kd_asset='$idaset' AND bulan=MONTH(NOW()) AND YEAR(NOW())")->row();
			
			if ($search->flag =='Y'){
			$status = 'Sudah Di Jurnal';
			}
			else {
			$status = 'Belum Di Jurnal';
			}


			$nestedData 	= array();
			$nestedData[]	= "<div align='center'>".$nomor."</div>";
			$nestedData[]	= "<div align='center'>".strtoupper(strtolower($row['kd_asset']))."</div>";
			$nestedData[]	= "<div align='left'>".strtoupper(strtolower($row['nm_asset']))."</div>";
			$nestedData[]	= "<div align='left'>".strtoupper(strtolower($row['nm_category']))."</div>";
			$nestedData[]	= "<div align='center'>".$row['depresiasi']." Tahun</div>"; 
			$nestedData[]	= number_format($row['nilai_asset']);
			$nestedData[]	= number_format($row['value']);
			$nestedData[]	= number_format($row['sisa_nilai']);
			$nestedData[]	= "<div align='center'>".$search->bulan."/".$search->tahun."</div>"; 
			$nestedData[]	= "<div align='center'>".$status."</div>"; 
			
				$updX = "<button type='button' id='edit' class='btn btn-sm btn-success' title='Edit' data-id='".$row['id']."' data-group_akses='".$row['group_akses']."' data-role='qtip'><i class='fa fa-edit'></i></button>";
				$delX = "";
				$PrintX	= "";
				
			$nestedData[]	= "<div align='center'>
									<button type='button' id='detail' class='btn btn-sm btn-primary' title='Detail' data-id='".$row['id']."' data-role='qtip'><i class='fa fa-eye'></i></button>
									
									".$PrintX."
									".$delX."
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
			"recordsAset"		=> intval($totalAset),
			"recordsSusut"		=> intval($totalSusut),
			"recordsSisa"		=> intval($totalSisa)
		);

		echo json_encode($json_data);
	}

	public function queryDataJSON($kdcab, $tgl, $kategori, $like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL){
		
		$where_kdcab = "";
		if(!empty($kdcab)){
			$where_kdcab = " AND a.kdcab = '".$kdcab."' ";
		}
		
		$where_kategori = "";
		if(!empty($kategori)){
			$where_kategori = " AND a.category = '".$kategori."' ";
		}
		
		// $where_tgl = "";
		// if(!empty($tgl)){
			// $ArrEx	= explode('-', $tgl);
			
			// $where_tgl = " AND a.kdcab = '".$tgl."' ";
		// }
		
		$sql = "
			SELECT
				a.id,
				a.kd_asset,
				a.nm_asset,
				a.category,
				a.nm_category,
				a.nilai_asset,
				a.depresiasi,
				a.`value`,
				b.sisa_nilai,
				a.lokasi_asset,
				a.kdcab 
			FROM
				asset a LEFT JOIN asset_nilai b ON a.kd_asset = b.kd_asset 
			WHERE 1=1
				AND a.deleted = 'N' 
				".$where_kdcab."
				".$where_kategori."
				AND (
				a.nm_asset LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.category LIKE '%".$this->db->escape_like_str($like_value)."%'
	        )
		";
		// echo $sql; exit;
		
		$Query_Sum	= "SELECT
				SUM(a.nilai_asset) AS total_aset,
				SUM(a.`value`) AS total_susut,
				SUM(b.sisa_nilai) AS total_sisa
			FROM
				asset a LEFT JOIN asset_nilai b ON a.kd_asset = b.kd_asset 
			WHERE 1=1
				AND a.deleted = 'N' 
				".$where_kdcab."
				".$where_kategori."
				AND (
				a.nm_asset LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.category LIKE '%".$this->db->escape_like_str($like_value)."%'
	        )";
		$Total_Aset = $Total_Susut = $Tota_Sisa	= 0;		
		$Hasil_SUM		   = $this->db->query($Query_Sum)->result_array();
		if($Hasil_SUM){
			$Total_Aset		= $Hasil_SUM[0]['total_aset'];
			$Total_Susut	= $Hasil_SUM[0]['total_susut'];
			$Tota_Sisa		= $Hasil_SUM[0]['total_sisa'];
		}
		$data['totalData'] 	= $this->db->query($sql)->num_rows();
		$data['totalAset'] 	= $Total_Aset;
		$data['totalSusut'] = $Total_Susut;
		$data['totalSisa'] 	= $Tota_Sisa;
		$data['totalFiltered'] = $this->db->query($sql)->num_rows();
		$columns_order_by = array(
			0 => 'id',
			1 => 'kd_asset',
			2 => 'nm_asset',
			3 => 'nm_category',
			4 => 'depresiasi',
			5 => 'nilai_asset',
			6 => 'value',
			7 => 'sisa_nilai'  
			
		);

		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir." ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function GetAsetCombo(){
		$aMenu		= array();
		$this->db->select('a.kd_asset, a.nm_asset');
		$this->db->from('asset a');
		$this->db->where('a.deleted','N');
		$this->db->order_by('a.nm_asset', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aMenu[$vals['kd_asset']]	= $vals['kd_asset'].' - '.$vals['nm_asset'];
			}
		}
		return $aMenu;
	}
	
	function GetPoAsetPeyusutan($id=''){
		$this->db->select('a.*, b.nama');
		$this->db->from('tr_po_aset a');
		$this->db->join('ms_vendor b','a.vendor_id=b.id_vendor','left');
		$this->db->order_by('a.id', 'desc');
		$this->db->where('a.terima_barang', 1);
		$this->db->where('a.penyusutan', 0);
		if($id!=''){
			$this->db->where('a.id', $id);
		}
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}
