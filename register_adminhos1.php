<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_doc = $_POST["type_doc"];
$bill_id  = $_POST["bill_id"];
$bill_name = $_POST["bill_name"];
$bill_address = $_POST["bill_address"];
$bill_tel = $_POST["bill_tel"];
$full_bill = $_POST["full_bill"];

$date_so = $_POST["date_so"];
$suggest = $_POST["suggest"];
$payment = $_POST["payment"];
$sale_comment = $_POST["sale_comment"];
$po_no = $_POST["po_no"];
$delivery_contract = $_POST["delivery_contract"];
$book_clear = $_POST["book_clear"];
$book_no = $_POST["book_no"];
$brn_clear = $_POST["brn_clear"];
$brn_no = $_POST["brn_no"];
$brnp_clear = $_POST["brnp_clear"];
$brnp_no = $_POST["brnp_no"];
$sn_ckk = $_POST["sn_ckk"];
$sn_no = $_POST["sn_no"];
$install_place = $_POST["address_send"];
$with_pr = $_POST["with_pr"];
$type_type = $_POST["type_type"];
$type_detail = $_POST["type_detail"];
$delivery_type = $_POST["delivery_type"];
$delivery_date = $_POST["start_date"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$delivery_time = "$start_time $end_time";
$delivery_address = $_POST["address_send"];
$delivery_contact = $_POST["customer_name"];
$delivery_tel = $_POST["customer_tel"];
$payment_des  = $_POST["payment_des"];
$have_order  = $_POST["have_order"];
$order_no = $_POST["order_no"];	
$tax_id = $_POST["tax_id"];
$sale_date= date('Y-m-d');
$sale =  $_SESSION['name'];
$sale_code = $_POST['sale_code'];
$date_tranfer = $_POST['date_tranfer'];
  
  if($sale_code=='S11' or $sale_code=='S12' or $sale_code=='S13' or $sale_code=='S14'   or $sale_code=='S24'){
$sup_code = 'SS2';
$approve  = 'นรินทิพย์';
  }else if ($sale_code=='S15' or $sale_code=='S22' or $sale_code=='S21' or $sale_code=='S51') {

$sup_code = 'SS1';
$approve  = 'พรรณิภา';
  }else if ($sale_code=='S16' or $sale_code=='S17' or $sale_code=='SM1' or $sale_code=='S23') {

$sup_code = 'SM1';
$approve  = 'ลักษณาวรรณ';


  }else if ($sale_code=='S31' or $sale_code=='MM1') {
$sup_code = 'SS3';
$approve  = 'มาลินี';

  }else if ($sale_code=='EN') {
$sup_code = 'SUP_EN';
$approve  = 'ศิรวิทย์';

  }
	
$iv_no = $_POST["iv_no"];
$iv_date = $_POST["iv_date"];
$iv_time = $_POST["iv_time"];
	
$dep_no  = $_POST["dep_no"];
$job_no  = $_POST["job_no"];


$pr_no  = $_POST["pr_no"];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$name =  $_SESSION['name'];
$admin_date= date('Y-m-d');
$admin_code =	$_SESSION['code'];
$admin =  $_SESSION['name'];
$approve_time = date("H:i:s");
$add_by = "$name $surname";

//echo $_FILES['upload1']['name'];
//exit();
	
if ($_FILES['slip1']['size'] == 0) {
$slip1 = "";
}else if ($_FILES['slip1']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip1']['size'] != 0) {
$temp1 = explode(".", $_FILES["slip1"]["name"]);
$slip1 = "slip1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["slip1"]["tmp_name"], "upload/" . $slip1);
}	

	
	
if ($_FILES['slip2']['size'] == 0) {
$slip2 = "";
}else if ($_FILES['slip2']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip2']['size'] != 0) {
$temp2 = explode(".", $_FILES["slip2"]["name"]);
$slip2 = "slip2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["slip2"]["tmp_name"], "upload/" . $slip2);
}	
	
	
if ($_FILES['slip3']['size'] == 0) {
$slip3 = "";
}else if ($_FILES['slip3']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip3']['size'] != 0) {
$temp3 = explode(".", $_FILES["slip3"]["name"]);
$slip3 = "slip3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["slip3"]["tmp_name"], "upload/" . $slip3);
}	
	
	
if ($_FILES['slip4']['size'] == 0) {
$slip4 = "";
}else if ($_FILES['slip4']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip4']['size'] != 0) {
$temp4 = explode(".", $_FILES["slip4"]["name"]);
$slip4 = "slip4" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp4);
move_uploaded_file($_FILES["slip4"]["tmp_name"], "upload/" . $slip4);
}	
	
	
	
if ($_FILES['slip5']['size'] == 0) {
$slip5 = "";
}else if ($_FILES['slip5']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip5']['size'] != 0) {
$temp5 = explode(".", $_FILES["slip5"]["name"]);
$slip5 = "slip5" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp5);
move_uploaded_file($_FILES["slip5"]["tmp_name"], "upload/" . $slip5);
}	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__so";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "SO";

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

$so = "SO";
$ref_id ="$so$nextId";

	
$save="insert into hos__so
(ref_id,type_doc,bill_name,bill_address,full_bill,date_so,suggest,payment,sale_comment,po_no,delivery_contract,book_clear,book_no,brn_clear,brn_no,brnp_clear,brnp_no,sn_ckk,sn_no,install_place,with_pr,type_type,type_detail,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,sale_date,sale,sale_code,pr_no,add_date,add_by,status_doc,approve,approve_code,payment_des,slip1,slip2,slip3,slip4,slip5,iv_no,iv_date,job_no,dep_no,bill_id,admin,admin_code,admin_date,have_order,send_sup,send_admin,approve_date,order_no,tax_id,approve_time,date_tranfer)
values
('".$ref_id."','".$type_doc."','".$bill_name."','".$bill_address."','".$full_bill."','".$date_so."','".$suggest."','".$payment."','".$sale_comment."','".$po_no."','".$delivery_contract."','".$book_clear."','".$book_no."','".$brn_clear."','".$brn_no."','".$brnp_clear."','".$brnp_no."','".$sn_ckk."','".$sn_no."','".$install_place."','".$with_pr."','".$type_type."','".$type_detail."','".$delivery_type."','".$delivery_date."','".$delivery_time."','".$delivery_address."','".$delivery_contact."','".$delivery_tel."','".$sale_date."','".$sale."','".$sale_code."','".$pr_no."','".$add_date."','".$add_by."','Approve','".$approve."','".$sup_code."','".$payment_des."','".$_FILES['slip1']['name']."','".$_FILES['slip2']['name']."','".$_FILES['slip3']['name']."','".$_FILES['slip4']['name']."','".$_FILES['slip5']['name']."','".$iv_no."','".$iv_date."','".$job_no."','".$dep_no."','".$bill_id."','".$admin."','".$admin_code."','".$admin_date."','".$have_order."','1','1','".$admin_date."','".$order_no."','".$tax_id."','".$approve_time."','".$date_tranfer."')";

//echo $save;

$qsave=mysqli_query($conn,$save);

/*$product_id1 = $_POST["product_id1"];
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
	}else{
$product_code1 = $_POST["product_codet1"];
	}

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
	}else{
$product_code2 = $_POST["product_codet2"];
	}


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
	}else{
$product_code3 = $_POST["product_codet3"];
	}

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
	}else{
$product_code4 = $_POST["product_codet4"];
	}



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
	}else{
$product_code5 = $_POST["product_codet5"];
	}


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



$product_id11 = $_POST["product_id11"];
$sale_count11 = $_POST["sale_count11"];
$product_price11 = $_POST["product_price11"];
$sale_remarkk11 = $_POST["sale_remarkk11"];
$sum_amountt11 = $_POST["sum_amount11"];
$sum_amount11= str_replace(',','', $sum_amountt11);
$discount_unit11 = $_POST["discount_unit11"];
$warranty11  = $_POST["warranty11"];
$cal11 = $_POST["cal11"];
$pm11 = $_POST["pm11"];


$product_id12 = $_POST["product_id12"];
$sale_count12 = $_POST["sale_count12"];
$product_price12 = $_POST["product_price12"];
$sale_remarkk12 = $_POST["sale_remarkk12"];
$sum_amountt12 = $_POST["sum_amount12"];
$sum_amount12= str_replace(',','', $sum_amountt12);
$discount_unit12 = $_POST["discount_unit12"];
$warranty12  = $_POST["warranty12"];
$cal12 = $_POST["cal12"];
$pm12 = $_POST["pm12"];


$product_id13 = $_POST["product_id13"];
$sale_count13 = $_POST["sale_count13"];
$product_price13 = $_POST["product_price13"];
$sale_remarkk13 = $_POST["sale_remarkk13"];
$sum_amountt13 = $_POST["sum_amount13"];
$sum_amount13= str_replace(',','', $sum_amountt13);
$discount_unit13 = $_POST["discount_unit13"];
$warranty13  = $_POST["warranty13"];
$cal13 = $_POST["cal13"];
$pm13 = $_POST["pm13"];


$product_id14 = $_POST["product_id14"];
$sale_count14 = $_POST["sale_count14"];
$product_price14 = $_POST["product_price14"];
$sale_remarkk14 = $_POST["sale_remarkk14"];
$sum_amountt14 = $_POST["sum_amount14"];
$sum_amount14= str_replace(',','', $sum_amountt14);
$discount_unit14 = $_POST["discount_unit14"];
$warranty14  = $_POST["warranty14"];
$cal14 = $_POST["cal14"];
$pm14 = $_POST["pm14"];


$product_id15 = $_POST["product_id15"];
$sale_count15 = $_POST["sale_count15"];
$product_price15 = $_POST["product_price15"];
$sale_remarkk15 = $_POST["sale_remarkk15"];
$sum_amountt15 = $_POST["sum_amount15"];
$sum_amount15= str_replace(',','', $sum_amountt15);
$discount_unit15 = $_POST["discount_unit15"];
$warranty15  = $_POST["warranty15"];
$cal15 = $_POST["cal15"];
$pm15 = $_POST["pm15"];



$product_id16 = $_POST["product_id16"];
$sale_count16 = $_POST["sale_count16"];
$product_price16 = $_POST["product_price16"];
$sale_remarkk16 = $_POST["sale_remarkk16"];
$sum_amountt16 = $_POST["sum_amount16"];
$sum_amount16= str_replace(',','', $sum_amountt16);
$discount_unit16 = $_POST["discount_unit16"];
$warranty16  = $_POST["warranty16"];
$cal16 = $_POST["cal16"];
$pm16 = $_POST["pm16"];




$product_id17 = $_POST["product_id17"];
$sale_count17 = $_POST["sale_count17"];
$product_price17 = $_POST["product_price17"];
$sale_remarkk17 = $_POST["sale_remarkk17"];
$sum_amountt17 = $_POST["sum_amount17"];
$sum_amount17= str_replace(',','', $sum_amountt17);
$discount_unit17 = $_POST["discount_unit17"];
$warranty17  = $_POST["warranty17"];
$cal17 = $_POST["cal17"];
$pm17 = $_POST["pm17"];


$product_id18 = $_POST["product_id18"];
$sale_count18 = $_POST["sale_count18"];
$product_price18 = $_POST["product_price18"];
$sale_remarkk18 = $_POST["sale_remarkk18"];
$sum_amountt18 = $_POST["sum_amount18"];
$sum_amount18 = str_replace(',','', $sum_amountt18);
$discount_unit18 = $_POST["discount_unit18"];
$warranty18  = $_POST["warranty18"];
$cal18 = $_POST["cal18"];
$pm18 = $_POST["pm18"];


$product_id19 = $_POST["product_id19"];
$sale_count19 = $_POST["sale_count19"];
$product_price19 = $_POST["product_price19"];
$sale_remarkk19 = $_POST["sale_remarkk19"];
$sum_amountt19 = $_POST["sum_amount19"];
$sum_amount19= str_replace(',','', $sum_amountt19);
$discount_unit19 = $_POST["discount_unit19"];
$warranty19  = $_POST["warranty19"];
$cal19 = $_POST["cal19"];
$pm19 = $_POST["pm19"];




$product_id20 = $_POST["product_id20"];
$sale_count20 = $_POST["sale_count20"];
$product_price20 = $_POST["product_price20"];
$sale_remarkk20 = $_POST["sale_remarkk20"];
$sum_amountt20 = $_POST["sum_amount20"];
$sum_amount20 = str_replace(',','', $sum_amountt20);
$discount_unit20 = $_POST["discount_unit20"];
$warranty20  = $_POST["warranty20"];
$cal20 = $_POST["cal20"];
$pm20 = $_POST["pm20"];


$product_id21 = $_POST["product_id21"];
$sale_count21 = $_POST["sale_count21"];
$product_price21 = $_POST["product_price21"];
$sale_remarkk21 = $_POST["sale_remarkk21"];
$sum_amountt21 = $_POST["sum_amount21"];
$sum_amount21 = str_replace(',','', $sum_amountt21);
$discount_unit21 = $_POST["discount_unit21"];
$warranty21  = $_POST["warranty21"];
$cal21 = $_POST["cal21"];
$pm21 = $_POST["pm21"];


$product_id22 = $_POST["product_id22"];
$sale_count22 = $_POST["sale_count22"];
$product_price22 = $_POST["product_price22"];
$sale_remarkk22 = $_POST["sale_remarkk22"];
$sum_amountt22 = $_POST["sum_amount22"];
$sum_amount22 = str_replace(',','', $sum_amountt22);
$discount_unit22 = $_POST["discount_unit22"];
$warranty22  = $_POST["warranty22"];
$cal22 = $_POST["cal22"];
$pm22 = $_POST["pm22"];


$product_id23 = $_POST["product_id23"];
$sale_count23 = $_POST["sale_count23"];
$product_price23 = $_POST["product_price23"];
$sale_remarkk23 = $_POST["sale_remarkk23"];
$sum_amountt23 = $_POST["sum_amount23"];
$sum_amount23 = str_replace(',','', $sum_amountt23);
$discount_unit23 = $_POST["discount_unit23"];
$warranty23  = $_POST["warranty23"];
$cal23 = $_POST["cal23"];
$pm23 = $_POST["pm23"];



$product_id24 = $_POST["product_id24"];
$sale_count24 = $_POST["sale_count24"];
$product_price24 = $_POST["product_price24"];
$sale_remarkk24 = $_POST["sale_remarkk24"];
$sum_amountt24 = $_POST["sum_amount24"];
$sum_amount24 = str_replace(',','', $sum_amountt24);
$discount_unit24 = $_POST["discount_unit24"];
$warranty24  = $_POST["warranty24"];
$cal24 = $_POST["cal24"];
$pm24 = $_POST["pm24"];


$product_id25 = $_POST["product_id25"];
$sale_count25 = $_POST["sale_count25"];
$product_price25 = $_POST["product_price25"];
$sale_remarkk25 = $_POST["sale_remarkk25"];
$sum_amountt25 = $_POST["sum_amount25"];
$sum_amount25 = str_replace(',','', $sum_amountt25);
$discount_unit25 = $_POST["discount_unit25"];
$warranty25  = $_POST["warranty25"];
$cal25 = $_POST["cal25"];
$pm25 = $_POST["pm25"];



$product_id26 = $_POST["product_id26"];
$sale_count26 = $_POST["sale_count26"];
$product_price26 = $_POST["product_price26"];
$sale_remarkk26 = $_POST["sale_remarkk26"];
$sum_amountt26 = $_POST["sum_amount26"];
$sum_amount26 = str_replace(',','', $sum_amountt26);
$discount_unit26 = $_POST["discount_unit26"];
$warranty26  = $_POST["warranty26"];
$cal26 = $_POST["cal26"];
$pm26 = $_POST["pm26"];


$product_id27 = $_POST["product_id27"];
$sale_count27 = $_POST["sale_count27"];
$product_price27 = $_POST["product_price27"];
$sale_remarkk27 = $_POST["sale_remark27"];
$sum_amountt27 = $_POST["sum_amount27"];
$sum_amount27 = str_replace(',','', $sum_amountt27);
$discount_unit27 = $_POST["discount_unit27"];
$warranty27  = $_POST["warranty27"];
$cal27 = $_POST["cal27"];
$pm27 = $_POST["pm27"];


$product_id28 = $_POST["product_id28"];
$sale_count28 = $_POST["sale_count28"];
$product_price28 = $_POST["product_price28"];
$sale_remarkk28 = $_POST["sale_remarkk28"];
$sum_amountt28 = $_POST["sum_amount28"];
$sum_amount28 = str_replace(',','', $sum_amountt28);
$discount_unit28 = $_POST["discount_unit28"];
$warranty28  = $_POST["warranty28"];
$cal28 = $_POST["cal28"];
$pm28 = $_POST["pm28"];


$product_id29 = $_POST["product_id29"];
$sale_count29 = $_POST["sale_count29"];
$product_price29 = $_POST["product_price29"];
$sale_remarkk29 = $_POST["sale_remarkk29"];
$sum_amountt29 = $_POST["sum_amount29"];
$sum_amount29 = str_replace(',','', $sum_amountt29);
$discount_unit29 = $_POST["discount_unit29"];
$warranty29  = $_POST["warranty29"];
$cal29 = $_POST["cal29"];
$pm29 = $_POST["pm29"];


$product_id30 = $_POST["product_id30"];
$sale_count30 = $_POST["sale_count30"];
$product_price30 = $_POST["product_price30"];
$sale_remarkk30 = $_POST["sale_remarkk30"];
$sum_amountt30 = $_POST["sum_amount30"];
$sum_amount30 = str_replace(',','', $sum_amountt30);
$discount_unit30 = $_POST["discount_unit30"];
$warranty30  = $_POST["warranty30"];
$cal30 = $_POST["cal30"];
$pm30 = $_POST["pm30"];







//แถวที่ 1

if($product_id1 !==''  ){
	
	$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code1."' ";
//echo $strSQL21;
//exit();
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];

	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_idb1."','".$product_idb1."','".$product_code1."','1','".$product_code1."')";


$objQuery104 = mysqli_query($conn,$strSQL104);
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count1."','".$sale_count1."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code1."')";



$objQuery100 = mysqli_query($conn,$strSQL100);
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count1."','".$sale_count1."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code1."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count1."','".$sale_count1."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code1."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	}
	
}else{
	
$strSQL1 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$discount_unit1."','".$warranty1."','".$cal1."','".$pm1."','".$product_id1."','".$product_id1."')";


$objQuery1 = mysqli_query($conn,$strSQL1);	
	
}	
}





//แถวที่ 2

if($product_id2 !==''  ){


	$strSQL32 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code2."' ";
//echo $strSQL21;
//exit();
$objQuery32 = mysqli_query($conn,$strSQL32) or die ("Error Query [".$strSQL32."]");
$Num_Rows32 = mysqli_num_rows($objQuery32);
$objResult32 = mysqli_fetch_array($objQuery32);

$product_ida1 =$objResult32["product_id1"];
$product_ida2 =$objResult32["product_id2"];
$product_ida3 =$objResult32["product_id3"];
$product_ida4 =$objResult32["product_id4"];

	
if($Num_Rows32 > 0){

	if($product_ida1!=''){
$strSQL105 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count2."','".$sale_count2."','".$product_price2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$product_ida1."','".$product_ida1."','".$product_code2."','1','".$product_code2."')";


$objQuery105 = mysqli_query($conn,$strSQL105);
	}
	
	if($product_ida2!=''){
		
$strSQL106 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count2."','".$sale_count2."','0.00','0.00','0.00','','0.00','0','0','0','".$product_ida2."','".$product_ida2."','1','".$product_code2."')";


//echo $strSQL100;

$objQuery106 = mysqli_query($conn,$strSQL106);
	}
	
	if($product_ida3!=''){
		
$strSQL107 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count2."','".$sale_count2."','0.00','0.00','0.00','','0.00','0','0','0','".$product_ida3."','".$product_ida3."','1','".$product_code2."')";

$objQuery107 = mysqli_query($conn,$strSQL107);
	}
	
	if($product_ida4!=''){
		
$strSQL108 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count2."','".$sale_count2."','0.00','0.00','0.00','','0.00','0','0','0','".$product_ida4."','".$product_ida4."','1','".$product_code2."')";

$objQuery108 = mysqli_query($conn,$strSQL108);
	}
	
}else{

$strSQL2 ="insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count2."','".$sale_count2."','".$product_price2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$discount_unit2."','".$warranty2."','".$cal2."','".$pm2."','".$product_id2."','".$product_id2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);

}
}







//แถวที่ 3

if($product_id3 !==''  ){

$strSQL33 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code3."' ";
$objQuery33 = mysqli_query($conn,$strSQL33) or die ("Error Query [".$strSQL33."]");
$Num_Rows33 = mysqli_num_rows($objQuery33);
$objResult33 = mysqli_fetch_array($objQuery33);

$product_idc1 =$objResult33["product_id1"];
$product_idc2 =$objResult33["product_id2"];
$product_idc3 =$objResult33["product_id3"];
$product_idc4 =$objResult33["product_id4"];

	
if($Num_Rows33 > 0){

	if($product_idc1!=''){
$strSQL109 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count3."','".$sale_count3."','".$product_price3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$product_idc1."','".$product_idc1."','".$product_code3."','1','".$product_code3."')";


$objQuery109 = mysqli_query($conn,$strSQL109);
	}
	
	if($product_idc2!=''){
		
$strSQL110 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count3."','".$sale_count3."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idc2."','".$product_idc2."','1','".$product_code3."')";


//echo $strSQL100;

$objQuery110 = mysqli_query($conn,$strSQL110);
	}
	
	if($product_idc3!=''){
		
$strSQL111 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count3."','".$sale_count3."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idc3."','".$product_idc3."','1','".$product_code3."')";

$objQuery111 = mysqli_query($conn,$strSQL111);
	}
	
	if($product_idc4!=''){
		
$strSQL112 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count3."','".$sale_count3."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idc4."','".$product_idc4."','1','".$product_code3."')";

$objQuery112 = mysqli_query($conn,$strSQL112);
	}
	
}else{


$strSQL3 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count3."','".$sale_count3."','".$product_price3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$discount_unit3."','".$warranty3."','".$cal3."','".$pm3."','".$product_id3."','".$product_id3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);

}
}


if($product_id4 !==''  ){


$strSQL34 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code4."' ";
$objQuery34 = mysqli_query($conn,$strSQL34) or die ("Error Query [".$strSQL34."]");
$Num_Rows34 = mysqli_num_rows($objQuery34);
$objResult34 = mysqli_fetch_array($objQuery34);

$product_idd1 =$objResult34["product_id1"];
$product_idd2 =$objResult34["product_id2"];
$product_idd3 =$objResult34["product_id3"];
$product_idd4 =$objResult34["product_id4"];

	
if($Num_Rows34 > 0){

	if($product_idd1!=''){

$strSQL113 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count4."','".$sale_count4."','".$product_price4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$product_idd1."','".$product_idd1."','".$product_code4."','1','".$product_code4."')";


$objQuery113 = mysqli_query($conn,$strSQL113);
	}
	
	if($product_idd2!=''){
		
$strSQL114 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count4."','".$sale_count4."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idd2."','".$product_idd2."','1','".$product_code4."')";


//echo $strSQL100;

$objQuery114 = mysqli_query($conn,$strSQL114);
	}
	
	if($product_idd3!=''){
		
$strSQL115 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count4."','".$sale_count4."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idd3."','".$product_idd3."','1','".$product_code4."')";

$objQuery115 = mysqli_query($conn,$strSQL115);
	}
	
	if($product_idd4!=''){
		
$strSQL116 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count4."','".$sale_count4."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idd4."','".$product_idd4."','1','".$product_code4."')";

$objQuery116 = mysqli_query($conn,$strSQL116);
	}
	
}else{



$strSQL4 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count4."','".$sale_count4."','".$product_price4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$discount_unit4."','".$warranty4."','".$cal4."','".$pm4."','".$product_id4."','".$product_id4."')";
//echo $strSQL1;
//exit();

$objQuery4 = mysqli_query($conn,$strSQL4);

}
}


if($product_id5 !==''  ){


$strSQL35 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code5."' ";
$objQuery35 = mysqli_query($conn,$strSQL35) or die ("Error Query [".$strSQL35."]");
$Num_Rows35 = mysqli_num_rows($objQuery35);
$objResult35 = mysqli_fetch_array($objQuery35);

$product_ide1 =$objResult35["product_id1"];
$product_ide2 =$objResult35["product_id2"];
$product_ide3 =$objResult35["product_id3"];
$product_ide4 =$objResult35["product_id4"];

	
if($Num_Rows35 > 0){

	if($product_ide1!=''){

$strSQL117 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count5."','".$sale_count5."','".$product_price5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$product_ide1."','".$product_ide1."','".$product_code5."','1','".$product_code5."')";


$objQuery117 = mysqli_query($conn,$strSQL117);
	}
	
	if($product_ide2!=''){
		
$strSQL118 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count5."','".$sale_count5."','0.00','0.00','0.00','','0.00','0','0','0','".$product_ide2."','".$product_ide2."','1','".$product_code5."')";


$objQuery118 = mysqli_query($conn,$strSQL118);
	}
	
	if($product_ide3!=''){
		
$strSQL119 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count5."','".$sale_count5."','0.00','0.00','0.00','','0.00','0','0','0','".$product_ide3."','".$product_ide3."','1','".$product_code5."')";

$objQuery119 = mysqli_query($conn,$strSQL119);
	}
	
	if($product_ide4!=''){
		
$strSQL120 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame)
values ('".$ref_id."','".$sale_count5."','".$sale_count5."','0.00','0.00','0.00','','0.00','0','0','0','".$product_ide4."','".$product_ide4."','1','".$product_code5."')";

$objQuery120 = mysqli_query($conn,$strSQL120);
	}
	
}else{



$strSQL5 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count5."','".$sale_count5."','".$product_price5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$discount_unit5."','".$warranty5."','".$cal5."','".$pm5."','".$product_id5."','".$product_id5."')";
//echo $strSQL1;
//exit();

$objQuery5 = mysqli_query($conn,$strSQL5);

}
}

if($product_id6 !==''  ){

$strSQL6 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."','".$product_id6."','".$product_id6."')";
//echo $strSQL1;
//exit();

$objQuery6 = mysqli_query($conn,$strSQL6);

}


if($product_id7 !==''  ){

$strSQL7 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."','".$product_id7."','".$product_id7."')";
//echo $strSQL1;
//exit();

$objQuery7 = mysqli_query($conn,$strSQL7);

}


if($product_id8 !==''  ){

$strSQL8 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."','".$product_id8."','".$product_id8."')";
//echo $strSQL1;
//exit();

$objQuery8 = mysqli_query($conn,$strSQL8);

}


if($product_id9 !==''  ){

$strSQL9 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."','".$product_id9."','".$product_id9."')";
//echo $strSQL1;
//exit();

$objQuery9 = mysqli_query($conn,$strSQL9);

}


if($product_id10 !==''  ){

$strSQL10 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."','".$product_id10."','".$product_id10."')";
//echo $strSQL1;
//exit();

$objQuery10 = mysqli_query($conn,$strSQL10);

}


////////////

if($product_id11 !==''  ){

$strSQL11 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count11."','".$sale_count11."','".$product_price11."','".$product_price11."','".$sum_amount11."','".$sale_remarkk11."','".$discount_unit11."','".$warranty11."','".$cal11."','".$pm11."','".$product_id11."','".$product_id11."')";
//echo $strSQL1;
//exit();

$objQuery11 = mysqli_query($conn,$strSQL11);

}

if($product_id12 !==''  ){

$strSQL12 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count12."','".$sale_count12."','".$product_price12."','".$product_price12."','".$sum_amount12."','".$sale_remarkk12."','".$discount_unit12."','".$warranty12."','".$cal12."','".$pm12."','".$product_id12."','".$product_id12."')";
//echo $strSQL1;
//exit();

$objQuery12 = mysqli_query($conn,$strSQL12);

}

if($product_id13 !==''  ){

$strSQL13 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count13."','".$sale_count13."','".$product_price13."','".$product_price13."','".$sum_amount13."','".$sale_remarkk13."','".$discount_unit13."','".$warranty13."','".$cal13."','".$pm13."','".$product_id13."','".$product_id13."')";
//echo $strSQL1;
//exit();

$objQuery13 = mysqli_query($conn,$strSQL13);

}

if($product_id14 !==''  ){

$strSQL14 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count14."','".$sale_count14."','".$product_price14."','".$product_price14."','".$sum_amount14."','".$sale_remarkk14."','".$discount_unit14."','".$warranty14."','".$cal14."','".$pm14."','".$product_id14."','".$product_id14."')";
//echo $strSQL1;
//exit();

$objQuery14 = mysqli_query($conn,$strSQL14);

}

if($product_id15 !==''  ){

$strSQL15 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count15."','".$sale_count15."','".$product_price15."','".$product_price15."','".$sum_amount15."','".$sale_remarkk15."','".$discount_unit15."','".$warranty15."','".$cal15."','".$pm15."','".$product_id15."','".$product_id15."')";
//echo $strSQL1;
//exit();

$objQuery15 = mysqli_query($conn,$strSQL15);

}



if($product_id16 !==''  ){

$strSQL16 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count16."','".$sale_count16."','".$product_price16."','".$product_price16."','".$sum_amount16."','".$sale_remarkk16."','".$discount_unit16."','".$warranty16."','".$cal16."','".$pm16."','".$product_id16."','".$product_id16."')";
//echo $strSQL1;
//exit();

$objQuery16 = mysqli_query($conn,$strSQL16);

}


if($product_id17 !==''  ){

$strSQL17 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count17."','".$sale_count17."','".$product_price17."','".$product_price17."','".$sum_amount17."','".$sale_remarkk17."','".$discount_unit17."','".$warranty17."','".$cal17."','".$pm17."','".$product_id17."','".$product_id17."')";
//echo $strSQL2;
//exit();

$objQuery17 = mysqli_query($conn,$strSQL17);

}


if($product_id18 !==''  ){

$strSQL18 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count18."','".$sale_count18."','".$product_price18."','".$product_price18."','".$sum_amount18."','".$sale_remarkk18."','".$discount_unit18."','".$warranty18."','".$cal18."','".$pm18."','".$product_id18."','".$product_id18."')";
//echo $strSQL3;
//exit();

$objQuery18 = mysqli_query($conn,$strSQL18);

}


if($product_id19 !==''  ){

$strSQL19 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count19."','".$sale_count19."','".$product_price19."','".$product_price19."','".$sum_amount19."','".$sale_remarkk19."','".$discount_unit19."','".$warranty19."','".$cal19."','".$pm19."','".$product_id19."','".$product_id19."')";
//echo $strSQL1;
//exit();

$objQuery19 = mysqli_query($conn,$strSQL19);

}


if($product_id20 !==''  ){

$strSQL20 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count20."','".$sale_count20."','".$product_price20."','".$product_price20."','".$sum_amount20."','".$sale_remarkk20."','".$discount_unit20."','".$warranty20."','".$cal20."','".$pm20."','".$product_id20."','".$product_id20."')";
//echo $strSQL1;
//exit();

$objQuery20 = mysqli_query($conn,$strSQL20);

}


if($product_id21 !==''  ){

$strSQL21 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count21."','".$sale_count21."','".$product_price21."','".$product_price21."','".$sum_amount21."','".$sale_remarkk21."','".$discount_unit21."','".$warranty21."','".$cal21."','".$pm21."','".$product_id21."','".$product_id21."')";
//echo $strSQL1;
//exit();

$objQuery21 = mysqli_query($conn,$strSQL21);

}


if($product_id22 !==''  ){

$strSQL22 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count22."','".$sale_count22."','".$product_price22."','".$product_price22."','".$sum_amount22."','".$sale_remarkk22."','".$discount_unit22."','".$warranty22."','".$cal22."','".$pm22."','".$product_id22."','".$product_id22."')";
//echo $strSQL1;
//exit();

$objQuery22 = mysqli_query($conn,$strSQL22);

}


if($product_id23 !==''  ){

$strSQL23 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count23."','".$sale_count23."','".$product_price23."','".$product_price23."','".$sum_amount23."','".$sale_remarkk23."','".$discount_unit23."','".$warranty23."','".$cal23."','".$pm23."','".$product_id23."','".$product_id23."')";
//echo $strSQL1;
//exit();

$objQuery23 = mysqli_query($conn,$strSQL23);

}


if($product_id24 !==''  ){

$strSQL24 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count24."','".$sale_count24."','".$product_price24."','".$product_price24."','".$sum_amount24."','".$sale_remarkk24."','".$discount_unit24."','".$warranty24."','".$cal24."','".$pm24."','".$product_id24."','".$product_id24."')";
//echo $strSQL1;
//exit();

$objQuery24 = mysqli_query($conn,$strSQL24);

}


if($product_id25 !==''  ){

$strSQL25 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count25."','".$sale_count25."','".$product_price25."','".$product_price25."','".$sum_amount25."','".$sale_remarkk25."','".$discount_unit25."','".$warranty25."','".$cal25."','".$pm25."','".$product_id25."','".$product_id25."')";
//echo $strSQL1;
//exit();

$objQuery25 = mysqli_query($conn,$strSQL25);

}


////////////

if($product_id26 !==''  ){

$strSQL26 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count26."','".$sale_count26."','".$product_price26."','".$product_price26."','".$sum_amount26."','".$sale_remarkk26."','".$discount_unit26."','".$warranty26."','".$cal26."','".$pm26."','".$product_id26."','".$product_id26."')";
//echo $strSQL1;
//exit();

$objQuery26 = mysqli_query($conn,$strSQL26);

}

if($product_id27 !==''  ){

$strSQL27 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count27."','".$sale_count27."','".$product_price27."','".$product_price27."','".$sum_amount27."','".$sale_remarkk27."','".$discount_unit27."','".$warranty27."','".$cal27."','".$pm27."','".$product_id27."','".$product_id27."')";
//echo $strSQL1;
//exit();

$objQuery27 = mysqli_query($conn,$strSQL27);

}

if($product_id28 !==''  ){

$strSQL28 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count28."','".$sale_count28."','".$product_price28."','".$product_price28."','".$sum_amount28."','".$sale_remarkk28."','".$discount_unit28."','".$warranty28."','".$cal28."','".$pm28."','".$product_id28."','".$product_id28."')";
//echo $strSQL1;
//exit();

$objQuery28 = mysqli_query($conn,$strSQL28);

}

if($product_id29 !==''  ){

$strSQL29 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count29."','".$sale_count29."','".$product_price29."','".$product_price29."','".$sum_amount29."','".$sale_remarkk29."','".$discount_unit29."','".$warranty29."','".$cal29."','".$pm29."','".$product_id29."','".$product_id29."')";
//echo $strSQL1;
//exit();

$objQuery29 = mysqli_query($conn,$strSQL29);

}

if($product_id30 !==''  ){

$strSQL30 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('".$ref_id."','".$sale_count30."','".$sale_count30."','".$product_price30."','".$product_price30."','".$sum_amount30."','".$sale_remarkk30."','".$discount_unit30."','".$warranty30."','".$cal30."','".$pm30."','".$product_id30."','".$product_id30."')";
//echo $strSQL1;
//exit();

$objQuery30 = mysqli_query($conn,$strSQL30);

}*/



 $start_date =$_POST["start_date"];
 $status_comment = $_POST["status_comment"];
 $between_date =$_POST["between_date"];
 $start_time=$_POST["start_time"];
 $end_time=$_POST["end_time"];
 $status=$_POST["status"];
	
 if ($_POST["start_date"]!=''){
		$start_date =$_POST["start_date"];
	}else{
		$start_date='0000-00-00';
	}
	
	if ($_POST['fix_datetime']!=''){
		$fix_date=$_POST['fix_datetime'];
	}else{
		$fix_date='0';
	}
	
	if ($_POST['no_money']!=''){
        $no_price=$_POST['no_money'];
	}else{
		$no_price='0';
	}
	if ($_POST['call_customer']!=''){
		 $call_customer=$_POST['call_customer'];
	}else{
		$call_customer='0';
	}
	if ($_POST['credit_card']!=''){
		 $credit=$_POST['credit_card'];
	}else{
		$credit='0';
	}
	if ($_POST['call_back']!=''){
		 $call_employee=$_POST['call_back'];
	}else{
		$call_employee='0';
	}
	
	if ($_POST['cash']!=''){
		 $chash=$_POST['cash'];
	}else{
		$chash='0';
	}
	if ($_POST['check_paper']!=''){
	 $check_peper=$_POST['check_paper'];
	}else{
		$check_peper='0';
	}
	if ($_POST['check_paper']!=''){
		$check_peper=$_POST['check_paper'];
	}else{
		$check_peper='0';
	}
	if ($_POST['bill']!=''){
		 $bill=$_POST['bill'];
	}else{
		$bill='0';
	}
	if ($_POST['want_bus']!=''){
	$want_bus=$_POST['want_bus'];
	}else{
		$want_bus='0';
	}
	if ($_POST['tran']!=''){
		 $tran=$_POST["tran"];
	}else{
		$tran='0';
	}
	if ($_POST['more']!=''){
		 $check_detail=$_POST["more"];
	}else{
		$check_detail='0';
	}
	
		if ($_POST['dep']!=''){
		  $dep=$_POST["dep"];
	}else{
		$dep='0';
	}

	
 $department=$_POST["department_name"];
 $type_customer=$_POST["customer_typename"];
 $type_company=$_POST["company_name"];
 $customer_name=$_POST["customer_name"];
 $customer_tel=$_POST["customer_tel"];
 $address_name=$_POST["address_name"];
 $address_send=$_POST["address_send"];
$customer_contact =$_POST["customer_contact"];
	
 $on_time =$_POST["on_time"];	
 $amphur_name=$_POST["amphur_name"];
 $province_name=$_POST["province_name"];
 $product_name=$_POST["product"];
 $product_sn=$_POST["product_sn"];
 $unit_credit=$_POST["unit_credit"];
 $price=$_POST["unit_cash"];
 $employee_name=$_POST["employee_name"];
	 $h_employee_name=$_POST["h_employee_name"];
 $employee_tel=$_POST["employee_tel"];
 $add_by=$_POST["add_by"];
 $description=$_POST["description"];
 $havemap=$_POST['have_map'];
$unit_check=$_POST["unit_check"];
$unit_bill=$_POST["unit_bill"];
$unit_tran=$_POST["unit_tran"];
$department_show = $_POST["department_show"];
$unit_check1 = str_replace(',', '', $unit_check);
$unit_bill1 = str_replace(',', '', $unit_bill);
$dept =$_POST["dept"];
$address_1=$_POST["address_1"];
$mk_research =$_POST["mk_research"];
	

$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,address_1,add_code,mk_research) 

values('".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$address_1."','".$h_employee_name."','".$mk_research."')";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());




if ($type_doc=='3'){
		$com ="ฟาร์ ทริลเลี่ยน บจก.";
	}else if ($type_doc=='4'){
	$com="โนเบิล เมด บจก.";	
	}
	
	
if($payment =='1'){
$cash = '5';	
}else if($payment =='8'){
	$cash = '22';
}else  if($payment =='21'){
	$cash = '7';
}
	
	

	if($payment=='1' or $payment =='8' or $payment =='21'){
		
$strSQL29 = "SELECT SUM(amount) AS unit_cash FROM hos__subso WHERE ref_idd = '".$ref_id."' ";
$objQuery29 = mysqli_query($conn,$strSQL29) or die ("Error Query [".$strSQL29."]");
$rs = mysqli_fetch_assoc($objQuery29);
if($payment=='2' or $payment=='3' or $payment=='4' or $payment=='5' ){
$unit_cash = "0.00";
}else{
$unit_cash = $rs["unit_cash"];
}
		

	
$strSQL292="insert into   tb_register_data (IV_number,date_inv,company,customer_name,date_tranfer,employee_name,credit,cash,unit_cash,description,ref_id,between_dateinv) values ('".$iv_no."','".$start_date."','".$com."','".$bill_name."','".$date_tranfer ."','".$sale."','".$credit."','$cash','".$unit_cash."','".$payment_des."','".$ref_id."','".$date_send_key."')";

$objQuery292 = mysqli_query($code,$strSQL292);	
			

$strSQL262="Update  hos__so set send_receipt ='2'  where ref_id='".$ref_id."'";
$objQuery262 = mysqli_query($conn,$strSQL262);		

	}






	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_suphos_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}