<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-grey"><h3>Status หมายเหตุแจ้ง Admin (ทั้งหมด)</h3></div>
	
<div class="w3-bar w3-quarter">

วันที่ IV : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
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
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
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
			<td width="8%">วันที่ส่งสินค้า</td >
			<td width="8%">เลขที่ IV</td >
			<td width="8%">วันที่ออก IV</td >
			<td width="15%">รายการสินค้า</td >
			<td width="15%">ชื่อลูกค้า</td >
			<td width="8%">เขตการขาย</td >
			<td width="15%">หมายเหตุ Admin</td >
			<td width="2%">ปิดงาน</td >
			<td width="10%">หมายเหตุการปิดงาน</td >
			
	</thead>
	

<?php	
	
date_default_timezone_set("Asia/Bangkok");

$strSQL = "SELECT * FROM   tb_comment_so WHERE comment_ad != '' ";

/*if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}*/

if($Keyword !=""){ 
	$strSQL .= ' AND ref_id  LIKE "%'.$Keyword.'%"'; 
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
	
$ref_iv = substr($objResult["ref_id"],0,2);	
	
if($ref_iv=='SO'){ 
$strSQL15 = "SELECT iv_no, iv_date, bill_name, sale_code, delivery_date,status_doc FROM hos__so WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn, $strSQL15) or die("Query Error: " . mysqli_error($conn));
$objResult15 = mysqli_fetch_array($objQuery15);
	
$iv_no = $objResult15["iv_no"];	
$iv_date = $objResult15["iv_date"];	
$bill_name = $objResult15["bill_name"];	
$sale_code = $objResult15["sale_code"];	
$delivery_date = $objResult15["delivery_date"];	
$status_doc = $objResult15["status_doc"];	

}else{
$strSQL15 = "SELECT doc_no,doc_release_date,billing_name,employee_name,delivery_date,approve_complete FROM so__main WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no = $objResult15["doc_no"];	
$iv_date = $objResult15["doc_release_date"];	
$bill_name = $objResult15["billing_name"];	
$sale_code = $objResult15["employee_name"];	
$delivery_date = $objResult15["delivery_date"];	
$status_doc = $objResult15["approve_complete"];	


	
}
	
	
?>
			<tr>
				<?php if($objResult["complete_adckk"]=='0'){ ?>
				<td bgcolor="#FF0000" >
				<?php }elseif($objResult["complete_adckk"]=='2'){ 	?>
				<td bgcolor="#00FF00" >	
				<?php }	?>
					<?php echo $objResult["ref_id"];?></td>
				<td><font style="color:#000;"><?php echo DateThai($delivery_date);?></font></td>
				<td><font style="color:#000;"><?php echo $iv_no;?></font></td>
				<td><font style="color:#000;"><?php echo DateThai($iv_date); ?></font></td>
				
<td><div align="left"><font style="color:#000;">
					<?php
	if($ref_iv=='SO'){ 
			$strSQL2 = "SELECT sol_name,count,unit_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
			$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
			$Num_Rows2 = mysqli_num_rows($objQuery2);
			while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
			<?php echo $objResult2["sol_name"]; ?> (<?php echo number_format($objResult2["count"],0).""; ?> <?php echo $objResult2["unit_name"]; ?>)<br>
			<?php } 
					
	}else{
	$strSQL2 = "SELECT sol_name,sale_count,unit_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
			$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
			$Num_Rows2 = mysqli_num_rows($objQuery2);
			while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
			<?php echo $objResult2["sol_name"]; ?> (<?php echo number_format($objResult2["sale_count"],0).""; ?> <?php echo $objResult2["unit_name"]; ?>)<br>
			<?php } 
					
	}				
					?>
				</div></td>
								
				
				<td ><font style="color:#000;"><div align="left"><?php echo $bill_name;?></div></font></td>
				<td ><font style="color:#000;"><div align="left"><?php echo $sale_code;?></div></font></td>
				<td ><div align="left"><?php echo $objResult["comment_ad"];?></div></td>
				<td >
					<?php if($objResult["complete_adckk"]=='2'){ ?>
					<img src="img/success.gif" width="23" height="23" border="0" />
					<?php }else{ ?>
					<!--a href=javascript:if(confirm('!!!ต้องการปิดการดำเนินการAdminใช่หรือไม่')==true){window.location='comment_ad_close.php?ref_id=<?php echo $objResult["ref_id"];?>';}><img src="img/create.png" width="23" height="23" border="0" /></a-->
				<?php } ?>
				</td>	
				<td ><div align="left"><?php echo $objResult["cls_desad"];?></div></td>	

					
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
      </p>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>
</body>
</html>