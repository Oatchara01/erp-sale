<?php
include "dbconnect.php";
include "head.php";


  $ref_id = $_GET['ref_id'];
  $rental_name = $_GET["rental_name"];
  $type_doc = $_GET["type_doc"];
  $iv_no = $_GET["iv_no"];
  $sale_code = $_SESSION['code'];
  $name =  $_SESSION['name'];
  $surname =	$_SESSION['surname'];
  $add_by = "$name $surname";
  $add_date = date('Y-m-d H:i:s');
  $doc_date = date('Y-m-d');
  $start_promis = $_GET["start_promis"];

$sql1 = "SELECT * FROM hos__rental where ref_id='".$ref_id."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

$promis_no1 = $rs1["promis_no"];



$date = explode('-' , $doc_date );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);


if($iv_no !=''){
$doc_no = $_GET["iv_no"];

}else{

	if($type_doc =='3'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_doc_rental where head_no='JN' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "JN";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_doc_rental (head_no,doc_no,year_no,month_no,run_iv,ref_id,doc_date) values ('JN','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id_br."','".$doc_date."')";
$qsave5=mysqli_query($conn,$save5);
		
	}else if($type_doc =='4'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_doc_rental where head_no='JN/' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "JN/";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_doc_rental (head_no,doc_no,year_no,month_no,run_iv,ref_id,doc_date) values ('JN/','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id_br."','".$doc_date."')";
$qsave5=mysqli_query($conn,$save5);


	}

}

$promis_date = $start_promis;
if($promis_no1!=''){
$promis_no = $promis_no1;
}else{
	
$date = explode('-' , $start_promis );	
$year = $date[0];
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_promisno where month_no ='".$mont."' and year_no = '".$year1."'";
			
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "ธส.";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -3);
$nextId = $maxId2;


$promis_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_promisno (promis_n,year_no,month_no,run_no,date_save,ref_id) values ('".$promis_no."','".$year1."','".$mont."','".$nextId."','".$date_save."','".$ref_id."')";
$qsave5=mysqli_query($conn,$save5);	
	
	
}



 $save="Update  hos__rental set send_admin ='1',status_doc='Approve',iv_no='".$doc_no."',iv_date='".$doc_date."',send_stock='1',send_sup='1',sup_name='".$add_by."',sup_date='".$add_date."',promis_date='".$promis_date."',promis_no='".$promis_no."'  where ref_id = '".$ref_id."' ";
 $qsave=mysqli_query($conn,$save);



$strSQL1 = "SELECT * FROM  (hos__subrental LEFT JOIN tb_product ON hos__subrental.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
	
	
$strSQL2 = "SELECT product_code,count  FROM hos__subrental where ref_idd = '".$ref_id."' and product_code ='".$objResult1["product_code"]."' and ckk_pro='0'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
$objResult2 = mysqli_fetch_array($objQuery2);	

if($Num_Rows2 > 0){
	
$strSQL3 = "SELECT * FROM  tb_product_checklist  WHERE ref_id = '".$ref_id."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	
$strSQLreb = "SELECT * FROM tb_product_rental where product_id ='".$objResult1["product_code"]."'";
$objQueryreb = mysqli_query($conn,$strSQLreb) or die ("Error Query [".$strSQL2."]");
$Num_Rowsreb = mysqli_num_rows($objQueryreb);
$objResultreb = mysqli_fetch_array($objQueryreb);	
	

if($objResult3["ref_id"]!=''){ }else{
	
	
$save99="insert into tb_product_rentalref
(ref_idrt,product_id,sn_number,list_des1,list_des2,list_des3,list_des4,list_des5,list_des6,list_des7,list_des8,list_des9,list_des11,list_des12,list_des13,list_des14,list_des15,list_des16)
values
('".$ref_id."','".$objResult1["product_code"]."','".$objResultreb["sn_number"]."','".$objResultreb["list_des1"]."','".$objResultreb["list_des2"]."','".$objResultreb["list_des3"]."','".$objResultreb["list_des4"]."','".$objResultreb["list_des5"]."','".$objResultreb["list_des6"]."','".$objResultreb["list_des7"]."','".$objResultreb["list_des8"]."','".$objResultreb["list_des9"]."','".$objResultreb["list_des10"]."','".$objResultreb["list_des11"]."','".$objResultreb["list_des12"]."','".$objResultreb["list_des13"]."','".$objResultreb["list_des14"]."','".$objResultreb["list_des15"]."','".$objResultreb["list_des16"]."')";
$qsave99=mysqli_query($conn,$save99);
	
	
	

$product_id = $objResult1["product_code"]; 
$count = str_replace('.00','',$objResult2["count"]);
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";

$strDate = date('Y-m-d');

$strYear = date("Y",strtotime($strDate))+543;
$strYear1 =substr( $strYear , 2 , 2 );

//for ($x = 0; $x <= $count; $x+=$count) {
	

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_pc) AS MAXID FROM tb_product_checklist where head_pc='DO'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}

$so = "DO";
$ref_pc ="$so$nextId";



$save99="insert into tb_product_checklist
(ref_pc,doc_no,year_no,ref_id,product_id,add_date,add_by,date_create,head_pc,sn)
values
('".$ref_pc."','".$ref_pc."','".$strYear1."','".$ref_id."','".$product_id."','".$add_date."','".$add_by."','".$strDate."','".$so."','".$objResultreb["sn_number"]."')";
$qsave99=mysqli_query($conn,$save99);


$save1="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','ST','1')";
$qsave1=mysqli_query($conn,$save1);

$save2="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','EN','1')";
$qsave2=mysqli_query($conn,$save2);

$save3="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','CS','1')";
$qsave3=mysqli_query($conn,$save3);

$save4="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','CS','2')";
$qsave4=mysqli_query($conn,$save4);

$save5="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','EN','2')";
$qsave5=mysqli_query($conn,$save5);

$save6="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','ST','2')";
$qsave6=mysqli_query($conn,$save6);	
	
	
//}	
	
$strSQL = "Update   hos__subrental set ckk_pro='1'  Where ref_idd = '".$ref_id."'";
$objQuery = mysqli_query($conn,$strSQL);
	
	
}
}
}









if($qsave){
 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_apprental.php';";
echo "</script>";

  }else{
   echo "Cannot";
  }
  
	

	
?>
