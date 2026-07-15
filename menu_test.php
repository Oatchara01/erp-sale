<div id="sidebar">
	<button type="button" class="sidebar-mobile-toggle">&#9776;</button>

	<div class="sidebar-header">
		<a href="main_test.php" class="sidebar-logo">
			<img src="img/allwellsale_logo.png" alt="logo">
			<span>ERP System</span>
		</a>
		<button type="button" class="sidebar-toggle-btn"><i class="fa fa-angle-left"></i></button>
	</div>

	<nav class="sidebar-nav">
		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-file-alt"></i></span><span class="sidebar-label">ออกเอกสาร</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<a href="register_allwell_br.php">Create ใบยืม</a>
				<a href="register_allwell.php">Create ใบสั่งขาย</a>
			</div>
		</div>
	</nav>

	<div class="sidebar-footer">
		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn">
				<span class="sidebar-icon"><i class="fa fa-user"></i></span>
				<span class="sidebar-label">Setting (<?php echo $_SESSION['name']; ?>)</span>
				<span class="sidebar-caret"><i class="fa fa-angle-down"></i></span>
			</button>
			<div class="sidebar-submenu">
				<a href="change_pass.php">Change Password</a>
				<a href="logout.php">Logout</a>
			</div>
		</div>
	</div>
</div>
