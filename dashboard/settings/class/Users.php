<?php
include_once __DIR__.'/../../controller/controller.php';
class Users extends Controller
{
    public $filepath;
    public $ip;
    public $userid;
    public $role_id;
    public function __construct()
    {
        parent::__construct();

        $this->ip = $_SERVER['REMOTE_ADDR'];

        if(in_array($this->ip,['::1','localhost']) ){
            $this->filepath = 'admin/uploads/';
        }else{
            $this->filepath = '../console.messaging.com.au/uploads/';
        }

        $this->userid = $_SESSION['messaging_userid'] ?? '';
        $this->role_id = $_SESSION['messaging_role_id'] ?? ''; 

    }

    public function usersList($data)
    {
        $table = 'userdata';
        $key = 'wallet_id';
        $columns = array(
            array('db' => 'wallet_id', 'dt' => 0),
            array('db' => 'firstname', 'dt' => 1, 'formatter' => function ($e, $kk) {
                return $e;
            }),
            array('db' => 'middlename', 'dt' => 2, 'formatter' => function ($e, $kk) {
                return $e;
            }),
            array('db' => 'lastname', 'dt' => 3, 'formatter' => function ($e, $kk) {
                return $e;
            }),
            array('db' => 'email', 'dt' => 4, 'formatter' => function ($e, $kk) {
                return '<a href="mailto:'.$e.'">'.$e.'</a>';
            }),
            array('db' => 'mobile_phone', 'dt' => 5, 'formatter' => function ($e, $kk) {
                return '<a href="tel:'.$e.'">'.$e.'</a>';
            }),
            array('db' => 'user_disabled', 'dt' => 6, 'formatter' => function ($e, $kk) {
                return ($e == 1)?'<span class="badge badge-soft-danger">Disabled</span>':'<span class="badge badge-soft-info">Enabled</span>';
            }),
            array('db' => 'user_locked', 'dt' => 7, 'formatter' => function ($e, $kk) {
                return ($e == 1)?'<span class="badge badge-soft-danger">Locked</span>':'<span class="badge badge-soft-info">Unlocked</span>';
            }),
            array('db' => 'sex', 'dt' => 8, 'formatter' => function ($e, $kk) {
                return ucfirst($e);
            }),
            array('db' => 'status', 'dt' => 9, 'formatter' => function ($e, $kk) {
                if($e == 1){
                    $status = '<span class="badge badge-soft-success">Activated</span>';
                }else if($e == 2){
                    $status = '<span class="badge badge-soft-warning">Pending approval</span>';
                }else if($e == 0){
                    $status = '<span class="badge badge-soft-danger">Pending activation</span>';
                }
                return $status;
            }),
            array('db' => 'created', 'dt' => 10, 'formatter' => function ($e, $kk) {
                return date('j F, Y H:i a', strtotime($e));
            }),
            array('db' => 'wallet_id', 'dt' =>11, 'formatter' => function($e, $kk){
                $user_locked = $this->SelectOne('userdata','wallet_id',$e,'user_locked');
                $user_disabled = $this->SelectOne('userdata','wallet_id',$e,'user_disabled');
                $locked = ($user_locked == 0)?'<li> <a class="dropdown-item remove-item-btn" href="javascript:void(0)" onclick="javascript:AccountLocker(\'' .$e. '\',\'1\')"> <i class="ri-lock-2-line align-bottom me-2 text-muted"></i> Lock </a> </li> ':'<li><a class="dropdown-item edit-item-btn" href="javascript:void(0)" onclick="javascript:AccountLocker(\'' .$e. '\',\'0\')"><i class="ri-lock-unlock-line align-bottom me-2 text-muted"></i> Unlock</a></li> ';

                $disabled = ($user_disabled == 0)?' <li> <a class="dropdown-item remove-item-btn" href="javascript:void(0)" onclick="javascript:AccountAccess(\'' .$e. '\',\'1\')"> <i class=" ri-close-line align-bottom me-2 text-muted"></i> Disable </a> </li> ':'<li> <a class="dropdown-item remove-item-btn" href="javascript:void(0)" onclick="javascript:AccountAccess(\'' .$e. '\',\'0\')"> <i class="ri-check-line align-bottom me-2 text-muted"></i> Enable </a> </li> ';
                
                $action = '';
                if(in_array($this->role_id, [100,200,201])){
                   $action .= '<li> <a class="dropdown-item edit-item-btn" onclick="loadModal(\'user/setup?id=' .$e. '&action=edit\',\'modal_div\')" href="javascript:void(0)"><i class="ri-edit-line align-bottom me-2 text-muted"></i> Edit</a>
                   </li>'; 
                }
                
                $action .= $locked.$disabled;

                return '<td><div class="dropdown d-inline-block"><button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-more-fill align-middle"></i> </button> 
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item edit-item-btn" onclick="loadModal(\'user/profile?id=' .$e. '\',\'modal_div\')" href="javascript:void(0)"><i class="ri-eye-line align-bottom me-2 text-muted"></i> View</a>
                    </li>'.$action.'</ul> </div></td>';
            })
        );

        $filter = " AND role_id ='300'";

        if(isset($data['column']) && $data['column'] != ""){
            $column = $data['column'];
            $value = $data['value'];
            $filter .= " AND $column = '$value'";
        }

        $datatable = new DataTableEngine();
        return $datatable->generateTable($data, $table, $columns, $key, $filter);

    }
    public function pendingLimitUpgradeRequest($data)
    {
        $table = 'userdata';
        $key = 'wallet_id';
        $columns = array(
            array('db' => 'wallet_id', 'dt' => 0),
            array('db' => 'wallet_id', 'dt' => 1, 'formatter' => function ($e, $kk) {
                return  "<a class='btn btn-sm btn-primary mt-2' onclick=\"loadModal('user/profile?id=$e','modal_div')\"  href='javascript:void(0)' data-toggle='modal' data-target='#defaultModalPrimary'>".$e."</a>";

            }),
            array('db' => 'wallet_id', 'dt' => 2, 'formatter' => function ($e, $kk) {
                return  "<a class='btn btn-sm btn-primary mt-2' onclick=\"loadModal('user/view?section=view&id=$e','modal_div')\"  href='javascript:void(0)' data-toggle='modal' data-target='#defaultModalPrimary'>View</a>";

            }),
            array('db' => 'expected_limit', 'dt' => 3, 'formatter' => function ($e, $kk) {
                return 'AUD'.number_format($e,2);
            }),
            array('db' => 'second_level_status', 'dt' => 4, 'formatter' => function ($e, $kk) {
                return '<span class="badge badge-soft-danger">Pending approval</span>';
            }),
            array('db' => 'created', 'dt' => 5, 'formatter' => function ($e, $kk) {
                return date('j F, Y H:i:s', strtotime($e));
            }),
            array('db' => 'wallet_id', 'dt' =>6, 'formatter' => function($e, $kk){
                
                $button = '<li><a class="dropdown-item remove-item-btn" href="javascript:void(0)" onclick="ApproveUpgrade(\'' . $e . '\', \'1\')">
                <i class="ri-check-line align-bottom me-2 text-muted"></i> Approve</a></li><li><a class="dropdown-item remove-item-btn" href="javascript:void(0)" data-toggle="modal" data-target="#defaultModalPrimary"
                onclick="loadModal(\'user/view?section=decline&id=' . $e . '\', \'modal_div\')"><i class="ri-close-line align-bottom me-2 text-muted"></i> Decline</a></li>';

                
                return '<td><div class="dropdown d-inline-block"><button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-more-fill align-middle"></i> </button> 
                <ul class="dropdown-menu dropdown-menu-end"> '.$button.'</ul> </div></td>';
            })
        );

        $filter = " AND second_level_status ='2'";

        $datatable = new DataTableEngine();
        return $datatable->generateTable($data, $table, $columns, $key, $filter);

    }

    public function allBeneficiary()
    {
        // Extract the payload from the URL
        $payload = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

        $selected = '';
        $reciepients = '<div class="myDropdown transactionDropdown" style="    max-height: 299px;overflow: overlay;">';

        $stmt = $this->db_connect("SELECT * FROM transfer_recepients WHERE is_deleted IN (0) AND wallet_id ='{$this->userid}' ORDER BY id DESC LIMIT 50");
        if(is_array($stmt) && count($stmt) > 0){
            
            foreach($stmt as $row){
                if(isset($_REQUEST['account_name']) && $_REQUEST['account_name'] == $row['account_name']){
                    $selected = 'active';
                }

                $reciepients .= '<div class="single-user">
                <div class="left d-flex align-items-center">
                    <div class="img-area">
                        <img src="assets/images/avartar.png" alt="image" style="height:70px">
                    </div>
                    <div class="text-area">
                        <p>'.$row['account_name'].'</p>
                        <span class="mdr">'.$row['bank_name'].': '.$row['account_number'].'</span>
                    </div>
                </div>
                <div class="right">
                    <a href="javascript:void(0)" class="choose-button ' . $row['receipient_code'] . ' '.$selected.'" onclick="select_beneficiary(\'' . $row['receipient_code'] . '\',\''.$payload.'\')" data-id="' . $row['receipient_code'] . '">Choose</a>
                </div>
            </div>';
            }
        }

        $reciepients .= '</div>';

        return $reciepients;
    }

    public function Onboarding($data)
    {
        try {
            $validate = $this->validate($data,
                array('mobile_phone'=>'required','address'=>'required','dob'=>'required','occupation'=>'required','kyc_id'=>'required','card_issued_date' =>'required','card_expiry_date' =>'required','sex'=>'required','state'=>'required','city'=>'required','card_issuer'=>'required'),
                array('mobile_phone'=>'Phone number','address'=>'Address','dob'=>'Date of Birth','occupation'=>'Occupation','kyc_id'=>'Id Number','card_issued_date' =>'Card Issued Date','card_expiry_date' =>'Card Expiry Date','sex'=>'Gender','state'=>'State','city'=>'City','card_issuer'=>'Card Issuer')
            );
            
            if($validate['error']){
                return json_encode(array('response_code'=>20,'response_message'=>$validate['messages'][0]));
            }
            
            $validate_number = $this->SelectOne('userdata','mobile_phone',$data['mobile_phone'],'wallet_id');
            
            if ($validate_number != '' && $validate_number != $_SESSION['messaging_userid']) {
                return json_encode(['response_code' => 20, 'response_message' => 'This phone number is already in use']);
            }

            $validate_id = $this->SelectArr('userdata',['kyc_id','kyc_type'],[$data['kyc_id'],$data['kyc_type']],['wallet_id']);
            if ($validate_id != '' && $validate_id['wallet_id'] != $_SESSION['messaging_userid']) {
                return json_encode(['response_code' => 20, 'response_message' => 'This '.$data['kyc_type'].' is already in use']);
            }

            if($data['occupation'] == 'Others' && $data['others'] == ''){
                return json_encode(['response_code' => 20, 'response_message' => 'Please, specify your occupation']);
            }

            if($data['occupation'] == 'Others' && $data['others'] != ''){
                $data['occupation'] = $data['others'];
            }

            if(isset($_SESSION['kyc_document']) && $_SESSION['kyc_document'] != ""){
                $data['kyc_document'] = $_SESSION['kyc_document'];
            }else{
                $files = json_decode($this->uploadIdDocument($_FILES), true);
                if($files['response_code'] == 20){
                    return json_encode(array('response_code'=>$files['response_code'],'response_message'=>$files['response_message']));
                }

                $data['kyc_document'] = $files['kyc_document'];
            }
 
            $data['status'] = 2;//pending approval; 3 = dclined; 1 = approved; 0= unprofiled;
            if($data['action'] == 'onboarding'){
                $notify = array("notification" => array("2","3","4"));
                $this->setNotification($notify);
            }

            $stmt = $this->Update('userdata',$data,['type','hci-csrf-token-label','filedata','action','PHPSESSID','pageid','others'],['wallet_id' => $_SESSION['messaging_userid']]);
            if($stmt > 0){
                $_SESSION['messaging_mobile_phone'] = $data['mobile_phone'];
                $_SESSION['messaging_gender'] = $data['sex'];
                $_SESSION['messaging_city'] = $data['city'];
                $_SESSION['messaging_state'] = $data['state'];
                $_SESSION['messaging_postcode'] = $data['postcode'];
                $_SESSION['messaging_daily_limit'] = $data['daily_limit'];
                $_SESSION['messaging_kyc_id'] = $data['kyc_id'];
                $_SESSION['messaging_kyc_type'] = $data['kyc_type'];
                $_SESSION['messaging_card_issuer'] = $data['card_issuer'];
                $_SESSION['messaging_issued_date'] = $data['card_issued_date'];
                $_SESSION['messaging_expiry_date'] = $data['card_expiry_date'];
                $_SESSION['messaging_occupation'] = $data['occupation'];
                $_SESSION['messaging_dob'] = $data['dob'];
                $_SESSION['messaging_address'] = trim($data['address']);

                if(isset($_SESSION['messaging_account_status']) && $_SESSION['messaging_account_status'] == 1){

                    $current_data = $this->getCurrentData('userdata', 'wallet_id', $_SESSION['messaging_userid']);
    
                    $fullname = $current_data['firstname'] .' '.$current_data['lastname'];

                    $gender = ($current_data['sex'] == 'male') ? 'his' : 'her';

                    $notify['email'] = 'transactions@messaging.com.au';
                    $notify['message'] = $fullname.' updated '.$gender.' means of identification. Kindly review accordingly.';
                    $notify['subject'] = 'Payment Limit Request';
    
                    $this->notify($notify);
                }

                unset($_SESSION['kyc_document']);

                return json_encode(array('response_code'=>0,'response_message'=>'Your record has been updated.'));
            }else{
                return json_encode(array('response_code'=>20,'response_message'=>'We could not update your record. Please, try again.'));
            }

        } catch (Exception $e) {
            
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() .' on line '.$e->getLine()));

        }
    }
    public function Kyc($data)
    {
        try {

            $data = [
                'payslip' => $_SESSION['payslip'],
                'document' => $_SESSION['utility_document'],
                'type' => $_REQUEST['utility_type'],
                'expected_limit' => $data['expected_limit']
            ];

            $validate = $this->validate($data,
                array('payslip'=>'required','type'=>'required','document'=>'required'),
                array('payslip'=>'Pay slip','type'=>'Document type','document'=>'Supplementary document')
            );
            
            if($validate['error']){
                return json_encode(array('response_code'=>20,'response_message'=>$validate['messages'][0]));
            }

            if(is_array($data['payslip']) && count($data['payslip']) < 3){
                return json_encode(array('response_code'=>20,'response_message'=>'You need to provide your latest 3 pay slips'));
            }

            
            $data['supplementary_document'] = $data['document'];
            $data['supplementary_document_type'] = $data['type'];
            $data['payment_slip'] = implode(",", $data['payslip']);

            $data['second_level_status'] = 2;

            $stmt = $this->Update('userdata',$data,['type','hci-csrf-token-label','filedata','type','payslip','document'],['wallet_id' => $_SESSION['messaging_userid']]);
            if($stmt > 0){
                unset($_SESSION['kyc_document']);
                unset($_SESSION['utility_document']);
                unset($_SESSION['payslip_urls']);

                $_SESSION['messaging_second_level_status'] = 2;

                $current_data = $this->getCurrentData('userdata', 'wallet_id', $_SESSION['messaging_userid']);

                $fullname = $current_data['firstname'] .' '.$current_data['lastname'];
                $notify['email'] = 'transactions@messaging.com.au';
                $notify['message'] = 'You have a new fortnight limit upgrade from '.$fullname.'. Requested amount is AUD' .$current_data['expected_limit'];
                $notify['subject'] = 'Payment Limit Request';

                $this->notify($notify);

                return json_encode(array('response_code'=>0,'response_message'=>'Your record has been updated.'));
            }else{
                return json_encode(array('response_code'=>20,'response_message'=>'We could not update your record. Please, try again.'));
            }

        } catch (Exception $e) {
            
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() .' on line '.$e->getLine()));

        }
    }

    public function processFile($data)
    {
        try {
            $files = $_FILES;
            $data = $_REQUEST;

            switch ($data['section']) {
                case 'kyc_document':
                    $type = 'ID Document';
                    break;
                case 'payslip':
                    $type = 'Pay Slip';
                    break;
                default:
                    $type = 'Supplementary Document';
                    break;
            }

            if (!in_array($files['filedata']['type'], $this->mimeType())) {
                return json_encode(array("response_code" => 20, "response_message" => $files['filedata']['type'] . ' files are not allowed. Only jpg, jpeg, png, docx, doc, and pdf files are allowed'));
            }

            if (empty($files['filedata']['name'])) {
                return json_encode(array("response_code" => 20, "response_message" => "Please, attach your {$type}"));
            }

            if (!file_exists($this->filepath)) {
                mkdir($this->filepath, 0777, true);
            }

            $exist = array_diff(scandir($this->filepath), array('.', '..'));
            $tmpPath = $files['filedata']['tmp_name'];
            $fileName = $files['filedata']['name'];
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);

            if ($data['section'] == 'payslip') {
                $payslipURLs = isset($_SESSION['payslip_urls']) ? $_SESSION['payslip_urls'] : array();
                $payslipCount = count($payslipURLs) + 1;
                $file = "payslip_{$_SESSION['messaging_userid']}_{$payslipCount}.{$extension}";
                array_push($payslipURLs, $this->admin_base_url().'uploads/' . $file);
                $_SESSION['payslip_urls'] = $payslipURLs;
            } else {
                $files = $this->admin_base_url().'uploads/' ."{$data['section']}_{$_SESSION['messaging_userid']}_" . date('dmYhis') . ".{$extension}";
                $file = "{$data['section']}_{$_SESSION['messaging_userid']}_" . date('dmYhis') . ".{$extension}";
            }

            
            $file_path = "{$this->filepath}/{$file}";

            foreach ($exist as $l) {
                if ($file == $l) {
                    unlink("{$this->filepath}/{$l}");
                }
            }

            if (move_uploaded_file($tmpPath, $file_path)) {
                if ($data['section'] == 'payslip') {
                    $_SESSION[$data['section']] = $payslipURLs;
                }else {
                    $_SESSION[$data['section']] =  $files;
                }

                return json_encode(array('response_code' => 0, 'response_message' => $type . ' has been successfully added.'));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Sorry, we could not process your request.'));
            }
        } catch (Exception $e) {
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function uploadIdDocument($data)
    {
        $files = $_FILES;
        $data = $_REQUEST;

        if(!isset($_SESSION['kyc_document'])){
            return json_encode(array("response_code" => 20, "response_message" => 'Please, upload your ID documnet before proceeding.'));
        }

        $file = count($files['filedata']['type']);
        
        for($i = 0; $i < $file; ++$i){
            if (!in_array($files['filedata']['type'][$i], $this->mimeType())) {
                return json_encode(array("response_code" => 20, "response_message" => $files['filedata']['type'][$i] . 'files are not allowed. Only mage files are allowed'));
            }

            if (empty($files['filedata']['name'][$i])) {
                return json_encode(array("response_code" => 20, "response_message" => 'Please, attach your ID documnet'));
            }

            if (!file_exists($this->filepath)) {
                mkdir($this->filepath, 0777);
            }

            $exist = scandir($this->filepath);
            $exist = array_diff(scandir($this->filepath), array('.', '..'));
            $tmpPath = $files['kyc_document']['tmp_name'][$i];
            $fileName = $files['kyc_document']['name'][$i];
            $extension = explode(".", $fileName);
            $file_name = '';
            if ($tmpPath != "") {
                $file = strtolower($data['kyc_document'].'_'.$_SESSION['messaging_userid']).'_'.date('dmYhis'). '.' . $extension[1];
                $file_name .= $this->filepath . $file;

                foreach ($exist as $l) {
                    if ($file == $l) {
                        unlink($this->filepath . $l);
                    }
                }
                
                if (move_uploaded_file($tmpPath, $file_name)) {
                    $_SESSION['kyc_document'] = $this->admin_base_url().'uploads/'.$file_name;
                    
                    return json_encode(array('response_code'=>0,'kyc_document'=>$_SESSION['kyc_document']));
                    
                }else{
                    return json_encode(array('response_code'=>20,'response_message'=>'Sorry, we could not process your documents.'));
                }
            }
        }
        
    }

    public function changePassword($data)
    {
        try{

            $validate = $this->validate($data, 
                ['current_password' => 'required','password' => 'required|min:8', 'cpassword' => 'required|matches:password'],
                ['current_password' => 'Current password','password' => 'Password', 'cpassword' => 'Password']
            );
    
            if($validate['error']){
                return json_encode(['response_code' => 20, 'response_message' => $validate['messages'][0]]);
            }
    
            $wallet_id = $_SESSION['messaging_userid'];
    
            $current_password = $this->SelectOne('userdata','wallet_id',$wallet_id,'password');
    
            if ($current_password != $this->encrypt($data['current_password'])){
                return json_encode(['response_code' => 20, 'response_message' => 'The current password is incorrect']);
            }

            if ($data['current_password'] == $data['password']){
                return json_encode(['response_code' => 20, 'response_message' => 'Your current password should be different from the new password.']);
            }
    
            $update['password'] = $this->encrypt($data['password']);
    
            $stmt = $this->Update('userdata',$update,[],['wallet_id' => $wallet_id]);
            if($stmt > 0) {
                return json_encode(['response_code' => 0, 'response_message' => 'Password has been updated successfully']);
            }else{
                return json_encode(['response_code' => 20, 'response_message' => 'We could not process your request. Please try again.']);
            }
        }catch(Exception $e){
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function ApproveUpgrade($data)
    {
        try{

            $current_data = $this->getCurrentData('userdata', 'wallet_id', $data['id']);
            $stmt = $this->Update('userdata', ['second_level_status' => '1','current_limit'=> $current_data['expected_limit'],'expected_limit'=>''], [], ['wallet_id' => $data['id']]);
            if ($stmt > 0){
                
                $notify['name'] = $current_data['firstname'];
                $notify['email'] = $current_data['email'];
                $notify['message'] = 'Your fortnight limit has been upgraded to AUD' .number_format($current_data['expected_limit'],2);
                $notify['subject'] = 'Payment Limit Request Approval';

                $data = array(
                    'wallet_id' => $data['id'],
                    'second_level_status' => 1
                );
    
                $this->logActivity($current_data, $data, ["table_name" => 'transaction_table', "table_id" => $current_data['transaction_id'], "table_alias" => 'Approved Upgrade Request'], ['action', 'id', 'type', 'hci-csrf-token-label']);
    
                $this->notify($notify);

                return json_encode(array('response_code'=>0,'response_message'=>"Upgrade has been approved successfully"));
            }else{
                return json_encode(array('response_code'=>20,'response_message'=>"Upgrade could not be approved"));
            }

        }catch (Exception $e) {
            echo json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function DeclineUpgrade($data)
    {
        try{

            if(!isset($data['reason_for_declining_approval']) || $data['reason_for_declining_approval'] == ''){
                return json_encode(array('response_code'=>20,'response_message'=>"Please, let us know why you are declining this request."));
            }

            $current_data = $this->getCurrentData('userdata', 'wallet_id', $data['id']);
            $stmt = $this->Update('userdata', ['second_level_status' => 20], [], ['wallet_id' => $data['id']]);
            if ($stmt > 0){
    
                $notify['name'] = $current_data['firstname'];
                $notify['email'] = $current_data['email'];
                $notify['message'] = 'Unfortunately, we could not upgrade your fortnight limit to AUD' .number_format($current_data['expected_limit'],2).' because of the following:';
                $notify['message'] .= '<em>'.$data['reason_for_declining_approval'].'</em>';
                $notify['subject'] = 'Payment Limit Request Declined';

    
                $data = array(
                    'wallet_id' => $data['id'],
                    'second_level_status' => 20,
                    'reason_for_declining_approval' => $data['reason_for_declining_approval']
                );
    
                $this->logActivity($current_data, $data, ["table_name" => 'transaction_table', "table_id" => $current_data['transaction_id'], "table_alias" => 'Approved Upgrade Request'], ['action', 'id', 'type', 'hci-csrf-token-label']);
    
                $this->notify($notify);

                return json_encode(array('response_code'=>0,'response_message'=>"Request has been declined successfully"));
            }else{
                return json_encode(array('response_code'=>20,'response_message'=>"Request could not be declined"));
            }

        }catch (Exception $e) {
            echo json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function ManageAccount($data)
    {
        try{

            $current_data = $this->getCurrentData('userdata', 'wallet_id', $data['wallet_id']);
            $stmt = $this->Update('userdata', ['status' => $data['status']], [], ['wallet_id' => $data['wallet_id']]);
            if ($stmt > 0){
                if($data['status'] == 1){
                    $message = 'Congratulations, your account has been approved.';
                    $alias = 'Account Approval';
                }else{
                    $message = 'Unfortunately, we could not approve your account. Please, cross-check your details and re-submit.';
                    $alias = 'Account Rejected';
                }
    
                $notify['name'] = $current_data['firstname'];
                $notify['email'] = $current_data['email'];
                $notify['message'] = $message;
                $notify['subject'] = $alias;

    
                $data = array(
                    'wallet_id' => $data['id'],
                    'status' => $data['status']
                );
    
                $this->logActivity($current_data, $data, ["table_name" => 'transaction_table', "table_id" => $current_data['transaction_id'], "table_alias" => $alias], ['action', 'id', 'type', 'hci-csrf-token-label','PHPSSID','pageid']);
    
                $this->notify($notify);

                return json_encode(array('response_code'=>0,'response_message'=>"Successful"));
            }else{
                return json_encode(array('response_code'=>20,'response_message'=>"Request could not be processed"));
            }

        }catch (Exception $e) {
            echo json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function notify($data)
    {
        
        $header = $data['subject'];

        $message = "";

        if(isset($data['name']) && $data['name'] != ""){
            $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px'><h5>Hello <b style='text-transform:uppercase;'>".$data['name'].",</b></h5></p>";
        }

        $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px;>".$data['message'].".</p>";
            
        $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px;>Thank you for choosing messaging.</ p>";                    

        $email_data = array(
            "to" => $data['email'],
            "from" => 'noreply@'.$_SERVER['SERVER_NAME'],
            "subject" => $header,
            "message" => $message,
            "sender_name" => 'messaging',
            "logo" => $this->base_url . 'assets/img/10.png',
            "template" => $this->template . 'otp.php',
            "type" => $header,
            "channel" => 'mail'
        );

        $this->notification->channel($email_data);
    }

    public function userProfile($data)
    {
        $details = array();
        $wallet_id = $data['id'];

        if ($wallet_id == ""){
            return $details;
        }
        $daysUntilExpiry = 0;
        $stmt = $this->db_connect("SELECT * FROM userdata WHERE wallet_id = '$wallet_id'");
        if (is_array($stmt) && count($stmt) > 0){

            if(!empty($stmt[0]['card_expiry_date'])){
                $expiryDate = strtotime($stmt[0]['card_expiry_date']); // Convert the expiry date to a Unix timestamp
                $today = strtotime(date('Y-m-d')); // Get today's date as a Unix timestamp

                $daysUntilExpiry = ($expiryDate - $today) / 86400; // Calculate the number of days until expiry
            }

            $text = ($daysUntilExpiry <= 1) ? 'day':'days';

            $details = array(
                'name' => $stmt[0]['firstname'].' '.$stmt[0]['lastname'],
                'email' => $stmt[0]['email'],
                'phone' => $stmt[0]['mobile_phone'],
                'dob' => $stmt[0]['dob'],
                'role' => $stmt[0]['role_name'],
                'country' => $this->SelectOne('countries','id',$stmt[0]['country_id'],'name'),
                'address' => $stmt[0]['address'],
                'city' => $this->SelectOne('cities','id',$stmt[0]['city'],'name'),
                'state' => $this->SelectOne('states','id',$stmt[0]['state'],'name'),
                'joined' => date('F d, Y', strtotime($stmt[0]['created'])),
                'postcode' => $stmt[0]['postcode'],
                'occupation' => $stmt[0]['occupation'],
                'kyc_type' => $stmt[0]['kyc_type'],
                'kyc_id' => $stmt[0]['kyc_id'],
                'kyc_document' => $stmt[0]['kyc_document'],
                'issued_date' => date('F d, Y', strtotime($stmt[0]['card_issued_date'])) ?? '',
                'expiry_date' => date('F d, Y', strtotime($stmt[0]['card_expiry_date'])) ?? '',
                'valid_till' => round($daysUntilExpiry).' '.$text,
                'limit' => $stmt[0]['expected_limit'] ?? '5000',
                'limit_status' => ($stmt[0]['second_level_status'] == 1) ? 'Active' : (($stmt[0]['second_level_status'] == 2) ?'Pending approval': 'N/A'),
                'profile_strength' => $this->profileScore($wallet_id),
                'status' => json_decode($this->CheckKyc($wallet_id),true)['status'],
                'wallet_id' => $wallet_id,
                'supp' => $stmt[0]['supplementary_document'],
                'supp_type' => $stmt[0]['supplementary_document_type'],
                'slip' => $stmt[0]['payment_slip'],
                'sec_kyc_document' => $stmt[0]['sec_kyc_document'],
                'sec_kyc_type' => $stmt[0]['sec_kyc_type']
            );
        }

        return $details;
    }
    
    public function IdCardValidity()
    {
        $stmt = $this->db_connect("SELECT card_expiry_date AS expiry FROM userdata WHERE card_expiry_date != ''");

        if (is_array($stmt) && count($stmt) > 0) {
            foreach ($stmt as $row) {
                $expiryDate = strtotime($row['expiry']); // Convert the expiry date to a Unix timestamp
                $today = strtotime(date('Y-m-d')); // Get today's date as a Unix timestamp

                $daysUntilExpiry = ($expiryDate - $today) / 86400; // Calculate the number of days until expiry

                if ($daysUntilExpiry >= 1 && $daysUntilExpiry <= 10) {
                    // The card will expire in 1 to 10 days, send a notification
                    $id_type = $row['kyc_type'];
                    $id_number = $row['kyc_id'];

                    $day = ($daysUntilExpiry == 1) ? 'day' : 'days';

                    $notify['name'] = $row['firstname'];
                    $notify['email'] = $row['email'];
                    $notify['message'] = 'Your '.$id_type.' with Id number '.$id_number.' will expire in '.$daysUntilExpiry.' '.$day.' from today. ';
                    $notify['message'] .= 'You\'re advised to kindly update your means of identification before the said date in order to continue using our services';
                    $notify['subject'] = $row['kyc_type'].' ';

                    $this->notify($notify);
                }
            }
        }

    }
}