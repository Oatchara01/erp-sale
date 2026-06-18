<?php
include("dbconnect.php");
date_default_timezone_set("Asia/Bangkok");

$add_date1 = date('Y-m-d');
	 
	 function DateDiff($strDate1,$strDate2)
{
return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
}
function TimeDiff($strTime1,$strTime2)
{
return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}
function DateTimeDiff($strDateTime1,$strDateTime2)
{
return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}


if ($_POST["submit"] = "submit") {
$group_name = $_POST["product_name"];
	
if($_POST["type_warr"]=='2'){	
$product_name = $_POST["ddlProductBrand"];	
}else{
	
$sqlpro = "SELECT product_name FROM tb_prowaranty where id = '".$_POST["ddlProductBrand"]."'";
$qrypro = mysqli_query($conn,$sqlpro) or die(mysqli_error());
$rspro = mysqli_fetch_assoc($qrypro);
	
$product_name = $rspro["product_name"];	
}

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
$address = "$cus_address $cus_province $cus_postcode";	
	
$add_date = date('Y-m-d H:i:s');
$today = date('Y-m-d');

$lot_no = $_POST["lot_no"];	
$sale_channel = $_POST["sale_channel"];	
	
	

if($serial_num!=''){	
	
	
$strSQL22 = "SELECT product_name,serial_num,cus_name FROM tb_waranty WHERE serial_num = '".$serial_num."' ";
$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$objResult22 = mysqli_fetch_array($objQuery22);	
	
	
$sql3 = "SELECT date_st,ref_idd FROM st__sbmain where sn_number LIKE '%".$serial_num."%' order by date_st DESC ";
$qry3 = mysqli_query($new,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);

$date_st = $rs3["date_st"];

$date_late = DateDiff($date_st,$add_date1);

$sql33 = "SELECT sale_channel FROM st__main where ref_id = '".$rs3["ref_idd"]."'  ";
$qry33 = mysqli_query($new,$sql33) or die(mysqli_error());
$rs33 = mysqli_fetch_assoc($qry33);	

$sql2 = "SELECT buy_status FROM product__instock where product_sn = '".$serial_num."' and buy_status='1'";
$qry2 = mysqli_query($new,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_assoc($qry2);
	
	
$sql4="select product_sn,buy_status from tb_products_in_stock where product_sn='".$serial_num."' ";
$result4 = mysqli_query($service,$sql4) or die(mysqli_error());
$num4=mysqli_num_rows($result4); 
	
$sql41="select product_sn,buy_status from tb_products_in_stock where product_sn='".$serial_num."' ";
$result41 = mysqli_query($servicenb,$sql41) or die(mysqli_error());
$num41=mysqli_num_rows($result41); 	

$valii = $num4+$num41;	
	
if($valii < 1){

echo "<script language=\"JavaScript\">";
echo "alert('คุณกรอก ข้อมูล Serial number ไม่ถูกต้อง');window.location='register_waranty3.php?sn=$serial_num&group=$group_name&product=$product_name';";
echo "</script>";
exit();

}elseif($objResult22["serial_num"]!=''){	

echo "<script language=\"JavaScript\">";
echo "alert('ไม่สามารถลงทะเบียนรับประกันได้');window.location='register_waranty3.php?sn=$serial_num&group=$group_name&product=$product_name';";
echo "</script>";
exit();	
	
}elseif($date_late > '30' and $rs33["sale_channel"]!='0'){

echo "<script language=\"JavaScript\">";
echo "alert('ไม่สามารถลงทะเบียนรับประกันได้');window.location='register_waranty3.php?sn=$serial_num&group=$group_name&product=$product_name';";
echo "</script>";
exit();

}else{
	
	
	
$sql = "SELECT waranty FROM tb_prowaranty where product_name ='".$product_name."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
$waranty = $rs["waranty"];
$yy = "year";
$waranty1 = "$waranty$yy";
$register_date = $date_install;	
$datedate = date ("Y-m-d", strtotime($warranty1, strtotime($register_date)));	
$product_sn1 = $serial_num;	
	
	
if ($_FILES['img_upload']['size'] == 0) {
$newfilename = "";

} else if($_FILES['img_upload']['size'] != 0) {
$temp = explode(".", $_FILES["img_upload"]["name"]);
$newfilename = "img" . "_" . $serial_num . "_" . round(microtime(true)) . '.' . end($temp);
move_uploaded_file($_FILES["img_upload"]["tmp_name"], "up_waranty/" . $newfilename);
}
	
	

$save="insert into tb_waranty
(group_name,product_name,serial_num,cus_name,cus_address,date_install,cus_province,cus_country,cus_postcode,tel_cus,email,add_date,accept,waranty,date_save,agree_ckk,cus_lastname,customer_name,cus_add,cus_addtum,cus_ampher,img_upload)
values
('".$group_name."','".$product_name."','".$serial_num."','".$cus_name."','".$cus_address."','".$date_install."','".$cus_province."','".$cus_country."','".$cus_postcode."','".$tel_cus."','".$email."','".$add_date."','".$accept."','".$waranty1."','".$today."','1','".$cus_lastname."','".$customer_name."','".$cus_add."','".$cus_addtum."','".$cus_ampher."','".$newfilename."')";

$qsave=mysqli_query($conn,$save);
	
	
$strSQL9 = "UPDATE tb_installation_data SET install_cus_tel='".$tel_cus."'  where product_sn='".$product_sn1."'";
$objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());		
	
	
$sql4="select product_sn from tb_products_in_stock where product_sn='".$product_sn1."' ";
$result4 = mysqli_query($service,$sql4) or die(mysqli_error());
$num4=mysqli_num_rows($result4); 
	
$sql41="select product_sn from tb_products_in_stock where product_sn='".$product_sn1."' ";
$result41 = mysqli_query($servicenb,$sql41) or die(mysqli_error());
$num41=mysqli_num_rows($result41); 
	
$sql3="select * from tb_waranty where serial_num='".$product_sn1."' ";
$result = mysqli_query($conn,$sql3) or die(mysqli_error());
$objResult = mysqli_fetch_array($result);
	
	
	
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
	
$sql1_up="update tb_installation_data set warranty='1',install_cus_tel='".$objResult["tel_cus"]."' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($service,$sql1_up)or die(mysqli_error());		
	
	
}else if($num23=='1' and $objResult23["cus_name"]==''){	
	
$strSQL19 = "UPDATE tb_waranty_cus SET date_save='".$objResult["date_save"]."',cus_name='".$objResult["customer_name"]."',cus_add='".$objResult["cus_add"]."',cus_addtum='".$objResult["cus_addtum"]."',cus_ampher='".$objResult["cus_ampher"]."',cus_province='".$objResult["cus_province"]."',cus_postcode='".$objResult["cus_postcode"]."',cus_tel='".$objResult["tel_cus"]."',email='".$objResult["email"]."',add_by='".$add_by."',add_date='".$add_date."' where sn_num='".$product_sn1."'";
$objQuery19 = mysqli_query($service,$strSQL19)or die(mysqli_error());	
	
$sql1_up="update tb_installation_data set warranty='1',install_cus_tel='".$objResult["tel_cus"]."' where product_sn='".$product_sn1."' ";
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

$sql1_up="update tb_installation_data set warranty='1',install_cus_tel='".$objResult["tel_cus"]."' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($servicenb,$sql1_up)or die(mysqli_error());		
	
	
}else if($num23=='1' and $objResult23["cus_name"]==''){	
	
$strSQL19 = "UPDATE tb_waranty_cus SET date_save='".$objResult["date_save"]."',cus_name='".$objResult["customer_name"]."',cus_add='".$objResult["cus_add"]."',cus_addtum='".$objResult["cus_addtum"]."',cus_ampher='".$objResult["cus_ampher"]."',cus_province='".$objResult["cus_province"]."',cus_postcode='".$objResult["cus_postcode"]."',cus_tel='".$objResult["tel_cus"]."',email='".$objResult["email"]."',add_by='".$add_by."',add_date='".$add_date."' where sn_num='".$product_sn1."'";
 $objQuery19 = mysqli_query($servicenb,$strSQL19)or die(mysqli_error());	
	
$sql1_up="update tb_installation_data set warranty='1',install_cus_tel='".$objResult["tel_cus"]."' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($servicenb,$sql1_up)or die(mysqli_error());		
	
	
}else if($num23 > 0){

$MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ มีการลงทะเบียนรับประกันแล้วค่ะในชื่อของ คุณ '".$objResult23["customer_name"]."'";	
	
$strSQL78 = "insert into tb_snproprem (sn,des,add_by,add_date) values ('".$product_sn1."','".$MSG."','".$add_by."','".$add_date."')";
$objQuery78 = mysqli_query($conn,$strSQL78);	
	
}		

}
}
}else{

	
if($lot_no !=''){	
$em_id = date('m');
	
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_war) AS MAXID FROM tb_waranty";
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

$so = "WR";
$ref_war ="$so$nextId";
	
	
	
	
if ($_FILES['img_upload']['size'] != 0) {
 $temp = explode(".", $_FILES["img_upload"]["name"]);
 $img_upload = "warbill" . $ref_war . "_" . round(microtime(true)) . '.' . end($temp);
 move_uploaded_file($_FILES["img_upload"]["tmp_name"], "up_waranty/" . $img_upload);
}	
	

	
$sql = "SELECT waranty,id FROM tb_prowaranty where product_name ='".$product_name."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
$waranty = $rs["waranty"];
$yy = "year";
$waranty1 = "$waranty$yy";
$register_date = $date_install;	
$datedate = date ("Y-m-d", strtotime($waranty1, strtotime($register_date)));

if($rs["id"]=='66'){	
$product_id ='5398';	
}else if($rs["id"]=='68'){
$product_id ='5620';	
}else if($rs["id"]=='83'){
$product_id ='5277';		
}

$save="insert into tb_waranty
(group_name,product_name,lot_no,cus_name,cus_address,date_install,cus_province,cus_country,cus_postcode,tel_cus,email,add_date,accept,waranty,date_save,agree_ckk,cus_lastname,customer_name,cus_add,cus_addtum,cus_ampher,img_upload,sale_channel,ref_war)
values
('".$group_name."','".$product_name."','".$lot_no."','".$customer_name."','".$cus_address."','".$date_install."','".$cus_province."','".$cus_country."','".$cus_postcode."','".$tel_cus."','".$email."','".$add_date."','".$accept."','".$waranty1."','".$today."','1','".$cus_lastname."','".$customer_name."','".$cus_add."','".$cus_addtum."','".$cus_ampher."','".$img_upload."','".$sale_channel."','".$ref_war."')";
//echo $save;
$qsave=mysqli_query($conn,$save);
		
	
$strSQL19 = "INSERT INTO tb_install_nosn (customer_name,customer_tel,address,buy_date,install_date,warranty_phase,out_insurance_date,add_by,add_date,cus_mail,warranty,up_slip,sale_channel,product_id,lot_no,ref_war) VALUES ('".$customer_name."','".$tel_cus."','".$address."','".$date_install."','".$date_install."','".$waranty1."','".$datedate."','Customer','".$add_date."','".$email."','1','".$img_upload."','".$sale_channel."','".$product_id."','".$lot_no."','".$ref_war."')";
//echo $strSQL19;	
 $objQuery19 = mysqli_query($service,$strSQL19)or die(mysqli_error());		
	
	
}	
}

	
//exit();
	

 if($qsave){ ?>
 </p></p></p></p></p>
<?php
  echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_waranty2.php?serial_num=$serial_num&ref_war=$ref_war';";
echo "</script>";
?>

<?php	
  } else {
   echo "Cannot";
  }
	}
?>