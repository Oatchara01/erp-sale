<html>

<head>
<title>Delete user</title>
</head>
<body>
<?php
include"dbconnect.php";


$subsmp_id= $_GET["id_submain"];
$code = $_GET["code"]; 
	$ref_idsmp = $_GET["ref_idsmp"]; 
$strSQL = "DELETE FROM hos__subsmp ";
$strSQL .="WHERE subsmp_id = '".$_GET["subsmp_id"]."' ";

$objQuery = mysqli_query($conn,$strSQL);
if($objQuery)
{
	if($code == "Sale"){
  echo "<script language=\"JavaScript\">";
echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_salesmp_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
	}else if ($code == "Sup_Sale"){

  echo "<script language=\"JavaScript\">";
  echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_supsmp_edit.php?ref_idsmp=$ref_idsmp';";
  echo "</script>";


	}else if  ($code == "Admin"){

  echo "<script language=\"JavaScript\">";
  echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminsmp1_edit.php?ref_idsmp=$ref_idsmp';";
  echo "</script>";

	
	}else if  ($code == "It"){

  echo "<script language=\"JavaScript\">";
  echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_cmsmp_edit.php?ref_idsmp=$ref_idsmp';";
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