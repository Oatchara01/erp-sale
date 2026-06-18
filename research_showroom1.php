<?php include ("head.php"); 
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_research_showroom";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -3);
$maxId3 = substr($rs['MAXID'],-7);

$maxId1 = substr($maxId3,0,-3);
$so = "CT";

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

$ref_id ="$so$nextId";


$date_research = $_POST["date_research"];
$customer_name = $_POST["customer_name"];
$province = $_POST["province"];
$tel = $_POST["tel"];
$remark = $_POST["remark"];
$email = $_POST["email"];
$product_code = $_POST["product_code"];
$price = $_POST["price"];
$des_ckk1 = $_POST["des_ckk1"];
$des_ckk2 = $_POST["des_ckk2"];
$des_ckk2_re = $_POST["des_ckk2_re"];
$research_ckk = $_POST["research_ckk"];
$reseach_des = $_POST["reseach_des"];
$add_date = date('Y-m-d H:i:s');


$save="insert into tb_research_showroom
(ref_id,date_research,customer_name,province,tel,email,product_code,price,des_ckk1,des_ckk2,des_ckk2_re,research_ckk,reseach_des,add_date,remark)
values
('".$ref_id."','".$date_research."','".$customer_name."','".$province."','".$tel."','".$email."','".$product_code."','".$price."','".$des_ckk1."','".$des_ckk2."','".$des_ckk2_re."','".$research_ckk."','".$reseach_des."','".$add_date."','".$remark."')";

$qsave=mysqli_query($conn,$save);

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='research_showroom_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}

	?>