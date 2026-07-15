<?php
function encryptData($data, $secretKey = 'mySecretKey123456789') {
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
			<img src="img/allwellsale_logo.png" alt="logo">
			<span>ERP ALLWELL</span>
		</a>
		<button type="button" class="sidebar-toggle-btn"><i class="fa fa-angle-left"></i></button>
	</div>

	<nav class="sidebar-nav">

	<?php if ($_SESSION['name']=='ชนิกานต์' or $_SESSION['name']=='ชนาภา' or $_SESSION['name']=='ปาลิตา' or $_SESSION['name']=='ศุภลักษณ์'  or $_SESSION['name']=='ปวัน​รัตน์​' or $_SESSION['name']=='กัญญารัตน์' or $_SESSION['name']=='ธัญนุช' or $_SESSION['name']=='มิณฑิตา') { ?>

	<?php if ($_SESSION['name']=='ปาลิตา'   or $_SESSION['name']=='กัญญารัตน์') { ?>
	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-cog"></i></span><span class="sidebar-label">Setting</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="status_customerallwell.php">ลูกค้า</a>
			<a href="add_customer_rgister.php">บัตรสมาชิก</a>
		</div>
	</div>
	<?php } ?>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-cubes"></i></span><span class="sidebar-label">ยอดสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="https://stock.allwellcenter.com/report_hotpro1.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม เตียงและสินค้าประกอบ</a>
			<a href="https://stock.allwellcenter.com/report_hotpro2.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม สินค้า Online</a>
			<a href="https://stock.allwellcenter.com/report_hotpro3.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม สินค้าทั่วไป</a>
			<a href="https://stock.allwellcenter.com/report_hotpro4.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยมสินค้า Allied</a>
			<a href="search_productall.php">รายงานสินค้าคงเหลือแบบเลือกรายการ</a>
			<?php if($_SESSION['name']=='ชนิกานต์'    or $_SESSION['name']=='กัญญารัตน์' or $_SESSION['name']=='ปาลิตา' or $_SESSION['name']=='ปวัน​รัตน์​'){?>
			<a href="https://stock.allwellcenter.com/report_prduct_online.php" target="_blank">รายงานสินค้าคงเหลือน้อยกว่าจุดสั่งซื้อ (ออนไลน์)</a>
			<a href="https://stock.allwellcenter.com/report_prduct_bed.php" target="_blank">รายงานสินค้าคงเหลือน้อยกว่าจุดสั่งซื้อ (เตียงไฟฟ้า)</a>
			<?php } ?>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-chart-bar"></i></span><span class="sidebar-label">Report ยอดขาย</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="search_reccord_supall.php">Sale Record สินค้า</a>
			<a href="search_reccord_supall1.php">Sale Record เลขที่เอกสาร</a>
			<?php if($_SESSION['name']=='ชนิกานต์' or $_SESSION['name']=='ปาลิตา'   or $_SESSION['name']=='กัญญารัตน์' or $_SESSION['name']=='ปวัน​รัตน์​' or $_SESSION['name']=='ชนาภา' or $_SESSION['name']=='ธัญนุช' or $_SESSION['name']=='มิณฑิตา'){ ?>
			<a href="report_dadecom.php">ยอดขายของช่องทาง E-commerce (Dashboard)</a>
			<?php if($_SESSION['name']=='ชนิกานต์' or $_SESSION['name']=='ปาลิตา'  or $_SESSION['name']=='กัญญารัตน์' or $_SESSION['name']=='ชนาภา'){ ?>
			<a href="report_ecomercevip.php">รายงานเปิดออเดอร์ E-Commerce</a>
			<a href="report_ecomercevip1.php">รายงานยอดสั่งซื้อ E-Commerce</a>
			<?php }
					} ?>
		</div>
	</div>

	<?php if( $_SESSION['name']=='ปาลิตา'   or $_SESSION['name']=='กัญญารัตน์'){ ?>
	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-minus-circle"></i></span><span class="sidebar-label">ใบสั่งลดหนี้</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="register_credit_allwell.php">สร้างใบสั่งลดหนี้</a>
			<a href="status_credit_mk.php">รายการใบสั่งลดหนี้</a>
		</div>
	</div>
	<?php } ?>

	<?php if ($_SESSION['name']=='ชนาภา') { ?>
	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-reply"></i></span><span class="sidebar-label">รับคืนสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="status_receive_allwell.php">Status บันทึกรับคืนสินค้า</a>
		</div>
	</div>
	<?php } ?>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-shopping-bag"></i></span><span class="sidebar-label">Allwell</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="main_allwell_br.php">Create ใบยืม</a>
			<a href="main_allwell_so.php">Create ใบสั่งขาย</a>
			<a href="status_allwell.php">Status เอกสาร</a>
			<a href="status_ecomsmp.php">Status Ecommerce</a>
			<a href="status_adminprice.php">Status ออเดอร์สินค้าราคาต่ำกว่ากำหนด</a>
			<?php if(  $_SESSION['name']=='กัญญารัตน์' or $_SESSION['name']=='ปาลิตา'){ ?>
			<a href="status_mkchange_glu.php">รายการออเดอร์เครื่อง G-426</a>
			<a href="status_mkchange_glucos.php">รายการออเดอร์เครื่อง GLUCOSURE</a>
			<a href="register_chother_blood.php">ลงทะเบียนลูกค้าแลกเครื่องวัดน้ำตาล</a>
			<a href="status_bloodch.php">รายการลูกค้าแลกเครื่องวัดน้ำตาลยี้ห้ออื่น</a>
			<?php } ?>
			<a href="status_brclear_allwell.php">ใบยืมค้างเคลียร์</a>
			<a href="status_clearbrmm.php">Status โชว์เคลียร์ยิม</a>
			<a href="search_brkangclear.php">รายงานใบยืมค้างเคลียร์ Showroom</a>
			<a href="status_etaxcustomer.php">ข้อมูลลูกค้าขอใบกำกับภาษี</a>
		</div>
	</div>

	<?php if ($_SESSION['name']=='ปาลิตา') { ?>
	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-shopping-bag"></i></span><span class="sidebar-label">ใบสั่งขาย IC</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="main_salehos_so.php">Sale Order (SO)</a>
			<a href="status_saleic.php">Status (IC) ฝากขาย</a>
		</div>
	</div>
	<?php } ?>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-cubes"></i></span><span class="sidebar-label">ใบเบิกสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="main_allwell_smp.php">สร้างใบเบิกสินค้า</a>
			<a href="status_sampleallwell.php">รายการใบเบิกสินค้า</a>
			<a href="status_samplemm.php">รายการใบเบิกสินค้า MM2</a>
		</div>
	</div>

	<?php if($_SESSION['name']=='ปวัน​รัตน์​' or $_SESSION['name']=='ธัญนุช' or $_SESSION['name']=='มิณฑิตา'){ ?>
	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-undo"></i></span><span class="sidebar-label">ใบยืม</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="main_salehos_br.php">Borrow (BR)</a>
			<a href="status_brhos.php">Status (BR)</a>
			<a href="status_clearbr.php">Status ใบยืมค้างเคลียร์</a>
			<a href="report_brkangbyarea.php">ตรวจเช็คใบยืมค้างเคลียร์ (stock)</a>
			<a href="status_brsalearea.php">รายการตรวจเช็คใบยืม (ทั้งหมด)</a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-shopping-bag"></i></span><span class="sidebar-label">ใบสั่งขาย</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="main_suphos_so.php">Sale Order (SO)</a>
			<a href="status_mkhos.php">Status (SO)</a>
			<a href="status_glucosemkhos.php">รายงานรอส่ง SN Gluco All-Pro</a>
		</div>
	</div>
	<?php } ?>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-chart-bar"></i></span><span class="sidebar-label">Report</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="search_report_mk1.php">สรุปรายการขายแยกตามสินค้า</a>
			<a href="search_report_twodate.php">สรุปตามวันที่ (เลือกวัน)</a>
			<a href="search_report_bydate.php">สรุปตามวันที่ (ช่วงเวลา)</a>
			<a href="search_report_byproduct.php">สรุปตามสินค้า (เลือกวัน)</a>
			<a href="search_report_producttwo.php">สรุปตามสินค้า (ช่วงเวลา)</a>
			<a href="search_summary_product.php">สรุปตามสินค้า (เลือกวัน แบบสรุป)</a>
			<a href="search_summary_productdate.php">สรุปตามสินค้า (ช่วงเวลา แบบสรุป)</a>
			<a href="search_reportacc.php">รายงานยอดขายประจำวัน</a>
			<a href="search_bycustomer.php">สรุปจำนวนลูกค้า (เลือกวัน)</a>
			<a href="search_bycustomer_date.php">สรุปจำนวนลูกค้า (ช่วงเวลา)</a>
			<a href="search_summary_channel.php">สรุปจำนวนลูกค้า (ช่วงเวลา)</a>
			<a href="search_buyckk.php">รายงานลูกค้าซื้อซ้ำ</a>
			<a href="search_report_datemar.php">รายงานสรุปรายการสินค้า</a>
			<a href="search_sumresearch_mk.php">รายงานสรุปแบบสอบถามความพึงพอใจลูกค้าหลังการขายที่ต้องทำ</a>
			<a href="search_sumresearch_sale.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย (รายเดือน)</a>
			<a href="search_sumresearch_sale1.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขายแบบใหม่ (รายเดือน)</a>
			<a href="search_sumsearch_sale.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย (รายปี)</a>
			<a href="search_sumsearch_salenew.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขายแบบใหม่ (รายปี)</a>
			<a href="search_research_cs.php">รายงานความพึงพอใจของการจัดส่งและการประกอบติดตั้ง</a>
			<a href="search_research_cs1.php">รายงานความพึงพอใจของการจัดส่งและการประกอบติดตั้งแบบใหม่</a>
			<a href="search_report_mk.php">ประวัติการขาย / แยกตามสินค้า</a>

			<?php if ($_SESSION['name']=='ชนิกานต์' or $_SESSION['name']=='ปาลิตา'   or $_SESSION['name']=='กัญญารัตน์' or $_SESSION['name']=='ปวัน​รัตน์​' or $_SESSION['name']=='ธัญนุช' or $_SESSION['name']=='มิณฑิตา') {?>
			<a href="search_report_customer.php">รายงานประวัติการขาย แยกตามลูกค้า</a>
			<a href="search_report_allbyproduct.php">รายงานประวัติการขาย แยกตามสินค้า</a>
			<a href="search_cusbuyagain.php">รายงานลูกค้าซื้อซ้ำของสมาชิก Allwell</a>
			<a href="search_gugosure.php">รายงานการซื้อเครื่อง และแผ่น GLUCOSURE</a>
			<a href="search_cusmember.php">ข้อมูลการขายของสมาชิก Allwell</a>
			<a href="search_upcus.php">รายการสมาชิกที่มีการอัพเดทสถานะ</a>
			<?php if ($_SESSION['name']=='ชนิกานต์') {?>
			<a href="report_allwellecom.php">รายงานสรุปจำนวนลูกค้าสมาชิก Allwell member</a>
			<?php
			}
			}
			?>
			<?php if ($_SESSION['name']=='ปาลิตา'    or $_SESSION['name']=='กัญญารัตน์') { ?>
			<a href="status_almostpro.php">รายการสินค้ายอดนิยมออนไลน์สินค้าคงเหลือต่ำกว่ากำหนด</a>
			<?php } ?>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-question-circle"></i></span><span class="sidebar-label">แบบสอบถาม</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="status_research.php">ทำแบบสอบถาม</a>
			<a href="status_changeall.php">Status แบบสอบถามทั้งหมด</a>
			<a href="status_reserch_receive.php">แบบประเมินความพึงพอใจในการจัดสินค้า</a>
		</div>
	</div>

	<?php }else{ ?>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-cog"></i></span><span class="sidebar-label">Setting</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="status_customerallwell.php">ลูกค้า</a>
			<a href="add_customer_rgister.php">บัตรสมาชิก</a>
			<a href="add_vendor.php">ผู้ขาย</a>
			<a href="add_salechannel.php">ช่องทางการขาย</a>
			<a href="add_delivery.php">การจัดส่ง</a>
			<a href="run_customer.php">รันลูกค้า</a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-question-circle"></i></span><span class="sidebar-label">แบบสอบถาม</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="research_showroom.php">แบบสอบถามลูกค้า Showroom</a>
			<a href="status_showroom.php">รายการแบบสอบถาม</a>
			<a href="report_rsshowroom.php">รายงานแบบสอบถาม</a>
			<a href="status_soldemo.php">ทำแบบสอบถามสินค้าสาธิต</a>
			<a href="status_soldemoall.php">แบบสอบถามสินค้าสาธิตทั้งหมด</a>
			<a href="status_reserch_receive.php">แบบประเมินความพึงพอใจในการจัดสินค้า</a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-cubes"></i></span><span class="sidebar-label">ยอดสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="https://stock.allwellcenter.com/report_hotpro1.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม เตียงและสินค้าประกอบ</a>
			<a href="https://stock.allwellcenter.com/report_hotpro2.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม สินค้า Online</a>
			<a href="https://stock.allwellcenter.com/report_hotpro3.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม สินค้าทั่วไป</a>
			<a href="https://stock.allwellcenter.com/report_hotpro4.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยมสินค้า Allied</a>
			<a href="search_productall.php">รายงานสินค้าคงเหลือแบบเลือกรายการ</a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-search"></i></span><span class="sidebar-label">รายการค้นหาสินค้าผ่าน SN</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="search_snonline.php">รายการ Sale Online</a>
			<a href="search_snsalehos.php">รายการใบสั่งขาย</a>
			<a href="search_snsalehosbr.php">รายการใบยืม</a>
			<a href="search_snsmp.php">รายการใบเบิก SMP</a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-chart-bar"></i></span><span class="sidebar-label">Report</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="search_allwell99.php">Sale Record All</a>
			<a href="search_allwell.php">Sale Record สินค้า</a>
			<a href="search_allwell1.php">Sale Record เลขที่เอกสาร</a>
			<a href="search_clearbr.php">รายงานใบยืมที่ถูกเคลียร์ยืมแล้ว</a>
			<a href="search_sumresearch_mk.php">รายงานสรุปแบบสอบถามความพึงพอใจลูกค้าหลังการขายที่ต้องทำ</a>
			<a href="search_member.php">สรุปตามบัตรสมาชิก</a>
			<a href="search_upcus.php">รายการสมาชิกที่มีการอัพเดทสถานะ</a>
			<a href="search_report_twodate.php">สรุปตามวันที่ (เลือกวัน)</a>
			<a href="search_report_bydate.php">สรุปตามวันที่ (ช่วงเวลา)</a>
			<a href="search_report_byproduct.php">สรุปตามสินค้า (เลือกวัน)</a>
			<a href="search_report_producttwo.php">สรุปตามสินค้า (ช่วงเวลา)</a>
			<a href="search_summary_product.php">สรุปตามสินค้า (เลือกวัน แบบสรุป)</a>
			<a href="search_summary_productdate.php">สรุปตามสินค้า (ช่วงเวลา แบบสรุป)</a>
			<a href="search_bycustomer.php">สรุปจำนวนลูกค้า (เลือกวัน)</a>
			<a href="search_bycustomer_date.php">สรุปจำนวนลูกค้า (ช่วงเวลา)</a>
			<a href="search_summary_channel.php">สรุปจำนวนลูกค้า (ช่วงเวลา)</a>
			<a href="search_reportacc.php">รายงานยอดขายประจำวัน</a>
			<a href="search_buyckk.php">รายงานลูกค้าซื้อซ้ำ</a>
			<a href="search_report_mk.php">สรุปรายการขายแยกตามสินค้า</a>
			<a href="search_report_customer.php">รายงานประวัติการขาย แยกตามลูกค้า</a>
			<a href="search_sumresearch_sale.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย</a>
		</div>
	</div>

	<?php if ($_SESSION['name']!='รุจิรา') { ?>
	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-cubes"></i></span><span class="sidebar-label">ใบเบิกสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="main_allwell_smp.php">สร้างใบเบิกสินค้า</a>
			<a href="status_sampleallwell.php">รายการใบเบิกสินค้า</a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-minus-circle"></i></span><span class="sidebar-label">ใบสั่งลดหนี้</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="register_credit_allwell.php">สร้างใบสั่งลดหนี้</a>
			<a href="status_credit_allwell.php">รายการใบสั่งลดหนี้</a>
		</div>
	</div>
	<?php } ?>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-exchange-alt"></i></span><span class="sidebar-label">ใบแลกเปลี่ยนสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="main_allwell_change.php">สร้างใบแลกเปลี่ยนสินค้า</a>
			<a href="status_allwellchange.php">รายการใบแลกเปลี่ยนสินค้า</a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-reply"></i></span><span class="sidebar-label">รับคืนสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="status_receive_allwell.php">Status บันทึกรับคืนสินค้า</a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-upload"></i></span><span class="sidebar-label">Import</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="upload_99.php">Upload ข้อมูลร้าน 99</a>
			<a href="upload_tran.php">Upload ค่าจัดส่ง</a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-file-alt"></i></span><span class="sidebar-label">ใบสั่งเช่า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="main_allwell_rental.php">ใบสั่งเช่า</a>
			<a href="status_allwellrental.php">Status ใบสั่งเช่า</a>
			<a href="status_allwellrental_kang.php">Status ใบสั่งเช่ารอออกใบสั่งขาย</a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-shopping-bag"></i></span><span class="sidebar-label">AllWell</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="main_allwell_so.php">Create ใบสั่งขาย</a>
			<a href="main_allwell_br.php">Create ใบยืม</a>
			<a href="status_allwell.php">Status</a>
			<a href="status_allwell_fak.php">Status ใบฝาก</a>
			<a href="status_onlinekangsend.php">Status เตียงค้างส่ง</a>
			<a href="status_admin_bedkang.php">Status เตียง ค้าง IV</a>
			<a href="status_allwell_adminfak.php">Status ใบฝาก</a>
			<a href="status_researchk_sol.php">Status ค้างทำแบบสอบถาม</a>
			<a href="status_searchproduct.php">Status Search Product</a>
			<?php if($_SESSION['name']=='รัชดาภรณ์' or $_SESSION['name']=='ธนบัตร' or $_SESSION['name']=='นิรชา' or $_SESSION['name']=='กนกพร'){ ?>
			<a href="status_mkchange_glu.php">รายการออเดอร์เครื่อง G-426</a>
			<a href="status_mkchange_glucos.php">รายการออเดอร์เครื่อง GLUCOSURE</a>
			<a href="register_chother_blood.php">ลงทะเบียนลูกค้าแลกเครื่องวัดน้ำตาล</a>
			<a href="status_bloodch.php">รายการลูกค้าแลกเครื่องวัดน้ำตาลยี้ห้ออื่น</a>
			<?php } ?>
			<a href="status_brclear_allwell.php">ใบยืมค้างเคลียร์</a>
			<a href="status_clearbrmm.php">Status โชว์เคลียร์ยิม</a>
			<a href="report_itkangbr_all.php">รายงานใบยืมค้างเคลียร์ ตามเขตการขาย</a>
			<a href="search_brkangclear.php">รายงานใบยืมค้างเคลียร์ Showroom</a>
			<a href="report_brkangbyaw.php">ตรวจเช็คใบยืมค้างเคลียร์ (stock)</a>
			<a href="status_brareaaw.php">รายการตรวจเช็คใบยืม (ทั้งหมด)</a>
			<a href="report_waitcod.php">รายการเก็บเงินปลายทาง</a>
			<?php if ($_SESSION['type_login']=='Sup_AllWell') { ?>
			<a href="status_approve_sol.php">อนุมัติ</a>
			<?php } ?>
		</div>
	</div>

	<?php if ($_SESSION['type_login']=='Sup_AllWell') { ?>
	<?php if ($_SESSION['name']!='รุจิรา') { ?>
	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-hospital"></i></span><span class="sidebar-label">Hospital</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="status_br_hos.php">Status (BR)</a>
			<a href="status_hos.php">Status (SO)</a>
			<a href="register_br_hos.php">Borrow (BR)</a>
			<a href="register_sale_hos.php">Sale Order (SO)</a>
		</div>
	</div>
	<?php } } ?>

	<?php if ($_SESSION['name']!='รุจิรา') { ?>
	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-money-bill"></i></span><span class="sidebar-label">ใบมัดจำ</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="status_deposit.php">รายการใบรับเงินมัดจำ</a>
			<a href="register_deposit.php">ใบรับเงินมัดจำ</a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-bookmark"></i></span><span class="sidebar-label">ใบจอง</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="main_homecare_jong.php">สร้างใบจอง</a>
			<a href="status_homecare.php">Status ใบจอง</a>
			<a href="status_homecare_clear.php">Status ใบจองค้างเคลียร์</a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-file-alt"></i></span><span class="sidebar-label">ใบเสนอราคา</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="main_qou.php">สร้างใบเสนอราคา</a>
			<a href="status_qou.php">รายการใบเสนอราคา</a>
		</div>
	</div>
	<?php } ?>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-inbox"></i></span><span class="sidebar-label">รายการรับเรื่องจากลูกค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="register_story.php">การรับเรื่องจากลูกค้า</a>
			<a href="status_storycreate.php">รายการรับเรื่องจากลูกค้าเอง</a>
			<a href="status_storykangall.php">รายการรับเรื่องจากลูกค้า (ค้าง)</a>
			<a href="status_storyallwellall.php">รายการรับเรื่องจากลูกค้า (ปิดงานแล้ว)</a>
			<a href="register_cuseng.php">การรับเรื่องลูกค้าของช่าง</a>
			<a href="status_cusopen.php">รายการรับเรื่องลูกค้าช่าง</a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-book"></i></span><span class="sidebar-label">คู่มือการใช้งาน</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="manual/Story_Allwell.pdf">คู่มือรายการรับเรื่องลูกค้า</a>
			<a href="manual/Jong_Allwell.pdf">คู่มือ ใบจอง</a>
			<a href="manual/BR_Allwell.pdf">คู่มือ ใบยืม</a>
			<a href="manual/ClearBr_Allwell.pdf">คู่มือ การเคลียร์ใบยืม</a>
			<a href="manual/SaleOrder_Allwell.pdf">คู่มือ ใบสั่งขาย</a>
			<a href="manual/Order_Allwell.pdf">คู่มือ ใบฝาก</a>
			<a href="manual/Credit_Allwell.pdf">คู่มือ ใบลดหนี้</a>
			<a href="manual/Change_Allwell.pdf">คู่มือ ใบแลกเปลี่ยน</a>
			<a href="manual/Sample_Allwell.pdf">คู่มือ ใบเบิกเพื่อสนับสนุนการขาย</a>
			<a href="manual/Research_Allwell.pdf">คู่มือ แบบประเมินความพึงพอใจ</a>
		</div>
	</div>

	<?php if ($_SESSION['name']=='นิรชา' or $_SESSION['name']=='รัชดาภรณ์' or $_SESSION['name']=='ธนบัตร' or $_SESSION['name']=='กนกพร') { ?>

	<?php
	$strSQLp5 = "SELECT *  FROM fb__maim  where  status_doc ='3' and department_id LIKE '%SO%'";
	$objQueryp5 = mysqli_query($user,$strSQLp5) or die ("Error Query [".$strSQLp5."]");
	$Num_Rowsp5 = mysqli_num_rows($objQueryp5);
	?>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn">
			<span class="sidebar-icon"><i class="fa fa-comments"></i></span>
			<span class="sidebar-label">แบบฟอร์ม Feedback</span>
			<?php if($Num_Rowsp5 > 0 ){ ?><span class="sidebar-badge">(<?php echo $Num_Rowsp5; ?>)</span><?php } ?>
			<span class="sidebar-caret"><i class="fa fa-angle-down"></i></span>
		</button>
		<div class="sidebar-submenu">
			<a href="https://feedback.allwellcenter.com/check_login_out.php?token=<?php echo  $token; ?>" target="_blank">แบบฟอร์ม Feedback<?php if($Num_Rowsp5 > 0 ){ ?> (<?php echo $Num_Rowsp5; ?>)<?php } ?></a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-chart-bar"></i></span><span class="sidebar-label">Report ยอดขาย</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="search_reccord_supall.php">Sale Record สินค้า</a>
			<a href="search_reccord_supall1.php">Sale Record เลขที่เอกสาร</a>
		</div>
	</div>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-chart-bar"></i></span><span class="sidebar-label">รายงานใบยืมสินค้าคงเหลือ</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="search_sumbrpdk.php" target="_blank">รายงานใบยืมสินค้าคงเหลือตามสินค้า</a>
			<a href="report_sumbrpdk_all.php" target="_blank">รายงานใบยืมสินค้าคงเหลือทั้งหมด</a>
		</div>
	</div>

	<?php

	} if($_SESSION['name']=='ปวัน​รัตน์​'){ ?>

	<div class="sidebar-group">
		<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-chart-bar"></i></span><span class="sidebar-label">Report ยอดขาย</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
		<div class="sidebar-submenu">
			<a href="search_reccord_supall.php">Sale Record สินค้า</a>
			<a href="search_reccord_supall1.php">Sale Record เลขที่เอกสาร</a>
			<a href="report_dadecom.php">ยอดขายของช่องทาง E-commerce (Dashboard)</a>
		</div>
	</div>

	<?php } ?>
	<?php } ?>

	</nav>

	<div class="sidebar-footer">
		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn">
				<span class="sidebar-icon"><i class="fa fa-user"></i></span>
				<span class="sidebar-label">Setting (<?php echo $_SESSION['name']; ?> <?php echo $_SESSION['surname']; ?>)</span>
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
