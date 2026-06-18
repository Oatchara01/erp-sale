<?php
include "head.php";
include "dbconnect.php";
 ?>
<div class="w3-white">
<div class="w3-container w3-padding-large">
		
<div class="w3-panel w3-light-gray"><h3>รายงานแบบสอบถาม</h3></div>
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

//SOL1

$strSQL1 = "SELECT *  FROM tb_research_showroom WHERE date_research LIKE '%".$start_date."%' and research_ckk='1'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows11 = mysqli_num_rows($objQuery1);
$objResult1 = mysqli_fetch_array($objQuery1);

if($Num_Rows11 > 0){
$Num_Rows1 =$Num_Rows11;	
}else{
$Num_Rows1 ='0';	
}

$strSQL2 = "SELECT *  FROM tb_research_showroom WHERE date_research LIKE '%".$start_date."%'  and research_ckk='2'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows21 = mysqli_num_rows($objQuery2);
$objResult2 = mysqli_fetch_array($objQuery2);

if($Num_Rows21 > 0){
$Num_Rows2 =$Num_Rows21;	
}else{
$Num_Rows2='0';	
}

$strSQL3 = "SELECT *  FROM tb_research_showroom WHERE date_research LIKE '%".$start_date."%'  and research_ckk='3'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows31 = mysqli_num_rows($objQuery3);
$objResult3 = mysqli_fetch_array($objQuery3);

if($Num_Rows31 > 0){
$Num_Rows3 =$Num_Rows31;	
}else{
$Num_Rows3='0';	
}

$strSQL4 = "SELECT *  FROM tb_research_showroom WHERE date_research LIKE '%".$start_date."%'  and research_ckk='4'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows41 = mysqli_num_rows($objQuery4);
$objResult4 = mysqli_fetch_array($objQuery4);
	
if($Num_Rows41 > 0){
$Num_Rows4 =$Num_Rows41;	
}else{
$Num_Rows4 = '0';	
}

	
$strSQL5 = "SELECT *  FROM tb_research_showroom WHERE date_research LIKE '%".$start_date."%'  and research_ckk='5'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rows51 = mysqli_num_rows($objQuery5);
$objResult5 = mysqli_fetch_array($objQuery5);
	
if($Num_Rows51 > 0){
$Num_Rows5 =$Num_Rows51;	
}else{
$Num_Rows5 = '0';	
}
	
	
$strSQL6 = "SELECT *  FROM tb_research_showroom WHERE date_research LIKE '%".$start_date."%'  and research_ckk='6'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$Num_Rows61 = mysqli_num_rows($objQuery6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
if($Num_Rows61 > 0){
$Num_Rows6 =$Num_Rows61;	
}else{
$Num_Rows6 = '0';	
}
	
	
$strSQL7 = "SELECT *  FROM tb_research_showroom WHERE date_research LIKE '%".$start_date."%'  and research_ckk='7'";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows71 = mysqli_num_rows($objQuery7);
$objResult7 = mysqli_fetch_array($objQuery7);
	
if($Num_Rows71 > 0){
$Num_Rows7 =$Num_Rows71;	
}else{
$Num_Rows7 = '0';	
}
	
	
$strSQL8 = "SELECT *  FROM tb_research_showroom WHERE date_research LIKE '%".$start_date."%'  and research_ckk='8'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$Num_Rows81 = mysqli_num_rows($objQuery8);
$objResult8 = mysqli_fetch_array($objQuery8);
	
if($Num_Rows81 > 0){
$Num_Rows8 =$Num_Rows81;	
}else{
$Num_Rows8 = '0';	
}
	
	
$strSQL9 = "SELECT *  FROM tb_research_showroom WHERE date_research LIKE '%".$start_date."%'  and research_ckk='9'";
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows91 = mysqli_num_rows($objQuery9);
$objResult9 = mysqli_fetch_array($objQuery9);
	
if($Num_Rows91 > 0){
$Num_Rows9 =$Num_Rows91;	
}else{
$Num_Rows9 = '0';	
}
	
	
$strSQL10 = "SELECT *  FROM tb_research_showroom WHERE date_research LIKE '%".$start_date."%'  and research_ckk='10'";
$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$Num_Rows101 = mysqli_num_rows($objQuery10);
$objResult10 = mysqli_fetch_array($objQuery10);
	
if($Num_Rows101 > 0){
$Num_Rows10 =$Num_Rows101;	
}else{
$Num_Rows10 = '0';	
}	


$strSQL15 = "SELECT *  FROM tb_research_showroom WHERE date_research LIKE '%".$start_date."%'";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$Num_Rows15 = mysqli_num_rows($objQuery15);
$objResult15 = mysqli_fetch_array($objQuery15);



$strSQL16 = "SELECT SUM(research_ckk) AS sum_research  FROM tb_research_showroom WHERE date_research LIKE '%".$start_date."%'";
$objQuery16 = mysqli_query($conn,$strSQL16) or die ("Error Query [".$strSQL16."]");
$Num_Rows16 = mysqli_num_rows($objQuery16);
$objResult16 = mysqli_fetch_array($objQuery16);

$sum_research = $objResult16["sum_research"];
$sum_all = $Num_Rows15*4;

$percent_1 = ($Num_Rows1/$Num_Rows15)*100 ;
$percent_2 = ($Num_Rows2/$Num_Rows15)*100 ;
$percent_3 = ($Num_Rows3/$Num_Rows15)*100 ;
$percent_4 = ($Num_Rows4/$Num_Rows15)*100 ;
$percent_5 = ($Num_Rows5/$Num_Rows15)*100 ;
$percent_6 = ($Num_Rows6/$Num_Rows15)*100 ;
$percent_7 = ($Num_Rows7/$Num_Rows15)*100 ;
$percent_8 = ($Num_Rows8/$Num_Rows15)*100 ;
$percent_9 = ($Num_Rows9/$Num_Rows15)*100 ;
$percent_10 = ($Num_Rows10/$Num_Rows15)*100 ;	
	
$percent_16 = ($sum_research/$sum_all)*100 ;
	
?>


<center>
<h3 align="center">รายงานคะแนนความพึงพอใจการรับบริการหน้าโชว์รูม</h3>
<h3 align="center"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></h3><br>
	
	

	
	
	
	<table width="90%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr> 
	  <th width="8%">ผลการประเมิน</th>
    <th width="10%">จำนวนผู้ประเมิน</th>
	<th width="10%">คิดเป็นเปอร์เซ็น</th>
      </tr>
  </thead>
  
  
    <tr> 
	
      <td align="center">10</td>
	  <td align="right"><?php echo $Num_Rows10; ?></td> 
	  <td align="right"><?php echo number_format($percent_10,2);?></td> 
      
    </tr>
	
	 <tr>
	
      <td align="center">9</td>
      <td align="right"><?php echo $Num_Rows9; ?></td> 
	  <td align="right"><?php echo number_format($percent_9,2);?></td> 
      
    </tr>
	
	 <tr>
		
      <td align="center">8</td>
      <td align="right"><?php echo $Num_Rows8; ?></td> 
	  <td align="right"><?php echo number_format($percent_8,2);?></td> 
      
    </tr>
	
	<tr>
		
      <td align="center">7</td>
      <td align="right"><?php echo $Num_Rows7; ?></td> 
	  <td align="right"><?php echo number_format($percent_7,2);?></td> 
      
    </tr>
	
	<tr> 
	
      <td align="center">6</td>
	  <td align="right"><?php echo $Num_Rows6; ?></td> 
	  <td align="right"><?php echo number_format($percent_6,2);?></td> 
      
    </tr>
	
	 <tr>
	
      <td align="center">5</td>
      <td align="right"><?php echo $Num_Rows5; ?></td> 
	  <td align="right"><?php echo number_format($percent_5,2);?></td> 
      
    </tr>
	
	 <tr>
		
      <td align="center">4</td>
      <td align="right"><?php echo $Num_Rows4; ?></td> 
	  <td align="right"><?php echo number_format($percent_4,2);?></td> 
      
    </tr>
	
	<tr>
		
      <td align="center">3</td>
      <td align="right"><?php echo $Num_Rows3; ?></td> 
	  <td align="right"><?php echo number_format($percent_3,2);?></td> 
      
    </tr>	
	 <tr>
		
      <td align="center">2</td>
      <td align="right"><?php echo $Num_Rows2; ?></td> 
	  <td align="right"><?php echo number_format($percent_2,2);?></td> 
      
    </tr>
	
	<tr>
		
      <td align="center">1</td>
      <td align="right"><?php echo $Num_Rows1; ?></td> 
	  <td align="right"><?php echo number_format($percent_1,2);?></td> 
      
    </tr>		
  <tr>
		
      <td align="center">ยอดรวม</td>
      <td align="right"><?php echo $Num_Rows5; ?></td> 
	  <td align="right"><?php echo number_format($percent_6,2);?></td> 
      
    </tr>
  
</table>
	
<br><br>
<style>
	
.button1 {border-radius: 2px; background-color:#9966CC;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#9966FF;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#9933FF;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button4 {border-radius: 2px; background-color:#9933CC;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button5 {border-radius: 2px; background-color:#993399;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button6 {border-radius: 2px; background-color:#993366;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button7 {border-radius: 2px; background-color:#9900FF;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button8 {border-radius: 2px; background-color:#9900CC;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button9 {border-radius: 2px; background-color:#990099;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button10 {border-radius: 2px; background-color:#990066;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button11 {border-radius: 2px; background-color:#330066;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}

</style>

<input  class="button10" style="width:40px;height:20px "> : 10 &nbsp;
<input  class="button9" style="width:40px;height:20px"> : 9 &nbsp;
<input  class="button8" style="width:40px;height:20px "> : 8 &nbsp;
<input  class="button7" style="width:40px;height:20px"> : 7 &nbsp;
<input  class="button6" style="width:40px;height:20px "> : 6 &nbsp;
<input  class="button5" style="width:40px;height:20px"> : 5 &nbsp;
<input  class="button4" style="width:40px;height:20px "> : 4 &nbsp;
<input  class="button3" style="width:40px;height:20px"> : 3 &nbsp;
<input  class="button2" style="width:40px;height:20px "> : 2 &nbsp;
<input  class="button1" style="width:40px;height:20px"> : 1 &nbsp;
<input  class="button11" style="width:40px;height:20px"> : เปอร์เซ็นตการประเมิน &nbsp;


<br><br>

<?php
 
$dataPoints = array( 
	array("y" =>  $percent_10,"color" => "#990066", "label" => "10" ),
	array("y" =>  $percent_9,"color" => "#990099", "label" => "9" ),
	array("y" =>  $percent_8,"color" => "#9900CC", "label" => "8" ),
	array("y" =>  $percent_7,"color" => "#9900FF", "label" => "7" ),
	array("y" =>  $percent_6,"color" => "#993366", "label" => "6" ),
	array("y" =>  $percent_5,"color" => "#993399", "label" => "5"),
	array("y" =>  $percent_4,"color" => "#9933CC", "label" => "4" ),
	array("y" =>  $percent_3,"color" => "#9933FF", "label" => "3" ),
	array("y" =>  $percent_2,"color" => "#9966FF", "label" => "2" ),
	array("y" =>  $percent_1,"color" => "#9966CC", "label" => "1"),
	array("y" =>  $percent_16,"color" => "#330066", "label" => "สรุปคะแนน" )
	
	

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
		text: "เปอร์เซ็นต์ความพึงพอใจ"
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
		
		</form>
	
<!--<meta http-equiv="refresh" content="20">-->
<br><br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
