<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สแกน QR Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
        }
        h2, h3 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #f9f9f9;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
<h2>ยิง QR Code แล้วแยกข้อมูลทันที</h2>
<div style="display: flex; ">
    <div style="width: 50%; padding:10px;">
        <h3>ช่องระบุ QR Code</h3>
        <textarea style="width: 100%;" rows="5" id="qrInput" autofocus placeholder="สแกน QR Code ที่นี่"></textarea>
    </div>
    <div style="width: 50%; padding:10px;">
        <h3>Log ประวัติการยิง</h3>
        <textarea style="width: 100%;" rows="5" id="qrLog" readonly></textarea>
    </div>
</div>
    

    <!-- ตารางแสดงข้อมูล -->
    <h3>ข้อมูล QR Code</h3>
    <table id="qrTable">
        <thead>
            <tr>
                <th>Product Code</th>
                <th>SN</th>
                <th>LOT No.</th>
                <th>Expiry Date</th>
                <th>Production Date</th>
            </tr>
        </thead>
        <tbody id="qrTableBody">
            <!-- ข้อมูลจะถูกเพิ่มโดย JavaScript -->
        </tbody>
    </table>

    <script>
        const listAll = [];
        let inputBuffer = ''; // เก็บข้อมูลชั่วคราว
        let timeoutId = null; // สำหรับ debounce

        function handleQRInput(valueIn) {
            inputBuffer = valueIn.trim(); // อัปเดต buffer

            // ใช้ debounce เพื่อรอข้อมูลครบ
            if (timeoutId) clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                processQRInput(inputBuffer);
            }, 500); // รอ 500ms หลังหยุดพิมพ์/สแกน
        }

        function processQRInput(input) {
            // Regex ที่ยืดหยุ่นขึ้น
            const keyProduct = /Product Code: *([0-9]+)/i;
            const cutkeyProduct = input.match(keyProduct);

            const keySn = /SN: *([0-9]+)/i;
            const cutKeySn = input.match(keySn);

            const keyLot = /LOT No\.?: *([a-zA-Z0-9]+)/i;
            const cutKeyLot = input.match(keyLot);

            const keyExpiry = /Expiry Date: *([0-9]{4}-[0-9]{1,2}-[0-9]{1,2})/i;
            const cutKeyExpiry = input.match(keyExpiry);

            const keyProduction = /Production Date: *([0-9]{4}-[0-9]{1,2}-[0-9]{1,2})/i;
            const cutKeyProduction = input.match(keyProduction);

            // ตรวจสอบว่ามี SN อย่างน้อย
            if (cutKeySn && cutKeySn[1]) {
                const data = {
                    product: cutkeyProduct ? cutkeyProduct[1] : '',
                    sn: cutKeySn ? cutKeySn[1] : '',
                    lot: cutKeyLot ? cutKeyLot[1] : '',
                    expiry: cutKeyExpiry ? cutKeyExpiry[1] : '',
                    production: cutKeyProduction ? cutKeyProduction[1] : '',
                };

                // เพิ่มข้อมูลลง listAll
                listAll.push(data);

                // อัปเดต qrLog
                document.getElementById('qrLog').value = listAll.map(item =>
                    `{"product":"${item.product}", "lot":"${item.lot}", "expiry":"${item.expiry}", "sn":"${item.sn}" , "production":"${item.production}"},`
                ).join('\n');

                // อัปเดตตาราง
                updateTable();

                // ส่งข้อมูลไป PHP
                fetch('ttest_scan.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    console.log('Response from PHP:', result);
                    if (result.status === 'error') {
                        alert('เกิดข้อผิดพลาด: ' + result.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            } else {
                console.log('ข้อมูล QR code ไม่ถูกต้อง:', input);
            }

            // ล้างช่อง input
            document.getElementById('qrInput').value = '';
            inputBuffer = ''; // ล้าง buffer
        }

        function updateTable() {
            const tableBody = document.getElementById('qrTableBody');
            tableBody.innerHTML = ''; // ล้างตารางก่อน

            listAll.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.product}</td>
                    <td>${item.sn}</td>
                    <td>${item.lot}</td>
                    <td>${item.expiry}</td>
                    <td>${item.production}</td>
                `;
                tableBody.appendChild(row);
            });
        }

        // แก้ไข event listener ให้ใช้ oninput
        document.getElementById('qrInput').addEventListener('input', (e) => {
            handleQRInput(e.target.value);
        });
    </script>
</body>
</html>


<!-- 
Output ที่ใช้งานได้ ณ ตอนนี้
{"product":"8859717401325", "lot":"250701", "expiry":"2030-07-02", "sn":"25070100837" , "production":"2025-07-03"},
{"product":"8859717400601", "lot":"593253001", "expiry":"2030-04-11", "sn":"59325300101800" , "production":""},
{"product":"8859717401325", "lot":"250701", "expiry":"2030-07-02", "sn":"25070100837" , "production":"2025-07-03"},
{"product":"8859717400601", "lot":"593253001", "expiry":"2030-04-11", "sn":"59325300101800" , "production":""},
-->