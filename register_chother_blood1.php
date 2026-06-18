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
	

$sale_code = $_SESSION['code'];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	
	

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb__gluboold";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "OT";

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

$ref_id ="$so$nextId";
	
	
	
	
if ($_FILES['img_pro1']['size'] == 0) {
$img_pro1 = "";
}else if ($_FILES['img_pro1']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['img_pro1']['size'] != 0) {
$temp1 = explode(".", $_FILES["img_pro1"]["name"]);
$img_pro1 = "img_pro1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["img_pro1"]["tmp_name"], "img_pro/" . $img_pro1);
}	

	
	
if ($_FILES['img_pro2']['size'] == 0) {
$img_pro2 = "";
}else if ($_FILES['img_pro2']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['img_pro2']['size'] != 0) {
$temp2 = explode(".", $_FILES["img_pro2"]["name"]);
$img_pro2 = "img_pro2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["img_pro2"]["tmp_name"], "img_pro/" . $img_pro2);
}	
	
	
if ($_FILES['img_pro3']['size'] == 0) {
$img_pro3 = "";
}else if ($_FILES['img_pro3']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['img_pro3']['size'] != 0) {
$temp3 = explode(".", $_FILES["img_pro3"]["name"]);
$img_pro3 = "img_pro3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["img_pro3"]["tmp_name"], "img_pro/" . $img_pro3);
}	
	
	



$save="insert into tb__gluboold
(ref_id,register_date,customer_name,address,add_aumpher,province,postcode,customer_tel,type_product,sn_number,img_pro1,img_pro2,img_pro3,add_by,add_date,sale_code)
values
('".$ref_id."','".$register_date."','".$customer_name."','".$address."','".$add_aumpher."','".$province."','".$postcode."','".$customer_tel."','".$type_product."','".$sn_number."','".$img_pro1."','".$img_pro2."','".$img_pro3."','".$add_by."','".$add_date."','".$sale_code."')";

$qsave=mysqli_query($conn,$save);
	

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_blood_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


