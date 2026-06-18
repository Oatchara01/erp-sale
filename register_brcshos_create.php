<?php include('head.php');
?>

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

$ref_id =$_GET["ref_id"];

$sql = "SELECT *   FROM hos__consig where ref_id ='".$ref_id."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);


$strSQL1 = "SELECT * FROM  (hos__subconsig LEFT JOIN tb_product ON hos__subconsig.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);




$yearMonth = substr(date("Y")+543, -2).date("m");
$sql1 = "SELECT MAX(ref_id) AS MAXID FROM hos__consig ";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

$maxId = substr($rs1['MAXID'], -5);
$maxId3 = substr($rs1['MAXID'],-9);

$maxId1 = substr($maxId3,0,-5);

$so = "BS";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -5);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "00001"; 
$nextId = $yearMonth.$maxId1;

}

	 ?>

<div class="w3-white w3-container">
<div class="w3-panel w3-light-grey">
	<div class="w3-half">
	<h3>Borrow Sale Consignment</h3>
	</div><div class="w3-half">
		</div></div>
<form action="register_brcshos_create1.php" method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();" >
		
<script language="javascript">
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
	
	if(document.frmMain.start_time.value == ""){
			
		alert('กรุณาใส่เวลาส่ง');
		document.frmMain.start_time.focus();
		return false;
		}
	
		if(document.frmMain.customer_name.value == ""){
		alert('กรุณาใส่ชื่อลูกค้า');
		document.frmMain.customer_name.focus();
		return false;
		}
	
	if(document.frmMain.customer_tel.value == ""){
		alert('กรุณาใส่เบอร์โทรลูกค้า');
		document.frmMain.customer_tel.focus();
		return false;
		}
	if(document.frmMain.address_1.value == ""){
		alert('กรุณาใส่สถานที่ส่งสินค้า');
		document.frmMain.address_1.focus();
		return false;
		}
	
		if(document.frmMain.address_name.value == ""){
		alert('กรุณาใส่ที่อยู่ในการส่งสินค้า');
		document.frmMain.address_name.focus();
		return false;
		}
	
	if(document.frmMain.address_send.value == ""){
		alert('กรุณาใส่สถานที่ติดตั้งเครื่อง');
		document.frmMain.address_send.focus();
		return false;
		}
			
		if(document.frmMain.province_name.value == ""){
		alert('กรุณาเลือกจังหวัดที่ต้องการจัดส่ง');
		document.frmMain.province_name.focus();
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
		<br>
		
		
				<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $so; echo $nextId; ?></span>
		<input type="hidden" name="ref_id_br" class="w3-input" value="<?php echo $so; echo $nextId; ?>">
	</div>
	
	<div class="w3-bar w3-padding-small"></div><!-- bar -->
	<div class="w3-half 1">
<input type="checkbox" name="que_ckk" id="que_ckk" value="1" ><font color='red' > งานด่วน </font>
		<div class="w3-bar w3-margin-bottom">
			<span>รหัสลูกค้า</span> <input type="text" name="customer_id" id="customer_id" class="w3-input" style="width:90%;"  value="<?php echo $rs["customer_id"]; ?>" OnChange="JavaScript:doCallAjax1('customer_id','customer','address','customer_typename');"  placeholder="Search ชื่อลูกค้า..." required>
			<input type ='hidden' name="h_customer"  id="h_customer" class="w3-input" >

		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ชื่อลูกค้า/รพ.</span> <input type="text" name="customer" id="customer"  value="<?php echo $rs["customer"]; ?>" class="w3-input" style="width:90%;"  required>

		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ที่อยู่</span> <textarea name="address" id="address" class="w3-input" style="width:90%;" rows="2"><?php echo $rs["address"]; ?></textarea>
		</div>

		<div class="w3-bar w3-margin-bottom">
			<span>Sale Comment</span> <textarea name="sale_comment" id="sale_comment" class="w3-input" style="width:90%;" rows="2"><?php echo $rs["sale_comment"]; ?></textarea>
		</div>

		
		
	</div>
	<div class="w3-half 2">
		<div class="w3-bar w3-half w3-margin-bottom">
<span>วันที่</span> <input type="date" name="date_save" id="date_save" value = "<?php echo $today; ?>" class="w3-input" style="width:90%;" readonly></p>

		
แนบไฟล์ :</p>
<input name="slip1"  type="file">
</p>
<input name="slip2"  type="file">
</p>
<input name="slip3"  type="file">
</p>
<input name="slip4"  type="file">
</p>
<input name="slip5"  type="file">
</p>		


		
</div>
		
<div class="w3-bar w3-margin-bottom w3-half">

<span>วัตถุประสงค์การเบิก</span>

	<div class="w3-panel">
	<?php if ($rs["objective"]=='1'){ ?>
	<input type="radio" checked='checked'  name="objective" value="1" id="objective" required> สินค้าฝากขาย (มีใบรับประกัน)
	<?php }else{ ?>
	<input type="radio"  name="objective" value="1" id="objective" required> สินค้าฝากขาย (มีใบรับประกัน)
	<?php } ?>
	</div>
<input type="text" name="objective_des" class="w3-input" value = "<?php echo $rs["objective_des"]; ?>" placeholder="ใส่รายละเอียด" style="width:90%;">
<div>	
<!--input type="checkbox" name="ckk_war" id ="ckk_war" value="1" > สินค้าฝากขาย (มีใบรับประกัน) -->
</div>		
</div>			
</div>

	</p>
	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
   

</div>

<div id="pd" class="w3-container city1">

<table width="100%" border="0" class="w3-table">
<tr>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>ราคาต่อหน่วย</th>
	<th>ส่วนลด/หน่วย</th>
    <th>ยอดรวม</th>
	<th>รับประกัน (ปี)</th>
	<th>Cal(ครั้ง/ปี)</th>
	<th>PM (ครั้ง/ปี)</th>
    <th>หมายเหตุ</th>
	</tr>
	
<?php
	
$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>	
	
	<tr>
<td style="width:10%;">

<input type="hidden" name="id[<?php echo $objResult1["id"];?>]" class="w3-input w3-center" size="5%" value="<?php echo $objResult1['id']; ?>">

<input type="hidden" name="product_id[<?php echo $objResult1["id"];?>]" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

<input type='text' name ="product_code[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["access_code"];?>" id ="product_code[<?php echo $objResult1["id"];?>]"   class="button4" /></td>

<td style="width:15%;"><textarea name = "product_name[<?php echo $objResult1["id"];?>]" id = "product_name[<?php echo $objResult1["id"];?>]"  class="button4" readonly><?php echo $objResult1["sol_name"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[<?php echo $objResult1["id"];?>]"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "sale_count[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["count"];?>" id = "sale_count[<?php echo $objResult1["id"];?>]"  class="w3-input" style="color:black;text-align:center"    /></td>

<td style="width:8%;"><input type='text' name = "product_price[<?php echo $objResult1["id"];?>]" value="<?php  $price=$objResult1["price"]; echo number_format( $price,2)."";?>" id = "product_price[<?php echo $objResult1["id"];?>]"  class="button4"  style="color:black;text-align:right"    /></td>

<td style="width:8%;"><input type='text' name = "discount_unit[<?php echo $objResult1["id"];?>]" value="<?php  $discount_unit=$objResult1["discount"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[<?php echo $objResult1["id"];?>]"  class="button4" style="color:black;text-align:right"   /></td>


<td style="width:8%;">
<input type='text' name = "sum_amount[<?php echo $objResult1["id"];?>]" value="<?php  $sum_amount=$objResult1["amount"]; echo number_format( $sum_amount,2)."";?>"  id = "sum_amount[<?php echo $objResult1["id"];?>]"  class="button4" style="color:black;text-align:right"   />


</td>

<td style="width:5%;">
	
<?php
$ggfgf = substr($objResult1["warranty"],0,1);	
if($objResult1["war_hos"] < $ggfgf){ ?>
	<input type='text' name = "warranty[<?php echo $objResult1["id"];?>]" style="border: 1px #CC0033 solid; color:red;text-align:right" value="<?php echo $objResult1["warranty"];?>" id = "warranty[<?php echo $objResult1["id"];?>]"  class="w3-input"  >
	 <?php }else{ ?>
	<input type='text' name = "warranty[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["warranty"];?>" id = "warranty[<?php echo $objResult1["id"];?>]" style=" text-align:right"   class="w3-input" />
	<?php } ?>

</td>

<td style="width:5%;"><input type='text' name = "cal[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["cal"];?>" id = "cal[<?php echo $objResult1["id"];?>]"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:5%;"><input type='text' name = "pm[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["pm"];?>" id = "pm[<?php echo $objResult1["id"];?>]"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td style="width:10%;">
<textarea name = "sale_remarkk[<?php echo $objResult1["id"];?>]"  id = "sale_remarkk[<?php echo $objResult1["id"];?>]" class="w3-input" ><?php echo $objResult1["sale_remark"];?></textarea>
</td>
	

</tr>

<?php 
	$i++;
	} ?>

	</table>
<?php
	
if ($rs["company"]=='1'){ 

 include ('detail_brschos1.php');
 
 }else if($rs["company"]=='2'){ 

include ('detail_brschosnb1.php');
 } 
 
 ?>

</div>

<div id="cs" class="w3-container city1" style="display:none">

<input type="radio" name="delivery_type" value="1" checked='checked'  id="delivery_type" >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"   id="delivery_type" >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"   id="delivery_type" >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"   id="delivery_type" >&nbsp;บริษัทจัดส่ง <br />

</p>




 วันที่ รับ-ส่ง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="start_date" type='date' id="start_date"   class="button4" style="width:20%" /></p>


วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="button4" type='text' id="between_date" style="width:20%" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เวลา :&nbsp;&nbsp;&nbsp;&nbsp;
<input id="start_time"  name="start_time"  class="button4" type="text" style="width:10%"/>
ถึง
<input id="end_time" name="end_time"  class="button4" type="text" style="width:10%"/></p>



สถานะการทำงาน : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='radio'  name='status' id = 'status' value='ส่ง' checked='checked'/>ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
สถานะ :&nbsp;&nbsp;
      <input name="status_comment" type='text' id="status_comment"  style="width:22%" class="button4"/></p>


<input type="checkbox"  name="fix_datetime" id = "fix_datetime" value="1">นัดวันและเวลาเรียบร้อยแล้ว &nbsp;&nbsp;
<input type="checkbox"  id = "on_time" name="on_time" value="1">งานสำคัญต้องตรงเวลา&nbsp;&nbsp;


<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
		
&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
&nbsp;&nbsp;
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน&nbsp;&nbsp;
<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่</p>
		
	 
<input type="checkbox"  name="cash"id = "cash"  value="1">เก็บเงินสด : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 <input name="unit_cash" type='text' class="button4" id="unit_cash" size="20" rows="1" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)">  
		
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="checkbox"  name="check_paper" id = "check_paper" value="1">รับเช็ค : &nbsp;
	<input name="unit_check" type='text' class="button4"  id="unit_check" style="color:black;text-align:right" size="20" OnChange="JavaScript:chkNum(this)"/></p>
		

<input type="checkbox"  id = "credit_card" name="credit_card" value="1">รูดการ์ด :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="unit_credit" type='text' class="button4"  id="unit_credit"  size="20" style="color:black;text-align:right"  OnChange="JavaScript:chkNum(this)"/> 
	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox"  id = "bill" name="bill" value="1">วางบิล : &nbsp;
<input name="unit_bill" type='text' class="button4" style="color:black;text-align:right" id="unit_bill"  size="20" OnChange="JavaScript:chkNum(this)" /></p>



<input type="checkbox"  name="tran"id = "tran"  value="1">ลูกค้าโอนเงินหน้างาน :
		 <input name="unit_tran" type='text' class="button4" id="unit_tran" size="20" style="color:black;text-align:right" rows="1"OnChange="JavaScript:chkNum(this)"> 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type="checkbox"  id = "dep" name="dep" value="1">อื่นๆ : &nbsp;&nbsp;&nbsp;
<input name="dept" type='text' class="button4"  id="dept"  size="20"  /></p>

<?php
if($_SESSION['department']=="วิศวกรรม"){
	$department="ฝ่ายวิศวกรรม";
}else if($_SESSION['code']=="INT"){
	$department="ฝ่ายต่างประเทศ";	
	
}else{
	$department="ฝ่ายขาย";	
}
?>
แผนก - ฝ่าย :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="department_show" value="<?php echo $department; ?>" class="button4" type='text' id="department_show">

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       ประเภทลูกค้า :
<input name="customer_typename"  class="button4" type='text' id="customer_typename" >	</p>

<?php 
if($_SESSION['department']=="วิศวกรรม"){
$sale='วิศวกรรม';
}else if($_SESSION['code']=="INT"){
	$sale="อื่นๆ";			
	}else{
$sale='Sale';	
}

?>

     
       ประเภทงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   <input name="department_name" value="<?php echo $sale; ?>"  class="button4" type='text' id="department_name">

</p>


ชื่อผู้ติดต่อ  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name"  class="button4" type='text' id="customer_name">


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า :
<input name="customer_tel"  class="button4" type='text' id="customer_tel" >
</p>
ชื่อพนักงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="employee_name"  class="button4" type='text' value="<?php echo $_SESSION['name']; ?>" id="employee_name" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรพนักงาน :&nbsp;
<input name="employee_tel"  class="button4" type='text' id="employee_tel" >
<input name="add_by" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" type='hidden' class="button4" >

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
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['province_name']; ?>"><?php echo $objResuut5['province_name']; ?></option>
<?php } ?>
</select>
</p>
สถานที่ส่งสินค้า :</p>
         
<textarea  class="button4" name="address_1"  style="width:30%" ></textarea>

</p>
ที่อยู่ในการส่งสินค้า :</p>
            
<textarea  class="button4" name="address_name"  style="width:30%" ></textarea>

</p>

  สถานที่ติดตั้งเครื่อง :</p>
<textarea   class="button4" name="address_send"  style="width:30%" rows="2"></textarea>
</p>
เลขที่เอกสาร/เลขที่เครื่อง : </p>
<textarea name="product_sn"  class="button4" id="product_sn" style="width:30%" rows="2"></textarea>
</p>
สินค้า/เอกสาร :</p>
<textarea name="product"  class="button4" id="product" style="width:30%" rows="2"></textarea>


</p>
รายละเอียดเพิ่มเติม :</p>
     <textarea name="description"  class="button4" id="description" style="width:30%" rows="2"></textarea>



</div><!-- cs -->


	<center>

			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึก">

	</center><br>
	</div>
	
	</form>

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
		return "data_bill_name2.php?bill_search=" +encodeURIComponent(this.value);
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