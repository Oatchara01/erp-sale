<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$date_jong = $_POST["date_jong"];
$company = $_POST["company"];
$customer_id  = $_POST["bill_id"];
$customer = $_POST["customer"];
$bq_no = $_POST["bq_no"];
$drescription = $_POST["drescription"];
$date_receive = $_POST["date_receive"];
$ref_receive =  substr($date_receive,0,7);
$address_send = $_POST["address_send"];
$type_jong = $_POST["type_jong"];
	
$status_doc = "Request";
$sale_code = $_POST["sale_code"];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
	
	
	


$ref_id = $_POST["ref_id"];


$save="UPDATE  hos__jongproduct SET date_jong = '".$date_jong."',customer_id = '".$customer_id."',customer = '".$customer."',bq_no = '".$bq_no."' ,drescription = '".$drescription."',date_receive = '".$date_receive."',address_send = '".$address_send."',ref_receive='".$ref_receive."',type_jong='".$type_jong."'  where ref_id = '".$ref_id."'";

$qsave=mysqli_query($conn,$save);
	
$save1="insert into hos__jongproduct_rt
(ref_id,date_jong,company,customer,drescription,date_receive,address_send,sale_code,add_date,add_by,customer_id,iv_no,ref_receive,type_jong)
values
('".$ref_id."','".$date_jong."','".$company."','".$customer."','".$drescription."','".$date_receive."','".$address_send."','".$sale_code."','".$add_date."','".$add_by."','".$customer_id."','".$iv_no."','".$ref_receive."','".$type_jong."')";

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




if($send_stock =='1'){
	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "Z0eE7VaoDEBdOHiOZyOOL86JiMPP6XycvpnynKpFiVV";
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
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_homecare_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }

	}


