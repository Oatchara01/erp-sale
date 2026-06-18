<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_doc = $_POST["type_doc"];
$bill_name = $_POST["bill_name"];
$bill_address = $_POST["bill_address"];
$bill_tel = $_POST["bill_tel"];
$full_bill = $_POST["full_bill"];

$date_so = $_POST["date_so"];
$suggest = $_POST["suggest"];
$payment = $_POST["payment"];
$sale_comment = $_POST["sale_comment"];
$po_no = $_POST["po_no"];
$delivery_contract = $_POST["delivery_contract"];
$book_clear = $_POST["book_clear"];
$book_no = $_POST["book_no"];
$brn_clear = $_POST["brn_clear"];
$brn_no = $_POST["brn_no"];
$brnp_clear = $_POST["brnp_clear"];
$brnp_no = $_POST["brnp_no"];
$sn_ckk = $_POST["sn_ckk"];
$sn_no = $_POST["sn_no"];
$install_place = $_POST["address_send"];
$with_pr = $_POST["with_pr"];
$type_type = $_POST["type_type"];
$type_detail = $_POST["type_detail"];
$delivery_type = $_POST["delivery_type"];
$delivery_date = $_POST["start_date"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$delivery_time = "$start_time $end_time";
$delivery_address = $_POST["address_send"];
$delivery_contact = $_POST["customer_contact"];
$delivery_tel = $_POST["customer_tel"];
$payment_des  = $_POST["payment_des"];
$admin_date= date('Y-m-d');
$admin_code =	$_SESSION['code'];
$admin =  $_SESSION['name'];
$have_order = $_POST["have_order"]; 
$order_no  = $_POST["order_no"]; 
$tax_id = $_POST["tax_id"];


$sale_date= date('Y-m-d');
$sale =  $_SESSION['name'];
$sale_code = $_POST['sale_code'];
  
 if($sale_code=='S11' or $sale_code=='S12' or $sale_code=='S13' or $sale_code=='S14'   or $sale_code=='S24'){
$sup_code = 'SS2';
$approve  = 'นรินทิพย์';
  }else if ($sale_code=='S15' or $sale_code=='S22' or $sale_code=='S21' or $sale_code=='S51') {

$sup_code = 'SS1';
$approve  = 'พรรณิภา';
  }else if ($sale_code=='S16' or $sale_code=='S17' or $sale_code=='S23' or $sale_code=='SM1') {

$sup_code = 'SM1';
$approve  = 'ลักษณาวรรณ';


  }else if ($sale_code=='S31' or $sale_code=='MM1') {
$sup_code = 'SS3';
$approve  = 'มาลินี';

  }else if ($sale_code=='EN' or $sale_code=='EN2' or $sale_code=='EN3' or $sale_code=='EN4' or $sale_code=='EN5' or $sale_code=='EN6' or $sale_code=='EN7' or $sale_code=='EN8') {
$sup_code = 'SUP_EN';
$approve  = 'บรรเทิง';

  }

$iv_no = $_POST["iv_no"];
$iv_date = $_POST["iv_date"];
$dep_no  = $_POST["dep_no"];
$job_no  = $_POST["job_no"];

$pr_no  = $_POST["pr_no"];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$sale $surname";

//echo $_FILES['upload1']['name'];
//exit();
if ($_FILES['slip1']['size'] == 0) {
$slip1 = "";
}else if ($_FILES['slip1']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip1']['size'] != 0) {
$temp1 = explode(".", $_FILES["slip1"]["name"]);
$slip1 = "slip1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["slip1"]["tmp_name"], "upload/" . $slip1);
}	

	
	
if ($_FILES['slip2']['size'] == 0) {
$slip2 = "";
}else if ($_FILES['slip2']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip2']['size'] != 0) {
$temp2 = explode(".", $_FILES["slip2"]["name"]);
$slip2 = "slip2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["slip2"]["tmp_name"], "upload/" . $slip2);
}	
	
	
if ($_FILES['slip3']['size'] == 0) {
$slip3 = "";
}else if ($_FILES['slip3']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip3']['size'] != 0) {
$temp3 = explode(".", $_FILES["slip3"]["name"]);
$slip3 = "slip3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["slip3"]["tmp_name"], "upload/" . $slip3);
}	
	
	
if ($_FILES['slip4']['size'] == 0) {
$slip4 = "";
}else if ($_FILES['slip4']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip4']['size'] != 0) {
$temp4 = explode(".", $_FILES["slip4"]["name"]);
$slip4 = "slip4" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp4);
move_uploaded_file($_FILES["slip4"]["tmp_name"], "upload/" . $slip4);
}	
	
	
	
if ($_FILES['slip5']['size'] == 0) {
$slip5 = "";
}else if ($_FILES['slip5']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip5']['size'] != 0) {
$temp5 = explode(".", $_FILES["slip5"]["name"]);
$slip5 = "slip5" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp5);
move_uploaded_file($_FILES["slip5"]["tmp_name"], "upload/" . $slip5);
}	


$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
$warranty =$_POST["warranty"];
 $pm=$_POST["pm"];
 $cal=$_POST["cal"];
 $product_id = $_POST["product_id"];
 $discount_unit = $_POST["discount_unit"];
$product_name = $_POST["product_name"];
$countref = $_POST["countref"];


$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__so";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "SO";

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

$so = "SO";
$ref_id ="$so$nextId";



$save="insert into hos__so
(ref_id,type_doc,bill_name,bill_address,full_bill,date_so,suggest,payment,sale_comment,po_no,delivery_contract,book_clear,book_no,brn_clear,brn_no,brnp_clear,brnp_no,sn_ckk,sn_no,install_place,with_pr,type_type,type_detail,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,sale_date,sale,sale_code,pr_no,add_date,add_by,status_doc,approve,approve_code,approve_date,payment_des,slip1,slip2,slip3,slip4,slip5,iv_no,iv_date,job_no,dep_no,send_sup,have_order,order_no,tax_id)
values
('".$ref_id."','".$type_doc."','".$bill_name."','".$bill_address."','".$full_bill."','".$date_so."','".$suggest."','".$payment."','".$sale_comment."','".$po_no."','".$delivery_contract."','".$book_clear."','".$book_no."','".$brn_clear."','".$brn_no."','".$brnp_clear."','".$brnp_no."','".$sn_ckk."','".$sn_no."','".$install_place."','".$with_pr."','".$type_type."','".$type_detail."','".$delivery_type."','".$delivery_date."','".$delivery_time."','".$delivery_address."','".$delivery_contact."','".$delivery_tel."','".$sale_date."','".$sale."','".$sale_code."','".$pr_no."','".$add_date."','".$add_by."','Request','".$approve."','".$sup_code."','".$sale_date."','".$payment_des."','".$slip1."','".$slip2."','".$slip3."','".$slip4."','".$slip5."','".$iv_no."','".$iv_date."','".$job_no."','".$dep_no."','1','".$have_order."','".$order_no."','".$tax_id."')";


$qsave=mysqli_query($conn,$save);

if($book_no !=''){
	
$strSQL = "SELECT ref_id FROM hos__jongproduct WHERE iv_no = '".$book_no."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
$remark_jong ="เปิดใบสั่งขายเลขที่อ้างอิง $ref_id";
	
$save2="UPDATE  hos__jongproduct SET close_jong='1',remark='".$remark_jong."'  where ref_id = '".$objResult["ref_id"]."'";
$qsave2=mysqli_query($conn,$save2);	
	
$save3="UPDATE hos__subjongpro SET close_ckk='1'  where ref_idd = '".$objResult["ref_id"]."'";
$qsave3=mysqli_query($conn,$save3);		

}

foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
		$sale_remarkk_new=$sale_remarkk[$key];
		$warranty_new=$warranty[$key];
		$pm_new=$pm[$key];
		$cal_new=$cal[$key];
        $product_id_new =$product_id[$key];
	$product_name_new =$product_name[$key];
        $discount_unit1 =$discount_unit[$key];
		$discount_unit_new=str_replace(',','', $discount_unit1);

		
		$sum_amount_new = ($product_price_new - $discount_unit_new)*$sale_count_new;
		 //echo $sum_amount_new;

	if($product_name_new !=""){

$strSQL = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count_new."','".$sale_count_new."','".$product_price_new."','".$product_price_new."','".$sum_amount_new."','".$sale_remarkk_new."','".$discount_unit_new."','".$warranty_new."','".$cal_new."','".$pm_new."','".$product_id_new."','".$product_id_new."')";
//echo $strSQL1;
//exit();

$objQuery = mysqli_query($conn,$strSQL);
	}

}








$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$discount_unit6 = $_POST["discount_unit6"];
$warranty6  = $_POST["warranty6"];
$cal6 = $_POST["cal6"];
$pm6 = $_POST["pm6"];
	if($_POST["product_code6"]!=''){
$product_code6 = $_POST["product_code6"];
	}else{
$product_code6 = $_POST["product_codet6"];
	}

$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$discount_unit7 = $_POST["discount_unit7"];
$warranty7  = $_POST["warranty7"];
$cal7 = $_POST["cal7"];
$pm7 = $_POST["pm7"];
	if($_POST["product_code7"]!=''){
$product_code7 = $_POST["product_code7"];
	}else{
$product_code7 = $_POST["product_codet7"];
	}

$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$discount_unit8 = $_POST["discount_unit8"];
$warranty8  = $_POST["warranty8"];
$cal8 = $_POST["cal8"];
$pm8 = $_POST["pm8"];
	if($_POST["product_code8"]!=''){
$product_code8 = $_POST["product_code8"];
	}else{
$product_code8 = $_POST["product_codet8"];
	}


$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$discount_unit9 = $_POST["discount_unit9"];
$warranty9  = $_POST["warranty9"];
$cal9 = $_POST["cal9"];
$pm9 = $_POST["pm9"];
	if($_POST["product_code9"]!=''){
$product_code9 = $_POST["product_code9"];
	}else{
$product_code9 = $_POST["product_codet9"];
	}

$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$discount_unit10 = $_POST["discount_unit10"];
$warranty10  = $_POST["warranty10"];
$cal10 = $_POST["cal10"];
$pm10 = $_POST["pm10"];
	if($_POST["product_code10"]!=''){
$product_code10 = $_POST["product_code10"];
	}else{
$product_code10 = $_POST["product_codet10"];
	}



$product_id11 = $_POST["product_id11"];
$sale_count11 = $_POST["sale_count11"];
$product_price11 = $_POST["product_price11"];
$sale_remarkk11 = $_POST["sale_remarkk11"];
$sum_amountt11 = $_POST["sum_amount11"];
$sum_amount11= str_replace(',','', $sum_amountt11);
$discount_unit11 = $_POST["discount_unit11"];
$warranty11  = $_POST["warranty11"];
$cal11 = $_POST["cal11"];
$pm11 = $_POST["pm11"];


$product_id12 = $_POST["product_id12"];
$sale_count12 = $_POST["sale_count12"];
$product_price12 = $_POST["product_price12"];
$sale_remarkk12 = $_POST["sale_remarkk12"];
$sum_amountt12 = $_POST["sum_amount12"];
$sum_amount12= str_replace(',','', $sum_amountt12);
$discount_unit12 = $_POST["discount_unit12"];
$warranty12  = $_POST["warranty12"];
$cal12 = $_POST["cal12"];
$pm12 = $_POST["pm12"];


$product_id13 = $_POST["product_id13"];
$sale_count13 = $_POST["sale_count13"];
$product_price13 = $_POST["product_price13"];
$sale_remarkk13 = $_POST["sale_remarkk13"];
$sum_amountt13 = $_POST["sum_amount13"];
$sum_amount13= str_replace(',','', $sum_amountt13);
$discount_unit13 = $_POST["discount_unit13"];
$warranty13  = $_POST["warranty13"];
$cal13 = $_POST["cal13"];
$pm13 = $_POST["pm13"];


$product_id14 = $_POST["product_id14"];
$sale_count14 = $_POST["sale_count14"];
$product_price14 = $_POST["product_price14"];
$sale_remarkk14 = $_POST["sale_remarkk14"];
$sum_amountt14 = $_POST["sum_amount14"];
$sum_amount14= str_replace(',','', $sum_amountt14);
$discount_unit14 = $_POST["discount_unit14"];
$warranty14  = $_POST["warranty14"];
$cal14 = $_POST["cal14"];
$pm14 = $_POST["pm14"];


$product_id15 = $_POST["product_id15"];
$sale_count15 = $_POST["sale_count15"];
$product_price15 = $_POST["product_price15"];
$sale_remarkk15 = $_POST["sale_remarkk15"];
$sum_amountt15 = $_POST["sum_amount15"];
$sum_amount15= str_replace(',','', $sum_amountt15);
$discount_unit15 = $_POST["discount_unit15"];
$warranty15  = $_POST["warranty15"];
$cal15 = $_POST["cal15"];
$pm15 = $_POST["pm15"];










//แถวที่ 1

if($product_id6 !==''  ){
	
	$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code6."' ";
//echo $strSQL21;
//exit();
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];

	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."','".$product_idb1."','".$product_idb1."','".$product_code6."','1','".$product_code6."')";


$objQuery104 = mysqli_query($conn,$strSQL104);
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count6."','".$sale_count6."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code6."')";



$objQuery100 = mysqli_query($conn,$strSQL100);
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count6."','".$sale_count6."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code6."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count6."','".$sale_count6."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code6."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	}
	
}else{
	
$strSQL1 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."','".$product_id6."','".$product_id6."')";


$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
}





//แถวที่ 2

if($product_id7 !==''  ){


	$strSQL32 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code7."' ";
//echo $strSQL21;
//exit();
$objQuery32 = mysqli_query($conn,$strSQL32) or die ("Error Query [".$strSQL32."]");
$Num_Rows32 = mysqli_num_rows($objQuery32);
$objResult32 = mysqli_fetch_array($objQuery32);

$product_ida1 =$objResult32["product_id1"];
$product_ida2 =$objResult32["product_id2"];
$product_ida3 =$objResult32["product_id3"];
$product_ida4 =$objResult32["product_id4"];

	
if($Num_Rows32 > 0){

	if($product_ida1!=''){
$strSQL105 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."','".$product_ida1."','".$product_ida1."','".$product_code7."','1','".$product_code7."')";


$objQuery105 = mysqli_query($conn,$strSQL105);
	}
	
	if($product_ida2!=''){
		
$strSQL106 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count7."','".$sale_count7."','0.00','0.00','0.00','','0.00','0','0','0','".$product_ida2."','".$product_ida2."','1','".$product_code7."')";


//echo $strSQL100;

$objQuery106 = mysqli_query($conn,$strSQL106);
	}
	
	if($product_ida3!=''){
		
$strSQL107 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count7."','".$sale_count7."','0.00','0.00','0.00','','0.00','0','0','0','".$product_ida3."','".$product_ida3."','1','".$product_code7."')";

$objQuery107 = mysqli_query($conn,$strSQL107);
	}
	
	if($product_ida4!=''){
		
$strSQL108 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count7."','".$sale_count7."','0.00','0.00','','0.00','0','0','0','".$product_ida4."','".$product_ida4."','1','".$product_code7."')";

$objQuery108 = mysqli_query($conn,$strSQL108);
	}
	
}else{

$strSQL2 ="insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."','".$product_id7."','".$product_id7."')";

$objQuery2 = mysqli_query($conn,$strSQL2);

}
}







//แถวที่ 3

if($product_id8 !==''  ){

$strSQL33 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code8."' ";
$objQuery33 = mysqli_query($conn,$strSQL33) or die ("Error Query [".$strSQL33."]");
$Num_Rows33 = mysqli_num_rows($objQuery33);
$objResult33 = mysqli_fetch_array($objQuery33);

$product_idc1 =$objResult33["product_id1"];
$product_idc2 =$objResult33["product_id2"];
$product_idc3 =$objResult33["product_id3"];
$product_idc4 =$objResult33["product_id4"];

	
if($Num_Rows33 > 0){

	if($product_idc1!=''){
$strSQL109 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."','".$product_idc1."','".$product_idc1."','".$product_code8."','1','".$product_code8."')";


$objQuery109 = mysqli_query($conn,$strSQL109);
	}
	
	if($product_idc2!=''){
		
$strSQL110 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count8."','".$sale_count8."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idc2."','".$product_idc2."','1','".$product_code8."')";


//echo $strSQL100;

$objQuery110 = mysqli_query($conn,$strSQL110);
	}
	
	if($product_idc3!=''){
		
$strSQL111 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count8."','".$sale_count8."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idc3."','".$product_idc3."','1','".$product_code8."')";

$objQuery111 = mysqli_query($conn,$strSQL111);
	}
	
	if($product_idc4!=''){
		
$strSQL112 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count8."','".$sale_count8."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idc4."','".$product_idc4."','1','".$product_code8."')";

$objQuery112 = mysqli_query($conn,$strSQL112);
	}
	
}else{


$strSQL3 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."','".$product_id8."','".$product_id8."')";

$objQuery3 = mysqli_query($conn,$strSQL3);

}
}


if($product_id9 !==''  ){


$strSQL34 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code9."' ";
$objQuery34 = mysqli_query($conn,$strSQL34) or die ("Error Query [".$strSQL34."]");
$Num_Rows34 = mysqli_num_rows($objQuery34);
$objResult34 = mysqli_fetch_array($objQuery34);

$product_idd1 =$objResult34["product_id1"];
$product_idd2 =$objResult34["product_id2"];
$product_idd3 =$objResult34["product_id3"];
$product_idd4 =$objResult34["product_id4"];

	
if($Num_Rows34 > 0){

	if($product_idd1!=''){

$strSQL113 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."','".$product_idd1."','".$product_idd1."','".$product_code9."','1','".$product_code9."')";


$objQuery113 = mysqli_query($conn,$strSQL113);
	}
	
	if($product_idd2!=''){
		
$strSQL114 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count9."','".$sale_count9."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idd2."','".$product_idd2."','1','".$product_code9."')";


//echo $strSQL100;

$objQuery114 = mysqli_query($conn,$strSQL114);
	}
	
	if($product_idd3!=''){
		
$strSQL115 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count9."','".$sale_count9."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idd3."','".$product_idd3."','1','".$product_code9."')";

$objQuery115 = mysqli_query($conn,$strSQL115);
	}
	
	if($product_idd4!=''){
		
$strSQL116 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count9."','".$sale_count9."','0.00','0.00','','0.00','0','0','0','".$product_idd4."','".$product_idd4."','1','".$product_code9."')";

$objQuery116 = mysqli_query($conn,$strSQL116);
	}
	
}else{



$strSQL4 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."','".$product_id9."','".$product_id9."')";
//echo $strSQL1;
//exit();

$objQuery4 = mysqli_query($conn,$strSQL4);

}
}


if($product_id10 !==''  ){


$strSQL35 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code10."' ";
$objQuery35 = mysqli_query($conn,$strSQL35) or die ("Error Query [".$strSQL35."]");
$Num_Rows35 = mysqli_num_rows($objQuery35);
$objResult35 = mysqli_fetch_array($objQuery35);

$product_ide1 =$objResult35["product_id1"];
$product_ide2 =$objResult35["product_id2"];
$product_ide3 =$objResult35["product_id3"];
$product_ide4 =$objResult35["product_id4"];

	
if($Num_Rows35 > 0){

	if($product_ide1!=''){

$strSQL117 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."','".$product_ide1."','".$product_ide1."','".$product_code10."','1','".$product_code10."')";


$objQuery117 = mysqli_query($conn,$strSQL117);
	}
	
	if($product_ide2!=''){
		
$strSQL118 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count10."','".$sale_count10."','0.00','0.00','0.00','','0.00','0','0','0','".$product_ide2."','".$product_ide2."','1','".$product_code10."')";


$objQuery118 = mysqli_query($conn,$strSQL118);
	}
	
	if($product_ide3!=''){
		
$strSQL119 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count10."','".$sale_count10."','0.00','0.00','0.00','','0.00','0','0','0','".$product_ide3."','".$product_ide3."','1','".$product_code10."')";

$objQuery119 = mysqli_query($conn,$strSQL119);
	}
	
	if($product_ide4!=''){
		
$strSQL120 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count10."','".$sale_count10."','0.00','0.00','0.00','','0.00','0','0','0','".$product_ide4."','".$product_ide4."','1','".$product_code10."')";

$objQuery120 = mysqli_query($conn,$strSQL120);
	}
	
}else{



$strSQL5 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."','".$product_id10."','".$product_id10."')";
//echo $strSQL1;
//exit();

$objQuery5 = mysqli_query($conn,$strSQL5);

}
}



////////////

if($product_id11 !==''  ){

$strSQL11 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count11."','".$sale_count11."','".$product_price11."','".$product_price11."','".$sum_amount11."','".$sale_remarkk11."','".$discount_unit11."','".$warranty11."','".$cal11."','".$pm11."','".$product_id11."','".$product_id11."')";
//echo $strSQL1;
//exit();

$objQuery11 = mysqli_query($conn,$strSQL11);

}

if($product_id12 !==''  ){

$strSQL12 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count12."','".$sale_count12."','".$product_price12."','".$product_price12."','".$sum_amount12."','".$sale_remarkk12."','".$discount_unit12."','".$warranty12."','".$cal12."','".$pm12."','".$product_id12."','".$product_id12."')";
//echo $strSQL1;
//exit();

$objQuery12 = mysqli_query($conn,$strSQL12);

}

if($product_id13 !==''  ){

$strSQL13 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count13."','".$sale_count13."','".$product_price13."','".$product_price13."','".$sum_amount13."','".$sale_remarkk13."','".$discount_unit13."','".$warranty13."','".$cal13."','".$pm13."','".$product_id13."','".$product_id13."')";
//echo $strSQL1;
//exit();

$objQuery13 = mysqli_query($conn,$strSQL13);

}

if($product_id14 !==''  ){

$strSQL14 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count14."','".$sale_count14."','".$product_price14."','".$product_price14."','".$sum_amount14."','".$sale_remarkk14."','".$discount_unit14."','".$warranty14."','".$cal14."','".$pm14."','".$product_id14."','".$product_id14."')";
//echo $strSQL1;
//exit();

$objQuery14 = mysqli_query($conn,$strSQL14);

}

if($product_id15 !==''  ){

$strSQL15 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count15."','".$sale_count15."','".$product_price15."','".$product_price15."','".$sum_amount15."','".$sale_remarkk15."','".$discount_unit15."','".$warranty15."','".$cal15."','".$pm15."','".$product_id15."','".$product_id15."')";
//echo $strSQL1;
//exit();

$objQuery15 = mysqli_query($conn,$strSQL15);

}






 $start_date =$_POST["start_date"];
 $status_comment = $_POST["status_comment"];
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
	
 $on_time = $_POST["on_time"];	
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
 $product_name=$_POST["product"];
 $product_sn=$_POST["product_sn"];
 $unit_credit=$_POST["unit_credit"];
 $price=$_POST["unit_cash"];
 $employee_name=$_POST["employee_name"];
 $h_employee_name=$_POST["h_employee_name"];
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
$address_1 =$_POST["address_1"];

$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1) 

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."')";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());










	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_suphos_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}