
<!DOCTYPE html>
<html>
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


	<script> //tab
function showUser2(str) {
    if (str2 == "") {
        document.getElementById("txtHint2").innerHTML = "";
        return;
    } 
	if (str3 == "") {
		document.getElementById("txtHint3").innerHTML = "";
        return;
	}
	else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState2 == 4 && this.status == 200) {
                document.getElementById("txtHint2").innerHTML = this.responseText;
            }
			if (this.readyState3 == 4 && this.status == 200) {
                document.getElementById("txtHint3").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getuser2.php?q="+str2"&u="+str3,true);
        xmlhttp.send();
    }
}

function openCity(cityName) {
  var i;
  var x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  document.getElementById(cityName).style.display = "block";  
}
</script>
<script>
function openCity1(cityName) {
  var i;
  var x = document.getElementsByClassName("city1");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  document.getElementById(cityName).style.display = "block";  
}

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function myFunction() {
  var x = document.getElementById("Demo");
  if (x.className.indexOf("w3-show") == -1) {  
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>
<style>
#inner {
  display: table;
  margin: 0 auto;
  border: 0px solid black;
}

#outer {
  border: 0px solid red;
  width:100%
}
</style>

<?php include "dbconnect.php"; ?>

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



$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE type_arae ='2' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumsol_awl = $objResult['sum_awl'];
$sumsol_nbm = $objResult['sum_nbm'];
$sumsol_all = $sumsol_awl+$sumsol_nbm;

$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE ckk_type !='1' and ckk_type !='0' and ckk_type !='8' and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$targetsol_all = $objResult1['target'];

$percensol_all = ($sumsol_all/$targetsol_all)*100;


	

$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE type_arae ='1' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumhos_awl = $objResult['sum_awl'];
$sumhos_nbm = $objResult['sum_nbm'];
$sumhos_all = $sumhos_awl+$sumhos_nbm;

$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE ckk_type ='1' and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$targethos_all = $objResult1['target'];

$percenhos_all = ($sumhos_all/$targethos_all)*100;
	
$strSQLc = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose='IC' and month_sum = '".$start_date."'";
$objQueryc = mysqli_query($conn,$strSQLc) or die ("Error Query [".$strSQLc."]");
$objResultc = mysqli_fetch_array($objQueryc);

$sumic_awl = $objResultc['sum_awl'];
$sumic_nbm = $objResultc['sum_nbm'];	
	
	
	
$strSQL8 = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE sale_cose!='IC' and type_arae ='0' and month_sum = '".$start_date."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

$sumsol_awl8 = $objResult8['sum_awl'];
$sumsol_nbm8 = $objResult8['sum_nbm'];
$sumsol_all8 = $sumsol_awl8+$sumsol_nbm8;	

	
$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE ckk_type ='8'  and month_no = '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$targetsm_all = $objResult1['target'];

$percensm_all = ($sumsol_all8/$targetsm_all)*100;		
	
	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE type_arae ='3' and month_sum = '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumext_awl = $objResult['sum_awl'];
$sumext_nbm = $objResult['sum_nbm'];
$sumext_all = $sumext_awl+$sumext_nbm;
	
	


$sum_awl = $sumsol_awl+$sumhos_awl+$sumsol_awl8+$sumic_awl+$sumext_awl;
$sum_nbm = $sumsol_nbm+$sumhos_nbm+$sumsol_nbm8+$sumic_nbm+$sumext_nbm;
$sum_all = $sumhos_all+$sumsol_all+$sumsol_all8+$sumic_awl+$sumic_nbm+$sumext_all;
$target_all =$targethos_all+$targetsol_all+$targetsm_all+$sumext_all;
$percen_all = ($sum_all/$target_all)*100;

	
	
//YTD
$ytd_1 = "$yy-01";
	
	//and type_arae !='0'
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE  month_sum >= '".$ytd_1."' and month_sum <= '".$start_date."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumytd_awl = $objResult['sum_awl'];
$sumytd_nbm = $objResult['sum_nbm'];
$sumytd_all = $sumytd_awl+$sumytd_nbm;
	
	
$strSQL = "SELECT SUM(sum_awl) As sum_awl,SUM(sum_nbm) As sum_nbm   FROM tb_sumall WHERE type_arae ='3' and month_sum >= '".$ytd_1."' and month_sum <= '".$start_date."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$sumext_awl = $objResult['sum_awl'];
$sumext_nbm = $objResult['sum_nbm'];
$sumext_all1 = $sumext_awl+$sumext_nbm;
	
	

$strSQL1 = "SELECT SUM(target) AS target FROM tb_target WHERE ckk_type !='0' and month_no >= '".$ytd_1."' and month_no <= '".$start_date."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$targetytd_all = $objResult1['target']+$sumext_all1;

$percenytd_all = ($sumytd_all/$targetytd_all)*100;	
$per_all  = ($targetytd_all/$targetytd_all)*100;	
if($year=='2567'){ 	
$percenytdne_all = ($sumytd_all/300000000)*100;		
}else if($year=='2568'){
$percenytdne_all = ($sumytd_all/350000000)*100;	
}else if($year=='2569'){
$percenytdne_all = ($sumytd_all/400000000)*100;		
}
?>

<html lang="en-US">
<body>
	

<center>
<h3 align="center">รายงานยอดขายรวม</h3>
<h3 align="center"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></h3>
<br><br>
	
<div class="w3-half 1">	
	
<table width="90%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr> 
	 <th width="10%"></th>
	 <th width="15%">เดือน <?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></th>
	 <th width="15%">YTD</th>
	 <th width="15%">เป้า &nbsp;&nbsp;<?php echo $year; ?></th>
	  </tr>
  </thead>
     
	<tr>
    <td align="center"><b>Target (เป้าหมาย)</b></td>
    <td align="right"><b><?php echo number_format($target_all,2);?></b></td>
    <td align="right"><b><?php echo number_format($targetytd_all,2);?></b></td>	
    <td align="right"><b><?php if($year=='2567'){ echo number_format(300000000,2); }else if($year=='2568'){  echo number_format(350000000,2);  }else if($year=='2569'){   echo number_format(400000000,2); } ?></b></td>	
  </tr>
	
  <tr>
	  <td align="center"><b>Achieve (ยอดขาย)</b></td>
	   <td align="right"><b><?php echo number_format($sum_all,2);?></b></td>
	   <td align="right"><b><?php echo number_format($sumytd_all,2);?></b></td>	
       <td align="right"><b><?php echo number_format($sumytd_all,2);?></b></td>	
    </tr>
	
 <tr>
	 <td align="center"><b>% Achieve</b></td>
	 <td align="right"><h4><b><font color='#FF4500'><?php echo number_format($percen_all,2);?> % </font></b></h4></td>	
	  <td align="right"><h4><b><font color='#FF4500'><?php echo number_format($percenytd_all,2);?> % </font></b></h4></td>	
      <td align="right"><h4><b><font color='#FF4500'><?php echo number_format($percenytdne_all,2);?> % </font></b></h4></td>	
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
          ['Target & Acheive', <?php echo $targetytd_all; ?>,<?php echo $sumytd_all; ?>]
          
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
<table width="100%" border="1" cellpadding="0"  cellspacing="0" align="center">
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
      <td align="center">แผนกโรงพยาบาล</td>
      <td align="right"><?php echo number_format($sumhos_awl,2);?></td> 
	  <td align="right"><?php echo number_format($sumhos_nbm,2);?></td> 
      <td align="right"><a href="report_hosgraph.php" target="_blank"><?php echo number_format($sumhos_all,2);?></a></td> 
	  <td align="right"><?php echo number_format($targethos_all,2);?></td>
	 <td align="right"><?php echo number_format($percenhos_all,2);?> %</td>
    </tr>
	
	<tr>
      <td align="center">แผนก Home Care</td>
      <td align="right"><?php echo number_format($sumsol_awl,2);?></td> 
	  <td align="right"><?php echo number_format($sumsol_nbm,2);?></td> 
      <td align="right"><a href="report_solgraph.php" target="_blank"><?php echo number_format($sumsol_all,2);?></a></td> 
	  <td align="right"><?php echo number_format($targetsol_all,2);?></td>
	 <td align="right"><?php echo number_format($percensol_all,2);?> %</td>
    </tr>
	
	
	<tr>
      <td align="center">แผนก Home Care Extra</td>
      <td align="right"><?php echo number_format($sumext_awl,2);?></td> 
	  <td align="right"><?php echo number_format($sumext_nbm,2);?></td> 
      <td align="right"><?php echo number_format($sumext_all,2);?></td> 
	  <td align="right"><?php echo number_format(0.00,2);?></td>
	 <td align="right"><?php echo number_format(0.00,2);?> %</td>
    </tr>
	 
	 <tr>
      <td align="center">แผนก อื่นๆ</td>
      <td align="right"><?php echo number_format($sumsol_awl8,2);?></td> 
	  <td align="right"><?php echo number_format($sumsol_nbm8,2);?></td> 
      <td align="right"><?php echo number_format($sumsol_all8,2);?></td> 
	  <td align="right"><?php echo number_format($targetsm_all,2);?></td>
	 <td align="right"><?php echo number_format($percensm_all,2);?> %</td>
    </tr>
	
		 <tr>
      <td align="center">IC</td>
      <td align="right"><?php echo number_format($sumic_awl,2);?></td> 
	  <td align="right"><?php echo number_format($sumic_nbm,2);?></td> 
      <td align="right"><?php echo number_format($sumic_awl+$sumic_nbm,2);?></td> 
	  <td align="right"><?php echo number_format(0,2);?></td>
	 <td align="right"><?php echo number_format(0,2);?> %</td>
    </tr>
	
 <tr>
	 
	 
      <td align="center"><b><font color='#FF0000'>ยอดขายรวมทั้งหมด</font></b></td>
      <td align="right"><h4><b><font color='#CC00FF'><?php echo number_format($sum_awl,2);?></font></b></h4></td> 
	  <td align="right"><h4><b><font color='#FF3399'><?php echo number_format($sum_nbm,2);?></font></b></h4></td> 
      <td align="right"><h4><b><font color='#660099'><?php echo number_format($sum_all,2);?></font></b></h4></td> 
      <td align="right"><h4><b><font color='#FF6600'><?php echo number_format($target_all,2);?></font></b></h4></td> 
	  <td align="right"><h4><b><font color='#339900'><?php echo number_format($percen_all,2);?> % </font></b></h4></td> 
	
    </tr>
	  
	
  
</table>
	<br>
	<style>
	
.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#FF3399;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#330066;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}

</style>

<input  class="button3" style="width:40px;height:20px"> : เปอร์เซ็นต์ยอดขาย &nbsp;


<br>

<?php
 
$dataPoints = array( 
	array("y" =>  $percensol_all,"color" => "#330066", "label" => "Home Care" ),
	array("y" =>  $percenhos_all,"color" => "#330066", "label" => "Hospital" ),
	array("y" =>  $per_all,"color" => "#FFFFFF", "label" => "." )
	
	

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
</head>
	
 <body>

<div id="chartContainer" style="height: 90%; width: 100%;"></div>
<script src="js/canvasjs.min.js"></script>
</body>
</html>	
	
	
	
	
</div>
	
	
	
	
	
	
<?php/*	
<div id="piechart"></div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// ใส่ข้อมูลลงไปในแผนภูมิวงกลม
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Task', 'Sale Report'],
	  ['แผนก Home Care', <?php echo $sumsol_all;?>],
	  ['แผนกโรงพยาบาล', <?php echo $sumhos_all;?>]
  
	  
 
]);

  // ชื่อหัข้อวงกลม ขนาด และความสูงของแผนภูมิวงกลม
  var options = {'title':'ยอดขาย', 'width':650, 'height':500};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>*/ ?>

</body>
</html>
	
	
	
	