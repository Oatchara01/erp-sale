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
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-chart-bar"></i></span><span class="sidebar-label">Report</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<a href="search_report_twodate.php">สรุปตามวันที่ (เลือกวัน)</a>
				<a href="search_report_bydate.php">สรุปตามวันที่ (ช่วงเวลา)</a>
				<a href="search_report_byproduct.php">สรุปตามสินค้า (เลือกวัน)</a>
				<a href="search_report_producttwo.php">สรุปตามสินค้า (ช่วงเวลา)</a>
				<a href="search_summary_product.php">สรุปตามสินค้า (เลือกวัน แบบสรุป)</a>
				<a href="search_summary_productdate.php">สรุปตามสินค้า (ช่วงเวลา แบบสรุป)</a>
				<a href="search_bycustomer.php">สรุปจำนวนลูกค้า (เลือกวัน)</a>
				<a href="search_bycustomer_date.php">สรุปจำนวนลูกค้า (ช่วงเวลา)</a>
				<a href="search_summary_channel.php">สรุปจำนวนลูกค้า (ช่วงเวลา)</a>
			</div>
		</div>

		<a href="search_service_engineer.php" class="sidebar-link"><span class="sidebar-icon"><i class="fa fa-upload"></i></span><span class="sidebar-label">Export ข้อมูลติดตั้ง</span></a>
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
