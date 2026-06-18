<?php 
include ('head.php');
include "dbconnect.php";

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



$start_date = date('Y-m-d');
$time = date('H:i:s');


?>
<body>

</p>
</p>

<div class="w3-container w3-padding-large">

<center>
<span class="style15">รายงานสินค้าคงเหลือ + จุดสั่งซื้อ</span></p>
<span class="style15">บริษัท ออลล์เวล ไลฟ์ จำกัด</span></p>
<span class="style33"><?php echo Datethai($start_date); ?> <?php echo $time; ?></span>
</center></p>




			



<table border= "1" width="100%" class='w3-table'>
<thead>	
<tr>
<td width="5%" align="center" class="style30">รหัสสินค้า</td>
<td width="15%" align="center" class="style30">รายการสินค้า</td>
<td width="2%" align="center" class="style30">หน่วย</td>
<td width="2%" align="center" class="style30">พร้อมขาย</td> 
<td width="2%" align="center" class="style30">คงเหลือ</td>
<td width="2%" align="center" class="style30">หมดอายุ</td> 
<td width="2%" align="center" class="style30">มีปัญหา</td>
<td width="2%" align="center" class="style30">สินค้าเกรด B</td>
<td width="2%" align="center" class="style30">จอง</td> 
<td width="2%" align="center" class="style30">Order</td>
<td width="2%" align="center" class="style30">จุดสั่งซื้อ</td> 
<td width="2%" align="center" class="style30">สั่งซื้อ</td>
<td width="2%" align="center" class="style30">สั่งแล้ว</td> 
<td width="5%" align="center" class="style30">เลขที่ใบสั่งซื้อ</td>
<td width="2%" align="center" class="style30">รวมซื้อ</td> 
</tr>
</thead>	

<?php	
$strSQL = "SELECT expire_total,problem_total,reorder_point,access_code,sol_name,order_no,unit_name,product_ID,ordered,order_count,grade_b  FROM tb_product  WHERE popular_4 ='1' ";
	


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$Per_Page = '10';  
		$Page = isset($_GET['Page']) ? $_GET['Page'] : '';

	if(!isset($_GET['Page']))
	{
		$Page=1;
	}

	$Prev_Page = $Page-1;
	$Next_Page = $Page+1;

	$Page_Start = (($Per_Page*$Page)-$Per_Page);
	if($Num_Rows<=$Per_Page)
	{
		$Num_Pages =1;
	}
	else if(($Num_Rows % $Per_Page)==0)
	{
		$Num_Pages =($Num_Rows/$Per_Page) ;
	}
	else
	{
		$Num_Pages =($Num_Rows/$Per_Page)+1;
		$Num_Pages = (int)$Num_Pages;
	}


$strSQL .=" order  by number ASC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);

while($objResult = mysqli_fetch_array($objQuery))
{

$strSQL16 = "SELECT SUM(count) AS count FROM (hos__jongproduct LEFT JOIN hos__subjongpro ON hos__jongproduct.ref_id=hos__subjongpro.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and close_ckk = '0'  and status_doc ='Approve'";
$objQuery16 = mysqli_query($conn,$strSQL16);
$objResult16 = mysqli_fetch_array($objQuery16);

//ใบจอง
$count_jong =$objResult16['count'];
$jong= number_format( $count_jong,2)."";

$strSQL1 = "SELECT SUM(count) AS count FROM hos__subso WHERE product_id = '".$objResult["product_ID"]."' and ckk_order='1' and code_same=''";
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);

$strSQL2 = "SELECT SUM(sale_count) AS count FROM so__submain WHERE product_id = '".$objResult["product_ID"]."' and order_ckk = '1'";
$objQuery2 = mysqli_query($conn,$strSQL2);
$objResult2 = mysqli_fetch_array($objQuery2);

$count_hot =$objResult1['count'];
$count_sol =$objResult2['count'];

//ใบฝาก
$count_sale = $count_hot+$count_sol;
$sale= number_format( $count_sale,2)."";


$strSQL3 = "SELECT SUM(count_send) AS count_send ,SUM(count_receive) AS count_receive FROM st__sbmain WHERE product_id = '".$objResult["product_ID"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);

$count_send = $objResult3["count_send"];
$count_receive = $objResult3["count_receive"];
//คงเหลือ
$count_pro =$count_receive-$count_send;
$count_pro1= number_format( $count_pro,2)."";


//สั่งซื้อ
$buy_pro = $count_pro-($objResult["expire_total"]+$objResult["grade_b"]+$objResult["problem_total"]+$jong+$sale+$objResult["reorder_point"]);
$buy_pro1= number_format( $buy_pro,2)."";

//พร้อมขาย
$buy_sale = $count_pro-($objResult["expire_total"]+$objResult["grade_b"]+$objResult["problem_total"]+$count_jong+$count_sale);
$buy_sale1= number_format( $buy_sale,2)."";


	
?>


	<tr>
<td  align="left" class="style30"><div align="left"><?php echo $objResult["access_code"]; ?></div></td>
<td  align="left" class="style30"><div align="left"><?php echo $objResult["sol_name"]; ?></div></td>
<td  align="center" class="style30"><?php echo $objResult["unit_name"]; ?></td> 
<td   align="center" class="style40"><?php echo $buy_sale1;  ?></td> 
<td   align="center" class="style30"><b><?php echo $count_pro1;  ?></b></td> 
<td   align="center" class="style30"><?php echo $objResult["expire_total"]; ?></td> 
<td   align="center" class="style30"><?php echo $objResult["problem_total"]; ?></td> 
<td   align="center" class="style30"><?php echo $objResult["grade_b"]; ?></td> 		
<td  align="center" class="style30"><?php echo $jong;  ?></td> 
<td  align="center" class="style30"><?php echo $sale;  ?></td> 
<td  align="center" class="style39"><?php echo $objResult["reorder_point"]; ?></td> 
<td  align="center" class="style38"><?php echo $buy_pro1;  ?></td> 
<td   align="center" class="style30"><?php 
if($objResult["ordered"]=='1'){	
echo "<input type='checkbox' checked='checked' >"; }else{  echo "<input type='checkbox'>";   } ?></td> 
<td   align="left" class="style37"><div align="left"><?php echo $objResult["order_no"]; ?></div></td> 
<td   align="left" class="style30"><div align="left"><?php echo $objResult["order_count"]; ?></div></td> 

</tr>

<?php
}
?>

</table>

<div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page'><span class='style40'>Next>></span></a> ";
	}

	
	?>
      </p>
	
<?php 
 

	 
	 include('foot.php'); ?>
</div>
</body>
</html>