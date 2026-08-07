<?php include("head.php"); ?>

<?php
include("dbconnect.php");
include("error_page.php");

date_default_timezone_set("Asia/Bangkok");

function credinotEsc($conn, $value)
{
	return mysqli_real_escape_string($conn, (string)$value);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_POST["submit"])) {

	$formMode = $_POST["form_mode"] ?? '';
	$postedRefCredit = trim($_POST["ref_credit"] ?? '');
	$isEdit = ($formMode === 'edit' && $postedRefCredit !== '');

	$date_credit = $_POST["date_credit"] ?? '';
	$customer_name = $_POST["customer_name"] ?? '';
	$customer_tel = $_POST["customer_tel"] ?? '';
	$address_name = $_POST["address_name"] ?? '';
	$return_des = trim($_POST["return_reason"] ?? '');
	$send_return_name = $_POST["send_return_name"] ?? '';
	$date_send_return = $_POST["date_send_return"] ?? '';
	$receive_name = $_POST["receive_name"] ?? '';
	$date_receive = $_POST["date_receive"] ?? '';
	$sale_name = $_POST["sale_name"] ?? '';
	$sale_date = $_POST["sale_date"] ?? '';
	$credit_ckk = $_POST["credit_ckk"] ?? '';
	$credit_no = $_POST["credit_no"] ?? '';
	$type_return_ckk = $_POST["type_return_ckk"] ?? '';
	$type_return_no = $_POST["type_return_no"] ?? '';
	$dis_credit = $_POST["dis_credit"] ?? '';
	$mode_cus = $_POST["mode_cus"] ?? '';
	$name =  $_SESSION['name'] ?? '';
	$surname =  $_SESSION['surname'] ?? '';
	$add_by = trim("$name $surname");
	$add_date = date('Y-m-d H:i:s');
	$company_type = $_POST["company_type"] ?? '';
	$ttype_doc = $_POST["ttype_doc"] ?? '';
	$iv_no_ref = $_POST["iv_no_ref"] ?? '';
	$id = $_POST["id"] ?? array();
	$count = $_POST["count"] ?? array();
	$unit_price = $_POST["unit_price"] ?? array();
	$sum_amount = $_POST["sum_amount"] ?? array();
	$discount_unit = $_POST["discount_unit"] ?? array();
	$product_id = $_POST["product_id"] ?? array();
	$sale_code = $_POST["sale_code"] ?? '';
	$send_sup = '1';
	$status_doc = 'Request';
	$send_admin = '0';
	$account_no =  $_POST["account_no"] ?? '';
	$account_name =  $_POST["account_name"] ?? '';
	$bank_name =  $_POST["bank_name"] ?? '';
	$type_return = $_POST["type_return"] ?? '';
	$ref_id = $_POST["ref_id"] ?? ($_POST["ref_order_id"] ?? '');
	$ref_order_id = $_POST["ref_order_id"] ?? $ref_id;
	$opener = $_POST["opener"] ?? '';
	$remark_et = trim($_POST["return_des"] ?? ($_POST["remark_et"] ?? ''));
	$desnew_bill = trim($_POST["etax_edit_note"] ?? ($_POST["desnew_bill"] ?? ''));
	$new_bill = $_POST["new_bill"] ?? ($_POST["etax_count"] ?? '0');
	if (trim((string)$new_bill) === '') {
		$new_bill = '0';
	}
	$date_oldbill = $_POST["date_oldbill"] ?? ($_POST["etax_orig_date"] ?? '');
	$bill_id = $_POST["bill_id"] ?? '';

	// รายการสินค้าที่ผู้ใช้กดลบในหน้าแก้ไข (ถูกซ่อนไว้ตั้งแต่ตอนกด ไม่ได้ลบจริงจนกว่าจะ submit ฟอร์มนี้)
	$deleteSubcreditIds = $_POST['delete_subcredit_id'] ?? array();
	if (!is_array($deleteSubcreditIds)) {
		$deleteSubcreditIds = array();
	}
	$deleteSubcreditIdSet = array_flip(array_map('strval', $deleteSubcreditIds));

	// แนบไฟล์ Book Bank (เก็บไฟล์ไว้ในโฟลเดอร์ credit_no/ และบันทึกเฉพาะชื่อไฟล์ลง DB)
	// โหมดแก้ไข: ถ้าไม่ได้อัปโหลดไฟล์ใหม่ ให้คงชื่อไฟล์เดิมไว้ (ส่งมาเป็น hidden input book_bank_existing จากฟอร์ม)
	$book_bank = $_POST['book_bank_existing'] ?? '';
	if (!empty($_FILES['book_bank']['name'])) {
		move_uploaded_file($_FILES['book_bank']['tmp_name'], "credit_no/" . iconv("UTF-8", "TIS-620", $_FILES['book_bank']['name']));
		$book_bank = $_FILES['book_bank']['name'];
	}

	$qsave = false;
	$ref_credit = $postedRefCredit;

	if ($isEdit) {
		// ================== โหมดแก้ไข: UPDATE เอกสารที่มีอยู่แล้ว ==================
		$escRefCredit = credinotEsc($conn, $ref_credit);

		$save = "UPDATE tb_credit_note SET
			date_credit = '" . credinotEsc($conn, $date_credit) . "',
			ref_id = '" . credinotEsc($conn, $ref_id) . "',
			customer_name = '" . credinotEsc($conn, $customer_name) . "',
			customer_tel = '" . credinotEsc($conn, $customer_tel) . "',
			address_name = '" . credinotEsc($conn, $address_name) . "',
			return_des = '" . credinotEsc($conn, $return_des) . "',
			receive_name = '" . credinotEsc($conn, $receive_name) . "',
			date_receive = '" . credinotEsc($conn, $date_receive) . "',
			credit_no = '" . credinotEsc($conn, $credit_no) . "',
			ttype_doc = '" . credinotEsc($conn, $ttype_doc) . "',
			iv_no_ref = '" . credinotEsc($conn, $iv_no_ref) . "',
			sale_code = '" . credinotEsc($conn, $sale_code) . "',
			company_type = '" . credinotEsc($conn, $company_type) . "',
			type_return = '" . credinotEsc($conn, $type_return) . "',
			bank_name = '" . credinotEsc($conn, $bank_name) . "',
			account_name = '" . credinotEsc($conn, $account_name) . "',
			account_no = '" . credinotEsc($conn, $account_no) . "',
			book_bank = '" . credinotEsc($conn, $book_bank) . "',
			bill_id = '" . credinotEsc($conn, $bill_id) . "',
			remark_et = '" . credinotEsc($conn, $remark_et) . "',
			desnew_bill = '" . credinotEsc($conn, $desnew_bill) . "',
			new_bill = '" . credinotEsc($conn, $new_bill) . "',
			date_oldbill = '" . credinotEsc($conn, $date_oldbill) . "'
			WHERE ref_credit = '" . $escRefCredit . "'";

		$qsave = mysqli_query($conn, $save);

		if (is_array($id)) {
			foreach ($id as $key => $value) {
				$count_new = $count[$key] ?? 0;
				$product_price1 = $unit_price[$key] ?? 0;
				$unit_price_new = str_replace(',', '', $product_price1);
				$product_id_new = $product_id[$key] ?? '';
				$discount_unit1 = $discount_unit[$key] ?? 0;
				$discount_unit_new = str_replace(',', '', $discount_unit1);
				$sum_amount_new = ((float)$unit_price_new - (float)$discount_unit_new) * (float)$count_new;
				$sum_discount = (float)$discount_unit_new * (float)$count_new;

				if ($product_id_new == "") {
					continue;
				}

				// แถวที่กดลบไว้ (รอลบจริงตอน submit) ไม่ต้อง update ให้เสียเที่ยว เดี๋ยวก็โดนลบด้านล่างอยู่ดี
				if (isset($deleteSubcreditIdSet[(string)$value])) {
					continue;
				}

				// แถวที่เพิ่มเองผ่าน modal "เพิ่มสินค้า" ใช้ key ขึ้นต้นด้วย new_ (ยังไม่มี id จริงใน tb_subcredit) -> INSERT
				// แถวเดิมที่มาจาก tb_subcredit อยู่แล้ว key เป็น id จริง -> UPDATE
				$isNewRow = (strpos((string)$key, 'new_') === 0);

				if ($isNewRow) {
					$strSQL = "insert into tb_subcredit
	(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id,sum_discount)
	values ('" . $escRefCredit . "','" . credinotEsc($conn, $count_new) . "','" . credinotEsc($conn, $unit_price_new) . "','" . credinotEsc($conn, $sum_amount_new) . "','" . credinotEsc($conn, $discount_unit_new) . "','" . credinotEsc($conn, $product_id_new) . "','" . credinotEsc($conn, $sum_discount) . "')";
					mysqli_query($conn, $strSQL);
				} else {
					$escSubId = credinotEsc($conn, $value);
					$strSQL = "UPDATE tb_subcredit SET
						count = '" . credinotEsc($conn, $count_new) . "',
						unit_price = '" . credinotEsc($conn, $unit_price_new) . "',
						sum_amount = '" . credinotEsc($conn, $sum_amount_new) . "',
						discount_unit = '" . credinotEsc($conn, $discount_unit_new) . "',
						product_id = '" . credinotEsc($conn, $product_id_new) . "',
						sum_discount = '" . credinotEsc($conn, $sum_discount) . "'
						WHERE id = '" . $escSubId . "'";
					mysqli_query($conn, $strSQL);
				}
			}
		}

		// ลบรายการสินค้าที่ผู้ใช้กดลบไว้ระหว่างแก้ไข (deferred delete — ลบจริงตอนนี้เท่านั้น)
		foreach ($deleteSubcreditIds as $delId) {
			$delId = trim((string)$delId);
			if ($delId === '' || !ctype_digit($delId)) {
				continue;
			}
			mysqli_query($conn, "DELETE FROM tb_subcredit WHERE id = '" . credinotEsc($conn, $delId) . "'");
		}
	} else {
		// ================== โหมดสร้างใหม่ (จาก SO หรือไม่มีเอกสารอ้างอิง): INSERT ==================
		$yearMonth = substr(date("Y") + 543, -2) . date("m");
		$sql1 = "SELECT MAX(ref_credit) AS MAXID FROM tb_credit_note";
		$qry1 = mysqli_query($conn, $sql1) or die(mysqli_error());
		$rs1 = mysqli_fetch_assoc($qry1);
		$maxId = substr($rs1['MAXID'], -4);
		$maxId3 = substr($rs1['MAXID'], -8);

		$maxId1 = substr($maxId3, 0, -4);

		if ($maxId1 == $yearMonth) {
			$maxId1 = ($maxId + 1);
			$maxId2 = substr("00000" . $maxId1, -4);
			$nextId = $yearMonth . $maxId2;
		} else {
			$maxId1 = "0001";
			$nextId = $yearMonth . $maxId1;
		}

		$so = "SR";

		$ref_credit = "$so$nextId";
		$escRefCredit = credinotEsc($conn, $ref_credit);

		if (!empty($product_id)) {

			$save = "insert into tb_credit_note
(ref_credit,ref_id,date_credit,customer_name,customer_tel,address_name,return_des,send_return_name,date_send_return,receive_name,date_receive,sale_name,sale_date,credit_ckk,credit_no,type_return_ckk,type_return_no,dis_credit,add_by,add_date,company_type,ttype_doc,iv_no_ref,sale_code,send_sup,send_admin,status_doc,type_return,bank_name,account_name,account_no,book_bank,mode_cus,remark_et,desnew_bill,new_bill,date_oldbill,ref_order_id,bill_id)
values
('" . $escRefCredit . "','" . credinotEsc($conn, $ref_id) . "','" . credinotEsc($conn, $date_credit) . "','" . credinotEsc($conn, $customer_name) . "','" . credinotEsc($conn, $customer_tel) . "','" . credinotEsc($conn, $address_name) . "','" . credinotEsc($conn, $return_des) . "','" . credinotEsc($conn, $send_return_name) . "','" . credinotEsc($conn, $date_send_return) . "','" . credinotEsc($conn, $receive_name) . "','" . credinotEsc($conn, $date_receive) . "','" . credinotEsc($conn, $sale_name) . "','" . credinotEsc($conn, $sale_date) . "','" . credinotEsc($conn, $credit_ckk) . "','" . credinotEsc($conn, $credit_no) . "','" . credinotEsc($conn, $type_return_ckk) . "','" . credinotEsc($conn, $type_return_no) . "','" . credinotEsc($conn, $dis_credit) . "','" . credinotEsc($conn, $add_by) . "','" . credinotEsc($conn, $add_date) . "','" . credinotEsc($conn, $company_type) . "','" . credinotEsc($conn, $ttype_doc) . "','" . credinotEsc($conn, $iv_no_ref) . "','" . credinotEsc($conn, $sale_code) . "','" . credinotEsc($conn, $send_sup) . "','" . credinotEsc($conn, $send_admin) . "','" . credinotEsc($conn, $status_doc) . "','" . credinotEsc($conn, $type_return) . "','" . credinotEsc($conn, $bank_name) . "','" . credinotEsc($conn, $account_name) . "','" . credinotEsc($conn, $account_no) . "','" . credinotEsc($conn, $book_bank) . "','" . credinotEsc($conn, $mode_cus) . "','" . credinotEsc($conn, $remark_et) . "','" . credinotEsc($conn, $desnew_bill) . "','" . credinotEsc($conn, $new_bill) . "','" . credinotEsc($conn, $date_oldbill) . "','" . credinotEsc($conn, $ref_order_id) . "','" . credinotEsc($conn, $bill_id) . "')";

			$qsave = mysqli_query($conn, $save);

			if ($qsave && $ref_id !== '') {
				$refPrefix = substr($ref_id, 0, 2);
				$srUpdateTable = ($refPrefix === 'SO') ? 'hos__so' : 'so__main';
				$escRefId = credinotEsc($conn, $ref_id);
				mysqli_query($conn, "UPDATE $srUpdateTable SET sr_no = '$escRefCredit' WHERE ref_id = '$escRefId'");
			}

			if (is_array($id)) {
				foreach ($id as $key => $value) {
					$count_new = $count[$key] ?? 0;
					$product_price1 = $unit_price[$key] ?? 0;
					$unit_price_new = str_replace(',', '', $product_price1);
					$product_id_new = $product_id[$key] ?? '';
					$discount_unit1 = $discount_unit[$key] ?? 0;
					$discount_unit_new = str_replace(',', '', $discount_unit1);
					$sum_amount_new = ((float)$unit_price_new - (float)$discount_unit_new) * (float)$count_new;
					$sum_discount = (float)$discount_unit_new * (float)$count_new;

					if ($product_id_new != "") {

						$strSQL = "insert into tb_subcredit
	(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id,sum_discount)
	values ('" . $escRefCredit . "','" . credinotEsc($conn, $count_new) . "','" . credinotEsc($conn, $unit_price_new) . "','" . credinotEsc($conn, $sum_amount_new) . "','" . credinotEsc($conn, $discount_unit_new) . "','" . credinotEsc($conn, $product_id_new) . "','" . credinotEsc($conn, $sum_discount) . "')";

						mysqli_query($conn, $strSQL);
					}
				}
			}
		}
	}

	// ===== แถบอนุมัติ (รวม flow เดิมของ credit_approve.php / credit_cmapprove.php /
	// credit_rejected.php / credit_cmrejected.php / send_credit_approve.php / send_credit_admin.php
	// เข้ามาไว้จุดเดียว) — ทำงานหลังบันทึกข้อมูลฟอร์มหลักสำเร็จแล้วเท่านั้น =====
	$approveAction = $_POST['approve_action'] ?? '';
	if ($approveAction !== '' && $qsave && $ref_credit !== '') {
		$escRefCredit = credinotEsc($conn, $ref_credit);
		$approverCode = $_SESSION['code'] ?? '';
		$today = date('Y-m-d');
		$now = date('Y-m-d H:i:s');

		$curRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT send_sup, send_dm, status_doc FROM tb_credit_note WHERE ref_credit = '" . $escRefCredit . "'"));
		$curSendSup = $curRow['send_sup'] ?? '0';
		$curSendDm = $curRow['send_dm'] ?? '0';
		$curStatusDoc = $curRow['status_doc'] ?? '';
		$isBucket1 = ($curSendSup === '1' && $curSendDm === '0' && $curStatusDoc === 'Request');
		$isBucket2 = ($curSendDm === '1' && $curStatusDoc === 'Request');

		if ($approveAction === 'send_sup') {
			mysqli_query($conn, "UPDATE tb_credit_note SET send_sup='1' WHERE ref_credit='" . $escRefCredit . "'");
		} elseif ($approveAction === 'approve') {
			if ($isBucket1) {
				if ($approverCode === 'SS5') {
					// ทีม SS5: ประทับว่าตรวจแล้ว แต่ยังค้างอยู่ระดับ SUP เหมือนเดิม (ตาม credit_approve.php เดิม)
					mysqli_query($conn, "UPDATE tb_credit_note SET send_sup='1', status_doc='Request' WHERE ref_credit='" . $escRefCredit . "'");
				} else {
					mysqli_query($conn, "UPDATE tb_credit_note SET send_dm='1', approve_name='" . credinotEsc($conn, $add_by) . "', approve_date='" . $today . "', approve_datetime='" . $now . "' WHERE ref_credit='" . $escRefCredit . "'");
				}
			} elseif ($isBucket2) {
				mysqli_query($conn, "UPDATE tb_credit_note SET status_doc='Approve', send_admin='1', dm_name='" . credinotEsc($conn, $add_by) . "', dm_date='" . $today . "', dm_datetime='" . $now . "' WHERE ref_credit='" . $escRefCredit . "'");
			}
		} elseif ($approveAction === 'return') {
			if ($isBucket1) {
				mysqli_query($conn, "UPDATE tb_credit_note SET send_sup='0' WHERE ref_credit='" . $escRefCredit . "'");
			} elseif ($isBucket2) {
				mysqli_query($conn, "UPDATE tb_credit_note SET send_dm='0' WHERE ref_credit='" . $escRefCredit . "'");
			}
		} elseif ($approveAction === 'reject') {
			if ($isBucket1) {
				mysqli_query($conn, "UPDATE tb_credit_note SET status_doc='Rejected', approve_name='" . credinotEsc($conn, $add_by) . "', approve_date='" . $today . "' WHERE ref_credit='" . $escRefCredit . "'");
			} elseif ($isBucket2) {
				mysqli_query($conn, "UPDATE tb_credit_note SET status_doc='Rejected' WHERE ref_credit='" . $escRefCredit . "'");
			}
		} elseif ($approveAction === 'cancel') {
			mysqli_query($conn, "UPDATE tb_credit_note SET status_doc='ยกเลิก' WHERE ref_credit='" . $escRefCredit . "'");
		}
	}

	if ($qsave) {
		if ($opener === 'suphos') {
			echo "<script language=\"JavaScript\">";
			echo "if (window.opener && typeof window.opener.handleCreditNoteCreated === 'function') {";
			echo "  window.opener.handleCreditNoteCreated(" . json_encode($ref_credit) . ");";
			echo "  window.close();";
			echo "} else {";
			echo "  alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');";
			echo "  window.location='register_credinot.php?ref_credit=" . rawurlencode($ref_credit) . "';";
			echo "}";
			echo "</script>";
		} else {
			echo "<script language=\"JavaScript\">";
			echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_credinot.php?ref_credit=" . rawurlencode($ref_credit) . "';";
			echo "</script>";
		}
	} else {
		echo "Cannot ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่มีรายการใบสั่งลดหนี้แล้วค่ะ";
	}
}
