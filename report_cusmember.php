<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 16px; color: #000000;}
.style17 {font-size: 14px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style30 {font-size: 14px; color: #000000;}
.style40 {font-size: 15px; color: #FF0000; }
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

$h_start_codecus = $_GET["h_start_codecus"];
$h_start_codepro = $_GET["h_start_codepro"];
$customer_no = $_GET["customer_no"];
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
//echo $customer_no;
include"dbconnect.php";

?>
<body>


<center>
<span class="style15"><b>ข้อมูลการขายของสมาชิก Allwell</b></span></p>
	<?php if($start_date !='' and $end_date !=''){ ?>
<span class="style15"><b><?php echo Datethai($start_date); ?> ถึง <?php echo Datethai($end_date); ?></b></span></p>
<?php } ?>
</center>
</p>


<?php
if ($h_start_codepro =='' and $h_start_codecus =='' and $customer_no ==''){
	?>


	<?php
$strSQL11 ="SELECT DISTINCT(bill_id) AS bill_id FROM so__main WHERE  cancel_ckk='0' and approve_complete = 'Approve' and customer_no !=''";
if($start_date !=""){ 
    $strSQL11 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}	
$strSQL11 .= ' ORDER BY doc_release_date ASC '; 
$objQuery11 =mysqli_query($conn,$strSQL11);
while($objResult11=mysqli_fetch_array($objQuery11)){	
	
$strSQL ="SELECT  status_cus,customer_no,first_name,last_name,preface_name,customer_id FROM tb_customer WHERE customer_id ='".$objResult11["bill_id"]."' ";
$objQuery =mysqli_query($conn,$strSQL);
$Num_Rows = mysqli_num_rows($objQuery);
$objResult=mysqli_fetch_array($objQuery);


?>
<br><br>
<span class="style16"><b><?php echo $objResult["preface_name"]; ?>&nbsp;&nbsp;<?php echo $objResult["first_name"]; ?>  &nbsp;&nbsp;<?php echo $objResult["last_name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo 'รหัสสมาชิก'; ?>&nbsp;&nbsp; <?php echo $objResult["customer_no"]; ?> </b></span><br>

<?php
			
$strSQL1 ="SELECT  doc_no,doc_release_date,ref_id FROM so__main WHERE bill_id='".$objResult["customer_id"]."' and cancel_ckk='0' and approve_complete = 'Approve'";
if($start_date !=""){ 
    $strSQL1 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}	
//echo $strSQL1;
$objQuery1 =mysqli_query($conn,$strSQL1);

?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="15%" align="center" class="style30">วันที่ออกบิล</td>
<td width="15%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="25%" align="center" class="style30">รายการสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ราคารวม</td> 
<td width="10%" align="center" class="style30">ยอดรวม</td> 
<td width="10%" align="center" class="style30">สถานะลูกค้า</td> 


	</tr>


<?php
while($objResult1=mysqli_fetch_array($objQuery1)){
	
$save=" Update  so__submain set doc_date='".$objResult1["doc_release_date"]."',cus_no='".$objResult["customer_no"]."'  where  ref_idd ='".$objResult1["ref_id"]."'";
$qsave=mysqli_query($conn,$save);		

?>

<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult1["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["doc_no"]; ?></td>

<td class="style30"><div align="left">
<?php
$strSQL12 = "SELECT product_id FROM so__submain  WHERE ref_idd = '".$objResult1["ref_id"]."' ";
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
while($objResult12 = mysqli_fetch_array($objQuery12))
{
	
$strSQL2 = "SELECT sol_name FROM  tb_product  WHERE product_ID = '".$objResult12["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
	
?>
<?php
	echo $objResult2["sol_name"]; 
	?><br />
<?php
}
?>
</div>
</td>


<td class="style30"><div align="right">
<?php
$strSQL4 = "SELECT sale_count,product_id FROM so__submain  WHERE ref_idd = '".$objResult1["ref_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
while($objResult4 = mysqli_fetch_array($objQuery4))
{
	
$strSQL14 = "SELECT sol_name FROM  tb_product  WHERE product_ID = '".$objResult4["product_id"]."' ";
$objQuery14 = mysqli_query($conn,$strSQL14) or die ("Error Query [".$strSQL14."]");
$objResult14 = mysqli_fetch_array($objQuery14);	
?>
<?php
	echo $objResult4["sale_count"];   echo $objResult14["unit_name"];
	?><br />
<?php
}
?>
</div>
</td>


<td class="style30"><div align="right">
<?php
$strSQL3 = "SELECT sum_amount FROM so__submain WHERE ref_idd = '".$objResult1["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
while($objResult3 = mysqli_fetch_array($objQuery3))
{
?>
<?php
	echo number_format($objResult3["sum_amount"],2).""; 
	?><br />
<?php
}
?>
</div>
</td>

<td  align="right" class="style30">
<?php
$strSQL5 = "SELECT SUM(sum_amount) AS sum_amount FROM so__submain  WHERE ref_idd = '".$objResult1["ref_id"]."' ";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);
echo number_format($objResult5["sum_amount"],2).""; 

?>


</td> 
<td  align="right" class="style30">
<?php if($objResult["status_cus"]=='0'){echo "Gold Customer"; }else if($objResult["status_cus"]=='1'){ echo "Platinum Customer";  }else if($objResult["status_cus"]=='2'){ echo "Daimond Customer";  } ?>


</td> 

	</tr>




<?php } ?>
</table>
<?php
	
$strSQL15 = "SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE cus_no='".$objResult["customer_no"]."'";
if($start_date !=""){ 
    $strSQL15 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND doc_date <= "'.$end_date.'"'; 
}	
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);
	
	?>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="100%" align="center" class="style40"><?php echo $objResult["preface_name"]; ?>&nbsp;&nbsp;<?php echo $objResult["first_name"]; ?>  &nbsp;&nbsp;<?php echo $objResult["last_name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo 'รหัสสมาชิก'; ?>&nbsp;&nbsp; <?php echo $objResult["customer_no"]; ?> &nbsp;&nbsp; <?php echo 'ยอดรวม'; ?> &nbsp;&nbsp; <?php echo number_format($objResult15["sum_amount"],2)."";  ?>&nbsp;&nbsp;<?php echo 'บาท'; ?></td>

	</tr>
	</table>

<?php
}
	?>

</p>

<?php
	
$strSQL15 = "SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE cus_no !=''";
if($start_date !=""){ 
    $strSQL15 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND doc_date <= "'.$end_date.'"'; 
}	
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);
	
	?>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="100%" align="center" class="style40"><?php echo 'ยอดรวมทั้งหมด'; ?>&nbsp;&nbsp;  <?php echo number_format($objResult15["sum_amount"],2)."";  ?>&nbsp;&nbsp;<?php echo 'บาท'; ?></td>

	</tr>
	</table>


<?php

}else if ($customer_no !='' or $h_start_codecus!=''){

$strSQL ="SELECT  status_cus,customer_no,first_name,last_name,preface_name,customer_id FROM tb_customer WHERE 1 ";

if($customer_no !=""){ 
    $strSQL .= ' AND customer_no = "'.$customer_no.'"'; 
}

if($h_start_codecus !=""){ 
    $strSQL .= ' AND customer_id = "'.$h_start_codecus.'"'; 
}
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$objResult=mysqli_fetch_array($objQuery);

if($customer_no !='' or $h_start_codecus !='')	{
?>

<span class="style16"><b><?php echo $objResult["preface_name"]; ?>&nbsp;&nbsp;<?php echo $objResult["first_name"]; ?>  &nbsp;&nbsp;<?php echo $objResult["last_name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo 'รหัสสมาชิก'; ?>&nbsp;&nbsp; <?php echo $objResult["customer_no"]; ?> </b></span><br>


<?php
 }
$strSQL1 ="SELECT  doc_no,doc_release_date,ref_id FROM so__main WHERE  cancel_ckk='0' and approve_complete = 'Approve'";
if($start_date !=""){ 
    $strSQL1 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}	

if($h_start_codecus !=""){ 
    $strSQL1 .= ' AND bill_id = "'.$h_start_codecus.'"'; 
}else{	
$strSQL1 .= ' AND bill_id = "'.$objResult["customer_id"].'"'; 	
}
$objQuery1 =mysqli_query($conn,$strSQL1);

?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="15%" align="center" class="style30">วันที่ออกบิล</td>
<td width="15%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="25%" align="center" class="style30">รายการสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ราคารวม</td> 
<td width="10%" align="center" class="style30">ยอดรวม</td> 
<td width="10%" align="center" class="style30">สถานะลูกค้า</td> 


	</tr>


<?php
while($objResult1=mysqli_fetch_array($objQuery1)){
if($objResult["customer_id"]!=''){
?>

<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult1["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["doc_no"]; ?></td>

<td class="style30"><div align="left">
<?php
$strSQL2 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult1["ref_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
while($objResult2 = mysqli_fetch_array($objQuery2))
{
?>
<?php
	echo $objResult2["sol_name"]; 
	?><br />
<?php
}
?>
</div>
</td>


<td class="style30"><div align="right">
<?php
$strSQL4 = "SELECT sale_count,unit_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult1["ref_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
while($objResult4 = mysqli_fetch_array($objQuery4))
{
?>
<?php
	echo $objResult4["sale_count"];   echo $objResult4["unit_name"];
	?><br />
<?php
}
?>
</div>
</td>


<td class="style30"><div align="right">
<?php
$strSQL3 = "SELECT sum_amount FROM so__submain WHERE ref_idd = '".$objResult1["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
while($objResult3 = mysqli_fetch_array($objQuery3))
{
?>
<?php
	echo number_format($objResult3["sum_amount"],2).""; 
	?><br />
<?php
}
?>
</div>
</td>

<td  align="right" class="style30">
<?php
$strSQL5 = "SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE ref_idd = '".$objResult1["ref_id"]."' ";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);
echo number_format($objResult5["sum_amount"],2).""; 

?>


</td> 
<td  align="right" class="style30">
<?php if($objResult["status_cus"]=='0'){echo "Gold Customer"; }else if($objResult["status_cus"]=='1'){ echo "Platinum Customer";  }else if($objResult["status_cus"]=='2'){ echo "Daimond Customer";  } ?>


</td> 

	</tr>




<?php }
}
	?>
</table>

<?php
	
$strSQL15 = "SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE cus_no='".$objResult["customer_no"]."'";
if($start_date !=""){ 
    $strSQL15 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND doc_date <= "'.$end_date.'"'; 
}	
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);
	
	?>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="100%" align="center" class="style40"><?php echo $objResult["preface_name"]; ?>&nbsp;&nbsp;<?php echo $objResult["first_name"]; ?>  &nbsp;&nbsp;<?php echo $objResult["last_name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo 'รหัสสมาชิก'; ?>&nbsp;&nbsp; <?php echo $objResult["customer_no"]; ?> &nbsp;&nbsp; <?php echo 'ยอดรวม'; ?> &nbsp;&nbsp; <?php echo number_format($objResult15["sum_amount"],2)."";  ?>&nbsp;&nbsp;<?php echo 'บาท'; ?></td>

	</tr>
	</table>


<?php }else if($h_start_codepro !=''){

$strSQL ="SELECT  sol_name,access_code,unit_name FROM tb_product WHERE product_ID='".$h_start_codepro."' ";
$objQuery =mysqli_query($conn,$strSQL);
$objResult=mysqli_fetch_array($objQuery);

?>

<span class="style16"><b><?php echo $objResult["access_code"]; ?>&nbsp;&nbsp;<?php echo $objResult["sol_name"]; ?>   </b></span><br>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่ออกบิล</td>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">รหัสสมาชิก</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ราคารวม</td> 
<td width="10%" align="center" class="style30">ยอดรวม</td> 
<td width="10%" align="center" class="style30">สถานะลูกค้า</td> 


	</tr>
<?php 
$strSQL1 ="SELECT  ref_idd,sale_count,sum_amount,price_per_unit FROM so__submain WHERE product_id ='".$h_start_codepro."' and cus_no !=''";
if($start_date !=""){ 
    $strSQL1 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_date <= "'.$end_date.'"'; 
}
	
$strSQL1 .= ' ORDER BY doc_date ASC '; 
$objQuery1 =mysqli_query($conn,$strSQL1);	
while($objResult1 = mysqli_fetch_array($objQuery1))
{	

$strSQL2 ="SELECT  doc_no,doc_release_date,ref_id,bill_id FROM so__main WHERE ref_id ='".$objResult1["ref_idd"]."' and cancel_ckk='0' and approve_complete = 'Approve'";
/*if($start_date !=""){ 
    $strSQL2 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}*/
	
$objQuery2 =mysqli_query($conn,$strSQL2);	
$objResult2=mysqli_fetch_array($objQuery2);
	
	
$strSQL3 ="SELECT  status_cus,customer_no,first_name,last_name,preface_name FROM tb_customer WHERE customer_id='".$objResult2["bill_id"]."' ";
$objQuery3 =mysqli_query($conn,$strSQL3);
//$Num_Rows3 = mysqli_num_rows($objQuery3);
$objResult3=mysqli_fetch_array($objQuery3);
	
	
//if($Num_Rows3 > 0){	
	?>

<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult2["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult2["doc_no"]; ?></td>
<td class="style30"><div align="left"><?php echo  $objResult3["first_name"]; ?>  <?php echo  $objResult3["last_name"]; ?></div></td>
<td class="style30"><div align="left"><?php echo  $objResult3["customer_no"]; ?></div></td>
<td class="style30"><div align="right"><?php 	echo $objResult1["sale_count"];   echo $objResult["unit_name"];	?></div></td>
<td class="style30"><div align="right"><?php	echo number_format($objResult1["price_per_unit"],2).""; 	?></div></td>
<td  align="right" class="style30"><?php echo number_format($objResult1["sum_amount"],2).""; ?></td> 
<td  align="center" class="style30">
<?php if($objResult3["status_cus"]=='0'){echo "Gold Customer"; }else if($objResult3["status_cus"]=='1'){ echo "Platinum Customer";  }else if($objResult3["status_cus"]=='2'){ echo "Daimond Customer";  } ?>


</td> 

	</tr>



<?php
}
/*} 
}*/
	?>
	</table>

<?php
	
$strSQL15 = "SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE cus_no !='' and product_id ='".$h_start_codepro."'";
if($start_date !=""){ 
    $strSQL15 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND doc_date <= "'.$end_date.'"'; 
}	
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);
	
	?>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="100%" align="center" class="style40"><?php echo 'ยอดรวมทั้งหมด'; ?>&nbsp;&nbsp;  <?php echo number_format($objResult15["sum_amount"],2)."";  ?>&nbsp;&nbsp;<?php echo 'บาท'; ?></td>

	</tr>
	</table>


	<?php } ?>

</body>
</html>