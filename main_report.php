<?php include('head.php'); ?>
<?php
	ini_set('display_errors', 1);
	error_reporting(~0);

	$register = null;

	if(isset($_POST["register_date"]))
	{
		$register = $_POST["register_date"];
	}
	if(isset($_GET["register_date"]))
	{
		$register = $_GET["register_date"];
	}

	$delivery = null;

	if(isset($_POST["deliver_date"]))
	{
		$delivery = $_POST["delivery_date"];
	}
	if(isset($_GET["delivery_date"]))
	{
		$delivery = $_GET["delivery_date"];
	}
?>
<div class="w3-container">
<div class="w3-padding-large"></div>
<div class="w3-bar w3-light-gray">
<div class="w3-half"><h4>รายงานสรุปตามวันที่</h4></div>
<form name="frmSearch" method="get" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-half">
<table>
  <tr><td>วันที่ขาย</td>
  <td><input name="register_date" type="date" id="register_date" class="w3-input w3-light-gray" value="<?php echo $register;?>"></td>
  <td>วันที่จัดส่ง</td>
  <td> <input name="delivery_date" type="date" id="delivery_date" class="w3-input w3-light-gray" value="<?php echo $delivery;?>"></td>
  <td><input type="submit" value="Search" class="w3-button w3-teal"></td>
  </tr>
  </table>
</div>
</div>
</form>
<?php
	$sql = "select so__main.*,tb_delivery.* from (so__main left join tb_delivery on so__main.delivery=tb_delivery.delivery_id) where (register_date='".$register."') and (delivery_date='".$delivery."')";
	$query = mysqli_query($conn,$sql);

	$num_rows = mysqli_num_rows($query);

	$per_page = 10;   // Per Page
	$page  = 1;
	
	if(isset($_GET["Page"]))
	{
		$page = $_GET["Page"];
	}

	$prev_page = $page-1;
	$next_page = $page+1;

	$row_start = (($per_page*$page)-$per_page);
	if($num_rows<=$per_page)
	{
		$num_pages =1;
	}
	else if(($num_rows % $per_page)==0)
	{
		$num_pages =($num_rows/$per_page) ;
	}
	else
	{
		$num_pages =($num_rows/$per_page)+1;
		$num_pages = (int)$num_pages;
	}
	$row_end = $per_page * $page;
	if($row_end > $num_rows)
	{
		$row_end = $num_rows;
	}

	$sql .= " ORDER BY main_id ASC LIMIT $row_start ,$row_end ";
	$query = mysqli_query($conn,$sql);

?>
<div class="w3-padding-small"></div>
<table class="w3-table" id="myTable" border="1">
  <tr class="w3-gray">
    <th style="width:10%;" onclick="sortTable(0)"> <div align="center">วันที่ </div></th>
    <th style="width:5%;" onclick="sortTable(1)"> <div align="center">เลขที่อ้างอิง </div></th>
    <th style="width:10%;" onclick="sortTable(2)"> <div align="center">หมายเลขคำสั่งซื้อ </div></th>
    <th style="width:15%;" onclick="sortTable(3)"> <div align="center">ชื่อลูกค้า </div></th>
    <th style="width:25%;" onclick="sortTable(4)"> <div align="center">รายการสินค้า </div></th>
    <th style="width:5%;" onclick="sortTable(5)"> <div align="center">จำนวน </div></th>
	<th style="width:5%;" onclick="sortTable(6)"> <div align="center">ราคา </div></th>
	<th style="width:5%;" onclick="sortTable(7)"> <div align="center">รวมเป็นเงิน </div></th>
	<th style="width:5%;" onclick="sortTable(8)"> <div align="center">เลขที่เอกสาร </div></th>
	<th style="width:15%;" onclick="sortTable(9)"> <div align="center">การจัดส่ง </div></th>
  </tr>
<?php
while($result=mysqli_fetch_array($query,MYSQLI_ASSOC))
{
?>
  <tr>
    <td><div align="center"><?php echo DateThai($result["register_date"]);?><br /><font color="#b3b3b3">Send : <?php echo DateThai($result["delivery_date"]);?></font></div></td>
    <td><?php echo $result["ref_id"];?></td>
    <td><?php echo $result["order_id"];?></td>
    <td><?php echo $result["customer_name"];?></td>
    <td>
		<?php
			$pd = "SELECT * FROM so__submain WHERE ref_idd = '".$result["ref_id"]."' ";
			$qpd = mysqli_query($conn,$pd) or die ("Error Query [".$strSQL1."]");
			$pdr = mysqli_num_rows($qpd);

			while($fpd = mysqli_fetch_array($qpd))
			{
			?>
							<?php echo $fpd["product_name"];?><br />
			<?php
			}
			?>
    </td>
    <td>
		<?php
			$pd = "SELECT * FROM so__submain WHERE ref_idd = '".$result["ref_id"]."' ";
			$qpd = mysqli_query($conn,$pd) or die ("Error Query [".$strSQL1."]");
			$pdr = mysqli_num_rows($qpd);

			while($fpd = mysqli_fetch_array($qpd))
			{
			?>
							<center><?php echo $fpd["sale_count"];?><br /></center>
			<?php
			}
			?>
    </td>
	<td><div align="right">
		<?php
			$pd = "SELECT * FROM so__submain WHERE ref_idd = '".$result["ref_id"]."' ";
			$qpd = mysqli_query($conn,$pd) or die ("Error Query [".$strSQL1."]");
			$pdr = mysqli_num_rows($qpd);

			while($fpd = mysqli_fetch_array($qpd))
			{
			?>
							<?php echo $fpd["price_per_unit"];?><br />
			<?php
			}
			?>
    </div></td>
    <td><div align="right">
		<?php
			$pd = "SELECT * FROM so__submain WHERE ref_idd = '".$result["ref_id"]."' ";
			$qpd = mysqli_query($conn,$pd) or die ("Error Query [".$strSQL1."]");
			$pdr = mysqli_num_rows($qpd);

			while($fpd = mysqli_fetch_array($qpd))
			{
			?>
							<?php echo $fpd["amount"];?><br />
			<?php
			}
			?>
    </div></td>
	<td align="right"><?php echo $result["doc_no"];?></td>
	<td align="right"><?php echo $result["delivery_name"];?></td>
  </tr>
<?php
}
?>
</table>
<br>
Total <?php echo $num_rows;?> Record : <?php echo $num_pages;?> Page :
<?php
if($prev_page)
{
	echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$prev_page&register_date=$register&delivery_date=$delivery'><< Back</a> ";
}

for($i=1; $i<=$num_pages; $i++){
	if($i != $page)
	{
		echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&register_date=$register&delivery_date=$delivery'>$i</a> ]";
	}
	else
	{
		echo "<b> $i </b>";
	}
}
if($page!=$num_pages)
{
	echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$next_page&register_date=$register&delivery_date=$delivery'>Next>></a> ";
}
$conn = null;
?>
<?php require_once('foot.php'); ?>
</div>
</body>
</html>