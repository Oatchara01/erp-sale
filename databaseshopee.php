
<?php
include "configDBsp.php";


function saveShopToken($obj)
{
    $result = false;
    $conn = OpenCon();
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // ตรวจสอบโครงสร้าง $obj ที่ได้รับจาก API
    var_dump($obj);

    // ตรวจสอบว่ามี access_token และ refresh_token หรือไม่
    if (!isset($obj['access_token']) || !isset($obj['refresh_token'])) {
        echo "Error: Missing access_token or refresh_token";
        return false;
    }

    $sql = "INSERT INTO shopToken (
        access_token,
        refresh_token,
        expires_in,
        account,
		request_id
    )
    VALUES (
        '" . $conn->real_escape_string(base64_encode($obj['access_token'])) . "',
        '" . $conn->real_escape_string(base64_encode($obj['refresh_token'])) . "',
        " . (int)$obj['expire_in'] . ",
        'shopee_account',
		" . (int)$obj['request_id'] . "
    )
    ON DUPLICATE KEY UPDATE
        access_token = VALUES(access_token),
        refresh_token = VALUES(refresh_token),
        expires_in = VALUES(expires_in)";

    if ($conn->query($sql) === TRUE) {
        $result = true;
    } else {
        echo "SQL Error: " . $conn->error;
    }

    CloseCon($conn);
    return $result;
}
	

function updateShopToken($obj, $running)
{
    $result = false;
    $conn = OpenCon();
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (!isset($obj['access_token']) || !isset($obj['refresh_token'])) {
        echo "Error: Missing access_token or refresh_token in the response.";
        return false;
    }

    $sql = "UPDATE shopToken
        SET
            access_token = '" . $conn->real_escape_string(base64_encode($obj['access_token'])) . "',
            refresh_token = '" . $conn->real_escape_string(base64_encode($obj['refresh_token'])) . "',
            expires_in = " . (int)$obj['expire_in'] . "
        WHERE
            running = " . (int)$running;

    if ($conn->query($sql) === TRUE) {
        $result = true;
    } else {
        echo "SQL Error: " . $conn->error;
    }

    CloseCon($conn);
    return $result;
}

function getTokenFromDB($running)
{
    $conn = OpenCon();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $access_token = null;
    $sql = "SELECT access_token  FROM shopToken WHERE running = " . $running;
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        $access_token = $row["access_token"];
        $result->close();
    }

    CloseCon($conn);
    return $access_token;
}

function getRefreshTokenFromDB($running)
{
    $conn = OpenCon();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $refresh_token = null;
    $sql = "SELECT refresh_token FROM shopToken WHERE running = " . (int)$running;
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        $refresh_token = base64_decode($row["refresh_token"]);  // ใช้ base64_decode() เพื่อดึงค่า refresh_token ที่แท้จริง
        $result->close();
    }

    CloseCon($conn);
    return $refresh_token;
}


function saveOrders($order_items_obj, $shop_running)
{
    $result = false;
    $conn = OpenCon();
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
date_default_timezone_set("Asia/Bangkok");

foreach ($order_items_obj->response->order_list as $order_details) {

$sql1 = "SELECT MAX(main_id) AS main_id FROM so__main";
$query1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$fetch1 = mysqli_fetch_array($query1);

$main_id =$fetch1['main_id']+1;
$doc_release_date= date('Y-m-d'); 
$register_date = date('Y-m-d');
$register_time = date('H:i:s');
$add_date = date('Y-m-d H:i:s');
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
$approve_complete = "Approve";

/*echo '<pre>';
print_r($order_details);
echo '</pre>';*/

	

// ดึงที่อยู่ผู้รับ
$recipient = $order_details->recipient_address;
$package = $order_details->package_list;

$order_id         = $order_details->order_sn;
$customer_name    = $recipient->name;
$delivery_name    = $recipient->name;
$order_name       = $recipient->name;
$billing_name     = $recipient->name;

$province         = $recipient->state;
$bill_province    = $recipient->state;
$ampher           = $recipient->city;
$bill_ampher      = $recipient->city;

$tel              = $recipient->phone;
$billing_tel      = $recipient->phone;
$delivery_contact = "$order_name / $tel";

$address1         = $recipient->district;
$ex_add           = $recipient->district;
$address2         = $recipient->city;

$billing_address  = $recipient->full_address;
$delivery_place   = $recipient->full_address;

$postcode         = $recipient->zipcode;
$bill_postcode    = $recipient->zipcode;

$order_item_id    = $package[0]->package_number;
$cs_remark = $package[0]->shipping_carrier ?? '';

$cus_online       = $order_details->buyer_username;
$create_time      = $order_details->create_time;
$create_order     = date("Y-m-d H:i:s", $create_time);

$sale_remark      = $order_details->checkout_shipping_carrier ?? ''; // ป้องกัน error กรณีไม่มี field
	

$pre_name = "";
$payment = "36";	
$add_date = date('Y-m-d H:i:s');
//$order_refer_code = $objArr[3];
$sale_channel = '12';
$delivery_date = date('Y-m-d');
$employee_name ="SOL92";
$job_id = "Kerry มารับ";
$delivery = '29';

	
 foreach ($package as $pkg) {
 $order_item_id = $pkg->package_number;
	 
 $sql_insert = "INSERT INTO so__uppack (ref_id, sale_channel, order_id, order_item_id) VALUES ('$main_id', '$sale_channel', '$order_id', '$order_item_id')";
$result = mysqli_query($conn, $sql_insert);
	 
	 
	 
 }



$sql2 = "SELECT order_id FROM so__main where order_id = '".$order_id."'";
$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($query2);
$fetch2 = mysqli_fetch_array($query2);
		
if($Num_Rows2 > 0){ 
}else{	

$bill_id = '0';	


 $strSQL = "INSERT INTO so__main (ref_id,register_date,register_time,delivery_name,address1,address2,province,postcode,billing_address,billing_name,billing_tel,tel,order_id,customer_name,order_name,delivery_contact,delivery_place,add_date,add_by,sale_channel,doc_release_date,status_doc,delivery_date,approve_complete,employee_name,job_id,delivery,payment,sale_remark,send_stock,bill_id,prefer_name,po_no,ex_add,ex_aumper,ex_provin,ex_post,pre_name,create_order,order_item_id,cs_remark) VALUES ('".$main_id."','".$register_date."','".$register_time."','".$delivery_name."','".$address1."','".$address2."','".$province."','".$postcode."','".$billing_address."','".$billing_name."','".$billing_tel."','".$tel."','".$order_id."','".$customer_name."','".$order_name."','".$delivery_contact."','".$delivery_place."','".$add_date."','".$add_by."','".$sale_channel."','".$doc_release_date."','2','".$delivery_date."','".$approve_complete."','".$employee_name."','".$job_id."','".$delivery."','".$payment."','".$sale_remark."','1','".$bill_id."','Shopee','".$order_id."','".$ex_add."','".$bill_ampher."','".$bill_province."','".$bill_postcode."','".$pre_name."','".$create_order."','".$order_item_id."','".$cs_remark."')";
$objQuery = mysqli_query($conn,$strSQL)or die(mysqli_error());
	
	
	
 foreach ($package as $pkg) {
 $package_number = $pkg->package_number;
	 
 $sql_insert = "INSERT INTO so__uppack (ref_id, sale_channel, order_id, order_item_id) VALUES ('$main_id', '12', '$order_id', '$package_number')";
$result = mysqli_query($conn, $sql_insert);
	 
	 
  if ($result) {
            echo "✅ Insert $order_item_id สำเร็จ<br>";
        } else {
            echo "❌ Insert ล้มเหลว: ".mysqli_error($conn)."<br>";
        }	 
 }	


}
}
}




function updateOrders($invoiceInfo, $order_sn)
{
	
$conn = OpenCon();
    if (!$conn) {
        echo "Database connection failed.";
        return;
    }

    if (!isset($invoiceInfo["data"][0])) {
        echo "No invoice_info_list data.";
        return;
    }

    $invoiceData = $invoiceInfo["data"][0];
	
	

  $sqlCheck = "SELECT * FROM so__main WHERE order_id = '$order_sn'";
    $queryCheck = mysqli_query($conn, $sqlCheck) or die(mysqli_error($conn));

    if (mysqli_num_rows($queryCheck) === 0) {
        echo "Order not found in database.";
        return;
    }

    $fetch = mysqli_fetch_array($queryCheck);
    $ref_id = $fetch["ref_id"];
   	$pre_ckk = $fetch["pre_ckk"];

	
	
    // ข้อมูลพื้นฐาน
    $invoiceDetail = $invoiceData["invoice_detail"] ?? [];
    $tax_no = $invoiceDetail["company_tax_id"] ?? $invoiceDetail["tax_id"] ?? '';
	//$address = $invoiceDetail["company_full_address"] ?? $invoiceDetail["full_address"] ?? '';
    $name1 = $invoiceDetail["company_name"] ?? $invoiceDetail["name"] ?? '';
    $phone_number = $invoiceDetail["company_phone_number"] ?? $invoiceDetail["phone_number"] ?? '';
    $email = $invoiceDetail["company_email"] ?? $invoiceDetail["email"] ?? '';

    // Address Breakdown
    $addressBreakdown = $invoiceDetail["company_address_breakdown"] ?? $invoiceDetail["address_breakdown"] ?? [];

    $region = $addressBreakdown["company_region"] ?? $addressBreakdown["region"] ?? '';
    $state = $addressBreakdown["company_state"] ?? $addressBreakdown["state"] ?? '';
    $city = $addressBreakdown["company_state"] ?? $addressBreakdown["state"] ?? '';
    $district = $addressBreakdown["company_district"] ?? $addressBreakdown["district"] ?? '';
    $town = $addressBreakdown["company_town"] ?? $addressBreakdown["town"] ?? '';
    $postcode = $addressBreakdown["company_postcode"] ?? $addressBreakdown["postcode"] ?? '';
    $detailed_address = $addressBreakdown["company_detailed_address"] ?? $addressBreakdown["detailed_address"] ?? '';
	$company_head_office = $invoiceDetail["company_head_office"] ?? '';
    $company_branch_name = $invoiceDetail["company_branch_name"] ?? '';
    $company_branch_id = $invoiceDetail["company_branch_id"] ?? '';
	
	

	if($company_branch_name!='' or $company_branch_id!=''){
	$h_ckk='2';
	$brun_no ="$company_branch_id$company_branch_name";	
	$name = $invoiceDetail["company_name"] ?? $invoiceDetail["name"] ?? '';	
	}else if($company_head_office=='yes'){
	$h_ckk='1';	
	$name = "$name1 สำนักงานใหญ่";	
	$brun_no ="";	
	}else{
	$h_ckk='0';
	$brun_no ="";	
	$name = $invoiceDetail["company_name"] ?? $invoiceDetail["name"] ?? '';		
	}
	
	

    $ex_add = trim($detailed_address . ' ' . $town);

    // อัปเดต tb_customer
    $sql9 = "SELECT customer_name FROM tb_customer WHERE customer_id = '{$fetch["bill_id"]}'";
    $query9 = mysqli_query($conn, $sql9) or die(mysqli_error($conn));
    $Num_Rows9 = mysqli_num_rows($query9);

    if ($Num_Rows9 > 0) {
        $save9 = "UPDATE tb_customer SET 
                    bill_name = '" . mysqli_real_escape_string($conn, $name) . "',
                    bill_address = '" . mysqli_real_escape_string($conn, $ex_add) . "',
                    bill_ampher = '" . mysqli_real_escape_string($conn, $district) . "',
                    billl_province = '" . mysqli_real_escape_string($conn, $city) . "',
                    bill_postcode = '" . mysqli_real_escape_string($conn, $postcode) . "',
                    bill_tel = '" . mysqli_real_escape_string($conn, $phone_number) . "',
                    email_cus = '" . mysqli_real_escape_string($conn, $email) . "',
                    tax_id = '" . mysqli_real_escape_string($conn, $tax_no) . "',
					h_ckk = '".$h_ckk."',
					brun_no = '".$brun_no."'
                 WHERE customer_id = '{$fetch["bill_id"]}'";
        mysqli_query($conn, $save9) or die(mysqli_error($conn));
    }
	
		
$bill_vat = '1';
$send_supadm = '1';
$status_vat  = "Approve";	
		
		
$doc_release_date= date('Y-m-d');		
if($fetch["select_type_doc"]=="1"){	
$select_type_doc ='3';	
	
$date = explode('-' , $doc_release_date );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_et_awl where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ET";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;

if($pre_ckk=='1'){
$doc_no = "";		
}else{	
	
$doc_no = $so.$year1.$mont.$nextId;	
		
$save5="insert into tb_et_awl (doc_no,year_no,mount_no,run_no,iv_date,ref_so) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$doc_release_date."','".$ref_id."')";
$qsave5=mysqli_query($conn,$save5);	
}	
	
	
}else if($fetch["select_type_doc"]=="2"){
$select_type_doc ='4';		
	
$date = explode('-' , $doc_release_date);
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_et_nbm where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ET";
$so1 = "-";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
	
	
if($pre_ckk=='1'){
$doc_no = "";		
}else{	
	
$doc_no = $so.$year1.$so1.$mont.$nextId;

$save="insert into tb_et_nbm (doc_no,year_no,mount_no,run_no,iv_date,ref_so) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$doc_release_date."','".$ref_id."')";
$qsave=mysqli_query($conn,$save);
}
	
}
	
	
$address = "$ex_add $district $city $postcode";	
	
$sqlUpdate = "UPDATE so__main 
                  SET billing_name = '" . mysqli_real_escape_string($conn, $name) . "',
                      tax_id = '" . mysqli_real_escape_string($conn, $tax_no) . "',
                      billing_address = '" . mysqli_real_escape_string($conn, $address) . "',
                      billing_tel = '" . mysqli_real_escape_string($conn, $phone_number) . "',
                      email = '" . mysqli_real_escape_string($conn, $email) . "',
                      ex_add = '" . mysqli_real_escape_string($conn, $ex_add) . "',
                      ex_aumper = '" . mysqli_real_escape_string($conn, $district) . "',
                      ex_provin = '" . mysqli_real_escape_string($conn, $city) . "',
                      ex_post = '" . mysqli_real_escape_string($conn, $postcode) . "',
                      bill_vat = '$bill_vat',
                      send_supadm = '$send_supadm',
                      status_vat = '$status_vat',
                      doc_no = '$doc_no',
                      select_type_doc = '$select_type_doc'
                  WHERE order_id = '$order_sn'";
    mysqli_query($conn, $sqlUpdate) or die(mysqli_error($conn));
		

 
}







function saveOrderItemWithEscrowFromDetail($response, $order_sn)
{
    global $conn;

    $ref_id = '';
    $stmt = mysqli_prepare($conn, "SELECT ref_id FROM so__main WHERE order_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $order_sn);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $ref_id_result);
    if (mysqli_stmt_fetch($stmt)) {
        $ref_id = $ref_id_result;
    }
    mysqli_stmt_close($stmt);
	
   $buyer_username = $response->buyer_user_name ?? '';
    $total_amount = $response->buyer_payment_info->buyer_total_amount ?? 0;
    $payment_method = $response->buyer_payment_info->buyer_payment_method ?? '';
    $order_seller_discount = $response->order_income->order_seller_discount ?? 0;
    $estimated_shipping_fee = $response->order_income->estimated_shipping_fee ?? 0;
    $actual_shipping_fee = $response->order_income->final_shipping_fee ?? 0;
	
$register_date = date('Y-m-d');
$add_date = date('Y-m-d H:i:s');

	
$sqlCheck = "SELECT * FROM so__main WHERE ref_id = '".$ref_id."'";
$queryCheck = mysqli_query($conn, $sqlCheck) or die(mysqli_error($conn));
$fetch = mysqli_fetch_array($queryCheck);	
	
$cs_remark = $fetch["cs_remark"];
$pre_ckk = $fetch["pre_ckk"];	
	
if($sale_remark=='Express Delivery - ส่งด่วน' ){
$save17="UPDATE so__main SET stock_remark ='pickup' where ref_id='".$ref_id."'";
$qsave17=mysqli_query($conn,$save17);	
}	
	
	
$sql9 = "SELECT customer_name FROM tb_customer where cus_online = '".$buyer_username."' and cus_online !=''";
$query9 = mysqli_query($conn,$sql9) or die(mysqli_error());
$Num_Rows9 = mysqli_num_rows($query9);
$fetch9 = mysqli_fetch_array($query9);
	
if($Num_Rows9 > 0){
	
$save9="UPDATE tb_customer SET
(customer_name='".$fetch["customer_name"]."',type_customer='7',cus_address='".$fetch["address1"]."',cus_ampher='".$fetch["address2"]."',cus_province='".$fetch["province"]."',cus_postcode='".$fetch["postcode"]."',cus_tel='".$fetch["tel"]."',bill_name='".$fetch["customer_name"]."',bill_address='".$fetch["address1"]."',bill_ampher='".$fetch["address2"]."',billl_province='".$fetch["province"]."',bill_postcode='".$fetch["postcode"]."',bill_tel='".$fetch["tel"]."',tax_id='".$fetch["tax_id"]."',delivery_name='".$fetch["customer_name"]."',del_address='".$fetch["address1"]."',del_ampher='".$fetch["address2"]."',del_province='".$fetch["province"]."',del_postcode='".$fetch["postcode"]."',del_tel='".$fetch["tel"]."',contact_name='".$fetch["delivery_contact"]."',email_cus='".$fetch["email"]."'  where cus_online = '".$buyer_username."'";
	
$qsave9=mysqli_query($conn,$save9);	
	
	
}else {	
	
$save9="insert into tb_customer
(customer_name,type_customer,cus_address,cus_ampher,cus_province,cus_postcode,cus_tel,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,bill_tel,delivery_name,del_address,del_ampher,del_province,del_postcode,del_tel,contact_name,sale_code,tax_id,email_cus,cus_online)
values
('".$fetch["customer_name"]."','7','".$fetch["address1"]."','".$fetch["address2"]."','".$fetch["province"]."','".$fetch["postcode"]."','".$fetch["tel"]."','".$fetch["customer_name"]."','".$fetch["address1"]."','".$fetch["address2"]."','".$fetch["province"]."','".$fetch["postcode"]."','".$fetch["tel"]."','".$fetch["customer_name"]."','".$fetch["address1"]."','".$fetch["address2"]."','".$fetch["province"]."','".$fetch["postcode"]."','".$fetch["tel"]."','".$fetch["delivery_contact"]."','SOL92','".$fetch["tax_id"]."','".$fetch["email"]."','".$buyer_username."')";
$qsave9=mysqli_query($conn,$save9);
	
}
	
	
$sql10 = "SELECT customer_id FROM tb_customer where cus_online = '".$buyer_username."'";
$query10 = mysqli_query($conn,$sql10) or die(mysqli_error());
$fetch10 = mysqli_fetch_array($query10);	

$bill_id = $fetch10["customer_id"];	
	
$strSQL = "Update  so__main set bill_id='".$bill_id."' Where ref_id = '".$ref_id."'";
$objQuery = mysqli_query($conn,$strSQL);	 
	

    // รายการสินค้า
	$companies = [];
	
    foreach ($response->order_income->items as $item) {
        //$sku = $item->model_sku ?? '';
		$sku1 = $item->model_sku ?? '';
		$sku2 = $item->item_sku ?? '';
		
		if($sku1!=''){
		$sku = $item->model_sku ?? '';
		}else if($sku2!=''){	
		$sku = $item->item_sku ?? '';	
		}	
		$original_price = $item->original_price ?? 0;
        $discounted_price = $item->discount_from_voucher_seller?? 0;
        //$seller_discount = $item->seller_discount ?? 0;
        $count = $item->quantity_purchased ?? 0;
		//$product_price =  $item->selling_price ?? 0;
		//$sum_amount =  $item->selling_price ?? 0;
		$product_price =  $item->discounted_price ?? 0;
		$sum_amount =  $item->discounted_price ?? 0;
		
		

	       
$sql2 = "SELECT * FROM tb_product_lzd WHERE code_lazada='" . $sku . "'";
//echo $sql2;		
$query2 = mysqli_query($conn, $sql2) or die(mysqli_error());
if (mysqli_num_rows($query2) === 0) {
continue;
}
$fetch2 = mysqli_fetch_array($query2);
		
		
$companies[] = $fetch2["company"] ?? '';		
		

$id_product1 = $fetch2["id_product1"];
$id_product2 = $fetch2["id_product2"];
$id_product3 = $fetch2["id_product3"];
$id_product4 = $fetch2["id_product4"];
$id_product5 = $fetch2["id_product5"];
$id_product6 = $fetch2["id_product6"];
$id_product7 = $fetch2["id_product7"];
$id_product8 = $fetch2["id_product8"];
$id_product9 = $fetch2["id_product9"];
$id_product10 = $fetch2["id_product10"];
	

$unit11 = $fetch2["unit1"];
$unit22 = $fetch2["unit2"];
$unit33 = $fetch2["unit3"];
$unit44 = $fetch2["unit4"];
$unit55 = $fetch2["unit5"];
$unit66 = $fetch2["unit6"];
$unit77 = $fetch2["unit7"];
$unit88 = $fetch2["unit8"];
$unit99 = $fetch2["unit9"];
$unit110 = $fetch2["unit10"];


$unit1 = $count*$unit11 ;
$unit2 = $count*$unit22 ;
$unit3 = $count*$unit33 ;
$unit4 = $count*$unit44 ;
$unit5 = $count*$unit55 ;
$unit6 = $count*$unit66 ;
$unit7 = $count*$unit77 ;
$unit8 = $count*$unit88 ;	
$unit9 = $count*$unit99 ;
$unit10 = $count*$unit110 ;

	
$waranty1 = $fetch2["waranty1"];
$waranty2 = $fetch2["waranty2"];
$waranty3 = $fetch2["waranty3"];
$waranty4 = $fetch2["waranty4"];
$waranty5 = $fetch2["waranty5"];
$waranty6 = $fetch2["waranty6"];
$waranty7 = $fetch2["waranty7"];
$waranty8 = $fetch2["waranty8"];
$waranty9 = $fetch2["waranty9"];
$waranty10 = $fetch2["waranty10"];
$big_ckk = $fetch2["big_ckk"];		

$price_lazada = $fetch2["percen_price"]; 	

if($sum_amount < $price_lazada){	
	
$strSQL15 = "SELECT ref_id,doc_no,select_type_doc FROM  so__main  where ref_id='".$ref_id."'";
$objQuery15 = mysqli_query($stock_out,$strSQL15);
$objResult15 = mysqli_fetch_array($objQuery15);		

$save19="UPDATE so__main SET price_ckk ='1',approve_complete='Request' where ref_id='".$ref_id."'";
$qsave19=mysqli_query($conn,$save19);	

}
		
if($pre_ckk=='1'){
	
if($fetch2["company"]=="AWL"){	
	
$select_type_doc ='1';	
$doc_no = "";	
	
}else if($fetch2["company"]=="NBM"){	
	
$select_type_doc ='2';
$doc_no = "";	
	
}
		

}else if($fetch2["company"]=="AWL"){
	
$select_type_doc ='1';	

$sql1 = "SELECT doc_no FROM tb_solptl where sale_channel = '".$sale_channel."' and date_sol = '".$register_date."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($qry1);
$rs1 = mysqli_fetch_assoc($qry1);	

	
if($Num_Rows > 0){
$doc_no = $rs1["doc_no"];	
}else{
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(doc_no) AS MAXID FROM tb_solptl";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -3);
$maxId3 = substr($rs['MAXID'],-7);

$maxId1 = substr($maxId3,0,-3);
$so = "SOL";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "001"; 
$nextId = $yearMonth.$maxId1;

}

$doc_no = $so.$nextId;
	

$save="insert into tb_solptl (doc_no,date_sol,sale_channel ) values ('".$doc_no."','".$register_date."','".$sale_channel."')";
$qsave=mysqli_query($conn,$save);

}


}else if($fetch2["company"]=="NBM"){
$select_type_doc ='2';		


$sql1 = "SELECT doc_no FROM tb_solnbm where sale_channel = '".$sale_channel."' and date_sol = '".$register_date."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($qry1);
$rs1 = mysqli_fetch_assoc($qry1);	

	
if($Num_Rows > 0){
$doc_no = $rs1["doc_no"];	
}else{
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(doc_no) AS MAXID FROM tb_solnbm";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -3);
$maxId3 = substr($rs['MAXID'],-7);

$maxId1 = substr($maxId3,0,-3);
$so = "SOL/";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "001"; 
$nextId = $yearMonth.$maxId1;

}

$doc_no = $so.$nextId;
$save="insert into tb_solnbm (doc_no,date_sol,sale_channel ) values ('".$doc_no."','".$register_date."','".$sale_channel."')";
$qsave=mysqli_query($conn,$save);


}
}



$save19="UPDATE so__main SET doc_no ='".$doc_no."',select_type_doc='".$select_type_doc."' where ref_id='".$ref_id."'";
$qsave19=mysqli_query($conn,$save19);	
		
if($big_ckk=='1'){
	
$save17="UPDATE so__main SET stock_remark ='pickup' where ref_id='".$ref_id."'";
$qsave17=mysqli_query($conn,$save17);	
	
}	
		

$price = $product_price/$unit1;	


if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date,sku_code)
values ('".$ref_id."','".$unit1."','".$unit1."','".$price."','".$price."','".$sum_amount."','0.00','".$id_product1."','".$id_product1."','".$waranty1."','".$add_date."','".$sku."')";
$objQuery1 = mysqli_query($conn,$strSQL1);

}


if($id_product2 !=''){

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','0.00','".$id_product2."','".$id_product2."','".$waranty2."','".$add_date."')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	

}


if($id_product3 !=''){

$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','0.00','".$id_product3."','".$id_product3."','".$waranty3."','".$add_date."')";
$objQuery3 = mysqli_query($conn,$strSQL3);
	
}
	
if($id_product4 !=''){

$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','0.00','".$id_product4."','".$id_product4."','".$waranty4."','".$add_date."')";
$objQuery4 = mysqli_query($conn,$strSQL4);
	
}
	
if($id_product5 !=''){

$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','0.00','".$id_product5."','".$id_product5."','".$waranty5."','".$add_date."')";
$objQuery5 = mysqli_query($conn,$strSQL5);
}	
		
		
		
if($discounted_price !='0'){	
	
$sum_amount1 = -$discounted_price;		
	
$strSQL11 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,add_date,sale_remark,code_dis,doc_date)
values ('".$ref_id."','1','1','0.00','0.00','".$sum_amount1."','".$discounted_price."','3196','3196','".$add_date."','ส่วนลดพิเศษ','','".$register_date."')";
//echo $strSQL11;
$objQuery11 = mysqli_query($conn,$strSQL11);	
	
}
				

	
if($id_product6 !=''){

$strSQL6 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','0.00','".$id_product6."','".$id_product6."','".$waranty6."','".$add_date."')";
$objQuery6 = mysqli_query($conn,$strSQL6);
}	
		
if($id_product7 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','0.00','".$id_product7."','".$id_product7."','".$waranty7."','".$add_date."')";
$objQuery7 = mysqli_query($conn,$strSQL7);
}	

if($id_product8 !=''){

$strSQL8 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','0.00','".$id_product8."','".$id_product8."','".$waranty8."','".$add_date."')";
$objQuery8 = mysqli_query($conn,$strSQL8);
}		
	
if($id_product9 !=''){

$strSQL9 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','0.00','".$id_product9."','".$id_product9."','".$waranty9."','".$add_date."')";
$objQuery9 = mysqli_query($conn,$strSQL9);
}		

if($id_product10 !=''){

$strSQL10 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,add_date)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','0.00','".$id_product10."','".$id_product10."','".$waranty10."','".$add_date."')";
$objQuery10 = mysqli_query($conn,$strSQL10);
}
		
		
$sku_list = [
    "SUP-KOW-CFKNEM",
    "SUP-KOW-CFKNEL",
    "SUP-KOW-KNES",
    "SUP-KOW-KNEM",
    "SUP-KOW-KNEL",
    "SUP-KOW-KNEXL",
    "SUP-KOW-ANKS",
    "SUP-KOW-ANKM",
    "SUP-KOW-ANKL",
    "SUP-KOW-WRIS",
    "SUP-KOW-WRIM",
    "SUP-KOW-WRIL",
    "SUP-KOW-ELBS",
    "SUP-KOW-ELBM",
    "SUP-KOW-ELBL",
    "SUP-KOW-BACM",
    "SUP-KOW-BACL",
    "SUP-KOW-BACXL"
];

if (in_array($sku, $sku_list)) {

    // ตรวจสอบก่อนว่า ref_id นี้เคยแถม product_id 6270 แล้วหรือยัง
    $checkSQL = "
        SELECT id 
        FROM so__submain 
        WHERE ref_idd = '".$ref_id."'
        AND product_id = '6270'
        LIMIT 1
    ";
    $checkQuery = mysqli_query($conn, $checkSQL);

    if (mysqli_num_rows($checkQuery) == 0) {

        $strSQLfe = "
            INSERT INTO so__submain
            (
                ref_idd,
                sale_count,
                sale_countref,
                price_per_unit,
                price_per_unitref,
                sum_amount,
                discount_unit,
                product_id,
                product_code,
                warranty,
                add_date,
                sale_remark
            )
            VALUES
            (
                '".$ref_id."',
                '1',
                '1',
                '0.00',
                '0.00',
                '0.00',
                '0.00',
                '6270',
                '6270',
                '',
                '".$add_date."',
                'แถมกับพยุงทุกขนาดค่ะ ออเดอร์ละ 1 ซอง (คละแบบ/จนกว่าสินค้าจะหมดค่ะ)'
            )
        ";

        mysqli_query($conn, $strSQLfe);
    }
}
	
$sku_list1 = [
    "BPM-BSX-593",
    "BPM-BSX-593CUF40",
    "BSX593+GCA10"
];

if (in_array($sku, $sku_list1)) {

    // ตรวจสอบก่อนว่า ref_id นี้เคยแถม product_id 6326 แล้วหรือยัง
    $checkSQL1 = "
        SELECT id 
        FROM so__submain 
        WHERE ref_idd = '".$ref_id."'
        AND product_id = '6326'
        LIMIT 1
    ";
    $checkQuery1 = mysqli_query($conn, $checkSQL1);

    if (mysqli_num_rows($checkQuery1) == 0) {

        $strSQLfe = "
            INSERT INTO so__submain
            (
                ref_idd,
                sale_count,
                sale_countref,
                price_per_unit,
                price_per_unitref,
                sum_amount,
                discount_unit,
                product_id,
                product_code,
                warranty,
                add_date,
                sale_remark
            )
            VALUES
            (
                '".$ref_id."',
                '1',
                '1',
                '0.00',
                '0.00',
                '0.00',
                '0.00',
                '6326',
                '6326',
                '',
                '".$add_date."',
                'เครื่องวัดความดันรุ่น BSX593 (ทุกขนาด+เซตจับคู่) แถม สมุดบันทึกความดัน 1 ออเดอร์ ต่อ 1 เล่ม'
            )
        ";

        mysqli_query($conn, $strSQLfe);
    }
}	
		
    }
	
	
$companies = array_values(array_unique(array_filter($companies)));

if (count($companies) >= 2) {

$strSQL = "Update  so__main set doc_release_date='0000-00-00' Where ref_id = '".$ref_id."'";
$objQuery = mysqli_query($conn,$strSQL);		
	
} else {
    
}	
	
	

    //echo "✅ บันทึกออเดอร์ $order_sn สำเร็จ<br>";
}


?>



