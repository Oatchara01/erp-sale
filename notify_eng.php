	
<div class="w3-row" style="display: flex; gap: 10px;">	
<?php	
	
//รายการรับเรื่อง	
$strSQLeng = "SELECT *  FROM tb_register_eng  where send_eng='1' and summary_adm='0'";
$objQueryeng = mysqli_query($conn,$strSQLeng) or die ("Error Query [".$strSQLeng."]");
$Num_Rowseng = mysqli_num_rows($objQueryeng);	
	
//รายการ PO	
$strSQLengp = "SELECT *  FROM hos__po  where  send_sale = '1' and open_so = '0' and sale_code LIKE '%EN%'";
$objQueryengp = mysqli_query($conn,$strSQLengp) or die ("Error Query [".$strSQLengp."]");
$Num_Rowsengp = mysqli_num_rows($objQueryengp);	
	
	

//เอกสารส่งกลับแก้ไข
$strSQLedso = "SELECT DISTINCT hos__so.ref_id FROM  (hos__so LEFT JOIN tb_editdoc ON hos__so.ref_id=tb_editdoc.ref_id) WHERE hos__so.sale_code LIKE '%EN%' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedso = mysqli_query($conn,$strSQLedso) or die ("Error Query [".$strSQLedso."]");
$Num_Rowsedso = mysqli_num_rows($objQueryedso);
	
$strSQLedbr = "SELECT DISTINCT hos__br.ref_id_br FROM  (hos__br LEFT JOIN tb_editdoc ON hos__br.ref_id_br=tb_editdoc.ref_id) WHERE hos__br.sale_code LIKE '%EN%' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedbr = mysqli_query($conn,$strSQLedbr) or die ("Error Query [".$strSQLedbr."]");
$Num_Rowsedbr = mysqli_num_rows($objQueryedbr);
	
$strSQLedsm = "SELECT DISTINCT hos__smp.ref_idsmp FROM  (hos__smp LEFT JOIN tb_editdoc ON hos__smp.ref_idsmp=tb_editdoc.ref_id) WHERE hos__smp.sale_code LIKE '%EN%' and status_sup ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedsm = mysqli_query($conn,$strSQLedsm) or die ("Error Query [".$strSQLedsm."]");
$Num_Rowsedsm = mysqli_num_rows($objQueryedsm);

$strSQLedch = "SELECT DISTINCT hos__change.ref_id FROM  (hos__change LEFT JOIN tb_editdoc ON hos__change.ref_id=tb_editdoc.ref_id) WHERE hos__change.sale_code LIKE '%EN%' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedch = mysqli_query($conn,$strSQLedch) or die ("Error Query [".$strSQLedch."]");
$Num_Rowsedch = mysqli_num_rows($objQueryedch);
	
$strSQLedsc = "SELECT DISTINCT hos__consig.ref_id FROM  (hos__consig LEFT JOIN tb_editdoc ON hos__consig.ref_id=tb_editdoc.ref_id) WHERE hos__consig.sale_code LIKE '%EN%' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedsc = mysqli_query($conn,$strSQLedsc) or die ("Error Query [".$strSQLedsc."]");
$Num_Rowsedsc = mysqli_num_rows($objQueryedsc);
	
$strSQLedsp = "SELECT DISTINCT hos__spr.ref_id FROM  (hos__spr LEFT JOIN tb_editdoc ON hos__spr.ref_id=tb_editdoc.ref_id) WHERE hos__spr.sale_code LIKE '%EN%' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedsp = mysqli_query($conn,$strSQLedsp) or die ("Error Query [".$strSQLedsp."]");
$Num_Rowsedsp = mysqli_num_rows($objQueryedsp);

	
	
	
	
	
if(($Num_Rowseng+$Num_Rowsengp+$Num_Rowsedso+$Num_Rowsedbr+$Num_Rowsedsm+$Num_Rowsedch+$Num_Rowsedsc+$Num_Rowsedsp) > 0){
	
?>	
<div class="w3-third" style="flex: 1; background-color: #f0f0f0;">	
<div class="w3-container"><font color ='blue'><b> ERP SALE</b></font></div>	
	
	
<?php if(($Num_Rowsedso+$Num_Rowsedbr+$Num_Rowsedsm+$Num_Rowsedch+$Num_Rowsedsc+$Num_Rowsedsp) > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_editwailsale.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>มีเอกสารส่งกลับรอแก้ไข</b></span>
        <span style="text-align: right;"><b><?php echo ($Num_Rowsedso+$Num_Rowsedbr+$Num_Rowsedsm+$Num_Rowsedch+$Num_Rowsedsc+$Num_Rowsedsp); ?> รายการ </b></span>
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
    <a href="https://sol.allwellcenter.com/status_po_sale.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>เอกสาร PO รอเปิดใบสั่งขาย</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsengp; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	


</div>	
<?php } ?>
	
	
	
	
<?php	
//แจ้งเตือนช่าง	
$strSQL = "SELECT * FROM tb_comment_so LEFT JOIN hos__so ON tb_comment_so.ref_id = hos__so.ref_id WHERE tb_comment_so.comment_en != '' AND hos__so.status_doc = 'Approve' and name_en=''";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rowsnt = mysqli_num_rows($objQuery);

	
if(($Num_Rowsnt) > 0){
	
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
	
				
</div>	
<?php } ?>	
	

	
<?php 

//คุณทำดี
$strSQLem = "SELECT *  FROM good_result where  rc_id='".$_SESSION['em_id']."' AND read_ckk ='0'";
$objQueryem = mysqli_query($user,$strSQLem) or die ("Error Query [".$strSQLem."]");
$Num_Rowsem = mysqli_num_rows($objQueryem);
	
//ใบแจ้งสินค้าไม่สมบูรณ์
$strSQLnc = "SELECT *  FROM no__complete  where  status_doc ='' and send_doc ='1' and send_sup ='0' and type_doc='2'";
$objQuerync = mysqli_query($conn,$strSQLnc) or die ("Error Query [".$strSQLnc."]");
$Num_Rowsnc = mysqli_num_rows($objQuerync);
	
	
if(($Num_Rowsem+$Num_Rowsnc) > 0){	?>	

<div class="w3-third" style="flex: 1;  background-color: #f0f0f0;">
<div class="w3-container"><font color ='blue'><b>อื่นๆ</b></font></div>

	
<?php if($Num_Rowsnc > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/no_complete/status_editor_en.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบแจ้งสินค้าไม่สมบูรณ์</b></span>
     <span><b><?php echo $Num_Rowsnc;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	
	
	
<?php if($Num_Rowssa > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/good_receive.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>การ์ดคุณทำดีที่ยังไม่ได้อ่าน</b></span>
     <span><b><?php echo $Num_Rowsem;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	
	


	
</div>
<?php } ?>	
	


</div>	
