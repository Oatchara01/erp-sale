<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = $_POST["ref_id"];
$type_doc = $_POST["type_doc"];
$bill_id = $_POST["bill_id"];
$bill_name = $_POST["bill_name"];
$sale_code = $_POST["sale_code"];
$po_no = $_POST["po_no"];
$remark = $_POST["remark"];
$date_po = $_POST["date_po"];
	

if($_FILES['img_po1']['name']!=''){
 move_uploaded_file($_FILES['img_po1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['img_po1']['name']));
 $img_po1=$_FILES['img_po1']['name'];
}else{
 $img_po1 = $_POST["img_po1"];

}

if($_FILES['img_po2']['name']!=''){
 move_uploaded_file($_FILES['img_po2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['img_po2']['name']));
 $img_po2=$_FILES['img_po2']['name'];
}else{
 $img_po2 = $_POST["img_po2"];

}

if($_FILES['img_po3']['name']!=''){
 move_uploaded_file($_FILES['img_po3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['img_po3']['name']));
 $img_po3=$_FILES['img_po3']['name'];
}else{
 $img_po3 = $_POST["img_po3"];

}

if($_FILES['img_po4']['name']!=''){
 move_uploaded_file($_FILES['img_po4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['img_po4']['name']));
 $img_po4 =$_FILES['img_po4']['name'];
}else{
 $img_po4 = $_POST["img_po4"];

}

if($_FILES['img_po5']['name']!=''){
 move_uploaded_file($_FILES['img_po5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['img_po5']['name']));
 $img_po5=$_FILES['img_po5']['name'];
}else{
 $img_po5 = $_POST["img_po5"];

}



$save="UPDATE hos__po SET
type_doc='".$type_doc."',bill_id='".$bill_id."',bill_name='".$bill_name."',po_no='".$po_no."',date_po='".$date_po."',sale_code='".$sale_code."',remark='".$remark."',img_po1='".$img_po1."',img_po2='".$img_po2."',img_po3='".$img_po3."',img_po4='".$img_po4."',img_po5='".$img_po5."'   Where ref_id ='".$ref_id."'";

$qsave=mysqli_query($conn,$save);
	
	

$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$product_price = $_POST["product_price"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
 $warranty =$_POST["warranty"];
 $pm=$_POST["pm"];
 $cal=$_POST["cal"];
 $product_id = $_POST["product_id"];
 $discount_unit = $_POST["discount_unit"];



  foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sale_count_new=$sale_count[$key];
		$product_price1=$product_price[$key];
		$product_price_new=str_replace(',','', $product_price1);
		$sale_remarkk_new=$sale_remarkk[$key];
		$warranty_new=$warranty[$key];
		$pm_new=$pm[$key];
	    $sn_new=$sn[$key];
		$cal_new=$cal[$key];
        $product_id_new =$product_id[$key];
        $discount_unit1 =$discount_unit[$key];
		$discount_unit_new=str_replace(',','', $discount_unit1);
		$sum_amount_new = ($product_price_new - $discount_unit_new)*$sale_count_new;




$strSQL = "Update   hos__subpo set count='".$sale_count_new."',price='".$product_price_new."',amount='".$sum_amount_new."',sale_remark='".$sale_remarkk_new."',warranty='".$warranty_new."',pm='".$pm_new."',cal='".$cal_new."',product_id='".$product_id_new."',product_code ='".$product_id_new."',discount ='".$discount_unit_new."'    Where id= '".$id_new."' ";

$objQuery = mysqli_query($conn,$strSQL);



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