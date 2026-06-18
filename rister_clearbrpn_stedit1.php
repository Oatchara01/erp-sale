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
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$receive_ckk = $_POST["receive_ckk"];
$receive_name = $_POST["receive_name"];	
$receive_between = $_POST["receive_between"];
$time_between = $_POST["time_between"];
$order_id = $_POST["order_id"];	
$type_remark = $_POST["type_remark"];
$remark_st = $_POST["remark_st"];


$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$sale_remarkk = $_POST["sale_remarkk"];
$sn = $_POST["sn"];
$product_id = $_POST["product_id"];
$ref_id = $_POST["ref_id"];
	
	
	
if ($_FILES['img_re1']['size'] != 0) {
$temp1 = explode(".", $_FILES["img_re1"]["name"]);
$img_re1 = "img_re1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["img_re1"]["tmp_name"], "up_return/" . $img_re1);
}else{
$img_re1 = $_POST["h_img_re1"];
}

	
	
if ($_FILES['img_re2']['size'] != 0) {
$temp2 = explode(".", $_FILES["img_re2"]["name"]);
$img_re2 = "img_re2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["img_re2"]["tmp_name"], "up_return/" . $img_re2);
}else{
$img_re2 = $_POST["h_img_re2"];
}	
	
	
if ($_FILES['img_re3']['size'] != 0) {
$temp3 = explode(".", $_FILES["img_re3"]["name"]);
$img_re3 = "img_re3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["img_re3"]["tmp_name"], "up_return/" . $img_re3);
}else{
$img_re3 = $_POST["h_img_re3"];
}	
	
		
		
	
	



$save="Update hos__receive Set type_company = '".$type_company."',date_receive = '".$date_receive."',customer_name = '".$customer_name."',customer_address = '".$customer_address."',iv_no = '".$iv_no."',remark_st = '".$remark_st."',sale_code = '".$sale_code."',sale_name = '".$sale_name."',receive_ckk='".$receive_ckk."',receive_name='".$receive_name."',receive_between='".$receive_between."',time_between='".$time_between."',order_id='".$order_id."',remark_st='".$remark_st."',type_remark='".$type_remark."',img_re1 ='".$img_re1."',img_re2 ='".$img_re2."',img_re3 ='".$img_re3."'     where ref_id = '".$ref_id."'";
$qsave=mysqli_query($conn,$save);

	
	

foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$sn_new  = $sn[$key];
		$sale_remarkk_new=$sale_remarkk[$key];
		$product_id_new =$product_id[$key];
        


	if($product_id_new!=''){


$strSQL = "Update hos__subreceive Set
ref_idd = '".$ref_id."',count ='".$sale_count_new."' ,stock_remark = '".$sale_remarkk_new."',product_id = '".$product_id_new."',product_code = '".$product_id_new."',sn = '".$sn_new."' where id = '".$id_new."'";

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


