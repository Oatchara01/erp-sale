<link rel="stylesheet" href="css/w3.css"  type="text/css"/>
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<script src="dist/jautocalc.js"></script>
<script>
$('form').jAutoCalc({
  attribute: 'jAutoCalc',
  thousandOpts: [',', '.', ' '],
  decimalOpts: ['.', ','],
  decimalPlaces: -1,
  initFire: true,
  chainFire: true,
  keyEventsFire: false,
  readOnlyResults: true,
  showParseError: true,
  emptyAsZero: false,
  smartIntegers: false,
  onShowResult: null,
  funcs: {},
  vars: {}
});
</script>
<script>
function ClearForm(no){
document.getElementById("product_id"+no).value="";
document.getElementById("access_code"+no).value="";
document.getElementById("access_name"+no).value="";
document.getElementById("count"+no).value="";
document.getElementById("unit_name"+no).value="";
document.getElementById("sol_price"+no).value="";
document.getElementById("amount"+no).value="";
document.getElementById("sn"+no).value="";
document.getElementById("lot"+no).value="";
document.getElementById("sale_remark"+no).value="";
document.getElementById("admin_remark"+no).value="";
}
</script>
<script>
	function OpenPopup(rows)
	{
		window.open('getData.php?Line='+rows,'myPopup','width=650,height=200,toolbar=0, menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
	}
</script>
<div style="overflow-x:auto;">
<table name="frmMain" class="w3-table" border="0">
	<thead>
		<th style="width:3%;">#</th>
		<th style="width:8%;">รหัสสินค้า</th>
		<th style="width:15%;">ชื่อสินค้า</th>
		<th style="width:3%;">จำนวน</th>
		<th style="width:5%;">หน่วย</th>
		<th style="width:5%;">ราคา</th>
		<th style="width:10%;">สุทธิ</th>
		<th style="width:10%;">Serials</th>
		<th style="width:10%;">Lot/Exp.</th>
		<th style="width:11%;">หมายเหตุ</th>
		<th style="width:11%;">Admin</th>
	</thead>
	<tbody>
		<?php include('dbconnect.php');
			$ref_id = $_GET['ref_id'];
			$pd = "select hos__subbr.*,tb_product.* from hos__subbr left join tb_product on hos__subbr.product_id=tb_product.product_ID where ref_id='$ref_id'";
			$qpd = mysqli_query($conn,$pd);
			$npd = mysqli_num_rows($qpd);
			for ($i=1;$i<11-$npd;$i++){ 
			while ($fpd = mysqli_fetch_array($qpd,MYSQLI_ASSOC)) { ?>
				<tr>
					<td><input type="hidden" name="pid<?php echo $fpd["id"]; ?>" value="<?php echo $fpd["id"]; ?>"><input type="text" name="no<?php echo $fpd["no"]; ?>" class="w3-input w3-center" value="<?php echo $fpd["no"]; ?>"></td>
					<td><input type="hidden" name="product_id<?php echo $fpd["no"]; ?>" id="product_id<?php echo $fpd["no"]; ?>" class="w3-input" value="<?php echo $fpd["product_id"]; ?>"><input type="text" name="access_code<?php echo $fpd["no"]; ?>" id="access_code<?php echo $fpd["no"]; ?>" class="w3-input" value="<?php echo $fpd["access_code"]; ?>" onclick="OpenPopup(<?php echo $fpd["no"]; ?>)"></td>
					<td><input type="text" name="access_name<?php echo $fpd["no"]; ?>" id="access_name<?php echo $fpd["no"]; ?>"class="w3-input" value="<?php echo $fpd["access_name"]; ?>"></td>
					<td><input type="text" name="count<?php echo $fpd["no"]; ?>" id="count<?php echo $fpd["no"]; ?>"class="w3-input w3-center" value="<?php echo $fpd["count"]; ?>"></td>
					<td><input type="text" name="unit<?php echo $fpd["no"]; ?>" id="unit_name<?php echo $fpd["no"]; ?>" class="w3-input w3-center" value="<?php echo $fpd["unit"]; ?>"></td>
					<td><input type="text" name="sol_price<?php echo $fpd["no"]; ?>" class="w3-input w3-right" value="<?php echo $fpd["price"]; ?>">
					    <input type="hidden" name="discount<?php echo $fpd["no"]; ?>" class="w3-input w3-right" value="0"></td>
					<td><input type="text" name="amount<?php echo $fpd["no"]; ?>" id="amount<?php echo $fpd["no"]; ?>" class="w3-input w3-right" value="<?php echo $fpd["amount"]; ?>" jAutoCalc= "{count<?php echo $fpd["no"]; ?>} * {sol_price<?php echo $fpd["no"]; ?>} - {discount<?php echo $fpd["no"]; ?>} * {count<?php echo $fpd["no"]; ?>}"></td>
					<td><textarea name="sn<?php echo $fpd["no"]; ?>" id="sn<?php echo $fpd["no"]; ?>"class="w3-input" rows="1"><?php echo $fpd["sn"]; ?></textarea></td>
					<td><textarea name="lot<?php echo $fpd["no"]; ?>" id="lot<?php echo $fpd["no"]; ?>" class="w3-input" rows="1"><?php echo $fpd["lot"]; ?></textarea></td>
					<td><input type="text" name="sale_remark<?php echo $fpd["no"]; ?>" id="sale_remark<?php echo $fpd["no"]; ?>" class="w3-input" value="<?php echo $fpd["sale_remark"]; ?>"></td>
					<td><input type="text" name="admin_remark<?php echo $fpd["no"]; ?>" id="admin_remark<?php echo $fpd["no"]; ?>" class="w3-input"></td>
					<td><button type="button" name="clear<?php echo $fpd["no"]; ?>" class="w3-button w3-pale-red" onclick="javascript:ClearForm(<?php echo $fpd["no"]; ?>)"></td>
				</tr>
			<?php } ?>
				<tr>
					<td><input type="hidden" name="pid<?php echo $i+$npd; ?>" value=""><input type="text" name="no<?php echo $i+$npd; ?>" class="w3-input w3-center" value="<?php echo $i+$npd; ?>"></td>
					<td><input type="hidden" name="product_id<?php echo $i+$npd; ?>" id="product_id<?php echo $i+$npd; ?>" class="w3-input"><input type="text" name="access_code<?php echo $i+$npd; ?>" id="access_code<?php echo $i+$npd; ?>"class="w3-input" onclick="OpenPopup(<?php echo $i+$npd; ?>)"></td>
					<td><input type="text" name="access_name<?php echo $i+$npd; ?>" id="access_name<?php echo $i+$npd; ?>" class="w3-input"></td>
					<td><input type="text" name="count<?php echo $i+$npd; ?>" id="count<?php echo $i+$npd; ?>" class="w3-input w3-center"></td>
					<td><input type="text" name="unit<?php echo $i+$npd; ?>" id="unit_name<?php echo $i+$npd; ?>" class="w3-input w3-center"></td>
					<td><input type="text" name="sol_price<?php echo $i+$npd; ?>" id="sol_price<?php echo $i+$npd; ?>" class="w3-input w3-right">
					    <input type="hidden" name="discount<?php echo $i+$npd; ?>" id="discount<?php echo $i+$npd; ?>" value="0"></td>
					<td><input type="text" name="amount<?php echo $i+$npd; ?>" id="amount<?php echo $i+$npd; ?>" class="w3-input w3-right" value="" jAutoCalc= "{count<?php echo $i+$npd; ?>} * {sol_price<?php echo $i+$npd; ?>} - {discount<?php echo $i+$npd; ?>} * {count<?php echo $i+$npd; ?>}"></td>
					<td><textarea name="sn<?php echo $i+$npd; ?>" class="w3-input" rows="1"></textarea></td>
					<td><textarea name="lot<?php echo $i+$npd; ?>" class="w3-input" rows="1"></textarea></td>
					<td><input type="text" name="sale_remark<?php echo $i+$npd; ?>" class="w3-input"></td>
					<td><input type="text" name="admin_remark<?php echo $i+$npd; ?>" class="w3-input"></td>
					<td><button type="button" name="clear<?php echo $i+$npd; ?>" class="w3-button w3-pale-red" onclick="javascript:ClearForm(<?php echo $i+$npd; ?>)"></td>
				</tr>
			<?php } ?><input type="text" name="count" value="<?php echo ($i+$npd)-1; ?>">
	</tbody>
</table>
</div>
<script>
function chkNumber(ele) {
var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
ele.onKeyPress=vchar; }
</script>