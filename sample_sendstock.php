<?php
include "dbconnect.php";
 include('head.php'); 
date_default_timezone_set("Asia/Bangkok");

  $ref_idsmp = $_GET['ref_idsmp'];
  $sup_date = date('Y-m-d');
  $sup_name = $_SESSION['name'];

$strSQL1 = "SELECT * FROM  (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$_GET["ref_idsmp"]."' and product_type = 'สินค้าขาย'";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$sql1 = "SELECT sale_count FROM   hos__subsmp   where reff_idsmp = '".$_GET["ref_idsmp"]."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);


if($Num_Rows1 > 0 or $rs1["sale_count"] >= "100.00" ){
 $save="Update  hos__smp set send_dm = '1',sup_name='".$sup_name."',sup_date='".$sup_date."'  where ref_idsmp = '".$ref_idsmp."'";

$qsave=mysqli_query($conn,$save);

}else{
 $save="Update  hos__smp set status_sup ='Approve',send_stock = '1' ,send_admin = '1' ,sup_name='".$sup_name."',sup_date='".$sup_date."'  where ref_idsmp = '".$ref_idsmp."' ";
$qsave=mysqli_query($conn,$save);
	
$save17="Update  hos__subsmp set status_smp ='Approve'  where reff_idsmp = '".$ref_idsmp."' ";
$qsave17=mysqli_query($conn,$save17);	
	
 /*foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
        $product_id_new =$product_id[$key];
		$sale_remark_new = $sale_remark[$key];
	    $clear_br_new = $clear_br[$key];
	    $br_no_new = $br_no[$key];
	    $sn_new = $sn[$key];
		$sum_amount_new = $product_price_new *$sale_count_new;

if($br_no_new !=''){
	
$sql1 = "SELECT ref_id_br   FROM   hos__br   where  iv_no = '".$br_no_new."' and status_doc = 'Approve'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

	
$sql2 = "SELECT sum(count) as sale_count   FROM   hos__subbr   where  ref_idd_br = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_array($qry2);



$sql3 = "SELECT sum(sale_count) as count3   FROM   (hos__spr LEFT JOIN hos__subspr ON hos__spr.ref_id=hos__subspr.ref_idd)   where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$br_no_new."' and status_doc ='Aprrove'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM   (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd)   where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$br_no_new."' and status_doc ='Aprrove'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$br_no_new."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
$rs41 = mysqli_fetch_array($qry41);

$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '".$rs41['ref_id']."' and product_id = '".$product_id_new."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM   (hos__smp LEFT JOIN hos__subsmp ON hos__smp.ref_idsmp=hos__subsmp.reff_idsmp)   where  product_id = '".$product_id_new."' and clear_br = '1' and br_no ='".$br_no_new."'  and status_sup ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs3["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];

	
$count2 = $rs2['sale_count'] - ($count3+$count4+$count5+$count13);

if($count2=='0'){

$save6="Update  hos__subbr set  clear_ckk = '1'    where ref_idd = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";
$qsave6=mysqli_query($conn,$save6);

}


		

if($count2 < 0){

echo "<script language=\"JavaScript\">";
echo "alert('สินค้าในใบยืมนี้มีไม่พอในการเคลียร์ยืมครั้งนี้ค่ะ');window.location='register_salesmp_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
	
}
	
$strSQL1 = "SELECT clear_ckk  where hos__subbr WHERE ref_idd_br = '".$rs1['ref_id_br']."' and  clear_ckk ='0'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

if($objResult1["clear_ckk"]==''){
$save1="Update   hos__br set  close_br = '1'   where iv_no ='".$clear_ivno_new."'";
$qsave1=mysqli_query($conn,$save1);	
}
	
}
 }*/
	
	
	
	
}

 
if($qsave) {
	if($_SESSION['type_login']=='Sup_Sale'){

 echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_supsmp_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";
	}else{
		
	echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_cmsmp_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";	
		
	}

  }else{
   echo "Cannot";
  }
	

	
?>
