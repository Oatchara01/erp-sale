<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>Status BR (ค้างเลขที่เอกสาร)</h4></div>

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
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div></div></p>
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
			<td width="10%">เลขที่เอกสาร</td > 
			<td width="10%">วันที่ออกเอกสาร</td >
			<?php  if($_SESSION['name']=="พรทวี" or $_SESSION['name']=="ศิริพร"  or $_SESSION['name']=="พัชร์ชนัญ"){ ?>
			<td width="8%">วันที่ส่งของ</td >
			<?php } ?>
			<td width="30%">รายการสินค้า</td >
			<?php /*<td width="10%">จำนวน</td >*/ ?>
			<td width="25%">ชื่อผู้ออกบิล</td >
			<td width="5%">เขตการขาย</td >
			<td width="10%">สถานะ</td >
			<td width="15%">เวลา Approve</td >
			<td width="2%">แก้ไข</td >
			<td width="2%">Print ต่อเนื่อง</td >
			<td width="2%">Print</td >
			<td width="2%">Copy Doc</td >
			<td width="2%">สร้างใบรับสินค้า</td >
	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');




$strSQL = "SELECT *  FROM hos__br  where status_doc ='Approve' and iv_date ='0000-00-00'";

if($start_date !=""){ 
    $strSQL .= ' AND date_br >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_br <= "'.$end_date.'"'; 
}

if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}


if($Keyword !=""){ 
	$strSQL .= ' AND customer  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or order_refer_code  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or order_refer_code1  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or ref_id_br  LIKE "%'.$Keyword.'%"'; 

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

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		
			<tr>
				<td  ><?php echo $objResult["ref_id_br"];?></td>
				

				<td ><?php
 echo DateThai($objResult["date_br"]);
					?></td>
				<td ><?php echo $objResult["iv_no"];?></td>
				<td >
					<?php if ($objResult["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["iv_date"]);
					}
					?> 
				</td>
				
				<?php  if($_SESSION['name']=="พรทวี" or $_SESSION['name']=="ศิริพร"  or $_SESSION['name']=="พัชร์ชนัญ" ){ ?>
				
				<?php if($objResult["send_cs"]=='2'){	?>
						<td bgcolor="#00FF00" >
				<?php } else { ?>
						<td >	
							<?php } ?>
				
				
					
					<?php 
							if ($objResult["delivery_date"]=="0000-00-00") {
						echo $objResult["date_send_key"]; 
					}else{														 
						echo DateThai($objResult["delivery_date"]);?></td>
				
				<?php 
							}
					}
				?>
				
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$objResult["ref_id_br"]."' ";
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
				<?php /*<td><div align="left">
					<?php
						$strSQL1 = "SELECT count FROM hos__subbr WHERE ref_idd_br = '".$objResult["ref_id_br"]."' ";
						//echo $strSQL1;
						//exit();
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$Num_Rows1 = mysqli_num_rows($objQuery1);

						while($objResult1 = mysqli_fetch_array($objQuery1)) { ?>
							<?php
 
	echo $objResult1["count"]; 

	
	?><br />
						<?php } ?>
				</div></td>*/ ?>
				<td ><div align="left"><?php echo $objResult["customer"];?></div></td>
				<td ><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				<td ><div align="left"><?php echo Datethai($objResult["approve_date"]); ?>   <?php echo $objResult["approve_time"]; ?></div></td>
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }else if($objResult["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				<td  >
				
<?php if($objResult["close_mount"]=='0'){ ?>
				<a href="register_adminbrhos_edit.php?ref_id_br=<?php echo $objResult["ref_id_br"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
			<?php } ?>	
								
				</td>
				<td >

<?php if($objResult["send_admin"] =='1' ){	?> 
				<a href="report_loanhos.php?ref_id_br=<?php echo $objResult["ref_id_br"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
				<?php } ?>
				</td>
				<td >

<?php if($objResult["send_admin"] =='1' ){	
		if($objResult["company"] =='1' ){				
					?> 
					
				<a href="report_loanhosptl.php?ref_id_br=<?php echo $objResult["ref_id_br"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
					<?php }else{ ?>
				<a href="report_loanhosnbm.php?ref_id_br=<?php echo $objResult["ref_id_br"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>	
				<?php } } ?>
				</td>


<td>
	<?php if($objResult["send_admin"] =='1' ){	?> 
	
	<a href=javascript:if(confirm('!!!ต้องการเพิ่มเอกสารใหม่โดยCopyเอกสารเดิมใช่หรือไม่')==true){window.location='register_adminbrhos_createnew.php?ref_id_br=<?php echo $objResult["ref_id_br"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a>	
	<?php } ?>
</td>				
<td>
<?php if($objResult["send_admin"] =='1'){	 ?>
<a href=javascript:if(confirm('!!!ต้องการสร้างใบรับสินค้าใช่หรือไม่')==true){window.location='register_receivepro_br.php?ref_id=<?php echo $objResult["ref_id_br"];?>';}><img src="img/create.png" width="23" height="23" border="0" /></a>
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