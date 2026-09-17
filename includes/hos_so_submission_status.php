<?php

/**
 * Decide whether a register_suphos submission is allowed to change the SO
 * workflow status. Administrative side actions must not resubmit an already
 * approved document for approval.
 *
 * @return array{status_doc: string|null}
 */
function resolveHosSoStatusFields($isDraftRequest, $cancelDocPost, $adminAction)
{
	if ($cancelDocPost === '1') {
		return array('status_doc' => 'ยกเลิก');
	}

	if ($isDraftRequest || $adminAction === 'send_receipt') {
		return array('status_doc' => null);
	}

	return array('status_doc' => 'Request');
}

