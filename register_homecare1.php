<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$date_jong = $_POST["date_jong"];
$company = $_POST["company"];
$customer_id = $_POST["bill_id"];
$customer = $_POST["customer"];
$bq_no = $_POST["bq_no"];
$drescription = $_POST["drescription"];
$date_receive = $_POST["date_receive"];
$type_jong = $_POST["type_jong"];
$ref_receive =  substr($date_receive,0,7);

$address_send = $_POST["address_send"];

$status_doc = "Request";
$sale_code = $_POST["sale_code"];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
	

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(iv_no) AS MAXID FROM hos__jongproduct";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -3);
$maxId3 = substr($rs['MAXID'],-7);

$maxId1 = substr($maxId3,0,-3);
$so1 = "JG";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId1 = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "001"; 
$nextId1 = $yearMonth.$maxId1;

}

 $iv_no ="$so1$nextId1";
//echo $iv_no;
	//exit();
	
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__jongproduct";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "PD";

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

 $ref_id ="$so$nextId";
	
	
$save="insert into hos__jongproduct
(ref_id,date_jong,company,customer_id,customer,bq_no,drescription,date_receive,address_send,status_doc,sale_code,sale_name,add_date,add_by,iv_no,ref_receive,type_jong)
values
('".$ref_id."','".$date_jong."','".$company."','".$customer_id."','".$customer."','".$bq_no."','".$drescription."','".$date_receive."','".$address_send."','".$status_doc."','".$sale_code."','".$add_by."','".$add_date."','".$add_by."','".$iv_no."','".$ref_receive."','".$type_jong."')";
$qsave=mysqli_query($conn,$save);


$save1="insert into hos__jongproduct_rt
(ref_id,date_jong,company,customer,drescription,date_receive,address_send,sale_code,add_date,add_by,customer_id,iv_no,ref_receive,type_jong)
values
('".$ref_id."','".$date_jong."','".$company."','".$customer."','".$drescription."','".$date_receive."','".$address_send."','".$sale_code."','".$add_date."','".$add_by."','".$customer_id."','".$iv_no."','".$ref_receive."','".$type_jong."')";
//echo $save1;
$qsave1=mysqli_query($conn,$save1);	
	
//exit();

if($_POST["product_code1"]!=''){
$product_code1 = $_POST["product_code1"];
}else if($_POST["product_codet1"]!=''){
$product_code1 = $_POST["product_codet1"];
}else{
$product_code1 = $_POST["product_c1"];	
}

$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];


if($_POST["product_code2"]!=''){
$product_code2 = $_POST["product_code2"];
}else if($_POST["product_codet2"]!=''){
$product_code2 = $_POST["product_codet2"];
}else{
$product_code2 = $_POST["product_c2"];	
}

$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$sale_remarkk2 = $_POST["sale_remarkk2"];


if($_POST["product_code3"]!=''){
$product_code3 = $_POST["product_code3"];
}else if($_POST["product_codet3"]!=''){
$product_code3 = $_POST["product_codet3"];
}else{
$product_code3 = $_POST["product_c3"];	
}	

$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];

if($_POST["product_code4"]!=''){
$product_code4 = $_POST["product_code4"];
}else if($_POST["product_codet4"]!=''){
$product_code4 = $_POST["product_codet4"];
}else{
$product_code4 = $_POST["product_c4"];	
}

$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];


if($_POST["product_code5"]!=''){
$product_code5 = $_POST["product_code5"];
}else if($_POST["product_codet5"]!=''){
$product_code5 = $_POST["product_codet5"];
}else{
$product_code5 = $_POST["product_c5"];	
}	

$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];

if($_POST["product_code6"]!=''){
$product_code6 = $_POST["product_code6"];
}else if($_POST["product_codet6"]!=''){
$product_code6 = $_POST["product_codet6"];
}else{
$product_code6 = $_POST["product_c6"];	
}		

$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];


if($_POST["product_code7"]!=''){
$product_code7 = $_POST["product_code7"];
}else if($_POST["product_codet7"]!=''){
$product_code7 = $_POST["product_codet7"];
}else{
$product_code7 = $_POST["product_c7"];	
}	

$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];


if($_POST["product_code8"]!=''){
$product_code8 = $_POST["product_code8"];
}else if($_POST["product_codet8"]!=''){
$product_code8 = $_POST["product_codet8"];
}else{
$product_code8 = $_POST["product_c8"];	
}		

$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];


if($_POST["product_code9"]!=''){
$product_code9 = $_POST["product_code9"];
}else if($_POST["product_codet9"]!=''){
$product_code9 = $_POST["product_codet9"];
}else{
$product_code9 = $_POST["product_c9"];	
}	

$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];

if($_POST["product_code10"]!=''){
$product_code10 = $_POST["product_code10"];
}else if($_POST["product_codet10"]!=''){
$product_code10 = $_POST["product_codet10"];
}else{
$product_code10 = $_POST["product_c10"];	
}	

$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];



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
$strSQL1 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product1."','".$id_product1."','".$unit1."','".$sale_remarkk1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product2."','".$id_product2."','".$unit2."','".$sale_remarkk1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product3."','".$id_product3."','".$unit3."','".$sale_remarkk1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product4."','".$id_product4."','".$unit4."','".$sale_remarkk1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product5."','".$id_product5."','".$unit5."','".$sale_remarkk1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product6."','".$id_product6."','".$unit6."','".$sale_remarkk1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product7."','".$id_product7."','".$unit7."','".$sale_remarkk1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}	
	
if($id_product8 !=''){

$strSQL1 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product8."','".$id_product8."','".$unit8."','".$sale_remarkk1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product9."','".$id_product9."','".$unit9."','".$sale_remarkk1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
}	
	
if($id_product10 !=''){

$strSQL1 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product10."','".$id_product10."','".$unit10."','".$sale_remarkk1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);

	
}	
	

	
}else{
$strSQL1 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id1."','".$product_id1."','".$sale_count1."','".$sale_remarkk1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);
	
	
	
$strSQLs1 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id1."','".$product_id1."','".$sale_count1."','".$sale_remarkk1."','".$add_date."','".$add_by."')";
$objQuerys1 = mysqli_query($conn,$strSQLs1);
	
	
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
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product1."','".$id_product1."','".$unit1."','".$sale_remarkk2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product2 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product2."','".$id_product2."','".$unit2."','".$sale_remarkk2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product3 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product3."','".$id_product3."','".$unit3."','".$sale_remarkk2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product4 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product4."','".$id_product4."','".$unit4."','".$sale_remarkk2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product5 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product5."','".$id_product5."','".$unit5."','".$sale_remarkk2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product6 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product6."','".$id_product6."','".$unit6."','".$sale_remarkk2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product7 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product7."','".$id_product7."','".$unit7."','".$sale_remarkk2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product8 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product8."','".$id_product8."','".$unit8."','".$sale_remarkk2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product9 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product9."','".$id_product9."','".$unit9."','".$sale_remarkk2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product10 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product10."','".$id_product10."','".$unit10."','".$sale_remarkk2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
	
}else{	
	
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id2."','".$product_id2."','".$sale_count2."','".$sale_remarkk2."')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	
	
$strSQLs2 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id2."','".$product_id2."','".$sale_count2."','".$sale_remarkk2."','".$add_date."','".$add_by."')";
$objQuerys2 = mysqli_query($conn,$strSQLs2);
	
	
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
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product1."','".$id_product1."','".$unit1."','".$sale_remarkk3."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product2 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product2."','".$id_product2."','".$unit2."','".$sale_remarkk3."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product3 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product3."','".$id_product3."','".$unit3."','".$sale_remarkk3."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product4 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product4."','".$id_product4."','".$unit4."','".$sale_remarkk3."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product5 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product5."','".$id_product5."','".$unit5."','".$sale_remarkk3."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product6 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product6."','".$id_product6."','".$unit6."','".$sale_remarkk3."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product7 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product7."','".$id_product7."','".$unit7."','".$sale_remarkk3."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product8 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product8."','".$id_product8."','".$unit8."','".$sale_remarkk3."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product9 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product9."','".$id_product9."','".$unit9."','".$sale_remarkk3."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product10 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product10."','".$id_product10."','".$unit10."','".$sale_remarkk3."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
	
}else{	
	
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id3."','".$product_id3."','".$sale_count3."','".$sale_remarkk3."')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	
	
$strSQLs2 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id3."','".$product_id3."','".$sale_count3."','".$sale_remarkk3."','".$add_date."','".$add_by."')";
$objQuerys2 = mysqli_query($conn,$strSQLs2);
	
	
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
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product1."','".$id_product1."','".$unit1."','".$sale_remarkk4."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product2 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product2."','".$id_product2."','".$unit2."','".$sale_remarkk4."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product3 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product3."','".$id_product3."','".$unit3."','".$sale_remarkk4."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product4 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product4."','".$id_product4."','".$unit4."','".$sale_remarkk4."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product5 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product5."','".$id_product5."','".$unit5."','".$sale_remarkk4."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product6 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product6."','".$id_product6."','".$unit6."','".$sale_remarkk4."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product7 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product7."','".$id_product7."','".$unit7."','".$sale_remarkk4."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product8 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product8."','".$id_product8."','".$unit8."','".$sale_remarkk4."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product9 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product9."','".$id_product9."','".$unit9."','".$sale_remarkk4."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product10 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product10."','".$id_product10."','".$unit10."','".$sale_remarkk4."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
	
}else{	
	
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id4."','".$product_id4."','".$sale_count4."','".$sale_remarkk4."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
$strSQLs2 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id4."','".$product_id4."','".$sale_count4."','".$sale_remarkk4."','".$add_date."','".$add_by."')";
$objQuerys2 = mysqli_query($conn,$strSQLs2);
	
	
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
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product1."','".$id_product1."','".$unit1."','".$sale_remarkk5."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product2 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product2."','".$id_product2."','".$unit2."','".$sale_remarkk5."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product3 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product3."','".$id_product3."','".$unit3."','".$sale_remarkk5."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product4 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product4."','".$id_product4."','".$unit4."','".$sale_remarkk5."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product5 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product5."','".$id_product5."','".$unit5."','".$sale_remarkk5."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product6 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product6."','".$id_product6."','".$unit6."','".$sale_remarkk5."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product7 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product7."','".$id_product7."','".$unit7."','".$sale_remarkk5."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product8 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product8."','".$id_product8."','".$unit8."','".$sale_remarkk5."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product9 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product9."','".$id_product9."','".$unit9."','".$sale_remarkk5."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product10 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product10."','".$id_product10."','".$unit10."','".$sale_remarkk5."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
	
}else{	
	
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id5."','".$product_id5."','".$sale_count5."','".$sale_remarkk5."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
$strSQLs2 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id5."','".$product_id5."','".$sale_count5."','".$sale_remarkk5."','".$add_date."','".$add_by."')";
$objQuerys2 = mysqli_query($conn,$strSQLs2);
	
	
	
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
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product1."','".$id_product1."','".$unit1."','".$sale_remarkk6."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product2 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product2."','".$id_product2."','".$unit2."','".$sale_remarkk6."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product3 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product3."','".$id_product3."','".$unit3."','".$sale_remarkk6."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product4 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product4."','".$id_product4."','".$unit4."','".$sale_remarkk6."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product5 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product5."','".$id_product5."','".$unit5."','".$sale_remarkk6."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product6 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product6."','".$id_product6."','".$unit6."','".$sale_remarkk6."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product7 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product7."','".$id_product7."','".$unit7."','".$sale_remarkk6."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product8 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product8."','".$id_product8."','".$unit8."','".$sale_remarkk6."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product9 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product9."','".$id_product9."','".$unit9."','".$sale_remarkk6."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product10 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product10."','".$id_product10."','".$unit10."','".$sale_remarkk6."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
	
}else{	
	
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id6."','".$product_id6."','".$sale_count6."','".$sale_remarkk6."')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	
	
$strSQLs2 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id6."','".$product_id6."','".$sale_count6."','".$sale_remarkk6."','".$add_date."','".$add_by."')";
$objQuerys2 = mysqli_query($conn,$strSQLs2);
	
	
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
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product1."','".$id_product1."','".$unit1."','".$sale_remarkk7."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product2 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product2."','".$id_product2."','".$unit2."','".$sale_remarkk7."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product3 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product3."','".$id_product3."','".$unit3."','".$sale_remarkk7."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product4 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product4."','".$id_product4."','".$unit4."','".$sale_remarkk7."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product5 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product5."','".$id_product5."','".$unit5."','".$sale_remarkk7."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product6 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product6."','".$id_product6."','".$unit6."','".$sale_remarkk7."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product7 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product7."','".$id_product7."','".$unit7."','".$sale_remarkk7."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product8 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product8."','".$id_product8."','".$unit8."','".$sale_remarkk7."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product9 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product9."','".$id_product9."','".$unit9."','".$sale_remarkk7."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product10 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product10."','".$id_product10."','".$unit10."','".$sale_remarkk7."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
	
}else{	
	
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id7."','".$product_id7."','".$sale_count7."','".$sale_remarkk7."')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	

$strSQLs2 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id7."','".$product_id7."','".$sale_count7."','".$sale_remarkk7."','".$add_date."','".$add_by."')";
$objQuerys2 = mysqli_query($conn,$strSQLs2);
	
	
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
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product1."','".$id_product1."','".$unit1."','".$sale_remarkk8."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product2 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product2."','".$id_product2."','".$unit2."','".$sale_remarkk8."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product3 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product3."','".$id_product3."','".$unit3."','".$sale_remarkk8."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product4 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product4."','".$id_product4."','".$unit4."','".$sale_remarkk8."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product5 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product5."','".$id_product5."','".$unit5."','".$sale_remarkk8."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product6 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product6."','".$id_product6."','".$unit6."','".$sale_remarkk8."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product7 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product7."','".$id_product7."','".$unit7."','".$sale_remarkk8."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product8 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product8."','".$id_product8."','".$unit8."','".$sale_remarkk8."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product9 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product9."','".$id_product9."','".$unit9."','".$sale_remarkk8."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product10 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product10."','".$id_product10."','".$unit10."','".$sale_remarkk8."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
	
}else{	
	
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id8."','".$product_id8."','".$sale_count8."','".$sale_remarkk8."')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	
$strSQLs2 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id8."','".$product_id8."','".$sale_count8."','".$sale_remarkk8."','".$add_date."','".$add_by."')";
$objQuerys2 = mysqli_query($conn,$strSQLs2);
	
	
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
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product1."','".$id_product1."','".$unit1."','".$sale_remarkk9."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product2 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product2."','".$id_product2."','".$unit2."','".$sale_remarkk9."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product3 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product3."','".$id_product3."','".$unit3."','".$sale_remarkk9."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product4 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product4."','".$id_product4."','".$unit4."','".$sale_remarkk9."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product5 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product5."','".$id_product5."','".$unit5."','".$sale_remarkk9."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product6 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product6."','".$id_product6."','".$unit6."','".$sale_remarkk9."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product7 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product7."','".$id_product7."','".$unit7."','".$sale_remarkk9."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product8 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product8."','".$id_product8."','".$unit8."','".$sale_remarkk9."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product9 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product9."','".$id_product9."','".$unit9."','".$sale_remarkk9."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product10 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product10."','".$id_product10."','".$unit10."','".$sale_remarkk9."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
	
}else{	
	
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id9."','".$product_id9."','".$sale_count9."','".$sale_remarkk9."')";
$objQuery2 = mysqli_query($conn,$strSQL2);

	
$strSQLs2 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id9."','".$product_id9."','".$sale_count9."','".$sale_remarkk9."','".$add_date."','".$add_by."')";
$objQuerys2 = mysqli_query($conn,$strSQLs2);
	
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
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product1."','".$id_product1."','".$unit1."','".$sale_remarkk10."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product2 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product2."','".$id_product2."','".$unit2."','".$sale_remarkk10."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}
	
if($id_product3 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product3."','".$id_product3."','".$unit3."','".$sale_remarkk10."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product4 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product4."','".$id_product4."','".$unit4."','".$sale_remarkk10."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product5 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product5."','".$id_product5."','".$unit5."','".$sale_remarkk10."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product6 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product6."','".$id_product6."','".$unit6."','".$sale_remarkk10."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product7 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product7."','".$id_product7."','".$unit7."','".$sale_remarkk10."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product8 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product8."','".$id_product8."','".$unit8."','".$sale_remarkk10."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product9 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product9."','".$id_product9."','".$unit9."','".$sale_remarkk10."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
if($id_product10 !=''){
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$id_product10."','".$id_product10."','".$unit10."','".$sale_remarkk10."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}	
	
	
}else{	
	
$strSQL2 = "insert into hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
values ('".$ref_id."','".$product_id10."','".$product_id10."','".$sale_count10."','".$sale_remarkk10."')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	
	
$strSQLs2 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('".$ref_id."','".$product_id10."','".$product_id10."','".$sale_count10."','".$sale_remarkk10."','".$add_date."','".$add_by."')";
$objQuerys2 = mysqli_query($conn,$strSQLs2);
	
	
}


}











	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_homecare_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }

	}


