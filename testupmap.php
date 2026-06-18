<?php
include('dbconnect.php');
$target_dir = "map/";
$target_file = $target_dir . basename($_FILES["mapfile"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["mapfile"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "ไฟล์ชื่อนี้มีการอัพโหลดแล้ว หากคุณแน่ใจว่าไม่ซ้ำกับรูปที่ระบบฟ้องว่ามี กรุณาเปลี่ยนชื่อไฟล์ใหม่และอัพโหลดอีกครั้ง";
    $uploadOk = 0;
}
// Allow certain file formats
else if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo " กรุณาอัพโหลดไฟล์รูปภาพที่มีนามสกุล JPG, JPEG, PNG & GIF เท่านั้น";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
else if ($uploadOk == 0) {
    echo " ไฟล์ของคุณไม่ได้รับการอัพโหลด";
// if everything is ok, try to upload file
}
else {
    if (move_uploaded_file($_FILES["mapfile"]["tmp_name"], $target_file)) {
		mysqli_query($conn,"insert into map (mapfile) values ('".$_FILES["mapfile"]["tmp_name"]."')");
        echo " ไฟล์ ". basename( $_FILES["mapfile"]["name"]). " ได้รับการอัพโหลดเรียบร้อยแล้ว";
    } else {
        echo " ขออภัย ไม่สามารถอัพโหลดไฟล์ได้ในขณะนี้ กรุณาลองให่อีกครั้ง";
    }
}
?>