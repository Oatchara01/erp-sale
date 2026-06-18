<?php

include"dbconnect.php";


$register_date = date('Y-m-d');
//$register_date = "2026-03-22";



//register_date ='".$register_date."' and select_type_doc!='3' and select_type_doc !='4'


$strSQL = "SELECT ref_id,doc_release_date , select_type_doc FROM so__main WHERE sale_channel='1' and register_date ='".$register_date."' and select_type_doc!='3' and select_type_doc !='4' AND email != '' AND tax_id != '' AND doc_no NOT LIKE '%E%' AND doc_no != '' AND cancel_ckk = '0' AND tax_id REGEXP '^[0-9]{13}$' AND tax_id !='0000000000000'";
$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");

while ($objResult = mysqli_fetch_array($objQuery)) {
    $ref_id = $objResult["ref_id"];
	$doc_release_date = $objResult["doc_release_date"];

	$bill_vat = '1';
	$send_supadm = '1';
	$status_vat  = "Approve";	



    if ($ref_id!='') {

if($objResult["select_type_doc"]=="1"){	

$select_type_doc ='3';	
	
$date = explode('-' , $doc_release_date );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_et_awl where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ET";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;

	
$doc_no = $so.$year1.$mont.$nextId;	
		
$save5="insert into tb_et_awl (doc_no,year_no,mount_no,run_no,iv_date,ref_so) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$doc_release_date."','".$ref_id."')";
$qsave5=mysqli_query($conn,$save5);	

	
	
}else if($objResult["select_type_doc"]=="2"){


$select_type_doc ='4';		
	
$date = explode('-' , $doc_release_date);
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_et_nbm where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ET";
$so1 = "-";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
	
	
	
$doc_no = $so.$year1.$so1.$mont.$nextId;

$save="insert into tb_et_nbm (doc_no,year_no,mount_no,run_no,iv_date,ref_so) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$doc_release_date."','".$ref_id."')";
$qsave=mysqli_query($conn,$save);

	
}


$sqlUpdate = "UPDATE so__main SET 
                      bill_vat = '$bill_vat',
                      send_supadm = '$send_supadm',
                      status_vat = '$status_vat',
                      doc_no = '$doc_no',
                      select_type_doc = '$select_type_doc'
                  WHERE ref_id = '$ref_id'";
    mysqli_query($conn, $sqlUpdate) or die(mysqli_error($conn));
       
    } else {
        echo "ไม่มีข้อมูล";
        
    }
			
  	
}





?>