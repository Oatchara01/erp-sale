<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_doc = $_POST["type_doc"];
$bill_name = $_POST["bill_name"];
$bill_address = $_POST["bill_address"];
$type_company = $_POST["type_company"];
$iv_date = $_POST["iv_date"];
$iv_noref = $_POST["iv_noref"];
$ref_iddoc = $_POST["ref_iddoc"];
$address = $_POST["address"];
$sale_code = $_POST["sale_code"];
$customer = $_POST["customer"];
$type_customer = $_POST["type_customer"];
$delivery_date = $_POST["delivery_date"];
$reforder_id = $_POST["reforder_id"];	
	
$add_date = date('Y-m-d H:i:s');
$name =	$_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";




$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(rp_no) AS MAXID FROM hos__proreceive";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -3);
$maxId3 = substr($rs['MAXID'],-7);
$maxId1 = substr($maxId3,0,-3);
		
$so = "RP";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -3);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "001"; 
$nextId = $yearMonth.$maxId1;
}

$so = "RP";
$rp_no ="$so$nextId";



$save="insert into hos__proreceive
(rp_no,type_company,iv_date,iv_noref,customer,address,bill_name,bill_address,ref_iddoc,add_date,add_by,type_doc,sale_code,type_customer,delivery_date,reforder_id,show_name)
values
('".$rp_no."','".$type_company."','".$iv_date."','".$iv_noref."','".$customer."','".$address."','".$bill_name."','".$bill_address."','".$ref_iddoc."','".$add_date."','".$add_by."','".$type_doc."','".$sale_code."','".$type_customer."','".$delivery_date."','".$reforder_id."','1')";


$qsave=mysqli_query($conn,$save);


$sale_count1 = $_POST["sale_count1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];
$product_id1 = $_POST["product_id1"];
$amount1  = $_POST["sum_amount1"];
$proname1 =$_POST["proname1"];
$ckk_name1 =$_POST["ckk_name1"];

$sale_count2 = $_POST["sale_count2"];
$sale_remarkk2 = $_POST["sale_remarkk2"];
$product_id2 = $_POST["product_id2"];
$amount2  = $_POST["sum_amount2"];
$proname2 =$_POST["proname2"];
$ckk_name2 =$_POST["ckk_name2"];

$sale_count3 = $_POST["sale_count3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];
$product_id3 = $_POST["product_id3"];
$amount3  = $_POST["sum_amount3"];
$proname3 =$_POST["proname3"];
$ckk_name3 =$_POST["ckk_name3"];

$sale_count4 = $_POST["sale_count4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];
$product_id4 = $_POST["product_id4"];
$amount4  = $_POST["sum_amount4"];
$proname4 =$_POST["proname4"];
$ckk_name4 =$_POST["ckk_name4"];

$sale_count5 = $_POST["sale_count5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];
$product_id5 = $_POST["product_id5"];
$amount5  = $_POST["sum_amount5"];
$proname5 =$_POST["proname5"];
$ckk_name5 =$_POST["ckk_name5"];



if($product_id1 !=""){

$strSQL = "insert into hos__subproreceive
(ref_rpno,count,sale_remark,product_code,product_id,amount,proname,ckk_name)
values ('".$rp_no."','".$sale_count1."','".$sale_remarkk1."','".$product_id1."','".$product_id1."','".$amount1."','".$proname1."','".$ckk_name1."')";

$objQuery = mysqli_query($conn,$strSQL);
	}



if($product_id2 !=""){

$strSQL = "insert into hos__subproreceive
(ref_rpno,count,sale_remark,product_code,product_id,amount,proname,ckk_name)
values ('".$rp_no."','".$sale_count2."','".$sale_remarkk2."','".$product_id2."','".$product_id2."','".$amount2."','".$proname2."','".$ckk_name2."')";

$objQuery = mysqli_query($conn,$strSQL);
	}


if($product_id3 !=""){

$strSQL = "insert into hos__subproreceive
(ref_rpno,count,sale_remark,product_code,product_id,amount,proname,ckk_name)
values ('".$rp_no."','".$sale_count3."','".$sale_remarkk3."','".$product_id3."','".$product_id3."','".$amount3."','".$proname3."','".$ckk_name3."')";

$objQuery = mysqli_query($conn,$strSQL);
	}


if($product_id4 !=""){

$strSQL = "insert into hos__subproreceive
(ref_rpno,count,sale_remark,product_code,product_id,amount,proname,ckk_name)
values ('".$rp_no."','".$sale_count4."','".$sale_remarkk4."','".$product_id4."','".$product_id4."','".$amount4."','".$proname4."','".$ckk_name4."')";

$objQuery = mysqli_query($conn,$strSQL);
	}


if($product_id5 !=""){

$strSQL = "insert into hos__subproreceive
(ref_rpno,count,sale_remark,product_code,product_id,amount,proname,ckk_name)
values ('".$rp_no."','".$sale_count5."','".$sale_remarkk5."','".$product_id5."','".$product_id5."','".$amount5."','".$proname5."','".$ckk_name5."')";

$objQuery = mysqli_query($conn,$strSQL);
	}


	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_receivepro_soedit.php?rp_no=$rp_no';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}