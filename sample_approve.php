<?php
include "dbconnect.php";
include "dbconnect_cs.php";
include('head.php');

date_default_timezone_set("Asia/Bangkok");

  $ref_idsmp = $_POST['ref_idsmp'];
  $comment_sup = $_POST['comment_sup'];
  $sup_date = date('Y-m-d');
  $sup_name = $_SESSION['name'];
  $sale_code = $_POST['sale_code'];
 $sale_name = $_POST['sale_name'];
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
 $customer_name1=$_POST["customer_name1"];
 $customer_tel=$_POST["customer_tel"];
 $address_name1=$_POST["address_name1"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
$on_time = $_POST["on_time"];
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
 $product_name=$_POST["product"];
 $product_sn_re=$_POST["product_sn"];
 $product_sn = "$product_sn_re เลขที่อ้างอิง : $ref_idsmp";
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
$address_1 =$_POST["address_1"];
$address_to ="$address_1 $province_name";
$add_code = $_POST["h_employee_name"];
$delivery_type 	= $_POST["delivery_type"];
$add_date = date('Y-m-d H:i:s');	



$id = $_POST["subsmp_id"];
$product_id = $_POST["product_id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remark = $_POST["sale_remark"];
$clear_br = $_POST["clear_br"];
$br_no = $_POST["br_no"];
$sn	= $_POST["sn"];


 foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
        $product_id_new =$product_id[$key];
		$sale_remark_new = $sale_remark[$key];
	    $clear_br_new = $clear_br[$key];
	    $br_no_new = $br_no[$key];
	    $sn_new = $sn[$key];
		$sum_amount_new = $product_price_new *$sale_count_new;

if($br_no_new !=''){
	
$sql1 = "SELECT ref_id_br   FROM   hos__br   where  iv_no = '".$br_no_new."' and status_doc = 'Approve'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

	
$sql2 = "SELECT sum(count) as sale_count   FROM   hos__subbr   where  ref_idd_br = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_array($qry2);
	
	
$sql21 = "SELECT ref_id   FROM   so__main   where  doc_no = '".$br_no_new."' and cancel_ckk = '0'";
$qry21 = mysqli_query($conn,$sql21) or die(mysqli_error());
$rs21 = mysqli_fetch_assoc($qry21);

	
$sql22 = "SELECT sum(sale_count) as sale_count   FROM   so__submain   where  ref_idd = '".$rs21['ref_id']."' and product_id = '".$product_id_new."'";
$qry22 = mysqli_query($conn,$sql22) or die(mysqli_error());
$rs22 = mysqli_fetch_array($qry22);
	

$sql5 = "SELECT ref_id FROM   hos__breg   where  iv_no = '".$br_no_new."' and status_doc = 'Approve'";
$qry5 = mysqli_query($conn,$sql5) or die(mysqli_error());
$rs5 = mysqli_fetch_assoc($qry5);

	
$sql51 = "SELECT sum(count1) as sale_count   FROM   hos__subbreg1   where  ref_id1 = '".$rs5['ref_id']."' and product_id1 = '".$product_id_new."'";
$qry51 = mysqli_query($conn,$sql51) or die(mysqli_error());
$rs51 = mysqli_fetch_array($qry51);	
	
	


$sql3 = "SELECT sum(sale_count) as count3   FROM  hos__subspr  where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$br_no_new."' and status_spr='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM hos__subso where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$br_no_new."' and status_so ='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$br_no_new."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
$rs41 = mysqli_fetch_array($qry41);

$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '".$rs41['ref_id']."' and product_id = '".$product_id_new."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM hos__subsmp where  product_id = '".$product_id_new."' and clear_br = '1' and br_no ='".$br_no_new."' and status_smp ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs3["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];

	
$count2 = (($rs2['sale_count']+$rs22['sale_count']+$rs51['sale_count']) - ($count3+$count4+$count5+$count13+$sale_count_new));
	
if($count2=='0'){

$save6="Update  hos__subbr set  clear_ckk = '1'    where ref_idd_br = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";
$qsave6=mysqli_query($conn,$save6);
	
	
$save6="Update  so__submain set  clear_ckk = '1'    where ref_idd = '".$rs21['ref_id']."' and product_id = '".$product_id_new."'";
$qsave6=mysqli_query($conn,$save6);	
	
$save6="Update  hos__subbreg1 set  clear_ckk = '1'    where ref_id1 = '".$rs5['ref_id']."' and product_id1 = '".$product_id_new."'";
$qsave6=mysqli_query($conn,$save6);		

}


		

if($count2 < 0){

echo "<script language=\"JavaScript\">";
echo "alert('สินค้าในใบยืมนี้มีไม่พอในหารเคลียร์ยืมครั้งนี้ค่ะ');window.location='supsmp_approve.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
exit();
	
}

}
	}

$strSQL1 = "SELECT * FROM  (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$ref_idsmp."' and product_type = 'สินค้าขาย'";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
  

$strSQL2 = "SELECT * FROM  hos__subsmp WHERE reff_idsmp = '".$ref_idsmp."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
$rs102 = mysqli_fetch_array($objQuery2);    
 if($rs102["sale_count"]>='100'){
	 
 $save="Update  hos__smp set  send_dm = '1',comment_sup='".$comment_sup."',sup_date = '".$sup_date."',sup_name='".$sup_name."',sup_adddate='".$add_date."'  where ref_idsmp = '".$ref_idsmp."' ";
	
$qsave=mysqli_query($conn,$save);	
	
			$fline=mysqli_fetch_array($line);
			$sToken = "gCe7s6XlzcHFCtuVNBF2D2g6xbZZS7PrmPz5vpQBc6G";
			$sMessage = "
			คุณ : $sale_name มีการสร้างใบเบิกสินค้า SMP
			เลขที่อ้างอิง : $ref_idsmp
			รบกวนทำการตรวจสอบข้อมูล
			และอนุมัติการร้องขอ ตามลิงค์ด้านล่างได้เลยคะ
			https://sol.allwellcenter.com			
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
			if(curl_error($chOne)) {
				echo 'error:' . curl_error($chOne);
			}
			else {
				$result_ = json_decode($result, true);
				echo "status : ".$result_['status']; echo "message : ". $result_['message'];
				}
			curl_close( $chOne );  
	
	
			
			$fline=mysqli_fetch_array($line);
			$sToken = "I9fEDAgfYAuSbsHACVyUDUPbAJhVMB9LY554hBZiNWH";
			$sMessage = "
			คุณ : $sale_name มีการสร้างใบเบิกสินค้า SMP
			เลขที่อ้างอิง : $ref_idsmp
			รบกวนทำการตรวจสอบข้อมูล
			และอนุมัติการร้องขอ ตามลิงค์ด้านล่างได้เลยคะ
			https://sol.allwellcenter.com			
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
			if(curl_error($chOne)) {
				echo 'error:' . curl_error($chOne);
			}
			else {
				$result_ = json_decode($result, true);
				echo "status : ".$result_['status']; echo "message : ". $result_['message'];
				}
			curl_close( $chOne );
	

}else if($Num_Rows1 > 0){
	
 $save="Update  hos__smp set  send_dm = '1',comment_sup='".$comment_sup."',sup_date = '".$sup_date."',sup_name='".$sup_name."',sup_adddate='".$add_date."'  where ref_idsmp = '".$ref_idsmp."' ";
	
$qsave=mysqli_query($conn,$save);	
	
			$fline=mysqli_fetch_array($line);
			$sToken = "gCe7s6XlzcHFCtuVNBF2D2g6xbZZS7PrmPz5vpQBc6G";
			$sMessage = "
			คุณ : $sale_name มีการสร้างใบเบิกสินค้า SMP
			เลขที่อ้างอิง : $ref_idsmp
			รบกวนทำการตรวจสอบข้อมูล
			และอนุมัติการร้องขอ ตามลิงค์ด้านล่างได้เลยคะ
			https://sol.allwellcenter.com			
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
			if(curl_error($chOne)) {
				echo 'error:' . curl_error($chOne);
			}
			else {
				$result_ = json_decode($result, true);
				echo "status : ".$result_['status']; echo "message : ". $result_['message'];
				}
			curl_close( $chOne );  
	
	
			
			$fline=mysqli_fetch_array($line);
			$sToken = "I9fEDAgfYAuSbsHACVyUDUPbAJhVMB9LY554hBZiNWH";
			$sMessage = "
			คุณ : $sale_name มีการสร้างใบเบิกสินค้า SMP
			เลขที่อ้างอิง : $ref_idsmp
			รบกวนทำการตรวจสอบข้อมูล
			และอนุมัติการร้องขอ ตามลิงค์ด้านล่างได้เลยคะ
			https://sol.allwellcenter.com			
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
			if(curl_error($chOne)) {
				echo 'error:' . curl_error($chOne);
			}
			else {
				$result_ = json_decode($result, true);
				echo "status : ".$result_['status']; echo "message : ". $result_['message'];
				}
			curl_close( $chOne );
	
	
	
}else{

 $save="Update  hos__smp set status_sup ='Approve',send_stock = '1',send_admin = '1',comment_sup='".$comment_sup."',sup_date='".$sup_date."',sup_name = '".$sup_name."',sup_adddate='".$add_date."'  where ref_idsmp = '".$ref_idsmp."' ";

$qsave=mysqli_query($conn,$save);
	
$save17="Update  hos__subsmp set status_smp ='Approve'  where reff_idsmp = '".$ref_idsmp."' ";
$qsave17= mysqli_query($conn,$save17);	
	
	
if($sale_code =='(SOL99)' or $sale_code =='EN' or $sale_code =='(SOL1)' or $sale_code =='(SOL2)' or $sale_code =='SOL3'){	

}else{
include("dbconnect_cs.php");
	
if( $delivery_type =='2'){
		
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

$sum_address ="$address_name1 $address_send";	
	
$strSQL89 =  "insert into tb_register_data (running,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,address_bus,customer_contact,on_time,add_code,ref_id) 

values('".$nextId."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name1."','".$customer_tel."','".$address_to."','".$sum_address."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$province_name."','".$customer_contact."','".$on_time."','".$add_code."','".$ref_idsmp."')";

$objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());

$strSQL90 =  "insert into tb_transaction (running) values ('".$nextId."')";
$objQuery90 = mysqli_query($com1,$strSQL90) or die(mysqli_error());
		
$strSQL26="Update  hos__smp set send_cs ='2'  where ref_idsmp='".$ref_idsmp."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	
	}
}
	
}






 
if($qsave) {

 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_sample_approve.php';";
echo "</script>";

  }else{
   echo "Cannot";
  }
	

	
?>
