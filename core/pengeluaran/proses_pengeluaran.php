<?php
require_once __DIR__ . '/../../utility/PHPExcel/IOFactory.php';
require_once __DIR__ . '/../../utility/ExcelReader.php';

switch ($process) {
  case 'import':
  
  break;
  case 'table':
    // echo "This";
    $table = "realisasi";
    $key   = "id";
    $column = array(
      array( 'db' => 'id',      'dt' => 0 ),
      array( 'db' => 'nama_item',   'dt' => 1 ),
      array( 'db' => 'jumlah',  'dt' => 2),
      array( 'db' => 'satuan',  'dt' => 3),
      array( 'db' => 'harga_satuan',  'dt' => 4),
      array( 'db' => 'total_harga',  'dt' => 5),
      array( 'db' => 'output_kegiatan',  'dt' => 6),
      array( 'db' => 'username',  'dt' => 7),
      array(  'db' => 'username',  'dt' => 8, 'formatter' => function($d,$row,$data){ 

          // return  '<div class="text-center">'.
          //           '<a style="margin:0 2px;" id="btn-viw" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-file-text-o"></i> Edit</a>'.
          //           '<a style="margin:0 2px;" id="btn-edt" href="#editModal" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-edit"></i>Hapus</a>'.
          //         '</div>';
         if($d==$_SESSION["username"] or $_SESSION["level"]<2){
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-hps" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-edit"></i>Hapus</a>'.
                  '</div>';
          }

        }),
    );
    $datatable->get_rkakl_view($table, $key, $column);
  break;

  case 'tambah-pengeluaran':
    $pengeluaran->insertPengeluaran($_POST);
  break;
  case 'baca_kegiatan':
    $pengeluaran->baca_kegiatan();
  break;
  case 'hapus-pengeluaran':
   $pengeluaran->deletePengeluaran($_POST["key"]);
  break;
  default:
    $utility->location_goto(".");
  break;
}
?>
