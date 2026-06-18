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
	<div class="w3-panel w3-light-grey"><h3>ใบรับสินค้า</h3></p>	
	<h5>(Received Product Form)</h5>
	</div>
	<form action="register_receivepro_so1.php" method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-bar">
		
		<?php
			include('dbconnect.php');

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

$sql1 = "SELECT *   FROM so__main where ref_id = '".$_GET["ref_id"]."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);


$strSQL1 = "SELECT * FROM  (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$sql1 = "select * from tb_register_data where ref_id = '".$_GET["ref_id"]."'";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 

		?>
		<span class="w3-light-grey w3-right"> เลขที : <?php echo $so; echo $nextId; ?></span>
		<input type="hidden" name="rp_no" class="w3-input" value="<?php echo $so; echo $nextId; ?>">
	</div>

	<div class="w3-bar w3-padding-small"></div><!-- bar -->
		<div class="w3-half 1">
	<div class="w3-bar w3-margin-bottom">

	<?php if($rs1["select_type_doc"]=='3' or $rs1["select_type_doc"]=='1'){ ?>
<input type="radio" name="type_company"  checked ='checked' value="1">&nbsp;ALL
<input type="radio" name="type_company"  value="2" >&nbsp;NBM
<?php }else if($rs1["select_type_doc"]=='4'  or $rs1["select_type_doc"]=='2'){ ?>
<input type="radio" name="type_company"   value="1">&nbsp;ALL
<input type="radio" name="type_company" checked ='checked' value="2" >&nbsp;NBM

		<?php } ?>
				</div>		
	
		<div class="w3-bar w3-margin-bottom">
			วันที่ออกเอกสาร :<input type="date" name="iv_date" value = "<?php echo $rs1["doc_release_date"]; ?>" style="width:30%;" class="w3-input"  required>
</div>
	<div class="w3-bar w3-margin-bottom">
			เลขที่เอกสาร :<input type="text" name="iv_noref" value = "<?php echo $rs1["doc_no"]; ?>" style="width:90%;" class="w3-input"  required>
			<input type="hidden" name="ref_iddoc" value = "<?php echo $rs1["ref_id"]; ?>" style="width:90%;" class="w3-input"  required>
			<input type="hidden" name="type_doc" value = "<?php echo "SOL"; ?>" style="width:90%;" class="w3-input"  required>
		<input type="hidden" name="type_customer" value="<?php echo $fetch1["type_customer"]; ?>" style="width:90%;" class="w3-input"  required>
		<input type="hidden" name="reforder_id" value="<?php echo $rs1["po_no"]; ?>" style="width:90%;" class="w3-input"  required>
</div>
<div class="w3-bar w3-margin-bottom">
			วันที่ส่งของ:<input type="date" name="delivery_date" value = "<?php echo $rs1["delivery_date"]; ?>" style="width:30%;" class="w3-input"  >
</div>			
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
if($rs1["employee_name"] == $objResuut5["sale_code"])
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
			<input type="text" name="customer" id="customer" value="<?php echo $fetch1["customer_name"]; ?>" class="w3-input" style="width:90%;"  required>
</div>

<div class="w3-bar w3-margin-bottom">
ที่อยุ่ :<textarea name="address" id="address" class="w3-input" style="width:90%;"  required><?php echo $fetch1["address_name"]; ?></textarea>
</div>

<div class="w3-bar w3-margin-bottom">
			ชื่อออกบิล
			<input type="text" name="bill_name" id="bill_name" value="<?php echo $rs1["billing_name"];?>" class="w3-input" style="width:90%;"  required>
</div>

<div class="w3-bar w3-margin-bottom">
ที่อยุ่ออกบิล:<textarea name="bill_address" id="bill_address" class="w3-input" style="width:90%;"  required><?php echo $rs1["billing_address"];?></textarea>
</div>
</div>
		
		

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

<input type="text" name="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="5%" value="<?php echo $objResult1['product_id']; ?>">

</td>

<td style="width:15%;"><textarea name = "product_name[]<?php echo $objResult1["id"];?>"   id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly><?php echo $objResult1["sol_name"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:center"  readonly/></td>

<td style="width:5%;">
	<input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    />
	
		</td>
<td style="width:10%;">
	<input type='text' name = "amount[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sum_amount"];?>" id = "amount[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    />
	
		</td>

<td style="width:10%;">

<input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input" />

</td>


</tr>



<?php
	$i++;
	}
	?>

		</table>
</div>


	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
	</div>
	</div>
	</form>
</div>
<div id="cr_bar"><?php include('foot.php'); ?></div>



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