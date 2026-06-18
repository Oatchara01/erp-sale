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

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];

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
$strSQL = "SELECT ref_id_br,date_br,customer,iv_no,sale_code   FROM hos__br where close_br = '0' and status_doc = 'Approve'";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
while($objResult=mysqli_fetch_array($objQuery)){



$strSQL1 = "SELECT count,sol_name,product_code,sn,access_code FROM  (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$objResult["ref_id_br"]."' ";
//echo $strSQL1;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


while($objResult1 = mysqli_fetch_array($objQuery1))
{


if($objResult1["sn"] !=''){


$sn_number =  $objResult1["sn"];
$str_arr = explode("\n",$sn_number);
foreach ($str_arr as $test =>$value){
$product_sn = $str_arr[$test];
$product_sn1 =  trim($product_sn);

$strSQL2 = "SELECT sn FROM  (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE brnp_no = '".$objResult["iv_no"]."' and product_id = '".$objResult1['product_code']."' and sn = '".$product_sn1."' ";

$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

$strSQL3 = "SELECT sn FROM  (hos__receive LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd) WHERE iv_no = '".$objResult["iv_no"]."' and product_id = '".$objResult1['product_code']."' and sn = '".$product_sn1."' ";

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);



if($Num_Rows2 > 0){

}else if ($Num_Rows3 > 0){

}else{

if($product_sn1 !=''){
?>

<tr>
<td width="10%" align="center" class="style30"><?php  echo Datethai($objResult['date_br']); ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult['iv_no']; ?></td>
<td width="20%" align="reft" class="style30"><?php echo $objResult['customer']; ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult1['access_code']; ?></td>
<td width="25%" align="reft" class="style30"><?php  echo $objResult1['sol_name'];  ?></td> 
<td width="10%" align="center" class="style30"><?php echo '1'; ?></td> 
<td width="10%" align="center" class="style30"><?php echo  $product_sn1;; ?></td> 
<td width="5%" align="center" class="style30"><?php echo $objResult['sale_code']; ?></td>
	</tr>

<?php
}
}
}
}

else if($objResult1["sn"]==''){

	$sql3 = "SELECT sum(count) as count3   FROM  (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) where brnp_no = '".$objResult["iv_no"]."' and product_id = '".$objResult1['product_code']."'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());

while($rs3 = mysqli_fetch_assoc($qry3)){

$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd) where iv_no = '".$objResult["iv_no"]."' and product_id = '".$objResult1['product_code']."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());

while($rs4 = mysqli_fetch_assoc($qry4)){


$count3 =  $rs3["count3"]; 
$count4 =  $rs4["count4"]; 


$count2 = $objResult1["count"] - ($count3 + $count4);

}
}

	
	if($count2=='0'){

}else{

?>
	<tr>
<td width="10%" align="center" class="style30"><?php  echo Datethai($objResult['date_br']); ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult['iv_no']; ?></td>
<td width="20%" align="reft" class="style30"><?php echo $objResult['customer']; ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult1['access_code']; ?></td>
<td width="25%" align="reft" class="style30"><?php  echo $objResult1['sol_name'];  ?></td> 
<td width="10%" align="center" class="style30"><?php echo $objResult1['count']; ?></td> 
<td width="10%" align="center" class="style30"><?php echo  $objResult1['sn']; ?></td> 
		<td width="5%" align="center" class="style30"><?php echo $objResult['sale_code']; ?></td>
	</tr>


	<?php }
}
}
}
?>



</table>
</p>

</body>
</html>