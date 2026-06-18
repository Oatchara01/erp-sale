<?php include('head.php'); ?>
<script>
	function toggleField(hideObj,showObj){
		hideObj.disabled=true;        
		hideObj.style.display='none';
		showObj.disabled=false;   
		showObj.style.display='inline';
		showObj.focus();
	}

	function toggleField2(hideObj2,showObj2){
		hideObj2.disabled=true;        
		hideObj2.style.display='none';
		showObj2.disabled=false;   
		showObj2.style.display='inline';
		showObj2.focus();
	}


	function openTab(tabName) {
		var i;
		var x = document.getElementsByClassName("tab");
		for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";  
		}
		document.getElementById(tabName).style.display = "block";  
	}

	function qtype() {
		if (document.getElementById('type1').checked) {
			document.getElementById('detail').style.display = 'none';
		}
		else if (document.getElementById('type2').checked) {
			document.getElementById('detail').style.display = 'none';
		}
		else if (document.getElementById('type3').checked) {
			document.getElementById('detail').style.display = 'block';
		}
	}
	function openmaps() {
		if (document.getElementById('mapn').checked) {
			document.getElementById('ityes').style.display = 'block';
		}
		else {
			document.getElementById('ityes').style.display = 'none';
		}
	}
</script>
<?php
	$id = $_GET["id"];
	$view = "select * from hos__so where id='$id'";
	$qview = mysqli_query($conn,$view);
	$fv = mysqli_fetch_array($qview);
?>
<div class="w3-container">
	<div class="w3-panel w3-light-grey"><h3>Edit Sale Order</h3></div>
	<form action="hos_so_edit1.php" method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-bar">
		<?php if($fv["company"]=="PTL") { ?>
			<input type="radio" name="company" value="PTL" checked> <img src="img/ptl64.png">
			<input type="radio" name="company" value="NBM"> <img src="img/nbm64.png">
		<?php } 
		else if($fv["company"]=="NBM") { ?>
			<input type="radio" name="company" value="PTL"> <img src="img/ptl64.png">
			<input type="radio" name="company" value="NBM" checked> <img src="img/nbm64.png">
		<?php } ?>
	</div>
	<input type="hidden" name="id" value="<?php echo $fv["id"]; ?>">
	<div class="w3-bar w3-margin-bottom"></div>
		<div class="w3-half"><!--ครึ่งแรก-->
			<div class="w3-bar 11">
				<div class="w3-half">
					วันที่ <input type="date" name="date" class="w3-input" style="width:90%;" value="<?php echo $fv["date"]; ?>">
				</div>
				<div class="w3-half 12">
					ชื่อผู้แนะนำ/ร.พ./แผนก <input type="text" name="suggest" class="w3-input" style="width:90%;" value="<?php echo $fv["suggest"]; ?>">
				</div>
			</div>
			<div class="w3-bar w3-padding-small"></div>
			<div class="w3-bar 31">
				ชื่อที่ต้องการออกบิล <input type="text" name="bill_name" class="w3-input" style="width:95%;" value="<?php echo $fv["bill_name"]; ?>">
			</div>
			<div class="w3-bar w3-padding-small"></div>
			<div class="w3-bar 32">
				ที่อยู่ที่ใช้ในการออกบิล <input type="text" name="bill_address" class="w3-input" style="width:95%" value="<?php echo $fv["bill_address"]; ?>">
			</div>
			<div class="w3-bar w3-padding-small"></div>
			<div class="w3-half 24">
				เบอร์โทรศัพท์ <input type="text" name="bill_tel" class="w3-input" style="width:90%;" value="<?php echo $fv["bill_tell"]; ?>">
			</div>
			<div class="w3-half 242">
				<div class="w3-bar">ชำระโดย</div> <select name="payment" class="w3-select" style="width:90%; height:90%;"
						onchange="if(this.options[this.selectedIndex].value=='customOption'){
						toggleField(this,this.nextSibling);
						this.selectedIndex='0';}">
						<option value="<?php echo $fv["payment"]; ?>"><?php echo $fv["payment"]; ?></option>
						<option value="เงินสด (C.O.D.)">เงินสด (C.O.D.)</option>
						<option value="Cr.30 วัน">Cr.30 วัน</option>
						<option value="Cr.45 วัน">Cr.45 วัน</option>
						<option value="customOption">อื่น ๆ (พิมพ์)</option>
					</select><input name="payment" style="display:none; width:90%;" class="w3-input" disabled="disabled" onblur="if(this.value==''){toggleField(this,this.previousSibling);}" value="<?php echo $fv["payment"]; ?>">
			</div>				
			
			<div class="w3-bar w3-padding-small"></div>
			
			<div class="w3-half 33">
				ใบสั่งซื้อเลขที่ <input type="text" name="po_no" class="w3-input" style="width:90%;" value="<?php echo $fv["po_no"]; ?>">
			</div>
			<div class="w3-half 34">
				กำหนดส่งตามสัญญา <input type="text" name="delivery_contract" class="w3-input" style="width:90%;" value="<?php echo $fv["delivery_contract"]; ?>">
			</div>
			<div class="w3-bar w3-padding-small"></div>
			<div class="w3-bar">
				สถานที่ติดตั้ง<input name="install_place" class="w3-input" style="width:95%;" value="<?php echo $fv["install_place"]; ?>">
			</div>
			<div class="w3-bar w3-padding-small"></div>
			<div class="w3-bar">
				Sale Comment<textarea name="sale_comment" rows="5" class="w3-input" style="width:95%;"><?php echo $fv["sale_comment"]; ?></textarea>
			</div>
			<div class="w3-bar w3-margin-bottom"></div>
		</div><!-- จบครึ่งแรก -->
		<div class="w3-half"><!-- ครึ่งสอง -->
			<div class="w3-bar w3-pale-blue">
				<!--a class="w3-bar-item w3-button" onclick="openTab('1')"><b>รายการของแถม</b></a-->
				<span class="w3-bar-item w3-button"><b>เพิ่มเติม</b></span>
			</div>
			<div id="1" class="tab w3-padding-small" style="display:none">
				<textarea name="free_items" class="w3-input" rows="5" style="width:100%" hidden></textarea>
			</div>
			<div class="w3-padding-small"></div>
				<div class="w3-half 1 w3-container w3-padding-small"><!-- first right half-->
					<?php if($fv["book_clear"]==1) { ?>
						<div class="w3-bar"><input type="checkbox" name="book_clear" value="1" checked> Clear ใบจองสินค้า เลขที่ <input type="text" name="book_no" class="w3-input" style="width:90%;" value="<?php echo $fv["book_no"]; ?>"></div>
					<?php } else { ?>
						<div class="w3-bar"><input type="checkbox" name="book_clear" value="1"> Clear ใบจองสินค้า เลขที่ <input type="text" name="book_no" class="w3-input" style="width:90%;"></div>
					<?php } ?>
					<div class="w3-padding-small"></div>
					<?php if($fv["brn_clear"]==1) { ?>
						<div class="w3-bar"><input type="checkbox" name="brn_clear" value="1" checked> Clear ใบยืมสินค้าติดเล่ม <input type="text" name="brn_no" class="w3-input" style="width:90%;" value="<?php echo $fv["brn_no"]; ?>"></div>
					<?php } else { ?>
						<div class="w3-bar"><input type="checkbox" name="brn_clear" value="1"> Clear ใบยืมสินค้าติดเล่มี่ <input type="text" name="brn_no" class="w3-input" style="width:90%;"></div>
					<?php } ?>
					<div class="w3-padding-small"></div>
					<?php if($fv["brnp_clear"]==1) { ?>
						<div class="w3-bar"><input type="checkbox" name="brnp_clear" value="1" checked> Clear ใบยืมฯ กระดาษต่อเนื่อง <input type="text" name="brnp_no" class="w3-input" style="width:90%;" value="<?php echo $fv["brnp_no"]; ?>"></div>
					<?php } else { ?>
						<div class="w3-bar"><input type="checkbox" name="brnp_clear" value="1"> Clear ใบยืมฯ กระดาษต่อเนื่อง <input type="text" name="brnp_no" class="w3-input" style="width:90%;"></div>
					<?php } ?>					
					<div class="w3-padding-small"></div>
					<div class="w3-bar">Sale</div>
					<div class="w3-bar">
						<input type="text" name="sale" class="w3-input" style="width:90%;" value="<?php echo $fv["sale"]; ?>">
						<input type="date" name="sale_date" class="w3-input" style="width:90%;" value="<?php echo $fv["sale_date"]; ?>">
					</div>
					<div class="w3-padding-small"></div>
					<div class="w3-bar">
							Approve
							<?php if($fv["approve"]!="") { ?>
								<input type="text" name="approve" class="w3-input" style="width:90%;" value="<?php echo $fv["approve"]; ?>">
								<input type="date" name="approve_time" class="w3-input" style="width:90%;" value="<?php echo $fv["approve_date"]; ?>">
							<?php } else if($fv["approve"]=="") { ?>
								<input type="text" name="approve" class="w3-input w3-light-grey" style="width:90%;">
								<input type="date" name="approve_time" class="w3-input w3-light-grey" style="width:90%;">
							<?php } ?>
					</div>
				</div><!--first right half-->
				<div class="w3-half 2 w3-padding-small"><!--second right half-->
						<div class="w3-bar"><?php if($fv["with_pr"]==1) { ?>
								<input type="checkbox" name="with_pr" value="1" checked> แนบใบเสนอราคา <?php }
							else { ?>
								<input type="checkbox" name="with_pr" value="1"> แนบใบเสนอราคา <?php } ?>
						</div>
						<div class="w3-padding-small"></div>
						<div class="w3-bar"><?php if($fv["full_bill"]==1) { ?>
								<input type="checkbox" name="full_bill" value="1" checked> ต้องการใบกำกับภาษี<?php }
							else { ?>
								<input type="checkbox" name="full_bill" value="1"> ต้องการใบกำกับภาษี <?php } ?>
						</div>
						<div class="w3-padding-small"></div>
						<?php if($fv["type_type"]==1) { ?>
							<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="1" id="type1" checked> พิมพ์ตามคอม</div>
							<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="2" id="type2"> พิมพ์ตามใบสั่งซื้อ</div>
							<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="3" id="type3"> พิมพ์ตามที่เขียน
								<div id="detail" style="display:none">
									<textarea name="type_detail" class="w3-input" style="width:90%;" rows="5"></textarea>
								</div>
							</div>
						<?php } else if($fv["type_type"]==2) { ?>
							<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="1" id="type1"> พิมพ์ตามคอม</div>
							<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="2" id="type2" checked> พิมพ์ตามใบสั่งซื้อ</div>
							<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="3" id="type3"> พิมพ์ตามที่เขียน
								<div id="detail" style="display:none">
									<textarea name="type_detail" class="w3-input" style="width:90%;" rows="5"></textarea>
								</div>
							</div>
						<?php } else if($fv["type_type"]==3) { ?>
							<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="1" id="type1"> พิมพ์ตามคอม</div>
							<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="2" id="type2"> พิมพ์ตามใบสั่งซื้อ</div>
							<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="3" id="type3" checked> พิมพ์ตามที่เขียน
								<div id="detail" style="display:block">
									<textarea name="type_detail" class="w3-input" style="width:90%;" rows="5"><?php echo $fv["type_detail"]; ?></textarea>
								</div>
							</div>
						<?php } ?>
						<div class="w3-padding-small"></div>
						<div class="w3-bar">อัพโหลดสลิป</div>
						<div class="w3-bar"><?php if($fv["slip1"]!="") { ?>
							<a href="slip/<?php echo $fv["slip1"]; ?>" target="_blank"><?php echo $fv["slip1"]; ?></a>
						<?php } else { ?>
							<input type="file" name="slip1">
						<?php } ?>
						</div>
						<div class="w3-bar"><?php if($fv["slip2"]!="") { ?>
							<a href="slip/<?php echo $fv["slip2"]; ?>" target="_blank"><?php echo $fv["slip2"]; ?></a>
						<?php } else { ?>
							<input type="file" name="slip2">
						<?php } ?>
						</div><div class="w3-bar"><?php if($fv["slip3"]!="") { ?>
							<a href="slip/<?php echo $fv["slip3"]; ?>" target="_blank"><?php echo $fv["slip3"]; ?></a>
						<?php } else { ?>
							<input type="file" name="slip3">
						<?php } ?>
						</div><div class="w3-bar"><?php if($fv["slip4"]!="") { ?>
							<a href="slip/<?php echo $fv["slip4"]; ?>" target="_blank"><?php echo $fv["slip4"]; ?></a>
						<?php } else { ?>
							<input type="file" name="slip4">
						<?php } ?>
						</div><div class="w3-bar"><?php if($fv["slip5"]!="") { ?>
							<a href="slip/<?php echo $fv["slip5"]; ?>" target="_blank"><?php echo $fv["slip5"]; ?></a>
						<?php } else { ?>
							<input type="file" name="slip5">
						<?php } ?>
						</div>
						<span style="color:red"><small>ไฟล์รูปภาพเท่านั้น</small></span>
				</div><!--second right half-->
			<div class="w3-bar w3-padding-small"></div>			
		</div><!-- จบครึ่งสอง -->
		<div class="w3-bar w3-margin-bottom"><!-- ท่อนล่าง -->
			<div class="w3-bar w3-pale-green">
				<!--a class="w3-bar-item w3-button" onclick="openTab('1')"><b>รายการของแถม</b></a-->
				<a class="w3-bar-item w3-button" onclick="openTab('14')"><b>ข้อมูลสินค้า</b></a>
				<a class="w3-bar-item w3-button" onclick="openTab('3')"><b>การจัดส่ง</b></a>
			</div>
			<div id="14" class="tab w3-padding-small">
				<div style="overflow-x:auto;">
					<table width="100%" border="0" id="myTable" class="w3-table w3-striped">
					<!-- head table -->
					<thead class="w3-border w3-pale-blue">
					  <tr>
						<td style='width:5%;'> <div align="center"># </div></td>
						<td style='width:10%;'> <div align="center">รหัส </div></td>
						<td style='width:15%;'> <div align="center">ชื่อสินค้า </div></td>
						<td style='width:5%;'> <div align="center">จำนวน </div></td>
						<td style='width:5%;'> <div align="center">หน่วย </div></td>
						<td style='width:5%;'> <div align="center">ราคา </div></td>
						<td style='width:5%;'> <div align="center">ส่วนลด </div></td>
						<td style='width:10%;'> <div align="center">ราคารวม </div></td>
						<td style='width:5%;'> <div align="center">รับประกัน </div></td>
						<td style='width:5%;'> <div align="center">CAL </div></td>
						<td style='width:5%;'> <div align="center">PM </div></td>
						<td style='width:15%;'> <div align="center">หมายเหตุ </div></td>
					  </tr>
					</thead>
					<?php
							$ref_id = $fv["ref_id"];
							$pd = mysqli_query($conn,"select hos__subso.*,tb_product.* from hos__subso left join tb_product on (hos__subso.product_id=tb_product.product_ID) where hos__subso.ref_id='$ref_id' order by id asc");
							while ($fpd = mysqli_fetch_array($pd)) {
						?>
						<tr>
							<td><input type="hidden" name="id" id="id" value="<?php echo $fpd["id"]; ?>"><input type="hidden" name="product_id" id="product_id" value="<?php echo $fpd["product_id"]; ?>"></td>
							<td><input name="access_code" id="access_code" class="w3-input" style="width:90%;" value="<?php echo $fpd["access_code"]; ?>"></td>
							<td><input name="access_name" id="access_name" class="w3-input" style="width:90%;" value="<?php echo $fpd["access_name"]; ?>"></td>
							<td><input name="count" id="count" class="w3-input" style="width:90%;" value="<?php echo $fpd["count"]; ?>"></td>
							<td><input name="unit" id="unit" class="w3-input" style="width:90%;" value="<?php echo $fpd["unit"]; ?>"></td>
							<td><input name="price" id="price" class="w3-input" style="width:90%;" value="<?php echo $fpd["price"]; ?>"></td>
							<td><input name="discount" id="discount" class="w3-input" style="width:90%;" value="<?php echo $fpd["discount"]; ?>"></td>
							<td><input name="amount" id="amount" class="w3-input" style="width:90%;" value="<?php echo $fpd["amount"]; ?>"></td>
							<td><input name="warranty" id="warranty" class="w3-input" style="width:90%;" value="<?php echo $fpd["warranty"]; ?>"></td>
							<td><input name="cal" id="cal" class="w3-input" style="width:90%;" value="<?php echo $fpd["cal"]; ?>"></td>
							<td><input name="pm" id="pm" class="w3-input" style="width:90%;" value="<?php echo $fpd["pm"]; ?>"></td>
							<td><input name="sale_remark" id="sale_remark" class="w3-input" style="width:90%;" value="<?php echo $fpd["sale_remark"]; ?>"></td>
						</tr>
						<?php } ?>
					<!-- body dynamic rows -->
					<tbody class="w3-border">
						
					</tbody>
					</table>
				</div>
			</div><!--div14-->
			<div id="3" class="tab w3-padding-small" style="display:none">
				<?php if($fv["delivery_type"]==1) { ?>
					<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8" checked>&nbsp;Sale รับเอง
					<input type="radio" name="delivery_type" value="2"  onclick="javascript:ckk_2();" id="object9">&nbsp;ช่างรับเอง<br />
					<input type="radio" name="delivery_type" value="3"  onclick="javascript:ckk_2();" id="object10">&nbsp;ลูกค้ารับเอง 
					<input type="radio" name="delivery_type" value="4"  onclick="javascript:ckk_2();" id="object11">&nbsp;บริษัทจัดส่ง <br />
				
				<div id="dv1" style="display:block"><!-- dv1 -->
					<div class="w3-half w3-container"><!-- first half -->
						วันที่รับ/ส่ง
						<input type="date" name="delivery_date" class="w3-input" value="<?php echo $fv["delivery_date"]; ?>">
						เวลารับ/ส่ง
						<input type="text" name="delivery_time" class="w3-input" value="<?php echo $fv["delivery_time"]; ?>">
						สถานที่รับ/ส่งสินค้า
						<textarea name="delivery_place" class="w3-input" rows="1" style="width:100%;resize: none" ><?php echo $fv["delivery_date"]; ?></textarea>
						ชื่อผู้ติดต่อ/TEL.
						<input type="text" name="delivery_contact" class="w3-input" value="<?php echo $fv["delivery_contact"]; ?>">
					</div><!-- first half -->
				</div><!-- dv1 -->
				<?php } ?>
				<?php if($fv["delivery_type"]==2) { ?>
					<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8">&nbsp;Sale รับเอง
					<input type="radio" name="delivery_type" value="2"  onclick="javascript:ckk_2();" id="object9" checked>&nbsp;ช่างรับเอง<br />
					<input type="radio" name="delivery_type" value="3"  onclick="javascript:ckk_2();" id="object10">&nbsp;ลูกค้ารับเอง 
					<input type="radio" name="delivery_type" value="4"  onclick="javascript:ckk_2();" id="object11">&nbsp;บริษัทจัดส่ง <br />
				
				<div id="dv1" style="display:block"><!-- dv1 -->
					<div class="w3-half w3-container"><!-- first half -->
						วันที่รับ/ส่ง
						<input type="date" name="delivery_date" class="w3-input" value="<?php echo $fv["delivery_date"]; ?>">
						เวลารับ/ส่ง
						<input type="text" name="delivery_time" class="w3-input" value="<?php echo $fv["delivery_time"]; ?>">
						สถานที่รับ/ส่งสินค้า
						<textarea name="delivery_place" class="w3-input" rows="1" style="width:100%;resize: none" ><?php echo $fv["delivery_date"]; ?></textarea>
						ชื่อผู้ติดต่อ/TEL.
						<input type="text" name="delivery_contact" class="w3-input" value="<?php echo $fv["delivery_contact"]; ?>">
					</div><!-- first half -->
				</div><!-- dv1 -->
				<?php } ?>
				<?php if($fv["delivery_type"]==3) { ?>
					<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8">&nbsp;Sale รับเอง
					<input type="radio" name="delivery_type" value="2"  onclick="javascript:ckk_2();" id="object9">&nbsp;ช่างรับเอง<br />
					<input type="radio" name="delivery_type" value="3"  onclick="javascript:ckk_2();" id="object10" checked>&nbsp;ลูกค้ารับเอง 
					<input type="radio" name="delivery_type" value="4"  onclick="javascript:ckk_2();" id="object11">&nbsp;บริษัทจัดส่ง <br />
				
				<div id="dv1" style="display:block"><!-- dv1 -->
					<div class="w3-half w3-container"><!-- first half -->
						วันที่รับ/ส่ง
						<input type="date" name="delivery_date" class="w3-input" value="<?php echo $fv["delivery_date"]; ?>">
						เวลารับ/ส่ง
						<input type="text" name="delivery_time" class="w3-input" value="<?php echo $fv["delivery_time"]; ?>">
						สถานที่รับ/ส่งสินค้า
						<textarea name="delivery_place" class="w3-input" rows="1" style="width:100%;resize: none" ><?php echo $fv["delivery_date"]; ?></textarea>
						ชื่อผู้ติดต่อ/TEL.
						<input type="text" name="delivery_contact" class="w3-input" value="<?php echo $fv["delivery_contact"]; ?>">
					</div><!-- first half -->
				</div><!-- dv1 -->
				<?php } ?>
				<?php if($fv["delivery_type"]==4) { ?>
					<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8">&nbsp;Sale รับเอง
					<input type="radio" name="delivery_type" value="2"  onclick="javascript:ckk_2();" id="object9">&nbsp;ช่างรับเอง<br />
					<input type="radio" name="delivery_type" value="3"  onclick="javascript:ckk_2();" id="object10">&nbsp;ลูกค้ารับเอง 
					<input type="radio" name="delivery_type" value="4"  onclick="javascript:ckk_2();" id="object11" checked>&nbsp;บริษัทจัดส่ง <br />
				<div id="dv1" style="display:none"><!-- dv1 -->
					<div class="w3-half w3-container"><!-- first half -->
						วันที่รับ/ส่ง
						<input type="date" name="delivery_date" class="w3-input" value="<?php echo $fv["delivery_date"]; ?>">
						เวลารับ/ส่ง
						<input type="text" name="delivery_time" class="w3-input" value="<?php echo $fv["delivery_time"]; ?>">
						สถานที่รับ/ส่งสินค้า
						<textarea name="delivery_place" class="w3-input" rows="1" style="width:100%;resize: none" ><?php echo $fv["delivery_date"]; ?></textarea>
						ชื่อผู้ติดต่อ/TEL.
						<input type="text" name="delivery_contact" class="w3-input" value="<?php echo $fv["delivery_contact"]; ?>">
					</div><!-- first half -->
				</div><!-- dv1 -->
				<?php $cs = mysqli_query($conn,"select * from hos__cs where ref_id='$ref_id'");
				      $fcs = mysqli_fetch_array($cs);
				?>
				<div id="dv2" style="display:none"><!-- dv2 -->
					<div class="w3-container w3-third"><!-- first third -->
						<div class="w3-bar">
							วันที่ รับ-ส่ง
							<input name="start_date" type='date' id="start_date" class="w3-input" value="<?php echo $fcs["start_date"]; ?>"/>
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							วันที่ต้องการโดยประมาณ
							<input name="date_requir"  class="w3-input" type='text' id="date_requir" value="<?php echo $fcs["date_requir"]; ?>" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-half">เวลา
							<input id="start_time"  name="start_time"  class="w3-input" type="text"  style="width:99%;"/ value="<?php echo $fcs["start_time"]; ?>">
						</div>
						<div class="w3-half">ถึง
							<input id="end_time" name="end_time"  class="w3-input" type="text" value="<?php echo $fcs["end_time"]; ?>"/>
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							สถานะการทำงาน 
							<?php if($fcs["work_status"]=="ส่ง") { ?>
								<input type='radio'  name="work_status" id = "work_status" value="ส่ง" checked="checked"/>  ส่ง
								&nbsp; <input type="radio"  name="work_status" id = "work_status" value="รับ" />  รับ
							<?php } else { ?>
								<input type='radio'  name="work_status" id = "work_status" value="ส่ง" />  ส่ง
								&nbsp; <input type="radio"  name="work_status" id = "work_status" value="รับ" checked="checked"/>  รับ
							<?php } ?>
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							สถานะ 
							<input name="status_comment" type='text' id="status_comment" class="w3-input" value="<?php echo $fcs["status_comment"]; ?>">
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							แผนก - ฝ่าย
							<input type="text" name="department_show" id="department_show" class="w3-input" value="ฝ่ายขาย">
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							ประเภทลูกค้า
							<select name="customer_typename" id="customer_typename" class="w3-select">
								<option value="<?php echo $fcs["customerr_typename"]; ?>"><?php echo $fcs["customer_typename"]; ?></option>
								<option value="ร้านขายยา">ร้านขายยา</option>
								<option value="ลูกค้าทั่วไป">ลูกค้าทั่วไป</option>
								<option value="โรงพยาบาล">โรงพยาบาล</option>
							</select>
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							หน่วยงาน
							<select name="company_name" id="company_name" class="w3-select">
								<option value="<?php echo $fcs["company_name"]; ?>"><?php echo $fcs["company_name"]; ?></option>
								<option value="ฟาร์ ทริลเลี่ยน บจก.">ฟาร์ ทริลเลี่ยน บจก.</option>
								<option value="โนเบิล เมด บจก.">โนเบิล เมด บจก.</option>
								<option value="อื่นๆ">อื่นๆ</option>				
							</select>
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							ประเภทงาน
							<input type="text" name="department_name" id="department_name" class="w3-input" value="Sale">
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
					</div><!-- first third -->
					<div class="w3-container w3-third"><!-- second third -->
						<div class="w3-bar w3-half">
							<?php if($fcs["cash"]==1) { ?>
								<input type="checkbox"  name="cash" id = "cash"  value="1" checked>  เก็บเงินสด
								<input name="unit_cash" type='text' class="w3-input" id="unit_cash" style="color:black;text-align:right;width:99%;" OnChange="JavaScript:chkNum(this)" value="<?php echo $fcs["unit_cash"]; ?>">
							<?php } else { ?>
								<input type="checkbox"  name="cash" id = "cash"  value="1">  เก็บเงินสด
								<input name="unit_cash" type='text' class="w3-input" id="unit_cash" style="color:black;text-align:right;width:99%;" OnChange="JavaScript:chkNum(this)" value="<?php echo $fcs["unit_cash"]; ?>">
							<?php } ?>
						</div>
						<div class="w3-bar w3-half">
							<?php if($fcs["check_paper"]==1) { ?>
								<input type="checkbox"  name="check_paper" id = "check_paper" value="1" checked>  รับเช็ค
								<input name="unit_check" type='text' class="w3-input"  id="unit_check" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)" value="<?php echo $fcs["unit_check"]; ?>"/ >
							<?php } else { ?>
								<input type="checkbox"  name="check_paper" id = "check_paper" value="1">  รับเช็ค
								<input name="unit_check" type='text' class="w3-input"  id="unit_check" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)" value="<?php echo $fcs["unit_check"]; ?>"/ >
							<?php } ?>
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar w3-half">
							<?php if($fcs["credit_card"]==1) { ?>
								<input type="checkbox"  id = "credit_card" name="credit_card" value="1" checked>  รูดการ์ด 
								<input name="unit_credit" type='text' class="w3-input"  id="unit_credit" style="color:black;text-align:right;width:99%;"  OnChange="JavaScript:chkNum(this)" value="<?php echo $fcs["unit_credit"]; ?>"/>
							<?php } else { ?>
								<input type="checkbox"  id = "credit_card" name="credit_card" value="1">  รูดการ์ด 
								<input name="unit_credit" type='text' class="w3-input"  id="unit_credit" style="color:black;text-align:right;width:99%;"  OnChange="JavaScript:chkNum(this)" value="<?php echo $fcs["unit_credit"]; ?>"/>
							<?php } ?>
						</div>
						<div class="w3-bar w3-half">
							<?php if($fcs["bill"]==1) { ?>
								<input type="checkbox"  id = "bill" name="bill" value="1" checked>  วางบิล
								<input name="unit_bill" type='text' class="w3-input" style="color:black;text-align:right" id="unit_bill" OnChange="JavaScript:chkNum(this)" value="<?php echo $fcs["unit_bill"]; ?>"/>
							<?php } else { ?>
								<input type="checkbox"  id = "bill" name="bill" value="1">  วางบิล
								<input name="unit_bill" type='text' class="w3-input" style="color:black;text-align:right" id="unit_bill" OnChange="JavaScript:chkNum(this)" value="<?php echo $fcs["unit_bill"]; ?>"/>
							<?php } ?>
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar w3-half">
							<?php if($fcs["tran"]==1) { ?>
								<input type="checkbox"  name="tran"id = "tran"  value="1" checked>  ลูกค้าโอนเงินหน้างาน
								<input name="unit_tran" type='text' class="w3-input" id="unit_tran" style="color:black;text-align:right;width:99%;" rows="1"OnChange="JavaScript:chkNum(this)" value="<?php echo $fcs["unit_tran"]; ?>">
							<?php } else { ?>
								<input type="checkbox"  name="tran"id = "tran"  value="1">  ลูกค้าโอนเงินหน้างาน
								<input name="unit_tran" type='text' class="w3-input" id="unit_tran" style="color:black;text-align:right;width:99%;" rows="1"OnChange="JavaScript:chkNum(this)" value="<?php echo $fcs["unit_tran"]; ?>">
							<?php } ?>
						</div>
						<div class="w3-bar w3-half">
							<?php if($fcs["dep"]==1) { ?>
								<input type="checkbox" id = "dep" name="dep" value="1" checked>  อื่นๆ
								<input name="dept" type='text' class="w3-input" id="dept" value="<?php echo $fcs["dept"]; ?>"/>
							<?php } else { ?>
								<input type="checkbox" id = "dep" name="dep" value="1">  อื่นๆ
								<input name="dept" type='text' class="w3-input" id="dept" value="<?php echo $fcs["dept"]; ?>"/>
							<?php } ?>
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							<?php if($fcs["want_bus"]==1) { ?>
								<input type="checkbox" name="want_bus" value="1" checked>  ต้องการรถใหญ่
							<?php } else { ?>
								<input type="checkbox" name="want_bus" value="1">  ต้องการรถใหญ
							<?php } ?>
						</div>
						<div class="w3-bar">
							<?php if($fcs["fix_date"]==1) { ?>
								<input type="checkbox"  name="fix_date" id = "fix_date" value="1" checked>  นัดวันและเวลาเรียบร้อยแล้ว 
							<?php } else { ?>
								<input type="checkbox"  name="fix_date" id = "fix_date" value="1">  นัดวันและเวลาเรียบร้อยแล้ว 
							<?php } ?>
						</div>
						<div class="w3-bar">
							<?php if($fcs["no_money"]==1) { ?>
								<input type="checkbox" id = "no_money" name="no_money" value="1" checked>  ไม่ต้องเก็บเงิน
							<?php } else { ?>
								<input type="checkbox" id = "no_money" name="no_money" value="1">  ไม่ต้องเก็บเงิน
							<?php } ?>
						</div>
						<div class="w3-bar">
							<?php if($fcs["call_customer"]==1) { ?>
								<input type="checkbox"  id = "call_customer" name="call_customer" value="1" checked>  โทรแจ้งลูกค้าก่อนไป
							<?php } else { ?>
								<input type="checkbox"  id = "call_customer" name="call_customer" value="1">  โทรแจ้งลูกค้าก่อนไป
							<?php } ?>
						</div>
						<div class="w3-bar">
							<?php if($fcs["call_back"]==1) { ?>
								<input type="checkbox"  id = "call_back" name="call_back" value="1" checked>  ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
							<?php } else { ?>
								<input type="checkbox"  id = "call_back" name="call_back" value="1">  ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
							<?php } ?>
						</div>
						<div class="w3-bar">
							<?php if($fcs["have_map"]==1) { ?>
								<input type="checkbox" name="have_map" id="have_map" value="1" checked>  มีแผนที่ประกอบ
							<?php } else { ?>
								<input type="checkbox" name="have_map" id="have_map" value="1">  มีแผนที่ประกอบ
							<?php } ?>
						</div>
							<div id="have_map-2" style="display:block;">
								<div class="w3-bar"><?php if($fv["mapfile1"]!="") { ?>
							<a href="slip/<?php echo $fv["mapfile1"]; ?>" target="_blank"><?php echo $fv["mapfile1"]; ?></a>
						<?php } else { ?>
							<input type="file" name="mapfile1">
						<?php } ?>
						</div>
						<div class="w3-bar"><?php if($fv["mapfile2"]!="") { ?>
							<a href="slip/<?php echo $fv["mapfile2"]; ?>" target="_blank"><?php echo $fv["mapfile2"]; ?></a>
						<?php } else { ?>
							<input type="file" name="mapfile2">
						<?php } ?>
						</div><div class="w3-bar"><?php if($fv["mapfile3"]!="") { ?>
							<a href="slip/<?php echo $fv["mapfile3"]; ?>" target="_blank"><?php echo $fv["mapfile3"]; ?></a>
						<?php } else { ?>
							<input type="file" name="mapfile3">
						<?php } ?>
						</div><div class="w3-bar"><?php if($fv["mapfile4"]!="") { ?>
							<a href="slip/<?php echo $fv["mapfile4"]; ?>" target="_blank"><?php echo $fv["mapfile4"]; ?></a>
						<?php } else { ?>
							<input type="file" name="mapfile4">
						<?php } ?>
						</div><div class="w3-bar"><?php if($fv["mapfile5"]!="") { ?>
							<a href="slip/<?php echo $fv["mapfile5"]; ?>" target="_blank"><?php echo $fv["mapfile5"]; ?></a>
						<?php } else { ?>
							<input type="file" name="mapfile5">
						<?php } ?>
						</div>
							</div>
						</fieldset>
					</div><!-- second third -->
					<div class="w3-container w3-third"><!-- third third -->
						<div class="w3-bar">
							ชื่อโรงพยาบาล
							<input type='text' class="w3-input" name="address_name" value="<?php echo $fcs["address_name"]; ?>">  
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							  ที่อยู่ 
							<textarea   class="w3-input" name="address_send" cols="54" rows="1"><?php echo $fcs["address_send"]; ?></textarea>
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							เลขที่เอกสาร/เลขที่เครื่อง 
							<textarea name="product_sn"  class="w3-input" id="product_sn" cols="54" rows="1"><?php echo $fcs["product_sn"]; ?>"</textarea>
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							สินค้า/เอกสาร 
							<input type="text" name="product"  class="w3-input" id="product" value="<?php echo $fcs["product"]; ?>">
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							ชื่อผู้ติดต่อ
							<input name="customer_name"  class="w3-input" type='text' id="customer_name" value="<?php echo $fcs["customer_name"]; ?>">
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							 ผู้รับสินค้า
							<input name="customer_contact"  class="w3-input" type='text' id="customer_contact" value="<?php echo $fcs["customer_contact"]; ?>">
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							 เบอร์โทรลูกค้า 
							<input name="customer_tel"  class="w3-input" type='text' id="customer_tel" value="<?php echo $fcs["customer_tel"]; ?>">
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							รายละเอียดเพิ่มเติม 
							<textarea name="description"  class="w3-input" id="description" cols="54" rows="1"><?php echo $fcs["description"]; ?></textarea>
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
					</div><!-- third third -->
					<div class="w3-bar w3-margin-bottom"></div>
					<?php
						$more = mysqli_query($conn,"select * from hos__csmore where ref_id='$ref_id'");
						$fm = mysqli_fetch_array($more);
					?>
					<fieldset><legend><input type="checkbox" name="more" id="more" value="1"> <b>รายละเอียดการจัดส่ง</b></legend>
					<div id="more-2" style="display:none;">
						<div class="w3-third 112">
							<div class="w3-bar 1">
								<?php if($fm["runway"]==1) { ?>
									<input type="checkbox" name="runway" id ="runway" value="1" checked> ติดถนนรันเวย์
								<?php } else { ?>
									<input type="checkbox" name="runway" id ="runway" value="1"> ติดถนนรันเวย์
								<?php } ?>
							</div>
							<div class="w3-bar 2">
								<?php if($fm["road"]==1) { ?>
									<input type="checkbox" name="road" id = "road" value="1" checked> ติดถนนวิ่งสวนกัน
								<?php } else { ?>
									<input type="checkbox" name="road" id = "road" value="1"> ติดถนนวิ่งสวนกัน
								<?php } ?>
							</div>
							<div class="w3-bar 3">
								<?php if($fm["soy"]==1) { ?>
									<input type="checkbox" name="soy"id = "soy" value="1" checked> เข้าซอย
								<?php } else { ?>
									<input type="checkbox" name="soy"id = "soy" value="1"> เข้าซอย
								<?php } ?>
							</div>
							<div class="w3-bar 4">
								ทางเข้ากว้าง
								<input name="soy_big" class="w3-input" type='text' id="soy_big" style="color:black;text-align:left;width:90%;" value="<?php echo $fm["soy_big"]; ?>" />
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 5">
								<?php if($fm["height_ltd"]==1) { ?>
									<input type="checkbox" name="height_ltd" id = "height_ltd" value="1" checked> มีตัวจำกัดความสูง
								<?php } else { ?>
									<input type="checkbox" name="height_ltd" id = "height_ltd" value="1"> มีตัวจำกัดความสูง
								<?php } ?>
							</div>
							<div class="w3-bar 6">
								<?php if($fm["car_load"]==1) { ?>
									<input type="checkbox" name="car_load"id = "car_load" value="1" checked> รถยนต์สามารถเข้าได้
								<?php } else { ?>
									<input type="checkbox" name="car_load"id = "car_load" value="1"> รถยนต์สามารถเข้าได
								<?php } ?>
							</div>
							<div class="w3-bar 7">
								<?php if($fm["no_car_road"]==1) { ?>
									<input type="checkbox" name="no_car_road"id = "no_car_road" value="1" checked> รถยนต์เข้าไม่ได้ สามารถจอดได้ที่ 
								<?php } else { ?>
									<input type="checkbox" name="no_car_road"id = "no_car_road" value="1"> รถยนต์เข้าไม่ได้ สามารถจอดได้ที่ 
								<?php } ?>
									<input name="car_park" class="w3-input" type='text' id="car_park" style="width:90%;" value="<?php echo $fm["car_park"]; ?>"/>
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 8">
								การจอดรถ
							</div>
							<div class="w3-bar 9">
								<?php if($fm["car_road"]==1) { ?>
									<input type="checkbox" name="car_road" id = "car_road" value="1" checked> จอดรถข้างถนน
								<?php } else { ?>
									<input type="checkbox" name="car_road" id = "car_road" value="1"> จอดรถข้างถนน
								<?php } ?>
							</div>
							<div class="w3-bar 10">
								<?php if($fm["car_home"]==1) { ?>
									<input type="checkbox" name="car_home"id = "car_home" value="1" checked> จอดรถหน้าบ้านได้
								<?php } else { ?>
									<input type="checkbox" name="car_home"id = "car_home" value="1"> จอดรถหน้าบ้านได้
								<?php } ?>
							</div>
							<div class="w3-bar 11">
								ประตูหน้าบ้านสูง
								<input name="door_long" class="w3-input" type='text' id="door_long" style="color:black;text-align:left;width:90%;" value="<?php echo $fm["door_long"]; ?>" />
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 12">
								<?php if($fm["slope"]==1) { ?>
									<input type="checkbox" name="slope"id = "slope" value="1" checked> มีทางราบก่อนประตูบ้าน
								<?php } else { ?>
									<input type="checkbox" name="slope"id = "slope" value="1"> มีทางราบก่อนประตูบ้าน
								<?php } ?>
							</div>
							<div class="w3-bar 13">
								<?php if($fm["bundai"]==1) { ?>
									<input type="checkbox" name="bundai"id = "bundai" value="1" checked> มีบันไดก่อนประตูบ้าน
								<?php } else { ?>
									<input type="checkbox" name="bundai"id = "bundai" value="1"> มีบันไดก่อนประตูบ้าน
								<?php } ?>
							</div>
							<div class="w3-bar 14">
								<input name="unit_bundai" class="w3-input" type='text' id="unit_bundai" style="width:90%;" value="<?php echo $fm["unit_bundai"]; ?>" />
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 15">
								ประตูบ้านกว้าง
								<input name="door_bigger" class="w3-input" type='text' id="door_bigger" style="width:90%;" value="<?php echo $fm["door_bigger"]; ?>" />
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 16">
								ประตูสูง 
								<input name="door_longer" class="w3-input" type='text' id="door_longer" style="width:90%;" value="<?php echo $fm["door_longer"]; ?>" />
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 17">
								ประตูห้องกว้าง 
								<input name="room_bigger" class="w3-input" type='text' id="room_bigger" style="width:90%;" value="<?php echo $fm["room_bigger"]; ?>" />
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 18">
								ประตูห้องสูง 
								<input name="room_longer" class="w3-input" type='text' id="room_longer" style="width:90%;" value="<?php echo $fm["room_longer"]; ?>" />
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
						</div>
						<div class="w3-third 212">
							<div class="w3-bar 1">
								ประตูบ้านเป็นแบบ
								<input name="type_door" class="w3-input" type='text' id="type_door" style="width:90%;" value="<?php echo $fm["type_door"]; ?>" />
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 2">
								พื้นบ้านเป็นแบบ
								<input name="home_type" class="w3-input" type='text' id="home_type" style="width:90%;" value="<?php echo $fm["home_type"]; ?>"/>
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 3">
								ติดตั้งที่ชั้น
								<input name="install" class="w3-input" type='text' id="install" style="width:90%;" value="<?php echo $fm["install"]; ?>"/>
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 4">
								<?php if($fm["bundai_install"]==1) { ?>
									<input type="checkbox" name="bundai_install"id ="bundai_install" value="1" checked> บันไดกว้าง
								<?php } else { ?>
									<input type="checkbox" name="bundai_install"id ="bundai_install" value="1"> บันไดกว้าง
								<?php } ?>
							</div>
							<div class="w3-bar 5">
								<input name="bundai_big" class="w3-input" type='text' id="bundai_big" style="width:90%;" value="<?php echo $fm["bundai_big"]; ?>" />
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 6">
								หักมุมบันได
								<input name="bundai_hug" class="w3-input" type='text' id="bundai_hug" style="width:90%;" value="<?php echo $fm["bundai_hug"]; ?>"/>
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 7">
								ชนิดของบันได
								<input name="type_bundai" class="w3-input" type='text' id="type_bundai" style="width:90%;" value="<?php echo $fm["type_bundai"]; ?>"/>
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 8">
								<?php if($fm["lip"]==1) { ?>
									<input type="checkbox" name="lip"id = "lip" value="1" checked> ลิฟท์กว้าง
								<?php } else { ?>
									<input type="checkbox" name="lip"id = "lip" value="1"> ลิฟท์กว้าง
								<?php } ?>
							</div>
							<div class="w3-bar 9">
								<input name="lip_big" class="w3-input" type='text' id="lip_big" style="width:90%;" value="<?php echo $fm["lip_big"]; ?>" />
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 10">
								สูง
								<input name="lip_long" class="w3-input" type='text' id="lip_long" style="width:90%;" value="<?php echo $fm["lip_long"]; ?>" />
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 11">
								รับน้ำหนักได้ 
								<input name="lip_weight" class="w3-input" type='text' id="lip_weight" style="width:90%;" value="<?php echo $fm["lip_weight"]; ?>"/>
							</div>
						</div>
						<div class="w3-third 312">
							<div class="w3-bar 12">
								<?php if($fm["up"]==1) { ?>
									<input type="checkbox" name="up"id ="up" value="1" checked> ขึ้นลิฟท์ได้
								<?php } else { ?>
									<input type="checkbox" name="up"id ="up" value="1"> ขึ้นลิฟท์ได้
								<?php } ?>
							</div>
							<div class="w3-bar 13">
								<?php if($fm["no_up"]==1) { ?>
									<input type="checkbox" name="no_up"id ="no_up" value="1" checked> ขึ้นลิฟท์ไม่ได้
								<?php } else { ?>
									<input type="checkbox" name="no_up"id ="no_up" value="1"> ขึ้นลิฟท์ไม่ได้
								<?php } ?>
							</div>
							<div class="w3-bar 14">
								<?php if($fm["head_bad"]==1) { ?>
									<input type="checkbox" name="head_bad" id ="head_bad" value="1" checked> ต้องถอดหัวเตียง-ท้ายเตียง
								<?php } else { ?>
									<input type="checkbox" name="head_bad" id ="head_bad" value="1"> ต้องถอดหัวเตียง-ท้ายเตียง
								<?php } ?>
							</div>
							<div class="w3-bar 15">
								<?php if($fm["want_employee"]==1) { ?>
									<input type="checkbox" name="want_employee"id ="want_employee" value="1" checked> ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์
								<?php } else { ?>
									<input type="checkbox" name="want_employee"id ="want_employee" value="1"> ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์
								<?php } ?>
							</div>
							<div class="w3-bar 16">
								จำนวนคนที่ใช้ 
								<input name="employee_unit" class="w3-input" type='text' id="employee_unit" style="width:90%;" value="<?php echo $fm["employee_unit"]; ?>"/>
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 17">
								ย้ายเฟอร์นิเจอร์ 
								<input name="ferniger_name" class="w3-input" type='text' id="ferniger_name" style="width:90%;" value="<?php echo $fm["ferniger_name"]; ?>"/>
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar 18">
								ย้ายไปที่ 
								<input name="ferniger_address" class="w3-input" type='text' id="ferniger_address" style="width:90%;" value="<?php echo $fm["ferniger_address"]; ?>"/>
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar">
								<?php if($fm["want_ex"]==1) { ?>
									<input type="checkbox" name="want_ex"id = "want_ex" value="1" checked> ต้องเตรียมอุปกรณ์ไปถอดประกอบ
								<?php } else { ?>
									<input type="checkbox" name="want_ex"id = "want_ex" value="1"> ต้องเตรียมอุปกรณ์ไปถอดประกอบ
								<?php } ?>
							</div>
							<div class="w3-bar">
								<?php if($fm["want_credit"]==1) { ?>
									<input type="checkbox" name="want_credit"id = "want_credit" value="1" checked> ต้องเตรียมเครื่องรูดบัตร
								<?php } else { ?>
									<input type="checkbox" name="want_credit"id = "want_credit" value="1"> ต้องเตรียมเครื่องรูดบัตร
								<?php } ?>
							</div>
							<div class="w3-bar">
								ธนาคาร 
								<input name="bank" class="w3-input" type='text' id="bank" style="width:90%;" value="<?php echo $fm["bank"]; ?>"/>
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar">
								<?php if($fm["want_prem"]==1) { ?>
									<input type="checkbox" name="want_prem"id ="want_prem" value="1" checked> ต้องการให้เตรียมฟรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า
								<?php } else { ?>
									<input type="checkbox" name="want_prem"id ="want_prem" value="1"> ต้องการให้เตรียมฟรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า
								<?php } ?>
							</div>
							<div class="w3-bar w3-margin-bottom"></div>
							<div class="w3-bar">
								รายละเอียดเพิ่มเติม
								<textarea name="description_ja" class="w3-input" id="description_ja" cols="54" rows="1" style="width:90%;"><?php echo $fm["description_ja"]; ?></textarea>
							</div>
						</div>
					</div>
					</fieldset>
				</div><!-- dv2 -->
			<?php } ?>
		</div><!-- จบท่อนล่าง -->
		<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="แก้ไขข้อมูล">
		</div>
	</form>
</div>
<?php include('foot.php'); ?>
<script>
$('#more').click(function() {
  if($(this).is(":checked")){
   $("#more-2").show();
  }
  else{
   $("#more-2").hide();
  }
});

$('#have_map').click(function() {
  if($(this).is(":checked")){
   $("#have_map-2").show();
  }
  else{
   $("#have_map-2").hide();
  }
});

function ckk_2() {
		if (document.getElementById('object8').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
		else if (document.getElementById('object9').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
		else if (document.getElementById('object10').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
			else if (document.getElementById('object11').checked) {
			document.getElementById('dv1').style.display = 'none';
			document.getElementById('dv2').style.display = 'block';
		}
}
</script>
