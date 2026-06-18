<?php include('head.php'); ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>


	
<style>
	.none {
    display:none;
	}
</style>


<?php
			include('dbconnect.php');

$sql = "SELECT * FROM st__expro where ref_id = '".$_GET["ref_id"]."'";
$qry = mysqli_query($new,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);


$strSQL1 = "SELECT * FROM  st__subexpro WHERE ref_idd = '".$_GET["ref_id"]."' ";
$objQuery1 = mysqli_query($new,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


		?>
<div class="w3-white">
<div class="w3-container">
	<div class="w3-panel w3-light-grey">
		<div class="w3-half">		
		<h3>2103 ใบเบิกเป็นสินค้าสาธิต</h3>
		</div>
				<div class="w3-half">
<a href="report_expro.php?ref_id=<?php echo $rs["ref_id"];?>" class="w3-button w3-blue w3-right"><font color="black">ปริ้นใบเบิกเป็นสินค้าสาธิต</font></a>					
<a href="reject_expro.php?ref_id=<?php echo $rs["ref_id"];?>" class="w3-button w3-red w3-right"><font color="black">Rejected</font></a>		<a href="app_expro.php?ref_id=<?php echo $rs["ref_id"];?>" class="w3-button w3-green w3-right"><font color="black">Approve</font></a>
</div>
		
		</div>
	<form  method="post" action ="" name="frmMain" enctype="multipart/form-data">
	
		
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $rs["ref_id"]; ?></span>
	
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $rs["ref_id"]; ?>">
	
	
	<div class="w3-bar w3-padding-small"></div><!-- bar -->
	<div class="w3-half 1">
<div class="w3-bar w3-margin-bottom">

     <?php if($rs["company"]=='1'){ ?>
			<input type="radio" name="company" value='1' checked='checked'   required> AWL 
			<input type="radio" name="company" value='2'    required> NBM 
 <?php }else if($rs["company"]=='2'){ ?>
			<input type="radio" name="company" value='1'   required> AWL 
			<input type="radio" name="company" value='2'  checked='checked'   required> NBM 
		 <?php }else{ ?>

			<input type="radio" name="company" value='1'   required> AWL 
			<input type="radio" name="company" value='2'    required> NBM 
			 <?php } ?>





		</div>

		<div class="w3-bar w3-margin-bottom">
			<span>รหัสพนักงานคลัง</span> <input type="text" name="employee_code" id="employee_code" value="<?php echo $rs['employee_code']; ?>" class="w3-input" style="width:90%;" OnChange="JavaScript:doCallAjax1('employee_code','employee_name');"  required>
			
		</div>
			<div class="w3-bar w3-margin-bottom">
			<span>วันที่ออกเอกสาร</span> <input type="date" name="iv_date"  id="iv_date" class="w3-input" value="<?php echo $rs['iv_date']; ?>" style="width:90%;" readonly>
			
		</div>
				
	</div>
	<div class="w3-half 2">
		<div class="w3-bar w3-margin-bottom">
			<span>ชื่อพนักงานคลัง</span> <input type="text" name="employee_name"  id="employee_name" class="w3-input" value="<?php echo $rs['employee_name']; ?>" style="width:90%;" required>
			
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>เลขที่ออกเอกสาร</span> <input type="ะำปะ" name="iv_no"  id="iv_no" class="w3-input" value="<?php echo $rs['iv_no']; ?>" style="width:90%;" readonly>
			
		</div>
		
		<div class="w3-bar w3-margin-bottom">
				<span>หมายเหตุ </span> <input type="text" name="description" value="<?php echo $rs['description']; ?>" id="description" class="w3-input" style="width:90%;"  >

		</div>
		
				
		</div>
		
	
	<br>
		
		<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
		
</div>


<div id="pd" class="w3-container city1">

<table width="100%" border="0" class="w3-table">
<thead>

    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
	<th>หน่วย</th>
	<th>จำนวน</th>
	<th>หมายเลขเครื่อง</th>
	<th>หมายเหตุคลัง</th>
	

</thead>
<?php


$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$strSQL2 = "SELECT access_code,sol_name,unit_name,adjust_list FROM  tb_product WHERE product_ID = '".$objResult1["product_id"]."' ";

$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

	?>

<tbody>
<tr>
<td style="width:10%;">

<input type='text' name = "product_code" value="<?php echo $objResult2["access_code"]; ?>" id = "product_code" class="w3-input" readonly> 
<input type='hidden' name = "product_id[]<?php echo $objResult1["id_sub"];?>"  id = "product_id[]<?php echo $objResult1["id_sub"];?>" value="<?php echo $objResult1["product_id"]; ?>"  class="w3-input" readonly>
<input type='hidden' name = "id_sub[]<?php echo $objResult1["id_sub"];?>"  id = "id_sub[]<?php echo $objResult1["id_sub"];?>" value="<?php echo $objResult1["id_sub"]; ?>"  class="w3-input" readonly>


</td>

<td>
<textarea  name = "product_name"  id = "product_name"  class="w3-input" readonly><?php echo $objResult2["sol_name"]; ?></textarea>
</td>

<td style="width:5%;">
<input type='text' name = "unit_name"  id = "unit_name"  class="w3-input" value="<?php echo $objResult2["unit_name"]; ?>" readonly/>
</td>

<td>
<input type='text' name = "count[]<?php echo $objResult1["id_sub"];?>"  id = "count[]<?php echo $objResult1["id_sub"];?>"  class="w3-input" value="<?php echo $objResult1["count"]; ?>" style="color:black;text-align:right" />

</td>

	
<td>
<textarea  name = "sn_number[]<?php echo $objResult1["id_sub"];?>"  id = "sn_number[]<?php echo $objResult1["id_sub"];?>"  class="w3-input"  style="color:black;text-align:right" ><?php echo $objResult1["sn_number"]; ?></textarea>

</td>

<td>
<textarea  name = "stock_remark[]<?php echo $objResult1["id_sub"];?>"  id = "stock_remark[]<?php echo $objResult1["id_sub"];?>"  class="w3-input" ><?php echo $objResult1["stock_remark"]; ?></textarea>
</td>
</tr>

<?php 
$i++;
}
?>
</table>

</div>

</form>
</div>
<?php include('foot.php'); ?>



       

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


