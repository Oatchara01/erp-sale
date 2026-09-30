<?php

/**
 * ตัวเลือก/ข้อความของฟิลด์ในใบลดหนี้ (tb_credit_note)
 *
 * return_des = สภาพสินค้าที่ได้รับคืน เก็บเป็นรหัส '1' / '2'
 * (เอกสารเก่าที่เป็นข้อความอิสระ → แปลงแล้วได้ค่าว่าง)
 */

if (!function_exists('credit_return_condition_options')) {
	function credit_return_condition_options()
	{
		return array(
			'1' => 'ลูกค้าปฏิเสธการรับสินค้า',
			'2' => 'ลูกค้าคืนสินค้า',
		);
	}
}

if (!function_exists('credit_return_condition_label')) {
	function credit_return_condition_label($code)
	{
		$opts = credit_return_condition_options();
		$code = trim((string)$code);
		return isset($opts[$code]) ? $opts[$code] : '';
	}
}
