<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_doc = $_POST["type_doc"];
$bill_id = $_POST["bill_id"];
$bill_name = $_POST["bill_name"];
$sale_code = $_POST["sale_code"];
$po_no = $_POST["po_no"];
$remark = $_POST["remark"];
$date_po = $_POST["date_po"];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	
	move_uploaded_file($_FILES['img_po1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['img_po1']['name']));
	move_uploaded_file($_FILES['img_po2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['img_po2']['name']));
	move_uploaded_file($_FILES['img_po3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['img_po3']['name']));
	move_uploaded_file($_FILES['img_po4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['img_po4']['name']));
	move_uploaded_file($_FILES['img_po5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['img_po5']['name']));

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__po";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "PO";

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

$ref_id ="$so$nextId";
	
	

	
$strSQL23 = "SELECT * FROM hos__po WHERE po_no = '".$po_no."'";
$objQuery23 = mysqli_query($conn,$strSQL23);
$num = mysqli_num_rows($objQuery23);

if($num > 0){	
echo "<script language=\"JavaScript\">";
echo "alert('PO เลขที่ $po_no มีการบันทึกข้อมูลไปแล้วค่ะ');window.location='main_admin_po.php';";
echo "</script>";
exit();
	
	
}


$save="insert into hos__po
(ref_id,type_doc,bill_id,bill_name,po_no,date_po,sale_code,remark,add_date,add_by,img_po1,img_po2,img_po3,img_po4,img_po5)
values
('".$ref_id."','".$type_doc."','".$bill_id."','".$bill_name."','".$po_no."','".$date_po."','".$sale_code."','".$remark."','".$add_date."','".$add_by."','".$_FILES['img_po1']['name']."','".$_FILES['img_po2']['name']."','".$_FILES['img_po3']['name']."','".$_FILES['img_po4']['name']."','".$_FILES['img_po5']['name']."')";

$qsave=mysqli_query($conn,$save);
	
	

$product_id1 = $_POST["product_id1"];
$product_name1 = $_POST["product_name1"];
$unit_name1 = $_POST["unit_name1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);
$discount_unit1 = $_POST["discount_unit1"];
$warranty1  = $_POST["warranty1"];
$cal1 = $_POST["cal1"];
$pm1 = $_POST["pm1"];
	
	
	
if($_POST["product_code1"]!=''){
$product_code1 = $_POST["product_code1"];
}else if($_POST["product_codet1"]!=''){
$product_code1 = $_POST["product_codet1"];
}else{
$product_code1 = $_POST["product_c1"];	
}

	
	
$product_name2 = $_POST["product_name2"];
$unit_name2 = $_POST["unit_name2"];
$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sale_remarkk2 = $_POST["sale_remarkk2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);
$discount_unit2 = $_POST["discount_unit2"];
$warranty2  = $_POST["warranty2"];
$cal2 = $_POST["cal2"];
$pm2 = $_POST["pm2"];
	
if($_POST["product_code2"]!=''){
$product_code2 = $_POST["product_code2"];
}else if($_POST["product_codet2"]!=''){
$product_code2 = $_POST["product_codet2"];
}else{
$product_code2 = $_POST["product_c2"];	
}



$product_name3 = $_POST["product_name3"];
$unit_name3 = $_POST["unit_name3"];
$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);
$discount_unit3 = $_POST["discount_unit3"];
$warranty3  = $_POST["warranty3"];
$cal3 = $_POST["cal3"];
$pm3 = $_POST["pm3"];

if($_POST["product_code3"]!=''){
$product_code3 = $_POST["product_code3"];
}else if($_POST["product_codet3"]!=''){
$product_code3 = $_POST["product_codet3"];
}else{
$product_code3 = $_POST["product_c3"];	
}


$product_name4 = $_POST["product_name4"];
$unit_name4 = $_POST["unit_name4"];
$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);
$discount_unit4 = $_POST["discount_unit4"];
$warranty4  = $_POST["warranty4"];
$cal4 = $_POST["cal4"];
$pm4 = $_POST["pm4"];
	
if($_POST["product_code4"]!=''){
$product_code4 = $_POST["product_code4"];
}else if($_POST["product_codet4"]!=''){
$product_code4 = $_POST["product_codet4"];
}else{
$product_code4 = $_POST["product_c4"];	
}


$product_name5 = $_POST["product_name5"];
$unit_name5 = $_POST["unit_name5"];
$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);
$discount_unit5 = $_POST["discount_unit5"];
$warranty5  = $_POST["warranty5"];
$cal5 = $_POST["cal5"];
$pm5 = $_POST["pm5"];
	
if($_POST["product_code5"]!=''){
$product_code5 = $_POST["product_code5"];
}else if($_POST["product_codet1"]!=''){
$product_code5 = $_POST["product_codet5"];
}else{
$product_code5 = $_POST["product_c5"];	
}


$product_name6 = $_POST["product_name6"];
$unit_name6 = $_POST["unit_name6"];
$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$discount_unit6 = $_POST["discount_unit6"];
$warranty6  = $_POST["warranty6"];
$cal6 = $_POST["cal6"];
$pm6 = $_POST["pm6"];
	
if($_POST["product_code6"]!=''){
$product_code6 = $_POST["product_code6"];
}else if($_POST["product_codet6"]!=''){
$product_code6 = $_POST["product_codet6"];
}else{
$product_code6 = $_POST["product_c6"];	
}


$product_name7 = $_POST["product_name7"];
$unit_name7 = $_POST["unit_name7"];
$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$discount_unit7 = $_POST["discount_unit7"];
$warranty7  = $_POST["warranty7"];
$cal7 = $_POST["cal7"];
$pm7 = $_POST["pm7"];

if($_POST["product_code7"]!=''){
$product_code7 = $_POST["product_code7"];
}else if($_POST["product_codet7"]!=''){
$product_code7 = $_POST["product_codet7"];
}else{
$product_code7 = $_POST["product_c7"];	
}

$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$discount_unit8 = $_POST["discount_unit8"];
$warranty8  = $_POST["warranty8"];
$cal8 = $_POST["cal8"];
$pm8 = $_POST["pm8"];
if($_POST["product_code8"]!=''){
$product_code8 = $_POST["product_code8"];
}else if($_POST["product_codet8"]!=''){
$product_code8 = $_POST["product_codet8"];
}else{
$product_code8 = $_POST["product_c8"];	
}


$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$discount_unit9 = $_POST["discount_unit9"];
$warranty9  = $_POST["warranty9"];
$cal9 = $_POST["cal9"];
$pm9 = $_POST["pm9"];
if($_POST["product_code9"]!=''){
$product_code9 = $_POST["product_code9"];
}else if($_POST["product_codet9"]!=''){
$product_code9 = $_POST["product_codet9"];
}else{
$product_code9 = $_POST["product_c9"];	
}

$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$discount_unit10 = $_POST["discount_unit10"];
$warranty10  = $_POST["warranty10"];
$cal10 = $_POST["cal10"];
$pm10 = $_POST["pm10"];

if($_POST["product_code10"]!=''){
$product_code10 = $_POST["product_code10"];
}else if($_POST["product_codet10"]!=''){
$product_code10 = $_POST["product_codet10"];
}else{
$product_code10 = $_POST["product_c10"];	
}






//แถวที่ 1

if($product_id1 !==''  ){
	

$strSQL1 = "insert into hos__subpo
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_id1."','".$product_id1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);	
	

}	

//แถวที่ 2

if($product_id2 !==''  ){


$strSQL2 ="insert into hos__subpo
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$product_id2."','".$product_id2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);



}


//แถวที่ 3

if($product_id3 !==''  ){


$strSQL3 = "insert into hos__subpo
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$product_id3."','".$product_id3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);
	


}


if($product_id4 !==''  ){


$strSQL4 = "insert into hos__subpo
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$product_id4."','".$product_id4."')";

$objQuery4 = mysqli_query($conn,$strSQL4);


}


if($product_id5 !==''  ){
	


$strSQL5 = "insert into hos__subpo
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$product_id5."','".$product_id5."')";

$objQuery5 = mysqli_query($conn,$strSQL5);
	

}

if($product_id6 !==''  ){
	
$strSQL6 = "insert into hos__subpo
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."','".$product_id6."','".$product_id6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);
	

}


if($product_id7 !==''  ){
	

$strSQL7 = "insert into hos__subpo
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."','".$product_id7."','".$product_id7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);

}


if($product_id8 !==''  ){

	
	
$strSQL8 = "insert into hos__subpo
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."','".$product_id8."','".$product_id8."')";

	$objQuery8 = mysqli_query($conn,$strSQL8);

}


if($product_id9 !==''  ){
	
	

$strSQL9 = "insert into hos__subpo
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."','".$product_id9."','".$product_id9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);


}


if($product_id10 !==''  ){


$strSQL10 = "insert into hos__subpo
(ref_idd,count,price,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."','".$product_id10."','".$product_id10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);


}



	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_poadmin_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}