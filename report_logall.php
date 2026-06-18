<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 14px; color: #FF0000;}
.style17 {font-size: 14px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style30 {font-size: 14px; color: #000000;}
.style40 {font-size: 15px; color: #000000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#CCFF66;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#FF3333;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}



</style>



<?php

date_default_timezone_set("Asia/Bangkok");
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$type_doc = $_GET["type_doc"];
include"dbconnect.php";



?>
<body>

<center>
<span class="style15">รายการ การปรับเพิ่ม - ลบ รายการสินค้า</span></p>
</center>
</p>

<?php if ($type_doc =='1'){ ?>
</p>
<center>
<span class="style15">Sale Online</span></p>
</center>

</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">ช่องทาง</td>
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 
<td width="8%" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="8%" align="center" class="style30">ยอดรวม</td> 
<td width="12%" align="center" class="style30">หมายเหตุ</td> 
<td width="12%" align="center" class="style30">ปรับโดย</td> 
<td width="5%" align="center" class="style30">สถานะ</td> 

</tr>

<?php
$strSQL = "SELECT ref_idd,date_edit,add_date,add_by,sale_count,price_per_unit,sum_amount,sale_remark,product_id,delete_ckk,new_proadm FROM so__submain_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_edit <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery)) {

$strSQL1 = "SELECT doc_no,select_type_doc FROM so__main WHERE ref_id = '".$objResult["ref_idd"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


	?>

<tr>
<td  class="style30"><?php echo $objResult["ref_idd"]; ?></td>
<td  class="style30"><?php echo $objResult["add_date"]; ?></td>
<td  class="style30"><a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_idd"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["doc_no"]; ?></span></a></td>
<td  class="style30">
	
<?php if($objResult1["select_type_doc"]=='1' or $objResult1["select_type_doc"]=='2'){
	
echo 'ใบยืม';

}else if($objResult1["select_type_doc"]=='3' or $objResult1["select_type_doc"]=='4'){
	
echo 'ใบสั่งขาย';

}?>

</td>
<td  class="style30"><?php echo $objResult2["sol_name"]; ?></td> 
<td  class="style30"><div align="right"><?php echo $objResult["sale_count"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["price_per_unit"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["sum_amount"]; ?></div></td> 
<td  class="style30"><?php echo $objResult["sale_remark"]; ?></td> 
<td  class="style30"><?php echo $objResult["add_by"]; ?></td> 

<?php if($objResult["new_proadm"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#00FF00" >ADD</td> 
<?php }else if($objResult["delete_ckk"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#FF3030" >DELETE</td> 
	<?php } ?>
</tr>
<?php 
	}
?>

</table>

<?php } ?>


<?php if ($type_doc =='2'){ ?>
</p>
<center>
<span class="style15">ใบสั่งขาย รพ.</span></p>
</center>

</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">ช่องทาง</td>
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 
<td width="8%" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="8%" align="center" class="style30">ยอดรวม</td> 
<td width="12%" align="center" class="style30">หมายเหตุ</td> 
<td width="12%" align="center" class="style30">ปรับโดย</td> 
<td width="5%" align="center" class="style30">สถานะ</td> 

</tr>

<?php
$strSQL = "SELECT ref_idd,date_edit,add_date,add_by,count,price,amount,sale_remark,product_id,delete_ckk,new_proadm FROM hos__subso_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_edit <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery)) {

$strSQL1 = "SELECT iv_no FROM hos__so WHERE ref_id = '".$objResult["ref_idd"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


	?>

<tr>
<td  class="style30"><?php echo $objResult["ref_idd"]; ?></td>
<td  class="style30"><?php echo $objResult["add_date"]; ?></td>
<td  class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult["ref_idd"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["iv_no"]; ?></span></a></td>

<td  class="style30"><?php echo $objResult2["sol_name"]; ?></td> 
<td  class="style30"><div align="right"><?php echo $objResult["count"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["price"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["amount"]; ?></div></td> 
<td  class="style30"><?php echo $objResult["sale_remark"]; ?></td> 
<td  class="style30"><?php echo $objResult["add_by"]; ?></td> 

<?php if($objResult["new_proadm"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#00FF00" >ADD</td> 
<?php }else if($objResult["delete_ckk"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#FF3030" >DELETE</td> 
	<?php } ?>
</tr>
<?php 
	}
?>

</table>

<?php } ?>


<?php if ($type_doc =='3'){ ?>
</p>
<center>
<span class="style15">ใบยืม รพ.</span></p>
</center>

</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">ช่องทาง</td>
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 
<td width="8%" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="8%" align="center" class="style30">ยอดรวม</td> 
<td width="12%" align="center" class="style30">หมายเหตุ</td> 
<td width="12%" align="center" class="style30">ปรับโดย</td> 
<td width="5%" align="center" class="style30">สถานะ</td> 

</tr>

<?php
$strSQL = "SELECT ref_idd_br,date_edit,add_date,add_by,count,price,amount,sale_remark,product_id,delete_ckk,new_proadm FROM hos__subbr_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_edit <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery)) {

$strSQL1 = "SELECT iv_no FROM hos__br WHERE ref_id_br = '".$objResult["ref_idd_br"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


	?>

<tr>
<td  class="style30"><?php echo $objResult["ref_idd_br"]; ?></td>
<td  class="style30"><?php echo $objResult["add_date"]; ?></td>
<td  class="style30"><?php echo $objResult1["iv_no"]; ?></td>

<td  class="style30"><?php echo $objResult2["sol_name"]; ?></td> 
<td  class="style30"><div align="right"><?php echo $objResult["count"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["price"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["amount"]; ?></div></td> 
<td  class="style30"><?php echo $objResult["sale_remark"]; ?></td> 
<td  class="style30"><?php echo $objResult["add_by"]; ?></td> 

<?php if($objResult["new_proadm"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#00FF00" >ADD</td> 
<?php }else if($objResult["delete_ckk"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#FF3030" >DELETE</td> 
	<?php } ?>
</tr>
<?php 
	}
?>

</table>

<?php } ?>

<?php if ($type_doc =='4'){ ?>
</p>
<center>
<span class="style15">ใบเบิกสินค้า SMP</span></p>
</center>

</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">ช่องทาง</td>
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 
<td width="8%" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="8%" align="center" class="style30">ยอดรวม</td> 
<td width="12%" align="center" class="style30">หมายเหตุ</td> 
<td width="12%" align="center" class="style30">ปรับโดย</td> 
<td width="5%" align="center" class="style30">สถานะ</td> 

</tr>

<?php
$strSQL = "SELECT reff_idsmp,date_edit,add_date,add_by,sale_count,unit_price,sum_amount,sale_remark,product_id,delete_ckk,new_proadm FROM hos__subsmp_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_edit <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery)) {

$strSQL1 = "SELECT smp_no FROM hos__smp WHERE ref_idsmp = '".$objResult["reff_idsmp"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


	?>

<tr>
<td  class="style30"><?php echo $objResult["reff_idsmp"]; ?></td>
<td  class="style30"><?php echo $objResult["add_date"]; ?></td>
<td  class="style30"><?php echo $objResult1["smp_no"]; ?></td>

<td  class="style30"><?php echo $objResult2["sol_name"]; ?></td> 
<td  class="style30"><div align="right"><?php echo $objResult["sale_count"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["unit_price"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["sum_amount"]; ?></div></td> 
<td  class="style30"><?php echo $objResult["sale_remark"]; ?></td> 
<td  class="style30"><?php echo $objResult["add_by"]; ?></td> 

<?php if($objResult["new_proadm"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#00FF00" >ADD</td> 
<?php }else if($objResult["delete_ckk"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#FF3030" >DELETE</td> 
	<?php } ?>
</tr>
<?php 
	}
?>

</table>

<?php } ?>

<?php if ($type_doc =='5'){ ?>
</p>
<center>
<span class="style15">ใบแลกเปลี่ยนสินค้า</span></p>
</center>

</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">ช่องทาง</td>
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="8%" align="center" class="style30">จำนวนจ่าย</td> 
<td width="8%" align="center" class="style30">จำนวนรับ</td> 
<td width="8%" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="8%" align="center" class="style30">ยอดรวม</td> 
<td width="12%" align="center" class="style30">หมายเหตุ</td> 
<td width="12%" align="center" class="style30">ปรับโดย</td> 
<td width="5%" align="center" class="style30">สถานะ</td> 

</tr>

<?php
$strSQL = "SELECT ref_idd,date_edit,add_date,add_by,count_sale,count_sale,price,amount,sale_remark,product_id,delete_ckk,new_proadm FROM hos__subchange_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_edit <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery)) {

$strSQL1 = "SELECT iv_no FROM hos__change WHERE ref_id = '".$objResult["ref_idd"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


	?>

<tr>
<td  class="style30"><?php echo $objResult["ref_idd"]; ?></td>
<td  class="style30"><?php echo $objResult["add_date"]; ?></td>
<td  class="style30"><?php echo $objResult1["iv_no"]; ?></td>

<td  class="style30"><?php echo $objResult2["sol_name"]; ?></td> 
<td  class="style30"><div align="right"><?php echo $objResult["count_sale"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["count_stock"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["price"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["amount"]; ?></div></td> 
<td  class="style30"><?php echo $objResult["sale_remark"]; ?></td> 
<td  class="style30"><?php echo $objResult["add_by"]; ?></td> 

<?php if($objResult["new_proadm"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#00FF00" >ADD</td> 
<?php }else if($objResult["delete_ckk"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#FF3030" >DELETE</td> 
	<?php } ?>
</tr>
<?php 
	}
?>

</table>

<?php } ?>


<?php if ($type_doc =='6'){ ?>
</p>
<center>
<span class="style15">ใบจองสินค้า</span></p>
</center>

</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">ช่องทาง</td>
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 
<td width="12%" align="center" class="style30">หมายเหตุ</td> 
<td width="12%" align="center" class="style30">ปรับโดย</td> 
<td width="5%" align="center" class="style30">สถานะ</td> 

</tr>

<?php
$strSQL = "SELECT ref_idd,date_edit,add_date,add_by,count,sale_remark,product_id,delete_ckk,new_proadm FROM hos__subjongpro_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_edit <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery)) {

$strSQL1 = "SELECT iv_no FROM hos__jongproduct WHERE ref_id = '".$objResult["ref_idd"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


	?>

<tr>
<td  class="style30"><?php echo $objResult["ref_idd"]; ?></td>
<td  class="style30"><?php echo $objResult["add_date"]; ?></td>
<td  class="style30"><?php echo $objResult1["iv_no"]; ?></td>

<td  class="style30"><?php echo $objResult2["sol_name"]; ?></td> 
<td  class="style30"><div align="right"><?php echo $objResult["count"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><?php echo $objResult["sale_remark"]; ?></td> 
<td  class="style30"><?php echo $objResult["add_by"]; ?></td> 

<?php if($objResult["new_proadm"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#00FF00" >ADD</td> 
<?php }else if($objResult["delete_ckk"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#FF3030" >DELETE</td> 
	<?php } ?>
</tr>
<?php 
	}
?>

</table>

<?php } ?>

<?php if ($type_doc =='7'){ ?>
</p>
<center>
<span class="style15">ใบเบิก SPR</span></p>
</center>

</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 
<td width="8%" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="8%" align="center" class="style30">ยอดรวม</td> 
<td width="12%" align="center" class="style30">หมายเหตุ</td> 
<td width="12%" align="center" class="style30">ปรับโดย</td> 
<td width="5%" align="center" class="style30">สถานะ</td> 

</tr>

<?php
$strSQL = "SELECT ref_idd,date_edit,add_date,add_by,sale_count,unit_price,sum_amount,sale_remark,product_id,delete_ckk,new_proadm FROM hos__subspr_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_edit <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery)) {

$strSQL1 = "SELECT spr_no FROM hos__spr WHERE ref_id = '".$objResult["ref_idd"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


	?>

<tr>
<td  class="style30"><?php echo $objResult["ref_idd"]; ?></td>
<td  class="style30"><?php echo $objResult["add_date"]; ?></td>
<td  class="style30"><?php echo $objResult1["spr_no"]; ?></td>

<td  class="style30"><?php echo $objResult2["sol_name"]; ?></td> 
<td  class="style30"><div align="right"><?php echo $objResult["sale_count"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["unit_price"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["sum_amount"]; ?></div></td> 
<td  class="style30"><?php echo $objResult["sale_remark"]; ?></td> 
<td  class="style30"><?php echo $objResult["add_by"]; ?></td> 

<?php if($objResult["new_proadm"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#00FF00" >ADD</td> 
<?php }else if($objResult["delete_ckk"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#FF3030" >DELETE</td> 
	<?php } ?>
</tr>
<?php 
	}
?>

</table>

<?php }else{ ?>


</p>
<center>
<span class="style15">ALL</span></p>
</center>

</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">ช่องทาง</td>
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 
<td width="8%" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="8%" align="center" class="style30">ยอดรวม</td> 
<td width="12%" align="center" class="style30">หมายเหตุ</td> 
<td width="12%" align="center" class="style30">ปรับโดย</td> 
<td width="5%" align="center" class="style30">สถานะ</td> 

</tr>

<?php
$strSQL = "SELECT ref_idd,date_edit,add_date,add_by,sale_count,price_per_unit,sum_amount,sale_remark,product_id,delete_ckk,new_proadm FROM so__submain_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_edit <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery)) {

$strSQL1 = "SELECT doc_no,select_type_doc FROM so__main WHERE ref_id = '".$objResult["ref_idd"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


	?>

<tr>
<td  class="style30"><?php echo $objResult["ref_idd"]; ?></td>
<td  class="style30"><?php echo $objResult["add_date"]; ?></td>
<td  class="style30"><a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_idd"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["doc_no"]; ?></span></a></td>
<td  class="style30">
	
<?php if($objResult1["select_type_doc"]=='1' or $objResult1["select_type_doc"]=='2'){
	
echo 'ใบยืม';

}else if($objResult1["select_type_doc"]=='3' or $objResult1["select_type_doc"]=='4'){
	
echo 'ใบสั่งขาย';

}?>

</td>
<td  class="style30"><?php echo $objResult2["sol_name"]; ?></td> 
<td  class="style30"><div align="right"><?php echo $objResult["sale_count"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["price_per_unit"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["sum_amount"]; ?></div></td> 
<td  class="style30"><?php echo $objResult["sale_remark"]; ?></td> 
<td  class="style30"><?php echo $objResult["add_by"]; ?></td> 

<?php if($objResult["new_proadm"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#00FF00" >ADD</td> 
<?php }else if($objResult["delete_ckk"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#FF3030" >DELETE</td> 
	<?php } ?>
</tr>
<?php 
	}
?>


<?php
$strSQL = "SELECT ref_idd,date_edit,add_date,add_by,count,price,amount,sale_remark,product_id,delete_ckk,new_proadm FROM hos__subso_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_edit <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery)) {

$strSQL1 = "SELECT iv_no FROM hos__so WHERE ref_id = '".$objResult["ref_idd"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


	?>

<tr>
<td  class="style30"><?php echo $objResult["ref_idd"]; ?></td>
<td  class="style30"><?php echo $objResult["add_date"]; ?></td>
<td  class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult["ref_idd"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["iv_no"]; ?></span></a></td>
<td  class="style30"></td> 
<td  class="style30"><?php echo $objResult2["sol_name"]; ?></td> 
<td  class="style30"><div align="right"><?php echo $objResult["count"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["price"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["amount"]; ?></div></td> 
<td  class="style30"><?php echo $objResult["sale_remark"]; ?></td> 
<td  class="style30"><?php echo $objResult["add_by"]; ?></td> 

<?php if($objResult["new_proadm"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#00FF00" >ADD</td> 
<?php }else if($objResult["delete_ckk"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#FF3030" >DELETE</td> 
	<?php } ?>
</tr>
<?php 
	}
?>

<?php
$strSQL = "SELECT ref_idd_br,date_edit,add_date,add_by,count,price,amount,sale_remark,product_id,delete_ckk,new_proadm FROM hos__subbr_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_edit <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery)) {

$strSQL1 = "SELECT iv_no FROM hos__br WHERE ref_id_br = '".$objResult["ref_idd_br"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


	?>

<tr>
<td  class="style30"><?php echo $objResult["ref_idd_br"]; ?></td>
<td  class="style30"><?php echo $objResult["add_date"]; ?></td>
<td  class="style30"><a href="register_adminbrhos_edit.php?ref_id_br=<?php echo $objResult["ref_idd_br"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["iv_no"]; ?></span></a></td>
<td  class="style30"></td> 

<td  class="style30"><?php echo $objResult2["sol_name"]; ?></td> 
<td  class="style30"><div align="right"><?php echo $objResult["count"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["price"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["amount"]; ?></div></td> 
<td  class="style30"><?php echo $objResult["sale_remark"]; ?></td> 
<td  class="style30"><?php echo $objResult["add_by"]; ?></td> 

<?php if($objResult["new_proadm"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#00FF00" >ADD</td> 
<?php }else if($objResult["delete_ckk"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#FF3030" >DELETE</td> 
	<?php } ?>
</tr>
<?php 
	}
?>



<?php
$strSQL = "SELECT reff_idsmp,date_edit,add_date,add_by,sale_count,unit_price,sum_amount,sale_remark,product_id,delete_ckk,new_proadm FROM hos__subsmp_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_edit <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery)) {

$strSQL1 = "SELECT smp_no FROM hos__smp WHERE ref_idsmp = '".$objResult["reff_idsmp"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


	?>

<tr>
<td  class="style30"><?php echo $objResult["reff_idsmp"]; ?></td>
<td  class="style30"><?php echo $objResult["add_date"]; ?></td>
<td  class="style30"><a href="register_adminsmp_edit.php?ref_idsmp=<?php echo $objResult["reff_idsmp"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["smp_no"]; ?></span></a></td>
<td  class="style30"></td> 
<td  class="style30"><?php echo $objResult2["sol_name"]; ?></td> 
<td  class="style30"><div align="right"><?php echo $objResult["sale_count"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["unit_price"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["sum_amount"]; ?></div></td> 
<td  class="style30"><?php echo $objResult["sale_remark"]; ?></td> 
<td  class="style30"><?php echo $objResult["add_by"]; ?></td> 

<?php if($objResult["new_proadm"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#00FF00" >ADD</td> 
<?php }else if($objResult["delete_ckk"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#FF3030" >DELETE</td> 
	<?php } ?>
</tr>
<?php 
	}
?>


<?php
$strSQL = "SELECT ref_idd,date_edit,add_date,add_by,count_sale,count_sale,price,amount,sale_remark,product_id,delete_ckk,new_proadm FROM hos__subchange_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_edit <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery)) {

$strSQL1 = "SELECT iv_no FROM hos__change WHERE ref_id = '".$objResult["ref_idd"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


	?>

<tr>
<td  class="style30"><?php echo $objResult["ref_idd"]; ?></td>
<td  class="style30"><?php echo $objResult["add_date"]; ?></td>
<td  class="style30"><a href="register_adminchange_edit.php?ref_id=<?php echo $objResult["ref_idd"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["iv_no"]; ?></span></a></td>
<td  class="style30"></td> 

<td  class="style30"><?php echo $objResult2["sol_name"]; ?></td> 
<td  class="style30"><div align="right"><?php echo $objResult["count_sale"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["count_stock"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["price"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["amount"]; ?></div></td> 
<td  class="style30"><?php echo $objResult["sale_remark"]; ?></td> 
<td  class="style30"><?php echo $objResult["add_by"]; ?></td> 

<?php if($objResult["new_proadm"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#00FF00" >ADD</td> 
<?php }else if($objResult["delete_ckk"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#FF3030" >DELETE</td> 
	<?php } ?>
</tr>
<?php 
	}
?>

<?php
$strSQL = "SELECT ref_idd,date_edit,add_date,add_by,count,sale_remark,product_id,delete_ckk,new_proadm FROM hos__subjongpro_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_edit <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery)) {

$strSQL1 = "SELECT iv_no FROM hos__jongproduct WHERE ref_id = '".$objResult["ref_idd"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


	?>

<tr>
<td  class="style30"><?php echo $objResult["ref_idd"]; ?></td>
<td  class="style30"><?php echo $objResult["add_date"]; ?></td>
<td  class="style30"><a href="register_salebook_edit.php?ref_id=<?php echo $objResult["ref_idd"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["iv_no"]; ?></span></a></td>
<td  class="style30"></td> 
<td  class="style30"><?php echo $objResult2["sol_name"]; ?></td> 
<td  class="style30"><div align="right"><?php echo $objResult["count"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"></td> 
<td  class="style30"></td> 
<td  class="style30"><?php echo $objResult["sale_remark"]; ?></td> 
<td  class="style30"><?php echo $objResult["add_by"]; ?></td> 

<?php if($objResult["new_proadm"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#00FF00" >ADD</td> 
<?php }else if($objResult["delete_ckk"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#FF3030" >DELETE</td> 
	<?php } ?>
</tr>
<?php 
	}
?>

<?php
$strSQL = "SELECT ref_idd,date_edit,add_date,add_by,sale_count,unit_price,sum_amount,sale_remark,product_id,delete_ckk,new_proadm FROM hos__subspr_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_edit <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery)) {

$strSQL1 = "SELECT spr_no FROM hos__spr WHERE ref_id = '".$objResult["ref_idd"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


	?>

<tr>
<td  class="style30"><?php echo $objResult["ref_idd"]; ?></td>
<td  class="style30"><?php echo $objResult["add_date"]; ?></td>
<td  class="style30"><a href="register_engspr_edit.php?ref_id=<?php echo $objResult["ref_idd"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["spr_no"]; ?></span></a></td>
<td  class="style30"></td> 
<td  class="style30"><?php echo $objResult2["sol_name"]; ?></td> 
<td  class="style30"><div align="right"><?php echo $objResult["sale_count"]; ?> <?php echo $objResult2["unit_name"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["unit_price"]; ?></div></td> 
<td  class="style30"><div align="right"><?php echo $objResult["sum_amount"]; ?></div></td> 
<td  class="style30"><?php echo $objResult["sale_remark"]; ?></td> 
<td  class="style30"><?php echo $objResult["add_by"]; ?></td> 

<?php if($objResult["new_proadm"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#00FF00" >ADD</td> 
<?php }else if($objResult["delete_ckk"]=='1'){ ?>

<td align="center" class="style30" bgcolor="#FF3030" >DELETE</td> 
	<?php } ?>
</tr>
<?php 
	}
?>


</table>




	<?php } ?>

</body>
</html>