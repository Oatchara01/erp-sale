<?php
include "dbconnect.php";
include "dbconnect_acc.php";
include ("head.php");

date_default_timezone_set("Asia/Bangkok");


$ref_id=$_POST['ref_id'];
$approve_code = $_SESSION['code'];
$approve_name =  $_SESSION['name'];
$sale_date= date('Y-m-d');
$approve_time = date("H:i:s");
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');

$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$sn = $_POST["sn"];
$product_id = $_POST["product_id"];
$clear_br = $_POST["clear_br"];
$clear_ivno = $_POST["clear_ivno"];
$jong_ckk = $_POST["jong_ckk"];
$jong_no = $_POST["jong_no"];
$adm_ckk = $_POST["adm_ckk"];
$ic_ckk = $_POST["ic_ckk"];

//if($clear_ivno !=''){


if($approve_code=='SS5'){
	
$save="Update  hos__so set send_sup ='1',examine_name='".$add_by."',examine_date='".$add_date."',send_admin='0',status_doc='Request'  where ref_id = '".$ref_id."' ";
$objQuery25=mysqli_query($conn,$save);

	
	
}else{


foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$clear_ivno_new = trim($clear_ivno[$key]);
		$sn_new=$sn[$key];
	    $clear_br_new = $clear_br[$key];
        $product_id_new =$product_id[$key];
	    $jong_ckk_new = $jong_ckk[$key];
        $jong_no_new =$jong_no[$key];
	 
	
$dfdf = substr($clear_ivno_new,0,4);	

	if($dfdf=='BREG'){
	
	}else{
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
echo "alert('หมายเลขเครื่อง : $sn_new มีการเคลียร์ยืมไปแล้วค่ะ');window.location='register_suphos_approve.php?ref_id=$ref_id';";
echo "</script>";
exit();	
	
}
	
}
			
$sqlsc1 = "SELECT ref_id   FROM   hos__consig   where  iv_no = '".$clear_ivno_new."' and status_doc = 'Approve'";
$qrysc1 = mysqli_query($conn,$sqlsc1) or die(mysqli_error());
$rssc1 = mysqli_fetch_assoc($qrysc1);

	
$sqlsc2 = "SELECT sum(count) as sale_count   FROM   hos__subconsig   where  ref_idd = '".$rssc1['ref_id']."' and product_id = '".$product_id_new."'";
$qrysc2 = mysqli_query($conn,$sqlsc2) or die(mysqli_error());
$rssc2 = mysqli_fetch_array($qrysc2);	


		
$sqle1 = "SELECT ref_id   FROM   hos__breg   where  iv_no = '".$clear_ivno_new."' and status_doc = 'Approve'";
$qrye1 = mysqli_query($conn,$sqle1) or die(mysqli_error());
$rse1 = mysqli_fetch_assoc($qrye1);

	
$sqle2 = "SELECT sum(count1) as sale_count   FROM hos__subbreg1   where  ref_id1 = '".$rse1['ref_id']."' and product_id1 = '".$product_id_new."'";
$qrye2 = mysqli_query($conn,$sqle2) or die(mysqli_error());
$rse2 = mysqli_fetch_array($qrye2);		
		
		
$sql1 = "SELECT ref_id_br   FROM   hos__br   where  iv_no = '".$clear_ivno_new."' and status_doc = 'Approve'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

	
$sql2 = "SELECT sum(count) as sale_count   FROM   hos__subbr   where  ref_idd_br = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_array($qry2);
	
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
$count2 = (($rs2['sale_count']+$rs22['sale_count']+$rse2['sale_count']+$rssc2['sale_count']) - ($count3+$count4+$count5+$count13+$sale_count_new));
	
//echo $product_id_new; echo " ";  echo $count2; '<br>';		
		
if($count2 <='0'){
$save6="Update  hos__subbr set  clear_ckk = '1'    where ref_idd_br = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";
$qsave6=mysqli_query($conn,$save6);
	
$save7="Update  hos__subconsig set  clear_ckk = '1'    where ref_idd = '".$rssc1['ref_id']."' and product_id = '".$product_id_new."'";
$qsave7=mysqli_query($conn,$save7);	
	

}
		


if($count2 < '0'){

echo "<script language=\"JavaScript\">";
echo "alert('สินค้าในใบยืมนี้มีไม่พอในการเคลียร์ยืมครั้งนี้ค่ะ');window.location='register_suphos_approve.php?ref_id=$ref_id';";
echo "</script>";
exit();
	
}		
	 
	}
 }
	
	
if($jong_no_new!=''){
	
$strSQL = "SELECT * FROM hos__jongproduct WHERE iv_no = '".$jong_no_new."' ";
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
echo "alert('สินค้าในใบจองนี้มีไม่พอในการเคลียร์จองครั้งนี้ค่ะ');window.location='register_suphos_approve.php?ref_id=$ref_id';";
echo "</script>";
exit();
	
}			
	
	
}	
	
}


$sql = "SELECT payment,bill_name  FROM hos__so where ref_id = '".$ref_id."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$payment = $rs["payment"];
$bill_name = $rs["bill_name"];

$sql2 = "SELECT credit_name  FROM tb_credit where credit_id  = '".$payment."'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_assoc($qry2);


$sql1 = "SELECT SUM(amount) AS amount  FROM hos__subso where ref_idd = '".$ref_id."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

$amount = $rs1["amount"];

if($ic_ckk=='1'){
	
$save="Update  hos__so set send_cm ='2',approve='".$approve_name."',approve_code = '".$approve_code."',approve_date = '".$sale_date."',approve_time = '".$approve_time."'   where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
	
	

	
}else if($amount <='2000'){

	
if($payment =='36' or $payment =='38' or $payment =='39' or $payment =='40' or $payment =='41' or $payment =='42'){
	
	
$save="Update  hos__so set send_cm ='1'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
	
	
	

	
	
}else{
	
$strSQL25="Update  hos__so set status_doc = 'Approve',approve='".$approve_name."',approve_code = '".$approve_code."',approve_date = '".$sale_date."',send_admin='1',approve_time = '".$approve_time."'  where ref_id='".$ref_id."'";

$objQuery25 = mysqli_query($conn,$strSQL25);


$strSQL28="Update  hos__subso set status_so = 'Approve' where ref_idd='".$ref_id."'";
$objQuery28 = mysqli_query($conn,$strSQL28);	
	
}

}else{	

$strSQL25="Update  hos__so set status_doc = 'Approve',approve='".$approve_name."',approve_code = '".$approve_code."',approve_date = '".$sale_date."',send_admin='1',approve_time = '".$approve_time."'  where ref_id='".$ref_id."'";

$objQuery25 = mysqli_query($conn,$strSQL25);


$strSQL28="Update  hos__subso set status_so = 'Approve' where ref_idd='".$ref_id."'";
$objQuery28 = mysqli_query($conn,$strSQL28);

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


 if($objQuery25){
	 
	 
if($adm_ckk=='1'){
	
echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_approveadm.php';";
echo "</script>";
	
}else{	
	
echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_approvesup.php';";
echo "</script>";
	
}	 
	 
  } else {
   echo "Cannot";
  }

//ทำหน้า connect Database CS
	
?>