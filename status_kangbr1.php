
<?php include('head.php'); 

include "dbconnect.php";

?>
<body>

	
	<form name="frmSearch1" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-container w3-padding-large">

<div class="w3-bar w3-quarter">
ค้นหาเลข SN : <input name="Keyword1" class="w3-input" style="width:90%;" type="text" id="Keyword1" value="<?php echo $Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';?>"></div>

<div class="w3-bar w3-quarter">
ค้นหาเลขที่บาร์โค้ด : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
	
<div class="w3-bar w3-quarter">
ค้นหาชื่อสินค้า
<input type='text' name = "product_codet"  id = "product_codet" style="width:90%;" class="w3-input" value="<?php echo $product_codet = isset($_GET['product_codet']) ? $_GET['product_codet'] : '';?>" placeholder="Search ชื่อสินค้าไทย" /> 
<input type='hidden' name = "h_product_codet"  id = "h_product_codet"  value="<?php echo $h_product_codet = isset($_GET['h_product_codet']) ? $_GET['h_product_codet'] : '';?>" class="w3-input" readonly>	

</div>
</div>


</p>
<center><input type="submit" class="w3-button w3-teal" value="Search"></center>
</p></p>
</form>

<?php
$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';
$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
$h_product_codet = isset($_GET['h_product_codet']) ? $_GET['h_product_codet'] : '';

 if($Keyword1 !='' or $Keyword !='' or $h_product_codet !=''){
$strSQL = "SELECT ref_idd,product_id,sn_number  FROM  so__submain   where  sale_area ='SOL5' and clear_ckk='0'";

if($Keyword1 !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND sn_number  LIKE "%'.$Keyword1.'%"'; 
		}

if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND code_same  LIKE "%'.$Keyword.'%"'; 
		}

if($h_product_codet !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND product_id  = "'.$h_product_codet.'"'; 
		}



$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
?>

<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%">เลขที่อ้างอิง</th>
<th width="10%">วันที่ลงทะเบียน</th>
<th width="10%">เลขที่เอกสาร</th> 
<th width="10%">วันที่ออกเอกสาร</th>
<th width="23%">รายการสินค้า</th>
<th width="10%">SN number</th>
<th width="22%">ชื่อลูกค้า</th>
<th width="20%">ช่องทางการขาย</th>
<th width="5%">สถานะการอนุมัติ</th>
<th width="5%">แก้ไข</th>
</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
$strSQL9 = "SELECT ref_id,register_date,doc_no,doc_release_date,delivery_contact,approve_complete,sale_channel,cancel_ckk  FROM  so__main   where  ref_id =   '".$objResult["ref_idd"]."' ";

$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);	
	
while($objResult9 = mysqli_fetch_array($objQuery9))
{	
?>
<tbody>
<tr align="">
<td><?php echo $objResult9["ref_id"];?></td>
<td><?php echo DateThai($objResult9["register_date"]);?></td>
<td><?php echo $objResult9["doc_no"];?></td>
<td>
<?php if ($objResult9["doc_release_date"]=="0000-00-00") {
	echo "-"; 
	} 
	else 
	{ echo DateThai($objResult9["doc_release_date"]);
	}
	?> 
</td>
<td><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM  tb_product  WHERE product_ID = '".$objResult["product_id"]."' ";
///echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
	echo $objResult1["sol_name"]; 
	?><br />
<?php
}
?>
</div>
</td>
	<td><div align="left"><?php echo $objResult["sn_number"];?></br></div></td>
<td><div align="left"><?php echo $objResult9["delivery_contact"];?></div></td>


<td><div align="left">
	

<?php
$strSQL2 = "SELECT salechannel_nameshort FROM  tb_salechannel where salechannel_ID = '".$objResult9["sale_channel"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

while($objResult2 = mysqli_fetch_array($objQuery2))
{
?>


<?php echo $objResult2["salechannel_nameshort"];?>
<?php
}
?>

</div></td>


<?php
if($objResult9["cancel_ckk"]=='1'){	?>
<td bgcolor="#FF3030"><?php echo "ยกเลิก";?></td>
<?php }else
if($objResult9["approve_complete"]=='Rejected'){	?>
<td bgcolor="#FF3030"><?php echo $objResult9["approve_complete"];?></td>
<?php }
else if ($objResult9["approve_complete"]=='Approve'){ ?>
<td bgcolor="#00FF00"><?php echo $objResult9["approve_complete"];?></td>
<?php }else{ ?>
<td ><?php echo $objResult9["approve_complete"];?></td>
<?php } ?>



<td><a href="register_stock_edit.php?ref_id=<?php echo $objResult9["ref_id"];?>&start_date=<?php echo $start_date;  ?>&end_date=<?php echo $end_date;?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>
</tr>
<?php
$i++;
}
}
?>
</tbody>
</table>


	
<?php 
 }

	 
	 include('foot.php'); ?>
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
		return "data_pro_searchth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet","h_product_codet");
        </script>


