<?php
		$start_date=$_GET["start_date"];
		$product_code=$_GET["h_product_code"];
		//echo $start_date.' '.$product_code;

		include "dbconnect.php";

		if($product_code=='') {

		$search1="select distinct sale_channel from so__main where register_date='".$start_date."' ";//echo $search1;
		$qs1=mysqli_query($conn,$search1);
		$rows=mysqli_num_rows($qs1);
		if ($row < 1) {
			echo mysqli_error($conn);
		}
		while ($fs1=mysqli_fetch_array($qs1)) {
			$cncode=$fs1['sale_channel'];
			$search2="select salechannel_ID, salechannel_nameshort, salechannel_name from tb_salechannel where salechannel_ID='".$cncode."'";
			$qs2=mysqli_query($conn,$search2);
			$row2=mysqli_num_rows($qs2);
			if($row2 < 1){
				echo mysqli_error($conn);
			}
			while ($fs2=mysqli_fetch_array($qs2)) {
				$ci=$fs2["salechannel_ID"];
				$cns=$fs2["salechannel_nameshort"];
				$cn=$fs2["salechannel_name"];
				$search3="select * from so__main where sale_channel='".$ci."' and register_date='".$start_date."' ";
				$qs3=mysqli_query($conn,$search3);
				echo $cns.' '.$cn.'<br>';
				?>
				<table border=0 style="width:100%;">
					<thead>
						<th>ID</th>
						<th>หมายเลขคำสั่งซื้อ</th>
						<th>ชื่อลูกค้า</th>
						<th>รายการสินค้า</th>
						<th>จำนวน</th>
						<th>ราคา</th>
						<th>รวมเป็นเงิน</th>
						<th>เลขที่เอกสาร</th>
					</thead>
					<tbody>
					<?php
							while($fs3=mysqli_fetch_array($qs3)) {
								$qsub=mysqli_query($conn,"select * from so__submain where ref_idd='".$fs3["ref_id"]."'");
								while ($fsub=mysqli_fetch_array($qsub)) { 
								?>
									<tr>
										<td><?php echo $fsub["ref_idd"]; ?></td>
										<td><?php echo $fs3["order_id"]; ?></td>
										<td><?php echo $fs3["customer_name"]; ?></td>
										<td><?php $pid=$fsub["product_id"];$name=mysqli_query($conn,"select access_name from tb_product where product_ID='".$pid."'");$fname=mysqli_fetch_array($name); echo $fname["access_name"]; ?></td>
										<td><?php echo $fsub["sale_count"]; ?></td>
										<td><?php echo $fsub["price_per_unit"]; ?></td>
										<td><?php echo $fsub["sum_amount"]; ?></td>
										<td><?php echo $fs3["doc_no"]; ?></td>
									</tr>
								<?php
								}
							}
					?>
					</tbody>
				</table>
				<?php 
						$count=mysqli_query($conn,"select sum(sale_count) as count from (so__main inner join so__submain on so__main.ref_id=so__submain.ref_idd) where sale_channel='".$ci."' and register_date='".$start_date."'");
						$amount=mysqli_query($conn,"select sum(sum_amount) as amount from (so__main inner join so__submain on so__main.ref_id=so__submain.ref_idd) where sale_channel='".$ci."' and register_date='".$start_date."'");
				?>
				<p>รวมช่องทาง <?php echo $cns.' '.$cn; ?> มียอดขายรวมทั้งหมด <?php $fcount=mysqli_fetch_array($count); echo number_format($fcount["count"],2); ?> ชิ้น รวมมูลค่า <?php $famount=mysqli_fetch_array($amount); echo number_format($famount["amount"],2); ?> บาท</p>
			<?php } 
		}
		$sumcount=mysqli_query($conn,"select sum(sale_count) as allcount from (so__main inner join so__submain on so__main.ref_id=so__submain.ref_idd) where register_date='".$start_date."'");
		$sumall=mysqli_query($conn,"select sum(sum_amount) as allsum from (so__main inner join so__submain on so__main.ref_id=so__submain.ref_idd) where register_date='".$start_date."'"); ?>
			<p>รวมทุกช่องทางการขาย สามารถขายสินค้าได้ทั้งหมด <?php $fsc=mysqli_fetch_array($sumcount); echo number_format($fsc["allcount"],2); ?> ชิ้น มูลค่าทั้งหมด <?php $fsa=mysqli_fetch_array($sumall); echo number_format($fsa["allsum"],2); ?> บาท</p>
		<?php
		}
		/////////////////////
		else if($start_date!='' && $product_code!='') {

		$search1="select distinct sale_channel from so__main where register_date='".$start_date."'";//echo $search1;
		$qs1=mysqli_query($conn,$search1);
		$rows=mysqli_num_rows($qs1);
		if ($row < 1) {
			echo mysqli_error($conn);
		}
		while ($fs1=mysqli_fetch_array($qs1)) {
			$cncode=$fs1['sale_channel'];
			$search2="select salechannel_ID, salechannel_nameshort, salechannel_name from tb_salechannel where salechannel_ID='".$cncode."'";
			$qs2=mysqli_query($conn,$search2);
			$row2=mysqli_num_rows($qs2);
			if($row2 < 1){
				echo mysqli_error($conn);
			}
			while ($fs2=mysqli_fetch_array($qs2)) {
				$ci=$fs2["salechannel_ID"];
				$cns=$fs2["salechannel_nameshort"];
				$cn=$fs2["salechannel_name"];
				$search3="select * from so__main where sale_channel='".$ci."' and register_date='".$start_date."' ";
				$qs3=mysqli_query($conn,$search3);
				echo $cns.' '.$cn.'<br>';
				?>
				<table border=0 style="width:100%;">
					<thead>
						<th>ID</th>
						<th>หมายเลขคำสั่งซื้อ</th>
						<th>ชื่อลูกค้า</th>
						<th>รายการสินค้า</th>
						<th>จำนวน</th>
						<th>ราคา</th>
						<th>รวมเป็นเงิน</th>
						<th>เลขที่เอกสาร</th>
					</thead>
					<tbody>
					<?php
							while($fs3=mysqli_fetch_array($qs3)) {
								$qsub=mysqli_query($conn,"select * from so__submain where ref_idd='".$fs3["ref_id"]."' and product_id='".$product_code."'");
								while ($fsub=mysqli_fetch_array($qsub)) { 
								?>
									<tr>
										<td><?php echo $fsub["ref_idd"]; ?></td>
										<td><?php echo $fs3["order_id"]; ?></td>
										<td><?php echo $fs3["customer_name"]; ?></td>
										<td><?php $pid=$fsub["product_id"];$name=mysqli_query($conn,"select access_name from tb_product where product_ID='".$pid."'");$fname=mysqli_fetch_array($name); echo $fname["access_name"]; ?></td>
										<td><?php echo $fsub["sale_count"]; ?></td>
										<td><?php echo $fsub["price_per_unit"]; ?></td>
										<td><?php echo $fsub["sum_amount"]; ?></td>
										<td><?php echo $fs3["doc_no"]; ?></td>
									</tr>
								<?php
								}
							}
					?>
					</tbody>
				</table>
				<?php 
						$count=mysqli_query($conn,"select sum(sale_count) as count from (so__main inner join so__submain on so__main.ref_id=so__submain.ref_idd) where sale_channel='".$ci."' and register_date='".$start_date."' and product_id='".$product_code."'");
						$amount=mysqli_query($conn,"select sum(sum_amount) as amount from (so__main inner join so__submain on so__main.ref_id=so__submain.ref_idd) where sale_channel='".$ci."' and register_date='".$start_date."' and product_id='".$product_code."'");
				?>
				<p>รวมช่องทาง <?php echo $cns.' '.$cn; ?> มียอดขายรวมทั้งหมด <?php $fcount=mysqli_fetch_array($count); echo number_format($fcount["count"],2); ?> ชิ้น รวมมูลค่า <?php $famount=mysqli_fetch_array($amount); echo number_format($famount["amount"],2); ?> บาท</p>
			<?php } 
		}
		$sumcount=mysqli_query($conn,"select sum(sale_count) as allcount from (so__main inner join so__submain on so__main.ref_id=so__submain.ref_idd) where register_date='".$start_date."' and product_id='".$product_code."'");
		$sumall=mysqli_query($conn,"select sum(sum_amount) as allsum from (so__main inner join so__submain on so__main.ref_id=so__submain.ref_idd) where register_date='".$start_date."' and product_id='".$product_code."'"); ?>
			<p>รวมทุกช่องทางการขาย สามารถขายสินค้าได้ทั้งหมด <?php $fsc=mysqli_fetch_array($sumcount); echo number_format($fsc["allcount"],2); ?> ชิ้น มูลค่าทั้งหมด <?php $fsa=mysqli_fetch_array($sumall); echo number_format($fsa["allsum"],2); ?> บาท</p>
		<?php
		}
?>
