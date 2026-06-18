

<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--
.style15 {	font-size: 18px; color: #000000;}
.style16 {	font-size: 18px; color: #FF0000;}

.style30 {font-size: 16px; color: #000000;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 10.5px; color: #000000; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 15px; color: #000000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#CCFF66;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#FF3333;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}



</style>



<?php
//ini_set('max_execution_time', 3000);
include "error_page.php";

//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment; filename=testing.doc");


include"dbconnect.php";
$start_date=$_GET["start_date"];	
$end_date=$_GET["end_date"];


$date = explode('-' , $_GET["start_date"] );
$newDate = $date[2].'-'.$date[1].'-'.$date[0];
$date1 = explode('-' , $_GET["end_date"] );
$newDate1 = $date1[2].'-'.$date1[1].'-'.$date1[0];
?>
<span class="style15">รายงานสรุปตามสินค้า</span><br>

<span class="style39">ณ วันที่:</span> <span class="style39"><?php echo $newDate; ?></span><span class="style39">ถึง</span> <span class="style39"><?php echo $newDate1; ?></span>

	<?php


	$sql = "SELECT distinct product_code FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1 ";
	


	if($start_date !=""){ 
    $sql .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql .= ' AND register_date <= "'.$end_date.'"'; 
}


$query = mysqli_query($conn,$sql) or die(mysqli_error());



	while($result = mysqli_fetch_array($query)){

$product_code=$result["product_code"];

$sql11 = "SELECT  access_name,unit_name FROM tb_product where product_ID ='".$product_code."' ";
	
$query11 = mysqli_query($conn,$sql11) or die(mysqli_error());
$result11 = mysqli_fetch_array($query11);

	$product_name = $result11["access_name"];
	$unit_name = $result11["unit_name"];

?>

</p>
<span class="style16"><?php echo $product_name; ?></span>	
	
	
<?php

$sql2 = "SELECT distinct sale_channel FROM so__main   where 1 ";
	if($start_date !=""){ 
    $sql2 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql2 .= ' AND register_date <= "'.$end_date.'"'; 
}

$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
while($result2 = mysqli_fetch_array($query2)){

$sale_channel =$result2["sale_channel"];


$sql12 = "SELECT  salechannel_nameshort FROM tb_salechannel   where salechannel_ID = '".$sale_channel."' ";
	
$query12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$result12 = mysqli_fetch_array($query12);

$salechannel_nameshort =$result12["salechannel_nameshort"];



$strSQL1 = "SELECT SUM(sum_amount) AS amount_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."' and product_code='".$product_code."'";
	


	if($start_date !=""){ 
    $strSQL1 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND register_date <= "'.$end_date.'"'; 
}
//echo $strSQL1;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1= mysqli_fetch_array($objQuery1);

$summary_1=$objResult1['amount_1'];
$summary= number_format( $summary_1,2)."";


$strSQL2 = "SELECT SUM(sale_count) AS sale_count  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."' and product_code='".$product_code."'";
	


	if($start_date !=""){ 
    $strSQL2 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND register_date <= "'.$end_date.'"'; 
}

$objQuery2 = mysqli_query($conn,$strSQL2);
$objResult2= mysqli_fetch_array($objQuery2);


$sale_count1=$objResult2['sale_count'];
$sale_count= number_format( $sale_count1,2)."";

 


	
if ($sale_count !='0'){
?>

	<table  width="100%" class='w3-table'>




<tr>

<td width="40%" align="left" class="style39"><?php echo $salechannel_nameshort; ?></td>
<td width="20%" align="right" class="style39"><?php echo $sale_count;?>  &nbsp;&nbsp; <?php echo $unit_name;?></td>
<td width="20%" align="right" class="style39"><?php echo $summary; ?></td>

	</tr>
	</table>


<?php
}

}


$strSQL3 = "SELECT SUM(sum_amount) AS amount_3 FROM ( so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  where  product_code='".$product_code."'";
	


	if($start_date !=""){ 
    $strSQL3 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL3 .= ' AND register_date <= "'.$end_date.'"'; 
}
//echo $strSQL3;
//exit();
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3= mysqli_fetch_array($objQuery3);

$summary_3=$objResult3['amount_3'];
$summary3= number_format( $summary_3,2)."";


$strSQL4 = "SELECT SUM(sale_count) AS sale_count4  FROM  ( so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  where  product_code='".$product_code."'";
	


	if($start_date !=""){ 
    $strSQL4 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL4 .= ' AND register_date <= "'.$end_date.'"'; 
}
//echo $strSQL4;
//exit();
$objQuery4 = mysqli_query($conn,$strSQL4);
$objResult4= mysqli_fetch_array($objQuery4);


$sale_count_4=$objResult4['sale_count4'];
$sale_count4= number_format( $sale_count_4,2)."";

?>

<table  width="100%" class='w3-table'>




<tr>

<td width="40%" align="left" class="style39"><?php echo 'รวมรายการสินค้า'; ?></td>
<td width="20%" align="right" class="style39"><?php echo $sale_count4; ?> &nbsp;&nbsp; <?php echo $unit_name; ?></td>
<td width="20%" align="right" class="style39"><?php echo $summary3; ?>  &nbsp;&nbsp; <?php echo 'บาท'?></td>

	</tr>
	</table>




<?php	


	}
	



$strSQL5 = "SELECT SUM(sale_count) AS sale_count_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1 ";
	


	if($start_date !=""){ 
    $strSQL5 .= ' AND register_date >= "'.$start_date.'"'; 
	}

	if($end_date !=""){ 
    $strSQL5 .= ' AND register_date <= "'.$end_date.'"'; 
	}

//echo $strSQL5;
//exit();

	$objQuery5 = mysqli_query($conn,$strSQL5);
	$objResult5= mysqli_fetch_array($objQuery5);

	$sale_count2=$objResult5['sale_count_1'];
	$sale_count_2= number_format( $sale_count2,2)."";


$strSQL6 = "SELECT SUM(sum_amount) AS amount_6 FROM ( so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  where  1 ";
	


	if($start_date !=""){ 
    $strSQL6 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL6 .= ' AND register_date <= "'.$end_date.'"'; 
}
$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6= mysqli_fetch_array($objQuery6);

$summary_6=$objResult6['amount_6'];
$summary6= number_format( $summary_6,2)."";
?>


<table  width="100%" class='w3-table'>




<tr>

<td width="40%" align="left" class="style39"><?php echo 'รวมทั้งหมด'; ?></td>
<td width="20%" align="right" class="style39"><?php echo $sale_count_2; ?></td>
<td width="20%" align="right" class="style39"><?php echo $summary6; ?> &nbsp;&nbsp; <?php echo 'บาท'?></td>

	</tr>
	</table>









</p>
</body>

</html>
