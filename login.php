<html>
<head>
<?php include('head.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sale Online</title>
<link href="css/w3.css" rel="stylesheet" type="text/css" />
<!--link href="css/form_style.css" rel="stylesheet" type="text/css" /-->
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
</script>
<script type="text/javascript" src="js/jquery.min.js"></script>

<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
<script src="js/lightbox.js" type="text/javascript"></script>

<script type="text/javascript">
function chk_form(){
    var j_keep_login=document.login.keep_login;
    var i_username=document.login.user_id_login.value;
    var i_password=document.login.pass_login.value;
    if(j_keep_login.checked==true){
        var days=30; // กำหนดจำนวนวันที่ต้องการให้จำค่า
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
        document.cookie = "CK_username=" +i_username+ "; expires=" + expires + "; path=/";
        document.cookie = "CK_password=" +i_password+ "; expires=" + expires + "; path=/";
    }else{
        var expires="";
        document.cookie = "CK_username="+expires+";-1;path=/";
        document.cookie = "CK_password="+expires+";-1;path=/";      
    }
}
</script>
<!--style type="text/css">

.button {
    background-color: #FE2E9A;
    border: none;
    color: white;
    padding: 4px 6px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}

</style>
<style type="text/css">
<!--
.style1 {
	font-size: 12px;
	color: #0000FF;
	font-style: italic;
}
.style35 {font-size: 14px; color: #000000; }
.style36 {font-size: 20px; color: #000000; }

</style>
-->

</head>
<body>
<div id="wrapper">
  <div id="header">
    <!-- end of header -->
  </div>
 <div id="main_wrapper">

      <div class="w3-center">
        <h6><strong><br />
            <br />
                     <label class="style35">Login</label></strong></h6>
 
        <div id="login_form" class="w3-center"><form method="post" name="login" action="check_login.php">
         <label for="user_id" class="style35">username:
            <input type="text" id="user_id_login" name="user_id_login" value="<?php $_COOKIE['CK_username'] ?>" />
            </label>
            <div class="cleaner h10"></div>
            <label for="pass_login"class="style35">password:</label>
            <input type="password" id="pass_login" name="pass_login" value="<?php $_COOKIE['CK_password']?>"  />
            <div class="cleaner h10"></div>
			<input name="keep_login" type="checkbox" id="keep_login" value="1" <?php (isset($_COOKIE['CK_username']) && $_COOKIE['CK_username']!="")?"checked":""?>/> 
			<span class="style35">จำข้อมูลการล็อกอินไว้</span>
  <br />

            <input type="submit" value="Login" id="go" name="go" class="button button4" />
             

          </form>
        </div>
      </div>
      <div class="w3-center"> <img src="img/LOGO1.png" width="350" height="250" /></div>
      <div class="cleaner"></div>
	    <br />
		  <br />
		   
   
</div>
<!-- end of wrapper -->
<div class="w3-center">
  <div id="cr_bar"> Copyright © 2019 phar trillion co., ltd. </div>
</div>
</body>
</html>
