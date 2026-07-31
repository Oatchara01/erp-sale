<?php
// Shared helper functions for rendering saved form values (used by
// register_suphos.php, register_supbook.php, and their partials).

if (!function_exists('so_saved_h')) {
	function so_saved_h($value)
	{
		return htmlspecialchars((string)($value ?? ""), ENT_QUOTES, "UTF-8");
	}
}

if (!function_exists('so_saved_buddhist_date_input')) {
	function so_saved_buddhist_date_input($value)
	{
		$value = trim((string)($value ?? ""));
		if ($value === "") {
			return "";
		}

		if (preg_match('/^(\d{4})-(\d{2})-(\d{2})(?:\s.*)?$/', $value, $matches)) {
			return sprintf('%02d/%02d/%04d', (int)$matches[3], (int)$matches[2], (int)$matches[1] + 543);
		}

		if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $value, $matches)) {
			$year = (int)$matches[3];
			if ($year < 2400) {
				$year += 543;
			}
			return sprintf('%02d/%02d/%04d', (int)$matches[1], (int)$matches[2], $year);
		}

		return $value;
	}
}

if (!function_exists('so_saved_iso_date_input')) {
	function so_saved_iso_date_input($value)
	{
		$value = trim((string)($value ?? ""));
		if ($value === "" || $value === "0000-00-00" || $value === "0000-00-00 00:00:00") {
			return "";
		}

		if (preg_match('/^(\d{4})-(\d{2})-(\d{2})(?:\s.*)?$/', $value, $matches)) {
			$year = (int)$matches[1];
			if ($year > 2400) {
				$year -= 543;
			}
			return sprintf('%04d-%02d-%02d', $year, (int)$matches[2], (int)$matches[3]);
		}

		if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $value, $matches)) {
			$year = (int)$matches[3];
			if ($year > 2400) {
				$year -= 543;
			}
			return sprintf('%04d-%02d-%02d', $year, (int)$matches[2], (int)$matches[1]);
		}

		return $value;
	}
}

