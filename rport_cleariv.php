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


include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorHTML.php";
include "src/BarcodeGeneratorPNG.php";




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
$sale_channel = $_GET["sale_channel"];
$iv_no = $_GET["iv_no"];
$sol = "SOL";

include"dbconnect.php";
include"dbconnect_acc.php";


?>
<body>


<center>
<span class="style15">รายงานออร์เดอร์เคลียร์ยืม</span></p>

</center>
</p>



<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">หมายเลขคำสั่งซื้อ</td>
<td width="8%" align="center" class="style30">วันที่</td>
<td width="8%" align="center" class="style30">วันที่สั่งซื้อ</td>
<td width="15%" align="center" class="style30">ชื่อลุกค้า</td> 
<td width="5%" align="center" class="style30">ID สินค้า</td> 
<td width="8%" align="center" class="style30">รหัสสินค้า</td> 
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 
<td width="8%" align="center" class="style30">ราคา</td> 
<td width="8%" align="center" class="style30">เลขที่อ้างอิง</td> 
<td width="8%" align="center" class="style30">บริษัท</td> 	
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td> 
<td width="10%" align="center" class="style30">IV เคลียร์ยืม</td> 
<td width="10%" align="center" class="style30">IV เคลียร์ยืมตามสินค้า</td> 
	</tr>


<?php 
$strSQL ="SELECT  doc_no,iv_date,customer_name,delivery_name,order_id,register_time,ref_id,iv_no,select_type_doc,create_order FROM so__main WHERE iv_no ='".$iv_no."' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $strSQL .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

$strSQL .=" order  by doc_release_date ASC ";
//echo $strSQL;

$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){
	
	
	
	
$strSQL5 = "SELECT *  FROM so__main  WHERE ref_id = '".$objResult["ref_id"]."'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die(mysqli_error());
while($objResuut5 = mysqli_fetch_array($objQuery5)){
	
if ($objResuut5["select_type_doc"]=='3'){
$com ="ออลล์เวล ไลฟ์ บจก.";
}else if ($objResuut5["select_type_doc"]=='4'){
$com="โนเบิล เมด บจก.";	
}	
	
$delivery_date = $objResuut5["doc_release_date"];	
	
$iv_no = $objResult["iv_no"];
$billing_name = $objResuut5["billing_name"];
$ref_id = $objResuut5["ref_id"];	
$bill_id = $objResuut5["bill_id"];	
$sale_channel = $objResuut5["sale_channel"];
$doc_no	= $objResuut5["doc_no"];
$order_id	= $objResuut5["order_id"];	
	
$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$objResuut5["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);	
	
$amount_1 = $objResult15["amount_1"];	

$strSQL2 = "SELECT ref_id,id_off  FROM tb_register_data  WHERE ref_id = '".$objResuut5["ref_id"]."' ";
$objQuery2 = mysqli_query($code,$strSQL2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($objQuery2);
$objResult2= mysqli_fetch_array($objQuery2);		

if($Num_Rows2 > 0){ 
	
$strSQL29="UPDATE   tb_register_data SET  clear_iv='".$iv_no."',order_id='".$order_id."',sale_channel='".$sale_channel."'  WHERE id_off = '".$objResult2["id_off"]."'";
$objQuery29 = mysqli_query($code,$strSQL29);	

}else{
	
if($objResuut5["select_type_doc"]=='3' or $objResuut5["select_type_doc"]=='4'){	

$strSQL29="insert into   tb_register_data (IV_number,date_inv,company,customer_name,unit_cash,cash,employee_name,ref_id,credit,description,bill_id,sale_channel,summary,summary_work,summary_ckk,clear_iv,order_id) 
values ('".$doc_no."','".$delivery_date."','".$com."','".$billing_name."','".$amount_1."','36','".$add_by."','".$ref_id."','1','LAZADA','".$bill_id."','".$sale_channel."','สมบูรณ์','สมบูรณ์','1','".$iv_no."','".$order_id."')";
	
$objQuery29 = mysqli_query($code,$strSQL29);	
	
	 
 }
	 
}
}
	



$strSQL1 = "SELECT sol_name,access_code,sale_count,sum_amount,product_code,clear_ivno FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{

?>

<tr>
<td  align="center" class="style30">'<?php echo $objResult["order_id"]; ?></td>
<td  align="reft" class="style30"><?php echo datethai($objResult["iv_date"]); ?></td>
<td  align="reft" class="style30"><?php echo datethai($objResult["create_order"]); ?></td>
<td align="reft" class="style30"><?php if ($objResult["customer_name"]!=''){ echo $objResult["customer_name"];  }else{    echo $objResult["delivery_name"];  } ?></td> 
<td  align="reft" class="style30"><?php echo $objResult1["product_code"]; ?></td> 
<td  align="reft" class="style30"><?php echo $objResult1["access_code"]; ?></td> 
<td  align="reft" class="style30"><?php echo $objResult1["sol_name"]; ?></td> 
<td  align="right" class="style30"><?php echo $objResult1["sale_count"]; ?></td> 
<td  align="right" class="style30"><?php $price=$objResult1["sum_amount"]; echo number_format( $price,2).""; ?></td> 
<td  align="center" class="style30"><?php echo $objResult["ref_id"]; ?></td> 
	<td  align="center" class="style30"><?php if($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='3'){ echo "AWL";  }elseif($objResult["select_type_doc"]=='2' or $objResult["select_type_doc"]=='4'){ echo "NBM";  }  ?></td> 
	
<td  align="center" class="style30"><?php echo $objResult["doc_no"]; ?></td> 
<td  align="center" class="style30"><?php echo $objResult["iv_no"]; ?></td> 
<td  align="reft" class="style30"><?php echo $objResult1["clear_ivno"]; ?></td> 
	</tr>





<?php
}
}

$strSQL9 = "SELECT SUM(sale_count)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  WHERE  iv_no ='".$iv_no."' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL9 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL9 .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $strSQL9 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");

$objResult9 = mysqli_fetch_array($objQuery9);

$total1 =$objResult9["total1"];

//echo $total1;


$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE   iv_no ='".$iv_no."' and cancel_ckk ='0'";


if($start_date !=""){ 
    $strSQL8 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL8 .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $strSQL8 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");

$objResult8 = mysqli_fetch_array($objQuery8);

$total =$objResult8["total"];
//echo $total;


?>

<tr>
<td  align="center" class="style30"></td>
<td  align="reft" class="style30"></td>
<td  align="reft" class="style30"></td> 
<td  align="reft" class="style30"></td> 
<td  align="reft" class="style30"></td> 
<td  align="reft" class="style30"></td> 
<td  align="right" class="style30"><?php echo $total1; ?></td> 
<td  align="right" class="style30"><?php  echo number_format( $total,2).""; ?></td> 
<td  align="center" class="style30"></td> 
<td  align="center" class="style30"></td> 
<td  align="center" class="style30"></td> 
<td  align="center" class="style30"></td> 
	</tr>


</table>
</body>
</html>