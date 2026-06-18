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
$stock_remark =  $_POST['stock_remark'];
$date_disburse =  $_POST['date_disburse'];


$id = $_POST["id"];
$sn_number = $_POST["sn"];
$product_id = $_POST["product_id"];
$code_same  = $_POST["product_code_same"];
	
$save="Update  hos__so set stock ='".$stock."',stock_date ='".$stock_date."',stock_code = '".$stock_code."',date_disburse = '".$date_disburse."'  where ref_id='".$ref_id."'";

//echo $save;
$qsave=mysqli_query($conn,$save);


$strSQL21 = "SELECT * FROM hos__subso WHERE ref_idd = '".$ref_id."' ";
//echo $strSQL21;
//exit();
$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){

  foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sn_number_new=$sn_number[$key];
		$product_id_new =$product_id[$key];
        $code_same_new =$code_same[$key];
        $stock_remark_new =$stock_remark[$key];
	  
$strSQL = "Update   hos__subso set sn='$sn_number_new',code_same='$code_same_new',stock_remark = '$stock_remark_new'  Where id= '$id_new' ";

//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL);
}
	
}





//exit();


	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_stockhos.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


