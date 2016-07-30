<?php
include 'config/application.php';
// require_once __DIR__ . '/../../utility/PHPExcel/IOFactory.php';
// require_once __DIR__ . '/../../utility/ExcelReader.php';
require_once './utility/PHPExcel.php';
require_once './utility/PHPExcel/IOFactory.php';

$sess_id    = $_SESSION['user_id'];
$direktorat = $_SESSION['direktorat'];

$id = $data[3];



$param  = explode("-", $data[3]);
$id = $param[0];
// $penerima = str_replace("%20"," ",$param[1]);
$format = $param[2];
switch ($data[2]) {
  case 'rekap_penerimaan':
    $report->rekap_penerimaan();
  break;
  default:
    
    echo $kdakun;
  break;
}
?>
