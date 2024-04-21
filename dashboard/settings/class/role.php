<?php

    class Role extends Controller
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function roleLists($data)
        {
            $table = 'role';
            $key = 'role_id';
            $columns = array(
                array('db' => 'role_id', 'dt' => 0),
                array('db' => 'role_name', 'dt' => 1),
                array('db' => 'role_enabled', 'dt' => 2, 'formatter' => function ($e, $kk) {
                    if($kk['is_deleted'] == 1){
                        $status = '<span class="badge badge-soft-danger">Deleted</span>';
                    }elseif($e == 1){
                        $status = '<span class="badge badge-soft-success">Active</span>';
                    }else{
                        $status = '<span class="badge badge-soft-warning">Inactive</span>';
                    }

                    return $status;
                }),
                array('db' => 'created', 'dt' => 3, 'formatter' => function ($e, $kk) {
                    return date('j F, Y H:i:s', strtotime($e));
                }),
                array('db' => 'role_id', 'dt' => 4, 'formatter' => function ($e, $kk) {
                    $status = $this->SelectOne('role','role_id',$e,'role_enabled');
                
                    $status = ($status == 1)?' <li> <a class="dropdown-item remove-item-btn" href="javascript:void(0)"  onclick="javascript:ManageRole(\'' .$e. '\',\'0\')"> <i class=" ri-close-line align-bottom me-2 text-muted"></i> Disable </a> </li> ':'<li> <a class="dropdown-item remove-item-btn" href="javascript:void(0)" onclick="javascript:ManageRole(\'' .$e. '\',\'1\')"> <i class="ri-check-line align-bottom me-2 text-muted"></i> Enable </a> </li> ';

                    $button = ($kk['is_deleted'] == 1)?'<li> <a class="dropdown-item remove-item-btn" href="javascript:void(0)" onclick="javascript:OverideRole(\'' .$e. '\')"> <i class="ri-settings-5-line align-bottom me-2 text-muted"></i> Overide </a> </li>':'<li><a class="dropdown-item edit-item-btn" href="javascript:void(0)" onclick="javascript:getpage(\'role/setup?id='.$e.'&action=edit\',\'page\')"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit </a></li>'.$status.'<li> <a class="dropdown-item remove-item-btn" href="javascript:void(0)" onclick="javascript:DeleteRole(\'' .$e. '\')"> <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete </a> </li>';
                    
                    return '<td><div class="dropdown d-inline-block"><button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-more-fill align-middle"></i> </button> <ul class="dropdown-menu dropdown-menu-end">'.$button.' </ul> </div> </td>';

                })
            );

            $filter = " AND role_id NOT IN (100)";

            $datatable = new DataTableEngine();
            return $datatable->generateTable($data, $table, $columns, $key, $filter);    
        }

        public function DeleteRole($data)
        {
            $stmt = $this->runCRUD("UPDATE role SET is_deleted = '1', role_enabled='0' WHERE role_id = '".$data['role_id']."'");
            if ($stmt > 0){
                return json_encode(array('response_code' => 0, 'response_message' => 'Record has been successfully deleted.'));
            }else{
                return json_encode(array('response_code' => 20, 'response_message' => 'Record could not be deleted.'));
            }
        }

        public function OverideRole($data)
        {
            $stmt = $this->runCRUD("UPDATE role SET is_deleted = '0', role_enabled='1' WHERE role_id = '".$data['role_id']."'");
            if ($stmt > 0){
                return json_encode(array('response_code' => 0, 'response_message' => 'Overide was successful.'));
            }else{
                return json_encode(array('response_code' => 20, 'response_message' => 'Overide was not successful.'));
            }
        }

        public function ManageRole($data)
        {
            try{
           
                if ($data['role_enabled'] == 1){
                    $type = 'enabled';
                }else{
                    $type = 'disabled';
                }
    
                $stmt = $this->runCRUD("UPDATE role SET `role_enabled`='".$data['role_enabled']."' WHERE role_id = '".$data['role_id']."'");
                if($stmt > 0){
                    return json_encode(array('response_code'=>0,'response_message'=>"Record has been ".$type." successfully"));
                }else{
                    return json_encode(array('response_code'=>20,'response_message'=>"Record could not be ".$type));
                }
    
            }catch (Exception $e) {
                $this->error_msg = date('Y-m-d H:i:s') . " >>>> MANAGE_ROLE_MODEL => Error: " . $e->getMessage();
    
                file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);
    
                echo json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
            }
        }

        public function genRoleId()
        {
            $stmt = $this->db_connect("select max(role_id)+1 as maximum from role")[0];
            
            return (!empty($stmt['maximum']))?$stmt['maximum']:'001';
        }
        
        public function saveRole($data)
        {       
            try{
                $sanitize = json_decode($this->sanitize($data['role_name'], array('role_enabled','id')),true);
                if(isset($sanitize['error'])){
                    return json_encode(array('response_code'=>20,'response_message'=>$sanitize['error']));
                }

                $data['created'] = date('Y-m-d h:i:s');
                
                if($data['action'] == "new"){
                    $stmt = $this->db_connect("SELECT role_name FROM role WHERE role_name='".$data['role_name']."' ");
                    if($stmt > 0){
                        return json_encode(array('response_code'=>20,'response_message'=>$data['role_name'].' already exists'));
                    }else{
                        $data['role_id'] = $this->genRoleId();
                        $stmt = $this->runCRUD("INSERT INTO role(role_id,role_name, role_enabled,created,`description`) VALUES('".$data['role_id']."','".$data['role_name']."','".$data['role_enabled']."','".$data['created']."','".$data['description']."')");
                        if($stmt > 0){
                            return json_encode(array('response_code'=>0,'response_message'=>'Role has been created Successfully')); 
                        }else{
                            return json_encode(array('response_code'=>20,'response_message'=>'Role could not be created'));
                        }
                    }
                }else{
                    $stmt = $this->db_connect("SELECT * FROM role WHERE role_name='".$data['role_name']."' AND role_id <> ".$data['id']."");
                    
                    if(is_array($stmt) && sizeof($stmt) > 0){
                        return json_encode(array('response_code'=>20,'response_message'=>$data['role_name'].' already exists'));
                    }else{
                        $stmt = $this->Update('role',$data,array('action','id','hci-csrf-token-label','type'),array('role_id'=>$data['id']));
                        if($stmt > 0){
                            return json_encode(array('response_code'=>0,'response_message'=>'Role has been updated successfully')); 
                             
                        }else{
                            return json_encode(array('response_code'=>20,'response_message'=>'Role could not be updated'));
                        }
                    }
                }
                
            }catch (Exception $e) {
                $this->error_msg = date('Y-m-d H:i:s') . " >>>> SAVE_ROLE_MODEL => Error: " . $e->getMessage();
    
                file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);
    
                echo json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
            }
        }

        private function sanitize($data, $exp_arr)
        {   
            if(!is_array($data)){
                if(!in_array($data, $exp_arr)){
                    $data = $this->preg_value($data);
                }
            }else{

                foreach($data as $key => $value){
                    if(!in_array($key, $exp_arr)){

                        if(is_array($value)){
                            $this->sanitize($value, $exp_arr);
                        }else{                        
                            $data = $this->preg_value($value);
                        }
                    }
    
                }
            }
            
            return $data;
        }

        private function preg_value($data)
        {   
            if (preg_match('/[\/\'^£$%&*()}{@#~?><>,|=_+¬-]/', trim($data))){
                return json_encode(array('error' => 'Special characters are not allowed.'));
            }

            if (preg_match('/[0-9]/', trim($data))){
                return json_encode(array('error' => 'Numeric characters are not allowed.'));
            }
            
        }
    }