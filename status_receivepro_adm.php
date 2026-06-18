<?php include('head.php'); ?>
<?php include('dbconnect_sale.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white" >
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายการใบรับสินค้า</h4></div>


<div class="w3-half">

<div class="w3-container w3-third">

วันที่ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>">
</div>
<div class="w3-container w3-third">


  ถึง
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>">

</div>

<div class="w3-container w3-third">


  เขตการขาย


<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" >
<option  value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_adm where ckk!='1' ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
if($rs["sale_code"] == $objResuut5["sale_code"])
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
</div>

<div class="w3-half">

<div class="w3-container w3-third">

  ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>">
</div>
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>

</form>
<?php	
	$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";


$strSQL = "SELECT *  FROM hos__proreceive  where 1";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}
	if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND iv_noref  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or rp_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or customer  LIKE "%'.$Keyword.'%"'; 
	

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


$strSQL .=" order  by id_proreceive  DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่</th>
			<th width="10%">วันที่</th>
			<th width="10%">อ้างอิงเลขที่เอกสาร</th>
			<th width="22%">ชื่อลูกค้า</th>
			<th width="23%">รายการสินค้า</th>
			<th width="7%">เขตการขาย</th>
			<th width="5%">สถานะ</th>
			<th width="5%">แก้ไข</th>
			

	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
					
					<td>
					<?php echo $objResult["rp_no"];?></td>
				

				<td><?php
 echo DateThai($objResult["iv_date"]);
					?></td>
				
				<td><?php
 echo $objResult["iv_noref"];
					?></td>
				<td><div align="left"><?php echo $objResult["customer"];?></div></td>

				<td><div align="left">
					<?php
						$strSQL1 = "SELECT * FROM (hos__subproreceive LEFT JOIN tb_product ON hos__subproreceive.product_ID=tb_product.product_id) WHERE ref_rpno = '".$objResult["rp_no"]."' ";
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
				
				<td><div align="left"><?php echo $objResult["sale_code"];?></div></td>
				<?php
if($objResult["cancel_ckk"]=='1'){
	?>
<td bgcolor="#FF0000"><?php echo "ยกเลิก";?></td>

<?php
}else{	
?>
<td><?php echo "";?></td>
<?php
}
?>
				
				<td>
					
				<a href="register_receivepro_soedit.php?rp_no=<?php echo $objResult["rp_no"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
						
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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&sale_code=$sale_code&start_date=$start_date&end_date=$end_date'><font color='black' ><< Back</font></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&sale_code=$sale_code&start_date=$start_date&end_date=$end_date'><font color='black' >$i</font></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&sale_code=$sale_code&start_date=$start_date&end_date=$end_date'><font color='black' >Next>></font></a> ";
	}
	
	?>
      <br>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>
