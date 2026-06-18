<!doctype html>
<html>
<head>
<title>SOL : ITEAMDEV</title>
<meta charset="utf-8">
<script src="js/jquery-3.4.1.min.js"></script>
</head>
<body>
<form method="post" >
	<table width="100%" border="0" id="tbExp" class="w3-table">
	<thead>
	  <tr>
		<th align="center">Code</th>
		<th align="center">Name</th>
		<th align="center">Unit</th>
		<th align="center">Count</th>
		<th align="center">Price</th>
		<th align="center">Amount</th>
		<th align="center">Remark</th>
		<th align="center">Stock</th>
		<th align="center">Total</th>
		<th align="center">Action</th>
	  </tr>
	</thead>
	<tbody>
	</tbody>
	<tfoot>
	  <tr>
		<th align="right" colspan="3" >All </th>
		<th align="right" id="sum_ttl" data-val="0" >0.00</th>
		<th align="center" id="add" title="Add New Row" class="cursor: pointer" > + </th>
	  </tr>
	  <tr id="template" style="display:none;">
		<td><pf_input type="hidden" name="product_ID[]" value="" /><pf_input type="text" name="product_code[]" value="" /></td>
		<td><pf_input type="text" name="product_name[]" value="" /></td>
		<td><pf_input type="text" name="unit_name[]" value="" /></td>
		<td><pf_input type="text" pf_class="calc" data-t="q" name="sale_count[]" data-old="0" value="0" /></td>
		<td><pf_input type="text" pf_class="calc" data-t="a" name="product_price[]" data-old="0" value="0" /></td>
		<td><pf_input type="text" name="sale_remark[]" value="" /></td>
		<td><pf_input type="text" name="packing_id[]" value="" /></td>
		<td><pf_input type="text" name="Total[]" value="" /></td>
		<td pf_class="del" align="center" title="Delete" class="cursor: pointer" >-</td>
	  </tr>
	</tfoot>
	</table>
	<input type="submit" name="save" value="Submit">
</form>
</body>
<script language="javascript" src="myjs.js"></script>
</html>