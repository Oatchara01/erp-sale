<?php
	//include('head.php'); 
?>
<?php
// รับ JSON จาก LINE
/*$content = file_get_contents("php://input");

// บันทึกข้อมูลที่ได้รับจาก LINE
file_put_contents("webhook_log.txt", $content . "\n", FILE_APPEND);

$events = json_decode($content, true);

if (!empty($events['events'])) {
    foreach ($events['events'] as $event) {
        $eventType = $event['type'] ?? 'unknown';
        $sourceType = $event['source']['type'] ?? 'unknown';
        $groupId = $event['source']['groupId'] ?? 'ไม่พบ Group ID';

        file_put_contents("group_list.txt", "Event Type: " . $eventType . " | Source Type: " . $sourceType . " | Group ID: " . $groupId . "\n", FILE_APPEND);

        // ถ้าเป็นข้อความจากกลุ่ม ให้ตอบกลับ
        if ($eventType == 'message' && $sourceType == 'group') {
            $replyToken = $event['replyToken'] ?? '';
            $messageText = $event['message']['text'] ?? 'ไม่มีข้อความ';
            replyMessage($replyToken, "คุณส่งข้อความว่า: " . $messageText . "\nGroup ID: " . $groupId);
        }
    }
}*/

// ฟังก์ชันตอบกลับข้อความ
/*function replyMessage($replyToken, $messageText) {
    $access_token = "2DutwYfMoMI48/RuKV97XCvKNeXCmxckpDRjJuk3nIKO6fAiGu9oxCyaF0KlzKwMc1vH2Atd0y/Tq3wpKZBKE6uDRwrJ/uMkTQTEbLkcrnM534HudNReyR3aO/qEUPGgpuoGnVV02eKU/0Imb8y4QwdB04t89/1O/w1cDnyilFU=";
    $data = [
        "replyToken" => $replyToken,
        "messages" => [["type" => "text", "text" => $messageText]]
    ];

    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $access_token
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_exec($ch);
    curl_close($ch);
}

echo "OK";*/
?>
