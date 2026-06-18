<script type="text/javascript" src="//laz-g-cdn.alicdn.com/sj/securesdk/0.0.3/securesdk_lzd_v1.js" id="J_secure_sdk_v2" data-appkey="124441"></script>

<?php
include "databaseHelper.php";
include "LazadaAPI.php";
include "dbconnect.php";
include "dbconnect_acc.php";	
include "head.php";
require_once 'LazopSdk.php';


?>
<form name="frmSearch" method="GET" >
<div class="w3-white">
<div class="w3-container w3-padding-large">	
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>ปริ้นใบปะ Lazada</h4>
					</div>		
<?php
$running = '1'; 	
$accessToken = base64_decode(getTokenFromDB($running));	
	
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_ckk']) && isset($_POST['ref_id']) && isset($_POST['order_id'])) {
        $order_ckk = $_POST['order_ckk'];
        $order_id = $_POST['order_id'];
        $ref_id = $_POST['ref_id'];

        $orderList = []; 
        $packageList = []; 

        foreach ($ref_id as $key => $value) {
            if (isset($order_ckk[$key]) && $order_ckk[$key] == '1') {
                $orderList[] = $order_id[$key];
				
		$strSQL = "Update  so__main set printst_ckk='1' Where order_id = '".$order_id[$key]."'";
        $objQuery = mysqli_query($conn,$strSQL);
				
            }
        }
        //print_r($orderList); // เช็คค่าที่ถูกเก็บ
    } else {
        echo "ข้อมูลไม่ครบถ้วน";
    }
}
// 🔹 ตรวจสอบว่ามี order_id หรือไม่
if (!empty($orderList)) {
    foreach ($orderList as $orderId) {
        $params = [
            ["name" => "order_id", "value" => $orderId]
        ];

        $obj = getOrderItems($accessToken, $params);

        if ($obj->code == "0") {
            foreach ($obj->data as $item) {
                $package_id = $item->package_id;
                array_push($packageList, ["package_id" => $package_id]);
            }
        }
    }
}

// 🔹 ตรวจสอบว่ามี package_id หรือไม่
if (!empty($packageList)) {
    // 🔹 สร้างโฟลเดอร์เก็บไฟล์รวม
    $directory = __DIR__ . "/AWB_lazada/";
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    $mergedHtmlContent = ""; // ✅ เก็บ HTML ของทุก Packing List
    $mergedPdfUrls = []; // ✅ เก็บลิงก์ของ Shipping Label PDF

    foreach ($packageList as $package) {
        $package_id = $package['package_id'];

        // 🔹 ดึงใบปะหน้า (Shipping Label)
        $printParamsLabel = [
            ["name" => "getDocumentReq", "value" => json_encode([
                "doc_type" => "PDF",
                "print_item_list" => "false",
                "packages" => [$package]
            ])]
        ];
        $responseLabel = setprintlabel($accessToken, $printParamsLabel);

        if (isset($responseLabel->code) && $responseLabel->code == "0") {
            if (isset($responseLabel->result->data->pdf_url)) {
                $mergedPdfUrls[] = $responseLabel->result->data->pdf_url;
            }
        }

        // 🔹 ดึง Packing List (HTML)
        $printParamsPacking = [
            ["name" => "getDocumentReq", "value" => json_encode([
                "doc_type" => "HTML",
                "print_item_list" => "true",
                "packages" => [$package]
            ])]
        ];
        $responsePacking = setprintlabel($accessToken, $printParamsPacking);

 if (isset($responsePacking->code) && $responsePacking->code == "0") {
    if (isset($responsePacking->result->data->file)) {
        $htmlContent = base64_decode($responsePacking->result->data->file);

        // ✅ แปลงเอนโค้ดให้รองรับภาษาไทย
        $htmlContent = mb_convert_encoding($htmlContent, 'UTF-8', 'auto');

        // ✅ เพิ่ม meta charset UTF-8
        $metaTag = "<meta charset='UTF-8'>";

        // ✅ CSS สำหรับขนาด A6 (10.5 × 14.8 cm) และให้ใบปะ + Packing List ต่อกัน
        $css = "<style>
            @media print {
                .document-container {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    width: 10.5cm;
                }
                .document-page {
                    width: 10.5cm;
                    height: 14.8cm;
                    margin-bottom: 10px;
                    border: 1px solid #000;
                    padding: 10px;
                    page-break-inside: avoid;
                    font-family: 'Sarabun', sans-serif; /* ✅ รองรับภาษาไทย */
                }
            }
            .document-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 10.5cm;
            }
            .document-page {
                width: 10.5cm;
                height: 14.8cm;
                border: 1px solid #000;
                padding: 10px;
                margin-bottom: 10px;
                font-family: 'Sarabun', sans-serif; /* ✅ รองรับภาษาไทย */
            }
        </style>";

        // ✅ รวม AWB (ใบปะหน้า) + Packing List ไว้ในไฟล์เดียว
        $mergedHtmlContent .= $metaTag . $css . "<div class='document-container'>
                <div class='document-page'>$printUrlLabel</div> 
                <div class='document-page'>$htmlContent</div>
            </div>";
    }
}


    }

    // ✅ บันทึก Packing List ที่รวมกัน
    $htmlFilePath = $directory . "merged_packing_list.html";
    file_put_contents($htmlFilePath, $mergedHtmlContent);
    echo "<center>";
    // ✅ แสดงปุ่มปริ้น Packing List (รวมทุกออเดอร์)
    if ($mergedHtmlContent != "") {
        $webHtmlPath = "AWB_lazada/merged_packing_list.html";
        echo "<a href='$webHtmlPath' class='w3-button w3-orange' target='_blank'>🖨️ ปริ้น Packing List</a><br>";
    }

    echo "</center>";
} else {
    echo "❌ ไม่พบข้อมูลใบปะที่ยังไม่ได้ปริ้นขนส่ง<br>";
}

?>
	
	
</p></p></p></p>
<center>
<?php
$add_date = date('Y-m-d');	


?>
	
<input type="button" name ="Submit" value="กลับสู่หน้าหลัก" class = "button button4" onClick="this.form.action='status_getlzd.php'; submit()">	
	
	
	</div></div>
	</p></p>
	
</center>

</form>