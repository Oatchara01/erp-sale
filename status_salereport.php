<?php 
include('head.php'); 
include "dbconnect_sale.php";

?>
<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 14px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 14px; color: #FF0000; }
-->

.button {
    background-color: #FF0099;
    border: none;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}
</style>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white" >
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>Status ขายสมบูรณ์ (Sale Report)</h4></div>


<div class="w3-half">

<div class="w3-container w3-third">

โรงพยาบาล :
<input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_POST['Keyword']) ? $_POST['Keyword'] : '';?>">
</div>
	
<div class="w3-container w3-third">
  เขตการขาย
<select name="sale_code" id="sale_code" style="width:90%;" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_adm where ckk='0' ORDER BY sale_code ASC";
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
<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>

</div>

<div class="w3-container w3-third">
 <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
<br><br>

</form>
<?php	
	$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y');

include "dbconnect.php";

//and date_request LIKE '%$to_day%'
$strSQL = "SELECT *  FROM tb_register_data where  summary_order='0' and   summary_product1!=''  and percent_id <='3'";

if($Keyword !=""){ 
    $strSQL .= ' AND hospital_name  LIKE "%'.$Keyword.'%"'; 
}
if($sale_code !=""){ 
    $strSQL .= ' AND sale_area = "'.$sale_code.'"'; 
}


$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
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

$strSQL .="order  by date_plan ASC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($com,$strSQL);


?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
<tr>

<td width="8%" align="center" bgcolor="#ebe4ed">วันที่</td>
<td width="10%" align="center" bgcolor="#ebe4ed">โรงพยาบาล</td> 
<td width="10%" align="center" bgcolor="#ebe4ed">หน่วยงาน</td>
<td width="10%" align="center" bgcolor="#ebe4ed">รายการ</td>
<td width="5%" align="center" bgcolor="#ebe4ed">จำนวน</td>
<td width="8%" align="center" bgcolor="#ebe4ed">มูลค่า</td>
<td width="10%" align="center" bgcolor="#ebe4ed">ผู้แนะนำ</td>
<td width="5%" align="center" bgcolor="#ebe4ed">เปอร์เซ็น</td>
<td width="10%" align="center" bgcolor="#ebe4ed">วันที่จะได้รับ P/O</td>
<td width="10%" align="center" bgcolor="#ebe4ed">วันที่ส่งของ</td>
<td width="5%" align="center" bgcolor="#ebe4ed">เขตการขาย</td>
<td width="10%" align="center" bgcolor="#ebe4ed">วันที่ออกบิล</td>

</tr>

<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
	
	<td  class="style39"><?php echo Datethai($objResult["date_plan"]); ?></td>
<td  class="style39"><?php echo $objResult["hospital_name"];?></td>


<td  class="style39"><?php echo $objResult["hospital_ward"];?></td>
<td  class="style39"><?php  echo $objResult["summary_quote"]; ?>
	<?php  echo $objResult["summary_product1"]; ?>&nbsp;&nbsp; <?php  echo $objResult["remark_pro1"]; ?>
	</td>
	
	<td  class="style39">
		<?php if ($objResult["unit_product1"]!='0') { echo $objResult["unit_product1"]; }?>&nbsp;<?php echo $objResult["unit_name1"];?>
	</td>

<td  class="style39"><?php $sum_price_product=$objResult["sum_price_product"]; echo number_format( $sum_price_product,0).""; ?></td>

<td  class="style39"><?php  echo $objResult["pre_name"]; ?></td>
	
	<?php if ($objResult["percent_id"]=='1'){ ?>
<td  class="style39" bgcolor="#00FF00"><?php echo $objResult["percent_name"]; ?></td>
	<?php
}else if ($objResult["percent_id"]=='2'){
	?>
	<td  class="style39" bgcolor="#CCFF99"><?php echo $objResult["percent_name"]; ?></td>
	<?php
}else if ($objResult["percent_id"]=='3'){
	?>
	<td  class="style39" bgcolor="#FFFF00"><?php echo $objResult["percent_name"]; ?></td>
<?php
}else if ($objResult["percent_id"]=='4'){
	?>	
<td  class="style39" bgcolor="#FF6600"><?php echo $objResult["percent_name"]; ?></td>
<?php
}else if ($objResult["percent_id"]=='5'){
	?>	
<td  class="style39" bgcolor="#FF0000"><?php echo $objResult["percent_name"]; ?></td>
	<?php }else{ ?>
	<td></td>
	<?php } ?>
	
<td  class="style39"><?php echo Datethai($objResult["month_po"]); ?></td>

<td class="style39" ><?php if($objResult["date_request"]!='0000-00-00'){ echo Datethai($objResult["date_request"]); } ?></td>
<td width="15" class="style39"><?php echo $objResult["sale_area"]; ?></td>
<td  class="style39"><input type='date' name = "date_order[<?php echo $objResult["id_work"];?>]" value="<?php echo $objResult["date_order"]; ?>" id = "date_order[<?php echo $objResult["id_work"];?>]"  class="w3-input"    >
<input type='hidden' name = "id_work[<?php echo $objResult["id_work"];?>]" value="<?php echo $objResult["id_work"]; ?>" id = "id_work[<?php echo $objResult["id_work"];?>]"  class="w3-input"    >				
				
				</td>	
					</tr>
			<?php $i++; }
			?>
		</tbody>
	</table>
	<br>
	<center>
	<input type="button" name ="Submit" value="บันทึก" class = "button button4" align="center" onClick="this.form.action='salereport_save.php'; submit()"><br>
</center>

 <div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&sale_code=$sale_code'><font color='black' ><< Back</font></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&sale_code=$sale_code'><font color='black' >$i</font></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&sale_code=$sale_code'><font color='black' >Next>></font></a> ";
	}
	
	?>
      <br>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>

