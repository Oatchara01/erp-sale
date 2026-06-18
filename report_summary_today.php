<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-container w3-padding-large">
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>"></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value="<?php echo $_GET["end_date"];?>"></div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php		  
$keyword=$_GET["Keyword"];		
$start_date=$_GET["start_date"];	
$end_date=$_GET["end_date"];	
$name=$_SESSION[name_show];

include "dbconnect.php";


?>

<?php

$strSQL2 = "SELECT
distinct salechannel_ID,salechannel_nameshort  FROM (so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) WHERE 1 ";

if($start_date !=""){ 
    $strSQL2 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND register_date <= "'.$end_date.'"'; 
}
//echo  $strSQL2;
//exit();

$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());

while($objResult2 = mysqli_fetch_array($objQuery2)){

 //echo $objResult2["salechannel_nameshort"];
 ?>

	 <table border="1" width="90%" class="w3-table">
<thead class="w3-gray">
<td width="5%">รายการ</td>

<td width="5%" ><?php echo $objResult2["salechannel_nameshort"];?></td>




</thead>
</table>

<?php
$sale_channel=$objResult2["salechannel_ID"];

$strSQL5="SELECT distinct product_code,product_name,unit_name FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  sale_channel = '".$sale_channel."'  ";

if($start_date !=""){ 
    $strSQL5 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND register_date <= "'.$end_date.'"'; 
}


//echo $strSQL5;
//exit();

$objQuery5 =mysqli_query($conn,$strSQL5);
while($objResult5=mysqli_fetch_array($objQuery5)){

$product_name=$objResult5["product_name"];
$product_code=$objResult5["product_code"];
$ref_id=$objResult5["ref_id"];
//echo $ref_id;
?>

<?php

$strSQL6="SELECT sum(sale_count )AS sale_count FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  sale_channel = '".$sale_channel."' and product_code = '".$product_code."'  ";

if($start_date !=""){ 
    $strSQL6 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL6 .= ' AND register_date <= "'.$end_date.'"'; 
}


//echo $strSQL5;
//exit();

$objQuery6 =mysqli_query($conn,$strSQL6);
while($objResult6=mysqli_fetch_array($objQuery6)){
$sale_count=$objResult6['sale_count'];
?>
 <table border="1" width="90%" class="w3-table">

<tr>

 <?php
if ($objResult5["product_name"]!=''){
	 ?>
<td width="5%" ><div align="left"><?php echo $objResult5["product_name"];?></div>

<div align="center">&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp<?php echo $sale_count;?></div></td>
<?php
 }
?>
</tr>

</table>

<?php
}
}
}
?>

 <table border="1" width="90%" class="w3-table">
<thead class="w3-gray">
<td width="5%">รายการ</td>

<td width="5%" >ยอดรวม</td>




</thead>
</table>
<?php

$strSQL8="SELECT distinct product_code,product_name,unit_name FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE 1 ";

if($start_date !=""){ 
    $strSQL8 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL8 .= ' AND register_date <= "'.$end_date.'"'; 
}


//echo $strSQL8;
//exit();

$objQuery8 =mysqli_query($conn,$strSQL8);
while($objResult8=mysqli_fetch_array($objQuery8)){

$product_code1=$objResult8["product_code"];
$product_name1=$objResult8["product_name"];


$strSQL7="SELECT sum(sale_count )AS sale_count1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE   product_code = '".$product_code1."'  ";

if($start_date !=""){ 
    $strSQL7 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL7 .= ' AND register_date <= "'.$end_date.'"'; 
}


//echo $strSQL5;
//exit();

$objQuery7 =mysqli_query($conn,$strSQL7);
while($objResult7=mysqli_fetch_array($objQuery7)){
$sale_count1=$objResult7['sale_count1'];

?>

 <table border="1" width="90%" class="w3-table">

<tr>
<?php
if ($objResult8["product_name"]!=''){
	 ?>
<td width="5%"><div align="left"><?php echo $objResult8["product_name"];?></div>

	 <div align="center">&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp<?php echo $sale_count1;?></div></td>
<?php
 }
?>
</tr>
</table>


	
<?php
}
}
?>

<?php include('foot.php'); ?>
</div>
</body>
</html>