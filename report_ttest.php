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
.style30 {font-size: 12px; color: #000000;}
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

/*$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$company = $_GET["company"]; */

include"dbconnect.php";
//include"dbconnect_sale.php";




?>
<body>



<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">หมายเลขคำสั่งซื้อ</td>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="10%" align="center" class="style30">วันที่สั่งซื้อ</td>
<td width="10%" align="center" class="style30">ID ลูกค้า</td> 	
<td width="10%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">ID สินค้า</td> 
<td width="10%" align="center" class="style30">รหัสสินค้า</td> 	
<td width="10%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ราคา</td> 
<td width="10%" align="center" class="style30">เลขที่อ้างอิง</td> 
<td width="10%" align="center" class="style30">บริษัท</td> 
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td> 
<td width="10%" align="center" class="style30">IV เคลียร์ยืม</td> 
<td width="10%" align="center" class="style30">วันที่ IV</td> 
<td width="10%" align="center" class="style30">เขตการขาย</td> 

</tr>

<?php
/*$strSQL1 = "SELECT * FROM hos__receive  WHERE ref_idsale ='0' AND sale_code LIKE '%SOL%' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1)) {

	
$strSQL = "SELECT ref_id,order_refer_code,sale_channel,order_id FROM so__main WHERE doc_no  = '".$objResult1["iv_no"]."'";
$objQuery= mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL2 = "Update  hos__receive set  sale_chan = '".$objResult["sale_channel"]."',ref_idsale = '".$objResult["ref_id"]."',track_no='".$objResult["order_refer_code"]."' where ref_id = '".$objResult1["ref_id"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2);	
	
?>	
<tr>
<td width="10%" align="center" class="style30"><?php echo $objResult1["order_id"]; ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult["order_id"]; ?></td>	
	
<td width="10%" align="center" class="style30"><?php echo $objResult["ref_id"]; ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult["order_refer_code"]; ?></td>	
<td width="10%" align="center" class="style30"><?php echo $objResult["sale_channel"]; ?></td>	
</tr>	
<?php	
}*/
	
/*$strSQL1 = "SELECT * FROM hos__subsmp  WHERE sum_amount = '0.00' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1)) {	
	
$strSQL = "SELECT sol_price FROM tb_product WHERE product_ID = '".$objResult1["product_id"]."'";
$objQuery= mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
$unit_price = $objResult["sol_price"];
$sale_count = $objResult1["sale_count"];
$sum_amount = 	$unit_price*$sale_count;
	
$strSQL2 = "Update  hos__subsmp set  unit_price = '".$unit_price."',sum_amount = '".$sum_amount."' where subsmp_id = '".$objResult1["subsmp_id"]."'";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
	
}*/

//$product_id ='1844';

$strSQL = "SELECT ref_id,order_id,doc_release_date,create_order,billing_name,select_type_doc,doc_no,iv_no,iv_date,employee_name,bill_id  FROM so__main  where approve_complete='Approve' and cancel_ckk='0'  and iv_no ='IV69050273'";
	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$strSQL2 = "SELECT product_id,sale_count,sum_amount FROM so__submain  where ref_idd='".$objResult["ref_id"]."' ";
	
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

$i = 1;
while($objResult2 = mysqli_fetch_array($objQuery2))
{
	
$strSQL1 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE product_ID = '".$objResult2["product_id"]."'";
$objQuery1= mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);
	
	
?>
	
<tr>
<td width="10%" align="center" class="style30">'<?php echo $objResult["order_id"]; ?></td>
<td width="10%" align="center" class="style30"><?php echo Datethai($objResult["doc_release_date"]); ?></td>
<td width="10%" align="center" class="style30"><?php echo Datethai($objResult["create_order"]); ?></td>	
<td width="10%" align="center" class="style30"><?php echo $objResult["bill_id"]; ?></td>	
<td width="10%" align="center" class="style30"><?php echo $objResult["billing_name"]; ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult2["product_id"]; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $objResult1["access_code"]; ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult1["sol_name"]; ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult2["sale_count"]; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $objResult2["sum_amount"]; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $objResult["ref_id"]; ?></td> 
<td width="10%" align="center" class="style30"><?php if($objResult["select_type_doc"]=='3' or $objResult["select_type_doc"]=='1'){ echo "AWL"; }else{  echo "NBM";  } ?></td> 
<td width="10%" align="center" class="style30"><?php echo $objResult["doc_no"]; ?></td> 
<td width="10%" align="center" class="style30"><?php echo $objResult["iv_no"]; ?></td> 
<td width="10%" align="center" class="style30"><?php echo Datethai($objResult["iv_date"]); ?></td>	
<td width="10%" align="center" class="style30"><?php echo $objResult["employee_name"]; ?></td>	
</tr>	
	

<?php 

}
}
	?>
		
	
</table>

</body>
</html>