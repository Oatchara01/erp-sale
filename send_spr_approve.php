<?php
include('head.php'); 



 $ref_id = $_GET['ref_id'];
 $name = $_SESSION["name"];
 $today= date('Y-m-d');
$add_date = date('Y-m-d H:i:s');


/*$qfirst = "select SUM(sum_amount) As sum_amount from hos__subspr where ref_idd = '".$_GET["ref_id"]."'";
			$first = mysqli_query($conn,$qfirst);
			$ffirst = mysqli_fetch_array($first);*/

$qfirst = "select product_id from hos__subspr where ref_idd = '".$_GET["ref_id"]."'";
$first = mysqli_query($conn,$qfirst);
$ffirst = mysqli_fetch_array($first);

$qfirst1 = "select group1 from tb_product where product_ID = '".$ffirst["product_id"]."'";
$first1 = mysqli_query($conn,$qfirst1);
$ffirst1 = mysqli_fetch_array($first1);

if($ffirst1["group1"] =="ALPHABED / ที่นอนลม" or  $ffirst1["group1"] =="SUCTION / เครื่องดูดเสมหะ"  or  $ffirst1["group1"] =="อะไหล่ Alphabed"  or  $ffirst1["group1"] =="Hartmann"   or  $ffirst1["group1"] =="Flowmeter"  or  $ffirst1["group1"] =="Smartsign"   or  $ffirst1["group1"] =="Thermometer/เครื่องวัดอุณหภูมิ" ){

$save="Update  hos__spr set send_sup ='1',sup_name='".$name."',sup_date='".$today."',sup_adddate='".$add_date."',send_cm='1',cm_name='".$name."',cm_date='".$today."',status_doc='Approve',send_stock='1'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
	
$save17="Update  hos__subspr set status_spr='Approve'  where ref_idd = '".$ref_id."' ";
$qsave17=mysqli_query($conn,$save17);	
	
	
}else{
 $save="Update  hos__spr set send_sup ='1',sup_name='".$name."',sup_date='".$today."',sup_adddate='".$add_date."',send_cm='1'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);

}
 
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้วค่ะ');window.location='register_engspr_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>