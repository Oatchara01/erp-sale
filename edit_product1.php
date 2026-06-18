<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$product_ID = $_POST["product_ID"];

$type_company = $_POST["type_company"];
$sol_code  = $_POST["sol_code"];
$sol_price = $_POST["sol_price"];
$access_code = $_POST["access_code"];
$access_name = $_POST["access_name"];
$express_code = $_POST["express_code"];
$express_name = $_POST["express_name"];
$unit_name = $_POST["unit_name"];
$expire = $_POST["expire"];
$expire_total = $_POST["expire_total"];
$problem = $_POST["problem"];
$problem_total = $_POST["problem_total"];
$balance_remark = $_POST["balance_remark"];
$add_info = $_POST["add_info"];
$more_product_info = $_POST["more_product_info"];
$store = $_POST["store"];
$pannipha = $_POST["pannipha"];
$group1 = $_POST["group1"];
$reorder_point = $_POST["reorder_point"];
$ordered = $_POST["ordered"];
$order_no = $_POST["order_no"];
$order_count = $_POST["order_count"];
$itr_type = $_POST["itr_type"];
$product_type = $_POST["product_type"];
$expire_date = $_POST["expire_date"];
$EXP1_1 = $_POST["1_1EXP"];
$EXP1_2 = $_POST["1_2EXP"];
$EXP1_3 = $_POST["1_3EXP"];
$EXP1_4 = $_POST["1_4EXP"];

$clearing = $_POST["clearing"];
$Clearing_count = $_POST["Clearing_count"];
$EXP2_1 = $_POST["2_1EXP"];
$EXP2_2 = $_POST["2_2EXP"];
$EXP2_3 = $_POST["2_3EXP"];

$clearing_remark = $_POST["clearing_remark"];
$humidity = $_POST["humidity"];
$temperator = $_POST["temperator"];
$rh = $_POST["rh"];
$store_remark = $_POST["store_remark"];
$br_period = $_POST["br_period"];
$no_print = $_POST["no_print"];
$folder_no = $_POST["folder_no"];
$spare_select = $_POST["spare_select"];
$adjust = $_POST["adjust"];
$adjust_list = $_POST["adjust_list"];
$reserved = $_POST["reserved"];
$reserved_amount = $_POST["reserved_amount"];
$import_check = $_POST["import_check"];
$verify = $_POST["verify"];
$verify01 = $_POST["verify01"];
$verify02 = $_POST["verify02"];
$verify03 = $_POST["verify03"];
$verify04 = $_POST["verify04"];
$verify05 = $_POST["verify05"];
$verify06 = $_POST["verify06"];
$verify07 = $_POST["verify07"];
$verify08 = $_POST["verify08"];
$verify09 = $_POST["verify09"];
$verify10 = $_POST["verify10"];
$verify_add = $_POST["verify_add"];
$assemble_per_day = $_POST["assemble_per_day"];
$check_per_day = $_POST["check_per_day"];
$energy = $_POST["energy"];
$ordered_ready = $_POST["ordered_ready"];
$ordered_amount = $_POST["ordered_amount"];
$inventory_group = $_POST["inventory_group"];
$update_chula = $_POST["update_chula"];
$type_time = $_POST["type_time"];
$popular_1 = $_POST["popular_1"];
$popular_2 = $_POST["popular_2"];
$popular_3 = $_POST["popular_3"];
$popular_4 = $_POST["popular_4"];
$popular_5 = $_POST["popular_5"];
$sale_ckk = $_POST["sale_ckk"];
$engineer_ckk = $_POST["engineer_ckk"];
$adm_ckk = $_POST["adm_ckk"];
$online_ckk = $_POST["online_ckk"];
$demo_ckk = $_POST["demo_ckk"];
$access_code_old = $_POST["access_code_old"]; 
$have_sn = $_POST["have_sn"];
	
	
$save="Update  tb_product set 
type_company='".$type_company."',sol_code='".$sol_code."',sol_price='".$sol_price."',access_code='".$access_code."',access_name='".$access_name."',express_code='".$express_code."',express_name='".$express_name."',unit_name='".$unit_name."',expire='".$expire."',expire_total='".$expire_total."',problem='".$problem."',problem_total='".$problem_total."',balance_remark='".$balance_remark."',add_info='".$add_info."',more_product_info='".$more_product_info."',store='".$store."',pannipha='".$pannipha."',group1='".$group1."',reorder_point='".$reorder_point."',ordered='".$ordered."',order_no='".$order_no."',order_count='".$order_count."',itr_type='".$itr_type."',product_type='".$product_type."',expire_date='".$expire_date."',1_1EXP='".$EXP1_1."',1_2EXP='".$EXP1_2."',1_3EXP='".$EXP1_3."',1_4EXP='".$EXP1_4."',clearing='".$clearing."',Clearing_count='".$Clearing_count."',2_1EXP='".$EXP2_1."',2_2EXP='".$EXP2_2."',2_3EXP='".$EXP2_3."',clearing_remark='".$clearing_remark."',humidity='".$humidity."',temperator='".$temperator."',rh='".$rh."',store_remark='".$store_remark."',br_period='".$br_period."',no_print='".$no_print."',folder_no='".$folder_no."',spare_select='".$spare_select."',adjust='".$adjust."',adjust_list='".$adjust_list."',reserved='".$reserved."',reserved_amount='".$reserved_amount."',import_check='".$import_check."',verify='".$verify."',verify01='".$verify01."',verify02='".$verify02."',verify03='".$verify03."',verify04='".$verify04."',verify05='".$verify05."',verify06='".$verify06."',verify07='".$verify07."',verify08='".$verify08."',verify09='".$verify09."',verify10='".$verify10."',verify_add='".$verify_add."',assemble_per_day='".$assemble_per_day."',check_per_day='".$check_per_day."',energy='".$energy."',ordered_ready='".$ordered_ready."',ordered_amount='".$ordered_amount."',inventory_group='".$inventory_group."',update_chula='".$update_chula."',type_time='".$type_time."',popular_1='".$popular_1."',popular_2='".$popular_2."',popular_3='".$popular_3."',popular_4='".$popular_4."',popular_5='".$popular_5."',sale_ckk='".$sale_ckk."',engineer_ckk='".$engineer_ckk."',adm_ckk='".$adm_ckk."',online_ckk='".$online_ckk."',demo_ckk = '".$demo_ckk."',access_code_old = '".$access_code_old."',have_sn='".$have_sn."'     where  product_ID ='".$product_ID."'";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);












 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_product.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>