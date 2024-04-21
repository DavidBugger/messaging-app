<?php
@session_start();
ini_set('display_errors', 1);
error_reporting(E_ERROR);
error_reporting(E_ERROR | E_ALL & ~E_NOTICE);

include_once (__DIR__.'../../model/model.php');
// include_once (__DIR__.'/boot.php');

class Controller extends Model
{
    public $current_date;
    public $logfile;
    public $path;
    public $error_msg;
    public $base_url;
    public $csrf;
    public $csrfToken;
    public $charges;
    public $user;
    public $ip;

    public function __construct()
    {
        parent::__construct();

        $this->ip = $_SERVER['REMOTE_ADDR'];
        if (in_array($this->ip, ['localhost', '::1'])) {
            $this->root = $_SERVER['DOCUMENT_ROOT'] . '/messaging/';
            $this->base_url = 'http://localhost/messaging/';
        } else {
            $this->root = $_SERVER['DOCUMENT_ROOT'] . '/';
            $this->base_url = $_SERVER['REQUEST_SCHEME'] . '://messaging.com.au/'; //or you hardcode your domain name here
            // $this->base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/'; //or you hardcode your domain name here
        }

        $this->csrf = new \HCI\SecurityService\securityService();
        $this->csrfToken  = $this->csrf->getCSRFToken();

        $this->current_date = date('Y-m-d');
        $this->logfile = $this->base_url() . 'logger/';
        if (!file_exists($this->logfile)) :
            mkdir($this->logfile);
        endif;

        $this->path = $this->base_url() . 'uploads/'; // specified path for file uploads
        if (!file_exists($this->path)) :
            mkdir($this->path);
        endif;

        $this->charges = $this->SelectOne('parameter', 'parameter_name', 'foreign_charges', 'parameter_value');

        if (isset($_SESSION['messaging_firstname'])) {
            $this->user = $_SESSION['messaging_firstname'];
        }
    }
    public function base_url()
    {
        if (in_array($this->ip, ['localhost', '::1'])) {
            $base = 'http://localhost/messaging/';
        } else {
            $base = $_SERVER['REQUEST_SCHEME'] . '://messaging.com.au/';
            // $base = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/';
        }

        return $base;
    }
    public function admin_base_url()
    {
        if (in_array($this->ip, ['localhost', '::1'])) {
            $base = 'http://localhost/messaging/admin/';
        } else {
            $base = $_SERVER['REQUEST_SCHEME'] . '://console.messaging.com.au/';
        }

        return $base;
    }
    public function Cookie()
    {
        header("Set-Cookie: Carparts=" . base64_encode(openssl_random_pseudo_bytes(32)) . "; Secure;SameSite=none");
        header("Set-Cookie: Carparts=" . base64_encode(openssl_random_pseudo_bytes(32)) . "; HttpOnly;SameSite=none");
        header("Set-Cookie: SSID=" . $this->csrfToken . "; HttpOnly;SameSite=none");
        header("Set-Cookie: SSID=" . $this->csrfToken . "; Secure;SameSite=none");
    }
    public function integrityHash($data)
    {

        $app_local_link = $this->getOne("parameter", "parameter_name", "site_local_assets_url", "parameter_value") . $data;
        $app_live_link = $this->getOne("parameter", "parameter_name", "site_live_assets_url", "parameter_value") . $data;
        $link =  (in_array($this->ip, ['localhost', '::1'])) ? $app_local_link : $app_live_link;

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $link);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'messaging');
        $data =  base64_encode(hash_file("sha256", curl_exec($curl_handle), true));
        curl_close($curl_handle);


        return $data;
    }
    public function getOne($a, $b, $c, $d)
    {
        try {
            return $this->SelectOne($a, $b, $c, $d);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function autoLoader($data)
    {
        $type = $data['type'];
        $operation = explode("::", $type);
    
        
        // Getting data for the class method
        $params[] = $data;

        $stmt = json_decode($this->GrantAccess(), true);
        if ($stmt['response_code'] == 20) {
            return json_encode(array('response_code' => $stmt['response_code'], 'response_message' => $stmt['response_message']));
        }

        // Calling the method of the class
        return $this->callClassMethod($operation[0], $operation[1], $params);
    }

    public function GrantAccess()
    {
        include_once __DIR__ . '../../settings/class/Access_control.php';
        $access = new Access_control();

        return $access->GrantPermission();
    }

    private function callClassMethod($className, $methodName, $params)
    {
        if (class_exists($className)) {
            $instance = new $className();

            if (method_exists($instance, $methodName)) {
                return call_user_func_array(array($instance, $methodName), $params);
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => "Error: Method '$methodName' does not exist in class '$className'."));
            }
        } else {
            return json_encode(array('response_code' => 20, 'response_message' => "Error: Class '$className' does not exist."));
        }
    }
    public function secondLayerLogin($data)
    {
        try {

            return $this->mfa($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function time_of_day()
    {
        /* This sets the $time variable to the current hour in the 24 hour clock format */
        $time = date("H");
        /* Set the $timezone variable to become the current timezone */
        $timezone = date("e");
        /* If the time is less than 1200 hours, show good morning */
        if ($time < "12") {
            $greetings = "Good morning, {$this->user}!";
        } else
            /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
            if ($time >= "12" && $time < "17") {
                $greetings = "Good afternoon, {$this->user}!";
            } else
                /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
                if ($time >= "17" && $time < "19") {
                    $greetings = "Good evening, {$this->user}!";
                } else
                    /* Finally, show good night if the time is greater than or equal to 1900 hours */
                    if ($time >= "19") {
                        // $greetings = "Good night";
                        $greetings = "Good evening, {$this->user}!";
                    }

        return $greetings;
    }
    public function login($data)
    {
        try {

            $validate = $this->validate(
                $data,
                array('username' => 'required', 'password' => 'required'),
                array('username' => 'Username', 'password' => 'Password')
            );

            if (!$validate['error']) {
                return $this->access($data);
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function register($data)
    
    {

     
        try {



            $validate = $this->validate(
                $data,
                array('email' => 'required|email|unique:userdata.email', 'password' => 'required|min:8|matches:confirm_password', 'country_id' => 'required'),
                array('email' => 'Email Address', 'password' => 'Password', 'confirm_password' => 'Password', 'country_id' => 'Country')
            );

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $validate['messages'][0] = 'Invalid email address';
                $validate['error'] = true;
            }

            if (!$validate['error']) {

                // if (!isset($data['terms'])) {
                //     return json_encode(array('response_code' => 20, 'response_message' => 'You have not accepted our Terms & Conditions of service.'));
                // }

                return $this->createAccount($data);
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    // this method helps you manage all category-related issues [add, edit, disable, enable]
    public function saveMenu($data)
    {
        try {
            include_once __DIR__ . '/../settings/class/menu.php';
            $menu = new Menu();
            $action = $data['action'];
            if ($action == 'new') :
                $auth = $this->validate(
                    $data,
                    array(
                        'menu_name' => 'required|unique:menu.menu_name', 'menu_url' => 'required', 'parent_id' => 'required', 'menu_icon' => 'required'
                    ),
                    array(
                        'menu_name' => 'Menu Name', 'menu_url' => 'Menu URL', 'parent_id' => 'Parent Menu', 'menu_icon' => 'Menu Icon'
                    )
                );
                if (!$auth['error']) :
                    return $menu->saveMenu($data);
                else :
                    return json_encode(array('response_code' => 20, "response_message" => $auth['messages'][0]));
                endif;
            elseif ($action == 'edit') :
                $auth = $this->validate(
                    $data,
                    array(
                        'menu_name' => 'required',
                        'menu_url' => 'required',
                        'parent_id' => 'required',
                        'menu_icon' => 'required'
                    ),
                    array(
                        'menu_name' => 'Menu Name',
                        'menu_url' => 'Menu URL',
                        'parent_id' => 'Parent Menu',
                        'menu_icon' => 'Menu Icon'
                    )
                );
                if (!$auth['error']) :
                    return $menu->saveMenu($data);
                else :
                    return json_encode(array('response_code' => 20, "response_message" => $auth['messages'][0]));
                endif;
            elseif ($action == 'delete') :
                return $menu->deleteMenu($data);

            endif;
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function saveRole($data)
    {
        try {
            include_once __DIR__ . '/../settings/class/role.php';
            $role = new Role();
            $action = $data['action'];
            if ($action == 'new') :
                $auth = $this->validate(
                    $data,
                    array(
                        'role_name' => 'required|unique:role.role_name', 'role_enabled' => 'required|int'
                    ),
                    array('role_name' => 'Role Name', 'role_enabled' => 'Role Status')
                );
                if (!$auth['error']) :
                    return $role->saveRole($data);
                else :
                    return json_encode(array('response_code' => 20, "response_message" => $auth['messages'][0]));
                endif;
            elseif ($action == 'edit') :
                $auth = $this->validate(
                    $data,
                    array(
                        'role_name' => 'required', 'role_enabled' => 'required|int'
                    ),
                    array('role_name' => 'Role Name', 'role_enabled' => 'Role Status')
                );
                if (!$auth['error']) :
                    return $role->saveRole($data);
                else :
                    return json_encode(array('response_code' => 20, "response_message" => $auth['messages'][0]));
                endif;
            elseif ($action == 'role-action') :
                return $role->saveRole($data);
            else :
                return $role->roleList($data);
            endif;
        } catch (Exception $e) {

            echo json_encode(array('response_code' => 0, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    // public function Converter($data)
    // {
    //     try {
    //         include_once __DIR__ . '/../settings/class/Exchange_rate.php';
    //         $rate = new Exchange_rate();

    //         $stmt = json_decode($rate->doConversion($data), true);

    //         if ($stmt['response_code'] == 20) {
    //             return json_encode(array('response_code' => 20, 'response_message' => $stmt['response_message']));
    //         } else {

    //             return json_encode(array('response_code' => 0, 'amount' => $stmt['data']['amount'], 'info' => '1 ' . $stmt['data']['source'] . ' = ' . $stmt['data']['rate'] . ' ' . $stmt['data']['destination'], 'fee' => $stmt['data']['fee'], 'source' => $stmt['data']['source'], 'destination' => $stmt['data']['destination'], 'total_send' => $stmt['data']['total_send'], 'time' => $stmt['data']['time'], 'rate' => $stmt['data']['rate'],'default' =>$stmt['data']['default']));
    //         }
    //     } catch (Exception $e) {

    //         return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
    //     }
    // }
    // public function getBanks($data)
    // {
    //     try {
    //         include_once __DIR__ . '/../settings/class/Exchange_rate.php';
    //         $rate = new Exchange_rate();

    //         return $rate->fetchBanks($data);
    //     } catch (Exception $e) {

    //         return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
    //     }
    // }

    public function myNotificationAlerts()
    {
        $stmt = $this->conn->prepare("SELECT subscription_id FROM subscription_list WHERE wallet_id ='" . $_SESSION['messaging_userid'] . "'");
        $stmt->execute();
        $subscriptions = array();
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $key => $value) {
                $subscriptions[] = $value['subscription_id'];
            }
        }

        return array_values($subscriptions);
    }
    // public function saveRate($data)
    // {
    //     try {
    //         include_once __DIR__ . '/../settings/class/Exchange_rate.php';
    //         $rate = new Exchange_rate();
    //         $action = $data['action'];
    //         if ($action == 'new') :
    //             $auth = $this->validate(
    //                 $data,
    //                 array('source_rate' => 'required', 'source_currency' => 'required', 'destination_rate' => 'required', 'destination_currency' => 'required'),
    //                 array('source_rate' => 'Source Rate', 'source_currency' => 'Source Currency', 'destination_rate' => 'Destination Rate', 'destination_currency' => 'Destination Currency')
    //             );
    //             if (!$auth['error']) :
    //                 return $rate->saveRate($data);
    //             else :
    //                 return json_encode(array('response_code' => 20, "response_message" => $auth['messages'][0]));
    //             endif;
    //         elseif ($action == 'edit') :
    //             $auth = $this->validate(
    //                 $data,
    //                 array('source_rate' => 'required', 'source_currency' => 'required', 'destination_rate' => 'required', 'destination_currency' => 'required'),
    //                 array('source_rate' => 'Source Rate', 'source_currency' => 'Source Currency', 'destination_rate' => 'Destination Rate', 'destination_currency' => 'Destination Currency')
    //             );
    //             if (!$auth['error']) :
    //                 return $rate->saveRate($data);
    //             else :
    //                 return json_encode(array('response_code' => 20, "response_message" => $auth['messages'][0]));
    //             endif;
    //         elseif ($action == 'role-action') :
    //             return $role->saveRole($data);
    //         else :
    //             return $role->roleList($data);
    //         endif;
    //     } catch (Exception $e) {

    //         echo json_encode(array('response_code' => 0, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
    //     }
    // }

    public function menuList($data)
    {
        try {
            include_once __DIR__ . '/../settings/class/menu.php';
            $menu = new Menu();

            return $menu->menuList($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function roleList()
    {
        try {
            include_once __DIR__ . '/../settings/class/role.php';
            $role = new Role();

            return $role->roleLists($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    // public function RateList($data)
    // {
    //     try {
    //         include_once __DIR__ . '/../settings/class/Exchange_rate.php';
    //         $rate = new Exchange_rate();

    //         return $rate->RateLists($data);
    //     } catch (Exception $e) {

    //         return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
    //     }
    // }
    // public function loadRateCountry()
    // {
    //     try {
    //         include_once __DIR__ . '/../settings/class/Exchange_rate.php';
    //         $rate = new Exchange_rate();

    //         return $rate->loadCountry();
    //     } catch (Exception $e) {

    //         return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
    //     }
    // }

    public function loadMenus($data)
    {
        try {
            include_once __DIR__ . '/../settings/class/menu.php';
            $menu = new Menu();

            return $menu->loadMenus($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function loadParentmenu($data)
    {
        try {
            include_once __DIR__ . '/../settings/class/menu.php';
            $menu = new Menu();

            return $menu->loadParentmenu($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function generateMenu($data)
    {
        try {
            include_once __DIR__ . '/../settings/class/menu.php';
            $menu = new Menu();

            return $menu->generateMenu($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function loadSubmenu($data)
    {
        try {
            include_once __DIR__ . '/../settings/class/menu.php';
            $menu = new Menu();

            return $menu->loadSubmenu($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function saveMenuGroup($data)
    {
        try {
            include_once __DIR__ . '/../settings/class/menu.php';
            $menu = new Menu();

            return $menu->saveMenuGroup($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    // public function saveReceivingCountry($data)
    // {
    //     try {
    //         include_once __DIR__ . '/../settings/class/Exchange_rate.php';
    //         $rate = new Exchange_rate();

    //         return $rate->saveReceivingCountries($data);
    //     } catch (Exception $e) {

    //         return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
    //     }
    // }
    // public function loadVisibleCountry()
    // {
    //     try {
    //         include_once __DIR__ . '/../settings/class/Exchange_rate.php';
    //         $rate = new Exchange_rate();

    //         return $rate->fetchCountry();
    //     } catch (Exception $e) {

    //         return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
    //     }
    // }
    // public function loadReceivingCountries()
    // {
    //     try {
    //         include_once __DIR__ . '/../settings/class/Exchange_rate.php';
    //         $rate = new Exchange_rate();

    //         return $rate->getReceivingCountries();
    //     } catch (Exception $e) {

    //         return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
    //     }
    // }

    // this method handles all sales reports [paid, queued, sold, available] operations
    public function getChart($data)
    {
        try {

            return $this->Chart($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 0, 'response_message' => 'Error: ' . $e->getMessage() . ' on line: ' . $e->getLine()));
        }
    }

    // public function requestpasswordLink($data)
    // {
    //     try {
    //         return $this->passwordLink($data);
    //     } catch (Exception $e) {

    //         return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
    //     }
    // }
    public function validatePassword($data)
    {
        try {
            return $this->validatePasswordLink($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function resetPassword($data)
    {
        try {
            $validate = $this->validate(
                $data,
                array('password' => 'required|min:8', 'cpassword' => 'required|min:8|matches:password'),
                array('password' => 'Password', 'cpassword' => 'Password')
            );

            $regex = $this->validateUserPassword($data['password']);

            if ($regex != 1) {
                $validate['error'] = true;
                $validate['messages'][0] = $regex;
            }

            if (!$validate['error']) {
                return $this->completeResetPassword($data);
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function resolveWalletId($data)
    {
        try {
            $validate = $this->validate($data, array('account_no' => 'required'), array('account_no' => 'Wallet Id'));
            if (!$validate['error']) {
                return $this->getWalletAccountName($data);
            } else {
                return json_encode(array('response_code' => 0, 'response_message' => $validate['messages'][0]));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function SelectDistinct($table, $colum, $array)
    {
        return $this->SelectDistinct($table, $colum, $array);
    }

    public function userList()
    {
        try {
            return $this->userList();
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }


    public function contact($data)
    {
        try {
            $validate = $this->validate(
                $data,
                array('name' => 'required', 'email' => 'required', 'subject' => 'required', 'message' => 'required'),
                array('name' => 'Name', 'email' => 'Email', 'subject' => 'Subject', 'message' => 'Message')
            );

            if (!$validate['error']) {
                return $this->contactUs($data);
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }
        } catch (Exception $e) {
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }


    public function createUser($data)
    {
        try {
            $validate = $this->validate(
                $data,
                array('firstname' => 'required', 'lastname' => 'required', 'email' => 'required', 'mobile_phone' => 'required', 'role_id' => 'required'),
                array('firstname' => 'Firstname', 'lastname' => 'Lastname', 'email' => 'Email', 'mobile_phone' => 'Contact No.', 'role_id' => 'Role Name')
            );

            if ($validate['error']) {
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }

            return $this->createUserAcct($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 0, 'response_message' => 'Error: ' . $e->getMessage() . ' on line: ' . $e->getLine()));
        }
    }

    public function updateProfile($data)
    {
        try {
            $validate = $this->validate(
                $data,
                array('firstname' => 'required', 'lastname' => 'required', 'mobile_phone' => 'required', 'sex' => 'required'),
                array('firstname' => 'Firstname', 'lastname' => 'Lastname', 'mobile_phone' => 'Mobile Phone', 'sex' => 'Gender')
            );

            if (!$validate['error']) {
                return $this->profile($data);
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function generateOTP($data)
    {
        try {
            return $this->generateOTP($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function getBankName($data)
    {
        return json_encode(array('bank_name' => $this->getOne('banks', 'bank_code', $data['id'], 'bank_name')));
    }


    public function verify($data)
    {
        try {
            return $this->verify($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function confirm2FA($data)
    {
        try {
            return $this->validate2FA($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function generateAuthPIN($data)
    {
        try {
            return $this->generate2FAPIN($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function updateAddress($data)
    {
        try {
            return $this->updateAddress($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function changePassword($data)
    {
        try {

            if (isset($data['usage_channel']) && $data['usage_channel'] != "") {
                $data['email'] = str_replace("'", '', $data['email'][0]);
                $data['id'] = str_replace("'", '', $data['id'][0]);
                $data['current-password'] = isset($data['current-password']) ? str_replace("'", '', $data['current-password'][0]) : '';
                $data['new-password'] = isset($data['new-password']) ? str_replace("'", '', $data['new-password'][0]) : '';
                $data['confirm-password'] = isset($data['confirm-password']) ? str_replace("'", '', $data['confirm-password'][0]) : '';
            }

            $validation = $this->validate(
                $data,
                array(
                    'current-password' => 'required',
                    'new-password' => 'required|min:8',
                    'confirm-password' => 'required|matches:new-password'
                ),
                array('confirm-password' => 'Password', 'new-password' => 'Password', 'current-password' => 'Current Password')
            );

            // $regex = $this->validateUserPassword($data['new-password']);

            // if($regex != 1){
            //     $validation['error'] = true;
            //     $validation['messages'][0] = $regex;
            // }

            if (!$validation['error']) {
                return $this->completeChangePassword($data);
            } else {
                return json_encode(array("response_code" => 20, "response_message" => $validation['messages'][0]));
            }
        } catch (Exception $e) {
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function validatePIN()
    {
        try {
            $get_pin = $this->SelectOne('userdata', 'wallet_id', $_SESSION['messaging_userid'], 'transaction_pin');
            return ($get_pin == "") ? json_encode(
                array('response_code' => 20, 'response_message' => 1) //'Set up transaction PIN'
            ) : json_encode(array('response_code' => 0, 'response_message' => 0)); //'Validate for transaction'
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function transactionPin($data)
    {
        try {

            if (isset($data['pin-setup']) && $data['pin-setup'] == 1) {
                $validate = $this->validate($data, array('pin-1' => 'required|matches:pin-2'), array('pin-1' => 'Transaction PIN', 'pin-2' => 'Transaction PIN'));
                if (!$validate['error']) {
                    return $this->manageTransactionPIN($data);
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
                }
            } else {
                $stmt = json_decode($this->manageTransactionPIN($data), true);
                return json_encode(array('response_code' => $stmt['response_code'], 'response_message' => $stmt['response_message']));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function walletBeneficiary($data)
    {
        try {
            $validate = $this->validate($data, array('account_no' => 'required|unique:wallet_beneficiaries.source_wallet', 'name' => 'required'), array('account_no' => 'Beneficiary Wallet Id', 'name' => 'Beneficiary Wallet Name'));
            if (!$validate['error']) {
                return $this->walletBeneficiaries($data);
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function deleteBeneficiary($data)
    {
        try {
            return $this->deleteBeneficiaries($data);
        } catch (Exception $e) {
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function validatePayout($data)
    {
        try {
            if ($data['section'] == 'wallet') {
                $validate = $this->validate(
                    $data,
                    array('wallet-account_id' => 'required', 'wallet-account_name_1' => 'required', 'amount' => 'required'),
                    array('wallet-account_id' => 'Wallet ID', 'wallet-account_name_1' => 'Account Name', 'amount' => 'Transaction Amount')
                );
                if (!$validate['error']) {
                    return json_encode(array('response_code' => 0, 'response_message' => 'Proceed to confirmation'));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
                }
            } else {
                $validate = $this->validate(
                    $data,
                    array('bank_code' => 'required', 'account_no' => 'required', 'account_name_1' => 'required', 'transfer-amount' => 'required'),
                    array('bank_code' => 'Beneficiary Bank', 'account_no' => 'Beneficiary Account Number', 'account_name_1' => 'required', 'transfer-amount' => 'Transfer Amount')
                );
                if (!$validate['error']) {
                    return json_encode(array('response_code' => 0, 'response_message' => 'Proceed to confirmation'));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
                }
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function manageAccountDetails($data)
    {
        try {

            $validate = $this->validate($data, array('bank_code' => 'required', 'account_no' => 'required', 'account_name' => 'required'), array('bank_code' => 'Bank name', 'account_no' => 'Account number', 'account_name' => 'Account name'));
            if (!$validate['error']) {
                return $this->create_bankDetails($data);
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function SecurityQuestion($data)
    {
        try {
            $validate = $this->validate(
                $data,
                array('question' => 'required', 'answer' => 'required'),
                array('question' => 'Security question', 'answer' => 'Answer')
            );

            if ($validate['error']) {
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }

            return json_encode(json_decode($this->setSecurityQuestions($data), true));
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function setNotifications($data)
    {
        try {
            $validate = $this->validate(
                $data,
                array('notification' => 'required'),
                array('notification' => 'Notification')
            );

            if ($validate['error']) {
                if ($validate['messages'][0] == 'Notification field is required.') {
                    $validate['messages'][0] = 'Please, enable at least 1 notification alert.';
                }
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }

            return json_encode(json_decode($this->setNotification($data), true));
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function supportedCurrency()
    {
        try {
            return json_encode(json_decode($this->getSupportedCurrencies(), true));
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }


    public function getMyBanks()
    {
        try {

            return json_encode(json_decode($this->myBanks(), true));
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function getBeneficiary($data)
    {
        try {
            $validate = $this->validate($data, array('bank_code' => 'required'), array('bank_code' => 'Bank name'));
            if (!$validate['error']) {
                return json_encode(json_decode($this->myBanksdetails($data), true));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function timeZone($data)
    {
        try {
            $validate = $this->validate($data, array('timezone_id' => 'required'), array('timezone_id' => 'Timezone'));
            if (!$validate['error']) {
                return json_encode(json_decode($this->updateTimeZone($data), true));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => $validate['mesages'][0]));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function mobile_phone($data)
    {
        try {
            $validate = $this->validate($data, array('country_code' => 'required', 'mobile_phone' => 'required'), array('country_code' => 'Country code', 'mobile_phone' => 'Mobile number'));
            if (!$validate['error']) {
                return json_encode(json_decode($this->updateMobilePhone($data), true));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => $validate['mesages'][0]));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function personalDetails($data)
    {
        try {
            $validate = $this->validate(
                $data,
                array('firstname' => 'required', 'lastname' => 'required', 'country_id' => 'required', 'state' => 'required', 'address' => 'required','city' => 'required','postcode' => 'required'),
                array('firstname' => 'First name code', 'lastname' => 'Last name', 'country_id' => 'Country', 'state' => 'State', 'address' => 'Address','city' => 'City','postcode' => 'Postcode')
            );
            if (!$validate['error']) {
                return json_encode(json_decode($this->updatePersonalDetails($data), true));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function deleteBankAccount($data)
    {
        try {
            return json_encode(json_decode($this->deleteBankAccountNumber($data), true));
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function deleteCard($data)
    {
        try {
            return json_encode(json_decode($this->deleteCardDetails($data), true));
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function getSystemBalance()
    {
        try {
            return $this->systemBalance();
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function doReversal()
    {
        try {
            return $this->transactionReversal();
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function getActiveSession()
    {
        if ((isset($_SESSION['messaging_username']) && $_SESSION['messaging_username'] != "")) {
            return json_encode(array('response_code' => 0));
        } else {
            return json_encode(array('response_code' => 20));
        }
    }

    // public function resolveAccountNumber($data)
    // {
    //     include_once __DIR__ . '/../settings/class/Exchange_rate.php';
    //     $rate = new Exchange_rate();

    //     $stmt = json_decode($rate->resolveAccountNumber($data), true);

    //     if (isset($stmt['status']) && $stmt['status'] == true) {
    //         return json_encode(array('response_code' => 0, 'response_message' => $stmt['data']['account_name']));
    //     } else {
    //         return json_encode(array('response_code' => 20, 'response_message' => $stmt['message']));
    //     }
    // }

    public function getAccountBalance()
    {
        if ((isset($_SESSION['messaging_userid']) && $_SESSION['messaging_userid'] != "")) {

            $balance = $this->SelectOne('wallet_table', 'wallet_id', $this->encrypt($_SESSION['messaging_userid']), 'wallet_balance');
            return json_encode(array('response_code' => 0, 'response_message' => $this->decrypt($balance)));
        } else {
            return json_encode(array('response_code' => 20));
        }
    }

    public function processRequestData($data)
    {
        // Initialize an empty associative array to store the values
        $response = [];

        $payload = parse_url($data['REQUEST_URI'], PHP_URL_QUERY);

        $path = parse_url($data['REQUEST_URI'], PHP_URL_PATH);
        $path = explode('/', $path);
        $ccc = count($path) - 1; // getting the element of the array
        $url = $path[$ccc];

        // If payload is empty but the URL is not, redirect to a dashboard
        if (empty($payload) && !empty($url)) {
            header('Location: ../dashboard/');
            exit(); // Ensure the script exits after the redirection
        } elseif ($url == 'select-beneficiary') {
            $_SESSION['select-beneficiary'] = $payload;
        } elseif ($url == 'confirm-payment') {
            $_SESSION['confirm-payment'] = $payload;
        }

        // Store the raw payload in the response array
        $response['raw'] = $payload;
        $response['raw'] .= $_SESSION['select-beneficiary'];
        $response['raw'] .= $_SESSION['confirm-payment'];

        if (isset($response['payload'])) {
            $response['payload'] .= $response['raw'];
        } else {
            $response['payload'] = $response['raw'];
        }

        $payload = base64_decode($payload);

        // Decoding the URL-encoded string
        $inputString = urldecode(trim($payload, '"'));

        // Split the string into key-value pairs
        $keyValuePairs = explode('&', $inputString);

        // Loop through the key-value pairs and populate the array
        foreach ($keyValuePairs as $pair) {
            list($key, $value) = explode('=', $pair);
            $response[$key] = $value;
        }

        // Check if 'raw' key exists in $response
        if (array_key_exists('payload', $response)) {
            // Decode 'raw' value
            $rawValue = base64_decode($response['payload']);

            $inputString = urldecode(trim($rawValue, '"'));

            // Split 'raw' value into key-value pairs
            $rawKeyValuePairs = explode('&', $inputString);

            // Loop through the 'raw' key-value pairs and push them to $response
            foreach ($rawKeyValuePairs as $pair) {
                list($key, $value) = explode('=', $pair);
                $response[$key] = $value;
            }
        }

        return $response;
    }

    public function processPayload($data)
    {
        // Initialize an empty associative array to store the values
        $response = [];

        // Extract the payload from the URL
        $payload = parse_url($data['REQUEST_URI'], PHP_URL_QUERY);

        // Store the raw payload in the response array
        $response['raw'] = $payload;

        // Check if URL indicates a specific page
        $path = parse_url($data['REQUEST_URI'], PHP_URL_PATH);
        $pathParts = explode('/', $path);
        $lastPathPart = end($pathParts);

        // var_dump($lastPathPart);exit;

        if (!empty($lastPathPart)) {
            if ($lastPathPart == 'send') {
                // $_SESSION['send'] = $payload;
            } elseif ($lastPathPart == 'select-beneficiary') {
                $_SESSION['select-beneficiary'] = $payload;
            } elseif ($lastPathPart == 'confirm-payment') {
                $_SESSION['confirm-payment'] = $payload;
            } elseif ($lastPathPart == 'login') {
                $_SESSION['confirm-payment'] = $payload;
            }
        } else {
            // Redirect to a dashboard or handle other cases
            // header('Location: ../dashboard/');
            // exit();
        }

        // Decode the base64-encoded payload
        // $decodedPayload = $this->decryptPayload($payload);
        $decodedPayload = base64_decode($payload);

        // var_dump($decodedPayload);

        if ($decodedPayload !== false) {
            // Decode the URL-encoded string and split into key-value pairs
            $inputString = urldecode(trim($decodedPayload, '"'));
            $keyValuePairs = explode('&', $inputString);

            // Populate the response array with key-value pairs
            foreach ($keyValuePairs as $pair) {
                list($key, $value) = explode('=', $pair);
                $response[$key] = $value;
            }
        } else {
            // Handle the case where decoding fails
            // You might log an error or perform another action as needed
        }

         // Check if 'payload' key exists in $response
         if (array_key_exists('rate', $response)) {
            $_SESSION['send'] = $payload;
         }


        // Check if 'payload' key exists in $response
        if (array_key_exists('payload', $response)) {
            // Decode 'raw' value
            // $rawValue = $this->decryptPayload($response['payload']);
            $rawValue = base64_decode($response['payload']);

            $inputString = urldecode(trim($rawValue, '"'));

            // Split 'raw' value into key-value pairs
            $rawKeyValuePairs = explode('&', $inputString);

            // Loop through the 'raw' key-value pairs and push them to $response
            foreach ($rawKeyValuePairs as $pair) {
                list($key, $value) = explode('=', $pair);
                $response[$key] = $value;
            }
        }

        // Check if 'send' key exists in $_SESSION array
        if (array_key_exists('send', $_SESSION)) {
            // Decode 'raw' value
            // $rawValue = $this->decryptPayload($_SESSION['send']);
            $rawValue = base64_decode($_SESSION['send']);

            $inputString = urldecode(trim($rawValue, '"'));

            // Split 'raw' value into key-value pairs
            $rawKeyValuePairs = explode('&', $inputString);

            // Loop through the 'raw' key-value pairs and push them to $response
            foreach ($rawKeyValuePairs as $pair) {
                list($key, $value) = explode('=', $pair);
                $response[$key] = $value;
            }
        }

        // Check if 'select-beneficiary' key exists in $_SESSION array
        if (array_key_exists('select-beneficiary', $_SESSION)) {
            // Decode 'raw' value
            // $rawValue = $this->decryptPayload($_SESSION['select-beneficiary']);
            $rawValue = base64_decode($_SESSION['select-beneficiary']);

            $inputString = urldecode(trim($rawValue, '"'));

            // Split 'raw' value into key-value pairs
            $rawKeyValuePairs = explode('&', $inputString);

            // Loop through the 'raw' key-value pairs and push them to $response
            foreach ($rawKeyValuePairs as $pair) {
                list($key, $value) = explode('=', $pair);
                $response[$key] = $value;
            }
        }

        // Check if 'confirm-payment' key exists in $_SESSION array
        if (array_key_exists('confirm-payment', $_SESSION)) {
            // Decode 'raw' value
            // $rawValue = $this->decryptPayload($_SESSION['confirm-payment']);
            $rawValue = base64_decode($_SESSION['confirm-payment']);

            $inputString = urldecode(trim($rawValue, '"'));

            // Split 'raw' value into key-value pairs
            $rawKeyValuePairs = explode('&', $inputString);

            // Loop through the 'raw' key-value pairs and push them to $response
            foreach ($rawKeyValuePairs as $pair) {
                list($key, $value) = explode('=', $pair);
                $response[$key] = $value;
            }
        }

        if (array_key_exists('recipient', $response)) {
            $stmt = $this->getRecipientData($response['recipient']);

            if (is_array($stmt) && count($stmt) > 0) {
                $payload = http_build_query($stmt);
                // Append the payload data to the existing 'raw' value
                $response['raw'] .= base64_encode($payload);
                // Loop through the 'raw' key-value pairs and push them to $response
                foreach ($stmt as $key => $value) {
                    $response[$key] = $value;
                }
            }
        }

        if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == true){
            $stmt = $this->getRecipientData($_REQUEST['recipientid']);

            if (is_array($stmt) && count($stmt) > 0) {
                $payload = http_build_query($stmt);
                // Append the payload data to the existing 'raw' value
                $response['raw'] .= base64_encode($payload);
                // Loop through the 'raw' key-value pairs and push them to $response
                foreach ($stmt as $key => $value) {
                    $response[$key] = $value;
                }
            }
            $recipient = $this->SelectOne('transfer_recepients','receipient_code', $_REQUEST['recipientid'],'account_name');
            // $response['account_name'] = $recipient;
            return json_encode(['response_code' => 0, 'response_message' => $response, 'account_name'=>$recipient]);
        }else{
            
            return $response;
        }

    }

    private function getRecipientData($code)
    {
        $response = array();
        $stmt = $this->Select('transfer_recepients', 'receipient_code', $code);
        if (is_array($stmt) && count($stmt) > 0) {
            $response = [
                'code' => $code,
                'account_name' => $stmt['account_name'],
                'account_name_1' => $stmt['account_name'],
                'account_no' => $stmt['account_number'],
                'bank_branch' => $stmt['bank_branch'],
                'email' => $stmt['email'],
                'phone_number' => $stmt['phone_number'],
                'city' => $stmt['city'],
                'state' => $stmt['state'],
                'country' => $stmt['country'],
                'postcode' => $stmt['postcode'],
                'bank_name' => $stmt['bank_code'],
                'address' => $stmt['address'],
            ];
        }

        return $response;
    }

    // public function initiateRequest()
    // {
    //     try {

    //         $data = $this->processPayload($_SERVER);

    //         $validate = $this->validate(
    //             $data,
    //             array('converting-amount' => 'required', 'converting-currency' => 'required', 'recieving-amount' => 'required', 'receiving-currency' => 'required', 'delivery-method' => 'required', 'bank_name' => 'required', 'account_no' => 'required', 'account_name' => 'required', 'email' => 'required', 'phone_number' => 'required'),
    //             array('converting-amount' => 'Source Amount', 'converting-currency' => 'Source Currency', 'recieving-amount' => 'Destination Amount', 'receiving-currency' => 'Destination Currency', 'delivery-method' => 'Delivery Method', 'bank_name' => 'Bank Name', 'account_no' => 'Account Number', 'account_name' => 'Account Name', 'email' => 'Email Address', 'phone_number' => 'Phone Number')
    //         );

    //         if ($validate['error']) {
    //             return json_encode(['response_code' => 20, 'response_message' => $validate['messages'][0]]);
    //         }

    //         include_once __DIR__ . '/../settings/class/Transactions.php';
    //         $transactions = new Transactions();

    //         $stmt = json_decode($transactions->logTransaction($data), true);
    //         if ($stmt['response_code'] == 0) {
    //             return json_encode(['response_code' => 0, 'response_message' => 'Your request has been successfully initiated.','payload' => $stmt['payload']]);
    //         } else {
    //             return json_encode(['response_code' => 20, 'response_message' => $stmt['response_message']]);
    //         }
    //     } catch (Exception $e) {
    //         return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
    //     }
    // }
    public function allBeneficiary()
    {
        try {

            include_once __DIR__ . '../../settings/class/Users.php';
            $user = new Users();
            return $user->allBeneficiary();
        } catch (Exception $e) {
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    // public function getFortnightSummary()
    // {
    //     try {

    //         include_once __DIR__ . '../../settings/class/Transactions.php';
    //         $transactions = new Transactions();
    //         return $transactions->getFortnightSummary();
    //     } catch (Exception $e) {
    //         return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
    //     }
    // }

    public function getSecurityKey()
    {
        try {

            $key = $this->SelectOne('parameter', 'parameter_name', 'KEY', 'parameter_value');
            $iv = $this->SelectOne('parameter', 'parameter_name', 'IV', 'parameter_value');

            // return json_encode(['response_code' => 0, 'key' => $key, 'iv' => $iv]);
            return json_encode(['response_code' => 0, 'key' => '', 'iv' => '']);
        } catch (Exception $e) {
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function getPayId()
    {
        try {

            $account_name = $this->SelectOne('parameter', 'parameter_name', 'PAYMENT_NAME', 'parameter_value');
            $account_number = $this->SelectOne('parameter', 'parameter_name', 'PAYMENT_ACCOUNT', 'parameter_value');
            $bank_name = $this->SelectOne('parameter', 'parameter_name', 'BANK_NAME', 'parameter_value');
            $payid = $this->SelectOne('parameter', 'parameter_name', 'PAYMENT_ID', 'parameter_value');
            $bsb = $this->SelectOne('parameter', 'parameter_name', 'PAYMENT_BSB', 'parameter_value');
            $abn = $this->SelectOne('parameter', 'parameter_name', 'ABN', 'parameter_value');

            return json_encode(['response_code' => 0, 'account_name' => $account_name,'account_number' => $account_number, 'bank_name' => $bank_name, 'payid' => $payid, 'bsb' => $bsb, 'abn' => $abn]);
        } catch (Exception $e) {
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function userProfile($data)
    {
        try {

            include_once __DIR__ . '/../settings/class/Users.php';
            $user = new Users();
            return $user->userProfile($data);
            
        } catch (Exception $e) {
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function time_out()
    {
        //Time to time out in seconds
        $inact_min = $this->SelectOne("parameter", "parameter_name", 'inactivity_time', 'parameter_value');
        //convert by multiplying by 3600
        $inact_val = ($inact_min > 0) ? $inact_min * 60 * 60 : 10 * 60 * 60;
        
        return $inact_val;
    }

    public function getStates($data)
    {        
        $country_id = $data['id'];
        $options = '<option value="" selected>Select...</option>';
        $stmt = $this->db_connect("SELECT id,name FROM states WHERE country_id = '$country_id' ORDER BY name");
        if(is_array($stmt) && count($stmt) > 0){
            foreach($stmt as $row){
                $options .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
        }

        return json_encode(['options' => $options]);
    }
    public function getCities($data)
    {        
        $state_id = $data['id'];
        $country_id = $data['country_id'];
        $options = '<option value="" selected>Select...</option>';
        $stmt = $this->db_connect("SELECT id,name FROM cities WHERE country_id = '$country_id' AND state_id = '$state_id' ORDER BY name");
        if(is_array($stmt) && count($stmt) > 0){
            foreach($stmt as $row){
                $options .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
        }

        return json_encode(['options' => $options]);
    }
}

