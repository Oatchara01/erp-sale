<?php include ("head.php"); ?>


<?php
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$smp_date = $_GET["smp_date"];
$address_name = $_GET["address_name"];
$customer_name = $_GET["customer_name"];
$comment_sale = $_GET["comment_sale"];
$sup_name =  $_SESSION['name'];
$sale_code = $_GET['sale_code'];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');
$comment_sup = $_GET["comment_sup"];
$type_company  = $_GET["type_company"];
$ref_idsmp = $_GET['ref_idsmp'];
$comment_dm = $_GET['comment_dm'];

$save="Update  hos__smp set
smp_date = '".$smp_date."',address_name ='".$address_name."',customer_name ='".$customer_name."',comment_sale = '".$comment_sale."',sup_name = '".$sup_name."',sale_code = '".$sale_code."',comment_sup='".$comment_sup."',type_company = '".$type_company."',comment_dm = '".$comment_dm."'  where ref_idsmp = '".$ref_idsmp."'";

	
$qsave=mysqli_query($conn,$save);



$id = $_GET["subsmp_id"];
$product_id = $_GET["product_id"];
$sale_count = $_GET["sale_count"];
$product_price = $_GET["product_price"];
$sum_amount = $_GET["sum_amount"];



$strSQL21 = "SELECT * FROM hos__subsmp WHERE reff_idsmp = '".$ref_idsmp."' ";

$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){


 foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
        $product_id_new =$product_id[$key];
		
		$sum_amount_new = $product_price_new *$sale_count_new;


$strSQL1 = "Update  hos__subsmp set  reff_idsmp ='".$ref_idsmp."' ,product_id = '".$product_id_new."',product_code = '".$product_id_new."',sale_count ='".$sale_count_new."',unit_price = '".$product_price_new."',sum_amount = '".$sum_amount_new."' where subsmp_id = '".$id_new."'";

$objQuery1 = mysqli_query($conn,$strSQL1);


	}
}


	

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='dmsmp_approve.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


