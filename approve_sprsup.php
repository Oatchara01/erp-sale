<?php
include('head.php'); 
include "dbconnect.php";


$ref_id = $_POST['ref_id'];
$engineer = $_POST['engineer'];
 $name = $_SESSION["name"];
 $today= date('Y-m-d');
$add_date = date('Y-m-d H:i:s');



$id = $_POST["id"];
$product_id = $_POST["product_id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remark = $_POST["sale_remark"];
$clear_ivno = $_POST["clear_ivno"];
$clear_br = $_POST["clear_br"];
$sn = $_POST["sn"];

	
foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
        $product_id_new =$product_id[$key];
	    $clear_br_new =$clear_br[$key];
	   	$sn_new =$sn[$key];
	  	$clear_ivno_new =$clear_ivno[$key];
		$sum_amount_new = $product_price_new *$sale_count_new;
		$sale_remark_new =$sale_remark[$key];


if($clear_ivno_new !=''){
$sql1 = "SELECT ref_id_br   FROM   hos__br   where  iv_no = '".$clear_ivno_new."' and status_doc = 'Approve'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

	
$sql2 = "SELECT sum(count) as sale_count   FROM   hos__subbr   where  ref_idd_br = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_array($qry2);
	
/*$sql21 = "SELECT ref_id   FROM   so__main   where  doc_no = '".$clear_ivno_new."' and cancel_ckk='0'";
$qry21 = mysqli_query($conn,$sql21) or die(mysqli_error());
$rs21 = mysqli_fetch_assoc($qry21);

	
$sql22 = "SELECT sum(sale_count) as sale_count   FROM   so__submain   where  ref_idd = '".$rs21['ref_id']."' and product_id = '".$product_id_new."'";
$qry22 = mysqli_query($conn,$sql22) or die(mysqli_error());
$rs22 = mysqli_fetch_array($qry22);	*/
	
$sql3 = "SELECT sum(sale_count) as count3   FROM  hos__subspr  where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$clear_ivno_new."' and status_spr ='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM  hos__subso   where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$clear_ivno_new."' and status_so ='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$clear_ivno_new."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
$rs41 = mysqli_fetch_array($qry41);

$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '".$rs41['ref_id']."' and product_id = '".$product_id_new."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM hos__subsmp where  product_id = '".$product_id_new."' and clear_br = '1' and br_no ='".$clear_ivno_new."' and status_smp ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];		
$count2 = $rs2['sale_count'] - ($count3+$count4+$count5+$count13+$sale_count_new);
if($count2 <='0'){
$save6="Update  hos__subbr set  clear_ckk = '1'    where ref_idd_br = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";
$qsave6=mysqli_query($conn,$save6);

}
//echo $count2;
if($count2 < '0'){

echo "<script language=\"JavaScript\">";
echo "alert('สินค้าในใบยืมนี้มีไม่พอในการเคลียร์ยืมครั้งนี้ค่ะ');window.location='register_suphos_approve.php?ref_id=$ref_id';";
echo "</script>";

	
}		
	 
	}
	

}	

//exit();

/*$qfirst = "select SUM(sum_amount) As sum_amount from hos__subspr where ref_idd = '".$_GET["ref_id"]."'";
$first = mysqli_query($conn,$qfirst);
$ffirst = mysqli_fetch_array($first);*/

$qfirst2 = "select app_ckk from hos__spr where ref_id = '".$ref_id."'";
$first2 = mysqli_query($conn,$qfirst2);
$ffirst2 = mysqli_fetch_array($first2);

$qfirst = "select product_id from hos__subspr where ref_idd = '".$ref_id."'";
$first = mysqli_query($conn,$qfirst);
$ffirst = mysqli_fetch_array($first);

$qfirst1 = "select group1 from tb_product where product_ID = '".$ffirst["product_id"]."'";
$first1 = mysqli_query($conn,$qfirst1);
$ffirst1 = mysqli_fetch_array($first1);



//
if($ffirst2["app_ckk"]=='1'){
	
$save="Update  hos__spr set send_sup ='1',sup_name='".$name."',sup_date='".$today."',sup_adddate='".$add_date."',send_cm='1',cm_name='".$name."',cm_date='".$today."',status_doc='Approve',send_stock='1'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
	
$save="Update  hos__subspr set status_spr='Approve'  where ref_idd = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
	
	
}else if($ffirst1["group1"] =="501112.1 ที่นอนลม - YoungWon" or $ffirst1["group1"]=="501311 อะไหล่ - YoungWon"  or  $ffirst1["group1"] =="501320 Suction vacuum" or  $ffirst1["group1"] =="อะไหล่ - Alphabed"  or  $ffirst1["group1"] =="เครื่องวัดความดันโลหิต - HARTMANN"   or  $ffirst1["group1"] =="Flowmeter"  or  $ffirst1["group1"] =="Smartsign"   or  $ffirst1["group1"] =="501212 เครื่องวัดอุณหภูมิ / Thermometer" or  $ffirst1["group1"] =="501205 เครื่องวัดน้ำตาล - Glucosure" or  $ffirst1["group1"] =="501206 เครื่องวัดน้ำตาล - G-426" or  $ffirst1["group1"] =="501205.1 เครื่องวัดน้ำตาล - GLUCOALL" ){


$save="Update  hos__spr set send_sup ='1',sup_name='".$name."',sup_date='".$today."',sup_adddate='".$add_date."',send_cm='1',cm_name='".$name."',cm_date='".$today."',status_doc='Approve',send_stock='1'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
	
$save="Update  hos__subspr set status_spr='Approve'  where ref_idd = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);	
	
	
}else{
	
$save="Update  hos__spr set send_sup ='1',sup_name='".$name."',sup_date='".$today."',sup_adddate='".$add_date."',send_cm='1'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
	
	
			$fline=mysqli_fetch_array($line);
			$sToken = "gCe7s6XlzcHFCtuVNBF2D2g6xbZZS7PrmPz5vpQBc6G";
			$sMessage = "คุณ : $engineer
			มีใบเบิกเครื่องและอะไหล่
			เลขที่อ้างอิง : $ref_id
			รบกวนทำการตรวจสอบข้อมูล
			และอนุมัติการร้องขอ ตามลิงค์ด้านล่างได้เลยคะ
			https://sol.allwellcenter.com			
			";
			$chOne = curl_init();
			curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
			curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);			
			curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt( $chOne, CURLOPT_POST, 1);
			curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage);
			$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
			curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
			curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec( $chOne );
			if(curl_error($chOne)) {
				echo 'error:' . curl_error($chOne);
			}
			else {
				$result_ = json_decode($result, true);
				echo "status : ".$result_['status']; echo "message : ". $result_['message'];
				}
			curl_close( $chOne );  
		
			$fline=mysqli_fetch_array($line);
			$sToken = "I9fEDAgfYAuSbsHACVyUDUPbAJhVMB9LY554hBZiNWH";
			$sMessage = "คุณ : $engineer
			มีใบเบิกเครื่องและอะไหล่
			เลขที่อ้างอิง : $ref_id
			รบกวนทำการตรวจสอบข้อมูล
			และอนุมัติการร้องขอ ตามลิงค์ด้านล่างได้เลยคะ
			https://sol.allwellhealthcare.com			
			";
			$chOne = curl_init();
			curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
			curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);			
			curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt( $chOne, CURLOPT_POST, 1);
			curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage);
			$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
			curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
			curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec( $chOne );
			if(curl_error($chOne)) {
				echo 'error:' . curl_error($chOne);
			}
			else {
				$result_ = json_decode($result, true);
				echo "status : ".$result_['status']; echo "message : ". $result_['message'];
				}
			curl_close( $chOne );  
	
}
 
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้วค่ะ');window.location='status_approvespr.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>