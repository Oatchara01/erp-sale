<?php include ("head2.php"); ?>
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

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$company = $_GET["company"]; 
$sale_channel  = $_GET["sale_channel"]; 

include"dbconnect.php";
include"dbconnect_sale.php";




?>
<body>

<?php 
if($company =='3'){
$company_name = "บริษัท ออลล์เวล ไลฟ์ จำกัด";

}else if($company =='4'){
$company_name = "บริษัท โนเบิล เมด จำกัด";

}


$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;



?>

</p>



<table border= "1" width="100%" class='w3-table'>
<tr>
	<?php if($_SESSION['name']=='พัชร์ชนัญ'){ ?>
	<td width="5%" align="center" class="style30">CUST_ID</td>
	<?php } ?>
<td width="5%" align="center" class="style30">CUSTID</td>
<td width="5%" align="center" class="style30">DOCNUM</td>
<td width="5%" align="center" class="style30">ORDNUM</td> 
<td width="5%" align="center" class="style30">BR</td> 
<td width="5%" align="center" class="style30">TERM</td> 
<td width="5%" align="center" class="style30">SALEID</td> 
<td width="5%" align="center" class="style30">AREAID</td>
<td width="5%" align="center" class="style30">DOCDAT</td>
<td width="5%" align="center" class="style30">STKCOD</td>
<td width="5%" align="center" class="style30">STKDES</td>
<td width="5%" align="center" class="style30">TRNQTY</td>
<td width="5%" align="center" class="style30">TRNUNIT</td>
<td width="5%" align="center" class="style30">UNITPR</td>
<td width="5%" align="center" class="style30">TRNDIS</td>
<td width="5%" align="center" class="style30">TRNVAL</td>
<td width="5%" align="center" class="style30">TOTAL</td>
<td width="5%" align="center" class="style30">DISAMT</td>
<td width="5%" align="center" class="style30">AIDOC</td>
<td width="5%" align="center" class="style30">AIAMT</td>
<td width="5%" align="center" class="style30">VATRAT</td>
<td width="5%" align="center" class="style30">VATAMT</td>
<td width="5%" align="center" class="style30">NETAMT</td>

	</tr>

<?php

$strSQL = "SELECT ref_id,bill_id,billing_name,select_type_doc,ex_add,ex_aumper,ex_provin,ex_post,billing_tel,product_id,sale_count,sum_amount,price_per_unit,doc_no,order_id,doc_release_date,ref_id,sum_amount,employee_name   FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  where cancel_ckk='0' and approve_complete ='Approve'  and doc_no LIKE '%E%' ";

//nd doc_no NOT LIKE '%AI%'  and doc_no NOT LIKE '%AR%'
if($start_date !=""){ 
    $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; 
}
if($company !=""){ 
	$strSQL .= ' AND select_type_doc = "'.$company.'"'; 

}
if($sale_channel !=''){
$strSQL .= ' AND sale_channel = "'.$sale_channel.'"'; 	
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$strSQL5 = "SELECT product_code FROM so__submain WHERE ref_idd = '".$objResult["ref_id"]."'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");



$strSQL1 = "SELECT customer_code,customer_coden,preface_name,sale_code FROM tb_customer WHERE customer_id = '".$objResult["bill_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$strSQL2 = "SELECT express_code,sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult["product_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$strSQL3 = "SELECT SUM(discount_unit) AS discount_unit,SUM(sum_amount) AS sum_amount,SUM(sale_count) AS sale_count    FROM so__submain WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	
$strSQL5 = "SELECT SUM(sum_amount) AS sum_amount,SUM(discount_unit) AS discount_unit   FROM so__submain WHERE ref_idd = '".$objResult["ref_id"]."' and price_per_unit !='0.00'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);	

$strSQL4 = "SELECT discount_unit FROM so__submain WHERE ref_idd = '".$objResult["ref_id"]."' and product_id ='3197'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

if($objResult["product_id"]=='4401' or $objResult["product_id"]=='4389' or $objResult["product_id"]=='3612' or $objResult["product_id"]=='3196' or $objResult["product_id"]=='4505'  or $objResult["product_id"]=='4506'  or $objResult["product_id"]=='4507'  or $objResult["product_id"]=='4504'){ }else{
?>
<tr>
<?php if($_SESSION['name']=='พัชร์ชนัญ'){ ?>
	<td  align="left" class="style30"><?php echo $objResult["bill_id"]; ?></td>
	<?php } ?>
	
<td width="10%" align="left" class="style30"><?php if($objResult["select_type_doc"]=='3'){ echo $objResult1["customer_code"]; }else if($objResult["select_type_doc"]=='4'){ echo $objResult1["customer_coden"];  } ?>

</td>
<td  align="left" class="style30"><?php echo $objResult["doc_no"]; ?></td>
<td  align="left" class="style30"><?php echo $objResult["order_id"]; ?></td> 
<td  align="left" class="style30"><?php echo '0'; ?></td> 
<td  align="left" class="style30"><?php echo '0'; ?></td> 
<td  align="left" class="style30"><?php if($objResult["employee_name"]=='(SOL99)'){ echo "SOL99"; }else{ echo $objResult["employee_name"]; } ?></td> 
<td  align="left" class="style30"><?php echo 'กท'; ?></td>
<td width="10%" align="left" class="style30">

<?php

$date_arr = explode('-' , $objResult["doc_release_date"] );
$dd = $date_arr[2];
$mm = $date_arr[1];
$yy5 = $date_arr[0]; //+543
$yy = substr($yy5,2,2);

echo $iv_date = "$dd/$mm/$yy5";

?>
</td>

<td  align="left" class="style30"><?php echo $objResult2["express_code"]; ?></td>
<td  align="left" class="style30"><?php echo $objResult2["sol_name"]; ?></td>
<td  align="left" class="style30">
	<?php 
	if($objResult["product_id"]=='5801'){ echo ($objResult["sale_count"]*6); }else{ echo $objResult["sale_count"]; }
	?>
</td>
<td  align="left" class="style30"><?php  if($objResult["product_id"]=='5801'){ echo "ซอง";  }else{ echo $objResult2["unit_name"]; } ?></td>
<td  align="left" class="style30"><?php	echo number_format($objResult["price_per_unit"],2)."";  ?></td>
<td  align="left" class="style30"><?php echo number_format($objResult["discount_unit"],2).""; ?></td>

<td  align="left" class="style30"><?php echo number_format($objResult["sum_amount"],2).""; ?></td>
<td  align="left" class="style30"><?php echo number_format($objResult5["sum_amount"]+$objResult5["discount_unit"],2).""; ?></td>
<td  align="left" class="style30"><?php echo number_format($objResult3["discount_unit"],2).""; ?></td>
<td  align="left" class="style30"><?php echo number_format($objResult4["discount_unit"],2).""; ?></td>
<td  align="left" class="style30"><?php echo ''; ?></td>
<td  align="left" class="style30"><?php echo '7.00'; ?></td>
<td  align="left" class="style30"><?php echo number_format($objResult3["sum_amount"]-($objResult3["sum_amount"]/1.07),2).""; ?></td>
<td  align="left" class="style30"><?php echo number_format($objResult3["sum_amount"],2).""; ?></td>


	</tr>
	
	<?php 
	$i++;
}
}
?>
</table>


</body>
</html>