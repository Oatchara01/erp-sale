<html>
<head>

<style type="text/css">
	
.button1 {border-radius: 2px; background-color:#FFCC00;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#FF3333;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#000099;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button4 {border-radius: 2px; background-color:#FFFFFF;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}

</style>

<?php
include('head.php');

include "dbconnect.php";
 
$sale_code = $_GET["sale_code"];
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$company = $_GET["company"];
if($company=='3'){
$company_name = 'บริษัท ฟาร์ ทริลเลียน จำกัด';
}else if($company=='4'){

$company_name = 'บริษัท โนเบิล เมด จำกัด';

}

$start_date = $_GET["start_date"];
$date = explode('-' , $start_date );
$start_date1 = $date[1].'-'.$date[0];
$end_date = $_GET["end_date"];
$date1 = explode('-' , $end_date );
$end_date1 = $date1[1].'-'.$date1[0];



$query = "
SELECT SUM(amount) AS totol, DATE_FORMAT(iv_date, '%m-%Y') AS iv_date
FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) 
WHERE iv_date >= '".$start_date."' and iv_date <='".$end_date."' and sale_code = '".$sale_code."' and type_doc = '3'
GROUP BY DATE_FORMAT(iv_date, '%m% %Y%') 
";
$result = mysqli_query($conn, $query);



$query1 = "
SELECT SUM(amount) AS totol, DATE_FORMAT(iv_date, '%m-%Y') AS iv_date
FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) 
WHERE iv_date >= '".$start_date."' and iv_date <='".$end_date."' and sale_code = '".$sale_code."' and type_doc = '4'
GROUP BY DATE_FORMAT(iv_date, '%m% %Y%') 
";
$result1 = mysqli_query($conn, $query1);


$query2 = "
SELECT SUM(amount) AS totol, DATE_FORMAT(iv_date, '%m-%Y') AS iv_date
FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) 
WHERE iv_date >= '".$start_date."' and iv_date <='".$end_date."' and sale_code = '".$sale_code."' 
GROUP BY DATE_FORMAT(iv_date, '%m% %Y%') 
";
$result2 = mysqli_query($conn, $query2);

while ($row2= mysqli_fetch_array($result2)) {

$strSQL1 = "SELECT * FROM  hos_summarysale WHERE sale_code = '".$sale_code."' and date_mount ='".$row2["iv_date"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

if($Num_Rows1 > 0){

$save="UPDATE hos_summarysale SET sum_all = '".$row2["totol"]."' WHERE sale_code = '".$sale_code."' and date_mount ='".$row2["iv_date"]."' ";
$qsave=mysqli_query($conn,$save);

}else{
 
$save="insert into hos_summarysale (date_mount,sale_code,sum_all) values ('".$row2["iv_date"]."','".$sale_code."','".$row2["totol"]."')";
$qsave=mysqli_query($conn,$save);
 
}


}


while ($row= mysqli_fetch_array($result)) {

$save1="UPDATE hos_summarysale SET sum_ptl  = '".$row["totol"]."' WHERE sale_code = '".$sale_code."' and date_mount ='".$row["iv_date"]."' ";
$qsave1=mysqli_query($conn,$save1);


}
while ($row1= mysqli_fetch_array($result1)) {

$save1="UPDATE hos_summarysale SET sum_nbm  = '".$row1["totol"]."' WHERE sale_code = '".$sale_code."' and date_mount ='".$row1["iv_date"]."' ";
$qsave1=mysqli_query($conn,$save1);

}



$sql9 = "SELECT * FROM hos_summarysale where date_mount >= '".$start_date1."' and date_mount <='".$end_date1."' and sale_code = '".$sale_code."' ";
$result9 = mysqli_query($conn,$sql9) or die("Couldn't execute query");
$result19 = mysqli_query($conn,$sql9) or die("Couldn't execute query");

?>
<div class="w3-white w3-container w3-padding-large">
<center>
<h3 align="center">รายงานยอดขายแบบกราฟ เขตการขาย <?php echo $sale_code ?></h3>
<h3 align="center"><?php echo $company_name ?></h3>
<table width="50%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
  <tr>
    <th width="15%">เดือน </th>
    <th width="10%">ยอดขาย ptl</th>
	    <th width="10%">ยอดขาย NBM</th>
    <th width="10%">ยอดขาย All</th>

  </tr>
  </thead>
  
  <?php while($row19 = mysqli_fetch_array($result19)) { ?>
    <tr>
<?php 
$date_arr = explode('-' ,$row19['date_mount']);
$mm = $date_arr[0];
$yy = $date_arr[1];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;
?>

      <td align="center"><?php echo $thai;?> <?php echo $year;?></td>
      <td align="right"><?php echo number_format($row19['sum_ptl'],2);?></td> 
	  <td align="right"><?php echo number_format($row19['sum_nbm'],2);?></td> 
      <td align="right"><?php echo number_format($row19['sum_all'],2);?></td> 

    </tr>
    <?php } ?>
 
</table></p>
	<input  class="button3" style="width:40px;height:20px"> : ยอดขาย AWL &nbsp
	<input  class="button2" style="width:40px;height:20px"> : ยอดขาย NBM &nbsp
<input  class="button1" style="width:40px;height:20px"> : ยอดขายทั้งหมด &nbsp
	
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("visualization", "1.1", {packages:["bar"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
var data = google.visualization.arrayToDataTable([
['เดือน', 'บริษัท ออลเวลล์ ไลฟ์ จำกัด','บริษัท โนเบิล เมด จำกัด','ทั้งหมด'],
<?php
	
while ($row9= mysqli_fetch_array($result9)) {

$sum_ptl =number_format($row9['sum_ptl'],2);
$sum_nbm =number_format($row9['sum_nbm'],2);
$sum_all =number_format($row9['sum_ptl'],2);

?>


['<?=$row9["date_mount"]?>', <?=$row9["sum_ptl"]?>,<?=$row9["sum_nbm"]?>,<?=$row9["sum_all"]?>],
<?php
}
?>
]);
var options = {
legend: { position: 'none' },
width: 800,
height: 500,
chart: {           

subtitle: 'กราฟแท่งแสดงยอดขาย',
}
};

var chart = new google.charts.Bar(document.getElementById('deawxchart'));
chart.draw(data, options);
}
</script>
</center>
</head>
<body>
<div id="deawxchart" style="width: 800px; height: 300px;"></div>
</body>
<br><br><br><br><br><br><br><br><br><input  class="button4" style="width:40px;height:20px">
</div>
<div id="cr_bar"> <?php include "foot.php"; ?> </div>
</html> 


