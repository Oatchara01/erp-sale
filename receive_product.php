<?php include ("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>
<html>
<head>


<style type="text/css">

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 8px 10px;
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
.style15 {
	font-size: 18px; color: #000000;
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
</style>
</head>
<body>
	<form  method="post" name="frmMain" enctype="multipart/form-data">
<div class="w3-white">
		
				   
  <center>
      <div class="w3-panel w3-light-gray"><h2><span class="style15">ผู้รับสินค้า</span></h2>
             <h2><span class="style15">Scan Barcode รหัสพนักงาน</span></h2></div>
   
		  
   </center>
	  

<?php
include "dbconnect.php";

date_default_timezone_set("Asia/Bangkok");
 $add_date = date('Y-m-d H:i:s');
	
 $id_br=$_GET["id_br"];	

$strSQL10 = "SELECT * FROM tb_register_br where id_br='".$_GET["id_br"]."'";
$objQuery10 = mysqli_query($conn,$strSQL10);
$objResult10 = mysqli_fetch_array($objQuery10);

$product_receive=$objResult10["product_receive"];
$strSQL1 = "SELECT * FROM tb_user where em_id='".$product_receive."'";
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);





?>
<input type='hidden' id = "id_br" class="button4" value ="<?php echo $id_br;?>" name='id_br' size='10' /> 
<input type='hidden' id = "iv_no" class="button4" value ="<?php echo $objResult10["iv_no"];;?>" name='iv_no' size='10' /> 



  <tr>
    <td align="center"><label for="textfield"></label>
      <table width="100%" border="0" id="tablee">
        <tr>
          <td width="30%" align="center"><font size="+3"><div style="color:#000000">ผู้รับสินค้า :</div></font></td>
          <td width="51%" align="letf"><input type="text" name="id_em" id="id_em" style="font-size:48px; width:500px;" value="<?=$objResult10["product_receive"];?>" align="letf" />
        </tr>
<center>
  <button align="center" type="submit" name="button" id="button" value="save" onClick="this.form.action='receive_product1.php'; submit()" style="width: 52px; height: 38px"><img src="save.png" width="35" height="30" /><br />
      บันทึก      </button>


 <tr>
    <td align="center"><br />
	<div style="color:#000000">
      <table width="60%" border="2" cellpadding="1" cellspacing="0" align="center" style="color:#FF0033">
      <tr>
        <td style="color:#000000" width="51%" align="left">ชื่อ - นามสกุล:
          <?=$objResult1["name"]?>
          <?=$objResult1["surname"]?>
    <input name="receive_product1" id="receive_product1" value="<?=$objResult1["name"]?>" type="hidden" /></td>        
        </tr>
      <tr>
        <td style="color:#000000" align="left">รหัสพนักงาน:
          <?=$objResult1["em_id"]?></td>
        
        </tr>
      <tr>
        <td style="color:#000000" align="left">ตำแหน่ง:
          <?=$objResult1["position"]?></td>
        
        </tr>
	   <tr>
        <td style="color:#000000" align="left">เวลาจ่าย:
		<?=$objResult10["date_proreceive"]?></td>
      </tr>
    </table></div></td>
  </tr>

</center>
   </form>

     
     


  </body>
</html>
