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
	<div class="w3-panel w3-light-gray"><h4>ข้อมูลการจัดส่งสินค้า ขนส่ง</h4></div>

	<div class="w3-container w3-third">
		วันที่
	<input type='date' name="start_date" class="w3-select" id="start_date"  value ="<?php echo $_GET["start_date"];  ?>" >	
		</div>

<div class="w3-container w3-third">
เดือน
<select name="mount" id="mount" class="w3-select" >
<option  value="">**เลือกเดือน**</option>
<?php
$sql = "select * from tb_month order by month_id";
$query = mysqli_query($conn,$sql);
while ($fetch = mysqli_fetch_array($query,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetch['month_code']; ?>"><?php echo $fetch['month_name']; ?></option>
<?php } ?>
</select>

</div>
<div class="w3-container w3-third">

ปี
<select name="year" id="year" class="w3-select" >
<option  value="">**เลือกปี**</option>
<?php
$sql = "select * from tb_year order by id_year  DESC";
$query = mysqli_query($conn,$sql);
while ($fetch = mysqli_fetch_array($query,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetch['year_no']; ?>"><?php echo $fetch['year_name']; ?></option>
<?php } ?>
</select>

</div>
	
<div class="w3-container w3-third">
  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>	</div>
	
<?php

	$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฎาคม","08"=>"สิงหาคม",  "09"=>"กันยายน","10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");
	
	
	
if($_GET["mount"] !='' and $_GET["year"] !=''){
$mm = $_GET["mount"];
$yy = $_GET["year"];
	
	
$day1 = "$yy-$mm-01";	
$day2 = "$yy-$mm-02";	
$day3 = "$yy-$mm-03";	
$day4 = "$yy-$mm-04";	
$day5 = "$yy-$mm-05";	
$day6 = "$yy-$mm-06";	
$day7 = "$yy-$mm-07";	
$day8 = "$yy-$mm-08";	
$day9 = "$yy-$mm-09";	
$day10 = "$yy-$mm-10";	
$day11 = "$yy-$mm-11";	
$day12 = "$yy-$mm-12";	
$day13 = "$yy-$mm-13";	
$day14 = "$yy-$mm-14";	
$day15 = "$yy-$mm-15";	
$day16 = "$yy-$mm-16";	
$day17 = "$yy-$mm-17";	
$day18 = "$yy-$mm-18";	
$day19 = "$yy-$mm-19";	
$day20 = "$yy-$mm-20";
$day21 = "$yy-$mm-21";	
$day22 = "$yy-$mm-22";	
$day23 = "$yy-$mm-23";	
$day24 = "$yy-$mm-24";	
$day25 = "$yy-$mm-25";	
$day26 = "$yy-$mm-26";	
$day27 = "$yy-$mm-27";	
$day28 = "$yy-$mm-28";	
$day29 = "$yy-$mm-29";	
$day30 = "$yy-$mm-30";	
$day31 = "$yy-$mm-31";	
	
$thai= $_month_name[$mm];
$year =$yy+543;
$sumdate = "$yy-$mm";		
	
}else if($_GET["start_date"] !=''){
$day1 = $_GET["start_date"];
	
$sh_date = substr($day1,-2);	
	
}	

?>
	
<div class="w3-container">	
	
	<center><br>
<h4>ตารางข้อมูลการจัดส่งสินค้า</h4>
<?php		
if($_GET["mount"] !='' and $_GET["year"] !=''){		
	
	?>
<h4>เดือน <?php echo $thai; ?> ปี <?php echo $year; ?></h4>	
		
		<?php }else if($_GET["start_date"] !=''){ ?>
<h4>วันที่  <?php echo Datethai($_GET["start_date"]); ?></h4>			
		<?php } ?>
</center><br>

<?php
if($_GET["mount"] !='' or $_GET["year"] !='' or  $_GET["start_date"] !=''){	

	?>
	
	
	

<table border= "1" width="100%" class='w3-table'>
<thead>	
<tr>
<th width="2%" style="font-size: 12px; ">วันที่</th>
<th width="4%" style="font-size: 12px; ">Lazada</th>
<th width="4%" style="font-size: 12px; ">Shopee</th>
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

	
<?php	if($_GET["start_date"] !=''){	?>
	
	
	<tr>
<td><?php echo $sh_date; ?></td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day1."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day1."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day1."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
									 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day1."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day1; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
									 
									 
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day1; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day1; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day1."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day1; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day1."'  and cancel_ckk ='0'";
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
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day1."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>			

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day1."'  and cancel_ckk ='0'";
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
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day1."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day1; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day1."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day1; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>

	<?php }else if($_GET["mount"] !='' and $_GET["year"] !=''){ ?>
	
		<tr>
<td>1</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day1."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day1."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day1."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];	
		
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
		
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day1."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day1; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);

$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
			
			?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day1; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day1; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day1."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day1; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day1."'  and cancel_ckk ='0'";
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
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day1."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
			
			
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day1."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day1."'  and cancel_ckk ='0'";
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
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day1."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day1; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day1."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day1; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>2</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day2."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day2."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day2."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day2."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 

$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day2."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
		
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day2."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day2."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day2."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day2; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day2; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day2."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day2."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day2."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day2."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day2."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day2."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day2; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day2."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day2."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day2."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day2."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day2."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day2."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day2; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day2."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day2."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day2; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day2."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day2; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day2."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
		
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>				
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day2."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day2;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day2."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day2; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day2."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day2; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day2."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day2."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day2; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day2."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day2; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>3</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day3."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day3."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day3."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day3."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
		
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day3."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day3."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day3."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day3."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day3; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day3; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day3."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day3."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day3."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day3."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day3."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day3."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day3; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day3."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day3."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day3."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day3."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day3."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day3."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day3; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day3."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day3."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day3; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day3."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day3; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day3."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day3."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day3;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				

		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day3."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day3; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day3."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day3; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day3."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day3."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day3; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day3."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day3; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>4</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day4."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day4."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day4."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day4."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 

$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day4."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
									 		
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day4."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day4."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day4."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day4; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day4; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day4."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day4."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day4."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day4."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day4."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day4."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day4; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day4."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day4."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day4."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day4."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day4."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day4."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day4; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day4."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day4."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day4; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day4."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day4; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day4."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day4."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day4;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day4."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day4; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day4."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day4; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day4."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day4."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day4; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day4."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day4; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>5</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day5."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day5."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day5."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day5."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day5."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
		
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day5."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day5."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day5."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day5; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day5; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day5."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day5."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day5."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day5."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day5."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day5."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day5; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day5."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day5."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day5."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day5."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day5."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day5."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day5; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day5."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day5."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day5; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day5."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day5; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day5."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day5."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day5;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				

		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day5."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day5; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day5."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day5; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day5."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day5."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day5; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day5."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day5; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>6</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day6."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day6."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day6."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day6."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 

$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day6."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
		
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day6."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day6."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day6."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day6; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day6; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day6."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day6."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day6."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day6."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day6."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day6."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day6; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day6."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day6."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day6."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day6."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day6."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day6."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day6; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day6."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day6."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day6; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day6."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day6; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day6."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day6."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day6;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day6."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day6; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day6."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day6; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day6."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day6."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day6; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day6."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day6; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>7</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day7."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day7."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day7."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day7."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 

$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day7."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
		
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day7."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day7."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day7."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day7; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day7; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day7."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day7."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day7."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day7."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day7."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day7."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day7; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day7."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day7."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day7."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day7."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day7."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day7."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day7; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day7."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day7."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day7; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day7."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day7; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day7."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day7."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day7;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day7."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day7; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day7."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day7; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day7."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day7."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day7; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day7."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day7; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>8</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day8."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day8."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day8."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day8."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day8."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day8."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day8."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day8."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day8; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day8; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day8."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day8."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day8."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day8."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day8."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day8."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day8; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day8."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day8."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day8."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day8."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day8."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day8."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day8; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day8."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day8."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day8; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day8."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day8; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day8."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day8."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day8;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day8."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day8; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day8."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day8; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day8."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day8."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day8; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day8."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day8; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>9</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day9."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day9."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day9."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day9."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day9."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
									 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day9."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day9."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day9."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day9; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day9; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day9."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day9."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day9."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day9."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day9."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day9."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day9; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day9."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day9."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day9."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day9."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day9."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day9."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day9; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day9."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day9."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day9; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day9."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day9; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day9."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day9."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day9;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day9."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day9; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day9."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day9; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day9."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day9."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day9; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day9."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day9; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>10</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day10."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day10."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day10."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day10."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day10."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day10."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day10."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day10."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day10; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day10; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day10."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day10."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day10."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day10."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day10."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day10."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day10; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day10."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day10."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day10."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day10."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day10."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day10."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day10; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day10."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day10."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day10; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day10."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day10; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day10."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
		
		
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>				
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day10."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day10; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day10."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day10; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day10."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day10."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day10; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day10."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day10; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>11</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day11."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day11;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day11."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day11;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day11."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day11."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day11;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day11."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day11."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day11."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day11;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day11."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day11."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day11."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day11; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day11."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day11."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day11; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day11."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day11."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day11."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day11."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day11."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day11."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day11; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day11."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day11."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day11."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day11."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day11."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day11."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day11; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day11."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day11."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day11; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day11."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day11;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day11."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day11; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day11."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day11."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day11;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day11."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day11;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day11."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day11;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day11."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day11;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day11."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day11;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day11."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day11;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day11."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day11;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day11."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day11;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day11."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day11;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day10."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day10;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day11."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day11; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day11."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day11; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day11."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day11."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day11; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day11."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day11; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>12</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day12."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day12."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day12."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day12."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day12."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day12."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day12."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day12."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day12; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day12; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day12."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day12."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day12."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day12."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day12."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day12."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day12; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day12."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day12."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day12."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day12."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day12."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day12."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day12; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day12."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day12."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day12; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day12."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day12; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day12."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day12."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day12;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day12."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day12; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day12."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day12; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day12."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day12."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day12; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day12."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day12; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>13</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day13."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day13."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day13."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day13."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day13."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day13."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day13."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day13."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day13; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day13+$Num_Rows_13; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day13."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day13."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day13."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day13."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day13."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day13."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day13; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day13."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day13."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day13."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day13."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day13."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day13."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day13; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day13."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day13."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day13; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day13."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day13; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day13."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day13."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day13;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day13."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day13; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day13."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day13; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day13."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day13."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day13; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day13."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day13; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	
	<tr>
<td>14</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day14."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day14."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day14."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day14."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day14."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day14."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day14."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day14."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day14; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day14; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day14."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day14."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day14."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day14."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day14."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day14."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day14; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day14."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day14."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day14."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day14."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day14."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day14."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day14; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day14."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day14."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day14; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day14."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day14; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day14."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day14."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day14;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day14."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day14; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day14."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day14; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day14."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day14."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day14; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day14."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day14; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>15</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day15."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day15."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day15."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day15."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day15."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day15."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day15."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day15."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day15; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day15; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day15."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day15."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day15."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day15."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day15."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day15."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day15; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day15."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day15."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day15."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day15."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day15."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day15."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day15; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day15."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day15."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day15; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day15."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day15; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day15."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day15."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day15;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day15."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day15; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day15."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day15; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day15."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day15."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day15; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day15."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day15; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>16</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day16."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day16."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day16."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day16."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day16."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day16."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day16."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day16."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day16; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day16; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day16."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day16."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day16."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day16."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day16."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day16."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day16; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day16."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day16."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day16."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day16."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day16."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day16."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day16; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day16."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day16."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day16; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day16."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day16; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day16."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day16."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day16;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day16."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day16; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day16."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day16; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day16."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day16."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day16; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day16."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day16; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>17</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day17."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day17."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day17."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day17."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
		
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day17."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day17."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day17."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day17."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day17; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
	
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day17; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day17."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day17."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day17."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day17."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day17."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day17."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day17; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day17."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day17."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day17."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day17."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day17."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day17."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day17; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day17."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day17."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day17; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day17."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day17; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day17."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day17."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day17;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day17."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day17; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day17."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day17; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day17."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day17."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day17; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day17."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day17; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>18</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day18."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day18."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day18."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day18."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];	
		
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day18."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day18."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day18."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day18."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day18; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day18; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day18."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day18."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day18."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day18."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day18."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day18."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day18; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day18."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day18."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day18."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day18."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day18."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day18."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day18; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day18."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day18."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day18; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day18."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day18; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day18."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day18."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day18;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day18."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day18; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day18."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day18; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day18."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day18."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day18; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day18."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day18; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>19</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day19."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day19."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day19."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day19."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day19."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day19."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day19."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day19."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day19; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day19; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day19."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day19."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day19."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day19."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day19."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day19."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day19; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day19."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day19."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day19."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day19."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day19."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day19."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day19; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day19."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day19."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day19; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day19."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day19; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day19."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day19."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day19;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day19."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day19; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day19."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day19; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day19."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day19."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day19; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day19."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day19; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>20</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day20."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day20."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day20."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day20."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];	
		
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day20."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day20."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day20."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day20."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day20; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day20; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day20."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day20."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day20."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day20."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day20."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day20."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day20; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day20."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day20."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day20."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day20."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day20."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day20."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day20; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day20."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day20."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day20; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day20."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day20; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day20."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day20."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day20;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day20."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day20; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day20."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day20; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day20."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day20."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day20; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day20."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day20; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>21</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day21."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day21."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day21."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day21."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];	
		
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day21."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day21."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day21."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day21."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day21; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day21; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day21."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day21."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day21."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day21."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day21."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day21."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day21; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day21."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day21."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day21."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day21."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day21."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day21."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day21; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day21."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day21."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day21; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day21."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day21; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day21."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day21."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day21;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day21."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day21; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day21."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day21; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day21."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day21."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day21; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day21."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day21; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>22</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day22."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day22."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day22."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day22."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day22."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day22."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day22."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day22."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day22; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day22; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day22."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day22."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day22."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day22."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day22."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day22."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day22; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day22."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day22."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day22."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day22."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day22."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day22."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day22; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day22."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day22."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day22; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day22."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day22; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day22."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day22."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day22;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day22."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day22; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day22."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day22; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day22."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day22."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day22; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day22."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day22; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>23</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day23."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day23."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day23."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day23."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day23."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day23."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day23."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day23."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day23; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day23; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day23."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day23."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day23."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day23."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day23."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day23."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day23; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day23."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day23."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day23."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day23."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day23."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day23."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day23; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day23."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day23."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day23; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day23."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day23; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day23."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day23."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day23;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day23."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day23; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day23."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day23; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day23."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day23."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day23; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day23."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day23; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>24</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day24."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day24."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day24."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day24."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day24."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day24."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day24."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
					 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day24."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day24; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day24; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day24."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day24."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day24."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day24."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day24."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day24."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day24; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day24."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day24."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day24."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day24."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day24."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day24."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day24; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day24."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day24."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day24; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day24."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day24; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day24."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day24."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day24;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day24."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day24; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day24."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day24; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day24."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day24."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day24; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day24."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day24; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>25</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day25."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day25."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day25."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day25."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day25."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day25."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day25."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day25."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day25; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day25; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day25."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day25."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day25."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day25."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day25."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day25."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day25; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day25."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day25."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day25."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day25."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day25."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day25."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day25; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day25."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day25."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day25; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day25."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day25; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day25."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day25."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day25;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day25."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day25; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day25."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day25; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day25."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day25."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day25; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day25."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day25; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>26</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day26."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day26."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day26."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day26."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];	
		
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day26."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
		
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day26."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day26."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day26."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day26; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
			
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day26; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day26."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day26."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day26."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day26."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day26."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day26."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day26; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day26."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day26."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day26."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day26."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day26."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day26."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day26; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day26."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day26."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day26; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day26."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day26; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day26."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day26."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day26;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
		
			
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day26."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day26; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day26."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day26; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day26."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day26."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day26; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day26."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day26; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>27</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day27."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day27."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day27."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day27."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day27."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day27."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day27."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day27."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day27; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day27; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day27."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day27."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day27."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day27."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day27."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day27."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day27; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day27."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day27."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day27."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day27."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day27."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day27."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day27; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day27."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day27."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day27; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day27."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day27; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day27."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day27."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day27;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day27."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day27; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day27."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day27; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day27."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day27."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day27; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day27."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day27; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>28</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day28."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day28."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day28."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day28."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day28."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day28."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day28."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day28."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day28; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day28; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day28."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day28."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day28."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day28."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day28."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day28."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day28; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day28."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day28."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day28."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day28."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day28."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day28."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day28; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day28."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day28."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day28; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day28."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day28; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day28."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day28."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day28;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day28."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day28; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day28."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day28; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day28."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day28."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day28; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day28."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day28; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>29</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day29."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day29."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day29."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day29."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day29."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day29."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day29."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day29."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day29; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day29; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day29."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day29."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day29."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day29."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day29."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day29."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day29; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day29."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day29."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day29."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day29."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day29."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day29."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day29; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day29."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day29."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day29; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day29."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day29; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day29."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day29."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day29;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day29."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day29; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day29."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day29; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>			
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day29."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day29."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day29; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day29."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day29; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>30</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day30."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day30."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day30."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day30."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day30."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day30."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day30."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day30."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day30; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day30; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day30."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day30."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day30."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day30."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day30."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day30."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day30; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day30."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day30."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day30."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day30."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day30."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day30."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day30; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day30."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day30."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day30; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day30."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day30; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day30."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day30."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day30;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day30."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day30; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day30."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day30; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day30."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day30."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day30; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day30."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day30; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>
	
	<tr>
<td>31</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date='".$day31."' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows1; ?></a>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '12'; ?>" target="_blank"><?php echo $Num_Rows2; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date='".$day31."'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows10+$objResult["count_box"]; ?></a></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day31."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date='".$day31."'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date='".$day31."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>" target="_blank"><?php echo $Num_Rows11+$count_awl1+$Num_Rows_11; ?></a></td>		
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day31."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date='".$day31."'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date='".$day31."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
					 
									 
	?>
	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day31; ?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows12+$count_nbm1+$Num_Rows_12; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41' and delivery='4' and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
	?>
	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day31; ?>&sale_channel=<?php echo '3'; ?>&delivery=<?php echo '4'; ?>" target="_blank"><?php echo $Num_Rows13+$Num_Rows_13; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date='".$day31."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day31."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day31."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day31."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day31."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day31."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day31; ?>&type_company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day31."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day31."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day31."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day31."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day31."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day31."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day31; ?>&type_company=<?php echo 'โนเบิล เมด บจก.'; ?>&ref_id=<?php echo 'SO'; ?>" target="_blank"><?php echo $Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day31."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day31."' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day31; ?>&ref_id=<?php echo 'CH'; ?>" target="_blank"><?php echo $Num_Rows17+$Num_Rows_17; ?></a></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '20'; ?>" target="_blank"><?php echo $Num_Rows3; ?></a></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date='".$day31."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><a href="status_delothshow.php?type_del=<?php echo 'ไปรษณีย์';?>&del_date=<?php echo $day31; ?>" target="_blank"><?php echo $Num_Rows20; ?></a></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '25'; ?>&delivery=<?php echo '23'; ?>" target="_blank"><?php echo $Num_Rows6+$Num_Rows7; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '38'; ?>&delivery=<?php echo '34'; ?>" target="_blank"><?php echo $Num_Rows8; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '22'; ?>" target="_blank"><?php echo $Num_Rows22; ?></a></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '31'; ?>" target="_blank"><?php echo $Num_Rows37; ?></a></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '31'; ?>&delivery=<?php echo '7'; ?>" target="_blank"><?php echo $Num_Rows87; ?></a></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '32'; ?>" target="_blank"><?php echo $Num_Rows38; ?></a></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date='".$day31."' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '33'; ?>" target="_blank"><?php echo $Num_Rows41; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '34'; ?>; ?>" target="_blank"><?php echo $Num_Rows42; ?></a></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '35'; ?>; ?>" target="_blank"><?php echo $Num_Rows43; ?></a></td>		
		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '39'; ?>; ?>" target="_blank"><?php echo $Num_Rows44; ?></a></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date='".$day31."'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><a href="status_keryecom.php?delivery_date=<?php echo $day31;?>&sale_channel=<?php echo '40'; ?>; ?>" target="_blank"><?php echo $Num_Rows45; ?></a></td>				
		
		
<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day31."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);

									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'Kerry';?>&del_date=<?php echo $day31; ?>" target="_blank"><?php echo $Num_Rows21; ?></a></td>	



<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day31."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
<td><a href="status_delothshow.php?type_del=<?php echo 'SPX Express';?>&del_date=<?php echo $day31; ?>" target="_blank"><?php echo $Num_Rows_21; ?></a></td>		
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date='".$day31."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day31."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><a href="status_keryhospi.php?address_1=<?php echo "kerry/SPX";?>&start_date=<?php echo $day31; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows18+$Num_Rows_18; ?></a></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date='".$day31."' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><a href="status_keryhospi.php?address_1=<?php echo "ไปรษณี";?>&start_date=<?php echo $day31; ?>&ref_id=<?php echo 'SMP'; ?>" target="_blank"><?php echo $Num_Rows19; ?></a></td>
			
<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45+$Num_Rows_13+$Num_Rows_12+$Num_Rows_11; ?></td>		

</tr>	
	
		<tr>
<td>ยอดรวม</td>	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='1'  and delivery_date LIKE '%$sumdate%' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);

?>
<td>
	<?php echo number_format($Num_Rows1,0).""; ?>
	</td>	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='12'  and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows2 = mysqli_num_rows($objQuery);

?>
<td><?php echo number_format($Num_Rows2,0).""; ?></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4' and delivery !='6'   and delivery !='4' and delivery !='7' and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows10 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4' and delivery !='6' and delivery !='4' and delivery !='7'  and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>

<td><?php echo number_format($Num_Rows10+$objResult["count_box"],0).""; ?></td>		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date LIKE '%$sumdate%' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows11 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3' and delivery !='4' and delivery !='6'  and delivery !='7' and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0' and select_type_doc='3' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];									 
									 
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6' and delivery !='4' and delivery !='7' and delivery_date LIKE '%$sumdate%' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_11 = mysqli_num_rows($objQuery);

									 
	?>
	
<td><?php echo number_format($Num_Rows11+$Num_Rows_11+$count_awl1,0).""; ?></td>	
	
	<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date LIKE '%$sumdate%' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows12 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery !='6'  and delivery !='4'  and delivery !='7' and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0' and select_type_doc='4' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult1 = mysqli_fetch_array($objQuery);									 
$count_nbm1 = $objResult1["count_box"];									 

$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='41'  and delivery !='6'  and delivery !='7'  and delivery !='4' and delivery_date LIKE '%$sumdate%' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_12 = mysqli_num_rows($objQuery);
		
									 
	?>
	
<td><?php echo number_format($Num_Rows12+$Num_Rows_12+$count_nbm1,0).""; ?></a></td>	
	
	
<?php
	
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows13 = mysqli_num_rows($objQuery);
		
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3' and delivery='4' and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_13 = mysqli_num_rows($objQuery);
		
	?>
	
	<td><?php echo number_format($Num_Rows13+$Num_Rows_13,0).""; ?></a></td>	
	
	<?php
	
$strSQL = "SELECT start_date  FROM tb_register_data where address_1 LIKE '%kerry%' and start_date LIKE '%$sumdate%' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date LIKE '%$sumdate%' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date LIKE '%$sumdate%' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%$sumdate%' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_14 = mysqli_num_rows($objQuery);

$strSQL = "SELECT  SUM(count_box) AS count_box   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%$sumdate%' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");									 
$objResult_21 = mysqli_fetch_array($objQuery);									 
								 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%$sumdate%' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_15 = mysqli_num_rows($objQuery);	
									 
									 
	?>
	
	<td><?php echo number_format($Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"],0).""; ?></a></td>	
	
	
	<?php
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date LIKE '%$sumdate%' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date LIKE '%$sumdate%' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date LIKE '%$sumdate%' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);	
									 
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%$sumdate%' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_16 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%$sumdate%' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SO%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult_22 = mysqli_fetch_array($objQuery);									 
									 
	
$strSQL = "SELECT start_date    FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%$sumdate%' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);
									 
	?>
	
		
	<td><?php echo number_format($Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"],0).""; ?></a></td>
	<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date LIKE '%$sumdate%' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows17 = mysqli_num_rows($objQuery);
									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%$sumdate%' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_17 = mysqli_num_rows($objQuery);									 
	
	?>
	
	<td><?php echo number_format($Num_Rows17+$Num_Rows_17,0).""; ?></td>
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='20' and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows3 = mysqli_num_rows($objQuery);

?>	
	<td><?php echo number_format($Num_Rows3,0).""; ?></td>

	<?php 
	$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='ไปรษณีย์' and del_date LIKE '%$sumdate%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows20 = mysqli_num_rows($objQuery);
 ?>
	<td><?php echo number_format($Num_Rows20,0).""; ?></td>
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='25' and delivery='23' and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows6 = mysqli_num_rows($objQuery);

$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='30' and delivery='23' and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows7 = mysqli_num_rows($objQuery);	
	
?>	
<td><?php echo number_format($Num_Rows6+$Num_Rows7,0).""; ?></td>	
	
	<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='38' and delivery='34' and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows8 = mysqli_num_rows($objQuery);

?>	
	<td><?php echo number_format($Num_Rows8,0).""; ?></td>	
	
	
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='22' and delivery!='7' and delivery!='6' and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows22 = mysqli_num_rows($objQuery);

?>	
	<td><?php echo number_format($Num_Rows22,0).""; ?></td>
	
		<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31'  and delivery!='7' and delivery!='6' and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows37 = mysqli_num_rows($objQuery);

?>	
	<td><?php echo number_format($Num_Rows37,0).""; ?></td>	

<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='31' and delivery='7' and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows87 = mysqli_num_rows($objQuery);

?>	
	<td><?php echo number_format($Num_Rows87,0).""; ?></td>		
		
<?php
	
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='32' and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows38 = mysqli_num_rows($objQuery);

?>	
	<td><?php echo number_format($Num_Rows38,0).""; ?></td>	
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='33'  and delivery_date LIKE '%$sumdate%' and delivery!='7' and delivery!='6' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows41 = mysqli_num_rows($objQuery);
?>	
	<td><?php echo number_format($Num_Rows41,0).""; ?></td>		
		
<?php
$strSQL = "SELECT DISTINCT order_id   FROM so__main  where sale_channel='34'  and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows42 = mysqli_num_rows($objQuery);
?>	
	<td><?php echo number_format($Num_Rows42,0).""; ?></td>		
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='35'  and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows43 = mysqli_num_rows($objQuery);
?>	
	<td><?php echo number_format($Num_Rows43,0).""; ?></td>			
<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='39'  and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows44 = mysqli_num_rows($objQuery);
?>	
	<td><?php echo $Num_Rows44; ?></td>				

<?php
$strSQL = "SELECT DISTINCT ref_id   FROM so__main  where sale_channel='40'  and delivery_date LIKE '%$sumdate%'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows45 = mysqli_num_rows($objQuery);
?>	
	<td><?php echo $Num_Rows45; ?></td>				
				

<?php 
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date LIKE '%$sumdate%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows21 = mysqli_num_rows($objQuery);
		?>
	<td><?php echo number_format($Num_Rows21,0).""; ?></td>			
<?php
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date LIKE '%$sumdate%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
									 
 ?>
	<td><?php echo number_format($Num_Rows_21,0).""; ?></td>	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%kerry%' and start_date LIKE '%$sumdate%' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows18 = mysqli_num_rows($objQuery);

									 
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date LIKE '%$sumdate%' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_18 = mysqli_num_rows($objQuery);
									 
	?>
	
		<td><?php echo number_format($Num_Rows18+$Num_Rows_18,0).""; ?></td>
	
<?php
	
$strSQL = "SELECT ref_id   FROM tb_register_data  where address_1 LIKE '%ไปรษณี%' and start_date LIKE '%$sumdate%' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows19 = mysqli_num_rows($objQuery);
	
	?>
	
			<td><?php echo number_format($Num_Rows19,0).""; ?></td>
			
<td><?php echo number_format($Num_Rows1+$Num_Rows2+$Num_Rows10+$objResult["count_box"]+$Num_Rows11+$count_awl1+$Num_Rows12+$count_nbm1+$Num_Rows13+$Num_Rows14+$Num_Rows15+$objResult21["count_box"]+$Num_Rows_14+$Num_Rows_15+$objResult_21["count_box"]+$Num_Rows16+$Num_Rows17+$objResult22["count_box"]+$Num_Rows_16+$Num_Rows_17+$objResult_22["count_box"]+$Num_Rows17+$Num_Rows_17+$Num_Rows20+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows22+$Num_Rows37+$Num_Rows87+$Num_Rows38+$Num_Rows41+$Num_Rows42+$Num_Rows43+$Num_Rows21+$Num_Rows_21+$Num_Rows18+$Num_Rows_18+$Num_Rows19+$Num_Rows44+$Num_Rows45,0).""; ?></td>		

</tr>
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	<?php } ?>
	
	
</table><br>
	
<?php }
	?>
<br><br>

 </div></div>	
<div id="cr_bar"> <?php include "foot.php"; ?></div>		 
</form>
</body>
