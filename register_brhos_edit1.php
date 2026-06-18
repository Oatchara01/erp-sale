
<?php
include("dbconnect.php");
include ("error_page.php"); 
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id_br = trim($_POST["ref_id_br"]);
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
$return_date_bet  = $_POST["return_date_bet"];
$returns = $_POST["returns"];
$returns_date = $_POST["returns_date"];
$returns_time = $_POST["returns_time"];
$returns_name = $_POST["returns_name"];
$returns_address = $_POST["returns_address"];
$returns_contact = $_POST["return_contact"];
//$ckk_war = $_POST["ckk_war"];
$status_doc = "Request";
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
$que_ckk = $_POST["que_ckk"];

$sale_date= date('Y-m-d');
$sale =  $_SESSION['name'];
$sale_code = $_SESSION['code'];
$name =  $_SESSION['name'];

//echo $sale_code;
//exit();

$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";

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
$ref_11des = $_POST["ref_11des"];

$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
 $product_id = $_POST["product_id"];
$br_period = $_POST["br_period"];
$warranty = $_POST["warranty"];	

 if ($_FILES['slip1']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip1']['name']!=''){
$temp1 = explode(".", $_FILES["slip1"]["name"]);
$slip1 = "slip1" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["slip1"]["tmp_name"], "upload/" . $slip1);
}else{
 $slip1 = $_POST["slip1"];

}

 if ($_FILES['slip2']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip2']['name']!=''){
$temp2 = explode(".", $_FILES["slip2"]["name"]);
$slip2 = "slip2" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["slip2"]["tmp_name"], "upload/" . $slip2);
}else{
 $slip2 = $_POST["slip2"];

}

 if ($_FILES['slip3']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip3']['name']!=''){
$temp3 = explode(".", $_FILES["slip3"]["name"]);
$slip3 = "slip3" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["slip3"]["tmp_name"], "upload/" . $slip3);
}else{
 $slip3 = $_POST["slip3"];

}

 if ($_FILES['slip4']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip4']['name']!=''){
$temp4 = explode(".", $_FILES["slip4"]["name"]);
$slip4 = "slip4" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp4);
move_uploaded_file($_FILES["slip4"]["tmp_name"], "upload/" . $slip4);
}else{
 $slip4 = $_POST["slip4"];

}

 if ($_FILES['slip5']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip5']['name']!=''){
$temp5 = explode(".", $_FILES["slip5"]["name"]);
$slip5 = "slip5" . "_" . $ref_id_br . "_" . round(microtime(true)) . '.' . end($temp5);
move_uploaded_file($_FILES["slip5"]["tmp_name"], "upload/" . $slip5);
}else{
 $slip5 = $_POST["slip5"];

}


$sqlbr = "SELECT * FROM hos__br where  ref_id_br = '".$ref_id_br."' ";
$qrybr = mysqli_query($conn,$sqlbr) or die(mysqli_error());
$rsbr = mysqli_fetch_assoc($qrybr);

$save="Update   hos__br set date_br='".$date_br."',customer='".$customer."',customer_id='".$customer_id."',address='".$address."',sale_comment='".$sale_comment."',sn_ckk='".$sn_ckk."',sn='".$sn."',objective='".$objective."',objective_des1='".$objective_des1."',objective_des2='".$objective_des2."',objective_des4='".$objective_des4."',objective_des5='".$objective_des5."',returns='".$returns."',returns_date='".$returns_date."',returns_time='".$returns_time."',returns_name='".$returns_name."',returns_address='".$returns_address."',returns_contact='".$returns_contact."',status_doc='".$status_doc."',delivery_name='".$delivery_name."',delivery_type='".$delivery_type."',delivery_date='".$delivery_date."',delivery_time='".$delivery_time."',delivery_address='".$delivery_address."',delivery_contact='".$delivery_contact."',delivery_tel='".$delivery_tel."',date_send_key = '".$date_send_key."',return_date_bet='".$return_date_bet."',slip1 = '".$slip1."',slip2 = '".$slip2."',slip3 = '".$slip3."',slip4 = '".$slip4."',slip5 = '".$slip5."',que_ckk = '".$que_ckk."',cm_no='".$cm_no."'   where ref_id_br ='".$ref_id_br."'";


$qsave=mysqli_query($conn,$save);


$save56="Update tb_other_bill SET
head_1='".$head_1."',ref_1='".$ref_1."',ref_2='".$ref_2."',ref_3='".$ref_3."',ref_4='".$ref_4."',ref_5='".$ref_5."',ref_6='".$ref_6."',ref_7='".$ref_7."',ref_8='".$ref_8."',ref_9='".$ref_9."',ref_10='".$ref_10."',ref_11='".$ref_11."',ref_des='".$ref_des."',ref_11des='".$ref_11des."' where  ref_id ='".$ref_id_br."'";
$qsave56=mysqli_query($conn,$save56);	
	
	

$strSQL21 = "SELECT * FROM hos__subbr WHERE ref_idd_br = '".$ref_id_br."' ";
$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){

  foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
		$sale_remarkk_new=$sale_remarkk[$key];
        $product_id_new =$product_id[$key];
		$br_period_new = $br_period[$key];
		$warranty_new = $warranty[$key];
		$sum_amount_new = $product_price_new *$sale_count_new;
		 //echo $sum_amount_new;


$strSQL = "Update   hos__subbr set count='$sale_count_new',countref='$sale_count_new',price='$product_price_new',amount='$sum_amount_new',sale_remark='$sale_remarkk_new',product_id='$product_id_new',product_code ='$product_id_new',br_periodd='".$br_period_new."',warranty='".$warranty_new."'   Where id= '$id_new' ";

//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL);
}
	
}
//exit();
if($rsbr["status_doc"]=="Request" or $rsbr["status_doc"]=="Pending review"){
//if($Num_Rows21 >= '8'){ }else{	
	
$warranty6 = $_POST["warranty6"];	
$warranty7 = $_POST["warranty7"];	
$warranty8 = $_POST["warranty8"];	
$warranty9 = $_POST["warranty9"];	
$warranty10 = $_POST["warranty10"];	
$warranty11 = $_POST["warranty11"];	
$warranty12 = $_POST["warranty12"];	
$warranty13 = $_POST["warranty13"];	
$warranty14 = $_POST["warranty14"];	
$warranty15 = $_POST["warranty15"];	
	

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
	
$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='".$product_id6."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["demo_ckk"]=='1'){
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
	
$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='".$product_id7."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["demo_ckk"]=='1'){
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
	
$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='".$product_id8."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["demo_ckk"]=='1'){
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
	
$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='".$product_id9."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["demo_ckk"]=='1'){
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
	
$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='".$product_id10."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	if($rs["demo_ckk"]=='1'){
	$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='".$product_id10."' ";
   $objQuery91 = mysqli_query($conn,$strSQL91);
		
	}	

}

//}
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
 $type_company=$_POST["company_name"];
 $customer_name=$_POST["customer_name"];
 $customer_tel=$_POST["customer_tel"];
 $address_name=$_POST["address_name"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
	
$on_time =$_POST["on_time"];	
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
 $product=$_POST["product"];
 $product_name = "$product  $product_name6  $sale_count6 $unit_name6 $product_name7  $sale_count7 $unit_name7 $product_name8  $sale_count8 $unit_name8 $product_name9  $sale_count9 $unit_name9 $product_name10  $sale_count10 $unit_name10";
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
$address_1 = $_POST["address_1"];
	
	

$strSQL66 =  "Update tb_register_data set start_date = '".$start_date."',between_date ='".$between_date."',start_time ='".$start_time."',end_time ='".$end_time."',status ='".$status."',fix_date ='".$fix_date."',no_price ='".$no_price."',call_customer ='".$call_customer."',credit ='".$credit."',call_employee ='".$call_employee."',cash ='".$chash."',check_peper ='".$check_peper."',bill = '".$bill."',department ='".$department."',type_customer ='".$type_customer."',type_company = '".$type_company."',customer_name ='".$customer_name."',customer_tel ='".$customer_tel."',address_name ='".$address_name."',address_send ='".$address_send."',want_bus ='".$want_bus."',product_name ='".$product_name."',product_sn ='".$product_sn."',unit_credit ='".$unit_credit."',price ='".$price."',employee_name ='".$employee_name."',employee_tel ='".$employee_tel."',add_by ='".$add_by."',description ='".$description."',have_map = '".$havemap."',add_date ='$add_date',unit_bill ='".$unit_bill."',unit_check ='".$unit_check."',unit_tran ='".$unit_tran."',tran ='".$tran."',check_detail ='".$check_detail."',dep ='".$dep."',dept ='".$dept."',department_show ='".$department_show."',customer_contact = '".$customer_contact."',status_comment = '".$status_comment."',on_time = '".$on_time."',address_1 = '".$address_1."',province_name='".$province_name."'  where ref_id = '".$ref_id_br."'";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());







		if($qsave){
			echo "<script language=\"JavaScript\">";
			echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_brhos_edit.php?ref_id_br=$ref_id_br';";
			echo "</script>";
		} else {
			echo "Cannot";
		}
	}

