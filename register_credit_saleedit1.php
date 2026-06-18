<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$date_credit = $_POST["date_credit"];
	$bill_id = $_POST["bill_id"];
$customer_name = $_POST["customer_name"];
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
$company_type =  $_POST["company_type"];
$account_no =  $_POST["account_no"];
$account_name =  $_POST["account_name"];
$bank_name =  $_POST["bank_name"];
$type_return = $_POST["type_return"];
$ref_order_id = $_POST["ref_order_id"];
$ref_rental = $_POST["ref_rental"];	
$ref_credit = trim($_POST["ref_credit"]);
	
	
if ($_FILES['book_bank']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if($_FILES['book_bank']['name']!=''){
 $temp1 = explode(".", $_FILES["book_bank"]["name"]);
$book_bank = "book_bank" . "_" . $ref_credit . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["book_bank"]["tmp_name"], "credit_no/" . $book_bank);
}else{
 $book_bank = $_POST["book_bank"];

}
	

$id = $_POST["id"];
$count = $_POST["count"];
$unit_price = $_POST["unit_price"];
$sum_amount = $_POST["sum_amount"];
$discount_unit = $_POST["discount_unit"];
$product_id = $_POST["product_id"];







$save="Update tb_credit_note set 
date_credit ='".$date_credit."' ,bill_id='".$bill_id."',customer_name ='".$customer_name."' ,customer_tel ='".$customer_tel."',address_name = '".$address_name."',return_des ='".$return_des."',send_return_name ='".$send_return_name."',date_send_return ='".$date_send_return."',sale_name = '".$sale_name."',sale_date ='".$sale_date."' ,ttype_doc ='".$ttype_doc."',iv_no_ref ='".$iv_no_ref."',sale_code = '".$sale_code."',company_type = '".$company_type."',type_return='".$type_return."',bank_name='".$bank_name."',account_name='".$account_name."',account_no = '".$account_no."',ref_order_id='".$ref_order_id."',book_bank='".$book_bank."',ref_rental='".$ref_rental."'  where ref_credit = '".$ref_credit."'";

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
		 //echo $product_id_new;

	if($product_id_new !=""){

$strSQL = "Update tb_subcredit set
ref_creditt='".$ref_credit."',count='".$count_new."',unit_price='".$unit_price_new."',sum_amount='".$sum_amount_new."',discount_unit='".$discount_unit_new."',product_id='".$product_id_new."',sum_discount = '".$sum_discount."' where  id ='".$id_new."'";

//echo $strSQL;
//exit();
$objQuery = mysqli_query($conn,$strSQL);
	}

}


$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$discount_unit6 = $_POST["discount_unit6"];



$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$discount_unit7 = $_POST["discount_unit7"];



$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$discount_unit8 = $_POST["discount_unit8"];



$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$discount_unit9 = $_POST["discount_unit9"];


$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$discount_unit10 = $_POST["discount_unit10"];




if($product_id6 !==''  ){

$strSQL6 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id)
values ('".$ref_credit."','".$sale_count6."','".$product_price6."','".$sum_amount6."','".$discount_unit6."','".$product_id6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);

}


if($product_id7 !==''  ){

$strSQL7 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id)
values ('".$ref_credit."','".$sale_count7."','".$product_price7."','".$sum_amount7."','".$discount_unit7."','".$product_id7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);

}


if($product_id8!==''  ){

$strSQL8 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id)
values ('".$ref_credit."','".$sale_count8."','".$product_price8."','".$sum_amount8."','".$discount_unit8."','".$product_id8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);

}


if($product_id9 !==''  ){

$strSQL9 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id)
values ('".$ref_credit."','".$sale_count9."','".$product_price9."','".$sum_amount9."','".$discount_unit9."','".$product_id9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);

}


if($product_id10 !==''  ){

$strSQL10 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id)
values ('".$ref_credit."','".$sale_count10."','".$product_price10."','".$sum_amount10."','".$discount_unit10."','".$product_id10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);

}


	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_credit_saleedit.php?ref_credit=$ref_credit';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}