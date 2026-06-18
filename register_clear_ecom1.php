<?php include ("head.php"); ?>


<?php
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_company = $_POST["type_company"];
$date_receive = $_POST["date_receive"];
$customer_name = $_POST["customer_name"];
$customer_address = $_POST["customer_address"];
$iv_no = $_POST["iv_no"];
$ref_sale = $_POST["ref_sale"];
$remark_st = $_POST["remark_st"];
$sale_code = $_POST["sale_code"];
$sale_name = $_POST["sale_name"];
$channel = $_POST["channel"];
$type_remark = $_POST["type_remark"];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	

$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$sale_remarkk = $_POST["sale_remarkk"];
$sn = $_POST["sn"];
$product_id = $_POST["product_id"];
$receive_ckk = $_POST["receive_ckk"];
$order_id = $_POST["order_id"];
$receive_name = $_POST["receive_name"];
	
$sql1 = "select * from hos__receive order by id_auto desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
$ref_id =$fetch1['ref_id']+1;


$save="insert into hos__receive
(type_company,date_receive,customer_name,customer_address,iv_no,remark_st,sale_code,sale_name,add_date,add_by,ref_id,receive_ckk,receive_name,allwell_ckk,order_id,stock_complete,ecom_ckk,channel,type_remark)
values
('".$type_company."','".$date_receive."','".$customer_name."','".$customer_address."','".$iv_no."','".$remark_st."','".$sale_code."','".$sale_name."','".$add_date."','".$add_by."','".$ref_id."','".$receive_ckk."','".$receive_name."','2','".$order_id."','3','1','".$channel."','".$type_remark."')";

$qsave=mysqli_query($conn,$save);


foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$sn_new  = $sn[$key];
		$sale_remarkk_new=$sale_remarkk[$key];
		$product_id_new =$product_id[$key];
        


	if($product_id_new!=''){


$strSQL = "insert into hos__subreceive
(ref_idd,count,stock_remark,product_id,product_code,sn)
values ('".$ref_id."','".$sale_count_new."','".$sale_remarkk_new."','".$product_id_new."','".$product_id_new."','".$sn_new."')";

$objQuery = mysqli_query($conn,$strSQL);

		
	}
}




/*$save1="Update   so__main set  cancel_ckk = '1'   where ref_id ='".$ref_sale."'";
$qsave1=mysqli_query($conn,$save1);
*/


//exit();

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='rister_clearbrpn_stedit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


