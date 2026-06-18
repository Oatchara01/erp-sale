<script type="text/javascript" src="//laz-g-cdn.alicdn.com/sj/securesdk/0.0.3/securesdk_lzd_v1.js" id="J_secure_sdk_v2" data-appkey="124441"></script>
<?php
include "configDB.php";


function saveShopToken($obj)
{
    $result = false;
    $conn = OpenCon();
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO shopToken (
        access_token,
        refresh_token,
        country,
        refresh_expires_in,
        account_platform,
        expires_in,
        account
    )
    VALUES (
        '" . base64_encode($obj->access_token) . "',
        '" . base64_encode($obj->refresh_token) . "',
        '" . $obj->country . "',
        $obj->refresh_expires_in,
        '" . $obj->account_platform . "'
        ,$obj->expires_in,
        '" . $obj->account . "'
    )
    ON DUPLICATE KEY UPDATE
        access_token = VALUES(access_token),
        refresh_token = VALUES(refresh_token),
        refresh_expires_in = VALUES(refresh_expires_in),
        expires_in = VALUES(expires_in)";

	
    if ($conn->query($sql) === TRUE) {
        $result = true;
    } else {
        echo $conn->error;
    }

    CloseCon($conn);
    return $result;
}

function updateShopToken($obj, $running)
{
    $result = false;
    $conn = OpenCon();
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE shopToken
        SET
            access_token = '" . base64_encode($obj->access_token) . "',
            refresh_token = '" . base64_encode($obj->refresh_token) . "'
        WHERE
            running = " . $running;

    if ($conn->query($sql) === TRUE) {
        $result = true;
    } else {
        echo $conn->error;
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
    $sql = "SELECT refresh_token  FROM shopToken WHERE running = " . $running;
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        $refresh_token = $row["refresh_token"];
        $result->close();
    }

    CloseCon($conn);
    return $refresh_token;
}

function saveOrdersauto($obj, $shop_running)
{
    $result = false;
    $conn = OpenCon();
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    date_default_timezone_set("Asia/Bangkok");

    if (!isset($obj->data->orders) || count($obj->data->orders) === 0) {
        return; // ออกจากฟังก์ชันถ้าไม่มีคำสั่งซื้อ
    }

    session_start();
    $name = isset($_SESSION['name']) ? $_SESSION['name'] : "System";
    $surname = isset($_SESSION['surname']) ? $_SESSION['surname'] : "Auto";
    $add_by = "$name $surname";

    $create_date = date('Y-m-d');
    $add_date = date('Y-m-d H:i:s');
    $sale_channel = $shop_running;



    foreach ($obj->data->orders as $order) {
        $customer_name = $order->address_shipping->first_name ?? "Unknown";
        $order_id = $order->order_id ?? "Unknown";

        // ตรวจสอบว่ามี order_id นี้ในฐานข้อมูลแล้วหรือยัง
        $sql2 = "SELECT order_id FROM so__getlzd WHERE order_id = ?";
        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_bind_param($stmt2, "s", $order_id);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_store_result($stmt2);
        $Num_Rows2 = mysqli_stmt_num_rows($stmt2);
        mysqli_stmt_close($stmt2);

        if ($Num_Rows2 == 0) {
			
			    // ดึง max ref_id
    $yearMonth = substr(date("Y") + 543, -2) . date("m");
    $sql = "SELECT MAX(ref_id) AS MAXID FROM so__getlzd";
    $qry = mysqli_query($conn, $sql);
    if (!$qry) {
        die("Error: " . mysqli_error($conn));
    }
    $rs = mysqli_fetch_assoc($qry);
    
    $maxId3 = substr($rs['MAXID'], -8);
    $maxId1 = substr($maxId3, 0, -4);
    $maxId = substr($rs['MAXID'], -4);
    
    if ($maxId1 == $yearMonth) {
        $maxId1 = ($maxId + 1);
        $maxId2 = substr("00000" . $maxId1, -4);
        $nextId = $yearMonth . $maxId2;
    } else {
        $nextId = $yearMonth . "0001";
    }
    
    $so = "GO";
    $ref_id = "$so$nextId";
			
			
            // ใช้ prepared statement เพื่อความปลอดภัย
            $sql_insert = "INSERT INTO so__getlzd (ref_id, create_date, customer_name, sale_channel, order_id, add_date, add_by) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($conn, $sql_insert);
            mysqli_stmt_bind_param($stmt_insert, "sssssss", $ref_id, $create_date, $customer_name, $sale_channel, $order_id, $add_date, $add_by);
            
            if (!mysqli_stmt_execute($stmt_insert)) {
                die("Insert Error: " . mysqli_error($conn));
            }
            mysqli_stmt_close($stmt_insert);
        }
    }

    mysqli_close($conn);
}




	
function saveOrderItemsauto($obj, $order_id, $shop_running)
{
    $result = false;
    $conn = OpenCon();
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


$x = 0;
$companies = [];
	
    while ($x < count($obj->data)) {

        if ($x > 0) {
            $values = $values . ",";
        }

        $item_no = $x + 1;
		

$sku = $obj->data[$x]->sku;	

$sql4 = "SELECT ref_id FROM so__getlzd where order_id='".$order_id."'";
$query4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$fetch4 = mysqli_fetch_array($query4);	

$ref_id = $fetch4["ref_id"];

$sql2 = "SELECT * FROM tb_product_lzd where code_lazada='".$sku."'";
$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($query2);
$fetch2 = mysqli_fetch_array($query2);
		
$company = strtoupper(trim($fetch2["company"] ?? ''));
        if ($company !== '') {
            $companies[] = $company;
        }	
		

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
	
	

$unit1 = $fetch2["unit1"];
$unit2 = $fetch2["unit2"];
$unit3 = $fetch2["unit3"];
$unit4 = $fetch2["unit4"];
$unit5 = $fetch2["unit5"];
$unit6 = $fetch2["unit6"];
$unit7 = $fetch2["unit7"];
$unit8 = $fetch2["unit8"];
$unit7 = $fetch2["unit7"];
$unit8 = $fetch2["unit8"];
$unit9 = $fetch2["unit9"];
$unit10 = $fetch2["unit10"];

	
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

$paid_price1 = $obj->data[$x]->item_price;
$paid_price = $paid_price1;	
$price_per_unit = ($paid_price/$unit1);

//$price_lazada = $fetch2["price_lazada"]-($fetch2["price_lazada"]*($fetch2["percen_price"]/100));
$price_lazada = $fetch2["percen_price"]; 


if($id_product1 !=''){

$strSQL1 = "insert into so__subgetlzd
(ref_idd,count,price,sum_amount,product_id,product_code,sku_code)
values ('".$ref_id."','".$unit1."','".$price_per_unit."','".$paid_price."','".$id_product1."','".$id_product1."','".$sku."')";
$objQuery1 = mysqli_query($conn,$strSQL1);

}

if($id_product2 !=''){

$strSQL2 = "insert into so__subgetlzd
(ref_idd,count,price,sum_amount,product_id,product_code) values ('".$ref_id."','".$unit2.",'0.00','0.00','".$id_product2."','".$id_product2."')";
$objQuery2 = mysqli_query($conn,$strSQL2);

}


if($id_product3 !=''){

$strSQL3 = "insert into so__subgetlzd
(ref_idd,count,price,sum_amount,product_id,product_code) values ('".$ref_id."','".$unit3.",'0.00','0.00','".$id_product3."','".$id_product3."')";
$objQuery3 = mysqli_query($conn,$strSQL3);

}

if($id_product4 !=''){

$strSQL4 = "insert into so__subgetlzd
(ref_idd,count,price,sum_amount,product_id,product_code) values ('".$ref_id."','".$unit4.",'0.00','0.00','".$id_product4."','".$id_product4."')";

	$objQuery4 = mysqli_query($conn,$strSQL4);
	
}
	
if($id_product5 !=''){

$strSQL5 = "insert into so__subgetlzd
(ref_idd,count,price,sum_amount,product_id,product_code) values ('".$ref_id."','".$unit5.",'0.00','0.00','".$id_product5."','".$id_product5."')";
	
	$objQuery5 = mysqli_query($conn,$strSQL5);
}	

	
if($id_product6 !=''){

$strSQL6 ="insert into so__subgetlzd
(ref_idd,count,price,sum_amount,product_id,product_code) values ('".$ref_id."','".$unit6.",'0.00','0.00','".$id_product6."','".$id_product6."')";
	$objQuery6 = mysqli_query($conn,$strSQL6);
}	
		
if($id_product7 !=''){

$strSQL7 = "insert into so__subgetlzd
(ref_idd,count,price,sum_amount,product_id,product_code) values ('".$ref_id."','".$unit7.",'0.00','0.00','".$id_product7."','".$id_product7."')";
	$objQuery7 = mysqli_query($conn,$strSQL7);
}	

if($id_product8 !=''){

$strSQL8 ="insert into so__subgetlzd
(ref_idd,count,price,sum_amount,product_id,product_code) values ('".$ref_id."','".$unit8.",'0.00','0.00','".$id_product8."','".$id_product8."')";
	$objQuery8 = mysqli_query($conn,$strSQL8);
}		
	
if($id_product9 !=''){

$strSQL9 = "insert into so__subgetlzd
(ref_idd,count,price,sum_amount,product_id,product_code) values ('".$ref_id."','".$unit9.",'0.00','0.00','".$id_product9."','".$id_product9."')";
	$objQuery9 = mysqli_query($conn,$strSQL9);
}		

if($id_product10 !=''){

$strSQL10 ="insert into so__subgetlzd (ref_idd,count,price,sum_amount,product_id,product_code) values ('".$ref_id."','".$unit10.",'0.00','0.00','".$id_product10."','".$id_product10."')";
	$objQuery10 = mysqli_query($conn,$strSQL10);
}
		
		
		
		
		
	
		
$x += 1;
	}
	
	
	

  $companies = array_values(array_unique($companies));
if (count($companies) > 2) {
        $strSQL = "UPDATE so__main
                   SET doc_release_date='0000-00-00'
                   WHERE ref_id='" . mysqli_real_escape_string($conn,$ref_id) . "'";

        mysqli_query($conn, $strSQL) or die(mysqli_error($conn));
    }
	
		}
			
	


function saveOrders($obj, $shop_running)
{
    $result = false;
    $conn = OpenCon();
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
date_default_timezone_set("Asia/Bangkok");
    $sql = "INSERT INTO shopOrders (
        order_number,
        shop_running,
        order_id,
        voucher_platform,
        voucher,
        warehouse_code,
        voucher_seller,
        created_at,
        voucher_code,
        gift_option,
        shipping_fee_discount_platform,
        customer_last_name,
        updated_at,
        promised_shipping_times,
        price,
        national_registration_number,
        shipping_fee_original,
        payment_method,
        customer_first_name,
        shipping_fee_discount_seller,
        shipping_fee,
        items_count,
        delivery_info,
        statuses,
        TaxInvoiceRequested,
        gift_message,
        remarks,
        address_billing_first_name,
        address_billing_last_name,
        address_billing_phone,
        address_billing_phone2,
        address_billing_address1,
        address_billing_address2,
        address_billing_address3,
        address_billing_address4,
        address_billing_address5,
        address_billing_city,
        address_billing_country,
        address_billing_post_code,
        address_shipping_first_name,
        address_shipping_last_name,
        address_shipping_phone,
        address_shipping_phone2,
        address_shipping_address1,
        address_shipping_address2,
        address_shipping_address3,
        address_shipping_address4,
        address_shipping_address5,
        address_shipping_city,
        address_shipping_country,
        address_shipping_post_code,
		register_date 
    )";

    $values = " VALUES ";

    //for delete before insert
    $idList = array();

    //prepare multi rows insert
    $x = 0;
    while ($x < $obj->data->count) {
        //echo "The order_id is: " . $obj->data->orders[$x]->order_id . "<br>";

        //push id for delete before insert
        array_push($idList, $obj->data->orders[$x]->order_id);

        // for read boolean value from json
        $gift_option = "false";
        if ($obj->data->orders[$x]->gift_option === TRUE) {
            $gift_option = "true";
        } else {
            $gift_option = "false";
        }
        // echo $x . "<br>";
        // echo "gift_option is " . $gift_option . "<br>";

        // add , seperate insert rows (row0),(row1),(row2)
        if ($x > 0) {
            $values = $values . ",";
        }
		
$register_date = date('Y-m-d');
$doc_release_date= date('Y-m-d');
$register_time = date('H:i:s');
$delivery_date = date('Y-m-d');	
$sale_channel = $shop_running;
		
if($shop_running=='1'){		
$delivery = '30';
}else if($shop_running=='20'){
$delivery = '31';	
}

$employee_name ="SOL91";
$job_id = "LZD";
$prefer_name = "LAZADA";

$approve_complete = "Approve";
$add_date = date('Y-m-d H:i:s');
   
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";	
			
$customer_name = $obj->data->orders[$x]->address_shipping->first_name;
$delivery_name = $obj->data->orders[$x]->address_shipping->first_name;
$order_name = $obj->data->orders[$x]->address_shipping->first_name;
$str_arr = explode('/',$obj->data->orders[$x]->address_shipping->address3);
 
$str_arr[0];
$str_arr[1];

$str_arr1 = explode('/',$obj->data->orders[$x]->address_shipping->address4);

$str_arr1[0];
$str_arr1[1];
		
$tel =	$obj->data->orders[$x]->address_shipping->phone;	
$tel1 = substr($tel, -9); 
$delivery_contact = "$customer_name / $tel";
$add14 = $obj->data->orders[$x]->address_shipping->address1;		
$add15 = $obj->data->orders[$x]->address_shipping->address2;
		
$address1 = "$add14 $add15";
$address2 = $str_arr1[0];
$postcode =	$obj->data->orders[$x]->address_shipping->post_code;
$delivery_place = "$add14 $add15 $str_arr[0]  $postcode";
$str_arr2 = explode('/',$obj->data->orders[$x]->address_billing->address4);
 
$str_arr2[0];
$str_arr2[1];

$str_arr3 = explode('/',$obj->data->orders[$x]->address_billing->address3);

$str_arr3[0];
$str_arr3[1];	

$add26	= $obj->data->orders[$x]->address_billing->address1;
$add27	=$obj->data->orders[$x]->address_billing->address2;
$billing_postcode =	$obj->data->orders[$x]->address_billing->address5;	

$billing_add= "$add26 $add27";		
$billing_address = "$add26 $add27 $str_arr2[0] $str_arr3[0]  $billing_postcode";
$branch_number = $obj->data->orders[$x]->branch_number;			
$billing_name1 =	$obj->data->orders[$x]->address_billing->first_name;
$billing_name = "$billing_name1 $branch_number";		
$billing_tel =	$obj->data->orders[$x]->address_billing->phone;
$create_order = $obj->data->orders[$x]->created_at;



//$order_refer_code = '-';
$order_id = $obj->data->orders[$x]->order_id;	
		
$tax_id1 = $obj->data->orders[$x]->tax_code;		
$tax_id2 = str_replace("-", "", $tax_id1);
$tax_id = str_replace(' ', '', $tax_id2);		
		
		
$bill_vat1 = $obj->data->orders[$x]->extra_attributes;

//$email_cus = $obj->data[$x]->digital_delivery_info;
	
/*if($bill_vat1=='{"TaxInvoiceRequested":false}'){
$TaxInvoiceRequested ='false';	
}else{
$TaxInvoiceRequested ='true';		
}*/
		
$preface_name ="คุณ";
		
		
$sql9 = "SELECT customer_name,customer_id FROM tb_customer where cus_tel LIKE '%".$tel1."%'";
$query9 = mysqli_query($conn,$sql9) or die(mysqli_error());
$Num_Rows9 = mysqli_num_rows($query9);
$fetch9 = mysqli_fetch_array($query9);
		
if($Num_Rows9 > 0){
		
}else {	
	
$qfirst = "select * from tb_customer ORDER BY customer_id DESC LIMIT 1";
$first = mysqli_query($conn,$qfirst);
$Num_Rows88 = mysqli_num_rows($first);
$ffirst = mysqli_fetch_array($first);
	
$customer_id = $ffirst['customer_id']+1;	
	
	
$save9="insert into tb_customer
(customer_name,type_customer,cus_address,cus_ampher,cus_province,cus_postcode,cus_tel,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,bill_tel,tax_id,delivery_name,del_address,del_ampher,del_province,del_postcode,del_tel,contact_name,sale_code,cus_online,preface_name)
values
('".$customer_name."','7','".$address1."','".$address2."','".$str_arr[0]."','".$postcode."','".$tel."','".$billing_name."','".$billing_add."','".$str_arr2[0]."','".$str_arr3[0]."','".$billing_postcode."','".$billing_tel."','".$tax_id."','".$delivery_name."','".$delivery_place."','".$address2."','".$str_arr[0]."','".$postcode."','".$tel."','".$delivery_contact."','".$employee_name."','".$objArr[10]."','".$preface_name."')";
echo $save9;	
$qsave9=mysqli_query($conn,$save9);
	
$sql = "INSERT INTO tb_selected_sales (sale_code, id_customer, customer_name) VALUES ('$employee_name', '$customer_id', '$billing_name')";
$qsave2 = mysqli_query($conn, $sql);	
	
}
		
$sql10 = "SELECT customer_id FROM tb_customer where cus_tel LIKE '%".$tel1."%'";
$query10 = mysqli_query($conn,$sql10) or die(mysqli_error());
$fetch10 = mysqli_fetch_array($query10);
$bill_id = $fetch10["customer_id"];
		
		
if(is_numeric($tax_id)){
if(strlen($tax_id)=='13'){	
$bill_vat = '1';
$send_supadm = '1';
$status_vat  = "Approve";	
$payment = '36';	
$account_approve ='1';		
}else{
$bill_vat = '0';
$send_supadm = '0';
$status_vat  = "";	
$payment = '35';	
$account_approve ='0';		
}
}else{
$bill_vat = '0';
$send_supadm = '0';
$status_vat  = "";
$payment = '35';	
$account_approve ='0';		
}
	




		
	
		
$sql1 = "SELECT MAX(main_id) AS main_id FROM so__main";
$query1 = mysqli_query($conn,$sql1) or die(mysqli_error());
while($fetch1 = mysqli_fetch_array($query1)){
 $ref_id = $fetch1['main_id']+1;
	
$sql2 = "SELECT order_id FROM so__main where order_id = '".$order_id."'";
$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($query2);
	
$fetch2 = mysqli_fetch_array($query2);
		
if($Num_Rows2 > 0){ 
}else{	
	
	

$strSQL = "INSERT INTO so__main (ref_id,register_date,register_time,delivery_name,address1,province,postcode,billing_address,billing_name,billing_tel,tel,order_id,customer_name,order_name,delivery_contact,delivery_place,add_date,add_by,sale_channel,select_type_doc,doc_release_date,status_doc,delivery,payment,employee_name,job_id,address2,delivery_date,approve_complete,send_stock,bill_vat,tax_id,send_supadm,status_vat,bill_id,doc_no,prefer_name,po_no,ex_add,ex_aumper,ex_provin,ex_post,pre_name,create_order,account_approve) VALUES 
('".$ref_id."','".$register_date."','".$register_time."','".$delivery_name."','".$address1."','".$str_arr[0]."','".$postcode."','".$billing_address."','".$billing_name."','".$billing_tel."','".$tel."','".$order_id."','".$customer_name."','".$order_name."','".$delivery_contact."','".$delivery_place."','".$add_date."','".$add_by."','".$sale_channel."','".$select_type_doc."','".$doc_release_date."','".$select_type_doc."','".$delivery."','".$payment."','".$employee_name."','".$job_id."','".$address2."','".$delivery_date."','".$approve_complete."','1','".$bill_vat."','".$tax_id."','".$send_supadm."','".$status_vat."','".$bill_id."','".$doc_no."','".$prefer_name."','".$order_id."','".$billing_add."','".$str_arr2[0]."','".$str_arr3[0]."','".$billing_postcode."','".$pre_name."','".$create_order."','".$account_approve."'
)";
echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL)or die(mysqli_error());
	
	
/*$strSQL8 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark)
values ('".$ref_id."','1','1','0.00','0.00','0.00','0.00','2719','2719','แถมพิเศษโปรโมชั่น 2.2')";
$objQuery8 = mysqli_query($conn,$strSQL8);*/	
	
	
}
}
		
		
$register_date = date('Y-m-d');
        $values = $values . "(
            '" . $obj->data->orders[$x]->order_number . "',
            " . $shop_running . ",
            '" . $obj->data->orders[$x]->order_id . "',
            '" . $obj->data->orders[$x]->voucher_platform . "',
            '" . $obj->data->orders[$x]->voucher . "',
            '" . $obj->data->orders[$x]->warehouse_code . "',
            '" . $obj->data->orders[$x]->voucher_seller . "',
            '" . $obj->data->orders[$x]->created_at . "',
            '" . $obj->data->orders[$x]->voucher_code . "',
            '" . $gift_option . "',
            '" . $obj->data->orders[$x]->shipping_fee_discount_platform . "',
            '" . $obj->data->orders[$x]->customer_last_name . "',
            '" . $obj->data->orders[$x]->updated_at . "',
            '" . $obj->data->orders[$x]->promised_shipping_times . "',
            '" . $obj->data->orders[$x]->price . "',
            '" . $obj->data->orders[$x]->national_registration_number . "',
            '" . $obj->data->orders[$x]->shipping_fee_original . "',
            '" . $obj->data->orders[$x]->payment_method . "',
            '" . $obj->data->orders[$x]->customer_first_name . "',
            '" . $obj->data->orders[$x]->shipping_fee_discount_seller . "',
            '" . $obj->data->orders[$x]->shipping_fee . "',
            " . $obj->data->orders[$x]->items_count . ",
            '" . $obj->data->orders[$x]->delivery_info . "',
            '" . $obj->data->orders[$x]->statuses[0] . "',
            '" . $TaxInvoiceRequested . "',
            '" . $obj->data->orders[$x]->gift_message . "',
            '" . $obj->data->orders[$x]->remarks . "',
            '" . $obj->data->orders[$x]->address_billing->first_name . "',
            '" . $obj->data->orders[$x]->address_billing->last_name . "',
            '" . $obj->data->orders[$x]->address_billing->phone . "',
            '" . $obj->data->orders[$x]->address_billing->phone2 . "',
            '" . $obj->data->orders[$x]->address_billing->address1 . "',
            '" . $obj->data->orders[$x]->address_billing->address2 . "',
            '" . $obj->data->orders[$x]->address_billing->address3 . "',
            '" . $obj->data->orders[$x]->address_billing->address4 . "',
            '" . $obj->data->orders[$x]->address_billing->address5 . "',
            '" . $obj->data->orders[$x]->address_billing->city . "',
            '" . $obj->data->orders[$x]->address_billing->country . "',
            '" . $obj->data->orders[$x]->address_billing->post_code . "',
            '" . $obj->data->orders[$x]->address_shipping->first_name . "',
            '" . $obj->data->orders[$x]->address_shipping->last_name . "',
            '" . $obj->data->orders[$x]->address_shipping->phone . "',
            '" . $obj->data->orders[$x]->address_shipping->phone2 . "',
            '" . $obj->data->orders[$x]->address_shipping->address1 . "',
            '" . $obj->data->orders[$x]->address_shipping->address2 . "',
            '" . $obj->data->orders[$x]->address_shipping->address3 . "',
            '" . $obj->data->orders[$x]->address_shipping->address4 . "',
            '" . $obj->data->orders[$x]->address_shipping->address5 . "',
            '" . $obj->data->orders[$x]->address_shipping->city . "',
            '" . $obj->data->orders[$x]->address_shipping->country . "',
            '" . $obj->data->orders[$x]->address_shipping->post_code . "',
			'".$register_date."'
            )";

        $x += 1;
    }

    $sql = $sql . $values;
   

    //delete before insert
    $idListString = implode(",", $idList);
    $sqlDelete = "DELETE FROM shopOrders WHERE order_id IN ($idListString)";
    if ($conn->query($sqlDelete) === TRUE) {

        //insert orders to database
        if ($conn->query($sql) === TRUE) {
            $result = true;
        } else {
            echo $conn->error;
        }
        CloseCon($conn);
        return $result;
    } else {
        echo $conn->error;
    }
}

function saveOrderItems($obj, $order_id, $shop_running)
{
    $result = false;
    $conn = OpenCon();
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO shopOrderItems (
        order_id,
        shop_running,
        item_no,
        reason,
        digital_delivery_info,
        promised_shipping_time,
        voucher_amount,
        return_status,
        shipping_type,
        shipment_provider,
        variation,
        created_at,
        invoice_number,
        shipping_amount,
        currency,
        order_flag,
        shop_id,
        sla_time_stamp,
        sku,
        voucher_code,
        wallet_credits,
        updated_at,
        is_digital,
        tracking_code_pre,
        order_item_id,
        package_id,
        tracking_code,
        shipping_service_cost,
        extra_attributes,
        paid_price,
        shipping_provider_type,
        product_detail_url,
        shop_sku,
        reason_detail,
        purchase_order_id,
        purchase_order_number,
        name,
        product_main_image,
        item_price,
        tax_amount,
        status,
        cancel_return_initiator,
        voucher_platform,
        voucher_seller,
        order_type,
        stage_pay_status,
        warehouse_code,
        shipping_fee_original,
        shipping_fee_discount_seller,
        shipping_fee_discount_platform,
        voucher_code_seller,
        voucher_code_platform
)";
    $values = " VALUES ";

    //echo "data count " . count($obj->data) . "<br>";

    //prepare multi rows insert
    $x = 0;
	$companies = [];
    while ($x < count($obj->data)) {

        if ($x > 0) {
            $values = $values . ",";
        }

        $item_no = $x + 1;
		

$sku = $obj->data[$x]->sku;	
$paid_price1 = $obj->data[$x]->item_price;
$voucher_seller = $obj->data[$x]->voucher_seller;
$voucher_seller1 = "-$voucher_seller";
$paid_price = $paid_price1;
$voucher_amount = $obj->data[$x]->voucher_amount;
$dis_price = $obj->data[$x]->paid_price;
$voucher_platform= $obj->data[$x]->voucher_platform;
		
$sql4 = "SELECT ref_id,bill_vat,doc_no,tax_id FROM so__main where order_id='".$order_id."'";
$query4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$fetch4 = mysqli_fetch_array($query4);	
		

$main_id = $fetch4["ref_id"];
$register_date = date('Y-m-d');
$bill_vat = $fetch4["bill_vat"];		
$ref_id = $fetch4["ref_id"];
$email = $obj->data[$x]->digital_delivery_info;		
		
		
		
$strSQLs8 = "insert into so__uppack (ref_id,sale_channel,order_id,order_item_id) values ('".$fetch4["ref_id"]."','".$shop_running."','".$order_id."','".$obj->data[$x]->order_item_id."')";
$objQuerys8 = mysqli_query($conn,$strSQLs8);
		
		
if($shop_running=='1'){		
		
$sql2 = "SELECT * FROM tb_product_lzd where code_lazada='".$sku."'";
$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($query2);
$fetch2 = mysqli_fetch_array($query2);

$companies[] = $fetch2["company"] ?? '';	
	
	
if($fetch4["doc_no"]!=''){	}else{

$order_type = $obj->data[$x]->order_type;
	
if($order_type=='PreOrder'){	
	
$saveo19="UPDATE so__main SET pre_ckk='1' where ref_id='".$ref_id."'";
$qsaveo19=mysqli_query($conn,$saveo19);		
	
if($fetch2["company"]=='AWL'){

if($fetch4["tax_id"]!='' and $email!=''){
	
$select_type_doc ='3';	
$bill_vat = '1';
$send_supadm = '1';
$status_vat  = "Approve";	
$doc_no = "";	
	
}else{
	
$select_type_doc ='1';	
$bill_vat = '0';
$send_supadm = '0';
$status_vat  = "";	
$doc_no = "";	
	
}
	
	
	
}else if($fetch2["company"]=='NBM'){
	
if($fetch4["tax_id"]!='' and $email!=''){
	
$select_type_doc ='4';	
$bill_vat = '1';
$send_supadm = '1';
$status_vat  = "Approve";	
$doc_no = "";	
	
}else{
	
$select_type_doc ='2';	
$bill_vat = '0';
$send_supadm = '0';
$status_vat  = "";	
$doc_no = "";	
	
}
	
	
}
}else if($fetch2["company"]=='AWL'){

if($bill_vat=='1'){
	
if($fetch4["tax_id"]!='0000000000000' and $fetch4["tax_id"]!='' and $email!=''){
	
$select_type_doc ='3';		
$date = explode('-' , $register_date);
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);
$bill_vat = '1';
$send_supadm = '1';
$status_vat  = "Approve";		

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_et_awl where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ET";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$doc_no = $so.$year1.$mont.$nextId;

$save9="insert into tb_et_awl (doc_no,year_no,mount_no,run_no,iv_date,ref_so) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$register_date."','".$ref_id."')";
$qsave9=mysqli_query($conn,$save9);
	
	
}else{
	
$select_type_doc ='1';		
$bill_vat = '0';
$send_supadm = '0';
$status_vat  = "";		
	
$sql1 = "SELECT doc_no FROM tb_solptl where sale_channel = '".$shop_running."' and date_sol = '".$register_date."'";
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
	

$save="insert into tb_solptl (doc_no,date_sol,sale_channel ) values ('".$doc_no."','".$register_date."','".$shop_running."')";
$qsave=mysqli_query($conn,$save);

}		
	
	
	
}
		
	}else{
	
$select_type_doc ='1';	
$bill_vat = '0';
$send_supadm = '0';
$status_vat  = "";	
	
$sql1 = "SELECT doc_no FROM tb_solptl where sale_channel = '".$shop_running."' and date_sol = '".$register_date."'";
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
	

$save="insert into tb_solptl (doc_no,date_sol,sale_channel ) values ('".$doc_no."','".$register_date."','".$shop_running."')";
$qsave=mysqli_query($conn,$save);

}	
	}	

	
}else if($fetch2["company"]=='NBM'){



if($bill_vat=='1'){
	
if($fetch4["tax_id"]!='0000000000000' and $fetch4["tax_id"]!='' and $email!=''){	
	
$select_type_doc ='4';	
$bill_vat = '1';
$send_supadm = '1';
$status_vat  = "Approve";	
		
$date = explode('-' , $register_date);
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
$doc_no = $so.$year1.$so1.$mont.$nextId;

$save9="insert into tb_et_nbm (doc_no,year_no,mount_no,run_no,ref_so,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id."','".$register_date."')";
$qsave9=mysqli_query($conn,$save9);
	
	
}else{
	
$select_type_doc ='2';	
$bill_vat = '0';
$send_supadm = '0';
$status_vat  = "";	
	
$sql1 = "SELECT doc_no FROM tb_solnbm where sale_channel = '".$shop_running."' and date_sol = '".$register_date."'";
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
	

$save="insert into tb_solnbm (doc_no,date_sol,sale_channel) values ('".$doc_no."','".$register_date."','".$shop_running."')";
$qsave=mysqli_query($conn,$save);

}	
	
}
		
	}else{
$select_type_doc ='2';
$bill_vat = '0';
$send_supadm = '0';
$status_vat  = "";	
	
$sql1 = "SELECT doc_no FROM tb_solnbm where sale_channel = '".$shop_running."' and date_sol = '".$register_date."'";
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
	

$save="insert into tb_solnbm (doc_no,date_sol,sale_channel) values ('".$doc_no."','".$register_date."','".$shop_running."')";
$qsave=mysqli_query($conn,$save);

}	
	}	
	
}		

$date = explode(',' , $obj->data[$x]->shipment_provider );	
$cs_remark = $date[0];	

$save19="UPDATE so__main SET select_type_doc ='".$select_type_doc."',doc_no = '".$doc_no."',status_vat='".$status_vat."',send_supadm='".$send_supadm."',bill_vat='".$bill_vat."',cs_remark='" . $cs_remark . "',order_refer_code='" . $obj->data[$x]->tracking_code . "',email='".$obj->data[$x]->digital_delivery_info."',order_item_id='".$obj->data[$x]->order_item_id."'  where ref_id='".$ref_id."'";
$qsave19=mysqli_query($conn,$save19);	
}
	

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
	
	

$unit1 = $fetch2["unit1"];
$unit2 = $fetch2["unit2"];
$unit3 = $fetch2["unit3"];
$unit4 = $fetch2["unit4"];
$unit5 = $fetch2["unit5"];
$unit6 = $fetch2["unit6"];
$unit7 = $fetch2["unit7"];
$unit8 = $fetch2["unit8"];
$unit7 = $fetch2["unit7"];
$unit8 = $fetch2["unit8"];
$unit9 = $fetch2["unit9"];
$unit10 = $fetch2["unit10"];

	
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
	
$price_per_unit = ($paid_price/$unit1);

//$price_lazada = $fetch2["price_lazada"]-($fetch2["price_lazada"]*($fetch2["percen_price"]/100));
$price_lazada = $fetch2["percen_price"]; 	


if($id_product1 !=''){

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sku_code)
values ('".$main_id."','".$unit1."','".$unit1."','".$price_per_unit."','".$paid_price."','".$paid_price."','0.00','".$id_product1."','".$id_product1."','".$waranty1."','Approve','".$sku."')";
$objQuery1 = mysqli_query($conn,$strSQL1);
	
$strSQL11 = "insert into so__disecom(ref_so,price_dis,order_num,sale_chan,date_today,product_id) values ('".$main_id."','".$dis_price."','".$order_id."','".$shop_running."','".$register_date."','".$id_product1."')";
$objQuery11 = mysqli_query($conn,$strSQL11);
	
	
	
//'" . $obj->data[$x]->tracking_code . "'	
	
/*$strSQL11 = "Update so__main order_refer_code = '".$obj->data[$x]->tracking_code."' where ref_id = '".$main_id."'";
$objQuery11 = mysqli_query($conn,$strSQL11);*/
	

}


if($paid_price < $price_lazada){
	
	
$strSQL15 = "SELECT ref_id,doc_no,select_type_doc FROM  so__main  where ref_id='".$main_id."'";
$objQuery15 = mysqli_query($stock_out,$strSQL15);
$objResult15 = mysqli_fetch_array($objQuery15);	
	

$save19="UPDATE so__main SET price_ckk ='1',approve_complete='Request' where ref_id='".$main_id."'";
$qsave19=mysqli_query($conn,$save19);	
	
if($objResult15["select_type_doc"]=='3'){

$strSQL = "DELETE FROM tb_et_awl WHERE doc_no = '".$objResult15["doc_no"]."'";
$objQuery = mysqli_query($conn,$strSQL);
	
$save19="UPDATE so__main SET price_ckk ='1',doc_no ='' where ref_id='".$main_id."'";
$qsave19=mysqli_query($conn,$save19);	

}

if($objResult15["select_type_doc"]=='4'){
	
$strSQL = "DELETE FROM tb_et_nbm WHERE doc_no = '".$objResult15["doc_no"]."'";
$objQuery = mysqli_query($conn,$strSQL);	

$save19="UPDATE so__main SET price_ckk ='1',doc_no ='' where ref_id='".$main_id."'";
$qsave19=mysqli_query($conn,$save19);	

}	
		
	
	
	

}	
	

if($id_product2 !=''){
//if($sku=='PMLG1PCS'){ }else{}	

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','0.00','".$id_product2."','".$id_product2."','".$waranty2."','Approve')";
$objQuery2 = mysqli_query($conn,$strSQL2);

}


if($id_product3 !=''){

$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','0.00','".$id_product3."','".$id_product3."','".$waranty3."','Approve')";

	$objQuery3 = mysqli_query($conn,$strSQL3);

}

if($id_product4 !=''){

$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','0.00','".$id_product4."','".$id_product4."','".$waranty4."','Approve')";

	$objQuery4 = mysqli_query($conn,$strSQL4);
	
}
	
if($id_product5 !=''){

$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','0.00','".$id_product5."','".$id_product5."','".$waranty5."','Approve')";
	
	$objQuery5 = mysqli_query($conn,$strSQL5);
}	

	
if($id_product6 !=''){

$strSQL6 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','0.00','".$id_product6."','".$id_product6."','".$waranty6."','Approve')";
	$objQuery6 = mysqli_query($conn,$strSQL6);
}	
		
if($id_product7 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','0.00','".$id_product7."','".$id_product7."','".$waranty7."','Approve')";
	$objQuery7 = mysqli_query($conn,$strSQL7);
}	

if($id_product8 !=''){

$strSQL8 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','0.00','".$id_product8."','".$id_product8."','".$waranty8."','Approve')";
	$objQuery8 = mysqli_query($conn,$strSQL8);
}		
	
if($id_product9 !=''){

$strSQL9 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','0.00','".$id_product9."','".$id_product9."','".$waranty9."','Approve')";
	$objQuery9 = mysqli_query($conn,$strSQL9);
}		

if($id_product10 !=''){

$strSQL10 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','0.00','".$id_product10."','".$id_product10."','".$waranty10."','Approve')";
	$objQuery10 = mysqli_query($conn,$strSQL10);
}
	
	
if($sku=='AW100TL' or $sku=='AW50TL'  or $sku=='AW50T' or $sku=='AW25T'){

$save69="UPDATE so__main SET glu_ckk ='1' where ref_id='".$main_id."'";
$qsave69=mysqli_query($conn,$save69);	
	
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
	
	

$sku_list2 = [
    "WCH-KAI-A86312BL",
    "WCH-KAI-A86320BL",
    "WCH-KAI-A869BL",
    "WCH-DON-MOVD1BLA",
    "WKI-OSC-WALKASIL",
    "BBBSWHGK+Superior",
    "BBBWHGK+Superior",
    "GBWHGK+Superior",
    "WCH-DON-MOVD1BLA+Superior",
    "MAT-DHS-MER15CM",
    "MAT-DHS-MER10W88",
    "MAT-DHS-JUPITER",
    "MAT-DHS-COMMU10",
    "DYMR15cm+bedsheet",
    "DYMR15cm+MPAllwell",
    "DYMR10cm+bedsheet",
    "DYMR10cm+MPAllwell",
    "Jupiter+bedsheet",
    "Jupiter+MPAllwell",
    "Community+bedsheet",
    "Community+MPAllwell"
];	
	
if (in_array($sku, $sku_list2)) {

    // ตรวจสอบก่อนว่า ref_id นี้เคยแถม product_id 6314 แล้วหรือยัง
    $checkSQL1 = "
        SELECT id 
        FROM so__submain 
        WHERE ref_idd = '".$ref_id."'
        AND product_id = '6314'
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
                '6314',
                '6314',
                '',
                '".$add_date."',
                'ซื้อวีลแชร์ทุกรุ่น / ที่นอนทุกรุ่น แถมผ้าอ้อมผู้ใหญ่ (คละไซซ์ 1 ชิ้น / 1 ออเดอร์)'
            )
        ";

        mysqli_query($conn, $strSQLfe);
    }
}		
	
	
/*$sql22 = "SELECT ref_idd FROM so__submain where ref_idd='".$main_id."' and sale_remark LIKE '%แถมพิเศษ ปฏิทิน ปี 2025%'";
$query22 = mysqli_query($conn,$sql22) or die(mysqli_error());
$Num_Rows22 = mysqli_num_rows($query22);
$fetch22 = mysqli_fetch_array($query22);
	
if($fetch22["ref_idd"]!=''){	}else{	

$skuss = array(
    "GBWHGK", "GBWHGK+Superior", "BBBWHGK", "BBBSWHGK", "BBBWHGK+Superior", "BBBSWHGK+Superior", "WCH-DON-MOVD1BLA", "WCH-DON-MOVD1BLA+Superior", "WKI-OSC-WALKASIL", "Community", "Community+bedsheet", "Community+MPAllwell", "DYMR15cm", "DYMR15cm+bedsheet", "DYMR15cm+MPAllwell", "DYMR10cm", "DYMR10cm+bedsheet", "DYMR10cm+MPAllwell", "PMLG1PCS", "PMLG3PCS", "PMLG6PCS"
);


if (!empty($sku) && in_array($sku, $skuss)) {

	
$strSQL19 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sale_remark)
values ('".$main_id."','1','1','0.00','0.00','0.00','0.00','5734','5734','','Approve','แถมพิเศษ ปฏิทิน ปี 2025')";
$objQuery19 = mysqli_query($conn,$strSQL19);	
	
} else {

}	
	
}*/		
	
	
	
	
	
	
		
//โปร 1-31 พ.ค.	
/*if($sku=='jupiter' or $sku=='Community' or $sku=='MOEM' or $sku =='Let Shop' or $sku=='GBWHGK' or $sku=='GBWHGK+Dyna-Tek' or $sku=='BBBWHGK' or $sku=='BBBWHGK+Dyna-Tek' or $sku=='BBBSWHGK' or $sku=='BBBSWHGK+Dyna-Tek' or $sku=='WCH-DON-MOVD1BLA' or $sku=='DYMR15cm' or $sku=='DYMR10cm'  or $sku=='DYMR15cm+bedsheet'  or $sku=='DYMR15cm+MPAllwell'  or $sku=='DYMR10cm+bedsheet'  or $sku=='DYMR10cm+MPAllwell'  or $sku=='Community+bedsheet'  or $sku=='Community+MPAllwell'  or $sku=='BBBWHGK+Superior'  or $sku=='BBBSWHGK+Superior'  or $sku=='GBWHGK+Superior'  or $sku=='WCH-DON-MOVD1BLA+Superior' or $sku=='DYMR15cm+MPAllwel'){

$strSQL19 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sale_remark)
values ('".$main_id."','".$unit1."','".$unit1."','0.00','0.00','0.00','0.00','5390','5390','','Approve','แถมผ้าเปียก ALLWELL 1 ห่อ เล็ก')";
$objQuery19 = mysqli_query($conn,$strSQL19);
	
}*/
		
	
/*if($sku=='SCA-ZTE-BODYA1BW'){	
	
$strSQL15 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sale_remark)
values ('".$main_id."','1','1','0.00','0.00','0.00','0.00','5510','5510','','Approve','ซื้อ ALLWELL เครื่องชั่งน้ำหนัก วัดไขมันและดัชนีมวลกาย รุ่น BodyA-1B รับฟรี FITWHEY Astaxanthin 1 กระปุก ต่อ 1 ออเดอร์')";
$objQuery15 = mysqli_query($conn,$strSQL15);
	
}*/
	


/*if($sku=='BSX593' or $sku =='BSX593-L' or $sku=='JPD-HA120' or $sku=='SCA-ZTE-BODYA1BW' or $sku=='GCA10' or $sku=='GCA60'){
	
$strSQL15 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sale_remark)
values ('".$main_id."','".$unit1."','".$unit1."','0.00','0.00','0.00','0.00','4170','4170','','Approve','แถมตลับใส่ยาเก่า')";
$objQuery15 = mysqli_query($conn,$strSQL15);
	
}
	
if($sku=='GLS25'){
	
$strSQL15 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sale_remark)
values ('".$main_id."','".$unit1."','".$unit1."','0.00','0.00','0.00','0.00','5494','5494','','Approve','แถมตลับใส่ยาเก่า')";
$objQuery15 = mysqli_query($conn,$strSQL15);
	
}*/

	
	
	
	
	
if($voucher_seller !='0'){

$strSQL17 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,status_sol)
values ('".$main_id."','1','1','0.00','0.00','".$voucher_seller1."','".$voucher_seller."','3196','3196','Approve')";
$objQuery17 = mysqli_query($conn,$strSQL17);	
	
}
	

	
	
}else if($shop_running=='20'){
	
$sql2 = "SELECT * FROM tb_product_lzd where code_lazada='".$sku."'";
$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($query2);
$fetch2 = mysqli_fetch_array($query2);
	
if($fetch4["doc_no"]!=''){	}else{
if($fetch2["company"]=='AWL'){

if($bill_vat=='1'){
	
if($fetch4["tax_id"]!='0000000000000' and $fetch4["tax_id"]!='' and $email!=''){
	
$select_type_doc ='3';		
$date = explode('-' , $register_date);
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);
$bill_vat = '1';
$send_supadm = '1';
$status_vat  = "Approve";		

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_et_awl where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ET";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$doc_no = $so.$year1.$mont.$nextId;

$save9="insert into tb_et_awl (doc_no,year_no,mount_no,run_no,iv_date,ref_so) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$register_date."','".$ref_id."')";
$qsave9=mysqli_query($conn,$save9);
	
	

/*$sql = "SELECT MAX(run_no) AS MAXID FROM tb_doc_ptl where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "IE";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$doc_no = $so.$year1.$mont.$nextId;

$save9="insert into tb_doc_ptl (doc_no,year_no,mount_no,run_no,iv_date,ref_so) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$register_date."','".$ref_id."')";
$qsave9=mysqli_query($conn,$save9);*/



	
	
	
}else{
	
$select_type_doc ='1';		
$bill_vat = '0';
$send_supadm = '0';
$status_vat  = "";		
	
$sql1 = "SELECT doc_no FROM tb_solptl where sale_channel = '".$shop_running."' and date_sol = '".$register_date."'";
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
	

$save="insert into tb_solptl (doc_no,date_sol,sale_channel ) values ('".$doc_no."','".$register_date."','".$shop_running."')";
$qsave=mysqli_query($conn,$save);

}		
	
	
	
}
		
	}else{
	
$select_type_doc ='1';	
$bill_vat = '0';
$send_supadm = '0';
$status_vat  = "";	
	
$sql1 = "SELECT doc_no FROM tb_solptl where sale_channel = '".$shop_running."' and date_sol = '".$register_date."'";
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
	

$save="insert into tb_solptl (doc_no,date_sol,sale_channel ) values ('".$doc_no."','".$register_date."','".$shop_running."')";
$qsave=mysqli_query($conn,$save);

}	
	}	

	
}else if($fetch2["company"]=='NBM'){



if($bill_vat=='1'){
	
/*if($fetch14["billing_name"]!='' or $fetch15["billing_name"]!='' or $fetch16["billing_name"]!='' or $fetch17["billing_name"]!='' or $fetch18["billing_name"]!='' or $fetch19["billing_name"]!=''){	*/
	
if($fetch4["tax_id"]!='0000000000000' and $fetch4["tax_id"]!='' and $email!=''){	
	
$select_type_doc ='4';	
$bill_vat = '1';
$send_supadm = '1';
$status_vat  = "Approve";	
		
$date = explode('-' , $register_date);
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
$doc_no = $so.$year1.$so1.$mont.$nextId;

$save9="insert into tb_et_nbm (doc_no,year_no,mount_no,run_no,ref_so,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id."','".$register_date."')";
$qsave9=mysqli_query($conn,$save9);
	
	

/*$sql = "SELECT MAX(run_no) AS MAXID FROM tb_doc_nbm where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "IE";
$so1 = "/";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$doc_no = $so.$year1.$so1.$mont.$nextId;

$save9="insert into tb_doc_nbm (doc_no,year_no,mount_no,run_no,ref_so,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id."','".$register_date."')";
$qsave9=mysqli_query($conn,$save9);*/


	
	
	
	
}else{
	
$select_type_doc ='2';	
$bill_vat = '0';
$send_supadm = '0';
$status_vat  = "";	
	
$sql1 = "SELECT doc_no FROM tb_solnbm where sale_channel = '".$shop_running."' and date_sol = '".$register_date."'";
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
	

$save="insert into tb_solnbm (doc_no,date_sol,sale_channel) values ('".$doc_no."','".$register_date."','".$shop_running."')";
$qsave=mysqli_query($conn,$save);

}	
	
}
		
	}else{
$select_type_doc ='2';
$bill_vat = '0';
$send_supadm = '0';
$status_vat  = "";	
	
$sql1 = "SELECT doc_no FROM tb_solnbm where sale_channel = '".$shop_running."' and date_sol = '".$register_date."'";
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
	

$save="insert into tb_solnbm (doc_no,date_sol,sale_channel) values ('".$doc_no."','".$register_date."','".$shop_running."')";
$qsave=mysqli_query($conn,$save);

}	
	}	
	
}		
	
$date = explode(',' , $obj->data[$x]->shipment_provider );	
$cs_remark = $date[0];	
	
$save19="UPDATE so__main SET select_type_doc ='".$select_type_doc."',doc_no = '".$doc_no."',status_vat='".$status_vat."',send_supadm='".$send_supadm."',bill_vat='".$bill_vat."',cs_remark='".$cs_remark."',order_refer_code='" . $obj->data[$x]->tracking_code . "',email='".$obj->data[$x]->digital_delivery_info."',order_item_id='".$obj->data[$x]->order_item_id."'  where ref_id='".$ref_id."'";
$qsave19=mysqli_query($conn,$save19);	
}
	
		
	

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
	
	

$unit1 = $fetch2["unit1"];
$unit2 = $fetch2["unit2"];
$unit3 = $fetch2["unit3"];
$unit4 = $fetch2["unit4"];
$unit5 = $fetch2["unit5"];
$unit6 = $fetch2["unit6"];
$unit7 = $fetch2["unit7"];
$unit8 = $fetch2["unit8"];
$unit7 = $fetch2["unit7"];
$unit8 = $fetch2["unit8"];
$unit9 = $fetch2["unit9"];
$unit10 = $fetch2["unit10"];

	
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

$price_per_unit = ($paid_price/$unit1);		

/*if($voucher_amount !='0'){
$voucher_amount1 = $voucher_amount/2;	
$voucher = "-$voucher_amount1";	

$strSQL17 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code)
values ('".$main_id."','1','1','0.00','0.00','".$voucher."','".$voucher_amount1."','3196','3196')";
$objQuery17 = mysqli_query($conn,$strSQL17);	
	
}	*/
	
$price_lazada = $fetch2["percen_price"]; 	




if($paid_price < $price_lazada){	

$strSQL15 = "SELECT ref_id,doc_no,select_type_doc FROM  so__main  where ref_id='".$main_id."'";
$objQuery15 = mysqli_query($stock_out,$strSQL15);
$objResult15 = mysqli_fetch_array($objQuery15);	
	

$save19="UPDATE so__main SET price_ckk ='1',approve_complete='Request' where ref_id='".$main_id."'";
$qsave19=mysqli_query($conn,$save19);	
	
if($objResult15["select_type_doc"]=='3'){

$strSQL = "DELETE FROM tb_et_awl WHERE doc_no = '".$objResult15["doc_no"]."'";
$objQuery = mysqli_query($conn,$strSQL);
	
$save19="UPDATE so__main SET price_ckk ='1',doc_no ='' where ref_id='".$main_id."'";
$qsave19=mysqli_query($conn,$save19);	

}

if($objResult15["select_type_doc"]=='4'){
	
$strSQL = "DELETE FROM tb_et_nbm WHERE doc_no = '".$objResult15["doc_no"]."'";
$objQuery = mysqli_query($conn,$strSQL);	

$save19="UPDATE so__main SET price_ckk ='1',doc_no ='' where ref_id='".$main_id."'";
$qsave19=mysqli_query($conn,$save19);	

}		

}		
	

if($id_product1 !=''){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sku_code)
values ('".$main_id."','".$unit1."','".$unit1."','".$price_per_unit."','".$paid_price."','".$paid_price."','0.00','".$id_product1."','".$id_product1."','".$waranty1."','Approve','".$sku."')";

$objQuery1 = mysqli_query($conn,$strSQL1);
	
	
$strSQL11 = "Update so__main order_refer_code = '".$obj->data[$x]->tracking_code."',email='".$obj->data[$x]->digital_delivery_info."' where ref_id = '".$main_id."'";
$objQuery11 = mysqli_query($conn,$strSQL11);	
	

$strSQL12 = "insert into so__disecom(ref_so,price_dis,order_num,sale_chan,date_today) values ('".$main_id."','".$dis_price."','".$order_id."','".$shop_running."','".$register_date."')";
$objQuery12 = mysqli_query($conn,$strSQL12);	
	
/*$strSQL11 = "Update so__main order_refer_code = '".$obj->data[$x]->tracking_code."' where ref_id = '".$main_id."'";
$objQuery11 = mysqli_query($conn,$strSQL11);*/	
}


if($id_product2 !=''){

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','0.00','".$id_product2."','".$id_product2."','".$waranty2."','Approve')";

$objQuery2 = mysqli_query($conn,$strSQL2);
	
}


if($id_product3 !=''){

$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','0.00','".$id_product3."','".$id_product3."','".$waranty3."','Approve')";

$objQuery3 = mysqli_query($conn,$strSQL3);

}

if($id_product4 !=''){

$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','0.00','".$id_product4."','".$id_product4."','".$waranty4."','Approve')";

$objQuery4 = mysqli_query($conn,$strSQL4);

}
	
if($id_product5 !=''){

$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','0.00','".$id_product5."','".$id_product5."','".$waranty5."','Approve')";
	$objQuery5 = mysqli_query($conn,$strSQL5);
}	

	
if($id_product6 !=''){

$strSQL6 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','0.00','".$id_product6."','".$id_product6."','".$waranty6."','Approve')";
	$objQuery6 = mysqli_query($conn,$strSQL6);
}	
		
if($id_product7 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','0.00','".$id_product7."','".$id_product7."','".$waranty7."','Approve')";
	$objQuery7 = mysqli_query($conn,$strSQL7);
}	

if($id_product8 !=''){

$strSQL8 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','0.00','".$id_product8."','".$id_product8."','".$waranty8."','Approve')";
$objQuery8 = mysqli_query($conn,$strSQL8);
}		
	
if($id_product9 !=''){

$strSQL7 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','0.00','".$id_product9."','".$id_product9."','".$waranty9."','Approve')";
	$objQuery9 = mysqli_query($conn,$strSQL9);
}		

if($id_product10 !=''){

$strSQL10 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','0.00','".$id_product10."','".$id_product10."','".$waranty10."','Approve')";
	$objQuery10 = mysqli_query($conn,$strSQL10);
}
	
	
	
	
	
	
	
	
if($voucher_seller !='0'){

$strSQL17 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,status_sol)
values ('".$main_id."','1','1','0.00','0.00','".$voucher_seller1."','".$voucher_seller."','3196','3196','Approve')";
$objQuery17 = mysqli_query($conn,$strSQL17);	
	
}		
	

}
		
	

        $values = $values . "(
            '" . $order_id . "',
            " . $shop_running . ",
            " . $item_no . ",
            '" . $obj->data[$x]->reason . "',
            '" . $obj->data[$x]->digital_delivery_info . "',
            '" . $obj->data[$x]->promised_shipping_time . "',
            '" . $obj->data[$x]->voucher_amount . "',
            '" . $obj->data[$x]->return_status . "',
            '" . $obj->data[$x]->shipping_type . "',
            '" . $obj->data[$x]->shipment_provider . "',
            '" . $obj->data[$x]->variation . "',
            '" . $obj->data[$x]->created_at . "',
            '" . $obj->data[$x]->invoice_number . "',
            '" . $obj->data[$x]->shipping_amount . "',
            '" . $obj->data[$x]->currency . "',
            '" . $obj->data[$x]->order_flag . "',
            '" . $obj->data[$x]->shop_id . "',
            '" . $obj->data[$x]->sla_time_stamp . "',
            '" . $obj->data[$x]->sku . "',
            '" . $obj->data[$x]->voucher_code . "',
            '" . $obj->data[$x]->wallet_credits . "',
            '" . $obj->data[$x]->updated_at . "',
            " . $obj->data[$x]->is_digital . ",
            '" . $obj->data[$x]->tracking_code_pre . "',
            " . $obj->data[$x]->order_item_id . ",
            '" . $obj->data[$x]->package_id . "',
            '" . $obj->data[$x]->tracking_code . "',
            " . $obj->data[$x]->shipping_service_cost . ",
            '" . $obj->data[$x]->extra_attributes . "',
            '" . $obj->data[$x]->paid_price . "',
            '" . $obj->data[$x]->shipping_provider_type . "',
            '" . $obj->data[$x]->product_detail_url . "',
            '" . $obj->data[$x]->shop_sku . "',
            '" . $obj->data[$x]->reason_detail . "',
            '" . $obj->data[$x]->purchase_order_id . "',
            '" . $obj->data[$x]->purchase_order_number . "',
            '" . $obj->data[$x]->name . "',
            '" . $obj->data[$x]->product_main_image . "',
            '" . $obj->data[$x]->item_price . "',
            '" . $obj->data[$x]->tax_amount . "',
            '" . $obj->data[$x]->status . "',
            '" . $obj->data[$x]->cancel_return_initiator . "',
            '" . $obj->data[$x]->voucher_platform . "',
            '" . $obj->data[$x]->voucher_seller . "',
            '" . $obj->data[$x]->order_type . "',
            '" . $obj->data[$x]->stage_pay_status . "',
            '" . $obj->data[$x]->warehouse_code . "',
            '" . $obj->data[$x]->shipping_fee_original . "',
            '" . $obj->data[$x]->shipping_fee_discount_seller . "',
            '" . $obj->data[$x]->shipping_fee_discount_platform . "',
            '" . $obj->data[$x]->voucher_code_seller . "',
            '" . $obj->data[$x]->voucher_code_platform . "'
            )";

        $x += 1;
    }
	
	
$companies = array_values(array_unique(array_filter($companies)));

if (count($companies) >= 2) {

$strSQL = "Update  so__main set doc_release_date='0000-00-00' Where ref_id = '".$ref_id."'";
$objQuery = mysqli_query($conn,$strSQL);		
	
}

    //echo $values;
    $sql = $sql . $values;
    //echo $sql;


    //delete before insert
    $sqlDelete = "DELETE FROM shopOrderItems WHERE order_id = '" . $order_id . "'";
    //echo $sqlDelete;
    if ($conn->query($sqlDelete) === TRUE) {

        //insert orders to database
        if ($conn->query($sql) === TRUE) {
            $result = true;
        } else {
            echo $conn->error;
        }
        CloseCon($conn);
        return $result;
    } else {
        echo $conn->error;
    }
}



function saveupdatetrack($obj, $order_id, $shop_running)
{
    $conn = OpenCon(); // เปิดการเชื่อมต่อฐานข้อมูล
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (!isset($obj->data) || !is_array($obj->data)) {
        return false;
    }

    $x = 0;
    while ($x < count($obj->data)) {
        // ใช้ prepared statement เพื่อความปลอดภัย
        $sql4 = "SELECT ref_id FROM so__main WHERE order_id=?";
        $stmt4 = mysqli_prepare($conn, $sql4);
        mysqli_stmt_bind_param($stmt4, "s", $order_id);
        mysqli_stmt_execute($stmt4);
        $result4 = mysqli_stmt_get_result($stmt4);
        $fetch4 = mysqli_fetch_array($result4);
        
        if (!$fetch4) {
            return false;
        }

        $ref_id = $fetch4["ref_id"];

        // อัปเดตข้อมูล order_refer_code
        $tracking_code = $obj->data[$x]->tracking_code;
        $save19 = "UPDATE so__main SET order_refer_code=? WHERE ref_id=?";
        $stmt19 = mysqli_prepare($conn, $save19);
        mysqli_stmt_bind_param($stmt19, "ss", $tracking_code, $ref_id);
        mysqli_stmt_execute($stmt19);

        $x++;
    }
    
    mysqli_close($conn); // ปิดการเชื่อมต่อฐานข้อมูล
    return true;
}



