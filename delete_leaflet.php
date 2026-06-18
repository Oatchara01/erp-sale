<?php
include('head.php'); 
include"dbconnect.php";


$name = $_GET["name"]; 
$leaflet_id = $_GET["leaflet_id"]; 

$save="Update  tb_product_leaflet set $name=''	  where leaflet_id = '".$leaflet_id."'";

$qsave=mysqli_query($conn,$save);

if($qsave)
{
	
  echo "<script language=\"JavaScript\">";
echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='edit_leaflet.php?leaflet_id=$leaflet_id';";
echo "</script>";
	
}else{
echo "Error Delete [".$strSQL."]";
}
?>
