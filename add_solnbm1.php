
<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$sale_channel = $_GET["sale_channel"];
$today  = date('Y-m-d');

$sql1 = "SELECT doc_no FROM tb_solnbm where sale_channel = '".$sale_channel."' and date_sol = '".$today."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($qry1);
$rs1 = mysqli_fetch_assoc($qry1);	
$num = $rs1["doc_no"];
	
if($Num_Rows>0){
	
	   echo "<script language=\"JavaScript\">";
echo "alert('วันนี้มีการเพิ่ม $num ช่องทางการขายนี้ของวันนี้แล้วค่ะ');window.location='add_solnbm.php'";
echo "</script>";

}else{
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(doc_no) AS MAXID FROM tb_solnbm";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -3);
$maxId3 = substr($rs['MAXID'],-7);

$maxId1 = substr($maxId3,0,-3);
$so = "SOL/";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "001"; 
$nextId = $yearMonth.$maxId1;

}

$doc_no = $so.$nextId;
	

$save="insert into tb_solnbm (doc_no,date_sol,sale_channel ) values ('".$doc_no."','".$today."','".$sale_channel ."')";
$qsave=mysqli_query($conn,$save);




 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_solnbm.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
}
?>