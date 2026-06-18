<html>

<head>
<title>Delete user</title>
</head>
<body>
<?php
include"dbconnect.php";


$ref_id_br= $_GET["ref_id_br"];

$strSQL = "DELETE FROM hos__subbr ";
$strSQL .="WHERE id = '".$_GET["id"]."' ";


$objQuery = mysqli_query($conn,$strSQL);
if($objQuery)
{
  echo "<script language=\"JavaScript\">";
echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_stockbrhos_edit.php?ref_id_br=$ref_id_br';";
echo "</script>";
}
else
{
echo "Error Delete [".$strSQL."]";
}
?>
</body>
</html>