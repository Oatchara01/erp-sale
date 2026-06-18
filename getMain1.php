<html>
<head>
<title>ThaiCreate.Com</title>
<meta name="viewport" http-equiv="Content-Type" content="width=device-width, initial-scale=1, text/html; charset=utf-8">
</head>
<?php
extract($_POST);
//do addition and store the result in $res
if(isset($add))
{
$res=$fnum*$snum;
}	
 
?>
<script language="javascript">


	$("input[name=\"product_price"+intLine+"\"]").keyup(function() {
	var a = $("input[name=\"sale_count"+intLine+"\"]").val();
	var b = $(this).val();
	$("input[name=\"amount"+intLine+"\"]").val(a * b);
	});

	function OpenPopup(intLine)
	{
		window.open('getData.php?Line='+intLine,'myPopup','width=650,height=200,toolbar=0, menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
	}

	function CreateNewRow()
	{
		var intLine = parseInt(document.frmMain.hdnMaxLine.value);
		intLine++;
			
		var theTable = document.getElementById("tbExp");
		var newRow = theTable.insertRow(theTable.rows.length)
		newRow.id = newRow.uniqueID

		var newCell
		
		//*** Column No ***//
		newCell = newRow.insertCell(0);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center>"+intLine+"</center>";


		//*** Column Name ***//
		newCell = newRow.insertCell(1);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"HIDDEN\" NAME=\"product_ID"+intLine+"\"  ID=\"product_ID"+intLine+"\" VALUE=\"\"><INPUT TYPE=\"TEXT\" SIZE=\"15\" STYLE=\"width:100%\" NAME=\"product_code"+intLine+"\" ID=\"product_code"+intLine+"\" VALUE=\"\" CLASS=\"w3-input\"></center>";

		//*** Column Email ***//
		newCell = newRow.insertCell(2);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" SIZE=\"25\" STYLE=\"width:100%\" NAME=\"product_name"+intLine+"\" ID=\"product_name"+intLine+"\"  VALUE=\"\" CLASS=\"w3-input\"></center>";
		
		//*** Column Country Code ***//
		newCell = newRow.insertCell(3);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" SIZE=\"5\" STYLE=\"width:100%\" NAME=\"unit_name"+intLine+"\" ID=\"unit_name"+intLine+"\"  VALUE=\"\" CLASS=\"w3-input\"></center>";
		
		//*** Column Budget ***//
		newCell = newRow.insertCell(4);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><input TYPE=\"TEXT\" SIZE=\"5\" STYLE=\"width:100%\" name=\"sale_count"+intLine+"\" ID=\"sale_count"+intLine+"\" VALUE=\"\" CLASS=\"w3-input\"></center>";
	
			//*** Column Used ***//
		newCell = newRow.insertCell(5);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><input TYPE=\"TEXT\" SIZE=\"10\" STYLE=\"width:100%\" name=\"product_price"+intLine+"\"  ID=\"product_price"+intLine+"\" VALUE=\"\" CLASS=\"w3-input\"></center>";	

			//*** Column Used ***//
		newCell = newRow.insertCell(6);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><input TYPE=\"TEXT\" SIZE=\"10\" STYLE=\"width:100%\" name=\"amount"+intLine+"\"  ID=\"amount"+intLine+"\" VALUE=\"\" CLASS=\"w3-input\"></center>";
		
			//*** Column Used ***//
		newCell = newRow.insertCell(7);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" SIZE=\"20\" STYLE=\"width:100%\" NAME=\"remark"+intLine+"\"  ID=\"remark"+intLine+"\" VALUE=\"\" CLASS=\"w3-input\"></center>";

			//*** Column Used ***//
		newCell = newRow.insertCell(8);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" SIZE=\"20\" STYLE=\"width:100%\" NAME=\"packing_id"+intLine+"\"  ID=\"packing_id"+intLine+"\" VALUE=\"\" CLASS=\"w3-input\"></center>";

			//*** Column 10 ***//
		newCell = newRow.insertCell(9);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		//newCell.setAttribute("OnClick", "OpenPopup('"+intLine+"')");
		newCell.innerHTML = "<center><INPUT TYPE=\"BUTTON\" NAME=\"btnPopup_"+intLine+"\"  ID=\"btnPopup_"+intLine+"\" VALUE=\"...\" OnClick=\"OpenPopup('"+intLine+"')\"></center>";	
	
		document.frmMain.hdnMaxLine.value = intLine;
	}
	
	function RemoveRow()
	{
		intLine = parseInt(document.frmMain.hdnMaxLine.value);
		if(parseInt(intLine) > 0)
		{
				theTable = document.getElementById("tbExp");				
				theTableBody = theTable.tBodies[0];
				theTableBody.deleteRow(intLine);
				intLine--;
				document.frmMain.hdnMaxLine.value = intLine;
		}	
	}	
</script>

<body OnLoad="CreateNewRow();">
<script>
</script>
<table width="100%" border="0" id="tbExp" class="w3-table">
  <tr>
    <td><div align="center">No </div></td>
    <td><div align="center">ProductCode </div></td>
    <td><div align="center">ProductName </div></td>
    <td><div align="center">Unit </div></td>
    <td><div align="center">Sale Count </div></td>
    <td><div align="center">Price </div></td>
	<td><div align="center">Amount </div></td>
	<td><div align="center">Remark </div></td>
	<td><div align="center">Stock </div></td>
  </tr>
</table>
<input type="hidden" name="hdnMaxLine" value="0">
<input name="btnAdd" type="button" id="btnAdd" value="+" onClick="CreateNewRow();">
<input name="btnDel" type="button" id="btnDel" value="-" onClick="RemoveRow();">
<input type="submit" name="btnSubmit" value="Submit">
</body>
</html>