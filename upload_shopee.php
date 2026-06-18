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
<div class="w3-white">
		<div class="w3-container w3-padding-large">
		<div class="w3-panel w3-light-grey">
					<div class="w3-half"><h3>Upload Shopee</h3></div>
<div class="w3-half">
<a href="update_trackshopee.php" class="w3-button w3-blue w3-right" ><font color="black">Update Tracking</font></a>
<a href="status_getshp.php" class="w3-button w3-pink w3-right" target="_blank"><font color="black">กดรับออเดอร์</font></a>
<a href="getOrdershopee_manual.php" class="w3-button w3-yellow w3-right" target="_blank"><font color="blue">ดึง API Shopee (กดรับเอง)</font></a>
<a href="getOrdershopeebai3.php" class="w3-button w3-orange w3-right" target="_blank"><font color="black">ดึง API Shopee (ส่งพรุ่งนี้)</font></a>	<a href="getOrdershopee_twostatus.php" class="w3-button w3-green w3-right" target="_blank"><font color="black">ดึง API Shopee (Pickup)</font></a>		
			
			
			</div>
			
			
			</div>		
<br><br>
<center> 
    <h2><span class="style15">Upload รายการจากShopee </span></h2>
  
</br>




<br>
<br>

   <table width=70% cellpadding="4" cellspacing="0" style="border:double 5px #330033	;"><tr><td style="border:double 5px #330033	;" background =http://www.yenta4.com/webboard/upload_images/81631_688240.gif>
  <form enctype="multipart/form-data" action="upload_shopee.php" method="POST">
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

<?php 
$strSQL = "Update  so__main set ckk_item='1' Where sale_channel= '12' and ckk_item='0'";
$objQuery = mysqli_query($conn,$strSQL);	 

	
	if(!empty($_FILES['uploaded_file']))

  {

    $path = "upload/";

    $path = $path . basename( $_FILES['uploaded_file']['name']);

    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {

     echo '	 	 <center>

           <form action = "import_shopee.php" method ="post">

                 Files '. basename( $_FILES["uploaded_file"]["name"]).' has been uploaded 

                 <br>

                 <br>

                 <input type="hidden" name="linkurl" value="'.$path.'">

                 <input type="submit" class="button button3" value="import Data to Database">

           </form>

          </center> ';

    } else{

        echo "There was an error uploading the file, please try again!";

    }

  }

?>
 </br>

</div>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	
</body>
</html>