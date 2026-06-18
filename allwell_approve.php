<?php
include "dbconnect.php";
include "dbconnect_acc.php";
 include('head.php'); 


if($_GET['ref_id']!=''){
$ref_id=$_GET['ref_id'];
$approve_name= $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');	
$que_ckk = $_GET['que_ckk'];
$employee_name = $_GET['employee_name'];
$customer_name = $_GET["customer_name"];	
		

	
$strSQL25="Update  so__main set approve_complete='Approve',approve_name='".$approve_name."',approve_date = '".$add_date."'  where ref_id='".$ref_id."'";
$objQuery25 = mysqli_query($conn,$strSQL25);


$strSQL27="Update  so__submain set status_sol='Approve'  where ref_idd = '".$ref_id."'";
$objQuery27 = mysqli_query($conn,$strSQL27);	
	
	
}

if($_POST['ref_id']!=''){

$ref_id=$_POST['ref_id'];
$approve_name= $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');

$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$sn = $_POST["sn"];
$product_id = $_POST["product_id"];
$clear_br = $_POST["clear_br"];
$clear_ivno = $_POST["clear_ivno"];
$que_ckk = $_POST['que_ckk'];
$billing_name = $_POST["billing_name"];	
$employee_name = $_POST['employee_name'];	
$jong_ckk = $_POST['jong_ckk'];	
$jong_no = $_POST['jong_no'];	
	

foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$clear_ivno_new = $clear_ivno[$key];
		$sn_new=$sn[$key];
	    $clear_br_new = $clear_br[$key];
        $product_id_new =$product_id[$key];
	 	$jong_ckk_new = $jong_ckk[$key];
        $jong_no_new =$jong_no[$key];
		
	if($clear_ivno_new !=''){
		

$sql21 = "SELECT ref_id   FROM   so__main   where  doc_no = '".$clear_ivno_new."' and cancel_ckk='0'";
$qry21 = mysqli_query($conn,$sql21) or die(mysqli_error());
$rs21 = mysqli_fetch_assoc($qry21);

	
$sql22 = "SELECT sum(sale_count) as sale_count   FROM   so__submain   where  ref_idd = '".$rs21['ref_id']."' and product_id = '".$product_id_new."'";
$qry22 = mysqli_query($conn,$sql22) or die(mysqli_error());
$rs22 = mysqli_fetch_array($qry22);	
	
$sql3 = "SELECT sum(sale_count) as count3   FROM   hos__subspr   where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$clear_ivno_new."' and status_spr ='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso  where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$clear_ivno_new."' and status_so ='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$clear_ivno_new."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
$rs41 = mysqli_fetch_array($qry41);

$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '".$rs41['ref_id']."' and product_id = '".$product_id_new."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM hos__subsmp where  product_id = '".$product_id_new."' and clear_br = '1' and br_no ='".$clear_ivno_new."' and status_smp ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];		
$count2 = ($rs22['sale_count'] - ($count3+$count4+$count5+$count13))-$sale_count_new;
if($count2 <='0'){
$save6="Update  so__submain set  clear_ckk = '1'    where ref_idd = '".$rs21['ref_id']."' and product_id = '".$product_id_new."'";
$qsave6=mysqli_query($conn,$save6);

}

if($count2 < '0'){

echo "<script language=\"JavaScript\">";
echo "alert('สินค้าในใบยืมนี้มีไม่พอในการเคลียร์ยืมครั้งนี้ค่ะ');window.location='allwell_approve_sale.php?ref_id=$ref_id';";
echo "</script>";
exit();
	
}		
	 
	}
	
if($jong_ckk_new!=''){	
	
$strSQL = "SELECT * FROM hos__jongproduct WHERE iv_no = '".$jong_ckk_new."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT * FROM hos__subjongpro  WHERE ref_idd = '".$objResult["ref_id"]."' and product_id ='".$product_id_new."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$sql3 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '".$objResult1['product_id']."' and jong_ckk = '1' and jong_no ='".$objResult["iv_no"]."' and status_sol ='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);
	
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$objResult1['product_id']."' and jong_ckk = '1' and jong_no ='".$objResult["iv_no"]."' and status_so ='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_assoc($qry13);
	

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
	
$count2 = $objResult1["count"] - ($count3+$count13);

if($count2=='0'){

$strSQL1 = "Update  hos__subjongpro set  close_ckk ='1' where  ref_idd = '".$objResult["ref_id"]."' and product_id ='".$product_id_new."'";
$objQuery1 = mysqli_query($conn,$strSQL1);


}
if($count2 < '0'){

echo "<script language=\"JavaScript\">";
echo "alert('สินค้าในใบจองนี้มีไม่พอในการเคลียร์จองครั้งนี้ค่ะ');window.location='allwell_approve_sale.php?ref_id=$ref_id';";
echo "</script>";
exit();
	
}		
	
}	
 }


$strSQLboo = "SELECT objective FROM so__main WHERE ref_id = '".$ref_id."'";
$objQueryboo= mysqli_query($conn,$strSQLboo) or die(mysqli_error());
$objResultboo = mysqli_fetch_array($objQueryboo);

if($objResultboo["objective"]=='7'){	

$strSQL25="Update  so__main set send_dm='1',approve_complete='Request',approve_name='".$approve_name."',approve_date = '".$add_date."'  where ref_id='".$ref_id."'";
$objQuery25 = mysqli_query($conn,$strSQL25);
		
}else{	

$strSQL25="Update  so__main set approve_complete='Approve',approve_name='".$approve_name."',approve_date = '".$add_date."'  where ref_id='".$ref_id."'";
$objQuery25 = mysqli_query($conn,$strSQL25);


$strSQL27="Update  so__submain set status_sol='Approve'  where ref_idd = '".$ref_id."'";
$objQuery27 = mysqli_query($conn,$strSQL27);
}


$strSQL = "SELECT *  FROM so__main  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$doc_no = $objResult["doc_no"];
$account_approve = $objResult["account_approve"];
$doc_noo = substr($doc_no,0,4);
	
	if($doc_noo=="IV24"){
		$com ="บิลเงินสด";
	}else if ($objResult["select_type_doc"]=='3'){
		$com ="ออลล์เวล ไลฟ์ บจก.";
	}else if ($objResult["select_type_doc"]=='4'){
	$com="โนเบิล เมด บจก.";	
	}
	
	
	
	$cash = $objResult["payment"];
	if($cash=='36' or $cash=='38' or $cash=='39' or $cash=='40' or $cash=='40' or $cash=='42'){
	$credit = '1';	
	}else{
	$credit = '0';		
	}
	
	
	$doc_no1 = substr($doc_no,0,2);
	
$bill_id = $objResult["bill_id"];
	
	
		/*if($objResult["sale_channel"]=='1' or $objResult["sale_channel"]=='20' or $objResult["sale_channel"]=='12' or $objResult["payment"]=='7' or $objResult["payment"]=='8'){
		$amount_1 = "0.00";
	}else {	}*/
	
	
	if($account_approve=='1'){
		
		$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$ref_id."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$amount_1 = $objResult15["amount_1"];
		
		
if($objResult["delivery_date"]!='0000-00-00'){		
$delivery_date = $objResult["delivery_date"];
}else{
$delivery_date = $objResult["register_date"];	
}	
$billing_name = $objResult["billing_name"];
$transfer_date = $objResult["transfer_date"];
		
		
	$strSQL29="insert into   tb_register_data ( IV_number,date_inv,company,customer_name,date_tranfer,unit_cash,
cash,employee_name,bill_id,credit) values ('".$doc_no."','".$delivery_date."','".$com."','".$billing_name."','".$transfer_date."','".$amount_1."','".$cash."','".$approve_name."','".$ref_id."','".$bill_id."','".$credit."')";
//echo $strSQL29;
		//exit();
$objQuery29 = mysqli_query($code,$strSQL29);	
	
		
		}

/*$sql3 = "select * from so__main where ref_id = '".$_GET["ref_id"]."'";
$query3 = mysqli_query($conn,$sql3);
$fetch3 = mysqli_fetch_array($query3,MYSQLI_ASSOC); 

$sql1 = "select * from tb_register_data where ref_id = '".$_GET["ref_id"]."'";
$query1 = mysqli_query($conn,$sql1);
$num1=mysqli_num_rows($query1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 

 $between_date =$fetch1["date_requir"];
 $start_time=$fetch1["start_time"];
 $end_time=$fetch1["end_time"];
 $status=$fetch1["status"];
$product_name =$fetch1["product_name"];
	
 if ($fetch1["date"]!=''){
		$start_date =$fetch1["date"];
	}else{
		$start_date='0000-00-00';
	}
	
	if ($fetch1['fix_datetime']!=''){
		$fix_date=$fetch1['fix_datetime'];
	}else{
		$fix_date='0';
	}
	
	if ($fetch1['no_money']!=''){
        $no_price=$fetch1['no_money'];
	}else{
		$no_price='0';
	}
	if ($fetch1['call_customer']!=''){
		 $call_customer=$fetch1['call_customer'];
	}else{
		$call_customer='0';
	}
	if ($fetch1['credit_card']!=''){
		 $credit=$fetch1['credit_card'];
	}else{
		$credit='0';
	}
	if ($fetch1['call_back']!=''){
		 $call_employee=$fetch1['call_back'];
	}else{
		$call_employee='0';
	}
	
	if ($fetch1['cash']!=''){
		 $chash=$fetch1['cash'];
	}else{
		$chash='0';
	}
	if ($fetch1['check_paper']!=''){
	 $check_peper=$fetch1['check_paper'];
	}else{
		$check_peper='0';
	}
	if ($fetch1['check_paper']!=''){
		$check_peper=$fetch1['check_paper'];
	}else{
		$check_peper='0';
	}
	if ($fetch1['bill']!=''){
		 $bill=$fetch1['bill'];
	}else{
		$bill='0';
	}
	if ($fetch1['want_bus']!=''){
	$want_bus=$fetch1['want_bus'];
	}else{
		$want_bus='0';
	}
	if ($fetch1['tran']!=''){
		 $tran=$fetch1["tran"];
	}else{
		$tran='0';
	}
	if ($fetch1['ckk']!=''){
		 $check_detail=$fetch1["ckk"];
	}else{
		$check_detail='0';
	}
	
		if ($fetch1['dep']!=''){
		  $dep=$fetch1["dep"];
	}else{
		$dep='0';
	}

 $department=$fetch1["department_name"];
 $type_customer=$fetch1["customer_typename"];
 $type_company=$fetch1["company_name"];
 $customer_name=$fetch1["customer_name"];
 $customer_tel=$fetch1["customer_tel"];
 $address_name=$fetch1["address_name"];
 $address_send=$fetch1["address_send"];
$customer_contact =$fetch1["customer_contact"];
	
	
 $amphur_name=$fetch1["amphur_name"];
 $province_name=$fetch1["province_name"];
 
$product_sn = $_POST["doc_no"];
 $unit_credit=$fetch1["unit_credit"];
 $price=$fetch1["unit_cash"];
 $employee_name=$fetch1["employee_name"];
 $employee_tel=$fetch1["employee_tel"];
 
 $description=$fetch1["description"];
 $havemap=$fetch1['have_map'];
$unit_check=$fetch1["unit_check"];
$unit_bill=$fetch1["unit_bill"];
$unit_tran=$fetch1["unit_tran"];
$mk_research = $fetch1["mk_research"];

$unit_check1 = str_replace(',', '', $unit_check);
$unit_bill1 = str_replace(',', '', $unit_bill);


$sql2 = "select * from tb_transaction where ref_id = '".$_GET["ref_id"]."'";
$query2 = mysqli_query($conn,$sql2);
$fetch2 = mysqli_fetch_array($query2,MYSQLI_ASSOC); 


	if ($fetch2['runway']!=''){
		$runway=$fetch2["runway"];
	}else{
		$runway='0';
	}

if ($fetch2['road']!=''){
		$road=$fetch2["road"];
	}else{
		$road='0';
	}

if ($fetch2['soy']!=''){
	$soy=$fetch2["soy"];
	}else{
		$soy='0';
	}
	
	if ($fetch2['car_load']!=''){
	$car_load=$fetch2["car_load"];
	}else{
		$car_load='0';
	}

if ($fetch2['no_car_road']!=''){
	$no_car_road=$fetch2["no_car_road"];
	}else{
		$no_car_road='0';
	}
	
	if ($fetch2['car_road']!=''){
	$car_road=$fetch2["car_road"];
	}else{
		$car_road='0';
	}
if ($fetch2['car_home']!=''){
	$car_home=$fetch2["car_home"];
	}else{
		$car_home='0';
	}

	if ($fetch2['slope']!=''){
	$slope=$fetch2["slope"];	
	}else{
		$slope='0';
	}

	
	if ($fetch2['bundai']!=''){
	$bundai=$fetch2["bundai"];
	}else{
		$bundai='0';
	}

	if ($fetch2['bundai_install']!=''){
	$bundai_install=$fetch2["bundai_install"];
	}else{
		$bundai_install='0';
	}

	if ($fetch2['lip']!=''){
	$lip=$fetch2["lip"];
	}else{
		$lip='0';
	}

	
	if ($fetch2['want_employee']!=''){
	$want_employee=$fetch2["want_employee"];	
	}else{
		$want_employee='0';
	}

	if ($fetch2['want_ex']!=''){
	$want_ex=$fetch2["want_ex"];	
	}else{
		$want_ex='0';
	}

	
	if ($fetch2['want_credit']!=''){
	$want_credit=$fetch2["want_credit"];
	}else{
		$want_credit='0';
	}
if ($fetch2['want_prem']!=''){
	$want_prem=$fetch2["want_prem"];	
	}else{
		$want_prem='0';
	}
	
	if ($fetch2['head_bad']!=''){
	$head_bad=$fetch2["head_bad"];	
	}else{
		$head_bad='0';
	}

	
	if ($fetch2['height_ltd']!=''){
	$height_ltd=$fetch2["height_ltd"];	
	}else{
		$height_ltd='0';
	}
if ($fetch2['up']!=''){
	$up=$fetch2["up"];	
	}else{
		$up='0';
	}
if ($fetch2['no_up']!=''){
	$no_up=$fetch2["no_up"];	
	}else{
		$no_up='0';
	}

	
	
	
$type_bundai=$fetch2["type_bundai"];	
	
	
	
$soy_long=$fetch2["soy_long"];
$soy_big=$fetch2["soy_big"];
$car_park=$fetch2["car_park"];
$door_long=$fetch2["door_long"];
$unit_bundai=$fetch2["unit_bundai"];
$door_big=$fetch2["door_bigger"];
$door_longer=$fetch2["door_longer"];
$type_door=$fetch2["type_door"];
$home_type=$fetch2["home_type"];
$install=$fetch2["install"];
$bundai_big=$fetch2["bundai_big"];
$lip_big=$fetch2["lip_big"];
$lip_long=$fetch2["lip_long"];
$lip_weight=$fetch2["lip_weight"];
$employee_unit=$fetch2["employee_unit"];
$ferniger_name=$fetch2["ferniger_name"];
$ferniger_address=$fetch2["ferniger_address"];
$number=$fetch2["number"];
$status_comment=$fetch2["status_comment"];

$dept=$fetch2["dept"];
$room_bigger=$fetch2["room_bigger"];
$room_longer=$fetch2["room_longer"];
$bundai_hug=$fetch2["bundai_hug"];
$bank=$fetch2["bank"];
$add_code=$fetch2["add_code"];

$department_show=$fetch2["department_show"];
$description_ja=$fetch2["description_ja"];
$time1="$start_time-$end_time";
//echo $time1;
//Exit();
$add_date = date('Y-m-d H:i:s');
	
$sql3 = "select * from so__main where ref_id = '".$_GET["ref_id"]."'";
$query3 = mysqli_query($conn,$sql3);
$fetch3 = mysqli_fetch_array($query3,MYSQLI_ASSOC); 
	
$employee_name = $fetch3["employee_name"];	
$add_by = $fetch3["add_by"];
	//echo $add_by;
	
	


	
	if($fetch3["send_cs"] =='1'){
		
	
include("dbconnect_cs.php");
	


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

$strSQL89 =  "insert into tb_register_data (running,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,address_bus,customer_contact,add_code,mk_research,sale_code) 

values('".$nextId."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','ลูกค้าทั่วไป','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$province_name."','".$customer_contact."','".$add_code."','".$mk_research."','".$employee_name."')";

//echo $strSQL89;

 $objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());


 
 $strSQL90 =  "insert into tb_transaction (running,runway,road,soy,soy_long,soy_big,car_load,car_park,car_road,no_car_road,car_home,door_long,slope,bundai,unit_bundai,door_big,door_longer,type_door,home_type,install,bundai_install,bundai_big,lip,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,ferniger_address,want_ex,want_credit,want_prem,add_date,add_by,room_bigger,room_longer,bundai_hug,bank,description,type_bundai,head_bad,height_ltd,up,no_up) 

values('".$nextId."','".$runway."','".$road."','".$soy."','".$soy_long."','".$soy_big."','".$car_load."','".$car_park."','".$car_road."','".$no_car_road."','".$car_home."','".$door_long."','".$slope."','".$bundai."','".$unit_bundai."','".$door_big."','".$door_longer."','".$type_door."','".$home_type."','".$install."','".$bundai_install."','".$bundai_big."','".$lip."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$ferniger_address."','".$want_ex."','".$want_credit."','".$want_prem."','$add_date','".$add_by."','".$room_bigger."','".$room_longer."','".$bundai_hug."','".$bank."','".$description_ja."','".$type_bundai."','".$head_bad."','".$height_ltd."','".$up."','".$no_up."')";


//echo $strSQL90;
//exit();
$objQuery90 = mysqli_query($com1,$strSQL90) or die(mysqli_error());
		
$strSQL26="Update  so__main set job_id='".$nextId."'  where ref_id='".$ref_id."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	
	}*/
}


 if($objQuery25){
	 
if($que_ckk=='1'){
	
if($customer_name!=''){	

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "QSKtBh5RtlRkR6qE9p3APwPzvO3qCyR5B0dqULqYsOq";
$sMessage = "
มีเอกสารใบยืม เลขที่อ้างอิง  : $ref_id
ลูกค้า : $billing_name
เขตการขาย : $employee_name
มีการติ๊กงานด่วน รบกวนตรวจสอบรายละเอียดใบยืมตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
";
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
	
	
}else{
	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "QSKtBh5RtlRkR6qE9p3APwPzvO3qCyR5B0dqULqYsOq";
$sMessage = "
มีเอกสารใบสั่งขาย เลขที่อ้างอิง  : $ref_id
ลูกค้า : $billing_name
เขตการขาย : $employee_name
มีการติ๊กงานด่วน รบกวนตรวจสอบรายละเอียดใบสั่งขายตามลิงค์ได้เลยค่ะ
กรุณาคลิ๊กลิงค์ sol.allwellcenter.com
";
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
	
}	 
	 
	 
	 
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_approve_sol.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }

//ทำหน้า connect Database CS
	
?>