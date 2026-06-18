<?php error_reporting(~E_NOTICE); ?>
<html>
	<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>


<head>
<title>Select Product</title>
<link rel="stylesheet" href="css/w3.css">
</head>
<script language="javascript">
	function selData(no1,ProductID,ProductCode,ProductName,Unit,Price)
	{

		var sProductID = self.opener.document.getElementById("product_id" +no1);
		sProductID.value = ProductID;

		var sProductCode = self.opener.document.getElementById("access_code" +no1);
		sProductCode.value = ProductCode;

		var sProductName = self.opener.document.getElementById("access_name" +no1);
		sProductName.value = ProductName;

		var sUnit = self.opener.document.getElementById("unit_name" +no1);
		sUnit.value = Unit;

		var sPrice = self.opener.document.getElementById("sol_price" +no1);
		sPrice.value = Price;

		window.close();
	}
</script>
<body>
	<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-grey"><h3>เลือกรายการสินค้า</h3></div>	
<form name="frmSearch" method="POST" >
	
	<div class="w3-half">
<div class="w3-container w3-third">
	รหัสสินค้า
<input type='text' name = "product_codet"  id = "product_codet" class="w3-input" placeholder="Search รหัส"   /> 

</div><div class="w3-container w3-third">

		ชื่อสินค้าภาษาอังกฤษ
<input type='text' name = "product_code"  id = "product_code" class="w3-input" placeholder="Search ชื่ออังกฤษ"  /> 

	
</div><div class="w3-container w3-third">	
		ชื่อสินค้าภาษาไทย
<input type='text' name = "product_c"  id = "product_c" class="w3-input" placeholder="Search ชื่อไทย"   /> 
<input type='hidden' name = "h_product"  id = "h_product"  class="button4" readonly>	
</div></div>
	
	<div class="w3-quarter"><input type="submit" value="Search" class="w3-button w3-teal w3-border"></div>


<?php
error_reporting(~E_NOTICE);
include('dbconnect.php');
	
	if($_POST["h_product"]!=''){
	
$strSQL = "SELECT access_code,sol_name,up_img,unit_name FROM tb_product where online_ckk='1' and type_company='AWL' and  access_code LIKE '%".$_POST["h_product"]."%'";
//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");

?>

<table width="100%" border="1" class="w3-table">
  <tr>
  	<th width="10%"> <div align="center">Code</div></th>
    <th width="20%"> <div align="center">Name</div></th>
    <th width="15%"> <div align="center">รูปภาพ</div></th>
  </tr>
<?php
while($objResult = mysqli_fetch_array($objQuery))
{
?>
  <tr>
    <td><div align="center"><a href="javascript:window.open('','_self');window.close()" OnClick="selData('<?php echo $_GET["Line"];?>' , '<?php echo $objResult["product_ID"];?>','<?php echo $objResult["access_code"];?>' ,'<?php echo $objResult["sol_name"];?>' ,'<?php echo $objResult["unit_name"];?>');">
	<?php echo $objResult["access_code"];?>
	</a></div></td>
	<td><?php echo $objResult["sol_name"];?></td>
       <td>
					<?php if($objResult['up_img'] !=''){ ?>
				<a href="https://stock.allwellcenter.com/upimg/<?php echo $objResult['up_img']; ?>" target="_blank"><img src="https://stock.allwellcenter.com/upimg/<?php echo $objResult["up_img"]; ?>" align="center"  width="50" height="50" border="0" /></a>
					<?php } ?>
				</td>
  </tr>
<?php
}
?>
</table>
<?php
	}
//mysqli_close($conn);
?>
</form>
		</div>
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
		return "data_pro_notdemoth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c","h_product");
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
		return "data_pro_notdemo.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet","h_product");
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
		return "data_pro_notdemoi.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code","h_product");
        </script>





