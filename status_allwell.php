<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-grey"><h3>Status</h3></div>
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>
	
	
<div class="w3-bar w3-quarter">
	
เขตการขาย
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php
$strSQL5 = "SELECT * FROM tb_team_ss3 where sale_code LIKE '%SOL%'  ORDER BY sale_code ASC";
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
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php	
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
include "dbconnect_cs.php";
$strSQL = "SELECT ref_id,select_type_doc,register_date,doc_no,doc_release_date,delivery_contact,approve_complete,cancel_ckk,order_refer_code,order_refer_code1,employee_name,sale_channel,bill_id,bill_vat,status_vat,add_by,billing_name,job_id  FROM so__main  where allwell_ckk = '1' ";

if($start_date !=""){ 
    $strSQL .= ' AND register_date >= "'.$start_date.'"'; 
}else{
    $strSQL .= ' AND register_date >= "'.$to_day.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND register_date <= "'.$end_date.'"'; 
}else{
    $strSQL .= ' AND register_date <= "'.$to_day.'"'; 

}

if($sale_code !=''){	
	
$strSQL .= ' AND employee_name  = "'.$sale_code.'"'; 	
}
	
if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND delivery_contact  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or customer_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or billing_name  LIKE "%'.$Keyword.'%"'; 
	
	$strSQL .= ' or tel  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or doc_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or ref_id  LIKE "%'.$Keyword.'%"'; 
	 

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


$strSQL .=" order  by main_id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="10%">ประเภทเอกสาร</th>
			<th width="10%">วันที่ลงทะเบียน</th>
			<th width="10%">เลขที่เอกสาร</th> 
			<th width="10%">วันที่ออกเอกสาร</th>
			
			<th width="23%">รายการสินค้า</th>
			<?php /*<th width="23%">ยอดรวม</th>*/ ?>
			<th width="22%">ชื่อลูกค้า</th>
			<th width="10%">เคลียร์ยืม</th>
			<th width="22%">เลขพัสดุ</th>
			<th width="15%">เลขลงงาน CS</th>
			<th width="10%">สถานะ</th>
			<th width="10%">สถานะลูกค้า</th>
			<th width="5%">VIP</th>
			<th width="5%">เขตการขาย</th>
			<th width="5%">แก้ไข</th>
			<th width="2%">ใบกำกับภาษี</th>
			<th width="5%">Copy page</th>
			<td width="2%">สร้างใบลดหนี้</td >
			<td width="2%">แบบสอบถามประเภท D</td >
			
	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$sql = "SELECT status_cus,customer_no,vip_ckk  FROM tb_customer where customer_id = '".$objResult["bill_id"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
	
?>
		<tbody>
			<tr>
				<td><?php echo $objResult["ref_id"];?></td>
				<td><?php if ($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='2'){
	echo 'ใบยืม'; }else { echo 'ใบสั่งขาย';  }?></td>

				<td><?php
 echo DateThai($objResult["register_date"]);
					?></td>
				<td><?php echo $objResult["doc_no"];?></td>
				<td>
					<?php if ($objResult["doc_release_date"]=="0000-00-00" or $objResult["doc_release_date"]=="") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["doc_release_date"]);
					}
					?> 
				</td>
				
				
				<td><div align="left">
					<?php
						$strSQL1 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
						///echo $strSQL;
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
					
						$strSQL1 = "SELECT SUM(sum_amount) AS sum FROM so__submain  WHERE ref_idd = '".$objResult["ref_id"]."' ";
						$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
						$objResult1 = mysqli_fetch_array($objQuery1); 

	echo $objResult1["sum"]; 
				</div></td>*/ ?>
				
				
				<td><div align="left">
					ชื่อออกบิล : <?php echo $objResult["billing_name"];?><br>
					ชื่อผู้รับสินค้า : <?php echo $objResult["delivery_contact"];?></div></td>
				<td><div align="left">
					<?php
						$strSQL21 = "SELECT clear_ivno FROM so__submain  WHERE ref_idd = '".$objResult["ref_id"]."' and clear_ivno!=''";
						$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
						$Num_Rows21 = mysqli_num_rows($objQuery21);

						while($objResult21 = mysqli_fetch_array($objQuery21)) { ?>
							<?php

	echo $objResult21["clear_ivno"]; 

	
	?><br>
						<?php } ?>
				</div></td>
				<td><div align="left"><?php echo $objResult["order_refer_code"];?></p><?php echo $objResult["order_refer_code1"];?></div></td>
				<td><div align="left"><?php echo $objResult["job_id"];?></div></td>
				<?php
					if($objResult["approve_complete"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["approve_complete"];?></td>
				<?php }else if($objResult["cancel_ckk"]=='1'){	?>
						<td bgcolor="#FF3030"><?php echo 'ยกเลิก';?></td>
				<?php }
					else if ($objResult["approve_complete"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["approve_complete"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["approve_complete"];?></td>
				<?php } ?>
	
						<?php
 if($rs["customer_no"] !=''){
 if($rs["status_cus"]=='0'){ ?>
				<td bgcolor="#FFFF00" style="font-size: 12px;">รหัสสมาชิก : <?php echo $rs["customer_no"]; ?>
					<br>Gold Customer</td>
				<?php }else if($rs["status_cus"]=='1'){ ?>
				<td  bgcolor="#CCFF99" style="font-size: 12px;">รหัสสมาชิก : <?php echo $rs["customer_no"]; ?>
					<br>Platinum Customer</td>
				<?php }else if($rs["status_cus"]=='2'){ ?>
				<td  bgcolor="#00FF00" style="font-size: 12px;">รหัสสมาชิก : <?php echo $rs["customer_no"]; ?>
					<br>Daimond Customer</td>
				<?php
}									 
}else{ ?>
				<td></td>
				<?php } ?>
	
<?php  if($rs["vip_ckk"]=='1'){ ?>
				<td  bgcolor="#00FF00">VIP</td>
				<?php }else{ ?>
				<td></td>
				<?php } ?>
	<td><div align="left"><?php echo $objResult["employee_name"];?>-<?php echo $objResult["add_by"];?></div></td>
				<td>
				<?php if ($objResult["select_type_doc"]=='3' or $objResult["select_type_doc"]=='4' ){ ?>
				<a href="register_allwell_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
				<?php }else if ($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='2'){ ?>

				<a href="register_allwell_bredit.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>

						<?php } ?>
				
				</td>
					<td>	
		<?php  if($objResult["bill_vat"]=='1' and $objResult["status_vat"]=='Approve'  and $objResult["doc_no"] !='') {
		if($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='3') {
		 ?>
<a href="report_vat.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
		
		<?php }else if($objResult["select_type_doc"]=='2' or $objResult["select_type_doc"]=='4') {
		 ?> 
		
		<a href="report_vatnbm1.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>"><img src="img/print_icon-2.png" width="23" height="23" border="0" /></a>
				<?php 
		}
		} ?>
</td>
				<td>
				<?php if ($objResult["select_type_doc"]=='3' or $objResult["select_type_doc"]=='4' ){ ?>
				<a href="register_allwell_createnew.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a>
				<?php }else if ($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='2'){ ?>

				<a href="register_allwell_brcreatenew.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a>

						<?php } ?>
				
				</td>
				
					<td>	
<a href=javascript:if(confirm('!!!ต้องการสร้างใบสั่งลดหนี้ใช่หรือไม่')==true){window.location='register_credit_saleallwell.php?ref_id=<?php echo $objResult["ref_id"];?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a>
</td>
					<td>	
						<?php if($objResult["sale_channel"]=='3' ){ 
						 if($objResult["select_type_doc"]=='3' or $objResult["select_type_doc"]=='4'){
						
							 
$strSQL21 = "SELECT red_id FROM tb_research WHERE red_id = '".$objResult["ref_id"]."' ";
$objQuery21 = mysqli_query($com1,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

if($Num_Rows21 > 0){ ?>
						
<a href="register_commentd_r.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/receipt_product.png" width="23" height="23" border="0" /></a>	 
							 
					<?php }else{	?>
<a href=javascript:if(confirm('!!!ต้องการทำแบบสอบถามสินค้าประเภทDใช่หรือไม่')==true){window.location='register_commentd.php?ref_id=<?php echo $objResult["ref_id"];?>';}><img src="img/receipt_product.png" width="23" height="23" border="0" /></a>
						<?php 
}
						 }
						 } ?>
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
      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>