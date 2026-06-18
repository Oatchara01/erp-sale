<?php include ("head.php"); ?>

<script language="JavaScript">

var HttPRequest = false;
function doCallAjax1(bill_id,customer_name) {
HttPRequest = false;
if (window.XMLHttpRequest) { // Mozilla, Safari,...
HttPRequest = new XMLHttpRequest();

if (HttPRequest.overrideMimeType) {
HttPRequest.overrideMimeType('text/html');
}
} else if (window.ActiveXObject) { // IE
try {
HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
try {
HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
} catch (e) {}
}
}

if (!HttPRequest) {

alert('Cannot create XMLHTTP instance');
return false;
}
var url = 'data_bill_name1.php';
var pmeters = "bill_id=" + encodeURI( document.getElementById(bill_id).value);
HttPRequest.open('POST',url,true);

HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
HttPRequest.setRequestHeader("Content-length", pmeters.length);
HttPRequest.setRequestHeader("Connection", "close");
HttPRequest.send(pmeters);

HttPRequest.onreadystatechange = function()
{
if(HttPRequest.readyState == 4) // Return Request
{
var myProduct = HttPRequest.responseText;

if(myProduct != "")
{

var myArr = myProduct.split("|");

document.getElementById(customer_name).value = myArr[0];
	
}
}
}
}

    
</script>


<script>
 


function object() {
		if (document.getElementById('object1').checked) {
			document.getElementById('dt1').style.display = 'block';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
		}
		else if (document.getElementById('object2').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'block';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
		}
		else if (document.getElementById('object3').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'block';
			document.getElementById('dt4').style.display = 'none';
		}
		else if (document.getElementById('object4').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'block';
		}
	
	}


function ckk_1() {
		if (document.getElementById('object5').checked) {
			document.getElementById('dt5').style.display = 'block';
		}
		else if (document.getElementById('object6').checked) {
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object7').checked) {
			document.getElementById('dt5').style.display = 'none';
		}
}



function ckk_2() {
		if (document.getElementById('object8').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
		else if (document.getElementById('object9').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
		else if (document.getElementById('object10').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
			else if (document.getElementById('object11').checked) {
			document.getElementById('dv1').style.display = 'none';
			document.getElementById('dv2').style.display = 'block';
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

$sql = "SELECT *   FROM hos__breg where ref_id = '".$ref_id."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

	 ?>

	<!--action="register_office1.php"-->
	<form  method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();" >
		
<script language="javascript">
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
	
		
	document.frmMain.submit();
}


</script>
<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			
			<div class="w3-panel w3-light-gray"><div class="w3-half"><h4>ใบขอเบิกอะไหล่จากสินค้าขาย (BREG)</h4></div>
<div class="w3-half">
<a href="bregdm_app.php?ref_id=<?php echo $rs["ref_id"];?>&add_by=<?php echo $rs["add_by"]; ?>&iv_no=<?php echo $rs["iv_no"]; ?>&customer_name=<?php echo $rs["customer_name"]; ?>&company=<?php echo $rs["type_doc"]; ?>"  class="w3-button w3-green w3-center"><font color="black">Approve</font></a>
<a href="bregdm_reject.php?ref_id=<?php echo $rs["ref_id"];?>"  class="w3-button w3-red w3-center"><font color="black">Rejected</font></a>&nbsp;&nbsp;
					
<a href="from_breg.php?ref_id=<?php echo $rs["ref_id"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="purple">แบบฟอร์มใบขอเบิก</font></a>

				</div>
			</div>
<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;			
			
			?>
			
<div class="w3-bar">
	<?php if($rs["type_doc"]=='1'){ ?>	
<input type="radio" checked='checked' name="type_doc" value = "1">&nbsp;AWL
<input type="radio"  name="type_doc" value = "2">&nbsp;NBM
	<?php }else if($rs["type_doc"]=='2'){ ?>
<input type="radio"  name="type_doc" value = "1">&nbsp;AWL
<input type="radio" checked='checked' name="type_doc" value = "2">&nbsp;NBM	
	<?php } ?>

	    <span class="w3-light-grey w3-right"> วันที่ : <?php echo Datethai($rs["register_date"]); ?></span><br>
	<input type="hidden" name = "register_date" id="register_date" style="width:90%;"  value="<?php echo $today; ?>" class = "w3-input"> 	
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $rs["ref_id"]; ?></span>
		<input type="hidden" name="ref_id"  id="ref_id" class="w3-input" value="<?php echo $rs["ref_id"]; ?>">
	</div>

</p>


		<div class="w3-half 1">

		รหัสลูกค้า  : 

<input type='text' name = "bill_id" value="<?php echo $rs["bill_id"]; ?>" id = "bill_id" class="w3-input" placeholder="Search ชื่อลูกค้า..."  style="width:90%;" OnChange="JavaScript:doCallAjax1('bill_id','customer_name');"/> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id"  class="button4" readonly>	
			
			วัตถุประสงค์การเบิก
<textarea name="description" id="description" class="w3-input" rows="2" style="width:90%"><?php echo $rs["description"]; ?></textarea>			
			
</div>
		
		<div class="w3-half 1">
ชื่อลูกค้า :
				
<input type='text' name = "customer_name" value="<?php echo $rs["customer_name"]; ?>" id = "customer_name" style="width:90%;" class="w3-input" >
			
เลขที่ PER :
<input type='text' name = "per_no" value="<?php echo $rs["per_no"]; ?>" id = "per_no" style="width:90%;" class="w3-input" >

เลขที่ใบงานบริการ :
<input type='text' name = "cm_no" value="<?php echo $rs["cm_no"]; ?>" id = "cm_no" style="width:90%;" class="w3-input" >
	<br>					
</div>
		

</p>



<div class="w3-bar w3-light-grey w3-border">
<a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการอะไหล่ที่ต้องการเบิก</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>เบิกอะไหล่จากสินค้า</b></font></a>
</div>
<div id="pd" class="w3-container city1" >

<table width="100%" border="0" class="w3-table">
<thead>

    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
   <th>หมายเเลขเครื่อง</th> 
   <th>หมายเหตุ</th>
	
</thead>
<?php 
$strSQL1 = "SELECT * FROM  (hos__subbreg1 LEFT JOIN tb_product ON tb_product.product_ID=hos__subbreg1.product_id1) WHERE ref_id1 = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
	
	?>
<tr>
<td style="width:15%;">
<input type='text' name = "product_code" value="<?php echo $objResult1["access_code"]; ?>" id = "product_code" class="w3-input" readonly> 
<input type='hidden' name = "product_id" value="<?php echo $objResult1["product_id1"]; ?>" id = "product_id" class="w3-input" >
<input type='hidden' name = "id_sub" value="<?php echo $objResult1["id_sub1"]; ?>" id = "id_sub" class="w3-input" >
</td>
<td  style="width:20%;">
<textarea  name = "product_name"  id = "product_name"  rows="2" class="w3-input" readonly><?php echo $objResult1["sol_name"]; ?></textarea>
</td>
<td style="width:8%;">
<input type='text' name = "unit_name"  value="<?php echo $objResult1["unit_name"]; ?>"  id = "unit_name"  class="w3-input" />
</td>
<td style="width:8%;">
<input type='text' name = "sale_count" id = "sale_count" value="<?php echo $objResult1["count1"]; ?>" class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:10%;">
<textarea name = "sn_number"  id = "sn_number"  class="w3-input" ><?php echo $objResult1["sn_number1"]; ?></textarea>
</td>

<td style="width:20%;">
<textarea name = "remark_eng"  id = "remark_eng"  class="w3-input" ><?php echo $objResult1["remark_eng1"]; ?></textarea>
</td>

</tr>
	<?php
$i++;
} 
	?>
</table>	
	
	
</div>

<br>
		
<div id="cs" class="w3-container city1" style="display:none">		
	<table width="100%" border="0" class="w3-table">
<tr>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>หมายเลขเครื่อง</th>
    <th>หมายเหตุ</th>
	<th>ประเภทสินค้า</th>
	</tr>	
	<?php 
$strSQL2 = "SELECT * FROM  (hos__subbreg2 LEFT JOIN tb_product ON tb_product.product_ID=hos__subbreg2.product_id2) WHERE ref_id2 = '".$ref_id."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

$j = 1;
while($objResult2 = mysqli_fetch_array($objQuery2))
{
	
	
	?>	
	<tr>
<td style="width:10%;">
<input type='text' name = "product_code_1" value="<?php echo $objResult2["access_code"]; ?>" id = "product_code_1" class="w3-input" > 
<input type='hidden' name = "id_sub2" value="<?php echo $objResult2["id_sub2"]; ?>" id = "id_sub2"  class="button4" readonly>	
<input type='hidden' name = "product_id_1" value="<?php echo $objResult2["product_id2"]; ?>" id = "product_id_1" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name_1"  id = "product_name_1"  rows="2" class="w3-input" readonly><?php echo $objResult2["sol_name"]; ?></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name_1"  id = "unit_name_1" value="<?php echo $objResult2["unit_name"]; ?>" class="w3-input" />
</td>
<td style="width:5%;">
<input type='text' name = "sale_count_1" id = "sale_count_1" value="<?php echo $objResult2["count2"]; ?>" class="w3-input" style="color:black;text-align:center"  />
</td>

<td style="width:10%;">
<textarea name = "sn_number_1"  id = "sn_number_1"  class="w3-input" ><?php echo $objResult2["sn_number2"]; ?></textarea>
</td>

<td style="width:10%;">
<textarea name = "remark_eng_1"  id = "remark_eng_1"  class="w3-input" ><?php echo $objResult2["remark_eng2"]; ?></textarea>
</td>

<td style="width:10%;">
<input type="text" name = "type_probd_1"  id = "type_probd_1" value="<?php echo $objResult2["type_probd"]; ?>" class="w3-input" readonly>
</td>

</tr>

<?php 
$j++;
} 
		?>	
		
		
		</table>
	
	

</div>

<br>	
</form>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	</body>

  <!--/div-->

  

<script type="text/javascript">
function make_autocom(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_bill_name.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("bill_id","h_bill_id");
</script> 


<script type="text/javascript">
function make_autocom(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_sale1.php?employee_name_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("employee_name","h_employee_name");
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