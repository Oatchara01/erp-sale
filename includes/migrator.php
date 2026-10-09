<?php

/**
 * ตัวรัน migration ของฐานขาย — ใช้โดย migrate.php (CLI และหน้าเว็บ)
 *
 * ไฟล์อยู่ที่ sql/migrations/YYYYMMDDHHMM_ชื่อ.up.sql คู่กับ .down.sql
 * สถานะเก็บในตาราง schema_migrations (สร้างเองเมื่อรันครั้งแรก)
 *
 * MySQL ทำ DDL แบบ transaction ไม่ได้ จึงไม่มี rollback อัตโนมัติ: ถ้า statement ไหนพัง runner หยุด
 * บันทึกแถวเป็น failed แล้วรัน up ซ้ำได้ (ไฟล์ up ต้องเช็ค information_schema ก่อนแก้ตาราง)
 * ไฟล์เก่าใน sql/*.sql ไม่เกี่ยวกับตัวนี้ — ยังรันมือผ่าน phpMyAdmin ตามเดิม
 */

if (!defined('MIGRATIONS_DIR')) {
	define('MIGRATIONS_DIR', dirname(__DIR__) . '/sql/migrations');
}

if (!function_exists('migrator_ensure_table')) {
	function migrator_ensure_table(mysqli $conn)
	{
		$conn->query("CREATE TABLE IF NOT EXISTS schema_migrations (
			name VARCHAR(190) NOT NULL,
			status VARCHAR(10) NOT NULL DEFAULT 'ok',
			error TEXT NULL,
			ran_by VARCHAR(100) NOT NULL DEFAULT '',
			ran_at DATETIME NOT NULL,
			PRIMARY KEY (name)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
	}
}

/** รายชื่อ migration ทั้งหมดที่มีไฟล์ .up.sql เรียงตามชื่อ (ชื่อ = ไม่รวม .up.sql) */
if (!function_exists('migrator_files')) {
	function migrator_files()
	{
		$names = array();
		foreach (glob(MIGRATIONS_DIR . '/*.up.sql') ?: array() as $path) {
			$names[] = basename($path, '.up.sql');
		}
		sort($names, SORT_STRING);
		return $names;
	}
}

/** สถานะที่บันทึกไว้ ชื่อ => แถว */
if (!function_exists('migrator_records')) {
	function migrator_records(mysqli $conn)
	{
		migrator_ensure_table($conn);
		$rows = array();
		$res = $conn->query("SELECT name, status, error, ran_by, ran_at FROM schema_migrations ORDER BY name");
		while ($res && ($row = $res->fetch_assoc())) {
			$rows[$row['name']] = $row;
		}
		return $rows;
	}
}

/** ที่ยังไม่รัน หรือรันแล้วพัง (failed) เรียงตามชื่อ */
if (!function_exists('migrator_pending')) {
	function migrator_pending(mysqli $conn)
	{
		$records = migrator_records($conn);
		$pending = array();
		foreach (migrator_files() as $name) {
			if (!isset($records[$name]) || $records[$name]['status'] !== 'ok') {
				$pending[] = $name;
			}
		}
		return $pending;
	}
}

/** แถวล่าสุดที่เคยบันทึก (ok หรือ failed) = ตัวที่ Rollback จะถอย */
if (!function_exists('migrator_last')) {
	function migrator_last(mysqli $conn)
	{
		migrator_ensure_table($conn);
		$res = $conn->query("SELECT name, status FROM schema_migrations ORDER BY name DESC LIMIT 1");
		return $res ? $res->fetch_assoc() : null;
	}
}

if (!function_exists('migrator_read_sql')) {
	function migrator_read_sql($name, $direction)
	{
		$path = MIGRATIONS_DIR . '/' . $name . '.' . $direction . '.sql';
		if (!is_file($path)) {
			return null;
		}
		$sql = file_get_contents($path);
		if (substr($sql, 0, 3) === "\xEF\xBB\xBF") {
			$sql = substr($sql, 3);
		}
		return $sql;
	}
}

/**
 * แยก SQL เป็นทีละคำสั่งด้วย ; ที่อยู่นอกเครื่องหมายคำพูดและคอมเมนต์
 * (คอมเมนต์ขึ้นต้น -- หรือ # และคอมเมนต์แบบบล็อก) ไม่รองรับ DELIMITER — ห้ามใช้ stored program ใน migration
 */
if (!function_exists('migrator_split')) {
	function migrator_split($sql)
	{
		$statements = array();
		$buf = '';
		$len = strlen($sql);
		$quote = '';
		for ($i = 0; $i < $len; $i++) {
			$c = $sql[$i];
			$n = $i + 1 < $len ? $sql[$i + 1] : '';
			if ($quote !== '') {
				$buf .= $c;
				if ($c === '\\' && $quote !== '`') {
					$buf .= $n;
					$i++;
				} elseif ($c === $quote) {
					if ($n === $quote) {
						$buf .= $n;
						$i++;
					} else {
						$quote = '';
					}
				}
				continue;
			}
			if ($c === "'" || $c === '"' || $c === '`') {
				$quote = $c;
				$buf .= $c;
			} elseif (($c === '-' && $n === '-' && ($i + 2 >= $len || ctype_space($sql[$i + 2]))) || $c === '#') {
				while ($i < $len && $sql[$i] !== "\n") {
					$i++;
				}
				$buf .= "\n";
			} elseif ($c === '/' && $n === '*') {
				$end = strpos($sql, '*/', $i + 2);
				$i = $end === false ? $len : $end + 1;
				$buf .= ' ';
			} elseif ($c === ';') {
				if (trim($buf) !== '') {
					$statements[] = trim($buf);
				}
				$buf = '';
			} else {
				$buf .= $c;
			}
		}
		if (trim($buf) !== '') {
			$statements[] = trim($buf);
		}
		return $statements;
	}
}

/** คำเตือนสำหรับ Dry-run: คำสั่งที่แก้/ลบข้อมูล ย้อนกลับด้วย down ไม่ได้ */
if (!function_exists('migrator_data_warning')) {
	function migrator_data_warning(array $statements)
	{
		foreach ($statements as $stmt) {
			if (preg_match('/^\s*(UPDATE|DELETE|TRUNCATE|DROP)\b/i', $stmt)) {
				return true;
			}
		}
		return false;
	}
}

/** รันทีละคำสั่ง คืน array(ok, error, ran) — หยุดที่คำสั่งแรกที่พัง */
if (!function_exists('migrator_execute')) {
	function migrator_execute(mysqli $conn, array $statements)
	{
		$ran = 0;
		foreach ($statements as $stmt) {
			try {
				$conn->query($stmt);
			} catch (mysqli_sql_exception $e) {
				return array(false, 'คำสั่งที่ ' . ($ran + 1) . ': ' . $e->getMessage(), $ran);
			}
			if ($conn->errno) {
				return array(false, 'คำสั่งที่ ' . ($ran + 1) . ': ' . $conn->error, $ran);
			}
			$ran++;
		}
		return array(true, '', $ran);
	}
}

if (!function_exists('migrator_record')) {
	function migrator_record(mysqli $conn, $name, $status, $error, $by)
	{
		$stmt = $conn->prepare("REPLACE INTO schema_migrations (name, status, error, ran_by, ran_at) VALUES (?, ?, ?, ?, NOW())");
		$stmt->bind_param('ssss', $name, $status, $error, $by);
		$stmt->execute();
	}
}

/** รัน up ของไฟล์ที่ pending ทั้งหมดตามลำดับ หยุดที่ไฟล์แรกที่พัง คืนรายการผล */
if (!function_exists('migrator_up')) {
	function migrator_up(mysqli $conn, $by)
	{
		$results = array();
		foreach (migrator_pending($conn) as $name) {
			$sql = migrator_read_sql($name, 'up');
			list($ok, $error) = migrator_execute($conn, migrator_split($sql));
			migrator_record($conn, $name, $ok ? 'ok' : 'failed', $ok ? null : $error, $by);
			$results[] = array('name' => $name, 'ok' => $ok, 'error' => $error);
			if (!$ok) {
				break;
			}
		}
		return $results;
	}
}

/** ถอย migration ล่าสุด 1 ไฟล์ (รัน down แล้วลบแถวสถานะ) */
if (!function_exists('migrator_down')) {
	function migrator_down(mysqli $conn, $by)
	{
		$last = migrator_last($conn);
		if (!$last) {
			return array('name' => '', 'ok' => false, 'error' => 'ไม่มี migration ให้ถอย');
		}
		$name = $last['name'];
		$sql = migrator_read_sql($name, 'down');
		if ($sql === null) {
			return array('name' => $name, 'ok' => false, 'error' => 'ไม่พบไฟล์ ' . $name . '.down.sql');
		}
		list($ok, $error) = migrator_execute($conn, migrator_split($sql));
		if ($ok) {
			$stmt = $conn->prepare("DELETE FROM schema_migrations WHERE name = ?");
			$stmt->bind_param('s', $name);
			$stmt->execute();
		} else {
			migrator_record($conn, $name, 'failed', 'rollback: ' . $error, $by);
		}
		return array('name' => $name, 'ok' => $ok, 'error' => $error);
	}
}
