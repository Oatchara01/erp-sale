<?php
include "dbconnect.php";
include "head.php";

  $product_ID=$_GET['product_ID'];
  $ecom_ckk = $_GET['ecom_ckk'];
  $ecom_count = $_GET['ecom_count'];
 
  

  foreach($product_ID as $key =>$value)
	{
		$product_ID_new=$product_ID[$key];
	  	$ecom_ckk_new=$ecom_ckk[$key];
		$ecom_count_new=$ecom_count[$key];
	
	  
$strSQL =  "Update tb_product set  ecom_ckk='".$ecom_ckk_new."',ecom_count='".$ecom_count_new."' where product_ID='".$product_ID_new."'";  
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());

$strSQL1 =  "Update tb_product set  ecom_ckk='".$ecom_ckk_new."',ecom_count='".$ecom_count_new."' where product_ID='".$product_ID_new."'";
$objQuery1 = mysqli_query($new,$strSQL1) or die(mysqli_error());
	  
}


 if($objQuery&&$objQuery1){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_online_cls.php';";
echo "</script>";
	
	 
  } else {
   echo "Cannot";
  }
	

	

?>