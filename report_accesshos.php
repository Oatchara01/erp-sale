<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 18px; color: #FF0000;}
.style17 {font-size: 18px; color: #3333FF;}
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
$str_arr = $_GET["company"]; 
$company = substr($str_arr, 0,1);
$company1 = substr($str_arr,-1);
$type_doc = $_GET["type_doc"]; 
include"dbconnect.php";



?>
<body>

<?php if($type_doc =='1'){ ?>

<center>
<span class="style15">ข้อมูลลงทะเบียน Access Stock</span></p>

</center>
</p>
<span class="style16">ข้อมูลหลักลูกค้า</span></p>
</p>

			



<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="20%" align="center" class="style30">ชื่อพนักงาน</td> 
</tr>
	<?php
$strSQL = "SELECT date_disburse,iv_no,bill_name,sale_code  FROM hos__so  WHERE status_doc ='Approve' and report_ckk ='0'";
	
if($start_date !=""){ 

    $strSQL .= ' AND date_disburse  >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND date_disburse  <= "'.$end_date.'"'; 
/*$strSQL .= ' AND stock_date  = "'.$end_date.'"';*/ 
}
	

	if($company !=""){ 
	$strSQL .= ' AND type_doc = "'.$company1.'"'; 
	}


$strSQL .=" order  by iv_no ASC  ";	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



//$objQuery  = mysql_query($strSQL);



$i = 2;
$n=2;
$sum = 0;

while($objResult = mysqli_fetch_array($objQuery))
{

 $bill_name = $objResult["bill_name"];
 $iv_no = $objResult["iv_no"];	 		

    $sale_code = $objResult["sale_code"];
    $stock_date1 = $objResult["date_disburse"];
    
$date = explode('-' ,$stock_date1);
$stock_date = $date[2].'-'.$date[1].'-'.$date[0];
	
?>
<tr>


	

<td  align="center" class="style30"><?php echo $stock_date; ?></td>
<td  align="center" class="style30"><?php echo $iv_no; ?></td>
<td  align="center" class="style30"><?php echo $bill_name; ?></td> 
<td  align="center" class="style30"><?php echo $sale_code; ?></td> 

</tr>

<?php
}
?>

</table>

</p>
<span class="style16">ข้อมูลรายละเอียดสินค้า</span></p>
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="25%" align="center" class="style30">รหัสสินค้า</td> 
<td width="10%" align="center" class="style30">ประเภทเอกสาร</td> 
<td width="10%" align="center" class="style30">จำนวนจ่าย</td> 
<td width="10%" align="center" class="style30">หมายเหตุ</td> 


	</tr>
	<?php
$strSQL = "SELECT date_disburse,iv_no,ref_id  FROM hos__so  WHERE status_doc ='Approve'  and report_ckk ='0'";
	
if($start_date !=""){ 

    $strSQL .= ' AND date_disburse  >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND date_disburse  <= "'.$end_date.'"'; 
}
	

	if($company !=""){ 
	$strSQL .= ' AND type_doc = "'.$company1.'"'; 
	}


$strSQL .=" order  by ref_id ASC  ";	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



while($objResult = mysqli_fetch_array($objQuery))
{
$ref_id = $objResult["ref_id"];	
	
$strSQL1 = "SELECT stock_remark,product_id,count FROM hos__subso WHERE ref_idd = '".$ref_id."'";
	//echo $strSQL1;
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
 $iv_no = $objResult["iv_no"];	 		
    $stock_date1 = $objResult["date_disburse"];
    
$date = explode('-' ,$stock_date1);
$stock_date = $date[2].'-'.$date[1].'-'.$date[0];

	$select_type_doc = 'IV';
	$product_id = $objResult1["product_id"];
     $count = $objResult1["count"];
     $stock_remark = $objResult1["stock_remark"];
	
$strSQL2 = "SELECT access_code_old,sol_code,sol_name FROM tb_product WHERE product_ID = '".$product_id."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);	
while($objResult2 = mysqli_fetch_array($objQuery2))
{
$access_code = $objResult2["access_code_old"];	
	

?>


<tr>
<td  align="center" class="style30"><?php echo $iv_no; ?></td>
<td  align="center" class="style30"><?php echo $access_code; ?></td> 
<td  align="center" class="style30"><?php echo $select_type_doc; ?></td> 
<td  align="center" class="style30"><?php echo $count; ?></td> 
<td  align="center" class="style30"><?php echo $iv_no; ?></td> 

</tr>

<?php
}
}
}

?>	
	


</table>

<?php 
$strSQL8 = "SELECT ref_id  FROM hos__so  WHERE status_doc ='Approve' and report_ckk ='0'";
	if($start_date !=""){ 
    $strSQL8 .= ' AND date_disburse  >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
    $strSQL8 .= ' AND date_disburse  <= "'.$end_date.'"'; 
}
if($company !=""){ 
	$strSQL8 .= ' AND type_doc = "'.$company1.'"'; 
	}
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
while($objResult8 = mysqli_fetch_array($objQuery8))
{
	
$save="Update  hos__so set report_ckk = '1'  where ref_id = '".$objResult8["ref_id"]."'";
$qsave=mysqli_query($conn,$save);

 
}


?>

<?php }else if($type_doc =='2'){ ?>

<center>
<span class="style15">ข้อมูลลงทะเบียน Access Stock</span></p>

</center>
</p>
<span class="style16">ข้อมูลหลักลูกค้า</span></p>
</p>

			



<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="20%" align="center" class="style30">ชื่อพนักงาน</td> 
</tr>
	<?php
$strSQL = "SELECT date_disburse,iv_no,customer,sale_code  FROM hos__br  WHERE status_doc ='Approve'  and report_ckk ='0'";
	
if($start_date !=""){ 

    $strSQL .= ' AND date_disburse  >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND date_disburse  <= "'.$end_date.'"'; 
/*$strSQL .= ' AND stock_date  = "'.$end_date.'"';*/ 
}
	

	if($company !=""){ 
	$strSQL .= ' AND company = "'.$company.'"'; 
	}


$strSQL .=" order  by ref_id_br ASC  ";	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


while($objResult = mysqli_fetch_array($objQuery))
{

 $bill_name = $objResult["customer"];
 $iv_no = $objResult["iv_no"];	 		

    $sale_code = $objResult["sale_code"];
    $stock_date1 = $objResult["date_disburse"];
    
$date = explode('-' ,$stock_date1);
$stock_date = $date[2].'-'.$date[1].'-'.$date[0];
	
?>
<tr>


	

<td  align="center" class="style30"><?php echo $stock_date; ?></td>
<td  align="center" class="style30"><?php echo $iv_no; ?></td>
<td  align="center" class="style30"><?php echo $bill_name; ?></td> 
<td  align="center" class="style30"><?php echo $sale_code; ?></td> 

</tr>

<?php
}
?>

</table>

</p>
<span class="style16">ข้อมูลรายละเอียดสินค้า</span></p>
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="25%" align="center" class="style30">รหัสสินค้า</td> 
<td width="10%" align="center" class="style30">ประเภทเอกสาร</td> 
<td width="10%" align="center" class="style30">จำนวนจ่าย</td> 
<td width="10%" align="center" class="style30">หมายเหตุ</td> 


	</tr>
	<?php
$strSQL = "SELECT date_disburse,iv_no,ref_id_br  FROM hos__br  WHERE status_doc ='Approve'  and report_ckk ='0'";
	
if($start_date !=""){ 

    $strSQL .= ' AND date_disburse  >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND date_disburse  <= "'.$end_date.'"'; 
}
	

	if($company !=""){ 
	$strSQL .= ' AND company = "'.$company.'"'; 
	}


$strSQL .=" order  by ref_id_br ASC  ";	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



while($objResult = mysqli_fetch_array($objQuery))
{
$ref_id_br = $objResult["ref_id_br"];	
	
$strSQL1 = "SELECT stock_remark,product_id,count FROM hos__subbr WHERE ref_idd_br = '".$ref_id_br."'";
	//echo $strSQL1;
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);	
while($objResult1 = mysqli_fetch_array($objQuery1))
{

 $iv_no = $objResult["iv_no"];	 		
    $stock_date1 = $objResult["date_disburse"];
    
$date = explode('-' ,$stock_date1);
$stock_date = $date[2].'-'.$date[1].'-'.$date[0];

	$select_type_doc = 'BRN / BRN P';
	

	
    
	$product_id = $objResult1["product_id"];
	
     $count = $objResult1["count"];

     $stock_remark = $objResult1["stock_remark"];
	
$strSQL2 = "SELECT access_code_old,sol_code,sol_name FROM tb_product WHERE product_ID = '".$product_id."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);	
while($objResult2 = mysqli_fetch_array($objQuery2))
{
$access_code = $objResult2["access_code_old"];	
	

?>


<tr>
<td  align="center" class="style30"><?php echo $iv_no; ?></td>
<td  align="center" class="style30"><?php echo $access_code; ?></td> 
<td  align="center" class="style30"><?php echo $select_type_doc; ?></td> 
<td  align="center" class="style30"><?php echo $count; ?></td> 
<td  align="center" class="style30"><?php echo $iv_no; ?></td> 

</tr>

<?php
}
}
}

?>	
	


</table>
<?php 
$strSQL8 = "SELECT ref_idd_br  FROM hos__br  WHERE status_doc ='Approve'  and report_ckk ='0'";
if($start_date !=""){ 
    $strSQL8 .= ' AND date_disburse  >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
    $strSQL8 .= ' AND date_disburse  <= "'.$end_date.'"'; 
}
if($company !=""){ 
$strSQL8 .= ' AND company = "'.$company.'"'; 
}
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
while($objResult8 = mysqli_fetch_array($objQuery8))
{
$save="Update  hos__br set report_ckk = '1'  where ref_id_br = '".$objResult8["ref_id_br"]."'";
$qsave=mysqli_query($conn,$save);

}
?>

	<?php }else if($type_doc =='3'){ ?>

<center>
<span class="style15">ข้อมูลลงทะเบียน Access Stock</span></p>

</center>
</p>
<span class="style16">ข้อมูลหลักลูกค้า</span></p>
</p>

			



<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="20%" align="center" class="style30">ชื่อพนักงาน</td> 
</tr>
	<?php
$strSQL = "SELECT date_disburse,smp_no,customer_name,sale_code  FROM hos__smp  WHERE status_sup ='Approve'  and report_ckk ='0'";
	
if($start_date !=""){ 

    $strSQL .= ' AND date_disburse  >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND date_disburse  <= "'.$end_date.'"'; 
/*$strSQL .= ' AND stock_date  = "'.$end_date.'"';*/ 
}
	

	if($company !=""){ 
	$strSQL .= ' AND type_company = "'.$company.'"'; 
	}


$strSQL .=" order  by ref_idsmp ASC  ";	
//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


while($objResult = mysqli_fetch_array($objQuery))
{

 $bill_name = $objResult["customer_name"];
 $smp_no = $objResult["smp_no"];	 		

    $sale_code = $objResult["sale_code"];
    $stock_date1 = $objResult["date_disburse"];
    
$date = explode('-' ,$stock_date1);
$stock_date = $date[2].'-'.$date[1].'-'.$date[0];
	
?>
<tr>


	

<td  align="center" class="style30"><?php echo $stock_date; ?></td>
<td  align="center" class="style30"><?php echo $smp_no; ?></td>
<td  align="center" class="style30"><?php echo $bill_name; ?></td> 
<td  align="center" class="style30"><?php echo $sale_code; ?></td> 

</tr>

<?php
}
?>

</table>

</p>
<span class="style16">ข้อมูลรายละเอียดสินค้า</span></p>
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="25%" align="center" class="style30">รหัสสินค้า</td> 
<td width="10%" align="center" class="style30">ประเภทเอกสาร</td> 
<td width="10%" align="center" class="style30">จำนวนจ่าย</td> 
<td width="10%" align="center" class="style30">หมายเหตุ</td> 


	</tr>
	<?php
$strSQL = "SELECT date_disburse,smp_no,ref_idsmp  FROM hos__smp  WHERE status_sup ='Approve'  and report_ckk ='0'";
	
if($start_date !=""){ 

    $strSQL .= ' AND date_disburse  >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND date_disburse  <= "'.$end_date.'"'; 
}
	

	if($company !=""){ 
	$strSQL .= ' AND type_company = "'.$company.'"'; 
	}


$strSQL .=" order  by ref_idsmp ASC  ";	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



while($objResult = mysqli_fetch_array($objQuery))
{
$ref_idsmp = $objResult["ref_idsmp"];	
	
$strSQL1 = "SELECT product_id,sale_count FROM hos__subsmp WHERE reff_idsmp = '".$ref_idsmp."'";
	//echo $strSQL1;
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);	
while($objResult1 = mysqli_fetch_array($objQuery1))
{

 $iv_no = $objResult["smp_no"];	 		
    $stock_date1 = $objResult["date_disburse"];
    
$date = explode('-' ,$stock_date1);
$stock_date = $date[2].'-'.$date[1].'-'.$date[0];

	$select_type_doc = 'SMP';
	

	
    
	$product_id = $objResult1["product_id"];
	
     $count = $objResult1["sale_count"];

     //$stock_remark = $objResult1["stock_remark"];
	
$strSQL2 = "SELECT access_code_old,sol_code,sol_name FROM tb_product WHERE product_ID = '".$product_id."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);	
while($objResult2 = mysqli_fetch_array($objQuery2))
{
$access_code = $objResult2["access_code_old"];	
	

?>


<tr>
<td  align="center" class="style30"><?php echo $iv_no; ?></td>
<td  align="center" class="style30"><?php echo $access_code; ?></td> 
<td  align="center" class="style30"><?php echo $select_type_doc; ?></td> 
<td  align="center" class="style30"><?php echo $count; ?></td> 
<td  align="center" class="style30"><?php echo $iv_no; ?></td> 

</tr>

<?php
}
}
}

?>	
	


</table>

<?php 
$strSQL8 = "SELECT ref_idsmp  FROM hos__smp  WHERE status_sup ='Approve'  and report_ckk ='0'";
if($start_date !=""){ 
$strSQL8 .= ' AND date_disburse  >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
    $strSQL8 .= ' AND date_disburse  <= "'.$end_date.'"'; 
}
if($company !=""){ 
$strSQL8 .= ' AND type_company = "'.$company.'"'; 
}
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
while($objResult8 = mysqli_fetch_array($objQuery8))
{
$save="Update  hos__smp set report_ckk = '1'  where ref_idsmp = '".$objResult8["ref_idsmp"]."'";
$qsave=mysqli_query($conn,$save);

}

?>


<?php } ?>


</body>
</html>