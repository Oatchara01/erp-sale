<html lang="th">
	<head>
		<meta charset="utf-8">
		<title>รายงานการตรวจสอบสินค้าที่สถานที่ของลูกค้า</title>

	<link rel="stylesheet" href="css/normalize.min.css">
	<link rel="stylesheet" href="css/paper.css">
	<link rel="stylesheet" href="css/w3.css">
		
	<style>
#tableDtel > table, #tableDtel th, #tableDtel td {
    border: 1px solid #202020;
    border-collapse: collapse;
    font-weight: bold;
}
#tableDtel table {
    width: 100%;
}
.Page {
    font: 14pt "Angsana New";
}

@media print {
    .Page {
        display: block !important;
        min-height: auto !important;
        height: auto !important;
    }

    .divFooter {
        margin-top: 20px !important;
    }
}
table, th, td {
  /* border: 1px solid black; 
  border-collapse: collapse; */
}	
		</style>
	</head>



		
<?php
$product_id = $_GET["product_ID"];
$ref_id_br = $_GET["ref_id"];
			
include 'dbconnect.php';
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    if($strYear != '2513'){
        return "$strDay $strMonthThai $strYear";
    } else {
        return "";
    }
}			

function getWarrantyPeriod($warranty_phase) {
    switch ($warranty_phase) {
        case 12:
        case "1year":
            return "1 ปี";
        case 15:
        case "1year.+3month":
            return "1 ปี 3 เดือน";
        case 6:
        case "6month":
            return "6 เดือน";
        case 18:
        case "1year.+6month":
            return "1 ปี 6 เดือน";
        case 20:
        case "1year.+8month":
            return "1 ปี 8 เดือน";
        case 24:
        case "2year":
            return "2 ปี";
        case 36:
        case "3year":
            return "3 ปี";
        case "4year":
            return "4 ปี";
        case 60:
        case "5year":
            return "5 ปี";
        case 99:
        case "LT":
            return "ตลอดอายุการใช้งาน";
        case 0:
            return "ไม่ระบุ";
        default:
            return "ไม่ระบุ";
    }
}

$s_item0 = "SELECT * FROM document_checking WHERE product_id = '".$product_id."' AND ckk = '2' AND type_doc = '1' ORDER BY id DESC ";
$q_item0 = mysqli_query($service,$s_item0);
$n_item0 = mysqli_num_rows($q_item0);
$v_item0 = mysqli_fetch_array($q_item0);
if($n_item0 < 1){
  echo '<a style="text-decoration: none;" href="add_proa.php"><h1><center style="color:#ff8080; margin-top:200px;">ไม่พบใบตรวจเช็คสินค้าเข้าต่างประเทศของท่าน <br>(Checking Details of Imported Product)</h1></center></a>';
  exit;
}

$status = substr($ref_id_br,0,2);
if($status == 'SO'){
   
$sql = "SELECT *   FROM hos__so where ref_id = '".$ref_id_br."'";
    $qry = mysqli_query($conn,$sql) or die(mysqli_error());
    $rs = mysqli_fetch_assoc($qry);
	$bill_name =$rs["bill_name"];    
} else {
 $sql = "SELECT *   FROM hos__br where ref_id_br ='".$ref_id_br."' ";
    $qry = mysqli_query($conn,$sql) or die(mysqli_error());
    $rs = mysqli_fetch_assoc($qry);
$bill_name =$rs["customer"];    
}


$ref_id = $_GET['product_sn'];

$sql1 = "select * from tb_register_data where ref_id = '".$ref_id_br."'";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC);
$address_send =$fetch1["address_send"];

$s_main_a = "SELECT * FROM tb_checking_en_main WHERE  sn_number = '".$ref_id."'  ";
$q_main_a = mysqli_query($service,$s_main_a);
$v_main_a = mysqli_fetch_array($q_main_a);

$strSQL16 = " SELECT service_order_no,product_sn FROM tb_service_order  WHERE  product_sn = '".$v_main_a['sn_number']."' "; 
$objQuery16 = mysqli_query($service,$strSQL16);
$objResult16 = mysqli_fetch_array($objQuery16);

$s_frequency = "SELECT service_order_no,Frequency FROM tb_product_checking_report_new_main WHERE service_order_no = '".$objResult16['service_order_no']."' ";
$q_frequency = mysqli_query($service,$s_frequency);
$v_frequency = mysqli_fetch_array($q_frequency);

$id_fk = $v_main_a['id_fk'];

$s_product = "SELECT sol_name,brand_id,model_id FROM tb_product WHERE product_ID = '".$product_id."' ";
$q_product = mysqli_query($stock,$s_product);
$n_product = mysqli_num_rows($q_product);
$v_product = mysqli_fetch_array($q_product);

$s_item1 = "SELECT * FROM document_checking1 WHERE id_fk = '".$id_fk."' ";
$q_item1 = mysqli_query($service,$s_item1);
$n_item1 = mysqli_num_rows($q_item1);
$v_item1 = mysqli_fetch_array($q_item1);
$s_item2 = "SELECT * FROM document_checking2 WHERE id_fk = '".$id_fk."' ";
$q_item2 = mysqli_query($service,$s_item2);
$n_item2 = mysqli_num_rows($q_item2);
$v_item2 = mysqli_fetch_array($q_item2);
$s_item3 = "SELECT * FROM document_checking3 WHERE id_fk = '".$id_fk."' ";
$q_item3 = mysqli_query($service,$s_item3);
$n_item3 = mysqli_num_rows($q_item3);
$v_item3 = mysqli_fetch_array($q_item3);
$s_item4 = "SELECT * FROM document_checking4 WHERE id_fk = '".$id_fk."' AND type_doc = '1' ";
$q_item4 = mysqli_query($service,$s_item4);
$n_item4 = mysqli_num_rows($q_item4);
$v_item4 = mysqli_fetch_array($q_item4);

$s_main = "SELECT * FROM tb_checking_en_main WHERE id = '".$v_main_a['id']."' ";
$q_main = mysqli_query($service,$s_main);
$n_main = mysqli_num_rows($q_main);
$v_main = mysqli_fetch_array($q_main);

$s_img = "SELECT * FROM tb_checking_images WHERE po_no = '".$v_main['po_no']."' and sn_number = '".$v_main['sn_number']."' ";
$q_img = mysqli_query($service,$s_img);
$n_img = mysqli_num_rows($q_img);
$v_img = mysqli_fetch_array($q_img); //window.print();onload="javascript:settimeout('self.close()',500);"	



$s_check1 = "SELECT * FROM tb_service_check WHERE product_sn = '".$v_main['sn_number']."' AND service_check_terms = '1' ";
$q_check1 = mysqli_query($service,$s_check1);
$n_check1 = mysqli_num_rows($q_check1);
$v_check1 = mysqli_fetch_array($q_check1);

$s_so = "SELECT delivery_date FROM hos__so WHERE ref_id = '".$ref_id_br."' ";
$q_so = mysqli_query($conn,$s_so);
$n_so = mysqli_num_rows($q_so);
$v_so = mysqli_fetch_array($q_so);

$s_subso = "SELECT * FROM hos__subso WHERE ref_idd = '".$ref_id_br."' AND sn != '' ";
$q_subso = mysqli_query($conn,$s_subso);
$n_subso = mysqli_num_rows($q_subso);
$v_subso = mysqli_fetch_array($q_subso);

$s_check2 = "SELECT * FROM tb_service_check WHERE product_sn = '".$v_main['sn_number']."' AND service_check_terms = '2' ";
$q_check2 = mysqli_query($service,$s_check2);
$n_check2 = mysqli_num_rows($q_check2);
$v_check2 = mysqli_fetch_array($q_check2);



$s_warranty = "SELECT * FROM tb_installation_data WHERE product_sn = '".$v_main['sn_number']."' ";
$q_warranty = mysqli_query($service,$s_warranty);
$v_warranty = mysqli_fetch_array($q_warranty);
?>
<body class="A4">			
<section class="Page 1 A4 sheet padding-10mm">

<header>
            <div class="w3-half"  style="text-align: left; font-size: 15px;">
            <?php echo $v_item1['company_thai'];?><br></div>
            <div class="w3-half" style="text-align: right; font-size: 15px;"><?php echo $v_item1['company_eng'];?><br></div>
            <div class="w3-bar w3-border"></div>
            <div class="w3-half"  style="text-align: left; font-size: 15px;">
                73,75 ซอยจรัญสนิทวงศ์ 89/2 ถนนจรัญสนิทวงศ์ แขวงบางอ้อ<br>
                เขตบางพลัด กรุงเทพฯ 10700<br>
                โทร : 0-2424-3555 แฟ็กซ์ : 0-2424-3322 <br>
                E-mail : service@allwelllifegroup.com
            </div>
            <div class="w3-half" style="text-align: right; font-size: 15px;">
                
                73,75 Charansanitwong Rd., Bang-Or,<br>
                Bang-Plad, Bangkok 10700<br>
                Tel : 0-2424-3555 Fax : 0-2424-3322<br> E-mail : service@allwelllifegroup.com
            </div>
        </header>
			
<center><div style="font-size: 18px;"><b>รายงานการตรวจสอบสินค้าที่สถานที่ของลูกค้า</b></div></center>
<center><div style="font-size: 18px;"><b>(Product-Checking Report at Customer' Location)</b></div></center><br>
	
<table style="width: 100%; border-collapse: collapse;">
    <tr style="font-size: 15px;">
        <td style="border: 1px solid black;">Hospital/Customer: <?php echo $bill_name; ?></td>
        <td style="border: 1px solid black;">Department/Room: <?=$fetch1["address_name"];?></td>
        <td style="border: 1px solid black;">Date: : <?=DateThai($rs['delivery_date']);?></td> <!-- วันที่ส่งสินค้า -->
    </tr>
    <tr  style="font-size: 15px;">
        <td style="border: 1px solid black;">Equipment Name : <?=$v_item0['model_id'];?></td>
        <td style="border: 1px solid black;">S/N : <?=$v_main['sn_number'];?></td>
        <td style="border: 1px solid black;">W/O,IV : <?=$rs['iv_no'];?></td> <!-- เลขที่ IV ใน ERP SALE -->
    </tr>
    <tr  style="font-size: 15px;">
        <td style="border: 1px solid black; vertical-align: top;">Frequency</td>
        <td style="border: 1px solid black; border-left: hidden; padding:8px 0px;">
            <font style="font-size:15px; padding:0px 6px; border: 1px solid #202020;"><?php if($v_frequency['Frequency'] == '3'){ echo '&#10003;'; } else { echo '&nbsp;&nbsp;&nbsp;&nbsp;';} ?></font> 3 Months 
            <br><br>
             <font style="font-size:15px; padding:0px 6px; border: 1px solid #202020;"><?php if($v_frequency['Frequency'] == '6'){ echo '&#10003;'; } else { echo '&nbsp;&nbsp;&nbsp;&nbsp;';} ?></font> 6 Months
        </td>
        <td style="border: 1px solid black; border-left: hidden; padding:8px 0px;">
            <font style="font-size:15px; padding:0px 6px; border: 1px solid #202020;"><?php if($v_frequency['Frequency'] == '4'){ echo '&#10003;'; } else { echo '&nbsp;&nbsp;&nbsp;';} ?></font> 4 Months 
            <br><br>
             <font style="font-size:15px; padding:0px 6px; border: 1px solid #202020;"><?php if($v_frequency['Frequency'] == '12'){ echo '&#10003;'; } else { echo '&nbsp;&nbsp;&nbsp;&nbsp;';} ?></font> 1 Year
        </td>
    </tr>
</table>
<div style="display: grid; place-items: center; padding:20px 0px 0px 0px;">
    <div style="width: 150px; display: flex; justify-content: space-between;">
        Inspected <span style="width: 30px; text-align:center; font-size:15px; padding:0px 6px; border: 1px solid #202020; ">&#10003;</span>
    </div>
    <div style="width: 150px; display: flex; justify-content: space-between;">
        Damaged <span style="width: 30px; text-align:center; font-size:15px; padding:0px 6px; border: 1px solid #202020; border-top:1px; border-bottom:1px;">D</span>
    </div>
    <div style="width: 150px; display: flex; justify-content: space-between;">
        Not Applicable <span style="width: 30px; text-align:center; font-size:15px; padding:0px 6px; border: 1px solid #202020; ">N/A</span>
    </div>
</div>
<br>
Visual cheok and rectify
<table style="width: 100%;" >
<td style="width: 50%; vertical-align:top; padding:0px;">
            <!--  -->
        <table style="width: 100%; border-collapse: collapse;"  >
            <td style="width: 85%; "><b>1.Mechanical Inspection / Operation</b></td>
            <td style="width: 15%; text-align: center;">ผ่าน</td>
        <?php
        $numrows_03 = 1;
        $s_key = "SELECT c2_1.item_id,c2_1.ckk_subtopic,c2_1.subtopic,c2.item_name,c2.images_main
        FROM document_checking2_1  c2_1
        LEFT JOIN document_checking2 c2
        ON c2_1.item_id = c2.id
        WHERE c2.item_id = 3 and c2_1.id_fk = '".$id_fk."' ";

        $q_key = mysqli_query($service,$s_key);
        $n_key = mysqli_num_rows($q_key);?>
        <input type="hidden" name="n_key3" id="n_key3" value="<?=$n_key;?>">
        <?php while($v_key = mysqli_fetch_array($q_key)){ 
        $s_ck1 = "SELECT ckk_list1,ckk_list2,ckk_list3,t_list1,item_id FROM tb_checking_en WHERE item_id = '".$v_key['item_id']."' and po_no = '".$v_main['po_no']."' and sn_number = '".$v_main['sn_number']."' ";
        $q_ck1 = mysqli_query($service,$s_ck1);
        $n_ck1 = mysqli_num_rows($q_ck1);
        $v_ck1 = mysqli_fetch_array($q_ck1); 
        ?>
        <tr style="text-align: left;">
            <td style="width: 85%;"><?php if($v_key['images_main'] != ''){?><a style="text-decoration: none;" href="up_img/<?php echo $v_key['images_main'];?>" target="_blank"><?=$v_key['item_name'];?></a><?php } else { echo $v_key['item_name']; }?><input type="hidden" name="key_id3" id="key_id3" value="<?=$numrows_03;?>"></td>
            <td style="width: 15%; border: 1px solid black;  text-align: center;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['ckk_list1'] == 2){?>&#10003;<?}?></td>
        </tr>
        <?php $numrows_03++; } ?>
        
        </table>
            <!--  -->
</td>

<td style="width: 50%; vertical-align: top; padding-left:-20px;">

    <table style="width: 100%; border-collapse: collapse;" >
    <tr>
        <td style="width: 70%;"><b>2.Safety Testing</b></td>
        <td style="width: 15%; text-align: center;">ค่าที่วัดได้</td>
        <td style="width: 15%; text-align: center;">ผ่าน</td>
    </tr>
    <?php
    $numrows_04 = 1;
    $s_key = "SELECT c2_1.item_id,c2_1.ckk_subtopic,c2_1.subtopic,c2.item_name
    FROM document_checking2_1  c2_1
    LEFT JOIN document_checking2 c2
    ON c2_1.item_id = c2.id
    WHERE c2.item_id = 4 and c2_1.id_fk = '".$id_fk."' ";

    $q_key = mysqli_query($service,$s_key);
    $n_key = mysqli_num_rows($q_key);?>
    <input type="hidden" name="n_key4" id="n_key4" value="<?=$n_key;?>">
    <?php while($v_key = mysqli_fetch_array($q_key)){ 
    $s_ck1 = "SELECT ckk_list1,ckk_list2,ckk_list3,t_list1,item_id FROM tb_checking_en WHERE item_id = '".$v_key['item_id']."' and po_no = '".$v_main['po_no']."' and sn_number = '".$v_main['sn_number']."' ";
    $q_ck1 = mysqli_query($service,$s_ck1);
    $n_ck1 = mysqli_num_rows($q_ck1);
    $v_ck1 = mysqli_fetch_array($q_ck1); 
    ?>
    <tr style="text-align: left; " >
        <td style="width: 70%;"><?php if($v_key['images_main'] != ''){?><a style="text-decoration: none;" href="up_img/<?php echo $v_key['images_main'];?>" target="_blank"><?=$v_key['item_name'];?></a><?php } else { echo $v_key['item_name']; }?><input type="hidden" name="key_id4" id="key_id4" value="<?=$numrows_04;?>"></td>
        <td style="width: 15%; border: 1px solid black; text-align:center;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['t_list1'] != ''){ echo $v_ck1['t_list1']; }?></td>
        <td style="width: 15%; border: 1px solid black; text-align:center;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['ckk_list1'] == 2){?>&#10003;<?}?></td>
    </tr>
    <?php $numrows_04++; } ?>
    </table>

</td>
</tr>
</table>
<br><br>
<div style="font-size: 18px; text-align: left;"><b>รายละเอียดเพิ่มเติม :</b></div>
<br><div class="w3-bar w3-border w3-black"></div>
<br><div class="w3-bar w3-border w3-black"></div>
<br><div class="w3-bar w3-border w3-black"></div>

<br><br>


 <table style="width:720px" border=0>
	   <tr>
<td style="width:50%; text-align:center;"><u> <?php echo $v_main_a['add_name1'];?> / <?=DateThai($rs['delivery_date']);?> <?php // echo DateThai($v_main_a['add_date1']);?> </u></td>
<td style="width:50%; text-align:center;"><u> <?php echo $v_main_a['add_name2'];?> / <?=DateThai($rs['delivery_date']);?> <?php // echo DateThai($v_main_a['add_date2']);?> </u></td>
            </tr>
	 
	 
            <tr>
                <td style="width:50%; text-align:center;">Performed by</td>
                <td style="width:50%; text-align:center;">Approved by</td>
            </tr>
        </table>

<div class="divFooter">
        <div class="w3-bar w3-border"></div>
        <table style="width:720px" border=0>
            <tr>
                <td style="width:50%; text-align:left;">อนุมัติวันที่ <?php echo $v_item4['add_day'];?></td>
                <td style="width:50%; text-align:right;">เลขที่เอกสาร <?php echo $v_item4['id_doc'];?></td>
            </tr>
        </table>
    </div>      	

		</section>
        <!-- <section class="Page 1 A4 sheet padding-10mm"> -->
     <section class="Page 1 A4 landscape padding-10mm" style="background-color: #FFFFFF; padding:40px; margin:2%;">

<?php
    // ====== CONFIG ======
    $warranty_year = (int)$v_subso['warranty'];   // ปีประกัน
    $pm_per_year   = (int)$v_subso['pm'];         // PM ต่อปี

    // fallback กัน error
    if ($warranty_year <= 0) $warranty_year = 1;
    if ($pm_per_year <= 0)   $pm_per_year = 1;

    // จำนวนครั้ง PM ทั้งหมด
    $total_pm = $warranty_year * $pm_per_year;

    // วันที่เริ่ม
    if (!empty($v_warranty['install_date']) && $v_warranty['install_date'] != '0000-00-00') {
        $start_date = $v_warranty['install_date'];
    } else {
        $start_date = $v_so['delivery_date'];
    }

    // interval ต่อครั้ง (เดือน)
    $interval_month = floor(12 / $pm_per_year);
    if ($interval_month <= 0) $interval_month = 12;
?>

<div>
    <center><b>แผนการบำรุงรักษาเครื่องมือแพทย์ <br> MAINTENANCE SCHEDULE</b></center>

    <div style="display:flex; justify-content:space-between; font-weight:bold; margin-top:10px;">
        <div>
            <span>ชื่อลูกค้า <?=$bill_name;?> </span>
            <span style="margin-left: 50px;">PO <?=$rs['po_no'];?></span>
        </div>

        <div>
            รับประกัน <?= getWarrantyPeriod($v_warranty["warranty_phase"]); ?>
        </div>
    </div>

    <div id="tableDtel" style="margin-top:10px;">
        <table>
            <tr>
                <th rowspan="2">สินค้า</th>
                <th rowspan="2">หมายเลขเครื่อง</th>
                <th rowspan="2">ความถี่/ปี</th>
                <th colspan="<?= $total_pm * 2; ?>">รอบ PM ทั้งหมด</th>
            </tr>

            <tr>
                <?php for ($i = 1; $i <= $total_pm; $i++) { ?>
                    <th>ครั้งที่ <?= $i; ?></th>
                    <th>เซ็น</th>
                <?php } ?>
            </tr>

            <tr>
                <td style="text-align:center;">
                    <?=$v_item0['model_id'];?>
                </td>

                <td style="text-align:center;">
                    <?=$v_main['sn_number'];?>
                </td>

                <td style="text-align:center;">
                    <?=$pm_per_year;?>
                </td>

                <?php
                for ($i = 1; $i <= $total_pm; $i++) {
                    $pm_date = date('Y-m-d', strtotime($start_date . ' +' . (($i - 1) * $interval_month) . ' months'));
                ?>
                    <td style="text-align:center;">
                        <?= DateThai($pm_date); ?>
                    </td>
                    <td>&nbsp;</td>
                <?php } ?>
            </tr>
        </table>
    </div>
</div>

<div style="margin-top:20px; padding-left:10%;">
    <p>การบำรุงรักษาโดยเจ้าหน้าที่ของบริษัท ตามความเหมาะสมของแผนงาน</p>
    <p>กำหนดเข้าบำรุงรักษา <?= $pm_per_year; ?> ครั้ง/ปี</p>

    <p style="font-weight:bold;">หมายเหตุ</p>
    <hr style="border:1px solid #202020;">
    <hr style="border:1px solid #202020;">
    <hr style="border:1px solid #202020;">

    <p style="font-weight:bold;">
        จัดจำหน่ายและบริการหลังการขายโดย บริษัท ออลล์เวล ไลฟ์ จำกัด 02-424-3555
    </p>
</div>

</section>
	</body>
</html>			
			