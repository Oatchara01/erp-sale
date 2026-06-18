<?php include('head.php'); ?>
<body>
 <div class="w3-container"> 
	 
	 <?php
	include "dbconnect.php";
 ?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	
	
<?php if($_SESSION['name']=='รัชดาภรณ์' or $_SESSION['name']=='ธนบัตร' or $_SESSION['name']=='นิรชา' or $_SESSION['name']=='กนกพร'){ 

include('notify_sol.php');

}	?>
	
	
	
<?php
	
	
if($_SESSION['name']=='ปาลิตา' or $_SESSION['name']=='ธันย์ชนก'){
	
$strSQL = "SELECT access_code, sol_name, unit_name,product_ID,ecom_count FROM tb_product WHERE popular_2 = '1' AND close_pro = '0' AND close_out = '0' and ecom_ckk='1'";
$strSQL .= " ORDER BY number ASC";
$objQuery = mysqli_query($new, $strSQL) or die("Error Query [" . $strSQL . "]");
$Num_Rows = mysqli_num_rows($objQuery);

$j = 0; // ปรับตัวแปร $j ให้อยู่ภายนอกลูป
while ($objResult = mysqli_fetch_array($objQuery)) {
    $strSQL37 = "SELECT SUM(count_send) AS count_send, SUM(count_receive) AS count_receive FROM st__sbmain WHERE product_id = '" . $objResult["product_ID"] . "'";
    $objQuery37 = mysqli_query($new, $strSQL37);
    $objResult37 = mysqli_fetch_array($objQuery37);

    $count_send7 = $objResult37["count_send"];
    $count_receive7 = $objResult37["count_receive"];
    // คงเหลือ
    $count_pro7 = $count_receive7 - $count_send7;

    if ($count_pro7 < $objResult["ecom_count"]) {
        $j++; // เพิ่มค่าของ $j
    }
}
	
if($j > 0){	
?>	
<div class="w3-container"><img src="img/new_alern.gif" width="40" height="20" border="0" > <a href="status_almostpro.php"  target="_blank"><font color="Blue">มีรายการสินค้ายอดนิยมออนไลน์สินค้า <font color="red"><b>คงเหลือต่ำกว่ากำหนด</b></font> จำนวน <?php echo $j;?> รายการ</font></a></div><br>	
<?php 
		  }		   
		   
$strSQL = "SELECT access_code, sol_name, unit_name, product_ID FROM tb_product WHERE popular_2 = '1' AND close_pro = '0'  and close_out='1' and  close_in='1' and ecom_ckk='1'";
$strSQL .= " ORDER BY number ASC";
$objQuery = mysqli_query($new, $strSQL) or die("Error Query [" . $strSQL . "]");
$Num_Rows = mysqli_num_rows($objQuery);

$j = 0; // ปรับตัวแปร $j ให้อยู่ภายนอกลูป
while ($objResult = mysqli_fetch_array($objQuery)) {
  $j++; // เพิ่มค่าของ $j
    }

	
if($j > 0){	
?>	
<div class="w3-container"><img src="img/new_alern.gif" width="40" height="20" border="0" > <a href="status_almostpro.php"  target="_blank"><font color="Blue">มีรายการสินค้ายอดนิยมออนไลน์ <font color="red"><b>สินค้าเข้าพร้อมขาย</b></font> จำนวน <?php echo $j;?> รายการ</font></a></div><br>		
	
<?php }
	
	}
	?>			
	
<?php if($_SESSION['name']=='ปวัน​รัตน์​' or $_SESSION['name']=='ธัญนุช'){ 

$strSQLsb = "SELECT DISTINCT hos__so.ref_id 
    FROM hos__so 
    LEFT JOIN hos__subso ON hos__subso.ref_idd = hos__so.ref_id 
    LEFT JOIN tb_product ON tb_product.product_id = hos__subso.product_id 
    WHERE hos__so.status_doc = 'Approve' 
      AND group1 = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL' 
      AND sol_name LIKE '%GLUCOALL-PRO%' and hos__subso.sn !='' and iv_no NOT LIKE '%IC%' and sm_care='0'";

$objQuerysb = mysqli_query($conn,$strSQLsb) or die ("Error Query [".$strSQLsb."]");
$Num_Rowssb = mysqli_num_rows($objQuerysb);


$strSQLmr = "SELECT DISTINCT hos__br.ref_id_br 
    FROM hos__br 
    LEFT JOIN hos__subbr ON hos__subbr.ref_idd_br = hos__br.ref_id_br 
    LEFT JOIN tb_product ON tb_product.product_id = hos__subbr.product_id 
    WHERE hos__br.status_doc = 'Approve' 
      AND group1 = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL' 
      AND sol_name LIKE '%GLUCOALL-PRO%' and hos__subbr.sn !='' and sm_care='0'";

$objQuerymr = mysqli_query($conn,$strSQLmr) or die ("Error Query [".$strSQLmr."]");
$Num_Rowsmr = mysqli_num_rows($objQuerymr);	
	
		if($Num_Rowssb+$Num_Rowsmr > 0){ 	
	?>	
	
<div class="w3-third" style="flex: 1; background-color: #f0f0f0;">	
<div class="w3-container"><font color ='blue'><b> ERP SALE</b></font></div>	
	
 		
	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_glucosemkhos.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>รายงานรอส่ง SN Gluco All-Pro</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowssb+$Num_Rowsmr; ?> รายการ </b></span>
    </a>
	</div>
	</div>
	</p>
<?php 
		}
		} ?>	
<div class="w3-container">	
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
	
//SOL5

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
		<td align="right"><b><?php echo number_format($targetsol,2);?></b></td>
	   <td align="right"><b><?php echo number_format($target_allh,2);?></b></td>	
      
      
    </tr>
	
  <tr>
	  <td align="center"><b>Achieve (ยอดขาย)</b></td>
	   <td align="right"><b><?php echo number_format($sum_sol,2);?></b></td>
	   <td align="right"><b><?php echo number_format($sum_allh,2);?></b></td>	
      
    </tr>
	
 <tr>
	 <td align="center"><b>% Achieve</b></td>
	 <td align="right"><h4><b><font color='#FF4500'><?php echo number_format($percen_sol,2);?> % </font></b></h4></td>	
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
	
      <td align="center">SOL1</td>
	  <td align="right"><?php echo number_format($sumawl_sol1,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_sol1,2);?></td> 
      <td align="right"><?php echo number_format($sumawl_sol1+$sumnbm_sol1,2);?></td> 
	  <td align="right"></td>
	 <td align="right"></td>
    </tr>
	
	  <tr> 
	
      <td align="center">SOL2</td>
	  <td align="right"><?php echo number_format($sumawl_sol2,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_sol2,2);?></td> 
      <td align="right"><?php echo number_format($sumawl_sol2+$sumnbm_sol2,2);?></td> 
	  <td align="right"></td>
	 <td align="right"></td>
    </tr>
		
		
	  <tr> 
	
      <td align="center">SOL3</td>
	  <td align="right"><?php echo number_format($sumawl_sol3,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_sol3,2);?></td> 
      <td align="right"><?php echo number_format($sumawl_sol3+$sumnbm_sol3,2);?></td> 
	  <td align="right"></td>
	 <td align="right"></td>
    </tr>
		
	  <tr> 
	
      <td align="center">SOL4</td>
	  <td align="right"><?php echo number_format($sumawl_sol4,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_sol4,2);?></td> 
      <td align="right"><?php echo number_format($sumawl_sol4+$sumnbm_sol4,2);?></td> 
	  <td align="right"></td>
	 <td align="right"></td>
    </tr>
	
	  <tr> 
	
      <td align="center">SOL5</td>
	  <td align="right"><?php echo number_format($sumawl_sol5,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_sol5,2);?></td> 
      <td align="right"><?php echo number_format($sumawl_sol5+$sumnbm_sol5,2);?></td> 
	  <td align="right"></td>
	 <td align="right"></td>
    </tr>
		
	  <tr> 
	
      <td align="center">SOL6</td>
	  <td align="right"><?php echo number_format($sumawl_sol6,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_sol6,2);?></td> 
      <td align="right"><?php echo number_format($sumawl_sol6+$sumnbm_sol6,2);?></td> 
	  <td align="right"></td>
	 <td align="right"></td>
    </tr>
		<tr> 
	
      <td align="center">SOL99</td>
	  <td align="right"><?php echo number_format($sumawl_sol99,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_sol99,2);?></td> 
      <td align="right"><?php echo number_format($sumawl_sol99+$sumnbm_sol99,2);?></td> 
	  <td align="right"></td>
	 <td align="right"></td>
    </tr>
		
	 	
      <td align="center"><font color='#FF0000'>ยอดขายรวมทั้งหมด</font></td>
      <td align="right"><b><font color='#CC00FF'><?php echo number_format($sumawl_sol,2);?></font></b></td> 
	  <td align="right"><b><font color='#FF3399'><?php echo number_format($sumnbm_sol,2);?></font></b></td> 
      <td align="right"><b><font color='#660099'><?php echo number_format($sum_sol,2);?></font></b></td> 
      <td align="right"><b><font color='#FF6600'><?php echo number_format($targetsol,2);?></font></b></td> 
	  <td align="right"><b><font color='#339900'><?php echo number_format($percen_sol,2);?> % </font></b></td> 
	
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
<input  class="button3" style="width:40px;height:20px"> : ยอดขาย &nbsp;


<br><br>

<?php
 
$dataPoints = array( 
	array("y" =>  $sumary_sol1,"color" => "#330066", "label" => "SOL1" ),
	array("y" =>  $sumary_sol2,"color" => "#330066", "label" => "SOL2" ),
	array("y" =>  $sumary_sol3,"color" => "#330066", "label" => "SOL3" ),
	array("y" =>  $sumary_sol4,"color" => "#330066", "label" => "SOL4" ),
	array("y" =>  $sumary_sol5,"color" => "#330066", "label" => "SOL5" ),
	array("y" =>  $sumary_sol6,"color" => "#330066", "label" => "SOL6" )
	

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
		text: "ยอดขาย"
	},
	axisY: {
		suffix: ""
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## Bath",
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





	 
	 
	 
    </div>
