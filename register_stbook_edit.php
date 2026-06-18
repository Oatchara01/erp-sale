<?php include('head.php'); ?>
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

<div class="w3-container">
	<div class="w3-panel w3-light-grey"><h3>ใบจองสินค้า</h3></p>	
	<h5>(Product Booking)</h5>
		
	</div>
	<form action="register_stbook_edit1.php" method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-bar">

		
		<?php
			include('dbconnect.php');
			include('dbconnect_sale.php');

			$qfirst = "select * from hos__jongproduct where ref_id = '".$_GET["ref_id"]."'";
			$first = mysqli_query($conn,$qfirst);
			$ffirst = mysqli_fetch_array($first);

			$strSQL1 = "SELECT * FROM  (hos__subjongpro LEFT JOIN tb_product ON hos__subjongpro.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";

		$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
		$Num_Rows1 = mysqli_num_rows($objQuery1);



		
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;



		?>
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $ffirst['ref_id']; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $ffirst['ref_id']; ?>">
	</div>

	<div class="w3-bar w3-padding-small"></div><!-- bar -->
		<div class="w3-half 1">
			<div class="w3-bar w3-margin-bottom">
				<?php if ($ffirst['company']=='1'){ ?>
			<input type="radio" name="company"  checked ='checked' value="1">&nbsp;PTL
<input type="radio" name="company"  value="2" >&nbsp;NBM
				<?php }else{ ?>
			<input type="radio" name="company"  value="1">&nbsp;PTL
<input type="radio" name="company" checked ='checked'  value="2" >&nbsp;NBM	
				<?php } ?>
				</div>
				<div class="w3-bar w3-margin-bottom">
			วันที่แจ้ง  :<input type="date" name="date_jong" value = "<?php echo $ffirst['date_jong']; ?>" style="width:30%;" class="w3-input"  >
			
</div>
<div class="w3-bar w3-margin-bottom">
			เลขที่ BQ 
			<input type="text" name="bq_no" id="bq_no" value = "<?php echo $ffirst['bq_no']; ?>" class="w3-input" style="width:90%;"  >
</div>

			<div class="w3-bar w3-margin-bottom">
หมายเหตุ :&nbsp;		
			<textarea name="drescription" id="drescription" class="w3-input" style="width:90%;"  ><?php echo $ffirst['drescription']; ?></textarea>
			</div>
</div>
<div class="w3-half 1">

<div class="w3-bar w3-margin-bottom">
			วันที่ต้องการสินค้า :<input type="date" name="date_receive"  value = "<?php echo $ffirst['date_receive']; ?>" style="width:30%;" class="w3-input"  >
			
</div>

<div class="w3-bar w3-margin-bottom">
			ชื่อลูกค้า 
			<input type="text" name="customer" id="customer" value = "<?php echo $ffirst['customer']; ?>" class="w3-input" style="width:90%;"  >
</div>

<div class="w3-bar w3-margin-bottom">
	สถานที่ส่ง :<textarea name="address_send" id="address_send" class="w3-input" style="width:90%;"  ><?php echo $ffirst['address_send']; ?></textarea>

</div>

<div class="w3-bar w3-margin-bottom">


เขตการขาย :

<select name="sale_code" id="sale_code" style="width:330px" class="w3-input" >
<option value="">**Please Select**</option>


<?php

$strSQL5 = "SELECT * FROM tb_team_adm ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($ffirst["sale_code"] == $objResuut5["sale_code"])
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


</div>

</div>
		
		
	
	<fieldset><legend ><b><font color="red">ส่วนของ Stock</font></b></legend></p>

	คลังสินค้า :&nbsp;
<input type="text" name="iv_no" id="iv_no" value ="<?php echo $ffirst['iv_no']; ?>" class="button4" style="width:12%;"  required> &nbsp;&nbsp;


<?php 

if($ffirst["register_ckk"]=='1'){ ?>
<input type="checkbox" name="register_ckk" id="register_ckk" value = '1' checked='checked' class="button4"  >&nbsp;&nbsp; ลงทะเบียน&nbsp;&nbsp;

<?php }else { ?>
<input type="checkbox" name="register_ckk" id="register_ckk" value = '1'  class="button4"  >&nbsp;&nbsp;ลงทะเบียน&nbsp;&nbsp;

	<?php } ?>

	<?php 

if($ffirst["cancel_ckk"]=='1'){ ?>
<input type="checkbox" name="cancel_ckk" id="cancel_ckk" value = '1' checked='checked' class="button4"  >&nbsp;&nbsp;ยกเลิก&nbsp;&nbsp;

<?php }else { ?>
<input type="checkbox" name="cancel_ckk" id="cancel_ckk" value = '1'  class="button4"  >&nbsp;&nbsp;ยกเลิก&nbsp;&nbsp;

	<?php } ?>


&nbsp;&nbsp;หมายเหตุ :&nbsp;
<input type="text" name="remark" id="remark"  class="button4" style="width:30%;"  > &nbsp;&nbsp;






	</p></fieldset>	

	</p>
	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
</div>


<div id="pd" class="w3-container city1">

<table width="100%" border="0" class="w3-table">

    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
      <th>จำนวน</th>
  <th>หน่วย</th>
   <th>หมายเหตุ</th>

<tbody>

<?php

$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
?>

<tr>
<td style="width:10%;">


<input type='text' name = "product_code[]<?php echo $objResult1["id"]; ?>"  id = "product_code[]<?php echo $objResult1["id"]; ?>" class="w3-input" value = "<?php echo $objResult1["access_code"]; ?>"  size="7" /> 
<input type='hidden' name = "product_id[]<?php echo $objResult1["id"]; ?>" value = "<?php echo $objResult1["product_id"]; ?>" id = "product_id[]<?php echo $objResult1["id"]; ?>" class="w3-input" />
<input type='hidden' name = "id[]<?php echo $objResult1["id"]; ?>" value = "<?php echo $objResult1["id"]; ?>" id = "id[]<?php echo $objResult1["id"]; ?>" class="w3-input" />


</td>
<td  style="width:8%;">
<textarea  name = "product_name[]<?php echo $objResult1["id"]; ?>"  id = "product_name[]<?php echo $objResult1["id"]; ?>"   rows="2" class="w3-input" readonly><?php echo $objResult1["access_name"]; ?></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "count[]<?php echo $objResult1["id"]; ?>" id = "count[]<?php echo $objResult1["id"]; ?>" value = "<?php echo $objResult1["count"]; ?>" class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:5%;">
<input type='text' name = "unit_name[]<?php echo $objResult1["id"]; ?>"  id = "unit_name[]<?php echo $objResult1["id"]; ?>" value = "<?php echo $objResult1["unit_name"]; ?>" class="w3-input" readonly/>
</td>
<td style="width:10%;">
<textarea name = "sale_remarkk[]<?php echo $objResult1["id"]; ?>"  id = "sale_remarkk[]<?php echo $objResult1["id"]; ?>"  class="w3-input" ><?php echo $objResult1["sale_remark"]; ?></textarea>
</td>

</tr>
<?php } ?>

</table>




</div>






	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
	</div>
	</div>
	</form>
</div>
<?php include('foot.php'); ?>



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