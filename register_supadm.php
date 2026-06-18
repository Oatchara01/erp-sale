<?php
	include('head.php'); 
	/*include "src/BarcodeGenerator.php";
	include "src/BarcodeGeneratorPNG.php";
	include "src/BarcodeGeneratorHTML.php"; */
?>

<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>


<body>
		

	<form  method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>อนุมัติใบกำกับภาษี</h4></div>



<?php
		$strSQL = "SELECT so__main.*  ,tb_delivery.* ,tb_payment.*  FROM ((so__main  LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_id) LEFT JOIN tb_payment ON so__main.payment=tb_payment.payment_ID) WHERE ref_id = '".$_GET["ref_id"]."' ";


		$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);
	

$strSQL1 = "SELECT * FROM  (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";
//echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);



	?>




<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-container w3-bar w3-light-gray w3-margin-bottom">
		
		<div class="w3-half">
					<h4>Edit Data : Admin</h4>
				</div>
				<div class="w3-half">
			
													
<a href="send_supp.php?ref_id=<?php echo $objResult["ref_id"];?>&billing_name=<?php echo $objResult["billing_name"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="red">ส่งใบกำกับภาษีให้ Sup อนุมัติ</font></button></a>&nbsp;&nbsp;
				
	<a href="supadm_approve.php?ref_id=<?php echo $objResult["ref_id"];?>&billing_name=<?php echo $objResult["billing_name"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="green">Approve</font></button></a>&nbsp;&nbsp;
	
					
		<?php
		if($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='3') {
		 ?>
	
				<a href="report_vat1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">ใบกำกับภาษี</font></a>
		
		<?php }else if($objResult["select_type_doc"]=='2' or $objResult["select_type_doc"]=='4') {
		 ?> 
			
		<a href="report_vatnbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="DeepPink">ใบกำกับภาษี</font></a>
		
				<?php 
		}
		 ?>	</p>
			</div>
</div>

		<div class="w3-container w3-half"><!-- first half -->
			<div class="w3-bar w3-border">
				<?php if ($objResult["select_type_doc"]=='1'){ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="1" onclick="javascript:object();" id="object1">&nbsp;ใบยืมสินค้า PTL</div>
				<?php }else{ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" value="1" onclick="javascript:object();"  id="object1">&nbsp;ใบยืมสินค้า PTL</div>
				<?php }
				if ($objResult["select_type_doc"]=='2'){ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="2" onclick="javascript:object();"  id="object2" >&nbsp;ใบยืมสินค้า NBM</div>
				<?php } else{ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" value="2" onclick="javascript:object();"  id="object2" >&nbsp;ใบยืมสินค้า NBM</div>
				<?php }
				if ($objResult["select_type_doc"]=='3'){ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="3" onclick="javascript:object();"  id="object3" >&nbsp;ใบสั่งขาย PTL</div>
				<?php } else{ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" value="3" onclick="javascript:object();"  id="object3" >&nbsp;ใบสั่งขาย PTL</div>
				<?php }
				if ($objResult["select_type_doc"]=='4'){ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="4" onclick="javascript:object();"  id="object4" >&nbsp;ใบสั่งขาย NBM</div>
				<?php } else{ ?>
				<div class="w3-button"><input type="radio" name="select_type_doc" value="4" onclick="javascript:object();"  id="object4">&nbsp;ใบสั่งขาย NBM</div>
				<?php } ?>
			</div>
		<div class="w3-panel">
			<?php $date = explode('-' , $objResult["register_date"] );
				 // $xdate = $date[2].'-'.$date[1].'-'.$date[0];
				  /*echo $xdate;*/
			?>
			<span>วันที่</span> <span class="w3-light-grey"><?php echo DateThai($objResult["register_date"]); ?></span> เลขที่อ้างอิง :<span class="w3-light-grey"><?php echo $objResult['ref_id']; ?></span><input type="hidden" name="ref_id" class="w3-input25" value="<?php echo $objResult['ref_id']; ?>"> <input type="hidden" name="main_id" value="<?php echo $objResult['main_id']; ?>">
			<input type="hidden" name="register_date" value="<?php echo $objResult['register_date']; ?>">
			<input type="hidden" name="register_time" value="<?php echo $objResult['register_time']; ?>">
		</div>
		<div class="w3-bar">
			<span>ช่องทางการขาย</span>
			<select name="sale_channel" id="sale_channel" class="w3-select" onchange="showUser(this.value)">
				<option  value="">**โปรดเลือกช่องทางการขาย**</option>
				<?php
					$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
					$querychannel = mysqli_query($conn,$sqlchannel);
					while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) {
						if($objResult["sale_channel"] == $fetchchannel["salechannel_ID"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						} ?>
				<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>" <?php echo $sel;?>><?php echo $fetchchannel['salechannel_nameshort']; ?>&nbsp;&nbsp;<?php echo $fetchchannel['description_chanel']; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="w3-padding-small"></div>
		<div class="w3-bar">
			<span>การจัดส่ง</span>
			<input name="delivery" type='text' class="w3-input" id="delivery" value="<?php echo $objResult["delivery_name"]; ?><?php echo $objResult["time_delivery"]; ?>" placeholder="Search การจัดส่ง..."> 
			<input name="h_delivery" type="hidden" id="h_delivery"  value="<?php echo $objResult["delivery"]; ?>" class="w3-input" /> 
			<?php /*
				<select name="delivery" class="w3-select">
				<option value="">**Please Select Item**</option>
				<?php
					$sqldeli = "SELECT tb_delivery.*,tb_sender.* FROM tb_delivery LEFT JOIN tb_sender ON tb_delivery.employee_send=tb_sender.sender_ID";
					$querydeli = mysqli_query($conn,$sqldeli);
					while ($fetchdeli = mysqli_fetch_array($querydeli,MYSQLI_ASSOC)) {
					if($objResult["delivery"] == $fetchdeli["delivery_id"]) {
						$sel = "selected";
					}
					else {
						$sel = "";
					}
				?>
				<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_id'];?>" <?php echo $sel;?>><?php echo $fetchdeli['delivery_name'];?> | <?php echo $fetchdeli['time_delivery']; ?> | <?php echo $fetchdeli['remark']; ?><?php echo $fetchdeli['packing_remark'];?></option>
				<?php } ?>
			</select>*/?>
		</div>
		<div class="w3-padding-small"></div>
		<div class="w3-bar">
			<span>การชำระเงิน</span>
			<input name="payment" type='text' class="w3-input" id="payment"  value="<?php echo $objResult["payment_name"]; ?><?php echo $objResult["bank_name"]; ?><?php echo $objResult["book_name"]; ?>" placeholder="Search การชำระเงิน..."> 
			<input name="h_payment" type="hidden" id="h_payment" value="<?php echo $objResult["payment"]; ?>" class="w3-input" />
			<?php /*
				<select name="payment" class="w3-select">
				<option value="">**Please Select Item**</option>
				<?php
					$strSQL5 = "select * from tb_payment order by payment_ID";
					$objQuery5 = mysqli_query($conn,$strSQL5);
					if (!$objQuery5) {
						echo "Failed to fetch to MySQL: " . mysqli_error();
					}
					while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
						if($objResult["payment"] == $objResuut5["payment_ID"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						}
				?>
				<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['payment_ID']; ?>"<?php echo $sel;?>><?php echo $objResuut5['payment_name']; ?> | <?php echo $objResuut5['bank_name']; ?> | <?php echo $objResuut5['book_number']; ?> | <?php echo $objResuut5['branch_bank']; ?> | <?php echo $objResuut5['book_type']; ?> | <?php echo $objResuut5['book_name']; ?> | <?php echo $objResuut5['description_payment']; ?></option>
				<?php } ?>
				</select>*/
			?>
		</div>
		<div class="w3-padding-small"></div>
		<div class="w3-bar">
			<span>หมายเหตุ</span>
			<textarea name="sale_remark"  class="w3-input" id="sale_remark"  rows="1"><?php echo $objResult['sale_remark']; ?></textarea>
		</div>
		<div class="w3-padding-small"></div>
		<div class="w3-bar">
			<span>ชื่อพนักงาน</span>
			<input name="employee_name" type="text" id="employee_name" value="<?php echo $objResult["employee_name"]; ?>" class="w3-input" /> 
			
			
			
			<?php /*
				<select  name="employee_name" class="w3-select"  >
				<option value="">**Please Select Item**</option>
				<?php
					$emp = "select * from tb_employee where status=1 order by employee_ID";
					$sqlemp = mysqli_query($conn,$emp);
					while ($fetchemp = mysqli_fetch_array($sqlemp,MYSQLI_ASSOC)) {
					if($objResult["employee_name"] == $fetchemp["employee_ID"]) {
						$sel = "selected";
					}
					else {
						$sel = "";
					}
				?>
				<option class="w3-bar-item w3-button" value="<?php echo $fetchemp['employee_ID']; ?>"<?php echo $sel;?>><?php echo $fetchemp['employee_name']; ?></option>
				<?php } ?>
				</select>*/
			?>
		</div>
			<div class="w3-padding-small"></div>
		<div class="w3-bar">
			<?php if($objResult["cancel_ckk"]=='1'){ ?>
<input type="checkbox" name="cancel_ckk" id="cancel_ckk" value = '1' checked='checked' class="button4"  >&nbsp;&nbsp; ยกเลิก&nbsp;&nbsp;
<?php }else { ?>
<input type="checkbox" name="cancel_ckk" id="cancel_ckk" value = '1'  class="button4"  >&nbsp;&nbsp; ยกเลิก&nbsp;&nbsp;

	<?php } ?>
</div>
			
	</div><!-- first half -->
	<div class="w3-container w3-half"><!-- second half -->
		<div class="w3-bar w3-light-grey w3-border">
			<a class="w3-bar-item w3-button" onclick="openCity('st')"><font color="#404040"><b>Admin ลงทะเบียน</b></font></a>
			<a class="w3-bar-item w3-button" onclick="openCity('so')"><font color="#404040"><b>ใบสั่งขาย</b></font></a>
			<a class="w3-bar-item w3-button" onclick="openCity('mo')"><font color="#404040"><b>เพิ่มเติม</b></font></a>
			<a class="w3-bar-item w3-button"  onclick="openCity('br')"><font color="#404040"><b>ใบยืมสินค้า</b></font></a>
		</div>
	<div id="st" class="w3-container city" >
		<div class="w3-half"><!-- first right half -->
			<div class="w3-half w3-bar">
				เลขที่เอกสาร <input name="doc_no" class="w3-input" value="<?php echo $objResult['doc_no']; ?>" type="text" >
				<?php /*$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
					    $barcode ='<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($objResult['doc_no'], $generator::TYPE_CODE_128)) . '">';
						echo $barcode;
						$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
						$border = 1;//กำหนดความหน้าของเส้น Barcode
						$height = 30;//กำหนดความสูงของ Barcode$Barcode =$generator->getBarcode($objResult['doc_no'], $generator::TYPE_CODE_128,$border,$height);
						echo $Barcode;*/
						
						/*header('Content-Type: image/png');
						if (!hasCache($file)) {
							$obj = file_get_contents($file);
							$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
							$content = $generator->getBarcode($obj, $generator::TYPE_CODE_128_A);
							generateCache($file, $content);
						}
						outputCache($file);*/
				?>
			</div>
			
			<div class="w3-half w3-bar">
 
เลขที่ IV รวมบิล <input name="iv_no" value="<?php echo $objResult['iv_no']; ?>" class="w3-input" type="text">
				
</div>
<div class="w3-half w3-bar">
 
เลขที่ SR ลดหนี้ <input name="sr_no" value="<?php echo $objResult['sr_no']; ?>" class="w3-input" type="text">
</div>
			<div class="w3-container w3-half w3-bar">
				เลขที่ลงงาน <input name="job_id" class="w3-input" value="<?php echo $objResult['job_id']; ?>" type="text">
			</div>
			<div class="w3-half w3-bar">
				วันที่ออกเอกสาร <input name="doc_release_date" class="w3-input" value="<?php echo $objResult['doc_release_date']; ?>" type="date">
			</div>
			
<div class="w3-half w3-bar">
				วันที่รวม IV <input name="iv_date" class="w3-input" value="<?php echo $objResult['iv_date']; ?>" type="date">
			</div>
			<div class="w3-container w3-half w3-bar">
				ฝากสินค้าเลขที่ <input name="deposit_no" class="w3-input" value="<?php echo $objResult['deposit_no']; ?>" type="text">
			</div>
<?php if ($objResult['sale_channel']=='12'){  ?>
<div class="w3-container w3-half w3-bar">
รหัสอ้างอิงการส่ง
<input name="order_refer_code" class="w3-input w3-sand" value="<?php echo $objResult['order_refer_code']; ?>"  type="text" >
</div>
<?php } ?>
<?php if ($objResult["send_stock"]=='1'){ ?>

<input type="checkbox" name="send_stock" checked='checked' value="1"> &nbsp;ส่งข้อมูลให้ Stock
<?php }else{ ?>
<input type="checkbox" name="send_stock" value="1"> &nbsp;ส่งข้อมูลให้ Stock

	<?php } ?>

			<div class="w3-bar">

<?php
if($objResult["approve_complete"]=='Rejected' ){
}else{

				 if ($objResult["select_type_doc"]=='1') { ?>
					<input type="checkbox"  checked="checked" value="1">&nbsp;
					<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม PTL</font></a>&nbsp;&nbsp;
				<?php }
				else { ?>
					<div id="dt1" style="display:none">
						<input type="checkbox"  checked="checked" value="1">&nbsp;
						<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม PTL</font></a>&nbsp;&nbsp;
					</div>
				<?php }
					if ($objResult["select_type_doc"]=='2'){ ?>
						<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
						<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;
				<?php }
				else { ?>
					<div id="dt2" style="display:none">
						<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
						<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;
					</div>
				<?php }
					if ($objResult["select_type_doc"]=='3'){ ?>
						<input type="checkbox" name="select_so_ptl" checked="checked" value="1">&nbsp;
						<a href="report_saleptl1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย PTL</font></button></a><br/>
				<?php }
				else { ?>
					<div id="dt3" style="display:none">
						<input type="checkbox" name="select_so_ptl" checked="checked" value="1">&nbsp;
						<a href="report_saleptl1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย PTL</font></button></a><br/>
					</div>
				<?php }
					if ($objResult["select_type_doc"]=='4'){?>
						<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
						<a href="report_salenbm1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
				<?php }
				else { ?>
					<div id="dt4" style="display:none">
						<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
						<a href="report_salenbm1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
					</div>
				<?php } 
						}
						?>





			</div>
			<div class="w3-bar">ใบปะหน้ากล่อง</div>
			<div class="w3-bar w3-half 1">
				<a href="report_99std.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_99std_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
			<div class="w3-bar w3-half 2">
				<a href="report_a5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ptl</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_a5ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ptl+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_a4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ptl</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_a4ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ptl+k</font></a>
			</div>
			<div class="w3-bar w3-half 4">
				<a href="report_a5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 4">
				<a href="report_a5nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a>
			</div>
			<div class="w3-bar w3-half 5">
				<a href="report_a4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 5">
				<a href="report_a4nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a>
			</div>
		</div><!-- first right half -->
		<div class="w3-half"><!-- second right half -->
			<div class="w3-bar w3-half">
			<?php if ($objResult["select_type_doc"]=='1') { ?>
				<a href="report_summary_ptl.php?sale_channel=<?php echo $objResult["sale_channel"];?>&doc_release_date=<?php echo  $objResult["doc_release_date"];?>&doc_no=<?php echo  $objResult["doc_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">สรุปยืมแบบรวม PTL</font></a>
				<?php } ?>
			</div>
				<?php if ($objResult["select_type_doc"]=='2') { ?>
<div class="w3-bar w3-half w3-margin-bottom">

		
				<a href="report_summary_nbm.php?sale_channel=<?php echo $objResult["sale_channel"];?>&doc_release_date=<?php echo  $objResult["doc_release_date"];?>&doc_no=<?php echo  $objResult["doc_no"];?>" target="_blank" class="w3-button w3-grey w3-right" style="width:90%;"><font color="DeepPink">สรุปยืมแบบรวม NBM</font></a>

			</div>

				<?php } ?>
			<div class="w3-bar w3-half">
			<?php if ($objResult["select_type_doc"]=='1') { ?>
				<a href="report_summary_IVptl.php?sale_channel=<?php echo $objResult["sale_channel"];?>&register_date=<?php echo  $objResult["register_date"];?>&iv_no=<?php echo  $objResult["iv_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">สรุปรวม เคลียร์ยอดเงิน PTL</font></a>

				<?php } ?>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom">
			<?php if ($objResult["select_type_doc"]=='2') { ?>
				<a href="report_summary_IVnbm.php?sale_channel=<?php echo $objResult["sale_channel"];?>&register_date=<?php echo  $objResult["register_date"];?>&iv_no=<?php echo  $objResult["iv_no"];?>" target="_blank" class="w3-button w3-grey w3-right" style="width:90%;"><font color="DeepPink">สรุปรวม เคลียร์ยอดเงิน NBM</font></a>
				<?php } ?>
			</div>
			
			<div class="w3-bar w3-half">
			<?php if ($objResult["select_type_doc"]=='1') { ?>
				<a href="report_summary_IVptl_st.php?sale_channel=<?php echo $objResult["sale_channel"];?>&register_date=<?php echo  $objResult["register_date"];?>&iv_no=<?php echo  $objResult["iv_no"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">สรุปรวม Stock เคลียร์ยอดเงิน PTL</font></a>

				<?php } ?>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom">
			<?php if ($objResult["select_type_doc"]=='2') { ?>
				<a href="report_summary_IVnbm_st.php?sale_channel=<?php echo $objResult["sale_channel"];?>&register_date=<?php echo  $objResult["register_date"];?>&iv_no=<?php echo  $objResult["iv_no"];?>" target="_blank" class="w3-button w3-grey w3-right" style="width:90%;"><font color="DeepPink">สรุปรวม Stock เคลียร์ยอดเงิน NBM</font></a>
				<?php } ?>
			</div>

			<div class="w3-bar w3-center">
				<a href="" target="_blank" class="w3-button w3-grey" style="width:100%;" onClick="window.open('billing_name.php?main_id=<?php echo $objResult['main_id']; ?>','Billing Description','resizable,height=600,width=720'); return false;"><font color="DarkViolet">รายชื่อที่ต้องการออกบิล</font></a>
			</div>
			<div class="w3-bar w3-margin-top">
				<?php
					if ($objResult['admin_complete']=='1'){ ?>
						คลิ๊กสมบูรณ์เมื่อออกบิลแล้ว <input type='checkbox' name='admin_complete' checked='checked' value='1'>
					<?php }
					else { ?>
						คลิ๊กสมบูรณ์เมื่อออกบิลแล้ว <input type='checkbox' name='admin_complete' value='1'>
				<?php } ?>
			</div>
			<div class="w3-bar w3-margin-top">
				Status เอกสาร 
			</div>
			<div class="w3-bar">
				<?php
					if ($objResult['status_doc']=='1'){ ?>
						<input type='radio' name='status_doc' checked="checked" value='1'>&nbsp;รอดำเนินการ
						<input type='radio' name='status_doc' value='2'>&nbsp;สมบูรณ์แล้ว
					<?php }
					else if ($objResult['status_doc']=='2'){ ?>
						<input type='radio' name='status_doc'  value='1'>&nbsp;รอดำเนินการ
						<input type='radio' name='status_doc' checked="checked" value='2'>&nbsp;สมบูรณ์แล้ว
					<?php }
					else { ?>
						<input type='radio' name='status_doc'  value='1'>&nbsp;รอดำเนินการ
						<input type='radio' name='status_doc'  value='2'>&nbsp;สมบูรณ์แล้ว
					<?php } ?>
			</div>
			<div class="w3-bar w3-margin-top">
				แนบไฟล์ 
			</div>
			<input type='hidden' name='upload1' id='upload1' value ="<?php echo $objResult['upload1']; ?>"  />
			<input type='hidden' name='upload2' id='upload2' value ="<?php echo $objResult['upload2']; ?>"  />
			<input type='hidden' name='upload3' id='upload3' value ="<?php echo $objResult['upload3']; ?>"  />
			<input type='hidden' name='upload4' id='upload4' value ="<?php echo $objResult['upload4']; ?>"  />
			<input type='hidden' name='upload5' id='upload5' value ="<?php echo $objResult['upload5']; ?>"  />
		
			<input name="upload1"  type="file"><a href="upload/<?php echo $objResult['upload1']; ?>" target="_blank"><?php echo $objResult['upload1']; ?></a></p>
			<input name="upload2"  type="file"><a href="upload/<?php echo $objResult['upload2']; ?>" target="_blank"><?php echo $objResult['upload2']; ?></a></p>
			<input name="upload3"  type="file"><a href="upload/<?php echo $objResult['upload3']; ?>" target="_blank"><?php echo $objResult['upload3']; ?></a></p>
			<input name="upload4"  type="file"><a href="upload/<?php echo $objResult['upload4']; ?>" target="_blank"><?php echo $objResult['upload4']; ?></a></p>
			<input name="upload5"  type="file"><a href="upload/<?php echo $objResult['upload5']; ?>" target="_blank"><?php echo $objResult['upload5']; ?></a></p>
		</div><!-- second right half -->
	</div><!-- close st -->
	
	<div id="so" class="w3-container city" style="display:none">
		<div class="w3-half"><!--first half-->
			<div class="w3-bar">
				ชื่อที่ออกบิล <input name="billing_name" type='text' class="w3-input" value="<?php echo $objResult['billing_name']; ?>">
			</div>
			<div class="w3-bar">
				ทีอยู่ที่ออกบิล <textarea name="billing_address" class="w3-input" rows="1"><?php echo $objResult['billing_address']; ?></textarea>
			</div>
			<div class="w3-bar w3-half">
				Tel. <input type="text" name="billing_tel" class="w3-input" value="<?php echo $objResult['billing_tel']; ?>">
			</div>
			<div class="w3-bar w3-half">
				<?php
					if($objResult['bill_vat']=='1'){
				?>
					<input type="checkbox" name="bill_vat" checked='checked' value="1"> บิล VAT
				<?php } else { ?>
					<input type="checkbox" name="bill_vat" value="1"> บิล VAT
				<?php } ?>
				<input type="text" name="tax_id" class="w3-input" value="<?php echo $objResult['tax_id']; ?>">
			</div>
			<div class="w3-bar">
				การชำระเงิน
				<input name="payment1" type='text' class="w3-input" id="payment1"  value="<?php echo $objResult["payment_name"]; ?><?php echo $objResult["bank_name"]; ?><?php echo $objResult["book_name"]; ?>" placeholder="Search การชำระเงิน...">
				
			</div>
			<div class="w3-bar">
				การโอนเงิน
				<select name="transfer" class="w3-select">
					<option value="">**Please Select Item**</option>
					<?php
						$strSQL3 = "SELECT * FROM tb_transfer ORDER BY tranfer_ID ASC";
						$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
						while($objResult3 = mysqli_fetch_array($objQuery3)) {
							if($objResult["transfer"] == $objResult3["tranfer_name"]) {
								$sel = "selected";
							}
							else {
								$sel = "";
							}
					?>
					<option value="<?php echo $objResult3["tranfer_name"];?>"<?php echo $sel;?>><?php echo $objResult3["tranfer_name"];?></option>
					<?php } ?>
				</select>
			</div>
			<div class="w3-bar">
				ส่งบัญชีตรวจสอบ
				<?php
					if ($objResult["account_approve"]=='1'){?>
						<input type="checkbox" name="account_approve" checked='checked' value="1">
				<?php } else { ?>
						<input type="checkbox" name="account_approve" value="1">
				<?php } ?>
			</div>
			<div class="w3-bar">
				วันที่โอน
				<input type="date" name="transfer_date" id="transfer_date" class="w3-input" value="<?php echo $objResult["transfer_date"];?>">
			</div>
			<div class="w3-bar">
				จำนวนเงินโอน/เก็บปลายทาง
				<input type="text" name="amount" class="w3-input" value="<?php echo $objResult["amount"];?>">
			</div>
		</div><!-- first half -->
		<div class="w3-half w3-container w3-light-grey"><!--second half-->
			<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
			ชื่อผู้รับสินค้า
			<input name="customer_name" type="text" value="<?php echo $objResult['customer_name']; ?>" class="w3-input" >
			ที่อยู่ในการจัดส่ง
			<input name="address1" class="w3-input" type="text" value="<?php echo $objResult['address1'];?>">
			<input name="address2" class="w3-input" type="text" value="<?php echo $objResult['address2'];?>">
			จังหวัด
			<select name="province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult["province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>
			รหัสไปรษณีย์
			<input name="postcode" type="text" value="<?php echo $objResult["postcode"];?>" class="w3-input">
			โทรศัพท์
			<input name="tel" type="text"  value="<?php echo $objResult["tel"];?>" class="w3-input">
			<div class="w3-margin-bottom"></div>
		</div><!-- second half -->
	</div><!-- close so -->
	<div id="mo" class="w3-container city" style="display:none">
		<div class="w3-third"><!-- 1st 3rd -->
			ชื่อผู้แนะนำ
			<input name="prefer_name" class="w3-input" value="<?php echo $objResult["prefer_name"];?>" >
			ใบสั่งซื้อเลขที่
			<input name="po_no" class="w3-input" value="<?php echo $objResult["po_no"];?>" >
			กำหนดส่งตามสัญญา
			<input name="delivery_contract" class="w3-input" value="<?php echo $objResult["delivery_contract"];?>" >
			<?php
				if($objResult["clear_book_ckk"]=='1'){ ?>
					<input type="checkbox" name="clear_book_ckk" checked='checked' value="1">
				<?php } else { ?>
					<input type="checkbox" name="clear_book_ckk" value="1">
				<?php } ?>
			เคลียร์ใบจอง
			<input name="clear_book_no" class="w3-input" value="<?php echo $objResult["clear_book_no"];?>" placeholder="เลขที่" >
<?php
if($objResult["clear_brn_no_ckk"]=='1'){
?>

<input type="checkbox" name="clear_brn_no_ckk" checked='checked' value="1">&nbsp;

<?php
}else{
?>
	<input type="checkbox" name="clear_brn_no_ckk" value="1">&nbsp;
<?php
}
?>

เคลียร์ใบยืม BRN:
<input name="clear_brn_no" class="w3-input" value="<?php echo $objResult["clear_brn_no"];?>" placeholder="เลขที่" >

<?php
if($objResult["clear_brnp_no_ckk"]=='1'){
?>
<input type="checkbox" name="clear_brnp_no_ckk" checked='checked' value="1">&nbsp;

<?php
}else{
	?>

<input type="checkbox" name="clear_brnp_no_ckk" value="1">&nbsp;

		<?php
}
		?>





เคลียร์ใบยืม BRNP:
<input name="clear_brnp_no" class="w3-input" value="<?php echo $objResult["clear_brnp_no"];?>" placeholder="เลขที่" >
</div>
<div class="w3-third w3-container"><!-- 2nd 3rd -->

<?php
if($objResult["sn_ckk"]=='1'){
?>
<input type="checkbox" name="sn_ckk" checked="checked" value="1">&nbsp;
<?php
}else{
	?>
<input type="checkbox" name="sn_ckk" value="1">&nbsp;

		<?php
}
		?>

ต้องการ SN:
<input name="sn" class="w3-input" value="<?php echo $objResult["sn"];?>" >

<?php
if($objResult["bq_ckk"]=='1'){
?>
<input type="checkbox" name="bq_ckk" checked="checked" value="1">&nbsp;
<?php
}else{
	?>
<input type="checkbox" name="bq_ckk" value="1">&nbsp;

		<?php
}
		?>


BQ เลขที่:
<input name="bq" class="w3-input" value="<?php echo $objResult["bq"];?>" >

<?php
if($objResult["ot_ckk"]=='1'){
?>
<input type="checkbox" name="ot_ckk" checked="checked" value="1">&nbsp;
<?php
}else{
	?>
<input type="checkbox" name="ot_ckk" value="1">&nbsp;

		<?php
}
		?>



OT เลขที่:
<input name="ot" class="w3-input" value="<?php echo $objResult["ot"];?>" >



</div>
<div class="w3-third"><!-- 3rd 3rd -->
สถานที่ติดตั้งเครื่อง
<input name="install_place" class="w3-input" value="<?php echo $objResult["install_place"];?>" ><br />
<?php 
if($objResult["with_pr"]=='1'){
?>
<input name="with_pr" type="checkbox" checked='checked' value="1">
<?php
}else{
	?>
<input name="with_pr" type="checkbox" value="1">
<?php
}
			?>
แนบใบเสนอราคา<br />

<?php 
if($objResult["type_type"]=='1'){
?>

<input type="radio" name="type_type" checked="checked" value="1" onclick="javascript:ckk_1();" id="object6">พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7">พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5">พิมพ์ตามที่เขียน
<br />

<?php
}else if($objResult["type_type"]=='2'){
	?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6">พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" checked="checked" value="2" onclick="javascript:ckk_1();" id="object7">พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5">พิมพ์ตามที่เขียน
<br />

		<?php
}else if($objResult["type_type"]=='3'){

			?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6">พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7">พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" checked="checked" value="3" onclick="javascript:ckk_1();" id="object5">พิมพ์ตามที่เขียน
<br />

	<?php
}else {

			?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6">พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7">พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type"  value="3" onclick="javascript:ckk_1();" id="object5">พิมพ์ตามที่เขียน
<br />


<?php 
		}

if($objResult["type_type"]=='3'){
?>

ระบุ:
<textarea name="type_type_detail" class="w3-input" style="resize: none;width:100%"><?php echo $objResult["type_type_detail"];?></textarea>
<?php
}else{
	?>

<div id="dt5" style="display:none">

ระบุ:
<textarea name="type_type_detail" class="w3-input" style="resize: none;width:100%"></textarea>
</div>

		<?php
}
			?>

</div>
</div><!-- close more -->

<div id="br" class="w3-container city" style="display:none">
<?php
$sale_channel=$objResult["sale_channel"];
include "dbconnect.php";
$sql="SELECT tb_salechannel.*,tb_province.* FROM tb_salechannel LEFT JOIN tb_province ON tb_salechannel.province_id=tb_province.province_ID WHERE salechannel_ID = '".$sale_channel."'";

//echo  $sql;
//exit();

$result = mysqli_query($conn,$sql) or die(mysqli_error());
$row = mysqli_fetch_array($result);

?>
<div class="w3-bar">
วัตถุประสงค์การเบิก: <input name='objective'  class='w3-input' value="<?php echo $objResult["objective"];?>"/>
</div>
<div class="w3-bar">
หมายเลขคำสั่งซื้อ: <input type='text' class='w3-input' name='order_id'  value="<?php echo $objResult["order_id"]; ?>">
</div>
<div class="w3-bar">
ชื่อลูกค้าตามคำสั่งซื้อ: <input type='text' class='w3-input' name='order_name' value="<?php echo $objResult["order_name"]; ?>" >
</div>
<div class="w3-bar">
ชื่อลูกค้า: <span class="w3-padding-small"><?php echo $row["salechannel_nameshort"];?></span>
</div>
<div class="w3-bar">
วันที่: <span class="w3-padding-small"><?php echo DateThai($objResult["register_date"]); ?></span>
</div>
<div class="w3-bar">
เลขที่เอกสาร: <span class="w3-padding-small"><?php echo $objResult["doc_no"];?></span>
</div>
<div class="w3-bar">
เลขที่ลงงาน: <span class="w3-padding-small"><?php echo $objResult["job_id"];?></span>
</div>
<div class="w3-bar">
วันที่ออกเอกสาร: <span class="w3-padding-small"><?php echo $objResult["doc_release_date"];?></span>
</div>
<div class="w3-bar">
ชื่อลูกค้า: <span class="w3-padding-small"><?php echo $row["salechannel_nameshort"];?></span>
</div>
<div class="w3-bar">
ที่อยู่: <span class="w3-padding-small"><?php echo $row["address1"]; ?>&nbsp;<?php echo $row["address2"]; ?>&nbsp;<?php echo $row['province_name']; ?>&nbsp;<?php echo $row['zip_code']; ?></span>
</div>
<div class="w3-bar">
หมายเหตุ: <span class="w3-padding-small"><?php echo $row['description_chanel']; ?></span>
</div>
</div><!-- close br -->
</div><!-- second half -->

<div class="w3-bar w3-light-grey w3-border">
    <a class="w3-bar-item w3-button" onclick="openCity1('stoc')"><font color="#404040"><b>เอกสารแนบเพิ่มเติม</b></font></a>
	<a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
	<a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
</div>

<div id="stoc" class="w3-container city1" style="display:none">
<div class="w3-quarter w3-container">
<b>เอกสารเพิ่มเติม Lazada</b><br />
1. ใบบาร์โค้ด<br />
2. รายละเอียดลูกค้า<br />
3.<br />
4.<br />
5.
</div>
<div class="w3-quarter w3-container">
<b>เอกสารเพิ่มเติม 99 HM</b><br />
1. Slip<br />
2. รายละเอียดลูกค้า<br />
3.<br />
4.<br />
5.
</div>
<div class="w3-quarter w3-container">
<b>เอกสารเพิ่มเติม 11 Street</b><br />
1. ใบบาร์โค้ด<br />
2. รายละเอียดลูกค้า<br />
3.<br />
4.<br />
5.
</div>
</div>

<div id="pd" class="w3-container city1">

<table width="100%" border="0" class="w3-table">
<thead>
    <th><div class="w3-center"><b>รหัสสินค้า</b></div></th>
    <th><div class="w3-center"><b>ชื่อสินค้า</b></div></th>
    <th><div class="w3-center"><b>หน่วย</b></div></th>
    <th><div class="w3-center"><b>จำนวน</b></div></th>
    <th><div class="w3-center"><b>ราคาต่อหน่วย</b></div></th>
	<th><div class="w3-center"><b>ส่วนลด/หน่วย</b></div></th>
    <th><div class="w3-center"><b>ยอดรวม</b></div></th>
	<th><div class="w3-center"><b>รับประกัน (ปี)</b></div></th>
	<th><div class="w3-center"><b>Cal (ครั้ง/ปี)</b></div></th>
	<th><div class="w3-center"><b>PM (ครั้ง/ปี)</b></div></th>
    <th><div class="w3-center"><b>หมายเหตุ</b></div></th>

</thead>
<tbody>
<?php
$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<tr>
<td>

<input type="hidden" name="id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id']; ?>">

<input type="hidden" name="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

<input type='text' name ="product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sol_code"];?>" id ="product_code[]<?php echo $objResult1["id"];?>"    class="w3-input" OnChange="JavaScript:doCallAjax('product_code[]<?php echo $objResult1["id"];?>','product_name[]<?php echo $objResult1["id"];?>','unit_name[]<?php echo $objResult1["id"];?>','product_price[]<?php echo $objResult1["id"];?>','discount_unit[]<?php echo $objResult1["id"];?>');"/></td>

<td><input type='text' name = "product_name[]<?php echo $objResult1["id"];?>"  value="<?php echo $objResult1["sol_name"];?>" id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly></td>	
	
<td><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    readonly/></td>

<td><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    /></td>

<td><input type='text' name = "product_price[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["price_per_unit"];?>" id = "product_price[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:right"    /></td>

<td><input type='text' name = "discount_unit[]<?php echo $objResult1["id"];?>" value="<?php  $discount_unit=$objResult1["discount_unit"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:right"   /></td>


<td>
<input type='text' name = "sum_amount[]<?php echo $objResult1["id"];?>" value="<?php  $sum_amount=$objResult1["sum_amount"]; echo number_format( $sum_amount,2)."";?>"  id = "sum_amount[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:right"   />


</td>

<td><input type='text' name = "warranty[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["warranty"];?>" id = "warranty[]<?php echo $objResult1["id"];?>"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["cal"];?>" id = "cal[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td><input type='text' name = "pm[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["pm"];?>" id = "pm[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td>


<input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input" />

</td>

<td><a href="product_delete.php?ref_id=<?php echo $objResult["ref_id"];?>&id=<?php echo $objResult1["id"];?>"><img src="img/false.png" width="16" height="16" border="0" /></a></td>

</tr>



<?php
	$i++;
	}
?>
</tbody>
</table>

<?php include ('data_product_adedit.php')
?>


<script>
$('form').jAutoCalc({
  attribute: 'jAutoCalc',
  thousandOpts: [',', '.', ' '],
  decimalOpts: ['.', ','],
  decimalPlaces: -1,
  initFire: true,
  chainFire: true,
  keyEventsFire: false,
  readOnlyResults: true,
  showParseError: true,
  emptyAsZero: false,
  smartIntegers: false,
  onShowResult: null,
  funcs: {},
  vars: {}
});
</script>
<input type="hidden" name="hdnLine" value="<?php echo $i;?>">

</div>

<div id="cs" class="w3-container city1" style="display:none">

	<?php 
	
	$sql1 = "select * from tb_register_data where ref_id = '".$_GET["ref_id"]."'";
				$query1 = mysqli_query($conn,$sql1);
				$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
	
	if($objResult["delivery_type"]=='4'){
	?>
	
<div class="w3-quarter"><!-- first third-->
<?php

		if($objResult["delivery_type"]=='1'){
			?>
<input type="radio" name="delivery_type" checked='checked' value="1">Sale รับเอง
<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4">บริษัทจัดส่ง <br />

<?php
		}else if($objResult["delivery_type"]=='2'){
	?>
<input type="radio" name="delivery_type" value="1">Sale รับเอง
<input type="radio" name="delivery_type" checked='checked' value="2">ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4">บริษัทจัดส่ง <br />


		<?php
}else if($objResult["delivery_type"]=='3'){
		
			?>
	<input type="radio" name="delivery_type" value="1">Sale รับเอง
	<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
    <input type="radio" name="delivery_type" checked='checked' value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4">บริษัทจัดส่ง <br />

<?php
		}else if($objResult["delivery_type"]=='4'){
		?>

	<input type="radio" name="delivery_type" value="1">Sale รับเอง
	<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
    <input type="radio" name="delivery_type"  value="3">ลูกค้ารับเอง 
	<input type="radio" name="delivery_type" checked='checked' value="4">บริษัทจัดส่ง <br />

			<?php
}else {
			?>
	<input type="radio" name="delivery_type" value="1">Sale รับเอง
	<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
    <input type="radio" name="delivery_type"  value="3">ลูกค้ารับเอง 
	<input type="radio" name="delivery_type"  value="4">บริษัทจัดส่ง <br />

				<?php
			}
				?><br \>
วันที่ส่ง
<input type="date" name="delivery_date" value="<?php echo $objResult["delivery_date"];?>" class="w3-input" >
เวลาส่ง
<input type="text" name="delivery_time" value="<?php echo $objResult["delivery_time"];?>" class="w3-input" >

</div><!-- first third-->
<div class="w3-quarter w3-container"><!-- second quarter -->


สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" cols="20" rows="1" style="width:100%;resize: none" ><?php echo $objResult["delivery_place"]; ?></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" value ="<?php echo $objResult["delivery_contact"]; ?>" class="w3-input" >
</div><!-- second third-->
<div class="w3-quarter"><!-- 3rd third-->
<?php
if ($objResult["return_date"]=='1'){
?>
<input type="checkbox" name="return" checked="checked" value="1">รับคืนสินค้า<br>
<?php
}else{
	?>
<input type="checkbox" name="return" value="1">รับคืนสินค้า<br>
<?php
}
	?>

วันที่รับคืน
<input type="date" name="return_date" value ="<?php echo $objResult["return_date"]; ?>" class="w3-input" >



<input type="text" name="return_time" value ="<?php echo $objResult["return_time"]; ?>" class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address" value ="<?php echo $objResult["return_address"]; ?>" class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact"  value ="<?php echo $objResult["return_contact"]; ?>"  class="w3-input" >
</div><!-- 3rd third-->
	
<div class="w3-container w3-third">
	<?php 
	if($objResult["return_contact"]=='2'){
	?>
<input type="checkbox" name="send_cs" checked= 'checked' value="2">&nbsp;ส่งข้อมูลไประบบลงงาน 
	<?php }else{ ?>
<input type="checkbox" name="send_cs" value="1">&nbsp;ส่งข้อมูลไประบบลงงาน 	
	<?php } ?>
	</div>
<div class="w3-container w3-third">
.
	</div>
	<div class="w3-container w3-third">
.
	</div>
	<div class="w3-container w3-third">
 วันที่ รับ-ส่ง :
      <input name="start_date" type='date' id="start_date" value="<?php echo $fetch1["start_date"]; ?>"  class="w3-input"  />

	</div><div class="w3-container w3-third">

วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="w3-input" value="<?php echo $fetch1["between_date"]; ?>" type='text' id="between_date"  />
 </div><div class="w3-container w3-third">

 เวลา :
<input id="start_time"  name="start_time" value="<?php echo $fetch1["start_time"]; ?>" class="w3-input" type="text" />
ถึง
<input id="end_time" name="end_time"  value="<?php echo $fetch1["end_time"]; ?>" class="w3-input" type="text" />

</div><div class="w3-container w3-third">


สถานะการทำงาน : 

<?php if($fetch1["status"]=='ส่ง'){ ?>

<input type='radio'  name='status' id = 'status' value='ส่ง' checked='checked'/>ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ

<?php }else if($fetch1["status"]=='รับ'){ ?>

<input type='radio'  name='status' id = 'status' value='ส่ง' />ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' checked='checked'/>รับ

<?php } ?>

</div><div class="w3-container w3-third">

สถานะ :
      <input name="status_comment" type='text' id="status_comment" value="<?php echo $fetch1["status_comment"]; ?>" size="20" class="w3-input"/>
</div><div class="w3-container w3-third">

<?php if($fetch1["fix_date"]=='1'){ ?>

<input type="checkbox"  name="fix_datetime" id = "fix_datetime" checked='checked' value="1">นัดวันและเวลาเรียบร้อยแล้ว 
<?php }else { ?>
<input type="checkbox"  name="fix_datetime" id = "fix_datetime"  value="1">นัดวันและเวลาเรียบร้อยแล้ว 

<?php } if($fetch1["no_price"]=='1'){ ?>

<input type="checkbox"  id = "no_money" name="no_money" checked="checked" value="1">ไม่ต้องเก็บเงิน

<?php }else { ?>
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน


<?php } ?>
</div><div class="w3-container w3-third">
<?php if($fetch1["call_customer"]=='1'){ ?>

<input type="checkbox"  id = "call_customer" name="call_customer"  checked="checked" value="1">โทรแจ้งลูกค้าก่อนไป
<?php }else { ?>
<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
	<?php } if($fetch1["call_employee"]=='1'){ ?>
	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" checked="checked" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
<?php }else { ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว


<?php } ?>
</div><div class="w3-container w3-third">
<?php if($fetch1["want_bus"]=='1'){ ?>
<input type="checkbox"   name="want_bus" checked="checked" value="1">ต้องการรถใหญ่
<?php }else{ ?>
	<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่

<?php } ?>
		</div><div class="w3-container w3-third">
	 <?php if($fetch1["cash"]=='1'){ ?>

<input type="checkbox"  name="cash"id = "cash" checked="checked" value="1">เก็บเงินสด
<?php }else { ?>
	<input type="checkbox"  name="cash"id = "cash"  value="1">เก็บเงินสด


<?php } ?>
		 <input name="unit_cash" type='text' class="w3-input" id="unit_cash" value="<?php echo $fetch1["unit_cash"]; ?>" size="20" rows="1" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)">  
		 </div><div class="w3-container w3-third">

<?php if ($fetch1["check_paper"]=='1'){ ?>

	<input type="checkbox"  name="check_paper" id = "check_paper" checked='checked' value="1">รับเช็ค

	<?php }else{ ?>
	<input type="checkbox"  name="check_paper" id = "check_paper" value="1">รับเช็ค

		<?php } ?>
	<input name="unit_check" type='text' class="w3-input" value="<?php echo $fetch1["unit_check"]; ?>"  id="unit_check" style="color:black;text-align:right" size="20" OnChange="JavaScript:chkNum(this)"/>
		</div><div class="w3-container w3-third">

<?php if ($fetch1["credit_card"]=='1'){ ?>
<input type="checkbox"  id = "credit_card" name="credit_card" checked="checked" value="1">รูดการ์ด 
<?php }else { ?>
<input type="checkbox"  id = "credit_card" name="credit_card" value="1">รูดการ์ด 

<?php } ?>

	<input name="unit_credit" type='text' class="w3-input"  id="unit_credit" value="<?php echo $fetch1["unit_credit"]; ?>" size="20" style="color:black;text-align:right"  OnChange="JavaScript:chkNum(this)"/> 
	</div><div class="w3-container w3-third">

<?php if ($fetch1["bill"]=='1'){ ?>

<input type="checkbox"  id = "bill" name="bill" checked="checked" value="1">วางบิล

<?php }else{ ?>
<input type="checkbox"  id = "bill" name="bill" value="1">วางบิล

	<?php } ?>
<input name="unit_bill" type='text' class="w3-input" style="color:black;text-align:right" id="unit_bill" value="<?php echo $fetch1["unit_bill"]; ?>" size="20" OnChange="JavaScript:chkNum(this)" />
</div><div class="w3-container w3-third">

<?php if ($fetch1["tran"]=='1'){ ?>

<input type="checkbox"  name="tran"id = "tran" checked="checked" value="1">ลูกค้าโอนเงินหน้างาน
<?php }else { ?>
<input type="checkbox"  name="tran"id = "tran"  value="1">ลูกค้าโอนเงินหน้างาน
	<?php } ?>

		 <input name="unit_tran" type='text' class="w3-input" id="unit_tran" size="20" value="<?php echo $fetch1["unit_tran"]; ?>" style="color:black;text-align:right" rows="1"OnChange="JavaScript:chkNum(this)"> 
</div><div class="w3-container w3-third">

<?php if ($fetch1["tran"]=='1'){ ?>

<input type="checkbox"  id = "dep" name="dep" checked="checked" value="1">อื่นๆ
<?php }else { ?>
<input type="checkbox"  id = "dep" name="dep" value="1">อื่นๆ


	<?php } ?>



<input name="dept" type='text' class="w3-input"  id="dept" value="<?php echo $fetch1["dept"]; ?>" size="20"  />
</div><div class="w3-container w3-third">

แผนก - ฝ่าย :

<input name="department_show" type='text' class="w3-input"  id="department_show" value="<?php echo $fetch1["department_show"]; ?>" size="20"  />
<?php /*
<select name="department_show" id="department_show" class="w3-input"   >
<option  value="">**โปรดเลือกแผนก-ฝ่าย**</option>
<option  value="ฝ่ายการตลาด">ฝ่ายการตลาด</option>
<option  value="ฝ่ายขาย">ฝ่ายขาย</option>
<option  value="ฝ่ายสนับสนุนการขาย ธุรการ">ฝ่ายสนับสนุนการขาย ธุรการ</option>

</select>*/ ?>

</div><div class="w3-container w3-third">
       ประเภทลูกค้า :

<input name="customer_typename" type='text' class="w3-input"  id="customer_typename" value="<?php echo $fetch1["type_customer"]; ?>" size="20"  />

<?php /*
<select name="customer_typename" id="customer_typename" class="w3-input"   >
<option  value="">**โปรดเลือกประเภทลูกค้า**</option>
<option  value="ร้านขายยา">ร้านขายยา</option>
<option  value="ลูกค้าทั่วไป">ลูกค้าทั่วไป</option>
<option  value="โรงพยาบาล">โรงพยาบาล</option>

</select>*/ ?>


</div><div class="w3-container w3-third">
       หน่วยงาน :

	   <input name="company_name" type='text' class="w3-input"  id="company_name" value="<?php echo $fetch1["type_company"]; ?>" size="20"  />
<?php /*
<select name="company_name" id="company_name" class="w3-input"   >
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="ฟาร์ ทริลเลี่ยน บจก.">ฟาร์ ทริลเลี่ยน บจก.</option>
<option  value="โนเบิล เมด บจก.">โนเบิล เมด บจก.</option>
<option  value="อื่นๆ">อื่นๆ</option>
</select>*/ ?>


</div><div class="w3-container w3-third">
       ประเภทงาน :
	   <input name="department_name" type='text' class="w3-input"  id="department_name" value="<?php echo $fetch1["department"]; ?>" size="20"  />
<?php /*
<select name="department_name" id="department_name" class="w3-input"   >
<option  value="">**โปรดเลือกประเภทงาน**</option>
<option  value="Online">Online</option>
<option  value="Sale">Sale</option>

</select>*/ ?>

</div><div class="w3-container w3-third">
ชื่อผู้ติดต่อ  :
<input name="customer_name1"  class="w3-input" type='text' value="<?php echo $fetch1["customer_name"]; ?>" id="customer_name1">

</div><div class="w3-container w3-third">
 ผู้รับสินค้า :
<input name="customer_contact" value="<?php echo $fetch1["customer_contact"]; ?>" class="w3-input" type='text' id="customer_contact">

</div><div class="w3-container w3-third">

 เบอร์โทรลูกค้า :
<input name="customer_tel"  class="w3-input" type='text' value="<?php echo $fetch1["customer_tel"]; ?>" id="customer_tel">

</div><div class="w3-container w3-third">
ชื่อโรงพยาบาล :
<input type='text'  class="w3-input" value="<?php echo $fetch1["address_name"]; ?>" name="address_name" >             


 </div>
<div class="w3-container w3-third">	

  ที่อยู่ :
<textarea   class="w3-input" name="address_send" cols="54" rows="1"><?php echo $fetch1["address_send"]; ?></textarea>

</div>
<div class="w3-container w3-third">
เลขที่เอกสาร/เลขที่เครื่อง : 
<textarea name="product_sn"  class="w3-input" id="product_sn" cols="54" rows="1"><?php echo $fetch1["product_sn"]; ?></textarea>

</div>
<div class="w3-container w3-third">
สินค้า/เอกสาร :  
<textarea name="product"  class="w3-input" id="product" cols="54" rows="1"><?php echo $fetch1["product_name"]; ?></textarea>

</div>

<div class="w3-container w3-third">
รายละเอียดเพิ่มเติม : 
     <textarea name="description"  class="w3-input" id="description" cols="54" rows="1"><?php echo $fetch1["description"]; ?></textarea>
</div>


<? }else{ ?>

	
<div class="w3-quarter"><!-- first third-->
<?php

		if($objResult["delivery_type"]=='1'){
			?>
<input type="radio" name="delivery_type" checked='checked' value="1">Sale รับเอง
<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4">บริษัทจัดส่ง <br />

<?php
		}else if($objResult["delivery_type"]=='2'){
	?>
<input type="radio" name="delivery_type" value="1">Sale รับเอง
<input type="radio" name="delivery_type" checked='checked' value="2">ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4">บริษัทจัดส่ง <br />


		<?php
}else if($objResult["delivery_type"]=='3'){
		
			?>
	<input type="radio" name="delivery_type" value="1">Sale รับเอง
	<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
    <input type="radio" name="delivery_type" checked='checked' value="3">ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4">บริษัทจัดส่ง <br />

<?php
		}else if($objResult["delivery_type"]=='4'){
		?>

	<input type="radio" name="delivery_type" value="1">Sale รับเอง
	<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
    <input type="radio" name="delivery_type"  value="3">ลูกค้ารับเอง 
	<input type="radio" name="delivery_type" checked='checked' value="4">บริษัทจัดส่ง <br />

			<?php
}else {
			?>
	<input type="radio" name="delivery_type" value="1">Sale รับเอง
	<input type="radio" name="delivery_type" value="2">ช่างรับเอง<br />
    <input type="radio" name="delivery_type"  value="3">ลูกค้ารับเอง 
	<input type="radio" name="delivery_type"  value="4">บริษัทจัดส่ง <br />

				<?php
			}
				?><br \>
วันที่ส่ง
<input type="date" name="delivery_date" value="<?php echo $objResult["delivery_date"];?>" class="w3-input" >
เวลาส่ง
<input type="text" name="delivery_time" value="<?php echo $objResult["delivery_time"];?>" class="w3-input" >
การส่งสินค้า<br>

		<?php

		if($objResult["big_car"]=='1'){

			?>
<input type="checkbox" name="big_car" checked='checked' value="1">ต้องการรถใหญ่<br />
<?php
		}else{
	?>
<input type="checkbox" name="big_car" value="1">ต้องการรถใหญ่<br />

		<?php
}
		if($objResult["call_before"]=='1'){
			?>
<input type="checkbox" name="call_before" checked='checked' value="1">โทรแจ้งลูกค้าก่อนไป<br />
<?php
		}else{
	?>
<input type="checkbox" name="call_before" value="1">โทรแจ้งลูกค้าก่อนไป<br />
		<?php
}
		if($objResult["maps"]=='1'){
			?>
<input type="checkbox" name="maps" checked='checked' value="1">มีแผนที่ประกอบ</p>
<?php
		}else{
				?>
<input type="checkbox" name="maps" value="1">มีแผนที่ประกอบ</p>
					
			<?php
			}
				?>
<input type='hidden' name='upload_map' id='upload_map' value ="<?php echo $objResult['upload_map']; ?>"  />

<input name="upload_map"  type="file"><a href="upload/<?php echo $objResult['upload_map']; ?>" target="_blank"><?php echo $objResult['upload_map']; ?></a></p>

				<?php
			
				if($objResult["assign_date_time"]=='1'){
						?>
<input type="checkbox" name="assign_date_time" checked='checked' value="1">นัดวันเวลาเรียบร้อยแล้ว<br />

<?php
				}else{
	?>
<input type="checkbox" name="assign_date_time" value="1">นัดวันเวลาเรียบร้อยแล้ว<br />

<?php
}
?>
</div><!-- first third-->
<div class="w3-quarter w3-container"><!-- second quarter -->


สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" cols="20" rows="1" style="width:100%;resize: none" ><?php echo $objResult["delivery_place"]; ?></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" value ="<?php echo $objResult["delivery_contact"]; ?>" class="w3-input" >
</div><!-- second third-->
<div class="w3-quarter"><!-- 3rd third-->
<?php
if ($objResult["return_date"]=='1'){
?>
<input type="checkbox" name="return" checked="checked" value="1">รับคืนสินค้า<br>
<?php
}else{
	?>
<input type="checkbox" name="return" value="1">รับคืนสินค้า<br>
<?php
}
	?>

วันที่รับคืน
<input type="date" name="return_date" value ="<?php echo $objResult["return_date"]; ?>" class="w3-input" >



<input type="text" name="return_time" value ="<?php echo $objResult["return_time"]; ?>" class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address" value ="<?php echo $objResult["return_address"]; ?>" class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact"  value ="<?php echo $objResult["return_contact"]; ?>"  class="w3-input" >
</div><!-- 3rd third-->

<?php } ?>

</div>
<center>


<?php  /*<input type="submit" name="submit" class="w3-button w3-teal" >*/ ?>
</center>

      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>
</form>

</body>
</html>

