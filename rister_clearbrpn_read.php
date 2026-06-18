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





$ref_id =$_GET["ref_id"];

$strSQL = "SELECT *   FROM hos__receive where ref_id ='".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_assoc($objQuery);


	 ?>


	<!--action="register_office1.php"-->
	<form action='rister_clearbrpn_read1.php' method="post" name="frmMain" enctype="multipart/form-data"  >
   <div class="w3-white" >
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray">
				
				<h4>105 Edit ใบรับคืน</h4>
				</div>

<div class="w3-bar">
		
	<?php if ($objResult['type_company']=='3'){
		?>
<input type="radio" checked='checked' name="type_company" value = "3">&nbsp; AWL
<input type="radio" name="type_company"  value="4" >&nbsp;NBM
<?php }else{ ?>

<input type="radio"  name="type_company" value = "3">&nbsp; AWL
<input type="radio" name="type_company" checked='checked' value="4" >&nbsp;NBM

			<?php } ?>

		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php  echo $objResult['ref_id'];  ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $objResult['ref_id']; ?>">
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
		<div class="w3-bar w3-margin-bottom">

<?php if ($objResult['receive_ckk']=='1'){
		?>
<input type="radio" checked='checked' name="receive_ckk" value = "1" required>&nbsp; คืนสินค้าด้วยตัวเอง
<input type="radio" name="receive_ckk"  value="2" required>&nbsp;ฝากบุคคลอื่นคืน คุณ &nbsp;
<?php }else if($objResult['receive_ckk']=='2'){ ?>

<input type="radio"  name="receive_ckk" value = "1" required>&nbsp; คืนสินค้าด้วยตัวเอง
<input type="radio" name="receive_ckk" checked='checked' value="2" required>&nbsp;ฝากบุคคลอื่นคืน คุณ &nbsp;

			<?php }else{ ?>

<input type="radio"  name="receive_ckk" value = "1" required>&nbsp; คืนสินค้าด้วยตัวเอง
<input type="radio" name="receive_ckk"  value="2" required>&nbsp;ฝากบุคคลอื่นคืน คุณ &nbsp;

			<?php } ?>
  : &nbsp;<input type="text" name="receive_name"  value="<?php echo $objResult['receive_name'];?>" class="w3-input" style="width:90%;" > 

</div><div class="w3-bar w3-margin-bottom">
		วันที่ : 
<input type="date" name = "date_receive" id="date_receive" value="<?php echo $objResult['date_receive'];?>" class = "w3-input" style="width:90%;"> 
</div><div class="w3-bar w3-margin-bottom">
		วันที่ช่วงเวลา : 
<input type="text" name = "receive_between" id="receive_between" value="<?php echo $objResult['receive_between'];?>" class = "w3-input" style="width:90%;"> 
</div><div class="w3-bar w3-margin-bottom">
		ช่วงเวลา : 
<input type="text" name = "time_between" id="time_between" value="<?php echo $objResult['time_between'];?>" class = "w3-input" style="width:90%;"> 
</div>
<div class="w3-bar w3-margin-bottom">

ที่อยู่ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <textarea rows="2" name="customer_address" class="w3-input" style="width:90%"  ><?php echo $objResult["customer_address"]; ?></textarea>
</div>

<div class="w3-bar w3-margin-bottom">
			
เขตการขาย : &nbsp;<input type="text" name="sale_code" class="w3-input" style="width:90%;" value = '<?php echo $objResult['sale_code'];?>' required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>
<div class="w3-bar w3-margin-bottom">
		วันที่รับคืน : 
<input type="date" name = "stock_date" id="stock_date" value="<?php echo $today;?>" class = "w3-input" style="width:90%;" required> 
</div>		

<?php /*<div class="w3-bar w3-margin-bottom">
<input type="checkbox" name="send_erpst"  value="1" required>&nbsp;<font color="red"><b>สมบูรณ์ </b></font>&nbsp;

</div>	*/ ?>	
</div>
<div class="w3-half 1">
		<div class="w3-bar w3-margin-bottom">

เลขที่ใบยืม : <input type="text" name="iv_no" value = '<?php echo $objResult['iv_no'];?>' class="w3-input" style="width:90%;" 	>

</div>
<div class="w3-bar w3-margin-bottom">

ชื่อลูกค้า  : &nbsp;<input type="text" name="customer_name" class="w3-input" value = '<?php echo $objResult['customer_name'];?>' style="width:90%;" required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


</div>
	<div class="w3-bar w3-margin-bottom">
				ชื่อผู้ยืม :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="sale_name" value = '<?php echo $objResult['sale_name'];?>' class="w3-input" style="width:90%;" 	>
				</div>
				<div class="w3-bar w3-margin-bottom">	
สาเหตุรับคืน<br>
<?php if($objResult['type_remark']=='1'){ ?>					
<input type="radio" name="type_remark" id='type_remark' checked='checked' value = '1' required>	
			<?php }else{ ?>
<input type="radio" name="type_remark" id='type_remark' value = '1' required>						
					<?php } ?>
					ลูกค้าปฏิเสธการรับพัสดุกับขนส่ง<br>	
					
<?php if($objResult['type_remark']=='2'){ ?>					
<input type="radio" name="type_remark" id='type_remark' checked='checked' value = '2' required>	
			<?php }else{ ?>
<input type="radio" name="type_remark" id='type_remark' value = '2' required>						
					<?php } ?>					
					ลูกค้าคืนสินค้าผ่านระบบ<br>	
					
<?php if($objResult['type_remark']=='3'){ ?>					
<input type="radio" name="type_remark" id='type_remark' checked='checked' value = '3' required>	
			<?php }else{ ?>
<input type="radio" name="type_remark" id='type_remark' value = '3' required>						
					<?php } ?>
					
					ลูกค้าคืนสินค้านอกระบบ<br>	
					
<?php if($objResult['type_remark']=='4'){ ?>					
<input type="radio" name="type_remark" id='type_remark' checked='checked' value = '4' required>	
			<?php }else{ ?>
<input type="radio" name="type_remark" id='type_remark' value = '4' required>						
					<?php } ?>
					อื่นๆ<br>	
	หมายเหตุ : <textarea rows="2" name="remark_st" class="w3-input" style="width:90%"  ><?php echo $objResult['remark_st'];?></textarea>
</div>
<div class="w3-bar w3-margin-bottom">
				ผู้รับคืน : <input type="text" name="stock_name" value = '<?php echo $_SESSION['name'];?> <?php echo $_SESSION['surname'];?>' class="w3-input" style="width:90%;" 	required>
				</div>
	
	</div>
	
	
	<br><br>				

<div class="w3-bar w3-light-grey w3-border">
 <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>

</div>

<div id="pd" class="w3-container city1" >


	<table width="100%" border="0" class="w3-table">
<thead>
    <th>ID สินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>หมายเลขเครื่อง</th>
    <th>หมายเหตุ</th>
	<th>รายการปรับปรุงสินค้า</th>

</thead>
<tbody>
<?php

$i = 1;


$strSQL1 = "SELECT * FROM  (hos__subreceive LEFT JOIN tb_product ON hos__subreceive.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
//echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


while($objResult1 = mysqli_fetch_array($objQuery1))
{

?>
<tr>

<td style="width:10%;">

<input type="hidden" name="id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id']; ?>">

<input type="hidden" name="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

<input type='text' name ="product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["access_code"];?>" id ="product_code[]<?php echo $objResult1["id"];?>"  size="7"   class="w3-input w3-center" OnChange="JavaScript:doCallAjax('product_code[]<?php echo $objResult1["id"];?>','product_name[]<?php echo $objResult1["id"];?>','unit_name[]<?php echo $objResult1["id"];?>','product_price[]<?php echo $objResult1["id"];?>','discount_unit[]<?php echo $objResult1["id"];?>');"/></td>

<td  style="width:12%;">
<textarea name = "product_name[]<?php echo $objResult1["id"];?>"   id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly><?php echo $objResult1["sol_name"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    /></td>


<td style="width:10%;">

<textarea name = "sn[]<?php echo $objResult1["id"];?>"  id = "sn[]<?php echo $objResult1["id"];?>"  class="w3-input" ><?php echo $objResult1["sn"];?></textarea>
</td>


<td style="width:10%;">
<input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input" />
</td>


<td style="width:8%;">
<textarea name = "Improve[]<?php echo $objResult1["id"];?>"  id = "Improve"[]<?php echo $objResult1["id"];?>  class="w3-input" ><?php echo $objResult1['adjust_list']; ?></textarea>
</td>


</tr>



<?php
	$i++;
	

}


?>
</tbody>
</table>



</div>

</form></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>

  
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