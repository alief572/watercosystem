<?php

class Master_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		// Your own constructor code

	}

	public function Simpan($table,$data){
		return $this->db->insert($table, $data);
	}
	public function getData($table,$where_field='',$where_value=''){
		if($where_field !='' && $where_value!=''){
			$query = $this->db->get_where($table, array($where_field=>$where_value));
		}else{
			$query = $this->db->get($table);
		}

		return $query->result();
	}

	public function getDataArray($table,$where_field='',$where_value='',$keyArr='',$valArr='',$where_field2='',$where_value2=''){
		if($where_field !='' && $where_value!=''){
			$query = $this->db->get_where($table, array($where_field=>$where_value));
		}
		if($where_field2 !='' && $where_value2 !='' && $where_field !='' && $where_value!=''){
			$query = $this->db->get_where($table, array($where_field=>$where_value,$where_field2=>$where_value2));
		}
		else{
			$query = $this->db->get($table);
		}
		$dataArr	= $query->result_array();

		if(!empty($keyArr) && !empty($valArr)){
			$Arr_Data	= array();
			foreach($dataArr as $key=>$val){
				$nilai_id				= $val[$keyArr];
				if(empty($valArr)){
					$Arr_Data[$nilai_id]	= $val;
				}else{
					$Arr_Data[$nilai_id]	= $nilai_id;
				}


			}

			return $Arr_Data;
		}else{
			return $dataArr;
		}

	}
	public function getCount($table,$where_field='',$where_value=''){
		if($where_field !='' && $where_value!=''){
			$query = $this->db->get_where($table, array($where_field=>$where_value));
		}else{
			$query = $this->db->get($table);
		}
		return $query->num_rows();
	}

	public function getUpdate($table,$data,$where_field='',$where_value=''){
		if($where_field !='' && $where_value!=''){
			$query = $this->db->where(array($where_field=>$where_value));
		}
		$result	= $this->db->update($table,$data);
		return $result;
	}
	public function getDelete($table,$where_field,$where_value){
		$result	= $this->db->delete($table,array($where_field=>$where_value));
		return $result;
	}

	public function getMenu	($where=array()){
		$aMenu		= array();
		if(!empty($where)){
			$query = $this->db->get_where('menus',$where);
		}else{
			$query = $this->db->get('menus');
		}

		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aMenu[$vals['id']]	= $vals['name'];
			}
		}
		return $aMenu;

	}



	public function getArray($table,$WHERE=array(),$keyArr='',$valArr=''){
		if($WHERE){
			$query = $this->db->get_where($table, $WHERE);
		}else{
			$query = $this->db->get($table);
		}
		$dataArr	= $query->result_array();

		if(!empty($keyArr)){
			$Arr_Data	= array();
			foreach($dataArr as $key=>$val){
				$nilai_id					= $val[$keyArr];
				if(!empty($valArr)){
					$nilai_val				= $val[$valArr];
					$Arr_Data[$nilai_id]	= $nilai_val;
				}else{
					$Arr_Data[$nilai_id]	= $val;
				}

			}

			return $Arr_Data;
		}else{
			return $dataArr;
		}

	}

	public function get_select($typex=NULL,$idm=NULL){
		if ($typex == 'veil') {
			$type = 'VEIL';
			$kode = 'TYP-0003';
		}elseif ($typex == 'csm') {
			$type = 'CSM (MAT)';
			$kode = 'TYP-0004';
		}else {
			$type = 'woven rooving';
			$kode = 'TYP-0006';
		}
		$utype = strtoupper($type);
		$ListMat		= $this->db->query("SELECT * FROM raw_materials WHERE id_category = '".$kode."'")->result_array();
		$sel = "

		<input type='hidden' name='glass[detail_name][]' value='GLASS'>
		<input type='hidden' name='glass[id_category][]' value='".$kode."'>
		<select name='glass[id_material][]' id='$typex' class='form-control input-sm chosen-select'>
			<option value='0'>Select $utype</option>";
			foreach($ListMat AS $val => $valx){
				if ($valx['id_material'] == $idm) {
					$selected = 'selected';
				}else {
					$selected = '';
				}
				$sel .= "<option value='".$valx['id_material']."' ".$selected.">".strtoupper(strtolower($valx['nm_material']))."</option>";
			}
			$sel .= "<option value='MTL-1903000'>NONE MATERIAL</option>";
		$sel .= "</select>";
		return $sel;
	}

	public function get_select_detail_OLD($type=NULL,$name=NULL){
		$utype = strtoupper($type);
		$ListMat		= $this->db->query("SELECT * FROM raw_materials WHERE id_category = '$type'")->result_array();
		if ($type == 'TYP-001519') {
			$ListMat		= $this->db->query("SELECT * FROM raw_materials WHERE id_category IN ('TYP-0015','TYP-0019')")->result_array();
		}
		if ($type == 'WAX') {
			$ListMat	= $this->db->query("SELECT * FROM raw_materials WHERE id_category='TYP-0008' OR id_category='TYP-0019' ORDER BY nm_material ASC")->result_array();
		}
		$ListCat		= $this->db->query("SELECT * FROM raw_categories WHERE id_category = '$type'")->row();
		$sel = "
		<input type='hidden' name='resinnadd[detail_name][]' value='RESIN AND ADD'>
		<input type='hidden' name='resinnadd[id_category][]' value='".$type."'>
		<select name='$name' id='$type' class='form-control input-sm'>
			<option value='0'>Select ".$ListCat->category."</option>";
			foreach($ListMat AS $val => $valx){
				$sel .= "<option value='".$valx['id_material']."'>".strtoupper(strtolower($valx['nm_material']))."</option>";
			}
			$sel .= "<option value='MTL-1903000'>NONE MATERIAL</option>";
		$sel .= "</select>";
		return $sel;
	}

	public function get_select_detailOLD($type=NULL,$name=NULL,$cat=NULL){
		$utype = strtoupper($type);
		$ListMat		= $this->db->query("SELECT * FROM raw_materials WHERE id_category = '$type'")->result_array();
		if ($type == 'WAX') {
			$ListMat	= $this->db->query("SELECT * FROM raw_materials WHERE id_category='TYP-0008' OR id_category='TYP-0019' ORDER BY nm_material ASC")->result_array();
		}
		if ($type == 'TYP-001519') {
			$ListMat		= $this->db->query("SELECT * FROM raw_materials WHERE id_category IN ('TYP-0015','TYP-0019')")->result_array();
		}
		$ListCat		= $this->db->query("SELECT * FROM raw_categories WHERE id_category = '$type'")->row();
		$sel = "
		<input type='hidden' name='resinnadd[detail_name][]' value='RESIN AND ADD'>
		<input type='hidden' name='resinnadd[nm_category][]' value='$cat'>
		<input type='hidden' name='resinnadd[id_category][]' value='".$type."'>
		<select name='$name' id='$type' class='form-control input-sm'>
			<option value='0'>Select ".$cat."</option>";
			foreach($ListMat AS $val => $valx){
				$sel .= "<option value='".$valx['id_material']."'>".strtoupper(strtolower($valx['nm_material']))."</option>";
			}
			$sel .= "<option value='MTL-1903000'>NONE MATERIAL</option>";
		$sel .= "</select>";
		return $sel;
	}

	public function get_select_detail($type=NULL,$name=NULL,$cat=NULL,$idm=NULL){
		$utype = strtoupper($type);
		$ListMat		= $this->db->query("SELECT * FROM raw_materials WHERE id_category = '$type'")->result_array();
		if ($type == 'WAX') {
			$ListMat	= $this->db->query("SELECT * FROM raw_materials WHERE id_category='TYP-0008' OR id_category='TYP-0019' ORDER BY nm_material ASC")->result_array();
		}
		if ($type == 'TYP-001519') {
			$ListMat		= $this->db->query("SELECT * FROM raw_materials WHERE id_category IN ('TYP-0015','TYP-0019')")->result_array();
		}
		if ($cat == 'DEMPUL') {
			$ListMat		= $this->db->query("SELECT * FROM raw_materials WHERE id_category IN ('TYP-0025','TYP-0019')")->result_array();
		}
		$ListCat		= $this->db->query("SELECT * FROM raw_categories WHERE id_category = '$type'")->row();
		$sel = "
		<input type='hidden' name='resinnadd[detail_name][]' value='RESIN AND ADD'>
		<input type='hidden' name='resinnadd[nm_category][]' value='$cat'>
		<input type='hidden' name='resinnadd[id_category][]' value='".$type."'>
		<select name='$name' id='$type' class='form-control input-sm chosen-select'>
			<option value='0'>Select ".$cat."</option>";
			foreach($ListMat AS $val => $valx){
				if ($valx['id_material'] == $idm) {
					$selected = 'selected';
				}
				else {
					$selected = '';
				}
				if ('MTL-1903000' == $idm) {
					$selected = 'selected';
				}
				$sel .= "<option value='".$valx['id_material']."' ".$selected.">".strtoupper(strtolower($valx['nm_material']))."</option>";
			}
			$sel .= "<option value='MTL-1903000' ".$selected.">NONE MATERIAL</option>";
		$sel .= "</select>";
		return $sel;
	}
	
	public function get_select_detailx($type=NULL,$name=NULL,$cat=NULL,$idm=NULL){
		$utype = strtoupper($type);
		$ListMat		= $this->db->query("SELECT * FROM raw_materials WHERE id_category = '$type'")->result_array();
		if ($type == 'WAX') {
			$ListMat	= $this->db->query("SELECT * FROM raw_materials WHERE id_category='TYP-0008' OR id_category='TYP-0019' ORDER BY nm_material ASC")->result_array();
		}
		if ($type == 'TYP-001519') {
			$ListMat		= $this->db->query("SELECT * FROM raw_materials WHERE id_category IN ('TYP-0015','TYP-0019')")->result_array();
		}
		if ($cat == 'DEMPUL') {
			$ListMat		= $this->db->query("SELECT * FROM raw_materials WHERE id_category IN ('TYP-0025','TYP-0019')")->result_array();
		}
		$ListCat		= $this->db->query("SELECT * FROM raw_categories WHERE id_category = '$type'")->row();
		$sel = "
		<select name='$name' id='$type' class='form-control input-sm chosen-select'>
			<option value='0'>Select ".$cat."</option>";
			foreach($ListMat AS $val => $valx){
				if ($valx['id_material'] == $idm) {
					$selected = 'selected';
				}
				else {
					$selected = '';
				}
				if ('MTL-1903000' == $idm) {
					$selected = 'selected';
				}
				$sel .= "<option value='".$valx['id_material']."' ".$selected.">".strtoupper(strtolower($valx['nm_material']))."</option>";
			}
			$sel .= "<option value='MTL-1903000' ".$selected.">NONE MATERIAL</option>";
		$sel .= "</select>";
		return $sel;
	}
}
