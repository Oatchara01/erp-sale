<?php
include "dbconnect.php";


  $id_story = $_GET['id_story'];
  $sale_code = $_GET['sale_code'];
  $customer_name = $_GET['customer_name'];
$add_date = date('Y-m-d H:i:s');
 $save="Update  tb_register_story set send_sale ='1',send_sdate='".$add_date."'  where id_story = '".$id_story."' ";
$qsave=mysqli_query($conn,$save);
 




	
if($qsave){	
 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_story_edit.php?id_story=$id_story';";
echo "</script>";
	
	}else{
   echo "Cannot";
  }

	

	
?>
