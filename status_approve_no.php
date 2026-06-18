<?php include('head.php'); 

include "dbconnect.php";

?>
<body>
<div class="w3-container w3-white">
	<div class="w3-panel w3-light-grey"><h3>ใบแจ้งสินค้าไม่สมบูรณ์</h3>
	<h3>Incomplete Delivery</h3></div>

	<div class="w3-bar">
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-container w3-padding-large">
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>



<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
	</div>
	</p>
<center><input type="submit" class="w3-button w3-teal" value="Search"></center>
</p></p>
</form>


<?php
	
		$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	
	
?>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="10%">วันที่ลงทะเบียน</td >
			<td width="15%">ชื่อผู้ออกบิล</td >
			<td width="15%">สินค้า</td >
			<td width="5%">สถานะเอกสาร</td >
			<td width="2%">แก้ไข</td >
			

	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');
$em_no =  $_SESSION['emid'];



$strSQL = "SELECT *  FROM no__complete  where  status_doc ='Request'  and send_sup ='1' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND date_create >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_create <= "'.$end_date.'"'; 
}

if($Keyword !=""){ 
	$strSQL .= ' AND customer  LIKE "%'.$Keyword.'%"'; 
	
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


$strSQL .=" order  by id_main DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
			<tr>
				<td  ><?php echo $objResult["ref_id"];?></td>
				
				<td ><?php echo DateThai($objResult["date_create"]);		?></td>
				<td ><?php echo $objResult["customer"];?></td>
				<td><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (no__subcomplete LEFT JOIN tb_product ON no__subcomplete.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
///echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
 	echo $objResult1["sol_name"];
 	?><br />
<?php
}
?>
</div>
</td>
				
				<?php if($objResult["status_doc"]=='Approve' ){ ?>
					<td bgcolor="#66FF00"><?php echo "สมบูรณ์";?></td>
				<?php }else if($objResult["status_doc"]=='Request' and $objResult["send_sup"]=='1'){ ?>
				<td bgcolor="#FFFF00"><?php echo "รอปิดงาน";?></td>	
				<?php }else if($objResult["status_doc"]=='' and $objResult["send_doc"]=='1'){ ?>
				<td bgcolor="#FF0000"><?php echo "รอการแก้ไข";?></td>
				<?php }else{ ?>
			<td ><?php echo "";?></td>		
				<?php } ?>
				
				<td><a href="register_noadapprove.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>
					
			</tr>
		
				
			<?php $i++; 
				}

?>
		
	</table>
	

 <div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><span class='style40'>Next>></span></a> ";
	}

	
	?>
      </p>
<?php include('foot.php'); ?>
</div>
</body>
</html>