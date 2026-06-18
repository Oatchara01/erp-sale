<?php
include('head.php') ;
include "dbconnect.php";
error_reporting(0);
?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-row" style="display: flex; gap: 10px;">
    <div class="w3-third" style="flex: 1;">	
<?php 
include "notify_supsale.php";
?>
</div>
	<?php if($_SESSION["name"]=='มาลินี'){ ?>
	<div class="w3-third" style="flex: 1;">		
	
<?php 
include "notify_mhom.php";  ?>	
	
</div>	<?php } ?>		</div>	
<br>	
	
<div class="w3-quarter">
	เดือน :
	<select name="mount" id="mount" style="width:90%" class="w3-input" >
<option  value="">**Please Select**</option>
<option  value="01">มกราคม</option>
<option  value="02">กุมภาพันธ์</option>
<option  value="03">มีนาคม</option>
<option  value="04">เมษายน</option>
<option  value="05">พฤษภาคม</option>
<option  value="06">มิถุนายน</option>
<option  value="07">กรกฎาคม</option>
<option  value="08">สิงหาคม</option>
<option  value="09">กันยายน</option>
<option  value="10">ตุลาคม</option>
<option  value="11">พฤศจิกายน</option>
<option  value="12">ธันวาคม</option>

</select>
	</div>
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
if($_GET["mount"] !='' and $_GET["year"] !=''){
$mm = $_GET["mount"];
$yy = $_GET["year"];
}else{
$mm = date('m');
$yy = date('Y');
}	
	

$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;
$start_date = "$yy-$mm";

//SOL1

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='SOL1' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_sol1 = $objResult['sum_awl'];
$sumnbm_sol1 = $objResult['sum_nbm'];
$sumary_sol1 = $sumawl_sol1+$sumnbm_sol1; 
	
//SOL2

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='SOL2' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_sol2 = $objResult['sum_awl'];
$sumnbm_sol2 = $objResult['sum_nbm'];
$sumary_sol2 = $sumawl_sol2+$sumnbm_sol2; 

//SOL3

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='SOL3' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_sol3 = $objResult['sum_awl'];
$sumnbm_sol3 = $objResult['sum_nbm'];
$sumary_sol3 = $sumawl_sol3+$sumnbm_sol3; 


//SOL4

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='SOL4' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_sol4 = $objResult['sum_awl'];
$sumnbm_sol4 = $objResult['sum_nbm'];
$sumary_sol4 = $sumawl_sol4+$sumnbm_sol4; 

//SOL5

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='SOL5' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_sol5 = $objResult['sum_awl'];
$sumnbm_sol5 = $objResult['sum_nbm'];
$sumary_sol5 = $sumawl_sol5+$sumnbm_sol5; 
	
//SOL6

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='SOL6' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_sol6 = $objResult['sum_awl'];
$sumnbm_sol6 = $objResult['sum_nbm'];
$sumary_sol6 = $sumawl_sol6+$sumnbm_sol6; 	
	
$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='SOL99' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_sol99 = $objResult['sum_awl'];
$sumnbm_sol99 = $objResult['sum_nbm'];
$sumary_sol99 = $sumawl_sol99+$sumnbm_sol99; 	

$sumawl_sol = $sumawl_sol1+$sumawl_sol2+$sumawl_sol3+$sumawl_sol4+$sumawl_sol5+$sumawl_sol6+$sumawl_sol99;
$sumnbm_sol = $sumnbm_sol1+$sumnbm_sol2+$sumnbm_sol3+$sumnbm_sol4+$sumnbm_sol5+$sumnbm_sol6+$sumnbm_sol99;
$sum_sol = $sumary_sol1+$sumary_sol2+$sumary_sol3+$sumary_sol4+$sumary_sol5+$sumary_sol6+$sumary_sol99;


$strSQL1 = "SELECT * FROM tb_target WHERE ckk_type='2' and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$targetsol = $objResult1['target'];
$percen_sol = ($sum_sol/$targetsol)*100;



//E-Com

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='SOL91' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_sol91 = $objResult['sum_awl'];
$sumnbm_sol91 = $objResult['sum_nbm'];
$sumary_sol91 = $sumawl_sol91+$sumnbm_sol91; 
	
$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='SOL92' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_sol92 = $objResult['sum_awl'];
$sumnbm_sol92 = $objResult['sum_nbm'];
$sumary_sol92 = $sumawl_sol92+$sumnbm_sol92; 

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='SOL93' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_sol93 = $objResult['sum_awl'];
$sumnbm_sol93 = $objResult['sum_nbm'];
$sumary_sol93 = $sumawl_sol93+$sumnbm_sol93; 

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='SOL94' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_sol94 = $objResult['sum_awl'];
$sumnbm_sol94 = $objResult['sum_nbm'];
$sumary_sol94 = $sumawl_sol94+$sumnbm_sol94; 

$sumawl_ecom = $sumawl_sol91+$sumawl_sol92+$sumawl_sol93+$sumawl_sol94;
$sumnbm_ecom = $sumnbm_sol91+$sumnbm_sol92+$sumnbm_sol93+$sumnbm_sol94;
$sum_ecom = $sumary_sol91+$sumary_sol92+$sumary_sol93+$sumary_sol94;
	
	

$strSQL1 = "SELECT * FROM tb_target WHERE ckk_type='6' and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$targetecom = $objResult1['target'];

$percen_solecom = ($sum_ecom/$targetecom)*100;



//MM1

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='MM1' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_mm1 = $objResult['sum_awl'];
$sumnbm_mm1 = $objResult['sum_nbm'];
$sumary_mm1 = $sumawl_mm1+$sumnbm_mm1; 

$strSQL1 = "SELECT * FROM tb_target WHERE ckk_type='4' and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$targetmm1 = $objResult1['target'];

$percen_mm1 = ($sumary_mm1/$targetmm1)*100;
//MM2

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='MM2' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_mm2 = $objResult['sum_awl'];
$sumnbm_mm2 = $objResult['sum_nbm'];
$sumary_mm2 = $sumawl_mm2+$sumnbm_mm2; 

$strSQL1 = "SELECT * FROM tb_target WHERE ckk_type='5' and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$targetmm2 = $objResult1['target'];
//$percen_mm2 = ($sumary_mm2/$targetmm2)*100;
if($sumary_mm2!='0' or $sumary_mm2 !='0.00'){
	if($targetmm2 !='0.00'){
$percen_mm2 = ($sumary_mm2/$targetmm2)*100;	
	}
}
//S31

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='S31' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_s31 = $objResult['sum_awl'];
$sumnbm_s31 = $objResult['sum_nbm'];
$sumary_s31 = $sumawl_s31+$sumnbm_s31; 

$strSQL1 = "SELECT * FROM tb_target WHERE ckk_type='3' and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$targets31 = $objResult1['target'];

$percen_s31 = ($sumary_s31/$targets31)*100;
	
	
//S32

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='S32' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_s32 = $objResult['sum_awl'];
$sumnbm_s32 = $objResult['sum_nbm'];
$sumary_s32 = $sumawl_s32+$sumnbm_s32; 

$strSQL1 = "SELECT * FROM tb_target WHERE ckk_type='7' and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$targets32 = $objResult1['target'];
if($sumary_s32!='0' or $sumary_s32 !='0.00'){
	if($targets32 !='0.00'){
$percen_s32 = ($sumary_s32/$targets32)*100;	
	}
}
	
//S33

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='S33' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_s33 = $objResult['sum_awl'];
$sumnbm_s33 = $objResult['sum_nbm'];
$sumary_s33 = $sumawl_s33+$sumnbm_s33; 

$strSQL1 = "SELECT * FROM tb_target WHERE ckk_type='10' and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$targets33 = $objResult1['target'];
if($sumary_s33!='0' or $sumary_s33 !='0.00'){
	if($targets33 !='0.00'){
$percen_s33 = ($sumary_s33/$targets33)*100;	
	}
}	
	
//echo $targets32;
//sumary

$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE type_arae='2' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sum_awl = $objResult['sum_awl'];
$sum_nbm = $objResult['sum_nbm'];
$sum_all = $sum_awl+$sum_nbm;

$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE ckk_type !='0' and ckk_type !='1' and ckk_type !='8' and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$target_all = $objResult1['target'];

$percen_all = ($sum_all/$target_all)*100;



//sumary all
$ytd_1 = "$yy-01";

$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE type_arae='2' and month_sum >= '".$ytd_1."' and month_sum <= '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sum_awlh = $objResult['sum_awl'];
$sum_nbmh = $objResult['sum_nbm'];
$sum_allh = $sum_awlh+$sum_nbmh;

$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE ckk_type !='0' and ckk_type !='1' and month_no >= '".$ytd_1."' and month_no <= '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$target_allh = $objResult1['target'];

$percen_allh = ($sum_allh/$target_allh)*100;

?>


<center>
<h3 align="center">รายงานยอดขายแบบกราฟ แผนก Home Care</h3>
<h3 align="center"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></h3><br>
	
	

	
	<div class="w3-half 1">	
	
<table width="90%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr> 
	 <th width="10%"></th>
	 <th width="15%">เดือน <?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></th>
	 <th width="15%">YTD</th>
	  </tr>
  </thead>
     
	<tr>
		<td align="center"><b>Target (เป้าหมาย)</b></td>
		<td align="right"><b><?php echo number_format($target_all,2);?></b></td>
	   <td align="right"><b><?php echo number_format($target_allh,2);?></b></td>	
      
      
    </tr>
	
  <tr>
	  <td align="center"><b>Achieve (ยอดขาย)</b></td>
	   <td align="right"><b><?php echo number_format($sum_all,2);?></b></td>
	   <td align="right"><b><?php echo number_format($sum_allh,2);?></b></td>	
      
    </tr>
	
 <tr>
	 <td align="center"><b>% Achieve</b></td>
	 <td align="right"><h4><b><font color='#FF4500'><?php echo number_format($percen_all,2);?> % </font></b></h4></td>	
	  <td align="right"><h4><b><font color='#FF4500'><?php echo number_format($percen_allh,2);?> % </font></b></h4></td>	
      
    </tr>
	  
	
  
</table>
	
<br><br>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> <!--เรียกใช้ API ของ Google Chart-->
    <script type="text/javascript">
      //------เรียกใช้ package ของทำ Bar Chart
      google.charts.load('current', {'packages':['bar']});   
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
      //------ใส่ข้อมูลที่จะแสดงบนกราฟ 2 ส่วนคือ 
      //--1. บรรทัดแรกเป็น label ในแกน x (แนวตั้ง)
      //--2. บรรทัดที่ 2 เป็นต้นไปต้องเป็นจำนวน 
      //--แต่ย่ำว่าต้องเป็นตัวเลขเท่านั้น หากเป็นข้อความ var, string กราฟจะไม่แสดง
        var data = google.visualization.arrayToDataTable([
          ['ยอดการขาย', 'Target','Achieve'],  
          ['Target & Acheive', <?php echo $target_allh; ?>,<?php echo $sum_allh; ?>]
          
        ]);
	//--ส่วนตั้งค่ารูปแบบของกราฟ เช่น หัวข้อกราฟ, รูปแบบตัวอักษร, ขนาดของแท่ง, แนวของกราฟแท่ง (แนวตั้ง / แนวนอน)
        var options = {
          chart: {
            title: 'Target & Achieve', //--หัวข้อกราฟ
            subtitle: '',  //---คำอธิบายกราฟจะอยู่ใต้ title
          },
          bars: 'horizontal' //--ให้กราฟอยู่ในแนวตั้ง (vertical) / แนวนอน (horizontal)
        };
	//--ส่วนประมวลผลทำกราฟออกมาเอา id ที่ชื่อ barchart_material ไปใช้ในหน้า View ของเรา 
        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
  </head>
  <body>
  <!--ใช้ div ในการแสดงผลกราฟออกมาสามารถปรับขนาดกราฟได้ตามต้องการ-->
    <div id="barchart_material" style="width: 80%; height: 80%;"></div>
  </body>
</html>
</div>
	
	<div class="w3-half 1">	
	
	<table width="90%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr> 
	  <th width="8%">เขตการขาย </th>
    <th width="10%">ยอดขาย AWL</th>
	<th width="10%">ยอดขาย NBM</th>
    <th width="10%">ยอดขายทั้งหมด</th>
    <th width="10%">เป้าหมาย</th>
	<th width="10%">% Achieve</th>
  </tr>
  </thead>
  
  
    <tr> 
	
      <td align="center">SOL</td>
	  <td align="right"><?php echo number_format($sumawl_sol,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_sol,2);?></td> 
      <td align="right"><a href="report_solsummonth.php?sale_code=<?php echo "SOL";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sum_sol,2);?></a></td> 
	  <td align="right"><?php echo number_format($targetsol,2);?></td>
	 <td align="right"><?php echo number_format($percen_sol,2);?> %</td>
    </tr>
	
	 <tr>
	
      <td align="center">S31</td>
      <td align="right"><?php echo number_format($sumawl_s31,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s31,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S31";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_s31,2);?></a></td> 
	  <td align="right"><?php echo number_format($targets31,2);?></td>
	 <td align="right"><?php echo number_format($percen_s31,2);?> %</td>
    </tr>
	
	 <tr>
	  <td align="center">S32</td>
      <td align="right"><?php echo number_format($sumawl_s32,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s32,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S32";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_s32,2);?></a></td> 
	  <td align="right"><?php echo number_format($targets32,2);?></td>
	 <td align="right"><?php echo number_format($percen_s32,2);?> %</td>
    </tr>
		
		 <tr>
	  <td align="center">S33</td>
      <td align="right"><?php echo number_format($sumawl_s33,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s33,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S33";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_s33,2);?></a></td> 
	  <td align="right"><?php echo number_format($targets33,2);?></td>
	 <td align="right"><?php echo number_format($percen_s33,2);?> %</td>
    </tr>
	
	 <tr>
      <td align="center">MM1</td>
      <td align="right"><?php echo number_format($sumawl_mm1,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_mm1,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "MM1";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_mm1,2);?></a></td> 
	  <td align="right"><?php echo number_format($targetmm1,2);?></td>
	 <td align="right"><?php echo number_format($percen_mm1,2);?> %</td>
    </tr>
	
	<tr>
		
      <td align="center">MM2</td>
      <td align="right"><?php echo number_format($sumawl_mm2,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_mm2,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "MM2";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_mm2,2);?></a></td> 
	  <td align="right"><?php echo number_format($targetmm2,2);?></td>
	 <td align="right"><?php echo number_format($percen_mm2,2);?> %</td>
    </tr>
	
  <tr>
	  
      <td align="center">Ecom</td>
      <td align="right"><?php echo number_format($sumawl_ecom,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_ecom,2);?></td> 
      <td align="right"><?php echo number_format($sum_ecom,2);?></td> 
	  <td align="right"><?php echo number_format($targetecom,2);?></td>
	 <td align="right"><?php echo number_format($percen_solecom,2);?> %</td>
    </tr>
	
 <tr>
	 	
      <td align="center"><font color='#FF0000'>ยอดขายรวมทั้งหมด</font></td>
      <td align="right"><b><font color='#CC00FF'><?php echo number_format($sum_awl,2);?></font></b></td> 
	  <td align="right"><b><font color='#FF3399'><?php echo number_format($sum_nbm,2);?></font></b></td> 
      <td align="right"><b><font color='#660099'><?php echo number_format($sum_all,2);?></font></b></td> 
      <td align="right"><b><font color='#FF6600'><?php echo number_format($target_all,2);?></font></b></td> 
	  <td align="right"><b><font color='#339900'><?php echo number_format($percen_all,2);?> % </font></b></td> 
	
    </tr>
	  
	
  
</table>
	
<br><br>
<style>
	
.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#FF3399;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#330066;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}

</style>

<?php /*<input  class="button3" style="width:40px;height:20px "> : ยอดขาย AWL &nbsp;
<input  class="button2" style="width:40px;height:20px"> : ยอดขาย NBM &nbsp;*/ ?>
<input  class="button3" style="width:40px;height:20px"> : เปอร์เซ็นต์ยอดขาย &nbsp;


<br><br>

<?php
 
$dataPoints = array( 
	array("y" =>  $percen_sol,"color" => "#330066", "label" => "SOL" ),
	array("y" =>  $percen_s31,"color" => "#330066", "label" => "S31" ),
	array("y" =>  $percen_s32,"color" => "#330066", "label" => "S32" ),
	array("y" =>  $percen_mm1,"color" => "#330066", "label" => "MM1" ),
	array("y" =>  $percen_mm2,"color" => "#330066", "label" => "MM2" ),
	array("y" =>  $percen_sol99,"color" => "#330066", "label" => "Ecom" )
	
	

);
 
?>
<!DOCTYPE HTML>





<html>
<head>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	//theme: "theme3",
	theme: "light1",
	
title:{
		text: "เปอร์เซ็นต์ยอดขาย"
	},
	axisY: {
		suffix: ""
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## percent",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
	
 <body>

<div id="chartContainer" style="height: 90%; width: 100%;"></div>
<script src="js/canvasjs.min.js"></script>
</body>
</html>	
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			</div></div>	</form>
	
<!--<meta http-equiv="refresh" content="20">-->
<br><br>
<div id="cr_bar"><?php include "foot.php"; ?></div>



