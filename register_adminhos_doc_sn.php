<?php include ("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>
<body>
<?php 
$ref_id =$_GET["ref_id"];
$status =$_GET["status"];

if($status == 'so'){
    $sql = "SELECT *   FROM hos__br where ref_id_br ='".$ref_id."' ";
    $qry = mysqli_query($conn,$sql) or die(mysqli_error());
    $rs = mysqli_fetch_assoc($qry);
//$bill_name =$rs["customer"];
    
} else {
    $sql = "SELECT *   FROM hos__so where ref_id = '".$ref_id."'";
    $qry = mysqli_query($conn,$sql) or die(mysqli_error());
    $rs = mysqli_fetch_assoc($qry);
	//$bill_name =$rs["bill_name"];
}

$sql1 = "select * from tb_register_data where ref_id = '".$ref_id."'";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
?>
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom" style="padding: 20px;">
<div>
<fieldset><legend><b>เอกสารที่เกี่ยวข้อง</b></legend>	
	
	
<section>
<?php if($status == 'so'){ ?>
<b>เลขที่เอกสาร</b> : <?php echo $rs['iv_no']; ?> <br>
<b>ชื่อลูกค้า/โรงพยาบาล</b> : <?php echo $rs["customer"];?> <br>
<b>ที่อยู่</b> : <?php echo $rs["address"];?> <br>
<b>วันที่ รับ-ส่ง</b> : <?php echo $fetch1["start_date"]; ?>
<?php } else { ?>
<b>เลขที่เอกสาร</b> : <?php echo $rs['iv_no']; ?> <br>
<b>ชื่อลูกค้า/โรงพยาบาล</b> : <?php echo $rs["bill_name"];?> <br>
<b>ที่อยู่</b> : <?php echo $rs["bill_address"];?> <br>
<b>วันที่ รับ-ส่ง</b> : <?php echo $fetch1["start_date"]; ?>
<?php } ?>


</section>
<a href="register_adminhos_doc_sn_full.php?ref_id=<?php echo $ref_id;  ?>" class="w3-button w3-khaki" target="_blank" rel="noopener noreferrer">รายละเอียดเอกสาร</a>		
<!--section>
<table style="width:70%; margin:0% 15%;">
    <tr>
        <th style="text-align:left;"><b>ชื่อสินค้า</b></th>
        <th style="text-align:left;"><b>SN</b></th>
        <th style="text-align:left;"><b>รายละเอียดเอกสาร</b></th>
    </tr>
<?php 
if($status == 'so'){
$strSQL1_sn = "SELECT * FROM  (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$ref_id."'  AND sn != ''  and unit_name='เตียง'";
} else {
$strSQL1_sn = "SELECT * FROM  (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' AND sn != ''   and unit_name='เตียง' ";
}
$objQuery1_sn = mysqli_query($conn,$strSQL1_sn) or die ("Error Query [".$strSQL1_sn."]");
$Num_Rows1_sn = mysqli_num_rows($objQuery1_sn);
while($objResult1_sn = mysqli_fetch_array($objQuery1_sn)){ ?>
<?php if($objResult1_sn["sn"] != "") { 
$key_sn = (explode("\n",$objResult1_sn["sn"]));
$key_sn_null = implode("null",$key_sn);
foreach ($key_sn as $key => $value) {
if(strlen($key_sn[$key]) > 2){
    echo '
    <tr>
    <td>'.$objResult1_sn['sol_name'].'</td>
    <td>'.$key_sn[$key].'</td>
    <td><a href="register_adminhos_doc_sn1.php?product_sn='.$key_sn[$key].'&product_ID='.$objResult1_sn['product_ID'].'&ref_id='.$ref_id.'" class="w3-button w3-khaki" target="_blank" rel="noopener noreferrer">รายละเอียดเอกสาร</a></td>
    </tr>
    ';
}
}
?>
<?php } ?>
<?php } ?>
</table>

</section-->
</fieldset>
</div>  
</div>  

</body>

<div id="cr_bar"> <?php include "foot.php"; ?></div>	