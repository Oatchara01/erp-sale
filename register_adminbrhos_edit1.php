
<?php
include("dbconnect.php");
include("dbconnect_cs.php");
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
$clear_book_ckk = $_POST["clear_book_ckk"];
$clear_book_no = $_POST["clear_book_no"];
$clear_brn_no_ckk = $_POST["clear_brn_no_ckk"];
$clear_brn_no = $_POST["clear_brn_no"];
$clear_brnp_no_ckk = $_POST["clear_brnp_no_ckk"];
$clear_brnp_no = $_POST["clear_brnp_no"];
$sn_ckk = $_POST["sn_ckk"];
$sn = $_POST["sn"];
$cm_no = $_POST["cm_no"];
$que_ckk = $_POST["que_ckk"];
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
$sale_code  = $_POST["sale_code"];
$send_cs =  $_POST["send_cs"];
$send_brdoc  =  $_POST["send_brdoc"];
$sale_date= date('Y-m-d');
$sale =  $_SESSION['name'];

$send_edit = $_POST["send_edit"];
$des_stock = $_POST["des_stock"];
$remark_cancel = $_POST["remark_cancel"];
//$ckk_war = $_POST["ckk_war"];	

$iv_date = $_POST["iv_date"];
$iv_time = $_POST["iv_time"];
$dep_no  = $_POST["dep_no"];
$job_no  = $_POST["job_no"];
$status_doc = $_POST["status_doc"];
$sale = $_POST["sale"];
	//echo $add_by1;
	
$add_date = date('Y-m-d H:i:s');
$date_edit = date('Y-m-d');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$admin =  $_SESSION['name'];
$admin_code =  $_SESSION['code'];
$admin_date= date('Y-m-d H:i:s');
$date_ker = $_POST["date_ker"];
$order_refer_code = $_POST["order_refer_code"];
$order_refer_code1 = $_POST["order_refer_code1"];
$ker_bath = $_POST["ker_bath"];	
	

$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
 $product_id = $_POST["product_id"];
$countref = $_POST["countref"];
$br_period = $_POST["br_period"];
$delete_ckk = $_POST["delete_ckk"];	

	
if($_FILES['slip1']['name']!=''){
 move_uploaded_file($_FILES['slip1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip1']['name']));
 $slip1=$_FILES['slip1']['name'];
}else{
 $slip1 = $_POST["slip1"];

}

if($_FILES['slip2']['name']!=''){
 move_uploaded_file($_FILES['slip2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip2']['name']));
 $slip2=$_FILES['slip2']['name'];
}else{
 $slip2 = $_POST["slip2"];

}

if($_FILES['slip3']['name']!=''){
 move_uploaded_file($_FILES['slip3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip3']['name']));
 $slip3=$_FILES['slip3']['name'];
}else{
 $slip3 = $_POST["slip3"];

}

if($_FILES['slip4']['name']!=''){
 move_uploaded_file($_FILES['slip4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip4']['name']));
 $slip4 =$_FILES['slip4']['name'];
}else{
 $slip4 = $_POST["slip4"];

}

if($_FILES['slip5']['name']!=''){
 move_uploaded_file($_FILES['slip5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip5']['name']));
 $slip5=$_FILES['slip5']['name'];
}else{
 $slip5 = $_POST["slip5"];

}

	
	
$run_id = $_POST["run_id"];
$date = explode('-' , $iv_date );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);


if($run_id=='1'){	

if($company =='1'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng where head_no='BRNP' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "BRNP";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$iv_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_docbreng (head_no,doc_no,year_no,month_no,run_iv,ref_id) values ('BRNP','".$iv_no."','".$year1."','".$mont."','".$nextId."','".$ref_id_br."')";
$qsave5=mysqli_query($conn,$save5);
		
	}else if($company =='2'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng where head_no='BRN.P' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "BRN.P";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$iv_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_docbreng (head_no,doc_no,year_no,month_no,run_iv,ref_id) values ('BRN.P','".$iv_no."','".$year1."','".$mont."','".$nextId."','".$ref_id_br."')";
$qsave5=mysqli_query($conn,$save5);


	}
	
	
}else{	
$iv_no = $_POST["iv_no"];	
}
		
	
	
	

$line_stock = $_POST["line_stock"];	
	

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


$save="Update   hos__br set company='".$company."',date_br='".$date_br."',customer='".$customer."',customer_id='".$customer_id."',address='".$address."',sale_comment='".$sale_comment."',clear_book_ckk='".$clear_book_ckk."',clear_book_no = '".$clear_book_no."',clear_brn_no_ckk='".$clear_brn_no_ckk."',clear_brn_no = '".$clear_brn_no."',clear_brnp_no_ckk='".$clear_brnp_no_ckk."',clear_brnp_no='".$clear_brnp_no."',sn_ckk='".$sn_ckk."',sn='".$sn."',objective='".$objective."',objective_des1='".$objective_des1."',objective_des2='".$objective_des2."',objective_des4='".$objective_des4."',objective_des5='".$objective_des5."',returns='".$returns."',returns_date='".$returns_date."',returns_time='".$returns_time."',returns_name='".$returns_name."',returns_address='".$returns_address."',returns_contact='".$returns_contact."',delivery_name='".$delivery_name."',delivery_type='".$delivery_type."',delivery_date='".$delivery_date."',delivery_time='".$delivery_time."',delivery_address='".$delivery_address."',delivery_contact='".$delivery_contact."',delivery_tel='".$delivery_tel."',date_send_key = '".$date_send_key."', admin = '".$admin."',admin_code = '".$admin_code."',admin_date = '".$admin_date."',iv_no='".$iv_no."',iv_date='".$iv_date."',dep_no='".$dep_no."',job_no='".$job_no."',return_date_bet = '".$return_date_bet."',slip1 = '".$slip1."',slip2 = '".$slip2."',slip3 = '".$slip3."',slip4 = '".$slip4."',slip5 = '".$slip5."',sale = '".$sale."',date_ker='".$date_ker."',order_refer_code='".$order_refer_code."',order_refer_code1='".$order_refer_code1."',ker_bath = '".$ker_bath."',que_ckk='".$que_ckk."',cm_no='".$cm_no."',iv_time='".$iv_time."',head_2='".$head_1."'  where ref_id_br ='".$ref_id_br."'";

	$qsave=mysqli_query($conn,$save);

	
$save56="Update tb_other_bill SET
head_1='".$head_1."',ref_1='".$ref_1."',ref_2='".$ref_2."',ref_3='".$ref_3."',ref_4='".$ref_4."',ref_5='".$ref_5."',ref_6='".$ref_6."',ref_7='".$ref_7."',ref_8='".$ref_8."',ref_9='".$ref_9."',ref_10='".$ref_10."',ref_11='".$ref_11."',ref_des='".$ref_des."',ref_11des='".$ref_11des."' where  ref_id ='".$ref_id_br."'";
$qsave56=mysqli_query($conn,$save56);	
	
	
if($send_brdoc =='1'){	
	
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');

$save9="insert into tb_register_br
(company,br_date,iv_no,customer_name,add_by,add_date,ref_id) values ('".$company."','".$iv_date."','".$iv_no."','".$customer."','".$add_by."','".$add_date."','".$ref_id_br."')";
$qsave9=mysqli_query($conn,$save9);


$save3="Update   hos__br set send_brdoc = '2' where ref_id_br ='".$ref_id_br."'";
$qsave3=mysqli_query($conn,$save3);
	
}
	
	
if($status_doc !=''){	
	
if($remark_cancel==''){

echo "<script language=\"JavaScript\">";
echo "alert('กรุณาใส่หมายเหตุการยกเลิกเอกสาร');window.location='register_adminbrhos_edit.php?ref_id_br=$ref_id_br';";
echo "</script>";
exit();
	
}else{
	
	
$save1="Update   hos__br set status_doc='".$status_doc."',remark_cancel='".$remark_cancel."'  where ref_id_br ='".$ref_id_br."'";
$qsave1=mysqli_query($conn,$save1);

	
$save1="Update   tb_register_br set cancel='1',cancel_des='".$remark_cancel."'  where ref_id ='".$ref_id_br."'";
$qsave1=mysqli_query($conn,$save1);
	
$save3="Update   tb_register_data set summary_sup='".$status_doc."',description_sup='".$remark_cancel."',status_comment='".$status_doc."'  where ref_id ='".$ref_id_br."'";
$qsave3=mysqli_query($com1,$save3);	
	
}	
	
}
	
/*if($send_edit =='1'){	
	
$save2="Update   hos__br set stock = '',status_stock='0',des_stock = '".$des_stock."'  where ref_id_br ='".$ref_id_br."'";
$qsave2 = mysqli_query($conn,$save2);
	
}*/
	
	

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
		$countref_new = $countref[$key];
		$sum_amount_new = $product_price_new *$sale_count_new;
		$br_period_new = $br_period[$key];
	  $delete_ckk_new = $delete_ckk[$key];
	  


$strSQL = "Update   hos__subbr set count='$sale_count_new',price='$product_price_new',amount='$sum_amount_new',sale_remark='$sale_remarkk_new',product_id='$product_id_new',product_code ='$product_id_new',br_periodd='".$br_period_new."'   Where id= '$id_new' ";

$objQuery = mysqli_query($conn,$strSQL);
	  
if($delete_ckk_new=='1'){

$strSQL5 = "DELETE FROM hos__subbr WHERE id = '".$id_new."'";
$objQuery5 = mysqli_query($conn,$strSQL5);
	
}	  
	  
	  
	  
}
	
}

$sql66 = "SELECT send_erpst   FROM hos__br where ref_id_br ='".$ref_id_br."' ";
$qry66 = mysqli_query($conn,$sql66) or die(mysqli_error());
$rs66 = mysqli_fetch_assoc($qry66);	

if($rs66["send_erpst"]=='0'){	

$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);


$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);


$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);



$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);


$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);



$product_id11 = $_POST["product_id11"];
$sale_count11 = $_POST["sale_count11"];
$product_price11 = $_POST["product_price11"];
$sale_remarkk11 = $_POST["sale_remarkk11"];
$sum_amountt11 = $_POST["sum_amount11"];
$sum_amount11= str_replace(',','', $sum_amountt11);


$product_id12 = $_POST["product_id12"];
$sale_count12 = $_POST["sale_count12"];
$product_price12 = $_POST["product_price12"];
$sale_remarkk12 = $_POST["sale_remarkk12"];
$sum_amountt12 = $_POST["sum_amount12"];
$sum_amount12= str_replace(',','', $sum_amountt12);


$product_id13 = $_POST["product_id13"];
$sale_count13 = $_POST["sale_count13"];
$product_price13 = $_POST["product_price13"];
$sale_remarkk13 = $_POST["sale_remarkk13"];
$sum_amountt13 = $_POST["sum_amount13"];
$sum_amount13= str_replace(',','', $sum_amountt13);


$product_id14 = $_POST["product_id14"];
$sale_count14 = $_POST["sale_count14"];
$product_price14 = $_POST["product_price14"];
$sale_remarkk14 = $_POST["sale_remarkk14"];
$sum_amountt14 = $_POST["sum_amount14"];
$sum_amount14= str_replace(',','', $sum_amountt14);


$product_id15 = $_POST["product_id15"];
$sale_count15 = $_POST["sale_count15"];
$product_price15 = $_POST["product_price15"];
$sale_remarkk15 = $_POST["sale_remarkk15"];
$sum_amountt15 = $_POST["sum_amount15"];
$sum_amount15= str_replace(',','', $sum_amountt15);





if($product_id6 !=''  ){

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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$id_product1."','".$id_product1."','".$br_period6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk6."','".$id_product2."','".$id_product2."','".$br_period6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk6."','".$id_product3."','".$id_product3."','".$br_period6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk6."','".$id_product4."','".$id_product4."','".$br_period6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk6."','".$id_product5."','".$id_product5."','".$br_period6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk6."','".$id_product6."','".$id_product6."','".$br_period6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk6."','".$id_product7."','".$id_product7."','".$br_period6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk6."','".$id_product8."','".$id_product8."','".$br_period6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk6."','".$id_product9."','".$id_product9."','".$br_period6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk6."','".$id_product10."','".$id_product10."','".$br_period6."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{			


$strSQL6 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$product_id6."','".$product_id6."','".$br_period6."')";
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


if($product_id7 !=''  ){

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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$id_product1."','".$id_product1."','".$br_period7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk7."','".$id_product2."','".$id_product2."','".$br_period7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk7."','".$id_product3."','".$id_product3."','".$br_period7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk7."','".$id_product4."','".$id_product4."','".$br_period7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk7."','".$id_product5."','".$id_product5."','".$br_period7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk7."','".$id_product6."','".$id_product6."','".$br_period7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk7."','".$id_product7."','".$id_product7."','".$br_period7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk7."','".$id_product8."','".$id_product8."','".$br_period7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk7."','".$id_product9."','".$id_product9."','".$br_period7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk7."','".$id_product10."','".$id_product10."','".$br_period7."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{			
	

$strSQL7 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$product_id7."','".$product_id7."','".$br_period7."')";
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


if($product_id8 !=''  ){

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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$id_product1."','".$id_product1."','".$br_period8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk8."','".$id_product2."','".$id_product2."','".$br_period8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk8."','".$id_product3."','".$id_product3."','".$br_period8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk8."','".$id_product4."','".$id_product4."','".$br_period8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk8."','".$id_product5."','".$id_product5."','".$br_period8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk8."','".$id_product6."','".$id_product6."','".$br_period8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk8."','".$id_product7."','".$id_product7."','".$br_period8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk8."','".$id_product8."','".$id_product8."','".$br_period8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk8."','".$id_product9."','".$id_product9."','".$br_period8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk8."','".$id_product10."','".$id_product10."','".$br_period8."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{				

$strSQL8 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$product_id8."','".$product_id8."','".$br_period8."')";
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


if($product_id9 !=''  ){

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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$id_product1."','".$id_product1."','".$br_period9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk9."','".$id_product2."','".$id_product2."','".$br_period9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk9."','".$id_product3."','".$id_product3."','".$br_period9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk9."','".$id_product4."','".$id_product4."','".$br_period9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk9."','".$id_product5."','".$id_product5."','".$br_period9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk9."','".$id_product6."','".$id_product6."','".$br_period9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk9."','".$id_product7."','".$id_product7."','".$br_period9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk9."','".$id_product8."','".$id_product8."','".$br_period9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk9."','".$id_product9."','".$id_product9."','".$br_period9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk9."','".$id_product10."','".$id_product10."','".$br_period9."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{				
	

$strSQL9 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$product_id9."','".$product_id9."','".$br_period9."')";

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


if($product_id10 !=''  ){

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
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$id_product1."','".$id_product1."','".$br_period10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk10."','".$id_product2."','".$id_product2."','".$br_period10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk10."','".$id_product3."','".$id_product3."','".$br_period10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk10."','".$id_product4."','".$id_product4."','".$br_period10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk10."','".$id_product5."','".$id_product5."','".$br_period10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk10."','".$id_product6."','".$id_product6."','".$br_period10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk10."','".$id_product7."','".$id_product7."','".$br_period10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk10."','".$id_product8."','".$id_product8."','".$br_period10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk10."','".$id_product9."','".$id_product9."','".$br_period10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk10."','".$id_product10."','".$id_product10."','".$br_period10."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{				
		

$strSQL10 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$product_id10."','".$product_id10."','".$br_period10."')";

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



if($product_id11 !=''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id11."' ";
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
	
$unit1 = $sale_count11*$objResult31["unit1"];
$unit2 = $sale_count11*$objResult31["unit2"];
$unit3 = $sale_count11*$objResult31["unit3"];
$unit4 = $sale_count11*$objResult31["unit4"];
$unit5 = $sale_count11*$objResult31["unit5"];
$unit6 = $sale_count11*$objResult31["unit6"];
$unit7 = $sale_count11*$objResult31["unit7"];
$unit8 = $sale_count11*$objResult31["unit8"];
$unit9 = $sale_count11*$objResult31["unit9"];
$unit10 =$sale_count11*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
	
if($id_product1 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price11."','".$sum_amount11."','".$sale_remarkk11."','".$id_product1."','".$id_product1."','".$br_period11."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk11."','".$id_product2."','".$id_product2."','".$br_period11."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk11."','".$id_product3."','".$id_product3."','".$br_period11."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk11."','".$id_product4."','".$id_product4."','".$br_period11."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk11."','".$id_product5."','".$id_product5."','".$br_period11."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk11."','".$id_product6."','".$id_product6."','".$br_period11."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk11."','".$id_product7."','".$id_product7."','".$br_period11."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk11."','".$id_product8."','".$id_product8."','".$br_period11."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk11."','".$id_product9."','".$id_product9."','".$br_period11."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk11."','".$id_product10."','".$id_product10."','".$br_period11."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{				
			

$strSQL11 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$sale_count11."','".$sale_count11."','".$product_price11."','".$sum_amount11."','".$sale_remarkk11."','".$product_id11."','".$product_id11."','".$br_period11."')";

$objQuery11 = mysqli_query($conn,$strSQL11);
}
}

if($product_id12 !=''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id12."' ";
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
	
$unit1 = $sale_count12*$objResult31["unit1"];
$unit2 = $sale_count12*$objResult31["unit2"];
$unit3 = $sale_count12*$objResult31["unit3"];
$unit4 = $sale_count12*$objResult31["unit4"];
$unit5 = $sale_count12*$objResult31["unit5"];
$unit6 = $sale_count12*$objResult31["unit6"];
$unit7 = $sale_count12*$objResult31["unit7"];
$unit8 = $sale_count12*$objResult31["unit8"];
$unit9 = $sale_count12*$objResult31["unit9"];
$unit10 =$sale_count12*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
	
if($id_product1 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price12."','".$sum_amount12."','".$sale_remarkk12."','".$id_product1."','".$id_product1."','".$br_period12."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk12."','".$id_product2."','".$id_product2."','".$br_period12."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk12."','".$id_product3."','".$id_product3."','".$br_period12."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk12."','".$id_product4."','".$id_product4."','".$br_period12."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk12."','".$id_product5."','".$id_product5."','".$br_period12."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk12."','".$id_product6."','".$id_product6."','".$br_period12."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk12."','".$id_product7."','".$id_product7."','".$br_period12."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk12."','".$id_product8."','".$id_product8."','".$br_period12."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk12."','".$id_product9."','".$id_product9."','".$br_period12."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk12."','".$id_product10."','".$id_product10."','".$br_period12."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{				
				

$strSQL12 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$sale_count12."','".$sale_count12."','".$product_price12."','".$sum_amount12."','".$sale_remarkk12."','".$product_id12."','".$product_id12."','".$br_period12."')";
$objQuery12 = mysqli_query($conn,$strSQL12);
}
}

if($product_id13 !=''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id13."' ";
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
	
$unit1 = $sale_count13*$objResult31["unit1"];
$unit2 = $sale_count13*$objResult31["unit2"];
$unit3 = $sale_count13*$objResult31["unit3"];
$unit4 = $sale_count13*$objResult31["unit4"];
$unit5 = $sale_count13*$objResult31["unit5"];
$unit6 = $sale_count13*$objResult31["unit6"];
$unit7 = $sale_count13*$objResult31["unit7"];
$unit8 = $sale_count13*$objResult31["unit8"];
$unit9 = $sale_count13*$objResult31["unit9"];
$unit10 =$sale_count13*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
	
if($id_product1 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price13."','".$sum_amount13."','".$sale_remarkk13."','".$id_product1."','".$id_product1."','".$br_period13."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk13."','".$id_product2."','".$id_product2."','".$br_period13."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk13."','".$id_product3."','".$id_product3."','".$br_period13."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk13."','".$id_product4."','".$id_product4."','".$br_period13."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk13."','".$id_product5."','".$id_product5."','".$br_period13."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk13."','".$id_product6."','".$id_product6."','".$br_period13."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk13."','".$id_product7."','".$id_product7."','".$br_period13."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk13."','".$id_product8."','".$id_product8."','".$br_period13."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk13."','".$id_product9."','".$id_product9."','".$br_period13."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk13."','".$id_product10."','".$id_product10."','".$br_period13."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{				
					

$strSQL13 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$sale_count13."','".$sale_count13."','".$product_price13."','".$sum_amount13."','".$sale_remarkk13."','".$product_id13."','".$product_id13."','".$br_period13."')";
$objQuery13 = mysqli_query($conn,$strSQL13);
}
}

if($product_id14 !=''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id14."' ";
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
	
$unit1 = $sale_count14*$objResult31["unit1"];
$unit2 = $sale_count14*$objResult31["unit2"];
$unit3 = $sale_count14*$objResult31["unit3"];
$unit4 = $sale_count14*$objResult31["unit4"];
$unit5 = $sale_count14*$objResult31["unit5"];
$unit6 = $sale_count14*$objResult31["unit6"];
$unit7 = $sale_count14*$objResult31["unit7"];
$unit8 = $sale_count14*$objResult31["unit8"];
$unit9 = $sale_count14*$objResult31["unit9"];
$unit10 =$sale_count14*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
	
if($id_product1 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price14."','".$sum_amount14."','".$sale_remarkk14."','".$id_product1."','".$id_product1."','".$br_period14."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk14."','".$id_product2."','".$id_product2."','".$br_period14."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk14."','".$id_product3."','".$id_product3."','".$br_period14."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk14."','".$id_product4."','".$id_product4."','".$br_period14."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk14."','".$id_product5."','".$id_product5."','".$br_period14."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk14."','".$id_product6."','".$id_product6."','".$br_period14."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk14."','".$id_product7."','".$id_product7."','".$br_period14."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk14."','".$id_product8."','".$id_product8."','".$br_period14."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk14."','".$id_product9."','".$id_product9."','".$br_period14."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk14."','".$id_product10."','".$id_product10."','".$br_period14."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{				
					
	

$strSQL14 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$sale_count14."','".$sale_count14."','".$product_price14."','".$sum_amount14."','".$sale_remarkk14."','".$product_id14."','".$product_id14."','".$br_period14."')";
$objQuery14 = mysqli_query($conn,$strSQL14);
}
}

if($product_id15 !=''  ){

$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id15."' ";
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
	
$unit1 = $sale_count15*$objResult31["unit1"];
$unit2 = $sale_count15*$objResult31["unit2"];
$unit3 = $sale_count15*$objResult31["unit3"];
$unit4 = $sale_count15*$objResult31["unit4"];
$unit5 = $sale_count15*$objResult31["unit5"];
$unit6 = $sale_count15*$objResult31["unit6"];
$unit7 = $sale_count15*$objResult31["unit7"];
$unit8 = $sale_count15*$objResult31["unit8"];
$unit9 = $sale_count15*$objResult31["unit9"];
$unit10 =$sale_count15*$objResult31["unit10"];
	
if($Num_Rows31 > 0){
	
if($id_product1 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit1."','".$unit1."','".$product_price15."','".$sum_amount15."','".$sale_remarkk15."','".$id_product1."','".$id_product1."','".$br_period15."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product2 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit2."','".$unit2."','0.00','0.00','".$sale_remarkk15."','".$id_product2."','".$id_product2."','".$br_period15."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}
	
if($id_product3 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit3."','".$unit3."','0.00','0.00','".$sale_remarkk15."','".$id_product3."','".$id_product3."','".$br_period15."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product4 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit4."','".$unit4."','0.00','0.00','".$sale_remarkk15."','".$id_product4."','".$id_product4."','".$br_period15."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product5 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit5."','".$unit5."','0.00','0.00','".$sale_remarkk15."','".$id_product5."','".$id_product5."','".$br_period15."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product6 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remarkk15."','".$id_product6."','".$id_product6."','".$br_period15."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product7 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remarkk15."','".$id_product7."','".$id_product7."','".$br_period15."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product8 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remarkk15."','".$id_product8."','".$id_product8."','".$br_period15."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product9 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remarkk15."','".$id_product9."','".$id_product9."','".$br_period15."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
if($id_product10 !=''){
$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remarkk15."','".$id_product10."','".$id_product10."','".$br_period15."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
	
	
}else{				
						

$strSQL15 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd)
values ('".$ref_id_br."','".$sale_count15."','".$sale_count15."','".$product_price15."','".$sum_amount15."','".$sale_remarkk15."','".$product_id15."','".$product_id15."','".$br_period15."')";
$objQuery15 = mysqli_query($conn,$strSQL15);
}
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
 if($company=='1'){
 	$type_company='ออลล์เวล ไลฟ์ บจก.';
	}else if($company=='2'){
	$type_company='โนเบิล เมด บจก.';	
	}
 $customer_name=$_POST["customer_name"];
 $customer_tel=$_POST["customer_tel"];
 $address_name=$_POST["address_name"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
	$bus_inter =$_POST["bus_inter"];
$on_time=$_POST["on_time"];	
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
 $product_name=$_POST["product"];
$returns_name = "รับคืน $product_name";
 $product_sn=$_POST["product_sn"];
 $unit_credit=$_POST["unit_credit"];
 $price=$_POST["unit_cash"];
 $employee_name=$_POST["employee_name"];
 $employee_tel=$_POST["employee_tel"];
 $address_1 =$_POST["address_1"];
$address_to ="$address_1 $province_name";
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
$h_employee_name =$_POST["h_employee_name"];
$sum_address = "$address_name $address_send";		

$sql = "SELECT *   FROM st__signature where ref_id = '".$ref_id."'";
$qry = mysqli_query($new,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	
if($rs["cs_name"]=='' and $rs["cs_code"]==''){	
	
	
$strSQL66 =  "Update tb_register_data set start_date = '".$start_date."',between_date ='".$between_date."',start_time ='".$start_time."',end_time ='".$end_time."',status ='".$status."',fix_date ='".$fix_date."',no_price ='".$no_price."',call_customer ='".$call_customer."',credit ='".$credit."',call_employee ='".$call_employee."',cash ='".$chash."',check_peper ='".$check_peper."',bill = '".$bill."',department ='".$department."',type_customer ='".$type_customer."',type_company = '".$type_company."',customer_name ='".$customer_name."',customer_tel ='".$customer_tel."',address_name ='".$address_name."',address_send ='".$address_send."',want_bus ='".$want_bus."',product_name ='".$product_name."',product_sn ='".$product_sn."',unit_credit ='".$unit_credit."',price ='".$price."',employee_name ='".$employee_name."',employee_tel ='".$employee_tel."',add_by ='".$add_by."',description ='".$description."',have_map = '".$havemap."',add_date ='$add_date',unit_bill ='".$unit_bill."',unit_check ='".$unit_check."',unit_tran ='".$unit_tran."',tran ='".$tran."',check_detail ='".$check_detail."',dep ='".$dep."',dept ='".$dept."',department_show ='".$department_show."',customer_contact = '".$customer_contact."',status_comment = '".$status_comment."',on_time = '".$on_time."',address_1 ='".$address_1."',add_code = '".$h_employee_name."',bus_inter='".$bus_inter."',province_name='".$province_name."'  where ref_id = '".$ref_id_br."'";
$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());
	
if($job_no!=''){	
	
$strSQLn =  "Update tb_register_data set start_date = '".$start_date."',between_date ='".$between_date."',start_time ='".$start_time."',end_time ='".$end_time."',status ='".$status."',fix_date ='".$fix_date."',no_price ='".$no_price."',call_customer ='".$call_customer."',credit ='".$credit."',call_employee ='".$call_employee."',cash ='".$chash."',check_peper ='".$check_peper."',bill = '".$bill."',department ='".$department."',type_customer ='".$type_customer."',type_company = '".$type_company."',customer_name ='".$customer_name."',customer_tel ='".$customer_tel."',address_name ='".$address_to."',address_send ='".$sum_address."',want_bus ='".$want_bus."',product_name ='".$product_name."',product_sn ='".$product_sn."',unit_credit ='".$unit_credit."',price ='".$price."',employee_name ='".$employee_name."',employee_tel ='".$employee_tel."',add_by ='".$add_by."',description ='".$description."',have_map = '".$havemap."',add_date ='$add_date',unit_bill ='".$unit_bill."',unit_check ='".$unit_check."',unit_tran ='".$unit_tran."',tran ='".$tran."',check_detail ='".$check_detail."',dep ='".$dep."',dept ='".$dept."',department_show ='".$department_show."',customer_contact = '".$customer_contact."',status_comment = '".$status_comment."',on_time = '".$on_time."',province_name='".$province_name."'  where running = '".$job_no."'";
$objQueryn = mysqli_query($com1,$strSQLn) or die(mysqli_error());	
	
}	
}
	
	


	
if( $send_cs =='2'){
	
	$save22="Update  tb_register_data set
product_sn ='".$product_sn."'  where running='".$job_no."'";

$qsave22=mysqli_query($com1,$save22);
}

if( $send_cs =='1'){

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(running) AS MAXID FROM tb_register_data";
$qry = mysqli_query($com1,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId1 = substr($rs['MAXID'],0,-4);

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


	
$strSQL89 =  "insert into tb_register_data (running,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,address_bus,customer_contact,on_time,add_code,bus_inter,ref_id,return_ckk) 

values('".$nextId."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','ส่ง','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_to."','".$sum_address."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$province_name."','".$customer_contact."','".$on_time."','".$h_employee_name."','".$bus_inter."','".$ref_id_br."','3')";

//echo $strSQL89;
//exit();

 $objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());


 
 $strSQL90 =  "insert into tb_transaction (running) 

values('".$nextId."')";

$objQuery90 = mysqli_query($com1,$strSQL90) or die(mysqli_error());
		

	
	
if($returns=='1' and $sale_code !='MM2'){
	
/*$save9="insert into tb_register_br
(company,br_date,iv_no,customer_name,add_by,add_date,doc_2) values ('".$company."','".$iv_date."','".$iv_no."','".$customer."','".$add_by."','".$add_date."','1')";
$qsave9=mysqli_query($conn,$save9);*/
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(running) AS MAXID FROM tb_register_data";
$qry = mysqli_query($com1,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId1 = substr($rs['MAXID'],0,-4);

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 2);
$maxId2 = substr("00000".$maxId1, -4);
$nextId1 = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId1 = $yearMonth.$maxId1;

}


$strSQL99 =  "insert into tb_register_data (running,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,address_bus,customer_contact,on_time,ref_id,return_ckk) 

values('".$nextId1."','".$returns_date."','".$return_date_bet."','".$returns_time."','".$end_time."','รับ','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$returns_contact."','".$customer_tel."','".$returns_address."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$returns_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$province_name."','".$customer_contact."','".$on_time."','".$ref_id_br."','1')";

//echo $strSQL89;
//exit();

 $objQuery99 = mysqli_query($com1,$strSQL99) or die(mysqli_error());


 
 $strSQL91 =  "insert into tb_transaction (running) 

values('".$nextId1."')";


//echo $strSQL90;
//exit();
$objQuery91 = mysqli_query($com1,$strSQL91) or die(mysqli_error());
		
	
	
}
	
$strSQL26="Update  hos__br set job_no ='".$nextId."',job_no1 ='".$nextId1."',send_cs ='2'  where ref_id_br='".$ref_id_br."'";
$objQuery26 = mysqli_query($conn,$strSQL26);	
	}


$strSQL89="Update  st__main set iv_no = '".$iv_no."'  where ref_idsale='".$ref_id_br."'";
$objQuery89 = mysqli_query($new,$strSQL89);



 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminbrhos_edit.php?ref_id_br=$ref_id_br';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}

