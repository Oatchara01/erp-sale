<?php
define('FPDF_FONTPATH','font/');
require('fpdf.php');
	include "dbconnect_cs.php";
$iv_number = isset($_GET["running_id"]) ? $_GET["running_id"] : "";

include "dbconnect.php";
$strSQL = "SELECT * from tb_research  WHERE  running_id = '".$iv_number."' ";
$objQuery = mysqli_query($com1,$strSQL)or die ("Error Query [".$strSQL."]");;
$objResult = mysqli_fetch_array($objQuery);


date_default_timezone_set("Asia/Bangkok");
function DateThai($strDate){
  if(!$strDate || $strDate=='0000-00-00') return "-";
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay  = date("j",strtotime($strDate));
  $strMonthCut = ["","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."];
  return "$strDay ".$strMonthCut[$strMonth]." $strYear";
}

/* ===== ดึงตัวแปรที่ใช้ ===== */
$running_id     = $objResult["running_id"];
$date_research  = DateThai($objResult["date_research"]);
$customer_name  = $objResult["customer_name"];
$customer_tel   = $objResult["customer_tel"];
$iv_number_row  = $objResult["iv_number"];
$team_send      = $objResult["team_send"];
$product_name   = substr($objResult["product_name"],0,150);
$type_customer  = $objResult["type_customer"];

// ส่วนที่ 1 (ขาย) — 3 ข้อ
$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3    = $objResult["sale_3"];

// ส่วนที่ 2 (สินค้า) — 3 ข้อ
$product_good   = $objResult["product_good"];
$product_link   = $objResult["product_link"];
$product_corect = $objResult["product_corect"];

// ส่วนที่ 3 (จัดส่ง) — 3 ข้อ
$cs_neat    = $objResult["cs_neat"];
$cs_explain = $objResult["cs_explain"];
$cs_3       = $objResult["cs_3"];

// ข้อเสนอแนะ
$suggest    = trim(($objResult["suggest"] ?? "")." ".($objResult["problem"] ?? ""));
$suggest_1  = $objResult["suggest_1"];
$suggest_2  = $objResult["suggest_2"];

// ลายเซ็น/วันที่
$employee_send    = $objResult["employee_send"];
$employee_date    = DateThai($objResult["employee_date"]);
$customer_receive = $objResult["customer_receive"];
$customer_date    = DateThai($objResult["customer_date"]);

/* ===== ค่าคงที่เพื่อความบาลานซ์ทั้งหน้า ===== */
$PW = 21.0;   // A4 cm
$PH = 29.7;
$LM = 1.5;    // Left margin
$RM = 1.5;    // Right margin
$CW = $PW - $LM - $RM; // ความกว้างเนื้อหา (= 18.0 cm)

/* ===== Helpers ===== */
function text($pdf,$x,$y,$w,$h,$str,$align='L',$border=0,$fill=false,$font='angsa',$size=14){
  $pdf->SetFont($font,'',$size);
  $pdf->setXY($x,$y);
  $pdf->Cell($w,$h, iconv('UTF-8','cp874',$str), $border, 0, $align, $fill);
}
function fieldRow($pdf,$x,$y,$label,$value,$labelW,$valueW,$h=0.6){
  text($pdf,$x,$y,$labelW,$h,$label,'L',0,false,'angsa',16);
  // เส้นใต้ช่องค่า
  $pdf->setXY($x+$labelW,$y+$h);
  $pdf->Cell($valueW,0,'','T',0,'C');
  // ค่า
  text($pdf,$x+$labelW,$y,$valueW,$h,$value,'L',0,false,'angsa',14);
}

/* ===== ฟังก์ชันวาดตารางคะแนน 1–5 (3 แถว) ===== */
function drawRatingSection($pdf, $title, $yStart, $questions, $answers, $LM, $CW){
  $rowH  = 0.65;
  $idxW  = 1.2;
  $colW  = 0.9;
  $scoreColsW = $colW * 5;
  $textW = $CW - $idxW - $scoreColsW;
  $mark  = "img/23012019.png";

  // หัวข้อ
  $pdf->SetFont('angsana','B',14);
  $pdf->setXY($LM,$yStart);
  $pdf->MultiCell($CW,$rowH, iconv('UTF-8','cp874',$title), 0,'L');

  $y = $yStart + 0.55;

  // หัวตาราง
  $pdf->SetFont('angsa','',14);
  $pdf->SetFillColor(240,240,240);
  $pdf->setXY($LM,$y);               $pdf->Cell($idxW,$rowH,'',1,0,'C',true);
  $pdf->setXY($LM,$y);               $pdf->Cell($idxW,$rowH,iconv('UTF-8','cp874','ลำดับ'),0,0,'C');
  $pdf->setXY($LM+$idxW,$y);         $pdf->Cell($textW,$rowH,'',1,0,'C',true);
  $pdf->setXY($LM+$idxW,$y);         $pdf->Cell($textW,$rowH,iconv('UTF-8','cp874','รายละเอียด'),0,0,'C');

  $x = $LM+$idxW+$textW;
  for($s=5;$s>=1;$s--){
    $pdf->setXY($x,$y);              $pdf->Cell($colW,$rowH,'',1,0,'C',true);
    $pdf->setXY($x,$y-0.05);         $pdf->Cell($colW,$rowH,iconv('UTF-8','cp874',(string)$s),0,0,'C');
    $x += $colW;
  }
  $pdf->SetFillColor(255,255,255);
  $y += $rowH;

  // แถวคำถาม (ฟอนต์คงที่ทุกข้อ)
  for($i=0;$i<3;$i++){
    // ลำดับ
    $pdf->setXY($LM,$y);             $pdf->Cell($idxW,$rowH,'',1,0,'C');
    $pdf->setXY($LM,$y);             $pdf->Cell($idxW,$rowH,iconv('UTF-8','cp874',(string)($i+1)),0,0,'C');

    // ข้อความคำถาม (ฟอนต์ 14 เท่ากันทุกข้อ)
    $pdf->setXY($LM+$idxW,$y);       $pdf->Cell($textW,$rowH,'',1,0,'L');
    $pdf->setXY($LM+$idxW+0.1,$y);
    $pdf->SetFont('angsa','',14);
    $pdf->Cell($textW-0.2,$rowH, iconv('UTF-8','cp874',$questions[$i]),0,0,'L');

    // คะแนน 5..1 + ติ๊ก
    $x = $LM+$idxW+$textW;
    for($s=5;$s>=1;$s--){
      $pdf->setXY($x,$y);            $pdf->Cell($colW,$rowH,'',1,0,'C');
      if((string)$answers[$i] === (string)$s){
        $pdf->Image($mark, $x+($colW/2-0.175), $y+0.12, 0.35, 0.35);
      }
      $x += $colW;
    }
    $y += $rowH;
  }
  return [$y, $idxW, $textW, $colW];
}

/* ===== เริ่มสร้าง PDF ===== */
$pdf = new FPDF('P','cm','A4');
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->SetAutoPageBreak(true, 1.2); // เผื่อก้นหน้าเพิ่มเล็กน้อย
$pdf->AddPage();

// สีตั้งต้น
$pdf->SetDrawColor(0,0,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(255,255,255);

// โลโก้ + หัวเรื่อง
$pdf->SetFont('angsana','BU',18);
$pdf->Image("img/allwell_logo.png", $LM + ($CW/2 - 2.5), 0.5, 5.0, 1.5);
$pdf->Image("img/SGS_ISO 9001_with_UKAS_TCL_HR.jpg", $PW-$RM-3.5, 0.7, 3.5, 1.7);
$pdf->setXY($LM,2.5);
$pdf->MultiCell($CW,0.6, iconv('UTF-8','cp874',"แบบสำรวจความพึงพอใจลูกค้า   (Customer's Satisfaction Questionnaire after sale)"),0,'C');

$y = 3.4;

/* ===== หัวเอกสาร (3 คอลัมน์) ===== */
$col = $CW/3;
$lh  = 0.65;

fieldRow($pdf,$LM,$y,"ชื่อลูกค้า :", $customer_name, 2.2, $col-2.2);
fieldRow($pdf,$LM+$col,$y,"โทรศัพท์ :", $customer_tel, 2.0, $col-2.0);
fieldRow($pdf,$LM+($col*2),$y,"วันที่ :", $date_research, 1.7, $col-1.7);
$y += $lh + 0.35;

fieldRow($pdf,$LM,$y,"เลขที่ IV :", $iv_number_row, 2.2, $col-2.2);
fieldRow($pdf,$LM+$col,$y,"ทีมจัดส่ง :", $team_send, 2.2, $col-2.2);
$y += $lh + 0.5;

// สินค้า (เต็มความกว้าง)
text($pdf,$LM,$y,2.0,$lh,"สินค้า :", 'L',0,false,'angsa',16);
$pdf->setXY($LM+2.0,$y+$lh);
$pdf->Cell($CW-2.0,0,'','T',0,'C');
text($pdf,$LM+2.0,$y,$CW-2.0,$lh,$product_name,'L',0,false,'angsa',14);
$y += $lh + 0.6;

// คำอธิบายสเกล
$pdf->SetFont('angsa','',16);
$pdf->setXY($LM,$y);
$pdf->MultiCell($CW,0.6, iconv('UTF-8','cp874',"โปรดใส่เครื่องหมาย      ลงในช่องที่ท่านเห็นด้วย  (คะแนนการประเมิน มากที่สุด = 5, น้อยที่สุด = 1)"),0,'L');
$pdf->Image("img/23012019.png",$LM+3.35,$y+0.1,0.35,0.35);
$y += 0.9;

/* ===== ส่วนที่ 1 ===== */
$questions_sale = [
  "พนักงานพูดจาสุภาพ มีมารยาท และแต่งกายเหมาะสม",
  "มีความรู้ความเข้าใจเกี่ยวกับสินค้า ให้คำแนะนำได้ชัดเจน",
  "แสดงความใส่ใจ ติดตามผล และให้ความช่วยเหลือหลังการขาย",
];
$answers_sale = [ $sale_neat, $sale_data, $sale_3 ];
list($y,) = drawRatingSection($pdf, "ส่วนที่ 1 ความพึงพอใจต่อพนักงานขาย", $y, $questions_sale, $answers_sale, $LM, $CW);

// ข้อเสนอแนะ 1
$y += 0.2;
$pdf->setXY($LM,$y);  $pdf->Cell($CW,1.2,'',1,0,'C');
text($pdf,$LM+0.2,$y,3.0,0.6,"ข้อเสนอแนะอื่นๆ");
$pdf->setXY($LM+0.2,$y+0.5);
$pdf->MultiCell($CW-0.4,0.6, iconv('UTF-8','cp874',$suggest),0,'L');
$y += 1.0;

/* ===== ส่วนที่ 2 ===== */
$questions_product = [
  "สินค้าตรงตามข้อมูลที่ได้รับก่อนซื้อ และสามารถใช้งานได้จริง",
  "คุณภาพสินค้าตรงตามที่คาดหวัง",
  "ความพึงพอใจในสินค้าโดยรวมที่มีต่อผลิตภัณฑ์ที่ได้รับ",
];
$answers_product = [ $product_good, $product_link, $product_corect ];
list($y,) = drawRatingSection($pdf, "ส่วนที่ 2 ความพึงพอใจต่อสินค้า / ผลิตภัณฑ์", $y+0.3, $questions_product, $answers_product, $LM, $CW);

// ข้อเสนอแนะ 2
$y += 0.2;
$pdf->setXY($LM,$y);  $pdf->Cell($CW,1.2,'',1,0,'C');
text($pdf,$LM+0.2,$y,3.0,0.6,"ข้อเสนอแนะอื่นๆ");
$pdf->setXY($LM+0.2,$y+0.5);
$pdf->MultiCell($CW-0.4,0.6, iconv('UTF-8','cp874',$suggest_1),0,'L');
$y += 1.0;

/* ===== ส่วนที่ 3 ===== */
$questions_cs = [
  "พนักงานจัดส่งสุภาพ แต่งกายเหมาะสม และปฏิบัติตามมาตรการความปลอดภัย",
  "จัดส่งตรงเวลา พร้อมบริการติดตั้ง/สาธิตการใช้งานสินค้า",
  "ประสานงานก่อนส่ง และดูแลจนถึงการส่งมอบเรียบร้อย",
];
$answers_cs = [ $cs_neat, $cs_explain, $cs_3 ];
list($y,) = drawRatingSection($pdf, "ส่วนที่ 3 การสอบถามความพึงพอใจของลูกค้าที่มีต่อการบริการจัดส่ง", $y+0.3, $questions_cs, $answers_cs, $LM, $CW);

// ข้อเสนอแนะ 3
$y += 0.2;
$pdf->setXY($LM,$y);  $pdf->Cell($CW,1.1,'',1,0,'C');
text($pdf,$LM+0.2,$y,3.0,0.6,"ข้อเสนอแนะอื่นๆ");
$pdf->setXY($LM+0.2,$y+0.5);
$pdf->MultiCell($CW-0.4,0.6, iconv('UTF-8','cp874',$suggest_2),0,'L');
$y += 1.5;

/* ===== ลายเซ็น/วันที่ (จัดกึ่งกลาง) ===== */
$boxH = 2.6;          // ความสูงกรอบลายเซ็น
$gapAfterSign = 1.0;  // ระยะเว้นก่อนข้อความปิดท้าย

$pdf->setXY($LM,$y+0.2);
$pdf->Cell($CW, $boxH, '', 1, 0, 'C');

// กำหนดกรอบซ้าย/ขวา
$leftX  = $LM + 0.2;
$leftW  = $CW/2 - 0.4;
$rightX = $LM + $CW/2 + 0.2;
$rightW = $leftW;

// ขนาด/ตำแหน่งรูปเซ็น
$imgW = 3.0; $imgH = 1.1;
$imgY = $y + 0.75;              // ยกลงมานิดให้ไม่ชนหัวข้อ
$lineY = $y + $boxH - 0.9;      // ตำแหน่งเส้นเซ็นชื่อ

// ฝั่งซ้าย (เจ้าหน้าที่) — จัดกึ่งกลางทั้งหมด
text($pdf, $leftX, $y+0.35, $leftW, 0.6, "เจ้าหน้าที่จัดส่ง/เจ้าหน้าที่โทรสอบถาม", 'C');
if(!empty($employee_send)){
  $imgX = $leftX + ($leftW - $imgW)/2;
  $pdf->Image($employee_send, $imgX, $imgY, $imgW, $imgH, 'png');
}
$pdf->setXY($leftX, $lineY); $pdf->Cell($leftW, 0, '', 'T', 0, 'C');
text($pdf, $leftX, $lineY+0.05, $leftW, 0.6, "วันที่ : ".$employee_date, 'C');

// ฝั่งขวา (ผู้รับสินค้า) — จัดกึ่งกลางทั้งหมด
text($pdf, $rightX, $y+0.35, $rightW, 0.6, "ผู้รับสินค้า", 'C');
if(!empty($customer_receive)){
  $imgX = $rightX + ($rightW - $imgW)/2;
  $pdf->Image($customer_receive, $imgX, $imgY, $imgW, $imgH, 'png');
}
$pdf->setXY($rightX, $lineY); $pdf->Cell($rightW, 0, '', 'T', 0, 'C');
text($pdf, $rightX, $lineY+0.05, $rightW, 0.6, "วันที่ : ".$customer_date, 'C');

$y += $boxH + $gapAfterSign;

/* ===== ข้อความปิดท้าย ===== */
$pdf->SetFont('angsa','',14);
$pdf->setXY($LM,$y);
$pdf->MultiCell($CW,0.6, iconv('UTF-8','cp874',"บริษัทขอขอบพระคุณเป็นอย่างสูงที่ท่านได้กรุณาสละเวลาในการเสนอแนะข้อคิดเห็นต่างๆ ในการปฏิบัติงานของเจ้าหน้าที่"),0,'C');
$pdf->setXY($LM,$y+0.7);
$pdf->MultiCell($CW,0.6, iconv('UTF-8','cp874',"โดยได้รับความไว้วางใจเลือกใช้ผลิตภัณฑ์และบริการ บริษัท ฯ หวังเป็นอย่างยิ่งว่า จะมีโอกาสได้รับการบริการจากท่านอีก"),0,'C');
$pdf->setXY($LM,$y+1.4);
$pdf->MultiCell($CW,0.6, iconv('UTF-8','cp874',"หากมีข้อสงสัย หรือพบปัญหา กรุณาติดต่อฝ่ายบริการลูกค้าสัมพันธ์ โทร 0-2424-3555"),0,'C');

$pdf->setXY($LM,$y+2.2);
$pdf->MultiCell($CW/2,0.6, iconv('UTF-8','cp874',"อนุมัติวันที่ 9 ก.ย. 2568"),0,'L');
$pdf->setXY($LM+$CW-4.0,$y+2.2);
$pdf->MultiCell(4.0,0.6, iconv('UTF-8','cp874',"FM-OF-63:Rev.0"),0,'R');

$pdf->Output();
?>
