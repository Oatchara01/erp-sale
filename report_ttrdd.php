<?php include('head.php'); 
include 'dbconnect.php' ; 

?>
<link rel="stylesheet" href="css/w33.css">
<style type="text/css">
<!--

.style15 {
	font-size: 12px; color: #000000;
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


<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
	


<div class="w3-container">	
	
	<center><br>
<h4>ตารางข้อมูลการจัดส่งสินค้า</h4>
	
<table border= "1" width="100%" class='w3-table'>
<thead>	
<tr>
<th width="2%" style="font-size: 12px; ">เดือน</th>
<th width="4%" style="font-size: 12px; ">Lazada</th>
<th width="4%" style="font-size: 12px; ">Shopee</th>
<th width="4%" style="font-size: 12px; ">Shopee (ด่วน)</th>
<th width="4%" style="font-size: 12px; ">Shopee (Instant)</th>
<th width="4%" style="font-size: 12px; ">German Bed</th>
<th width="4%" style="font-size: 12px; ">99HM AWL</th>
<th width="4%" style="font-size: 12px; ">99HM NBM</th>
<th width="4%" style="font-size: 12px; ">99HM EMS</th>
<th width="4%" style="font-size: 12px; ">รพ. AWL</th>
<th width="4%" style="font-size: 12px; ">รพ. NBM</th>
<th width="4%" style="font-size: 12px; ">ใบแลกเปลี่ยน</th>
<th width="4%" style="font-size: 12px; ">Allwell Bed</th>
<th width="4%" style="font-size: 12px; ">จดหมาย</th>
<th width="4%" style="font-size: 12px; ">Central Online</th>
<th width="4%" style="font-size: 12px; ">Thishop</th>
<th width="4%" style="font-size: 12px; ">24 Shopping</th>
<th width="4%" style="font-size: 12px; ">Office Mate</th>
<th width="4%" style="font-size: 12px; ">Office Mate(รับเอง)</th>
<th width="4%" style="font-size: 12px; ">Noc Noc</th>
<th width="4%" style="font-size: 12px; ">Homepro</th>
<th width="4%" style="font-size: 12px; ">Tiktok</th>
<th width="4%" style="font-size: 12px; ">KTC</th>
<th width="4%" style="font-size: 12px; ">CLICKZY</th>
<th width="4%" style="font-size: 12px; ">BeDee</th>
<th width="4%" style="font-size: 12px; ">Kerry อื่นๆ</th>
<th width="4%" style="font-size: 12px; ">SPX อื่นๆ</th>	
<th width="4%" style="font-size: 12px; ">SMP Kerry</th>
<th width="4%" style="font-size: 12px; ">SMP ไปรษณีย์</th>
<th width="4%" style="font-size: 12px; ">ยอดรวม</th>
	</tr>
</thead>

<?php 
$year = 2025;   // ปีที่ต้องการ
for ($m = 1; $m <= 12; $m++) {
    // ได้รูปแบบเป็น 2025-01, 2025-02 ... 2025-12
    $day1 = $year . '-' . str_pad($m, 2, '0', STR_PAD_LEFT);
?>	
<tr>
<td><?php echo $day1; ?></td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date LIKE '%".$day1."%' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0' and sale_remark NOT LIKE '%ด่วน%' and cs_remark NOT LIKE '%Insta%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0' and sale_remark  LIKE '%ด่วน%' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	


<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0' and cs_remark  LIKE '%Insta%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	

	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date LIKE '%".$day1."%' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date LIKE '%".$day1."%' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
									 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date LIKE '%".$day1."%' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date LIKE '%".$day1."%' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day1; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
									 
									 
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date LIKE '%".$day1."%' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date LIKE '%".$day1."%' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date LIKE '%".$day1."%' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%".$day1."%' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%".$day1."%' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%".$day1."%' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day1; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date LIKE '%".$day1."%' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date LIKE '%".$day1."%' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date LIKE '%".$day1."%' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%".$day1."%' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%".$day1."%' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%".$day1."%' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day1; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date LIKE '%".$day1."%' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%".$day1."%' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day1; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day1."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day1; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date LIKE '%".$day1."%' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>			

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date LIKE '%".$day1."%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day1."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day1; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day1."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day1; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>			
		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date LIKE '%".$day1."%' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%".$day1."%' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day1; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date LIKE '%".$day1."%' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day1; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td></td>		

</tr>

<?php 
		}
	?>
	
</table><br>
	

<br><br>

 </div></div>	
<div id="cr_bar"> <?php include "foot.php"; ?></div>		 
</form>
</body>
