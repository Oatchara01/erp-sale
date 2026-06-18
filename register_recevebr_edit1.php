<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$id_br = $_POST["id_br"];
$company = $_POST["company"];
$br_date = $_POST["br_date"];
$iv_no = $_POST["iv_no"];
$customer_name = $_POST["customer_name"];
$remark = $_POST["remark"];

$date_trace1 = $_POST["date_trace1"];
$date_trace2 = $_POST["date_trace2"];
$sup_date = $_POST["sup_date"];
$car_date = $_POST["car_date"];
$doc_green = $_POST["doc_green"];
//echo $doc_green; 
$doc_greenckk = $_POST["doc_greenckk"];
$doc_white = $_POST["doc_white"];
$doc_purple = $_POST["doc_purple"];
$doc_check = $_POST["doc_check"];
$cancel = $_POST["cancel"];
$cancel_des = $_POST["cancel_des"];
$doc_2 = $_POST["doc_2"];
	
$trace_des1 = $_POST["trace_des1"];
$trace_des2 = $_POST["trace_des2"];
$sup_des = $_POST["sup_des"];
$car_des = $_POST["car_des"];
$complete_ckk = $_POST["complete_ckk"];
$complete_des = $_POST["complete_des"];

$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$em_id =  $_SESSION["emid"];
	
if($doc_purple =='1'){
$close_doc ='1';	
}else if($doc_white=='1'){
$close_doc ='1';	
}else if($complete_ckk=='1'){
$close_doc ='1';	
}else{
$close_doc ='0';	
}
	
	
	
if($complete_ckk=='1' and $complete_des==''){
	
 echo "<script language=\"JavaScript\">";
echo "alert('กรูณาใส่เหตุผลในการ Complete เอกสารด้วยค่ะ');window.location='register_recevebr_edit.php?id_br=$id_br'";
echo "</script>";	
exit();	
}
	
	

$save="Update tb_register_br SET
company='".$company."',br_date='".$br_date."',iv_no='".$iv_no."',customer_name='".$customer_name."',remark='".$remark."',date_trace1='".$date_trace1."',date_trace2 ='".$date_trace2."',sup_date='".$sup_date."',car_date='".$car_date."',doc_green='".$doc_green."',doc_white='".$doc_white."',doc_purple = '".$doc_purple."',doc_check ='".$doc_check."',cancel='".$cancel."',cancel_des='".$cancel_des."',doc_2 = '".$doc_2."',doc_greenckk='".$doc_greenckk."',remark='".$remark."',car_des='".$car_des."',sup_des='".$sup_des."',trace_des2='".$trace_des2."',trace_des1='".$trace_des1."',complete_ckk='".$complete_ckk."',complete_des='".$complete_des."',close_doc='".$close_doc."'  where id_br = '".$id_br."'";
$qsave=mysqli_query($conn,$save);

if($doc_green=='1'){
$strSQL = "UPDATE tb_register_br SET ";
	$strSQL .=" doc_send = '".$em_id."'";
	$strSQL .=", date_send = '$add_date'";
	$strSQL .=", doc_send1 = '$name'";
	$strSQL .="WHERE id_br = '".$id_br."'";
	
 $objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
	
}
	
	if($doc_white=='1'){
	$strSQL = "UPDATE tb_register_br SET ";
	$strSQL .=" doc_adm  = '".$em_id."'";
	$strSQL .=", date_adm = '$add_date'";
	$strSQL .=", doc_adm1 = '$name'";
	$strSQL .="WHERE id_br = '".$id_br."'";
	
 $objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
	
	}
	
	

 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_recevebr_edit.php?id_br=$id_br'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>