<html>
<head>
<link rel="stylesheet" href="css/w3.css">
<title>ThaiCreate.Com JavaScript Add/Remove Element</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?
include('dbconnect.php');
$strSQL = "SELECT * FROM tb_product";
$objQuery = mysqli_query($conn,$strSQL);
?>
<script language="javascript">
	
	function CreateSelectOption(ele)
	{
		var objSelect = document.getElementById(ele);
		var Item = new Option("", "", "");

		objSelect.options[objSelect.length] = Item;
		<?
		while($objResult = mysqli_fetch_array($objQuery))
		{
		?>
		var Item = new Option("<?php echo $objResult["product_code"];?>", "<?php echo $objResult["product_name"];?>", "<?php echo $objResult["unit_name"];?>"); 
		objSelect.options[objSelect.length] = Item;

		<?
		}
		?>
	}
	
	function resutPD(strPD)
	{
			frmMain.product_name.value = strPD.split(",")[1];
			frmMain.unit_name.value = strPD.split(",")[2];
	}

	function CreateNewRow()
	{
		var intLine = parseInt(document.frmMain.hdnMaxLine.value);
		intLine++;
			
		var theTable = document.getElementById("tbExp");
		var newRow = theTable.insertRow(theTable.rows.length)
		newRow.id = newRow.uniqueID

		var newCell
		
				
		//*** Column 1 ***//
		newCell = newRow.insertCell(0);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "w3-select");
		newCell.innerHTML = "<center><SELECT NAME=\"product_code"+intLine+"\" ID=\"product_code"+intLine+"\" ONCHANGE=\"resutPD(this.Option);"+intLine+"\" CLASS=\"w3-select"+intLine+"\"></SELECT></center>";

		//*** Column 2 ***//
		newCell = newRow.insertCell(1);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "w3-input");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" NAME=\"product_name"+intLine+"\" ID=\"product_name"+intLine+"\"  VALUE=\"\"></center>";
		
		//*** Column 3 ***//
		newCell = newRow.insertCell(2);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" NAME=\"unit_name"+intLine+"\"  ID=\"unit_name"+intLine+"\" VALUE=\"\"></center>";
		
		//*** Column 4 ***//
		newCell = newRow.insertCell(3);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" NAME=\"Column4"+intLine+"\"  ID=\"Column4"+intLine+"\" VALUE=\"\"></center>";

		//*** Column 1 ***//
		newCell = newRow.insertCell(4);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" NAME=\"Column5"+intLine+"\"  ID=\"Column5"+intLine+"\" VALUE=\"\"></center>";
		
		
		//*** Create Option ***//
		CreateSelectOption("product_code"+intLine)
		
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
<body>
<?php $i=0; ?>
<form name="frmMain" method="post">
<table width="50%" border="1" id="tbExp">
  <tr>
    <td><div align="center">Column 1 </div></td>
    <td><div align="center">Column 2 </div></td>
    <td><div align="center">Column 3 </div></td>
    <td><div align="center">Column 4 </div></td>
    <td><div align="center">Column 5 </div></td>
  </tr>
</table>
<input type="hidden" name="hdnMaxLine" value="0">
<input name="btnAdd" type="button" id="btnAdd" value="+" onClick="CreateNewRow();">
<input name="btnDel" type="button" id="btnDel" value="-" onClick="RemoveRow();">
</form>
</body>
</html>