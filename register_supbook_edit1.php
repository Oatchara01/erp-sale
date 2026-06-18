<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$date_jong = $_POST["date_jong"];
$company = $_POST["company"];
$sale_code = $_POST["sale_code"];
$customer_id = $_POST["bill_id"];
$customer = $_POST["customer"];
$bq_no = $_POST["bq_no"];
$drescription = $_POST["drescription"];
$date_receive = $_POST["date_receive"];
$ref_receive =  substr($date_receive,0,7);
$address_send = $_POST["address_send"];
$send_stock = $_POST["send_stock"];
$contact_ckk = $_POST["contact_ckk"];	
$type_jong = $_POST["type_jong"];
$status_doc = "Request";
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
$remark_edit = $_POST["remark_edit"];	
	
	


$ref_id = $_POST["ref_id"];


$save="UPDATE  hos__jongproduct SET date_jong = '".$date_jong."',customer_id = '".$customer_id."',customer = '".$customer."',bq_no = '".$bq_no."' ,drescription = '".$drescription."',date_receive = '".$date_receive."',address_send = '".$address_send."',sale_code = '".$sale_code."',ref_receive='".$ref_receive."',type_jong='".$type_jong."',contact_ckk='".$contact_ckk."'  where ref_id = '".$ref_id."'";

$qsave=mysqli_query($conn,$save);
	
	
	
$save1="insert into hos__jongproduct_rt
(ref_id,date_jong,company,customer,drescription,date_receive,address_send,sale_code,add_date,add_by,customer_id,iv_no,ref_receive,type_jong,remark_edit)
values
('".$ref_id."','".$date_jong."','".$company."','".$customer."','".$drescription."','".$date_receive."','".$address_send."','".$sale_code."','".$add_date."','".$add_by."','".$customer_id."','".$iv_no."','".$ref_receive."','".$type_jong."','".$remark_edit."')";

$qsave1=mysqli_query($conn,$save1);	
	
	

$id = $_POST["id"];
$product_id = $_POST["product_id"];
$count = $_POST["count"];
$sale_remarkk = $_POST["sale_remarkk"];
	
	
$strSQL1 = "SELECT * FROM  hos__subjongpro WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);	

if($Num_Rows1 > 0){	
 foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$count[$key];
		$product_id_new =$product_id[$key];
		$sale_remarkk_new =$sale_remarkk[$key];
	

$strSQL1 = "Update  hos__subjongpro set  product_id = '".$product_id_new."',product_code = '".$product_id_new."',count ='".$sale_count_new."',sale_remark = '".$sale_remarkk_new."' where id = '".$id_new."'";
$objQuery1 = mysqli_query($conn,$strSQL1);
	 
	 

$strSQLs1 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id_new."','".$product_id_new."','".$sale_count_new."','".$sale_remarkk_new."','".$add_date."','".$add_by."')";
$objQuerys1 = mysqli_query($conn,$strSQLs1);
	 

 }
}




$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];


$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];

	
$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];


$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];


$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];






if($product_id6 !==''  ){

$strSQL6 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id6."','".$product_id6."','".$sale_count6."','".$sale_remarkk6."')";
$objQuery6 = mysqli_query($conn,$strSQL6);

	
$strSQLs2 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id6."','".$product_id6."','".$sale_count6."','".$sale_remarkk6."','".$add_date."','".$add_by."')";
$objQuerys2 = mysqli_query($conn,$strSQLs2);
	
	
}


if($product_id7 !==''  ){

$strSQL7 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id7."','".$product_id7."','".$sale_count7."','".$sale_remarkk7."')";
$objQuery7 = mysqli_query($conn,$strSQL7);

	
$strSQLs2 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id7."','".$product_id7."','".$sale_count7."','".$sale_remarkk7."','".$add_date."','".$add_by."')";
$objQuerys2 = mysqli_query($conn,$strSQLs2);
	
}


if($product_id8 !==''  ){

$strSQL8 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id8."','".$product_id8."','".$sale_count8."','".$sale_remarkk8."')";
$objQuery8 = mysqli_query($conn,$strSQL8);

	
$strSQLs2 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id8."','".$product_id8."','".$sale_count8."','".$sale_remarkk8."','".$add_date."','".$add_by."')";
$objQuerys2 = mysqli_query($conn,$strSQLs2);
	
}


if($product_id9 !==''  ){

$strSQL9 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id9."','".$product_id9."','".$sale_count9."','".$sale_remarkk9."')";
$objQuery9 = mysqli_query($conn,$strSQL9);

	
$strSQLs2 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id9."','".$product_id9."','".$sale_count9."','".$sale_remarkk9."','".$add_date."','".$add_by."')";
$objQuerys2 = mysqli_query($conn,$strSQLs2);
	
}


if($product_id10 !==''  ){

$strSQL10 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id10."','".$product_id10."','".$sale_count10."','".$sale_remarkk10."')";
$objQuery10 = mysqli_query($conn,$strSQL10);

	
$strSQLs2 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id10."','".$product_id10."','".$sale_count10."','".$sale_remarkk10."','".$add_date."','".$add_by."')";
$objQuerys2 = mysqli_query($conn,$strSQLs2);
	
	
}

if($send_stock =='1'){
	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "uHRdo0cuoAeo2QdHm9xNLesbZidwSPRxjhGgm3W9HuE";
$sMessage = "หมายเลขอ้างอิง $ref_id มีการแก้ไขใบจองค่ะ ";
$chOne = curl_init();
curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt( $chOne, CURLOPT_POST, 1);
curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage);
$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec( $chOne );
if(curl_error($chOne))
{
echo 'error:' . curl_error($chOne);
}
else {
$result_ = json_decode($result, true);
echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne );  	
	
	
}



	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_supbook_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }

	}


