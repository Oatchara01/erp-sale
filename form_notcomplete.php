<style>
		body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font: 12pt "Angsana New";
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
<?php error_reporting(~E_NOTICE);
include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorHTML.php";
include "src/BarcodeGeneratorPNG.php";

function barcode($code){
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $border = 1.5;//กำหนดความหน้าของเส้น Barcode
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
$strSQL = "SELECT * from no__complete WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM (no__subcomplete LEFT JOIN tb_product ON no__subcomplete.product_id=tb_product.product_ID) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$ref_id = $objResult['ref_id'];
$date_create = Datethai($objResult['date_create']);
$customer = $objResult['customer'];
$iv_no = $objResult['iv_no'];
$bad_condition = $objResult['bad_condition'];
$add_by = $objResult['add_by'];
$add_date = Datethai($objResult['add_date']);
$editor = $objResult['editor'];
$editor_name = $objResult['editor_name'];
if($objResult['date_editor']=='0000-00-00 00:00:00'){
$date_editor='-';
}else{
$date_editor = Datethai($objResult['date_editor']);
}
$dept_en = $objResult['dept_en'];
$dept_st = $objResult['dept_st'];
$dept_cs = $objResult['dept_cs'];
$dept_ma = $objResult['dept_ma'];
$dept_in = $objResult['dept_in'];
$dept_sale = $objResult['dept_sale'];
$description = $objResult['description'];
$sup_name = $objResult['sup_name'];
if($objResult['sup_date']=='0000-00-00 00:00:00'){
	$sup_date='-';
}else{
$sup_date = Datethai($objResult['sup_date']);
}
$per = $objResult['per'];
$per_no = $objResult['per_no'];
$smp = $objResult['smp'];
$smp_no = $objResult['smp_no'];
$spr = $objResult['spr'];
$spr_no = $objResult['spr_no'];
$chang = $objResult['chang'];
$chang_no = $objResult['chang_no'];
$par = $objResult['par'];
$par_no = $objResult['par_no'];
$car = $objResult['car'];
$car_no = $objResult['car_no'];
$sol_name = $objResult1["sol_name"];
$sn = $objResult1["sn"];
$type_product = $objResult["type_product"];

?>
<div class="Section2 page">
<body>

<table style="width:100%;">
	<tr>
				<td style="width:40%;text-align:center;"><b><font size="5">ใบแจ้งสินค้าไม่สมบูรณ์</font><br><font size="5">(Incomplet Delivery Form)</font><b></td>

	</tr>
</table>
	
	<table style="width:100%;">
	<tr>
		<td style="width:30%;text-align:right;"><span align="right"><div align="right"><?php echo "เลขที่ : ";?>  <?php echo $ref_id;?> <br><?php echo "วันที่ : ";?>  <?php echo $date_create;?> </div></span></td>
	</tr>
</table>

</p><fieldset></p>
	
	<table style="width:100%;">
	<tr>
		<td style="width:100%;text-align:left;">
	<b>ชื่อสินค้า : </b> <?php echo $sol_name; ?> <?php if($type_product=='2'){ ?> <input type ='checkbox' checked ='checked'> <?php }else{ ?><input type ='checkbox' > <?php } ?> สินค้าสาธิต <?php if($type_product=='1'){ ?> <input type ='checkbox' checked ='checked'> <?php }else{ ?><input type ='checkbox' > <?php } ?> สินค้าขาย      <b>SN : </b>  <?php echo $sn; ?> <br>
	<b>ชื่อลูกค้า :   </b> <?php echo $customer; ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>เลขที่ IV : </b> <?php echo $iv_no; ?><br>
	<b>อาการเสีย : </b><br>
	 <?php echo $bad_condition; ?> <br>
			</td>
		</tr>
</table>
	<table style="width:100%;">
	<tr>
		<td style="width:30%;text-align:right;"><span align="right"><div align="right"><b><?php echo "ชื่อผู้พบ : ";?> </b> <?php echo $add_by;?> <br><b><?php echo "วันที่ : ";?> </b> <?php echo $add_date;?> </div></span></td>
	</tr>
</table>
	
</fieldset>	<fieldset></p>
	<table style="width:100%;">
	<tr>
		<td style="width:100%;text-align:left;">
	<b>การแก้ไข : </b><br>
	 <?php echo $editor; ?> <br>
			</td>
		</tr>
</table>
	<table style="width:100%;">
	<tr>
		<td style="width:30%;text-align:right;"><span align="right"><div align="right"><b><?php echo "ชื่อผู้แก้ไข : ";?> </b> <?php echo $editor_name;?> <br><b><?php echo "วันที่ : ";?> </b> <?php echo $date_editor;?> </div></span></td>
	</tr>
</table>
	<br>
	<table style="width:100%;">
	<tr>
		<td style="width:100%;text-align:left;">
			<b>การประเมิน สาเหตุเกิดจาก : </b><br>
	<?php if($dept_en=='1'){ ?>	<input type ='checkbox' checked ='checked'> แผนกวิศวกรรม <?php }else{ ?> <input type ='checkbox' > แผนกวิศวกรรม	<?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			<?php if($dept_in=='1'){ ?>	<input type ='checkbox' checked ='checked'> ผู้ผลิตต่างประเทศ <?php }else{ ?> <input type ='checkbox' > ผู้ผลิตต่างประเทศ	<?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			<?php if($dept_ma=='1'){ ?>	<input type ='checkbox' checked ='checked'> แผนกการตลาด <?php }else{ ?> <input type ='checkbox' > แผนกการตลาด	<?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			<?php if($dept_st=='1'){ ?>	<input type ='checkbox' checked ='checked'> แผนกคลังสินค้า <?php }else{ ?> <input type ='checkbox' > แผนกคลังสินค้า	<?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			<?php if($dept_cs=='1'){ ?>	<input type ='checkbox' checked ='checked'> แผนกจัดส่ง <?php }else{ ?> <input type ='checkbox' > แผนกจัดส่ง	<?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			<?php if($dept_sale=='1'){ ?>	<input type ='checkbox' checked ='checked'> ฝ่ายขาย <?php }else{ ?> <input type ='checkbox' > ฝ่ายขาย	<?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			
				</td>
		</tr>
</table>
	</fieldset>	<fieldset></p>
		
		<table style="width:100%;">
	<tr>
		<td style="width:100%;text-align:left;">
	<b>สาเหตุที่สินค้าชำรุด : </b><br>
	 <?php echo $description; ?> <br>
			</td>
		</tr>
</table><br>
	<table style="width:100%;">
	<tr>
		<td style="width:30%;text-align:right;"><span align="right"><div align="right"><b><?php echo "หัวหน้าแผนก : ";?> </b> <?php echo $sup_name;?> <br><b><?php echo "วันที่ : ";?> </b> <?php echo $sup_date;?> </div></span></td>
	</tr>
</table><br>
<table style="width:100%;">
	<tr>
		<td style="width:30%;text-align:left;">
	<b>ข้อสรุป : </b><br>
	<?php if($per=='1'){ ?>	<input type ='checkbox' checked ='checked'> PER  <b> <?php echo $per_no;?> </b><?php }else{ ?> <input type ='checkbox' > PER	<?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			<?php if($car=='1'){ ?>	<input type ='checkbox' checked ='checked'> CAR   <b><?php echo $car_no;?> </b><?php }else{ ?> <input type ='checkbox' > CAR	<?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			<?php if($par=='1'){ ?>	<input type ='checkbox' checked ='checked'> PAR   <b><?php echo $par_no;?> </b><?php }else{ ?> <input type ='checkbox' > PAR	<?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<?php if($smp=='1'){ ?>	<input type ='checkbox' checked ='checked'> SMP   <b><?php echo $smp_no;?> </b><?php }else{ ?> <input type ='checkbox' > SMP	<?php } ?><br>
<?php if($spr=='1'){ ?>	<input type ='checkbox' checked ='checked'> SPR  <b> <?php echo $spr_no;?> </b><?php }else{ ?> <input type ='checkbox' > SPR	<?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			<?php if($chang=='1'){ ?>	<input type ='checkbox' checked ='checked'> ใบแลกเปลี่ยนสินค้า   <b> <?php echo $chang_no;?> </b><?php }else{ ?> <input type ='checkbox' > ใบแลกเปลี่ยนสินค้า	<?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		</td>
		</tr>
</table>	
	</fieldset>

	
<table style="width:100%;" class="tablel">
	<tr>
		<td>
			<span >อนุมัติวันที่ 16 ธันวาคม 2562 </span>
		</td>
		<td style="text-align:right;">
			<span >FM-CS-04:Rev.4<!--080563:Rev.10--></span>
		</td>
	</tr>
</table>

</body>
</div>
</html>