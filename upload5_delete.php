<html>

<head>
<title>Delete Upload</title>
</head>
<body>
<?php
include"dbconnect.php";


$ref_id= $_GET["ref_id"];


$save=" Update  so__main set  upload5=''  where  ref_id ='".$ref_id."'";

$qsave=mysqli_query($conn,$save);

if($qsave)
{
  echo "<script language=\"JavaScript\">";
echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_admin_edit.php?ref_id=$ref_id';";
echo "</script>";
}
else
{
echo "Error Delete [".$strSQL."]";
}
?>
</body>
</html>