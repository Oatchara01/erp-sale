<?php 

$emid = $_SESSION['code'];
$user_type = $_SESSION['user_type'];
$start_date = date('Y-m-d');
$date_1ms = date("Y-m-d",strtotime("+30 days"));


$sddd = "AND sale_code IN ('S31','S32')";	
	

?>	
	
<div class="w3-row" style="display: flex; gap: 10px;">	
<?php	
//ใบสั่งขาย	
$strSQL = "SELECT ref_id  FROM hos__so  where status_doc ='Pending review' and send_sup ='1' and send_cm ='0' $sddd";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rowsf = mysqli_num_rows($objQuery);

$strSQL = "SELECT ref_id  FROM hos__so  where status_doc ='Pending review' and send_sup ='1' and send_cm ='0' and ic_ckk='0' and que_ckk='1' $sddd";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rowsfd = mysqli_num_rows($objQuery);	
	
//ใบยืม	
$strSQL1 = "SELECT *  FROM hos__br  where  status_doc ='Pending review' and send_sup ='1' $sddd";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rowsf1 = mysqli_num_rows($objQuery1);
	
$strSQL1 = "SELECT *  FROM hos__br  where  status_doc ='Pending review' and send_sup ='1'  and que_ckk='1' $sddd";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rowsf1d = mysqli_num_rows($objQuery1);

	
//ลดหนี้	
$strSQLfc = "SELECT *  FROM tb_credit_note  where status_doc = 'Pending review' and send_sup = '1' and send_dm = '0' $sddd";
//echo $strSQLfc;
	
$objQueryfc = mysqli_query($conn,$strSQLfc) or die ("Error Query [".$strSQLfc."]");
$Num_Rowsfc = mysqli_num_rows($objQueryfc);

//smp	
$strSQLsm = "SELECT *  FROM hos__smp  where send_dm = '0' and send_stock = '0' and  send_admin = '0' and send_sup = '1' and status_sup = 'Pending review' $sddd";
$objQuerysm = mysqli_query($conn,$strSQLsm) or die ("Error Query [".$strSQLsm."]");
$Num_Rowssm = mysqli_num_rows($objQuerysm);
	
//jong	
$strSQLjn = "SELECT *  FROM hos__jongproduct  where send_sup = '1' and status_doc = 'Pending review' $sddd";
$objQueryjn = mysqli_query($conn,$strSQLjn) or die ("Error Query [".$strSQLjn."]");
$Num_Rowsjn = mysqli_num_rows($objQueryjn);
	
//change	
$strSQLch = "SELECT *  FROM hos__change  where status_doc ='Pending review' and send_sup ='1' and  adm_ckk='0' $sddd";
$objQuerych = mysqli_query($conn,$strSQLch) or die ("Error Query [".$strSQLch."]");
$Num_Rowsch = mysqli_num_rows($objQuerych);
	
//รายการรับเรื่อง	
$strSQLeng = "SELECT *  FROM tb_register_story  where summary_sale = '0'  $sddd";
$objQueryeng = mysqli_query($conn,$strSQLeng) or die ("Error Query [".$strSQLeng."]");
$Num_Rowseng = mysqli_num_rows($objQueryeng);	
	
//รายการ PO	
$strSQLengp = "SELECT *  FROM hos__po  where  send_sale = '1' and open_so = '0' $sddd";
$objQueryengp = mysqli_query($conn,$strSQLengp) or die ("Error Query [".$strSQLengp."]");
$Num_Rowsengp = mysqli_num_rows($objQueryengp);	
	
//แบบสอบถามสินค้าสาธิต	
$strSQLdm = "SELECT *  FROM hos__br  where research_demo ='1' and status_doc ='Approve' $sddd";
$objQuerydm = mysqli_query($conn,$strSQLdm) or die ("Error Query [".$strSQLdm."]");
$Num_Rowsdm = mysqli_num_rows($objQuerydm);

//ใบยืมฝากขาย	
$strSQLcos = "SELECT *  FROM hos__consig  where send_sup = '1' and send_cm='0' and status_doc = 'Pending review' $sddd";
$objQuerycos = mysqli_query($conn,$strSQLcos) or die ("Error Query [".$strSQLcos."]");
$Num_Rowscos = mysqli_num_rows($objQuerycos);

$strSQLcos1 = "SELECT *  FROM hos__consig  where send_sup = '1' and send_cm='0' and status_doc = 'Pending review' and que_ckk ='1' $sddd";
$objQuerycos1 = mysqli_query($conn,$strSQLcos1) or die ("Error Query [".$strSQLcos1."]");
$Num_Rowscos1 = mysqli_num_rows($objQuerycos1);
	
	
//ใบสั่งเช่า
$strSQLren = "SELECT *  FROM hos__rental where status_doc ='Pending review' and send_sup ='1' $sddd";
$objQueryren = mysqli_query($conn,$strSQLren) or die ("Error Query [".$strSQLren."]");
$Num_Rowsren = mysqli_num_rows($objQueryren);

	

	
function qualifySaleCode($sddd, $tableName) {
    $sddd = (string)($sddd ?? '');
    $tableName = (string)($tableName ?? '');

    if ($sddd === '' || $tableName === '') {
        return '';
    }

    // ตัวอย่าง: " AND sale_code NOT LIKE '%EN%'" -> " AND hos__so.sale_code NOT LIKE '%EN%'"
    return preg_replace('/(?<!\.)\bsale_code\b/', $tableName . '.sale_code', $sddd);
}
// ===== ฟังก์ชันนับ (JOIN tb_editdoc) =====
// หมายเหตุ: ฟังก์ชันนี้ "ไม่ใช้ alias" กับตาราง เพื่อให้สอดคล้องกับ sddd ที่ชี้บ่งด้วยชื่อเต็ม เช่น hos__so.sale_code
function countRequestsWithQualifiedSddd(
  mysqli $conn,
  string $table,     // ชื่อตารางเอกสาร เช่น hos__so
  string $refCol,    // คอลัมน์ ref เช่น ref_id
  string $statusCol, // status_doc หรือ status_sup
  string $statusVal, // 'Pending review'
  string $sdddQualified // sddd ที่ผ่าน qualifySaleCode() มาแล้ว
): int {
  $sql = "
    SELECT COUNT(DISTINCT {$table}.{$refCol}) AS cnt
    FROM {$table}
    INNER JOIN tb_editdoc e
      ON e.ref_id = {$table}.{$refCol}
    WHERE 1=1
      {$sdddQualified}
      AND {$table}.{$statusCol} = ?
      AND e.sale_edit IS NOT NULL
      AND e.sale_edit <> ''
  ";
  $stmt = $conn->prepare($sql);
  if (!$stmt) { die('Prepare failed: '.$conn->error); }
  $stmt->bind_param('s', $statusVal);
  $stmt->execute();
  $res = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  return (int)($res['cnt'] ?? 0);
}

	
	

$sddd1 = "AND sale_code IN ('S31','S32')";
	
$sddd2 = " and employee_name  IN ('S31','S32')";
	


// ====== ทำ sddd รายตาราง โดยชี้บ่งชื่อเต็ม ======
$sddd_so     = qualifySaleCode($sddd1, 'hos__so');
$sddd_br     = qualifySaleCode($sddd1, 'hos__br');
$sddd_smp    = qualifySaleCode($sddd1, 'hos__smp');
$sddd_change = qualifySaleCode($sddd1, 'hos__change');
$sddd_consig = qualifySaleCode($sddd1, 'hos__consig');
$sddd_spr    = qualifySaleCode($sddd1, 'hos__spr');
$sddd_som    = qualifySaleCode($sddd2, 'so__main');
	

// ====== เรียกนับรายตาราง โดยใช้ sddd ที่ชี้บ่งแล้ว ======
$Num_Rowsedso = countRequestsWithQualifiedSddd($conn, 'hos__so',     'ref_id',    'status_doc', 'Pending review', $sddd_so);
$Num_Rowsedbr = countRequestsWithQualifiedSddd($conn, 'hos__br',     'ref_id_br', 'status_doc', 'Pending review', $sddd_br);
$Num_Rowsedsm = countRequestsWithQualifiedSddd($conn, 'hos__smp',    'ref_idsmp', 'status_sup', 'Pending review', $sddd_smp);
$Num_Rowsedch = countRequestsWithQualifiedSddd($conn, 'hos__change', 'ref_id',    'status_doc', 'Pending review', $sddd_change);
$Num_Rowsedsc = countRequestsWithQualifiedSddd($conn, 'hos__consig', 'ref_id',    'status_doc', 'Pending review', $sddd_consig);
$Num_Rowsedsp = countRequestsWithQualifiedSddd($conn, 'hos__spr',    'ref_id',    'status_doc', 'Pending review', $sddd_spr);
$Num_Rowsedsom = countRequestsWithQualifiedSddd($conn, 'so__main',     'ref_id',    'approve_complete', 'Pending review', $sddd_som);
	
// ====== แสดงปุ่มรวม ถ้ามากกว่า 0 ======
$totalEdits = $Num_Rowsedso + $Num_Rowsedbr + $Num_Rowsedsm + $Num_Rowsedch + $Num_Rowsedsc + $Num_Rowsedsp + $Num_Rowsedsom;	
	
	
	
if(($Num_Rowsf+$Num_Rowsf1+$Num_Rowsfc+$Num_Rowssm+$Num_Rowsjn+$Num_Rowsch+$Num_Rowssp1+$Num_Rowseng+$Num_Rowsengp+$Num_Rowsdm+$Num_Rowscos+$Num_Rowsrs+$p+$j+$Num_Rows7+$Num_Rows17+$Num_Rowssb+$Num_Rowsmr+$totalEdits) > 0){
	
?>	
<div class="w3-third" style="flex: 1; background-color: #f0f0f0;">	
<div class="w3-container"><font color ='blue'><b> ERP SALE</b></font></div>	
	
	
<?php if(($totalEdits) > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_editwailsale.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>มีเอกสารส่งกลับรอแก้ไข</b></span>
        <span style="text-align: right;"><b><?php echo ($totalEdits); ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	
	
	
	
	
<?php if($Num_Rowsf > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_approvesup.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบสั่งขาย</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsf; ?> รายการ <?php if($Num_Rowsfd > 0 ){ ?> <font color='red'> ด่วน <?php echo $Num_Rowsfd; ?> </font>  <?php }?></b></span>
    </a>
</div></p>
<?php } ?>	
	
<?php if($Num_Rowsf1 > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_approvebrsup.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบยืม</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsf1; ?> รายการ <?php if($Num_Rowsf1d > 0 ){ ?> <font color='red'> ด่วน <?php echo $Num_Rowsf1d; ?> </font>  <?php }?></b></span>
    </a>
</div></p>
<?php } ?>	


<?php if($Num_Rows7 > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_approve_sol.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบสั่งขาย/ใบยืม</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rows7; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	

<?php if($Num_Rows17 > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_appqou.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเสนอราคา</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rows17; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	


<?php if($Num_Rowscos > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_approvebrsc.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบยืมฝากขาย</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowscos; ?> รายการ <?php if($Num_Rowscos1 > 0 ){ ?> <font color='red'> ด่วน <?php echo $Num_Rowscos1; ?> </font>  <?php }?></b></span>
    </a>
</div></p>
<?php } ?>	


<?php if($Num_Rowsfc > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_credit_approve.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบลดหนี้</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsfc; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>			

<?php if($Num_Rowssm > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_sample_approve.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเบิก (SMP)</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowssm; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>			

<?php if($Num_Rowsjn > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_supjongapp.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบจอง</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsjn; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	

<?php if($Num_Rowsch > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_supchangeapp.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบแลกเปลี่ยน</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsch; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	

<?php if($Num_Rowsren > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_apprental.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบสั่งเช่า</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsren; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	


<?php if($Num_Rowseng > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_storykangsup.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>รายการรับเรื่องรอดำเนินการ</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowseng; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	

<?php if($Num_Rowsengp > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_po_sup.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>เอกสาร PO รอเปิดใบสั่งขาย</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsengp; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	




</div>	
<?php } ?>
	
	
<?php	
//ใบขอซื้อภายใน	
$pr_main = "SELECT * FROM tb__pr WHERE ( pr_status = 1 OR  pr_status = 30 ) and pr_department = '".$emid."' ";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr2 = mysqli_num_rows($qpr_main);
	
$pr_main = "SELECT * FROM tb__pr WHERE ( pr_status = 1 OR  pr_status = 30 ) and pr_department = '".$emid."' and pr_need= 1";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr2_ = mysqli_num_rows($qpr_main);

//ใบเบิกสำนักงาน
$pr_main = "SELECT * FROM tb__wr WHERE wr_status = 2 and  user_type = '".$emm."'";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_wr2 = mysqli_num_rows($qpr_main);
	
$pr_main = "SELECT * FROM tb__wr WHERE wr_status = 2 and user_type = '".$emm."' and wr_need=1";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_wr2_ = mysqli_num_rows($qpr_main);
	
//ใบเบิกค่าใช้จาย	
$pr_main = "SELECT * FROM tb__re WHERE ( status_re = 2 OR status_re = 30 ) and user_type = '".$emm."' ";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr1 = mysqli_num_rows($qpr_main);
	
//ใบสำรองจ่าย RA	
$pr_main = "SELECT * FROM tb__ra WHERE ( status_re = 2 OR status_re = 30 ) and user_type = '".$emm."'";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr3 = mysqli_num_rows($qpr_main);
	
//ใบขอซื้อภายนอก	
$pr_main = "SELECT *  FROM po__main  where  send_sup = '1' and sup_name ='' and status_doc ='Pending review' $sddd";
$qpr_main = mysqli_query($inter,$pr_main);
$Num_pr9 = mysqli_num_rows($qpr_main);	

	


if(($Num_pr2+$Num_pr2_+$Num_wr2+$Num_wr2_+$Num_pr1+$Num_pr3+$Num_pr9) > 0){
	
?>	
<div class="w3-third" style="flex: 1; background-color: #f0f0f0;">	
<div class="w3-container"><font color ='blue'><b>ใบขอซื้อ & ใบเบิกค่าใช้จ่าย</b></font></div>	
<?php if($Num_pr2 > 0){ ?>	
<div class="w3-container">
    <a href="https://pr-wr.allwellcenter.com/pr_doc_status_sup" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบขอซื้อภายใน</b></span>
        <span style="text-align: right;"><b><?php echo $Num_pr2; ?> รายการ <?php if($Num_pr2_ > 0 ){ ?> <font color='red'> ด่วน <?php echo $Num_pr2_; ?> </font>  <?php }?></b></span>
    </a>
</div></p>
<?php } ?>	
	
	
<?php if($Num_wr2 > 0){ ?>	
<div class="w3-container">
    <a href="https://pr-wr.allwellcenter.com/wr_status_sup" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเบิกอุปกรณสำนักงาน</b></span>
        <span style="text-align: right;"><b><?php echo $Num_wr2; ?> รายการ <?php if($Num_wr2_ > 0 ){ ?> <font color='red'> ด่วน <?php echo $Num_wr2_; ?> </font>  <?php }?></b></span>
    </a>
</div></p>
<?php } ?>		
	
	
<?php if($Num_pr1 > 0){ ?>	
<div class="w3-container">
    <a href="https://pr-wr.allwellcenter.com/doc_expenditure_status_sup" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเบิกค่าใช้จ่าย</b></span>
        <span style="text-align: right;"><b><?php echo $Num_pr1; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>		
	
<?php if($Num_pr3 > 0){ ?>	
<div class="w3-container">
    <a href="https://pr-wr.allwellcenter.com/doc_ra_status_sup" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบสำรองจ่าย</b></span>
        <span style="text-align: right;"><b><?php echo $Num_pr3; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>		
	
<?php if($Num_pr9 > 0){ ?>	
<div class="w3-container">
    <a href="https://inter.allwellcenter.com/status_supapprove.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบขอซื้อ (INTER)</b></span>
        <span style="text-align: right;"><b><?php echo $Num_pr9; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>		
	
	
</div>	
<?php } ?>
		
	

<?php	
//ใบเสนอราคา
$strSQLqu = "SELECT id,id_fk,company,emid1,add_by,add_date,sale_code,status_all,
CASE
WHEN status_all = '0' THEN 'Pending review' -- ยังไม่ส่งsup
WHEN status_all = '1' THEN 'Pending review' -- ส่งsupแล้ว
WHEN status_all = '2' THEN 'Rejected' -- supไม่อนุมัติ
WHEN status_all = '3' THEN 'Pending review' -- supส่งกลับ
WHEN status_all = '4' THEN 'admin กำลังดำเนินการ' -- adminดำเนินการ
WHEN status_all = '5' THEN 'Pending review' -- adminส่งกลับ
WHEN status_all = '6' THEN 'admin อนุมัติส่งตรวจสอบ' -- adminอนุมัติส่งตรวจสอบ
WHEN status_all = '7' THEN 'Approve' -- Approve
WHEN status_all = '8' THEN 'admin กำลังดำเนินการ' -- ผู้ตรวจสอบส่งให้adminแก้ไข
WHEN status_all = '99' THEN 'Rejected' -- Rejected
WHEN status_all = '98' THEN 'ยกเลิก' -- Cancel
END as type_status
FROM quotation_handler WHERE (status_all = 1 or status_all = 5) $sddd";
$objQueryqu = mysqli_query($quo,$strSQLqu) or die ("Error Query [".$strSQLqu."]");
$Num_Rowsqu = mysqli_num_rows($objQueryqu);
	
$strSQLqu1 = "SELECT id FROM quotation_handler WHERE status_all IN (6, 8, 9) $sddd";
$objQueryqu1 = mysqli_query($quo,$strSQLqu1) or die ("Error Query [".$strSQLqu1."]");
$Num_Rowsqu1 = mysqli_num_rows($objQueryqu1);


if(($Num_Rowsqu1+$Num_Rowsqu) > 0){
	
?>	
<div class="w3-third" style="flex: 1; background-color: #f0f0f0;">	
<div class="w3-container"><font color ='blue'><b>ใบเสนอราคา</b></font></div>	
<?php if($Num_Rowsqu > 0){ ?>	
<div class="w3-container">
    <a href="https://quotation.allwellcenter.com/login_all.php?em_id=<?php echo $_SESSION['emid'] ?>" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเสนอราคาอนุมัติจัดทำ</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsqu; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>	
	
<?php if($Num_Rowsqu1 > 0){ ?>	
<div class="w3-container">
    <a href="https://quotation.allwellcenter.com/report_split_status_sup_v3" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเสนอราคาอนุมัติจัดส่งลูกค้า</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsqu1 ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>	
		
	
	
</div>	
<?php } ?>
		

</div><br>	
<div class="w3-row" style="display: flex; gap: 10px;">
	

<?php 

//คุณทำดี
$strSQLem = "SELECT *  FROM good_result where  rc_id='".$_SESSION['emid']."' AND read_ckk ='0'";
$objQueryem = mysqli_query($user,$strSQLem) or die ("Error Query [".$strSQLem."]");
$Num_Rowsem = mysqli_num_rows($objQueryem);
	
//ใบแจ้งสินค้าไม่สมบูรณ์
/*$strSQLnc = "SELECT * FROM fb__maim where $code and (status_doc ='3' or status_doc ='4' )";
$objQuerync = mysqli_query($user,$strSQLnc) or die ("Error Query [".$strSQLnc."]");
$Num_Rowsnc = mysqli_num_rows($objQuerync);*/
	
//อนุมัติสินค้าไม่สมบูรณ์
/*$strSQLnc1 = "SELECT *  FROM no__complete  where  status_doc ='Pending review'  and send_sup ='1' $code";
$objQuerync1 = mysqli_query($conn,$strSQLnc1) or die ("Error Query [".$strSQLnc1."]");
$Num_Rowsnc1 = mysqli_num_rows($objQuerync1);*/
	
	
if(($Num_Rowsem+$Num_Rowsnc+$Num_Rowsca+$Num_Rowspa+$Num_Rowsiso+$Num_Rowsnc1) > 0){	?>	

<div class="w3-third" style="flex: 1;  background-color: #f0f0f0;">
<div class="w3-container"><font color ='blue'><b>อื่นๆ</b></font></div>

	
	
	
<?php if($Num_Rowsem > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/good_receive.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>การ์ดคุณทำดีที่ยังไม่ได้อ่าน</b></span>
     <span><b><?php echo $Num_Rowsem;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	
	
	
</div>
<?php } ?>	
	


</div>	
