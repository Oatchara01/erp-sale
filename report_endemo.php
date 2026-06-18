<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-grey"><h3>รายงานสรุปแบบสอบถามความพึงพอใจสินค้าสาธิต</h3></div>
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" value = "<?php echo $_GET['start_date']; ?>" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" value =<?php echo $_GET['end_date']; ?> id="end_date" ></div>

<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>


<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="2%">ลำดับ</th>
			<th width="8%">เลขที่เอกสาร</th>
			<th width="15%">ลูกค้า</th>
			<th width="15%">สินค้า</th>
			<th width="5%">เขตการขาย</th>
			<th width="5%">คุณภาพสินค้า (เปอร์เซ็นต์)</th>
			<th width="15%">ข้อเสนอแนะ</th>
			<th width="5%">การจัดส่ง และการบริการ (เปอร์เซ็นต์)</th>
			<th width="15%">ข้อเสนอแนะ</th>
	</thead>


<?php	
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";


if($start_date !='' or $end_date !=''){


$strSQL = "SELECT *  FROM tb_research_demo  where 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND date_reseach >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_reseach <= "'.$end_date.'"'; 
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$ggg = substr($objResult["ref_id"],0,2);

if($ggg=='BR'){

$sql = "SELECT iv_no,customer,sale_code   FROM hos__br where ref_id_br ='".$objResult["ref_id"]."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$iv_no = $rs["iv_no"];
$customer = $rs["customer"];
$sale_code = $rs["sale_code"];

}else{

$sql = "SELECT doc_no,employee_name,customer_name   FROM so__main where ref_id ='".$objResult["ref_id"]."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$iv_no = $rs["doc_no"];
$customer = $rs["customer_name"];
$sale_code = $rs["employee_name"];


}

$sql1 = "SELECT sol_name   FROM tb_product where product_ID ='".$objResult["product_iddemo"]."' ";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);



?>
		<tbody>
			<tr>
<td><?php echo $i;?></td>
<td>
				
	
<a href="viewreserch_demo.php?ref_id_br=<?php echo $objResult["ref_id"];?>"  target="_blank"><?php echo $iv_no;	?></a>			
				</td>
<td><div align="left"><?php echo $customer;?></div></td>
<td><div align="left"><?php echo $rs1["sol_name"]; ?></div></td>
<td><?php echo $sale_code;?></td>

				<?php
	if(((($objResult["ckk_1"]+$objResult["ckk_2"]+$objResult["ckk_3"]+$objResult["ckk_4"]+$objResult["ckk_5"])/50)*100) < 90 ){ ?>
<td bgcolor="#FF0000" >
	<?php }else{ ?>
	<td>
	<?php } ?>
	
	<?php  echo number_format((($objResult["ckk_1"]+$objResult["ckk_2"]+$objResult["ckk_3"]+$objResult["ckk_4"]+$objResult["ckk_5"])/50)*100,2).""; ?> %</td>
<td><div align="left"><?php  echo $objResult["ckk_des"]; ?></div></td>
				
			<?php
	if(((($objResult["cs_1"]+$objResult["cs_2"]+$objResult["cs_3"]+$objResult["cs_4"]+$objResult["cs_5"]+$objResult["cs_6"])/60)*100) < 90 ){ ?>
<td bgcolor="#FF0000" >
	<?php }else{ ?>
	<td>
	<?php } ?>				

	
	<?php  echo number_format((($objResult["cs_1"]+$objResult["cs_2"]+$objResult["cs_3"]+$objResult["cs_4"]+$objResult["cs_5"]+$objResult["cs_6"])/60)*100,2).""; ?> %</td>
<td><div align="left"><?php  echo $objResult["cs_des"]; ?></div></td>
				
				
			</tr>
			<?php $i++; } ?>
		</tbody>
		
<?php
	
$strSQL1 = "SELECT SUM(cs_1) AS cs_1, SUM(cs_2) AS cs_2, SUM(cs_3) AS cs_3, SUM(cs_4) AS cs_4, SUM(cs_5) AS cs_5, SUM(cs_6) AS cs_6,SUM(ckk_1) AS ckk_1, SUM(ckk_2) AS ckk_2, SUM(ckk_3) AS ckk_3, SUM(ckk_4) AS ckk_4, SUM(ckk_5) AS ckk_5  FROM tb_research_demo  where 1 ";

if($start_date !=""){ 
    $strSQL1 .= ' AND date_reseach >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND date_reseach <= "'.$end_date.'"'; 
}


$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$objResult1 = mysqli_fetch_array($objQuery1);	
	
	
	?>
	<tr>
<td></td>
<td>รวมทั้งหมด</td>
<td><?php echo $Num_Rows; ?> งาน</td>
<td></td><td></td>
<td><?php if($objResult1["ckk_1"]!=''){  echo number_format((($objResult1["ckk_1"]+$objResult1["ckk_2"]+$objResult1["ckk_3"]+$objResult1["ckk_4"]+$objResult1["ckk_5"])/(50*$Num_Rows))*100,2).""; } ?> %</td>
		
<td></td>
<td><?php if($objResult1["cs_1"]!=''){  echo number_format((($objResult1["cs_1"]+$objResult1["cs_2"]+$objResult1["cs_3"]+$objResult1["cs_4"]+$objResult1["cs_5"]+$objResult1["cs_6"])/(60*$Num_Rows))*100,2).""; } ?> %</td>
<td></td>
				
				
			</tr>		
		

<?php } ?>

	</table>

      </p>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>