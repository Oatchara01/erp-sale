<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
	<div class="w3-panel w3-light-grey"><h3>อนุมัติรายการตรวจเช็คใบยืม</h3></div>

<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>
<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="10%">วันที่ลงทะเบียน</th>
			<th width="10%">ผู้บันทึก</th>
			<th width="10%">เขตการขาย</th>
			<th width="10%">สถานะ</th>
			<th width="10%">การส่ง Stock</th>
			<th width="5%">ดูรายละเอียด</th>
			
	</thead>


<?php	
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
include "dbconnect_sale.php";
$sale_code = $_SESSION['code'];
$user_type = $_SESSION['user_type'];

if($user_type=='Engineer'){
$strSQL = "SELECT DISTINCT ref_id  FROM st__checkbr  where sale_code LIKE '%EN%' and send_sup='1' and status_doc ='Request' ";
if($start_date !=""){ 
    $strSQL .= ' AND add_date >= "'.$start_date.'"'; 
}
	
if($end_date !=""){ 
    $strSQL .= ' AND add_date <= "'.$end_date.'"'; 
}
	
if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND customer_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or ref_id  LIKE "%'.$Keyword.'%"'; 

}
//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$strSQL .=" order  by id DESC ";
$objQuery  = mysqli_query($conn,$strSQL);


?>

<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$sql1 = "SELECT add_date,add_by,sale_code,send_stock,status_doc FROM st__checkbr where ref_id ='".$objResult["ref_id"]."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

?>
		<tbody>
			<tr>
				<td><?php echo $objResult["ref_id"];?></td>
				

				<td><?php
                echo DateThai($rs1["add_date"]);
					?></td>
				<td><?php echo $rs1["add_by"];?></td>
				
				<td><?php echo $rs1["sale_code"];?></td>
				
				<?php if($rs1["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $rs1["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $rs1["status_doc"];?></td>
				<?php } ?>
				
				
				<?php if($rs1["send_stock"]=='0'){	?>
						<td bgcolor="#FF3030">ยังไม่ได้ส่ง Stock</td>
				<?php }
					else if ($rs1["send_stock"]=='1'){ ?>
				<td bgcolor="#00FF00">ส่ง Stock เรียบร้อยแล้ว</td>
				<?php } ?>
				<td>
				
				<a href="report_brkangbyareaapp.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
												
				</td>
				
			</tr>
			<?php $i++; } 

}else{

$emid = $_SESSION['code'];

$strSQL1 = "SELECT * FROM tb_user_team WHERE em_id = '".$emid."' ";
$objQuery1 = mysqli_query($com,$strSQL1) or die(mysqli_error());
		$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$zone = $objResult1["sale_code"];

$strSQL = "SELECT DISTINCT ref_id  FROM st__checkbr  where sale_code = '".$zone."'  and send_sup='1' and status_doc ='Request'";	


if($start_date !=""){ 
    $strSQL .= ' AND add_date >= "'.$start_date.'"'; 
}
	
if($end_date !=""){ 
    $strSQL .= ' AND add_date <= "'.$end_date.'"'; 
}
	
if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND customer_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or ref_id  LIKE "%'.$Keyword.'%"'; 

}
//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$strSQL .=" order  by id DESC ";
$objQuery  = mysqli_query($conn,$strSQL);


?>

<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$sql1 = "SELECT add_date,add_by,sale_code,send_stock,status_doc FROM st__checkbr where ref_id ='".$objResult["ref_id"]."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

?>
		<tbody>
			<tr>
				<td><?php echo $objResult["ref_id"];?></td>
				

				<td><?php
                echo DateThai($rs1["add_date"]);
					?></td>
				<td><?php echo $rs1["add_by"];?></td>
				
				<td><?php echo $rs1["sale_code"];?></td>
				
				<?php if($rs1["status_doc"]=='Approve'){ ?>
				<td  bgcolor="#00FF00"><?php echo $rs1["status_doc"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $rs1["status_doc"];?></td>
				<?php } ?>
				
				
				<?php if($rs1["send_stock"]=='0'){	?>
						<td bgcolor="#FF3030">ยังไม่ได้ส่ง Stock</td>
				<?php }
					else if ($rs1["send_stock"]=='1'){ ?>
				<td bgcolor="#00FF00">ส่ง Stock เรียบร้อยแล้ว</td>
				<?php } ?>
				<td>
				
				<a href="report_brkangbyareaapp.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a>
												
				</td>
				
			</tr>
			<?php $i++; }
			
}
			?>
		</tbody>


<?php } ?>


	</table>

      <br>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		


</body>
</html>