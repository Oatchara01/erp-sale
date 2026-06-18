<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_tax = $_POST["type_tax"];
$sale_channel = $_POST["sale_channel"];
$order_id = $_POST["order_id"];
$amount = $_POST["amount"];
$tax_id = $_POST["tax_id"];
$brun_no = $_POST["brun_no"];
$head_name = $_POST["head_name"];
$last_name = $_POST["last_name"];
$address = $_POST["address"];
$sub_district = $_POST["sub_district"];
$district = $_POST["district"];
$province = $_POST["province"];
$postcode = $_POST["postcode"];
$tel_num = $_POST["tel_num"];
$mail_cus = $_POST["mail_cus"];
$customer_name = "$head_name $last_name";
$address_name = "$address $sub_district $district $province $postcode";
$import_order = $_POST["import_order"];
$ckk_h = "1";

$add_date = date('Y-m-d H:i:s');


$ref_id =$_POST["ref_id"];
	
	
	
$save="UPDATE tb_customer_etax SET type_tax='".$type_tax."',sale_channel='".$sale_channel."',order_id='".$order_id."',amount='".$amount."',tax_id='".$tax_id."',brun_no='".$brun_no."',head_name='".$head_name."',last_name='".$last_name."',address='".$address."',sub_district='".$sub_district."',district='".$district."',province='".$province."',postcode='".$postcode."',tel_num='".$tel_num."',mail_cus='".$mail_cus."',customer_name='".$customer_name."',address_name='".$address_name."'  where ref_id ='".$ref_id."' ";

$qsave=mysqli_query($conn,$save);
	

if($import_order=='1'){	
	
$save1="UPDATE tb_customer_etax SET import_order = '".$import_order."'  where ref_id ='".$ref_id."' ";
$qsave1=mysqli_query($conn,$save1);
	
}
	
	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='etaxcustomer_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


?>