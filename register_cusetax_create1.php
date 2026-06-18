<?php // include ("head.php"); ?>


<?php
include("dbconnect.php");
// include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_tax = $_POST["type_tax"];
$sale_channel = $_POST["sale_channel"];
$order_id = $_POST["order_id"];
// $amount = $_POST["amount"];
$tax_id = $_POST["tax_id"];
$brun_no = $_POST["brun_no"];
$head_name = $_POST["head_name"];
$last_name = $_POST["last_name"];
$address = $_POST["address"];
$sub_district = $_POST["sub_district"];
$district = $_POST["district"];
$province = $_POST["province"];
$postcode = $_POST["postcode"];
$tel_num = $_POST["tel_num"];
$mail_cus = $_POST["mail_cus"];
$ckk_h = "1";
	
$order_id1 = $_POST["order_id1"];	
$order_id2 = $_POST["order_id2"];	
$order_id3 = $_POST["order_id3"];	
$order_id4 = $_POST["order_id4"];	
$order_id5 = $_POST["order_id5"];	
$order_id6 = $_POST["order_id6"];	
$order_id7 = $_POST["order_id7"];	
$order_id8 = $_POST["order_id8"];	
$order_id9 = $_POST["order_id9"];	
	

$add_date = date('Y-m-d H:i:s');

	
	
	
	
$ckk_order = "SELECT * FROM tb_customer_etax WHERE order_id = '".$order_id."' ";
$qckk_order = mysqli_query($conn,$ckk_order) or die(mysqli_error());
$nckk_order = mysqli_num_rows($qckk_order);
$vckk_order = mysqli_fetch_array($qckk_order);

if($nckk_order > 0){
  echo "<script language=\"JavaScript\">";
	echo "alert('หมายเลขคำสั่งซื้อนี้ได้มีการดำเนินการขอบิล E-tax ไปแล้ว หากต้องการแก้ไขข้อมูลกรุณาติดต่อร้านค้าผ่านช่องทางแชทค่ะ');";
	echo "window.location.href='register_cusetax_create.php'";
	echo "</script>";
exit();
}

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_customer_etax";
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

$so = "CE";
$ref_id ="$so$nextId";
	
	
	
$save="insert into tb_customer_etax
(ref_id,type_tax,sale_channel,order_id,tax_id,brun_no,head_name,last_name,address,sub_district,district,province,postcode,tel_num,mail_cus,ckk_h,add_date)
values
('".$ref_id."','".$type_tax."','".$sale_channel."','".$order_id."','".$tax_id."','".$brun_no."','".$head_name."','".$last_name."','".$address."','".$sub_district."','".$district."','".$province."','".$postcode."','".$tel_num."','".$mail_cus."','".$ckk_h."','".$add_date."')";
//echo $save;
$qsave=mysqli_query($conn,$save);
	
	

if($order_id1!=''){

$ckk_order = "SELECT * FROM tb_customer_etax WHERE order_id = '".$order_id1."' ";
$qckk_order = mysqli_query($conn,$ckk_order) or die(mysqli_error());
$nckk_order = mysqli_num_rows($qckk_order);
$vckk_order = mysqli_fetch_array($qckk_order);

if($nckk_order > 0){
  echo "<script language=\"JavaScript\">";
	echo "alert('หมายเลขคำสั่งซื้อนี้ได้มีการดำเนินการขอบิล E-tax ไปแล้ว หากต้องการแก้ไขข้อมูลกรุณาติดต่อร้านค้าผ่านช่องทางแชทค่ะ');";
	echo "window.location.href='register_cusetax_create.php'";
	echo "</script>";
exit();
}

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_customer_etax";
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

$so = "CE";
$ref_id ="$so$nextId";
	
	
	
$save="insert into tb_customer_etax
(ref_id,type_tax,sale_channel,order_id,tax_id,brun_no,head_name,last_name,address,sub_district,district,province,postcode,tel_num,mail_cus,ckk_h,add_date)
values
('".$ref_id."','".$type_tax."','".$sale_channel."','".$order_id1."','".$tax_id."','".$brun_no."','".$head_name."','".$last_name."','".$address."','".$sub_district."','".$district."','".$province."','".$postcode."','".$tel_num."','".$mail_cus."','".$ckk_h."','".$add_date."')";
//echo $save;
$qsave=mysqli_query($conn,$save);
	
}
	
	
	
if($order_id2!=''){

$ckk_order = "SELECT * FROM tb_customer_etax WHERE order_id = '".$order_id2."' ";
$qckk_order = mysqli_query($conn,$ckk_order) or die(mysqli_error());
$nckk_order = mysqli_num_rows($qckk_order);
$vckk_order = mysqli_fetch_array($qckk_order);

if($nckk_order > 0){
  echo "<script language=\"JavaScript\">";
	echo "alert('หมายเลขคำสั่งซื้อนี้ได้มีการดำเนินการขอบิล E-tax ไปแล้ว หากต้องการแก้ไขข้อมูลกรุณาติดต่อร้านค้าผ่านช่องทางแชทค่ะ');";
	echo "window.location.href='register_cusetax_create.php'";
	echo "</script>";
exit();
}

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_customer_etax";
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

$so = "CE";
$ref_id ="$so$nextId";
	
	
	
$save="insert into tb_customer_etax
(ref_id,type_tax,sale_channel,order_id,tax_id,brun_no,head_name,last_name,address,sub_district,district,province,postcode,tel_num,mail_cus,ckk_h,add_date)
values
('".$ref_id."','".$type_tax."','".$sale_channel."','".$order_id2."','".$tax_id."','".$brun_no."','".$head_name."','".$last_name."','".$address."','".$sub_district."','".$district."','".$province."','".$postcode."','".$tel_num."','".$mail_cus."','".$ckk_h."','".$add_date."')";
//echo $save;
$qsave=mysqli_query($conn,$save);
	
}	
	
	
if($order_id3!=''){

$ckk_order = "SELECT * FROM tb_customer_etax WHERE order_id = '".$order_id3."' ";
$qckk_order = mysqli_query($conn,$ckk_order) or die(mysqli_error());
$nckk_order = mysqli_num_rows($qckk_order);
$vckk_order = mysqli_fetch_array($qckk_order);

if($nckk_order > 0){
  echo "<script language=\"JavaScript\">";
	echo "alert('หมายเลขคำสั่งซื้อนี้ได้มีการดำเนินการขอบิล E-tax ไปแล้ว หากต้องการแก้ไขข้อมูลกรุณาติดต่อร้านค้าผ่านช่องทางแชทค่ะ');";
	echo "window.location.href='register_cusetax_create.php'";
	echo "</script>";
exit();
}

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_customer_etax";
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

$so = "CE";
$ref_id ="$so$nextId";
	
	
	
$save="insert into tb_customer_etax
(ref_id,type_tax,sale_channel,order_id,tax_id,brun_no,head_name,last_name,address,sub_district,district,province,postcode,tel_num,mail_cus,ckk_h,add_date)
values
('".$ref_id."','".$type_tax."','".$sale_channel."','".$order_id3."','".$tax_id."','".$brun_no."','".$head_name."','".$last_name."','".$address."','".$sub_district."','".$district."','".$province."','".$postcode."','".$tel_num."','".$mail_cus."','".$ckk_h."','".$add_date."')";
//echo $save;
$qsave=mysqli_query($conn,$save);
	
}	
	
	
if($order_id4!=''){

$ckk_order = "SELECT * FROM tb_customer_etax WHERE order_id = '".$order_id4."' ";
$qckk_order = mysqli_query($conn,$ckk_order) or die(mysqli_error());
$nckk_order = mysqli_num_rows($qckk_order);
$vckk_order = mysqli_fetch_array($qckk_order);

if($nckk_order > 0){
  echo "<script language=\"JavaScript\">";
	echo "alert('หมายเลขคำสั่งซื้อนี้ได้มีการดำเนินการขอบิล E-tax ไปแล้ว หากต้องการแก้ไขข้อมูลกรุณาติดต่อร้านค้าผ่านช่องทางแชทค่ะ');";
	echo "window.location.href='register_cusetax_create.php'";
	echo "</script>";
exit();
}

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_customer_etax";
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

$so = "CE";
$ref_id ="$so$nextId";
	
	
	
$save="insert into tb_customer_etax
(ref_id,type_tax,sale_channel,order_id,tax_id,brun_no,head_name,last_name,address,sub_district,district,province,postcode,tel_num,mail_cus,ckk_h,add_date)
values
('".$ref_id."','".$type_tax."','".$sale_channel."','".$order_id4."','".$tax_id."','".$brun_no."','".$head_name."','".$last_name."','".$address."','".$sub_district."','".$district."','".$province."','".$postcode."','".$tel_num."','".$mail_cus."','".$ckk_h."','".$add_date."')";
//echo $save;
$qsave=mysqli_query($conn,$save);
	
}	
	
	
	
if($order_id5!=''){

$ckk_order = "SELECT * FROM tb_customer_etax WHERE order_id = '".$order_id5."' ";
$qckk_order = mysqli_query($conn,$ckk_order) or die(mysqli_error());
$nckk_order = mysqli_num_rows($qckk_order);
$vckk_order = mysqli_fetch_array($qckk_order);

if($nckk_order > 0){
  echo "<script language=\"JavaScript\">";
	echo "alert('หมายเลขคำสั่งซื้อนี้ได้มีการดำเนินการขอบิล E-tax ไปแล้ว หากต้องการแก้ไขข้อมูลกรุณาติดต่อร้านค้าผ่านช่องทางแชทค่ะ');";
	echo "window.location.href='register_cusetax_create.php'";
	echo "</script>";
exit();
}

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_customer_etax";
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

$so = "CE";
$ref_id ="$so$nextId";
	
	
	
$save="insert into tb_customer_etax
(ref_id,type_tax,sale_channel,order_id,tax_id,brun_no,head_name,last_name,address,sub_district,district,province,postcode,tel_num,mail_cus,ckk_h,add_date)
values
('".$ref_id."','".$type_tax."','".$sale_channel."','".$order_id5."','".$tax_id."','".$brun_no."','".$head_name."','".$last_name."','".$address."','".$sub_district."','".$district."','".$province."','".$postcode."','".$tel_num."','".$mail_cus."','".$ckk_h."','".$add_date."')";
//echo $save;
$qsave=mysqli_query($conn,$save);
	
}	
	
	
if($order_id6!=''){

$ckk_order = "SELECT * FROM tb_customer_etax WHERE order_id = '".$order_id6."' ";
$qckk_order = mysqli_query($conn,$ckk_order) or die(mysqli_error());
$nckk_order = mysqli_num_rows($qckk_order);
$vckk_order = mysqli_fetch_array($qckk_order);

if($nckk_order > 0){
  echo "<script language=\"JavaScript\">";
	echo "alert('หมายเลขคำสั่งซื้อนี้ได้มีการดำเนินการขอบิล E-tax ไปแล้ว หากต้องการแก้ไขข้อมูลกรุณาติดต่อร้านค้าผ่านช่องทางแชทค่ะ');";
	echo "window.location.href='register_cusetax_create.php'";
	echo "</script>";
exit();
}

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_customer_etax";
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

$so = "CE";
$ref_id ="$so$nextId";
	
	
	
$save="insert into tb_customer_etax
(ref_id,type_tax,sale_channel,order_id,tax_id,brun_no,head_name,last_name,address,sub_district,district,province,postcode,tel_num,mail_cus,ckk_h,add_date)
values
('".$ref_id."','".$type_tax."','".$sale_channel."','".$order_id6."','".$tax_id."','".$brun_no."','".$head_name."','".$last_name."','".$address."','".$sub_district."','".$district."','".$province."','".$postcode."','".$tel_num."','".$mail_cus."','".$ckk_h."','".$add_date."')";
//echo $save;
$qsave=mysqli_query($conn,$save);
	
}	
	

if($order_id7!=''){

$ckk_order = "SELECT * FROM tb_customer_etax WHERE order_id = '".$order_id7."' ";
$qckk_order = mysqli_query($conn,$ckk_order) or die(mysqli_error());
$nckk_order = mysqli_num_rows($qckk_order);
$vckk_order = mysqli_fetch_array($qckk_order);

if($nckk_order > 0){
  echo "<script language=\"JavaScript\">";
	echo "alert('หมายเลขคำสั่งซื้อนี้ได้มีการดำเนินการขอบิล E-tax ไปแล้ว หากต้องการแก้ไขข้อมูลกรุณาติดต่อร้านค้าผ่านช่องทางแชทค่ะ');";
	echo "window.location.href='register_cusetax_create.php'";
	echo "</script>";
exit();
}

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_customer_etax";
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

$so = "CE";
$ref_id ="$so$nextId";
	
	
	
$save="insert into tb_customer_etax
(ref_id,type_tax,sale_channel,order_id,tax_id,brun_no,head_name,last_name,address,sub_district,district,province,postcode,tel_num,mail_cus,ckk_h,add_date)
values
('".$ref_id."','".$type_tax."','".$sale_channel."','".$order_id7."','".$tax_id."','".$brun_no."','".$head_name."','".$last_name."','".$address."','".$sub_district."','".$district."','".$province."','".$postcode."','".$tel_num."','".$mail_cus."','".$ckk_h."','".$add_date."')";
//echo $save;
$qsave=mysqli_query($conn,$save);
	
}

	

if($order_id8!=''){

$ckk_order = "SELECT * FROM tb_customer_etax WHERE order_id = '".$order_id8."' ";
$qckk_order = mysqli_query($conn,$ckk_order) or die(mysqli_error());
$nckk_order = mysqli_num_rows($qckk_order);
$vckk_order = mysqli_fetch_array($qckk_order);

if($nckk_order > 0){
  echo "<script language=\"JavaScript\">";
	echo "alert('หมายเลขคำสั่งซื้อนี้ได้มีการดำเนินการขอบิล E-tax ไปแล้ว หากต้องการแก้ไขข้อมูลกรุณาติดต่อร้านค้าผ่านช่องทางแชทค่ะ');";
	echo "window.location.href='register_cusetax_create.php'";
	echo "</script>";
exit();
}

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_customer_etax";
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

$so = "CE";
$ref_id ="$so$nextId";
	
	
	
$save="insert into tb_customer_etax
(ref_id,type_tax,sale_channel,order_id,tax_id,brun_no,head_name,last_name,address,sub_district,district,province,postcode,tel_num,mail_cus,ckk_h,add_date)
values
('".$ref_id."','".$type_tax."','".$sale_channel."','".$order_id8."','".$tax_id."','".$brun_no."','".$head_name."','".$last_name."','".$address."','".$sub_district."','".$district."','".$province."','".$postcode."','".$tel_num."','".$mail_cus."','".$ckk_h."','".$add_date."')";
//echo $save;
$qsave=mysqli_query($conn,$save);
	
}

	
	
if($order_id9!=''){

$ckk_order = "SELECT * FROM tb_customer_etax WHERE order_id = '".$order_id9."' ";
$qckk_order = mysqli_query($conn,$ckk_order) or die(mysqli_error());
$nckk_order = mysqli_num_rows($qckk_order);
$vckk_order = mysqli_fetch_array($qckk_order);

if($nckk_order > 0){
  echo "<script language=\"JavaScript\">";
	echo "alert('หมายเลขคำสั่งซื้อนี้ได้มีการดำเนินการขอบิล E-tax ไปแล้ว หากต้องการแก้ไขข้อมูลกรุณาติดต่อร้านค้าผ่านช่องทางแชทค่ะ');";
	echo "window.location.href='register_cusetax_create.php'";
	echo "</script>";
exit();
}

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_customer_etax";
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

$so = "CE";
$ref_id ="$so$nextId";
	
	
	
$save="insert into tb_customer_etax
(ref_id,type_tax,sale_channel,order_id,tax_id,brun_no,head_name,last_name,address,sub_district,district,province,postcode,tel_num,mail_cus,ckk_h,add_date)
values
('".$ref_id."','".$type_tax."','".$sale_channel."','".$order_id9."','".$tax_id."','".$brun_no."','".$head_name."','".$last_name."','".$address."','".$sub_district."','".$district."','".$province."','".$postcode."','".$tel_num."','".$mail_cus."','".$ckk_h."','".$add_date."')";
//echo $save;
$qsave=mysqli_query($conn,$save);
	
}
	
	
	
	
	
	
	
	
	

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_cusetax_veiw.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


?>