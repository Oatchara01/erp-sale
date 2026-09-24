<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";
require_once __DIR__ . '/includes/po_repo.php';

// ตัวกรองสถานะ (key ตาม po_status_info()) — Draft แสดงเฉพาะหน้านี้ ไม่ไหลไปหน้า Sale/SO
$poStatusFilters = array(
	'' => 'ทั้งหมด',
	'draft' => 'Draft',
	'waiting_send' => 'รอส่งข้อมูลให้ Sale',
	'waiting_so' => 'รอ Sale เปิดใบสั่งขาย',
	'opened' => 'เปิดใบสั่งขายแล้ว',
	'cancelled' => 'ยกเลิก',
);
$status_filter = isset($_GET['status_filter']) && !is_array($_GET['status_filter']) && isset($poStatusFilters[$_GET['status_filter']]) ? $_GET['status_filter'] : '';
$poHasStatusColumn = po_has_status_column($conn);
?>
<?php if (isset($_GET['submitted']) && !is_array($_GET['submitted']) && $_GET['submitted'] !== '') { ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
	var cleanUrl = new URL(window.location.href);
	cleanUrl.searchParams.delete('submitted');
	window.history.replaceState({}, document.title, cleanUrl);
	Swal.fire({
		title: 'ส่งใบ PO ให้ Sale เรียบร้อยแล้ว',
		text: <?php echo json_encode('เลขที่อ้างอิง: ' . (string)$_GET['submitted'], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG); ?>,
		icon: 'success',
		confirmButtonColor: '#612989',
		confirmButtonText: 'ตกลง'
	});
});
</script>
<?php } ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-grey"><h3 style="display:inline-block;">Status เอกสาร PO</h3> <a href="register_poawl.php" class="w3-button w3-teal w3-right" style="margin-top:12px;">+ สร้างใบ PO</a></div>
	
<div class="w3-bar w3-quarter">

วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>



<div class="w3-bar w3-quarter">


Sale : 

<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php
$strSQL5 = "SELECT * FROM tb_team_adm  ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
</div>

<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo htmlspecialchars($Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '', ENT_QUOTES, 'UTF-8');?>"></div>

<div class="w3-bar w3-quarter">
สถานะ :
<select name="status_filter" id="status_filter" class="w3-input" style="width:90%;">
<?php foreach ($poStatusFilters as $poFilterKey => $poFilterLabel) { ?>
<option value="<?php echo $poFilterKey; ?>" <?php echo $poFilterKey === $status_filter ? 'selected' : ''; ?>><?php echo $poFilterLabel; ?></option>
<?php } ?>
</select></div>
	</div>
	</p>
<center><input type="submit" class="w3-button w3-teal" value="Search"></center>
</p></p>
</form>


<?php
	
		$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
		$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';


	
	
?>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="10%">วันที่ลงทะเบียน</td >
			<td width="8%">เลขที่ PO</td >
			<td width="8%">เลขที่อ้างอิงใบสั่งขาย</td >
			<td width="15%">รหัสสินค้า</td >
			<td width="25%">รายการสินค้า</td >
			<td width="20%">ชื่อลูกค้า</td >
			<td width="8%">เขตการขาย</td >
			<td width="10%">เวลาส่ง Sale</td >
			<td width="10%">สถานะ</td >
			<td width="2%">แก้ไข</td >
			<?php if ($_SESSION['code']=='ACC' or $_SESSION['code']=='ST'){  }else{?>
			<td width="2%">ปิด PO</td >
<?php } ?>
	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$strSQL = "SELECT *  FROM hos__po  where  1";

if($start_date !=""){
    $strSQL .= ' AND date_po >= "'.mysqli_real_escape_string($conn, $start_date).'"';
}

if($end_date !=""){
    $strSQL .= ' AND date_po <= "'.mysqli_real_escape_string($conn, $end_date).'"';
}

if($sale_code !=""){
    $strSQL .= ' AND sale_code = "'.mysqli_real_escape_string($conn, $sale_code).'"';
}

if($Keyword !=""){
	// ครอบวงเล็บ — เดิม OR หลุดออกนอกเงื่อนไขอื่นทั้งหมด (วันที่/Sale/สถานะ) ทำให้ตัวกรองอื่นไม่มีผล
	$safeKeyword = mysqli_real_escape_string($conn, $Keyword);
	$strSQL .= ' AND (bill_name  LIKE "%'.$safeKeyword.'%"';
	$strSQL .= ' or  po_no  LIKE "%'.$safeKeyword.'%"';
	$strSQL .= ' or ref_id  LIKE "%'.$safeKeyword.'%"';
	$strSQL .= ' or ref_so  LIKE "%'.$safeKeyword.'%")';
}

// เงื่อนไขตามลำดับเดียวกับ po_status_info()
$poNotDraft = $poHasStatusColumn ? " AND status_doc <> 'Draft'" : '';
if ($status_filter === 'draft') {
	$strSQL .= $poHasStatusColumn ? " AND status_doc = 'Draft'" : " AND 0";
} else if ($status_filter === 'cancelled') {
	$strSQL .= $poNotDraft . " AND cancel_ckk = '1'";
} else if ($status_filter === 'opened') {
	$strSQL .= $poNotDraft . " AND cancel_ckk <> '1' AND open_so = '1'";
} else if ($status_filter === 'waiting_so') {
	$strSQL .= $poNotDraft . " AND cancel_ckk <> '1' AND open_so <> '1' AND send_sale = '1'";
} else if ($status_filter === 'waiting_send') {
	$strSQL .= $poNotDraft . " AND cancel_ckk <> '1' AND open_so <> '1' AND send_sale <> '1'";
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

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		
		
		
			<tr>
				<td  ><?php echo $objResult["ref_id"];?></td>
				<td ><?php echo DateThai($objResult["date_po"]);?></td>
				<td  ><?php echo $objResult["po_no"];?></td>
				<td  ><?php echo $objResult["ref_so"];?></td>
				
				<td><div align="left">
					<?php
			$strSQL2 = "SELECT express_code FROM (hos__subpo LEFT JOIN tb_product ON hos__subpo.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						
						$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
						$Num_Rows2 = mysqli_num_rows($objQuery2);

						while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
							<?php
 
	echo $objResult2["express_code"]; 

	
	?><br />
						<?php } ?>
				</div></td>
								
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT sol_name FROM (hos__subpo LEFT JOIN tb_product ON hos__subpo.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						//echo $strSQL1;
						//exit();
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php
 
	echo $objResult1["sol_name"]; 

	
	?><br />
						<?php } ?>
				</div></td>
				<td ><div align="left"><?php echo $objResult["bill_name"];?></div></td>
				
				<td ><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				
				<td ><div align="left"><?php echo Datethai($objResult["send_saledate"]);   ?> <?php echo substr($objResult["send_saledate"],10); ?></div></td>
				
					<?php $poStatus = po_status_info($objResult); $poRowIsDraft = ($poStatus['key'] === 'draft'); ?>
					<td  bgcolor="<?php echo $poStatus['color']; ?>" ><?php echo $poStatus['label']; ?></td>



<td  >
<?php if ($poRowIsDraft) { ?>
<a href="register_poawl.php?ref_id=<?php echo urlencode($objResult["ref_id"]);?>" title="แก้ไขร่าง"><img src="img/edit-icon.png" width="23" height="23" border="0" alt="แก้ไขร่าง" /></a>
<?php } else { ?>
<a href="register_poadmin_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
<?php } ?>
</td>
<td  >
	<?php if ($_SESSION['code']=='ACC' or $_SESSION['code']=='ST'){  }else{?>
	<?php if($objResult["open_so"]=='0' && !$poRowIsDraft){ ?>
	<a href="register_poclose.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a></td>
					<?php }
																		  }
				?>
					
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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code&status_filter=$status_filter'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code&status_filter=$status_filter'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code&status_filter=$status_filter'><span class='style40'>Next>></span></a> ";
	}

	
	?>
      </p>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>
</body>
</html>