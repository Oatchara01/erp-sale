<html>

<head>
<title>Delete Product</title>
</head>
<body>
<?php
include"dbconnect.php";
include ("head.php");

$id= $_GET["id"];
$code = $_SESSION["type_login"]; 
$ref_id= $_GET["ref_id"];

$strSQL = "DELETE FROM hos__subchange ";
$strSQL .="WHERE id = '".$_GET["id"]."' ";


$objQuery = mysqli_query($conn,$strSQL);
if($objQuery)
{
	if($code == 'Sale'){
  echo "<script language=\"JavaScript\">";
echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_allwelltran_edit.php?ref_id=$ref_id';";
echo "</script>";
	}else if ($code == 'Sup_Sale' or $code == 'Sup_AllWell' ){

  echo "<script language=\"JavaScript\">";
  echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_suptran_edit.php?ref_id=$ref_id';";
  echo "</script>";


	}else if  ($code == 'AllWell'){

  echo "<script language=\"JavaScript\">";
  echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_allwell_edit.php?ref_id=$ref_id';";
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