<?php include "test.php"; ?>

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
      <h2><span class="style15" align="right">แบบสอบถามความพึงพอใจหลังการขาย</span></h2> </p>
             <h2><span class="style15" align="right">(Customer's Satisfaction Questionnaire after sale)</span></h2> </p>

 
   </center>
  
  
	<form action="register_commentb1.php" name="frmAdd" method="post" onSubmit="JavaScript:return fncSubmit();">

	 

<?php

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;



/*$strSQL = "SELECT * FROM tb_research WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery = mysqli_query($com1,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);*/
		
$strSQL1 = "SELECT * FROM so__main WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);
		
$strSQL11 = "SELECT sol_name FROM  (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";
$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);		
		

?>


<div class="w3-container w3-padding-large">

	ลูกค้าเกรด :
	
	<input type='radio' name = "grade"  name='grade'  value="B" checked="checked" size='10' > B
	
	</p>
	
	  วันที่ :</p>
      <input type='date' name = "date_sale" class="button4"  name='date_sale'  value="<?php echo $today; ?>" size='10' readonly> </p>
<input type='hidden' name = "iv_date" class="button4"  name='iv_date'  value="<?php echo $objResult1["doc_release_date"]; ?>" size='10' readonly> </p>

  ชื่อลูกค้า :</p>
	   <input name="customer_name" type='text' id="customer_name" value="<?php echo $objResult1["customer_name"]; ?>" size="40%"  class="button4"/>&nbsp;&nbsp;&nbsp;</p>
      <input name="running_id" type='hidden' id="running_id"  size="6" value="<?=$objResult1["job_id"]?>" class="button4" readonly/>
     โทรศัพท์ :</p>
      <input name="customer_tel" type='text' id="customer_tel" value="<?php echo $objResult1["tel"];?>" size="40%" class="button4"  /></p>
	  
<input name="ref_id" type='hidden' id="ref_id" value="<?php echo $objResult1["ref_id"];?>" size="40%" class="button4"  />

	  
	   เลขที่ IV :</p>
      <input name="iv_number" type='text' id="iv_number" value="<?php echo $objResult1["doc_no"];?>" size="40%"  class="button4"/>&nbsp;&nbsp;&nbsp;</p>
     
	<input name="sale_code" type='hidden' id="sale_code" value="<?php echo $objResult1["employee_name"];?>" size="40%"  class="button4"/>

 สินค้า :</p>
      <textarea name="product_name"  id="product_name" cols="40" rows="2"  class="button4"><?php echo $objResult11["sol_name"];?></textarea>&nbsp;&nbsp;&nbsp;</p>

ชื่อพนักงานส่ง :</p>
      <input name="team_send" type='text' id="team_send" value="<?php echo 'Kerry';?>" size="40%" class="button4"  />



</p></p>
				

โปรดใส่เครื่องหมาย  <input type='radio'   value='' checked='checked'/> ลงในช่องที่ท่านเห็นด้วย
      </p>

	 (คะแนนการประเมิน มากที่สุด = 10, น้อยที่สุด = 1 )
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
<input type='radio'  name='sale_neat' id = 'sale_neat' value='10' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='sale_neat' id = 'sale_neat' value='9' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_neat' id = 'sale_neat' value='8' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_neat' id = 'sale_neat' value='7' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_neat' id = 'sale_neat' value='6' /></div></td>
	
	
<td align="center"><div align="center">
<input type='radio'  name='sale_neat' id = 'sale_neat' value='5' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='sale_neat' id = 'sale_neat' value='4' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_neat' id = 'sale_neat' value='3' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_neat' id = 'sale_neat' value='2' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_neat' id = 'sale_neat' value='1' /></div></td>


</tr>

<tr>
<td align="center"><div align="center">
<span class='style39'>2</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>พนักงานขายพูดจาสุภาพ อัธยาศัยดี วางตัวเหมาะสม</span>
</div></td>

<td align="center"><div align="center">
<input type='radio'  name='sale_data' id = 'sale_data' value='10' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='sale_data' id = 'sale_data' value='9' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_data' id = 'sale_data' value='8' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_data' id = 'sale_data' value='7' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_data' id = 'sale_data' value='6' /></div></td>	
	
<td align="center"><div align="center">
<input type='radio'  name='sale_data' id = 'sale_data' value='5' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='sale_data' id = 'sale_data' value='4' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_data' id = 'sale_data' value='3' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_data' id = 'sale_data' value='2' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_data' id = 'sale_data' value='1' /></div></td>
	</tr>
		  <tr>
			  <td align="center"><div align="center">
<span class='style39'>3</span>
</div></td>
	<td align="left"><div align="left">
<span class='style39'>ความพึงพอใจต่อบริการที่ได้รับจาก ออลล์เวลในครั้งนี้</span>
</div></td>

<td align="center"><div align="center">
<input type='radio'  name='sale_3' id = 'sale_3' value='10' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='sale_3' id = 'sale_3' value='9' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_3' id = 'sale_3' value='8' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_3' id = 'sale_3' value='7' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_3' id = 'sale_3' value='6' /></div></td>			  
			  
<td align="center"><div align="center">
<input type='radio'  name='sale_3' id = 'sale_3' value='5' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='sale_3' id = 'sale_3' value='4' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_3' id = 'sale_3' value='3' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_3' id = 'sale_3' value='2' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_3' id = 'sale_3' value='1' /></div></td>

</tr>
		  
		  
</table>
</p>

<fieldset><legend><b></b></legend></br>

ข้อเสนอแนะอื่นๆ : </p>
		 <textarea name="suggest"  class="button4" id="suggest" cols="40%" rows="3"></textarea><br>

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
<input type='radio'  name='product_good' id = 'product_good' value='10' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_good' id = 'product_good' value='9' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_good' id = 'product_good' value='8' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_good' id = 'product_good' value='7' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_good' id = 'product_good' value='6' /></div></td>
	
	
<td align="center"><div align="center">
<input type='radio'  name='product_good' id = 'product_good' value='5' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_good' id = 'product_good' value='4' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_good' id = 'product_good' value='3' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_good' id = 'product_good' value='2' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_good' id = 'product_good' value='1' /></div></td>


</tr>
<tr>
<td align="center"><div align="center">
<span class='style39'>2</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>ระดับคุณภาพสินค้าเมื่อเทียบกับบริษัทอื่นๆ</span>
</div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_link' id = 'product_link' value='10' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_link' id = 'product_link' value='9' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_link' id = 'product_link' value='8' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_link' id = 'product_link' value='7' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_link' id = 'product_link' value='6' /></div></td>
	
	
<td align="center"><div align="center">
<input type='radio'  name='product_link' id = 'product_link' value='5' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_link' id = 'product_link' value='4' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_link' id = 'product_link' value='3' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_link' id = 'product_link' value='2' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_link' id = 'product_link' value='1' /></div></td>


</tr>
	 
<tr>
<td align="center"><div align="center">
<span class='style39'>3</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>ความพึงพอใจในสินค้าโดยรวม</span>
</div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_corect' id = 'product_corect' value='10' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_corect' id = 'product_corect' value='9' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_corect' id = 'product_corect' value='8' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_corect' id = 'product_corect' value='7' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_corect' id = 'product_corect' value='6' /></div></td>	
	
<td align="center"><div align="center">
<input type='radio'  name='product_corect' id = 'product_corect' value='5' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_corect' id = 'product_corect' value='4' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_corect' id = 'product_corect' value='3' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_corect' id = 'product_corect' value='2' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_corect' id = 'product_corect' value='1' /></div></td>


</tr>
	 
<tr>
<td align="center"><div align="center">
<span class='style39'>4</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>มีแนวโน้มที่จะแนะนำให้เพื่อน หรือคนรู้จักมาใช้บริการของ ALLWELL มากน้อยเพียงใด</span>
</div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_3' id = 'product_3' value='10' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_3' id = 'product_3' value='9' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_3' id = 'product_3' value='8' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_3' id = 'product_3' value='7' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_3' id = 'product_3' value='6' /></div></td>	
	
<td align="center"><div align="center">
<input type='radio'  name='product_3' id = 'product_3' value='5' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_3' id = 'product_3' value='4' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_3' id = 'product_3' value='3' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_3' id = 'product_3' value='2' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_3' id = 'product_3' value='1' /></div></td>


</tr>	 
	 
	 
	 
</table>

</p>


</br>
<fieldset><legend><b></b></legend></br>

ข้อเสนอแนะอื่นๆ : </p>
		 <textarea name="suggest_1"  class="button4" id="suggest_1" cols="40%" rows="3"></textarea><br>

</fieldset>


</br>


<p align="center">
          <label>          <span class="style43">

        <input type="submit" name="button" id="button" value="Submit"  class="button button3" />
			
           </span></label>
        </p>
     
       </br></br> 
      </form>

    
    
<div id="cr_bar_wrapper">
  <div id="cr_bar"> Copyright © 2018 phar trillion co., ltd. </div>
</div>
</body>
</html>


