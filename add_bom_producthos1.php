<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$bom_code = $_GET["bom_code"];
$bom_name  = $_GET["bom_name"];
$unit_name = $_GET["unit_name"];
$id_product1 = $_GET["id_product1"];
$id_product2 = $_GET["id_product2"];
$id_product3 = $_GET["id_product3"];
$id_product4 = $_GET["id_product4"];

$unit1 = $_GET["unit1"];
$unit2 = $_GET["unit2"];
$unit3 = $_GET["unit3"];
$unit4 = $_GET["unit4"];



$save="insert into tb_product_bomhos
(bom_code,bom_name,product_id1,product_id2,product_id3,product_id4,unit1,unit2,unit3,unit4,unit_name)
values
('".$bom_code."','".$bom_name."','".$id_product1."','".$id_product2."','".$id_product3."','".$id_product4."','".$unit1."','".$unit2."','".$unit3."','".$unit4."','".$unit_name."')";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);


$save1="insert into tb_product
(access_code,access_name,sale_ckk,adm_ckk,online_ckk,engineer_ckk)
values
('".$bom_code."','".$bom_name."','1','1','0','0')";


//echo $save;
//exit();

$qsave1=mysqli_query($conn,$save1);









 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_bom_producthos.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>