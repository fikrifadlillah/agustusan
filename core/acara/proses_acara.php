<?php
require_once __DIR__ . '/../../utility/PHPExcel/IOFactory.php';
require_once __DIR__ . '/../../utility/ExcelReader.php';

switch ($process) {
  case 'import':
  
  break;
  case 'table':
    $table = "kegiatan";
    $key   = "id";
    $column = array(
      array( 'db' => 'id',      'dt' => 0 ),
      array( 'db' => 'nama_kegiatan',   'dt' => 1 ),
      array( 'db' => 'tanggal',  'dt' => 2),
      array( 'db' => 'lokasi',  'dt' => 3),
      array( 'db' => 'pj',  'dt' => 4),
      array( 'db' => 'dana',  'dt' => 5),
      array( 'db' => 'user_name',  'dt' => 6),
      array( 'db' => 'id',  'dt' => 7, 'formatter' => function($d,$row,$data){ 

          // return  '<div class="text-center">'.
          //           '<a style="margin:0 2px;" id="btn-viw" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-file-text-o"></i> Edit</a>'.
          //           '<a style="margin:0 2px;" id="btn-edt" href="#editModal" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-edit"></i>Hapus</a>'.
          //         '</div>';
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-hps" href="#btn-hps" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-edit"></i>Hapus</a>'.
                  '</div>';

        }
      ),
    );
    $datatable->get_rkakl_view($table, $key, $column);
  break;
  case 'tambah-acara':
    $acara->insertAcara($_POST);
    
  break;
  case 'hapus-acara':
  // print_r($_POST);
   $acara->deleteAcara($_POST["key"]);
   $utility->load("content/acara/","success","Data Kegiatan telah Dihapus");
  break;
  default:
    $utility->location_goto(".");
  break;
}
?>
