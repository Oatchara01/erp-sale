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



include"dbconnect.php";



$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];



$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;

?>
<body>



<span class="style15">รายงานการเคลื่อนไหวสินค้า     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></span>
<hr color="black"  width="100%" size="0.1" align="right">
</p>

<?php 
if($_GET["h_product_code"]!=''){

$product_h = $_GET["h_product_code"];

$strSQL22 = "SELECT access_code,access_name,unit_name,express_code FROM tb_product WHERE product_ID = '".$product_h."' ";
//echo $strSQL22;

$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$objResult22 = mysqli_fetch_array($objQuery22);

$access_code1 = $objResult22["access_code"];
$access_name1 = $objResult22["access_name"];
$unit_name1 = $objResult22["unit_name"];
$express_code1 = $objResult22["express_code"];

?>

<span class="style16"><?php echo $access_code1 ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $access_name1 ;  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $unit_name1 ;  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $express_code1 ;  ?></span>

	<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">เลขที่ IV รวม</td>
<td width="25%" align="center" class="style30">ชื่อลุกค้า</td> 
<td width="20%" align="center" class="style30">จำนวนจ่าย</td> 
<td width="25%" align="center" class="style30">หมายเหตุ</td> 
<td width="15%" align="center" class="style30">ช่องทางการขาย</td>
	</tr>

</p>




	<?php

$strSQL2 = "SELECT date_so,iv_no,bill_name,count,sale_remark FROM (hos__so  LEFT JOIN hos__subso  ON hos__so .ref_id=hos__subso .ref_idd) WHERE product_id = '".$product_h."' ";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_so <= "'.$end_date.'"'; 
}



$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);


while($objResult2 = mysqli_fetch_array($objQuery2))
{

?>

<tr>
<td width="10%" align="center" class="style30"><?php echo datethai($objResult2["date_so"]);  ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult2["iv_no"];  ?></td>
<td width="10%" align="center" class="style30"></td>
<td width="25%" align="left" class="style30"><?php echo $objResult2["bill_name"];  ?></td> 
<td width="20%" align="center" class="style30"><?php echo $objResult2["count"];  ?></td> 
<td width="25%" align="left" class="style30"><?php echo $objResult2["sale_remark"];  ?></td> 
<td width="15%" align="center" class="style30"></td>
	</tr>
<?php } 


	$strSQL3 = "SELECT date_br,iv_no,customer,count,sale_remark FROM (hos__br  LEFT JOIN hos__subbr  ON hos__br .ref_id_br=hos__subbr .ref_idd_br) WHERE product_id = '".$product_h."' ";

if($start_date !=""){ 
    $strSQL3 .= ' AND date_br >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL3 .= ' AND date_br <= "'.$end_date.'"'; 
}

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);


while($objResult3 = mysqli_fetch_array($objQuery3))
{

?>

 <tr>
<td width="10%" align="center" class="style30"><?php echo datethai($objResult3["date_br"]);  ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult3["iv_no"];  ?></td>
<td width="10%" align="center" class="style30"></td>
<td width="25%" align="left" class="style30"><?php echo $objResult3["customer"];  ?></td> 
<td width="20%" align="center" class="style30"><?php echo $objResult3["count"];  ?></td> 
<td width="25%" align="left" class="style30"><?php echo $objResult3["sale_remark"];  ?></td> 
<td width="15%" align="center" class="style30"></td>
	</tr>

	<?php } 

$strSQL1 = "SELECT register_date,product_id,doc_no,iv_no,customer_name,billing_name,delivery_name,sale_count,ref_id,sale_channel  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$product_h."' and cancel_ckk='0'";

if($start_date !=""){ 
    $strSQL1 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND register_date <= "'.$end_date.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{



	
$strSQL4 = "SELECT sale_remark FROM so__submain WHERE product_id = '".$product_h."' and ref_idd = '".$objResult1["ref_id"]."'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
while($objResult4 = mysqli_fetch_array($objQuery4))
{
	
$strSQL40 = "SELECT salechannel_nameshort  FROM tb_salechannel WHERE salechannel_ID = '".$objResult1["sale_channel"]."' ";
$objQuery40 = mysqli_query($conn,$strSQL40) or die ("Error Query [".$strSQL40."]");
$objResult40 = mysqli_fetch_array($objQuery40);
?>

 <tr>
<td width="10%" align="center" class="style30"><?php echo datethai($objResult1["register_date"]);  ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult1["doc_no"];  ?></td>
<td width="10%" align="center" class="style30"><?php echo $objResult1["iv_no"];  ?></td>
<td width="25%" align="left" class="style30"><?php echo $objResult1["customer_name"];  ?></td> 
<td width="20%" align="center" class="style30"><?php echo $objResult1["sale_count"];  ?></td> 
<td width="25%" align="left" class="style30"><?php echo $objResult4["sale_remark"];  ?></td> 
<td width="25%" align="left" class="style30"><?php echo $objResult40["salechannel_nameshort"];  ?></td> 

	</tr>


	<?
}
}


$strSQL12 = "SELECT SUM(count)  as total12  FROM (hos__so  LEFT JOIN hos__subso  ON hos__so .ref_id=hos__subso .ref_idd) WHERE product_id = '".$product_h."' ";

if($start_date !=""){ 
    $strSQL12 .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL12 .= ' AND date_so <= "'.$end_date.'"'; 
}



$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);


$strSQL13 = "SELECT SUM(count)  as total13  FROM (hos__br  LEFT JOIN hos__subbr  ON hos__br .ref_id_br=hos__subbr .ref_idd_br) WHERE product_id = '".$product_h."' ";

if($start_date !=""){ 
    $strSQL13 .= ' AND date_br >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL13 .= ' AND date_br <= "'.$end_date.'"'; 
}

$objQuery13 = mysqli_query($conn,$strSQL13) or die ("Error Query [".$strSQL13."]");
$objResult13 = mysqli_fetch_array($objQuery13);


$strSQL11 = "SELECT SUM(sale_count)  as total11 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$product_h."'  and cancel_ckk='0'";

if($start_date !=""){ 
    $strSQL11 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND register_date <= "'.$end_date.'"'; 
}

$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

$count = $objResult12["total12"];
$count1 = $objResult13["total13"];
$count2 = $objResult11["total11"];
$sum_count = $count+$count1+$count2;
?>

 <tr>

 <td width="10%" align="center" class="style30"></td>
<td width="20%" align="center" class="style30"></td>
<td width="25%" align="left" class="style30"><?php  echo "รวมตามประเภทเอกสาร";  ?></td> 
<td width="20%" align="center" class="style30"><?php echo $sum_count;  ?></td> 
<td width="25%" align="left" class="style30"></td> 



	</tr>






<?php

}else{

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];


$strSQL ="SELECT product_ID,access_name,access_code,unit_name,express_code  FROM tb_product ";



$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$product_ID = $objResult["product_ID"];
$access_name = $objResult["access_name"];
$access_code = $objResult["access_code"];
$unit_name = $objResult["unit_name"];
$express_code = $objResult["express_code"];



$strSQL7 = "SELECT register_date,product_id,doc_no,customer_name,billing_name,delivery_name,sale_count,ref_id FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$product_ID."' ";

if($start_date !=""){ 
    $strSQL7 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL7 .= ' AND register_date <= "'.$end_date.'"'; 
}

$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);


$strSQL5 = "SELECT date_so,count FROM (hos__so  LEFT JOIN hos__subso  ON hos__so .ref_id=hos__subso .ref_idd) WHERE product_id = '".$product_ID."' ";

if($start_date !=""){ 
    $strSQL5 .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND date_so <= "'.$end_date.'"'; 
}



$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rows5 = mysqli_num_rows($objQuery5);



$strSQL6 = "SELECT date_br,count FROM (hos__br  LEFT JOIN hos__subbr  ON hos__br .ref_id_br=hos__subbr .ref_idd_br) WHERE product_id = '".$product_ID."' ";

if($start_date !=""){ 
    $strSQL6 .= ' AND date_br >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL6 .= ' AND date_br <= "'.$end_date.'"'; 
}

$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$Num_Rows6 = mysqli_num_rows($objQuery6);





?>
	</p>
	<?php if($Num_Rows5 > 0 or $Num_Rows6 > 0 or $Num_Rows7 > 0 ){ ?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="20%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="25%" align="center" class="style30">ชื่อลุกค้า</td> 
<td width="20%" align="center" class="style30">จำนวนจ่าย</td> 
<td width="25%" align="center" class="style30">หมายเหตุ</td> 

	</tr>

</p>
<span class="style16"><?php echo $access_code ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $access_name ;  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $unit_name ;  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $express_code ;  ?></span>




	<?php

$strSQL2 = "SELECT date_so,iv_no,bill_name,count,sale_remark FROM (hos__so  LEFT JOIN hos__subso  ON hos__so .ref_id=hos__subso .ref_idd) WHERE product_id = '".$product_ID."' ";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_so <= "'.$end_date.'"'; 
}



$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);


while($objResult2 = mysqli_fetch_array($objQuery2))
{

?>

<tr>
<td width="10%" align="center" class="style30"><?php echo datethai($objResult2["date_so"]);  ?></td>
<td width="20%" align="center" class="style30"><?php echo $objResult2["iv_no"];  ?></td>
<td width="25%" align="left" class="style30"><?php echo $objResult2["bill_name"];  ?></td> 
<td width="20%" align="center" class="style30"><?php echo $objResult2["count"];  ?></td> 
<td width="25%" align="left" class="style30"><?php echo $objResult2["sale_remark"];  ?></td> 

	</tr>
<?php } 


	$strSQL3 = "SELECT date_br,iv_no,customer,count,sale_remark FROM (hos__br  LEFT JOIN hos__subbr  ON hos__br .ref_id_br=hos__subbr .ref_idd_br) WHERE product_id = '".$product_ID."' ";

if($start_date !=""){ 
    $strSQL3 .= ' AND date_br >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL3 .= ' AND date_br <= "'.$end_date.'"'; 
}

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);


while($objResult3 = mysqli_fetch_array($objQuery3))
{

?>

 <tr>
<td width="10%" align="center" class="style30"><?php echo datethai($objResult3["date_br"]);  ?></td>
<td width="20%" align="center" class="style30"><?php echo $objResult3["iv_no"];  ?></td>
<td width="25%" align="left" class="style30"><?php echo $objResult3["customer"];  ?></td> 
<td width="20%" align="center" class="style30"><?php echo $objResult3["count"];  ?></td> 
<td width="25%" align="left" class="style30"><?php echo $objResult3["sale_remark"];  ?></td> 

	</tr>

	<?php } 

$strSQL1 = "SELECT register_date,product_id,doc_no,customer_name,billing_name,delivery_name,sale_count,ref_id FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$product_ID."' ";

if($start_date !=""){ 
    $strSQL1 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND register_date <= "'.$end_date.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{



	
$strSQL4 = "SELECT sale_remark FROM so__submain WHERE product_id = '".$product_ID."' and ref_idd = '".$objResult1["ref_id"]."'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
while($objResult4 = mysqli_fetch_array($objQuery4))
{

?>

 <tr>
<td width="10%" align="center" class="style30"><?php echo datethai($objResult1["register_date"]);  ?></td>
<td width="20%" align="center" class="style30"><?php echo $objResult1["doc_no"];  ?></td>
<td width="25%" align="left" class="style30"><?php echo $objResult1["customer_name"];  ?></td> 
<td width="20%" align="center" class="style30"><?php echo $objResult1["sale_count"];  ?></td> 
<td width="25%" align="left" class="style30"><?php echo $objResult4["sale_remark"];  ?></td> 

	</tr>


	<?
}
}


$strSQL12 = "SELECT SUM(count)  as total12  FROM (hos__so  LEFT JOIN hos__subso  ON hos__so .ref_id=hos__subso .ref_idd) WHERE product_id = '".$product_ID."' ";

if($start_date !=""){ 
    $strSQL12 .= ' AND date_so >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL12 .= ' AND date_so <= "'.$end_date.'"'; 
}



$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);


$strSQL13 = "SELECT SUM(count)  as total13  FROM (hos__br  LEFT JOIN hos__subbr  ON hos__br .ref_id_br=hos__subbr .ref_idd_br) WHERE product_id = '".$product_ID."' ";

if($start_date !=""){ 
    $strSQL13 .= ' AND date_br >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL13 .= ' AND date_br <= "'.$end_date.'"'; 
}

$objQuery13 = mysqli_query($conn,$strSQL13) or die ("Error Query [".$strSQL13."]");
$objResult13 = mysqli_fetch_array($objQuery13);


$strSQL11 = "SELECT SUM(sale_count)  as total11 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$product_ID."' ";

if($start_date !=""){ 
    $strSQL11 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND register_date <= "'.$end_date.'"'; 
}

$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

$count = $objResult12["total12"];
$count1 = $objResult13["total13"];
$count2 = $objResult11["total11"];
$sum_count = $count+$count1+$count2;
?>

 <tr>

 <td width="10%" align="center" class="style30"></td>
<td width="20%" align="center" class="style30"></td>
<td width="25%" align="left" class="style30"><?php  echo "รวมตามประเภทเอกสาร";  ?></td> 
<td width="20%" align="center" class="style30"><?php echo $sum_count;  ?></td> 
<td width="25%" align="left" class="style30"></td> 



	</tr>



<?php
}
}
}
?>
</table>
</body>
</html>