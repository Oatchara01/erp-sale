<?php
include "dbconnect.php";

$strSQL ="SELECT  customer_id,status_cus,date_update,date_updateold FROM tb_customer WHERE customer_no !='' and status_cus !='2'";
$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){
	
/*$strSQL2 ="SELECT  ref_id FROM so__main WHERE bill_id ='".$objResult["customer_id"]."' and cancel_ckk='0' and approve_complete = 'Approve'";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2=mysqli_fetch_array($objQuery2);	
	
$strSQL3 ="SELECT  SUM(sum_amount) AS sum_amount FROM so__submain WHERE ref_idd ='".$objResult2["ref_id"]."'";
$objQuery3 =mysqli_query($conn,$strSQL3);
$objResult3=mysqli_fetch_array($objQuery3);	*/	
	
$strSQL1 ="SELECT  SUM(amount) AS sum_amount FROM tb__buypro  WHERE bill_id ='".$objResult["customer_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);
	
$price = 	$objResult1["amount"];
$status_cus = $objResult["status_cus"];
$today = date('Y-m-d');
$date_update = $objResult["date_update"];

if($price > 100000){
	
if($status_cus !='2'){	
$save=" Update  tb_customer set status_cusold='2',status_cus='2',date_update='".$today."',date_updateold='".$date_update."',point='".$objResult1["sum_amount"]."'  where  customer_id ='".$objResult["customer_id"]."'";
$qsave=mysqli_query($conn,$save);
}	
	
}else if($price > 50000){
	
if($status_cus !='1'){	
$save=" Update  tb_customer set status_cusold='1',status_cus='1',date_update='".$today."',date_updateold='".$date_update."',point='".$objResult1["sum_amount"]."'  where  customer_id ='".$objResult["customer_id"]."'";
	//echo $save;
$qsave=mysqli_query($conn,$save);
}		
	
}
	
	
	
}

/*$t = $_GET["t"];

$strSQL ="SELECT  ref_id,doc_release_date FROM so__main WHERE doc_release_date LIKE '%$t%' and allwell_ckk = '1' and customer_no !=''";
$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){
	
	
$save=" Update  so__submain set doc_date='".$objResult["doc_release_date"]."'  where  ref_idd ='".$objResult["ref_id"]."'";
$qsave=mysqli_query($conn,$save);	
	
}*/



?>

  <form action = "main_admin.php" method ="post">
    <center>
  <input type="submit" class="button button3"  value="กลับสู่หน้าหลัก" >
  </center>
  <br>
	   <br>
	   <br>
           </form>