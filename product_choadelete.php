<html>

<head>
</head>
<body>
<?php
include"dbconnect.php";
include ("head.php");

$id_sub= $_GET["id_sub"];
$code = $_SESSION["type_login"]; 
$ref_id= $_GET["ref_id"];
	
$strSQL = "DELETE FROM hos__subrental ";
$strSQL .="WHERE id_sub = '".$id_sub."' and ref_idd= '".$ref_id."' ";


$objQuery = mysqli_query($conn,$strSQL);
if($objQuery)
{
	if($code == 'Sale' or $code == 'AllWell' ){
  echo "<script language=\"JavaScript\">";
echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_salerental_edit.php?ref_id=$ref_id';";
echo "</script>";
	}else if ($code == 'Sup_Sale' or $code == 'Sup_AllWell' ){

  echo "<script language=\"JavaScript\">";
  echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_suprental_edit.php?ref_id=$ref_id';";
  echo "</script>";


	}else if  ($code == 'Admin_hos'){

  echo "<script language=\"JavaScript\">";
  echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminrental_edit.php?ref_id=$ref_id';";
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