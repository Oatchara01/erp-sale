0<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$company = $_POST["company"];
$date_br = $_POST["date_br"];
$customer = $_POST["customer"];
$customer_id = $_POST["customer_id"];
$address = $_POST["address"];
$sale_comment = $_POST["sale_comment"];
$clear_book_ckk = $_POST["clear_book_ckk"];
$clear_book_no = $_POST["clear_book_no"];
$clear_brn_no_ckk = $_POST["clear_brn_no_ckk"];
$clear_brn_no = $_POST["clear_brn_no"];
$clear_brnp_no_ckk = $_POST["clear_brnp_no_ckk"];
$clear_brnp_no = $_POST["clear_brnp_no"];
$sn_ckk = $_POST["sn_ckk"];
$sn = $_POST["sn"];
$objective = $_POST["objective"];
$objective_des1 = $_POST["objective_des1"];
$objective_des2 = $_POST["objective_des2"];
$objective_des4 = $_POST["objective_des4"];
$objective_des5 = $_POST["objective_des5"];
$return_date_bet = $_POST["return_date_bet"];
$returns = $_POST["returns"];
$returns_date = $_POST["returns_date"];
$returns_time = $_POST["returns_time"];
$returns_name = $_POST["returns_name"];
$returns_address = $_POST["returns_address"];
$returns_contact = $_POST["return_contact"];
$status_doc = "Approve";
$delivery_name = $_POST["address_name"];
$delivery_type = $_POST["delivery_type"];
$delivery_date = $_POST["start_date"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$delivery_time = "$start_time $end_time";
$delivery_address = $_POST["address_send"];
$delivery_contact = $_POST["customer_contact"];
$delivery_tel = $_POST["customer_tel"];
$date_send_key  = $_POST["between_date"];
$sale_code = $_POST["sale_code"];


$sale_date= date('Y-m-d');
$approve_date= date('Y-m-d');
$admin_date= date('Y-m-d');

$sale =  $_SESSION['name'];
$admin =  $_SESSION['name'];
$admin_code	= $_SESSION['code'];

  if($sale_code=='S11' or $sale_code=='S12' or $sale_code=='S13' or $sale_code=='S14'  or $sale_code=='S24'){
$approve_code = 'SS2';
$approve  = 'นรินทิพย์';
  }else if ($sale_code=='S15' or $sale_code=='S22' or $sale_code=='S21' or $sale_code=='S51') {

$approve_code = 'SS1';
$approve  = 'พรรณิภา';
  }else if ($sale_code=='S16' or $sale_code=='S17' or $sale_code=='SM1'  or $sale_code=='S23') {

$approve_code = 'SM1';
$approve  = 'ลักษณาวรรณ';


  }else if ($sale_code=='S31' or $sale_code=='MM1') {
$approve_code = 'SS3';
$approve  = 'มาลินี';

  }else if ($sale_code=='EN' or $sale_code=='EN2' or $sale_code=='EN3' or $sale_code=='EN4' or $sale_code=='EN5' or $sale_code=='EN6' or $sale_code=='EN7' or $sale_code=='EN8') {
$approve_code = 'SUP_EN';
$approve  = 'บรรเทิง';

  }

$iv_no = $_POST["iv_no"];
$iv_date = $_POST["iv_date"];
$dep_no  = $_POST["dep_no"];
$job_no  = $_POST["job_no"];

$approve_time = date("H:i:s");
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";

move_uploaded_file($_FILES['slip1']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip1']['name']));
	move_uploaded_file($_FILES['slip2']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip2']['name']));
	move_uploaded_file($_FILES['slip3']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip3']['name']));
	move_uploaded_file($_FILES['slip4']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip4']['name']));
	move_uploaded_file($_FILES['slip5']['tmp_name'],"upload/".iconv("UTF-8", "TIS-620",$_FILES['slip5']['name']));

	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id_br) AS MAXID FROM hos__br ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = substr($rs['MAXID'], -5);
$maxId3 = substr($rs['MAXID'],-9);

$maxId1 = substr($maxId3,0,-5);

$so = "BR";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -5);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "00001"; 
$nextId = $yearMonth.$maxId1;

}


$so = "BR";
$ref_id_br ="$so$nextId";






$save="insert into hos__br
(company,ref_id_br,date_br,customer,customer_id,address,sale_comment,clear_book_ckk,clear_book_no,clear_brn_no_ckk,clear_brn_no,clear_brnp_no_ckk,clear_brnp_no,sn_ckk,sn,objective,objective_des1,objective_des2,objective_des4,objective_des5,returns,returns_date,returns_time,returns_name,returns_address,returns_contact,status_doc,delivery_name,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,date_send_key,sale_date,sale,sale_code,add_date,add_by,approve_date,approve,approve_code,iv_no,iv_date,job_no,dep_no,admin,admin_code,admin_date,send_sup,send_admin,return_date_bet,slip1,slip2,slip3,slip4,slip5,approve_time)
values
('".$company."','".$ref_id_br."','".$date_br."','".$customer."','".$customer_id."','".$address."','".$sale_comment."','".$clear_book_ckk."','".$clear_book_no."','".$clear_brn_no_ckk."','".$clear_brn_no."','".$clear_brnp_no_ckk."','".$clear_brnp_no."','".$sn_ckk."','".$sn."','".$objective."','".$objective_des1."','".$objective_des2."','".$objective_des4."','".$objective_des5."','".$returns."','".$returns_date."','".$returns_time."','".$returns_name."','".$returns_address."','".$returns_contact."','".$status_doc."','".$delivery_name."','".$delivery_type."','".$delivery_date."','".$delivery_time."','".$delivery_address."','".$delivery_contact."','".$delivery_tel."','".$date_send_key."','".$sale_date."','".$sale."','".$sale_code."','".$add_date."','".$add_by."','".$approve_date."','".$approve."','".$approve_code."','".$iv_no."','".$iv_date."','".$job_no."','".$dep_no."','".$admin."','".$admin_code."','".$admin_date."','1','1','".$return_date_bet."','".$slip1."','".$slip2."','".$slip3."','".$slip4."','".$slip5."','".$approve_time."')";


$qsave=mysqli_query($conn,$save);

/*$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$sale_remarkk1 = $_POST["sale_remarkk1"];
$sum_amountt = $_POST["sum_amount1"];
$sum_amount1= str_replace(',','', $sum_amountt);




$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$sale_remarkk2 = $_POST["sale_remarkk2"];
$sum_amountt2 = $_POST["sum_amount2"];
$sum_amount2= str_replace(',','', $sum_amountt2);


$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$sale_remarkk3 = $_POST["sale_remarkk3"];
$sum_amountt3 = $_POST["sum_amount3"];
$sum_amount3= str_replace(',','', $sum_amountt3);


$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$sale_remarkk4 = $_POST["sale_remarkk4"];
$sum_amountt4 = $_POST["sum_amount4"];
$sum_amount4= str_replace(',','', $sum_amountt4);




$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$sale_remarkk5 = $_POST["sale_remarkk5"];
$sum_amountt5 = $_POST["sum_amount5"];
$sum_amount5= str_replace(',','', $sum_amountt5);


$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);


$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);


$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);



$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);


$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);



$product_id11 = $_POST["product_id11"];
$sale_count11 = $_POST["sale_count11"];
$product_price11 = $_POST["product_price11"];
$sale_remarkk11 = $_POST["sale_remarkk11"];
$sum_amountt11 = $_POST["sum_amount11"];
$sum_amount11= str_replace(',','', $sum_amountt11);


$product_id12 = $_POST["product_id12"];
$sale_count12 = $_POST["sale_count12"];
$product_price12 = $_POST["product_price12"];
$sale_remarkk12 = $_POST["sale_remarkk12"];
$sum_amountt12 = $_POST["sum_amount12"];
$sum_amount12= str_replace(',','', $sum_amountt12);


$product_id13 = $_POST["product_id13"];
$sale_count13 = $_POST["sale_count13"];
$product_price13 = $_POST["product_price13"];
$sale_remarkk13 = $_POST["sale_remarkk13"];
$sum_amountt13 = $_POST["sum_amount13"];
$sum_amount13= str_replace(',','', $sum_amountt13);


$product_id14 = $_POST["product_id14"];
$sale_count14 = $_POST["sale_count14"];
$product_price14 = $_POST["product_price14"];
$sale_remarkk14 = $_POST["sale_remarkk14"];
$sum_amountt14 = $_POST["sum_amount14"];
$sum_amount14= str_replace(',','', $sum_amountt14);


$product_id15 = $_POST["product_id15"];
$sale_count15 = $_POST["sale_count15"];
$product_price15 = $_POST["product_price15"];
$sale_remarkk15 = $_POST["sale_remarkk15"];
$sum_amountt15 = $_POST["sum_amount15"];
$sum_amount15= str_replace(',','', $sum_amountt15);



$product_id16 = $_POST["product_id16"];
$sale_count16 = $_POST["sale_count16"];
$product_price16 = $_POST["product_price16"];
$sale_remarkk16 = $_POST["sale_remarkk16"];
$sum_amountt16 = $_POST["sum_amount16"];
$sum_amount16= str_replace(',','', $sum_amountt16);




$product_id17 = $_POST["product_id17"];
$sale_count17 = $_POST["sale_count17"];
$product_price17 = $_POST["product_price17"];
$sale_remarkk17 = $_POST["sale_remarkk17"];
$sum_amountt17 = $_POST["sum_amount17"];
$sum_amount17= str_replace(',','', $sum_amountt17);


$product_id18 = $_POST["product_id18"];
$sale_count18 = $_POST["sale_count18"];
$product_price18 = $_POST["product_price18"];
$sale_remarkk18 = $_POST["sale_remarkk18"];
$sum_amountt18 = $_POST["sum_amount18"];
$sum_amount18 = str_replace(',','', $sum_amountt18);


$product_id19 = $_POST["product_id19"];
$sale_count19 = $_POST["sale_count19"];
$product_price19 = $_POST["product_price19"];
$sale_remarkk19 = $_POST["sale_remarkk19"];
$sum_amountt19 = $_POST["sum_amount19"];
$sum_amount19= str_replace(',','', $sum_amountt19);




$product_id20 = $_POST["product_id20"];
$sale_count20 = $_POST["sale_count20"];
$product_price20 = $_POST["product_price20"];
$sale_remarkk20 = $_POST["sale_remarkk20"];
$sum_amountt20 = $_POST["sum_amount20"];
$sum_amount20 = str_replace(',','', $sum_amountt20);


$product_id21 = $_POST["product_id21"];
$sale_count21 = $_POST["sale_count21"];
$product_price21 = $_POST["product_price21"];
$sale_remarkk21 = $_POST["sale_remarkk21"];
$sum_amountt21 = $_POST["sum_amount21"];
$sum_amount21 = str_replace(',','', $sum_amountt21);


$product_id22 = $_POST["product_id22"];
$sale_count22 = $_POST["sale_count22"];
$product_price22 = $_POST["product_price22"];
$sale_remarkk22 = $_POST["sale_remarkk22"];
$sum_amountt22 = $_POST["sum_amount22"];
$sum_amount22 = str_replace(',','', $sum_amountt22);


$product_id23 = $_POST["product_id23"];
$sale_count23 = $_POST["sale_count23"];
$product_price23 = $_POST["product_price23"];
$sale_remarkk23 = $_POST["sale_remarkk23"];
$sum_amountt23 = $_POST["sum_amount23"];
$sum_amount23 = str_replace(',','', $sum_amountt23);



$product_id24 = $_POST["product_id24"];
$sale_count24 = $_POST["sale_count24"];
$product_price24 = $_POST["product_price24"];
$sale_remarkk24 = $_POST["sale_remarkk24"];
$sum_amountt24 = $_POST["sum_amount24"];
$sum_amount24 = str_replace(',','', $sum_amountt24);


$product_id25 = $_POST["product_id25"];
$sale_count25 = $_POST["sale_count25"];
$product_price25 = $_POST["product_price25"];
$sale_remarkk25 = $_POST["sale_remarkk25"];
$sum_amountt25 = $_POST["sum_amount25"];
$sum_amount25 = str_replace(',','', $sum_amountt25);



$product_id26 = $_POST["product_id26"];
$sale_count26 = $_POST["sale_count26"];
$product_price26 = $_POST["product_price26"];
$sale_remarkk26 = $_POST["sale_remarkk26"];
$sum_amountt26 = $_POST["sum_amount26"];
$sum_amount26 = str_replace(',','', $sum_amountt26);


$product_id27 = $_POST["product_id27"];
$sale_count27 = $_POST["sale_count27"];
$product_price27 = $_POST["product_price27"];
$sale_remarkk27 = $_POST["sale_remark27"];
$sum_amountt27 = $_POST["sum_amount27"];
$sum_amount27 = str_replace(',','', $sum_amountt27);


$product_id28 = $_POST["product_id28"];
$sale_count28 = $_POST["sale_count28"];
$product_price28 = $_POST["product_price28"];
$sale_remarkk28 = $_POST["sale_remarkk28"];
$sum_amountt28 = $_POST["sum_amount28"];
$sum_amount28 = str_replace(',','', $sum_amountt28);


$product_id29 = $_POST["product_id29"];
$sale_count29 = $_POST["sale_count29"];
$product_price29 = $_POST["product_price29"];
$sale_remarkk29 = $_POST["sale_remarkk29"];
$sum_amountt29 = $_POST["sum_amount29"];
$sum_amount29 = str_replace(',','', $sum_amountt29);


$product_id30 = $_POST["product_id30"];
$sale_count30 = $_POST["sale_count30"];
$product_price30 = $_POST["product_price30"];
$sale_remarkk30 = $_POST["sale_remarkk30"];
$sum_amountt30 = $_POST["sum_amount30"];
$sum_amount30 = str_replace(',','', $sum_amountt30);







if($product_id1 !==''  ){

$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count1."','".$sale_count1."','".$product_price1."','".$sum_amount1."','".$sale_remarkk1."','".$product_id1."','".$product_id1."')";


$objQuery1 = mysqli_query($conn,$strSQL1);

}


if($product_id2 !==''  ){

$strSQL2 ="insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count2."','".$sale_count2."','".$product_price2."','".$sum_amount2."','".$sale_remarkk2."','".$product_id2."','".$product_id2."')";


$objQuery2 = mysqli_query($conn,$strSQL2);

}


if($product_id3 !==''  ){

$strSQL3 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count3."','".$sale_count3."','".$product_price3."','".$sum_amount3."','".$sale_remarkk3."','".$product_id3."','".$product_id3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);

}


if($product_id4 !==''  ){

$strSQL4 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count4."','".$sale_count4."','".$product_price4."','".$sum_amount4."','".$sale_remarkk4."','".$product_id4."','".$product_id4."')";
//echo $strSQL1;
//exit();

$objQuery4 = mysqli_query($conn,$strSQL4);

}


if($product_id5 !==''  ){

$strSQL5 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count5."','".$sale_count5."','".$product_price5."','".$sum_amount5."','".$sale_remarkk5."','".$product_id5."','".$product_id5."')";
//echo $strSQL1;
//exit();

$objQuery5 = mysqli_query($conn,$strSQL5);

}


if($product_id6 !==''  ){

$strSQL6 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$product_id6."','".$product_id6."')";
//echo $strSQL1;
//exit();

$objQuery6 = mysqli_query($conn,$strSQL6);

}


if($product_id7 !==''  ){

$strSQL7 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$product_id7."','".$product_id7."')";
//echo $strSQL1;
//exit();

$objQuery7 = mysqli_query($conn,$strSQL7);

}


if($product_id8 !==''  ){

$strSQL8 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$product_id8."','".$product_id8."')";
//echo $strSQL1;
//exit();

$objQuery8 = mysqli_query($conn,$strSQL8);

}


if($product_id9 !==''  ){

$strSQL9 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$product_id9."','".$product_id9."')";
//echo $strSQL1;
//exit();

$objQuery9 = mysqli_query($conn,$strSQL9);

}


if($product_id10 !==''  ){

$strSQL10 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$product_id10."','".$product_id10."')";
//echo $strSQL1;
//exit();

$objQuery10 = mysqli_query($conn,$strSQL10);

}


////////////

if($product_id11 !==''  ){

$strSQL11 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count11."','".$sale_count11."','".$product_price11."','".$sum_amount11."','".$sale_remarkk11."','".$product_id11."','".$product_id11."')";
//echo $strSQL1;
//exit();

$objQuery11 = mysqli_query($conn,$strSQL11);

}

if($product_id12 !==''  ){

$strSQL12 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count12."','".$sale_count12."','".$product_price12."','".$sum_amount12."','".$sale_remarkk12."','".$product_id12."','".$product_id12."')";
//echo $strSQL1;
//exit();

$objQuery12 = mysqli_query($conn,$strSQL12);

}

if($product_id13 !==''  ){

$strSQL13 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count13."','".$sale_count13."','".$product_price13."','".$sum_amount13."','".$sale_remarkk13."','".$product_id13."','".$product_id13."')";
//echo $strSQL1;
//exit();

$objQuery13 = mysqli_query($conn,$strSQL13);

}

if($product_id14 !==''  ){

$strSQL14 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count14."','".$sale_count14."','".$product_price14."','".$sum_amount14."','".$sale_remarkk14."','".$product_id14."','".$product_id14."')";
//echo $strSQL1;
//exit();

$objQuery14 = mysqli_query($conn,$strSQL14);

}

if($product_id15 !==''  ){

$strSQL15 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count15."','".$sale_count15."','".$product_price15."','".$sum_amount15."','".$sale_remarkk15."','".$product_id15."','".$product_id15."')";
//echo $strSQL1;
//exit();

$objQuery15 = mysqli_query($conn,$strSQL15);

}

*/




 $start_date =$_POST["start_date"];

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
$status_comment =$_POST["status_comment"];
$address_1  =$_POST["address_1"];
$h_employee_name =$_POST["$h_employee_name"];
	
	
$strSQL66 =  "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,address_1,add_code) 

values('".$ref_id_br."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$address_1."','".$h_employee_name."')";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());










	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminbrhos_edit.php?ref_id_br=$ref_id_br';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


