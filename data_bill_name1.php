<?php


include"dbconnect.php"; 

$strProduct = trim($_POST["bill_id"]);

$strSQL = "SELECT * FROM tb_customer WHERE customer_id = '".$strProduct."' ";

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
if($objResult)
{
	
$strSQL1 = "SELECT type_name FROM tb_typecustomer WHERE type_id = '".$objResult["type_customer"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	
$typeName = $objResult1 ? $objResult1["type_name"] : "";
	
	$pro ="จ.";
	$del_address =$objResult["del_address"];
	$del_ampher = $objResult["del_ampher"];
	$del_province =$objResult["del_province"];
	$del_postcode=$objResult["del_postcode"];
	$delivery ="$del_address $del_ampher $del_province $del_postcode";
	
	$data = array(
		$objResult["bill_name"], // index 0: ชื่อบิล
		$objResult["bill_address"] . " " . $objResult["bill_ampher"] . " " . $pro . " " . $objResult["billl_province"] . " " . $objResult["bill_postcode"], // index 1: ที่อยู่ออกบิลรวม
		$objResult["bill_tel"], // index 2: เบอร์โทรออกบิล
		$objResult["tax_id"], // index 3: เลขผู้เสียภาษี
		$objResult["customer_no"], // index 4: รหัสลูกค้า
		$objResult["cus_tel"], // index 5: เบอร์โทรลูกค้า
		$objResult["bill_address"], // index 6: ที่อยู่ออกบิล
		$objResult["bill_ampher"], // index 7: อำเภอออกบิล
		$objResult["billl_province"], // index 8: จังหวัดออกบิล
		$objResult["bill_postcode"], // index 9: รหัสไปรษณีย์ออกบิล
		$objResult["preface_name"], // index 10: คำนำหน้าชื่อ
		$objResult["tax_id"], // index 11: เลขผู้เสียภาษี (ซ้ำ)
		$objResult["delivery_name"], // index 12: ชื่อจัดส่ง
		$objResult["del_address"], // index 13: ที่อยู่จัดส่ง
		$objResult["del_ampher"], // index 14: อำเภอจัดส่ง
		$objResult["del_province"], // index 15: จังหวัดจัดส่ง
		$objResult["del_postcode"], // index 16: รหัสไปรษณีย์จัดส่ง
		$objResult["del_tel"], // index 17: เบอร์โทรจัดส่ง
		$objResult["contact_name"], // index 18: ชื่อผู้ติดต่อ
		$delivery, // index 19: ที่อยู่จัดส่งรวม
		$objResult["mode_name"], // index 20: กลุ่มลูกค้า
		$objResult["email_cus"], // index 21: อีเมล
		$typeName, // index 22: ประเภทลูกค้า
		$objResult["credit_ckk"], // index 23: วิธีชำระเงิน
		$objResult["credit_thb"], // index 24: วงเงินเครดิต
		$objResult["vip_ckk"], // index 25: สถานะ VIP
		$objResult["customer_code"], // index 26: รหัสลูกค้า AWL
		$objResult["customer_coden"], // index 27: รหัสลูกค้า NBM
		$objResult["status_cus"] // index 28: สถานะลูกค้า (0=Gold, 1=Platinum, 2=Diamond)
	);

	echo implode('|', $data);

}

?>


