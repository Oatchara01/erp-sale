<?php
// URL สำหรับ redirect
$url = 'https://auth.lazada.com/oauth/authorize?response_type=code&force_auth=true&redirect_uri=https://sol.allwellcenter.com/LazadaShopVerify.php&client_id=124441';

// ทำการ redirect ไปที่ URL
header('Location: ' . $url);
exit;
?>
