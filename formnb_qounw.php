<?php
// ================================
// Allwell/NobleMed Quotation (A4)
// Layout: Dynamic table + auto pagination
// ================================

define('FPDF_FONTPATH','font/');
require('fpdf1.php');
date_default_timezone_set("Asia/Bangkok");

// ---------------- Functions ----------------
function DateThai($strDate){
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay  = date("j",strtotime($strDate));
    $strMonthCut = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
function ReadNumber($number){
    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
    $number_call   = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
    $number = $number + 0;
    $ret = "";
    if ($number == 0) return $ret;
    if ($number > 1000000){
        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
        $number = intval(fmod($number, 1000000));
    }
    $divider = 100000; $pos = 0;
    while($number > 0){
        $d = intval($number / $divider);
        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" :
        ((($divider == 10) && ($d == 1)) ? "" :
        ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
        $ret .= ($d ? $position_call[$pos] : "");
        $number = $number % $divider;
        $divider = $divider / 10;
        $pos++;
    }
    return $ret;
}

// คำนวณจำนวนบรรทัดที่ MultiCell จะใช้กับความกว้าง $w ปัจจุบัน
function nbLines($pdf, $w, $txt) {
    $cw = $pdf->CurrentFont['cw'];
    if ($w == 0) $w = $pdf->w - $pdf->rMargin - $pdf->x;
    $wmax = ($w - 2*$pdf->cMargin) * 1000 / $pdf->FontSize;

    $s = str_replace("\r", '', $txt);
    $nb = strlen($s);
    $sep = -1; $i = 0; $j = 0; $l = 0; $nl = 1;

    while ($i < $nb) {
        $c = $s[$i];
        if ($c === "\n") { $i++; $sep = -1; $j = $i; $l = 0; $nl++; continue; }
        if ($c === ' ') $sep = $i;
        $l += $cw[$c] ?? 0;
        if ($l > $wmax) {
            if ($sep === -1) { if ($i == $j) $i++; }
            else { $i = $sep + 1; }
            $sep = -1; $j = $i; $l = 0; $nl++;
        } else {
            $i++;
        }
    }
    return $nl;
}



function Convert($amount_number){
    $amount_number = number_format($amount_number, 2, ".","");
    $pt = strpos($amount_number , ".");
    $number = $fraction = "";
    if ($pt === false) $number = $amount_number;
    else { $number = substr($amount_number, 0, $pt); $fraction = substr($amount_number, $pt + 1); }
    $ret = "";
    $baht = ReadNumber($number);
    if ($baht != "") $ret .= $baht . "บาท";
    $satang = ReadNumber($fraction);
    if ($satang != "") $ret .=  $satang . "สตางค์"; else $ret .= "ถ้วน";
    return $ret;
}
function thai($t){ return iconv('UTF-8','cp874//IGNORE',$t); }

// ---------------- Input ----------------
$ref_id = isset($_GET["ref_id"]) ? $_GET["ref_id"] : '';
$code   = isset($_GET["code"])   ? $_GET["code"]   : ''; // (ไม่ใช้)

// ---------------- DB ----------------
include "dbconnect.php";

// main doc
$strSQL  = "SELECT * FROM qou__main WHERE ref_id = '".$ref_id."' ";
$objQuery= mysqli_query($conn,$strSQL) or die(mysqli_error($conn));
$objResult = mysqli_fetch_array($objQuery);

// sale owner tel
$strSQL3  = "SELECT employee_tel FROM tb_user WHERE em_id = '".$objResult["sup_code"]."' ";
$objQuery3= mysqli_query($conn,$strSQL3) or die(mysqli_error($conn));
$objResult3= mysqli_fetch_array($objQuery3);

// sums
$strSQL15  = "SELECT SUM(amount) AS amount_1, SUM(discount) AS discount FROM qou__sbmain WHERE ref_idd = '".$ref_id."' ";
$objQuery15= mysqli_query($conn,$strSQL15) or die(mysqli_error($conn));
$objResult15= mysqli_fetch_array($objQuery15);

// detail rows
$strSQL1 = "SELECT amount,price,sol_name,`count`,unit_name,remark_name,product_code
            FROM (qou__sbmain LEFT JOIN tb_product ON qou__sbmain.product_ID=tb_product.product_id)
            WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

// ---------------- Extract fields ----------------
$type_doc   = $objResult["type_doc"];           // 1=Allwell, 2=NobleMed
$iv_date    = DateThai($objResult["iv_date"]);
$register_date = DateThai($objResult["register_date"]);
$iv_no      = $objResult["iv_no"];
$cus_name   = $objResult["cus_name"];
if($objResult["payment_dead"]=='อื่นๆ'){
$payment_dead = $objResult["payment_dead_other_wrap"];		
}else{	
$payment_dead = $objResult["payment_dead"];	
}
$set_price  = DateThai($objResult["set_price"]);
if($objResult["delivery_dead"]=='เลือกวันที่'){
$delivery_dead = DateThai($objResult["delivery_date"]);	
}else{
$delivery_dead = $objResult["delivery_dead"];
}
$waranty    = $objResult["waranty"];
$waranty_ckk= $objResult["waranty_ckk"];

$sup_name   = $objResult["sup_name"];
$tel        = $objResult3["employee_tel"];
$sup_code   = $objResult["sup_code"];
$speck      = $objResult["speck"];
$catalog    = $objResult["catalog"];
$picture    = $objResult["picture"];
$add_by     = $objResult["add_by"];
$status_doc = $objResult["status_doc"];

$remark1    = $objResult["remark1"];
$remark2    = $objResult["remark2"];
$remark3    = $objResult["remark3"];
$remark4    = $objResult["remark4"];
$remark5    = $objResult["remark5"];
$remark_ckk = $objResult["remark_ckk"];
$type_head  = $objResult["type_head"]; // 1=ซื้อ, else=เช่า

// ---------------- Financials ----------------
// ใช้ยอดรวม (amount_1) และส่วนลดรวม (discount) จาก DB
$summary_1  = floatval($objResult15['amount_1']);   // สมมติเป็นยอด "รวมภาษี" (ตามโค้ดเดิม)
$discount_1 = floatval($objResult15['discount']);

// คิดยอดสุทธิหลังหักส่วนลด แล้วแยกฐานภาษี/ภาษี
$subtotal = max(0, $summary_1 - $discount_1); // ป้องกันค่าติดลบ
$base     = $subtotal / 1.07;
$vatVal   = $base * 0.07;
$grand    = $base + $vatVal;

// แปลงเป็นสตริงแสดงผล
$discount = number_format($discount_1,2);
$sum_vat  = number_format($base,2);
$vat      = number_format($vatVal,2);
$summary  = number_format($grand,2);
$number_thai = Convert($grand);

// ---------------- PDF Setup ----------------
$pdf = new FPDF('P','cm','A4');
$pdf->AddPage();
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->AddFont('times','','times.php');

// หัวกระดาษ (ภาพพื้นหลัง)
if($type_doc=='1'){
    $pdf->Image("img/head_awl.jpg",0,0,21.0,29.7);
}else if($type_doc=='2'){
    $pdf->Image("img/head_nbm.png",0,0,21.0,29.7);
}

// ---------------- Header Fields (Top-right) ----------------
$pdf->SetFont('angsa','',14);
$pdf->setXY(13.2,3.5); $pdf->MultiCell(9.0,0.5, thai("ใบเสนอราคาเลขที่"),0,'L');
$pdf->setXY(16.5,3.5); $pdf->MultiCell(9.0,0.5, thai($ref_id),0,'L');

$pdf->setXY(13.2,4.0); $pdf->MultiCell(9.0,0.5, thai("วันที่"),0,'L');
$pdf->setXY(14.5,4.0); $pdf->MultiCell(9.0,0.5, thai($register_date),0,'L');

// ---------------- Subject & Greeting ----------------
$pdf->SetFont('angsana','B',15);
$pdf->setXY(1.0,4.5);  $pdf->MultiCell(90,0.6, thai("เรื่อง"),0,'L');

if($type_head=='1'){
    $pdf->setXY(2.0,4.5); $pdf->MultiCell(90,0.6, thai("ขอเสนอราคาวัสดุ ครุภัณฑ์ และอุปกรณ์การแพทย์"),0,'L');
}else{
    $pdf->setXY(2.0,4.5); $pdf->MultiCell(90,0.6, thai("ขอเสนอราคาเช่าวัสดุ ครุภัณฑ์ และอุปกรณ์การแพทย์"),0,'L');
}

$pdf->setXY(1.0,5.1);  $pdf->MultiCell(90,0.6, thai("เรียน"),0,'L');
$pdf->SetFont('angsana','B',14);
$pdf->setXY(2.0,5.1);  $pdf->MultiCell(90,0.6, iconv('UTF-8//IGNORE','cp874//IGNORE',$cus_name),0,'L');

$pdf->SetFont('angsa','',14);
if($type_doc=='1'){
    $pdf->setXY(2.0,6.3);
    $pdf->MultiCell(90,0.6, thai("บริษัท ออลล์เวล ไลฟ์ จำกัด มีความยินดีขอเสนอราคาวัสดุ ครุภัณฑ์ และอุปกรณ์การแพทย์ ดังรายละเอียดต่อไปนี้"),0,'L');
}else if($type_doc=='2'){
    $pdf->setXY(2.0,6.3);
    $pdf->MultiCell(90,0.6, thai("บริษัท โนเบิล เมด จำกัด มีความยินดีขอเสนอราคาวัสดุ ครุภัณฑ์ และอุปกรณ์การแพทย์ ดังรายละเอียดต่อไปนี้"),0,'L');
}

// ---------------- Dynamic Table Layout ----------------
$marginL = 0.6;
$lineH   = 0.7;
$wIdx    = 1.2;    // ITEM
$wDesc   = 11.5;   // DESCRIPTION
$wQty    = 2.2;    // QTY
$wUnit   = 2.5;    // UNITPRICE
$wAmt    = 2.5;    // AMOUNT

$colX    = $marginL;
$yStart  = 7.0;
$y       = $yStart;
$yBottom = 19.5;   // กันชนหน้าตารางก่อนขึ้นบล็อกสรุป

function setFontArr($pdf,$name,$style,$size){ $pdf->SetFont($name,$style,$size); }
function drawTableHeader($pdf,$x,$y,$wIdx,$wDesc,$wQty,$wUnit,$wAmt,$lineH){
    setFontArr($pdf,'angsa','',14);
    $pdf->setXY($x,$y); $pdf->Cell($wIdx, $lineH, thai("ITEM"), 1,0,'C');
    $pdf->setXY($x+$wIdx,$y); $pdf->Cell($wDesc,$lineH, thai("DESCRIPTION"), 1,0,'C');
    $pdf->setXY($x+$wIdx+$wDesc,$y); $pdf->Cell($wQty,$lineH, thai("QTY"), 1,0,'C');
    $pdf->setXY($x+$wIdx+$wDesc+$wQty,$y); $pdf->Cell($wUnit,$lineH, thai("UNITPRICE"), 1,0,'C');
    $pdf->setXY($x+$wIdx+$wDesc+$wQty+$wUnit,$y); $pdf->Cell($wAmt,$lineH, thai("AMOUNT"), 1,1,'C');
}
// วาดรายการ 1 แถว (บังคับให้ทุกคอลัมน์อยู่บรรทัดเดียวกัน)
// วาดรายการ 1 แถว (บังคับให้ทุกคอลัมน์อยู่บรรทัดเดียวกัน)
function drawRow($pdf,$i,$name,$qtyText,$unitPriceText,$amountText,
                 $x,$y,$wIdx,$wDesc,$wQty,$wUnit,$wAmt,$lineH){
    $pdf->SetFont('angsa','',14);

    // 1) วาดคอลัมน์ ITEM (ใส่ตัวเลขกลางกรอบ)
    $pdf->setXY($x,$y);
    $pdf->Cell($wIdx, $lineH, '', 1, 0); // กรอบไว้ก่อน
    $pdf->setXY($x,$y);
    $pdf->Cell($wIdx, $lineH, thai($i), 0, 0, 'C');

    // 2) DESCRIPTION: ใช้ MultiCell เพื่อคำนวณความสูงจริงของแถว
    $xDesc = $x + $wIdx;
    $pdf->setXY($xDesc, $y);
    $pdf->MultiCell($wDesc, 0.7, thai($name), 0, 'L'); // ยังไม่ใส่กรอบ
    $yAfterDesc = $pdf->GetY();
    $rowH = max($lineH, $yAfterDesc - $y); // ความสูงจริงของแถว

    // ใส่กรอบ DESCRIPTION ให้สูงเท่าทั้งแถว
    $pdf->Rect($xDesc, $y, $wDesc, $rowH);

    // 3) รีเซ็ตไปต้นแถว แล้ววาด QTY / UNITPRICE / AMOUNT ให้สูงเท่ากัน
    $xQty  = $xDesc + $wDesc;
    $xUnit = $xQty  + $wQty;
    $xAmt  = $xUnit + $wUnit;

    // QTY
    $pdf->setXY($xQty, $y);
    $pdf->Cell($wQty, $rowH, thai($qtyText), 1, 0, 'R');

    // UNITPRICE
    $pdf->setXY($xUnit, $y);
    $pdf->Cell($wUnit, $rowH, thai($unitPriceText), 1, 0, 'R');

    // AMOUNT
    $pdf->setXY($xAmt, $y);
    $pdf->Cell($wAmt, $rowH, thai($amountText), 1, 1, 'R');

    return $rowH;
}


function drawLetterheadBG($pdf,$type_doc){
    if($type_doc=='1'){
        $pdf->Image("img/head_awl.jpg",0,0,21.0,29.7);
    }else if($type_doc=='2'){
        $pdf->Image("img/head_nbm.png",0,0,21.0,29.7);
    }
}
function newPageWithHeader($pdf,$type_doc){
    $pdf->AddPage();
    $pdf->AddFont('angsa','','angsa.php');
    $pdf->AddFont('angsana','B','angsab.php');
    $pdf->AddFont('times','','times.php');
    drawLetterheadBG($pdf,$type_doc);
}

// วาดหัวตารางครั้งแรก
drawTableHeader($pdf,$colX,$y,$wIdx,$wDesc,$wQty,$wUnit,$wAmt,$lineH);
$y += $lineH;

// วนวาดรายการสินค้าแบบไดนามิก
$i=1;
mysqli_data_seek($objQuery1,0);
while($row = mysqli_fetch_assoc($objQuery1)){
    $sale_count = (float)$row["count"];
    $unit_name  = $row["unit_name"];
  $name = (trim($row['remark_name'] ?? '') !== '')
    ? ' ' . ltrim($row['remark_name'])
    : ' ' . ltrim($row['sol_name']);

    $unitPrice  = (float)$row["price"];
    $lineTotal  = $sale_count * $unitPrice;

    $qtyText       = number_format($sale_count,0)." ".$unit_name;
    $unitPriceText = number_format($unitPrice,2);
    $amountText    = number_format($lineTotal,2);

    // ถ้าพื้นที่ไม่พอ ขึ้นหน้าใหม่และวาดหัวตารางอีกครั้ง
    if($y > $yBottom){
        newPageWithHeader($pdf,$type_doc);
        drawTableHeader($pdf,$colX,$yStart,$wIdx,$wDesc,$wQty,$wUnit,$wAmt,$lineH);
        $y = $yStart + $lineH;
    }

    $rowH = drawRow($pdf,$i,$name,$qtyText,$unitPriceText,$amountText,$colX,$y,$wIdx,$wDesc,$wQty,$wUnit,$wAmt,$lineH);
    $y += $rowH;
    $i++;
}

// เว้นใต้ตาราง
$y += 0.0;

// ---------------- Summary Block (ชิดขวา) ----------------
$sumBoxX = $colX + $wIdx + $wDesc;     // เริ่มคอลัมน์สรุป (ขอบซ้ายของบล็อคขวา)
$sumBoxW = $wQty + $wUnit;             // กว้างคอลัมน์ label
$sumValW = $wAmt;                      // กว้างคอลัมน์ค่า
$labelH  = 0.6;

if ($y > 23.5) { // กันชนกับลายเซ็น
    newPageWithHeader($pdf, $type_doc);
    drawTableHeader($pdf, $colX, $yStart, $wIdx, $wDesc, $wQty, $wUnit, $wAmt, $lineH);
    $y = $yStart + $lineH;
}

// เก็บ y ต้นบล็อคสรุปไว้ เพื่อใช้คำนวณความสูงกล่องซ้ายให้ "เท่ากัน"
$summaryTopY = $y;

// แถวสรุป 4 แถว (ขวา)
$pdf->setXY($sumBoxX,$y);                 $pdf->Cell($sumBoxW,$labelH, thai("ส่วนลดพิเศษ"),        1,0,'L');
$pdf->setXY($sumBoxX+$sumBoxW,$y);        $pdf->Cell($sumValW,$labelH, thai($discount),            1,1,'R'); $y += $labelH;

$pdf->setXY($sumBoxX,$y);                 $pdf->Cell($sumBoxW,$labelH, thai("มูลค่าสินค้า"),        1,0,'L');
$pdf->setXY($sumBoxX+$sumBoxW,$y);        $pdf->Cell($sumValW,$labelH, thai($sum_vat),             1,1,'R'); $y += $labelH;

$pdf->setXY($sumBoxX,$y);                 $pdf->Cell($sumBoxW,$labelH, thai("ภาษีมูลค่าเพิ่ม 7 %"), 1,0,'L');
$pdf->setXY($sumBoxX+$sumBoxW,$y);        $pdf->Cell($sumValW,$labelH, thai($vat),                 1,1,'R'); $y += $labelH;

$pdf->setXY($sumBoxX,$y);                 $pdf->Cell($sumBoxW,$labelH, thai("มูลค่ารวม"),           1,0,'L');
$pdf->setXY($sumBoxX+$sumBoxW,$y);        $pdf->Cell($sumValW,$labelH, thai($summary),             1,1,'R'); $y += 0; // ยังไม่ขยับ เพื่อวัดความสูงจริง

// คำนวณความสูงบล็อคสรุป (ด้านขวา)
$summaryBottomY = $summaryTopY + 4 * $labelH;   // มี 4 แถว x ความสูงแถว
$y = $summaryBottomY;                           // ตั้ง y ปัจจุบันให้ตรงกัน

// ---------------- กล่องซ้าย (ยอดตัวอักษร) ให้ "เท่าความสูง" กับบล็อคขวา ----------------
$leftBoxX = $colX;                 // ชิดซ้ายเท่าตาราง
$leftBoxW = $sumBoxX - $colX;      // กว้าง = ตั้งแต่ซ้ายสุดจนถึงก่อนบล็อคขวา
$leftBoxH = $summaryBottomY - $summaryTopY;  // สูงเท่าบล็อคขวา

// วาดกรอบกล่องซ้าย
$pdf->Rect($leftBoxX, $summaryTopY, $leftBoxW, $leftBoxH);

$padX   = 0.3;                 // ขอบซ้าย/ขวา
$lineH  = 0.6;                 // ความสูงบรรทัด
$text   = thai("($number_thai).");
$innerW = $leftBoxW - 2*$padX; // ความกว้างด้านในกรอบ

// นับบรรทัดและหาความสูงข้อความจริง
// (ต้องกำหนดฟอนต์ไว้แล้วก่อนเรียก nbLines)
$lines = nbLines($pdf, $innerW, $text);
$textH = $lines * $lineH;

// จุดเริ่มให้ "ชิดล่าง" (ไม่มีระยะเผื่อด้านล่าง)
$topY = $summaryTopY + $leftBoxH - $textH;
// กันไม่ให้ล้นขึ้นไปเหนือกรอบ ถ้าข้อความยาวมาก
if ($topY < $summaryTopY) $topY = $summaryTopY;

// วางข้อความกึ่งกลางแนวนอน + ชิดล่าง
$pdf->SetXY($leftBoxX + $padX, $topY);
$pdf->MultiCell($innerW, $lineH, $text, 0, 'C');



// ขยับ y ลงเล็กน้อยสำหรับบรรทัดถัดไป
$y = $summaryBottomY + 0.4;

// ---------------- Terms / Notes ----------------
$lines = array(
    "สินค้ารับประกัน $waranty",
    "การชำระเงิน $payment_dead",
    "กำหนดยืนราคา $set_price",
    "กำหนดส่งสินค้า $delivery_dead",
    
);

foreach($lines as $t){
    if($y > 26.0){
        newPageWithHeader($pdf,$type_doc);
        $y = $yStart;
    }
    $pdf->setXY(2.0,$y); $pdf->MultiCell(20.0,0.6, thai($t), 0,'L'); $y += 0.6;
}

// หมายเหตุเพิ่มเติม
if($remark_ckk=='1'){
    $remarks = array_filter([$remark1,$remark2,$remark3,$remark4,$remark5], function($v){ return trim((string)$v) !== ''; });
    foreach($remarks as $rmk){
        if($y > 26.0){
            newPageWithHeader($pdf,$type_doc);
            $y = $yStart;
        }
        $pdf->setXY(2.0,$y); $pdf->MultiCell(20.0,0.6, thai($rmk), 0,'L'); $y += 0.6;
    }
}

// ---------------- Signature Block ----------------
if($y > 21.0){
    newPageWithHeader($pdf,$type_doc);
    $y = $yStart;
}


$pdf->setXY(15.4,20.0);
$pdf->MultiCell(15.0,0.6, thai("จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติ"), 0,'L');
	
$pdf->setXY(16.0,21.4);
$pdf->MultiCell(15.0,0.6, thai("ขอแสดงความนับถือ"), 0,'L');

if($status_doc=='Approve'){
    if($type_doc=='1'){
        $pdf->Image("img/ptl_square.png",15.5,22.0,4.7,1.5);
    }elseif($type_doc=='2'){
        $pdf->Image("img/nbm_oval.png",16.0,22.0,3.5,1.7);
    }
    if($sup_code=='52025'){
        $pdf->Image("img/malinee.png",16.0,22.0,3.0,1.5);
    }else{
        $pdf->Image("img/keaw_1.png",16.0,20.8,4.0,4.0);
    }
}

$pdf->setXY(16.0,24.0); $pdf->MultiCell(15.0,0.6, thai("(นางสาว$sup_name)"),0,'L');
$pdf->setXY(16.3,24.6); $pdf->MultiCell(15.0,0.6, thai("หัวหน้าเขตการขาย"),0,'L');

$pdf->setXY(1.0,24.4);  $pdf->MultiCell(15.0,0.6, thai("ผู้เสนอราคา : "),0,'L');
$pdf->setXY(3.0,24.4);  $pdf->MultiCell(15.0,0.6, thai($add_by),0,'L');

$pdf->setXY(1.0,25.0);  $pdf->MultiCell(15.0,0.6, thai("โทร : "),0,'L');
$pdf->setXY(2.0,25.0);  $pdf->MultiCell(15.0,0.6, thai($iv_no),0,'L'); // ตามไฟล์เดิม: แสดง $iv_no ในบรรทัด "โทร :"

// ---------------- Optional Attach Pages (spec / catalog / picture) ----------------
if(!empty($speck)){
    $pdf->AddPage(); drawLetterheadBG($pdf,$type_doc); // ถ้าอยากมีหัวทุกหน้า
    $path = "qou/$speck";
    $pdf->Image($path,1.5,3.0,21.0,29.7);
}
if(!empty($catalog)){
    $pdf->AddPage(); drawLetterheadBG($pdf,$type_doc);
    $path1 = "qou/$catalog";
    $pdf->Image($path1,1.5,3.0,21.0,29.7);
}
if(!empty($picture)){
    $pdf->AddPage(); drawLetterheadBG($pdf,$type_doc);
    $path2 = "qou/$picture";
    $pdf->Image($path2,1.5,3.0,21.0,29.7);
}

// ---------------- Output ----------------
$pdf->Output();
?>
