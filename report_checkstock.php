<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 18px; color: #FF0000;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style30 {font-size: 14px; color: #FF0000; }
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style39 {font-size: 14px; color: #000000;}
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



include"dbconnect.php";



$start_date = $_GET["start_date"];
$end_date   = $_GET["end_date"];



$date = explode('-' , $_GET["start_date"] );
$newDate = $date[2].'-'.$date[1].'-'.$date[0];


$date1 = explode('-' , $_GET["end_date"] );
$newDate1 = $date1[2].'-'.$date1[1].'-'.$date1[0];
?>
<body>



<center>
<span class="style15">รายงานสรุปการแก้ไขสินค้า</span></p>
<span class="style15"><?php echo Datethai($newDate); ?> - <?php echo Datethai($newDate1); ?></span></p>

</center>


	<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style39">วันที่</td>
<td width="10%" align="center" class="style39">ประเภทเอกสาร</td>
<td width="10%" align="center" class="style39">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style39">เลขที่อ้างอิง</td>
<td width="20%" align="center" class="style39">ชื่อสินค้า</td> 
<td width="8%" align="center" class="style39">จำนวนจ่าย</td> 
<td width="10%" align="center" class="style39">ราคาต่อหน่วย</td> 
<td width="10%" align="center" class="style39">พนักงาน</td>
<td width="20%" align="center" class="style39">หมายเหตุ </td>
<td width="20%" align="center" class="style39">หมายเหตุ Stock</td>
<td width="15%" align="center" class="style39">สถานะ</td>
	</tr>





	<?php

$strSQL2 = "SELECT distinct ref_idd,product_id FROM hos__subso_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_edit <= "'.$end_date.'"'; 
}



$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
while($objResult2 = mysqli_fetch_array($objQuery2))
{

 $ref_id = $objResult2["ref_idd"];
 $product_id = $objResult2["product_id"];

$strSQL1 = "SELECT iv_no,iv_date FROM hos__so WHERE ref_id = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$strSQL = "SELECT countref,price_ref,sale_remark,stock_remark FROM hos__subso WHERE ref_idd = '".$ref_id."' and  product_id = '".$product_id."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL3 = "SELECT access_name FROM tb_product WHERE  product_ID = '".$product_id."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);

if($objResult1["iv_no"] !='ยกเลิก'){
?>


<tr>
<td  align="center" class="style30"><?php echo datethai($objResult1["iv_date"]);  ?></td>
<td  align="center" class="style30">ใบสั่งขาย รพ</td>
<td  align="center" class="style30"><?php echo $objResult1["iv_no"];  ?></td>
<td  align="center" class="style30"><?php echo $ref_id;  ?></td>
<td  align="left" class="style30"><?php echo $objResult3["access_name"];  ?></td> 
<td  align="center" class="style30"><?php echo $objResult["countref"];  ?></td> 
<td  align="right" class="style30"><?php echo $objResult["price_ref"];  ?></td> 
<td  align="center" class="style30"></td>
<td  align="center" class="style30"><?php echo $objResult["sale_remark"];  ?></td>
<td  align="center" class="style30"><?php echo $objResult["stock_remark"];  ?></td>
<td  align="center" class="style30"></td>
	</tr>
	
	
<?php 

$strSQL4 = "SELECT count,price,sale_remark,stock_remark,date_edit,add_by,edit_product,new_proadm,stock_ckk FROM hos__subso_ref WHERE ref_idd = '".$ref_id."' and  product_id = '".$product_id."'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");

while($objResult4 = mysqli_fetch_array($objQuery4))
{

$strSQL5 = "SELECT access_name FROM tb_product WHERE  product_ID = '".$product_id."'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);
?>


<tr>
<td  align="center" class="style39"><?php echo datethai($objResult4["date_edit"]);  ?></td>
<td  align="center" class="style39">ใบสั่งขาย รพ.</td>
<td  align="center" class="style39"><?php echo $objResult1["iv_no"];  ?></td>
<td  align="center" class="style39"><?php echo $ref_id;  ?></td>
<td  align="left" class="style39"><?php echo $objResult5["access_name"];  ?></td> 
<td  align="center" class="style39"><?php echo $objResult4["count"];  ?></td> 
<td  align="right" class="style39"><?php echo $objResult4["price"];  ?></td> 
<td  align="center" class="style39"><?php echo $objResult4["add_by"];  ?></td>
<td  align="center" class="style39"><?php echo $objResult4["sale_remark"];  ?></td>
<td  align="center" class="style39"><?php echo $objResult4["stock_remark"];  ?></td>
<td  align="center" class="style39"><?php if($objResult4["edit_product"]=='1'){ echo "แก้ไข By Admin"; }   if($objResult4["new_proadm"]=='1'){ echo "เพิ่มใหม่ By Admin"; } if($objResult4["stock_ckk"]=='1'){ echo "เพิ่มใหม่ By Stock"; } ?></td>
	</tr>




	<?php
}
	
}
} 


?>

	<?php

$strSQL2 = "SELECT distinct ref_idd_br,product_id FROM hos__subbr_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_edit <= "'.$end_date.'"'; 
}



$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
while($objResult2 = mysqli_fetch_array($objQuery2))
{

 $ref_id = $objResult2["ref_idd_br"];
 $product_id = $objResult2["product_id"];

$strSQL1 = "SELECT iv_no,iv_date FROM hos__br WHERE ref_id_br = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$strSQL = "SELECT countref,sale_remark,stock_remark FROM hos__subbr WHERE ref_idd_br = '".$ref_id."' and  product_id = '".$product_id."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL3 = "SELECT access_name FROM tb_product WHERE  product_ID = '".$product_id."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);

if($objResult1["iv_no"] !='ยกเลิก'){
?>


<tr>
<td  align="center" class="style30"><?php echo datethai($objResult1["iv_date"]);  ?></td>
<td  align="center" class="style30">ใบยืม รพ</td>
<td  align="center" class="style30"><?php echo $objResult1["iv_no"];  ?></td>
<td  align="center" class="style30"><?php echo $ref_id;  ?></td>
<td  align="left" class="style30"><?php echo $objResult3["access_name"];  ?></td> 
<td  align="center" class="style30"><?php echo $objResult["countref"];  ?></td> 
<td  align="right" class="style30"></td> 
<td  align="center" class="style30"></td>
<td  align="center" class="style30"><?php echo $objResult["sale_remark"];  ?></td>
<td  align="center" class="style30"><?php echo $objResult["stock_remark"];  ?></td>
<td  align="center" class="style30"></td>
	</tr>
	
	
<?php 

$strSQL4 = "SELECT count,price,sale_remark,stock_remark,date_edit,add_by,edit_product,new_proadm,stock_ckk FROM hos__subbr_ref WHERE ref_idd_br = '".$ref_id."' and  product_id = '".$product_id."'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");

while($objResult4 = mysqli_fetch_array($objQuery4))
{

$strSQL5 = "SELECT access_name FROM tb_product WHERE  product_ID = '".$product_id."'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);
?>


<tr>
<td  align="center" class="style39"><?php echo datethai($objResult4["date_edit"]);  ?></td>
<td  align="center" class="style39">ใบยืม รพ.</td>
<td  align="center" class="style39"><?php echo $objResult1["iv_no"];  ?></td>
<td  align="center" class="style39"><?php echo $ref_id;  ?></td>
<td  align="left" class="style39"><?php echo $objResult5["access_name"];  ?></td> 
<td  align="center" class="style39"><?php echo $objResult4["count"];  ?></td> 
<td  align="right" class="style39"><?php echo $objResult4["price"];  ?></td> 
<td  align="center" class="style39"><?php echo $objResult4["add_by"];  ?></td>
<td  align="center" class="style39"><?php echo $objResult4["sale_remark"];  ?></td>
<td  align="center" class="style39"><?php echo $objResult4["stock_remark"];  ?></td>
<td  align="center" class="style39"><?php if($objResult4["edit_product"]=='1'){ echo "แก้ไข By Admin"; }   if($objResult4["new_proadm"]=='1'){ echo "เพิ่มใหม่ By Admin"; } if($objResult4["stock_ckk"]=='1'){ echo "เพิ่มใหม่ By Stock"; } ?></td>
	</tr>




	<?php
}
	
}
} 


?>


<?php

$strSQL2 = "SELECT distinct ref_idd,product_id FROM so__submain_ref WHERE 1 ";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_edit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_edit <= "'.$end_date.'"'; 
}



$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
while($objResult2 = mysqli_fetch_array($objQuery2))
{

 $ref_id = $objResult2["ref_idd"];
 $product_id = $objResult2["product_id"];

$strSQL1 = "SELECT doc_no,doc_release_date,select_type_doc FROM so__main WHERE ref_id = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$strSQL = "SELECT sale_countref,price_per_unitref,sale_remark,stock_remark FROM so__submain WHERE ref_idd = '".$ref_id."' and  product_id = '".$product_id."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL3 = "SELECT access_name FROM tb_product WHERE  product_ID = '".$product_id."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);

if($objResult1["doc_no"] !='ยกเลิก'){
?>


<tr>
<td  align="center" class="style30"><?php echo datethai($objResult1["doc_release_date"]);  ?></td>
<td  align="center" class="style30"><?php if($objResult1["select_type_doc"]=='1' or $objResult1["select_type_doc"]=='2'){ echo "ใบยืม Online"; } if($objResult1["select_type_doc"]=='3' or $objResult1["select_type_doc"]=='4'){ echo "ใบสั่งขาย Online"; } ?></td>
<td  align="center" class="style30"><?php echo $objResult1["doc_no"];  ?></td>
<td  align="center" class="style30"><?php echo $ref_id;  ?></td>
<td  align="left" class="style30"><?php echo $objResult3["access_name"];  ?></td> 
<td  align="center" class="style30"><?php echo $objResult["sale_countref"];  ?></td> 
<td  align="right" class="style30"><?php echo $objResult["price_per_unitref"];  ?></td> 
<td  align="center" class="style30"></td>
<td  align="center" class="style30"><?php echo $objResult["sale_remark"];  ?></td>
<td  align="center" class="style30"><?php echo $objResult["stock_remark"];  ?></td>
<td  align="center" class="style30"></td>
	</tr>
	
	
<?php 

$strSQL4 = "SELECT sale_count,price_per_unit,sale_remark,stock_remark,date_edit,add_by,edit_product,new_proadm,stock_ckk FROM so__submain_ref WHERE ref_idd = '".$ref_id."' and  product_id = '".$product_id."'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");

while($objResult4 = mysqli_fetch_array($objQuery4))
{

$strSQL5 = "SELECT access_name FROM tb_product WHERE  product_ID = '".$product_id."'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);
?>


<tr>
<td  align="center" class="style39"><?php echo datethai($objResult4["date_edit"]);  ?></td>
<td  align="center" class="style39"><?php if($objResult1["select_type_doc"]=='1' or $objResult1["select_type_doc"]=='2'){ echo "ใบยืม Online"; } if($objResult1["select_type_doc"]=='3' or $objResult1["select_type_doc"]=='4'){ echo "ใบสั่งขาย Online"; } ?></td>
<td  align="center" class="style39"><?php echo $objResult1["doc_no"];  ?></td>
<td  align="center" class="style39"><?php echo $ref_id;  ?></td>
<td  align="left" class="style39"><?php echo $objResult5["access_name"];  ?></td> 
<td  align="center" class="style39"><?php echo $objResult4["sale_count"];  ?></td> 
<td  align="right" class="style39"><?php echo $objResult4["price_per_unit"];  ?></td> 
<td  align="center" class="style39"><?php echo $objResult4["add_by"];  ?></td>
<td  align="center" class="style39"><?php echo $objResult4["sale_remark"];  ?></td>
<td  align="center" class="style39"><?php echo $objResult4["stock_remark"];  ?></td>
<td  align="center" class="style39"><?php if($objResult4["edit_product"]=='1'){ echo "แก้ไข By Admin"; }   if($objResult4["new_proadm"]=='1'){ echo "เพิ่มใหม่ By Admin"; } if($objResult4["stock_ckk"]=='1'){ echo "เพิ่มใหม่ By Stock"; } ?></td>
	</tr>




	<?php
}
	
}
} 


?>




</table>

</p></p></p></p>
</body>
</html>