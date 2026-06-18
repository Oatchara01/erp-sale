<html>

<head>
<title>Delete user</title>
</head>
<body>
<?php
include"dbconnect.php";
include ("head.php");

$code_bomsame= $_GET["code_bomsame"];
$code = $_GET["code"]; 
$ref_id= $_GET["ref_id"];
	
$strSQL = "DELETE FROM hos__subso ";
$strSQL .="WHERE code_bomsame = '".$_GET["code_bomsame"]."' and ref_idd= '".$_GET["ref_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL);

	
$strSQL21 = "SELECT *  FROM (hos__so WHERE ref_id ='".$ref_id."'";
$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$objResult21 = mysqli_fetch_array($objQuery21);
	
	
	
	
	
if($objQuery)
{
	if($code == 'Sale'){
  echo "<script language=\"JavaScript\">";
echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_salehos_edit.php?ref_id=$ref_id';";
echo "</script>";
	}else if ($code == 'Sup_Sale' or $code == 'Sup_AllWell' ){

  echo "<script language=\"JavaScript\">";
  echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_suphos_edit.php?ref_id=$ref_id';";
  echo "</script>";


	}else if  ($code == 'Admin_hos'){

  echo "<script language=\"JavaScript\">";
  echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminhos_edit.php?ref_id=$ref_id';";
  echo "</script>";

	}



}
else
{
echo "Error Delete [".$strSQL."]";
}
?>
</body>
</html>