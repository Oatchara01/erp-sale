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




$id = $_POST["id"];
$sn_number = $_POST["sn_number"];
$stock_remark = $_POST["stock_remark"];
$code_same = $_POST["product_code_same"];
$sale_count_same = $_POST["sale_count_same"];
$date_disburse = $_POST["date_disburse"];

$save="Update  hos__change set stock ='".$stock."',stock_date ='".$stock_date."',stock_code = '".$stock_code."',date_disburse = '".$date_disburse."'  where ref_id ='".$ref_id."'";

//echo $save;
$qsave=mysqli_query($conn,$save);


$strSQL21 = "SELECT * FROM hos__subchange  WHERE ref_idd = '".$ref_id."' ";
$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){

  foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sn_number_new=$sn_number[$key];
		$stock_remark_new =$stock_remark[$key];
        $code_same_new  =$code_same[$key];
		$count_same = $sale_count_same[$key];

$strSQL = "Update   hos__subchange set sn='".$sn_number_new."',stock_remark='".$stock_remark_new."',code_same='".$code_same_new."',count_same = '".$count_same."'  Where id= '".$id_new."' ";

//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL);
}
	
}



	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_stockchanghos.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


