<?php 
include('head.php');

 ?>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>


<script language="JavaScript">
var HttPRequest = false;
function doCallAjax(product_id,product_code,product_name,) {
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
var url = 'data_product_add1.php';
var pmeters = "product_id=" + encodeURI( document.getElementById(product_id).value);
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

document.getElementById(product_code).value = myArr[0];
document.getElementById(product_name).value = myArr[1];


}
}
}
}

</script>




<?php /*<script type="text/javascript">
$(document).ready(function(){

$("#id_customer_run").change(function(){
$.ajax({
url: "returnCustomer2.php" ,
type: "POST",
data: 'sCusID=' +$("#id_customer_run").val()
})
.success(function(result) {
var obj = jQuery.parseJSON(result);
if(obj == '')
{
$('input[type=text]').val('');
}
else
{
$.each(obj, function(key, inval) {

$("#id_customer_run").val(inval["customer_id"]);
$("#customer_code").val(inval["customer_code"]);
$("#customer_name").val(inval["cistomer_name"]);
$("#status").val(inval["type_customer"]);
$("#payment_term").val(inval["credit"]);

});
}

});

});
});
</script>*/ ?>


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


<body>
<form   method="POST" name="frmMain"  enctype="multipart/form-data" action='edit_leaflet1.php' >
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>EDIT : ใบตรวจทาน</h4></div>
<?php
$strSQL = "SELECT *  FROM tb_product_leaflet WHERE leaflet_id = '".$_GET["leaflet_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL1 = "SELECT *  FROM tb_product WHERE product_id = '".$_GET["product_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);
	
	?>
<div class="w3-half">

<div class="w3-container ">
ID รหัสสินค้า
<input name="product_id" id ='product_id' value ="<?php echo $objResult1["product_ID"]; ?>" class="w3-input" placeholder="Search ชื่อสินค้า.." OnChange="JavaScript:doCallAjax('product_id','product_code','product_name');" required>
<input type ='hidden' name="h_product_id"  id="h_product_id" class="w3-input" >
</div>
	
<div class="w3-container ">
ชื่อสินค้า
<input name="product_name"  id = "product_name" value ="<?php echo $objResult1["sol_name"]; ?>" class="w3-input" >

</div>	
	
<div class="w3-container ">
ส่วนประกอบ 01
 <input name="ingredient1" value ="<?php echo $objResult["ingredient1"]; ?>"  class="w3-input" >

</div>

<div class="w3-container ">
ส่วนประกอบ 02
 <input name="ingredient2" value ="<?php echo $objResult["ingredient2"]; ?>"  class="w3-input" >

</div><div class="w3-container ">
 ส่วนประกอบ 03
 <input name="ingredient3" value ="<?php echo $objResult["ingredient3"]; ?>"  class="w3-input" >

</div><div class="w3-container ">
 ส่วนประกอบ 04
<input name="ingredient4" value ="<?php echo $objResult["ingredient4"]; ?>" class="w3-input" >

</div>

<div class="w3-container w3-fourth">
ส่วนประกอบ 05
<input name="ingredient5" value ="<?php echo $objResult["ingredient5"]; ?>"  class="w3-input" >
</div><div class="w3-container">
ส่วนประกอบ 06
 <input name="ingredient6" value ="<?php echo $objResult["ingredient6"]; ?>" class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 07
 <input name="ingredient7" value ="<?php echo $objResult["ingredient7"]; ?>" class="w3-input" >

</div>

<div class="w3-container">
ส่วนประกอบ 08
<input name="ingredient8" value ="<?php echo $objResult["ingredient8"]; ?>" class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 09
 <input name="ingredient9" value ="<?php echo $objResult["ingredient9"]; ?>" class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 10
<input name="ingredient10" value ="<?php echo $objResult["ingredient10"]; ?>"  class="w3-input" >

</div>

<div class="w3-container">
ส่วนประกอบ 11
<input name="ingredient11" value ="<?php echo $objResult["ingredient11"]; ?>"  class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 12

 <input name="ingredient12" value ="<?php echo $objResult["ingredient12"]; ?>"  class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 13
 <input name="ingredient13" value ="<?php echo $objResult["ingredient13"]; ?>"  class="w3-input" >

</div>

<div class="w3-container">
ส่วนประกอบ 14
<input name="ingredient14" value ="<?php echo $objResult["ingredient14"]; ?>"  class="w3-input" >

</div><div class="w3-container">
 ส่วนประกอบ 15
<input name="ingredient15" value ="<?php echo $objResult["ingredient15"]; ?>"  class="w3-input" >

</div><div class="w3-container">
 ส่วนประกอบ 16
<input name="ingredient16" value ="<?php echo $objResult["ingredient16"]; ?>"  class="w3-input" >

</div>

<div class="w3-container">
ส่วนประกอบ 17
<input  name="ingredient17" value ="<?php echo $objResult["ingredient17"]; ?>" class="w3-input" >

</div><div class="w3-container">
 ส่วนประกอบ 18
 <input name="ingredient18" value ="<?php echo $objResult["ingredient18"]; ?>" class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 19
<input name="ingredient19" value ="<?php echo $objResult["ingredient19"]; ?>" class="w3-input" >
 
</div>

<div class="w3-container">
ส่วนประกอบ 20
<input name="ingredient20" value ="<?php echo $objResult["ingredient20"]; ?>" class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 21
 <input name="ingredient21" value ="<?php echo $objResult["ingredient21"]; ?>" class="w3-input" >

</div><div class="w3-container">
 ส่วนประกอบ 22
 <input name="ingredient22" value ="<?php echo $objResult["ingredient22"]; ?>" class="w3-input" >

</div>

<div class="w3-container">
 ส่วนประกอบ 23
<input name="ingredient23" value ="<?php echo $objResult["ingredient23"]; ?>" class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 24
 <input name="ingredient24" value ="<?php echo $objResult["ingredient24"]; ?>" class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 25
 <input name="ingredient25" value ="<?php echo $objResult["ingredient25"]; ?>" class="w3-input" >

</div>

<div class="w3-container">
ส่วนประกอบ 26
<input name="ingredient26" value ="<?php echo $objResult["ingredient26"]; ?>" class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 27
<input name="ingredient27" value ="<?php echo $objResult["ingredient27"]; ?>" class="w3-input" >

</div><div class="w3-container">
ส่วนประกอบ 28
<input name="ingredient28" value ="<?php echo $objResult["ingredient28"]; ?>" class="w3-input" >

</div>

<div class="w3-container">
ส่วนประกอบ 29
<input name="ingredient29" value ="<?php echo $objResult["ingredient29"]; ?>" class="w3-input" >

</div>
	</div>
	
<div class="w3-half">	
	
	<div class="w3-container ">
รหัสสินค้า
<input name="product_code"  id="product_code" value ="<?php echo $objResult1["access_code"]; ?>" class="w3-input" >
<input type="hidden" name="leaflet_id"  id="leaflet_id" value ="<?php echo $objResult["leaflet_id"]; ?>" class="w3-input" >

</div>

<div class="w3-container ">
หมายเลขเครื่อง
<input name="product_sn" value ="<?php echo $objResult["product_sn"]; ?>"  class="w3-input" >

</div>
<div class="w3-container ">	
	
	Upload รูปภาพ 1<br>

<input name="img1"  type="file" style="width:30%;"> 
	<?php if($objResult['img1']!=''){ ?>
<a href="review/<?php echo $objResult['img1']; ?>" target="_blank"><img src="review/<?php echo $objResult['img1']; ?>" width="50" height="50" border="0" ></a> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img1';}><img src="img/false.png" width="25" height="25" border="0" /></a>
		<?php } ?>
<input type='hidden' name="up_img1" value="<?php echo $objResult["img1"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 2<br>
<input name="img2"  type="file" style="width:30%;"> 
		<?php if($objResult['img2']!=''){ ?>
<a href="review/<?php echo $objResult['img2']; ?>" target="_blank"><img src="review/<?php echo $objResult['img2']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img2';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img2" value="<?php echo $objResult["img2"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 3<br>
<input name="img3"  type="file" style="width:30%;"> 
		<?php if($objResult['img3']!=''){ ?>
<a href="review/<?php echo $objResult['img3']; ?>" target="_blank"><img src="review/<?php echo $objResult['img3']; ?>" width="50" height="50" border="0" ></a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img3';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img3" value="<?php echo $objResult["img3"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 4<br>
<input name="img4"  type="file" style="width:30%;"> 
		<?php if($objResult['img4']!=''){ ?>
<a href="review/<?php echo $objResult['img4']; ?>" target="_blank"><img src="review/<?php echo $objResult['img4']; ?>" width="50" height="50" border="0" ></a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img4';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img4" value="<?php echo $objResult["img4"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 5<br>
<input name="img5"  type="file" style="width:30%;"> 
		<?php if($objResult['img5']!=''){ ?>
<a href="review/<?php echo $objResult['img5']; ?>" target="_blank"><img src="review/<?php echo $objResult['img5']; ?>" width="50" height="50" border="0" ></a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img5';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img5" value="<?php echo $objResult["img5"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 6<br>
<input name="img6"  type="file" style="width:30%;"> 
		<?php if($objResult['img6']!=''){ ?>
<a href="review/<?php echo $objResult['img6']; ?>" target="_blank"><img src="review/<?php echo $objResult['img6']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img6';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img6" value="<?php echo $objResult["img6"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 7<br>
<input name="img7"  type="file" style="width:30%;"> 
		<?php if($objResult['img7']!=''){ ?>
<a href="review/<?php echo $objResult['img7']; ?>" target="_blank"><img src="review/<?php echo $objResult['img7']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img7';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img7" value="<?php echo $objResult["img7"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 8<br>
<input name="img8"  type="file" style="width:30%;"> 
		<?php if($objResult['img8']!=''){ ?>
<a href="review/<?php echo $objResult['img8']; ?>" target="_blank"><img src="review/<?php echo $objResult['img8']; ?>" width="50" height="50" border="0" ></a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img8';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img8" value="<?php echo $objResult["img8"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 9<br>
<input name="img9"  type="file" style="width:30%;"> 
		<?php if($objResult['img9']!=''){ ?>
<a href="review/<?php echo $objResult['img9']; ?>" target="_blank"><img src="review/<?php echo $objResult['img9']; ?>" width="50" height="50" border="0" ></a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img9';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img9" value="<?php echo $objResult["img9"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 10<br>
<input name="img10"  type="file" style="width:30%;"> 
		<?php if($objResult['img10']!=''){ ?>
<a href="review/<?php echo $objResult['img10']; ?>" target="_blank"><img src="review/<?php echo $objResult['img10']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img10';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img10" value="<?php echo $objResult["img10"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 11<br>
<input name="img11"  type="file" style="width:30%;"> 
		<?php if($objResult['img11']!=''){ ?>
<a href="review/<?php echo $objResult['img11']; ?>" target="_blank"><img src="review/<?php echo $objResult['img11']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img11';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img11" value="<?php echo $objResult["img11"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 12<br>
<input name="img12"  type="file" style="width:30%;"> 
		<?php if($objResult['img12']!=''){ ?>
<a href="review/<?php echo $objResult['img12']; ?>" target="_blank"><img src="review/<?php echo $objResult['img12']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img12';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img12" value="<?php echo $objResult["img12"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 13<br>
<input name="img13"  type="file" style="width:30%;"> 
		<?php if($objResult['img13']!=''){ ?>
<a href="review/<?php echo $objResult['img13']; ?>" target="_blank"><img src="review/<?php echo $objResult['img13']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img13';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img13" value="<?php echo $objResult["img13"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 14<br>
<input name="img14"  type="file" style="width:30%;"> 
		<?php if($objResult['img14']!=''){ ?>
<a href="review/<?php echo $objResult['img14']; ?>" target="_blank"><img src="review/<?php echo $objResult['img14']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img14';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img14" value="<?php echo $objResult["img14"]; ?>" class="w3-input" >
	
	</div>
	<div class="w3-container ">	
	Upload รูปภาพ 15<br>
<input name="img15"  type="file" style="width:30%;"> 
		<?php if($objResult['img15']!=''){ ?>
<a href="review/<?php echo $objResult['img15']; ?>" target="_blank"><img src="review/<?php echo $objResult['img15']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img15';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img15" value="<?php echo $objResult["img15"]; ?>" class="w3-input" >
	
	</div>
	<div class="w3-container ">	
	Upload รูปภาพ 16<br>
<input name="img16"  type="file" style="width:30%;"> 
		<?php if($objResult['img16']!=''){ ?>
<a href="review/<?php echo $objResult['img16']; ?>" target="_blank"><img src="review/<?php echo $objResult['img16']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img16';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img16" value="<?php echo $objResult["img16"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 17<br>
<input name="img17"  type="file" style="width:30%;"> 
		<?php if($objResult['img17']!=''){ ?>
<a href="review/<?php echo $objResult['img17']; ?>" target="_blank"><img src="review/<?php echo $objResult['img17']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img17';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img17" value="<?php echo $objResult["img17"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 18<br>
<input name="img18"  type="file" style="width:30%;"> 
		<?php if($objResult['img18']!=''){ ?>
<a href="review/<?php echo $objResult['img18']; ?>" target="_blank"><img src="review/<?php echo $objResult['img18']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img18';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img18" value="<?php echo $objResult["img18"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 19<br>
<input name="img19"  type="file" style="width:30%;"> 
		<?php if($objResult['img19']!=''){ ?>
<a href="review/<?php echo $objResult['img19']; ?>" target="_blank"><img src="review/<?php echo $objResult['img19']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img19';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img19" value="<?php echo $objResult["img19"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 20<br>
<input name="img20"  type="file" style="width:30%;"> 
		<?php if($objResult['img20']!=''){ ?>
<a href="review/<?php echo $objResult['img20']; ?>" target="_blank"><img src="review/<?php echo $objResult['img20']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img20';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img20" value="<?php echo $objResult["img20"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 21<br>
<input name="img21"  type="file" style="width:30%;"> 
		<?php if($objResult['img21']!=''){ ?>
<a href="review/<?php echo $objResult['img21']; ?>" target="_blank"><img src="review/<?php echo $objResult['img21']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img21';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img21" value="<?php echo $objResult["img21"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 22<br>
<input name="img22"  type="file" style="width:30%;"> 
		<?php if($objResult['img22']!=''){ ?>
<a href="review/<?php echo $objResult['img22']; ?>" target="_blank"><img src="review/<?php echo $objResult['img22']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img22';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img22" value="<?php echo $objResult["img22"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 23<br>
<input name="img23"  type="file" style="width:30%;"> 
		<?php if($objResult['img23']!=''){ ?>
<a href="review/<?php echo $objResult['img23']; ?>" target="_blank"><img src="review/<?php echo $objResult['img23']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img23';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img23" value="<?php echo $objResult["img23"]; ?>" class="w3-input" >
	
	</div>
	<div class="w3-container ">	
	Upload รูปภาพ 24<br>
<input name="img24"  type="file" style="width:30%;"> 
		<?php if($objResult['img24']!=''){ ?>
<a href="review/<?php echo $objResult['img24']; ?>" target="_blank"><img src="review/<?php echo $objResult['img24']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img24';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img24" value="<?php echo $objResult["img24"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 25<br>
<input name="img25"  type="file" style="width:30%;"> 
		<?php if($objResult['img25']!=''){ ?>
<a href="review/<?php echo $objResult['img25']; ?>" target="_blank"><img src="review/<?php echo $objResult['img25']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img25';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img25" value="<?php echo $objResult["img25"]; ?>" class="w3-input" >
	
	</div>
	<div class="w3-container ">	
	Upload รูปภาพ 26<br>
<input name="img26"  type="file" style="width:30%;"> 
		<?php if($objResult['img26']!=''){ ?>
<a href="review/<?php echo $objResult['img26']; ?>" target="_blank"><img src="review/<?php echo $objResult['img26']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img26';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img26" value="<?php echo $objResult["img26"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 27<br>
<input name="img27"  type="file" style="width:30%;"> 
		<?php if($objResult['img27']!=''){ ?>
<a href="review/<?php echo $objResult['img27']; ?>" target="_blank"><img src="review/<?php echo $objResult['img27']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img27';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img27" value="<?php echo $objResult["img27"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 28<br>
<input name="img28"  type="file" style="width:30%;"> 
		<?php if($objResult['img28']!=''){ ?>
<a href="review/<?php echo $objResult['img28']; ?>" target="_blank"><img src="review/<?php echo $objResult['img28']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img28';}><img src="img/false.png" width="25" height="25" border="0" /></a>
			<?php } ?>
<input type='hidden' name="up_img28" value="<?php echo $objResult["img28"]; ?>" class="w3-input" >
	
	</div>
	
	<div class="w3-container ">	
	Upload รูปภาพ 29<br>
<input name="img29"  type="file" style="width:30%;"> 
		<?php if($objResult['img29']!=''){ ?>
<a href="review/<?php echo $objResult['img29']; ?>" target="_blank"><img src="review/<?php echo $objResult['img29']; ?>" width="50" height="50" border="0" ></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=javascript:if(confirm('ต้องการลบรูปนี้ใช่หรือไม่')==true){window.location='delete_leaflet.php?leaflet_id=<?php echo $objResult["leaflet_id"];?>&name=img29';}><img src="img/false.png" width="25" height="25" border="0" /></a>
		<?php } ?>
<input type='hidden' name="up_img29" value="<?php echo $objResult["img29"]; ?>" class="w3-input" >
	
	</div>	</div>





<br>
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='edit_leaflet1.php'; submit()">
</center>

<br>

	</div>	</div>


<div id="cr_bar"> <?php include "foot.php"; ?></div>		


</form>

</body>
</html>

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
		return "data_product_lesflet.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_id","h_product_id");
        </script>



