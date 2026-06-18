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

<td width="10%" align="center" class="style30">Phone</td>
<td width="5%" align="center" class="style30">Message1</td>
<td width="10%" align="center" class="style30">Message2</td> 

	</tr>

<?php

$strSQL = "SELECT ref_id,tel,order_id  FROM so__main  where cancel_ckk='0' and approve_complete ='Approve' and doc_no LIKE '%IE%'";


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

$g = $objResult["ref_id"];
$save="Update  so__main set  cus_sb = '1'  where ref_id = '".$g."' ";
$qsave=mysqli_query($conn,$save);
	
	
?>
<tr>
<td  align="left" class="style30"><?php echo $objResult["tel"]; ?></td> 
<td  align="left" class="style30"><?php echo "สวัสดีค่ะ คุณลูกค้าสามารถดาวน์โหลดใบกำกับภาษีอิเล็กทรอนิกส์ได้ที่ "; echo "https://sol.allwellcenter.com/b.php?g=$g"; ?></td> 
<td  align="left" class="style30"><?php echo $objResult["order_id"]; ?></td>


	</tr>
	
	<?php 
}
?>
</table>


</body>
</html>