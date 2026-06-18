<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_company = $_POST["type_company"];
$date_receive = $_POST["date_receive"];
$customer_name = $_POST["customer_name"];
$customer_address = $_POST["customer_address"];
$iv_no = $_POST["iv_no"];
$remark_st = $_POST["remark_st"];
$sale_code = $_POST["sale_code"];
$sale_name = $_POST["sale_name"];
$receive_ckk = $_POST["receive_ckk"];
$receive_name = $_POST["receive_name"];
$receive_between = $_POST["receive_between"];
$time_between = $_POST["time_between"];
$ref_id_br = $_POST["ref_id_br"];	
	
	
	
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	

$id = $_POST["id_sub"];
$sale_count = $_POST["sale_count"];
$sale_remarkk = $_POST["sale_remarkk"];
$sn = $_POST["sn"];
$product_id = $_POST["product_id"];
$clear_br = $_POST["clear_br"];

$sql1 = "select * from hos__receive order by id_auto desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
$ref_id =$fetch1['ref_id']+1;
	
	
if ($_FILES['img_re1']['size'] == 0) {
$img_re1 = "";
}else if ($_FILES['img_re1']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['img_re1']['size'] != 0) {
$temp1 = explode(".", $_FILES["img_re1"]["name"]);
$img_re1 = "img_re1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["img_re1"]["tmp_name"], "up_return/" . $img_re1);
}	

	
	
if ($_FILES['img_re2']['size'] == 0) {
$img_re2 = "";
}else if ($_FILES['img_re2']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['img_re2']['size'] != 0) {
$temp2 = explode(".", $_FILES["img_re2"]["name"]);
$img_re2 = "img_re2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["img_re2"]["tmp_name"], "up_return/" . $img_re2);
}	
	
	
if ($_FILES['img_re3']['size'] == 0) {
$img_re3 = "";
}else if ($_FILES['img_re3']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['img_re3']['size'] != 0) {
$temp3 = explode(".", $_FILES["img_re3"]["name"]);
$img_re3 = "img_re3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["img_re3"]["tmp_name"], "up_return/" . $img_re3);
}	
		
	
	
	
foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$sn_new  = $sn[$key];
		$sale_remarkk_new=$sale_remarkk[$key];
		$product_id_new =$product_id[$key];
	   $clear_br_new =$clear_br[$key];

if($clear_br_new =='1'){


$sql1 = "SELECT ref_id   FROM   hos__breg   where  iv_no = '".$iv_no."' and status_doc = 'Approve'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

$sql2 = "SELECT sum(count1) as count   FROM   hos__subbreg1   where  ref_id1 = '".$rs1['ref_id']."' and product_id1 = '".$product_id_new."'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_array($qry2);

	
$sql4 = "SELECT sum(count) as count   FROM  (hos__receive LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$iv_no."' and product_id = '".$objResult1['product_id']."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$count =  $rs4["count"]; 
		
$count2 = $rs2['count']-$count;


if($count2 < '0'){

echo "<script language=\"JavaScript\">";
echo "alert('สินค้าในใบยืมนี้มีไม่พอในการเคลียร์ยืมครั้งนี้ค่ะ');window.location='return_breg.php?ref_id=$ref_id_br';";
echo "</script>";
exit();
	
}		
	 
	}
	

}		
	
	

$save="insert into hos__receive
(type_company,date_receive,customer_name,customer_address,iv_no,remark_st,sale_code,sale_name,add_date,add_by,ref_id,receive_name,receive_ckk,receive_between,time_between,img_re1,img_re2,img_re3)
values
('".$type_company."','".$date_receive."','".$customer_name."','".$customer_address."','".$iv_no."','".$remark_st."','".$sale_code."','".$sale_name."','".$add_date."','".$add_by."','".$ref_id."','".$receive_name."','".$receive_ckk."','".$receive_between."','".$time_between."','".$img_re1."','".$img_re2."','".$img_re3."')";



$qsave=mysqli_query($conn,$save);


foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$sn_new  = $sn[$key];
		$sale_remarkk_new=$sale_remarkk[$key];
		$product_id_new =$product_id[$key];
        $clear_br_new =$clear_br[$key];

	if($clear_br_new=='1'){


$strSQL = "insert into hos__subreceive
(ref_idd,count,stock_remark,product_id,product_code,sn)
values ('".$ref_id."','".$sale_count_new."','".$sale_remarkk_new."','".$product_id_new."','".$product_id_new."','".$sn_new."')";

$objQuery = mysqli_query($conn,$strSQL);
		


	}
	}








	
 if($qsave){
		 
 echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='rister_clearbrpn_stedit.php?ref_id=$ref_id';";
echo "</script>";
		 
  } else {
   echo "Cannot";
  }
	}


