<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id_br = trim($_POST["ref_id_br"]);

$stock_date= date('Y-m-d');
$stock =  $_SESSION['name'];
$stock_code =  $_SESSION['code'];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";




$id = $_POST["id"];
$sn_number = $_POST["sn"];
$stock_remark = $_POST["stock_remark"];
$product_id  = $_POST["product_id"];



$strSQL21 = "SELECT * FROM hos__subbr WHERE ref_idd_br = '".$ref_id_br."' ";
//echo $strSQL21;
//exit();
$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){

  foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$sn_number_new=$sn_number[$key];
		$stock_remark_new =$stock_remark[$key];
        $product_id_new  =$product_id[$key];

$strSQL = "Update   hos__subbr set product_code = '$product_id_new',product_id = '$product_id_new',stock_remark='$stock_remark_new'  Where id= '$id_new' ";

//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL);
}
	
}

$product_id1 = $_POST["product_id1"];
$sale_count1 = $_POST["sale_count1"];
$product_price1 = $_POST["product_price1"];
$stock_remark1 = $_POST["stock_remark1"];




$product_id2 = $_POST["product_id2"];
$sale_count2 = $_POST["sale_count2"];
$product_price2 = $_POST["product_price2"];
$stock_remark2 = $_POST["stock_remark2"];



$product_id3 = $_POST["product_id3"];
$sale_count3 = $_POST["sale_count3"];
$product_price3 = $_POST["product_price3"];
$stock_remark3= $_POST["stock_remark3"];



$product_id4 = $_POST["product_id4"];
$sale_count4 = $_POST["sale_count4"];
$product_price4 = $_POST["product_price4"];
$stock_remark4 = $_POST["stock_remark4"];





$product_id5 = $_POST["product_id5"];
$sale_count5 = $_POST["sale_count5"];
$product_price5 = $_POST["product_price5"];
$stock_remark5 = $_POST["stock_remark5"];

if($product_id1 !==''  ){

$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,stock_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count1."','".$sale_count1."','".$stock_remark1."','".$product_id1."','".$product_id1."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
	
$strSQL11 = "insert into hos__subbr_ref
(ref_idd_br,count,stock_remark,product_id,product_code,stock_ckk,add_by,add_date,date_edit)
values ('".$ref_id_br."','".$sale_count1."','".$stock_remark1."','".$product_id1."','".$product_id1."','1','".$add_by."','".$add_date."','".$stock."')";

$objQuery11 = mysqli_query($conn,$strSQL11);


}


if($product_id2 !==''  ){

$strSQL2 ="insert into hos__subbr
(ref_idd_br,count,countref,stock_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count2."','".$sale_count2."','".$stock_remark2."','".$product_id2."','".$product_id2."')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
	
	
$strSQL12 ="insert into hos__subbr_ref
(ref_idd_br,count,stock_remark,product_id,product_code,stock_ckk,add_by,add_date,date_edit)
values ('".$ref_id_br."','".$sale_count2."','".$stock_remark2."','".$product_id2."','".$product_id2."','1','".$add_by."','".$add_date."','".$stock."')";

$objQuery12 = mysqli_query($conn,$strSQL21);


}


if($product_id3 !==''  ){

$strSQL3 = "insert into hos__subbr
(ref_idd_br,count,countref,stock_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count3."','".$sale_count3."','".$stock_remark3."','".$product_id3."','".$product_id3."')";

$objQuery3 = mysqli_query($conn,$strSQL3);
	
	
	
$strSQL13 = "insert into hos__subbr_ref
(ref_idd_br,count,countref,stock_remark,product_id,product_code,stock_ckk,add_by,add_date,date_edit)
values ('".$ref_id_br."','".$sale_count3."','".$stock_remark3."','".$product_id3."','".$product_id3."','1','".$add_by."','".$add_date."','".$stock."')";

$objQuery13 = mysqli_query($conn,$strSQL13);


}


if($product_id4 !==''  ){

$strSQL4 = "insert into hos__subbr
(ref_idd_br,count,countref,stock_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count4."','".$sale_count4."','".$stock_remark4."','".$product_id4."','".$product_id4."')";

$objQuery4 = mysqli_query($conn,$strSQL4);

	
	
$strSQL14 = "insert into hos__subbr_ref
(ref_idd_br,count,stock_remark,product_id,product_code,stock_ckk,add_by,add_date,date_edit)
values ('".$ref_id_br."','".$sale_count4."','".$stock_remark4."','".$product_id4."','".$product_id4."','1','".$add_by."','".$add_date."','".$stock."')";

$objQuery14 = mysqli_query($conn,$strSQL14);

}


if($product_id5 !==''  ){

$strSQL5 = "insert into hos__subbr
(ref_idd_br,count,countref,stock_remark,product_id,product_code)
values ('".$ref_id_br."','".$sale_count5."','".$sale_count5."','".$stock_remark5."','".$product_id5."','".$product_id5."')";

$objQuery5 = mysqli_query($conn,$strSQL5);
	
	
	
$strSQL15 = "insert into hos__subbr_ref
(ref_idd_br,count,stock_remark,product_id,product_code,stock_ckk,add_by,add_date,date_edit)
values ('".$ref_id_br."','".$sale_count5."','".$stock_remark5."','".$product_id5."','".$product_id5."','1','".$add_by."','".$add_date."','".$stock."')";

$objQuery15 = mysqli_query($conn,$strSQL15);


}

	
 if($objQuery){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_stockbrhos_edit.php?ref_id_br=$ref_id_br';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


