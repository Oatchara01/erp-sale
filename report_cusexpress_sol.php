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



</style>



<?php



/*date_default_timezone_set("Asia/Bangkok");
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}*/

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
	<td width="10%" align="center" class="style30">CUST_ID</td>
	<td width="10%" align="center" class="style30">REFID</td>
	<?php } ?>
<td width="10%" align="center" class="style30">CUSTID</td>
<td width="5%" align="center" class="style30">PRENAM</td>
<td width="10%" align="center" class="style30">CUSNAM</td> 
<td width="10%" align="center" class="style30">ADDR01</td> 
<td width="10%" align="center" class="style30">ADDR02</td> 
<td width="10%" align="center" class="style30">ADDR03</td> 
<td width="5%" align="center" class="style30">ZIPCOD</td>
<td width="10%" align="center" class="style30">TELNUM</td>
<td width="10%" align="center" class="style30">TAXID</td>
<td width="2%" align="center" class="style30">BR</td>
<td width="5%" align="center" class="style30">CUSTYP</td>
<td width="10%" align="center" class="style30">ACCNUM</td>
<td width="8%" align="center" class="style30">SALEID</td>
<td width="5%" align="center" class="style30">AREAID</td>

	</tr>

<?php

$strSQL = "SELECT ref_id,bill_id,billing_name,select_type_doc,ex_add,ex_aumper,ex_provin,ex_post,billing_tel,pre_name,tax_id,employee_name   FROM so__main  where cancel_ckk='0' and approve_complete ='Approve' and doc_no NOT LIKE '%AI%'  and doc_no NOT LIKE '%AR%' ";


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

$strSQL1 = "SELECT customer_code,customer_coden,preface_name,sale_code FROM tb_customer WHERE customer_id = '".$objResult["bill_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$objResult1 = mysqli_fetch_array($objQuery1);

?>
<tr>
	<?php if($_SESSION['name']=='พัชร์ชนัญ'){ ?>
	<td  align="left" class="style30"><?php echo $objResult["bill_id"]; ?></td> 
	<td  align="left" class="style30"><?php echo $objResult["ref_id"]; ?></td> 
	<?php } ?>

<td width="10%" align="left" class="style30"><?php if($objResult["select_type_doc"]=='3'){ echo $objResult1["customer_code"]; }else if($objResult["select_type_doc"]=='4'){ echo $objResult1["customer_coden"];  } ?>

</td>
<td  align="left" class="style30"><?php echo $objResult["pre_name"]; ?></td>
<td  align="left" class="style30"><?php echo $objResult["billing_name"]; ?></td> 
<td  align="left" class="style30"><?php echo $objResult["ex_add"]; ?></td> 
<td  align="left" class="style30"><?php echo $objResult["ex_aumper"]; ?></td> 
<td  align="left" class="style30"><?php echo $objResult["ex_provin"]; ?></td> 
<td  align="left" class="style30"><?php echo $objResult["ex_post"]; ?></td>
<td  align="left" class="style30">'<?php echo $objResult["billing_tel"]; ?></td>
<td width="10%" align="left" class="style30">
'<?php if($objResult["tax_id"] !=''){ echo $objResult["tax_id"]; }else{ echo "0000000000000"; } ?>
</td>
<td  align="left" class="style30"><?php echo '0'; ?></td>
<td  align="left" class="style30"><?php echo 'EC'; ?></td>
<td  align="left" class="style30"><?php if($company =='3'){ echo '1130-01-00'; }else if($company =='4'){ echo '1130-01';  } ?></td>
<td  align="left" class="style30"><?php if($objResult["employee_name"]=='SOL99'){ echo "SOL99"; }else{ echo $objResult["employee_name"]; } ?></td>
<td  align="left" class="style30"><?php echo 'กท'; ?></td>


	</tr>
	
	<?php 
}
?>
</table>


</body>
</html>