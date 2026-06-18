<?php include ("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>



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

<form  method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();" >
		
<script language="javascript">
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
	
		
	document.frmMain.submit();
}


</script>
<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>แบบสอบถามความพึงพอใจสินค้าสาธิต</h4></div>



</p>

<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;
$ref_id_br = $_GET["ref_id_br"];
	
$sql = "SELECT *   FROM so__main where ref_id ='".$ref_id_br."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);


$strSQL1 = "SELECT sol_name,product_code FROM  (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id_br."' and product_type ='สินค้าสาธิต'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$objResult1 = mysqli_fetch_array($objQuery1);
	

$sql1 = "SELECT *   FROM tb_research_demo where ref_id ='".$ref_id_br."' ";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);



?>
		<div class="w3-half 1">

		วันที่ : <input type="date" name = "date_reseach" id="date_reseach" style="width:90%;"  value="<?php echo $rs1["date_reseach"]; ?>" class = "w3-input" readonly> 	
		รหัสลูกค้า  : 

<input type='text' value="<?php echo $rs["customer_name"]; ?>" class="w3-input"   style="width:90%;"  readonly> 
	
<input type="hidden" name = "ref_id_br" id="ref_id_br" style="width:90%;"  value="<?php echo $ref_id_br; ?>" class = "w3-input" >			
			

			
</div>
		
		<div class="w3-half 1">
		เลขที่เอกสาร  : <input type='text' value="<?php echo $rs["doc_no"]; ?>" style="width:90%;" class="w3-input" readonly>
			
			ชื่อสินค้า
<textarea  class="w3-input" rows="2" style="width:90%" readonly><?php echo $objResult1["sol_name"]; ?></textarea>
	<input type='hidden' name="product_iddemo" id="product_iddemo" value="<?php echo $objResult1["product_code"]; ?>" class="w3-input"   style="width:90%;"  /> 					
</div></div><div class="w3-container w3-padding-large">


<h8><b>ส่วนที่ 1 คุณภาพสินค้า</b></h8><br>	

<table width="100%" border="1" class="w3-table">
<thead>
	<th width="2%">ลำดับ</th>
    <th  width="25%">รายการ</th>
    <th  width="5%">10</th>
    <th  width="5%">9</th>
    <th  width="5%">8</th>
    <th  width="5%">7</th>
	<th  width="5%">6</th>
	<th  width="5%">5</th>
	<th  width="5%">4</th>
    <th  width="5%">3</th>
    <th  width="5%">2</th>
    <th width="5%">1</th>
	

</thead>
	
<tr>
<td >1</td>
<td ><div align="left">ภาพลักษณ์ ความสวยงาม ความสะอาด</div></td>	
<td>
<?php if($rs1["ckk_1"]=='10'){ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='10' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='10' >
<?php } ?>
</td>	
<td>
	<?php if($rs1["ckk_1"]=='9'){ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='9' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='9' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_1"]=='8'){ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='8' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='8' >
<?php } ?>
</td>	
<td>
<?php if($rs1["ckk_1"]=='7'){ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='7' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='7' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_1"]=='6'){ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='6' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='6' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_1"]=='5'){ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='5' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='5' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_1"]=='4'){ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='4' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='4' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_1"]=='3'){ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='3' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='3' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_1"]=='2'){ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='2' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='2' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_1"]=='1'){ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='1' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_1" name="ckk_1" value='1' >
<?php } ?>

</td>	
</tr>	
	
	
<tr>
<td >2</td>
<td ><div align="left">ฟังก์ชันการใช้งาน สามารถใช้งานได้ดี</div></td>	
<td>
<?php if($rs1["ckk_2"]=='10'){ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='10' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='10' >
<?php } ?>

</td>	
<td>
<?php if($rs1["ckk_2"]=='9'){ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='9' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='9' >
<?php } ?>

</td>	
<td>
<?php if($rs1["ckk_2"]=='8'){ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='8' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='8' >
<?php } ?>

</td>	
<td>
<?php if($rs1["ckk_2"]=='7'){ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='7' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='7' >
<?php } ?>

</td>	
<td>
<?php if($rs1["ckk_2"]=='6'){ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='6' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='6' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_2"]=='5'){ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='5' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='5' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_2"]=='4'){ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='4' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='4' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_2"]=='3'){ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='3' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='3' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_2"]=='2'){ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='2' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='2' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_2"]=='1'){ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='1' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_2" name="ckk_2" value='1' >
<?php } ?>

</td>	
</tr>
	
<tr>
<td >3</td>
<td ><div align="left">อุปกรณ์ประกอบครบถ้วน</div></td>	
<td>
<?php if($rs1["ckk_3"]=='10'){ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='10' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='10' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_3"]=='9'){ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='9' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='9' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_3"]=='8'){ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='8' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='8' >
<?php } ?>

</td>	

<td>
	<?php if($rs1["ckk_3"]=='7'){ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='7' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='7' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_3"]=='6'){ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='6' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='6' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_3"]=='5'){ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='5' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='5' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_3"]=='4'){ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='4' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='4' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_3"]=='3'){ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='3' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='3' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_3"]=='2'){ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='2' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='2' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_3"]=='1'){ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='1' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_3" name="ckk_3" value='1' >
<?php } ?>

</td>	
</tr>
	
	
<tr>
<td >4</td>
<td ><div align="left">มีสติ๊กเกอร์ช่องทางการติดต่อครบถ้วน</div></td>	

<td>
	<?php if($rs1["ckk_4"]=='10'){ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='10' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='10' >
<?php } ?>

</td>	


<td>
	<?php if($rs1["ckk_4"]=='9'){ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='9' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='9' >
<?php } ?>

</td>	

<td>
	<?php if($rs1["ckk_4"]=='8'){ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='8' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='8' >
<?php } ?>

</td>	

<td>
	<?php if($rs1["ckk_4"]=='7'){ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='7' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='7' >
<?php } ?>

</td>	

<td>
	<?php if($rs1["ckk_4"]=='6'){ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='6' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='6' >
<?php } ?>

</td>	

<td>
	<?php if($rs1["ckk_4"]=='5'){ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='5' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='5' >
<?php } ?>

</td>	

<td>
	<?php if($rs1["ckk_4"]=='4'){ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='4' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='4' >
<?php } ?>

</td>	

<td>
	<?php if($rs1["ckk_4"]=='3'){ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='3' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='3' >
<?php } ?>

</td>	

<td>
	<?php if($rs1["ckk_4"]=='2'){ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='2' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='2' >
<?php } ?>

</td>	

<td>
	<?php if($rs1["ckk_4"]=='1'){ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='1' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_4" name="ckk_4" value='1' >
<?php } ?>

</td>	




</tr>
	
<tr>
<td >5</td>
<td ><div align="left">มีใบปะการใช้งาน และ VDO การใช้งานครบถ้วน</div></td>	
<td>
	<?php if($rs1["ckk_5"]=='10'){ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='10' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='10' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_5"]=='9'){ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='9' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='9' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_5"]=='8'){ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='8' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='8' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_5"]=='7'){ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='7' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='7' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_5"]=='6'){ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='6' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='6' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_5"]=='5'){ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='5' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='5' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_5"]=='4'){ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='4' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='4' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_5"]=='3'){ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='3' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='3' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_5"]=='2'){ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='2' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='2' >
<?php } ?>

</td>	
<td>
	<?php if($rs1["ckk_5"]=='1'){ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='1' checked="checked" >
<?php }else{ ?>
<input type='radio' id="ckk_5" name="ckk_5" value='1' >
<?php } ?>

</td>	


</tr>
	

	


</table>

<br>
ข้อเสนอแนะ
<textarea  class="w3-input" id="ckk_des" name="ckk_des" rows="4" style="width:90%" readonly><?php echo $rs1["ckk_des"]; ?></textarea>	
<br><br>
	
<h8><b>ส่วนที่ 2 การจัดส่ง และการบริการ</b></h8><br>	
	
<table width="100%" border="1" class="w3-table">
<thead>
	<th  width="2%">ลำดับ</th>
    <th  width="25%">รายการ</th>
    <th  width="5%">10</th>
    <th  width="5%">9</th>
    <th  width="5%">8</th>
    <th  width="5%">7</th>
	<th  width="5%">6</th>
	<th  width="5%">5</th>
	<th  width="5%">4</th>
    <th  width="5%">3</th>
    <th  width="5%">2</th>
    <th  width="5%">1</th>
	

</thead>
	
<tr>
<td >1</td>
<td ><div align="left">ความถูกต้องครบถ้วนของอุปกรณ์ที่เบิกไปสาธิต</div></td>	
<td>	
<?php if($rs1["cs_1"]=='10'){ ?>
<input type='radio' id="cs_1" name="cs_1" value='10' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_1" name="cs_1" value='10' >
<?php } ?>
</td><td>
	
<?php if($rs1["cs_1"]=='9'){ ?>
<input type='radio' id="cs_1" name="cs_" value='9' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_1" name="cs_1" value='9' >
<?php } ?>
</td><td>	
<?php if($rs1["cs_1"]=='8'){ ?>
<input type='radio' id="cs_1" name="cs_1" value='8' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_1" name="cs_1" value='8' >
<?php } ?>
	</td><td>
<?php if($rs1["cs_1"]=='7'){ ?>
<input type='radio' id="cs_1" name="cs_1" value='7' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_1" name="cs_1" value='7' >
<?php } ?>
</td><td>	
<?php if($rs1["cs_1"]=='6'){ ?>
<input type='radio' id="cs_1" name="cs_1" value='6' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_1" name="cs_1" value='6' >
<?php } ?>
	</td><td>
<?php if($rs1["cs_1"]=='5'){ ?>
<input type='radio' id="cs_1" name="cs_1" value='5' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_1" name="cs_1" value='5' >
<?php } ?>
</td><td>	
<?php if($rs1["cs_1"]=='4'){ ?>
<input type='radio' id="cs_1" name="cs_1" value='4' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_1" name="cs_1" value='4' >
<?php } ?>
	</td><td>
<?php if($rs1["cs_1"]=='3'){ ?>
<input type='radio' id="cs_1" name="cs_1" value='3' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_1" name="cs_1" value='3' >
<?php } ?>
	</td><td>
<?php if($rs1["cs_1"]=='2'){ ?>
<input type='radio' id="cs_1" name="cs_1" value='2' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_1" name="cs_1" value='2' >
<?php } ?>
	</td><td>
<?php if($rs1["cs_1"]=='1'){ ?>
<input type='radio' id="cs_1" name="cs_1" value='1' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_1" name="cs_1" value='1' >
<?php } ?>
	
	</td>
	
	
</tr>
	
<tr>
<td >2</td>
<td ><div align="left">คุณภาพการบริการจัดส่งสินค้าสาธิต (การเคลื่อนย้ายสินค้า การดูแลสถานที่ห้องลูกค้า)</div></td>	
<td>
<?php if($rs1["cs_2"]=='10'){ ?>
<input type='radio' id="cs_2" name="cs_2" value='10' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_2" name="cs_2" value='10' >
<?php } ?>
</td><td>
<?php if($rs1["cs_2"]=='9'){ ?>
<input type='radio' id="cs_2" name="cs_2" value='9' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_2" name="cs_2" value='9' >
<?php } ?>
</td><td>
<?php if($rs1["cs_2"]=='8'){ ?>
<input type='radio' id="cs_2" name="cs_2" value='8' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_2" name="cs_2" value='8' >
<?php } ?>
</td><td>
<?php if($rs1["cs_2"]=='7'){ ?>
<input type='radio' id="cs_2" name="cs_2" value='7' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_2" name="cs_2" value='7' >
<?php } ?>
</td><td>
<?php if($rs1["cs_2"]=='6'){ ?>
<input type='radio' id="cs_2" name="cs_2" value='6' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_2" name="cs_2" value='6' >
<?php } ?>
</td><td>
<?php if($rs1["cs_2"]=='5'){ ?>
<input type='radio' id="cs_2" name="cs_2" value='5' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_2" name="cs_2" value='5' >
<?php } ?>
</td><td>
<?php if($rs1["cs_2"]=='4'){ ?>
<input type='radio' id="cs_2" name="cs_2" value='4' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_2" name="cs_2" value='4' >
<?php } ?>
</td><td>
<?php if($rs1["cs_2"]=='3'){ ?>
<input type='radio' id="cs_2" name="cs_2" value='3' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_2" name="cs_2" value='3' >
<?php } ?>
</td><td>
<?php if($rs1["cs_2"]=='2'){ ?>
<input type='radio' id="cs_2" name="cs_2" value='2' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_2" name="cs_2" value='2' >
<?php } ?>
</td><td>
<?php if($rs1["cs_2"]=='1'){ ?>
<input type='radio' id="cs_2" name="cs_2" value='1' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_2" name="cs_2" value='1' >
<?php } ?>
	</td>
	
</tr>
	
	
<tr>
<td >3</td>
<td ><div align="left">ส่งมอบสินค้าสาธิตได้ตามเวลาที่นัดหมาย</div></td>	

<td>
<?php if($rs1["cs_3"]=='10'){ ?>
<input type='radio' id="cs_3" name="cs_3" value='10' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_3" name="cs_3" value='10' >
<?php } ?>
</td><td>
<?php if($rs1["cs_3"]=='9'){ ?>
<input type='radio' id="cs_3" name="cs_3" value='9' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_3" name="cs_3" value='9' >
<?php } ?>
</td><td>
<?php if($rs1["cs_3"]=='8'){ ?>
<input type='radio' id="cs_3" name="cs_3" value='8' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_3" name="cs_3" value='8' >
<?php } ?>
</td><td>
<?php if($rs1["cs_3"]=='7'){ ?>
<input type='radio' id="cs_3" name="cs_3" value='7' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_3" name="cs_3" value='7' >
<?php } ?>
</td><td>
<?php if($rs1["cs_3"]=='6'){ ?>
<input type='radio' id="cs_3" name="cs_3" value='6' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_3" name="cs_3" value='6' >
<?php } ?>
</td><td>
<?php if($rs1["cs_3"]=='5'){ ?>
<input type='radio' id="cs_3" name="cs_3" value='5' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_3" name="cs_3" value='5' >
<?php } ?>
</td><td>
<?php if($rs1["cs_3"]=='4'){ ?>
<input type='radio' id="cs_3" name="cs_3" value='4' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_3" name="cs_3" value='4' >
<?php } ?>
</td><td>
<?php if($rs1["cs_3"]=='3'){ ?>
<input type='radio' id="cs_3" name="cs_3" value='3' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_3" name="cs_3" value='3' >
<?php } ?>
</td><td>
<?php if($rs1["cs_3"]=='2'){ ?>
<input type='radio' id="cs_3" name="cs_3" value='2' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_3" name="cs_3" value='2' >
<?php } ?>
</td><td>
<?php if($rs1["cs_3"]=='1'){ ?>
<input type='radio' id="cs_3" name="cs_3" value='1' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_3" name="cs_3" value='1' >
<?php } ?>
</td>
	
</tr>
	
<tr>
<td >4</td>
<td ><div align="left">พนักงานจัดส่งมีการโทรประสานงาน</div></td>	

<td>
<?php if($rs1["cs_4"]=='10'){ ?>
<input type='radio' id="cs_4" name="cs_4" value='10' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_4" name="cs_4" value='10' >
<?php } ?>
</td>
		

<td>
<?php if($rs1["cs_4"]=='9'){ ?>
<input type='radio' id="cs_4" name="cs_4" value='9' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_4" name="cs_4" value='9' >
<?php } ?>
</td>

<td>
<?php if($rs1["cs_4"]=='8'){ ?>
<input type='radio' id="cs_4" name="cs_4" value='8' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_4" name="cs_4" value='8' >
<?php } ?>
</td>

<td>
<?php if($rs1["cs_4"]=='7'){ ?>
<input type='radio' id="cs_4" name="cs_4" value='7' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_4" name="cs_4" value='7' >
<?php } ?>
</td>

<td>
<?php if($rs1["cs_4"]=='6'){ ?>
<input type='radio' id="cs_4" name="cs_4" value='6' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_4" name="cs_4" value='6' >
<?php } ?>
</td>

<td>
<?php if($rs1["cs_4"]=='5'){ ?>
<input type='radio' id="cs_4" name="cs_4" value='5' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_4" name="cs_4" value='5' >
<?php } ?>
</td>

<td>
<?php if($rs1["cs_4"]=='4'){ ?>
<input type='radio' id="cs_4" name="cs_4" value='4' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_4" name="cs_4" value='4' >
<?php } ?>
</td>

<td>
<?php if($rs1["cs_4"]=='3'){ ?>
<input type='radio' id="cs_4" name="cs_4" value='3' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_4" name="cs_4" value='3' >
<?php } ?>
</td>

<td>
<?php if($rs1["cs_4"]=='2'){ ?>
<input type='radio' id="cs_4" name="cs_4" value='2' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_4" name="cs_4" value='2' >
<?php } ?>
</td>

<td>
<?php if($rs1["cs_4"]=='1'){ ?>
<input type='radio' id="cs_4" name="cs_4" value='1' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_4" name="cs_4" value='1' >
<?php } ?>
</td>

</tr>
	
<tr>
<td >5</td>
<td ><div align="left">การแต่งกาย และการวางตัวเหมาะสม</div></td>	

<td>
<?php if($rs1["cs_5"]=='10'){ ?>
<input type='radio' id="cs_5" name="cs_5" value='10' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_5" name="cs_5" value='10' >
<?php } ?>
</td>

<td>
<?php if($rs1["cs_5"]=='9'){ ?>
<input type='radio' id="cs_5" name="cs_5" value='9' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_5" name="cs_5" value='9' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_5"]=='8'){ ?>
<input type='radio' id="cs_5" name="cs_5" value='8' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_5" name="cs_5" value='8' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_5"]=='7'){ ?>
<input type='radio' id="cs_5" name="cs_5" value='7' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_5" name="cs_5" value='7' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_5"]=='6'){ ?>
<input type='radio' id="cs_5" name="cs_5" value='6' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_5" name="cs_5" value='6' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_5"]=='5'){ ?>
<input type='radio' id="cs_5" name="cs_5" value='5' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_5" name="cs_5" value='5' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_5"]=='4'){ ?>
<input type='radio' id="cs_5" name="cs_5" value='4' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_5" name="cs_5" value='4' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_5"]=='3'){ ?>
<input type='radio' id="cs_5" name="cs_5" value='3' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_5" name="cs_5" value='3' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_5"]=='2'){ ?>
<input type='radio' id="cs_5" name="cs_5" value='2' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_5" name="cs_5" value='2' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_5"]=='1'){ ?>
<input type='radio' id="cs_5" name="cs_5" value='1' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_5" name="cs_5" value='1' >
<?php } ?>
</td>	
</tr>
	
<tr>
<td >6</td>
<td ><div align="left">ความพึงพอใจในสินค้าสาธิต และการบริการ</div></td>	

<td>
<?php if($rs1["cs_6"]=='10'){ ?>
<input type='radio' id="cs_6" name="cs_6" value='10' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_6" name="cs_6" value='10' >
<?php } ?>
</td>

<td>
<?php if($rs1["cs_6"]=='9'){ ?>
<input type='radio' id="cs_6" name="cs_6" value='9' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_6" name="cs_6" value='9' >
<?php } ?>
</td>

<td>
<?php if($rs1["cs_6"]=='8'){ ?>
<input type='radio' id="cs_6" name="cs_6" value='8' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_6" name="cs_6" value='8' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_6"]=='7'){ ?>
<input type='radio' id="cs_6" name="cs_6" value='7' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_6" name="cs_6" value='7' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_6"]=='6'){ ?>
<input type='radio' id="cs_6" name="cs_6" value='6' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_6" name="cs_6" value='6' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_6"]=='5'){ ?>
<input type='radio' id="cs_6" name="cs_6" value='5' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_6" name="cs_6" value='5' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_6"]=='4'){ ?>
<input type='radio' id="cs_6" name="cs_6" value='4' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_6" name="cs_6" value='4' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_6"]=='3'){ ?>
<input type='radio' id="cs_6" name="cs_6" value='3' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_6" name="cs_6" value='3' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_6"]=='2'){ ?>
<input type='radio' id="cs_6" name="cs_6" value='2' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_6" name="cs_6" value='2' >
<?php } ?>
</td>
<td>
<?php if($rs1["cs_6"]=='1'){ ?>
<input type='radio' id="cs_6" name="cs_6" value='1' checked="checked" >
<?php }else{ ?>
<input type='radio' id="cs_6" name="cs_6" value='1' >
<?php } ?>
</td>	
	
</tr>

</table>

<br>
ข้อเสนอแนะ
<textarea  class="w3-input" id="cs_des" name="cs_des" rows="4" style="width:90%" ><?php echo $rs1["cs_des"]; ?></textarea>	


<br><br>

</form>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>


  

