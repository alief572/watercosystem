<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunaz
 * @copyright Copyright (c) 2018, Yunaz
 *
 * This is controller for Salesorder
 */

class Kurs extends Admin_Controller {
    /*
    //Permission
    protected $viewPermission   = "Customer.View";
    protected $addPermission    = "Customer.Add";
    protected $managePermission = "Customer.Manage";
    protected $deletePermission = "Customer.Delete";
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Kurs/Kurs_model'));
        $this->template->title('Setting Kurs');
        $this->template->page_icon('fa fa-money');

        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $kursyuan = $this->Kurs_model->get_kurs(38)->row();//id di tabel mata_uang
        $kursusd = $this->Kurs_model->get_kurs(6)->row();//CHINA id 38 dan USA id 6
        $this->template->set('yuan', $kursyuan);
        $this->template->set('usd', $kursusd);
        $this->template->title('Setting Kurs');
        $this->template->render('settingkurs');
    }

    public function simpankurs(){
        if(!empty($this->input->post('USD'))){
            $this->db->where(array('id'=>6));
            $this->db->update('mata_uang',array('kurs'=>$this->input->post('USD')));
        }

        if(!empty($this->input->post('YUAN'))){
            $this->db->where(array('id'=>38));
            $this->db->update('mata_uang',array('kurs'=>$this->input->post('YUAN')));
        }
       
        echo 'Simpan data berhasil';
    }

    //===========INI UNTUK PERCOBAAN SERVER SIDE==========//
    public function ajaxgetcoba(){
        $this->template->title('Setting Kurs');
        $this->template->render('ajax/ajaxgetcoba');
    }

    public function editkurs(){
        $this->db->insert('tb_coba_ss',array('coba'=>$this->input->post('COBA')));
        echo $this->input->post('ID');
    }
    //===========END PERCOBAAN SERVER SIDE==========//
}

?>
