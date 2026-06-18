<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-container w3-padding-large">
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" value="<?php echo $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" value="<?php echo $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>" type="date" id="end_date" ></div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php	
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			
<td width="5%" align="center" class="style30">ลำดับที่</td>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="12%" align="center" class="style30">เลขที่พัสดุ</td> 
<td width="12%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="25%" align="center" class="style30">รายการสินค้า</td> 
<td width="10%" align="center" class="style30">การจัดส่ง</td> 
<td width="8%" align="center" class="style30">ค่าจัดส่ง</td> 
<td width="2%" align="center" class="style30">แก้ไข</td> 
			

	</thead>
<?php
if($start_date !='' and $end_date !=''){		

$sql1 = "SELECT ref_id,delivery,date_ker,ker_bath,order_refer_code1,order_refer_code,doc_no  FROM so__main  where 1  ";
	


if($start_date !=""){ 
    $sql1 .= ' AND date_ker >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql1 .= ' AND date_ker <= "'.$end_date.'"'; 
}


$query1 = mysqli_query($conn,$sql1) or die ("Error Query [".$sql1."]");
$Num_Rows1 = mysqli_num_rows($query1);
$i=1;	
while($result1 = mysqli_fetch_array($query1)){

$strSQL3 = "select delivery_name from tb_delivery where delivery_id ='".$result1["delivery"]."'";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResuut3 = mysqli_fetch_array($objQuery3,MYSQLI_ASSOC);

?>


<tr>
<td  align="center" class="style30"><?php echo  $i; ?></td>
<td  align="center" class="style30"><?php echo  Datethai($result1["date_ker"]); ?> </td>
<td   class="style30"><div align="left"><?php echo  $result1["order_refer_code"]; ?><?php if($result1["order_refer_code1"]!=''){ ?></p><?php echo $result1["order_refer_code1"]; } ?></div></td> 
<td align="center" class="style30"><?php echo $result1["doc_no"];  ?></td> 

<td class="style30">
<div align="left">
					<?php
$strSQL2 = "SELECT * FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$result1["ref_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
							<?php
 
	echo $objResult2["sol_name"]; 

	
	?><br />
						<?php } ?>
				</div>

</td> 

<td  class="style30"><div align="left"><?php echo  $objResuut3["delivery_name"]; ?></div></td> 
<td  align="right" class="style30"><?php echo   number_format( $result1["ker_bath"],2).""; ?></td> 
<td>
				<a href="edit_soldel.php?ref_id=<?php echo $result1["ref_id"];?>&start_date=<?php echo $_GET["start_date"];?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>	</td>
	
	</tr>



<?php 
$i++;
} ?>
	
	
<?php

$sql8 = "SELECT ref_idsmp,smp_no,date_ker,ker_bath,ref_no,ref_no1  FROM hos__smp  where 1  ";
if($start_date !=""){ 
    $sql8 .= ' AND date_ker >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql8 .= ' AND date_ker <= "'.$end_date.'"'; 
}

if($company1 !=""){ 
    $sql8 .= ' AND type_company = "'.$company1.'"'; 
}

$query8 = mysqli_query($conn,$sql8) or die ("Error Query [".$sql8."]");
$Num_Rows8 = mysqli_num_rows($query8);

$i=$Num_Rows1+$Num_Rows4+1;
	while($result8 = mysqli_fetch_array($query8)){
		
$strSQL9 = "select address_1 from tb_register_data where ref_id ='".$result8["ref_idsmp"]."'";
$objQuery9 = mysqli_query($conn,$strSQL9);
$objResuut9 = mysqli_fetch_array($objQuery9,MYSQLI_ASSOC);
?>


<tr>
<td  align="center" class="style30"><?php echo  $i; ?></td>
<td  align="center" class="style30"><?php echo  Datethai($result8["date_ker"]); ?> </td>
<td  class="style30"><div align="left"><?php echo  $result8["ref_no"]; ?><?php if($result8["ref_no1"]!=''){ ?></p><?php echo $result8["ref_no1"]; } ?></div></td> 
<td align="center" class="style30"><?php echo $result8["smp_no"];  ?></td> 

<td class="style30">
<div align="left">
					<?php
		$strSQL10 = "SELECT * FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$result8["ref_idsmp"]."' ";
		$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
		while($objResult10 = mysqli_fetch_array($objQuery10)) { ?>
							<?php
 
	echo $objResult10["sol_name"]; 

	
	?><br />
						<?php } ?>
				</div>
</td> 
<td class="style30"><div  align="left"><?php echo  $objResuut9["address_1"]; ?></div></td> 
<td  align="right" class="style30"><?php echo   number_format( $result8["ker_bath"],2).""; ?></td> 

<td>
<a href="edit_smpdel.php?ref_idsmp=<?php echo $result8["ref_idsmp"];?>&start_date=<?php echo $_GET["start_date"];?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>	</td>
	</tr>



<?php 
$i++;
} ?>





<?php

$sql11 = "SELECT ref_id,iv_no,date_ker,ker_bath,order_refer_code,order_refer_code1  FROM hos__so  where 1  ";
if($start_date !=""){ 
    $sql11 .= ' AND date_ker >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql11 .= ' AND date_ker <= "'.$end_date.'"'; 
}

$query11 = mysqli_query($conn,$sql11) or die ("Error Query [".$sql11."]");
$Num_Rows11 = mysqli_num_rows($query11);

$i=$Num_Rows1+$Num_Rows4+$Num_Rows8+1;
	while($result11 = mysqli_fetch_array($query11)){
		
$strSQL12 = "select address_1 from tb_register_data where ref_id ='".$result11["ref_id"]."'";
$objQuery12 = mysqli_query($conn,$strSQL12);
$objResuut12 = mysqli_fetch_array($objQuery12,MYSQLI_ASSOC);
?>


<tr>
<td  align="center" class="style30"><?php echo  $i; ?></td>
<td  align="center" class="style30"><?php echo  Datethai($result11["date_ker"]); ?> </td>
<td  class="style30"><div align="left"><?php echo  $result11["order_refer_code"];  ?><?php if($result11["order_refer_code"]!=''){ ?> </p><?php echo $result11["order_refer_code1"]; } ?></div></td> 
<td align="center" class="style30"><?php echo $result11["iv_no"];  ?></td> 

<td class="style30">
<div align="left">
					<?php
		$strSQL13 = "SELECT * FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$result11["ref_id"]."' ";
		$objQuery13 = mysqli_query($conn,$strSQL13) or die ("Error Query [".$strSQL13."]");
		while($objResult13 = mysqli_fetch_array($objQuery13)) { ?>
							<?php
 	echo $objResult13["sol_name"]; 
	?><br />
						<?php } ?>
				</div>
</td> 
<td  class="style30"><div  align="left"><?php echo  $objResuut12["address_1"]; ?></div></td> 
<td  align="right" class="style30"><?php echo   number_format( $result11["ker_bath"],2).""; ?></td> 
<td>
<a href="edit_hossodel.php?ref_id=<?php echo $result11["ref_id"];?>&start_date=<?php echo $_GET["start_date"];?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>	
	</tr>



<?php 
$i++;
} ?>


<?php

$sql14 = "SELECT ref_id_br,iv_no,date_ker,ker_bath,order_refer_code,order_refer_code1  FROM hos__br  where 1  ";
if($start_date !=""){ 
    $sql14 .= ' AND date_ker >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql14 .= ' AND date_ker <= "'.$end_date.'"'; 
}

$query14 = mysqli_query($conn,$sql14) or die ("Error Query [".$sql14."]");
$Num_Rows14 = mysqli_num_rows($query14);

$i=$Num_Rows1+$Num_Rows4+$Num_Rows8+$Num_Rows11+1;
	while($result14 = mysqli_fetch_array($query14)){
		
$strSQL15 = "select address_1 from tb_register_data where ref_id ='".$result14["ref_id_br"]."'";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResuut15 = mysqli_fetch_array($objQuery15,MYSQLI_ASSOC);
?>


<tr>
<td  align="center" class="style30"><?php echo  $i; ?></td>
<td  align="center" class="style30"><?php echo  Datethai($result14["date_ker"]); ?> </td>
<td  class="style30"><div align="left"><?php echo  $result14["order_refer_code"]; ?><?php if($result14["order_refer_code1"]!=''){ ?></p><?php echo $result14["order_refer_code1"]; } ?></div></td> 
<td align="center" class="style30"><?php echo $result14["iv_no"];  ?></td> 

<td class="style30">
<div align="left">
					<?php
		$strSQL16 = "SELECT * FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$result14["ref_id_br"]."' ";
		$objQuery16 = mysqli_query($conn,$strSQL16) or die ("Error Query [".$strSQL16."]");
		while($objResult16 = mysqli_fetch_array($objQuery16)) { ?>
							<?php
 	echo $objResult16["sol_name"]; 
	?><br />
						<?php } ?>
				</div>
</td> 
<td  class="style30"><div  align="left"><?php echo  $objResuut15["address_1"]; ?></div></td> 
<td  align="right" class="style30"><?php echo   number_format( $result14["ker_bath"],2).""; ?></td> 

<td>
<a href="edit_hosbrdel.php?ref_id_br=<?php echo $result14["ref_id_br"];?>&start_date=<?php echo $_GET["start_date"];?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>	
	</tr>
<?php 
$i++;
} 
?>
<?php

$sql17 = "SELECT del_date,iv_no,ker_bath,ref_no,ref_no1,pro_name,type_del,id  FROM tb_deloth  where 1  ";
if($start_date !=""){ 
    $sql17 .= ' AND del_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql17 .= ' AND del_date <= "'.$end_date.'"'; 
}

$query17 = mysqli_query($conn,$sql17) or die ("Error Query [".$sql17."]");
$Num_Rows17 = mysqli_num_rows($query17);

$i=$Num_Rows1+$Num_Rows4+$Num_Rows8+$Num_Rows11+$Num_Rows14+1;
	while($result17 = mysqli_fetch_array($query17)){
		
?>


<tr>
<td  align="center" class="style30"><?php echo  $i; ?></td>
<td  align="center" class="style30"><?php echo  Datethai($result17["del_date"]); ?> </td>
<td  class="style30"><div align="left"><?php echo  $result17["ref_no"]; ?><?php if($result17["ref_no1"]!=''){ ?></p><?php echo $result17["ref_no1"]; } ?></div></td> 
<td align="center" class="style30"><?php echo $result17["iv_no"];  ?></td> 

<td class="style30">
<div align="left">
<?php 	echo $result17["pro_name"]; ?>
				</div>
</td> 
<td  class="style30"><div  align="left"><?php echo  $result17["type_del"]; ?></div></td> 
<td  align="right" class="style30"><?php echo   number_format( $result17["ker_bath"],2).""; ?></td> 
<td>
<a href="edit_othdel.php?id=<?php echo $result17["id"];?>&start_date=<?php echo $_GET["start_date"];?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>	</td>

	</tr>


<?php 
$i++;
} 
}
?>
	</table>

 
      </p>
<?php include('foot.php'); ?>
</div>
</body>
</html>