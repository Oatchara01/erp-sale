<?php include ("head.php"); ?>
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

$ref_id =$_GET["ref_id"];

$sql = "SELECT *   FROM hos__so where ref_id = '".$ref_id."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);


$strSQL1 = "SELECT * FROM  (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
//echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


	 ?>



	<!--action="register_office1.php"-->
	<form  method="post" name="frmMain" >
		<div class="w3-container w3-padding-large"><!-- main div -->


			<div class="w3-container w3-bar w3-light-gray w3-margin-bottom">
		
		<div class="w3-half">
					<h4>EDIT Sale Order</h4>
				</div>
				<div class="w3-half">
					<?php
if ($rs["type_doc"]=='3'){

?>
		
<a href="report_salehosptl1.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">ใบสั่งขาย PTL</font></button></a><br />


<?php
}else if ($rs["type_doc"]=='4'){

?>


<a href="report_salehosnbm1.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
<?php

}
?>
				</div>
			</div>









<div class="w3-bar">
		
		<?php if($rs["type_doc"]=='3'){ ?>
<input type="radio" checked='checked' name="type_doc" value = "3">&nbsp;ใบสั่งขาย PTL
<input type="radio" name="type_doc"  value="4" >&nbsp;ใบสั่งขาย NBM
<?php }else if($rs["type_doc"]=='4'){ ?>

<input type="radio"  name="type_doc" value = "3">&nbsp;ใบสั่งขาย PTL
<input type="radio" name="type_doc" checked='checked' value="4" >&nbsp;ใบสั่งขาย NBM

			<?php } ?>

		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $rs["ref_id"]; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value=" <?php echo $rs["ref_id"]; ?>" >
	</div>

</p>
<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


?>


		วันที่ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name = "date_so" id="date_so" value="<?php echo $rs["date_so"];?>" class = "button4"> 
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

		
<?php if($rs["have_order"]=='1'){ ?>
				<input type="checkbox" name="have_order" checked='checked' value="1" > มีออเดอร์ฝาก เลขที่
				<?php }else{ ?>
				<input type="checkbox" name="have_order" value="1" > มีออเดอร์ฝาก เลขที่
	<?php } ?>
&nbsp;<input type="text" name = "order_no" id="date_so" value="<?php echo $rs["order_no"];?>" class = "button4"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php if($rs["have_product"]=='2'){ ?>
				<input type="checkbox" name="have_product" checked='checked' value="2" > มีสินค้า
				<?php }else{ ?>
				<input type="checkbox" name="have_product" value="1" > มีสินค้า
	<?php } 
		
	?>

	หมายเหตุ :&nbsp;
<textarea name="des_product"  class="button4" style="width:15%" id="des_product"  rows="1"><?php echo $rs["des_product"];?></textarea></p>

		</p>





ชื่อผู้แนะนำ/ร.พ./แผนก  : &nbsp;<input type="text" name="suggest" class="button4" value="<?php echo $rs["suggest"];?>" style="width:30%;" required> </p>
				
				รหัสลูกค้า  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='text' name = "bill_id"  id = "bill_id" class="button4" placeholder="Search ชื่อสินค้า..."  style="width:30%;" OnChange="JavaScript:doCallAjax1('bill_id','bill_name','bill_address','bill_tel');"   value="<?php echo $rs["bill_id"];?>" /> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id"  class="button4" readonly>



				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ชื่อที่ต้องการออกบิล :&nbsp; 
				
<input type='text' name = "bill_name"  id = "bill_name" style="width:30%;" class="button4" value="<?php echo $rs["bill_name"];?>" />
				</p>
			
					ที่อยู่ที่ใช้ในการออกบิล : &nbsp;
					
					<textarea  name = "bill_address"  id = "bill_address" style="width:30%;" rows="2" class="button4" ><?php echo $rs["bill_address"];?></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
				เบอร์โทรศัพท์ :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<input type='text' name = "bill_tel"  id = "bill_tel" style="width:30%;" class="button4" value="<?php echo $rs["bill_tel"];?>" /></p>



<?php if ($rs["full_bill"]=='1'){ ?>

<input type="checkbox" name="full_bill" checked='checked' value="1"> &nbsp;บิล VAT
<?php }else{ ?>
<input type="checkbox" name="full_bill" value="1"> &nbsp;บิล VAT

	<?php } ?>

</p>

การชำระเงิน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<select name="payment" class="button4" style="width:30%" >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_credit order by credit_id";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($rs["payment"] == $objResuut5["credit_id"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['credit_id']; ?>" <?php echo $sel;?>><?php echo $objResuut5['credit_name']; ?></option>
<?php } ?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Sales Comment :&nbsp;
<textarea name="sale_comment"  class="button4" style="width:30%" id="sale_comment"  rows="2"><?php echo $rs["sale_comment"];?></textarea></p>

เพิ่มเติมการชำระเงิน :&nbsp;&nbsp;
<input type="text" name="payment_des" id="payment_des" value ="<?php echo $rs["payment_des"];?>" class="button4" style="width:30%;"  > </p>


ใบสั่งซื้อเลขที่:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="po_no" class="button4" value ="<?php echo $rs["po_no"];?>" style="width:30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
กำหนดส่งตามสัญญา :
<input name="delivery_contract" value ="<?php echo $rs["delivery_contract"];?>"  class="button4" style="width:30%"> </p>

<?php if($rs["book_clear"]=='1'){ ?>
<input type="checkbox" name="book_clear" checked="checked" value="1">&nbsp; เคลียร์ใบจอง :
<?php }else{ ?>
<input type="checkbox" name="book_clear" value="1">&nbsp; เคลียร์ใบจอง :

	<?php } ?>



&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="book_no" value ="<?php echo $rs["book_no"];?>"  class="button4" placeholder="เลขที่" style="width:30%">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php if($rs["brn_clear"]=='1'){ ?>
<input type="checkbox" name="brn_clear" checked='checked' value="1">&nbsp;เคลียร์ใบยืมสินค้า ติดเล่ม  :
<?php }else{ ?>
<input type="checkbox" name="brn_clear" value="1">&nbsp;เคลียร์ใบยืมสินค้า ติดเล่ม  :

<?php } ?>
<input name="brn_no" value ="<?php echo $rs["brn_no"];?>"  class="button4" style="width:27%" placeholder="เลขที่" ></p>

<?php if($rs["brnp_clear"]=='1'){ ?>

<input type="checkbox" name="brnp_clear" checked='checked' value="1">&nbsp;เคลียร์ใบยืมสินค้า กระดาษต่อเนื่อง :&nbsp;

<?php }else{ ?>

<input type="checkbox" name="brnp_clear" value="1">&nbsp;เคลียร์ใบยืมสินค้า กระดาษต่อเนื่อง :&nbsp;

<?php } ?>

<input name="brnp_no" value ="<?php echo $rs["brnp_no"];?>"  class="button4" style="width:23%" placeholder="เลขที่" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php if($rs["sn_ckk"]=='1'){ ?>

<input type="checkbox" name="sn_ckk" checked='checked' value="1">&nbsp;ต้องการ SN :

<?php }else{ ?>
<input type="checkbox" name="sn_ckk" value="1">&nbsp;ต้องการ SN :

	<?php } ?>


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="sn_no" value ="<?php echo $rs["sn_no"];?>"  class="button4" style="width:30%" placeholder="เลขที่"> </p>


Sale : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
	if ($_SESSION['code']=='SS1'){
	?>
<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
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
<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
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
<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
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
				<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
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


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


<?php if($rs["with_pr"]=="1"){ ?>

<input name="with_pr" type="checkbox" checked="checked" value="1"> แนบใบเสนอราคา

<?php }else{ ?>
<input name="with_pr" type="checkbox" value="1"> แนบใบเสนอราคา

	<?php } ?>

เลขที่  : 
<input name="pr_no" class="button4"  value ="<?php echo $rs["brnp_no"];?>" style="width:28%" placeholder="เลขที่"></p>


 รายการของแถม :</p>

<textarea placeholder="คีย์เฉพาะสินค้าที่ไม่มีในสต๊อก..."  class="button4" name="product_free" style="width:30%" rows="1" ><?php echo $rs["product_free"]; ?></textarea> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<textarea placeholder="คีย์เฉพาะสินค้าที่ไม่มีในสต๊อก..."  class="button4" name="product_free1" style="width:30%" rows="1" ><?php echo $rs["product_free1"]; ?></textarea>

</p>



<textarea placeholder="คีย์เฉพาะสินค้าที่ไม่มีในสต๊อก..."  class="button4" name="product_free2" style="width:30%" rows="1" ><?php echo $rs["product_free2"]; ?></textarea> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<textarea placeholder="คีย์เฉพาะสินค้าที่ไม่มีในสต๊อก..."  class="button4" name="product_free3" style="width:30%" rows="1" ><?php echo $rs["product_free3"]; ?></textarea>
</p>

<textarea placeholder="คีย์เฉพาะสินค้าที่ไม่มีในสต๊อก..."  class="button4" name="product_free4" style="width:30%" rows="1" ><?php echo $rs["product_free4"]; ?></textarea> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<textarea placeholder="คีย์เฉพาะสินค้าที่ไม่มีในสต๊อก..."  class="button4" name="product_free5" style="width:30%" rows="1" ><?php echo $rs["product_free5"]; ?></textarea>
</p>

<textarea placeholder="คีย์เฉพาะสินค้าที่ไม่มีในสต๊อก..."  class="button4" name="product_free6" style="width:30%" rows="1" ><?php echo $rs["product_free6"]; ?></textarea> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<textarea placeholder="คีย์เฉพาะสินค้าที่ไม่มีในสต๊อก..."  class="button4" name="product_free7" style="width:30%" rows="1" ><?php echo $rs["product_free7"]; ?></textarea>
</p>


<textarea placeholder="คีย์เฉพาะสินค้าที่ไม่มีในสต๊อก..."  class="button4" name="product_free8" style="width:30%" rows="1" ><?php echo $rs["product_free8"]; ?></textarea> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<textarea placeholder="คีย์เฉพาะสินค้าที่ไม่มีในสต๊อก..."  class="button4" name="product_free9" style="width:30%" rows="1" ><?php echo $rs["product_free9"]; ?></textarea>
</p>

</p>

<fieldset><legend ><b><font color="red">ส่วนของ Admin</font></b></legend></p>

เลขที่เอกสาร  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="iv_no" class="button4" value="<?php echo $rs['iv_no']; ?>" style="width:30%;" > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;วันที่ออกเอกสาร :&nbsp; <input type="date" value="<?php echo $rs['iv_date']; ?>"  name="iv_date" id="iv_date" class="button4"   > </p>

เลขที่ลงงาน  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="job_no" value="<?php echo $rs['job_no']; ?>" class="button4" style="width:30%;" > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ฝากสินค้าเลขที่ :&nbsp; <input type="text" name="dep_no" value="<?php echo $rs['dep_no']; ?>" id="dep_no" class="button4"  style="width:30%;" > </p>

</fieldset>
</p>

<?php if($rs["type_type"]=="1"){ ?>
<input type="radio" name="type_type" checked="checked" value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />

<?php }else if($rs["type_type"]=="2"){ ?>

<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" checked="checked" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />


	<?php }else if($rs["type_type"]=="3"){ ?>

<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" checked="checked" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />


		<?php }
		if($rs["type_type"]=="3"){ ?>
		

ระบุ:
<textarea name="type_detail" class="button4" rows="2" style="width:30%"><?php echo $rs["type_detail"]; ?></textarea>

<?php } ?>

</p>


<div class="w3-bar w3-light-grey w3-border">
 <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>



</div>



<div id="pd" class="w3-container city1" >
<?php /*
<table width="100%" border="0" class="w3-table">
<thead>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>รับประกัน (ปี)</th>
	<th>Cal(ครั้ง/ปี)</th>
	<th>PM (ครั้ง/ปี)</th>
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
<td style="width:10%;">

<input type="hidden" name="id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id']; ?>">



<input type='text' name ="product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["access_code"];?>" id ="product_code[]<?php echo $objResult1["id"];?>"    class="w3-input" OnChange="JavaScript:doCallAjax('product_code[]<?php echo $objResult1["id"];?>','product_id[]<?php echo $objResult1["id"];?>','product_name[]<?php echo $objResult1["id"];?>','unit_name[]<?php echo $objResult1["id"];?>');" />
	<input type="hidden" name="product_id[]<?php echo $objResult1["id"];?>" id="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>"></td>

<td style="width:15%;"><textarea name = "product_name[]<?php echo $objResult1["id"];?>"   id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly><?php echo $objResult1["access_name"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    readonly/></td>


<td style="width:5%;"><input type='text' name = "warranty[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["warranty"];?>" id = "warranty[]<?php echo $objResult1["id"];?>"  class="w3-input"  OnKeyPress="return chkNumber(this)" readonly/></td>

<td style="width:5%;"><input type='text' name = "cal[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["cal"];?>" id = "cal[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)" readonly/></td>

<td style="width:5%;"><input type='text' name = "pm[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["pm"];?>" id = "pm[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)" readonly/></td>

<td style="width:10%;">


<input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input" readonly/>

</td>
<td style="width:10%;" >
<input type='text' name = "sn_number[]<?php echo $objResult1["id"];?>"  id = "sn_number[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sn"];?>" class="w3-input" />

</td>
</tr>



<?php
	$i++;
	}
?>
</tbody>
</table>
*/
	
	?>
	
	<?php  include('product_stock.php');  ?>
</div>




<center>
	<input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='register_stockhos_jong1.php'; submit()">

	

</center>


</form>
<div id="cr_bar"> Copyright © 2019 phar trillion co., ltd. </div>
  </div>
  <!--/div-->

  
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
		return "data_product_hos.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code","h_product_code");
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