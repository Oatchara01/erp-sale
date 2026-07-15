<?php
// Ensure session is started and UserID is checked (head.php handles this, but safety check is good)
if (!isset($_SESSION['UserID'])) {
    return;
}

$userName = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8') : 'User';
$userSurname = isset($_SESSION['surname']) ? htmlspecialchars($_SESSION['surname'], ENT_QUOTES, 'UTF-8') : '';
?>
<!-- Top Navbar -->
<div id="top-navbar">
    <div class="navbar-left">
        <button type="button" id="navbar-hamburger" class="navbar-btn" title="Toggle Sidebar">
            <i class="fa fa-bars"></i>
        </button>
        <a href="main_suphos.php" class="navbar-logo">
            <img src="img/allwell_logo.png" onerror="this.src='allwell.png'" alt="Logo">
            <span class="navbar-title">ERP SALE</span>
        </a>
    </div>

    <div class="navbar-right">
        <button type="button" class="navbar-btn navbar-notification-btn" title="Notifications">
            <i class="far fa-bell"></i>
        </button>

        <div class="navbar-user-container">
            <button type="button" class="navbar-user-btn" id="navbar-user-trigger">
                <div class="navbar-avatar">
                    <i class="fa fa-user"></i>
                </div>
                <span class="navbar-username"><?php echo $userName; ?></span>
                <i class="fa fa-angle-down navbar-caret"></i>
            </button>
            <div class="navbar-dropdown" id="navbar-user-dropdown">
                <div class="navbar-dropdown-header">
                    <strong><?php echo $userName . ' ' . $userSurname; ?></strong>
                    <span class="navbar-dropdown-role"><?php echo htmlspecialchars($_SESSION['position'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <hr class="navbar-dropdown-divider">
                <a href="change_pass.php"><i class="fa fa-key"></i> เปลี่ยนรหัสผ่าน</a>
                <a href="https://allwellcenter.com/itsupport/" target="_blank"><i class="fa fa-question-circle"></i> แจ้งปัญหาการใช้งาน</a>
                <hr class="navbar-dropdown-divider">
                <a href="logout.php" class="logout-link"><i class="fa fa-sign-out-alt"></i> ออกจากระบบ</a>
            </div>
        </div>
    </div>
</div>