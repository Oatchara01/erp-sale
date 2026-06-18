<?php include ("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>

<script language="JavaScript">

var HttPRequest = false;
function doCallAjax1(bill_id,bill_name,bill_address,bill_tel,tax_id,pre_name) {
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

document.getElementById(bill_name).value = myArr[0];
document.getElementById(bill_address).value = myArr[1];
document.getElementById(bill_tel).value = myArr[2];
document.getElementById(tax_id).value = myArr[3];
document.getElementById(pre_name).value = myArr[10];
	
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



function ckk_2() {
		if (document.getElementById('object8').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
		else if (document.getElementById('object9').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
		else if (document.getElementById('object10').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
			else if (document.getElementById('object11').checked) {
			document.getElementById('dv1').style.display = 'none';
			document.getElementById('dv2').style.display = 'block';
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

<body>
<?php

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT * FROM hos__po where ref_id ='".$_GET["ref_id"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_array($qry);

	?>

	<!--action="register_office1.php"-->
	<form action='' method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();" >
		
<script language="javascript">
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
	
		
	document.frmMain.submit();
}


</script>
<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><div class="w3-half">
			<h4>Register PO Sale</h4></div>

			
				<div class="w3-half">
		<?php if($rs["send_sale"]=='0'){ ?>			
<a href="sendsale_line.php?ref_id=<?php echo $rs["ref_id"];?>&sale_code=<?php echo $rs["sale_code"]; ?>&bill_name=<?php echo $rs["bill_name"]; ?>&po_no=<?php echo $rs["po_no"]; ?>"  class="w3-button w3-yellow w3-right"><font color="red">ส่งข้อมูลให้ Sale</font></a>
					
					<?php } ?>
			</div></div>
			
<div class="w3-bar">
	<?php if($rs["type_doc"]=='3'){ ?>	
<input type="radio" checked='checked' name="type_doc" value = "3"  >&nbsp;PO AWL
<input type="radio"  name="type_doc" value = "4">&nbsp;PO NBM
<?php }else if($rs["type_doc"]=='4'){ ?>	
<input type="radio"  name="type_doc" value = "3" >&nbsp;PO AWL
<input type="radio" checked='checked' name="type_doc" value = "4"  >&nbsp;PO NBM	
	<?php } ?>
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $rs["ref_id"]; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $rs["ref_id"]; ?>">
	</div>

</p>

		<div class="w3-half 1">

		วันที่ : <input type="date" name = "date_po" id="date_po" style="width:90%;"  value="<?php echo $rs["date_po"]; ?>" class = "w3-input" readonly> 	
		รหัสลูกค้า  : 

<input type='text' name = "bill_id"  id = "bill_id" value="<?php echo $rs["bill_id"]; ?>" class="w3-input" placeholder="Search ชื่อลูกค้า..."  style="width:90%;" OnChange="JavaScript:doCallAjax1('bill_id','bill_name');" readonly> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id"  class="button4" readonly>	
			
			
Sale : 
<select name="sale_code" id="sale_code" style="width:90%" class="w3-input" readonly>
<option value="">**Please Select**</option>

<?php

$strSQL5 = "SELECT * FROM tb_team_adm  ORDER BY sale_code ASC";
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

?>
<option value="<?php echo $objResuut5["sale_code"];?>"  <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
			
			
</div>
		
		<div class="w3-half 1">
		เลขที่ PO  : <input type='text' name = "po_no" value="<?php echo $rs["po_no"]; ?>" id = "po_no" style="width:90%;" class="w3-input" readonly>
ชื่อที่ต้องการออกบิล :
				
<input type='text' name = "bill_name"  id = "bill_name" value="<?php echo $rs["bill_name"]; ?>" style="width:90%;" class="w3-input" readonly>
			
			หมายเหตุ
<textarea name="remark" id="remark" class="w3-input" rows="2" style="width:90%" readonly><?php echo $rs["remark"]; ?></textarea>
						
</div>
		
แนบไฟล์ </p>
<input name="img_po1"  type="file"><a href="upload/<?php echo $rs['img_po1']; ?>" target="_blank"><?php echo $rs['img_po1']; ?></a>
</p>
<input name="img_po2"  type="file"><a href="upload/<?php echo $rs['img_po2']; ?>" target="_blank"><?php echo $rs['img_po2']; ?></a>
</p>
<input name="img_po3"  type="file"><a href="upload/<?php echo $rs['img_po3']; ?>" target="_blank"><?php echo $rs['img_po3']; ?></a>
</p>
<input name="img_po4"  type="file"><a href="upload/<?php echo $rs['img_po4']; ?>" target="_blank"><?php echo $rs['img_po4']; ?></a>
</p>
<input name="img_po5"  type="file"><a href="upload/<?php echo $rs['img_po5']; ?>" target="_blank"><?php echo $rs['img_po5']; ?></a>
</p>



</div>

</form>
<div id="cr_bar"> <?php include ("foot.php"); ?></div>
  
  <!--/div-->

  

