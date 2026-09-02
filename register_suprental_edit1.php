<?php
// เปิด output buffering ตั้งแต่ก่อน include head.php (ซึ่งส่ง HTML ออกทันที)
// เพื่อให้เรียก header('Location: ...') ได้จริงตอนบันทึกสำเร็จ (true POST-Redirect-GET)
// (pattern เดียวกับ register_suprental1.php ที่แก้ไว้แล้ว / register_supchange_edit1.php)
ob_start();
$isDraftRequest = isset($_POST["is_draft"]) && $_POST["is_draft"] === "1";
if (!$isDraftRequest) {
	include ("head.php");
} else {
	header('Content-Type: application/json; charset=utf-8');
}
?>


<?php
include("dbconnect.php");
include ("error_page.php");

date_default_timezone_set("Asia/Bangkok");

if (!function_exists('rt_abort_with_alert')) {
	function rt_abort_with_alert($message, $isDraftRequest = false)
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

if (!isset($_POST["submit"]) || $_POST["submit"] !== "submit") {
	rt_abort_with_alert('ไม่พบข้อมูลที่จะบันทึก', $isDraftRequest);
}

$ref_id = mysqli_real_escape_string($conn, $_POST["ref_id"] ?? '');
if ($ref_id === '') {
	rt_abort_with_alert('ไม่พบเลขที่อ้างอิง (ref_id)', $isDraftRequest);
}

$rentalExistsQuery = mysqli_query($conn, "SELECT ref_id FROM hos__rental WHERE ref_id = '" . $ref_id . "' LIMIT 1");
if (!$rentalExistsQuery || mysqli_num_rows($rentalExistsQuery) === 0) {
	rt_abort_with_alert('ไม่พบเอกสารนี้ในระบบ (ref_id: ' . $ref_id . ')', $isDraftRequest);
}

// ===== $_POST -> ตัวแปร (เหมือน register_suprental1.php ทุกประการ ยกเว้นไม่มีการ generate ref_id ใหม่) =====
$send_cs = $_POST["send_cs"] ?? '';
$type_doc = $_POST["type_doc"];
$register_date = $_POST["register_date"];
$rental_name = $_POST["rental_name"];
// connect_name/connect_tel ไม่มี input แยกสำหรับ hos__rental ในฟอร์มใหม่ ใช้ผู้ติดต่อจัดส่ง
// (customer_name/customer_tel ในแท็บที่อยู่จัดส่ง) แทน ใกล้เคียงความหมายที่สุด
// (mapping เดียวกับ register_suprental1.php)
$connect_name = $_POST["customer_name"] ?? '';
$start_promis = $_POST["start_promis"];
$install_date = $_POST["install_date"] ?? '';
$rental_address = $_POST["rental_address"];
$rental_id = $_POST["rental_id"];
$rental_tel = $_POST["rental_tel"];
$connect_tel = $_POST["customer_tel"] ?? '';
$bill_vat = $_POST["bill_vat"] ?? '';
$des_sale = $_POST["des_sale"];
// install_address ไม่มี input แยก ใช้สถานที่ติดตั้งเครื่อง (address_send) ที่ความหมายตรงกัน
$install_address = $_POST["address_send"] ?? '';
// bill_name/bill_tel/bill_address ไม่มีช่อง "ชื่อออกบิล" แยกในฟอร์มใหม่ ใช้ข้อมูลผู้เช่าแทน
$bill_name = $rental_name;
$bill_tel = $rental_tel;
$bill_address = $rental_address;
$tax_no = $_POST["tax_no"] ?? '';
$payment = $_POST["payment"];
$patient_name = $_POST["patient_name"] ?? '';
$emergency_name = $_POST["emergency_name"] ?? '';
$emergency_tel = $_POST["emergency_tel"] ?? '';
$count_m = $_POST["count_m"];
$unit = "month";
$wdff = "$count_m $unit";
$end_promis = date("Y-m-d", strtotime($wdff, strtotime($start_promis)));
$delivery_type = $_POST["delivery_type"];
$delivery_date = $_POST["start_date"];
$delivery_key = $_POST["between_date"];
$sale_code = $_POST['sale_code'];

$type_product_map = ['สินค้าเตียง' => 1, 'สินค้าที่นอน' => 2, 'สินค้าอื่นๆ' => 3];
$type_product = $type_product_map[$_POST['product_type_rental'] ?? ''] ?? 0;
$des_productunit = mysqli_real_escape_string($conn, $_POST['rental_item_name'] ?? '');
$have_order = isset($_POST['have_order']) ? 1 : 0;

// เลขที่ลงงาน (job_no) แก้ได้เฉพาะผ่านแท็บ Admin ตรง ๆ เหมือน iv_no — ไม่ re-run เครื่องออกเลขอัตโนมัติ
$job_no = mysqli_real_escape_string($conn, trim($_POST['rt_admin_work_no'] ?? ''));

$sr_no = mysqli_real_escape_string($conn, $_POST['rt_admin_sr_no'] ?? '');
$order_no = mysqli_real_escape_string($conn, $_POST['rt_admin_deposit_no'] ?? '');
$count_box = intval($_POST['rt_admin_box_count'] ?? 0);
$new_bill = intval($_POST['rt_admin_edit_count'] ?? 0);
$date_oldbill = !empty($_POST['rt_admin_doc_date_old']) ? $_POST['rt_admin_doc_date_old'] : '0000-00-00';
$desnew_bill = mysqli_real_escape_string($conn, $_POST['rt_admin_edit_reason'] ?? '');
$remark_cancel = mysqli_real_escape_string($conn, $_POST['rt_admin_cancel_reason'] ?? '');
$cancel_flag = intval($_POST['rt_admin_cancel_doc'] ?? 0);

// เลขที่เอกสาร (iv_no/iv_date) แก้ได้เฉพาะผ่านแท็บ Admin ตรง ๆ — ไม่ re-run เครื่องออกเลขอัตโนมัติ
// (tb_doc_rental/tb_promisno) ซ้ำทุกครั้งที่ update เหมือน register_suprental1.php ทำตอนสร้างใหม่
$iv_no = mysqli_real_escape_string($conn, $_POST['rt_admin_doc_no'] ?? '');
$iv_date = !empty($_POST['rt_admin_doc_date']) ? $_POST['rt_admin_doc_date'] : '0000-00-00';

$date_ker = !empty($_POST['shipping_date']) ? $_POST['shipping_date'] : '0000-00-00';
$order_refer_code = mysqli_real_escape_string($conn, $_POST['shipping_ref1'] ?? '');
$order_refer_code1 = mysqli_real_escape_string($conn, $_POST['shipping_ref2'] ?? '');
$ker_bath = floatval($_POST['shipping_cost'] ?? 0);

$rental_addr_detail = mysqli_real_escape_string($conn, $_POST['rental_addr_detail'] ?? '');
$rental_province = mysqli_real_escape_string($conn, $_POST['rental_province'] ?? '');
$rental_district = mysqli_real_escape_string($conn, $_POST['rental_district'] ?? '');
$rental_zipcode = mysqli_real_escape_string($conn, $_POST['rental_zipcode'] ?? '');
$rental_referrer = mysqli_real_escape_string($conn, $_POST['rental_referrer'] ?? '');
$rental_repeat_cus = isset($_POST['rental_repeat_cus']) ? 1 : 0;

$location_link = mysqli_real_escape_string($conn, $_POST['location_link'] ?? '');
$transport_company = mysqli_real_escape_string($conn, $_POST['transport_company'] ?? '');

$bank_name = $_POST["bank_name"];
$accbank_name = $_POST["accbank_name"];
$bank_no = $_POST["bank_no"];

// bank_img: ไม่อัปโหลดไฟล์ใหม่ = คงไฟล์เดิม (ต่างจาก register_suprental1.php ที่บังคับแนบไฟล์เสมอ)
$bank_img_existing = mysqli_real_escape_string($conn, $_POST['bank_img_existing'] ?? '');
if (!isset($_FILES['bank_img']) || $_FILES['bank_img']['size'] == 0) {
	$bank_img = $bank_img_existing;
} else if ($_FILES['bank_img']['size'] > 1100000) {
	rt_abort_with_alert('กรุณาแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB', $isDraftRequest);
} else {
	$temp = explode(".", $_FILES["bank_img"]["name"]);
	$bank_img = "bank_img" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp);
	move_uploaded_file($_FILES["bank_img"]["tmp_name"], "credit_no/" . $bank_img);
}

// สถานะเอกสาร/ส่งหัวหน้า — พอร์ตจาก register_supchange_edit1.php:185,232-239,309-317 (ไม่มีสาขา "ยกเลิก"
// เพราะ rental ใช้ cancel_flag/remark_cancel แยกจาก status_doc อยู่แล้ว ดู sql/suprental_optional_columns.sql:4-7)
$status_doc = $isDraftRequest ? "Draft" : "Request";
$rtName = trim(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? ''));
$rtNowDateTime = date('Y-m-d H:i:s');
// Save Draft/Update ธรรมดาต้องไม่แตะสถานะ/ส่งหัวหน้าเลย ไม่งั้นเอกสารที่ส่งไปแล้ว (Request) จะถูกดึงกลับ
// เป็น Draft เพียงเพราะผู้ใช้กดปุ่ม Update — ตั้งค่าเฉพาะตอน Submit จริงเท่านั้น
$rtSetStatusColumns = !$isDraftRequest;
if ($rtSetStatusColumns) {
	$send_sup_val = "1";
	$sup_name_val = mysqli_real_escape_string($conn, $rtName);
	$sup_date_val = $rtNowDateTime;
}

$saveOk = true;
$saveError = '';
mysqli_begin_transaction($conn);
try {

	// ===== ตารางหลัก (hos__rental) — UPDATE ไม่แตะ ref_id/add_date/add_by/sale_code (คงผู้สร้างเอกสารเดิมไว้) =====
	$save = "Update hos__rental set" . ($rtSetStatusColumns ? "
	status_doc='" . $status_doc . "',
	send_sup='" . $send_sup_val . "',
	sup_name='" . $sup_name_val . "',
	sup_date='" . $sup_date_val . "'," : "") . "
	type_doc='" . $type_doc . "',
	register_date='" . $register_date . "',
	rental_name='" . $rental_name . "',
	connect_name='" . $connect_name . "',
	start_promis='" . $start_promis . "',
	install_date='" . $install_date . "',
	rental_address='" . $rental_address . "',
	rental_id='" . $rental_id . "',
	rental_tel='" . $rental_tel . "',
	connect_tel='" . $connect_tel . "',
	end_promis='" . $end_promis . "',
	des_sale='" . $des_sale . "',
	install_address='" . $install_address . "',
	bill_name='" . $bill_name . "',
	bill_tel='" . $bill_tel . "',
	bill_address='" . $bill_address . "',
	tax_no='" . $tax_no . "',
	payment='" . $payment . "',
	patient_name='" . $patient_name . "',
	emergency_name='" . $emergency_name . "',
	emergency_tel='" . $emergency_tel . "',
	count_m='" . $count_m . "',
	unit_m='" . $unit . "',
	bill_vat='" . $bill_vat . "',
	delivery_type='" . $delivery_type . "',
	delivery_date='" . $delivery_date . "',
	delivery_key='" . $delivery_key . "',
	bank_name='" . $bank_name . "',
	accbank_name='" . $accbank_name . "',
	bank_no='" . $bank_no . "',
	bank_img='" . $bank_img . "',
	type_product='" . $type_product . "',
	des_productunit='" . $des_productunit . "',
	have_order='" . $have_order . "',
	iv_no='" . $iv_no . "',
	iv_date='" . $iv_date . "',
	job_no='" . $job_no . "',
	sr_no='" . $sr_no . "',
	order_no='" . $order_no . "',
	new_bill='" . $new_bill . "',
	date_oldbill='" . $date_oldbill . "',
	desnew_bill='" . $desnew_bill . "',
	remark_cancel='" . $remark_cancel . "',
	cancel_flag='" . $cancel_flag . "',
	date_ker='" . $date_ker . "',
	order_refer_code='" . $order_refer_code . "',
	order_refer_code1='" . $order_refer_code1 . "',
	ker_bath='" . $ker_bath . "',
	rental_addr_detail='" . $rental_addr_detail . "',
	rental_province='" . $rental_province . "',
	rental_district='" . $rental_district . "',
	rental_zipcode='" . $rental_zipcode . "',
	rental_referrer='" . $rental_referrer . "',
	rental_repeat_cus='" . $rental_repeat_cus . "'
	where ref_id = '" . $ref_id . "'";

	$objQuerySave = mysqli_query($conn, $save);
	if (!$objQuerySave) {
		$saveOk = false;
		$saveError = 'hos__rental: ' . mysqli_error($conn);
	}

	// ===== รายการสินค้า (hos__subrental) — DELETE แล้ว re-INSERT ใหม่ทั้งหมด กันบั๊ก insert ซ้ำ =====
	mysqli_query($conn, "DELETE FROM hos__subrental WHERE ref_idd = '" . $ref_id . "'");

	for ($rtEditI = 1; $rtEditI <= 10; $rtEditI++) {
		$rtEditProductId = $_POST["product_id" . $rtEditI] ?? '';
		if ($rtEditProductId === '') {
			continue;
		}
		$rtEditSaleCount = $_POST["sale_count" . $rtEditI] ?? '';
		$rtEditProductPrice = $_POST["product_price" . $rtEditI] ?? '';
		$rtEditSaleRemarkk = $_POST["sale_remarkk" . $rtEditI] ?? '';
		$rtEditSumAmount = str_replace(',', '', $_POST["sum_amount" . $rtEditI] ?? '');
		$rtEditSnNumber = $_POST["sn_number" . $rtEditI] ?? '';
		$rtEditDeliveryCost = $_POST["delivery_cost" . $rtEditI] ?? '';
		$rtEditFreeCount = $_POST["free_count" . $rtEditI] ?? '';
		$rtEditWarranty = $_POST["warranty" . $rtEditI] ?? '';
		$rtEditDisplayName = $_POST["display_name" . $rtEditI] ?? '';

		$strSQLSub = "insert into hos__subrental
		(ref_idd,product_id,product_code,count,sn_number,price,amount,remark_sale,warranty,delivery_cost,free_count,display_name)
		values ('" . $ref_id . "','" . $rtEditProductId . "','" . $rtEditProductId . "','" . $rtEditSaleCount . "','" . $rtEditSnNumber . "','" . $rtEditProductPrice . "','" . $rtEditSumAmount . "','" . $rtEditSaleRemarkk . "','" . $rtEditWarranty . "','" . $rtEditDeliveryCost . "','" . $rtEditFreeCount . "','" . $rtEditDisplayName . "')";
		mysqli_query($conn, $strSQLSub);

		mysqli_query($conn, "UPDATE tb_product SET close_pro = '1' where product_ID ='" . $rtEditProductId . "' ");
	}

	// ===== สร้าง checklist สินค้า (tb_product_checklist ฯลฯ) ถ้ายังไม่เคยมีของ ref_id นี้ =====
	// พอร์ตจาก register_suprental1.php แบบคำต่อคำ — มี guard ในตัว (บรรทัด "ref_id"!='' ด้านล่าง)
	// จึงรันซ้ำได้อย่างปลอดภัยตอน edit ไม่สร้างซ้ำ
	$strSQL1 = "SELECT * FROM  (hos__subrental LEFT JOIN tb_product ON hos__subrental.product_ID=tb_product.product_id) WHERE ref_idd = '" . $ref_id . "' ";
	$objQuery1 = mysqli_query($conn, $strSQL1);
	if ($objQuery1) {
		while ($objResult1 = mysqli_fetch_array($objQuery1)) {
			$strSQL2 = "SELECT product_code,count  FROM hos__subrental where ref_idd = '" . $ref_id . "' and product_code ='" . $objResult1["product_code"] . "' and ckk_pro='0'";
			$objQuery2 = mysqli_query($conn, $strSQL2);
			$Num_Rows2 = $objQuery2 ? mysqli_num_rows($objQuery2) : 0;
			$objResult2 = $objQuery2 ? mysqli_fetch_array($objQuery2) : [];

			if ($Num_Rows2 > 0) {
				$strSQL3 = "SELECT * FROM  tb_product_checklist  WHERE ref_id = '" . $ref_id . "'";
				$objQuery3 = mysqli_query($conn, $strSQL3);
				$objResult3 = $objQuery3 ? (mysqli_fetch_array($objQuery3) ?: []) : [];

				$strSQLreb = "SELECT * FROM tb_product_rental where product_id ='" . $objResult1["product_code"] . "'";
				$objQueryreb = mysqli_query($conn, $strSQLreb);
				$objResultreb = $objQueryreb ? (mysqli_fetch_array($objQueryreb) ?: []) : [];

				if (($objResult3["ref_id"] ?? '') != '') {
					// มี checklist อยู่แล้ว ไม่สร้างซ้ำ
				} else {
					$save99 = "insert into tb_product_rentalref
					(ref_idrt,product_id,sn_number,list_des1,list_des2,list_des3,list_des4,list_des5,list_des6,list_des7,list_des8,list_des9,list_des10,list_des11,list_des12,list_des13,list_des14,list_des15,list_des16)
					values
					('" . $ref_id . "','" . $objResult1["product_code"] . "','" . ($objResultreb["sn_number"] ?? '') . "','" . ($objResultreb["list_des1"] ?? '') . "','" . ($objResultreb["list_des2"] ?? '') . "','" . ($objResultreb["list_des3"] ?? '') . "','" . ($objResultreb["list_des4"] ?? '') . "','" . ($objResultreb["list_des5"] ?? '') . "','" . ($objResultreb["list_des6"] ?? '') . "','" . ($objResultreb["list_des7"] ?? '') . "','" . ($objResultreb["list_des8"] ?? '') . "','" . ($objResultreb["list_des9"] ?? '') . "','" . ($objResultreb["list_des10"] ?? '') . "','" . ($objResultreb["list_des11"] ?? '') . "','" . ($objResultreb["list_des12"] ?? '') . "','" . ($objResultreb["list_des13"] ?? '') . "','" . ($objResultreb["list_des14"] ?? '') . "','" . ($objResultreb["list_des15"] ?? '') . "','" . ($objResultreb["list_des16"] ?? '') . "')";
					mysqli_query($conn, $save99);

					$product_id = $objResult1["product_code"];
					$count = str_replace('.00', '', $objResult2["count"] ?? '');
					$rtEditChecklistAddDate = date('Y-m-d H:i:s');
					$rtEditChecklistAddBy = trim(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? ''));

					$strDate = date('Y-m-d');
					$strYear = date("Y", strtotime($strDate)) + 543;
					$strYear1 = substr($strYear, 2, 2);

					$yearMonth = substr(date("Y") + 543, -2) . date("m");
					$sql = "SELECT MAX(ref_pc) AS MAXID FROM tb_product_checklist where head_pc='DO'";
					$qry = mysqli_query($conn, $sql);
					$rs = mysqli_fetch_assoc($qry);
					$maxId = substr($rs['MAXID'] ?? '', -4);
					$maxId3 = substr($rs['MAXID'] ?? '', -8);
					$maxId1 = substr($maxId3, 0, -4);

					if ($maxId1 == $yearMonth) {
						$maxId1 = ($maxId + 1);
						$maxId2 = substr("00000" . $maxId1, -4);
						$nextId = $yearMonth . $maxId2;
					} else {
						$maxId1 = "0001";
						$nextId = $yearMonth . $maxId1;
					}

					$so = "DO";
					$ref_pc = "$so$nextId";

					$save99 = "insert into tb_product_checklist
					(ref_pc,doc_no,year_no,ref_id,product_id,add_date,add_by,date_create,head_pc,sn)
					values
					('" . $ref_pc . "','" . $ref_pc . "','" . $strYear1 . "','" . $ref_id . "','" . $product_id . "','" . $rtEditChecklistAddDate . "','" . $rtEditChecklistAddBy . "','" . $strDate . "','" . $so . "','" . ($objResultreb["sn_number"] ?? '') . "')";
					mysqli_query($conn, $save99);

					mysqli_query($conn, "insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('" . $ref_pc . "','ST','1')");
					mysqli_query($conn, "insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('" . $ref_pc . "','EN','1')");
					mysqli_query($conn, "insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('" . $ref_pc . "','CS','1')");
					mysqli_query($conn, "insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('" . $ref_pc . "','CS','2')");
					mysqli_query($conn, "insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('" . $ref_pc . "','EN','2')");
					mysqli_query($conn, "insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('" . $ref_pc . "','ST','2')");
				}
			}
		}
	}

	mysqli_query($conn, "Update hos__subrental set ckk_pro='1' Where ref_idd = '" . $ref_id . "'");

	// ===== ข้อมูลการจัดส่ง (tb_register_data) — DELETE แล้ว re-INSERT ใหม่ =====
	$start_date = (isset($_POST["start_date"]) && $_POST["start_date"] != '') ? $_POST["start_date"] : '0000-00-00';
	$between_date = $_POST["between_date"] ?? '';
	$start_time = $_POST["start_time"] ?? '';
	$end_time = $_POST["end_time"] ?? '';
	$status = $_POST["status"] ?? '';
	$fix_date = (isset($_POST['fix_datetime']) && $_POST['fix_datetime'] != '') ? $_POST['fix_datetime'] : '0';
	$no_price = (isset($_POST['no_money']) && $_POST['no_money'] != '') ? $_POST['no_money'] : '0';
	$call_customer = (isset($_POST['call_customer']) && $_POST['call_customer'] != '') ? $_POST['call_customer'] : '0';
	$credit = (isset($_POST['credit_card']) && $_POST['credit_card'] != '') ? $_POST['credit_card'] : '0';
	$unit_credit = $_POST["unit_credit"] ?? '';
	$want_bus = (isset($_POST['want_bus']) && $_POST['want_bus'] != '') ? $_POST['want_bus'] : '0';
	$call_employee = (isset($_POST['call_back']) && $_POST['call_back'] != '') ? $_POST['call_back'] : '0';
	$chash = (isset($_POST['cash']) && $_POST['cash'] != '') ? $_POST['cash'] : '0';
	$price = $_POST["unit_cash"] ?? '';
	$check_peper = (isset($_POST['check_paper']) && $_POST['check_paper'] != '') ? $_POST['check_paper'] : '0';
	$unit_check1 = $_POST["unit_check"] ?? '';
	$bill = (isset($_POST['bill']) && $_POST['bill'] != '') ? $_POST['bill'] : '0';
	$unit_bill1 = $_POST["unit_bill"] ?? '';
	$tran = (isset($_POST['tran']) && $_POST['tran'] != '') ? $_POST["tran"] : '0';
	$unit_tran = $_POST["unit_tran"] ?? '';
	$dep = (isset($_POST['dep']) && $_POST['dep'] != '') ? $_POST["dep"] : '0';

	$department = $_POST["department_name"] ?? '';
	$type_customer = $_POST["customer_typename"] ?? '';
	if ($type_doc == '3') {
		$type_company = 'ออลล์เวล ไลฟ์ บจก.';
	} else if ($type_doc == '4') {
		$type_company = 'โนเบิล เมด บจก.';
	} else {
		$type_company = '';
	}

	$province_name = $_POST["province_name"];
	$customer_name = $_POST["customer_name"];
	$customer_tel = $_POST["customer_tel"];
	$address_name = $_POST["address_name"];
	$address_1 = $_POST["address_1"];
	$address_send = $_POST["address_send"];

	// ===== เพิ่มที่อยู่ลงฐานข้อมูลลูกค้า (tb_customer_shipping_address) เมื่อกดปุ่ม "เพิ่มลงฐานลูกค้า" =====
	// พอร์ตจาก register_suprental1.php (เพิ่มไว้แล้ว) / register_supbrcshos1.php:652-731
	$save_to_customer_db = isset($_POST['save_to_customer_db']) && $_POST['save_to_customer_db'] === '1';
	if ($save_to_customer_db && !empty($rental_id)) {
		$esc_customer_id = mysqli_real_escape_string($conn, $rental_id);
		$esc_shipping_name = mysqli_real_escape_string($conn, $customer_name);
		$esc_shipping_tel = mysqli_real_escape_string($conn, $customer_tel);
		$esc_shipping_province = mysqli_real_escape_string($conn, $province_name);
		$esc_shipping_address = mysqli_real_escape_string($conn, $address_name);
		$esc_shipping_ampher = '';
		$esc_shipping_postcode = '';
		$esc_install_location = mysqli_real_escape_string($conn, $address_send);
		$esc_location_link = $location_link;
		$now = date('Y-m-d H:i:s');

		$col_check = mysqli_query($conn, "SHOW COLUMNS FROM tb_customer_shipping_address");
		$existing_cols = array();
		if ($col_check) {
			while ($col_row = mysqli_fetch_assoc($col_check)) {
				$existing_cols[] = strtolower($col_row['Field']);
			}
		}

		$sql_dup_check = "SELECT id FROM tb_customer_shipping_address
			WHERE customer_id = '$esc_customer_id'
				AND shipping_name = '$esc_shipping_name'
				AND shipping_address = '$esc_shipping_address'
				AND shipping_tel = '$esc_shipping_tel'
			LIMIT 1";
		$dup_result = mysqli_query($conn, $sql_dup_check);
		$dup_row = $dup_result ? mysqli_fetch_assoc($dup_result) : null;

		if (!$dup_row) {
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

			mysqli_query($conn, "INSERT INTO tb_customer_shipping_address ($insert_cols_str) VALUES ($insert_vals_str)");
		}
	}

	$customer_contact = $_POST["customer_contact"] ?? '';
	$mk_research = $_POST["mk_research"] ?? '';
	$on_time = $_POST["on_time"] ?? '';

	$product_sn = "เลขที่เอกสาร " . ($iv_no !== '' ? $iv_no : '-');
	$product_name = mysqli_real_escape_string($conn, "ส่ง " . $des_productunit);

	$employee_name = $_POST["employee_name"] ?? '';
	$employee_tel = $_POST["employee_tel"] ?? '';
	$rtEditAddBy = $_POST["add_by"] ?? '';
	$description = $_POST["sale_comment"] ?? '';
	$havemap = $_POST['have_map'] ?? '';
	$department_show = $_POST["department_show"] ?? '';
	$dept = $_POST["dept"] ?? '';
	$status_comment = $_POST["status_comment"];
	$check_detail = (isset($_POST['more']) && $_POST['more'] != '') ? $_POST["more"] : '0';
	$rtEditAddDate = date('Y-m-d H:i:s');

	mysqli_query($conn, "DELETE FROM tb_register_data WHERE ref_id = '" . $ref_id . "'");
	$strSQL66 = "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,mk_research,province_name,count_box,location_link,transport_company)
	values('" . $ref_id . "','" . $start_date . "','" . $between_date . "','" . $start_time . "','" . $end_time . "','" . $status . "','" . $fix_date . "','" . $no_price . "','" . $call_customer . "','" . $credit . "','" . $call_employee . "','" . $chash . "','" . $check_peper . "','" . $bill . "','" . $department . "','โรงพยาบาล','" . $type_company . "','" . $customer_name . "','" . $customer_tel . "','" . $address_name . "','" . $address_send . "','" . $want_bus . "','" . $product_name . "','" . $product_sn . "','" . $unit_credit . "','" . $price . "','" . $employee_name . "','" . $employee_tel . "','" . $rtEditAddBy . "','" . $description . "','" . $havemap . "','" . $rtEditAddDate . "','" . $unit_bill1 . "','" . $unit_check1 . "','" . $unit_tran . "','" . $tran . "','" . $check_detail . "','" . $dep . "','" . $dept . "','" . $department_show . "','" . $customer_contact . "','" . $status_comment . "','" . $on_time . "','" . $address_1 . "','" . $mk_research . "','" . $province_name . "','" . $count_box . "','" . $location_link . "','" . $transport_company . "')";
	$objQuery66 = mysqli_query($conn, $strSQL66);
	if (!$objQuery66) {
		$saveOk = false;
		$saveError = 'tb_register_data: ' . mysqli_error($conn);
	}

	// ===== รายละเอียดที่อยู่ (tb_transaction) — DELETE แล้ว re-INSERT ใหม่ =====
	$park_front = $_POST['park_front'] ?? '1';
	$car_home = ($park_front === '1') ? 1 : 0;
	$car_park = mysqli_real_escape_string($conn, $_POST['park_location'] ?? '');
	$is_high_roof = isset($_POST['is_high_roof']) ? 1 : 0;
	$entrance_type = $_POST['entrance_type'] ?? '1';
	$slope = ($entrance_type === '1') ? 1 : 0;
	$bundai = ($entrance_type === '2') ? 1 : 0;
	$unit_bundai = mysqli_real_escape_string($conn, $_POST['stair_count'] ?? '');
	$install = mysqli_real_escape_string($conn, $_POST['install_floor'] ?? '');
	$install_room = mysqli_real_escape_string($conn, $_POST['room_type'] ?? '');
	$room_bigger = mysqli_real_escape_string($conn, $_POST['door_width'] ?? '');
	$room_longer = mysqli_real_escape_string($conn, $_POST['door_height'] ?? '');
	$bundai_big = trim(($_POST['stair_width'] ?? '') . ' x ' . ($_POST['stair_height'] ?? ''), ' x');
	$lip_big = trim(($_POST['elev_door_width'] ?? '') . ' x ' . ($_POST['elev_door_height'] ?? ''), ' x');
	$lip_long = trim(($_POST['elev_width'] ?? '') . ' x ' . ($_POST['elev_height'] ?? '') . ' x ' . ($_POST['elev_depth'] ?? ''), ' x');
	$lip_weight = mysqli_real_escape_string($conn, $_POST['elev_capacity'] ?? '');
	$want_employee = (($_POST['move_furn'] ?? '0') === '1') ? 1 : 0;
	$employee_unit = mysqli_real_escape_string($conn, $_POST['move_furn_count'] ?? '');
	$ferniger_name = mysqli_real_escape_string($conn, $_POST['move_furn_detail'] ?? '');
	$addr_note = mysqli_real_escape_string($conn, $_POST['addr_note'] ?? '');
	$height_ltd = $is_high_roof;

	mysqli_query($conn, "DELETE FROM tb_transaction WHERE ref_id = '" . $ref_id . "'");
	$strSQL99 = "insert into tb_transaction (ref_id,car_home,car_park,slope,bundai,unit_bundai,install,install_room,room_bigger,room_longer,bundai_big,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,description,height_ltd,add_date,add_by)
	values('" . $ref_id . "','" . $car_home . "','" . $car_park . "','" . $slope . "','" . $bundai . "','" . $unit_bundai . "','" . $install . "','" . $install_room . "','" . $room_bigger . "','" . $room_longer . "','" . $bundai_big . "','" . $lip_big . "','" . $lip_long . "','" . $lip_weight . "','" . $want_employee . "','" . $employee_unit . "','" . $ferniger_name . "','" . $addr_note . "','" . $height_ltd . "','" . $rtEditAddDate . "','" . $rtEditAddBy . "')";
	$objQuery99 = mysqli_query($conn, $strSQL99);
	if (!$objQuery99) {
		$saveOk = false;
		$saveError = 'tb_transaction: ' . mysqli_error($conn);
	}
} catch (mysqli_sql_exception $e) {
	$saveOk = false;
	$saveError = $e->getMessage();
}

if ($saveOk) {
	mysqli_commit($conn);

	// ===== ปุ่มอนุมัติ/ส่งกลับ/ไม่อนุมัติ บนแถบล่างของ register_suprental.php =====
	// ทำงานหลังบันทึกฟอร์มปกติเสร็จแล้ว (การบันทึกด้านบนเพิ่งตั้ง status_doc='Request' ไป
	// บล็อกนี้จึงเขียนทับเป็นสถานะสุดท้าย) — พอร์ตจาก register_supchange_edit1.php:559-579
	// ไม่มีคอลัมน์ approve/approve_code/approve_date/approve_time ใน hos__rental เหมือน hos__change
	// จึงใช้เท่าที่มี (send_admin สำหรับกรณีอนุมัติ)
	$rtApproveAction = $_POST['approve_action'] ?? '';
	if ($rtApproveAction !== '') {
		$rtSafeRefId = mysqli_real_escape_string($conn, $ref_id);

		if ($rtApproveAction === 'return') {
			// ส่งกลับให้ Sale แก้ไข — send_sup='0' ทำให้ปุ่ม Submit บนฟอร์มกลับมาใช้ได้อีกครั้ง
			mysqli_query($conn, "UPDATE hos__rental SET status_doc='ส่งกลับ', send_sup='0' WHERE ref_id='" . $rtSafeRefId . "'");
		} elseif ($rtApproveAction === 'reject') {
			mysqli_query($conn, "UPDATE hos__rental SET status_doc='Rejected' WHERE ref_id='" . $rtSafeRefId . "'");
		} elseif ($rtApproveAction === 'approve') {
			mysqli_query($conn, "UPDATE hos__rental SET status_doc='Approve', send_admin='1' WHERE ref_id='" . $rtSafeRefId . "'");
		}
	}

	if (ob_get_level() > 0) {
		ob_end_clean();
	}
	if ($isDraftRequest) {
		echo json_encode(array('success' => true, 'ref_id' => $ref_id));
		exit();
	}
	header('Location: register_suprental.php?ref_id=' . rawurlencode($ref_id) . '&saved=1');
	exit();
} else {
	mysqli_rollback($conn);
	rt_abort_with_alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $saveError, $isDraftRequest);
}
