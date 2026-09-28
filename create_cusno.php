<?php
include "dbconnect.php";

$select_type_doc = $_GET["select_type_doc"];
$ref_id1 = $_GET["ref_id"];

$strSQL = "SELECT bill_id,doc_release_date FROM so__main WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$bill_id = $objResult["bill_id"];
$iv_date = $objResult["doc_release_date"];
$yy = substr($iv_date,0,4);
$mm1 = substr($iv_date,0,7);
$mm = substr($mm1,-2);



if($select_type_doc =='3'){
	

// ใช้ helper กลางให้เลขไม่ชนกับรหัสบิล 2+ (tb_customer_billing_address.billing_code) ยังอิงเดือนของวันที่ SO เหมือนเดิม
include_once "customer_code_lib.php";
if (!customer_code_acquire_lock($conn, 'awl')) {
	echo "<script>alert('ระบบกำลังรันรหัสลูกค้าให้ผู้ใช้อื่น กรุณาลองใหม่อีกครั้ง');history.back();</script>";
	exit();
}
$ref_id = customer_code_next($conn, 'awl', array(), customer_code_prefix('awl', substr($iv_date, 0, 10)));


$save="UPDATE  tb_customer SET customer_code='".$ref_id."' where customer_id ='".$bill_id."'";
$qsave=mysqli_query($conn,$save);
// บิล 1 ต้องเท่ากับ tb_customer.customer_code เสมอ
if ($qsave && customer_code_ensure_billing_column($conn, 'awl')) {
	mysqli_query($conn, "UPDATE tb_customer_billing_address SET billing_code='".mysqli_real_escape_string($conn, $ref_id)."' WHERE customer_id='".(int)$bill_id."' AND billing_index=1");
}


		
	}else if($select_type_doc =='4'){
		
// ชุดเลข NBM ผ่าน helper กลางให้เลขไม่ชนกับรหัสบิล 2+ (tb_customer_billing_address.billing_coden) ยังอิงเดือนของวันที่ SO เหมือนเดิม
include_once "customer_code_lib.php";
if (!customer_code_acquire_lock($conn, 'nbm')) {
	echo "<script>alert('ระบบกำลังรันรหัสลูกค้าให้ผู้ใช้อื่น กรุณาลองใหม่อีกครั้ง');history.back();</script>";
	exit();
}
$ref_id = customer_code_next($conn, 'nbm', array(), customer_code_prefix('nbm', substr($iv_date, 0, 10)));


$save="UPDATE  tb_customer SET customer_coden = '".$ref_id."' where customer_id ='".$bill_id."'";
$qsave=mysqli_query($conn,$save);
// บิล 1 ต้องเท่ากับ tb_customer.customer_coden เสมอ
if ($qsave && customer_code_ensure_billing_column($conn, 'nbm')) {
	mysqli_query($conn, "UPDATE tb_customer_billing_address SET billing_coden='".mysqli_real_escape_string($conn, $ref_id)."' WHERE customer_id='".(int)$bill_id."' AND billing_index=1");
}


}


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_admin_edit.php?ref_id=$ref_id1';";
echo "</script>";
  } else {
   echo "Cannot";
  }


?>