<?php

session_start();
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_ALL & ~E_NOTICE);
date_default_timezone_set('Africa/Lagos');

include_once(__DIR__ . '/connection.php');
include_once(__DIR__ . '/../settings/class/frontend.php');
include_once(__DIR__ . '/../settings/class/Notification.php');

include_once(__DIR__ . '/../settings/class/Encryption.php');
// include_once (__DIR__.'/../settings/class/sendMail.php');
// include_once (__DIR__.'/../settings/class/Notifications.php');
include_once(__DIR__ . '/../settings/class/pdf.php');
include_once(__DIR__ . '/../settings/class/SecurityService.php');

// generate json web token :: JWT
include_once(__DIR__ . '/../library/php-jwt-main/src/BeforeValidException.php');
include_once(__DIR__ . '/../library/php-jwt-main/src/ExpiredException.php');
include_once(__DIR__ . '/../library/php-jwt-main/src/SignatureInvalidException.php');
include_once(__DIR__ . '/../library/php-jwt-main/src/Key.php');
include_once(__DIR__ . '/../library/php-jwt-main/src/JWT.php');

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class Model extends Frontend
{
    public $root;
    public $base_url;
    public $notification;
    public $pdf;
    public $current_date;
    public $logfile;
    public $conn;
    public $validation;
    public $myemail;
    public $path;
    public $error_msg;
    public $encryption;
    public $template;
    public $paystack;
    public $flutter;
    public $db;
    public $ip;
    protected $tokenKey;
    protected $tokenIssuedAt;
    protected $tokenExpirationTime;
    protected $tokenIssuer;
    protected $tokenAlgorithm;
    protected $flutter_percentage;
    protected $local_charges;
    public $production_env;
    public $sandbox;
    public $connection;
    public $key;
    public $iv;

    public function __construct()
    {
        parent::__construct();
        // $this->base_url = $this->SelectOne("parameter", "parameter_name", "local_url", "parameter_value");

        $this->ip = $_SERVER['REMOTE_ADDR'];
        if ($this->ip == 'localhost' or $this->ip == '::1') {
            $this->root = $_SERVER['DOCUMENT_ROOT'] . '/messaging/';
            $this->base_url = 'http://localhost/messaging/';
        } else {

            $this->root = $_SERVER['DOCUMENT_ROOT'] . '/';
            $this->base_url = $_SERVER['REQUEST_SCHEME'] . '://messaging.com.au/'; //or you hardcode your domain name here
            // $this->base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/'; //or you hardcode your domain name here
        }



        $this->tokenKey = "h[wm+6c?5q7&g=z-p=9";
        $this->tokenIssuedAt = time();
        $this->tokenExpirationTime = $this->tokenIssuedAt + (60 * 60 * 24); //1 day
        $this->tokenIssuer = $this->base_url;
        $this->tokenAlgorithm = "HS256";

        $this->template = $_SERVER['REQUEST_SCHEME'] . '://console.messaging.com.au/email_template/';
        // $this->template = $this->base_url . 'admin/email_template/';
        $this->path = $this->root;
        $this->myemail = 'info@' . $_SERVER['SERVER_NAME'];

        $this->encryption = new Encryption($this->key, $this->iv);
        $this->notification = new Notification();
        $this->pdf = new Pdf(); //instantiates a new object for the Pdf class

        $this->current_date = date('Y-m-d');
        $this->logfile = $this->path . 'logger/';
        if (!file_exists($this->logfile)) :
            mkdir($this->logfile);
        endif;

        $this->path = $this->path . 'uploads/'; // specified path for file uploads
        if (!file_exists($this->path)) :
            mkdir($this->path);
        endif;

        $this->flutter_percentage = '1.4'; //0.014

        $this->db = new Connection();
        $this->conn = $this->db->connect(); //instantiates a new object for the db connect() 

        $this->local_charges = $this->SelectOne('parameter', 'parameter_name', 'local_charges', 'parameter_value');
        $this->key = $this->SelectOne('parameter', 'parameter_name', 'KEY', 'parameter_value');
        $this->iv = $this->SelectOne('parameter', 'parameter_name', 'IV', 'parameter_value');
    }

    public function initiateTransaction()
    {
        $this->conn->beginTransaction();
    }
    public function commit()
    {
        $this->conn->commit();
    }
    public function rollback()
    {
        $this->conn->rollback();
    }

    public function runQuery($sql)
    {
        if ($sql == "") {
            return json_encode(array('response_code' => 20, 'response_message' => 'Query parameter is required'));
        }

        // var_dump($this->conn);exit;

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return json_encode(
            array(
                'count' => $stmt->rowCount(),
                'row' => $stmt->fetch(),
                'data' => $stmt->fetchAll()
            )
        );
    }
    public function runCRUD($sql)
    {
        if ($sql == "") {
            return json_encode(array('response_code' => 20, 'response_message' => 'Query parameter is required'));
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getCurrentData($table_name, $table_field, $table_id)
    {
        $sql = "SELECT * FROM $table_name WHERE  $table_field = '$table_id' LIMIT 1";
        $result = json_decode($this->runQuery($sql), true);
        return $result['row'];
    }

    public function logActivity($current_data, $insert_data, array $option, array $exempt = [])
    {
        $result       = $this->Insert("log_table", array("username" => $_SESSION['messaging_username'], "table_name" => $option['table_name'], "table_id" => $option['table_id'], "table_alias" => $option['table_alias'], "created" => date("Y-m-d H:i:s")), []);
        $insert_id    = $this->loglastInsertId();
        if ($result > 0) {
            $difference = array_diff($insert_data, $current_data);
            foreach ($difference as $key => $value) {
                if (!in_array($key, $exempt)) {
                    $this->Insert("log_details", array("log_id" => $insert_id, "field_name" => $key, "previous_data" => $current_data[$key], "current_data" => $value, "field_alias" => ""), []);
                }
            }
        }
    }

    public function loglastInsertId()
    {
        $stmt = $this->db_connect("SELECT max(id) AS id FROM log_table")[0];
        return $stmt['id'];
    }
    // this method is used to retrieve a column irrespective of the table
    public function SelectOne($table_name, $where_column, $where_value, $retval)
    {
        $stmt = json_decode($this->runQuery("SELECT $retval FROM $table_name WHERE $where_column = '$where_value' LIMIT 1"), true);

        return ($stmt['count'] > 0) ? $stmt['row'][$retval] : $stmt['count'];
    }

    // this method is used to retrieve a column irrespective of the table
    public function Select($table_name, $where_column, $where_value, $retval = "*")
    {
        $stmt = json_decode($this->runQuery("SELECT $retval FROM $table_name WHERE $where_column = '$where_value' LIMIT 1"), true);
        return ($stmt['count'] == 1) ? $stmt['row'] : (($stmt['data'] > 1) ? $stmt['data'] : $stmt['count']);
    }

    function SelectArr($table, $col_arr, $val_arr, $ret_val_arr)
    {
        $selectClause = $whrClause = $retValue = "";

        if ($ret_val_arr == "*") {
            $qquery = "SHOW COLUMNS FROM $table ";
            $result = $this->conn->query($qquery);
            $columns = $result->fetchAll(PDO::FETCH_COLUMN);
            $selectClause = implode(", ", $columns);
        } else {
            $selectClause = implode(", ", $ret_val_arr);
        }

        $whereConditions = [];
        for ($j = 0; $j < count($col_arr); $j++) {
            $whereConditions[] = $col_arr[$j] . " = ?";
        }
        $whrClause = implode(" AND ", $whereConditions);

        $query = "SELECT $selectClause FROM $table WHERE $whrClause LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($val_arr);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $row : null;
    }


    // this method is used to retrieve a column irrespective of the table
    public function SelectAll($table_name, $retval = "*")
    {
        $stmt = json_decode($this->runQuery("SELECT $retval FROM $table_name"), true);
        return ($stmt['count'] > 0) ? $stmt['data'] : $stmt['count'];
    }

    public function SelectAllWhere($table_name, $where_column, $where_value, $retval = "*")
    {
        $stmt = json_decode($this->runQuery("SELECT $retval FROM $table_name WHERE $where_column = '$where_value'"), true);
        return ($stmt['count'] > 0) ? $stmt['data'] : $stmt['count'];
    }

    public function SelectDistinct($table_name, $column, $array)
    {
        $stmt = json_decode($this->runQuery("SELECT DISTINCT($column),$array[0] AS id FROM $table_name ORDER BY $column ASC"), true);
        return ($stmt['count'] > 0) ? $stmt['data'] : $stmt['count'];
    }

    // this method is used to check if a record is already in existence irrespective of the table
    public function SelectCount($table_name, $column, $retval)
    {
        $stmt = json_decode($this->runQuery("SELECT COUNT($column) AS counter FROM $table_name WHERE $column='$retval'"), true);
        return $stmt['count'];
    }

    //this method returns a mysql escaped string
    public function escape($data, $exempt_arr = [])
    {
        $array = array();
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($exempt_arr) && sizeof($exempt_arr) > 0) {
                    if (!in_array($value, $exempt_arr)) {
                        $array[$key] = $this->escape($value);
                    }
                } else {
                    $array[$key] = $this->escape($value);
                }
            }
        } else {
            $array[] = str_replace("'", '', $this->conn->quote(trim(strip_tags($data))));
        }

        return $array;
    }

    public function maskEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            list($first, $last) = explode('@', $email);
            $first = str_replace(substr($first, '3'), str_repeat('*', strlen($first) - 3), $first);
            $last = explode('.', $last);
            $last_domain = str_replace(substr($last['0'], '1'), str_repeat('*', strlen($last['0']) - 1), $last['0']);
            $maskEmail = $first . '@' . $last_domain . '.' . $last['1'];
            return $maskEmail;
        }
    }

    public function mfa($data)
    {
        try {

            $username = $_SESSION['messaging_username'];
            if (isset($data['is_mfa']) && $data['is_mfa'] == "") {
                return json_encode(array('response_code' => 20, 'response_message' => 'This field accepts either 1 or 0'));
            }
            if ((isset($_SESSION['messaging_mfa']) && $_SESSION['messaging_mfa'] == 1) && $data['is_mfa'] == 1) {
                $data['is_mfa'] = 0;
            } elseif ((isset($_SESSION['messaging_mfa']) && $_SESSION['messaging_mfa'] == 0) && $data['is_mfa'] == 0) {
                $data['is_mfa'] = 1;
            }

            $message = ($data['is_mfa'] == 1) ? 'enabled' : 'disabled';
            $update['is_mfa'] = $data['is_mfa'];
            $stmt = $this->Update('userdata', $update, [], ['username' => $username]);
            if ($stmt > 0) {
                $_SESSION['messaging_mfa'] = $data['is_mfa'];
                return json_encode(array('response_code' => 0, 'response_message' => '2-FA has been ' . $message . ' successfully.'));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => '2-FA could not be ' . $message));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> SECOND_LAYER_LOGIN_MODEL => Error: " . $e->getMessage() . ' on line ' . $e->getLine();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function deviceId($data)
    {
        // there is no cookie set; a new device has connected
        $dIdentifier = md5(time());

        $device_id = $this->SelectOne('userdata', 'username', $data, 'device_id');
        if ($device_id != "") {
            if (isset($_COOKIE["deviceIdentifier"]) && $_COOKIE["deviceIdentifier"] != $device_id) {
                return json_encode(array('response_code' => 20, 'response_message' => 'We could not recognise your device...'));
            }
        } elseif ($device_id == "") {
            $wallet_id = $this->SelectOne('userdata', 'username', $data, 'username');
            if ($wallet_id != "") {
                $device['device_id'] = $dIdentifier;
                $stmt = $this->Update('userdata', $device, [], ['username' => $data]);
                if ($stmt > 0) {
                    // set a new cookie for the device
                    setcookie("deviceIdentifier", $dIdentifier, time() * 2, true, true);

                    return json_encode(array('response_code' => 0, 'response_message' => ''));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'We could not recognise your device...'));
                }
            }
        }
    }

    public function isMerchantEnvironment()
    {
        if (isset($_REQUEST['2l']) && $_REQUEST['2l'] == true && isset($_REQUEST['merchant']) && $_REQUEST['merchant'] == true) {
            return true;
        } else {
            return false;
        }
    }

    public function redirect()
    {
        // @session_start();
        if (!isset($_SESSION['messaging_username']) || $_SESSION['messaging_username'] == '') {
            header('location: ../logout');
        }

        $stmt = json_decode($this->CheckKYC(), true);
        if (in_array($stmt['status'], [1, 3, 5])) {
            $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $uri_segments = explode('/', $uri_path);

            $ccc = count($uri_segments) - 1; // getting the element of the array
            $url = $uri_segments[$ccc];
            if ($url != 'kyc') {
                header('location: kyc');
            }
        }
    }

    public function CheckKYC($wallet_id = null)
    {
        if ($wallet_id == null) {
            $wallet_id = $_SESSION['messaging_userid'];
        }

        $daysUntilExpiry = 0;
        $stmt = $this->Select('userdata', 'wallet_id', $wallet_id);


        if (!empty($stmt['card_expiry_date'])) {
            $expiryDate = strtotime($stmt['card_expiry_date']); // Convert the expiry date to a Unix timestamp
            $today = strtotime(date('Y-m-d')); // Get today's date as a Unix timestamp
            $daysUntilExpiry = ($expiryDate - $today) / 86400; // Calculate the number of days until expiry
        }

        $alert = json_decode($this->getAlert(), true);

        if ($stmt['status'] == 0) {
            return json_encode(['status' => 1]); //trigger kyc modal 
        } else if ($stmt['status'] == 2) {
            return json_encode(['status' => 2]); //pending approval
        } else if ($stmt['status'] == 3) {
            return json_encode(['status' => 3]); //declined approval
        } else if (in_array($stmt['second_level_status'], [2])) {
            return json_encode(['status' => 4]); //fortnight limit pending approval
        } else if (round($daysUntilExpiry) <= 0) {
            return json_encode(['status' => 5]); //means of identification has expired
        } else if ($alert['response_code'] == 0 && in_array($alert['data']['status'], [0, "0"])) {
            return json_encode(['status' => 6]); //system upgrade 
        } else {
            return json_encode(['status' => 0]);
        }
    }

    //this method is for login operation
    public function access($data)
    {
        try {
            $this->escape($data);

            $username = trim($data['username']);
            $password = trim($data['password']);

            $stmt = $this->Select('userdata', 'email', $username);

            //check if user is trying to login from the merchant environment
            if ($this->isMerchantEnvironment() == true && $stmt['role_id'] == 300) {
                return json_encode(array('response_code' => 20, 'response_message' => 'Invalid User Account'));
            }

            if (is_array($stmt) && sizeof($stmt) <= 0) {
                return json_encode(array('response_code' => 20, 'response_message' => 'Invalid User Account'));
            }

            $str_cipher_password = $this->encrypt($password);
            if ($str_cipher_password != $stmt['password']) {
                return json_encode(array('response_code' => 20, 'response_message' => "Incorrect password "));
            }

            $verify = [
                'type' => 'emfa',
                'username' => $username,
                // 'authenticate' => $stmt['firstname'],
                '_2l' => true
            ];

            // Account verification Section
            if ($stmt['is_email_verified'] == 0) {
                $data['column'] = 'email_token';
                if ($stmt['role_id'] == 300) {
                    $page = 'verification';
                } else {
                    $page = 'verification';
                    // $page = 'merchant/verification';
                }

                $pin = json_decode($this->generate2FAPIN($data), true);
                if ($pin['response_code'] == 0) {
                    $message = "Please, enter the verification code that was sent to " . $this->maskEmail($username) . " to verify your email address.";

                    return json_encode(array(
                        'response_code' => 20, 'response_message' => $message, 'status' => 101,
                        'page' => $page, 'data' => $this->encryptPayload(json_encode($verify))
                    ));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Verification code could not be sent to ' . $this->maskEmail($username), 'status' => 101, 'page' => $page, 'data' => $this->encryptPayload(json_encode($verify))));
                }
            }

            $verify['type'] = 'mfa';

            // 2-FA Section
            if (isset($stmt['is_mfa'])  && $stmt['is_mfa'] == 1) {
                $message = "Please, enter the OTP that was sent to " . $this->maskEmail($username);
                $pin = json_decode($this->generate2FAPIN($data), true);

                if ($pin['response_code'] == 0) {
                    return json_encode(array(
                        'response_code' => 20, 'response_message' => $message, 'status' => 101,
                        'page' => 'verification', 'data' => $this->encryptPayload(json_encode($verify))
                    ));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'OTP could not be sent to ' . $this->maskEmail($username) . ' [' . $stmt['response_message'] . ']', 'status' => 101, 'page' => 'verification', 'data' => $this->encryptPayload(json_encode($verify))));
                }
            }

            $device = json_decode($this->deviceId($username), true);
            if ($device['response_code'] == 20) {
                return json_encode(array('response_code' => $device['response_code'], 'response_message' => $device['response_message']));
            }

            return $this->signIn($username, $password);
        } catch (Exception $e) {
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    // Function to generate a CSRF token
   public function generateCsrfToken()
    {
        // Generate a random token (32-byte random string, hex encoded)
        return bin2hex(random_bytes(32));
    }

    public function signIn($data)
    {
        try {
            // var_dump($data['username']);exit;
            // $stmt = $this->db_connect("SELECT * FROM userdata AS u LEFT JOIN wallet_table AS wb ON wb.wallet_id=u.wallet_id WHERE u.email='" . $data['username'] . "'");
            $stmt = $this->db_connect("SELECT * FROM userdata  WHERE username ='" . $data['username'] . "'");
            $password = $this->encrypt($data['password']);
            if (is_array($stmt) && count($stmt) > 0) {
                if ($password == $stmt[0]['password']) {

                    $country = $this->SelectOne('countries', 'id', $stmt[0]['country_id'], 'name');
                    $state = $this->SelectOne('states', 'id', $stmt[0]['state'], 'name');
                    $city = $this->SelectOne('cities', 'id', $stmt[0]['city'], 'name');

                    $_SESSION['messaging_userid'] = ($stmt[0]['wallet_id']) ?? $this->SelectOne('userdata', 'username', $data['username'], 'wallet_id');
                    $_SESSION['messaging_username'] = $data['username'];
                    $_SESSION['messaging_firstname'] = $stmt[0]['firstname'];
                    $_SESSION['messaging_middlename'] = $stmt[0]['middlename'];
                    $_SESSION['messaging_lastname'] = $stmt[0]['lastname'];
                    $_SESSION['messaging_email'] = $stmt[0]['email'];
                    $_SESSION['messaging_role_name'] = $stmt[0]['role_name'];
                    $_SESSION['messaging_mobile_phone'] = $stmt[0]['mobile_phone'];
                    $_SESSION['messaging_gender'] = $stmt[0]['sex'];
                    $_SESSION['messaging_city'] = $stmt[0]['city'];
                    $_SESSION['messaging_postcode'] = $stmt[0]['postcode'];
                    $_SESSION['messaging_daily_limit'] = $stmt[0]['daily_limit'];
                    $_SESSION['messaging_role_id'] = $stmt[0]['role_id'];
                    $_SESSION['messaging_kyc_id'] = $stmt[0]['kyc_id'];
                    $_SESSION['messaging_kyc_type'] = $stmt[0]['kyc_type'];
                    $_SESSION['messaging_card_issuer'] = $stmt[0]['card_issuer'];
                    $_SESSION['messaging_issued_date'] = $stmt[0]['card_issued_date'];
                    $_SESSION['messaging_expiry_date'] = $stmt[0]['card_expiry_date'];
                    $_SESSION['messaging_occupation'] = $stmt[0]['occupation'];
                    $_SESSION['messaging_account_status'] = $stmt[0]['status'];
                    $_SESSION['csrf_token'] = $this->generateCsrfToken();
                

                    //merchant parameters ends
                    $created = ($stmt[0]['created']) ?? $this->SelectOne('userdata', 'username', $data['username'], 'created');

                    $_SESSION['messaging_mfa'] = $stmt[0]['is_mfa'];
                    $_SESSION['messaging_role_name'] = $stmt[0]['role_name'];
                    $_SESSION['messaging_password_lastmodified'] = ($stmt[0]['password_lastmodified'] != "") ? date('F d, Y', strtotime($stmt[0]['password_lastmodified'])) : date('F d, Y', strtotime($stmt[0]['created']));
                    $_SESSION['messaging_joined_date'] = date('F d, Y', strtotime($created));
                    $_SESSION['messaging_default_limit'] = $this->SelectOne('parameter', 'parameter_name', 'FORTNIGHT_LIMIT', 'parameter_value');
                    $_SESSION['messaging_current_limit'] = $stmt[0]['current_limit'] ?? $_SESSION['messaging_default_limit'];
                    $_SESSION['messaging_expected_limit'] = $stmt[0]['expected_limit'] ?? '0.00';
                    $_SESSION['messaging_status'] = $stmt[0]['status'];
                    // $_SESSION['messaging_currency'] = $stmt[0]['currency'];
                    $_SESSION['messaging_device_id'] = $stmt[0]['device_id'];
                    $_SESSION['messaging_dob'] = $stmt[0]['dob'];
                    // $_SESSION['messaging_default_currency'] = $this->Select('currency','`default`',1,'currency_short_code')[0];
                    // $_SESSION['messaging_address'] = trim($stmt[0]['address']);
                    $_SESSION['messaging_second_level_status'] = trim($stmt[0]['second_level_status']);
                    $_SESSION['messaging_kyc_document'] = $stmt[0]['kyc_document'];
                    $_SESSION['messaging_sec_kyc_type'] = $stmt[0]['sec_kyc_type'];
                    $_SESSION['messaging_sec_kyc_document'] = $stmt[0]['sec_kyc_document'];

                    $_SESSION['messaging_verified_email'] = $stmt[0]['is_email_verified'];
                    $_SESSION['messaging_country'] = $country;
                    $_SESSION['messaging_state'] = $state;
                    $_SESSION['messaging_city'] = $city;

                    session_write_close();

                    $this->loginNotification($stmt[0]['email'], $stmt[0]['firstname']);

                    $status = json_decode($this->CheckKYC(), true);

                    return json_encode(array('response_code' => 0, 'response_message' => 'Successful', 'status' => $status['status']));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Incorrect password'));
                }
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Your credential did not match any record in system'));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function loginNotification($email, $name)
    {

        $header = 'Login Notification';

        $subject = $header;

        $message = "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px'><h5>Dear <b style='text-transform:uppercase;'>" . $name . ",</b></h5></p>";

        $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px;font-weight:300;'>messaging LOGIN CONFIRMATION</p>";

        $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px;>Please be informed that your messaging profile was accessed on " . date('d M, Y h:i a') . ".</p>";

        $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px;>If you did not log on to your profile at the time detailed above, please call our 24-hour contact centre on  0426 022 733 or send an email to info@" . $_SERVER['SERVER_NAME'] . " immediately.</p>";

        $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px;>Thank you for choosing messaging.</p>";

        $email_data = array(
            "to" => $email,
            "from" => 'noreply@' . $_SERVER['SERVER_NAME'],
            "subject" => $subject,
            "message" => $message,
            "sender_name" => 'messaging',
            "logo" => $this->base_url . 'assets/img/10.png',
            "template" => $this->template . 'otp.php',
            "type" => $header,
            "channel" => 'mail',
            "account" => $this->SelectOne('userdata', 'email', $email, 'wallet_id'),
            "subscription" => array(6) //6=login
        );

        //$this->notification->channel($email_data);
    }
    public function validateSessionToken()
    {

        $authorization = isset($_SERVER["HTTP_AUTHORIZATION"]) ? $_SERVER["HTTP_AUTHORIZATION"] : '';

        $token = trim(str_replace("Bearer ", "", $authorization));
        if ($token == "") {
            return json_encode(array('response_code' => '20', 'response_message' => 'Missing Required Authorization in Request Header'));
        }

        // if decode succeed, show user details
        try {
            // decode jwt
            $key = new Key($this->tokenKey, $this->tokenAlgorithm);
            $decoded = JWT::decode($token, $key);

            if ($decoded->iss != $this->tokenIssuer) {
                return json_encode(array('response_code' => '20', 'response_message' => "The provided authorization does not match this environment. Please, login again!"));
            } else {

                // show user details
                $details = json_decode(json_encode($decoded->data), true);
                return json_encode(array(
                    "response_code" => "0",
                    "response_message" => "Access granted.",
                    "data" => $details
                ));
            }
        } catch (Exception $e) {
            $message = $e->getMessage();

            if (strtolower(substr($message, '0',  '9')) == "malformed") {
                return json_encode(array('response_code' => '20', 'response_message' => 'Invalid/Malformed Authorization Bearer Token Provided'));
            } elseif (strtolower(substr($message, '0',  '7')) == "expired") {
                return json_encode(array('response_code' => '20', 'response_message' => 'Please, login to continue.'));
            } else {
                return json_encode(array('response_code' => '20', 'response_message' => 'Invalid/Expired System Authorization'));
            }
        }
    }

    private function generateRefreshToken()
    {
        $token = array(
            "iat" => $this->tokenIssuedAt,
            "exp" => $this->tokenIssuedAt + (60 * 60 * 24), //1hr
            "iss" => $this->tokenIssuer,
            "data" => array(
                "id" => $_SESSION['messaging_userid'],
                "username" => $_SESSION['messaging_username'],
                "firstname" => $_SESSION['messaging_firstname'],
                "lastname" => $_SESSION['messaging_lastname'],
                "email" => $_SESSION['messaging_email'],
                "role_id" => $_SESSION['messaging_role_id'],
                "mobile_phone" => $_SESSION['messaging_mobile_phone'],
                "gender" => $_SESSION['messaging_gender'],
                "state" => $_SESSION['messaging_state'],
                "role_name" => $_SESSION['messaging_role_name'],
                "balance" => $_SESSION['messaging_balance'],
                "status" => $_SESSION['messaging_status'],
                "address" => $_SESSION['messaging_address'],
                "timezone" => $_SESSION['messaging_timezone'],
                "language" => $_SESSION['messaging_language'],
                "country" => $_SESSION['messaging_country'],
                "dob" => $_SESSION['messaging_dob'],
                "merchant_id" => isset($_SESSION['messaging_merchant_id']) ? $_SESSION['messaging_merchant_id'] : '',

            )
        );

        // generate jwt
        $jwt = JWT::encode($token, $this->tokenKey, $this->tokenAlgorithm);

        return $jwt;
    }

    public function generateAccessToken()
    {
        $token = array(
            "iat" => $this->tokenIssuedAt,
            "exp" => $this->tokenExpirationTime,
            "iss" => $this->tokenIssuer,
            "data" => array(
                "id" => $_SESSION['messaging_userid'],
                "firstname" => $_SESSION['messaging_firstname'],
                "lastname" => $_SESSION['messaging_lastname'],
                "email" => $_SESSION['messaging_email'],
                "role_id" => $_SESSION['messaging_role_id'],
                "username" => $_SESSION['messaging_username'],
                "mobile_phone" => $_SESSION['messaging_mobile_phone'],
                "gender" => $_SESSION['messaging_gender'],
                "state" => $_SESSION['messaging_state'],
                "role_name" => $_SESSION['messaging_role_name'],
                "balance" => $_SESSION['messaging_balance'],
                "status" => $_SESSION['messaging_status'],
                "address" => $_SESSION['messaging_address'],
                "timezone" => $_SESSION['messaging_timezone'],
                "language" => $_SESSION['messaging_language'],
                "country" => $_SESSION['messaging_country'],
                "dob" => $_SESSION['messaging_dob'],
                "merchant_id" => isset($_SESSION['messaging_merchant_id']) ? $_SESSION['messaging_merchant_id'] : '',
            )
        );

        // generate jwt
        $jwt = JWT::encode($token, $this->tokenKey, $this->tokenAlgorithm);

        return $jwt;
    }

    public function regenerateAccessToken($refresh_token)
    {

        // if decode succeed, show user details
        try {
            // decode jwt
            $key = new Key($this->tokenKey, $this->tokenAlgorithm);
            $decoded = JWT::decode($refresh_token, $key);

            if ($decoded->iss != $this->tokenIssuer) {
                return array('response_code' => '20', 'response_message' => "The provided authorization does not match this environment. Please, login again...");
            } else {

                //generate new token
                $data = json_decode(json_encode($decoded->data), true);
                if (!isset($_SESSION['messaging_username'])) {

                    $_SESSION['messaging_userid'] = $data['id'];
                    $_SESSION['messaging_firstname'] = $data['firstname'];
                    $_SESSION['messaging_lastname'] = $data['lastname'];
                    $_SESSION['messaging_email'] = $data['email'];
                    $_SESSION['messaging_role_id'] = $data['role_id'];
                    $_SESSION['messaging_username'] = $data['username'];
                    $_SESSION['messaging_mobile_phone'] = $data['mobile_phone'];
                    $_SESSION['messaging_gender'] = $data['gender'];
                    $_SESSION['messaging_state'] = $data['state'];
                    $_SESSION['messaging_role_name'] = $data['role_name'];
                    $_SESSION['messaging_balance'] = $data['balance'];
                    $_SESSION['messaging_status'] = $data['status'];
                    $_SESSION['messaging_address'] = $data['address'];
                    $_SESSION['messaging_timezone'] = $data['timezone'];
                    $_SESSION['messaging_language'] = $data['language'];
                    $_SESSION['messaging_country'] =  $data['country'];
                    $_SESSION['messaging_dob'] =  $data['dob'];
                    $_SESSION['messaging_merchant_id'] =  $data['merchant_id'];
                }

                //generate jwt token
                $access_token = $this->generateAccessToken();

                //generate jwt token
                $refresh_token = $this->generateRefreshToken();

                return json_encode(array('response_code' => 0, 'response_message' => 'Successful', 'data' => array('access_token' => $access_token, 'access_expiry' => $this->tokenExpirationTime, 'refresh_token' => $refresh_token)));
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
            if (strtolower(substr($message, '0',  '9')) == "malformed") {
                return json_encode(array('response_code' => 20, 'response_message' => 'Invalid Authorization Bearer Token Provided'));
            } elseif (strtolower(substr($message, '0',  '7')) == "expired") {
                return json_encode(array('response_code' => 20, 'response_message' => 'Please, login to continue.'));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Invalid System Authorization'));
            }
        }
    }

    private function doPostLoginActions()
    {

        //send login email

        //generate jwt token
        $access_token = $this->generateAccessToken();

        //generate jwt token
        $refresh_token = $this->generateRefreshToken();

        return json_encode(array('response_code' => 0, 'response_message' => 'Successful', 'data' => array('access_token' => $access_token, 'access_expiry' => $this->tokenExpirationTime, 'refresh_token' => $refresh_token)));
    }

    function resendActivation($data)
    {
        $link = $this->encrypt($data);

        $message = "
            <h5>!</h5>
            <div>
                <p>Please, follow this <a href='" . $this->base_url . "verify?_rd_=" . $link . "' style='text-decoration:none;'> link </a> to verify your account.</p>
                <p>If the above link is broken, copy " . $this->base_url . "verify?_rd_=" . $link . " and paste on browser.</p>
                    
            </div>";

        $subject = "Account Verification";

        $email_data = array(
            "to" => $data,
            "from" => 'noreply@' . $_SERVER['SERVER_NAME'],
            "subject" => $subject,
            "message" => $message,
            "logo" => $this->base_url . 'assets/images/10.png',
            "template" => $this->template . 'otp.php',
            "sender_name" => 'messaging',
            "channel" => 'mail'
        );

        return; //$this->notification->channel($email_data);
    }


    //this method is for user account creation
    public function createAccount($data)
    {
        try {
            $this->escape($data);

            $data['password'] = $this->encrypt($data['password']);
            $data['role_id'] = 300;
            $data['role_name'] = 'User';
            $data['username'] = $data['email'];
            $data['wallet_id'] = $this->generateWalletId();
            $data['created'] = date('Y-m-d H:i:s');
            $data['daily_limit'] = 1;
            $data['mobile_phone'] = '';
            $data['pass_expire'] = '';
            $data['pin_missed'] = '';
            $data['last_used'] = '';
            $data['user_type'] = '';
            $data['sex'] = '';
            $data['modified_date'] = '';
            $data['is_email_verified'] = 0;
            $data['email_token'] = '';
            $data['passchg_logon'] = 0;

            $stmt = $this->Insert('userdata', $data, ['type', 'confirm_password', 'terms', 'hci-csrf-token-label', 'PHPSESSID', 'pageid', 'amp_6e403e']);

            $this->deviceId($this->encrypt($data['username']));

            $data['column'] = 'email_token';
            $data['vtype'] = 'verification';

            $verify = [
                'type' => 'emfa',
                'username' => $data['email'],
                // 'authenticate' => $stmt['email']
            ];

            // Compose the email subject and messages
            $message = $alt_message = '';

            // Determine the message content based on verification type
            $message .= "<h4>Hello,</h4>";
            $message .= "<p>" . $data['email'] . " just created an account on messaging</p>";
            $alt_message .= "Hello,\n";
            $alt_message .= $data['email'] . " just created an account on messaging \n";

            // Compose email data
            $email_data = [
                "to" => $data['email'],
                // "from" => 'noreply@' . $_SERVER['SERVER_NAME'],
                "from" => 'davidakanang@gmail.com',
                "subject" => 'New User Account',
                "message" => $message,
                "sender_name" => 'messaging',
                // "logo" => $this->base_url . 'assets/img/logo.png',
                "template" => $this->template . 'otp.php',
                "type" => 'New User Account',
                "channel" => 'mail',
                "copy" => true,
                // "route" => 2,
                "alt_message" => $alt_message
            ];


            if ($stmt > 0) {
                $pin = json_decode($this->generate2FAPIN($data), true);
                // var_dump($pin);exit;
                if ($pin['response_code'] == 0) {
                    // Send the email notification to messaging
                    $send_mail = $this->notification->channel($email_data);

                    return json_encode(array('response_code' => 0, 'response_message' => 'Registration was successful', 'page' => 'verification', 'type' => $this->encrypt('emfa'), 'username' => $this->encrypt($data['email']), 'data' => $this->encryptPayload(json_encode($verify)), 'verify' => 1));
                } else {
                    $send_mail = $this->notification->channel($email_data);
                    return json_encode(array('response_code' => 0, 'response_message' => 'Registration was successful', 'verify' => 0, 'mail' => $send_mail));
                }
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Registration could not be processed'));
            }
        } catch (Exception $e) {
            return json_encode(array('respons_code' => '20', 'response_message' => $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function generateWalletId()
    {
        $wallet_id = $this->generateUniqueCode();

        $stmt = $this->db_connect("SELECT wallet_id FROM userdata WHERE wallet_id ='$wallet_id'");
        if (is_array($stmt) && sizeof($stmt) > 0) {
            // User ID already exists, generate a new one and return it
            return $this->generateWalletId(); // Call the function recursively to generate a new ID
        } else {
            // User ID is unique, return it
            return $wallet_id;
        }

        return $wallet_id;
    }

    private function generateUniqueCode()
    {
        return str_pad(mt_rand(1000000000, 9999999999), 10, '0', STR_PAD_LEFT);
    }

    //this method is for password recovery link
    // public function passwordLink($data)
    // {
    //     try {

    //         if (empty($data['username'])){
    //             return json_encode(array('response_code' => 20, 'response_message' => 'Please, enter your email address'));
    //         }else{
    //             $email = $data['username'];

    //             $stmt = $this->db_connect("SELECT firstname, email FROM userdata WHERE email='$email'");
    //             if(is_array($stmt) && count($stmt) > 0){

    //                 $link = $this->encrypt(date('Y-m-d h:i:s').'::'.$data['username']);

    //                 $header = 'Password Link';

    //                 $subject = $header;

    //                 $message = "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px'><h5>Hello <b style='text-transform:uppercase;'>".$stmt[0]['firstname'].",</b></h5></p>";

    //                 $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px;>Please, follow this <a href='" . $this->base_url . "reset-password?rl=" . $link . "' style='text-decoration:none;' class='btn btn-primary'> link </a> to reset your password.</p>";

    //                 $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px;>If the above link is broken, copy " . $this->base_url . "reset-password?rl=" . $link . " and paste on your browser to continue.</p>";

    //                 $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px;>Thank you for choosing messaging.</p>";  

    //                 $email_data = array(
    //                     "to" => $data['username'],
    //                     "from" => 'noreply@messaging.com.au',
    //                     "subject" => $subject,
    //                     "message" => $message,
    //                     "logo" => $this->base_url . 'assets/images/10.png',
    //                     "template" => $this->template . 'otp.php',
    //                     "type" => $header,
    //                     "sender_name" => 'messaging',
    //                     "channel" => 'mail'
    //                 );
    //                 $stmt = $this->Update("userdata", ['reset_pwd_link'=>$link,'pass_change' => 1],[], ['email'=>$email]);
    //                 if ($stmt > 0){

    //                     $stmt = json_decode(//$this->notification->channel($email_data), true);

    //                     if ($stmt['response_code'] == 0){
    //                         return json_encode(array('response_code' => 0, 'response_message' => 'Your password recovery link has been sent the provided email address.'));
    //                     }else{
    //                         return json_encode(array('response_code' => 20, 'response_message' => 'Check your internet connection and try again.'));
    //                     }
    //                 }else{
    //                     return json_encode(array('response_code' => 20, 'response_message' => 'Your request could not be processed.'));
    //                 }
    //             }else{
    //                 return json_encode(array('response_code' => 20, 'response_message' => 'The supplied email address does not exist'));
    //             }
    //         }
    //     } catch (Exception $e) {

    //         return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
    //     }
    // }

    //this method is for newsletter subscription 
    public function subscribe($data)
    {
        $email = (!empty($data['email'])) ? $data['email'] : "";

        if (empty($email)) :
            return json_encode(array('response_code' => 20, 'response_message' => 'Please, enter your email address'));
        else :
            $stmt = json_decode($this->runQuery("SELECT subscriber FROM newsletter WHERE subscriber='$email'"), true);
            if ($stmt['count'] > 0) :
                return json_encode(array('response_code' => 20, 'response_message' => 'This subscriber already exists'));
            else :
                $sub['subscriber'] = $email;
                $sub['status'] = 0;
                $stmt = $this->Insert("newsletter", $sub, ['hci-csrf-token-label', 'usage_channel']);
                $message = "
                    <p><b>Dear Subscriber,</b></p>
                    <div class='activity-card' style='background: white; margin-top: 10px; border-bottom: 2px solid #24C8A6; text-align: justify; color: grey;'>
                                            
                        <p>Your subscription to our Events Newsletter was successful.</p>

                        <p>Thank you.</p>
                    
                    </div>";

                $subject = "Newsletter Subscription";

                $data = array(
                    'message' => $message,
                    'to' => $email,
                    'subject' => $subject,
                    "channel" => 'mail'
                );
                if ($stmt['count'] > 0) :
                    $stmt = //$this->notification->channel($data); //send notification to subscriber on a successful subscription
                        $status = json_decode($stmt, true);

                    if ($status == true) :
                        return json_encode(array('response_code' => 0, 'response_message' => 'Your subscription was successful.'));
                    else :
                        return json_encode(array('response_code' => 20, 'response_message' => 'Newsletter subscription was successful, but we could not send mail to your email address because your system is hosted locally.'));
                    endif;
                else :
                    return json_encode(array('response_code' => 20, 'response_message' => 'Your request could be processed. Please, try again.'));
                endif;
            endif;
        endif;
    }

    public function generateAccountNo($data)
    {
        try {
            $stmt = json_decode($this->flutter->virtual($data), true);
            if (isset($stmt['status']) && $stmt['status'] == 'success') {
                $acct['account_number'] = $stmt['data']['account_number'];
                $acct['account_name'] = $stmt['data']['account_name'];
                $acct['bank_name'] = $stmt['data']['bank_name'];
                $acct['order_ref'] = $stmt['data']['order_ref'];
                $acct['flw_ref'] = $stmt['data']['flw_ref'];
                $acct['payload'] = json_encode($stmt);

                $stmt = $this->Insert('generated_account_details', $acct, []);

                return json_encode(array('response_code' => 0, 'response_message' => $acct['account_number']));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => $stmt['message']));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> ACCOUNT_MODEL => Error: " . $e->getMessage() . ' on line ' . $e->getLine();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            echo json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    // this method handles all sales reports [paid, queued, sold, available] operations
    public function Chart($data)
    {
        try {

            $cat = (!empty($data['action'])) ? " AND c.category_name = '" . $data['action'] . "'" : "";
            $filter = '';
            if ($_SESSION['messaging_role_id'] == 5) {
                $filter .= " AND p.merchant_id =" . $_SESSION['messaging_userid'];
            }

            $stmt = json_decode($this->runQuery("SELECT p.id, p.item_name AS name, p.available_qty AS qty, p.unit_price AS price, 
            p.item_logo AS image, p.sub_category AS category, p.is_deleted AS active, p.created,p.sku FROM items AS p INNER 
            JOIN category AS c ON c.id=p.sub_category WHERE 1=1 $filter ORDER BY p.id"), true);

            $available = $stmt['data'];

            $stmt = json_decode($this->runQuery("SELECT SUM(p.available_qty) AS available_qty FROM items AS p  INNER JOIN category AS c ON c.id=p.sub_category WHERE 1=1 $filter  GROUP BY c.id"), true);

            $available_sum = ($stmt['count'] > 0) ? $stmt['row']['available_qty'] : 0;

            $stmt = json_decode($this->runQuery("SELECT o.*, sum(o.qty) AS qty, p.item_name FROM orders AS o INNER JOIN items AS p ON p.id=o.item_id INNER JOIN category AS c ON c.id=p.sub_category WHERE o.status IN (1) AND o.payment IN (1) $filter GROUP BY o.item_id"), true);

            $sold = $stmt['data'];

            $stmt = json_decode($this->runQuery("SELECT  SUM(o.qty) AS sold_qty FROM orders AS o INNER JOIN items AS p ON p.id=o.item_id INNER JOIN category AS c ON c.id=p.sub_category  WHERE o.status IN (1) AND o.payment IN (1)  $filter  GROUP BY c.id"), true);

            $sold_sum = ($stmt['count'] > 0) ? $stmt['row']['sold_qty'] : 0;

            $stmt = json_decode($this->runQuery("SELECT o.*, sum(o.qty) AS qty, p.item_name FROM orders AS o INNER JOIN items AS p ON o.item_id=p.id INNER JOIN category AS c ON c.id=p.sub_category WHERE o.status IN (0) AND o.payment IN (0) $filter GROUP BY o.item_id"), true);

            $awaiting = $stmt['data'];

            $stmt = json_decode($this->runQuery("SELECT SUM(o.qty) AS awaiting_qty FROM orders AS o INNER JOIN items AS p ON o.item_id=p.id INNER JOIN category AS c ON c.id=p.sub_category WHERE o.status IN (0) AND o.payment IN (0) $filter  GROUP BY c.id"), true);

            $awaiting_sum = ($stmt['count'] > 0) ? $stmt['row']['awaiting_qty'] : 0;

            $stmt = json_decode($this->runQuery("SELECT o.*, sum(o.qty) AS qty, p.item_name FROM orders AS o INNER JOIN items AS p ON p.id=o.item_id INNER JOIN category AS c ON c.id=p.sub_category WHERE o.status IN (0) AND o.payment IN (1) $filter GROUP BY o.item_id"), true);

            $paid = $stmt['data'];

            $stmt = json_decode($this->runQuery("SELECT SUM(o.qty) AS paid_qty FROM orders AS o INNER JOIN items AS p ON p.id=o.item_id 
            INNER JOIN category AS c ON c.id=p.sub_category  WHERE o.status IN (0) AND o.payment IN (1) $filter  GROUP BY c.id"), true);

            $paid_sum = ($stmt['count'] > 0) ? $stmt['row']['paid_qty'] : 0;

            return ($stmt) ? json_encode(
                array(
                    'available' => $available,
                    'sold' => $sold,
                    'awaiting' => $awaiting,
                    'paid' => $paid,
                    'available_qty' => !empty($available_sum) ? $available_sum : 0,
                    'sold_qty' => !empty($sold_sum) ? $sold_sum : 0,
                    'awaiting_qty' => !empty($awaiting_sum) ? $awaiting_sum : 0,
                    'paid_qty' => $paid_sum
                )
            ) : false;
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> CHART_MODEL => Error: " . $e->getMessage() . ' on line: ' . $e->getLine();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 0, 'response_message' => 'Error: ' . $e->getMessage() . ' on line: ' . $e->getLine()));
        }
    }

    public function decrypt($data)
    {
        // return $data;
        $this->encryption = new Encryption($this->key, $this->iv);

        return $this->encryption->decryptData($data);
    }
    public function decryptPayload($data)
    {
        $this->encryption = new Encryption($this->key, $this->iv);

        return $this->encryption->decryptPayload($data);
    }
    public function encryptPayload($data)
    {
        $this->encryption = new Encryption($this->key, $this->iv);

        return $this->encryption->encryptPayload($data);
    }

    public function decryptAPI($data)
    {
        // return $data;
        $this->encryption = new Encryption($this->key, $this->iv);

        return $this->encryption->decryptAPIData($data);
    }

    public function encrypt($data)
    {
        $this->encryption = new Encryption($this->key, $this->iv);

        return $this->encryption->encryptData($data);
    }
    public function encryptAPI($data)
    {
        $this->encryption = new Encryption($this->key, $this->iv);

        return $this->encryption->encryptAPIData($data);
    }

    public function userList()
    {
        try {
            return $this->SelectAll('userdata');
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> USERDATA_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function validatePasswordLink($data)
    {
        try {
            if (isset($data['rl']) && $data['rl'] != "") {
                $stmt = $this->Select('userdata', 'reset_pwd_link', str_replace(' ', '+', $data['rl']));

                if (is_array($stmt) && sizeof($stmt) > 0) {
                    $link = $stmt['reset_pwd_link'];
                    $payload = $this->decrypt($link);
                    $payload = explode('::', $payload);
                    $timestamp = $payload[0];
                    $email = $payload[1];

                    $date1  = strtotime($timestamp);
                    $date2  = strtotime(date('Y-m-d h:i:s'));
                    // Formulate the Difference between two dates 
                    $diff   = abs($date2 - $date1);
                    // To get the year divide the resultant date into 
                    // total seconds in a year (365*60*60*24) 
                    $years  = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days   = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                    $hours  = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));

                    if ($hours > 48) {
                        return json_encode(array('response_code' => 20, 'response_message' => 'This link has expired.'));
                    } else {
                        return json_encode(array('response_code' => 0, 'data' => array('firstname' => $stmt['firstname'])));
                    }
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'This link is invalid'));
                }
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'The link has been tampered with.'));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function completeResetPassword($data)
    {
        try {
            $validate = $this->validate(
                $data,
                array('password' => 'required|min:8|matches:cpassword'),
                array('password' => 'Password', 'confirm_password' => 'Password')
            );

            if ($validate['error']) {
                return json_encode(array('response_code' => 20, 'response_message' => $validate['messages'][0]));
            }

            $payload = $this->decrypt(str_replace(' ', '+', $data['rl']));
            $payload = explode('::', $payload);
            $username = $payload[1];

            $current_password = $this->SelectOne('userdata', 'username', $username, 'password');

            $password = $this->encrypt($data['password']);

            if ($current_password == $password) {
                return json_encode(array('response_code' => 20, 'response_message' => 'Password must not be the same as the current password'));
            }

            $update['password'] = $password;
            $update['reset_pwd_link'] = '';
            $update['pass_change'] = 0;

            $stmt = $this->Update('userdata', $update, [], array('email' => $username));

            if ($stmt > 0) {
                return json_encode(array('response_code' => 0, 'response_message' => 'Your password has been successfully updated'));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Your password could not be updated'));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function contactUs($data)
    {
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return json_encode(array('response_code' => 20, 'response_message' => 'Invalid email address.'));
        }

        $message = '<br /><br /><p>Please, reply to ' . $data['email'];

        $email_data = array(
            "to" => 'info@messaging.com.au',
            // "to" => 'info@'.$_SERVER['SERVER_NAME'],
            "from" => $data['email'],
            "subject" => $data['subject'],
            "message" => $data['message'] . $message,
            "logo" => $this->base_url . 'assets/images/10.png',
            "full_name" => $data['name'],
            "sender_name" => $data['name'],
            "template" => $this->template . 'otp.php',
            "channel" => 'mail'
        );

        $mail = json_decode($this->notification->channel($email_data), true);
        if ($mail['response_code'] == 0) {
            return json_encode(array('response_code' => 0, 'response_message' => 'Thank you for reaching out to us. We\'ll get back to you shortly.'));
        } else {
            return json_encode(array('response_code' => 20, 'response_message' => $mail['response_message']));
        }
    }

    function Insert($table, $arr, $exp_arr)
    {
        $str1  = "(";
        $str2  = "(";
        $this->escape($arr);

        foreach ($arr as $key => $value) {
            if (!in_array($key, $exp_arr)) {
                $str1 .= $key . ",";
                $str2 .= "'" . $value . "',";
            }
        }
        $str1 =  substr($str1, 0, -1) . ")";
        $str2 =  substr($str2, 0, -1) . ")";
        $sql = "INSERT INTO " . $table . " " . $str1 . " VALUES " . $str2;

        $error_msg = date('Y-m-d H:i:s') . " >>>> INSERT_QUERY: " . $sql;
        if (file_exists($this->logfile . 'insert_' . $this->current_date . '.php')) {
            file_put_contents($this->logfile . 'insert_' . $this->current_date . '.php', $error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);
        }
        return $this->runCRUD($sql);
    }

    function Update($table, $arr, $exp_arr, $clause)
    {
        $str1     = "";
        $key_id     = "";

        $this->escape($arr);

        foreach ($arr as $key => $value) {
            if (!in_array($key, $exp_arr)) {
                $str1 .= $key . "='" . $value  . "',";
            }
        }
        foreach ($clause as $key => $value) {
            $key_id .= " " . $key . "='" . $value . "' AND";
        }

        $key_id  =  substr($key_id, 0, -3);
        $patch1  =  substr($str1, 0, -1);

        $sql    = "UPDATE " . $table . " SET " . $patch1 . " WHERE " . $key_id;
        // echo $sql    = "UPDATE " . $table . " SET " . $patch1 . " WHERE " . $key_id;exit;

        $error_msg = date('Y-m-d H:i:s') . " >>>> UPDATE_QUERY: " . $sql;

        if (file_exists($this->logfile . 'update_' . $this->current_date . '.php')) {
            file_put_contents($this->logfile . 'update_' . $this->current_date . '.php', $error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        return $this->runCRUD($sql);
    }

    public function createUserAcct($data)
    {
        try {

            if ($data['action'] == 'new') {

                $get_acct = $this->SelectOne('userdata', 'username', $data['email'], 'email');
                if ($get_acct != "") {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Email address is already in use.'));
                }

                $mobile_number = $this->SelectOne('userdata', 'mobile_phone', $data['mobile_phone'], 'mobile_phone');

                if ($mobile_number != "") {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Phone number is already in use.'));
                }

                $password = $this->passwordGen();
                $data['role_name'] = $this->SelectOne('role', 'role_id', $data['role_id'], 'role_name');
                $data['password'] = $password['password'];
                $data['wallet_id'] = $this->generateWalletId();
                $data['username'] = $data['email'];
                $data['created'] = date('Y-m-d h:i:s');
                $data['daily_limit'] = 1;
                $data['pass_expire'] = '';
                $data['pin_missed'] = '';
                $data['last_used'] = '';
                $data['user_type'] = '';
                $data['modified_date'] = '';
                $data['is_email_verified'] = 1; //verify email address by default
                $data['is_mfa'] = 1; //enforce mfa by default
                $data['email_token'] = '';
                $data['passchg_logon'] = 0;

                $stmt = $this->Insert('userdata', $data, ['id', 'action', 'type', 'hci-csrf-token-label', 'PHPSESSID', 'pageid']);

                //set the account's device ID
                $this->deviceId($data['username']);

                $data['column'] = 'email_token';
                $data['vtype'] = 'verification';

                if ($stmt > 0) {
                    $header = 'Login credentials';

                    $subject = $header;

                    $message = "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px'>Hello, {$data['firstname']} </p>";

                    $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px'>You have been profiled as {$data['role_name']}. And your login details are: </p>";

                    $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px'><b>Username:</b> " . $data['email'] . "</p>";

                    $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px'><b>Password:</b> " . $password['plain'] . "</p>";

                    $email_data = array(
                        "to" => $data['email'],
                        "from" => 'noreply@' . $_SERVER['SERVER_NAME'],
                        "subject" => $subject,
                        "message" => $message,
                        "logo" => $this->base_url . 'assets/images/10.png',
                        "template" => $this->template . 'otp.php',
                        "type" => $header,
                        "sender_name" => 'messaging',
                        "channel" => 'mail'
                    );

                    $feedback = '';
                    $stmt = json_decode($this->notification->channel($email_data), true);
                    if ($stmt['response_code'] == 20) {
                        $feedback .= 'Password could not be mailed';
                    }

                    return json_encode(array('response_code' => 0, 'response_message' => 'Account has been successful created. ' . $feedback));
                } else {
                    return json_encode(array('response_code' => 0, 'response_message' => 'Registration could not be processed'));
                }
            } elseif ($data['action'] == 'edit') {
                $data['role_name'] = $this->SelectOne('role', 'role_id', $data['role_id'], 'role_name');

                $stmt = $this->Update('userdata', $data, ['id', 'type', 'action', 'hci-csrf-token-label', 'SSID', 'PHPSESSID', 'pageid'], ['wallet_id' => $data['id']]);
                if ($stmt > 0) {
                    return json_encode(array('response_code' => 0, 'response_message' => 'Record has been updated successfully.'));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Record could not be updated.'));
                }
            }
        } catch (Exception $e) {

            echo json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function passwordGen()
    {
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!#*&^_';
        $password = rand(00, 9999999999);
        $password = substr(str_shuffle($str . $password), 0, 10);
        return array(
            'plain' => $password,
            'password' => $this->encrypt($password)
        );
    }

    public function pendingSettlement()
    {
        try {
            $stmt = json_decode($this->runQuery("SELECT sum(a.price) AS total, a.order_ref AS ref, c.business_name AS shop, b.account_name AS name, b.bank_name AS bank, b.account_number AS digits, recipient_code AS code, DATE(a.ordered_date) AS `date`, c.percentage_charge AS percent, a.settlement AS `status` FROM orders AS a INNER JOIN transfer_recepients AS b ON b.merchant_id=a.merchant_id INNER JOIN subaccounts AS c ON c.merchant_id=a.merchant_id INNER JOIN transaction_table AS d ON d.order_reference=a.order_ref WHERE a.payment IN (1) AND a.settlement IN (0) GROUP BY a.merchant_id, DATE(a.ordered_date)"), true);

            return ($stmt['count'] > 0) ? $stmt['data'] : 0;
        } catch (Exception $e) {
            $error_msg = date('Y-m-d H:i:s') . " >>>> FETCH_PENDING_SETTLEMENTS_MODEL => Error: " . $e->getMessage() . ' on line ' . $e->getLine();

            file_put_contents($this->logfile . $this->current_date . '.php', $error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            echo json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function profile($data)
    {
        try {
            $get_cell = $this->SelectAllWhere('userdata', 'mobile_phone', $data['mobile_phone'])[0];
            if ($get_cell != "" && ($get_cell['wallet_id'] != $_SESSION['messaging_userid'])) {
                return json_encode(array('response_code' => 20, 'response_message' => 'Phone number already exists.'));
            }

            $stmt = $this->Update('userdata', $data, ['type', 'hci-csrf-token-label', 'SSID', 'PHPSESSID', 'pageid'], ['wallet_id' => $_SESSION['messaging_userid']]);
            if ($stmt > 0) {

                $_SESSION['messaging_firstname'] = $data['firstname'];
                $_SESSION['messaging_lastname'] = $data['lastname'];
                $_SESSION['messaging_mobile_phone'] = $data['mobile_phone'];
                $_SESSION['gender'] = $data['sex'];
                return json_encode(array('response_code' => 0, 'response_message' => 'Your profile has been successfully updated.'));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Your profile could not be updated.'));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function generateOTP($data)
    {
        try {
            $get_order = $this->SelectAllWhere('orders', 'order_ref', $data['id'])[0];
            if ($get_order == "") {
                return json_encode(array('response_code' => 20, 'response_message' => 'Invalid Order Reference'));
            }
            $otp['otp'] = substr(uniqid(), 0, 6);
            $stmt = $this->Update('orders', $otp, ['hci-csrf-token-label', 'SSID', 'PHPSESSID', 'usage_channel'], ['order_ref' => $data['id']]);
            if ($stmt > 0) {

                //retrieve customer's information
                $customer = $this->SelectAllWhere('userdata', 'user_id', $get_order['user_id'])[0];
                $customer_email = $customer['email'];
                $customer_name = $customer['firstname'];
                $customer_phone = $customer['mobile_phone'];

                $customer_message = '
                    <p>Your OTP for package Id ' . $get_order['package_id'] . ' is <b>' . $otp['otp'] . '</b>.</p>';
                $customer_message .= '<p></p><p>Do not share this OTP over the phone.</p>';

                $customer_data = array(
                    "to" => $customer_email,
                    "from" => 'otp@' . $_SERVER['SERVER_NAME'],
                    "subject" => "Your OTP For  Order [" . $data['id'] . "]",
                    "message" => $customer_message,
                    "logo" => $this->base_url . 'assets/images/10.png',
                    "full_name" => $customer_name,
                    "template" => $this->template . 'notification.php',
                    "channel" => 'mail'
                );

                $msg = '';
                $customer_mail = json_decode($this->notification->channel($customer_data), true); //send notification to customer

                if ($customer_mail['response_code'] == 20) {
                    $msg .= '[' . $customer_mail['response_message'] . ']';
                }

                return json_encode(array('response_code' => 0, 'response_message' => 'OTP Sent ' . $msg));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Error generating OTP'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> GENERATE_OTP_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function verify($data)
    {
        try {
            $key = $this->decrypt($data['_rd_']);
            $stmt = $this->SelectOne('userdata', 'email', $key, 'email');
            if ($stmt != "") {
                $status['status'] = 1;
                $stmt = $this->Update('userdata', $status, ['hci-csrf-token-label', 'SSID', 'PHPSESSID', 'usage_channel'], ['email' => $key]);
                if ($stmt > 0) {
                    return json_encode(array('response_code' => 0, 'response_message' => 'Your account has been successfully verified.'));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Your account could not be verified.'));
                }
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Invalid verification key.'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> ACCOUNT_VERIFICATION_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function validate2FA($data)
    {
        try {


            $otp = $data['digit-1'] . $data['digit-2'] . $data['digit-3'] . $data['digit-4'] . $data['digit-5'] . $data['digit-6'];

            $username = $data['username'];
            $password  = $this->SelectOne('userdata', 'email', $username, 'password');

            $pin['otp_date'] = '';

            $stmt = $this->Select('userdata', 'email', $username);

            if ($data['vtype'] != 'mfa') {
                //check if account has been previously activated
                if ($stmt['is_email_verified'] == 1) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'This account has already been verified.'));
                }
            }

            if ($data['vtype'] != 'mfa') {
                $pin['email_token'] = '';
                $key = $stmt['email_token'];
                $type = 'Account verification code';
                $pin['is_email_verified'] = 1;
            } else {
                $pin['mfa_otp'] = '';
                $key = $stmt['mfa_otp'];
                $type = '2-FA Pin';
            }

            if ($key != $otp) {
                return json_encode(array('response_code' => 20, 'response_message' => 'Invalid ' . $type));
            }

            $date = isset($stmt['otp_date']) ? $stmt['otp_date'] : '';

            $date1  = strtotime($date);
            $date2  = strtotime(date('Y-m-d h:i:s'));
            // Formulate the Difference between two dates 
            $diff   = abs($date2 - $date1);
            // To get the year divide the resultant date into 
            // total seconds in a year (365*60*60*24) 
            $years  = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days   = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            $hours  = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
            $mins  = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60) / (60));
            if ($mins > 10) {
                return json_encode(array('response_code' => 20, 'response_message' => 'This ' . $type . ' has expired', 'expired' => true));
            } else {

                if ($data['vtype'] != 'mfa') {
                    $stmt = $this->Update('userdata', $pin, [], array('email' => $username, 'email_token' => $otp));
                } else {
                    $stmt = $this->Update('userdata', $pin, [], array('email' => $username, 'mfa_otp' => $otp));
                }

                $password = $this->decrypt($password);

                if ($stmt == 1) {
                    $retval = json_decode($this->signIn($username, $password), true);
                    return json_encode(array('response_code' => $retval['response_code'], 'response_message' => $retval['response_message'], 'status' => isset($retval['status']) ? $retval['status'] : ''));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Invalid ' . $type));
                }
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function isAesEncoded($text)
    {
        // If the decryption is successful, it means the text was AES encoded
        if ($this->decrypt($text) !== false) {
            return true;
        }

        return false;
    }

    public function verifyByLink($data)
    {
        if (!isset($data['ga']) || (isset($data['ga']) && $data['ga'] == "")) {
            return json_encode(['response_code' => 20, 'response_message' => 'The link is invalid or has been tampared with.']);
        }

        $link = str_replace([' '], '+', $data['ga']);
        $payload = $this->decrypt($link);
        $payload = explode('::', $payload);

        $username = $payload[0];
        $pin = $payload[1];

        if ($username == '' || $pin == '') {
            return json_encode(['response_code' => 20, 'response_message' => 'The link is invalid or has been tampared with.']);
        }

        $get_status = $this->SelectArr('userdata', ['email'], [$username], ['firstname', 'is_email_verified', 'email_token']);
        if ($get_status == "") {
            return json_encode(['response_code' => 20, 'response_message' => 'Invalid account']);
        }

        if (!in_array($get_status['is_email_verified'], [0, '0'])) {
            return json_encode(['response_code' => 20, 'response_message' => 'This account has already been activated. You can <a href="' . $this->base_url . 'login">Login from here</a>']);
        }

        if ($get_status['email_token'] != $pin) {
            return json_encode(['response_code' => 20, 'response_message' => 'This link has expired.']);
        }

        $verify = [
            'is_email_verified' => 1,
            'email_token' => ''
        ];
        // Update the user data with the verification information
        $stmt = $this->Update('userdata', $verify, [], ['email' => $username]);
        if ($stmt > 0) {
            return json_encode(['response_code' => 0, 'response_message' => 'Your account has been successfully activated.', 'firstname' => $get_status['firstname']]);
        } else {
            return json_encode(['response_code' => 20, 'response_message' => 'Sorry, we could not process your request at the moment. Please, try again later.']);
        }
    }
    public function generate2FAPIN($data)
    {
        try {
            // Extract username from $data (either from array or directly)
            // var_dump($data);exit;
            if (is_array($data)) {

                $username = $data['email'];
            } else {
                $username = $data;
            }

            if (isset($data['redirect']) && in_array($data['redirect'], [1, '1'])) {

                if ($username == "") {
                    return json_encode(['response_code' => 20, 'response_message' => 'Enter your email address']);
                }

                $get_status = $this->SelectArr('userdata', ['email'], [$username], ['firstname', 'is_email_verified']);
                if ($get_status == "") {
                    return json_encode(['response_code' => 20, 'response_message' => 'Invalid email address']);
                }

                if (!in_array($get_status['is_email_verified'], [0, '0'])) {
                    return json_encode(['response_code' => 20, 'response_message' => 'This account has already been activated.']);
                }

                $payload = [
                    'type' => 'emfa',
                    'username' => $data['username'],
                    // 'authenticate' => $get_status['firstname']
                ];
            }


            // Generate a 6-character PIN
            $pin = substr(str_shuffle('12345678900987654321'), 0, 6);

            // Prepare the verification data
            $verify = [
                'otp_date' => date('Y-m-d h:i:s')
            ];

            // Determine the type of verification and set the appropriate fields
            if (isset($data['vtype'])) {
                if ($data['vtype'] != 'mfa') {
                    $verify['email_token'] = $pin;
                    $header = 'Authentication PIN';
                    // $header = 'Verification Code';
                } else {
                    $verify['mfa_otp'] = $pin;
                    $header = '2-Factor Authentication PIN';
                }
            } else {
                if (isset($data['column'])) {
                    $verify['email_token'] = $pin;
                    $header = 'Authentication PIN';
                    // $header = 'Verification Code';
                } else {
                    $verify['mfa_otp'] = $pin;
                    $header = '2-Factor Authentication PIN';
                }
            }

            // Update the user data with the verification information
            $stmt = $this->Update('userdata', $verify, [], ['email' => $username]);

            // Compose the email subject and messages
            $subject = $header;
            $message = $alt_message = '';

            // Determine the message content based on verification type
            if ((isset($data['column']) && $data['column'] == 'email_token') || (isset($data['vtype']) && $data['vtype'] == 'emfa')) {
                $link = $username . "::" . $pin;
                // $message .= "<p>". $verify['email_token'] . "</p>";
                $message .= "<p>Your " . ucfirst($header) . " is " . $verify['email_token'] . "</p>";
                $message .= "<br />";
                $message .= "<p>Alternaively, you can use this <a href='" . $this->base_url . "verify?ga=" . $this->encrypt($link) . "' style='text-decoration:none;'> link </a> to verify your account.</p>";
                $message .= "<p>If the above link is broken, copy " . $this->base_url . "verify?ga=" . $this->encrypt($link) . " and paste on browser.</p>";

                $alt_message .= "Your " . ucfirst($header) . " is " . $verify['email_token'] . "\n";
                $alt_message .= "\n";
                $alt_message .= "Alternaively, you can use this <a href='" . $this->base_url . "verify?ga=" . $this->encrypt($link) . "' style='text-decoration:none;'> link </a> to verify your account.\n";
                $alt_message .= "If the above link is broken, copy " . $this->base_url . "verify?ga=" . $this->encrypt($link) . " and paste on browser.";
            } else {
                $message .= "<p><b>" . $verify['mfa_otp'] . "</b> is your " . ucfirst($header) . "</p>";
                $alt_message .= $verify['mfa_otp'] . " is your " . ucfirst($header) . "\n";
            }

            // Compose email data
            $email_data = [
                "to" => $username,
                // "from" => 'noreply@' . $_SERVER['SERVER_NAME'],
                "from" => 'davidakanang@gmail.com',
                "subject" => $subject,
                "message" => $message,
                "sender_name" => 'messaging',
                // "logo" => $this->base_url . 'assets/img/logo.png',
                "template" => $this->template . 'otp.php',
                "type" => $header,
                "channel" => 'mail',
                // "route" => 2,
                "alt_message" => $alt_message
            ];

            // var_dump($email_data);exit;
            // Send the email notification
            // var_dump($this->notification);
            $stmt = json_decode($this->notification->channel($email_data), true);
            // var_dump($stmt);exit;
            $send_mail = $this->notification->channel($email_data);

            if ($stmt['response_code'] == 0) {
                if (isset($data['redirect']) && in_array($data['redirect'], [1, '1'])) {
                    return json_encode(array('response_code' => 0, 'response_message' => 'Activation code has been sent to your email address.', 'page' => 'verification', 'type' => $this->encrypt('emfa'), 'username' => $this->encrypt($payload['username']), 'authenticate' => $this->encrypt($payload['firstname']), 'data' => $this->encryptPayload(json_encode($payload)), 'verify' => 1, 'send_mail' => $send_mail));
                } else {

                    return json_encode(['response_code' => $stmt['response_code']]);
                }
            } else {
                return json_encode(['response_code' => $stmt['response_code'], 'response_message' => $stmt['response_message']]);
            }
        } catch (Exception $e) {
            return json_encode(['response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()]);
        }
    }

    public function generate2FAPIN_main($data)
    {
        try {


            if (is_array($data)) {
                $username = $data['username'];
            } else {
                $username = $data;
            }

            $pin = substr(str_shuffle('12345678900987654321'), 0, 6);
            $verify['otp_date'] = date('Y-m-d h:i:s');

            if (isset($data['vtype'])) {
                if ($data['vtype'] != 'mfa') {
                    $verify['email_token'] = $pin;
                    $header = ' Verification Code';
                } else {
                    $verify['mfa_otp'] = $pin;
                    $header = ' Verification Code';
                    // $header = ' 2-Factor Authenticaion PIN';
                }
            } else {
                if (isset($data['column'])) {
                    $verify['email_token'] = $pin;
                    $header = ' Verification Code';
                } else {
                    $verify['mfa_otp'] = $pin;
                    $header = ' Verification Code';
                }
            }

            $stmt = $this->Update('userdata', $verify, [], array('email' => $username));

            $subject = $header;
            $message = $alt_message = '';
            if (isset($data['column']) && $data['column'] == 'email_token') {
                // if((isset($data['column']) && $data['column'] == 'email_token') || (isset($data['vtype']) && $data['vtype'] == 'emfa')){
                $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px'>You are almost there...</p>";

                $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px'>Your " . ucfirst($header) . " is " . $verify['email_token'] . "</p>";

                $alt_message .= "You are almost there... \n";
                $alt_message .= "Your " . ucfirst($header) . " is " . $verify['email_token'] . " \n";
            } else {
                $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px'><b>" . $verify['mfa_otp'] . "</b> is your " . ucfirst($header) . "</p>";

                $alt_message .= $verify['mfa_otp'] . " is your " . ucfirst($header) . " \n";
            }


            $email_data = array(
                "to" => $username,
                "from" => 'noreply@' . $_SERVER['SERVER_NAME'],
                "subject" => $subject,
                "message" => $message,
                "sender_name" => 'messaging',
                "logo" => $this->base_url . 'assets/img/10.png',
                "template" => $this->template . 'otp.php',
                "type" => $header,
                "channel" => 'mail',
                "route" => 2,
                "alt_message" => $alt_message
            );


            // $stmt = json_decode($email_data);//$this->notification->channel($email_data), true);
            // var_dump($stmt);exit;

            if ($stmt['response_code'] == 0) {
                return json_encode(array('response_code' => $stmt['response_code']));
            } else {
                return json_encode(array('response_code' => $stmt['response_code'], 'response_message' => $stmt['response_message']));
            }
        } catch (Exception $e) {

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function updateAddress($data)
    {
        try {
            $stmt = $this->Update('billing_address', $data, ['type', 'SSID', 'PHPSESSID', 'hci-csrf-token-label', 'usage_channel'], array('user_id' => $_SESSION['messaging_userid']));

            if ($stmt == 1) {
                return json_encode(array('response_code' => 0, 'response_message' => 'Your address has been successfully updated.'));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Something went wrong... Please, try again.'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> UPDATE_ADDRESS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function completeChangePassword($data)
    {
        try {
            if (isset($data['usage_channel']) && $data['usage_channel'] != "") {
                $username = $this->encrypt($data['id']);
            } else {
                $username = $this->encrypt($_SESSION['messaging_userid']);
            }

            $update['password'] = $data['new-password'];
            $update['password_lastmodified'] = date('Y-m-d h:i:s');
            $user_curr_password = $this->encrypt($data['current-password']);

            $stmt = json_decode($this->runQuery("SELECT wallet_id FROM userdata WHERE wallet_id = '$username' AND password = '$user_curr_password'"), true);
            if ($stmt['count'] == 1) {

                if ($data['current-password'] == $data['new-password']) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Kindly choose a password that is different from your current password.'));
                }

                $current_data = $this->getCurrentData('userdata', 'wallet_id', $username);

                $stmt = $this->Update('userdata', $update, [], ['wallet_id' => $username]);

                if ($stmt > 0) {

                    $this->logActivity($current_data, $data, ["table_name" => 'userdata', "table_id" => $current_data['user_id'], "table_alias" => 'Password Change'], ['type', 'new-password', 'current-password', 'confirm-password', 'hci-csrf-token-label', 'usage_channel']);
                    return json_encode(array('response_code' => 0, 'response_message' => 'Your password was changed successfully', 'remark' => 'Logging you out...'));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Your password could not be changed'));
                }
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Current password is invalid'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> CHANGE_PASSWORD_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function creditMeFlutter($data, $form = array())
    {
        try {
            $db = new Connection(); //instantiates a new object for the Connection class
            $conn = $db->connect(); //instantiates a new object for the db connect() 

            $transaction_ok = true;
            $conn->beginTransaction();

            if (isset($form['usage_channel']) && $form['usage_channel'] != "") {
                $form['username'] = str_replace("'", '', $form['username']);
                $wallet_id = str_replace("'", '', $form['id']);
                $form['email'] = str_replace("'", '', $form['email'][0]);
                $balance = str_replace("'", '', $form['balance'][0]);
            } else {
                $wallet_id = $_SESSION['messaging_userid'];
                $balance = $_SESSION['messaging_balance'];
            }

            $rate = json_decode($this->flutter->apiLayerConverter($data['data']), true);

            if (isset($rate['error'])) {
                return json_encode(array('response_code' => 20, 'response_message' => $rate['error']['message']));
            }

            $deposited = round($rate['result'], 2);

            $data['wallet_balance'] = $deposited + $balance;

            $get_wallet = $this->Select('wallet_table', 'wallet_id', $this->encrypt($wallet_id));
            if ($get_wallet != "") {
                // credit depositor
                $credit = "UPDATE wallet_table SET ";
                $credit .= "wallet_balance = '" . $this->encrypt($balance + $deposited) . "', ";
                $credit .= "wallet_previous_balance='" . $this->encrypt($balance) . "',";
                $credit .= "lastmodified='" . $this->encrypt(date('Y-m-d h:i:s')) . "'";
                $credit .= " WHERE wallet_id='" . $this->encrypt($wallet_id) . "'";

                $stmt = $conn->prepare($credit);
                $stmt->execute();
                if ($stmt->rowCount() <= 0) {
                    $transaction_ok = false;
                }
            } else {
                $credit = "(";
                $credit .= "'" . $this->encrypt($balance + $deposited) . "','";
                $credit .= $this->encrypt($balance) . "','";
                $credit .= $this->encrypt($wallet_id) . "','";
                $credit .= $this->encrypt($_SERVER['REMOTE_ADDR']) . "','";
                $credit .= $this->encrypt(date('Y-m-d h:i:s')) . "'";
                $credit .= ")";

                $stmt = $conn->prepare("INSERT INTO wallet_table(wallet_balance,wallet_previous_balance,wallet_id,posted_ip,created) VALUES " . rtrim($credit, ','));
                $stmt->execute();
                if ($stmt->rowCount() <= 0) {
                    $transaction_ok = false;
                }
            }

            $status = ($data['data']['status'] == 'successful') ? 0 : 20;
            // log sender's transaction
            $log = "(";
            $log .= "'" . $this->encrypt($data['data']['id']) . "','";
            $log .= $this->encrypt($wallet_id) . "','";
            $log .= $this->encrypt($deposited) . "','";
            $log .= $this->encrypt($data['data']['amount']) . "','";
            $log .= $this->encrypt('DEPOSIT') . "','";
            $log .= $this->encrypt('Wallet Deposit') . "','";
            $log .= $this->encrypt($status) . "','";
            $log .= $this->encrypt($data['data']['payment_type']) . "','";
            $log .= $this->encrypt($data['data']['ip']) . "','";
            $log .= $this->encrypt($data['data']['created_at']) . "','";
            $log .= $this->encrypt($data['data']['currency']) . "','";
            $log .= $this->encrypt($data['data']['flw_ref']) . "','";
            $log .= $this->encrypt($data['data']['customer']['email']) . "','";
            $log .= $this->encrypt($data['data']['customer']['phone_number']) . "'";
            $log .= ")";

            $stmt = $conn->prepare("INSERT INTO transaction_table(transaction_id,destination_acct,source_amount,currency_amount,trans_type,transaction_desc,response_code,payment_mode,posted_ip,created,currency_code,flutter_ref,customer_email,customer_phone) VALUES " . rtrim($log, ','));
            $stmt->execute();
            if ($stmt->rowCount() <= 0) {
                $transaction_ok = false;
            }

            if ($transaction_ok == true) {
                $conn->commit();
                $_SESSION['messaging_balance'] = $data['wallet_balance'];

                return json_encode(array('response_code' => 0, 'response_message' => 'Successful', 'ref' => $data['data']['id'], 'amount' => $deposited, 'current_balance' => $data['wallet_balance'], 'previous_balance' => $balance));
            } else {
                $conn->rollBack();
                return json_encode(array('response_code' => 20, 'response_message' => 'Transaction failed'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> CREDITME_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function creditMeFlutterTransfer($data, $webhook = array())
    {
        try {
            $db = new Connection(); //instantiates a new object for the Connection class
            $conn = $db->connect(); //instantiates a new object for the db connect() 

            $transaction_ok = true;
            $conn->beginTransaction();

            $stage = 0;

            $get_user_acct = $this->SelectOne('userdata', 'email', $this->encrypt($webhook['data']['customer']['email']), 'wallet_id');

            $deposited = round($data['data']['amount_settled'], 2);
            $balance = 0;
            $get_wallet = $this->SelectOne('wallet_table', 'wallet_id', $get_user_acct, 'wallet_balance');
            if ($get_wallet != "") {
                $balance = $this->decrypt($get_wallet);
                // credit depositor
                $credit = "UPDATE wallet_table SET ";
                $credit .= "wallet_balance = '" . $this->encrypt($balance + $deposited) . "', ";
                $credit .= "wallet_previous_balance='" . $this->encrypt($balance) . "',";
                $credit .= "lastmodified='" . $this->encrypt(date('Y-m-d h:i:s')) . "'";
                $credit .= " WHERE wallet_id='$get_user_acct'";

                $stmt = $conn->prepare($credit);
                $stmt->execute();
                if ($stmt->rowCount() == 0) {
                    $transaction_ok = false;
                    $stage = 1;
                }
            } else {
                $credit = "(";
                $credit .= "'" . $this->encrypt($balance + $deposited) . "','";
                $credit .= $this->encrypt($balance) . "','";
                $credit .= $get_user_acct . "','";
                $credit .= $this->encrypt($_SERVER['REMOTE_ADDR']) . "','";
                $credit .= $this->encrypt(date('Y-m-d h:i:s')) . "'";
                $credit .= ")";

                $stmt = $conn->prepare("INSERT INTO wallet_table(wallet_balance,wallet_previous_balance,wallet_id,posted_ip,created) VALUES " . rtrim($credit, ','));
                $stmt->execute();
                if ($stmt->rowCount() == 0) {
                    $transaction_ok = false;
                    $stage = 2;
                }
            }

            $status = ($data['data']['status'] == 'successful') ? 0 : 20;
            // log sender's transaction
            $log = "(";
            $log .= "'" . $this->encrypt($data['data']['id']) . "','";
            $log .= $get_user_acct . "','";
            $log .= $this->encrypt($deposited) . "','";
            $log .= $this->encrypt($deposited) . "','";
            $log .= $this->encrypt('DEPOSIT') . "','";
            $log .= $this->encrypt('Wallet Deposit') . "','";
            $log .= $this->encrypt($status) . "','";
            $log .= $this->encrypt($data['data']['payment_type']) . "','";
            $log .= $this->encrypt($data['data']['ip']) . "','";
            $log .= $this->encrypt($data['data']['created_at']) . "','";
            $log .= $this->encrypt($data['data']['currency']) . "','";
            $log .= $this->encrypt($data['data']['flw_ref']) . "','";
            $log .= $this->encrypt($data['data']['customer']['email']) . "','";
            $log .= $this->encrypt($data['data']['customer']['phone_number']) . "'";
            $log .= ")";

            $stmt = $conn->prepare("INSERT INTO transaction_table(transaction_id,destination_acct,source_amount,currency_amount,trans_type,transaction_desc,response_code,payment_mode,posted_ip,created,currency_code,flutter_ref,customer_email,customer_phone) VALUES " . rtrim($log, ','));
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                $transaction_ok = false;
                $stage = 3;
            }

            //log webhook
            $log_hook = "(";
            $log_hook .= "'" . $data['data']['id'] . "','";
            $log_hook .= json_encode($webhook) . "'";
            $log_hook .= ")";

            $stmt = $conn->prepare("INSERT INTO webhook_log(webhook_id,payload) VALUES " . rtrim($log_hook, ','));
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                $transaction_ok = false;
                $stage = 4;
            }

            if ($transaction_ok == true) {
                $conn->commit();

                $data['beneficiary_acct'] = $this->decrypt($get_user_acct);
                $data['reference'] = $data['data']['id'];
                $data['debit_amount'] = $deposited;

                $this->creditAlert($data);

                return json_encode(array('response_code' => 0, 'response_message' => 'Successful'));
            } else {
                $conn->rollBack();
                return json_encode(array('response_code' => 20, 'response_message' => 'Transaction failed ' . $stage));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> CREDITME_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function creditMeStack($data)
    {
        try {
            $form = "";
            if (isset($form['usage_channel']) && $form['usage_channel'] != "") {
                $form['username'] = str_replace("'", '', $form['username']);
                $wallet_id = str_replace("'", '', $form['id']);
                $form['email'] = str_replace("'", '', $form['email'][0]);
                $balance = str_replace("'", '', $form['balance'][0]);
            } else {
                $wallet_id = $_SESSION['messaging_userid'];
                $balance = $_SESSION['messaging_balance'];
            }

            $rate = json_decode($this->flutter->apiLayerConverter($data['data']), true);

            if (isset($rate['error'])) {
                return json_encode(array('response_code' => 20, 'response_message' => $rate['error']['message']));
            }

            $deposited = number_format($rate['result'], 2);
            $wallet['wallet_balance'] = $deposited + $balance;

            $get_wallet = $this->Select('wallet_table', 'wallet_id', $this->encrypt($wallet_id), 'wallet_id');
            if ($get_wallet != "") {

                $wallet['wallet_previous_balance'] = $balance;
                $wallet['lastmodified'] = date('Y-m-d h:i:s');

                $stmt = $this->Update('wallet_table', $wallet, [], ['wallet_id' => $this->encrypt($wallet_id)]);
            } else {
                $wallet['wallet_id'] = $wallet_id;
                $wallet['posted_ip'] = $_SERVER['REMOTE_ADDR'];
                $wallet['created'] = date('Y-m-d h:i:s');
                $stmt = $this->Insert('wallet_table', $wallet, []);
            }

            $trans['transaction_id'] = $data['data']['id'];
            // $trans['source_acct'] = $wallet_id;
            $trans['destination_acct'] = $wallet_id;
            $trans['source_amount'] = $deposited;
            $trans['currency_amount'] = $data['data']['amount'];
            $trans['trans_type'] = 'DEPOSIT';
            $trans['transaction_desc'] = 'Wallet Deposit';
            $trans['response_code'] = ($data['data']['status'] == 'successful') ? 0 : 20;
            $trans['payment_mode'] = $data['data']['payment_type'];
            $trans['posted_ip'] = $data['data']['ip'];
            $trans['created'] = $data['data']['created_at'];
            $trans['currency_code'] = $data['data']['currency'];
            $trans['flutter_ref'] = $data['data']['flw_ref'];
            $trans['customer_email'] = $data['data']['customer']['email'];
            $trans['customer_phone'] = $data['data']['customer']['phone_number'];

            $stmt = $this->Insert('transaction_table', $trans, []);

            if ($stmt > 0) {
                $_SESSION['messaging_balance'] = $wallet['wallet_balance'];
                return json_encode(array('response_code' => 0, 'response_message' => 'Successful', 'amount' => $deposited, 'balance' => $data['wallet_balance']));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Transaction failed'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> CREDITME_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function transactionLists($page_no, $offset, $order = 'DESC', $data = '')
    {
        try {

            $records_per_view = isset($offset) ? $offset : 5;
            $offset = ($page_no > 1) ? ($page_no - 1) * $records_per_view : 0 * $records_per_view;
            $filter = (isset($data['status']) && $data['status'] != 'all') ? " AND trans_type='" . $this->encrypt(strtoupper($data['status'])) . "'" : "";

            if (isset($data['daterange']) && $data['daterange'] != '') {
                $daterange = explode('~', $data['daterange']);
                $start_date = $this->encrypt($daterange[0]);
                $end_date = $this->encrypt($daterange[1]);

                $filter .= (isset($data['daterange']) && $data['daterange'] != '') ? " AND (DATE(created) BETWEEN '$start_date' AND '$end_date')" : "";
            }

            $wallet_id = $this->encrypt($_SESSION['messaging_userid']);

            $stmt = $this->db_connect("SELECT * FROM transaction_table WHERE (source_acct='$wallet_id' OR destination_acct='$wallet_id') $filter ORDER BY id $order LIMIT $offset,$records_per_view");

            $output = '';

            if ((isset($data['status']) && $data['status'] !== '') ||
                (isset($data['daterange']) && $data['daterange'] !== '')
            ) {
                $records = $this->decrypt($stmt);
                if (!empty($records)) { // Use !empty() instead of is_array() and sizeof()
                    foreach ($records as $record) {
                        $created = isset($record['created']) ? str_replace('T', ' ', $record['created']) : '';
                        $dateParts = explode(' ', $created);
                        $date = explode('-', $dateParts[0]);
                        $day = isset($date[2]) ? $date[2] : date('d');
                        $month = !empty($date[1]) && $date[1] !== '00' ? date('M', strtotime($dateParts[0])) : date('M');

                        // Escape HTML entities and use double quotes for attribute values
                        $status = ($record['response_code'] == 0)
                            ? '<span class="text-success" data-bs-toggle="tooltip" title="' . htmlspecialchars($record['response_message'], ENT_QUOTES, 'UTF-8') . '"><i class="fas fa-check-circle"></i></span>'
                            : '<span class="text-danger" data-bs-toggle="tooltip" title="' . htmlspecialchars($record['response_message'], ENT_QUOTES, 'UTF-8') . '"><i class="fas fa-times"></i></span>';

                        // Use sprintf() to format the output string
                        $amount = (strtolower($record['trans_type']) !== 'debit')
                            ? sprintf('<span class="text-nowrap text-success">&#8358;%s</span> <span class="text-2 text-uppercase text-success">(NGN)</span>', $record['source_amount'] ?: '0.00')
                            : sprintf('<span class="text-nowrap text-danger">&#8358;%s</span> <span class="text-2 text-uppercase text-danger">(NGN)</span>', $record['source_amount'] ?: '0.00');

                        // Escape HTML entities and use double quotes for attribute values
                        $output .= sprintf(
                            '<a onclick="loadModal(\'transaction_details?id=%s&amp;width=modal-sm&amp;title=Transaction Details\',\'modal_div\')" href="#" data-bs-toggle="modal" data-target="#defaultModalPrimary">
                                    <div class="transaction-item px-4 py-3">
                                    <div class="row align-items-center flex-row">
                                        <div class="col-2 col-sm-1 text-center"> <span class="d-block text-4 fw-300">%s</span> <span class="d-block text-1 fw-300 text-uppercase">%s</span> </div>
                                        <div class="col col-sm-5"> <span class="d-block text-4">%s</span> <span class="text-muted">%s</span> </div>
                                        <div class="col col-sm-2"> <span class="d-block text-4">%s</span> </div>
                                        <div class="col-auto col-sm-2 d-none d-sm-block text-center text-3"> %s </div>
                                        <div class="col-3 col-sm-2 text-end text-4"> %s </div>
                                    </div>
                                    </div>
                                </a>',
                            htmlspecialchars($record['transaction_id'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($day, ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($month, ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($record['transaction_desc'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($record['trans_type'], ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($record['transaction_id'], ENT_QUOTES, 'UTF-8'),
                            $status,
                            $amount
                        );
                    }
                } else {
                    // Use sprintf() to format the output string
                    $output = sprintf('<h5 class="text-center text-danger">No record found %s transactions.</h5>', htmlspecialchars($data['status'] ?? '', ENT_QUOTES, 'UTF-8'));
                }
            } else {
                $output = $this->decrypt($stmt);
            }

            return $output;
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> TRANSACTION_LIST_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function getMyTransactions($data)
    {
        try {

            $start_limit = 0;
            $count_limit = 20;
            $order = isset($data['order']) ? $data['order'][0] : 'DESC';
            $start_limit = isset($data['page']) ? $data['page'][0] : $start_limit;
            $count_limit = isset($data['limit']) ? $data['limit'][0] : $count_limit;

            if ($count_limit > 100) {
                return array('response_code' => '20', 'response_message' => "Per page record count can only be maximum of 100");
            }

            if ($start_limit == 0 || $start_limit == 1) {
                $start_limit = 0;
            } else {
                $start_limit--;
                $start_limit = $start_limit * $count_limit;
            }
            $limit = ($start_limit >= 0 && $count_limit > 0) ? " LIMIT $start_limit, $count_limit " : " LIMIT 0, $count_limit ";

            $wallet_id = isset($data['id']) ? $this->encrypt($data['id'][0]) : '';

            $stmt = $this->db_connect("SELECT * FROM transaction_table WHERE (source_acct='$wallet_id' OR destination_acct='$wallet_id') ORDER BY id $order $limit");

            $list = array();
            if (is_array($stmt) && sizeof($stmt) <= 0) {
                return json_encode(array('response_code' => 20, 'response_message' => 'No record was found'));
            }

            foreach ($this->decrypt($stmt) as $key => $value) {
                switch ($value['response_code']) {
                    case '0':
                        $message = 'Successful';
                        break;
                    case '20':
                        $message = 'Failed';
                        break;
                    case '30':
                        $message = 'Pending';
                        break;
                    default:
                        $message = 'Failed';
                        break;
                }

                $list[] = array(
                    'id' => $value['transaction_id'],
                    'amount' => $value['source_amount'],
                    'fee' => $value['chargefee'],
                    'description' => $value['transaction_desc'],
                    'created' => $value['created'],
                    'status' => $value['response_code'],
                    'status_message' => $message,
                    'source' => $value['source_acct'],
                    'beneficiary' => $value['destination_acct']
                );
            }

            return json_encode(array('response_code' => 0, 'response_message' => 'Transaction fetched successfully', 'data' => $list, 'info' => array('total_records' => count($stmt), 'filter_limit' => $count_limit, 'current_page' => $start_limit + 1)));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> GET_MY_TRANSACTION_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function getSupportedCurrencies()
    {
        try {
            $stmt = $this->db_connect("SELECT * FROM currency WHERE `status` IN (1) ORDER BY currency_id");

            $list = array();
            if (is_array($stmt) && sizeof($stmt) <= 0) {
                return json_encode(array('response_code' => 20, 'response_message' => 'No record was found'));
            }

            foreach ($stmt as $value) {
                switch ($value['default']) {
                    case '1':
                        $message = 'Local currency';
                        break;
                    case '0':
                        $message = 'Foreign currency';
                        break;
                    default:
                        $message = 'Local currency';
                        break;
                }

                $list[] = array(
                    'id' => $value['currency_id'],
                    'currency_name' => $value['currency_name'],
                    'currency_code' => $value['currency_code'],
                    'short_code' => $value['currency_short_code'],
                    'default' => $value['default'],
                    'card_fee' => $value['save_card_fee'],
                    'status_message' => $message,
                    'status' => $value['status']
                );
            }

            return json_encode(array('response_code' => 0, 'response_message' => 'Currency fetched successfully', 'data' => $list));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> SUPPORTED_CURRENCIES_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function notificationAlert()
    {
        try {
            $stmt = $this->db_connect("SELECT * FROM subscriptions ORDER BY subscription_id");

            $list = array();
            if (is_array($stmt) && sizeof($stmt) <= 0) {
                return json_encode(array('response_code' => 20, 'response_message' => 'No record was found'));
            }

            foreach ($stmt as $value) {

                $list[] = array(
                    'id' => $value['subscription_id'],
                    'name' => $value['subscription_name'],
                    'description' => $value['description']
                );
            }

            return json_encode(array('response_code' => 0, 'response_message' => 'Notification alert fetched successfully', 'data' => $list));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> NOTIFICATION_ALERT_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function getsecurityQuestions()
    {
        try {
            $stmt = $this->db_connect("SELECT * FROM questions ORDER BY question_id");

            $list = array();
            if (is_array($stmt) && sizeof($stmt) <= 0) {
                return json_encode(array('response_code' => 20, 'response_message' => 'No record was found'));
            }

            foreach ($stmt as $value) {

                $list[] = array(
                    'id' => $value['question_id'],
                    'question' => $value['question']
                );
            }

            return json_encode(array('response_code' => 0, 'response_message' => 'Security questions fetched successfully', 'data' => $list));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> SECURITY_QUESTIONS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function getCountries()
    {
        try {

            $stmt = $this->db_connect("SELECT id,name,iso2 FROM countries  ORDER BY id");

            // $stmt = $this->db_connect("SELECT * FROM country WHERE un_code IN (36) ORDER BY un_code");

            $list = array();
            if (is_array($stmt) && sizeof($stmt) <= 0) {
                return json_encode(array('response_code' => 20, 'response_message' => 'No record was found'));
            }

            foreach ($stmt as $value) {

                $list[] = array(
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'code' => $value['iso2']
                );

                // $list[] = array(
                //     'id' => $value['un_code'],
                //     'name' => $value['country_name'],
                //     'code' => $value['alpha_code_2']
                // );
            }
            // var_dump($list);exit;
            return json_encode(array('response_code' => 0, 'response_message' => 'Countries fetched successfully', 'data' => $list));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> SECURITY_QUESTIONS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function getState()
    {
        try {

            $stmt = $this->db_connect("SELECT id,name,country_id FROM states WHERE country_id IN (161) ORDER BY id");

            // $stmt = $this->db_connect("SELECT * FROM country WHERE un_code IN (36) ORDER BY un_code");

            $list = array();
            if (is_array($stmt) && sizeof($stmt) <= 0) {
                return json_encode(array('response_code' => 20, 'response_message' => 'No record was found'));
            }

            foreach ($stmt as $value) {

                $list[] = array(
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'code' => $value['country_id']
                );

                // $list[] = array(
                //     'id' => $value['un_code'],
                //     'name' => $value['country_name'],
                //     'code' => $value['alpha_code_2']
                // );
            }
            // var_dump($list);exit;
            return json_encode(array('response_code' => 0, 'response_message' => 'Countries fetched successfully', 'data' => $list));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> SECURITY_QUESTIONS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function getAllCountries()
    {
        try {

            $stmt = $this->db_connect("SELECT * FROM country WHERE un_code IN (36) ORDER BY un_code");

            $list = array();
            if (is_array($stmt) && sizeof($stmt) <= 0) {
                return json_encode(array('response_code' => 20, 'response_message' => 'No record was found'));
            }

            foreach ($stmt as $value) {

                $list[] = array(
                    'id' => $value['un_code'],
                    'name' => $value['country_name'],
                    'code' => $value['alpha_code_2']
                );
            }

            return $list;
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> SECURITY_QUESTIONS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function getTimezones()
    {
        try {

            $stmt = $this->db_connect("SELECT * FROM timezone ORDER BY id");

            $list = array();
            if (is_array($stmt) && sizeof($stmt) <= 0) {
                return json_encode(array('response_code' => 20, 'response_message' => 'No record was found'));
            }

            foreach ($stmt as $value) {

                $list[] = array(
                    'id' => $value['id'],
                    'timezone' => $value['timezone_region'],
                    'time_difference' => $value['value']
                );
            }

            return json_encode(array('response_code' => 0, 'response_message' => 'Timezones fetched successfully', 'data' => $list));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> TIMEZONE_LIST_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function getLanguages()
    {
        try {

            $stmt = $this->db_connect("SELECT * FROM languages ORDER BY id");

            $list = array();
            if (is_array($stmt) && sizeof($stmt) <= 0) {
                return json_encode(array('response_code' => 20, 'response_message' => 'No record was found'));
            }

            foreach ($stmt as $value) {

                $list[] = array(
                    'id' => $value['id'],
                    'language' => $value['language']
                );
            }

            return json_encode(array('response_code' => 0, 'response_message' => 'Languages fetched successfully', 'data' => $list));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> LANGUAGES_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function getPhoneCodes()
    {
        try {

            $stmt = $this->db_connect("SELECT * FROM mobile_codes ORDER BY id");

            $list = array();
            if (is_array($stmt) && sizeof($stmt) <= 0) {
                return json_encode(array('response_code' => 20, 'response_message' => 'No record was found'));
            }

            foreach ($stmt as $value) {

                $list[] = array(
                    'id' => $value['id'],
                    'code' => $value['code'],
                    'value' => $value['value']
                );
            }

            return json_encode(array('response_code' => 0, 'response_message' => 'Mobile codes fetched successfully', 'data' => $list));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> MOBILE_CODES_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function getTelcomBillers()
    {
        try {
            $providers = array('BIL108' => 'MTN NIGERIA', 'BIL109' => 'GLO NIGERIA', 'BIL110' => 'AIRTEL NIGERIA', 'BIL111' => '9MOBILE NIGERIA');
            $airtime = array('BIL099' => 'MTN VTU', 'BIL102' => 'GLO VTU', 'BIL100' => 'AIRTEL VTU', 'BIL103' => '9MOBILE VTU');

            $data = $vtu = array();

            foreach ($providers as $key => $value) {

                $data[] = array(
                    'biller_code' => $key,
                    'biller_name' => $value
                );
            }

            foreach ($airtime as $key => $value) {

                $vtu[] = array(
                    'biller_code' => $key,
                    'biller_name' => $value
                );
            }

            return json_encode(array('response_code' => 0, 'response_message' => 'Telcom Billers fetched successfully', 'data' => array($data, $vtu)));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> TELCOM_BILLERS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function getUtilityBillers()
    {
        try {
            $cables = array('BIL121' => 'DSTV', 'BIL122' => 'GOtv', 'BIL123' => 'Nova');
            $wifis = array('BIL125' => 'TOP UP ACCOUNT', 'BIL126' => 'SWIFT', 'BIL129' => 'ipNX', 'BIL124' => 'SMILE', 'BIL136' => 'MTN Hynet');
            $tolls = array('BIL127' => 'LCC');

            $cable = $wifi = $toll = array();

            foreach ($cables as $key => $value) {

                $cable[] = array(
                    'biller_code' => $key,
                    'biller_name' => $value
                );
            }

            foreach ($wifis as $key => $value) {

                $wifi[] = array(
                    'biller_code' => $key,
                    'biller_name' => $value
                );
            }
            foreach ($tolls as $key => $value) {

                $toll[] = array(
                    'biller_code' => $key,
                    'biller_name' => $value
                );
            }

            return json_encode(array('response_code' => 0, 'response_message' => 'Telcom Billers fetched successfully', 'data' => array($cable, $wifi, $toll)));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> TELCOM_BILLERS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function transactionCounts()
    {
        try {
            $wallet_id = $this->encrypt($_SESSION['messaging_userid']);

            $stmt = $this->db_connect("SELECT * FROM transaction_table WHERE (source_acct='$wallet_id' OR destination_acct='$wallet_id') ORDER BY id");

            return count($stmt);
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> TRANSACTION_COUNTS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function fetchTransaction($id)
    {
        try {
            $wallet_id = $this->encrypt($_SESSION['messaging_userid']);
            $transation_id = $this->encrypt($id);
            $stmt = json_decode($this->runQuery("SELECT * FROM transaction_table WHERE (source_acct='$wallet_id' OR destination_acct='$wallet_id') AND transaction_id='$transation_id' LIMIT 1"), true);

            $data = $this->decrypt($stmt);
            return $data;
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> FETCH_TRANSACTION_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function getBankDetail($data)
    {
        try {
            $wallet_id = $this->encrypt($_SESSION['messaging_userid']);
            $id = $this->encrypt($data['id']);
            $stmt = json_decode($this->runQuery("SELECT * FROM bank_details WHERE source_wallet='$wallet_id' AND account_number='$id' LIMIT 1"), true);

            $data = $this->decrypt($stmt);
            return $data;
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> FETCH_TRANSACTION_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function getPaymentDetails($data = array())
    {
        try {
            if (isset($data['usage_channel']) && $data['usage_channel'] != "") {
                $wallet_id = $this->encrypt(str_replace("'", '', $data['id'][0]));
            } else {
                $wallet_id = $this->encrypt($_SESSION['messaging_userid']);
            }

            $banks = $this->db_connect("SELECT * FROM bank_details WHERE source_wallet='$wallet_id' AND is_deleted='" . $this->encrypt(0) . "' ORDER BY id");

            $cards = $this->db_connect("SELECT * FROM card_details WHERE source_wallet='$wallet_id' AND is_deleted='" . $this->encrypt(0) . "' ORDER BY id");

            return json_encode(
                array(
                    'bank' => $this->decrypt($banks),
                    'card' => $this->decrypt($cards)
                )
            );
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> PAYMENT_DETAILS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function get_Cards($data)
    {
        try {

            $stmt = json_decode($this->getPaymentDetails($data), true);
            $list = array();

            if (is_array($stmt['card']) && sizeof($stmt['card']) > 0) {
                foreach ($stmt['card'] as $key => $value) {
                    switch ($value['priority']) {
                        case '0':
                            $message = 'Secondary Card';
                            break;
                        case '1':
                            $message = 'Primary Card';
                            break;
                        default:
                            $message = 'Unknown Card';
                            break;
                    }

                    $list[] = array(
                        'card_holder' => $value['card_holder'],
                        'card_number' => $value['card_number'],
                        'valid_thru' => $value['valid_thru'],
                        'card_cvv' => $value['card_cvv'],
                        'issuing_country' => $value['issuing_country'],
                        'card_type' => $value['card_type'],
                        'issuing_info' => $value['issuing_info'],
                        'priority' => $value['priority'],
                        'priority_message' => $message,
                        'created' => $value['created']
                    );
                }
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'No record was found'));
            }

            return json_encode(array('response_code' => 0, 'response_message' => 'Cards fetched successfully', 'data' => $list, 'info' => array('total_records' => count($stmt['card']))));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> PAYMENT_DETAILS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function get_Accounts($data)
    {
        try {
            $stmt = json_decode($this->getPaymentDetails($data), true);
            $list = array();

            if (is_array($stmt['bank']) && sizeof($stmt['bank']) > 0) {
                foreach ($stmt['bank'] as $key => $value) {
                    switch ($value['priority']) {
                        case '0':
                            $message = 'Secondary Bank';
                            break;
                        case '1':
                            $message = 'Primary Bank';
                            break;
                        default:
                            $message = 'Unknown Bank';
                            break;
                    }

                    $list[] = array(
                        'account_name' => $value['account_name'],
                        'account_number' => $value['account_number'],
                        'bank_name' => $value['bank_name'],
                        'bank_code' => $value['bank_code'],
                        'priority' => $value['priority'],
                        'priority_message' => $message,
                        'created' => $value['created']
                    );
                }
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'No record was found'));
            }

            return json_encode(array('response_code' => 0, 'response_message' => 'Banks fetched successfully', 'data' => $list, 'info' => array('total_records' => count($stmt['bank']))));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> PAYMENT_DETAILS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function getCardDetail($data)
    {
        try {
            $wallet_id = $this->encrypt($_SESSION['messaging_userid']);
            $id = $data['id'];
            $stmt = json_decode($this->runQuery("SELECT * FROM card_details WHERE source_wallet='$wallet_id' AND id='$id' LIMIT 1"), true);

            $data = $this->decrypt($stmt);
            return $data;
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> FETCH_TRANSACTION_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function getWalletAccountName($data)
    {
        try {
            $wallet = $this->Select('userdata', 'wallet_id', $this->encrypt($data['wallet_id']));
            if (is_array($wallet) && sizeof($wallet) > 0) {
                $row[] = $this->decrypt($wallet);
                $wallet_name = $row[0]['firstname'] . ' ' . $row[0]['middlename'] . ' ' . $row[0]['lastname'];

                return json_encode(array('response_code' => 0, 'response_message' => $wallet_name));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Invalid Wallet ID'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> RESOLVE_WALLET_ID_CONTROLLER => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function manageTransactionPIN($data)
    {
        try {
            if (isset($data['usage_channel']) && $data['usage_channel'] != "") {
                $wallet_id = $this->encrypt(str_replace("'", '', $data['id']));
            } else {
                $wallet_id = $this->encrypt($_SESSION['messaging_userid']);
            }

            if (isset($data['pin-setup']) && $data['pin-setup'] == 1) {
                $pin['transaction_pin'] = $data['pin-1'];

                $get_pin = $this->SelectOne('userdata', 'wallet_id', $wallet_id, 'transaction_pin');
                if ($get_pin != "" && ($this->decrypt($get_pin) == $pin['transaction_pin'])) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Please, choose a PIN that is different from your current PIN'));
                }

                $stmt = $this->Update('userdata', $pin, [], ['wallet_id' => $wallet_id]);

                if ($stmt > 0) {
                    return json_encode(array('response_code' => 0, 'response_message' => 'Your transaction PIN has been successfully configured.'));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Your transaction PIN could not configured.'));
                }
            } else {
                if (isset($data['usage_channel']) && $data['usage_channel'] != "") {
                    $pin = $data['pin'];
                } else {
                    $pin = $data['digit-1'] . $data['digit-2'] . $data['digit-3'] . $data['digit-4'] . $data['digit-5'] . $data['digit-6'];
                }

                $get_pin = $this->decrypt($this->SelectOne('userdata', 'wallet_id', $wallet_id, 'transaction_pin'));

                if ($get_pin != $pin) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Incorrect transaction PIN'));
                } else {
                    return json_encode(array('response_code' => 0, 'response_message' => 'Authorized'));
                }
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> TRANSACTION_PIN_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function walletBeneficiaries($data)
    {
        try {
            $wallet['source_wallet'] = $_SESSION['messaging_userid'];
            $wallet['destination_wallet'] = $data['wallet_id'];
            $wallet['destination_wallet_name'] = $data['name'];
            $wallet['is_deleted'] = 0;
            $wallet['created'] = date('Y-m-d h:i:s');

            $get_wallet = $this->SelectOne('wallet_beneficiaries', 'destination_wallet', $this->encrypt($data['wallet_id']), 'destination_wallet_name');
            if ($get_wallet != "") {
                return json_encode(array('response_code' => 0, 'response_message' => 'Saved as beneficiary'));
            }

            $stmt = $this->Insert('wallet_beneficiaries', $wallet, []);
            if ($stmt > 0) {
                return json_encode(array('response_code' => 0, 'response_message' => 'Saved as beneficiary'));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Counld not be saved as beneficiary'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> WALLET_BENEFICIARY_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function getWalletBeneficiaries()
    {
        $this->db = new Connection(); //instantiates a new object for the Connection class
        $this->conn = $this->db->connect(); //instantiates a new object for the db connect() 

        $source = $this->encrypt($_SESSION['messaging_userid']);

        $stmt = $this->conn->prepare("SELECT * FROM wallet_beneficiaries WHERE source_wallet='$source' AND is_deleted ='" . $this->encrypt(0) . "'");
        $stmt->execute();
        return $this->decrypt($stmt->fetchAll());
    }
    public function getBankBeneficiaries()
    {
        $this->db = new Connection(); //instantiates a new object for the Connection class
        $this->conn = $this->db->connect(); //instantiates a new object for the db connect() 

        $source = $this->encrypt($_SESSION['messaging_userid']);

        $stmt = $this->conn->prepare("SELECT * FROM transfer_recepients WHERE source_wallet='$source' AND is_deleted ='" . $this->encrypt(0) . "' AND save_as_beneficiary='" . $this->encrypt(1) . "'");
        $stmt->execute();
        return $this->decrypt($stmt->fetchAll());
    }

    public function deleteBeneficiaries($data)
    {
        try {
            if ($data['source'] == 'wallet') {
                $delete['is_deleted'] = 1;
                $stmt = $this->Update('wallet_beneficiaries', $delete, [], ['destination_wallet' => $this->encrypt($data['id'])]);
                if ($stmt > 0) {
                    return json_encode(array('response_code' => 0, 'response_message' => 'Beneficiary has been successfully deleted'));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Beneficiary could not be deleted'));
                }
            } else if ($data['source'] == 'bank') {
                $delete['is_deleted'] = 1;
                $stmt = $this->Update('transfer_recepients', $delete, [], ['account_number' => $this->encrypt($data['id'])]);
                if ($stmt > 0) {
                    return json_encode(array('response_code' => 0, 'response_message' => 'Beneficiary has been successfully deleted'));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Beneficiary could not be deleted'));
                }
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> DELETE_BENEFICIARY_CONTROLLER => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function validateBalance($data)
    {
        try {
            $data['section'] = $data['type'];
            $amount = $data['transfer-amount'];
            if ($amount == "" or $amount < 1) {
                return json_encode(array('response_code' => 20, 'response_message' => 'Invalid transaction amount'));
            }

            // var_dump($data['category']);exit;
            $allowed = array('data', 'airtime');
            if (isset($data['category']) && in_array($data['category'], $allowed)) {
                // don't restrict amount for airtime purchase
            } else {
                if ($amount < 100) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Amount is below minimum limit of 100'));
                }
            }

            // get wallet balance
            if (isset($data['wallet_id']) && $data['wallet_id'] != "") {
                $wallet_id = $data['wallet_id'];
            } else {
                $wallet_id = $_SESSION['messaging_userid'];
            }

            $get_wallet = $this->SelectOne('wallet_table', 'wallet_id', $this->encrypt($wallet_id), 'wallet_balance');
            if ($get_wallet == "") {
                return json_encode(array('response_code' => 20, 'response_message' => 'Could not fetch wallet balance'));
            }

            $balance = $this->decrypt($get_wallet);
            if ($balance == 0) {
                return json_encode(array('response_code' => 20, 'response_message' => 'Insufficient balance'));
            }

            if ($data['section'] == 'bank') { //charges applies for only wallet - bank transactions and bills payment [$data['charges']]
                // get my commission
                $my_commission = ($this->local_charges / 100) * $amount;
                if ($balance <= $my_commission) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Insufficient balance'));
                }
                $current_bal = $balance - $my_commission;

                // get app_fee commission
                $app_fee = (isset($data['charges']) && $data['charges'] != '') ? $data['charges'] : ($this->flutter_percentage / 100) * $amount;
                if ($current_bal <= $app_fee) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Insufficient balance'));
                }
                $current_bal = $current_bal - $app_fee;
            } else {
                $current_bal = $balance;
                $my_commission = $app_fee = 0;
            }

            // deduct the transfer amount
            if ($current_bal < $amount) {
                return json_encode(array('response_code' => 20, 'response_message' => 'Insufficient balance'));
            }

            $current_bal = $current_bal - $amount;

            if ($data['section'] == 'bank') {

                // check transaction limit
                $stmt = json_decode($this->daily_limit($data), true);
                if ($stmt['response_code'] == 20) {
                    return json_encode(array('response_code' => $stmt['response_code'], 'response_message' => $stmt['response_message']));
                }

                $currency['currency'] = 'NGN';
                $wallet = json_decode($this->flutter->getBalanceByCurrency($currency), true);
                if (isset($wallet['status']) && $wallet['status'] == 'error') {
                    return json_encode(array('response_code' => 20, 'response_message' => 'We could not process your request at the moment. Please, try again later.'));
                }

                // if($wallet['data']['ledger_balance'] <= $amount OR $wallet['data']['available_balance'] <= $amount){
                if ($wallet['data']['available_balance'] <= $amount) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'We could not process your request at the moment. Please, try again later.'));
                }
            }

            $_SESSION['debit_amount'] = $my_commission + $app_fee + $amount;
            $_SESSION['messaging_balance'] = $current_bal;

            return json_encode(array('response_code' => 0, 'response_message' => 'Continue', 'debit_amount' => $my_commission + $app_fee + $amount, 'wallet_balance' => $current_bal));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> VALIDATE_BALANCE_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function daily_limit($data)
    {
        try {
            $amount = $data['transfer-amount'];

            $today = $this->encrypt(date('Y-m-d'));
            $response_code = $this->encrypt(0);

            $this->db = new Connection(); //instantiates a new object for the Connection class
            $this->conn = $this->db->connect(); //instantiates a new object for the db connect() 

            $source = $this->encrypt($_SESSION['messaging_userid']);

            $my_daily_limit = $this->Select('daily_limit', 'limit_id', $_SESSION['messaging_daily_limit'], 'amount')[0];

            if ($amount > $my_daily_limit) {
                return json_encode(array('response_code' => 20, 'response_message' => 'Your transaction amount is greater than your daily transaction limit of NGN' . $my_daily_limit));
            }

            $stmt = $this->conn->prepare("SELECT source_amount FROM transaction_table WHERE source_acct='$source' AND response_code ='$response_code' AND DATE(created)='$today'");
            $stmt->execute();
            $row = $this->decrypt($stmt->fetchAll());

            $transacted_amount = 0;
            foreach ($row as $val) {
                $transacted_amount += $val['source_amount'];
            }

            if ($transacted_amount > $my_daily_limit) {
                return json_encode(array('response_code' => 20, 'response_message' => 'You have exceeded your daily transaction limit of NGN' . $my_daily_limit));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> DAILY_LIMIT_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function transferRecepients($data, $form)
    {
        // wallet to bank
        try {

            $db = new Connection(); //instantiates a new object for the Connection class
            $conn = $db->connect(); //instantiates a new object for the db connect() 

            $transaction_ok = true;
            $conn->beginTransaction();

            $data = $data['data'];

            if (isset($form['usage_channel']) && $form['usage_channel'] != "") {
                $wallet_id = $form['id'][0];
            } else {
                $wallet_id = $_SESSION['messaging_userid'];
            }

            $get_wallet = $this->SelectOne('transfer_recepients', 'account_number', $this->encrypt($wallet_id), 'account_name');
            if ($get_wallet == "") {

                $transfer = "(";
                $transfer .= "'" . $this->encrypt($wallet_id) . "','";
                $transfer .= $this->encrypt($data['account_number']) . "','";
                $transfer .= $this->encrypt($data['full_name']) . "','";
                $transfer .= $this->encrypt($data['id']) . "','";
                $transfer .= $this->encrypt(0) . "','";
                $transfer .= $this->encrypt($data['created_at']) . "','";
                $transfer .= $this->encrypt($data['currency']) . "','";
                $transfer .= $this->encrypt($form['save_as_beneficiary']) . "'";
                $transfer .= ")";

                $stmt = $conn->prepare("INSERT INTO transfer_recepients(source_wallet,account_number,account_name,id,is_deleted,createdAt,currency,save_as_beneficiary) VALUES " . rtrim($transfer, ','));
                $stmt->execute();
                if ($stmt->rowCount() <= 0) {
                    $transaction_ok = false;
                }
            }

            $get_wallet = $this->SelectOne('wallet_table', 'wallet_id', $this->encrypt($wallet_id), 'wallet_balance');
            $balance = $this->decrypt($get_wallet);

            // debit sender
            $bal = "UPDATE wallet_table SET ";
            $bal .= "wallet_balance = '" . $this->encrypt($balance - $form['debit_amount']) . "', ";
            $bal .= "wallet_previous_balance='" . $this->encrypt($balance) . "'";
            $bal .= " WHERE wallet_id='" . $this->encrypt($wallet_id) . "'";

            $stmt = $conn->prepare($bal);
            $stmt->execute();
            if ($stmt->rowCount() <= 0) {
                $transaction_ok = false;
            }
            $data['wallet_balance'] = $balance - $form['debit_amount'];

            // log sender's transaction
            $debit = "(";
            $debit .= "'" . $this->encrypt($wallet_id) . "','";
            $debit .= $this->encrypt($form['account_number']) . "','";
            $debit .= $this->encrypt('DEBIT') . "','";
            $debit .= $this->encrypt($form['debit_amount']) . "','";
            $debit .= $this->encrypt('DEB/' . $data['full_name']) . "','";
            $debit .= $this->encrypt($data['reference']) . "','";
            $debit .= $this->encrypt($data['created_at']) . "','";
            $debit .= $this->encrypt($_SERVER['REMOTE_ADDR']) . "','";
            $debit .= $this->encrypt($data['full_name']) . "','";
            $debit .= $this->encrypt($data['account_number']) . "','";
            $debit .= $this->encrypt($data['bank_name']) . "','";
            $debit .= $this->encrypt('wallet-bank') . "','";
            $debit .= $this->encrypt(0) . "'";
            $debit .= ")";

            $stmt = $conn->prepare("INSERT INTO transaction_table(source_acct,destination_acct,trans_type,source_amount,transaction_desc,transaction_id,created,posted_ip,account_name,account_number,bank_name,payment_mode,response_code) VALUES " . rtrim($debit, ','));
            $stmt->execute();
            if ($stmt->rowCount() <= 0) {
                $transaction_ok = false;
            }

            if ($transaction_ok == true) {
                $conn->commit();
                $_SESSION['messaging_balance'] = $form['wallet_balance'];
                unset($_SESSION['debit_amount']);
                $this->debitAlert($form);

                return json_encode(array('response_code' => 0, 'response_message' => 'Transfer successful', 'reference' => $data['reference']));
            } else {
                $conn->rollBack();
                return json_encode(array('response_code' => 20, 'response_message' => 'Transaction could not be completed...'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> WALLET_BANK_TRANSFER_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function wallettowallet($data)
    {
        try {

            $db = new Connection(); //instantiates a new object for the Connection class
            $conn = $db->connect(); //instantiates a new object for the db connect() 

            $transaction_ok = true;
            $conn->beginTransaction();

            if (isset($data['usage_channel']) && $data['usage_channel'] != "") {
                $wallet_id = $data['id'][0];
                $amount = $data['amount'][0];
            } else {
                $wallet_id = $_SESSION['messaging_userid'];
                $amount = $data['amount'];
            }

            $beneficiary = $data['account_id'];

            $get_wallet = $this->SelectOne('wallet_table', 'wallet_id', $this->encrypt($wallet_id), 'wallet_balance');
            $balance = $this->decrypt($get_wallet);

            $ref = date('Ymdhis');
            $created = date('Y-m-d h:i:s');
            // get beneficiary's balance
            $get_benef_acct = $this->Select('userdata', 'wallet_id', $this->encrypt($beneficiary));
            if ($get_benef_acct == "") {
                return json_encode(array('response_code' => 20, 'response_message' => 'Invalid account number'));
            }

            // debit sender
            $bal = "UPDATE wallet_table SET ";
            $bal .= "wallet_balance = '" . $this->encrypt($balance - $data['debit_amount']) . "', ";
            $bal .= "wallet_previous_balance='" . $this->encrypt($balance) . "'";
            $bal .= " WHERE wallet_id='" . $this->encrypt($wallet_id) . "'";

            $stmt = $conn->prepare($bal);
            $stmt->execute();
            if ($stmt->rowCount() <= 0) {
                $transaction_ok = false;
            }
            $data['wallet_balance'] = $balance - $data['debit_amount'];

            // credit receiver
            //check if the receiver's record is in wallet table
            $benef_balanace = $this->Select('wallet_table', 'wallet_id', $this->encrypt($beneficiary));
            if (!isset($benef_balanace['wallet_balance'])) {
                $benef = "(";
                $benef .= "'" . $this->encrypt($data['debit_amount']) . "','";
                $benef .= $this->encrypt(0) . "','";
                $benef .= $this->encrypt($beneficiary) . "','";
                $benef .= $this->encrypt($_SERVER['REMOTE_ADDR']) . "','";
                $benef .= $this->encrypt(date('Y-m-d h:i:s')) . "'";
                $benef .= ")";

                $stmt = $conn->prepare("INSERT INTO wallet_table(wallet_balance,wallet_previous_balance,wallet_id,posted_ip,created) VALUES " . rtrim($benef, ','));
                $stmt->execute();
                if ($stmt->rowCount() <= 0) {
                    $transaction_ok = false;
                }
            } else {
                $ben_balance = $this->decrypt($benef_balanace['wallet_balance']);

                $benef = "UPDATE wallet_table SET ";
                $benef .= "wallet_balance = '" . $this->encrypt($ben_balance + $data['debit_amount']) . "', ";
                $benef .= "wallet_previous_balance='" . $this->encrypt($ben_balance) . "'";
                $benef .= " WHERE wallet_id='" . $this->encrypt($beneficiary) . "'";

                $stmt = $conn->prepare($benef);
                $stmt->execute();
                if ($stmt->rowCount() <= 0) {
                    $transaction_ok = false;
                }
            }


            $narration = (isset($data['narration']) && $data['narration'] != "") ? $data['narration'] : 'DEBIT/' . $_SESSION['messaging_firstname'] . ' ' . $_SESSION['messaging_lastname'];

            // log sender's transaction
            $debit = "(";
            $debit .= "'" . $this->encrypt($wallet_id) . "','";
            $debit .= $this->encrypt('DEBIT') . "','";
            $debit .= $this->encrypt($data['debit_amount']) . "','";
            $debit .= $this->encrypt($narration) . "','";
            $debit .= $this->encrypt($ref) . "','";
            $debit .= $this->encrypt($created) . "','";
            $debit .= $this->encrypt($_SERVER['REMOTE_ADDR']) . "','";
            $debit .= $this->encrypt($data['account_name']) . "','";
            $debit .= $this->encrypt($beneficiary) . "','";
            $debit .= $this->encrypt($data['bank_name']) . "','";
            $debit .= $this->encrypt('wallet-wallet') . "','";
            $debit .= $this->encrypt(0) . "','";
            $debit .= $this->encrypt(1) . "','";
            $debit .= $this->encrypt(0) . "'";
            $debit .= ")";

            $stmt = $conn->prepare("INSERT INTO transaction_table(source_acct,trans_type,source_amount,transaction_desc,transaction_id,created,posted_ip,account_name,account_number,bank_name,payment_mode,response_code,debit_flag,reversal_flag) VALUES " . rtrim($debit, ','));
            $stmt->execute();
            if ($stmt->rowCount() <= 0) {
                $transaction_ok = false;
            }

            // log receiver's transaction
            $credit = "(";
            $credit .= "'" . $this->encrypt('') . "','";
            $credit .= $this->encrypt($beneficiary) . "','";
            $credit .= $this->encrypt('CREDIT') . "','";
            $credit .= $this->encrypt($amount) . "','";
            $credit .= $this->encrypt($narration) . "','";
            $credit .= $this->encrypt('C' . $ref) . "','";
            $credit .= $this->encrypt($created) . "','";
            $credit .= $this->encrypt($_SERVER['REMOTE_ADDR']) . "','";
            $credit .= $this->encrypt('wallet-wallet') . "','";
            $credit .= $this->encrypt(0) . "','";
            $credit .= $this->encrypt(0) . "','";
            $credit .= $this->encrypt(0) . "'";
            $credit .= ")";

            $stmt = $conn->prepare("INSERT INTO transaction_table(source_acct,destination_acct,trans_type,source_amount,transaction_desc,transaction_id,created,posted_ip,payment_mode,response_code,debit_flag,reversal_flag) VALUES " . rtrim($credit, ','));
            $stmt->execute();
            if ($stmt->rowCount() <= 0) {
                $transaction_ok = false;
            }

            if ($transaction_ok == true) {
                $conn->commit();
                unset($_SESSION['debit_amount']);
                $_SESSION['messaging_balance'] = $data['wallet_balance'];

                $data['reference'] = $ref;
                $data['wallet_id'] = $wallet_id;
                $data['beneficiary_acct'] = $beneficiary;

                //send transaction notification
                $this->debitAlert($data);
                $this->creditAlert($data);

                return json_encode(array('response_code' => 0, 'response_message' => 'Transfer successful', 'reference' => $ref));
            } else {
                $conn->rollback();
                return json_encode(array('response_code' => 20, 'response_message' => 'Transaction could not be completed... '));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> WALLET_TRANSFER_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function debitAlert($data)
    {
        $subject = 'messaging - Transaction Notification';
        $message = '';
        $email_data = array(
            "salute" => 'Hello ' . $_SESSION['messaging_firstname'] . ',',
            "subtitle" => 'Your transfer to ' . $data['account_name'] . ' was successful',
            "beneficiary" => $data['account_name'],
            "label" => 'Beneficiary',
            "amount" => 'NGN ' . $data['debit_amount'],
            "reference" => $data['reference'],
            "to" => $_SESSION['messaging_email'],
            "from" => 'noreply@' . $_SERVER['SERVER_NAME'],
            "subject" => $subject,
            "message" => $message,
            "logo" => $this->base_url . 'assets/images/10.png',
            "template" => $this->template . 'transaction_notification.php',
            "type" => 'Debit Alert',
            "channel" => 'mail',
            "sender_name" => 'messaging',
            "date" => date('D d M, Y'),
            "account" => $_SESSION['messaging_userid'],
            "title" => 'Debit details',
            "pdflink" => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/receipt/' . $this->encrypt($data['reference']),
            "subscription" => array(2) //2=debit, 3=credit
        );
        //$this->notification->channel($email_data);

        return true;
    }
    public function creditAlert($data)
    {
        $subject = 'messaging - Transaction Notification';
        $stmt = $this->db_connect("SELECT firstname, email FROM userdata WHERE wallet_id ='" . $data['beneficiary_acct'] . "'");

        $subtitle = isset($_SESSION['messaging_firstname']) ? 'You have received payment from ' . $_SESSION['messaging_firstname'] . ' ' . $_SESSION['messaging_lastname'] : 'Your account has been credited';
        $email_data = array(
            "salute" => 'Hello ' . $stmt[0]['firstname'] . ',',
            "subtitle" => $subtitle,
            "beneficiary" => $_SESSION['messaging_firstname'] . ' ' . $_SESSION['messaging_lastname'],
            "label" => 'Sender',
            "amount" => 'NGN ' . $data['debit_amount'],
            "reference" => $data['reference'],
            "to" => $stmt[0]['email'],
            "from" => 'noreply@' . $_SERVER['SERVER_NAME'],
            "subject" => $subject,
            "message" => '',
            "logo" => $this->base_url . 'assets/images/10.png',
            "template" => $this->template . 'transaction_notification.php',
            "type" => 'Credit Alert',
            "channel" => 'mail',
            "sender_name" => 'messaging',
            "date" => date('D d M, Y'),
            "account" => $data['beneficiary_acct'],
            "title" => 'Credit details',
            "pdflink" => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/receipt/' . $this->encrypt($data['reference']),
            "subscription" => array(3) //2=debit, 3=credit
        );

        //$this->notification->channel($email_data);

        return true;
    }

    public function billsDebit($data)
    {
        // log bills payment transaction
        try {
            $db = new Connection(); //instantiates a new object for the Connection class
            $conn = $db->connect(); //instantiates a new object for the db connect() 

            $transaction_ok = true;
            $conn->beginTransaction();

            if (isset($data['usage_channel']) && $data['usage_channel'] != "") {
                $wallet_id = $data['id'][0];
            } else {
                $wallet_id = $_SESSION['messaging_userid'];
            }

            $get_wallet = $this->SelectOne('wallet_table', 'wallet_id', $this->encrypt($wallet_id), 'wallet_balance');
            $balance = $this->decrypt($get_wallet);

            // debit sender
            $bal = "UPDATE wallet_table SET ";
            $bal .= "wallet_balance = '" . $this->encrypt($balance - $data['debit_amount']) . "', ";
            $bal .= "wallet_previous_balance='" . $this->encrypt($balance) . "'";
            $bal .= " WHERE wallet_id='" . $this->encrypt($wallet_id) . "'";

            $stmt = $conn->prepare($bal);
            $stmt->execute();
            if ($stmt->rowCount() <= 0) {
                $transaction_ok = false;
            }
            $data['wallet_balance'] = $balance - $data['debit_amount'];

            // log payer's transaction 
            $debit = "(";
            $debit .= "'" . $this->encrypt($wallet_id) . "','";
            $debit .= $this->encrypt('DEBIT') . "','";
            $debit .= $this->encrypt($data['debit_amount']) . "','";
            $debit .= $this->encrypt('Payment for ' . $data['biller_name']) . "','";
            $debit .= $this->encrypt($data['reference']) . "','";
            $debit .= $this->encrypt(date('Y-m-d h:i:s')) . "','";
            $debit .= $this->encrypt($_SERVER['REMOTE_ADDR']) . "','";
            $debit .= $this->encrypt($data['biller_name']) . "','";
            $debit .= $this->encrypt($data['biller_code']) . "','";
            $debit .= $this->encrypt('Flutter') . "','";
            $debit .= $this->encrypt('wallet-' . $data['biller_name']) . "','";
            $debit .= $this->encrypt(30) . "'";
            $debit .= ")";

            $stmt = $conn->prepare("INSERT INTO transaction_table(source_acct,trans_type,source_amount,transaction_desc,transaction_id,created,posted_ip,account_name,account_number,bank_name,payment_mode,response_code) VALUES " . rtrim($debit, ','));
            $stmt->execute();
            if ($stmt->rowCount() <= 0) {
                $transaction_ok = false;
            }

            if ($transaction_ok == true) {
                $conn->commit();
                $_SESSION['messaging_balance'] = $data['wallet_balance'];
                unset($_SESSION['debit_amount']);

                $data['account_name'] = $data['biller_name'];
                $data['wallet_id'] = $wallet_id;
                //send debit notification
                $this->debitAlert($data);
                return json_encode(array('response_code' => 0, 'response_message' => 'Transaction successful'));
            } else {
                $conn->rollBack();
                return json_encode(array('response_code' => 20, 'response_message' => 'Transaction could not be completed...'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> BILLS_DEBIT_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function transactionReversal()
    {
        // reverse all failed transactions
        try {
            $db = new Connection(); //instantiates a new object for the Connection class
            $conn = $db->connect(); //instantiates a new object for the db connect() 

            $transaction_ok = true;
            $conn->beginTransaction();

            // get failed transactions 
            $response_code = $this->encrypt(30);
            $day_before = date('Y-m-d', strtotime('- 1 day'));
            $stmt = $this->conn->prepare("SELECT source_amount FROM transaction_table WHERE response_code ='$response_code' AND DATE(created) ='$day_before'");
            $stmt->execute();
            $row = $this->decrypt($stmt->fetchAll());

            foreach ($row as $val) {
                $get_wallet = $this->SelectOne('wallet_table', 'wallet_id', $this->encrypt($val['source_acct']), 'wallet_balance');
                $balance = $this->decrypt($get_wallet);

                // credit sender
                $bal = "UPDATE wallet_table SET ";
                $bal .= "wallet_balance = '" . $this->encrypt($balance + $val['source_amount'] + $val['chargefee']) . "', ";
                $bal .= "wallet_previous_balance='" . $this->encrypt($balance) . "'";
                $bal .= " WHERE wallet_id='" . $this->encrypt($val['source_acct']) . "'";

                $stmt = $conn->prepare($bal);
                $stmt->execute();
                if ($stmt->rowCount() <= 0) {
                    $transaction_ok = false;
                }

                // log payer's transaction
                $debit = "(";
                $debit .= "'" . $this->encrypt($val['source_acct']) . "','";
                $debit .= $this->encrypt('REVERSAL') . "','";
                $debit .= $this->encrypt($val['source_amount']) . "','";
                $debit .= $this->encrypt('REV/' . $val['transaction_desc']) . "','";
                $debit .= $this->encrypt('REV/' . $val['transaction_id']) . "','";
                $debit .= $this->encrypt(date('Y-m-d h:i:s')) . "','";
                $debit .= $this->encrypt($_SERVER['REMOTE_ADDR']) . "','";
                $debit .= $this->encrypt($val['account_name']) . "','";
                $debit .= $this->encrypt($val['account_number']) . "','";
                $debit .= $this->encrypt('Wallet') . "','";
                $debit .= $this->encrypt($val['payment_mode']) . "','";
                $debit .= $this->encrypt(0) . "'"; //credit
                $debit .= ")";

                $stmt = $conn->prepare("INSERT INTO transaction_table(source_acct,trans_type,source_amount,transaction_desc,transaction_id,created,posted_ip,account_name,account_number,bank_name,payment_mode,response_code) VALUES " . rtrim($debit, ','));
                $stmt->execute();
                if ($stmt->rowCount() <= 0) {
                    $transaction_ok = false;
                }
            }

            if ($transaction_ok == true) {
                $conn->commit();
                $this->creditAlert($data = array());
                return json_encode(array('response_code' => 0, 'response_message' => 'Reversal was successful'));
            } else {
                $conn->rollBack();
                return json_encode(array('response_code' => 20, 'response_message' => 'Reversal could not be completed...'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> TRANSACTION_RESERVAL_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function setSecurityQuestions($data)
    {
        try {
            if (isset($data['usage_channel']) && $data['usage_channel'] != "") {
                $data['username'] = str_replace("'", '', $data['username'][0]);
                $data['action'] = isset($data['action']) ? str_replace("'", '', $data['action'][0]) : '';
                $wallet_id =  str_replace("'", '', $data['id'][0]);
            } else {
                $wallet_id = $_SESSION['messaging_userid'];
            }

            $do_check = $this->SelectAllWhere('security_questions', 'wallet_id', $wallet_id);
            if ($do_check != "") {
                $data['action'] = 'edit';
            }

            if ($data['action'] == 'new') {
                if (isset($data['questions'])) {
                    if (count($data['questions']) == 0) {
                        return json_encode(array('response_code' => 20, 'response_message' => 'Please, provide at least 1 security question.'));
                    }
                    if (count($data['questions']) > 2) {
                        return json_encode(array('response_code' => 20, 'response_message' => 'Only 2 security questions are allowed.'));
                    }

                    $insert = '';
                    foreach ($data['questions'] as $key => $question) {
                        $insert .= "'" . $wallet_id . "','" . str_replace("'", '', $question['question_id'][0]) . "','" . str_replace("'", '', $question['answer'][0]) . "'-";
                    }

                    $batch_insert = explode('-', $insert);
                    for ($i = 0; $i < count($batch_insert); $i++) {
                        if (strlen($batch_insert[$i]) > 0) {
                            $stmt = $this->conn->prepare("INSERT INTO security_questions(wallet_id,question_id,answer) VALUES($batch_insert[$i])")->execute();
                        }
                    }
                } else {

                    $count = count($data['question']);
                    $questions = $data['question'];
                    $answers = $data['answer'];

                    for ($i = 0; $i < $count; $i++) {
                        $question = $questions[$i];
                        $answer = $answers[$i];

                        $stmt = $this->conn->prepare("INSERT INTO security_questions(wallet_id,question_id,answer) VALUES('$wallet_id','$question','$answer')")->execute();
                    }
                }


                if (!$stmt) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Security questions could not be added.'));
                }

                return json_encode(array('response_code' => 0, 'response_message' => 'Security questions has been successfully added.'));
            } else {
                if (isset($data['questions'])) {
                    if (count($data['questions']) == 0) {
                        return json_encode(array('response_code' => 20, 'response_message' => 'Please, provide at least 1 security question.'));
                    }

                    if (count($data['questions']) > 2) {
                        return json_encode(array('response_code' => 20, 'response_message' => 'Only 2 security questions are allowed.'));
                    }

                    $insert = '';
                    foreach ($data['questions'] as $question) {
                        $insert .= "question_id='" . str_replace("'", '', $question['question_id'][0]) . "',answer='" . str_replace("'", '', $question['answer'][0]) . "'-";
                    }

                    $ids = array();
                    $stmt = $this->conn->prepare("SELECT id FROM security_questions WHERE wallet_id='$wallet_id'");
                    $stmt->execute();

                    foreach ($stmt->fetchAll() as $row) {
                        $ids[] = array(
                            $row['id']
                        );
                    }

                    $batch_insert = explode('-', $insert);
                    for ($i = 0; $i < count($batch_insert); $i++) {
                        $id = $ids[0][$i];
                        if (strlen($batch_insert[$i]) > 0) {
                            $stmt = $this->conn->prepare("UPDATE security_questions SET $batch_insert[$i] WHERE wallet_id='$wallet_id' AND id='$id'")->execute();
                        }
                    }
                } else {
                    $count = count($data['question']);
                    $questions = $data['question'];
                    $answers = $data['answer'];

                    $ids = array();
                    $stmt = $this->conn->prepare("SELECT id FROM security_questions WHERE wallet_id='$wallet_id'");
                    $stmt->execute();

                    foreach ($stmt->fetchAll() as $row) {
                        $ids[] = array(
                            $row['id']
                        );
                    }

                    for ($i = 0; $i < $count; $i++) {
                        $question = $questions[$i];
                        $answer = $answers[$i];
                        $id = $ids[0][$i];
                        $stmt = $this->conn->prepare("UPDATE security_questions SET question_id='$question',answer='$answer' WHERE wallet_id='$wallet_id' AND id='$id'")->execute();
                    }
                }

                if (!$stmt) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Security questions could not be updated.'));
                }

                return json_encode(array('response_code' => 0, 'response_message' => 'Security questions has been successfully updated.'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> SECURITY_QUESTIONS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function setNotification($data)
    {
        try {

            // var_dump($data);exit;

            $wallet_id = $_SESSION['messaging_userid'];

            if (isset($data['notification'])) {
                if (count($data['notification']) == 0) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Please, provide at least 1 notification type.'));
                }

                $this->conn->prepare("DELETE FROM subscription_list WHERE wallet_id='$wallet_id'")->execute();

                foreach ($data['notification'] as $notification) {
                    $stmt = $this->conn->prepare("INSERT INTO subscription_list(wallet_id,subscription_id) VALUES('$wallet_id','$notification[0]')")->execute();
                }

                if (!$stmt) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Notification alert could not be configured.'));
                }

                return json_encode(array('response_code' => 0, 'response_message' => 'Notification alert has been successfully configured'));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Please, provide at least 1 notification type.'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> SET_SECURITY_ALERT_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function myNotificationAlerts()
    {
        $stmt = $this->conn->prepare("SELECT subscription_id FROM subscription_list WHERE wallet_id='" . $_SESSION['messaging_userid'] . "'");
        $stmt->execute();
        $subscriptions = array();
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $key => $value) {
                $subscriptions[] = $value['subscription_id'];
            }
        }

        return array_values($subscriptions);
    }

    public function create_bankDetails($data)
    {
        try {
            if (isset($data['usage_channel']) && $data['usage_channel'] != "") {
                $data['wallet_id'] = $data['wallet_id'];
            } else {
                $data['wallet_id'] = $_SESSION['messaging_userid'];
            }

            $wallet_id = $this->encrypt($data['wallet_id']);

            if ($data['action'] == 'new') {

                $stmt = $this->conn->prepare("SELECT * FROM bank_details WHERE source_wallet ='$wallet_id'");
                $stmt->execute();
                $get_bank = $this->decrypt($stmt->fetchAll());

                if ($get_bank == "") {
                    $bank['priority'] = 1;
                } else {
                    $bank['priority'] = 0;
                }

                $exists = 0;
                foreach ($get_bank as $value) {
                    if ($value['account_number'] == $data['wallet_id']) {
                        $exists += 1;
                    }
                }

                if ($exists > 0) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Bank details already exists'));
                }

                $bank['source_wallet'] = $data['wallet_id'];
                $bank['account_number'] = $data['wallet_id'];
                $bank['bank_name'] = $data['bank_name'];
                $bank['bank_code'] = $data['bank_code'];
                $bank['account_name'] = $data['account_name'];
                $bank['is_deleted'] = 0;
                $bank['created'] = date('Y-m-d h:i:s');

                $stmt = $this->Insert('bank_details', $bank, ['type', 'username', 'action', 'id', 'account_name_1', 'hci-csrf-token-label', 'wallet_id', 'usage_channel']);
                if ($stmt > 0) {
                    return json_encode(array('response_code' => 0, 'response_message' => 'Bank details has been successfully added'));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Bank details could not be added'));
                }
            } else {
                $get_bank = $this->decrypt($this->Select('bank_details', 'id', $data['id']));
                if ($get_bank == "") {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Bank details cound not be found'));
                }

                if (($get_bank['account_number'] == $data['wallet_id']) && ($get_bank['source_wallet'] != $data['wallet_id'])) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Bank details already exists'));
                }

                $data['account_number'] = $data['wallet_id'];

                $stmt = $this->Update('bank_details', $data, ['type', 'id', 'action', 'account_name_1', 'hci-csrf-token-label', 'wallet_id', 'usage_channel'], ['id' => $data['id']]);
                if ($stmt > 0) {
                    return json_encode(array('response_code' => 0, 'response_message' => 'Bank details has been successfully updated'));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Bank details could not be updated'));
                }
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> CREATE_BANK_DETAILS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function create_cardDetails($data)
    {
        try {
            if (isset($data['usage_channel']) && $data['usage_channel'] != "") {
                $data['id'] = $data['id'];
            } else {
                $data['id'] = $_SESSION['messaging_userid'];
            }

            if ($data['action'] == 'new') {
                $get_card = $this->decrypt($this->Select('card_details', 'source_wallet', $this->encrypt($data['id'])));
                if ($get_card == "") {
                    $data['priority'] = 1;
                } else {
                    $data['priority'] = 0;
                }


                if ($get_card['card_number'] == $data['card_number']) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Bank details already exists'));
                }

                $data['source_wallet'] = $data['id'];
                $data['is_deleted'] = 0;
                $data['created'] = date('Y-m-d h:i:s');

                $stmt = $this->Insert('card_details', $data, ['type', 'action', 'id', 'hci-csrf-token-label', 'usage_channel']);
                if ($stmt > 0) {
                    return json_encode(array('response_code' => 0, 'response_message' => 'Card details has been successfully added'));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Card details could not be added'));
                }
            } else {
                $get_card = $this->decrypt($this->Select('card_details', 'id', $data['id']));
                if ($get_card == "") {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Card details cound not be found'));
                }

                if (($get_card['card_number'] == $data['card_number']) && ($get_card['source_wallet'] != $_SESSION['messaging_userid'])) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Card details already exists'));
                }

                $stmt = $this->Update('card_details', $data, ['type', 'id', 'action', 'hci-csrf-token-label', 'usage_channel'], ['id' => $data['id']]);
                if ($stmt > 0) {
                    return json_encode(array('response_code' => 0, 'response_message' => 'Card details has been successfully updated'));
                } else {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Card details could not be updated'));
                }
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> CREATE_CARD_DETAILS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function myBanks()
    {
        try {
            $wallet_id = $this->encrypt($_SESSION['messaging_userid']);

            $this->db = new Connection(); //instantiates a new object for the Connection class
            $this->conn = $this->db->connect(); //instantiates a new object for the db connect() 

            $stmt = $this->conn->prepare("SELECT bank_code, bank_name FROM bank_details WHERE source_wallet='$wallet_id' AND is_deleted='" . $this->encrypt(0) . "'");
            $stmt->execute();
            $row[] = $this->decrypt($stmt->fetchAll());

            return json_encode(array('data' => $row[0]));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> GET_MY_BANKS_CONTROLLER => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function myBanksdetails($data)
    {
        try {
            $wallet_id = $this->encrypt($_SESSION['messaging_userid']);
            $bank_code = $this->encrypt($data['bank_code']);
            $active = $this->encrypt(0);

            $this->db = new Connection(); //instantiates a new object for the Connection class
            $this->conn = $this->db->connect(); //instantiates a new object for the db connect() 

            $stmt = $this->conn->prepare("SELECT account_name, account_number FROM bank_details WHERE source_wallet='$wallet_id' && bank_code='$bank_code' AND is_deleted='$active'");
            $stmt->execute();
            $row[] = $this->decrypt($stmt->fetch());

            if ($stmt->rowCount() == 0) {
                return json_encode(array('response_code' => 20, 'response_message' => 'No Beneficiary was found for the selected Bank'));
            }

            return json_encode(array('response_code' => 0, 'wallet_id' => $row[0]['account_number'], 'account_name' => $row[0]['account_name']));
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> GET_MY_BANKS_CONTROLLER => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function validation_key()
    {
        try {
            $key = file_get_contents($this->base_url . 'model/script.dll');
            return $key;
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> ENCRYPTION_KEY_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function updateTimeZone($data)
    {
        try {
            if (isset($data['usage_channel']) && $data['usage_channel'] != "") {
                $wallet_id = str_replace("'", '', $data['id'][0]);
                $timezone['timezone_id'] = str_replace("'", '', $data['timezone_id'][0]);
                $timezone['language_id'] = str_replace("'", '', $data['language_id'][0]);
            } else {
                $wallet_id = $_SESSION['messaging_userid'];
                $timezone['timezone_id'] = $data['timezone_id'];
                $timezone['language_id'] = $data['language_id'];
            }

            $validate = $this->SelectOne('timezone', 'id', $timezone['timezone_id'], 'timezone_region');
            if ($validate == "") {
                return json_encode(array('response_code' => 20, 'response_message' => 'The selected timezone does not exist.'));
            }

            $validate = $this->SelectOne('languages', 'id', $timezone['language_id'], 'language');
            if ($validate == "") {
                return json_encode(array('response_code' => 20, 'response_message' => 'The selected language does not exist.'));
            }

            $stmt = $this->Update('userdata', $timezone, [], ['wallet_id' => $this->encrypt($wallet_id)]);
            if ($stmt > 0) {
                $_SESSION['messaging_timezone'] = $this->SelectOne('timezone', 'id', $timezone['timezone_id'], 'timezone_region');
                $_SESSION['messaging_language'] = $this->SelectOne('languages', 'id', $timezone['language_id'], 'language');

                return json_encode(array('response_code' => 0, 'response_message' => 'Timezone has been successfully updated'));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'No changes has been made.'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> TIMEZONE_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function updateMobilePhone($data)
    {
        try {
            if (isset($data['usage_channel']) && $data['usage_channel'] != "") {
                $wallet_id = str_replace("'", '', $data['id'][0]);
                $data['country_code'] = str_replace(array("'", "+"), '', $data['country_code'][0]);
                $data['mobile_phone'] = str_replace("'", '', $data['mobile_phone'][0]);
            } else {
                $wallet_id = $_SESSION['messaging_userid'];
                $data['mobile_phone'] = $data['mobile_phone'];
            }

            $validate = $this->SelectOne('mobile_codes', 'value', $data['country_code'], 'code');
            if ($validate == "") {
                return json_encode(array('response_code' => 20, 'response_message' => 'The selected mobile code does not exist.'));
            }

            $code = explode(',', $data['country_code']);
            $phone = str_replace(' ', '', $data['mobile_phone']);
            if (strlen($phone) > 11 or strlen($phone) < 10) {
                return json_encode(array('response_code' => 20, 'response_message' => 'Invalid mobile number.'));
            } elseif (strlen($phone) == 11) {
                $number = '+' . $code[1] . substr($phone, 1, 11);
            } elseif (strlen($phone) == 10) {
                $number = '+' . $code[1] . $phone;
            }

            $update['mobile_phone'] = $number;

            $stmt = $this->Update('userdata', $update, [], ['wallet_id' => $this->encrypt($wallet_id)]);
            if ($stmt > 0) {
                $_SESSION['messaging_mobile_phone'] = $number;

                return json_encode(array('response_code' => 0, 'response_message' => 'Mobile number has been successfully updated'));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'No changes has been made.'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> MOBILE_PHONE_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function updatePersonalDetails($data)
    {
        try {

            $wallet_id = $_SESSION['messaging_userid'];

            $country = $this->SelectOne('countries', 'id', $data['country_id'], 'name');
            if ($country == "") {
                return json_encode(array('response_code' => 20, 'response_message' => 'The selected Country does not exist.'));
            }
            $state = $this->SelectOne('states', 'id', $data['state'], 'name');
            if ($state == "") {
                return json_encode(array('response_code' => 20, 'response_message' => 'The selected State does not exist.'));
            }
            $city = $this->SelectOne('cities', 'id', $data['city'], 'name');
            if ($city == "") {
                return json_encode(array('response_code' => 20, 'response_message' => 'The selected City does not exist.'));
            }


            if ($data['address'] == "") {
                return json_encode(array('response_code' => 20, 'response_message' => 'Please, provide your address.'));
            }

            $update['address'] = $data['address'];
            $update['mobile_phone'] = $data['mobile_phone'];


            $stmt = $this->Update('userdata', $data, ['type', 'hci-csrf-token-label', 'PHPSESSID', 'pageid'], ['wallet_id' => $wallet_id]);
            if ($stmt > 0) {
                $_SESSION['messaging_address'] = $update['address'];
                $_SESSION['messaging_country'] = $country;
                $_SESSION['messaging_state'] = $state;
                $_SESSION['messaging_city'] = $city;
                $_SESSION['messaging_mobile_phone'] = $update['mobile_phone'];
                $_SESSION['messaging_middlename'] = $data['middlename'];

                return json_encode(array('response_code' => 0, 'response_message' => 'Record has been successfully updated'));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'No changes has been made.'));
            }
        } catch (Exception $e) {
            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function deleteBankAccountNumber($data)
    {
        try {
            if (isset($data['usage_channel']) && $data['usage_channel'] != "") {
                $data['account_id'] = str_replace(array("'"), '', $data['account_id'][0]);
            }

            $update['is_deleted'] = 1;

            $stmt = $this->Update('bank_details', $update, [], ['account_number' => $this->encrypt($data['account_id'])]);
            if ($stmt > 0) {
                return json_encode(array('response_code' => 0, 'response_message' => 'Bank details has been successfully deleted'));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Bank details could not be deleted.'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> DELETE_BANK_DETAILS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function deleteCardDetails($data)
    {
        try {
            if (isset($data['usage_channel']) && $data['usage_channel'] != "") {
                $data['card_id'] = str_replace(array("'"), '', $data['card_id'][0]);
            }

            $update['is_deleted'] = 1;

            $stmt = $this->Update('card_details', $update, [], ['card_number' => $this->encrypt($data['card_id'])]);
            if ($stmt > 0) {
                return json_encode(array('response_code' => 0, 'response_message' => 'Card details has been successfully deleted'));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Card details could not be deleted.'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> DELETE_CARD_DETAILS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function db_connect($sql)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function receipt($ref)
    {
        try {
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> RECEIPT_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function systemBalance()
    {
        try {
            $currency['currency'] = 'NGN';
            $wallet = json_decode($this->flutter->getBalanceByCurrency($currency), true);
            if (isset($wallet['status']) && $wallet['status'] == 'error') {
                $this->error_msg = date('Y-m-d H:i:s') . " >>>> GET_SYSTEM_BALANCE_MODEL => Error: " . $wallet['message'];

                file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);
            }

            $minimum_bal = 50000;
            // if($wallet['data']['ledger_balance'] <= $amount OR $wallet['data']['available_balance'] <= $amount){
            if ($wallet['data']['available_balance'] <= $minimum_bal) {
                $header = 'Balance Notification';

                $subject = 'messaging - ' . $header;

                $message = "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px'><h5>Dear <b style='text-transform:uppercase;'>Ifeanyichukwu,</b></h5></p>";

                $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px;font-weight:300;'>messaging OPERATING BALANCE</p>";

                $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px;>Please, note that your NGN balances on Flutterwave as at " . date('d M, Y H:i:s') . " are <b>NGN " . $wallet['data']['available_balance'] . "</b> [Available Bal.] and <b>NGN " . $wallet['data']['ledger_balance'] . "</b> [Ledger Bal.] respectively.</p>";

                $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px;>We advice you fund the account to enable messaging transact with ease.</p>";

                $message .= "<p style='font-size:14px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;line-height:1.6;color:#000;margin-top:0;margin-bottom:15px;>Joyce</p>";

                $email_data = array(
                    "to" => 'hughi.obeni@gmail.com',
                    "from" => 'noreply@' . $_SERVER['SERVER_NAME'],
                    "subject" => $subject,
                    "message" => $message,
                    "logo" => $this->base_url . 'assets/images/10.png',
                    "template" => $this->template . 'otp.php',
                    "type" => $header,
                    "channel" => 'mail'
                );

                $today = date('Y-m-d');
                $get_today = $this->db_connect("SELECT * FROM system_balance_notification WHERE `date`='$today'");
                if (is_array($get_today) && sizeof($get_today) > 0) {
                    return json_encode(array('response_code' => 20, 'response_message' => 'Notification has already been sent for today.'));
                } else {
                    $stmt = json_decode($this->notification->channel($email_data), true);
                    if ($stmt['reponse_code'] == 0) {
                        $this->runCRUD("INSERT INTO system_balance_notification(`notified`,`date`,`created`) VALUES('1','" . date('Y-m-d') . "','" . date('Y-m-d h:i:s') . "')");
                        return json_encode(array('response_code' => 0, 'response_message' => 'Notification has been sent.'));
                    } else {
                        return json_encode(array('response_code' => 20, 'response_message' => $stmt['response_message']));
                    }
                }
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'No need to worry'));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> GET_SYSTEM_BALANCE_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function AccountAccess($data)
    {
        try {
            $text = ($data['user_disabled'] == 1) ? 'disabled' : 'enabled';
            $stmt = $this->Update('userdata', $data, ['wallet_id', 'hci-csrf-token-label', 'type'], ['wallet_id' => $this->encrypt($data['wallet_id'])]);
            if ($stmt > 0) {
                return json_encode(array('response_code' => 0, 'response_message' => 'Account has been successfully ' . $text));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Account could not be ' . $text));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> ACCOUNT_LOCKER_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }
    public function AccountLocker($data)
    {
        try {
            $text = ($data['user_locked'] == 1) ? 'locked' : 'unlocked';
            $stmt = $this->Update('userdata', $data, ['wallet_id', 'hci-csrf-token-label', 'type'], ['wallet_id' => $this->encrypt($data['wallet_id'])]);
            if ($stmt > 0) {
                return json_encode(array('response_code' => 0, 'response_message' => 'Account has been successfully ' . $text));
            } else {
                return json_encode(array('response_code' => 20, 'response_message' => 'Account could not be ' . $text));
            }
        } catch (Exception $e) {
            $this->error_msg = date('Y-m-d H:i:s') . " >>>> ACCOUNT_ACCESS_MODEL => Error: " . $e->getMessage();

            file_put_contents($this->logfile . $this->current_date . '.php', $this->error_msg . PHP_EOL, FILE_APPEND | LOCK_EX);

            return json_encode(array('response_code' => 20, 'response_message' => 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine()));
        }
    }

    public function generateRandomDigit()
    {
        $length = 15;
        $min = pow(10, $length - 1);
        $max = pow(10, $length) - 1;
        return strval(random_int($min, $max));
    }

    public function mimeType()
    {
        return array(
            'image/png',
            'image/jpeg',
            'image/jpg',
            // 'application/msword',
            'application/pdf',
            // 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        );
    }

    public function profileScore($wallet_id = '')
    {
        $wallet_id = ($wallet_id == '') ? $_SESSION['messaging_userid'] : $wallet_id;
        $score = $daysUntilExpiry = 0;
        $stmt = $this->db_connect("SELECT * FROM userdata WHERE wallet_id = '{$wallet_id}'");
        if (is_array($stmt) && count($stmt) > 0) {

            if (!empty($stmt[0]['card_expiry_date'])) {
                $expiryDate = strtotime($stmt[0]['card_expiry_date']); // Convert the expiry date to a Unix timestamp
                $today = strtotime(date('Y-m-d')); // Get today's date as a Unix timestamp

                $daysUntilExpiry = ($expiryDate - $today) / 86400; // Calculate the number of days until expiry
            }

            if ($stmt[0]['status'] == 1 && $daysUntilExpiry <= 0) {
                $score = 30;
            } elseif ($stmt[0]['status'] == 1 && $daysUntilExpiry > 0) {
                $score = 100;
            }
        }

        return $score;
    }

    public function getAlert()
    {
        $stmt = $this->SelectArr('notifications', ['is_deleted'], [0], '*');
        if ($stmt == "") {
            return json_encode(['response_code' => 20, 'response_message' => '']);
        }

        return json_encode(['response_code' => 0, 'response_message' => 'Alert', 'data' => ['subject' => $stmt['subject'], 'message' => $stmt['content'], 'status' => $stmt['allow_transactions']]]);
    }

    public function validatePhoneNumber($phoneNumber)
    {
        // Remove any non-digit characters from the input
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        // Define a regular expression pattern for a common phone number format
        $pattern = '/^(\+?[0-9]{1,4})?[0-9]{10}$/';

        // Use the preg_match function to check if the phone number matches the pattern
        $length = strlen($phoneNumber);
        if ($length >= 10 && $length <= 13) {
            return true;
        } else if (preg_match($pattern, $phoneNumber)) {
            return true; // Valid phone number with the correct length
        } else {
            return false; // Invalid phone number or incorrect length
        }
    }

    public function isAccountNumberValid($accountNumber)
    {
        // Define the expected length for your account numbers
        $expectedLength = 10;

        // Check if the account number is numeric and has the expected length
        if (is_numeric($accountNumber) && strlen($accountNumber) === $expectedLength) {
            return true;
        } else {
            return false;
        }
    }

    public function validateEmail($email)
    {
        // Define a regular expression pattern for a valid email address
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        // Use the preg_match function to check if the email matches the pattern
        if (preg_match($pattern, $email)) {
            return true; // Valid email address
        } else {
            return false; // Invalid email address
        }
    }

    public function validateCurrentDomain($referenceDomain)
    {
        $currentDomain = strtolower($_SERVER['HTTP_HOST']);

        // Remove any leading subdomains from both domains
        $currentDomain = preg_replace('/^[\w-]+\./', '', $currentDomain);
        $referenceDomain = preg_replace('/^[\w-]+\./', '', $referenceDomain);

        // Split the current domain into parts
        $currentDomainParts = explode('.', $currentDomain);
        $referenceDomainParts = explode('.', $referenceDomain);

        // Compare the domain parts starting from the right (TLD) and moving left
        for ($i = 1; $i <= min(count($currentDomainParts), count($referenceDomainParts)); $i++) {
            if ($currentDomainParts[count($currentDomainParts) - $i] !== $referenceDomainParts[count($referenceDomainParts) - $i]) {
                return false;
            }
        }

        // If we made it through the loop, the current domain is a subdomain of the reference domain
        // Return true and the parent domain
        return [
            'isSubdomain' => true,
            'parentDomain' => $referenceDomain,
        ];
    }

    public function calculate_integrity($file_path)
    {
        // Read the content of the file
        $content = file_get_contents($file_path);

        // Calculate SHA-256 hash
        $sha256_hash = hash('sha256', $content, true);

        // Encode the hash in Base64
        $base64_hash = base64_encode($sha256_hash);

        // Format the integrity value
        $integrity_value = 'sha256-' . $base64_hash;

        return $integrity_value;
    }
}
