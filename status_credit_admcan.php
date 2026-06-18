<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายการใบสั่งลดหนี้ (ยกเลิก)</h4></div>

<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>



<div class="w3-bar w3-quarter">
ค้นหาชื่อลูกค้า : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
	<div class="w3-bar w3-quarter">
ค้นหาเลขที่ SR : <input name="Keyword1" class="w3-input" style="width:90%;" type="text" id="Keyword1" value="<?php echo $Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';?>"></div>
	</div></p>
<center><input type="submit" class="w3-button w3-teal" value="Search"></center>
</p></p>
</form>


<?php
	
		$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';

	
	
?>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="10%">วันที่ลงทะเบียน</td >
			<td width="8%">เลขที่ลดหนี้</td > 
			<td width="15%">รหัสสินค้า</td >
			<td width="25%">รายการสินค้า</td >
			<td width="20%">ชื่อลูกค้า</td >
			<td width="8%">สถานะเอกสาร</td >
			<td width="8%">เขตการขาย</td >
			<td width="2%">ดูรายละเอียด</td >
			<td width="2%">Print</td >
			<td width="2%">Copy Doc</td >

	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');




$strSQL = "SELECT *  FROM tb_credit_note  where   status_doc = 'ยกเลิก'";

if($start_date !=""){ 
    $strSQL .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($Keyword1 !=""){ 
    $strSQL .= ' AND credit_no  LIKE "%'.$Keyword1.'%"'; 
}

if($Keyword !=""){ 
	$strSQL .= ' AND customer_name  LIKE "%'.$Keyword.'%"'; 
	

}
///cho $strSQL;

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


$strSQL .=" order  by credit_id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		
		
		
			<tr>
				<td  ><?php echo $objResult["ref_credit"];?></td>
				

				<td ><?php
 echo DateThai($objResult["date_credit"]);
					?></td>
				<td ><?php echo $objResult["credit_no"];?></td>
				
				<td><div align="left">
					<?php
						$strSQL2 = "SELECT express_code FROM (tb_subcredit LEFT JOIN tb_product ON tb_subcredit.product_ID=tb_product.product_id) WHERE ref_creditt = '".$objResult["ref_credit"]."' ";
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
						$strSQL1 ="SELECT sol_name FROM (tb_subcredit LEFT JOIN tb_product ON tb_subcredit.product_ID=tb_product.product_id) WHERE ref_creditt = '".$objResult["ref_credit"]."'";
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
				<td ><div align="left"><?php echo $objResult["customer_name"];?></div></td>
				
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }else if($objResult["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }else if ($objResult["send_sup"]=='1' or $objResult["send_dm"]=='1'){ ?>
				<td >รอผู้บริหารอนุมัติ</td>
				<?php }else if ($objResult["send_sup"]=='1'){ ?>
				<td >รอผู้หัวหน้าอนุมัติ</td>
				<?php }else if ($objResult["send_sup"]=='0'){ ?>
				<td >รอกดส่งหัวหน้า</td>
				<?php } ?>
				
				<td  ><?php echo $objResult["sale_code"];?></td>
<td>
	<?php if( $objResult["close_mount"]=='0'){ ?>
				<a href="register_credit_adm.php?ref_credit=<?php echo $objResult["ref_credit"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
				<?php } ?>				
				</td>
					<td>

<?php if($objResult["credit_no"]!=''){ ?>

				<a href="report_credit_adm.php?ref_credit=<?php echo $objResult["ref_credit"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>

				<?php } ?>
				
				</td>
<td>
			<a href="register_credit_createnew.php?ref_credit=<?php echo $objResult["ref_credit"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/sticker.png" width="23" height="23" border="0" /></a>
								
				</td>

			</tr>
		
		
		
			<?php 
			}

			$i++;
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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date'><font color='black'><< Back</font></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date'><font color='black'>$i</font></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date'><font color='black'>Next>></font></a> ";
	}

	
	?>
      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		 

</body>
</html>