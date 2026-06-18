<html>

<head>
<title>Delete Product</title>
</head>
<body>
<?php
include"dbconnect.php";


$ref_id= $_GET["ref_id"];


$strSQL = "DELETE FROM hos__subproreceive ";
$strSQL .="WHERE id = '".$_GET["id"]."' ";

$objQuery = mysqli_query($conn,$strSQL);
if($objQuery)
{
  echo "<script language=\"JavaScript\">";
echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_receivepro_soedit.php?ref_id=$ref_id';";
echo "</script>";
}
else
{
echo "Error Delete [".$strSQL."]";
}
?>
</body>
</html>