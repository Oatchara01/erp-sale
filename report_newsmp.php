<?php
include "head.php";
include "dbconnect.php";
include "dbconnect_sale.php";
 
function DateThai1($strDate)
	{
		$strYear = date("y",strtotime($strDate))+43;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strMonthThai $strYear";
	}
?>		
 <div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายงานแลกเปลี่ยนสินค้า (GLUCOALL-1B)</h4></div>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">

<?php

$date_sum3 = '2024-03';
$date_sum4 = '2024-04';
$date_sum5 = '2024-05';
$date_sum6 = '2024-06';
$date_sum7 = '2024-07';
$date_sum8 = '2024-08';
$date_sum9 = '2024-09';
$date_sum10 = '2024-10';
$date_sum11 = '2024-11';
$date_sum12 = '2024-12';

?>

<br>

<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="10%" >เดือน</th>
<th width="8%" >จำนวนแลกเปลี่ยน G-426</th>
<th width="8%" >จำนวนแลกเปลี่ยน GLS</th>
<th width="8%" >จำนวนขาย</th> 
<th width="15%" >คงเหลือ G-426</th>
<th width="15%" >คงเหลือ GLS</th>	
</thead>
<?php
$strSQL = "SELECT sn FROM tb__glu426  where sn !=''";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

	
$strSQL1 = "SELECT sn FROM tb__glucos  where sn !=''";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
	
?>

<tr>
<td>ยอดขายยกมา เครื่องน้ำตาล</td>
<td></td>
<td></td>
<td></td>	
<td><?php echo number_format($Num_Rows,2).""; ?></td>
<td><?php echo number_format($Num_Rows1,2).""; ?></td>	
</tr>


<?php

$strSQL3 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum3."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล G-426%'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);
	
$strSQL3 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum3."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล GLUCOSURE%'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rowsg3 = mysqli_num_rows($objQuery3);
	

$sql3 = "SELECT SUM(count) AS count  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) where doc_date  LIKE '%".$date_sum3."%' and group_pro='501205.1 เครื่องวัดน้ำตาล - GLUCOALL' and unit_name ='เครื่อง'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);


?>

<tr>
<td><?php echo DateThai1($date_sum3);?></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum3;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล G-426" ?>"  target="_blank"><?php echo number_format($Num_Rows3,2).""; ?></a></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum3;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล GLUCOSURE" ?>"  target="_blank"><?php echo number_format($Num_Rowsg3,2).""; ?></a></td>	
<td><a href="report_smpnew22.php?date_sum=<?php echo $date_sum3;?>"  target="_blank"><?php echo number_format($rs3["count"],2).""; ?></a></td>
<td><?php echo number_format($Num_Rows-($Num_Rows3),2).""; ?></td>
<td><?php echo number_format($Num_Rows1-($Num_Rowsg3),2).""; ?></td>	
</tr>
	
	
<?php
$today = date('Y-m');
	
if($date_sum4 <= $today){	
$strSQL4 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum4."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล G-426%'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);
	
	
$strSQL4 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum4."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล GLUCOSURE%'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rowsg4 = mysqli_num_rows($objQuery4);
	
	

$sql4 = "SELECT SUM(count) AS count  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) where doc_date  LIKE '%".$date_sum4."%' and group_pro='501205.1 เครื่องวัดน้ำตาล - GLUCOALL' and unit_name ='เครื่อง'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_assoc($qry4);

?>

<tr>
<td><?php echo DateThai1($date_sum4);?></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum4;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล G-426" ?>"  target="_blank"><?php echo number_format($Num_Rows4,2).""; ?></a></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum4;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล GLUCOSURE" ?>"  target="_blank"><?php echo number_format($Num_Rowsg4,2).""; ?></a></td>
	
<td><a href="report_smpnew22.php?date_sum=<?php echo $date_sum4;?>"  target="_blank"><?php echo number_format($rs4["count"],2).""; ?></a></td>

<td><?php echo number_format($Num_Rows-($Num_Rows3+$Num_Rows4),2).""; ?></td>
<td><?php echo number_format($Num_Rows1-($Num_Rowsg3+$Num_Rowsg4),2).""; ?></td>
	
</tr>
		
	

<?php
	}
	
if($date_sum5 <= $today){	

$strSQL5 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum5."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล G-426%'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rows5 = mysqli_num_rows($objQuery5);
	
	
$strSQL5 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum5."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล GLUCOSURE%'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rowsg5 = mysqli_num_rows($objQuery5);
	
	

$sql5 = "SELECT SUM(count) AS count  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) where doc_date  LIKE '%".$date_sum5."%' and group_pro='501205.1 เครื่องวัดน้ำตาล - GLUCOALL' and unit_name ='เครื่อง'";
$qry5 = mysqli_query($conn,$sql5) or die(mysqli_error());
$rs5 = mysqli_fetch_assoc($qry5);

?>

<tr>
<td><?php echo DateThai1($date_sum5);?></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum5;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล G-426" ?>"  target="_blank"><?php echo number_format($Num_Rows5,2).""; ?></a></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum5;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล GLUCOSURE" ?>"  target="_blank"><?php echo number_format($Num_Rowsg5,2).""; ?></a></td>
	
<td><a href="report_smpnew22.php?date_sum=<?php echo $date_sum5;?>"  target="_blank"><?php echo number_format($rs5["count"],2).""; ?></a></td>

<td><?php echo number_format($Num_Rows-($Num_Rows3+$Num_Rows4+$Num_Rows5),2).""; ?></td>
<td><?php echo number_format($Num_Rows1-($Num_Rowsg3+$Num_Rowsg4+$Num_Rowsg5),2).""; ?></td>
	
</tr>


<?php

}
if($date_sum6 <= $today){	

$strSQL6 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum6."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล G-426%'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$Num_Rows6 = mysqli_num_rows($objQuery6);
	
$strSQL6 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum6."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล GLUCOSURE%'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$Num_Rowsg6 = mysqli_num_rows($objQuery6);
	
	

$sql6 = "SELECT SUM(count) AS count  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) where doc_date  LIKE '%".$date_sum6."%' and group_pro='501205.1 เครื่องวัดน้ำตาล - GLUCOALL' and unit_name ='เครื่อง'";
$qry6 = mysqli_query($conn,$sql6) or die(mysqli_error());
$rs6 = mysqli_fetch_assoc($qry6);

?>

<tr>
<td><?php echo DateThai1($date_sum6);?></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum6;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล G-426" ?>"  target="_blank"><?php echo number_format($Num_Rows6,2).""; ?></a></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum6;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล GLUCOSURE" ?>"  target="_blank"><?php echo number_format($Num_Rowsg6,2).""; ?></a></td>
<td><a href="report_smpnew22.php?date_sum=<?php echo $date_sum6;?>"  target="_blank"><?php echo number_format($rs6["count"],2).""; ?></a></td>

<td><?php echo number_format($Num_Rows-($Num_Rows3+$Num_Rows4+$Num_Rows5+$Num_Rows6),2).""; ?></td>
<td><?php echo number_format($Num_Rows1-($Num_Rowsg3+$Num_Rowsg4+$Num_Rowsg5+$Num_Rowsg6),2).""; ?></td>
	
</tr>

<?php
}
if($date_sum7 <= $today){	

$strSQL7 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum7."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล G-426%'";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);
	
$strSQL7 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum7."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล GLUCOSURE%'";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rowsg7 = mysqli_num_rows($objQuery7);
	

$sql7 = "SELECT SUM(count) AS count  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) where doc_date  LIKE '%".$date_sum7."%' and group_pro='501205.1 เครื่องวัดน้ำตาล - GLUCOALL' and unit_name ='เครื่อง'";
$qry7 = mysqli_query($conn,$sql7) or die(mysqli_error());
$rs7 = mysqli_fetch_assoc($qry7);

?>

<tr>
<td><?php echo DateThai1($date_sum7);?></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum7;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล G-426" ?>"  target="_blank"><?php echo number_format($Num_Rows7,2).""; ?></a></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum7;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล GLUCOSURE" ?>"  target="_blank"><?php echo number_format($Num_Rowsg7,2).""; ?></a></td>
<td><a href="report_smpnew22.php?date_sum=<?php echo $date_sum7;?>"  target="_blank"><?php echo number_format($rs7["count"],2).""; ?></a></td>

<td><?php echo number_format($Num_Rows-($Num_Rows3+$Num_Rows4+$Num_Rows5+$Num_Rows6+$Num_Rows7),2).""; ?></td>
<td><?php echo number_format($Num_Rows1-($Num_Rowsg3+$Num_Rowsg4+$Num_Rowsg5+$Num_Rowsg6+$Num_Rowsg7),2).""; ?></td>
</tr>
		
<?php
}
if($date_sum8 <= $today){	

$strSQL8 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum8."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล G-426%'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$Num_Rows8 = mysqli_num_rows($objQuery8);
	
$strSQL8 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum8."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล GLUCOSURE%'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$Num_Rowsg8 = mysqli_num_rows($objQuery8);
	
	

$sql8 = "SELECT SUM(count) AS count  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) where doc_date  LIKE '%".$date_sum8."%' and group_pro='501205.1 เครื่องวัดน้ำตาล - GLUCOALL' and unit_name ='เครื่อง'";
$qry8 = mysqli_query($conn,$sql8) or die(mysqli_error());
$rs8 = mysqli_fetch_assoc($qry8);

?>

<tr>
<td><?php echo DateThai1($date_sum8);?></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum8;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล G-426" ?>"  target="_blank"><?php echo number_format($Num_Rows8,2).""; ?></a></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum8;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล GLUCOSURE" ?>"  target="_blank"><?php echo number_format($Num_Rows8,2).""; ?></a></td>

<td><a href="report_smpnew22.php?date_sum=<?php echo $date_sum8;?>"  target="_blank"><?php echo number_format($rs8["count"],2).""; ?></a></td>

<td><?php echo number_format($Num_Rows-($Num_Rows3+$Num_Rows4+$Num_Rows5+$Num_Rows6+$Num_Rows7+$Num_Rows8),2).""; ?></td>
<td><?php echo number_format($Num_Rows1-($Num_Rowsg3+$Num_Rowsg4+$Num_Rowsg5+$Num_Rowsg6+$Num_Rowsg7+$Num_Rowsg8),2).""; ?></td>

	</tr>
			
<?php
}
if($date_sum9 <= $today){	

$strSQL9 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum9."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล G-426%'";
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);
	
$strSQL9 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum9."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล GLUCOSURE%'";
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rowsg9 = mysqli_num_rows($objQuery9);
	

$sql9 = "SELECT SUM(count) AS count  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) where doc_date  LIKE '%".$date_sum9."%' and group_pro='501205.1 เครื่องวัดน้ำตาล - GLUCOALL' and unit_name ='เครื่อง'";
$qry9 = mysqli_query($conn,$sql9) or die(mysqli_error());
$rs9 = mysqli_fetch_assoc($qry9);

?>

<tr>
<td><?php echo DateThai1($date_sum9);?></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum9;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล G-426" ?>"  target="_blank"><?php echo number_format($Num_Rows9,2).""; ?></a></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum9;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล GLUCOSURE" ?>"  target="_blank"><?php echo number_format($Num_Rows9,2).""; ?></a></td>
	
<td><a href="report_smpnew22.php?date_sum=<?php echo $date_sum9;?>"  target="_blank"><?php echo number_format($rs9["count"],2).""; ?></a></td>
<td><?php echo number_format($Num_Rows-($Num_Rows3+$Num_Rows4+$Num_Rows5+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows9),2).""; ?></td>
<td><?php echo number_format($Num_Rows1-($Num_Rowsg3+$Num_Rowsg4+$Num_Rowsg5+$Num_Rowsg6+$Num_Rowsg7+$Num_Rowsg8+$Num_Rowsg9),2).""; ?></td>
	
</tr>
	
<?php
}
if($date_sum10 <= $today){	

$strSQL10 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum10."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล G-426%'";
$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$Num_Rows10 = mysqli_num_rows($objQuery10);
	
$strSQL10 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum10."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล GLUCOSURE%'";
$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$Num_Rowsg10 = mysqli_num_rows($objQuery10);
	

$sql10 = "SELECT SUM(count) AS count  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) where doc_date  LIKE '%".$date_sum10."%' and group_pro='501205.1 เครื่องวัดน้ำตาล - GLUCOALL' and unit_name ='เครื่อง'";
$qry10 = mysqli_query($conn,$sql10) or die(mysqli_error());
$rs10 = mysqli_fetch_assoc($qry10);

?>

<tr>
<td><?php echo DateThai1($date_sum10);?></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum10;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล G-426" ?>"  target="_blank"><?php echo number_format($Num_Rows10,2).""; ?></a></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum10;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล GLUCOSURE" ?>"  target="_blank"><?php echo number_format($Num_Rowsg10,2).""; ?></a></td>

<td><a href="report_smpnew22.php?date_sum=<?php echo $date_sum10;?>"  target="_blank"><?php echo number_format($rs10["count"],2).""; ?></a></td>

<td><?php echo number_format($Num_Rows-($Num_Rows3+$Num_Rows4+$Num_Rows5+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows9+$Num_Rows10),2).""; ?></td>
<td><?php echo number_format($Num_Rows1-($Num_Rowsg3+$Num_Rowsg4+$Num_Rowsg5+$Num_Rowsg6+$Num_Rowsg7+$Num_Rowsg8+$Num_Rowsg9+$Num_Rowsg10),2).""; ?></td>
</tr>
			
<?php
}
if($date_sum11 <= $today){	

$strSQL11 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum11."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล G-426%'";
$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rows11 = mysqli_num_rows($objQuery11);
	

$strSQL11 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum11."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล GLUCOSURE%'";
$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rowsg11 = mysqli_num_rows($objQuery11);
	

$sql11 = "SELECT SUM(count) AS count  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) where doc_date  LIKE '%".$date_sum11."%' and group_pro='501205.1 เครื่องวัดน้ำตาล - GLUCOALL' and unit_name ='เครื่อง'";
$qry11 = mysqli_query($conn,$sql11) or die(mysqli_error());
$rs11 = mysqli_fetch_assoc($qry11);

?>

<tr>
<td><?php echo DateThai1($date_sum11);?></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum11;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล G-426" ?>"  target="_blank"><?php echo number_format($Num_Rows11,2).""; ?></a></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum11;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล GLUCOSURE" ?>"  target="_blank"><?php echo number_format($Num_Rowsg11,2).""; ?></a></td>

<td><a href="report_smpnew22.php?date_sum=<?php echo $date_sum11;?>"  target="_blank"><?php echo number_format($rs11["count"],2).""; ?></a></td>

<td><?php echo number_format($Num_Rows-($Num_Rows3+$Num_Rows4+$Num_Rows5+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows9+$Num_Rows10+$Num_Rows11),2).""; ?></td>
	
<td><?php echo number_format($Num_Rows1-($Num_Rowsg3+$Num_Rowsg4+$Num_Rowsg5+$Num_Rowsg6+$Num_Rowsg7+$Num_Rowsg8+$Num_Rowsg9+$Num_Rowsg10+$Num_Rowsg11),2).""; ?></td>	
</tr>	
	
<?php
}
if($date_sum12 <= $today){	

$strSQL12 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum12."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล G-426%'";
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$Num_Rows12 = mysqli_num_rows($objQuery12);
	

$strSQL12 = "SELECT * FROM hos__smp  where smp_date LIKE '%".$date_sum12."%' and  status_sup='Approve' and chang_ckk='1' and comment_sale LIKE '%ซื้อเครื่องวัดน้ำตาล GLUCOSURE%'";
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$Num_Rowsg12 = mysqli_num_rows($objQuery12);
	

$sql12 = "SELECT SUM(count) AS count  FROM (tb__buypro LEFT JOIN tb_product ON tb__buypro.product_no=tb_product.product_ID) where doc_date  LIKE '%".$date_sum12."%' and group_pro='501205.1 เครื่องวัดน้ำตาล - GLUCOALL' and unit_name ='เครื่อง'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_assoc($qry12);

?>

<tr>
<td><?php echo DateThai1($date_sum12);?></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum12;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล G-426" ?>"  target="_blank"><?php echo number_format($Num_Rows12,2).""; ?></a></td>
<td><a href="report_smpnew11.php?date_sum=<?php echo $date_sum12;?>&comment_sale=<?php echo "ซื้อเครื่องวัดน้ำตาล GLUCOSURE" ?>"  target="_blank"><?php echo number_format($Num_Rowsg12,2).""; ?></a></td>
	
<td><a href="report_smpnew22.php?date_sum=<?php echo $date_sum12;?>"  target="_blank"><?php echo number_format($rs12["count"],2).""; ?></a></td>

<td><?php echo number_format($Num_Rows-($Num_Rows3+$Num_Rows4+$Num_Rows5+$Num_Rows6+$Num_Rows7+$Num_Rows8+$Num_Rows9+$Num_Rows10+$Num_Rows11+$Num_Rows12),2).""; ?></td>
	
<td><?php echo number_format($Num_Rows1-($Num_Rowsg3+$Num_Rowsg4+$Num_Rowsg5+$Num_Rowsg6+$Num_Rowsg7+$Num_Rowsg8+$Num_Rowsg9+$Num_Rowsg10+$Num_Rowsg11+$Num_Rowsg12),2).""; ?></td>	
</tr>	
<?php } ?>		
				

</table>
	
	
	

<br><br>
</div></div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>




