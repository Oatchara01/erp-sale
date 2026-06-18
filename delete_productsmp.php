<html>

<head>
<title>Delete user</title>
</head>
<body>
<?php
include"dbconnect.php";


$ref_idsmp= $_GET["ref_idsmp"];

$strSQL = "DELETE FROM hos__subsmp ";
$strSQL .="WHERE subsmp_id = '".$_GET["subsmp_id"]."' ";


$objQuery = mysqli_query($conn,$strSQL);
if($objQuery)
{
  echo "<script language=\"JavaScript\">";
echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_allwellsmp_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
}
else
{
echo "Error Delete [".$strSQL."]";
}
?>
</body>
</html>