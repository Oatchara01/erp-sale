<?php

define('FPDF_FONTPATH', 'font/');

require('fpdf.php');

// แปลง UTF-8 -> cp874 อย่างปลอดภัย: อักขระที่ cp874 แทนไม่ได้จะถูกแปลงใกล้เคียง (TRANSLIT)
// หรือตัดทิ้ง (IGNORE) แทนที่จะยิง Notice ซึ่งทำให้เอาต์พุต PDF พัง
function thai_cp874($str)
{
	return @iconv('UTF-8', 'cp874//TRANSLIT//IGNORE', (string)$str);
}

$ref_id = isset($_GET["ref_id"]) ? $_GET["ref_id"] : '';
$isPreview = ($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['preview_mode']) && $_POST['preview_mode'] === '1';

include "dbconnect.php";

if ($isPreview) {
	$objResult = array(
		'date_jong'     => isset($_POST['date_jong']) ? $_POST['date_jong'] : '',
		'date_receive'  => isset($_POST['date_receive']) ? $_POST['date_receive'] : '',
		'customer'      => isset($_POST['customer']) ? $_POST['customer'] : '',
		'address_send'  => isset($_POST['address_send']) ? $_POST['address_send'] : '',
		'sale_name'     => '',
		'sale_code'     => isset($_POST['sale_code']) ? $_POST['sale_code'] : '',
		'register_ckk'  => '',
		'cancel_ckk'    => '',
		'status_doc'    => '',
		'type_jong'     => isset($_POST['type_jong']) ? $_POST['type_jong'] : '',
		'bq_no'         => '',
		'drescription'  => isset($_POST['drescription']) ? $_POST['drescription'] : '',
		'approve_name'  => '',
		'date_approve'  => '0000-00-00',
		'remark'        => '',
		'iv_no'         => '',
	);
} else {
	$strSQL = "SELECT * FROM hos__jongproduct WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "' ";

	$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");;
	$objResult = mysqli_fetch_array($objQuery);
}

// รวมกับค่า default เสมอ กันกรณีคอลัมน์ที่โค้ดอ้างถึงไม่มีในตาราง/แถว หรือเป็น null
// ซึ่งจะยิง PHP Warning: Undefined array key และทำให้เอาต์พุต PDF พัง
$objResultDefaults = array(
	'date_jong'     => '',
	'date_receive'  => '',
	'customer'      => '',
	'address_send'  => '',
	'sale_name'     => '',
	'sale_code'     => '',
	'register_ckk'  => '',
	'cancel_ckk'    => '',
	'status_doc'    => '',
	'type_jong'     => '',
	'bq_no'         => '',
	'drescription'  => '',
	'approve_name'  => '',
	'date_approve'  => '0000-00-00',
	'remark'        => '',
	'iv_no'         => '',
);
$objResult = array_merge($objResultDefaults, array_filter(is_array($objResult) ? $objResult : array(), function ($v) {
	return $v !== null;
}));

$items = array();
if ($isPreview) {
	$productIdList = isset($_POST['product_id']) && is_array($_POST['product_id']) ? $_POST['product_id'] : array();
	$countList = isset($_POST['sale_count']) && is_array($_POST['sale_count']) ? $_POST['sale_count']
		: (isset($_POST['count']) && is_array($_POST['count']) ? $_POST['count'] : array());
	$remarkList = isset($_POST['sale_remark']) && is_array($_POST['sale_remark']) ? $_POST['sale_remark']
		: (isset($_POST['sale_remarkk']) && is_array($_POST['sale_remarkk']) ? $_POST['sale_remarkk'] : array());

	for ($i = 0; $i < count($productIdList); $i++) {
		$pid = trim($productIdList[$i]);
		if ($pid === '') continue;
		$pidEsc = mysqli_real_escape_string($conn, $pid);
		$prod = array('access_code' => '', 'sol_name' => '', 'unit_name' => '');
		$prodQ = mysqli_query($conn, "SELECT access_code, sol_name, unit_name FROM tb_product WHERE product_id = '" . $pidEsc . "' LIMIT 1");
		if ($prodQ && ($pr = mysqli_fetch_assoc($prodQ))) {
			$prod = $pr;
		}
		$items[] = array(
			'access_code' => $prod['access_code'],
			'sol_name'    => $prod['sol_name'],
			'unit_name'   => $prod['unit_name'],
			'count'       => isset($countList[$i]) ? $countList[$i] : '',
			'sale_remark' => isset($remarkList[$i]) ? $remarkList[$i] : '',
		);
	}
} else {
	$strSQL1 = "SELECT * FROM (hos__subjongpro LEFT JOIN tb_product ON hos__subjongpro.product_ID=tb_product.product_id) WHERE ref_idd = '" . mysqli_real_escape_string($conn, $ref_id) . "' ";
	$objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [" . $strSQL1 . "]");
	while ($row = mysqli_fetch_array($objQuery1)) {
		$items[] = $row;
	}
}


date_default_timezone_set("Asia/Bangkok");
function DateThai($strDate)
{
	if ($strDate === '' || $strDate === null) {
		return '';
	}
	$timestamp = strtotime($strDate);
	if ($timestamp === false) {
		return '';
	}
	$strYear = date("Y", $timestamp) + 543;
	$strMonth = (int)date("n", $timestamp);
	$strDay = date("j", $timestamp);
	$strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
	$strMonthThai = isset($strMonthCut[$strMonth]) ? $strMonthCut[$strMonth] : '';
	return "$strDay $strMonthThai $strYear";
}



$date_jong = DateThai($objResult['date_jong']);
$date_receive = DateThai($objResult['date_receive']);

$customer = $objResult['customer'];
$address_send = $objResult['address_send'];
$sale_name  = $objResult['sale_name'];
$sale_code  = $objResult['sale_code'];
$register_ckk = $objResult['register_ckk'];
$cancel_ckk = $objResult['cancel_ckk'];
$status_doc = $objResult['status_doc'];
$type_jong = $objResult['type_jong'];
$bq_no = $objResult['bq_no'];
$drescription = $objResult['drescription'];
$approve_name = $objResult['approve_name'];
$date_approve = '';
if ($objResult['date_approve'] != '0000-00-00') {
	$date_approve = DateThai($objResult['date_approve']);
}
$remark = $objResult['remark'];
$newadd_date = date("d-m-Y H:i:s");
$iv_no = $objResult['iv_no'];

$pdf = new FPDF('P', 'cm', 'A4');
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->AddFont('angsana', 'B', 'angsab.php');

$pdf->AddPage();
$pdf->SetFont('angsana', 'BU', 20);



$pdf->setXY(8.9, 1.0);
$pdf->MultiCell(9, 0.6, thai_cp874("ใบจองสินค้า"), 0, 'L');
$pdf->setXY(8.2, 1.5);
$pdf->MultiCell(5.5, 0.6, thai_cp874("(Product Booking)"), 0, 'L');



$pdf->SetFont('angsana', 'B', 14);

$pdf->setXY(1.4, 3.0);
$pdf->Cell(6.0, 6.2, "", 1, 1, "c");

$pdf->setXY(1.4, 9.2);
$pdf->Cell(6.0, 2.8, "", 1, 1, "c");



$pdf->setXY(7.4, 3.0);
$pdf->Cell(3.0, 9.0, "", 1, 1, "c");

$pdf->setXY(10.4, 3.0);
$pdf->Cell(7.0, 9.0, "", 1, 1, "c");


$pdf->setXY(17.4, 3.0);
$pdf->Cell(1.5, 9.0, "", 1, 1, "c");

$pdf->setXY(18.9, 3.0);
$pdf->Cell(1.5, 9.0, "", 1, 1, "c");


$pdf->setXY(1.4, 12.0);
$pdf->Cell(19.0, 1.5, "", 1, 1, "c");

$pdf->setXY(1.4, 13.5);
$pdf->Cell(19.0, 1.0, "", 1, 1, "c");



$pdf->setXY(1.4, 3.8);
$pdf->Cell(19.0, 0, '', 'T', 0, 'C', 0);


$pdf->setXY(3.8, 3.1);
$pdf->MultiCell(10, 0.6, thai_cp874("ข้อมูลการจอง"), 0, 'L');


$pdf->setXY(8.0, 3.1);
$pdf->MultiCell(10, 0.6, thai_cp874("รหัสสินค้า"), 0, 'L');

$pdf->setXY(13.5, 3.1);
$pdf->MultiCell(10, 0.6, thai_cp874("รายการ"), 0, 'L');

$pdf->setXY(17.5, 3.1);
$pdf->MultiCell(10, 0.6, thai_cp874("จำนวน"), 0, 'L');

$pdf->setXY(19.1, 3.1);
$pdf->MultiCell(10, 0.6, thai_cp874("หน่วย"), 0, 'L');







$pdf->SetFont('angsa', '', 14);


$pdf->setX(17.0);
$pdf->MultiCell(9.0, 0.5, thai_cp874(""), 0, 'L');

$i = 1;
foreach ($items as $objResult1) {

	$unit_name  = (string)($objResult1["unit_name"] ?? '');
	$product_code1  = (string)($objResult1["access_code"] ?? '');
	$product_code = substr($product_code1, 0, 10);
	$product_name  = (string)($objResult1["sol_name"] ?? '');
	//$product_name = substr($product_name1,0,70);
	$sale_count  = (string)($objResult1["count"] ?? '');
	$sale_remark  = (string)($objResult1["sale_remark"] ?? '');



	$pdf->setX(7.6);
	$pdf->MultiCell(9.0, 0, thai_cp874("$product_code"), 0, 'L');

	$pdf->setX(10.5);
	$pdf->Cell(10, 0, thai_cp874("$product_name $sale_remark"), 0, 'L');


	$pdf->setX(16.9);
	$pdf->MultiCell(1.9, 0, thai_cp874("$sale_count"), 0, 'R');

	$pdf->setX(18.0);
	$pdf->MultiCell(2.0, 0, thai_cp874("$unit_name"), 0, 'R');


	$pdf->setX(18.3);
	$pdf->MultiCell(9.0, 0.7, thai_cp874(""), 0, 'L');


	$i++;
}

$pdf->setXY(7.4, 4.55);
$pdf->Cell(13.0, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(7.4, 5.25);
$pdf->Cell(13.0, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(7.4, 5.95);
$pdf->Cell(13.0, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(7.4, 6.65);
$pdf->Cell(13.0, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(7.4, 7.35);
$pdf->Cell(13.0, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(7.4, 8.05);
$pdf->Cell(13.0, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(7.4, 8.75);
$pdf->Cell(13.0, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(7.4, 9.45);
$pdf->Cell(13.0, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(7.4, 10.15);
$pdf->Cell(13.0, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(7.4, 10.85);
$pdf->Cell(13.0, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(7.4, 11.55);
$pdf->Cell(13.0, 0, '', 'T', 0, 'c', 0);



$pdf->setXY(1.4, 4.0);
$pdf->MultiCell(10, 0.6, thai_cp874("วันที่แจ้ง :"), 0, 'L');


$pdf->setXY(3.4, 4.55);
$pdf->Cell(4.0, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(4.0, 4.0);
$pdf->MultiCell(10, 0.6, thai_cp874("$date_jong"), 0, 'L');


$pdf->setXY(1.4, 4.6);
$pdf->MultiCell(10, 0.6, thai_cp874("ชื่อลูกค้า :"), 0, 'L');

$pdf->setXY(3.4, 5.15);
$pdf->Cell(4.0, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(3.5, 4.6);
$pdf->MultiCell(4.0, 0.5, thai_cp874("$customer"), 0, 'L');

$pdf->setXY(1.4, 5.8);
$pdf->MultiCell(10, 0.6, thai_cp874("วันที่ต้องการรับสินค้า :"), 0, 'L');

$pdf->setXY(4.7, 6.35);
$pdf->Cell(2.7, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(4.7, 5.8);
$pdf->MultiCell(10, 0.6, thai_cp874("$date_receive"), 0, 'L');

$pdf->setXY(1.4, 6.4);
$pdf->MultiCell(10, 0.6, thai_cp874("ชื่อพนักงาน :"), 0, 'L');

$pdf->setXY(3.4, 6.95);
$pdf->Cell(4.0, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(3.4, 6.4);
$pdf->MultiCell(10, 0.6, thai_cp874("$sale_name "), 0, 'L');

$pdf->setXY(1.4, 7.0);
$pdf->MultiCell(10, 0.6, thai_cp874("เลขที่ BQ :"), 0, 'L');

$pdf->setXY(3.4, 7.0);
$pdf->MultiCell(10, 0.6, thai_cp874("$bq_no"), 0, 'L');

$pdf->setXY(3.4, 7.55);
$pdf->Cell(4.0, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(1.4, 7.6);
$pdf->MultiCell(10, 0.6, thai_cp874("ผู้จองสินค้า :"), 0, 'L');

$pdf->setXY(3.4, 8.4);
$pdf->MultiCell(10, 0.6, thai_cp874("$sale_name "), 0, 'L');

$pdf->setXY(3.4, 9.0);
$pdf->Cell(4.0, 0, '', 'T', 0, 'c', 0);


if ($status_doc == "Approve") {


	$pdf->Image("img/cor.jpeg", 2.8, 9.3, 0.9, 0.5);


	$pdf->setXY(5.5, 9.4);
	$pdf->MultiCell(0.40, 0.40, thai_cp874(""), 1, 'L');
} else if ($status_doc == "Rejected") {

	$pdf->setXY(3.0, 9.4);
	$pdf->MultiCell(0.40, 0.40, thai_cp874(""), 1, 'L');

	$pdf->Image("img/cor.jpeg", 5.3, 9.3, 0.9, 0.5);
} else {

	$pdf->setXY(3.0, 9.4);
	$pdf->MultiCell(0.40, 0.40, thai_cp874(""), 1, 'L');

	$pdf->setXY(5.5, 9.4);
	$pdf->MultiCell(0.40, 0.40, thai_cp874(""), 1, 'L');
}





$pdf->setXY(1.4, 9.3);
$pdf->MultiCell(10, 0.6, thai_cp874("ผู้อนุมัติ :"), 0, 'L');

/*$pdf->setXY( 3.0,9.4);
$pdf->MultiCell( 0.40, 0.40 , iconv( 'UTF-8','cp874' , "" ),1,'L' );*/

$pdf->setXY(3.5, 9.3);
$pdf->MultiCell(10, 0.6, thai_cp874("อนุมัติ"), 0, 'L');

/*$pdf->setXY(5.5,9.4);
$pdf->MultiCell( 0.40, 0.40 , iconv( 'UTF-8','cp874' , "" ),1,'L' );*/

$pdf->setXY(6.0, 9.3);
$pdf->MultiCell(10, 0.6, thai_cp874("ไม่อนุมัติ"), 0, 'L');

$pdf->setXY(3.0, 10.5);
$pdf->MultiCell(10, 0.6, thai_cp874("$approve_name "), 0, 'L');

$pdf->setXY(2.9, 11.1);
$pdf->Cell(4.5, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(3.5, 11.2);
$pdf->MultiCell(10, 0.6, thai_cp874("$date_approve"), 0, 'L');

$pdf->setXY(2.9, 11.8);
$pdf->Cell(4.5, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(1.4, 12.1);
$pdf->MultiCell(10, 0.6, thai_cp874("หมายเหตุ :"), 0, 'L');

$pdf->setXY(3.5, 12.1);
$pdf->MultiCell(16.5, 0.6, thai_cp874("$drescription"), 0, 'L');


$pdf->setXY(3.5, 12.7);
$pdf->Cell(16.5, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(3.5, 13.3);
$pdf->Cell(16.5, 0, '', 'T', 0, 'c', 0);


$pdf->setXY(1.4, 13.6);
$pdf->MultiCell(10, 0.6, thai_cp874("คลังสินค้า :"), 0, 'L');

$pdf->setXY(3.5, 13.6);
$pdf->MultiCell(10, 0.6, thai_cp874("$iv_no"), 0, 'L');


$pdf->setXY(3.5, 14.1);
$pdf->Cell(3.5, 0, '', 'T', 0, 'c', 0);

if ($register_ckk == '1') {
	$pdf->Image("img/cor.jpeg", 7.7, 13.6, 0.9, 0.5);
} else {

	$pdf->setXY(8.0, 13.7);
	$pdf->MultiCell(0.40, 0.40, thai_cp874(""), 1, 'L');
}

$pdf->setXY(8.5, 13.6);
$pdf->MultiCell(10, 0.6, thai_cp874("ลงทะเบียน"), 0, 'L');

if ($cancel_ckk == '1') {
	$pdf->Image("img/cor.jpeg", 10.2, 13.6, 0.9, 0.5);
} else {

	$pdf->setXY(10.5, 13.7);
	$pdf->MultiCell(0.40, 0.40, thai_cp874(""), 1, 'L');
}

$pdf->setXY(11.0, 13.6);
$pdf->MultiCell(10, 0.6, thai_cp874("ยกเลิก"), 0, 'L');

$pdf->setXY(13.0, 13.6);
$pdf->MultiCell(10, 0.6, thai_cp874("หมายเหตุ"), 0, 'L');

$pdf->setXY(14.5, 14.1);
$pdf->Cell(5.8, 0, '', 'T', 0, 'c', 0);

$pdf->setXY(14.5, 13.6);
$pdf->MultiCell(10, 0.6, thai_cp874("$remark"), 0, 'L');












$pdf->SetFont('angsa', '', 11);


$pdf->setXY(1.4, 14.5);
$pdf->MultiCell(10, 0.6, thai_cp874("อนุมัติวันที่ 18 มี.ค. 2557"), 0, 'L');


$pdf->setXY(18.5, 14.5);
$pdf->MultiCell(10, 0.6, thai_cp874("FM-SA-14:Rev.4"), 0, 'L');


$pdf->Output();
?>



