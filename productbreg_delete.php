<html>

<head>
</head>
<body>
<?php
include"head.php";
include"dbconnect.php";


$ref_id= $_GET["ref_id"];
$id_sub = $_GET["id_sub"];

$strSQL = "DELETE FROM hos__subbreg1 ";
$strSQL .="WHERE id_sub1  = '".$id_sub."' and ref_id1 ='".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL);
if($objQuery)
{
  echo "<script language=\"JavaScript\">";
echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_breg_edit.php?ref_id=$ref_id';";
echo "</script>";
}
else
{
echo "Error Delete [".$strSQL."]";
}
?>
</body>
</html>