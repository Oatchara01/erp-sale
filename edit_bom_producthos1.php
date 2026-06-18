<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {
$bom_id = $_POST["bom_id"];
$bom_code = $_POST["bom_code"];
$bom_name  = $_POST["bom_name"];
$unit_name = $_POST["unit_name"];
$id_product1 = $_POST["id_product1"];
$id_product2 = $_POST["id_product2"];
$id_product3 = $_POST["id_product3"];
$id_product4 = $_POST["id_product4"];

$unit1 = $_POST["unit1"];
$unit2 = $_POST["unit2"];
$unit3 = $_POST["unit3"];
$unit4 = $_POST["unit4"];



$save="Update  tb_product_bomhos set  
bom_code = '".$bom_code."',bom_name = '".$bom_name."',product_id1='".$id_product1."',product_id2='".$id_product2."',product_id3='".$id_product3."',product_id4='".$id_product4."',unit1='".$unit1."',unit2='".$unit2."',unit3='".$unit3."',unit4='".$unit4."'  where bom_id ='".$bom_id."'";

$qsave=mysqli_query($conn,$save);












 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_bom_producthos.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>