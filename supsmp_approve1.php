<?php include ("head.php"); ?>


<?php
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$smp_date = $_POST["smp_date"];
$address_name = $_POST["address_name"];
$customer_name = $_POST["customer_name"];
$comment_sale = $_POST["comment_sale"];
$sup_name =  $_SESSION['name'];
$sale_code = $_POST['sale_code'];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
$comment_sup = $_POST["comment_sup"];
$type_company  = $_POST["type_company"];
$ref_idsmp = $_POST['ref_idsmp'];
$delivery_date =$_POST["start_date"];
$date_send_key =$_POST["between_date"];	
$customer_tel = $_POST["customer_tel"];
$brnp_ckk =$_POST["brnp_ckk"];
$brnp_no =$_POST["brnp_no"];
$bill_id = $_POST["bill_id"];
$crm_ref = $_POST["crm_ref"];
$crm_ckk = $_POST["crm_ckk"];
$delivery_type = $_POST["delivery_type"];
$order_id = $_POST["order_id"];	
	
if($_FILES['up_img1']['name']!=''){
 move_uploaded_file($_FILES['up_img1']['tmp_name'],"smp_up/".iconv("UTF-8", "TIS-620",$_FILES['up_img1']['name']));
 $up_img1=$_FILES['up_img1']['name'];
}else{
 $up_img1 = $_POST["up_img1_1"];

}	
	
if($_FILES['up_img2']['name']!=''){
 move_uploaded_file($_FILES['up_img2']['tmp_name'],"smp_up/".iconv("UTF-8", "TIS-620",$_FILES['up_img2']['name']));
 $up_img2=$_FILES['up_img2']['name'];
}else{
 $up_img2 = $_POST["up_img2_2"];

}	
	
if($_FILES['up_img3']['name']!=''){
 move_uploaded_file($_FILES['up_img3']['tmp_name'],"smp_up/".iconv("UTF-8", "TIS-620",$_FILES['up_img3']['name']));
 $up_img3=$_FILES['up_img3']['name'];
}else{
 $up_img3 = $_POST["up_img3_3"];

}		
	
	

$save="Update  hos__smp set
smp_date = '".$smp_date."',address_name ='".$address_name."',customer_name ='".$customer_name."',comment_sale = '".$comment_sale."',sup_name = '".$sup_name."',sale_code = '".$sale_code."',comment_sup='".$comment_sup."',delivery_date='".$delivery_date."',date_send_key='".$date_send_key."',brnp_no='".$brnp_no."',brnp_ckk='".$brnp_ckk."',up_img1='".$up_img1."',up_img2='".$up_img2."',up_img3='".$up_img3."',customer_tel='".$customer_tel."',bill_id='".$bill_id."',crm_ckk='".$crm_ckk."',crm_ref='".$crm_ref."',delivery_type='".$delivery_type."',order_id='".$order_id."'	  where ref_idsmp = '".$ref_idsmp."'";

$qsave=mysqli_query($conn,$save);



$id = $_POST["subsmp_id"];
$product_id = $_POST["product_id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remark = $_POST["sale_remark"];
$clear_br = $_POST["clear_br"];
$br_no = $_POST["br_no"];
$sn	= $_POST["sn"];

$strSQL21 = "SELECT * FROM hos__subsmp WHERE reff_idsmp = '".$ref_idsmp."' ";
$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);






// เพิ่มเติม เริ่ม
$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$sale_remark6 = $_POST["sale_remark6"];
$waranty6 = $_POST["waranty6"];
$clear_br6 = $_POST["clear_br6"];
$br_no6 = $_POST["br_no6"];		

$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$sale_remark7 = $_POST["sale_remark7"];
$waranty7 = $_POST["waranty7"];
$clear_br7 = $_POST["clear_br7"];
$br_no7 = $_POST["br_no7"];		
		


$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$sale_remark8 = $_POST["sale_remark8"];
$waranty8 = $_POST["waranty8"];
$clear_br8 = $_POST["clear_br8"];
$br_no8 = $_POST["br_no8"];		
		


$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$sale_remark9 = $_POST["sale_remark9"];
$waranty9 = $_POST["waranty9"];
$clear_br9 = $_POST["clear_br9"];
$br_no9 = $_POST["br_no9"];		
		

$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$sale_remark10 = $_POST["sale_remark10"];
$waranty10 = $_POST["waranty10"];
$clear_br10 = $_POST["clear_br10"];
$br_no10 = $_POST["br_no10"];		


if($product_id6 !==''  ){

	$strSQL31 = "SELECT * FROM tb_probom_online WHERE id_bompro = '".$product_id6."' ";
	$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
	$Num_Rows31 = mysqli_num_rows($objQuery31);
	$objResult31 = mysqli_fetch_array($objQuery31);
	
	$id_product1 =$objResult31["id_product1"];
	$id_product2 =$objResult31["id_product2"];
	$id_product3 =$objResult31["id_product3"];
	$id_product4 =$objResult31["id_product4"];
	$id_product5 =$objResult31["id_product5"];
	$id_product6 =$objResult31["id_product6"];
	$id_product7 =$objResult31["id_product7"];
	$id_product8 =$objResult31["id_product8"];
	$id_product9 =$objResult31["id_product9"];
	$id_product10 =$objResult31["id_product10"];
		
	$unit1 = $sale_count6*$objResult31["unit1"];
	$unit2 = $sale_count6*$objResult31["unit2"];
	$unit3 = $sale_count6*$objResult31["unit3"];
	$unit4 = $sale_count6*$objResult31["unit4"];
	$unit5 = $sale_count6*$objResult31["unit5"];
	$unit6 = $sale_count6*$objResult31["unit6"];
	$unit7 = $sale_count6*$objResult31["unit7"];
	$unit8 = $sale_count6*$objResult31["unit8"];
	$unit9 = $sale_count6*$objResult31["unit9"];
	$unit10 =$sale_count6*$objResult31["unit10"];
		
	if($Num_Rows31 > 0){
	
				if($id_product6 !=''){
					
				$strSQL1 = "insert into hos__subsmp
				(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark,clear_br,br_no)
				values ('".$ref_idsmp."','".$id_product6."','".$id_product6."','".$unit6."','".$unit6."','0.00','0.00','".$sale_remark6."','".$clear_br6."','".$br_no6."')";
				$objQuery1 = mysqli_query($conn,$strSQL1);	
					
				}		
					
				if($id_product7 !=''){
					
				$strSQL1 = "insert into hos__subsmp
				(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark,clear_br,br_no)
				values ('".$ref_idsmp."','".$id_product7."','".$id_product7."','".$unit7."','".$unit7."','0.00','0.00','".$sale_remark6."','".$clear_br6."','".$br_no6."')";
				$objQuery1 = mysqli_query($conn,$strSQL1);	
					
				}	
					
				if($id_product8 !=''){
					
				$strSQL1 = "insert into hos__subsmp
				(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark,clear_br,br_no)
				values ('".$ref_idsmp."','".$id_product8."','".$id_product8."','".$unit8."','".$unit8."','0.00','0.00','".$sale_remark6."','".$clear_br6."','".$br_no6."')";
				$objQuery1 = mysqli_query($conn,$strSQL1);	
					
				}	
					
				if($id_product9 !=''){
					
				$strSQL1 = "insert into hos__subsmp
				(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark,clear_br,br_no)
				values ('".$ref_idsmp."','".$id_product9."','".$id_product9."','".$unit9."','".$unit9."','0.00','0.00','".$sale_remark6."','".$clear_br6."','".$br_no6."')";
				$objQuery1 = mysqli_query($conn,$strSQL1);	
					
				}	
					
				if($id_product10 !=''){
					
				$strSQL1 = "insert into hos__subsmp
				(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark,clear_br,br_no)
				values ('".$ref_idsmp."','".$id_product10."','".$id_product10."','".$unit10."','".$unit10."','0.00','0.00','".$sale_remark6."','".$clear_br6."','".$br_no6."')";
				$objQuery1 = mysqli_query($conn,$strSQL1);	
					
				}		
					
					
				}else{			
					
				$strSQL6 = "insert into hos__subsmp
				(reff_idsmp,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark,clear_br,br_no)
				values ('".$ref_idsmp."','".$product_id6."','".$product_id6."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$sum_amount6."','".$sale_remark6."','".$clear_br6."','".$br_no6."')";
				
				$objQuery6 = mysqli_query($conn,$strSQL6);
				}
	}

// เพิ่มเติม จบ







if($Num_Rows21 > 0){


 foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
        $product_id_new =$product_id[$key];
		$sale_remark_new = $sale_remark[$key];
	    $clear_br_new = $clear_br[$key];
	    $br_no_new = $br_no[$key];
	    $sn_new = $sn[$key];
		$sum_amount_new = $product_price_new *$sale_count_new;

if($br_no_new !=''){
	
$sql1 = "SELECT ref_id_br   FROM   hos__br   where  iv_no = '".$br_no_new."' and status_doc = 'Approve'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

	
$sql2 = "SELECT sum(count) as sale_count   FROM   hos__subbr   where  ref_idd_br = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";

$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_array($qry2);



$sql3 = "SELECT sum(sale_count) as count3   FROM   hos__subspr  where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$br_no_new."' and status_spr='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM hos__subso where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$br_no_new."' and status_so ='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$br_no_new."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
$rs41 = mysqli_fetch_array($qry41);

$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '".$rs41['ref_id']."' and product_id = '".$product_id_new."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM hos__subsmp where  product_id = '".$product_id_new."' and clear_br = '1' and br_no ='".$br_no_new."' and status_smp ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs3["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];

	
$count2 = ($rs2['sale_count'] - ($count3+$count4+$count5+$count13))-$sale_count_new;

if($count2=='0'){

$save6="Update  hos__subbr set  clear_ckk = '1'    where ref_idd_br = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";
$qsave6=mysqli_query($conn,$save6);

}


		

if($count2 < 0){

echo "<script language=\"JavaScript\">";
echo "alert('สินค้าในใบยืมนี้มีไม่พอในหารเคลียร์ยืมครั้งนี้ค่ะ');window.location='register_salesmp_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
exit();
	
}else{	 

	 
$strSQL1 = "Update  hos__subsmp set  reff_idsmp ='".$ref_idsmp."' ,product_id = '".$product_id_new."',product_code = '".$product_id_new."',sale_count ='".$sale_count_new."',sale_countref ='".$sale_count_new."',unit_price = '".$product_price_new."',sum_amount = '".$sum_amount_new."',sale_remark ='".$sale_remark_new."',clear_br = '".$clear_br_new."',br_no ='".$br_no_new."',sn='".$sn_new."'   where subsmp_id = '".$id_new."'";

$objQuery1 = mysqli_query($conn,$strSQL1);
}
}else{

$strSQL1 = "Update  hos__subsmp set  reff_idsmp ='".$ref_idsmp."' ,product_id = '".$product_id_new."',product_code = '".$product_id_new."',sale_count ='".$sale_count_new."',sale_countref ='".$sale_count_new."',unit_price = '".$product_price_new."',sum_amount = '".$sum_amount_new."',sale_remark ='".$sale_remark_new."',clear_br = '".$clear_br_new."',br_no ='".$br_no_new."',sn='".$sn_new."'   where subsmp_id = '".$id_new."'";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}

	}
}


$start_date =$_POST["start_date"];
 $between_date =$_POST["between_date"];
 $start_time=$_POST["start_time"];
 $end_time=$_POST["end_time"];
 $status=$_POST["status"];
	
 if ($_POST["start_date"]!=''){
		$start_date =$_POST["start_date"];
	}else{
		$start_date='0000-00-00';
	}
	
	if ($_POST['fix_datetime']!=''){
		$fix_date=$_POST['fix_datetime'];
	}else{
		$fix_date='0';
	}
	
	if ($_POST['no_money']!=''){
        $no_price=$_POST['no_money'];
	}else{
		$no_price='0';
	}
	if ($_POST['call_customer']!=''){
		 $call_customer=$_POST['call_customer'];
	}else{
		$call_customer='0';
	}
	if ($_POST['credit_card']!=''){
		 $credit=$_POST['credit_card'];
	}else{
		$credit='0';
	}
	if ($_POST['call_back']!=''){
		 $call_employee=$_POST['call_back'];
	}else{
		$call_employee='0';
	}
	
	if ($_POST['cash']!=''){
		 $chash=$_POST['cash'];
	}else{
		$chash='0';
	}
	if ($_POST['check_paper']!=''){
	 $check_peper=$_POST['check_paper'];
	}else{
		$check_peper='0';
	}
	if ($_POST['check_paper']!=''){
		$check_peper=$_POST['check_paper'];
	}else{
		$check_peper='0';
	}
	if ($_POST['bill']!=''){
		 $bill=$_POST['bill'];
	}else{
		$bill='0';
	}
	if ($_POST['want_bus']!=''){
	$want_bus=$_POST['want_bus'];
	}else{
		$want_bus='0';
	}
	if ($_POST['tran']!=''){
		 $tran=$_POST["tran"];
	}else{
		$tran='0';
	}
	if ($_POST['more']!=''){
		 $check_detail=$_POST["more"];
	}else{
		$check_detail='0';
	}
	
		if ($_POST['dep']!=''){
		  $dep=$_POST["dep"];
	}else{
		$dep='0';
	}

	
 $department=$_POST["department_name"];
 $type_customer=$_POST["customer_typename"];
 $type_company=$_POST["company_name"];
 $customer_name1=$_POST["customer_name1"];
 $customer_tel=$_POST["customer_tel"];
 $address_name1=$_POST["address_name1"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
$on_time = $_POST["on_time"];
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
 $product_name=$_POST["product"];
 $product_sn=$_POST["product_sn"];
 $unit_credit=$_POST["unit_credit"];
 $price=$_POST["unit_cash"];
 $employee_name=$_POST["employee_name"];
 $employee_tel=$_POST["employee_tel"];
 $add_by=$_POST["add_by"];
 $description=$_POST["description"];
 $havemap=$_POST['have_map'];
$unit_check=$_POST["unit_check"];
$unit_bill=$_POST["unit_bill"];
$unit_tran=$_POST["unit_tran"];
$department_show = $_POST["department_show"];
$unit_check1 = str_replace(',', '', $unit_check);
$unit_bill1 = str_replace(',', '', $unit_bill);
$dept =$_POST["dept"];
$status_comment =$_POST["status_comment"];
$address_1 =$_POST["address_1"];
	
	$strSQL22 = "SELECT * FROM tb_register_data WHERE ref_id = '".$ref_idsmp."' ";

$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$Num_Rows22 = mysqli_num_rows($objQuery22);

	if($Num_Rows22 > 0){

$strSQL66 =  "Update tb_register_data set start_date = '".$start_date."',between_date ='".$between_date."',start_time ='".$start_time."',end_time ='".$end_time."',status ='".$status."',fix_date ='".$fix_date."',no_price ='".$no_price."',call_customer ='".$call_customer."',credit ='".$credit."',call_employee ='".$call_employee."',cash ='".$chash."',check_peper ='".$check_peper."',bill = '".$bill."',department ='".$department."',type_customer ='".$type_customer."',type_company = '".$type_company."',customer_name ='".$customer_name1."',customer_tel ='".$customer_tel."',address_name ='".$address_name1."',address_send ='".$address_send."',want_bus ='".$want_bus."',product_name ='".$product_name."',product_sn ='".$product_sn."',unit_credit ='".$unit_credit."',price ='".$price."',employee_name ='".$employee_name."',employee_tel ='".$employee_tel."',add_by ='".$add_by."',description ='".$description."',have_map = '".$havemap."',add_date ='$add_date',unit_bill ='".$unit_bill."',unit_check ='".$unit_check."',unit_tran ='".$unit_tran."',tran ='".$tran."',check_detail ='".$check_detail."',dep ='".$dep."',dept ='".$dept."',department_show ='".$department_show."',customer_contact = '".$customer_contact."',status_comment = '".$status_comment."',on_time = '".$on_time."',address_1 = '".$address_1."'  where ref_id = '".$ref_idsmp."'";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());

	}else{
		
$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1) 

values('".$ref_idsmp."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name1."','".$customer_tel."','".$address_name1."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."')";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());		
		
		
		
	}
		
	

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='supsmp_approve.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


