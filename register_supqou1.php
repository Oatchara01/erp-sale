<?php include ("head.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
<style type="text/css">
<!--
.style8 {color: #6633FF; font-weight: bold; }
.style9 {
	color: #FF0000;
	font-weight: bold;
	font-size: 24px;
}

.style10 {
	color: #006600;
	font-weight: bold;
	font-size: 24px;
}
-->
</style>
</head>
<body>
<center></br></br>

<?php
include("dbconnect.php");
include("dbconnect_acc.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$register_date = date("Y-m-d");
$type_doc = $_POST["type_doc"];
$cus_name = $_POST["cus_name"];
$description = $_POST["description"];
$payment_dead = $_POST["payment_dead"];
$set_price = $_POST["set_price"];
$delivery_dead = $_POST["delivery_dead"];
$waranty = $_POST["waranty"];
$cusmail_name = $_POST["cusmail_name"];
$email = $_POST["email"];
$remark1 = $_POST["remark1"];
$remark2 = $_POST["remark2"];
$remark3 = $_POST["remark3"];
$remark4 = $_POST["remark4"];
$remark5 = $_POST["remark5"];
$iv_date = $_POST["iv_date"];
$iv_no = $_POST["iv_no"];
$remark_ckk = $_POST["remark_ckk"];
$delivery_date = $_POST["delivery_date"];	
$payment_dead_other_wrap = $_POST["payment_dead_other"];	
	
	
$add_date = date('Y-m-d H:i:s');
$sup_code = $_SESSION["emid"];
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
	
	move_uploaded_file($_FILES['speck']['tmp_name'],"qou/".iconv("UTF-8", "TIS-620",$_FILES['speck']['name']));
	move_uploaded_file($_FILES['catalog']['tmp_name'],"qou/".iconv("UTF-8", "TIS-620",$_FILES['catalog']['name']));
	move_uploaded_file($_FILES['picture']['tmp_name'],"qou/".iconv("UTF-8", "TIS-620",$_FILES['picture']['name']));

	if($type_doc=='1'){

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM qou__main where type_doc ='1'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "AWL";

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

	}else if($type_doc=='2'){

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM qou__main where type_doc ='2'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "NBM";

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

	}



$save="insert into qou__main
(ref_id,register_date,type_doc,cus_name,description,payment_dead,set_price,delivery_dead,waranty,cusmail_name,email,remark1,remark2,remark3,remark4,remark5,iv_date,iv_no,add_by,add_date,speck,catalog,picture,sup_name,sup_date,status_doc,send_sup,sup_code,remark_ckk,delivery_date,payment_dead_other_wrap)
values
('".$ref_id."','".$register_date."','".$type_doc."','".$cus_name."','".$description."','".$payment_dead."','".$set_price."','".$delivery_dead."','".$waranty."','".$cusmail_name."','".$email."','".$remark1."','".$remark2."','".$remark3."','".$remark4."','".$remark5."','".$iv_date."','".$iv_no."','".$add_by."','".$add_date."','".$_FILES['speck']['name']."','".$_FILES['catalog']['name']."','".$_FILES['picture']['name']."','".$add_by."','".$add_date."','Approve','1','".$sup_code."','".$remark_ckk."','".$delivery_date."','".$payment_dead_other_wrap."')";

$qsave=mysqli_query($conn,$save);

	




	
$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);
$discount_unit1 = $_POST["discount_unit1"];

	
$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$discount_unit2 = $_POST["discount_unit2"];


	
	$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$discount_unit3 = $_POST["discount_unit3"];


	
	$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$discount_unit4 = $_POST["discount_unit4"];


	
	$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$discount_unit5 = $_POST["discount_unit5"];


	
	$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$discount_unit6 = $_POST["discount_unit6"];


	
	$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$discount_unit7 = $_POST["discount_unit7"];


	
	$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$discount_unit8 = $_POST["discount_unit8"];


	
	$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$discount_unit9 = $_POST["discount_unit9"];


	
	$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$discount_unit10 = $_POST["discount_unit10"];


	$product_id11 = $_POST["product_id11"];
$sale_count11 = $_POST["sale_count11"];
$product_price11 = $_POST["product_price11"];
$sum_amountt11 = $_POST["sum_amount11"];
$sum_amount11= str_replace(',','', $sum_amountt11);
$discount_unit11 = $_POST["discount_unit11"];


	$product_id12 = $_POST["product_id12"];
$sale_count12 = $_POST["sale_count12"];
$product_price12 = $_POST["product_price12"];
$sum_amountt12 = $_POST["sum_amount12"];
$sum_amount12= str_replace(',','', $sum_amountt12);
$discount_unit12 = $_POST["discount_unit12"];


	$product_id13 = $_POST["product_id13"];
$sale_count13 = $_POST["sale_count13"];
$product_price13 = $_POST["product_price13"];
$sum_amountt13 = $_POST["sum_amount13"];
$sum_amount13= str_replace(',','', $sum_amountt13);
$discount_unit13 = $_POST["discount_unit13"];


	$product_id14 = $_POST["product_id14"];
$sale_count14 = $_POST["sale_count14"];
$product_price14 = $_POST["product_price14"];
$sum_amountt14 = $_POST["sum_amount14"];
$sum_amount14= str_replace(',','', $sum_amountt14);
$discount_unit14 = $_POST["discount_unit14"];


	$product_id15 = $_POST["product_id15"];
$sale_count15 = $_POST["sale_count15"];
$product_price15 = $_POST["product_price15"];
$sum_amountt15= $_POST["sum_amount15"];
$sum_amount15= str_replace(',','', $sum_amountt15);
$discount_unit15 = $_POST["discount_unit15"];


	



	
if($product_id1 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count1."','".$product_price1."','".$sum_amount1."','".$discount_unit1."','".$product_id1."','".$product_id1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	
	if($product_id2 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count2."','".$product_price2."','".$sum_amount2."','".$discount_unit2."','".$product_id2."','".$product_id2."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	if($product_id3 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count3."','".$product_price3."','".$sum_amount3."','".$discount_unit3."','".$product_id3."','".$product_id3."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	if($product_id4 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count4."','".$product_price4."','".$sum_amount4."','".$discount_unit4."','".$product_id4."','".$product_id4."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	if($product_id5 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count5."','".$product_price5."','".$sum_amount5."','".$discount_unit5."','".$product_id5."','".$product_id5."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	if($product_id6 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count6."','".$product_price6."','".$sum_amount6."','".$discount_unit6."','".$product_id6."','".$product_id6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	if($product_id7 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count7."','".$product_price7."','".$sum_amount7."','".$discount_unit7."','".$product_id7."','".$product_id7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	if($product_id8 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count8."','".$product_price8."','".$sum_amount8."','".$discount_unit8."','".$product_id8."','".$product_id8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	if($product_id9 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count9."','".$product_price9."','".$sum_amount9."','".$discount_unit9."','".$product_id9."','".$product_id9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	if($product_id10 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count10."','".$product_price10."','".$sum_amount10."','".$discount_unit10."','".$product_id10."','".$product_id10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	if($product_id11 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count11."','".$product_price11."','".$sum_amount11."','".$discount_unit11."','".$product_id11."','".$product_id11."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	if($product_id12 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count12."','".$product_price12."','".$sum_amount12."','".$discount_unit12."','".$product_id12."','".$product_id12."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	if($product_id13 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count13."','".$product_price13."','".$sum_amount13."','".$discount_unit13."','".$product_id13."','".$product_id13."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	if($product_id14 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count14."','".$product_price14."','".$sum_amount14."','".$discount_unit14."','".$product_id14."','".$product_id14."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	if($product_id15 !==''  ){

$strSQL1 = "insert into qou__sbmain
(ref_idd,count,price,amount,discount,product_id,product_code)
values ('".$ref_id."','".$sale_count15."','".$product_price15."','".$sum_amount15."','".$discount_unit15."','".$product_id15."','".$product_id15."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
	





	 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_supqou_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }	
	
	
}




?>


</center>
</body>
</html>



