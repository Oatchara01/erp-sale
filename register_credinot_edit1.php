<?php 
include ("head.php"); 

include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {
	
$bill_id = $_POST["bill_id"];
$date_credit = $_POST["date_credit"];
$ref_id = $_POST["ref_id"];
$customer_name = $_POST["customer_name"];
$customer_tel = $_POST["customer_tel"];
$address_name = $_POST["address_name"];
$return_des = $_POST["return_des"];
$send_return_name = $_POST["send_return_name"];
$date_send_return = $_POST["date_send_return"];
$receive_name = $_POST["receive_name"];
$date_receive = $_POST["date_receive"];
$sale_name = $_POST["sale_name"];
$sale_date = $_POST["sale_date"];
$credit_ckk = $_POST["credit_ckk"];
$credit_no = $_POST["credit_no"];
$type_return_ckk = $_POST["type_return_ckk"];
$type_return_no = $_POST["type_return_no"];
$dis_credit = $_POST["dis_credit"];
$name =  $_SESSION['name'];
$surname =  $_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
$ttype_doc = $_POST["ttype_doc"];
$iv_no_ref = $_POST["iv_no_ref"];
$account_no =  $_POST["account_no"];
$account_name =  $_POST["account_name"];
$bank_name =  $_POST["bank_name"];
$type_return = $_POST["type_return"];
$remark_et = $_POST["remark_et"];	
	
	
if($_FILES['book_bank']['name']!=''){
 move_uploaded_file($_FILES['book_bank']['tmp_name'],"credit_no/".iconv("UTF-8", "TIS-620",$_FILES['upload1']['name']));
 $book_bank=$_FILES['book_bank']['name'];
}else{
 $book_bank = $_POST["book_bank"];

}	

	
$id = $_POST["id"];
$count = $_POST["count"];
$unit_price = $_POST["unit_price"];
$sum_amount = $_POST["sum_amount"];
$discount_unit = $_POST["discount_unit"];
$product_id = $_POST["product_id"];

$ref_credit = trim($_POST["ref_credit"]);
$status_doc =  $_POST["status_doc"];
$des_doc =  $_POST["des_doc"];
$ref_order_id  =  $_POST["ref_order_id"];
$company_type =  $_POST["company_type"];
$send_receipt = $_POST["send_receipt"];	
	
	
$save="Update tb_credit_note set date_credit='".$date_credit."',customer_name='".$customer_name."',customer_tel='".$customer_tel."',address_name='".$address_name."',return_des='".$return_des."',send_return_name='".$send_return_name."',date_send_return='".$date_send_return."',receive_name='".$receive_name."',date_receive='".$date_receive."',sale_name='".$sale_name."',sale_date='".$sale_date."',credit_ckk='".$credit_ckk."',credit_no='".$credit_no."',type_return_ckk='".$type_return_ckk."',type_return_no='".$type_return_no."',dis_credit='".$dis_credit."',ttype_doc = '".$ttype_doc."',iv_no_ref = '".$iv_no_ref."',des_doc='".$des_doc."',ref_order_id='".$ref_order_id."',company_type = '".$company_type."',type_return='".$type_return."',bank_name='".$bank_name."',account_name='".$account_name."',account_no='".$account_no."',book_bank='".$book_bank."',bill_id='".$bill_id."',remark_et='".$remark_et."'  where ref_credit = '".$ref_credit."'";


$qsave=mysqli_query($conn,$save);

if($status_doc !=''){
$save1="Update tb_credit_note set status_doc='".$status_doc."'  where ref_credit = '".$ref_credit."'";
$qsave1=mysqli_query($conn,$save1);
}
	
if($credit_no !='' and $ref_id !=''){
$refref = substr($ref_id,0,2);	

if($refref=='SO'){

$save1="Update hos__so set sr_no='".$credit_no."'  where ref_id = '".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);	
	
}else{
	
$save1="Update so__main set sr_no='".$credit_no."'  where ref_id = '".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);	
	
	
}
	
	
}
	
	

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

$strSQL = "Update tb_subcredit set
ref_creditt='".$ref_credit."',count='".$count_new."',unit_price='".$unit_price_new."',sum_amount='".$sum_amount_new."',discount_unit='".$discount_unit_new."',product_id='".$product_id_new."',sum_discount = '".$sum_discount."' where  id ='".$id_new."'";
		
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
	
	
	
$strSQL219 = "SELECT * FROM tb_credit_note WHERE ref_credit = '".$ref_credit."' ";
$objQuery219 = mysqli_query($conn,$strSQL219) or die ("Error Query [".$strSQL219."]");
$rs1 = mysqli_fetch_assoc($objQuery219);

$date_inv = $rs1["date_credit"];	
$iv_no = $rs1["credit_no"];	
$com = $rs1["company_type"];
$bill_name = $rs1["customer_name"];	
$bill_id = $rs1["bill_id"];	
$iv_no_ref = $rs1["iv_no_ref"];	
$ref_id = $rs1["ref_id"];	
$ref_order_id = $rs1["ref_order_id"];	
$sale_code = $rs1["sale_code"];		
	
	
	
	
if($send_receipt=='1'){
		
$strSQL29 = "SELECT SUM(sum_amount) AS unit_cash FROM tb_subcredit WHERE ref_creditt = '".$ref_credit."' ";
$objQuery29 = mysqli_query($conn,$strSQL29) or die ("Error Query [".$strSQL29."]");
$rs = mysqli_fetch_assoc($objQuery29);

$unit_cash = $rs["unit_cash"];


$strSQL292="insert into tb_credit_not (ref_id,credit_no,date_cdnote,type_doc,customer_name,add_by,add_date,bill_id,ref_idsale,ref_ivsale,ref_order_id,sale_code,amount) values ('".$ref_credit."','".$iv_no."','".$date_inv."','".$com."','".$bill_name."','".$add_by."','".$add_date."','".$bill_id."','".$ref_id."','".$iv_no_ref."','".$ref_order_id."','".$sale_code."','".$unit_cash."')";

$objQuery292 = mysqli_query($code,$strSQL292);	
			

$strSQL262="Update  tb_credit_note set send_receipt ='2'  where ref_credit = '".$ref_credit."'";
$objQuery262 = mysqli_query($conn,$strSQL262);		

	}
	

if($send_receipt=='2'){
		
$strSQL29 = "SELECT SUM(sum_amount) AS unit_cash FROM tb_subcredit WHERE ref_creditt = '".$ref_credit."' ";
$objQuery29 = mysqli_query($conn,$strSQL29) or die ("Error Query [".$strSQL29."]");
$rs = mysqli_fetch_assoc($objQuery29);

$unit_cash = $rs["unit_cash"];

	

$strSQL293="Update  tb_credit_not SET credit_no='".$iv_no."',date_cdnote='".$date_inv."',type_doc='".$com."',customer_name='".$bill_name."',bill_id='".$bill_id."',ref_idsale='".$ref_id."',ref_ivsale='".$iv_no_ref."',sale_channel='".$iv_no_ref."',ref_order_id='".$ref_order_id."',sale_code='".$sale_code."',amount='".$unit_cash."' where ref_id = '".$ref_credit."' and summary_all !='สมบูรณ์'";
$objQuery293 = mysqli_query($code,$strSQL293);	
			
			
				

	}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
if($type_return=='1' or $type_return=='2'){
	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "PIw84qamheB4FL7tWznDtO7AiriT6CAmd8ipSdYxG8G";
$sMessage = "หมายเลขอ้างอิง $ref_credit มีการชำระเงินคืนลูกค้า";
$chOne = curl_init();
curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt( $chOne, CURLOPT_POST, 1);
curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage);
$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec( $chOne );
if(curl_error($chOne))
{
echo 'error:' . curl_error($chOne);
}
else {
$result_ = json_decode($result, true);
echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne );	
	
}


	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_credinot_edit.php?ref_credit=$ref_credit';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}