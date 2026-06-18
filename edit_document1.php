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
$id_customer = $_POST["id_customer"]; 


if($_FILES['img_1']['name']!=''){
 move_uploaded_file($_FILES['img_1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['img_1']['name']));
 $img_1=$_FILES['img_1']['name'];
}else{
 $img_1 = $_POST["img_11"];

}
	
	

$save="Update  tb_document set
id_customer_run='".$id_customer_run."',customer_code='".$customer_code."',customer_name='".$customer_name."',bill_name='".$bill_name."',status='".$status."',date_specify='".$date_specify."',discription1='".$discription1."',discription2='".$discription2."',discription3='".$discription3."',discription4='".$discription4."',discription5='".$discription5."',discription6='".$discription6."',discription7='".$discription7."',discription8='".$discription8."',discription9='".$discription9."',discription10='".$discription10."',sale1='".$sale1."',sale2='".$sale2."',customer_note='".$customer_note."',command_print='".$command_print."',stamp='".$stamp."',stamp_note='".$stamp_note."',count_tax='".$count_tax."',description_tax='".$description_tax."',bill='".$bill."',description_bill='".$description_bill."',attachment1='".$attachment1."',attachment2='".$attachment2."',attachment3='".$attachment3."',attachment4='".$attachment4."',attachment5='".$attachment5."',payment_term='".$payment_term."',img_1='".$img_1."' where id_customer = '".$id_customer."' 
";


$qsave=mysqli_query($conn,$save);


$ref_id = $_POST["ref_id"];
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
$send_probill = $_POST["send_probill"];	
	
if($_FILES['img_sendpro']['name']!=''){
$temp1 = explode(".", $_FILES["img_sendpro"]["name"]);
$img_sendpro = "img_sendpro" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["img_sendpro"]["tmp_name"], "up_doccument/" . $img_sendpro);
}else{
 $img_sendpro = $_POST["img_sendpro1"];

}	
	
	
	
/*$save1="Update tb_document_all SET
bill_id='".$id_customer_run."',send_probill='".$send_probill."',step_bill='".$step_bill."',place_bill='".$place_bill."',bill_ckk='".$bill_ckk."',invoice_ckk='".$invoice_ckk."',invoice_no='".$invoice_no."',po_ckk='".$po_ckk."',add_bill='".$add_bill."',date_bill='".$date_bill."',bill_tel='".$bill_tel."',check_ckk='".$check_ckk."',authorize_ckk='".$authorize_ckk."',authorize='".$authorize."',welfare_ckk='".$welfare_ckk."',welfare='".$welfare."',payment_ckk='".$payment_ckk."',payment_name='".$payment_name."',add_check='".$add_check."',date_check='".$date_check."',withtax_ckk='".$withtax_ckk."',note_ckk='".$note_ckk."',note='".$note."',add_withtax='".$add_withtax."',date_withtax='".$date_withtax."',img_sendpro='".$img_sendpro."' where ref_idd='".$ref_id."'";

$qsave1=mysqli_query($conn,$save1);	*/
	








 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_document.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>