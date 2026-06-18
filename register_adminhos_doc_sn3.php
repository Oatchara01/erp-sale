<html lang="th">
	<head>
		<meta charset="utf-8">
		<title>รายงานการตรวจสอบสินค้าที่สถานที่ของลูกค้า</title>

	<link rel="stylesheet" href="css/normalize.min.css">
	<link rel="stylesheet" href="css/paper.css">
	<link rel="stylesheet" href="css/w3.css">
		
	<style>
.Page {
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* ให้ section สูงเท่ากับความสูงของหน้าจอหรือเนื้อหา */
	font: 14pt "Angsana New";
}

.divFooter {
    margin-top: auto; /* ดัน divFooter ไปอยู่ด้านล่างของ section */
    width: 100%; /* ให้แน่ใจว่า footer กินพื้นที่เต็ม section */
}

@media screen, print {
    .Page {
        display: flex;
        flex-direction: column;
        min-height: 100vh; /* ให้แน่ใจว่ามีความสูงเพียงพอสำหรับ footer */
    }

    .divFooter {
        margin-top: auto;
		
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
    return "$strDay $strMonthThai $strYear";
}			
			
			
$s_item0 = "SELECT * FROM document_checking WHERE product_id = '".$product_id."' and ckk = '2' ORDER BY id DESC ";
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
$s_item4 = "SELECT * FROM document_checking4 WHERE id_fk = '".$id_fk."' ";
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
			
			?>
<body class="A4">			
<section class="Page 1 A4 sheet padding-10mm">

<header>
            <div class="w3-half"  style="text-align: left; font-size: 15px;">
             <?php echo $v_item1['company_thai'];?><br>
			 </div>
            <div class="w3-half" style="text-align: right; font-size: 15px;">
             <?php echo $v_item1['company_eng'];?><br>
            </div>
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
	
<table style="width: 100%; border-collapse: collapse;" >
<tr style="font-size: 15px;">
  <td style="border: 1px solid black;">Hospital/Customer: <?php echo $bill_name; ?></td>
  <td style="border: 1px solid black;">Department/Room: <?=$fetch1["address_name"];?></td>
  <td style="border: 1px solid black;">Date: PO : <?=$v_main['po_no'];?></td>
</tr>
<tr  style="font-size: 15px;">
  <td style="border: 1px solid black;">Equipment Name : <?=$v_item0['model_id'];?></td>
  <td style="border: 1px solid black;">S/N : <?=$v_main['sn_number'];?></td>
  <td style="border: 1px solid black;">W/O :<?=$v_main['po_no'];?></td>
</tr>

</table>
<br>
<table style="width: 100%;" >
<td style="width: 50%; vertical-align:top; padding:0px;">
            <!--  -->
        <table style="width: 100%; border-collapse: collapse;"  >
            <td style="width: 85%; "><b>1.ทดสอบการปรับใช้งาน</b></td>
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
        <td style="width: 70%;"><b>2.การทดสอบค่าความปลอดภัย</b></td>
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
<td style="width:50%; text-align:center;"><u> <?php echo $v_main_a['add_name1'];?> / <?php echo DateThai($v_main_a['add_date1']);?> </u></td>
<td style="width:50%; text-align:center;"><u> <?php echo $v_main_a['add_name2'];?> / <?php echo DateThai($v_main_a['add_date2']);?> </u></td>
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
                <td style="width:50%; text-align:left;">อนุมัติวันที่ 12 มิ.ย. 2566</td>
                <td style="width:50%; text-align:right;">เลขที่เอกสาร FM-EN-27:Rev.0</td>
            </tr>
        </table>
    </div>      	

		</section>
	</body>
</html>			
			