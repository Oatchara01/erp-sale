<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = trim($_POST["ref_id"]);

$stock_date= date('Y-m-d');
$stock =  $_SESSION['name'];
$stock_code =  $_SESSION['code'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$name =	$_SESSION['name'];
$add_by = "$name $surname";



$id = $_POST["id"];
$sn_number = $_POST["sn_number"];
$have_product = $_POST["have_product"];
$product_id = $_POST["product_id"];
$code_same  = $_POST["code_same"];
	
$save="Update  hos__so set have_product = '".$have_product."'  where ref_id='".$ref_id."'";

$qsave=mysqli_query($conn,$save);


$strSQL21 = "SELECT * FROM hos__subso WHERE ref_idd = '".$ref_id."' ";

$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){

  foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sn_number_new=$sn_number[$key];
		$product_id_new =$product_id[$key];
        $code_same_new =$code_same[$key];

$strSQL = "Update   hos__subso set product_id='$product_id_new',product_code='$product_id_new'  Where id= '$id_new' ";

//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL);
}
	
}

if($have_product=='1'){

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "KLadYmSxQFDtfywN5HqZHCipQ2cSX6aBd6JVtZf063h";
$sMessage = "หมายเลขอ้างอิง $ref_id มีสินค้าครับ";
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


$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];
$sum_amountt1 = $_POST["sum_amount1"];
$sum_amount1 = str_replace(',','', $sum_amountt1);
$discount_unit1 = $_POST["discount_unit1"];
$warranty1  = $_POST["warranty1"];
$cal1 = $_POST["cal1"];
$pm1 = $_POST["pm1"];


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


if($product_id1 !==''  ){

$strSQL11 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,stock_ckk,add_by,add_date)
values ('".$ref_id."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_id1."','".$product_id1."','1','".$add_by."','".$add_date."')";

$objQuery11 = mysqli_query($conn,$strSQL11);
	
	$strSQL110 = "insert into hos__subso_ref
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,stock_ckk,add_by,add_date,date_edit)
values ('".$ref_id."','".$sale_count1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_id1."','".$product_id1."','1','".$add_by."','".$add_date."','".$stock_date."')";

$objQuery110 = mysqli_query($conn,$strSQL110);

}

if($product_id2 !==''  ){

$strSQL12 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,stock_ckk,add_by,add_date)
values ('".$ref_id."','".$sale_count2."','".$sale_count2."','".$product_price2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$product_id2."','".$product_id2."','1','".$add_by."','".$add_date."')";

$objQuery12 = mysqli_query($conn,$strSQL12);
	
	$strSQL120 = "insert into hos__subso_ref
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,stock_ckk,add_by,add_date,date_edit)
values ('".$ref_id."','".$sale_count2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$product_id2."','".$product_id2."','1','".$add_by."','".$add_date."','".$stock_date."')";

$objQuery120 = mysqli_query($conn,$strSQL120);

}

if($product_id3 !==''  ){

$strSQL13 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,stock_ckk,add_by,add_date)
values ('".$ref_id."','".$sale_count3."','".$sale_count3."','".$product_price3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$product_id3."','".$product_id3."','1','".$add_by."','".$add_date."')";

$objQuery13 = mysqli_query($conn,$strSQL13);
	
$strSQL130 = "insert into hos__subso_ref
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,stock_ckk,add_by,add_date,date_edit)
values ('".$ref_id."','".$sale_count3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$product_id3."','".$product_id3."','1','".$add_by."','".$add_date."','".$stock_date."')";

$objQuery130 = mysqli_query($conn,$strSQL130);

}

if($product_id4 !==''  ){

$strSQL14 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,stock_ckk,add_by,add_date)
values ('".$ref_id."','".$sale_count4."','".$sale_count4."','".$product_price4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$product_id4."','".$product_id4."','1','".$add_by."','".$add_date."')";

$objQuery14 = mysqli_query($conn,$strSQL14);
	
	
$strSQL140 = "insert into hos__subso_ref
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,stock_ckk,add_by,add_date,date_edit)
values ('".$ref_id."','".$sale_count4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$product_id4."','".$product_id4."','1','".$add_by."','".$add_date."','".$stock_date."')";

$objQuery140 = mysqli_query($conn,$strSQL140);


}

if($product_id5 !==''  ){

$strSQL15 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,stock_ckk,add_by,add_date)
values ('".$ref_id."','".$sale_count5."','".$sale_count5."','".$product_price5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$product_id5."','".$product_id5."','1','".$add_by."','".$add_date."')";

$objQuery15 = mysqli_query($conn,$strSQL15);

	
$strSQL150 = "insert into hos__subso_ref
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,stock_ckk,add_by,add_date,date_edit)
values ('".$ref_id."','".$sale_count5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$product_id5."','".$product_id5."','1','".$add_by."','".$add_date."','".$stock_date."')";

$objQuery150 = mysqli_query($conn,$strSQL150);

}


	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_stockhos.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


?>