<html>

<head>
<title>Delete Product</title>
</head>
<body>
<?php
include"dbconnect.php";


$ref_credit= $_GET["ref_credit"];
$code = $_GET["code"]; 

$strSQL = "DELETE FROM tb_subcredit ";
$strSQL .="WHERE id = '".$_GET["id"]."' ";

$objQuery = mysqli_query($conn,$strSQL);
if($objQuery)
{
	
  	if($code == 'Sale'){
  echo "<script language=\"JavaScript\">";
echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_credit_saleedit.php?ref_credit=$ref_credit';";
echo "</script>";
	}else if ($code == 'Sup_Sale' or $code == 'Sup_AllWell' ){

 echo "<script language=\"JavaScript\">";
echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_credit_supedit.php?ref_credit=$ref_credit';";
echo "</script>";

	}else if  ($code == 'Admin_hos'){

  echo "<script language=\"JavaScript\">";
echo "alert('ลบข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_credinot_edit.php?ref_credit=$ref_credit';";
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