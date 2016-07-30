<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";
  require_once __DIR__ . '/../utility/PHPExcel.php';
  require_once __DIR__ . '/../utility/PHPExcel/IOFactory.php';

  class modelReport extends mysql_db {

    public function getChartRKAKL(){
      $result = $this->query("SELECT KDGIAT, sum(jumlah), sum(realisasi) from rkakl_full group by KDGIAT");
      while($res=$this->fetch_array($result)){
          $results[] = $res;
      }
      $prev_value = array('value' => null, 'amount' => null);
      sort($results);
      foreach ($results as $data) {
        if ($prev_value['value'] != $data['KDGIAT'] && $data['KDGIAT'] != null) {
            unset($prev_value);
            $prev_value = array('value' => 'Kode Kegiatan '.$data['KDGIAT'], 'amount' => $data['sum(jumlah)']);
            $newResults[] =& $prev_value;
        }
        $prev_value['amount']++;
      }
      for ($i=0; $i < count($newResults) ; $i++) { 
        $newresult[$i][] =& $newResults[$i]['value'];
        $newresult[$i][] =& $newResults[$i]['amount'];
      }
      echo json_encode($newresult);
    }

    
    public function create_pdf($name, $size, $html){
      ob_end_clean();
      $mpdf=new mPDF('utf-8', $size); 
      $mpdf->WriteHTML(utf8_encode($html));
      $mpdf->Output($name.".pdf" ,'I');
      exit;
    }

    public function create_word($name, $size, $html){
      ob_end_clean();
      header("Content-type: application/vnd.ms-word");
      header("Content-Disposition: attachment;Filename=".$name.".doc");
      echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"
              xmlns:w="urn:schemas-microsoft-com:office:word"
              xmlns="http://www.w3.org/TR/REC-html40">';
      echo '<head>';
      echo '<style >
              @page Section1
              { 
                 mso-header-margin:.20in;
                margin: 0.40in 0.40in 0.40in 0.40in; 
              } 
               div.Section1
                {page:Section1;}
              body,  p.MsoNormal, li.MsoNormal, div.MsoNormal {
              margin: 0.8mm 0.8mm 0.8mm 0.8mm;
              margin-bottom:.0001pt;
              font-size:12.0pt;     
              }
              </style>';
      echo '<body>
             <div class="Section1"> ';
      echo $html;
      echo '</div>
      </body>';
      echo '<head>';
      echo '<html>';
    }

    
    public function rekap_penerimaan(){
      $nama="";
      $sql = "SELECT nama, alamat, jiwa, beras, uang, maal, infaq, fidyah, santunan, tot_uang from penerimaan";
      $hsl_rekap = $this->query($sql);

       $objPHPExcel = new PHPExcel();
      // Set properties
      $objPHPExcel->getProperties()->setCreator("")
              ->setLastModifiedBy("")
              ->setTitle("")
              ->setSubject("")
              ->setDescription("")
              ->setKeywords("")
              ->setCategory("");
      $border = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      );
        $horizontal = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $vertical = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getDefaultStyle()->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getDefaultStyle()->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);

        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true); 
        $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true); 
        for($col = 'A'; $col !== 'F'; $col++) {
          if($col!='A' and $col!='F'){
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(false);
          }
        }
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        
        $sheet = $objPHPExcel->getActiveSheet()->setTitle("REKAPTULASI");
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->mergeCells('A3:A4');
        $sheet->mergeCells('B3:B4');
        $sheet->mergeCells('C3:C4');
        $sheet->mergeCells('D3:D4');
        $sheet->mergeCells('E3:F3');
        $sheet->mergeCells('G3:G4');
        $sheet->mergeCells('I3:I4');
        $sheet->mergeCells('K3:L3');
        
        $sheet->getStyle('A3:L4')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        
        $sheet->getStyle('A1:L4')->applyFromArray($horizontal);    
        $sheet->getStyle('A1:L4')->applyFromArray($vertical);
        $sheet->getStyle("A5:F5")->applyFromArray($border);
        $sheet->getStyle("A3:L4")->applyFromArray($border);
        // $objPHPExcel->getActiveSheet()->getStyle("A1:A3")->getFont()->setSize(14); 
        $objPHPExcel->getActiveSheet()->getStyle("A5:L5")->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(14);
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1',"REKAPTULASI PENERIMAAN PANITIA ZIS" )
                ->setCellValue('A3',"NO" )
                ->setCellValue('B3',"NAMA" )
                ->setCellValue('C3',"ALAMAT" )
                ->setCellValue('D3',"JIWA" )
                ->setCellValue('E3',"ZAKAT FITRAH" )
                ->setCellValue('E4',"BERAS" )
                ->setCellValue('F4',"UANG" )
                ->setCellValue('G3',"MAAL" )
                ->setCellValue('H3',"INFAQ" )
                ->setCellValue('H4',"SHADAQAH" )
                ->setCellValue('I3',"FIDIYAH" )
                ->setCellValue('J3',"SANTUNAN" )
                ->setCellValue('J4',"ANAK YATIM" )
                ->setCellValue('K3',"TOTAL" )
                ->setCellValue('K4',"BERAS" )
                ->setCellValue('L4',"UANG" );

      $row=5;
      $cell = $objPHPExcel->setActiveSheetIndex(0);
      $tot_pendapatan = 0;
      $tot_pjk_pendapatan = 0;
      $nomor=1;
      $acc_jiwa = $acc_beras = $acc_uang = $acc_maal = $acc_infaq = $acc_fidiyah = $acc_santunan = $acc_tot_beras = $acc_tot_uang;
      foreach ($hsl_rekap as $nilai) {
    
        $cell->setCellValue('A'.$row, $nomor);
        $cell->setCellValue('B'.$row, $nilai[nama]);
        $cell->setCellValue('C'.$row, $nilai[alamat]);
        $cell->setCellValue('D'.$row, $nilai[jiwa]);
        if($nilai[beras]>0) $cell->setCellValue('E'.$row, $nilai[beras]." L");
        if($nilai[uang]>0) $cell->setCellValue('F'.$row, $nilai[uang]);
        if($nilai[maal]>0) $cell->setCellValue('G'.$row, $nilai[maal]);
        if($nilai[infaq]>0) $cell->setCellValue('H'.$row, $nilai[infaq]);
        if($nilai[fidyah]>0) $cell->setCellValue('I'.$row, $nilai[fidyah]);
        if($nilai[santunan]>0) $cell->setCellValue('J'.$row, $nilai[santunan]);
        if($nilai[beras]>0) $cell->setCellValue('K'.$row, $nilai[beras]);
        if($nilai[tot_uang]>0) $cell->setCellValue('L'.$row, $nilai[tot_uang]);
        $sheet->getStyle("A".$row.":L".$row)->applyFromArray($border);
         $objPHPExcel->getActiveSheet()->getStyle("A".$row.":L".$row)->getFont()->setSize(12);
         $sheet->getStyle("F".$row.":L".$row)->getNumberFormat()->setFormatCode('#,##0');
        $nomor+=1;
        $row+=1;
        $acc_jiwa     +=$nilai[jiwa];
        $acc_beras    +=$nilai[beras];
        $acc_uang     +=$nilai[uang];
        $acc_maal     +=$nilai[maal];
        $acc_infaq    +=$nilai[infaq];
        $acc_fidiyah  +=$nilai[fidiyah];
        $acc_santunan +=$nilai[santunan];
        $acc_beras    +=$nilai[beras];
        $acc_tot_uang +=$nilai[tot_uang];

      }
      // $row+=1;

      $sheet->mergeCells('A'.$row.':C'.$row);
      $cell->setCellValue('A'.$row, "TOTAL");
      $sheet->getStyle("A".$row.":L".$row)->getFont()->setBold(true);
      $cell->setCellValue('D'.$row, $acc_jiwa);
      $cell->setCellValue('E'.$row, $acc_beras." L");
      $cell->setCellValue('F'.$row, $acc_uang);
      $cell->setCellValue('G'.$row, $acc_maal);
      $cell->setCellValue('H'.$row, $acc_infaq);
      $cell->setCellValue('I'.$row, $acc_fidiyah);
      $cell->setCellValue('J'.$row, $acc_santunan);
      $cell->setCellValue('K'.$row, $acc_beras);
      $cell->setCellValue('L'.$row, $acc_tot_uang);
      $sheet->getStyle("A".$row.":L".$row)->applyFromArray($border);
      $objPHPExcel->getActiveSheet()->getStyle("A".$row.":F".$row)->getFont()->setSize(12);
      $sheet->getStyle("F".$row.":L".$row)->getNumberFormat()->setFormatCode('#,##0');
        Header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="rekap_penerimaan.xlsx"');
        header('Cache-Control: max-age=0');


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // If you want to output e.g. a PDF file, simply do:
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
        $objWriter->save('php://output');
    }

    function kekata($x) {
      $x = abs($x);
      $angka = array("", "satu", "dua", "tiga", "empat", "lima",
      "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
      $temp = "";
      if ($x <12) {
      $temp = " ". $angka[$x];
      } else if ($x <20) {
      $temp = $this->kekata($x - 10). " belas";
      } else if ($x <100) {
      $temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
      } else if ($x <200) {
      $temp = " seratus" . $this->kekata($x - 100);
      } else if ($x <1000) {
      $temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
      } else if ($x <2000) {
      $temp = " seribu" . $this->kekata($x - 1000);
      } else if ($x <1000000) {
      $temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
      } else if ($x <1000000000) {
      $temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
      } else if ($x <1000000000000) {
      $temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
      } else if ($x <1000000000000000) {
      $temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
      }
      return $temp;

    }

    function konversi_tanggal($tgl,$type)
    {
      $data_tgl = explode("-",$tgl);
      $bulan ="";
      if($data_tgl[1]=="01")
            {
                $bulan="Januari";
            }        

            if($data_tgl[1]=="02")
            {
                $bulan="Februari";
            }

            if($data_tgl[1]=="03")
            {
                $bulan="Maret";
            }
            if($data_tgl[1]=="04")
            {
                $bulan="April";
            }
            if($data_tgl[1]=="05")
            {
                $bulan="Mei";
            }
            if($data_tgl[1]=="06")
            {
                $bulan="Juni";
            }
            if($data_tgl[1]=="07")
            {
                $bulan="Juli";
            }
            if($data_tgl[1]=="08")
            {
                $bulan="Agustus";
            }
            if($data_tgl[1]=="09")
            {
                $bulan="September";
            }
            if($data_tgl[1]=="10")
            {
                $bulan="Oktober";
            }
            if($data_tgl[1]=="11")
            {
                $bulan="November";
            }
            if($data_tgl[1]=="12")
            {
                $bulan="Desember";
            }
      if($type==""){
        $array = array($data_tgl[2],$bulan,$data_tgl[0]);
        $tanggal = implode(" ", $array );
      }
      else {
        $array = array($data_tgl[2],$data_tgl[1],$data_tgl[0]);
        $tanggal = implode(" / ", $array );
      }
      
      return $tanggal;
    }    

    function terbilang($x, $style=1) {
      if($x<0) {
      $hasil = "minus ". trim($this->kekata($x));
      } else {
      $hasil = trim($this->kekata($x));
      }
      switch ($style) {
      case 1:
      $hasil = strtoupper($hasil);
      break;
      case 2:
      $hasil = strtolower($hasil);
      break;
      case 3:
      $hasil = ucwords($hasil);
      break;
      default:
      $hasil = ucfirst($hasil);
      break;
      }
      $hasil .= " RUPIAH";
      return $hasil;
    }
  public function Romawi($n){
      if($n=="") $n="";
      $hasil = "";
      $iromawi = array("","I","II","III","IV","V","VI","VII","VIII","IX","X",20=>"XX",30=>"XXX",40=>"XL",50=>"L",
      60=>"LX",70=>"LXX",80=>"LXXX",90=>"XC",100=>"C",200=>"CC",300=>"CCC",400=>"CD",500=>"D",600=>"DC",700=>"DCC",
      800=>"DCCC",900=>"CM",1000=>"M",2000=>"MM",3000=>"MMM");
      if(array_key_exists($n,$iromawi)){
        $hasil = $iromawi[$n];
      }
      elseif($n >= 11 && $n <= 99){
        $i = $n % 10;
       $hasil = $iromawi[$n-$i] . Romawi($n % 10);
      }
        elseif($n >= 101 && $n <= 999){
        $i = $n % 100;
        $hasil = $iromawi[$n-$i] . Romawi($n % 100);
      }
      else{
        $i = $n % 1000;
        $hasil = $iromawi[$n-$i] . Romawi($n % 1000);
      }
      return $hasil;
    }
}

?>
