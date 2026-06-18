<?php include('head.php');
?>
<?php include('dbconnect_sale.php'); ?>

<script language="JavaScript">

var HttPRequest = false;
function doCallAjax1(customer_id,customer,address,customer_typename) {
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
document.getElementById(customer_typename).value = myArr[2];
}
}
}
}

    
</script>




<script>
	
function ck_1(){
var ck_1 = document.getElementById('ckk_1');
if(ck_1.checked == true){
document.getElementById('frm_txt_1').style.display = "";
}else{
document.getElementById('frm_txt_1').style.display = "none";
}

}
	
	
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
		}else if (document.getElementById('object6').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';	
			
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

$sql23 = "SELECT *   FROM tb_other_bill where ref_id = '".$ref_id_br."'";
$qry23 = mysqli_query($conn,$sql23) or die(mysqli_error());
$rs23 = mysqli_fetch_assoc($qry23);


$strSQL1 = "SELECT * FROM  (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$ref_id_br."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL3 = "SELECT * FROM  tb_product_checklist WHERE ref_id = '".$ref_id_br."' ";
$objQ1 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");


	 ?>

<div class="w3-white w3-container">
	<div class="w3-panel w3-light-grey">
	
	<div class="w3-half">
	<h3>Edit Borrow Order</h3>
	</div>

<div class="w3-half">


<?php if($rs["send_admin"] =='1' ){	?> 
		
<a href="report_loanhos.php?ref_id_br=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">Print ใบยืมต่อเนื่อง</font></a>
	
	
<a href="report_brnphos_awl.php?ref_id_br=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-yellow w3-right"><font color="Blue">Print ใบยืมต่อเนื่อง</font></a>	

<?php
if ($rs["company"]=='1'){

?>
		
<a href="report_loanhosptl.php?ref_id_br=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">ใบยืม AWL</font></a><br />


<?php
}else if ($rs["company"]=='2'){

?>
 


<a href="report_loanhosnbm.php?ref_id_br=<?php echo $rs["ref_id_br"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="DeepPink">ใบยืม NBM</font></a>
<?php

}
								  }
?>

				</div>



	</div>
<form action="register_adminbrhos_edit1.php" method="post" name="frmMain" enctype="multipart/form-data"  onSubmit="JavaScript:return fncSubmit();" >
		
<script language="javascript">
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
	if(document.frmMain.payment.value != "")
	{
		if(document.frmMain.payment.value == "7")
	{
	
		if(document.frmMain.date_tranfer.value == ""){
			
		alert('กรุณาใส่วันที่โอน');
		document.frmMain.date_tranfer.focus();
		return false;
		}
	}	
	}
	
	if(document.frmMain.h_employee_name.value == ""){
		alert('กรุณาเลือกชื่อพนักงาน');
		document.frmMain.employee_name.focus();
		return false;
		}

	document.frmMain.submit();
}


</script>
		
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
<?php if ($rs["que_ckk"]=='1'){ ?>
<input type="checkbox" name="que_ckk" id="que_ckk" value="1" checked='checked' ><font color='red' > งานด่วน </font>
		<?php  }else{ ?>
	<input type="checkbox" name="que_ckk" id="que_ckk" value="1" ><font color='red' > งานด่วน </font>	
		<?php } ?>
			
		
		<div class="w3-bar w3-margin-bottom">
			<span>รหัสลูกค้า</span> <input type="text" name="customer_id" id="customer_id" value = "<?php echo $rs["customer_id"]; ?>" class="w3-input" style="width:90%;"  OnChange="JavaScript:doCallAjax1('customer_id','customer','address','customer_typename');"  placeholder="Search ชื่อลูกค้า..." >
			<input type ='hidden' name="h_customer"  id="h_customer" class="w3-input" >

		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ชื่อลูกค้า/รพ.</span> <input type="text" name="customer" id="customer"  value = "<?php echo $rs["customer"]; ?>" class="w3-input" style="width:90%;"  required>

		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ที่อยู่</span> <textarea name="address" id="address"   class="w3-input" style="width:90%;" rows="2"><?php echo $rs["address"]; ?></textarea>
		</div>
		<?php 
		$strSQL8 = "SELECT h_ckk,brun_no FROM tb_customer WHERE customer_id  = '".$rs["customer_id"]."' ";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);
		?>
		<div class="w3-bar w3-margin-bottom">
			<?php if($objResult8["h_ckk"]=='1'){ ?>
<input type="radio" name="h_ckk" id='h_ckk' checked='checked' value ='1'  readonly>
<?php }else{ ?>
<input type="radio" name="h_ckk" id='h_ckk' value ='1'  readonly>
<?php } ?>
สำนักงานใหญ่
<?php if($objResult8["h_ckk"]=='2'){ ?>
<input type="radio" name="h_ckk" id='h_ckk' checked='checked' value ='2'  readonly>
<?php }else{ ?>
<input type="radio" name="h_ckk" id='h_ckk' value ='2'  readonly>
<?php } ?>

สาขา เลขที่	<input name="brun_no" class="w3-input" value="<?php echo $objResult8["brun_no"]; ?>" style="width:90%;" readonly>
			</div>

		<div class="w3-bar w3-margin-bottom">
			<span>Sale Comment</span> <textarea name="sale_comment"  id="sale_comment" class="w3-input" style="width:90%;" rows="2"><?php echo $rs["sale_comment"]; ?></textarea>
			
		</div>
		<div class="w3-bar w3-margin-bottom">
	<?php if ($rs['send_brdoc']=='2'){ ?>
	<input type="checkbox" name="send_brdoc" checked='checked' value="2">&nbsp;ส่งข้อมูลไปรับจ่ายใบยืม

	<?php }else{ ?>

	<input type="checkbox" name="send_brdoc" value="1">&nbsp;ส่งข้อมูลไปรับจ่ายใบยืม 

		<?php
	} 
		?></div>
		<div class="w3-bar w3-margin-bottom">
		<input type="checkbox" name="send_edit"  value="1" > ส่งข้อมูลแก้ไขให้ Stock &nbsp;&nbsp;&nbsp; 
<textarea  name = "des_stock"  id = "des_stock" style="width:50%;" rows="2" class="button4" ><?php echo $rs["des_stock"];?></textarea>
				</div>
		<div class="w3-bar w3-margin-bottom">

<?php if($rs["stock_print"]==""){ ?>
<input type='hidden'  name = "line_stock"  id = "line_stock"  class="button4"   >
<?php }else{  ?>
<font color="red">หมายเหตุการแก้ไข (เนื่องจาก Stock ปริ้นเอกสารแล้ว)</font></p>
<textarea  name = "line_stock"  id = "line_stock" style="width:30%;" rows="2" class="button4"  required ></textarea>
<?php } ?>
				
		</div>
		
	</p>

&nbsp;ต้องการเอกสารแนบบิล<br>
<?php if($rs23["head_1"]=='1'){ ?>
<input type="checkbox" name="head_1"  checked='checked' id="head_1" value="1" > 
<?php }else{ ?>
<input type="checkbox" name="head_1"  id="head_1" value="1" > 
<?php } ?>
&nbsp;Admin เตรียมเอกสาร
<br>	
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
		
เลขที่ CM 
<input name="cm_no" id ="cm_no" value = "<?php echo $rs["cm_no"]; ?>" class="w3-input" >


Sale : 

<select name="sale_code" id="sale_code" style="width:280px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_adm ORDER BY sale_code ASC";
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
			ชื่อ Sale :
			 <input type="text" name="sale" id="sale"  value = "<?php echo $rs["sale"]; ?>" class="w3-input" style="width:80%;">
</p>
		
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

				<?php } ?>

				
			</div>
			<div class="w3-panel">

						<?php if ($rs["objective"]=='2'){ ?>

			<input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2" checked="checked" required> สำหรับลูกค้าทดลองใช้
					<input type="text" name="objective_des2"  value = "<?php echo $rs["objective_des2"]; ?>" class="w3-input" placeholder="ใส่จำนวนวัน" style="width:90%;">

			<?php }else{ ?>

			<input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2" required> สำหรับลูกค้าทดลองใช้
				<?php } ?>

				
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

				
			</div>
		  <div class="w3-panel">
			  <?php if ($rs["objective"]=='6'){ ?>
			  <input type="radio" onclick="javascript:object();" name="objective" checked="checked" value="6" id="object6" required> 
			  <?php }else{ ?>
			  <input type="radio" onclick="javascript:object();" name="objective" value="6" id="object6" required>  
			  <?php } ?>
			  สินค้าฝากขาย (มีใบรับประกัน)</div>
			<div class="w3-panel">
					<?php if ($rs["objective"]=='7'){ ?>
<input type="radio" onclick="javascript:object();" name="objective" value="7" id="object6" checked="checked" required> สินค้าออกบูธ
					<?php }else{ ?>
<input type="radio" onclick="javascript:object();" name="objective" value="7" id="object6" required> สินค้าออกบูธ				
					<?php } ?>
			</div>
			<div class="w3-panel">

				<?php if ($rs["objective"]=='5'){ ?>

			<input type="radio" onclick="javascript:object();" name="objective" value="5" checked="checked" id="object5" required> อื่น ๆ
								<input type="text" name="objective_des5"  value = "<?php echo $rs["objective_des5"]; ?>" class="w3-input" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;">

			<?php }else{ ?>
			<input type="radio" onclick="javascript:object();" name="objective" value="5" id="object5" required> อื่น ๆ

				<?php } ?>


				
			</div>
		</div>

		<fieldset><legend ><b><font color="red">ส่วนของ Admin</font></b></legend></p>

<?php  if($rs['iv_no']!='' and $rs['iv_no']!='BRNP'){
			}else{ ?>
	<input type="checkbox" name="run_id" value="1"> &nbsp;Run เลขที่เอกสาร <br>
<?php } ?>
<div class="w3-panel">
			เลขที่เอกสาร  : <input type="text" name="iv_no" id="iv_no" class="w3-input" value = "<?php echo $rs["iv_no"]; ?>" style="width:90%;"  required>
</div>

<div class="w3-panel">
			วันที่ออกเอกสาร : <input type="date" name="iv_date" id="iv_date" class="w3-input" value = "<?php echo $rs["iv_date"]; ?>" style="width:90%;"  required>
	
	<?php
if( $rs['iv_time']=='00:00:00'){
$iv_time = date('H:m:s');

}else{
$iv_time = $rs['iv_time'];	
}
?>

<input type="hidden" value="<?php echo $iv_time; ?>"  name="iv_time" id="iv_time" class="button4"   > 
</div>

<div class="w3-panel">
			เลขที่ลงงาน : <input type="text" name="job_no" id="job_no" class="w3-input" value = "<?php echo $rs["job_no"]; ?>" style="width:90%;"  >
</div>

<div class="w3-panel">
			ฝากสินค้าเลขที่ : <input type="text" name="dep_no" id="dep_no" class="w3-input" value = "<?php echo $rs["dep_no"]; ?>" style="width:90%;"  >
</div>

<div class="w3-panel">
<?php if($rs["status_doc"]=='ยกเลิก'){ ?>
				<input type="checkbox" name="status_doc" checked='checked' value="ยกเลิก" > ยกเลิก
				<?php }else{ ?>
				<input type="checkbox" name="status_doc" value="ยกเลิก" > ยกเลิก
	<?php } ?>
เนื่องจาก
<textarea name="remark_cancel" id="remark_cancel" class="w3-input" style="width:90%;"  ><?php echo $rs["remark_cancel"]; ?></textarea>

</div>

<!--div class="w3-panel">
	<?php if ($rs["ckkwar_pro"]=='1'){ ?>

<input type="checkbox" name="ckkwar_pro" checked='checked' value="1"> &nbsp;ไม่ต้องแสดงชื่อในใบรับประกัน
<?php }else{ ?>
<input type="checkbox" name="ckkwar_pro" value="1"> &nbsp;ไม่ต้องแสดงชื่อในใบรับประกัน

	<?php } ?>	
		</div><div class="w3-panel">
	<?php if ($rs["ckk_showwar"]=='1'){ ?>

<input type="checkbox" name="ckk_showwar" checked='checked' value="1"> &nbsp;ไม่ต้องแสดงที่อยู่บริษัทในใบรับประกัน
<?php }else{ ?>
<input type="checkbox" name="ckk_showwar" value="1"> &nbsp;ไม่ต้องแสดงที่อยู่บริษัทในใบรับประกัน

	<?php } ?>	
		</div-->
		</p>

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
	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('rt')"><font color="#404040"><b>การรับสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('pdf')"><font color="#404040"><b>ใบตรวจทานสินค้า</b></font></a>
  <a class="w3-bar-item w3-button"  onclick="openCity1('lg')"><font color="#404040"><b>ค่าจัดส่ง</b></font></a>
  <a class="w3-bar-item w3-button"  onclick="openCity1('ch3')"><font color="#404040"><b>เอกสารที่เกี่ยวข้อง</b></font></a>
</div>


<div id="lg" class="w3-container city1" style="display:none">
	<div class="w3-half">
		<div class="w3-bar">
		วันที่คีย์ค่าจัดส่ง
<input name="date_ker" class="w3-input" value="<?php echo $rs['date_ker']; ?>"  type="date" >
		</div>
		
	<div class="w3-bar">
		รหัสอ้างอิงการส่ง1
<input name="order_refer_code" class="w3-input" value="<?php echo $rs['order_refer_code']; ?>"  type="text" >
		</div>
		
		<div class="w3-bar">
		รหัสอ้างอิงการส่ง2
<input name="order_refer_code1" class="w3-input" value="<?php echo $rs['order_refer_code1']; ?>"  type="text" >
		</div>
		
		<div class="w3-bar">
		ค่าจัดส่ง
<input name="ker_bath" class="w3-input" value="<?php echo $rs['ker_bath']; ?>"  type="text" >
		</div>
		</div>
		
		
		</div>


<div id="pdf" class="w3-container city1" style="display:none">
	<?php 
	while($objR1 = mysqli_fetch_array($objQ1))
{
	echo $objR1["product_code"];	
$strSQL2 = "SELECT product_name FROM tb_product_leaflet WHERE product_id = '".$objR1["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);	
		$objR2 = mysqli_fetch_array($objQuery2);
		if($Num_Rows2 > 0){ ?>
	</p>
	<a href="report_checklist.php?product_code=<?php echo $objR1["product_id"];?>&ref_id_br=<?php echo $rs["ref_id_br"];?>&doc_no=<?php echo $objR1["doc_no"];?>&year_no=<?php echo $objR1["year_no"];?>" target="_blank" class="w3-button w3-grey" ><font color="DeepPink"><?php echo $objR2["product_name"];?></font></a>	
	</p>
	<?php
						  }
	}
	?>
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
			<?php /*<div class="w3-bar w3-half w3-margi-bottom">
				รับคืนสินค้า
				<input type="text" name="returns_name" value = "<?php echo $rs["returns_name"]; ?>" class="w3-input" style="width:90%;">
			</div>*/ ?>
			<div class="w3-bar w3-half w3-margi-bottom">
				วันที่รับคืน
				<input type="date" name="returns_date" value = "<?php echo $rs["returns_date"]; ?>" class="w3-input" style="width:90%;">
			</div>
			<div class="w3-bar w3-half w3-margin-bottom">
				<span>วันที่รับคืน ช่วงเวลา</span> <input type="text" value = "<?php echo $rs["return_date_bet"]; ?>" name="return_date_bet" class="w3-input" style="width:90%;">
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


<table width="100%" border="0" class="w3-table">
<thead>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>ราคาต่อหน่วย</th>
    <th>ยอดรวม</th>
	<th>หมายเลขเครื่อง</th>
	<th>ระยะเวลายืม</th>
	<th>หมายเหตุ</th>
	


</thead>
<tbody>
<?php

$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$product_type = $objResult1["product_type"];
if($product_type=='สินค้าสาธิต' and $rs["research_demo"]=='0'){
$save="Update   hos__br set research_demo='1'   where ref_id_br ='".$ref_id_br."'";
$qsave=mysqli_query($conn,$save);
}		
	
$strSQL2 = "SELECT product_code,count  FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) where ref_idd_br = '".$ref_id_br."' and product_code ='".$objResult1["product_code"]."' and ckk_pro='0'  and review_ckk='1'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
$objResult2 = mysqli_fetch_array($objQuery2);	

if($Num_Rows2 > 0){
	


$product_id = $objResult1["product_code"]; 
$count = str_replace('.00','',$objResult2["count"]);
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";

$strDate = date('Y-m-d');

$strYear = date("Y",strtotime($strDate))+543;
$strYear1 =substr( $strYear , 2 , 2 );

//for ($x = 0; $x <= $count; $x+=$count) {
	
$strSQL28 = "SELECT * FROM tb_product_leaflet where product_id ='".$product_id."'";
$objQuery28 = mysqli_query($conn,$strSQL28) or die ("Error Query [".$strSQL28."]");
$objResult28 = mysqli_fetch_array($objQuery28);		
	
	
$sql1 = "select * from tb_product_checklist  where head_pc='PC' order by checklist_id desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 

$doc_no = $fetch1["doc_no"]+1;

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_pc) AS MAXID FROM tb_product_checklist where head_pc='PC'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}

$so = "PC";
$ref_pc ="$so$nextId";

$save98="insert into tb_product_checkref
(product_id,ref_id,ref_pc,ingredient1,ingredient2,ingredient3,ingredient4,ingredient5,ingredient6,ingredient7,ingredient8,ingredient9,ingredient10,ingredient11,ingredient12,ingredient13,ingredient14,ingredient15,ingredient16,ingredient17,ingredient18,ingredient19,ingredient20,ingredient21,ingredient22,ingredient23,ingredient24,ingredient25,ingredient26,ingredient27,ingredient28,ingredient29)
values
('".$product_id."','".$ref_id_br."','".$ref_pc."','".$objResult28["ingredient1"]."','".$objResult28["ingredient2"]."','".$objResult28["ingredient3"]."','".$objResult28["ingredient4"]."','".$objResult28["ingredient5"]."','".$objResult28["ingredient6"]."','".$objResult28["ingredient7"]."','".$objResult28["ingredient8"]."','".$objResult28["ingredient9"]."','".$objResult28["ingredient10"]."','".$objResult28["ingredient11"]."','".$objResult28["ingredient12"]."','".$objResult28["ingredient13"]."','".$objResult28["ingredient14"]."','".$objResult28["ingredient15"]."','".$objResult28["ingredient16"]."','".$objResult28["ingredient17"]."','".$objResult28["ingredient18"]."','".$objResult28["ingredient19"]."','".$objResult28["ingredient20"]."','".$objResult28["ingredient21"]."','".$objResult28["ingredient22"]."','".$objResult28["ingredient23"]."','".$objResult28["ingredient24"]."','".$objResult28["ingredient25"]."','".$objResult28["ingredient26"]."','".$objResult28["ingredient27"]."','".$objResult28["ingredient28"]."','".$objResult28["ingredient29"]."')";
$qsave98=mysqli_query($conn,$save98);
	
	
if($rs["returns"]=='S31'){
	
$save99="insert into tb_product_checklist
(ref_pc,doc_no,year_no,ref_id,product_id,add_date,add_by,date_create,head_pc,sol_ckk)
values
('".$ref_pc."','".$doc_no."','".$strYear1."','".$ref_id_br."','".$product_id."','".$add_date."','".$add_by."','".$strDate."','".$so."','1')";
$qsave99=mysqli_query($conn,$save99);


$save1="insert into tb_product_checklis (ref_pcc,type_emp,go_back,sol_ckk) values ('".$ref_pc."','ST','1','1')";
$qsave1=mysqli_query($conn,$save1);

$save2="insert into tb_product_checklis (ref_pcc,type_emp,go_back,sol_ckk) values ('".$ref_pc."','EN','1','1')";
$qsave2=mysqli_query($conn,$save2);

$save3="insert into tb_product_checklis (ref_pcc,type_emp,go_back,sol_ckk) values ('".$ref_pc."','CS','1','1')";
$qsave3=mysqli_query($conn,$save3);

$save4="insert into tb_product_checklis (ref_pcc,type_emp,go_back,sol_ckk) values ('".$ref_pc."','CS','2','1')";
$qsave4=mysqli_query($conn,$save4);

$save5="insert into tb_product_checklis (ref_pcc,type_emp,go_back,sol_ckk) values ('".$ref_pc."','EN','2','1')";
$qsave5=mysqli_query($conn,$save5);

$save6="insert into tb_product_checklis (ref_pcc,type_emp,go_back,sol_ckk) values ('".$ref_pc."','ST','2','1')";
$qsave6=mysqli_query($conn,$save6);	
		
}else{	

$save99="insert into tb_product_checklist
(ref_pc,doc_no,year_no,ref_id,product_id,add_date,add_by,date_create,head_pc)
values
('".$ref_pc."','".$doc_no."','".$strYear1."','".$ref_id_br."','".$product_id."','".$add_date."','".$add_by."','".$strDate."','".$so."')";
$qsave99=mysqli_query($conn,$save99);


$save1="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','ST','1')";
$qsave1=mysqli_query($conn,$save1);

$save2="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','EN','1')";
$qsave2=mysqli_query($conn,$save2);

$save3="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','CS','1')";
$qsave3=mysqli_query($conn,$save3);

$save4="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','CS','2')";
$qsave4=mysqli_query($conn,$save4);

$save5="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','EN','2')";
$qsave5=mysqli_query($conn,$save5);

$save6="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','ST','2')";
$qsave6=mysqli_query($conn,$save6);	
	
}	
	
	
//}	
	
$strSQL = "Update   hos__subbr set ckk_pro='1'  Where ref_idd_br = '".$ref_id_br."' and product_id ='".$product_id."'";
$objQuery = mysqli_query($conn,$strSQL);
	
	
	
}
	
	
?>
<tr>
<td style="width:15%;">
<?php if($rs["send_erpst"]=='0'){ ?>	
<input type='checkbox' name = "delete_ckk[<?php echo $objResult1["id"];?>]" value="1" style="border: 1px #CC0033 solid" class="w3-input w3-center" id = "delete_ckk[<?php echo $objResult1["id"];?>]" >	
	<?php } ?>
<input type="hidden" name="id[<?php echo $objResult1["id"];?>]" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id']; ?>">

<input type="hidden" name="product_id[<?php echo $objResult1["id"];?>]" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

<input type='text' name ="product_code[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["access_code"];?>" id ="product_code[<?php echo $objResult1["id"];?>]"    class="w3-input" />
	</td>

<td  style="width:20%;">
<textarea name = "product_name[<?php echo $objResult1["id"];?>]"   id = "product_name[<?php echo $objResult1["id"];?>]"  class="w3-input" readonly><?php echo $objResult1["sol_name"];?></textarea></td>	
	
<td style="width:8%;"><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    readonly/></td>

<td style="width:8%;">
	<input type='text' name = "sale_count[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["count"];?>" id = "sale_count[<?php echo $objResult1["id"];?>]"  class="w3-input" style="color:black;text-align:center"    />
	
	<input type='hidden' name = "countref[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["countref"];?>" id = "countref[]<?php echo $objResult1["id"];?>"    />
	</td>

<td style="width:15%;"><input type='text' name = "product_price[<?php echo $objResult1["id"];?>]" value="<?php  $price=$objResult1["price"]; echo number_format( $price,2)."";?>" id = "product_price[<?php echo $objResult1["id"];?>]"  class="w3-input"  style="color:black;text-align:right"  size="10"  /></td>


<td style="width:15%;">
<input type='text' name = "sum_amount[<?php echo $objResult1["id"];?>]" value="<?php  $sum_amount=$objResult1["amount"]; echo number_format( $sum_amount,2)."";?>"  id = "sum_amount[<?php echo $objResult1["id"];?>]" size="10" class="w3-input" style="color:black;text-align:right"   />


</td>
	<td style="width:10%;"><textarea name = "sn[<?php echo $objResult1["id"];?>]"   id = "sn[<?php echo $objResult1["id"];?>]"  class="w3-input" readonly><?php echo $objResult1["sn"];?></textarea></td>	
<td style="width:10%;">

<input type='text' name = "br_period[<?php echo $objResult1["id"];?>]"  id = "br_period[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["br_periodd"];?>" placeholder="จำนวนวัน" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" class="w3-input" />

</td>
	<td style="width:20%;">

<textarea name = "sale_remarkk[<?php echo $objResult1["id"];?>]"  id = "sale_remarkk[<?php echo $objResult1["id"];?>]"  class="w3-input" ><?php echo $objResult1["sale_remark"];?></textarea>

</td>

<?php /*<td style="width:2%;"><a href=javascript:if(confirm('!!!ต้องการสร้างใบตรวจทานสินค้าใช่หรือไม่')==true){window.location='product_list.php?ref_id_br=<?php echo $rs["ref_id_br"];?>&product_id=<?php echo $objResult1["product_id"];  ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a>	</td>*/ ?>


<td style="width:2%;">
	<?php if($rs["send_erpst"]=='0'){ ?>	
	<a href="producthos_brdelete.php?ref_id_br=<?php echo $rs["ref_id_br"];?>&id=<?php echo $objResult1["id"];?>&code=<?php echo $_SESSION["type_login"]; ?>"><img src="img/false.png" width="16" height="16" border="0" /></a>
	<?php } ?>
	</td>

</tr>



<?php
	$i++;
	}
?>
</tbody>
</table>



<?php if($rs["send_erpst"]=='0'){
 if ($rs["company"]=='1'){ 
 include ('detail_adminbrhos1.php');
 }else  if ($rs["company"]=='2'){ 
 include ('detail_adminbrhosnb1.php');	 
 }
		}
?>



</div>



<div id="cs" class="w3-container city1" style="display:none"></p>
<?php
if ($rs["job_no"]!=''){

?>
		
<a href="https://cs.allwellcenter.com/7112018.php?running=<?php echo $rs["job_no"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">รายละเอียดจัดส่ง</font></a><br />

<?php } ?>

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


	<?php }else{ ?>
<input type="radio" name="delivery_type" value="1"   id="delivery_type" >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"   id="delivery_type" >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"   id="delivery_type" >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"    id="delivery_type" >&nbsp;บริษัทจัดส่ง <br />



<?php } ?>
<br>




	<?php
		$sql1 = "select * from tb_register_data where ref_id = '".$rs["ref_id_br"]."'";
				$query1 = mysqli_query($conn,$sql1);
				$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
	?>
<br>
	<?php if ($rs['send_cs']=='2'){ ?>
	<input type="checkbox" name="send_cs" checked='checked' value="2">&nbsp;ส่งข้อมูลไปสมุดลงงาน CS 

	<?php }else{ ?>

	<input type="checkbox" name="send_cs" value="1">&nbsp;ส่งข้อมูลไปสมุดลงงาน CS 

		<?php
	} 
		?>
&nbsp;&nbsp;&nbsp;
<?php if ($fetch1['bus_inter']=='1'){ ?>
	<input type="checkbox" name="bus_inter" checked='checked' value="1">&nbsp; ขนส่งอินเตอร์ 

	<?php }else{ ?>

	<input type="checkbox" name="bus_inter" value="1">&nbsp;ขนส่งอินเตอร์ 

		<?php
	} 
		?>
	
	<br>
 วันที่ รับ-ส่ง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="start_date" type='date' id="start_date" value="<?php echo $fetch1["start_date"]; ?>"  class="button4" style="width:20%" /><br>


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

<input type="checkbox"  name="fix_datetime" checked='checked' id = "fix_datetime" value="1">นัดวันและเวลาเรียบร้อยแล้ว &nbsp;&nbsp;
<?php }else{ ?>

<input type="checkbox"  name="fix_datetime" id = "fix_datetime" value="1">นัดวันและเวลาเรียบร้อยแล้ว &nbsp;&nbsp;

	<?php } ?>
<?php	
	if($fetch1["on_time"]=='1'){
	?>

<input type="checkbox"  id = "on_time" checked='checked' name="on_time" value="1">งานสำคัญต้องตรงเวลา&nbsp;&nbsp;

<?php }else{ ?>
<input type="checkbox"  id = "on_time" name="on_time" value="1">งานสำคัญต้องตรงเวลา&nbsp;&nbsp;

	<?php } ?>


<?php
	if($fetch1["call_customer"]=='1'){
		?>

<input type="checkbox" checked='checked' id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
<?php }else{ ?>

<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป

	<?php } 
	if($fetch1["call_employee"]=='1'){
	?>
		
&nbsp;&nbsp;<input type="checkbox"  id = "call_back" checked='checked' name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
&nbsp;&nbsp;
<?php }else{ ?>
&nbsp;&nbsp;<input type="checkbox"  id = "call_back"  name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
&nbsp;&nbsp;

	<?php } ?>
<?php	
	if($fetch1["no_price"]=='1'){
	?>

<input type="checkbox"  id = "no_money" checked='checked' name="no_money" value="1">ไม่ต้องเก็บเงิน&nbsp;&nbsp;

<?php }else{ ?>
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน&nbsp;&nbsp;

	<?php } ?>
<?php 	
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
<input name="employee_name" value="<?php echo $fetch1["employee_name"]; ?>" class="button4" type='text' value="<?php $fetch1["employee_name"]; ?>" id="employee_name" >
<input name="h_employee_name" value="<?php echo $fetch1["add_code"]; ?>" class="button4" type='hidden'  id="h_employee_name" >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรพนักงาน :&nbsp;
<input name="employee_tel" value="<?php echo $fetch1["employee_tel"]; ?>" class="button4" type='text' id="employee_tel" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 ผู้ลงงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="add_by" value="<?php echo $fetch1["add_by"]; ?>" type='text' class="button4" >

</p>
จังหวัด :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
<select name="province_name" id ="province_name" class="button4" style="width:30%" >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_province order by province_ID ";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($fetch1["province_name"] == $objResuut5["province_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
	?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['province_name']; ?>"<?php echo $sel;?>><?php echo $objResuut5['province_name']; ?></option>
<?php } ?>
</select>
</p>
สถานที่ส่งสินค้า :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         
<textarea  class="button4" name="address_1"  style="width:30%" ><?php echo $fetch1["address_1"]; ?></textarea>
</p>
ที่อยู่ในการส่งสินค้า :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<textarea  class="button4" name="address_name"   style="width:30%" ><?php echo $fetch1["address_name"]; ?></textarea>                 
</p>

  สถานที่ติดตั้งเครื่อง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<textarea   class="button4" name="address_send"   style="width:30%" rows="2"><?php echo $fetch1["address_send"]; ?></textarea>
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



<div id="ch3" class="w3-container city1" style="display:none">
<aside style="display: flex; justify-content: space-between;">
<div>
<b>เลขที่เอกสาร</b> : <?php echo $rs['iv_no']; ?> <br>
<b>ชื่อลูกค้า/โรงพยาบาล</b> : <?php echo $rs["customer"];?> <br>
<b>ที่อยู่</b> : <?php echo $rs["address"];?> <br>
<b>วันที่ รับ-ส่ง</b> : <?php echo $fetch1["start_date"]; ?>
</div>


<div>
<?php 
$strSQL1_sn = "SELECT * FROM  (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$ref_id_br."'  AND sn != ''  ";
$objQuery1_sn = mysqli_query($conn,$strSQL1_sn) or die ("Error Query [".$strSQL1_sn."]");
$Num_Rows1_sn = mysqli_num_rows($objQuery1_sn);
$objResult1_sn = mysqli_fetch_array($objQuery1_sn); ?>
<?php if($Num_Rows1_sn > 0) { ?>
<a href="register_adminhos_doc_sn.php?ref_id=<?php echo $ref_id_br;?>&status=so" class="w3-button w3-khaki" target="_blank" rel="noopener noreferrer">รายละเอียดเอกสาร</a> <br>
<?php  } ?>
</div>
</aside>
</div>


<?php if($rs["send_admin"] =='1' ){	?> 
	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึก">
	</div><br>
<?php } ?>

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
		return "data_sale1.php?employee_name_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("employee_name","h_employee_name");
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