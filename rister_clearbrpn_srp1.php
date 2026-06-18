<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {


$spr_date = $_POST["spr_date"];
$wo_no = $_POST["wo_no"];	
$equipment = $_POST["equipment"];	
$engineer = $_POST["engineer"];	
$date_exp = $_POST["date_exp"];	
$clear_brn = $_POST["clear_brn"];	
$sn_num = $_POST["sn_num"];	
$date_imstall = $_POST["date_imstall"];	
$per_no = $_POST["per_no"];
$clear_brnp = $_POST["clear_brnp"];	
$brn_no = $_POST["brn_no"];	
$brnp_no = $_POST["brnp_no"];	
$clear_epe = $_POST["clear_epe"];	
$epe_no = $_POST["epe_no"];	
$pro_ckk = $_POST["pro_ckk"];	
$pro_des = $_POST["pro_des"];	
$address = $_POST["address"];
$customer = $_POST["customer"];
$type_company = $_POST["type_company"];
$status_doc = "Request";
$engineer_date= date('Y-m-d');
$sale_code = $_POST["sale_code"];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$em_code =  $_SESSION['emid'];
$add_date = date('Y-m-d H:i:s');
$ref_id_br = $_POST["ref_id_br"];	
$date_receive = $_POST["date_receive"];	
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$year_1 = substr(date("Y")+543, -2);
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__spr ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "SPR";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}

$ref_id = "$so$nextId";


$year_1 = substr(date("Y")+543, -2);
$sql1 = "SELECT MAX(spr) AS spr FROM hos__spr where type_company = '".$type_company."' and year = '".$year_1."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

$spr = $rs1["spr"]+1;
	
if($type_company=='1'){
	$so1='SPR';
}else if($type_company=='2'){
	$so1='SPRNB';
}	
$spr_no = "$so1$spr/$year_1";




$save="insert into hos__spr
(ref_id,spr,spr_no,spr_date,wo_no,equipment,engineer,date_exp,clear_brn,sn_num,date_imstall,per_no,clear_brnp,brn_no,brnp_no,clear_epe,epe_no,pro_ckk,pro_des,address,customer,type_company,status_doc,engineer_date,sale_code,add_by,em_code,add_date,date_receive,year)
values
('".$ref_id."','".$spr."','".$spr_no."','".$spr_date."','".$wo_no."','".$equipment."','".$engineer."','".$date_exp."','".$clear_brn."','".$sn_num."','".$date_imstall."','".$per_no."','".$clear_brnp."','".$brn_no."','".$brnp_no."','".$clear_epe."','".$epe_no."','".$pro_ckk."','".$pro_des."','".$address."','".$customer."','".$type_company."','".$status_doc."','".$engineer_date."','".$sale_code."','".$add_by."','".$em_code."','".$add_date."','".$date_receive."','".$year_1."')";

$qsave=mysqli_query($conn,$save);




$id = $_POST["id"];
$product_id = $_POST["product_id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remark = $_POST["sale_remark"];
$sn = $_POST["sn"];
$clear_br = $_POST["clear_br"];

foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
        $product_id_new =$product_id[$key];
		$sum_amount_new = $product_price_new *$sale_count_new;
		$sale_remark_new =$sale_remark[$key];
		$sn_new =$sn[$key];
	$clear_br_new =$clear_br[$key];

if($clear_br_new =='1'){

$strSQL6 = "insert into hos__subspr
(ref_idd,product_id,product_code,sale_count,unit_price,sum_amount,sale_remark,clear_br,clear_ivno,sn)
values ('".$ref_id."','".$product_id_new."','".$product_id_new."','".$sale_count_new."','".$product_price_new."','".$sum_amount_new."','".$sale_remark_new."','1','".$brnp_no."','".$sn_new."')";

$objQuery6 = mysqli_query($conn,$strSQL6);
	
	
$strSQL6 = "SELECT app_spr  FROM tb_product where product_ID ='".$product_id_new."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
if($objResult6["app_spr"]=='1'){
	
$save1="Update  hos__spr set app_ckk='1'   where  ref_id ='".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);
		
}			
	
$sql1 = "SELECT ref_id_br   FROM   hos__br   where  iv_no = '".$brnp_no."' and status_doc = 'Approve'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

	
$sql2 = "SELECT sum(count) as sale_count   FROM   hos__subbr   where  ref_idd_br = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";

$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_array($qry2);



$sql3 = "SELECT sum(sale_count) as count3   FROM   hos__subspr   where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$brnp_no."' and status_spr='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM hos__subso where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$brnp_no."' and status_so='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$brnp_no."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
$rs41 = mysqli_fetch_array($qry41);

$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '".$rs41['ref_id']."' and product_id = '".$product_id_new."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM hos__subsmp where  product_id = '".$product_id_new."' and clear_br = '1' and br_no ='".$brnp_no."' and status_smp ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs3["count13"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];

	
$count2 = ($rs2['count'] - ($count3+$count4+$count5+$count13))-$sale_count_new;

if($count2=='0'){

$save6="Update  hos__subbr set  clear_ckk = '1'    where ref_idd_br = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";
$qsave6=mysqli_query($conn,$save6);

}	
	
}
	}


//$save1="Update hos__br SET close_br='1'  where ref_id_br = '".$ref_id_br."'";
//$qsave1=mysqli_query($conn,$save1);


	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_engspr_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
}
	


