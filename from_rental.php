<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 16px; color: #000000;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {font-size: 16px; color: #FF0000; }
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 15px; color: #000000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#CCFF66;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#FF3333;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}



</style>

<style>
		body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font: 16pt "Angsana New";
    }
	table {
	  border-collapse: collapse;
	  font-size:14pt;
	}
	.tablel {
	  border-collapse: collapse;
	  font-size:10pt;
	}
	.tablepr {
	  border-collapse: collapse;
	  font-size:12pt;
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
        padding-left: 10mm;
		padding-right: 10mm;
		padding-top: 5mm;
		padding-bottom: 0mm;
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
	@page Section2 {size:595.45pt 841.7pt;mso-page-orientation:landscape;margin:0.4in 0.4in 0.4in 0.4in;mso-header-margin:.4in;mso-footer-margin:.4in;mso-paper-source:0;}
	div.Section2 {page:Section2;}

	@media screen {
	  div.divFooter {
		display: none;
	  }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;
			margin: 0;
			 div.divFooter {
				position: fixed;
				bottom: 0;
			 }
        }
    }
	h1,h2,h3,h4,h5,h6 {
		font: 18pt "Angsana New";
	}
</style>

<?php


include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorHTML.php";
include "src/BarcodeGeneratorPNG.php";


function barcode($code){
    
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $border = 1.0;//กำหนดความหน้าของเส้น Barcode
    $height = 20;//กำหนดความสูงของ Barcode
 
    return $generator->getBarcode($code , $generator::TYPE_CODE_128,$border,$height);
 
}
 

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

$ref_id=$_GET["ref_id"];



include"dbconnect.php";

$strSQL = "SELECT * from hos__rental WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$iv_no =$objResult["iv_no"]; 
$ref_id =$objResult["ref_id"]; 
$type_doc =$objResult["type_doc"]; 
$register_date =Datethai($objResult["register_date"]); 
if($objResult["iv_date"]='0000-00-00'){
$iv_date ="";	
}else{
$iv_date =Datethai($objResult["iv_date"]); 
}
$rental_id =$objResult["rental_id"]; 
$rental_name =$objResult["rental_name"]; 
$rental_address =$objResult["rental_address"]; 
$rental_tel =$objResult["rental_tel"]; 
$connect_name =$objResult["connect_name"]; 
$connect_tel =$objResult["connect_tel"]; 
$install_date =Datethai($objResult["install_date"]); 
$start_promis =Datethai($objResult["start_promis"]); 
$end_promis =Datethai($objResult["end_promis"]); 
$count_m =$objResult["count_m"]; 
$unit_m =$objResult["unit_m"]; 
$promis_no =$objResult["promis_no"]; 
if($objResult["promis_date"]=='0000-00-00'){
$promis_date ='';	
}else{
$promis_date =$objResult["promis_date"]; 
}
$des_sale =$objResult["des_sale"]; 
$install_address =$objResult["install_address"]; 
$bill_name =$objResult["bill_name"]; 
$bill_address =$objResult["bill_address"]; 
$bill_tel =$objResult["bill_tel"]; 
$tax_no =$objResult["tax_no"]; 
$payment =$objResult["payment"]; 
$patient_name =$objResult["patient_name"]; 
$emergency_name =$objResult["emergency_name"]; 
$emergency_tel =$objResult["emergency_tel"]; 
$add_by =$objResult["add_by"]; 
$sale_code =$objResult["sale_code"]; 
$sup_name =$objResult["sup_name"]; 
if($objResult["sup_date"]=='0000-00-00 00:00:00'){
$sup_date='';	
}else{
$sup_date = Datethai($objResult["sup_date"]); 
}
$send_admin =$objResult["send_admin"]; 
$send_sup =$objResult["send_sup"]; 
$bill_vat =$objResult["bill_vat"]; 


$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subrental WHERE ref_idd = '".$ref_id."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";


?>
<div class="Section2 page">
<body>

<table style="width:100%;">
	<tr>
		<td style="width:30%;text-align:left;"><span align="left" style="color:red"><div align="left"><?php echo $customer_no;?></div>
			<?php if($type_doc=='4'){ ?>
			<img src="img/nb_logo.jpg" width="80" align="left" height="40" /> <?php } ?> </td>
		<td style="width:40%;text-align:center;"><font size="5">ใบสั่งเช่า</font><br><font size="4">(Rental Order)</font></td>
		<td style="width:30%;text-align:right;"><span align="right"><div align="right"><?php echo $iv_no;?></div><div align="right"><?php echo barcode($iv_no);?></div></span></td>
	</tr>
</table>
<!--div align="right"><?php echo barcode($iv_no);?></div-->
<table style="width:100%;" border="0">
	<tr>
		<td style="width:70%;">
			เลขที่อ้างอิง : <span class="style38"><?php echo $ref_id; ?></span>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>วันที่ </span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<span class="style38"><?php echo $register_date; ?></span>
		</td>
		</tr>
</table>

<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			<span>ชื่อ-นามสกุล ผู้เช่า</span>
		</td>
		<td style="border-bottom: 1px solid black;width:50%;">
			<span class="style38"><?php echo $rental_name; ?></span>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>เบอร์โทร </span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<span class="style38"><?php echo $rental_tel; ?></span>
		</td>
	</tr>
	</table>
	<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			<span>ที่อยู่ผู้เช่า</span>
		</td>
		<td style="border-bottom: 1px solid black;">
			<span class="style38"><?php echo $rental_address; ?></span>
		</td>
	</tr>
	</table>
	<table style="width:100%;" border="0">
		<tr>
		<td style="width:20%;">
			<span>ชื่อที่ต้องการออกบิล </span>
		</td>
		<td style="border-bottom: 1px solid black;width:50%;">
			<span class="style38"><?php echo $pre_name; ?><?php echo $bill_name; ?> </span> <?php echo 'เลขผู้เสียภาษี :'; ?>  <span class="style38"><?php echo $tax_id; ?></span>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>เบอร์โทร </span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<span class="style38"><?php echo $bill_tel; ?></span>
		</td>
	</tr>
</table>
<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			<span>ที่อยู่ที่ต้องการออกบิล </span>
		</td>
		<td style="border-bottom: 1px solid black;">
			<span class="style38"><?php echo $bill_address; ?></span>
		</td>
	</tr>
	<tr>
		<td style="width:20%;">
			<span>ชื่อผู้ป่วย </span>
		</td>
		<td style="border-bottom: 1px solid black;">
			<span class="style38"><?php echo $patient_name; ?></span>
		</td>
	</tr>
	</table>
<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			<span>สถานที่ติดตั้ง </span>
		</td>
		<td style="border-bottom: 1px solid black;">
			<span class="style38"><?php echo $install_address; ?></span>
		</td>
		
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>วันที่ติดตั้ง </span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<span class="style38"><?php echo $install_date; ?></span>
		</td>
	</tr>
	
</table>
<table style="width:100%;" border="0">
	<tr>
		<td style="width:10%;">
			<span>ชื่อผู้ติดต่อ </span>
		</td>
		<td style="border-bottom: 1px solid black;width:30%;">
			<span class="style38"><?php echo $connect_name; ?></span>
		</td>
		
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>เบอร์โทรผู้ติดต่อ </span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<span class="style38"><?php echo $connect_tel; ?></span>
		</td>
	</tr>
	<tr>
		<td style="width:10%;">
			<span>ผู้ติดต่อกรณีฉุกเฉิน </span>
		</td>
		<td style="border-bottom: 1px solid black;width:30%;">
			<span class="style38"><?php echo $emergency_name; ?></span>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>เบอร์โทร</span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<span class="style38"><?php echo $emergency_tel; ?></span>
		</td>
	</tr>
	
</table>

<br>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" >ลำดับ</td>
<td width="15%" align="center" >รหัสสินค้า</td>
<td width="30%" align="center" >รายละเอียด</td> 
<td width="10%" align="center" >จำนวน</td> 
<td width="10%" align="center" >ราคาต่อหน่วย</td> 
<td width="10%" align="center" >ยอดรวม</td> 
</tr>
<?php

$strSQL1 = "SELECT * FROM (hos__subrental LEFT JOIN tb_product ON hos__subrental.product_ID=tb_product.product_id) where ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{


$sum_amount= number_format($objResult1["amount"],2)."";
$price= number_format($objResult1["price"],2)."";
$access_code  =$objResult1["access_code"];
$access_name  =$objResult1["sol_name"];
$count  =$objResult1["count"];
$unit  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];

?>
	<tr>

<td align="center" class="style38"><?php echo $i;?></td>
<td align="center" class="style38"><?php echo $access_code;?></td>
<td align="left" class="style38"><?php echo $access_name; ?></td>
<td align="right" class="style38"><?php echo $count;?> &nbsp <?php echo $unit;?></td>
<td align="right" class="style38"><?php echo $price;?></td>
<td align="right" class="style38"><?php echo $sum_amount;?></td>



<?php 
$i++; 
}
?>
</tr>
</table>

<table class="tablep" width="100%" border= "1" >
<tr>
	<td style="border-right:1px solid black;"><?php if ($bill_vat ==1){ ?><input type="checkbox" checked>  <span>ต้องการใบกำกับภาษีเต็มรูปแบบ</span><?php } else{ ?><input type="checkbox">  <span >ต้องการใบกำกับภาษีเต็มรูปแบบ</span><?php } ?></td>
	<td style="text-align:right;width:23.2%;">Total : <?php echo $summary;?></td>
</tr>
</table><br>

<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			<span>เลขที่สัญญา</span>
		</td>
		<td style="border-bottom: 1px solid black;width:50%;">
			<span class="style38"><?php echo $promis_no; ?></span>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>วันที่</span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<span class="style38"><?php echo $promis_date; ?></span>
		</td>
	</tr>
	<tr>
		<td style="width:20%;">
			<span>บิลเลขที่</span>
		</td>
		<td style="border-bottom: 1px solid black;width:50%;">
			<span class="style38"><?php echo ""; ?></span>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>วันที่ออกบิล</span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<span class="style38"><?php echo ""; ?></span>
		</td>
	</tr>
	</table>
	<table style="width:100%;" border="0">
	<tr>
		<td style="width:20%;">
			<span>หมายเหตุเพิ่มเติม</span>
		</td>
		<td style="border-bottom: 1px solid black;">
			<span class="style38"><?php echo $des_sale; ?></span>
		</td>
	</tr>
	<tr>
		</table><br>

<div style="padding-top:5px;"></div>
<table style="width:100%;" border="0">
	<tr>
		<td style="text-align:center;width:33%;">
			<span ><u><?php echo $add_by; echo "("; echo $sale_code; echo ")"; echo "/"; echo $register_date; ?></u></span>
		</td>
		<td style="text-align:center;width:33%;">
			<span align="right"><?php echo $iv_no ; ?></span>
		</td>
		<td style="text-align:center;width:33%;">
			<span ><u><?php echo $sup_name; echo "/"; echo $sup_date; ?></u></span>
		</td>
	</tr>
	<tr>
		<td style="text-align:center;width:33%;">
			<span >Sales Signature/Area/Date</span>
		</td>
		<td style="text-align:center;width:33%;">
			<span align="right"><?php echo $iv_date ; ?></span>
		</td>
		<td style="text-align:center;width:33%;">
			<span >Authorized Signature/Date</span>
		</td>
	</tr>
</table>
	<br><br>
<table style="width:100%;" class="tablel">
	<tr>
		<td><span>อนุมัติวันที่ 21 ต.ค. 2562 </span></td>
		<td style="text-align:right;"><span>FM-SA-19:Rev.1</span></td>
	</tr>
</table>	

<br>
	
	
<br><br><br>
</body>
</html>