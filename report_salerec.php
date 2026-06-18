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


include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorHTML.php";
include "src/BarcodeGeneratorPNG.php";


function barcode($code){
    
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $border = 0.5;//กำหนดความหน้าของเส้น Barcode
    $height = 15;//กำหนดความสูงของ Barcode
 
    return $generator->getBarcode($code , $generator::TYPE_CODE_128,$border,$height);
 
}
 

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
$sale_code = $_GET["sale_code"];
$str_arr = $_GET["company"]; 
$company = substr($str_arr, 0,1);
$company1 = substr($str_arr,-1);
$no_sale = $_GET["no_sale"]; 
//echo $company1;

include"dbconnect.php";
include"dbconnect_sale.php";



?>
<body>

<?php 
if($company =='3'){
$company_name = "บริษัท ออลล์เวล ไลฟ์ จำกัด";

}else if($company =='4'){
$company_name = "บริษัท โนเบิล เมด จำกัด";

}else{
$company_name = "";
}


$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;



?>

<center>
<span class="style15">Monthly Sales Record</span></p>

<span class="style15"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></span><br>


<span class="style15"><?php echo $company_name ; ?></span>
</center>
</p>





<?php
if($no_sale=='1'){ ?>
	
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="10%" align="center" class="style30">ช่องทางการขาย</td>
<td width="10%" align="center" class="style30">ID ลูกค้า</td>	
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">เขตการขาย</td> 
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 


	</tr>
	
<?php

	$strSQL5 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and ic_ckk='0' and sale_code =''";

if($start_date !=""){ 
    $strSQL5 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL5 .= ' AND type_doc = "'.$company.'"'; 
}




$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");

while($objResult5 = mysqli_fetch_array($objQuery5))
{

	$strSQL15 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and ic_ckk='0'  and sale_code =''";

if($start_date !=""){ 
    $strSQL15 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL15 .= ' AND type_doc = "'.$company.'"'; 
}



$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");

while($objResult15 = mysqli_fetch_array($objQuery15)){


$total15=$objResult15['total1'];
$total5=$objResult5['total'];
$total1=$total15+$total5;

$total= number_format( $total1,2)."";

$no_vat_to1 = ($total1 / 1.07); 
$no_vat_to = number_format( $no_vat_to1,2)."";

	

$strSQL1 ="SELECT  iv_no,iv_date,bill_name,ref_id,bill_id,sale_code FROM hos__so WHERE status_doc ='Approve' and have_order = '0' and ic_ckk='0'  and sale_code =''";


if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL1 .= ' AND type_doc = "'.$company.'"'; 
}



$strSQL1 .=" order  by iv_no ASC  ";


$objQuery1 =mysqli_query($conn,$strSQL1);
while($objResult1=mysqli_fetch_array($objQuery1)){

$strSQL2 ="SELECT product_id,count,amount  FROM hos__subso  WHERE ref_idd = '".$objResult1["ref_id"]."'  ";

$objQuery2 =mysqli_query($conn,$strSQL2);
while($objResult2=mysqli_fetch_array($objQuery2)){



$strSQL3 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult2["product_id"]."'  ";

$objQuery3 =mysqli_query($conn,$strSQL3);
while($objResult3=mysqli_fetch_array($objQuery3)){


$summary_1=$objResult2['amount'];
$summary= number_format( $summary_1,2)."";

$no_vat1 = ($summary_1 / 1.07); 
$no_vat = number_format( $no_vat1,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult1["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult1["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["iv_no"]; ?></span></a></td>
	<td  align="left" class="style30"><?php  ?></td> 
<td  align="left" class="style30"><?php echo  $objResult1["bill_id"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult1["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult1["sale_code"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult3["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult2["count"];  ?>&nbsp;<?php echo $objResult3["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat; ?></td> 

	</tr>




	<?php
}
}
}


$strSQL61 ="SELECT  iv_no,iv_date,bill_name,bill_tel,ref_id,bill_id,sale_code FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and ic_ckk='0'  and sale_code =''";


if($start_date !=""){ 
    $strSQL61 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL61 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL61 .= ' AND type_doc = "'.$company.'"'; 
}



$strSQL61 .=" order  by iv_no ASC  ";


$objQuery61 =mysqli_query($conn,$strSQL61);
while($objResult61=mysqli_fetch_array($objQuery61)){

$strSQL62 ="SELECT product_id,count,amount  FROM hos__subso  WHERE ref_idd = '".$objResult61["ref_id"]."'  ";

$objQuery62 =mysqli_query($conn,$strSQL62);
while($objResult62=mysqli_fetch_array($objQuery62)){



$strSQL63 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult62["product_id"]."'  ";

$objQuery63 =mysqli_query($conn,$strSQL63);
while($objResult63=mysqli_fetch_array($objQuery63)){


$summary_61=$objResult62['amount'];
$summary6= number_format( $summary_61,2)."";

$no_vat61 = ($summary_61 / 1.07); 
$no_vat6 = number_format( $no_vat61,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult61["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult61["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult61["iv_no"]; ?></span></a></td>
	<td  align="left" class="style30"><?php  ?></td> 
<td  align="left" class="style30"><?php echo  $objResult61["bill_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult61["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult61["sale_code"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult63["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult62["count"];  ?>&nbsp;<?php echo $objResult63["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary6; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat6; ?></td> 

	</tr>




	<?
}
}
}


?>

</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_name ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to; ?></td> 

	</tr>
</table>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">เขตการขาย</td> 	
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 


	</tr>
	<?php
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit,bill_id,sale_code FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve' and sale_code =''";


if($start_date !=""){ 
    $strSQL211 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL211 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL211 .= ' AND company_type = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL211 .= ' AND sale_code = "'.$sale_code.'"'; 
}


$strSQL211 .=" order  by credit_no ASC  ";


$objQuery211 =mysqli_query($conn,$strSQL211);
while($objResult211=mysqli_fetch_array($objQuery211)){

$strSQL222 ="SELECT product_id,count,sum_amount  FROM tb_subcredit  WHERE ref_creditt = '".$objResult211["ref_credit"]."'  ";

$objQuery222 = mysqli_query($conn,$strSQL222);
while($objResult222 = mysqli_fetch_array($objQuery222)){



$strSQL233 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult222["product_id"]."'  ";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){


$summary_22=$objResult222['sum_amount'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat22 = number_format( $no_vat22,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult211["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult211["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult211["bill_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult211["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult211["sale_code"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult233["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult222["count"];  ?>&nbsp;<?php echo $objResult233["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary22; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat22; ?></td> 

	</tr>




	<?php
}
}
}

?>
</table>

<?php
		
$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code =''";

if($start_date !=""){ 
    $strSQL151 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL151 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL151 .= ' AND company_type = "'.$company.'"'; 
}


$objQuery151 = mysqli_query($conn,$strSQL151) or die ("Error Query [".$strSQL151."]");
$objResult151 = mysqli_fetch_array($objQuery151);

$total22=$objResult151['total15'];
$total2= number_format( $total22,2)."";

$no_vat_to12 = ($total22 / 1.07); 
$no_vat_to2 = number_format( $no_vat_to12,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php
 
$creditno_vat1 = $no_vat_to1-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total1-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>
<?php }
}

?>
	
<?php	
}else if ($sale_code !=''){


$strSQL555 = "SELECT * FROM tb_team_adm where sale_code='".$sale_code."' ";
$objQuery555 = mysqli_query($com,$strSQL555);
$objResuut555 = mysqli_fetch_array($objQuery555);

$sale_name = $objResuut555["sale_name"];

?>

</p>
	<center>
<span class="style16"><?php echo $sale_name ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $sale_code ;  ?></span>
</center> 
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="10%" align="center" class="style30">ช่องทางการขาย</td>
<td width="10%" align="center" class="style30">ID ลูกค้า</td>	
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 


	</tr>


<?php

	if($sale_code =='SOL99' or $sale_code =='SOL2' or $sale_code =='SOL91' or $sale_code =='SOL92' or $sale_code =='SOL93' or $sale_code =='SOL94' or $sale_code =='SOL1' or $sale_code =='SOL3' or $sale_code =='SOL4' or $sale_code =='SOL5'){


$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no !='' and cancel_ckk = '0' and approve_complete = 'Approve'";

if($start_date !=""){ 
    $strSQL5 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL5 .= ' AND select_type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL5 .= ' AND employee_name = "'.$sale_code.'"'; 
}

$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL15 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk = '0' and approve_complete = 'Approve'";

if($start_date !=""){ 
    $strSQL15 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL15 .= ' AND select_type_doc = "'.$company1.'"'; 
}

if($sale_code !=""){ 
    $strSQL15 .= ' AND employee_name = "'.$sale_code.'"'; 
}


$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);

$total1=$objResult5['total'];
$total2=$objResult15['total1'];
$total3 = $total1+$total2;

$total= number_format( $total3,2)."";

$no_vat_to1 = ($total3 / 1.07); 
$no_vat_to = number_format( $no_vat_to1,2)."";




$strSQL11 ="SELECT  doc_no,doc_release_date,customer_name,ref_id,sale_channel,bill_id,employee_name FROM so__main WHERE doc_no !=''  and  cancel_ckk = '0' and approve_complete = 'Approve'";


if($start_date !=""){ 
    $strSQL11 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL11 .= ' AND select_type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL11 .= ' AND employee_name = "'.$sale_code.'"'; 
}

		
$strSQL11 .=" order  by doc_no ASC  ";


$objQuery11 =mysqli_query($conn,$strSQL11);
while($objResult11=mysqli_fetch_array($objQuery11)){

$strSQL12 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult11["ref_id"]."'  ";

$objQuery12 =mysqli_query($conn,$strSQL12);
while($objResult12=mysqli_fetch_array($objQuery12)){



$strSQL13 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult12["product_id"]."'  ";

$objQuery13 =mysqli_query($conn,$strSQL13);
while($objResult13=mysqli_fetch_array($objQuery13)){

	
$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult11["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);

$summary_1=$objResult12['sum_amount'];
$summary= number_format( $summary_1,2)."";

$no_vat1 = ($summary_1 / 1.07); 
$no_vat = number_format( $no_vat1,2)."";


	
?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult11["doc_release_date"]); ?></td>
<td  align="center" class="style30"><a href="register_admin_edit.php?ref_id=<?php echo $objResult11["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult11["doc_no"]; ?></span></a></td>
<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult11["bill_id"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult11["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult11["employee_name"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult13["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult12["sale_count"];  ?>&nbsp;<?php echo $objResult13["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat; ?></td> 

	</tr>




	<?php
}
}
}






$strSQL21 ="SELECT  iv_no,iv_date,customer_name,ref_id,doc_no,sale_channel,bill_id,employee_name FROM so__main WHERE iv_no !='' and cancel_ckk = '0' and approve_complete = 'Approve'";


if($start_date !=""){ 
    $strSQL21 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL21 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL21 .= ' AND select_type_doc = "'.$company1.'"'; 
}

if($sale_code !=""){ 
    $strSQL21 .= ' AND employee_name = "'.$sale_code.'"'; 
}

$strSQL21 .=" order  by iv_no ASC  ";


$objQuery21 =mysqli_query($conn,$strSQL21);
while($objResult21=mysqli_fetch_array($objQuery21)){

$strSQL22 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult21["ref_id"]."'  ";

$objQuery22 =mysqli_query($conn,$strSQL22);
while($objResult22=mysqli_fetch_array($objQuery22)){



$strSQL23 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult22["product_id"]."'  ";

$objQuery23 =mysqli_query($conn,$strSQL23);
while($objResult23=mysqli_fetch_array($objQuery23)){

	
$strSQL24 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult21["sale_channel"]."'  ";

$objQuery24 =mysqli_query($conn,$strSQL24);
$objResult24=mysqli_fetch_array($objQuery24);

$summary_2=$objResult22['sum_amount'];
$summary2= number_format( $summary_2,2)."";

$no_vat2 = ($summary_2 / 1.07); 
$no_vat2 = number_format( $no_vat2,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult21["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_admin_edit.php?ref_id=<?php echo $objResult21["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult21["iv_no"]; ?></span></a></td>
<td  align="left" class="style30"><?php echo  $objResult24["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult21["bill_id"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult21["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult21["employee_name"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult23["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult22["sale_count"];  ?>&nbsp;<?php echo $objResult23["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary2; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat2; ?></td> 

	</tr>




	<?php
}
}
}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to; ?></td> 

	</tr>
</table>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="10%" align="center" class="style30">ID ลูกค้า</td>	
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">เขตการขาย</td> 	
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 


	</tr>
	<?php
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit,sale_code FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve'";


if($start_date !=""){ 
    $strSQL211 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL211 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL211 .= ' AND company_type = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL211 .= ' AND sale_code = "'.$sale_code.'"'; 
}


$strSQL211 .=" order  by credit_no ASC  ";


$objQuery211 =mysqli_query($conn,$strSQL211);
while($objResult211=mysqli_fetch_array($objQuery211)){

$strSQL222 ="SELECT product_id,count,sum_amount  FROM tb_subcredit  WHERE ref_creditt = '".$objResult211["ref_credit"]."'  ";

$objQuery222 = mysqli_query($conn,$strSQL222);
while($objResult222 = mysqli_fetch_array($objQuery222)){



$strSQL233 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult222["product_id"]."'  ";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){


$summary_22=$objResult222['sum_amount'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat22 = number_format( $no_vat22,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult211["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult211["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult211["bill_id"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult211["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult211["sale_code"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult233["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult222["count"];  ?>&nbsp;<?php echo $objResult233["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary22; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat22; ?></td> 

	</tr>




	<?php
}
}
}

?>
</table>

<?php
		
$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'";

if($start_date !=""){ 
    $strSQL151 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL151 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL151 .= ' AND company_type = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL151 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery151 = mysqli_query($conn,$strSQL151) or die ("Error Query [".$strSQL151."]");
$objResult151 = mysqli_fetch_array($objQuery151);

$total22=$objResult151['total15'];
$total2= number_format( $total22,2)."";

$no_vat_to12 = ($total22 / 1.07); 
$no_vat_to2 = number_format( $no_vat_to12,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php
 
$creditno_vat1 = $no_vat_to1-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total3-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>

<?php
	}else{
if($sale_channel==''){		
		
	$strSQL5 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and ic_ckk='0' ";

if($start_date !=""){ 
    $strSQL5 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL5 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL5 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL5 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}


$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");

while($objResult5 = mysqli_fetch_array($objQuery5))
{

	$strSQL15 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and ic_ckk='0' ";

if($start_date !=""){ 
    $strSQL15 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL15 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL15 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL15 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}


$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");

while($objResult15 = mysqli_fetch_array($objQuery15)){


$total15=$objResult15['total1'];
$total5=$objResult5['total'];
$total1=$total15+$total5;

$total= number_format( $total1,2)."";

$no_vat_to1 = ($total1 / 1.07); 
$no_vat_to = number_format( $no_vat_to1,2)."";

	

$strSQL1 ="SELECT  iv_no,iv_date,bill_name,ref_id,bill_id,sale_code FROM hos__so WHERE status_doc ='Approve' and have_order = '0' and ic_ckk='0' ";


if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL1 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL1 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}


$strSQL1 .=" order  by iv_no ASC  ";


$objQuery1 =mysqli_query($conn,$strSQL1);
while($objResult1=mysqli_fetch_array($objQuery1)){

$strSQL2 ="SELECT product_id,count,amount  FROM hos__subso  WHERE ref_idd = '".$objResult1["ref_id"]."'  ";

$objQuery2 =mysqli_query($conn,$strSQL2);
while($objResult2=mysqli_fetch_array($objQuery2)){



$strSQL3 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult2["product_id"]."'  ";

$objQuery3 =mysqli_query($conn,$strSQL3);
while($objResult3=mysqli_fetch_array($objQuery3)){


$summary_1=$objResult2['amount'];
$summary= number_format( $summary_1,2)."";

$no_vat1 = ($summary_1 / 1.07); 
$no_vat = number_format( $no_vat1,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult1["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult1["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["iv_no"]; ?></span></a></td>
	<td  align="left" class="style30"><?php  ?></td> 
<td  align="left" class="style30"><?php echo  $objResult1["bill_id"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult1["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult1["sale_code"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult3["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult2["count"];  ?>&nbsp;<?php echo $objResult3["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat; ?></td> 

	</tr>




	<?php
}
}
}


$strSQL61 ="SELECT  iv_no,iv_date,bill_name,bill_tel,ref_id,bill_id,sale_code FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and ic_ckk='0' ";


if($start_date !=""){ 
    $strSQL61 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL61 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL61 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL61 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL61 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}


$strSQL61 .=" order  by iv_no ASC  ";


$objQuery61 =mysqli_query($conn,$strSQL61);
while($objResult61=mysqli_fetch_array($objQuery61)){

$strSQL62 ="SELECT product_id,count,amount  FROM hos__subso  WHERE ref_idd = '".$objResult61["ref_id"]."'  ";

$objQuery62 =mysqli_query($conn,$strSQL62);
while($objResult62=mysqli_fetch_array($objQuery62)){



$strSQL63 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult62["product_id"]."'  ";

$objQuery63 =mysqli_query($conn,$strSQL63);
while($objResult63=mysqli_fetch_array($objQuery63)){


$summary_61=$objResult62['amount'];
$summary6= number_format( $summary_61,2)."";

$no_vat61 = ($summary_61 / 1.07); 
$no_vat6 = number_format( $no_vat61,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult61["iv_date"]); ?></td>
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult61["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult61["iv_no"]; ?></span></a></td>
	<td  align="left" class="style30"><?php  ?></td> 
<td  align="left" class="style30"><?php echo  $objResult61["bill_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult61["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult61["sale_code"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult63["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult62["count"];  ?>&nbsp;<?php echo $objResult63["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary6; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat6; ?></td> 

	</tr>




	<?
}
}
}


?>

</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_name ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to; ?></td> 

	</tr>
</table>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">เขตการขาย</td> 	
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 


	</tr>
	<?php
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit,bill_id,sale_code FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve'";


if($start_date !=""){ 
    $strSQL211 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL211 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL211 .= ' AND company_type = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL211 .= ' AND sale_code = "'.$sale_code.'"'; 
}


$strSQL211 .=" order  by credit_no ASC  ";


$objQuery211 =mysqli_query($conn,$strSQL211);
while($objResult211=mysqli_fetch_array($objQuery211)){

$strSQL222 ="SELECT product_id,count,sum_amount  FROM tb_subcredit  WHERE ref_creditt = '".$objResult211["ref_credit"]."'  ";

$objQuery222 = mysqli_query($conn,$strSQL222);
while($objResult222 = mysqli_fetch_array($objQuery222)){



$strSQL233 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult222["product_id"]."'  ";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){


$summary_22=$objResult222['sum_amount'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat22 = number_format( $no_vat22,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult211["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult211["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult211["bill_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult211["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult211["sale_code"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult233["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult222["count"];  ?>&nbsp;<?php echo $objResult233["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary22; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat22; ?></td> 

	</tr>




	<?php
}
}
}

?>
</table>

<?php
		
$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'";

if($start_date !=""){ 
    $strSQL151 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL151 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL151 .= ' AND company_type = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL151 .= ' AND sale_code = "'.$sale_code.'"'; 
}

$objQuery151 = mysqli_query($conn,$strSQL151) or die ("Error Query [".$strSQL151."]");
$objResult151 = mysqli_fetch_array($objQuery151);

$total22=$objResult151['total15'];
$total2= number_format( $total22,2)."";

$no_vat_to12 = ($total22 / 1.07); 
$no_vat_to2 = number_format( $no_vat_to12,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php
 
$creditno_vat1 = $no_vat_to1-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total1-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>

	<?
}
}
	}
}

	
	



}else{

	if($sale_channel==''){

$strSQL ="SELECT * FROM tb_team_adm where ckk ='0'";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$sale_code1 = $objResult["sale_code"];
$sale_name = $objResult["sale_name"];
	
?>
	</p>
	<center>
<span class="style16"><?php echo $sale_name ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $sale_code1 ;  ?></span>
</center> 
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="10%" align="center" class="style30">ID ลูกค้า</td>
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">เขตการขาย</td> 	
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>





<?php

	$strSQL5 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and ic_ckk='0' ";

if($start_date !=""){ 
    $strSQL5 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL5 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL5 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL5 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}


$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");

while($objResult5 = mysqli_fetch_array($objQuery5))
{


	$strSQL15 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and ic_ckk='0' ";

if($start_date !=""){ 
    $strSQL15 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL15 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL15 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL15 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}


$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");

while($objResult15 = mysqli_fetch_array($objQuery15)){


$total15=$objResult15['total1'];
$total5=$objResult5['total'];
$total1=$total15+$total5;

$total= number_format( $total1,2)."";

$no_vat_to1 = ($total1 / 1.07); 
$no_vat_to = number_format( $no_vat_to1,2)."";




$strSQL1 ="SELECT  iv_no,iv_date,bill_name,bill_tel,ref_id,bill_id,sale_code FROM hos__so WHERE status_doc ='Approve' and have_order = '0' and ic_ckk='0' ";


if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL1 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL1 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}


$strSQL1 .=" order  by iv_no ASC  ";


$objQuery1 =mysqli_query($conn,$strSQL1);
while($objResult1=mysqli_fetch_array($objQuery1)){

$strSQL2 ="SELECT product_id,count,amount  FROM hos__subso  WHERE ref_idd = '".$objResult1["ref_id"]."'  ";

$objQuery2 =mysqli_query($conn,$strSQL2);
while($objResult2=mysqli_fetch_array($objQuery2)){



$strSQL3 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult2["product_id"]."'  ";

$objQuery3 =mysqli_query($conn,$strSQL3);
while($objResult3=mysqli_fetch_array($objQuery3)){


$summary_1=$objResult2['amount'];
$summary= number_format( $summary_1,2)."";

$no_vat1 = ($summary_1 / 1.07); 
$no_vat = number_format( $no_vat1,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult1["iv_date"]); ?></td>
<td  align="left" class="style30"><?php echo  $objResult1["ref_id"]; ?></td>
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult1["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["iv_no"]; ?></span></a></td>
<td  align="left" class="style30"><?php echo  $objResult1["bill_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult1["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult1["sale_code"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult3["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult2["count"];  ?>&nbsp;<?php echo $objResult3["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat; ?></td> 

	</tr>




	<?
}
}
}






$strSQL61 ="SELECT  iv_no,iv_date,bill_name,bill_tel,ref_id,bill_id,sale_code FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and ic_ckk='0' ";


if($start_date !=""){ 
    $strSQL61 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL61 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL61 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL61 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL61 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}


$strSQL61 .=" order  by iv_no ASC  ";


$objQuery61 =mysqli_query($conn,$strSQL61);
while($objResult61=mysqli_fetch_array($objQuery61)){

$strSQL62 ="SELECT product_id,count,amount  FROM hos__subso  WHERE ref_idd = '".$objResult61["ref_id"]."'  ";

$objQuery62 =mysqli_query($conn,$strSQL62);
while($objResult62=mysqli_fetch_array($objQuery62)){



$strSQL63 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult62["product_id"]."'  ";

$objQuery63 =mysqli_query($conn,$strSQL63);
while($objResult63=mysqli_fetch_array($objQuery63)){


$summary_61=$objResult62['amount'];
$summary6= number_format( $summary_61,2)."";

$no_vat61 = ($summary_61 / 1.07); 
$no_vat6 = number_format( $no_vat61,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult61["iv_date"]); ?></td>
<td  align="left" class="style30"><?php echo  $objResult61["ref_id"]; ?></td> 
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult61["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult61["iv_no"]; ?></span></a></td>
<td  align="left" class="style30"><?php echo  $objResult61["bill_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult61["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult61["sale_code"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult63["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult62["count"];  ?>&nbsp;<?php echo $objResult63["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary6; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat6; ?></td> 

	</tr>




	<?
}
}
}


?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_name ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to; ?></td> 

	</tr>
</table>


	<?
}
}
	?>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ID ลูกค้า</td> 	
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">เขตการขาย</td> 	
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 


	</tr>
	<?php
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit,bill_id,sale_code FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve'";


if($start_date !=""){ 
    $strSQL211 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL211 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL211 .= ' AND company_type = "'.$company.'"'; 
}
	
$strSQL211 .= ' AND sale_code = "'.$sale_code1.'"'; 
$strSQL211 .=" order  by credit_no ASC  ";


$objQuery211 =mysqli_query($conn,$strSQL211);
while($objResult211=mysqli_fetch_array($objQuery211)){

$strSQL222 ="SELECT product_id,count,sum_amount  FROM tb_subcredit  WHERE ref_creditt = '".$objResult211["ref_credit"]."'  ";

$objQuery222 = mysqli_query($conn,$strSQL222);
while($objResult222 = mysqli_fetch_array($objQuery222)){



$strSQL233 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult222["product_id"]."'  ";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){


$summary_22=$objResult222['sum_amount'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat22 = number_format( $no_vat22,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult211["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult211["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult211["bill_id"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult211["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult211["sale_code"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult233["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult222["count"];  ?>&nbsp;<?php echo $objResult233["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary22; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat22; ?></td> 

	</tr>




	<?php
}
}
}

?>
</table>

<?php
		
$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'";

if($start_date !=""){ 
    $strSQL151 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL151 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL151 .= ' AND company_type = "'.$company.'"'; 
}

$strSQL151 .= ' AND sale_code = "'.$sale_code1.'"'; 
$objQuery151 = mysqli_query($conn,$strSQL151) or die ("Error Query [".$strSQL151."]");
$objResult151 = mysqli_fetch_array($objQuery151);

$total22=$objResult151['total15'];
$total2= number_format( $total22,2)."";

$no_vat_to12 = ($total22 / 1.07); 
$no_vat_to2 = number_format( $no_vat_to12,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php
 
$creditno_vat1 = $no_vat_to1-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total1-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>

<?php
}
	}
?>


</p>

<center>
<span class="style16"><?php echo "ช่าง" ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo "ช่าง" ;  ?></span>
</center> 
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">เขตการขาย</td> 	
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>





<?php

	$strSQL5 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code LIKE '%EN%' and ic_ckk='0'";

if($start_date !=""){ 
    $strSQL5 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL5 .= ' AND type_doc = "'.$company.'"'; 
}



$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");

while($objResult5 = mysqli_fetch_array($objQuery5))
{


	$strSQL15 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2'  and sale_code LIKE '%EN%'  and ic_ckk='0'";

if($start_date !=""){ 
    $strSQL15 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL15 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL15 .= ' AND type_doc = "'.$company.'"'; 
}

/*if($sale_code !=""){ 
    $strSQL15 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL15 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}*/


$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");

while($objResult15 = mysqli_fetch_array($objQuery15)){


$total15=$objResult15['total1'];
$total5=$objResult5['total'];
$total1=$total15+$total5;

$total= number_format( $total1,2)."";

$no_vat_to1 = ($total1 / 1.07); 
$no_vat_to = number_format( $no_vat_to1,2)."";




$strSQL1 ="SELECT  iv_no,iv_date,bill_name,bill_tel,ref_id,bill_id,sale_code FROM hos__so WHERE status_doc ='Approve' and have_order = '0'  and sale_code LIKE '%EN%' and ic_ckk='0'";


if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL1 .= ' AND type_doc = "'.$company.'"'; 
}

/*if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL1 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}*/


$strSQL1 .=" order  by iv_no ASC  ";


$objQuery1 =mysqli_query($conn,$strSQL1);
while($objResult1=mysqli_fetch_array($objQuery1)){

$strSQL2 ="SELECT product_id,count,amount  FROM hos__subso  WHERE ref_idd = '".$objResult1["ref_id"]."'  ";

$objQuery2 =mysqli_query($conn,$strSQL2);
while($objResult2=mysqli_fetch_array($objQuery2)){



$strSQL3 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult2["product_id"]."'  ";

$objQuery3 =mysqli_query($conn,$strSQL3);
while($objResult3=mysqli_fetch_array($objQuery3)){


$summary_1=$objResult2['amount'];
$summary= number_format( $summary_1,2)."";

$no_vat1 = ($summary_1 / 1.07); 
$no_vat = number_format( $no_vat1,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult1["iv_date"]); ?></td>
<td  align="left" class="style30"><?php echo  $objResult1["ref_id"]; ?></td> 
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult1["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult1["iv_no"]; ?></span></a></td>
<td  align="left" class="style30"><?php echo  $objResult1["bill_id"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult1["bill_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult1["sale_code"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult3["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult2["count"];  ?>&nbsp;<?php echo $objResult3["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat; ?></td> 

	</tr>




	<?
}
}
}






$strSQL61 ="SELECT  iv_no,iv_date,bill_name,bill_tel,ref_id,bill_id,sale_code FROM hos__so WHERE status_doc ='Approve' and have_order = '1' and have_product = '2'  and sale_code LIKE '%EN%' and ic_ckk='0'";


if($start_date !=""){ 
    $strSQL61 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL61 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL61 .= ' AND type_doc = "'.$company.'"'; 
}

/*if($sale_code !=""){ 
    $strSQL61 .= ' AND sale_code = "'.$sale_code.'"'; 
}else {
    $strSQL61 .= ' AND sale_code = "'.$sale_code1.'"'; 
	
}*/


$strSQL61 .=" order  by iv_no ASC  ";


$objQuery61 =mysqli_query($conn,$strSQL61);
while($objResult61=mysqli_fetch_array($objQuery61)){

$strSQL62 ="SELECT product_id,count,amount  FROM hos__subso  WHERE ref_idd = '".$objResult61["ref_id"]."'  ";

$objQuery62 =mysqli_query($conn,$strSQL62);
while($objResult62=mysqli_fetch_array($objQuery62)){



$strSQL63 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult62["product_id"]."'  ";

$objQuery63 =mysqli_query($conn,$strSQL63);
while($objResult63=mysqli_fetch_array($objQuery63)){


$summary_61=$objResult62['amount'];
$summary6= number_format( $summary_61,2)."";

$no_vat61 = ($summary_61 / 1.07); 
$no_vat6 = number_format( $no_vat61,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult61["iv_date"]); ?></td>
<td  align="left" class="style30"><?php echo  $objResult61["ref_id"]; ?></td> 
<td  align="center" class="style30"><a href="register_adminhos_edit.php?ref_id=<?php echo $objResult61["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult61["iv_no"]; ?></span></a></td>
<td  align="left" class="style30"><?php echo  $objResult61["bill_id"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult61["bill_name"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult61["sale_code"]; ?></td>	
<td  align="left" class="style30"><?php echo  $objResult63["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult62["count"];  ?>&nbsp;<?php echo $objResult63["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary6; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat6; ?></td> 

	</tr>




	<?
}
}
}


?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_name ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to; ?></td> 

	</tr>
</table>


	<?
}
}
	?>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">เขตการขาย</td> 	
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 


	</tr>
	<?php
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit,bill_id,sale_code FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve'  and sale_code LIKE '%EN%'";


if($start_date !=""){ 
    $strSQL211 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL211 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL211 .= ' AND company_type = "'.$company.'"'; 
}
	
//$strSQL211 .= ' AND sale_code = "'.$sale_code1.'"'; 
$strSQL211 .=" order  by credit_no ASC  ";


$objQuery211 =mysqli_query($conn,$strSQL211);
while($objResult211=mysqli_fetch_array($objQuery211)){

$strSQL222 ="SELECT product_id,count,sum_amount  FROM tb_subcredit  WHERE ref_creditt = '".$objResult211["ref_credit"]."'  ";

$objQuery222 = mysqli_query($conn,$strSQL222);
while($objResult222 = mysqli_fetch_array($objQuery222)){



$strSQL233 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult222["product_id"]."'  ";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){


$summary_22=$objResult222['sum_amount'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat22 = number_format( $no_vat22,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult211["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult211["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult211["bill_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult211["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult211["sale_code"]; ?></td>	
<td  align="left" class="style30"><?php echo  $objResult233["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult222["count"];  ?>&nbsp;<?php echo $objResult233["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary22; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat22; ?></td> 

	</tr>




	<?php
}
}
}

?>
</table>

<?php
		
$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code LIKE '%EN%'";

if($start_date !=""){ 
    $strSQL151 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL151 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL151 .= ' AND company_type = "'.$company.'"'; 
}

//$strSQL151 .= ' AND sale_code = "'.$sale_code1.'"'; 
$objQuery151 = mysqli_query($conn,$strSQL151) or die ("Error Query [".$strSQL151."]");
$objResult151 = mysqli_fetch_array($objQuery151);

$total22=$objResult151['total15'];
$total2= number_format( $total22,2)."";

$no_vat_to12 = ($total22 / 1.07); 
$no_vat_to2 = number_format( $no_vat_to12,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php
 
$creditno_vat1 = $no_vat_to1-$no_vat_to12;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total1-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>




</p>

<?php 
	
$strSQL ="SELECT * FROM tb_team_adm where ckk ='1'";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$sale_code1 = $objResult["sale_code"];
$sale_name = $objResult["sale_name"];


/*$strSQL20 ="SELECT  doc_no,doc_release_date,customer_name,ref_id FROM so__main WHERE doc_no !='' and employee_name = '".$sale_code1."' and cancel_ckk = '0'";


if($start_date !=""){ 
    $strSQL20 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL20 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL20 .= ' AND select_type_doc = "'.$company.'"'; 
}

$strSQL20 .=" order  by doc_no ASC  ";


$objQuery20 =mysqli_query($conn,$strSQL20);
$Num_Rows20 = mysqli_num_rows($objQuery20);
 if ($Num_Rows20 > 0){*/

?>

</p>
<center>
<span class="style16"><?php echo $sale_code1 ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $sale_code1 ;  ?></span>
</center> 
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="10%" align="center" class="style30">ช่องทางการขาย</td> 
<td width="10%" align="center" class="style30">ID ลูกค้า</td> 
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">เขตการขาย</td> 	
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 

	</tr>


<?php

	

$strSQL8 = "SELECT SUM(sum_amount)  as total8  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no !='' AND employee_name = '".$sale_code1."' and cancel_ckk = '0'";

if($start_date !=""){ 
    $strSQL8 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL8 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL8 .= ' AND select_type_doc = "'.$company.'"'; 
}


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total9  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' AND employee_name = '".$sale_code1."' and cancel_ckk = '0'";

if($start_date !=""){ 
    $strSQL9 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL9 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL9 .= ' AND select_type_doc = "'.$company1.'"'; 
}


$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$total8=$objResult8['total8'];
$total9=$objResult9['total9'];
$total10 = $total8+$total9;
$no_vat1 = ($total10 / 1.07); 
$tot= number_format( $total10,2)."";
$no_vat = number_format( $no_vat1,2)."";




$strSQL10 ="SELECT  doc_no,doc_release_date,billing_name,ref_id,tel,sale_channel,bill_id,employee_name FROM so__main WHERE doc_no !='' and employee_name = '".$sale_code1."' and cancel_ckk = '0'";


if($start_date !=""){ 
    $strSQL10 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL10 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL10 .= ' AND select_type_doc = "'.$company.'"'; 
}


$strSQL10 .=" order  by doc_no ASC  ";


$objQuery10 =mysqli_query($conn,$strSQL10);
while($objResult10=mysqli_fetch_array($objQuery10)){

$strSQL7 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult10["ref_id"]."'  ";

$objQuery7 =mysqli_query($conn,$strSQL7);
while($objResult7=mysqli_fetch_array($objQuery7)){



$strSQL16 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult7["product_id"]."'  ";

$objQuery16 =mysqli_query($conn,$strSQL16);
while($objResult16=mysqli_fetch_array($objQuery16)){

$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult10["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);
	
$summary_17=$objResult7['sum_amount'];
$summary17= number_format( $summary_17,2)."";

$no_vat17 = ($summary_17 / 1.07); 
$no_vat_17 = number_format( $no_vat17,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult10["doc_release_date"]); ?></td>
<td  align="left" class="style30"><?php echo  $objResult10["ref_id"]; ?></td> 
<td  align="center" class="style30"><a href="register_admin_edit.php?ref_id=<?php echo $objResult10["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult10["doc_no"]; ?></span></a></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult10["bill_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult10["billing_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult10["employee_name"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult16["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult7["sale_count"];  ?>&nbsp;<?php echo $objResult16["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary17; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat_17; ?></td> 

	</tr>




	<?php
}
}
}






$strSQL26 ="SELECT  iv_no,iv_date,billing_name,ref_id,tel,sale_channel,bill_id,employee_name FROM so__main WHERE iv_no !='' and employee_name = '".$sale_code1."' and cancel_ckk = '0'";


if($start_date !=""){ 
    $strSQL26 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL26 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL26 .= ' AND select_type_doc = "'.$company1.'"'; 
}

if($sale_code !=""){ 
    $strSQL26 .= ' AND employee_name = "'.$sale_code.'"'; 
}

$strSQL26 .=" order  by iv_no ASC  ";


$objQuery26 =mysqli_query($conn,$strSQL26);
while($objResult26=mysqli_fetch_array($objQuery26)){

$strSQL27 ="SELECT product_id,sale_count,sum_amount  FROM so__submain  WHERE ref_idd = '".$objResult26["ref_id"]."'  ";

$objQuery27 =mysqli_query($conn,$strSQL27);
while($objResult27=mysqli_fetch_array($objQuery27)){



$strSQL28 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult27["product_id"]."'  ";

$objQuery28 =mysqli_query($conn,$strSQL28);
while($objResult28=mysqli_fetch_array($objQuery28)){

$strSQL14 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID = '".$objResult26["sale_channel"]."'  ";

$objQuery14 =mysqli_query($conn,$strSQL14);
$objResult14=mysqli_fetch_array($objQuery14);
	
$summary_28=$objResult27['sum_amount'];
$summary28= number_format( $summary_28,2)."";

$no_vat28 = ($summary_28 / 1.07); 
$no_vat28 = number_format( $no_vat28,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult26["iv_date"]); ?></td>
<td  align="left" class="style30"><?php echo  $objResult26["ref_id"]; ?></td> 
<td  align="center" class="style30"><a href="register_admin_edit.php?ref_id=<?php echo $objResult26["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult26["iv_no"]; ?></span></a></td>
	<td  align="left" class="style30"><?php echo  $objResult14["salechannel_nameshort"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult26["bill_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult26["billing_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult26["employee_name"]; ?></td> 	
<td  align="left" class="style30"><?php echo  $objResult28["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult27["sale_count"];  ?>&nbsp;<?php echo $objResult28["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary28; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat28; ?></td> 

	</tr>




	<?php
}
}
}

?>



</table>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_code1 ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $tot; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat; ?></td> 

	</tr>
</table>



<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่อ้างอิง</td>
<td width="10%" align="center" class="style30">เลขที่</td>
<td width="10%" align="center" class="style30">ID ลูกค้า</td>	
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td> 
<td width="10%" align="center" class="style30">เขตการขาย</td> 	
<td width="10%" align="center" class="style30">ช่องทางการขาย</td> 
<td width="25%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="10%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ยอดลูกหนี้</td> 
<td width="10%" align="center" class="style30">รายได้จากขาย</td> 


	</tr>
	<?php
$strSQL211 ="SELECT credit_no,date_credit,customer_name,ref_credit,bill_id,sale_code FROM tb_credit_note WHERE credit_no !='' and status_doc = 'Approve' and sale_code = '".$sale_code1."'";


if($start_date !=""){ 
    $strSQL211 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL211 .= ' AND date_credit <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL211 .= ' AND company_type = "'.$company.'"'; 
}

$strSQL211 .=" order  by credit_no ASC  ";


$objQuery211 =mysqli_query($conn,$strSQL211);
while($objResult211=mysqli_fetch_array($objQuery211)){

$strSQL222 ="SELECT product_id,count,sum_amount  FROM tb_subcredit  WHERE ref_creditt = '".$objResult211["ref_credit"]."'  ";

$objQuery222 = mysqli_query($conn,$strSQL222);
while($objResult222 = mysqli_fetch_array($objQuery222)){



$strSQL233 ="SELECT sol_name,unit_name  FROM tb_product  WHERE product_ID = '".$objResult222["product_id"]."'  ";

$objQuery233 = mysqli_query($conn,$strSQL233);
while($objResult233 = mysqli_fetch_array($objQuery233)){


$summary_22=$objResult222['sum_amount'];
$summary22= number_format( $summary_22,2)."";

$no_vat22 = ($summary_22 / 1.07); 
$no_vat22 = number_format( $no_vat22,2)."";


?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult211["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult211["credit_no"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult211["bill_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult211["customer_name"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult211["sale_code"]; ?></td>	
<td  align="left" class="style30"><?php echo  $objResult233["sol_name"]; ?></td> 
<td align="right" class="style30"><?php echo $objResult222["count"];  ?>&nbsp;<?php echo $objResult233["unit_name"];  ?></td> 
<td  align="right" class="style30"><?php echo $summary22; ?></td> 
<td  align="right" class="style30"><?php echo $no_vat22; ?></td> 

	</tr>




	<?php
}
}
}

?>
</table>

<?php
		
$strSQL151 = "SELECT SUM(sum_amount)  as total15  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code = '".$sale_code1."'";

if($start_date !=""){ 
    $strSQL151 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL151 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL151 .= ' AND company_type = "'.$company.'"'; 
}

$objQuery151 = mysqli_query($conn,$strSQL151) or die ("Error Query [".$strSQL151."]");
$objResult151 = mysqli_fetch_array($objQuery151);

$total22=$objResult151['total15'];
$total2= number_format( $total22,2)."";

$no_vat_to12 = ($total22 / 1.07); 
$no_vat_to2 = number_format( $no_vat_to12,2)."";	
		
?>		

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">รวมยอดลดหนี้ของ Sale :&nbsp; <?php echo  $sale_code1 ; ?></td>
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $no_vat_to2; ?></td> 

	</tr>
</table>

<?php

$creditno_vat1 = $no_vat_to1-$no_vat1;
$creditno_vat2 = number_format( $creditno_vat1,2)."";

$credit_total = $total10-$total22;
$credit_total1 = number_format( $credit_total,2)."";		
?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style17">ยอดสุทธิของ Sale :&nbsp; <?php echo $sale_code1 ; ?></td>
<td width="10%" align="right" class="style17"><?php echo $credit_total1; ?></td> 
<td width="10%" align="right" class="style17"><?php echo $creditno_vat2; ?></td> 

	</tr>
</table>

<?php
//}
}
?>

<?php


	
$strSQL50 = "SELECT SUM(sum_amount)  as total50  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' ";

if($start_date !=""){ 
    $strSQL50 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL50 .= ' AND date_credit <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL50 .= ' AND company_type = "'.$company.'"'; 
}

$objQuery50 = mysqli_query($conn,$strSQL50) or die ("Error Query [".$strSQL50."]");
$objResult50 = mysqli_fetch_array($objQuery50);


	
$strSQL53 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0'  and status_adm !='ยกเลิก' and sale_code !='' and ic_ckk='0'";

if($start_date !=""){ 
    $strSQL53 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL53 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL53 .= ' AND type_doc = "'.$company.'"'; 
}

$objQuery53 = mysqli_query($conn,$strSQL53) or die ("Error Query [".$strSQL53."]");
$objResult53 = mysqli_fetch_array($objQuery53);

	
$strSQL54 = "SELECT SUM(amount)  as total53  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2'   and status_adm !='ยกเลิก' and sale_code !='' and ic_ckk='0'";

if($start_date !=""){ 
    $strSQL54 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL54 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL54 .= ' AND type_doc = "'.$company.'"'; 
}
	
$objQuery54 = mysqli_query($conn,$strSQL54) or die ("Error Query [".$strSQL54."]");
$objResult54 = mysqli_fetch_array($objQuery54);




$strSQL55 = "SELECT SUM(sum_amount)  as sum_amount  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE  cancel_ckk ='0' and doc_no !=''  ";
//and employee_name LIKE '%SOL%'
if($start_date !=""){ 
    $strSQL55 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL55 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL55 .= ' AND select_type_doc = "'.$company.'"'; 
}


$objQuery55 = mysqli_query($conn,$strSQL55) or die ("Error Query [".$strSQL55."]");
$objResult55 = mysqli_fetch_array($objQuery55);


$strSQL56 = "SELECT SUM(sum_amount)  as total22  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !=''   and cancel_ckk ='0' ";
//and employee_name LIKE '%SOL%'
if($start_date !=""){ 
    $strSQL56 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL56 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company1 !=""){ 
    $strSQL56 .= ' AND select_type_doc = "'.$company1.'"'; 
}

$objQuery56 = mysqli_query($conn,$strSQL56) or die ("Error Query [".$strSQL56."]");
$objResult56 = mysqli_fetch_array($objQuery56);
		
		

$sol_1=$objResult55['sum_amount'];
$sol_2=$objResult56['total22'];

	
$hos_1=$objResult54['total53'];
$hos_2=$objResult53['total'];

$total_online = $sol_1+$sol_2+$hos_1+$hos_2;

$credit50=$objResult50['total50'];

$no_vat_credit50 = ($credit50 / 1.07); 	

$total_online1 = ($total_online / 1.07); 

$summary_all = $total_online -$credit50 ;

	
$summary_novatall = $total_online1 -$no_vat_credit50 ;
$summary_allrec = number_format( $summary_all,2)."";
$summary_rec = number_format( $summary_novatall,2)."";
?>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="80%" align="left" class="style16">ยอดรวมทั้งหมด</td>
<td width="10%" align="right" class="style16"><?php echo $summary_allrec; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $summary_rec; ?></td> 

	</tr>
</table>
<?php
}
?>


</body>
</html>