<?php
function watermarkImage ($SourceFile, $WaterMarkText, $WaterMarkText1, $WaterMarkText2, $DestinationFile) {
list($width, $height) = getimagesize($SourceFile);
$image_p = imagecreatetruecolor($width, $height);

$image = imagecreatefromjpeg($SourceFile);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);
$black = imagecolorallocate($image_p, 255, 255, 255);//กำหนดสี
$font = 'PSLxKittithada_Bold.ttf';//กำหนดชื่อฟอนต์
$font_size = 36; //กำหนดขนาดฟอนต์
imagettftext($image_p, $font_size, 0, 245, 325, $black, $font, $WaterMarkText);
	imagettftext($image_p, $font_size, 0, 580, 325, $black, $font, $WaterMarkText1);
	imagettftext($image_p, $font_size, 0, 400, 417, $black, $font, $WaterMarkText2);
//อธิบาย imagettftext($image_p,ขนาดฟอนต์,องศ์ษา,แนวนอน,แนวตั้ง,สี,ชื่อฟอร์ตที่ใช้,ข้อความ);
if ($DestinationFile<>'') {
imagejpeg ($image_p, $DestinationFile, 100);
} else {
header('Content-Type: image/jpeg');
imagejpeg($image_p, null, 100);
};
imagedestroy($image);
imagedestroy($image_p);
};




?>