<style type="text/css">
<!--
.style15 {
	font-size: 25px; color: #000000;
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

<style>
		body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font: 14pt "Angsana New";
    }
	table {
	  border-collapse: collapse;
	  font-size:14pt;
	}
	.tablel {
	  border-collapse: collapse;
	  font-size:10pt;
	}
	.tablep, .tr, .td {
	  border: 1px solid black;
	}
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 210mm;
        max-height: 297mm;
        padding: 10mm;
        margin: 0mm auto;
        /*border: 0px #D3D3D3 solid;
        border-radius: 0px;*/
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0);
    }
    
    @page {
        size: A4;
        margin: 0;
    }
	@page Section1 {size:841.7pt 595.45pt; margin:1.0in 1.25in 1.0in 1.25in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
	div.Section1 {page:Section1;}
	@page Section2 {size:595.45pt 841.7pt;mso-page-orientation:landscape;margin:0.6in 0.6in 0.6in 0.6in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
	div.Section2 {page:Section2;}

	@media screen {
	  div.divFooter {
		display: none;
	  }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;
			 div.divFooter {
				position: fixed;
				bottom: 0;
			 }
        }
    }
	h1,h2,h3,h4,h5,h6 {
		font: 18pt "Angsana New";
	}
		
		
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
<?php
include "error_page.php";
date_default_timezone_set("Asia/Bangkok");
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

$ref_pc=$_GET["ref_pc"];

include"dbconnect.php";

$strSQL3 = "SELECT * FROM  tb_product_checklist  WHERE ref_pc = '".$ref_pc."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);

$strSQL22 = "SELECT * FROM  tb_product_leaflet  WHERE product_id = '".$objResult3["product_id"]."'";
$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL2."]");
$objResult22 = mysqli_fetch_array($objQuery22);	


$id_ccos = substr($objResult3["ref_id"],0,2);


if($id_ccos=='RT'){
	
$strSQL11 = "SELECT product_code,count,sn_number,remark_sale,sol_name,unit_name FROM  (hos__subrental LEFT JOIN tb_product ON hos__subrental.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult3["ref_id"]."' ";
$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rows11 = mysqli_num_rows($objQuery11);
$objResult11 = mysqli_fetch_array($objQuery11);	
	
	
$strSQL2 = "SELECT * FROM  tb_product_rentalref  WHERE ref_idrt = '".$objResult3["ref_id"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);	
	
}else{	
	
$strSQL2 = "SELECT * FROM  tb_product_checkref  WHERE product_id = '".$objResult3["product_id"]."' and  ref_pc = '".$ref_pc."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

}
	


if($id_ccos=='BR'){
$strSQL = "SELECT * FROM hos__br  WHERE ref_id_br = '".$objResult3["ref_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
}else if($id_ccos=='RT'){
	
$strSQL = "SELECT * FROM hos__rental  WHERE ref_id = '".$objResult3["ref_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
}else if($id_ccos=='CH'){
	
$strSQL = "SELECT * FROM hos__change  WHERE ref_id = '".$objResult3["ref_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
}else{

$strSQL = "SELECT * FROM so__main  WHERE ref_id = '".$objResult3["ref_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
	
}


$strSQL1 = "SELECT * FROM  tb_product  WHERE product_ID = '".$objResult3["product_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$doc = $objResult3["doc_no"];
$year_no = $objResult3["year_no"];
$iv_nocheck = "$doc/$year_no";


if($id_ccos=='BR'){

$ref_id =$objResult["ref_id_br"];
$date_br = DateThai($objResult["date_br"]);
$customer =$objResult["customer"];
$address =$objResult["address"];
$iv_no =$objResult["iv_no"];
$type_doc =$objResult["company"];
	

}else if($id_ccos=='RT'){
	
$ref_id = $objResult["ref_id"];
$date_br = DateThai($objResult["promis_date"]);
$customer =$objResult["rental_name"];
$address =$objResult["rental_address"];
$iv_no =$objResult["iv_no"];
$type_doc =$objResult["type_doc"];
		
		
	
}else if($id_ccos=='CH'){
	
$ref_id = $objResult["ref_id"];
$date_br = DateThai($objResult["date_change"]);
$customer =$objResult["customer"];
$address =$objResult["address"];
$iv_no =$objResult["iv_no"];
$type_doc =$objResult["company"];
	
	
}else{

$ref_id = $objResult["ref_id"];	
$date_br = DateThai($objResult["register_date"]);	
$customer =$objResult["billing_name"];
$address1 =$objResult["address1"];
$address2 =$objResult["address2"];
$address ="$address1 $address2";
$iv_no =$objResult["doc_no"];
$type_doc =$objResult["select_type_doc"];	
	
}


$unit_name = $objResult1["unit_name"];
$product_name = $objResult1["sol_name"];



 if($id_ccos=='RT'){
	 
$ingredient1 = $objResult2["list_des1"];
$ingredient2 = $objResult2["list_des2"];
$ingredient3 = $objResult2["list_des3"];
$ingredient4 = $objResult2["list_des4"];
$ingredient5 = $objResult2["list_des5"];
$ingredient6 = $objResult2["list_des6"];
$ingredient7 = $objResult2["list_des7"];
$ingredient8 = $objResult2["list_des8"];
$ingredient9 = $objResult2["list_des9"];
$ingredient10 = $objResult2["list_des10"];
$ingredient11 = $objResult2["list_des11"];
$ingredient12 = $objResult2["list_des12"];
$ingredient13 = $objResult2["list_des13"];
$ingredient14 = $objResult2["list_des14"];
$ingredient15 = $objResult2["list_des15"];
	 
	 
 }else{	 
	
$ingredient1 = $objResult2["ingredient1"];
$ingredient2 = $objResult2["ingredient2"];
$ingredient3 = $objResult2["ingredient3"];
$ingredient4 = $objResult2["ingredient4"];
$ingredient5 = $objResult2["ingredient5"];
$ingredient6 = $objResult2["ingredient6"];
$ingredient7 = $objResult2["ingredient7"];
$ingredient8 = $objResult2["ingredient8"];
$ingredient9 = $objResult2["ingredient9"];
$ingredient10 = $objResult2["ingredient10"];
$ingredient11 = $objResult2["ingredient11"];
$ingredient12 = $objResult2["ingredient12"];
$ingredient13 = $objResult2["ingredient13"];
$ingredient14 = $objResult2["ingredient14"];
$ingredient15 = $objResult2["ingredient15"];
$ingredient16 = $objResult2["ingredient16"];
$ingredient17 = $objResult2["ingredient17"];
$ingredient18 = $objResult2["ingredient18"];
$ingredient19 = $objResult2["ingredient19"];
$ingredient20 = $objResult2["ingredient20"];
$ingredient21 = $objResult2["ingredient21"];
$ingredient22 = $objResult2["ingredient22"];
$ingredient23 = $objResult2["ingredient23"];
$ingredient24 = $objResult2["ingredient24"];
$ingredient25 = $objResult2["ingredient25"];
$ingredient26 = $objResult2["ingredient26"];
$ingredient27 = $objResult2["ingredient27"];
$ingredient28 = $objResult2["ingredient28"];
$ingredient29 = $objResult2["ingredient29"];

 }




?>
<body>
<form   method="POST" name="frmMain"  enctype="multipart/form-data" action='register_chken2s.php' >

<div class="Section2 page">
	
	<?php if($type_doc =='1'){ ?>

<table style="width:100%;">
	<tr>
		<td valign="bottom" style="width:30%;text-align:left;"><b>บริษัท ออลล์เวล ไลฟ์ จำกัด</b><br>
			73,75 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ
	<br> เขตบางพลัด กรุงเทพมหานคร 10700<br>โทร : 0-2424-3555 (อัตโนมัติ)<br>แฟ็กซ์ : 0-2424-3322
		</td>
		<td valign="bottom" style="width:35%;text-align:center;"><img src="img/allwell_logo.png" width="180" align="center" height="50" ></td>
		<td valign="bottom" style="width:30%;text-align:right;"><b>ALLWELL LIFE CO.,TH</b><br>73,75 Soi Charansanitwong 89/2,<br>
		Bang-Or, Bang-Plad,Bankok 10700<br>TEL : 0-2424-3555 (Auto)<br>FAX : 0-2424-3322
		</td>
	</tr>
	
<tr>
		<td valign="bottom" style="width:30%;text-align:left;">	</td>
		<td valign="bottom" style="width:35%;text-align:center;" class = "style15"><b>ใบรายการตรวจทานสินค้า</b></td>
		<td valign="bottom" style="width:30%;text-align:right;"></td>
	</tr>	
	
	<tr>
		<td valign="bottom" style="width:30%;text-align:left;">	</td>
		<td valign="bottom" style="width:35%;text-align:center;" class = "style15"><b>(Product Check list)</b></td>
		<td valign="bottom" style="width:30%;text-align:right;"></td>
	</tr>	
	
</table>
	
	<?php } ?>
	
	
		<?php if($type_doc =='2'){ ?>

<table style="width:100%;">
	<tr>
		<td valign="bottom" style="width:30%;text-align:left;"><b>บริษัท โนเบิล เมด จำกัด</b><br>
			73 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ
	<br> เขตบางพลัด กรุงเทพมหานคร 10700<br>โทร : 0-2880-5566 (อัตโนมัติ)<br>แฟ็กซ์ : 0-2880-5533
		</td>
		<td valign="bottom" style="width:35%;text-align:center;"><img src="img/nbm_select.png" width="180" align="center" height="50" ></td>
		<td valign="bottom" style="width:30%;text-align:right;"><b>NOBLE MED CO.,LTD</b><br>73 Soi Charansanitwong 89/2,<br>
		Bang-Or, Bang-Plad,Bankok 10700<br>TEL : 0-2880-5566 (Auto)<br>FAX : 0-2880-5533
		</td>
	</tr>
	
<tr>
		<td valign="bottom" style="width:30%;text-align:left;">	</td>
		<td valign="bottom" style="width:35%;text-align:center;" class = "style15"><b>ใบรายการตรวจทานสินค้า</b></td>
		<td valign="bottom" style="width:30%;text-align:right;"></td>
	</tr>	
	
	<tr>
		<td valign="bottom" style="width:30%;text-align:left;">	</td>
		<td valign="bottom" style="width:35%;text-align:center;" class = "style15"><b>(Product Check list)</b></td>
		<td valign="bottom" style="width:30%;text-align:right;"></td>
	</tr>	
	
</table>
	
	<?php } ?>

	<table border="1" width="100%">
		
<tr>
<td valign="bottom" style="width:60%;text-align:left;">ชื่อลูกค้า : <?php echo $customer; ?>	</td>
<td valign="bottom" style="width:20%;text-align:left;" >วันที่ : <?php echo $date_br; ?></td>
<td valign="bottom" style="width:20%;text-align:left;">เลขที่ : <?php echo $iv_nocheck; ?></td>
	</tr>
		
</table>
	<table border="1" width="100%">
		
<tr>
<td valign="bottom" style="width:70%;text-align:left;">ที่อยู่ : <?php echo $address; ?>	</td>

<td valign="bottom" style="width:30%;text-align:left;">อ้างอิงเแกสารเลขที่ : <?php echo $iv_no; ?></td>
	</tr>
		
</table>

<table border="1" width="100%">
		
<tr>
<td valign="bottom" style="width:60%;text-align:center;">รายการ<br>Description</td>
<td valign="bottom" style="width:20%;text-align:center;" >หมายเลขเครื่อง<br>Serial No.</td>
<td valign="bottom" style="width:10%;text-align:center;" >จำนวน<br>Qty</td>
<td valign="bottom" style="width:10%;text-align:center;" >หน่วย<br>Unit</td>
	</tr>
	
<tr>
<td valign="bottom" style="width:60%;text-align:left;"><?php echo $objResult1["sol_name"]; ?></td>
<td valign="bottom" style="width:20%;text-align:left;" ><?php echo $objResult3["sn"]; ?></td>
<td valign="bottom" style="width:10%;text-align:center;" >1</td>
<td valign="bottom" style="width:10%;text-align:center;" ><?php echo $unit_name; ?> </td>
	</tr>	
		
</table>	
	
	<table border="1" width="100%">
		
<tr>
<td valign="bottom" style="width:60%;text-align:center;">รายการตรวจเช็ค<br>Checklist</td>
<td valign="bottom" style="width:5%;text-align:center;" >มี</td>
<td valign="bottom" style="width:5%;text-align:center;" >ไม่มี</td>
<td valign="bottom" style="width:20%;text-align:center;" >หมายเหตุ<br>Remarks</td>
	</tr>
	
<?php if($ingredient1 !=''){ ?>		
<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img1']; ?>" target="_blank"><font color='black' ><?php echo $ingredient1; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check1' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check1' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des1" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
<?php if($ingredient2 !=''){ ?>				
<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img2']; ?>" target="_blank"><font color='black' ><?php echo $ingredient2; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check2' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check2' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des2" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
		
<?php } ?>		
		
<?php if($ingredient3 !=''){ ?>				
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img3']; ?>" target="_blank"><font color='black' ><?php echo $ingredient3; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check3' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check3' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des3"  rows="2" class="w3-input" ></textarea></td>
	</tr>	

		<?php } ?>		
		
<?php if($ingredient4 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img4']; ?>" target="_blank"><font color='black' ><?php echo $ingredient4; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check4' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check4' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des4"  rows="2" class="w3-input" ></textarea></td>
	</tr>	

<?php } ?>		
		
<?php if($ingredient5 !=''){ ?>				
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img5']; ?>" target="_blank"><font color='black' ><?php echo $ingredient5; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check5' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check5' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des5" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
		
<?php } ?>		
		
<?php if($ingredient6 !=''){ ?>				
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img6']; ?>" target="_blank"><font color='black' ><?php echo $ingredient6; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check6' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check6' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des6" rows="2"  class="w3-input" ></textarea></td>
	</tr>	

		
<?php } ?>		
		
<?php if($ingredient7 !=''){ ?>			
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img7']; ?>" target="_blank"><font color='black' ><?php echo $ingredient7; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check7' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check7' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des7"  rows="2" class="w3-input" ></textarea></td>
	</tr>	

<?php } ?>		
		
<?php if($ingredient8 !=''){ ?>			
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img8']; ?>" target="_blank"><font color='black' ><?php echo $ingredient8; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check8' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check8' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des8" rows="2"  class="w3-input" ></textarea></td>
	</tr>	

<?php } ?>		
		
<?php if($ingredient9 !=''){ ?>			
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img9']; ?>" target="_blank"><font color='black' ><?php echo $ingredient9; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check9' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check9' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des9"  rows="2" class="w3-input" ></textarea></td>
	</tr>	

<?php } ?>		
		
<?php if($ingredient10 !=''){ ?>			
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img10']; ?>" target="_blank"><font color='black' ><?php echo $ingredient10; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check10' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check10' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des10"  rows="2" class="w3-input" ></textarea></td>
	</tr>	
		
<?php } ?>		
		
<?php if($ingredient11 !=''){ ?>			
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img11']; ?>" target="_blank"><font color='black' ><?php echo $ingredient11; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check11' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check11' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des11" rows="2"  class="w3-input" ></textarea></td>
	</tr>	

<?php } ?>		
		
<?php if($ingredient12 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img12']; ?>" target="_blank"><font color='black' ><?php echo $ingredient12; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check12' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check12' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des12" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
<?php if($ingredient13 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img13']; ?>" target="_blank"><font color='black' ><?php echo $ingredient13; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check13' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check13' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des13"  rows="2" class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
<?php if($ingredient14 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img14']; ?>" target="_blank"><font color='black' ><?php echo $ingredient14; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check14' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check14' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des14" rows="2"  class="w3-input" ></textarea></td>
	</tr>	

<?php } ?>		
		
<?php if($ingredient15 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img15']; ?>" target="_blank"><font color='black' ><?php echo $ingredient15; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check15' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check15' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des15" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
<?php if($ingredient16 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img16']; ?>" target="_blank"><font color='black' ><?php echo $ingredient16; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check16' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check16' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des16"  rows="2" class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
<?php if($ingredient17 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img17']; ?>" target="_blank"><font color='black' ><?php echo $ingredient17; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check17' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check17' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des17" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
<?php if($ingredient18 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img18']; ?>" target="_blank"><font color='black' ><?php echo $ingredient18; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check18' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check18' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des18" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
<?php if($ingredient19 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img19']; ?>" target="_blank"><font color='black' ><?php echo $ingredient19; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check19' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check19' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des19" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
<?php if($ingredient20 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img20']; ?>" target="_blank"><font color='black' ><?php echo $ingredient20; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check20' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check20' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des20" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		

<?php if($ingredient21 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img21']; ?>" target="_blank"><font color='black' ><?php echo $ingredient21; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check21' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check21' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des21" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
		
		<?php if($ingredient22 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img22']; ?>" target="_blank"><font color='black' ><?php echo $ingredient22; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check22' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check22' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des22" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
		
		<?php if($ingredient23 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img23']; ?>" target="_blank"><font color='black' ><?php echo $ingredient23; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check23' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check23' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des23" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
		
		<?php if($ingredient24 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img24']; ?>" target="_blank"><font color='black' ><?php echo $ingredient24; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check24' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check24' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des24" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
		
		<?php if($ingredient25 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img25']; ?>" target="_blank"><font color='black' ><?php echo $ingredient25; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check25' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check25' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des25" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
		
		<?php if($ingredient26 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img26']; ?>" target="_blank"><font color='black' ><?php echo $ingredient26; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check26' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check26' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des26" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
		
		<?php if($ingredient27 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img27']; ?>" target="_blank"><font color='black' ><?php echo $ingredient27; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check27' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check27' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des27" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
		<?php if($ingredient28 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img28']; ?>" target="_blank"><font color='black' ><?php echo $ingredient28; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check28' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check28' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des28" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
		
		<?php if($ingredient29 !=''){ ?>		
		<tr>
<td valign="bottom" style="width:60%;text-align:left;"><a href="review/<?php echo $objResult22['img29']; ?>" target="_blank"><font color='black' ><?php echo $ingredient29; ?></font></a></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check29' value='1' ></td>
<td valign="bottom" style="width:5%;text-align:center;" ><input type='radio' name='check29' value='2' ></td>
<td valign="bottom" style="width:20%;text-align:center;" ><textarea name="des29" rows="2"  class="w3-input" ></textarea></td>
	</tr>	
<?php } ?>		
		
		
		
	
		
		</table>
	
	
<input name="ref_pc" style="width:90%;" type='hidden' id="ref_pc" value="<?php echo $ref_pc; ?>" class="w3-input"  />	
<input name="ref_id" style="width:90%;" type='hidden' id="ref_id" value="<?php echo $ref_id; ?>" class="w3-input"  />	
	
<br>
<input type='checkbox' name='close_ckk' id='close_ckk' value='1' required> ปิดใบตรวจทาน <br>
หมายเหตุ <br>
<textarea name="close_des"  id="close_des" rows="2" style="width:90%;" class="w3-input" required></textarea>	


<br>
	<center>
<input type="Submit" name ="Submit" value="บันทึก" class = "button button4" >
</center>
	
</div>
</form>
</body>

