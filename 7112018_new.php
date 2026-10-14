<?php
// ต้อง login ก่อน (เปิดจากเมนู Preview > รายละเอียดจัดส่ง ใน register_suphos.php)
session_start();
if (empty($_SESSION['UserID'])) {
	header('Location: index.php');
	exit;
}
?>
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
	}
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;
			margin: 0;
        }
		div.divFooter {
			position: fixed;
			bottom: 0;
		}
    }
	h1,h2,h3,h4,h5,h6 {
		font: 18pt "Angsana New";
	}
</style>



<?php

define('FPDF_FONTPATH','font/');
// ใช้ไฟล์เชื่อมต่อของระบบแทนการ hardcode user/password
include "dbconnect.php";      // $conn = ฐานข้อมูลขาย (hos__so, tb_other_bill, tb_document ...)
$sol = $conn;
include "dbconnect_cs.php";   // $com1 = สมุดลงงาน CS (tb_register_data, tb_transaction)
include "dbconnect_acc.php";  // $code = invoice_receipt
$conn  = $com1;
$conn2 = $code;

// ลิงก์เดิมบางหน้าส่งมาเป็น ?job_no= แทน ?running=
// Preview จาก register_suphos.php ส่งมาแบบ POST
$running_raw = trim($_POST["running"] ?? ($_GET["running"] ?? ($_GET["job_no"] ?? '')));
$running = mysqli_real_escape_string($conn, $running_raw);

// ดึง 1 แถว ถ้าไม่พบข้อมูลให้คืนแถวว่าง (ทุกคอลัมน์ = '') แทน null
// เพื่อไม่ให้เกิด Warning "Trying to access array offset on null"
function fetch_row_or_blank($query)
{
	$row = mysqli_fetch_array($query);
	if ($row) {
		return $row;
	}
	$blank = array();
	foreach (mysqli_fetch_fields($query) as $i => $field) {
		$blank[$i] = '';
		$blank[$field->name] = '';
	}
	return $blank;
}

// escape ค่าก่อนแสดงผลใน HTML
function h($value)
{
	return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$strSQL = "SELECT * FROM tb_register_data WHERE running = '".$running."' ";
$objQuery = mysqli_query($conn,$strSQL)or die ("Error Query [".$strSQL."]");
// ไม่พบใบงาน -> แสดงฟอร์มเปล่า (เหมือนพฤติกรรมเดิม)
$objResult = fetch_row_or_blank($objQuery);

$strSQL1 = "SELECT * FROM tb_transaction WHERE running = '".$running."' ";
$objQuery1 = mysqli_query($conn,$strSQL1)or die ("Error Query [".$strSQL1."]");
$objResult1 = fetch_row_or_blank($objQuery1);

$ref_id_esc = mysqli_real_escape_string($sol, $objResult["ref_id"]);

$strSQL2 = "SELECT bill_id,bill_name FROM hos__so WHERE ref_id = '".$ref_id_esc."' ";
//echo $strSQL2;
$objQuery2 = mysqli_query($sol,$strSQL2)or die ("Error Query [".$strSQL2."]");
$objResult2 = fetch_row_or_blank($objQuery2);

$strSQL4 = "SELECT ref_12,ref_13 FROM tb_other_bill WHERE ref_id = '".$ref_id_esc."' ";
$objQuery4 = mysqli_query($sol,$strSQL4)or die ("Error Query [".$strSQL4."]");
$objResult4 = fetch_row_or_blank($objQuery4);


$strSQL13 = "SELECT * FROM tb_document WHERE id_customer_run = '".mysqli_real_escape_string($sol, $objResult2["bill_id"])."' ";
$objQuery13 = mysqli_query($sol,$strSQL13)or die ("Error Query [".$strSQL13."]");
$objResult13 = fetch_row_or_blank($objQuery13);



$strSQL3 = "SELECT * FROM tb_document_all WHERE ref_idd = '".mysqli_real_escape_string($sol, $objResult13["ref_id"])."' ";
$objQuery3 = mysqli_query($sol,$strSQL3)or die ("Error Query [".$strSQL3."]");
$objResult3 = fetch_row_or_blank($objQuery3);


date_default_timezone_set("Asia/Bangkok");
function DateThai($strDate)
	{
		if (empty($strDate) || $strDate == '0000-00-00') {
			return '';
		}
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}


$start_date=DateThai($objResult["start_date"]);
$bill_name = $objResult2["bill_name"];
//$newDate = date("d-m-Y", strtotime($start_date));
$between_date=$objResult["between_date"];
$status =$objResult["status"];
$start_time =$objResult["start_time"];
$end_time=$objResult["end_time"];
$department=$objResult["department"];
$customer_name=$objResult["customer_name"];
$employee_name=$objResult["employee_name"];
$type_company=$objResult["type_company"];
$type_customer =$objResult["type_customer"];
$ref_id = $objResult["ref_id"];
$customer_tel =$objResult["customer_tel"];
$province_name=$objResult["province_name"];
$employee_tel =$objResult["employee_tel"];
$add_by =$objResult["add_by"];
$want_bus =$objResult["want_bus"];
$address_send =$objResult["address_send"];
$customer_contact =$objResult["customer_contact"];
$description =$objResult["description"];
$have_map =$objResult["have_map"];
$add_date =$objResult["add_date"];
$newadd_date = ($add_date != '' && $add_date != '0000-00-00 00:00:00') ? date("d-m-Y H:i:s", strtotime($add_date)) : '';
$upload_name  =$objResult["upload_name"];

$product_sn =$objResult["product_sn"];
$product_name=$objResult["product_name"];
// Preview: ใช้ช่อง "สินค้า/เอกสาร" ที่ยังไม่บันทึก ว่างไว้ = ข้อความที่ระบบจะสร้างจากรายการสินค้า (ไม่เขียนฐาน)
// doc_type บอกชนิดเอกสารที่เปิด Preview: rental = register_suprental.php, ไม่ส่งมา = SO (register_suphos.php)
if (($_POST["_report_preview"] ?? '') === '1') {
	$product_name = trim((string)($_POST["product"] ?? ''));
	if (($_POST["doc_type"] ?? '') === 'rental') {
		require_once __DIR__ . '/includes/rental_cs_send.php';
		$product_name = rental_product_note_display($product_name);
	}
	if ($product_name === '' && $ref_id !== '') {
		if (($_POST["doc_type"] ?? '') === 'rental') {
			$rentalDoc = rental_cs_load_document($sol, $ref_id);
			$product_name = ($rentalDoc !== null) ? rental_cs_compose_product_name($rentalDoc) : '';
		} else {
			require_once __DIR__ . '/includes/so_cs_send.php';
			$product_name = so_cs_compose_product_name($sol, $ref_id);
		}
	}
}
$price  =$objResult["price"];
$unit_credit  =$objResult["unit_credit"];
$fix_date=$objResult["fix_date"];
$no_price =$objResult["no_price"];
$call_customer=$objResult["call_customer"];
$credit =$objResult["credit"];
$call_employee =$objResult["call_employee"];
$cash =$objResult["cash"];
$unit_bill  =$objResult["unit_bill"];
$unit_check  =$objResult["unit_check"];
$unit_tran  =$objResult["unit_tran"];
$tran  =$objResult["tran"];

$check_peper  =$objResult["check_peper"];
$bill =$objResult["bill"];
$amphur_name =$objResult["amphur_name"];
$province_name =$objResult["province_name"];
$address_name  =$objResult["address_name"];


$status_comment =$objResult["status_comment"];
$type_word  =$objResult["type_word"];
$employee_send =$objResult["employee_send"];
$time_send =$objResult["time_send"];
$summary_cs   =$objResult["summary_cs"];
$description_cs=$objResult["description_cs"];
$run_long  =$objResult["run_long"];
$summary_sup =$objResult["summary_sup"];
$description_sup  =$objResult["description_sup"];
$dep =$objResult["dep"];
$dept  =$objResult["dept"];

$time="$start_time - $end_time";
$date = date('d-m-Y H:i:s');


$runway  =$objResult1["runway"];
$road  =$objResult1["road"];
$soy  =$objResult1["soy"];
$soy_long  =$objResult1["soy_long"];
$soy_big  =$objResult1["soy_big"];
$car_load  =$objResult1["car_load"];
$car_park  =$objResult1["car_park"];
$car_road  =$objResult1["car_road"];
$no_car_road  =$objResult1["no_car_road"];
$car_home  =$objResult1["car_home"];
$door_long  =$objResult1["door_long"];
$slope  =$objResult1["slope"];
$bundai  =$objResult1["bundai"];
$unit_bundai  =$objResult1["unit_bundai"];
$door_big  =$objResult1["door_big"];
$door_longer  =$objResult1["door_longer"];
$type_door  =$objResult1["type_door"];
$home_type  =$objResult1["home_type"];
$install  =$objResult1["install"];
$bundai_install  =$objResult1["bundai_install"];
$bundai_big  =$objResult1["bundai_big"];
$lip  =$objResult1["lip"];
$lip_big  =$objResult1["lip_big"];
$lip_long  =$objResult1["lip_long"];
$lip_weight  =$objResult1["lip_weight"];
$want_employee  =$objResult1["want_employee"];
$employee_unit  =$objResult1["employee_unit"];
$ferniger_address  =$objResult1["ferniger_address"];
$ferniger_name  =$objResult1["ferniger_name"];
$want_ex  =$objResult1["want_ex"];
$want_credit  =$objResult1["want_credit"];
$want_prem  =$objResult1["want_prem"];

$room_bigger  =$objResult1["room_bigger"];
$room_longer  =$objResult1["room_longer"];
$bundai_hug  =$objResult1["bundai_hug"];
$bank  =$objResult1["bank"];

$description_tran=$objResult1["description"];
$type_bundai =$objResult1["type_bundai"];
$head_bad=$objResult1["head_bad"];
$up=$objResult1["up"];
$no_up=$objResult1["no_up"];
$height_ltd=$objResult1["height_ltd"];

$ref_12 = $ref_13 = $ref_14 = '';
if($objResult4["ref_12"]=='1'){
$ref_12 = "ส่งสินค้าด้วยใบรับสินค้า [ไม่ระบุราคา]";	
}
if($objResult4["ref_13"]=='1'){
$ref_13 = "ไม่ต้องนำใบกำกับภาษี/ใบเสร็จ";	
$ref_14 = "ไปส่งสินค้า";
}

// escape ค่าที่มาจากฐานข้อมูลก่อนแสดงผล (query ข้างบนใช้ค่าดิบไปหมดแล้ว)
$running_display = h($running_raw);
$map_link = h($objResult["map_link"]);
foreach (array(
	'start_date', 'bill_name', 'between_date', 'time', 'department', 'customer_name',
	'employee_name', 'ref_id', 'customer_tel', 'province_name', 'employee_tel', 'add_by',
	'address_send', 'customer_contact', 'description', 'newadd_date', 'product_sn',
	'product_name', 'price', 'unit_credit', 'unit_bill', 'unit_check', 'unit_tran',
	'address_name', 'status_comment', 'dept',
	'soy_long', 'car_park', 'door_long', 'unit_bundai', 'door_big', 'door_longer',
	'type_door', 'home_type', 'install', 'room_bigger', 'room_longer', 'type_bundai',
	'bundai_big', 'bundai_hug', 'lip_big', 'lip_long', 'lip_weight', 'employee_unit',
	'ferniger_name', 'ferniger_address', 'bank', 'description_tran',
) as $varName) {
	$$varName = h($$varName);
}

?>
<html>
<div class="Section2 page">
<body>
<table style="width:100%;">
	<tr>
		<td style="width:45%;"><span></span></td>
		<td align="right" style="width:40%;"><b><font color='red'><?php echo $ref_12; ?><br><?php echo $ref_13; echo $ref_14; ?></font></b></td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
<td style="width:40%;text-align:center;"><b><font size="5">ใบแจ้งรายละเอียดการจัดส่งสินค้า</font><br><font size="4">(Delivery Information)</font></b></td>
		</tr>
</table>
<table style="width:100%;" border="0">
	<tr>
		<td style="width:15%;">
			<span>ชื่อที่ต้องการออกบิล :</span>
		</td>
		<td style="border-bottom: 1px solid black;width:50%;">
			<font color='blue'><span><?php echo $bill_name; ?></span></font>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>ID NO.</span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<font color='blue'><span><?php echo $running_display; ?></span></font>
		</td>
	</tr>
	
</table>

<table style="width:100%;" border="0">
	<tr>
		<td style="width:15%;">
			<span>ชื่อผู้ติดต่อ :</span>
		</td>
		<td style="border-bottom: 1px solid black;width:20%;">
			<font color='blue'><span><?php echo $customer_name; ?></span></font>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>ผู้รับสินค้า :</span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<font color='blue'><span><?php echo $customer_contact; ?></span></font>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>วันที่ :</span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<font color='blue'><span><?php echo $start_date; ?></span></font>
		</td>
	</tr>
	
	
</table>
<table style="width:100%;" border="0">
	<tr>
		<td style="width:15%;">
			<span>เบอร์โทร :</span>
		</td>
		<td style="border-bottom: 1px solid black;width:50%;">
			<font color='blue'><span><?php echo $customer_tel; ?></span></font>
		</td>
		<td style="width:10%;">
		
		</td><td style="width:20%;">
			
		</td>
	</tr>	
</table>		

<table style="width:100%;" border="0">
	<tr>
		<td style="width:15%;">
			<span>สถานที่จัดส่ง/เขต/รพ. :</span>
		</td>
		<td style="border-bottom: 1px solid black;width:45%;">
			<font color='blue'><span><?php echo $address_name; ?></span></font>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>วันที่ประมาณ</span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<font color='blue'><span><?php echo $between_date; ?></span></font>
		</td>
	</tr>
	</table>


<table style="width:100%;" border="0">
		<tr>
		<td style="width:15%;">
			<span>จังหวัด: </span>
		</td>
		<td style="border-bottom: 1px solid black;width:50%;">
			<font color='blue'><span><?php echo $province_name; ?></span></font>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>เวลา:</span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<font color='blue'><span><?php echo $time; ?></span></font>
		</td>
	</tr>
	
		<tr>
		<td style="width:15%;">
			<span>แผนก/ที่อยู่ :</span>
		</td>
		<td style="border-bottom: 1px solid black;width:50%;">
			<font color='blue'><span><?php echo $address_send; ?></span></font>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>สถานะ:</span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<font color='blue'><span><?php echo $status_comment; ?></span></font>
		</td>
	</tr>
	
	
		<tr>
		<td style="width:15%;">
			<span>ข้อมูลเพิ่มเติม :</span>
		</td>
		<td style="border-bottom: 1px solid black;width:50%;">
			<font color='blue'><span><?php echo $description; ?></span></font>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>แผนก:</span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<font color='blue'><span><?php echo $department; ?></span></font>
		</td>
	</tr>
	
</table>

<table style="width:100%;" border="0">
	<tr>
		<td style="width:10%;">
			<span>ชื่อพนักงาน :</span>
		</td>
		<td style="border-bottom: 1px solid black;width:20%;">
			<font color='blue'><span><?php echo $employee_name; ?></span></font>
		</td>
		<td style="width:10%;text-align:left;padding-left:15px;">
			<span>เบอร์โทร :</span>
		</td>
		<td  style="border-bottom: 1px solid black;width:20%;">
			<font color='blue'><span><?php echo $employee_tel; ?></span></font>
		</td>
		<td style="width:20%;text-align:left;padding-left:15px;">
			<?php if($want_bus=="1"){ ?><input type='checkbox' style="width:25px; height:25px;" checked='checked'><b><font color='blue' style="font-size:28px;">ต้องการรถใหญ่</font></b>
			<?php }else{ ?>
			<input type='checkbox'> ต้องการรถใหญ่
			<?php } ?>

		</td>
	</tr>
	
	
</table>
	
	
	

<table style="width:100%;" border="0">
	<tr>
		<td style="width:100%;">
		
		<?php if($status=="ส่ง"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'> ส่ง</font></b>
			<input type='checkbox' ><b> รับ</b>
			<?php }else if($status=="รับ"){ ?>
			<input type='checkbox'><b> ส่ง</b>
			<input type='checkbox' checked='checked' ><b><font color='blue'> รับ</font></b>
			<?php }else{ ?>
			<input type='checkbox'><b>ส่ง</b>
			<input type='checkbox'><b> รับ</b>
			<?php } ?>
		
		</td>	
	</tr>	
</table>
	
		
	
<table style="width:100%;" border="0">
	<tr>
		<td style="width:15%;">
			<span>อ้างอิงเอกสาร :</span>
		</td>
		<td style="border-bottom: 1px solid black;width:30%;">
			<font color='blue'><span><?php echo $product_sn; if($ref_id !=''){ echo " เลขที่อ้างอิง "; echo  $ref_id; } ?></span></font>
		</td>
		<td style="width:15%;text-align:left;padding-left:15px;">
			<span>รายละเอียดงาน :</span>
		</td>
		<td  style="border-bottom: 1px solid black;width:40%;">
			<font color='blue'><span><?php echo $product_name; ?></span></font>
		</td>
	</tr>
	</table>	
	
<fieldset><legend><b><font color ='green' style="font-size:20px;">รายละเอียดการเก็บเงิน</font></b></legend>
	
	
<table style="width:100%;" border="0">
	<tr>
		<td style="width:30%;">
		
		<?php if($no_price=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>ไม่ต้องเก็บเงิน</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>ไม่ต้องเก็บเงิน</b>
			<?php } ?>
		</td>
		
		<td style="width:30%;">
		
		<?php if($cash=="1"){ ?>
			<input type='checkbox' style="width:25px; height:25px;" checked='checked'><b><font color='red' style="font-size:28px;">เก็บเงินสด <?php echo $price; ?>  บาท</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>เก็บเงินสด</b>
			<?php } ?>
		</td>
		
		<td style="width:30%;">
		
		<?php if($credit=="1"){ ?>
			<input type='checkbox' style="width:25px; height:25px;" checked='checked'><b><font color='red' style="font-size:28px;">รูดการ์ด <?php echo $unit_credit; ?>  บาท</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>รูดการ์ด</b>
			<?php } ?>
		</td>
	</tr>
	
	
	
	<tr>
		<td style="width:30%;">
		
		<?php if($bill=="1"){ ?>
			<input type='checkbox' style="width:25px; height:25px;" checked='checked'><b><font color='red' style="font-size:28px;">วางบิล <?php echo $unit_bill; ?>  บาท</font></b>
			
			<?php }else{ ?>
			<input type='checkbox' ><b>วางบิล</b>
			<?php } ?>
		</td>
		
		<td style="width:30%;">
		
		<?php if($check_peper=="1"){ ?>
		<input type='checkbox' style="width:25px; height:25px;" checked='checked'><b><font color='red' style="font-size:28px;">รับเช็ค <?php echo $unit_check; ?>  บาท</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>รับเช็ค</b>
			<?php } ?>
		</td>
		
		<td style="width:30%;">
		
		<?php if($tran=="1"){ ?>
		<input type='checkbox' style="width:25px; height:25px;" checked='checked'><b><font color='red' style="font-size:28px;">ลูกค้าโอนเงินหน้างาน <?php echo $unit_tran; ?>  บาท</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>ลูกค้าโอนเงินหน้างาน</b>
			<?php } ?>
		</td>
	</tr>
	
	
	</table>	
	<table style="width:100%;" border="0">
	<tr>
		<td style="width:100%;">
		
		<?php if($dep=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>อื่นๆ : <?php echo $dept; ?></font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>อื่นๆ :</b>
			<?php } ?>
		</td>
		</tr>
	
	
	</table>	

 </fieldset>	
	
<table style="width:100%;" border="0">
	<tr>
		<td style="width:30%;">
		
		<?php if($fix_date=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>นัดวันเวลาเรียบร้อยแล้ว (ห้ามเลื่อน)</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>นัดวันเวลาเรียบร้อยแล้ว (ห้ามเลื่อน)</b>
			<?php } ?>
		</td>
		
		<td style="width:30%;">
		
		<?php if($call_employee=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>ติดต่อกลับเจ้าของงานเมื่องานเรียบร้อย</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>ติดต่อกลับเจ้าของงานเมื่องานเรียบร้อย</b>
			<?php } ?>
		</td>
		
		<td style="width:30%;">
		
		<?php if($call_customer=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>โทรแจ้งลูกค้าก่อนไป</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>โทรแจ้งลูกค้าก่อนไป</b>
			<?php } ?>
		</td>
	</tr>	
</table>	

<table style="width:100%;" border="0">
	<tr>
	<td style="width:20%;">
			<?php if($map_link!=''){ ?><span><b><font color='blue'>ลิงค์แผนที่ :</font></b></span><?php }else{ ?><span><b>ลิงค์แผนที่ :</b></span><?php } ?>
		</td>
		<td>
			<?php if($map_link!=''){ ?><font color='blue'><a href="<?php echo $map_link; ?>" target="_blank"><span class="style40">Map แผนที่บ้านลูกค้า</span></a>	</font><?php } ?>
		</td>
		</tr>
	
	
	</table>		
	
<br>
<table style="width:100%;" border="0">
	<tr>
		<td style="width:70%; text-align:left; font-size:16px;">เวลาลงงาน: <?php echo $newadd_date; echo " $add_by"; ?></td>
		<td style="width:30%; text-align:right; font-size:16px;">เวลา Print: <?php echo $date; ?></td>
	</tr>	
	
	
	<tr>
	<td style="width:70%; text-align:left; font-size:16px;">อนุมัติวันที่ 29 พ.ย. 2565</td>
    <td style="width:30%; text-align:right; font-size:16px;">FM-SA-05 : Rev.2</td>
	</tr>		
</table>	
	
	
	
<?php if($objResult["check_detail"]=='1'){ ?>	
<br><br><br>	
<table style="width:100%;">
	<tr>
<td style="width:40%;text-align:center;"><b><font size="5">รายละเอียดการจัดส่งเพิ่มเติม</font></b></td>
		</tr>
</table>	
<br>	
<table style="width:100%;" border="0">
	<tr>
		<td style="width:30%;">
		
		<?php if($runway=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>ติดถนนรันเวย์</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>ติดถนนรันเวย์</b>
			<?php } ?>
		</td>
		
		<td style="width:30%;">
		
		<?php if($road=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>ติดถนนวิ่งสวนกัน</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>ติดถนนวิ่งสวนกัน</b>
			<?php } ?>
		</td>
		
		<td style="width:30%;">
		
		<?php if($soy=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>เข้าซอย</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>เข้าซอย</b>
			<?php } ?>
		</td>
	</tr>
	
	
		<tr>
		<td style="width:30%;">
		
		ทางเข้า กว้าง : <font color='blue'><?php echo $soy_long; ?></font> เมตร
		</td>
		
		<td style="width:30%;">
		
		<?php if($height_ltd=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>มีตัวจำกัดความสูง</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>มีตัวจำกัดความสูง</b>
			<?php } ?>
		</td>
		
		<td style="width:30%;">
		
		<?php if($car_load=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>รถยนต์เข้าได้</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>รถยนต์เข้าได้</b>
			<?php } ?>
		</td>
	</tr>
	
	<tr>
		<td style="width:30%;">
		
		<?php if($no_car_road=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>รถยนต์เข้าไม่ได้</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>รถยนต์เข้าไม่ได้</b>
			<?php } ?>
		</td>
		
		<td style="width:30%;">
		สามารถจอดได้ที่ : <font color='blue'><?php echo $car_park; ?></font>
		</td>
		
		<td style="width:30%;">
		
		<?php if($car_road=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>จอดรถข้างถนน</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>จอดรถข้างถนน</b>
			<?php } ?>
		</td>
	</tr>	
	
	
	<tr>
		<td style="width:30%;">
		
		<?php if($car_home=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>จอดรถหน้าบ้านได้</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>จอดรถหน้าบ้านได้</b>
			<?php } ?>
		</td>
		
		<td style="width:30%;">
		ประตูหน้าบ้านสูง : <font color='blue'><?php echo $door_long; ?></font> เมตร
		</td>
		
		<td style="width:30%;">
		
		<?php if($slope=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>มีทางราบก่อนประตูบ้าน</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>มีทางราบก่อนประตูบ้าน</b>
			<?php } ?>
		</td>
	</tr>	
	
		
	<tr>
		<td style="width:30%;">
		
		<?php if($bundai=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>มีบันไดก่อนประตูบ้าน</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>มีบันไดก่อนประตูบ้าน</b>
			<?php } ?>
		</td>
		
		<td style="width:30%;">
		จำนวน : <font color='blue'><?php echo $unit_bundai; ?></font> ขั้น
		</td>
		
		<td style="width:30%;">
		ประตูบ้านกว้าง : <font color='blue'><?php echo $door_big; ?></font> เมตร
		</td>
	</tr>	
	
		
	<tr>
		
		<td style="width:30%;">
		สูง : <font color='blue'><?php echo $door_longer; ?></font> ขั้น
		</td>
		
		<td style="width:30%;">
		ประตูบ้านเป็นแบบ : <font color='blue'><?php echo $type_door; ?></font>
		</td>
		
	<td style="width:30%;">
		พื้นบ้านเป็นแบบ : <font color='blue'><?php echo $home_type; ?></font>
		</td>
		</tr>	
	
		
	<tr>
		
		<td style="width:30%;">
		ติดตั้งที่ชั้น : <font color='blue'><?php echo $install; ?></font> 
		</td>
		
		<td style="width:30%;">
		ประตูห้องกว้าง : <font color='blue'><?php echo $room_bigger; ?></font> เมตร
		</td>
		
	<td style="width:30%;">
		ชนิดบันได : <font color='blue'><?php echo $type_bundai; ?></font>
		</td>
		</tr>	
	
		<tr>
		
		<td style="width:30%;">
		สูง : <?php echo $room_longer; ?> เมตร
		</td>
		
		<td style="width:30%;">
		<?php if($bundai_install=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>บันได</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>บันได</b>
			<?php } ?>
		</td>
		
	<td style="width:30%;">
		กว้าง : <font color='blue'><?php echo $bundai_big; ?></font> เมตร
		</td>
		</tr>	
	
	
			<tr>
		
		<td style="width:30%;">
		หักมุมบันได : <font color='blue'><?php echo $bundai_hug; ?></font>
		</td>
		
		<td style="width:30%;">
		<?php if($lip=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>ลิฟท์</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>ลิฟท์</b>
			<?php } ?>
		</td>
		
	<td style="width:30%;">
		กว้าง : <font color='blue'><?php echo $lip_big; ?></font> เมตร
		</td>
		</tr>	
	
				<tr>
		
		<td style="width:30%;">
		สูง : <font color='blue'><?php echo $lip_long; ?></font> เมตร
		</td>
					
		<td style="width:30%;">
		รับน้ำหนักได้ : <font color='blue'><?php echo $lip_weight; ?></font> กิโลกรัม
		</td>
					
		<td style="width:30%;">
		<?php if($want_employee=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์</b>
			<?php } ?>
		</td>
		
	
		</tr>	
	
	
					<tr>
		<td style="width:30%;">
		<?php if($head_bad=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>ต้องถอดหัวเตียง-ท้ายเตียง</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>ต้องถอดหัวเตียง-ท้ายเตียง</b>
			<?php } ?>
		</td>
		
		<td style="width:30%;">
		จำนวน : <font color='blue'><?php echo $employee_unit; ?> </font> คน
		</td>
					
		<td style="width:30%;">
		ย้ายเฟอร์นิเจอร์ : <font color='blue'><?php echo $ferniger_name; ?></font>
		</td>
					
		
	
		</tr>	
	
					<tr>
			
		<td style="width:30%;">
		ย้ายไปที่  : <font color='blue'><?php echo $ferniger_address; ?></font>
		</td>
						
		<td style="width:30%;">
		<?php if($up=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>ขึ้นลิฟท์ได้</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>ขึ้นลิฟท์ได้</b>
			<?php } ?>
		</td>			
		<td style="width:30%;">
		<?php if($no_up=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>ขึ้นลิฟท์ไม่ได้</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>ขึ้นลิฟท์ไม่ได้</b>
			<?php } ?>
		</td>
					
		</tr>	
	
	
					<tr>
						
		<td style="width:30%;">
		<?php if($want_prem=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>ต้องการให้เตรียมพรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>ต้องการให้เตรียมพรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า</b>
			<?php } ?>
		</td>			
		<td style="width:30%;">
		<?php if($want_credit=="1"){ ?>
			<input type='checkbox' checked='checked'><b><font color='blue'>ต้องเตรียมเครื่องรูดบัตร</font></b>
			<?php }else{ ?>
			<input type='checkbox' ><b>ต้องเตรียมเครื่องรูดบัตร</b>
			<?php } ?>
		</td>
			<td style="width:30%;">
		ของธนาคาร : <font color='blue'><?php echo $bank; ?></font>
		</td>		
		</tr>	
	</table>	
	
	
	
<table style="width:100%;">	
			<tr>
		<td style="width:20%;">เพิ่มเติม  :	</td>
		<td  style="border-bottom: 1px solid black;width:70%;">
			<font color='blue'><span><?php echo $description_tran; ?></span></font>
		</td>		
		</tr>	
	</table>		
	<br>	<br>
<?php } ?>	
	
	
<?php if($objResult2["bill_id"]!='' and $objResult3["ref_idd"]!=''){	
	
	
$date_bill = $objResult3["date_bill"];	
$time_bill = $objResult3["time_bill"];	
$add_bill = $objResult3["add_bill"];	
$date_withtax = $objResult3["date_withtax"];	
$add_withtax = $objResult3["add_withtax"];	
$bill_tel = $objResult3["bill_tel"];	
$bill_contact = $objResult3["bill_contact"];	
	
if($objResult3["post_ckk"]=='1'){	
$post_ckk ="ไปรษณีย์ตอบรับ";
}else{
$post_ckk="";	
}
	
if($objResult3["mail_boxckk"]=='1'){	
$mail_boxckk ="พิมพ์จดหมาย";
}else{
$mail_boxckk="";	
}
	
$email_cus = $objResult3["email_cus"];
	
	
if($objResult3["place_bill"]=='1'){	
$place_bill ="ใบวางบิล";
}else{
$place_bill="";	
}
	
if($objResult3["place_bluebill"]=='1'){	
$place_bluebill ="สำเนาใบวางบิล(สีฟ้า)";
}else{
$place_bluebill="";	
}
	
if($objResult3["invoice_ckk"]=='1'){	
$invoice_ckk ="ขาว";
}else{
$invoice_ckk="";	
}

	
if($objResult3["invoice_ckk1"]=='1'){	
$invoice_ckk1 ="เหลือง";
}else{
$invoice_ckk1="";	
}

	
if($objResult3["invoice_ckkall"]=='1'){	
$invoice_ckkall ="เอกสารทั้งชุด";
}else{
$invoice_ckkall="";	
}
	
	
	
if($objResult3["invoice_ckkn"]=='1'){	
$invoice_ckkn ="ชมพู";
}else{
$invoice_ckkn="";	
}

	
if($objResult3["invoice_ckkn1"]=='1'){	
$invoice_ckkn1 ="ม่วง";
}else{
$invoice_ckkn1="";	
}

	
if($objResult3["invoice_ckknall"]=='1'){	
$invoice_ckknall ="เอกสารทั้งชุด";
}else{
$invoice_ckknall="";	
}
	
if($invoice_ckk!='' or $invoice_ckk1!='' or $invoice_ckkall!='' or $invoice_ckkn!='' or $invoice_ckkn1!='' or $invoice_ckknall!=''){	
	
$sum_inv ="ใบกำกับภาษี/ใบส่งสินค้า ออลล์เวล ไลฟ์ : $invoice_ckk $invoice_ckk1 $invoice_ckkall";		
$sum_invn ="ใบกำกับภาษี/ใบส่งสินค้า โนเบิล เมด : $invoice_ckkn $invoice_ckkn1 $invoice_ckknall";		
	
}else{
	
$sum_inv ="";		
$sum_invn ="";		
	
}
	
	
if($objResult3["po_ckk"]=='1'){	
$po_ckk ="ใบ PO";
}else{
$po_ckk="";	
}
	
if($objResult3["product_ckk"]=='1'){	
$product_ckk ="ใบรับสินค้า";
}else{
$product_ckk="";	
}
	
if($objResult3["bill_ckk"]=='1'){	
$bill_ckk ="ใบเสร็จรับเงิน";
}else{
$bill_ckk="";	
}
	
$tel_wt = $objResult3["tel_wt"];	
	
	
$strSQLbk = "SELECT pay_in FROM tb_bank WHERE id = '".mysqli_real_escape_string($conn2, $objResult3["payment_name"])."' ";
$objQuerybk = mysqli_query($conn2,$strSQLbk)or die ("Error Query [".$strSQLbk."]");
$objResultbk = fetch_row_or_blank($objQuerybk);
	
$pay_in = $objResultbk["pay_in"];
	
$strSQLbk1 = "SELECT pay_in FROM tb_bank WHERE id = '".mysqli_real_escape_string($conn2, $objResult3["payment_name1"])."' ";
$objQuerybk1 = mysqli_query($conn2,$strSQLbk1)or die ("Error Query [".$strSQLbk1."]");
$objResultbk1 = fetch_row_or_blank($objQuerybk1);
	
$pay_in1 = $objResultbk1["pay_in"];	
	
if($objResult3["payment_name"]!='0'){	
$payment_name = "การชำระเงิน AWL $pay_in";	
}else{
$payment_name = "";		
}
	
if($objResult3["payment_name1"]!='0'){	
$payment_name1 = "การชำระเงิน NBM $pay_in1";		
}else{
$payment_name1 = "";		
}
	
if($objResult3["note_ckk"]=='1'){	
$note_ckk ="ไปรษณีย์ตอบรับ";
}else{
$note_ckk="";	
}
	
if($objResult3["note_desckk"]=='1'){	
$note_desckk ="พิมพ์จดหมาย";
}else{
$note_desckk="";	
}
	
$tel_withtax = $objResult3["tel_withtax"];
	
	
if($objResult3["with_ckk"]=='1'){	
$with_ckk ="ใบวางบิล / ใบนัดรับเช็ค";
}else{
$with_ckk="";	
}
	
if($objResult3["withtax_ckk"]=='1'){	
$withtax_ckk ="ใบเสร็จรับเงิน";
}else{
$withtax_ckk="";	
}

	
$strSQLnt = "SELECT note FROM tb_note WHERE id = '".mysqli_real_escape_string($sol, $objResult3["note"])."' ";
$objQuerynt = mysqli_query($sol,$strSQLnt)or die ("Error Query [".$strSQLnt."]");
$objResultnt = fetch_row_or_blank($objQuerynt);

$note = $objResultnt["note"];	
	

	
$strSQLbk2 = "SELECT pay_in FROM tb_bank WHERE id = '".mysqli_real_escape_string($conn2, $objResult3["bank_tran"])."' ";
$objQuerybk2 = mysqli_query($conn2,$strSQLbk2)or die ("Error Query [".$strSQLbk2."]");
$objResultbk2 = fetch_row_or_blank($objQuerybk2);
	
$step_delivery1 = $objResult3["step_delivery1"];	
$date_timdel = $objResult3["date_timdel"];	
$add_del = $objResult3["add_del"];	
$name_condel = $objResult3["name_condel"];	
$remark1 = $objResult3["remark1"];	
$bank_tran = $objResultbk2["pay_in"];		
$doc_del = $objResult3["doc_del"];	
$step_billcs = $objResult3["step_billcs"];
$step_delivery2 = $objResult3["step_delivery2"];
// คอลัมน์จาก 7112018.php เดิม อาจไม่มีในตารางปัจจุบัน -> ค่าว่าง
$count_arkon = $objResult3["count_arkon"] ?? '';
$index_no = $objResult3["index_no"] ?? '';

foreach (array(
	'date_bill', 'time_bill', 'add_bill', 'date_withtax', 'add_withtax', 'bill_tel',
	'bill_contact', 'email_cus', 'payment_name', 'payment_name1', 'tel_withtax', 'note',
	'step_delivery1', 'date_timdel', 'add_del', 'name_condel', 'remark1', 'bank_tran',
	'doc_del', 'step_billcs', 'step_delivery2', 'count_arkon', 'index_no',
) as $varName) {
	$$varName = h($$varName);
}
	
	
	
	?>
<br><br><br>	
<table style="width:100%;">
	<tr>
<td style="width:40%;text-align:center;"><b><font size="5">การรับเช็ค-วางบิล หรือเอกสารที่ใช้ (รพ.)</font></b><br></td>
		</tr>
	<tr>
<td style="width:40%;text-align:left;"><b><u>ข้อมูลการวางบิล</u></b></td>
		</tr>	
</table>
<table style="width:100%;">	
			<tr>
		<td style="width:15%;">วันที่/เวลา วางบิล :	</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $date_bill; echo $time_bill; ?></span></font>
		</td>		
		<td style="width:15%;">สถานที่วางบิล :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $add_bill; ?></span></font>
		</td>				
		</tr>	
	
	
				<tr>
		<td style="width:15%;">เบอร์โทรศัพท์ :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $bill_tel; echo $post_ckk; echo $mail_boxckk; echo $email_cus; ?></span></font>
		</td>		
		<td style="width:15%;">ผู้ติดต่อ :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $bill_contact; ?></span></font>
		</td>				
		</tr>	
	
	
	</table>
	
	
	
	
	<table style="width:100%;">	
			<tr>
		<td style="width:20%;">ขั้นตอนการวางบิล :</td>
		<td  style="border-bottom: 1px solid black;width:80%;">
			<font color='blue'><span><?php echo $step_billcs; ?></span></font>
		</td>		
		</tr>	
		
			<tr>
		<td style="width:20%;">เอกสารที่ต้องใช้วางบิล :</td>
		<td  style="border-bottom: 1px solid black;width:80%;">
			<font color='blue'><span><?php echo $place_bill; echo  $place_bluebill; echo $sum_inv; echo  $sum_invn;  echo $po_ckk; echo $product_ckk; echo $bill_ckk; ?></span></font>
		</td>		
		</tr>	
	</table>
	
	<br>
	<table style="width:100%;">
	<tr>
<td style="width:40%;text-align:left;"><b><u>ข้อมูลการรับเช็ค</u></b></td>
		</tr>	
</table>
	<table style="width:100%;">
				<tr>
		<td style="width:15%;">วันที่/เวลา รับเช็ค :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $date_withtax; ?></span></font>
		</td>		
		<td style="width:15%;">สถานที่รับเช็ค :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $add_withtax; echo  $note_ckk; echo  $note_desckk; ?></span></font>
		</td>				
		</tr>	
	
			<tr>
		<td style="width:15%;">เบอร์โทรศัพท์ :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $tel_withtax; ?></span></font>
		</td>		
		<td style="width:15%;">เอกสารรับเช็ค :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $withtax_ckk; echo $with_ckk; ?></span></font>
		</td>				
		</tr>	
		
			<tr>
		<td style="width:15%;">ใบมอบอำนาจ :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $note; ?></span></font>
		</td>		
		<td style="width:15%;">ระยะเวลาการมอบอำนาจ :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $note; ?></span></font>
		</td>				
		</tr>	
		
			<tr>
		<td style="width:15%;">จำนวนอากร :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $count_arkon; ?></span></font>
		</td>		
		<td style="width:15%;">เลขที่ดัชนี :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $index_no; ?></span></font>
		</td>				
		</tr>
		
		
	</table>
	
	<br>
	<table style="width:100%;">
	<tr>
<td style="width:40%;text-align:left;"><b><u>ข้อมูลการจัดส่ง</u></b></td>
		</tr>	
</table>
	
		
	
		<table style="width:100%;">
	<tr>
		<td style="width:20%;">ขั้นตอนการส่งสินค้า1 :</td>
		<td  style="border-bottom: 1px solid black;width:30%;">
			<font color='blue'><span><?php echo $step_delivery1; ?></span></font>
		</td>		
		<td style="width:20%;">วันที่/เวลา ส่งสินค้า :</td>
		<td  style="border-bottom: 1px solid black;width:30%;">
			<font color='blue'><span><?php echo $date_timdel; ?></span></font>
		</td>				
		</tr>
		
		<tr>
		<td style="width:15%;">สถานที่ส่งสินค้า :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $add_del; ?></span></font>
		</td>		
		<td style="width:15%;">ชื่อผู้ติอต่อ :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $name_condel; ?></span></font>
		</td>				
		</tr>
			
		
		<tr>
		<td style="width:15%;">หมายเหตุ1 :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $remark1; ?></span></font>
		</td>		
		<td style="width:15%;">ขั้นตอนการส่งสินค้า2 :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $step_delivery2; ?></span></font>
		</td>				
		</tr>	
		
		<tr>
		<td style="width:15%;">ธนาคารที่โอนเงิน :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $bank_tran; ?></span></font>
		</td>		
		<td style="width:15%;">เอกสารที่ใช้ส่งสินค้า :</td>
		<td  style="border-bottom: 1px solid black;width:35%;">
			<font color='blue'><span><?php echo $doc_del; ?></span></font>
		</td>				
		</tr>	
		
	</table>
	
	<br><br>
<?php } ?>	
</body>
</div>
</html>



