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
$ref_id = $_POST["ref_id"];
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
$remark_name = $_POST["remark_name"];
$type_head = $_POST["type_head"];	
$delivery_date = $_POST["delivery_date"];
$payment_dead_other_wrap = $_POST["payment_dead_other_wrap"];	
	
$add_date = date('Y-m-d H:i:s');
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
	
if($_FILES['speck']['name']!=''){
	move_uploaded_file($_FILES['speck']['tmp_name'],"qou/".iconv("UTF-8", "TIS-620",$_FILES['speck']['name']));
 $speck=$_FILES['speck']['name'];

}else{
 $speck = $_POST["speck"];

}

if($_FILES['picture']['name']!=''){
	move_uploaded_file($_FILES['picture']['tmp_name'],"qou/".iconv("UTF-8", "TIS-620",$_FILES['picture']['name']));
 $picture=$_FILES['picture']['name'];

}else{
 $picture = $_POST["picture"];

}

if($_FILES['catalog']['name']!=''){
	move_uploaded_file($_FILES['catalog']['tmp_name'],"qou/".iconv("UTF-8", "TIS-620",$_FILES['catalog']['name']));
 $catalog=$_FILES['catalog']['name'];

}else{
 $catalog = $_POST["catalog"];

}



	

$save="UPDATE qou__main SET
cus_name='".$cus_name."',description='".$description."',payment_dead='".$payment_dead."',set_price='".$set_price."',delivery_dead='".$delivery_dead."',waranty='".$waranty."',cusmail_name='".$cusmail_name."',email='".$email."',remark1='".$remark1."',remark2='".$remark2."',remark3='".$remark3."',remark4='".$remark4."',remark5='".$remark5."',iv_date='".$iv_date."',iv_no='".$iv_no."',speck='".$speck."',catalog='".$catalog."',picture='".$picture."',remark_ckk='".$remark_ckk."',type_head='".$type_head."',payment_dead_other_wrap='".$payment_dead_other_wrap."',delivery_date='".$delivery_date."'  where ref_id ='".$ref_id."'";

$qsave=mysqli_query($conn,$save);

	
$id = $_POST["id"];
$product_id = $_POST["product_id"];
$sale_count = $_POST["sale_count"];
$sum_amount = $_POST["sum_amount"];
$discount_unit = $_POST["discount_unit"];
$product_price = $_POST["product_price"];

$strSQL21 = "SELECT * FROM qou__sbmain WHERE ref_idd = '".$ref_id."' ";

$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){

  foreach($id as $key =>$value)
	{
	$id_new=$id[$key];
	$product_id_new =$product_id[$key];
    $sale_count_new = $sale_count[$key];
	$remark_name_new = $remark_name[$key];
	$discount_unit1 = $discount_unit[$key];
	$discount_unit_new = str_replace(',','', $discount_unit1);
	$product_price1 = $product_price[$key];
	$product_price_new = str_replace(',','', $product_price1);
	 $sum_amount_new = ($sale_count_new*$product_price_new)-($sale_count_new*$discount_unit_new); 
	

	  
	  


$strSQL = "Update   qou__sbmain set ref_idd='".$ref_id."',count='".$sale_count_new."',price='".$product_price_new."',amount='".$sum_amount_new."',product_id='".$product_id_new."',product_code ='".$product_id_new."',discount ='".$discount_unit_new."',remark_name='".$remark_name_new."'  Where id= '".$id_new."' ";

$objQuery = mysqli_query($conn,$strSQL);
	  
	  
	  
}
	
}




	

	
$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = str_replace(',','',$_POST["product_price6"]);
$discount_unit6 = str_replace(',','',$_POST["discount_unit6"]);
$sum_amount6= ($sale_count6*$product_price6)-($sale_count6*$discount_unit6);


	
$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = str_replace(',','',$_POST["product_price7"]);
$discount_unit7 = str_replace(',','',$_POST["discount_unit7"]);
$sum_amount7= ($sale_count7*$product_price7)-($sale_count7*$discount_unit7);


	
$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = str_replace(',','',$_POST["product_price8"]);
$discount_unit8 = str_replace(',','',$_POST["discount_unit8"]);
$sum_amount8= ($sale_count8*$product_price8)-($sale_count8*$discount_unit8);


	
$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = str_replace(',','',$_POST["product_price9"]);
$discount_unit9 = str_replace(',','',$_POST["discount_unit9"]);
$sum_amount9= ($sale_count9*$product_price9)-($sale_count9*$discount_unit9);


	
$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = str_replace(',','',$_POST["product_price10"]);
$discount_unit10 = str_replace(',','',$_POST["discount_unit10"]);
$sum_amount10= ($sale_count10*$product_price10)-($sale_count10*$discount_unit10);


	$product_id11 = $_POST["product_id11"];
$sale_count11 = $_POST["sale_count11"];
$product_price11 = str_replace(',','',$_POST["product_price11"]);
$discount_unit11 = str_replace(',','',$_POST["discount_unit11"]);
$sum_amount11= ($sale_count11*$product_price11)-($sale_count11*$discount_unit11);


	$product_id12 = $_POST["product_id12"];
$sale_count12 = $_POST["sale_count12"];
$product_price12 = str_replace(',','',$_POST["product_price12"]);
$discount_unit12 = str_replace(',','',$_POST["discount_unit12"]);
$sum_amount12= ($sale_count12*$product_price12)-($sale_count12*$discount_unit12);


	$product_id13 = $_POST["product_id13"];
$sale_count13 = $_POST["sale_count13"];
$product_price13 = str_replace(',','',$_POST["product_price13"]);
$discount_unit13 = str_replace(',','',$_POST["discount_unit13"]);
$sum_amount13= ($sale_count13*$product_price13)-($sale_count13*$discount_unit13);


	$product_id14 = $_POST["product_id14"];
$sale_count14 = $_POST["sale_count14"];
$product_price14 = str_replace(',','',$_POST["product_price14"]);
$discount_unit14 = str_replace(',','',$_POST["discount_unit14"]);
$sum_amount14= ($sale_count14*$product_price14)-($sale_count14*$discount_unit14);


	$product_id15 = $_POST["product_id15"];
$sale_count15 = $_POST["sale_count15"];
$product_price15 = str_replace(',','',$_POST["product_price15"]);
$discount_unit15 = str_replace(',','',$_POST["discount_unit15"]);
$sum_amount15= ($sale_count15*$product_price15)-($sale_count15*$discount_unit15);

	



	
	
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
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_qou_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }	
	
	
}




?>


</center>
</body>
</html>



