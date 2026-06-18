<?php

include ("head.php");
date_default_timezone_set("Asia/Bangkok");


if ($_POST["submit"] = "submit") {
$order_refer_code  = $_POST["order_refer_code"];
$product_code_same = $_POST["product_code_same"];
$stock_remark = $_POST["stock_remark"];
$ref_id = $_POST["ref_id"];
$sn_number = $_POST["sn_number"];
$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$doc_no = $_POST["doc_no"];
$customer_name = $_POST["customer_name"];
$warranty = $_POST["warranty"];

$address1 = $_POST["address1"];
$province = $_POST["province"];
$postcode = $_POST["postcode"];
$tel = $_POST["tel"];
$register_date = $_POST["register_date"];
$delivery_date = $_POST["delivery_date"];
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname"; 

$add_date = date('Y-m-d H:i:s');
$date_disburse = $_POST["date_disburse"];
$cal = $_POST["cal"];
$pm = $_POST["pm"];
$start_date = $_POST["start_date"];
$end_date = $_POST["end_date"];
$product_code_same = $_POST["product_code_same"];
$sale_count_same = $_POST["sale_count_same"];
$stock_date = date('Y-m-d');

$strSQL = "Update   so__main set order_refer_code ='$order_refer_code',ckk_h='1',stock_date = '$stock_date',date_disburse = '".$date_disburse."'  Where ref_id='$ref_id' ";
//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL);





  foreach($id as $key =>$value)
	{
		$id_new = $id[$key];
		$sn_number_new=$sn_number[$key];
		$stock_remark_new=$stock_remark[$key];
		$warranty_new=$warranty[$key];
		$pm_new=$pm[$key];
		$cal_new=$cal[$key];
	  	$sale_count_new=$sale_count[$key];
	  	$product_code_same_new=$product_code_same[$key];
	  	$sale_count_same_new=$sale_count_same[$key];

	  


if($product_code_same_new!=''){

$strSQL = "Update   so__submain set  count_same = '$sale_count_same_new',code_same='$product_code_same_new', ckk ='1',sn_number='$sn_number_new',stock_remark='$stock_remark_new' Where id= '$id_new' ";
//echo $strSQL;
//exit();

$objQuery = mysqli_query($conn,$strSQL);
	


}else{

$strSQL = "Update   so__submain set  count_same = '$sale_count_same_new',code_same='$product_code_same_new',sn_number='$sn_number_new',stock_remark='$stock_remark_new' Where id= '$id_new' ";
//echo $strSQL;
//exit();

$objQuery = mysqli_query($conn,$strSQL);

}


}






$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$stock_remarkk1 = $_POST["stock_remarkk1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);
$discount_unit1 = $_POST["discount_unit1"];
$sn_number1 = $_POST["sn_number1"];



$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$stock_remarkk2 = $_POST["stock_remarkk2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$discount_unit2 = $_POST["discount_unit2"];
$sn_number2 = $_POST["sn_number2"];


$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$stock_remarkk3 = $_POST["stock_remarkk3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$discount_unit3 = $_POST["discount_unit3"];
$sn_number3 = $_POST["sn_number3"];


$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$stock_remarkk4 = $_POST["stock_remarkk4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$discount_unit4 = $_POST["discount_unit4"];
$sn_number4 = $_POST["sn_number4"];




$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$stock_remarkk5 = $_POST["stock_remarkk5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$discount_unit5 = $_GET["discount_unit5"];
$sn_number5 = $_GET["sn_number5"];









if($product_id1 !==''  ){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,stock_remark,discount_unit,warranty,cal,pm,product_id,product_code,stock_ckk)
values ('".$ref_id."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$product_price1."','".$sum_amount1."','".$stock_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_id1."','".$product_id1."','1')";
	
$objQuery1 = mysqli_query($conn,$strSQL1);
	

}


if($product_id2 !==''  ){

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,stock_ckk)
values ('".$ref_id."','".$sale_count2."','".$sale_count2."','".$product_price2."','".$product_price2."','".$sum_amount2."','".$stock_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$product_id2."','".$product_id2."','1')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
	
}


if($product_id3 !==''  ){

$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,stock_ckk)
values ('".$ref_id."','".$sale_count3."','".$sale_count3."','".$product_price3."','".$product_price3."','".$sum_amount3."','".$stock_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$product_id3."','".$product_id3."','1')";

$objQuery3 = mysqli_query($conn,$strSQL3);
	


}


if($product_id4 !==''  ){

$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,stock_ckk)
values ('".$ref_id."','".$sale_count4."','".$sale_count4."','".$product_price4."','".$product_price4."','".$sum_amount4."','".$stock_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$product_id4."','".$product_id4."','1')";

	$objQuery4 = mysqli_query($conn,$strSQL4);
	

}


if($product_id5 !==''  ){

$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,sale_remark,discount_unit,warranty,cal,pm,product_id,product_code,stock_ckk)
values ('".$ref_id."','".$sale_count5."','".$sale_count5."','".$product_price5."','".$product_price5."','".$sum_amount5."','".$stock_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$product_id5."','".$product_id5."','1')";

$objQuery5 = mysqli_query($conn,$strSQL5);
	
	


}
		$strSQL88 = "Update   so__main set stock_complete='1' Where ref_id='$ref_id' ";
	$objQuery88 = mysqli_query($conn,$strSQL88);

if($objQuery){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_stock.php?start_date=$start_date&end_date=$end_date';";
echo "</script>";
  } else {
   echo "Cannot";
  }

	
}
?>