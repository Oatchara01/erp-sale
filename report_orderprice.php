<?php
include "head.php";
include "dbconnect.php";
include "dbconnect_sale.php";
 ?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายงานการอนุมัติสินค้าราคาต่ำกว่ากำหนด</h4></div>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	<div class="w3-half">	
<div class="w3-bar w3-quarter w3-third">
วันที่ :
<input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>">
</div>
<div class="w3-bar w3-quarter w3-thirdr">
ถึง :
<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value="<?php echo $_GET["end_date"];?>">
	</div>

<div class="w3-bar w3-quarter w3-third">
เขตการขาย :
 	
<select name="sale_code" id="sale_code" style="width:90%;" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_adm where ckk='1' ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
if($_GET["sale_code"] == $objResuut5["sale_code"]) {
$sel = "selected";
}else {
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>"  <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>

</div></div><div class="w3-half">	
<!--div class="w3-bar w3-quarter w3-third">
  สินค้า
  <input name="product_code" type="text" id="product_code" class="w3-input w3-light-gray" value="<?php echo $_GET["product_code"];?>">
 <input name="h_product_code" type="hidden" id="h_product_code" class="w3-input w3-light-gray" value="<?php echo $_GET["h_product_code"];?>">

</div-->	
	<div class="w3-margin-bottom w3-third">
	<input type="submit" value="Search" class="w3-button w3-pale-red">
	</div></div>
<br>
<?php

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$sale_code = $_GET["sale_code"];
//$h_product_code = isset($_GET['h_product_code']) ? $_GET['h_product_code'] : '';
	
?>



<?php 
if($start_date!='' or $end_date!='' or $sale_code){ 

$strSQL = "SELECT DISTINCT employee_name  FROM so__main  where approve_complete='Approve' and price_ckk ='1'";

if($start_date !=""){ 
    $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; 
}

if($sale_code !=""){ 
    $strSQL .= ' AND employee_name = "'.$sale_code.'"'; 
}
	


$strSQL .=" order  by employee_name ASC";	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery))
{

?>
<br>
	<div class="w3-container"><h5>เขตการขาย : <?php echo $objResult["employee_name"]; ?></h5></div>
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%" >เลขที่อ้างอิง</th>
<th width="8%" >วันที่ออกเอกสาร</th>
<th width="8%" >เลขที่เอกสาร</th> 
<th width="10%" >ชื่อลูกค้า</th>
<th width="8%" >หมายเลขคำสั่งซื้อ</th> 
<th width="15%" >รายการสินค้า</th>
<th width="8%" >จำนวน</th>
<th width="8%" >ราคาต่อหน่วย</th>
<th width="8%" >ราคารวม</th>
<th width="8%" style="font-size: 12px;"><font color ='red'>ราคาต่ำสุด</font></th>	
<th width="10%" >ผู้นุมัติ</th>	
<th width="8%" >ช่องทางการขาย</th>
</thead>

<?php

$strSQL41 = "SELECT * FROM so__main  where employee_name='".$objResult["employee_name"]."' and approve_complete='Approve' and price_ckk ='1'";

if($start_date !=""){ 
    $strSQL41 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL41 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}
 
/*if($h_product_code !=""){ 
	$strSQL41 .= ' AND product_id  = "'.$h_product_code.'"'; 
	
}*/	 

$objQuery41 = mysqli_query($conn,$strSQL41) or die ("Error Query [".$strSQL41."]");
$Num_Rows41 = mysqli_num_rows($objQuery41);
$sum=0;
$sale_count=0; 
 $i=0;
while($objResult41 = mysqli_fetch_array($objQuery41))
{

/*$strSQL1 = "SELECT * FROM hos__smp where ref_idsmp = '".$objResult41["ref_idsmp"]."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_assoc($objQuery1);		

$sql = "SELECT sale_channel,order_id FROM so__main where ref_id = '".$objResult1["ref_idsale"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);	*/


$sql12 = "SELECT salechannel_nameshort FROM tb_salechannel where salechannel_ID  = '".$objResult41["sale_channel"]."'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_assoc($qry12);	


?>

<tr>
<td><?php echo $objResult41["ref_id"];?></td>
<td><?php echo Datethai($objResult41["doc_release_date"]);?></td>
<td><?php echo $objResult41["doc_no"];?></td>
<td><div align="left"><?php echo $objResult41["customer_name"];?></div></td>

<?php if($objResult41["order_id"] ==''){ ?><td bgcolor="#FF0000"><?php }else{ ?><td><?php } ?>
<a href="register_admin_edit.php?ref_id=<?php echo $objResult41["ref_id"];?>"  target="_blank"><?php echo $objResult41["order_id"];?></a></td>

	
<td><div align="left">
<?php
$strSQL14 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult41["ref_id"]."' ";
$objQuery14 = mysqli_query($conn,$strSQL14) or die ("Error Query [".$strSQL14."]");
$Num_Rows14 = mysqli_num_rows($objQuery14);
while($objResult14 = mysqli_fetch_array($objQuery14)) { ?>
<?php	echo $objResult14["sol_name"]; ?><br>
<?php } ?>
</div></td>
	
<td><div align="right">
<?php
$strSQL15 = "SELECT sale_count,unit_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult41["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$Num_Rows15 = mysqli_num_rows($objQuery15);
$count=0;
$j=0;	
while($objResult15 = mysqli_fetch_array($objQuery15)) { ?>
<?php	echo number_format($objResult15["sale_count"],0).""; ?> <?php	echo $objResult15["unit_name"]; 
	
	$count = $count + $objResult15["sale_count"];
	
	?><br>
<?php 
	$count++;
	$j++;
													  } 
	//echo $count;
	$sale_count = $sale_count + ($count-$j);
	
	?>
</div></td>
	
<td><div align="right">
<?php
$strSQL16 = "SELECT price_per_unit FROM so__submain WHERE ref_idd = '".$objResult41["ref_id"]."' ";
$objQuery16 = mysqli_query($conn,$strSQL16) or die ("Error Query [".$strSQL16."]");
$Num_Rows16 = mysqli_num_rows($objQuery16);
while($objResult16 = mysqli_fetch_array($objQuery16)) { ?>
<?php	echo number_format($objResult16["price_per_unit"],2)."";  ?><br>
<?php } ?>
</div></td>

<td><div align="rihgt">
<?php
$strSQL4 = "SELECT sum_amount FROM so__submain  WHERE ref_idd = '".$objResult41["ref_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);

while($objResult4 = mysqli_fetch_array($objQuery4))
{
?>
<?php
	echo number_format($objResult4["sum_amount"],2).""; 
	?><br />
<?php
}
?>
</div>
</td>
	
<td><div align="right">
<?php
$strSQL71 = "SELECT percen_price,price_lazada FROM (so__submain LEFT JOIN tb_product_lzd ON so__submain.sku_code=tb_product_lzd.code_lazada) WHERE ref_idd = '".$objResult41["ref_id"]."' ";
$objQuery71 = mysqli_query($conn,$strSQL71) or die ("Error Query [".$strSQL71."]");
$Num_Rows71 = mysqli_num_rows($objQuery71);

while($objResult71 = mysqli_fetch_array($objQuery71))
{
	
?>
<?php
	if($objResult71["price_lazada"]!=''){
		
	echo number_format($objResult71["percen_price"],2).""; 
	}
	?><br />
<?php
}
?>
</div>
</td>	

<td><?php echo $objResult41["approve_name"]; ?></td>


<td><?php echo $rs12["salechannel_nameshort"];?></td>

</tr>
<?php 
$i++;
$sum++;
$sale_count++;
} 
	
	

	?>
	
	
<!--tr>
<td></td>
<td></td>
<td></td>	
<td></td>
<td></td>
<td></td>	
<td bgcolor='yellow' >ยอดรวม</td>
<td bgcolor='yellow' ><div align="right"><?php echo number_format($sale_count-$i,0).""; ?> รายการ</div></td>	
<td bgcolor='yellow' ><div align="right"><?php echo number_format($sum-$i,2).""; ?></div></td>	
<td bgcolor='yellow' ></td>


<td></td>	

</tr-->	
	

</table>
	
	
	
<br>

<?php 
}	
}
?>


<br><br>
</div></div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>

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
		return "data_product_search3.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code","h_product_code");
        </script>





