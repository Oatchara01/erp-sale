<?php include ("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>

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

<script language="JavaScript">

var HttPRequest = false;
function doCallAjax1(bill_id,customer_name,address_name,customer_tel) {
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

document.getElementById(customer_name).value = myArr[0];
document.getElementById(address_name).value = myArr[1];
document.getElementById(customer_tel).value = myArr[2];

}
}
}
}

    
</script>

<body>
<?php

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql1 = "SELECT MAX(ref_credit) AS MAXID FROM tb_credit_note";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);
$maxId = substr($rs1['MAXID'], -4);
$maxId3 = substr($rs1['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "SR";

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


	 ?>



	<!--action="register_office1.php"-->
	<form action='register_credit_allwell1.php' method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->


			<div class="w3-container w3-bar w3-light-gray w3-margin-bottom">
		
		<div class="w3-half">
					<h4>ใบสั่งลดหนี้ (Credit Note Order)</h4>
				</div>
				
			</div>

<div class="w3-bar">
			<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $so; echo $nextId; ?></span>
		<input type="hidden" name="ref_credit" class="w3-input" value=" <?php echo $so; echo $nextId; ?>" >
	</div>

</p>
<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;
?>
<input type="radio" name="company_type" id="company_type" value = '3' checked='checked' class="button4"  >&nbsp;&nbsp; AWL&nbsp;&nbsp;
<input type="radio" name="company_type" id="company_type" value = '4'  class="button4"  >&nbsp;&nbsp; NBM</p>

วันที่ :&nbsp;&nbsp;
<input type="date" name="date_credit" id="date_credit" value ="<?php echo $today;?>" class="button4" style="width:12%;"  > 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="ttype_doc" id="ttype_doc" value = '1' checked='checked' class="button4"  >&nbsp;&nbsp; คืนสืนค้า&nbsp;&nbsp;
<input type="radio" name="ttype_doc" id="ttype_doc" value = '2'  class="button4"  >&nbsp;&nbsp; ส่วนลด&nbsp;&nbsp;


</p>
	
เลขที่ IV :&nbsp;&nbsp;
<input type="text" name="iv_no_ref" id="iv_no_ref"  class="button4" style="width:30%;"  > 
	
</p>
ID ลูกค้า :&nbsp;&nbsp;
<input type="text" name="bill_id" id="bill_id"  class="button4" style="width:30%;"   placeholder="Search ชื่อลูกค้า..."  OnChange="JavaScript:doCallAjax1('bill_id','customer_name','address_name','customer_tel');" > 
<input type="hidden" name="h_bill_id" id="h_bill_id" class="button4" style="width:30%;"  > 

&nbsp;&nbsp;&nbsp;&nbsp; ช่องทางการขาย &nbsp;&nbsp;
<select name="sale_chan" id="sale_chan"  class="button4" style="width:30%;"  >
				<option  value="">**โปรดเลือกช่องทางการขาย**</option>
				<?php
					$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
					$querychannel = mysqli_query($conn,$sqlchannel);
					while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) {
						?>
				<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>" ><?php echo $fetchchannel['salechannel_nameshort']; ?>&nbsp;&nbsp;<?php echo $fetchchannel['description_chanel']; ?></option>
				<?php } ?>
			</select>
</p>

ชื่อลูกค้า :&nbsp;&nbsp;
<input type="text" name="customer_name" id="customer_name"  class="button4" style="width:30%;"  > 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
เบอร์โทร :&nbsp;&nbsp;
<input type="text" name="customer_tel" id="customer_tel"  class="button4" style="width:30%;"  > 

</p>
ที่อยู่ :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       สาเหตุที่คืน : <br>
<textarea name="address_name" id="address_name"  class="button4" style="width:35%;"  ></textarea>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<textarea name="return_des" id="return_des"  class="button4" style="width:35%;"  ></textarea>

</p>
ชำระคืนค่าสินค้าโดย :</p>
<input type="radio" name="type_return" id="type_return"  value ='1'   class="button4"  required>&nbsp;&nbsp; เงินสด&nbsp;&nbsp;
</p>
<input type="radio" name="type_return" id="type_return"  value ='2'   class="button4"  required>&nbsp;&nbsp; โอนเงินเข้าบัญชี&nbsp;&nbsp; ธนาคาร  :&nbsp;&nbsp;
<input type="text" name="bank_name" id="bank_name"  class="button4" style="width:12%;"  >
&nbsp;&nbsp; ชื่อบัญชี  :&nbsp;&nbsp;
<input type="text" name="account_name" id="account_name"  class="button4" style="width:12%;"  >
&nbsp;&nbsp; เลขที่บัญชี  :&nbsp;&nbsp;
<input type="text" name="account_no" id="account_no"  class="button4" style="width:12%;"  >
&nbsp;&nbsp;แนบไฟล์รูป Book Bank 
<input name="book_bank"  type="file">
</p>
<input type="radio" name="type_return" id="type_return"  value ='3'   class="button4"  required>&nbsp;&nbsp; ลดหนี้จากยอดลูกหนี้ค้างชำระ&nbsp;&nbsp;
</p>
<input type="radio" name="type_return" id="type_return"  value ='4'   class="button4"  required>&nbsp;&nbsp; ไม่ต้องชำระเงิน&nbsp;&nbsp;
</p>
ผู้ขอคืนสินค้า :&nbsp;
<input type="text" name="send_return_name" id="send_return_name"  value = "<?php echo $_SESSION['name']; ?>" class="button4" style="width:12%;"  required> &nbsp;&nbsp;


วันที่ :&nbsp;
<input type="date" name="date_send_return" id="date_send_return" value ="<?php echo $today;?>" class="button4" style="width:12%;"  required>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


ผู้แทนขาย :&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="sale_name" id="sale_name" value = "<?php echo $_SESSION['name']; ?>" class="button4" style="width:12%;"  required> &nbsp;&nbsp;



วันที่ :&nbsp;
<input type="date" name="sale_date" id="sale_date" value ="<?php echo $today;?>" class="button4" style="width:12%;"  required>
</p>


เขตการขาย :&nbsp;&nbsp;
<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" required>
<option  value="">**Please Select**</option>
<option  value="(SOL99)">(SOL99)</option>
<option  value="(SOL2)">รัชดาภรณ์ สีสัน (SOL2)</option>
<option  value="(SOL1)">หทัยชนก  ไชยแสง (SOL1)</option>
<option  value="SOL3">SOL3</option>


</select>


</div>

<div class="w3-bar w3-light-grey w3-border">
 <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
 

</div>

<div id="pd" class="w3-container city1" >
	
<?php include ('product_creditsale.php')?>



</div>





<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>
<br></div>

</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	
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
		return "data_bill_name2.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("bill_id","h_bill_id");
</script> 
