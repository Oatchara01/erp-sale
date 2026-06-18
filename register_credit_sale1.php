<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$date_credit = $_POST["date_credit"];
$date = explode('-' , $_POST["date_credit"] );
$xdate = $date[0].'-'.$date[1];
	
$strSQL1 = "SELECT close_mount FROM  tb_closedoc WHERE close_mount = '".$xdate."' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
if($Num_Rows1 > 0){
	
echo "<script language=\"JavaScript\">";
echo "alert('ไม่สามารถบันทึกข้อมูลใบลดหนี้ในเดือนนี้ได้เนื่องจากได้ทำการปิดเอกสารเรียบร้อยแล้วค่ะ');window.location='register_credit_sale.php';";
echo "</script>";
	
}else{
	
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
$mode_cus = $_POST["mode_name"];	

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
	
	
	
if ($_FILES['book_bank']['size'] == 0) {
$book_bank = "";
}else if ($_FILES['book_bank']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['book_bank']['size'] != 0) {
$temp1 = explode(".", $_FILES["book_bank"]["name"]);
$book_bank = "book_bank" . "_" . $ref_credit . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["book_bank"]["tmp_name"], "credit_no/" . $book_bank);
}	
	
//move_uploaded_file($_FILES['book_bank']['tmp_name'],"credit_no/".iconv("UTF-8", "TIS-620",$_FILES['book_bank']['name']));
	
	


$save="insert into tb_credit_note
(ref_credit,date_credit,customer_name,customer_tel,address_name,return_des,send_return_name,date_send_return,sale_name,sale_date,add_by,add_date,ttype_doc,iv_no_ref,sale_code,status_doc,company_type,type_return,bank_name,account_name,account_no,book_bank,mode_cus)

values

('".$ref_credit."','".$date_credit."','".$customer_name."','".$customer_tel."','".$address_name."','".$return_des."','".$send_return_name."','".$date_send_return."','".$sale_name."','".$sale_date."','".$add_by."','".$add_date."','".$ttype_doc."','".$iv_no_ref."','".$sale_code."','".$status_doc."','".$company_type."','".$type_return."','".$bank_name."','".$account_name."','".$account_no."','".$book_bank."','".$mode_cus."')";

$qsave=mysqli_query($conn,$save);



$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$discount_unit1 = $_POST["discount_unit1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_discount1 = $sale_count1 * $discount_unit1;
$sum_amount1= str_replace(',','', $sum_amountt);


$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sum_amountt2 = $_POST["sum_amount2"];
$discount_unit2 = $_POST["discount_unit2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$discount_unit2 = $_POST["discount_unit2"];
$sum_discount2 = $sale_count2 * $discount_unit2;	


$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sum_amountt3 = $_POST["sum_amount3"];
$discount_unit3 = $_POST["discount_unit3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$discount_unit3 = $_POST["discount_unit3"];
$sum_discount3 = $sale_count3 * $discount_unit3;

$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sum_amountt4 = $_POST["sum_amount4"];
$discount_unit4 = $_POST["discount_unit4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$discount_unit4 = $_POST["discount_unit4"];
$sum_discount4 = $sale_count4 * $discount_unit4;	



$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sum_amountt5 = $_POST["sum_amount5"];
$discount_unit5 = $_POST["discount_unit5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$discount_unit5 = $_POST["discount_unit5"];
$sum_discount5 = $sale_count5 * $discount_unit5;	


$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sum_amountt6 = $_POST["sum_amount6"];
$discount_unit6 = $_POST["discount_unit6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$discount_unit6 = $_POST["discount_unit6"];
$sum_discount6 = $sale_count6 * $discount_unit6;


$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sum_amountt7 = $_POST["sum_amount7"];
$discount_unit7 = $_POST["discount_unit7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$discount_unit7 = $_POST["discount_unit7"];
$sum_discount7 = $sale_count7 * $discount_unit7;


$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sum_amountt8 = $_POST["sum_amount8"];
$discount_unit8 = $_POST["discount_unit8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$discount_unit8 = $_POST["discount_unit8"];
$sum_discount8 = $sale_count8 * $discount_unit8;
$sum_discount8 = $sale_count8 * $discount_unit8;

$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sum_amountt9 = $_POST["sum_amount9"];
$discount_unit9 = $_POST["discount_unit9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$discount_unit9 = $_POST["discount_unit9"];
$sum_discount9 = $sale_count9 * $discount_unit9;

$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$discount_unit10 = $_POST["discount_unit10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$discount_unit10 = $_POST["discount_unit10"];
$sum_discount10 = $sale_count10 * $discount_unit10;

	
if($product_id1 !==''  ){

$strSQL1 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id,sum_discount)
values ('".$ref_credit."','".$sale_count1."','".$product_price1."','".$sum_amount1."','".$discount_unit1."','".$product_id1."','".$sum_discount1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);

}

if($product_id2 !==''  ){

$strSQL2 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id,sum_discount)
values ('".$ref_credit."','".$sale_count2."','".$product_price2."','".$sum_amount2."','".$discount_unit2."','".$product_id2."','".$sum_discount2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);

}


if($product_id3 !==''  ){

$strSQL3 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id,sum_discount)
values ('".$ref_credit."','".$sale_count3."','".$product_price3."','".$sum_amount3."','".$discount_unit3."','".$product_id3."','".$sum_discount3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);

}


if($product_id4 !==''  ){

$strSQL4 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id,sum_discount)
values ('".$ref_credit."','".$sale_count4."','".$product_price4."','".$sum_amount4."','".$discount_unit4."','".$product_id4."','".$sum_discount4."')";

$objQuery4 = mysqli_query($conn,$strSQL4);

}


if($product_id5 !==''  ){

$strSQL5 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id,sum_discount)
values ('".$ref_credit."','".$sale_count5."','".$product_price5."','".$sum_amount5."','".$discount_unit5."','".$product_id5."','".$sum_discount5."')";

$objQuery5 = mysqli_query($conn,$strSQL5);

}


if($product_id6 !==''  ){

$strSQL6 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id,sum_discount)
values ('".$ref_credit."','".$sale_count6."','".$product_price6."','".$sum_amount6."','".$discount_unit6."','".$product_id6."','".$sum_discount6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);

}


if($product_id7 !==''  ){

$strSQL7 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id,sum_discount)
values ('".$ref_credit."','".$sale_count7."','".$product_price7."','".$sum_amount7."','".$discount_unit7."','".$product_id7."','".$sum_discount7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);

}


if($product_id8!==''  ){

$strSQL8 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id,sum_discount)
values ('".$ref_credit."','".$sale_count8."','".$product_price8."','".$sum_amount8."','".$discount_unit8."','".$product_id8."','".$sum_discount8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);

}


if($product_id9 !==''  ){

$strSQL9 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id,sum_discount)
values ('".$ref_credit."','".$sale_count9."','".$product_price9."','".$sum_amount9."','".$discount_unit9."','".$product_id9."','".$sum_discount9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);

}


if($product_id10 !==''  ){

$strSQL10 = "insert into tb_subcredit
(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id,sum_discount)
values ('".$ref_credit."','".$sale_count10."','".$product_price10."','".$sum_amount10."','".$discount_unit10."','".$product_id10."','".$sum_discount10."')";

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
	}