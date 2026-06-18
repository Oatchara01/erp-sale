<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
			<div class="w3-panel w3-light-gray"><h4>รายการรับเรื่องจากลูกค้าของช่าง</h4></div>

<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>
<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php	
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$sale_code = $_SESSION["emid"];
	
	
$emid = $_SESSION['code'];
	
if($emid=='SS1'){
$sddd = "  sale_open IN ('S15','S16','S21','S22','S14','SS1')";
}else if($emid=='SS2'){
$sddd = "  sale_open IN ('S11','S12','S17','S24','S13','SS2')";	
}else if($emid=='SS3'){
$sddd = "  sale_open IN ('S31','S32','S33','MM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99','SS3')";	
}else if($emid=='SS5'){
$sddd = "  sale_code IN ('S31','S32','SS5')";	
}else if($emid=='SUP_EN'){
$sddd = " sale_open LIKE '%EN%'";		
}else if($emid=='SUP_MK'){
$sddd = " sale_open IN ('MK','SOL91','SOL92','SOL93','SOL94','SOL99','SUP_MK')";	
}else{
$sddd = "sale_open='".$emid."'";			
}
	
$strSQL = "SELECT *  FROM tb_register_eng  where $sddd";		

if($start_date !=""){ 
    $strSQL .= ' AND date_story >= "'.$start_date.'"'; 
}

if($end_date !=""){ 

    $strSQL .= ' AND date_story <= "'.$end_date.'"'; 
}
if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	
	$strSQL .= ' AND customer_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' OR ref_id  LIKE "%'.$Keyword.'%"'; 

}
//echo $strSQL;

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
			
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="8%">วันที่</th>
			<th width="5%">เลขที่เอกสารของช่าง</th>
			<th width="10%">โรงพยาบาล</th>
             <th width="8%">แผนก</th>
			<th width="10%">ชื่อลูกค้า</th>
			<th width="15%">รายละเอียด</th>
			<th width="5%">โทร</th>
			<th width="5%">เขตการขาย</th>
			<th width="20%">การดำเนินงาน</th>
			<th width="20%">หมายเหตุช่าง</th>
			<th width="8%">สถานะ</th>
			<th width="5%">แก้ไข</th>
			<th width="5%">รายละเอียด</th>
			
			

	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$sql = "SELECT code FROM tb_user where em_id = '".$objResult["employee"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	
$save="Update tb_register_eng set sale_open ='".$rs["code"]."'  where ref_id = '".$objResult["ref_id"]."' ";
$qsave=mysqli_query($conn,$save);
		
?>
	
			<tr>
				
			<td><?php echo $objResult["ref_id"];?></td>	
			<td><?php  echo DateThai($objResult["date_story"]);	?><br><?php echo $objResult["time_story"];?></td>
			
				<td><?php echo $objResult["doc_noeng"];?></td>	
				<td><div align="left"><?php echo $objResult["customer_name"];?></div></td>

				<td><div align="left"><?php echo $objResult["address_name"];?></div></td>

				<td><div align="left"><?php echo $objResult["contact_name"];?></div></td>

				<td><div align="left"><?php echo $objResult["description"];?></div></td>

				<td><div align="left"><?php echo $objResult["tel_number"];?></div></td>

				<td><div align="center"><?php echo $rs["code"];?></div></td>
				
				<td><div align="left"><?php echo $objResult["pending"];?>
										<br>
<font color='green'><?php if($objResult["date_calcus"]!='0000-00-00'){ echo "วันที่ติดต่อลูกค้า : "; echo Datethai($objResult["date_calcus"]);	 echo " "; echo $objResult["time_calcus"]; } ?></font>
					<br>
					<font color='red'><?php if($objResult["pend_date"]!='0000-00-00 00:00:00'){ echo "วันที่ดำเนินการ : "; echo Datethai($objResult["pend_date"]);
					 echo " "; echo substr($objResult["pend_date"],10,10);													   
																		   } ?></font>
					</div></td>
				
				<td><div align="left"><?php echo $objResult["remark_adm"];?></div></td>

<?php if($objResult["summary_adm"]=='1'){ ?>
<td bgcolor="#00FF00" >ช่างดำเนินการเปิดเอกสารเรียบร้อยแล้ว</td>
<?php }else if($objResult["summary_adm"]=='2'){ ?>
<td bgcolor="#FFFF00" >รอดำเนินการ</td>
	<?php }else if($objResult["send_eng"]=='1'){ ?>
<td bgcolor="#FF0000" >ส่งเรื่องให้ช่างแล้ว</td>
<?php }else{ ?>
<td></td>
<?php } ?>
				
<td><a href="register_cuseng_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>
				
<td>
	<?php if($objResult["doc_noeng"] !=''){ ?>	
<?php if($objResult["type_eng"]=='1'){ ?>	
<a href="https://service-engineer.allwellcenter.com/incomplete_show6_print.php?service_order_no=<?php echo $objResult["doc_noeng"];?>"  target="_blank" ><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
	<?php } ?>
	
<?php if($objResult["type_eng"]=='2'){ ?>	
<a href="https://service-engineer.allwellcenter.com/form_checkon.php?ref_id=<?php echo $objResult["doc_noeng"];?>"  target="_blank"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
	<?php }
										  } ?>	
	
				
				</td>		
						
			</tr>
			<?php $i++; } ?>
		
	</table>
</div>
 <div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date'><span class='style40'>Next>></span></a> ";
	}
	
	?>
      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>