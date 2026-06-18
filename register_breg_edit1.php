<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_doc = $_POST["type_doc"];
$register_date = $_POST["register_date"];
$bill_id = $_POST["bill_id"];
$customer_name = $_POST["customer_name"];
$description = $_POST["description"];
$per_no = $_POST["per_no"];
$cm_no = $_POST["cm_no"];

$sale_code = $_SESSION['code'];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$ref_id =  $_POST["ref_id"];
	
	


$save="UPDATE hos__breg SET
bill_id='".$bill_id."',customer_name='".$customer_name."',description='".$description."',per_no='".$per_no."',cm_no= '".$cm_no."' where ref_id ='".$ref_id."'";
$qsave=mysqli_query($conn,$save);

	
$product_id = $_POST["product_id"];
$id_sub = $_POST["id_sub"];	
$sale_count = $_POST["sale_count"];
$sn_number = $_POST["sn_number"];
$remark_eng = $_POST["remark_eng"];

foreach($id_sub as $key =>$value)
{
		$id_sub_new = $id_sub[$key];
		$sale_count_new = $sale_count[$key];
		$sn_number_new = $sn_number[$key];
		$remark_eng_new = $remark_eng[$key];
				
	
$save6 = "Update  hos__subbreg1 set  count1 = '".$sale_count_new."',remark_eng1='".$remark_eng_new."',sn_number1='".$sn_number_new."'  where ref_id1 = '".$ref_id."' and id_sub1 = '".$id_sub_new."'";
$qsave6 = mysqli_query($conn,$save6);
	
}

	
$id_sub2 = $_POST["id_sub2"];	
$sale_count_1 = $_POST["sale_count_1"];
$sn_number_1 = $_POST["sn_number_1"];
$remark_eng_1 = $_POST["remark_eng_1"];
$type_probd_1 = $_POST["type_probd_1"];
	

foreach($id_sub2 as $key =>$value)
{
		$id_sub2_new = $id_sub2[$key];
		$sale_count_1_new = $sale_count_1[$key];
		$sn_number_1_new = $sn_number_1[$key];
		$remark_eng_1_new = $remark_eng_1[$key];
	    $type_probd_1_new = $type_probd_1[$key];
				
	
$save7 = "Update  hos__subbreg2 set  count2 = '".$sale_count_1_new."',remark_eng2='".$remark_eng_1_new."',sn_number2='".$sn_number_1_new."',type_probd='".$type_probd_1_new."'  where ref_id2 = '".$ref_id."' and id_sub2  = '".$id_sub2_new."'";
$qsave7 = mysqli_query($conn,$save7);
	
}	
	
	


$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$sn_number6 = $_POST["sn_number6"];
$remark_eng6 = $_POST["remark_eng6"];

$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$sn_number7 = $_POST["sn_number7"];
$remark_eng7 = $_POST["remark_eng7"];

$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$sn_number8 = $_POST["sn_number8"];
$remark_eng8 = $_POST["remark_eng8"];

$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$sn_number9 = $_POST["sn_number9"];
$remark_eng9 = $_POST["remark_eng9"];

$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$sn_number10 = $_POST["sn_number10"];
$remark_eng10 = $_POST["remark_eng10"];

	



if($product_id6 !==''  ){

$strSQL6 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id6."','".$product_id6."','".$sale_count6."','".$remark_eng6."','".$sn_number6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);
}
	

if($product_id7 !==''  ){

$strSQL7 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id7."','".$product_id7."','".$sale_count7."','".$remark_eng7."','".$sn_number7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);
}
	

if($product_id8 !==''  ){

$strSQL8 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id8."','".$product_id8."','".$sale_count8."','".$remark_eng8."','".$sn_number8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);
}
	

if($product_id9 !==''  ){

$strSQL9 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id9."','".$product_id9."','".$sale_count9."','".$remark_eng9."','".$sn_number9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);
}
	

if($product_id10 !==''  ){

$strSQL10 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id10."','".$product_id10."','".$sale_count10."','".$remark_eng10."','".$sn_number10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);
}
	


$product_id_6 = $_POST["product_id_6"];
$sale_count_6 = $_POST["sale_count_6"];
$sn_number_6 = $_POST["sn_number_6"];
$remark_eng_6 = $_POST["remark_eng_6"];
$type_probd_6 = $_POST["type_probd_6"];


$product_id_7 = $_POST["product_id_7"];
$sale_count_7 = $_POST["sale_count_7"];
$sn_number_7 = $_POST["sn_number_7"];
$remark_eng_7 = $_POST["remark_eng_7"];
$type_probd_7 = $_POST["type_probd_7"];


$product_id_8 = $_POST["product_id_8"];
$sale_count_8 = $_POST["sale_count_8"];
$sn_number_8 = $_POST["sn_number_8"];
$remark_eng_8 = $_POST["remark_eng_8"];
$type_probd_8 = $_POST["type_probd_8"];


$product_id_9 = $_POST["product_id_9"];
$sale_count_9 = $_POST["sale_count_9"];
$sn_number_9 = $_POST["sn_number_9"];
$remark_eng_9 = $_POST["remark_eng_9"];
$type_probd_9 = $_POST["type_probd_9"];


$product_id_10 = $_POST["product_id_10"];
$sale_count_10 = $_POST["sale_count_10"];
$sn_number_10 = $_POST["sn_number_10"];
$remark_eng_10 = $_POST["remark_eng_10"];
$type_probd_10 = $_POST["type_probd_10"];



if($product_id_6 !==''  ){

$strSQL16 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_6."','".$product_id_6."','".$sale_count_6."','".$remark_eng_6."','".$sn_number_6."','".$type_probd_6."')";

$objQuery16 = mysqli_query($conn,$strSQL16);
}

if($product_id_7 !==''  ){

$strSQL17 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_7."','".$product_id_7."','".$sale_count_7."','".$remark_eng_7."','".$sn_number_7."','".$type_probd_7."')";

$objQuery17 = mysqli_query($conn,$strSQL17);
}

if($product_id_8 !==''  ){

$strSQL18 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_8."','".$product_id_8."','".$sale_count_8."','".$remark_eng_8."','".$sn_number_8."','".$type_probd_8."')";

$objQuery18 = mysqli_query($conn,$strSQL18);
}

if($product_id_9 !==''  ){

$strSQL19 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_9."','".$product_id_9."','".$sale_count_9."','".$remark_eng_9."','".$sn_number_9."','".$type_probd_9."')";

$objQuery19 = mysqli_query($conn,$strSQL19);
}



if($product_id_10 !==''  ){

$strSQL20 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_10."','".$product_id_10."','".$sale_count_10."','".$remark_eng_10."','".$sn_number_10."','".$type_probd_10."')";

$objQuery20 = mysqli_query($conn,$strSQL20);
}



	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_breg_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


