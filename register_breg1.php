<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$type_doc = $_POST["type_doc"];
$register_date = $_POST["register_date"];
$bill_id = $_POST["bill_id"];
$customer_name = $_POST["customer_name"];
$description = $_POST["description"];
$per_no = $_POST["per_no"];
$cm_no = $_POST["cm_no"];

$sale_code = $_SESSION['code'];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__breg";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);
$maxId1 = substr($maxId3,0,-4);

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
$so = "RG";
$ref_id ="$so$nextId";	
	
	


$save="insert into hos__breg
(ref_id,type_doc,register_date,add_by,add_date,bill_id,customer_name,description,per_no,cm_no,sale_code)
values
('".$ref_id."','".$type_doc."','".$register_date."','".$add_by."','".$add_date."','".$bill_id."','".$customer_name."','".$description."','".$per_no."','".$cm_no."','".$sale_code."')";

$qsave=mysqli_query($conn,$save);

	

	
$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$sn_number1 = $_POST["sn_number1"];
$remark_eng1 = $_POST["remark_eng1"];

$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$sn_number2 = $_POST["sn_number2"];
$remark_eng2 = $_POST["remark_eng2"];

$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$sn_number3 = $_POST["sn_number3"];
$remark_eng3 = $_POST["remark_eng3"];

$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$sn_number4 = $_POST["sn_number4"];
$remark_eng4 = $_POST["remark_eng4"];

$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$sn_number5 = $_POST["sn_number5"];
$remark_eng5 = $_POST["remark_eng5"];

$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$sn_number6 = $_POST["sn_number6"];
$remark_eng6 = $_POST["remark_eng6"];

$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$sn_number7 = $_POST["sn_number7"];
$remark_eng7 = $_POST["remark_eng7"];

$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$sn_number8 = $_POST["sn_number8"];
$remark_eng8 = $_POST["remark_eng8"];

$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$sn_number9 = $_POST["sn_number9"];
$remark_eng9 = $_POST["remark_eng9"];

$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$sn_number10 = $_POST["sn_number10"];
$remark_eng10 = $_POST["remark_eng10"];

	

if($product_id1 !=='' ){

$strSQL1 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id1."','".$product_id1."','".$sale_count1."','".$remark_eng1."','".$sn_number1."')";
$objQuery1 = mysqli_query($conn,$strSQL1);
}
	

if($product_id2 !=''  ){

$strSQL2 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id2."','".$product_id2."','".$sale_count2."','".$remark_eng2."','".$sn_number2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
}
	

if($product_id3 !=''  ){

$strSQL3 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id3."','".$product_id3."','".$sale_count3."','".$remark_eng3."','".$sn_number3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);
}
	

if($product_id4 !=''  ){

$strSQL4 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id4."','".$product_id4."','".$sale_count4."','".$remark_eng4."','".$sn_number4."')";

$objQuery4 = mysqli_query($conn,$strSQL4);
}
	

if($product_id5 !==''  ){

$strSQL5 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id5."','".$product_id5."','".$sale_count5."','".$remark_eng5."','".$sn_number5."')";

$objQuery5 = mysqli_query($conn,$strSQL5);
}
	

if($product_id6 !==''  ){

$strSQL6 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id6."','".$product_id6."','".$sale_count6."','".$remark_eng6."','".$sn_number6."')";

$objQuery6 = mysqli_query($conn,$strSQL6);
}
	

if($product_id7 !==''  ){

$strSQL7 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id7."','".$product_id7."','".$sale_count7."','".$remark_eng7."','".$sn_number7."')";

$objQuery7 = mysqli_query($conn,$strSQL7);
}
	

if($product_id8 !==''  ){

$strSQL8 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id8."','".$product_id8."','".$sale_count8."','".$remark_eng8."','".$sn_number8."')";

$objQuery8 = mysqli_query($conn,$strSQL8);
}
	

if($product_id9 !==''  ){

$strSQL9 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id9."','".$product_id9."','".$sale_count9."','".$remark_eng9."','".$sn_number9."')";

$objQuery9 = mysqli_query($conn,$strSQL9);
}
	

if($product_id10 !==''  ){

$strSQL10 = "insert into hos__subbreg1
(ref_id1,product_id1,product_code1,count1,remark_eng1,sn_number1)
values ('".$ref_id."','".$product_id10."','".$product_id10."','".$sale_count10."','".$remark_eng10."','".$sn_number10."')";

$objQuery10 = mysqli_query($conn,$strSQL10);
}
	


$product_id_1 = $_POST["product_id_1"];
$sale_count_1 = $_POST["sale_count_1"];
$sn_number_1 = $_POST["sn_number_1"];
$remark_eng_1 = $_POST["remark_eng_1"];
$type_probd_1 = $_POST["type_probd_1"];

$product_id_2 = $_POST["product_id_2"];
$sale_count_2 = $_POST["sale_count_2"];
$sn_number_2 = $_POST["sn_number_2"];
$remark_eng_2 = $_POST["remark_eng_2"];
$type_probd_2 = $_POST["type_probd_2"];


$product_id_3 = $_POST["product_id_3"];
$sale_count_3 = $_POST["sale_count_3"];
$sn_number_3 = $_POST["sn_number_3"];
$remark_eng_3 = $_POST["remark_eng_3"];
$type_probd_3 = $_POST["type_probd_3"];

$product_id_4 = $_POST["product_id_4"];
$sale_count_4 = $_POST["sale_count_4"];
$sn_number_4 = $_POST["sn_number_4"];
$remark_eng_4 = $_POST["remark_eng_4"];
$type_probd_4 = $_POST["type_probd_4"];

$product_id_5 = $_POST["product_id_5"];
$sale_count_5 = $_POST["sale_count_5"];
$sn_number_5 = $_POST["sn_number_5"];
$remark_eng_5 = $_POST["remark_eng_5"];
$type_probd_5 = $_POST["type_probd_5"];

$product_id_6 = $_POST["product_id_6"];
$sale_count_6 = $_POST["sale_count_6"];
$sn_number_6 = $_POST["sn_number_6"];
$remark_eng_6 = $_POST["remark_eng_6"];
$type_probd_6 = $_POST["type_probd_6"];


$product_id_7 = $_POST["product_id_7"];
$sale_count_7 = $_POST["sale_count_7"];
$sn_number_7 = $_POST["sn_number_7"];
$remark_eng_7 = $_POST["remark_eng_7"];
$type_probd_7 = $_POST["type_probd_7"];


$product_id_8 = $_POST["product_id_8"];
$sale_count_8 = $_POST["sale_count_8"];
$sn_number_8 = $_POST["sn_number_8"];
$remark_eng_8 = $_POST["remark_eng_8"];
$type_probd_8 = $_POST["type_probd_8"];


$product_id_9 = $_POST["product_id_9"];
$sale_count_9 = $_POST["sale_count_9"];
$sn_number_9 = $_POST["sn_number_9"];
$remark_eng_9 = $_POST["remark_eng_9"];
$type_probd_9 = $_POST["type_probd_9"];


$product_id_10 = $_POST["product_id_10"];
$sale_count_10 = $_POST["sale_count_10"];
$sn_number_10 = $_POST["sn_number_10"];
$remark_eng_10 = $_POST["remark_eng_10"];
$type_probd_10 = $_POST["type_probd_10"];


if($product_id_1 !==''  ){

$strSQL11 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_1."','".$product_id_1."','".$sale_count_1."','".$remark_eng_1."','".$sn_number_1."','".$type_probd_1."')";

$objQuery11 = mysqli_query($conn,$strSQL11);
}
	
if($product_id_2 !==''  ){

$strSQL12 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_2."','".$product_id_2."','".$sale_count_2."','".$remark_eng_2."','".$sn_number_2."','".$type_probd_2."')";

$objQuery12 = mysqli_query($conn,$strSQL12);
}

if($product_id_3 !==''  ){

$strSQL13 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_3."','".$product_id_3."','".$sale_count_3."','".$remark_eng_3."','".$sn_number_3."','".$type_probd_3."')";

$objQuery13 = mysqli_query($conn,$strSQL13);
}

if($product_id_4 !==''  ){

$strSQL14 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_4."','".$product_id_4."','".$sale_count_4."','".$remark_eng_4."','".$sn_number_4."','".$type_probd_4."')";

$objQuery14 = mysqli_query($conn,$strSQL14);
}

if($product_id_5 !==''  ){

$strSQL15 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_5."','".$product_id_5."','".$sale_count_5."','".$remark_eng_5."','".$sn_number_5."','".$type_probd_5."')";

$objQuery15 = mysqli_query($conn,$strSQL15);
}

if($product_id_6 !==''  ){

$strSQL16 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_6."','".$product_id_6."','".$sale_count_6."','".$remark_eng_6."','".$sn_number_6."','".$type_probd_6."')";

$objQuery16 = mysqli_query($conn,$strSQL16);
}

if($product_id_7 !==''  ){

$strSQL17 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_7."','".$product_id_7."','".$sale_count_7."','".$remark_eng_7."','".$sn_number_7."','".$type_probd_7."')";

$objQuery17 = mysqli_query($conn,$strSQL17);
}

if($product_id_8 !==''  ){

$strSQL18 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_8."','".$product_id_8."','".$sale_count_8."','".$remark_eng_8."','".$sn_number_8."','".$type_probd_8."')";

$objQuery18 = mysqli_query($conn,$strSQL18);
}

if($product_id_9 !==''  ){

$strSQL19 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_9."','".$product_id_9."','".$sale_count_9."','".$remark_eng_9."','".$sn_number_9."','".$type_probd_9."')";

$objQuery19 = mysqli_query($conn,$strSQL19);
}



if($product_id_10 !==''  ){

$strSQL20 = "insert into hos__subbreg2
(ref_id2,product_id2,product_code2,count2,remark_eng2,sn_number2,type_probd)
values ('".$ref_id."','".$product_id_10."','".$product_id_10."','".$sale_count_10."','".$remark_eng_10."','".$sn_number_10."','".$type_probd_10."')";

$objQuery20 = mysqli_query($conn,$strSQL20);
}



	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_breg_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


