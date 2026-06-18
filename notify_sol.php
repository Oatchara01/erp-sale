
	
<?php 
$code = $_SESSION['code'];

//$code	="and type_doc !='1' and type_doc !='4' and type_doc !='5' and type_doc !='6' and type_doc !='7'";	

?>	
	
<div class="w3-row" style="display: flex; gap: 10px;">	
<?php	
	
//รายการรับเรื่อง	
$strSQLeng = "SELECT *  FROM tb_register_story  where summary_sale = '0' and sale_code LIKE '%SOL%'";
$objQueryeng = mysqli_query($conn,$strSQLeng) or die ("Error Query [".$strSQLeng."]");
$Num_Rowseng = mysqli_num_rows($objQueryeng);	
	
//รายการ PO	
$strSQLengp = "SELECT *  FROM hos__po  where  send_sale = '1' and open_so = '0'  and sale_code LIKE '%SOL%'";
$objQueryengp = mysqli_query($conn,$strSQLengp) or die ("Error Query [".$strSQLengp."]");
$Num_Rowsengp = mysqli_num_rows($objQueryengp);	
	
//เอกสารส่งกลับแก้ไข
$strSQLedso = "SELECT DISTINCT hos__so.ref_id FROM  (hos__so LEFT JOIN tb_editdoc ON hos__so.ref_id=tb_editdoc.ref_id) WHERE hos__so.sale_code LIKE '%SOL%' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedso = mysqli_query($conn,$strSQLedso) or die ("Error Query [".$strSQLedso."]");
$Num_Rowsedso = mysqli_num_rows($objQueryedso);
	
$strSQLedbr = "SELECT DISTINCT hos__br.ref_id_br FROM  (hos__br LEFT JOIN tb_editdoc ON hos__br.ref_id_br=tb_editdoc.ref_id) WHERE hos__br.sale_code LIKE '%SOL%' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedbr = mysqli_query($conn,$strSQLedbr) or die ("Error Query [".$strSQLedbr."]");
$Num_Rowsedbr = mysqli_num_rows($objQueryedbr);
	
$strSQLedsm = "SELECT DISTINCT hos__smp.ref_idsmp FROM  (hos__smp LEFT JOIN tb_editdoc ON hos__smp.ref_idsmp=tb_editdoc.ref_id) WHERE hos__smp.sale_code LIKE '%SOL%' and hos__smp.sale_code!='SOL91' and hos__smp.sale_code!='SOL92' and hos__smp.sale_code!='SOL93' and hos__smp.sale_code!='SOL94' and status_sup ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedsm = mysqli_query($conn,$strSQLedsm) or die ("Error Query [".$strSQLedsm."]");
$Num_Rowsedsm = mysqli_num_rows($objQueryedsm);

$strSQLedch = "SELECT DISTINCT hos__change.ref_id FROM  (hos__change LEFT JOIN tb_editdoc ON hos__change.ref_id=tb_editdoc.ref_id) WHERE hos__change.sale_code LIKE '%SOL%' and hos__change.sale_code!='SOL91' and hos__change.sale_code!='SOL92' and hos__change.sale_code!='SOL93' and hos__change.sale_code!='SOL94' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedch = mysqli_query($conn,$strSQLedch) or die ("Error Query [".$strSQLedch."]");
$Num_Rowsedch = mysqli_num_rows($objQueryedch);
	
$strSQLedsc = "SELECT DISTINCT hos__consig.ref_id FROM  (hos__consig LEFT JOIN tb_editdoc ON hos__consig.ref_id=tb_editdoc.ref_id) WHERE hos__consig.sale_code LIKE '%SOL%' and hos__consig.sale_code!='SOL91' and hos__consig.sale_code!='SOL92' and hos__consig.sale_code!='SOL93' and hos__consig.sale_code!='SOL94' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedsc = mysqli_query($conn,$strSQLedsc) or die ("Error Query [".$strSQLedsc."]");
$Num_Rowsedsc = mysqli_num_rows($objQueryedsc);
	
$strSQLedsco = "SELECT DISTINCT so__main.ref_id FROM  (so__main LEFT JOIN tb_editdoc ON so__main.ref_id=tb_editdoc.ref_id) WHERE so__main.employee_name LIKE '%SOL%' and so__main.employee_name!='SOL91' and so__main.employee_name!='SOL92' and so__main.employee_name!='SOL93' and so__main.employee_name!='SOL94' and status_doc ='Request' and tb_editdoc.sale_edit !=''";
$objQueryedsco = mysqli_query($conn,$strSQLedsco) or die ("Error Query [".$strSQLedsco."]");
$Num_Rowsedsco = mysqli_num_rows($objQueryedsco);
	
//	
$strSQL = "
    SELECT DATE(date_runiv) AS d, COUNT(*) AS cnt
    FROM hos__rental_runiv
    WHERE ckk_open='0'
      AND close_ckk='0'
      AND DATE(date_runiv) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 6 DAY)
    GROUP BY DATE(date_runiv)
    ORDER BY d ASC
";
$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [".$strSQL."]");

$total = 0; // ตัวแปรเก็บผลรวมทั้งหมด

while ($row = mysqli_fetch_assoc($objQuery)) {
    //echo $row['d']." : ".$row['cnt']." รายการ<br>";
    $total += $row['cnt']; // บวกจำนวนแต่ละวันเข้า total
}
	
	
if(($Num_Rowseng+$Num_Rowsengp+$Num_Rowsdm+$Num_Rowsrs+$Num_Rowsedso+$Num_Rowsedbr+$Num_Rowsedsm+$Num_Rowsedch+$Num_Rowsedsc+$Num_Rowsedsco+$total) > 0){
	
?>	
<div class="w3-third" style="flex: 1; background-color: #f0f0f0;">	
<div class="w3-container"><font color ='blue'><b> ERP SALE</b></font></div>	
	

<?php if(($Num_Rowsedso+$Num_Rowsedbr+$Num_Rowsedsm+$Num_Rowsedch+$Num_Rowsedsc+$Num_Rowsedsco) > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_editwailsale.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>มีเอกสารส่งกลับรอแก้ไข</b></span>
        <span style="text-align: right;"><b><?php echo ($Num_Rowsedso+$Num_Rowsedbr+$Num_Rowsedsm+$Num_Rowsedch+$Num_Rowsedsc+$Num_Rowsedsp+$Num_Rowsedsco); ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	

	
<?php if($total > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_allwellrental_kang.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบสั่งเช่ารอต่อสัญญา</b></span>
        <span style="text-align: right;"><b><?php echo $total; ?> รายการ </b></span>
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



</div>	
<?php } ?>
	

	

<?php 

//คุณทำดี
$strSQLem = "SELECT *  FROM good_result where  rc_id='".$_SESSION['em_id']."' AND read_ckk ='0'";
$objQueryem = mysqli_query($user,$strSQLem) or die ("Error Query [".$strSQLem."]");
$Num_Rowsem = mysqli_num_rows($objQueryem);
	
	
	
	
if(($Num_Rowsem) > 0){	?>	

<div class="w3-third" style="flex: 1;  background-color: #f0f0f0;">
<div class="w3-container"><font color ='blue'><b>อื่นๆ</b></font></div>


	
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
