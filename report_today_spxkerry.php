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
	<div class="w3-panel w3-light-gray"><h4>ตารางแจ้งการจัดส่ง SPX&Kerry</h4></div>

	<div class="w3-container w3-third">
		วันที่
	<input type='date' name="start_date" class="w3-select" id="start_date"  value ="<?php echo $_GET["start_date"];  ?>" >	
		</div>


<div class="w3-container w3-third">
  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>	</div>
	
<?php

$day1 = $_GET["start_date"];
	

?>
	
<div class="w3-container">	

	<center><br>
<h4>ตารางแจ้งการจัดส่ง SPX&Kerry</h4>
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
<div class="w3-container">	
<div class="w3-container w3-half">	
	
	
	
<table border= "1" width="100%" class='w3-table'>	
<tr><td bgcolor='red'>ขนส่ง SPX Express</td></tr>	
</table>	

<table border= "1" width="100%" class='w3-table'>	
<tr><td bgcolor='Linen'>Allwell</td></tr>	
</table>		
	
<table border= "1" width="100%" class='w3-table'>

<tr>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">99HM</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">99HM (COD)</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">Hospital</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">Hospital (COD)</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">German Bed</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">Homepro</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">KTC</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">24 Shopping</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">OFM</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">Allwell Bed</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">Noc Noc</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">อื่นๆ</th>
</tr>
	
	
	
<tr>
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$hm =$Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $hm; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery ='36' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery ='36' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];	
$hmcod=$Num_Rows1+$count_awl1;
	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '36'; ?>" target="_blank"><?php echo $hmcod; ?></a></th>

	
<?php
$strSQL = "SELECT start_date  FROM (tb_register_data LEFT JOIN hos__so ON tb_register_data.ref_id=hos__so.ref_id) where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_doc='3' and status_doc ='Approve' and payment!='29' and payment!='26'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%CH%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows16 = mysqli_num_rows($objQuery);
	

$hos = 	$Num_Rows14+$Num_Rows15+$Num_Rows16;
	
?>	
	
	
	
<th width="4%" style="font-size: 12px; "><a href="status_spxhos.php?address_1=<?php echo "SPX";?>&start_date=<?php echo $day1; ?>&company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&type_doc=<?php echo "3"; ?>" target="_blank"><?php echo $hos; ?></a></th>
	
<?php
$strSQL = "SELECT start_date  FROM (tb_register_data LEFT JOIN hos__so ON tb_register_data.ref_id=hos__so.ref_id) where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_doc='3' and status_doc ='Approve' and payment='29'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);
	
$hoscod = 	$Num_Rows14;
	
?>		
	
<th width="4%" style="font-size: 12px; "><a href="status_spxhos.php?address_1=<?php echo "SPX";?>&start_date=<?php echo $day1; ?>&company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&payment=<?php echo '29'; ?>&type_doc=<?php echo "3"; ?>" target="_blank"><?php echo $hoscod; ?></a></th>
	
	
	
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$gm = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '4'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $gm; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='33'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='33'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];	
$home=$Num_Rows1+$count_awl1;	
	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '33'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $home; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='35'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='35'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$ktc = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '35'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $ktc; ?></a></th>
	
	
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='22'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='22'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$shop = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '22'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $shop; ?></a></th>

	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='31'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='31'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$ofm =$Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '31'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $ofm; ?></a></th>
	
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='20'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='20'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$bed = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '20'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $bed; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='32'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='32'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$noc =$Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '32'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $noc; ?></a></th>
	
	
<?php
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day1."' and company='1'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);
	
	
?>
	
<th width="4%" style="font-size: 12px; "><a href="status_delpsxkerry.php?del_date=<?php echo $day1;?>&type_del=<?php echo 'SPX Express'; ?>&company=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows_21+$Num_Rows15; ?></a></th>
	
</tr>	
</table>
	
<table border= "1" width="100%" class='w3-table'>	
<tr><td bgcolor='Linen'>Noble Med</td></tr>	
</table>		
	
<table border= "1" width="100%" class='w3-table'>

<tr>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">99HM</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">99HM (COD)</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">Hospital</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">Hospital (COD)</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">German Bed</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">Homepro</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">KTC</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">24 Shopping</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">OFM</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">Allwell Bed</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">Noc Noc</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">อื่นๆ</th>
</tr>
	
	
	
<tr>
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$hmnb =$Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $hmnb; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery ='36' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery ='36' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];	
$hmcodnb=$Num_Rows1+$count_awl1;
	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '36'; ?>" target="_blank"><?php echo $hmcodnb; ?></a></th>

<?php
$strSQL = "SELECT start_date  FROM (tb_register_data LEFT JOIN hos__so ON tb_register_data.ref_id=hos__so.ref_id) where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_doc='4' and status_doc ='Approve' and payment!='29' and payment!='26'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);

$hosnb = 	$Num_Rows14+$Num_Rows15;
	
?>	
	
	
	
<th width="4%" style="font-size: 12px; "><a href="status_spxhos.php?address_1=<?php echo "SPX";?>&start_date=<?php echo $day1; ?>&company=<?php echo 'โนเบิล เมด บจก.'; ?>&type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $hosnb; ?></a></th>
	
<?php
$strSQL = "SELECT start_date  FROM (tb_register_data LEFT JOIN hos__so ON tb_register_data.ref_id=hos__so.ref_id) where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_doc='4' and status_doc ='Approve' and payment='29'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);
	
$hoscodnb = 	$Num_Rows14;
	
?>		
	
<th width="4%" style="font-size: 12px; "><a href="status_spxhos.php?address_1=<?php echo "SPX";?>&start_date=<?php echo $day1; ?>&company=<?php echo 'โนเบิล เมด บจก.'; ?>&payment=<?php echo '29'; ?>&type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $hoscodnb; ?></a></th>
	
		
	
	
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$gmnb = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '4'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $gmnb; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='33'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='33'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];	
$homenb=$Num_Rows1+$count_awl1;	
	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '33'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $homenb; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='35'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='35'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$ktcnb = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '35'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $ktcnb; ?></a></th>
	
	
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='22'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='22'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$shopnb = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '22'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $shopnb; ?></a></th>

	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='31'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='31'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$ofmnb =$Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '31'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $ofmnb; ?></a></th>
	
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='20'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='20'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$bednb = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '20'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $bednb; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='32'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='32'  and delivery ='35' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$nocnb =$Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '32'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '35'; ?>" target="_blank"><?php echo $nocnb; ?></a></th>
	
	
<?php
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='SPX Express' and del_date='".$day1."' and company='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_22 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%SPX%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rowsnb15 = mysqli_num_rows($objQuery);
	
	
?>
	
<th width="4%" style="font-size: 12px; "><a href="status_delpsxkerry.php?del_date=<?php echo $day1;?>&type_del=<?php echo 'SPX Express'; ?>&company=<?php echo '2'; ?>" target="_blank"><?php echo $Num_Rows_22+$Num_Rowsnb15; ?></a></th>
	
</tr>	
</table>	
<br><br>	
</div><div class="w3-container w3-half">
<center>
<table border= "1" width="100%" class='w3-table'>	
<tr><td bgcolor='red'>สรุป SPX Express</td></tr>	
</table>		
<table border= "1" width="100%" class='w3-table'>

<tr>
<th width="4%" bgcolor='#D3D3D3' style="font-size: 12px; "></th>
<th width="4%" bgcolor='#D3D3D3' style="font-size: 12px; ">NON-COD</th>
<th width="4%" bgcolor='#D3D3D3' style="font-size: 12px; ">COD</th>	
</tr>

<tr>
<th width="4%"  style="font-size: 12px; ">ออลล์เวล ไลฟ์</th>
<th width="4%"  style="font-size: 12px; "><?php echo $hm+$gm+$home+$ktc+$shop+$noc+$ofm+$bed+$Num_Rows_21+$hos+$Num_Rows15; ?></th>
<th width="4%"  style="font-size: 12px; "><?php echo $hmcod+$hoscod; ?></th>	
</tr>
	
<tr>
<th width="4%"  style="font-size: 12px; ">โนเบิล เมด</th>
<th width="4%"  style="font-size: 12px; "><?php echo $hmnb+$gmnb+$homenb+$ktcnb+$shopnb+$nocnb+$ofmnb+$bednb+$Num_Rows_22+$hosnb+$Num_Rowsnb15; ?></th>
<th width="4%"  style="font-size: 12px; "><?php echo $hmcodnb+$hoscodenb; ?></th>	
</tr>	
	
</table>	
	
	
</center>	
</div></div>	
<div class="w3-container w3-half">

<table border= "1" width="100%" class='w3-table'>	
<tr><td bgcolor='#FF6600'>ขนส่ง Kerry</td></tr>	
</table>	

<table border= "1" width="100%" class='w3-table'>	
<tr><td bgcolor='Linen'>Allwell</td></tr>	
</table>		
	
<table border= "1" width="100%" class='w3-table'>

<tr>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">99HM</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">99HM (COD)</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">Hospital</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">Hospital (COD)</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">German Bed</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">Homepro</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">KTC</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">24 Shopping</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">OFM</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">Allwell Bed</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">Noc Noc</th>
<th width="4%" bgcolor='#CC99FF' style="font-size: 12px; ">อื่นๆ</th>
</tr>
	
	
	
<tr>
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$hm =$Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $hm; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery ='2' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery ='2' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];	
$hmcod=$Num_Rows1+$count_awl1;
	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '2'; ?>" target="_blank"><?php echo $hmcod; ?></a></th>

<?php
$strSQL = "SELECT start_date  FROM (tb_register_data LEFT JOIN hos__so ON tb_register_data.ref_id=hos__so.ref_id) where address_1 LIKE '%Kerry%' and start_date='".$day1."' and type_doc='3' and status_doc ='Approve' and payment!='29' and payment!='26'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%Kerry%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);

$hos = 	$Num_Rows14+$Num_Rows15;
	
?>	
	
	
	
<th width="4%" style="font-size: 12px; "><a href="status_spxhos.php?address_1=<?php echo "Kerry";?>&start_date=<?php echo $day1; ?>&company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&type_doc=<?php echo "3"; ?>" target="_blank"><?php echo $hos; ?></a></th>
	
<?php
$strSQL = "SELECT start_date  FROM (tb_register_data LEFT JOIN hos__so ON tb_register_data.ref_id=hos__so.ref_id) where address_1 LIKE '%Kerry%' and start_date='".$day1."' and type_doc='3' and status_doc ='Approve' and payment='26'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);
	
$hoscod = 	$Num_Rows14;
	
?>		
	
<th width="4%" style="font-size: 12px; "><a href="status_spxhos.php?address_1=<?php echo "Kerry";?>&start_date=<?php echo $day1; ?>&company=<?php echo 'ออลล์เวล ไลฟ์ บจก.'; ?>&payment=<?php echo '26'; ?>&type_doc=<?php echo "3"; ?>" target="_blank"><?php echo $hoscod; ?></a></th>
	
	
	
	
	
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc='3'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$gm = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '4'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $gm; ?></a></th>
	
<?php
//and delivery ='33'
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='33'   and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
//and delivery ='33'									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='33'   and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];	
$home=$Num_Rows1+$count_awl1;	
	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '33'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $home; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='35'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='35'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$ktc = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '35'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $ktc; ?></a></th>
	
	
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='22'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='22'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$shop = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '22'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $shop; ?></a></th>

	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='31'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='31'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$ofm =$Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '31'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $ofm; ?></a></th>
	
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='20'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='20'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$bed = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '20'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $bed; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='32'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='32'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='2'  and select_type_doc !='4' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$noc =$Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '32'; ?>&select_type_doc=<?php echo '3'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $noc; ?></a></th>
	
	
<?php
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day1."' and company='1'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_21 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%Kerry%' and start_date='".$day1."' and type_company='ออลล์เวล ไลฟ์ บจก.' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);	
	
?>
	
<th width="4%" style="font-size: 12px; "><a href="status_delpsxkerry.php?del_date=<?php echo $day1;?>&type_del=<?php echo 'Kerry'; ?>&company=<?php echo '1'; ?>" target="_blank"><?php echo $Num_Rows_21+$Num_Rows15; ?></a></th>
	
</tr>	
</table>
	
<table border= "1" width="100%" class='w3-table'>	
<tr><td bgcolor='Linen'>Noble Med</td></tr>	
</table>		
	
<table border= "1" width="100%" class='w3-table'>

<tr>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">99HM</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">99HM (COD)</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">Hospital</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">Hospital (COD)</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">German Bed</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">Homepro</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">KTC</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">24 Shopping</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">OFM</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">Allwell Bed</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">Noc Noc</th>
<th width="4%" bgcolor='#FFCCFF' style="font-size: 12px; ">อื่นๆ</th>
</tr>
	
	
	
<tr>
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$hmnb =$Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $hmnb; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='3'  and delivery ='2' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='3'  and delivery ='2' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];	
$hmcodnb=$Num_Rows1+$count_awl1;
	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '3'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '2'; ?>" target="_blank"><?php echo $hmcodnb; ?></a></th>

<?php
$strSQL = "SELECT start_date  FROM (tb_register_data LEFT JOIN hos__so ON tb_register_data.ref_id=hos__so.ref_id) where address_1 LIKE '%Kerry%' and start_date='".$day1."' and type_doc='4' and status_doc ='Approve' and payment!='29' and payment!='26'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);
	
$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%Kerry%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%BR%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows15 = mysqli_num_rows($objQuery);

$hosnb = 	$Num_Rows14+$Num_Rows15;
	
?>	
	
	
	
<th width="4%" style="font-size: 12px; "><a href="status_spxhos.php?address_1=<?php echo "Kerry";?>&start_date=<?php echo $day1; ?>&company=<?php echo 'โนเบิล เมด บจก.'; ?>&type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $hosnb; ?></a></th>
	
<?php
$strSQL = "SELECT start_date  FROM (tb_register_data LEFT JOIN hos__so ON tb_register_data.ref_id=hos__so.ref_id) where address_1 LIKE '%Kerry%' and start_date='".$day1."' and type_doc='4' and status_doc ='Approve' and payment='26'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows14 = mysqli_num_rows($objQuery);
	
$hoscodnb = 	$Num_Rows14;
	
?>		
	
<th width="4%" style="font-size: 12px; "><a href="status_spxhos.php?address_1=<?php echo "Kerry";?>&start_date=<?php echo $day1; ?>&company=<?php echo 'โนเบิล เมด บจก.'; ?>&payment=<?php echo '29'; ?>&type_doc=<?php echo '4'; ?>" target="_blank"><?php echo $hoscodnb; ?></a></th>
	
		
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='4'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='4'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc='4'  and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$gmnb = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '4'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $gmnb; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='35'  and delivery ='33' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='35'  and delivery ='33' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];	
$homenb=$Num_Rows1+$count_awl1;	
	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '33'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $homenb; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='35'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='35'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$ktcnb = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '35'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $ktcnb; ?></a></th>
	
	
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='22'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='22'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$shopnb = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '22'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $shopnb; ?></a></th>

	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='31'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='31'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$ofmnb =$Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '31'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $ofmnb; ?></a></th>
	
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='20'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='20'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$bednb = $Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '20'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $bednb; ?></a></th>
	
<?php
$strSQL = "SELECT ref_id   FROM so__main  where sale_channel='32'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows1 = mysqli_num_rows($objQuery);
									 
									 
$strSQL = "SELECT SUM(count_box) AS count_box  FROM so__main  where sale_channel='32'  and delivery ='1' and delivery_date='".$day1."' and select_type_doc !='1'  and select_type_doc !='3' and cancel_ckk ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);									 
				 
$count_awl1 = $objResult["count_box"];		
$nocnb =$Num_Rows1+$count_awl1;	
?>	
	
<th width="4%" style="font-size: 12px; "><a href="status_newspx.php?delivery_date=<?php echo $day1;?>&sale_channel=<?php echo '32'; ?>&select_type_doc=<?php echo '4'; ?>&delivery=<?php echo '1'; ?>" target="_blank"><?php echo $nocnb; ?></a></th>
	
	
<?php
$strSQL = "SELECT type_del   FROM tb_deloth  where  type_del='Kerry' and del_date='".$day1."' and company='2'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows_22 = mysqli_num_rows($objQuery);

$strSQL = "SELECT start_date  FROM tb_register_data  where address_1 LIKE '%Kerry%' and start_date='".$day1."' and type_company='โนเบิล เมด บจก.' and ref_id LIKE '%SMP%'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rowsnb15 = mysqli_num_rows($objQuery);
	
?>
	
<th width="4%" style="font-size: 12px; "><a href="status_delpsxkerry.php?del_date=<?php echo $day1;?>&type_del=<?php echo 'Kerry'; ?>&company=<?php echo '2'; ?>" target="_blank"><?php echo $Num_Rows_22+$Num_Rowsnb15; ?></a></th>
	
</tr>	
</table>	
<br><br>	
</div><div class="w3-container w3-half">
<center>
<table border= "1" width="100%" class='w3-table'>	
<tr><td bgcolor='#FF6600'>สรุป Kerry</td></tr>	
</table>		
<table border= "1" width="100%" class='w3-table'>

<tr>
<th width="4%" bgcolor='#D3D3D3' style="font-size: 12px; "></th>
<th width="4%" bgcolor='#D3D3D3' style="font-size: 12px; ">NON-COD</th>
<th width="4%" bgcolor='#D3D3D3' style="font-size: 12px; ">COD</th>	
</tr>

<tr>
<th width="4%"  style="font-size: 12px; ">ออลล์เวล ไลฟ์</th>
<th width="4%"  style="font-size: 12px; "><?php echo $hm+$gm+$home+$ktc+$shop+$noc+$ofm+$bed+$Num_Rows_21+$hos+$Num_Rows15; ?></th>
<th width="4%"  style="font-size: 12px; "><?php echo $hmcod+$hoscod; ?></th>	
</tr>
	
<tr>
<th width="4%"  style="font-size: 12px; ">โนเบิล เมด</th>
<th width="4%"  style="font-size: 12px; "><?php echo $hmnb+$gmnb+$homenb+$ktcnb+$shopnb+$nocnb+$ofmnb+$bednb+$Num_Rows_22+$hosnb+$Num_Rowsnb15; ?></th>
<th width="4%"  style="font-size: 12px; "><?php echo $hmcodnb+$hoscodnb; ?></th>	
</tr>	
	
</table>	
	
	
</center>	
</div>	
		
	
<?php }
	?>
<br><br>

 </div></div>	
<div id="cr_bar"> <?php include "foot.php"; ?></div>		 
</form>
</body>
