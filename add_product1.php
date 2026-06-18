<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$type_company = $_GET["type_company"];
$sol_code  = $_GET["sol_code"];
$sol_price = $_GET["sol_price"];
$access_code = $_GET["access_code"];
$access_name = $_GET["access_name"];
$express_code = $_GET["express_code"];
$express_name = $_GET["express_name"];
$unit_name = $_GET["unit_name"];
$expire = $_GET["expire"];
$expire_total = $_GET["expire_total"];
$problem = $_GET["problem"];
$problem_total = $_GET["problem_total"];
$balance_remark = $_GET["balance_remark"];
$add_info = $_GET["add_info"];
$more_product_info = $_GET["more_product_info"];
$store = $_GET["store"];
$pannipha = $_GET["pannipha"];
$group1 = $_GET["group1"];
$reorder_point = $_GET["reorder_point"];
$ordered = $_GET["ordered"];
$order_no = $_GET["order_no"];
$order_count = $_GET["order_count"];
$itr_type = $_GET["itr_type"];
$product_type = $_GET["product_type"];
$expire_date = $_GET["expire_date"];
$EXP1_1 = $_GET["1_1EXP"];
$EXP1_2 = $_GET["1_2EXP"];
$EXP1_3 = $_GET["1_3EXP"];
$EXP1_4 = $_GET["1_4EXP"];

$clearing = $_GET["clearing"];
$Clearing_count = $_GET["Clearing_count"];
$EXP2_1 = $_GET["2_1EXP"];
$EXP2_2 = $_GET["2_2EXP"];
$EXP2_3 = $_GET["2_3EXP"];

$clearing_remark = $_GET["clearing_remark"];
$humidity = $_GET["humidity"];
$temperator = $_GET["temperator"];
$rh = $_GET["rh"];
$store_remark = $_GET["store_remark"];
$br_period = $_GET["br_period"];
$no_print = $_GET["no_print"];
$folder_no = $_GET["folder_no"];
$spare_select = $_GET["spare_select"];
$adjust = $_GET["adjust"];
$adjust_list = $_GET["adjust_list"];
$reserved = $_GET["reserved"];
$reserved_amount = $_GET["reserved_amount"];
$import_check = $_GET["import_check"];
$verify = $_GET["verify"];
$verify01 = $_GET["verify01"];
$verify02 = $_GET["verify02"];
$verify03 = $_GET["verify03"];
$verify04 = $_GET["verify04"];
$verify05 = $_GET["verify05"];
$verify06 = $_GET["verify06"];
$verify07 = $_GET["verify07"];
$verify08 = $_GET["verify08"];
$verify09 = $_GET["verify09"];
$verify10 = $_GET["verify10"];
$verify_add = $_GET["verify_add"];
$assemble_per_day = $_GET["assemble_per_day"];
$check_per_day = $_GET["check_per_day"];
$energy = $_GET["energy"];
$ordered_ready = $_GET["ordered_ready"];
$ordered_amount = $_GET["ordered_amount"];
$inventory_group = $_GET["inventory_group"];
$update_chula = $_GET["update_chula"];
$type_time = $_GET["type_time"];
$popular_1 = $_GET["popular_1"];
$popular_2 = $_GET["popular_2"];
$popular_3 = $_GET["popular_3"];
$popular_4 = $_GET["popular_4"];
$popular_5 = $_GET["popular_5"];
$sale_ckk = $_GET["sale_ckk"];
$engineer_ckk = $_GET["engineer_ckk"];
$adm_ckk = $_GET["adm_ckk"];
$online_ckk = $_GET["online_ckk"];
$demo_ckk = $_GET["demo_ckk"];
$access_code_old = $_GET["access_code_old"];
	
$save="insert into tb_product
(type_company,sol_code,sol_price,access_code,access_name,express_code,express_name,unit_name,expire,expire_total,problem,problem_total,balance_remark,add_info,more_product_info,store,pannipha,group1,reorder_point,ordered,order_no,order_count,itr_type,product_type,expire_date,1_1EXP,1_2EXP,1_3EXP,1_4EXP,clearing,Clearing_count,2_1EXP,2_2EXP,2_3EXP,clearing_remark,humidity,temperator,rh,store_remark,br_period,no_print,folder_no,spare_select,adjust,adjust_list,reserved,reserved_amount,import_check,verify,verify01,verify02,verify03,verify04,verify05,verify06,verify07,verify08,verify09,verify10,verify_add,assemble_per_day,check_per_day,energy,ordered_ready,ordered_amount,inventory_group,update_chula,type_time,popular_1,popular_2,popular_3,popular_4,popular_5,sale_ckk,engineer_ckk,adm_ckk,online_ckk,demo_ckk,access_code_old)
values
('".$type_company."','".$sol_code."','".$sol_price."','".$access_code."','".$access_name."','".$express_code."','".$express_name."','".$unit_name."','".$expire."','".$expire_total."','".$problem."','".$problem_total."','".$balance_remark."','".$add_info."','".$more_product_info."','".$store."','".$pannipha."','".$group1."','".$reorder_point."','".$ordered."','".$order_no."','".$order_count."','".$itr_type."','".$product_type."','".$expire_date."','".$EXP1_1."','".$EXP1_2."','".$EXP1_3."','".$EXP1_4."','".$clearing."','".$Clearing_count."','".$EXP2_1."','".$EXP2_2."','".$EXP2_3."','".$clearing_remark."','".$humidity."','".$temperator."','".$rh."','".$store_remark."','".$br_period."','".$no_print."','".$folder_no."','".$spare_select."','".$adjust."','".$adjust_list."','".$reserved."','".$reserved_amount."','".$import_check."','".$verify."','".$verify01."','".$verify02."','".$verify03."','".$verify04."','".$verify05."','".$verify06."','".$verify07."','".$verify08."','".$verify09."','".$verify10."','".$verify_add."','".$assemble_per_day."','".$check_per_day."','".$energy."','".$ordered_ready."','".$ordered_amount."','".$inventory_group."','".$update_chula."','".$type_time."','".$popular_1."','".$popular_2."','".$popular_3."','".$popular_4."','".$popular_5."','".$sale_ckk."','".$engineer_ckk."','".$adm_ckk."','".$online_ckk."','".$demo_ckk."','".$access_code_old."')";


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