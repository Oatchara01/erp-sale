<?php

/**
 * Migration runner — ใช้ได้ทั้ง CLI และหน้าเว็บ
 *
 *   php migrate.php status | up | down | dry-run
 *   เปิดผ่านเบราว์เซอร์: migrate.php  (ปุ่ม Dry-run / Run pending / Rollback)
 *
 * หน้าเว็บต้อง login ด้วยบัญชีที่ hardcode ด้านล่าง (session แยกจาก ERP หมดอายุเมื่อไม่ใช้งาน 30 นาที)
 * CLI ไม่ต้อง login — ผู้ที่สั่งได้มีสิทธิ์เข้าเครื่องเซิร์ฟเวอร์อยู่แล้ว
 * รายละเอียดการทำงานดู includes/migrator.php และ sql/migrations/README.md
 */

const MIGRATE_USER = 'Admin';
const MIGRATE_PASS = 'Admin@123';
const MIGRATE_IDLE_SECONDS = 1800;

mysqli_report(MYSQLI_REPORT_OFF);

require_once __DIR__ . '/dbconnect.php';
require_once __DIR__ . '/includes/migrator.php';

migrator_ensure_table($conn);

// ---------------------------------------------------------------------------
// CLI
// ---------------------------------------------------------------------------
if (PHP_SAPI === 'cli') {
	$cmd = $argv[1] ?? 'status';
	$by = 'cli';
	$dbRes = $conn->query('SELECT DATABASE() AS db');
	$dbRow = $dbRes ? $dbRes->fetch_assoc() : array('db' => '?');
	echo 'ฐานข้อมูล: ' . $dbRow['db'] . PHP_EOL;

	if ($cmd === 'up') {
		$results = migrator_up($conn, $by);
		if (!$results) {
			echo 'ไม่มี migration ที่รอรัน' . PHP_EOL;
		}
		foreach ($results as $r) {
			echo ($r['ok'] ? '[OK]     ' : '[FAILED] ') . $r['name'] . ($r['ok'] ? '' : '  → ' . $r['error']) . PHP_EOL;
		}
		exit($results && !end($results)['ok'] ? 1 : 0);
	}
	if ($cmd === 'down') {
		$r = migrator_down($conn, $by);
		echo ($r['ok'] ? '[ROLLED BACK] ' : '[FAILED] ') . $r['name'] . ($r['ok'] ? '' : '  → ' . $r['error']) . PHP_EOL;
		exit($r['ok'] ? 0 : 1);
	}
	if ($cmd === 'dry-run') {
		foreach (migrator_pending($conn) as $name) {
			$stmts = migrator_split(migrator_read_sql($name, 'up'));
			echo '== ' . $name . ' (' . count($stmts) . ' คำสั่ง)' . (migrator_data_warning($stmts) ? '  ⚠ แก้/ลบข้อมูล ย้อนกลับด้วย down ไม่ได้' : '') . PHP_EOL;
			foreach ($stmts as $s) {
				echo $s . ';' . PHP_EOL . PHP_EOL;
			}
		}
		exit(0);
	}
	// status
	$records = migrator_records($conn);
	foreach (migrator_files() as $name) {
		$st = isset($records[$name]) ? strtoupper($records[$name]['status']) : 'PENDING';
		echo str_pad($st, 8) . $name . (isset($records[$name]) ? '  (' . $records[$name]['ran_at'] . ' โดย ' . $records[$name]['ran_by'] . ')' : '') . PHP_EOL;
	}
	exit(0);
}

// ---------------------------------------------------------------------------
// เว็บ
// ---------------------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
	session_name('migrate_auth');
	session_set_cookie_params(array('httponly' => true, 'samesite' => 'Lax'));
	session_start();
}
$h = function ($s) {
	return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
};
$action = $_SERVER['REQUEST_METHOD'] === 'POST' ? (string)($_POST['action'] ?? '') : '';
$loginError = '';

// หมดอายุเมื่อไม่ใช้งานเกินกำหนด
if (isset($_SESSION['migrate_user']) && time() - (int)($_SESSION['migrate_last'] ?? 0) > MIGRATE_IDLE_SECONDS) {
	unset($_SESSION['migrate_user'], $_SESSION['migrate_last']);
	$loginError = 'หมดเวลา กรุณา login ใหม่';
}

if ($action === 'login') {
	$okUser = hash_equals(MIGRATE_USER, (string)($_POST['user'] ?? ''));
	$okPass = hash_equals(MIGRATE_PASS, (string)($_POST['pass'] ?? ''));
	if ($okUser && $okPass) {
		session_regenerate_id(true);
		$_SESSION['migrate_user'] = MIGRATE_USER;
		$loginError = '';
	} else {
		sleep(1);
		$loginError = 'user หรือ password ไม่ถูกต้อง';
	}
	$action = '';
} elseif ($action === 'logout') {
	unset($_SESSION['migrate_user'], $_SESSION['migrate_last']);
	$action = '';
}

if (empty($_SESSION['migrate_user'])) {
	// ยังไม่ login: ไม่ส่งข้อมูลฐาน/รายการ migration และไม่รันคำสั่งใดๆ
	?>
<!doctype html>
<html lang="th">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Database Migrations</title>
<style>
	body { font-family: system-ui, "Segoe UI", sans-serif; margin: 0; background: #f4f5f7; color: #1c2430; }
	.overlay { position: fixed; inset: 0; background: rgba(28, 36, 48, .55); display: flex; align-items: center; justify-content: center; padding: 16px; }
	.modal { background: #fff; border-radius: 12px; padding: 24px; width: 100%; max-width: 340px; box-shadow: 0 10px 40px rgba(0, 0, 0, .25); }
	h1 { font-size: 20px; margin: 0 0 16px; }
	label { display: block; font-size: 13px; color: #5c6675; margin-bottom: 4px; }
	input { font: inherit; width: 100%; box-sizing: border-box; padding: 9px 10px; border: 1px solid #c4cad3; border-radius: 8px; margin-bottom: 12px; }
	button { font: inherit; width: 100%; padding: 9px 16px; border-radius: 8px; border: 1px solid #1f5fbf; background: #1f5fbf; color: #fff; cursor: pointer; }
	.err { background: #fde0e0; color: #a12020; padding: 8px 10px; border-radius: 8px; margin-bottom: 12px; font-size: 14px; }
</style>
</head>
<body>
<div class="overlay">
	<form class="modal" method="post" autocomplete="off">
		<h1>Database Migrations</h1>
		<?php if ($loginError !== '') : ?><div class="err"><?= $h($loginError) ?></div><?php endif; ?>
		<input type="hidden" name="action" value="login">
		<label for="user">User</label>
		<input type="text" id="user" name="user" autofocus required>
		<label for="pass">Password</label>
		<input type="password" id="pass" name="pass" required>
		<button type="submit">Login</button>
	</form>
</div>
</body>
</html>
	<?php
	exit;
}

$_SESSION['migrate_last'] = time();
$by = (string)$_SESSION['migrate_user'];
$messages = array();
$dryRun = array();

if ($action === 'up') {
	foreach (migrator_up($conn, $by) as $r) {
		$messages[] = array($r['ok'], ($r['ok'] ? 'รันสำเร็จ: ' : 'พัง: ') . $r['name'] . ($r['ok'] ? '' : ' — ' . $r['error']));
	}
	if (!$messages) {
		$messages[] = array(true, 'ไม่มี migration ที่รอรัน');
	}
} elseif ($action === 'down') {
	$last = migrator_last($conn);
	if (!$last || trim((string)($_POST['confirm_name'] ?? '')) !== $last['name']) {
		$messages[] = array(false, 'ชื่อที่พิมพ์ยืนยันไม่ตรงกับ migration ล่าสุด — ยังไม่ได้ถอยอะไร');
	} else {
		$r = migrator_down($conn, $by);
		$messages[] = array($r['ok'], ($r['ok'] ? 'ถอยสำเร็จ: ' : 'ถอยไม่สำเร็จ: ') . $r['name'] . ($r['ok'] ? '' : ' — ' . $r['error']));
	}
} elseif ($action === 'dry') {
	foreach (migrator_pending($conn) as $name) {
		$dryRun[$name] = migrator_split(migrator_read_sql($name, 'up'));
	}
}

$records = migrator_records($conn);
$pending = migrator_pending($conn);
$last = migrator_last($conn);
$dbRes = $conn->query('SELECT DATABASE() AS db');
$dbName = $dbRes ? $dbRes->fetch_assoc()['db'] : '?';
?>
<!doctype html>
<html lang="th">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Database Migrations</title>
<style>
	body { font-family: system-ui, "Segoe UI", sans-serif; margin: 0; padding: 24px 16px; background: #f4f5f7; color: #1c2430; }
	main { max-width: 860px; margin: 0 auto; }
	h1 { font-size: 22px; margin: 0 0 4px; }
	.sub { color: #5c6675; margin-bottom: 20px; }
	.card { background: #fff; border: 1px solid #dde1e7; border-radius: 10px; padding: 16px; margin-bottom: 16px; }
	table { width: 100%; border-collapse: collapse; font-size: 14px; }
	th, td { text-align: left; padding: 8px 10px; border-bottom: 1px solid #eceff3; vertical-align: top; }
	.badge { display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 12px; font-weight: 600; }
	.ok { background: #dff5e6; color: #14663a; }
	.pending { background: #fff1cf; color: #8a5a00; }
	.failed { background: #fde0e0; color: #a12020; }
	.msg { padding: 10px 12px; border-radius: 8px; margin-bottom: 8px; }
	.msg.ok { background: #dff5e6; } .msg.failed { background: #fde0e0; }
	button { font: inherit; padding: 8px 16px; border-radius: 8px; border: 1px solid #c4cad3; background: #fff; cursor: pointer; }
	button.primary { background: #1f5fbf; border-color: #1f5fbf; color: #fff; }
	button.danger { background: #c33; border-color: #c33; color: #fff; }
	input[type=text] { font: inherit; padding: 8px 10px; border: 1px solid #c4cad3; border-radius: 8px; min-width: 280px; max-width: 100%; }
	form { display: inline-block; margin: 0 8px 8px 0; }
	pre { background: #f4f5f7; padding: 10px; border-radius: 8px; overflow: auto; font-size: 12px; white-space: pre-wrap; }
	.warn { color: #a12020; font-weight: 600; }
	.error { color: #a12020; font-size: 13px; }
</style>
</head>
<body>
<main>
	<h1>Database Migrations</h1>
	<div class="sub">ฐานข้อมูล: <strong><?= $h($dbName) ?></strong> · ไฟล์: sql/migrations/ · login เป็น <?= $h($by) ?> — ตรวจชื่อฐานก่อนกดทุกครั้ง
		<form method="post" style="margin:0 0 0 8px"><input type="hidden" name="action" value="logout"><button type="submit">Logout</button></form>
	</div>

	<?php foreach ($messages as $m) : ?>
		<div class="msg <?= $m[0] ? 'ok' : 'failed' ?>"><?= $h($m[1]) ?></div>
	<?php endforeach; ?>

	<div class="card">
		<form method="post"><input type="hidden" name="action" value="dry"><button type="submit">Dry-run (ดู SQL ที่จะรัน)</button></form>
		<form method="post" onsubmit="return confirm('รัน migration ที่รออยู่ <?= count($pending) ?> ไฟล์ บนฐาน <?= $h($dbName) ?> ?');">
			<input type="hidden" name="action" value="up">
			<button type="submit" class="primary"<?= $pending ? '' : ' disabled' ?>>Run pending (<?= count($pending) ?>)</button>
		</form>
	</div>

	<?php foreach ($dryRun as $name => $stmts) : ?>
		<div class="card">
			<strong><?= $h($name) ?></strong> — <?= count($stmts) ?> คำสั่ง
			<?php if (migrator_data_warning($stmts)) : ?><div class="warn">⚠ มีคำสั่งแก้/ลบข้อมูล (UPDATE/DELETE/DROP) — ย้อนกลับด้วย down ไม่ได้ ควร backup ก่อน</div><?php endif; ?>
			<pre><?= $h(implode(";\n\n", $stmts) . ';') ?></pre>
		</div>
	<?php endforeach; ?>
	<?php if ($action === 'dry' && !$dryRun) : ?>
		<div class="card">ไม่มี migration ที่รอรัน</div>
	<?php endif; ?>

	<div class="card">
		<table>
			<tr><th>Migration</th><th>สถานะ</th><th>รันเมื่อ</th></tr>
			<?php foreach (migrator_files() as $name) : $rec = $records[$name] ?? null; $st = $rec ? $rec['status'] : 'pending'; ?>
				<tr>
					<td><?= $h($name) ?><?php if ($rec && $rec['error']) : ?><div class="error"><?= $h($rec['error']) ?></div><?php endif; ?></td>
					<td><span class="badge <?= $h($st) ?>"><?= $h($st) ?></span></td>
					<td><?= $rec ? $h($rec['ran_at'] . ' โดย ' . $rec['ran_by']) : '—' ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>

	<?php if ($last) : ?>
		<div class="card">
			<strong>Rollback</strong> — ถอยทีละ 1 ไฟล์ คือ <code><?= $h($last['name']) ?></code> (<?= $h($last['status']) ?>)<br>
			<small>คำสั่ง UPDATE/DELETE ที่รันไปแล้วย้อนกลับไม่ได้ ควร backup ก่อน</small><br><br>
			<form method="post" onsubmit="return confirm('ถอย <?= $h($last['name']) ?> บนฐาน <?= $h($dbName) ?> ?');">
				<input type="hidden" name="action" value="down">
				<input type="text" name="confirm_name" placeholder="พิมพ์ชื่อ migration เพื่อยืนยัน" autocomplete="off">
				<button type="submit" class="danger">Rollback</button>
			</form>
		</div>
	<?php endif; ?>
</main>
</body>
</html>
