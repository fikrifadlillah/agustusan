<?php
require_once __DIR__ . '/../../utility/PHPExcel/IOFactory.php';
require_once __DIR__ . '/../../utility/ExcelReader.php';

switch ($process) {
  case 'import':
  
  break;
  case 'table':
    // echo "This";
    $table = "penerimaan";
    $key   = "id";
    $column = array(
      array( 'db' => 'id',      'dt' => 0 ),
      array( 'db' => 'nama_donatur',   'dt' => 1 ),
      array( 'db' => 'alamat',  'dt' => 2),
      array( 'db' => 'jumlah',  'dt' => 3),
      array( 'db' => 'username',  'dt' => 4),
      array(  'db' => 'id',  'dt' => 5, 'formatter' => function($d,$row,$data){ 
          if($_SESSION["level"]==0 or $_SESSION["level"]==1){
          // return  '<div class="text-center">'.
          //           '<a style="margin:0 2px;" id="btn-viw" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-file-text-o"></i> Edit</a>'.
          //           '<a style="margin:0 2px;" id="btn-edt" href="#editModal" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-edit"></i>Hapus</a>'.
          //         '</div>';
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-hps" href="#btn-hps" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-edit"></i>Hapus</a>'.
                  '</div>';
         }
         else{
          return "";
         }
        }),
    );
    $datatable->get_rkakl_view($table, $key, $column);
  break;

  case 'tambah-dana':
    $penerimaan->insertPenerimaan($_POST);
    $utility->location_goto("./view/content/penerimaan.php");
  break;
  case 'hapus-penerimaan':
  // print_r($_POST);
   $penerimaan->deletePenerimaan($_POST["key"]);
   $utility->load("content/penerimaan/","success","Data Penerimaan Dana telah Dihapus");
  break;
  default:
    $utility->location_goto(".");
  break;
}
?>
