<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$company = $_POST["company"];
$date_br = $_POST["date_br"];
$customer = $_POST["customer"];
$customer_id = $_POST["customer_id"];
$address = $_POST["address"];
$sale_comment = $_POST["sale_comment"];
$sn_ckk = $_POST["sn_ckk"];
$sn = $_POST["sn"];
$cm_no = $_POST["cm_no"];
$objective = $_POST["objective"];
$objective_des1 = $_POST["objective_des1"];
$objective_des2 = $_POST["objective_des2"];
$objective_des4 = $_POST["objective_des4"];
$objective_des5 = $_POST["objective_des5"];

$return_date_bet = $_POST["return_date_bet"];
$returns = $_POST["returns"];
$que_ckk = $_POST["que_ckk"];
$returns_date = $_POST["returns_date"];
$returns_time = $_POST["returns_time"];
$returns_name = $_POST["returns_name"];
$returns_address = $_POST["returns_address"];
$returns_contact = $_POST["returns_contact"];
$status_doc = "Approve";
$delivery_name = $_POST["address_name"];
$delivery_type = $_POST["delivery_type"];
$delivery_date = $_POST["start_date"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$delivery_time = "$start_time $end_time";
$delivery_address = $_POST["address_send"];
$delivery_contact = $_POST["customer_name"];
$delivery_tel = $_POST["customer_tel"];
$date_send_key  = $_POST["between_date"];
$iv_no = "";

$sale_date= date('Y-m-d');
$approve_date= date('Y-m-d');
$approve_time = date("H:i:s");
$sale =  $_SESSION['name'];

$sale_code = $_POST["sale_code"];
$name =  $_SESSION['name'];
$em_id =  $_SESSION['emid'];
$approve_code = 'SUP_EN';
$approve  = 'ศิรวิทย์';



$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = $_POST["add_by"];

	
	move_uploaded_file($_FILES['slip1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip1']['name']));
	move_uploaded_file($_FILES['slip2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip2']['name']));
	move_uploaded_file($_FILES['slip3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip3']['name']));
	move_uploaded_file($_FILES['slip4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip4']['name']));
	move_uploaded_file($_FILES['slip5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip5']['name']));
	
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id_br) AS MAXID FROM hos__br ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = substr($rs['MAXID'], -5);
$maxId3 = substr($rs['MAXID'],-9);

$maxId1 = substr($maxId3,0,-5);

$so = "BR";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -5);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "00001"; 
$nextId = $yearMonth.$maxId1;

}


$so = "BR";
$ref_id_br ="$so$nextId";


$head_1 = $_POST["head_1"];	
$ref_1 = $_POST["ref_1"];	
$ref_2 = $_POST["ref_2"];	
$ref_3 = $_POST["ref_3"];	
$ref_4 = $_POST["ref_4"];	
$ref_5 = $_POST["ref_5"];	
$ref_6 = $_POST["ref_6"];	
$ref_7 = $_POST["ref_7"];	
$ref_8 = $_POST["ref_8"];	
$ref_9 = $_POST["ref_9"];	
$ref_10 = $_POST["ref_10"];	
$ref_11 = $_POST["ref_11"];
$ref_des = $_POST["ref_des"];
$type_breng = $_POST["type_breng"]; 



$save="insert into hos__br
(company,ref_id_br,date_br,customer,customer_id,address,sale_comment,sn_ckk,sn,objective,objective_des1,objective_des2,objective_des4,objective_des5,returns,returns_date,returns_time,returns_name,returns_address,returns_contact,status_doc,delivery_name,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,date_send_key,sale_date,sale,sale_code,add_date,add_by,approve_date,approve,approve_code,send_sup,return_date_bet,slip1,slip2,slip3,slip4,slip5,iv_no,approve_time,que_ckk,cm_no,type_breng)
values
('".$company."','".$ref_id_br."','".$date_br."','".$customer."','".$customer_id."','".$address."','".$sale_comment."','".$sn_ckk."','".$sn."','".$objective."','".$objective_des1."','".$objective_des2."','".$objective_des4."','".$objective_des5."','".$returns."','".$returns_date."','".$returns_time."','".$returns_name."','".$returns_address."','".$returns_contact."','".$status_doc."','".$delivery_name."','".$delivery_type."','".$delivery_date."','".$delivery_time."','".$delivery_address."','".$delivery_contact."','".$delivery_tel."','".$date_send_key."','".$sale_date."','".$sale."','".$sale_code."','".$add_date."','".$add_by."','".$approve_date."','".$approve."','".$approve_code."','1','".$return_date_bet."','".$slip1."','".$slip2."','".$slip3."','".$slip4."','".$slip5."','".$iv_no."','".$approve_time."','".$que_ckk."','".$cm_no."','".$type_breng."')";


$qsave=mysqli_query($conn,$save);
	

$save56="insert into tb_other_bill
(ref_id,head_1,ref_1,ref_2,ref_3,ref_4,ref_5,ref_6,ref_7,ref_8,ref_9,ref_10,ref_11,ref_des)
values
('".$ref_id_br."','".$head_1."','".$ref_1."','".$ref_2."','".$ref_3."','".$ref_4."','".$ref_5."','".$ref_6."','".$ref_7."','".$ref_8."','".$ref_9."','".$ref_10."','".$ref_11."','".$ref_des."')";
$qsave56=mysqli_query($conn,$save56);	
	
$warranty1 = $_POST["warranty1"];	
$warranty2 = $_POST["warranty2"];	
$warranty3 = $_POST["warranty3"];	
$warranty4 = $_POST["warranty4"];	
$warranty5 = $_POST["warranty5"];	
$warranty6 = $_POST["warranty6"];	
$warranty7 = $_POST["warranty7"];	
$warranty8 = $_POST["warranty8"];	
$warranty9 = $_POST["warranty9"];	
$warranty10 = $_POST["warranty10"];	


$product_name1 = $_POST["product_name1"];
$unit_name1 = $_POST["unit_name1"];
$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);
$br_period1 = $_POST["br_period1"];
	
if($_POST["product_code1"]!=''){
$product_code1 = $_POST["product_code1"];
}else if($_POST["product_codet1"]!=''){
$product_code1 = $_POST["product_codet1"];
}else{
$product_code1 = $_POST["product_c1"];	
}


$product_name2 = $_POST["product_name2"];
$unit_name2 = $_POST["unit_name2"];
$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sale_remarkk2 = $_POST["sale_remarkk2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$br_period2 = $_POST["br_period2"];
	
if($_POST["product_code2"]!=''){
$product_code2 = $_POST["product_code2"];
}else if($_POST["product_codet2"]!=''){
$product_code2 = $_POST["product_codet2"];
}else{
$product_code2 = $_POST["product_c2"];	
}
	
	
$product_name3 = $_POST["product_name3"];
$unit_name3 = $_POST["unit_name3"];
$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$br_period3 = $_POST["br_period3"];
	
if($_POST["product_code3"]!=''){
$product_code3 = $_POST["product_code3"];
}else if($_POST["product_codet3"]!=''){
$product_code3 = $_POST["product_codet3"];
}else{
$product_code3 = $_POST["product_c3"];	
}	

$product_name4 = $_POST["product_name4"];
$unit_name4 = $_POST["unit_name4"];	
$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$br_period4 = $_POST["br_period4"];

if($_POST["product_code4"]!=''){
$product_code4 = $_POST["product_code4"];
}else if($_POST["product_codet4"]!=''){
$product_code4 = $_POST["product_codet4"];
}else{
$product_code4 = $_POST["product_c4"];	
}
	


$product_name5 = $_POST["product_name5"];
$unit_name5 = $_POST["unit_name5"];
$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$br_period5 = $_POST["br_period5"];
	
if($_POST["product_code5"]!=''){
$product_code5 = $_POST["product_code5"];
}else if($_POST["product_codet5"]!=''){
$product_code5 = $_POST["product_codet5"];
}else{
$product_code5 = $_POST["product_c5"];	
}	

$product_name6 = $_POST["product_name6"];
$unit_name6 = $_POST["unit_name6"];
$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$br_period6 = $_POST["br_period6"];
	
if($_POST["product_code6"]!=''){
$product_code6 = $_POST["product_code6"];
}else if($_POST["product_codet6"]!=''){
$product_code6 = $_POST["product_codet6"];
}else{
$product_code6 = $_POST["product_c6"];	
}		
	
	
$product_name7 = $_POST["product_name7"];
$unit_name7 = $_POST["unit_name7"];
$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$br_period7 = $_POST["br_period7"];

if($_POST["product_code7"]!=''){
$product_code7 = $_POST["product_code7"];
}else if($_POST["product_codet7"]!=''){
$product_code7 = $_POST["product_codet7"];
}else{
$product_code7 = $_POST["product_c7"];	
}	
	
	
	
$product_name8 = $_POST["product_name8"];
$unit_name8 = $_POST["unit_name8"];
$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$br_period8 = $_POST["br_period8"];
	
if($_POST["product_code8"]!=''){
$product_code8 = $_POST["product_code8"];
}else if($_POST["product_codet8"]!=''){
$product_code8 = $_POST["product_codet8"];
}else{
$product_code8 = $_POST["product_c8"];	
}		
	

$product_name9 = $_POST["product_name9"];
$unit_name9 = $_POST["unit_name9"];
$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$br_period9 = $_POST["br_period9"];

if($_POST["product_code9"]!=''){
$product_code9 = $_POST["product_code9"];
}else if($_POST["product_codet9"]!=''){
$product_code9 = $_POST["product_codet9"];
}else{
$product_code9 = $_POST["product_c9"];	
}	
	

$product_name10 = $_POST["product_name10"];
$unit_name10 = $_POST["unit_name10"];
$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$br_period10 = $_POST["br_period10"];

if($_POST["product_code10"]!=''){
$product_code10 = $_POST["product_code10"];
}else if($_POST["product_codet10"]!=''){
$product_code10 = $_POST["product_codet10"];
}else{
$product_code10 = $_POST["product_c10"];	
}	




if($product_id1 !==''  ){
	
$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code1."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["product_id1"];
$id_product2 =$objResult31["product_id2"];
$id_product3 =$objResult31["product_id3"];
$id_product4 =$objResult31["product_id4"];
$id_product5 =$objResult31["product_id5"];
$id_product6 =$objResult31["product_id6"];
$id_product7 =$objResult31["product_id7"];
$id_product8 =$objResult31["product_id8"];
$id_product9 =$objResult31["product_id9"];
$id_product10 =$objResult31["product_id10"];
	
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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$id_product1."','".$id_product1."','".$br_period1."','".$warranty1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk1."','".$id_product2."','".$id_product2."','".$br_period1."','".$warranty1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk1."','".$id_product3."','".$id_product3."','".$br_period1."','".$warranty1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk1."','".$id_product4."','".$id_product4."','".$br_period1."','".$warranty1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk1."','".$id_product5."','".$id_product5."','".$br_period1."','".$warranty1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk1."','".$id_product6."','".$id_product6."','".$br_period1."','".$warranty1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk1."','".$id_product7."','".$id_product7."','".$br_period1."','".$warranty1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk1."','".$id_product8."','".$id_product8."','".$br_period1."','".$warranty1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk1."','".$id_product9."','".$id_product9."','".$br_period1."','".$warranty1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk1."','".$id_product10."','".$id_product10."','".$br_period1."','".$warranty1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	

	
	
}else{
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$product_id1."','".$product_id1."','".$br_period1."','".$warranty1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
}
	
$sql = "SELECT have_sn   FROM tb_product where product_ID ='".$product_id1."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["have_sn"]=='1'){
	$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='".$product_id1."' ";
   $objQuery91 = mysqli_query($conn,$strSQL91);
		
	}
	


}


if($product_id2 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code2."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["product_id1"];
$id_product2 =$objResult31["product_id2"];
$id_product3 =$objResult31["product_id3"];
$id_product4 =$objResult31["product_id4"];
$id_product5 =$objResult31["product_id5"];
$id_product6 =$objResult31["product_id6"];
$id_product7 =$objResult31["product_id7"];
$id_product8 =$objResult31["product_id8"];
$id_product9 =$objResult31["product_id9"];
$id_product10 =$objResult31["product_id10"];
	
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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$id_product1."','".$id_product1."','".$br_period2."','".$warranty2."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk2."','".$id_product2."','".$id_product2."','".$br_period2."','".$warranty2."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk2."','".$id_product3."','".$id_product3."','".$br_period2."','".$warranty2."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk2."','".$id_product4."','".$id_product4."','".$br_period2."','".$warranty2."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk2."','".$id_product5."','".$id_product5."','".$br_period2."','".$warranty2."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk2."','".$id_product6."','".$id_product6."','".$br_period2."','".$warranty2."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk2."','".$id_product7."','".$id_product7."','".$br_period2."','".$warranty2."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk2."','".$id_product8."','".$id_product8."','".$br_period2."','".$warranty2."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk2."','".$id_product9."','".$id_product9."','".$br_period2."','".$warranty2."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk2."','".$id_product10."','".$id_product10."','".$br_period2."','".$warranty2."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{	
	
$strSQL2 ="insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$sale_count2."','".$sale_count2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$product_id2."','".$product_id2."','".$br_period2."','".$warranty2."')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
$sql = "SELECT have_sn   FROM tb_product where product_ID ='".$product_id2."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["have_sn"]=='1'){
	$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='".$product_id2."' ";
   $objQuery91 = mysqli_query($conn,$strSQL91);
		
	}

}


if($product_id3 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code3."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["product_id1"];
$id_product2 =$objResult31["product_id2"];
$id_product3 =$objResult31["product_id3"];
$id_product4 =$objResult31["product_id4"];
$id_product5 =$objResult31["product_id5"];
$id_product6 =$objResult31["product_id6"];
$id_product7 =$objResult31["product_id7"];
$id_product8 =$objResult31["product_id8"];
$id_product9 =$objResult31["product_id9"];
$id_product10 =$objResult31["product_id10"];
	
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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$id_product1."','".$id_product1."','".$br_period3."','".$warranty3."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk3."','".$id_product2."','".$id_product2."','".$br_period3."','".$warranty3."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk3."','".$id_product3."','".$id_product3."','".$br_period3."','".$warranty3."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk3."','".$id_product4."','".$id_product4."','".$br_period3."','".$warranty3."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk3."','".$id_product5."','".$id_product5."','".$br_period3."','".$warranty3."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk3."','".$id_product6."','".$id_product6."','".$br_period3."','".$warranty3."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk3."','".$id_product7."','".$id_product7."','".$br_period3."','".$warranty3."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk3."','".$id_product8."','".$id_product8."','".$br_period3."','".$warranty3."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk3."','".$id_product9."','".$id_product9."','".$br_period3."','".$warranty3."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk3."','".$id_product10."','".$id_product10."','".$br_period3."','".$warranty3."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{		
	
$strSQL3 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$sale_count3."','".$sale_count3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$product_id3."','".$product_id3."','".$br_period3."','".$warranty3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);
}
	
$sql = "SELECT have_sn   FROM tb_product where product_ID ='".$product_id3."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["have_sn"]=='1'){
	$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='".$product_id3."' ";
   $objQuery91 = mysqli_query($conn,$strSQL91);
		
	}	
	
}


if($product_id4 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code4."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["product_id1"];
$id_product2 =$objResult31["product_id2"];
$id_product3 =$objResult31["product_id3"];
$id_product4 =$objResult31["product_id4"];
$id_product5 =$objResult31["product_id5"];
$id_product6 =$objResult31["product_id6"];
$id_product7 =$objResult31["product_id7"];
$id_product8 =$objResult31["product_id8"];
$id_product9 =$objResult31["product_id9"];
$id_product10 =$objResult31["product_id10"];
	
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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$id_product1."','".$id_product1."','".$br_period4."','".$warranty4."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk4."','".$id_product2."','".$id_product2."','".$br_period4."','".$warranty4."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk4."','".$id_product3."','".$id_product3."','".$br_period4."','".$warranty4."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk4."','".$id_product4."','".$id_product4."','".$br_period4."','".$warranty4."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk4."','".$id_product5."','".$id_product5."','".$br_period4."','".$warranty4."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk4."','".$id_product6."','".$id_product6."','".$br_period4."','".$warranty4."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk4."','".$id_product7."','".$id_product7."','".$br_period4."','".$warranty4."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk4."','".$id_product8."','".$id_product8."','".$br_period4."','".$warranty4."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk4."','".$id_product9."','".$id_product9."','".$br_period4."','".$warranty4."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk4."','".$id_product10."','".$id_product10."','".$br_period4."','".$warranty4."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{		
		
	
$strSQL4 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$sale_count4."','".$sale_count4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$product_id4."','".$product_id4."','".$br_period4."','".$warranty4."')";
$objQuery4 = mysqli_query($conn,$strSQL4);
}
	
$sql = "SELECT have_sn   FROM tb_product where product_ID ='".$product_id4."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["have_sn"]=='1'){
	$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='".$product_id4."' ";
   $objQuery91 = mysqli_query($conn,$strSQL91);
		
	}		
}


if($product_id5 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code5."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["product_id1"];
$id_product2 =$objResult31["product_id2"];
$id_product3 =$objResult31["product_id3"];
$id_product4 =$objResult31["product_id4"];
$id_product5 =$objResult31["product_id5"];
$id_product6 =$objResult31["product_id6"];
$id_product7 =$objResult31["product_id7"];
$id_product8 =$objResult31["product_id8"];
$id_product9 =$objResult31["product_id9"];
$id_product10 =$objResult31["product_id10"];
	
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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$id_product1."','".$id_product1."','".$br_period5."','".$warranty5."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk5."','".$id_product2."','".$id_product2."','".$br_period5."','".$warranty5."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk5."','".$id_product3."','".$id_product3."','".$br_period5."','".$warranty5."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk5."','".$id_product4."','".$id_product4."','".$br_period5."','".$warranty5."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk5."','".$id_product5."','".$id_product5."','".$br_period5."','".$warranty5."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk5."','".$id_product6."','".$id_product6."','".$br_period5."','".$warranty5."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk5."','".$id_product7."','".$id_product7."','".$br_period5."','".$warranty5."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk5."','".$id_product8."','".$id_product8."','".$br_period5."','".$warranty5."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk5."','".$id_product9."','".$id_product9."','".$br_period5."','".$warranty5."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk5."','".$id_product10."','".$id_product10."','".$br_period5."','".$warranty5."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{		
			
	
$strSQL5 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$sale_count5."','".$sale_count5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$product_id5."','".$product_id5."','".$br_period5."','".$warranty5."')";
$objQuery5 = mysqli_query($conn,$strSQL5);
}	
	
$sql = "SELECT have_sn   FROM tb_product where product_ID ='".$product_id5."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["have_sn"]=='1'){
	$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='".$product_id5."' ";
   $objQuery91 = mysqli_query($conn,$strSQL91);
		
	}	

}


if($product_id6 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code6."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["product_id1"];
$id_product2 =$objResult31["product_id2"];
$id_product3 =$objResult31["product_id3"];
$id_product4 =$objResult31["product_id4"];
$id_product5 =$objResult31["product_id5"];
$id_product6 =$objResult31["product_id6"];
$id_product7 =$objResult31["product_id7"];
$id_product8 =$objResult31["product_id8"];
$id_product9 =$objResult31["product_id9"];
$id_product10 =$objResult31["product_id10"];
	
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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$id_product1."','".$id_product1."','".$br_period6."','".$warranty6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk6."','".$id_product2."','".$id_product2."','".$br_period6."','".$warranty6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk6."','".$id_product3."','".$id_product3."','".$br_period6."','".$warranty6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk6."','".$id_product4."','".$id_product4."','".$br_period6."','".$warranty6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk6."','".$id_product5."','".$id_product5."','".$br_period6."','".$warranty6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk6."','".$id_product6."','".$id_product6."','".$br_period6."','".$warranty6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk6."','".$id_product7."','".$id_product7."','".$br_period6."','".$warranty6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk6."','".$id_product8."','".$id_product8."','".$br_period6."','".$warranty6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk6."','".$id_product9."','".$id_product9."','".$br_period6."','".$warranty6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk6."','".$id_product10."','".$id_product10."','".$br_period6."','".$warranty6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{			


$strSQL6 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$product_id6."','".$product_id6."','".$br_period6."','".$warranty6."')";
$objQuery6 = mysqli_query($conn,$strSQL6);
}	
	
$sql = "SELECT have_sn   FROM tb_product where product_ID ='".$product_id6."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["have_sn"]=='1'){
	$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='".$product_id6."' ";
   $objQuery91 = mysqli_query($conn,$strSQL91);
		
	}	

}


if($product_id7 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code7."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["product_id1"];
$id_product2 =$objResult31["product_id2"];
$id_product3 =$objResult31["product_id3"];
$id_product4 =$objResult31["product_id4"];
$id_product5 =$objResult31["product_id5"];
$id_product6 =$objResult31["product_id6"];
$id_product7 =$objResult31["product_id7"];
$id_product8 =$objResult31["product_id8"];
$id_product9 =$objResult31["product_id9"];
$id_product10 =$objResult31["product_id10"];
	
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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$id_product1."','".$id_product1."','".$br_period7."','".$warranty7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk7."','".$id_product2."','".$id_product2."','".$br_period7."','".$warranty7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk7."','".$id_product3."','".$id_product3."','".$br_period7."','".$warranty7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk7."','".$id_product4."','".$id_product4."','".$br_period7."','".$warranty7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk7."','".$id_product5."','".$id_product5."','".$br_period7."','".$warranty7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk7."','".$id_product6."','".$id_product6."','".$br_period7."','".$warranty7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk7."','".$id_product7."','".$id_product7."','".$br_period7."','".$warranty7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk7."','".$id_product8."','".$id_product8."','".$br_period7."','".$warranty7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk7."','".$id_product9."','".$id_product9."','".$br_period7."','".$warranty7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk7."','".$id_product10."','".$id_product10."','".$br_period7."','".$warranty7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{			
	

$strSQL7 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$product_id7."','".$product_id7."','".$br_period7."','".$warranty7."')";
$objQuery7 = mysqli_query($conn,$strSQL7);
}	
	
$sql = "SELECT have_sn   FROM tb_product where product_ID ='".$product_id7."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["have_sn"]=='1'){
	$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='".$product_id7."' ";
   $objQuery91 = mysqli_query($conn,$strSQL91);
		
	}	

}


if($product_id8 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code8."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["product_id1"];
$id_product2 =$objResult31["product_id2"];
$id_product3 =$objResult31["product_id3"];
$id_product4 =$objResult31["product_id4"];
$id_product5 =$objResult31["product_id5"];
$id_product6 =$objResult31["product_id6"];
$id_product7 =$objResult31["product_id7"];
$id_product8 =$objResult31["product_id8"];
$id_product9 =$objResult31["product_id9"];
$id_product10 =$objResult31["product_id10"];
	
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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$id_product1."','".$id_product1."','".$br_period8."','".$warranty8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk8."','".$id_product2."','".$id_product2."','".$br_period8."','".$warranty8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk8."','".$id_product3."','".$id_product3."','".$br_period8."','".$warranty8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk8."','".$id_product4."','".$id_product4."','".$br_period8."','".$warranty8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk8."','".$id_product5."','".$id_product5."','".$br_period8."','".$warranty8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk8."','".$id_product6."','".$id_product6."','".$br_period8."','".$warranty8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk8."','".$id_product7."','".$id_product7."','".$br_period8."','".$warranty8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk8."','".$id_product8."','".$id_product8."','".$br_period8."','".$warranty8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk8."','".$id_product9."','".$id_product9."','".$br_period8."','".$warranty8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk8."','".$id_product10."','".$id_product10."','".$br_period8."','".$warranty8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{				

$strSQL8 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$product_id8."','".$product_id8."','".$br_period8."','".$warranty8."')";
$objQuery8 = mysqli_query($conn,$strSQL8);
}
	
$sql = "SELECT have_sn   FROM tb_product where product_ID ='".$product_id8."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["have_sn"]=='1'){
	$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='".$product_id8."' ";
   $objQuery91 = mysqli_query($conn,$strSQL91);
		
	}	

}



if($product_id9 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code9."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["product_id1"];
$id_product2 =$objResult31["product_id2"];
$id_product3 =$objResult31["product_id3"];
$id_product4 =$objResult31["product_id4"];
$id_product5 =$objResult31["product_id5"];
$id_product6 =$objResult31["product_id6"];
$id_product7 =$objResult31["product_id7"];
$id_product8 =$objResult31["product_id8"];
$id_product9 =$objResult31["product_id9"];
$id_product10 =$objResult31["product_id10"];
	
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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$id_product1."','".$id_product1."','".$br_period9."','".$warranty9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk9."','".$id_product2."','".$id_product2."','".$br_period9."','".$warranty9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk9."','".$id_product3."','".$id_product3."','".$br_period9."','".$warranty9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk9."','".$id_product4."','".$id_product4."','".$br_period9."','".$warranty9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk9."','".$id_product5."','".$id_product5."','".$br_period9."','".$warranty9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk9."','".$id_product6."','".$id_product6."','".$br_period9."','".$warranty9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk9."','".$id_product7."','".$id_product7."','".$br_period9."','".$warranty9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk9."','".$id_product8."','".$id_product8."','".$br_period9."','".$warranty9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk9."','".$id_product9."','".$id_product9."','".$br_period9."','".$warranty9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk9."','".$id_product10."','".$id_product10."','".$br_period9."','".$warranty9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{				
	

$strSQL9 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$product_id9."','".$product_id9."','".$br_period9."','".$warranty9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);
}	
	
$sql = "SELECT have_sn   FROM tb_product where product_ID ='".$product_id9."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["have_sn"]=='1'){
	$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='".$product_id9."' ";
   $objQuery91 = mysqli_query($conn,$strSQL91);
		
	}	

}


if($product_id10 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code10."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$id_product1 =$objResult31["product_id1"];
$id_product2 =$objResult31["product_id2"];
$id_product3 =$objResult31["product_id3"];
$id_product4 =$objResult31["product_id4"];
$id_product5 =$objResult31["product_id5"];
$id_product6 =$objResult31["product_id6"];
$id_product7 =$objResult31["product_id7"];
$id_product8 =$objResult31["product_id8"];
$id_product9 =$objResult31["product_id9"];
$id_product10 =$objResult31["product_id10"];
	
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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$id_product1."','".$id_product1."','".$br_period10."','".$warranty10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk10."','".$id_product2."','".$id_product2."','".$br_period10."','".$warranty10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk10."','".$id_product3."','".$id_product3."','".$br_period10."','".$warranty10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk10."','".$id_product4."','".$id_product4."','".$br_period10."','".$warranty10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk10."','".$id_product5."','".$id_product5."','".$br_period10."','".$warranty10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk10."','".$id_product6."','".$id_product6."','".$br_period10."','".$warranty10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk10."','".$id_product7."','".$id_product7."','".$br_period10."','".$warranty10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk10."','".$id_product8."','".$id_product8."','".$br_period10."','".$warranty10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk10."','".$id_product9."','".$id_product9."','".$br_period10."','".$warranty10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk10."','".$id_product10."','".$id_product10."','".$br_period10."','".$warranty10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{				
		

$strSQL10 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('".$ref_id_br."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$product_id10."','".$product_id10."','".$br_period10."','".$warranty10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);
}	
	
$sql = "SELECT have_sn   FROM tb_product where product_ID ='".$product_id10."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["have_sn"]=='1'){
	$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='".$product_id10."' ";
   $objQuery91 = mysqli_query($conn,$strSQL91);
		
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
 
	if($company=='3'){
 $type_company='ออลล์เวล ไลฟ์ บจก.';
	}else if($company=='4'){
	$type_company='โนเบิล เมด บจก.';	
	}
	
 $customer_name=$_POST["customer_name"];
 $customer_tel=$_POST["customer_tel"];
 $address_name=$_POST["address_name"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
	
$on_time =$_POST["on_time"];
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
	
 $product_name = "ส่ง $product_name1 $sale_remarkk1  $sale_count1 $unit_name1 $product_name2 $sale_remarkk2 $sale_count2 $unit_name2 $product_name3 $sale_remarkk3 $sale_count3 $unit_name3 $product_name4 $sale_remarkk4 $sale_count4 $unit_name4  $product_name5 $sale_remarkk5 $sale_count5 $unit_name5  $product_name6 $sale_remarkk6 $sale_count6 $unit_name6 $product_name7 $sale_remarkk7 $sale_count7 $unit_name7 $product_name8 $sale_remarkk8 $sale_count8 $unit_name8 $product_name9 $sale_remarkk9 $sale_count9 $unit_name9 $product_name10 $sale_remarkk10 $sale_count10 $unit_name10 $address_name";
	
 $product_sn=$_POST["product_sn"];
 $unit_credit=$_POST["unit_credit"];
 $price=$_POST["unit_cash"];
 $employee_name=$_POST["employee_name"];
 $employee_tel=$_POST["employee_tel"];
 $add_by=$_POST["add_by"];
 $description=$_POST["sale_comment"];
 $havemap=$_POST['have_map'];
$unit_check=$_POST["unit_check"];
$unit_bill=$_POST["unit_bill"];
$unit_tran=$_POST["unit_tran"];
$department_show = $_POST["department_show"];
$unit_check1 = str_replace(',', '', $unit_check);
$unit_bill1 = str_replace(',', '', $unit_bill);
$dept =$_POST["dept"];
$status_comment =$_POST["status_comment"];
$address_1 =$_POST["address_1"];

$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code,province_name) 

values('".$ref_id_br."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."','".$em_id."','".$province_name."')";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());










	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_supbreng_edit.php?ref_id_br=$ref_id_br';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


