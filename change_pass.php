<?php
	//session_start();
	include('head.php');
	if($_SESSION['UserID'] == "")
	{
		echo "Please Login!";
		exit();
	}
	$strSQL = "SELECT * FROM tb_user WHERE user_id = '".$_SESSION['UserID']."' ";
	$objQuery = mysqli_query($conn,$strSQL);
	$objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<form name="form1" method="post" action="change_pass2.php">
<div class="w3-white"><br><br>
<!--div class="topnav"-->
  <h2><center>Edit Profile!</center></h2>
  <table width="100%" border="0" class="w3-table" style="width: 400px" id="inner">
    <tbody>
      <tr>
        <td width="125"> &nbsp;UserID</td>
        <td width="180">
          <?php echo $objResult["em_id"];?>
			<input name="em_id" type="hidden" id="em_id" value="<?php echo $objResult["em_id"];?>">
        </td>
      </tr>
      <tr>
        <td> &nbsp;Username</td>
        <td>
          <?php echo $objResult["user_id"];?>
        </td>
      </tr>
      <tr>
        <td> &nbsp;Password</td>
        <td><input name="txtPassword" type="password" id="txtPassword" value="<?php echo $objResult["pass"];?>">
        </td>
      </tr>
      <tr>
        <td> &nbsp;Confirm Password</td>
        <td><input name="txtConPassword" type="password" id="txtConPassword" value="<?php echo $objResult["pass"];?>">
        </td>
      </tr>
      <tr>
        <td>&nbsp;Name</td>
        <td><input name="txtName" type="text" id="txtName" value="<?php echo $objResult["name"];?>"></td>
      </tr>
	  <tr>
        <td>&nbsp;Surame</td>
        <td><input name="txtSurname" type="text" id="txtSurname" value="<?php echo $objResult["surname"];?>"></td>
      </tr>
    </tbody>
  </table>
  <br>
  <div class="w3-center"><input type="submit" name="Submit" class="w3-button w3-teal" value="Save"></div> <br>
<br></div>
</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
</body>
</html>
<?php
	mysqli_close($conn);
?>