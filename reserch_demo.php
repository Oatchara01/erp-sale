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

<form action='reserch_demo1.php' method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();" >
		
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
	
$sql = "SELECT *   FROM hos__br where ref_id_br ='".$ref_id_br."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);


$strSQL1 = "SELECT id,sol_name,product_code FROM  (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$ref_id_br."' and product_type ='สินค้าสาธิต'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	?>
	<input type="hidden" name = "ref_id_br" id="ref_id_br" style="width:90%;"  value="<?php echo $ref_id_br; ?>" class = "w3-input" >
<?php
$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

	
?>
	
<br><fieldset><legend><font color ="red"><b>สินค้า <?php echo $i; ?></b></font></legend><br>
	
	
	
<div class="w3-half 1">

		วันที่ : <input type="date" name = "date_reseach[<?php echo $objResult1["id"];?>]" id="date_reseach[<?php echo $objResult1["id"];?>]" style="width:90%;"  value="<?php echo $today; ?>" class = "w3-input" readonly> 	
	ชื่อลูกค้า  : 

<input type='text' value="<?php echo $rs["customer"]; ?>" class="w3-input"   style="width:90%;"  readonly> 
	<input type='hidden' id = 'sale_code'  name = 'sale_code' value="<?php echo $rs["sale_code"]; ?>" class="w3-input"   style="width:90%;"  readonly> 
	<input type='hidden' id = 'iv_date'  name = 'iv_date' value="<?php echo $rs["iv_date"]; ?>" class="w3-input"   style="width:90%;"  readonly> 

			
<input type="hidden" name = "id[<?php echo $objResult1["id"];?>]" id="id[<?php echo $objResult1["id"];?>]" style="width:90%;"  value="<?php echo $objResult1["id"]; ?>" class = "w3-input" >			
<input type="hidden" name = "allwell[<?php echo $objResult1["id"];?>]" id="allwell[<?php echo $objResult1["id"];?>]" style="width:90%;"  value="<?php echo '0'; ?>" class = "w3-input" >			

			
</div>
		
		<div class="w3-half 1">
		เลขที่เอกสาร  : <input type='text' name="iv_no[<?php echo $objResult1["id"];?>]" value="<?php echo $rs["iv_no"]; ?>" style="width:90%;" class="w3-input" readonly>
			
			ชื่อสินค้า
<textarea  class="w3-input" rows="2" style="width:90%" readonly><?php echo $objResult1["sol_name"]; ?></textarea>
	<input type='hidden' name="product_iddemo[<?php echo $objResult1["id"];?>]" id="product_iddemo[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["product_code"]; ?>" class="w3-input"   style="width:90%;"  /> 					
</div><!--div class="w3-container w3-padding-large" -->


<h8><b>ส่วนที่ 1 คุณภาพสินค้า</b></h8><br>	
	
<table width="100%" border="1" class="w3-table">
<thead>
	<th  width="2%">ลำดับ</th>
    <th  width="25%">รายการ</th>
    <th  width="5%">1</th>
    <th  width="5%">2</th>
    <th  width="5%">3</th>
    <th  width="5%">4</th>
	<th  width="5%">5</th>
	<th  width="5%">6</th>
	<th  width="5%">7</th>
    <th  width="5%">8</th>
    <th  width="5%">9</th>
    <th  width="5%">10</th>
	

</thead>
	
<?php
$questions = [
    1 => 'ภาพลักษณ์ ความสวยงาม ความสะอาด',
    2 => 'ฟังก์ชันการใช้งาน สามารถใช้งานได้ดี',
    3 => 'อุปกรณ์ประกอบครบถ้วน',
    4 => 'มีสติ๊กเกอร์ช่องทางการติดต่อครบถ้วน',
    5 => 'มีใบปะการใช้งาน และ VDO การใช้งานครบถ้วน'
];

foreach ($questions as $no => $text) {
?>
<tr>
    <td><?php echo $no; ?></td>
    <td><div align="left"><?php echo $text; ?></div></td>

    <?php for ($score = 1; $score <= 10; $score++) { ?>
        <td>
            <input 
                type="radio"
                name="ckk_<?php echo $no; ?>[<?php echo $objResult1["id"]; ?>]"
                value="<?php echo $score; ?>"
                <?php echo ($score == 10) ? 'checked="checked"' : ''; ?>
            >
        </td>
    <?php } ?>
</tr>
<?php } ?>
	

</table>

<br>
ข้อเสนอแนะ
<textarea  class="w3-input" id="ckk_des[<?php echo $objResult1["id"];?>]" name="ckk_des[<?php echo $objResult1["id"];?>]" rows="4" style="width:90%" ></textarea>	


<br><br>
	
<h8><b>ส่วนที่ 2 การจัดส่ง และการบริการ</b></h8><br>	
	
<table width="100%" border="1" class="w3-table">
<thead>
	<th  width="2%">ลำดับ</th>
    <th  width="25%">รายการ</th>
    <th  width="5%">1</th>
    <th  width="5%">2</th>
    <th  width="5%">3</th>
    <th  width="5%">4</th>
	<th  width="5%">5</th>
	<th  width="5%">6</th>
	<th  width="5%">7</th>
    <th  width="5%">8</th>
    <th  width="5%">9</th>
    <th  width="5%">10</th>
	

</thead>
	
<?php
$cs_questions = [
    1 => 'ความถูกต้องครบถ้วนของอุปกรณ์ที่เบิกไปสาธิต',
    2 => 'คุณภาพการบริการจัดส่งสินค้าสาธิต (การเคลื่อนย้ายสินค้า การดูแลสถานที่ห้องลูกค้า)',
    3 => 'ส่งมอบสินค้าสาธิตได้ตามเวลาที่นัดหมาย',
    4 => 'พนักงานจัดส่งมีการโทรประสานงาน',
    5 => 'การแต่งกาย และการวางตัวเหมาะสม',
    6 => 'ความพึงพอใจในสินค้าสาธิต และการบริการ'
];

foreach ($cs_questions as $no => $text) {
?>
<tr>
    <td><?php echo $no; ?></td>
    <td><div align="left"><?php echo $text; ?></div></td>

    <?php for ($score = 1; $score <= 10; $score++) { ?>
        <td>
            <input
                type="radio"
                name="cs_<?php echo $no; ?>[<?php echo $objResult1["id"]; ?>]"
                value="<?php echo $score; ?>"
                <?php echo ($score == 10) ? 'checked="checked"' : ''; ?>
            >
        </td>
    <?php } ?>
</tr>
<?php } ?>
</table>

<br>
ข้อเสนอแนะ
<textarea  class="w3-input" id="cs_des[<?php echo $objResult1["id"];?>]" name="cs_des[<?php echo $objResult1["id"];?>]" rows="4" style="width:90%" ></textarea>	


<br><br>	
</fieldset>
	
	
<?php $i++; } ?>	
<br><br>
	
<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>

<br><br>
</form>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>


  

