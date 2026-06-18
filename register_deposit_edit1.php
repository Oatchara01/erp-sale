
<?php 

include('head.php');

 ?>


 <?php

include "dbconnect.php";
  //print_r($_POST);
	//exit();
	date_default_timezone_set("Asia/Bangkok");
$bank_name =$_POST["bank_name"];

$add_by =$_POST["add_by"];
$bill_name = $_POST["bill_name"];
$bill_date =$_POST["bill_date"];
$deposit_code =$_POST["deposit_code"];
$bill_address =$_POST["bill_address"];
$bill_tel =$_POST["bill_tel"];
$customer_contact =$_POST["customer_contact"];
$tax_id =$_POST["tax_id"];
$delivery_date =$_POST["delivery_date"];
$delivery_time =$_POST["delivery_time"];
$department =$_POST["department"];
$delivery_name =$_POST["delivery_name"];
$delivery_tel =$_POST["delivery_tel"];
$delivery_address =$_POST["delivery_address"];
$product_name1 =$_POST["product_name1"];
$product_name2 =$_POST["product_name2"];
$product_name3 =$_POST["product_name3"];
$product_name4 =$_POST["product_name4"];
$product_name5 =$_POST["product_name5"];



$product_name6 = $_POST["product_name6"];
$product_name7 = $_POST["product_name7"];
$product_name8 = $_POST["product_name8"];
$product_name9 = $_POST["product_name9"];
$product_name10 = $_POST["product_name10"];


$product_name11 = $_POST["product_name11"];
$product_name12 = $_POST["product_name12"];
$product_name13 = $_POST["product_name13"];
$product_name14 = $_POST["product_name14"];
$product_name15 = $_POST["product_name15"];





$unit1 =$_POST["unit_price1"];
$unit2 =$_POST["unit_price2"];
$unit3 =$_POST["unit_price3"];
$unit4 =$_POST["unit_price4"];
$unit5 =$_POST["unit_price5"];

$unit_price1= str_replace(',','', $unit1);
$unit_price2= str_replace(',','', $unit2);
$unit_price3= str_replace(',','', $unit3);
$unit_price4= str_replace(',','', $unit4);
$unit_price5= str_replace(',','', $unit5);


$unit6 = $_POST["unit_price6"];
$unit7 = $_POST["unit_price7"];
$unit8 = $_POST["unit_price8"];
$unit9 = $_POST["unit_price9"];
$unit10 = $_POST["unit_price10"];

$unit_price6= str_replace(',','', $unit6);
$unit_price7= str_replace(',','', $unit7);
$unit_price8= str_replace(',','', $unit8);
$unit_price9= str_replace(',','', $unit9);
$unit_price10= str_replace(',','', $unit10);




$unit11 = $_POST["unit_price11"];
$unit12 = $_POST["unit_price12"];
$unit13 = $_POST["unit_price13"];
$unit14 = $_POST["unit_price14"];
$unit15 = $_POST["unit_price15"];

$unit_price11= str_replace(',','', $unit11);
$unit_price12= str_replace(',','', $unit12);
$unit_price13= str_replace(',','', $unit13);
$unit_price14= str_replace(',','', $unit14);
$unit_price15= str_replace(',','', $unit15);



$sum_unit =$_POST["sum_unit_price"];
$sum_unit_price= str_replace(',','', $sum_unit);

$bill_send =$_POST["bill_send"]; 
$payment =$_POST["payment"];
$check_no =$_POST["check_no"];
$branch_name =$_POST["branch_name"];
$payment_date =$_POST["payment_date"];
$employee_name =$_POST["employee_signature_name"];
//echo $employee_name;
//exit();
$bank_card =$_POST["bank_card"];
$add_date = date('Y-m-d H:i:s');




if ($_POST['runway']!=''){
		$runway=$_POST["runway"];
	}else{
		$runway='0';
	}

if ($_POST['road']!=''){
		$road=$_POST["road"];
	}else{
		$road='0';
	}

if ($_POST['soy']!=''){
	$soy=$_POST["soy"];
	}else{
		$soy='0';
	}
	
	if ($_POST['car_load']!=''){
	$car_load=$_POST["car_load"];
	}else{
		$car_load='0';
	}

if ($_POST['no_car_road']!=''){
	$no_car_road=$_POST["no_car_road"];
	}else{
		$no_car_road='0';
	}
	
	if ($_POST['car_road']!=''){
	$car_road=$_POST["car_road"];
	}else{
		$car_road='0';
	}
if ($_POST['car_home']!=''){
	$car_home=$_POST["car_home"];
	}else{
		$car_home='0';
	}

	if ($_POST['slope']!=''){
	$slope=$_POST["slope"];	
	}else{
		$slope='0';
	}

	
	if ($_POST['bundai']!=''){
	$bundai=$_POST["bundai"];
	}else{
		$bundai='0';
	}

	if ($_POST['bundai_install']!=''){
	$bundai_install=$_POST["bundai_install"];
	}else{
		$bundai_install='0';
	}

	if ($_POST['lip']!=''){
	$lip=$_POST["lip"];
	}else{
		$lip='0';
	}

	
	if ($_POST['want_employee']!=''){
	$want_employee=$_POST["want_employee"];	
	}else{
		$want_employee='0';
	}

	if ($_POST['want_ex']!=''){
	$want_ex=$_POST["want_ex"];	
	}else{
		$want_ex='0';
	}

	
	if ($_POST['want_credit']!=''){
	$want_credit=$_POST["want_credit"];
	}else{
		$want_credit='0';
	}
if ($_POST['want_prem']!=''){
	$want_prem=$_POST["want_prem"];	
	}else{
		$want_prem='0';
	}
	
	if ($_POST['head_bad']!=''){
	$head_bad=$_POST["head_bad"];	
	}else{
		$head_bad='0';
	}

	
	if ($_POST['height_ltd']!=''){
	$height_ltd=$_POST["height_ltd"];	
	}else{
		$height_ltd='0';
	}
if ($_POST['up']!=''){
	$up=$_POST["up"];	
	}else{
		$up='0';
	}
if ($_POST['no_up']!=''){
	$no_up=$_POST["no_up"];	
	}else{
		$no_up='0';
	}

if ($_POST['more']!=''){
	$more=$_POST["more"];	
	}else{
		$more='0';
	}
	
	
	
$type_bundai=$_POST["type_bundai"];	
	
	
	
$soy_long=$_POST["soy_long"];
$soy_big=$_POST["soy_big"];
$car_park=$_POST["car_park"];
$door_long=$_POST["door_long"];
$unit_bundai=$_POST["unit_bundai"];
$door_big=$_POST["door_bigger"];
$door_longer=$_POST["door_longer"];
$type_door=$_POST["type_door"];
$home_type=$_POST["home_type"];
$install=$_POST["install"];
$bundai_big=$_POST["bundai_big"];
$lip_big=$_POST["lip_big"];
$lip_long=$_POST["lip_long"];
$lip_weight=$_POST["lip_weight"];
$employee_unit=$_POST["employee_unit"];
$ferniger_name=$_POST["ferniger_name"];
$ferniger_address=$_POST["ferniger_address"];
$number=$_POST["number"];
$status_comment=$_POST["status_comment"];

$dept=$_POST["dept"];
$room_bigger=$_POST["room_bigger"];
$room_longer=$_POST["room_longer"];
$bundai_hug=$_POST["bundai_hug"];
$bank=$_POST["bank"];

$department_show=$_POST["department_show"];
$description_ja=$_POST["description_ja"];









 $strSQL =  "Update tb_deposit  Set bill_date = '".$bill_date."',bill_name = '".$bill_name."',bill_address = '".$bill_address."',bill_tel='".$bill_tel."',customer_contact='".$customer_contact."',tax_id='".$tax_id."',delivery_date='".$delivery_date."',delivery_time='".$delivery_time."',department='".$department."',delivery_name='".$delivery_name."',delivery_tel='".$delivery_tel."',delivery_address='".$delivery_address."',product_name1='".$product_name1."',product_name2='".$product_name2."',product_name3='".$product_name3."',product_name4='".$product_name4."',product_name5='".$product_name5."',unit_price1='".$unit_price1."',unit_price2='".$unit_price2."',unit_price3='".$unit_price3."',unit_price4='".$unit_price4."',unit_price5='".$unit_price5."',sum_unit_price='".$sum_unit_price."',payment='".$payment."',check_no='".$check_no."',branch_name='".$branch_name."',payment_date='".$payment_date."',employee_name='".$employee_name."',bank_name='".$bank_name."',more = '".$more."',bank_card = '".$bank_card."',unit_price6='".$unit_price6."',unit_price7='".$unit_price7."',unit_price8='".$unit_price8."',unit_price9='".$unit_price9."',unit_price10='".$unit_price10."',unit_price11='".$unit_price11."',unit_price12='".$unit_price12."',unit_price13='".$unit_price13."',unit_price14='".$unit_price14."',unit_price15='".$unit_price15."',product_name6='".$product_name6."',product_name7='".$product_name7."',product_name8='".$product_name8."',product_name9='".$product_name9."',product_name10='".$product_name10."',product_name11='".$product_name11."',product_name12='".$product_name12."',product_name13='".$product_name13."',product_name14='".$product_name14."',product_name15='".$product_name15."',bill_send='".$bill_send."'  where deposit_code = '".$deposit_code."'";


//echo $strSQL;
//exit();
 $objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());






 $strSQL1 =  "Update tb_transaction Set runway='".$runway."',road='".$road."',soy='".$soy."',soy_long='".$soy_long."',soy_big='".$soy_big."',car_load='".$car_load."',car_park='".$car_park."',car_road='".$car_road."',no_car_road='".$no_car_road."',car_home='".$car_home."',door_long='".$door_long."',slope='".$slope."',bundai='".$bundai."',unit_bundai='".$unit_bundai."',door_big='".$door_big."',door_longer='".$door_longer."',type_door='".$type_door."',home_type='".$home_type."',install='".$install."',bundai_install='".$bundai_install."',bundai_big='".$bundai_big."',lip='".$lip."',lip_big='".$lip_big."',lip_long='".$lip_long."',lip_weight='".$lip_weight."',want_employee='".$want_employee."',employee_unit='".$employee_unit."',ferniger_name='".$ferniger_name."',ferniger_address='".$ferniger_address."',want_ex='".$want_ex."',want_credit='".$want_credit."',want_prem='".$want_prem."',room_bigger='".$room_bigger."',room_longer='".$room_longer."',bundai_hug='".$bundai_hug."',bank='".$bank."',description='".$description_ja."',type_bundai='".$type_bundai."',head_bad='".$head_bad."',height_ltd='".$height_ltd."',up='".$up."',no_up= '".$no_up."'  where  deposit_id ='".$deposit_code."'";


//echo $strSQL1;
//exit();
 $objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());










?>












<p align="center"><a href="report_deposit.php?deposit_code=<?php echo $deposit_code;?>"><img src="img/print_icon-2.png"   width="60" height="60" border="0" /></a></p>


<p align="center"><a href="main_allwell.php"><span class="style8">กลับสู่หน้าหลัก</span></a></p>



