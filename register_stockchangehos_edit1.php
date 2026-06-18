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
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";




$id = $_POST["id"];
$count_stock = $_POST["count_stock"];
$sale_remarkk = $_POST["sale_remarkk"];
$count_sale  = $_POST["count_sale"];



$strSQL21 = "SELECT * FROM hos__subchange WHERE ref_idd = '".$ref_id."' ";
//echo $strSQL21;
//exit();
$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){

  foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$count_stock_new=$count_stock[$key];
		$sale_remarkk_new =$sale_remarkk[$key];
        $count_sale_new  =$count_sale[$key];

$strSQL = "Update   hos__subchange set count_stock = '$count_stock_new',count_sale = '$count_sale_new',sale_remark='$sale_remarkk_new'  Where id= '$id_new' ";

//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL);
}
	
}



$product_id1 = $_POST["product_id1"];
$count_stock1 = $_POST["count_stock1"];
$count_sale1 = $_POST["count_sale1"];
$product_price1 = $_POST["product_price1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);




if($product_id1 !==''  ){

$strSQL1 = "insert into hos__subchange
(ref_idd,count_stock,count_sale,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id."','".$count_stock1."','".$count_sale1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$product_id1."','".$product_id1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
	
}



	
 if($objQuery){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_stockchangehos_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


