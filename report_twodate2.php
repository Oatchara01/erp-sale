<style>
		body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font: 13pt "Angsana New";
    }
	table {
	  border-collapse: collapse;
	  font-size:13pt;
	}

	.tablep, .tr, .td {
	  border: 1px solid black;
	}
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 297mm;
        max-height: 210mm;
        padding: 10mm;
        margin: 0mm auto;
        /*border: 0px #D3D3D3 solid;
        border-radius: 0px;*/
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0);
    }
    @page {
        size: A4 landscape;
        margin: 0;
    }
	@page Section1 {size:841.7pt 595.45pt; margin:1.0in 1.25in 1.0in 1.25in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
	div.Section1 {page:Section1;}
	@page Section2 {size:841.7pt 595.45pt;mso-page-orientation:landscape;margin:0.6in 0.6in 0.6in 0.6in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
	div.Section2 {page:Section2;}
	@media screen {
	  div.divFooter {
		display: none;
	  }
    @media print {
        html, body {
            width: 297mm;
            height: 210mm;
			 div.divFooter {
				position: fixed;
				bottom: 0;
			 }
        }
    }
	h1,h2,h3,h4,h5,h6 {
		font: 18pt "Angsana New";
	}
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
include"dbconnect.php";
$start_date=$_GET["start_date"];	
$end_date=$_GET["end_date"];
$h_product_code =$_GET["h_product_code"];

$date = explode('-' , $_GET["start_date"] );
$newDate = $date[2].'-'.$date[1].'-'.$date[0];
$date1 = explode('-' , $_GET["end_date"] );
$newDate1 = $date1[2].'-'.$date1[1].'-'.$date1[0];
?>
<div class="Section2 page">
	<body>
		<?php
			echo "รายงานสรุปตามวันที่ : ".$newDate."</p>";
			$started = microtime(true);
			
			$sql = "SELECT distinct salechannel_nameshort,sale_channel,salechannel_name FROM ((so__main INNER JOIN  tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)INNER JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1";
				
			if($start_date !=""){ 
				$sql .= ' AND register_date = "'.$start_date.'"'; 
			}
			if($h_product_code !=""){ 
				$sql .= ' AND product_code = "'.$h_product_code.'"'; 
			}

			/*if($end_date !=""){ 
				$sql .= ' AND delivery_date = "'.$end_date.'"'; 
			}*/

			$query = mysqli_query($conn,$sql) or die(mysqli_error());
			while($result = mysqli_fetch_array($query)){
			$salechannel_nameshort=$result["salechannel_nameshort"];
			$sale_channel =$result["sale_channel"];
			$salechannel_name = $result["salechannel_name"];
			$sum_salechannel = "$salechannel_nameshort $salechannel_name";
			echo "ช่องทางการขาย : ".$salechannel_nameshort.' '.$salechannel_name;
			?>
			<table border="0" style="width:100%;">
				<thead>
					<th>วันที่</th>
					<th>ID</th>
					<th>หมายเลขคำสั่งซื้อ</th>
					<th>ชื่อลูกค้า</th>
					<th>รายการสินค้า</th>
					<th>จำนวน</th>
					<th>ราคา</th>
					<th>รวมเป็นเงิน</th>
					<th>เลขที่เอกสาร</th>
					<th>การจัดส่ง</th>
				</thead>
				<tbody>
				<?php // // 
					$sql1 = "SELECT *  FROM (so__main INNER JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."' ";
					if($start_date !=""){ 
						$sql1 .= ' AND register_date = "'.$start_date.'"'; 
					}
					if($h_product_code !=""){ 
						$sql1 .= ' AND product_id = "'.$h_product_code.'"'; 
					}
					/*if($end_date !=""){ 
						$sql1 .= ' AND delivery_date = "'.$end_date.'"'; 
					}*/
					//echo $sql1;
					//exit();
					
					$query1 = mysqli_query($conn,$sql1) or die(mysqli_error($conn));
					while($result1 = mysqli_fetch_array($query1)){
						$register_date=$result1["register_date"];
						$ref_id=$result1["ref_id"];
						$order_id=$result1["order_id"];
						//$product_name=$result1["access_name"];
						if($result1["order_name"]==''){
							$customer_name=$result1["customer_name"];
						}else{
							$customer_name=$result1["order_name"];
						}
						$sale_count=$result1["sale_count"];
						$price_per_unit1=$result1["price_per_unit"];
						$price_per_unit= number_format( $price_per_unit1,2)."";
						$sum_amount1=$result1["sum_amount"];
						$sum_amount= number_format( $sum_amount1,2)."";
						$doc_no=$result1["doc_no"];
						$delivery_name=$result1["delivery_name"];
						$pd=$result1["product_id"]; $temp=mysqli_query($conn,"select access_name from tb_product where product_ID='".$pd."'"); 
				?>
					<tr>
						<td><?php echo $register_date; ?></td>
						<td><?php echo $ref_id; ?></td>
						<td><?php echo $order_id; ?></td>
						<td><?php echo $customer_name; ?></td>
						<td><?php while($access=mysqli_fetch_array($temp)) {echo $access["access_name"];} ?></td>
						<td><?php echo $sale_count; ?></td>
						<td><?php echo $price_per_unit; ?></td>
						<td><?php echo $sum_amount; ?></td>
						<td><?php echo $doc_no; ?></td>
						<td><?php echo $delivery_name; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

			<?php
				$strSQL1 = "SELECT SUM(sum_amount) AS amount_1 FROM (so__main INNER JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."' ";
				if($start_date !=""){ 
					$strSQL1 .= ' AND register_date = "'.$start_date.'"'; 
				}
				if($h_product_code !=""){ 
					$strSQL1 .= ' AND product_code = "'.$h_product_code.'"'; 
				}
				/*if($end_date !=""){ 
					$strSQL1 .= ' AND delivery_date = "'.$end_date.'"'; 
				}*/
				//echo $strSQL1;
				//exit();
				$objQuery1 = mysqli_query($conn,$strSQL1);
				$objResult1= mysqli_fetch_array($objQuery1);
				$summary_1=$objResult1['amount_1'];
				$summary= number_format( $summary_1,2)."";
				$strSQL2 = "SELECT SUM(sale_count) AS sale_count  FROM (so__main INNER JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."' ";
				if($start_date !=""){ 
					$strSQL2 .= ' AND register_date = "'.$start_date.'"'; 
				}
				if($h_product_code !=""){ 
					$strSQL2 .= ' AND product_code = "'.$h_product_code.'"'; 
				}
				/*if($end_date !=""){ 
					$strSQL2 .= ' AND delivery_date = "'.$end_date.'"'; 
				}*/
				//echo $strSQL1;
			//exit();
			$objQuery2 = mysqli_query($conn,$strSQL2);
			$objResult2= mysqli_fetch_array($objQuery2);
			$sale_count1=$objResult2['sale_count'];
			$sale_count= number_format( $sale_count1,2)."";
			echo "<b>รวมตามช่องทางการขาย จำนวน ".$sale_count." ชิ้น รวมเป็นเงิน ".$summary." บาท</b></p />";
			}
			$strSQL3 = "SELECT SUM(sale_count) AS sale_count_1 FROM (so__main INNER JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1 ";
			if($start_date !=""){ 
				$strSQL3 .= ' AND register_date = "'.$start_date.'"'; 
			}
			if($h_product_code !=""){ 
				$strSQL3 .= ' AND product_code = "'.$h_product_code.'"'; 
			}
			/*if($end_date !=""){ 
				$strSQL3 .= ' AND delivery_date = "'.$end_date.'"'; 
			}*/
			//echo $strSQL3;
			//exit();
			$objQuery3 = mysqli_query($conn,$strSQL3);
			$objResult3= mysqli_fetch_array($objQuery3);
			$sale_count2=$objResult3['sale_count_1'];
			$sale_count_2= number_format( $sale_count2,2)."";
			$strSQL4 = "SELECT SUM(sum_amount) AS amount_2 FROM (so__main INNER JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1 ";
			if($start_date !=""){ 
				$strSQL4 .= ' AND register_date = "'.$start_date.'"'; 
			}
			if($h_product_code !=""){ 
				$strSQL4 .= ' AND product_code = "'.$h_product_code.'"'; 
			}
			/*	if($end_date !=""){ 
				$strSQL4 .= ' AND delivery_date = "'.$end_date.'"'; 
			}*/
			//echo $strSQL3;
			//exit();
			$objQuery4 = mysqli_query($conn,$strSQL4);
			$objResult4= mysqli_fetch_array($objQuery4);
			$amount_2=$objResult4['amount_2'];
			$amount_23= number_format( $amount_2,2)."";
			echo "<b>รวมทั้งหมด จำนวน ".$sale_count_2." ชิ้น รวมเป็นเงิน ".$amount_23." บาท</b>";
				
			$end = microtime(true);
			$difference = $end - $started;
			$queryTime = number_format($difference, 10);
			echo "<script>alert('SQL query took $queryTime seconds');</script>";
		?>
	</body>
</div>