<?php
	include("dbconnect.php");
	$ref_id=$_GET["ref_id"];
	
	$pr = "select * from hos__so where ref_id='$ref_id'";
	$qpr = mysqli_query($conn,$pr);
	$fpr = mysqli_fetch_array($qpr);
?>
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="ang/stylesheet.css">
	<style>
		body {
			  margin: 0;
			  padding: 0;
			  background-color: #FFFFFF;
			  font: 12pt "angsana_newregular";
			}

			* {
			  box-sizing: border-box;
			  -moz-box-sizing: border-box;
			}

			.page {
			  width: 21cm;
			  min-height: 29.7cm;
			  padding: 1cm;
			  margin: 1cm auto;
			  border: 1px #D3D3D3 solid;
			  border-radius: 5px;
			  background: white;
			  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
			}

			.subpage {
			  padding: 1cm;
			  border: 0px;
			  height: 256mm;
			  outline: 0cm;
			}

			@page {
			  size: A4;
			  margin: 0;
			}

			@media print {
			  .page {
				margin: 0;
				border: initial;
				border-radius: initial;
				width: initial;
				min-height: initial;
				box-shadow: initial;
				background: initial;
				page-break-after: always;
			  }
			}
	</style>
<div class="page w3-container">
<div class="w3-border">
<div class="w3-container w3-margin-top">
	<div class="w3-bar">
		<div class="w3-third 1">
			<span class="w3-badge w3-border w3-white">ก</span>
			<span class="w3-badge w3-border w3-white">C</span>
			<br class="w3-margin-bottom">
			<span>เลขที่อ้างอิง : <?php echo $ref_id; ?></span>
			<br>
			<span>เลขที่ลงงาน : <?php echo $fpr["job_no"]; ?></span>
		</div>
		<div class="w3-third 2 w3-center">
			<span><h4>ใบสั่งขาย<br>(SALE ORDER)</h4></span>
		</div>
		<div class="w3-third 3">
			<span class="w3-right">ฝากสินค้าเลขที่ : <?php echo $fpr["dep_no"]; ?></span>
			<br>
			<span class="w3-right">วันที่ : <?php echo $fpr["date"]; ?>
		</div>
	</div>
	<div class="w3-bar w3-quarter">
		<span>ชื่อผู้แนะนำ/รพ./แผนก</span>
	</div>
	<div class="w3-bar w3-threequarter w3-border-bottom">
		<span class="w3-margin-left"><?php echo $fpr["suggest"]; ?></span>
	</div>
	<div class="w3-bar w3-quarter">
		<span>ชื่อที่ต้องการออกบิล</span>
	</div>
	<div class="w3-bar w3-threequarter w3-border-bottom">
		<span class="w3-margin-left"><?php echo $fpr["bill_name"]; ?></span>
	</div>
	<div class="w3-bar w3-quarter">
		<span>ที่อยู่ที่ต้องการออกบิล</span>
	</div>
	<div class="w3-bar w3-threequarter w3-border-bottom">
		<span class="w3-margin-left"><?php echo $fpr["bill_address"]; ?></span>
	</div>
	<div class="w3-bar w3-quarter">
		<span>เบอร์โทร</span>
	</div>
	<div class="w3-bar w3-threequarter w3-border-bottom">
		<span class="w3-margin-left"><?php echo $fpr["bill_tel"]; ?></span>
	</div>
	<div class="w3-third">
		<div class="w3-bar w3-half">
			<span>ใบสั่งซื้อเลขที่</span>
		</div>
		<div class="w3-bar w3-half w3-border-bottom">
			<span class="w3-margin-left"><?php echo $fpr["po_no"]; ?></span>
		</div>
	</div>
	<div class="w3-third w3-container">
		<div class="w3-bar w3-twothird">
			<span class="w3-right">กำหนดส่งตามสัญญา</span>
		</div>
		<div class="w3-bar w3-third w3-border-bottom">
			<span class="w3-margin-left"><?php echo $fpr["delivery_contract"]; ?></span>
		</div>
	</div>
	<div class="w3-third w3-container">
		<div class="w3-bar w3-third">
			<span class="w3-right">ชำระโดย</span>
		</div>
		<div class="w3-bar w3-twothird w3-border-bottom">
			<span class="w3-margin-left"><?php echo $fpr["payment"]; ?></span>
		</div>
	</div>
	<div class="w3-bar w3-margin-bottom"></div>
	<?php
		$pd = "select hos__subso.*, tb_product.* from hos__subso left join tb_product on (hos__subso.product_id=tb_product.product_ID) where ref_id='$ref_id'";
		$qpd = mysqli_query($conn,$pd);
	?>
	<table name="pd" class="w3-table" border="0">
		<thead>
			<th class="w3-border">ลำดับ</th>
			<th class="w3-border">รหัสสินค้า</th>
			<th class="w3-border">รายละเอียด</th>
			<th class="w3-border">จำนวน</th>
			<th class="w3-border">ราคาต่อหน่วย</th>
			<th class="w3-border">ส่วนลด</th>
			<th class="w3-border">ราคารวม</th>
			<th class="w3-border">รับประกัน</th>
			<th class="w3-border">CAL</th>
			<th class="w3-border">PM</th>
		</thead>
		<tbody>
			<?php $i=1; while($fpd=mysqli_fetch_array($qpd)) { ?>
			<tr>
				<td class="w3-border"><?php echo $i; ?></td>
				<td class="w3-border"><?php echo $fpd["access_code"]; ?></td>
				<td class="w3-border"><?php echo $fpd["access_name"]; ?></td>
				<td class="w3-border"><?php echo $fpd["count"]; ?></td>
				<td class="w3-border"><?php echo $fpd["price"]; ?></td>
				<td class="w3-border"><?php echo $fpd["discount"]; ?></td>
				<td class="w3-border"><?php echo $fpd["amount"]; ?></td>
				<td class="w3-border"><?php echo $fpd["warranty"]; ?></td>
				<td class="w3-border"><?php echo $fpd["cal"]; ?></td>
				<td class="w3-border"><?php echo $fpd["pm"]; ?></td>
			</tr>
			<?php $i++; } 
				$sum="select sum(amount) as samount from hos__subso where ref_id='$ref_id'";
				$qsum=mysqli_query($conn,$sum);
				$fsum=mysqli_fetch_array($qsum);
			?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td class="w3-border"><b>ราคาสุทธิ</b></td>
				<td class="w3-border"><?php echo $fsum["samount"]; ?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>
	<div class="w3-bar w3-margin-bottom"></div>
	<div class="w3-third">
		<div class="w3-third">
			<?php if($fpr["bq_check"]==1) { ?>
				<span class="w3-margin-left"><input type="checkbox" name="bq_check" checked>  BQ เลขที่</span>
			<?php } else { ?>
				<span class="w3-margin-left"><input type="checkbox" name="bq_check">  BQ เลขที่</span>
			<?php } ?>		
		</div>
		<div class="w3-twothird w3-border-bottom">
			<?php echo $fpr["bq"]; ?>
		</div>
	</div>
	<div class="w3-third">
		<div class="w3-bar w3-third">
			<?php if($fpr["bq_check"]==1) { ?>
				<span class="w3-margin-left"><input type="checkbox" name="bq_check" checked>  BQ เลขที่</span>
			<?php } else { ?>
				<span class="w3-margin-left"><input type="checkbox" name="bq_check">  BQ เลขที่</span>
			<?php } ?>		
		</div>
		<div class="w3-twothird w3-border-bottom">
			<?php echo $fpr["bq"]; ?>
		</div>
	</div>
	<div class="w3-third w3-container">
		<div class="w3-bar">
			<?php if($fpr["full_bill"]==1) { ?>
				<input type="checkbox" name="full_bill" checked> ต้องการใบกำกับภาษีเต็มรูปแบบ
			<?php } else { ?>
				<input type="checkbox" name="full_bill"> ต้องการใบกำกับภาษีเต็มรูปแบบ
			<?php } ?>
		</div>
	</div>
	<div class="w3-bar w3-margin-bottom"></div>
	<div class="w3-half w3-container">
		<div class="w3-bar w3-third w3-margin-top">
			<span>Sale Comment</span>
		</div>
		<div class="w3-bar w3-twothird w3-border-bottom w3-margin-top">
			<?php echo $fpr["sale_comment"]; ?>
		</div>
		<div class="w3-bar">
			<?php if($fpr["with_pr"]==1) { ?>
				<input type="checkbox" name="with_pr" checked>  แนบใบเสนอราคา
			<?php } else { ?>
				<input type="checkbox" name="with_pr">   แนบใบเสนอราคา
			<?php } ?>
		</div>
		<div class="w3-bar w3-twothird">
			<?php if($fpr["book_clear"]==1) {?>
				<input type="checkbox" name="book_clear" checked>  Clear ใบจองสินค้าเลขที่
			<?php } else { ?>
				<input type="checkbox" name="book_clear">  Clear ใบจองสินค้าเลขท
			<?php } ?>
		</div>
		<div class="w3-bar w3-third w3-border-bottom">
			<?php echo $fpr["book_no"]; ?>
		</div>
		<div class="w3-bar"><span><b><i>ไม่ต้องส่งสินค้า</i></b></div>

		<div class="w3-bar w3-twothird">
			<?php if($fpr["book_clear"]==1) {?>
				<input type="checkbox" name="brn_clear" checked>  Clear ใบยืมสินค้าติดเล่ม BRN
			<?php } else { ?>
				<input type="checkbox" name="brn_clear">  Clear ใบยืมสินค้าติดเล่ม BRN
			<?php } ?>
		</div>
		<div class="w3-bar w3-third w3-border-bottom">
			<?php echo $fpr["brn_no"]; ?>
		</div>
		<div class="w3-bar"></div>
		<div class="w3-bar w3-twothird">
			<?php if($fpr["book_clear"]==1) {?>
				<input type="checkbox" name="brnp_clear" checked>  Clear ใบยืมสินค้ากระดาษต่อเนื่อง BRNP
					<?php } else { ?>
				<input type="checkbox" name="brnp_clear">
			<?php } ?>
		</div>
		<div class="w3-bar w3-third w3-border-bottom">
			<?php echo $fpr["brnp_no"]; ?>
		</div>

	</div>

	<div class="w3-half w3-container">
		<div class="w3-bar w3-margin-top"></div>
		<?php if ($fpr["type_type"]==1) { ?>
			<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="1" id="type1" checked> พิมพ์ตามคอม</div>
			<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="2" id="type2"> พิมพ์ตามใบสั่งซื้อ</div>
			<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="3" id="type3"> พิมพ์ตามที่เขียน
				<div id="detail">
					<textarea name="type_detail" class="w3-input  w3-border" style="width:90%;"></textarea>
				</div>
			</div>
		<?php } else if ($fpr["type_type"]==2) { ?>
			<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="1" id="type1"> พิมพ์ตามคอม</div>
			<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="2" id="type2" checked> พิมพ์ตามใบสั่งซื้อ</div>
			<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="3" id="type3"> พิมพ์ตามที่เขียน
				<div id="detail">
					<textarea name="type_detail" class="w3-input  w3-border" style="width:90%;"></textarea>
				</div>
			</div>
		<?php } else if ($fpr["type_type"]==3) { ?>
			<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="1" id="type1"> พิมพ์ตามคอม</div>
			<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="2" id="type2"> พิมพ์ตามใบสั่งซื้อ</div>
			<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="3" id="type3" checked> พิมพ์ตามที่เขียน
				<div id="detail">
					<textarea name="type_detail" class="w3-input w3-border" style="width:90%;" rows="10"><?php echo $fpr["type_detail"]; ?></textarea>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="w3-bar w3-margin-top"></div>
	<div class="w3-bar w3-margin-top"></div>
		<div class="w3-third w3-center">
			<span class="w3-border-bottom"><?php $sale=$fpr["sale"]; $qsale=mysqli_query($conn,"select * from tb_user where em_id='$sale'"); $fsale=(mysqli_fetch_array($qsale)); echo $fsale["name"]." ".$fsale["surname"]." / ".$fsale["code"]." / ".$fpr["date"]; ?></span><br>
			<span>Sale Signature/Area/Date</span>
		</div>
		<div class="w3-third w3-center">
			<span class="w3-border-bottom"><?php echo $fpr["iv_no"]; ?></span><br>
			<span><?php echo $fpr["iv_date"]; ?></span>
		</div>
		<div class="w3-third w3-center">
			<span class="w3-border-bottom"><?php $ap=$fpr["approve"]; $qap=mysqli_query($conn,"select * from tb_user where em_id='$ap'"); $fap=(mysqli_fetch_array($qap)); echo $fap["name"]." ".$fap["surname"]." / ".$fap["code"]." / ".$fpr["approve_date"]; ?></span><br>
			<span>Sale Signature/Area/Date</span>
		</div>
	</div>

</div>
</div>
</div>
<script>
function qtype() {
		if (document.getElementById('type1').checked) {
			document.getElementById('detail').style.display = 'block';
		}
		else if (document.getElementById('type2').checked) {
			document.getElementById('detail').style.display = 'block';
		}
		else if (document.getElementById('type3').checked) {
			document.getElementById('detail').style.display = 'block';
		}
	}
</script>