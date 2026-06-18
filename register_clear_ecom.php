<?php include ("head.php"); ?>



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

<body>
<?php

$sql1 = "select * from hos__receive order by id_auto desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 



$ref_id =$_GET["ref_id"];

$strSQL = "SELECT *   FROM so__main where ref_id ='".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_assoc($objQuery);


	 ?>


	<!--action="register_office1.php"-->
	<form action='register_clear_ecom1.php' method="post" name="frmMain" enctype="multipart/form-data">
		<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>คืนสินค้า E-Commerce</h4></div>

<div class="w3-bar">
		
	<?php if ($objResult['select_type_doc']=='1' or $objResult['select_type_doc']=='3'){
		?>
<input type="radio" checked='checked' name="type_company" value = "3">&nbsp; AWL
<input type="radio" name="type_company"  value="4" >&nbsp;NBM
<?php }else{ ?>

<input type="radio"  name="type_company" value = "3">&nbsp; AWL
<input type="radio" name="type_company" checked='checked' value="4" >&nbsp;NBM

			<?php } ?>

		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $fetch1['ref_id']+1; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $fetch1['ref_id']+1; ?>">
	</div>

</p>
<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


?>
			
<div class="w3-half 1">			
			
<input type="radio"  name="receive_ckk" value = "1" required>&nbsp; คืนสินค้าด้วยตัวเอง
<input type="radio" name="receive_ckk"  value="2" required>&nbsp;ฝากบุคคลอื่นคืน คุณ &nbsp;

			
  : &nbsp;<input type="text" name="receive_name" class="w3-input" style="width:90%;" > 
		<input type="hidden" name="channel" id ="channel" value ="<?php echo $objResult["sale_channel"]; ?>" class="button4" style="width:15%;" > 
	
เลขที่ใบยืม : <input type="text" name="iv_no" value = '<?php echo $objResult['doc_no'];?>' class="w3-input" style="width:90%;" 	>	
หมายเลขคำสั่งซื้อ : <input type="text" name="order_id" value = '<?php echo $objResult['order_id'];?>' class="w3-input" style="width:90%;" 	>	
	
ที่อยู่ :  <textarea rows="2" name="customer_address" class="w3-input" style="width:90%"  ><?php echo $objResult["address1"]; echo $objResult["address2"]; ?></textarea>
	
				ชื่อผู้ยืม : <input type="text" name="sale_name" value = '<?php echo $_SESSION['name'];?> <?php echo $_SESSION['surname'];?>' class="w3-input" style="width:90%;" 	>	
	
</div>	
	
	<div class="w3-half 1">
		
		
		วันที่ : 
<input type="date" name = "date_receive" id="date_receive" value="<?php echo $today;?>" class = "w3-input"> 
			
ชื่อลูกค้า  :<input type="text" name="customer_name" class="w3-input" value = '<?php echo $objResult['customer_name'];?>' style="width:90%;" required>			

เขตการขาย : &nbsp;<input type="text" name="sale_code" class="w3-input" style="width:90%;" value = '<?php echo $objResult['employee_name'];?>' required> 
สาเหตุรับคืน<br>		
<input type="radio" name="type_remark" id='type_remark' value = '1' required>	ลูกค้าปฏิเสธการรับพัสดุกับขนส่ง<br>	
<input type="radio" name="type_remark" id='type_remark' value = '2' required>	ลูกค้าคืนสินค้าผ่านระบบ<br>	
<input type="radio" name="type_remark" id='type_remark' value = '3' required>	ลูกค้าคืนสินค้านอกระบบ<br>	
<input type="radio" name="type_remark" id='type_remark' value = '4' required>	อื่นๆ<br>	
หมายเหตุ : <textarea rows="2" name="remark_st" class="w3-input" style="width:90%"  ></textarea>	
		
			</div>
</div>

<input type="hidden" name="ref_sale" class="w3-input" value = '<?php echo $ref_id;?>' style="width:30%;" required>



	

					
			
			






<div class="w3-bar w3-light-grey w3-border">
 <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>

</div>

<div id="pd" class="w3-container city1" >

<table width="100%" border="0" class="w3-table">
<tr>
     <th>ID สินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>หมายเลขเครื่อง</th>
    <th>หมายเหตุ</th>

</tr>
<tbody>
<?php

$i = 1;


$strSQL1 = "SELECT * FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";
//echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<tr>

<td >
<input type='hidden' name = "id[]" value="<?php echo $objResult1["id"];?>" id = "id[]"    size='16' readonly/>
<input type='text' name = "product_id[]" value="<?php echo $objResult1["product_id"];?>" id = "product_id[]"    size='16' class="w3-input" />
 <input type='hidden' name = "product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sol_code"];?>" id = "product_code[]<?php echo $objResult1["id"];?>"  class="w3-input"    size='16' readonly/>  


</td>


<td><input type='text' name = "product_name[]<?php echo $objResult1["id"];?>"  value="<?php echo $objResult1["sol_name"];?>" id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly></td>	
	
	

<td><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    size='9' readonly/></td>

<td><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"   size='7' /></td>

<td><input type='text' name = "sn[]<?php echo $objResult1["id"];?>"  id = "sn[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sn_number"]; ?>" class="w3-input"    size='13' /></td>

<td><input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input"    size='13' /></td>




</tr>



<?php
	$i++;
	

}


?>
</tbody>
</table>


</div>



<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>


</div></div></form>
<div id="cr_bar"><?php include "foot.php"; ?></div>
  
  <!--/div-->

  
 





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