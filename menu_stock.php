<div id="sidebar">
	<button type="button" class="sidebar-mobile-toggle">&#9776;</button>

	<div class="sidebar-header">
		<a href="main_stock.php" class="sidebar-logo">
			<span>ERP System</span>
		</a>
		<button type="button" class="sidebar-toggle-btn"><i class="fa fa-angle-left"></i></button>
	</div>

	<nav class="sidebar-nav">
		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-cog"></i></span><span class="sidebar-label">Setting</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<a href="add_product.php">สินค้า</a>
				<a href="add_bom_lzdhm.php">สินค้า BOM LAZADA HEALTH MART</a>
				<a href="add_bom_lzdmd.php">สินค้า BOM LAZADA MED SHOP</a>
				<a href="add_bom_shopee.php">สินค้า BOM SHOPEE</a>
				<a href="add_bom_producthos.php">สินค้า BOM Hospital</a>
			</div>
		</div>

		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-chart-bar"></i></span><span class="sidebar-label">Report</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<a href="search_product_tran.php">รายงานการเคลื่อนไหวสินค้า</a>
				<a href="search_jong_order.php">รายงานสินค้ารอออก ORDER</a>
				<a href="search_accessst.php">รายงานดึงข้อมูลลงทะเบียน Access Online</a>
				<a href="search_accesshos.php">รายงานดึงข้อมูลลงทะเบียน Access Hospital</a>
				<a href="search_inter.php">รายการขนส่งอินเตอร์</a>
			</div>
		</div>

		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-globe"></i></span><span class="sidebar-label">รายการ Sale Online</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<a href="status_stock.php">Status Online</a>
				<a href="status_stock_sendbill.php">Status เปิดบิลแล้วรอส่งของ</a>
				<a href="status_stock_bed.php">Status Online เตียง</a>
				<a href="status_stock_fak.php">Status Online ใบฝาก</a>
				<a href="status_stock_all.php">Status Online All</a>
				<a href="status_clearst_allwell.php">รายการใบยืมค้างเคลียร์โชว์รูม</a>
				<?php if($_SESSION['name']=="พิทักษ์ชัย" or $_SESSION['name']=="สิลปชัย"){ ?>
				<a href="status_admin_bed.php">Status Edit Product</a>
				<?php } ?>
			</div>
		</div>

		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-hospital"></i></span><span class="sidebar-label">รายการ Sale Hospita</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<a href="status_stockbrhoskang.php">Status Hospital (ใบยืม) รออนุมัติ</a>
				<a href="status_stockbrhos.php">Status Hospital (ใบยืม)</a>
				<a href="status_stockhoskang.php">Status Hospital (ใบสั่งขาย) รออนุมัติ</a>
				<a href="status_stockhos.php">Status Hospital (ใบสั่งขาย)</a>
				<a href="status_stockhos_sendbill.php">Status (SO) เปิดบิลแล้วรอส่งของ</a>
				<a href="status_stockhos_Accept.php">Status Hospital (ใบสั่งขาย[ใบฝาก])</a>
				<a href="status_stockbrhos_all.php">Status Hospital All(ใบยืม)</a>
				<a href="status_stockhos_all.php">Status Hospital All(ใบสั่งขาย)</a>
				<a href="status_clearbr_st.php">Status ใบยืมค้างเคลียร์</a>
			</div>
		</div>

		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-minus-circle"></i></span><span class="sidebar-label">ใบสั่งลดหนี้</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<a href="status_credit_st.php">รายการใบสั่งลดหนี้</a>
				<a href="status_credit_stall.php">รายการใบสั่งลดหนี้ทั้งหมด</a>
			</div>
		</div>

		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-cubes"></i></span><span class="sidebar-label">ใบเบิกสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<a href="status_stocksmp.php">รายการใบเบิกสินค้า</a>
				<a href="status_stocksmpall.php">รายการใบเบิกสินค้า All</a>
			</div>
		</div>

		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-reply"></i></span><span class="sidebar-label">การรับคืนสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<a href="status_receive_pro.php">รายการการคืนสินค้า</a>
			</div>
		</div>

		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-bookmark"></i></span><span class="sidebar-label">ใบจอง</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<a href="status_stjong.php">Status ใบจอง</a>
				<a href="status_stjongall.php">Status ใบจองทั้งหมด</a>
				<a href="calendar_stjong.php">ปฏิทินใบจอง</a>
			</div>
		</div>

		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-exchange-alt"></i></span><span class="sidebar-label">ใบแลกเปลี่ยนสินค้า</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<a href="status_stockchanghos.php">Status ใบแลกเปลี่ยนสินค้า</a>
				<a href="status_stockchanghosall.php">Status ใบแลกเปลี่ยนสินค้า All</a>
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
				<a href="logout.php">Logout</a>
			</div>
		</div>
	</div>
</div>
