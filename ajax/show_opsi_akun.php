<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
#This code provided by:
#Andreas Hadiyono (andre.hadiyono@gmail.com)
#Gunadarma University
include '../config/application.php';
// $kodeUniversitas=$_GET['kodeUniversitas'];
 $id_rabfull=$_GET['id_rabfull'];
 $query1 = $db->query("SELECT * FROM rabfull where id ='$id_rabfull'");
 $row1 = $db->fetch_object($query1);


 $query2="select distinct K.KDAKUN, K.NMAKUN from rkakl_full as K
 					
 					where K.KDAKUN not like '51%' 
 						and K.THANG = '$row1->thang' 
 						and K.KDPROGRAM = '$row1->kdprogram' 
						and K.KDGIAT = '".trim($row1->kdgiat,"\x0D\x0A")."' 
						and K.KDOUTPUT = '".trim($row1->kdoutput,"\x0D\x0A")."' 
						and K.KDSOUTPUT = '".trim($row1->kdsoutput,"\x0D\x0A")."' 
						and K.KDKMPNEN = '".trim($row1->kdkmpnen,"\x0D\x0A")."'
						and K.KDSKMPNEN = '$row1->kdskmpnen' 
					order by K.KDAKUN";
 $qry = $db->query($query2);
 // $qry = $db->query("select distinct KDAKUN, NMAKUN from rkakl_full order by KDAKUN");
 // echo "<option value=\"\" >--Pilih Kode Akun--</option>";
 while ($row = $db->fetch_object($qry)) {
    $akun[$row->KDAKUN] = $row->NMAKUN ;
 }
 echo json_encode($akun);

?>