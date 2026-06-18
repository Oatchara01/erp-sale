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


?>
<body>


<center>
<span class="style15">รายงานออร์เดอร์เคลียร์ยืม</span></p>
</center>


</p>



<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่เคลียร์</td>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="10%" align="center" class="style30">รหัสสินค้า</td>
<td width="25%" align="center" class="style30">รายการสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">หมายเลขเครื่อง</td> 
	<td width="5%" align="center" class="style30">เขตการขาย</td> 
	</tr>

<?php 
$strSQL = "SELECT ref_id,doc_release_date,customer_name,doc_no,employee_name   FROM so__main where allwell_ckk = '1' and close_br = '0' and allwell_br ='1'  and approve_complete = 'Approve' ";
	//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
while($objResult=mysqli_fetch_array($objQuery)){



$strSQL1 = "SELECT sale_count,access_name,product_code,sn_number,access_code FROM  (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


while($objResult1 = mysqli_fetch_array($objQuery1))
{


$sql3 = "SELECT sum(sale_count) as count3   FROM  (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where clear_brn_no = '".$objResult["doc_no"]."' and product_id = '".$objResult1['product_code']."'";
	
	
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());

$rs3 = mysqli_fetch_assoc($qry3);

$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd) where iv_no = '".$objResult["doc_no"]."' and product_id = '".$objResult1['product_code']."'";
		
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_assoc($qry4);


$count3 =  $rs3["count3"]; 
$count4 =  $rs4["count4"]; 


$count2 = $objResult1["sale_count"] - ($count3 + $count4);

	
	if($count2=='0'){

}else{

?>
	<tr>
<td width="10%" align="center" class="style30"><?php  echo Datethai($objResult['doc_release_date']); ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult['doc_no']; ?></td>
<td width="20%" align="reft" class="style30"><?php echo $objResult['customer_name']; ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult1['access_code']; ?></td>
<td width="25%" align="reft" class="style30"><?php  echo $objResult1['access_name'];  ?></td> 
<td width="10%" align="center" class="style30"><?php echo $count2; ?></td> 
<td width="10%" align="center" class="style30"><?php echo  $objResult1['sn_number']; ?></td> 
		<td width="5%" align="center" class="style30"><?php echo $objResult['employee_name']; ?></td>
	</tr>


	<?php }
}
}

?>



</table>
</p>

</body>
</html>