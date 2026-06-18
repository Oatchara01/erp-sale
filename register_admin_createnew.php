<?php
	include('head.php'); 
	/*include "src/BarcodeGenerator.php";
	include "src/BarcodeGeneratorPNG.php";
	include "src/BarcodeGeneratorHTML.php"; */
?>

<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>

<script language="JavaScript">


function chkNumber(ele)

{

var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
ele.onKeyPress=vchar;
}

var HttPRequest = false;
function doCallAjax1(bill_id,billing_name,billing_address,billing_tel,tax_id) {
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

}
}
}
}


</script>

<script src="dist/jautocalc.js"></script>


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

<body>

<?php
$sql1 = "select * from so__main order by main_id desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); ?>
	<?php
		$strSQL = "SELECT so__main.* ,tb_salechannel.* ,tb_delivery.* ,tb_payment.*  FROM (((so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_id) LEFT JOIN tb_payment ON so__main.payment=tb_payment.payment_ID) WHERE ref_id = '".$_GET["ref_id"]."' ";
		$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT * FROM  (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
	
	?>
	<form action="register_admin_createnew1.php" method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-container w3-bar w3-light-gray w3-margin-bottom">
				<div class="w3-half">
					<h4>New Data : Admin</h4>
				</div>
				<div class="w3-half">
<a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_id"]+1;?>" class="w3-button w3-grey w3-right"><font color="330066">NEXT</font></a>
<a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_id"]-1;?>" class="w3-button w3-grey w3-right"><font color="330066">BACK</font></a>
				</div>
			</div>
		<div class="w3-container w3-half"><!-- first half -->
			<div class="w3-bar w3-border">
				<?php if ($objResult["select_type_doc"]=='1'){ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="1" onclick="javascript:object();" id="object1">&nbsp;ใบยืมสินค้า ALL</div>
				<?php }else{ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" value="1" onclick="javascript:object();"  id="object1">&nbsp;ใบยืมสินค้า ALL</div>
				<?php }
				if ($objResult["select_type_doc"]=='2'){ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="2" onclick="javascript:object();"  id="object2" >&nbsp;ใบยืมสินค้า NBM</div>
				<?php } else{ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" value="2" onclick="javascript:object();"  id="object2" >&nbsp;ใบยืมสินค้า NBM</div>
				<?php }
				if ($objResult["select_type_doc"]=='3'){ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="3" onclick="javascript:object();"  id="object3" >&nbsp;ใบสั่งขาย ALL</div>
				<?php } else{ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" value="3" onclick="javascript:object();"  id="object3" >&nbsp;ใบสั่งขาย ALL</div>
				<?php }
				if ($objResult["select_type_doc"]=='4'){ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="4" onclick="javascript:object();"  id="object4" >&nbsp;ใบสั่งขาย NBM</div>
				<?php } else{ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" value="4" onclick="javascript:object();"  id="object4">&nbsp;ใบสั่งขาย NBM</div>
				<?php } ?>
			</div>
		<div class="w3-panel">
			<?php $date = explode('-' , $objResult["register_date"] );
				  $xdate = $date[2].'-'.$date[1].'-'.$date[0];
				  /*echo $xdate;*/
			?>
			วันที่ : <span class="w3-light-grey"><?php echo datethai(date("Y-m-d")); ?></span> | เลขที่อ้างอิง : <span name="ref_id" class="w3-light-grey"><?php echo $fetch1['ref_id']+1; ?></span> <input type="hidden" name="main_id" value="<?php echo $fetch1['main_id']+1; ?>"><input type="hidden" name="ref_id" value="<?php echo $fetch1['ref_id']+1; ?>">
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
			<input name="create_order" type="hidden" id="create_order"  value="<?php echo $objResult["create_order"]; ?>" class="w3-input" /> 
			
			
			<?php /*
				<select name="delivery" class="w3-select">
				<option value="">**Please Select Item**</option>
				<?php
					$sqldeli = "SELECT tb_delivery.*,tb_sender.* FROM tb_delivery LEFT JOIN tb_sender ON tb_delivery.employee_send=tb_sender.sender_ID";
					$querydeli = mysqli_query($conn,$sqldeli);
					while ($fetchdeli = mysqli_fetch_array($querydeli,MYSQLI_ASSOC)) {
					if($objResult["delivery"] == $fetchdeli["delivery_id"]) {
						$sel = "selected";
					}
					else {
						$sel = "";
					}
				?>
				<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_id'];?>" <?php echo $sel;?>><?php echo $fetchdeli['delivery_name'];?> | <?php echo $fetchdeli['time_delivery']; ?> | <?php echo $fetchdeli['remark']; ?><?php echo $fetchdeli['packing_remark'];?></option>
				<?php } ?>
			</select>*/?>
		</div>
		<div class="w3-padding-small"></div>
		<div class="w3-bar">
			<span>การชำระเงิน</span>
			<input name="payment" type='text' class="w3-input" id="payment"  value="<?php echo $objResult["payment_name"]; ?><?php echo $objResult["bank_name"]; ?><?php echo $objResult["book_name"]; ?>" placeholder="Search การชำระเงิน..."> 
			<input name="h_payment" type="hidden" id="h_payment" value="<?php echo $objResult["payment"]; ?>" class="w3-input" />
			<?php /*
				<select name="payment" class="w3-select">
				<option value="">**Please Select Item**</option>
				<?php
					$strSQL5 = "select * from tb_payment order by payment_ID";
					$objQuery5 = mysqli_query($conn,$strSQL5);
					if (!$objQuery5) {
						echo "Failed to fetch to MySQL: " . mysqli_error();
					}
					while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
						if($objResult["payment"] == $objResuut5["payment_ID"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						}
				?>
				<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['payment_ID']; ?>"<?php echo $sel;?>><?php echo $objResuut5['payment_name']; ?> | <?php echo $objResuut5['bank_name']; ?> | <?php echo $objResuut5['book_number']; ?> | <?php echo $objResuut5['branch_bank']; ?> | <?php echo $objResuut5['book_type']; ?> | <?php echo $objResuut5['book_name']; ?> | <?php echo $objResuut5['description_payment']; ?></option>
				<?php } ?>
				</select>*/
			?>
		</div>
		<div class="w3-padding-small"></div>
		<div class="w3-bar">
			<span>หมายเหตุ</span>
			<textarea name="sale_remark"  class="w3-input" id="sale_remark"  rows="1"><?php echo $objResult['sale_remark']; ?></textarea>
		</div>
		<div class="w3-padding-small"></div>
		<div class="w3-bar">
			<span>ชื่อพนักงาน</span>
			
			<input type='text' class="w3-input" class="w3-input" name="employee_name" value="<?php echo $objResult["employee_name"]; ?>"  placeholder="Search ชื่อพนักงาน..."/>            
<input name="h_employee_name" type="hidden" id="h_employee_name" value="" class="button4" />
			<?php /*
				<select  name="employee_name" class="w3-select"  >
				<option value="">**Please Select Item**</option>
				<?php
					$emp = "select * from tb_employee where status=1 order by employee_ID";
					$sqlemp = mysqli_query($conn,$emp);
					while ($fetchemp = mysqli_fetch_array($sqlemp,MYSQLI_ASSOC)) {
					if($objResult["employee_name"] == $fetchemp["employee_ID"]) {
						$sel = "selected";
					}
					else {
						$sel = "";
					}
				?>
				<option class="w3-bar-item w3-button" value="<?php echo $fetchemp['employee_ID']; ?>"<?php echo $sel;?>><?php echo $fetchemp['employee_name']; ?></option>
				<?php } ?>
				</select>*/
			?>
		</div>
	</div><!-- first half -->
	<div class="w3-container w3-half"><!-- second half -->
		<div class="w3-bar w3-light-grey w3-border">
			<a class="w3-bar-item w3-button" onclick="openCity('st')"><font color="#404040"><b>Admin ลงทะเบียน</b></font></a>
			<a class="w3-bar-item w3-button" onclick="openCity('so')"><font color="#404040"><b>ใบสั่งขาย</b></font></a>
			<a class="w3-bar-item w3-button" onclick="openCity('mo')"><font color="#404040"><b>เพิ่มเติม</b></font></a>
			<a class="w3-bar-item w3-button"  onclick="openCity('br')"><font color="#404040"><b>ใบยืมสินค้า</b></font></a>
		</div>
	<div id="st" class="w3-container city" >
		<div class="w3-half"><!-- first right half -->
			
			<div class="w3-half w3-bar">
<input type="checkbox" name="run_id" value="1"> &nbsp;Run เลขที่เอกสาร IE,SOL<br>
<input type="checkbox" name="run_et" value="1"> &nbsp;Run เลขที่เอกสาร ET				
</div>
			<div class="w3-half w3-bar">
				เลขที่เอกสาร <input name="doc_no" class="w3-input"  type="text" >
				<?php /*$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
					    $barcode ='<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($objResult['doc_no'], $generator::TYPE_CODE_128)) . '">';
						echo $barcode;
						$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
						$border = 1;//กำหนดความหน้าของเส้น Barcode
						$height = 30;//กำหนดความสูงของ Barcode$Barcode =$generator->getBarcode($objResult['doc_no'], $generator::TYPE_CODE_128,$border,$height);
						echo $Barcode;*/
						
						/*header('Content-Type: image/png');
						if (!hasCache($file)) {
							$obj = file_get_contents($file);
							$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
							$content = $generator->getBarcode($obj, $generator::TYPE_CODE_128_A);
							generateCache($file, $content);
						}
						outputCache($file);*/
				?>
			</div>
			<div class="w3-half w3-bar">
 
เลขที่ IV รวมบิล <input name="iv_no" value="<?php echo $objResult['iv_no']; ?>" class="w3-input" type="text">
</div>

			<div class="w3-container w3-half w3-bar">
				เลขที่ลงงาน <input name="job_id" class="w3-input" value="<?php echo $objResult['job_id']; ?>" type="text">
			</div>
			<div class="w3-half w3-bar">
				วันที่ออกเอกสาร <input name="doc_release_date" class="w3-input" value="<?php echo $objResult['doc_release_date']; ?>" type="date">
			</div>
			<div class="w3-container w3-half w3-bar">
				ฝากสินค้าเลขที่ <input name="deposit_no" class="w3-input" value="<?php echo $objResult['deposit_no']; ?>" type="text">
			</div>
<?php //if ($objResult['sale_channel']=='12'){  ?>
<div class="w3-container w3-half w3-bar">
รหัสอ้างอิงการส่ง
<input name="order_refer_code" class="w3-input w3-sand" value="<?php echo $objResult['order_refer_code']; ?>"  type="text" >
</div>
<?php //} ?>

			<div class="w3-bar">
				<?php if ($objResult["select_type_doc"]=='1') { ?>
					<input type="checkbox"  checked="checked" value="1">&nbsp;
					<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม ALL</font></a>&nbsp;&nbsp;
				<?php }
				else { ?>
					<div id="dt1" style="display:none">
						<input type="checkbox"  checked="checked" value="1">&nbsp;
						<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม ALL</font></a>&nbsp;&nbsp;
					</div>
				<?php }
					if ($objResult["select_type_doc"]=='2'){ ?>
						<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
						<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;
				<?php }
				else { ?>
					<div id="dt2" style="display:none">
						<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
						<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;
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
				<?php } ?>
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
				<a href="report_summary_ptl.php?sale_channel=<?php echo $objResult["sale_channel"];?>&register_date=<?php echo  $objResult["register_date"];?>&doc_no=<?php echo  $objResult["doc_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">สรุปยืมแบบรวม PTL</font></a>
				<?php } ?>
			</div>
<?php if ($objResult["select_type_doc"]=='2') { ?>
<div class="w3-bar w3-half w3-margin-bottom">
<a href="report_summary_nbm.php?sale_channel=<?php echo $objResult["sale_channel"];?>&register_date=<?php echo  $objResult["register_date"];?>&doc_no=<?php echo  $objResult["doc_no"];?>" target="_blank" class="w3-button w3-grey w3-right" style="width:90%;"><font color="DeepPink">สรุปยืมแบบรวม NBM</font></a>
			</div>

				<?php } ?>
			<div class="w3-bar w3-half">
			<?php if ($objResult["select_type_doc"]=='1') { ?>
				<a href="report_summary_IVptl.php?sale_channel=<?php echo $objResult["sale_channel"];?>&register_date=<?php echo  $objResult["register_date"];?>&iv_no=<?php echo  $objResult["iv_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">สรุปรวม เคลียร์ยอดเงิน PTL</font></a>

				<?php } ?>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom">
			<?php if ($objResult["select_type_doc"]=='2') { ?>
				<a href="report_summary_IVnbm.php?sale_channel=<?php echo $objResult["sale_channel"];?>&register_date=<?php echo  $objResult["register_date"];?>&iv_no=<?php echo  $objResult["iv_no"];?>" target="_blank" class="w3-button w3-grey w3-right" style="width:90%;"><font color="DeepPink">สรุปรวม เคลียร์ยอดเงิน NBM</font></a>
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
		
			<input name="upload1"  type="file"><a href="upload/<?php echo $objResult['upload1']; ?>" target="_blank"><?php echo $objResult['upload1']; ?></a></p>
			<input name="upload2"  type="file"><a href="upload/<?php echo $objResult['upload2']; ?>" target="_blank"><?php echo $objResult['upload2']; ?></a></p>
			<input name="upload3"  type="file"><a href="upload/<?php echo $objResult['upload3']; ?>" target="_blank"><?php echo $objResult['upload3']; ?></a></p>
			<input name="upload4"  type="file"><a href="upload/<?php echo $objResult['upload4']; ?>" target="_blank"><?php echo $objResult['upload4']; ?></a></p>
			<input name="upload5"  type="file"><a href="upload/<?php echo $objResult['upload5']; ?>" target="_blank"><?php echo $objResult['upload5']; ?></a></p>
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
			<input name="customer_name" type="text" value="<?php echo $objResult['customer_name']; ?>" class="w3-input" readonly>
			ที่อยู่ในการจัดส่ง
			<input name="address1" class="w3-input" type="text" value="<?php echo $objResult["address1"];?>">
			<input name="address2" class="w3-input" type="text" value="<?php echo $objResult["address2"];?>">
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
<div class="w3-bar">
วัตถุประสงค์การเบิก: <input name='objective'  class='w3-input' value="<?php echo $row["salechannel_nameshort"];?>"/>
</div>
<div class="w3-bar">
หมายเลขคำสั่งซื้อ: <input type='text' class='w3-input' name='order_id'  value="<?php echo $objResult["order_id"]; ?>">
</div>
<div class="w3-bar">
ชื่อลูกค้าตามคำสั่งซื้อ: <input type='text' class='w3-input' name='order_name' value="<?php echo $objResult["order_name"]; ?>" >
</div>
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
<b>เอกสารเพิ่มเติม Lazada</b><br />
1. ใบบาร์โค้ด<br />
2. รายละเอียดลูกค้า<br />
3.<br />
4.<br />
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
	
	
<table width="100%" border="0" class="w3-table">
<thead>
    <th><div class="w3-center"><b><font color='red'>ID สินค้า</font></b></div></th>
    <th><div class="w3-center"><b>ชื่อสินค้า</b></div></th>
    <th><div class="w3-center"><b>หน่วย</b></div></th>
    <th><div class="w3-center"><b>จำนวน</b></div></th>
    <th><div class="w3-center"><b>ราคาต่อหน่วย</b></div></th>
	<th><div class="w3-center"><b>ส่วนลด/หน่วย</b></div></th>
    <th><div class="w3-center"><b>ยอดรวม</b></div></th>
	<th><div class="w3-center"><b>รับประกัน (ปี)</b></div></th>
	<th><div class="w3-center"><b>Cal (ครั้ง/ปี)</b></div></th>
	<th><div class="w3-center"><b>PM (ครั้ง/ปี)</b></div></th>
	 <th><div class="w3-center"><b>หมายเลขเครื่อง</b></div></th>
    <th><div class="w3-center"><b>หมายเหตุ</b></div></th>
	

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

<input type="text" name="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

</td>

<td><textarea name = "product_name[]<?php echo $objResult1["id"];?>" id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly><?php echo $objResult1["sol_name"];?></textarea></td>	
	
<td><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    readonly/></td>

<td><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    />
	
<input type='hidden' name = "sale_countref[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_countref"];?>" id = "sale_countref[]<?php echo $objResult1["id"];?>"    />

</td>

<td>
	<input type='text' name = "product_price[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["price_per_unit"];?>" id = "product_price[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:right"    />
	
	<input type='hidden' name = "product_priceref[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["price_per_unitref"];?>" id = "product_priceref[]<?php echo $objResult1["id"];?>"  />

</td>

<td><input type='text' name = "discount_unit[]<?php echo $objResult1["id"];?>" value="<?php  $discount_unit=$objResult1["discount_unit"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:right"   /></td>


<td>
<input type='text' name = "sum_amount[]<?php echo $objResult1["id"];?>" value="<?php  $sum_amount=$objResult1["sum_amount"]; echo number_format( $sum_amount,2)."";?>"  id = "sum_amount[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:right"   />


</td>

<td><input type='text' name = "warranty[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["warranty"];?>" id = "warranty[]<?php echo $objResult1["id"];?>"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["cal"];?>" id = "cal[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td><input type='text' name = "pm[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["pm"];?>" id = "pm[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

	<td style="width:10%;"><textarea name = "sn"   id = "sn"  class="w3-input" readonly><?php echo $objResult1["sn_number"];?></textarea></td>	
<td>
<textarea  name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>"  class="w3-input" ><?php echo $objResult1["sale_remark"];?></textarea>

</td>

</tr>



<?php
	$i++;
	}
?>
</tbody>
</table>
	
	

<?php //include ('data_product_code1.1.php') ?>

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
<div class="w3-quarter w3-container"><!-- second quarter -->
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
เวลา
<input type="text" name="return_time" value ="<?php echo $objResult["return_time"]; ?>" class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address" value ="<?php echo $objResult["return_address"]; ?>" class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact"  value ="<?php echo $objResult["return_contact"]; ?>"  class="w3-input" >
</div><!-- 3rd third-->


</div>
<center>
<input type="submit" name="submit" class="w3-button w3-teal" >
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