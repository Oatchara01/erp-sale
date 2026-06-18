<?php
/*echo "<script>
    alert('กรุณา Login ผ่าน Allwellcenter นะคะ !!!');
    window.location.href = 'https://allwellcenter.com/index.php';
</script>";
exit(); // ควรใช้ exit() เพื่อหยุดการทำงานหลัง redirect*/
?>


<html>
	<title>SOL :: ITEAMDEV</title>
<head>
<?php // require_once('head_first.php'); ?>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

<style>
  body {
  font-family: 'Pacifico', cursive;
	margin: 0;
	padding: 10;
	color: #000000;
	font-size: 14px;
	line-height: 1.5em;
	background-color: #5c1b70;
	background-image: url(css/bg-lines.jpg);
	background-repeat: no-repeat;
	background-size: 100% auto;
	/*background-position: top;*/
	background-position: right top;
	background-attachment: fixed;
}
.login_sale_box1{
  width: 70%;
  margin: 4% 15% 2% 15%;
  background-color: #ffffff;
  padding: 5%;
  border-radius: 25px;
}
.login_sale_box2_1{
  width: 50%;
  float: left;
  height: 400px;
  text-align: center;
}
.login_sale_box2_1 h1{
  width: 80%;
  text-align: center;
  margin: 40px 0px;
}

 .login_sale_box2{
  width: 50%;
  box-shadow: 0px 0px 10px #c9c9c9;
  padding: 5%;
  border-radius: 25px;
  margin-left: 50%;
}
.login_sale_box4{
  width: 100%;
  font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}
.button_login_sale{
  width: 100%;
  border-radius: 25px;
  background-color: #9696cb;
  border: 0px solid white;
  padding: 10px;
  font-size: 20px;
  color: #ffb7db;
}
.button_login_sale:hover{
  width: 100%;
  border-radius: 25px;
  background-color: #ffb7db;
  border: 0px solid white;
  box-shadow: 0px 0px 10px #9696cb;
  color: #9696cb;
}

</style>
<body>
<form name="form1" method="post" action="check_login.php" >
<div class="login_sale_box1">
  <div class="w3-container w3-center">
  <div class="login_sale_box2_1">
  <br>
    <br>
<svg style="color: #8080c0; margin-left: -80px;" xmlns="http://www.w3.org/2000/svg" width="140" height="165" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
  <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
</svg>
<h1 style="font-family: 'Pacifico', cursive;"><font style="color: #ff80c0;">SOL :: ITEAMDEV</font></h1>
    <br>
    
  </div>
  <div class="login_sale_box2">
    <h1 style="color:#8080c0;">ERP Sale<font style="color: #ff80c0;">.</font></h1>
  
  <div class="login_sale_box3">
    <h5 style="color: #ff80c0;">Login</h5>
  </div>
    
    
  <div class="login_sale_box4">

  <div class="form-floating mb-3">
  <input type="text" class="form-control" id="txtUsername" name="txtUsername" placeholder="Username">
  <label for="txtUsername">Username</label>
</div>
<div class="form-floating">
  <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Password">
  <label for="txtPassword">Password</label>
</div>

  </div>
<br>
    
  <a href="forget_pass.php"><font color=red >ลืมรหัสผ่าน ?</font></a></p>
    <input type="submit" name="Submit" value="Login" class="button_login_sale">
  </div>
  </form>
</div>
</div>
<font style="color: #ffffff;">
  <?php require_once('foot.php'); ?>
</font>

</body>
</html>