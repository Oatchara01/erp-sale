<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$smp_date = $_POST["smp_date"];
$date = explode('-' , $_POST["smp_date"] );
$xdate = $date[0].'-'.$date[1];

$strSQL1 = "SELECT close_mount FROM  tb_closedoc WHERE close_mount = '".$xdate."' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
if($Num_Rows1 > 0){
	
echo "<script language=\"JavaScript\">";
echo "alert('ไม่สามารถบันทึกข้อมูลใบเบิกในเดือนนี้ได้เนื่องจากได้ทำการปิดเอกสารเรียบร้อยแล้วค่ะ');window.location='register_salesmp.php';";
echo "</script>";
	
}else{
		
	
$address_name = $_POST["address_name"];
$customer_name = $_POST["customer_name"];
$comment_sale = $_POST["comment_sale"];
$status_sup = "Request";
$sale_date= date('Y-m-d');
$sale_name =  $_SESSION['name'];
$sale_code = $_POST['sale_code'];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
$send_sup= '0';
$sup_name = $_SESSION['name'];
$sup_date = date('Y-m-d');
$comment_sup  = $_POST["comment_sup"];
$type_company   = $_POST["type_company"];
$delivery_type = $_POST["delivery_type"];
$delivery_date =$_POST["start_date"];
$date_send_key =$_POST["between_date"];	
$ref_idsale = $_POST["ref_idsale"];
$bill_id = $_POST["bill_id"];
$brnp_ckk =$_POST["brnp_ckk"];
$brnp_no =$_POST["brnp_no"];	
$crm_ckk = $_POST["crm_ckk"];
$crm_ref = $_POST["crm_ref"];	
$customer_tel = $_POST["customer_tel"];
$order_id = $_POST["order_id"];	
	
move_uploaded_file($_FILES['up_img1']['tmp_name'],"smp_up/".iconv("UTF-8", "TIS-620",$_FILES['up_img1']['name']));
move_uploaded_file($_FILES['up_img2']['tmp_name'],"smp_up/".iconv("UTF-8", "TIS-620",$_FILES['up_img2']['name']));
move_uploaded_file($_FILES['up_img3']['tmp_name'],"smp_up/".iconv("UTF-8", "TIS-620",$_FILES['up_img3']['name']));	
	
	
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_idsmp) AS MAXID FROM hos__smp";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "RSMP";

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


$ref_idsmp = "$so$nextId";


$save="insert into hos__smp
(ref_idsmp,smp_date,address_name,customer_name,comment_sale,status_sup,sale_date,sale_name,sale_code,add_by,add_date,send_sup,delivery_type,type_company,send_admin,create_adm,delivery_date,date_send_key,up_img1,up_img2,up_img3,allwell_ckk,ref_idsale,bill_id,customer_tel,brnp_no,brnp_ckk,crm_ckk,crm_ref,order_id)
values
('".$ref_idsmp."','".$smp_date."','".$address_name."','".$customer_name."','".$comment_sale."','".$status_sup."','".$sale_date."','".$sale_name."','".$sale_code."','".$add_by."','".$add_date."','".$send_sup."','".$delivery_type."','".$type_company."','0','1','".$delivery_date."','".$date_send_key."','".$_FILES['up_img1']['name']."','".$_FILES['up_img2']['name']."','".$_FILES['up_img3']['name']."','1','".$ref_idsale."','".$bill_id."','".$customer_tel."','".$brnp_no."','".$brnp_ckk."','".$crm_ckk."','".$crm_ref."','".$order_id."')";

$qsave=mysqli_query($conn,$save);

if($ref_idsale!=''){

$save56="Update so__main SET smp_ckk='1' where  ref_id ='".$ref_idsale."'";
$qsave56=mysqli_query($conn,$save56);
	
}


$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);
$sale_remark1 = $_POST["sale_remark1"];
$waranty1 = $_POST["waranty1"];



$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$sale_remark2 = $_POST["sale_remark2"];
$waranty2 = $_POST["waranty2"];



$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$sale_remark3 = $_POST["sale_remark3"];
$waranty3 = $_POST["waranty3"];



$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$sale_remark4 = $_POST["sale_remark4"];
$waranty4 = $_POST["waranty4"];



$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$sale_remark5 = $_POST["sale_remark5"];
$waranty5 = $_POST["waranty5"];



$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$sale_remark6 = $_POST["sale_remark6"];
$waranty6 = $_POST["waranty6"];



$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$sale_remark7 = $_POST["sale_remark7"];
$waranty7 = $_POST["waranty7"];




$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$sale_remark8 = $_POST["sale_remark8"];
$waranty8 = $_POST["waranty8"];




$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$sale_remark9 = $_POST["sale_remark9"];
$waranty9 = $_POST["waranty9"];



$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$sale_remark10 = $_POST["sale_remark10"];
$waranty10 = $_POST["waranty10"];


if($product_id1 !==''  ){
	
$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id1."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count1*$objResult31["unit1"];
$unit2 = $sale_count1*$objResult31["unit2"];
$unit3 = $sale_count1*$objResult31["unit3"];
$unit4 = $sale_count1*$objResult31["unit4"];
$unit5 = $sale_count1*$objResult31["unit5"];
$unit6 = $sale_count1*$objResult31["unit6"];
$unit7 = $sale_count1*$objResult31["unit7"];
$unit8 = $sale_count1*$objResult31["unit8"];
$unit9 = $sale_count1*$objResult31["unit9"];
$unit10 =$sale_count1*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
if($id_product1 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product1."','".$id_product1."','".$unit1."','".$unit1."','".$product_price1."','".$sum_amount1."','".$sale_remark1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product2."','".$id_product2."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remark1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product3 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product3."','".$id_product3."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remark1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product4 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product4."','".$id_product4."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remark1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product5."','".$id_product5."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remark1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product6 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product6."','".$id_product6."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remark1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
if($id_product7 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product7."','".$id_product7."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remark1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product8."','".$id_product8."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remark1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product9."','".$id_product9."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remark1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product10."','".$id_product10."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remark1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
	
}else{
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$product_id1."','".$product_id1."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$sum_amount1."','".$sale_remark1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
}
}

if($product_id2 !==''  ){
	
$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id2."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count2*$objResult31["unit1"];
$unit2 = $sale_count2*$objResult31["unit2"];
$unit3 = $sale_count2*$objResult31["unit3"];
$unit4 = $sale_count2*$objResult31["unit4"];
$unit5 = $sale_count2*$objResult31["unit5"];
$unit6 = $sale_count2*$objResult31["unit6"];
$unit7 = $sale_count2*$objResult31["unit7"];
$unit8 = $sale_count2*$objResult31["unit8"];
$unit9 = $sale_count2*$objResult31["unit9"];
$unit10 =$sale_count2*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
if($id_product1 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product1."','".$id_product1."','".$unit1."','".$unit1."','".$product_price2."','".$sum_amount2."','".$sale_remark2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product2."','".$id_product2."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remark2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product3 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product3."','".$id_product3."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remark2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product4 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product4."','".$id_product4."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remark2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product5."','".$id_product5."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remark2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product6 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product6."','".$id_product6."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remark2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
if($id_product7 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product7."','".$id_product7."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remark2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product8."','".$id_product8."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remark2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product9."','".$id_product9."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remark2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product10."','".$id_product10."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remark2."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
	
}else{
$strSQL2 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$product_id2."','".$product_id2."','".$sale_count2."','".$sale_count2."','".$product_price2."','".$sum_amount2."','".$sale_remark2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);

}
}


if($product_id3 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id3."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count3*$objResult31["unit1"];
$unit2 = $sale_count3*$objResult31["unit2"];
$unit3 = $sale_count3*$objResult31["unit3"];
$unit4 = $sale_count3*$objResult31["unit4"];
$unit5 = $sale_count3*$objResult31["unit5"];
$unit6 = $sale_count3*$objResult31["unit6"];
$unit7 = $sale_count3*$objResult31["unit7"];
$unit8 = $sale_count3*$objResult31["unit8"];
$unit9 = $sale_count3*$objResult31["unit9"];
$unit10 =$sale_count3*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
if($id_product1 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product1."','".$id_product1."','".$unit1."','".$unit1."','".$product_price3."','".$sum_amount3."','".$sale_remark3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product2."','".$id_product2."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remark3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product3 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product3."','".$id_product3."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remark3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product4 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product4."','".$id_product4."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remark3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product5."','".$id_product5."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remark3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product6 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product6."','".$id_product6."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remark3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
if($id_product7 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product7."','".$id_product7."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remark3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product8."','".$id_product8."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remark3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product9."','".$id_product9."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remark3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product10."','".$id_product10."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remark3."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
	
}else{	
	
$strSQL3 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$product_id3."','".$product_id3."','".$sale_count3."','".$sale_count3."','".$product_price3."','".$sum_amount3."','".$sale_remark3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);

}
}

if($product_id4 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id4."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count4*$objResult31["unit1"];
$unit2 = $sale_count4*$objResult31["unit2"];
$unit3 = $sale_count4*$objResult31["unit3"];
$unit4 = $sale_count4*$objResult31["unit4"];
$unit5 = $sale_count4*$objResult31["unit5"];
$unit6 = $sale_count4*$objResult31["unit6"];
$unit7 = $sale_count4*$objResult31["unit7"];
$unit8 = $sale_count4*$objResult31["unit8"];
$unit9 = $sale_count4*$objResult31["unit9"];
$unit10 =$sale_count4*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
if($id_product1 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product1."','".$id_product1."','".$unit1."','".$unit1."','".$product_price4."','".$sum_amount4."','".$sale_remark4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product2."','".$id_product2."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remark4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product3 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product3."','".$id_product3."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remark4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product4 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product4."','".$id_product4."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remark4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product5."','".$id_product5."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remark4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product6 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product6."','".$id_product6."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remark4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
if($id_product7 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product7."','".$id_product7."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remark4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product8."','".$id_product8."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remark4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product9."','".$id_product9."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remark4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product10."','".$id_product10."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remark4."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
	
}else{	
	
$strSQL4 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$product_id4."','".$product_id4."','".$sale_count4."','".$sale_count4."','".$product_price4."','".$sum_amount4."','".$sale_remark4."')";
$objQuery4 = mysqli_query($conn,$strSQL4);
}
}


if($product_id5 !==''  ){
	
$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id5."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count5*$objResult31["unit1"];
$unit2 = $sale_count5*$objResult31["unit2"];
$unit3 = $sale_count5*$objResult31["unit3"];
$unit4 = $sale_count5*$objResult31["unit4"];
$unit5 = $sale_count5*$objResult31["unit5"];
$unit6 = $sale_count5*$objResult31["unit6"];
$unit7 = $sale_count5*$objResult31["unit7"];
$unit8 = $sale_count5*$objResult31["unit8"];
$unit9 = $sale_count5*$objResult31["unit9"];
$unit10 =$sale_count5*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
if($id_product1 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product1."','".$id_product1."','".$unit1."','".$unit1."','".$product_price5."','".$sum_amount5."','".$sale_remark5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product2."','".$id_product2."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remark5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product3 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product3."','".$id_product3."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remark5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product4 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product4."','".$id_product4."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remark5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product5."','".$id_product5."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remark5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product6 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product6."','".$id_product6."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remark5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
if($id_product7 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product7."','".$id_product7."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remark5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product8."','".$id_product8."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remark5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product9."','".$id_product9."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remark5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product10."','".$id_product10."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remark5."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
	
}else{		

$strSQL5 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$product_id5."','".$product_id5."','".$sale_count5."','".$sale_count5."','".$product_price5."','".$sum_amount5."','".$sale_remark5."')";

$objQuery5 = mysqli_query($conn,$strSQL5);
}
}


if($product_id6 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id6."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count6*$objResult31["unit1"];
$unit2 = $sale_count6*$objResult31["unit2"];
$unit3 = $sale_count6*$objResult31["unit3"];
$unit4 = $sale_count6*$objResult31["unit4"];
$unit5 = $sale_count6*$objResult31["unit5"];
$unit6 = $sale_count6*$objResult31["unit6"];
$unit7 = $sale_count6*$objResult31["unit7"];
$unit8 = $sale_count6*$objResult31["unit8"];
$unit9 = $sale_count6*$objResult31["unit9"];
$unit10 =$sale_count6*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
if($id_product1 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product1."','".$id_product1."','".$unit1."','".$unit1."','".$product_price6."','".$sum_amount6."','".$sale_remark6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product2."','".$id_product2."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remark6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product3 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product3."','".$id_product3."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remark6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product4 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product4."','".$id_product4."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remark6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product5."','".$id_product5."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remark6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product6 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product6."','".$id_product6."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remark6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
if($id_product7 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product7."','".$id_product7."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remark6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product8."','".$id_product8."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remark6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product9."','".$id_product9."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remark6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product10."','".$id_product10."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remark6."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
	
}else{			
	
$strSQL6 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$product_id6."','".$product_id6."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$sum_amount6."','".$sale_remark6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);
}
}


if($product_id7 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id7."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count7*$objResult31["unit1"];
$unit2 = $sale_count7*$objResult31["unit2"];
$unit3 = $sale_count7*$objResult31["unit3"];
$unit4 = $sale_count7*$objResult31["unit4"];
$unit5 = $sale_count7*$objResult31["unit5"];
$unit6 = $sale_count7*$objResult31["unit6"];
$unit7 = $sale_count7*$objResult31["unit7"];
$unit8 = $sale_count7*$objResult31["unit8"];
$unit9 = $sale_count7*$objResult31["unit9"];
$unit10 =$sale_count7*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
if($id_product1 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product1."','".$id_product1."','".$unit1."','".$unit1."','".$product_price7."','".$sum_amount7."','".$sale_remark7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product2."','".$id_product2."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remark7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product3 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product3."','".$id_product3."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remark7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product4 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product4."','".$id_product4."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remark7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product5."','".$id_product5."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remark7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product6 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product6."','".$id_product6."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remark7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
if($id_product7 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product7."','".$id_product7."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remark7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product8."','".$id_product8."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remark7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product9."','".$id_product9."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remark7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product10."','".$id_product10."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remark7."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
	
}else{				
	
$strSQL7 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$product_id7."','".$product_id7."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$sum_amount7."','".$sale_remark7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);
}
}


if($product_id8 !==''  ){
	
$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id8."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count8*$objResult31["unit1"];
$unit2 = $sale_count8*$objResult31["unit2"];
$unit3 = $sale_count8*$objResult31["unit3"];
$unit4 = $sale_count8*$objResult31["unit4"];
$unit5 = $sale_count8*$objResult31["unit5"];
$unit6 = $sale_count8*$objResult31["unit6"];
$unit7 = $sale_count8*$objResult31["unit7"];
$unit8 = $sale_count8*$objResult31["unit8"];
$unit9 = $sale_count8*$objResult31["unit9"];
$unit10 =$sale_count8*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
if($id_product1 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product1."','".$id_product1."','".$unit1."','".$unit1."','".$product_price8."','".$sum_amount8."','".$sale_remark8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product2."','".$id_product2."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remark8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product3 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product3."','".$id_product3."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remark8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product4 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product4."','".$id_product4."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remark8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product5."','".$id_product5."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remark8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product6 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product6."','".$id_product6."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remark8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
if($id_product7 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product7."','".$id_product7."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remark8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product8."','".$id_product8."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remark8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product9."','".$id_product9."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remark8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product10."','".$id_product10."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remark8."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
	
}else{				

$strSQL8 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$product_id8."','".$product_id8."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$sum_amount8."','".$sale_remark8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);
}
}


if($product_id9 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id9."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count9*$objResult31["unit1"];
$unit2 = $sale_count9*$objResult31["unit2"];
$unit3 = $sale_count9*$objResult31["unit3"];
$unit4 = $sale_count9*$objResult31["unit4"];
$unit5 = $sale_count9*$objResult31["unit5"];
$unit6 = $sale_count9*$objResult31["unit6"];
$unit7 = $sale_count9*$objResult31["unit7"];
$unit8 = $sale_count9*$objResult31["unit8"];
$unit9 = $sale_count9*$objResult31["unit9"];
$unit10 =$sale_count9*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
if($id_product1 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product1."','".$id_product1."','".$unit1."','".$unit1."','".$product_price9."','".$sum_amount9."','".$sale_remark9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product2."','".$id_product2."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remark9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product3 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product3."','".$id_product3."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remark9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product4 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product4."','".$id_product4."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remark9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product5."','".$id_product5."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remark9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product6 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product6."','".$id_product6."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remark9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
if($id_product7 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product7."','".$id_product7."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remark9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product8."','".$id_product8."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remark9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product9."','".$id_product9."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remark9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product10."','".$id_product10."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remark9."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
	
}else{				

$strSQL9 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$product_id9."','".$product_id9."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$sum_amount9."','".$sale_remark9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);
}
}


if($product_id10 !==''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id10."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["id_product1"];
$id_product2 =$objResult31["id_product2"];
$id_product3 =$objResult31["id_product3"];
$id_product4 =$objResult31["id_product4"];
$id_product5 =$objResult31["id_product5"];
$id_product6 =$objResult31["id_product6"];
$id_product7 =$objResult31["id_product7"];
$id_product8 =$objResult31["id_product8"];
$id_product9 =$objResult31["id_product9"];
$id_product10 =$objResult31["id_product10"];
	
$unit1 = $sale_count10*$objResult31["unit1"];
$unit2 = $sale_count10*$objResult31["unit2"];
$unit3 = $sale_count10*$objResult31["unit3"];
$unit4 = $sale_count10*$objResult31["unit4"];
$unit5 = $sale_count10*$objResult31["unit5"];
$unit6 = $sale_count10*$objResult31["unit6"];
$unit7 = $sale_count10*$objResult31["unit7"];
$unit8 = $sale_count10*$objResult31["unit8"];
$unit9 = $sale_count10*$objResult31["unit9"];
$unit10 =$sale_count10*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
if($id_product1 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product1."','".$id_product1."','".$unit1."','".$unit1."','".$product_price10."','".$sum_amount10."','".$sale_remark10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

if($id_product2 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product2."','".$id_product2."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remark10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product3 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product3."','".$id_product3."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remark10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product4 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product4."','".$id_product4."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remark10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product5."','".$id_product5."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remark10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		

if($id_product6 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product6."','".$id_product6."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remark10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
if($id_product7 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product7."','".$id_product7."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remark10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product8."','".$id_product8."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remark10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product9."','".$id_product9."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remark10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
	
$strSQL1 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$id_product10."','".$id_product10."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remark10."')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}		
	
	
}else{				
	

$strSQL10 = "insert into hos__subsmp
(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark)
values ('".$ref_idsmp."','".$product_id10."','".$product_id10."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$sum_amount10."','".$sale_remark10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);
}
}




$start_date =$_POST["start_date"];
 $between_date =$_POST["between_date"];
 $start_time=$_POST["start_time"];
 $end_time=$_POST["end_time"];
 $status=$_POST["status"];
	
 if ($_POST["start_date"]!=''){
		$start_date =$_POST["start_date"];
	}else{
		$start_date='0000-00-00';
	}
	
	if ($_POST['fix_datetime']!=''){
		$fix_date=$_POST['fix_datetime'];
	}else{
		$fix_date='0';
	}
	
	if ($_POST['no_money']!=''){
        $no_price=$_POST['no_money'];
	}else{
		$no_price='0';
	}
	if ($_POST['call_customer']!=''){
		 $call_customer=$_POST['call_customer'];
	}else{
		$call_customer='0';
	}
	if ($_POST['credit_card']!=''){
		 $credit=$_POST['credit_card'];
	}else{
		$credit='0';
	}
	if ($_POST['call_back']!=''){
		 $call_employee=$_POST['call_back'];
	}else{
		$call_employee='0';
	}
	
	if ($_POST['cash']!=''){
		 $chash=$_POST['cash'];
	}else{
		$chash='0';
	}
	if ($_POST['check_paper']!=''){
	 $check_peper=$_POST['check_paper'];
	}else{
		$check_peper='0';
	}
	if ($_POST['check_paper']!=''){
		$check_peper=$_POST['check_paper'];
	}else{
		$check_peper='0';
	}
	if ($_POST['bill']!=''){
		 $bill=$_POST['bill'];
	}else{
		$bill='0';
	}
	if ($_POST['want_bus']!=''){
	$want_bus=$_POST['want_bus'];
	}else{
		$want_bus='0';
	}
	if ($_POST['tran']!=''){
		 $tran=$_POST["tran"];
	}else{
		$tran='0';
	}
	if ($_POST['more']!=''){
		 $check_detail=$_POST["more"];
	}else{
		$check_detail='0';
	}
	
		if ($_POST['dep']!=''){
		  $dep=$_POST["dep"];
	}else{
		$dep='0';
	}

	
 $department=$_POST["department_name"];
	$type_customer=$_POST["customer_typename"];
	
 
 $customer_name1=$_POST["customer_name1"];
 $customer_tel1 =$_POST["customer_tel1"];
 $address_name1=$_POST["address_name1"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
	
 $on_time = $_POST["on_time"];	
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
 $product_name=$_POST["product"];
 $product_sn=$_POST["product_sn"];
 $unit_credit=$_POST["unit_credit"];
 $price=$_POST["unit_cash"];
 $employee_name=$_POST["employee_name"];
 $employee_tel=$_POST["employee_tel"];
 $add_by=$_POST["add_by"];
 $description=$_POST["description"];
 $havemap=$_POST['have_map'];
$unit_check=$_POST["unit_check"];
$unit_bill=$_POST["unit_bill"];
$unit_tran=$_POST["unit_tran"];
$department_show = $_POST["department_show"];
$unit_check1 = str_replace(',', '', $unit_check);
$unit_bill1 = str_replace(',', '', $unit_bill);
$dept =$_POST["dept"];
$status_comment =$_POST["status_comment"];
$type_company = $_POST["customer_typename"];
$address_1 = $_POST["address_1"];	


if($delivery_type=='2'){
	
$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1) 

values('".$ref_idsmp."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name1."','".$customer_tel1."','".$address_name1."','".$address_send."','".$want_bus."','".$product_name."','".$ref_idsmp."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."')";


$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());
}




	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminsmp1_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
  } else {
   echo "Cannot";
  }
}
	}


