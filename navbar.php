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
        <button type="button" id="navbar-hamburger" class="navbar-btn" title="Toggle Sidebar" aria-label="เปิด/ปิดเมนู" aria-controls="sidebar" aria-expanded="true">
            <img src="img/icons/burger.svg" alt="" width="20" height="16">
        </button>
        <a href="main_suphos.php" class="navbar-logo">
            <img src="img/allwell_logo.png" onerror="this.src='allwell.png'" alt="Logo">
            <span class="navbar-title">ERP SALE</span>
        </a>
    </div>

    <div class="navbar-right">
        <button type="button" class="navbar-btn navbar-notification-btn" title="Notifications">
            <img src="img/icons/notification.svg" alt="" width="20" height="20">
        </button>

        <div class="navbar-user-container">
            <button type="button" class="navbar-user-btn" id="navbar-user-trigger">
                <div class="navbar-avatar">
                    <img src="img/icons/user.svg" alt="" width="32" height="32">
                </div>
                <span class="navbar-username"><?php echo $userName; ?></span>
                <img src="img/icons/arrow_down.svg" alt="" width="12" height="6" class="navbar-caret">
            </button>
            <div class="navbar-dropdown" id="navbar-user-dropdown">
                <div class="navbar-dropdown-header">
                    <strong><?php echo $userName . ' ' . $userSurname; ?></strong>
                    <span class="navbar-dropdown-role"><?php echo htmlspecialchars($_SESSION['position'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <hr class="navbar-dropdown-divider">
                <a href="change_pass.php"><img src="img/icons/iconoir_password-cursor.svg" alt="" width="20" height="20"> เปลี่ยนรหัสผ่าน</a>
                <a href="https://allwellcenter.com/itsupport/" target="_blank"><img src="img/icons/hugeicons_bubble-chat-question.svg" alt="" width="20" height="20"> แจ้งปัญหาการใช้งาน</a>
                <hr class="navbar-dropdown-divider">
                <a href="logout.php" class="logout-link"><img src="img/icons/lucide_log-out.svg" alt="" width="20" height="20"> ออกจากระบบ</a>
            </div>
        </div>
    </div>
</div>