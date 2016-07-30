<?php
  require_once './config/application.php';
  $path = ltrim($_SERVER['REQUEST_URI'], '/');
  $temp_path = explode($PROSES_REQUEST,$path);
  $elements = explode('/', $temp_path[1]);
  $data = array_filter($elements);


  
  if (count($data) == 0){
    include "./index.php";
  }
  else {
    switch ($data[1]) {
      case 'submit_register';
        if($_POST["password"]!=$_POST["konfirmasi_password"]){
            $utility->load("content/registrasi","error","Isian Password dan Konfirmasi Pasword Tidak Sama, Silahkan Masukkan Kembali");
        }
        else{
          $password = $utility->sha512($_POST["password"]);
          $data = array(
            "name"=>$_POST["name"],
            "username"=>$_POST["username"],
            "password"=>$password,
            "alamat"=>$_POST["alamat"]
              );
         $pengguna->insertPengguna($data);
        }
      break;
      case 'user':
        $process = $data[2]; 
        include "./core/pengguna/proses_pengguna.php";
      break;
      case 'report':
        $process = $data[2]; 
        include "./core/pengguna/proses_report.php";
      break;
      case 'acara':
        $process = $data[2]; 
        include "./core/acara/proses_acara.php";
      break;
      case 'rab':
        $process = $data[2]; 
        include "./core/rab/proses_rab.php";
      break;
      case 'acara':
        $process = $data[2]; 
        include "./core/acara/proses_acara.php";
      break;
      case 'penerimaan':
        $process = $data[2]; 
        include "./core/penerimaan/proses_penerimaan.php";
      break;
      case 'pengeluaran':
        $process = $data[2]; 
        include "./core/pengeluaran/proses_pengeluaran.php";
      break;
      case 'rab51':
        $process = $data[2]; 
        include "./core/rab/proses_rab51.php";
        break;
      case 'example':
        if ($data[2] == "hapusexample") {
          $hapusdata = $purifier->purify($data[3]);
        }
        else if ($data[2] == "anotherexample") {
          $publishdata = $purifier->purify($data[3]);
          $publishvalue = $purifier->purify($data[4]);
        }
        include "./core/today/proses_today.php";
      break;
      default:
        header('HTTP/1.1 404 Not Found');
        include "view/404.php";
      break;
    }
  }
?>
