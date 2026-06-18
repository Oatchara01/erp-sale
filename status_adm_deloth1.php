<?php
include "dbconnect.php";

  $ref_id=$_GET['ref_id'];
  $date_ker = $_GET['date_ker'];
  $order_refer_code = $_GET['order_refer_code'];
  $order_refer_code1 = $_GET['order_refer_code1'];
  $ker_bath = $_GET['ker_bath'];
  

  foreach($ref_id as $key =>$value)
	{
		$ref_id_new=$ref_id[$key];
	  	$date_ker_new=$date_ker[$key];
		$order_refer_code_new=$order_refer_code[$key];
		$order_refer_code1_new=$order_refer_code1[$key];
		$ker_bath_new=$ker_bath[$key];
		
	  
	  
	
$strSQL =  "Update so__main set  date_ker='".$date_ker_new."',order_refer_code='".$order_refer_code_new."',order_refer_code1='".$order_refer_code1_new."',ker_bath='".$ker_bath_new."' where ref_id='".$ref_id_new."'";

 $objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
	  

  }

	  
	  
 if($objQuery){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_adm_deloth.php';";
echo "</script>";
	
	 
  } else {
   echo "Cannot";
  }
	

	

?>