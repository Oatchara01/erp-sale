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

$iv_no = $_GET["iv_no"];

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
	
$strSQL42 = "SELECT DISTINCT 
                s.product_code, 
                s.price_per_unit
                
            FROM so__main m
            LEFT JOIN so__submain s ON m.ref_id = s.ref_idd
            LEFT JOIN tb_product p ON p.product_id = s.product_id
            WHERE m.cancel_ckk = '0'
              AND m.approve_complete = 'Approve'";

if($iv_no != ''){
    $strSQL42 .= " AND m.iv_no = '".$iv_no."' ";
}

$strSQL42 .= " ORDER BY p.access_code ASC, s.price_per_unit DESC ";



$objQuery42 = mysqli_query($conn,$strSQL42) or die ("Error Query [".$strSQL42."]");
$Num_Rows42 = mysqli_num_rows($objQuery42);

$i = 1;
while($objResult42 = mysqli_fetch_array($objQuery42))
{	
	
	

$strSQL = "SELECT SUM(discount_unit) AS discount_unit,SUM(sum_amount) AS sum_amount,SUM(sale_count) AS sale_count  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  where cancel_ckk='0' and approve_complete ='Approve' and product_id ='".$objResult42["product_code"]."' and price_per_unit = '".$objResult42["price_per_unit"]."' ";

if($iv_no !=''){
$strSQL .= ' AND iv_no = "'.$iv_no.'"'; 	
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$strSQL15 = "SELECT sale_channel,iv_no,iv_date,employee_name,select_type_doc FROM so__main WHERE iv_no = '".$iv_no."'";
$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);

if($objResult15["sale_channel"]=='1'){

$bill_id ='1398';

}else if($objResult15["sale_channel"]=='12'){

$bill_id ='24995';

}else if($objResult15["sale_channel"]=='34'){

$bill_id ='106403';
	
}else if($objResult15["sale_channel"]=='25'){

$bill_id ='63624';
	

}
	
$strSQL1 = "SELECT customer_code,customer_coden,preface_name,sale_code FROM tb_customer WHERE customer_id = '".$bill_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);





$strSQL2 = "SELECT express_code,sol_name,unit_name FROM tb_product WHERE product_ID = '".$objResult42["product_code"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
								  

/*$strSQL3 = "SELECT SUM(discount_unit) AS discount_unit,SUM(sum_amount) AS sum_amount,SUM(sale_count) AS sale_count    FROM so__submain WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	
$strSQL5 = "SELECT SUM(sum_amount) AS sum_amount,SUM(discount_unit) AS discount_unit   FROM so__submain WHERE ref_idd = '".$objResult["ref_id"]."' and price_per_unit !='0.00'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);	

$strSQL4 = "SELECT discount_unit FROM so__submain WHERE ref_idd = '".$objResult["ref_id"]."' and product_id ='3197'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);*/
	
	
$strSQL4 = "SELECT SUM(discount_unit) AS discount_unit FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  where cancel_ckk='0' and approve_complete ='Approve' and (product_id ='4401' or product_id ='4389' or product_id ='3612' or product_id ='3196' or product_id ='4505' or product_id ='4506' or product_id ='4507' or product_id ='4504') ";

if($iv_no !=''){
$strSQL4 .= ' AND iv_no = "'.$iv_no.'"'; 	
}

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);	
	
								  

if($objResult42["product_code"]=='4401' or $objResult42["product_code"]=='4389' or $objResult42["product_code"]=='3612' or $objResult42["product_code"]=='3196' or $objResult42["product_code"]=='4505'  or $objResult42["product_code"]=='4506'  or $objResult42["product_code"]=='4507'  or $objResult42["product_code"]=='4504'){ }else{
?>
<tr>
	
<td width="10%" align="left" class="style30"><?php if($objResult15["select_type_doc"]=='1'){ echo $objResult1["customer_code"]; }else if($objResult15["select_type_doc"]=='2'){ echo $objResult1["customer_coden"];  } ?>

</td>
<td  align="left" class="style30"><?php echo $objResult15["iv_no"]; ?></td>
<td  align="left" class="style30"></td> <?php /*echo $objResult["order_id"];*/ ?>
<td  align="left" class="style30"><?php echo '0'; ?></td> 
<td  align="left" class="style30"><?php echo '0'; ?></td> 
<td  align="left" class="style30"><?php if($objResult15["employee_name"]=='(SOL99)'){ echo "SOL99"; }else{ echo $objResult15["employee_name"]; } ?></td> 
<td  align="left" class="style30"><?php echo 'กท'; ?></td>
<td width="10%" align="left" class="style30">

<?php

$date_arr = explode('-' , $objResult15["iv_date"] );
$dd = $date_arr[2];
$mm = $date_arr[1];
$yy5 = $date_arr[0]; //+543
$yy = substr($yy5,2,2);

echo $iv_date = "$dd/$mm/$yy5";

?>
</td>

<td  align="left" class="style30"><?php echo $objResult2["express_code"]; ?></td>
<td  align="left" class="style30"><?php echo $objResult2["sol_name"]; ?></td>
<td  align="left" class="style30"><?php echo $objResult["sale_count"]; ?></td>
<td  align="left" class="style30"><?php echo $objResult2["unit_name"]; ?></td>
<td  align="left" class="style30"><?php echo number_format($objResult42["price_per_unit"],2).""; ?></td>
<td  align="left" class="style30"><?php echo number_format($objResult["discount_unit"],2).""; ?></td>

<td  align="left" class="style30"><?php echo number_format($objResult["sum_amount"],2).""; ?></td>
<td  align="left" class="style30"><?php echo number_format($objResult["sum_amount"]+$objResult["discount_unit"],2).""; ?></td>
<td  align="left" class="style30"><?php echo number_format($objResult4["discount_unit"],2).""; ?></td>
<td  align="left" class="style30"><?php echo number_format($objResult["discount_unit"],2).""; ?></td>
<td  align="left" class="style30"><?php echo ''; ?></td>
<td  align="left" class="style30"><?php echo '7.00'; ?></td>
<td  align="left" class="style30"><?php echo number_format($objResult["sum_amount"]-($objResult["sum_amount"]/1.07),2).""; ?></td>
<td  align="left" class="style30"><?php echo number_format($objResult["sum_amount"],2).""; ?></td>


	</tr>
	
	<?php 
	$i++;
}
}
}
?>
</table>


</body>
</html>