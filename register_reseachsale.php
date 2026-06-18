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

  
		   
  
	<form action="register_reseachsale1.php" name="frmAdd" method="post" onSubmit="JavaScript:return fncSubmit();">

	 

<?php

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;



$strSQL = "SELECT * FROM tb_research WHERE running_id = '".$_GET["running"]."' ";
$objQuery = mysqli_query($com1,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
		
$strSQL1 = "SELECT * FROM hos__so WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);
		
$strSQL2 = "SELECT * FROM tb_register_data WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
$objResult2 = mysqli_fetch_array($objQuery2);

?>


<div class="w3-container w3-padding-large">

	ลูกค้าเกรด :
	<?php if($objResult1["sale_code"]=='S31' or $objResult1["sale_code"]=='MM1'){ ?>
     <input type='radio' name = "grade"  name='grade'  value="B" checked="checked" size='10' > B
	
	<?php }else { ?> 
	<input type='radio' name = "grade"  name='grade'  value="A" checked="checked" size='10' > A
	
	<?php } ?>
	</p>
	
	  วันที่ :</p>
      <input type='date' name = "date_sale" class="button4"  name='date_sale'  value="<?php echo $today; ?>" size='10' readonly> </p>
<input type='hidden' name = "iv_date" class="button4"  name='iv_date'  value="<?php echo $objResult1["iv_date"]; ?>" size='10' readonly> </p>

  ชื่อลูกค้า :</p>
	   <input name="customer_name" type='text' id="customer_name" value="<?php echo $objResult1["bill_name"]; ?>" size="40%"  class="button4"/>&nbsp;&nbsp;&nbsp;</p>
      <input name="running_id" type='hidden' id="running_id"  size="6" value="<?=$objResult1["job_no"]?>" class="button4" readonly/>
     โทรศัพท์ :</p>
      <input name="customer_tel" type='text' id="customer_tel" value="<?php echo $objResult2["customer_tel"];?>" size="40%" class="button4"  /></p>
	  
<input name="ref_id" type='hidden' id="ref_id" value="<?php echo $objResult1["ref_id"];?>" size="40%" class="button4"  />

	  
	   เลขที่ IV :</p>
      <input name="iv_number" type='text' id="iv_number" value="<?php echo $objResult1["iv_no"];?>" size="40%"  class="button4"/>&nbsp;&nbsp;&nbsp;</p>
      <input name="employee_code" type='hidden' id="employee_code" value="<?php echo $objResult["employee_code"];?>" size="40%"  class="button4"/>
	<input name="sale_code" type='hidden' id="sale_code" value="<?php echo $objResult1["sale_code"];?>" size="40%"  class="button4"/>

 สินค้า :</p>
      <textarea name="product_name"  id="product_name" cols="40" rows="2"  class="button4"><?php echo $objResult2["product_name"];?></textarea>&nbsp;&nbsp;&nbsp;</p>

ชื่อพนักงานส่ง :</p>
      <input name="team_send" type='text' id="team_send" value="<?php echo $objResult["team_send"];?>" size="40%" class="button4"  />



</p></p>
				

โปรดใส่เครื่องหมาย  <input type='radio'   value='' checked='checked'/> ลงในช่องที่ท่านเห็นด้วย
      </p>

	 (คะแนนการประเมิน มากที่สุด = 5, มาก  = 4, ปานกลาง = 3, น้อย = 2, น้อยที่สุด = 1 )
      </p> </p>

<u>ความพึงพอใจต่อพนักงานขาย</u></p>

	  <table border="1" class="w3-table" width="100%">
<tr>
<td width="7%"  bgcolor="#CFCFCF"><div align="center" >ลำดับ </div></td>
<td width="50%"  bgcolor="#CFCFCF"><div align="center" >รายละเอียด</div></td> 
<td width="8%"  bgcolor="#CFCFCF"><div align="center" >มากที่สุด</div></td>
<td width="8%"  bgcolor="#CFCFCF"><div align="center" >มาก</div></td>

<td width="8%"  bgcolor="#CFCFCF"><div align="center" >ปานกลาง</div></td>
<td width="8%"  bgcolor="#CFCFCF"><div align="center" >น้อย</div></td>
<td width="8%"  bgcolor="#CFCFCF"><div align="center" >น้อยที่สุด</div></td>

</tr>

<tr>
<td align="center"><div align="center">
<span class='style39'>1</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>พนักงานขายมีกิริยามารยาทเรียบร้อย พูดจาสุภาพ อัธยาศัยดี วางตัวเหมาะสม</span>
</div></td>

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
<span class='style39'>พนักงานขายมีความรู้ความชำนาญในตัวสินค้า สามารถแนะนำ ตอบข้อซักถามได้ชัดเจน</span>
</div></td>

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
<span class='style39'>พนักงานขายบริการด้วยความรวดเร็ว/เอาใจใส่ และมีความเต็มใจให้บริการ</span>
</div></td>

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
		  
		  
  <tr>
			  <td align="center"><div align="center">
<span class='style39'>4</span>
</div></td>
	<td align="left"><div align="left">
<span class='style39'>การติดต่อพนักงานขายในช่องทางต่างๆ รวดเร็ว และมีประสิทธิภาพ</span>
</div></td>

<td align="center"><div align="center">
<input type='radio'  name='sale_4' id = 'sale_4' value='5' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='sale_4' id = 'sale_4' value='4' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_4' id = 'sale_4' value='3' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_4' id = 'sale_4' value='2' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='sale_4' id = 'sale_4' value='1' /></div></td>



</tr>

</table>
</p>

<fieldset><legend><b></b></legend></br>

ข้อเสนอแนะอื่นๆ : </p>
		 <textarea name="suggest"  class="button4" id="suggest" cols="40%" rows="3"></textarea></p>

</fieldset></br>

<u> ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์</u></p>

 <table border="1" class="w3-table" width="100%">
<tr>
<td width="7%"  bgcolor="#CFCFCF"><div align="center" >ลำดับ </div></td>
<td width="50%"  bgcolor="#CFCFCF"><div align="center" >รายละเอียด</div></td> 
<td width="8%"  bgcolor="#CFCFCF"><div align="center" >มากที่สุด</div></td>
<td width="8%"  bgcolor="#CFCFCF"><div align="center" >มาก</div></td>

<td width="8%"  bgcolor="#CFCFCF"><div align="center" >ปานกลาง</div></td>
<td width="8%"  bgcolor="#CFCFCF"><div align="center" >น้อย</div></td>
<td width="8%"  bgcolor="#CFCFCF"><div align="center" >น้อยที่สุด</div></td>

</tr>

<tr>
<td align="center"><div align="center">
<span class='style39'>1</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>สินค้ามีคุณภาพ และสามารถใช้งานได้อย่างมีประสิทธิภาพ</span>
</div></td>

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
<span class='style39'>สินค้าตรงกับความต้องการของลูกค้า</span>
</div></td>

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
<span class='style39'>ความพึงพอใจในสินค้า</span>
</div></td>

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
</table>

</p>


</br>
<fieldset><legend><b></b></legend></br>

ข้อเสนอแนะอื่นๆ : </p>
		 <textarea name="suggest_1"  class="button4" id="suggest_1" cols="40%" rows="3"></textarea></p>

</fieldset>


</br>


<fieldset><legend><b></b></legend></br>

<input type='checkbox'  name='no_research' id = 'no_research' value='1' /><font color ="red">ไม่ต้องทำแบบสอบถาม </font> </p>
		 

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


