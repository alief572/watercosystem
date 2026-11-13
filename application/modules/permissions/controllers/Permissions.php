<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunaz
 * @copyright Copyright (c) 2018, Yunaz
 *
 * This is controller for Permissions
 */

class Permissions extends Admin_Controller
{

    //Permission 
    protected $viewPermission   = "Permissions.View";
    protected $addPermission    = "Permissions.Add";
    protected $managePermission = "Permissions.Manage";
    protected $deletePermission = "Permissions.Delete";

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'Permissions/Permissions_model',
            'Aktifitas/aktifitas_model'
        ));
        $this->template->title('Manage Data Permissions');
        $this->template->page_icon('fa fa-table');

        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $this->auth->restrict($this->viewPermission);

        $this->template->title('Permissions');
        $this->template->render('list');
    }

    // Data serverside daftar permission (DataTable).
    public function data_permissions()
    {
        $this->auth->restrict($this->viewPermission);
        $this->load->helper('dt');
        dt_respond($this, function () {
            $data = dt_list($this->db, array(
                'draw' => $this->input->post('draw'), 'start' => $this->input->post('start'), 'length' => $this->input->post('length'),
                'search' => $this->input->post('search'), 'order' => $this->input->post('order'),
            ), array(
                'from'    => 'permissions',
                'select'  => 'id_permission, nm_permission, nm_menu, ket',
                'search'  => array('nm_permission', 'nm_menu'),
                'sort'    => array(1 => 'id_permission', 2 => 'nm_permission', 3 => 'nm_menu', 4 => 'ket'),
                'default' => 'id_permission ASC',
            ));
            $canManage = has_permission($this->managePermission);
            $canDelete = has_permission($this->deletePermission);
            $rows = array(); $number = $data['start'];
            foreach ($data['rows'] as $row) {
                $action = '';
                if ($canManage) {
                    $action .= '<a class="text-green" href="javascript:void(0)" title="Edit" onclick="edit_data(' . (int) $row->id_permission . ')"><i class="fa fa-pencil"></i></a> ';
                }
                if ($canDelete) {
                    $action .= '<a class="text-red" href="javascript:void(0)" title="Delete" onclick="delete_data(' . (int) $row->id_permission . ')"><i class="fa fa-trash"></i></a>';
                }
                $rows[] = array('DT_RowId' => 'perm-' . (int) $row->id_permission, 'no' => ++$number, 'id' => (int) $row->id_permission,
                    'nm_permission' => html_escape($row->nm_permission), 'nm_menu' => html_escape($row->nm_menu), 'ket' => html_escape($row->ket),
                    'action' => $action);
            }
            return array('draw' => $data['draw'], 'recordsTotal' => $data['total'], 'recordsFiltered' => $data['filtered'], 'data' => $rows);
        }, 'Permissions table');
    }

    //Create New Customer
    public function create()
    {
        $this->auth->restrict($this->addPermission);
        $datmenu         = $this->Permissions_model->pilih_menu_permission();
        $datgroupmenu    = $this->Permissions_model->pilih_menu_group();
        $permission      = $this->Permissions_model->pilih_permission();
        $parent_id       = $this->Permissions_model->pilih_parent();

        $this->template->set('datmenu', $datmenu);
        $this->template->set('datgroupmenu', $datgroupmenu);
        $this->template->set('permission', $permission);
        $this->template->set('parent', $parent_id);
        $this->template->title('Input Master Permissions');
        $this->template->render('permissions_form');
    }

    //Edit Permissions
    public function edit()
    {
        $this->auth->restrict($this->managePermission);

        $id = $this->uri->segment(3);
        $data  = $this->Permissions_model->find_by(array('id_permission' => $id));
        if (!$data) {
            $this->template->set_message("Invalid ID", 'error');
            redirect('Permissions');
        }

        $datmenu         = $this->Permissions_model->pilih_menu_permission();
        $datgroupmenu    = $this->Permissions_model->pilih_menu_group();
        $permission      = $this->Permissions_model->pilih_permission();
        $parent_id       = $this->Permissions_model->pilih_parent();

        $this->template->set('datmenu', $datmenu);
        $this->template->set('datgroupmenu', $datgroupmenu);
        $this->template->set('permission', $permission);
        $this->template->set('parent', $parent_id);
        $this->template->set('data', $data);
        $this->template->title('Edit Master Permission');
        $this->template->render('permissions_form');
    }

    //Save permission ajax
    public function save_data_permissions()
    {
        $type = $this->input->post("type");
        // Otorisasi dulu, sebelum ada tulisan ke DB apa pun.
        $this->auth->restrict($type == "edit" ? $this->managePermission : $this->addPermission);

        $id             = $this->input->post("id_permission");
        $nama           = trim((string) $this->input->post("nm_permission"));
        $ket            = (string) $this->input->post("ket");
        $namapermission = str_replace(" ", "_", $nama) . '.' . $ket;

        // Jenis harus salah satu dari empat aksi baku; nm_permission varchar(45).
        if ($nama === '' || !in_array($ket, array('View', 'Add', 'Manage', 'Delete'), true) || strlen($namapermission) > 45) {
            echo json_encode(array('save' => FALSE, 'pesan' => 'Nama menu wajib diisi, jenis harus valid, dan nama permission maksimal 45 karakter.'));
            return;
        }

        // Nama permission harus unik (id yang sedang diedit dikecualikan).
        $dup = $this->db->query("SELECT COUNT(*) AS n FROM permissions WHERE nm_permission = ? AND id_permission <> ?", array($namapermission, (int) $id))->row();
        if ($dup && (int) $dup->n > 0) {
            echo json_encode(array('save' => FALSE, 'pesan' => 'Permission ' . $namapermission . ' sudah ada.'));
            return;
        }

        $log_status = 1;
        if ($type == "edit") {
            if ($id != "") {
                $data = array(
                    array(
                        'id_permission' => $id,
                        'nm_permission' => $namapermission,
                        'nm_menu' => $nama,
                        'ket' => $ket,
                    )
                );

                //Update data
                $result = $this->Permissions_model->update_batch($data, 'id_permission') !== FALSE;
                $keterangan = ($result ? "SUKSES" : "GAGAL") . ", Edit data Permissions " . $id . ", atas Nama : " . $nama;
            } else {
                $result = FALSE;
                $keterangan = "GAGAL, Edit data Permissions " . $id . ", atas Nama : " . $nama;
            }
            $kode_universal = $id;
        } else //Add New
        {
            // id_permission auto_increment: tidak dikirim.
            $data = array(
                'nm_permission' => $namapermission,
                'nm_menu' => $nama,
                'ket' => $ket,
            );

            $id = $this->Permissions_model->insert($data);
            $result = is_numeric($id);
            $keterangan = ($result ? "SUKSES" : "GAGAL") . ", tambah data Permissions " . $id . ", atas Nama : " . $nama;
            $log_status = $result ? 1 : 0;
            $kode_universal = 'NewData';
        }
        //Save Log
        simpan_aktifitas($type == "edit" ? $this->managePermission : $this->addPermission, $kode_universal, $keterangan, 1, $this->db->last_query(), $log_status);

        echo json_encode(array('save' => $result));
    }

    function hapus_Permissions()
    {
        $this->auth->restrict($this->deletePermission);
        $id = $this->uri->segment(3);

        $result = 0;
        if (ctype_digit((string) $id)) {
            // Izin + pemberiannya ke user/group dihapus bersama, semua atau tidak sama sekali.
            $this->db->trans_begin();
            $this->db->where('id_permission', $id)->delete('user_permissions');
            $this->db->where('id_permission', $id)->delete('group_permissions');
            $this->Permissions_model->delete($id);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $result = 1;
            }
        }
        $keterangan = ($result ? "SUKSES" : "GAGAL") . ", Delete data Permissions " . $id;

        //Save Log
        simpan_aktifitas($this->deletePermission, $id, $keterangan, 1, $this->db->last_query(), $result);

        echo json_encode(array('delete' => $result, 'idx' => $id));
    }
}
