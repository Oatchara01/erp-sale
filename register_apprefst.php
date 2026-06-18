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
$strSQL = "SELECT *  FROM st__main_new WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery = mysqli_query($new,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

?>

<div class="w3-white">
<div class="w3-container">
	<div class="w3-panel w3-light-grey"><div class="w3-half"><h3>Approve ขอปรับปรุงยอดสต็อก</h3>
		
			</div>
<div class="w3-half">
					
<a href="cm_apprefst.php?ref_id=<?php echo $objResult["ref_id"];?>" class="w3-button w3-green "><font color="330066">Approve</font></a>

<a href="cm_rejrefst.php?ref_id=<?php echo $objResult["ref_id"];?>" class="w3-button w3-red "><font color="330066">Rejected</font></a>		
		
			</div></div>
	<form  method="post" action ='' name="frmMain" enctype="multipart/form-data">
	<div class="w3-bar">
		
		<?php
			include('dbconnect.php');


		 
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;



		?>
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $objResult['ref_id']; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $objResult['ref_id']; ?>">
	</div>
	
	<div class="w3-bar w3-padding-small"></div><!-- bar -->
	<div class="w3-half 1">
		<div class="w3-bar w3-margin-bottom">
			<span>วันที่ปรับปรุงรายการ</span> <input type="text" name="add_date" value = "<?php echo $objResult['add_date']; ?>" class="w3-input" style="width:90%;" readonly>  <!--required-->
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>วันที่คลัง</span> <input type="date" name="stock_date" value = "<?php echo $objResult['stock_date']; ?>" class="w3-input" style="width:90%;" readonly>  <!--required-->
		</div>
		
		<div class="w3-bar w3-margin-bottom">
			<span>เลขที่เอกสารเดิม</span> <input type="text" name="iv_no" value = "<?php echo $objResult['iv_no']; ?>" class="w3-input" style="width:90%;" required>

		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>เลขที่อ้างอิง (ERP Sale)</span> <input type="text" name="ref_idsale"  value = "<?php echo $objResult['ref_idsale']; ?>" class="w3-input" style="width:90%;" >
		</div>
		


		<div class="w3-bar w3-margin-bottom">
				<span>ชื่อลูกค้า </span> <input type="text" name="customer_name" value = "<?php echo $objResult['customer_name']; ?>" id="customer_name" class="w3-input" style="width:90%;"  required>

		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>เลขที่เอกสารใหม่</span> <input type="text" name="iv_no1" value = "<?php echo $objResult['iv_no1']; ?>"class="w3-input" style="width:90%;" >
			
		</div>
	</div>
	<div class="w3-half 2">
		<div class="w3-bar w3-margin-bottom">
			<span>ผู้ปรับปรุงรายการ</span> <input type="text" name="add_by" value = "<?php echo $objResult['add_by']; ?>" class="w3-input" style="width:90%;" readonly>  <!--required-->
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ชื่อพนักงานคลัง</span> <input type="text" name="employee_name" value = "<?php echo $objResult['employee_name']; ?>"class="w3-input" style="width:90%;" required>
			
		</div>
		
		
		<div class="w3-bar w3-margin-bottom ">
		
			<span>วันที่ออกเอกสาร</span>  <input type="date" name="iv_date" value = "<?php echo $objResult['iv_date']; ?>" class="w3-input" style="width:90%;" readonly>
			
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>หมายเลขคำสั่งซื้อ</span> <input type="text" name="order_id" value = "<?php echo $objResult['order_id']; ?>" class="w3-input" style="width:90%;" >

		</div>
		
		<div class="w3-bar w3-margin-bottom">
			<span>ชื่อพนักงานขาย</span> 
			
			<input type='text' class="w3-input" class="button4" value = "<?php echo $objResult['sale_code']; ?>" name="sale_code" style="width:90%;" placeholder="Search ชื่อพนักงาน..."/>            
<input name="h_sale_code" type="hidden" id="h_sale_code" value="" class="button4" />



		</div>
		
		<div class="w3-bar w3-margin-bottom">
<font color='red'>รายละเอียดการแก้ไข</font> 
<textarea type="text" name="edit_remark"  id="edit_remark"  class="w3-input" rows="3" style="width:90%;" required><?php echo $objResult['edit_remark']; ?></textarea>

</div>	
		</div>
		
	</div>
	</p>
	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="blue"><b>ข้อมูลรายการสินค้าใหม่</b></font></a>
</div>

<div id="pd" class="w3-container city1">

<table width="100%" border="0" class="w3-table">
<thead>

	<th>รหัสสินค้า</th>
	<th>ชื่อสินค้า</th>
	<th>หน่วย</th>
	<th>ประเภทเอกสาร</th>
	<th>จำนวนคลังรับ</th>
	<th>จำนวนคลังจ่าย</th>
	<th>หมายเลขเครื่อง</th>
	<th>Lot no</th>
	<th>หมายเหตุคลัง</th>
	<th>เคลียร์ IV</th>

</thead>
<tbody>

<?php
$strSQL1 = "SELECT * FROM  st__sbmain_new WHERE ref_idd = '".$_GET["ref_id"]."' ";
$objQuery1 = mysqli_query($new,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$strSQL2 = "SELECT express_code,sol_name,unit_name,adjust_list FROM  tb_product WHERE product_ID = '".$objResult1["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

?>

<tr>
<td style="width:10%;">

<input type='text' name = "product_code"  value="<?php echo $objResult2["express_code"];?>" id = "product_code" class="w3-input" placeholder="ยิง Barcode..." OnChange="JavaScript:doCallAjax('product_code1','product_id1','product_name1','unit_name1','product_price1','discount_unit1');"/> 
<input type="hidden" name="id_submain[]<?php echo $objResult1["id_submain"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id_submain']; ?>">

<input type="hidden" name="product_id[]<?php echo $objResult1["id_submain"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

</td>

<td>
<textarea name = "product_name[]<?php echo $objResult1["id_submain"];?>"   id = "product_name[]<?php echo $objResult1["id_submain"];?>"  class="w3-input" readonly><?php echo $objResult2["sol_name"]; ?></textarea>
</td>

<td style="width:5%;">
<input type='text' name = "unit_name[]<?php echo $objResult1["id_submain"];?>"  value="<?php echo $objResult2['unit_name']; ?>" id = "unit_name[]<?php echo $objResult1["id_submain"];?>"  class="w3-input" readonly/>
</td>
<td style="width:8%;">

<select name="type_doc[]<?php echo $objResult1["id_submain"];?>" id="type_doc[]<?php echo $objResult1["id_submain"];?>" class="w3-select" >
<option  value="">**ประเภทเอกสาร**</option>
<?php
$sqlchannel = "select * from tb_typedoc order by typedoc_id";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) { 
	
if($objResult1["type_doc"] == $fetchchannel["typedoc_id"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>

<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['typedoc_id']; ?>"<?php echo $sel;?>><?php echo $fetchchannel['typedoc_code']; ?></option>
<?php } ?>
</select>


</td>


<td>
<input type='text' name = "count_receive[]<?php echo $objResult1["id_submain"];?>"  id = "count_receive[]<?php echo $objResult1["id_submain"];?>" value="<?php echo $objResult1['count_receive']; ?>" class="w3-input"  style="color:black;text-align:right" />

</td>

<td>
<input type='text' name = "count_send[]<?php echo $objResult1["id_submain"];?>"  id = "count_send[]<?php echo $objResult1["id_submain"];?>" value="<?php echo $objResult1['count_send']; ?>" class="w3-input"  style="color:black;text-align:right" />

</td>

<td>
<textarea name = "sn_number[]<?php echo $objResult1["id_submain"];?>"  id = "sn_number[]<?php echo $objResult1["id_submain"];?>"  class="w3-input"  ><?php echo $objResult1['sn_number']; ?></textarea>

</td>

<td>
<textarea name = "lot_no[]<?php echo $objResult1["id_submain"];?>"  id = "lot_no[]<?php echo $objResult1["id_submain"];?>"  class="w3-input"  ><?php echo $objResult1['lot_no']; ?></textarea>

</td>


<td>
<textarea name = "stock_remarkk[]<?php echo $objResult1["id_submain"];?>"  id = "stock_remarkk[]<?php echo $objResult1["id_submain"];?>"  class="w3-input" ><?php echo $objResult1['stock_remark']; ?></textarea>
</td>


<td>
<textarea name = "clear_ivno[]<?php echo $objResult1["id_submain"];?>"  id = "clear_ivno"[]<?php echo $objResult1["id_submain"];?>  class="w3-input" ><?php echo $objResult1['clear_ivno']; ?></textarea>
</td>
	

</tr>

<?php
	$i++;
	}


?>



</tbody>
</table>







</div>



<br>
<br>	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" ><font color="red"><b>ข้อมูลรายการสินค้าเดิม</b></font></a>
</div>

<table width="100%" border="0" class="w3-table">
<thead>

	<th>รหัสสินค้า</th>
	<th>ชื่อสินค้า</th>
	<th>หน่วย</th>
	<th>ประเภทเอกสาร</th>
	<th>จำนวนคลังรับ</th>
	<th>จำนวนคลังจ่าย</th>
	<th>หมายเลขเครื่อง</th>
	<th>Lot no</th>
	<th>หมายเหตุคลัง</th>
	<th>เคลียร์ IV</th>

</thead>
<tbody>

<?php
$strSQL1 = "SELECT * FROM  st__sbmain_old WHERE ref_idd = '".$_GET["ref_id"]."' ";
$objQuery1 = mysqli_query($new,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$strSQL2 = "SELECT express_code,sol_name,unit_name,adjust_list FROM  tb_product WHERE product_ID = '".$objResult1["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

?>

<tr>
<td style="width:10%;">

<input type='text'  value="<?php echo $objResult2["express_code"];?>"  class="w3-input" > 

</td>

<td>
<textarea  class="w3-input" readonly><?php echo $objResult2["sol_name"]; ?></textarea>
</td>

<td style="width:5%;">
<input type='text'  value="<?php echo $objResult2['unit_name']; ?>"  class="w3-input" readonly/>
</td>
<td style="width:8%;">

<select  class="w3-select" >
<option  value="">**ประเภทเอกสาร**</option>
<?php
$sqlchannel = "select * from tb_typedoc order by typedoc_id";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) { 
	
if($objResult1["type_doc"] == $fetchchannel["typedoc_id"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>

<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['typedoc_id']; ?>"<?php echo $sel;?>><?php echo $fetchchannel['typedoc_code']; ?></option>
<?php } ?>
</select>


</td>


<td>
<input type='text'  value="<?php echo $objResult1['count_receive']; ?>" class="w3-input"  style="color:black;text-align:right" />

</td>

<td>
<input type='text' value="<?php echo $objResult1['count_send']; ?>" class="w3-input"  style="color:black;text-align:right" />

</td>

<td>
<textarea  class="w3-input"  ><?php echo $objResult1['sn_number']; ?></textarea>

</td>

<td>
<textarea  class="w3-input"  ><?php echo $objResult1['lot_no']; ?></textarea>

</td>

<td>
<textarea  class="w3-input" ><?php echo $objResult1['stock_remark']; ?></textarea>
</td>

<td>
<textarea  class="w3-input" ><?php echo $objResult1['clear_ivno']; ?></textarea>
</td>
	

</tr>

<?php
	$i++;
	}


?>



</tbody>
</table>


	<br>
<br>
	</div></form>
</div>
<?php include('foot.php'); ?>

