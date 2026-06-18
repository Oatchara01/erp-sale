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
	<form action="register_receivepro_soedit1.php" method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-bar">
		
		<?php
			include('dbconnect.php');

		
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;

$sql1 = "SELECT *   FROM hos__proreceive where rp_no = '".$_GET["rp_no"]."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);


$strSQL1 = "SELECT * FROM  (hos__subproreceive LEFT JOIN tb_product ON hos__subproreceive.product_ID=tb_product.product_id) WHERE ref_rpno = '".$_GET["rp_no"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

		?>
		<span class="w3-light-grey w3-right"> เลขที : <?php echo $rs1["rp_no"]; ?></span>
		<input type="hidden" name="rp_no" class="w3-input" value="<?php echo $rs1["rp_no"]; ?>">
	</div>

	<div class="w3-bar w3-padding-small"></div><!-- bar -->
		<div class="w3-half 1">
	<div class="w3-bar w3-margin-bottom">

	<?php if($rs1["type_company"]=='1'){ ?>
<input type="radio" name="type_company"  checked ='checked' value="1">&nbsp;AWL
<input type="radio" name="type_company"  value="2" >&nbsp;NBM
<?php }else if($rs1["type_company"]=='2'){ ?>
<input type="radio" name="type_company"   value="1">&nbsp;AWL
<input type="radio" name="type_company" checked ='checked' value="2" >&nbsp;NBM

		<?php } ?>
				</div>		
	
		<div class="w3-bar w3-margin-bottom">
			วันที่ออกเอกสาร :<input type="date" name="iv_date" value = "<?php echo $rs1["iv_date"]; ?>" style="width:30%;" class="w3-input"  required>
</div>
	<div class="w3-bar w3-margin-bottom">
			เลขที่เอกสาร :<input type="text" name="iv_noref" value = "<?php echo $rs1["iv_noref"]; ?>" style="width:90%;" class="w3-input"  required>
			<input type="hidden" name="ref_iddoc" value = "<?php echo $rs1["ref_iddoc"]; ?>" style="width:90%;" class="w3-input"  required>
			<input type="hidden" name="type_doc" value = "<?php echo $rs1["type_doc"]; ?>" style="width:90%;" class="w3-input"  required>
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
	<?php if($rs1["send_receive"]=='2'){ ?>
<input type="checkbox" name="send_receive" id="send_receive"  checked='checked' value="2"/> ส่งข้อมูลไปรับจ่าย	
	<?php }else{ ?>
<input type="checkbox" name="send_receive" id="send_receive"  value="1"/> ส่งข้อมูลไปรับจ่าย
	<?php } ?>
	
	<?php if($rs1["cancel_ckk"]=='1'){ ?>
<input type="checkbox" name="cancel_ckk" id="cancel_ckk"  checked='checked' value="1"/> ยกเลิกใบรับสินค้า	
	<?php }else{ ?>
<input type="checkbox" name="cancel_ckk" id="cancel_ckk"  value="1"/> ยกเลิกใบรับสินค้า
	<?php } ?>
		</div>
	<div class="w3-bar w3-margin-bottom">
	<?php if($rs1["show_name"]=='1'){ ?>
<input type="radio" name="show_name" id="show_name"  checked='checked' value="1"/> แสดงชื่อลูกค้าในแบบฟอร์ม	
	<?php }else{ ?>
<input type="radio" name="show_name" id="show_name"  value="1"/> แสดงชื่อลูกค้าในแบบฟอร์ม
	<?php } ?>
	</div>
	
	<div class="w3-bar w3-margin-bottom">
	<?php if($rs1["show_name"]=='2'){ ?>
<input type="radio" name="show_name" id="show_name"  checked='checked' value="2"/> แสดงชื่อออกบิลในแบบฟอร์ม	
	<?php }else{ ?>
<input type="radio" name="show_name" id="show_name"  value="2"/> แสดงชื่อออกบิลในแบบฟอร์ม
	<?php } ?>
	</div>
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
		
	&nbsp;&nbsp;&nbsp;<input type="checkbox" name="ckk_1" id="ckk_1" onClick="ck_1();" value="1"/>ปริ้นใบรับสินค้า<br/>
<div id="frm_txt_1" style="display:none;">

			<div class="w3-bar w3-half 1">
				<a href="form_scg.php?rp_no=<?php echo $rs1["rp_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">SCG</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="form_scgexpress.php?rp_no=<?php echo $rs1["rp_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">SCG EXPERIENCE</font></a>
			</div>
	
			<div class="w3-bar w3-half 2">
				<a href="form_nexter.php?rp_no=<?php echo $rs1["rp_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">NEXTER</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="form_nexterliving.php?rp_no=<?php echo $rs1["rp_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">NEXTER LIVING</font></a>
			</div>
	
	<div class="w3-bar w3-half 2">
			<a href="form_normal.php?rp_no=<?php echo $rs1["rp_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">ลูกค้าทั่วไป/ลูกค้า ร.พ.</font></a>
			</div>
	
	<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="form_nexx.php?rp_no=<?php echo $rs1["rp_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">NEXTER LIVING NEW</font></a>
			</div>
	
	<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="rece_bauen.php?rp_no=<?php echo $rs1["rp_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">DAUEN BY SCG</font></a>
			</div>
	<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="form_24shop.php?rp_no=<?php echo $rs1["rp_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">24 SHOPPING</font></a>
			</div>
			
				</p>
		</div><!-- first right half -->	

	</p>
	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
</div>


<div id="pd" class="w3-container city1">

<table width="100%" border="0" class="w3-table">
<thead>
    <th>ID สินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
	<th>ยอดรวม</th>
    <th>หมายเหตุ</th>
	<th>ชื่อสินค้า 1</th>
	<th>เลือกโชว์ชื่อ</th>

</thead>
<tbody>
<?php


$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	?>
<tr>
<td style="width:8%;">

<input type="hidden" name="id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id']; ?>">

<input type="hidden" name="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="5%" value="<?php echo $objResult1['product_id']; ?>">
<input type="text" name="access_code[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="5%" value="<?php echo $objResult1['access_code']; ?>" readonly>

</td>

<td style="width:15%;"><textarea name = "product_name[]<?php echo $objResult1["id"];?>"   id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly><?php echo $objResult1["sol_name"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:center"  readonly/></td>

<td style="width:5%;">
	<input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    />
	
		</td>

<td style="width:10%;">
	<input type='text' name = "amount[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["amount"];?>" id = "amount[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    />
	
		</td>
<td style="width:10%;">

<input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input" />

</td>
	
	<td style="width:10%;">

<input type='text' name = "proname[]<?php echo $objResult1["id"];?>"  id = "proname[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["proname"];?>" class="w3-input" />

</td>
	
<td style="width:2%;">
	<input type='text' name = "ckk_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["ckk_name"];?>" id = "ckk_name[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    />
	
		</td>	

<td  style="width:2%;"><a href="product_receive_pro.php?ref_id=<?php echo $objResult["ref_id"];?>&id=<?php echo $objResult1["id"];?>"><img src="img/false.png" width="16" height="16" border="0" /></a></td>
	

</tr>



<?php
	$i++;
	}
	?>

		</table>
</div>


	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
	</div><br>
	</div>
	</form>
</div></div>
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