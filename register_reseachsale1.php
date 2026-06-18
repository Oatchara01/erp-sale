 
<?php
include('head.php'); 
 include "dbconnect.php";
 include "dbconnect_cs.php";
date_default_timezone_set("Asia/Bangkok");

$sale_neat = $_POST["sale_neat"];
$grade = $_POST["grade"];
$sale_data = $_POST["sale_data"];
$sale_3 = $_POST["sale_3"];
$sale_4 = $_POST["sale_4"];
$sale_5 = $_POST["sale_5"];
$product_corect = $_POST["product_corect"];
$product_link = $_POST["product_link"];
$product_good = $_POST["product_good"];
$running_id = $_POST["running_id"];
$suggest_1  = $_POST["suggest_1"];
$ref_id = $_POST["ref_id"];
$type_login = $_SESSION['type_login'];
$suggest  = $_POST["suggest"];
$customer_name = $_POST["customer_name"];
$date_research = date('Y-m-d');
$add_date = date('Y-m-d H:i:s');
$iv_number = $_POST["iv_number"];	
$product_name  = $_POST["product_name"];	
$sale_code	= $_POST["sale_code"];	
$customer_tel= $_POST["customer_tel"];	
$date_sale = $_POST["date_sale"];	
$team_send = $_POST["team_send"];	
$no_research = $_POST["no_research"];
$iv_date =  $_POST["iv_date"];
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
 $objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());
	
	
$strSQL8 =   "Update  hos__so set close_reseach='1'  where ref_id='".$ref_id."' ";
$objQuery8 = mysqli_query($conn,$strSQL8) or die(mysqli_error());

}else{
	
$strSQL89 =   "insert into  tb_research (running_id,product_good,product_link,suggest_1,product_corect,add_by1,sale_neat,sale_data,sale_3,sale_4,suggest,customer_name,date_research,iv_number,product_name,sale_code,customer_tel,add_date1,red_id,date_sale,type_customer,team_send,grade,no_research,iv_date,sale_5) 
values ('".$running_id."','".$product_good."','".$product_link."','".$suggest_1."','".$product_corect."','".$add_by."','".$sale_neat."','".$sale_data."','".$sale_3."','".$sale_4."','".$suggest."','".$customer_name."','".$date_research."','".$iv_number."','".$product_name."','".$sale_code."','".$customer_tel."','".$add_date."','".$ref_id."','".$date_sale."','".$type_customer."','".$team_send."','".$grade."','".$no_research."','".$iv_date."','".$sale_5."') ";
	
 $objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());	
	
$strSQL8 =   "Update  hos__so set close_reseach='1'  where ref_id='".$ref_id."' ";
$objQuery8 = mysqli_query($conn,$strSQL8) or die(mysqli_error());	
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

