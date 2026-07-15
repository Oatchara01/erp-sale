<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

<?php
function encryptData($data, $secretKey = 'mySecretKey123456789')
{
	// ให้ key เป็นไบต์ 32 bytes (SHA-256)
	$key = hash('sha256', $secretKey, true);      // 32 bytes
	$iv  = substr($key, 0, 16);                   // 16 bytes IV

	// คืน raw binary (OPENSSL_RAW_DATA) แล้ว base64_encode เพื่อให้ส่งใน URL ได้
	$cipher_raw = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
	return rawurlencode(base64_encode($cipher_raw)); // rawurlencode เพื่อความปลอดภัยใน URL
}

// ตัวอย่างใช้งาน
$em_id = $_SESSION['emid'];
$token = encryptData($em_id, 'mySecretKey123456789');
?>
<div id="sidebar">
	<button type="button" class="sidebar-mobile-toggle">&#9776;</button>

	<div class="sidebar-header">
		<a href="main_admin.php" class="sidebar-logo">
			<img width="90" height="24" src="img/allwellsale_logo.png" alt="logo">
			<span>ERP IT</span>
		</a>
		<button type="button" class="sidebar-toggle-btn"><i class="fa fa-angle-left"></i></button>
	</div>

	<nav class="sidebar-nav">
		<?php if ($_SESSION['name'] == 'ชลชินี' or $_SESSION['name'] == 'สมบัติ') {
		} else { ?>
			<div class="sidebar-group">
				<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-upload"></i></span><span class="sidebar-label">Export ข้อมูล</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
				<div class="sidebar-submenu">
					<a href="search_cusexpress_sol.php">ดึงรายชื่อลูกค้าออนไลน์</a>
					<a href="search_orderexpress_sol.php">ดึงรายการ Order ออนไลน์ (ใบสั่งขาย)</a>
					<a href="search_cusexpress_hos.php">ดึงรายชื่อลูกค้า รพ.</a>
					<a href="search_orderexpress_hos.php">ดึงรายการ Order รพ.</a>
					<a href="upload_crm.php">Upload ข้อมูลลูกค้าจาก CRM</a>
					<a href="search_orderexpress_ecom.php">ดึงข้อมูล Order E-Commerce ลง Express (เคลียร์ยืม)</a>
				</div>
			</div>
		<?php } ?>

		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-cubes"></i></span><span class="sidebar-label">ยอดสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<a href="https://stock.allwellcenter.com/report_herohomecare.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงาน Hero Product For Home Care</a>
				<a href="https://stock.allwellcenter.com/report_herohos.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงาน Hero Product For Hospital</a>
				<a href="https://stock.allwellcenter.com/report_hotpro1.php?name=<?php echo $_SESSION['name']; ?>">รายงานสินค้าคงเหลือ ยอดนิยม เตียงและสินค้าประกอบ</a>
				<a href="https://stock.allwellcenter.com/report_hotpro2.php?name=<?php echo $_SESSION['name']; ?>">รายงานสินค้าคงเหลือ ยอดนิยม สินค้า Online</a>
				<a href="https://stock.allwellcenter.com/report_hotpro3.php?name=<?php echo $_SESSION['name']; ?>">รายงานสินค้าคงเหลือ ยอดนิยม สินค้าทั่วไป</a>
				<a href="https://stock.allwellcenter.com/report_hotphhr.php?name=<?php echo $_SESSION['name']; ?>">รายงานสินค้าคงเหลือ หีบห่อ</a>
				<a href="search_productall.php">รายงานสินค้าคงเหลือแบบเลือกรายการ</a>
				<a href="https://stock.allwellcenter.com/report_prduct_online.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าใกล้หมด (ออนไลน์)</a>
				<a href="https://stock.allwellcenter.com/report_prduct_bed.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าใกล้หมด (เตียงไฟฟ้า)</a>
				<a href="https://stock.allwellcenter.com/report_prduct_online1.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าคงเหลือน้อยกว่าจุดสั่งซื้อ (ออนไลน์)</a>
				<a href="https://stock.allwellcenter.com/report_prduct_bed1.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าคงเหลือน้อยกว่าจุดสั่งซื้อ (เตียงไฟฟ้า)</a>
			</div>
		</div>

		<?php if ($_SESSION['name'] == 'ชลชินี' or $_SESSION['name'] == 'อัจฉรา'  or $_SESSION['name'] == 'สมบัติ') { ?>
			<div class="sidebar-group">
				<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-check-square"></i></span><span class="sidebar-label">อนุมัติเอกสาร</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
				<div class="sidebar-submenu">
					<a href="status_adminprice.php">อนุมัติออเดอร์สินค้าราคาต่ำกว่ากำหนด</a>
					<a href="status_approvecm.php">อนุมัติใบสั่งขายฝากขาย</a>
					<a href="status_approvebrsup.php">อนุมัติใบยืม (BRNP)</a>
					<a href="status_appbrbooth.php">อนุมัติใบยืมออกบูธ (BRNP)</a>
					<a href="status_appcmbrsc.php">อนุมัติใบยืมฝากขาย</a>
					<a href="status_smpapprove.php">อนุมัติใบเบิกสินค้า (SMP)</a>
					<?php if ($_SESSION['name'] == 'ชลชินี' or $_SESSION['name'] == 'อัจฉรา') { ?>
						<a href="status_sample_approve.php">อนุมัติใบเบิกสินค้า (SMP) [สิทธิ์พี่จืด]</a>
					<?php } ?>
					<a href="status_appspr_cm.php">อนุมัติใบเบิกเครื่องและอะไหล่ (SPR)</a>
					<a href="status_dmbreg_app.php">อนุมัติใบขอเบิกอะไหล่สินค้าขาย (BREG)</a>
					<a href="status_apprental.php">อนุมัติใบสั่งเช่า</a>
					<a href="status_credit_cmapprove.php">อนุมัติใบสั่งลดหนี้</a>
					<a href="status_app_credit.php">ข้อมูลวงเงินลูกค้า (รออนุมัติ)</a>
					<a href="status_approve_sol.php">อนุมัติเอกสารโชว์รูม</a>
					<a href="status_cmvat.php">อนุมัติใบกำกับภาษี</a>
					<a href="status_appckkst.php">อนุมัติรายการตรวจเช็คใบยืม</a>
					<a href="status_appexpro.php">อนุมัติใบเบิกเป็นสินค้าสาธิต</a>
					<a href="status_apprefst.php">อนุมัติขอปรับปรุงยอดสต็อก</a>
				</div>
			</div>
		<?php } else if ($_SESSION['name'] == 'ปิยะ') { ?>
			<div class="sidebar-group">
				<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-check-square"></i></span><span class="sidebar-label">อนุมัติเอกสาร</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
				<div class="sidebar-submenu">
					<a href="status_approvebrsup.php">อนุมัติใบยืม (BRNP)</a>
					<a href="status_supvat.php">อนุมัติใบกำกับภาษี</a>
					<a href="status_approve_no.php">อนุมัติใบแจ้งสินค้าไม่สมบูรณ์</a>
				</div>
			</div>
		<?php } else if ($_SESSION['name'] == 'พัชร์ชนัญ') { ?>
			<div class="sidebar-group">
				<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-check-square"></i></span><span class="sidebar-label">อนุมัติเอกสาร</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
				<div class="sidebar-submenu">
					<a href="status_apprefst.php">อนุมัติขอปรับปรุงยอดสต็อก</a>
				</div>
			</div>
		<?php } ?>

		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-file-alt"></i></span><span class="sidebar-label">รายการเอกสาร</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">

				<a href="status_deposit.php">ใบรับเงินมัดจำ</a>
				<a href="status_mkchange_glu.php">รายการออเดอร์เครื่อง G-426</a>
				<a href="status_mkchange_glucos.php">รายการออเดอร์เครื่อง GLUCOSURE</a>
				<a href="register_chother_blood.php">ลงทะเบียนลูกค้าแลกเครื่องวัดน้ำตาล</a>
				<a href="status_bloodch.php">รายการลูกค้าแลกเครื่องวัดน้ำตาลยี้ห้ออื่น</a>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ใบสั่งขาย</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">
						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">Online</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="status_allwell.php">Status</a>
								<a href="status_admin.php">Status Adm</a>
								<a href="status_admin_bed.php">Status เตียง</a>
								<a href="status_allprice.php">Status ออเดอร์สินค้าราคาต่ำกว่ากำหนด</a>
								<a href="status_cancel_ecom.php">Status Order Shopee ยกเลิก</a>
							</div>
						</div>
						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">Hospital</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="status_adminhos.php">Status ใบสั่งขาย (SO)</a>
								<a href="status_adminhos1.php">Status (SO)ค้างเลขที่ IV</a>
								<a href="status_adminhos.php">สถานะ (SO)</a>
								<a href="status_admin_jong.php">Status (SO) ใบฝาก</a>
							</div>
						</div>
					</div>
				</div>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ใบยืม</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">
						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">Online</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="status_allwell.php">Status</a>
								<a href="search_brkangclear.php">รายงานใบยืมค้างเคลียร์ Showroom</a>
								<a href="status_clearst_allwell.php">รายการใบยืมค้างเคลียร์โชว์รูม Stock</a>
								<a href="status_clear_admin.php">Status ใบยืมค้างเคลียร์ Adm</a>
							</div>
						</div>
						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">Hospital</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="status_supbrhos1.php">ใบยืม (BR)</a>
								<a href="report_brkangbysup.php">ตรวจเช็คใบยืมค้างเคลียร์ (stock)</a>
								<a href="status_brsuparea.php">รายการตรวจเช็คใบยืม (ทั้งหมด)</a>
								<a href="status_adminbrhos.php">สถานะ (BR)</a>
								<a href="status_clearbr_st.php">Status ใบยืมค้างเคลียร์ Stock</a>
								<a href="status_clearbr_adm.php">Status ใบยืมค้างเคลียร์ Adm</a>
							</div>
						</div>
					</div>
				</div>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ใบเบิกสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">
						<?php if ($_SESSION['name'] == 'สมบัติ') { ?>
							<a href="status_samplepm.php">รายการใบเบิกสินค้า (สนับสนุนการขาย)</a>
							<a href="status_adminmp.php">รายการเบิกสินค้าทั้งหมด</a>
						<?php } else if ($_SESSION['name'] == 'ชลชินี') { ?>
							<a href="status_samplecm.php">รายการใบเบิกสินค้า (สนับสนุนการขาย)</a>
							<a href="status_adminmp.php">รายการเบิกสินค้าทั้งหมด</a>
						<?php } else { ?>
							<a href="status_adminmp.php">รายการเบิกสินค้า Admin</a>
						<?php } ?>
					</div>
				</div>

				<a href="status_adminbrsc.php">Status ใบฝากขาย</a>
				<a href="status_adminchange.php">Status ใบแลกเปลี่ยน</a>
				<?php if ($_SESSION['name'] == 'ชลชินี' or $_SESSION['name'] == 'สมบัติ') { ?>
					<a href="status_spr.php">รายการใบเบิกเครื่องและอะไหล่</a>
				<?php } ?>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ใบสั่งเช่า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">
						<a href="status_suprental.php">Status ใบสั่งเช่า(Sup)</a>
						<a href="status_adminrental.php">Status ใบสั่งเช่า(Admin)</a>
						<a href="status_kangrental.php">Status ใบสั่งเช่ารอเปิดใบสั่งขาย</a>
						<?php if ($_SESSION['name'] == 'เฉลิมศักดิ์') { ?>
							<a href="rental_200_main.php">Status ใบสั่งเช่า(Md)</a>
						<?php } ?>
						<a href="status_adminrental_iv.php">Status ใบสั่งเช่าออกใบสั่งขาย</a>
					</div>
				</div>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ใบลดหนี้</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">
						<a href="status_credit_adm.php">รายการใบสั่งลดหนี้</a>
						<a href="status_credit_admall.php">รายการใบสั่งลดหนี้ทั้งหมด</a>
					</div>
				</div>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ค้นหาสินค้าผ่าน SN</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">
						<a href="search_snonline.php">รายการ Sale Online</a>
						<a href="search_snsalehos.php">รายการใบสั่งขาย</a>
						<a href="search_snsalehosbr.php">รายการใบยืม</a>
						<a href="search_snsmp.php">รายการใบเบิก SMP</a>
					</div>
				</div>

				<a href="status_etaxcustomer.php">ข้อมูลลูกค้าขอใบกำกับภาษี</a>
			</div>
		</div>

		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-edit"></i></span><span class="sidebar-label">ออกเอกสาร</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<a href="register_deposit.php">ใบรับเงินมัดจำ</a>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ใบสั่งขาย</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">
						<a href="main_allwell_so.php">Online</a>
						<a href="register_suphos.php">Hospital</a>
					</div>
				</div>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ใบยืม</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">
						<a href="main_allwell_br.php">Online</a>
						<a href="main_suphos_br.php">Hospital</a>
					</div>
				</div>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ใบเบิกสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">
						<?php if ($_SESSION['name'] == 'สมบัติ') { ?>
							<a href="main_cm_smp.php">- ใบเบิกสินค้า (สนับสนุนการขาย)</a>
						<?php } else if ($_SESSION['name'] == 'ชลชินี') { ?>
							<a href="main_cm_smp.php">- ใบเบิกสินค้า (สนับสนุนการขาย)</a>
						<?php } else { ?>
							<a href="main_admin_smp.php">- ใบเบิกสินค้า (สนับสนุนการขาย)</a>
						<?php } ?>
						<a href="status_ecomsmp.php">- Status Ecommerce</a>
					</div>
				</div>

				<a href="main_sup_brsc.php">ใบยืมฝากขาย</a>
				<a href="main_suphos_change.php">ใบแลกเปลี่ยนสินค้า</a>
				<a href="main_receivepro.php">ใบรับสินค้า</a>
				<a href="register_creditnot_create.php">ใบสั่งลดหนี้</a>
				<a href="main_sup_rental.php">ใบสั่งเช่า</a>

				<?php if ($_SESSION['name'] == 'อัจฉรา') { ?>
					<div class="sidebar-subgroup">
						<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ใบสั่งเช่า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
						<div class="sidebar-submenu">
							<a href="main_sale_rental.php">ใบสั่งเช่า (sale)</a>
							<a href="status_salerental.php">Status ใบสั่งเช่า(sale)</a>
							<a href="main_allwell_rental.php">ใบสั่งเช่า (โชว์รูม)</a>
							<a href="status_allwellrental.php">Status ใบสั่งเช่า(โชว์รูม)</a>
							<a href="main_sup_rental.php">ใบสั่งเช่า (Sup)</a>
							<a href="status_suprental.php">Status ใบสั่งเช่า(Sup)</a>
							<a href="status_apprental.php">Status ใบสั่งเช่า(อนุมัติ)</a>
							<a href="status_adminrental.php">Status ใบสั่งเช่า(Admin)</a>
						</div>
					</div>
				<?php } ?>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">E-Commerc</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">
						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ดึงข้อมูล</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="search_apilazada.php">Lazada</a>
								<a href="upload_shopee.php">Shopee1</a>
								<a href="upload_shopee1.php">Shopee2</a>
								<a href="upload_jdcental.php">JD central</a>
								<a href="upload_ctonline.php">Central Online</a>
								<a href="upload_officemate.php">Officemate</a>
								<a href="upload_nocnoc.php">Noc Noc</a>
								<a href="upload_homepro.php">Homepro</a>
								<a href="upload_homepro1.php">Homepro1</a>
								<a href="upload_tiktok.php">Tiktok</a>
								<a href="upload_ktc.php">KTC Ushop Web</a>
								<a href="upload_ktcnew.php">KTC Ushop Line & Face</a>
								<a href="upload_ktcmobile.php">KTC Ushop App</a>
								<a href="upload_bd.php">BeDee</a>
								<a href="upload_amaze.php">Amaze</a>
							</div>
						</div>
						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">Upload ข้อมุล</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="upload_discount.php">รายการส่วนลด</a>
								<a href="upload_tran.php">Upload ค่าจัดส่ง ร้าน 99</a>
								<a href="search_productpomo.php">รายการสินค้าของแถมโปรโมชั่น</a>
								<a href="upload_tranpro.php">Update ค่าส่วนต่างสินค้า</a>
								<a href="upload_99.php">Upload ข้อมูลร้าน 99</a>
								<a href="upload_solnb.php">Upload SOL NBM</a>
								<a href="Upload_cleariv.php">รายการเคลียร์ใบยืม</a>
								<a href="up_cleariv_no.php">รายการเคลียร์ใบยืมตามรายการสินค้า</a>
								<a href="upload_smptiktok.php">Update เลขขนส่ง SMP</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-chart-bar"></i></span><span class="sidebar-label">Report</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">

				<?php if ($_SESSION['name'] == 'สมบัติ' or $_SESSION['name'] == 'ชลชินี'  or $_SESSION['name'] == 'อัจฉรา' or $_SESSION['name'] == 'พัชร์ชนัญ') {  ?>
					<div class="sidebar-subgroup">
						<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">Report พี่เปิ้ล</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
						<div class="sidebar-submenu">

							<div class="sidebar-subgroup">
								<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">รายงานยอดขายเทียบเป้าหมาย</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
								<div class="sidebar-submenu">
									<a href="report_solgraph1.php">รวม</a>
									<a href="report_solgraph.php">แผนก Home Care</a>
									<a href="report_hosgraph.php">แผนกโรงพยาบาล</a>
								</div>
							</div>

							<div class="sidebar-subgroup">
								<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">รายงานยอดขายเปรียบเทียบปี</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
								<div class="sidebar-submenu">
									<a href="report_yearcom.php">รวม</a>
									<a href="report_yearhc.php">แผนก Home Care</a>
									<a href="report_yearhos.php">แผนก Hospital</a>
									<a href="report_year31hc.php">แยกตามลูกค้า</a>
									<div class="sidebar-subgroup">
										<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">แยกตามช่องทาง E-Com กลุ่มสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
										<div class="sidebar-submenu">
											<a href="report_yearecom.php">มูลค่า</a>
											<a href="report_countecom.php">จำนวน</a>
										</div>
									</div>
								</div>
							</div>

							<a href="report_sumbyproduct.php">รายงานยอดขายเรียงตามสินค้า/แผนก</a>

							<div class="sidebar-subgroup">
								<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">รายงานลูกค้าซื้อซ้ำ</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
								<div class="sidebar-submenu">
									<a href="search_buyckk.php">ตามกลุ่มสินค้า</a>
									<a href="search_cusbuyagain.php">ตามรหัสสมาชิก</a>
								</div>
							</div>

							<div class="sidebar-subgroup">
								<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">รายงานยอดขายตามกลุ่มสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
								<div class="sidebar-submenu">
									<a href="report_sumbygrouppro.php">เปรียบเทียบตามระยะเวลา /กลุ่มสินค้า</a>
									<a href="report_sumbyglugopro.php">รายงานยอดขาย Gluco All-Pro</a>
									<a href="search_buyprodaycom.php">ตามบริษัท</a>
									<a href="search_buyproday.php">ตามเขตการขาย</a>
								</div>
							</div>

							<a href="report_ecomercevip1.php">รายงานยอดสั่งซื้อ E-Commerce</a>
							<a href="report_ecomercevip.php">รายงานเปิดออเดอร์ E-Commerce</a>
							<a href="report_showroomvip.php">รายงานเปิดออเดอร์ Homecare</a>
							<a href="report_allwellecom.php">รายงานสรุปจำนวนลูกค้าสมาชิก Allwell member</a>

							<div class="sidebar-subgroup">
								<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">รายงานแบบสอบถาม</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
								<div class="sidebar-submenu">
									<a href="report_endemo.php">ความพึงพอใจสินค้าสาธิต</a>
									<a href="report_endemobypro.php">ความพึงพอใจสินค้าสาธิตตามสินค้า</a>
								</div>
							</div>

							<a href="report_sumchon.php">รายงานยอดขายตาม IV</a>
							<a href="report_orderprice.php">รายงานการอนุมัติสินค้าราคาต่ำกว่ากำหนด</a>
							<a href="status_ickangmd.php">รายงานเอกสาร IC & BRSC คงค้าง</a>
							<a href="report_smpsumall.php">รายงานใบเบิกสินค้า SMP (ทั้งหมด)</a>
							<a href="report_smpglu.php">รายงานใบเบิกสินค้า SMP (GLUCOALL-1B)</a>
							<a href="report_newsmp.php">รายงานแลกเปลี่ยนสินค้า (GLUCOALL-1B)</a>
							<a href="report_mdkangbr.php">รายงานใบยืมค้างเคลียร์ตามเขตการขาย</a>
							<a href="report_stockedit.php">รายงานขอปรับปรุงยอดสต็อก (ทั้งหมด)</a>
							<?php if ($_SESSION['name'] == 'อัจฉรา' or $_SESSION['name'] == 'พัชร์ชนัญ') {  ?>
								<a href="report_itkangbr.php">รายงานใบยืมค้างเคลียร์ตามเขตการขาย (ยอดค้างสต็อก)</a>
							<?php } ?>
							<a href="report_clearstsa.php">รายงานการเคลียร์ใบยืม New</a>
							<a href="status_almostpro.php">รายการสินค้ายอดนิยมออนไลน์สินค้าคงเหลือต่ำกว่ากำหนด</a>

							<?php if ($_SESSION['name'] == 'อัจฉรา') {  ?>
								<div class="sidebar-subgroup">
									<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">รายงานเจน</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
									<div class="sidebar-submenu">
										<a href="search_buyproday1.php">ดึงข้อมูลยอดขายตามกลุ่มสินค้า (jane)</a>
										<a href="search_buyproday2.php">ดึงข้อมูลยอดขาย E-Commerce (jane)</a>
										<a href="search_buyprodaybuy.php">ดึงข้อมูลยอดขายซื้อซ้ำ (jane)</a>
										<a href="search_buyagain.php">รายงานลูกค้าซื้อซ้ำ AA</a>
									</div>
								</div>
							<?php } ?>

						</div>
					</div>
				<?php } ?>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">Report SOL</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">

						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">รายงานสรุปตามวันที่</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="search_report_twodate.php">แบบเลือกวัน</a>
								<a href="search_report_bydate.php">แบบช่วงเวลา</a>
							</div>
						</div>

						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">รายงานสรุปตามสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="search_report_byproduct.php">แบบเลือกวัน</a>
								<a href="search_report_producttwo.php">แบบช่วงเวลา</a>
								<a href="search_summary_product.php">แบบเลือกวัน (สรุป)</a>
								<a href="search_summary_productdate.php">แบบช่วงเวลา (สรุป)</a>
								<a href="search_report_datemar.php">สรุปรายการสินค้า</a>
								<a href="search_product_tran.php">การเคลื่อนไหวสินค้า</a>
							</div>
						</div>

						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">รายงานสรุปตามลูกค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="search_bycustomer.php">จำนวนลูกค้า (เลือกวัน)</a>
								<a href="search_bycustomer_date.php">จำนวนลูกค้า (ช่วงเวลา)</a>
								<a href="search_summary_channel.php">จำนวนลูกค้าตามช่องทางการขาย</a>
								<a href="search_member.php">บัตรสมาชิก</a>
								<a href="search_upcus.php">การอัพเดทสถานะบัตรสมาชิก</a>
							</div>
						</div>

						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">รายงานการเคลียร์ยืม</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="search_kangclear.php">ออเดอร์ค้างเคลียร์ยืม</a>
								<a href="search_cleariv.php">ออเดอร์เคลียร์ยืม</a>
								<a href="search_solno.php">สรุปแยก SOL และ IV ที่ออกบิลแล้ว</a>
							</div>
						</div>

						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">รายงานประวัติการขาย</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="search_reportacc.php">ยอดขายประจำวัน</a>
								<a href="search_report_customer.php">ประวัติการขาย แยกตามลูกค้า</a>
								<a href="search_report_allbyproduct.php">ประวัติการขาย แยกตามสินค้า</a>
							</div>
						</div>

						<a href="search_cusmember.php">ข้อมูลการขายของสมาชิก Allwell</a>
					</div>
				</div>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">Report Hospital</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">

						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">รายงาน Sale Record</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="search_sale_record.php">สินค้า (ทั้งหมด)</a>
								<a href="search_hosrecpro.php">สินค้า (โรงพยาบาล)</a>
								<a href="search_solrecpro.php">สินค้า (ออนไลน์)</a>
								<a href="search_sale_record1.php">เลขที่เอกสาร (ทั้งหมด)</a>
								<a href="search_hosrec.php">เลขที่เอกสาร (โรงพยาบาล)</a>
								<a href="search_solrec.php">เลขที่เอกสาร (ออนไลน์)</a>
								<a href="search_sumallevery.php">ยอดรวม</a>
							</div>
						</div>

						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">รายงานเคลียร์ยืม</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="search_clearbr.php">สินค้าที่ถูกเคลียร์ยืมแล้ว</a>
								<a href="report_clearnobr.php">สินค้าค้างเคลียร์ยืม</a>
								<a href="search_clearnobr.php">การสรุปการยืมสินค้า</a>
								<a href="report_kangbrsc_dm.php">รายการใบยืมฝากขายคงค้าง แยกตามลูกค้า</a>
							</div>
						</div>

						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">รายงานยอดขายแบบกราฟ</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="search_supgraph.php">แยกเขต</a>
								<a href="search_grapsum.php">ทั้งหมด</a>
							</div>
						</div>

						<a href="search_jong_order.php">รายงานสินค้ารอออก ORDER</a>
						<?php if ($_SESSION['name'] == 'พัชร์ชนัญ') { ?>
							<a href="search_report_umim.php">รายการพี่อิ๋ม</a>
						<?php } ?>
					</div>
				</div>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">Report Stock</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">
						<a href="search_product_tran.php">รายงานการเคลื่อนไหวสินค้า</a>
						<a href="search_jong_order.php">รายงานสินค้ารอออก ORDER</a>
						<?php if ($_SESSION['name'] == 'ชลชินี' or $_SESSION['name'] == 'อัจฉรา') { ?>
							<a href="search_logall.php">รายการตรวจสอบการแก้ไขสินค้า</a>
						<?php } ?>
					</div>
				</div>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">Report Etax Invoice</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">

						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ดึงข้อมูล ใบกำกับภาษี/ใบเสร็จ</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="search_taxinvoice.php">ดึงข้อมูล ไฟล์ .txt (Home Care)</a>
								<a href="search_etax_ecomer.php">ดึงข้อมูล ไฟล์ .pdf (Home Care)</a>
								<a href="search_taxinvoice1.php">ดึงข้อมูล ไฟล์ .txt (Hospital)</a>
								<a href="search_etax_hos.php">ดึงข้อมูล ไฟล์ .pdf (Hospital)</a>
								<a href="search_taxinvoice_txt.php">ดึงข้อมูล ไฟล์ .txt (Home Care) ทดแทน</a>
								<a href="search_etax_ecomer1.php">ดึงข้อมูล ไฟล์ .pdf (Home Care)ทดแทน</a>
								<a href="search_taxinvoice_txt1.php">ดึงข้อมูล ไฟล์ .txt (Hospital) ทดแทน</a>
								<a href="search_etax_hos1.php">ดึงข้อมูล ไฟล์ .pdf (Hospital) ทดแทน</a>
							</div>
						</div>

						<div class="sidebar-subgroup">
							<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ดึงข้อมูล ใบรับคืนสินค้า/ใบลดหนี้</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
							<div class="sidebar-submenu">
								<a href="search_creditnote.php">ดึงข้อมูล ไฟล์ .txt</a>
								<a href="search_creditfrom.php">ดึงข้อมูล ไฟล์ .pdf</a>
								<a href="search_creditnote1.php">ดึงข้อมูล ไฟล์ .txt ทดแทน</a>
								<a href="search_creditfrom1.php">ดึงข้อมูล ไฟล์ .pdf ทดแทน</a>
							</div>
						</div>

					</div>
				</div>

				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">Report แบบสอบถาม</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">
						<a href="status_researchk_admin.php">รายการทำแบบสอบถาม</a>
						<a href="search_sumresearch_mk.php">รายงานสรุปแบบสอบถามความพึงพอใจลูกค้าหลังการขายที่ต้องทำ</a>
						<a href="search_sumresearch_sale.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย (รายเดือน)</a>
						<a href="search_sumresearch_sale1.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขายแบบใหม่ (รายเดือน)</a>
						<a href="search_sumsearch_sale.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย (รายปี)</a>
						<a href="search_sumsearch_salenew.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขายแบบใหม่ (รายปี)</a>
						<a href="search_research_cs.php">รายงานความพึงพอใจของการจัดส่งและการประกอบติดตั้ง</a>
						<a href="search_research_cs1.php">รายงานความพึงพอใจของการจัดส่งและการประกอบติดตั้งแบบใหม่</a>
						<a href="https://service-engineer.allwellcenter.com/main_admin.php">แบบประเมินความพึงพอใจของลูกค้าที่มีต่อบริการหลังการขายช่าง ( รายเดือน )</a>
						<a href="search_sumresearch_company.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย (รายเดือน) New</a>
					</div>
				</div>

				<a href="veiw_bussend.php">ตารางรถใหญ่</a>

				<?php if ($_SESSION['name'] == 'ปิยะ') { ?>
					<a href="status_almostpro.php">รายการสินค้ายอดนิยมออนไลน์สินค้าคงเหลือต่ำกว่ากำหนด</a>
				<?php } ?>
			</div>
		</div>

		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-inbox"></i></span><span class="sidebar-label">รายการรับเรื่อง</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ในส่วนของเซลล์</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">
						<a href="register_story.php">การรับเรื่องจากลูกค้า</a>
						<a href="status_storykang.php">รายการรับเรื่องจากลูกค้า (ค้าง)</a>
						<a href="status_storyall.php">รายการรับเรื่องจากลูกค้า (ปิดงานแล้ว)</a>
					</div>
				</div>
				<div class="sidebar-subgroup">
					<button type="button" class="sidebar-subgroup-btn"><span class="sidebar-label">ในส่วนของช่าง</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
					<div class="sidebar-submenu">
						<a href="register_cuseng.php">การรับเรื่องลูกค้าของช่าง</a>
						<a href="status_cusopen.php">รายการรับเรื่องลูกค้าช่าง</a>
					</div>
				</div>
			</div>
		</div>

	</nav>

	<div class="sidebar-group" style="margin-top: auto; border-top: 1px solid rgba(92, 27, 112, 0.15);">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-cog"></i></span><span class="sidebar-label">Setting</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="add_user.php">User</a>
			<a href="add_customer_rgister.php">บัตรสมาชิก</a>
			<a href="add_employee.php">พนักงาน</a>
			<a href="add_customer.php">ลูกค้า</a>
			<?php if ($_SESSION['name'] == 'ปิยะ' or $_SESSION['name'] == 'อัจฉรา') { ?>
				<a href="status_customerapp.php">อนุมัติลูกค้า</a>
				<a href="status_online_cls.php">รายการสินค้ายอดนิยมออนไลน์</a>
			<?php } ?>
			<a href="add_customer_rgister.php">บัตรสมาชิก</a>
			<a href="add_vendor.php">ผู้ขาย</a>
			<a href="add_payment.php">การชำระเงิน</a>
			<a href="add_salechannel.php">ช่องทางการขาย</a>
			<a href="add_delivery.php">การจัดส่ง</a>
			<a href="add_document.php">เอกสารประกอบการออกบิล</a>
			<a href="add_leaflet.php">ใบตรวจทาน</a>
			<a href="status_warproduct.php">ข้อมูลรายการรับประกันสินค้า</a>
			<?php if ($_SESSION['name'] == 'อัจฉรา' or $_SESSION['name'] == 'พัชร์ชนัญ') {  ?>
				<a href="add_prochang.php">สินค้าแลกเครื่องวัดน้ำตาล</a>
				<a href="status_app_credit.php">ข้อมูลวงเงินลูกค้า (รออนุมัติ)</a>
			<?php } ?>
		</div>
	</div>

	<div class="sidebar-footer">
		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn">
				<span class="sidebar-icon"><i class="fa fa-user"></i></span>
				<span class="sidebar-label">Setting (<?php echo $_SESSION['name']; ?>)</span>
				<span class="sidebar-caret"><i class="fa fa-angle-down"></i></span>
			</button>
			<div class="sidebar-submenu">
				<a href="change_pass.php">Change Password</a>
				<a href="https://allwellcenter.com/itsupport/" target="_blank">แจ้งปัญหาการใช้งาน</a>
				<a href="logout.php">Logout</a>
			</div>
		</div>
	</div>
</div>