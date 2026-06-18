<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<!--div class="topnav"-->

<div class="w3-white">
<div  class="w3-white w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>รายงานรอส่ง SN Gluco All-Pro</h4></div>


<!--div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value = "<?php  echo $_GET["start_date"]; ?>"></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value = "<?php  echo $_GET["end_date"]; ?>"></div>



<div class="w3-bar w3-quarter">


Sale : 

				<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>


<?php

$strSQL5 = "SELECT * FROM tb_team_all ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET['sale_code'] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>




</div>

<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div></div></p>
<center><input type="submit" class="w3-button w3-teal" value="Search"></center-->
<br><br>
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
			<td width="15%">รายการสินค้า</td >
			<td width="15%">ชื่อผู้ออกบิล</td >
			<td width="10%">เขตการขาย</td >
			<td width="10%">สถานะ</td >
			<td width="2%">ส่งข้อมูล SN</td >
			<td width="2%">ไม่ส่งข้อมูล</td >
			

	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');
		
//$emid = $_SESSION['code'];
		
$strSQL = "SELECT DISTINCT hos__so.ref_id 
    FROM hos__so 
    LEFT JOIN hos__subso ON hos__subso.ref_idd = hos__so.ref_id 
    LEFT JOIN tb_product ON tb_product.product_id = hos__subso.product_id 
    WHERE hos__so.status_doc = 'Approve' 
      AND group1 = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL' 
      AND sol_name LIKE '%GLUCOALL-PRO%' and hos__subso.sn !='' and iv_no NOT LIKE '%IC%' and sm_care='0'";

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objQuery  = mysqli_query($conn,$strSQL);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$sql = "SELECT *  FROM hos__so where ref_id = '".$objResult["ref_id"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

	
?>
		
<tr>
<td><?php echo $objResult["ref_id"];?></td>
<td><?php echo DateThai($rs["date_so"]);	?></td>
<td><?php echo $rs["iv_no"];?></td>
<td>
<?php if ($rs["iv_date"]=="0000-00-00") {
	echo "-"; 
	}else{ echo DateThai($rs["iv_date"]);}
	?> 
</td>
<td><div align="left">
<?php
$strSQL9 = "SELECT * FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' AND group1 = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL' AND sol_name LIKE '%GLUCOALL-PRO%' and sn!=''";
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);
while($objResult9 = mysqli_fetch_array($objQuery9)) { 
echo $objResult9["sol_name"]; 
?><br /><?php } ?>
</div></td>
<td ><div align="left"><?php echo $rs["pre_name"];?><?php echo $rs["bill_name"];?></div></td>
<td ><div align="left"><?php echo $rs["sale_code"];?></div></td>
				
				<?php if($rs["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $rs["status_doc"];?></td>
				<?php }
					else if ($rs["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $rs["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $rs["status_doc"];?></td>
				
				<td></td>
				<?php } ?>
<td>
  <a href="sendsn_smartcare.php?ref_id=<?php echo $objResult['ref_id'];?>"
     onclick="return confirm('ต้องการส่ง SN สินค้าไปยังระบบ allwellSmartcare ใช่หรือไม่?')">
     <img src="img/success.gif" width="28" height="28" border="0" />
  </a>
</td>
<td>
  <a href="nosendsn_smartcare.php?ref_id=<?php echo $objResult['ref_id'];?>"
     onclick="return confirm('ไม่ต้องการส่ง SN สินค้าไปยังระบบ allwellSmartcare ใช่หรือไม่?')">
     <img src="img/false.png" width="17" height="17" border="0" />
  </a>
</td>
				
			</tr>
	<?php		
	$i++;
}			

		
$strSQL = "SELECT DISTINCT hos__br.ref_id_br 
    FROM hos__br 
    LEFT JOIN hos__subbr ON hos__subbr.ref_idd_br = hos__br.ref_id_br 
    LEFT JOIN tb_product ON tb_product.product_id = hos__subbr.product_id 
    WHERE hos__br.status_doc = 'Approve' 
      AND group1 = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL' 
      AND sol_name LIKE '%GLUCOALL-PRO%' and hos__subbr.sn !='' and sm_care='0'";

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_s = mysqli_num_rows($objQuery);
$objQuery  = mysqli_query($conn,$strSQL);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$sql = "SELECT *  FROM hos__br where ref_id_br = '".$objResult["ref_id_br"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

	
?>
		
<tr>
<td><?php echo $objResult["ref_id_br"];?></td>
<td><?php echo DateThai($rs["date_br"]);	?></td>
<td><?php echo $rs["iv_no"];?></td>
<td>
<?php if ($rs["iv_date"]=="0000-00-00") {
	echo "-"; 
	}else{ echo DateThai($rs["iv_date"]);}
	?> 
</td>
<td><div align="left">
<?php
$strSQL9 = "SELECT * FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$objResult["ref_id_br"]."' AND group1 = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL' AND sol_name LIKE '%GLUCOALL-PRO%' and sn!=''";
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);
while($objResult9 = mysqli_fetch_array($objQuery9)) { 
echo $objResult9["sol_name"]; 
?><br /><?php } ?>
</div></td>
<td ><div align="left"><?php echo $rs["customer"];?></div></td>
<td ><div align="left"><?php echo $rs["sale_code"];?></div></td>
				
				<?php if($rs["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $rs["status_doc"];?></td>
				<?php }
					else if ($rs["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $rs["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $rs["status_doc"];?></td>
				
				<td></td>
				<?php } ?>
<td>
  <a href="sendsn_smartcare.php?ref_id=<?php echo $objResult['ref_id_br'];?>"
     onclick="return confirm('ต้องการส่ง SN สินค้าไปยังระบบ allwellSmartcare ใช่หรือไม่?')">
     <img src="img/success.gif" width="28" height="28" border="0" />
  </a>
</td>
<td>
  <a href="nosendsn_smartcare.php?ref_id=<?php echo $objResult['ref_id_br'];?>"
     onclick="return confirm('ไม่ต้องการส่ง SN สินค้าไปยังระบบ allwellSmartcare ใช่หรือไม่?')">
     <img src="img/false.png" width="17" height="17" border="0" />
  </a>
</td>
				
			</tr>
	<?php		
	$i++;
}			

$strSQL = "SELECT DISTINCT hos__smp.ref_idsmp 
    FROM hos__smp 
    LEFT JOIN hos__subsmp ON hos__subsmp.reff_idsmp = hos__smp.ref_idsmp 
    LEFT JOIN tb_product ON tb_product.product_id = hos__subsmp.product_id 
    WHERE hos__smp.status_sup = 'Approve' 
      AND group1 = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL' 
      AND sol_name LIKE '%GLUCOALL-PRO%' and hos__subsmp.sn !='' and sm_care='0'";

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_s = mysqli_num_rows($objQuery);
$objQuery  = mysqli_query($conn,$strSQL);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$sql = "SELECT *  FROM hos__smp where ref_idsmp = '".$objResult["ref_idsmp"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

	
?>
		
<tr>
<td><?php echo $objResult["ref_idsmp"];?></td>
<td><?php echo DateThai($rs["doc_date"]);	?></td>
<td><?php echo $rs["smp_no"];?></td>
<td>
<?php if ($rs["smp_date"]=="0000-00-00") {
	echo "-"; 
	}else{ echo DateThai($rs["smp_date"]);}
	?> 
</td>
<td><div align="left">
<?php
$strSQL9 = "SELECT * FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp  = '".$objResult["ref_idsmp"]."' AND group1 = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL' AND sol_name LIKE '%GLUCOALL-PRO%' and sn!=''";
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);
while($objResult9 = mysqli_fetch_array($objQuery9)) { 
echo $objResult9["sol_name"]; 
?><br /><?php } ?>
</div></td>
<td ><div align="left"><?php echo $rs["customer_name"];?></div></td>
<td ><div align="left"><?php echo $rs["sale_code"];?></div></td>
				
				<?php if($rs["status_sup"]=='Rejected'){	?>
						<td bgcolor="#FF3030"  width="10%"><?php echo $rs["status_sup"];?></td>
				<?php }
					else if ($rs["status_sup"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $rs["status_sup"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $rs["status_sup"];?></td>
				
				<td></td>
				<?php } ?>
<td>
  <a href="sendsn_smartcare.php?ref_id=<?php echo $objResult['ref_idsmp'];?>"
     onclick="return confirm('ต้องการส่ง SN สินค้าไปยังระบบ allwellSmartcare ใช่หรือไม่?')">
     <img src="img/success.gif" width="28" height="28" border="0" />
  </a>
</td>
<td>
  <a href="nosendsn_smartcare.php?ref_id=<?php echo $objResult['ref_idsmp'];?>"
     onclick="return confirm('ไม่ต้องการส่ง SN สินค้าไปยังระบบ allwellSmartcare ใช่หรือไม่?')">
     <img src="img/false.png" width="17" height="17" border="0" />
  </a>
</td>
				
			</tr>
	<?php		
	$i++;
}			

	?>		
			
		
	
		
		
	</table>
	

 <div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows+$Num_Rows_s;?>
      <strong>รายการ</strong>
      <!--span class="style14"> :</span>จำนวน<?=$Num_Pages;?>
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
      <br> <br-->

		
		</div></div></div>
 <div id="cr_bar"> <?php include "foot.php"; ?></div></body>
</html>