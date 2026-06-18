<?php
include "head.php";
include "dbconnect.php";
 ?>

<div class="w3-white">
<div class="w3-container w3-padding-large">
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	
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

//S11

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='S11' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_s11 = $objResult['sum_awl'];
$sumnbm_s11 = $objResult['sum_nbm'];
$sumary_s11 = $sumawl_s11+$sumnbm_s11; 

$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE zone_code ='S11'  and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
$target_s11 = $objResult1['target'];

$percen_s11 = ($sumary_s11/$target_s11)*100;

	
//S12

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='S12' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_s12 = $objResult['sum_awl'];
$sumnbm_s12 = $objResult['sum_nbm'];
$sumary_s12 = $sumawl_s12+$sumnbm_s12; 


$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE zone_code ='S12'  and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
$target_s12 = $objResult1['target'];

$percen_s12 = ($sumary_s12/$target_s12)*100;


//S13 AWL

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='S13' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_s13 = $objResult['sum_awl'];
$sumnbm_s13 = $objResult['sum_nbm'];
$sumary_s13 = $sumawl_s13+$sumnbm_s13; 


$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE zone_code ='S13'  and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
$target_s13 = $objResult1['target'];

//$percen_s13 = ($sumary_s13/$target_s13)*100;
if($target_s13=='0.00'){
$percen_s13='0.00';
}else{
$percen_s13 = ($sumary_s13/$target_s13)*100;
}
//S14 AWL

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='S14' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_s14 = $objResult['sum_awl'];
$sumnbm_s14 = $objResult['sum_nbm'];
$sumary_s14 = $sumawl_s14+$sumnbm_s14; 


$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE zone_code ='S14'  and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
$target_s14 = $objResult1['target'];


	
if($target_s14=='0.00'){
$percen_s14='0.00';
}else{
$percen_s14 = ($sumary_s14/$target_s14)*100;
}

//S15 AWL

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='S15' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_s15 = $objResult['sum_awl'];
$sumnbm_s15 = $objResult['sum_nbm'];
$sumary_s15 = $sumawl_s15+$sumnbm_s15; 

$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE zone_code ='S15'  and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
$target_s15 = $objResult1['target'];

//$percen_s15 = ($sumary_s15/$target_s15)*100;
if($target_s15=='0.00'){
$percen_s15='0.00';	
}else{
$percen_s15 = ($sumary_s15/$target_s15)*100;
}
//S16 AWL

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='S16' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_s16 = $objResult['sum_awl'];
$sumnbm_s16 = $objResult['sum_nbm'];
$sumary_s16 = $sumawl_s16+$sumnbm_s16; 

$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE zone_code ='S16'  and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
$target_s16 = $objResult1['target'];


	
if($target_s16=='0.00'){
$percen_s16='0.00';
}else{
$percen_s16 = ($sumary_s16/$target_s16)*100;
}	

//S17 AWL

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='S17' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_s17 = $objResult['sum_awl'];
$sumnbm_s17 = $objResult['sum_nbm'];
$sumary_s17 = $sumawl_s17+$sumnbm_s17; 

$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE zone_code ='S17'  and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
$target_s17 = $objResult1['target'];


if($target_s17=='0.00'){
$percen_s17='0.00';
}else{
$percen_s17 = ($sumary_s17/$target_s17)*100;
}	

//S21 AWL

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='S21' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_s21 = $objResult['sum_awl'];
$sumnbm_s21 = $objResult['sum_nbm'];
$sumary_s21 = $sumawl_s21+$sumnbm_s21; 


$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE zone_code ='S21'  and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
$target_s21 = $objResult1['target'];

//$percen_s21 = ($sumary_s21/$target_s21)*100;
if($target_s21=='0.00'){
$percen_s21='0.00';
}else{
$percen_s21 = ($sumary_s21/$target_s21)*100;
	
}
//S22 AWL

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='S22' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_s22 = $objResult['sum_awl'];
$sumnbm_s22 = $objResult['sum_nbm'];
$sumary_s22 = $sumawl_s22+$sumnbm_s22; 

$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE zone_code ='S22'  and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
$target_s22 = $objResult1['target'];

$percen_s22 = ($sumary_s22/$target_s22)*100;

//S23 AWL

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='S23' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_s23 = $objResult['sum_awl'];
$sumnbm_s23 = $objResult['sum_nbm'];
$sumary_s23 = $sumawl_s23+$sumnbm_s23; 

$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE zone_code ='S23'  and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
$target_s23 = $objResult1['target'];

if($target_s23=='0.00'){
$percen_s23 = ($sumary_s23/$target_s23)*100;
}else{
$percen_s23='0.00';
}
//S24 AWL

$strSQL = "SELECT *  FROM tb_sumall WHERE sale_cose='S24' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumawl_s24 = $objResult['sum_awl'];
$sumnbm_s24 = $objResult['sum_nbm'];
$sumary_s24 = $sumawl_s24+$sumnbm_s24; 


$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE zone_code ='S24'  and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
$target_s24 = $objResult1['target'];

$percen_s24 = ($sumary_s24/$target_s24)*100;

$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE type_arae='1' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sum_awl = $objResult['sum_awl'];
$sum_nbm = $objResult['sum_nbm'];
$sum_all = $sum_awl+$sum_nbm;

$strSQL1 = "SELECT * FROM tb_target WHERE ckk_type='1' and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$target = $objResult1['target'];

$percen = ($sum_all/$target)*100;



//sumary all
$ytd_1 = "$yy-01";
	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE type_arae='1' and month_sum >= '".$ytd_1."' and month_sum <= '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sum_awlh = $objResult['sum_awl'];
$sum_nbmh = $objResult['sum_nbm'];
$sum_allh = $sum_awlh+$sum_nbmh;

$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE ckk_type ='1' and month_no >= '".$ytd_1."' and month_no <= '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);
$target_allh = $objResult1['target'];

$percen_allh = ($sum_allh/$target_allh)*100;





?>
<center>
<h3 align="center">รายงานยอดขายแบบกราฟ แผนกโรงพยาบาล</h3>
<h3 align="center"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></h3>
	</center>
	<br><br>



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
		<td align="right"><b><?php echo number_format($target,2);?></b></td>
	   <td align="right"><b><?php echo number_format($target_allh,2);?></b></td>	
      
      
    </tr>
	
  <tr>
	  <td align="center"><b>Achieve (ยอดขาย)</b></td>
	   <td align="right"><b><?php echo number_format($sum_all,2);?></b></td>
	   <td align="right"><b><?php echo number_format($sum_allh,2);?></b></td>	
      
    </tr>
	
 <tr>
	 <td align="center"><b>% Achieve</b></td>
	 <td align="right"><h4><b><font color='#FF4500'><?php echo number_format($percen,2);?> % </font></b></h4></td>	
	  <td align="right"><h4><b><font color='#FF4500'><?php echo number_format($percen_allh,2);?> % </font></b></h4></td>	
      
    </tr>
	  
	
  
</table>
	
<br><br>


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
          ['Target & Achieve', <?php echo $target_allh; ?>,<?php echo $sum_allh; ?>]
          
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
 
  <!--ใช้ div ในการแสดงผลกราฟออกมาสามารถปรับขนาดกราฟได้ตามต้องการ-->
    <div id="barchart_material" style="width: 80%; height: 80%;"></div>


</div>



<div class="w3-half 1">


<table width="60%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr>
    <th width="10%">เขตการขาย </th>
    <th width="10%">ยอดขาย AWL</th>
	<th width="10%">ยอดขาย NBM</th>
    <th width="10%">ยอดขายทั้งหมด</th>
    <th width="10%">เป้าหมาย</th>
	<th width="10%">% Achieve</th>
  </tr>
  </thead>
  
  
    <tr>
		<?php //$start_date ?>
      <td align="center">S11</td>
      <td align="right"><?php echo number_format($sumawl_s11,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s11,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S11";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_s11,2);?></a></td> 
	  <td align="right"><?php echo number_format($target_s11,2);?></td>
	 <td align="right"><?php echo number_format($percen_s11,2);?> %</td>
    </tr>
	
	
	    <tr>
      <td align="center">S12</td>
      <td align="right"><?php echo number_format($sumawl_s12,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s12,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S12";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_s12,2);?></a></td> 
	 <td align="right"><?php echo number_format($target_s12,2);?></td>
	 <td align="right"><?php echo number_format($percen_s12,2);?> %</td>
    </tr>
	
	    <tr>
      <td align="center">S13</td>
      <td align="right"><?php echo number_format($sumawl_s13,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s13,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S13";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_s13,2);?></a></td> 
	  <td align="right"><?php echo number_format($target_s13,2);?></td>
	 <td align="right"><?php echo number_format($percen_s13,2);?> %</td>
    </tr>
	
	    <tr>
      <td align="center">S14</td>
      <td align="right"><?php echo number_format($sumawl_s14,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s14,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S14";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_s14,2);?></a></td> 
	  <td align="right"><?php echo number_format($target_s14,2);?></td>
	 <td align="right"><?php echo number_format($percen_s14,2);?> %</td>
    </tr>
	
	    <tr>
      <td align="center">S15</td>
      <td align="right"><?php echo number_format($sumawl_s15,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s15,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S15";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_s15,2);?></a></td> 
	 <td align="right"><?php echo number_format($target_s15,2);?></td>
	 <td align="right"><?php echo number_format($percen_s15,2);?> %</td>
    </tr>
	
	    <tr>
      <td align="center">S16</td>
      <td align="right"><?php echo number_format($sumawl_s16,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s16,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S16";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_s16,2);?></a></td> 
	 <td align="right"><?php echo number_format($target_s16,2);?></td>
	 <td align="right"><?php echo number_format($percen_s16,2);?> %</td>
    </tr>
	
	    <tr>
      <td align="center">S17</td>
      <td align="right"><?php echo number_format($sumawl_s17,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s17,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S17";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_s17,2);?></a></td> 
	  <td align="right"><?php echo number_format($target_s17,2);?></td>
	 <td align="right"><?php echo number_format($percen_s17,2);?> %</td>
    </tr>

	   <tr>
      <td align="center">S21</td>
      <td align="right"><?php echo number_format($sumawl_s21,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s21,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S21";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_s21,2);?></a></td> 
	 <td align="right"><?php echo number_format($target_s21,2);?></td>
	 <td align="right"><?php echo number_format($percen_s21,2);?> %</td>
    </tr>

	   <tr>
      <td align="center">S22</td>
      <td align="right"><?php echo number_format($sumawl_s22,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s22,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S22";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_s22,2);?></a></td> 
	  <td align="right"><?php echo number_format($target_s22,2);?></td>
	 <td align="right"><?php echo number_format($percen_s22,2);?> %</td>
    </tr>

	   <tr>
      <td align="center">S23</td>
      <td align="right"><?php echo number_format($sumawl_s23,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s23,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S23";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_s23,2);?></a></td> 
	  <td align="right"><?php echo number_format($target_s23,2);?></td>
	 <td align="right"><?php echo number_format($percen_s23,2);?> %</td>
    </tr>

	   <tr>
      <td align="center">S24</td>
      <td align="right"><?php echo number_format($sumawl_s24,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s24,2);?></td> 
      <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S24";?>&start_date=<?php echo $start_date;?>"  target="_blank" ><?php echo number_format($sumary_s24,2);?></a></td> 
	  <td align="right"><?php echo number_format($target_s24,2);?></td>
	 <td align="right"><?php echo number_format($percen_s24,2);?> %</td>
    </tr>

	  
	
 <tr>
      <td align="center"><b><font color='#FF0000'>ยอดขายรวมทั้งหมด</font></b></td>
      <td align="right"><b><font color='#CC00FF'><?php echo number_format($sum_awl,2);?></font></b></td> 
	  <td align="right"><b><font color='#FF3399'><?php echo number_format($sum_nbm,2);?></font></b></td> 
      <td align="right"><b><font color='#660099'><?php echo number_format($sum_all,2);?></font></b></td> 
      <td align="right"><b><font color='#FF6600'><?php echo number_format($target,2);?></font></b></td> 
	  <td align="right"><b><font color='#339900'><?php echo number_format($percen,2);?> % </font></b></td> 
	
    </tr>
	 	  
	
  
</table>


<br><br>
<style>
	
.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#FFFFFF;  padding: 0px 0px; margin: 0px 0px;}
.button3 {border-radius: 2px; background-color:#330066;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}

</style>

<input  class="button3" style="width:40px;height:20px"> : เปอร์เซ็นต์ยอดขาย   &nbsp;


<br><br>

<?php
 
$dataPoints = array( 
	array("y" =>  $percen_s11,"color" => "#330066", "label" => "S11" ),
	array("y" =>  $percen_s12,"color" => "#330066", "label" => "S12" ),
	array("y" =>  $percen_s13,"color" => "#330066", "label" => "S13" ),
	array("y" =>  $percen_s14,"color" => "#330066", "label" => "S14" ),
	array("y" =>  $percen_s15,"color" => "#330066", "label" => "S15" ),
	array("y" =>  $percen_s16,"color" => "#330066", "label" => "S16" ),
	array("y" =>  $percen_s17,"color" => "#330066", "label" => "S17" ),
	array("y" =>  $percen_s21,"color" => "#330066", "label" => "S21" ),
	array("y" =>  $percen_s22,"color" => "#330066", "label" => "S22" ),
	array("y" =>  $percen_s23,"color" => "#330066", "label" => "S23" ),
	array("y" =>  $percen_s24,"color" => "#330066", "label" => "S24" )
	

);
 
?>
<!DOCTYPE HTML>





<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
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


<div id="chartContainer" style="height: 100%; width: 100%;"></div>
<script src="js/canvasjs.min.js"></script>
<br><br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>


<input  class="button2" style="width:40px;height:20px">

</div>



		
		</form></div></div></div>

<!--<meta http-equiv="refresh" content="20">-->
<br>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
