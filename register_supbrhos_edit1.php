<?php
// UPDATE handler ของฟอร์ม BR — mirror ของ register_supbrhos1.php (create)
// ต่างกันเฉพาะ: ใช้ ref_id_br ที่ post มาแทนการออกเลขใหม่, hos__br เป็น UPDATE,
// และตารางลูกใช้ DELETE ก่อน INSERT เพื่อแทนที่ข้อมูลชุดเดิมของเอกสารนั้น
// logic รายการสินค้า/BOM ยกมาจากไฟล์ create ทั้งหมดเพื่อให้พฤติกรรมตรงกัน

// เปิด output buffering ตั้งแต่ก่อน include head.php (ซึ่งส่ง HTML ออกทันที)
// เพื่อให้เรียก header('Location: ...') ได้จริงตอนบันทึกสำเร็จ (true POST-Redirect-GET)
// กัน "Confirm Form Resubmission" เมื่อผู้ใช้กด reload ค้างอยู่ที่หน้า response ของ POST
ob_start();
// Draft (เรียกผ่าน register_supbrhos_draft1.php เมื่อเอกสารเดิมเป็น Draft) เป็น AJAX ที่รอ JSON กลับ
// จึงข้าม head.php (ซึ่งพ่วง session_start() มาแล้วจาก router) และตอบ Content-Type เป็น json แทน
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
include(__DIR__ . "/includes/br_product_checklist.php");

if (!function_exists('tableExists')) {
	function tableExists($conn, $tableName)
	{
		static $tables = null;
		if ($tables === null) {
			$tables = array();
			$res = mysqli_query($conn, "SHOW TABLES");
			if ($res) {
				while ($row = mysqli_fetch_array($res)) {
					$tables[strtolower($row[0])] = true;
				}
			}
		}
		return isset($tables[strtolower($tableName)]);
	}
}

date_default_timezone_set("Asia/Bangkok");
// เดิมเขียน $_POST["submit"] = "submit" (assignment) ทำให้เงื่อนไขเป็นจริงเสมอ
// เปิดไฟล์นี้ตรง ๆ ก็รันโค้ดบันทึกได้ จึงเปลี่ยนเป็นการเปรียบเทียบจริง
if (isset($_POST["submit"]) && $_POST["submit"] === "submit") {

	// PHP 8.1+ ตั้ง mysqli.report_mode = ERROR|STRICT เป็นค่า default ทำให้ query ที่ล้มเหลว "โยน exception"
	// ไม่ใช่คืน false ดังนั้น or die() และ if (!$result) ที่มีอยู่เดิมทั้งไฟล์จึงไม่เคยทำงาน
	// ผลคือ query พังแล้วได้หน้า fatal error เปล่า ๆ แทนข้อความที่ผู้ใช้เข้าใจได้
	// ครอบ try/catch ไว้เพื่อดักทุก query ในไฟล์ (รวมจุดที่ไม่ได้ตรวจผลอีก ~84 จุด) แล้วรายงานสาเหตุจริงตอนท้าย
	$saveOk = true;
	$saveFailures = array();

	// Backend validation กันกรณีปิด JS หรือยิง POST ตรงเข้ามาโดยไม่ผ่านฟอร์ม (เดิมพึ่ง JS validation ใน fncSubmit() ฝั่งเดียว)
	// mirror รายการฟิลด์บังคับเดียวกับ fncSubmit() ใน register_supbrhos.php
	// ข้ามการตรวจนี้เมื่อเป็น Draft เพราะ "Save Draft" ตั้งใจให้บันทึกข้อมูลไม่ครบได้ (brSaveDraft() ไม่เรียก fncSubmit())
	if (!$isDraftRequest) {
		$brRequiredFieldLabels = array(
			'start_time' => 'กรุณาใส่เวลาส่ง',
			'customer_name' => 'กรุณาใส่ชื่อลูกค้า',
			'customer_tel' => 'กรุณาใส่เบอร์โทรลูกค้า',
			'address_name' => 'กรุณาใส่ที่อยู่ในการส่งสินค้า',
			'address_send' => 'กรุณาใส่สถานที่ติดตั้งเครื่อง',
			'returns_date' => 'กรุณาใส่วันที่รับคืนสินค้า',
			'returns_time' => 'กรุณาใส่เวลารับคืนสินค้า',
			'returns_name' => 'กรุณาใส่ชื่อผู้ติดต่อในการรับคืนสินค้า',
			'returns_contact' => 'กรุณาใส่เบอร์โทรศัพท์ติดต่อในการรับคืนสินค้า',
			'returns_address' => 'กรุณาใส่รายละเอียดสถานที่รับคืนสินค้า',
			// 'province_name' => 'กรุณาเลือกจังหวัดที่ต้องการจัดส่ง',
		);

		$brValidationErrors = array();
		foreach ($brRequiredFieldLabels as $brRequiredField => $brRequiredMessage) {
			if (trim((string)($_POST[$brRequiredField] ?? '')) === '') {
				$brValidationErrors[] = $brRequiredMessage;
			}
		}

		if (!empty($brValidationErrors)) {
			if (ob_get_level() > 0) {
				ob_end_clean();
			}
			$brValidationText = implode("\\n", array_map(function ($msg) {
				return str_replace(array("\\", "'", "\r", "\n"), array("\\\\", "\\'", " ", " "), $msg);
			}, $brValidationErrors));
			echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน\\n\\n$brValidationText');history.back();</script>";
			exit();
		}
	}

	// ครอบทุกตารางที่บันทึกในเอกสารนี้ด้วย transaction เดียว เพื่อไม่ให้ข้อมูลค้างครึ่งเมื่อมีตัวใดตัวหนึ่งพัง
	// ทำได้เพราะทุกตารางที่ query ในไฟล์นี้เป็น InnoDB แล้ว (hos__br เพิ่งแปลงจาก MyISAM มาเป็น InnoDB)
	// edit mode ต้องมีเลขเอกสารเป้าหมายเสมอ และต้องมีอยู่จริงใน hos__br
	// ตรวจก่อนเปิด transaction เพื่อไม่ให้ UPDATE ยิงลอย ๆ โดยไม่โดนแถวไหนเลย
	$ref_id_br = mysqli_real_escape_string($conn, trim((string)($_POST["ref_id_br"] ?? '')));
	$brTargetExists = false;
	if ($ref_id_br !== '') {
		$brTargetQuery = mysqli_query($conn, "SELECT ref_id_br FROM hos__br WHERE ref_id_br = '" . $ref_id_br . "' LIMIT 1");
		$brTargetExists = ($brTargetQuery && mysqli_num_rows($brTargetQuery) > 0);
	}

	if (!$brTargetExists) {
		if (ob_get_level() > 0) {
			ob_end_clean();
		}
		if ($isDraftRequest) {
			echo json_encode(array(
				'success' => false,
				'message' => 'ไม่พบเอกสารที่ต้องการแก้ไข'
			));
			exit();
		}
		echo "<script>alert('ไม่พบเอกสารที่ต้องการแก้ไข');history.back();</script>";
		exit();
	}

	mysqli_begin_transaction($conn);

	try {

		$company = mysqli_real_escape_string($conn, $_POST["company"]);
		$date_br = mysqli_real_escape_string($conn, $_POST["date_br"]);
		$customer = mysqli_real_escape_string($conn, $_POST["customer"]);
		$customer_id = mysqli_real_escape_string($conn, $_POST["customer_id"]);
		$address = mysqli_real_escape_string($conn, $_POST["address"]);
		$sale_comment = mysqli_real_escape_string($conn, $_POST["sale_comment"]);
		$sn_ckk = mysqli_real_escape_string($conn, $_POST["sn_ckk"]);
		$sn = mysqli_real_escape_string($conn, $_POST["sn"]);
		$cm_no = mysqli_real_escape_string($conn, $_POST["cm_no"]);
		$objective = mysqli_real_escape_string($conn, $_POST["objective"]);
		$objective_des1 = mysqli_real_escape_string($conn, $_POST["objective_des1"]);
		$objective_des2 = mysqli_real_escape_string($conn, $_POST["objective_des2"]);
		$objective_des4 = mysqli_real_escape_string($conn, $_POST["objective_des4"]);
		$objective_des5 = mysqli_real_escape_string($conn, $_POST["objective_des5"]);

		$return_date_bet = mysqli_real_escape_string($conn, $_POST["return_date_bet"]);
		$returns = mysqli_real_escape_string($conn, $_POST["returns"]);
		$que_ckk = mysqli_real_escape_string($conn, $_POST["que_ckk"]);
		// รับค่าจากช่อง "วันที่รับคืน" ในแท็บที่อยู่การคืนเท่านั้น
		// ส่วนช่อง "วันที่คืน" ที่คำนวณอัตโนมัติไม่มี name จึงไม่ถูกส่งมาและไม่ถูกบันทึก
		$returns_date = mysqli_real_escape_string($conn, $_POST["returns_date"] ?? "");
		$returns_time = mysqli_real_escape_string($conn, $_POST["returns_time"]);
		$returns_name = mysqli_real_escape_string($conn, $_POST["returns_name"]);
		$returns_address = mysqli_real_escape_string($conn, $_POST["returns_address"]);
		$returns_contact = mysqli_real_escape_string($conn, $_POST["returns_contact"]);
		$delivery_name = mysqli_real_escape_string($conn, $_POST["address_name"]);
		$delivery_type = mysqli_real_escape_string($conn, $_POST["delivery_type"]);
		$delivery_date = mysqli_real_escape_string($conn, $_POST["start_date"]);
		$start_time = mysqli_real_escape_string($conn, $_POST["start_time"]);
		$end_time = mysqli_real_escape_string($conn, $_POST["end_time"] ?? "");
		$delivery_time = "$start_time $end_time";
		$delivery_address = mysqli_real_escape_string($conn, $_POST["address_send"]);
		$delivery_contact = mysqli_real_escape_string($conn, $_POST["customer_name"]);
		$delivery_tel = mysqli_real_escape_string($conn, $_POST["customer_tel"]);
		$date_send_key = mysqli_real_escape_string($conn, $_POST["between_date"] ?? "");
		$type_breng = mysqli_real_escape_string($conn, $_POST["type_breng"] ?? "1");
		if ($type_breng == '2') {
			$iv_no = "BRES";
		} else {
			$iv_no = "BRNP";
		}

		$sale_date = date('Y-m-d');
		$approve_date = date('Y-m-d');
		$approve_time = date("H:i:s");
		$sale =  $_SESSION['name'];
		$code =  $_SESSION['code'];

		if ($code == 'ADM') {
			$adm_ckk = '1';
		} else {
			$adm_ckk = '0';
		}

		$sale_code = mysqli_real_escape_string($conn, $_POST["sale_code"]);
		$name =  $_SESSION['name'];
		$em_id =  $_SESSION['emid'];
		if ($sale_code == 'S11' or $sale_code == 'S12' or $sale_code == 'S13' or $sale_code == 'S14') {
			$approve_code = 'SS2';
			$approve  = 'นรินทิพย์';
		} else if ($sale_code == 'S15' or $sale_code == 'S22' or $sale_code == 'S21' or $sale_code == 'S51' or $sale_code == 'S16') {

			$approve_code = 'SS1';
			$approve  = 'พรรณิภา';
		} else if ($sale_code == 'S17' or $sale_code == 'SM1' or $sale_code == 'S23' or $sale_code == 'S24') {

			$approve_code = 'SM1';
			$approve  = 'ลักษณาวรรณ';
		} else if ($sale_code == 'S32' or $sale_code == 'S31' or $sale_code == 'MM1') {
			$approve_code = 'SS3';
			$approve  = 'มาลินี';
		} else if ($sale_code == 'EN') {
			$approve_code = 'SUP_EN';
			$approve  = 'ศิรวิทย์';
		}

		$add_date = date('Y-m-d H:i:s');
		$surname =	$_SESSION['surname'];
		$add_by = mysqli_real_escape_string($conn, $_POST["add_by"]);


		// เก็บชื่อไฟล์ที่อัปโหลดสำเร็จไว้ใน $slip1..$slip5
		// edit mode: ถ้าแนบไฟล์ใหม่ให้อัปโหลดและบันทึกชื่อใหม่ ถ้าไม่ได้แนบให้อ่านจาก $_POST (เพื่อคงชื่อเดิมหรือบันทึกค่าว่างถ้าสั่งลบ)
		$slip1 = $slip2 = $slip3 = $slip4 = $slip5 = null;
		for ($i = 1; $i <= 5; $i++) {
			$fileKey = 'slip' . $i;
			if (!empty($_FILES[$fileKey]['name'])) {
				$uploadedName = iconv("UTF-8", "TIS-620", $_FILES[$fileKey]['name']);
				move_uploaded_file($_FILES[$fileKey]['tmp_name'], "upload/" . $uploadedName);
				${$fileKey} = mysqli_real_escape_string($conn, $uploadedName);
			} else if (isset($_POST[$fileKey])) {
				${$fileKey} = mysqli_real_escape_string($conn, $_POST[$fileKey]);
			}
		}


		$head_1 = mysqli_real_escape_string($conn, $_POST["head_1"]);
		$ref_1 = mysqli_real_escape_string($conn, $_POST["ref_1"]);
		$ref_2 = mysqli_real_escape_string($conn, $_POST["ref_2"]);
		$ref_3 = mysqli_real_escape_string($conn, $_POST["ref_3"]);
		$ref_4 = mysqli_real_escape_string($conn, $_POST["ref_4"]);
		$ref_5 = mysqli_real_escape_string($conn, $_POST["ref_5"]);
		$ref_6 = mysqli_real_escape_string($conn, $_POST["ref_6"]);
		$ref_7 = mysqli_real_escape_string($conn, $_POST["ref_7"]);
		$ref_8 = mysqli_real_escape_string($conn, $_POST["ref_8"]);
		$ref_9 = mysqli_real_escape_string($conn, $_POST["ref_9"]);
		$ref_10 = mysqli_real_escape_string($conn, $_POST["ref_10"]);
		$ref_11 = mysqli_real_escape_string($conn, $_POST["ref_11"]);
		$ref_des = mysqli_real_escape_string($conn, $_POST["ref_des"]);
		$ref_11des = mysqli_real_escape_string($conn, $_POST["ref_11des"] ?? '');
		$ref_12 = ($_POST["ref_12"] ?? '') === '1' ? '1' : '0';


		// edit mode: เอกสารมีเลขอยู่แล้ว จึงไม่ต้องออกเลขใหม่/retry กันชน
		// อัปเดตเฉพาะคอลัมน์เนื้อหา — ไม่แตะ sale/sale_code/sale_date/add_by/add_date/approve*
		// เพื่อรักษาข้อมูลผู้สร้างและผู้อนุมัติเดิมไว้ (ตรงกับแนวทางฝั่ง SO)
		$brUpdateColumns = array(
			'company' => $company,
			'date_br' => $date_br,
			'customer' => $customer,
			'customer_id' => $customer_id,
			'address' => $address,
			'sn_ckk' => $sn_ckk,
			'sn' => $sn,
			'objective' => $objective,
			'objective_des1' => $objective_des1,
			'objective_des2' => $objective_des2,
			'objective_des4' => $objective_des4,
			'objective_des5' => $objective_des5,
			'returns' => $returns,
			'returns_date' => $returns_date,
			'returns_time' => $returns_time,
			'returns_name' => $returns_name,
			'returns_address' => $returns_address,
			'returns_contact' => $returns_contact,
			'delivery_name' => $delivery_name,
			'delivery_type' => $delivery_type,
			'delivery_date' => $delivery_date,
			'delivery_time' => $delivery_time,
			'delivery_address' => $delivery_address,
			'delivery_contact' => $delivery_contact,
			'delivery_tel' => $delivery_tel,
			'date_send_key' => $date_send_key,
			'return_date_bet' => $return_date_bet,
			'que_ckk' => $que_ckk,
			'cm_no' => $cm_no,
			'type_breng' => $type_breng,
			'iv_no' => $iv_no,
		);

		// ปุ่ม Submit/Update/แถบอนุมัติ ทั้งหมดยิงเข้าไฟล์นี้ (Update/แถบอนุมัติผ่าน register_supbrhos_draft1.php
		// ซึ่งเซ็ต is_draft='1' ไว้เสมอ) ถ้าเซ็ต send_sup/status_doc ทุกครั้ง เอกสาร Draft/ส่งกลับ จะถูกส่งให้ Sup
		// ทันทีที่กด Update ทั้งที่ผู้ใช้แค่แก้ไขข้อมูลเฉย ๆ จึงแยกเงื่อนไข: ยกเลิกเอกสาร > ส่งอนุมัติจริง (ไม่ใช่ draft) > คงสถานะเดิม
		$cancelDocPost = $_POST["cancel_doc"] ?? null;
		if ($cancelDocPost === '1') {
			$brUpdateColumns['send_sup'] = '1';
			$brUpdateColumns['status_doc'] = 'ยกเลิก';
		} elseif (!$isDraftRequest) {
			$brUpdateColumns['send_sup'] = '1';
			$brUpdateColumns['send_supname'] = $add_by;
			$brUpdateColumns['send_supdate'] = $add_date;
			$brUpdateColumns['send_admin'] = '0';
			$brUpdateColumns['status_doc'] = 'Request';
		}

		// อัปเดตคอลัมน์ slip (null = ไม่มีการส่งค่ามา ให้คงของเดิม)
		foreach (array('slip1' => $slip1, 'slip2' => $slip2, 'slip3' => $slip3, 'slip4' => $slip4, 'slip5' => $slip5) as $brSlipCol => $brSlipVal) {
			if ($brSlipVal !== null) {
				$brUpdateColumns[$brSlipCol] = $brSlipVal;
			}
		}

		$brUpdateParts = array();
		foreach ($brUpdateColumns as $brCol => $brVal) {
			$brUpdateParts[] = "`" . $brCol . "` = '" . $brVal . "'";
		}

		$save = "update hos__br set " . implode(", ", $brUpdateParts) . " where ref_id_br = '" . $ref_id_br . "'";
		$qsave = mysqli_query($conn, $save);
		if (!$qsave) {
			$saveOk = false;
			$saveFailures[] = 'hos__br: ' . mysqli_error($conn);
		}


		// pattern เดียวกับ updateHosSoColumnIfExists ใน register_suphos1.php — UPDATE คอลัมน์ hos__br ที่มีอยู่จริงเท่านั้น
		function updateHosBrColumnIfExists($conn, $ref_id_br, $column, $value)
		{
			if ($value === null || $value === '') {
				return;
			}

			$safeColumn = mysqli_real_escape_string($conn, $column);
			$columnCheck = mysqli_query($conn, "SHOW COLUMNS FROM hos__br LIKE '" . $safeColumn . "'");
			if (!$columnCheck || mysqli_num_rows($columnCheck) == 0) {
				return;
			}

			$safeValue = mysqli_real_escape_string($conn, $value);
			$safeRefId = mysqli_real_escape_string($conn, $ref_id_br);
			mysqli_query($conn, "UPDATE hos__br SET " . $safeColumn . " = '" . $safeValue . "' WHERE ref_id_br = '" . $safeRefId . "'");
		}

		function normalizeOptionalBrDateValue($value)
		{
			$value = trim($value);
			if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $value, $matches)) {
				$year = (int)$matches[3];
				if ($year > 2400) {
					$year -= 543;
				}
				return sprintf('%04d-%02d-%02d', $year, (int)$matches[2], (int)$matches[1]);
			}
			return $value;
		}

		$optionalHosBrFieldMap = array(
			'admin_doc_no' => 'iv_no',
			'admin_doc_date' => 'iv_date',
			'admin_work_no' => 'job_no',
			'admin_cancel_reason' => 'remark_cancel',
			'shipping_date' => 'date_ker',
			'shipping_ref1' => 'order_refer_code',
			'shipping_ref2' => 'order_refer_code1',
			'shipping_cost' => 'ker_bath',
		);

		foreach ($optionalHosBrFieldMap as $postField => $columnName) {
			if (isset($_POST[$postField])) {
				$optionalValue = mysqli_real_escape_string($conn, $_POST[$postField]);
				if ($postField === 'admin_doc_date') {
					$optionalValue = normalizeOptionalBrDateValue($optionalValue);
				}
				updateHosBrColumnIfExists($conn, $ref_id_br, $columnName, $optionalValue);
			}
		}

		// ช่วงวันที่/เวลารับคืน (ถึงวันที่ / ถึงเวลา): ค่าว่างต้องล้างเป็น NULL ได้ จึงไม่ใช้ updateHosBrColumnIfExists ที่ข้ามค่าว่าง
		foreach (array('returns_date_to', 'returns_time_to') as $returnsRangeColumn) {
			$returnsRangeCheck = mysqli_query($conn, "SHOW COLUMNS FROM hos__br LIKE '" . $returnsRangeColumn . "'");
			if ($returnsRangeCheck && mysqli_num_rows($returnsRangeCheck) > 0) {
				$returnsRangeValue = trim((string)($_POST[$returnsRangeColumn] ?? ''));
				$returnsRangeSql = $returnsRangeValue === '' ? 'NULL' : "'" . mysqli_real_escape_string($conn, $returnsRangeValue) . "'";
				mysqli_query($conn, "UPDATE hos__br SET " . $returnsRangeColumn . " = " . $returnsRangeSql . " WHERE ref_id_br = '" . mysqli_real_escape_string($conn, $ref_id_br) . "'");
			}
		}

		// send_cs เป็น checkbox: checkbox ที่ไม่ติ๊กจะไม่ถูกส่งมาใน $_POST เลย
		// ต้องกำหนดค่า '0' เองแทนการข้าม ไม่เช่นนั้นผู้ใช้ uncheck แล้วกด Save ค่าเดิมจะไม่ถูกล้าง
		updateHosBrColumnIfExists($conn, $ref_id_br, 'send_cs', (($_POST['send_cs'] ?? '') === '1') ? '1' : '0');

		// ช่วงเวลาจัดส่ง (sql/delivery_time_range.sql): เขียนเฉพาะค่าที่รู้จัก หน้าที่ไม่ส่งฟิลด์นี้มาจึงไม่ล้างค่าเดิม
		if (in_array($_POST['time_range'] ?? '', array('morning', 'afternoon', 'allday', 'specific'), true)) {
			updateHosBrColumnIfExists($conn, $ref_id_br, 'time_range', $_POST['time_range']);
		}


		mysqli_query($conn, "DELETE FROM tb_other_bill WHERE ref_id = '" . $ref_id_br . "'");
		$save56 = "insert into tb_other_bill
(ref_id,head_1,ref_1,ref_2,ref_3,ref_4,ref_5,ref_6,ref_7,ref_8,ref_9,ref_10,ref_11,ref_des,ref_12)
values
('" . $ref_id_br . "','" . $head_1 . "','" . $ref_1 . "','" . $ref_2 . "','" . $ref_3 . "','" . $ref_4 . "','" . $ref_5 . "','" . $ref_6 . "','" . $ref_7 . "','" . $ref_8 . "','" . $ref_9 . "','" . $ref_10 . "','" . $ref_11 . "','" . $ref_des . "','" . $ref_12 . "')";
		$qsave56 = mysqli_query($conn, $save56);
		if (!$qsave56) {
			$saveOk = false;
			$saveFailures[] = 'tb_comment_so: ' . mysqli_error($conn);
		}

		// ---- ข้อความแจ้งแผนก (tb_comment_so + tb_comment_so_item) — reuse จาก register_suphos1.php ----
		function getBrDeptCommentItemsFromPost()
		{
			$itemsJson = $_POST["dept_comment_items"] ?? "[]";
			$decodedItems = json_decode($itemsJson, true);
			if (!is_array($decodedItems)) {
				return array();
			}

			$items = array();
			$allowedDepartments = array(1, 2, 3, 4, 5);
			foreach ($decodedItems as $index => $item) {
				$departmentId = isset($item["department_id"]) ? (int)$item["department_id"] : 0;
				$message = isset($item["message"]) ? trim($item["message"]) : "";
				if (!in_array($departmentId, $allowedDepartments, true) || $message === "") {
					continue;
				}

				$items[] = array(
					"department_id" => $departmentId,
					"message" => $message,
					"sort_order" => isset($item["sort_order"]) ? (int)$item["sort_order"] : ($index + 1)
				);
			}

			return $items;
		}

		function saveBrDeptCommentItems($conn, $commentSoId, $refId, $items)
		{
			$commentSoId = (int)$commentSoId;
			$refIdEscaped = mysqli_real_escape_string($conn, $refId);
			mysqli_query($conn, "DELETE FROM tb_comment_so_item WHERE comment_so_id = " . $commentSoId . " OR ref_id = '" . $refIdEscaped . "'");

			foreach ($items as $item) {
				$departmentId = (int)$item["department_id"];
				$message = mysqli_real_escape_string($conn, $item["message"]);
				$sortOrder = (int)$item["sort_order"];
				$sql = "INSERT INTO tb_comment_so_item (comment_so_id, ref_id, department_id, message, sort_order) VALUES (" . $commentSoId . ", '" . $refIdEscaped . "', " . $departmentId . ", '" . $message . "', " . $sortOrder . ")";
				mysqli_query($conn, $sql);
			}
		}

		$comment_cs = mysqli_real_escape_string($conn, $_POST["comment_cs"] ?? "");
		$comment_en = mysqli_real_escape_string($conn, $_POST["comment_en"] ?? "");
		$comment_st = mysqli_real_escape_string($conn, $_POST["comment_st"] ?? "");
		$comment_ad = mysqli_real_escape_string($conn, $_POST["comment_ad"] ?? "");
		$technician_required = ($_POST["technician_required"] ?? "0") === "1" ? "1" : "0";

		mysqli_query($conn, "DELETE FROM tb_comment_so WHERE ref_id = '" . $ref_id_br . "'");
		$save57 = "insert into tb_comment_so (ref_id,comment_cs,comment_en,comment_st,comment_ad,technician_required) values ('" . $ref_id_br . "','" . $comment_cs . "','" . $comment_en . "','" . $comment_st . "','" . $comment_ad . "','" . $technician_required . "')";
		$qsave57 = mysqli_query($conn, $save57);
		if ($qsave57) {
			saveBrDeptCommentItems($conn, mysqli_insert_id($conn), $ref_id_br, getBrDeptCommentItemsFromPost());
		} else {
			$saveOk = false;
			$saveFailures[] = 'tb_comment_so (comment): ' . mysqli_error($conn);
		}

		// ---- รายละเอียดที่อยู่ (tb_transaction) — ชื่อฟิลด์ friendly ของฟอร์ม BR ต้องแปลงเป็นคอลัมน์จริงเอง ----
		$br_park_front = mysqli_real_escape_string($conn, $_POST["park_front"] ?? "");
		$br_car_home = ($br_park_front === '1') ? '1' : '0';
		$br_car_road = ($br_park_front === '0') ? '1' : '0';
		$br_car_park = mysqli_real_escape_string($conn, $_POST["park_location"] ?? "");
		$br_height_ltd = ($_POST["is_high_roof"] ?? "") === '1' ? '1' : '0';

		$br_entrance_type = mysqli_real_escape_string($conn, $_POST["entrance_type"] ?? "");
		$br_slope = ($br_entrance_type === '1') ? '1' : '0';
		$br_bundai = ($br_entrance_type === '2') ? '1' : '0';
		$br_unit_bundai = mysqli_real_escape_string($conn, $_POST["stair_count"] ?? "");
		$br_install = mysqli_real_escape_string($conn, $_POST["install_floor"] ?? "");

		$br_room_type = mysqli_real_escape_string($conn, $_POST["room_type"] ?? "");
		$br_room_bigger = mysqli_real_escape_string($conn, $_POST["door_width"] ?? "");
		$br_room_longer = mysqli_real_escape_string($conn, $_POST["door_height"] ?? "");

		$br_stair_width = trim((string)($_POST["stair_width"] ?? ""));
		$br_stair_height = trim((string)($_POST["stair_height"] ?? ""));
		$br_bundai_big = ($br_stair_width !== '' || $br_stair_height !== '') ? ($br_stair_width . ' x ' . $br_stair_height) : '';

		$br_elev_door_width = trim((string)($_POST["elev_door_width"] ?? ""));
		$br_elev_door_height = trim((string)($_POST["elev_door_height"] ?? ""));
		$br_lip_big = ($br_elev_door_width !== '' || $br_elev_door_height !== '') ? ($br_elev_door_width . ' x ' . $br_elev_door_height) : '';

		$br_elev_width = trim((string)($_POST["elev_width"] ?? ""));
		$br_elev_height = trim((string)($_POST["elev_height"] ?? ""));
		$br_elev_depth = trim((string)($_POST["elev_depth"] ?? ""));
		$br_lip_long = ($br_elev_width !== '' || $br_elev_height !== '' || $br_elev_depth !== '') ? ($br_elev_width . ' x ' . $br_elev_height . ' x ' . $br_elev_depth) : '';

		$br_lip_weight = mysqli_real_escape_string($conn, $_POST["elev_capacity"] ?? "");

		$br_move_furn = mysqli_real_escape_string($conn, $_POST["move_furn"] ?? "0");
		$br_want_employee = ($br_move_furn === '1') ? '1' : '0';
		$br_employee_unit = mysqli_real_escape_string($conn, $_POST["move_furn_count"] ?? "");
		$br_ferniger_name = mysqli_real_escape_string($conn, $_POST["move_furn_detail"] ?? "");
		$br_addr_note = mysqli_real_escape_string($conn, $_POST["addr_note"] ?? "");

		mysqli_query($conn, "DELETE FROM tb_transaction WHERE ref_id = '" . $ref_id_br . "'");
		$strSQL99Br = "insert into tb_transaction (ref_id,car_park,car_road,car_home,slope,bundai,unit_bundai,home_type,install,bundai_big,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,room_bigger,room_longer,description,height_ltd,add_date,add_by)
values('" . $ref_id_br . "','" . $br_car_park . "','" . $br_car_road . "','" . $br_car_home . "','" . $br_slope . "','" . $br_bundai . "','" . $br_unit_bundai . "','" . $br_room_type . "','" . $br_install . "','" . $br_bundai_big . "','" . $br_lip_big . "','" . $br_lip_long . "','" . $br_lip_weight . "','" . $br_want_employee . "','" . $br_employee_unit . "','" . $br_ferniger_name . "','" . $br_room_bigger . "','" . $br_room_longer . "','" . $br_addr_note . "','" . $br_height_ltd . "','$add_date','" . $add_by . "')";
		$objQuery99Br = mysqli_query($conn, $strSQL99Br);

		if (!function_exists('updateTbTransactionColumnIfExists')) {
			function updateTbTransactionColumnIfExists($conn, $ref_id, $column, $value)
			{
				$safeColumn = mysqli_real_escape_string($conn, $column);
				$columnCheck = mysqli_query($conn, "SHOW COLUMNS FROM tb_transaction LIKE '" . $safeColumn . "'");
				if (!$columnCheck || mysqli_num_rows($columnCheck) == 0) {
					return;
				}

				$safeValue = mysqli_real_escape_string($conn, $value);
				$safeRefId = mysqli_real_escape_string($conn, $ref_id);
				mysqli_query($conn, "UPDATE tb_transaction SET " . $safeColumn . " = '" . $safeValue . "' WHERE ref_id = '" . $safeRefId . "'");
			}
		}

		updateTbTransactionColumnIfExists($conn, $ref_id_br, 'install_room', $br_room_type);

		// ---- ที่อยู่เพิ่มเติม (tb_shipping_address) — ชื่อฟิลด์ extra_contact_*_{i} ของฟอร์ม BR, สูงสุด 9 แถว ----
		mysqli_query($conn, "DELETE FROM tb_shipping_address WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id_br) . "'");

		for ($brShippingIndex = 1; $brShippingIndex <= 9; $brShippingIndex++) {
			$brShippingContactName = trim((string)($_POST['extra_contact_name_' . $brShippingIndex] ?? ''));
			$brShippingTelephone = trim((string)($_POST['extra_contact_tel_' . $brShippingIndex] ?? ''));
			$brShippingProvince = trim((string)($_POST['extra_contact_province_' . $brShippingIndex] ?? ''));
			$brShippingAddress = trim((string)($_POST['extra_shipping_address_' . $brShippingIndex] ?? ''));

			if ($brShippingContactName === '' && $brShippingTelephone === '' && $brShippingProvince === '' && $brShippingAddress === '') {
				continue;
			}

			$strBrShippingInsert = "INSERT INTO tb_shipping_address (ref_id, contact_name, telephone, province, address) VALUES ('" .
				mysqli_real_escape_string($conn, $ref_id_br) . "','" .
				mysqli_real_escape_string($conn, $brShippingContactName) . "','" .
				mysqli_real_escape_string($conn, $brShippingTelephone) . "','" .
				mysqli_real_escape_string($conn, $brShippingProvince) . "','" .
				mysqli_real_escape_string($conn, $brShippingAddress) . "')";

			mysqli_query($conn, $strBrShippingInsert);
		}

		// ---- คัดลอกที่อยู่เพิ่มเติมชุดเดียวกันเข้า tb_delivery_print เพื่อให้ปุ่ม "พิมพ์ใบปะ" (ที่อยู่เพิ่มเติม) มีข้อมูลพิมพ์ — ฝั่ง SO เขียนตารางนี้จากฟิลด์ customer_name{i} ของฟอร์มตัวเอง แต่ฟอร์ม BR ไม่มีฟิลด์ชุดนั้น จึงใช้ extra_contact_*_{i} ที่มีอยู่แล้วเป็นต้นทาง ----
		if (!function_exists('tbDeliveryPrintColumnExists')) {
			function tbDeliveryPrintColumnExists($conn, $columnName)
			{
				static $columnCache = array();
				if (array_key_exists($columnName, $columnCache)) {
					return $columnCache[$columnName];
				}

				$safeColumnName = mysqli_real_escape_string($conn, $columnName);
				$query = mysqli_query($conn, "SHOW COLUMNS FROM tb_delivery_print LIKE '" . $safeColumnName . "'");
				$columnCache[$columnName] = ($query && mysqli_num_rows($query) > 0);
				return $columnCache[$columnName];
			}
		}

		mysqli_query($conn, "DELETE FROM tb_delivery_print WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id_br) . "'");

		$brDeliveryPrintHasData = false;
		for ($brDeliveryPrintIndex = 1; $brDeliveryPrintIndex <= 9; $brDeliveryPrintIndex++) {
			$brDeliveryPrintName = trim((string)($_POST['extra_contact_name_' . $brDeliveryPrintIndex] ?? ''));
			$brDeliveryPrintTel = trim((string)($_POST['extra_contact_tel_' . $brDeliveryPrintIndex] ?? ''));
			$brDeliveryPrintProvince = trim((string)($_POST['extra_contact_province_' . $brDeliveryPrintIndex] ?? ''));
			$brDeliveryPrintAddress = trim((string)($_POST['extra_shipping_address_' . $brDeliveryPrintIndex] ?? ''));

			if ($brDeliveryPrintName !== '' || $brDeliveryPrintTel !== '' || $brDeliveryPrintProvince !== '' || $brDeliveryPrintAddress !== '') {
				$brDeliveryPrintHasData = true;
			}
		}

		if ($brDeliveryPrintHasData) {
			$brDeliveryPrintColumns = array('ref_id');
			$brDeliveryPrintValues = array("'" . mysqli_real_escape_string($conn, $ref_id_br) . "'");

			for ($brDeliveryPrintIndex = 1; $brDeliveryPrintIndex <= 9; $brDeliveryPrintIndex++) {
				$brDeliveryPrintName = trim((string)($_POST['extra_contact_name_' . $brDeliveryPrintIndex] ?? ''));
				$brDeliveryPrintTel = trim((string)($_POST['extra_contact_tel_' . $brDeliveryPrintIndex] ?? ''));
				$brDeliveryPrintProvince = trim((string)($_POST['extra_contact_province_' . $brDeliveryPrintIndex] ?? ''));
				$brDeliveryPrintAddress = trim((string)($_POST['extra_shipping_address_' . $brDeliveryPrintIndex] ?? ''));

				$brDeliveryPrintColumns[] = 'customer_name' . $brDeliveryPrintIndex;
				$brDeliveryPrintValues[] = "'" . mysqli_real_escape_string($conn, $brDeliveryPrintName) . "'";
				$brDeliveryPrintColumns[] = 'customer_tel' . $brDeliveryPrintIndex;
				$brDeliveryPrintValues[] = "'" . mysqli_real_escape_string($conn, $brDeliveryPrintTel) . "'";
				if (tbDeliveryPrintColumnExists($conn, 'province_name' . $brDeliveryPrintIndex)) {
					$brDeliveryPrintColumns[] = 'province_name' . $brDeliveryPrintIndex;
					$brDeliveryPrintValues[] = "'" . mysqli_real_escape_string($conn, $brDeliveryPrintProvince) . "'";
				}
				$brDeliveryPrintColumns[] = 'address_name' . $brDeliveryPrintIndex;
				$brDeliveryPrintValues[] = "'" . mysqli_real_escape_string($conn, $brDeliveryPrintAddress) . "'";
			}

			$strBrDeliveryPrintInsert = "insert into tb_delivery_print (" . implode(',', $brDeliveryPrintColumns) . ") values(" . implode(',', $brDeliveryPrintValues) . ")";
			mysqli_query($conn, $strBrDeliveryPrintInsert);
		}

		// ---- ที่อยู่ส่งบิล (tb_delivery_bill) — ชื่อฟิลด์ตรงกับฟอร์ม SO พอดี ----
		$brDeliveryBillContactName = trim((string)($_POST['bill_extra_contact_name_2'] ?? ''));
		$brDeliveryBillTelephone = trim((string)($_POST['bill_extra_contact_tel_2'] ?? ''));
		$brDeliveryBillProvince = trim((string)($_POST['bill_extra_contact_province_2'] ?? ''));
		$brDeliveryBillAddress = trim((string)($_POST['bill_extra_shipping_address_2'] ?? ''));

		mysqli_query($conn, "DELETE FROM tb_delivery_bill WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id_br) . "'");

		if ($brDeliveryBillContactName !== '' || $brDeliveryBillTelephone !== '' || $brDeliveryBillProvince !== '' || $brDeliveryBillAddress !== '') {
			$strBrDeliveryBillInsert = "INSERT INTO tb_delivery_bill (ref_id, customer_nameb, customer_telb, province, address_nameb) VALUES ('" .
				mysqli_real_escape_string($conn, $ref_id_br) . "','" .
				mysqli_real_escape_string($conn, $brDeliveryBillContactName) . "','" .
				mysqli_real_escape_string($conn, $brDeliveryBillTelephone) . "','" .
				mysqli_real_escape_string($conn, $brDeliveryBillProvince) . "','" .
				mysqli_real_escape_string($conn, $brDeliveryBillAddress) . "')";

			mysqli_query($conn, $strBrDeliveryBillInsert);
		}

		// ลบรายการสินค้าเดิมของเอกสารนี้ทั้งหมด แล้วแทรกชุดใหม่จากฟอร์ม
		// (แทนการไล่ diff ทีละแถว ซึ่งซับซ้อนกว่าและพลาดง่ายเมื่อผู้ใช้สลับ/ลบแถว)
		mysqli_query($conn, "DELETE FROM hos__subbr WHERE ref_idd_br = '" . $ref_id_br . "'");

		$warranty1 = mysqli_real_escape_string($conn, $_POST["warranty1"]);
		$warranty2 = mysqli_real_escape_string($conn, $_POST["warranty2"]);
		$warranty3 = mysqli_real_escape_string($conn, $_POST["warranty3"]);
		$warranty4 = mysqli_real_escape_string($conn, $_POST["warranty4"]);
		$warranty5 = mysqli_real_escape_string($conn, $_POST["warranty5"]);
		$warranty6 = mysqli_real_escape_string($conn, $_POST["warranty6"]);
		$warranty7 = mysqli_real_escape_string($conn, $_POST["warranty7"]);
		$warranty8 = mysqli_real_escape_string($conn, $_POST["warranty8"]);
		$warranty9 = mysqli_real_escape_string($conn, $_POST["warranty9"]);
		$warranty10 = mysqli_real_escape_string($conn, $_POST["warranty10"]);
		$warranty11 = mysqli_real_escape_string($conn, $_POST["warranty11"]);
		$warranty12 = mysqli_real_escape_string($conn, $_POST["warranty12"]);
		$warranty13 = mysqli_real_escape_string($conn, $_POST["warranty13"]);
		$warranty14 = mysqli_real_escape_string($conn, $_POST["warranty14"]);
		$warranty15 = mysqli_real_escape_string($conn, $_POST["warranty15"]);
		$warranty16 = mysqli_real_escape_string($conn, $_POST["warranty16"]);
		$warranty17 = mysqli_real_escape_string($conn, $_POST["warranty17"]);
		$warranty18 = mysqli_real_escape_string($conn, $_POST["warranty18"]);
		$warranty19 = mysqli_real_escape_string($conn, $_POST["warranty19"]);
		$warranty20 = mysqli_real_escape_string($conn, $_POST["warranty20"]);
		$warranty21 = mysqli_real_escape_string($conn, $_POST["warranty21"]);
		$warranty22 = mysqli_real_escape_string($conn, $_POST["warranty22"]);
		$warranty23 = mysqli_real_escape_string($conn, $_POST["warranty23"]);
		$warranty24 = mysqli_real_escape_string($conn, $_POST["warranty24"]);
		$warranty25 = mysqli_real_escape_string($conn, $_POST["warranty25"]);
		$warranty26 = mysqli_real_escape_string($conn, $_POST["warranty26"]);
		$warranty27 = mysqli_real_escape_string($conn, $_POST["warranty27"]);
		$warranty28 = mysqli_real_escape_string($conn, $_POST["warranty28"]);
		$warranty29 = mysqli_real_escape_string($conn, $_POST["warranty29"]);
		$warranty30 = mysqli_real_escape_string($conn, $_POST["warranty30"]);


		$product_name1 = mysqli_real_escape_string($conn, $_POST["product_name1"]);
		$unit_name1 = mysqli_real_escape_string($conn, $_POST["unit_name1"]);
		$product_id1 = mysqli_real_escape_string($conn, $_POST["product_id1"]);
		$sale_count1 = mysqli_real_escape_string($conn, $_POST["sale_count1"]);
		$product_price1 = mysqli_real_escape_string($conn, $_POST["product_price1"]);
		$sale_remarkk1 = mysqli_real_escape_string($conn, $_POST["sale_remarkk1"]);
		$sum_amountt = mysqli_real_escape_string($conn, $_POST["sum_amount1"]);
		$sum_amount1 = str_replace(',', '', $sum_amountt);
		$br_period1 = mysqli_real_escape_string($conn, $_POST["br_period1"]);

		if ($_POST["product_code1"] != '') {
			$product_code1 = mysqli_real_escape_string($conn, $_POST["product_code1"]);
		} else if ($_POST["product_codet1"] != '') {
			$product_code1 = mysqli_real_escape_string($conn, $_POST["product_codet1"]);
		} else {
			$product_code1 = mysqli_real_escape_string($conn, $_POST["product_c1"]);
		}


		$product_name2 = mysqli_real_escape_string($conn, $_POST["product_name2"]);
		$unit_name2 = mysqli_real_escape_string($conn, $_POST["unit_name2"]);
		$product_id2 = mysqli_real_escape_string($conn, $_POST["product_id2"]);
		$sale_count2 = mysqli_real_escape_string($conn, $_POST["sale_count2"]);
		$product_price2 = mysqli_real_escape_string($conn, $_POST["product_price2"]);
		$sale_remarkk2 = mysqli_real_escape_string($conn, $_POST["sale_remarkk2"]);
		$sum_amountt2 = mysqli_real_escape_string($conn, $_POST["sum_amount2"]);
		$sum_amount2 = str_replace(',', '', $sum_amountt2);
		$br_period2 = mysqli_real_escape_string($conn, $_POST["br_period2"]);

		if ($_POST["product_code2"] != '') {
			$product_code2 = mysqli_real_escape_string($conn, $_POST["product_code2"]);
		} else if ($_POST["product_codet2"] != '') {
			$product_code2 = mysqli_real_escape_string($conn, $_POST["product_codet2"]);
		} else {
			$product_code2 = mysqli_real_escape_string($conn, $_POST["product_c2"]);
		}


		$product_name3 = mysqli_real_escape_string($conn, $_POST["product_name3"]);
		$unit_name3 = mysqli_real_escape_string($conn, $_POST["unit_name3"]);
		$product_id3 = mysqli_real_escape_string($conn, $_POST["product_id3"]);
		$sale_count3 = mysqli_real_escape_string($conn, $_POST["sale_count3"]);
		$product_price3 = mysqli_real_escape_string($conn, $_POST["product_price3"]);
		$sale_remarkk3 = mysqli_real_escape_string($conn, $_POST["sale_remarkk3"]);
		$sum_amountt3 = mysqli_real_escape_string($conn, $_POST["sum_amount3"]);
		$sum_amount3 = str_replace(',', '', $sum_amountt3);
		$br_period3 = mysqli_real_escape_string($conn, $_POST["br_period3"]);

		if ($_POST["product_code3"] != '') {
			$product_code3 = mysqli_real_escape_string($conn, $_POST["product_code3"]);
		} else if ($_POST["product_codet3"] != '') {
			$product_code3 = mysqli_real_escape_string($conn, $_POST["product_codet3"]);
		} else {
			$product_code3 = mysqli_real_escape_string($conn, $_POST["product_c3"]);
		}

		$product_name4 = mysqli_real_escape_string($conn, $_POST["product_name4"]);
		$unit_name4 = mysqli_real_escape_string($conn, $_POST["unit_name4"]);
		$product_id4 = mysqli_real_escape_string($conn, $_POST["product_id4"]);
		$sale_count4 = mysqli_real_escape_string($conn, $_POST["sale_count4"]);
		$product_price4 = mysqli_real_escape_string($conn, $_POST["product_price4"]);
		$sale_remarkk4 = mysqli_real_escape_string($conn, $_POST["sale_remarkk4"]);
		$sum_amountt4 = mysqli_real_escape_string($conn, $_POST["sum_amount4"]);
		$sum_amount4 = str_replace(',', '', $sum_amountt4);
		$br_period4 = mysqli_real_escape_string($conn, $_POST["br_period4"]);

		if ($_POST["product_code4"] != '') {
			$product_code4 = mysqli_real_escape_string($conn, $_POST["product_code4"]);
		} else if ($_POST["product_codet4"] != '') {
			$product_code4 = mysqli_real_escape_string($conn, $_POST["product_codet4"]);
		} else {
			$product_code4 = mysqli_real_escape_string($conn, $_POST["product_c4"]);
		}



		$product_name5 = mysqli_real_escape_string($conn, $_POST["product_name5"]);
		$unit_name5 = mysqli_real_escape_string($conn, $_POST["unit_name5"]);
		$product_id5 = mysqli_real_escape_string($conn, $_POST["product_id5"]);
		$sale_count5 = mysqli_real_escape_string($conn, $_POST["sale_count5"]);
		$product_price5 = mysqli_real_escape_string($conn, $_POST["product_price5"]);
		$sale_remarkk5 = mysqli_real_escape_string($conn, $_POST["sale_remarkk5"]);
		$sum_amountt5 = mysqli_real_escape_string($conn, $_POST["sum_amount5"]);
		$sum_amount5 = str_replace(',', '', $sum_amountt5);
		$br_period5 = mysqli_real_escape_string($conn, $_POST["br_period5"]);

		if ($_POST["product_code5"] != '') {
			$product_code5 = mysqli_real_escape_string($conn, $_POST["product_code5"]);
		} else if ($_POST["product_codet5"] != '') {
			$product_code5 = mysqli_real_escape_string($conn, $_POST["product_codet5"]);
		} else {
			$product_code5 = mysqli_real_escape_string($conn, $_POST["product_c5"]);
		}

		$product_name6 = mysqli_real_escape_string($conn, $_POST["product_name6"]);
		$unit_name6 = mysqli_real_escape_string($conn, $_POST["unit_name6"]);
		$product_id6 = mysqli_real_escape_string($conn, $_POST["product_id6"]);
		$sale_count6 = mysqli_real_escape_string($conn, $_POST["sale_count6"]);
		$product_price6 = mysqli_real_escape_string($conn, $_POST["product_price6"]);
		$sale_remarkk6 = mysqli_real_escape_string($conn, $_POST["sale_remarkk6"]);
		$sum_amountt6 = mysqli_real_escape_string($conn, $_POST["sum_amount6"]);
		$sum_amount6 = str_replace(',', '', $sum_amountt6);
		$br_period6 = mysqli_real_escape_string($conn, $_POST["br_period6"]);

		if ($_POST["product_code6"] != '') {
			$product_code6 = mysqli_real_escape_string($conn, $_POST["product_code6"]);
		} else if ($_POST["product_codet6"] != '') {
			$product_code6 = mysqli_real_escape_string($conn, $_POST["product_codet6"]);
		} else {
			$product_code6 = mysqli_real_escape_string($conn, $_POST["product_c6"]);
		}


		$product_name7 = mysqli_real_escape_string($conn, $_POST["product_name7"]);
		$unit_name7 = mysqli_real_escape_string($conn, $_POST["unit_name7"]);
		$product_id7 = mysqli_real_escape_string($conn, $_POST["product_id7"]);
		$sale_count7 = mysqli_real_escape_string($conn, $_POST["sale_count7"]);
		$product_price7 = mysqli_real_escape_string($conn, $_POST["product_price7"]);
		$sale_remarkk7 = mysqli_real_escape_string($conn, $_POST["sale_remarkk7"]);
		$sum_amountt7 = mysqli_real_escape_string($conn, $_POST["sum_amount7"]);
		$sum_amount7 = str_replace(',', '', $sum_amountt7);
		$br_period7 = mysqli_real_escape_string($conn, $_POST["br_period7"]);

		if ($_POST["product_code7"] != '') {
			$product_code7 = mysqli_real_escape_string($conn, $_POST["product_code7"]);
		} else if ($_POST["product_codet7"] != '') {
			$product_code7 = mysqli_real_escape_string($conn, $_POST["product_codet7"]);
		} else {
			$product_code7 = mysqli_real_escape_string($conn, $_POST["product_c7"]);
		}



		$product_name8 = mysqli_real_escape_string($conn, $_POST["product_name8"]);
		$unit_name8 = mysqli_real_escape_string($conn, $_POST["unit_name8"]);
		$product_id8 = mysqli_real_escape_string($conn, $_POST["product_id8"]);
		$sale_count8 = mysqli_real_escape_string($conn, $_POST["sale_count8"]);
		$product_price8 = mysqli_real_escape_string($conn, $_POST["product_price8"]);
		$sale_remarkk8 = mysqli_real_escape_string($conn, $_POST["sale_remarkk8"]);
		$sum_amountt8 = mysqli_real_escape_string($conn, $_POST["sum_amount8"]);
		$sum_amount8 = str_replace(',', '', $sum_amountt8);
		$br_period8 = mysqli_real_escape_string($conn, $_POST["br_period8"]);

		if ($_POST["product_code8"] != '') {
			$product_code8 = mysqli_real_escape_string($conn, $_POST["product_code8"]);
		} else if ($_POST["product_codet8"] != '') {
			$product_code8 = mysqli_real_escape_string($conn, $_POST["product_codet8"]);
		} else {
			$product_code8 = mysqli_real_escape_string($conn, $_POST["product_c8"]);
		}


		// ช่อง 9-10 (แผนกวิศวกรรมเท่านั้น ปลดล็อกผ่านติ๊ก "เพิ่มเติม" ใน detail_breng_so.php)
		// mirror ของ register_supbrhos1.php ทุกประการ — ดูเหตุผลเต็มในไฟล์ create
		$product_name9 = mysqli_real_escape_string($conn, $_POST["product_name9"] ?? '');
		$unit_name9 = mysqli_real_escape_string($conn, $_POST["unit_name9"] ?? '');
		$product_id9 = mysqli_real_escape_string($conn, $_POST["product_id9"] ?? '');
		$sale_count9 = mysqli_real_escape_string($conn, $_POST["sale_count9"] ?? '');
		$product_price9 = mysqli_real_escape_string($conn, $_POST["product_price9"] ?? '');
		$sale_remarkk9 = mysqli_real_escape_string($conn, $_POST["sale_remarkk9"] ?? '');
		$sum_amountt9 = mysqli_real_escape_string($conn, $_POST["sum_amount9"] ?? '');
		$sum_amount9 = str_replace(',', '', $sum_amountt9);
		$br_period9 = mysqli_real_escape_string($conn, $_POST["br_period9"] ?? '');

		if (($_POST["product_code9"] ?? '') != '') {
			$product_code9 = mysqli_real_escape_string($conn, $_POST["product_code9"]);
		} else if (($_POST["product_codet9"] ?? '') != '') {
			$product_code9 = mysqli_real_escape_string($conn, $_POST["product_codet9"]);
		} else {
			$product_code9 = mysqli_real_escape_string($conn, $_POST["product_c9"] ?? '');
		}

		$product_name10 = mysqli_real_escape_string($conn, $_POST["product_name10"] ?? '');
		$unit_name10 = mysqli_real_escape_string($conn, $_POST["unit_name10"] ?? '');
		$product_id10 = mysqli_real_escape_string($conn, $_POST["product_id10"] ?? '');
		$sale_count10 = mysqli_real_escape_string($conn, $_POST["sale_count10"] ?? '');
		$product_price10 = mysqli_real_escape_string($conn, $_POST["product_price10"] ?? '');
		$sale_remarkk10 = mysqli_real_escape_string($conn, $_POST["sale_remarkk10"] ?? '');
		$sum_amountt10 = mysqli_real_escape_string($conn, $_POST["sum_amount10"] ?? '');
		$sum_amount10 = str_replace(',', '', $sum_amountt10);
		$br_period10 = mysqli_real_escape_string($conn, $_POST["br_period10"] ?? '');

		if (($_POST["product_code10"] ?? '') != '') {
			$product_code10 = mysqli_real_escape_string($conn, $_POST["product_code10"]);
		} else if (($_POST["product_codet10"] ?? '') != '') {
			$product_code10 = mysqli_real_escape_string($conn, $_POST["product_codet10"]);
		} else {
			$product_code10 = mysqli_real_escape_string($conn, $_POST["product_c10"] ?? '');
		}




		if ($product_id1 !== '') {

			$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code1 . "' ";
			$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
			$Num_Rows31 = mysqli_num_rows($objQuery31);
			$objResult31 = mysqli_fetch_array($objQuery31);

			if ($Num_Rows31 > 0) {

				$id_product1 = $objResult31["product_id1"];
				$id_product2 = $objResult31["product_id2"];
				$id_product3 = $objResult31["product_id3"];
				$id_product4 = $objResult31["product_id4"];
				$id_product5 = $objResult31["product_id5"];
				$id_product6 = $objResult31["product_id6"];
				$id_product7 = $objResult31["product_id7"];
				$id_product8 = $objResult31["product_id8"];
				$id_product9 = $objResult31["product_id9"];
				$id_product10 = $objResult31["product_id10"];

				$unit1 = $sale_count1 * $objResult31["unit1"];
				$unit2 = $sale_count1 * $objResult31["unit2"];
				$unit3 = $sale_count1 * $objResult31["unit3"];
				$unit4 = $sale_count1 * $objResult31["unit4"];
				$unit5 = $sale_count1 * $objResult31["unit5"];
				$unit6 = $sale_count1 * $objResult31["unit6"];
				$unit7 = $sale_count1 * $objResult31["unit7"];
				$unit8 = $sale_count1 * $objResult31["unit8"];
				$unit9 = $sale_count1 * $objResult31["unit9"];
				$unit10 = $sale_count1 * $objResult31["unit10"];

				if ($id_product1 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit1 . "','" . $unit1 . "','" . $product_price1 . "','" . $sum_amount1 . "','" . $sale_remarkk1 . "','" . $id_product1 . "','" . $id_product1 . "','" . $br_period1 . "','" . $warranty1 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product2 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','" . $sale_remarkk1 . "','" . $id_product2 . "','" . $id_product2 . "','" . $br_period1 . "','" . $warranty1 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product3 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','" . $sale_remarkk1 . "','" . $id_product3 . "','" . $id_product3 . "','" . $br_period1 . "','" . $warranty1 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product4 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','" . $sale_remarkk1 . "','" . $id_product4 . "','" . $id_product4 . "','" . $br_period1 . "','" . $warranty1 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product5 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','" . $sale_remarkk1 . "','" . $id_product5 . "','" . $id_product5 . "','" . $br_period1 . "','" . $warranty1 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product6 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','" . $sale_remarkk1 . "','" . $id_product6 . "','" . $id_product6 . "','" . $br_period1 . "','" . $warranty1 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product7 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','" . $sale_remarkk1 . "','" . $id_product7 . "','" . $id_product7 . "','" . $br_period1 . "','" . $warranty1 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product8 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','" . $sale_remarkk1 . "','" . $id_product8 . "','" . $id_product8 . "','" . $br_period1 . "','" . $warranty1 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product9 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','" . $sale_remarkk1 . "','" . $id_product9 . "','" . $id_product9 . "','" . $br_period1 . "','" . $warranty1 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product10 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','" . $sale_remarkk1 . "','" . $id_product10 . "','" . $id_product10 . "','" . $br_period1 . "','" . $warranty1 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}
			} else {
				$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $sale_count1 . "','" . $sale_count1 . "','" . $product_price1 . "','" . $sum_amount1 . "','" . $sale_remarkk1 . "','" . $product_id1 . "','" . $product_id1 . "','" . $br_period1 . "','" . $warranty1 . "')";

				$objQuery1 = mysqli_query($conn, $strSQL1);
			}

			$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='" . $product_id1 . "' ";
			$qry = mysqli_query($conn, $sql);
			$rs = mysqli_fetch_assoc($qry);

			if ($rs["demo_ckk"] == '1') {
				$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='" . $product_id1 . "' ";
				$objQuery91 = mysqli_query($conn, $strSQL91);
			}
		}


		if ($product_id2 !== '') {

			$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code2 . "' ";
			$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
			$Num_Rows31 = mysqli_num_rows($objQuery31);
			$objResult31 = mysqli_fetch_array($objQuery31);

			if ($Num_Rows31 > 0) {

				$id_product1 = $objResult31["product_id1"];
				$id_product2 = $objResult31["product_id2"];
				$id_product3 = $objResult31["product_id3"];
				$id_product4 = $objResult31["product_id4"];
				$id_product5 = $objResult31["product_id5"];
				$id_product6 = $objResult31["product_id6"];
				$id_product7 = $objResult31["product_id7"];
				$id_product8 = $objResult31["product_id8"];
				$id_product9 = $objResult31["product_id9"];
				$id_product10 = $objResult31["product_id10"];

				$unit1 = $sale_count2 * $objResult31["unit1"];
				$unit2 = $sale_count2 * $objResult31["unit2"];
				$unit3 = $sale_count2 * $objResult31["unit3"];
				$unit4 = $sale_count2 * $objResult31["unit4"];
				$unit5 = $sale_count2 * $objResult31["unit5"];
				$unit6 = $sale_count2 * $objResult31["unit6"];
				$unit7 = $sale_count2 * $objResult31["unit7"];
				$unit8 = $sale_count2 * $objResult31["unit8"];
				$unit9 = $sale_count2 * $objResult31["unit9"];
				$unit10 = $sale_count2 * $objResult31["unit10"];

				if ($id_product1 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit1 . "','" . $unit1 . "','" . $product_price2 . "','" . $sum_amount2 . "','" . $sale_remarkk2 . "','" . $id_product1 . "','" . $id_product1 . "','" . $br_period2 . "','" . $warranty2 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product2 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','" . $sale_remarkk2 . "','" . $id_product2 . "','" . $id_product2 . "','" . $br_period2 . "','" . $warranty2 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product3 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','" . $sale_remarkk2 . "','" . $id_product3 . "','" . $id_product3 . "','" . $br_period2 . "','" . $warranty2 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product4 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','" . $sale_remarkk2 . "','" . $id_product4 . "','" . $id_product4 . "','" . $br_period2 . "','" . $warranty2 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product5 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','" . $sale_remarkk2 . "','" . $id_product5 . "','" . $id_product5 . "','" . $br_period2 . "','" . $warranty2 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product6 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','" . $sale_remarkk2 . "','" . $id_product6 . "','" . $id_product6 . "','" . $br_period2 . "','" . $warranty2 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product7 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','" . $sale_remarkk2 . "','" . $id_product7 . "','" . $id_product7 . "','" . $br_period2 . "','" . $warranty2 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product8 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','" . $sale_remarkk2 . "','" . $id_product8 . "','" . $id_product8 . "','" . $br_period2 . "','" . $warranty2 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product9 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','" . $sale_remarkk2 . "','" . $id_product9 . "','" . $id_product9 . "','" . $br_period2 . "','" . $warranty2 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product10 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','" . $sale_remarkk2 . "','" . $id_product10 . "','" . $id_product10 . "','" . $br_period2 . "','" . $warranty2 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}
			} else {

				$strSQL2 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $sale_count2 . "','" . $sale_count2 . "','" . $product_price2 . "','" . $sum_amount2 . "','" . $sale_remarkk2 . "','" . $product_id2 . "','" . $product_id2 . "','" . $br_period2 . "','" . $warranty2 . "')";
				$objQuery2 = mysqli_query($conn, $strSQL2);
			}

			$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='" . $product_id2 . "' ";
			$qry = mysqli_query($conn, $sql);
			$rs = mysqli_fetch_assoc($qry);

			if ($rs["demo_ckk"] == '1') {
				$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='" . $product_id2 . "' ";
				$objQuery91 = mysqli_query($conn, $strSQL91);
			}
		}


		if ($product_id3 !== '') {

			$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code3 . "' ";
			$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
			$Num_Rows31 = mysqli_num_rows($objQuery31);
			$objResult31 = mysqli_fetch_array($objQuery31);

			if ($Num_Rows31 > 0) {

				$id_product1 = $objResult31["product_id1"];
				$id_product2 = $objResult31["product_id2"];
				$id_product3 = $objResult31["product_id3"];
				$id_product4 = $objResult31["product_id4"];
				$id_product5 = $objResult31["product_id5"];
				$id_product6 = $objResult31["product_id6"];
				$id_product7 = $objResult31["product_id7"];
				$id_product8 = $objResult31["product_id8"];
				$id_product9 = $objResult31["product_id9"];
				$id_product10 = $objResult31["product_id10"];

				$unit1 = $sale_count3 * $objResult31["unit1"];
				$unit2 = $sale_count3 * $objResult31["unit2"];
				$unit3 = $sale_count3 * $objResult31["unit3"];
				$unit4 = $sale_count3 * $objResult31["unit4"];
				$unit5 = $sale_count3 * $objResult31["unit5"];
				$unit6 = $sale_count3 * $objResult31["unit6"];
				$unit7 = $sale_count3 * $objResult31["unit7"];
				$unit8 = $sale_count3 * $objResult31["unit8"];
				$unit9 = $sale_count3 * $objResult31["unit9"];
				$unit10 = $sale_count3 * $objResult31["unit10"];

				if ($id_product1 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit1 . "','" . $unit1 . "','" . $product_price3 . "','" . $sum_amount3 . "','" . $sale_remarkk3 . "','" . $id_product1 . "','" . $id_product1 . "','" . $br_period3 . "','" . $warranty3 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product2 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','" . $sale_remarkk3 . "','" . $id_product2 . "','" . $id_product2 . "','" . $br_period3 . "','" . $warranty3 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product3 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','" . $sale_remarkk3 . "','" . $id_product3 . "','" . $id_product3 . "','" . $br_period3 . "','" . $warranty3 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product4 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','" . $sale_remarkk3 . "','" . $id_product4 . "','" . $id_product4 . "','" . $br_period3 . "','" . $warranty3 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product5 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','" . $sale_remarkk3 . "','" . $id_product5 . "','" . $id_product5 . "','" . $br_period3 . "','" . $warranty3 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product6 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','" . $sale_remarkk3 . "','" . $id_product6 . "','" . $id_product6 . "','" . $br_period3 . "','" . $warranty3 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product7 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','" . $sale_remarkk3 . "','" . $id_product7 . "','" . $id_product7 . "','" . $br_period3 . "','" . $warranty3 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product8 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','" . $sale_remarkk3 . "','" . $id_product8 . "','" . $id_product8 . "','" . $br_period3 . "','" . $warranty3 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product9 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','" . $sale_remarkk3 . "','" . $id_product9 . "','" . $id_product9 . "','" . $br_period3 . "','" . $warranty3 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product10 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','" . $sale_remarkk3 . "','" . $id_product10 . "','" . $id_product10 . "','" . $br_period3 . "','" . $warranty3 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}
			} else {

				$strSQL3 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $sale_count3 . "','" . $sale_count3 . "','" . $product_price3 . "','" . $sum_amount3 . "','" . $sale_remarkk3 . "','" . $product_id3 . "','" . $product_id3 . "','" . $br_period3 . "','" . $warranty3 . "')";

				$objQuery3 = mysqli_query($conn, $strSQL3);
			}

			$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='" . $product_id3 . "' ";
			$qry = mysqli_query($conn, $sql);
			$rs = mysqli_fetch_assoc($qry);

			if ($rs["demo_ckk"] == '1') {
				$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='" . $product_id3 . "' ";
				$objQuery91 = mysqli_query($conn, $strSQL91);
			}
		}


		if ($product_id4 !== '') {

			$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code4 . "' ";
			$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
			$Num_Rows31 = mysqli_num_rows($objQuery31);
			$objResult31 = mysqli_fetch_array($objQuery31);

			if ($Num_Rows31 > 0) {

				$id_product1 = $objResult31["product_id1"];
				$id_product2 = $objResult31["product_id2"];
				$id_product3 = $objResult31["product_id3"];
				$id_product4 = $objResult31["product_id4"];
				$id_product5 = $objResult31["product_id5"];
				$id_product6 = $objResult31["product_id6"];
				$id_product7 = $objResult31["product_id7"];
				$id_product8 = $objResult31["product_id8"];
				$id_product9 = $objResult31["product_id9"];
				$id_product10 = $objResult31["product_id10"];

				$unit1 = $sale_count4 * $objResult31["unit1"];
				$unit2 = $sale_count4 * $objResult31["unit2"];
				$unit3 = $sale_count4 * $objResult31["unit3"];
				$unit4 = $sale_count4 * $objResult31["unit4"];
				$unit5 = $sale_count4 * $objResult31["unit5"];
				$unit6 = $sale_count4 * $objResult31["unit6"];
				$unit7 = $sale_count4 * $objResult31["unit7"];
				$unit8 = $sale_count4 * $objResult31["unit8"];
				$unit9 = $sale_count4 * $objResult31["unit9"];
				$unit10 = $sale_count4 * $objResult31["unit10"];

				if ($id_product1 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit1 . "','" . $unit1 . "','" . $product_price4 . "','" . $sum_amount4 . "','" . $sale_remarkk4 . "','" . $id_product1 . "','" . $id_product1 . "','" . $br_period4 . "','" . $warranty4 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product2 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','" . $sale_remarkk4 . "','" . $id_product2 . "','" . $id_product2 . "','" . $br_period4 . "','" . $warranty4 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product3 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','" . $sale_remarkk4 . "','" . $id_product3 . "','" . $id_product3 . "','" . $br_period4 . "','" . $warranty4 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product4 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','" . $sale_remarkk4 . "','" . $id_product4 . "','" . $id_product4 . "','" . $br_period4 . "','" . $warranty4 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product5 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','" . $sale_remarkk4 . "','" . $id_product5 . "','" . $id_product5 . "','" . $br_period4 . "','" . $warranty4 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product6 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','" . $sale_remarkk4 . "','" . $id_product6 . "','" . $id_product6 . "','" . $br_period4 . "','" . $warranty4 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product7 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','" . $sale_remarkk4 . "','" . $id_product7 . "','" . $id_product7 . "','" . $br_period4 . "','" . $warranty4 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product8 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','" . $sale_remarkk4 . "','" . $id_product8 . "','" . $id_product8 . "','" . $br_period4 . "','" . $warranty4 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product9 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','" . $sale_remarkk4 . "','" . $id_product9 . "','" . $id_product9 . "','" . $br_period4 . "','" . $warranty4 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product10 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','" . $sale_remarkk4 . "','" . $id_product10 . "','" . $id_product10 . "','" . $br_period4 . "','" . $warranty4 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}
			} else {


				$strSQL4 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $sale_count4 . "','" . $sale_count4 . "','" . $product_price4 . "','" . $sum_amount4 . "','" . $sale_remarkk4 . "','" . $product_id4 . "','" . $product_id4 . "','" . $br_period4 . "','" . $warranty4 . "')";
				$objQuery4 = mysqli_query($conn, $strSQL4);
			}

			$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='" . $product_id4 . "' ";
			$qry = mysqli_query($conn, $sql);
			$rs = mysqli_fetch_assoc($qry);

			if ($rs["demo_ckk"] == '1') {
				$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='" . $product_id4 . "' ";
				$objQuery91 = mysqli_query($conn, $strSQL91);
			}
		}


		if ($product_id5 !== '') {

			$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code5 . "' ";
			$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
			$Num_Rows31 = mysqli_num_rows($objQuery31);
			$objResult31 = mysqli_fetch_array($objQuery31);

			if ($Num_Rows31 > 0) {

				$id_product1 = $objResult31["product_id1"];
				$id_product2 = $objResult31["product_id2"];
				$id_product3 = $objResult31["product_id3"];
				$id_product4 = $objResult31["product_id4"];
				$id_product5 = $objResult31["product_id5"];
				$id_product6 = $objResult31["product_id6"];
				$id_product7 = $objResult31["product_id7"];
				$id_product8 = $objResult31["product_id8"];
				$id_product9 = $objResult31["product_id9"];
				$id_product10 = $objResult31["product_id10"];

				$unit1 = $sale_count5 * $objResult31["unit1"];
				$unit2 = $sale_count5 * $objResult31["unit2"];
				$unit3 = $sale_count5 * $objResult31["unit3"];
				$unit4 = $sale_count5 * $objResult31["unit4"];
				$unit5 = $sale_count5 * $objResult31["unit5"];
				$unit6 = $sale_count5 * $objResult31["unit6"];
				$unit7 = $sale_count5 * $objResult31["unit7"];
				$unit8 = $sale_count5 * $objResult31["unit8"];
				$unit9 = $sale_count5 * $objResult31["unit9"];
				$unit10 = $sale_count5 * $objResult31["unit10"];

				if ($id_product1 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit1 . "','" . $unit1 . "','" . $product_price5 . "','" . $sum_amount5 . "','" . $sale_remarkk5 . "','" . $id_product1 . "','" . $id_product1 . "','" . $br_period5 . "','" . $warranty5 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product2 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','" . $sale_remarkk5 . "','" . $id_product2 . "','" . $id_product2 . "','" . $br_period5 . "','" . $warranty5 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product3 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','" . $sale_remarkk5 . "','" . $id_product3 . "','" . $id_product3 . "','" . $br_period5 . "','" . $warranty5 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product4 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','" . $sale_remarkk5 . "','" . $id_product4 . "','" . $id_product4 . "','" . $br_period5 . "','" . $warranty5 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product5 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','" . $sale_remarkk5 . "','" . $id_product5 . "','" . $id_product5 . "','" . $br_period5 . "','" . $warranty5 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product6 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','" . $sale_remarkk5 . "','" . $id_product6 . "','" . $id_product6 . "','" . $br_period5 . "','" . $warranty5 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product7 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','" . $sale_remarkk5 . "','" . $id_product7 . "','" . $id_product7 . "','" . $br_period5 . "','" . $warranty5 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product8 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','" . $sale_remarkk5 . "','" . $id_product8 . "','" . $id_product8 . "','" . $br_period5 . "','" . $warranty5 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product9 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','" . $sale_remarkk5 . "','" . $id_product9 . "','" . $id_product9 . "','" . $br_period5 . "','" . $warranty5 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product10 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','" . $sale_remarkk5 . "','" . $id_product10 . "','" . $id_product10 . "','" . $br_period5 . "','" . $warranty5 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}
			} else {


				$strSQL5 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $sale_count5 . "','" . $sale_count5 . "','" . $product_price5 . "','" . $sum_amount5 . "','" . $sale_remarkk5 . "','" . $product_id5 . "','" . $product_id5 . "','" . $br_period5 . "','" . $warranty5 . "')";
				$objQuery5 = mysqli_query($conn, $strSQL5);
			}

			$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='" . $product_id5 . "' ";
			$qry = mysqli_query($conn, $sql);
			$rs = mysqli_fetch_assoc($qry);

			if ($rs["demo_ckk"] == '1') {
				$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='" . $product_id5 . "' ";
				$objQuery91 = mysqli_query($conn, $strSQL91);
			}
		}


		if ($product_id6 !== '') {

			$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code6 . "' ";
			$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
			$Num_Rows31 = mysqli_num_rows($objQuery31);
			$objResult31 = mysqli_fetch_array($objQuery31);

			if ($Num_Rows31 > 0) {

				$id_product1 = $objResult31["product_id1"];
				$id_product2 = $objResult31["product_id2"];
				$id_product3 = $objResult31["product_id3"];
				$id_product4 = $objResult31["product_id4"];
				$id_product5 = $objResult31["product_id5"];
				$id_product6 = $objResult31["product_id6"];
				$id_product7 = $objResult31["product_id7"];
				$id_product8 = $objResult31["product_id8"];
				$id_product9 = $objResult31["product_id9"];
				$id_product10 = $objResult31["product_id10"];

				$unit1 = $sale_count6 * $objResult31["unit1"];
				$unit2 = $sale_count6 * $objResult31["unit2"];
				$unit3 = $sale_count6 * $objResult31["unit3"];
				$unit4 = $sale_count6 * $objResult31["unit4"];
				$unit5 = $sale_count6 * $objResult31["unit5"];
				$unit6 = $sale_count6 * $objResult31["unit6"];
				$unit7 = $sale_count6 * $objResult31["unit7"];
				$unit8 = $sale_count6 * $objResult31["unit8"];
				$unit9 = $sale_count6 * $objResult31["unit9"];
				$unit10 = $sale_count6 * $objResult31["unit10"];

				if ($id_product1 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit1 . "','" . $unit1 . "','" . $product_price6 . "','" . $sum_amount6 . "','" . $sale_remarkk6 . "','" . $id_product1 . "','" . $id_product1 . "','" . $br_period6 . "','" . $warranty6 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product2 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','" . $sale_remarkk6 . "','" . $id_product2 . "','" . $id_product2 . "','" . $br_period6 . "','" . $warranty6 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product3 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','" . $sale_remarkk6 . "','" . $id_product3 . "','" . $id_product3 . "','" . $br_period6 . "','" . $warranty6 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product4 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','" . $sale_remarkk6 . "','" . $id_product4 . "','" . $id_product4 . "','" . $br_period6 . "','" . $warranty6 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product5 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','" . $sale_remarkk6 . "','" . $id_product5 . "','" . $id_product5 . "','" . $br_period6 . "','" . $warranty6 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product6 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','" . $sale_remarkk6 . "','" . $id_product6 . "','" . $id_product6 . "','" . $br_period6 . "','" . $warranty6 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product7 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','" . $sale_remarkk6 . "','" . $id_product7 . "','" . $id_product7 . "','" . $br_period6 . "','" . $warranty6 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product8 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','" . $sale_remarkk6 . "','" . $id_product8 . "','" . $id_product8 . "','" . $br_period6 . "','" . $warranty6 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product9 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','" . $sale_remarkk6 . "','" . $id_product9 . "','" . $id_product9 . "','" . $br_period6 . "','" . $warranty6 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product10 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','" . $sale_remarkk6 . "','" . $id_product10 . "','" . $id_product10 . "','" . $br_period6 . "','" . $warranty6 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}
			} else {


				$strSQL6 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $sale_count6 . "','" . $sale_count6 . "','" . $product_price6 . "','" . $sum_amount6 . "','" . $sale_remarkk6 . "','" . $product_id6 . "','" . $product_id6 . "','" . $br_period6 . "','" . $warranty6 . "')";
				$objQuery6 = mysqli_query($conn, $strSQL6);
			}

			$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='" . $product_id6 . "' ";
			$qry = mysqli_query($conn, $sql);
			$rs = mysqli_fetch_assoc($qry);

			if ($rs["demo_ckk"] == '1') {
				$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='" . $product_id6 . "' ";
				$objQuery91 = mysqli_query($conn, $strSQL91);
			}
		}


		if ($product_id7 !== '') {

			$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code7 . "' ";
			$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
			$Num_Rows31 = mysqli_num_rows($objQuery31);
			$objResult31 = mysqli_fetch_array($objQuery31);

			if ($Num_Rows31 > 0) {

				$id_product1 = $objResult31["product_id1"];
				$id_product2 = $objResult31["product_id2"];
				$id_product3 = $objResult31["product_id3"];
				$id_product4 = $objResult31["product_id4"];
				$id_product5 = $objResult31["product_id5"];
				$id_product6 = $objResult31["product_id6"];
				$id_product7 = $objResult31["product_id7"];
				$id_product8 = $objResult31["product_id8"];
				$id_product9 = $objResult31["product_id9"];
				$id_product10 = $objResult31["product_id10"];

				$unit1 = $sale_count7 * $objResult31["unit1"];
				$unit2 = $sale_count7 * $objResult31["unit2"];
				$unit3 = $sale_count7 * $objResult31["unit3"];
				$unit4 = $sale_count7 * $objResult31["unit4"];
				$unit5 = $sale_count7 * $objResult31["unit5"];
				$unit6 = $sale_count7 * $objResult31["unit6"];
				$unit7 = $sale_count7 * $objResult31["unit7"];
				$unit8 = $sale_count7 * $objResult31["unit8"];
				$unit9 = $sale_count7 * $objResult31["unit9"];
				$unit10 = $sale_count7 * $objResult31["unit10"];

				if ($id_product1 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit1 . "','" . $unit1 . "','" . $product_price7 . "','" . $sum_amount7 . "','" . $sale_remarkk7 . "','" . $id_product1 . "','" . $id_product1 . "','" . $br_period7 . "','" . $warranty7 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product2 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','" . $sale_remarkk7 . "','" . $id_product2 . "','" . $id_product2 . "','" . $br_period7 . "','" . $warranty7 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product3 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','" . $sale_remarkk7 . "','" . $id_product3 . "','" . $id_product3 . "','" . $br_period7 . "','" . $warranty7 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product4 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','" . $sale_remarkk7 . "','" . $id_product4 . "','" . $id_product4 . "','" . $br_period7 . "','" . $warranty7 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product5 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','" . $sale_remarkk7 . "','" . $id_product5 . "','" . $id_product5 . "','" . $br_period7 . "','" . $warranty7 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product6 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','" . $sale_remarkk7 . "','" . $id_product6 . "','" . $id_product6 . "','" . $br_period7 . "','" . $warranty7 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product7 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','" . $sale_remarkk7 . "','" . $id_product7 . "','" . $id_product7 . "','" . $br_period7 . "','" . $warranty7 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product8 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','" . $sale_remarkk7 . "','" . $id_product8 . "','" . $id_product8 . "','" . $br_period7 . "','" . $warranty7 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product9 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','" . $sale_remarkk7 . "','" . $id_product9 . "','" . $id_product9 . "','" . $br_period7 . "','" . $warranty7 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product10 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','" . $sale_remarkk7 . "','" . $id_product10 . "','" . $id_product10 . "','" . $br_period7 . "','" . $warranty7 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}
			} else {


				$strSQL7 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $sale_count7 . "','" . $sale_count7 . "','" . $product_price7 . "','" . $sum_amount7 . "','" . $sale_remarkk7 . "','" . $product_id7 . "','" . $product_id7 . "','" . $br_period7 . "','" . $warranty7 . "')";
				$objQuery7 = mysqli_query($conn, $strSQL7);
			}

			$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='" . $product_id7 . "' ";
			$qry = mysqli_query($conn, $sql);
			$rs = mysqli_fetch_assoc($qry);

			if ($rs["demo_ckk"] == '1') {
				$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='" . $product_id7 . "' ";
				$objQuery91 = mysqli_query($conn, $strSQL91);
			}
		}


		if ($product_id8 !== '') {

			$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code8 . "' ";
			$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
			$Num_Rows31 = mysqli_num_rows($objQuery31);
			$objResult31 = mysqli_fetch_array($objQuery31);

			if ($Num_Rows31 > 0) {

				$id_product1 = $objResult31["product_id1"];
				$id_product2 = $objResult31["product_id2"];
				$id_product3 = $objResult31["product_id3"];
				$id_product4 = $objResult31["product_id4"];
				$id_product5 = $objResult31["product_id5"];
				$id_product6 = $objResult31["product_id6"];
				$id_product7 = $objResult31["product_id7"];
				$id_product8 = $objResult31["product_id8"];
				$id_product9 = $objResult31["product_id9"];
				$id_product10 = $objResult31["product_id10"];

				$unit1 = $sale_count8 * $objResult31["unit1"];
				$unit2 = $sale_count8 * $objResult31["unit2"];
				$unit3 = $sale_count8 * $objResult31["unit3"];
				$unit4 = $sale_count8 * $objResult31["unit4"];
				$unit5 = $sale_count8 * $objResult31["unit5"];
				$unit6 = $sale_count8 * $objResult31["unit6"];
				$unit7 = $sale_count8 * $objResult31["unit7"];
				$unit8 = $sale_count8 * $objResult31["unit8"];
				$unit9 = $sale_count8 * $objResult31["unit9"];
				$unit10 = $sale_count8 * $objResult31["unit10"];

				if ($id_product1 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit1 . "','" . $unit1 . "','" . $product_price8 . "','" . $sum_amount8 . "','" . $sale_remarkk8 . "','" . $id_product1 . "','" . $id_product1 . "','" . $br_period8 . "','" . $warranty8 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product2 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','" . $sale_remarkk8 . "','" . $id_product2 . "','" . $id_product2 . "','" . $br_period8 . "','" . $warranty8 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product3 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','" . $sale_remarkk8 . "','" . $id_product3 . "','" . $id_product3 . "','" . $br_period8 . "','" . $warranty8 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product4 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','" . $sale_remarkk8 . "','" . $id_product4 . "','" . $id_product4 . "','" . $br_period8 . "','" . $warranty8 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product5 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','" . $sale_remarkk8 . "','" . $id_product5 . "','" . $id_product5 . "','" . $br_period8 . "','" . $warranty8 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product6 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','" . $sale_remarkk8 . "','" . $id_product6 . "','" . $id_product6 . "','" . $br_period8 . "','" . $warranty8 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product7 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','" . $sale_remarkk8 . "','" . $id_product7 . "','" . $id_product7 . "','" . $br_period8 . "','" . $warranty8 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product8 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','" . $sale_remarkk8 . "','" . $id_product8 . "','" . $id_product8 . "','" . $br_period8 . "','" . $warranty8 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product9 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','" . $sale_remarkk8 . "','" . $id_product9 . "','" . $id_product9 . "','" . $br_period8 . "','" . $warranty8 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product10 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','" . $sale_remarkk8 . "','" . $id_product10 . "','" . $id_product10 . "','" . $br_period8 . "','" . $warranty8 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}
			} else {

				$strSQL8 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $sale_count8 . "','" . $sale_count8 . "','" . $product_price8 . "','" . $sum_amount8 . "','" . $sale_remarkk8 . "','" . $product_id8 . "','" . $product_id8 . "','" . $br_period8 . "','" . $warranty8 . "')";
				$objQuery8 = mysqli_query($conn, $strSQL8);
			}

			$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='" . $product_id8 . "' ";
			$qry = mysqli_query($conn, $sql);
			$rs = mysqli_fetch_assoc($qry);

			if ($rs["demo_ckk"] == '1') {
				$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='" . $product_id8 . "' ";
				$objQuery91 = mysqli_query($conn, $strSQL91);
			}
		}

		// ช่อง 9 (มิเรอร์ช่อง 8 ทุกประการ — mirror ของ register_supbrhos1.php)
		if ($product_id9 !== '') {

			$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code9 . "' ";
			$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
			$Num_Rows31 = mysqli_num_rows($objQuery31);
			$objResult31 = mysqli_fetch_array($objQuery31);

			if ($Num_Rows31 > 0) {

				$id_product1 = $objResult31["product_id1"];
				$id_product2 = $objResult31["product_id2"];
				$id_product3 = $objResult31["product_id3"];
				$id_product4 = $objResult31["product_id4"];
				$id_product5 = $objResult31["product_id5"];
				$id_product6 = $objResult31["product_id6"];
				$id_product7 = $objResult31["product_id7"];
				$id_product8 = $objResult31["product_id8"];
				$id_product9 = $objResult31["product_id9"];
				$id_product10 = $objResult31["product_id10"];

				$unit1 = $sale_count9 * $objResult31["unit1"];
				$unit2 = $sale_count9 * $objResult31["unit2"];
				$unit3 = $sale_count9 * $objResult31["unit3"];
				$unit4 = $sale_count9 * $objResult31["unit4"];
				$unit5 = $sale_count9 * $objResult31["unit5"];
				$unit6 = $sale_count9 * $objResult31["unit6"];
				$unit7 = $sale_count9 * $objResult31["unit7"];
				$unit8 = $sale_count9 * $objResult31["unit8"];
				$unit9 = $sale_count9 * $objResult31["unit9"];
				$unit10 = $sale_count9 * $objResult31["unit10"];

				if ($id_product1 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit1 . "','" . $unit1 . "','" . $product_price9 . "','" . $sum_amount9 . "','" . $sale_remarkk9 . "','" . $id_product1 . "','" . $id_product1 . "','" . $br_period9 . "','" . $warranty9 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product2 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','" . $sale_remarkk9 . "','" . $id_product2 . "','" . $id_product2 . "','" . $br_period9 . "','" . $warranty9 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product3 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','" . $sale_remarkk9 . "','" . $id_product3 . "','" . $id_product3 . "','" . $br_period9 . "','" . $warranty9 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product4 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','" . $sale_remarkk9 . "','" . $id_product4 . "','" . $id_product4 . "','" . $br_period9 . "','" . $warranty9 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product5 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','" . $sale_remarkk9 . "','" . $id_product5 . "','" . $id_product5 . "','" . $br_period9 . "','" . $warranty9 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product6 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','" . $sale_remarkk9 . "','" . $id_product6 . "','" . $id_product6 . "','" . $br_period9 . "','" . $warranty9 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product7 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','" . $sale_remarkk9 . "','" . $id_product7 . "','" . $id_product7 . "','" . $br_period9 . "','" . $warranty9 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product8 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','" . $sale_remarkk9 . "','" . $id_product8 . "','" . $id_product8 . "','" . $br_period9 . "','" . $warranty9 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product9 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','" . $sale_remarkk9 . "','" . $id_product9 . "','" . $id_product9 . "','" . $br_period9 . "','" . $warranty9 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product10 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','" . $sale_remarkk9 . "','" . $id_product10 . "','" . $id_product10 . "','" . $br_period9 . "','" . $warranty9 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}
			} else {

				$strSQL9 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $sale_count9 . "','" . $sale_count9 . "','" . $product_price9 . "','" . $sum_amount9 . "','" . $sale_remarkk9 . "','" . $product_id9 . "','" . $product_id9 . "','" . $br_period9 . "','" . $warranty9 . "')";
				$objQuery9 = mysqli_query($conn, $strSQL9);
			}

			$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='" . $product_id9 . "' ";
			$qry = mysqli_query($conn, $sql);
			$rs = mysqli_fetch_assoc($qry);

			if ($rs["demo_ckk"] == '1') {
				$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='" . $product_id9 . "' ";
				$objQuery91 = mysqli_query($conn, $strSQL91);
			}
		}

		// ช่อง 10 (มิเรอร์ช่อง 8 ทุกประการ)
		if ($product_id10 !== '') {

			$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code10 . "' ";
			$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
			$Num_Rows31 = mysqli_num_rows($objQuery31);
			$objResult31 = mysqli_fetch_array($objQuery31);

			if ($Num_Rows31 > 0) {

				$id_product1 = $objResult31["product_id1"];
				$id_product2 = $objResult31["product_id2"];
				$id_product3 = $objResult31["product_id3"];
				$id_product4 = $objResult31["product_id4"];
				$id_product5 = $objResult31["product_id5"];
				$id_product6 = $objResult31["product_id6"];
				$id_product7 = $objResult31["product_id7"];
				$id_product8 = $objResult31["product_id8"];
				$id_product9 = $objResult31["product_id9"];
				$id_product10 = $objResult31["product_id10"];

				$unit1 = $sale_count10 * $objResult31["unit1"];
				$unit2 = $sale_count10 * $objResult31["unit2"];
				$unit3 = $sale_count10 * $objResult31["unit3"];
				$unit4 = $sale_count10 * $objResult31["unit4"];
				$unit5 = $sale_count10 * $objResult31["unit5"];
				$unit6 = $sale_count10 * $objResult31["unit6"];
				$unit7 = $sale_count10 * $objResult31["unit7"];
				$unit8 = $sale_count10 * $objResult31["unit8"];
				$unit9 = $sale_count10 * $objResult31["unit9"];
				$unit10 = $sale_count10 * $objResult31["unit10"];

				if ($id_product1 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit1 . "','" . $unit1 . "','" . $product_price10 . "','" . $sum_amount10 . "','" . $sale_remarkk10 . "','" . $id_product1 . "','" . $id_product1 . "','" . $br_period10 . "','" . $warranty10 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product2 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','" . $sale_remarkk10 . "','" . $id_product2 . "','" . $id_product2 . "','" . $br_period10 . "','" . $warranty10 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product3 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','" . $sale_remarkk10 . "','" . $id_product3 . "','" . $id_product3 . "','" . $br_period10 . "','" . $warranty10 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product4 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','" . $sale_remarkk10 . "','" . $id_product4 . "','" . $id_product4 . "','" . $br_period10 . "','" . $warranty10 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product5 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','" . $sale_remarkk10 . "','" . $id_product5 . "','" . $id_product5 . "','" . $br_period10 . "','" . $warranty10 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product6 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','" . $sale_remarkk10 . "','" . $id_product6 . "','" . $id_product6 . "','" . $br_period10 . "','" . $warranty10 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product7 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','" . $sale_remarkk10 . "','" . $id_product7 . "','" . $id_product7 . "','" . $br_period10 . "','" . $warranty10 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product8 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','" . $sale_remarkk10 . "','" . $id_product8 . "','" . $id_product8 . "','" . $br_period10 . "','" . $warranty10 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product9 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','" . $sale_remarkk10 . "','" . $id_product9 . "','" . $id_product9 . "','" . $br_period10 . "','" . $warranty10 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}

				if ($id_product10 != '') {
					$strSQL1 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','" . $sale_remarkk10 . "','" . $id_product10 . "','" . $id_product10 . "','" . $br_period10 . "','" . $warranty10 . "')";

					$objQuery1 = mysqli_query($conn, $strSQL1);
				}
			} else {

				$strSQL10 = "insert into hos__subbr
(ref_idd_br,count,countref,price,amount,sale_remark,product_id,product_code,br_periodd,warranty)
values ('" . $ref_id_br . "','" . $sale_count10 . "','" . $sale_count10 . "','" . $product_price10 . "','" . $sum_amount10 . "','" . $sale_remarkk10 . "','" . $product_id10 . "','" . $product_id10 . "','" . $br_period10 . "','" . $warranty10 . "')";
				$objQuery10 = mysqli_query($conn, $strSQL10);
			}

			$sql = "SELECT demo_ckk   FROM tb_product where product_ID ='" . $product_id10 . "' ";
			$qry = mysqli_query($conn, $sql);
			$rs = mysqli_fetch_assoc($qry);

			if ($rs["demo_ckk"] == '1') {
				$strSQL91 = "UPDATE tb_product SET sale_ckk = '0' where product_ID ='" . $product_id10 . "' ";
				$objQuery91 = mysqli_query($conn, $strSQL91);
			}
		}




		$start_date = mysqli_real_escape_string($conn, $_POST["start_date"]);

		$between_date = mysqli_real_escape_string($conn, $_POST["between_date"]);
		$start_time = mysqli_real_escape_string($conn, $_POST["start_time"]);
		$end_time = mysqli_real_escape_string($conn, $_POST["end_time"] ?? "");
		$status = mysqli_real_escape_string($conn, $_POST["status"]);

		if ($_POST["start_date"] != '') {
			$start_date = mysqli_real_escape_string($conn, $_POST["start_date"]);
		} else {
			$start_date = '0000-00-00';
		}

		if ($_POST['fix_datetime'] != '') {
			$fix_date = mysqli_real_escape_string($conn, $_POST['fix_datetime']);
		} else {
			$fix_date = '0';
		}

		if ($_POST['no_money'] != '') {
			$no_price = mysqli_real_escape_string($conn, $_POST['no_money']);
		} else {
			$no_price = '0';
		}
		if ($_POST['call_customer'] != '') {
			$call_customer = mysqli_real_escape_string($conn, $_POST['call_customer']);
		} else {
			$call_customer = '0';
		}
		if ($_POST['credit_card'] != '') {
			$credit = mysqli_real_escape_string($conn, $_POST['credit_card']);
		} else {
			$credit = '0';
		}
		if ($_POST['call_back'] != '') {
			$call_employee = mysqli_real_escape_string($conn, $_POST['call_back']);
		} else {
			$call_employee = '0';
		}

		if ($_POST['cash'] != '') {
			$chash = mysqli_real_escape_string($conn, $_POST['cash']);
		} else {
			$chash = '0';
		}
		if ($_POST['check_paper'] != '') {
			$check_peper = mysqli_real_escape_string($conn, $_POST['check_paper']);
		} else {
			$check_peper = '0';
		}
		if ($_POST['check_paper'] != '') {
			$check_peper = mysqli_real_escape_string($conn, $_POST['check_paper']);
		} else {
			$check_peper = '0';
		}
		if ($_POST['bill'] != '') {
			$bill = mysqli_real_escape_string($conn, $_POST['bill']);
		} else {
			$bill = '0';
		}
		if ($_POST['want_bus'] != '') {
			$want_bus = mysqli_real_escape_string($conn, $_POST['want_bus']);
		} else {
			$want_bus = '0';
		}
		if ($_POST['tran'] != '') {
			$tran = mysqli_real_escape_string($conn, $_POST["tran"]);
		} else {
			$tran = '0';
		}
		if ($_POST['more'] != '') {
			$check_detail = mysqli_real_escape_string($conn, $_POST["more"]);
		} else {
			$check_detail = '0';
		}

		if ($_POST['dep'] != '') {
			$dep = mysqli_real_escape_string($conn, $_POST["dep"]);
		} else {
			$dep = '0';
		}


		$department = mysqli_real_escape_string($conn, $_POST["department_name"]);
		$type_customer = mysqli_real_escape_string($conn, $_POST["customer_typename"]);

		if ($company == '1') {
			$type_company = 'ออลล์เวล ไลฟ์ บจก.';
		} else if ($company == '2') {
			$type_company = 'โนเบิล เมด บจก.';
		}

		$customer_name = mysqli_real_escape_string($conn, $_POST["customer_name"]);
		$customer_tel = mysqli_real_escape_string($conn, $_POST["customer_tel"]);
		$address_name = mysqli_real_escape_string($conn, $_POST["address_name"]);
		$address_send = mysqli_real_escape_string($conn, $_POST["address_send"]);
		$customer_contact = mysqli_real_escape_string($conn, $_POST["customer_contact"]);

		$on_time = mysqli_real_escape_string($conn, $_POST["on_time"]);
		$amphur_name = mysqli_real_escape_string($conn, $_POST["amphur_name"]);
		$province_name = mysqli_real_escape_string($conn, $_POST["province_name"]);
		$transport_company = mysqli_real_escape_string($conn, $_POST["transport_company"] ?? "");
		$location_link = mysqli_real_escape_string($conn, $_POST["location_link"] ?? "");

		// บันทึกที่อยู่ใหม่เข้าฐานข้อมูลของลูกค้ากรณีที่ปุ่ม "เพิ่มลงฐานลูกค้า" ถูกเลือกไว้ (mirror register_suphos1.php)
		$save_to_customer_db = isset($_POST['save_to_customer_db']) && $_POST['save_to_customer_db'] === '1';
		if ($save_to_customer_db && !empty($customer_id)) {
			$esc_customer_id = $customer_id;
			$esc_shipping_name = mysqli_real_escape_string($conn, $_POST['customer_name'] ?? '');
			$esc_shipping_tel = mysqli_real_escape_string($conn, $_POST['customer_tel'] ?? '');
			$esc_shipping_province = mysqli_real_escape_string($conn, $_POST['province_name'] ?? '');
			$esc_install_location = mysqli_real_escape_string($conn, $_POST['address_send'] ?? '');
			$esc_location_link = $location_link;

			// #address_name เก็บที่อยู่แบบรวมก้อน (address+ampher+province+postcode) ถ้าเอาไปใส่ shipping_address ตรง ๆ
			// พร้อมเซ็ต shipping_province ด้วย จะเกิดจังหวัดซ้ำและสะสมเพิ่มทุกรอบที่บันทึกซ้ำ
			// จึงใช้ส่วนประกอบดิบจาก hidden field แทนเมื่อมี (กรณีเลือกจาก popup / auto-fill จากลูกค้า)
			// ถ้าไม่มี (ผู้ใช้พิมพ์ที่อยู่เอง) ค่อย fallback ไปใช้ address_name ทั้งก้อนโดยไม่เซ็ต ampher/postcode
			$rawAddress = trim($_POST['shipping_address_raw'] ?? '');
			$hasRawAddress = ($rawAddress !== '');
			$esc_shipping_address = mysqli_real_escape_string($conn, $hasRawAddress ? $rawAddress : ($_POST['address_name'] ?? ''));
			$esc_shipping_ampher = $hasRawAddress ? mysqli_real_escape_string($conn, $_POST['shipping_ampher'] ?? '') : '';
			$esc_shipping_postcode = $hasRawAddress ? mysqli_real_escape_string($conn, $_POST['shipping_postcode'] ?? '') : '';
			$now = date('Y-m-d H:i:s');

			// ตรวจสอบคอลัมน์ที่มีอยู่จริงในตาราง tb_customer_shipping_address ป้องกันกรณีคอลัมน์ไม่มีใน schema
			$col_check = mysqli_query($conn, "SHOW COLUMNS FROM tb_customer_shipping_address");
			$existing_cols = array();
			if ($col_check) {
				while ($col_row = mysqli_fetch_assoc($col_check)) {
					$existing_cols[] = strtolower($col_row['Field']);
				}
			}

			// กันสร้างที่อยู่ซ้ำเมื่อกดบันทึกหลายครั้งด้วยข้อมูลชุดเดิม (ตารางไม่มี unique constraint)
			$sql_dup_check = "SELECT id FROM tb_customer_shipping_address
			WHERE customer_id = '$esc_customer_id'
				AND shipping_name = '$esc_shipping_name'
				AND shipping_address = '$esc_shipping_address'
				AND shipping_tel = '$esc_shipping_tel'
			LIMIT 1";
			$dup_result = mysqli_query($conn, $sql_dup_check);
			$dup_row = $dup_result ? mysqli_fetch_assoc($dup_result) : null;

			if ($dup_row) {
				$_POST["shipping_id"] = $dup_row['id'];
			} else {
				// shipping_index เป็นลำดับที่อยู่ของลูกค้าแต่ละราย (คอลัมน์ NOT NULL DEFAULT 1)
				// ถ้าไม่เซ็ตเองทุกแถวจะได้ 1 หมด ทำให้ลำดับใช้งานไม่ได้
				$next_index = 1;
				$idx_result = mysqli_query($conn, "SELECT COALESCE(MAX(shipping_index), 0) + 1 AS next_index
				FROM tb_customer_shipping_address WHERE customer_id = '$esc_customer_id'");
				if ($idx_result && ($idx_row = mysqli_fetch_assoc($idx_result))) {
					$next_index = (int)$idx_row['next_index'];
				}

				$insert_fields = array(
					'customer_id' => "'$esc_customer_id'",
					'shipping_index' => "'$next_index'",
					'shipping_preface_name' => "''",
					'shipping_name' => "'$esc_shipping_name'",
					'shipping_address' => "'$esc_shipping_address'",
					'shipping_ampher' => "'$esc_shipping_ampher'",
					'shipping_province' => "'$esc_shipping_province'",
					'shipping_postcode' => "'$esc_shipping_postcode'",
					'shipping_tel' => "'$esc_shipping_tel'",
					'created_at' => "'$now'",
					'updated_at' => "'$now'"
				);

				if (in_array('install_location', $existing_cols)) {
					$insert_fields['install_location'] = "'$esc_install_location'";
				}
				if (in_array('location_link', $existing_cols)) {
					$insert_fields['location_link'] = "'$esc_location_link'";
				}

				$insert_cols_str = implode(', ', array_keys($insert_fields));
				$insert_vals_str = implode(', ', array_values($insert_fields));

				$sql_insert_ship = "INSERT INTO tb_customer_shipping_address ($insert_cols_str) VALUES ($insert_vals_str)";
				if (mysqli_query($conn, $sql_insert_ship)) {
					$_POST["shipping_id"] = mysqli_insert_id($conn);
				}
			}
		}
		// shipping_id เป็น reference ไปยัง record ในตารางที่อยู่จัดส่ง ปัจจุบัน tb_register_data ยังไม่มีคอลัมน์นี้จริง
		// (ดู conditional check ก่อน INSERT tb_register_data ด้านล่าง) จึงเตรียมค่าไว้ล่วงหน้าตาม pattern เดียวกับ register_suphos1.php
		$shipping_id = isset($_POST["shipping_id"]) && $_POST["shipping_id"] !== '' ? $_POST["shipping_id"] : 0;

		$product_name = "ส่ง $product_name1 $sale_remarkk1  $sale_count1 $unit_name1 $product_name2 $sale_remarkk2 $sale_count2 $unit_name2 $product_name3 $sale_remarkk3 $sale_count3 $unit_name3 $product_name4 $sale_remarkk4 $sale_count4 $unit_name4  $product_name5 $sale_remarkk5 $sale_count5 $unit_name5  $product_name6 $sale_remarkk6 $sale_count6 $unit_name6 $product_name7 $sale_remarkk7 $sale_count7 $unit_name7 $product_name8 $sale_remarkk8 $sale_count8 $unit_name8 $product_name9 $sale_remarkk9 $sale_count9 $unit_name9 $product_name10 $sale_remarkk10 $sale_count10 $unit_name10 $address_name";

		$product_sn = mysqli_real_escape_string($conn, $_POST["product_sn"]);
		$unit_credit = mysqli_real_escape_string($conn, $_POST["unit_credit"]);
		$price = mysqli_real_escape_string($conn, $_POST["unit_cash"]);
		$employee_name = mysqli_real_escape_string($conn, $_POST["employee_name"]);
		$employee_tel = mysqli_real_escape_string($conn, $_POST["employee_tel"]);
		$add_by = mysqli_real_escape_string($conn, $_POST["add_by"]);
		$description = mysqli_real_escape_string($conn, $_POST["sale_comment"]);
		$havemap = mysqli_real_escape_string($conn, $_POST['have_map']);
		$unit_check = mysqli_real_escape_string($conn, $_POST["unit_check"]);
		$unit_bill = mysqli_real_escape_string($conn, $_POST["unit_bill"]);
		$unit_tran = mysqli_real_escape_string($conn, $_POST["unit_tran"]);
		$department_show = mysqli_real_escape_string($conn, $_POST["department_show"]);
		$unit_check1 = str_replace(',', '', $unit_check);
		$unit_bill1 = str_replace(',', '', $unit_bill);
		$dept = mysqli_real_escape_string($conn, $_POST["dept"]);
		$status_comment = mysqli_real_escape_string($conn, $_POST["status_comment"]);
		// เดิม UI มีช่อง address_1 แยกต่างหาก แต่ถูกถอดออกไปแล้ว (ฟอร์มปัจจุบันมีแค่ address_name)
		// ก่อนหน้านี้ต้องพึ่ง JS mirror ค่าใส่ hidden field ก่อน submit ทุกครั้ง ย้ายมา fallback ที่ backend แทน
		// เพื่อไม่ให้ผูกกับ JS ต้องรันถูกต้อง และกัน undefined array key ถ้าไม่มีการส่ง address_1 มาเลย
		$address_1Raw = trim((string)($_POST["address_1"] ?? ''));
		if ($address_1Raw === '') {
			$address_1 = $address_name; // ใช้ค่าที่ escape ไว้แล้วจาก address_name ตรง ๆ
		} else {
			$address_1 = mysqli_real_escape_string($conn, $address_1Raw);
		}

		$registerDataColumns = "ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code,province_name,transport_company,location_link";
		$registerDataValues = "'" . $ref_id_br . "','" . $start_date . "','" . $between_date . "','" . $start_time . "','" . $end_time . "','" . $status . "','" . $fix_date . "','" . $no_price . "','" . $call_customer . "','" . $credit . "','" . $call_employee . "','" . $chash . "','" . $check_peper . "','" . $bill . "','" . $department . "','" . $type_customer . "','" . $type_company . "','" . $customer_name . "','" . $customer_tel . "','" . $address_name . "','" . $address_send . "','" . $want_bus . "','" . $product_name . "','" . $product_sn . "','" . $unit_credit . "','" . $price . "','" . $employee_name . "','" . $employee_tel . "','" . $add_by . "','" . $description . "','" . $havemap . "','$add_date','" . $unit_bill . "','" . $unit_check . "','" . $unit_tran . "','" . $tran . "','" . $check_detail . "','" . $dep . "','" . $dept . "','" . $department_show . "','" . $customer_contact . "','" . $status_comment . "','" . $on_time . "','" . $address_1 . "','" . $em_id . "','" . $province_name . "','" . $transport_company . "','" . $location_link . "'";

		// เพิ่ม shipping_id แบบมีเงื่อนไข เผื่อ schema เพิ่มคอลัมน์นี้ในอนาคต (mirror register_suphos1.php)
		$shippingColumnCheck = mysqli_query($conn, "SHOW COLUMNS FROM tb_register_data LIKE 'shipping_id'");
		if ($shippingColumnCheck && mysqli_num_rows($shippingColumnCheck) > 0) {
			$registerDataColumns .= ",shipping_id";
			$registerDataValues .= ",'" . $shipping_id . "'";
		}

		mysqli_query($conn, "DELETE FROM tb_register_data WHERE ref_id = '" . $ref_id_br . "'");
		$strSQL66 = "insert into tb_register_data ($registerDataColumns)

values($registerDataValues)";

		//echo $strSQL66;

		// เดิมใช้ or die() ซึ่งจบ request ทันทีด้วยข้อความ error ดิบ ๆ บนหน้าเปล่า
		// เปลี่ยนมาเก็บสถานะแทน เพื่อให้ผู้ใช้เห็นข้อความที่เข้าใจได้ตอนท้าย (ข้อมูลค้างครึ่งเหมือนเดิมจนกว่าจะทำ transaction)
		$objQuery66 = mysqli_query($conn, $strSQL66);
		if (!$objQuery66) {
			$saveOk = false;
			$saveFailures[] = 'tb_register_data: ' . mysqli_error($conn);
		}

		// ปุ่มอนุมัติ/ส่งกลับ/ไม่อนุมัติ ของ Sup + ผู้บริหาร (register_supbrhos.php รวม Flow ทั้งสองขั้นไว้หน้าเดียว) — ทำงานหลังบันทึกข้อมูลฟอร์มปกติเสร็จแล้ว
		// สถานะ "ส่งกลับ" ใช้คำไทยตรงกับที่ status_supbrhos.php (หน้ารายการ) เข้าใจอยู่แล้ว ต่างจากฝั่ง SO ที่ใช้คำอังกฤษ 'Returned'
		$brApproveAction = $_POST['approve_action'] ?? '';
		// 'sup' = ขั้น Sup อนุมัติ, 'dm' = ขั้นผู้บริหารอนุมัติ (โชว์เมื่อ send_dm='1' แล้ว, ดู register_supbrhos.php $brApproveStage)
		$brApproveStage = ($_POST['approve_stage'] ?? 'sup') === 'dm' ? 'dm' : 'sup';
		if ($brApproveAction !== '' && $qsave) {
			$brApproveName = mysqli_real_escape_string($conn, trim(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? '')));
			$brApproveCode = mysqli_real_escape_string($conn, $_SESSION['code'] ?? '');
			$brApproveDateVal = date('Y-m-d');
			$brApproveTimeVal = date('H:i:s');
			$brDmDateVal = date('Y-m-d H:i:s');

			if ($brApproveAction === 'return') {
				mysqli_query($conn, "UPDATE hos__br SET status_doc='ส่งกลับ', send_sup='0', send_dm='0', send_admin='0' WHERE ref_id_br='" . $ref_id_br . "'");
			} elseif ($brApproveAction === 'reject' && $brApproveStage === 'dm') {
				// ผู้บริหารไม่อนุมัติ (mirror ของ dmbrhos_rejected.php)
				mysqli_query($conn, "UPDATE hos__br SET status_doc='Rejected', dm_name='" . $brApproveName . "', dm_date='" . $brDmDateVal . "' WHERE ref_id_br='" . $ref_id_br . "'");
			} elseif ($brApproveAction === 'reject') {
				mysqli_query($conn, "UPDATE hos__br SET status_doc='Rejected', approve='" . $brApproveName . "', approve_code='" . $brApproveCode . "', approve_date='" . $brApproveDateVal . "', approve_time='" . $brApproveTimeVal . "' WHERE ref_id_br='" . $ref_id_br . "'");
			} elseif ($brApproveAction === 'approve' && $brApproveStage === 'dm') {
				// ผู้บริหารอนุมัติ (mirror ของ dmbrhos_approve.php)
				mysqli_query($conn, "UPDATE hos__br SET status_doc='Approve', dm_name='" . $brApproveName . "', dm_date='" . $brDmDateVal . "', send_admin='1' WHERE ref_id_br='" . $ref_id_br . "'");
			} elseif ($brApproveAction === 'approve') {
				// วัตถุประสงค์ 'สินค้าออกบูธ' (objective='7') ต้องผ่านผู้บริหารอนุมัติต่อ (mirror ของ brhos_approve.php/send_bradmin.php)
				if ($objective === '7') {
					mysqli_query($conn, "UPDATE hos__br SET status_doc='Request', approve='" . $brApproveName . "', approve_code='" . $brApproveCode . "', approve_date='" . $brApproveDateVal . "', approve_time='" . $brApproveTimeVal . "', send_dm='1', send_admin='0' WHERE ref_id_br='" . $ref_id_br . "'");
				} else {
					mysqli_query($conn, "UPDATE hos__br SET status_doc='Approve', approve='" . $brApproveName . "', approve_code='" . $brApproveCode . "', approve_date='" . $brApproveDateVal . "', approve_time='" . $brApproveTimeVal . "', send_admin='1' WHERE ref_id_br='" . $ref_id_br . "'");
				}
			}
		}

		if ($qsave && tableExists($conn, 'tb_document_status_log')) {
			$brLogUserId = mysqli_real_escape_string($conn, $_SESSION['UserID'] ?? '');
			$brLogUserName = mysqli_real_escape_string($conn, trim(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? '')));
			$brApproveReason = trim((string)($_POST['br_approve_reason'] ?? ''));
			$brApproveStatusMap = array(
				'return' => 'ส่งกลับ',
				'reject' => 'Rejected'
			);

			if (isset($brApproveStatusMap[$brApproveAction]) && $brApproveReason !== '') {
				mysqli_query($conn, "INSERT INTO tb_document_status_log (ref_id, status_doc, reason, user_id, user_name)
				VALUES ('" . $ref_id_br . "', '" . $brApproveStatusMap[$brApproveAction] . "', '"
					. mysqli_real_escape_string($conn, $brApproveReason) . "', '"
					. $brLogUserId . "', '"
					. $brLogUserName . "')");
			}

			$brCancelReason = trim((string)($_POST['admin_cancel_reason'] ?? ''));
			if ($brCancelReason === '') {
				$brCancelReason = $brApproveReason;
			}
			if ($cancelDocPost === '1' && $brCancelReason !== '') {
				mysqli_query($conn, "INSERT INTO tb_document_status_log (ref_id, status_doc, reason, user_id, user_name)
				VALUES ('" . $ref_id_br . "', 'ยกเลิก', '"
					. mysqli_real_escape_string($conn, $brCancelReason) . "', '"
					. $brLogUserId . "', '"
					. $brLogUserName . "')");
			}
		}









		// Create product checklist records only for real update, inside the same transaction.
		if ($isDraftRequest === false) {
			createBrProductChecklists($conn, $ref_id_br);
		}
	} catch (mysqli_sql_exception $e) {
		$saveOk = false;
		$saveFailures[] = $e->getMessage();
	}

	if ($saveOk) {
		mysqli_commit($conn);
		if ($isDraftRequest) {
			if (ob_get_level() > 0) {
				ob_end_clean();
			}
			echo json_encode(array(
				'success' => true,
				'ref_id' => $ref_id_br,
				'message' => 'Draft updated'
			));
			exit();
		}

		// true PRG: ล้าง buffer (ที่มี HTML จาก head.php ค้างอยู่) แล้วส่ง redirect จริงระดับ HTTP
		// แทน JS-redirect เดิม เพื่อไม่ให้ browser ถือว่าหน้านี้เป็น "response ของ POST" ที่ reload แล้วเสี่ยงถามซ้ำ
		// ข้อความ "บันทึกสำเร็จ" ย้ายไปแสดงที่ปลายทาง (register_supbrhos_edit.php) ผ่าน query param saved=1
		if (ob_get_level() > 0) {
			ob_end_clean();
		}
		header('Location: register_supbrhos.php?ref_id_br=' . rawurlencode($ref_id_br) . '&saved=1');
		exit();
	} else {
		mysqli_rollback($conn);

		// แสดงสาเหตุจริงแทนคำว่า "Cannot" ลอย ๆ เพื่อให้ตามปัญหาได้
		// exception อาจเกิดก่อนที่ $ref_id_br จะถูกสร้าง จึงต้อง guard ไว้
		$failureRefId = isset($ref_id_br) ? $ref_id_br : '-';
		$failureText = implode("\\n", array_map(function ($msg) {
			return str_replace(array("\\", "'", "\r", "\n"), array("\\\\", "\\'", " ", " "), $msg);
		}, $saveFailures));
		if (ob_get_level() > 0) {
			ob_end_clean();
		}

		if ($isDraftRequest) {
			echo json_encode(array(
				'success' => false,
				'message' => 'Unable to save draft (เอกสาร ' . $failureRefId . '): ' . implode(' / ', $saveFailures)
			));
			exit();
		}

		echo "<script language=\"JavaScript\">";
		echo "alert('บันทึกข้อมูลไม่สำเร็จ (เอกสาร $failureRefId)\\n\\n$failureText');history.back();";
		echo "</script>";
	}
}
