<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author Yunaz
 * @copyright Copyright (c) 2018, Yunaz
 *
 * This is controller for Menus
 */

class Menus extends Admin_Controller
{

  //Permission
  protected $viewPermission   = "Menus.View";
  protected $addPermission    = "Menus.Add";
  protected $managePermission = "Menus.Manage";
  protected $deletePermission = "Menus.Delete";

  public function __construct()
  {
    parent::__construct();

    $this->load->model(array(
      'Menus/Menus_model',
      'Aktifitas/aktifitas_model'
    ));
    $this->template->title('Manage Data Menus');
    $this->template->page_icon('fa fa-table');

    date_default_timezone_set("Asia/Bangkok");
  }

  public function index()
  {
    $this->auth->restrict($this->viewPermission);

    $this->template->title('Menus');
    $this->template->render('list');
  }

  // Data serverside daftar menu (DataTable).
  public function data_menus()
  {
    $this->auth->restrict($this->viewPermission);
    $this->load->helper('dt');
    dt_respond($this, function () {
      $data = dt_list($this->db, array(
        'draw' => $this->input->post('draw'), 'start' => $this->input->post('start'), 'length' => $this->input->post('length'),
        'search' => $this->input->post('search'), 'order' => $this->input->post('order'),
      ), array(
        'from'    => 'menus',
        'select'  => 'id, title, link, target, group_menu, parent_id, permission_id, status',
        'search'  => array('title', 'link'),
        'sort'    => array(1 => 'id', 2 => 'title', 3 => 'link', 4 => 'target', 5 => 'group_menu', 6 => 'parent_id', 7 => 'permission_id', 8 => 'status'),
        'default' => 'id ASC',
      ));
      $canManage = has_permission($this->managePermission);
      $canDelete = has_permission($this->deletePermission);
      $rows = array(); $number = $data['start'];
      foreach ($data['rows'] as $row) {
        $action = '';
        if ($canManage) {
          $action .= '<a class="text-green" href="javascript:void(0)" title="Edit" onclick="edit_data(' . (int) $row->id . ')"><i class="fa fa-pencil"></i></a> ';
        }
        if ($canDelete) {
          $action .= '<a class="text-red" href="javascript:void(0)" title="Delete" onclick="delete_data(' . (int) $row->id . ')"><i class="fa fa-trash"></i></a>';
        }
        $rows[] = array('DT_RowId' => 'menu-' . (int) $row->id, 'no' => ++$number, 'id' => (int) $row->id,
          'title' => html_escape($row->title), 'link' => html_escape($row->link), 'target' => html_escape($row->target),
          'group_menu' => html_escape($row->group_menu), 'parent_id' => html_escape($row->parent_id), 'permission_id' => html_escape($row->permission_id),
          'status' => $row->status == '1' ? '<label class="label label-success">Aktif</label>' : '<label class="label label-danger">Non Aktif</label>',
          'action' => $action);
      }
      return array('draw' => $data['draw'], 'recordsTotal' => $data['total'], 'recordsFiltered' => $data['filtered'], 'data' => $rows);
    }, 'Menus table');
  }

  //Create New Customer
  public function create()
  {
    $this->auth->restrict($this->addPermission);
    $datmenu       = $this->Menus_model->pilih_menu();
    $datgroupmenu    = $this->Menus_model->pilih_menu_group();
    $permission      = $this->Menus_model->pilih_permission();
    $parent_id       = $this->Menus_model->pilih_parent();
    $this->template->set('datmenu', $datmenu);
    $this->template->set('datgroupmenu', $datgroupmenu);
    $this->template->set('permission', $permission);
    $this->template->set('parent', $parent_id);
    $this->template->title('Input Master Menus');
    $this->template->render('menus_form');
  }
  //Edit Menus
  public function edit()
  {
    $this->auth->restrict($this->managePermission);
    $id = $this->uri->segment(3);
    $data  = $this->Menus_model->find_by(array('id' => $id));
    if (!$data) {
      $this->template->set_message("Invalid ID", 'error');
      redirect('Menus');
    }
    $datmenu       = $this->Menus_model->pilih_menu();
    $datgroupmenu    = $this->Menus_model->pilih_menu_group();
    $permission      = $this->Menus_model->pilih_permission();
    $parent_id       = $this->Menus_model->pilih_parent();
    $this->template->set('datmenu', $datmenu);
    $this->template->set('datgroupmenu', $datgroupmenu);
    $this->template->set('permission', $permission);
    $this->template->set('parent', $parent_id);
    $this->template->set('data', $data);
    $this->template->title('Edit Master Menu');
    $this->template->render('menus_form');
  }
  public function modalAdd_Permission()
  {
    $this->auth->restrict($this->addPermission);
    $this->template->render('modalAdd_Permission');
  }
  //Save menu ajax
  public function save_data_Menus()
  {
    $type = $this->input->post("type");
    // Otorisasi dulu, sebelum ada tulisan ke DB apa pun.
    $this->auth->restrict($type == "edit" ? $this->managePermission : $this->addPermission);

    $id             = $this->input->post("id");
    $title          = trim((string) $this->input->post("title"));
    $link           = $this->input->post("link");
    $icon           = $this->input->post('icon');
    $target         = $this->input->post('target');
    $group_menu     = $this->input->post('group_menu');
    $parent_id      = $this->input->post('parent_id');
    $permission_id  = $this->input->post('permission_id');
    $status         = $this->input->post('status');
    $order          = $this->input->post('order');

    // nm_permission = judul (spasi jadi "_") + ".Manage"/".Delete" harus muat di varchar(45).
    $permission_base = str_replace(" ", "_", $title);
    if ($title === '' || strlen($permission_base) > 38 || !in_array((string) $status, array('0', '1'), true)) {
      echo json_encode(array('save' => FALSE, 'pesan' => 'Nama menu wajib diisi (maksimal 38 karakter) dan status harus valid.'));
      return;
    }

    $log_status = 1;
    if ($type == "edit") {
      if ($id != "") {
        $data = array(
          array(
            'id' => $id,
            'title' => $title,
            'link' => $link,
            'icon' => $icon,
            'target' => $target,
            'group_menu' => $group_menu,
            'parent_id' => $parent_id,
            'permission_id' => $permission_id,
            'status' => $status,
            'order' => $order,
          )
        );
        //Update data
        $result = $this->Menus_model->update_batch($data, 'id') !== FALSE;
        $keterangan = ($result ? "SUKSES" : "GAGAL") . ", Edit data Menus " . $id . ", atas Nama : " . $title;
      } else {
        $result = FALSE;
        $keterangan = "GAGAL, Edit data Menus " . $id . ", atas Nama : " . $title;
      }
      $kode_universal = $id;
    } else //Add New
    {
      // Menu baru + 4 izinnya dalam satu transaksi; permission_id menu = id izin ".View" yang baru dibuat.
      $this->db->trans_begin();
      $view_id = NULL;
      foreach (array('View', 'Add', 'Manage', 'Delete') as $ket) {
        $this->db->insert('permissions', array(
          'nm_permission' => $permission_base . "." . $ket,
          'nm_menu' => $title,
          'ket' => $ket,
          'created_on' => date("Y-m-d H:i:s"),
          'created_by' => $this->auth->user_id()
        ));
        if ($ket === 'View') {
          $view_id = $this->db->insert_id();
        }
      }
      $data = array(
        'title' => $title,
        'link' => $link,
        'icon' => $icon,
        'target' => $target,
        'group_menu' => $group_menu,
        'parent_id' => $parent_id,
        'permission_id' => $view_id,
        'status' => $status,
        'order' => $order,
      );
      $id = $this->Menus_model->insert($data);
      if (is_numeric($id) && $view_id && $this->db->trans_status() !== FALSE) {
        $this->db->trans_commit();
        $result = TRUE;
      } else {
        $this->db->trans_rollback();
        $result = FALSE;
      }
      $keterangan = ($result ? "SUKSES" : "GAGAL") . ", tambah data Menus " . $id . ", atas Nama : " . $title;
      $log_status = $result ? 1 : 0;
      $kode_universal = 'NewData';
    }
    //Save Log
    simpan_aktifitas($type == "edit" ? $this->managePermission : $this->addPermission, $kode_universal, $keterangan, 1, $this->db->last_query(), $log_status);

    echo json_encode(array('save' => $result));
  }

  function hapus_Menus()
  {
    $this->auth->restrict($this->deletePermission);
    $id = $this->uri->segment(3);
    $get = ctype_digit((string) $id) ? $this->db->get_where('menus', array('id' => $id))->row() : NULL;

    $result = 0;
    if ($get) {
      // Menu + izin miliknya (nm_menu = judul) + pemberian izin itu ke user/group, semua atau tidak sama sekali.
      $this->db->trans_begin();
      $this->db->query("DELETE FROM user_permissions WHERE id_permission IN (SELECT id_permission FROM permissions WHERE nm_menu = ?)", array($get->title));
      $this->db->query("DELETE FROM group_permissions WHERE id_permission IN (SELECT id_permission FROM permissions WHERE nm_menu = ?)", array($get->title));
      $this->db->where(array('nm_menu' => $get->title))->delete('permissions');
      $this->Menus_model->delete($id);
      if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
      } else {
        $this->db->trans_commit();
        $result = 1;
      }
    }
    $keterangan = ($result ? "SUKSES" : "GAGAL") . ", Delete data Menus " . $id;

    //Save Log
    simpan_aktifitas($this->deletePermission, $id, $keterangan, 1, $this->db->last_query(), $result);

    echo json_encode(array('delete' => $result, 'idx' => $id));
  }
}
