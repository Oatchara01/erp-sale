<?php
include "head.php";
include "dbconnect.php";

$product_ID = $_GET['product_ID'];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$admin_name = "$name $surname";
$add_date = date('Y-m-d H:i:s');


$save="Update  tb_product set close_out ='0',close_in ='0'  where product_ID = '".$product_ID."' ";
$qsave=mysqli_query($conn,$save);
 

$save1="Update  tb_product set close_out ='0',close_in ='0'  where product_ID = '".$product_ID."' ";
$qsave1=mysqli_query($new,$save1);



$save2="insert into tb_editoutpro (product_id,name_edit,date_edit,type_colse) values ('".$product_ID."','".$admin_name."','".$add_date."','Open')";
$qsave2=mysqli_query($conn,$save2);

 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('ปิดรายการสินค้ายอดนิยมออนไลน์สินค้าพร้อมขายเรียบร้อยแล้วนะคะ');window.location='status_almostpro.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>