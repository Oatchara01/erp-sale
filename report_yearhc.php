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



//target
	
$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE  month_no = '".$month1."' and ckk_type !='1' and ckk_type !='0'";
	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$target01 = $objResult1['target'];
	
$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE  month_no = '".$month2."' and ckk_type !='1' and ckk_type !='0'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$target02 = $objResult1['target'];	
	

$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE  month_no = '".$month3."' and ckk_type !='1' and ckk_type !='0'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$target03 = $objResult1['target'];	
	
	
$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE  month_no = '".$month4."' and ckk_type !='1' and ckk_type !='0'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$target04 = $objResult1['target'];
	
$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE  month_no = '".$month5."' and ckk_type !='1' and ckk_type !='0'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$target05 = $objResult1['target'];	
	
	
$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE  month_no = '".$month6."' and ckk_type !='1' and ckk_type !='0'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$target06 = $objResult1['target'];
	
$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE  month_no = '".$month7."' and ckk_type !='1' and ckk_type !='0'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$target07 = $objResult1['target'];	
	
	
$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE  month_no = '".$month8."'and ckk_type !='1' and ckk_type !='0'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
$target08 = $objResult1['target'];
	
$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE  month_no = '".$month9."' and ckk_type !='1' and ckk_type !='0'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$target09 = $objResult1['target'];	
	
	
$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE  month_no = '".$month10."' and ckk_type !='1' and ckk_type !='0'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$target10 = $objResult1['target'];
	
$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE  month_no = '".$month11."' and ckk_type !='1' and ckk_type !='0'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$target11 = $objResult1['target'];	
	
	
$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE  month_no = '".$month12."' and ckk_type !='1' and ckk_type !='0'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$target12 = $objResult1['target'];
	
	
//2564

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  month_sum = '".$month_1."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2564_01 = $sumhos_awl+$sumhos_nbm;	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month_2."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2564_02 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month_3."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2564_03 = $sumhos_awl+$sumhos_nbm;		

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month_4."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2564_04 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month_5."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2564_05 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month_6."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2564_06 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month_7."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2564_07 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month_8."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2564_08 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month_9."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2564_09 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month_10."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2564_10 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month_11."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2564_11 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month_12."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2564_12 = $sumhos_awl+$sumhos_nbm;	

			
		
//2565

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  month_sum = '".$month1."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2565_01 = $sumhos_awl+$sumhos_nbm;	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month2."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2565_02 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month3."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2565_03 = $sumhos_awl+$sumhos_nbm;		

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month4."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2565_04 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month5."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2565_05 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month6."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2565_06 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month7."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2565_07 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month8."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2565_08 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month9."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2565_09 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month10."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2565_10 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month11."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2565_11 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE month_sum = '".$month12."' and type_arae='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sum2565_12 = $sumhos_awl+$sumhos_nbm;	

				
	

//S31	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose = 'S31' and month_sum = '".$month1."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sumhos_01 = $sumhos_awl+$sumhos_nbm;	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose = 'S31' and month_sum = '".$month2."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sumhos_02 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose = 'S31' and month_sum = '".$month3."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sumhos_03 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose = 'S31' and month_sum = '".$month4."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sumhos_04 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose = 'S31' and month_sum = '".$month5."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sumhos_05 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose = 'S31' and month_sum = '".$month6."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sumhos_06 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose = 'S31' and month_sum = '".$month7."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sumhos_07 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose = 'S31' and month_sum = '".$month8."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sumhos_08 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose = 'S31' and month_sum = '".$month9."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sumhos_09 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose = 'S31' and month_sum = '".$month10."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sumhos_10 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose = 'S31' and month_sum = '".$month11."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sumhos_11 = $sumhos_awl+$sumhos_nbm;	

	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose = 'S31' and month_sum = '".$month12."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sumhos_12 = $sumhos_awl+$sumhos_nbm;	

	
	
	
	
//sol	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose !='SOL91' and sale_cose !='SOL92' and sale_cose !='SOL93' and sale_cose !='SOL94' and sale_cose LIKE '%SOL%' and month_sum = '".$month1."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumsol_awl = $objResult['sum_awl'];
$sumsol_nbm = $objResult['sum_nbm'];
$sumsol_01 = $sumsol_awl+$sumsol_nbm;	
	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose !='SOL91' and sale_cose !='SOL92' and sale_cose !='SOL93' and sale_cose !='SOL94'  and sale_cose LIKE '%SOL%' and month_sum = '".$month2."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumsol_awl = $objResult['sum_awl'];
$sumsol_nbm = $objResult['sum_nbm'];
$sumsol_02 = $sumsol_awl+$sumsol_nbm;	
	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose !='SOL91' and sale_cose !='SOL92' and sale_cose !='SOL93' and sale_cose !='SOL94'  and sale_cose LIKE '%SOL%' and month_sum = '".$month3."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumsol_awl = $objResult['sum_awl'];
$sumsol_nbm = $objResult['sum_nbm'];
$sumsol_03 = $sumsol_awl+$sumsol_nbm;	
	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose !='SOL91' and sale_cose !='SOL92' and sale_cose !='SOL93' and sale_cose !='SOL94'  and sale_cose LIKE '%SOL%' and month_sum = '".$month4."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumsol_awl = $objResult['sum_awl'];
$sumsol_nbm = $objResult['sum_nbm'];
$sumsol_04 = $sumsol_awl+$sumsol_nbm;	
	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose !='SOL91' and sale_cose !='SOL92' and sale_cose !='SOL93' and sale_cose !='SOL94'  and sale_cose LIKE '%SOL%' and month_sum = '".$month5."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumsol_awl = $objResult['sum_awl'];
$sumsol_nbm = $objResult['sum_nbm'];
$sumsol_05 = $sumsol_awl+$sumsol_nbm;	
	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose !='SOL91' and sale_cose !='SOL92' and sale_cose !='SOL93' and sale_cose !='SOL94'  and sale_cose LIKE '%SOL%' and month_sum = '".$month6."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumsol_awl = $objResult['sum_awl'];
$sumsol_nbm = $objResult['sum_nbm'];
$sumsol_06 = $sumsol_awl+$sumsol_nbm;	
	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose !='SOL91' and sale_cose !='SOL92' and sale_cose !='SOL93' and sale_cose !='SOL94'  and sale_cose LIKE '%SOL%' and month_sum = '".$month7."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumsol_awl = $objResult['sum_awl'];
$sumsol_nbm = $objResult['sum_nbm'];
$sumsol_07 = $sumsol_awl+$sumsol_nbm;	
	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose !='SOL91' and sale_cose !='SOL92' and sale_cose !='SOL93' and sale_cose !='SOL94'  and sale_cose LIKE '%SOL%' and month_sum = '".$month8."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumsol_awl = $objResult['sum_awl'];
$sumsol_nbm = $objResult['sum_nbm'];
$sumsol_08 = $sumsol_awl+$sumsol_nbm;	
	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose !='SOL91' and sale_cose !='SOL92' and sale_cose !='SOL93' and sale_cose !='SOL94'  and sale_cose LIKE '%SOL%' and month_sum = '".$month9."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumsol_awl = $objResult['sum_awl'];
$sumsol_nbm = $objResult['sum_nbm'];
$sumsol_09 = $sumsol_awl+$sumsol_nbm;	
	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose !='SOL91' and sale_cose !='SOL92' and sale_cose !='SOL93' and sale_cose !='SOL94'  and sale_cose LIKE '%SOL%' and month_sum = '".$month10."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumsol_awl = $objResult['sum_awl'];
$sumsol_nbm = $objResult['sum_nbm'];
$sumsol_10 = $sumsol_awl+$sumsol_nbm;	
	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose !='SOL91' and sale_cose !='SOL92' and sale_cose !='SOL93' and sale_cose !='SOL94'  and sale_cose LIKE '%SOL%' and month_sum = '".$month11."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumsol_awl = $objResult['sum_awl'];
$sumsol_nbm = $objResult['sum_nbm'];
$sumsol_11 = $sumsol_awl+$sumsol_nbm;	
	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose !='SOL91' and sale_cose !='SOL92' and sale_cose !='SOL93' and sale_cose !='SOL94'  and sale_cose LIKE '%SOL%' and month_sum = '".$month12."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumsol_awl = $objResult['sum_awl'];
$sumsol_nbm = $objResult['sum_nbm'];
$sumsol_12 = $sumsol_awl+$sumsol_nbm;	
	

	
	
	
//MM1	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM1' and month_sum = '".$month1."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumother_01 = $sumsol_awl8+$sumsol_nbm8;	

	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM1' and month_sum = '".$month2."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumother_02 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM1' and month_sum = '".$month3."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumother_03 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM1' and month_sum = '".$month4."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumother_04 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM1' and month_sum = '".$month5."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumother_05 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM1' and month_sum = '".$month6."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumother_06 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM1' and month_sum = '".$month7."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumother_07 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM1' and month_sum = '".$month8."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumother_08 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM1' and month_sum = '".$month9."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumother_09 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose ='MM1' and month_sum = '".$month10."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumother_10 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose ='MM1' and month_sum = '".$month11."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumother_11 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose ='MM1' and month_sum = '".$month12."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumother_12 = $sumsol_awl8+$sumsol_nbm8;	
	
//MM2	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM2' and month_sum = '".$month1."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$summm2_01 = $sumsol_awl8+$sumsol_nbm8;	

	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM2' and month_sum = '".$month2."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$summm2_02 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM2' and month_sum = '".$month3."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$summm2_03 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM2' and month_sum = '".$month4."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$summm2_04 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM2' and month_sum = '".$month5."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$summm2_05 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM2' and month_sum = '".$month6."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$summm2_06 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM2' and month_sum = '".$month7."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$summm2_07 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM2' and month_sum = '".$month8."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$summm2_08 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='MM2' and month_sum = '".$month9."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$summm2_09 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose ='MM2' and month_sum = '".$month10."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$summm2_10 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose ='MM2' and month_sum = '".$month11."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$summm2_11 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose ='MM2' and month_sum = '".$month12."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$summm2_12 = $sumsol_awl8+$sumsol_nbm8;	
	
	
//SOL99	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose LIKE '%SOL9%' and sale_cose !='SOL99' and month_sum = '".$month1."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol99_01 = $sumsol_awl8+$sumsol_nbm8;	

	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose LIKE '%SOL9%' and sale_cose !='SOL99' and month_sum = '".$month2."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol99_02 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose LIKE '%SOL9%' and sale_cose !='SOL99' and month_sum = '".$month3."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol99_03 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose LIKE '%SOL9%' and sale_cose !='SOL99' and month_sum = '".$month4."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol99_04 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose LIKE '%SOL9%' and sale_cose !='SOL99' and month_sum = '".$month5."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol99_05 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose LIKE '%SOL9%' and sale_cose !='SOL99' and month_sum = '".$month6."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol99_06 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose LIKE '%SOL9%' and sale_cose !='SOL99' and month_sum = '".$month7."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol99_07 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose LIKE '%SOL9%' and sale_cose !='SOL99' and month_sum = '".$month8."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol99_08 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose LIKE '%SOL9%' and sale_cose !='SOL99' and month_sum = '".$month9."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol99_09 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose LIKE '%SOL9%' and sale_cose !='SOL99' and month_sum = '".$month10."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol99_10 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose LIKE '%SOL9%' and sale_cose !='SOL99' and month_sum = '".$month11."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol99_11 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose LIKE '%SOL9%' and sale_cose !='SOL99' and month_sum = '".$month12."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol99_12 = $sumsol_awl8+$sumsol_nbm8;	
	
	
//S32
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S32' and month_sum = '".$month1."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol32_01 = $sumsol_awl8+$sumsol_nbm8;	

	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S32' and month_sum = '".$month2."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol32_02 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S32' and month_sum = '".$month3."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol32_03 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S32' and month_sum = '".$month4."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol32_04 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S32' and month_sum = '".$month5."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol32_05 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S32' and month_sum = '".$month6."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol32_06 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S32' and month_sum = '".$month7."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol32_07 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S32' and month_sum = '".$month8."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol32_08 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S32' and month_sum = '".$month9."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol32_09 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose ='S32' and month_sum = '".$month10."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol32_10 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose ='S32' and month_sum = '".$month11."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol32_11 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose ='S32' and month_sum = '".$month12."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol32_12 = $sumsol_awl8+$sumsol_nbm8;	
	
		
//S33
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S33' and month_sum = '".$month1."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol33_01 = $sumsol_awl8+$sumsol_nbm8;	

	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S33' and month_sum = '".$month2."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol33_02 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S33' and month_sum = '".$month3."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol33_03 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S33' and month_sum = '".$month4."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol33_04 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S33' and month_sum = '".$month5."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol33_05 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S33' and month_sum = '".$month6."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol33_06 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S33' and month_sum = '".$month7."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol33_07 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S33' and month_sum = '".$month8."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol33_08 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose ='S33' and month_sum = '".$month9."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol33_09 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose ='S33' and month_sum = '".$month10."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol33_10 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose ='S33' and month_sum = '".$month11."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol33_11 = $sumsol_awl8+$sumsol_nbm8;	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  sale_cose ='S33' and month_sum = '".$month12."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol33_12 = $sumsol_awl8+$sumsol_nbm8;	
		
	
	?>
<?php
 
$dataPoints1 = array(
	array("label"=> "มกราคม", "y"=> $sumhos_01),
	array("label"=> "กุมภาพันธ์", "y"=> $sumhos_02),
	array("label"=> "มีนาคม", "y"=> $sumhos_03),
	array("label"=> "เมษายน", "y"=> $sumhos_04),
	array("label"=> "พฤษภาคม", "y"=> $sumhos_05),
	array("label"=> "มิถุนายน", "y"=> $sumhos_06),
	array("label"=> "กรกฎาคม", "y"=> $sumhos_07),
	array("label"=> "สิงหาคม", "y"=> $sumhos_08),
	array("label"=> "กันยายน", "y"=> $sumhos_09),
	array("label"=> "ตุลาคม", "y"=> $sumhos_10),
	array("label"=> "พฤศจิกายน", "y"=> $sumhos_11),
	array("label"=> "ธันวาคม", "y"=> $sumhos_12)
);
	
	
$dataPoints4 = array(
	array("label"=> "มกราคม", "y"=> $target01),
	array("label"=> "กุมภาพันธ์", "y"=> $target02),
	array("label"=> "มีนาคม", "y"=> $target03),
	array("label"=> "เมษายน", "y"=> $target04),
	array("label"=> "พฤษภาคม", "y"=> $target05),
	array("label"=> "มิถุนายน", "y"=> $target06),
	array("label"=> "กรกฎาคม", "y"=> $target07),
	array("label"=> "สิงหาคม", "y"=> $target08),
	array("label"=> "กันยายน", "y"=> $target09),
	array("label"=> "ตุลาคม", "y"=> $target10),
	array("label"=> "พฤศจิกายน", "y"=> $target11),
	array("label"=> "ธันวาคม", "y"=> $target12)
);	
 

$dataPoints3 = array(
	array("label"=> "มกราคม", "y"=> $sumother_01),
	array("label"=> "กุมภาพันธ์", "y"=> $sumother_02),
	array("label"=> "มีนาคม", "y"=> $sumother_03),
	array("label"=> "เมษายน", "y"=> $sumother_04),
	array("label"=> "พฤษภาคม", "y"=> $sumother_05),
	array("label"=> "มิถุนายน", "y"=> $sumother_06),
	array("label"=> "กรกฎาคม", "y"=> $sumother_07),
	array("label"=> "สิงหาคม", "y"=> $sumother_08),
	array("label"=> "กันยายน", "y"=> $sumother_09),
	array("label"=> "ตุลาคม", "y"=> $sumother_10),
	array("label"=> "พฤศจิกายน", "y"=> $sumother_11),
	array("label"=> "ธันวาคม", "y"=> $sumother_12)
);
 
$dataPoints2 = array(
	array("label"=> "มกราคม", "y"=> $sumsol_01),
	array("label"=> "กุมภาพันธ์", "y"=> $sumsol_02),
	array("label"=> "มีนาคม", "y"=> $sumsol_03),
	array("label"=> "เมษายน", "y"=> $sumsol_04),
	array("label"=> "พฤษภาคม", "y"=> $sumsol_05),
	array("label"=> "มิถุนายน", "y"=> $sumsol_06),
	array("label"=> "กรกฎาคม", "y"=> $sumsol_07),
	array("label"=> "สิงหาคม", "y"=> $sumsol_08),
	array("label"=> "กันยายน", "y"=> $sumsol_09),
	array("label"=> "ตุลาคม", "y"=> $sumsol_10),
	array("label"=> "พฤศจิกายน", "y"=> $sumsol_11),
	array("label"=> "ธันวาคม", "y"=> $sumsol_12)
);
 
 $dataPoints5 = array(
	array("label"=> "มกราคม", "y"=> $summm2_01),
	array("label"=> "กุมภาพันธ์", "y"=> $summm2_02),
	array("label"=> "มีนาคม", "y"=> $summm2_03),
	array("label"=> "เมษายน", "y"=> $summm2_04),
	array("label"=> "พฤษภาคม", "y"=> $summm2_05),
	array("label"=> "มิถุนายน", "y"=> $summm2_06),
	array("label"=> "กรกฎาคม", "y"=> $summm2_07),
	array("label"=> "สิงหาคม", "y"=> $summm2_08),
	array("label"=> "กันยายน", "y"=> $summm2_09),
	array("label"=> "ตุลาคม", "y"=> $summm2_10),
	array("label"=> "พฤศจิกายน", "y"=> $summm2_11),
	array("label"=> "ธันวาคม", "y"=> $summm2_12)
);


$dataPoints6 = array(
	array("label"=> "มกราคม", "y"=> $sumsol99_01),
	array("label"=> "กุมภาพันธ์", "y"=> $sumsol99_02),
	array("label"=> "มีนาคม", "y"=> $sumsol99_03),
	array("label"=> "เมษายน", "y"=> $sumsol99_04),
	array("label"=> "พฤษภาคม", "y"=> $sumsol99_05),
	array("label"=> "มิถุนายน", "y"=> $sumsol99_06),
	array("label"=> "กรกฎาคม", "y"=> $sumsol99_07),
	array("label"=> "สิงหาคม", "y"=> $sumsol99_08),
	array("label"=> "กันยายน", "y"=> $sumsol99_09),
	array("label"=> "ตุลาคม", "y"=> $sumsol99_10),
	array("label"=> "พฤศจิกายน", "y"=> $sumsol99_11),
	array("label"=> "ธันวาคม", "y"=> $sumsol99_12)
);

$dataPoints9 = array(
	array("label"=> "มกราคม", "y"=> $sumsol32_01),
	array("label"=> "กุมภาพันธ์", "y"=> $sumsol32_02),
	array("label"=> "มีนาคม", "y"=> $sumsol32_03),
	array("label"=> "เมษายน", "y"=> $sumsol32_04),
	array("label"=> "พฤษภาคม", "y"=> $sumsol32_05),
	array("label"=> "มิถุนายน", "y"=> $sumsol32_06),
	array("label"=> "กรกฎาคม", "y"=> $sumsol32_07),
	array("label"=> "สิงหาคม", "y"=> $sumsol32_08),
	array("label"=> "กันยายน", "y"=> $sumsol32_09),
	array("label"=> "ตุลาคม", "y"=> $sumsol32_10),
	array("label"=> "พฤศจิกายน", "y"=> $sumsol32_11),
	array("label"=> "ธันวาคม", "y"=> $sumsol32_12)
);	
	
$dataPoints10 = array(
	array("label"=> "มกราคม", "y"=> $sumsol33_01),
	array("label"=> "กุมภาพันธ์", "y"=> $sumsol33_02),
	array("label"=> "มีนาคม", "y"=> $sumsol33_03),
	array("label"=> "เมษายน", "y"=> $sumsol33_04),
	array("label"=> "พฤษภาคม", "y"=> $sumsol33_05),
	array("label"=> "มิถุนายน", "y"=> $sumsol33_06),
	array("label"=> "กรกฎาคม", "y"=> $sumsol33_07),
	array("label"=> "สิงหาคม", "y"=> $sumsol33_08),
	array("label"=> "กันยายน", "y"=> $sumsol33_09),
	array("label"=> "ตุลาคม", "y"=> $sumsol33_10),
	array("label"=> "พฤศจิกายน", "y"=> $sumsol33_11),
	array("label"=> "ธันวาคม", "y"=> $sumsol33_12)
);	
	
$dataPoints7 = array(
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
		
$dataPoints8 = array(
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
		text: "รายงานยอดขาย Home Care ปี <?php echo $year ?>"
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
			name: "S31",
			showInLegend: true,
			yValueFormatString: "#,##0 บาท",
			dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
		},{
			type: "stackedColumn",
			name: "S32",
			showInLegend: true,
			yValueFormatString: "#,##0 บาท",
			dataPoints: <?php echo json_encode($dataPoints9, JSON_NUMERIC_CHECK); ?>
		},{
			type: "stackedColumn",
			name: "S33",
			showInLegend: true,
			yValueFormatString: "#,##0 บาท",
			dataPoints: <?php echo json_encode($dataPoints10, JSON_NUMERIC_CHECK); ?>	
		},{
			type: "stackedColumn",
			name: "SOL",
			showInLegend: true,
			yValueFormatString: "#,##0 บาท",
			dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
		},{
						
			type: "stackedColumn",
			name: "MM1",
			showInLegend: true,
			yValueFormatString: "#,##0 บาท",
			dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK);
			
			?>
		},{
						
			type: "stackedColumn",
			name: "MM2",
			showInLegend: true,
			yValueFormatString: "#,##0 บาท",
			dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK);
			
			?>
		},{
						
			type: "stackedColumn",
			name: "E-Comerce",
			showInLegend: true,
			yValueFormatString: "#,##0 บาท",
			dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK);
			
			?>
		},{
			type: "line",
			name: "ยอดขายรวม",
			showInLegend: true,
			yValueFormatString: "#,##0 บาท",
			dataPoints: <?php echo json_encode($dataPoints8, JSON_NUMERIC_CHECK); ?>
		},{
			type: "line",
			name: "เป้าหมาย",
			showInLegend: true,
			yValueFormatString: "#,##0 บาท",
			dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
		},{
			type: "line",
			name: "ยอดขายปี <?php echo $year1; ?>",
			showInLegend: true,
			yValueFormatString: "#,##0 บาท",
			dataPoints: <?php echo json_encode($dataPoints7, JSON_NUMERIC_CHECK); ?>
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
<br><br>
<div class="w3-container"><br>
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="7%">เดือน</th>
<th width="7%">มกราคม</th>
<th width="7%">กุมภาพันธ์</th>
<th width="7%">มีนาคม</th>
<th width="7%">เมษายน</th>
<th width="7%">พฤษภาคม</th>
<th width="7%">มิถุนาคม</th>
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
<td><?php echo number_format($sum2564_01,2).""; ?></td>	
<td><?php echo number_format($sum2564_02,2).""; ?></td>	
<td><?php echo number_format($sum2564_03,2).""; ?></td>	
<td><?php echo number_format($sum2564_04,2).""; ?></td>	
<td><?php echo number_format($sum2564_05,2).""; ?></td>	
<td><?php echo number_format($sum2564_06,2).""; ?></td>	
<td><?php echo number_format($sum2564_07,2).""; ?></td>	
<td><?php echo number_format($sum2564_08,2).""; ?></td>	
<td><?php echo number_format($sum2564_09,2).""; ?></td>	
<td><?php echo number_format($sum2564_10,2).""; ?></td>	
<td><?php echo number_format($sum2564_11,2).""; ?></td>	
<td><?php echo number_format($sum2564_12,2).""; ?></td>	
<td><?php echo number_format($sum2564_01+$sum2564_02+$sum2564_03+$sum2564_04+$sum2564_05+$sum2564_06+$sum2564_07+$sum2564_08+$sum2564_09+$sum2564_10+$sum2564_11+$sum2564_12,2).""; ?></td>	
</tr>

<tr>
<td>เป้าหมาย ปี <?php echo $year; ?></td>
<td><?php echo number_format($target01,2).""; ?></td>	
<td><?php echo number_format($target02,2).""; ?></td>	
<td><?php echo number_format($target03,2).""; ?></td>	
<td><?php echo number_format($target04,2).""; ?></td>	
<td><?php echo number_format($target05,2).""; ?></td>	
<td><?php echo number_format($target06,2).""; ?></td>	
<td><?php echo number_format($target07,2).""; ?></td>	
<td><?php echo number_format($target08,2).""; ?></td>	
<td><?php echo number_format($target09,2).""; ?></td>	
<td><?php echo number_format($target10,2).""; ?></td>	
<td><?php echo number_format($target11,2).""; ?></td>	
<td><?php echo number_format($target12,2).""; ?></td>	
<td><?php echo number_format($target01+$target02+$target03+$target04+$target05+$target06+$target07+$target08+$target09+$target10+$target11+$target12,2).""; ?></td>	
</tr>	

<tr>	
<td>ยอดขาย ปี <?php echo $year; ?></td>
<td><?php echo number_format($sum2565_01,2).""; ?></td>	
<td><?php echo number_format($sum2565_02,2).""; ?></td>	
<td><?php echo number_format($sum2565_03,2).""; ?></td>	
<td><?php echo number_format($sum2565_04,2).""; ?></td>	
<td><?php echo number_format($sum2565_05,2).""; ?></td>	
<td><?php echo number_format($sum2565_06,2).""; ?></td>	
<td><?php echo number_format($sum2565_07,2).""; ?></td>	
<td><?php echo number_format($sum2565_08,2).""; ?></td>	
<td><?php echo number_format($sum2565_09,2).""; ?></td>	
<td><?php echo number_format($sum2565_10,2).""; ?></td>	
<td><?php echo number_format($sum2565_11,2).""; ?></td>	
<td><?php echo number_format($sum2565_12,2).""; ?></td>	
<td><?php echo number_format($sum2565_01+$sum2565_02+$sum2565_03+$sum2565_04+$sum2565_05+$sum2565_06+$sum2565_07+$sum2565_08+$sum2565_09+$sum2565_10+$sum2565_11+$sum2565_12,2).""; ?></td>	
</tr>	

<tr>	
<td>SOL</td>
<td><?php echo number_format($sumsol_01,2).""; ?></td>	
<td><?php echo number_format($sumsol_02,2).""; ?></td>	
<td><?php echo number_format($sumsol_03,2).""; ?></td>	
<td><?php echo number_format($sumsol_04,2).""; ?></td>	
<td><?php echo number_format($sumsol_05,2).""; ?></td>	
<td><?php echo number_format($sumsol_06,2).""; ?></td>	
<td><?php echo number_format($sumsol_07,2).""; ?></td>	
<td><?php echo number_format($sumsol_08,2).""; ?></td>	
<td><?php echo number_format($sumsol_09,2).""; ?></td>	
<td><?php echo number_format($sumsol_10,2).""; ?></td>	
<td><?php echo number_format($sumsol_11,2).""; ?></td>	
<td><?php echo number_format($sumsol_12,2).""; ?></td>	
<td><?php echo number_format($sumsol_01+$sumsol_02+$sumsol_03+$sumsol_04+$sumsol_05+$sumsol_06+$sumsol_07+$sumsol_08+$sumsol_09+$sumsol_10+$sumsol_11+$sumsol_12,2).""; ?></td>	
</tr>		


<tr>	
<td>S31</td>
<td><?php echo number_format($sumhos_01,2).""; ?></td>	
<td><?php echo number_format($sumhos_02,2).""; ?></td>	
<td><?php echo number_format($sumhos_03,2).""; ?></td>	
<td><?php echo number_format($sumhos_04,2).""; ?></td>	
<td><?php echo number_format($sumhos_05,2).""; ?></td>	
<td><?php echo number_format($sumhos_06,2).""; ?></td>	
<td><?php echo number_format($sumhos_07,2).""; ?></td>	
<td><?php echo number_format($sumhos_08,2).""; ?></td>	
<td><?php echo number_format($sumhos_09,2).""; ?></td>	
<td><?php echo number_format($sumhos_10,2).""; ?></td>	
<td><?php echo number_format($sumhos_11,2).""; ?></td>	
<td><?php echo number_format($sumhos_12,2).""; ?></td>	
<td><?php echo number_format($sumhos_01+$sumhos_02+$sumhos_03+$sumhos_04+$sumhos_05+$sumhos_06+$sumhos_07+$sumhos_08+$sumhos_09+$sumhos_10+$sumhos_11+$sumhos_12,2).""; ?></td>	
</tr>		
			

<tr>	
<td>S32</td>
<td><?php echo number_format($sumsol32_01,2).""; ?></td>	
<td><?php echo number_format($sumsol32_02,2).""; ?></td>	
<td><?php echo number_format($sumsol32_03,2).""; ?></td>	
<td><?php echo number_format($sumsol32_04,2).""; ?></td>	
<td><?php echo number_format($sumsol32_05,2).""; ?></td>	
<td><?php echo number_format($sumsol32_06,2).""; ?></td>	
<td><?php echo number_format($sumsol32_07,2).""; ?></td>	
<td><?php echo number_format($sumsol32_08,2).""; ?></td>	
<td><?php echo number_format($sumsol32_09,2).""; ?></td>	
<td><?php echo number_format($sumsol32_10,2).""; ?></td>	
<td><?php echo number_format($sumsol32_11,2).""; ?></td>	
<td><?php echo number_format($sumsol32_12,2).""; ?></td>	
<td><?php echo number_format($sumsol32_01+$sumsol32_02+$sumsol32_03+$sumsol32_04+$sumsol32_05+$sumsol32_06+$sumsol32_07+$sumsol32_08+$sumsol32_09+$sumsol32_10+$sumsol32_11+$sumsol32_12,2).""; ?></td>	
</tr>	
	
<tr>	
<td>S33</td>
<td><?php echo number_format($sumsol33_01,2).""; ?></td>	
<td><?php echo number_format($sumsol33_02,2).""; ?></td>	
<td><?php echo number_format($sumsol33_03,2).""; ?></td>	
<td><?php echo number_format($sumsol33_04,2).""; ?></td>	
<td><?php echo number_format($sumsol33_05,2).""; ?></td>	
<td><?php echo number_format($sumsol33_06,2).""; ?></td>	
<td><?php echo number_format($sumsol33_07,2).""; ?></td>	
<td><?php echo number_format($sumsol33_08,2).""; ?></td>	
<td><?php echo number_format($sumsol33_09,2).""; ?></td>	
<td><?php echo number_format($sumsol33_10,2).""; ?></td>	
<td><?php echo number_format($sumsol33_11,2).""; ?></td>	
<td><?php echo number_format($sumsol33_12,2).""; ?></td>	
<td><?php echo number_format($sumsol33_01+$sumsol33_02+$sumsol33_03+$sumsol33_04+$sumsol33_05+$sumsol33_06+$sumsol33_07+$sumsol33_08+$sumsol33_09+$sumsol33_10+$sumsol33_11+$sumsol33_12,2).""; ?></td>	
</tr>	
		
	
<tr>
<td>MM1</td>
<td><?php echo number_format($sumother_01,2).""; ?></td>	
<td><?php echo number_format($sumother_02,2).""; ?></td>	
<td><?php echo number_format($sumother_03,2).""; ?></td>	
<td><?php echo number_format($sumother_04,2).""; ?></td>	
<td><?php echo number_format($sumother_05,2).""; ?></td>	
<td><?php echo number_format($sumother_06,2).""; ?></td>	
<td><?php echo number_format($sumother_07,2).""; ?></td>	
<td><?php echo number_format($sumother_08,2).""; ?></td>	
<td><?php echo number_format($sumother_09,2).""; ?></td>	
<td><?php echo number_format($sumother_10,2).""; ?></td>	
<td><?php echo number_format($sumother_11,2).""; ?></td>	
<td><?php echo number_format($sumother_12,2).""; ?></td>	
<td><?php echo number_format($sumother_01+$sumother_02+$sumother_03+$sumother_04+$sumother_05+$sumother_06+$sumother_07+$sumother_08+$sumother_09+$sumother_10+$sumother_11+$sumother_12,2).""; ?></td>	
</tr>			

<tr>
<td>MM2</td>
<td><?php echo number_format($summm2_01,2).""; ?></td>	
<td><?php echo number_format($summm2_02,2).""; ?></td>	
<td><?php echo number_format($summm2_03,2).""; ?></td>	
<td><?php echo number_format($summm2_04,2).""; ?></td>	
<td><?php echo number_format($summm2_05,2).""; ?></td>	
<td><?php echo number_format($summm2_06,2).""; ?></td>	
<td><?php echo number_format($summm2_07,2).""; ?></td>	
<td><?php echo number_format($summm2_08,2).""; ?></td>	
<td><?php echo number_format($summm2_09,2).""; ?></td>	
<td><?php echo number_format($summm2_10,2).""; ?></td>	
<td><?php echo number_format($summm2_11,2).""; ?></td>	
<td><?php echo number_format($summm2_12,2).""; ?></td>	
<td><?php echo number_format($summm2_01+$summm2_02+$summm2_03+$summm2_04+$summm2_05+$summm2_06+$summm2_07+$summm2_08+$summm2_09+$summm2_10+$summm2_11+$summm2_12,2).""; ?></td>	
</tr>			

<tr>
<td>E-Comerce</td>
<td><?php echo number_format($sumsol99_01,2).""; ?></td>	
<td><?php echo number_format($sumsol99_02,2).""; ?></td>	
<td><?php echo number_format($sumsol99_03,2).""; ?></td>	
<td><?php echo number_format($sumsol99_04,2).""; ?></td>	
<td><?php echo number_format($sumsol99_05,2).""; ?></td>	
<td><?php echo number_format($sumsol99_06,2).""; ?></td>	
<td><?php echo number_format($sumsol99_07,2).""; ?></td>	
<td><?php echo number_format($sumsol99_08,2).""; ?></td>	
<td><?php echo number_format($sumsol99_09,2).""; ?></td>	
<td><?php echo number_format($sumsol99_10,2).""; ?></td>	
<td><?php echo number_format($sumsol99_11,2).""; ?></td>	
<td><?php echo number_format($sumsol99_12,2).""; ?></td>	
<td><?php echo number_format($sumsol99_01+$sumsol99_02+$sumsol99_03+$sumsol99_04+$sumsol99_05+$sumsol99_06+$sumsol99_07+$sumsol99_08+$sumsol99_09+$sumsol99_10+$sumsol99_11+$sumsol99_12,2).""; ?></td>	
</tr>				

</table>	
<br><br>
</div>



