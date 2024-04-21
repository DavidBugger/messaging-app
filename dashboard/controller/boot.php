<?php

// ini_set('display_errors', 1);
// error_reporting(E_ERROR | E_ALL & ~E_NOTICE);
include_once 'controller.php';
class Boot extends Controller
{
    public $current_date;
    public $logfile;
    public $path;
    public $error_msg;
    public $root;
    public $base_url;
    public $csrf;
    public $csrfToken;
    public $charges;
    public $role_id;
    public $merchant_id;

    public function __construct()
    {
        parent::__construct();

        $this->root = __DIR__ . '/../';

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
        $this->role_id = isset($_SESSION['messaging_role_id']) ? $_SESSION['messaging_role_id'] : '';
        $this->merchant_id = isset($_SESSION['messaging_merchant_id']) ? $_SESSION['messaging_merchant_id'] : '';

    }
    public function base_url()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($ip == 'localhost' or $ip == '::1') {
            $base = 'http://localhost/messaging/';
        } else {
            $base = $_SERVER['REQUEST_SCHEME'] . '://messaging.com.au/';
            // $base = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/';
        }

        return $base;
    }

    public function gateKeeper($data)
    {
        try {
            return $this->login($data);
        } catch (Exception $e) {
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    

    public function createMenu($data)
    {
        try {
            return $this->saveMenu($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function createRole($data)
    {
        try {
            return $this->saveRole($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function createRate($data)
    {
        try {
            return $this->saveRate($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function createMenuGroup($data)
    {
        try {
            return $this->saveMenuGroup($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function createReceivingCountry($data)
    {
        try {
            return $this->saveReceivingCountry($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function loadMenu($data)
    {
        try {
            return $this->loadMenus($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function GetRoleList($data)
    {
        try {
            return $this->RoleList($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function GetRateList($data)
    {
        try {
            return $this->RateList($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function GetMenuList($data)
    {
        try {
            return $this->MenuList($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function GetTransactionList($data)
    {
        try {
            include_once $this->root . 'settings/class/Transactions.php';
            $transaction = new Transactions();

            return $transaction->TransactionList($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function viewReceipt($data)
    {
        try {
            include_once $this->root . 'settings/class/Transactions.php';
            $transaction = new Transactions();

            return $transaction->viewReceipt($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function GetUsersList($data)
    {
        try {
            include_once $this->root . 'settings/class/Users.php';
            $users = new Users();

            return $users->UsersList($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    
    
    public function partnerSetup($data)
    {
        try {
            include_once $this->root . 'settings/class/Account.php';
            $account = new Account();

            return $account->partnerSetup($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function APICredentials($data)
    {
        try {
            include_once $this->root . 'settings/class/Account.php';
            $account = new Account();

            return $account->APICredentials($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function GetPartnersList($data)
    {
        try {
            include_once $this->root . 'settings/class/Account.php';
            $account = new Account();

            return $account->PartnersList($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function GetPartnerToggler($data)
    {
        try {
            include_once $this->root . 'settings/class/Account.php';
            $account = new Account();

            return $account->PartnerToggler($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function getRoles()
    {
        include_once $this->root . 'settings/class/Account.php';
        $account = new Account();
        return $account->getAllRoles();
    }
    public function getPartners()
    {
        include_once $this->root . 'settings/class/Account.php';
        $account = new Account();
        return $account->getAllPartners();
    }

    public function GetAccountAccess($data)
    {
        return $this->AccountAccess($data);
    }
    public function GetAccountLocker($data)
    {
        return $this->AccountLocker($data);
    }
    public function GetManageMenu($data)
    {
        include_once $this->root . 'settings/class/menu.php';
        $menu = new Menu();
        return $menu->ManageMenu($data);
    }
    public function GetDeleteMenu($data)
    {
        include_once $this->root . 'settings/class/menu.php';
        $menu = new Menu();
        return $menu->DeleteMenu($data);
    }
    public function GetManageRole($data)
    {
        include_once $this->root . 'settings/class/role.php';
        $role = new Role();
        return $role->ManageRole($data);
    }
    public function GetDeleteRole($data)
    {
        include_once $this->root . 'settings/class/role.php';
        $role = new Role();
        return $role->DeleteRole($data);
    }
    public function GetOverideRole($data)
    {
        include_once $this->root . 'settings/class/role.php';
        $role = new Role();
        return $role->OverideRole($data);
    }
    public function GetSavePermission($data)
    {
        include_once $this->root . 'settings/class/Access_control.php';
        $access = new Access_control();
        return $access->SavePermission($data);
    }
    public function GetPermissionList($data)
    {
        include_once $this->root . 'settings/class/Access_control.php';
        $access = new Access_control();
        return $access->PermissionList($data);
    }
    public function GetManagePermission($data)
    {
        include_once $this->root . 'settings/class/Access_control.php';
        $access = new Access_control();
        return $access->ManagePermission($data);
    }
    public function GetDeletePermission($data)
    {
        include_once $this->root . 'settings/class/Access_control.php';
        $access = new Access_control();
        return $access->DeletePermission($data);
    }
    public function GetOveridePermission($data)
    {
        include_once $this->root . 'settings/class/Access_control.php';
        $access = new Access_control();
        return $access->OveridePermission($data);
    }
    public function LoadPermission($data)
    {
        include_once $this->root . 'settings/class/Access_control.php';
        $access = new Access_control();
        return $access->loadAccess($data);
    }
    public function createPermissionGroup($data)
    {
        include_once $this->root . 'settings/class/Access_control.php';
        $access = new Access_control();
        return $access->SavePermissionGroup($data);
    }

    public function GetAccountList($data)
    {
        try {
            include_once $this->root . 'settings/class/Account.php';
            $account = new Account();

            return $account->accountList($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function GetAdminList($data)
    {
        try {
            include_once $this->root . 'settings/class/Admin.php';
            $admin = new Admin();

            return $admin->adminList($data);
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function dashboardMetrics()
    {
        try {
            include_once __DIR__ . '/../settings/class/Dashboard.php';
            $dashboard = new Dashboard();

            return $dashboard->dashboardMetrics();
        } catch (Exception $e) {
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function createUserAccount($data)
    {
        return $this->createUser($data);
    }
}
