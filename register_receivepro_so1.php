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


$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$sale_remarkk = $_POST["sale_remarkk"];
$product_id = $_POST["product_id"];
$amount  = $_POST["amount"];


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
(rp_no,type_company,iv_date,iv_noref,customer,address,bill_name,bill_address,ref_iddoc,add_date,add_by,type_doc,sale_code,type_customer,delivery_date,reforder_id)
values
('".$rp_no."','".$type_company."','".$iv_date."','".$iv_noref."','".$customer."','".$address."','".$bill_name."','".$bill_address."','".$ref_iddoc."','".$add_date."','".$add_by."','".$type_doc."','".$sale_code."','".$type_customer."','".$delivery_date."','".$reforder_id."')";


$qsave=mysqli_query($conn,$save);



foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$sale_remarkk_new=$sale_remarkk[$key];
		$product_id_new =$product_id[$key];
	$amount_new =$amount[$key];


	if($product_id_new !=""){

$strSQL = "insert into hos__subproreceive
(ref_rpno,count,sale_remark,product_code,product_id,amount)
values ('".$rp_no."','".$sale_count_new."','".$sale_remarkk_new."','".$product_id_new."','".$product_id_new."','".$amount_new."')";

$objQuery = mysqli_query($conn,$strSQL);
	}

}


	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_receivepro_soedit.php?rp_no=$rp_no';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}