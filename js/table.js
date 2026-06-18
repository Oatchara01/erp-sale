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
		newCell.innerHTML = "<center><INPUT TYPE=\"HIDDEN\" NAME=\"product_ID"+intLine+"\"  ID=\"product_ID"+intLine+"\" VALUE=\"\"></center><INPUT TYPE=\"TEXT\" NAME=\"product_code"+intLine+"\"  ID=\"product_code"+intLine+"\" VALUE=\"\"></center>";

		//*** Column Email ***//
		newCell = newRow.insertCell(2);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" NAME=\"product_name"+intLine+"\" ID=\"product_name"+intLine+"\"  VALUE=\"\"></center>";
		
		//*** Column Country Code ***//
		newCell = newRow.insertCell(3);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" NAME=\"unit_name"+intLine+"\" ID=\"unit_name"+intLine+"\"  VALUE=\"\"></center>";
		
		//*** Column Budget ***//
		newCell = newRow.insertCell(4);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" NAME=\"sale_count"+intLine+"\"  ID=\"sale_count"+intLine+"\" VALUE=\"\"></center>";
	
			//*** Column Used ***//
		newCell = newRow.insertCell(5);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" NAME=\"product_price"+intLine+"\"  ID=\"product_price"+intLine+"\" VALUE=\"\"></center>";	

			//*** Column Used ***//
		newCell = newRow.insertCell(6);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" NAME=\"amount"+intLine+"\"  ID=\"amount"+intLine+"\" VALUE=\"\"></center>";
		
			//*** Column Used ***//
		newCell = newRow.insertCell(7);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" NAME=\"remark"+intLine+"\"  ID=\"remark"+intLine+"\" VALUE=\"\"></center>";

			//*** Column Used ***//
		newCell = newRow.insertCell(8);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<center><INPUT TYPE=\"TEXT\" NAME=\"packing_id"+intLine+"\"  ID=\"packing_id"+intLine+"\" VALUE=\"\"></center>";

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