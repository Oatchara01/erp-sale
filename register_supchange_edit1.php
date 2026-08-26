<?php
// Handler แก้ไขเอกสาร "ใบแลกเปลี่ยนสินค้า" (hos__change) — คู่กับ register_supchange1.php (INSERT)
// register_supchange_draft1.php hardcode ชื่อไฟล์นี้ไว้ใน include อยู่แล้ว — ดู plan
// "พอร์ต Submit flow เต็มรูปแบบ ... มาสู่ register_supchange.php"
//
// โครงสร้างมิเรอร์ register_supchange1.php เป็นหลัก ต่างกัน 3 จุดหลัก (เหมือน
// register_supbrcshos_edit1.php ต่างจาก register_supbrcshos1.php):
// (1) ref_id มาจาก POST ไม่ใช่ generate ใหม่ (2) hos__change เป็น UPDATE ไม่แตะ
// date_change/sale_date/sale/sale_code/add_date/add_by เพื่อรักษาประวัติผู้สร้างเดิม
// (send_sup*/status_doc ถูกปรับตามชนิดของคำขอในบล็อกก่อน UPDATE) (3) hos__subchange /
// tb_register_data ต้อง DELETE ก่อน INSERT (ตารางลูกอื่นเป็น DELETE+INSERT อยู่แล้วเหมือนกับ
// handler สร้างเอกสาร จึงก็อปมาแทบไม่ต้องแก้)
ob_start();
$isDraftRequest = isset($_POST["is_draft"]) && $_POST["is_draft"] === "1";
if (!$isDraftRequest) {
	include("head.php");
} else {
	header('Content-Type: application/json; charset=utf-8');
}
?>

<?php
include("dbconnect.php");
include("error_page.php");

date_default_timezone_set("Asia/Bangkok");
if (isset($_POST["submit"]) && $_POST["submit"] === "submit") {

	// ===== Helper อ่านค่า $_POST — เหมือน register_supchange1.php ทุกประการ =====
	// ไฟล์นี้ไม่เคย include คู่กับ register_supchange1.php ในคำขอเดียวกัน (router เลือก include แค่ไฟล์เดียว)
	// จึงประกาศซ้ำโดย guard function_exists() แทนการแยกไฟล์ helper กลาง
	if (!function_exists('cs_post_raw')) {
		function cs_post_raw($key, $default = '')
		{
			return trim((string)($_POST[$key] ?? $default));
		}
	}
	if (!function_exists('cs_post')) {
		function cs_post($conn, $key, $default = '')
		{
			return mysqli_real_escape_string($conn, cs_post_raw($key, $default));
		}
	}
	if (!function_exists('cs_post_date')) {
		function cs_post_date($conn, $key)
		{
			$value = cs_post_raw($key);
			return $value === '' ? '0000-00-00' : mysqli_real_escape_string($conn, $value);
		}
	}
	if (!function_exists('cs_post_amount')) {
		function cs_post_amount($conn, $key, $default = '0.00')
		{
			$value = str_replace(',', '', cs_post_raw($key));
			return $value === '' ? $default : mysqli_real_escape_string($conn, $value);
		}
	}
	if (!function_exists('cs_post_flag')) {
		function cs_post_flag($key)
		{
			return cs_post_raw($key) === '1' ? '1' : '0';
		}
	}
	if (!function_exists('cs_update_column_if_exists')) {
		function cs_update_column_if_exists($conn, $table, $refColumn, $refValue, $column, $value)
		{
			$safeTable = mysqli_real_escape_string($conn, $table);
			$safeColumn = mysqli_real_escape_string($conn, $column);
			$columnCheck = mysqli_query($conn, "SHOW COLUMNS FROM " . $safeTable . " LIKE '" . $safeColumn . "'");
			if (!$columnCheck || mysqli_num_rows($columnCheck) == 0) {
				return;
			}

			$safeRefColumn = mysqli_real_escape_string($conn, $refColumn);
			$safeValue = mysqli_real_escape_string($conn, $value);
			$safeRefValue = mysqli_real_escape_string($conn, $refValue);
			mysqli_query($conn, "UPDATE " . $safeTable . " SET " . $safeColumn . " = '" . $safeValue . "' WHERE " . $safeRefColumn . " = '" . $safeRefValue . "'");
		}
	}
	if (!function_exists('cs_column_exists')) {
		function cs_column_exists($conn, $table, $columnName)
		{
			static $columnCache = array();
			$cacheKey = $table . '.' . $columnName;
			if (array_key_exists($cacheKey, $columnCache)) {
				return $columnCache[$cacheKey];
			}

			$safeTable = mysqli_real_escape_string($conn, $table);
			$safeColumnName = mysqli_real_escape_string($conn, $columnName);
			$query = mysqli_query($conn, "SHOW COLUMNS FROM " . $safeTable . " LIKE '" . $safeColumnName . "'");
			$columnCache[$cacheKey] = ($query && mysqli_num_rows($query) > 0);
			return $columnCache[$cacheKey];
		}
	}
	if (!function_exists('chg_abort_with_alert')) {
		function chg_abort_with_alert($message, $isDraftRequest = false)
		{
			if (ob_get_level() > 0) {
				ob_end_clean();
			}
			if ($isDraftRequest) {
				echo json_encode(array('success' => false, 'message' => $message));
				exit();
			}
			$safeMessage = str_replace(array("\\", "'", "\r", "\n"), array("\\\\", "\\'", " ", " "), $message);
			echo "<script>alert('" . $safeMessage . "');history.back();</script>";
			exit();
		}
	}

	// partials/product_table_change.php เรนเดอร์ 6 แถวคงที่ (product_table_change.php:474-476)
	$chgProductRowCount = 6;

	// ===== ref_id ของเอกสารที่จะแก้ไข — ต้องมีอยู่จริงแล้ว (เป็น UPDATE ไม่ generate ใหม่) =====
	$ref_id = cs_post($conn, "ref_id");
	if ($ref_id === '') {
		chg_abort_with_alert('ไม่พบเลขที่อ้างอิงเอกสาร', $isDraftRequest);
	}
	$ref_id_escaped = $ref_id;

	$existingDocQuery = mysqli_query($conn, "SELECT ref_id FROM hos__change WHERE ref_id = '" . $ref_id . "' LIMIT 1");
	if (!$existingDocQuery || mysqli_num_rows($existingDocQuery) === 0) {
		chg_abort_with_alert('ไม่พบเอกสาร ' . $ref_id . ' ในระบบ', $isDraftRequest);
	}

	// Backend validation — ชุดเดียวกับ register_supchange1.php (ข้ามเมื่อเป็น Draft)
	if (!$isDraftRequest) {
		$chgRequiredFieldLabels = array(
			'start_time' => 'กรุณาใส่เวลาส่ง',
			'customer_name' => 'กรุณาใส่ชื่อลูกค้า',
			'customer_tel' => 'กรุณาใส่เบอร์โทรลูกค้า',
			'address_name' => 'กรุณาใส่ที่อยู่ในการส่งสินค้า',
			'address_send' => 'กรุณาใส่สถานที่ติดตั้งเครื่อง',
			'province_name' => 'กรุณาเลือกจังหวัดที่ต้องการจัดส่ง',
		);

		$chgValidationErrors = array();
		foreach ($chgRequiredFieldLabels as $chgRequiredField => $chgRequiredMessage) {
			if (trim((string)($_POST[$chgRequiredField] ?? '')) === '') {
				$chgValidationErrors[] = $chgRequiredMessage;
			}
		}

		$chgHasProductPost = false;
		for ($chgValidatePi = 1; $chgValidatePi <= $chgProductRowCount; $chgValidatePi++) {
			if (trim((string)($_POST['product_id' . $chgValidatePi] ?? '')) !== '') {
				$chgHasProductPost = true;
				break;
			}
		}
		if (!$chgHasProductPost) {
			$chgValidationErrors[] = 'กรุณาเลือกสินค้าอย่างน้อย 1 รายการ';
		}

		// การแลกเปลี่ยนสินค้า: จำนวนแลกเข้า/แลกออกต่างกันได้ แต่มูลค่ารวมสองฝั่งต้องเท่ากัน
		$chgValueIn = 0.0;
		$chgValueOut = 0.0;
		for ($chgValidatePi = 1; $chgValidatePi <= $chgProductRowCount; $chgValidatePi++) {
			$chgValidatePrice = (float) cs_post_raw("product_price" . $chgValidatePi);
			$chgValueIn += (float) cs_post_raw("count_stock" . $chgValidatePi) * $chgValidatePrice;
			$chgValueOut += (float) cs_post_raw("count_sale" . $chgValidatePi) * $chgValidatePrice;
		}
		if (abs($chgValueIn - $chgValueOut) > 0.01) {
			$chgValidationErrors[] = 'มูลค่าสินค้าแลกเข้า (' . number_format($chgValueIn, 2) . ') ต้องเท่ากับมูลค่าแลกออก (' . number_format($chgValueOut, 2) . ')';
		}

		if (!empty($chgValidationErrors)) {
			chg_abort_with_alert("กรุณากรอกข้อมูลให้ครบถ้วน\n\n" . implode("\n", $chgValidationErrors));
		}
	}

	$company = cs_post($conn, "company");
	$customer = cs_post($conn, "customer");
	$customer_id = cs_post($conn, "customer_id");
	$address = cs_post($conn, "address");
	$sale_comment = cs_post($conn, "sale_comment");
	$sn_ckk = cs_post($conn, "sn_ckk", "0");
	$sn = cs_post($conn, "sn");
	$objective = cs_post($conn, "objective");
	$objective_des = cs_post($conn, "objective_des");

	// ปุ่ม "ยกเลิกเอกสาร" มีลำดับเหนือ Draft — เหมือน register_supchange1.php
	$isCancelDoc = (cs_post_raw("cancel_doc") === "1");
	$status_doc = $isCancelDoc ? "ยกเลิก" : ($isDraftRequest ? "Draft" : "Request");

	$returns = cs_post($conn, "returns", "0");
	$returns_date = cs_post_date($conn, "returns_date");
	$returns_time = cs_post($conn, "returns_time");
	$returns_name = cs_post($conn, "returns_name");
	$returns_address = cs_post($conn, "returns_address");
	$returns_contact = cs_post($conn, "returns_contact");
	$return_date_bet = cs_post($conn, "return_date_bet");

	$delivery_name = cs_post($conn, "address_name");
	$delivery_type = cs_post($conn, "delivery_type");
	$delivery_date = cs_post_date($conn, "start_date");
	$start_time = cs_post($conn, "start_time");
	$end_time = cs_post($conn, "end_time");
	$delivery_time = "$start_time $end_time";
	$delivery_address = cs_post($conn, "address_send");
	$delivery_contact = cs_post($conn, "customer_name");
	$delivery_tel = cs_post($conn, "customer_tel");
	$date_send_key = cs_post($conn, "between_date");

	$iv_no = cs_post($conn, "admin_doc_no");
	// กันเลขซ้ำชุดเดียวกับ register_supchange1.php — ต่างกันตรงที่ต้องยกเว้นเอกสารตัวเอง
	// ไม่งั้นการกด Update ทุกครั้งจะฟ้องเลขซ้ำกับตัวเอง
	if ($iv_no !== '') {
		$chgDupQuery = mysqli_query($conn, "SELECT ref_id FROM hos__change WHERE iv_no = '" . $iv_no . "' AND ref_id <> '" . $ref_id . "' LIMIT 1");
		$chgDupRow = $chgDupQuery ? mysqli_fetch_assoc($chgDupQuery) : null;
		if ($chgDupRow) {
			$chgDupMessage = 'เลขที่เอกสาร ' . cs_post_raw("admin_doc_no") . ' ถูกใช้กับเอกสาร ' . $chgDupRow['ref_id']
				. ' แล้ว กรุณากดปุ่ม Run เอกสารใหม่อีกครั้ง';
			chg_abort_with_alert($chgDupMessage, $isDraftRequest);
		}
	}
	$iv_date = cs_post_date($conn, "admin_doc_date");
	$send_cs = cs_post_flag("send_cs");

	$date_ker = cs_post_date($conn, "shipping_date");
	$order_refer_code = cs_post($conn, "shipping_ref1");
	$order_refer_code1 = cs_post($conn, "shipping_ref2");
	$ker_bath = cs_post_amount($conn, "shipping_cost");

	$add_date = date('Y-m-d H:i:s');
	$name = $_SESSION['name'] ?? '';
	$surname = $_SESSION['surname'] ?? '';
	$add_by_session = mysqli_real_escape_string($conn, "$name $surname");
	$em_id = mysqli_real_escape_string($conn, (string)($_SESSION['emid'] ?? ''));

	// สถานะการส่งให้หัวหน้า — ตั้งเฉพาะตอน Submit/ยกเลิกเอกสารเท่านั้น ถ้าเซ็ตทุกครั้งเอกสาร Draft
	// จะถูกส่งให้หัวหน้าทันทีที่กด Save Draft — มิเรอร์ register_supbrcshos_edit1.php:340-354
	// (ไม่ตั้งค่าเมื่อ Save Draft/Update ธรรมดา — ปล่อยให้ $chgUpdateColumns ด้านล่างข้าม 3 คอลัมน์นี้ไปเลย)
	if (!($isDraftRequest && !$isCancelDoc)) {
		$send_sup_val = "1";
		$send_supname_val = $add_by_session;
		$send_supdate_val = $add_date;
	}

	// ===== ไฟล์แนบ (slip1-5) — edit mode: ไม่มีไฟล์ใหม่ = คงชื่อเดิม (ค่าจาก hidden input ที่ฟอร์มเติมไว้) =====
	// null = ไม่แตะคอลัมน์นี้เลยตอน UPDATE, ต่างจาก '' ที่หมายถึง "ลบไฟล์เดิมทิ้ง"
	$chgUploadDir = __DIR__ . '/upload';
	if (!is_dir($chgUploadDir)) {
		@mkdir($chgUploadDir, 0777, true);
	}

	$slip1 = $slip2 = $slip3 = $slip4 = $slip5 = null;
	for ($chgSlipIndex = 1; $chgSlipIndex <= 5; $chgSlipIndex++) {
		$chgSlipField = 'slip' . $chgSlipIndex;
		if (!empty($_FILES[$chgSlipField]['name']) && $_FILES[$chgSlipField]['size'] > 0) {
			if ($_FILES[$chgSlipField]['size'] > 1100000) {
				chg_abort_with_alert('กรุณาแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB', $isDraftRequest);
			}
			$chgSlipNameParts = explode(".", $_FILES[$chgSlipField]["name"]);
			$chgSlipFileName = $chgSlipField . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($chgSlipNameParts);
			if (move_uploaded_file($_FILES[$chgSlipField]["tmp_name"], $chgUploadDir . '/' . $chgSlipFileName)) {
				${$chgSlipField} = mysqli_real_escape_string($conn, $chgSlipFileName);
			}
		} elseif (isset($_POST[$chgSlipField])) {
			${$chgSlipField} = cs_post($conn, $chgSlipField);
		}
	}

	$saveOk = true;
	$saveFailures = array();
	mysqli_begin_transaction($conn);

	try {

		// ===== hos__change (UPDATE) =====
		// ไม่แตะ date_change/sale_date/sale/sale_code/add_date/add_by เพื่อรักษาประวัติผู้สร้างเดิมไว้
		// — เหมือนแนวทาง register_supbrcshos_edit1.php:301-304
		$chgUpdateColumns = array(
			'company' => $company,
			'customer' => $customer,
			'customer_id' => $customer_id,
			'address' => $address,
			'sale_comment' => $sale_comment,
			'sn_ckk' => $sn_ckk,
			'sn' => $sn,
			'objective' => $objective,
			'objective_des' => $objective_des,
			'status_doc' => $status_doc,
			'delivery_name' => $delivery_name,
			'delivery_type' => $delivery_type,
			'delivery_date' => $delivery_date,
			'delivery_time' => $delivery_time,
			'delivery_address' => $delivery_address,
			'delivery_contact' => $delivery_contact,
			'delivery_tel' => $delivery_tel,
			'date_send_key' => $date_send_key,
			'return_date_bet' => $return_date_bet,
			'returns' => $returns,
			'returns_date' => $returns_date,
			'returns_time' => $returns_time,
			'returns_name' => $returns_name,
			'returns_address' => $returns_address,
			'returns_contact' => $returns_contact,
			'iv_no' => $iv_no,
			'iv_date' => $iv_date,
			'send_cs' => $send_cs,
			'date_ker' => $date_ker,
			'order_refer_code' => $order_refer_code,
			'order_refer_code1' => $order_refer_code1,
			'ker_bath' => $ker_bath,
		);

		if ($isDraftRequest && !$isCancelDoc) {
			// Save Draft/Update ต้องไม่แตะสถานะเอกสารเลย ไม่งั้นเอกสารที่ส่งไปแล้ว (Request)
			// จะถูกดึงกลับเป็น Draft เพียงเพราะผู้ใช้กดปุ่ม Update
			unset($chgUpdateColumns['status_doc']);
		} else {
			$chgUpdateColumns['send_sup'] = $send_sup_val;
			$chgUpdateColumns['send_supname'] = $send_supname_val;
			$chgUpdateColumns['send_supdate'] = $send_supdate_val;
		}

		foreach (array('slip1' => $slip1, 'slip2' => $slip2, 'slip3' => $slip3, 'slip4' => $slip4, 'slip5' => $slip5) as $chgSlipCol => $chgSlipVal) {
			if ($chgSlipVal !== null) {
				$chgUpdateColumns[$chgSlipCol] = $chgSlipVal;
			}
		}

		// คอลัมน์เสริมจาก sql/supchange_optional_columns.sql — ข้ามเงียบ ๆ ถ้า DB ยังไม่ได้รัน ALTER
		$chgOptionalColumns = array(
			'que_ckk' => cs_post_flag('que_ckk'),
			'is_cancel' => $isCancelDoc ? '1' : '0',
			'remark_cancel' => cs_post($conn, 'admin_cancel_reason'),
		);
		foreach ($chgOptionalColumns as $chgOptionalName => $chgOptionalValue) {
			if (cs_column_exists($conn, 'hos__change', $chgOptionalName)) {
				$chgUpdateColumns[$chgOptionalName] = $chgOptionalValue;
			}
		}

		$chgUpdateParts = array();
		foreach ($chgUpdateColumns as $chgCol => $chgVal) {
			$chgUpdateParts[] = "`" . $chgCol . "` = '" . $chgVal . "'";
		}

		$save = "update hos__change set " . implode(", ", $chgUpdateParts) . " where ref_id = '" . $ref_id . "'";
		$qsave = mysqli_query($conn, $save);
		if (!$qsave) {
			$saveOk = false;
			$saveFailures[] = 'hos__change: ' . mysqli_error($conn);
		}

		cs_update_column_if_exists($conn, 'hos__change', 'ref_id', $ref_id, 'job_no', cs_post_raw('admin_work_no'));


		// ===== รายการสินค้า (hos__subchange) — DELETE ทั้งหมดแล้ว re-INSERT จากฟอร์ม =====
		$productNames = array();
		$productUnits = array();
		$productCounts = array();
		$productRemarks = array();

		mysqli_query($conn, "DELETE FROM hos__subchange WHERE ref_idd = '" . $ref_id_escaped . "'");

		for ($i = 1; $i <= $chgProductRowCount; $i++) {
			$product_id = cs_post($conn, "product_id" . $i);
			$count_stock = cs_post($conn, "count_stock" . $i);
			$count_sale = cs_post($conn, "count_sale" . $i);
			$product_price = cs_post($conn, "product_price" . $i);
			$sum_amount = cs_post_amount($conn, "sum_amount" . $i, '');
			$item_sn = cs_post($conn, "sn" . $i);
			$sale_remarkk = cs_post($conn, "sale_remarkk" . $i);

			$productNames[$i] = cs_post_raw("product_name" . $i);
			$productUnits[$i] = cs_post_raw("unit_name" . $i);
			$productCounts[$i] = cs_post_raw("count_sale" . $i);
			$productRemarks[$i] = cs_post_raw("sale_remarkk" . $i);

			if ($product_id === '') {
				continue;
			}

			$strSQLItem = "insert into hos__subchange
(ref_idd,product_id,product_code,count_stock,count_sale,price,amount,sn,sale_remark)
values ('" . $ref_id . "','" . $product_id . "','" . $product_id . "','" . $count_stock . "','" . $count_sale . "','" . $product_price . "','" . $sum_amount . "','" . $item_sn . "','" . $sale_remarkk . "')";

			mysqli_query($conn, $strSQLItem);
		}


		// ===== ส่งสินค้าด้วยใบรับสินค้า (tb_other_bill.ref_12) =====
		$ref_12 = cs_post_flag("no_money");
		mysqli_query($conn, "DELETE FROM tb_other_bill WHERE ref_id = '" . $ref_id_escaped . "'");
		mysqli_query($conn, "insert into tb_other_bill (ref_id,ref_12) values ('" . $ref_id . "','" . $ref_12 . "')");


		// ===== รายละเอียดที่อยู่ (tb_transaction) =====
		$chg_park_front = cs_post($conn, "park_front");
		$chg_car_home = ($chg_park_front === '1') ? '1' : '0';
		$chg_car_road = ($chg_park_front === '0') ? '1' : '0';
		$chg_car_park = cs_post($conn, "park_location");
		$chg_height_ltd = cs_post_flag("is_high_roof");

		$chg_entrance_type = cs_post($conn, "entrance_type");
		$chg_slope = ($chg_entrance_type === '1') ? '1' : '0';
		$chg_bundai = ($chg_entrance_type === '2') ? '1' : '0';
		$chg_unit_bundai = cs_post($conn, "stair_count");
		$chg_install = cs_post($conn, "install_floor");

		$chg_room_type = cs_post($conn, "room_type");
		$chg_room_bigger = cs_post($conn, "door_width");
		$chg_room_longer = cs_post($conn, "door_height");

		$chg_stair_width = cs_post_raw("stair_width");
		$chg_stair_height = cs_post_raw("stair_height");
		$chg_bundai_big = ($chg_stair_width !== '' || $chg_stair_height !== '') ? mysqli_real_escape_string($conn, $chg_stair_width . ' x ' . $chg_stair_height) : '';

		$chg_elev_door_width = cs_post_raw("elev_door_width");
		$chg_elev_door_height = cs_post_raw("elev_door_height");
		$chg_lip_big = ($chg_elev_door_width !== '' || $chg_elev_door_height !== '') ? mysqli_real_escape_string($conn, $chg_elev_door_width . ' x ' . $chg_elev_door_height) : '';

		$chg_elev_width = cs_post_raw("elev_width");
		$chg_elev_height = cs_post_raw("elev_height");
		$chg_elev_depth = cs_post_raw("elev_depth");
		$chg_lip_long = ($chg_elev_width !== '' || $chg_elev_height !== '' || $chg_elev_depth !== '') ? mysqli_real_escape_string($conn, $chg_elev_width . ' x ' . $chg_elev_height . ' x ' . $chg_elev_depth) : '';

		$chg_lip_weight = cs_post($conn, "elev_capacity");

		$chg_want_employee = cs_post_flag("move_furn");
		$chg_employee_unit = cs_post($conn, "move_furn_count");
		$chg_ferniger_name = cs_post($conn, "move_furn_detail");
		$chg_addr_note = cs_post($conn, "addr_note");

		mysqli_query($conn, "DELETE FROM tb_transaction WHERE ref_id = '" . $ref_id_escaped . "'");
		$strSQLTransaction = "insert into tb_transaction (ref_id,car_park,car_road,car_home,slope,bundai,unit_bundai,home_type,install,bundai_big,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,room_bigger,room_longer,description,height_ltd,add_date,add_by)
values('" . $ref_id . "','" . $chg_car_park . "','" . $chg_car_road . "','" . $chg_car_home . "','" . $chg_slope . "','" . $chg_bundai . "','" . $chg_unit_bundai . "','" . $chg_room_type . "','" . $chg_install . "','" . $chg_bundai_big . "','" . $chg_lip_big . "','" . $chg_lip_long . "','" . $chg_lip_weight . "','" . $chg_want_employee . "','" . $chg_employee_unit . "','" . $chg_ferniger_name . "','" . $chg_room_bigger . "','" . $chg_room_longer . "','" . $chg_addr_note . "','" . $chg_height_ltd . "','" . $add_date . "','" . $add_by_session . "')";
		mysqli_query($conn, $strSQLTransaction);

		cs_update_column_if_exists($conn, 'tb_transaction', 'ref_id', $ref_id, 'install_room', cs_post_raw('room_type'));


		// ===== ที่อยู่เพิ่มเติม (tb_shipping_address) — สูงสุด 9 แถว =====
		mysqli_query($conn, "DELETE FROM tb_shipping_address WHERE ref_id = '" . $ref_id_escaped . "'");

		for ($chgShippingIndex = 1; $chgShippingIndex <= 9; $chgShippingIndex++) {
			$chgShippingContactName = cs_post_raw('extra_contact_name_' . $chgShippingIndex);
			$chgShippingTelephone = cs_post_raw('extra_contact_tel_' . $chgShippingIndex);
			$chgShippingProvince = cs_post_raw('extra_contact_province_' . $chgShippingIndex);
			$chgShippingAddress = cs_post_raw('extra_shipping_address_' . $chgShippingIndex);

			if ($chgShippingContactName === '' && $chgShippingTelephone === '' && $chgShippingProvince === '' && $chgShippingAddress === '') {
				continue;
			}

			mysqli_query($conn, "INSERT INTO tb_shipping_address (ref_id, contact_name, telephone, province, address) VALUES ('" .
				$ref_id_escaped . "','" .
				mysqli_real_escape_string($conn, $chgShippingContactName) . "','" .
				mysqli_real_escape_string($conn, $chgShippingTelephone) . "','" .
				mysqli_real_escape_string($conn, $chgShippingProvince) . "','" .
				mysqli_real_escape_string($conn, $chgShippingAddress) . "')");
		}


		// ===== ที่อยู่ส่งบิล (tb_delivery_bill) =====
		$chgDeliveryBillContactName = cs_post_raw('bill_extra_contact_name_2');
		$chgDeliveryBillTelephone = cs_post_raw('bill_extra_contact_tel_2');
		$chgDeliveryBillProvince = cs_post_raw('bill_extra_contact_province_2');
		$chgDeliveryBillAddress = cs_post_raw('bill_extra_shipping_address_2');

		mysqli_query($conn, "DELETE FROM tb_delivery_bill WHERE ref_id = '" . $ref_id_escaped . "'");

		if ($chgDeliveryBillContactName !== '' || $chgDeliveryBillTelephone !== '' || $chgDeliveryBillProvince !== '' || $chgDeliveryBillAddress !== '') {
			mysqli_query($conn, "INSERT INTO tb_delivery_bill (ref_id, customer_nameb, customer_telb, province, address_nameb) VALUES ('" .
				$ref_id_escaped . "','" .
				mysqli_real_escape_string($conn, $chgDeliveryBillContactName) . "','" .
				mysqli_real_escape_string($conn, $chgDeliveryBillTelephone) . "','" .
				mysqli_real_escape_string($conn, $chgDeliveryBillProvince) . "','" .
				mysqli_real_escape_string($conn, $chgDeliveryBillAddress) . "')");
		}


		// ===== ข้อมูลการจัดส่ง (tb_register_data) =====
		$start_date = cs_post_date($conn, "start_date");
		$between_date = cs_post($conn, "between_date");
		$status = cs_post($conn, "status");

		$fix_date = cs_post_raw('fix_datetime') !== '' ? cs_post($conn, 'fix_datetime') : '0';
		$no_price = cs_post_raw('no_money') !== '' ? cs_post($conn, 'no_money') : '0';
		$call_customer = cs_post_raw('call_customer') !== '' ? cs_post($conn, 'call_customer') : '0';
		$credit = cs_post_raw('credit_card') !== '' ? cs_post($conn, 'credit_card') : '0';
		$call_employee = cs_post_raw('call_back') !== '' ? cs_post($conn, 'call_back') : '0';
		$chash = cs_post_raw('cash') !== '' ? cs_post($conn, 'cash') : '0';
		$check_peper = cs_post_raw('check_paper') !== '' ? cs_post($conn, 'check_paper') : '0';
		$bill = cs_post_raw('bill') !== '' ? cs_post($conn, 'bill') : '0';
		$want_bus = cs_post_raw('want_bus') !== '' ? cs_post($conn, 'want_bus') : '0';
		$tran = cs_post_raw('tran') !== '' ? cs_post($conn, 'tran') : '0';
		$check_detail = cs_post_raw('more') !== '' ? cs_post($conn, 'more') : '0';
		$dep = cs_post_raw('dep') !== '' ? cs_post($conn, 'dep') : '0';

		$department = cs_post($conn, "department_name");
		$type_customer = cs_post($conn, "customer_typename");

		if ($company == '1') {
			$type_company = 'ออลล์เวล ไลฟ์ บจก.';
		} else if ($company == '2') {
			$type_company = 'โนเบิล เมด บจก.';
		} else {
			$type_company = '';
		}

		$customer_name = cs_post($conn, "customer_name");
		$customer_tel = cs_post($conn, "customer_tel");
		$address_name = cs_post($conn, "address_name");
		$address_send = cs_post($conn, "address_send");
		$customer_contact = cs_post($conn, "customer_contact");
		$on_time = cs_post($conn, "on_time");
		$province_name = cs_post($conn, "province_name");
		$transport_company = cs_post($conn, "transport_company");
		$location_link = cs_post($conn, "location_link");

		$productSummaryParts = array('ส่ง');
		for ($i = 1; $i <= $chgProductRowCount; $i++) {
			$productSummaryParts[] = $productNames[$i] . ' ' . $productRemarks[$i] . ' ' . $productCounts[$i] . ' ' . $productUnits[$i];
		}
		$productSummaryParts[] = cs_post_raw("address_name");
		$product_name = mysqli_real_escape_string($conn, trim(preg_replace('/\s+/u', ' ', implode(' ', $productSummaryParts))));

		$product_sn = cs_post($conn, "product_sn");
		$unit_credit = cs_post($conn, "unit_credit");
		$price = cs_post($conn, "unit_cash");
		$employee_name = cs_post($conn, "employee_name");
		$employee_tel = cs_post($conn, "employee_tel");
		$add_by = cs_post($conn, "add_by");
		$description = cs_post($conn, "sale_comment");
		$havemap = cs_post($conn, 'have_map');
		$unit_check = cs_post($conn, "unit_check");
		$unit_bill = cs_post($conn, "unit_bill");
		$unit_tran = cs_post($conn, "unit_tran");
		$department_show = cs_post($conn, "department_show");
		$dept = cs_post($conn, "dept");
		$status_comment = cs_post($conn, "status_comment");
		$address_1 = cs_post_raw("address_1") !== '' ? cs_post($conn, "address_1") : $address_name;

		// ===== tb_register_data — ต่างจาก create handler: ต้อง DELETE ก่อนเพราะเป็นแถวเดิมที่มีอยู่แล้ว =====
		mysqli_query($conn, "DELETE FROM tb_register_data WHERE ref_id = '" . $ref_id_escaped . "'");

		$strSQL66 = "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code,province_name,transport_company,location_link)
values('" . $ref_id . "','" . $start_date . "','" . $between_date . "','" . $start_time . "','" . $end_time . "','" . $status . "','" . $fix_date . "','" . $no_price . "','" . $call_customer . "','" . $credit . "','" . $call_employee . "','" . $chash . "','" . $check_peper . "','" . $bill . "','" . $department . "','" . $type_customer . "','" . $type_company . "','" . $customer_name . "','" . $customer_tel . "','" . $address_name . "','" . $address_send . "','" . $want_bus . "','" . $product_name . "','" . $product_sn . "','" . $unit_credit . "','" . $price . "','" . $employee_name . "','" . $employee_tel . "','" . $add_by . "','" . $description . "','" . $havemap . "','" . $add_date . "','" . $unit_bill . "','" . $unit_check . "','" . $unit_tran . "','" . $tran . "','" . $check_detail . "','" . $dep . "','" . $dept . "','" . $department_show . "','" . $customer_contact . "','" . $status_comment . "','" . $on_time . "','" . $address_1 . "','" . $em_id . "','" . $province_name . "','" . $transport_company . "','" . $location_link . "')";

		$objQuery66 = mysqli_query($conn, $strSQL66);
		if (!$objQuery66) {
			$saveOk = false;
			$saveFailures[] = 'tb_register_data: ' . mysqli_error($conn);
		}
	} catch (mysqli_sql_exception $e) {
		$saveOk = false;
		$saveFailures[] = $e->getMessage();
	}


	if ($saveOk) {
		mysqli_commit($conn);

		// ===== ปุ่มอนุมัติ/ส่งกลับ/ไม่อนุมัติ บนแถบล่างของ register_supchange.php =====
		// ทำงานหลังบันทึกฟอร์มปกติเสร็จแล้ว (การบันทึกด้านบนเพิ่งตั้ง status_doc='Request' ไป
		// บล็อกนี้จึงเขียนทับเป็นสถานะสุดท้าย) — ชั้นเดียว (ไม่มี CM/ผู้ตรวจแบบ BR)
		// คอลัมน์ตรงกับ change_approve.php/change_rejected.php (หน้าอนุมัติเดิม) ทุกประการ
		$chgApproveAction = $_POST['approve_action'] ?? '';
		if ($chgApproveAction !== '') {
			$chgApproveName = mysqli_real_escape_string($conn, trim(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? '')));
			$chgApproveCode = mysqli_real_escape_string($conn, (string)($_SESSION['code'] ?? ''));
			$chgApproveDate = date('Y-m-d');
			$chgApproveTime = date('H:i:s');
			$chgSafeRefId = mysqli_real_escape_string($conn, $ref_id);

			if ($chgApproveAction === 'return') {
				// ส่งกลับให้ Sale แก้ไข — send_sup='0' ทำให้ปุ่ม Submit บนฟอร์มกลับมาใช้ได้อีกครั้ง
				mysqli_query($conn, "UPDATE hos__change SET status_doc='ส่งกลับ', send_sup='0' WHERE ref_id='" . $chgSafeRefId . "'");
			} elseif ($chgApproveAction === 'reject') {
				mysqli_query($conn, "UPDATE hos__change SET status_doc='Rejected', approve='" . $chgApproveName . "', approve_code='" . $chgApproveCode . "', approve_date='" . $chgApproveDate . "' WHERE ref_id='" . $chgSafeRefId . "'");
			} elseif ($chgApproveAction === 'approve') {
				mysqli_query($conn, "UPDATE hos__change SET status_doc='Approve', approve='" . $chgApproveName . "', approve_code='" . $chgApproveCode . "', approve_date='" . $chgApproveDate . "', approve_time='" . $chgApproveTime . "', send_admin='1' WHERE ref_id='" . $chgSafeRefId . "'");
			}
		}

		if ($isDraftRequest) {
			if (ob_get_level() > 0) {
				ob_end_clean();
			}
			echo json_encode(array(
				'success' => true,
				'ref_id' => $ref_id,
				'message' => 'บันทึกร่างเรียบร้อยแล้ว'
			));
			exit();
		}

		// true PRG: กลับไปหน้าเดิม (register_supchange.php) ในโหมดแสดงเอกสารที่เพิ่งบันทึก
		if (ob_get_level() > 0) {
			ob_end_clean();
		}
		header('Location: register_supchange.php?ref_id=' . rawurlencode($ref_id) . '&saved=1');
		exit();
	} else {
		mysqli_rollback($conn);

		$failureRefId = isset($ref_id) ? $ref_id : '-';
		if ($isDraftRequest) {
			if (ob_get_level() > 0) {
				ob_end_clean();
			}
			echo json_encode(array(
				'success' => false,
				'message' => 'Unable to save draft (เอกสาร ' . $failureRefId . '): ' . implode(' / ', $saveFailures)
			));
			exit();
		}
		chg_abort_with_alert("บันทึกข้อมูลไม่สำเร็จ (เอกสาร $failureRefId)\n\n" . implode("\n", $saveFailures));
	}
}
