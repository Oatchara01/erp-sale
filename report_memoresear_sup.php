<?php
include "head.php";
include "dbconnect.php";
include "dbconnect_sale.php";
 
function DateThai1($strDate)
	{
		$strYear = date("y",strtotime($strDate))+43;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strMonthThai $strYear";
	}
?>		

<style type="text/css">

.button1 {border-radius: 2px; background-color:#00FF00;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#FFFF00;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#FF3333;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button4 {border-radius: 2px; background-color:#CCFF99;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button8 {border-radius: 2px; background-color:#FF6600;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button5  {border-radius: 12px;}

</style>



 <div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>เปอร์เซ็นต์การทำแบบสอบถามสินค้าสาธิต</h4></div>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">

<?php

$to_yaer = date('Y');

$date_sum1  = "$to_yaer-01";
$date_sum2  = "$to_yaer-02";
$date_sum3  = "$to_yaer-03";
$date_sum4  = "$to_yaer-04";
$date_sum5  = "$to_yaer-05";
$date_sum6  = "$to_yaer-06";
$date_sum7  = "$to_yaer-07";
$date_sum8  = "$to_yaer-08";
$date_sum9  = "$to_yaer-09";
$date_sum10 = "$to_yaer-10";
$date_sum11 = "$to_yaer-11";
$date_sum12 = "$to_yaer-12";


?>
<br>

<div class="w3-bar w3-quarter">


Sale : 
<?php 
	if ($_SESSION['code']=='SS1'){
	?>
<select name="sale_code" id="sale_code" style="width:90%" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
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
<?php
}else 	if ($_SESSION['code']=='SS2'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
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
	
	
<?php
}else 	if ($_SESSION['code']=='SS3'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss3 where ckk_1='0' ORDER BY sale_code ASC";
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

	
	
<?php
}else 	if ($_SESSION['code']=='MK2'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_sm1 ORDER BY sale_code ASC";

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


		<?php
}else 	if ($_SESSION['code']=='SUP_EN'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
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


		<?php
}else 	{
			?>
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


				<?php
}
			
?>


</div>

<div class="w3-bar w3-quarter"><input type="submit" class="w3-button w3-teal" value="Search"></div>
<div class="w3-container">
<br>
<input  class="button1" style="width:20px;height:20px"> : 90% ขึ้นไป (A+) &nbsp&nbsp&nbsp&nbsp
<input  class="button4" style="width:20px;height:20px"> : 80% ขึ้นไป (A) &nbsp&nbsp&nbsp&nbsp
<input  class="button2" style="width:20px;height:20px"> : 70% ขึ้นไป (B) &nbsp&nbsp&nbsp&nbsp
<input  class="button8" style="width:20px;height:20px"> : 60% ขึ้นไป (C) &nbsp&nbsp&nbsp&nbsp
<input  class="button3" style="width:20px;height:20px"> : 59% ลงมา (D)
	
</div>	

<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="10%" >เดือน</th>
<th width="8%" >จำนวนครั้งสาธิต</th>
<th width="8%" >จำนวนที่ทำแบบสอบถาม</th>
<th width="8%" >ผลการประเมิน</th> 
</thead>

<?php
$today = date('Y-m');



$emid = $_SESSION['code'];
	
if($emid=='SS1'){
$sddd = " and sale_code !='S11'  and sale_code !='S12' and sale_code !='S13'  and sale_code !='S17'  and sale_code !='S23'  and sale_code !='S24'  and sale_code !='S31' and sale_code !='SM1' and sale_code !='MM1' and sale_code !='MM2' and sale_code !='S32'  and sale_code NOT LIKE '%EN%' and sale_code !=''";
	
}else if($emid=='SS2'){
$sddd = " and sale_code !='S14'  and sale_code !='S15' and sale_code !='S16'  and sale_code !='S21'  and sale_code !='S22' and sale_code !='S31' and sale_code !='SM1' and sale_code !='MM1'  and sale_code !='MM2' and sale_code !='S32' and sale_code NOT LIKE '%EN%' and sale_code !=''";	
}else if($emid=='SS3'){
$sddd = " and sale_code !='S11'  and sale_code !='S12' and sale_code !='S13'  and sale_code !='S17'  and sale_code !='S23'  and sale_code !='S24' and sale_code !='S14'  and sale_code !='S15' and sale_code !='S16'  and sale_code !='S21' and sale_code !='S22' and sale_code NOT LIKE '%EN%' and sale_code !=''";	
}else if($emid=='SUP_EN'){
$sddd = " and  sale_code LIKE '%EN%'";		
}else{
$sddd = "";			
}
	
$sale_code =  $_GET['sale_code'];

	
if($date_sum1 <= $today){	
	
$strSQL1 = "SELECT iv_no FROM hos__br  where iv_date LIKE '%".$date_sum1."%'  and research_demo !='0' $sddd";
if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
$strSQLc1 = "SELECT DISTINCT ref_id FROM tb_research_demo  where iv_date LIKE '%".$date_sum1."%' $sddd";
if($sale_code !=""){ 
    $strSQLc1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQueryc1 = mysqli_query($conn,$strSQLc1) or die ("Error Query [".$strSQLc1."]");
$Num_Rowsc1 = mysqli_num_rows($objQueryc1);
?>

<tr>
<td><?php echo DateThai1($date_sum1);?></td>
<td><?php echo $Num_Rows1; ?></td>
<td><?php echo $Num_Rowsc1; ?></td>
<?php
if($Num_Rowsc1!='0' and $Num_Rows1!='0'){	
$dd = (($Num_Rowsc1/$Num_Rows1)*100);	
}else{
$dd = '0';	
}

if($Num_Rowsc1=='0' and $Num_Rows1=='0'){
?>	
<td></td>
<?php	
}else if($dd >= '90'){
	?>
<td bgcolor="#00FF00">A+</td>
<?php }else if ($dd >= '80'){ ?>
	<td bgcolor="#CCFF99">A</td>
	<?php }else if($dd >= '70'){ ?>
	<td bgcolor="#FFFF00">B</td>
	<?php }else if($dd >= '60'){ ?>
	<td bgcolor="#FF6600">C</td>
	<?php }else if($dd <= '59'){ ?>
	<td bgcolor="#FF0000">D</td>
	<?php } ?>	
	
	
	
	</tr>
	
<?php
}	
if($date_sum2 <= $today){	

$strSQL1 = "SELECT iv_no FROM hos__br  where iv_date LIKE '%".$date_sum2."%'  and research_demo !='0' $sddd";
if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
$strSQLc1 = "SELECT DISTINCT ref_id FROM tb_research_demo  where iv_date LIKE '%".$date_sum2."%'  $sddd";
if($sale_code !=""){ 
    $strSQLc1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQueryc1 = mysqli_query($conn,$strSQLc1) or die ("Error Query [".$strSQLc1."]");
$Num_Rowsc1 = mysqli_num_rows($objQueryc1);
?>

<tr>
<td><?php echo DateThai1($date_sum2);?></td>
<td><?php echo $Num_Rows1; ?></td>
<td><?php echo $Num_Rowsc1; ?></td>
	
<?php
if($Num_Rowsc1!='0' and $Num_Rows1!='0'){	
$dd = (($Num_Rowsc1/$Num_Rows1)*100);	
}else{
$dd = '0';	
}

if($Num_Rowsc1=='0' and $Num_Rows1=='0'){
?>	
<td></td>
<?php	
}else if($dd >= '90'){
	?>
	<td bgcolor="#00FF00">A+</td>
<?php }else if ($dd >= '80'){ ?>
	<td bgcolor="#CCFF99">A</td>
	<?php }else if($dd >= '70'){ ?>
	<td bgcolor="#FFFF00">B</td>
	<?php }else if($dd >= '60'){ ?>
	<td bgcolor="#FF6600">C</td>
	<?php }else if($dd <= '59'){ ?>
	<td bgcolor="#FF0000">D</td>
	<?php } ?>	
	
	
	
	</tr>

<?php
}	
if($date_sum3 <= $today){	
	
$strSQL1 = "SELECT iv_no FROM hos__br  where iv_date LIKE '%".$date_sum3."%'  and research_demo !='0' $sddd";
if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
$strSQLc1 = "SELECT DISTINCT ref_id FROM tb_research_demo  where iv_date LIKE '%".$date_sum3."%'  $sddd";
if($sale_code !=""){ 
    $strSQLc1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQueryc1 = mysqli_query($conn,$strSQLc1) or die ("Error Query [".$strSQLc1."]");
$Num_Rowsc1 = mysqli_num_rows($objQueryc1);
?>

<tr>
<td><?php echo DateThai1($date_sum3);?></td>
<td><?php echo $Num_Rows1; ?></td>
<td><?php echo $Num_Rowsc1; ?></td>
<?php
if($Num_Rowsc1!='0' and $Num_Rows1!='0'){	
$dd = (($Num_Rowsc1/$Num_Rows1)*100);	
}else{
$dd = '0';	
}

if($Num_Rowsc1=='0' and $Num_Rows1=='0'){
?>	
<td></td>
<?php	
}else if($dd >= '90'){
	?>
	<td bgcolor="#00FF00">A+</td>
<?php }else if ($dd >= '80'){ ?>
	<td bgcolor="#CCFF99">A</td>
	<?php }else if($dd >= '70'){ ?>
	<td bgcolor="#FFFF00">B</td>
	<?php }else if($dd >= '60'){ ?>
	<td bgcolor="#FF6600">C</td>
	<?php }else if($dd <= '59'){ ?>
	<td bgcolor="#FF0000">D</td>
	<?php } ?>	</tr>
	
	
<?php
}	
if($date_sum4 <= $today){	
	
$strSQL1 = "SELECT iv_no FROM hos__br  where iv_date LIKE '%".$date_sum4."%'  and research_demo !='0' $sddd";
if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
$strSQLc1 = "SELECT DISTINCT ref_id FROM tb_research_demo  where iv_date LIKE '%".$date_sum4."%'  $sddd";
if($sale_code !=""){ 
    $strSQLc1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQueryc1 = mysqli_query($conn,$strSQLc1) or die ("Error Query [".$strSQLc1."]");
$Num_Rowsc1 = mysqli_num_rows($objQueryc1);
?>

<tr>
<td><?php echo DateThai1($date_sum4);?></td>
<td><?php echo $Num_Rows1; ?></td>
<td><?php echo $Num_Rowsc1; ?></td>
<?php
if($Num_Rowsc1!='0' and $Num_Rows1!='0'){	
$dd = (($Num_Rowsc1/$Num_Rows1)*100);	
}else{
$dd = '0';	
}

if($Num_Rowsc1=='0' and $Num_Rows1=='0'){
?>	
<td></td>
<?php	
}else if($dd >= '90'){
	?>
	<td bgcolor="#00FF00">A+</td>
<?php }else if ($dd >= '80'){ ?>
	<td bgcolor="#CCFF99">A</td>
	<?php }else if($dd >= '70'){ ?>
	<td bgcolor="#FFFF00">B</td>
	<?php }else if($dd >= '60'){ ?>
	<td bgcolor="#FF6600">C</td>
	<?php }else if($dd <= '59'){ ?>
	<td bgcolor="#FF0000">D</td>
	<?php } ?>	</tr>
		
	
<?php
}	
if($date_sum5 <= $today){	
	
$strSQL1 = "SELECT iv_no FROM hos__br  where iv_date LIKE '%".$date_sum5."%'  and research_demo !='0' $sddd";
if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
$strSQLc1 = "SELECT DISTINCT ref_id FROM tb_research_demo  where iv_date LIKE '%".$date_sum5."%'  $sddd";
if($sale_code !=""){ 
    $strSQLc1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQueryc1 = mysqli_query($conn,$strSQLc1) or die ("Error Query [".$strSQLc1."]");
$Num_Rowsc1 = mysqli_num_rows($objQueryc1);
?>

<tr>
<td><?php echo DateThai1($date_sum5);?></td>
<td><?php echo $Num_Rows1; ?></td>
<td><?php echo $Num_Rowsc1; ?></td>
<?php
if($Num_Rowsc1!='0' and $Num_Rows1!='0'){	
$dd = (($Num_Rowsc1/$Num_Rows1)*100);	
}else{
$dd = '0';	
}

if($Num_Rowsc1=='0' and $Num_Rows1=='0'){
?>	
<td></td>
<?php	
}else if($dd >= '90'){
	?>
	<td bgcolor="#00FF00">A+</td>
<?php }else if ($dd >= '80'){ ?>
	<td bgcolor="#CCFF99">A</td>
	<?php }else if($dd >= '70'){ ?>
	<td bgcolor="#FFFF00">B</td>
	<?php }else if($dd >= '60'){ ?>
	<td bgcolor="#FF6600">C</td>
	<?php }else if($dd <= '59'){ ?>
	<td bgcolor="#FF0000">D</td>
	<?php } ?>	</tr>
	
	
<?php
}	
if($date_sum6 <= $today){	
	
$strSQL1 = "SELECT iv_no FROM hos__br  where iv_date LIKE '%".$date_sum6."%'  and research_demo !='0' $sddd";
if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
$strSQLc1 = "SELECT DISTINCT ref_id FROM tb_research_demo  where iv_date LIKE '%".$date_sum6."%'  $sddd";
if($sale_code !=""){ 
    $strSQLc1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQueryc1 = mysqli_query($conn,$strSQLc1) or die ("Error Query [".$strSQLc1."]");
$Num_Rowsc1 = mysqli_num_rows($objQueryc1);
?>

<tr>
<td><?php echo DateThai1($date_sum6);?></td>
<td><?php echo $Num_Rows1; ?></td>
<td><?php echo $Num_Rowsc1; ?></td>
<?php
if($Num_Rowsc1!='0' and $Num_Rows1!='0'){	
$dd = (($Num_Rowsc1/$Num_Rows1)*100);	
}else{
$dd = '0';	
}

if($Num_Rowsc1=='0' and $Num_Rows1=='0'){
?>	
<td></td>
<?php	
}else if($dd >= '90'){
	?>
	<td bgcolor="#00FF00">A+</td>
<?php }else if ($dd >= '80'){ ?>
	<td bgcolor="#CCFF99">A</td>
	<?php }else if($dd >= '70'){ ?>
	<td bgcolor="#FFFF00">B</td>
	<?php }else if($dd >= '60'){ ?>
	<td bgcolor="#FF6600">C</td>
	<?php }else if($dd <= '59'){ ?>
	<td bgcolor="#FF0000">D</td>
	<?php } ?>	</tr>

<?php
}	
if($date_sum7 <= $today){	
	
$strSQL1 = "SELECT iv_no FROM hos__br  where iv_date LIKE '%".$date_sum7."%'  and research_demo !='0' $sddd";
if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
$strSQLc1 = "SELECT DISTINCT ref_id FROM tb_research_demo  where iv_date LIKE '%".$date_sum7."%'  $sddd";
if($sale_code !=""){ 
    $strSQLc1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQueryc1 = mysqli_query($conn,$strSQLc1) or die ("Error Query [".$strSQLc1."]");
$Num_Rowsc1 = mysqli_num_rows($objQueryc1);
?>

<tr>
<td><?php echo DateThai1($date_sum7);?></td>
<td><?php echo $Num_Rows1; ?></td>
<td><?php echo $Num_Rowsc1; ?></td>
<?php
if($Num_Rowsc1!='0' and $Num_Rows1!='0'){	
$dd = (($Num_Rowsc1/$Num_Rows1)*100);	
}else{
$dd = '0';	
}

if($Num_Rowsc1=='0' and $Num_Rows1=='0'){
?>	
<td></td>
<?php	
}else if($dd >= '90'){
	?>
	<td bgcolor="#00FF00">A+</td>
<?php }else if ($dd >= '80'){ ?>
	<td bgcolor="#CCFF99">A</td>
	<?php }else if($dd >= '70'){ ?>
	<td bgcolor="#FFFF00">B</td>
	<?php }else if($dd >= '60'){ ?>
	<td bgcolor="#FF6600">C</td>
	<?php }else if($dd <= '59'){ ?>
	<td bgcolor="#FF0000">D</td>
	<?php } ?>	</tr>
		
		
<?php
}	
if($date_sum8 <= $today){	
	
$strSQL1 = "SELECT iv_no FROM hos__br  where iv_date LIKE '%".$date_sum8."%'  and research_demo !='0' $sddd";
if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
$strSQLc1 = "SELECT DISTINCT ref_id FROM tb_research_demo  where iv_date LIKE '%".$date_sum8."%'  $sddd";
if($sale_code !=""){ 
    $strSQLc1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQueryc1 = mysqli_query($conn,$strSQLc1) or die ("Error Query [".$strSQLc1."]");
$Num_Rowsc1 = mysqli_num_rows($objQueryc1);
?>

<tr>
<td><?php echo DateThai1($date_sum8);?></td>
<td><?php echo $Num_Rows1; ?></td>
<td><?php echo $Num_Rowsc1; ?></td>
<?php
if($Num_Rowsc1!='0' and $Num_Rows1!='0'){	
$dd = (($Num_Rowsc1/$Num_Rows1)*100);	
}else{
$dd = '0';	
}

if($Num_Rowsc1=='0' and $Num_Rows1=='0'){
?>	
<td></td>
<?php	
}else if($dd >= '90'){
	?>
	<td bgcolor="#00FF00">A+</td>
<?php }else if ($dd >= '80'){ ?>
	<td bgcolor="#CCFF99">A</td>
	<?php }else if($dd >= '70'){ ?>
	<td bgcolor="#FFFF00">B</td>
	<?php }else if($dd >= '60'){ ?>
	<td bgcolor="#FF6600">C</td>
	<?php }else if($dd <= '59'){ ?>
	<td bgcolor="#FF0000">D</td>
	<?php } ?>	</tr>
		
		
<?php
}	
if($date_sum9 <= $today){	
	
$strSQL1 = "SELECT iv_no FROM hos__br  where iv_date LIKE '%".$date_sum9."%'  and research_demo !='0' $sddd";
if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
$strSQLc1 = "SELECT DISTINCT ref_id FROM tb_research_demo  where iv_date LIKE '%".$date_sum9."%'  $sddd";
if($sale_code !=""){ 
    $strSQLc1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQueryc1 = mysqli_query($conn,$strSQLc1) or die ("Error Query [".$strSQLc1."]");
$Num_Rowsc1 = mysqli_num_rows($objQueryc1);
?>

<tr>
<td><?php echo DateThai1($date_sum9);?></td>
<td><?php echo $Num_Rows1; ?></td>
<td><?php echo $Num_Rowsc1; ?></td>
<?php
if($Num_Rowsc1!='0' and $Num_Rows1!='0'){	
$dd = (($Num_Rowsc1/$Num_Rows1)*100);	
}else{
$dd = '0';	
}

if($Num_Rowsc1=='0' and $Num_Rows1=='0'){
?>	
<td></td>
<?php	
}else if($dd >= '90'){
	?>
	<td bgcolor="#00FF00">A+</td>
<?php }else if ($dd >= '80'){ ?>
	<td bgcolor="#CCFF99">A</td>
	<?php }else if($dd >= '70'){ ?>
	<td bgcolor="#FFFF00">B</td>
	<?php }else if($dd >= '60'){ ?>
	<td bgcolor="#FF6600">C</td>
	<?php }else if($dd <= '59'){ ?>
	<td bgcolor="#FF0000">D</td>
	<?php } ?>	</tr>

<?php
}	
if($date_sum10 <= $today){	
	
$strSQL1 = "SELECT iv_no FROM hos__br  where iv_date LIKE '%".$date_sum10."%'  and research_demo !='0' $sddd";
if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
$strSQLc1 = "SELECT DISTINCT ref_id FROM tb_research_demo  where iv_date LIKE '%".$date_sum10."%'  $sddd";
if($sale_code !=""){ 
    $strSQLc1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQueryc1 = mysqli_query($conn,$strSQLc1) or die ("Error Query [".$strSQLc1."]");
$Num_Rowsc1 = mysqli_num_rows($objQueryc1);
?>

<tr>
<td><?php echo DateThai1($date_sum10);?></td>
<td><?php echo $Num_Rows1; ?></td>
<td><?php echo $Num_Rowsc1; ?></td>
<?php
if($Num_Rowsc1!='0' and $Num_Rows1!='0'){	
$dd = (($Num_Rowsc1/$Num_Rows1)*100);	
}else{
$dd = '0';	
}

if($Num_Rowsc1=='0' and $Num_Rows1=='0'){
?>	
<td></td>
<?php	
}else if($dd >= '90'){
	?>
	<td bgcolor="#00FF00">A+</td>
<?php }else if ($dd >= '80'){ ?>
	<td bgcolor="#CCFF99">A</td>
	<?php }else if($dd >= '70'){ ?>
	<td bgcolor="#FFFF00">B</td>
	<?php }else if($dd >= '60'){ ?>
	<td bgcolor="#FF6600">C</td>
	<?php }else if($dd <= '59'){ ?>
	<td bgcolor="#FF0000">D</td>
	<?php } ?>	</tr>
		
<?php
}	
if($date_sum11 <= $today){	
	
$strSQL1 = "SELECT iv_no FROM hos__br  where iv_date LIKE '%".$date_sum11."%'  and research_demo !='0' $sddd";
if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
$strSQLc1 = "SELECT DISTINCT ref_id FROM tb_research_demo  where iv_date LIKE '%".$date_sum11."%'  $sddd";
if($sale_code !=""){ 
    $strSQLc1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQueryc1 = mysqli_query($conn,$strSQLc1) or die ("Error Query [".$strSQLc1."]");
$Num_Rowsc1 = mysqli_num_rows($objQueryc1);
?>

<tr>
<td><?php echo DateThai1($date_sum11);?></td>
<td><?php echo $Num_Rows1; ?></td>
<td><?php echo $Num_Rowsc1; ?></td>
<?php
if($Num_Rowsc1!='0' and $Num_Rows1!='0'){	
$dd = (($Num_Rowsc1/$Num_Rows1)*100);	
}else{
$dd = '0';	
}

if($Num_Rowsc1=='0' and $Num_Rows1=='0'){
?>	
<td></td>
<?php	
}else if($dd >= '90'){
	?>
	<td bgcolor="#00FF00">A+</td>
    <?php }else if ($dd >= '80'){ ?>
	<td bgcolor="#CCFF99">A</td>
	<?php }else if($dd >= '70'){ ?>
	<td bgcolor="#FFFF00">B</td>
	<?php }else if($dd >= '60'){ ?>
	<td bgcolor="#FF6600">C</td>
	<?php }else if($dd <= '59'){ ?>
	<td bgcolor="#FF0000">D</td>
	<?php } ?>	</tr>
		
			
<?php
}	
if($date_sum12 <= $today){	
	
$strSQL1 = "SELECT iv_no FROM hos__br  where iv_date LIKE '%".$date_sum12."%'  and research_demo !='0' $sddd";
if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
$strSQLc1 = "SELECT DISTINCT ref_id FROM tb_research_demo  where iv_date LIKE '%".$date_sum12."%'   $sddd";
if($sale_code !=""){ 
    $strSQLc1 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQueryc1 = mysqli_query($conn,$strSQLc1) or die ("Error Query [".$strSQLc1."]");
$Num_Rowsc1 = mysqli_num_rows($objQueryc1);
?>

<tr>
<td><?php echo DateThai1($date_sum12);?></td>
<td><?php echo $Num_Rows1; ?></td>
<td><?php echo $Num_Rowsc1; ?></td>
<?php
if($Num_Rowsc1!='0' and $Num_Rows1!='0'){	
$dd = (($Num_Rowsc1/$Num_Rows1)*100);	
}else{
$dd = '0';	
}

if($Num_Rowsc1=='0' and $Num_Rows1=='0'){
?>	
<td></td>
<?php	
}else if($dd >= '90'){
	?>
	<td bgcolor="#00FF00">A+</td>
<?php }else if ($dd >= '80'){ ?>
	<td bgcolor="#CCFF99">A</td>
	<?php }else if($dd >= '70'){ ?>
	<td bgcolor="#FFFF00">B</td>
	<?php }else if($dd >= '60'){ ?>
	<td bgcolor="#FF6600">C</td>
	<?php }else if($dd <= '59'){ ?>
	<td bgcolor="#FF0000">D</td>
	<?php } ?>		
</tr>
		
<?php } ?>		
	

</table>
	
	
	

<br><br>
</div></div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>




