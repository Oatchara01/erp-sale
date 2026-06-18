<?php
include("dbconnect.php");
include("dbconnect_cs.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {
	
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');	
$del_date  = $_POST["del_date"];
$ref_no = $_POST["ref_no"];
$ref_no1 = $_POST["ref_no1"];
$iv_no = $_POST["iv_no"];
$pro_name = $_POST["pro_name"];
$type_del = $_POST["type_del"];
$ker_bath = $_POST["ker_bath"];
$company = $_POST["company"];
$id  = $_POST["id"];
$send_cs = $_POST["send_cs"];

if($company=='1'){
$type_company ='ออลล์เวล ไลฟ์ บจก.';
}else if($company=='2'){
$type_company ='โนเบิล เมด บจก.';	
}
	
$product_name ="$ref_no $ref_no1 $pro_name";		
	
$save="Update  tb_deloth set
del_date='".$del_date."',ref_no='".$ref_no."',ref_no1='".$ref_no1."',iv_no='".$iv_no."',pro_name='".$pro_name."',type_del='".$type_del."',ker_bath='".$ker_bath."',company='".$company."' where id='".$id."'";

$qsave=mysqli_query($conn,$save);
	
if($send_cs=='1'){
	
$save="Update  tb_deloth set
del_date='".$del_date."',ref_no='".$ref_no."',ref_no1='".$ref_no1."',iv_no='".$iv_no."',pro_name='".$pro_name."',type_del='".$type_del."',ker_bath='".$ker_bath."',company='".$company."',send_cs='2' where id='".$id."'";

$qsave=mysqli_query($conn,$save);	
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(running) AS MAXID FROM tb_register_data";
$qry = mysqli_query($com1,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId1 = substr($rs['MAXID'],0,-4);

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
	
$strSQL =  "insert into tb_register_data (running,start_date,status,department,type_customer,type_company,address_name,product_name,product_sn,employee_name,add_by,add_date,department_show,province_name,add_code) 

values('".$nextId."','".$del_date."','ส่ง','อื่นๆ','ลูกค้าทั่วไป','".$type_company."','".$type_del."','".$product_name."','".$iv_no."','".$add_by."','".$add_by."','$add_date','ฝ่ายสนับสนุนการขาย ธุรการ','กรุงเทพมหานคร','".$em_code."')";

 $objQuery = mysqli_query($com1,$strSQL) or die(mysqli_error());
		
	
}else{
	
$save="Update  tb_deloth set
del_date='".$del_date."',ref_no='".$ref_no."',ref_no1='".$ref_no1."',iv_no='".$iv_no."',pro_name='".$pro_name."',type_del='".$type_del."',ker_bath='".$ker_bath."',company='".$company."',send_cs='0' where id='".$id."'";

$qsave=mysqli_query($conn,$save);		
	
}
	


 if($qsave){
   echo "<script language=\"JavaScript\">";
	 
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_deloth.php'";		 
	
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>