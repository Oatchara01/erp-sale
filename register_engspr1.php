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
$date_receive = $_POST["date_receive"];	

	
$yearMonth = substr(date("Y")+543, -2).date("m");
$year_1 = substr(date("Y")+543, -2);
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__spr";
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

	
$wo_no1 = substr($wo_no,0,2);	
	
	
if($type_company=='1'){
if($wo_no1=='IM'){
$save="UPDATE tb_service_orderim SET spar_ckk = '1',spr_no='".$spr_no."'  where service_order_no = '".$wo_no."'";
$qsave=mysqli_query($service,$save);	
}else{	
	
$save="UPDATE tb_service_order SET spar_ckk = '1',spr_no='".$spr_no."'  where service_order_no = '".$wo_no."'";
$qsave=mysqli_query($service,$save);
	
}
}else if($type_company=='2'){
	
if($wo_no1=='IM'){
$save="UPDATE tb_service_orderim SET spar_ckk = '1',spr_no='".$spr_no."'  where service_order_no = '".$wo_no."'";
$qsave=mysqli_query($servicenb,$save);	
}else{	
	
$save="UPDATE tb_service_order SET spar_ckk = '1',spr_no='".$spr_no."'  where service_order_no = '".$wo_no."'";
$qsave=mysqli_query($servicenb,$save);
	
}	
}
	


$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);
$sale_remark1 = $_POST["sale_remark1"];
		

$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$sale_remark2 = $_POST["sale_remark2"];
	

$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$sale_remark3 = $_POST["sale_remark3"];
		

$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$sale_remark4 = $_POST["sale_remark4"];
		

$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$sale_remark5 = $_POST["sale_remark5"];
		

$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$sale_remark6 = $_POST["sale_remark6"];
		

$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$sale_remark7 = $_POST["sale_remark7"];
		


$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$sale_remark8 = $_POST["sale_remark8"];
		


$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$sale_remark9 = $_POST["sale_remark9"];
		

$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$sale_remark10 = $_POST["sale_remark10"];
	
	
$clear_br1 = $_POST["clear_br1"];	
$clear_br2 = $_POST["clear_br2"];	
$clear_br3 = $_POST["clear_br3"];	
$clear_br4 = $_POST["clear_br4"];	
$clear_br5 = $_POST["clear_br5"];	
$clear_br6 = $_POST["clear_br6"];	
$clear_br7 = $_POST["clear_br7"];	
$clear_br8 = $_POST["clear_br8"];	
$clear_br9 = $_POST["clear_br9"];	
$clear_br10 = $_POST["clear_br10"];	

	
$clear_ivno1 = $_POST["clear_ivno1"];	
$clear_ivno2 = $_POST["clear_ivno2"];	
$clear_ivno3 = $_POST["clear_ivno3"];	
$clear_ivno4 = $_POST["clear_ivno4"];	
$clear_ivno5 = $_POST["clear_ivno5"];	
$clear_ivno6 = $_POST["clear_ivno6"];	
$clear_ivno7 = $_POST["clear_ivno7"];	
$clear_ivno8 = $_POST["clear_ivno8"];	
$clear_ivno9 = $_POST["clear_ivno9"];	
$clear_ivno10 = $_POST["clear_ivno10"];	
	

if($product_id1 !==''  ){

$strSQL1 = "insert into hos__subspr
(ref_idd,product_id,product_code,sale_count,unit_price,sum_amount,sale_remark,clear_br,clear_ivno)
values ('".$ref_id."','".$product_id1."','".$product_id1."','".$sale_count1."','".$product_price1."','".$sum_amount1."','".$sale_remark1."','".$clear_br1."','".$clear_ivno1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
$strSQL6 = "SELECT app_spr  FROM tb_product where product_ID ='".$product_id1."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
if($objResult6["app_spr"]=='1'){
	
$save1="Update  hos__spr set app_ckk='1'   where  ref_id ='".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);
		
}
	
	
}


if($product_id2 !==''  ){

$strSQL2 = "insert into hos__subspr
(ref_idd,product_id,product_code,sale_count,unit_price,sum_amount,sale_remark,clear_br,clear_ivno)
values ('".$ref_id."','".$product_id2."','".$product_id2."','".$sale_count2."','".$product_price2."','".$sum_amount2."','".$sale_remark2."','".$clear_br2."','".$clear_ivno2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);

$strSQL6 = "SELECT app_spr  FROM tb_product where product_ID ='".$product_id2."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
if($objResult6["app_spr"]=='1'){
	
$save1="Update  hos__spr set app_ckk='1'   where  ref_id ='".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);
		
}	
	
}



if($product_id3 !==''  ){

	
$strSQL3 = "insert into hos__subspr
(ref_idd,product_id,product_code,sale_count,unit_price,sum_amount,sale_remark,clear_br,clear_ivno)
values ('".$ref_id."','".$product_id3."','".$product_id3."','".$sale_count3."','".$product_price3."','".$sum_amount3."','".$sale_remark3."','".$clear_br3."','".$clear_ivno3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);

$strSQL6 = "SELECT app_spr  FROM tb_product where product_ID ='".$product_id3."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
if($objResult6["app_spr"]=='1'){
	
$save1="Update  hos__spr set app_ckk='1'   where  ref_id ='".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);
		
}		
	
}


if($product_id4 !==''  ){


$strSQL4 = "insert into hos__subspr
(ref_idd,product_id,product_code,sale_count,unit_price,sum_amount,sale_remark,clear_br,clear_ivno)
values ('".$ref_id."','".$product_id4."','".$product_id4."','".$sale_count4."','".$product_price4."','".$sum_amount4."','".$sale_remark4."','".$clear_br4."','".$clear_ivno4."')";
$objQuery4 = mysqli_query($conn,$strSQL4);
	
$strSQL6 = "SELECT app_spr  FROM tb_product where product_ID ='".$product_id4."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
if($objResult6["app_spr"]=='1'){
	
$save1="Update  hos__spr set app_ckk='1'   where  ref_id ='".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);
		
}		
	
}



if($product_id5 !==''  ){


$strSQL5 = "insert into hos__subspr
(ref_idd,product_id,product_code,sale_count,unit_price,sum_amount,sale_remark,clear_br,clear_ivno)
values ('".$ref_id."','".$product_id5."','".$product_id5."','".$sale_count5."','".$product_price5."','".$sum_amount5."','".$sale_remark5."','".$clear_br5."','".$clear_ivno5."')";

$objQuery5 = mysqli_query($conn,$strSQL5);
	
$strSQL6 = "SELECT app_spr  FROM tb_product where product_ID ='".$product_id5."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
if($objResult6["app_spr"]=='1'){
	
$save1="Update  hos__spr set app_ckk='1'   where  ref_id ='".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);
		
}		
	
}



if($product_id6 !==''  ){

	
$strSQL6 = "insert into hos__subspr
(ref_idd,product_id,product_code,sale_count,unit_price,sum_amount,sale_remark,clear_br,clear_ivno)
values ('".$ref_id."','".$product_id6."','".$product_id6."','".$sale_count6."','".$product_price6."','".$sum_amount6."','".$sale_remark6."','".$clear_br6."','".$clear_ivno6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);
	
$strSQL6 = "SELECT app_spr  FROM tb_product where product_ID ='".$product_id6."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
if($objResult6["app_spr"]=='1'){
	
$save1="Update  hos__spr set app_ckk='1'   where  ref_id ='".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);
		
}		
	
}



if($product_id7 !==''  ){

	
$strSQL7 = "insert into hos__subspr
(ref_idd,product_id,product_code,sale_count,unit_price,sum_amount,sale_remark,clear_br,clear_ivno)
values ('".$ref_id."','".$product_id7."','".$product_id7."','".$sale_count7."','".$product_price7."','".$sum_amount7."','".$sale_remark7."','".$clear_br7."','".$clear_ivno7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);
	
$strSQL6 = "SELECT app_spr  FROM tb_product where product_ID ='".$product_id7."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
if($objResult6["app_spr"]=='1'){
	
$save1="Update  hos__spr set app_ckk='1'   where  ref_id ='".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);
		
}		
	
}



if($product_id8 !==''  ){
			

$strSQL8 = "insert into hos__subspr
(ref_idd,product_id,product_code,sale_count,unit_price,sum_amount,sale_remark,clear_br,clear_ivno)
values ('".$ref_id."','".$product_id8."','".$product_id8."','".$sale_count8."','".$product_price8."','".$sum_amount8."','".$sale_remark8."','".$clear_br8."','".$clear_ivno8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);
	
$strSQL6 = "SELECT app_spr  FROM tb_product where product_ID ='".$product_id8."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
if($objResult6["app_spr"]=='1'){
	
$save1="Update  hos__spr set app_ckk='1'   where  ref_id ='".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);
		
}		
	
}



if($product_id9 !==''  ){
			

$strSQL9 = "insert into hos__subspr
(ref_idd,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark,clear_br,clear_ivno)
values ('".$ref_id."','".$product_id9."','".$product_id9."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$sum_amount9."','".$sale_remark9."','".$clear_br9."','".$clear_ivno9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);

$strSQL6 = "SELECT app_spr  FROM tb_product where product_ID ='".$product_id9."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
if($objResult6["app_spr"]=='1'){
	
$save1="Update  hos__spr set app_ckk='1'   where  ref_id ='".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);
		
}		
	
}


if($product_id10 !==''  ){


$strSQL10 = "insert into hos__subspr
(ref_idd,product_id,product_code,sale_count,sale_countref,unit_price,sum_amount,sale_remark,clear_br,clear_ivno)
values ('".$ref_id."','".$product_id10."','".$product_id10."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$sum_amount10."','".$sale_remark10."','".$clear_br10."','".$clear_ivno10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);
	
$strSQL6 = "SELECT app_spr  FROM tb_product where product_ID ='".$product_id10."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
if($objResult6["app_spr"]=='1'){
	
$save1="Update  hos__spr set app_ckk='1'   where  ref_id ='".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);
		
}		
	
}











	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_engspr_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
}
	


