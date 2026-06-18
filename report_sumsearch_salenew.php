<?php 
include('head1.php'); 

include "dbconnect_cs.php";


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

?>
<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 16px; color: #000000;
}
.style16 {font-size: 15px; color: #FF0000;}
.style17 {font-size: 18px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #CC0066; font-size: 14px; }
.style38 {font-size: 14px; color: #FF0000;}
.style39 {font-size: 14px; color: #339900;}
.style40 {font-size: 14px; color: #3333CC; }
-->

</style>



<?php

date_default_timezone_set("Asia/Bangkok");

$year_ckk = $_GET["year_ckk"];	
$year_sh = $year_ckk+543;

$jan_1 = "01";
$feb_1 = "02";
$march_1 = "03";
$apil_1 = "04";
$may_1 = "05";
$june_1 = "06";
$july_1 = "07";
$aug_1= "08";
$sep_1 = "09";
$oat_1 = "10";
$nov_1 = "11";
$Dec_1 = "12";


$jan = "$year_ckk-$jan_1";
$feb = "$year_ckk-$feb_1";
$march = "$year_ckk-$march_1";
$apil = "$year_ckk-$apil_1";
$may = "$year_ckk-$may_1";
$june = "$year_ckk-$june_1";
$july = "$year_ckk-$july_1";
$aug = "$year_ckk-$aug_1";
$sep = "$year_ckk-$sep_1";
$oat = "$year_ckk-$oat_1";
$nov = "$year_ckk-$nov_1";
$Dec = "$year_ckk-$Dec_1";

$type_customer=$_GET["type_customer"];		

?>
<body>

</p>
</p>

<div class="w3-container w3-padding-large">

<center>
<span class="style15">ความพึงพอใจลูกค้าเกรด <?php echo $type_customer; ?> ฝ่ายขาย ปี <?php echo $year_sh; ?></span></p>
</center></p>

<table border= "1" width="100%" class='w3-table'>


<thead>	
<tr>
<td align="center" class="style30">เดือน</td>
<td bgcolor='yellow' align="center" class="style30">จำนวนลูกค้า</td>		
<td bgcolor='yellow' align="center" class="style30">จำนวนลูกค้าประเมิน</td>
<td bgcolor='yellow' align="center" class="style30"><?php echo "<=50 %"; ?></td>
<td bgcolor='green' align="center" class="style30">ความพึงพอใจพนักขาย</td> 
<td bgcolor='green' align="center" class="style30">ความพึงพอใจผลิตภัณฑ์</td>
</tr>
</thead>	


<?php if( $type_customer=='A'){ ?>


<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$jan%' and grade='A'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(sale_4) AS sale_4,SUM(sale_5) AS sale_5,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$jan%' and grade='A'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];
$sale_4 = $objResult["sale_4"];
$sale_5 = $objResult["sale_5"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4+$sale_5;
$sale_persent =  number_format((($sum_sale1*100)/$i)/50,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];

$sum_pro1 = $product_good+$product_link+$product_corect;
$pro_persent = number_format((($sum_pro1*100)/$j)/30,2)."";

?>

<tr>
<td align="center" class="style30">มกราคม</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$feb%' and grade='A'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(sale_4) AS sale_4,SUM(sale_5) AS sale_5,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$feb%' and grade='A'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];
$sale_4 = $objResult["sale_4"];
$sale_5 = $objResult["sale_5"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4+$sale_5;
$sale_persent =  number_format((($sum_sale1*100)/$i)/50,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];

$sum_pro1 = $product_good+$product_link+$product_corect;
$pro_persent = number_format((($sum_pro1*100)/$j)/30,2)."";

?>
<tr>
<td align="center" class="style30">กุมภาพันธ์</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$march%' and grade='A'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(sale_4) AS sale_4,SUM(sale_5) AS sale_5,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$march%' and grade='A'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];
$sale_4 = $objResult["sale_4"];
$sale_5 = $objResult["sale_5"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4+$sale_5;
$sale_persent =  number_format((($sum_sale1*100)/$i)/50,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];

$sum_pro1 = $product_good+$product_link+$product_corect;
$pro_persent = number_format((($sum_pro1*100)/$j)/30,2)."";

?>
<tr>
<td align="center" class="style30">มีนาคม</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$apil%' and grade='A'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(sale_4) AS sale_4,SUM(sale_5) AS sale_5,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$apil%' and grade='A'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];
$sale_4 = $objResult["sale_4"];
$sale_5 = $objResult["sale_5"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4+$sale_5;
$sale_persent =  number_format((($sum_sale1*100)/$i)/50,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];

$sum_pro1 = $product_good+$product_link+$product_corect;
$pro_persent = number_format((($sum_pro1*100)/$j)/30,2)."";

?>
<tr>
<td align="center" class="style30">เมษายน</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$may%' and grade='A'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(sale_4) AS sale_4,SUM(sale_5) AS sale_5,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$may%' and grade='A'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];
$sale_4 = $objResult["sale_4"];
$sale_5 = $objResult["sale_5"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4+$sale_5;
$sale_persent =  number_format((($sum_sale1*100)/$i)/50,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];

$sum_pro1 = $product_good+$product_link+$product_corect;
$pro_persent = number_format((($sum_pro1*100)/$j)/30,2)."";

?>
<tr>
<td align="center" class="style30">พฤษภาคม</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$june%' and grade='A'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(sale_4) AS sale_4,SUM(sale_5) AS sale_5,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$june%' and grade='A'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];
$sale_4 = $objResult["sale_4"];
$sale_5 = $objResult["sale_5"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4+$sale_5;
$sale_persent =  number_format((($sum_sale1*100)/$i)/50,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];

$sum_pro1 = $product_good+$product_link+$product_corect;
$pro_persent = number_format((($sum_pro1*100)/$j)/30,2)."";

?>
<tr>
<td align="center" class="style30">มิถุนายน</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$july%' and grade='A'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(sale_4) AS sale_4,SUM(sale_5) AS sale_5,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$july%' and grade='A'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];
$sale_4 = $objResult["sale_4"];
$sale_5 = $objResult["sale_5"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4+$sale_5;
$sale_persent =  number_format((($sum_sale1*100)/$i)/50,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];

$sum_pro1 = $product_good+$product_link+$product_corect;
$pro_persent = number_format((($sum_pro1*100)/$j)/30,2)."";

?>
<tr>
<td align="center" class="style30">กรกฎาคม</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$aug%' and grade='A'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(sale_4) AS sale_4,SUM(sale_5) AS sale_5,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$aug%' and grade='A'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];
$sale_4 = $objResult["sale_4"];
$sale_5 = $objResult["sale_5"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4+$sale_5;
$sale_persent =  number_format((($sum_sale1*100)/$i)/50,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];

$sum_pro1 = $product_good+$product_link+$product_corect;
$pro_persent = number_format((($sum_pro1*100)/$j)/30,2)."";

?>
<tr>
<td align="center" class="style30">สิงหาคม</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$sep%' and grade='A'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(sale_4) AS sale_4,SUM(sale_5) AS sale_5,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$sep%' and grade='A'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];
$sale_4 = $objResult["sale_4"];
$sale_5 = $objResult["sale_5"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4+$sale_5;
$sale_persent =  number_format((($sum_sale1*100)/$i)/50,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];

$sum_pro1 = $product_good+$product_link+$product_corect;
$pro_persent = number_format((($sum_pro1*100)/$j)/30,2)."";

?>
<tr>
<td align="center" class="style30">กันยายน</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$oat%' and grade='A'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(sale_4) AS sale_4,SUM(sale_5) AS sale_5,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$oat%' and grade='A'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];
$sale_4 = $objResult["sale_4"];
$sale_5 = $objResult["sale_5"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4+$sale_5;
$sale_persent =  number_format((($sum_sale1*100)/$i)/50,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];

$sum_pro1 = $product_good+$product_link+$product_corect;
$pro_persent = number_format((($sum_pro1*100)/$j)/30,2)."";

?>
<tr>
<td align="center" class="style30">ตุลาคม</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$nov%' and grade='A'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(sale_4) AS sale_4,SUM(sale_5) AS sale_5,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$nov%' and grade='A'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];
$sale_4 = $objResult["sale_4"];
$sale_5 = $objResult["sale_5"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4+$sale_5;
$sale_persent =  number_format((($sum_sale1*100)/$i)/50,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];

$sum_pro1 = $product_good+$product_link+$product_corect;
$pro_persent = number_format((($sum_pro1*100)/$j)/30,2)."";

?>
<tr>
<td align="center" class="style30">พฤศจิกายน</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$Dec%' and grade='A'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(sale_4) AS sale_4,SUM(sale_5) AS sale_5,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$Dec%' and grade='A'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];
$sale_4 = $objResult["sale_4"];
$sale_5 = $objResult["sale_5"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4+$sale_5;
$sale_persent =  number_format((($sum_sale1*100)/$i)/50,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];

$sum_pro1 = $product_good+$product_link+$product_corect;
$pro_persent = number_format((($sum_pro1*100)/$j)/30,2)."";

?>
<tr>
<td align="center" class="style30">ธันวาคม</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>
	
<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$year_ckk%' and grade='A'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(sale_4) AS sale_4,SUM(sale_5) AS sale_5,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$year_ckk%' and grade='A'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];
$sale_4 = $objResult["sale_4"];
$sale_5 = $objResult["sale_5"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4+$sale_5;
$sale_persent =  number_format((($sum_sale1*100)/$i)/50,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];

$sum_pro1 = $product_good+$product_link+$product_corect;
$pro_persent = number_format((($sum_pro1*100)/$j)/30,2)."";

?>	
<tr>
<td align="center" class="style30">Total</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>	

<?php } ?>

<?php if( $type_customer=='B'){ ?>


<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$jan%' and grade='B'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect,SUM(product_3) AS product_3  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$jan%' and grade='B'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3;
$sale_persent =  number_format((($sum_sale1*100)/$i)/30,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];
$product_3 = $objResult["product_3"];

$sum_pro1 = $product_good+$product_link+$product_corect+$product_3;
$pro_persent = number_format((($sum_pro1*100)/$j)/40,2)."";

?>

<tr>
<td align="center" class="style30">มกราคม</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$feb%' and grade='B'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect,SUM(product_3) AS product_3  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$feb%' and grade='B'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3;
$sale_persent =  number_format((($sum_sale1*100)/$i)/30,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];
$product_3 = $objResult["product_3"];

$sum_pro1 = $product_good+$product_link+$product_corect+$product_3;
$pro_persent = number_format((($sum_pro1*100)/$j)/40,2)."";

?>
<tr>
<td align="center" class="style30">กุมภาพันธ์</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$march%' and grade='B'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect,SUM(product_3) AS product_3  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$march%' and grade='B'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3;
$sale_persent =  number_format((($sum_sale1*100)/$i)/30,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];
$product_3 = $objResult["product_3"];

$sum_pro1 = $product_good+$product_link+$product_corect+$product_3;
$pro_persent = number_format((($sum_pro1*100)/$j)/40,2)."";

?>
<tr>
<td align="center" class="style30">มีนาคม</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$apil%' and grade='B'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect,SUM(product_3) AS product_3  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$apil%' and grade='B'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3;
$sale_persent =  number_format((($sum_sale1*100)/$i)/30,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];
$product_3 = $objResult["product_3"];

$sum_pro1 = $product_good+$product_link+$product_corect+$product_3;
$pro_persent = number_format((($sum_pro1*100)/$j)/40,2)."";

?>
<tr>
<td align="center" class="style30">เมษายน</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$may%' and grade='B'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect,SUM(product_3) AS product_3  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$may%' and grade='B'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3;
$sale_persent =  number_format((($sum_sale1*100)/$i)/30,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];
$product_3 = $objResult["product_3"];

$sum_pro1 = $product_good+$product_link+$product_corect+$product_3;
$pro_persent = number_format((($sum_pro1*100)/$j)/40,2)."";

?>
<tr>
<td align="center" class="style30">พฤษภาคม</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$june%' and grade='B'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect,SUM(product_3) AS product_3  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$june%' and grade='B'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3;
$sale_persent =  number_format((($sum_sale1*100)/$i)/30,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];
$product_3 = $objResult["product_3"];

$sum_pro1 = $product_good+$product_link+$product_corect+$product_3;
$pro_persent = number_format((($sum_pro1*100)/$j)/40,2)."";

?>
<tr>
<td align="center" class="style30">มิถุนายน</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$july%' and grade='B'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect,SUM(product_3) AS product_3  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$july%' and grade='B'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3;
$sale_persent =  number_format((($sum_sale1*100)/$i)/30,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];
$product_3 = $objResult["product_3"];

$sum_pro1 = $product_good+$product_link+$product_corect+$product_3;
$pro_persent = number_format((($sum_pro1*100)/$j)/40,2)."";

?>
<tr>
<td align="center" class="style30">กรกฎาคม</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$aug%' and grade='B'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect,SUM(product_3) AS product_3  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$aug%' and grade='B'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3;
$sale_persent =  number_format((($sum_sale1*100)/$i)/30,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];
$product_3 = $objResult["product_3"];

$sum_pro1 = $product_good+$product_link+$product_corect+$product_3;
$pro_persent = number_format((($sum_pro1*100)/$j)/40,2)."";

?>
<tr>
<td align="center" class="style30">สิงหาคม</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$sep%' and grade='B'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect,SUM(product_3) AS product_3  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$sep%' and grade='B'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3;
$sale_persent =  number_format((($sum_sale1*100)/$i)/30,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];
$product_3 = $objResult["product_3"];

$sum_pro1 = $product_good+$product_link+$product_corect+$product_3;
$pro_persent = number_format((($sum_pro1*100)/$j)/40,2)."";

?>
<tr>
<td align="center" class="style30">กันยายน</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$oat%' and grade='B'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}

}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect,SUM(product_3) AS product_3  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$oat%' and grade='B'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3;
$sale_persent =  number_format((($sum_sale1*100)/$i)/30,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];
$product_3 = $objResult["product_3"];

$sum_pro1 = $product_good+$product_link+$product_corect+$product_3;
$pro_persent = number_format((($sum_pro1*100)/$j)/40,2)."";

?>
<tr>
<td align="center" class="style30">ตุลาคม</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$nov%' and grade='B'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect,SUM(product_3) AS product_3  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$nov%' and grade='B'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3;
$sale_persent =  number_format((($sum_sale1*100)/$i)/30,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];
$product_3 = $objResult["product_3"];

$sum_pro1 = $product_good+$product_link+$product_corect+$product_3;
$pro_persent = number_format((($sum_pro1*100)/$j)/40,2)."";

?>
<tr>
<td align="center" class="style30">พฤศจิกายน</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>

<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$Dec%' and grade='B'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
	
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect,SUM(product_3) AS product_3  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$Dec%' and grade='B'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3;
$sale_persent =  number_format((($sum_sale1*100)/$i)/30,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];
$product_3 = $objResult["product_3"];

$sum_pro1 = $product_good+$product_link+$product_corect+$product_3;
$pro_persent = number_format((($sum_pro1*100)/$j)/40,2)."";

?>
<tr>
<td align="center" class="style30">ธันวาคม</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>
	
<?php

$strSQL1 = "SELECT *  FROM  tb_research where sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$year_ckk%' and grade='B'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i=0;
$j=0;	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
if($objResult1["sale_neat"]!='0'){

$i++;
}
if($objResult1["product_good"]!='0'){

$j++;
}
	
}

$cus_persent = number_format(($i*100)/$Num_Rows1,2)."";


$strSQL = "SELECT SUM(sale_neat) AS sale_neat,SUM(sale_data) AS sale_data,SUM(sale_3) AS sale_3,SUM(product_good) AS product_good,SUM(product_link) AS product_link,SUM(product_corect) AS product_corect,SUM(product_3) AS product_3  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and iv_date LIKE '%$year_ckk%' and grade='B'";
$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

$sale_neat = $objResult["sale_neat"];
$sale_data = $objResult["sale_data"];
$sale_3 = $objResult["sale_3"];

$sum_sale1 = $sale_neat+$sale_data+$sale_3;
$sale_persent =  number_format((($sum_sale1*100)/$i)/30,2)."";

$product_good = $objResult["product_good"];
$product_link = $objResult["product_link"];
$product_corect =  $objResult["product_corect"];
$product_3 = $objResult["product_3"];

$sum_pro1 = $product_good+$product_link+$product_corect+$product_3;
$pro_persent = number_format((($sum_pro1*100)/$j)/40,2)."";

?>	
<tr>
<td align="center" class="style30">Total</td>
<td align="center" class="style30"><?php echo $Num_Rows1; ?></td>		
<td align="center" class="style30"><?php echo $i; ?></td>
<td align="center" class="style30"><?php echo $cus_persent; ?> %</td>
<td align="center" class="style30"><?php echo $sale_persent; ?> %</td> 
<td align="center" class="style30"><?php echo $pro_persent; ?> %</td>
</tr>	

<?php } ?>



</table>
</div>