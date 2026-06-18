<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$register_date = $_POST["register_date"];	
$customer_name = $_POST["customer_name"];	
$address = $_POST["address"];	
$add_aumpher = $_POST["add_aumpher"];	
$province = $_POST["province"];	
$postcode = $_POST["postcode"];	
$customer_tel = $_POST["customer_tel"];	
$sn_number = $_POST["sn_number"];	
$type_product = $_POST["type_product"];	
$ref_id = $_POST["ref_id"];	
	

$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	
	
	
	
	
	
if ($_FILES['img_pro1']['size'] != 0) {
$temp1 = explode(".", $_FILES["img_pro1"]["name"]);
$img_pro1 = "img_pro1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["img_pro1"]["tmp_name"], "img_pro/" . $img_pro1);
}else{
$img_pro1 = $_POST["img_pro1"];
}	

	
if ($_FILES['img_pro2']['size'] != 0) {
$temp2 = explode(".", $_FILES["img_pro2"]["name"]);
$img_pro2 = "img_pro2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["img_pro2"]["tmp_name"], "img_pro/" . $img_pro2);
}else{
$img_pro2 = $_POST["img_pro2"];
}	
	
	
	
if ($_FILES['img_pro3']['size'] != 0) {
$temp3 = explode(".", $_FILES["img_pro3"]["name"]);
$img_pro3 = "img_pro3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["img_pro3"]["tmp_name"], "img_pro/" . $img_pro3);
}else{
$img_pro3 = $_POST["img_pro3"];
}	
	
	



$save="UPDATE tb__gluboold SET
customer_name='".$customer_name."',address='".$address."',add_aumpher='".$add_aumpher."',province='".$province."',postcode='".$postcode."',customer_tel='".$customer_tel."',type_product='".$type_product."',sn_number='".$sn_number."',img_pro1='".$img_pro1."',img_pro2='".$img_pro2."',img_pro3='".$img_pro3."',register_date='".$register_date."'  where ref_id ='".$ref_id."'";

$qsave=mysqli_query($conn,$save);
	

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_blood_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


