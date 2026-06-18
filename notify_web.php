<?php

if ($_SESSION['name']=='ชลชินี' or $_SESSION['name']=='สมบัติ') {
	
?>
<div class="w3-row" style="display: flex; gap: 10px;">
<?php

//ใบสั่งขายฝากขาย	
$strSQLd = "SELECT *  FROM hos__so  where status_doc ='Request' and  send_cm ='2' and ic_ckk='1'";
$objQueryd = mysqli_query($conn,$strSQLd) or die ("Error Query [".$strSQLd."]");
$Num_Rowsfd = mysqli_num_rows($objQueryd);

//ออเดอร์สินค้าราคาต่ำกว่ากำหนด	
$strSQL6 = "SELECT ref_id FROM so__main  where price_ckk='1' and approve_complete='Request'  and cancel_ckk='0'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$Num_Rows6 = mysqli_num_rows($objQuery6);
	
$strSQLh1 = "SELECT *  FROM hos__so  where status_doc ='Request' and send_sup ='1' and send_cm ='1'";
$objQueryh1 = mysqli_query($conn,$strSQLh1) or die ("Error Query [".$strSQLh1."]");
$Num_Rowsh1 = mysqli_num_rows($objQueryh1);	
	
//ใบยืมออกบูธ
$strSQLboso = "SELECT ref_id FROM so__main  where send_dm ='1'  and approve_complete ='Request'";
$objQueryboso = mysqli_query($conn,$strSQLboso) or die ("Error Query [".$strSQLboso."]");
$Num_Rowsboso = mysqli_num_rows($objQueryboso);
	
$strSQLboho = "SELECT ref_id_br  FROM hos__br  where send_dm ='1'  and status_doc ='Request'";
$objQueryboho = mysqli_query($conn,$strSQLboho) or die ("Error Query [".$strSQLboho."]");
$Num_Rowsboho = mysqli_num_rows($objQueryboho);		
	
	
//ใบยืมฝากขาย	
$strSQL16 = "SELECT *  FROM hos__consig  where send_sup = '1'  and send_cm='1' and status_doc = 'Request'";
$objQuery16 = mysqli_query($conn,$strSQL16) or die ("Error Query [".$strSQL16."]");
$Num_Rows16 = mysqli_num_rows($objQuery16);
	
$strSQL16_ = "SELECT *  FROM hos__consig  where send_sup = '1'  and send_cm='1' and status_doc = 'Request'";
$objQuery16_ = mysqli_query($conn,$strSQL16_) or die ("Error Query [".$strSQL16_."]");
$Num_Rows16_ = mysqli_num_rows($objQuery16_);	
	
//ใบลดหนี้	
$strSQL3 = "SELECT *  FROM tb_credit_note  where status_doc = 'Request' and send_dm = '1'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rowsa3 = mysqli_num_rows($objQuery3);
	
//SMP	
$strSQL2 = "SELECT *  FROM hos__smp  where  send_dm = '1' and status_sup ='Request'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rowsa2 = mysqli_num_rows($objQuery2);
	
//SPR
$strSQL4 = "SELECT *  FROM hos__spr  where send_cm = '1' and cm_name ='' and status_doc='Request' and app_ckk='0'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rowsa4 = mysqli_num_rows($objQuery4);
	
//แก้ไข credit
$strSQLcd4 = "SELECT *  FROM tb_customer_credit  where  status_credit='Request' ";
$objQuerycd4 = mysqli_query($conn,$strSQLcd4) or die ("Error Query [".$strSQL4."]");
$Num_Rowsacd4 = mysqli_num_rows($objQuerycd4);
	
	
//ใบขอเบิกอะไหล่จากสินค้าขาย	
$strSQL5 = "SELECT *  FROM hos__breg  where status_doc ='Request' and send_dm='1'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rows5 = mysqli_num_rows($objQuery5);
	
//สินค้ายอดนิยมออนไลน์คงเหลือต่ำกว่ากำหนด	
$strSQL = "SELECT access_code, sol_name, unit_name,product_ID,ecom_count FROM tb_product WHERE popular_2 = '1' AND close_pro = '0' AND close_out = '0' and ecom_ckk='1'";
$strSQL .= " ORDER BY number ASC";
$objQuery = mysqli_query($stock, $strSQL) or die("Error Query [" . $strSQL . "]");
$Num_Rows = mysqli_num_rows($objQuery);

$j = 0; // ปรับตัวแปร $j ให้อยู่ภายนอกลูป
while ($objResult = mysqli_fetch_array($objQuery)) {
    $strSQL37 = "SELECT SUM(count_send) AS count_send, SUM(count_receive) AS count_receive FROM st__sbmain WHERE product_id = '" . $objResult["product_ID"] . "'";
    $objQuery37 = mysqli_query($stock, $strSQL37);
    $objResult37 = mysqli_fetch_array($objQuery37);

    $count_send7 = $objResult37["count_send"];
    $count_receive7 = $objResult37["count_receive"];
    // คงเหลือ
    $count_pro7 = $count_receive7 - $count_send7;

    if ($count_pro7 < $objResult["ecom_count"]) {
        $j++; // เพิ่มค่าของ $j
    }
}
	

//สินค้ายอดนิยมออนไลน์พร้อมขาย
$strSQL = "SELECT access_code, sol_name, unit_name, product_ID FROM tb_product WHERE popular_2 = '1' AND close_pro = '0'  and close_out='1' and  close_in='1' and ecom_ckk='1'";
$strSQL .= " ORDER BY number ASC";
$objQuery = mysqli_query($stock, $strSQL) or die("Error Query [" . $strSQL . "]");
$Num_Rows = mysqli_num_rows($objQuery);

$p = 0; 
while ($objResult = mysqli_fetch_array($objQuery)) {
  $p++;
    }

//ขอปรับปรุงยอดสต็อก	
$strSQLst = "SELECT *  FROM st__main_new  where  status_doc ='Request'";
$objQueryst = mysqli_query($stock,$strSQLst) or die ("Error Query [".$strSQLst."]");
$Num_Rowsst = mysqli_num_rows($objQueryst);

//อนุมัติเป็นสินค้าสาธิต	
$strSQLst1 = "SELECT *  FROM st__expro  where send_dm='1' and status_doc ='Request'";
$objQueryst1 = mysqli_query($stock,$strSQLst1) or die ("Error Query [".$strSQLst1."]");
$Num_Rowsst1 = mysqli_num_rows($objQueryst1);

//อนุมัติใบเสนอราคา	
$strSQLqo1 = "SELECT 
    h.id,
    h.id_fk,
    h.company,
    h.status_all,
    h.add_date,
    h.md_ckk,
    m.id AS main_id,
    m.refer_id,
    m.q_id,
    m.hospital,
    m.file_other1,
    m.sale_code,
    SUM(p.amount) AS total_amount
FROM quotation_handler h
LEFT JOIN quotation_main m
    ON h.id_fk = m.id
LEFT JOIN quotation_product p
    ON h.id_fk = p.id_fk
WHERE h.status_all = 4
    AND h.md_ckk = 0
    AND h.add_date > '2025-07-17'
GROUP BY 
    h.id,
    h.id_fk,
    h.company,
    h.status_all,
    h.add_date,
    h.md_ckk,
    m.id,
    m.refer_id,
    m.q_id,
    m.hospital,
    m.file_other1,
    m.sale_code
HAVING SUM(p.amount) >= 1000000";
$objQueryqo1 = mysqli_query($quo,$strSQLqo1) or die ("Error Query [".$strSQLqo1."]");
$Num_Rowsqo1 = mysqli_num_rows($objQueryqo1);
	
	
if(($Num_Rowsfd+$Num_Rows6+$Num_Rowsh1+$Num_Rows16+$Num_Rowsa3+$Num_Rowsa2+$Num_Rowsa4+$Num_Rows5+$Num_Rows+$j+$p+$Num_Rowsst+$Num_Rowsqo1+$Num_Rowsacd4+$Num_Rowsboho+$Num_Rowsboso) > 0){	
	
?>	
	
<div class="w3-third" style="flex: 1; background-color: #f0f0f0;">	
<div class="w3-container"><font color ='blue'><b> ERP SALE</b></font></div>
	
	
	
<?php	if($Num_Rowsacd4 > 0){ ?>
	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_app_credit.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ข้อมูลวงเงินลูกค้า (รออนุมัติ)</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsacd4; ?> รายการ</b></span>
    </a>
</div></p>	
	<?php } ?>
<?php	if($Num_Rowsqo1 > 0){ ?>
	
<div class="w3-container">
    <a href="https://quotation.allwellcenter.com/million_md_doc" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเสนอราคา</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsqo1; ?> รายการ</b></span>
    </a>
</div></p>

	
<?php } ?>
	
<?php	if($Num_Rowsfd > 0){ ?>
	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_approvecm.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบสั่งขายฝากขาย</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsfd; ?> รายการ</b></span>
    </a>
</div></p>

	
<?php } ?>
	
<?php if(($Num_Rows6+$Num_Rowsh1) > 0){ ?>
<div class="w3-container"><a href="https://sol.allwellcenter.com/status_adminprice.php"  target="_blank"  class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ออเดอร์ราคาต่ำกว่ากำหนด</b></span>
     <span style="text-align: right;"><b><?php echo $Num_Rows6+$Num_Rowsh1;?>  รายการ</b></span>
	</a></div></p>
	 
<?php } ?>	
<?php if(($Num_Rowsboso+$Num_Rowsboho) > 0){ ?>
<div class="w3-container"><a href="https://sol.allwellcenter.com/status_appbrbooth.php"  target="_blank"  class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบยืมออกบูธ</b></span>
     <span style="text-align: right;"><b><?php echo $Num_Rowsboso+$Num_Rowsboho;?>  รายการ</b></span>
	</a></div></p>
	 
<?php } ?>	
	
<?php if($Num_Rows16 > 0){ ?>
<div class="w3-container"><a href="https://sol.allwellcenter.com/status_appcmbrsc.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบยืมฝากขาย</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rows16;?> รายการ</b></span>
	</a></div></p>
	 
<?php }	?>
<?php if($Num_Rowsa3 > 0){ ?>
<div class="w3-container"><a href="https://sol.allwellcenter.com/status_credit_cmapprove.php"  target="_blank"  class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบลดหนี้</b></span>
     <span style="text-align: right;"><b><?php echo $Num_Rowsa3;?>  รายการ</b></span>
	</a></div></p>
	 
<?php } ?>	
<?php if($Num_Rowsa2 > 0){ ?>
<div class="w3-container"><a href="https://sol.allwellcenter.com/status_smpapprove.php"  target="_blank"  class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	
	<span style="flex-grow: 1; text-align: left;"><b>ใบเบิก (SMP)</b></span>
     <span style="text-align: right;"><b><?php echo $Num_Rowsa2;?>  รายการ</b></span>
	
	</a></div></p>
	 
<?php } ?>
<?php if($Num_Rowsa4 > 0){ ?>
<div class="w3-container"><a href="https://sol.allwellcenter.com/status_appspr_cm.php"  target="_blank"  class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบเบิก (SPR)</b></span>
     <span style="text-align: right;"><b><?php echo $Num_Rowsa4;?>  รายการ</b></span>
	</a></div></p>
	 
<?php } ?>
<?php if($Num_Rows5 > 0){ ?>
<div class="w3-container"><a href="https://sol.allwellcenter.com/status_dmbreg_app.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบขอเบิกอะไหล่จากสินค้าขาย (BREG)</b></span>
     <span style="text-align: right;"><b><?php echo $Num_Rows5;?>  รายการ</b></span>
	</a></div></p>
	 
<?php } ?>
<?php if($j > 0){	?>	
<div class="w3-container"><a href="https://sol.allwellcenter.com/status_almostpro.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>สินค้ายอดนิยมออนไลน์เหลือต่ำกว่าเกณฑ์</b></span>
     <span style="text-align: right;"><b><?php echo $j;?>  รายการ</b></span>
	</a></div></p>
<?php } ?>		   
<?php if($p > 0){ ?>	
<div class="w3-container"><a href="https://sol.allwellcenter.com/status_almostpro.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>สินค้ายอดนิยมออนไลน์มีสินค้าเข้าพร้อมขาย</b></span>
     <span style="text-align: right;"><b><?php echo $p;?>  รายการ</b></span>
	</a></div></p>	
<?php } ?>	
	
<?php if($Num_Rowsst > 0){ ?>
<div class="w3-container"><a href="https://sol.allwellcenter.com/status_apprefst.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ขอปรับปรุงยอดสต็อก</b></span>
     <span style="text-align: right;"><b><?php echo $Num_Rowsst;?>  รายการ</b></span>
	</a></div></p>
<?php } ?>		
	
<?php if($Num_Rowsst1 > 0){ ?>
<div class="w3-container"><a href="https://sol.allwellcenter.com/status_appexpro.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบเบิกเป็นสินค้าสาธิต</b></span>
     <span style="text-align: right;"><b><?php echo $Num_Rowsst1;?>  รายการ</b></span>
	</a></div></p>
<?php } ?>		
	
	
	
	
</div>
	
<?php } ?>	
	
	
	
<?php 
	
//ใบเบิกค่าใช้จ่าย	
$pr_main = "SELECT * FROM tb__re WHERE status_re IN ('3','7')";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr1 = mysqli_num_rows($qpr_main);
	
//ใบสำรองจ่าย RA	
$pr_main = "SELECT * FROM tb__ra WHERE status_re = 3";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr3 = mysqli_num_rows($qpr_main);

//ใบขอซื้อภายใน	
$pr_main = "SELECT * FROM tb__pr WHERE pr_status = 3 OR pr_status = 40";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr2 = mysqli_num_rows($qpr_main);

//ใบขอซื้อภายนอก	
$pr_main = "SELECT *  FROM po__main  where  send_dm = '1' and dm_name ='' and status_doc ='Request'";
$qpr_main = mysqli_query($inter,$pr_main);
$Num_pr9 = mysqli_num_rows($qpr_main);	
	
//ใบสั่งซื้อภายนอก	
$pr_main = "SELECT DISTINCT po_no,revision_po,vender  FROM po__main  where send_int ='1' and status_doc='Approve' and po_no != '' and inter_chk != '1' and ba_ckk1 != '1' and  inter_chk3 = '1'";
$qpr_main = mysqli_query($inter,$pr_main);
$Num_pr8 = mysqli_num_rows($qpr_main);	
	
if(($Num_pr1+$Num_pr3+$Num_pr2+$Num_pr9+$Num_pr8) > 0){		
?>	
	
<div class="w3-third" style="flex: 1;  background-color: #f0f0f0;">
<?php	
if($Num_pr1 > 0){	
?>	
	
<div class="w3-container"><font color ='blue'><b>ใบขอซื้อ & ใบเบิกค่าใช้จ่าย</b></font></div>	
	
<?php if($Num_pr1 > 0){ ?>
<div class="w3-container" style="width: 100%;">
    <a href="https://pr-wr.allwellcenter.com/login_all.php?em_id=<?php echo $_SESSION['emid']; ?>" target="_blank" 
       class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเบิกค่าใช้จ่าย</b></span>
        <span style="text-align: right;"><b><?php echo $Num_pr1;?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>		
	<?php if($Num_pr3 > 0){	?>	
<div class="w3-container"><a href="https://pr-wr.allwellcenter.com/login_all.php?em_id=<?php echo $_SESSION['emid']; ?>"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบสำรองจ่าย RA</b></span>
     <span><b><?php echo $Num_pr3;?>  รายการ</b></span>
	</a></div></p>
<?php } ?>
		

<?php 

if($Num_pr2 > 0){	
?>	
<div class="w3-container"><a href="https://pr-wr.allwellcenter.com/login_all.php?em_id=<?php echo $_SESSION['emid']; ?>"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบขอซื้อภายใน</b></span>
     <span><b><?php echo $Num_pr2;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>
		
<?php if($Num_pr9 > 0){	?>	

<div class="w3-container"><a href="https://inter.allwellcenter.com/login_all.php?em_id=<?php echo $_SESSION['emid']; ?>"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบขอซื้อ (Inter)</b></span>
     <span><b><?php echo $Num_pr9;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>
		
<?php if($Num_pr8 > 0){	?>	

<div class="w3-container"><a href="https://inter.allwellcenter.com/login_all.php?em_id=<?php echo $_SESSION['emid']; ?>"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบสั่งซื้อ (Inter)</b></span>
     <span><b><?php echo $Num_pr8;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>
		
<?php } 

?>
</div>
<?php } ?>	
<?php
//}
?>	

<?php 

//อนุมัติเปอร์เซ็นต์ประมาณการ
$strSQLsa = "SELECT *  FROM tb_apppercent where  status_doc='Request' ";
$objQuerysa = mysqli_query($com,$strSQLsa) or die ("Error Query [".$strSQLsa."]");
$Num_Rowssa = mysqli_num_rows($objQuerysa);
	
//อนุมัติวันที่ต้องการสินค้า
$isale = 0;

$strSQLsa1 = "SELECT id_work  FROM tb_appdatesend where  status_doc='Request' ";
$objQuerysa1 = mysqli_query($com,$strSQLsa1) or die ("Error Query [".$strSQLsa1."]");
$Num_Rowssa1 = mysqli_num_rows($objQuerysa1);
while ($objResult1 = mysqli_fetch_array($objQuerysa1)) {
    $strSQL1sale = "SELECT id_work  FROM tb_register_data  where id_work  = '" . $objResult1["id_work"] . "' AND date_plan != '0000-00-00' AND date_request != '0000-00-00' ";
    $objQuery1sale = mysqli_query($com, $strSQL1sale) or die("Error Query [" . $strSQL1sale . "]");
    $Num_Rows1sale = mysqli_num_rows($objQuery1sale);
    if ($Num_Rows1sale > 0) {
        $objResultsale = mysqli_fetch_array($objQuery1sale);
        $isale++;
    }
}

if($isale > 0){?>	

<div class="w3-third" style="flex: 1;  background-color: #f0f0f0;">
<div class="w3-container"><font color ='blue'><b>Sale Report</b></font></div>
	
	
<?php if($Num_Rowssa > 0){	?>	
<div class="w3-container"><a href="https://action-plans.allwellcenter.com/login_all.php?em_id=<?php echo $_SESSION['emid']; ?>"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>อนุมัติเปอร์เซ็นต์ประมาณการ</b></span>
     <span><b><?php echo $isale;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	
	
<?php if($Num_Rowssa1 > 0){	?>	
<div class="w3-container"><a href="https://sale.allwellcenter.com/login_all.php?em_id=<?php echo $_SESSION['emid']; ?>"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>อนุมัติวันที่ต้องการสินค้า</b></span>
     <span><b><?php echo $Num_Rowssa1;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	


</div>
<?php } ?>
</div>	
<br>
<div class="w3-row" style="display: flex; gap: 10px;">
	
	
<?php 
	
	
//itsupport
$strSQLit4 = "SELECT *  FROM tb_ticket  where  send_dm='1' and status_doc = 'Request'";
$objQueryit4 = mysqli_query($itsupport,$strSQLit4) or die ("Error Query [".$strSQLit4."]");
$Num_Rowsait4 = mysqli_num_rows($objQueryit4);
	
	
$strSQLit5 = "SELECT *  FROM tb_ticket_report  where status_doc ='3'";
$objQueryit5 = mysqli_query($itsupport,$strSQLit5) or die ("Error Query [".$strSQLit4."]");
$Num_Rowsait5 = mysqli_num_rows($objQueryit5);
	
	

//คุณทำดี
$strSQLem = "SELECT *  FROM good_result where  rc_id='".$_SESSION['emid']."' AND read_ckk ='0'";
$objQueryem = mysqli_query($user,$strSQLem) or die ("Error Query [".$strSQLem."]");
$Num_Rowsem = mysqli_num_rows($objQueryem);
	
	
if(($Num_Rowsem+$Num_Rowsait4) > 0){	?>	

<div class="w3-third" style="flex: 1;  background-color: #f0f0f0;">
<div class="w3-container"><font color ='blue'><b>อื่นๆ</b></font></div>
	
	
<?php if($Num_Rowsait4 > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/itsupport/status_approvedm.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>อนุมัติการแจ้งงานไอที</b></span>
     <span><b><?php echo $Num_Rowsait4;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	
	
	
<?php if($Num_Rowsait5 > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/itsupport/status_rpapprovedm.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>อนุมัติการแจ้งขอข้อมูลไอที</b></span>
     <span><b><?php echo $Num_Rowsait5;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	
	
	
<?php if($Num_Rowssa > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/good_receive.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>การ์ดคุณทำดีที่ยังไม่ได้อ่าน</b></span>
     <span><b><?php echo $Num_Rowssa;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	
	
</div>
<?php } ?>	
	


</div>
<?php } ?>
	

<div class="w3-container w3-padding-large"></div>	
	
<?php 
$emid = $_SESSION['code'];


if($emid=='SUP_EN'){
$sddd = "and sale_code LIKE '%EN%'";	

}	

if ($_SESSION['name']=='บรรเทิง') {
	
$code	="and type_doc !='1' and type_doc !='4' and type_doc !='5' and type_doc !='6' and type_doc !='7'";	
?>	
	
<div class="w3-row" style="display: flex; gap: 10px;">	
<?php	
//ใบสั่งขาย	
$strSQL = "SELECT ref_id  FROM hos__so  where status_doc ='Request' and send_sup ='1' and send_cm ='0' and ic_ckk='0' $sddd";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rowsf = mysqli_num_rows($objQuery);

$strSQL = "SELECT ref_id  FROM hos__so  where status_doc ='Request' and send_sup ='1' and send_cm ='0' and ic_ckk='0' and que_ckk='1' $sddd";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rowsfd = mysqli_num_rows($objQuery);	

//ใบยืม	
$strSQL1 = "SELECT *  FROM hos__br  where  status_doc ='Request' and send_sup ='1' $sddd";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rowsf1 = mysqli_num_rows($objQuery1);
	
$strSQL1 = "SELECT *  FROM hos__br  where  status_doc ='Request' and send_sup ='1'  and que_ckk='1' $sddd";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rowsf1d = mysqli_num_rows($objQuery1);

//breq	
$strSQLfq = "SELECT *  FROM in__br  where  status_doc ='Request' and send_sup ='1'";
$objQueryfq = mysqli_query($conn,$strSQLfq) or die ("Error Query [".$strSQLfq."]");
$Num_Rowsfq = mysqli_num_rows($objQueryfq);
	
//breg	
$strSQLfg = "SELECT *  FROM hos__breg  where send_sup='1' and status_doc ='Request' and send_dm='0'";
$objQueryfg = mysqli_query($conn,$strSQLfg) or die ("Error Query [".$strSQLfg."]");
$Num_Rowsfg = mysqli_num_rows($objQueryfg);
	
//ลดหนี้	
$strSQLfc = "SELECT *  FROM tb_credit_note  where status_doc = 'Request' and send_sup = '1' and send_dm = '0' $sddd";
$objQueryfc = mysqli_query($conn,$strSQLfc) or die ("Error Query [".$strSQLfc."]");
$Num_Rowsfc = mysqli_num_rows($objQueryfc);

//smp	
$strSQLsm = "SELECT *  FROM hos__smp  where send_dm = '0' and send_stock = '0' and  send_admin = '0' and send_sup = '1' and status_sup = 'Request' $sddd";
$objQuerysm = mysqli_query($conn,$strSQLsm) or die ("Error Query [".$strSQLsm."]");
$Num_Rowssm = mysqli_num_rows($objQuerysm);
	
//jong	
$strSQLjn = "SELECT *  FROM hos__jongproduct  where send_sup = '1' and status_doc = 'Request' $sddd";
$objQueryjn = mysqli_query($conn,$strSQLjn) or die ("Error Query [".$strSQLjn."]");
$Num_Rowsjn = mysqli_num_rows($objQueryjn);
	
//change	
$strSQLch = "SELECT *  FROM hos__change  where status_doc ='Request' and send_sup ='1' and  adm_ckk='0' $sddd";
$objQuerych = mysqli_query($conn,$strSQLch) or die ("Error Query [".$strSQLch."]");
$Num_Rowsch = mysqli_num_rows($objQuerych);
	
//SPR	
$strSQLsp = "SELECT *  FROM hos__spr  where send_sup = '1' and sup_name='' and status_doc='Request'";
$objQuerysp = mysqli_query($conn,$strSQLsp) or die ("Error Query [".$strSQLsp."]");
$Num_Rowssp = mysqli_num_rows($objQuerysp);
	
//SPR MD	
$strSQLsp1 = "SELECT *  FROM hos__spr  where send_cm = '1' and cm_name ='' and status_doc='Request' and app_ckk='1'";
$objQuerysp1 = mysqli_query($conn,$strSQLsp1) or die ("Error Query [".$strSQLsp1."]");
$Num_Rowssp1 = mysqli_num_rows($objQuerysp1);
	
//รายการรับเรื่อง	
$strSQLeng = "SELECT *  FROM tb_register_eng  where send_eng='1' and summary_adm='0'";
$objQueryeng = mysqli_query($conn,$strSQLeng) or die ("Error Query [".$strSQLeng."]");
$Num_Rowseng = mysqli_num_rows($objQueryeng);	
	
//รายการ PO	
$strSQLengp = "SELECT *  FROM hos__po  where  send_sale = '1' and open_so = '0' $sddd";
$objQueryengp = mysqli_query($conn,$strSQLengp) or die ("Error Query [".$strSQLengp."]");
$Num_Rowsengp = mysqli_num_rows($objQueryengp);	
	
	
if(($Num_Rowsf+$Num_Rowsf1+$Num_Rowsfq+$Num_Rowsfg+$Num_Rowsfc+$Num_Rowssm+$Num_Rowsjn+$Num_Rowsch+$Num_Rowssp+$Num_Rowssp1+$Num_Rowseng+$Num_Rowsengp) > 0){
	
?>	
<div class="w3-third" style="flex: 1; background-color: #f0f0f0;">	
<div class="w3-container"><font color ='blue'><b> ERP SALE</b></font></div>	
	
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
	
<?php if($Num_Rowsfq > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_approvebrsup_breq.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบยืม BREQ</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsfq; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>			

<?php if($Num_Rowsfg > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_supbreg_app.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบยืม BREG</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsfg; ?> รายการ </b></span>
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


<?php if($Num_Rowssp > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_approvespr.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเบิก (SPR)</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowssp; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	


<?php if($Num_Rowssp1 > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_approvespr.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเบิก (SPR) ผู้บริหาร</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowssp1; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	

<?php if($Num_Rowseng > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_engkang.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>รายการรับเรื่องรอดำเนินการ</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowseng; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	


<?php if($Num_Rowsengp > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_engkang.php" target="_blank" class="w3-button w3-grey" 
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
$pr_main = "SELECT * FROM tb__pr WHERE ( pr_status = 1 OR  pr_status = 30 ) and ( pr_department = 'CS' OR pr_department = 'EN') ";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr2 = mysqli_num_rows($qpr_main);
	
$pr_main = "SELECT * FROM tb__pr WHERE ( pr_status = 1 OR  pr_status = 30 ) and ( pr_department = 'CS' OR pr_department = 'EN') and pr_need= 1";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr2_ = mysqli_num_rows($qpr_main);
	
	
//ใบเบิกสำนักงาน
$pr_main = "SELECT * FROM tb__wr WHERE wr_status = 2 and ( user_type = 'CS' OR user_type = 'EN')";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_wr2 = mysqli_num_rows($qpr_main);
	
$pr_main = "SELECT * FROM tb__wr WHERE wr_status = 2 and ( user_type = 'CS' OR user_type = 'EN') and wr_need=1";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_wr2_ = mysqli_num_rows($qpr_main);
	
//ใบเบิกค่าใช้จาย	
$pr_main = "SELECT * FROM tb__re WHERE ( status_re = 2 OR status_re = 30 ) and ( user_type = 'CS' OR user_type = 'EN')";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr1 = mysqli_num_rows($qpr_main);
	
//ใบสำรองจ่าย RA	
$pr_main = "SELECT * FROM tb__ra WHERE ( status_re = 2 OR status_re = 30 ) and ( user_type = 'CS' OR user_type = 'EN')";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr3 = mysqli_num_rows($qpr_main);
	
//ใบขอซื้อภายนอก	
$pr_main = "SELECT *  FROM po__main  where  send_sup = '1' and sup_name ='' and status_doc ='Request' $sddd";
$qpr_main = mysqli_query($inter,$pr_main);
$Num_pr9 = mysqli_num_rows($qpr_main);	


//อนุมัติรับเข้า	
$pr_main = "SELECT DISTINCT time_number,po_no  FROM po__sumall  where sup_en =''";
$qpr_main = mysqli_query($inter,$pr_main);
$Num_ppo = mysqli_num_rows($qpr_main);	
	
//อนุมัติรับเข้า SPR	
$pr_main = "SELECT *  FROM tb_spare  where  confirm_in !='0'";
$qpr_main = mysqli_query($inter,$pr_main);
$Num_spp = mysqli_num_rows($qpr_main);	
	

if(($Num_pr2+$Num_pr2_+$Num_wr2+$Num_wr2_+$Num_pr1+$Num_pr3+$Num_pr9+$Num_ppo+$Num_spp) > 0){
	
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
    <a href="https://inter.allwellcenter.com/login_all.php?em_id=<?php echo $_SESSION['emid']; ?>" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบขอซื้อ (INTER)</b></span>
        <span style="text-align: right;"><b><?php echo $Num_pr9; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>		
	
	
<?php if($Num_ppo > 0){ ?>	
<div class="w3-container">
    <a href="https://inter.allwellcenter.com/status_supapprove.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>อนุมัติการรับเข้าสินค้า</b></span>
        <span style="text-align: right;"><b><?php echo $Num_ppo; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>		

	
<?php if($Num_spp > 0){ ?>	
<div class="w3-container">
    <a href="https://inter.allwellcenter.com/status_pocreateint_sumall_product_en_allwell_sup_sp.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>อนุมัติการรับเข้าสินค้า Spare Parts</b></span>
        <span style="text-align: right;"><b><?php echo $Num_spp; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>		


</div>	
<?php } ?>
		
	

<?php	
//ใบเสนอราคา
$strSQLqu = "SELECT id FROM quotation_handler WHERE (status_all = 1 or status_all = 3 or status_all = 4 or status_all = 5) and sale_code LIKE '%EN%'";
$objQueryqu = mysqli_query($quo,$strSQLqu) or die ("Error Query [".$strSQLqu."]");
$Num_Rowsqu = mysqli_num_rows($objQueryqu);
	
$strSQLqu1 = "SELECT id FROM quotation_handler WHERE (status_all = 6 or status_all = 8 or status_all = 9) and sale_code LIKE '%EN%'";
$objQueryqu1 = mysqli_query($quo,$strSQLqu1) or die ("Error Query [".$strSQLqu1."]");
$Num_Rowsqu1 = mysqli_num_rows($objQueryqu1);
	
if(($Num_Rowsqu1+$Num_Rowsqu) > 0){
	
?>	
<div class="w3-third" style="flex: 1; background-color: #f0f0f0;">	
<div class="w3-container"><font color ='blue'><b>ใบเสนอราคา</b></font></div>	
<?php if($Num_Rowsqu > 0){ ?>	
<div class="w3-container">
    <a href="https://quotation.allwellcenter.com/report_split_status_sup" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเสนอราคาอนุมัติจัดทำ</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsqu; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>	
	
<?php if($Num_Rowsqu1> 0){ ?>	
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
//แจ้งเตือนช่าง	
$strSQL = "SELECT * FROM tb_comment_so LEFT JOIN hos__so ON tb_comment_so.ref_id = hos__so.ref_id WHERE tb_comment_so.comment_en != '' AND hos__so.status_doc = 'Approve' and name_en=''";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rowsnt = mysqli_num_rows($objQuery);

//AWL	
//QC A	
$strSQLqc = "SELECT add_name2 FROM tb_checking_en_main WHERE add_name2=''";
$objQueryqc = mysqli_query($service,$strSQLqc) or die ("Error Query [".$strSQLqc."]");
$Num_Rowsqc = mysqli_num_rows($objQueryqc);	
	
//QC B	
$strSQLqc1 = "SELECT DISTINCT model_id,model_name,po_no,date_check,product_id,add_code FROM tb_check_pro  WHERE approve_name=''";
$objQueryqc1 = mysqli_query($service,$strSQLqc1) or die ("Error Query [".$strSQLqc1."]");
$Num_Rowsqc1 = mysqli_num_rows($objQueryqc1);	
	
//PER	
$strSQLqc2 = "SELECT  DISTINCT model_id,service_order_no,per_number,po_no,hospital_name,model_name,add_by1,ckk_1,ckk_2,indefective_status,sup_status,sup_add,ckk_priority
FROM tb_indefective_check1 WHERE per_number != '' AND en_add = '1'  AND sup_add != '1' and sup_status != 'rejected'";
$objQueryqc2 = mysqli_query($service,$strSQLqc2) or die ("Error Query [".$strSQLqc2."]");
$Num_Rowsqc2 = mysqli_num_rows($objQueryqc2);	
	
//NBM	
//QC A	
$strSQLqcn = "SELECT add_name2 FROM tb_checking_en_main WHERE add_name2=''";
$objQueryqcn = mysqli_query($service,$strSQLqcn) or die ("Error Query [".$strSQLqcn."]");
$Num_Rowsqcn = mysqli_num_rows($objQueryqcn);	
	
//QC B	
$strSQLqcn1 = "SELECT DISTINCT model_id,model_name,po_no,date_check,product_id,add_code FROM tb_check_pro  WHERE approve_name=''";
$objQueryqcn1 = mysqli_query($service,$strSQLqcn1) or die ("Error Query [".$strSQLqcn1."]");
$Num_Rowsqcn1 = mysqli_num_rows($objQueryqcn1);	
	
//PER	
$strSQLqcn2 = "SELECT  DISTINCT model_id,service_order_no,per_number,po_no,hospital_name,model_name,add_by1,ckk_1,ckk_2,indefective_status,sup_status,sup_add,ckk_priority
FROM tb_indefective_check1 WHERE per_number != '' AND en_add = '1'  AND sup_add != '1' and sup_status != 'rejected'";
$objQueryqcn2 = mysqli_query($service,$strSQLqcn2) or die ("Error Query [".$strSQLqcn2."]");
$Num_Rowsqcn2 = mysqli_num_rows($objQueryqcn2);		
	
if(($Num_Rowsnt+$Num_Rowsqc+$Num_Rowsqc1+$Num_Rowsqc2+$Num_Rowsqcn+$Num_Rowsqcn1+$Num_Rowsqcn2) > 0){
	
?>	
<div class="w3-third" style="flex: 1; background-color: #f0f0f0;">	
<div class="w3-container"><font color ='blue'><b>SERVICE-ENGINEER</b></font></div>	
<?php if($Num_Rowsnt > 0){ ?>	
<div class="w3-container">
    <a href="https://service-engineer.allwellcenter.com/status_enkangcom.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>หมายเหตุแจ้งช่าง</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsnt; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>	
	
<?php if($Num_Rowsqc > 0){ ?>	
<div class="w3-container">
    <a href="https://service-engineer.allwellcenter.com/status_waitApprove_new.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>รายการสินค้าประภท A รออนุมัติ (AWL)</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsqc; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>	
	
<?php if($Num_Rowsqc1 > 0){ ?>	
<div class="w3-container">
    <a href="https://service-engineer.allwellcenter.com/status_waitApproveb.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>รายการสินค้าประภท B รออนุมัติ (AWL)</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsqc1; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>	
		
<?php if($Num_Rowsqc2 > 0){ ?>	
<div class="w3-container">
    <a href="https://service-engineer.allwellcenter.com/per_indefective_main1_status_sup.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบแจ้งผลิตภัณฑ์ชำรุด (PER)  (AWL)</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsqc2; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>	
			
<?php if($Num_Rowsqcn > 0){ ?>	
<div class="w3-container">
    <a href="https://service-engineernb.allwellcenter.com/status_waitApprove_new.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>รายการสินค้าประภท A รออนุมัติ (NBM)</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsqcn; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>	
	
<?php if($Num_Rowsqcn1 > 0){ ?>	
<div class="w3-container">
    <a href="https://service-engineernb.allwellcenter.com/status_waitApproveb.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>รายการสินค้าประภท B รออนุมัติ (NBM)</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsqcn1; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>	
		
<?php if($Num_Rowsqcn2 > 0){ ?>	
<div class="w3-container">
    <a href="https://service-engineernb.allwellcenter.com/per_indefective_main1_status_sup.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบแจ้งผลิตภัณฑ์ชำรุด (PER)  (NBM)</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsqcn2; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>	
				
</div>	
<?php } ?>	
	
<?php 

//หมายเหตุแจ้งจัดส่ง
$strSQL = "SELECT * FROM tb_comment_so LEFT JOIN hos__so ON tb_comment_so.ref_id = hos__so.ref_id WHERE tb_comment_so.comment_cs != '' AND hos__so.status_doc = 'Approve' and complete_csckk='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rowscs = mysqli_num_rows($objQuery);
	
//อุบัติเหตุ	
$strSQL = "select * from tb_accident_report_form WHERE status_doc=''";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rowscs1 = mysqli_num_rows($objQuery);

//แจ้งขอแก้ไขรถยนต์บริษัท
$strSQL = "select * from tb_car_request_car_repair WHERE status_doc=''";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rowscs2 = mysqli_num_rows($objQuery);
	

//เช็คระยะ
$strSQLcar = "select * from tb_bussend where brand !=''";
$objQuerycar = mysqli_query($com1,$strSQLcar) or die ("Error Query [".$strSQLcar."]");
$Num_Rowscar = mysqli_num_rows($objQuery);
	
$mile_no = "";	
$mile_new = "";	
while($objResultcar = mysqli_fetch_array($objQuerycar))
{
$bus_number = $objResultcar["bus_number"];	
	
$qfirst = "select mile_no from tb_check_car where code_car = '".$objResultcar["code_bus"]."' ORDER BY mile_no DESC LIMIT 1";
$first = mysqli_query($com1,$qfirst);
$ffirst = mysqli_fetch_array($first);

$qfirst1 = "select distance_mile_round from tb_car_distance where code_car = '".$objResultcar["code_bus"]."' ORDER BY distance_mile_round DESC LIMIT 1";
$first1 = mysqli_query($com1,$qfirst1);
$ffirst1 = mysqli_fetch_array($first1);

$qfirst2 = "select mile_new from tb_car_tire where code_car = '".$objResultcar["code_bus"]."' ORDER BY mile_new DESC LIMIT 1";
$first2 = mysqli_query($com1,$qfirst2);
$ffirst2 = mysqli_fetch_array($first2);
	
if($ffirst["mile_no"] >= $ffirst1["distance_mile_round"]){ 
$mile_no .= $bus_number . ", ";		
}
if($ffirst["mile_no"] >= $ffirst2["mile_new"]){
 $mile_new .= $bus_number . ", ";
}
}
	
$mile_no = rtrim($mile_no, ", ");
$mile_new = rtrim($mile_new, ", ");	
	
	
if(($Num_Rowscs+$Num_Rowscs1+$Num_Rowscs2) > 0){	?>	

<div class="w3-third" style="flex: 1;  background-color: #f0f0f0;">
<div class="w3-container"><font color ='blue'><b>ระบบลงงาน CS</b></font></div>

	
<?php if($Num_Rowscs > 0){	?>	
<div class="w3-container"><a href="https://cs.allwellcenter.com/status_cskangcom.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>หมายเหตุแจ้งจัดส่ง</b></span>
     <span><b><?php echo $Num_Rowscs;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	
	
<?php if($Num_Rowscs1 > 0){	?>	
<div class="w3-container"><a href="https://cs.allwellcenter.com/car_number_Sup.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>แบบขอรายงานการเกิดอุบัติเหตุ</b></span>
     <span><b><?php echo $Num_Rowscs1;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	
	
	
<?php if($Num_Rowscs2 > 0){	?>	
<div class="w3-container"><a href="https://cs.allwellcenter.com/car_number5_home_show_SUP.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>แจ้งขอแก้ไขรถยนต์บริษัท</b></span>
     <span><b><?php echo $Num_Rowscs2;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	

<?php if($mile_no!=''){ ?>
<div class="w3-container"><a href="https://cs.allwellcenter.com/car_number_main_Sup.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>เช็คระยะ 10,000 km</b></span>
     <span><b> <?php echo $mile_no;?>  </b></span>
	</a></div></p>
	
<?php } ?>		

<?php if($mile_new!=''){ ?>
<div class="w3-container"><a href="https://cs.allwellcenter.com/car_number_main_Sup.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>เปลี่ยนยาง 50,000 km</b></span>
     <span><b><?php echo $mile_new;?>  </b></span>
	</a></div></p>
	
<?php } ?>		

</div>
<?php } ?>	
		
	
	
<?php 

//คุณทำดี
$strSQLem = "SELECT *  FROM good_result where  rc_id='".$_SESSION['em_id']."' AND read_ckk ='0'";
$objQueryem = mysqli_query($user,$strSQLem) or die ("Error Query [".$strSQLem."]");
$Num_Rowsem = mysqli_num_rows($objQueryem);
	
//ใบแจ้งสินค้าไม่สมบูรณ์
$strSQLnc = "SELECT *  FROM no__complete  where  status_doc ='' and send_doc ='1' and send_sup ='0' $code";
$objQuerync = mysqli_query($conn,$strSQLnc) or die ("Error Query [".$strSQLnc."]");
$Num_Rowsnc = mysqli_num_rows($objQuerync);
	
//อนุมัติสินค้าไม่สมบูรณ์
$strSQLnc1 = "SELECT *  FROM no__complete  where  status_doc ='Request'  and send_sup ='1' $code";
$objQuerync1 = mysqli_query($conn,$strSQLnc1) or die ("Error Query [".$strSQLnc1."]");
$Num_Rowsnc1 = mysqli_num_rows($objQuerync1);
	
	
//ใบ Car
$strSQLca = "select * from car WHERE status IN ('F0', 'H1', 'F2') AND (division1='CS' OR division1='EN' OR car_to_all1 LIKE '%CS%' OR car_to_all1 LIKE '%EN%') ";
$objQueryca = mysqli_query($car,$strSQLca) or die ("Error Query [".$strSQLca."]");
$Num_Rowsca = mysqli_num_rows($objQueryca);
	
//ใบ Par
$strSQLpa = "select * from par WHERE (status='F0' or status='H1' or status='F2') AND (division='CS' OR division='EN') ";
$objQuerypa = mysqli_query($car,$strSQLpa) or die ("Error Query [".$strSQLpa."]");
$Num_Rowspa = mysqli_num_rows($objQuerypa);
	
//ISO
$strSQLiso = "select * from dar WHERE status='0' AND (division='CS' OR division='EN') ";
$objQueryiso = mysqli_query($iso,$strSQLiso) or die ("Error Query [".$strSQLiso."]");
$Num_Rowsiso = mysqli_num_rows($objQueryiso);
	
	
if(($Num_Rowsem+$Num_Rowsnc+$Num_Rowsca+$Num_Rowspa+$Num_Rowsiso) > 0){	?>	

<div class="w3-third" style="flex: 1;  background-color: #f0f0f0;">
<div class="w3-container"><font color ='blue'><b>อื่นๆ</b></font></div>

	
<?php if($Num_Rowsnc > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/no_complete/status_editor_en.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบแจ้งสินค้าไม่สมบูรณ์</b></span>
     <span><b><?php echo $Num_Rowsnc;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	
	
	
<?php if($Num_Rowsnc1 > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/no_complete/status_approve.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>อนุมัติใบแจ้งสินค้าไม่สมบูรณ์</b></span>
     <span><b><?php echo $Num_Rowsnc1; ?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	
		
	
<?php if($Num_Rowssa > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/good_receive.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>การ์ดคุณทำดีที่ยังไม่ได้อ่าน</b></span>
     <span><b><?php echo $Num_Rowsem;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	
	
<?php if($Num_Rowsca > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/car/acarlist.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบขอให้แก้ไขรออนุมัติ</b></span>
     <span><b><?php echo $Num_Rowsca;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	

<?php if($Num_Rowspa > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/car/aparlist.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบขอให้พัฒนารออนุมัติ</b></span>
     <span><b><?php echo $Num_Rowspa;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	


<?php if($Num_Rowsiso > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/iso/ap.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>เอกสาร ISO รออนุมัติ</b></span>
     <span><b><?php echo $Num_Rowsiso;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	

	
</div>
<?php } ?>	
	


</div>	
<?php } ?>



