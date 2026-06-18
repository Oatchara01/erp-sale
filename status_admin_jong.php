<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
	<div class="w3-white">
<div class="w3-container w3-padding-large">
	<div class="w3-panel w3-light-grey"><h3>Status SO (ใบฝาก)</h3></div>	
	
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-container w3-padding-large">
<div class="w3-half">	
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>
<div class="w3-bar w3-quarter">

Sale : 
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>


<?php

$strSQL5 = "SELECT * FROM tb_team_adm where ckk ='0' ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
	
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
</div>
</div><div class="w3-half">	

<div class="w3-bar w3-quarter">
ค้นหาชื่อลูกค้า : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
	
<div class="w3-bar w3-quarter">
ค้นหาเลขที่อ้างอิง : <input name="Keyword1" class="w3-input" style="width:90%;" type="text" id="Keyword1" value="<?php echo $Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';?>"></div>	
	
<div class="w3-bar w3-quarter">
  สินค้า
<input name="product_code" type="text" id="product_code" class="w3-input w3-light-gray" value="<?php echo $_GET["product_code"];?>">
<input name="h_product_code" type="hidden" id="h_product_code" class="w3-input w3-light-gray" value="<?php echo $_GET["h_product_code"];?>">

</div>
	
	</div></div></p>
<center><input type="submit" class="w3-button w3-teal" value="Search"></center>
</p></p>
</form>


<?php
$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';	
$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
$h_product_code = isset($_GET['h_product_code']) ? $_GET['h_product_code'] : '';


	
	
?>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="10%">วันที่ลงทะเบียน</td >
			<td width="8%">เลขที่เอกสาร</td > 
			<td width="7%">เลขที่ใบฝาก</td > 
			<td width="7%">กำหนดส่งตามสัญญา</td > 
			<td width="10%">วันที่ออกเอกสาร</td >
			<td width="15%">รายการสินค้า</td >
			<td width="30%">รายการสินค้า</td >
			<td width="25%">ชื่อผู้ออกบิล</td >
			<td width="15%">เขตการขาย</td >
			<td width="10%">สถานะ</td >
			<td width="2%">แก้ไข</td >
			<td width="2%">Print</td >
			<td width="2%">Copy Doc</td >

	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');




$strSQL = "SELECT DISTINCT ref_id  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd)  where  have_order = '1' and have_product ='0' and status_doc = 'Approve'";

if($start_date !=""){ 
    $strSQL .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_so <= "'.$end_date.'"'; 
}

if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($Keyword !=""){ 
	$strSQL .= ' AND bill_name  LIKE "%'.$Keyword.'%"'; 
	
}	
		
if($Keyword1 !=""){ 
	$strSQL .= ' AND ref_id  LIKE "%'.$Keyword1.'%"'; 
	
}	
		
		
	if($h_product_code !=""){ 
	$strSQL .= ' AND product_code  = "'.$h_product_code.'"'; 
	
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


$strSQL .=" order  by ref_id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$strSQL4 = "SELECT * FROM hos__so WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);
	
?>
		
			<tr>
				<td  ><?php echo $objResult["ref_id"];?></td>
				

				<td ><?php  echo DateThai($objResult4["date_so"]);	?></td>
				<td ><?php echo $objResult4["iv_no"];?></td>
				<td ><?php echo $objResult4["order_no"];?></td>
				<td ><?php echo $objResult4["delivery_contract"];?></td>
				
				<td >
					<?php if ($objResult4["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult4["iv_date"]);
					}
					?> 
				</td>
				
				<td><div align="left">
					<?php
						$strSQL2 = "SELECT express_code FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						//echo $strSQL1;
						//exit();
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
						$strSQL1 = "SELECT * FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
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
				<td ><div align="left"><?php echo $objResult4["bill_name"];?></div></td>
				<td ><div align="left"><?php echo $objResult4["sale_code"];?> <?php echo '-';?> <?php echo $objResult4["sale"];?></div></td>
				
				<?php if($objResult4["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult4["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult4["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult4["status_doc"];?></td>
				<?php } ?>
				<td  >
				<?php if($objResult4["send_admin"] =='1'){	?> 

				<a href="register_adminhos_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
				<?php } ?>
								
				</td>
				<td >


	<?php if($objResult4["send_admin"] =='1'){	

if ($objResult4["type_doc"]=='3'){?>
				<a href="report_salehosptl1.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
				<?php }else if ($objResult4["type_doc"]=='4'){?>
								<a href="report_salehosnbm1.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>

<?php } 
}
?>
				</td>

<td>
<?php if($objResult4["send_admin"] =='1'){	 ?>

	
<a href=javascript:if(confirm('!!!ต้องการเพิ่มเอกสารใหม่โดยCopyเอกสารเดิมใช่หรือไม่')==true){window.location='register_adminhos_createnew.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a>
	
<?php } ?>
</td>				

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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code&h_product_code=$h_product_code&Keyword1=$Keyword1'><font color='black'><< Back</font></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code&h_product_code=$h_product_code&Keyword1=$Keyword1'><font color='black'>$i</font></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&sale_code=$sale_code&h_product_code=$h_product_code&Keyword1=$Keyword1'><font color='black'>Next>></font></a> ";
	}

	
	?>
      </p>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>
</html>

<script type="text/javascript">
function make_autocom(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_reort_pro1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code","h_product_code");
        </script>