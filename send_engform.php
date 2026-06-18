<?php
include "dbconnect.php";


  $id = $_GET['id'];
  $add_date = date('Y-m-d H:i:s');


$save="Update  tb_register_eng set summary_adm ='2', pend_date='".$add_date."'  where id = '".$id."' ";
$qsave=mysqli_query($conn,$save);
 


 if($qsave){

 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_engkang.php?id_story=$id_story';";
echo "</script>";

	
	}else{
   echo "Cannot";
  }

	

	
?>
