<?php
// เรนเดอร์หน้า PHP เป็นไฟล์ HTML โดยไม่ต้องล็อกอินผ่านเบราว์เซอร์ (session จำลอง, GET เท่านั้น, ไม่เขียน DB)
// ใช้: php render-page.php register_supbook.php [type_login] [query-string]
//   type_login ค่าเริ่มต้น admin (บางหน้า เช่น register_poawl.php ปฏิเสธ Sale)
//   ผลลัพธ์: tools/responsive-check/out/pg_<ชื่อหน้า>.html (ใส่ <base> ชี้ไปที่ BASE_URL ให้ CSS/JS โหลดได้)
// ระวัง: DB local กับ production ชื่อเดียวกัน (allwell_sol_test) ตรวจ dbconnect ก่อนรันกับหน้าที่ยิง query หนัก

$page = $argv[1] ?? '';
$role = $argv[2] ?? 'admin';
$query = $argv[3] ?? '';
if ($page === '' || !preg_match('/^[A-Za-z0-9_\/]+\.php$/', $page)) {
	fwrite(STDERR, "usage: php render-page.php <page.php> [type_login] [query-string]\n");
	exit(2);
}

$root = dirname(__DIR__, 2);
$base = getenv('BASE_URL') ?: 'http://localhost/erpsale/';
chdir($root);
session_start();
$_SESSION['UserID'] = '1';
$_SESSION['type_login'] = $role;
$_SESSION['code'] = 'T01';
$_SESSION['name'] = 'Test';
$_SESSION['surname'] = 'User';
parse_str($query, $_GET);
$_SERVER['SCRIPT_NAME'] = '/erpsale/' . $page;
$_SERVER['REQUEST_METHOD'] = 'GET';

ob_start();
@include $page;
$html = ob_get_clean();
$html = preg_replace('/<head([^>]*)>/i', '<head$1><base href="' . $base . '">', $html, 1);

$outDir = __DIR__ . '/out';
if (!is_dir($outDir)) {
	mkdir($outDir, 0777, true);
}
$file = $outDir . '/pg_' . str_replace('/', '_', basename($page, '.php')) . '.html';
file_put_contents($file, $html);
echo $page, ' ', strlen($html), " bytes -> ", $file, "\n";
