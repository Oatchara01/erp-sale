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
$bill_id = $_POST["bill_id"];
$date_so = $_POST["date_so"];
$suggest = $_POST["suggest"];
$payment = $_POST["payment"];
$sale_comment = $_POST["sale_comment"];
$po_no = $_POST["po_no"];
$que_ckk = $_POST["que_ckk"];
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
$delivery_address = $_POST["address_name"];
$delivery_contact = $_POST["customer_name"];
$delivery_tel = $_POST["customer_tel"];
$tax_id = $_POST["tax_id"];	
$cm_no = $_POST["cm_no"];	
$date_send_key  = $_POST["between_date"];
$have_order = $_POST["have_order"];
$date_tranfer = $_POST["date_tranfer"];
$pre_name = $_POST["pre_name"];
$ref_po = $_POST["ref_po"];
$sale_date= date('Y-m-d');
$sale =  $_SESSION['name'];
$sale_code = $_SESSION['code'];
$name =  $_SESSION['name'];
$em_id =  $_SESSION['emid'];

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
	
$comment_cs = $_POST["comment_cs"];	
$comment_en = $_POST["comment_en"];	
$comment_st = $_POST["comment_st"];	
$comment_ad = $_POST["comment_ad"];	

	

$pr_no  = $_POST["pr_no"];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$payment_des  = $_POST["payment_des"];
$iv_no = "IV";
	
if($_FILES['slip1']['name']!=''){
 move_uploaded_file($_FILES['slip1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip1']['name']));
 $slip1=$_FILES['slip1']['name'];
}else{
 $slip1 = $_POST["slip_1"];

}

if($_FILES['slip2']['name']!=''){
 move_uploaded_file($_FILES['slip2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip2']['name']));
 $slip2=$_FILES['slip2']['name'];
}else{
 $slip2 = $_POST["slip_2"];

}

if($_FILES['slip3']['name']!=''){
 move_uploaded_file($_FILES['slip3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip3']['name']));
 $slip3=$_FILES['slip3']['name'];
}else{
 $slip3 = $_POST["slip_3"];

}

if($_FILES['slip4']['name']!=''){
 move_uploaded_file($_FILES['slip4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip4']['name']));
 $slip4 =$_FILES['slip4']['name'];
}else{
 $slip4 = $_POST["slip_4"];

}

if($_FILES['slip5']['name']!=''){
 move_uploaded_file($_FILES['slip5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip5']['name']));
 $slip5=$_FILES['slip5']['name'];
}else{
 $slip5 = $_POST["slip_5"];

}

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
(ref_id,type_doc,bill_name,bill_address,full_bill,date_so,suggest,payment,sale_comment,po_no,delivery_contract,book_clear,book_no,brn_clear,brn_no,brnp_clear,brnp_no,sn_ckk,sn_no,install_place,with_pr,type_type,type_detail,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,sale_date,sale,sale_code,pr_no,add_date,add_by,status_doc,bill_tel,payment_des,slip1,slip2,slip3,slip4,slip5,date_send_key,have_order,iv_no,tax_id,bill_id,date_tranfer,cm_no,pre_name,que_ckk)
values
('".$ref_id."','".$type_doc."','".$bill_name."','".$bill_address."','".$full_bill."','".$date_so."','".$suggest."','".$payment."','".$sale_comment."','".$po_no."','".$delivery_contract."','".$book_clear."','".$book_no."','".$brn_clear."','".$brn_no."','".$brnp_clear."','".$brnp_no."','".$sn_ckk."','".$sn_no."','".$install_place."','".$with_pr."','".$type_type."','".$type_detail."','".$delivery_type."','".$delivery_date."','".$delivery_time."','".$delivery_address."','".$delivery_contact."','".$delivery_tel."','".$sale_date."','".$sale."','".$sale_code."','".$pr_no."','".$add_date."','".$add_by."','Request','".$bill_tel."','".$payment_des."','".$slip1."','".$slip2."','".$slip3."','".$slip4."','".$slip5."','".$date_send_key."','".$have_order."','".$iv_no."','".$tax_id."','".$bill_id."','".$date_tranfer."','".$cm_no."','".$pre_name."','".$que_ckk."')";

$qsave=mysqli_query($conn,$save);
	
	

$save1="Update  hos__po set  open_so='1',open_sodate='".$add_date."',ref_so='".$ref_id."',name_open ='".$add_by."'  where ref_id ='".$ref_po."'";
$qsave1=mysqli_query($conn,$save1);
	
$save56="insert into tb_other_bill
(ref_id,head_1,ref_1,ref_2,ref_3,ref_4,ref_5,ref_6,ref_7,ref_8,ref_9,ref_10,ref_des,ref_11)
values
('".$ref_id."','".$head_1."','".$ref_1."','".$ref_2."','".$ref_3."','".$ref_4."','".$ref_5."','".$ref_6."','".$ref_7."','".$ref_8."','".$ref_9."','".$ref_10."','".$ref_des."','".$ref_11."')";
$qsave56=mysqli_query($conn,$save56);	
	
$save57="insert into tb_comment_so (ref_id,comment_cs,comment_en,comment_st,comment_ad) values ('".$ref_id."','".$comment_cs."','".$comment_en."','".$comment_st."','".$comment_ad."')";
$qsave57=mysqli_query($conn,$save57);		


$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
$warranty =$_POST["warranty"];
 $pm=$_POST["pm"];
 $cal=$_POST["cal"];
$sn = $_POST["sn"];
 $product_id = $_POST["product_id"];
 $discount_unit = $_POST["discount_unit"];
$clear_br = $_POST["clear_br"];
$clear_ivno = $_POST["clear_ivno"];


foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);

		$clear_ivno_new = $clear_ivno[$key];
		$sale_remarkk_new=$sale_remarkk[$key];
		$warranty_new=$warranty[$key];
		$pm_new=$pm[$key];
		$cal_new=$cal[$key];
	 $sn_new=$sn[$key];
	   $clear_br_new = $clear_br[$key];
        $product_id_new =$product_id[$key];
        $discount_unit1 =$discount_unit[$key];
		$discount_unit_new=str_replace(',','', $discount_unit1);
		$sum_amount_new = ($product_price_new - $discount_unit_new)*$sale_count_new;
		 
	  

$strSQL = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno)
values ('".$ref_id."','".$sale_count_new."','".$sale_count_new."','".$product_price_new."','".$product_price_new."','".$sum_amount_new."','".$sale_remarkk_new."','".$discount_unit_new."','".$warranty_new."','".$cal_new."','".$pm_new."','".$product_id_new."','".$product_id_new."','".$have_order."','".$clear_br_new."','".$clear_ivno_new."')";
 
$objQuery = mysqli_query($conn,$strSQL);



}





$clear_br6 = $_POST["clear_br6"];
$clear_br7 = $_POST["clear_br7"];
$clear_br8 = $_POST["clear_br8"];
$clear_br9 = $_POST["clear_br9"];
$clear_br10 = $_POST["clear_br10"];	
	
	
$product_name6 = $_POST["product_name6"];
$unit_name6 = $_POST["unit_name6"];
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
$discount_unit7 = $_POST["discount_unit7"];
$warranty7  = $_POST["warranty7"];
$cal7 = $_POST["cal7"];
$pm7 = $_POST["pm7"];

if($_POST["product_code7"]!=''){
$product_code7 = $_POST["product_code7"];
}else if($_POST["product_codet7"]!=''){
$product_code7 = $_POST["product_codet7"];
}else{
$product_code7 = $_POST["product_c7"];	
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
}else if($_POST["product_codet8"]!=''){
$product_code8 = $_POST["product_codet8"];
}else{
$product_code8 = $_POST["product_c8"];	
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
}else if($_POST["product_codet9"]!=''){
$product_code9 = $_POST["product_codet9"];
}else{
$product_code9 = $_POST["product_c9"];	
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

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count6*$objResult31["unit1"];
$unit2 =$sale_count6*$objResult31["unit2"];
$unit3 =$sale_count6*$objResult31["unit3"];
$unit4 =$sale_count6*$objResult31["unit4"];
$unit5 =$sale_count6*$objResult31["unit5"];
$unit6 =$sale_count6*$objResult31["unit6"];
$unit7 =$sale_count6*$objResult31["unit7"];
$unit8 =$sale_count6*$objResult31["unit8"];
$unit9 =$sale_count6*$objResult31["unit9"];
$unit10 =$sale_count6*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."','".$product_idb1."','".$product_idb1."','".$product_code6."','1','".$product_code6."','".$have_order."','".$clear_br6."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code6."','".$have_order."','".$clear_br6."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code6."','".$have_order."','".$clear_br6."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code6."','".$have_order."','".$clear_br6."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code6."','".$have_order."','".$clear_br6."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code6."','".$have_order."','".$clear_br6."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code6."','".$have_order."','".$clear_br6."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code6."','".$have_order."','".$clear_br6."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code6."','".$have_order."','".$clear_br6."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk6."','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code6."','".$have_order."','".$clear_br6."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}			
}else{

$strSQL6 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br)
values ('".$ref_id."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."','".$product_id6."','".$product_id6."','".$have_order."','".$clear_br6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);
	
}
}


if($product_id7 !==''  ){
	
$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code7."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count7*$objResult31["unit1"];
$unit2 =$sale_count7*$objResult31["unit2"];
$unit3 =$sale_count7*$objResult31["unit3"];
$unit4 =$sale_count7*$objResult31["unit4"];
$unit5 =$sale_count7*$objResult31["unit5"];
$unit6 =$sale_count7*$objResult31["unit6"];
$unit7 =$sale_count7*$objResult31["unit7"];
$unit8 =$sale_count7*$objResult31["unit8"];
$unit9 =$sale_count7*$objResult31["unit9"];
$unit10 =$sale_count7*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."','".$product_idb1."','".$product_idb1."','".$product_code7."','1','".$product_code7."','".$have_order."','".$clear_br7."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code7."','".$have_order."','".$clear_br7."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code7."','".$have_order."','".$clear_br7."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code7."','".$have_order."','".$clear_br7."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code7."','".$have_order."','".$clear_br7."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code7."','".$have_order."','".$clear_br7."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code7."','".$have_order."','".$clear_br7."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code7."','".$have_order."','".$clear_br7."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code7."','".$have_order."','".$clear_br7."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk7."','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code7."','".$have_order."','".$clear_br7."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
}else{

$strSQL7 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br)
values ('".$ref_id."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."','".$product_id7."','".$product_id7."','".$have_order."','".$clear_br7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);

}
}


if($product_id8 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code8."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count8*$objResult31["unit1"];
$unit2 =$sale_count8*$objResult31["unit2"];
$unit3 =$sale_count8*$objResult31["unit3"];
$unit4 =$sale_count8*$objResult31["unit4"];
$unit5 =$sale_count8*$objResult31["unit5"];
$unit6 =$sale_count8*$objResult31["unit6"];
$unit7 =$sale_count8*$objResult31["unit7"];
$unit8 =$sale_count8*$objResult31["unit8"];
$unit9 =$sale_count8*$objResult31["unit9"];
$unit10 =$sale_count8*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."','".$product_idb1."','".$product_idb1."','".$product_code8."','1','".$product_code8."','".$have_order."','".$clear_br8."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code8."','".$have_order."','".$clear_br8."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code8."','".$have_order."','".$clear_br8."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code8."','".$have_order."','".$clear_br8."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code8."','".$have_order."','".$clear_br8."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code8."','".$have_order."','".$clear_br8."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code8."','".$have_order."','".$clear_br8."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code8."','".$have_order."','".$clear_br8."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code8."','".$have_order."','".$clear_br8."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk8."','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code8."','".$have_order."','".$clear_br8."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
}else{
	
	
$strSQL8 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br)
values ('".$ref_id."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."','".$product_id8."','".$product_id8."','".$have_order."','".$clear_br8."')";

	$objQuery8 = mysqli_query($conn,$strSQL8);

}
}


if($product_id9 !==''  ){
	
$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code9."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count9*$objResult31["unit1"];
$unit2 =$sale_count9*$objResult31["unit2"];
$unit3 =$sale_count9*$objResult31["unit3"];
$unit4 =$sale_count9*$objResult31["unit4"];
$unit5 =$sale_count9*$objResult31["unit5"];
$unit6 =$sale_count9*$objResult31["unit6"];
$unit7 =$sale_count9*$objResult31["unit7"];
$unit8 =$sale_count9*$objResult31["unit8"];
$unit9 =$sale_count9*$objResult31["unit9"];
$unit10 =$sale_count9*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."','".$product_idb1."','".$product_idb1."','".$product_code9."','1','".$product_code9."','".$have_order."','".$clear_br9."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code9."','".$have_order."','".$clear_br9."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code9."','".$have_order."','".$clear_br9."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code9."','".$have_order."','".$clear_br9."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code9."','".$have_order."','".$clear_br9."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code9."','".$have_order."','".$clear_br9."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code9."','".$have_order."','".$clear_br9."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code9."','".$have_order."','".$clear_br9."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code9."','".$have_order."','".$clear_br9."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk9."','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code10."','".$have_order."','".$clear_br9."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
}else{
	

$strSQL9 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br)
values ('".$ref_id."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."','".$product_id9."','".$product_id9."','".$have_order."','".$clear_br9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);


}
}


if($product_id10 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code10."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count10*$objResult31["unit1"];
$unit2 =$sale_count10*$objResult31["unit2"];
$unit3 =$sale_count10*$objResult31["unit3"];
$unit4 =$sale_count10*$objResult31["unit4"];
$unit5 =$sale_count10*$objResult31["unit5"];
$unit6 =$sale_count10*$objResult31["unit6"];
$unit7 =$sale_count10*$objResult31["unit7"];
$unit8 =$sale_count10*$objResult31["unit8"];
$unit9 =$sale_count10*$objResult31["unit9"];
$unit10 =$sale_count10*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."','".$product_idb1."','".$product_idb1."','".$product_code10."','1','".$product_code10."','".$have_order."','".$clear_br10."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code10."','".$have_order."','".$clear_br10."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code10."','".$have_order."','".$clear_br10."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code10."','".$have_order."','".$clear_br10."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code10."','".$have_order."','".$clear_br10."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code10."','".$have_order."','".$clear_br10."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code10."','".$have_order."','".$clear_br10."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code10."','".$have_order."','".$clear_br10."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code10."','".$have_order."','".$clear_br10."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','".$sale_remarkk10."','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code10."','".$have_order."','".$clear_br10."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
}else{
		

$strSQL10 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br)
values ('".$ref_id."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."','".$product_id10."','".$product_id10."','".$have_order."','".$clear_br10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);

}
}


	

$strSQL29 = "SELECT SUM(amount) AS unit_cash FROM hos__subso WHERE ref_idd = '".$ref_id."' ";
$objQuery29 = mysqli_query($conn,$strSQL29) or die ("Error Query [".$strSQL29."]");
$rs = mysqli_fetch_assoc($objQuery29);
		
$amount = $rs["unit_cash"];



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
		$unit_credit=$amount;
	}else{
		$credit='0';
		$unit_credit=$_POST["unit_credit"];
	}
	
	if ($_POST['want_bus']!=''){
	$want_bus=$_POST['want_bus'];
	}else{
		$want_bus='0';
	}
	if ($_POST['call_back']!=''){
		 $call_employee=$_POST['call_back'];
	}else{
		$call_employee='0';
	}
	
	if ($_POST['cash']!=''){
		 $chash=$_POST['cash'];
		$price=$amount;
	}else{
		$chash='0';
		$price=$_POST["unit_cash"];
	}
	
	if ($_POST['check_paper']!=''){
	 $check_peper=$_POST['check_paper'];
		$unit_check1=$amount;
	}else{
		$check_peper='0';
		$unit_check1=$_POST["unit_check"];
	}
	
	if ($_POST['bill']!=''){
		 $bill=$_POST['bill'];
		$unit_bill1=$amount;
	}else{
		$bill='0';
		$unit_bill1=$_POST["unit_bill"];
	}
	
	if ($_POST['tran']!=''){
		 $tran=$_POST["tran"];
		$unit_tran=$amount;
	}else{
		$tran='0';
		$unit_tran=$_POST["unit_tran"];
	}
	
	


	
		if ($_POST['dep']!=''){
		  $dep=$_POST["dep"];
	}else{
		$dep='0';
	}

	
 $department=$_POST["department_name"];
	$type_customer=$_POST["customer_typename"];
	
	if($type_doc=='3'){
 $type_company='ออลล์เวล ไลฟ์ บจก.';
	}else if($type_doc=='4'){
	$type_company='โนเบิล เมด บจก.';	
	}
 
	
$province_name =$_POST["province_name"];
 $customer_name=$_POST["customer_name"];
 $customer_tel=$_POST["customer_tel"];
 $address_name=$_POST["address_name"];
	 $address_1=$_POST["address_1"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
	$mk_research = $_POST["mk_research"];
 $on_time = $_POST["on_time"];	
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
$product_sn=$_POST["product_sn"];
	if($brnp_no !=''){
  $product_name="เคลียร์ยืม เลขที่ $brnp_no $product_name1 $sale_remarkk1 $sale_count1 $unit_name1 $product_name2 $sale_remarkk2 $sale_count2 $unit_name2 $product_name3 $sale_remarkk3 $sale_count3 $unit_name3 $product_name4 $sale_remarkk4 $sale_count4 $unit_name4  $product_name5 $sale_remarkk5 $sale_count5 $unit_name5  $product_name6 $sale_remarkk6 $sale_count6 $unit_name6 $product_name7 $sale_remarkk7 $sale_count7 $unit_name7 $address_name";
	}else{
 $product_name = "ส่ง $product_name1 $sale_remarkk1 $sale_count1 $unit_name1 $product_name2 $sale_remarkk2 $sale_count2 $unit_name2 $product_name3 $sale_remarkk3 $sale_count3 $unit_name3 $product_name4 $sale_remarkk4 $sale_count4 $unit_name4  $product_name5 $sale_remarkk5 $sale_count5 $unit_name5  $product_name6 $sale_remarkk6 $sale_count6 $unit_name6 $product_name7 $sale_remarkk7 $sale_count7 $unit_name7 $address_name";	
	}

 $employee_name=$_POST["employee_name"];
 $employee_tel=$_POST["employee_tel"];
 $add_by=$_POST["add_by"];
 $description=$_POST["sale_comment"];
 $havemap=$_POST['have_map'];
	$department_show = $_POST["department_show"];

$dept =$_POST["dept"];
$status_comment =$_POST["status_comment"];
	
if ($_POST['runway']!=''){
		$runway=$_POST["runway"];
	}else{
		$runway='0';
	}

if ($_POST['road']!=''){
		$road=$_POST["road"];
	}else{
		$road='0';
	}

if ($_POST['soy']!=''){
	$soy=$_POST["soy"];
	}else{
		$soy='0';
	}
	
	if ($_POST['car_load']!=''){
	$car_load=$_POST["car_load"];
	}else{
		$car_load='0';
	}

if ($_POST['no_car_road']!=''){
	$no_car_road=$_POST["no_car_road"];
	}else{
		$no_car_road='0';
	}
	
	if ($_POST['car_road']!=''){
	$car_road=$_POST["car_road"];
	}else{
		$car_road='0';
	}
if ($_POST['car_home']!=''){
	$car_home=$_POST["car_home"];
	}else{
		$car_home='0';
	}

	if ($_POST['slope']!=''){
	$slope=$_POST["slope"];	
	}else{
		$slope='0';
	}

	
	if ($_POST['bundai']!=''){
	$bundai=$_POST["bundai"];
	}else{
		$bundai='0';
	}

	if ($_POST['bundai_install']!=''){
	$bundai_install=$_POST["bundai_install"];
	}else{
		$bundai_install='0';
	}

	if ($_POST['lip']!=''){
	$lip=$_POST["lip"];
	}else{
		$lip='0';
	}

	
	if ($_POST['want_employee']!=''){
	$want_employee=$_POST["want_employee"];	
	}else{
		$want_employee='0';
	}

	if ($_POST['want_ex']!=''){
	$want_ex=$_POST["want_ex"];	
	}else{
		$want_ex='0';
	}

	
	if ($_POST['want_credit']!=''){
	$want_credit=$_POST["want_credit"];
	}else{
		$want_credit='0';
	}
if ($_POST['want_prem']!=''){
	$want_prem=$_POST["want_prem"];	
	}else{
		$want_prem='0';
	}
	
	if ($_POST['head_bad']!=''){
	$head_bad=$_POST["head_bad"];	
	}else{
		$head_bad='0';
	}

	
	if ($_POST['height_ltd']!=''){
	$height_ltd=$_POST["height_ltd"];	
	}else{
		$height_ltd='0';
	}
if ($_POST['up']!=''){
	$up=$_POST["up"];	
	}else{
		$up='0';
	}
if ($_POST['no_up']!=''){
	$no_up=$_POST["no_up"];	
	}else{
		$no_up='0';
	}

	
if ($_POST['more']!=''){
		 $check_detail=$_POST["more"];
	}else{
		$check_detail='0';
	}	
	
$type_bundai=$_POST["type_bundai"];	
	
	
	
$soy_long = $_POST["soy_long"];
$soy_big = $_POST["soy_big"];
$car_park = $_POST["car_park"];
$door_long = $_POST["door_long"];
$unit_bundai = $_POST["unit_bundai"];
$door_big = $_POST["door_bigger"];
$door_longer = $_POST["door_longer"];
$type_door = $_POST["type_door"];
$home_type = $_POST["home_type"];
$install = $_POST["install"];
$bundai_big = $_POST["bundai_big"];
$lip_big = $_POST["lip_big"];
$lip_long = $_POST["lip_long"];
$lip_weight = $_POST["lip_weight"];
$employee_unit = $_POST["employee_unit"];
$ferniger_name = $_POST["ferniger_name"];
$ferniger_address = $_POST["ferniger_address"];
$number = $_POST["number"];
$status_comment=$_POST["status_comment"];

$dept = $_POST["dept"];
$room_bigger = $_POST["room_bigger"];
$room_longer = $_POST["room_longer"];
$bundai_hug = $_POST["bundai_hug"];
$bank = $_POST["bank"];

$department_show = $_POST["department_show"];
$description_ja = $_POST["description_ja"];


$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code,mk_research,province_name) 

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','โรงพยาบาล','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."','".$em_id."','".$mk_research."','".$province_name."')";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());


$strSQL99 =  "insert into tb_transaction (ref_id,runway,road,soy,soy_long,soy_big,car_load,car_park,car_road,no_car_road,car_home,door_long,slope,bundai,unit_bundai,door_big,door_longer,type_door,home_type,install,bundai_install,bundai_big,lip,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,ferniger_address,want_ex,want_credit,want_prem,add_date,add_by,room_bigger,room_longer,bundai_hug,bank,description,type_bundai,head_bad,height_ltd,up,no_up) 

values('".$ref_id."','".$runway."','".$road."','".$soy."','".$soy_long."','".$soy_big."','".$car_load."','".$car_park."','".$car_road."','".$no_car_road."','".$car_home."','".$door_long."','".$slope."','".$bundai."','".$unit_bundai."','".$door_big."','".$door_longer."','".$type_door."','".$home_type."','".$install."','".$bundai_install."','".$bundai_big."','".$lip."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$ferniger_address."','".$want_ex."','".$want_credit."','".$want_prem."','$add_date','".$add_by."','".$room_bigger."','".$room_longer."','".$bundai_hug."','".$bank."','".$description_ja."','".$type_bundai."','".$head_bad."','".$height_ltd."','".$up."','".$no_up."')";

$objQuery99 = mysqli_query($conn,$strSQL99) or die(mysqli_error());


$customer_name1 = $_POST["customer_name1"];
$customer_tel1 = $_POST["customer_tel1"];
$address_name1 = $_POST["address_name1"];
	
$customer_name2 = $_POST["customer_name2"];
$customer_tel2 = $_POST["customer_tel2"];
$address_name2 = $_POST["address_name2"];

$customer_name3 = $_POST["customer_name3"];
$customer_tel3 = $_POST["customer_tel3"];
$address_name3 = $_POST["address_name3"];

$customer_name4 = $_POST["customer_name4"];
$customer_tel4 = $_POST["customer_tel4"];
$address_name4 = $_POST["address_name4"];
	
$customer_name5 = $_POST["customer_name5"];
$customer_tel5 = $_POST["customer_tel5"];
$address_name5 = $_POST["address_name5"];

$customer_name6 = $_POST["customer_name6"];
$customer_tel6 = $_POST["customer_tel6"];
$address_name6 = $_POST["address_name6"];

$customer_name7 = $_POST["customer_name7"];
$customer_tel7 = $_POST["customer_tel7"];
$address_name7 = $_POST["address_name7"];

$customer_name8 = $_POST["customer_name8"];
$customer_tel8 = $_POST["customer_tel8"];
$address_name8 = $_POST["address_name8"];

$customer_name9 = $_POST["customer_name9"];
$customer_tel9 = $_POST["customer_tel9"];
$address_name9 = $_POST["address_name9"];
	

if($customer_name1!=''){

$strSQL15 =  "insert into tb_delivery_print (ref_id,customer_name1,customer_tel1,address_name1,customer_name2,customer_tel2,address_name2,customer_name3,customer_tel3,address_name3,customer_name4,customer_tel4,address_name4,customer_name5,customer_tel5,address_name5,customer_name6,customer_tel6,address_name6,customer_name7,customer_tel7,address_name7,customer_name8,customer_tel8,address_name8,customer_name9,customer_tel9,address_name9) 

values('".$ref_id."','".$customer_name1."','".$customer_tel1."','".$address_name1."','".$customer_name2."','".$customer_tel2."','".$address_name2."','".$customer_name3."','".$customer_tel3."','".$address_name3."','".$customer_name4."','".$customer_tel4."','".$address_name4."','".$customer_name5."','".$customer_tel5."','".$address_name5."','".$customer_name6."','".$customer_tel6."','".$address_name6."','".$customer_name7."','".$customer_tel7."','".$address_name7."','".$customer_name8."','".$customer_tel8."','".$address_name8."','".$customer_name9."','".$customer_tel9."','".$address_name9."')";

$objQuery15 = mysqli_query($conn,$strSQL15) or die(mysqli_error());

}

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_salehos_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


