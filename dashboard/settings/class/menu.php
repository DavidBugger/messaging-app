<?php

class Menu extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function generateMenu($role_id)
    {
        $filter = " and menu_id in (select menu_id from menugroup where role_id IN ('$role_id')) ";
        $output = array();
        $sub_menu = $sub_menu_2 = array();
       
        $stmt = $this->db_connect("select * from menu where menu_level IN (0) and status IN (1) $filter order by menu_name asc");
        if($stmt > 0){
            foreach($stmt as $row)
            {
                $menu_id    = $row["menu_id"];
                $parent_id  = $row["parent_id"];
                $menu_level = $row["menu_level"];
                $icon       = $row['menu_icon'];
                $url        = $row["menu_url"];
                $menu_name  = $row["menu_name"];
                
                $stmt_2 = $this->db_connect("select * from menu where parent_id IN ('$menu_id') and parent_id2 in ('#','')  $filter and status IN (1) order by menu_order, menu_name ASC");
                
                $has_sub_menu = ($stmt_2 > 0)?true:false;
                if($stmt_2 > 0){
                    foreach($stmt_2 as $row_1)
                    {
                        $menu_id_1       = $row_1["menu_id"];
                        $menu_url_1      = $row_1["menu_url"];
                        $name_1          = $row_1["menu_name"];
                        $parent_id_1     = $row_1["menu_name"];

                        $sub_menu[]       = array(
                            'menu_id'     => $menu_id_1,
                            'menu_url'    => $menu_url_1,
                            'menu_name'        => $name_1,
                            'parent_id'   => $parent_id_1,
                            'sub_menu_2'  => $sub_menu_2
                        );
                        $sub_menu_2 = array();
                    }
                }
                $output[] = array(
                    'menu_id'      => $menu_id,
                    'menu_name'    => $menu_name,
                    'menu_url'     => $url,
                    'parent_id'    => $parent_id,
                    'menu_level'   => $menu_level,
                    'menu_icon'         => $icon,
                    'has_sub_menu' => $has_sub_menu,
                    'sub_menu'     => $sub_menu
                );
                $sub_menu = array();
            }
        }
        return json_encode(array('response_code'=>0,'data'=>$output));
    }
        
    public function generateParentMenu($role_id,$parent,$position)
    {
        //position = 1 = dashboard 0 = homepage
        $filter = ($position == 1)?" and menu_id in (select menu_id from menugroup where role_id ='$role_id') ":"";
        $output = array();
        $sub_menu = array();
       
        $stmt = $this->db_connect("select * from menu where parent_id='$parent' and parent_id2 in ('','#') and status='0' and area = '$position' $filter order by menu_name asc");
       
        if($stmt > 0){
            foreach($stmt as $row)
            {
                $menu_id    = $row["menu_id"];
                $parent_id  = $row["parent_id"];
                $menu_level = $row["menu_level"];
                $icon       = $row['icon'];
                $url        = $row["menu_url"];
                $menu_name  = $row["menu_name"];
                
                $stmt_2 = $this->db_connect("select * from menu where parent_id2 = '$menu_id' and area = '$position' and status='0' order by menu_order");
                $has_sub_menu = ($stmt_2 > 0)?true:false;
                if($stmt_2 > 0){
                    foreach($stmt_2 as $row_1)
                    {
                        $menu_id_1        = $row_1["menu_id"];
                        $menu_url_1       = $row_1["menu_url"];
                        $name_1             = $row_1["menu_name"];
                        $parent_id_1        = $row_1["parent_id"];

                        $sub_menu[]       = array(
                            'menu_id'     => $menu_id_1,
                            'menu_url'    => $menu_url_1,
                            'name'        => $name_1,
                            'parent_id'   => $parent_id_1
                        );
                    }
                }
                $output[] = array(
                    'menu_id'      => $menu_id,
                    'menu_name'    => $menu_name,
                    'menu_url'     => $url,
                    'parent_id'    => $parent_id,
                    'menu_level'   => $menu_level,
                    'icon'         => $icon,
                    'has_sub_menu' => $has_sub_menu,
                    'sub_menu'     => $sub_menu
                );
                $sub_menu = array();
            }
        }
        return json_encode(array('response_code'=>0,'data'=>$output));
    }
    
    public function saveMenu($data)
    {
        $menu_name    = $data['menu_name'];
        $menu_url     = $data['menu_url'];
        $parent_menu  = $data['parent_id'];
        $parent_icon  = $data['menu_icon'];
        $menu_level   = ($data['parent_id'] == "#")?"0":"1";
        $parent_menu2 = $data['sub_menu_id'];
        $area = $data['menu_position'];
        if($data['action'] == "new"){

            $stmt = $this->runCRUD("insert into menu (menu_name,menu_url,parent_id,parent_id2,menu_level,created,menu_icon) values('$menu_name','$menu_url','$parent_menu','$parent_menu2','$menu_level',now(),'$parent_icon')");
            if($stmt > 0){
                return json_encode(array('response_code'=>0,'response_message'=>'Menu has been created successfully'));
            }else {
                return json_encode(array('response_code'=>20,'response_message'=>'Menu could not be created'));
            }
        }else{
            
            $menu_id      = $data['id'];
            $stmt = $this->runCRUD("UPDATE menu SET parent_id2='$parent_menu2', menu_name = '$menu_name', menu_url='$menu_url', parent_id ='$parent_menu', menu_level='$menu_level',menu_icon = '$parent_icon' WHERE menu_id = '$menu_id'");
            if($stmt > 0){
               return json_encode(array('response_code'=>0,'response_message'=>'Menu has been successfully updated.'));
               
            }else{
                return json_encode(array('response_code'=>20,'response_message'=>'No update was made'));
            }
        }
        
        
    }
    public function genMenuId()
    {
        $stmt    = $this->db_connect("select max(menu_id)+1 as maximum from menu")[0];
        
        return (!empty($stmt['maximum']))?$stmt['maximum']:'001';
    }
    public function loadParentMenu($data)
    {
        $stmt    = $this->db_connect("SELECT * FROM menu WHERE parent_id = '#'");

        if($stmt > 0){
            $data = array();
            foreach($stmt as $key => $row)
            {
                $data[$key] = array($row['menu_id'],$row['menu_name']);
            }
            return json_encode(array('response_code'=>0,'data'=>$data));

        }
        else{
            return json_encode(array('response_code'=>20,'response_message'=>'No available menu'));
        }
        
    }
    public function loadSubmenu($data)
    {
        $stmt    = $this->db_connect("SELECT * FROM menu WHERE parent_id != '#' AND parent_id2 ='#'");

        if($stmt > 0){
            $data = array();
            foreach($stmt as $key => $row)
            {
                $data[$key] = array($row['menu_id'],$row['menu_name']);
            }
            return json_encode(array('response_code'=>0,'data'=>$data));

        }
        else{
            return json_encode(array('response_code'=>20,'response_message'=>'No available menu'));
        }
        
    }
    
    public function deleteMenu($data)
    {
        try{            
            $stmt = $this->runCRUD("UPDATE menu SET `status`='0' WHERE menu_id = '".$data['menu_id']."'");
            $stmt = $this->runCRUD("DELETE FROM menugroup WHERE menu_id = '".$data['menu_id']."'");
            if($stmt > 0){
                return json_encode(array('response_code'=>0,'response_message'=>"Record has been deleted successfully"));
            }else{
                return json_encode(array('response_code'=>20,'response_message'=>"Record could not be deleted."));
            }

        }catch (Exception $e) {
           
            echo json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function ManageMenu($data)
    {
        try{
           
            if ($data['status'] == 1){
                $type = 'enabled';
            }else{
                $type = 'disabled';
            }

            $stmt = $this->runCRUD("UPDATE menu SET `status`='".$data['status']."' WHERE menu_id = '".$data['menu_id']."'");
            if($stmt > 0){
                return json_encode(array('response_code'=>0,'response_message'=>"Record has been ".$type." successfully"));
            }else{
                return json_encode(array('response_code'=>20,'response_message'=>"Record could not be ".$type));
            }

        }catch (Exception $e) {
            
            echo json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    
    public function menuList($data)
    {
        // Define the database table and columns
        $table = 'menu';
        $key = 'menu_id';
        $columns = array(
            array('db' => 'menu_id', 'dt' => 0),
            array('db' => 'menu_name', 'dt' => 1),
            array('db' => 'menu_url', 'dt' => 2, 'formatter' => function ($e, $kk) {
                return $e;
            }),
            array('db' => 'parent_id', 'dt' => 3, 'formatter' => function ($e, $kk) {
                return ($e == '#')?'Parent Menu':$this->SelectOne('menu','menu_id',$e,'menu_name');
            }),
            array('db' => 'menu_icon', 'dt' => 4, 'formatter' => function ($e, $kk) {
                return '<i class="'.$e.'"></i>';
            }),
            array('db' => 'status', 'dt' => 5, 'formatter' => function ($e, $kk) {
                return ($e == 1)?'<span class="badge badge-soft-success">Active</span>':'<span class="badge badge-soft-danger">Inactive</span>';
            }),
            array('db' => 'created', 'dt' => 6, 'formatter' => function ($e, $kk) {
                return date('j F, Y H:i:s', strtotime($e));
            }),
            array('db' => 'menu_id', 'dt' =>7, 'formatter'=> function($e, $kk){
                $status = $this->SelectOne('menu','menu_id',$e,'status');

                $status = ($status == 1)?' <li> <a class="dropdown-item remove-item-btn" href="javascript:void(0)"  onclick="javascript:ManageMenu(\'' .$e. '\',\'0\')"> <i class=" ri-close-line align-bottom me-2 text-muted"></i> Disable </a> </li> ':'<li> <a class="dropdown-item remove-item-btn" href="javascript:void(0)"  onclick="javascript:ManageMenu(\'' .$e. '\',\'1\')"> <i class="ri-check-line align-bottom me-2 text-muted"></i> Enable </a> </li> ';
                
                return '<td><div class="dropdown d-inline-block"><button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-more-fill align-middle"></i> </button> <ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item edit-item-btn" href="javascript:void(0)" onclick="javascript:getpage(\'menu/setup?id='.$e.'&action=edit\',\'page\')"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit </a></li> '.$status.'<li> <a class="dropdown-item remove-item-btn" href="javascript:void(0)"   onclick="javascript:DeleteMenu(\'' .$e. '\')"> <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete </a> </li> </ul> </div> </td>';

            })
        );

        $filter = "";

        $datatable = new DataTableEngine();
        return $datatable->generateTable($data, $table, $columns, $key, $filter);


    }
    public function loadMenus($data)
    {
        $visible = $this->visibleMenus($data);
        $invisible = $this->inVisibleMenus($data);
        return json_encode(array('response_code'=>0,'response_message'=>'Menu has been created successfully','menu'=>$visible.$invisible));
    }
    
    private function visibleMenus($data)
    {
        $role_id = $data['role_id'];
        $stmt     = $this->db_connect("SELECT menu_id,menu_name FROM menu WHERE menu_id IN (SELECT menu_id FROM menugroup WHERE role_id = '$role_id') order by menu_name");
       
        $visible = '';
        if($stmt > 0){
            foreach($stmt as $row){
                $visible .= '<option selected="" value="'.$row['menu_id'].'">'.$row['menu_name'].'</option>';
            }
        }
        
        return $visible;
    }
    
    private function inVisibleMenus($data)
    {
        $role_id = $data['role_id'];
        $stmt = $this->db_connect("SELECT menu_id,menu_name FROM menu WHERE menu_id NOT IN (SELECT menu_id FROM menugroup WHERE role_id = '$role_id') order by menu_name");
        $invisible = '';
        if($stmt > 0){
            foreach($stmt as $row){
                $invisible .= '<option  value="'.$row['menu_id'].'">'.$row['menu_name'].'</option>';
            }
        }
        return $invisible;
    }

    public function saveMenuGroup($data)
    {
        if($data['role_id'] == ""){
            return json_encode(array('response_code'=>20,'response_message'=>"Please, select the role you want to assign the menu to")); 
        }

        $role_id = $data['role_id'];
        $stmt = $this->runCRUD("DELETE FROM menugroup WHERE role_id = '$role_id'");
        if(is_array($data['menus']) && sizeof($data['menus']) > 0){
            foreach($data['menus'] as $value){
                $stmt = $this->runCRUD("INSERT INTO menugroup (role_id,menu_id) VALUES('$role_id','$value')");
            }

            if($stmt > 0){
                return json_encode(array('response_code'=>0,'response_message'=>"Menu has been successfully assigned to {$this->SelectOne('role','role_id',$role_id,'role_name')}")); 

            }else{
                return json_encode(array('response_code'=>20,'response_message'=>"Menu could not be assigned to {$this->SelectOne('role','role_id',$role_id,'role_name')}")); 

            }
        }else{
            return json_encode(array('response_code'=>20,'response_message'=>"Please, select at least 1 menu")); 
 
        }
    }

}