<?php
include "head.php";
include "dbconnect.php";
include "dbconnect_acc.php";

 $ref_id = $_GET['ref_id'];
 $sale_code = $_GET['sale_code'];
 
$approve_time = date("H:i:s");
$approve_date = date("Y-m-d");
/*echo  $approve_time;
exit();*/
$code =  $_SESSION['code'];

if($code=='SS5'){

$save="Update  hos__so set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."',send_admin='0',status_doc='Request'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);

}else{

$strSQL29 = "SELECT * FROM hos__subso WHERE ref_idd = '".$ref_id."' ";
$objQuery29 = mysqli_query($conn,$strSQL29) or die ("Error Query [".$strSQL29."]");
while($objResult1 = mysqli_fetch_array($objQuery29))
{


		$id_new=$objResult1["id"];
		$sale_count_new=$objResult1["count"];
		$sn_new = $objResult1["sn"];
		$product_id_new =$objResult1["product_id"];
        $clear_br_new = $objResult1["clear_br"];
	 	$clear_ivno_new = $objResult1["clear_ivno"];
		

if($clear_ivno_new !=''){
	
	
if($sn_new!=''){
	
$sql3 = "SELECT sum(sale_count) as count3   FROM  hos__subspr  where  product_id = '".$product_id_new."' and sn='".$sn_new."' and clear_br = '1' and clear_ivno ='".$clear_ivno_new."' and status_spr='Approve'";

$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM hos__subso where  product_id = '".$product_id_new."' and sn='".$sn_new."' and clear_br = '1' and clear_ivno ='".$clear_ivno_new."' and status_so='Approve'";

$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$clear_ivno_new."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
$rs41 = mysqli_fetch_array($qry41);

$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '".$rs41['ref_id']."' and sn='".$sn_new."' and product_id = '".$product_id_new."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM hos__subsmp where  product_id = '".$product_id_new."' and sn='".$sn_new."' and clear_br = '1' and br_no ='".$clear_ivno_new."' and status_smp ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];	
	
$count_sn =  number_format($count3+$count4+$count5+$count13,0)."";	
	
if($count_sn!='0'){

echo "<script language=\"JavaScript\">";
echo "alert('หมายเลขเครื่อง : $sn_new มีการเคลียร์ยืมไปแล้วค่ะ');window.location='register_suphos_edit.php?ref_id=$ref_id';";
echo "</script>";
exit();	
	
}
	
}
		
	
	
	
	
$sql1 = "SELECT ref_id_br   FROM   hos__br   where  iv_no = '".$clear_ivno_new."' and status_doc = 'Approve'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

	
$sql2 = "SELECT sum(count) as sale_count   FROM   hos__subbr   where  ref_idd_br = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";

$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_array($qry2);



$sql3 = "SELECT sum(sale_count) as count3   FROM   (hos__spr LEFT JOIN hos__subspr ON hos__spr.ref_id=hos__subspr.ref_idd)   where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$clear_ivno_new."' and status_doc ='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM   (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd)   where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$clear_ivno_new."' and status_doc ='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$clear_ivno_new."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
$rs41 = mysqli_fetch_array($qry41);

$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '".$rs41['ref_id']."' and product_id = '".$product_id_new."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM   (hos__smp LEFT JOIN hos__subsmp ON hos__smp.ref_idsmp=hos__subsmp.reff_idsmp)   where  product_id = '".$product_id_new."' and clear_br = '1' and br_no ='".$clear_ivno_new."'  and status_sup ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];

	
$count2 = $rs2['sale_count'] - ($count3+$count4+$count5+$count13);

if($count2 <='0'){

$save6="Update  hos__subbr set  clear_ckk = '1'    where ref_idd = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";
$qsave6=mysqli_query($conn,$save6);

}

$strSQL1 = "SELECT clear_ckk  FROM hos__subbr WHERE ref_idd_br = '".$rs1['ref_id_br']."' and  clear_ckk ='0'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

	if($objResult1["clear_ckk"]==''){
	$save1="Update   hos__br set  close_br = '1'   where iv_no ='".$clear_ivno_new."'";
	$qsave1=mysqli_query($conn,$save1);	
	}
	
	

		

if($count2 < 0){

echo "<script language=\"JavaScript\">";
echo "alert('สินค้าในใบยืมนี้มีไม่พอในการเคลียร์ยืมครั้งนี้ค่ะ');window.location='register_suphos_edit.php?ref_id=$ref_id';";
echo "</script>";

	
}
	  
	  
}
}



$sql = "SELECT *  FROM hos__so where ref_id = '".$ref_id."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rsw = mysqli_fetch_assoc($qry);

$bill_name = $rsw["bill_name"];

if($rsw["ic_ckk"]=='1'){
	
$save="Update  hos__so set send_sup ='1',send_supname='".$add_by."',send_supdate='".$add_date."',send_admin='0',status_doc='Request'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
	
	
	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");

$sToken = "gCe7s6XlzcHFCtuVNBF2D2g6xbZZS7PrmPz5vpQBc6G";
$sMessage = "
มีการขออนุมัติเอกสารใบสั่งขายฝากขาย
เลขที่อ้างอิง : $ref_id
ลูกค้า : $bill_name
เปิดโดย : $add_by
รบกวนทำการตรวจสอบข้อมูล และทำการอนุมัติ
ตามลิงค์ด้านล่างได้เลยคะ
https://sol.allwellcenter.com/status_approvecm.php	
			 
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
//echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne );  	


}else{

 $save="Update  hos__so set send_admin ='1',status_doc='Approve',send_sup='1',approve_time='".$approve_time."',approve_date='".$approve_date."'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);


$save17="Update  hos__subso set status_so='Approve'  where ref_idd = '".$ref_id."' ";
$qsave17=mysqli_query($conn,$save17);

}
 

$strSQL = "SELECT * FROM hos__so WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$rsss = mysqli_fetch_assoc($objQuery);

$bill_name = $rsss["bill_name"];
$payment = $rsss["payment"];
$type_doc = $rsss["type_doc"];
$payment_des = $rsss["payment_des"];
$date_tranfer = $rsss["date_tranfer"];
$delivery_date = $rsss["delivery_date"];
$date_send_key = $rsss["date_send_key"];
$approve_name  = $rsss["approve_name"];

if ($type_doc=='3'){
		$com ="ออลล์เวล ไลฟ์ บจก.";
	}else if ($type_doc=='4'){
	$com="โนเบิล เมด บจก.";	
	}
	
	
if($payment =='1'){
$cash = '5';	
}else if($payment =='8'){
	$cash = '22';
}else  if($payment =='21'){
	$cash = '7';
}
	
	

	if($payment=='1' or $payment =='8' or $payment =='21'){
		
$strSQL29 = "SELECT SUM(amount) AS unit_cash FROM hos__subso WHERE ref_idd = '".$ref_id."' ";
$objQuery29 = mysqli_query($conn,$strSQL29) or die ("Error Query [".$strSQL29."]");
$rs = mysqli_fetch_assoc($objQuery29);
if($payment=='2' or $payment=='3' or $payment=='4' or $payment=='5' ){
$unit_cash = "0.00";
}else{
$unit_cash = $rs["unit_cash"];
}
		

	
$strSQL292="insert into   tb_register_data (IV_number,date_inv,company,customer_name,date_tranfer,employee_name,credit,cash,unit_cash,description,ref_id,between_dateinv) values ('".$iv_no."','".$delivery_date."','".$com."','".$bill_name."','".$date_tranfer ."','".$approve_name."','".$credit."','$cash','".$unit_cash."','".$payment_des."','".$ref_id."','".$date_send_key."')";

$objQuery292 = mysqli_query($code,$strSQL292);	
			

$strSQL262="Update  hos__so set send_receipt ='2'  where ref_id='".$ref_id."'";
$objQuery262 = mysqli_query($conn,$strSQL262);		

	}

}





 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_suphos_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	
	

	
?>
