<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id_br = trim($_POST["ref_id_br"]);

$stock_date= date('Y-m-d');
$stock =  $_SESSION['name'];
$stock_code =  $_SESSION['code'];




$id = $_POST["id"];
$sn_number = $_POST["sn"];
$stock_remark = $_POST["stock_remark"];
$code_same = $_POST["product_code_same"];
$date_disburse = $_POST["date_disburse"];

$save="Update  hos__br set stock ='".$stock."',stock_date ='".$stock_date."',stock_code = '".$stock_code."',date_disburse = '".$date_disburse."'  where ref_id_br ='".$ref_id_br."'";

//echo $save;
$qsave=mysqli_query($conn,$save);


$strSQL21 = "SELECT * FROM hos__subbr WHERE ref_idd_br = '".$ref_id_br."' ";
//echo $strSQL21;
//exit();
$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){

  foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sn_number_new=$sn_number[$key];
		$stock_remark_new =$stock_remark[$key];
        $code_same_new  =$code_same[$key];

$strSQL = "Update   hos__subbr set sn='$sn_number_new',stock_remark='$stock_remark_new',code_same='$code_same_new'  Where id= '$id_new' ";

//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL);
}
	
}



	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_stockbrhos.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


