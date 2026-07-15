<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

<div id="sidebar">
	<button type="button" class="sidebar-mobile-toggle">&#9776;</button>

	<div class="sidebar-header">
		<a href="main_admin.php" class="sidebar-logo">
			<img width="28" height="28" src="img/allwellsale_logo.png" alt="logo">
			<span>ERP System</span>
		</a>
		<button type="button" class="sidebar-toggle-btn"><i class="fa fa-angle-left"></i></button>
	</div>

	<nav class="sidebar-nav">
		<div class="sidebar-group">
			<button type="button" class="sidebar-group-btn"><span class="sidebar-icon"><i class="fa fa-chart-bar"></i></span><span class="sidebar-label">Report</span><span class="sidebar-caret"><i class="fa fa-angle-down"></i></span></button>
			<div class="sidebar-submenu">
				<a href="search_sumallevery_rpa.php">ยอดรวม</a>
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
				<a href="https://allwellcenter.com/itsupport/" target="_blank">แจ้งปัญหาการใช้งาน</a>
				<a href="logout.php">Logout</a>
			</div>
		</div>
	</div>
</div>
