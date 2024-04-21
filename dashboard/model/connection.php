<?php
class Connection
{
    public $db_host;
    public $db_user;
    public $db_pass;
    public $db_name;
    public $conn;
    public $ip;
    public $sandbox_host;
    public $sandbox_user;
    public $sandbox_pass;
    public $sandbox_db;
    public $sandbox;
    public $default_host;
    public $default_user;
    public $default_pass;
    public $default_db;
    public $default;

    public function __construct()
    {
        $this->ip = $_SERVER['REMOTE_ADDR'];

        if (in_array($this->ip, ['::1', 'localhost'])) {

            $this->db_host  = "localhost";
            $this->db_user  = "root";
            $this->db_pass  = "";
            $this->db_name  = "messaging";
        } else {
            //live environment
            $this->db_host  = "localhost";
            $this->db_user  = "";
            $this->db_pass  = "";
            $this->db_name  = "";
        }
    }

    public function connect()
    {

        try {
            $this->conn = new PDO("mysql:host={$this->db_host}; dbname={$this->db_name}", $this->db_user, $this->db_pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        return $this->conn;
    }

    public function production()
    {
        if (in_array($this->ip, ['::1', 'localhost'])) {
            $this->default_host = 'localhost'; //
            $this->default_user = 'root'; //
            $this->default_pass = '';
            $this->default_db = 'messaging';
        } else {
            //connect to live environment amd update environment mode to 1
            $this->default_host = 'localhost';
            $this->default_user = ''; //
            $this->default_pass = '';
            $this->default_db = '';
        }

        try {
            $this->default = new PDO("mysql:host={$this->default_host}; dbname={$this->default_db}", $this->default_user, $this->default_pass);
            $this->default->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->default->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return $this->default;
    }

    public function sandbox()
    {
        if (in_array($this->ip, ['::1', 'localhost'])) {
            $this->sandbox_host = 'localhost';
            $this->sandbox_user = 'root';
            $this->sandbox_pass = '';
            $this->sandbox_db = 'messaging';
        } else {
            //connect to live environment amd update environment mode to 1
            $this->sandbox_host = 'localhost';
            $this->sandbox_user = '';
            $this->sandbox_pass = '';
            $this->sandbox_db = '';
        }

        try {
            $this->sandbox = new PDO("mysql:host={$this->sandbox_host}; dbname={$this->sandbox_db}", $this->sandbox_user, $this->sandbox_pass);
            $this->sandbox->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->sandbox->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return $this->sandbox;
    }
}