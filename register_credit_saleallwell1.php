<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$date_credit = $_POST["date_credit"];
$customer_name = $_POST["customer_name"];
$bill_id = $_POST["bill_id"];
$customer_tel = $_POST["customer_tel"];
$address_name = $_POST["address_name"];
$return_des = $_POST["return_des"];
$send_return_name = $_POST["send_return_name"];
$date_send_return = $_POST["date_send_return"];
$sale_name = $_POST["sale_name"];
$sale_date = $_POST["sale_date"];
$name =  $_SESSION['name'];
$surname =  $_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
$ttype_doc = $_POST["ttype_doc"];
$sale_code = $_POST["sale_code"];
$status_doc = 'Request';
$iv_no_ref = $_POST["iv_no_ref"];
$account_no =  $_POST["account_no"];
$account_name =  $_POST["account_name"];
$bank_name =  $_POST["bank_name"];
$type_return = $_POST["type_return"];	
$ref_id = $_POST["ref_id"];	
$sale_chan = $_POST["sale_chan"];
	
	
$strSQL = "SELECT promis_no FROM hos__rental WHERE ref_ai = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

if($objResult["promis_no"]!=''){	
$ref_rental = $objResult["promis_no"];	
}else{
$ref_rental = '';		
}
	
	
	
if($_POST["company_type"]=='1' or $_POST["company_type"]=='3'){	
$company_type = '3';
}else if($_POST["company_type"]=='2' or $_POST["company_type"]=='4'){
$company_type = '4';	
}
	
move_uploaded_file($_FILES['book_bank']['tmp_name'],"credit_no/".iconv("UTF-8", "TIS-620",$_FILES['book_bank']['name']));
	

$id = $_POST["id"];
$count = $_POST["count"];
$unit_price = $_POST["unit_price"];
$sum_amount = $_POST["sum_amount"];
$discount_unit = $_POST["discount_unit"];
$product_id = $_POST["product_id"];

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql1 = "SELECT MAX(ref_credit) AS MAXID FROM tb_credit_note";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);
$maxId = substr($rs1['MAXID'], -4);
$maxId3 = substr($rs1['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);

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

$so = "SR";

$ref_credit ="$so$nextId";

if($product_id !=''){


$save="insert into tb_credit_note
(ref_credit,ref_id,date_credit,customer_name,customer_tel,address_name,return_des,send_return_name,date_send_return,sale_name,sale_date,add_by,add_date,ttype_doc,iv_no_ref,sale_code,status_doc,type_return,bank_name,account_name,account_no,book_bank,bill_id,company_type,sale_chan,ref_rental)

values

('".$ref_credit."','".$ref_id."','".$date_credit."','".$customer_name."','".$customer_tel."','".$address_name."','".$return_des."','".$send_return_name."','".$date_send_return."','".$sale_name."','".$sale_date."','".$add_by."','".$add_date."','".$ttype_doc."','".$iv_no_ref."','".$sale_code."','".$status_doc."','".$type_return."','".$bank_name."','".$account_name."','".$account_no."','".$_FILES['book_bank']['name']."','".$bill_id."','".$company_type."','".$sale_chan."','".$ref_rental."')";


$qsave=mysqli_query($conn,$save);



foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$count_new=$count[$key];
		$product_price1=$unit_price[$key];
		$unit_price_new=str_replace(',','', $product_price1);
        $product_id_new =$product_id[$key];
	    $discount_unit1 =$discount_unit[$key];
		$discount_unit_new=str_replace(',','', $discount_unit1);
		$sum_amount_new = ($unit_price_new - $discount_unit_new)*$count_new;
		$sum_discount = $discount_unit_new * $count_new;

	if($product_id_new !=""){

$strSQL = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id,sum_discount)
values ('".$ref_credit."','".$count_new."','".$unit_price_new."','".$sum_amount_new."','".$discount_unit_new."','".$product_id_new."','".$sum_discount."')";

$objQuery = mysqli_query($conn,$strSQL);	}

}

}

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_credit_saleedit.php?ref_credit=$ref_credit';";
echo "</script>";
  } else {
   echo "Cannot ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่มีรายการใบสั่งลดหนี้แล้วค่ะ";
  }
	}