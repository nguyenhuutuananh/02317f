<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Newview_model extends CRM_Model
{
    function __construct()
    {
        parent::__construct();
    }
    /**
     * Get tax by id
     * @param  mixed $id tax id
     * @return mixed     if id passed return object else array
     */
    public function get($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get('tbltaxes')->row();
        }
        $this->db->order_by('taxrate', 'ASC');
        return $this->db->get('tbltaxes')->result_array();
    }
    public function update_menu_bds($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('tblmenubds',$data);
        if ($this->db->affected_rows() > 0) {
            logActivity('Update menu bds [ID: ' . $id . ']');
            return true;
        }
        return false;
    }
    public function get_project_menu($id,$exigency="",$project=false,$where_array=array())
    {
        $this->db->select('tblprojectmenu.*,tblprojectmenu.id as id_project,province.name as province_name,province.provinceid,district.name as district_name,district.districtid,d.name as door_direction_name,f.name as furniture_name,tblmaster_bds.*');
        if($exigency)
        {
            $this->db->join('tblproject_exigency', 'tblproject_exigency.id_project = tblprojectmenu.id and id_exigency='.$exigency)
            ->join('tblexigency', 'tblexigency.id = tblproject_exigency.id_exigency', 'left');
        }
        $this->db->join('district', 'district.districtid = tblprojectmenu.district', 'left')
        ->join('province', 'province.provinceid = tblprojectmenu.province', 'left')

            ->join('tbldoor_direction d', 'd.id = tblprojectmenu.door_direction and d.type=0', 'left')
            ->join('tbldoor_direction f', 'f.id = tblprojectmenu.furniture and f.type=1', 'left')

        ->join('tblmenubds','tblmenubds.id=tblprojectmenu.id_menu and tblprojectmenu.id_menu='.$id)
        ->join('tblmaster_bds','tblmaster_bds.idproject=tblprojectmenu.id and tblmaster_bds.view=1 and tblmaster_bds._delete=0','left');



        $this->db->where('tblprojectmenu._delete=0');
        if($where_array!=array())
        {
            foreach($where_array as $r=> $rom)
            {
                if($r!=='district'&&$r!=='furniture')
                {
                    if($rom!="")
                    {
                        $this->db->where($rom);
                    }
                }
                if($r==='district'||$r==='furniture')
                {
                    $array=(array)json_decode($rom);
                    if($array!=array())
                    {
                        $this->db->where_in('tblprojectmenu.district',$array);
                    }
                }
            }
        }

        if($project)
        {
            $this->db->where('tblprojectmenu.project='.$project);
        }
        $result= $this->db->get('tblprojectmenu')->result_array();
        if($result)
        {
            return $result;
        }
        else
        {
            return array();
        }
    }
    public function kiemtra_fields($id_project="",$where_field=array())
    {
        if($where_field==array())
        {
            return true;
        }
        $this->db->where('tblfieldvalue_bds.colum_id',$id_project);
        $this->db->join('tbfield_bds','tbfield_bds.id=tblfieldvalue_bds.field_id','left');
        foreach($where_field as $rom)
        {
            $this->db->where($rom);
        }
       $result= $this->db->get('tblfieldvalue_bds')->row();
        if($result)
        {
            return true;
        }
        return false;
    }
    /**
     * Add new tax
     * @param array $data tax data
     * @return boolean
     */
    public function get_field($id)
    {
        $this->db->where('tblrow_menu_bds.id_menu',$id);
        $this->db->join('tbfield_bds','tbfield_bds.id=tblrow_menu_bds.id_field and fields_from=1 and tbfield_bds._table="menu_bds"');
        return $this->db->get('tblrow_menu_bds')->result_array();
    }
    public function add_field_value($id,$data)
    {
        $affected=0;
        foreach($data as $rom=>$value)
        {
            $array=array();
            $this->db->where('colum_id',$id);
            $this->db->where('field_id',$rom);
            $re=$this->db->get('tblfieldvalue_bds')->row();
            if(!$re) {
                $array = array('colum_id' => $id, 'field_id' => $rom, 'value' => $value);
                $this->db->insert('tblfieldvalue_bds', $array);
                $result = $this->db->insert_id();
                if ($result) {
                    $affected++;
                }
            }
            else
            {
                $array = array('field_id' => $rom, 'value' => $value);
                $this->db->where('colum_id',$id);
                $this->db->where('field_id',$rom);
                $this->db->update('tblfieldvalue_bds', $array);
                if ($this->db->affected_rows() > 0)
                {
                    $affected++;
                }
            }
        }
        if($affected>0)
        {
            return true;
        }
        return false;
    }
    public function get_colum($id_menu)
    {
        $this->db->select('tblrow_menu_bds.*,tbfield_bds.id_field as id_input,tbfield_bds.name');
        $this->db->where('tblrow_menu_bds.id_menu',$id_menu);
        $this->db->where('tblrow_menu_bds.fields_table=1');
        $this->db->join('tbfield_bds','tbfield_bds.id=tblrow_menu_bds.id_field','left');
        return $this->db->get('tblrow_menu_bds')->result_array();
    }
    public function get_order_colum($id_menu)
    {
        $this->db->where('id_menu',$id_menu);
        return $this->db->get('tblorder_table')->row();
    }
     public function add($data)
     {
         if(isset($data['tags'])){
             $tags=$data['tags'];
             unset($data['tags']);
         }
         $this->db->insert('tblprojectmenu', $data);
         $insert_id = $this->db->insert_id();
         if ($insert_id) {
             logActivity('New project bds [ID: ' . $insert_id . ', ' . $data['name'] . ']');
             if($tags)
             {
                handle_tags_save($tags,$insert_id,'project_bds');
             }
             return $insert_id;
         }
         return false;
     }
    public function add_exigency($id,$data=array())
    {
        $assult=0;
        if($data!=array())
        {
            foreach($data as $r){
                $this->db->insert('tblproject_exigency',array('id_project'=>$id,'id_exigency'=>$r,'addedfrom'=>get_staff_user_id()));
                if ($this->db->affected_rows() > 0)
                {
                    $assult++;
                }
            }
        }
        if($assult>0)
        {
            return true;
        }
        return false;
    }
    public function update_exigency($id,$data=array())
    {
        $assult=0;
        if($data!=array())
        {
            $this->db->where('id_project',$id);
            $this->db->delete('tblproject_exigency');
            foreach($data as $r){
                $this->db->insert('tblproject_exigency',array('id_project'=>$id,'id_exigency'=>$r,'addedfrom'=>get_staff_user_id()));
                if ($this->db->affected_rows() > 0)
                {
                    $assult++;
                }
            }
            if($assult>0)
            {
                return true;
            }

        }
        return false;
    }
    public function get_exigency_project($id_project)
    {
        $this->db->select('tblexigency.name,tblexigency.id');
        $this->db->where('id_project',$id_project);
        $this->db->join('tblexigency','tblexigency.id=tblproject_exigency.id_exigency');
        return $this->db->get('tblproject_exigency')->result_array();

    }

    public function insertfile($data)
    {
        $this->db->insert('tblfile_bds',$data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            logActivity('New video [ID: ' . $insert_id . ', ' . $data['name'] . ']');
            return $insert_id;
        }
        return false;
    }
    public function delete_project($id)
    {
        $data=array('_delete'=>1,'date_delete'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('tblprojectmenu',$data);
        if ($this->db->affected_rows() > 0)
        {
            $this->db->where('id',$id);
            $result=$this->db->get('tblprojectmenu')->row();
            return $result;
        }
    }
    public function _delete($id,$table)
    {
        $data=array('_delete'=>1,'date_delete'=>date('Y-m-d H:i:s'));
        if($table=='tblcall_logs'){
            $this->db->where('ID',$id);
        }
        else
            if($table=='tblmaster_bds')
            {
                $this->db->where('id',$id);
            }
        $this->db->update($table,$data);
        if ($this->db->affected_rows() > 0) {
            if($table=='tblcall_logs'){
                logActivity('Xóa nhật ký cuộc gọi [ID: ' . $id .']');
            }
            else
                if($table=='tblmaster_bds')
                {
                    logActivity('Xóa Chủ sỏ hữu [ID: ' . $id .']');
                }
            return true;
        }
        return false;

    }
    public function delete_profile($id)
    {
        $this->db->where('id',$id);
        $ro=$this->db->get('tblprofile_project')->row();
        $this->db->where('id',$id);
        $this->db->delete('tblprofile_project');
        if ($this->db->affected_rows() > 0) {
            logActivity('Xóa quyền quản trị của nhân viên [ID: ' . $ro->id_staff .']-'.get_staff_full_name($ro->id_staff).' tại bất động sản'.$ro->id_project);
            return true;
        }

    }
    public function update($id,$data)
     {
         if(isset($data['tags']))
         {
             $tags=$data['tags'];
             unset($data['tags']);
         }
         $this->db->where('id',$id);
         $this->db->update('tblprojectmenu', $data);
         if ($this->db->affected_rows() > 0) {

             if(isset($tags))
             {
                handle_tags_save($tags,$id,'project_bds');
             }
             logActivity('Update project bds [ID: ' . $id .']');
             return true;
         }
         return false;
     }
    public function get_status_project($id,$project=false)
    {
        $this->db->select('tblprojectmenu.*');
        $this->db->where('tblprojectmenu.id_menu',$id)->where('tblprojectmenu._delete=0');
        if($project)
        {
            $this->db->where('project',$project);
        }
        $project=$this->db->get('tblprojectmenu')->result_array();
        return $project;
    }
    public function get_status_project_exigency($id,$project=false,$exigency=false)
    {
        $this->db->select('count(DISTINCT(tblprojectmenu.id)) as count');
        $this->db->join('tblproject_exigency','tblproject_exigency.id_project=tblprojectmenu.id','left');
        if($project)
        {
            $this->db->where('tblprojectmenu.project',$project);
        }
        $this->db->where('tblprojectmenu._delete',0);
        if($exigency)
        {
            $this->db->where('tblproject_exigency.id_exigency',$exigency);
        }
        $result=$this->db->get('tblprojectmenu')->row();
        return $result->count;

    }
    public function get_projectmenu($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('tblprojectmenu')->row();

    }
    public function get_master_to_project($id="")
    {
        $this->db->where('id_project',$id);
        return $this->db->get('tblmaster_bds')->row();
    }
    public function get_master_where($table="",$where="")
    {
        if($where!=""){
            $this->db->where($where);
        }
       return $this->db->get($table)->row();
    }
    public function getdata_master($phones,$type_master)
    {
        $_phones=explode(',',$phones);
        $this->db->select('distinct(code_master),id,name');
        foreach($_phones as $phone)
        {
            $this->db->or_like('phonenumber',$phone);
        }
        $this->db->where('_delete','0');
        $this->db->where('type_master',$type_master);
        $result= $this->db->get('tblmaster_bds')->result_array();
        if($result)
        {
            return $result;
        }
    }
    public function getdata_master_tax($tax)
    {
        $this->db->where('_delete','0');
        $this->db->where('tax',$tax);
        $result= $this->db->get('tblmaster_bds')->row();
        if($result)
        {
            return $result;
        }
    }
    public function getcode_master()
    {
        $this->db->select('code_master');
        $this->db->where('type_master',3);
        $this->db->or_where('type_master',2);
        $result= $this->db->get('tblmaster_bds')->result_array();
        return count($result);
    }
    public function get_table_where_id($table,$where)
    {
        $this->db->where($where);
        $result= $this->db->get($table)->row();
        return $result;
    }
    /**
     * Edit tax
     * @param  array $data tax data
     * @return boolean
     */
    public function edit($data)
    {
        if (total_rows('tblexpenses', array(
            'tax' => $data['taxid']
        )) > 0) {
            return array(
                'tax_is_using_expenses' => true
            );
        }
        $taxid        = $data['taxid'];
        $original_tax = get_tax_by_id($taxid);
        unset($data['taxid']);
        $this->db->where('id', $taxid);
        $this->db->update('tbltaxes', $data);
        if ($this->db->affected_rows() > 0) {
            logActivity('Tax Updated [ID: ' . $taxid . ', ' . $data['name'] . ']');
            // Check if this task is used in settings
            $default_taxes = get_option('default_tax');
            $tax_name      = $original_tax->name . '|' . $original_tax->taxrate;
            if (strpos($default_taxes, $tax_name) !== false) {
                $default_taxes = str_ireplace($tax_name, $data['name'] . '|' . $data['taxrate'], $default_taxes);
                update_option('default_tax', $default_taxes);
            }
            return true;
        }
        return false;
    }
    /**
     * Delete tax from database
     * @param  mixed $id tax id
     * @return boolean
     */
    public function getmenu($id)
    {
        $this->db->where('id',$id)
        ->order_by('menu_name', 'asc');

        return $this->db->get('tblmenubds')->row();
    }
    public function get_table($table)
    {
        return $this->db->get($table)->result_array();
    }
    public function get_table_where($table,$where)
    {
        $this->db->where($where);
        return $this->db->get($table)->result_array();
    }
    public function get_table_where_order($table,$where,$colum,$type)
    {
        $this->db->order_by($colum,$type);
        $this->db->where($where);
        return $this->db->get($table)->result_array();
    }
    public function get_exigency_menu($id_menu="",$menu_chil="")
    {
        $array_menu=explode(',',$menu_chil);
        $this->db->select('tblexigency.*')->where_in('tblexigency.id',$array_menu);
        return $this->db->get('tblexigency')->result_array();
    }

     public function getprice()
    {   
        $this->db->select('id,CONCAT(price_min," - ",price_max) as price');
                  
        return $this->db->get('tblpricebds')->result_array();
    }
    public function get_data_join($table,$table_join,$where,$select)
    {
        $this->db->select($select);
        $this->db->join($table_join,$where);
        return $this->db->get($table)->result_array();
    }
    public function get_table_staff($where="")
    {
        $this->db->select('staffid,CONCAT(firstname,"",lastname) as fullname');
        $this->db->join('tblstaff','tblstaff.staffid=tblprofile_project.id_staff');
        if($where!="")
        {
            $this->db->where($where);
        }
        return $this->db->get('tblprofile_project')->result_array();
    }
    public function get_table_staff_fullname($where="")
    {
        $this->db->select('staffid,CONCAT(firstname," ",lastname) as fullname');
        $this->db->where($where);
        return $this->db->get('tblstaff')->result_array();
    }


    public function getstatus()
    {
        return $this->db->get('tblstatusbds')->result_array();
    }
    public function count_menu_project($id_menu)
    {
        return $this->db->query("SELECT count(id_menu) AS count FROM tblprojectmenu where id_menu=".$id_menu)->row();
    }
    public function code_menu($id_menu)
    {
        $this->db->where('id',$id_menu);
        return $this->db->get('tblmenubds')->row()->code_menu;
    }



    public function get_menu($id = '')
    {

        if (is_numeric($id)) {
            $this->db->where('id', $id);

            return $this->db->get('tblmenubds')->row();
        }
        $this->db->where('parent_id',0);
        return $this->db->get('tblmenubds')->result_array();
    }
    public function delete($id)
    {

        $this->db->where('id', $id);
        $this->db->delete('tblmenubds');

        if ($this->db->affected_rows() > 0) {
            logActivity('Tax Deleted [ID: ' . $id . ']');
            return true;
        }
        return false;
    }

    // TA Custom add file to database
    public function addFileToMaster($idProjectMenu, $filepath) {
        $this->db->where('id', $idProjectMenu);
        $projectMenu = $this->db->get('tblprojectmenu')->row();
        if($projectMenu) {
            $files = json_decode($projectMenu->masterFiles);
            if(!$files) {
                $files = array();
            }
            $image = new stdClass();
            $image->path = $filepath;
            $image->filename = basename($filepath);
            array_unshift($files, $image);
            
            $this->db->where('id', $idProjectMenu);
            $data = array(
                'masterFiles' => json_encode($files),
            );
            $this->db->update('tblprojectmenu', $data);
            if($this->db->affected_rows() > 0) {
                return true;
            }
        }
        return false;
    }
    public function removeFileFromMaster($idProjectMenu, $filename) {
        $this->db->where('id', $idProjectMenu);
        $projectMenu = $this->db->get('tblprojectmenu')->row();
        if($projectMenu) {
            $files = json_decode($projectMenu->masterFiles);
            if(!empty($files) && count($files) > 0) {
                $files = (array)$files;
                foreach($files as $key=>$file) {
                    if($file->filename == $filename) {
                        unlink($file->path);
                        unset($files[$key]);
                        $this->db->where('id', $idProjectMenu);
                        $data = array(
                            'masterFiles' => json_encode((array)$files),
                        );
                        $this->db->update('tblprojectmenu', $data);
                        if($this->db->affected_rows() > 0) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}
