<?php include('head.php'); ?>
<?php include('dbconnect_sale.php'); ?>
<?php include "dateselect.php"; ?>
<link href="css/form_style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">

var HttPRequest = false;
function doCallAjax1(customer_id,customer,address) {
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
var url = 'data_customerbr1.php';
var pmeters = "customer_id=" + encodeURI( document.getElementById(customer_id).value);
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

document.getElementById(customer).value = myArr[0];
document.getElementById(address).value = myArr[1];

}
}
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

<?php

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


$ref_id_br =$_GET["ref_id_br"];

$sql = "SELECT *   FROM in__br where ref_id_br ='".$ref_id_br."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$sql23 = "SELECT *   FROM tb_other_bill where ref_id = '".$ref_id_br."'";
$qry23 = mysqli_query($conn,$sql23) or die(mysqli_error());
$rs23 = mysqli_fetch_assoc($qry23);


$strSQL1 = "SELECT * FROM  (in__subbr LEFT JOIN tb_product ON in__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$ref_id_br."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);



	 ?>

<div class="w3-white w3-container">
	<div class="w3-panel w3-light-grey">
	
	<div class="w3-half">
	<h3>Edit Borrow Order</h3>
	</div>

<div class="w3-half">

<?php if ($rs["type_breng"]=='0'){ ?>	
<a href="breng_approve_breq.php?ref_id_br=<?php echo $rs["ref_id_br"];?>&que_ckk=<?php echo $rs["que_ckk"];?>&customer=<?php echo $rs["customer"];?>&approve_name=<?php echo $_SESSION['name']; ?>&sale_code=<?php echo $_SESSION['code']; ?>" class="w3-button w3-green "><font color="330066">Approve</font></a>	
<?php }else if($rs["type_breng"]=='1' or $rs["type_breng"]=='2'){ ?>

<a href="breng_approve_breq.php?ref_id_br=<?php echo $rs["ref_id_br"];?>&que_ckk=<?php echo $rs["que_ckk"];?>&customer=<?php echo $rs["customer"];?>&approve_name=<?php echo $_SESSION['name']; ?>&sale_code=<?php echo $_SESSION['code']; ?>&company=<?php echo $rs["company"];?>&type_breng=<?php echo $rs["type_breng"];?>&iv_no=<?php echo $rs["iv_no"];?>" class="w3-button w3-green "><font color="330066">Approve</font></a>
<?php } ?>	
	
	
	
<a href="brhos_rejected_breq.php?ref_id_br=<?php echo $rs["ref_id_br"];?>" class="w3-button w3-red "><font color="330066">Rejected</font></a>
				
				
<a href="report_loanhosptl1_breq.php?ref_id_br=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Purple">แบบฟอร์มใบยืม</font></a><br />

				</div>



	</div>
	<form action="register_supbrhos_approve1_breq.php" method="post" name="frmMain" enctype="multipart/form-data">
<div class="w3-bar">

	<?php if ($rs["company"]=='1'){ ?>
		<input type="radio" name="company" value="1" checked='checked' required>ใบยืม AWL
		<input type="radio" name="company" value="2" required> ใบยืม NBM
		<?php  }else if($rs["company"]=='2'){ ?>

		<input type="radio" name="company" value="1"  required>ใบยืม AWL
		<input type="radio" name="company" value="2" checked='checked' required> ใบยืม NBM


		<?php } ?>
		
<br>

		
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $rs["ref_id_br"]; ?></span>
		<input type="hidden" name="ref_id_br" class="w3-input" value="<?php echo $rs["ref_id_br"]; ?>">
	</div>
	
	<div class="w3-bar w3-padding-small"></div><!-- bar -->
	<div class="w3-half 1">

		<?php if ($rs["que_ckk"]=='1'){ ?>
		<input type="checkbox" name="que_ckk" id="que_ckk" value="1" checked='checked' ><font color='red' > งานด่วน </font>
		<?php  }else{ ?>

		<input type="checkbox" name="que_ckk" id="que_ckk" value="1" ><font color='red' > งานด่วน </font>


		<?php } ?>
		
		
		<div class="w3-bar w3-margin-bottom">
			<!-- <span>รหัสลูกค้า</span> --><input style="display:none;" type="text" name="customer_id" id="customer_id" value = "<?php echo $rs["customer_id"]; ?>" class="w3-input" style="width:90%;"  OnChange="JavaScript:doCallAjax1('customer_id','customer','address');"  placeholder="Search ชื่อลูกค้า..." >
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
		
		</p>

&nbsp;ต้องการเอกสารแนบบิล<br>
<?php if($rs23["ref_1"]=='1'){ ?>
<input type="checkbox" name="ref_1"  checked='checked' id="ref_1" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_1"  id="ref_1" value="1"> 
<?php } ?>
&nbsp;เตรียมเอกสาร N-Health&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php if($rs23["ref_2"]=='1'){ ?>
<input type="checkbox" name="ref_2"  checked='checked' id="ref_2" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_2"  id="ref_2" value="1"> 
<?php } ?>

&nbsp;เตรียมเอกสารตามสเปคใบเสนอราคา&nbsp;&nbsp;&nbsp;

<?php if($rs23["ref_3"]=='1'){ ?>
<input type="checkbox" name="ref_3"  checked='checked' id="ref_3" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_3"  id="ref_3" value="1"> 
<?php } ?>

&nbsp;ใบ อย.&nbsp;&nbsp;&nbsp;<br>

<?php if($rs23["ref_4"]=='1'){ ?>
<input type="checkbox" name="ref_4"  checked='checked' id="ref_4" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_4"  id="ref_4" value="1"> 
<?php } ?>

&nbsp;ใบตัวแทนจำหน่าย&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($rs23["ref_5"]=='1'){ ?>
<input type="checkbox" name="ref_5"  checked='checked' id="ref_5" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_5"  id="ref_5" value="1"> 
<?php } ?>
&nbsp;ใบช่างอบรม&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($rs23["ref_6"]=='1'){ ?>
<input type="checkbox" name="ref_6"  checked='checked' id="ref_6" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_6"  id="ref_6" value="1"> 
<?php } ?>
&nbsp;ใบนำเข้าสินค้า&nbsp;&nbsp;&nbsp;<br>

<?php if($rs23["ref_7"]=='1'){ ?>
<input type="checkbox" name="ref_7"  checked='checked' id="ref_7" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_7"  id="ref_7" value="1"> 
<?php } ?>

&nbsp;ใบ CER เครื่องมือที่ใช้ทดสอบ&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($rs23["ref_8"]=='1'){ ?>
<input type="checkbox" name="ref_8"  checked='checked' id="ref_8" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_8"  id="ref_8" value="1"> 
<?php } ?>
&nbsp;ใบ PM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($rs23["ref_9"]=='1'){ ?>
<input type="checkbox" name="ref_9"  checked='checked' id="ref_9" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_9"  id="ref_9" value="1"> 
<?php } ?>
&nbsp;ใบ CAL&nbsp;&nbsp;&nbsp;<br>
<?php if($rs23["ref_11"]=='1'){ ?>
<input type="checkbox" name="ref_11"  checked='checked' id="ref_11" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_11"  id="ref_11" value="1"> 
<?php } ?>
&nbsp;ใบประเมินสินค้า&nbsp;จำนวน&nbsp;&nbsp;
<input name="ref_11des" id="ref_11des"  value="<?php echo $rs23["ref_11des"]; ?>"  class="button4" style="width:30%">


<?php if($rs23["ref_10"]=='1'){ ?>
<input type="checkbox" name="ref_10"  checked='checked' id="ref_10" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="ref_10"  id="ref_10" value="1"> 
<?php } ?>
&nbsp;อื่น ๆ&nbsp;&nbsp;&nbsp;&nbsp;
<input name="ref_des" id="ref_des" value="<?php echo $rs23["ref_des"]; ?>" class="button4" style="width:30%">
</p>

		
	</div>
	<div class="w3-half 2">
		<div class="w3-bar w3-half w3-margin-bottom">
			<span>วันที่</span> <input type="date" name="date_br" id="date_br" value = "<?php echo $rs["date_br"]; ?>" class="w3-input" style="width:90%;" required>
			<span>เลขที่ใบสั่งซื้อ PO</span> <input type="text" name="po_no" id="po_no" value = "<?php echo $rs["po_no"]; ?>" class="w3-input" style="width:90%;" readonly>
				
		</p>
<?php if ($rs["sn_ckk"]=='1'){ ?>

<input type="checkbox" name="sn_ckk" checked="checked" value="1">&nbsp;ต้องการ SN:
<?php }else{ ?>
<input type="checkbox" name="sn_ckk" value="1">&nbsp;ต้องการ SN:

	<?php } ?>

<input name="sn" value = "<?php echo $rs["sn"]; ?>" class="w3-input" >
		
เลขที่ CM 
<input name="cm_no" id ="cm_no" value = "<?php echo $rs["cm_no"]; ?>" class="w3-input" >


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
}else 	if ($_SESSION['code']=='SUP_EN'){

	?>
<select name="sale_code" id="sale_code" style="width:330px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
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
		</p>
		
		<?php if($_SESSION['type_login']=='Admin'){ ?>
		<span>Sale name</span> <input type="text" name="add_by" id="add_by" value = "<?php echo $rs["add_by"]; ?>" class="w3-input" style="width:90%;" required></p>
	<?php } ?>
แนบไฟล์  :</p>
<input type='hidden' name='slip1' id='slip1' value ="<?php echo $rs['slip1']; ?>"  />
<input type='hidden' name='slip2' id='slip2' value ="<?php echo $rs['slip2']; ?>"  />
<input type='hidden' name='slip3' id='slip3' value ="<?php echo $rs['slip3']; ?>"  />
<input type='hidden' name='slip4' id='slip4' value ="<?php echo $rs['slip4']; ?>"  />
<input type='hidden' name='slip5' id='slip5' value ="<?php echo $rs['slip5']; ?>"  />

<input name="slip1"  type="file"><a href="upload/<?php echo $rs['slip1']; ?>" target="_blank"><?php echo $rs['slip1']; ?></a>


</p>

<input name="slip2"  type="file"><a href="upload/<?php echo $rs['slip2']; ?>" target="_blank"><?php echo $rs['slip2']; ?></a>

</p>
<input name="slip3"  type="file"><a href="upload/<?php echo $rs['slip3']; ?>" target="_blank"><?php echo $rs['slip3']; ?></a>

</p>
<input name="slip4"  type="file"><a href="upload/<?php echo $rs['slip4']; ?>" target="_blank"><?php echo $rs['slip4']; ?></a>

</p>
<input name="slip5"  type="file"><a href="upload/<?php echo $rs['slip5']; ?>" target="_blank"><?php echo $rs['slip5']; ?></a>

</p>


		</div>



		
		<div class="w3-bar w3-margin-bottom w3-half">
		


			<span>วัตถุประสงค์การเบิก</span>
			<div class="w3-panel">

			<?php if ($rs["objective"]=='1'){ ?>
			
			<input type="radio" onclick="javascript:object();" name="objective" value="1" checked="checked" id="object1" required> เป็นสินค้าสำรอง
<input type="text" name="objective_des1" value = "<?php echo $rs["objective_des1"]; ?>" class="w3-input" placeholder="ใส่รายละเอียด" style="width:90%;">

			<?php }else{ ?>

			<input type="radio" onclick="javascript:object();" name="objective" value="1" id="object1" required> เป็นสินค้าสำรอง

				<?php }

				/*<div id="dt1" style="display:none">

					<input type="text" name="objective_des1" value = "<?php echo $rs["objective_des1"]; ?>" class="w3-input" placeholder="ใส่รายละเอียด" style="width:90%;">

				</div> */ ?>
			</div>
			<div class="w3-panel">

						<?php if ($rs["objective"]=='2'){ ?>

			<input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2" checked="checked" required> สำหรับลูกค้าทดลองใช้
					<input type="text" name="objective_des2"  value = "<?php echo $rs["objective_des2"]; ?>" class="w3-input" placeholder="ใส่จำนวนวัน" style="width:90%;">

			<?php }else{ ?>

			<input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2" required> สำหรับลูกค้าทดลองใช้
				<?php } 

				/*<div id="dt2" style="display:none">

					<input type="text" name="objective_des2"  value = "<?php echo $rs["objective_des2"]; ?>" class="w3-input" placeholder="ใส่จำนวนวัน" style="width:90%;">

				</div>*/  ?>
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
				<input type="radio" onclick="javascript:object();" name="objective" value="6" checked="checked" id="object6" required> 
				<?php }else{ ?>
				<input type="radio" onclick="javascript:object();" name="objective" value="6" id="object6" required> 
				<?php } ?>
				สินค้าฝากขาย (มีใบรับประกัน)</div>
			<div class="w3-panel">

				<?php if ($rs["objective"]=='5'){ ?>

			<input type="radio" onclick="javascript:object();" name="objective" value="5" checked="checked" id="object5" required> อื่น ๆ
								<input type="text" name="objective_des5"  value = "<?php echo $rs["objective_des5"]; ?>" class="w3-input" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;">

			<?php }else{ ?>
			<input type="radio" onclick="javascript:object();" name="objective" value="5" id="object5" required> อื่น ๆ

				<?php } 

				/*<div id="dt5" style="display:none">

					<input type="text" name="objective_des5"  value = "<?php echo $rs["objective_des5"]; ?>" class="w3-input" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;">

				</div>*/ ?>
			
			</div>
		</div>
		
	</div>
	</p>
	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>

</div>


<div id="pd" class="w3-container city1">


<table width="100%" border="0" class="w3-table">
<thead>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>ราคาต่อหน่วย</th>
    <th>ยอดรวม</th>
	<th>หมายเหตุ</th>

</thead>
<tbody>
<?php




$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<tr>
<td style="width:10%;">

<input type="hidden" name="id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id']; ?>">

<input type="hidden" name="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

<input type='text' name ="product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["access_code"];?>" id ="product_code[]<?php echo $objResult1["id"];?>"  size="7"  class="button4" OnChange="JavaScript:doCallAjax('product_code[]<?php echo $objResult1["id"];?>','product_name[]<?php echo $objResult1["id"];?>','unit_name[]<?php echo $objResult1["id"];?>','product_price[]<?php echo $objResult1["id"];?>','discount_unit[]<?php echo $objResult1["id"];?>');"/></td>

<td  style="width:12%;">
<textarea name = "product_name[]<?php echo $objResult1["id"];?>"   id = "product_name[]<?php echo $objResult1["id"];?>"  class="button4" readonly><?php echo $objResult1["sol_name"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    /></td>

<td style="width:10%;"><input type='text' name = "product_price[]<?php echo $objResult1["id"];?>" value="<?php  $price=$objResult1["price"]; echo number_format( $price,2)."";?>" id = "product_price[]<?php echo $objResult1["id"];?>"  class="button4"  style="color:black;text-align:right"  size="10"  /></td>


<td style="width:10%;">
<input type='text' name = "sum_amount[]<?php echo $objResult1["id"];?>" value="<?php  $sum_amount=$objResult1["amount"]; echo number_format( $sum_amount,2)."";?>"  id = "sum_amount[]<?php echo $objResult1["id"];?>" size="10" class="button4" style="color:black;text-align:right"   />


</td>

<td style="width:20%;">

<input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input" />

</td>

<td style="width:2%;">
<!-- <a href="producthos_brdelete.php?ref_id_br=<?php echo $rs["ref_id_br"];?>&id=<?php echo $objResult1["id"];?>&code=<?php echo $_SESSION["type_login"]; ?>"><img src="img/false.png" width="16" height="16" border="0" /></a> -->
</td>

</tr>
<?php
	$i++;
	}
?>
</tbody>
</table>
<?php include ('detail_brhos_edit.php')?>
</div>


	<br>
<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึก">
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