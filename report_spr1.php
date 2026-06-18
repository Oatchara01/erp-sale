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
.style35 {font-size: 10.5px; color: #000000; }
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
        font: 13pt "Angsana New";
    }
	table {
	  border-collapse: collapse;
	  font-size:13pt;
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
</style>

<?php

include "error_page.php";
include"dbconnect.php";


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

$ref_id = $_GET["ref_id"];


include"dbconnect.php";

$strSQL = "SELECT * FROM hos__spr WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL)or die ("Error Query [".$strSQL."]");;
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM (hos__subspr LEFT JOIN tb_product ON hos__subspr.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


$strSQL2 = "SELECT SUM(sum_amount) As sum_amount FROM hos__subspr WHERE ref_idd = '".$ref_id."' ";
$objQuery2 = mysqli_query($conn,$strSQL2)or die ("Error Query [".$strSQL2."]");;
$objResult2 = mysqli_fetch_array($objQuery2);

$sum_a = number_format($objResult2["sum_amount"],2)."";



$month = date('m');
$day = date('d');
$year = date('Y');

$today1 = $year . '-' . $month . '-' . $day;
$today=DateThai($today1);


 $spr_date = DateThai($objResult['spr_date']);
 $date_receive = DateThai($objResult['date_receive']);
 $customer = $objResult['customer'];
 $address = $objResult['address'];
 $type_company  = $objResult['type_company'];
 $wo_no  = $objResult['wo_no'];
 $spr_no = $objResult['spr_no'];
 $equipment = $objResult['equipment'];
 $sn_num = $objResult['sn_num'];
 $engineer = $objResult['engineer'];
 $per_no = $objResult['per_no'];
 $clear_brn = $objResult['clear_brn'];
 $brn_no = $objResult['brn_no'];
 $clear_brnp = $objResult['clear_brnp'];
 $brnp_no = $objResult['brnp_no'];
 $clear_epe = $objResult['clear_epe'];
 $epe_no = $objResult['epe_no'];
 $pro_ckk = $objResult['pro_ckk'];
 $pro_des = $objResult['pro_des'];
 $sup_name = $objResult['sup_name'];
 $send_cm = $objResult['send_cm'];
 $cm_name = $objResult['cm_name'];
 $comment_cm = $objResult['comment_cm'];
if($objResult['cm_date']!='0000-00-00'){
  $cm_date = DateThai($objResult['cm_date']);
}else{
$cm_date = '';	
}

if($objResult['sup_date']!='0000-00-00'){
  $sup_date = DateThai($objResult['sup_date']);
}else{
$sup_date = '';	
}
 //$sup_date = DateThai($objResult['sup_date']);
 $engineer_date = DateThai($objResult['engineer_date']);
 $date_imstall = DateThai($objResult['date_imstall']);
 $date_exp = DateThai($objResult['date_exp']);
$status_doc = $objResult['status_doc'];


?>



<div class="Section2 page">
<body>
<table style="width:100%;">
	<tr>
	<td valign="top" style="width:20%;"><input type="checkbox"> ก <input type="checkbox"> C</td>
	</tr>	
</table>
	
<fieldset>	
<table style="width:100%;" >
	<tr>
<td valign="top" style="text-align:center; width:80%;"><font size="5">ใบเบิกเครื่องและอะไหล่</font><br><font size="4">(Device and Spare Part Request)</font></td>
		<?php if($type_company=='1'){ ?>
	<td valign="top" style="width:1%;"></td>
	<?php }else if($type_company=='2'){ ?>
		<td valign="top" style="width:20%;"><img src="img/nb_logo.jpg" width="100" align="right" height="40" /></td>
		<?php } ?>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td ></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td></td>
		<td></td>
		<td><div align="right" >SPR : <?php echo $spr_no;?></div><div align="right"><?php echo barcode($spr_no);?></div></td>
	</tr>
</table>
</fieldset>
<fieldset>	
<table width="100%">
<tr>
<td style="width:10%;"> Engineer : </td>
<td style="width:65%;"><?php echo $engineer; ?><hr color="black"  width="90%" size="0.1" align="left"></td>
<td style="width:10%;">Date : </td>
<td style="width:22%;"><?php echo $spr_date; ?><hr color="black"  width="90%" size="0.1" align="left"></td>	
</tr>	
	
<tr>
<td style="width:10%;"> Customer :</td>
<td style="width:65%;"> <?php echo $customer; ?><hr color="black"  width="90%" size="0.1" align="left"></td>
<td style="width:10%;">W/O No.  : </td>
<td style="width:22%;"><?php echo $wo_no; ?><hr color="black"  width="90%" size="0.1" align="left"></td>	
</tr>		
	
<tr>
<td style="width:10%;"> Address :</td>
<td style="width:65%;"> <?php echo $address; ?><hr color="black"  width="90%" size="0.1" align="left"></td>
<td style="width:10%;"></td>
<td style="width:22%;"></td>	
</tr>	

<tr>
<td style="width:10%;"> Equipment :</td>
<td style="width:65%;"> <?php echo $equipment; ?><hr color="black"  width="90%" size="0.1" align="left"></td>
<td style="width:10%;">วันที่สินค้าเข้า  : </td>
<td style="width:22%;"><?php echo $date_receive; ?><hr color="black"  width="90%" size="0.1" align="left"></td>	
</tr>		
	
</table>
	
<table width="100%" >	
<tr>
<td style="width:10%;"> วันที่ติดตั้ง :</td>
<td style="width:25%;"> <?php echo $date_imstall; ?><hr color="black"  width="90%" size="0.1" align="left"></td>
<td style="width:10%;">วันที่หมดประกัน  : </td>
<td style="width:25%;"><?php echo $date_exp; ?><hr color="black"  width="90%" size="0.1" align="left"></td>	
<td style="width:8%;">PER  : </td>
<td style="width:25%;"><?php echo $per_no; ?><hr color="black"  width="90%" size="0.1" align="left"></td>	
</tr>		
	
</table>	
	
	<table width="100%" >	
<tr>
<td style="width:10%;"> วันที่ติดตั้ง :</td>
<td style="width:25%;"> <?php echo $date_imstall; ?><hr color="black"  width="90%" size="0.1" align="left"></td>
<td style="width:10%;">วันที่หมดประกัน  : </td>
<td style="width:25%;"><?php echo $date_exp; ?><hr color="black"  width="90%" size="0.1" align="left"></td>	
<td style="width:8%;">PER  : </td>
<td style="width:25%;"><?php echo $per_no; ?><hr color="black"  width="90%" size="0.1" align="left"></td>	
</tr>		
	
</table>	
</fieldset>
	
<fieldset>
	
<table width="100%" >	
<tr>
<td style="width:10%;"> S/N :</td>
<td style="width:90%;"> <?php echo $sn_num; ?></td>

</tr>		
	
</table>		
	
	
</fieldset>
	

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" ><font color='red'>รับสินค้า</font></td>	
<td width="5%" align="center" >เคลียร์ยืม</td>
<td width="5%" align="center" >Item</td>
<td width="30%" align="center" >Description</td>
<td width="10%" align="center" >Qty.</td> 
<td width="8%" align="center" >Unit</td> 
<td width="15%" align="center" >Unit Price</td> 
<td width="15%" align="center" >Amount</td> 
<td width="30%" align="center" >หมายเลขเครื่อง</td> 

</tr>

<?php

$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
$cs_ckk = $objResult1["cs_ckk"];
$unit_name  =$objResult1["unit_name"];
$product_name  =$objResult1["sol_name"];
//$product_name = substr($product_name1,0,70);	
$sale_count  =$objResult1["sale_count"];
$unit_price  =number_format($objResult1["unit_price"],2)."";
$sale_remark  =$objResult1["sale_remark"];
$sum_amount =number_format($objResult1["sum_amount"],2)."";
$sn  =$objResult1["sn"];
$clear_br =$objResult1["clear_br"];
$clear_ivno  =$objResult1["clear_ivno"];	
	
	
?>
	<tr>
<td align="center" >
	<?php if ($cs_ckk =='1'){ ?><input type="checkbox" checked> <?php }else{ ?>  <input type="checkbox"> <?php } ?>
	
		</td>		
<td align="center" >
	<?php if ($clear_br =='1'){ ?><input type="checkbox" checked> <?php }else{ ?>  <input type="checkbox"> <?php } ?>
	<?php echo $clear_ivno; ?>	
		</td>
<td align="center" ><?php echo $i;?></td>
<td align="left" ><?php echo $product_name; ?> </td>
<td align="right" ><?php echo $sale_count; ?></td>
<td align="center" ><?php echo $unit_name; ?></td>
<td align="right" ><?php echo $unit_price; ?></td>
<td align="right" ><?php echo $sum_amount; ?></td>
<td align="left" ><?php echo $sn; ?> </td>


<?php
$i++;
}

?>
</tr>
</table>

<table border="1" width="100%" class='w3-table'>
<tr>

<td width="5%" align="center" ></td>	
<td width="5%" align="center" ></td>
<td width="30%" align="center" >Total</td>
<td width="10%" align="center" ></td> 
<td width="8%" align="center" ></td> 
<td width="15%" align="center" ></td> 
<td width="15%" align="right" ><?php echo $sum_a;?></td> 
<td width="30%" align="center" ></td> 
	
</tr>

</table>
	
	<table border="1" width="100%">
		<tr>
			<td style="width:35%;">
<?php if ($clear_brn =='1'){ ?>
<input type="checkbox" checked><span >Clear ใบยืมติดเล่มเลขที่</span> <?php echo $brn_no; ?><hr color="black"  width="90%" size="0.1" align="rigth">
<?php }else{ ?>
<input type="checkbox"><span >Clear ใบยืมติดเล่มเลขที่</span>
<?php } ?>	
			</td>
		
	<td style="width:35%;">
<?php if ($clear_brnp =='1'){ ?>
<input type="checkbox" checked><span >Clear ใบยืมกระดาษต่อเนื่องเลขที่</span> <?php echo $brnp_no; ?><hr color="black"  width="90%" size="0.1" align="rigth">
<?php }else{ ?>
<input type="checkbox"><span >Clear ใบยืมกระดาษต่อเนื่องเลขที่</span>
<?php } ?>	
			</td>		
	
	<td style="width:35%;">
<?php if ($clear_epe =='1'){ ?>
<input type="checkbox" checked><span >ของเสียส่งไปต่างประเทศตาม EPE</span> <?php echo $epe_no; ?><hr color="black"  width="90%" size="0.1" align="rigth">
<?php }else{ ?>
<input type="checkbox"><span >ของเสียส่งไปต่างประเทศตาม EPE</span>
<?php } ?>	
			</td>				
			
			
			</tr>
		
		</table>
	
<fieldset>
	
<table width="100%">
		<tr>
			<td style="width:50%;">
<?php if ($pro_ckk =='1'){ ?>
<input type="checkbox" checked><span >อะไหล่คืนใช้งานไม่ได้</span>
<?php }else{ ?>
<input type="checkbox"><span >อะไหล่คืนใช้งานไม่ได้</span>
<?php } ?>	
			</td>
		
	<td style="width:50%;">
<?php if ($pro_ckk =='2'){ ?>
<input type="checkbox" checked><span >อะไหล่คืนใช้งานได้ แต่สภาพไม่สมบูรณ์ (โปรดกรอกรายละเอียด)</span>
<?php }else{ ?>
<input type="checkbox"><span >อะไหล่คืนใช้งานได้ แต่สภาพไม่สมบูรณ์ (โปรดกรอกรายละเอียด)</span>
<?php } ?>	
			</td>	
			</tr>
	</table>
	<table width="100%">
		<tr>
			<td style="width:10%;">อาการเสีย : </td>
			<td style="width:90%;"><?php echo $pro_des; ?><hr color="black"  width="100%" size="0.1" align="rigth"></td>	
				</tr>
	</table>
	
	
	<table width="100%">
		<tr>
			<td style="width:50%;" align="center">
<?php echo $engineer; echo "/"; echo $engineer_date; ?><hr color="black"  width="50%" size="0.1" align="center">Engineer/Date
			</td>
		
	<td style="width:50%;" align="center">
<?php echo $sup_name; echo "/"; echo $sup_date; ?><hr color="black"  width="50%" size="0.1" align="center">Supervisor/Date
			</td>	
			</tr>
	</table>
	
	
	

</fieldset>
	<fieldset>
		
	<table width="100%">
		<tr>
			<td style="width:10%;">Comment : </td>
			<td style="width:90%;"><?php echo $comment_cm; ?><hr color="black"  width="100%" size="0.1" align="rigth"></td>	
				</tr>
	</table>	
		
	<table width="100%">
		<tr>
			<td style="width:50%;" align="left">
<?php if ($status_doc =='Approve'){ ?>
<input type="checkbox" checked><span >YES</span>&nbsp;&nbsp;
<input type="checkbox"><span >NO</span>				
<?php }else if($status_doc =='Rejected'){ ?>
<input type="checkbox" ><span >YES</span>&nbsp;&nbsp;
<input type="checkbox" checked><span >NO</span>	
<?php }else{ ?>	
<input type="checkbox" ><span >YES</span>&nbsp;&nbsp;
<input type="checkbox" ><span >NO</span>					
	<?php } ?>			
			</td>
		
	<td style="width:50%;" align="center">
<?php echo $cm_name; echo "/";  echo $cm_date;  ?><hr color="black"  width="50%" size="0.1" align="center">Supervisor/Date
			</td>	
			</tr>
	</table>	
		
	
	</fieldset>
		<?php

$qfirst = "select * from st__signature where ref_id = '".$ref_id."'";
$first = mysqli_query($new,$qfirst);
$ffirst = mysqli_fetch_array($first);

$qfirst1 = "select name,surname from tb_user where em_id = '".$ffirst["en_code"]."'";
$first1 = mysqli_query($conn,$qfirst1);
$ffirst1 = mysqli_fetch_array($first1);

$qfirst2 = "select name,surname from tb_user where em_id = '".$ffirst["cs_code"]."'";
$first2 = mysqli_query($conn,$qfirst2);
$ffirst2 = mysqli_fetch_array($first2);

	?>

	
		<table width="100%" border="1">
		<tr>
			<td style="width:25%;" align="center">
ผู้รับเอกสาร (Stock) <br><br><u><?php echo "("; echo $objResult["stock_print"]; echo ")";  ?></u><br>
				<u><?php  echo Datethai($ffirst["stock_d"]);   ?></u><br>
<input type="checkbox" ><span >ได้รับอะไหล่ครบถ้วน</span>					
		
			</td>
		
	<td style="width:25%;" align="center">
ผู้รับสินค้า (ช่าง) <br><br><?php if($ffirst["cs_name"]!=''){ ?>
		<img src="data:<?php echo $ffirst["cs_name"];?>" width="80" align="center" height="25" />
		<?php } ?><hr color="black"  width="50%" size="0.1" align="center"><?php echo "("; ?>  <?php echo $ffirst2["name"]; ?> <?php echo $ffirst2["surname"]; ?>  <?php echo ")";  ?><br><u><?php echo Datethai($ffirst["cs_dt"]); ?></u><br>
<input type="checkbox" ><span >ได้รับอะไหล่ครบถ้วน</span>			
			</td>
			
			<td style="width:25%;" align="center">
			ผู้จ่ายสินค้า (Stock) <br><br><u><?php echo "("; echo $ffirst["st_name"]; echo ")";  ?></u><br>
				<u><?php  echo Datethai($ffirst["stock_d"]);   ?></u><br>	
				</td>
				
				<td style="width:25%;" align="left">
					<input type="checkbox" ><span >จากคลังสินค้าชำรุด</span><br>
					<input type="checkbox" ><span >เข้า Stock ชำรุด</span><br>
					<input type="checkbox" ><span >ทำลาย</span>
					
					</td>
			</tr>
	</table>	
	
	<table width="100%" >
		<tr>
			<td style="width:10%;" align="left">คำแนะนำ : </td>
	<td style="width:90%;" align="left">กรณีที่เบิกอะไหล่ประเภท 1.สินค้าชำรุดแรกเข้า 2.ใช้ในการแลกเปลี่ยนเครื่อง และอะไหล่ที่ไม่สมบูรณ์ ที่อยู่ในระยรับประกัน<br>
			จะต้องเขียนใบ Product Error Report ก่อนเขียนเอกสารฉบับนี้ทุกครั้ง
			
			</td>
			</tr>
		</table>
<br><br>
