<?php
// Shared helper for creating "ใบตรวจทานสินค้า" (product checklist) records for a BR
// (hos__br / hos__subbr) document. Ported from the page-render side effect in
// register_adminbrhos_edit.php (old admin BR edit page's "pdf" tab), but made
// idempotent and safe to call from a POST handler instead of on every GET render.
//
// Used by register_supbrhos1.php (create) and register_supbrhos_edit1.php (update),
// both of which call this only during a successful non-draft Submit/Update transaction.

if (!function_exists('brProductChecklistQuery')) {
	function brProductChecklistQuery($conn, $sql)
	{
		$result = mysqli_query($conn, $sql);
		if ($result === false) {
			throw new mysqli_sql_exception(mysqli_error($conn));
		}
		return $result;
	}
}

if (!function_exists('createBrProductChecklists')) {
	function createBrProductChecklists($conn, $ref_id_br)
	{
		$ref_id_br = mysqli_real_escape_string($conn, $ref_id_br);

		// sale_code is not editable in the update flow (register_supbrhos_edit1.php leaves it
		// untouched), so read it back from hos__br instead of trusting a POST value that may be
		// stale or absent depending on which handler called us.
		$saleCodeQuery = brProductChecklistQuery($conn, "SELECT sale_code FROM hos__br WHERE ref_id_br = '" . $ref_id_br . "' LIMIT 1");
		$saleCodeRow = $saleCodeQuery ? mysqli_fetch_assoc($saleCodeQuery) : null;
		$isSaleCodeS31 = (($saleCodeRow['sale_code'] ?? '') === 'S31');

		// Only products flagged review_ckk='1' need a checklist. DISTINCT because hos__subbr rows
		// are fully deleted/reinserted on every edit (register_supbrhos_edit1.php), so the same
		// product_id can legitimately appear on more than one row.
		$productsQuery = brProductChecklistQuery(
			$conn,
			"SELECT DISTINCT hos__subbr.product_id FROM hos__subbr " .
				"INNER JOIN tb_product ON hos__subbr.product_id = tb_product.product_ID " .
				"WHERE hos__subbr.ref_idd_br = '" . $ref_id_br . "' AND tb_product.review_ckk = '1'"
		);
		if (!$productsQuery) {
			return;
		}

		while ($productRow = mysqli_fetch_assoc($productsQuery)) {
			$product_id = trim((string)($productRow['product_id'] ?? ''));
			if ($product_id === '') {
				continue;
			}
			$product_id = mysqli_real_escape_string($conn, $product_id);

			// Dedup key is ref_id + product_id, not hos__subbr.ckk_pro: ckk_pro resets to '0' every
			// time the edit handler deletes and reinserts hos__subbr rows, so it can't be trusted
			// across edits on its own.
			$existingQuery = brProductChecklistQuery($conn, "SELECT checklist_id FROM tb_product_checklist WHERE ref_id = '" . $ref_id_br . "' AND product_id = '" . $product_id . "' LIMIT 1");
			if ($existingQuery && mysqli_num_rows($existingQuery) > 0) {
				brProductChecklistQuery($conn, "UPDATE hos__subbr SET ckk_pro = '1' WHERE ref_idd_br = '" . $ref_id_br . "' AND product_id = '" . $product_id . "'");
				continue;
			}

			$leafletQuery = brProductChecklistQuery($conn, "SELECT * FROM tb_product_leaflet WHERE product_id = '" . $product_id . "'");
			$leafletRow = $leafletQuery ? (mysqli_fetch_assoc($leafletQuery) ?: array()) : array();

			$addDate = date('Y-m-d H:i:s');
			$addBy = mysqli_real_escape_string($conn, trim(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? '')));
			$strDate = date('Y-m-d');
			$strYear1 = substr((string)(date("Y", strtotime($strDate)) + 543), 2, 2);

			$docNoQuery = brProductChecklistQuery($conn, "SELECT doc_no FROM tb_product_checklist WHERE head_pc = 'PC' ORDER BY checklist_id DESC LIMIT 1");
			$docNoRow = $docNoQuery ? mysqli_fetch_assoc($docNoQuery) : null;
			$docNo = ((int)($docNoRow['doc_no'] ?? 0)) + 1;

			$yearMonth = substr((string)(date("Y") + 543), -2) . date("m");
			$maxRefQuery = brProductChecklistQuery($conn, "SELECT MAX(ref_pc) AS MAXID FROM tb_product_checklist WHERE head_pc = 'PC'");
			$maxRefRow = $maxRefQuery ? mysqli_fetch_assoc($maxRefQuery) : null;
			$maxIdRaw = (string)($maxRefRow['MAXID'] ?? '');
			$maxId = substr($maxIdRaw, -4);
			$maxId3 = substr($maxIdRaw, -8);
			$maxId1 = substr($maxId3, 0, -4);

			if ($maxId1 === $yearMonth) {
				$nextSeq = ((int)$maxId) + 1;
				$nextId = $yearMonth . substr("0000" . $nextSeq, -4);
			} else {
				$nextId = $yearMonth . "0001";
			}

			$refPc = "PC" . $nextId;

			$ingredientColumns = array();
			$ingredientValues = array();
			for ($ingredientIndex = 1; $ingredientIndex <= 29; $ingredientIndex++) {
				$ingredientColumns[] = "ingredient" . $ingredientIndex;
				$ingredientValues[] = mysqli_real_escape_string($conn, $leafletRow["ingredient" . $ingredientIndex] ?? '');
			}

			brProductChecklistQuery(
				$conn,
				"INSERT INTO tb_product_checkref (product_id, ref_id, ref_pc, " . implode(',', $ingredientColumns) . ") VALUES " .
					"('" . $product_id . "','" . $ref_id_br . "','" . $refPc . "','" . implode("','", $ingredientValues) . "')"
			);

			if ($isSaleCodeS31) {
				brProductChecklistQuery(
					$conn,
					"INSERT INTO tb_product_checklist (ref_pc,doc_no,year_no,ref_id,product_id,add_date,add_by,date_create,head_pc,sol_ckk) VALUES " .
						"('" . $refPc . "','" . $docNo . "','" . $strYear1 . "','" . $ref_id_br . "','" . $product_id . "','" . $addDate . "','" . $addBy . "','" . $strDate . "','PC','1')"
				);
			} else {
				brProductChecklistQuery(
					$conn,
					"INSERT INTO tb_product_checklist (ref_pc,doc_no,year_no,ref_id,product_id,add_date,add_by,date_create,head_pc) VALUES " .
						"('" . $refPc . "','" . $docNo . "','" . $strYear1 . "','" . $ref_id_br . "','" . $product_id . "','" . $addDate . "','" . $addBy . "','" . $strDate . "','PC')"
				);
			}

			$workflowRows = array(
				array('ST', 1),
				array('EN', 1),
				array('CS', 1),
				array('CS', 2),
				array('EN', 2),
				array('ST', 2),
			);
			foreach ($workflowRows as $workflowRow) {
				list($typeEmp, $goBack) = $workflowRow;
				if ($isSaleCodeS31) {
					brProductChecklistQuery($conn, "INSERT INTO tb_product_checklis (ref_pcc,type_emp,go_back,sol_ckk) VALUES ('" . $refPc . "','" . $typeEmp . "','" . $goBack . "','1')");
				} else {
					brProductChecklistQuery($conn, "INSERT INTO tb_product_checklis (ref_pcc,type_emp,go_back) VALUES ('" . $refPc . "','" . $typeEmp . "','" . $goBack . "')");
				}
			}

			brProductChecklistQuery($conn, "UPDATE hos__subbr SET ckk_pro = '1' WHERE ref_idd_br = '" . $ref_id_br . "' AND product_id = '" . $product_id . "'");
		}
	}
}
