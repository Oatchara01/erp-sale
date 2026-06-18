<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = $_POST["ref_id"];
$customer_name  = $_POST["customer_name"];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
$contact_name = $_POST["contact_name"];
$address_name = $_POST["address_name"];
$description = $_POST["description"];
$tel_number = $_POST["tel_number"];
$sale_code = $_POST["sale_code"];
$receive_name = $_POST["receive_name"];
$time_plan = $_POST["time_plan"];
$date_plan = $_POST["date_plan"];
$type_eng = $_POST["type_eng"];
$type_company = $_POST["type_company"];		
	

$product_code = $_POST["product_id1"];
$count = $_POST["sale_count1"];
$sn_number = $_POST["sn_number1"];
$sale_remark = $_POST["sale_remark1"];	

		
	
	
if ($_FILES['img_1']['size'] == 0) {
$newfilename1 = $_POST["img_11"];
}else if ($_FILES['img_1']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
} else if ($_FILES['img_1']['size'] != 0) {
$temp1 = explode(".", $_FILES["img_1"]["name"]);
$newfilename1 = "img_1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["img_1"]["tmp_name"], "regis_eng/" . $newfilename1);
}	
	
if ($_FILES['img_2']['size'] == 0) {
$newfilename2 = $_POST["img_22"];
}else if ($_FILES['img_2']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
} else if ($_FILES['img_2']['size'] != 0) {
$temp2 = explode(".", $_FILES["img_2"]["name"]);
$newfilename2 = "img_2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["img_2"]["tmp_name"], "regis_eng/" . $newfilename2);
}	
	
if ($_FILES['img_3']['size'] == 0) {
$newfilename3 = $_POST["img_33"];
}else if ($_FILES['img_3']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
} else if ($_FILES['img_3']['size'] != 0) {
$temp3 = explode(".", $_FILES["img_3"]["name"]);
$newfilename3 = "img_3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["img_3"]["tmp_name"], "regis_eng/" . $newfilename3);
}	
	
	
if ($_FILES['img_4']['size'] == 0) {
$newfilename4 = $_POST["img_44"];
}else if ($_FILES['img_4']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
} else if ($_FILES['img_4']['size'] != 0) {
$temp4 = explode(".", $_FILES["img_4"]["name"]);
$newfilename4 = "img_4" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp4);
move_uploaded_file($_FILES["img_4"]["tmp_name"], "regis_eng/" . $newfilename4);
}	
	
	
if ($_FILES['img_5']['size'] == 0) {
$newfilename5 = $_POST["img_55"];
}else if ($_FILES['img_5']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
} else if ($_FILES['img_5']['size'] != 0) {
$temp = explode(".", $_FILES["img_5"]["name"]);
$newfilename5 = "img_5" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp5);
move_uploaded_file($_FILES["img_5"]["tmp_name"], "regis_eng/" . $newfilename5);
}		
		
	



$save="UPDATE tb_register_eng SET
customer_name='".$customer_name."',contact_name='".$contact_name."',address_name='".$address_name."',description='".$description."',tel_number='".$tel_number."',sale_code='".$sale_code."',receive_name='".$receive_name."',remark_adm='".$remark_adm."',time_plan='".$time_plan."',date_plan='".$date_plan."',type_eng='".$type_eng."',img_1='".$newfilename1."',img_2='".$newfilename2."',img_3='".$newfilename3."',img_4='".$newfilename4."',img_5='".$newfilename5."',type_company='".$type_company."',product_code='".$product_code."',count='".$count."',sn_number='".$sn_number."',sale_remark='".$sale_remark."' where ref_id = '".$ref_id."'";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_cuseng_edit.php?ref_id=$ref_id'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>