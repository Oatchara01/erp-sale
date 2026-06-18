

<link rel="stylesheet" href="css/w32.css">
<style type="text/css">


<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 16px; color: #FF0000;}
.style17 {font-size: 14px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style30 {font-size: 12px; color: #000000;}
.style40 {font-size: 13px; color: #006600; }
-->

</style>

<?php


include "dbconnect.php";




function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

$h_start_codecus = $_GET["h_start_codecus"];
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$h_start_codepro = $_GET["h_start_codepro"];
$sale_code = $_GET["sale_code"];
$company = $_GET["company"]; 
$str_arr = $_GET["company"]; 

$company = substr($str_arr, 0,1);
$company1 = substr($str_arr,-1);


$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;

if($company =='3'){
$company_name = "บริษัท ออลล์เวล ไลฟ์ จำกัด";

}else if($company =='4'){
$company_name = "บริษัท โนเบิล เมด จำกัด";

}else{
$company_name = "";
}

?>
<div class="w3-container w3-padding-large">
 <center>
<span class="style15">รายงานประวัติการขายแยกตามลูกค้า</span></p>

<span class="style15"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></span><br>

<span class="style15"><?php echo $company_name ; ?></span><br>
	
<span class="style15">เขตการขาย <?php echo $sale_code ; ?></span>	
	
</center>
</p>






<?php




$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;


?>




<?php

$strSQL = "SELECT DISTINCT(bill_id)  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($h_start_codecus !=""){ 
    $strSQL .= ' AND bill_id = "'.$h_start_codecus.'"'; 
}


if($h_start_codepro !=""){ 
    $strSQL .= ' AND product_id = "'.$h_start_codepro.'"'; 
}



$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");


while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 = "SELECT bill_name  FROM tb_customer  where customer_id  = '".$objResult["bill_id"]."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1=mysqli_fetch_array($objQuery1);
?>
</p></p>
<table border= "1" width="100%" class='w3-table'>
	<thead>
<tr>
<td width="10%" align="center" class="style30">สินค้า</td>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">จำนวน</td>
<td width="10%" align="center" class="style30">ราคาต่อหน่วย</td>
<td width="10%" align="center" class="style30">ส่วนลด</td>
<td width="10%" align="center" class="style30">รวมเงิน</td> 
<td width="10%" align="center" class="style30">ส่วนลดรวม</td>
<td width="10%" align="center" class="style30">ยอดขายก่อน Vat </td> 
<td width="10%" align="center" class="style30">ยอดขายรวม Vat</td> 

	</tr>
</thead>

<tr>
<td width="10%" align="left" class="style30"><b><font color='blue'><?php echo $objResult1["bill_name"] ; ?></font></b></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 

	</tr>




<?php
$strSQL2 = "SELECT DISTINCT(product_id)  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

if($start_date !=""){ 
    $strSQL2 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL2 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL2 .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($h_start_codecus !=""){ 
    $strSQL2 .= ' AND bill_id = "'.$h_start_codecus.'"'; 
}else{
    $strSQL2 .= ' AND bill_id = "'.$objResult["bill_id"].'"'; 

}


if($h_start_codepro !=""){ 
    $strSQL2 .= ' AND product_id = "'.$h_start_codepro.'"'; 
}



$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");


while($objResult2=mysqli_fetch_array($objQuery2)){

$strSQL3 = "SELECT sol_name,unit_name  FROM tb_product  where product_ID  = '".$objResult2["product_id"]."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3=mysqli_fetch_array($objQuery3);



?>

	<tr>
<td width="10%" align="left" class="style30"><font color='red'><?php echo $objResult3["sol_name"] ; ?></font></font></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 

	</tr>


	
	<?php
$strSQL4 = "SELECT iv_date,iv_no,sale_code,count,price,amount,discount,ref_id,sale_code,sale_remark  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

if($start_date !=""){ 
    $strSQL4 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL4 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL4 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL4 .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($h_start_codecus !=""){ 
    $strSQL4 .= ' AND bill_id = "'.$h_start_codecus.'"'; 
}else{
    $strSQL4 .= ' AND bill_id = "'.$objResult["bill_id"].'"'; 

}


if($h_start_codepro !=""){ 
    $strSQL4 .= ' AND product_id = "'.$h_start_codepro.'"'; 
}else{

    $strSQL4 .= ' AND product_id = "'.$objResult2["product_id"].'"'; 

}



$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");


while($objResult4=mysqli_fetch_array($objQuery4)){
		?>


<tr>
<td  align="center" class="style30"></td>
<td  align="center" class="style30"><?php echo  DateThai($objResult4["iv_date"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult4["iv_no"]; ?></td>
<td   class="style30"><div align="right"><?php echo  $objResult4["count"]; ?> <?php echo  $objResult3["unit_name"]; ?></div></td>
<td   class="style30"><div align="right"><?php echo   number_format($objResult4["price"],2).""; ?></div></td>
<td   class="style30"><div align="right"><?php echo  number_format($objResult4["discount"],2).""; ?></div></td>
<td   class="style30"><div align="right"><?php echo  number_format($objResult4["price"]*$objResult4["count"],2).""; ?></div></td>
<td  align="center" class="style30"><?php echo  number_format($objResult4["discount"]*$objResult4["count"],2)."" ?></td>
<td   class="style30"><div align="right"><?php echo  number_format($objResult4["amount"]/1.07,2).""; ?></div></td>
<td  align="center" class="style30"><?php echo  number_format($objResult4["amount"],2).""; ?></td>


	</tr>




	<?
}
	?>


<?php

$strSQL5 = "SELECT SUM(count) AS count,SUM(price) AS price,SUM(amount) AS amount,SUM(discount) AS discount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

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
}

if($h_start_codecus !=""){ 
    $strSQL5 .= ' AND bill_id = "'.$h_start_codecus.'"'; 
}else{
    $strSQL5 .= ' AND bill_id = "'.$objResult["bill_id"].'"'; 

}


if($h_start_codepro !=""){ 
    $strSQL5 .= ' AND product_id = "'.$h_start_codepro.'"'; 
}else{

    $strSQL5 .= ' AND product_id = "'.$objResult2["product_id"].'"'; 

}



$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rows5 = mysqli_num_rows($objQuery5);
$objResult5=mysqli_fetch_array($objQuery5);


	?>




<tr>

<td  align="center" class="style40"><font color='red'><?php echo  "รวมใบกำกับภาษี"; ?></font></td>
<td  align="center" class="style40"></td>
<td  align="center" class="style40"></td>

<td   class="style40"><div align="right"><font color='red'><?php echo  $objResult5["count"]; ?> <?php echo  $objResult3["unit_name"]; ?></font></div></td>
<td   class="style40"><div align="right"></div></td>
<td   class="style40"><div align="right"></div></td>
<td   class="style40"></td>
<td  align="right" class="style40"></td>
<td   class="style40"><div align="right"><font color='red'><?php echo  number_format($objResult5["amount"]/1.07,2).""; ?></font></div></td>
<td  align="right" class="style40"><div align="right"><font color='red'><?php echo  number_format($objResult5["amount"],2).""; ?></font></div></td>


	</tr>



<?php
}

?>




<?php

$strSQL6 = "SELECT SUM(count) AS count,SUM(price) AS price,SUM(amount) AS amount,SUM(discount) AS discount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

if($start_date !=""){ 
    $strSQL6 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL6 .= ' AND iv_date <= "'.$end_date.'"'; 
}


if($company !=""){ 
    $strSQL6 .= ' AND type_doc = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL6 .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($h_start_codecus !=""){ 
    $strSQL6 .= ' AND bill_id = "'.$h_start_codecus.'"'; 
}else{
    $strSQL6 .= ' AND bill_id = "'.$objResult["bill_id"].'"'; 

}



$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$Num_Rows6 = mysqli_num_rows($objQuery6);
$objResult6=mysqli_fetch_array($objQuery6);


	?>




<tr>

<td  align="left" class="style40"><font color='blue'><b><?php echo  "รวม "; ?><?php echo $objResult1["bill_name"] ; ?></b></font></td>
<td  align="center" class="style40"></td>
<td  align="center" class="style40"></td>

<td   class="style40"><div align="right"><font color='blue'><?php echo  $objResult6["count"]; ?> <?php echo  "ชิ้น"; ?></font></div></td>
<td   class="style40"><div align="right"></div></td>
<td   class="style40"><div align="right"></div></td>
<td   class="style40"></td>
<td  align="center" class="style40"></td>
<td   class="style40"><div align="right"><font color='blue'><?php echo  number_format($objResult6["amount"]/1.07,2).""; ?></font></div></td>
<td  align="center" class="style40"><div align="right"><font color='blue'><?php echo  number_format($objResult6["amount"],2).""; ?></font></div></td>


	</tr>


<tr>
<td width="10%" align="center" class="style30">สินค้า</td>
<td width="10%" align="center" class="style30">วันเดือนปี</td>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">จำนวน</td>
<td width="10%" align="center" class="style30">ราคาต่อหน่วย</td>
<td width="10%" align="center" class="style30">ส่วนลด</td>
<td width="10%" align="center" class="style30">รวมเงิน</td> 
<td width="10%" align="center" class="style30">ส่วนลดรวม</td>
<td width="10%" align="center" class="style30">ยอดลดหนี้ก่อน Vat </td> 
<td width="10%" align="center" class="style30">ยอดลดหนี้รวม Vat</td> 

	</tr>










	<?php
$date_credit = substr($start_date,0,-3);	
	
$strSQL14 = "SELECT date_credit,credit_no,sale_code,count,unit_price,sum_amount,discount_unit,ref_credit,product_id  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE status_doc ='Approve' ";

if($start_date !=""){ 
    $strSQL14 .= ' AND date_credit LIKE "%'.$date_credit.'%"'; 
}

/*if($end_date !=""){ 
    $strSQL14 .= ' AND date_credit <= "'.$end_date.'"'; 
}*/

if($company !=""){ 
    $strSQL14 .= ' AND company_type = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL14 .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($h_start_codecus !=""){ 
    $strSQL14 .= ' AND bill_id = "'.$h_start_codecus.'"'; 
}else{
    $strSQL14 .= ' AND bill_id = "'.$objResult["bill_id"].'"'; 

}

$objQuery14 = mysqli_query($conn,$strSQL14) or die ("Error Query [".$strSQL14."]");


while($objResult14=mysqli_fetch_array($objQuery14)){
	
	
$strSQL13 = "SELECT sol_name,unit_name  FROM tb_product  where product_ID  = '".$objResult14["product_id"]."'";
$objQuery13 = mysqli_query($conn,$strSQL13) or die ("Error Query [".$strSQL13."]");
$objResult13=mysqli_fetch_array($objQuery13);
		?>


<tr>
<td  align="center" class="style30"><?php echo  $objResult13["sol_name"]; ?></td>
<td  align="center" class="style30"><?php echo  DateThai($objResult14["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $objResult14["credit_no"]; ?></td>
<td   class="style30"><div align="right"><?php echo  $objResult14["count"]; ?> <?php echo  $objResult13["unit_name"]; ?></div></td>
<td   class="style30"><div align="right"><?php echo   number_format($objResult14["unit_price"],2).""; ?></div></td>
<td   class="style30"><div align="right"><?php echo  number_format($objResult14["discount_unit"],2).""; ?></div></td>
<td   class="style30"><div align="right"><?php echo  number_format($objResult14["unit_price"]*$objResult14["count"],2).""; ?></div></td>
<td  align="center" class="style30"><?php echo  number_format($objResult14["discount_unit"]*$objResult14["count"],2)."" ?></td>
<td   class="style30"><div align="right"><?php echo  number_format($objResult14["sum_amount"]/1.07,2).""; ?></div></td>
<td  align="center" class="style30"><?php echo  number_format($objResult14["sum_amount"],2).""; ?></td>


	</tr>




	<?
}
	?>
<?php

$strSQL16 = "SELECT SUM(count) AS count,SUM(unit_price) AS price,SUM(sum_amount) AS amount,SUM(discount_unit) AS discount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE status_doc ='Approve' ";

if($start_date !=""){ 
    $strSQL16 .= ' AND date_credit LIKE "%'.$date_credit.'%"'; 
}

/*if($end_date !=""){ 
    $strSQL16 .= ' AND date_credit <= "'.$end_date.'"'; 
}*/


if($company !=""){ 
    $strSQL16 .= ' AND company_type = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL16 .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($h_start_codecus !=""){ 
    $strSQL16 .= ' AND bill_id = "'.$h_start_codecus.'"'; 
}else{
    $strSQL16 .= ' AND bill_id = "'.$objResult["bill_id"].'"'; 

}



$objQuery16 = mysqli_query($conn,$strSQL16) or die ("Error Query [".$strSQL16."]");
$Num_Rows16 = mysqli_num_rows($objQuery16);
$objResult16=mysqli_fetch_array($objQuery16);


	?>




<tr>

<td  align="left" class="style40"><font color='red'><b><?php echo  "รวมใบลดหนี้ทั้งหมด "; ?><?php echo $objResult1["bill_name"] ; ?></b></font></td>
<td  align="center" class="style40"></td>
<td  align="center" class="style40"></td>

<td   class="style40"><div align="right"><font color='red'><?php echo  $objResult16["count"]; ?> <?php echo  "ชิ้น"; ?></font></div></td>
<td   class="style40"><div align="right"></div></td>
<td   class="style40"><div align="right"></div></td>
<td   class="style40"></td>
<td  align="center" class="style40"></td>
<td   class="style40"><div align="right"><font color='red'><?php echo  number_format($objResult16["amount"]/1.07,2).""; ?></font></div></td>
<td  align="center" class="style40"><div align="right"><font color='red'><?php echo  number_format($objResult16["amount"],2).""; ?></font></div></td>


	</tr>



<tr>

<td  align="left" class="style40"><font color='blue'><b><?php echo  "รวมทั้งหมด "; ?><?php echo $objResult1["bill_name"] ; ?></b></font></td>
<td  align="center" class="style40"></td>
<td  align="center" class="style40"></td>

<td   class="style40"><div align="right"><font color='blue'><?php echo $objResult6["count"]-$objResult16["count"]; ?> <?php echo  "ชิ้น"; ?></font></div></td>
<td   class="style40"><div align="right"></div></td>
<td   class="style40"><div align="right"></div></td>
<td   class="style40"></td>
<td  align="center" class="style40"></td>
<td   class="style40"><div align="right"><font color='blue'><?php echo  number_format(($objResult6["amount"]-$objResult16["amount"])/1.07,2).""; ?></font></div></td>
<td  align="center" class="style40"><div align="right"><font color='blue'><?php echo  number_format($objResult6["amount"]-$objResult16["amount"],2).""; ?></font></div></td>


	</tr>

	<?php
}
	?>

</table></p></p></p></p>





<?php

$strSQL15 = "SELECT SUM(count) AS count,SUM(price) AS price,SUM(amount) AS amount,SUM(discount) AS discount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

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
}

if($h_start_codecus !=""){ 
    $strSQL15 .= ' AND bill_id = "'.$h_start_codecus.'"'; 
}


if($h_start_codepro !=""){ 
    $strSQL15 .= ' AND product_id = "'.$h_start_codepro.'"'; 
}



$objQuery15 = mysqli_query($conn,$strSQL15) or die ("Error Query [".$strSQL15."]");
$Num_Rows15 = mysqli_num_rows($objQuery15);
$objResult15=mysqli_fetch_array($objQuery15);






	$strSQL26 = "SELECT SUM(count) AS count,SUM(unit_price) AS price,SUM(sum_amount) AS amount,SUM(discount_unit) AS discount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE status_doc ='Approve' ";

if($start_date !=""){ 
    $strSQL26 .= ' AND date_credit LIKE "%'.$date_credit.'%"'; 
}

/*if($end_date !=""){ 
    $strSQL26 .= ' AND date_credit <= "'.$end_date.'"'; 
}*/


if($company !=""){ 
    $strSQL26 .= ' AND company_type = "'.$company.'"'; 
}

if($sale_code !=""){ 
    $strSQL26 .= ' AND sale_code = "'.$sale_code.'"'; 
}

if($h_start_codecus !=""){ 
    $strSQL26 .= ' AND bill_id = "'.$h_start_codecus.'"'; 
}



$objQuery26 = mysqli_query($conn,$strSQL26) or die ("Error Query [".$strSQL26."]");
$Num_Rows26 = mysqli_num_rows($objQuery26);
$objResult26=mysqli_fetch_array($objQuery26);


	?>

	</p>		</p>		</p>	


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style16">ยอดรวม</td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="right" class="style16"><?php echo  $objResult15["count"]; ?> <?php echo  "ชิ้น"; ?></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="right" class="style16"><?php echo  number_format($objResult15["amount"]/1.07,2).""; ?></td> 
<td width="10%" align="right" class="style16"><?php echo  number_format($objResult15["amount"],2).""; ?></td> 

	</tr>
	<tr>
<td width="10%" align="center" class="style16">ยอดรวมใบลดหนี้ทั้งหมด</td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="right" class="style16"><?php echo  $objResult26["count"]; ?> <?php echo  "ชิ้น"; ?></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="right" class="style16"><?php echo  number_format($objResult26["amount"]/1.07,2).""; ?></td> 
<td width="10%" align="right" class="style16"><?php echo  number_format($objResult26["amount"],2).""; ?></td> 

	</tr>
	
	<tr>
<td width="10%" align="center" class="style16">ยอดรวม</td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="right" class="style16"><?php echo  $objResult15["count"]-$objResult26["count"]; ?> <?php echo  "ชิ้น"; ?></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="right" class="style16"><?php echo  number_format(($objResult15["amount"]-$objResult26["amount"])/1.07,2).""; ?></td> 
<td width="10%" align="right" class="style16"><?php echo  number_format($objResult15["amount"]-$objResult26["amount"],2).""; ?></td> 

	</tr>
	
	
</table>
	</p>		</p>		</p>	
</div>