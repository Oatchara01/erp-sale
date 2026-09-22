<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include("dbconnect_acc.php");
include ("error_page.php"); 

function getDepositOrderCreditStatus($conn, $code, $refId)
{
	$status = array(
		'should_check' => false,
		'insufficient' => false,
		'credit_amount' => 0.0,
		'remaining_credit' => 0.0,
		'order_total' => 0.0
	);

	$orderStmt = mysqli_prepare($conn, "SELECT bill_id, have_order, ic_ckk FROM hos__so WHERE ref_id = ? LIMIT 1");
	if (!$orderStmt) {
		throw new RuntimeException('Unable to prepare order credit check');
	}
	mysqli_stmt_bind_param($orderStmt, 's', $refId);
	mysqli_stmt_execute($orderStmt);
	$orderResult = mysqli_stmt_get_result($orderStmt);
	$order = $orderResult ? mysqli_fetch_assoc($orderResult) : null;
	mysqli_stmt_close($orderStmt);

	if (!$order || ($order['have_order'] ?? '') !== '1' || ($order['ic_ckk'] ?? '') === '1') {
		return $status;
	}

	$billId = trim((string)($order['bill_id'] ?? ''));
	if ($billId === '') {
		return $status;
	}

	$customerStmt = mysqli_prepare($conn, "SELECT credit_thb FROM tb_customer WHERE customer_id = ? LIMIT 1");
	if (!$customerStmt) {
		throw new RuntimeException('Unable to prepare customer credit check');
	}
	mysqli_stmt_bind_param($customerStmt, 's', $billId);
	mysqli_stmt_execute($customerStmt);
	$customerResult = mysqli_stmt_get_result($customerStmt);
	$customer = $customerResult ? mysqli_fetch_assoc($customerResult) : null;
	mysqli_stmt_close($customerStmt);

	$creditAmount = (float)($customer['credit_thb'] ?? 0);
	if ($creditAmount <= 0) {
		return $status;
	}

	$totalStmt = mysqli_prepare($conn, "SELECT COALESCE(SUM(amount), 0) AS order_total FROM hos__subso WHERE ref_idd = ?");
	if (!$totalStmt) {
		throw new RuntimeException('Unable to prepare order total check');
	}
	mysqli_stmt_bind_param($totalStmt, 's', $refId);
	mysqli_stmt_execute($totalStmt);
	$totalResult = mysqli_stmt_get_result($totalStmt);
	$totalRow = $totalResult ? mysqli_fetch_assoc($totalResult) : null;
	mysqli_stmt_close($totalStmt);
	$orderTotal = (float)($totalRow['order_total'] ?? 0);

	$today = date('Y-m-d');
	$debtSql = "
		SELECT COALESCE(SUM(GREATEST(
			CAST(r.unit_cash AS DECIMAL(18,2)) - COALESCE(rc.paid_amount, 0),
			0
		)), 0) AS total_outstanding
		FROM tb_register_data AS r
		LEFT JOIN (
			SELECT ref_id_off, SUM(amount) AS paid_amount
			FROM tb_receipt_cash
			GROUP BY ref_id_off
		) AS rc ON rc.ref_id_off = r.id_off
		WHERE r.IV_number NOT LIKE '%ธ%'
		  AND r.IV_number NOT LIKE '%R%'
		  AND (
			  NULLIF(TRIM(CAST(r.date_bank AS CHAR)), '') IS NULL
			  OR TRIM(CAST(r.date_bank AS CHAR)) = '0000-00-00'
			  OR TRIM(CAST(r.date_bank AS CHAR)) > ?
		  )
		  AND r.unit_cash <> '0.00'
		  AND (r.ref_sub = '' OR r.ref_sub IS NULL)
		  AND r.ref_id NOT LIKE '%BL%'
		  AND r.bill_id = ?
	";
	$debtStmt = mysqli_prepare($code, $debtSql);
	if (!$debtStmt) {
		throw new RuntimeException('Unable to prepare outstanding credit check');
	}
	mysqli_stmt_bind_param($debtStmt, 'ss', $today, $billId);
	mysqli_stmt_execute($debtStmt);
	$debtResult = mysqli_stmt_get_result($debtStmt);
	$debtRow = $debtResult ? mysqli_fetch_assoc($debtResult) : null;
	mysqli_stmt_close($debtStmt);

	$totalOutstanding = (float)($debtRow['total_outstanding'] ?? 0);
	$remainingCredit = $creditAmount - $totalOutstanding;
	$status['should_check'] = true;
	$status['insufficient'] = $orderTotal > $remainingCredit;
	$status['credit_amount'] = $creditAmount;
	$status['remaining_credit'] = $remainingCredit;
	$status['order_total'] = $orderTotal;
	return $status;
}

date_default_timezone_set("Asia/Bangkok");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$ref_id = trim($_POST["ref_id"]);

$have_product = $_POST['have_product'] ?? '0';
$des_product =  $_POST['des_product'];
$bill_name = $_POST["bill_name"];


$id = $_POST["id"];
$sn_number = $_POST["sn"];
$product_id = $_POST["product_id"];
$code_same  = $_POST["product_code_same"];

if ($have_product === '1') {
	try {
		$creditStatus = getDepositOrderCreditStatus($conn, $code, $ref_id);
		if ($creditStatus['insufficient']) {
			$message = "วงเงินไม่เพียงพอ\nวงเงินคงเหลือ: " . number_format($creditStatus['remaining_credit'], 2) . " บาท\nยอดออเดอร์: " . number_format($creditStatus['order_total'], 2) . " บาท";
			echo '<script>alert(' . json_encode($message, JSON_UNESCAPED_UNICODE) . ');history.back();</script>';
			exit;
		}
	} catch (Throwable $e) {
		error_log('Deposit order credit check failed for ' . $ref_id . ': ' . $e->getMessage());
		echo '<script>alert(' . json_encode('ไม่สามารถตรวจสอบวงเงินเครดิตได้ กรุณาลองใหม่อีกครั้ง', JSON_UNESCAPED_UNICODE) . ');history.back();</script>';
		exit;
	}
}
	
$save="Update  hos__so set have_product ='".$have_product."',des_product ='".$des_product."'  where ref_id='".$ref_id."'";

//echo $save;
$qsave=mysqli_query($conn,$save);



if($have_product=='1'){

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "KLadYmSxQFDtfywN5HqZHCipQ2cSX6aBd6JVtZf063h";
$sMessage = "หมายเลขอ้างอิง $ref_id คุณ $bill_name มีสินค้าครับ ";
$chOne = curl_init();
curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt( $chOne, CURLOPT_POST, 1);
curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage);
$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec( $chOne );
if(curl_error($chOne))
{
echo 'error:' . curl_error($chOne);
}
else {
$result_ = json_decode($result, true);
echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne );  


	
	
	
$save1="Update  hos__so set have_product = '2'  where ref_id='".$ref_id."'";

//echo $save;
$qsave1=mysqli_query($conn,$save1);
	
}


//exit();


	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_stockhos_Accept.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


