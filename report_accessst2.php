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
$sale_channel = $_GET["sale_channel"]; 
include"dbconnect.php";



?>
<body>


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
$strSQL = "SELECT date_disburse,order_id,customer_name,employee_name,delivery_contact,billing_name,doc_no,sale_channel  FROM so__main  WHERE cancel_ckk='0' ";
	
if($start_date !=""){ 

    $strSQL .= ' AND date_disburse  >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND date_disburse  <= "'.$end_date.'"'; 
/*$strSQL .= ' AND stock_date  = "'.$end_date.'"';*/ 
}
	

	if($sale_channel !=""){ 
    $strSQL .= ' AND sale_channel = "'.$sale_channel.'"'; 

}
	if($company !=""){ 
	$strSQL .= ' AND select_type_doc = "'.$company.'"'; 
	}


$strSQL .=" order  by ref_id ASC  ";	
	//echo $strSQL;

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



//$objQuery  = mysql_query($strSQL);



$i = 2;
$n=2;
$sum = 0;

while($objResult = mysqli_fetch_array($objQuery))
{



if($objResult["customer_name"]!=""){
	$customer_name = $objResult["customer_name"];
}else if ($objResult["delivery_contact"]){
	$customer_name = $objResult["delivery_contact"];
}else{
	$customer_name = $objResult["billing_name"];
}
	
	
	if($objResult["order_id"] !='' and $objResult["sale_channel"] =='3' ){
    $order_id = $objResult["doc_no"];	 
	}if($objResult["order_id"] !=''){
    $order_id = $objResult["order_id"];	 
	}else{
	 $order_id = $objResult["doc_no"];	 		
	}
    $employee_name = $objResult["employee_name"];
    $stock_date1 = $objResult["date_disburse"];
    
$date = explode('-' ,$stock_date1);
$stock_date = $date[2].'-'.$date[1].'-'.$date[0];
	
?>
<tr>


	

<td  align="center" class="style30"><?php echo $stock_date; ?></td>
<td  align="center" class="style30"><?php echo $order_id; ?></td>
<td  align="center" class="style30"><?php echo $customer_name; ?></td> 
<td  align="center" class="style30"><?php echo $employee_name; ?></td> 

</tr>

<?php
}
	
	
	$strSQL = "SELECT date_disburse,order_id,customer_name,employee_name,delivery_contact,billing_name,doc_no,ref_id  FROM so__main  WHERE cancel_ckk='0' ";
	
if($start_date !=""){ 

    $strSQL .= ' AND date_disburse  >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND date_disburse  <= "'.$end_date.'"'; 
/*$strSQL .= ' AND stock_date  = "'.$end_date.'"'; */
}
	
	if($sale_channel !=""){ 
    $strSQL .= ' AND sale_channel = "'.$sale_channel.'"'; 
	}
	if($company1 !=""){ 
	$strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
	}


$strSQL .=" order  by ref_id ASC  ";	
	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


while($objResult = mysqli_fetch_array($objQuery))
{



if($objResult["customer_name"]!=""){
	$customer_name = $objResult["customer_name"];
}else if ($objResult["delivery_contact"]){
	$customer_name = $objResult["delivery_contact"];
}else{
	$customer_name = $objResult["billing_name"];
}
	
	
	if($objResult["order_id"] !=''){
    $order_id = $objResult["order_id"];	 
	}else{
	 $order_id = $objResult["doc_no"];	 		
	}
    $employee_name = $objResult["employee_name"];
    $stock_date1 = $objResult["date_disburse"];
    
$date = explode('-' ,$stock_date1);
$stock_date = $date[2].'-'.$date[1].'-'.$date[0];
    
	
?>

<tr>


	

<td  align="center" class="style30"><?php echo $stock_date; ?></td>
<td  align="center" class="style30"><?php echo $order_id; ?></td>
<td  align="center" class="style30"><?php echo $customer_name; ?></td> 
<td  align="center" class="style30"><?php echo $employee_name; ?></td> 


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
$strSQL = "SELECT date_disburse,order_id,customer_name,employee_name,select_type_doc,ref_id,delivery_contact,billing_name,doc_no  FROM so__main  WHERE cancel_ckk='0' ";
	
if($start_date !=""){ 

    $strSQL .= ' AND date_disburse  >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND date_disburse  <= "'.$end_date.'"'; 
/*$strSQL .= ' AND stock_date  = "'.$end_date.'"'; */
}
	
	if($sale_channel !=""){ 
    $strSQL .= ' AND sale_channel = "'.$sale_channel.'"'; 

}
	if($company !=""){ 
	$strSQL .= ' AND select_type_doc = "'.$company.'"'; 
	}


$strSQL .=" order  by ref_id ASC  ";	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



//$objQuery  = mysql_query($strSQL);



$i = 2;
$n=2;
$sum = 0;

while($objResult = mysqli_fetch_array($objQuery))
{
$ref_id = $objResult["ref_id"];	
	
$strSQL1 = "SELECT stock_remark,product_id,sale_count FROM so__submain WHERE ref_idd = '".$ref_id."'";
	//echo $strSQL1;
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);	
while($objResult1 = mysqli_fetch_array($objQuery1))
{



if($objResult["customer_name"]!=""){
	$customer_name = $objResult["customer_name"];
}else if ($objResult["delivery_contact"]){
	$customer_name = $objResult["delivery_contact"];
}else{
	$customer_name = $objResult["billing_name"];
}
	
	if($objResult["select_type_doc"] =="1" or $objResult["select_type_doc"] =="2"){
	$select_type_doc = 'BRN / BRN P';
	}else{
	$select_type_doc = 'IV';
	}

	if($objResult["order_id"] !=''){
    $order_id = $objResult["order_id"];	 
	}else{
	 $order_id = $objResult["doc_no"];	 		
	}
	 $doc_no = $objResult["doc_no"];
    $employee_name = $objResult["employee_name"];
    $stock_date = DateThai($objResult["date_disburse"]);
    
	$product_id = $objResult1["product_id"];
	//echo $product_id;
	
     $count = $objResult1["sale_count"];

     $stock_remark = $objResult1["stock_remark"];
	
if ($product_id == '3191'  or $product_id == '3192' or $product_id == '3193' or $product_id == '3194' or $product_id == '3195' or $product_id == '3197' or $product_id == '3198' or $product_id == '3199' or $product_id == '3200' or $product_id == '3202' or $product_id == '3206' or $product_id == '3606' or $product_id == '3611'  or $product_id == '3196'){	
}else{	
$strSQL2 = "SELECT access_code_old,sol_code,sol_name FROM tb_product WHERE product_ID = '".$product_id."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);	
while($objResult2 = mysqli_fetch_array($objQuery2))
{
$access_code = $objResult2["access_code_old"];	
$sol_code = $objResult2["sol_code"];	
$sol_name = $objResult2["sol_name"];
	

?>


<tr>
<td  align="center" class="style30"><?php echo $order_id; ?></td>
<td  align="center" class="style30"><?php echo $access_code; ?></td> 
<td  align="center" class="style30"><?php echo $select_type_doc; ?></td> 
<td  align="center" class="style30"><?php echo $count; ?></td> 
<td  align="center" class="style30"><?php echo $doc_no; ?></td> 

</tr>

<?php
}
}
}
}

	
	
	$strSQL = "SELECT date_disburse,order_id,customer_name,employee_name,select_type_doc,ref_id,delivery_contact,billing_name,doc_no  FROM so__main  WHERE cancel_ckk='0' ";

	
if($start_date !=""){ 

    $strSQL .= ' AND date_disburse  >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND date_disburse  <= "'.$end_date.'"'; 
/*$strSQL .= ' AND stock_date  = "'.$end_date.'"'; */
}
	
	if($sale_channel !=""){ 
    $strSQL .= ' AND sale_channel = "'.$sale_channel.'"'; 

}
	if($company1 !=""){ 
	$strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
	}


$strSQL .=" order  by ref_id ASC  ";	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);




while($objResult = mysqli_fetch_array($objQuery))
{
$ref_id = $objResult["ref_id"];	
	
$strSQL1 = "SELECT stock_remark,product_id,sale_count FROM so__submain WHERE ref_idd = '".$ref_id."'";
	//echo $strSQL1;
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);	
while($objResult1 = mysqli_fetch_array($objQuery1))
{



if($objResult["customer_name"]!=""){
	$customer_name = $objResult["customer_name"];
}else if ($objResult["delivery_contact"]){
	$customer_name = $objResult["delivery_contact"];
}else{
	$customer_name = $objResult["billing_name"];
}
	
	if($objResult["select_type_doc"] =="1" or $objResult["select_type_doc"] =="2"){
	$select_type_doc = 'BRN / BRN P';
	}else{
	$select_type_doc = 'IV';
	}

	if($objResult["order_id"] !=''){
    $order_id = $objResult["order_id"];	 
	}else{
	 $order_id = $objResult["doc_no"];	 		
	}
	 $doc_no = $objResult["doc_no"];	 		

    $employee_name = $objResult["employee_name"];
    $stock_date = DateThai($objResult["date_disburse"]);
    
	$product_id = $objResult1["product_id"];
     $count = $objResult1["sale_count"];
     $stock_remark = $objResult1["stock_remark"];

	if ($product_id == '3191'  or $product_id == '3192' or $product_id == '3193' or $product_id == '3194' or $product_id == '3195' or $product_id == '3197' or $product_id == '3198' or $product_id == '3199' or $product_id == '3200' or $product_id == '3202' or $product_id == '3206' or $product_id == '3606' or $product_id == '3611'  or $product_id == '3196'){	
}else{	
		
$strSQL2 = "SELECT access_code_old,sol_code,sol_name FROM tb_product WHERE product_ID = '".$product_id."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);	
while($objResult2 = mysqli_fetch_array($objQuery2))
{
$access_code = $objResult2["access_code_old"];	
$sol_name = $objResult2["sol_name"];	
$sol_code = $objResult2["sol_code"];
	

?>

<tr>


	

<td  align="center" class="style30"><?php echo $order_id; ?></td>
<td  align="center" class="style30"><?php echo $access_code; ?></td>
<td  align="center" class="style30"><?php echo $select_type_doc; ?></td> 
<td  align="center" class="style30"><?php echo $count; ?></td> 
<td  align="center" class="style30"><?php echo $doc_no; ?></td> 

</tr>

<?php
}
}
}
}
?>

</table>


</body>
</html>