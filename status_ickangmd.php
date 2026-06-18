<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>Report : เอกสาร IC & BRSC คงค้าง</h4></div>
<div class="w3-row" style="display: flex; gap: 10px;">
    <div class="w3-third" style="flex: 1;">
วันที่ออกเอกสาร : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
    <div class="w3-third" style="flex: 1;">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>



    <div class="w3-third" style="flex: 1;">
ชื่อลูกค้า : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
	    <div class="w3-third" style="flex: 1;">


Sale : 

<select name="sale_code" id="sale_code" style="width:90%;" class="w3-input" >
<option value="">**Please Select**</option>
<?php
$strSQL5 = "SELECT * FROM tb_team_adm  ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($_GET['sale_code'] == $objResuut5['sale_code'])
{
$sel = "selected";
}
else
{
$sel = "";
}
	
?>
<option value="<?php echo $objResuut5["sale_code"];?>"<?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
</div>
    <div class="w3-third" style="flex: 1;">	
ประเภทเอกสาร <br>
<?php if($_GET["type_doc"]=='1'){?>
<input type='radio' name='type_doc' id='type_doc' value='1' checked='checked' required> เอกสาร IC
<input type='radio' name='type_doc' id='type_doc' value='2' required> เอกสาร BRSC		
<?php }else if($_GET["type_doc"]=='2'){ ?>
<input type='radio' name='type_doc' id='type_doc' value='1' required> เอกสาร IC
<input type='radio' name='type_doc' id='type_doc' value='2' checked='checked' required> เอกสาร BRSC		
	
<?php }else{ ?>
<input type='radio' name='type_doc' id='type_doc' value='1' required> เอกสาร IC
<input type='radio' name='type_doc' id='type_doc' value='2' required> เอกสาร BRSC		
	<?php } ?>
	
	
</div>		
		</div></p>
<center><input type="submit" class="w3-button w3-teal" value="Search"></center>
</p></p>
</form>


<?php
	$type_doc = isset($_GET['type_doc']) ? $_GET['type_doc'] : '';
		$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';


	
	
	if($type_doc=='1'){
?>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="10%">เลขที่เอกสาร</td > 
			<td width="10%">วันที่ออกเอกสาร</td >
			<td width="15%">ชื่อผู้ออกบิล</td >
			<td width="15%">รายการสินค้า</td >
			<td width="8%">จำนวน</td >
			<td width="8%">มูลค่า</td >
			<td width="8%">เขตการขาย</td >
			<td width="8%">สถานะ</td >
			

	</thead>
	

<?php	
	
date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');


$emid = $_SESSION['code'];
$name = $_SESSION['name'];






$strSQL = "SELECT *  FROM hos__so  where ic_ckk='1' and close_ic='0' and iv_date!='0000-00-00' and status_doc='Approve'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}
		
if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}
		

if($Keyword !=""){ 
	$strSQL .= ' AND bill_name  LIKE "%'.$Keyword.'%"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$strSQL .=" order  by iv_date DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);


?>

	
<?php
$i = 1;
$sum = 0;	
$sum_all = 0;			
while($objResult = mysqli_fetch_array($objQuery))
{
	
$ref_id = $objResult["ref_id"];	
	
$sql3 = "SELECT * FROM   tb_credit_note   where  ref_id LIKE '%$ref_id%'  and status_doc ='Approve'";
//echo $sql3;	
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
while($rs3 = mysqli_fetch_array($qry3)){

$save19="UPDATE tb_subcredit SET ref_so ='".$ref_id."' where ref_creditt='".$rs3["ref_credit"]."'";
$qsave19=mysqli_query($conn,$save19);	
	
$save71="UPDATE hos__so SET close_ic ='1' where ref_id='".$ref_id."'";
$qsave71=mysqli_query($conn,$save71);		
	
}	
	
?>
		
			<tr>
				<td  ><?php echo $objResult["ref_id"];?></td>

				<td ><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><?php echo $objResult["iv_no"];?></a></td>
				
				<td ><?php  echo DateThai($objResult["iv_date"]); 	?></td>
				
<td ><div align="left"><?php echo $objResult["bill_name"];?></div></td>
<td><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
echo $objResult1["sol_name"]; 
?><br>
<?php } ?>
</div></td>
				
<td><div align="right">
<?php
$strSQL2 = "SELECT count,unit_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
while($objResult2 = mysqli_fetch_array($objQuery2)) { 
echo $objResult2["count"]; ?> <?php echo $objResult2["unit_name"]; ?><br>
<?php } ?>
</div></td>
<?php
$sql = "SELECT SUM(amount) AS amount  FROM hos__subso where  ref_idd = '".$objResult["ref_id"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);		
$sum_all += $rs["amount"];	
?>	
<td><div align="right"><?php echo number_format($rs["amount"],2).""; ?></div></td>
<td ><div align="left"><?php echo $objResult["sale_code"];?>-<?php echo $objResult["sale"];?></div></td>
<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["status_doc"];?></td>
				<?php }else if($objResult["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030" ><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td><?php echo $objResult["status_doc"];?></td>
				<?php } ?>				
				
				</tr>
			<?php 
	$i++; 
	$sum_all++;
	$sum++;
		}

?>
	<tr bgcolor='yellow'>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><div align="right">ยอดรวม</div></td>
				<td><div align="right"><?php echo number_format($sum_all-$sum,2).""; ?></div></td>
				<td></td>
				
				
				</tr>	
	</table>
	
<?php } 
	if($type_doc=='2'){
?>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="10%">เลขที่เอกสาร</td > 
			<td width="10%">วันที่ออกเอกสาร</td >
			<td width="15%">ชื่อผู้ออกบิล</td >
			<td width="15%">รายการสินค้า</td >
			<td width="8%">จำนวน</td >
			<td width="8%">มูลค่า</td >
			<td width="8%">เขตการขาย</td >
			<td width="8%">สถานะ</td >
			

	</thead>
	

<?php	
	
date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');


$emid = $_SESSION['code'];
$name = $_SESSION['name'];


$strSQL = "SELECT *  FROM hos__consig  where close_br='0' and status_doc ='Approve'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($Keyword !=""){ 
	$strSQL .= ' AND customer  LIKE "%'.$Keyword.'%"'; 
}

if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}
		

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$strSQL .=" order  by iv_date DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);


?>

	
<?php
$i = 1;
$sum = 0;	
$sum_all = 0;			
while($objResult = mysqli_fetch_array($objQuery))
{
	
$strSQL21 = "SELECT * FROM hos__subconsig WHERE clear_ckk = '0' and ref_idd = '".$objResult["ref_id"]."'";
$objQuery21 = mysqli_query($conn,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);	

if($Num_Rows21 > 0){ }else{
$save="Update  hos__consig set  close_br = '1' where ref_id = '".$objResult["ref_id"]."'";
$qsave=mysqli_query($conn,$save);
	
}	
	
	
?>
		
			<tr>
				<td  ><?php echo $objResult["ref_id"];?></td>

				<td ><a href="register_adminbrcshos_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><?php echo $objResult["iv_no"];?></a></td>
				
				<td ><?php  echo DateThai($objResult["iv_date"]); 	?></td>
				
<td ><div align="left"><?php echo $objResult["customer"];?></div></td>
<td><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (hos__subconsig LEFT JOIN tb_product ON hos__subconsig.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' and clear_ckk='0' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
echo $objResult1["sol_name"]; 
?><br>
<?php } ?>
</div></td>
				
<td><div align="right">
<?php
$strSQL2 = "SELECT count,unit_name,product_code,id FROM (hos__subconsig LEFT JOIN tb_product ON hos__subconsig.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."'  and clear_ckk='0'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
while($objResult2 = mysqli_fetch_array($objQuery2)) { 
	
	
$sql3 = "SELECT sum(sale_count) as count3   FROM   hos__subspr   where  product_id = '".$objResult2['product_code']."' and clear_br = '1' and clear_ivno ='".$objResult["iv_no"]."' and status_spr='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$objResult2['product_code']."' and clear_br = '1' and clear_ivno ='".$objResult["iv_no"]."' and status_so='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	

$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$objResult["iv_no"]."' and product_id = '".$objResult2['product_code']."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM   hos__subsmp   where  product_id = '".$objResult2['product_code']."' and clear_br = '1' and br_no ='".$objResult["iv_no"]."' and status_smp='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);


$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];
	
$count2 = $objResult2["count"] - ($count3+$count4+$count5+$count13);

if($count2=='0'){	

$save2="UPDATE  hos__jongproduct SET clear_ckk='1'  where id = '".$objResult2["id"]."' and ref_idd ='".$objResult["ref_id"]."'";
$qsave2=mysqli_query($conn,$save2);	
	
		
}
	
echo $count2; ?> <?php echo $objResult2["unit_name"]; ?><br>
<?php } ?>
</div></td>
<?php
$sql = "SELECT SUM(amount) AS amount  FROM hos__subconsig where  ref_idd = '".$objResult["ref_id"]."' and clear_ckk='0'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);		
$sum_all += $rs["amount"];	
?>	
<td><div align="right"><?php echo number_format($rs["amount"],2).""; ?></div></td>
<td ><div align="left"><?php echo $objResult["sale_code"];?>-<?php echo $objResult["sale"];?></div></td>
<?php if($objResult["status_doc"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["status_doc"];?></td>
				<?php }else if($objResult["status_doc"]=='ยกเลิก'){	?>
						<td bgcolor="#FF3030" ><?php echo $objResult["status_doc"];?></td>
				<?php }
					else if ($objResult["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
				<?php }
					else{ ?>
					<td><?php echo $objResult["status_doc"];?></td>
				<?php } ?>				
				
				</tr>
			<?php 
	$i++; 
	$sum_all++;
	$sum++;
		}

?>
	<tr bgcolor='yellow'>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><div align="right">ยอดรวม</div></td>
				<td><div align="right"><?php echo number_format($sum_all-$sum,2).""; ?></div></td>
				<td></td>
				
				
				</tr>	
	</table>
	
<?php } ?> 
      <br>
<?php include('foot.php'); ?>
		<?php //} ?>
</div>
</body>
</html>