<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = $_POST["ref_id"];

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
$date_receive = $_POST["date_receive"];
$sn_ckk = $_POST["sn_ckk"];
$status_doc = "Request";
$engineer_date= date('Y-m-d');
$sale_code = $_POST["sale_code"];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$em_code =  $_SESSION['emid'];
$add_date = date('Y-m-d H:i:s');
	
//,type_company='".$type_company."'



$save="Update  hos__spr SET
spr_date='".$spr_date."',wo_no='".$wo_no."',sn_ckk='".$sn_ckk."',equipment='".$equipment."',engineer='".$engineer."',date_exp='".$date_exp."',clear_brn='".$clear_brn."',sn_num='".$sn_num."',date_imstall='".$date_imstall."',per_no='".$per_no."',clear_brnp='".$clear_brnp."',brn_no='".$brn_no."',brnp_no='".$brnp_no."',clear_epe='".$clear_epe."',epe_no='".$epe_no."',pro_ckk='".$pro_ckk."',pro_des='".$pro_des."',address='".$address."',customer='".$customer."',date_receive='".$date_receive."'  where ref_id = '".$ref_id."'";

$qsave=mysqli_query($conn,$save);



$id = $_POST["id"];
$product_id = $_POST["product_id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remark = $_POST["sale_remark"];
$clear_ivno = $_POST["clear_ivno"];
$clear_br = $_POST["clear_br"];
$sn = $_POST["sn"];

$strSQL21 = "SELECT * FROM hos__subspr WHERE ref_idd = '".$ref_id."' ";
$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){	
	
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


$strSQL1 = "Update  hos__subspr set  product_id = '".$product_id_new."',product_code = '".$product_id_new."',sale_count ='".$sale_count_new."',unit_price = '".$product_price_new."',sum_amount = '".$sum_amount_new."',sale_remark='".$sale_remark_new."',clear_ivno='".$clear_ivno_new."',clear_br='".$clear_br_new."',sn='".$sn_new."'   where id = '".$id_new."'";

$objQuery1 = mysqli_query($conn,$strSQL1);

	
$strSQL6 = "SELECT app_spr  FROM tb_product where product_ID ='".$product_id_new."'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$objResult6 = mysqli_fetch_array($objQuery6);
if($objResult6["app_spr"]=='1'){
	
$save1="Update  hos__spr set app_ckk='1'   where  ref_id ='".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);
		
}			

	}

}	

$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$sale_remark6 = $_POST["sale_remark6"];
$clear_ivno6 = $_POST["clear_ivno6"];
$clear_br6 = $_POST["clear_br6"];
		

$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$sale_remark7 = $_POST["sale_remark7"];
$clear_ivno7 = $_POST["clear_ivno7"];
$clear_br7 = $_POST["clear_br7"];		


$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$sale_remark8 = $_POST["sale_remark8"];
$clear_ivno8 = $_POST["clear_ivno8"];
$clear_br8 = $_POST["clear_br8"];		


$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$sale_remark9 = $_POST["sale_remark9"];
$clear_ivno9 = $_POST["clear_ivno9"];
$clear_br9 = $_POST["clear_br9"];		

$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$sale_remark10 = $_POST["sale_remark10"];
$clear_ivno10 = $_POST["clear_ivno10"];
$clear_br10 = $_POST["clear_br10"];		



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
	


