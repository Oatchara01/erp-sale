<?php include "head.php"; ?>
<title>SOL :: ITEAMDEV</title>
<meta name="viewport" content="width=device-width, initial-scale=-1" charset="utf8">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/tab.css">
<link rel="stylesheet" href="awesome/css/all.css">
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/w3open.js"></script>
<script type="text/javascript" src="js/tab.js"></script>
<script type="text/javascript" src="js/ready.js"></script>
<script type="text/javascript" src="js/table.js"></script>
<script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery-3.4.1.js" type="text/javascript"></script>

<div class="w3-white w3-container">
	
<br><br><br>
<?php include "dbconnect.php"; ?>	
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-quarter">
	ปี :
<select name="year" id="year" style="width:90%" class="w3-input" >
<option  value="">**Please Select**</option>
<option  value="2021">2564</option>
<option  value="2022">2565</option>
<option  value="2023">2566</option>
<option  value="2024">2567</option>
<option  value="2025">2568</option>
<option  value="2026">2569</option>
<option  value="2027">2570</option>
<option  value="2028">2571</option>
<option  value="2029">2572</option>
<option  value="2030">2573</option>
</select>
	</div>

<div class="w3-quarter">
ลูกค้า
<input type='text' name = "bill_id" value ="<?php echo $_GET["bill_id"]; ?>"  id = "bill_id" class="w3-input" placeholder="Search ชื่อลูกค้า..."  style="width:90%;" /> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id" value ="<?php echo $_GET["h_bill_id"]; ?>"    class="button4" readonly>
</div>
	
	
<div class="w3-quarter">
กลุ่มลูกค้า
<input type='text' name = "mode_name" value ="<?php echo $_GET["mode_name"]; ?>"  id = "mode_name" class="w3-input" placeholder="ค้นหากลุ่มลูกค้า..."  style="width:90%;" /> 
<input type='hidden' name = "h_mode_name"  id = "h_mode_name" value ="<?php echo $_GET["h_mode_name"]; ?>"    class="button4" readonly>
</div>	

	<div class="w3-margin-bottom">
	<input type="submit" value="Search" class="w3-button w3-pale-red">
	</div>
<br>	
<?php
	
if($_GET["year"] !=''){
$yy = $_GET["year"];
}else{
$yy = date('Y');
}

$h_bill_id = $_GET["h_bill_id"];
$bill_id = $_GET["bill_id"];
$h_mode_name = $_GET["h_mode_name"];
$mode_name = $_GET["mode_name"];
$name = $_SESSION["name"];

if($h_bill_id!='' or $h_mode_name !=''){

$yy1 = $yy-1;
	
$year =$yy+543;
$year1 =$yy1+543;

$month1 ="$yy-01";	
$month2 ="$yy-02";	
$month3 ="$yy-03";	
$month4 ="$yy-04";	
$month5 ="$yy-05";	
$month6 ="$yy-06";	
$month7 ="$yy-07";	
$month8 ="$yy-08";	
$month9 ="$yy-09";	
$month10 ="$yy-10";	
$month11 ="$yy-11";	
$month12 ="$yy-12";	
	
$month_1 ="$yy1-01";	
$month_2 ="$yy1-02";	
$month_3 ="$yy1-03";	
$month_4 ="$yy1-04";	
$month_5 ="$yy1-05";	
$month_6 ="$yy1-06";	
$month_7 ="$yy1-07";	
$month_8 ="$yy1-08";	
$month_9 ="$yy1-09";	
$month_10 ="$yy1-10";	
$month_11 ="$yy1-11";	
$month_12 ="$yy1-12";		

if($name=='สมบัติ' or $name=='ชลชินี' or $name=='อัจฉรา' or $name=='ลักษณาวรรณ' or $name=='วารุณี'){
	
}else{
$sale="and ( d.sale_code ='S31' or d.sale_code ='S32' )";	
$sale1="and ( sale_code ='S31' or sale_code ='S32' )";	
	
}

//2564

	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_1%' $sale1 ";
	
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}	
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(d.amount) AS amount FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month_1%' $sale ";
 
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_01 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_2%' $sale1";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month_2%' $sale";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}		
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_02 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_3%' $sale1";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount  FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month_3%' $sale";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_03 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_4%' $sale1";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month_4%' $sale";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_04 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_5%' $sale1";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month_5%' $sale";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_05 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_6%' $sale1";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month_6%' $sale";
	
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_06 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_7%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month_7%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_07 = ($sumhos_awl-$sumhos_nbm)/1.07;		
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_8%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month_8%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_08 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_9%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month_9%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_09 = ($sumhos_awl-$sumhos_nbm)/1.07;		
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_10%' $sale1";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month_10%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_10 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_11%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month_11%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_11 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month_12%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month_12%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}		
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2564_12 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	

	

//2565

	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month1%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month1%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_01 = ($sumhos_awl-$sumhos_nbm)/1.07;	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month2%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month2%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_02 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month3%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month3%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_03 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month4%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month4%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}		
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_04 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month5%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month5%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_05 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month6%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}		

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month6%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_06 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month7%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month7%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_07 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month8%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month8%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_08 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month9%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month9%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_09 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month10%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month10%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}	

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_10 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month11%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month11%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_11 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	

		
	
	
$strSQL = "SELECT SUM(amount) As amount  FROM tb__buypro WHERE  doc_date LIKE '%$month12%' $sale1 ";
if($h_bill_id !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL .= ' AND mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount) As amount   FROM tb__discash d JOIN tb_credit_note c  ON d.ref_id = c.ref_credit WHERE c.iv_no_ref NOT LIKE '%IC%' and d.date_cash LIKE '%$month12%' $sale ";
if($h_bill_id !=""){ 
    $strSQL1 .= ' AND d.bill_id = "'.$h_bill_id.'"'; 
}	
if($h_mode_name !=""){ 
    $strSQL1 .= ' AND d.mode_cus = "'.$h_mode_name.'"'; 
}	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$sumhos_awl = $objResult['amount'];
$sumhos_nbm = $objResult1['amount'];
$sum2565_12 = ($sumhos_awl-$sumhos_nbm)/1.07;	
	
?>
<br>	
<div class="w3-container"><br>
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="7%">เดือน</th>
<th width="7%">มกราคม</th>
<th width="7%">กุมภาพันธ์</th>
<th width="7%">มีนาคม</th>
<th width="7%">เมษายน</th>
<th width="7%">พฤษภาคม</th>
<th width="7%">มิถุนายน</th>
<th width="7%">กรกฎาคม</th>
<th width="7%">สิงหาคม</th>
<th width="7%">กันยายน</th>
<th width="7%">ตุลาคม</th>
<th width="7%">พฤศจิกายน</th>
<th width="7%">ธันวาคม</th>
<th width="7%">ยอดรวม</th>

</thead>

<tr>
<td>ยอดขาย ปี <?php echo $year1; ?></td>
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month_1; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2564_01,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month_2; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2564_02,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month_3; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2564_03,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month_4; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2564_04,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month_5; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2564_05,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month_6; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2564_06,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month_7; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2564_07,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month_8; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2564_08,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month_9; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2564_09,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month_10; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2564_10,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month_11; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2564_11,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month_12; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2564_12,2).""; ?></a>
</td>		
<td><?php echo number_format($sum2564_01+$sum2564_02+$sum2564_03+$sum2564_04+$sum2564_05+$sum2564_06+$sum2564_07+$sum2564_08+$sum2564_09+$sum2564_10+$sum2564_11+$sum2564_12,2).""; ?></td>	
	</tr>
	

<tr>
<td>ยอดขาย ปี <?php echo $year; ?></td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month1; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2565_01,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month2; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2565_02,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month3; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2565_03,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month4; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2565_04,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month5; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2565_05,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month6; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2565_06,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month7; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2565_07,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month8; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2565_08,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month9; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2565_09,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month10; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2565_10,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month11; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2565_11,2).""; ?></a>
</td>	
<td>
<a href="report_salelers31.php?h_bill_id=<?php echo $h_bill_id;?>&month=<?php echo $month12; ?>&h_mode_name=<?php echo $h_mode_name;?>"  target="_blank"><?php echo number_format($sum2565_12,2).""; ?></a>
</td>	
<td><?php echo number_format($sum2565_01+$sum2565_02+$sum2565_03+$sum2565_04+$sum2565_05+$sum2565_06+$sum2565_07+$sum2565_08+$sum2565_09+$sum2565_10+$sum2565_11+$sum2565_12,2).""; ?></td>	
</tr>




		
	</table>
	<br><br>
	
<?php
 
$dataPoints1 = array(
	array("label"=> "มกราคม", "y"=> $sum2564_01),
	array("label"=> "กุมภาพันธ์", "y"=> $sum2564_02),
	array("label"=> "มีนาคม", "y"=> $sum2564_03),
	array("label"=> "เมษายน", "y"=> $sum2564_04),
	array("label"=> "พฤษภาคม", "y"=> $sum2564_05),
	array("label"=> "มิถุนายน", "y"=> $sum2564_06),
	array("label"=> "กรกฎาคม", "y"=> $sum2564_07),
	array("label"=> "สิงหาคม", "y"=> $sum2564_08),
	array("label"=> "กันยายน", "y"=> $sum2564_09),
	array("label"=> "ตุลาคม", "y"=> $sum2564_10),
	array("label"=> "พฤศจิกายน", "y"=> $sum2564_11),
	array("label"=> "ธันวาคม", "y"=> $sum2564_12)
);
	
	
$dataPoints2 = array(
	array("label"=> "มกราคม", "y"=> $sum2565_01),
	array("label"=> "กุมภาพันธ์", "y"=> $sum2565_02),
	array("label"=> "มีนาคม", "y"=> $sum2565_03),
	array("label"=> "เมษายน", "y"=> $sum2565_04),
	array("label"=> "พฤษภาคม", "y"=> $sum2565_05),
	array("label"=> "มิถุนายน", "y"=> $sum2565_06),
	array("label"=> "กรกฎาคม", "y"=> $sum2565_07),
	array("label"=> "สิงหาคม", "y"=> $sum2565_08),
	array("label"=> "กันยายน", "y"=> $sum2565_09),
	array("label"=> "ตุลาคม", "y"=> $sum2565_10),
	array("label"=> "พฤศจิกายน", "y"=> $sum2565_11),
	array("label"=> "ธันวาคม", "y"=> $sum2565_12)
);	
 


	
 
 
 
?>
<!DOCTYPE HTML>
<html>
<head>  
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "รายงานยอดขาย <?php  if($mode_name!=''){ echo $mode_name; }else if($bill_id!=''){ echo $bill_id; } ?> ปี <?php echo $year ?>"
	},
	theme: "light2",
	animationEnabled: true,
	toolTip:{
		shared: true,
		reversed: true
	},
	axisY: {
		title: "ยอดขาย",
		suffix: " บาท"
	},
	legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	data: [
		{
			
			type: "stackedColumn",
			name: "ยอดขาย <?php echo $year ?>",
			color : "#0099CC",
			showInLegend: true,
			yValueFormatString: "#,##0 บาท",
			dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK);
			
			 ?>
		},{
			type: "line",
			name: "ยอดขายปี <?php echo $year1; ?>",
			showInLegend: true,
			yValueFormatString: "#,##0 บาท",
			dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
		}
	]
});
 
chart.render();
 
function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html> 
<br><br><br><br>
</div>

<?php } ?>

 <script type="text/javascript">
function make_autocom(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_customers31.php?customer_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("bill_id","h_bill_id");
</script>
	

<script type="text/javascript">
function make_autocom(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_mode_cus.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("mode_name","h_mode_name");
</script> 
	
	
	