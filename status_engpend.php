<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large"><!-- main div -->
<div class="w3-panel w3-light-gray"><h4>รายการรับเรื่องจากลูกค้าของช่าง (รอดำเนินการ)</h4></div>
	<div class="w3-half">
<div class="w3-bar w3-quarter w3-third">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter w3-third">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>
<div class="w3-bar w3-quarter w3-third">
โรงพยาบาล : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div></div>
	<div class="w3-half">
<div class="w3-bar w3-quarter w3-third">
ชื่อลูกค้า : <input name="Keyword1" class="w3-input" style="width:90%;" type="text" id="Keyword1" value="<?php echo $Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';?>"></div>
	<div class="w3-bar w3-quarter w3-third">
เลขที่อ้างอิง : <input name="Keyword2" class="w3-input" style="width:90%;" type="text" id="Keyword2" value="<?php echo $Keyword2 = isset($_GET['Keyword2']) ? $_GET['Keyword2'] : '';?>"></div>	
</div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php	
	$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';
	$Keyword2 = isset($_GET['Keyword2']) ? $_GET['Keyword2'] : '';
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$sale_code = $_SESSION["emid"];

$strSQL = "SELECT *  FROM tb_register_eng  where send_eng='1' and summary_adm='2'";

if($start_date !=""){ 
    $strSQL .= ' AND date_story >= "'.$start_date.'"'; 
}

if($end_date !=""){ 

    $strSQL .= ' AND date_story <= "'.$end_date.'"'; 
}
if($Keyword !=""){ 
	$strSQL .= ' AND customer_name  LIKE "%'.$Keyword.'%"'; 
	
}
if($Keyword1 !=""){ 
	$strSQL .= ' AND contact_name  LIKE "%'.$Keyword1.'%"'; 
}	
	
if($Keyword2 !=""){ 
	$strSQL .= ' AND ref_id LIKE "%'.$Keyword2.'%"'; 
}
	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$Per_Page = '20';  
		$Page = isset($_GET['Page']) ? $_GET['Page'] : '';

	if(!isset($_GET['Page']))
	{
		$Page=1;
	}

	$Prev_Page = $Page-1;
	$Next_Page = $Page+1;

	$Page_Start = (($Per_Page*$Page)-$Per_Page);
	if($Num_Rows<=$Per_Page)
	{
		$Num_Pages =1;
	}
	else if(($Num_Rows % $Per_Page)==0)
	{
		$Num_Pages =($Num_Rows/$Per_Page) ;
	}
	else
	{
		$Num_Pages =($Num_Rows/$Per_Page)+1;
		$Num_Pages = (int)$Num_Pages;
	}


$strSQL .=" order  by id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="8%">เลขที่อ้างอิง</th>
			<th width="8%">วันที่</th>
			<th width="5%">เวลา</th> 
			<th width="10%">โรงพยาบาล</th>
             <th width="8%">แผนก</th>
			<th width="10%">ชื่อลูกค้า</th>
			<th width="20%">รายละเอียด</th>
			<th width="8%">โทร</th>
			<th width="8%">เขตการขาย</th>
			<th width="20%">การดำเนินงาน</th>
			<th width="5%">ปิดงาน</th>
			

	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
				
		<td><?php echo $objResult["ref_id"];?></td>		

<td><?php echo DateThai($objResult["date_story"]);	?></td>
				<td><?php echo $objResult["time_story"];?></td>
				
				<td><div align="left"><?php echo $objResult["customer_name"];?></div></td>

				<td><div align="left"><?php echo $objResult["address_name"];?></div></td>

				<td><div align="left"><?php echo $objResult["contact_name"];?></div></td>

				<td><div align="left"><?php echo $objResult["description"];?></div></td>

				<td><div align="left"><?php echo $objResult["tel_number"];?></div></td>

				<td><div align="center"><?php echo $objResult["sale_code"];?></div></td>
				<td><div align="left"><?php echo $objResult["pending"];?> 
					<br>
<font color='green'><?php if($objResult["date_calcus"]!='0000-00-00'){ echo "วันที่ติดต่อลูกค้า : "; echo Datethai($objResult["date_calcus"]);	 echo " "; echo $objResult["time_calcus"]; } ?></font>
					<br>
					<font color='red'><?php if($objResult["pend_date"]!=''){ echo "วันที่ดำเนินการ : "; echo Datethai($objResult["pend_date"]);
					 echo " "; echo substr($objResult["pend_date"],10,10);													   
																		   } ?></font></div></td>
<td>
				<a href="register_engclose.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
				
				</td>
				
			</tr>
			<?php $i++; } ?>
		</tbody>
	</table>

 <div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&Keyword1=$Keyword1&Keyword2=$Keyword2&start_date=$start_date&end_date=$end_date'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&Keyword1=$Keyword1&Keyword2=$Keyword2&start_date=$start_date&end_date=$end_date'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&Keyword1=$Keyword1&Keyword2=$Keyword2&start_date=$start_date&end_date=$end_date'><span class='style40'>Next>></span></a> ";
	}
	
	?>
      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>