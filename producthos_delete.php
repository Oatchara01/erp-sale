<html>

<head>
<title>Delete Product</title>
</head>
<body>
<?php
include"dbconnect.php";
include ("head.php");

$id= $_GET["id"];
$code = $_GET["code"]; 
$ref_id= $_GET["ref_id"];
$ckk = $_GET["ckk"];	

$strSQL = "DELETE FROM hos__subso ";
$strSQL .="WHERE id = '".$_GET["id"]."' ";


$objQuery = mysqli_query($conn,$strSQL);
if($objQuery)
{
	if($code == 'Sale'){
		
echo "<script language=\"JavaScript\">";
echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_salehos_edit.php?ref_id=$ref_id';";
echo "</script>";
		
	}else if ($code == 'Sup_Sale' or $code == 'Sup_AllWell' ){
		
		
if($ckk=='1'){
  echo "<script language=\"JavaScript\">";
  echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_suphosfak_edit.php?ref_id=$ref_id';";
  echo "</script>";
	
	
}else{
  echo "<script language=\"JavaScript\">";
  echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_suphos_edit.php?ref_id=$ref_id';";
  echo "</script>";
}

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