<?php
  error_reporting(E_ALL ^ E_NOTICE);
  session_start();
  ob_start();  
  header('Cache-Control: no-store, must-revalidate');
  header('Pragma       : no-cache');
  header('Expires      : 0');

  $cookie_name    = 'siteAuth';
  $cookie_time    = (3600 * 24 * 30);
  $algoritma      = "rijndael-256";
  $mode           = "cfb";
  $secretkey      = "sikartun";
  $TITLE          = "Sistem Informasi Kepanitiaan HUT RI 71";
  $domain         = "localhost";
  $url_rewrite    = "http://localhost/agustusan/";
  $REQUEST        = "agustusan/content";
  $PROSES_REQUEST = "agustusan/process";
  // $path           = "/var/www/html/agustusan/";
  $path           = "/Applications/XAMPP/xamppfiles/htdocs/agustusan/";
  // $path_upload    = "/var/www/html/agustusan/static/uploads/";
  $path_upload    = "/Applications/XAMPP/xamppfiles/htdocs/agustusan/static/uploads/";
  $path_download   = "/Applications/XAMPP/xamppfiles/htdocs/agustusan/template/";

  class config {
    public $db_host              = "localhost";
    public $db_user              = "root";
    public $db_pass              = "";
    public $database             = "soal";
    public $url_rewrite_class    = "http://localhost/agustusan/";
    public $hashing_number       = "k4r4n9t4run4";
    public $debug                = 1;
    public static $session_time  = 7200 /*2 hours*/;
    public function open_connection() {
      $this->link_db = mysqli_connect($this->db_host, $this->db_user, $this->db_pass,$this->database)
      or die("Koneksi Database gagal");
      return $this->link_db;
    }
    public function sql_details() {
      $this->sql_details = array(
        'user' => $this->db_user,
        'pass' => $this->db_pass,
        'db'   => $this->database,
        'host' => $this->db_host
      );
      return $this->sql_details;
    }
  }
?>
