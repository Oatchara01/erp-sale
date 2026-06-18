<?php
include "dbconnect.php";
include "dbconnect_sale.php";
include "test.php";

  $id_work=$_GET['id_work'];
  $date_order = $_GET['date_order'];
  

foreach($id_work as $key =>$value)
{

$id_work_new=$id_work[$key];
$date_order_new=$date_order[$key];
//echo $date_order_new;			  
if($date_order_new!=''){	

$strSQL =  "Update tb_register_data set  date_order='".$date_order_new."',summary_order='1' where id_work  = '".$id_work_new."'";
$objQuery = mysqli_query($com,$strSQL) or die(mysqli_error());
	
$strSQL1 =  "Update tb_appdatesend set  status_doc='Approve' where id_work  = '".$id_work_new."'";
$objQuery1 = mysqli_query($com,$strSQL1) or die(mysqli_error());

$strSQL2 =  "Update tb_apppercent set  status_doc='Approve' where id_work  = '".$id_work_new."'";
$objQuery2 = mysqli_query($com,$strSQL2) or die(mysqli_error());
	

}

}

 if($objQuery){
echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_salereport.php';";		 
echo "</script>";
  } else {
   echo "Cannot";
  }


	

?>