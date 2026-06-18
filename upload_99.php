<?php include('head.php'); ?>


<style type="text/css">
<!--
.style15 {
	font-size: 17px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #FF0000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 15px 32px;
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

<body>
<br><br>
<div class="w3-white" >
		<div class="w3-container w3-padding-large">
<center> 
    <h2><span class="style15">Upload รายการจากร้านค้า 99</span></h2>
  
</br>




<br>
<br>

   <table width=70% cellpadding="4" cellspacing="0" style="border:double 5px #330033	;"><tr><td style="border:double 5px #330033	;" background =http://www.yenta4.com/webboard/upload_images/81631_688240.gif>
  <form enctype="multipart/form-data" action="upload_99.php" method="POST">
  <center>
  <br>
  <br>
  <p><b>เลือก File ที่ต้องการ Upload<b></p> 

 
  <br>
  
  <font size="5"><input type="file" name="uploaded_file"> <br>
  <input type="submit"  class="button"  value="Upload">
  </center></input></input><br/>
	  </div></td></tr></table>
  	
   	</center>

  </form>



 <br>
</div></div></div>

<div id="cr_bar"> <?php include "foot.php"; ?></div>	
</body>
</html>