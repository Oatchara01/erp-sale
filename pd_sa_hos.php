<HTML>
<HEAD>
	<TITLE> Add/Remove dynamic rows in HTML table </TITLE>
	<SCRIPT language="javascript">
		function addRow(tableID) {

			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var colCount = table.rows[0].cells.length;

			for(var i=0; i<colCount; i++) {

				var newcell	= row.insertCell(i);

				newcell.innerHTML = table.rows[0].cells[i].innerHTML;
				//alert(newcell.childNodes);
				switch(newcell.childNodes[0].type) {
					case "text":
							newcell.childNodes[0].value = "";
							break;
					case "checkbox":
							newcell.childNodes[0].checked = false;
							break;
					case "select-one":
							newcell.childNodes[0].selectedIndex = 0;
							break;
				}
			}
		}

		function deleteRow(tableID) {
			try {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;

			for(var i=0; i<rowCount; i++) {
				var row = table.rows[i];
				var chkbox = row.cells[0].childNodes[0];
				if(null != chkbox && true == chkbox.checked) {
					if(rowCount <= 1) {
						alert("Cannot delete all the rows.");
						break;
					}
					table.deleteRow(i);
					rowCount--;
					i--;
				}


			}
			}catch(e) {
				alert(e);
			}
		}

	</SCRIPT>
	<script>
		function OpenPopup(rows)
			{ window.open('getData.php?&Line='+rows,'myPopup','width=650,height=200,toolbar=0, menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0'); }
	</script>
</HEAD>
<BODY>

	<INPUT type="button" value="Add Row" onclick="addRow('dataTable')" />

	<INPUT type="button" value="Delete Row" onclick="deleteRow('dataTable')" />

	<TABLE id="dataTable" width="100%" border="1">
		<?php
			$i=1;
			while($i<=10) { ?>
		<TR>
			<td><input type='checkbox' name='record' id='record' class='w3-input'></td>
			<td><input type='text' name='access_code<?php echo $i; ?>' id='access_code<?php echo $i; ?>' class='w3-input' onclick='OpenPopup(<?php echo $i; ?>)'></td>
			<td><input type='hidden' name='product_id<?php echo $i; ?>' id='product_id<?php echo $i; ?>'><input type='text' name='access_name' id='access_name' class='w3-input'></td>
			<td><input type='text' name='count<?php echo $i; ?>' id='count<?php echo $i; ?>' class='w3-input w3-center' required></td>
			<td><input type='text' name='unit_name<?php echo $i; ?>' id='unit_name<?php echo $i; ?>' class='w3-input w3-center'></td>
			<td><input style='text-align:right' type='text' name='sol_price<?php echo $i; ?>' id='sol_price<?php echo $i; ?>' class='w3-input w3-center'></td>
			<td><input type='text' name='discount<?php echo $i; ?>' id='discount<?php echo $i; ?>' class='w3-input w3-center'></td>
			<td><input type='text' name='amount<?php echo $i; ?>' id='amount<?php echo $i; ?>' class='w3-input w3-center' style='text-align:right' value='' jAutoCalc= '{count<?php echo $i; ?>} * {sol_price<?php echo $i; ?>} - {discount<?php echo $i; ?>} * {count<?php echo $i; ?>}' readonly></td>
			<td><input type='text' name='warranty<?php echo $i; ?>' id='warranty<?php echo $i; ?>' class='w3-input w3-center'></td>
			<td><input type='text' name='cal<?php echo $i; ?>' id='cal<?php echo $i; ?>' class='w3-input w3-center'></td>
			<td><input type='text' name='pm<?php echo $i; ?>' id='pm<?php echo $i; ?>' class='w3-input w3-center'></td>
			<td><input type='text' name='sale_remark<?php echo $i; ?>' id='sale_remark<?php echo $i; ?>' class='w3-input'></td>
		</TR>
		<?php $i++; } ?>
	</TABLE>

</BODY>
</HTML>