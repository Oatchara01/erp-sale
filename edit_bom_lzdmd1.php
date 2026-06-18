<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {
$lzd_id = $_POST["lzd_id"];
$code_lazada = $_POST["code_lazada"];
$name_lazada  = $_POST["name_lazada"];
$price_lazada = $_POST["price_lazada"];
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



$save="Update  tb_product_med set  
code_lazada='".$code_lazada."',name_lazada='".$name_lazada."',price_lazada='".$price_lazada."',id_product1='".$id_product1."',id_product2='".$id_product2."',id_product3='".$id_product3."',id_product4='".$id_product4."',unit1='".$unit1."',unit2='".$unit2."',unit3='".$unit3."',unit4='".$unit4."',waranty1 = '".$waranty1."',waranty2 = '".$waranty2."',waranty3 = '".$waranty3."',waranty4 = '".$waranty4."'  where lzd_id ='".$lzd_id."'";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);












 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_bom_lzdmd.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>