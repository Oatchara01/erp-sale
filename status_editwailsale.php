<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
  <div class="w3-container w3-padding-large">
    <div class="w3-panel w3-light-gray"><h4>Status เอกสารส่งกลับแก้ไข</h4></div>
  </div>



<?php
// ==============================
// เริ่มต้นใช้งาน
// ==============================
$to_day = date('Y-m-d');
include "dbconnect.php";
session_start();


$user_type = $_SESSION['user_type'] ?? '';
$emid      = $_SESSION['code'] ?? '';

// ==============================
// 1) เงื่อนไขการเห็นเขต ($sddd) — คงตามที่คุณระบุ
// ==============================
if ($emid=='SS1'){
	
$sddd = " and sale_code IN ('S15','S16','S21','S22','SS1')";
	
$sddd2 = " and employee_name IN ('S15','S16','S21','S22','SS1')";
	
} else if ($emid=='SS2'){
	
$sddd = " and sale_code IN ('S11','S12','S17','S24','SS2')";	
	
$sddd2 = " and employee_name IN ('S11','S12','S17','S24','SS2')";	
	
	
} else if ($emid=='SS3'){
	
$sddd = " and sale_code IN ('S31','S32','S33','MM1','SM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL0','SOL99')";
	
$sddd2 = " and employee_name IN ('S31','S32','S33','MM1','SM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL0','SOL99')";
	
} else if ($emid=='SUP_MK'){
	
  $sddd = " and sale_code  IN ('SOL91','SOL92','SOL93','SOL94','MK') ";	
  $sddd2 = " and employee_name   IN ('SOL91','SOL92','SOL93','SOL94','MK') ";	
	
} else if ($emid=='SM1'){
	
  $sddd = " and sale_code IN ('MM2','SM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL0','SOL99')";
  $sddd2 = " and employee_name IN ('MM2','SM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL0','SOL99')";
	
} else if ($emid=='SUP_EN'){
	
  $sddd = " and sale_code LIKE '%EN%'";	
  $sddd2 = " and employee_name LIKE '%EN%'";	
	
} else if ($user_type=='Engineer'){
	
  $sddd = " and sale_code LIKE '%EN%'";	
  $sddd2 = " and employee_name LIKE '%EN%'";	
	
}else if($_SESSION['name']=='กนกพร' or $_SESSION['name']=='นิรชา' or $_SESSION['name']=='รัชดาภรณ์' or $_SESSION['name']=='ธนบัตร' ){	
$sddd = " and sale_code  IN ('SM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL0','SOL99') ";
  $sddd2 = " and employee_name  IN ('SM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL0','SOL99') ";		
	
}else if($_SESSION['name']=='อัจฉรา' or $_SESSION['name']=='สุภัสสร' or $_SESSION['name']=='บรรจบพร' or $_SESSION['name']=='ขนิษฐา' or $_SESSION['name']=='พิมพ์ชนก' ){	
	
  $sddd = "";
  $sddd2 = "";	
	
} else {
  $sddd = " and sale_code = '".$emid."' ";
  $sddd2 = " and employee_name = '".$emid."' ";		
}

// helper: ชี้บ่ง sale_code ให้เป็น <table>.sale_code อัตโนมัติ
function qualifySaleCode(string $sddd, string $tableName): string {
  return preg_replace('/(?<!\.)\bsale_code\b/', $tableName.'.sale_code', $sddd);
}

// helper: ดึงข้อความล่าสุดของการส่งกลับแก้ไข
function getLastEdit(mysqli $conn, string $refId) {
  $sql = "SELECT sale_edit, add_by FROM tb_editdoc WHERE ref_id='{$refId}' ORDER BY id DESC";
  $qry = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  return mysqli_fetch_assoc($qry);
}

// ==============================
// 2) ตาราง hos__so
// ==============================
$sddd_so = qualifySaleCode($sddd, 'hos__so');
$strSQL = "
  SELECT hos__so.*, e.sale_edit, e.add_by
  FROM hos__so
  INNER JOIN (
    SELECT ref_id, MAX(id) AS max_id
    FROM tb_editdoc
    WHERE sale_edit IS NOT NULL AND sale_edit <> ''
    GROUP BY ref_id
  ) le ON le.ref_id = hos__so.ref_id
  INNER JOIN tb_editdoc e ON e.id = le.max_id
  WHERE 1=1
    {$sddd_so}
    AND hos__so.ic_ckk='0'
    AND hos__so.status_doc='Request'
   AND hos__so.send_sup='0'
  ORDER BY hos__so.id DESC
";
$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");
?>

<div class="w3-container">
<table border="1" width="100%" class="w3-table">
  <thead class="w3-gray">
    <th width="5%">เลขที่อ้างอิง</th>
    <th width="8%">วันที่ลงทะเบียน</th>
    <th width="8%">เลขที่เอกสาร</th>
    <th width="8%">วันที่ออกเอกสาร</th>
    <th width="15%">รายการสินค้า</th>
    <th width="15%">ชื่อผู้ออกบิล</th>
    <th width="10%">เขตการขาย</th>
    <th width="5%">สถานะ</th>
    <th width="10%">รายละเอียดการแก้ไข</th>
    <th width="5%">แก้ไข</th>
  </thead>

<?php
while($objResult = mysqli_fetch_array($objQuery)) {
  $rs = getLastEdit($conn, $objResult["ref_id"]);
  if (!$rs || $rs["sale_edit"]=='') continue;
?>
  <tbody>
    <tr>
      <td><?php echo $objResult["ref_id"];?></td>
      <td><?php echo DateThai($objResult["date_so"]);?></td>
      <td><?php echo $objResult["iv_no"];?></td>
      <td><?php echo ($objResult["iv_date"]=="0000-00-00")? "-" : DateThai($objResult["iv_date"]);?></td>
      <td>
        <div align="left">
          <?php
            $strSQL1 = "SELECT * FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
            $objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
            while($objResult1 = mysqli_fetch_array($objQuery1)) {
              if($objResult1["bom_ckk"]=='0'){
                echo $objResult1["sol_name"].$objResult1["sale_remark"]."<br>";
              }
            }
            // BOM
            $strSQL2 = "SELECT distinct code_bom FROM hos__subso WHERE ref_idd = '".$objResult["ref_id"]."' ";
            $objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error($conn));
            while($objResult2 = mysqli_fetch_array($objQuery2)){
              $code_bom = $objResult2["code_bom"];
              $strSQL3 = "SELECT * FROM (hos__subso LEFT JOIN tb_product_bomhos ON hos__subso.code_bom=tb_product_bomhos.bom_code) WHERE ref_idd = '".$objResult["ref_id"]."' and code_bom = '".$code_bom."'";
              $objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
              while($objResult3 = mysqli_fetch_array($objQuery3)){
                if($objResult3["code_bom"]!=""){
                  echo $objResult3["bom_name"].$objResult3["sale_remark"]."<br>";
                }
              }
            }
          ?>
        </div>
      </td>
      <td><div align="left"><?php echo $objResult["pre_name"].$objResult["bill_name"];?></div></td>
      <td><div align="left"><?php echo $objResult["sale_code"].' - '.$objResult["sale"];?></div></td>
      <?php
        $bg = '';
        if($objResult["status_doc"]=='Rejected'){ $bg=' bgcolor="#FF3030"'; }
        else if($objResult["status_doc"]=='Approve'){ $bg=' bgcolor="#00FF00"'; }
      ?>
      <td<?php echo $bg; ?>><?php echo $objResult["status_doc"];?></td>
      <td><div align="left"><?php echo $rs["sale_edit"];?> <br>ส่งกลับโดย : <?php echo $rs["add_by"];?></div></td>
      <td>
        <a href="register_salehos_edit.php?ref_id=<?php echo $objResult["ref_id"];?>">
          <img src="img/edit-icon.png" width="23" height="23" border="0" />
        </a>
      </td>
    </tr>
  </tbody>
<?php } ?>

<?php
// ==============================
// 3) ตาราง hos__br
// ==============================
$sddd_br = qualifySaleCode($sddd, 'hos__br');
$strSQL = "
  SELECT hos__br.*, e.sale_edit, e.add_by
  FROM hos__br
  INNER JOIN (
    SELECT ref_id, MAX(id) AS max_id
    FROM tb_editdoc
    WHERE sale_edit IS NOT NULL AND sale_edit <> ''
    GROUP BY ref_id
  ) le ON le.ref_id = hos__br.ref_id_br
  INNER JOIN tb_editdoc e ON e.id = le.max_id
  WHERE 1=1
    {$sddd_br}
    AND hos__br.status_doc='Request'
	 AND hos__br.send_sup='0'
  ORDER BY hos__br.id DESC
";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
while($objResult = mysqli_fetch_array($objQuery)){
  $rs = getLastEdit($conn, $objResult["ref_id_br"]);
  if (!$rs || $rs["sale_edit"]=='') continue;
?>
  <tbody>
    <tr>
      <td><?php echo $objResult["ref_id_br"];?></td>
      <td><?php echo DateThai($objResult["date_br"]);?></td>
      <td><?php echo $objResult["iv_no"];?></td>
      <td><?php echo ($objResult["iv_date"]=="0000-00-00")? "-" : DateThai($objResult["iv_date"]);?></td>
      <td>
        <div align="left">
          <?php
            $strSQL1 = "SELECT * FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br='".$objResult["ref_id_br"]."' ";
            $objQuery1 = mysqli_query($conn,$strSQL1) or die("Error Query [".$strSQL1."]");
            while($objResult1 = mysqli_fetch_array($objQuery1)) {
              echo $objResult1["sol_name"].' '.$objResult1["sale_remark"]."<br>";
            }
          ?>
        </div>
      </td>
      <td><div align="left"><?php echo $objResult["customer"];?></div></td>
      <td><div align="left"><?php echo $objResult["sale_code"].' - '.$objResult["sale"];?></div></td>
      <?php
        $bg = ($objResult["status_doc"]=='Rejected')?' bgcolor="#FF3030"' : (($objResult["status_doc"]=='Approve')?' bgcolor="#00FF00"':'');
      ?>
      <td<?php echo $bg; ?>><?php echo $objResult["status_doc"];?></td>
      <td><div align="left"><?php echo $rs["sale_edit"];?> <br>ส่งกลับโดย : <?php echo $rs["add_by"];?></div></td>
      <td>
        <?php if($user_type=='Engineer'){ ?>
          <a href="register_breng_edit.php?ref_id_br=<?php echo $objResult["ref_id_br"];?>&start_date=<?php echo $_GET["start_date"];?>&end_date=<?php echo $_GET["end_date"];?>">
            <img src="img/edit-icon.png" width="23" height="23" border="0" />
          </a>
        <?php } else { ?>
          <a href="register_brhos_edit.php?ref_id_br=<?php echo $objResult["ref_id_br"];?>&start_date=<?php echo $_GET["start_date"];?>&end_date=<?php echo $_GET["end_date"];?>">
            <img src="img/edit-icon.png" width="23" height="23" border="0" />
          </a>
        <?php } ?>
      </td>
    </tr>
  </tbody>
<?php } ?>

<?php
// ==============================
// 4) ตาราง hos__smp (status_sup)
// ==============================
$sddd_smp = qualifySaleCode($sddd, 'hos__smp');
$strSQL = "
  SELECT hos__smp.*, e.sale_edit, e.add_by
  FROM hos__smp
  INNER JOIN (
    SELECT ref_id, MAX(id) AS max_id
    FROM tb_editdoc
    WHERE sale_edit IS NOT NULL AND sale_edit <> ''
    GROUP BY ref_id
  ) le ON le.ref_id = hos__smp.ref_idsmp
  INNER JOIN tb_editdoc e ON e.id = le.max_id
  WHERE 1=1
    {$sddd_smp}
    AND hos__smp.status_sup='Request'
	AND hos__smp.send_sup='0'
  ORDER BY hos__smp.id_smp DESC
";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
while($objResult = mysqli_fetch_array($objQuery)){
  $rs = getLastEdit($conn, $objResult["ref_idsmp"]);
  if (!$rs || $rs["sale_edit"]=='') continue;
?>
  <tbody>
    <tr>
      <td><?php echo $objResult["ref_idsmp"];?></td>
      <td><?php echo DateThai($objResult["smp_date"]);?></td>
      <td><?php echo $objResult["smp_no"];?></td>
      <td><?php if($objResult["doc_date"]!='0000-00-00 00:00:00'){ echo DateThai($objResult["doc_date"]); } ?></td>
      <td>
        <div align="left">
          <?php
            $strSQL1 = "SELECT sol_name,sale_remark FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$objResult["ref_idsmp"]."' ";
            $objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
            while($objResult1 = mysqli_fetch_array($objQuery1)) {
              echo $objResult1["sol_name"].' '.$objResult1["sale_remark"]."<br />";
            }
          ?>
        </div>
      </td>
      <td><div align="left"><?php echo $objResult["customer_name"];?></div></td>
      <td><div align="left"><?php echo $objResult["sale_code"].' - '.$objResult["sale_name"];?></div></td>
      <td>
        <?php
          if($objResult["status_sup"]=='Rejected') {
            echo '<span style="display:block;background:#FF3030">'.$objResult["status_sup"].'</span>';
          } else if ($objResult["status_sup"]=='Approve') {
            echo '<span style="display:block;background:#00FF00">'.$objResult["status_sup"].'</span>';
          } else if ($objResult["status_sup"]=='Request' && $objResult["send_dm"]=='1'){
            echo "รอผู้บริหารอนุมัติ";
          } else if ($objResult["status_sup"]=='Request' && $objResult["send_dm"]=='0' && $objResult["sup_name"]!='' && $objResult["send_sup"]=='1'){
            echo "รอกดส่งผู้บริหารอนุมัติ".$objResult["sup_name"];
          } else if ($objResult["status_sup"]=='Request' && $objResult["send_sup"]=='1'){
            echo "รอหัวหน้าอนุมัติ";
          } else if ($objResult["status_sup"]=='Request' && $objResult["send_sup"]=='0'){
            echo "รอกดส่งหัวหน้าอนุมัติ";
          } else {
            echo $objResult["status_sup"];
          }
        ?>
      </td>
      <td><div align="left"><?php echo $rs["sale_edit"];?> <br>ส่งกลับโดย : <?php echo $rs["add_by"];?></div></td>
      <td>
        <?php if($objResult["chang_ckk"]=='1'){ ?>
          <a href="register_chang426_edit.php?ref_idsmp=<?php echo $objResult["ref_idsmp"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
        <?php } else { ?>
          <a href="register_salesmp_edit.php?ref_idsmp=<?php echo $objResult["ref_idsmp"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
        <?php } ?>
      </td>
    </tr>
  </tbody>
<?php } ?>

<?php
// ==============================
// 5) ตาราง hos__change
// ==============================
$sddd_change = qualifySaleCode($sddd, 'hos__change');
$strSQL = "
  SELECT hos__change.*, e.sale_edit, e.add_by
  FROM hos__change
  INNER JOIN (
    SELECT ref_id, MAX(id) AS max_id
    FROM tb_editdoc
    WHERE sale_edit IS NOT NULL AND sale_edit <> ''
    GROUP BY ref_id
  ) le ON le.ref_id = hos__change.ref_id
  INNER JOIN tb_editdoc e ON e.id = le.max_id
  WHERE 1=1
    {$sddd_change}
    AND hos__change.status_doc='Request'
	AND hos__change.send_sup='0'
  ORDER BY hos__change.id_change DESC
";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
while($objResult = mysqli_fetch_array($objQuery)){
  $rs = getLastEdit($conn, $objResult["ref_id"]);
  if (!$rs || $rs["sale_edit"]=='') continue;
?>
  <tbody>
    <tr>
      <td><?php echo $objResult["ref_id"];?></td>
      <td><?php echo DateThai($objResult["date_change"]);?></td>
      <td><?php echo $objResult["iv_no"];?></td>
      <td><?php echo ($objResult["iv_date"]=="0000-00-00")? "-" : DateThai($objResult["iv_date"]);?></td>
      <td>
        <div align="left">
          <?php
            $strSQL1 = "SELECT * FROM (hos__subchange LEFT JOIN tb_product ON hos__subchange.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
            $objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
            while($objResult1 = mysqli_fetch_array($objQuery1)) {
              echo $objResult1["sol_name"]."<br />";
            }
          ?>
        </div>
      </td>
      <td><div align="left"><?php echo $objResult["customer"];?></div></td>
      <td><div align="left"><?php echo $objResult["sale_code"].' - '.$objResult["sale"];?></div></td>
      <?php
        $bg = '';
        if($objResult["status_doc"]=='Rejected'){ $bg=' bgcolor="#FF3030"'; }
        else if($objResult["status_doc"]=='Approve'){ $bg=' bgcolor="#00FF00"'; }
      ?>
      <td<?php echo $bg; ?>><?php echo $objResult["status_doc"];?></td>
      <td><div align="left"><?php echo $rs["sale_edit"];?> <br>ส่งกลับโดย : <?php echo $rs["add_by"];?></div></td>
      <td>
        <?php if(!in_array($objResult["status_doc"], ['Rejected','Approve'])){ ?>
          <a href="register_saletran_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
        <?php } ?>
      </td>
    </tr>
  </tbody>
<?php } ?>

<?php
// ==============================
// 6) ตาราง hos__consig
// ==============================
$sddd_consig = qualifySaleCode($sddd, 'hos__consig');
$strSQL = "
  SELECT hos__consig.*, e.sale_edit, e.add_by
  FROM hos__consig
  INNER JOIN (
    SELECT ref_id, MAX(id) AS max_id
    FROM tb_editdoc
    WHERE sale_edit IS NOT NULL AND sale_edit <> ''
    GROUP BY ref_id
  ) le ON le.ref_id = hos__consig.ref_id
  INNER JOIN tb_editdoc e ON e.id = le.max_id
  WHERE 1=1
    {$sddd_consig}
    AND hos__consig.status_doc='Request'
	AND hos__consig.send_sup='0'
  ORDER BY hos__consig.id DESC
";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
while($objResult = mysqli_fetch_array($objQuery)){
  $rs = getLastEdit($conn, $objResult["ref_id"]);
  if (!$rs || $rs["sale_edit"]=='') continue;
?>
  <tbody>
    <tr>
      <td><?php echo $objResult["ref_id"];?></td>
      <td><?php echo DateThai($objResult["date_save"]);?></td>
      <td><?php echo $objResult["iv_no"];?></td>
      <td><?php echo ($objResult["iv_date"]=="0000-00-00")? "-" : DateThai($objResult["iv_date"]);?></td>
      <td>
        <div align="left">
          <?php
            $strSQL1 = "SELECT * FROM (hos__subconsig LEFT JOIN tb_product ON hos__subconsig.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
            $objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
            while($objResult1 = mysqli_fetch_array($objQuery1)) {
              echo $objResult1["sol_name"].' '.$objResult1["sale_remark"]."<br />";
            }
          ?>
        </div>
      </td>
      <td><div align="left"><?php echo $objResult["customer"];?></div></td>
      <td><div align="left"><?php echo $objResult["sale_code"].' - '.$objResult["sale"];?></div></td>
      <?php
        $bg = '';
        if($objResult["status_doc"]=='Rejected'){ $bg=' bgcolor="#FF3030"'; }
        else if($objResult["status_doc"]=='Approve'){ $bg=' bgcolor="#00FF00"'; }
      ?>
      <td<?php echo $bg; ?>><?php echo $objResult["status_doc"];?></td>
      <td><div align="left"><?php echo $rs["sale_edit"];?> <br>ส่งกลับโดย : <?php echo $rs["add_by"];?></div></td>
      <td><a href="register_brcshos_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>
    </tr>
  </tbody>
<?php } ?>

<?php
// ==============================
// 7) ตาราง hos__spr (ทั้งหมด แต่ต้องมีการส่งกลับแก้ไข)
// ==============================
$sddd_spr = qualifySaleCode($sddd, 'hos__spr');
$strSQL = "
  SELECT hos__spr.*, e.sale_edit, e.add_by
  FROM hos__spr
  INNER JOIN (
    SELECT ref_id, MAX(id) AS max_id
    FROM tb_editdoc
    WHERE sale_edit IS NOT NULL AND sale_edit <> ''
    GROUP BY ref_id
  ) le ON le.ref_id = hos__spr.ref_id
  INNER JOIN tb_editdoc e ON e.id = le.max_id
  WHERE 1=1
    {$sddd_spr}
    AND hos__spr.status_doc='Request'
	AND hos__spr.send_sup='0'
  ORDER BY hos__spr.spr_id DESC
";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
while($objResult = mysqli_fetch_array($objQuery)){
  $rs = getLastEdit($conn, $objResult["ref_id"]);
  if (!$rs || $rs["sale_edit"]=='') continue;
?>
  <tbody>
    <tr>
      <td><?php echo $objResult["ref_id"];?></td>
      <td><?php echo DateThai($objResult["spr_date"]);?></td>
      <td><?php echo $objResult["spr_no"];?></td>
      <td><?php echo DateThai($objResult["spr_date"]);?></td>
      <td>
        <div align="left">
          <?php
            $strSQL1 = "SELECT * FROM (hos__subspr LEFT JOIN tb_product ON hos__subspr.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
            $objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
            while($objResult1 = mysqli_fetch_array($objQuery1)) {
              echo $objResult1["sol_name"]."<br />";
            }
          ?>
        </div>
      </td>
      <td><div align="left"><?php echo $objResult["customer"];?></div></td>
      <td><div align="left"><?php echo $objResult["engineer"];?></div></td>
      <?php
        if($objResult["status_doc"]=='Rejected'){
          echo '<td bgcolor="#FF3030">'.$objResult["status_doc"].'</td>';
        } else if ($objResult["status_doc"]=='Approve'){
          echo '<td bgcolor="#00FF00">'.$objResult["status_doc"].'</td>';
        } else if ($objResult["send_sup"]=='1' && $objResult["sup_name"]=='' && $objResult["status_doc"]=='Request'){
          echo '<td>รอหัวหน้าอนุมัติ</td>';
        } else if ($objResult["send_sup"]=='1' && $objResult["sup_name"] !='' && $objResult["cm_name"]=='' && $objResult["status_doc"]=='Request'){
          echo '<td bgcolor="#FFFF00">รอผู้บริหารอนุมัติ</td>';
        } else {
          echo '<td>'.$objResult["status_doc"].'</td>';
        }
      ?>
      <td><div align="left"><?php echo $rs["sale_edit"];?> <br>ส่งกลับโดย : <?php echo $rs["add_by"];?></div></td>
      <td>
        <a href="register_engspr_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>">
          <img src="img/edit-icon.png" width="23" height="23" border="0" />
        </a>
      </td>
    </tr>
  </tbody>
<?php } 

	
	
// 8) ตาราง so__main (ทั้งหมด แต่ต้องมีการส่งกลับแก้ไข)
// ==============================
$sddd_spr = qualifySaleCode($sddd2, 'so__main');
$strSQL = "
  SELECT so__main.*, e.sale_edit, e.add_by
  FROM so__main
  INNER JOIN (
    SELECT ref_id, MAX(id) AS max_id
    FROM tb_editdoc
    WHERE sale_edit IS NOT NULL AND sale_edit <> ''
    GROUP BY ref_id
  ) le ON le.ref_id = so__main.ref_id
  INNER JOIN tb_editdoc e ON e.id = le.max_id
  WHERE 1=1
    {$sddd_spr}
    AND so__main.approve_complete='Request'
  ORDER BY so__main.main_id DESC
";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
while($objResult = mysqli_fetch_array($objQuery)){
  $rs = getLastEdit($conn, $objResult["ref_id"]);
  if (!$rs || $rs["sale_edit"]=='') continue;
?>
  <tbody>
    <tr>
      <td><?php echo $objResult["ref_id"];?></td>
      <td><?php echo DateThai($objResult["register_date"]);?></td>
      <td><?php echo $objResult["doc_no"];?></td>
      <td><?php echo DateThai($objResult["doc_release_date"]);?></td>
      <td>
        <div align="left">
          <?php
            $strSQL1 = "SELECT * FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
            $objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
            while($objResult1 = mysqli_fetch_array($objQuery1)) {
              echo $objResult1["sol_name"]."<br />";
            }
          ?>
        </div>
      </td>
      <td><div align="left"><?php echo $objResult["billing_name"];?></div></td>
      <td><div align="left"><?php echo $objResult["employee_name"];?></div></td>
      <?php
        if($objResult["approve_complete"]=='Rejected'){
          echo '<td bgcolor="#FF3030">'.$objResult["approve_complete"].'</td>';
        } else if ($objResult["approve_complete"]=='Approve'){
          echo '<td bgcolor="#00FF00">'.$objResult["approve_complete"].'</td>';
        } else {
          echo '<td>'.$objResult["status_doc"].'</td>';
        }
      ?>
      <td><div align="left"><?php echo $rs["sale_edit"];?> <br>ส่งกลับโดย : <?php echo $rs["add_by"];?></div></td>
      <td>
        <a href="register_allwell_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>">
          <img src="img/edit-icon.png" width="23" height="23" border="0" />
        </a>
      </td>
    </tr>
  </tbody>
<?php } ?>	
	
</table>
<br>
</div></div>
</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>
</body>
</html>
