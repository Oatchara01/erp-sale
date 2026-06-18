<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {
$shopee_id = $_POST["shopee_id"];
$code_shopee = $_POST["code_shopee"];
$name_shopee  = $_POST["name_shopee"];
$price_shopee = $_POST["price_shopee"];
$id_product1 = $_POST["id_product1"];
$id_product2 = $_POST["id_product2"];
$id_product3 = $_POST["id_product3"];
$id_product4 = $_POST["id_product4"];

$unit1 = $_POST["unit1"];
$unit2 = $_POST["unit2"];
$unit3 = $_POST["unit3"];
$unit4 = $_POST["unit4"];

$waranty1 = $_POST["waranty1"];
$waranty2 = $_POST["waranty2"];
$waranty3 = $_POST["waranty3"];
$waranty4 = $_POST["waranty4"];


$save="Update  tb_product_shopee set  
code_shopee='".$code_shopee."',name_shopee='".$name_shopee."',price_shopee='".$price_shopee."',id_product1='".$id_product1."',id_product2='".$id_product2."',id_product3='".$id_product3."',id_product4='".$id_product4."',unit1='".$unit1."',unit2='".$unit2."',unit3='".$unit3."',unit4='".$unit4."',waranty1 = '".$waranty1."',waranty2 = '".$waranty2."',waranty3 = '".$waranty3."',waranty4 = '".$waranty4."'  where shopee_id ='".$shopee_id."'";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);












 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_bom_shopee.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>