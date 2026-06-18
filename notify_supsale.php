<?php 

$emid = $_SESSION['code'];
$user_type = $_SESSION['user_type'];
$start_date = date('Y-m-d');
$date_1ms = date("Y-m-d",strtotime("+30 days"));


if($emid=='SS1'){
$sddd = "AND sale_code IN ('S15','S16','S21','S22')";	
	
}else if($emid=='SS2'){
$sddd = "AND sale_code IN ('S11','S12','S17','S24')";		
	
}else if($emid=='SS3'){
$sddd = "AND sale_code IN ('S31','S32','MM1','SM1','S33')";		
}else if($emid=='SS5'){
$sddd = "AND sale_code IN ('S31','S32')";	
	
}else if($emid=='SUP_MK'){
$sddd = " and sale_code IN ('SOL91','SOL92','SOL93','SOL94','MK') ";	
}else if($emid=='SM1'){
$sddd = "and sale_code IN ('SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL0','SOL99')";	
}else if($emid=='SUP_EN'){
$sddd = "and sale_code LIKE '%EN%'";	
}else if($user_type=='Engineer'){
$sddd = "and sale_code LIKE '%EN%'";	
}else{
$sddd = $_SESSION['code'];	
}	


if($_SESSION["name"]=='บรรเทิง'){
$code	=" department_id REGEXP 'EN|ST|CS'";
}else if($_SESSION["name"]=='ปิยะ'){ 
$code	=" department_id REGEXP 'OF|ST'";
}else if($_SESSION["name"]=='สุอาภา'){ 
$code	=" department_id LIKE '%IB%'";	
}else if($_SESSION["name"]=='รุจิรา'){ 
$code	="department_id LIKE '%MK2%'";
$emm = "MK";	
$division = 'MK';	
}else if($_SESSION["name"]=='ทิพย์ภาพัน'){ 	
$code	="department_id LIKE '%MK1%'";
$emm = "PM";	
$division = 'MK';	
}else if($_SESSION["name"]=='ลักษณาวรรณ'){ 
$code	=" department_id LIKE '%SO%'";
$emm = "SS3";	
$division = 'SO';	
}else if($_SESSION["name"]=='มาลินี'){ 
$code	="department_id LIKE '%SA3%'";
$emm = "SS3";
$division = 'SA';		
}else if($_SESSION["name"]=='นรินทิพย์'){ 
$code	="department_id LIKE '%SA2%'";	
$emm = "SS2";	
$division = 'SA';		
}else if($_SESSION["name"]=='พรรณิภา'){ 
$code	="department_id LIKE '%SA1%'";
$emm = "SS1";	
$division = 'SA';		
}

//$code	="and type_doc !='1' and type_doc !='4' and type_doc !='5' and type_doc !='6' and type_doc !='7'";	

?>	
	
<div class="w3-row" style="display: flex; gap: 10px;">	
<?php	
//ใบสั่งขาย	
$strSQL = "SELECT ref_id  FROM hos__so  where status_doc ='Request' and send_sup ='1' and send_cm ='0' $sddd";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rowsf = mysqli_num_rows($objQuery);

$strSQL = "SELECT ref_id  FROM hos__so  where status_doc ='Request' and send_sup ='1' and send_cm ='0' and ic_ckk='0' and que_ckk='1' $sddd";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rowsfd = mysqli_num_rows($objQuery);	
	
if($_SESSION["name"]=='ทิพย์ภาพัน'){ 	
	
$strSQLsb = "SELECT DISTINCT hos__so.ref_id 
    FROM hos__so 
    LEFT JOIN hos__subso ON hos__subso.ref_idd = hos__so.ref_id 
    LEFT JOIN tb_product ON tb_product.product_id = hos__subso.product_id 
    WHERE hos__so.status_doc = 'Approve' 
      AND group1 = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL' 
      AND sol_name LIKE '%GLUCOALL-PRO%' and hos__subso.sn !='' and iv_no NOT LIKE '%IC%' and sm_care='0'";

$objQuerysb = mysqli_query($conn,$strSQLsb) or die ("Error Query [".$strSQLsb."]");
$Num_Rowssb = mysqli_num_rows($objQuerysb);


$strSQLmr = "SELECT DISTINCT hos__br.ref_id_br 
    FROM hos__br 
    LEFT JOIN hos__subbr ON hos__subbr.ref_idd_br = hos__br.ref_id_br 
    LEFT JOIN tb_product ON tb_product.product_id = hos__subbr.product_id 
    WHERE hos__br.status_doc = 'Approve' 
      AND group1 = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL' 
      AND sol_name LIKE '%GLUCOALL-PRO%' and hos__subbr.sn !='' and sm_care='0'";

$objQuerymr = mysqli_query($conn,$strSQLmr) or die ("Error Query [".$strSQLmr."]");
$Num_Rowsmr = mysqli_num_rows($objQuerymr);	
	
}
	
	

//ใบยืม	
$strSQL1 = "SELECT *  FROM hos__br  where  status_doc ='Request' and send_sup ='1' $sddd";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rowsf1 = mysqli_num_rows($objQuery1);
	
$strSQL1 = "SELECT *  FROM hos__br  where  status_doc ='Request' and send_sup ='1'  and que_ckk='1' $sddd";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rowsf1d = mysqli_num_rows($objQuery1);

	
//ลดหนี้	
$strSQLfc = "SELECT *  FROM tb_credit_note  where status_doc = 'Request' and send_sup = '1' and send_dm = '0' $sddd";
//echo $strSQLfc;
	
$objQueryfc = mysqli_query($conn,$strSQLfc) or die ("Error Query [".$strSQLfc."]");
$Num_Rowsfc = mysqli_num_rows($objQueryfc);

//smp	
$strSQLsm = "SELECT *  FROM hos__smp  where send_dm = '0' and send_stock = '0' and  send_admin = '0' and send_sup = '1' and status_sup = 'Request' $sddd";
$objQuerysm = mysqli_query($conn,$strSQLsm) or die ("Error Query [".$strSQLsm."]");
$Num_Rowssm = mysqli_num_rows($objQuerysm);
	
//jong	
$strSQLjn = "SELECT *  FROM hos__jongproduct  where send_sup = '1' and status_doc = 'Request' $sddd";
$objQueryjn = mysqli_query($conn,$strSQLjn) or die ("Error Query [".$strSQLjn."]");
$Num_Rowsjn = mysqli_num_rows($objQueryjn);
	
//change	
$strSQLch = "SELECT *  FROM hos__change  where status_doc ='Request' and send_sup ='1' and  adm_ckk='0' $sddd";
$objQuerych = mysqli_query($conn,$strSQLch) or die ("Error Query [".$strSQLch."]");
$Num_Rowsch = mysqli_num_rows($objQuerych);
	
//รายการรับเรื่อง	
$strSQLeng = "SELECT *  FROM tb_register_story  where summary_sale = '0'  $sddd";
$objQueryeng = mysqli_query($conn,$strSQLeng) or die ("Error Query [".$strSQLeng."]");
$Num_Rowseng = mysqli_num_rows($objQueryeng);	
	
//รายการ PO	
$strSQLengp = "SELECT *  FROM hos__po  where  send_sale = '1' and open_so = '0' $sddd";
$objQueryengp = mysqli_query($conn,$strSQLengp) or die ("Error Query [".$strSQLengp."]");
$Num_Rowsengp = mysqli_num_rows($objQueryengp);	
	
//แบบสอบถามสินค้าสาธิต	
$strSQLdm = "SELECT *  FROM hos__br  where research_demo ='1' and status_doc ='Approve' $sddd";
$objQuerydm = mysqli_query($conn,$strSQLdm) or die ("Error Query [".$strSQLdm."]");
$Num_Rowsdm = mysqli_num_rows($objQuerydm);

//ใบยืมฝากขาย	
$strSQLcos = "SELECT *  FROM hos__consig  where send_sup = '1' and send_cm='0' and status_doc = 'Request' $sddd";
$objQuerycos = mysqli_query($conn,$strSQLcos) or die ("Error Query [".$strSQLcos."]");
$Num_Rowscos = mysqli_num_rows($objQuerycos);

$strSQLcos1 = "SELECT *  FROM hos__consig  where send_sup = '1' and send_cm='0' and status_doc = 'Request' and que_ckk ='1' $sddd";
$objQuerycos1 = mysqli_query($conn,$strSQLcos1) or die ("Error Query [".$strSQLcos1."]");
$Num_Rowscos1 = mysqli_num_rows($objQuerycos1);
	
//แบบสอบถามหลังการขาย AND DATEDIFF(CURDATE(), iv_date) >= 30 	
$strSQLrs = "SELECT *  FROM hos__so  where status_doc ='Approve' and close_reseach ='0' and reseach_kk='1' and status_doc = 'Approve' and iv_date !='0000-00-00' and sale_code!='S31' and sale_code!='S32' and sale_code!='MM1' and sale_code!='SM1'$sddd";
$objQueryrs = mysqli_query($conn,$strSQLrs) or die ("Error Query [".$strSQLrs."]");
$Num_Rowsrs = mysqli_num_rows($objQueryrs);
	
//ใบสั่งเช่า
$strSQLren = "SELECT *  FROM hos__rental where status_doc ='Request' and send_sup ='1' $sddd";
$objQueryren = mysqli_query($conn,$strSQLren) or die ("Error Query [".$strSQLren."]");
$Num_Rowsren = mysqli_num_rows($objQueryren);

	
if($_SESSION['name']=='รุจิรา'){	
	
//	ใบสั่งขาย/ใบยืม
$strSQL7 = "SELECT * FROM so__main where approve_complete ='Request' and cancel_ckk ='0' and employee_name IN ('SOL91','SOL92','SOL93','SOL94','MK') order by main_id DESC ";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);	

}else if($_SESSION['name']=='ลักษณาวรรณ'){	
	
$strSQL7 = "SELECT *  FROM so__main  where approve_complete ='Request' and cancel_ckk='0'";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);
	
$strSQL17 = "SELECT *  FROM qou__main  where send_sup='1' and status_doc ='Request'";
$objQuery17 = mysqli_query($conn,$strSQL17) or die ("Error Query [".$strSQL17."]");
$Num_Rows17 = mysqli_num_rows($objQuery17);
	
}
	
if($_SESSION['name']=='รุจิรา'){	
	
	
//ออเดอร์สินค้าราคาต่ำกว่ากำหนด	
$strSQLn6 = "SELECT ref_id FROM so__main  where price_ckk='1' and approve_complete='Request' and cancel_ckk='0'";
$objQueryn6 = mysqli_query($conn,$strSQLn6) or die ("Error Query [".$strSQLn6."]");
$Num_Rowsn6 = mysqli_num_rows($objQueryn6);
	
	
	
//สินค้ายอดนิยมออนไลน์คงเหลือต่ำกว่ากำหนด	
$strSQL = "SELECT access_code, sol_name, unit_name,product_ID,ecom_count FROM tb_product WHERE  close_pro = '0' AND close_out = '0' and ecom_ckk='1'";
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


    if ($count_pro7 < $objResult["ecom_count"]) {
        $j++; // เพิ่มค่าของ $j
    }
}
	

//สินค้ายอดนิยมออนไลน์พร้อมขาย
$strSQL = "SELECT access_code, sol_name, unit_name, product_ID FROM tb_product WHERE  close_pro = '0'  and close_out='1' and  close_in='1' and ecom_ckk='1'";
$strSQL .= " ORDER BY number ASC";
$objQuery = mysqli_query($new, $strSQL) or die("Error Query [" . $strSQL . "]");
$Num_Rows = mysqli_num_rows($objQuery);

$p = 0; 
while ($objResult = mysqli_fetch_array($objQuery)) {
  $p++;
    }
	
}	
	
	
	
//เอกสารส่งกลับแก้ไข
/*$strSQLedso = "SELECT DISTINCT hos__so.ref_id FROM  (hos__so LEFT JOIN tb_editdoc ON hos__so.ref_id=tb_editdoc.ref_id) WHERE  status_doc ='Request' and tb_editdoc.sale_edit !='' $sddd";
$objQueryedso = mysqli_query($conn,$strSQLedso) or die ("Error Query [".$strSQLedso."]");
$Num_Rowsedso = mysqli_num_rows($objQueryedso);
	
$strSQLedbr = "SELECT DISTINCT hos__br.ref_id_br FROM  (hos__br LEFT JOIN tb_editdoc ON hos__br.ref_id_br=tb_editdoc.ref_id) WHERE status_doc ='Request' and tb_editdoc.sale_edit !='' $sddd";
$objQueryedbr = mysqli_query($conn,$strSQLedbr) or die ("Error Query [".$strSQLedbr."]");
$Num_Rowsedbr = mysqli_num_rows($objQueryedbr);
	
$strSQLedsm = "SELECT DISTINCT hos__smp.ref_idsmp FROM  (hos__smp LEFT JOIN tb_editdoc ON hos__smp.ref_idsmp=tb_editdoc.ref_id) WHERE  status_sup ='Request' and tb_editdoc.sale_edit !='' $sddd";
$objQueryedsm = mysqli_query($conn,$strSQLedsm) or die ("Error Query [".$strSQLedsm."]");
$Num_Rowsedsm = mysqli_num_rows($objQueryedsm);

$strSQLedch = "SELECT DISTINCT hos__change.ref_id FROM  (hos__change LEFT JOIN tb_editdoc ON hos__change.ref_id=tb_editdoc.ref_id) WHERE  status_doc ='Request' and tb_editdoc.sale_edit !='' $sddd";
$objQueryedch = mysqli_query($conn,$strSQLedch) or die ("Error Query [".$strSQLedch."]");
$Num_Rowsedch = mysqli_num_rows($objQueryedch);
	
$strSQLedsc = "SELECT DISTINCT hos__consig.ref_id FROM  (hos__consig LEFT JOIN tb_editdoc ON hos__consig.ref_id=tb_editdoc.ref_id) WHERE  status_doc ='Request' and tb_editdoc.sale_edit !='' $sddd";
$objQueryedsc = mysqli_query($conn,$strSQLedsc) or die ("Error Query [".$strSQLedsc."]");
$Num_Rowsedsc = mysqli_num_rows($objQueryedsc);
	
$strSQLedsp = "SELECT DISTINCT hos__spr.ref_id FROM  (hos__spr LEFT JOIN tb_editdoc ON hos__spr.ref_id=tb_editdoc.ref_id) WHERE  status_doc ='Request' and tb_editdoc.sale_edit !='' $sddd";
$objQueryedsp = mysqli_query($conn,$strSQLedsp) or die ("Error Query [".$strSQLedsp."]");
$Num_Rowsedsp = mysqli_num_rows($objQueryedsp);
*/
	
	
function qualifySaleCode($sddd, $tableName) {
    $sddd = (string)($sddd ?? '');
    $tableName = (string)($tableName ?? '');

    if ($sddd === '' || $tableName === '') {
        return '';
    }

    // ตัวอย่าง: " AND sale_code NOT LIKE '%EN%'" -> " AND hos__so.sale_code NOT LIKE '%EN%'"
    return preg_replace('/(?<!\.)\bsale_code\b/', $tableName . '.sale_code', $sddd);
}
// ===== ฟังก์ชันนับ (JOIN tb_editdoc) =====
// หมายเหตุ: ฟังก์ชันนี้ "ไม่ใช้ alias" กับตาราง เพื่อให้สอดคล้องกับ sddd ที่ชี้บ่งด้วยชื่อเต็ม เช่น hos__so.sale_code
function countRequestsWithQualifiedSddd(
  mysqli $conn,
  string $table,     // ชื่อตารางเอกสาร เช่น hos__so
  string $refCol,    // คอลัมน์ ref เช่น ref_id
  string $statusCol, // status_doc หรือ status_sup
  string $statusVal, // 'Request'
  string $sdddQualified // sddd ที่ผ่าน qualifySaleCode() มาแล้ว
): int {
  $sql = "
    SELECT COUNT(DISTINCT {$table}.{$refCol}) AS cnt
    FROM {$table}
    INNER JOIN tb_editdoc e
      ON e.ref_id = {$table}.{$refCol}
    WHERE 1=1
      {$sdddQualified}
      AND {$table}.{$statusCol} = ?
      AND e.sale_edit IS NOT NULL
      AND e.sale_edit <> ''
  ";
  $stmt = $conn->prepare($sql);
  if (!$stmt) { die('Prepare failed: '.$conn->error); }
  $stmt->bind_param('s', $statusVal);
  $stmt->execute();
  $res = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  return (int)($res['cnt'] ?? 0);
}

// ====== ตัวอย่างการกำหนด $sddd ตามที่คุณมีอยู่ ======
if ($emid=='SS1'){
	
$sddd1 = " AND sale_code IN ('S15','S16','S21','S22')";
	
$sddd2 = " and employee_name IN ('S15','S16','S21','S22')";
	
} else if ($emid=='SS2'){
	
$sddd1 = " AND sale_code IN ('S11','S12','S17','S24')";	
	
$sddd2 = " and employee_name IN ('S11','S12','S17','S24')";	
	
	
} else if ($emid=='SS3'){
	
$sddd1 = "AND sale_code IN ('S31','S32','MM1','SM1','S33','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL0','SOL99')";
	
$sddd2 = " and employee_name  IN ('S31','S32','MM1','SM1','S33','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL0','SOL99')";
	
} else if ($emid=='SUP_MK'){
	
  $sddd1 = "  and sale_code IN ('SOL91','SOL92','SOL93','SOL94','MK') ";	
  $sddd2 = " and employee_name IN ('SOL91','SOL92','SOL93','SOL94','MK')";	
	
} else if ($emid=='SM1'){
	
 $sddd1 = "AND sale_code IN ('S31','S32','MM1','SM1','S33','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL0','SOL99')";
	
$sddd2 = " and employee_name  IN ('S31','S32','MM1','SM1','S33','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL0','SOL99')";
	
} else if ($emid=='SUP_EN'){
	
  $sddd1 = " and sale_code LIKE '%EN%'";	
  $sddd2 = " and employee_name LIKE '%EN%'";	
	
} else if ($user_type=='Engineer'){
	
  $sddd1 = " and sale_code LIKE '%EN%'";	
  $sddd2 = " and employee_name LIKE '%EN%'";	
	
} /*else {
  $sddd1 = $_SESSION['code'] ?? '';	
}*/

// ====== ทำ sddd รายตาราง โดยชี้บ่งชื่อเต็ม ======
$sddd_so     = qualifySaleCode($sddd1, 'hos__so');
$sddd_br     = qualifySaleCode($sddd1, 'hos__br');
$sddd_smp    = qualifySaleCode($sddd1, 'hos__smp');
$sddd_change = qualifySaleCode($sddd1, 'hos__change');
$sddd_consig = qualifySaleCode($sddd1, 'hos__consig');
$sddd_spr    = qualifySaleCode($sddd1, 'hos__spr');
$sddd_som    = qualifySaleCode($sddd2, 'so__main');
	

// ====== เรียกนับรายตาราง โดยใช้ sddd ที่ชี้บ่งแล้ว ======
$Num_Rowsedso = countRequestsWithQualifiedSddd($conn, 'hos__so',     'ref_id',    'status_doc', 'Request', $sddd_so);
$Num_Rowsedbr = countRequestsWithQualifiedSddd($conn, 'hos__br',     'ref_id_br', 'status_doc', 'Request', $sddd_br);
$Num_Rowsedsm = countRequestsWithQualifiedSddd($conn, 'hos__smp',    'ref_idsmp', 'status_sup', 'Request', $sddd_smp);
$Num_Rowsedch = countRequestsWithQualifiedSddd($conn, 'hos__change', 'ref_id',    'status_doc', 'Request', $sddd_change);
$Num_Rowsedsc = countRequestsWithQualifiedSddd($conn, 'hos__consig', 'ref_id',    'status_doc', 'Request', $sddd_consig);
$Num_Rowsedsp = countRequestsWithQualifiedSddd($conn, 'hos__spr',    'ref_id',    'status_doc', 'Request', $sddd_spr);
$Num_Rowsedsom = countRequestsWithQualifiedSddd($conn, 'so__main',     'ref_id',    'approve_complete', 'Request', $sddd_som);
	
// ====== แสดงปุ่มรวม ถ้ามากกว่า 0 ======
$totalEdits = $Num_Rowsedso + $Num_Rowsedbr + $Num_Rowsedsm + $Num_Rowsedch + $Num_Rowsedsc + $Num_Rowsedsp + $Num_Rowsedsom;	
	
	
	
if(($Num_Rowsf+$Num_Rowsf1+$Num_Rowsfc+$Num_Rowssm+$Num_Rowsjn+$Num_Rowsch+$Num_Rowssp1+$Num_Rowseng+$Num_Rowsengp+$Num_Rowsdm+$Num_Rowscos+$Num_Rowsrs+$p+$j+$Num_Rows7+$Num_Rows17+$Num_Rowssb+$Num_Rowsmr+$totalEdits) > 0){
	
?>	
<div class="w3-third" style="flex: 1; background-color: #f0f0f0;">	
<div class="w3-container"><font color ='blue'><b> ERP SALE</b></font></div>	
	
	
<?php if(($totalEdits) > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_editwailsale.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>มีเอกสารส่งกลับรอแก้ไข</b></span>
        <span style="text-align: right;"><b><?php echo ($totalEdits); ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	
	
	
	
	
<?php if($_SESSION["name"]=='รุจิรา'){ 
		if($Num_Rowsn6 > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_adminprice.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>อนุมัติออเดอร์สินค้าราคาต่ำกว่ากำหนด</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsn6; ?> รายการ </b></span>
    </a>
</div></p>
<?php }
	}
	?>		
		
 		
<?php if($_SESSION["name"]=='ทิพย์ภาพัน'){ 
		if($Num_Rowssb+$Num_Rowsmr > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_glucosemkhos.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>รายงานรอส่ง SN Gluco All-Pro</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowssb+$Num_Rowsmr; ?> รายการ </b></span>
    </a>
</div></p>
<?php }
	}
	?>		
	
<?php if($Num_Rowsf > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_approvesup.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบสั่งขาย</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsf; ?> รายการ <?php if($Num_Rowsfd > 0 ){ ?> <font color='red'> ด่วน <?php echo $Num_Rowsfd; ?> </font>  <?php }?></b></span>
    </a>
</div></p>
<?php } ?>	
	
<?php if($Num_Rowsf1 > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_approvebrsup.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบยืม</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsf1; ?> รายการ <?php if($Num_Rowsf1d > 0 ){ ?> <font color='red'> ด่วน <?php echo $Num_Rowsf1d; ?> </font>  <?php }?></b></span>
    </a>
</div></p>
<?php } ?>	


<?php if($Num_Rows7 > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_approve_sol.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบสั่งขาย/ใบยืม</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rows7; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	

<?php if($Num_Rows17 > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_appqou.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเสนอราคา</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rows17; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	


<?php if($Num_Rowscos > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_approvebrsc.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบยืมฝากขาย</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowscos; ?> รายการ <?php if($Num_Rowscos1 > 0 ){ ?> <font color='red'> ด่วน <?php echo $Num_Rowscos1; ?> </font>  <?php }?></b></span>
    </a>
</div></p>
<?php } ?>	


<?php if($Num_Rowsfc > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_credit_approve.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบลดหนี้</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsfc; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>			

<?php if($Num_Rowssm > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_sample_approve.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเบิก (SMP)</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowssm; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>			

<?php if($Num_Rowsjn > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_supjongapp.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบจอง</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsjn; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	

<?php if($Num_Rowsch > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_supchangeapp.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบแลกเปลี่ยน</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsch; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	

<?php if($Num_Rowsren > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_apprental.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบสั่งเช่า</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsren; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	


<?php if($Num_Rowseng > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_storykangsup.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>รายการรับเรื่องรอดำเนินการ</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowseng; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	

<?php if($Num_Rowsengp > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_po_sup.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>เอกสาร PO รอเปิดใบสั่งขาย</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsengp; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	

<?php if($Num_Rowsrs > 0){ ?>	
<div class="w3-container">
    <a href="https://sol.allwellcenter.com/status_supresearch.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>แบบสอบถามหลังการขาย </b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsrs; ?> รายการ </b></span>
    </a>
</div></p>
<?php } ?>	



<?php if($_SESSION['name']=='รุจิรา'){ ?>
<?php if($j > 0){	?>	
<div class="w3-container"><a href="https://sol.allwellcenter.com/status_almostpro.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>สินค้ายอดนิยมออนไลน์เหลือต่ำกว่าเกณฑ์</b></span>
     <span style="text-align: right;"><b><?php echo $j;?>  รายการ</b></span>
	</a></div></p>
<?php } ?>		   
<?php if($p > 0){ ?>	
<div class="w3-container"><a href="https://sol.allwellcenter.com/status_almostpro.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>สินค้ายอดนิยมออนไลน์มีสินค้าเข้าพร้อมขาย</b></span>
     <span style="text-align: right;"><b><?php echo $p;?>  รายการ</b></span>
	</a></div></p>	
<?php 
} 
 }
?>	

</div>	
<?php } ?>
	
	
<?php	
//ใบขอซื้อภายใน	
$pr_main = "SELECT * FROM tb__pr WHERE ( pr_status = 1 OR  pr_status = 30 ) and pr_department = '".$emid."' ";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr2 = mysqli_num_rows($qpr_main);
	
$pr_main = "SELECT * FROM tb__pr WHERE ( pr_status = 1 OR  pr_status = 30 ) and pr_department = '".$emid."' and pr_need= 1";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr2_ = mysqli_num_rows($qpr_main);
	
	
//ใบเบิกสำนักงาน
$pr_main = "SELECT * FROM tb__wr WHERE wr_status = 2 and  user_type = '".$emm."'";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_wr2 = mysqli_num_rows($qpr_main);
	
$pr_main = "SELECT * FROM tb__wr WHERE wr_status = 2 and user_type = '".$emm."' and wr_need=1";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_wr2_ = mysqli_num_rows($qpr_main);
	
//ใบเบิกค่าใช้จาย	
$pr_main = "SELECT * FROM tb__re WHERE ( status_re = 2 OR status_re = 30 ) and user_type = '".$emm."' ";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr1 = mysqli_num_rows($qpr_main);
	
//ใบสำรองจ่าย RA	
$pr_main = "SELECT * FROM tb__ra WHERE ( status_re = 2 OR status_re = 30 ) and user_type = '".$emm."'";
$qpr_main = mysqli_query($pr_wr,$pr_main);
$Num_pr3 = mysqli_num_rows($qpr_main);
	
//ใบขอซื้อภายนอก	
$pr_main = "SELECT *  FROM po__main  where  send_sup = '1' and sup_name ='' and status_doc ='Request' $sddd";
$qpr_main = mysqli_query($inter,$pr_main);
$Num_pr9 = mysqli_num_rows($qpr_main);	

	


if(($Num_pr2+$Num_pr2_+$Num_wr2+$Num_wr2_+$Num_pr1+$Num_pr3+$Num_pr9) > 0){
	
?>	
<div class="w3-third" style="flex: 1; background-color: #f0f0f0;">	
<div class="w3-container"><font color ='blue'><b>ใบขอซื้อ & ใบเบิกค่าใช้จ่าย</b></font></div>	
<?php if($Num_pr2 > 0){ ?>	
<div class="w3-container">
    <a href="https://pr-wr.allwellcenter.com/pr_doc_status_sup" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบขอซื้อภายใน</b></span>
        <span style="text-align: right;"><b><?php echo $Num_pr2; ?> รายการ <?php if($Num_pr2_ > 0 ){ ?> <font color='red'> ด่วน <?php echo $Num_pr2_; ?> </font>  <?php }?></b></span>
    </a>
</div></p>
<?php } ?>	
	
	
<?php if($Num_wr2 > 0){ ?>	
<div class="w3-container">
    <a href="https://pr-wr.allwellcenter.com/wr_status_sup" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเบิกอุปกรณสำนักงาน</b></span>
        <span style="text-align: right;"><b><?php echo $Num_wr2; ?> รายการ <?php if($Num_wr2_ > 0 ){ ?> <font color='red'> ด่วน <?php echo $Num_wr2_; ?> </font>  <?php }?></b></span>
    </a>
</div></p>
<?php } ?>		
	
	
<?php if($Num_pr1 > 0){ ?>	
<div class="w3-container">
    <a href="https://pr-wr.allwellcenter.com/doc_expenditure_status_sup" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเบิกค่าใช้จ่าย</b></span>
        <span style="text-align: right;"><b><?php echo $Num_pr1; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>		
	
<?php if($Num_pr3 > 0){ ?>	
<div class="w3-container">
    <a href="https://pr-wr.allwellcenter.com/doc_ra_status_sup" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบสำรองจ่าย</b></span>
        <span style="text-align: right;"><b><?php echo $Num_pr3; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>		
	
<?php if($Num_pr9 > 0){ ?>	
<div class="w3-container">
    <a href="https://inter.allwellcenter.com/status_supapprove.php" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบขอซื้อ (INTER)</b></span>
        <span style="text-align: right;"><b><?php echo $Num_pr9; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>		
	
	
</div>	
<?php } ?>
		
	

<?php	
//ใบเสนอราคา
$strSQLqu = "SELECT id,id_fk,company,emid1,add_by,add_date,sale_code,status_all,
CASE
WHEN status_all = '0' THEN 'Request' -- ยังไม่ส่งsup
WHEN status_all = '1' THEN 'Request' -- ส่งsupแล้ว
WHEN status_all = '2' THEN 'Rejected' -- supไม่อนุมัติ
WHEN status_all = '3' THEN 'Request' -- supส่งกลับ
WHEN status_all = '4' THEN 'admin กำลังดำเนินการ' -- adminดำเนินการ
WHEN status_all = '5' THEN 'Request' -- adminส่งกลับ
WHEN status_all = '6' THEN 'admin อนุมัติส่งตรวจสอบ' -- adminอนุมัติส่งตรวจสอบ
WHEN status_all = '7' THEN 'Approve' -- Approve
WHEN status_all = '8' THEN 'admin กำลังดำเนินการ' -- ผู้ตรวจสอบส่งให้adminแก้ไข
WHEN status_all = '99' THEN 'Rejected' -- Rejected
WHEN status_all = '98' THEN 'ยกเลิก' -- Cancel
END as type_status
FROM quotation_handler WHERE (status_all = 1 or status_all = 5) $sddd";
$objQueryqu = mysqli_query($quo,$strSQLqu) or die ("Error Query [".$strSQLqu."]");
$Num_Rowsqu = mysqli_num_rows($objQueryqu);
	
$strSQLqu1 = "SELECT id FROM quotation_handler WHERE status_all IN (6, 8, 9) $sddd";
$objQueryqu1 = mysqli_query($quo,$strSQLqu1) or die ("Error Query [".$strSQLqu1."]");
$Num_Rowsqu1 = mysqli_num_rows($objQueryqu1);


if(($Num_Rowsqu1+$Num_Rowsqu) > 0){
	
?>	
<div class="w3-third" style="flex: 1; background-color: #f0f0f0;">	
<div class="w3-container"><font color ='blue'><b>ใบเสนอราคา</b></font></div>	
<?php if($Num_Rowsqu > 0){ ?>	
<div class="w3-container">
    <a href="https://quotation.allwellcenter.com/login_all.php?em_id=<?php echo $_SESSION['emid'] ?>" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเสนอราคาอนุมัติจัดทำ</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsqu; ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>	
	
<?php if($Num_Rowsqu1 > 0){ ?>	
<div class="w3-container">
    <a href="https://quotation.allwellcenter.com/report_split_status_sup_v3" target="_blank" class="w3-button w3-grey" 
       style="width: 100%; display: flex; justify-content: space-between; ">
        <span style="flex-grow: 1; text-align: left;"><b>ใบเสนอราคาอนุมัติจัดส่งลูกค้า</b></span>
        <span style="text-align: right;"><b><?php echo $Num_Rowsqu1 ?> รายการ</b></span>
    </a>
</div></p>
<?php } ?>	
		
	
	
</div>	
<?php } ?>
		

</div><br>	
<div class="w3-row" style="display: flex; gap: 10px;">
	

<?php 

//คุณทำดี
$strSQLem = "SELECT *  FROM good_result where  rc_id='".$_SESSION['emid']."' AND read_ckk ='0'";
//echo $strSQLem;	
$objQueryem = mysqli_query($user,$strSQLem) or die ("Error Query [".$strSQLem."]");
$Num_Rowsem = mysqli_num_rows($objQueryem);
	
//ใบแจ้งสินค้าไม่สมบูรณ์
/*$strSQLnc = "SELECT * FROM fb__maim where $code and (status_doc ='3' or status_doc ='4' )";
$objQuerync = mysqli_query($user,$strSQLnc) or die ("Error Query [".$strSQLnc."]");
$Num_Rowsnc = mysqli_num_rows($objQuerync);*/
	
//อนุมัติสินค้าไม่สมบูรณ์
/*$strSQLnc1 = "SELECT *  FROM no__complete  where  status_doc ='Request'  and send_sup ='1' $code";
$objQuerync1 = mysqli_query($conn,$strSQLnc1) or die ("Error Query [".$strSQLnc1."]");
$Num_Rowsnc1 = mysqli_num_rows($objQuerync1);*/
	
	
//ใบ Car
$strSQLca = "select * from car WHERE (division='$division' OR car_to_all1 LIKE '%$division%' ) AND  (status='F0' or status='H1' or status='F2')   ";
$objQueryca = mysqli_query($car,$strSQLca) or die ("Error Query [".$strSQLca."]");
$Num_Rowsca = mysqli_num_rows($objQueryca);
	
//ใบ Par
$strSQLpa = "select * from par WHERE (status='F0' or status='H1' or status='F2') AND division='$division'  ";
$objQuerypa = mysqli_query($car,$strSQLpa) or die ("Error Query [".$strSQLpa."]");
$Num_Rowspa = mysqli_num_rows($objQuerypa);
	
//ISO
$strSQLiso = "select * from dar WHERE status='0' AND division='$division' ";
$objQueryiso = mysqli_query($iso,$strSQLiso) or die ("Error Query [".$strSQLiso."]");
$Num_Rowsiso = mysqli_num_rows($objQueryiso);
	
	
if(($Num_Rowsem+$Num_Rowsnc+$Num_Rowsca+$Num_Rowspa+$Num_Rowsiso+$Num_Rowsnc1) > 0){	?>	

<div class="w3-third" style="flex: 1;  background-color: #f0f0f0;">
<div class="w3-container"><font color ='blue'><b>อื่นๆ</b></font></div>

	
<?php /*if($Num_Rowsnc > 0){	?>	
<div class="w3-container"><a href="https://feedback.allwellcenter.com/check_login_out.php?token=<?php echo  $token; ?>"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>FEED BACK FORM </b></span>
     <span><b><?php echo $Num_Rowsnc;?>  รายการ</b></span>
	</a></div></p>

<?php }*/ ?>	
	
	
<?php /*if($Num_Rowsnc1 > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/no_complete/status_approve.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>อนุมัติใบแจ้งสินค้าไม่สมบูรณ์</b></span>
     <span><b><?php echo $Num_Rowsnc1; ?>  รายการ</b></span>
	</a></div></p>

<?php }*/ ?>	
	
	
<?php if($Num_Rowsem > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/good_receive.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>การ์ดคุณทำดีที่ยังไม่ได้อ่าน</b></span>
     <span><b><?php echo $Num_Rowsem;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	
	
<?php if($Num_Rowsca > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/car/acarlist.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบขอให้แก้ไขรออนุมัติ</b></span>
     <span><b><?php echo $Num_Rowsca;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	

<?php if($Num_Rowspa > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/car/aparlist.php"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>ใบขอให้พัฒนารออนุมัติ</b></span>
     <span><b><?php echo $Num_Rowspa;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	


<?php if($Num_Rowsiso > 0){	?>	
<div class="w3-container"><a href="https://allwellcenter.com/iso/ap_sup.php?em_id=<?php echo $_SESSION['emid']; ?>"  target="_blank" class="w3-button w3-grey" style="width: 100%; display: flex; justify-content: space-between; align-items: center; 
              padding: 10px 20px; box-sizing: border-box;">
	<span style="flex-grow: 1; text-align: left;"><b>เอกสาร ISO รออนุมัติ</b></span>
     <span><b><?php echo $Num_Rowsiso;?>  รายการ</b></span>
	</a></div></p>

<?php } ?>	

	
</div>
<?php } ?>	
	


</div>	
