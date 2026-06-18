<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!--title>Sale Online</title-->
<!--link href="css/style.css" rel="stylesheet" type="text/css" /-->
<link href="css/form_style.css" rel="stylesheet" type="text/css" />
<link href="css/w3.css" rel="stylesheet" type="text/css" />

</head>
<?php include('head.php'); ?>
<body>
    <div class="w3-white" id="w3-container">

	
      <div id="box2_center">
		 
	      <p align="center"><br \><br \><br \>
        <?php if($_GET['key'] == 'breq') { ?>
            <a href=javascript:if(confirm('!!!ต้องการสร้างใบยืมบริษัทออลเวลล์ไลฟ์ใช่หรือไม่')==true){window.location='register_breng_brgq.php';}><img src="img/allwell_logo.png"width="250" height="70"></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            <a href=javascript:if(confirm('!!!ต้องการสร้างใบยืมบริษัทโนเบิลเมดใช่หรือไม่')==true){window.location='register_brengnb_brgq.php';}><img src="img/nbm_select.png" width="250" height="120"></a>&nbsp&nbsp&nbsp</br></br></br></br>
        <?php } else { ?>
            <a href=javascript:if(confirm('!!!ต้องการสร้างใบยืมบริษัทออลเวลล์ไลฟ์ใช่หรือไม่')==true){window.location='register_breng.php';}><img src="img/allwell_logo.png"width="250" height="70"></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            <a href=javascript:if(confirm('!!!ต้องการสร้างใบยืมบริษัทโนเบิลเมดใช่หรือไม่')==true){window.location='register_brengnb.php';}><img src="img/nbm_select.png" width="250" height="120"></a>&nbsp&nbsp&nbsp</br></br></br></br>
        <?php } ?>

		 		  
		  </p>
</div>
      <div class="cleaner"></div>
    </div>
    <!-- end of main -->
</div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
</body>
</html>
