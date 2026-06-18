<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

	 function DateDiff($strDate1,$strDate2)
{
return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
}
function TimeDiff($strTime1,$strTime2)
{
return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}
function DateTimeDiff($strDateTime1,$strDateTime2)
{
return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>ใบขอเบิกอะไหล่จากสินค้าขาย BREG (ค้างเคลียร์)</h4></div>
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>

<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div></div></p>
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
			<td width="8%">วันที่ลงทะเบียน</td >
			<td width="8%">เลขที่เอกสาร</td > 
			<td width="8%">วันที่ออกเอกสาร</td >
			<td width="5%">รายการสินค้า</td >
			<td width="15%">รายการอะไหล่</td >
			<td width="15%">ชื่อลูกค้า</td >
			<td width="5%">ผู้ออกเอกสาร</td >
			<td width="5%">สถานะ</td >
			<th width="5%">สถานะการดำเนินงาน</th>
			<th width="5%">ประกอบอะไหล่</th>
			<th width="5%">เปิดใบสั่งขาย</th>
			</thead>
	

<?php	
	
date_default_timezone_set("Asia/Bangkok");
$to_day = date('Y-m-d');

$strSQL = "SELECT *  FROM hos__breg  where send_stock='1' and receive_pro !='' and brdoc_eng='0' and ckk_iv='0'";

if($start_date !=""){ 
    $strSQL .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND register_date <= "'.$end_date.'"'; 
}


if($Keyword !=""){ 
	
	$strSQL .= ' AND iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' OR ref_id  LIKE "%'.$Keyword.'%"'; 

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


$strSQL .=" order  by pro_comedate ASC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$add_date = date('Y-m-d');
	 


	
$pro_comedate=$objResult["pro_comedate"];	
$date_late = DateDiff($date_create,$add_date);	
?>

<tr>
<?php if($date_late >='7' and $objResult["pro_come"]=='1'){ ?>	
<td bgcolor="#FF0000" >
	<?php }else if($objResult["pro_come"]=='1'){ ?>
	<td bgcolor="#00FF00" >
	<?php }else{ ?>
	<td>	
		<?php } ?>
	
	<?php echo $objResult["ref_id"];?></td>
<td ><?php echo DateThai($objResult["register_date"]);	?></td>
<td ><?php echo $objResult["iv_no"];?></td>
<td ><?php if ($objResult["iv_date"]=="0000-00-00 00:00:00") { echo "-"; }else{ echo DateThai($objResult["iv_date"]); }	?> </td>
				
<td><div align="left">
					<?php
						$strSQL2 = "SELECT * FROM (hos__subbreg2 LEFT JOIN tb_product ON hos__subbreg2.product_id2=tb_product.product_ID) WHERE ref_id2 = '".$objResult["ref_id"]."' ";
						$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
						while($objResult2 = mysqli_fetch_array($objQuery2)) { 
	echo $objResult2["sol_name"]; ?><br>
						<?php } ?>
				</div></td>
	
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subbreg1 LEFT JOIN tb_product ON hos__subbreg1.product_id1=tb_product.product_ID) WHERE ref_id1 = '".$objResult["ref_id"]."' ";
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						while($objResult1 = mysqli_fetch_array($objQuery1)) { 
	echo $objResult1["sol_name"]; ?><br>
						<?php } ?>
				</div></td>
				
				<td ><div align="left"><?php echo $objResult["customer_name"];?></div></td>
				<td ><div align="left"><?php echo $objResult["add_by"];?></div></td>
				
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }else if($objResult["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
	
	<?php
					if($objResult["stock_print"]==''){	?>
						<td bgcolor="#FF3030"><?php echo 'รอ Print';?></td>
				<?php }
					else if ($objResult["st_name"]==''){ ?>
				<td bgcolor = "#FF9933" ><?php echo 'รอจัดของ';?></td>
				<?php }
					else if ($objResult["st_name"]!='' and $objResult["send_erpst"]!='0' and $objResult["receive_pro"]==''){ ?>
					<td bgcolor="#FF9966"><?php echo 'จัดของแล้ว รอช่างรับสินค้า';?></td>
				<?php }else if ($objResult["receive_pro"]!='' and $objResult["pro_come"]=='0'){ ?>
					<td bgcolor="#FFCC00"><?php echo 'ช่างรับสินค้าแล้ว';?></td>
	            <?php }else if ($objResult["name_eng"]=='' and $objResult["pro_come"]!='0'){ ?>
					<td bgcolor="#FFCC66"><?php echo 'อะไหล่เข้าแล้ว รอช่างประกอบสินค้า';?></td>
	            <?php }else if ($objResult["name_eng"]!='' and $objResult["ckk_complete"]=='0'){ ?>
					<td bgcolor="#FFCC66"><?php echo 'ช่างประกอบสินค้าเรียบร้อยแล้ว';?></td>
			<?php }else if ($objResult["ckk_complete"] !='0'){ ?>	
	        <td bgcolor="#00FF00"><?php echo 'สินค้าสมบูรณ์แล้ว';?></td>
	        <?php } ?>
				<td><a href="register_bregensum_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a></td>
	<td><a href="register_creteso_breg.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a></td>
					
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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><font color='black'><< Back</font></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><font color='black'>$i</font></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><font color='black'>Next>></font></a> ";
	}

	
	?>
      </p>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>
</html>