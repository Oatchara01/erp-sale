<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script>

function ckk_1() {
		if (document.getElementById('object5').checked) {
			document.getElementById('dt5').style.display = 'block';
		}
		else if (document.getElementById('object6').checked) {
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object7').checked) {
			document.getElementById('dt5').style.display = 'none';
		}
}


function object() {
		if (document.getElementById('object1').checked) {
			document.getElementById('dt1').style.display = 'block';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
		}
		else if (document.getElementById('object2').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'block';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
		}
		else if (document.getElementById('object3').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'block';
			document.getElementById('dt4').style.display = 'none';
		}
		else if (document.getElementById('object4').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'block';
		}
	
	}

</script>


<?php include('head.php'); ?>
<body>
<?php
$strSQL = "SELECT
so__main.* ,tb_salechannel.* ,tb_delivery.* ,tb_payment.*  FROM (((so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_id) LEFT JOIN tb_payment ON so__main.payment=tb_payment.payment_ID) WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
?>
<form action="register_lazada1.php" method="post" name="frmMain" >
<div class="w3-container w3-padding-large"><!-- main div -->
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom">
	<div class="w3-half">
		<h4>Edit Data : Admin</h4>
	</div>
	<div class="w3-half">
		<a href="register_lazada.php?ref_id=<?php echo $objResult["ref_id"]+1;?>" class="w3-button w3-grey w3-right"><font color="330066">NEXT</font></a>
		<a href="register_lazada.php?ref_id=<?php echo $objResult["ref_id"]-1;?>" class="w3-button w3-grey w3-right"><font color="330066">BACK</font></a>
	</div>
</div>
<div class="w3-container w3-third"><!-- first half -->
<div class="w3-bar w3-border">
<?php
if ($objResult["select_type_doc"]=='1'){
?>
<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="1" onclick="javascript:object();"  id="object1">&nbsp;ใบยืมสินค้า PTL</div>
<?php
}else{
	?>
<div class="w3-button"><input type="radio" name="select_type_doc" value="1" onclick="javascript:object();"  id="object1">&nbsp;ใบยืมสินค้า PTL</div>
		<?php
}
		if ($objResult["select_type_doc"]=='2'){
			?>
<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="2" onclick="javascript:object();"  id="object2" >&nbsp;ใบยืมสินค้า NBM</div>
				<?php
		}else{
				?>
<div class="w3-button"><input type="radio" name="select_type_doc" value="2" onclick="javascript:object();"  id="object2" >&nbsp;ใบยืมสินค้า NBM</div>
					<?php
					}
		if ($objResult["select_type_doc"]=='3'){
?>
<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="3" onclick="javascript:object();"  id="object3" >&nbsp;ใบสั่งขาย PTL</div>
<?php
	}else{
	?>
<div class="w3-button"><input type="radio" name="select_type_doc" value="3" onclick="javascript:object();"  id="object3" >&nbsp;ใบสั่งขาย PTL</div>
		<?php
}
			if ($objResult["select_type_doc"]=='4'){
			?>
<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="4" onclick="javascript:object();"  id="object4" >&nbsp;ใบสั่งขาย NBM</div>
<?php
			}else{
				?>
<div class="w3-button"><input type="radio" name="select_type_doc" value="4" onclick="javascript:object();"  id="object4">&nbsp;ใบสั่งขาย NBM</div>
					<?php
			}
						?>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
<?php
	$date = explode('-' , $objResult["register_date"] );
$xdate = $date[2].'-'.$date[1].'-'.$date[0];
 /*echo $xdate;*/?>
วันที่ : <span class="w3-light-grey"><?php echo datethai($xdate); ?></span> เลขที่อ้างอิง :<span class="w3-light-grey"><?php echo $objResult['ref_id']; ?></span><input type="hidden" name="ref_id" class="w3-input25" value="<?php echo $objResult['ref_id']; ?>"> <input type="hidden" name="main_id" value="<?php echo $objResult['main_id']; ?>"><br />
<input type="hidden" name="register_date" value="<?php echo $objResult['register_date']; ?>">
<input type="hidden" name="register_time" value="<?php echo $objResult['register_time']; ?>">
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
ช่องทางการขาย
<select name="sale_channel" id="sale_channel" class="w3-select" onchange="showUser(this.value)">
<option  value="">**โปรดเลือกช่องทางการขาย**</option>
<?php
$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) 
	{
if($objResult["sale_channel"] == $fetchchannel["salechannel_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>" <?php echo $sel;?>><?php echo $fetchchannel['salechannel_nameshort']; ?>&nbsp;&nbsp;<?php echo $fetchchannel['description_chanel']; ?></option>
<?php } ?>
</select>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
การจัดส่ง

<input name="delivery" type='text' class="w3-input" id="delivery" value="<?php echo $objResult["delivery_name"]; ?><?php echo $objResult["time_delivery"]; ?>" placeholder="Search การจัดส่ง..."> 
<input name="h_delivery" type="hidden" id="h_delivery"  value="<?php echo $objResult["delivery"]; ?>" class="w3-input" /> 




<?php /*
<select name="delivery" class="w3-select"  >
<option value="">**Please Select Item**</option>

<?php
$sqldeli = "SELECT tb_delivery.*,tb_sender.* FROM tb_delivery LEFT JOIN tb_sender ON tb_delivery.employee_send=tb_sender.sender_ID";
$querydeli = mysqli_query($conn,$sqldeli);
if (!$querydeli) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($fetchdeli = mysqli_fetch_array($querydeli,MYSQLI_ASSOC)) {
if($objResult["delivery"] == $fetchdeli["delivery_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_id'];?>"><?php echo $fetchdeli['delivery_name'];?> </option>
<?php } ?>
</select>*/?>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
การชำระเงิน:
<input name="payment" type='text' class="w3-input" id="payment"  value="<?php echo $objResult["payment_name"]; ?><?php echo $objResult["bank_name"]; ?><?php echo $objResult["book_name"]; ?>" placeholder="Search การชำระเงิน..."> 
<input name="h_payment" type="hidden" id="h_payment" value="<?php echo $objResult["payment"]; ?>" class="w3-input" /> 


<?php /*
<select name="payment" class="w3-select"  >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_payment order by payment_ID";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["payment"] == $objResuut5["payment_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['payment_ID']; ?>"<?php echo $sel;?>><?php echo $objResuut5['payment_name']; ?> | <?php echo $objResuut5['bank_name']; ?> | <?php echo $objResuut5['book_number']; ?> | <?php echo $objResuut5['branch_bank']; ?> | <?php echo $objResuut5['book_type']; ?> | <?php echo $objResuut5['book_name']; ?> </option>
<?php } ?>
</select>*/ ?>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
หมายเหตุ:
<textarea name="sale_remark"  class="w3-input" id="sale_remark"  rows="1"><?php echo $objResult['sale_remark']; ?></textarea>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
ชื่อพนักงาน:

<input name="employee_name" type='text' class="w3-input" value ="<?php echo $objResult['employee_name']; ?>" id="employee_name" placeholder="Search พนักงาน..."> 
<input name="h_employee_name" type="hidden" id="h_employee_name" value="<?php echo $objResult["employee_name"]; ?>" class="w3-input" /> 


<?php /*
<select  name="employee_name" class="w3-select"  >
<option value="">**Please Select Item**</option>
<?php
$emp = "select * from tb_employee where status=1 order by employee_ID";
$sqlemp = mysqli_query($conn,$emp);
while ($fetchemp = mysqli_fetch_array($sqlemp,MYSQLI_ASSOC)) {
if($objResult["employee_name"] == $fetchemp["employee_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchemp['employee_ID']; ?>"<?php echo $sel;?>><?php echo $fetchemp['employee_name']; ?></option>
<?php } ?>
</select>*/?>

</div>
</div><!-- first half -->

<div class="w3-container w3-twothird"><!-- second half -->
<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity('st')"><font color="#404040"><b>Admin ลงทะเบียน</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity('so')"><font color="#404040"><b>ใบสั่งขาย</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity('mo')"><font color="#404040"><b>เพิ่มเติม</b></font></a>
  <a class="w3-bar-item w3-button"  onclick="openCity('br')"><font color="#404040"><b>ใบยืมสินค้า</b></font></a>
</div>

<div id="st" class="city" >
<div class="w3-half"><!-- first right half -->
<div class="w3-padding-small"></div>
<div class="w3-half w3-bar">
เลขที่เอกสาร <input name="doc_no" class="w3-input" value="<?php echo $objResult['doc_no']; ?>" type="text">
</div>

<div class="w3-container w3-half w3-bar">
เลขที่ลงงาน <input name="job_id" class="w3-input" value="<?php echo $objResult['job_id']; ?>" type="text">
</div>
<div class="w3-bar w3-padding-small"></div>
<div class="w3-half w3-bar">
วันที่ออกเอกสาร <input name="doc_release_date" class="w3-input" value="<?php echo $objResult['doc_release_date']; ?>" type="date">
</div>
<div class="w3-container w3-half w3-bar">
ฝากสินค้าเลขที่ <input name="deposit_no" class="w3-input" value="<?php echo $objResult['deposit_no']; ?>" type="text">
</div>
<div class="w3-bar w3-padding-small"></div>
<div class="w3-bar">
<?php
if ($objResult["select_type_doc"]=='1'){
?>
<input type="checkbox"  checked="checked" value="1">&nbsp;

<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม PTL</font></a>&nbsp;&nbsp;
<?php
}else{
	?>

<div id="dt1" style="display:none">
					
<input type="checkbox"  checked="checked" value="1">&nbsp;

<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม PTL</font></a>&nbsp;&nbsp;
</div>

<?php
}

if ($objResult["select_type_doc"]=='2'){

?>
<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
					

<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;
<?php
}else{
	?>
<div id="dt2" style="display:none">
<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
					

<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;

</div>
<?php
}
if ($objResult["select_type_doc"]=='3'){

?>
	<input type="checkbox" name="select_so_ptl" checked="checked" value="1">&nbsp;
		
<a href="report_saleptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย PTL</font></button></a><br />

<?php
}else{
?>

<div id="dt3" style="display:none">

<input type="checkbox" name="select_so_ptl" checked="checked" value="1">&nbsp;
		
<a href="report_saleptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย PTL</font></button></a><br />

</div>
<?php
}
if ($objResult["select_type_doc"]=='4'){

?>
	<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
				

<a href="report_salenbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
<?php
}else{
	?>
	<div id="dt4" style="display:none">

		
<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
				

<a href="report_salenbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
</div>
<?php
}
?>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">ใบปะหน้ากล่อง :</div>

<div class="w3-half"><a href="report_99std.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a></div>
<div class="w3-half"><a href="report_99std_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a></div>
<div class="w3-bar w3-padding-small"></div>
<div class="w3-half"><a href="report_a5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ptl</font></a></div>
<div class="w3-half"><a href="report_a5ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ptl+k</font></a></div>
<div class="w3-bar w3-padding-small"></div>
<div class="w3-half"><a href="report_a4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ptl</font></a></div>
<div class="w3-half"><a href="report_a4ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ptl+k</font></a></div>
<div class="w3-bar w3-padding-small"></div>
<div class="w3-half"><a href="report_a5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a></div>
<div class="w3-half"><a href="report_a5nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a></div>
<div class="w3-bar w3-padding-small"></div>
<div class="w3-half"><a href="report_a4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a></div>
<div class="w3-half"><a href="report_a4nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a></div>
<div class="w3-bar w3-padding-small"></div>
</div><!-- first right half -->

<div class="w3-half"><!-- second right half -->
<div class="w3-bar w3-left w3-half">
<a href="" target="_blank" class="w3-button w3-blue" style="width:100%;">สรุปยืมแบบรวม PTL</a>
</div>
<div class="w3-bar w3-right w3-half">
<a href="" target="_blank" class="w3-button w3-pink" style="width:100%;">สรุปยืมแบบรวม NBM</a>
</div>
<div class="w3-bar w3-center">
<a href="" target="_blank" class="w3-button w3-purple" style="width:100%;">รายชื่อที่ต้องการออกบิล</a>
</div>
<div class=" w3-padding-small">
<div class="w3-bar w3-half">
<?php
if ($objResult['job_id']=='1'){
?>
<input type='checkbox' name='admin_commplete' checked='checked' value='1'> คลิ๊กสมบูรณ์เมื่อออกบิลแล้ว
<?php
}else{
	?>
<input type='checkbox' name='admin_commplete' value='1'> คลิ๊กสมบูรณ์เมื่อออกบิลแล้ว

		<?php
}
			?>

</div>
<div class="w3-bar w3-half">Status เอกสาร 
<?php
if ($objResult['status_doc']=='1'){
?>

<input type='radio' name='status_doc' checked="checked" value='1'>&nbsp;รอดำเนินการ 
<input type='radio' name='status_doc' value='2'>&nbsp;สมบูรณ์แล้ว

<?php
} else if ($objResult['status_doc']=='2'){

	?>
<input type='radio' name='status_doc'  value='1'>&nbsp;รอดำเนินการ
<input type='radio' name='status_doc' checked="checked" value='2'>&nbsp;สมบูรณ์แล้ว
<?php 
}else{
		?>
<input type='radio' name='status_doc'  value='1'>&nbsp;รอดำเนินการ
<input type='radio' name='status_doc'  value='2'>&nbsp;สมบูรณ์แล้ว
<?php
	}
		?>
</div>
<div class=" w3-padding-small"></div>
<div class="w3-bar">แนบไฟล์ </div>

<input type='hidden' name='upload1' id='upload1' value ="<?php echo $objResult['upload1']; ?>"  />
<input type='hidden' name='upload2' id='upload2' value ="<?php echo $objResult['upload2']; ?>"  />
<input type='hidden' name='upload3' id='upload3' value ="<?php echo $objResult['upload3']; ?>"  />
<input type='hidden' name='upload4' id='upload4' value ="<?php echo $objResult['upload4']; ?>"  />
<input type='hidden' name='upload5' id='upload5' value ="<?php echo $objResult['upload5']; ?>"  />

<input name="upload1"  type="file"><a href="upload/<?php echo $objResult['upload1']; ?>" target="_blank"><?php echo $objResult['upload1']; ?></a></p>



<input name="upload2"  type="file"><a href="upload/<?php echo $objResult['upload2']; ?>" target="_blank"><?php echo $objResult['upload2']; ?></a></p>
<input name="upload3"  type="file"><a href="upload/<?php echo $objResult['upload3']; ?>" target="_blank"><?php echo $objResult['upload3']; ?></a></p>
<input name="upload4"  type="file"><a href="upload/<?php echo $objResult['upload4']; ?>" target="_blank"><?php echo $objResult['upload4']; ?></a></p>
<input name="upload5"  type="file"><a href="upload/<?php echo $objResult['upload5']; ?>" target="_blank"><?php echo $objResult['upload5']; ?></a></p>
</div>
</div><!-- second right half -->
</div><!-- close st -->

<div id="so" class="city" style="display:none">
<div class="w3-half"><!--first half-->
<div class=" w3-padding-small"></div>
<div class="w3-bar">
ชื่อที่ออกบิล: <input name="billing_name" type='text' class="w3-input" value="<?php echo $objResult['billing_name']; ?>">
</div>
<div class=" w3-padding-small"></div>
<div class="w3-bar">
ทีอยู่ที่ออกบิล: <textarea name="billing_address" class="w3-input" rows="1"><?php echo $objResult['billing_address']; ?></textarea>
</div>
<div class=" w3-padding-small"></div>
<div class="w3-bar w3-half">
Tel.: <input type="text" name="billing_tel" class="w3-input" value="<?php echo $objResult['billing_tel']; ?>">
</div>
<div class=" w3-padding-small"></div>
<div class="w3-bar w3-half">
<?php
if($objResult['full_bill']=='1'){
?>
<input type="checkbox" name="full_bill" checked='checked' value="1"> บิล VAT
<?php
}else{
	?>
<input type="checkbox" name="full_bill" value="1"> บิล VAT
		<?php
}
?>
</div>
<div class=" w3-padding-small"></div>
<div class="w3-bar">
การชำระเงิน:

<input name="payment1" type='text' class="w3-input" id="payment1"  value="<?php echo $objResult["payment_name"]; ?><?php echo $objResult["bank_name"]; ?><?php echo $objResult["book_name"]; ?>" placeholder="Search การชำระเงิน..."> 

<?php/*
<select name="payment" class="w3-select" disabled>
<option value="">**Please Select Item**</option>
<?php
$strSQL6 = "select * from tb_payment order by payment_ID";
$objQuery6 = mysqli_query($conn,$strSQL6);
if (!$objQuery6) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut6 = mysqli_fetch_array($objQuery6,MYSQLI_ASSOC)) {
if($objResult["payment"] == $objResuut6["payment_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut6['payment_ID']; ?>"<?php echo $sel;?>><?php echo $objResuut6['payment_name']; ?> | <?php echo $objResuut6['bank_name']; ?> | <?php echo $objResuut6['book_number']; ?> | <?php echo $objResuut6['branch_bank']; ?> | <?php echo $objResuut6['book_type']; ?> | <?php echo $objResuut6['book_name']; ?> | <?php echo $objResuut6['description_payment']; ?></option>
<?php } ?>
</select>*/?>
</div>
<div class=" w3-padding-small"></div>
<div class="w3-bar">
การโอนเงิน:
<select name="transfer" class="w3-select">
<option value="">**Please Select Item**</option>
<?php
$strSQL3 = "SELECT * FROM tb_transfer ORDER BY tranfer_ID ASC";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
while($objResult3 = mysqli_fetch_array($objQuery3)){
if($objResult["transfer"] == $objResult3["tranfer_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResult3["tranfer_name"];?>"<?php echo $sel;?>><?php echo $objResult3["tranfer_name"];?></option>
<?php
}
?>
</select>
</div>
<div class=" w3-padding-small"></div>
<div class="w3-bar">
ส่งบัญชีตรวจสอบ
<?php
if ($objResult["account_approve"]=='1'){
?>
<input type="checkbox" name="account_approve" checked='checked' value="1">
<?php
}else{
	?>
<input type="checkbox" name="account_approve" value="1">
<?php
}
?>
</div>
<div class="w3-bar w3-half">
วันที่โอน
<input type="date" name="transfer_date" id="transfer_date" class="w3-input" value="<?php echo $objResult["transfer_date"];?>">
</div>
<div class="w3-bar w3-half">
จำนวนเงินโอน/เก็บปลายทาง
<input type="text" name="amount" class="w3-input" value="<?php echo $objResult["amount"];?>">
</div>
<div class="w3-bar w3-padding-small"></div>
</div><!-- first half -->
<div class="w3-half w3-container w3-pale-green"><!--second half-->
<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
ชื่อผู้รับสินค้า
<input name="customer_name" type="text" class="w3-input" value="<?php echo $objResult["customer_name"];?>">
<div class="w3-bar w3-padding-small"></div>
ที่อยู่ในการจัดส่ง
<input name="address1" class="w3-input" type="text" value="<?php echo $objResult["address1"];?>">
<input name="address2" class="w3-input" type="text" value="<?php echo $objResult["address2"];?>">
<div class="w3-bar w3-padding-small"></div>
จังหวัด
<select name="province" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) {

if($objResult["province"] == $fepro["province_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>
<div class="w3-bar w3-padding-small"></div>
รหัสไปรษณีย์
<input name="postcode" type="text" value="<?php echo $objResult["postcode"];?>" class="w3-input">
<div class="w3-bar w3-padding-small"></div>
โทรศัพท์
<input name="tel" type="text"  value="<?php echo $objResult["tel"];?>" class="w3-input">
<div class="w3-bar w3-padding-small"></div>
</div><!-- second half -->
</div><!-- close so -->

<div id="mo" class="city" style="display:none">
<div class="w3-third"><!-- 1st 3rd -->
<div class="w3-bar w3-padding-small"></div>
ชื่อผู้แนะนำ
<input name="prefer_name" class="w3-input" value="<?php echo $objResult["prefer_name"];?>" >
<div class="w3-bar w3-padding-small"></div>
ใบสั่งซื้อเลขที่
<input name="po_no" class="w3-input" value="<?php echo $objResult["po_no"];?>" >
<div class="w3-bar w3-padding-small"></div>
กำหนดส่งตามสัญญา:
<input name="delivery_contract" class="w3-input" value="<?php echo $objResult["delivery_contract"];?>" >

<div class="w3-bar w3-padding-small"></div>
<?php
if($objResult["clear_book_ckk"]=='1'){
?>
<input type="checkbox" name="clear_book_ckk" checked="checked" value="1">&nbsp;

<?php
}else{
	?>
<input type="checkbox" name="clear_book_ckk" value="1">&nbsp;


<?php
}
?>

เคลียร์ใบจอง:
<input name="clear_book_no" class="w3-input" value="<?php echo $objResult["clear_book_no"];?>" placeholder="เลขที่" >
<div class="w3-bar w3-padding-small"></div>
<?php
if($objResult["clear_brn_no_ckk"]=='1'){
?>

<input type="checkbox" name="clear_brn_no_ckk" checked='checked' value="1">&nbsp;

<?php
}else{
?>
	<input type="checkbox" name="clear_brn_no_ckk" value="1">&nbsp;
<?php
}
?>



เคลียร์ใบยืม BRN:
<input name="clear_brn_no" class="w3-input" value="<?php echo $objResult["clear_brn_no"];?>" placeholder="เลขที่" >
<div class="w3-bar w3-padding-small"></div>
<?php
if($objResult["clear_brnp_no_ckk"]=='1'){
?>
<input type="checkbox" name="clear_brnp_no_ckk" checked='checked' value="1">&nbsp;

<?php
}else{
	?>

<input type="checkbox" name="clear_brnp_no_ckk" value="1">&nbsp;

		<?php
}
		?>


เคลียร์ใบยืม BRNP:
<input name="clear_brnp_no" class="w3-input" value="<?php echo $objResult["clear_brnp_no"];?>" placeholder="เลขที่" >
<div class="w3-bar w3-padding-small"></div>
</div>
<div class="w3-third w3-container"><!-- 2nd 3rd -->
<div class="w3-bar w3-padding-small"></div>

<?php
if($objResult["sn_ckk"]=='1'){
?>
<input type="checkbox" name="sn_ckk" checked="checked" value="1">&nbsp;
<?php
}else{
	?>
<input type="checkbox" name="sn_ckk" value="1">&nbsp;

		<?php
}
		?>

ต้องการ SN:
<input name="sn" class="w3-input" value="<?php echo $objResult["sn"];?>" >
<div class="w3-bar w3-padding-small"></div>
<?php
if($objResult["bq_ckk"]=='1'){
?>
<input type="checkbox" name="bq_ckk" checked="checked" value="1">&nbsp;
<?php
}else{
	?>
<input type="checkbox" name="bq_ckk" value="1">&nbsp;

		<?php
}
		?>


BQ เลขที่:
<input name="bq" class="w3-input" value="<?php echo $objResult["bq"];?>" >
<div class="w3-bar w3-padding-small"></div>
<?php
if($objResult["ot_ckk"]=='1'){
?>
<input type="checkbox" name="ot_ckk" checked="checked" value="1">&nbsp;
<?php
}else{
	?>
<input type="checkbox" name="ot_ckk" value="1">&nbsp;

		<?php
}
		?>


OT เลขที่:
<input name="ot" class="w3-input" value="<?php echo $objResult["ot"];?>" >
</div>
<div class="w3-third"><!-- 3rd 3rd -->
<div class="w3-bar w3-padding-small"></div>
สถานที่ติดตั้งเครื่อง
<input name="install_place" class="w3-input" value="<?php echo $objResult["install_place"];?>" >
<div class="w3-bar w3-padding-small"></div>
<?php 
if($objResult["with_pr"]=='1'){
?>
<input name="with_pr" type="checkbox" checked='checked' value="1">
<?php
}else{
	?>
<input name="with_pr" type="checkbox" value="1">
<?php
}
			?>
แนบใบเสนอราคา
<div class="w3-bar w3-padding-small"></div>
<?php 
if($objResult["type_type"]=='1'){
?>

<input type="radio" name="type_type" checked="checked" value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />

<?php
}else if($objResult["type_type"]=='2'){
	?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" checked="checked" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />

		<?php
}else if($objResult["type_type"]=='3'){

			?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" checked="checked" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />

	<?php
}else {

			?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type"  value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />


<?php 
		}

if($objResult["type_type"]=='3'){
?>

ระบุ:
<textarea name="type_type_detail" class="w3-input" style="resize: none;width:100%"><?php echo $objResult["type_type_detail"];?></textarea>
<?php
}else{
	?>

<div id="dt5" style="display:none">

ระบุ:
<textarea name="type_type_detail" class="w3-input" style="resize: none;width:100%"></textarea>
</div>

		<?php
}
			?>

</div>
</div><!-- close more -->

<div id="br" class="city" style="display:none">
<?php
$sale_channel=$objResult["sale_channel"];
include "dbconnect.php";
$sql="SELECT tb_salechannel.*,tb_province.* FROM tb_salechannel LEFT JOIN tb_province ON tb_salechannel.province_id=tb_province.province_ID WHERE salechannel_ID = '".$sale_channel."'";

//echo  $sql;
//exit();

$result = mysqli_query($conn,$sql) or die(mysqli_error());
$row = mysqli_fetch_array($result);

?>
<div class="w3-bar w3-padding-small"></div>
<div class="w3-bar">
วัตถุประสงค์การเบิก: <input name='objective'  class='w3-input' value="<?php echo $row["salechannel_nameshort"];?>"/>
</div>
<div class="w3-bar w3-padding-small"></div>
<div class="w3-bar">
หมายเลขคำสั่งซื้อ: <input type='text' class='w3-input' name='order_id'  value="<?php echo $objResult["order_id"]; ?>">
</div>
<div class="w3-bar w3-padding-small"></div>
<div class="w3-bar">
ชื่อลูกค้าตามคำสั่งซื้อ: <input type='text' class='w3-input' name='order_name' value="<?php echo $objResult["order_name"]; ?>" >
</div>
<div class="w3-bar w3-padding-small"></div>
<div class="w3-bar">
ชื่อลูกค้า: <span class="w3-padding-small"><?php echo $row["salechannel_nameshort"];?></span>
</div>
<div class="w3-bar">
วันที่: <span class="w3-padding-small"><?php echo DateThai($objResult["register_date"]); ?></span>
</div>
<div class="w3-bar">
เลขที่เอกสาร: <span class="w3-padding-small"><?php echo $objResult["doc_no"];?></span>
</div>
<div class="w3-bar">
เลขที่ลงงาน: <span class="w3-padding-small"><?php echo $objResult["job_id"];?></span>
</div>
<div class="w3-bar">
วันที่ออกเอกสาร: <span class="w3-padding-small"><?php echo $objResult["doc_release_date"];?></span>
</div>
<div class="w3-bar">
ชื่อลูกค้า: <span class="w3-padding-small"><?php echo $row["salechannel_nameshort"];?></span>
</div>
<div class="w3-bar">
ที่อยู่: <span class="w3-padding-small"><?php echo $row["address1"]; ?>&nbsp;<?php echo $row["address2"]; ?>&nbsp;<?php echo $row['province_name']; ?>&nbsp;<?php echo $row['zip_code']; ?></span>
</div>
<div class="w3-bar">
หมายเหตุ: <span class="w3-padding-small"><?php echo $row['description_chanel']; ?></span>
</div>
</div><!-- close br -->
</div><!-- second half -->

<div class="w3-bar w3-light-grey w3-border">
    <a class="w3-bar-item w3-button" onclick="openCity1('stoc')"><font color="#404040"><b>เอกสารแนบเพิ่มเติม</b></font></a>
	<a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
	<a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
	<a class="w3-bar-item w3-button" onclick="openCity1('ot')"><font color="#404040"><b>ปิดงาน</b></font></a>
</div>

<div id="stoc" class="w3-container city1" style="display:none">
<div class="w3-quarter w3-container">
<b>เอกสารเพิ่มเติม Lazada</b><br/>
1. ใบบาร์โค้ด<br/>
2. รายละเอียดลูกค้า<br/>
3.<br/>
4.<br/>
5.
</div>
<div class="w3-quarter w3-container">
<b>เอกสารเพิ่มเติม 99 HM</b><br />
1. Slip<br />
2. รายละเอียดลูกค้า<br />
3.<br />
4.<br />
5.
</div>
<div class="w3-quarter w3-container">
<b>เอกสารเพิ่มเติม 11 Street</b><br />
1. ใบบาร์โค้ด<br />
2. รายละเอียดลูกค้า<br />
3.<br />
4.<br />
5.
</div>
</div>

<div id="pd" class="w3-container city1">

<?php 
include ('data_product_code1.1.php')
?>



</div>

<div id="cs" class="w3-container city1" style="display:none">
<div class="w3-quarter"><!-- first third-->
<input type="checkbox" name="" hidden><br \>
วันที่ส่ง
<input type="date" name="delivery_date" value="<?php echo $objResult["delivery_date"];?>" class="w3-input" >
เวลาส่ง
<input type="text" name="delivery_time" value="<?php echo $objResult["delivery_time"];?>" class="w3-input" >
การส่งสินค้า<br>

		<?php

		if($objResult["big_car"]){

			?>
<input type="checkbox" name="big_car" checked='checked' value="1">ต้องการรถใหญ่<br />
<?php
		}else{
	?>
<input type="checkbox" name="big_car" value="1">ต้องการรถใหญ่<br />

		<?php
}
		if($objResult["call_before"]){
			?>
<input type="checkbox" name="call_before" checked='checked' value="1">โทรแจ้งลูกค้าก่อนไป<br />
<?php
		}else{
	?>
<input type="checkbox" name="call_before" value="1">โทรแจ้งลูกค้าก่อนไป<br />
		<?php
}
		if($objResult["maps"]){
			?>
<input type="checkbox" name="maps" checked='checked' value="1">มีแผนที่ประกอบ</p>
<?php
		}else{
				?>
<input type="checkbox" name="maps" value="1">มีแผนที่ประกอบ</p>
					<?php
			}
?>
<input type='hidden' name='upload_map' id='upload_map' value ="<?php echo $objResult['upload_map']; ?>"  />

<input name="upload_map"  type="file"><a href="upload/<?php echo $objResult['upload_map']; ?>" target="_blank"><?php echo $objResult['upload_map']; ?></a></p>


<?php
	if($objResult["assign_date_time"]){
						?>
<input type="checkbox" name="assign_date_time" checked='checked' value="1">นัดวันเวลาเรียบร้อยแล้ว<br />

<?php
				}else{
	?>
<input type="checkbox" name="assign_date_time" value="1">นัดวันเวลาเรียบร้อยแล้ว<br />
<?php
}
	?>

</div><!-- first third-->
<div class="w3-quarter w3-container"><!-- second third-->
<?php

		if($objResult["delivery_type"]=='1'){
			?>
<input type="radio" name="delivery_type" checked='checked' value="1">Sale รับเอง
<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type"  value="4">บริษัทจัดส่ง <br />
<?php
		}else if($objResult["delivery_type"]=='2'){
	?>
<input type="radio" name="delivery_type" value="1">Sale รับเอง
<input type="radio" name="delivery_type" checked='checked' value="2">ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type"  value="4">บริษัทจัดส่ง <br />

		<?php
}else if($objResult["delivery_type"]=='3'){
		
			?>
	<input type="radio" name="delivery_type" value="1">Sale รับเอง
	<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
    <input type="radio" name="delivery_type" checked='checked' value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type"  value="4">บริษัทจัดส่ง <br />
<?php
	
		}else if($objResult["delivery_type"]=='4'){
		?>

	<input type="radio" name="delivery_type" value="1">Sale รับเอง
	<input type="radio" name="delivery_type" value="2">ช่างรับเอง <br />
    <input type="radio" name="delivery_type"  value="3">ลูกค้ารับเอง
	<input type="radio" name="delivery_type" checked='checked' value="4">บริษัทจัดส่ง <br />

			<?php
}else {
			?>
	<input type="radio" name="delivery_type" value="1">Sale รับเอง
	<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
    <input type="radio" name="delivery_type"  value="3">ลูกค้ารับเอง 
	<input type="radio" name="delivery_type"  value="4">บริษัทจัดส่ง <br />

				<?php
			}
				?>
สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" cols="20" rows="1" style="width:100%;resize: none" ><?php echo $objResult["delivery_place"];?></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" value ="<?php echo $objResult["delivery_contact"];?>" class="w3-input" >
</div><!-- second third-->
<div class="w3-quarter"><!-- 3rd third-->
<input type="checkbox" name="return" value="1">รับคืนสินค้า<br>
วันที่รับคืน
<input type="date" name="return_date" value ="<?php echo $objResult["return_date"];?>" class="w3-input" >
เวลา
<input type="text" name="return_time" value ="<?php echo $objResult["return_time"];?>" class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address" value ="<?php echo $objResult["return_address"];?>" class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact" value ="<?php echo $objResult["return_contact"];?>" class="w3-input" >
</div><!-- 3rd third-->

</div>
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='register_lazada1.php'; submit()">
</center>

<?php require_once('foot.php'); ?>
</div>
</form>

</body>
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
		return "data_delivery.php?delivery_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("delivery","h_delivery");
        </script>


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
		return "data_payment.php?payment_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("payment","h_payment");
        </script>

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
		return "data_employee_name.php?employee_name_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("employee_name","h_employee_name");
        </script>


<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[id="sale_channel"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("data_sale_channel.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[id="sale_channel"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
</script>