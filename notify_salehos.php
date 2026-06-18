
	
<?php 
$emid = $_SESSION['code'];

//$code	="and type_doc !='1' and type_doc !='4' and type_doc !='5' and type_doc !='6' and type_doc !='7'";	

?>	
	
<div class="w3-row" style="display: flex; gap: 10px;">	
<?php	
	
//รายการรับเรื่อง	
$strSQLeng = "SELECT *  FROM tb_register_story  where summary_sale = '0' and sale_code ='".$emid."'";
$objQueryeng = mysqli_query($conn,$strSQLeng) or die ("Error Query [".$strSQLeng."]");
$Num_Rowseng = mysqli_num_rows($objQueryeng);	
	
//รายการ PO	
$strSQLengp = "SELECT *  FROM hos__po  where  send_sale = '1' and open_so = '0'  and sale_code ='".$emid."'";
$objQueryengp = mysqli_query($conn,$strSQLengp) or die ("Error Query [".$strSQLengp."]");
$Num_Rowsengp = mysqli_num_rows($objQueryengp);	
	
//แบบสอบถามสินค้าสาธิต	
$strSQLdm = "SELECT *  FROM hos__br  where research_demo ='1' and status_doc ='Approve'  and sale_code ='".$emid."'";
$objQuerydm = mysqli_query($conn,$strSQLdm) or die ("Error Query [".$strSQLdm."]");
$Num_Rowsdm = mysqli_num_rows($objQuerydm);

//แบบสอบถามหลังการขาย	AND DATEDIFF(CURDATE(), iv_date) >= 30
$strSQLrs = "SELECT *  FROM hos__so  where status_doc ='Approve' and close_reseach ='0' and reseach_kk='1' and status_doc = 'Approve' and iv_date !='0000-00-00' and sale_code!='S31' and sale_code!='S32' and sale_code!='MM1' and sale_code!='SM1'   and sale_code ='".$emid."'";
$objQueryrs = mysqli_query($conn,$strSQLrs) or die ("Error Query [".$strSQLrs."]");
$Num_Rowsrs = mysqli_num_rows($objQueryrs);
	

//เอกสารส่งกลับแก้ไข
$strSQLedso = "SELECT DISTINCT hos__so.ref_id FROM  (hos__so LEFT JOIN tb_editdoc ON hos__so.ref_id=tb_editdoc.ref_id) WHERE hos__so.sale_code ='".$emid."' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedso = mysqli_query($conn,$strSQLedso) or die ("Error Query [".$strSQLedso."]");
$Num_Rowsedso = mysqli_num_rows($objQueryedso);
	
$strSQLedbr = "SELECT DISTINCT hos__br.ref_id_br FROM  (hos__br LEFT JOIN tb_editdoc ON hos__br.ref_id_br=tb_editdoc.ref_id) WHERE hos__br.sale_code ='".$emid."' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedbr = mysqli_query($conn,$strSQLedbr) or die ("Error Query [".$strSQLedbr."]");
$Num_Rowsedbr = mysqli_num_rows($objQueryedbr);
	
$strSQLedsm = "SELECT DISTINCT hos__smp.ref_idsmp FROM  (hos__smp LEFT JOIN tb_editdoc ON hos__smp.ref_idsmp=tb_editdoc.ref_id) WHERE hos__smp.sale_code ='".$emid."' and status_sup ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedsm = mysqli_query($conn,$strSQLedsm) or die ("Error Query [".$strSQLedsm."]");
$Num_Rowsedsm = mysqli_num_rows($objQueryedsm);

$strSQLedch = "SELECT DISTINCT hos__change.ref_id FROM  (hos__change LEFT JOIN tb_editdoc ON hos__change.ref_id=tb_editdoc.ref_id) WHERE hos__change.sale_code ='".$emid."' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedch = mysqli_query($conn,$strSQLedch) or die ("Error Query [".$strSQLedch."]");
$Num_Rowsedch = mysqli_num_rows($objQueryedch);
	
$strSQLedsc = "SELECT DISTINCT hos__consig.ref_id FROM  (hos__consig LEFT JOIN tb_editdoc ON hos__consig.ref_id=tb_editdoc.ref_id) WHERE hos__consig.sale_code ='".$emid."' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedsc = mysqli_query($conn,$strSQLedsc) or die ("Error Query [".$strSQLedsc."]");
$Num_Rowsedsc = mysqli_num_rows($objQueryedsc);
	
$strSQLedsp = "SELECT DISTINCT hos__spr.ref_id FROM  (hos__spr LEFT JOIN tb_editdoc ON hos__spr.ref_id=tb_editdoc.ref_id) WHERE hos__spr.sale_code ='".$emid."' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedsp = mysqli_query($conn,$strSQLedsp) or die ("Error Query [".$strSQLedsp."]");
$Num_Rowsedsp = mysqli_num_rows($objQueryedsp);
	
	
if(($Num_Rowseng+$Num_Rowsengp+$Num_Rowsdm+$Num_Rowsrs+$Num_Rowsedso+$Num_Rowsedbr+$Num_Rowsedsm+$Num_Rowsedch+$Num_Rowsedsc+$Num_Rowsedsp) > 0){
	
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
    <a href="https://sol.allwellcenter.com/status_storykangsale.php" target="_blank" class="w3-button w3-grey" 
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

<?php if($Num_Rowsdm > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_saledemo.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>แบบสอบถามสินค้าสาธิต</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsdm; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	

<?php if($Num_Rowsrs > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_saleresearch.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>แบบสอบถามหลังการขาย </b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsrs; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	




</div>	
<?php } ?>
	

	

<?php 

//คุณทำดี
$strSQLem = "SELECT *  FROM good_result where  rc_id='".$_SESSION['emid']."' AND read_ckk ='0'";
$objQueryem = mysqli_query($user,$strSQLem) or die ("Error Query [".$strSQLem."]");
$Num_Rowsem = mysqli_num_rows($objQueryem);
	
//ใบแจ้งสินค้าไม่สมบูรณ์
$strSQLnc = "SELECT *  FROM no__complete  where  status_doc ='' and send_doc ='1' and send_sup ='0' and type_doc='5' and sale_code ='".$emid."'";
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
