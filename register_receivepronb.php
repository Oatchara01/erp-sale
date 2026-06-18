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

<script>

function ck_1(){
var ck_1 = document.getElementById('ckk_1');
if(ck_1.checked == true){
document.getElementById('frm_txt_1').style.display = "";
}else{
document.getElementById('frm_txt_1').style.display = "none";
}

}
	</script>

<div class="w3-white w3-container">
	<div class="w3-panel w3-light-grey"><h3>ใบรับสินค้า</h3></p>	
	<h5>(Received Product Form)</h5>
	</div>
	<form action="register_receivepro1.php" method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-bar">
		
		<?php
			include('dbconnect.php');

		
date_default_timezone_set("Asia/Bangkok");

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(rp_no) AS MAXID FROM hos__proreceive";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -3);
$maxId3 = substr($rs['MAXID'],-7);
$maxId1 = substr($maxId3,0,-3);
		
$so = "RP";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -3);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "001"; 
$nextId = $yearMonth.$maxId1;
}


		
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;

		?>
		<span class="w3-light-grey w3-right"> เลขที : <?php echo $so; echo $nextId; ?></span>
		<input type="hidden" name="rp_no" class="w3-input" value="<?php echo $so; echo $nextId; ?>">
	</div>

	<div class="w3-bar w3-padding-small"></div><!-- bar -->
		<div class="w3-half 1">
	<div class="w3-bar w3-margin-bottom">


<input type="radio" name="type_company"  checked ='checked' value="2">&nbsp;NBM

				</div>		
	
		<div class="w3-bar w3-margin-bottom">
			วันที่ออกเอกสาร :<input type="date" name="iv_date" value = "<?php echo $today; ?>" style="width:30%;" class="w3-input"  required>
</div>
	<div class="w3-bar w3-margin-bottom">
			เลขที่เอกสาร :<input type="text" name="iv_noref"  style="width:90%;" class="w3-input"  required>
			
</div>
	<div class="w3-bar w3-margin-bottom">
			วันที่ส่งของ :<input type="date" name="delivery_date" value = "<?php echo $rs1["delivery_date"]; ?>" style="width:30%;" class="w3-input"  required>		</div>
<div class="w3-bar w3-margin-bottom">
เขตการขาย :

<select name="sale_code" id="sale_code" style="width:60%" class="w3-input"  required>
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_adm ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
if($rs1["sale_code"] == $objResuut5["sale_code"])
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
</select></div>
</div>
<div class="w3-half 1">

	
<div class="w3-bar w3-margin-bottom">
			ชื่อลูกค้า 
			<input type="text" name="customer" id="customer" value="<?php echo $rs1["customer"]; ?>" class="w3-input" style="width:90%;"  required>
</div>

<div class="w3-bar w3-margin-bottom">
ที่อยุ่ :<textarea name="address" id="address" class="w3-input" style="width:90%;"  required><?php echo $rs1["address"]; ?></textarea>
</div>

<div class="w3-bar w3-margin-bottom">
ชื่อออกบิล
<input type="text" name="bill_name" id="bill_name" value="<?php echo $rs1["bill_name"];?>" class="w3-input" style="width:90%;"  required>
</div>

<div class="w3-bar w3-margin-bottom">
ที่อยุ่ออกบิล:<textarea name="bill_address" id="bill_address" class="w3-input" style="width:90%;"  required><?php echo $rs1["bill_address"];?></textarea>
</div>
</div>
		

	</p>
	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
</div>


<div id="pd" class="w3-container city1">

<?php include('receivepronb.php'); ?>

</div>


	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
	</div><br>
	</div>
	</form>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	

        </script>

	