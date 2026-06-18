<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 18px; color: #FF0000;}
.style17 {font-size: 18px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style39 {font-size: 14px; color: #000000;}
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


include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorHTML.php";
include "src/BarcodeGeneratorPNG.php";




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

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$type_return = $_GET["type_return"];

include"dbconnect.php";




?>
<body>



<center>
<span class="style15">รายงานใบลดหนี้</span></p>

<span class="style15"><?php echo Datethai($start_date); ?>&nbsp;ถึง&nbsp;<?php echo Datethai($end_date); ?></span><br>


</center>
</p>





</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="10%" align="center" class="style30">เลขที่ใบลดหนี้</td>
<td width="10%" align="center" class="style30">เลขที่บิล</td> 
<td width="20%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="20%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="8%" align="center" class="style30">จำนวน</td> 
<td width="8%" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="8%" align="center" class="style30">ส่วนลดต่อหน่วย</td> 
<td width="8%" align="center" class="style30">ยอดรวม</td>

	</tr>





<?php
$strSQL = "SELECT *  FROM tb_credit_note  where credit_no !=''  and status_doc = 'Approve'";

if($start_date !=""){ 
    $strSQL .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_credit <= "'.$end_date.'"'; 
}



if($type_return !=""){ 
    $strSQL .= ' AND type_return ="'.$type_return.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");

	while($result1 = mysqli_fetch_array($objQuery)){

?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($result1["date_credit"]); ?></td>
<td  align="center" class="style30"><?php echo  $result1["credit_no"]; ?> </td>
<td  align="center" class="style30"><?php echo  $result1["ref_iv_no"]; ?></td> 
<td class="style30"><div align="left"><?php echo $result1["customer_name"];  ?></div></td> 
<td class="style30"><div align="left">
	<?php
						$strSQL2 = "SELECT sol_name FROM (tb_subcredit LEFT JOIN tb_product ON tb_subcredit.product_ID=tb_product.product_id) WHERE ref_creditt = '".$result1["ref_credit"]."' ";
						$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
						while($objResult2 = mysqli_fetch_array($objQuery2)) { ?>
							<?php
 	echo $objResult2["sol_name"]; 
	?><br />
						<?php } ?></div></td> 
<td class="style30"><div align="right">
			<?php
					$strSQL3 = "SELECT count,unit_name FROM (tb_subcredit LEFT JOIN tb_product ON tb_subcredit.product_ID=tb_product.product_id) WHERE ref_creditt = '".$result1["ref_credit"]."' ";
					$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
					while($objResult3 = mysqli_fetch_array($objQuery3)) { ?>
							<?php echo  $objResult3["count"]; ?> <?php echo  $objResult3["unit_name"]; ?><br />
						<?php } ?>
						</div></td> 
<td  align="center" class="style30"><div align="right">
					<?php
					$strSQL4 = "SELECT unit_price FROM tb_subcredit  WHERE ref_creditt = '".$result1["ref_credit"]."' ";
					$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
					while($objResult4 = mysqli_fetch_array($objQuery4)) { ?>
							<?php echo  number_format($objResult4["unit_price"],2).""; ?> <br />
						<?php } ?>	
					</div></td> 
<td  class="style30"><div align="right">
<?php
					$strSQL5 = "SELECT discount_unit FROM tb_subcredit  WHERE ref_creditt = '".$result1["ref_credit"]."' ";
					$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
					while($objResult5 = mysqli_fetch_array($objQuery5)) { ?>
							<?php echo  number_format($objResult5["discount_unit"],2).""; ?> <br />
						<?php } ?>
</div></td> 
<td  class="style30"><div align="right">
<?php
					$strSQL6 = "SELECT sum_amount FROM tb_subcredit  WHERE ref_creditt = '".$result1["ref_credit"]."' ";
					$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
					while($objResult6 = mysqli_fetch_array($objQuery6)) { ?>
							<?php echo  number_format($objResult6["sum_amount"],2).""; ?> <br />
						<?php } ?>
</div></td> 
	</tr>



<?php } ?>
	
	
	

</table>

<?php


$sql3 = "SELECT SUM(sum_amount) As sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt)  where credit_no !=''  and status_doc = 'Approve' ";
	
if($start_date !=""){ 
    $sql3 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql3 .= ' AND date_credit <= "'.$end_date.'"'; 
}



if($type_return !=""){ 
    $sql3 .= ' AND type_return ="'.$type_return.'"'; 
}

$query3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$result3 = mysqli_fetch_array($query3);
		
		?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td>
<td width="10%" align="center" class="style30"></td> 
<td width="20%" align="center" class="style30"></td>
<td width="20%" align="center" class="style30"></td> 
<td width="8%" align="center" class="style30"></td> 
<td width="8%" align="center" class="style30"></td> 
<td width="8%" align="center" class="style30">ยอดรวมทั้งหมด</td> 
<td width="8%" align="center" class="style30"><?php echo number_format( $result3["sum_amount"],2).""; ?> บาท</td>

	</tr>
</table>




</p>
</body>
</html>