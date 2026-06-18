<?php include('head.php') ;

include "dbconnect.php";

$strSQL78 = "DELETE FROM  tb__bypro_no1  ";
$objQuery78 = mysqli_query($conn,$strSQL78);

 ?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	
<div class="w3-quarter">
	วันที่ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" style="width:90%" value="<?php echo $_GET["start_date"];?>" required>


	</div>
	<div class="w3-quarter">
	 ถึง
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" style="width:90%" value="<?php echo $_GET["end_date"];?>" required> 

	</div>
<div class="w3-quarter">
 บริษัท

<select name="company" id="company" style="width:90%" class="w3-input"   >
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="3">ออลล์เวล ไลฟ์ บจก.</option>
<option  value="4">โนเบิล เมด บจก.</option>
	</select>
</div>


<div class="w3-margin-bottom">
<input type="submit" value="Search" class="w3-button w3-pale-red">
</div>
<br>
<?php

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$company = $_GET["company"]; 

	
if($start_date!='' or $end_date!='' or $company!=''){

if($company=='3'){
$name_com = "ออลล์เวล ไลฟ์ บจก.";
}else{
$name_com = "โนเบิล เมด บจก.";

}


$type_sale = $_SESSION['code'];


?>
<h3 align="center">รายงานยอดขายสินค้า</h3>
<h3 align="center">วันที่ <?php echo Datethai($start_date); ?> ถึง  <?php echo Datethai($end_date); ?> </h3>	
<h3 align="center">เขตการขาย : <?php echo $type_sale; ?></h3>
<h3 align="center"><?php echo $name_com; ?></h3><br>



 <table width="90%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr> 
 <th width="5%">ลำดับ </th>
	 <th width="10%">รหัสสินค้า</th>
	 <th width="20%">ชื่อสินค้า </th>
    <th width="10%">จำนวน</th>
	<th width="10%">ยอดขายรวม</th>
    <th width="10%">ยอดลดหนี้</th>
    <th width="10%">ยอดรวมก่อน Vat</th>
    <th width="10%">ยอดรวมหลัง Vat</th>
   
  </tr>
  </thead>
  
<?php
	
	
	
	
$strSQL ="SELECT distinct product_no FROM tb__buypro WHERE sale_code ='".$type_sale."'";

if($start_date !=""){ 
    $strSQL .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_date <= "'.$end_date.'"'; 
}
	
if($company !=""){ 
    $strSQL .= ' AND company = "'.$company.'"'; 
}	
	

$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 ="SELECT SUM(amount) as amount  FROM tb__buypro  WHERE sale_code ='".$type_sale."' and product_no = '".$objResult["product_no"]."'";

if($start_date !=""){ 
    $strSQL1 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_date <= "'.$end_date.'"'; 
}
if($company !=""){ 
    $strSQL1 .= ' AND company = "'.$company.'"'; 
}	
	

$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);	
	
	
$strSQL2 ="SELECT SUM(count) as count  FROM tb__buypro  WHERE sale_code ='".$type_sale."' and product_no = '".$objResult["product_no"]."'";

if($start_date !=""){ 
    $strSQL2 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND doc_date <= "'.$end_date.'"'; 
}
if($company !=""){ 
    $strSQL2 .= ' AND company = "'.$company.'"'; 
}	
	
	
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 = mysqli_fetch_array($objQuery2);	
	
	
	
//ลดหนี้

$strSQL11 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE  sale_code='".$type_sale."' and product_no = '".$objResult["product_no"]."'";

if($start_date !=""){ 
    $strSQL11 .= ' AND date_cash >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND date_cash <= "'.$end_date.'"'; 
}

if($company !=""){ 
    $strSQL11 .= ' AND company = "'.$company.'"'; 
}	
	

$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11 = mysqli_fetch_array($objQuery11);	
	
$amount_sum = $objResult1["amount"];
$count_sum = $objResult2["count"];
$dis_sum = $objResult11["amount"];	


	
$strSQL17 = "SELECT *  FROM tb__bypro_no1   WHERE product_no = '".$objResult["product_no"]."'";
$objQuery17 = mysqli_query($conn,$strSQL17) or die ("Error Query [".$strSQL17."]");
$Num_Rows17 = mysqli_num_rows($objQuery17);
if($Num_Rows17 > 0){

$strSQL71 = "UPDATE tb__bypro_no1 SET amount_sum='".$amount_sum."',count_sum='".$count_sum."',dis_sum='".$dis_sum."' where product_no='".$objResult["product_no"]."' ";
$objQuery71 = mysqli_query($conn,$strSQL71);	
	

}else{

	
$strSQL71 = "insert into tb__bypro_no1 (product_no,amount_sum,count_sum,dis_sum) values ('".$objResult["product_no"]."','".$amount_sum."','".$count_sum."','".$dis_sum."')";
//echo $strSQL71;
$objQuery71 = mysqli_query($conn,$strSQL71);

}	
	
}



$strSQL7 = "SELECT *  FROM tb__bypro_no1   Order by amount_sum DESC ";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);
	
	$i = 1;
while($objResult7=mysqli_fetch_array($objQuery7)){

$strSQL75 = "SELECT sol_name,access_code  FROM tb_product WHERE  product_ID='".$objResult7["product_no"]."'";
$objQuery75 = mysqli_query($conn,$strSQL75) or die ("Error Query [".$strSQL75."]");
$objResult75 = mysqli_fetch_array($objQuery75);



	
?>
  
    <tr> 
	 <td align="center"><?php echo $i; ?></td>
	 <td align="left"><?php echo $objResult75["access_code"]; ?></td>
      <td align="left"><?php echo $objResult75["sol_name"]; ?></td>
	  <td align="right"><?php echo number_format($objResult7["count_sum"],2); ?></td> 
	  <td align="right"><?php echo number_format($objResult7["amount_sum"],2); ?></td> 
      <td align="right"><?php echo number_format($objResult7["dis_sum"],2); ?></td> 
	  <td align="right"><?php echo number_format((($objResult7["amount_sum"]-$objResult7["dis_sum"])/1.07),2); ?></td>  
	 <td align="right"><?php echo number_format(($objResult7["amount_sum"]-$objResult7["dis_sum"]),2); ?></td> 

    </tr>

	<?php 
	$i++; 
	}
	
	
$strSQL1 ="SELECT SUM(amount) as amount,SUM(count) as count  FROM tb__buypro  WHERE sale_code ='".$type_sale."'";

if($start_date !=""){ 
    $strSQL1 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_date <= "'.$end_date.'"'; 
}
if($company !=""){ 
    $strSQL1 .= ' AND company = "'.$company.'"'; 
}	
	

$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$strSQL11 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE sale_code='".$type_sale."'";

if($start_date !=""){ 
    $strSQL11 .= ' AND date_cash >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND date_cash <= "'.$end_date.'"'; 
}
	
if($company !=""){ 
    $strSQL11 .= ' AND company = "'.$company.'"'; 
}	

$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11 = mysqli_fetch_array($objQuery11);		
	
?>	

<tr> 
	 <td align="center"></td>
      <td align="left">ยอดรวม</td>
	 <td align="center"></td>
	  <td align="right"><?php echo number_format($objResult1["count"],2); ?></td> 
	  <td align="right"><?php echo number_format($objResult1["amount"],2); ?></td> 
      <td align="right"><?php echo number_format($objResult11["amount"],2); ?></td> 
	  <td align="right"><?php echo number_format((($objResult1["amount"]-$objResult11["amount"])/1.07),2); ?></td>  
	  <td align="right"><?php echo number_format(($objResult1["amount"]-$objResult11["amount"]),2); ?></td> 
	 
    </tr>	 
	 
<?php
}
?>

</table>

<br>
</div>

</div>

<div id="cr_bar"> <?php include "foot.php"; ?></div>




