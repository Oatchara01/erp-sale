<?php
// อ่านค่าเชื่อมต่อฐานข้อมูลจาก .env ที่ root — ใช้ร่วมกันโดย dbconnect*.php

if (!function_exists('env_load')) {
	/**
	 * @return array|false false เมื่อไม่มีไฟล์ .env หรืออ่านไม่ได้
	 */
	function env_load()
	{
		static $env = null;
		if ($env === null) {
			$file = dirname(__DIR__) . '/.env';
			$env = is_file($file) ? parse_ini_file($file, false, INI_SCANNER_RAW) : false;
		}
		return $env;
	}
}

if (!function_exists('env_db_connect')) {
	/**
	 * ต่อฐานข้อมูลตามค่า {$prefix}_NAME — HOST/USER/PASS ใช้ {$prefix}_* ถ้าตั้งไว้
	 * ไม่งั้นใช้ DB_HOST/DB_USER/DB_PASS ร่วมกัน
	 * $required = false สำหรับไฟล์ที่ห้าม echo (คืน false เงียบ ๆ แทนการ die)
	 *
	 * @return mysqli|false
	 */
	function env_db_connect($prefix, $required = true)
	{
		$env = env_load();
		$nameKey = $prefix . '_NAME';
		if ($env === false || !isset($env[$nameKey]) || $env[$nameKey] === '') {
			if ($required) {
				die($env === false
					? "ไม่พบไฟล์ .env (คัดลอกจาก .env.example แล้วใส่ค่าการเชื่อมต่อฐานข้อมูล)"
					: "ไม่พบค่า " . $nameKey . " ในไฟล์ .env");
			}
			return false;
		}
		$cfg = array();
		foreach (array('HOST', 'USER', 'PASS') as $part) {
			$own = $prefix . '_' . $part;
			$shared = 'DB_' . $part;
			$cfg[$part] = array_key_exists($own, $env) ? $env[$own] : (isset($env[$shared]) ? $env[$shared] : '');
		}
		return mysqli_connect($cfg['HOST'], $cfg['USER'], $cfg['PASS'], $env[$nameKey]);
	}
}
