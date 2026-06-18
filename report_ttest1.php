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

/*$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$company = $_GET["company"]; */

include"dbconnect.php";
include"dbconnect_sale.php";




?>
<body>

<?php 
/*if($company =='3'){
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
$year =$yy+543;*/



?>

</p>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">ID</td>
<td width="10%" align="center" class="style30">บริษัท</td>	
<td width="10%" align="center" class="style30">รหัส SKU</td>
<td width="10%" align="center" class="style30">ชื่อ SKU</td>
<td width="10%" align="center" class="style30">ราคาตั้งต้น</td>	
<td width="15%" align="center" class="style30">ราคาต่ำสุด</td>
<td width="15%" align="center" class="style30">รหัสสินค้า</td>
<td width="15%" align="center" class="style30">ชื่อสินค้า</td>
<td width="10%" align="center" class="style30">จำนวน</td>

<td width="15%" align="center" class="style30">รหัสสินค้า</td>
<td width="15%" align="center" class="style30">ชื่อสินค้า</td>
<td width="10%" align="center" class="style30">จำนวน</td>

	<td width="15%" align="center" class="style30">รหัสสินค้า</td>
<td width="15%" align="center" class="style30">ชื่อสินค้า</td>
<td width="10%" align="center" class="style30">จำนวน</td>

	
	<td width="15%" align="center" class="style30">รหัสสินค้า</td>
<td width="15%" align="center" class="style30">ชื่อสินค้า</td>
<td width="10%" align="center" class="style30">จำนวน</td>

	<td width="15%" align="center" class="style30">รหัสสินค้า</td>
<td width="15%" align="center" class="style30">ชื่อสินค้า</td>
<td width="10%" align="center" class="style30">จำนวน</td>

	<td width="15%" align="center" class="style30">รหัสสินค้า</td>
<td width="15%" align="center" class="style30">ชื่อสินค้า</td>
<td width="10%" align="center" class="style30">จำนวน</td>

	<td width="15%" align="center" class="style30">รหัสสินค้า</td>
<td width="15%" align="center" class="style30">ชื่อสินค้า</td>
<td width="10%" align="center" class="style30">จำนวน</td>

	
	
	</tr>

<?php
$strSQL = "SELECT * FROM tb_product_lzd  where  1 ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{	
	

	
$strSQL1 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE product_ID = '".$objResult["id_product1"]."'";
$objQuery1= mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);
	
$strSQL2 = "SELECT sol_name,access_code FROM tb_product WHERE product_ID = '".$objResult["id_product2"]."'";
$objQuery2= mysqli_query($conn,$strSQL2) or die(mysqli_error());
$objResult2 = mysqli_fetch_array($objQuery2);
	
$strSQL3 = "SELECT sol_name,access_code FROM tb_product WHERE product_ID = '".$objResult["id_product3"]."'";
$objQuery3= mysqli_query($conn,$strSQL3) or die(mysqli_error());
$objResult3 = mysqli_fetch_array($objQuery3);

$strSQL4 = "SELECT sol_name,access_code FROM tb_product WHERE product_ID = '".$objResult["id_product4"]."'";
$objQuery4= mysqli_query($conn,$strSQL4) or die(mysqli_error());
$objResult4 = mysqli_fetch_array($objQuery4);
	
$strSQL5 = "SELECT sol_name,access_code FROM tb_product WHERE product_ID = '".$objResult["id_product5"]."'";
$objQuery5= mysqli_query($conn,$strSQL5) or die(mysqli_error());
$objResult5 = mysqli_fetch_array($objQuery5);

$strSQL6 = "SELECT sol_name,access_code FROM tb_product WHERE product_ID = '".$objResult["id_product6"]."'";
$objQuery6= mysqli_query($conn,$strSQL6) or die(mysqli_error());
$objResult6 = mysqli_fetch_array($objQuery6);

$strSQL7 = "SELECT sol_name,access_code FROM tb_product WHERE product_ID = '".$objResult["id_product7"]."'";
$objQuery7= mysqli_query($conn,$strSQL7) or die(mysqli_error());
$objResult7 = mysqli_fetch_array($objQuery7);
	
	
	
/*$save2="INSERT INTO `tb_product_lzd` (`lzd_id`, `company`, `code_lazada`, `name_lazada`, `percen_price`, `price_lazada`, `id_product1`, `unit1`, `waranty1`, `id_product2`, `unit2`, `waranty2`, `id_product3`, `unit3`, `waranty3`, `id_product4`, `unit4`, `waranty4`, `id_product5`, `unit5`, `waranty5`, `id_product6`, `unit6`, `waranty6`, `id_product7`, `unit7`, `waranty7`, `id_product8`, `unit8`, `waranty8`, `id_product9`, `unit9`, `waranty9`, `id_product10`, `unit10`, `waranty10`, `big_ckk`) VALUES (NULL, '".$objResult["company"]."', '".$objResult["code_jd"]."','".$objResult["name_jd"]."', '', '".$objResult["price_jd"]."', '".$objResult["id_product1"]."', '".$objResult["unit1"]."', '".$objResult["waranty1"]."', '".$objResult["id_product2"]."', '".$objResult["unit1"]."', '".$objResult["waranty2"]."', '".$objResult["id_product3"]."', '".$objResult["unit3"]."', '".$objResult["waranty3"]."', '".$objResult["id_product4"]."', '".$objResult["unit4"]."', '".$objResult["waranty4"]."', '".$objResult["id_product5"]."', '".$objResult["unit5"]."', '".$objResult["waranty5"]."', '".$objResult["id_product6"]."', '".$objResult["unit6"]."', '".$objResult["waranty6"]."', '".$objResult["id_product7"]."', '".$objResult["unit7"]."', '".$objResult["waranty7"]."', '".$objResult["id_product8"]."', '".$objResult["unit8"]."', '".$objResult["waranty8"]."', '".$objResult["id_product9"]."', '".$objResult["unit9"]."', '".$objResult["waranty9"]."', '".$objResult["id_product10"]."', '".$objResult["unit10"]."', '".$objResult["waranty10"]."','')";
$qsave2=mysqli_query($conn,$save2);	*/
	
	

?>
	
<tr>
<td width="10%" align="left" class="style30"><?php echo $objResult["lzd_id"]; ?></td>
<td width="10%" align="left" class="style30"><?php echo $objResult["company"]; ?></td> 	
<td width="10%" align="left" class="style30"><?php echo $objResult["code_lazada"]; ?></td> 
<td width="10%" align="left" class="style30"><?php echo $objResult["name_lazada"]; ?></td>
<td width="10%" align="left" class="style30"><?php echo $objResult["price_lazada"]; ?></td>
<td width="10%" align="left" class="style30"><?php echo $objResult["percen_price"]; ?></td>
	
<td width="10%" align="left" class="style30"><?php echo $objResult1["access_code"]; ?></td> 
<td width="10%" align="left" class="style30"><?php echo $objResult1["sol_name"]; ?></td> 	
<td width="10%" align="left" class="style30"><?php echo $objResult["unit1"]; ?></td> 
	
<td width="10%" align="left" class="style30"><?php echo $objResult2["access_code"]; ?></td> 
<td width="10%" align="left" class="style30"><?php echo $objResult2["sol_name"]; ?></td> 	
<td width="10%" align="left" class="style30"><?php echo $objResult["unit2"]; ?></td> 
	
<td width="10%" align="left" class="style30"><?php echo $objResult3["access_code"]; ?></td> 
<td width="10%" align="left" class="style30"><?php echo $objResult3["sol_name"]; ?></td> 	
<td width="10%" align="left" class="style30"><?php echo $objResult["unit3"]; ?></td> 
	
<td width="10%" align="left" class="style30"><?php echo $objResult4["access_code"]; ?></td> 
<td width="10%" align="left" class="style30"><?php echo $objResult4["sol_name"]; ?></td> 	
<td width="10%" align="left" class="style30"><?php echo $objResult["unit4"]; ?></td> 
	
<td width="10%" align="left" class="style30"><?php echo $objResult5["access_code"]; ?></td> 
<td width="10%" align="left" class="style30"><?php echo $objResult5["sol_name"]; ?></td> 	
<td width="10%" align="left" class="style30"><?php echo $objResult["unit5"]; ?></td> 
	
<td width="10%" align="left" class="style30"><?php echo $objResult6["access_code"]; ?></td> 
<td width="10%" align="left" class="style30"><?php echo $objResult6["sol_name"]; ?></td> 	
<td width="10%" align="left" class="style30"><?php echo $objResult["unit6"]; ?></td> 
	
<td width="10%" align="left" class="style30"><?php echo $objResult7["access_code"]; ?></td> 
<td width="10%" align="left" class="style30"><?php echo $objResult7["sol_name"]; ?></td> 	
<td width="10%" align="left" class="style30"><?php echo $objResult["unit7"]; ?></td> 

</tr>	
	

<?php 
	
}
//}
	?>
		
	
</table>


</body>
</html>