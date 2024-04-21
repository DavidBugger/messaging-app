<?php

class Access_control extends Controller
{
    public $type;
    public $action;
    public $role_id;

    public function __construct()
    {
        parent::__construct();

        $this->type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
        $this->action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
        $this->role_id = isset($_SESSION['messaging_role_id'])?$_SESSION['messaging_role_id']:'';
    }
    
    public function savePermission($data)
    {

        if($data['action'] == "new"){
            $validate = $this->validate($data,
                array('method'=>'required','name'=>'required|unique:permissions.name','actions'=>'required','description'=>'required'),
                array('method'=>'Method','name'=>'Permission name','actions'=>'Action', 'description'=>'Description')
            );

            $method = explode('::-',$data['method']);

            if(!is_array($method)){
                $validate['error'] = true;
                $validate['messages'][0] = 'Method is incorrectly formed';
            }
            if(is_array($method) && (sizeof($method) == 0 || sizeof($method) > 2)){
                $validate['error'] = true;
                $validate['messages'][0] = 'Method is incorrectly formed';
            }
            
            if(!$validate['error']){
                $data['created_by'] = $_SESSION['messaging_username'];
                $data['posted_ip'] = $_SERVER['REMOTE_ADDR'];
                $data['created'] = date('Y-m-d h:i:s');

                $stmt = $this->runCRUD("INSERT INTO `permissions` (`name`,`method`,`action`,`description`,`posted_ip`,`created`,`created_by`) values('".$data['name']."','".$data['method']."','".$data['actions']."','".$data['description']."','".$data['posted_ip']."','".$data['created']."','".$data['created_by']."')");

                if($stmt > 0){
                    return json_encode(array('response_code' => 0, 'response_message' => 'Permission has been created'));
                }else{
                    return json_encode(array('response_code' => 20, 'response_message' => 'Permission could not be created'));
                }
            }else{
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }
        }else{
            $validate = $this->validate($data,
                array('method'=>'required','name'=>'required','action'=>'required','description'=>'required'),
                array('method'=>'Method','name'=>'Permission name','action'=>'Action', 'description'=>'Description')
            );

            $method = explode('::-',$data['method']);
            if(!is_array($method)){
                $validate['error'] = true;
                $validate['messages'][0] = 'Method is incorrectly formed';
            }
            if(is_array($method) && (sizeof($method) == 0 || sizeof($method) > 2)){
                $validate['error'] = true;
                $validate['messages'][0] = 'Method is incorrectly formed';
            }

            if(!$validate['error']){
                $data['modified_by'] = $_SESSION['messaging_username'];
                $data['modified'] = date('Y-m-d h:i:s');
                $get_permission_name = $this->SelectOne('permissions','name',$data['name'],'id');
                if($get_permission_name != "" && $get_permission_name != $data['id']){
                    return json_encode(array('response_code' => 20, 'response_message' => 'Permission name already exist.'));
                }
                
                $stmt = $this->runCRUD("UPDATE permissions SET `name`='".$data['name']."',`method`='".$data['method']."',`action`='".$data['actions']."',`description`='".$data['description']."',`posted_ip`='".$data['posted_ip']."',`modified_by`='".$data['modified_by']."',`modified`='".$data['modified']."' WHERE id='".$data['id']."'");
                if($stmt > 0){
                    return json_encode(array('response_code' => 0, 'response_message' => 'Permission has been updated'));
                }else{
                    return json_encode(array('response_code' => 20, 'response_message' => 'Permission could not be updated'));
                }
            }else{
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }
            
        }
        
        
    }
    public function genMenuId()
    {
        $stmt    = $this->db_connect("select max(menu_id)+1 as maximum from menu")[0];
        
        return (!empty($stmt['maximum']))?$stmt['maximum']:'001';
    }
    
    public function OveridePermission($data)
    {
        $stmt = $this->runCRUD("UPDATE permissions SET is_deleted = '0', `status`='1' WHERE id = '".$data['id']."'");
        if ($stmt > 0){
            return json_encode(array('response_code' => 0, 'response_message' => 'Overide was successful.'));
        }else{
            return json_encode(array('response_code' => 20, 'response_message' => 'Overide was not successful.'));
        }
    }
    public function deletePermission($data)
    {
        try{   
            $stmt = $this->runCRUD("UPDATE permissions SET `is_deleted`='1', `status`='0' WHERE id = '".$data['id']."'");

            $get_permission_name = $this->SelectOne('permissions_group','permission_id',$data['id'],'role_id');
            if($get_permission_name != 0 ){
                $stmt = $this->runCRUD("DELETE FROM permissions_group WHERE permission_id = '".$data['id']."'");
            }
            if($stmt > 0){
                return json_encode(array('response_code'=>0,'response_message'=>"Record has been deleted successfully"));
            }else{
                return json_encode(array('response_code'=>20,'response_message'=>"Record could not be deleted."));
            }

        }catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> DELETE_PERMISSION_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            echo json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function ManagePermission($data)
    {
        try{
           
            if ($data['status'] == 1){
                $type = 'enabled';
            }else{
                $type = 'disabled';
            }

            $stmt = $this->runCRUD("UPDATE permissions SET `status`='".$data['status']."' WHERE id = '".$data['id']."'");
            if($stmt > 0){
                return json_encode(array('response_code'=>0,'response_message'=>"Record has been ".$type." successfully"));
            }else{
                return json_encode(array('response_code'=>20,'response_message'=>"Record could not be ".$type));
            }

        }catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> MANAGE_PERMISSION_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            echo json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    
    public function permissionList($data)
    {
        $table = 'permissions';
        $key = 'id';
        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'name', 'dt' => 1),
            array('db' => 'method', 'dt' => 2, 'formatter' => function ($e, $kk) {
                return $e;
            }),
            array('db' => 'action', 'dt' => 3, 'formatter' => function ($e, $kk) {
                return ucfirst($e);
            }),
            array('db' => 'description', 'dt' => 4, 'formatter' => function ($e, $kk) {
                return $e;
            }),
            array('db' => 'status', 'dt' => 5, 'formatter' => function ($e, $kk) {
                if($kk['is_deleted'] == 1){
                    $status = '<span class="badge badge-soft-danger">Deleted</span>';
                }elseif($e == 1){
                    $status = '<span class="badge badge-soft-success">Active</span>';
                }else{
                    $status = '<span class="badge badge-soft-warning">Inactive</span>';
                }

                return $status;
            }),
            array('db' => 'created', 'dt' => 6, 'formatter' => function ($e, $kk) {
                return date('j F, Y H:i:s', strtotime($e));
            }),
            array('db' => 'id', 'dt' =>7, 'formatter'=> function($e, $kk){
                $status = $this->SelectOne('permissions','id',$e,'status');

                $status = ($status == 1)?' <li> <a class="dropdown-item remove-item-btn" href="javascript:void(0)"  onclick="javascript:ManagePermission(\'' .$e. '\',\'0\')"> <i class=" ri-close-line align-bottom me-2 text-muted"></i> Disable </a> </li> ':'<li> <a class="dropdown-item remove-item-btn" href="javascript:void(0)" onclick="javascript:ManagePermission(\'' .$e. '\',\'1\')"> <i class="ri-check-line align-bottom me-2 text-muted"></i> Enable </a> </li> ';

                $button = ($kk['is_deleted'] == 1)?'<li> <a class="dropdown-item remove-item-btn" href="javascript:void(0)" onclick="javascript:OveridePermission(\'' .$e. '\')"> <i class="ri-settings-5-line align-bottom me-2 text-muted"></i> Overide </a> </li>':'<li><a class="dropdown-item edit-item-btn" href="javascript:void(0)" onclick="javascript:getpage(\'permission/setup?id='.$e.'&action=edit\',\'page\')"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit </a></li>'.$status.'<li> <a class="dropdown-item remove-item-btn" href="javascript:void(0)" onclick="javascript:DeletePermission(\'' .$e. '\')"> <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete </a> </li>';
                    
                return '<td><div class="dropdown d-inline-block"><button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-more-fill align-middle"></i> </button> <ul class="dropdown-menu dropdown-menu-end">'.$button.' </ul> </div> </td>';

            })
        );

        $filter = "";
        $datatable = new DataTableEngine();
        return $datatable->generateTable($data, $table, $columns, $key, $filter);

    }
    public function loadAccess($data)
    {
        $visible = $this->visibleAccess($data);
        $invisible = $this->inVisibleAccess($data);
        return json_encode(array('response_code'=>0,'response_message'=>'Permissions has been fetched successfully','permission'=>$visible.$invisible));
    }
    
    private function visibleAccess($data)
    {
        $role_id = $data['role_id'];
        $stmt     = $this->db_connect("SELECT id,name FROM permissions WHERE id IN (SELECT permission_id FROM permissions_group WHERE role_id = '$role_id') order by name");
       
        $visible = '';
        if($stmt > 0){
            foreach($stmt as $row){
                $visible .= '<option selected="" value="'.$row['id'].'">'.$row['name'].'</option>';
            }
        }
        
        return $visible;
    }
    
    private function inVisibleAccess($data)
    {
        $role_id = $data['role_id'];
        $stmt     = $this->db_connect("SELECT id,name FROM permissions WHERE id NOT IN (SELECT permission_id FROM permissions_group WHERE role_id = '$role_id') order by name");
        $invisible = '';
        if($stmt > 0){
            foreach($stmt as $row){
                $invisible .= '<option  value="'.$row['id'].'">'.$row['name'].'</option>';
            }
        }
        return $invisible;
    }

    public function savePermissionGroup($data)
    {
        if($data['role_id'] == ""){
            return json_encode(array('response_code'=>20,'response_message'=>"Please, select the role you want to assign the permission to")); 
        }

        $role_id = $data['role_id'];
        $stmt = $this->runCRUD("DELETE FROM permissions_group WHERE role_id = '$role_id'");
        if(is_array($data['permissions']) && sizeof($data['permissions']) > 0){
            foreach($data['permissions'] as $value){
                $stmt = $this->runCRUD("INSERT INTO permissions_group (role_id,permission_id) VALUES('$role_id','$value')");
            }

            if($stmt > 0){
                return json_encode(array('response_code'=>0,'response_message'=>"Permission has been successfully assigned to {$this->SelectOne('role','role_id',$role_id,'role_name')}")); 

            }else{
                return json_encode(array('response_code'=>20,'response_message'=>"Permission could not be assigned to {$this->SelectOne('role','role_id',$role_id,'role_name')}")); 

            }
        }else{
            return json_encode(array('response_code'=>20,'response_message'=>"Please, select at least 1 permission")); 
        }
    }

    public function GrantPermission()
    {
        $stmt = $this->db_connect("SELECT method, action, id FROM permissions WHERE id IN (SELECT permission_id FROM permissions_group WHERE role_id = '{$this->role_id}') AND method='{$this->type}' AND action='{$this->action}'");

        if($this->action == 'new'){
            $msg = 'add new records';
        }elseif($this->action == 'edit'){
            $msg = 'modify records';
        }elseif($this->action == 'list'){
            $msg = 'view this list';
        }elseif($this->action == 'view'){
            $msg = 'view this record';
        }else{
            $msg = 'access this feature';
        }

        if(is_array($stmt) && sizeof($stmt) <= 0){
            // return json_encode(array('response_code' => 20, 'response_message'=>"You are not permitted to {$msg}."));
        }

        return json_encode(array('response_code' => 0, 'response_message'=>'Allowed'));

    }
}