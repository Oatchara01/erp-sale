<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$code_lazada = $_GET["code_lazada"];
$name_lazada  = $_GET["name_lazada"];
$price_lazada = $_GET["price_lazada"];
$id_product1 = $_GET["id_product1"];
$id_product2 = $_GET["id_product2"];
$id_product3 = $_GET["id_product3"];
$id_product4 = $_GET["id_product4"];

$unit1 = $_GET["unit1"];
$unit2 = $_GET["unit2"];
$unit3 = $_GET["unit3"];
$unit4 = $_GET["unit4"];

$waranty1 = $_GET["waranty1"];
$waranty2 = $_GET["waranty2"];
$waranty3 = $_GET["waranty3"];
$waranty4 = $_GET["waranty4"];


$save="insert into tb_product_med
(code_lazada,name_lazada,price_lazada,id_product1,id_product2,id_product3,id_product4,unit1,unit2,unit3,unit4,waranty1,waranty2,waranty3,waranty4)
values
('".$code_lazada."','".$name_lazada."','".$price_lazada."','".$id_product1."','".$id_product2."','".$id_product3."','".$id_product4."','".$unit1."','".$unit2."','".$unit3."','".$unit4."','".$waranty1."','".$waranty2."','".$waranty3."','".$waranty4."')";


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