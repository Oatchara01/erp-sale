<?php include('head.php'); ?>
<?php include('dbconnect_sale.php'); ?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>

<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 14px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 14px; color: #FF0000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
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

	
<style>
	.none {
    display:none;
	}
</style>

<div class="w3-white w3-container">
	<div class="w3-panel w3-light-grey"><h3>ใบเบิกสินค้าเพื่อสนับสนุนการขาย</h3></p>	
	<h5>(Sample Request)</h5>
	</div>
	<form action="register_supsmp1.php" method="post" name="frmMain" enctype="multipart/form-data"  onSubmit="JavaScript:return fncSubmit();" >
		
<script language="javascript">
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
	
	if(document.frmMain.start_time.value == ""){
			
		alert('กรุณาใส่เวลาส่ง');
		document.frmMain.start_time.focus();
		return false;
		}
	
		if(document.frmMain.customer_name1.value == ""){
		alert('กรุณาใส่ชื่อลูกค้า');
		document.frmMain.customer_name1.focus();
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
		
		<?php
			include('dbconnect.php');

			$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_idsmp) AS MAXID FROM hos__smp";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "RSMP";

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


		
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;



		?>
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $so; echo $nextId; ?></span>
		<input type="hidden" name="ref_idsmp" class="w3-input" value="<?php echo $so; echo $nextId; ?>">
	</div>

	<div class="w3-bar w3-padding-small"></div><!-- bar -->
		<div class="w3-half 1">
	<div class="w3-bar w3-margin-bottom">
<input type="radio" name="type_company"  checked ='checked' value="2" >&nbsp;NBM
				</div>		
	
		<div class="w3-bar w3-margin-bottom">
			วันที่คลัง  :<input type="date" name="smp_date" value = "<?php echo $today; ?>" style="width:30%;" class="w3-input"  required>
</div>
			<div class="w3-bar w3-margin-bottom">
ที่อยุ่ :<textarea name="address_name" id="address_name" class="w3-input" style="width:90%;"  required></textarea>
</div>

<div class="w3-bar w3-margin-bottom">
เขตการขาย :
<?php 
	if ($_SESSION['code']=='SS1'){
	?>
<select name="sale_code" id="sale_code" style="width:330px" class="w3-input"  required>
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
<?php
}else 	if ($_SESSION['code']=='SS2'){

	?>
<select name="sale_code" id="sale_code" style="width:330px" class="w3-input" required>
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
<?php
}else 	if ($_SESSION['code']=='SS3'){

	?>
<select name="sale_code" id="sale_code" style="width:330px" class="w3-input" required>
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss3 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>		
	
<?php
}else 	if ($_SESSION['code']=='SS5'){

	?>
<select name="sale_code" id="sale_code" style="width:330px" class="w3-input" required>
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss3 where sale_code IN ('S31','S32') ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>			
<?php
}else 	if ($_SESSION['code']=='SUP_MK'){

	?>
<select name="sale_code" id="sale_code" style="width:330px" class="w3-input"  required>
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_allwell ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


		<?php
}else 	if ($_SESSION['code']=='SUP_EN'){

	?>
<select name="sale_code" id="sale_code" style="width:330px" class="w3-input"  required>
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
<?php
}else 	if ($_SESSION['code']=='HR'){

	?>	
<select name="sale_code" id="sale_code" style="width:330px" class="w3-input"  required>
<option value="HR">HR</option>

</select>	

		<?php
}else 	{
			?>
				<select name="sale_code" id="sale_code" style="width:330px" class="w3-input"  required>
<option value="">**Please Select**</option>


<?php

$strSQL5 = "SELECT * FROM tb_team_all ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


				<?php
}
			
?>
</div>
			
<div class="w3-bar w3-margin-bottom">			
			แนบไฟล์
<input name="up_img1" style="width:90%;"  class="w3-input"  type="file">
</div>

<div class="w3-bar w3-margin-bottom">			
			
<input name="up_img2" style="width:90%;"  class="w3-input"  type="file">
</div>
<div class="w3-bar w3-margin-bottom">			
			
<input name="up_img3" style="width:90%;"  class="w3-input"  type="file">
</div>				
			
</div>
<div class="w3-half 1">
<div class="w3-bar w3-margin-bottom">
			ชื่อลูกค้า 
			<input type="text" name="customer_name" id="customer_name" class="w3-input" style="width:90%;"  required>
</div>

<div class="w3-bar w3-margin-bottom">
			Comment Sale:&nbsp;
			<textarea name="comment_sale" id="comment_sale" class="w3-input" style="width:90%;"  required></textarea>
</div>
<div class="w3-bar w3-margin-bottom">
			Comment Sup :&nbsp;
			<textarea name="comment_sup" id="comment_sup" class="w3-input" style="width:90%;"  required></textarea>
</div>
<div class="w3-bar w3-margin-bottom">
	<input type="checkbox" name="brnp_ckk" id="brnp_ckk"  value ='1'>
			เคลียร์ใบยืม เลขที่  
			<input type="text" name="brnp_no" id="brnp_no" class="w3-input" style="width:90%;"  >
</div>			
	
	
</div>
		
		

	</p>
	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
 <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
</div>


<div id="pd" class="w3-container city1">
<?php
	if($_SESSION["department"]=='วิศวกรรม'){
		include ('detail_engsmnbp.php');
	}else{	
	include ('detail_salesmpnb.php');
		}
		?>
</div>

<div id="cs" class="w3-container city1" style="display:none">

<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2" checked='checked'>&nbsp;บริษัทจัดส่ง 

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
		
&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว&nbsp;&nbsp;
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน&nbsp;&nbsp;
<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่</p>
		
	 


<?php
if($_SESSION['department']=="วิศวกรรม"){
	$department="ฝ่ายวิศวกรรม";
}else{
	$department="ฝ่ายขาย";	
}
?>

แผนก - ฝ่าย :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="department_show" value="<?php echo $department; ?>" class="button4" type='text' id="department_show">

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       ประเภทลูกค้า :
<select name="customer_typename" id="customer_typename" class="button4"   >
<option value="">**Please Select Item**</option>
<?php
$strSQL4 = "SELECT * FROM tb_typecustomer ORDER BY type_name ASC";
$objQuery4 = mysqli_query($conn,$strSQL4);
while($objResuut4 = mysqli_fetch_array($objQuery4))
{
?>
<option value="<?php echo $objResuut4["type_name"];?>"><?php echo $objResuut4["type_name"];?></option>
<?php
}
?>

</select></p>


       หน่วยงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="company_name" value="<?php echo 'โนเบิล เมด บจก.'; ?>" class="button4" type='text' id="company_name">

&nbsp;&nbsp;&nbsp;&nbsp;
<?php
if($_SESSION['department']=="วิศวกรรม"){
$sale='วิศวกรรม';
	}else{
$sale='Sale';	
}
?>
       ประเภทงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   <input name="department_name" value="<?php echo $sale; ?>"  class="button4" type='text' id="department_name">

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
   <textarea  class="button4" name="address_1" style="width:50%" > </textarea>           
</p>
ที่อยู่ในการส่งสินค้า :</p>
       
<textarea  class="button4" name="address_name1" style="width:50%" > </textarea>
</p>

  สถานที่ติดตั้งเครื่อง :</p>
<textarea   class="button4" name="address_send"  style="width:50%" rows="2"></textarea>
</p>
</p>
ชื่อผู้ติดต่อ  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name1"  class="button4" type='text' id="customer_name1">


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า :
<input name="customer_tel"  class="button4" type='text' id="customer_tel" >
</p>
เลขที่เอกสาร/เลขที่เครื่อง : </p>
<textarea name="product_sn"  class="button4" id="product_sn" style="width:50%" rows="2"></textarea>
</p>
สินค้า/เอกสาร :</p>
<textarea name="product"  class="button4" id="product" style="width:50%" rows="2"></textarea>


</p>
รายละเอียดเพิ่มเติม :</p> 
     <textarea name="description"  class="button4" id="description" style="width:50%" rows="2"></textarea>



	
</div><!-- cs -->


	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
	</div><br>
	</div>
	</form>
</div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		



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