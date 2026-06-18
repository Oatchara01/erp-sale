<?php
mb_internal_encoding('UTF-8');

// =======================
// Config
// =======================
$base  = 'https://backend.allwellsmartcare.com';

// รับ JWT จาก ENV เพื่อความปลอดภัย (ตั้งด้วย: export ALLWELL_JWT="eyJ...")
// ถ้าอยากฮาร์ดโค้ด ให้ใส่แทนที่ 'YOUR_JWT_TOKEN_HERE'
$token = getenv('ALLWELL_JWT') ?: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MTIsInVzZXJuYW1lIjoiYWxsd2VsbGFwaSIsImhvc3BpdGFsSWQiOm51bGwsInJvbGUiOiJhZG1pbiIsImlhdCI6MTc1NTUxMjk1MX0.kTDRt3LM4xZ8od2cIzj7oh62-OztK0-i4TRpQCkIDOQ';

// ค่าพื้นฐาน (จะถูก override ด้วยอาร์กิวเมนต์ CLI ด้านล่างได้)
$hospitalId = null;                  // เช่น 12
$snCsv      = 'AAAA001,AAAA002';     // SN คั่นด้วย comma (จะรองรับช่องว่าง/ขึ้นบรรทัด/; ด้วย)
$deviceType = 'GlucoAll-Pro';

// =======================
// CLI overrides
// รูปแบบ: php allwell_devices.php <hospitalId> "sn1,sn2" <deviceType> <JWT(optional)>
// ตัวอย่าง: php allwell_devices.php 12 "AAAA001,AAAA002" "GlucoAll-Pro" "YOUR_JWT"
// =======================
if (PHP_SAPI === 'cli') {
    if (!empty($argv[1])) $hospitalId = (int)$argv[1];
    if (!empty($argv[2])) $snCsv      = (string)$argv[2];
    if (!empty($argv[3])) $deviceType = (string)$argv[3];
    if (!empty($argv[4])) $token      = (string)$argv[4];
}

// =======================
// Helpers
// =======================
function apiRequest(string $method, string $endpoint, string $token, array $data = null) {
    $url = rtrim($GLOBALS['base'], '/') . $endpoint;
    $ch  = curl_init($url);

    $headers = [
        'Authorization: Bearer ' . $token,
        'Accept: application/json',
    ];
    if (!is_null($data)) {
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => $method,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ]);

    $raw    = curl_exec($ch);
    $errno  = curl_errno($ch);
    $error  = curl_error($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($errno) {
        throw new Exception("cURL error: $error");
    }
    $json = json_decode($raw, true);

    if ($status < 200 || $status >= 300) {
        if ($status === 401) {
            $detail = is_array($json) ? json_encode($json, JSON_UNESCAPED_UNICODE) : $raw;
            throw new Exception("HTTP 401 Unauthorized: ตรวจสอบ JWT (ถูกต้อง/ยังไม่หมดอายุ)\nรายละเอียด: ".$detail);
        }
        $msg = is_array($json) ? json_encode($json, JSON_UNESCAPED_UNICODE) : $raw;
        throw new Exception("HTTP $status: $msg");
    }
    return $json ?? $raw;
}

// แยก SN จากสตริง: รองรับ คอมมา, ช่องว่าง, เว้นบรรทัด, ; และลบซ้ำ/ช่องว่าง
function parseSNs(string $s): array {
    $parts = preg_split('/[\s,;]+/u', $s);
    $parts = array_values(array_unique(array_filter(array_map('trim', $parts))));
    return $parts;
}

// ====== helper สำหรับตารางใน CLI ======
function pad_mb(string $text, int $width): string {
    $text = (string)$text;
    if (mb_strlen($text) > $width) {
        $text = rtrim(mb_strimwidth($text, 0, $width - 1, '…', 'UTF-8'));
    }
    $len = mb_strlen($text);
    return $text . str_repeat(' ', max(0, $width - $len));
}

function print_table(array $headers, array $rows, array $maxWidths = []): void {
    // คำนวณความกว้างคอลัมน์จาก header + data แล้วจำกัดความยาวสูงสุดถ้ามี
    $widths = [];
    foreach ($headers as $i => $h) $widths[$i] = mb_strlen($h);
    foreach ($rows as $r) {
        foreach ($r as $i => $cell) {
            $widths[$i] = max($widths[$i] ?? 0, mb_strlen((string)$cell));
        }
    }
    foreach ($widths as $i => $w) {
        if (isset($maxWidths[$i])) $w = min($w, (int)$maxWidths[$i]);
        $widths[$i] = max($w, mb_strlen($headers[$i]));
    }

    $border = '+';
    foreach ($widths as $w) $border .= str_repeat('-', $w + 2) . '+';

    echo $border . PHP_EOL . '|';
    foreach ($headers as $i => $h) echo ' ' . pad_mb($h, $widths[$i]) . ' |';
    echo PHP_EOL . $border . PHP_EOL;

    foreach ($rows as $r) {
        echo '|';
        foreach ($r as $i => $cell) echo ' ' . pad_mb((string)$cell, $widths[$i]) . ' |';
        echo PHP_EOL;
    }
    echo $border . PHP_EOL;
}

function usage(): void {
    echo PHP_EOL .
        "วิธีใช้: php allwell_devices.php <hospitalId> \"sn1,sn2\" <deviceType> <JWT(optional)>" . PHP_EOL .
        "ตัวอย่าง: php allwell_devices.php 12 \"AAAA001,AAAA002\" \"GlucoAll-Pro\" \"YOUR_JWT\"" . PHP_EOL;
}

// =======================
// Guards
// =======================
if (!$token || $token === 'YOUR_JWT_TOKEN_HERE') {
    echo "ยังไม่ได้ตั้ง JWT: โปรดตั้ง ENV ALLWELL_JWT หรือส่งเป็นอาร์กิวเมนต์ตัวที่ 4" . PHP_EOL;
    usage();
    exit(1);
}
if (empty($deviceType)) {
    echo "deviceType ว่าง: โปรดระบุ เช่น GlucoAll-Pro" . PHP_EOL;
    usage();
    exit(1);
}

// =======================
// Main
// =======================
try {
    // ถ้าไม่ระบุ hospitalId -> โชว์ตารางรายชื่อโรงพยาบาลแล้วจบ
    if (empty($hospitalId) || $hospitalId <= 0) {
        $h = apiRequest('GET', '/api/v1/hospitals', $token);
        $items = (is_array($h) && isset($h['data']) && is_array($h['data'])) ? $h['data'] : $h;

        $rows = [];
        foreach ($items as $it) {
            if (!is_array($it)) continue;
            $id   = $it['id'] ?? $it['hospitalId'] ?? null;
            $name = $it['name'] ?? $it['hospitalName'] ?? $it['title'] ?? null;
            if ($id !== null && $name) $rows[] = [(string)$id, (string)$name];
        }

        print_table(['ID', 'ชื่อโรงพยาบาล'], $rows, [10, 70]);
        usage();
        exit(0);
    }

    // ตรวจสอบว่า hospitalId มีจริง
    $h = apiRequest('GET', '/api/v1/hospitals', $token);
    $items = (is_array($h) && isset($h['data']) && is_array($h['data'])) ? $h['data'] : $h;

    $exists = false; $hospitalName = '';
    foreach ($items as $it) {
        if (!is_array($it)) continue;
        $id = $it['id'] ?? $it['hospitalId'] ?? null;
        if ((int)$id === (int)$hospitalId) {
            $exists = true;
            $hospitalName = $it['name'] ?? $it['hospitalName'] ?? $it['title'] ?? '';
            break;
        }
    }
    if (!$exists) {
        echo "ไม่พบ hospitalId = {$hospitalId} ในระบบ" . PHP_EOL;
        // แสดงตารางช่วยค้นให้ด้วย
        $rows = [];
        foreach ($items as $it) {
            if (!is_array($it)) continue;
            $id   = $it['id'] ?? $it['hospitalId'] ?? null;
            $name = $it['name'] ?? $it['hospitalName'] ?? $it['title'] ?? null;
            if ($id !== null && $name) $rows[] = [(string)$id, (string)$name];
        }
        print_table(['ID', 'ชื่อโรงพยาบาล'], $rows, [10, 70]);
        usage();
        exit(1);
    }

    // เตรียม SN และยิง POST
    $snList = parseSNs($snCsv);
    if (!$snList) {
        echo "snDevice ว่าง: โปรดระบุอย่างน้อย 1 SN" . PHP_EOL;
        usage();
        exit(1);
    }

    echo "เลือกโรงพยาบาล: [{$hospitalId}] {$hospitalName}" . PHP_EOL;
    $payload = [
        "snDevice"   => array_values($snList),
        "patientId"  => null,
        "hospitalId" => (int)$hospitalId,
        "deviceType" => $deviceType,
    ];

    $resp = apiRequest('POST', '/api/v1/devices', $token, $payload);
    echo "ผลลัพธ์การสร้าง devices:" . PHP_EOL;
    echo json_encode($resp, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . PHP_EOL;

} catch (Exception $e) {
    // แสดง error ชัดเจน
    fwrite(STDERR, "Error: " . $e->getMessage() . PHP_EOL);
    exit(1);
}
