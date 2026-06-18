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
$company = $_GET["company"];
$typee = $_GET["typee"];

include"dbconnect.php";




?>
<body>
	
<?php if($typee=='IC'){ ?>

<center>
<span class="style15">รายงานใบกำกับภาษี IC</span></p>

<span class="style15"><?php echo Datethai($start_date); ?>&nbsp;ถึง&nbsp;<?php echo Datethai($end_date); ?></span><br>


</center>
</p>





</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="10%" align="center" class="style30">เลขที่บิล</td> 
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="20%" align="center" class="style30">ยอดก่อน Vat</td> 
<td width="8%" align="center" class="style30">Vat</td> 
<td width="8%" align="center" class="style30">ยอดรวม</td>

	</tr>

	
<?php
$strSQL = "SELECT ref_id,iv_no,iv_date,ref_id,bill_name  FROM hos__so  where iv_no LIKE '%IC%' and status_doc='Approve'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL .= ' AND type_doc ="'.$company.'"'; 
}
//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");

	while($result1 = mysqli_fetch_array($objQuery)){


$sql3 = "SELECT SUM(amount) As amount  FROM hos__subso  where ref_idd ='".$result1["ref_id"]."' ";
$query3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$result3 = mysqli_fetch_array($query3);


$summary_1=$result3['amount'];
$summary= number_format( $summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";

?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($result1["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $result1["iv_no"]; ?> </td>
<td  align="left" class="style30"><?php echo  $result1["bill_name"]; ?></td> 
<td  align="center" class="style30"><?php echo  $sum_vat; ?></td> 
<td  align="center" class="style30"><?php echo  $vat; ?></td> 
<td  align="center" class="style30"><?php echo  $summary; ?></td> 



	</tr>



<?php } ?>
		
		

</table>

<?php } ?>
	
<?php if($typee=='ET'){ ?>

<center>
<span class="style15">รายงานใบกำกับภาษี ET</span></p>

<span class="style15"><?php echo Datethai($start_date); ?>&nbsp;ถึง&nbsp;<?php echo Datethai($end_date); ?></span><br>


</center>
</p>





</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="10%" align="center" class="style30">เลขที่บิล</td> 
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="20%" align="center" class="style30">ยอดก่อน Vat</td> 
<td width="8%" align="center" class="style30">Vat</td> 
<td width="8%" align="center" class="style30">ยอดรวม</td>

	</tr>





<?php
$strSQL = "SELECT ref_id,doc_no,doc_release_date,ref_id,billing_name  FROM so__main  where doc_no LIKE '%ET%' and cancel_ckk='0'";

if($start_date !=""){ 
    $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; 
}



if($company !=""){ 
    $strSQL .= ' AND select_type_doc ="'.$company.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");

	while($result1 = mysqli_fetch_array($objQuery)){


$sql3 = "SELECT SUM(sum_amount) As sum_amount  FROM so__submain  where ref_idd ='".$result1["ref_id"]."' ";
$query3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$result3 = mysqli_fetch_array($query3);


$summary_1=$result3['sum_amount'];
$summary= number_format( $summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";

?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($result1["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $result1["doc_no"]; ?> </td>
<td  align="left" class="style30"><?php echo  $result1["billing_name"]; ?></td> 
<td  align="center" class="style30"><?php echo  $sum_vat; ?></td> 
<td  align="center" class="style30"><?php echo  $vat; ?></td> 
<td  align="center" class="style30"><?php echo  $summary; ?></td> 



	</tr>



<?php } ?>
	


<?php
$strSQL = "SELECT ref_id,iv_no,iv_date,ref_id,bill_name  FROM hos__so  where iv_no LIKE '%ET%' and status_doc='Approve'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL .= ' AND type_doc ="'.$company.'"'; 
}
//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");

	while($result1 = mysqli_fetch_array($objQuery)){


$sql3 = "SELECT SUM(amount) As amount  FROM hos__subso  where ref_idd ='".$result1["ref_id"]."' ";
$query3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$result3 = mysqli_fetch_array($query3);


$summary_1=$result3['amount'];
$summary= number_format( $summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";

?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($result1["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $result1["iv_no"]; ?> </td>
<td  align="left" class="style30"><?php echo  $result1["bill_name"]; ?></td> 
<td  align="center" class="style30"><?php echo  $sum_vat; ?></td> 
<td  align="center" class="style30"><?php echo  $vat; ?></td> 
<td  align="center" class="style30"><?php echo  $summary; ?></td> 



	</tr>



<?php } ?>
		
	

</table>

<?php }	

 if($typee=='IE'){ ?>

<center>
<span class="style15">รายงานใบกำกับภาษี IE</span></p>

<span class="style15"><?php echo Datethai($start_date); ?>&nbsp;ถึง&nbsp;<?php echo Datethai($end_date); ?></span><br>


</center>
</p>





</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="10%" align="center" class="style30">เลขที่บิล</td> 
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="20%" align="center" class="style30">ยอดก่อน Vat</td> 
<td width="8%" align="center" class="style30">Vat</td> 
<td width="8%" align="center" class="style30">ยอดรวม</td>

	</tr>





<?php
$strSQL = "SELECT ref_id,doc_no,doc_release_date,ref_id,billing_name  FROM so__main  where doc_no LIKE '%IE%' and cancel_ckk='0'";

if($start_date !=""){ 
    $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; 
}



if($company !=""){ 
    $strSQL .= ' AND select_type_doc ="'.$company.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");

	while($result1 = mysqli_fetch_array($objQuery)){


$sql3 = "SELECT SUM(sum_amount) As sum_amount  FROM so__submain  where ref_idd ='".$result1["ref_id"]."' ";
$query3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$result3 = mysqli_fetch_array($query3);


$summary_1=$result3['sum_amount'];
$summary= number_format( $summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";

?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($result1["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $result1["doc_no"]; ?> </td>
<td  align="left" class="style30"><?php echo  $result1["billing_name"]; ?></td> 
<td  align="center" class="style30"><?php echo  $sum_vat; ?></td> 
<td  align="center" class="style30"><?php echo  $vat; ?></td> 
<td  align="center" class="style30"><?php echo  $summary; ?></td> 



	</tr>



<?php } ?>
	
	
<?php
$strSQL = "SELECT ref_id,iv_no,iv_date,ref_id,bill_name  FROM hos__so  where iv_no LIKE '%IE%' and status_doc='Approve'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL .= ' AND type_doc ="'.$company.'"'; 
}
//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");

	while($result1 = mysqli_fetch_array($objQuery)){


$sql3 = "SELECT SUM(amount) As amount  FROM hos__subso  where ref_idd ='".$result1["ref_id"]."' ";
$query3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$result3 = mysqli_fetch_array($query3);


$summary_1=$result3['amount'];
$summary= number_format( $summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";

?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($result1["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $result1["iv_no"]; ?> </td>
<td  align="left" class="style30"><?php echo  $result1["bill_name"]; ?></td> 
<td  align="center" class="style30"><?php echo  $sum_vat; ?></td> 
<td  align="center" class="style30"><?php echo  $vat; ?></td> 
<td  align="center" class="style30"><?php echo  $summary; ?></td> 



	</tr>



<?php } ?>
		
		

</table>

<?php }

if($typee=='AI'){
?>

<br><br>

<center>
<span class="style15">รายงานใบกำกับภาษี AI</span><br>

<span class="style15"><?php echo Datethai($start_date); ?>&nbsp;ถึง&nbsp;<?php echo Datethai($end_date); ?></span><br>


</center>
</p>





</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="10%" align="center" class="style30">เลขที่บิล</td> 
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="20%" align="center" class="style30">ยอดก่อน Vat</td> 
<td width="8%" align="center" class="style30">Vat</td> 
<td width="8%" align="center" class="style30">ยอดรวม</td>

	</tr>





<?php
$strSQL = "SELECT ref_id,doc_no,doc_release_date,ref_id,billing_name  FROM so__main  where doc_no LIKE '%AI%' and cancel_ckk='0'";

if($start_date !=""){ 
    $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; 
}



if($company !=""){ 
    $strSQL .= ' AND select_type_doc ="'.$company.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");

	while($result1 = mysqli_fetch_array($objQuery)){


$sql3 = "SELECT SUM(sum_amount) As sum_amount  FROM so__submain  where ref_idd ='".$result1["ref_id"]."' ";
$query3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$result3 = mysqli_fetch_array($query3);


$summary_1=$result3['sum_amount'];
$summary= number_format( $summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";

?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($result1["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $result1["doc_no"]; ?> </td>
<td  align="left" class="style30"><?php echo  $result1["billing_name"]; ?></td> 
<td  align="center" class="style30"><?php echo  $sum_vat; ?></td> 
<td  align="center" class="style30"><?php echo  $vat; ?></td> 
<td  align="center" class="style30"><?php echo  $summary; ?></td> 



	</tr>



<?php } ?>
	
<?php
$strSQL = "SELECT ref_id,iv_no,iv_date,ref_id,bill_name  FROM hos__so  where iv_no LIKE '%AI%' and status_doc ='Approve'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}



if($company !=""){ 
    $strSQL .= ' AND type_doc ="'.$company.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");

	while($result1 = mysqli_fetch_array($objQuery)){


$sql3 = "SELECT SUM(amount) As amount  FROM hos__subso  where ref_idd ='".$result1["ref_id"]."' ";
$query3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$result3 = mysqli_fetch_array($query3);


$summary_1=$result3['amount'];
$summary= number_format( $summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";

?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($result1["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $result1["iv_no"]; ?> </td>
<td  align="left" class="style30"><?php echo  $result1["bill_name"]; ?></td> 
<td  align="center" class="style30"><?php echo  $sum_vat; ?></td> 
<td  align="center" class="style30"><?php echo  $vat; ?></td> 
<td  align="center" class="style30"><?php echo  $summary; ?></td> 



	</tr>



<?php } ?>
			
</table>




<br><br>
<?php 
				 
				}
				 if($typee=='IV'){  ?>
<center>
<span class="style15">รายงานใบกำกับภาษี IV</span></p>

<span class="style15"><?php echo Datethai($start_date); ?>&nbsp;ถึง&nbsp;<?php echo Datethai($end_date); ?></span><br>


</center>
</p>





</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="10%" align="center" class="style30">เลขที่บิล</td> 
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="20%" align="center" class="style30">ยอดก่อน Vat</td> 
<td width="8%" align="center" class="style30">Vat</td> 
<td width="8%" align="center" class="style30">ยอดรวม</td>
</tr>





<?php
$strSQL = "SELECT ref_id,doc_no,doc_release_date,ref_id,billing_name  FROM so__main  where doc_no LIKE '%IV%' and cancel_ckk='0'";

if($start_date !=""){ 
    $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; 
}



if($company !=""){ 
    $strSQL .= ' AND select_type_doc ="'.$company.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");

	while($result1 = mysqli_fetch_array($objQuery)){


$sql3 = "SELECT SUM(sum_amount) As sum_amount  FROM so__submain  where ref_idd ='".$result1["ref_id"]."' ";
$query3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$result3 = mysqli_fetch_array($query3);


$summary_1=$result3['sum_amount'];
$summary= number_format( $summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";

?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($result1["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $result1["doc_no"]; ?> </td>
<td  align="left" class="style30"><?php echo  $result1["billing_name"]; ?></td> 
<td  align="center" class="style30"><?php echo  $sum_vat; ?></td> 
<td  align="center" class="style30"><?php echo  $vat; ?></td> 
<td  align="center" class="style30"><?php echo  $summary; ?></td> 



	</tr>



<?php } ?>
	
	
<?php
$strSQL = "SELECT DISTINCT iv_no,iv_date,sale_channel,select_type_doc  FROM so__main  where iv_no LIKE '%IV%' and cancel_ckk='0'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

if($company =="3"){ 
    $strSQL .= ' AND select_type_doc ="1"'; 
}else if($company =="4"){
	
 $strSQL .= ' AND select_type_doc ="2"'; 	
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
while($result1 = mysqli_fetch_array($objQuery)){


$sql3 = "SELECT SUM(sum_amount) As sum_amount  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)  where iv_date ='".$result1["iv_date"]."' and iv_no ='".$result1["iv_no"]."' and select_type_doc ='".$result1["select_type_doc"]."' and cancel_ckk='0'";
$query3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$result3 = mysqli_fetch_array($query3);

		
$sql5 = "SELECT salechannel_name  FROM tb_salechannel where salechannel_ID  ='".$result1["sale_channel"]."'";
$query5 = mysqli_query($conn,$sql5) or die(mysqli_error());
$result5 = mysqli_fetch_array($query5);		
		

$summary_1=$result3['sum_amount'];
$summary= number_format( $summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";

?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($result1["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $result1["iv_no"]; ?> </td>
<td  align="left" class="style30"><?php echo  $result5["salechannel_name"]; ?></td> 
<td  align="center" class="style30"><?php echo  $sum_vat; ?></td> 
<td  align="center" class="style30"><?php echo  $vat; ?></td> 
<td  align="center" class="style30"><?php echo  $summary; ?></td> 



	</tr>



<?php } ?>
		
	

<?php
$strSQL = "SELECT ref_id,iv_no,iv_date,ref_id,bill_name  FROM hos__so  where iv_no LIKE '%IV%' and status_doc ='Approve'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}



if($company !=""){ 
    $strSQL .= ' AND type_doc ="'.$company.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");

	while($result1 = mysqli_fetch_array($objQuery)){


$sql3 = "SELECT SUM(amount) As amount  FROM hos__subso  where ref_idd ='".$result1["ref_id"]."' ";
$query3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$result3 = mysqli_fetch_array($query3);


$summary_1=$result3['amount'];
$summary= number_format( $summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";

?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($result1["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $result1["iv_no"]; ?> </td>
<td  align="left" class="style30"><?php echo  $result1["bill_name"]; ?></td> 
<td  align="center" class="style30"><?php echo  $sum_vat; ?></td> 
<td  align="center" class="style30"><?php echo  $vat; ?></td> 
<td  align="center" class="style30"><?php echo  $summary; ?></td> 



	</tr>



<?php } ?>
		
	

</table>

<?php } ?>


<?php if($typee=='SR'){ ?>

<center>
<span class="style15">รายงานใบลดหนี้</span><br>

<span class="style15"><?php echo Datethai($start_date); ?>&nbsp;ถึง&nbsp;<?php echo Datethai($end_date); ?></span><br>


</center>
</p>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="10%" align="center" class="style30">เลขที่ลดหนี้</td> 
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="20%" align="center" class="style30">ยอดก่อน Vat</td> 
<td width="8%" align="center" class="style30">Vat</td> 
<td width="8%" align="center" class="style30">ยอดรวม</td>
</tr>





<?php
$strSQL = "SELECT * FROM tb_credit_note  where status_doc='Approve' and credit_no!=''";

if($start_date !=""){ 
    $strSQL .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_credit <= "'.$end_date.'"'; 
}



if($company !=""){ 
    $strSQL .= ' AND company_type ="'.$company.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
while($result1 = mysqli_fetch_array($objQuery)){


$sql3 = "SELECT SUM(sum_amount) As sum_amount  FROM tb_subcredit  where ref_creditt ='".$result1["ref_credit"]."' ";
$query3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$result3 = mysqli_fetch_array($query3);


$summary_1=$result3['sum_amount'];
$summary= number_format( $summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";

?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($result1["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $result1["credit_no"]; ?> </td>
<td  align="left" class="style30"><?php echo  $result1["customer_name"]; ?></td> 
<td  align="center" class="style30"><?php echo  $sum_vat; ?></td> 
<td  align="center" class="style30"><?php echo  $vat; ?></td> 
<td  align="center" class="style30"><?php echo  $summary; ?></td> 



	</tr>



<?php } ?>
</table>	

<?php } ?>

<br>
<br>








</p>
</body>
</html>