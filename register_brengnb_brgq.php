<?php 
include('head.php');
include('dbconnect.php');
$po_no = $_GET['po_no'];
if($po_no == ''){ ?>
<script>alert('โปรดเลือกเลขที่ใบสั่งซื้อ PO เป็นลำดับแรก !!');</script>
<?php } ?>
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


$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id_br) AS MAXID FROM in__br ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = substr($rs['MAXID'], -5);
$maxId3 = substr($rs['MAXID'],-9);

$maxId1 = substr($maxId3,0,-5);

$so = "BQ";

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

$strSQL_pomain = "SELECT customer_id FROM po__main WHERE po_no = '".$po_no."' ";
$objQuery_pomain = mysqli_query($inter,$strSQL_pomain);
$objResult_pomain = mysqli_fetch_array($objQuery_pomain);


$strSQLcus = "SELECT customer_name,cus_address FROM tb_customer WHERE customer_id = '".$objResult_pomain['customer_id']."' ";
$objQuerycus = mysqli_query($conn,$strSQLcus) or die ("Error Query [".$strSQLcus."]");
$objResultcus = mysqli_fetch_array($objQuerycus);


$strSQL1 = "SELECT ref_id,po_no FROM in__main WHERE po_no = '".$po_no."' and iv_no LIKE '%IO%' and close_br='0' ORDER BY po_no DESC ";	//echo $strSQL_po01;
$objQuery1 = mysqli_query($new,$strSQL1);
while($objResult1 = mysqli_fetch_array($objQuery1)) {
	
$strSQL4 = "SELECT * FROM  in__sbmain  WHERE ref_idd = '".$objResult1['ref_id']."' and ckk_check ='0'";
$objQuery4 = mysqli_query($new,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);
	
if($Num_Rows4=='0'){	

$strSQL =  "Update in__main set close_br='1'  where ref_id='".$objResult1['ref_id']."'";
$objQuery = mysqli_query($new,$strSQL) or die(mysqli_error());	
	
}
	
while($objResult4 = mysqli_fetch_array($objQuery4)) {
		
    $strSQL31 = "SELECT *,sum(count) as sum_count FROM  in__subbr  WHERE po_no = '".$po_no."' and product_id = '".$objResult4['product_id']."' ";
    $objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
    $objResult31 = mysqli_fetch_array($objQuery31);

    $count_item = $objResult4['sale_count']-$objResult31['sum_count'];
        if($count_item < 1){
            $strSQL11 =  "Update in__sbmain set ckk_check = '1'  where ref_idd='".$objResult1['ref_id']."' and product_id = '".$objResult4['product_id']."' ";
            $objQuery11 = mysqli_query($new,$strSQL11);
            echo $strSQL11;
        }
    
	}
  }
	 ?>

<div class="w3-white w3-container">
	<div class="w3-panel w3-light-grey"><h3>Register Borrow Order</h3></div>
	<form action="register_breng1_breq.php" method="post" name="frmMain" enctype="multipart/form-data" 
		   onSubmit="JavaScript:return fncSubmit();" >
  
	<div class="w3-bar">
		<input type="radio" name="company" value="2" checked='checked' required>ใบยืม NBM <br>
		<input type="hidden" name="type_breng" id="type_breng" value="2"  required> <!-- ใบยืมสินค้าตรวจเช็ค (BREQ)  -->
		<br>
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $so; echo $nextId; ?></span>
		<input type="hidden" name="ref_id_br" class="w3-input" value="<?php echo $so; echo $nextId; ?>">
	</div>
	
	<div class="w3-bar w3-padding-small"></div><!-- bar -->
	<div class="w3-half 1">
		<div class="w3-bar w3-margin-bottom" style="display: none;"><span>รหัสลูกค้า</span> <input type="text" name="customer_id" id="customer_id" class="w3-input" style="width:90%;"  value="<?php if($po_no != ''){ echo $objResult_pomain['customer_id']; } ?>" placeholder="Search ชื่อลูกค้า..." ><input type ='hidden' name="h_customer"  id="h_customer" class="w3-input" value="<?php echo $objResult_pomain['customer_id'];?>"></div>
		<div class="w3-bar w3-margin-bottom"><span>ชื่อลูกค้า/รพ.</span> <input type="text" name="customer" id="customer" class="w3-input" style="width:90%;" value="<?php echo $_SESSION['name'].' '.$_SESSION['surname'];?>" required></div>
		<div class="w3-bar w3-margin-bottom"><span>ที่อยู่</span> <textarea name="address" id="address" class="w3-input" style="width:90%;" rows="2"><?php if($po_no != ''){ echo $objResultcus["cus_address"]; } ?></textarea></div>
		<div class="w3-bar w3-margin-bottom"><span>Sale Comment</span> <textarea name="sale_comment" id="sale_comment" class="w3-input" style="width:90%;" rows="2"></textarea></div>
		
		 &nbsp;ต้องการเอกสารแนบบิล<br>

<input type="checkbox" name="ref_1"  id="ref_1" value="1"> &nbsp;เตรียมเอกสาร N-Health&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_2"  id="ref_2" value="1"> &nbsp;เตรียมเอกสารตามสเปคใบเสนอราคา&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_3"  id="ref_3" value="1"> &nbsp;ใบ อย.&nbsp;&nbsp;&nbsp;<br>

<input type="checkbox" name="ref_4"  id="ref_4" value="1">&nbsp;ใบตัวแทนจำหน่าย&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_5"  id="ref_5" value="1"> &nbsp;ใบช่างอบรม&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_6"  id="ref_6" value="1"> &nbsp;ใบนำเข้าสินค้า&nbsp;&nbsp;&nbsp;<br>

<input type="checkbox" name="ref_7"  id="ref_7" value="1"> &nbsp;ใบ CER เครื่องมือที่ใช้ทดสอบ&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_8"  id="ref_8" value="1"> &nbsp;ใบ PM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ref_9"  id="ref_9" value="1"> &nbsp;ใบ CAL&nbsp;&nbsp;&nbsp;<br>
<input type="checkbox" name="ref_11"  id="ref_11" value="1"> &nbsp;ใบประเมินสินค้า&nbsp;&nbsp;&nbsp;

<input type="checkbox" name="ref_10"  id="ref_10" value="1"> &nbsp;อื่น ๆ&nbsp;&nbsp;&nbsp;&nbsp;
<input name="ref_des" id="ref_des"   class="button4" style="width:30%">
</p>
		
	</div>
	<div class="w3-half 2">
		<div class="w3-bar w3-half w3-margin-bottom">
			<span>วันที่</span> <input type="date" name="date_br" id="date_br" value = "<?php echo $today; ?>" class="w3-input" style="width:90%;" required></p>

เลขที่ใบสั่งซื้อ PO <font color="red">*</font>
<select name="po_no" id="po_no" class="w3-select w3-border w3-round-xxlarge" onchange="location = this.value;" required>
<?php if($po_no == ''){?><option value="">select</option><?php } else { ?><option value="<?=$po_no;?>"><?=$po_no;?></option><?php } ?>
<?php
$strSQL_po = "SELECT DISTINCT po_no FROM in__main where close_br ='0' ORDER BY po_no DESC ";
$objQuery_po = mysqli_query($new,$strSQL_po);
while($objResult_po = mysqli_fetch_array($objQuery_po)){
    $strSQL_cpny = "SELECT company FROM po__main WHERE po_no = '".$objResult_po['po_no']."' and  company = '2' ";
	$objQuery_cpny = mysqli_query($inter,$strSQL_cpny);
    $num_cpny = mysqli_num_rows($objQuery_cpny);
	$objResult_cpny = mysqli_fetch_array($objQuery_cpny);
if($num_cpny >= 1){
?>
	<option value="register_brengnb_brgq.php?po_no=<?=$objResult_po['po_no'];?>"><?=$objResult_po['po_no'];?></option>
<?php 
} // num_cpny
} // while
 ?>
</select>

<input type="checkbox" name="sn_ckk" value="1">&nbsp;ต้องการ SN: <input name="sn" class="w3-input" >
เลขที่ CM <input name="cm_no" id ="cm_no" class="w3-input" >
แนบไฟล์ :</p>
<input name="slip1"  type="file"></p>
<input name="slip2"  type="file"></p>
<input name="slip3"  type="file"></p>
<input name="slip4"  type="file"></p>
<input name="slip5"  type="file"></p>		
		</div>
		<div class="w3-bar w3-margin-bottom w3-half">
			<span>วัตถุประสงค์การเบิก</span>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="1" id="object1" required> เป็นสินค้าสำรอง <div id="dt1" style="display:none"><input type="text" name="objective_des1" class="w3-input" placeholder="ใส่รายละเอียด" style="width:90%;"></div></div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2" required> สำหรับลูกค้าทดลองใช้ <div id="dt2" style="display:none"><input type="text" name="objective_des2" class="w3-input" placeholder="ใส่จำนวนวัน" style="width:90%;"></div></div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="3" id="object3" required> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ </div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="4" id="object4" required> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่
			<div id="dt4" style="display:none"><input type="text" name="objective_des4" class="w3-input" placeholder="ใส่เลขที่ใบงานบริการ" style="width:90%;"></div></div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="5" id="object5" required> อื่น ๆ<div id="dt5" style="display:none"><input type="text" name="objective_des5" class="w3-input" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;"></div></div>
		</div>
	</div>
	</p>
<div class="w3-bar w3-light-grey"><font class="w3-bar-item w3-button" color="#404040"><b>รายการสินค้า</b></font></div>
<section>
<table class="w3-table w3-striped">
<tr>
		<th style="width: 5%;"><input style="width:10px;height:10px;" type="checkbox" checked><small>=ยืม</small></th>
		<th style="width: 25%;">Product</th>
		<th style="width: 10%;">ยอดรับเข้า</th>
		<th style="width: 15%;">Borrowing</th>
		<th style="width: 15%;">Price</th>
		<th style="width: 15%;">Time</th>
		<th style="width: 15%;">หมายเหตุ</th>
	</tr>
<?php
$strSQL_po01 = "SELECT ref_id,po_no FROM in__main WHERE po_no = '".$po_no."' and iv_no LIKE '%IO%' ORDER BY po_no DESC ";	//echo $strSQL_po01;
$objQuery_po01 = mysqli_query($new,$strSQL_po01);
$objResult_po01 = mysqli_fetch_array($objQuery_po01);
echo $objResult_po01['ref_id'];
$num0 = 1;
	$strSQL_item01 = "SELECT * FROM  in__sbmain  WHERE ref_idd = '".$objResult_po01['ref_id']."' and ckk_check ='0' ";
    $objQuery_item01 = mysqli_query($new,$strSQL_item01) or die ("Error Query [".$strSQL_item01."]");
    while($objResult_item01 = mysqli_fetch_array($objQuery_item01)) {
    
	$strSQL2 = "SELECT sol_name,sol_code,access_code,express_code,unit_name,war_hc FROM  tb_product  WHERE product_ID = '".$objResult_item01['product_id']."' ";
    $objQuery2 = mysqli_query($new,$strSQL2) or die ("Error Query [".$strSQL2."]");
    $objResult2 = mysqli_fetch_array($objQuery2);

	$strSQL3 = "SELECT *,sum(count) as sum_count FROM  in__subbr  WHERE po_no = '".$po_no."' and product_id = '".$objResult_item01['product_id']."' ";
    $objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
    $objResult3 = mysqli_fetch_array($objQuery3);
    
?>
</form>
<tr>
<td>
    <input type="checkbox" name="check_in[<?=$num0;?>]" id="check_in[<?=$num0;?>]" value="1" checked>
    <input type="hidden" name="key[<?=$num0;?>]" id="key[<?=$num0;?>]" value="<?=$num0;?>">
    <input type="hidden" name="ref_id_stock" id="ref_id_stock" value="<?=$objResult_po01['ref_id'];?>">
    <input type="hidden" name="product_codet[<?=$num0;?>]" id="product_codet[<?=$num0;?>]" value="<?php echo $objResult_item01['product_codesame'];?>">
    <input type="hidden" name="product_id[<?=$num0;?>]" id="product_id[<?=$num0;?>]" value="<?php echo $objResult_item01['product_id'];?>">
</td>

<td style="text-align: left;">
<b>รหัสสินค้า</b> : <br><font style="color: #FF8080;"><?php echo $objResult2['access_code'];?></font><br>
<b>ชื่อสินค้า</b> : <br><font style="color: #FF8080;"><?php echo $objResult2['sol_name'];?></font><input type="hidden" name="product_name[<?=$num0;?>]" id="product_name[<?=$num0;?>]" value="<?php echo $objResult2['sol_name'];?>"><!-- ชื่อสินค้า --><br>
<b>หน่วย</b> : <br><font style="color: #FF8080;"><?php echo $objResult2['unit_name'];?></font><input type="hidden" name="unit_name[<?=$num0;?>]" id="unit_name[<?=$num0;?>]" value="<?php echo $objResult2['unit_name'];?>"><!-- หน่วย -->
</td>

<td style="text-align: center;"><?php echo $objResult_item01['sale_count'];?><input type="hidden" name="sale_count_main[<?=$num0;?>]" id="sale_count_main[<?=$num0;?>]" value="<?php echo $objResult_item01['sale_count'];?>"></td><!-- จำนวนรับเข้า -->

<td style="text-align: left;vertical-align: top;">
<b>จำนวนที่ต้องการยืม</b> : <input style="text-align:right; width: 100%; background-color:#ffffdf ;" type="number" name="sale_count[<?=$num0;?>]" id="sale_count<?=$num0;?>" onchange="calc<?=$num0;?>()" max="<?php echo $objResult_item01['sale_count']-$objResult3['sum_count'];?>" placeholder="จำนวนที่ต้องการยืม"><br>
<b>คงเหลือให้ยืม</b> : <br><input style="text-align:right; width: 100%; cursor: no-drop;" type="text" value="<?php echo $objResult_item01['sale_count']-$objResult3['sum_count'];?>" disabled><br>
<b>ยืมไปก่อนหน้า</b> : <br><input style="text-align:right; width: 100%; cursor: no-drop;" type="text" value="<?php echo $objResult3['sum_count'];?>" disabled>
</td><!-- Borrowing	 -->

<td style="text-align: left;vertical-align: top;">
<b>ราคาต่อหน่วย	</b> : <br><input style="text-align:right; width: 100%; background-color:#ffffdf ;" type="number" name="product_price[<?=$num0;?>]" id="product_price<?=$num0;?>" onchange="calc<?=$num0;?>()" placeholder="ราคาต่อหน่วย">
<b>ราคารวม </b> : <input style="cursor: no-drop; text-align:right; width: 100%;" type="text" name="sum_amount[<?=$num0;?>]" id="sum_amount<?=$num0;?>" placeholder="ยอดรวม"  readonly>
</td><!-- Price -->

<td style="text-align: left; vertical-align: top;">
    <b>ระยะเวลายืม</b> : <input style="width: 100%;text-align:right; background-color:#ffffdf ;" type="text" name="br_period[<?=$num0;?>]" id="br_period[<?=$num0;?>]" placeholder="ระยะเวลายืม">
    <b>รับประกัน</b> : <input style="width: 100%;text-align:right; cursor: no-drop;" type="text" name="warranty[<?=$num0;?>]" id="warranty[<?=$num0;?>]" value="<?php echo $objResult2['war_hc'];?>" placeholder="ปี" readonly><!-- รับประกัน --><br>
</td><!-- Warranty -->

<td style="text-align: left; "><textarea style="width: 100%; height: 150px; background-color:#ffffdf ;" name="sale_remarkk[<?=$num0;?>]" id="sale_remarkk[<?=$num0;?>]" rows="2" placeholder="หมายเหตุ"></textarea></td><!-- หมายเหตุ -->
</tr>
<?php 
$num0++;
} // objResult_item01
?> 
</table>
<script>
	function calc1() {
    let num1 = Number(document.querySelector("#sale_count1").value);
    let num2 = Number(document.querySelector("#product_price1").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount1").value = sum;
}
function calc2() {
    let num1 = Number(document.querySelector("#sale_count2").value);
    let num2 = Number(document.querySelector("#product_price2").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount2").value = sum;
}
function calc3() {
    let num1 = Number(document.querySelector("#sale_count3").value);
    let num2 = Number(document.querySelector("#product_price3").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount3").value = sum;
}
function calc4() {
    let num1 = Number(document.querySelector("#sale_count4").value);
    let num2 = Number(document.querySelector("#product_price4").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount4").value = sum;
}
function calc5() {
    let num1 = Number(document.querySelector("#sale_count5").value);
    let num2 = Number(document.querySelector("#product_price5").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount5").value = sum;
}
function calc6() {
    let num1 = Number(document.querySelector("#sale_count6").value);
    let num2 = Number(document.querySelector("#product_price6").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount6").value = sum;
}
function calc7() {
    let num1 = Number(document.querySelector("#sale_count7").value);
    let num2 = Number(document.querySelector("#product_price7").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount7").value = sum;
}
function calc8() {
    let num1 = Number(document.querySelector("#sale_count8").value);
    let num2 = Number(document.querySelector("#product_price8").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount8").value = sum;
}
function calc9() {
    let num1 = Number(document.querySelector("#sale_count9").value);
    let num2 = Number(document.querySelector("#product_price9").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount9").value = sum;
}
function calc10() {
    let num1 = Number(document.querySelector("#sale_count10").value);
    let num2 = Number(document.querySelector("#product_price10").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount10").value = sum;
}
function calc11() {
    let num1 = Number(document.querySelector("#sale_count11").value);
    let num2 = Number(document.querySelector("#product_price11").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount11").value = sum;
}
function calc12() {
    let num1 = Number(document.querySelector("#sale_count12").value);
    let num2 = Number(document.querySelector("#product_price12").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount12").value = sum;
}
function calc13() {
    let num1 = Number(document.querySelector("#sale_count13").value);
    let num2 = Number(document.querySelector("#product_price13").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount13").value = sum;
}
function calc14() {
    let num1 = Number(document.querySelector("#sale_count14").value);
    let num2 = Number(document.querySelector("#product_price14").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount14").value = sum;
}
function calc15() {
    let num1 = Number(document.querySelector("#sale_count15").value);
    let num2 = Number(document.querySelector("#product_price15").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount15").value = sum;
}
function calc16() {
    let num1 = Number(document.querySelector("#sale_count16").value);
    let num2 = Number(document.querySelector("#product_price16").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount16").value = sum;
}
function calc17() {
    let num1 = Number(document.querySelector("#sale_count17").value);
    let num2 = Number(document.querySelector("#product_price17").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount17").value = sum;
}
function calc18() {
    let num1 = Number(document.querySelector("#sale_count18").value);
    let num2 = Number(document.querySelector("#product_price18").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount18").value = sum;
}
function calc19() {
    let num1 = Number(document.querySelector("#sale_count19").value);
    let num2 = Number(document.querySelector("#product_price19").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount19").value = sum;
}
function calc20() {
    let num1 = Number(document.querySelector("#sale_count20").value);
    let num2 = Number(document.querySelector("#product_price20").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount20").value = sum;
}
function calc21() {
    let num1 = Number(document.querySelector("#sale_count21").value);
    let num2 = Number(document.querySelector("#product_price21").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount21").value = sum;
}
function calc22() {
    let num1 = Number(document.querySelector("#sale_count22").value);
    let num2 = Number(document.querySelector("#product_price22").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount22").value = sum;
}
function calc23() {
    let num1 = Number(document.querySelector("#sale_count23").value);
    let num2 = Number(document.querySelector("#product_price23").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount23").value = sum;
}
function calc24() {
    let num1 = Number(document.querySelector("#sale_count24").value);
    let num2 = Number(document.querySelector("#product_price24").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount24").value = sum;
}
function calc25() {
    let num1 = Number(document.querySelector("#sale_count25").value);
    let num2 = Number(document.querySelector("#product_price25").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount25").value = sum;
}
function calc26() {
    let num1 = Number(document.querySelector("#sale_count26").value);
    let num2 = Number(document.querySelector("#product_price26").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount26").value = sum;
}
function calc27() {
    let num1 = Number(document.querySelector("#sale_count27").value);
    let num2 = Number(document.querySelector("#product_price27").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount27").value = sum;
}
function calc28() {
    let num1 = Number(document.querySelector("#sale_count28").value);
    let num2 = Number(document.querySelector("#product_price28").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount28").value = sum;
}
function calc29() {
    let num1 = Number(document.querySelector("#sale_count29").value);
    let num2 = Number(document.querySelector("#product_price29").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount29").value = sum;
}
function calc30() {
    let num1 = Number(document.querySelector("#sale_count30").value);
    let num2 = Number(document.querySelector("#product_price30").value);
    let sum = (num1 * num2);
    document.getElementById("sum_amount30").value = sum;
}

</script>

</section>

<center><input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึก"></center><br></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>
