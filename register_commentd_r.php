<?php 
include "test.php";
include "head.php";

?>

<?php 
include "dbconnect.php"; 
include "dbconnect_cs.php";
date_default_timezone_set("Asia/Bangkok");

?>

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/w3.css" rel="stylesheet" type="text/css" />
<title>แบบสอบถามความพึงพอใจของลูกค้า</title>

<link href="css/form_style.css" rel="stylesheet" type="text/css" />


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
.style35 {font-size: 14px; color: #FF0000; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px; color: #000000; }
.style40 {font-size: 16px; color: #FF0000; }
-->
</style>




</head>
<body>

	    

		 	
<center>
      <h2><span class="style15" align="right">แบบสอบถามความพึงพอใจลูกค้า</span></h2> </p>
             <h2><span class="style15" align="right">(Customer's Satisfaction Questionnaire)</span></h2> </p>

 
   </center>
  
  
	<form  name="frmAdd" method="post" onSubmit="JavaScript:return fncSubmit();">

	 

<?php

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;



$strSQL = "SELECT * FROM tb_research WHERE red_id = '".$_GET["red_id"]."' ";
$objQuery = mysqli_query($com1,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
		
	

?>


<div class="w3-container w3-padding-large">

	ลูกค้าเกรด :
<?php if($objResult["grade"]=='D'){ ?>
	<input type='radio' name = "grade"  name='grade'   checked="checked" size='10' > D
	<?php } 
	 if($objResult["grade"]=='B'){
	?>
	<input type='radio' name = "grade"  name='grade'   checked="checked" size='10' > B
	<?php } ?>
	</p>
	
	  วันที่ :</p>
      <input type='date' name = "date_sale" class="button4"  name='date_sale'  value="<?php echo $objResult["date_research"]; ?>" size='10' readonly> </p>
<input type='hidden' name = "iv_date" class="button4"  name='iv_date'  value="<?php echo $objResult["iv_date"]; ?>" size='10' readonly> </p>

  ชื่อลูกค้า :</p>
	   <input name="customer_name" type='text' id="customer_name" value="<?php echo $objResult["customer_name"]; ?>" size="40%"  class="button4"/>&nbsp;&nbsp;&nbsp;</p>
      
     โทรศัพท์ :</p>
      <input name="customer_tel" type='text' id="customer_tel" value="<?php echo $objResult["customer_tel"];?>" size="40%" class="button4"  /></p>
	  
	  
	   เลขที่ IV :</p>
      <input name="iv_number" type='text' id="iv_number" value="<?php echo $objResult["iv_number"];?>" size="40%"  class="button4"/>&nbsp;&nbsp;&nbsp;</p>
     
	<input name="sale_code" type='hidden' id="sale_code" value="<?php echo $objResult["sale_code"];?>" size="40%"  class="button4"/>

 สินค้า :</p>
      <textarea name="product_name"  id="product_name" cols="40" rows="2"  class="button4"><?php echo $objResult["product_name"];?></textarea>&nbsp;&nbsp;&nbsp;</p>

ชื่อพนักงานส่ง :</p>
      <input name="team_send" type='text' id="team_send" value="<?php echo $objResult["team_send"];?>" size="40%" class="button4"  />



</p></p>
				

โปรดใส่เครื่องหมาย  <input type='radio'   value='' checked='checked'/> ลงในช่องที่ท่านเห็นด้วย
      </p>

	 (คะแนนการประเมิน มากที่สุด = 10,  น้อยที่สุด = 1 )
      </p> </p>

<u>ความพึงพอใจต่อพนักงานขาย</u></p>

	  <table border="1" class="w3-table" width="100%">
<tr>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >ลำดับ </div></td>
<td width="40%"  bgcolor="#CFCFCF"><div align="center" >รายละเอียด</div></td> 
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >10</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >9</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >8</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >7</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >6</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >5</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >4</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >3</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >2</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >1</div></td>

</tr>

<tr>
<td align="center"><div align="center">
<span class='style39'>1</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>พนักงานขายมีความรู้ความชำนาญในตัวสินค้า สามารถแนะนำ ตอบข้อซักถามได้ชัดเจน</span>
</div></td>

<td align="center"><div align="center">
	<?php if($objResult["sale_neat"]=='10'){ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat'  checked='checked' >
	<?php }else{ ?>
	<input type='radio'  name='sale_neat' id = 'sale_neat' />
	<?php } ?>
	</div></td>

<td align="center"><div align="center">
<?php if($objResult["sale_neat"]=='9'){ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat'  checked='checked' >
	<?php }else{ ?>
	<input type='radio'  name='sale_neat' id = 'sale_neat' />
	<?php } ?>
	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_neat"]=='8'){ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat'  checked='checked' >
	<?php }else{ ?>
	<input type='radio'  name='sale_neat' id = 'sale_neat' />
	<?php } ?>
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_neat"]=='7'){ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat'  checked='checked' >
	<?php }else{ ?>
	<input type='radio'  name='sale_neat' id = 'sale_neat' />
	<?php } ?>
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_neat"]=='6'){ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat'  checked='checked' >
	<?php }else{ ?>
	<input type='radio'  name='sale_neat' id = 'sale_neat' />
	<?php } ?>
	</div></td>
	
	
<td align="center"><div align="center">
<?php if($objResult["sale_neat"]=='5'){ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat'  checked='checked' >
	<?php }else{ ?>
	<input type='radio'  name='sale_neat' id = 'sale_neat' />
	<?php } ?>
	</div></td>

<td align="center"><div align="center">
<?php if($objResult["sale_neat"]=='4'){ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat'  checked='checked' >
	<?php }else{ ?>
	<input type='radio'  name='sale_neat' id = 'sale_neat' />
	<?php } ?>
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_neat"]=='3'){ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat'  checked='checked' >
	<?php }else{ ?>
	<input type='radio'  name='sale_neat' id = 'sale_neat' />
	<?php } ?>
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_neat"]=='2'){ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat'  checked='checked' >
	<?php }else{ ?>
	<input type='radio'  name='sale_neat' id = 'sale_neat' />
	<?php } ?>
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_neat"]=='1'){ ?>
<input type='radio'  name='sale_neat' id = 'sale_neat'  checked='checked' >
	<?php }else{ ?>
	<input type='radio'  name='sale_neat' id = 'sale_neat' />
	<?php } ?>
	</div></td>


</tr>

<tr>
<td align="center"><div align="center">
<span class='style39'>2</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>พนักงานขายพูดจาสุภาพ อัธยาศัยดี วางตัวเหมาะสม</span>
</div></td>

<td align="center"><div align="center">
	
<?php if($objResult["sale_data"]=='10'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	
	</div></td>

<td align="center"><div align="center">
<?php if($objResult["sale_data"]=='9'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_data"]=='8'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_data"]=='7'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_data"]=='6'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>	
	
<td align="center"><div align="center">
<?php if($objResult["sale_data"]=='5'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>

<td align="center"><div align="center">
<?php if($objResult["sale_data"]=='4'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">

	<?php if($objResult["sale_data"]=='3'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_data"]=='2'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_data"]=='1'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	
	</div></td>
	</tr>
		  <tr>
			  <td align="center"><div align="center">
<span class='style39'>3</span>
</div></td>
	<td align="left"><div align="left">
<span class='style39'>ความพึงพอใจต่อบริการที่ได้รับจาก ออลล์เวลในครั้งนี้</span>
</div></td>

<td align="center"><div align="center">

	<?php if($objResult["sale_3"]=='10'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	
	</div></td>

<td align="center"><div align="center">
<?php if($objResult["sale_3"]=='9'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_3"]=='8'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_3"]=='7'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_3"]=='6'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>			  
			  
<td align="center"><div align="center">
<?php if($objResult["sale_3"]=='5'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>

<td align="center"><div align="center">
<?php if($objResult["sale_3"]=='4'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_3"]=='3'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_3"]=='2'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["sale_3"]=='1'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>

</tr>
		  
		  
</table>
</p>

<fieldset><legend><b></b></legend></br>

ข้อเสนอแนะอื่นๆ : </p>
		 <textarea name="suggest"  class="button4" id="suggest" cols="40%" rows="3"><?php echo $objResult["suggest"]; ?></textarea><br>

</fieldset><br>

<u> ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์</u></p>

 <table border="1" class="w3-table" width="100%">
<tr>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >ลำดับ </div></td>
<td width="40%"  bgcolor="#CFCFCF"><div align="center" >รายละเอียด</div></td> 
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >10</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >9</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >8</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >7</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >6</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >5</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >4</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >3</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >2</div></td>
<td width="5%"  bgcolor="#CFCFCF"><div align="center" >1</div></td>

</tr>

<tr>
<td align="center"><div align="center">
<span class='style39'>1</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>สินค้าจริงตรงกับข้อมูลที่บริษัทให้ก่อนสั่งซื้อ และสามารถใช้งานได้อย่างมีประสิทธิภาพ</span>
</div></td>

<td align="center"><div align="center">
	<?php if($objResult["product_good"]=='10'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>

<td align="center"><div align="center">
	<?php if($objResult["product_good"]=='9'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_good"]=='8'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_good"]=='7'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_good"]=='6'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>
	
	
<td align="center"><div align="center">
	<?php if($objResult["product_good"]=='5'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>

<td align="center"><div align="center">
	<?php if($objResult["product_good"]=='4'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_good"]=='3'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_good"]=='2'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_good"]=='1'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


</tr>
<tr>
<td align="center"><div align="center">
<span class='style39'>2</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>ระดับคุณภาพสินค้าเมื่อเทียบกับบริษัทอื่นๆ</span>
</div></td>

<td align="center"><div align="center">

<?php if($objResult["product_link"]=='10'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	
	</div></td>

<td align="center"><div align="center">
<?php if($objResult["product_link"]=='9'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["product_link"]=='8'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["product_link"]=='7'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["product_link"]=='6'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>
	
	
<td align="center"><div align="center">
<?php if($objResult["product_link"]=='5'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>

<td align="center"><div align="center">
<?php if($objResult["product_link"]=='4'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["product_link"]=='3'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
<?php if($objResult["product_link"]=='2'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	
<?php if($objResult["product_link"]=='1'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


</tr>
	 
<tr>
<td align="center"><div align="center">
<span class='style39'>3</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>ความพึงพอใจในสินค้าโดยรวม</span>
</div></td>

<td align="center"><div align="center">
	<?php if($objResult["product_corect"]=='10'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	
	</div></td>

<td align="center"><div align="center">
	<?php if($objResult["product_corect"]=='9'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_corect"]=='8'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_corect"]=='7'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_corect"]=='6'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>	
	
<td align="center"><div align="center">
	<?php if($objResult["product_corect"]=='5'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>

<td align="center"><div align="center">
	<?php if($objResult["product_corect"]=='4'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_corect"]=='3'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_corect"]=='2'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_corect"]=='1'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


</tr>
	 
	 
<tr>
<td align="center"><div align="center">
<span class='style39'>4</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>มีแนวโน้มที่จะแนะนำให้เพื่อน หรือคนรู้จักมาใช้บริการของ ALLWELL มากน้อยเพียงใด</span>
</div></td>

<td align="center"><div align="center">
	<?php if($objResult["product_3"]=='10'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	
	</div></td>

<td align="center"><div align="center">
	<?php if($objResult["product_3"]=='9'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_3"]=='8'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_3"]=='7'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_3"]=='6'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>	
	
<td align="center"><div align="center">
	<?php if($objResult["product_3"]=='5'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>

<td align="center"><div align="center">
	<?php if($objResult["product_3"]=='4'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_3"]=='3'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_3"]=='2'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


<td align="center"><div align="center">
	<?php if($objResult["product_3"]=='1'){ ?>
<input type='radio'   checked='checked' >
	<?php }else{ ?>
	<input type='radio'  >
	<?php } ?>	
	</div></td>


</tr>	 
	 
</table>

</p>


</br>
<fieldset><legend><b></b></legend></br>

ข้อเสนอแนะอื่นๆ : </p>
		 <textarea name="suggest_1"  class="button4" id="suggest_1" cols="40%" rows="3"><?php echo $objResult["suggest_1"]; ?></textarea><br>

</fieldset>


</br>


     
       </br></br> 
      </form>

    
    
<div id="cr_bar_wrapper">
  <div id="cr_bar"> Copyright © 2018 phar trillion co., ltd. </div>
</div>
</body>
</html>


