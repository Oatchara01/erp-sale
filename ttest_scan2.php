<?php
// เมื่อกด Submit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitData'])) {
    $productCodes = $_POST['product_code'] ?? [];
    $sns = $_POST['sn'] ?? [];
    $lotNos = $_POST['lot_no'] ?? [];
    $expiryDates = $_POST['expiry_date'] ?? [];

    echo "<h2>รายการที่คุณส่งมา:</h2>";
    echo "<table border='1' cellpadding='8'><tr><th>Product Code</th><th>SN</th><th>LOT No.</th><th>Expiry Date</th></tr>";
    for ($i = 0; $i < count($productCodes); $i++) {
        echo "<tr>
                <td>{$productCodes[$i]}</td>
                <td>{$sns[$i]}</td>
                <td>{$lotNos[$i]}</td>
                <td>{$expiryDates[$i]}</td>
              </tr>";
    }
    echo "</table><br><a href='qr_scan.php'>กลับ</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ยิง QR แล้วแยกข้อมูลทันที</title>
    <style>
        label { display: inline-block; width: 140px; margin-top: 10px; }
        input[type="text"] { width: 300px; padding: 5px; margin-bottom: 5px; }
        table, th, td { border: 1px solid black; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 6px 12px; }
    </style>
</head>
<body>
    <h2>ยิง QR Code แล้วแยกข้อมูลทันที</h2>

    <!-- ช่องยิง QR -->
    <input type="text" id="qrInput" autofocus placeholder="ยิง QR ที่นี่" style="width: 500px; height: 30px; font-size: 16px;" oninput="handleQRInput()">

    <!-- ช่องแสดงข้อมูลแยก -->
    <div style="margin-top: 20px;">
        <label>Product Code:</label>
        <input type="text" id="productCode" readonly><br>
        <label>Serial Number (SN):</label>
        <input type="text" id="sn" readonly><br>
        <label>LOT No.:</label>
        <input type="text" id="lotNo" readonly><br>
        <label>Expiry Date:</label>
        <input type="text" id="expiryDate" readonly><br>
    </div>

    <!-- Log -->
    <h3>Log ประวัติการยิง</h3>
    <textarea id="qrLog" rows="8" cols="80" readonly style="background-color: #f5f5f5;"></textarea>

    <!-- ฟอร์มส่งข้อมูล -->
    <form method="post" id="qrForm">
        <table id="resultTable">
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Serial Number (SN)</th>
                    <th>LOT No.</th>
                    <th>Expiry Date</th>
                </tr>
            </thead>
            <tbody id="resultBody">
            </tbody>
        </table>
        <br>
        <button type="submit" name="submitData">Submit</button>
    </form>

    <script>
        function handleQRInput() {
            const input = document.getElementById('qrInput');
            const text = input.value.trim();

            // ใช้ regex ย่อยจับข้อมูลแบบไม่สนลำดับ
            const productCodeMatch = text.match(/Product Code:([0-9]+)/);
            const snMatch = text.match(/SN:\s*([0-9]+)/);
            const lotNoMatch = text.match(/LOT No.:\s*([a-zA-Z0-9]+)/);
            const expiryDateMatch = text.match(/Expiry Date:([0-9]{4}-[0-9]{2}-[0-9]{2})/);

            if (productCodeMatch && snMatch && lotNoMatch && expiryDateMatch) {
                const productCode = productCodeMatch[1];
                const sn = snMatch[1];
                const lotNo = lotNoMatch[1];
                const expiryDate = expiryDateMatch[1];

                // แสดงใน text fields
                document.getElementById('productCode').value = productCode;
                document.getElementById('sn').value = sn;
                document.getElementById('lotNo').value = lotNo;
                document.getElementById('expiryDate').value = expiryDate;

                // เพิ่มแถวในตาราง + input hidden สำหรับ submit
                const table = document.getElementById('resultBody');
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>
                        ${productCode}
                        <input type="hidden" name="product_code[]" value="${productCode}">
                    </td>
                    <td>
                        ${sn}
                        <input type="hidden" name="sn[]" value="${sn}">
                    </td>
                    <td>
                        ${lotNo}
                        <input type="hidden" name="lot_no[]" value="${lotNo}">
                    </td>
                    <td>
                        ${expiryDate}
                        <input type="hidden" name="expiry_date[]" value="${expiryDate}">
                    </td>
                `;
                table.appendChild(row);

                // เพิ่ม log
                const log = document.getElementById('qrLog');
                log.value += text + "\n";
                log.scrollTop = log.scrollHeight;

                // ล้าง input
                input.value = '';
                input.focus();
            }
        }
    </script>
</body>
</html>
