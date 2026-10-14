 
<?php
include('head.php'); 
 include "dbconnect.php";
 include "dbconnect_cs.php";
date_default_timezone_set("Asia/Bangkok");

// tb_research (CS DB) มีคอลัมน์ NOT NULL ไม่มีค่า default หลายตัว ที่ INSERT ด้านล่างไม่ได้ส่งค่าไป
mysqli_query($com1, "SET SESSION sql_mode = ''");

// คะแนน (คอลัมน์ int) — ฟอร์มไม่ได้ส่งมา (เช่น sale_4, sale_5) ให้เป็น 0
function research_int($key){
  return (int)($_POST[$key] ?? 0);
}
// ข้อความ — escape ก่อนต่อ SQL
function research_str($key){
  global $com1;
  return mysqli_real_escape_string($com1, trim((string)($_POST[$key] ?? '')));
}
// วันที่ — ค่าว่างหรือรูปแบบผิด ให้เป็น 0000-00-00
function research_date($key){
  $v = trim((string)($_POST[$key] ?? ''));
  return preg_match('/^\d{4}-\d{2}-\d{2}$/', $v) ? $v : '0000-00-00';
}

$sale_neat = research_int("sale_neat");
$grade = research_str("grade");
$sale_data = research_int("sale_data");
$sale_3 = research_int("sale_3");
$sale_4 = research_int("sale_4");
$sale_5 = research_int("sale_5");
$product_corect = research_int("product_corect");
$product_link = research_int("product_link");
$product_good = research_int("product_good");
$running_id = research_str("running_id");
$suggest_1  = research_str("suggest_1");
$ref_id = research_str("ref_id");
$type_login = $_SESSION['type_login'] ?? '';
$add_by = mysqli_real_escape_string($com1, trim(($_SESSION['name'] ?? '').' '.($_SESSION['surname'] ?? '')));
$suggest  = research_str("suggest");
$customer_name = research_str("customer_name");
$date_research = date('Y-m-d');
$add_date = date('Y-m-d H:i:s');
$iv_number = research_str("iv_number");
$product_name  = research_str("product_name");
$sale_code	= research_str("sale_code");
$customer_tel= research_str("customer_tel");
$date_sale = research_date("date_sale");
$team_send = research_str("team_send");
$no_research = research_int("no_research"); // checkbox ไม่ติ๊ก = ไม่ถูกส่งมา = 0
$iv_date = research_date("iv_date");
if($sale_code=='MM1' or $sale_code=='S31'){
$type_customer ='ร้านขายยา';	
}else{
$type_customer ='โรงพยาบาล';	
}
	
$strSQL21 = "SELECT * FROM tb_research WHERE running_id = '".$running_id."' ";

$objQuery21 = mysqli_query($com1,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){

$strSQL89 =   "Update  tb_research set product_good='".$product_good."',product_link='".$product_link."',suggest_1='".$suggest_1."',product_corect='".$product_corect."',add_by='".$add_by."',sale_neat='".$sale_neat."',sale_data='".$sale_data."',sale_3='".$sale_3."',sale_4='".$sale_4."',sale_5='".$sale_5."',suggest='".$suggest."',customer_name='".$customer_name."',grade='".$grade."',no_research='".$no_research."',iv_date='".$iv_date."',red_id ='".$ref_id."',sale_code='".$sale_code."',type_customer='".$type_customer."'  where running_id='".$running_id."' ";
 $objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error($com1));
	
	
$strSQL8 =   "Update  hos__so set close_reseach='1'  where ref_id='".$ref_id."' ";
$objQuery8 = mysqli_query($conn,$strSQL8) or die(mysqli_error($conn));

}else{
	
$strSQL89 =   "insert into  tb_research (running_id,product_good,product_link,suggest_1,product_corect,add_by1,sale_neat,sale_data,sale_3,sale_4,suggest,customer_name,date_research,iv_number,product_name,sale_code,customer_tel,add_date1,red_id,date_sale,type_customer,team_send,grade,no_research,iv_date,sale_5) 
values ('".$running_id."','".$product_good."','".$product_link."','".$suggest_1."','".$product_corect."','".$add_by."','".$sale_neat."','".$sale_data."','".$sale_3."','".$sale_4."','".$suggest."','".$customer_name."','".$date_research."','".$iv_number."','".$product_name."','".$sale_code."','".$customer_tel."','".$add_date."','".$ref_id."','".$date_sale."','".$type_customer."','".$team_send."','".$grade."','".$no_research."','".$iv_date."','".$sale_5."') ";
	
 $objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error($com1));	
	
$strSQL8 =   "Update  hos__so set close_reseach='1'  where ref_id='".$ref_id."' ";
$objQuery8 = mysqli_query($conn,$strSQL8) or die(mysqli_error($conn));	
}
 	
if($objQuery89){
 if($type_login=='Sale')
  {
	  echo "<script language=\"JavaScript\">";
	echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_salechangeall.php';";
	echo "</script>";
  
  }else if($type_login=='Admin'){
	 echo "<script language=\"JavaScript\">";
	echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_adminhos.php';";
	echo "</script>";
	}else{
	 echo "<script language=\"JavaScript\">";
	echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_supresearch.php';";
	echo "</script>";
	}

  } else {
   echo "Cannot";
  }

?>

