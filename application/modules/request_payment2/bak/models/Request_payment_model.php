<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Harboens
 * @copyright Copyright (c) 2022
 *
 * This is Model for Request Payment
 */

class Request_payment_model extends BF_Model
{

    /**
     * @var string  User Table Name
     */
    protected $table_name = 'request_payment';
    protected $key        = 'id';

    /**
     * @var string Field name to use for the created time column in the DB table
     * if $set_created is enabled.
     */
    protected $created_field = 'created_on';

    /**
     * @var string Field name to use for the modified time column in the DB
     * table if $set_modified is enabled.
     */
    protected $modified_field = 'modified_on';

    /**
     * @var bool Set the created time automatically on a new record (if true)
     */
    protected $set_created = true;

    /**
     * @var bool Set the modified time automatically on editing a record (if true)
     */
    protected $set_modified = true;
    /**
     * @var string The type of date/time field used for $created_field and $modified_field.
     * Valid values are 'int', 'datetime', 'date'.
     */
    /**
     * @var bool Enable/Disable soft deletes.
     * If false, the delete() method will perform a delete of that row.
     * If true, the value in $deleted_field will be set to 1.
     */
    protected $soft_deletes = true;

    protected $date_format = 'datetime';

    /**
     * @var bool If true, will log user id in $created_by_field, $modified_by_field,
     * and $deleted_by_field.
     */
    protected $log_user = true;

    /**
     * Function construct used to load some library, do some actions, etc.
     */
    public function __construct()
    {
        parent::__construct();
    }

	// list data request
	public function GetListDataRequest(){
		$data	= $this->db->query("SELECT id as ids,no_doc,nama,tgl_doc,'Transportasi' as keperluan, 'transportasi' as tipe,jumlah_expense as jumlah,null as tanggal,no_doc as id, bank_id, accnumber, accname FROM ".DBERP.".tr_transport_req WHERE status=1
		union
		SELECT id as ids,no_doc,nama,tgl_doc,keperluan, 'kasbon' as tipe,jumlah_kasbon as jumlah,null as tanggal,no_doc as id, bank_id, accnumber, accname FROM ".DBERP.".tr_kasbon WHERE status=1
		union
		SELECT a.id as ids,a.no_doc,a.nama,a.tgl_doc,a.informasi as keperluan, 'expense' as tipe,a.jumlah,null as tanggal,a.no_doc as id, bank_id, accnumber, accname FROM ".DBERP.".tr_expense a left join ".DBACC.".coa_master as b on a.coa=b.no_perkiraan WHERE status=1
		union
		SELECT a.id as ids,a.no_doc,a.pic nama,a.tanggal_doc as tgl_doc,a.info as keperluan, 'nonpo' as tipe,a.nilai_request jumlah,null as tanggal,a.no_doc as id, bank_id, accnumber, accname FROM ".DBERP.".tr_non_po_header a WHERE a.status=3
		union
		SELECT b.id as ids,a.no_doc,c.nama_karyawan nama,a.tanggal_doc as tgl_doc,b.nama as keperluan, 'periodik' as tipe,b.nilai jumlah,null as tanggal,a.no_doc as id, b.bank_id, b.accnumber, b.accname FROM ".DBERP.".tr_pengajuan_rutin a join tr_pengajuan_rutin_detail b on a.no_doc=b.no_doc join user_emp c on a.created_by=c.id WHERE a.status='1' and b.id_payment='0'
		")->result();

		return $data;
	}

	// list data payment
	public function GetListDataPayment($where='') {
		$data	= $this->db->query("SELECT * FROM ".DBERP.".request_payment WHERE ".$where." order by id desc")->result();
		return $data;
	}
	public function GetListDataJurnal() {
		$data	= $this->db->query("SELECT nomor,tanggal,tipe,no_reff,stspos,sum(kredit) as total FROM ".DBERP.".jurnal group by nomor order by nomor desc")->result();
		return $data;
	}

}
