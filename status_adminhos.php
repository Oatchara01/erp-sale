<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>

<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>Status SO</h4></div> 
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
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
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
	</div>
	<br>
<center><input type="submit" class="w3-button w3-teal" value="Search"></center>
<br><br>
</form>


<?php
	
		$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
		$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';


	
	
?>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table" style ="margin : 0px -10px;">
		<thead class="w3-gray">
			<td width="5%" style="font-size: 12px;" >เลขที่อ้างอิง</td >
			<td width="8%"  style="font-size: 12px;">วันที่ลงทะเบียน</td >
			<td width="8%"  style="font-size: 12px;">เลขที่เอกสาร</td >
			<td width="8%"  style="font-size: 12px;">เลขที่ใบสั่งซื้อ</td >
			<td width="8%"  style="font-size: 12px;">เลขที่ใบงาน CM</td >
			<td width="8%"  style="font-size: 12px;">เลขที่ใบยืม</td >
			<td width="8%"  style="font-size: 12px;">เลขที่ SR</td >
			<td width="6%"  style="font-size: 12px;">เลขที่ใบฝาก</td >
			<td width="6%"  style="font-size: 12px;">กำหนดส่งตามสัญญา</td >
			<td width="8%"  style="font-size: 12px;">วันที่ออกเอกสาร</td >
			<td width="8%"  style="font-size: 12px;">รหัสสินค้า</td >
			<td width="8%" style="font-size: 12px;" >รายการสินค้า</td >
			<td width="8%" style="font-size: 12px;">ชื่อผู้ออกบิล</td >
			<td width="8%" style="font-size: 12px;">เขตการขาย</td >
			<td width="8%" style="font-size: 12px;">เวลา Approve</td >
			<td width="8%" style="font-size: 12px;">สถานะ</td >
			<td width="2%" style="font-size: 12px;">VIP</td >
			<td width="2%" style="font-size: 12px;">แก้ไข</td >
			
			<?php if  ($_SESSION['name'] !="บรรเทิง"){ ?>
			<td width="2%" style="font-size: 12px;">Print</td >
			<?php if  ($_SESSION['user_type'] =="บัญชี"){ ?>
			<td width="2%" style="font-size: 12px;">ใบกำกับภาษี</td >
			<?php } ?>
			<td width="2%" style="font-size: 12px;">Copy Doc</td >
			<td width="2%" style="font-size: 12px;">สร้างใบลดหนี้</td >
			<td width="2%" style="font-size: 12px;">สร้างใบรับสินค้า</td >
<?php } ?>
	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');


//send_sup ='1' and iv_date !='0000-00-00' and ic_ckk='0'

$strSQL = "SELECT *  FROM hos__so  where  1";

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
	$strSQL .= ' or  brnp_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or  cm_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or ref_id  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or order_refer_code  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or po_no  LIKE "%'.$Keyword.'%"'; 

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

$strSQL27 = "SELECT ref_id  FROM hos__so  where  po_no ='".$objResult["po_no"]."'";
$objQuery27 = mysqli_query($conn,$strSQL27) or die ("Error Query [".$strSQL27."]");
$Num_Rows27 = mysqli_num_rows($objQuery27);	
	
	
	
$sql = "SELECT vip_ckk  FROM tb_customer where customer_id = '".$objResult["bill_id"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);	
	

$iv_no = substr($objResult['iv_no'],0,2);	

?>
		
		<?php if($objResult["have_order"]=='0'){?>
		
			<tr>
				<td  style="font-size: 10px;" ><?php echo $objResult["ref_id"];?></td>
				

				<td  style="font-size: 10px;"><?php
 echo DateThai($objResult["date_so"]);
					?></td>
				
				<?php if($objResult["que_ckk"]=='1'){	?>
						<td  style="font-size: 10px;" bgcolor="#FF0000" >
				<?php } else { ?>
						<td  style="font-size: 10px;">	
							<?php } ?>
				
				<?php echo $objResult["iv_no"];?></td>
				
				<?php if($Num_Rows27 > 1){ ?>
				<td style="font-size: 10px;"  bgcolor="#FFFF00">
				<?php }else{ ?>
				<td style="font-size: 10px;">
					<?php } ?>
				<?php echo $objResult["po_no"];?></td>
				<td  style="font-size: 10px;"><?php echo $objResult["cm_no"];?></td>
				<td width="8%" style="font-size: 10px;"><?php echo $objResult["brnp_no"];?></td>
				<td  style="font-size: 10px;"><?php echo $objResult["sr_no"];?></td>
				<td  style="font-size: 10px;"><div align="left"><?php echo $objResult["order_no"];?></div></td>
				<td  style="font-size: 10px;"><div align="left"><?php if($objResult["delivery_contract"]!='0000-00-00'){ echo DateThai($objResult["delivery_contract"]); } ?></div></td>
				<td  style="font-size: 10px;">
					<?php if ($objResult["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["iv_date"]);
					}
					?> 
				</td>
				
				<td style="font-size: 10px;"><div align="left">
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
				
				
				
				<td style="font-size: 10px;"><div align="left">
					<?php
						$strSQL1 = "SELECT sol_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
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
				<td  style="font-size: 10px;"><div align="left"><?php echo $objResult["bill_name"];?></div></td>
				
				<td  style="font-size: 10px;"><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				<td  style="font-size: 10px;"><div align="left"><?php echo Datethai($objResult["approve_date"]); ?>   <?php echo $objResult["approve_time"]; ?></div></td>
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  style="font-size: 10px;" ><?php echo $objResult["status_doc"];?></td>
				<?php }else if($objResult["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030"   style="font-size: 10px;"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"  style="font-size: 10px;"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td  style="font-size: 10px;"><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				<?php  if($rs["vip_ckk"]=='1'){ ?>
				<td  bgcolor="#00FF00">VIP</td>
				<?php }else{ ?>
				<td></td>
				<?php } ?>
				<td   style="font-size: 10px;">
<a href="register_adminhos_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date;  ?>&end_date=<?php echo $end_date;?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
								
				</td>
				
				<?php if  ($_SESSION['name'] !="บรรเทิง"){ ?>
				
				<?php if($objResult["status_ad_print"] =='1'){	 ?>
				<td bgcolor="#00FF00"  style="font-size: 12px;">
					<?php }else{ ?>
					<td  style="font-size: 10px;">
					<?php } ?>


	<?php if($objResult["send_admin"] =='1'){	

if ($objResult["type_doc"]=='3'){?>
<a href="report_salehosptl1.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
				<?php }else if ($objResult["type_doc"]=='4'){?>
<a href="report_salehosnbm1.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>

<?php } 
}
?>
				</td>
<?php
 if($_SESSION['user_type'] =="บัญชี"){ ?>				
<td>
<?php if($iv_no =='IE'){ ?>	
<a href="report_IEhos.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
				<?php } ?></td>	
<?php } ?>						

<td>
<?php if($objResult["send_admin"] =='1'){	 ?>

	
<a href=javascript:if(confirm('!!!ต้องการเพิ่มเอกสารใหม่โดยCopyเอกสารเดิมใช่หรือไม่')==true){window.location='register_adminhos_createnew.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date;  ?>&end_date=<?php echo $end_date;?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a>
	
<?php } ?>
</td>				
<td>
<?php if($objResult["send_admin"] =='1'){	 ?>

<a href=javascript:if(confirm('!!!ต้องการสร้างใบสั่งลดหนี้ใช่หรือไม่')==true){window.location='register_credinot.php?ref_id=<?php echo $objResult["ref_id"];?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a>
	
<?php } ?>
</td>	
				
<td>
<?php if($objResult["send_admin"] =='1'){	 ?>
<a href=javascript:if(confirm('!!!ต้องการสร้างใบรับสินค้าใช่หรือไม่')==true){window.location='register_receivepro_so.php?ref_id=<?php echo $objResult["ref_id"];?>';}><img src="img/create.png" width="23" height="23" border="0" /></a>
	<?php } ?>
</td>	
				<?php } ?>
			</tr>
		
		
		<?php }else if($objResult["have_order"]=='1' && $objResult["have_product"]=='2'){?>
		
			<tr>
				<td  style="font-size: 10px;" ><?php echo $objResult["ref_id"];?></td>
				

				<td  style="font-size: 10px;"><?php
 echo DateThai($objResult["date_so"]);
					?></td>
				
				<?php if($objResult["que_ckk"]=='1'){	?>
						<td  style="font-size: 10px;" bgcolor="#FF0000" >
				<?php } else { ?>
						<td  style="font-size: 10px;">	
							<?php } ?>
				
				<?php echo $objResult["iv_no"];?></td>
				<td style="font-size: 10px;"><?php echo $objResult["po_no"];?></td>
				<td  style="font-size: 10px;"><?php echo $objResult["cm_no"];?></td>
				<td  style="font-size: 10px;"><?php echo $objResult["brnp_no"];?></td>
				<td  style="font-size: 10px;"><?php echo $objResult["sr_no"];?></td>
				<td  style="font-size: 10px;"><div align="left"><?php echo $objResult["order_no"];?></div></td>
				<td  style="font-size: 10px;"><div align="left"><?php echo $objResult["delivery_contract"];?></div></td>
				<td  style="font-size: 10px;">
					<?php if ($objResult["iv_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["iv_date"]);
					}
					?> 
				</td>
				
				<td style="font-size: 10px;"><div align="left">
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
				
				
				
				<td style="font-size: 10px;"><div align="left">
					<?php
						$strSQL1 = "SELECT sol_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
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
				<td  style="font-size: 10px;"><div align="left"><?php /*echo $objResult["pre_name"];?><?php echo $objResult["bill_name"]; */?></div></td>
				
				<td  style="font-size: 10px;"><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				<td  style="font-size: 10px;"><div align="left"><?php echo Datethai($objResult["approve_date"]); ?>   <?php echo $objResult["approve_time"]; ?></div></td>
				<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  style="font-size: 10px;" ><?php echo $objResult["status_doc"];?></td>
				<?php }else if($objResult["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030"   style="font-size: 10px;"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"  style="font-size: 10px;"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td  style="font-size: 10px;"><?php echo $objResult["status_doc"];?></td>
				<?php } ?>
				<?php  if($rs["vip_ckk"]=='1'){ ?>
				<td  bgcolor="#00FF00">VIP</td>
				<?php }else{ ?>
				<td></td>
				<?php } ?>
				<td   style="font-size: 10px;">
<a href="register_adminhos_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date;  ?>&end_date=<?php echo $end_date;?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
								
				</td>
				
				
				<?php if  ($_SESSION['name'] !="บรรเทิง"){ ?>
				<?php if($objResult["status_ad_print"] =='1'){	 ?>
				<td bgcolor="#00FF00"  style="font-size: 12px;">
					<?php }else{ ?>
					<td  style="font-size: 10px;">
					<?php } ?>

	<?php if($objResult["send_admin"] =='1'){	

if ($objResult["type_doc"]=='3'){?>
				<a href="report_salehosptl1.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
				<?php }else if ($objResult["type_doc"]=='4'){?>
								<a href="report_salehosnbm1.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>

<?php } 
}
?>
				</td>
<?php
 if($_SESSION['user_type'] =="บัญชี"){ ?>				
<td>
<?php if($iv_no =='IE'){ ?>		
<a href="report_IEhos.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
<?php } ?>				</td>	
<?php } ?>				

<td>
<?php if($objResult["send_admin"] =='1'){	 ?>

	
<a href=javascript:if(confirm('!!!ต้องการเพิ่มเอกสารใหม่โดยCopyเอกสารเดิมใช่หรือไม่')==true){window.location='register_adminhos_createnew.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date;  ?>&end_date=<?php echo $end_date;?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a>
	
<?php } ?>
</td>		
	<td>
<?php if($objResult["send_admin"] =='1'){	 ?>

	
<a href=javascript:if(confirm('!!!ต้องการสร้างใบสั่งลดหนี้ใช่หรือไม่')==true){window.location='register_credinot.php?ref_id=<?php echo $objResult["ref_id"];?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a>
	
<?php } ?>
</td>	
<td>
<?php if($objResult["send_admin"] =='1'){	 ?>
<a href=javascript:if(confirm('!!!ต้องการสร้างใบรับสินค้าใช่หรือไม่')==true){window.location='register_receivepro_so.php?ref_id=<?php echo $objResult["ref_id"];?>';}><img src="img/create.png" width="23" height="23" border="0" /></a>
	<?php } ?>
</td>
				
		<?php } ?>
			</tr>
		
		<?php } ?>
			<?php $i++; 
				}

?>
		
	</table>
	

 <div class="w3-panel"  style="font-size: 10px;">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?php
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
      <br>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	
</body>
</html>