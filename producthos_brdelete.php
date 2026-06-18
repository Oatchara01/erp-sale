<html>

<head>
<title>Delete user</title>
</head>
<body>
<?php
include "dbconnect.php";


$ref_id_br= $_GET["ref_id_br"];
$code = $_GET["code"]; 
	
$strSQL = "DELETE FROM hos__subbr ";
$strSQL .="WHERE id = '".$_GET["id"]."' ";

$objQuery = mysqli_query($conn,$strSQL);
if($objQuery)
{
  if($code == "Sale"){
  echo "<script language=\"JavaScript\">";
  echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_brhos_edit.php?ref_id_br=$ref_id_br';";
  echo "</script>";
  } else if ($code == "Sup_Sale"){

  echo "<script language=\"JavaScript\">";
  echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_supbrhos_edit.php?ref_id_br=$ref_id_br';";
  echo "</script>";


  } else if  ($code == "Admin"){

  echo "<script language=\"JavaScript\">";
  echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminbrhos_edit.php?ref_id_br=$ref_id_br';";
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