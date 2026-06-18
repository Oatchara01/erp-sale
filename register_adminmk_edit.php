<?php
	include('head.php'); 
?>

<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>

<script src="dist/jautocalc.js"></script>

<script language="JavaScript">
	
	function chkNumber(ele)

{

var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
ele.onKeyPress=vchar;
}

var HttPRequest = false;
function doCallAjax1(bill_id,billing_name,billing_address,billing_tel,tax_id,ex_add,ex_aumper,ex_provin,ex_post,pre_name,email,customer_typename) {
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
var url = 'data_bill_name1.php';
var pmeters = "bill_id=" + encodeURI( document.getElementById(bill_id).value);
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

document.getElementById(billing_name).value = myArr[0];
document.getElementById(billing_address).value = myArr[1];
document.getElementById(billing_tel).value = myArr[2];
document.getElementById(tax_id).value = myArr[3];
document.getElementById(ex_add).value = myArr[6];
document.getElementById(ex_aumper).value = myArr[7];
document.getElementById(ex_provin).value = myArr[8];
document.getElementById(ex_post).value = myArr[9];
document.getElementById(pre_name).value = myArr[10];
document.getElementById(email).value = myArr[21];
document.getElementById(customer_typename).value = myArr[22];
}
}
}
}

    
</script>

<script>
	function resutName(strCusName) {
		frmMain.employee_name_head.value = strCusName.split("|")[0];
		frmMain.employee_code_head.value = strCusName.split("|")[1];
	}
	function object() {
		if (document.getElementById('object1').checked) {
			document.getElementById('dt1').style.display = 'block';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object2').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'block';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object3').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'block';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object4').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'block';
			document.getElementById('dt5').style.display = 'none';
		}else if (document.getElementById('object5').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'block';
		}
	
	}
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
	
</script>

<script>

function ck_2(){
var ck_2 = document.getElementById('ckk_2');
if(ck_2.checked == true){
document.getElementById('frm_txt_1').style.display = "";
}else{
document.getElementById('frm_txt_1').style.display = "none";
}

}
	
	
	
function ck_3(){
var ck_3 = document.getElementById('ckk_3');
if(ck_3.checked == true){
document.getElementById('frm_txt_2').style.display = "";
}else{
document.getElementById('frm_txt_2').style.display = "none";
}

}	

</script>

<body>
		

	<form  method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-white">
	
	<br>
	

<?php
$ref_id = isset($_GET['ref_id']) ? $_GET['ref_id'] : '';

$strSQL3 = "SELECT * FROM  tb_product_checklist WHERE ref_id = '".$ref_id."' ";
$objQ1 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");


$strSQL = "SELECT so__main.*  ,tb_delivery.* ,tb_payment.*  FROM ((so__main  LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_id) LEFT JOIN tb_payment ON so__main.payment=tb_payment.payment_ID) WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	

$strSQL1 = "SELECT * FROM  (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL12 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_id."' and extra='1'";
$objQuery12 = mysqli_query($conn,$strSQL12) or die("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);


$strSQL13 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_id."' and extra='2'";
$objQuery13 = mysqli_query($conn,$strSQL13) or die("Error Query [".$strSQL13."]");
$objResult13 = mysqli_fetch_array($objQuery13);

$strSQL14 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_id."' and extra='3'";
$objQuery14 = mysqli_query($conn,$strSQL14) or die("Error Query [".$strSQL14."]");
$objResult14 = mysqli_fetch_array($objQuery14);

$strSQL15 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='4'";
$objQuery15 = mysqli_query($conn,$strSQL15) or die("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);

$strSQL16 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='5'";
$objQuery16 = mysqli_query($conn,$strSQL16) or die("Error Query [".$strSQL16."]");
$objResult16 = mysqli_fetch_array($objQuery16);

$strSQL17 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='6'";
$objQuery17 = mysqli_query($conn,$strSQL17) or die("Error Query [".$strSQL17."]");
$objResult17 = mysqli_fetch_array($objQuery17);

$strSQL18 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='7'";
$objQuery18 = mysqli_query($conn,$strSQL18) or die("Error Query [".$strSQL18."]");
$objResult18 = mysqli_fetch_array($objQuery18);

$strSQL19 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='8'";
$objQuery19 = mysqli_query($conn,$strSQL19) or die("Error Query [".$strSQL19."]");
$objResult19 = mysqli_fetch_array($objQuery19);

$strSQL20 = "SELECT * FROM so__extraaddress WHERE ref_id = '".$ref_idd."' and extra='9'";
$objQuery20 = mysqli_query($conn,$strSQL20) or die("Error Query [".$strSQL20."]");
$objResult20 = mysqli_fetch_array($objQuery20);

		
$sql23 = "SELECT * FROM tb_other_bill where ref_id = '".$ref_id."'";
$qry23 = mysqli_query($conn,$sql23) or die(mysqli_error());
$rs23 = mysqli_fetch_assoc($qry23);	
		
		
	?>
<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-container w3-bar w3-light-gray w3-margin-bottom">
		
		<div class="w3-half">
					<h4>Edit Data : Admin</h4>
				</div>
				<div class="w3-half">

				</div>
			</div>


		<div class="w3-container w3-half"><!-- first half -->
			<div class="w3-bar w3-border">
				<?php if ($objResult["select_type_doc"]=='1'){ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="1" onclick="javascript:object();" id="object1">&nbsp;ใบยืมสินค้า AWL</div>
				<?php }else{ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" value="1" onclick="javascript:object();"  id="object1">&nbsp;ใบยืมสินค้า AWL</div>
				<?php }
				if ($objResult["select_type_doc"]=='2'){ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="2" onclick="javascript:object();"  id="object2" >&nbsp;ใบยืมสินค้า NBM</div>
				<?php } else{ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" value="2" onclick="javascript:object();"  id="object2" >&nbsp;ใบยืมสินค้า NBM</div>
				<?php }
				if ($objResult["select_type_doc"]=='3'){ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="3" onclick="javascript:object();"  id="object3" >&nbsp;ใบสั่งขาย AWL</div>
				<?php } else{ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" value="3" onclick="javascript:object();"  id="object3" >&nbsp;ใบสั่งขาย AWL</div>
				<?php }
				if ($objResult["select_type_doc"]=='4'){ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="4" onclick="javascript:object();"  id="object4" >&nbsp;ใบสั่งขาย NBM</div>
				<?php } else{ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" value="4" onclick="javascript:object();"  id="object4">&nbsp;ใบสั่งขาย NBM</div>
				<?php } ?>
				
			</div>
		<div class="w3-panel">
			<?php $date = explode('-' , $objResult["register_date"] );
				 // $xdate = $date[2].'-'.$date[1].'-'.$date[0];
				  /*echo $xdate;*/
			?>
			<span>วันที่</span> <span class="w3-light-grey"><?php echo DateThai($objResult["register_date"]); ?> <?php echo $objResult["register_time"]; ?></span> เลขที่อ้างอิง :<span class="w3-light-grey"><?php echo $objResult['ref_id']; ?></span><input type="hidden" name="ref_id" class="w3-input25" value="<?php echo $objResult['ref_id']; ?>"> <input type="hidden" name="main_id" value="<?php echo $objResult['main_id']; ?>">
			<input type="hidden" name="register_date" value="<?php echo $objResult['register_date']; ?>">
			<input type="hidden" name="register_time" value="<?php echo $objResult['register_time']; ?>">
		</div>
		<div class="w3-bar">
			<span>ช่องทางการขาย</span>
			<select name="sale_channel" id="sale_channel" class="w3-select" onchange="showUser(this.value)">
				<option  value="">**โปรดเลือกช่องทางการขาย**</option>
				<?php
					$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
					$querychannel = mysqli_query($conn,$sqlchannel);
					while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) {
						if($objResult["sale_channel"] == $fetchchannel["salechannel_ID"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						} ?>
				<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>" <?php echo $sel;?>><?php echo $fetchchannel['salechannel_nameshort']; ?>&nbsp;&nbsp;<?php echo $fetchchannel['description_chanel']; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="w3-padding-small"></div>
		<div class="w3-bar">
			<span>การจัดส่ง</span>
			<input name="delivery" type='text' class="w3-input" id="delivery" value="<?php echo $objResult["delivery_name"]; ?><?php echo $objResult["time_delivery"]; ?>" placeholder="Search การจัดส่ง..."> 
			<input name="h_delivery" type="hidden" id="h_delivery"  value="<?php echo $objResult["delivery"]; ?>" class="w3-input" /> 
			
		</div>
		<div class="w3-padding-small"></div>
		<div class="w3-bar">
			<span>การชำระเงิน</span>
			<input name="payment" type='text' class="w3-input" id="payment"  value="<?php echo $objResult["payment_name"]; ?><?php echo $objResult["bank_name"]; ?><?php echo $objResult["book_name"]; ?>" placeholder="Search การชำระเงิน..."> 
			<input name="h_payment" type="hidden" id="h_payment" value="<?php echo $objResult["payment"]; ?>" class="w3-input" />
			
		</div>
		<div class="w3-padding-small"></div>
		<div class="w3-bar">
			<span>หมายเหตุ</span>
			<textarea name="sale_remark"  class="w3-input" id="sale_remark"  rows="1"><?php echo $objResult['sale_remark']; ?></textarea>
		</div>
		<div class="w3-padding-small"></div>
		<div class="w3-bar">
			<span>ชื่อพนักงาน</span>
			<input name="employee_name" type="text" id="employee_name" value="<?php echo $objResult["employee_name"]; ?>" class="w3-input" /> 
					
		</div>
			<div class="w3-padding-small"></div>
		<div class="w3-bar">
			
			<?php if($objResult["cancel_ckk"]=='1'){ ?>
<input type="checkbox" name="cancel_ckk" id="cancel_ckk" value = '1' checked='checked' class="button4"  >&nbsp;&nbsp; ยกเลิก&nbsp;&nbsp;
<?php }else { ?>
<input type="checkbox" name="cancel_ckk" id="cancel_ckk" value = '1'  class="button4"  >&nbsp;&nbsp; ยกเลิก&nbsp;&nbsp;

	<?php } 
												   ?>
</div>
	<div class="w3-bar">
			<span>เหตุผล</span>
			<textarea name="cancel_des"  class="w3-input" id="cancel_des"  rows="1"><?php echo $objResult['cancel_des']; ?></textarea>
		</div>	
			
	<div class="w3-bar">		
			<?php if($objResult["send_erpst"]=="0"){ ?>
<input type='hidden'  name = "line_stock"  id = "line_stock"  class="button4"   >
<?php }else{  ?>
<font color="red">หมายเหตุการแก้ไข (เนื่องจาก Stock จัดของแล้ว)</font>&nbsp;<input type="checkbox" name="no_line" id ="no_line" value="1" >&nbsp;ไม่ต้องส่งแจ้งเตือน
<textarea  name = "line_stock"  id = "line_stock"  rows="2" class="w3-input"  required ></textarea>
<input type='hidden'  name = "send_erpst"  id = "send_erpst" value ="<?php echo $objResult["send_erpst"]; ?>"  class="button4"   >		
<?php } ?>
				</div>
			
			<div class="w3-bar">
	<?php if ($objResult['send_brdoc']=='2'){ ?>
	<input type="checkbox" name="send_brdoc" checked='checked' value="2" >&nbsp;ส่งข้อมูลไปรับจ่ายใบยืม

	<?php }else{ ?>

	<input type="checkbox" name="send_brdoc" value="1">&nbsp;ส่งข้อมูลไปรับจ่ายใบยืม 

		<?php
	} 
		?>
				
	</div>	
			
			<div class="w3-bar">
	<?php if ($objResult['cash_ckk']=='1'){ ?>
	<input type="checkbox" name="cash_ckk" checked='checked' value="1">&nbsp;บิลเงินสด

	<?php }else{ ?>

	<input type="checkbox" name="cash_ckk" value="1">&nbsp;บิลเงินสด 

		<?php
	} 
		?>
				
				</div><div class="w3-bar">
	<?php if ($objResult['bill_send']=='1'){ ?>
	<input type="checkbox" name="bill_send" checked='checked' value="1">&nbsp;เปิดบิลแล้วรอส่งของ

	<?php }else{ ?>

	<input type="checkbox" name="bill_send" value="1">&nbsp; เปิดบิลแล้วรอส่งของ

		<?php
	} 
		?>			
				
	</div>	
			
			<div class="w3-bar">	
	<?php if($objResult['buy_ckk']=='1'){ ?>
			<input type="checkbox" name="buy_ckk" checked='checked' value="1"> &nbsp;ลูกค้าซื้อซ้ำ<br>

	<?php }else{ ?>
		<input type="checkbox" name="buy_ckk" value="1"> &nbsp;ลูกค้าซื้อซ้ำ<br>
	<?php } ?>
	<?php if($rs23["ref_12"]=='1'){ ?>
<input type="checkbox" name="ref_12" checked='checked' id="ref_12" value="1"> &nbsp;ส่งสินค้าด้วยใบรับสินค้า [ไม่ระบุราคา]<br>
<?php }else{ ?>
<input type="checkbox" name="ref_12"  id="ref_12" value="1"> &nbsp;ส่งสินค้าด้วยใบรับสินค้า [ไม่ระบุราคา]<br>

<?php } ?>

<?php if($rs23["ref_13"]=='1'){ ?>
<input type="checkbox" name="ref_13"  checked='checked' id="ref_13" value="1"> &nbsp;ไม่ต้องนำใบกำกับภาษี/ใบเสร็จไปส่งสินค้า
<?php }else{ ?>
<input type="checkbox" name="ref_13"  id="ref_13" value="1"> &nbsp;ไม่ต้องนำใบกำกับภาษี/ใบเสร็จไปส่งสินค้า
<?php } ?>
			
		</div>	
	</div><!-- first half -->
	<div class="w3-container w3-half"><!-- second half -->
		<div class="w3-bar w3-light-grey w3-border">
			<a class="w3-bar-item w3-button" onclick="openCity('st')"><font color="#404040"><b>Admin ลงทะเบียน</b></font></a>
			<a class="w3-bar-item w3-button" onclick="openCity('so')"><font color="#404040"><b>ใบสั่งขาย</b></font></a>
			<a class="w3-bar-item w3-button" onclick="openCity('mo')"><font color="#404040"><b>เพิ่มเติม</b></font></a>
			<a class="w3-bar-item w3-button"  onclick="openCity('br')"><font color="#404040"><b>ใบยืมสินค้า</b></font></a>
			<a class="w3-bar-item w3-button" onclick="openCity1('cs2')"><font color="#404040"><b>ที่อยู่ส่งบิล</b></font></a>
			
			<div class="dropdown">
  <button class="w3-bar-item w3-button" ><font color="#404040"><b>ใบปะที่อยู่เพิ่มเติม</b></font></button>
  <div class="dropdown-content w3-light-grey w3-border">
    <a class="w3-bar-item w3-button" onclick="openCity('so1')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 2</b></font></a>
    <a class="w3-bar-item w3-button" onclick="openCity('so2')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 3</b></font></a>
    <a class="w3-bar-item w3-button" onclick="openCity('so3')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 4</b></font></a>
	<a class="w3-bar-item w3-button" onclick="openCity('so4')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 5</b></font></a>
    <a class="w3-bar-item w3-button" onclick="openCity('so5')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 6</b></font></a>
    <a class="w3-bar-item w3-button" onclick="openCity('so6')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 7</b></font></a>
	<a class="w3-bar-item w3-button" onclick="openCity('so7')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 8</b></font></a>
    <a class="w3-bar-item w3-button" onclick="openCity('so8')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 9</b></font></a>
    <a class="w3-bar-item w3-button" onclick="openCity('so9')"><font color="#404040"><b>ที่อยู่เพิ่มเติม 10</b></font></a>
  </div>
</div>
		</div>
		
		
<div id="cs2" class="w3-container city1" style="display:none">
	
</p><fieldset><legend><b>รายละเอียดการจัดส่งบิล</b></legend>	

<?php	

$strSQL8 = "SELECT *  FROM tb_delivery_bill where ref_id = '".$_GET["ref_id"]."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);	
	
?>	

<div class="w3-bar">			
ชื่อผู้ติดต่อ   :
<input name="customer_nameb"  class="w3-input" type='text' id="customer_nameb" style="width:90%" value="<?php echo $objResult8["customer_nameb"]; ?>" >
<input name="id_ref"  class="button4" type='hidden' id="id_ref" value="<?php echo $objResult8["id"]; ?>" >

</div><div class="w3-bar">	
 เบอร์โทรลูกค้า  :
<input name="customer_telb"  class="w3-input" type='text' id="customer_telb" style="width:90%" value="<?php echo $objResult8["customer_telb"]; ?>" >
</div><div class="w3-bar">	

ที่อยู่ในการส่งสินค้า  :
<textarea type='text'  class="w3-input" name="address_nameb" id="address_nameb" style="width:90%"  ><?php echo $objResult8["address_nameb"]; ?></textarea>  
</div>

<div class="w3-bar w3-half 1">
				<a href="reportb_h99std.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
				
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="reportb_ha5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ptl</font></a>
			</div>
			
			<div class="w3-bar w3-half 3">
				<a href="reportb_ha4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ptl</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				
				<a href="reportb_ha5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			
			<div class="w3-bar w3-half 5">
				<a href="reportb_ha4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			

</fieldset></p>	
	
	</div>		
		
		
		
		
		
	<div id="st" class="w3-container city" >
		<div class="w3-half"><!-- first right half -->
					
			<div class="w3-half w3-bar">
				เลขที่เอกสาร <input name="doc_no" class="w3-input" value="<?php echo $objResult['doc_no']; ?>" type="text" >
				
			</div>
			
			<div class="w3-half w3-bar">
 
เลขที่ IV รวมบิล <input name="iv_no" value="<?php echo $objResult['iv_no']; ?>" class="w3-input" type="text">
				
</div>
<div class="w3-half w3-bar">
 
เลขที่ SR ลดหนี้ <input name="sr_no" value="<?php echo $objResult['sr_no']; ?>" class="w3-input" type="text">
</div>
			<div class="w3-container w3-half w3-bar">
				เลขที่ลงงาน <input name="job_id" class="w3-input" value="<?php echo $objResult['job_id']; ?>" type="text">
			</div>
			<div class="w3-half w3-bar">
				วันที่ออกเอกสาร <input name="doc_release_date" class="w3-input" value="<?php echo $objResult['doc_release_date']; ?>" type="date">
	วันที่สั่งซื้อ <input class="w3-input" value="<?php echo $objResult['create_order']; ?>" type="text" readonly>			
<input name="doc_time" class="w3-input" value="<?php echo $objResult['doc_time']; ?>" type="hidden">	
<input name="admin_name" class="w3-input" value="<?php echo $objResult['admin_name']; ?>" type="hidden">				
			</div>
			
<div class="w3-half w3-bar">
				วันที่รวม IV <input name="iv_date" class="w3-input" value="<?php echo $objResult['iv_date']; ?>" type="date">
			</div><div class="w3-half w3-bar">
				จำนวนกล่อง <input name="count_box" class="w3-input" id='count_box' value="<?php echo $objResult['count_box']; ?>" type="text">
			</div>
			<div class="w3-half w3-bar">
				จำนวนครั้งที่แก้ไขบิล <input name="new_bill" class="w3-input" value="<?php echo $objResult['new_bill']; ?>" type="text">
			</div>
			<div class="w3-half w3-bar">
				วันที่ออกเอกสาร(เดิม) <input name="date_oldbill" class="w3-input" value="<?php echo $objResult['date_oldbill']; ?>" type="date">
			</div>
			แก้ไขบิลเนื่องจาก
<input name="desnew_bill" id="desnew_bill" type='text'  value="<?php echo $objResult['desnew_bill']; ?>" class="w3-input" >
			
			<div class="w3-container w3-half w3-bar">
				<?php if($objResult['et_ckk'] =='1'){ ?>
	<input type="checkbox" name="et_ckk" checked='checked' value="1"> ต้องการใบกำกับภาษี E-Tax 
<?php }else{
?>
	<input type="checkbox" name="et_ckk" value="1"> ต้องการใบกำกับภาษี E-Tax 
	<?php } ?>
				<?php if($objResult['have_order'] =='1'){ ?>
	<input type="checkbox" name="have_order" checked='checked' value="1"> &nbsp; มีออร์เดอร์ฝาก
<?php }else{
?>
	<input type="checkbox" name="have_order" value="1"> &nbsp; มีออร์เดอร์ฝาก
	<?php } ?><br>
				
				<?php if($objResult['que_ckk'] =='1'){ ?>
<input type="checkbox" name="que_ckk" id="que_ckk" value="1" checked='checked' ><font color='red' > งานด่วน </font>
<?php }else{
?>
	<input type="checkbox" name="que_ckk" id="que_ckk" value="1" ><font color='red' > งานด่วน </font>
	<?php } ?>
			<input name="deposit_no" class="w3-input" value="<?php echo $objResult['deposit_no']; ?>" type="text">
			</div>

<?php if ($objResult["send_stock"]=='1'){ ?>

<input type="checkbox" name="send_stock" checked='checked' value="1"> &nbsp;ส่งข้อมูลให้ Stock
<?php }else{ ?>
<input type="checkbox" name="send_stock" value="1"> &nbsp;ส่งข้อมูลให้ Stock

	<?php } ?>
			</p>
		<?php if ($objResult["ckkdate_vat"]=='1'){ ?>

<input type="checkbox" name="ckkdate_vat" checked='checked' value="1"> &nbsp;ไม่ต้องแสดงวันที่ในบิล
<?php }else{ ?>
<input type="checkbox" name="ckkdate_vat" value="1"> &nbsp;ไม่ต้องแสดงวันที่ในบิล

	<?php } ?>
		
		
		</p>
		<?php if ($objResult["ckkwar_pro"]=='1'){ ?>

<input type="checkbox" name="ckkwar_pro" checked='checked' value="1"> &nbsp;ไม่ต้องแสดงชื่อในใบรับประกัน
<?php }else{ ?>
<input type="checkbox" name="ckkwar_pro" value="1"> &nbsp;ไม่ต้องแสดงชื่อในใบรับประกัน

	<?php } ?></p>
		<?php if ($objResult["ckk_showwar"]=='1'){ ?>

<input type="checkbox" name="ckk_showwar" checked='checked' value="1"> &nbsp;ไม่ต้องแสดงที่อยู่บริษัทในใบรับประกัน
<?php }else{ ?>
<input type="checkbox" name="ckk_showwar" value="1"> &nbsp;ไม่ต้องแสดงที่อยู่บริษัทในใบรับประกัน

	<?php } ?>
		
		

			<div class="w3-bar">
				
				<?php
				$fdsfse = substr($objResult["doc_no"],0,2);
				if($fdsfse=='ET'){
					?>
				</p>
				<a href="report_ETecom.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบกำกับภาษี ET</font></a></p>	
				<?php 	
				}else{
				
				if($objResult["bill_vat"]=='1') {
		if($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='3') {
			
			
		 ?>
</p>
				<a href="report_vat1.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบกำกับภาษี ตรากลม</font></a></p>
			
			<a href="report_vat.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบกำกับภาษี ตราเหลี่ยม</font></a></p>
		
			<a href="report_vatph1.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบกำกับภาษี ตรากลม(สินค้า)</font></a></p>
			
			<a href="report_vatph.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบกำกับภาษี ตราเหลี่ยม(สินค้า)</font></a>

</p>
<input type="checkbox" name="ckk_2" id="ckk_2" onClick="ck_2();" value="1"/>เพิ่มเติม
<div id="frm_txt_1" style="display:none;">
</p>
				<a href="report_vat2.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบกำกับภาษี</font></a></p>
			
	
			<a href="report_vatph2.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบกำกับภาษี(สินค้า)</font></a></p>
			
</div>
		
		<?php }else if($objResult["select_type_doc"]=='2' or $objResult["select_type_doc"]=='4') {
		 ?> 
			</p>
		<a href="report_vatnbm.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบกำกับภาษี ตรากลม</font></a></p>
		<a href="report_vatnbm1.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบกำกับภาษี ตราเหลี่ยม</font></a></p>
<a href="report_vat_nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบกำกับภาษี ตรากลม(สินค้า)</font></a></p>
		<a href="report_vat_nbm1.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบกำกับภาษี ตราเหลี่ยม(สินค้า)</font></a>
		

</p>
<input type="checkbox" name="ckk_3" id="ckk_3" onClick="ck_3();" value="1"/>เพิ่มเติม
<div id="frm_txt_2" style="display:none;">
	
		<a href="report_vatnbm2.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบกำกับภาษี</font></a></p>
<a href="report_vat_nbm2.php?ref_id=<?php echo $objResult["ref_id"];?>&code=<?php echo $_SESSION['code'];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบกำกับภาษี(สินค้า)</font></a></p>
	
	
	</div>
				<?php 
		}
		}
				}
?>


				
				</p>

<?php
if($objResult["approve_complete"]=='Rejected' ){
}else{

				 if ($objResult["select_type_doc"]=='1') { ?>
					<input type="checkbox"  checked="checked" value="1">&nbsp;
					<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม ALL</font></a>&nbsp;&nbsp;
<a href="report_loansol.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืมต่อเนื่อง</font></a>&nbsp;&nbsp;
				<?php }
				else { ?>
					<div id="dt1" style="display:none">
						<input type="checkbox"  checked="checked" value="1">&nbsp;
						<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม PTL</font></a>&nbsp;&nbsp;
						<a href="report_loansol.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืมต่อเนื่อง</font></a>&nbsp;&nbsp;
					</div>
				<?php }
					if ($objResult["select_type_doc"]=='2'){ ?>
						<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
						<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;
<a href="report_loansol.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบยืมต่อเนื่อง</font></a>&nbsp;&nbsp;
				<?php }
				else { ?>
					<div id="dt2" style="display:none">
						<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
						<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;
						<a href="report_loansol.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบยืมต่อเนื่อง</font></a>&nbsp;&nbsp;
					</div>
				<?php }
					if ($objResult["select_type_doc"]=='3'){ ?>
						<input type="checkbox" name="select_so_ptl" checked="checked" value="1">&nbsp;
						<a href="report_saleptl1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย ALL</font></button></a><br/>
				<?php }
				else { ?>
					<div id="dt3" style="display:none">
						<input type="checkbox" name="select_so_ptl" checked="checked" value="1">&nbsp;
						<a href="report_saleptl1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย ALL</font></button></a><br/>
					</div>
				<?php }
					if ($objResult["select_type_doc"]=='4'){?>
						<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
						<a href="report_salenbm1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
				<?php }
				else { ?>
					<div id="dt4" style="display:none">
						<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
						<a href="report_salenbm1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
					</div>
				<?php } 
						}
						?>





			</div>
			<div class="w3-bar">ใบปะหน้ากล่อง</div>
			<div class="w3-bar w3-half 1">
				<a href="report_99std.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_99std_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
			<div class="w3-bar w3-half 2">
				<a href="report_a5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_a5ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_a4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_a4ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 4">
				<a href="report_a5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 4">
				<a href="report_a5nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a>
			</div>
			<div class="w3-bar w3-half 5">
				<a href="report_a4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 5">
				<a href="report_a4nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a>
			</div>
		</div><!-- first right half -->
		<div class="w3-half"><!-- second right half -->
			<div class="w3-bar w3-half">
			<?php if ($objResult["select_type_doc"]=='1') { ?>
				<?php if ($objResult["print_sol"]=='1') { ?>
				<a href="report_summary_ptl.php?sale_channel=<?php echo $objResult["sale_channel"];?>&doc_release_date=<?php echo  $objResult["doc_release_date"];?>&doc_no=<?php echo  $objResult["doc_no"];?>" target="_blank" class="w3-button w3-yellow" style="width:90%;"><font color="Blue">สรุปยืมแบบรวม ALL</font></a>
				<?php }else{ ?>
				<a href="report_summary_ptl.php?sale_channel=<?php echo $objResult["sale_channel"];?>&doc_release_date=<?php echo  $objResult["doc_release_date"];?>&doc_no=<?php echo  $objResult["doc_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">สรุปยืมแบบรวม ALL</font></a>
				<?php }
				}
				?>
			</div>
				<?php if ($objResult["select_type_doc"]=='2') { ?>
<div class="w3-bar w3-half w3-margin-bottom">
<?php if ($objResult["print_sol"]=='1') { ?>
	<a href="report_summary_nbm.php?sale_channel=<?php echo $objResult["sale_channel"];?>&doc_release_date=<?php echo  $objResult["doc_release_date"];?>&doc_no=<?php echo  $objResult["doc_no"];?>" target="_blank" class="w3-button w3-yellow w3-right" style="width:90%;"><font color="DeepPink">สรุปยืมแบบรวม NBM</font></a>
	<?php }else{ ?>
		
				<a href="report_summary_nbm.php?sale_channel=<?php echo $objResult["sale_channel"];?>&doc_release_date=<?php echo  $objResult["doc_release_date"];?>&doc_no=<?php echo  $objResult["doc_no"];?>" target="_blank" class="w3-button w3-grey w3-right" style="width:90%;"><font color="DeepPink">สรุปยืมแบบรวม NBM</font></a>
<?php } ?>
			</div>

				<?php } ?>
			<div class="w3-bar w3-half">
			<?php if ($objResult["select_type_doc"]=='1') { ?>
				<a href="report_summary_IVptl.php?sale_channel=<?php echo $objResult["sale_channel"];?>&register_date=<?php echo  $objResult["register_date"];?>&iv_no=<?php echo  $objResult["iv_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">สรุปรวม เคลียร์ยอดเงิน ALL</font></a>

				<?php } ?>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom">
			<?php if ($objResult["select_type_doc"]=='2') { ?>
				<a href="report_summary_IVnbm.php?sale_channel=<?php echo $objResult["sale_channel"];?>&register_date=<?php echo  $objResult["register_date"];?>&iv_no=<?php echo  $objResult["iv_no"];?>" target="_blank" class="w3-button w3-grey w3-right" style="width:90%;"><font color="DeepPink">สรุปรวม เคลียร์ยอดเงิน NBM</font></a>
				<?php } ?>
			</div>
			
			<div class="w3-bar w3-half">
			<?php if ($objResult["select_type_doc"]=='1') { ?>
				<a href="report_summary_IVptl_st.php?sale_channel=<?php echo $objResult["sale_channel"];?>&register_date=<?php echo  $objResult["register_date"];?>&iv_no=<?php echo  $objResult["iv_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">สรุปรวม Stock เคลียร์ยอดเงิน ALL</font></a>

				<?php } ?>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom">
			<?php if ($objResult["select_type_doc"]=='2') { ?>
				<a href="report_summary_IVnbm_st.php?sale_channel=<?php echo $objResult["sale_channel"];?>&register_date=<?php echo  $objResult["register_date"];?>&iv_no=<?php echo  $objResult["iv_no"];?>" target="_blank" class="w3-button w3-grey w3-right" style="width:90%;"><font color="DeepPink">สรุปรวม Stock เคลียร์ยอดเงิน NBM</font></a>
				<?php } ?>
			</div>

			<div class="w3-bar w3-center">
				<a href="" target="_blank" class="w3-button w3-grey" style="width:100%;" onClick="window.open('billing_name.php?main_id=<?php echo $objResult['main_id']; ?>','Billing Description','resizable,height=600,width=720'); return false;"><font color="DarkViolet">รายชื่อที่ต้องการออกบิล</font></a>
			</div>
			<div class="w3-bar w3-margin-top">
				<?php
					if ($objResult['admin_complete']=='1'){ ?>
						คลิ๊กสมบูรณ์เมื่อออกบิลแล้ว <input type='checkbox' name='admin_complete' checked='checked' value='1'>
					<?php }
					else { ?>
						คลิ๊กสมบูรณ์เมื่อออกบิลแล้ว <input type='checkbox' name='admin_complete' value='1'>
				<?php } ?>
			</div>
			<div class="w3-bar w3-margin-top">
				Status เอกสาร 
			</div>
			<div class="w3-bar">
				<?php
					if ($objResult['status_doc']=='1'){ ?>
						<input type='radio' name='status_doc' checked="checked" value='1'>&nbsp;รอดำเนินการ
						<input type='radio' name='status_doc' value='2'>&nbsp;สมบูรณ์แล้ว
					<?php }
					else if ($objResult['status_doc']=='2'){ ?>
						<input type='radio' name='status_doc'  value='1'>&nbsp;รอดำเนินการ
						<input type='radio' name='status_doc' checked="checked" value='2'>&nbsp;สมบูรณ์แล้ว
					<?php }
					else { ?>
						<input type='radio' name='status_doc'  value='1'>&nbsp;รอดำเนินการ
						<input type='radio' name='status_doc'  value='2'>&nbsp;สมบูรณ์แล้ว
					<?php } ?>
			</div>
			<div class="w3-bar w3-margin-top">
				แนบไฟล์ 
			</div>
			<input type='hidden' name='upload1' id='upload1' value ="<?php echo $objResult['upload1']; ?>"  />
			<input type='hidden' name='upload2' id='upload2' value ="<?php echo $objResult['upload2']; ?>"  />
			<input type='hidden' name='upload3' id='upload3' value ="<?php echo $objResult['upload3']; ?>"  />
			<input type='hidden' name='upload4' id='upload4' value ="<?php echo $objResult['upload4']; ?>"  />
			<input type='hidden' name='upload5' id='upload5' value ="<?php echo $objResult['upload5']; ?>"  />
		
			<input name="upload1" style="width:90%;" type="file"><a href="upload/<?php echo $objResult['upload1']; ?>" target="_blank"><?php echo $objResult['upload1']; ?></a> 
			<?php if($objResult['upload1'] !=''){ ?>
			<a href="upload1_delete.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/false.png" width="16" height="16" border="0" /></a>
			<?php }else{  } ?>
			
			
			
			</p>
			<input name="upload2" style="width:90%;" type="file"><a href="upload/<?php echo $objResult['upload2']; ?>" target="_blank"><?php echo $objResult['upload2']; ?></a>
<?php if($objResult['upload2'] !=''){ ?>
			<a href="upload2_delete.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/false.png" width="16" height="16" border="0" /></a>
			<?php }else{  } ?>
</p>
			<input name="upload3" style="width:90%;" type="file"><a href="upload/<?php echo $objResult['upload3']; ?>" target="_blank"><?php echo $objResult['upload3']; ?></a>
<?php if($objResult['upload3'] !=''){ ?>
			<a href="upload3_delete.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/false.png" width="16" height="16" border="0" /></a>
			<?php }else{  } ?>
</p>
			<input name="upload4" style="width:90%;" type="file"><a href="upload/<?php echo $objResult['upload4']; ?>" target="_blank"><?php echo $objResult['upload4']; ?></a>
<?php if($objResult['upload4'] !=''){ ?>
			<a href="upload4_delete.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/false.png" width="16" height="16" border="0" /></a>
			<?php }else{  } ?>
</p>
			<input name="upload5" style="width:90%;" type="file"><a href="upload/<?php echo $objResult['upload5']; ?>" target="_blank"><?php echo $objResult['upload5']; ?></a>
<?php if($objResult['upload5'] !=''){ ?>
			<a href="upload5_delete.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/false.png" width="16" height="16" border="0" /></a>
			<?php }else{  } ?>
</p>
		</div><!-- second right half -->
	</div><!-- close st -->
	
	<div id="so" class="w3-container city" style="display:none"> 
		<div class="w3-half"><!--first half-->
			<div class="w3-bar">
				
				รหัสลูกค้า
<input type='text' name = "bill_id"  id = "bill_id" value="<?php echo $objResult['bill_id']; ?>" class="w3-input" placeholder="Search ชื่อลูกค้า..."   OnChange="JavaScript:doCallAjax1('bill_id','billing_name','billing_address','billing_tel','tax_id','ex_add','ex_aumper','ex_provin','ex_post','pre_name','email','customer_typename');"/> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id"  class="button4" readonly>	
				
<a href="edit_customer.php?customer_id=<?php echo $objResult["bill_id"];?>" class="w3-button w3-grey w3-right"  target="_blank"><font color="330066">ข้อมูลลูกค้า</font></a>
<a href="status_customer_sale.php?bill_id=<?php echo $objResult["bill_id"];?>" class="w3-button w3-grey w3-right"  target="_blank"><font color="330066">ข้อมูลออเดอร์</font></a>				
				
				<?php
$strSQL8 = "SELECT customer_code,customer_coden FROM tb_customer WHERE customer_id  = '".$objResult["bill_id"]."' ";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);

				?>
				<?php if($objResult["select_type_doc"]=='3'){ ?>
				<input  type='text' class="w3-input" value="<?php echo $objResult8['customer_code']; ?>" readonly>
			<?php if($objResult8['customer_code'] !=''){  }else{ ?>
				<a href="create_cusno.php?ref_id=<?php echo $objResult["ref_id"];?>&select_type_doc=<?php echo $objResult["select_type_doc"];?>" class="w3-button w3-grey w3-right"><font color="330066">รหัสลูกค้า</font></a>
				<?php } ?>
				
				<?php }else if($objResult["select_type_doc"]=='4'){ ?>
				<input  type='text' class="w3-input" value="<?php echo $objResult8['customer_coden']; ?>"  readonly>
				
				<?php if($objResult8['customer_coden'] !=''){  }else{ ?>
				<a href="create_cusno.php?ref_id=<?php echo $objResult["ref_id"];?>&select_type_doc=<?php echo $objResult["select_type_doc"];?>" class="w3-button w3-grey w3-right"><font color="330066">รหัสลูกค้า</font></a>
				<?php } ?>
				<?php } ?>
				
				</div>
			<div class="w3-bar">
				<?php

$sql55 = "SELECT status_cus,customer_no  FROM tb_customer where customer_id = '".$objResult["bill_id"]."'";
$qry55 = mysqli_query($conn,$sql55) or die(mysqli_error());
$rs55 = mysqli_fetch_assoc($qry55);	
	

 if($rs55["customer_no"] !=''){
 if($rs55["status_cus"]=='0'){
$status_cus="Gold Customer";
 }else if($rs55["status_cus"]=='1'){ 
$status_cus="Platinum Customer";
}else if($rs55["status_cus"]=='2'){ 
$status_cus="Daimond Customer";

}									 
}
	
	
if($rs55["customer_no"] !=''){	
	?>	

สถานะลูกค้า	
<?php if($rs55["status_cus"]=='0'){ ?>	
<input name="status_cus" id="status_cus" value="<?php echo $status_cus; ?>" type='text' class="w3-input w3-yellow" >	
<?php }else if($rs55["status_cus"]=='1'){ ?>	
<input name="status_cus" id="status_cus" value="<?php echo $status_cus; ?>" type='text' class="w3-input w3-light-green" >		
<?php }if($rs55["status_cus"]=='2'){ ?>		
<input name="status_cus" id="status_cus" value="<?php echo $status_cus; ?>" type='text' class="w3-input w3-green" >	
<?php 
	}
	} ?>	
	
				
				</div>
			<div class="w3-bar">
				คำนำหน้าชื่อ:
             <input name="pre_name" id="pre_name" value="<?php echo $objResult['pre_name']; ?>" type='text' class="w3-input" >
				</div>
			<div class="w3-bar">
				ชื่อที่ออกบิล <input name="billing_name" id="billing_name" type='text' class="w3-input" value="<?php echo $objResult['billing_name']; ?>" >
			</div>
			<div class="w3-bar">
				ทีอยู่ที่ออกบิล <textarea name="billing_address" id="billing_address" class="w3-input" rows="1" ><?php echo $objResult['billing_address']; ?></textarea>
			</div>
			<div class="w3-bar">
				ทีอยู่ <textarea name="ex_add" id="ex_add" class="w3-input" rows="1" ><?php echo $objResult['ex_add']; ?></textarea>
			</div>
			<div class="w3-bar">
				อำเภอ <textarea name="ex_aumper" id="ex_aumper" class="w3-input" rows="1" ><?php echo $objResult['ex_aumper']; ?></textarea>
			</div>
			<div class="w3-bar">
				จังหวัด <textarea name="ex_provin" id="ex_provin" class="w3-input" rows="1" ><?php echo $objResult['ex_provin']; ?></textarea>
			</div>
			<div class="w3-bar">
				รหัสไปรษณีย์ <textarea name="ex_post" id="ex_post" class="w3-input" rows="1" ><?php echo $objResult['ex_post']; ?></textarea>
			</div>
			
<div class="w3-bar">
				E-Mail
<input name="email" id="email" type='text' value="<?php echo $objResult['email']; ?>" class="w3-input" >				
			</div>
			
<div class="w3-bar w3-half">
Tel. <input type="text" name="billing_tel" id="billing_tel" class="w3-input" value="<?php echo $objResult['billing_tel']; ?>" >
</div>
			<div class="w3-bar w3-half">
				<?php
					if($objResult['bill_vat']=='1'){
				?>
					<input type="checkbox" name="bill_vat" checked='checked' value="1"> บิล VAT
				<?php } else { ?>
					<input type="checkbox" name="bill_vat" value="1"> บิล VAT
				<?php } ?>
<input type="text" name="tax_id" id="tax_id" class="w3-input" value="<?php echo $objResult['tax_id']; ?>" >
			</div>
			<div class="w3-bar">
				การชำระเงิน
				<input name="payment1" type='text' class="w3-input" id="payment1"  value="<?php echo $objResult["payment_name"]; ?><?php echo $objResult["bank_name"]; ?><?php echo $objResult["book_name"]; ?>" placeholder="Search การชำระเงิน...">
				
			</div>
			<div class="w3-bar">
				การโอนเงิน
				<select name="transfer" class="w3-select">
					<option value="">**Please Select Item**</option>
					<?php
						$strSQL3 = "SELECT * FROM tb_transfer ORDER BY tranfer_ID ASC";
						$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
						while($objResult3 = mysqli_fetch_array($objQuery3)) {
							if($objResult["transfer"] == $objResult3["tranfer_name"]) {
								$sel = "selected";
							}
							else {
								$sel = "";
							}
					?>
					<option value="<?php echo $objResult3["tranfer_name"];?>"<?php echo $sel;?>><?php echo $objResult3["tranfer_name"];?></option>
					<?php } ?>
				</select>
			</div>
			<div class="w3-bar">
				ส่งบัญชีตรวจสอบ
				<?php
					if ($objResult["account_approve"]=='1'){?>
						<input type="checkbox" name="account_approve" checked='checked' value="1">
				<?php } else { ?>
						<input type="checkbox" name="account_approve" value="1">
				<?php } ?>
			</div>
			<div class="w3-bar">
				วันที่โอน
				<input type="date" name="transfer_date" id="transfer_date" class="w3-input" value="<?php echo $objResult["transfer_date"];?>">
			</div>
			<div class="w3-bar">
				จำนวนเงินโอน/เก็บปลายทาง
				<input type="text" name="amount" class="w3-input" value="<?php echo $objResult["amount"];?>">
			</div>
		</div><!-- first half -->
		<div class="w3-half w3-container w3-light-grey"><!--second half-->
			<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
			ชื่อผู้รับสินค้า
			<input name="customer_name" type="text" value="<?php echo $objResult['customer_name']; ?>" class="w3-input" >
			ที่อยู่ในการจัดส่ง
			<input name="address1" class="w3-input" type="text" value="<?php echo $objResult['address1'];?>">
			<input name="address2" class="w3-input" type="text" value="<?php echo $objResult['address2'];?>">
			จังหวัด
			<select name="province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>
			รหัสไปรษณีย์
			<input name="postcode" type="text" value="<?php echo $objResult["postcode"];?>" class="w3-input">
			โทรศัพท์
			<input name="tel" type="text"  value="<?php echo $objResult["tel"];?>" class="w3-input">
			<div class="w3-margin-bottom"></div>
		</div><!-- second half -->
	</div><!-- close so -->

	<div id="so1" class="w3-container city" style="display:none">
		<div class="w3-half"><h4> ที่อยู่เพิ่มเติม 2 </h4><!--first half so1-->
		<div class="w3-bar">ใบปะหน้ากล่อง</div>
			<div class="w3-bar w3-half 1">
				<a href="report_99std.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=1" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_99std_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=1" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
			<div class="w3-bar w3-half 2">
				<a href="report_a5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=1" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_a5ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=1" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_a4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=1" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_a4ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=1" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 4">
				<a href="report_a5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=1" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 4">
				<a href="report_a5nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=1" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a>
			</div>
			<div class="w3-bar w3-half 5">
				<a href="report_a4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=1" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 5">
				<a href="report_a4nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=1" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a>
			</div>
		</div><!-- first half -->
		<div class="w3-half w3-container w3-light-grey"><!--second half-->
			<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
			ชื่อผู้รับสินค้า
			<input name="ex1customer_name" type="text" value="<?php echo $objResult12['customer_name']; ?>" class="w3-input" >
			ที่อยู่ในการจัดส่ง
			<input name="ex1address1" class="w3-input" type="text" value="<?php echo $objResult12['address1'];?>">
			<input name="ex1address2" class="w3-input" type="text" value="<?php echo $objResult12['address2'];?>">
			จังหวัด
			<select name="ex1province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult12["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>
			รหัสไปรษณีย์
			<input name="ex1postcode" type="text" value="<?php echo $objResult12["postcode"];?>" class="w3-input">
			โทรศัพท์
			<input name="ex1tel" type="text"  value="<?php echo $objResult12["tel"];?>" class="w3-input">
			<div class="w3-margin-bottom"></div>
		</div><!-- second half -->
	</div><!-- close so1 -->

	<div id="so2" class="w3-container city" style="display:none">
		<div class="w3-half"><h4>ที่อยู่เพิ่มเติม 3 </h4><!--first half so2-->
		<div class="w3-bar">ใบปะหน้ากล่อง</div>
			<div class="w3-bar w3-half 1">
				<a href="report_99std.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=2" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_99std_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=2" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
			<div class="w3-bar w3-half 2">
				<a href="report_a5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=2" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_a5ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=2" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_a4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=2" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_a4ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=2" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 4">
				<a href="report_a5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=2" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 4">
				<a href="report_a5nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=2" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a>
			</div>
			<div class="w3-bar w3-half 5">
				<a href="report_a4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=2" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 5">
				<a href="report_a4nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=2" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a>
			</div>
		</div><!-- first half -->
		<div class="w3-half w3-container w3-light-grey"><!--second half-->
			<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
			ชื่อผู้รับสินค้า
			<input name="ex2customer_name" type="text" value="<?php echo $objResult13['customer_name']; ?>" class="w3-input" >
			ที่อยู่ในการจัดส่ง
			<input name="ex2address1" class="w3-input" type="text" value="<?php echo $objResult13['address1'];?>">
			<input name="ex2address2" class="w3-input" type="text" value="<?php echo $objResult13['address2'];?>">
			จังหวัด
			<select name="ex2province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult13["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>
			รหัสไปรษณีย์
			<input name="ex2postcode" type="text" value="<?php echo $objResult13["postcode"];?>" class="w3-input">
			โทรศัพท์
			<input name="ex2tel" type="text"  value="<?php echo $objResult13["tel"];?>" class="w3-input">
			<div class="w3-margin-bottom"></div>
		</div><!-- second half -->
	</div><!-- close so2 -->

	<div id="so3" class="w3-container city" style="display:none">
		<div class="w3-half"><h4>ที่อยู่เพิ่มเติม 4</h4> <!--first half so3-->
		<div class="w3-bar">ใบปะหน้ากล่อง</div>
			<div class="w3-bar w3-half 1">
				<a href="report_99std.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=3" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_99std_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=3" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
			<div class="w3-bar w3-half 2">
				<a href="report_a5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=3" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_a5ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=3" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_a4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=3" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_a4ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=3" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 4">
				<a href="report_a5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=3" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 4">
				<a href="report_a5nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=3" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a>
			</div>
			<div class="w3-bar w3-half 5">
				<a href="report_a4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=3" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 5">
				<a href="report_a4nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=3" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a>
			</div>
		</div><!-- first half -->
		<div class="w3-half w3-container w3-light-grey"><!--second half-->
			<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
			ชื่อผู้รับสินค้า
			<input name="ex3customer_name" type="text" value="<?php echo $objResult14['customer_name']; ?>" class="w3-input" >
			ที่อยู่ในการจัดส่ง
			<input name="ex3address1" class="w3-input" type="text" value="<?php echo $objResult14['address1'];?>">
			<input name="ex3address2" class="w3-input" type="text" value="<?php echo $objResult14['address2'];?>">
			จังหวัด
			<select name="ex3province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult14["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>
			รหัสไปรษณีย์
			<input name="ex3postcode" type="text" value="<?php echo $objResult14["postcode"];?>" class="w3-input">
			โทรศัพท์
			<input name="ex3tel" type="text"  value="<?php echo $objResult14["tel"];?>" class="w3-input">
			<div class="w3-margin-bottom"></div>
		</div><!-- second half -->
	</div><!-- close so3 -->

<div id="so4" class="w3-container city" style="display:none">
		<div class="w3-half"><h4>ที่อยู่เพิ่มเติม 5</h4> <!--first half so4-->
		<div class="w3-bar">ใบปะหน้ากล่อง</div>
			<div class="w3-bar w3-half 1">
				<a href="report_99std.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=4" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_99std_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=4" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
			<div class="w3-bar w3-half 2">
				<a href="report_a5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=4" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_a5ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=4" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_a4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=4" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_a4ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=4" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 4">
				<a href="report_a5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=4" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 4">
				<a href="report_a5nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=4" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a>
			</div>
			<div class="w3-bar w3-half 5">
				<a href="report_a4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=4" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 5">
				<a href="report_a4nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=4" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a>
			</div>
		</div><!-- first half -->
		<div class="w3-half w3-container w3-light-grey"><!--second half-->
			<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
			ชื่อผู้รับสินค้า
			<input name="ex4customer_name" type="text" value="<?php echo $objResult15['customer_name']; ?>" class="w3-input" >
			ที่อยู่ในการจัดส่ง
			<input name="ex4address1" class="w3-input" type="text" value="<?php echo $objResult15['address1'];?>">
			<input name="ex4address2" class="w3-input" type="text" value="<?php echo $objResult15['address2'];?>">
			จังหวัด
			<select name="ex4province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult15["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>
			รหัสไปรษณีย์
			<input name="ex4postcode" type="text" value="<?php echo $objResult15["postcode"];?>" class="w3-input">
			โทรศัพท์
			<input name="ex4tel" type="text"  value="<?php echo $objResult15["tel"];?>" class="w3-input">
			<div class="w3-margin-bottom"></div>
		</div><!-- second half -->
	</div><!-- close so4 -->

	<div id="so5" class="w3-container city" style="display:none">
		<div class="w3-half"><h4>ที่อยู่เพิ่มเติม 6</h4> <!--first half so5-->
		<div class="w3-bar">ใบปะหน้ากล่อง</div>
			<div class="w3-bar w3-half 1">
				<a href="report_99std.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=5" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_99std_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=5" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
			<div class="w3-bar w3-half 2">
				<a href="report_a5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=5" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_a5ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=5" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_a4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=5" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_a4ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=5" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 4">
				<a href="report_a5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=5" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 4">
				<a href="report_a5nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=5" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a>
			</div>
			<div class="w3-bar w3-half 5">
				<a href="report_a4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=5" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 5">
				<a href="report_a4nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=5" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a>
			</div>
		</div><!-- first half -->
		<div class="w3-half w3-container w3-light-grey"><!--second half-->
			<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
			ชื่อผู้รับสินค้า
			<input name="ex5customer_name" type="text" value="<?php echo $objResult16['customer_name']; ?>" class="w3-input" >
			ที่อยู่ในการจัดส่ง
			<input name="ex5address1" class="w3-input" type="text" value="<?php echo $objResult16['address1'];?>">
			<input name="ex5address2" class="w3-input" type="text" value="<?php echo $objResult16['address2'];?>">
			จังหวัด
			<select name="ex5province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult16["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>
			รหัสไปรษณีย์
			<input name="ex5postcode" type="text" value="<?php echo $objResult16["postcode"];?>" class="w3-input">
			โทรศัพท์
			<input name="ex5tel" type="text"  value="<?php echo $objResult16["tel"];?>" class="w3-input">
			<div class="w3-margin-bottom"></div>
		</div><!-- second half -->
	</div><!-- close so5 -->

	<div id="so6" class="w3-container city" style="display:none">
		<div class="w3-half"><h4>ที่อยู่เพิ่มเติม 7</h4> <!--first half so6-->
		<div class="w3-bar">ใบปะหน้ากล่อง</div>
			<div class="w3-bar w3-half 1">
				<a href="report_99std.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=6" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_99std_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=6" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
			<div class="w3-bar w3-half 2">
				<a href="report_a5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=6" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_a5ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=6" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_a4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=6" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_a4ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=6" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 4">
				<a href="report_a5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=6" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 4">
				<a href="report_a5nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=6" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a>
			</div>
			<div class="w3-bar w3-half 5">
				<a href="report_a4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=6" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 5">
				<a href="report_a4nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=6" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a>
			</div>
		</div><!-- first half -->
		<div class="w3-half w3-container w3-light-grey"><!--second half-->
			<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
			ชื่อผู้รับสินค้า
			<input name="ex6customer_name" type="text" value="<?php echo $objResult17['customer_name']; ?>" class="w3-input" >
			ที่อยู่ในการจัดส่ง
			<input name="ex6address1" class="w3-input" type="text" value="<?php echo $objResult17['address1'];?>">
			<input name="ex6address2" class="w3-input" type="text" value="<?php echo $objResult17['address2'];?>">
			จังหวัด
			<select name="ex6province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult17["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>
			รหัสไปรษณีย์
			<input name="ex6postcode" type="text" value="<?php echo $objResult17["postcode"];?>" class="w3-input">
			โทรศัพท์
			<input name="ex6tel" type="text"  value="<?php echo $objResult17["tel"];?>" class="w3-input">
			<div class="w3-margin-bottom"></div>
		</div><!-- second half -->
	</div><!-- close so6 -->

	<div id="so7" class="w3-container city" style="display:none">
		<div class="w3-half"><h4>ที่อยู่เพิ่มเติม 8</h4> <!--first half so7-->
		<div class="w3-bar">ใบปะหน้ากล่อง</div>
			<div class="w3-bar w3-half 1">
				<a href="report_99std.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=7" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_99std_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=7" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
			<div class="w3-bar w3-half 2">
				<a href="report_a5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=7" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_a5ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=7" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_a4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=7" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_a4ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=7" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 4">
				<a href="report_a5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=7" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 4">
				<a href="report_a5nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=7" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a>
			</div>
			<div class="w3-bar w3-half 5">
				<a href="report_a4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=7" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 5">
				<a href="report_a4nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=7" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a>
			</div>
		</div><!-- first half -->
		<div class="w3-half w3-container w3-light-grey"><!--second half-->
			<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
			ชื่อผู้รับสินค้า
			<input name="ex7customer_name" type="text" value="<?php echo $objResult18['customer_name']; ?>" class="w3-input" >
			ที่อยู่ในการจัดส่ง
			<input name="ex7address1" class="w3-input" type="text" value="<?php echo $objResult18['address1'];?>">
			<input name="ex7address2" class="w3-input" type="text" value="<?php echo $objResult18['address2'];?>">
			จังหวัด
			<select name="ex7province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult18["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>
			รหัสไปรษณีย์
			<input name="ex7postcode" type="text" value="<?php echo $objResult18["postcode"];?>" class="w3-input">
			โทรศัพท์
			<input name="ex7tel" type="text"  value="<?php echo $objResult18["tel"];?>" class="w3-input">
			<div class="w3-margin-bottom"></div>
		</div><!-- second half -->
	</div><!-- close so7 -->

	<div id="so8" class="w3-container city" style="display:none">
		<div class="w3-half"><h4>ที่อยู่เพิ่มเติม 9</h4> <!--first half so8-->
		<div class="w3-bar">ใบปะหน้ากล่อง</div>
			<div class="w3-bar w3-half 1">
				<a href="report_99std.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=8" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_99std_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=8" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
			<div class="w3-bar w3-half 2">
				<a href="report_a5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=8" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_a5ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=8" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_a4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=8" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_a4ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=8" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 4">
				<a href="report_a5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=8" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 4">
				<a href="report_a5nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=8" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a>
			</div>
			<div class="w3-bar w3-half 5">
				<a href="report_a4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=8" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 5">
				<a href="report_a4nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=8" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a>
			</div>
		</div><!-- first half -->
		<div class="w3-half w3-container w3-light-grey"><!--second half-->
			<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
			ชื่อผู้รับสินค้า
			<input name="ex8customer_name" type="text" value="<?php echo $objResult19['customer_name']; ?>" class="w3-input" >
			ที่อยู่ในการจัดส่ง
			<input name="ex8address1" class="w3-input" type="text" value="<?php echo $objResult19['address1'];?>">
			<input name="ex8address2" class="w3-input" type="text" value="<?php echo $objResult19['address2'];?>">
			จังหวัด
			<select name="ex8province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult19["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>
			รหัสไปรษณีย์
			<input name="ex8postcode" type="text" value="<?php echo $objResult19["postcode"];?>" class="w3-input">
			โทรศัพท์
			<input name="ex8tel" type="text"  value="<?php echo $objResult19["tel"];?>" class="w3-input">
			<div class="w3-margin-bottom"></div>
		</div><!-- second half -->
	</div><!-- close so8 -->

	<div id="so9" class="w3-container city" style="display:none">
		<div class="w3-half"><h4>ที่อยู่เพิ่มเติม 10</h4> <!--first half so9-->
		<div class="w3-bar">ใบปะหน้ากล่อง</div>
			<div class="w3-bar w3-half 1">
				<a href="report_99std.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=9" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_99std_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=9" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
			<div class="w3-bar w3-half 2">
				<a href="report_a5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=9" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_a5ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=9" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_a4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=9" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_a4ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=9" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ALL+k</font></a>
			</div>
			<div class="w3-bar w3-half 4">
				<a href="report_a5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=9" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 4">
				<a href="report_a5nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=9" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a>
			</div>
			<div class="w3-bar w3-half 5">
				<a href="report_a4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=9" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 5">
				<a href="report_a4nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>&extra=9" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a>
			</div>
		</div><!-- first half -->
		<div class="w3-half w3-container w3-light-grey"><!--second half-->
			<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
			ชื่อผู้รับสินค้า
			<input name="ex9customer_name" type="text" value="<?php echo $objResult20['customer_name']; ?>" class="w3-input" >
			ที่อยู่ในการจัดส่ง
			<input name="ex9address1" class="w3-input" type="text" value="<?php echo $objResult20['address1'];?>">
			<input name="ex9address2" class="w3-input" type="text" value="<?php echo $objResult20['address2'];?>">
			จังหวัด
			<select name="ex9province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult20["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>
			รหัสไปรษณีย์
			<input name="ex9postcode" type="text" value="<?php echo $objResult20["postcode"];?>" class="w3-input">
			โทรศัพท์
			<input name="ex9tel" type="text"  value="<?php echo $objResult20["tel"];?>" class="w3-input">
			<div class="w3-margin-bottom"></div>
		</div><!-- second half -->
	</div><!-- close so9 -->


	<div id="mo" class="w3-container city" style="display:none">
		<div class="w3-third"><!-- 1st 3rd -->
			ชื่อผู้แนะนำ
			<input name="prefer_name" class="w3-input" value="<?php echo $objResult["prefer_name"];?>" >
			ใบสั่งซื้อเลขที่
			<input name="po_no" class="w3-input" value="<?php echo $objResult["po_no"];?>" >
			กำหนดส่งตามสัญญา
			<input name="delivery_contract" class="w3-input" value="<?php echo $objResult["delivery_contract"];?>" >
			<?php
				if($objResult["clear_book_ckk"]=='1'){ ?>
					<input type="checkbox" name="clear_book_ckk" checked='checked' value="1">
				<?php } else { ?>
					<input type="checkbox" name="clear_book_ckk" value="1">
				<?php } ?>
			เคลียร์ใบจอง
			<input name="clear_book_no" class="w3-input" value="<?php echo $objResult["clear_book_no"];?>" placeholder="เลขที่" >
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
</div>
<div class="w3-third w3-container"><!-- 2nd 3rd -->

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
สถานที่ติดตั้งเครื่อง
<input name="install_place" class="w3-input" value="<?php echo $objResult["install_place"];?>" ><br />

แนบใบเสนอราคา<br />

<?php 
if($objResult["type_type"]=='1'){
?>

<input type="radio" name="type_type" checked="checked" value="1" onclick="javascript:ckk_1();" id="object6">พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7">พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5">พิมพ์ตามที่เขียน
<br />

<?php
}else if($objResult["type_type"]=='2'){
	?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6">พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" checked="checked" value="2" onclick="javascript:ckk_1();" id="object7">พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5">พิมพ์ตามที่เขียน
<br />

		<?php
}else if($objResult["type_type"]=='3'){

			?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6">พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7">พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" checked="checked" value="3" onclick="javascript:ckk_1();" id="object5">พิมพ์ตามที่เขียน
<br />

	<?php
}else {

			?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6">พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7">พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type"  value="3" onclick="javascript:ckk_1();" id="object5">พิมพ์ตามที่เขียน
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

<div id="br" class="w3-container city" style="display:none">
<?php
$sale_channel=$objResult["sale_channel"];
include "dbconnect.php";
$sql="SELECT tb_salechannel.*,tb_province.* FROM tb_salechannel LEFT JOIN tb_province ON tb_salechannel.province_id=tb_province.province_ID WHERE salechannel_ID = '".$sale_channel."'";

//echo  $sql;
//exit();

$result = mysqli_query($conn,$sql) or die(mysqli_error());
$row = mysqli_fetch_array($result);

?>
<span>วัตถุประสงค์การเบิก</span>
			<div class="w3-panel">

<?php
if($objResult['objective']=='1'){
?>
			<input type="radio" onclick="javascript:object();" name="objective" checked='checked' value="1" required> เป็นสินค้าสำรอง
			<input type="text" name="objective_des" value="<?php echo $objResult['objective_des']; ?>" class="w3-input" placeholder="ใส่รายละเอียด" style="width:90%;">
<?php }else{ ?>
			<input type="radio" onclick="javascript:object();" name="objective" value="1"  required> เป็นสินค้าสำรอง

	<?php } ?>

				<div id="dt1" style="display:none">
					<input type="text" name="objective_des" value="<?php echo $objResult['objective_des']; ?>" class="w3-input" placeholder="ใส่รายละเอียด" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel">
			
<?php
if($objResult['objective']=='2'){
?>

			<input type="radio" onclick="javascript:object();" name="objective" checked='checked' value="2"  required> สำหรับลูกค้าทดลองใช้
			<input type="text" name="objective_des" class="w3-input" value="<?php echo $objResult['objective_des']; ?>" placeholder="ใส่จำนวนวัน" style="width:90%;">
			<?php }else{ ?>
	<input type="radio" onclick="javascript:object();" name="objective" value="2"  required> สำหรับลูกค้าทดลองใช้
				<?php } ?>


				
			</div>
			<div class="w3-panel">
			
			<?php
if($objResult['objective']=='3'){
?>

			<input type="radio" onclick="javascript:object();" name="objective" value="3" checked="checked" id="object3" required> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ
			<?php }else{ ?>
			<input type="radio" onclick="javascript:object();" name="objective" value="3" id="object3" required> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ
<?php } ?>
			</div>
			<div class="w3-panel">
			
						<?php
if($objResult['objective']=='4'){
?>
			<input type="radio" onclick="javascript:object();" name="objective" checked="checked" value="4"  required> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่
			<input type="text" name="objective_des" class="w3-input" value="<?php echo $objResult['objective_des']; ?>" placeholder="ใส่เลขที่ใบงานบริการ" style="width:90%;">
			<?php }else{ ?>
			<input type="radio" onclick="javascript:object();" name="objective" value="4" id="object4" required> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่

	<?php } ?>
				
			</div><div class="w3-panel">
	<?php if($objResult['objective']=='6'){ ?>			
<input type="radio" onclick="javascript:object();" name="objective" value="6" checked="checked" required>	
	<?php }else{ ?>
<input type="radio" onclick="javascript:object();" name="objective" value="6" required>		
				<?php } ?> สินค้าฝากขาย (มีใบรับประกัน)
			</div><div class="w3-panel">
<?php if($objResult['objective']=='5'){ ?>			
			<input type="radio" onclick="javascript:object();" name="objective" checked="checked" value="5"  required> อื่น ๆ

<input type="text" name="objective_des" class="w3-input" value="<?php echo $objResult['objective_des']; ?>" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;">
			<?php }else{ ?>
			<input type="radio" onclick="javascript:object();" name="objective" value="5"  required> อื่น ๆ


	<?php } ?>
			
			
			</div>
<div class="w3-bar">
หมายเลขคำสั่งซื้อ: <input type='text' class='w3-input' name='order_id'  value="<?php echo $objResult["order_id"]; ?>">
</div>
<div class="w3-bar">
ชื่อลูกค้าตามคำสั่งซื้อ: <input type='text' class='w3-input' name='order_name' value="<?php echo $objResult["order_name"]; ?>" >
</div>
	<?php /*
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
</div>*/ ?>
</div><!-- close br -->
</div><!-- second half -->

<div class="w3-bar w3-light-grey w3-border">
  
	<a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
	<a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
	
   
</div>




<div id="pd" class="w3-container city1">

<table width="100%" border="0" class="w3-table">
<thead>
    <th><div class="w3-center"><b>รหัสสินค้า</b></div></th>
    <th><div class="w3-center"><b>ชื่อสินค้า</b></div></th>
    <th><div class="w3-center"><b>หน่วย</b></div></th>
    <th><div class="w3-center"><b>จำนวน</b></div></th>
    <th><div class="w3-center"><b>ราคาต่อหน่วย</b></div></th>
	<th><div class="w3-center"><b>ส่วนลด/หน่วย</b></div></th>
    <th><div class="w3-center"><b>ยอดรวม</b></div></th>
	<th><div class="w3-center"><b>รับประกัน (ปี)</b></div></th>
	<th><div class="w3-center"><b>หมายเลขเครื่อง</b></div></th>
	<th><div class="w3-center"><b>หมายเหตุ</b></div></th>
	<th><div class="w3-center"><b><font color ='red'>หมายเลขเครื่อง (เดิม)</font></b></div></th>
	<?php /* <th><div class="w3-center"><b>สร้างใบตรวจทาน</b></div></th>*/ ?>

</thead>
<tbody>
<?php
$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
?>
<tr>

	
<td>
<input type="hidden" name="id[<?php echo $objResult1["id"];?>]" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id']; ?>">

<input type="hidden" name="product_id[<?php echo $objResult1["id"];?>]" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

<input type='text' name ="product_code[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["sol_code"];?>" id ="product_code[<?php echo $objResult1["id"];?>]"    class="w3-input" /></td>

<td><textarea name = "product_name[<?php echo $objResult1["id"];?>]" id = "product_name[<?php echo $objResult1["id"];?>]"  class="w3-input" readonly><?php echo $objResult1["sol_name"];?></textarea></td>	
	
<td><input type='text' name = "unit_name[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[<?php echo $objResult1["id"];?>]"  class="w3-input"    readonly/></td>

<td><input type='text' name = "sale_count[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["sale_count"];?>" id = "sale_count[<?php echo $objResult1["id"];?>]"  class="w3-input" style="color:black;text-align:center"    />
	
<input type='hidden' name = "sale_countref[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_countref"];?>" id = "sale_countref[]<?php echo $objResult1["id"];?>"    />

</td>

<td>
	<input type='text' name = "product_price[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["price_per_unit"];?>" id = "product_price[<?php echo $objResult1["id"];?>]"  class="w3-input"  style="color:black;text-align:right"    />
	
	<input type='hidden' name = "product_priceref[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["price_per_unitref"];?>" id = "product_priceref[<?php echo $objResult1["id"];?>]"  />

</td>

<td><input type='text' name = "discount_unit[<?php echo $objResult1["id"];?>]" value="<?php  $discount_unit=$objResult1["discount_unit"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[<?php echo $objResult1["id"];?>]"  class="w3-input" style="color:black;text-align:right"   /></td>


<td>
<input type='text' name = "sum_amount[<?php echo $objResult1["id"];?>]" value="<?php  $sum_amount=$objResult1["sum_amount"]; echo number_format( $sum_amount,2)."";?>"  id = "sum_amount[<?php echo $objResult1["id"];?>]"  class="w3-input" style="color:black;text-align:right"   />


</td>

<td><input type='text' name = "warranty[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["war_hc"];?> <?php echo $objResult1["unit_hc"];?>" id = "warranty[<?php echo $objResult1["id"];?>]"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td style="width:10%;"><textarea name = "sn_number[<?php echo $objResult1["id"];?>]"   id = "sn_number[<?php echo $objResult1["id"];?>]"  class="w3-input" ><?php echo $objResult1["sn_number"];?></textarea></td>	

<td><textarea  name = "sale_remarkk[<?php echo $objResult1["id"];?>]"  id = "sale_remarkk[<?php echo $objResult1["id"];?>]"  class="w3-input" ><?php echo $objResult1["sale_remark"];?></textarea></td>
	
<td style="width:10%;"><textarea name = "sn_change[<?php echo $objResult1["id"];?>]"   id = "sn_change[<?php echo $objResult1["id"];?>]"  class="w3-input" ><?php echo $objResult1["sn_change"];?></textarea></td>	

	<?php if($objResult["send_erpst"]=='0'){ ?>
<td><a href="product_delete.php?ref_id=<?php echo $objResult["ref_id"];?>&id=<?php echo $objResult1["id"];?>"><img src="img/false.png" width="16" height="16" border="0" /></a></td>
<?php } ?>
</tr>



<?php
	$i++;
	}

	
if($objResult['glu_ckk']=='1'){	
	
$strSQL82 = "SELECT access_code,sol_name,unit_name FROM tb_product WHERE product_ID = '5293' ";
$objQuery82 = mysqli_query($conn,$strSQL82) or die ("Error Query [".$strSQL82."]");
$objR82 = mysqli_fetch_array($objQuery82);	
	
?>	
<tr>
<td style="width:15%;">

<input type='text' name = "product_codet1" value="<?php echo $objR82["access_code"]; ?>" id = "product_codet1" class="w3-input" readonly> 
<input type='hidden' name = "product_id1" value="<?php echo '5293'; ?>"  id = "product_id1" class="w3-input" />
</td>
<td>
<textarea  name = "product_name1"  id = "product_name1"  class="w3-input" readonly><?php echo $objR82["sol_name"]; ?></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name1" value="<?php echo $objR82["unit_name"]; ?>" id = "unit_name1"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count1"  id = "sale_count1" value="<?php echo '1'; ?>"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:10%;">
<input type='text' name = "product_price1"  id = "product_price1" value="<?php echo '0.00'; ?>" class="w3-input"  style="color:black;text-align:right" />
</td >

<td><input type='text' name = "discount_unit1"  id = "discount_unit1" value="<?php echo '0.00'; ?>" class="w3-input"  style="color:black;text-align:right" />

</td>


<td style="width:10%;"><input type='text' name = "sum_amount1"  id = "sum_amount1"  class="w3-input" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count1} * {product_price1} - {discount_unit1} * {sale_count1}'readonly/>
</td>

<td><input type='text' name = "warranty1"  id = "warranty1"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><textarea  name = "sn1"  id = "sn1"  class="w3-input"  ></textarea></td>
<td><textarea  name = "sale_remarkk1"  id = "sale_remarkk1"  class="w3-input" >เปลี่ยนเครื่องวัดน้ำตาล G-426 เป็น เครื่องวัดระดับน้ำตาลในเลือด GLUCOALL-1B ให้ลูกค้าแทน</textarea></td>
<td><textarea  name = "sn_change1"  id = "sn_change1"  class="w3-input"   ></textarea></td>
</tr>	
	

<?php } ?>
	
</tbody>
</table>




<script>
$('form').jAutoCalc({
  attribute: 'jAutoCalc',
  thousandOpts: [',', '.', ' '],
  decimalOpts: ['.', ','],
  decimalPlaces: -1,
  initFire: true,
  chainFire: true,
  keyEventsFire: false,
  readOnlyResults: true,
  showParseError: true,
  emptyAsZero: false,
  smartIntegers: false,
  onShowResult: null,
  funcs: {},
  vars: {}
});
</script>
<input type="hidden" name="hdnLine" value="<?php echo $i;?>">

</div>

<div id="cs" class="w3-container city1" style="display:none">

	<?php 
	
	$sql1 = "select * from tb_register_data where ref_id = '".$_GET["ref_id"]."'";
				$query1 = mysqli_query($conn,$sql1);
				$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
	
	if($objResult["delivery_type"]=='4'){
	?>
	
<div class="w3-quarter"><!-- first third-->
<?php

		if($objResult["delivery_type"]=='1'){
			?>
<input type="radio" name="delivery_type" checked='checked' value="1">Sale รับเอง
<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4">บริษัทจัดส่ง <br />

<?php
		}else if($objResult["delivery_type"]=='2'){
	?>
<input type="radio" name="delivery_type" value="1">Sale รับเอง
<input type="radio" name="delivery_type" checked='checked' value="2">ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4">บริษัทจัดส่ง <br />


		<?php
}else if($objResult["delivery_type"]=='3'){
		
			?>
	<input type="radio" name="delivery_type" value="1">Sale รับเอง
	<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
    <input type="radio" name="delivery_type" checked='checked' value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4">บริษัทจัดส่ง <br />

<?php
		}else if($objResult["delivery_type"]=='4'){
		?>

	<input type="radio" name="delivery_type" value="1">Sale รับเอง
	<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
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
	<?php	if($fetch1["bus_inter"]=='1'){	?>
	<input type="checkbox" name="bus_inter"  value="4" checked ='checked' id="bus_inter" >ขนส่งอินเตอร์ <br />
	<?php }else{ ?>
	<input type="checkbox" name="bus_inter"  value="4"  id="bus_inter" >ขนส่งอินเตอร์ <br />
	<?php } ?>
	
	<br \>
วันที่ส่ง
<input type="date" name="delivery_date" value="<?php echo $objResult["delivery_date"];?>" class="w3-input" >
เวลาส่ง
<input type="text" name="delivery_time" value="<?php echo $objResult["delivery_time"];?>" class="w3-input" >

</div><!-- first third-->
<div class="w3-quarter w3-container"><!-- second quarter -->


สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" cols="20" rows="1" style="width:100%;resize: none" ><?php echo $objResult["delivery_place"]; ?></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" value ="<?php echo $objResult["delivery_contact"]; ?>" class="w3-input" >
</div><!-- second third-->
<div class="w3-quarter"><!-- 3rd third-->
<?php
if ($objResult["return_date"]=='1'){
?>
<input type="checkbox" name="return" checked="checked" value="1">รับคืนสินค้า<br>
<?php
}else{
	?>
<input type="checkbox" name="return" value="1">รับคืนสินค้า<br>
<?php
}
	?>

วันที่รับคืน
<input type="date" name="return_date" value ="<?php echo $objResult["return_date"]; ?>" class="w3-input" >



<input type="text" name="return_time" value ="<?php echo $objResult["return_time"]; ?>" class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address" value ="<?php echo $objResult["return_address"]; ?>" class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact"  value ="<?php echo $objResult["return_contact"]; ?>"  class="w3-input" >
</div><!-- 3rd third-->
	
<div class="w3-container w3-third">
	<?php 
	if($objResult["send_cs"]=='2'){
	?>
<input type="checkbox" name="send_cs" checked= 'checked' value="2">&nbsp;ส่งข้อมูลไประบบลงงาน 
	<?php }else{ ?>
<input type="checkbox" name="send_cs" value="1">&nbsp;ส่งข้อมูลไประบบลงงาน 	
	<?php } ?>
	</div>
<div class="w3-container w3-third">
.
	</div>
	<div class="w3-container w3-third">
.
	</div>
	<div class="w3-container w3-third">
 วันที่ รับ-ส่ง :
      <input name="start_date" type='date' id="start_date" value="<?php echo $fetch1["start_date"]; ?>"  class="w3-input"  />

	</div><div class="w3-container w3-third">

วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="w3-input" value="<?php echo $fetch1["between_date"]; ?>" type='text' id="between_date"  />
 </div><div class="w3-container w3-third">

 เวลา :
<input id="start_time"  name="start_time" value="<?php echo $fetch1["start_time"]; ?>" class="w3-input" type="text" />
ถึง
<input id="end_time" name="end_time"  value="<?php echo $fetch1["end_time"]; ?>" class="w3-input" type="text" />

</div><div class="w3-container w3-third">


สถานะการทำงาน : 

<?php if($fetch1["status"]=='ส่ง'){ ?>

<input type='radio'  name='status' id = 'status' value='ส่ง' checked='checked'/>ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ

<?php }else if($fetch1["status"]=='รับ'){ ?>

<input type='radio'  name='status' id = 'status' value='ส่ง' />ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' checked='checked'/>รับ

<?php } ?>

</div><div class="w3-container w3-third">

สถานะ :
      <input name="status_comment" type='text' id="status_comment" value="<?php echo $fetch1["status_comment"]; ?>" size="20" class="w3-input"/>
</div><div class="w3-container w3-third">

<?php if($fetch1["fix_date"]=='1'){ ?>

<input type="checkbox"  name="fix_datetime" id = "fix_datetime" checked='checked' value="1">นัดวันและเวลาเรียบร้อยแล้ว 
<?php }else { ?>
<input type="checkbox"  name="fix_datetime" id = "fix_datetime"  value="1">นัดวันและเวลาเรียบร้อยแล้ว 

<?php } if($fetch1["no_price"]=='1'){ ?>

<input type="checkbox"  id = "no_money" name="no_money" checked="checked" value="1">ไม่ต้องเก็บเงิน

<?php }else { ?>
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน


<?php } ?>
</div><div class="w3-container w3-third">
<?php if($fetch1["call_customer"]=='1'){ ?>

<input type="checkbox"  id = "call_customer" name="call_customer"  checked="checked" value="1">โทรแจ้งลูกค้าก่อนไป
<?php }else { ?>
<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
	<?php } if($fetch1["call_employee"]=='1'){ ?>
	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" checked="checked" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
<?php }else { ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว


<?php } ?>
</div><div class="w3-container w3-third">
<?php if($fetch1["want_bus"]=='1'){ ?>
<input type="checkbox"   name="want_bus" checked="checked" value="1">ต้องการรถใหญ่
<?php }else{ ?>
	<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่

<?php } ?>
		</div><div class="w3-container w3-third">
	 <?php if($fetch1["cash"]=='1'){ ?>

<input type="checkbox"  name="cash"id = "cash" checked="checked" value="1">เก็บเงินสด
<?php }else { ?>
	<input type="checkbox"  name="cash"id = "cash"  value="1">เก็บเงินสด


<?php } ?>
		 <input name="unit_cash" type='text' class="w3-input" id="unit_cash" value="<?php echo $fetch1["unit_cash"]; ?>" size="20" rows="1" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)">  
		 </div><div class="w3-container w3-third">

<?php if ($fetch1["check_paper"]=='1'){ ?>

	<input type="checkbox"  name="check_paper" id = "check_paper" checked='checked' value="1">รับเช็ค

	<?php }else{ ?>
	<input type="checkbox"  name="check_paper" id = "check_paper" value="1">รับเช็ค

		<?php } ?>
	<input name="unit_check" type='text' class="w3-input" value="<?php echo $fetch1["unit_check"]; ?>"  id="unit_check" style="color:black;text-align:right" size="20" OnChange="JavaScript:chkNum(this)"/>
		</div><div class="w3-container w3-third">

<?php if ($fetch1["credit_card"]=='1'){ ?>
<input type="checkbox"  id = "credit_card" name="credit_card" checked="checked" value="1">รูดการ์ด 
<?php }else { ?>
<input type="checkbox"  id = "credit_card" name="credit_card" value="1">รูดการ์ด 

<?php } ?>

	<input name="unit_credit" type='text' class="w3-input"  id="unit_credit" value="<?php echo $fetch1["unit_credit"]; ?>" size="20" style="color:black;text-align:right"  OnChange="JavaScript:chkNum(this)"/> 
	</div><div class="w3-container w3-third">

<?php if ($fetch1["bill"]=='1'){ ?>

<input type="checkbox"  id = "bill" name="bill" checked="checked" value="1">วางบิล

<?php }else{ ?>
<input type="checkbox"  id = "bill" name="bill" value="1">วางบิล

	<?php } ?>
<input name="unit_bill" type='text' class="w3-input" style="color:black;text-align:right" id="unit_bill" value="<?php echo $fetch1["unit_bill"]; ?>" size="20" OnChange="JavaScript:chkNum(this)" />
</div><div class="w3-container w3-third">

<?php if ($fetch1["tran"]=='1'){ ?>

<input type="checkbox"  name="tran"id = "tran" checked="checked" value="1">ลูกค้าโอนเงินหน้างาน
<?php }else { ?>
<input type="checkbox"  name="tran"id = "tran"  value="1">ลูกค้าโอนเงินหน้างาน
	<?php } ?>

		 <input name="unit_tran" type='text' class="w3-input" id="unit_tran" size="20" value="<?php echo $fetch1["unit_tran"]; ?>" style="color:black;text-align:right" rows="1"OnChange="JavaScript:chkNum(this)"> 
</div><div class="w3-container w3-third">

<?php if ($fetch1["tran"]=='1'){ ?>

<input type="checkbox"  id = "dep" name="dep" checked="checked" value="1">อื่นๆ
<?php }else { ?>
<input type="checkbox"  id = "dep" name="dep" value="1">อื่นๆ


	<?php } ?>



<input name="dept" type='text' class="w3-input"  id="dept" value="<?php echo $fetch1["dept"]; ?>" size="20"  />
</div><div class="w3-container w3-third">

แผนก - ฝ่าย :

<input name="department_show" type='text' class="w3-input"  id="department_show" value="<?php echo $fetch1["department_show"]; ?>" size="20"  />
<?php /*
<select name="department_show" id="department_show" class="w3-input"   >
<option  value="">**โปรดเลือกแผนก-ฝ่าย**</option>
<option  value="ฝ่ายการตลาด">ฝ่ายการตลาด</option>
<option  value="ฝ่ายขาย">ฝ่ายขาย</option>
<option  value="ฝ่ายสนับสนุนการขาย ธุรการ">ฝ่ายสนับสนุนการขาย ธุรการ</option>

</select>*/ ?>

</div><div class="w3-container w3-third">
       ประเภทลูกค้า :

<input name="customer_typename" type='text' class="w3-input"  id="customer_typename" value="<?php echo $fetch1["type_customer"]; ?>" size="20"  />

<?php /*
<select name="customer_typename" id="customer_typename" class="w3-input"   >
<option  value="">**โปรดเลือกประเภทลูกค้า**</option>
<option  value="ร้านขายยา">ร้านขายยา</option>
<option  value="ลูกค้าทั่วไป">ลูกค้าทั่วไป</option>
<option  value="โรงพยาบาล">โรงพยาบาล</option>

</select>*/ ?>


</div><div class="w3-container w3-third">
       หน่วยงาน :

	   <input name="company_name" type='text' class="w3-input"  id="company_name" value="<?php echo $fetch1["type_company"]; ?>" size="20"  />
<?php /*
<select name="company_name" id="company_name" class="w3-input"   >
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="ฟาร์ ทริลเลี่ยน บจก.">ฟาร์ ทริลเลี่ยน บจก.</option>
<option  value="โนเบิล เมด บจก.">โนเบิล เมด บจก.</option>
<option  value="อื่นๆ">อื่นๆ</option>
</select>*/ ?>


</div><div class="w3-container w3-third">
       ประเภทงาน :
	   <input name="department_name" type='text' class="w3-input"  id="department_name" value="<?php echo $fetch1["department"]; ?>" size="20"  />
<?php /*
<select name="department_name" id="department_name" class="w3-input"   >
<option  value="">**โปรดเลือกประเภทงาน**</option>
<option  value="Online">Online</option>
<option  value="Sale">Sale</option>

</select>*/ ?>

</div><div class="w3-container w3-third">
ชื่อผู้ติดต่อ  :
<input name="customer_name1"  class="w3-input" type='text' value="<?php echo $fetch1["customer_name"]; ?>" id="customer_name1">

</div><div class="w3-container w3-third">
 ผู้รับสินค้า :
<input name="customer_contact" value="<?php echo $fetch1["customer_contact"]; ?>" class="w3-input" type='text' id="customer_contact">

</div><div class="w3-container w3-third">

 เบอร์โทรลูกค้า :
<input name="customer_tel"  class="w3-input" type='text' value="<?php echo $fetch1["customer_tel"]; ?>" id="customer_tel">

</div><div class="w3-container w3-third">
ชื่อโรงพยาบาล :
<input type='text'  class="w3-input" value="<?php echo $fetch1["address_name"]; ?>" name="address_name" >             


 </div>
<div class="w3-container w3-third">	

  ที่อยู่ :
<textarea   class="w3-input" name="address_send" cols="54" rows="1"><?php echo $fetch1["address_send"]; ?></textarea>

</div>
<div class="w3-container w3-third">
เลขที่เอกสาร/เลขที่เครื่อง : 
<textarea name="product_sn"  class="w3-input" id="product_sn" cols="54" rows="1"><?php echo $fetch1["product_sn"]; ?></textarea>

</div>
<div class="w3-container w3-third">
สินค้า/เอกสาร :  
<textarea name="product"  class="w3-input" id="product" cols="54" rows="1"><?php echo $fetch1["product_name"]; ?></textarea>

</div>

<div class="w3-container w3-third">
รายละเอียดเพิ่มเติม : 
     <textarea name="description"  class="w3-input" id="description" cols="54" rows="1"><?php echo $fetch1["description"]; ?></textarea>
</div>


<? }else{ ?>

	
<div class="w3-quarter"><!-- first third-->
<?php

		if($objResult["delivery_type"]=='1'){
			?>
<input type="radio" name="delivery_type" checked='checked' value="1">Sale รับเอง
<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4">บริษัทจัดส่ง <br />

<?php
		}else if($objResult["delivery_type"]=='2'){
	?>
<input type="radio" name="delivery_type" value="1">Sale รับเอง
<input type="radio" name="delivery_type" checked='checked' value="2">ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4">บริษัทจัดส่ง <br />


		<?php
}else if($objResult["delivery_type"]=='3'){
		
			?>
	<input type="radio" name="delivery_type" value="1">Sale รับเอง
	<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
    <input type="radio" name="delivery_type" checked='checked' value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4">บริษัทจัดส่ง <br />

<?php
		}else if($objResult["delivery_type"]=='4'){
		?>

	<input type="radio" name="delivery_type" value="1">Sale รับเอง
	<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
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
				?><br \>
วันที่ส่ง
<input type="date" name="delivery_date" value="<?php echo $objResult["delivery_date"];?>" class="w3-input" >
เวลาส่ง
<input type="text" name="delivery_time" value="<?php echo $objResult["delivery_time"];?>" class="w3-input" >
การส่งสินค้า<br>

		<?php

		if($objResult["big_car"]=='1'){

			?>
<input type="checkbox" name="big_car" checked='checked' value="1">ต้องการรถใหญ่<br />
<?php
		}else{
	?>
<input type="checkbox" name="big_car" value="1">ต้องการรถใหญ่<br />

		<?php
}
		if($objResult["call_before"]=='1'){
			?>
<input type="checkbox" name="call_before" checked='checked' value="1">โทรแจ้งลูกค้าก่อนไป<br />
<?php
		}else{
	?>
<input type="checkbox" name="call_before" value="1">โทรแจ้งลูกค้าก่อนไป<br />
		<?php
}
		if($objResult["maps"]=='1'){
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
			
				if($objResult["assign_date_time"]=='1'){
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
<div class="w3-quarter w3-container"><!-- second quarter -->


สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" cols="20" rows="1" style="width:100%;resize: none" ><?php echo $objResult["delivery_place"]; ?></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" value ="<?php echo $objResult["delivery_contact"]; ?>" class="w3-input" >
</div><!-- second third-->
<div class="w3-quarter"><!-- 3rd third-->
<?php
if ($objResult["return_date"]=='1'){
?>
<input type="checkbox" name="return" checked="checked" value="1">รับคืนสินค้า<br>
<?php
}else{
	?>
<input type="checkbox" name="return" value="1">รับคืนสินค้า<br>
<?php
}
	?>

วันที่รับคืน
<input type="date" name="return_date" value ="<?php echo $objResult["return_date"]; ?>" class="w3-input" >



<input type="text" name="return_time" value ="<?php echo $objResult["return_time"]; ?>" class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address" value ="<?php echo $objResult["return_address"]; ?>" class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact"  value ="<?php echo $objResult["return_contact"]; ?>"  class="w3-input" >
</div><!-- 3rd third-->

<?php } ?>

</div>



<center>
<br>
<input type="submit" name ="" value="บันทึก" class = "w3-button w3-green w3-center" onClick="this.form.action='register_adminmk_edit1.php'; submit()">

</center>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		 

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
		return "data_bill_name.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("bill_id","h_bill_id");
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