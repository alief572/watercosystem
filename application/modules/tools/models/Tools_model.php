<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Tools_model extends BF_Model {

	public function __construct() {
		parent::__construct();
	}
	
	public function CariRevenueTgl($tgl){        
        $bulan = date('m',strtotime($tgl));
        $tahun = date('Y',strtotime($tgl));
        $blnthn = $tahun.'-'.$bulan;
          
        
        $this->db->select('a.*,b.grand_total');
        $this->db->from('tr_revenue a');
		 $this->db->join('tr_sales_order b','b.no_so=a.no_so');  
		$where = "a.status_jurnal ='CLS'"; 
        $where2 = "a.tgl_so  LIKE '%$blnthn%'"; 
        $this->db->where($where);
		 $this->db->where($where2);
        $query = $this->db->get();	
        return $query->result();
	}
	
	
	
	public function cariPlanning($noplanning)
  {
		if(!empty($noplanning)){
		
		$this->db->select('a.*, c.name_customer as name_customer,d.nama_top');
		$this->db->from('tr_planning_delivery a');
		$this->db->join('master_customers c','c.id_customer=a.id_customer');
		$this->db->join('ms_top d','d.id_top=a.top');
		//$where2 = "a.status_planning ='1'"; 
        $where3 = "a.no_surat_planning  LIKE '%$noplanning%'"; 		
		//$this->db->where($where2);
		$this->db->where($where3);
		$this->db->order_by('a.no_planning', DESC);
		$query = $this->db->get();	
		return $query->result();
		
		}
	}
	
	
	public function cariSalesOrderId($noso)
  {
		$this->db->select('a.*, b.name_customer as name_customer, c.grand_total as total_penawaran, c.no_surat as nomor_penawaran, c.tgl_penawaran');
		$this->db->from('tr_sales_order a');
		$this->db->join('master_customers b','b.id_customer=a.id_customer');
		$this->db->join('tr_penawaran c','c.no_penawaran=a.no_penawaran');
		$where = "a.no_surat = '$noso'";
		$where2 = "a.status !='0'";
		$this->db->where($where);
		$this->db->where($where2);
		$this->db->order_by('a.no_so', DESC);
		$query = $this->db->get();	
		return $query->result();
	}
	
}