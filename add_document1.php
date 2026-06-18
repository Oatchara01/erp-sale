<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$id_customer_run = $_POST["id_customer_run"];
$customer_code = $_POST["customer_code"];
$customer_name = $_POST["customer_name"];
$bill_name = $_POST["bill_name"];
$status = $_POST["status"];
$date_specify = $_POST["date_specify"];
$discription1 = $_POST["discription1"];
$discription2 = $_POST["discription2"];
$discription3 = $_POST["discription3"];
$discription4 = $_POST["discription4"];
$discription5 = $_POST["discription5"];
$discription6 = $_POST["discription6"];
$discription7 = $_POST["discription7"];
$discription8 = $_POST["discription8"];
$discription9 = $_POST["discription9"];
$discription10 = $_POST["discription10"];
$sale1 = $_POST["sale1"];
$sale2 = $_POST["sale2"];
$customer_note = $_POST["customer_note"];
$command_print = $_POST["command_print"];
$stamp = $_POST["stamp"];
$stamp_note = $_POST["stamp_note"];
$count_tax = $_POST["count_tax"];

$description_tax = $_POST["description_tax"];
$bill = $_POST["bill"];
$description_bill = $_POST["description_bill"];
$attachment1 = $_POST["attachment1"];
$attachment2 = $_POST["attachment2"];
$attachment3 = $_POST["attachment3"];
$attachment4 = $_POST["attachment4"];
$attachment5 = $_POST["attachment5"];
$payment_term = $_POST["payment_term"];
	
move_uploaded_file($_FILES['img_1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['img_1']['name']));	
	
	
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_document";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -3);
$maxId3 = substr($rs['MAXID'],-7);

$maxId1 = substr($maxId3,0,-3);
$so = "DOC";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -3);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "001"; 
$nextId = $yearMonth.$maxId1;

}

$ref_id ="$so$nextId";
	
	//echo $ref_id;
	


$save="insert into tb_document
(id_customer_run,customer_code,customer_name,bill_name,status,date_specify,discription1,discription2,discription3,discription4,discription5,discription6,discription7,discription8,discription9,discription10,sale1,sale2,customer_note,command_print,stamp,stamp_note,count_tax,description_tax,bill,description_bill,attachment1,attachment2,attachment3,attachment4,attachment5,payment_term,img_1,ref_id)
values
('".$id_customer_run."','".$customer_code."','".$customer_name."','".$bill_name."','".$status."','".$date_specify."','".$discription1."','".$discription2."','".$discription3."','".$discription4."','".$discription5."','".$discription6."','".$discription7."','".$discription8."','".$discription9."','".$discription10."','".$sale1."','".$sale2."','".$customer_note."','".$command_print."','".$stamp."','".$stamp_note."','".$count_tax."','".$description_tax."','".$bill."','".$description_bill."','".$attachment1."','".$attachment2."','".$attachment3."','".$attachment4."','".$attachment5."','".$payment_term."','".$_FILES['img_1']['name']."','".$ref_id."')";

$qsave=mysqli_query($conn,$save);



$step_bill = $_POST["step_bill"]; 	
$bill_ckk = $_POST["bill_ckk"]; 	
$invoice_ckk = $_POST["invoice_ckk"]; 	
$invoice_no = $_POST["invoice_no"]; 	
$po_ckk = $_POST["po_ckk"]; 	
$add_bill = $_POST["add_bill"]; 	
$date_bill = $_POST["date_bill"]; 	
$bill_tel = $_POST["bill_tel"]; 	
$check_ckk = $_POST["check_ckk"]; 	
$authorize_ckk = $_POST["authorize_ckk"]; 	
$authorize = $_POST["authorize"]; 	
$welfare_ckk = $_POST["welfare_ckk"]; 	
$welfare = $_POST["welfare"]; 	
$payment_ckk = $_POST["payment_ckk"]; 	
$payment_name = $_POST["payment_name"]; 	
$add_check = $_POST["add_check"]; 	
$date_check = $_POST["date_check"]; 	
$withtax_ckk = $_POST["withtax_ckk"]; 	
$note_ckk = $_POST["note_ckk"]; 	
$note = $_POST["note"]; 	
$add_withtax = $_POST["add_withtax"]; 	
$date_withtax = $_POST["date_withtax"];
	
if($_FILES['img_sendpro']['name']!=''){
$temp1 = explode(".", $_FILES["img_sendpro"]["name"]);
$img_sendpro = "img_sendpro" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["img_sendpro"]["tmp_name"], "up_doccument/" . $img_sendpro);
}	
	
	
	
$save1="insert into tb_document_all
(ref_idd,bill_id,send_probill,step_bill,place_bill,bill_ckk,invoice_ckk,invoice_no,po_ckk,add_bill,date_bill,bill_tel,check_ckk,authorize_ckk,authorize,welfare_ckk,welfare,payment_ckk,payment_name,add_check,date_check,withtax_ckk,note_ckk,note,add_withtax,date_withtax,img_sendpro)
values
('".$ref_id."','".$id_customer_run."','".$send_probill."','".$step_bill."','".$place_bill."','".$bill_ckk."','".$invoice_ckk."','".$invoice_no."','".$po_ckk."','".$add_bill."','".$date_bill."','".$bill_tel."','".$check_ckk."','".$authorize_ckk."','".$authorize."','".$welfare_ckk."','".$welfare."','".$payment_ckk."','".$payment_name."','".$add_check."','".$date_check."','".$withtax_ckk."','".$note_ckk."','".$note."','".$add_withtax."','".$date_withtax."','".$img_sendpro."')";
//echo $save1;
$qsave1=mysqli_query($conn,$save1);	
	
	
	
	
	
	
	

if($qsave&$qsave1){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_document.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>