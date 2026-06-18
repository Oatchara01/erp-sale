<?php

$start_date = date('Y-m-d');
$date_1ms = date("Y-m-d",strtotime("+30 days"));
include "dbconnect.php";



//สินค้ายอดนิยมออนไลน์คงเหลือต่ำกว่ากำหนด	
$strSQL = "SELECT access_code, sol_name, unit_name,product_ID,ecom_count FROM tb_product WHERE  close_pro = '0' AND close_out = '1' and ecom_ckk='1'";
$strSQL .= " ORDER BY number ASC";
$objQuery = mysqli_query($new, $strSQL) or die("Error Query [" . $strSQL . "]");
$Num_Rows = mysqli_num_rows($objQuery);

$j = 0; // ปรับตัวแปร $j ให้อยู่ภายนอกลูป
while ($objResult = mysqli_fetch_array($objQuery)) {
$strSQL37 = "SELECT SUM(count_send) AS count_send, SUM(count_receive) AS count_receive FROM st__sbmain WHERE product_id = '" . $objResult["product_ID"] . "'";
$objQuery37 = mysqli_query($new, $strSQL37);
$objResult37 = mysqli_fetch_array($objQuery37);

$count_send7 = $objResult37["count_send"];
$count_receive7 = $objResult37["count_receive"];
	
// คงเหลือ
$count_pro =$count_receive7-$count_send7;	
	
//หมดอายุ
$strSQL73 = "SELECT SUM(count) AS count FROM tb_product_outtime WHERE product_id = '".$objResult["product_ID"]."' and pass='0'";
$objQuery73 = mysqli_query($new,$strSQL73);
$objResult73 = mysqli_fetch_array($objQuery73);	
	
if($objResult73["count"]!=''){	
$outtime =$objResult73["count"];
}else{
$outtime ='0.00';	
}
	
//เกรด B	
$strSQL83 = "SELECT SUM(count) AS count FROM tb_product_gradb WHERE product_id = '".$objResult["product_ID"]."' and pass='0'";
$objQuery83 = mysqli_query($new,$strSQL83);
$objResult83 = mysqli_fetch_array($objQuery83);		

if($objResult83["count"]!=''){	
$gradb =$objResult83["count"];
}else{
$gradb ='0.00';	
}
	
//มีปัญหา
$strSQL13 = "SELECT SUM(count) AS count FROM tb_product_proprem WHERE product_id = '".$objResult["product_ID"]."' and pass='0'";
$objQuery13 = mysqli_query($new,$strSQL13);
$objResult13 = mysqli_fetch_array($objQuery13);		

if($objResult13["count"]!=''){	
$pro_proprem =$objResult13["count"];
}else{
$pro_proprem ='0.00';	
}
	
//คำนวณวันที่ของเข้า
$product_id = $objResult["product_ID"]; // รับค่า product_ID
$po_data = []; // สร้าง array เก็บค่า po_no และ in7

// ค้นหา PO ที่เกี่ยวข้องกับ product_id ที่กำหนด และยังไม่ได้ถูกปิด
$strSQL241 = "SELECT DISTINCT po_no, product_id 
              FROM po__submain 
              WHERE product_id = '$product_id' 
              AND int_ckk = '1' 
              AND st_ckk = '0'";

$objQuery241 = mysqli_query($inter, $strSQL241) or die ("Error Query [".$strSQL241."]");

while ($objResult241 = mysqli_fetch_array($objQuery241)) {
    $po_no = $objResult241["po_no"];

    if (!empty($po_no)) {
        // ตรวจสอบว่า PO ยังไม่ถูกปิด
        $strSQL_ex = "SELECT po_no 
                      FROM po__main 
                      WHERE po_success != '1' 
                      AND po_no = '$po_no'";

        $objQuery_ex = mysqli_query($inter, $strSQL_ex);
        $NobjQuery_ex = mysqli_num_rows($objQuery_ex);

        if ($NobjQuery_ex > 0) {
            // ค้นหา in7 ล่าสุดที่ไม่ใช่ '0000-00-00'
            $strSQL_day = "SELECT po_no, in7 
                           FROM po__in 
                           WHERE po_no = '$po_no' 
                           AND in7 != '0000-00-00' 
                           ORDER BY in7 DESC 
                           LIMIT 1";

            $objQuery_day = mysqli_query($inter, $strSQL_day);
            $objResult_day = mysqli_fetch_array($objQuery_day);

            if (!empty($objResult_day["in7"])) {
                $po_data[$po_no] = $objResult_day["in7"];
            }
        }
    }
}

// คำนวณความต่างของวันที่
$start_date1 = new DateTime(date('Y-m-d H:i:s')); // วันที่ปัจจุบัน
$rti = ''; // กำหนดค่าเริ่มต้น

foreach ($po_data as $po_no => $in7) {
    $in71 = new DateTime("$in7 00:00:00");   
    $dass = $start_date1->diff($in71);

    if ($start_date1 < $in71) {
        $rti = "AND date_receive <= '$in7'";
		$rti1 = "AND delivery_contract <= '$in7'";
    } else {
        $rti = '';
		$rti1 = '';
    }

}


	
	
//ใบจองสัญญา
$strSQL16 = "SELECT * FROM (hos__jongproduct LEFT JOIN hos__subjongpro ON hos__jongproduct.ref_id=hos__subjongpro.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and close_ckk = '0' and status_sub ='Approve' and type_jong='1' $rti";
$objQuery16 = mysqli_query($conn,$strSQL16);
$sum = 0;	
$i = 0;	
	
while($objResult16 = mysqli_fetch_array($objQuery16))
{
	
	
$sql3 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '".$objResult["product_ID"]."' and jong_ckk = '1' and jong_no ='".$objResult16["iv_no"]."' and status_sol = 'Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);
	
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$objResult["product_ID"]."' and jong_ckk = '1' and jong_no ='".$objResult16["iv_no"]."' and status_so = 'Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_assoc($qry13);
	

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
	
$sum = ($objResult16["count"]-($count3+$count13))+$sum;	
	
$sum++;
$i++;	
}

//ใบจองสัญญา
$count_jong1 =$sum-$i;
$jong1= number_format( $count_jong1,2)."";
	
	
	
$strSQL106 = "SELECT * FROM (hos__jongproduct LEFT JOIN hos__subjongpro ON hos__jongproduct.ref_id=hos__subjongpro.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and close_ckk = '0' and status_sub ='Approve' and type_jong='2' $rti";
//echo $strSQL106;	
	
$objQuery106 = mysqli_query($conn,$strSQL106);

$sum1 = 0;	
$i1 = 0;	
	
while($objResult106 = mysqli_fetch_array($objQuery106))
{
	
	
$sql3 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '".$objResult["product_ID"]."' and jong_ckk = '1' and jong_no ='".$objResult106["iv_no"]."' and status_sol = 'Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);
	
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$objResult["product_ID"]."' and jong_ckk = '1' and jong_no ='".$objResult106["iv_no"]."' and status_so = 'Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_assoc($qry13);
	

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
	
$sum1 = ($objResult106["count"]-($count3+$count13))+$sum1;	
	
$sum1++;
$i1++;	
}
	
//ใบจอง FC
$count_jong2 =$sum1-$i1;
$jong2= number_format( $count_jong2,2)."";
	
$strSQL1 = "SELECT SUM(count) AS count FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE have_order ='1' and have_product = '0' and product_id = '".$objResult["product_ID"]."' and status_doc ='Approve'";
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);		
	
$strSQL2 = "SELECT SUM(sale_count) AS count FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and have_order ='1' and have_product = '0' and approve_complete ='Approve' and cancel_ckk='0'";
	
$objQuery2 = mysqli_query($conn,$strSQL2);
$objResult2 = mysqli_fetch_array($objQuery2);	

$count_hot =$objResult1['count'];
$count_sol =$objResult2['count'];

//ใบฝาก
$count_sale = $count_hot+$count_sol;
$sale= number_format( $count_sale,2)."";
	
	
	
$strSQLn1 = "SELECT SUM(count) AS count FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE have_order ='1' and have_product = '0' and product_id = '".$objResult["product_ID"]."' and status_doc ='Approve' and delivery_contract!='0000-00-00' $rti1";
$objQueryn1 = mysqli_query($conn,$strSQLn1);
$objResultn1 = mysqli_fetch_array($objQueryn1);		
	
$strSQLn2 = "SELECT SUM(sale_count) AS count FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and have_order ='1' and have_product = '0' and approve_complete ='Approve' and cancel_ckk='0' and delivery_contract!='0000-00-00' $rti1";
	
$objQueryn2 = mysqli_query($conn,$strSQLn2);
$objResultn2 = mysqli_fetch_array($objQueryn2);		
	
	
$count_hot_new =$objResultn1['count'];
$count_sol_new =$objResultn2['count'];

//ใบฝาก
$count_sale_new = $count_hot_new+$count_sol_new;
$sale_new = number_format( $count_sale_new,2)."";	
		
$strSQLp1 = "SELECT SUM(count) AS count FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE have_order ='0' and have_product = '0' and product_id = '".$objResult["product_ID"]."' and status_doc ='Approve'  and send_erpst='0' and ref_idst='' and clear_br ='0' and delivery_date <='$date_1ms'";
$objQueryp1 = mysqli_query($conn,$strSQLp1);
$objResultp1 = mysqli_fetch_array($objQueryp1);		
	
$strSQLp3 = "SELECT SUM(count) AS count FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE  have_product = '2' and product_id = '".$objResult["product_ID"]."' and status_doc ='Approve'  and send_erpst='0' and ref_idst='' and clear_br ='0' and delivery_date <='$date_1ms'";
$objQueryp3 = mysqli_query($conn,$strSQLp3);
$objResultp3 = mysqli_fetch_array($objQueryp3);			
	
$strSQLp2 = "SELECT SUM(sale_count) AS count FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and have_order ='0' and have_product = '0' and approve_complete ='Approve' and cancel_ckk='0'  and send_erpst='0' and ref_idst='' and clear_br ='0' and delivery_date <='$date_1ms'";
	
$objQueryp2 = mysqli_query($conn,$strSQLp2);
$objResultp2 = mysqli_fetch_array($objQueryp2);	
	
	
$strSQLp4 = "SELECT SUM(sale_count) AS count FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and have_order ='1' and have_product = '2' and approve_complete ='Approve' and cancel_ckk='0'  and send_erpst='0' and ref_idst='' and clear_br ='0' and delivery_date <='$date_1ms'";
	
$objQueryp4 = mysqli_query($conn,$strSQLp4);
$objResultp4 = mysqli_fetch_array($objQueryp4);	
	

$hot =$objResultp1['count'];
$hot1 =$objResultp3['count'];	
$sol =$objResultp2['count'];
$sol1 =$objResultp4['count'];

//รอส่ง
$wait_send = $hot1+$hot+$sol+$sol1;
$wait= number_format( $wait_send,2)."";			
$count_pro7 = $count_pro-($outtime+$gradb+$pro_proprem+$count_jong1+$count_jong2+$count_sale_new+$wait_send);	


    if ($count_pro7 > $objResult["ecom_count"]) {


	$save="Update  tb_product set close_in ='1'  where product_ID = '".$objResult["product_ID"]."' ";
	$qsave=mysqli_query($conn,$save);

	$save1="Update  tb_product set close_in ='1'  where product_ID = '".$objResult["product_ID"]."' ";
	$qsave1=mysqli_query($new,$save1);


        
    }
}
	












?>