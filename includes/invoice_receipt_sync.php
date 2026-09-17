<?php

/**
 * Shared, idempotent sync of an approved hos__so Sale Order into the
 * invoice_receipt database's tb_register_data (รายการรับ-จ่าย) table.
 *
 * Both register_suphos.php (current SO page) and the legacy
 * register_adminhos_edit1.php path must funnel through this single
 * function so there is exactly one place that decides insert vs update
 * and which columns the SO is allowed to own.
 */

if (!function_exists('prepareInvoiceReceiptLegacyConnection')) {
	/**
	 * tb_register_data is a legacy table with many NOT NULL columns that have
	 * no declared defaults. Existing writers rely on MySQL's implicit legacy
	 * defaults, so this connection must not use strict transactional mode.
	 */
	function prepareInvoiceReceiptLegacyConnection(mysqli $receiptConn): bool {
		return (bool)mysqli_query(
			$receiptConn,
			"SET SESSION sql_mode = REPLACE(REPLACE(@@SESSION.sql_mode, 'STRICT_TRANS_TABLES', ''), 'STRICT_ALL_TABLES', '')"
		);
	}
}

if (!function_exists('syncHosSoToInvoiceReceipt')) {

	/**
	 * @param mysqli $sourceConn  Connection to allwell_sol_test (hos__so, hos__subso).
	 * @param mysqli $receiptConn Connection to invoice_receipt (tb_register_data), i.e. $code from dbconnect_acc.php.
	 * @param string $soRefId     hos__so.ref_id to sync.
	 * @param array  $actor       ['id' => string, 'name' => string] of the user performing the send.
	 *
	 * @return array{success: bool, message: string, action: string|null}
	 */
	function syncHosSoToInvoiceReceipt(mysqli $sourceConn, mysqli $receiptConn, string $soRefId, array $actor): array {
		try {
		$soRefId = trim($soRefId);
		if ($soRefId === '') {
			return ['success' => false, 'message' => 'ไม่พบเลขที่อ้างอิงใบสั่งขาย', 'action' => null];
		}

		if (!prepareInvoiceReceiptLegacyConnection($receiptConn)) {
			return ['success' => false, 'message' => 'ไม่สามารถเชื่อมต่อระบบรายการรับ-จ่ายได้ กรุณาลองใหม่อีกครั้ง', 'action' => null];
		}

		$safeRefIdSource = mysqli_real_escape_string($sourceConn, $soRefId);

		$soQuery = mysqli_query($sourceConn, "SELECT ref_id, type_doc, iv_no, iv_date, bill_name, bill_id, payment, payment_des, date_tranfer, status_doc, delivery_type, sale, sale_code FROM hos__so WHERE ref_id = '" . $safeRefIdSource . "' LIMIT 1");
		$soRow = $soQuery ? mysqli_fetch_assoc($soQuery) : null;
		if (!$soRow) {
			return ['success' => false, 'message' => 'ไม่พบข้อมูลใบสั่งขายนี้ในระบบ', 'action' => null];
		}

		if (($soRow['status_doc'] ?? '') !== 'Approve') {
			return ['success' => false, 'message' => 'ใบสั่งขายต้องอยู่ในสถานะอนุมัติก่อนจึงจะส่งรายการรับ-จ่ายได้', 'action' => null];
		}

		$amountQuery = mysqli_query($sourceConn, "SELECT SUM(amount) AS unit_cash FROM hos__subso WHERE ref_idd = '" . $safeRefIdSource . "' AND status_so <> 'ยกเลิก'");
		$amountRow = $amountQuery ? mysqli_fetch_assoc($amountQuery) : null;
		$unitCash = $amountRow['unit_cash'] ?? '0.00';

		$ivNo = (string)($soRow['iv_no'] ?? '');
		$docPrefix = substr($ivNo, 0, 3);
		if ($docPrefix === 'IV2') {
			$company = 'บิลเงินสด';
		} elseif ((string)($soRow['type_doc'] ?? '') === '3') {
			$company = 'ออลล์เวล ไลฟ์ บจก.';
		} elseif ((string)($soRow['type_doc'] ?? '') === '4') {
			$company = 'โนเบิล เมด บจก.';
		} else {
			$company = '';
		}

		$creditPaymentCodes = ['36', '38', '39', '40', '41', '42'];
		$payment = (string)($soRow['payment'] ?? '');
		$credit = in_array($payment, $creditPaymentCodes, true) ? '1' : '0';

		$dateInv = !empty($soRow['iv_date']) && $soRow['iv_date'] !== '0000-00-00' ? $soRow['iv_date'] : date('Y-m-d');
		$dateTranfer = !empty($soRow['date_tranfer']) && $soRow['date_tranfer'] !== '0000-00-00' ? $soRow['date_tranfer'] : null;

		$actorId = (string)($actor['id'] ?? '');
		$actorName = (string)($actor['name'] ?? '');
		$now = date('Y-m-d H:i:s');

		// พนักงานผู้รับผิดชอบการขนส่ง (doc_receive/doc_receive1) มาจาก hos__so.sale/sale_code เอง
		// ไม่ใช่ actor ที่กดปุ่มส่ง เพื่อให้ตรงพฤติกรรมเดิมของ register_adminhos_edit1.php
		$changName = '';
		$changCode = '';
		if ((string)($soRow['delivery_type'] ?? '') === '2') {
			$safeSaleCode = mysqli_real_escape_string($sourceConn, (string)($soRow['sale_code'] ?? ''));
			$userQuery = mysqli_query($sourceConn, "SELECT em_id FROM tb_user WHERE code = '" . $safeSaleCode . "' LIMIT 1");
			$userRow = $userQuery ? mysqli_fetch_assoc($userQuery) : null;
			$changName = (string)($soRow['sale'] ?? '');
			$changCode = (string)($userRow['em_id'] ?? '');
		}

		$fields = [
			'ref_id' => $soRefId,
			'IV_number' => $ivNo,
			'date_inv' => $dateInv,
			'company' => $company,
			'customer_name' => (string)($soRow['bill_name'] ?? ''),
			'bill_id' => (string)($soRow['bill_id'] ?? ''),
			'credit' => $credit,
			'cash' => $payment,
			'unit_cash' => $unitCash,
			'description' => (string)($soRow['payment_des'] ?? ''),
			'employee_name' => $actorName,
			'doc_send' => $actorId,
			'date_send' => $now,
			'doc_send1' => $actorName,
			'doc_receive' => $changCode,
			'doc_receive1' => $changName,
		];
		if ($dateTranfer !== null) {
			$fields['date_tranfer'] = $dateTranfer;
		}

		$safeRefIdReceipt = mysqli_real_escape_string($receiptConn, $soRefId);
		$existingQuery = mysqli_query($receiptConn, "SELECT id_off FROM tb_register_data WHERE ref_id = '" . $safeRefIdReceipt . "' AND COALESCE(type_1,'') = '' ORDER BY id_off DESC LIMIT 1");
		$existingRow = $existingQuery ? mysqli_fetch_assoc($existingQuery) : null;

		if ($existingRow) {
			$setParts = [];
			foreach ($fields as $column => $value) {
				$setParts[] = $column . " = '" . mysqli_real_escape_string($receiptConn, (string)$value) . "'";
			}
			$updateSql = "UPDATE tb_register_data SET " . implode(', ', $setParts) . " WHERE id_off = " . (int)$existingRow['id_off'];
			$updateOk = mysqli_query($receiptConn, $updateSql);
			if (!$updateOk) {
				return ['success' => false, 'message' => 'บันทึกรายการรับ-จ่ายไม่สำเร็จ กรุณาลองใหม่อีกครั้ง', 'action' => null];
			}
			$action = 'update';
		} else {
			$fields['add_date'] = $now;
			$columns = array_keys($fields);
			$values = array_map(function ($value) use ($receiptConn) {
				return "'" . mysqli_real_escape_string($receiptConn, (string)$value) . "'";
			}, array_values($fields));
			$insertSql = "INSERT INTO tb_register_data (" . implode(',', $columns) . ") VALUES (" . implode(',', $values) . ")";
			$insertOk = mysqli_query($receiptConn, $insertSql);
			if (!$insertOk) {
				return ['success' => false, 'message' => 'บันทึกรายการรับ-จ่ายไม่สำเร็จ กรุณาลองใหม่อีกครั้ง', 'action' => null];
			}
			$action = 'insert';
		}

		$markOk = mysqli_query($sourceConn, "UPDATE hos__so SET send_receipt = '2' WHERE ref_id = '" . $safeRefIdSource . "'");
		if (!$markOk) {
			// Receipt row is already written; the SO flag can be reconciled on retry, so this is not a hard failure.
			return ['success' => true, 'message' => 'บันทึกรายการรับ-จ่ายสำเร็จ แต่ปรับสถานะใบสั่งขายไม่สำเร็จ กรุณากดส่งอีกครั้งเพื่อยืนยันสถานะ', 'action' => $action];
		}

		return ['success' => true, 'message' => 'ส่งรายการรับ-จ่ายเรียบร้อยแล้ว', 'action' => $action];
		} catch (Throwable $error) {
			error_log('[invoice_receipt_sync] Sync failed for ref_id=' . $soRefId . ': ' . $error->getMessage());
			return ['success' => false, 'message' => 'บันทึกรายการรับ-จ่ายไม่สำเร็จ กรุณาลองใหม่อีกครั้ง', 'action' => null];
		}
	}
}
