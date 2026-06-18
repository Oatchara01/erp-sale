<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_company = $_POST["type_company"];	
$customer_name  = $_POST["customer_name"];
$name =  $_SESSION['name'];
$code =  $_SESSION['code'];	
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
$date_story = date('Y-m-d');
$time_story = date("H:i:s");
$contact_name = $_POST["contact_name"];
$address_name = $_POST["address_name"];
$description = $_POST["description"];
$tel_number = $_POST["tel_number"];
$sale_code = $_POST["sale_code"];
$receive_name = $_POST["receive_name"];
$time_plan = $_POST["time_plan"];
$date_plan = $_POST["date_plan"];
$type_eng = $_POST["type_eng"];
$employee = $_SESSION["emid"];
	
if($_POST["product_id1"]!=''){	
$product_code = $_POST["product_id1"];
}else{
$product_code = $_POST["product_id2"];	
}
	
if($_POST["sale_count1"]!=''){	
$count = $_POST["sale_count1"];
}else{
$count = $_POST["sale_count2"];	
}
	
if($_POST["sn_number1"]!=''){	
$sn_number = $_POST["sn_number1"];
}else{
$sn_number = $_POST["sn_number2"];	
}
	
if($_POST["sale_remark1"]!=''){	
$sale_remark = $_POST["sale_remark1"];	
}else{
$sale_remark = $_POST["sale_remark2"];		
}
	

	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_register_eng";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "EN";

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
				
$ref_id = "$so$nextId";
	
	
if ($_FILES['img_1']['size'] == 0) {
$newfilename1 = "";
/*}else if ($_FILES['img_1']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();*/
}  else if ($_FILES['img_1']['size'] != 0) {
$temp1 = explode(".", $_FILES["img_1"]["name"]);
$newfilename1 = "img_1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["img_1"]["tmp_name"], "regis_eng/" . $newfilename1);
}	
	
if ($_FILES['img_2']['size'] == 0) {
$newfilename2 = "";
/*}else if ($_FILES['img_2']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();*/
} else if ($_FILES['img_2']['size'] != 0) {
$temp2 = explode(".", $_FILES["img_2"]["name"]);
$newfilename2 = "img_2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["img_2"]["tmp_name"], "regis_eng/" . $newfilename2);
}	
	
if ($_FILES['img_3']['size'] == 0) {
$newfilename3 = "";
/*}else if ($_FILES['img_3']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();*/
} else if ($_FILES['img_3']['size'] != 0) {
$temp3 = explode(".", $_FILES["img_3"]["name"]);
$newfilename3 = "img_3" . "_" .$ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["img_3"]["tmp_name"], "regis_eng/" . $newfilename3);
}	
	
	
if ($_FILES['img_4']['size'] == 0) {
$newfilename4 = "";
/*}else if ($_FILES['img_4']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();*/
} else if ($_FILES['img_4']['size'] != 0) {
$temp4 = explode(".", $_FILES["img_4"]["name"]);
$newfilename4 = "img_4" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp4);
move_uploaded_file($_FILES["img_4"]["tmp_name"], "regis_eng/" . $newfilename4);
}	
	
	
if ($_FILES['img_5']['size'] == 0) {
$newfilename5 = "";
/*}else if ($_FILES['img_5']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();*/
} else if ($_FILES['img_5']['size'] != 0) {
$temp = explode(".", $_FILES["img_5"]["name"]);
$newfilename5 = "img_5" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp5);
move_uploaded_file($_FILES["img_5"]["tmp_name"], "regis_eng/" . $newfilename5);
}		
	
	


$save="insert into tb_register_eng
(ref_id,customer_name,add_by,add_date,date_story,time_story,contact_name,address_name,description,tel_number,sale_code,receive_name,time_plan,date_plan,type_eng,employee,img_1,img_2,img_3,img_4,img_5,type_company,product_code,count,sn_number,sale_remark,sale_open) values ('".$ref_id."','".$customer_name."','".$add_by."','".$add_date."','".$date_story."','".$time_story."','".$contact_name."','".$address_name."','".$description."','".$tel_number."','".$sale_code."','".$receive_name."','".$time_plan."','".$date_plan."','".$type_eng."','".$employee."','".$newfilename1."','".$newfilename2."','".$newfilename3."','".$newfilename4."','".$newfilename5."','".$type_company."','".$product_code."','".$count."','".$sn_number."','".$sale_remark."','".$code."')";

$qsave=mysqli_query($conn,$save);
	
$sql1 = "select * from tb_register_eng order by id desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
$id =$fetch1["id"];

 if($qsave){
   echo "<script language=\"JavaScript\">";
	echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_cuseng_edit.php?ref_id=$ref_id'";		 
	echo "</script>";
  } else{
   echo "Cannot";
  }
	}
?>