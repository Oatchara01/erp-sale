<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_doc = $_POST["type_doc"];
$bill_id  = $_POST["bill_id"];
$bill_name = $_POST["bill_name"];
$bill_address = $_POST["bill_address"];
$bill_tel = $_POST["bill_tel"];
$full_bill = $_POST["full_bill"];

$date_so = $_POST["date_so"];
$suggest = $_POST["suggest"];
$payment = $_POST["payment"];
$sale_comment = $_POST["sale_comment"];
$po_no = $_POST["po_no"];
$delivery_contract = $_POST["delivery_contract"];
$book_clear = $_POST["book_clear"];
$book_no = $_POST["book_no"];
$brn_clear = $_POST["brn_clear"];
$brn_no = $_POST["brn_no"];
$brnp_clear = $_POST["brnp_clear"];
$brnp_no = $_POST["brnp_no"];
$sn_ckk = $_POST["sn_ckk"];
$sn_no = $_POST["sn_no"];
$install_place = $_POST["address_send"];
$with_pr = $_POST["with_pr"];
$type_type = $_POST["type_type"];
$type_detail = $_POST["type_detail"];
$delivery_type = $_POST["delivery_type"];
$delivery_date = $_POST["start_date"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$delivery_time = "$start_time $end_time";
$delivery_address = $_POST["address_send"];
$delivery_contact = $_POST["customer_name"];
$delivery_tel = $_POST["customer_tel"];
$payment_des  = $_POST["payment_des"];
$have_order  = $_POST["have_order"];
$order_no = $_POST["order_no"];	

$sale_date= date('Y-m-d');
$sale =  $_POST['sale'];
$sale_code = $_POST['sale_code'];
  
  if($sale_code=='S11' or $sale_code=='S12' or $sale_code=='S13' or $sale_code=='S14'   or $sale_code=='S24'){
$sup_code = 'SS2';
$approve  = 'นรินทิพย์';
  }else if ($sale_code=='S15' or $sale_code=='S22' or $sale_code=='S21' or $sale_code=='S51') {

$sup_code = 'SS1';
$approve  = 'พรรณิภา';
  }else if ($sale_code=='S16' or $sale_code=='S17' or $sale_code=='SM1' or $sale_code=='S23') {

$sup_code = 'SM1';
$approve  = 'ลักษณาวรรณ';


  }else if ($sale_code=='S31' or $sale_code=='MM1') {
$sup_code = 'SS3';
$approve  = 'มาลินี';

  }else if ($sale_code=='EN') {
$sup_code = 'SUP_EN';
$approve  = 'บรรเทิง';

  }
	
$iv_no = $_POST["iv_no"];
$iv_date = $_POST["iv_date"];
$dep_no  = $_POST["dep_no"];
$job_no  = $_POST["job_no"];
$tax_id  = $_POST["tax_id"];

$pr_no  = $_POST["pr_no"];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$name =  $_SESSION['name'];
$admin_date= date('Y-m-d');
$admin_code =	$_SESSION['code'];
$admin =  $_SESSION['name'];

$add_by = "$name $surname";

//echo $_FILES['upload1']['name'];
//exit();
	move_uploaded_file($_FILES['slip1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip1']['name']));
	move_uploaded_file($_FILES['slip2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip2']['name']));
	move_uploaded_file($_FILES['slip3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip3']['name']));
	move_uploaded_file($_FILES['slip4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip4']['name']));
	move_uploaded_file($_FILES['slip5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip5']['name']));

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__so";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "SO";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}

$so = "SO";
$ref_id ="$so$nextId";

	
$save="insert into hos__so
(ref_id,type_doc,bill_name,bill_address,full_bill,date_so,suggest,payment,sale_comment,po_no,delivery_contract,book_clear,book_no,brn_clear,brn_no,brnp_clear,brnp_no,sn_ckk,sn_no,install_place,with_pr,type_type,type_detail,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,sale_date,sale,sale_code,pr_no,add_date,add_by,status_doc,payment_des,slip1,slip2,slip3,slip4,slip5,job_no,dep_no,bill_id,have_order,send_sup,order_no,tax_id,adm_ckk)
values
('".$ref_id."','".$type_doc."','".$bill_name."','".$bill_address."','".$full_bill."','".$date_so."','".$suggest."','".$payment."','".$sale_comment."','".$po_no."','".$delivery_contract."','".$book_clear."','".$book_no."','".$brn_clear."','".$brn_no."','".$brnp_clear."','".$brnp_no."','".$sn_ckk."','".$sn_no."','".$install_place."','".$with_pr."','".$type_type."','".$type_detail."','".$delivery_type."','".$delivery_date."','".$delivery_time."','".$delivery_address."','".$delivery_contact."','".$delivery_tel."','".$sale_date."','".$sale."','".$sale_code."','".$pr_no."','".$add_date."','".$add_by."','Request','".$payment_des."','".$_FILES['slip1']['name']."','".$_FILES['slip2']['name']."','".$_FILES['slip3']['name']."','".$_FILES['slip4']['name']."','".$_FILES['slip5']['name']."','".$job_no."','".$dep_no."','".$bill_id."','".$have_order."','1','".$order_no."','".$tax_id."','1')";



$qsave=mysqli_query($conn,$save);


$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
$warranty =$_POST["warranty"];
$pm=$_POST["pm"];
$cal=$_POST["cal"];
$product_id = $_POST["product_id"];
$discount_unit = $_POST["discount_unit"];
$sn = $_POST["sn"];

foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
		$sn_new  = $sn[$key];
		$sale_remarkk_new=$sale_remarkk[$key];
		$warranty_new=$warranty[$key];
		$pm_new=$pm[$key];
		$cal_new=$cal[$key];
        $product_id_new =$product_id[$key];
        $discount_unit1 =$discount_unit[$key];
		$discount_unit_new=str_replace(',','', $discount_unit1);
		$sum_amount_new = ($product_price_new - $discount_unit_new)*$sale_count_new;
		 


	if($product_id_new!=''){


$strSQL = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,sn,clear_br)
values ('".$ref_id."','".$sale_count_new."','".$product_price_new."','".$sum_amount_new."','".$sale_remarkk_new."','".$discount_unit_new."','".$warranty_new."','".$cal_new."','".$pm_new."','".$product_id_new."','".$product_id_new."','".$sn_new."','1')";

$objQuery = mysqli_query($conn,$strSQL);


$strSQL15 = "Update   hos__subbr set clear_ckk='1'   Where id= '$id_new' ";

$objQuery15= mysqli_query($conn,$strSQL15);


}
	}

	


	$strSQL1 = "SELECT sum(count) as count FROM  (hos__br LEFT JOIN hos__subbr ON hos__br.ref_id_br=hos__subbr.ref_idd_br) WHERE iv_no = '".$brnp_no."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");

$objResult1 = mysqli_fetch_array($objQuery1);


$sql3 = "SELECT sum(count) as count3   FROM  (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) where brnp_no = '".$brnp_no."' and clear_br ='1' ";
	
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());

$rs3 = mysqli_fetch_assoc($qry3);

$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd) where iv_no = '".$brnp_no."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());

$rs4 = mysqli_fetch_assoc($qry4);

$count3 =  $rs3["count3"];
$count4 =  $rs4["count4"]; 
$count5 = $count3 + $count4;

$count2 = $objResult1["count"] - $count5;


	
	if($count2 == '0'){


$save1="Update   hos__br set  close_br = '1'   where iv_no ='".$brnp_no."'";

$qsave1=mysqli_query($conn,$save1);

	}


$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);
$discount_unit1 = $_POST["discount_unit1"];
$warranty1  = $_POST["warranty1"];
$cal1 = $_POST["cal1"];
$pm1 = $_POST["pm1"];
	
	if($_POST["product_code1"]!=''){
$product_code1 = $_POST["product_code1"];
	}else{
$product_code1 = $_POST["product_codet1"];
	}

$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sale_remarkk2 = $_POST["sale_remarkk2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$discount_unit2 = $_POST["discount_unit2"];
$warranty2  = $_POST["warranty2"];
$cal2 = $_POST["cal2"];
$pm2 = $_POST["pm2"];
	
	if($_POST["product_code2"]!=''){
$product_code2 = $_POST["product_code2"];
	}else{
$product_code2 = $_POST["product_codet2"];
	}


$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$discount_unit3 = $_POST["discount_unit3"];
$warranty3  = $_POST["warranty3"];
$cal3 = $_POST["cal3"];
$pm3 = $_POST["pm3"];
	if($_POST["product_code3"]!=''){
$product_code3 = $_POST["product_code3"];
	}else{
$product_code3 = $_POST["product_codet3"];
	}

$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$discount_unit4 = $_POST["discount_unit4"];
$warranty4  = $_POST["warranty4"];
$cal4 = $_POST["cal4"];
$pm4 = $_POST["pm4"];
	
	if($_POST["product_code4"]!=''){
$product_code4 = $_POST["product_code4"];
	}else{
$product_code4 = $_POST["product_codet4"];
	}



$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$discount_unit5 = $_POST["discount_unit5"];
$warranty5  = $_POST["warranty5"];
$cal5 = $_POST["cal5"];
$pm5 = $_POST["pm5"];
	
	if($_POST["product_code5"]!=''){
$product_code5 = $_POST["product_code5"];
	}else{
$product_code5 = $_POST["product_codet5"];
	}




//แถวที่ 1

if($product_id1 !==''  ){
	
	$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code1."' ";
//echo $strSQL21;
//exit();
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];

	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
$strSQL104 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_idb1."','".$product_idb1."','".$product_code1."','1','".$product_code1."')";


$objQuery104 = mysqli_query($conn,$strSQL104);
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count1."','0.00','0.00','','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code1."')";



$objQuery100 = mysqli_query($conn,$strSQL100);
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count1."','0.00','0.00','','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code1."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count1."','0.00','0.00','','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code1."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	}
	
}else{
	
$strSQL1 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_id1."','".$product_id1."')";


$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
}





//แถวที่ 2

if($product_id2 !==''  ){


	$strSQL32 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code2."' ";
//echo $strSQL21;
//exit();
$objQuery32 = mysqli_query($conn,$strSQL32) or die ("Error Query [".$strSQL32."]");
$Num_Rows32 = mysqli_num_rows($objQuery32);
$objResult32 = mysqli_fetch_array($objQuery32);

$product_ida1 =$objResult32["product_id1"];
$product_ida2 =$objResult32["product_id2"];
$product_ida3 =$objResult32["product_id3"];
$product_ida4 =$objResult32["product_id4"];

	
if($Num_Rows32 > 0){

	if($product_ida1!=''){
$strSQL105 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$product_ida1."','".$product_ida1."','".$product_code2."','1','".$product_code2."')";


$objQuery105 = mysqli_query($conn,$strSQL105);
	}
	
	if($product_ida2!=''){
		
$strSQL106 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count2."','0.00','0.00','','0.00','0','0','0','".$product_ida2."','".$product_ida2."','1','".$product_code2."')";


//echo $strSQL100;

$objQuery106 = mysqli_query($conn,$strSQL106);
	}
	
	if($product_ida3!=''){
		
$strSQL107 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count2."','0.00','0.00','','0.00','0','0','0','".$product_ida3."','".$product_ida3."','1','".$product_code2."')";

$objQuery107 = mysqli_query($conn,$strSQL107);
	}
	
	if($product_ida4!=''){
		
$strSQL108 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count2."','0.00','0.00','','0.00','0','0','0','".$product_ida4."','".$product_ida4."','1','".$product_code2."')";

$objQuery108 = mysqli_query($conn,$strSQL108);
	}
	
}else{

$strSQL2 ="insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$product_id2."','".$product_id2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);

}
}







//แถวที่ 3

if($product_id3 !==''  ){

$strSQL33 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code3."' ";
$objQuery33 = mysqli_query($conn,$strSQL33) or die ("Error Query [".$strSQL33."]");
$Num_Rows33 = mysqli_num_rows($objQuery33);
$objResult33 = mysqli_fetch_array($objQuery33);

$product_idc1 =$objResult33["product_id1"];
$product_idc2 =$objResult33["product_id2"];
$product_idc3 =$objResult33["product_id3"];
$product_idc4 =$objResult33["product_id4"];

	
if($Num_Rows33 > 0){

	if($product_idc1!=''){
$strSQL109 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$product_idc1."','".$product_idc1."','".$product_code3."','1','".$product_code3."')";


$objQuery109 = mysqli_query($conn,$strSQL109);
	}
	
	if($product_idc2!=''){
		
$strSQL110 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count3."','0.00','0.00','','0.00','0','0','0','".$product_idc2."','".$product_idc2."','1','".$product_code3."')";


//echo $strSQL100;

$objQuery110 = mysqli_query($conn,$strSQL110);
	}
	
	if($product_idc3!=''){
		
$strSQL111 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count3."','0.00','0.00','','0.00','0','0','0','".$product_idc3."','".$product_idc3."','1','".$product_code3."')";

$objQuery111 = mysqli_query($conn,$strSQL111);
	}
	
	if($product_idc4!=''){
		
$strSQL112 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count3."','0.00','0.00','','0.00','0','0','0','".$product_idc4."','".$product_idc4."','1','".$product_code3."')";

$objQuery112 = mysqli_query($conn,$strSQL112);
	}
	
}else{


$strSQL3 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$product_id3."','".$product_id3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);

}
}


if($product_id4 !==''  ){


$strSQL34 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code4."' ";
$objQuery34 = mysqli_query($conn,$strSQL34) or die ("Error Query [".$strSQL34."]");
$Num_Rows34 = mysqli_num_rows($objQuery34);
$objResult34 = mysqli_fetch_array($objQuery34);

$product_idd1 =$objResult34["product_id1"];
$product_idd2 =$objResult34["product_id2"];
$product_idd3 =$objResult34["product_id3"];
$product_idd4 =$objResult34["product_id4"];

	
if($Num_Rows34 > 0){

	if($product_idd1!=''){

$strSQL113 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$product_idd1."','".$product_idd1."','".$product_code4."','1','".$product_code4."')";


$objQuery113 = mysqli_query($conn,$strSQL113);
	}
	
	if($product_idd2!=''){
		
$strSQL114 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count4."','0.00','0.00','','0.00','0','0','0','".$product_idd2."','".$product_idd2."','1','".$product_code4."')";


//echo $strSQL100;

$objQuery114 = mysqli_query($conn,$strSQL114);
	}
	
	if($product_idd3!=''){
		
$strSQL115 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count4."','0.00','0.00','','0.00','0','0','0','".$product_idd3."','".$product_idd3."','1','".$product_code4."')";

$objQuery115 = mysqli_query($conn,$strSQL115);
	}
	
	if($product_idd4!=''){
		
$strSQL116 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count4."','0.00','0.00','','0.00','0','0','0','".$product_idd4."','".$product_idd4."','1','".$product_code4."')";

$objQuery116 = mysqli_query($conn,$strSQL116);
	}
	
}else{



$strSQL4 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$product_id4."','".$product_id4."')";
//echo $strSQL1;
//exit();

$objQuery4 = mysqli_query($conn,$strSQL4);

}
}


if($product_id5 !==''  ){


$strSQL35 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code5."' ";
$objQuery35 = mysqli_query($conn,$strSQL35) or die ("Error Query [".$strSQL35."]");
$Num_Rows35 = mysqli_num_rows($objQuery35);
$objResult35 = mysqli_fetch_array($objQuery35);

$product_ide1 =$objResult35["product_id1"];
$product_ide2 =$objResult35["product_id2"];
$product_ide3 =$objResult35["product_id3"];
$product_ide4 =$objResult35["product_id4"];

	
if($Num_Rows35 > 0){

	if($product_ide1!=''){

$strSQL117 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$product_ide1."','".$product_ide1."','".$product_code5."','1','".$product_code5."')";


$objQuery117 = mysqli_query($conn,$strSQL117);
	}
	
	if($product_ide2!=''){
		
$strSQL118 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count5."','0.00','0.00','','0.00','0','0','0','".$product_ide2."','".$product_ide2."','1','".$product_code5."')";


$objQuery118 = mysqli_query($conn,$strSQL118);
	}
	
	if($product_ide3!=''){
		
$strSQL119 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count5."','0.00','0.00','','0.00','0','0','0','".$product_ide3."','".$product_ide3."','1','".$product_code5."')";

$objQuery119 = mysqli_query($conn,$strSQL119);
	}
	
	if($product_ide4!=''){
		
$strSQL120 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count5."','0.00','0.00','','0.00','0','0','0','".$product_ide4."','".$product_ide4."','1','".$product_code5."')";

$objQuery120 = mysqli_query($conn,$strSQL120);
	}
	
}else{



$strSQL5 = "insert into hos__subso
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$product_id5."','".$product_id5."')";
//echo $strSQL1;
//exit();

$objQuery5 = mysqli_query($conn,$strSQL5);

}
}







 $start_date =$_POST["start_date"];
 $status_comment = $_POST["status_comment"];
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
 $customer_name=$_POST["customer_name"];
 $customer_tel=$_POST["customer_tel"];
 $address_name=$_POST["address_name"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
	
 $on_time =$_POST["on_time"];	
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
 $product_name=$_POST["product"];
 $product_sn=$_POST["product_sn"];
 $unit_credit=$_POST["unit_credit"];
 $price=$_POST["unit_cash"];
 $employee_name=$_POST["employee_name"];
$h_employee_name=$_POST["h_employee_name"];
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


$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,add_code) 

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$h_employee_name."')";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());










	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_suphos_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}