<?php 


$product_id = $_GET["product_ID"];
$ref_id_br = $_GET["ref_id"];
?>
<?php include ("checksession.php");
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<style>
  td{font-size: .875em; background-color: #FFFFFF;}
  .comment01{background-color: #fff;}
  .checking_content td{text-align: center; }
  .checking_content input{ background-color: #fff;}
  .checking_content textarea{ background-color: #fff;}
  .checking_content table table td{border-collapse: collapse;}
  .checking_content td:nth-child(1){text-align: left;}
  .radio_ckk1{accent-color: #80ff80;}
  .radio_ckk2{accent-color: #ff8080;}
  table,th,td{
    border: 1px solid #202020;
  }
  input{
    border:hidden;
  }
</style>


<form action="" method="post"  enctype="multipart/form-data">
<div class="container-xl">
<?php 

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
<input type="hidden" name="id_fk" id="id_fk" value="<?=$id_fk;?>">
<input type="hidden" name="product_id" id="product_id" value="<?=$product_id;?>">
<input type="hidden" name="po_no" id="po_no" value="<?=$po_no0;?>">

<body >
<!-- Contacts/Document name -->
	
<section class="row mt-5">
  <aside class="col-6"><pre><?php echo $v_item1['company_thai'];?></pre></aside>
  <aside style="text-align: right;" class="col-6"><pre><?php echo $v_item1['company_eng'];?></pre></aside>
  <aside class="col-6"><pre><?php echo $v_item1['address_thai'];?></pre></aside>
  <aside style="text-align: right;"class="col-6"><pre><?php echo $v_item1['address_eng'];?></pre></aside>
  <aside class="col-12 text-center"><pre><b><?php echo $v_item1['doc_name_thai'];?></b></pre></aside>
  <aside class="col-12 text-center"><pre><b><?php echo $v_item1['doc_name_eng'];?></b></pre></aside>
</section>



<main class="my-5 p-3">
<!-- haed -->
<section>
  <table style="width: 100%;border: 1px solid #e0e0e0;">
<tr>
  <td>Hospital/Customer: <?php echo $bill_name; ?></td>
  <td>Department/Room: <?=$fetch1["address_name"];?></td>
  <td>Date: PO : <?=$v_main['po_no'];?></td>
</tr>
<tr>
  <td>Equipment Name : <?=$v_item0['model_id'];?></td>
  <td>S/N : <?=$v_main['sn_number'];?></td>
  <td>W/O :<?=$v_main['po_no'];?></td>
</tr>

</table>
</section>
<!-- Add a document to view details. -->
<section>
<div class="checking_content">
<table style="width: 100%;">
    <td style="width: 50%; vertical-align: top;">
    <table style="width: 100%;" >
        <tr>
          <td style="width: 44%;"><b>1.ตรวจเช็กความสมบูรณ์ของอุปกรณ์</b></td>
          <td style="width: 18%;">ผ่านการตรวจสอบ</td>
          <td style="width: 20%;">อุปกรณ์ชำรุด</td>
          <td style="width: 18%;">ไม่พบอุปกรณ์</td>
        </tr>
<?php
$numrows_01 = 1;
$s_key = "SELECT c2_1.item_id,c2_1.ckk_subtopic,c2_1.subtopic,c2.item_name,c2.images_main
FROM document_checking2_1  c2_1
LEFT JOIN document_checking2 c2
ON c2_1.item_id = c2.id
WHERE c2.item_id = 1 and c2_1.id_fk = '".$id_fk."' ";

$q_key = mysqli_query($service,$s_key);
$n_key = mysqli_num_rows($q_key);?>
<input type="hidden" name="n_key1" id="n_key1" value="<?=$n_key;?>">
<?php while($v_key = mysqli_fetch_array($q_key)){ 
   $s_ck1 = "SELECT ckk_list1,ckk_list2,ckk_list3,t_list1,item_id FROM tb_checking_en WHERE item_id = '".$v_key['item_id']."' and po_no = '".$v_main['po_no']."' and sn_number = '".$v_main['sn_number']."' ";
   $q_ck1 = mysqli_query($service,$s_ck1);
   $n_ck1 = mysqli_num_rows($q_ck1);
   $v_ck1 = mysqli_fetch_array($q_ck1); 
?>
        <tr>
          <td style="width: 44%;"><?php if($v_key['images_main'] != ''){?><a style="text-decoration: none;" href="up_img/<?php echo $v_key['images_main'];?>" target="_blank"><?=$v_key['item_name'];?></a><?php } else { echo $v_key['item_name']; }?><input type="hidden" name="key_id1" id="key_id1" value="<?=$numrows_01;?>"></td>
          <td style="width: 18%;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['ckk_list1'] == 1){?>&#10003;<?}?></td>
          <td style="width: 20%;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['ckk_list1'] == 2){?>&#10003;<?}?></td>
          <td style="width: 18%;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['ckk_list1'] == 3){?>&#10003;<?}?></td>
        </tr>
<?php $numrows_01++; } ?>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr><td colspan="4"><b>2.ยี่ห้อมอเตอร์และชุดควบคุม</b></td></tr>
        </tr>
<?php
$numrows_02 = 1;
$s_key = "SELECT c2_1.item_id,c2_1.ckk_subtopic,c2_1.subtopic,c2.item_name,c2.images_main
FROM document_checking2_1  c2_1
LEFT JOIN document_checking2 c2
ON c2_1.item_id = c2.id
WHERE c2.item_id = 2 and c2_1.id_fk = '".$id_fk."' ";

$q_key = mysqli_query($service,$s_key);
$n_key = mysqli_num_rows($q_key);?>
<input type="hidden" name="n_key2" id="n_key2" value="<?=$n_key;?>">
<?php while($v_key = mysqli_fetch_array($q_key)){ 
    $s_ck1 = "SELECT ckk_list1,ckk_list2,ckk_list3,t_list1,item_id FROM tb_checking_en WHERE item_id = '".$v_key['item_id']."' and po_no = '".$v_main['po_no']."' and sn_number = '".$v_main['sn_number']."' ";
    $q_ck1 = mysqli_query($service,$s_ck1);
    $n_ck1 = mysqli_num_rows($q_ck1);
    $v_ck1 = mysqli_fetch_array($q_ck1); 
?>
        <tr>
          <td style="width: 44%;"><?php if($v_key['images_main'] != ''){?><a style="text-decoration: none;" href="up_img/<?php echo $v_key['images_main'];?>" target="_blank"><?=$v_key['item_name'];?></a><?php } else { echo $v_key['item_name']; }?><input type="hidden" name="key_id2" id="key_id2" value="<?=$numrows_02;?>"></td>
          <td style="width: 18%;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['ckk_list1'] == 1){?>&#10003;<?}?></td>
          <td style="width: 20%;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['ckk_list1'] == 2){?>&#10003;<?}?></td>
          <td style="width: 18%;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['ckk_list1'] == 3){?>&#10003;<?}?></td>
        </tr>
<?php $numrows_02++; } ?>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr><td colspan="4"><b>5.ตรงตาม Order ที่สั่งมา</b></td></tr>
        </tr>
<?php
$numrows_05 = 1;
$s_key = "SELECT c2_1.item_id,c2_1.ckk_subtopic,c2_1.subtopic,c2.item_name,c2.images_main
FROM document_checking2_1  c2_1
LEFT JOIN document_checking2 c2
ON c2_1.item_id = c2.id
WHERE c2.item_id = 5 and c2_1.id_fk = '".$id_fk."' ";

$q_key = mysqli_query($service,$s_key);
$n_key = mysqli_num_rows($q_key);?>
<input type="hidden" name="n_key5" id="n_key5" value="<?=$n_key;?>">
<?php while($v_key = mysqli_fetch_array($q_key)){ 
    $s_ck1 = "SELECT ckk_list1,ckk_list2,ckk_list3,t_list1,item_id FROM tb_checking_en WHERE item_id = '".$v_key['item_id']."' and po_no = '".$v_main['po_no']."' and sn_number = '".$v_main['sn_number']."' ";
    $q_ck1 = mysqli_query($service,$s_ck1);
    $n_ck1 = mysqli_num_rows($q_ck1);
    $v_ck1 = mysqli_fetch_array($q_ck1); 
?>
        <tr>
          <td style="width: 44%;"><?php if($v_key['images_main'] != ''){?><a style="text-decoration: none;" href="up_img/<?php echo $v_key['images_main'];?>" target="_blank"><?=$v_key['item_name'];?></a><?php } else { echo $v_key['item_name']; }?><input type="hidden" name="key_id5" id="key_id5" value="<?=$numrows_05;?>"></td>
          <td style="width: 18%;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['ckk_list1'] == 1){?>&#10003;<?}?></td>
          <td style="width: 20%;"></td>
          <td style="width: 18%;"></td>
        </tr>
<?php $numrows_05++; } ?>
    </table>
    </td>
    <td style="width: 50%; vertical-align: top;">
    <table style="width: 100%;" >
        <tr>
          <td style="width: 40%;"><b>3.ทดสอบการปรับใช้งาน</b></td>
          <td style="width: 20%;"></td>
          <td style="width: 20%;">ผ่าน</td>
          <td style="width: 20%;">ไม่ผ่าน</td>
        </tr></tr>
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
        <tr>
          <td style="width: 40%;"><?php if($v_key['images_main'] != ''){?><a style="text-decoration: none;" href="up_img/<?php echo $v_key['images_main'];?>" target="_blank"><?=$v_key['item_name'];?></a><?php } else { echo $v_key['item_name']; }?><input type="hidden" name="key_id3" id="key_id3" value="<?=$numrows_03;?>"></td>
          <td style="width: 20%;"></td>
          <td style="width: 20%;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['ckk_list1'] == 2){?>&#10003;<?}?></td>
          <td style="width: 20%;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['ckk_list1'] == 3){?>&#10003;<?}?></td>
        </tr>
<?php $numrows_03++; } ?>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr>
          <td style="width: 40%;"><b>4.การทดสอบค่าความปลอดภัย</b></td>
          <td style="width: 20%;">ค่าที่วัดได้</td>
          <td style="width: 20%;">ผ่าน</td>
          <td style="width: 20%;">ไม่ผ่าน</td>
        </tr></tr>
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
        <tr>
          <td style="width: 40%;"><?php if($v_key['images_main'] != ''){?><a style="text-decoration: none;" href="up_img/<?php echo $v_key['images_main'];?>" target="_blank"><?=$v_key['item_name'];?></a><?php } else { echo $v_key['item_name']; }?><input type="hidden" name="key_id4" id="key_id4" value="<?=$numrows_04;?>"></td>
          <td style="width: 20%; text-align:left;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['t_list1'] != ''){ echo $v_ck1['t_list1']; }?></td>
          <td style="width: 20%;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['ckk_list1'] == 2){?>&#10003;<?}?></td>
          <td style="width: 20%;"><?php if(($v_key['item_id'] == $v_ck1['item_id']) AND $v_ck1['ckk_list1'] == 3){?>&#10003;<?}?></td>
        </tr>
<?php $numrows_04++; } ?>
    </table>
    </td>
  </tr>
</table>
</div>
</section>
</main>

<!-- comment -->
<section class="my-5 p-3">
  <div class="row">
    <div class="col-sm-12">
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">รายละเอียดเพิ่มเติม :</label><?=$v_main['remark'];?>
      </div>
    </div>
  </div>
</section>

<!-- End document -->
<section class="row mt-5">
  <aside class="col-6 text-center mt-5"><input class="comment01" style="width: 50%; text-align:center;" type="text" value="<?php echo $v_main_a['add_name1'];?>" disabled><input class="comment01" style="width: 45%; margin-left: 5px; text-align:center;" type="text" value="<?php echo DateThai($v_main_a['add_date1']);?>" disabled><div style="border-top: 1px dashed #202020; margin-top:5px; padding-top:10px;">ผู้ตรวจเช็ก / วันที่</div></aside>
  <aside class="col-6 text-center mt-5"><input class="comment01" style="width: 50%; text-align:center;" type="text" value="<?php echo $v_main_a['add_name2'];?>" disabled><input class="comment01" style="width: 45%; text-align:center; margin-left: 5px;" type="text" value="<?php echo DateThai($v_main_a['add_date2']);?>" disabled><div style="border-top: 1px dashed #202020; margin-top:5px; padding-top:10px;">ผู้ตรวจสอบ / วันที่</div></aside>
</section>

<!-- Document ID	 -->
<section class="row mt-5 mb-5">
  <aside class="col-6" style="text-align: left;">อนุมัติวันที่ <?php echo $v_item4['add_day'];?></aside>
  <aside class="col-6" style="text-align: right;">เลขที่เอกสาร <?php echo $v_item4['id_doc'];?></aside>
</section>

</div>
</form>
</body>
</html>