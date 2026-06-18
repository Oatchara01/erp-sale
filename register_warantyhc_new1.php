<?php
include("dbconnect.php");
date_default_timezone_set("Asia/Bangkok");

if ($_POST["submit"] = "submit") {
$group_name = $_POST["product_name"];
$product_name = $_POST["ddlProductBrand"];
$serial_num = $_POST["serial_num"];
$cus_name = $_POST["cus_name"];
$cus_lastname = $_POST["cus_lastname"];
$customer_name = "$cus_name $cus_lastname";	
$cus_addtum = $_POST["cus_addtum"];
$cus_ampher = $_POST["cus_ampher"];
$cus_add = $_POST["cus_address"];
$cus_address = "$cus_add $cus_addtum $cus_ampher";	
$date_install = $_POST["date_install"];
$cus_province = $_POST["cus_province"];
$cus_country = $_POST["cus_country"];
$cus_postcode = $_POST["cus_postcode"];
$tel_cus = $_POST["tel_cus"];
$email = $_POST["email"];
$accept = $_POST["accept"];
$add_date = date('Y-m-d H:i:s');
$today = date('Y-m-d');
	
$strSQL22 = "SELECT product_name,serial_num,cus_name FROM tb_waranty WHERE serial_num = '".$serial_num."' ";
$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$objResult22 = mysqli_fetch_array($objQuery22);	
	
	

$sql2 = "SELECT buy_status FROM product__instock where product_sn = '".$serial_num."' and buy_status='1'";
$qry2 = mysqli_query($new,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_assoc($qry2);

if($rs2["buy_status"]==''){

echo "<script language=\"JavaScript\">";
echo "alert('คุณกรอก ข้อมูล Serial number ไม่ถูกต้อง');window.location='register_waranty3.php?sn=$serial_num&group=$group_name&product=$product_name';";
echo "</script>";
exit();

}elseif($objResult22["serial_num"]!=''){	

echo "<script language=\"JavaScript\">";
echo "alert('ไม่สามารถลงทะเบียนรับประกันได้');window.location='register_waranty3.php?sn=$serial_num&group=$group_name&product=$product_name';";
echo "</script>";
exit();	
	
}else{
	


if ($_FILES['img_upload']['size'] == 0) {
$newfilename = "";

} else if($_FILES['img_upload']['size'] != 0) {
$temp = explode(".", $_FILES["img_upload"]["name"]);
$newfilename = "img" . "_" . $serial_num . "_" . round(microtime(true)) . '.' . end($temp);
move_uploaded_file($_FILES["img_upload"]["tmp_name"], "up_waranty/" . $newfilename);
}
	
	
$sql = "SELECT waranty FROM tb_prowaranty where product_name ='".$product_name."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
$waranty = $rs["waranty"];
$yy = "year";
$waranty1 = "$waranty$yy";
$register_date = $date_install;	
$datedate = date ("Y-m-d", strtotime($warranty1, strtotime($register_date)));	
$product_sn1 = $serial_num;	
	

$save="insert into tb_waranty
(group_name,product_name,serial_num,cus_name,cus_address,date_install,cus_province,cus_country,cus_postcode,tel_cus,email,add_date,accept,waranty,date_save,agree_ckk,cus_lastname,customer_name,cus_add,cus_addtum,cus_ampher,img_upload)
values
('".$group_name."','".$product_name."','".$serial_num."','".$cus_name."','".$cus_address."','".$date_install."','".$cus_province."','".$cus_country."','".$cus_postcode."','".$tel_cus."','".$email."','".$add_date."','".$accept."','".$waranty1."','".$today."','1','".$cus_lastname."','".$customer_name."','".$cus_add."','".$cus_addtum."','".$cus_ampher."','".$newfilename."')";

$qsave=mysqli_query($conn,$save);

	
	
$sql3="select * from tb_waranty where serial_num='".$product_sn1."' ";
$result = mysqli_query($conn,$sql3) or die(mysqli_error());
$objResult = mysqli_fetch_array($result);

	
$sql4="select product_sn from tb_products_in_stock where product_sn='".$product_sn1."' ";
$result4 = mysqli_query($service,$sql4) or die(mysqli_error());
$num4=mysqli_num_rows($result4); 
	
$sql41="select product_sn from tb_products_in_stock where product_sn='".$product_sn1."' ";
$result41 = mysqli_query($servicenb,$sql41) or die(mysqli_error());
$num41=mysqli_num_rows($result41); 
	
	
if($num4 > 0){	
	
	
$sql3="select install_cus_name from tb_installation_data where product_sn='".$product_sn1."' ";
$result = mysqli_query($service,$sql3) or die(mysqli_error());
$num=mysqli_num_rows($result);
$objResult3 = mysqli_fetch_array($result);
	
if($num > 0 and $objResult3["install_cus_name"] !='') {
	
 $MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'";
	
$strSQL9 = "UPDATE tb_installation_data SET warranty='".$warranty."'  where product_sn='".$product_sn1."'";
$objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());		
	
$strSQL78 = "insert into tb_snproprem (sn,des,add_by,add_date) values ('".$product_sn1."','".$MSG."','".$add_by."','".$add_date."')";
$objQuery78 = mysqli_query($conn,$strSQL78);	
	
}else if($num > 0 and $objResult3["install_cus_name"] =='') {
$MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ<br>";
$strSQL78 = "insert into tb_snproprem (sn,des,add_by,add_date) values ('".$product_sn1."','".$MSG."','".$add_by."','".$add_date."')";
$objQuery78 = mysqli_query($conn,$strSQL78);	
	
$strSQL9 = "UPDATE tb_installation_data SET install_cus_name ='".$customer_name."',install_cus_address='".$address."',install_cus_tel='".$tel."',install_date='".$register_date."',warranty_phase='".$warranty1."',out_insurance_date='".$datedate."',add_date_search='".$date_edit."',warranty='".$warranty."',more_warranty='".$more_warranty."'  where product_sn='".$product_sn1."'";
$objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());

		}elseif($num == '0'){
 $strSQL9 = "INSERT INTO tb_installation_data (install_cus_id,install_cus_name,install_cus_address,install_cus_tel,product_sn,buy_date,install_date,warranty_phase,out_insurance_date,add_by,add_date,add_date_search,warranty,cus_id,more_warranty) VALUES ('".$product_sn1."','".$customer_name."','".$address."','".$tel."','".$product_sn1."','".$register_date."','".$register_date."','".$warranty1."','".$datedate."','".$add_by."','".$add_date."','".$date_edit."','".$warranty."','22522','".$more_warranty."')";
 $objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());
}	
	
$sql1_up="update tb_products_in_stock set buy_status='1' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($service,$sql1_up)or die(mysqli_error());		
	
$sql23="select cus_name from tb_waranty_cus where sn_num ='".$product_sn1."' ";
$result23 = mysqli_query($service,$sql23) or die(mysqli_error());
$num23=mysqli_num_rows($result23);
$objResult23 = mysqli_fetch_array($result23);	

if($num23 =='0'){	
	
$strSQL19 = "INSERT INTO tb_waranty_cus (sn_num,date_save,cus_name,cus_add,cus_addtum,cus_ampher,cus_province,cus_postcode,cus_tel,email,add_by,add_date) VALUES ('".$product_sn1."','".$objResult["date_save"]."','".$objResult["customer_name"]."','".$objResult["cus_add"]."','".$objResult["cus_addtum"]."','".$objResult["cus_ampher"]."','".$objResult["cus_province"]."','".$objResult["cus_postcode"]."','".$objResult["tel_cus"]."','".$objResult["email"]."','".$add_by."','".$add_date."')";
 $objQuery19 = mysqli_query($service,$strSQL19)or die(mysqli_error());	
	
$sql1_up="update tb_installation_data set warranty='1' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($service,$sql1_up)or die(mysqli_error());		
	
	
}else if($num23=='1' and $objResult23["cus_name"]==''){	
	
$strSQL19 = "UPDATE tb_waranty_cus SET date_save='".$objResult["date_save"]."',cus_name='".$objResult["customer_name"]."',cus_add='".$objResult["cus_add"]."',cus_addtum='".$objResult["cus_addtum"]."',cus_ampher='".$objResult["cus_ampher"]."',cus_province='".$objResult["cus_province"]."',cus_postcode='".$objResult["cus_postcode"]."',cus_tel='".$objResult["tel_cus"]."',email='".$objResult["email"]."',add_by='".$add_by."',add_date='".$add_date."' where sn_num='".$product_sn1."'";
$objQuery19 = mysqli_query($service,$strSQL19)or die(mysqli_error());			

$sql1_up="update tb_installation_data set warranty='1' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($service,$sql1_up)or die(mysqli_error());		
	
}else if($num23 > 0){

$MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ มีการลงทะเบียนรับประกันแล้วค่ะในชื่อของ คุณ '".$objResult23["customer_name"]."'";	
	
$strSQL78 = "insert into tb_snproprem (sn,des,add_by,add_date) values ('".$product_sn1."','".$MSG."','".$add_by."','".$add_date."')";
$objQuery78 = mysqli_query($conn,$strSQL78);	
	
}	
	
}else if($num41 > 0){

$sql3="select install_cus_name from tb_installation_data where product_sn='".$product_sn1."' ";
$result = mysqli_query($servicenb,$sql3) or die(mysqli_error());
$num=mysqli_num_rows($result);
$objResult3 = mysqli_fetch_array($result);
	
if($num > 0 and $objResult3["install_cus_name"] !='') {
	
 $MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'";
	
$strSQL9 = "UPDATE tb_installation_data SET warranty='".$warranty."'  where product_sn='".$product_sn1."'";
$objQuery9 = mysqli_query($servicenb,$strSQL9)or die(mysqli_error());		
	
$strSQL78 = "insert into tb_snproprem (sn,des,add_by,add_date) values ('".$product_sn1."','".$MSG."','".$add_by."','".$add_date."')";
$objQuery78 = mysqli_query($conn,$strSQL78);	
	
}else if($num > 0 and $objResult3["install_cus_name"] =='') {
$MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ<br>";
$strSQL78 = "insert into tb_snproprem (sn,des,add_by,add_date) values ('".$product_sn1."','".$MSG."','".$add_by."','".$add_date."')";
$objQuery78 = mysqli_query($conn,$strSQL78);	
	
$strSQL9 = "UPDATE tb_installation_data SET install_cus_name ='".$customer_name."',install_cus_address='".$address."',install_cus_tel='".$tel."',install_date='".$register_date."',warranty_phase='".$warranty1."',out_insurance_date='".$datedate."',add_date_search='".$date_edit."',warranty='".$warranty."',more_warranty='".$more_warranty."'  where product_sn='".$product_sn1."'";
$objQuery9 = mysqli_query($servicenb,$strSQL9)or die(mysqli_error());

}elseif($num == '0'){
	
 $strSQL9 = "INSERT INTO tb_installation_data (install_cus_id,install_cus_name,install_cus_address,install_cus_tel,product_sn,buy_date,install_date,warranty_phase,out_insurance_date,add_by,add_date,add_date_search,warranty,cus_id,more_warranty) VALUES ('".$product_sn1."','".$customer_name."','".$address."','".$tel."','".$product_sn1."','".$register_date."','".$register_date."','".$warranty1."','".$datedate."','".$add_by."','".$add_date."','".$date_edit."','".$warranty."','22522','".$more_warranty."')";
 $objQuery9 = mysqli_query($servicenb,$strSQL9)or die(mysqli_error());
	
}	
	
$sql1_up="update tb_products_in_stock set buy_status='1' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($servicenb,$sql1_up)or die(mysqli_error());		
	
$sql23="select cus_name from tb_waranty_cus where sn_num ='".$product_sn1."' ";
$result23 = mysqli_query($servicenb,$sql23) or die(mysqli_error());
$num23=mysqli_num_rows($result23);
$objResult23 = mysqli_fetch_array($result23);	

if($num23 =='0'){	
	
$strSQL19 = "INSERT INTO tb_waranty_cus (sn_num,date_save,cus_name,cus_add,cus_addtum,cus_ampher,cus_province,cus_postcode,cus_tel,email,add_by,add_date) VALUES ('".$product_sn1."','".$objResult["date_save"]."','".$objResult["customer_name"]."','".$objResult["cus_add"]."','".$objResult["cus_addtum"]."','".$objResult["cus_ampher"]."','".$objResult["cus_province"]."','".$objResult["cus_postcode"]."','".$objResult["tel_cus"]."','".$objResult["email"]."','".$add_by."','".$add_date."')";
 $objQuery19 = mysqli_query($servicenb,$strSQL19)or die(mysqli_error());	
	
$sql1_up="update tb_installation_data set warranty='1' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($servicenb,$sql1_up)or die(mysqli_error());		
	
}else if($num23=='1' and $objResult23["cus_name"]==''){	
	
$strSQL19 = "UPDATE tb_waranty_cus SET date_save='".$objResult["date_save"]."',cus_name='".$objResult["customer_name"]."',cus_add='".$objResult["cus_add"]."',cus_addtum='".$objResult["cus_addtum"]."',cus_ampher='".$objResult["cus_ampher"]."',cus_province='".$objResult["cus_province"]."',cus_postcode='".$objResult["cus_postcode"]."',cus_tel='".$objResult["tel_cus"]."',email='".$objResult["email"]."',add_by='".$add_by."',add_date='".$add_date."' where sn_num='".$product_sn1."'";
 $objQuery19 = mysqli_query($servicenb,$strSQL19)or die(mysqli_error());	
	
$sql1_up="update tb_installation_data set warranty='1' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($servicenb,$sql1_up)or die(mysqli_error());		
	
	
}else if($num23 > 0){

$MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ มีการลงทะเบียนรับประกันแล้วค่ะในชื่อของ คุณ '".$objResult23["customer_name"]."'";	

$strSQL78 = "insert into tb_snproprem (sn,des,add_by,add_date) values ('".$product_sn1."','".$MSG."','".$add_by."','".$add_date."')";
$objQuery78 = mysqli_query($conn,$strSQL78);	
	
	
}		
	
	
	
}
}

 if($qsave){ ?>
 </p></p></p></p></p>
<?php
  echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_waranty2.php?serial_num=$serial_num';";
echo "</script>";
?>

<?php	
  } else {
   echo "Cannot";
  }
	}
?>