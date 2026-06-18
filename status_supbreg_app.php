<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>อนุมัติใบขอเบิกอะไหล่จากสินค้าขาย (BREG)</h4></div>
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
			<td width="20%">รายการสินค้า</td >
			<td width="20%">รายการอะไหล่</td >
			<td width="10%">ชื่อลูกค้า</td >
			<td width="5%">ผู้ออกเอกสาร</td >
			<td width="8%">สถานะ</td >
			<?php if($_SESSION['name']=='บรรเทิง'){ ?>
<td width="8%">เวลาส่งอนุมัติ</td >
<?php } ?>
			<td width="2%">ดูรายละเอียด</td >
			
			</thead>
	

<?php	
	
date_default_timezone_set("Asia/Bangkok");
$to_day = date('Y-m-d');

$strSQL = "SELECT *  FROM hos__breg  where send_sup='1' and status_doc ='Request' and send_dm='0' ";

if($start_date !=""){ 
    $strSQL .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND register_date <= "'.$end_date.'"'; 
}


if($Keyword !=""){ 
	$strSQL .= ' AND customer_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or ref_id  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or add_by  LIKE "%'.$Keyword.'%"'; 

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


$strSQL .=" order  by ref_id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>

<tr>
<td  ><?php echo $objResult["ref_id"];?></td>
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
<?php if($_SESSION['name']=='บรรเทิง'){ ?>
<td>
<?php echo $objResult["send_supname"];?><br>
<?php if($objResult["send_supdate"]!='0000-00-00 00:00:00'){ echo Datethai($objResult["send_supdate"]); ?> <?php   echo   substr($objResult["send_supdate"],-9);   }  ?>				
</td>					
<?php } ?>					
				<td><a href="register_supbreg_app.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a></td>
				
	
			</tr>
			<?php $i++; 
				}

?>
		
	</table>
	

 <div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ</strong>
</div></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>
</html>