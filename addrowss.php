<!doctype html>
<html>
<head>
<title>SOL :: ITEAMDEV</title>
<meta charset="utf-8">
<script src="js/jquery-3.4.1.min.js""></script>
<script>
function OpenPopup(i)
	{
		window.open('getData.php?Line='i,'myPopup','width=650,height=200,toolbar=0, menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
	}
</script>
</head>
<body>
<?php for( $i= 0 ; $i <= 999 ; $i++ ) ?>
<form method="post" >
	<table width="60%" border="0" id="tbExp" class="w3-table">
	<thead>
	  <tr>
		<th align="center">Product</th>
		<th align="center">Quantity</th>
		<th align="center">Amount</th>
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
	    <td><pf_input type="hidden" name="product_ID[]"><pf_input type="text" name="product_code[]" /></td>
		<td><pf_input type="text" name="product_name[]" value="" placeholder="product name" /></td>
		<td><pf_input type="text" name="unit_name[]" value="" placeholder="product name" /></td>
		<td><pf_input type="text" pf_class="calc" data-t="q" name="sale_count[]" data-old="0" value="0" /></td>
		<td><pf_input type="text" pf_class="calc" data-t="a" name="product_price[]" data-old="0" value="0" /></td>
		<td><pf_input type="text" name="amount[]" value="" /></td>
		<td><pf_input type="text" name="remark[]" value="" /></td>
		<td><pf_input type="text" name="packing_id[]" value="" /></td>
		<td><pf_input type='button' name='btnPopup<?php echo $i; ?>' value='...' OnClick='OpenPopup(<?php echo $i; ?>)'>
		<td pf_class="del" align="center" title="Delete" class="cursor: pointer" >-</td>
	  </tr>
	</tfoot>
	</table>
	<input type="submit" name="save" value="Submit">
</form>
</body>
<script language="javascript" src="myjs.js"></script>
</html>