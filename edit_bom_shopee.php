<?php 


include('head.php');
include("dbconnect.php");

 
 
 ?>
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


<body>
<form   method="POST" name="frmMain" >
<div class="w3-panel w3-light-gray"><h4>EDIT : PRODUCT SHOPEE</h4></div>
<?php
		$strSQL = "SELECT *  FROM tb_product_shopee WHERE shopee_id = '".$_GET["shopee_id"]."' ";


		$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);
	?>


	


<div class="w3-container w3-third">
รหัสสินค้า
<input name="code_shopee" value="<?php echo $objResult["code_shopee"]; ?>" class="w3-input" >

</div><div class="w3-container w3-third">
ชื่อสินค้า
<input name="name_shopee" value="<?php echo $objResult["name_shopee"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
ราคาขาย
<input name="price_shopee" value="<?php echo $objResult["price_shopee"]; ?>" class="w3-input" >
</div>

<div class="w3-container w3-third">
<?php
		$strSQL1 = "SELECT *  FROM tb_product WHERE Product_ID = '".$objResult["id_product1"]."' ";


		$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
		$objResult1 = mysqli_fetch_array($objQuery1);
	?>

ID สินค้า 1
<input name="id_product1" value="<?php echo $objResult["id_product1"]; ?>" class="w3-input" placeholder="Search ชื่อสินค้า...">
<input type='hidden' name = "h_id_product1"  id = "h_id_product1"  class="w3-input" >
</div><div class="w3-container w3-third">
ชื่อสินค้า 1
<input  value="<?php echo $objResult1["access_name"]; ?>" class="w3-input" >

</div><div class="w3-container w3-third">
จำนวน 1
<input name="unit1" value="<?php echo $objResult["unit1"]; ?>" class="w3-input" >
</div>
	<div class="w3-container w3-third">
จำนวนปีที่รับประกัน 1
<input name="waranty1" value="<?php echo $objResult["waranty1"]; ?>" class="w3-input" >
</div>
<div class="w3-container w3-third">
<?php
		$strSQL2 = "SELECT *  FROM tb_product WHERE Product_ID = '".$objResult["id_product2"]."' ";


		$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
		$objResult2 = mysqli_fetch_array($objQuery2);
	?>
ID สินค้า  2

<input name="id_product2" value="<?php echo $objResult["id_product2"]; ?>" class="w3-input" placeholder="Search ชื่อสินค้า...">
<input type='hidden' name = "h_id_product2"  id = "h_id_product2"  class="w3-input" >
</div><div class="w3-container w3-third">
ชื่อสินค้า 2
<input  value="<?php echo $objResult2["access_name"]; ?>" class="w3-input" >

</div><div class="w3-container w3-third">
จำนวน 2
<input name="unit2" value="<?php echo $objResult["unit2"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
จำนวนปีที่รับประกัน 2
<input name="waranty2" value="<?php echo $objResult["waranty2"]; ?>" class="w3-input" >
</div>
<div class="w3-container w3-third">
<?php
		$strSQL3 = "SELECT *  FROM tb_product WHERE Product_ID = '".$objResult["id_product3"]."' ";


		$objQuery3 = mysqli_query($conn,$strSQL3) or die(mysqli_error());
		$objResult3 = mysqli_fetch_array($objQuery3);
	?>
ID สินค้า 3
<input name="id_product3" value="<?php echo $objResult["id_product3"]; ?>" class="w3-input" placeholder="Search ชื่อสินค้า...">
<input type='hidden' name = "h_id_product3"  id = "h_id_product3"  class="w3-input" >
</div><div class="w3-container w3-third">
ชื่อสินค้า 3
<input  value="<?php echo $objResult3["access_name"]; ?>" class="w3-input" >

</div><div class="w3-container w3-third">
จำนวน 3
<input name="unit3" value="<?php echo $objResult["unit3"]; ?>" class="w3-input" >
<input type = 'hidden' name="shopee_id" value="<?php echo $objResult["shopee_id"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
จำนวนปีที่รับประกัน 3
<input name="waranty3" value="<?php echo $objResult["waranty3"]; ?>" class="w3-input" >
</div>

<div class="w3-container w3-third">
<?php
		$strSQL4 = "SELECT *  FROM tb_product WHERE Product_ID = '".$objResult["id_product4"]."' ";


		$objQuery4 = mysqli_query($conn,$strSQL4) or die(mysqli_error());
		$objResult4 = mysqli_fetch_array($objQuery4);
	?>
ID สินค้า 4
<input name="id_product4" value="<?php echo $objResult["id_product4"]; ?>" class="w3-input" placeholder="Search ชื่อสินค้า...">
<input type='hidden' name = "h_id_product4"  id = "h_id_product4"  class="w3-input" >
</div><div class="w3-container w3-third">
ชื่อสินค้า 4
<input  value="<?php echo $objResult4["access_name"]; ?>" class="w3-input" >

</div><div class="w3-container w3-third">
จำนวน 4
<input name="unit4" value="<?php echo $objResult["unit4"]; ?>" class="w3-input" >
<input type = 'hidden' name="shopee_id" value="<?php echo $objResult["shopee_id"]; ?>" class="w3-input" >
</div><div class="w3-container w3-third">
จำนวนปีที่รับประกัน 4
<input name="waranty4" value="<?php echo $objResult["waranty4"]; ?>" class="w3-input" >
</div>


<br>
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='edit_bom_shopee1.php'; submit()">
</center>

</p>



<?php include('foot.php'); ?>















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
		return "data_product_add.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("id_product1","h_id_product1");
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
		return "data_product_add.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("id_product2","h_id_product2");
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
		return "data_product_add.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("id_product3","h_id_product3");
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
		return "data_product_add.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("id_product4","h_id_product4");
        </script>