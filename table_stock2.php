<script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery-3.4.1.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/w3.css">
<?php 
include('dbconnect.php');
$sql = "SELECT * FROM so__submain WHERE ref_idd = '".$_GET["ref_id"]."' ";
$query = mysqli_query($conn,$sql) or die ("Error Query [".$sql."]");
?>
<table name="stock" id="stock" class="w3-table" border="0">
  <thead>
    <th>No.</th>
	<th>รหัสสินค้า</th>
	<th>รหัสจัดสินค้า</th>
	<th>รายการสินค้า</th>
	<th>หน่วย</th>
	<th>จำนวน</th>
	<th>ราคาต่อหน่วย</th>
	<th>ส่วนลด</th>
	<th>หมายเหตุ</th>
	<th>หมายเลขเครื่อง</th>
  </thead>
  <tbody>
  <? 
  $i=1;
  while ($fetch=mysqli_fetch_array($query,MYSQLI_ASSOC)) { ?>
    <tr>
	  <td><input type="text" name="run" class="w3-input w3-center" size="1%" value="<?php echo $i; ?>"></td>
	  <td><input idx_code type="text" name="product_code[<?php echo $i?>]" class="w3-input" size="8%" value="<?php echo $fetch['product_code']?>"></td>
	  <td><input idx_same type="text" name="product_code_same[<?php echo $i?>]" class="w3-input" size="8%" value="<?php echo  $fetch['product_code_same']?>"></td>
	  <td><input type="text" name="product_name[<?php echo $i?>]" class="w3-input" size="23%" value="<?php echo $fetch['product_name']; ?>"></td>
	  <td><input type="text" name="unit_name[<?php echo $i?>]" class="w3-input w3-center" size="3%" value="<?php echo $fetch['unit_name']; ?>"></td>
	  <td><input type="text" name="sale_count[<?php echo $i?>]" class="w3-input w3-center" size="2%" value="<?php echo $fetch['sale_count']; ?>"></td>
	  <td><input type="text" name="product_price[<?php echo $i?>]" class="w3-input w3-center" size="5%" value="<?php echo $fetch['product_price']; ?>"></td>
	  <td><input type="text" name="discount[<?php echo $i?>]" class="w3-input w3-center" size="5%" value="<?php echo $fetch['discount']; ?>"></td>
	  <td><textarea name="sale_remark[<?php echo $i?>]" class="w3-input" rows="1"><?php echo $fetch['sale_remark']; ?></textarea></td>
	  <td><textarea name="sn_number[<?php echo $i?>]" class="w3-input" rows="1"><?php echo $fetch['sn_number']; ?></textarea></td>
	</tr>
	<?
	  $i++;
      }
    ?>
  </tbody>
</table>

<script>
var idx_code = 2, idx_same = 3; // แก้ไข ให้ถูกต้องตามตำแหน่ง เอาเอง  ประยุกต์ใช้กับอย่างอื่นได้อีก
$( "#stock").on('.product_code, .product_code_same','change', function() {
	var tr = $(this).parents('tr'), inp = $(tr).find('input');
	var code = inp[idx_code].value, same = inp[idx_same].value;
	if( code.length<1 || same.length < 1 ){
		// ข้อมูลยังไม่ครบไม่ตรวจสอบ
		return;
	}
    if (  code != same ) {
		alert("Not Same Value");
		return false;
    }else {
		return true;
    }
});
</script>