<!DOCTYPE html>
<html>
<head>
<title>SOL : ITEAMDEV</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="js/jquery-3.4.1.js"></script>
<script type="text/javascript" src="dist/jautocalc.js"></script>
<!-- -->
<script>
function multiplyBy(rows)
{
        num1 = document.getElementById("firstNumber"+rows).value;
        num2 = document.getElementById("secondNumber"+rows).value;
        document.getElementById("amount"+rows).innerHTML = num1 * num2;
}
</script>
<!-- -->
<script type="text/javascript">

function OpenPopup(rows)
	{
		window.open('getData.php?Line='+rows,'myPopup','width=650,height=200,toolbar=0, menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
	}


$(document).ready(function table(){

	var rows = 1;
	$("#createRows").click(function(){
				var tr = "<tr class='txtMult' id='txtMult'>";
					tr = tr + "<td><span><center>"+rows+"</center></span></td>";
					tr = tr + "<td><input type='hidden' name='product_ID"+rows+"' id='product_ID"+rows+"'><input type='text' name='product_code"+rows+"' id='product_code"+rows+"' size='15' style='width:100%'></td>";
					tr = tr + "<td><input type='text' name='product_name"+rows+"' id='product_name"+rows+"' size='25' style='width:100%'></td>";
					tr = tr + "<td><input type='text' name='unit_name"+rows+"' id='unit_name"+rows+"' size='5' style='width:100%'></td>";
					tr = tr + "<td><input type='text' name='sale_count"+rows+"' id='sale_count"+rows+"' size='5' style='width:100%'></td>";
					tr = tr + "<td><input type='text' name='product_price"+rows+"' id='product_price"+rows+"' size='10' style='width:100%'></td>";
					tr = tr + "<td><input type='text' name='amount"+rows+" id='amount"+rows+" value=''"jAutoCalc"={sale_count"+rows+"} * {product_price"+rows+"}''</td>";
					tr = tr + "<td><input type='text' name='remark"+rows+"' id='remark"+rows+"' size='20' style='width:100%'></td>";
					tr = tr + "<td><input type='text' name='packing_id"+rows+"' id='packing_id"+rows+"' size='20' style='width:100%'></td>";
					tr = tr + "<td><center><input type='button' name='btnPopup' id='btnPopup' value='...' OnClick='OpenPopup("+rows+")'></center></td>";
					tr = tr + "</tr>";
					$('#myTable > tbody:last').append(tr);
					
					$('#hdnCount').val(rows);
					rows = rows + 1;
		});

		$("#deleteRows").click(function(){
				if ($("#myTable tr").length != 1) {
					 $("#myTable tr:last").remove();
				}
		});

		$("#clearRows").click(function(){
				rows = 1;
				$('#hdnCount').val(rows);
				$('#myTable > tbody:last').empty(); // remove all
		});

	});
</script>
<meta charset=utf-8 />
</head>
<body>
 <center>
 <form action="save.php" id="frmMain" name="frmMain" method="post">
<table width="100%" border="0" id="myTable" class="w3-table">
<!-- head table -->
<thead>
  <tr>
	<td> <div align="center" style="font-weight: bold">No. </div></td>
    <td> <div align="center" style="font-weight: bold">Product Code </div></td>
    <td> <div align="center" style="font-weight: bold">Product Name </div></td>
    <td> <div align="center" style="font-weight: bold">Unit Name </div></td>
    <td> <div align="center" style="font-weight: bold">Sale Count </div></td>
    <td> <div align="center" style="font-weight: bold">Product Price </div></td>
    <td> <div align="center" style="font-weight: bold">Amount </div></td>
    <td> <div align="center" style="font-weight: bold">Sale Remark </div></td>
    <td> <div align="center" style="font-weight: bold">Stock Remark </div></td>
	<td> <div align="center" style="font-weight: bold">... </div></td>

  </tr>
</thead>
<!-- body dynamic rows -->
<tbody></tbody>
</table>
<br />
<input type="button" id="createRows" value="Add">
<input type="button" id="deleteRows" value="Del">
<input type="button" id="clearRows" value="Clear">
 <center>
 <br>
 <input type="hidden" id="hdnCount" name="hdnCount">
<input type="submit" value="Submit">
 </form>
</body>
<script src="myjs.js"></script>
</html>