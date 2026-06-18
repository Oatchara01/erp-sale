<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>อนุมัติใบกำกับภาษี</h4></div>

</form>
<?php	
date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$strSQL = "SELECT ref_id,register_date,doc_no,doc_release_date,delivery_contact,approve_complete,ckk_h,bill_vat,select_type_doc,sale_channel   FROM so__main  where bill_vat='1' and send_supadm = '1' and status_vat =''  and cancel_ckk='0' and sale_channel !='4'";

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$strSQL .=" order  by main_id DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);


?>
<div class="w3-container">
	</p>
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%">เลขที่อ้างอิง</th>
<th width="10%">ประเภทเอกสาร</th>
<th width="10%">วันที่ลงทะเบียน</th>
<th width="10%">เลขที่เอกสาร</th> 
<th width="10%">วันที่ออกเอกสาร</th>
<th width="23%">รายการสินค้า</th>
<th width="22%">ชื่อลูกค้า</th>
<th width="20%">ช่องทางการขาย</th>
<th width="5%">สถานะการขาย</th>
<th width="5%">สถานะการอนุมัติ</th>
<th width="5%">ดูรายละเอียด</th>
</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
<tbody>




<tr>
	
	
		<td><?php echo $objResult["ref_id"];?></td>
		
	
<td><?php if ($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='2'){
	echo 'ใบยืม'; }else { echo 'ใบสั่งขาย';  }?></td>
<td><?php echo DateThai($objResult["register_date"]);?></td>
<td><?php echo $objResult["doc_no"];?></td>
<td>
<?php if ($objResult["doc_release_date"]=="") {
	echo "-"; 
	} 
	else 
	{ echo DateThai($objResult["doc_release_date"]);
	}
	?> 
</td>
<td><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
///echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
	echo $objResult1["sol_name"]; 
	?><br />
<?php
}
?>
</div>
</td>
<td><div align="left"><?php echo $objResult["delivery_contact"];?></div></td>


	

<td><div align="left">
	

<?php
$strSQL2 = "SELECT salechannel_nameshort  FROM  tb_salechannel  where salechannel_ID  = '".$objResult["sale_channel"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

while($objResult2 = mysqli_fetch_array($objQuery2))
{
?>


<?php echo $objResult2["salechannel_nameshort"]; ?>
<?php
}
?>

</div></td>
<?php
if($objResult["status_doc"]=='1'){
	?>
<td bgcolor="#FF3030"><?php echo "กำลังดำเนินการ";?></td>

<?php
}else if ($objResult["status_doc"]=='2'){	
?>
<td bgcolor="#00FF00"><?php echo "สมบูรณ์";?></td>

<?php
}else{	
?>
<td ><?php echo $objResult["status"];?></td>
<?php
}
?>

<?php
					if($objResult["approve_complete"]=='Rejected'){	?>
						<td bgcolor="#FF3030"><?php echo $objResult["approve_complete"];?></td>
				<?php }else if($objResult["cancel_ckk"]=='1'){	?>
						<td bgcolor="#FF3030"><?php echo 'ยกเลิก';?></td>
				<?php }
					else if ($objResult["approve_complete"]=='Approve'){ ?>
				<td bgcolor="#00FF00"><?php echo $objResult["approve_complete"];?></td>
				<?php }
					else{ ?>
					<td ><?php echo $objResult["approve_complete"];?></td>
				<?php } ?>

<td><a href="register_supadm.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>
	
</tr>


<?php

$i++;
}
?>
</tbody>
</table>


      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>
</body>
</html>