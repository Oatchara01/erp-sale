<?php 

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // ไม่ต้องแสดงผล Error ที่ไม่สำคัญ เช่น Warning
    if ($errno == E_WARNING) {
        return true; // ข้าม Warning
    }
    return false; // แสดง Error อื่น ๆ ตามปกติ
});

include('head.php'); 

include "dbconnect.php";

?>
<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 16px; color: #000000;
}
.style16 {font-size: 18px; color: #FF0000;}
.style17 {font-size: 18px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #CC0066; font-size: 14px; }
.style38 {font-size: 14px; color: #FF0000;}
.style39 {font-size: 14px; color: #339900;}
.style40 {font-size: 14px; color: #3333CC; }
.style41 {font-size: 14px; color: #FF0000; }	
-->

</style>



<?php
	 function DateDiff($strDate1,$strDate2)
{
return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
}
function TimeDiff($strTime1,$strTime2)
{
return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}
function DateTimeDiff($strDateTime1,$strDateTime2)
{
return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}

date_default_timezone_set("Asia/Bangkok");
$group = $_GET["group"];
$group1 = $_GET["group1"];
$h_product_codet = $_GET["h_product_codet"];
$h_product_code = $_GET["h_product_code"];
$product_bar = $_GET["product_bar"];
$h_vender_name = $_GET["h_vender_name"];
$h_product_code1 = $_GET["h_product_code1"];
$start_date = date('Y-m-d');
?>
<body>

<br>

<div class="w3-white">
<div class="w3-container w3-padding-large">

<center>
<span class="style15">รายงานสินค้าคงเหลือ + จุดสั่งซื้อ</span><br>
<span class="style15">บริษัท ออลล์เวล ไลฟ์ จำกัด</span><br>
<span class="style15"><?php echo Datethai($start_date); ?> <?php echo $time; ?></span>


</center>




	<br>		

<div align="right">#5016</div></p>


<table border= "1" width="100%" class='w3-table'>
<tr>
<th width="5%" align="center" class="style30">รหัสสินค้า</th>
<th width="15%" align="center" class="style30">รายการสินค้า</th>
<th width="2%" align="center" class="style30">หน่วย</th>
<th width="2%" align="center" class="style30">คงเหลือ</th>
<th width="2%" align="center" class="style30">QC แล้ว</th> 	
	
<?php if($_SESSION['name']=='สมบัติ' or $_SESSION['name']=='อัจฉรา'){	?>
<th width="2%" align="center" class="style30">พร้อมขาย (สั่งสินค้า)</th> 	
<?php } ?>		
<th width="2%" align="center" class="style30">พร้อมขาย</th> 
<th width="2%" align="center" class="style30">หมดอายุ</th> 
<th width="2%" align="center" class="style30">มีปัญหา</th>
<th width="2%" align="center" class="style30">เกรด B</th>
<th width="2%" align="center" class="style30">จอง contract</th> 
<th width="2%" align="center" class="style30">จอง FC</th> 
<th width="2%" align="center" class="style30">Order ฝาก</th>
<th width="2%" align="center" class="style30">รอส่ง</th>
<th width="2%" align="center" class="style30">จุดสั่งซื้อ</th> 
<th width="2%" align="center" class="style30">อัตราการขายเดือนล่าสุด</th>
<th width="2%" align="center" class="style30">อัตราค่าเฉลี่ย 3 เดือน</th>
<th width="2%" align="center" class="style30">สั่งแล้ว</th> 
<th width="5%" align="center" class="style30">เลขที่ใบสั่งซื้อ</th>
<th width="2%" align="center" class="style30">รวมซื้อ</th> 
</tr>

	<?php
$strSQL = "SELECT grade_b,expire_total,problem_total,reorder_point,access_code,sol_name,order_no,unit_name,product_ID,ordered,order_count,code_type,due_date  FROM tb_product  WHERE  close_pro ='0'";
	
if($group !=""){ 
    $strSQL .= ' AND group1 = "'.$group.'"'; 
}else if($group1){
 $strSQL .= ' AND group1 = "'.$group1.'"'; 	
}

if($h_vender_name !=""){ 
    $strSQL .= ' AND vender_name = "'.$h_vender_name.'"'; 
}

if($h_product_codet !=""){ 
    $strSQL .= ' AND product_ID = "'.$h_product_codet.'"'; 
}


if($h_product_code !=""){ 
    $strSQL .= ' AND product_ID = "'.$h_product_code.'"'; 
}
	
if($h_product_code1!=""){	
    $strSQL .= ' AND product_ID = "'.$h_product_code1.'"'; 	
}	

if($product_bar !=""){ 
    $strSQL .= ' AND sol_code = "'.$product_bar.'"'; 
}



$strSQL .=" order  by number ASC  ";	

$objQuery = mysqli_query($new,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


while($objResult = mysqli_fetch_array($objQuery))
{

	
	
////คำนวณจุดสั่งซื้อ
$due_date = $objResult["due_date"]+15;	
$lead_time = $objResult["due_date"]; //(+15)*0.032877;
$date_bk = date("Y-m-d",strtotime("-$due_date days"));
$date_kk = date("Y-m-d",strtotime("-90 days"));
$date_1m = date("Y-m-d",strtotime("-30 days"));
$date_today = date("Y-m-d");
$date_1ms = date("Y-m-d",strtotime("+30 days"));	
	

if ($objResult["sn_ckk"] == '1') {

    $product_id = $objResult["product_ID"];

    $sql_qc = "SELECT COUNT(product_sn) AS total_qc
               FROM product__instock
               WHERE product_id = '$product_id'
               AND buy_status = '0'
			   AND product_sn NOT LIKE '%*%'";

    $qry_qc = mysqli_query($new, $sql_qc) or die("Error Query [" . $sql_qc . "]");
    $row_qc = mysqli_fetch_array($qry_qc);
    $total_qc = (int)$row_qc["total_qc"];

    $count_lot = $total_qc;

} else {
    $count_lot = "-";
}	
	
	
	
if($objResult["code_type"] !=''){

$strSQL93 = "SELECT SUM(count_send) AS count_send FROM (st__sbmain LEFT JOIN tb_product ON st__sbmain.product_ID=tb_product.product_id) WHERE code_type = '".$objResult["code_type"]."' and date_st >='".$date_bk."' and date_st <='".$date_today."'";
$objQuery93 = mysqli_query($new,$strSQL93);
$objResult93 = mysqli_fetch_array($objQuery93);	
	
$strSQL94 = "SELECT SUM(count_send) AS count_send FROM (st__sbmain LEFT JOIN tb_product ON st__sbmain.product_ID=tb_product.product_id) WHERE code_type = '".$objResult["code_type"]."' and date_st >='".$date_kk."' and date_st <='".$date_today."' and type_doc!='11' and type_doc!='6' and type_doc!='12' and type_doc!='13'";
$objQuery94 = mysqli_query($new,$strSQL94);
$objResult94 = mysqli_fetch_array($objQuery94);	
	
$strSQL95 = "SELECT SUM(count_send) AS count_send FROM (st__sbmain LEFT JOIN tb_product ON st__sbmain.product_ID=tb_product.product_id) WHERE code_type = '".$objResult["code_type"]."' and date_st >='".$date_1m."' and date_st <='".$date_today."' and type_doc!='11' and type_doc!='6' and type_doc!='12' and type_doc!='13'";
$objQuery95 = mysqli_query($new,$strSQL95);
$objResult95 = mysqli_fetch_array($objQuery95);		
	

if($due_date=='0'){	
$send_cm ='';	
}else{
$send_cm = 	$objResult93["count_send"];  //ยอดที่ขายได้ตามวันที่ต้องรอของ
}
	
$send_3m = 	$objResult94["count_send"];	 //ยอดขาย 3 เดือนย้อนหลัง
$send_1m = 	$objResult95["count_send"];  //ยอดขาย 1 เดือนย้อนหลัง

	
$strSQL37 = "SELECT SUM(count_send) AS count_send ,SUM(count_receive) AS count_receive FROM (st__sbmain LEFT JOIN tb_product ON st__sbmain.product_ID=tb_product.product_id) WHERE code_type = '".$objResult["code_type"]."' ";
$objQuery37 = mysqli_query($new,$strSQL37);
$objResult37 = mysqli_fetch_array($objQuery37);

$count_send7 = $objResult37["count_send"];
$count_receive7 = $objResult37["count_receive"];
//คงเหลือ
$count_pro7 =$count_receive7-$count_send7;		
	
}else{

$strSQL93 = "SELECT SUM(count_send) AS count_send FROM st__sbmain WHERE product_id = '".$objResult["product_ID"]."' and date_st >='".$date_bk."' and date_st <='".$date_today."'";

$objQuery93 = mysqli_query($new,$strSQL93);
$objResult93 = mysqli_fetch_array($objQuery93);	
	
$strSQL94 = "SELECT SUM(count_send) AS count_send FROM st__sbmain WHERE product_id = '".$objResult["product_ID"]."' and date_st >='".$date_kk."' and date_st <='".$date_today."' and type_doc!='11' and type_doc!='6' and type_doc!='12' and type_doc!='13'";
$objQuery94 = mysqli_query($new,$strSQL94);
$objResult94 = mysqli_fetch_array($objQuery94);	
	
$strSQL95 = "SELECT SUM(count_send) AS count_send FROM st__sbmain WHERE product_id = '".$objResult["product_ID"]."' and date_st >='".$date_1m."' and date_st <='".$date_today."' and type_doc!='11' and type_doc!='6' and type_doc!='12' and type_doc!='13'";
$objQuery95 = mysqli_query($new,$strSQL95);
$objResult95 = mysqli_fetch_array($objQuery95);	



if($due_date=='0'){	
$send_cm ='';	
}else{
$send_cm = 	$objResult93["count_send"];  //ยอดที่ขายได้ตามวันที่ต้องรอของ
}
	
$send_3m = 	$objResult94["count_send"];	 //ยอดขาย 3 เดือนย้อนหลัง
$send_1m = 	$objResult95["count_send"];	 //ยอดขาย 1 เดือนย้อนหลัง

	
$strSQL37 = "SELECT SUM(count_send) AS count_send ,SUM(count_receive) AS count_receive FROM st__sbmain WHERE product_id = '".$objResult["product_ID"]."' ";
$objQuery37 = mysqli_query($new,$strSQL37);
$objResult37 = mysqli_fetch_array($objQuery37);

$count_send7 = $objResult37["count_send"];
$count_receive7 = $objResult37["count_receive"];
//คงเหลือ
$count_pro7 =$count_receive7-$count_send7;	
	
	
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

	
/*$start_date1 = new DateTime(); 
$in71 = new DateTime("$in7 23:59:59");

if ($start_date1 <= $in71) {
    $rti  = "AND date_receive <= '$in7'";
    $rti1 = "AND delivery_contract <= '$in7'";
} else {
    $rti = '';
    $rti1 = '';
}
*/
	
	
//ใบจองสัญญา
$strSQL16 = "SELECT * FROM (hos__jongproduct LEFT JOIN hos__subjongpro ON hos__jongproduct.ref_id=hos__subjongpro.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and close_ckk = '0' and status_sub ='Approve' and type_jong='1' $rti";
//echo $strSQL16;	
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
	
	
	
/*------------------------------------*/	
	
//จองแสดงตาราง	
	
	

//ใบจองสัญญา
$strSQL16 = "SELECT * FROM (hos__jongproduct LEFT JOIN hos__subjongpro ON hos__jongproduct.ref_id=hos__subjongpro.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and close_ckk = '0' and status_sub ='Approve' and type_jong='1'";
$objQuery16 = mysqli_query($conn,$strSQL16);
$sum_web = 0;	
$i_web = 0;	
	
while($objResult16 = mysqli_fetch_array($objQuery16))
{
	
	
$sql3 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '".$objResult["product_ID"]."' and jong_ckk = '1' and jong_no ='".$objResult16["iv_no"]."' and status_sol = 'Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);
	
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$objResult["product_ID"]."' and jong_ckk = '1' and jong_no ='".$objResult16["iv_no"]."' and status_so = 'Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_assoc($qry13);
	

$count_web3 =  $rs3["count3"]; 
$count_web13 =  $rs13["count3"]; 
	
$sum_web = ($objResult16["count"]-($count_web3+$count1_web3))+$sum_web;	
	
$sum_web++;
$i_web++;	
}

//ใบจองสัญญา
$count_jong_web1 =$sum_web-$i_web;
$jong_web1= number_format( $count_jong_web1,2)."";
	
	
	
$strSQL106 = "SELECT * FROM (hos__jongproduct LEFT JOIN hos__subjongpro ON hos__jongproduct.ref_id=hos__subjongpro.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and close_ckk = '0' and status_sub ='Approve' and type_jong='2'";
$objQuery106 = mysqli_query($conn,$strSQL106);

$sum_web1 = 0;	
$i_web1 = 0;	
	
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
	
$sum_web1 = ($objResult106["count"]-($count3+$count13))+$sum_web1;	
	
$sum_web1++;
$i_web1++;	
}
	
//ใบจอง FC
$count_jong_web2 =$sum_web1-$i_web1;
$jong_web2= number_format( $count_jong_web2,2)."";
		
	
	
	
	
	
/*------------------------------------*/	
	
	

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
	
	
	
	
$strSQLp1 = "SELECT SUM(count) AS count FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE have_order ='0' and have_product = '0' and product_id = '".$objResult["product_ID"]."' and status_doc ='Approve' and send_erpst='0' and ref_idst='' and clear_br ='0' and delivery_date <='".$date_1ms."'";
$objQueryp1 = mysqli_query($conn,$strSQLp1);
$objResultp1 = mysqli_fetch_array($objQueryp1);		
	
$strSQLp3 = "SELECT SUM(count) AS count FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE have_product = '2' and product_id = '".$objResult["product_ID"]."' and status_doc ='Approve' and send_erpst='0' and ref_idst='' and clear_br ='0' and delivery_date <='".$date_1ms."'";
$objQueryp3 = mysqli_query($conn,$strSQLp3);
$objResultp3 = mysqli_fetch_array($objQueryp3);			
	
$strSQLp2 = "SELECT SUM(sale_count) AS count FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and have_order ='0' and have_product = '0' and approve_complete ='Approve' and cancel_ckk='0' and send_erpst='0' and ref_idst='' and clear_br ='0' and delivery_date <='".$date_1ms."'";
	
$objQueryp2 = mysqli_query($conn,$strSQLp2);
$objResultp2 = mysqli_fetch_array($objQueryp2);	
	
	
$strSQLp4 = "SELECT SUM(sale_count) AS count FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and have_order ='1' and have_product = '2' and approve_complete ='Approve' and cancel_ckk='0' and send_erpst='0' and ref_idst='' and clear_br ='0' and delivery_date <='".$date_1ms."'";
	
$objQueryp4 = mysqli_query($conn,$strSQLp4);
$objResultp4 = mysqli_fetch_array($objQueryp4);	
	

$hot =$objResultp1['count'];
$hot1 =$objResultp3['count'];	
$sol =$objResultp2['count'];
$sol1 =$objResultp4['count'];

//รอส่ง
$wait_send = $hot1+$hot+$sol+$sol1;
$wait= number_format( $wait_send,2)."";		


$strSQL3 = "SELECT SUM(count_send) AS count_send ,SUM(count_receive) AS count_receive FROM st__sbmain WHERE product_id = '".$objResult["product_ID"]."' ";
$objQuery3 = mysqli_query($new,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);
	
$strSQL41 = "SELECT * FROM po__submain WHERE product_id = '".$objResult["product_ID"]."' and inter_check ='1' and int_ckk='1' and st_ckk ='0'";
$objQuery41 = mysqli_query($inter,$strSQL41) or die ("Error Query [".$strSQL41."]");
$Num_Rows41 = mysqli_num_rows($objQuery41);
$objResult41 = mysqli_fetch_array($objQuery41);

$strSQL43 = "SELECT SUM(count_about) As count_about FROM po__sumall  WHERE  product_id = '".$objResult41["product_id"]."' and close_pro='1'";
$objQuery43 = mysqli_query($inter,$strSQL43) or die ("Error Query [".$strSQL43."]");
$objResult43 = mysqli_fetch_array($objQuery43);	
	
$strSQL42 = "SELECT SUM(count_purchase) As count_purchase1 FROM po__purchase  WHERE product_id = '".$objResult41["product_id"]."' and po_no = '".$objResult41["po_no"]."'   ";
$objQuery42 = mysqli_query($inter,$strSQL42) or die ("Error Query [".$strSQL42."]");
$objResult42 = mysqli_fetch_array($objQuery42);

// $strSQL44 = "SELECT * FROM tb_spare WHERE product_id = '".$objResult["product_code"]."'  ";
// $objQuery44 = mysqli_query($inter,$strSQL44);
// $objResult44 = mysqli_fetch_array($objQuery44);	

$strSQL45 = "SELECT DISTINCT sp_no,product_code,count FROM tb_spare_in WHERE product_code = '".$objResult["product_ID"]."' and stock_name =''  ";
$objQuery45 = mysqli_query($inter,$strSQL45);
$objResult45 = mysqli_fetch_array($objQuery45);	


$count_send = $objResult3["count_send"];
$count_receive = $objResult3["count_receive"];
//คงเหลือ
$count_pro =$count_receive-$count_send;
$count_pro1= number_format($count_pro,2)."";

//มีปัญหา
$strSQL13 = "SELECT SUM(count) AS count FROM tb_product_proprem WHERE product_id = '".$objResult["product_ID"]."' and pass='0'";
$objQuery13 = mysqli_query($new,$strSQL13);
$objResult13 = mysqli_fetch_array($objQuery13);		

if($objResult13["count"]!=''){	
$pro_proprem =$objResult13["count"];
}else{
$pro_proprem ='0.00';	
}
	
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
	
	
	
//สั่งซื้อ
$buy_pro = $count_pro-($outtime+$gradb+$pro_proprem+$jong1+$jong2+$sale+$objResult["reorder_point"]);
$buy_pro1= number_format( $buy_pro,2)."";

//พร้อมขาย พี่โจ้
$buy_sale = $count_pro-($outtime+$gradb+$pro_proprem+$count_jong1+$count_jong2+$count_sale+$wait_send);
$buy_sale1= number_format( $buy_sale,2)."";

//พร้อมขาย ทั้งหมด	
$buy_sale_new = $count_pro-($outtime+$gradb+$pro_proprem+$count_jong1+$count_jong2+$count_sale_new+$wait_send);
$buy_sale_new1= number_format( $buy_sale_new,2)."";
	

	
?>
<tr>

<td  align="left" class="style30"><div align="left"><?php echo $objResult["access_code"]; ?></div></td>
<td  align="left" class="style30"><div align="left"><?php echo $objResult["sol_name"]; ?></div></td>
<td  align="center" class="style30"><?php echo $objResult["unit_name"]; ?></td> 
	
<td align="center" class="style30"><b><a href="https://stock.allwellcenter.com/status_lotno.php?product_id=<?php echo $objResult["product_ID"]; ?>" target="_blank"><?php echo $count_pro1; ?></a></b></td> 	
	
<td align="center" class="style30"><font color="#006600"><b><?php echo $count_lot; ?></b></font></td> 
	
<?php if($_SESSION['name']=='สมบัติ' or $_SESSION['name']=='อัจฉรา'){	?>
	
<?php
	
$strSQLpo = "SELECT DISTINCT po_no FROM po__submain WHERE product_id = '".$objResult["product_ID"]."' and inter_check ='1' and int_ckk='1' and st_ckk ='0'";
$objQuerypo = mysqli_query($inter,$strSQLpo) or die ("Error Query [".$strSQLpo."]");
$objResultpo = mysqli_fetch_array($objQuerypo);


$strSQL_daypo = "SELECT po_no,in7 FROM po__in WHERE po_no = '".$objResultpo["po_no"]."' ORDER BY time_number DESC  ";
$objQuery_daypo = mysqli_query($inter,$strSQL_daypo);
$objResult_daypo = mysqli_fetch_array($objQuery_daypo);
	
	if($objResult_daypo["in7"]!='0000-00-00' and $objResultpo["po_no"]!=''){
		$date_late = DateDiff($date_today,$objResult_daypo["in7"]);	
		$co_order = ($send_1m/30)*$date_late;
		if($co_order > $buy_sale1){
		?>
		<td   align="center" class="style41">
		<?php }else{ ?>
		<td   align="center" class="style40">	
		<?php
		}
		}else{ ?><td   align="center" class="style40"> <?php } ?>
	<?php  echo $buy_sale1; ?>
		
		</td> 	
<?php } ?>	
<?php
	
$strSQLpo = "SELECT DISTINCT po_no FROM po__submain WHERE product_id = '".$objResult["product_ID"]."' and inter_check ='1' and int_ckk='1' and st_ckk ='0'";
$objQuerypo = mysqli_query($inter,$strSQLpo) or die ("Error Query [".$strSQLpo."]");
$objResultpo = mysqli_fetch_array($objQuerypo);


$strSQL_daypo = "SELECT po_no,in7 FROM po__in WHERE po_no = '".$objResultpo["po_no"]."' ORDER BY time_number DESC  ";
$objQuery_daypo = mysqli_query($inter,$strSQL_daypo);
$objResult_daypo = mysqli_fetch_array($objQuery_daypo);
	
	if($objResult_daypo["in7"]!='0000-00-00' and $objResultpo["po_no"]!=''){
		$date_late = DateDiff($date_today,$objResult_daypo["in7"]);	
		$co_order = ($send_1m/30)*$date_late;
		if($co_order > $buy_sale1){
		?>
		<td   align="center" class="style41">
		<?php }else{ ?>
		<td   align="center" class="style40">	
		<?php
		}
		}else{ ?><td   align="center" class="style40"> <?php } ?>
	<?php  echo $buy_sale_new1; ?>
		
		</td> 

<td   align="center" class="style30"><a href="https://stock.allwellcenter.com/status_outtime.php?product_id=<?php echo $objResult["product_ID"]; ?>" target="_blank"><?php echo $outtime; ?></a></td> 
<td   align="center" class="style30"><a href="https://stock.allwellcenter.com/status_proprem.php?product_id=<?php echo $objResult["product_ID"]; ?>" target="_blank"><?php echo $pro_proprem; ?></a>	</td> 
<td   align="center" class="style30"><a href="https://stock.allwellcenter.com/status_gradb.php?product_id=<?php echo $objResult["product_ID"]; ?>" target="_blank"><?php echo $gradb; ?></a></td> 		
	
<td  align="center" class="style30">
<a href="https://stock.allwellcenter.com/status_jongreport.php?product_id=<?php echo $objResult["product_ID"]; ?>&type_jong=<?php echo "1"; ?>" target="_blank"><?php echo $jong_web1;  ?></a>		
</td> 
	
<td  align="center" class="style30">
<a href="https://stock.allwellcenter.com/status_jongreport.php?product_id=<?php echo $objResult["product_ID"]; ?>&type_jong=<?php echo "2"; ?>" target="_blank"><?php echo $jong_web2;  ?></a>		
</td> 
	
<td  align="center" class="style30"><a href="https://stock.allwellcenter.com/status_orderport.php?product_id=<?php echo $objResult["product_ID"]; ?>" target="_blank"><?php echo $sale;  ?></a>
</td> 
	
<td  align="center" class="style30">		
	<?php if($_GET["sale"]=='Sale' or $_GET["sale"]=='AllWell'){ ?>
<?php echo $sale;  ?>
	<?php }else{ ?>
<a href="https://stock.allwellcenter.com/status_waitsend.php?product_id=<?php echo $objResult["product_ID"]; ?>" target="_blank"><?php echo $wait;  ?></a>	
	<?php } ?>
</td> 	
	
<?php


/*$sum_count = 0;
$strSQL241 = "SELECT DISTINCT po_no,product_id FROM po__submain WHERE product_id = '".$objResult["product_ID"]."' and inter_check ='1' and int_ckk='1' and st_ckk ='0'";
$objQuery241 = mysqli_query($inter,$strSQL241) or die ("Error Query [".$strSQL241."]");
$Num_Rows241 = mysqli_num_rows($objQuery241);
while($objResult241 = mysqli_fetch_array($objQuery241)){
	
$strSQL233 = "SELECT * FROM po__purchase WHERE po_no = '".$objResult241["po_no"]."' and   product_id = '".$objResult["product_ID"]."'";
$objQuery233 = mysqli_query($inter,$strSQL233);
$objResult233 = mysqli_fetch_array($objQuery233);
//echo $objResult233['count_purchase'].'<br>'; 


$sum_count += $objResult233['count_purchase'];

}*/
	
$strSQL233 = "SELECT SUM(count_purchase) AS count_purchase FROM po__purchase WHERE  product_id = '".$objResult["product_ID"]."'";
$objQuery233 = mysqli_query($inter,$strSQL233);
$objResult233 = mysqli_fetch_array($objQuery233);	
	
$sum_count	= $objResult233['count_purchase'];
//echo $objResult43["count_about"];

if($objResult["order_count"] !=''){
	$temp_sum = ($objResult["order_count"]+$sum_count)-$objResult43["count_about"];	
}else{
	// $temp_sum = ($sum_count-$objResult43["count_about"])+$objResult45['count'];
	$temp_sum = $objResult233['count_purchase']-($objResult43["count_about"]+$objResult45['count']);
}
	$temp_sum1 =$count_pro7+$temp_sum;
	$sum_new = $lead_time*($send_1m/30);


//$sum_derm = $count_pro7+$temp_sum;	

	if($objResult["order_count"] !=''){
	$temp_sum = ($objResult["order_count"]+$sum_count)-$objResult43["count_about"];	
}else{
	$temp_sum = ($sum_count-$objResult43["count_about"])+$objResult45['count'];
}
	$temp_sum1 =$count_pro7+$temp_sum; ///ยอดคงเหลือ+ยอดสั่งซื้อ ก่อน 15/01/2568
	$sum_new = $lead_time*($send_1m/30); //จำนวน leadtime*ยอดขายต่อเดือน/30 ก่อน 15/01/2568
	if($objResult["ordered"]=='1'){	
	$reofk = $dass->days*($send_1m/30);
	}else{
	$reofk = '';	
	}

	if($temp_sum1 < $sum_new){  ?>
	<td  align="center" bgcolor="#FF3030" class="style30">
	<?php }else if($reofk!='' and $count_pro7 < $reofk){ ?>
	<td  align="center" bgcolor="#FF6600" class="style30">
	<?php }else if($temp_sum1 >= $sum_new){ ?>
	<td  align="center" bgcolor="#00FF00" class="style30">
		<?php } ?>
<?php if($_GET["sale"]=='Sale' or $_GET["sale"]=='AllWell' or $_GET["sale"]=='SupSale'){ 	
 echo $send_cm;   }else{ ?>
	<a href="https://stock.allwellcenter.com/status_movepro.php?product_id=<?php echo $objResult["product_ID"]; ?>&date_bk=<?php echo $date_bk; ?>" target="_blank"><?php echo $send_cm;  ?></a>	
<?php } ?>
	
	</td>	
<?php /*<td  align="center" class="style38"><?php echo $buy_pro1;  ?></td>
<td  align="center" class="style39"><?php echo $objResult["reorder_point"]; ?></td> */ ?>
	
	

<td  align="center" class="style38">
<a href="https://stock.allwellcenter.com/status_montorder.php?product_id=<?php echo $objResult["product_ID"]; ?>&code_type=<?php echo $objResult["code_type"]; ?>&date_1m=<?php echo $date_1m; ?>&date_today=<?php echo $date_today; ?>&name=<?php echo $_SESSION['name']; ?>" target="_blank"><?php echo $send_1m;  ?></a>	
</td>		
<td  align="center" class="style38"><?php if($send_3m/3 !='0'){ echo number_format($send_3m/3,2).""; } ?></td>	

	
<td   align="center" class="style30"><?php 
if($objResult["ordered"]=='1'){	
echo "<input type='checkbox' checked='checked' >"; }else{  echo "<input type='checkbox'>";   } 
?>

</td> 
	
<td  align="left" class="style37" style="padding:0px;">
<div align="ltdeft">
<?php echo $objResult["order_no"];?><br>
<?php echo $objResult45['sp_no'];


 // เลขที่ใบสั่งซื้อ
 $sum_count_all= 0;	
 $strSQL241 = "SELECT DISTINCT po_no,product_id FROM po__submain WHERE product_id = '".$objResult["product_ID"]."' and int_ckk='1' and st_ckk ='0' ";
 $objQuery241 = mysqli_query($inter,$strSQL241) or die ("Error Query [".$strSQL241."]");
 $Num_Rows241 = mysqli_num_rows($objQuery241);
 while($objResult241 = mysqli_fetch_array($objQuery241)){
 
 $strSQL_ex = "SELECT po_no FROM po__main WHERE po_success != '1' AND po_no = '".$objResult241["po_no"]."' ";
 $objQuery_ex = mysqli_query($inter,$strSQL_ex);
 $NobjQuery_ex = mysqli_num_rows($objQuery_ex);
 $objResult_ex = mysqli_fetch_array($objQuery_ex);
 
	if($NobjQuery_ex > 0){

		$strSQL_day = "SELECT po_no,in7,in15,in5 FROM po__in WHERE po_no = '".$objResult241["po_no"]."' ORDER BY time_number DESC  ";
		$objQuery_day = mysqli_query($inter,$strSQL_day);
		$objResult_day = mysqli_fetch_array($objQuery_day);
				
		$strSQL23 = "SELECT * FROM po__purchase WHERE po_no = '".$objResult241["po_no"]."' and   product_id = '".$objResult["product_ID"]."'";
		$objQuery23 = mysqli_query($inter,$strSQL23);
		$objResult23 = mysqli_fetch_array($objQuery23);
		
		$strSQL25 = "SELECT * FROM po__sumall WHERE po_no = '".$objResult241["po_no"]."' and   product_id = '".$objResult["product_ID"]."'";
		$objQuery25 = mysqli_query($inter,$strSQL25);
		$objQuery25n = mysqli_num_rows($objQuery25);
		$objResult25 = mysqli_fetch_array($objQuery25);
		
		$remaining25 = $objResult23['count_purchase'] - $objResult25['count_about'];

			if($remaining25 > 0){

				$setTypePlant[] = [
					"po_no" => $objResult241["po_no"],
					"date" => $objResult_day["in7"],
					"date_tran" => $objResult_day["in5"],
					"ckk_in5" => $objResult_day["in15"],
					"count" => $remaining25,
					"unit_name" => $objResult["unit_name"],
					"product_ID" => $objResult["product_ID"]
				];

				$sum_count_all += $remaining25;		
			
			} 
	} // NobjQuery_ex
} // while
?>

<?php
$json_data = json_encode($setTypePlant);// แปลง JSON เป็น PHP array
$data = json_decode($json_data, true);
if ($data) { // ตรวจสอบว่ามีข้อมูลหรือไม่
	// เรียงลำดับข้อมูลตามวันที่
    usort($data, function($a, $b) {
        return strtotime($a['date']) - strtotime($b['date']);
    });
    // วนลูปแสดงข้อมูล
    foreach ($data as $item) {
if($item['product_ID'] == $objResult["product_ID"]){
			if($item['date'] !='0000-00-00' and $item['date'] !='' and $item['ckk_in5']=='1'){ 
				echo "<div style='margin:5px; text-align:center; color:#00BF00;'>[" .htmlspecialchars($item['po_no']).' '.htmlspecialchars(Datethai($item['date'])).' ('.htmlspecialchars($item['count']). htmlspecialchars($item['unit_name']).")]</div>";
				
			}else if($item['date'] !='0000-00-00' and $item['date'] !='' and $item['ckk_in5']=='2'){ 
				echo "<div style='margin:5px; text-align:center; color:#FF0000;'>[" .htmlspecialchars($item['po_no']).' '.htmlspecialchars(Datethai($item['date'])).' ('.htmlspecialchars($item['count']). htmlspecialchars($item['unit_name']).")]</div>";	
				
			}else if($item['date'] !='0000-00-00' and $item['date'] !='' and $item['ckk_in5']=='3'){ 
				echo "<div style='margin:5px; text-align:center; color:#0099FF;'>[" .htmlspecialchars($item['po_no']).' '.htmlspecialchars(Datethai($item['date'])).' ('.htmlspecialchars($item['count']). htmlspecialchars($item['unit_name']).")]</div>";	
			} else {
			if($item['date_tran']!='0000-00-00' and $item['date_tran'] !=''){	
				echo "<div style='margin:5px; text-align:center; color:#0099FF;'>[" .htmlspecialchars($item['po_no']).' ('.htmlspecialchars($item['count']). htmlspecialchars($item['unit_name']).")]</div>";
				
			}else{
			echo "<div style='margin:5px; text-align:center; color:#696969;'>[" .htmlspecialchars($item['po_no']).' ('.htmlspecialchars($item['count']). htmlspecialchars($item['unit_name']).")]</div>";	
			}
			}
		}
    }
} else {
    // echo "ไม่สามารถแสดงข้อมูลได้";
}
?>

</div>
</td> 
	
<td align="left" class="style30"><div align="left">
<?php 
if($sum_count_all  !='0'){ 
echo $sum_count_all; 
} ?>
</div>
</td> 

</tr>

<?php
}
?>

</table>



<br>

</div>
</body>
</html>