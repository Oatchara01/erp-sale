<?php 


include('head.php');

 
 
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
<form   method="GET" name="frmMain" enctype="multipart/form-data" >
<div class="w3-panel w3-light-gray"><h4>ADD : PRODUCT SHOPEE</h4></div>


<div class="w3-container w3-third">
รหัสสินค้า
<input name="code_shopee" class="w3-input" >

</div><div class="w3-container w3-third">
ชื่อสินค้า
<input name="name_shopee" class="w3-input" >
</div><div class="w3-container w3-third">
ราคาขาย
<input name="price_shopee" class="w3-input" >
</div>

<div class="w3-container w3-third">
ID สินค้า 1

<input name="id_product1" class="w3-input" placeholder="Search ชื่อสินค้า...">
<input type='hidden' name = "h_id_product1"  id = "h_id_product1"  class="w3-input" >

</div><div class="w3-container w3-third">
จำนวน 1
<input name="unit1" class="w3-input" >
</div><div class="w3-container w3-third">
จำนวนปีรับประกัน 1
<input name="waranty1" class="w3-input" >
</div>
<div class="w3-container w3-third">
ID สินค้า  2

<input name="id_product2" class="w3-input" placeholder="Search ชื่อสินค้า...">
<input type='hidden' name = "h_id_product2"  id = "h_id_product2"  class="w3-input" >

</div><div class="w3-container w3-third">
จำนวน 2
<input name="unit2" class="w3-input" >
</div><div class="w3-container w3-third">
จำนวนปีรับประกัน 2
<input name="waranty2" class="w3-input" >
</div>
<div class="w3-container w3-third">
ID สินค้า 3
<input name="id_product3" class="w3-input" placeholder="Search ชื่อสินค้า...">
<input type='hidden' name = "h_id_product3"  id = "h_id_product3"  class="w3-input" >

</div><div class="w3-container w3-third">
จำนวน 3
<input name="unit3" class="w3-input" >
</div><div class="w3-container w3-third">
จำนวนปีรับประกัน 3
<input name="waranty3" class="w3-input" >
</div>
<div class="w3-container w3-third">
ID สินค้า 4
<input name="id_product4" class="w3-input" placeholder="Search ชื่อสินค้า...">
<input type='hidden' name = "h_id_product4"  id = "h_id_product4"  class="w3-input" >

</div><div class="w3-container w3-third">
จำนวน 4
<input name="unit4" class="w3-input" >
</div><div class="w3-container w3-third">
จำนวนปีรับประกัน 4
<input name="waranty4" class="w3-input" >
</div>




<br>
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='add_bom_shopee1.php'; submit()">
</center>

</p>


<div class="w3-container w3-bar w3-quarter">
			ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
		<div class="w3-bar w3-quarter w3-padding-xsmall">
		<input type="submit" class="w3-button w3-teal" value="Search"></div>
		</div>

<?php
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';

include "dbconnect.php";

$strSQL = "SELECT *  FROM tb_product_shopee  where 1";

if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND code_shopee  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or name_shopee  LIKE "%'.$Keyword.'%"'; 

}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



$Per_Page = '20';  
	$Page = isset($_GET['Page']) ? $_GET['Page'] : '';

	if(!isset($_GET['Page']))
	{
		$Page=1;
	}

	$Prev_Page = $Page-1;
	$Next_Page = $Page+1;

	$Page_Start = (($Per_Page*$Page)-$Per_Page);
	if($Num_Rows<=$Per_Page)
	{
		$Num_Pages =1;
	}
	else if(($Num_Rows % $Per_Page)==0)
	{
		$Num_Pages =($Num_Rows/$Per_Page) ;
	}
	else
	{
		$Num_Pages =($Num_Rows/$Per_Page)+1;
		$Num_Pages = (int)$Num_Pages;
	}


$strSQL .=" order  by shopee_id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);
?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="15%">ID สินค้า</th>
			<th width="15%">รหัสสินค้า</th>
			<th width="15%">ชื่อสินค้า</th> 
			<th width="15%">ราคา</th>
			<th width="5%">แก้ไข</th>
	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
				<td><?php echo $objResult["shopee_id"];?></td>
				<td><?php echo $objResult["code_shopee"];?></td>
				<td><?php echo $objResult["name_shopee"];?></td>
				<td><?php $price_shopee=$objResult["price_shopee"]; echo number_format( $price_shopee,2)."";?></td>

				<td><a href="edit_bom_shopee.php?shopee_id=<?php echo $objResult["shopee_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>



</tr>
</tbody>
			

<?php
}
?>

</table>
<div class="w3-panel"><strong>พบทั้งหมด</strong> <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword'><span class='style40'>Next>></span></a> ";
	}
	
	?>
</div>
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

