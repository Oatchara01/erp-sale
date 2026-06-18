<html>
<head>
<?php require_once('head_first.php'); ?>
</head>
<body>
<form name="form1" method="post" action="forget_pass1.php">
<div class="w3-container w3-center">
  <h2>Forgot your password?</h2>
  <table border="0" id="inner" style="width:100%;" class="w3-table w3-center">
  <tr>
  <td ><div class="w3-right-align"><h4>รหัสพนักงาน</h4></div></td>
  <td><input name="em_id" type="text" id="em_id" class="w3-input" style="width:100%;"></td>
  </tr>
  <tr>
  <td><div class="w3-right-align"><h4>ช่องทางรับรหัสผ่าน</h4></div></td>
  <td><div align="left"><input name="type_send" type="radio" id="type_send"  value = '1' > E-mail  
  <input name="type_send" type="radio" id="type_send"  value = '2' > Line 
  </div></td>
  </tr>
  </table>
  <input type="submit" name="Submit" value="Send PassWord" class="w3-button w3-teal">
</div>
</form>
<?php require_once('foot.php'); ?>
</body>
</html>