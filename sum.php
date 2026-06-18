<html>
<head>
<title>ThaiCreate.Com Tutorial</title>
<>
</head>
<body>
<form name="frmMain" action="" method="post">
<script language="JavaScript">
	function fncSum()
	{
		 if(isNaN(document.frmMain.txtNumberA.value) || document.frmMain.txtNumberA.value == "")
		 {
			
			document.frmMain.txtNumberA.focus();
			return;
		 }

		 if(isNaN(document.frmMain.txtNumberB.value) || document.frmMain.txtNumberB.value == "")
		 {
			
			document.frmMain.txtNumberB.focus();
			return;
		 }

		 document.frmMain.txtNumberC.value = parseFloat(document.frmMain.txtNumberA.value) * parseFloat(document.frmMain.txtNumberB.value);
	}
</script>
Number A <input type="text" name="txtNumberA" value="" OnChange="fncSum();"> <br>
Number B <input type="text" name="txtNumberB" value="" OnChange="fncSum();"> <br>
A + B  = <input type="text" name="txtNumberC" value=""><br>
<?php date_default_timezone_set("Asia/Bangkok");
echo date("H:i:s"); ?>
</form>
</body>
</html>