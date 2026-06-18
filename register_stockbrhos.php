<?php include('head.php');
?>
<?php include('dbconnect_sale.php'); ?>

<script language="JavaScript">
var HttPRequest = false;
function doCallAjax(product_code,product_id,product_name,unit_name) {
HttPRequest = false;
if (window.XMLHttpRequest) { // Mozilla, Safari,...
HttPRequest = new XMLHttpRequest();

if (HttPRequest.overrideMimeType) {
HttPRequest.overrideMimeType('text/html');
}
} else if (window.ActiveXObject) { // IE
try {
HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
try {
HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
} catch (e) {}
}
}

if (!HttPRequest) {

alert('Cannot create XMLHTTP instance');
return false;
}
var url = 'data_product_hos1.php';
var pmeters = "product_code=" + encodeURI( document.getElementById(product_code).value);
HttPRequest.open('POST',url,true);

HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
HttPRequest.setRequestHeader("Content-length", pmeters.length);
HttPRequest.setRequestHeader("Connection", "close");
HttPRequest.send(pmeters);

HttPRequest.onreadystatechange = function()
{
if(HttPRequest.readyState == 4) // Return Request
{
var myProduct = HttPRequest.responseText;

if(myProduct != "")
{

var myArr = myProduct.split("|");

document.getElementById(product_id).value = myArr[0];
document.getElementById(product_name).value = myArr[1];
document.getElementById(unit_name).value = myArr[2];


}
}
}
}


function chkNumber(ele)

{

var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
ele.onKeyPress=vchar;
}
	
	
function ck_1(){
var ck_1 = document.getElementById('ckk_1');
if(ck_1.checked == true){
document.getElementById('frm_txt_1').style.display = "";
}else{
document.getElementById('frm_txt_1').style.display = "none";
}

}


</script>



<script>
function object() {
		if (document.getElementById('object1').checked) {
			document.getElementById('dt1').style.display = 'block';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object2').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'block';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object3').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object4').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'block';
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object5').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'block';
		}
	}
</script>

<style type="text/css">

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 8px 10px;
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
<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #FF0000; }
-->
</style>

<?php

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


$ref_id_br =$_GET["ref_id_br"];

$sql = "SELECT *   FROM hos__br where ref_id_br ='".$ref_id_br."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);


$strSQL1 = "SELECT * FROM  (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$ref_id_br."' ";
//echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);



	 ?>

<div class="w3-white w3-container">
	<div class="w3-panel w3-light-grey">
	
	<div class="w3-half">
	<h3>Edit Borrow Order</h3>
	</div>

<div class="w3-half">



		
<a href="report_loanhos.php?ref_id_br=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">Print ใบยืม</font></button></a><br />



				</div>



	</div>
	<form  method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-bar">

	<?php if ($rs["company"]=='1'){ ?>
		<input type="radio" name="company" value="1" checked='checked' required>ใบยืม AWL
		<input type="radio" name="company" value="2" required> ใบยืม NBM
		<?php  }else if($rs["company"]=='2'){ ?>

		<input type="radio" name="company" value="1"  required>ใบยืม AWL
		<input type="radio" name="company" value="2" checked='checked' required> ใบยืม NBM


		<?php } ?>
		

		
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $rs["ref_id_br"]; ?></span>
		<input type="hidden" name="ref_id_br" class="w3-input" value="<?php echo $rs["ref_id_br"]; ?>">
	</div>
	
	<div class="w3-bar w3-padding-small"></div><!-- bar -->
	<div class="w3-half 1">

		<div class="w3-bar w3-margin-bottom">
			<span>รหัสลูกค้า</span> <input type="text" name="customer_id" id="customer_id" value = "<?php echo $rs["customer_id"]; ?>" class="w3-input" style="width:90%;"  OnChange="JavaScript:doCallAjax1('customer_id','customer','address');"  placeholder="Search ชื่อลูกค้า..." >
			<input type ='hidden' name="h_customer"  id="h_customer" class="w3-input" >

		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ชื่อลูกค้า/รพ.</span> <input type="text" name="customer" id="customer"  value = "<?php echo $rs["customer"]; ?>" class="w3-input" style="width:90%;"  required>

		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ที่อยู่</span> <textarea name="address" id="address"   class="w3-input" style="width:90%;" rows="2"><?php echo $rs["address"]; ?></textarea>
		</div>

		<div class="w3-bar w3-margin-bottom">
			<span>Sale Comment</span> <textarea name="sale_comment"  id="sale_comment" class="w3-input" style="width:90%;" rows="2"><?php echo $rs["sale_comment"]; ?></textarea>
		</div>
		
	<div class="w3-bar w3-margin-bottom">
		<?php if($rs['date_disburse']=='0000-00-00'){ ?>
			วันที่เบิกจ่ายสินค้า  :<input type="date" name="date_disburse" value = "<?php echo $today; ?>" style="width:30%;" class="w3-input" >
		<?php }else{ ?>
			วันที่เบิกจ่ายสินค้า  :<input type="date" name="date_disburse" value = "<?php echo $rs['date_disburse']; ?>" style="width:30%;" class="w3-input"  readonly>
		<?php } ?>
		
			</div>	
		
		<div class="w3-bar w3-margin-bottom">
			<font color="red"><span>รายการแก้ไข</span></font> <textarea name="des_stock"  id="des_stock" class="w3-input" style="width:90%;" rows="2"><?php echo $rs["des_stock"]; ?></textarea>
		</div>
		
	</div>
	<div class="w3-half 2">
		<div class="w3-bar w3-half w3-margin-bottom">
			<span>วันที่</span> <input type="date" name="date_br" id="date_br" value = "<?php echo $rs["date_br"]; ?>" class="w3-input" style="width:90%;" required>
				
		<?php if ($rs["clear_book_ckk"]=='1'){ ?>
<input type="checkbox" name="clear_book_ckk" checked="checked" value="1">&nbsp; เคลียร์ใบจอง:
<?php }else{ ?>
<input type="checkbox" name="clear_book_ckk" value="1">&nbsp; เคลียร์ใบจอง:

			<?php } ?>
<input name="clear_book_no" value = "<?php echo $rs["clear_book_no"]; ?>" class="w3-input" placeholder="เลขที่" >

<?php if ($rs["clear_brn_no_ckk"]=='1'){ ?>

<input type="checkbox" name="clear_brn_no_ckk" checked="checked" value="1">&nbsp;เคลียร์ใบยืม BRN:
<?php }else{ ?>
<input type="checkbox" name="clear_brn_no_ckk" value="1">&nbsp;เคลียร์ใบยืม BRN:

	<?php }  ?>

<input name="clear_brn_no" value = "<?php echo $rs["clear_brn_no"]; ?>" class="w3-input" placeholder="เลขที่" >

<?php if ($rs["clear_brnp_no_ckk"]=='1'){ ?>

<input type="checkbox" name="clear_brnp_no_ckk" checked="checked" value="1">&nbsp;เคลียร์ใบยืม BRNP:

<?php }else{ ?>
<input type="checkbox" name="clear_brnp_no_ckk" value="1">&nbsp;เคลียร์ใบยืม BRNP:

	<?php } ?>
<input name="clear_brnp_no" value = "<?php echo $rs["clear_brnp_no"]; ?>" class="w3-input" placeholder="เลขที่" >

<?php if ($rs["sn_ckk"]=='1'){ ?>

<input type="checkbox" name="sn_ckk" checked="checked" value="1">&nbsp;ต้องการ SN:
<?php }else{ ?>
<input type="checkbox" name="sn_ckk" value="1">&nbsp;ต้องการ SN:

	<?php } ?>

<input name="sn" value = "<?php echo $rs["sn"]; ?>" class="w3-input" >
		



Sale : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
	if ($_SESSION['code']=='SS1'){
	?>
<select name="sale_code" id="sale_code" style="width:330px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
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
<?php
}else 	if ($_SESSION['code']=='SS2'){

	?>
<select name="sale_code" id="sale_code" style="width:330px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
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
<?php
}else 	if ($_SESSION['code']=='MK2'){

	?>
<select name="sale_code" id="sale_code" style="width:330px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_sm1 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
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


		<?php
}else 	{
			?>
				<select name="sale_code" id="sale_code" style="width:330px" class="w3-input" >
<option value="">**Please Select**</option>


<?php

$strSQL5 = "SELECT * FROM tb_team_all ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
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


				<?php
}
			
?>



		</div>



		
		<div class="w3-bar w3-margin-bottom w3-half">
		


			<span>วัตถุประสงค์การเบิก</span>
			<div class="w3-panel">

			<?php if ($rs["objective"]=='1'){ ?>
			
			<input type="radio" onclick="javascript:object();" name="objective" value="1" checked="checked" id="object1" required> เป็นสินค้าสำรอง
<input type="text" name="objective_des1" value = "<?php echo $rs["objective_des1"]; ?>" class="w3-input" placeholder="ใส่รายละเอียด" style="width:90%;">

			<?php }else{ ?>

			<input type="radio" onclick="javascript:object();" name="objective" value="1" id="object1" required> เป็นสินค้าสำรอง

				<?php } ?>

				<div id="dt1" style="display:none">

					<input type="text" name="objective_des1" value = "<?php echo $rs["objective_des1"]; ?>" class="w3-input" placeholder="ใส่รายละเอียด" style="width:90%;">

				</div>
			</div>
			<div class="w3-panel">

						<?php if ($rs["objective"]=='2'){ ?>

			<input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2" checked="checked" required> สำหรับลูกค้าทดลองใช้
					<input type="text" name="objective_des2"  value = "<?php echo $rs["objective_des2"]; ?>" class="w3-input" placeholder="ใส่จำนวนวัน" style="width:90%;">

			<?php }else{ ?>

			<input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2" required> สำหรับลูกค้าทดลองใช้
				<?php } ?>

				<div id="dt2" style="display:none">

					<input type="text" name="objective_des2"  value = "<?php echo $rs["objective_des2"]; ?>" class="w3-input" placeholder="ใส่จำนวนวัน" style="width:90%;">

				</div>
			</div>
			<div class="w3-panel">
									<?php if ($rs["objective"]=='3'){ ?>

			<input type="radio" onclick="javascript:object();" name="objective" value="3" checked="checked" id="object3" required> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ
			<?php }else{ ?>
			<input type="radio" onclick="javascript:object();" name="objective" value="3" id="object3" required> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ

				<?php } ?>

			</div>
			<div class="w3-panel">
				<?php if ($rs["objective"]=='4'){ ?>
			<input type="radio" onclick="javascript:object();" name="objective" value="4" id="object4" checked="checked" required> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่
							<input type="text" name="objective_des4"  value = "<?php echo $rs["objective_des4"]; ?>" class="w3-input" placeholder="ใส่เลขที่ใบงานบริการ" style="width:90%;">

		<?php }else{ ?>

			<input type="radio" onclick="javascript:object();" name="objective" value="4" id="object4" required> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่
				<?php } ?>

				<div id="dt4" style="display:none">

					<input type="text" name="objective_des4"  value = "<?php echo $rs["objective_des4"]; ?>" class="w3-input" placeholder="ใส่เลขที่ใบงานบริการ" style="width:90%;">

				</div>
			</div>

			<div class="w3-panel">
			<?php if ($rs["objective"]=='6'){ ?>
			<input type="radio" onclick="javascript:object();" name="objective" value="3" checked="checked" id="object6" required> สินค้าฝากขาย (มีใบรับประกัน)
			<?php }else{ ?>
			<input type="radio" onclick="javascript:object();" name="objective" value="3" id="object6" required> สินค้าฝากขาย (มีใบรับประกัน)
			<?php } ?>


			<div class="w3-panel">
			<?php if ($rs["objective"]=='5'){ ?>
				<input type="radio" onclick="javascript:object();" name="objective" value="5" checked="checked" id="object5" required> อื่น ๆ
				<input type="text" name="objective_des5"  value = "<?php echo $rs["objective_des5"]; ?>" class="w3-input" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;">
			<?php }else{ ?>
				<input type="radio" onclick="javascript:object();" name="objective" value="5" id="object5" required> อื่น ๆ
			<?php } ?>
				<div id="dt5" style="display:none">
					<input type="text" name="objective_des5"  value = "<?php echo $rs["objective_des5"]; ?>" class="w3-input" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;">
				</div>
			</div>



		</div>

		<fieldset><legend ><b><font color="red">ส่วนของ Admin</font></b></legend></p>
<div class="w3-panel">
			เลขที่เอกสาร  : <input type="text" name="iv_no" id="iv_no" class="w3-input" value = "<?php echo $rs["iv_no"]; ?>" style="width:90%;"  required>
</div>

<div class="w3-panel">
			วันที่ออกเอกสาร : <input type="date" name="iv_date" id="iv_date" class="w3-input" value = "<?php echo $rs["iv_date"]; ?>" style="width:90%;"  required>
</div>

<div class="w3-panel">
			เลขที่ลงงาน : <input type="text" name="job_no" id="job_no" class="w3-input" value = "<?php echo $rs["job_no"]; ?>" style="width:90%;"  >
</div>

<div class="w3-panel">
			ฝากสินค้าเลขที่ : <input type="text" name="dep_no" id="dep_no" class="w3-input" value = "<?php echo $rs["dep_no"]; ?>" style="width:90%;"  >
</div>

</fieldset>
		
	</div>
 &nbsp;&nbsp;&nbsp;<input type="checkbox" name="ckk_1" id="ckk_1" onClick="ck_1();" value="1"/>ใบปะหน้ากล่อง<br/>
<div id="frm_txt_1" style="display:none;">

			<div class="w3-bar w3-half 1">
				<a href="report_h99std.php?ref_id=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_h99std_k.php?ref_id=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
	
			<div class="w3-bar w3-half 2">
				<a href="report_ha5ptl.php?ref_id=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ptl</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_ha5ptl_k.php?ref_id=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ptl+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_ha4ptl.php?ref_id=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ptl</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_ha4ptl_k.php?ref_id=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ptl+k</font></a>
			</div>
		<div class="w3-bar w3-half 4">
				<a href="report_ha5nbm.php?ref_id=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 4">
				<a href="report_ha5nbm_k.php?ref_id=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a>
			</div>
			<div class="w3-bar w3-half 5">
				<a href="report_ha4nbm.php?ref_id=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 5">
				<a href="report_ha4nbm_k.php?ref_id=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a>
			</div>
		</div><!-- first right half -->

	</p>
	</p>
	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
    <a class="w3-bar-item w3-button" onclick="openCity1('rt')"><font color="#404040"><b>การรับสินค้า</b></font></a>

</div>
<div id="rt" class="w3-container city1" style="display:none">
<div class="w3-bar w3-margin-bottom"></div>
	<div class="w3-half 4 w3-container w3-pale-red">
		<div id="return">

						<?php if ($rs["returns"]=='1'){ ?>

					<input type="checkbox" name="returns" checked="checked" value="1"> <span>รับคืนสินค้า</span>
					<?php }else{ ?>
					<input type="checkbox" name="returns" value="1"> <span>รับคืนสินค้า</span>

						<?php } ?>
			</div>
			<div class="w3-bar w3-half w3-margi-bottom">
				รับคืนสินค้า
				<input type="text" name="returns_name" value = "<?php echo $rs["returns_name"]; ?>" class="w3-input" style="width:90%;">
			</div>
			<div class="w3-bar w3-half w3-margi-bottom">
				วันที่รับคืน
				<input type="date" name="returns_date" value = "<?php echo $rs["returns_date"]; ?>" class="w3-input" style="width:90%;">
			</div>
			
			<div class="w3-bar w3-half w3-margi-bottom">
				เวลารับคืน
				<input type="text" name="returns_time" value = "<?php echo $rs["returns_time"]; ?>" class="w3-input" style="width:90%;">
			</div>
			<div class="w3-bar w3-half w3-margin-bottom">
				<span>ชื่อผู้ติดต่อ/เบอร์โทร</span> <input type="text" value = "<?php echo $rs["returns_contact"]; ?>" name="return_contact" class="w3-input" style="width:90%;">
			</div>
			<div class="w3-bar w3-margin-bottom">
				<span>Ward/ตึก/ชั้น</span> <textarea name="returns_address" class="w3-input" style="width:95%;"><?php echo $rs["returns_address"]; ?></textarea>
			</div>
			
		</div>

</div>

<div id="pd" class="w3-container city1">

<?php /*
<table width="100%" border="0" class="w3-table">
<thead>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
  	<th>หมายเหตุ</th>
	<th>หมายเลขเครื่อง</th>


</thead>
<tbody>
<?php




$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<tr>
<td style="width:15%;">

<input type="hidden" name="id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id']; ?>">

<input type="hidden" name="product_id[]<?php echo $objResult1["id"];?>" id="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

<input type='text' name ="product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["access_code"];?>" id ="product_code[]<?php echo $objResult1["id"];?>"    class="w3-input" OnChange="JavaScript:doCallAjax('product_code[]<?php echo $objResult1["id"];?>','product_id[]<?php echo $objResult1["id"];?>','product_name[]<?php echo $objResult1["id"];?>','unit_name[]<?php echo $objResult1["id"];?>');"/></td>

<td  style="width:15%;">
<textarea name = "product_name[]<?php echo $objResult1["id"];?>"   id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly><?php echo $objResult1["access_name"];?></textarea></td>	
	
<td style="width:8%;"><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    readonly/></td>

<td style="width:8%;"><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    readonly/></td>


<td style="width:15%;">

<textarea name = "stock_remark[]<?php echo $objResult1["id"];?>"  id = "stock_remark[]<?php echo $objResult1["id"];?>"  class="w3-input" /><?php echo $objResult1["stock_remark"];?></textarea>

</td>

<td style="width:20%;">

<textarea name = "sn[]<?php echo $objResult1["id"];?>"  id = "sn[]<?php echo $objResult1["id"];?>"  class="w3-input" /><?php echo $objResult1["sn"];?></textarea>

</td>

</tr>



<?php
	$i++;
	}
?>
</tbody>
</table>

*/ ?>
	
	<?php include "product_brstock.php"; ?>





</div>
<div id="cs" class="w3-container city1" style="display:none">

<?php if($rs["delivery_type"]=='1'){ ?>

<input type="radio" name="delivery_type" value="1"  checked="checked" id="delivery_type" >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"   id="delivery_type" >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"   id="delivery_type" >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"   id="delivery_type" >&nbsp;บริษัทจัดส่ง <br />

<?php }else if ($rs["delivery_type"]=='2'){ ?>

<input type="radio" name="delivery_type" value="1"   id="delivery_type" >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  checked="checked"   id="delivery_type" >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"   id="delivery_type" >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"   id="delivery_type" >&nbsp;บริษัทจัดส่ง <br />


<?php }else if ($rs["delivery_type"]=='3'){ ?>

<input type="radio" name="delivery_type" value="1"   id="delivery_type" >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"   id="delivery_type" >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"   checked="checked"  id="delivery_type" >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"   id="delivery_type" >&nbsp;บริษัทจัดส่ง <br />


<?php }else if ($rs["delivery_type"]=='4'){ ?>

<input type="radio" name="delivery_type" value="1"   id="delivery_type" >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"   id="delivery_type" >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"   id="delivery_type" >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"  checked="checked"   id="delivery_type" >&nbsp;บริษัทจัดส่ง <br />


	<?php } ?>


</p>




	<?php
		$sql1 = "select * from tb_register_data where ref_id = '".$rs["ref_id_br"]."'";
				$query1 = mysqli_query($conn,$sql1);
				$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
	?>

 วันที่ รับ-ส่ง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="start_date" type='date' id="start_date" value="<?php echo $fetch1["start_date"]; ?>"  class="button4" style="width:20%" /></p>
status_admin

วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="button4" type='text'  value="<?php echo $fetch1["between_date"]; ?>" id="between_date" style="width:20%" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เวลา :&nbsp;&nbsp;&nbsp;&nbsp;
<input id="start_time"  name="start_time"  value="<?php echo $fetch1["start_time"]; ?>" class="button4" type="text" style="width:10%"/>
ถึง
<input id="end_time" name="end_time"  value="<?php echo $fetch1["end_time"]; ?>"  class="button4" type="text" style="width:10%"/></p>



สถานะการทำงาน : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='radio'  name='status' id = 'status' value='ส่ง' checked='checked'/>ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
สถานะ :&nbsp;&nbsp;
      <input name="status_comment" type='text' id="status_comment" value="<?php echo $fetch1["status_comment"]; ?>"  style="width:22%" class="button4"/></p>

<?php if($fetch1["fix_date"]=='1'){ ?>

<input type="checkbox"  name="fix_datetime" checked='checked' id = "fix_datetime" value="1">นัดวันและเวลาเรียบร้อยแล้ว &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php }else{ ?>

<input type="checkbox"  name="fix_datetime" id = "fix_datetime" value="1">นัดวันและเวลาเรียบร้อยแล้ว &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	<?php }
	
	if($fetch1["no_price"]=='1'){
	?>

<input type="checkbox"  id = "no_money" checked='checked' name="no_money" value="1">ไม่ต้องเก็บเงิน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php }else{ ?>
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	<?php } 
	if($fetch1["call_customer"]=='1'){
		?>

<input type="checkbox" checked='checked' id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
<?php }else{ ?>

<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป

	<?php } 
	if($fetch1["call_employee"]=='1'){
	?>
		
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id = "call_back" checked='checked' name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php }else{ ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id = "call_back"  name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	<?php } 
	
		if($fetch1["want_bus"]=='1'){

	?>


<input type="checkbox" checked='checked'  name="want_bus" value="1">ต้องการรถใหญ่</p>
<?php }else{ ?>

<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่</p>

	<?php } 
	if($fetch1["cash"]=='1'){
	?>
	
<input type="checkbox" checked='checked'  name="cash"id = "cash"  value="1">เก็บเงินสด : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php }else { ?>

<input type="checkbox"  name="cash"id = "cash"  value="1">เก็บเงินสด : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	<?php } ?>
		 <input name="unit_cash" type='text' class="button4" id="unit_cash" size="20" value="<?php echo $fetch1["price"]; ?>"  rows="1" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)">  
		
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php 	if($fetch1["check_peper"]=='1'){ ?>

	<input type="checkbox"  name="check_paper" checked='checked' id = "check_paper" value="1">รับเช็ค : &nbsp;
<?php }else{ ?>
	<input type="checkbox"  name="check_paper" id = "check_paper" value="1">รับเช็ค : &nbsp;

	<?php } ?>

	<input name="unit_check" type='text' class="button4" value="<?php echo $fetch1["unit_check"]; ?>"  id="unit_check" style="color:black;text-align:right" size="20" OnChange="JavaScript:chkNum(this)"/></p>
		
<?php if($fetch1["credit"]=='1'){ ?>
<input type="checkbox"  id = "credit_card" name="credit_card" checked='checked' value="1">รูดการ์ด :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php }else{ ?>
<input type="checkbox"  id = "credit_card" name="credit_card" value="1">รูดการ์ด :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php } ?>
	
	<input name="unit_credit" type='text' class="button4" value="<?php echo $fetch1["unit_credit"]; ?>"  id="unit_credit"  size="20" style="color:black;text-align:right"  OnChange="JavaScript:chkNum(this)"/> 
	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php if($fetch1["bill"]=='1'){  ?>
<input type="checkbox"  checked='checked' id = "bill" name="bill" value="1">วางบิล : &nbsp;
<?php }else{ ?>
<input type="checkbox"  id = "bill" name="bill" value="1">วางบิล : &nbsp;

	<?php } ?>

<input name="unit_bill" type='text' class="button4" style="color:black;text-align:right" id="unit_bill" value="<?php echo $fetch1["unit_bill"]; ?>"  size="20" OnChange="JavaScript:chkNum(this)" /></p>

<?php  if($fetch1["tran"]=='1'){ ?>

<input type="checkbox"  name="tran"id = "tran" checked='checked' value="1">ลูกค้าโอนเงินหน้างาน :
<?php }else{ ?>
<input type="checkbox"  name="tran"id = "tran"  value="1">ลูกค้าโอนเงินหน้างาน :
<?php } ?>
		 <input name="unit_tran" type='text' class="button4" id="unit_tran" value="<?php echo $fetch1["unit_tran"]; ?>"  size="20" style="color:black;text-align:right" rows="1"OnChange="JavaScript:chkNum(this)"> 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php  if($fetch1["dep"]=='1'){ ?>

<input type="checkbox" checked='checked' id = "dep" name="dep" value="1">อื่นๆ : &nbsp;&nbsp;&nbsp;
<?php }else{ ?>
<input type="checkbox"  id = "dep" name="dep" value="1">อื่นๆ : &nbsp;&nbsp;&nbsp;


	<?php } ?>

<input name="dept" type='text' class="button4" value="<?php echo $fetch1["dept"]; ?>"   id="dept"  size="20"  /></p>


แผนก - ฝ่าย :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="department_show" value="<?php echo $fetch1["department_show"]; ?>"  class="button4" type='text' id="department_show">


</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       ประเภทลูกค้า :

	   <input name="customer_typename"  value="<?php echo $fetch1["type_customer"]; ?>"  class="button4" type='text' id="customer_typename">

</p>



       หน่วยงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   	   <input name="company_name"  value="<?php echo $fetch1["type_company"]; ?>"  class="button4" type='text' id="company_name">


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       ประเภทงาน :&nbsp;&nbsp;
	   <input name="department_name" value="<?php echo $fetch1["department"]; ?>"  class="button4" type='text' id="department_name">

</p>


ชื่อผู้ติดต่อ  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name"  class="button4" type='text' value="<?php echo $fetch1["customer_name"]; ?>" id="customer_name">

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 ผู้รับสินค้า :&nbsp;&nbsp;
<input name="customer_contact" value="<?php echo $fetch1["customer_contact"]; ?>"  class="button4" type='text' id="customer_contact">


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า :
<input name="customer_tel" value="<?php echo $fetch1["customer_tel"]; ?>"  class="button4" type='text' id="customer_tel" >
</p>
ชื่อพนักงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="employee_name" value="<?php echo $fetch1["employee_name"]; ?>" class="button4" type='text' value="<?php echo $_SESSION['name']; ?>" id="employee_name" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรพนักงาน :&nbsp;
<input name="employee_tel" value="<?php echo $fetch1["employee_tel"]; ?>" class="button4" type='text' id="employee_tel" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 ผู้ลงงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="add_by" value="<?php echo $fetch1["add_by"]; ?>" type='text' class="button4" >


</p>
ชื่อโรงพยาบาล :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='text' value="<?php echo $fetch1["address_name"]; ?>" class="button4" name="address_name" style="width:30%" >             


</p>

  ที่อยู่ :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<textarea   class="button4" name="address_send"  style="width:30%" rows="2"><?php echo $fetch1["address_send"]; ?></textarea>
</p>
เลขที่เอกสาร/เลขที่เครื่อง : 
<textarea name="product_sn"  class="button4" id="product_sn" style="width:30%" rows="2"><?php echo $fetch1["product_sn"]; ?></textarea>
</p>
สินค้า/เอกสาร :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<textarea name="product"  class="button4" id="product" style="width:30%" rows="2"><?php echo $fetch1["product_name"]; ?></textarea>


</p>
รายละเอียดเพิ่มเติม :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
     <textarea name="description"  class="button4" id="description" style="width:30%" rows="2"><?php echo $fetch1["description"]; ?></textarea>





</div><!-- cs -->

	<div class="w3-bar w3-center">
		<?php if($_SESSION['code']=='ST' and $rs["status_doc"]=="Approve"){ ?>	
		
		<input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='register_stockbrhos1.php'; submit()" >
<?php } ?>
		
	</div><br>
	</div>
	</form>
</div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		


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
		return "data_customerbr.php?customer_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("customer_id","h_customer");
        </script>


        
		<script>
$('#more').click(function() {
  if($(this).is(":checked")){
   $("#more-2").show();
  }
  else{
   $("#more-2").hide();
  }
});
</script>