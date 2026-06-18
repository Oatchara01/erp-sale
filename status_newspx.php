<?php include('head.php'); 
include "dbconnect.php";
?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
	<div class="w3-white">
<div class="w3-container w3-padding-large">

<?php

$delivery_date= $_GET["delivery_date"];
$sale_channel= $_GET["sale_channel"];
$delivery= $_GET["delivery"];
$select_type_doc = $_GET["select_type_doc"];

$strSQL3 ="SELECT salechannel_nameshort  FROM tb_salechannel  WHERE salechannel_ID  = '".$sale_channel."'  ";

$objQuery3 =mysqli_query($conn,$strSQL3);
$objResult3=mysqli_fetch_array($objQuery3);


?>

<center>
<h4>ตารางข้อมูลการจัดส่งสินค้า</h4>
	<h4>วันที่ <?php echo  Datethai($delivery_date); ?></h4>	
	<h4><?php echo $objResult3["salechannel_nameshort"]; ?></h4>
</center><br>
</form>
		
<div class="w3-container">
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%">เลขที่อ้างอิง</th>
<th width="10%">วันที่ลงทะเบียน</th>
<th width="10%">เลขที่เอกสาร</th> 
<th width="10%">หมายเลขคำสั่งซื้อ</th> 
<th width="10%">วันที่ออกเอกสาร</th>
<th width="23%">รายการสินค้า</th>
<th width="22%">ชื่อลูกค้า</th>
<th width="20%">ช่องทางการขาย</th>
<th width="5%">จำนวนกล่อง</th>
<th width="5%">แก้ไข</th>
</thead>		
		
<?php	

$strSQL = "SELECT ref_id,register_date,doc_no,doc_release_date,delivery_contact,order_id,billing_name,sale_channel,count_box   FROM so__main  where sale_channel='".$sale_channel."' and delivery_date='".$delivery_date."' and cancel_ckk ='0'";

if($select_type_doc=='3' ){	
if($sale_channel=='3' or $sale_channel=='4'){	
    $strSQL .= ' AND select_type_doc = "'.$select_type_doc.'"'; 
}else{
    $strSQL .= ' AND select_type_doc != "2" and select_type_doc != "4"'; 	
}
	
	
}else if($select_type_doc=='4'){
	
if($sale_channel=='3' or $sale_channel=='4'){	
    $strSQL .= ' AND select_type_doc = "'.$select_type_doc.'"'; 
}else{
    $strSQL .= ' AND select_type_doc != "1" and select_type_doc != "3"'; 	
}	
	
}
	
if($delivery !=""){ 
    $strSQL .= ' AND delivery = "'.$delivery.'"'; 
}	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


/*$Per_Page = '20';  
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
	LIMIT $Page_Start , $Per_Page}*/


$strSQL .=" order  by ref_id DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);



$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$strSQL22 = "SELECT ref_id  FROM so__main where ref_id = '".$objResult["ref_id"]."'";
$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$Num_Rows22 = mysqli_num_rows($objQuery22);
	
	
?>
<tbody>




<tr>
<td><?php echo $objResult["ref_id"];?></td>
	
<td><?php echo DateThai($objResult["register_date"]);?></td>

<td><?php echo $objResult["doc_no"];?></td>
	<td><?php echo $objResult["order_id"];?></td>
<td>
<?php if ($objResult["doc_release_date"]=="0000-00-00") {
	echo "-"; 
	} 
	else 
	{ echo DateThai($objResult["doc_release_date"]);
	}
	?> 
</td>
<td><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
	echo $objResult1["sol_name"]; 
	?><br />
<?php
}
?>
</div>
</td>
<td><div align="left"><?php echo $objResult["delivery_contact"]; ?></div></td>	
<td><div align="left">
<?php
$strSQL2 = "SELECT salechannel_nameshort  FROM (so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) where ref_id = '".$objResult["ref_id"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

while($objResult2 = mysqli_fetch_array($objQuery2))
{
?>


<?php echo $objResult2["salechannel_nameshort"]; ?>
<?php
}
?>

</div></td>
<td><div align="center"><?php echo $objResult["count_box"]+1; ?></div></td>	
<td>
	<a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>

	</td>

</tr>


<?php
		  
$i++;
}

	
if($sale_channel=='25'){	
	
	$strSQL = "SELECT ref_id,register_date,doc_no,doc_release_date,delivery_contact,order_id,billing_name,sale_channel,count_box   FROM so__main  where sale_channel='' and delivery='".$delivery."' and delivery_date='".$delivery_date."'";
		
if($select_type_doc !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$select_type_doc.'"'; 
}	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$strSQL .=" order  by ref_id DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);



$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
<tbody>




<tr>
		<td><?php echo $objResult["ref_id"];?></td>
	
<td><?php echo DateThai($objResult["register_date"]);?></td>

<td><?php echo $objResult["doc_no"];?></td>
	<td><?php echo $objResult["order_id"];?></td>
<td>
<?php if ($objResult["doc_release_date"]=="0000-00-00") {
	echo "-"; 
	} 
	else 
	{ echo DateThai($objResult["doc_release_date"]);
	}
	?> 
</td>
<td><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
///echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
	echo $objResult1["sol_name"]; 
	?><br />
<?php
}
?>
</div>
</td>
<td><div align="left"><?php echo $objResult["delivery_contact"]; ?></div></td>	
<td><div align="left">
<?php
$strSQL2 = "SELECT salechannel_nameshort  FROM (so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) where ref_id = '".$objResult["ref_id"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

while($objResult2 = mysqli_fetch_array($objQuery2))
{
?>


<?php echo $objResult2["salechannel_nameshort"]; ?>
<?php
}
?>

</div></td>
<td><div align="center"><?php echo $objResult["count_box"]+$Num_Rows; ?></div></td>	
<td>
	<a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>

	</td>

</tr>
	
<?php 
	}
}
	?>
	<?php
if($sale_channel=='3' or $sale_channel=='4'){	
if($delivery=='1'){		
$strSQL = "SELECT ref_id,register_date,doc_no,doc_release_date,delivery_contact,order_id,billing_name,sale_channel,count_box   FROM so__main  where sale_channel='".$sale_channel."' and delivery='2' and delivery_date='".$delivery_date."'";
		
if($select_type_doc !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$select_type_doc.'"'; 
}	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$strSQL .=" order  by ref_id DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);



$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
<tbody>




<tr>
		<td><?php echo $objResult["ref_id"];?></td>
	
<td><?php echo DateThai($objResult["register_date"]);?></td>

<td><?php echo $objResult["doc_no"];?></td>
	<td><?php echo $objResult["order_id"];?></td>
<td>
<?php if ($objResult["doc_release_date"]=="0000-00-00") {
	echo "-"; 
	} 
	else 
	{ echo DateThai($objResult["doc_release_date"]);
	}
	?> 
</td>
<td><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
///echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
	echo $objResult1["sol_name"]; 
	?><br />
<?php
}
?>
</div>
</td>
<td><div align="left"><?php echo $objResult["delivery_contact"]; ?></div></td>	
<td><div align="left">
<?php
$strSQL2 = "SELECT salechannel_nameshort  FROM (so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) where ref_id = '".$objResult["ref_id"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

while($objResult2 = mysqli_fetch_array($objQuery2))
{
?>


<?php echo $objResult2["salechannel_nameshort"]; ?>
<?php
}
?>

</div></td>
<td><div align="center"><?php echo $objResult["count_box"]+1; ?></div></td>
<td>
	<a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>

	</td>

</tr>
	<?php 
}
	
$strSQL = "SELECT ref_id,register_date,doc_no,doc_release_date,delivery_contact,order_id,billing_name,sale_channel,count_box   FROM so__main  where sale_channel='".$sale_channel."' and delivery='17' and delivery_date='".$delivery_date."'";
		
if($select_type_doc !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$select_type_doc.'"'; 
}	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$strSQL .=" order  by ref_id DESC   ";
$objQuery  = mysqli_query($conn,$strSQL);



$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
<tbody>




<tr>
		<td><?php echo $objResult["ref_id"];?></td>
	
<td><?php echo DateThai($objResult["register_date"]);?></td>

<td><?php echo $objResult["doc_no"];?></td>
	<td><?php echo $objResult["order_id"];?></td>
<td>
<?php if ($objResult["doc_release_date"]=="0000-00-00") {
	echo "-"; 
	} 
	else 
	{ echo DateThai($objResult["doc_release_date"]);
	}
	?> 
</td>
<td><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
///echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
	echo $objResult1["sol_name"]; 
	?><br />
<?php
}
?>
</div>
</td>
<td><div align="left"><?php echo $objResult["delivery_contact"]; ?></div></td>	
<td><div align="left">
<?php
$strSQL2 = "SELECT salechannel_nameshort  FROM (so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) where ref_id = '".$objResult["ref_id"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

while($objResult2 = mysqli_fetch_array($objQuery2))
{
?>


<?php echo $objResult2["salechannel_nameshort"]; ?>
<?php
}
?>

</div></td>
<td><div align="center"><?php echo $objResult["count_box"]+$Num_Rows; ?></div></td>
<td>
	<a href="register_admin_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>

	</td>

</tr>
	

<?php 
	}
}
	}
	?>	
</tbody>
</table>

 <div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&Keyword1=$Keyword1'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&Keyword1=$Keyword1'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&Keyword1=$Keyword1'><span class='style40'>Next>></span></a> ";
	}
	
	?>
      <br></div></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>

</body>
</html>