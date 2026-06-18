

<?php
include('head.php');
include "dbconnect.php";
 
$sale_code = $_POST["sale_code"];
$start_date = $_POST["start_date"];
$end_date = $_POST["end_date"];

$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;

//S11 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S11' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S11' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S11' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_s11 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//S11 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S11' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S11' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S11' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_s11 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_s11 =$sumnbm_s11+$sumawl_s11;
	
	
	
	
//S12 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S12' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S12' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S12' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_s12 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//S12 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S12' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S12' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S12' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_s12 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_s12 =$sumnbm_s12+$sumawl_s12;	


//S13 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S13' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S13' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S13' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_s13 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//S13 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S13' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S13' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S13' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_s13 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_s13 =$sumnbm_s13+$sumawl_s13;	



//S14 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S14' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S14' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S14' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_s14 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//S14 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S14' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S14' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S14' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_s14 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_s14 =$sumnbm_s14+$sumawl_s14;	

//S15 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S15' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S15' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S15' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_s15 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//S15 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S15' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S15' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S15' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_s15 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_s15 =$sumnbm_s11+$sumawl_s15;	

//S16 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S16' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S16' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S16' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_s16 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//S16 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S16' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S16' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S16' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_s16 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_s16 =$sumnbm_s16+$sumawl_s16;	

//S17 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S17' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S17' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S17' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_s17 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//S17 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S17' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S17' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S17' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_s17 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_s17 =$sumnbm_s11+$sumawl_s17;	

//S21 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S21' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S21' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S21' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_s21 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//S21 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S21' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S21' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S21' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_s21 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_s21 =$sumnbm_s21+$sumawl_s21;	



//S22 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S22' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S22' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S22' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_s22 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//S22 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S22' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S22' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S22' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_s22 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_s22 =$sumnbm_s22+$sumawl_s22;	



//S23 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S23' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S23' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S23' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_s23 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//S23 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S23' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S23' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S23' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_s23 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_s23 =$sumnbm_s23+$sumawl_s23;	


//S24 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S24' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S24' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S24' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_s24 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//S24 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S24' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S24' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S24' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_s24 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_s24 =$sumnbm_s24+$sumawl_s24;	


//S31 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S31' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S31' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S31' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_s31 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//S31 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='S31' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='S31' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='S31' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_s31 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_s31 =$sumnbm_s31+$sumawl_s31;	


//MM1 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='MM1' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='MM1' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='MM1' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_MM1 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//MM1 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='MM1' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='MM1' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='MM1' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_MM1 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_MM1 =$sumnbm_MM1+$sumawl_MM1;		

	
//SM1 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='SM1' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='SM1' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='SM1' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_SM1 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//SM1 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='SM1' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='SM1' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='SM1' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_SM1 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_SM1 =$sumnbm_SM1+$sumawl_SM1;		
	
	
//MM2 AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='MM2' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='MM2' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='MM2' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_MM2 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//MM2 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code='MM2' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code='MM2' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code='MM2' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_MM2 = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_MM2 =$sumnbm_MM2+$sumawl_MM2;	
	

	
	
//EN AWL

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code LIKE '%EN%' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code  LIKE '%EN%' and type_doc ='3'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code  LIKE '%EN%' and company_type ='3'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumawl_EN = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];


//MM2 NBM

$strSQL = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0' and sale_code  LIKE '%EN%' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT SUM(amount)  as amount  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2' and sale_code  LIKE '%EN%' and type_doc ='4'";

if($start_date !=""){ 
    $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



$strSQL2 = "SELECT SUM(sum_amount)  as sum_amount  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve'  and sale_code  LIKE '%EN%' and company_type ='4'";

if($start_date !=""){ 
    $strSQL2 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND date_credit <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$sumnbm_EN = ($objResult1['amount']+$objResult['amount'])-$objResult2['sum_amount'];
$sumary_EN =$sumnbm_EN+$sumawl_EN;	

	
//AWL SUM

$strSQL50 = "SELECT SUM(sum_amount)  as total50  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code NOT LIKE '%SOL%' and company_type='3'";

if($start_date !=""){ 
    $strSQL50 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL50 .= ' AND date_credit <= "'.$end_date.'"'; 
}

$objQuery50 = mysqli_query($conn,$strSQL50) or die ("Error Query [".$strSQL50."]");
$objResult50 = mysqli_fetch_array($objQuery50);


	
$strSQL53 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0'  and status_adm !='ยกเลิก' and sale_code !='' and type_doc='3'";

if($start_date !=""){ 
    $strSQL53 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL53 .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery53 = mysqli_query($conn,$strSQL53) or die ("Error Query [".$strSQL53."]");
$objResult53 = mysqli_fetch_array($objQuery53);

	
$strSQL54 = "SELECT SUM(amount)  as total53  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2'   and status_adm !='ยกเลิก' and sale_code !='' and type_doc='3'";

if($start_date !=""){ 
    $strSQL54 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL54 .= ' AND iv_date <= "'.$end_date.'"'; 
}

	
$objQuery54 = mysqli_query($conn,$strSQL54) or die ("Error Query [".$strSQL54."]");
$objResult54 = mysqli_fetch_array($objQuery54);

$summary_awl = ($objResult54['total53']+$objResult53['total']) -$objResult50['total50'] ;
	

	
//NBM SUM
	

$strSQL50 = "SELECT SUM(sum_amount)  as total50  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE  credit_no !='' and status_doc = 'Approve' and sale_code NOT LIKE '%SOL%' and company_type='4'";

if($start_date !=""){ 
    $strSQL50 .= ' AND date_credit >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL50 .= ' AND date_credit <= "'.$end_date.'"'; 
}

$objQuery50 = mysqli_query($conn,$strSQL50) or die ("Error Query [".$strSQL50."]");
$objResult50 = mysqli_fetch_array($objQuery50);


	
$strSQL53 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '0'  and status_adm !='ยกเลิก' and sale_code !='' and type_doc='4'";

if($start_date !=""){ 
    $strSQL53 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL53 .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery53 = mysqli_query($conn,$strSQL53) or die ("Error Query [".$strSQL53."]");
$objResult53 = mysqli_fetch_array($objQuery53);

	
$strSQL54 = "SELECT SUM(amount)  as total53  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and have_order = '1' and have_product = '2'   and status_adm !='ยกเลิก' and sale_code !='' and type_doc='4'";

if($start_date !=""){ 
    $strSQL54 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL54 .= ' AND iv_date <= "'.$end_date.'"'; 
}

	
$objQuery54 = mysqli_query($conn,$strSQL54) or die ("Error Query [".$strSQL54."]");
$objResult54 = mysqli_fetch_array($objQuery54);

$summary_nbm = ($objResult54['total53']+$objResult53['total']) -$objResult50['total50'] ;
	
$summary_all = $summary_nbm+$summary_awl;	


?>

<?php 	if ($_SESSION['code']=='SS1'){ ?>	
<div class="w3-white w3-container w3-padding-large">
	
	<center>
<h3 align="center">รายงานยอดขายแบบกราฟ</h3>
<h3 align="center"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></h3>
<table width="80%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr>
    <th width="15%">เขตการขาย </th>
    <th width="10%">ยอดขาย AWL</th>
	    <th width="10%">ยอดขาย NBM</th>
    <th width="10%">ยอดขายทั้งหมด</th>

  </tr>
  </thead>
  
	
	    <tr>
      <td align="center">S15</td>
      <td align="right"><?php echo number_format($sumawl_s15,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s15,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s15,2);?></td> 

    </tr>
	
	    <tr>
      <td align="center">S16</td>
      <td align="right"><?php echo number_format($sumawl_s16,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s16,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s16,2);?></td> 

    </tr>
	
	   <tr>
      <td align="center">S21</td>
      <td align="right"><?php echo number_format($sumawl_s21,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s21,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s21,2);?></td> 

    </tr>

	   <tr>
      <td align="center">S22</td>
      <td align="right"><?php echo number_format($sumawl_s22,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s22,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s22,2);?></td> 

    </tr>
	
 <tr>
      <td align="center"><h4><b><font color='#FF0000'>ยอดขายรวม</font></b></h4></td>
      <td align="right"><h4><b><font color='#330066'><?php echo number_format($sumawl_s15+$sumawl_s16+$sumawl_s21+$sumawl_s22,2);?></font></b></h4></td> 
	  <td align="right"><h4><b><font color='#FF3399'><?php echo number_format($sumnbm_s15+$sumnbm_s16+$sumnbm_s21+$sumnbm_s22,2);?></font></b></h4></td> 
      <td align="right"><h4><b><font color='#FF9999'><?php echo number_format($sumary_s22+$sumary_s21+$sumary_s15+$sumary_s16,2);?></font></b></h4></td> 

    </tr>
	

	
  </thead>
</table>
<br><br>
<style>
	
.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#FF3399;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#330066;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}

</style>

<input  class="button3" style="width:40px;height:20px "> : ยอดขาย AWL &nbsp
<input  class="button2" style="width:40px;height:20px"> : ยอดขาย NBM &nbsp
<input  class="button1" style="width:40px;height:20px"> : ยอดขายทั้งหมด &nbsp


<br><br>

<?php
 
$dataPoints = array( 
	
	array("y" =>  $sumawl_s15,"color" => "#330066", "label" => "S15" ),
	array("y" =>  $sumnbm_s15,"color" => "#FF3399", "label" => "S15" ),
	array("y" => $sumary_s15,"color" => "#FF9999", "label" => "S15" ),
	array("y" =>  $sumawl_s16,"color" => "#330066", "label" => "S16" ),
	array("y" =>  $sumnbm_s16,"color" => "#FF3399", "label" => "S16" ),
	array("y" => $sumary_s16,"color" => "#FF9999", "label" => "S16" ),
	array("y" =>  $sumawl_s21,"color" => "#330066", "label" => "S21" ),
	array("y" =>  $sumnbm_s21,"color" => "#FF3399", "label" => "S21" ),
	array("y" => $sumary_s21,"color" => "#FF9999", "label" => "S21" ),
	array("y" =>  $sumawl_s22,"color" => "#330066", "label" => "S22" ),
	array("y" =>  $sumnbm_s22,"color" => "#FF3399", "label" => "S22" ),
	array("y" => $sumary_s22,"color" => "#FF9999", "label" => "S22" )

);
 
?>
<!DOCTYPE HTML>
<?php 	}else if ($_SESSION['code']=='SS2'){ ?>	
<div class="w3-white w3-container w3-padding-large">	
<center>
<h3 align="center">รายงานยอดขายแบบกราฟ</h3>
<h3 align="center"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></h3>
<table width="80%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr>
    <th width="15%">เขตการขาย </th>
    <th width="10%">ยอดขาย AWL</th>
	    <th width="10%">ยอดขาย NBM</th>
    <th width="10%">ยอดขายทั้งหมด</th>

  </tr>
  </thead>
  
    <tr>
      <td align="center">S11</td>
      <td align="right"><?php echo number_format($sumawl_s11,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s11,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s11,2);?></td> 

    </tr>
	
	
	    <tr>
      <td align="center">S12</td>
      <td align="right"><?php echo number_format($sumawl_s12,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s12,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s12,2);?></td> 

    </tr>
	
	    <tr>
      <td align="center">S13</td>
      <td align="right"><?php echo number_format($sumawl_s13,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s13,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s13,2);?></td> 

    </tr>
	
	    <tr>
      <td align="center">S14</td>
      <td align="right"><?php echo number_format($sumawl_s14,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s14,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s14,2);?></td> 

    </tr>
		
	    <tr>
      <td align="center">S17</td>
      <td align="right"><?php echo number_format($sumawl_s17,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s17,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s17,2);?></td> 

    </tr>

	   <tr>
      <td align="center">S23</td>
      <td align="right"><?php echo number_format($sumawl_s23,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s23,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s23,2);?></td> 

    </tr>

	   <tr>
      <td align="center">S24</td>
      <td align="right"><?php echo number_format($sumawl_s24,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s24,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s24,2);?></td> 

    </tr>

	
 <tr>
      <td align="center"><h4><b><font color='#FF0000'>ยอดขายรวมทั้งหมด</font></b></h4></td>
      <td align="right"><h4><b><font color='#330066'><?php echo number_format($sumawl_s11+$sumawl_s12+$sumawl_s13+$sumawl_s14+$sumawl_s17+$sumawl_s23+$sumawl_s24,2);?></font></b></h4></td> 
	  <td align="right"><h4><b><font color='#FF3399'><?php echo number_format($sumnbm_s24+$sumnbm_s23+$sumnbm_s11+$sumnbm_s12+$sumnbm_s13+$sumnbm_s14+$sumnbm_s17,2);?></font></b></h4></td> 
      <td align="right"><h4><b><font color='#FF9999'><?php echo number_format($sumary_s24+$sumary_s23+$sumary_s11+$sumary_s12+$sumary_s13+$sumary_s14+$sumary_s17,2);?></font></b></h4></td> 

    </tr>
	

	
  </thead>
</table>
<br><br>
<style>
	
.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#FF3399;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#330066;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}

</style>

<input  class="button3" style="width:40px;height:20px "> : ยอดขาย AWL &nbsp
<input  class="button2" style="width:40px;height:20px"> : ยอดขาย NBM &nbsp
<input  class="button1" style="width:40px;height:20px"> : ยอดขายทั้งหมด &nbsp


<br><br>

<?php
 
$dataPoints = array( 
	array("y" => $sumawl_s11,"color" => "#330066", "label" => "S11" ),
	array("y" =>  $sumnbm_s11,"color" => "#FF3399", "label" => "S11" ),
	array("y" =>  $sumary_s11,"color" => "#FF9999", "label" => "S11" ),
	array("y" =>  $sumawl_s12,"color" => "#330066", "label" => "S12" ),
	array("y" =>  $sumnbm_s12,"color" => "#FF3399", "label" => "S12" ),
	array("y" => $sumary_s12,"color" => "#FF9999", "label" => "S12" ),
	array("y" =>  $sumawl_s13,"color" => "#330066", "label" => "S13" ),
	array("y" =>  $sumnbm_s13,"color" => "#FF3399", "label" => "S13" ),
	array("y" => $sumary_s13,"color" => "#FF9999", "label" => "S13" ),
	array("y" =>  $sumawl_s14,"color" => "#330066", "label" => "S14" ),
	array("y" =>  $sumnbm_s14,"color" => "#FF3399", "label" => "S14" ),
	array("y" => $sumary_s14,"color" => "#FF9999", "label" => "S14" ),
	array("y" =>  $sumawl_s17,"color" => "#330066", "label" => "S17" ),
	array("y" =>  $sumnbm_s17,"color" => "#FF3399", "label" => "S17" ),
	array("y" => $sumary_s17,"color" => "#FF9999", "label" => "S17" ),
	array("y" =>  $sumawl_s23,"color" => "#330066", "label" => "S23" ),
	array("y" =>  $sumnbm_s23,"color" => "#FF3399", "label" => "S23" ),
	array("y" => $sumary_s23,"color" => "#FF9999", "label" => "S23" ),
	array("y" =>  $sumawl_s24,"color" => "#330066", "label" => "S24" ),
	array("y" =>  $sumnbm_s24,"color" => "#FF3399", "label" => "S24" ),
	array("y" => $sumary_s24,"color" => "#FF9999", "label" => "S24" )
	
);
 
?>
<!DOCTYPE HTML>

<?php 	}else if ($_SESSION['code']=='SS3'){ ?>	
<div class="w3-white w3-container w3-padding-large">
<center>
<h3 align="center">รายงานยอดขายแบบกราฟ</h3>
<h3 align="center"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></h3>
<table width="50%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr>
    <th width="15%">เขตการขาย </th>
    <th width="10%">ยอดขาย AWL</th>
	    <th width="10%">ยอดขาย NBM</th>
    <th width="10%">ยอดขายทั้งหมด</th>

  </tr>
  </thead>
	
	 <tr>
      <td align="center">S31</td>
      <td align="right"><?php echo number_format($sumawl_s31,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s31,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s31,2);?></td> 

    </tr>

	   <tr>
      <td align="center">MM1</td>
      <td align="right"><?php echo number_format($sumawl_MM1,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_MM1,2);?></td> 
      <td align="right"><?php echo number_format($sumary_MM1,2);?></td> 

    </tr>
	
	 <tr>
      <td align="center">SM1</td>
      <td align="right"><?php echo number_format($sumawl_SM1,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_SM1,2);?></td> 
      <td align="right"><?php echo number_format($sumary_SM1,2);?></td> 

    </tr>

	   <tr>
      <td align="center">MM2</td>
      <td align="right"><?php echo number_format($sumawl_MM2,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_MM2,2);?></td> 
      <td align="right"><?php echo number_format($sumary_MM2,2);?></td> 

    </tr>

	
	
 <tr>
      <td align="center"><h4><b><font color='#FF0000'>ยอดขายรวมทั้งหมด</font></b></h4></td>
      <td align="right"><h4><b><font color='#330066'><?php echo number_format($sumawl_s31+$sumawl_SM1+$sumawl_MM1+$sumawl_MM2,2);?></font></b></h4></td> 
	  <td align="right"><h4><b><font color='#FF3399'><?php echo number_format($sumnbm_MM2+$sumnbm_MM1+$sumnbm_SM1+$sumnbm_s31,2);?></font></b></h4></td> 
      <td align="right"><h4><b><font color='#FF9999'><?php echo number_format($sumary_MM2+$sumary_MM1+$sumary_SM1+$sumary_s31,2);?></font></b></h4></td> 

    </tr>

</table>
<br><br>
<style>
	
.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#FF3399;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#330066;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}

</style>

<input  class="button3" style="width:40px;height:20px "> : ยอดขาย AWL &nbsp
<input  class="button2" style="width:40px;height:20px"> : ยอดขาย NBM &nbsp
<input  class="button1" style="width:40px;height:20px"> : ยอดขายทั้งหมด &nbsp


<br><br>

<?php
 
$dataPoints = array( 
	
	array("y" =>  $sumawl_s31,"color" => "#330066", "label" => "S31" ),
	array("y" =>  $sumnbm_s31,"color" => "#FF3399", "label" => "S31" ),
	array("y" => $sumary_s31,"color" => "#FF9999", "label" => "S31" ),
	array("y" =>  $sumawl_MM1,"color" => "#330066", "label" => "MM1" ),
	array("y" =>  $sumnbm_MM1,"color" => "#FF3399", "label" => "MM1" ),
	array("y" => $sumary_MM1,"color" => "#FF9999", "label" => "MM1" ),
	array("y" =>  $sumawl_SM1,"color" => "#330066", "label" => "SM1" ),
	array("y" =>  $sumnbm_SM1,"color" => "#FF3399", "label" => "SM1" ),
	array("y" => $sumary_SM1,"color" => "#FF9999", "label" => "SM1" ),
	array("y" =>  $sumawl_MM2,"color" => "#330066", "label" => "MM2" ),
	array("y" =>  $sumnbm_MM2,"color" => "#FF3399", "label" => "MM2" ),
	array("y" => $sumary_MM2,"color" => "#FF9999", "label" => "MM2" )

);
 
?>
<!DOCTYPE HTML>

<?php }else{ ?>
	<div class="w3-white w3-container w3-padding-large">
<center>
<h3 align="center">รายงานยอดขายแบบกราฟ</h3>
<h3 align="center"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></h3>
<table width="50%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr>
    <th width="15%">เขตการขาย </th>
    <th width="10%">ยอดขาย AWL</th>
	    <th width="10%">ยอดขาย NBM</th>
    <th width="10%">ยอดขายทั้งหมด</th>

  </tr>
  </thead>
  
  
    <tr>
      <td align="center">S11</td>
      <td align="right"><?php echo number_format($sumawl_s11,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s11,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s11,2);?></td> 

    </tr>
	
	
	    <tr>
      <td align="center">S12</td>
      <td align="right"><?php echo number_format($sumawl_s12,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s12,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s12,2);?></td> 

    </tr>
	
	    <tr>
      <td align="center">S13</td>
      <td align="right"><?php echo number_format($sumawl_s13,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s13,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s13,2);?></td> 

    </tr>
	
	    <tr>
      <td align="center">S14</td>
      <td align="right"><?php echo number_format($sumawl_s14,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s14,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s14,2);?></td> 

    </tr>
	
	    <tr>
      <td align="center">S15</td>
      <td align="right"><?php echo number_format($sumawl_s15,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s15,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s15,2);?></td> 

    </tr>
	
	    <tr>
      <td align="center">S16</td>
      <td align="right"><?php echo number_format($sumawl_s16,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s16,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s16,2);?></td> 

    </tr>
	
	    <tr>
      <td align="center">S17</td>
      <td align="right"><?php echo number_format($sumawl_s17,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s17,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s17,2);?></td> 

    </tr>

	   <tr>
      <td align="center">S21</td>
      <td align="right"><?php echo number_format($sumawl_s21,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s21,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s21,2);?></td> 

    </tr>

	   <tr>
      <td align="center">S22</td>
      <td align="right"><?php echo number_format($sumawl_s22,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s22,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s22,2);?></td> 

    </tr>

	   <tr>
      <td align="center">S23</td>
      <td align="right"><?php echo number_format($sumawl_s23,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s23,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s23,2);?></td> 

    </tr>

	   <tr>
      <td align="center">S24</td>
      <td align="right"><?php echo number_format($sumawl_s24,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s24,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s24,2);?></td> 

    </tr>

	   <tr>
      <td align="center">S31</td>
      <td align="right"><?php echo number_format($sumawl_s31,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_s31,2);?></td> 
      <td align="right"><?php echo number_format($sumary_s31,2);?></td> 

    </tr>

	   <tr>
      <td align="center">MM1</td>
      <td align="right"><?php echo number_format($sumawl_MM1,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_MM1,2);?></td> 
      <td align="right"><?php echo number_format($sumary_MM1,2);?></td> 

    </tr>
	
    
	 <tr>
      <td align="center">SM1</td>
      <td align="right"><?php echo number_format($sumawl_SM1,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_SM1,2);?></td> 
      <td align="right"><?php echo number_format($sumary_SM1,2);?></td> 

    </tr>

	   <tr>
      <td align="center">MM2</td>
      <td align="right"><?php echo number_format($sumawl_MM2,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_MM2,2);?></td> 
      <td align="right"><?php echo number_format($sumary_MM2,2);?></td> 

    </tr>

	<tr>
      <td align="center">EN</td>
      <td align="right"><?php echo number_format($sumawl_EN,2);?></td> 
	  <td align="right"><?php echo number_format($sumnbm_EN,2);?></td> 
      <td align="right"><?php echo number_format($sumary_EN,2);?></td> 

    </tr>
	
 <tr>
      <td align="center"><h4><b><font color='#FF0000'>ยอดขายรวมทั้งหมด</font></b></h4></td>
      <td align="right"><h4><b><font color='#330066'><?php echo number_format($summary_awl,2);?></font></b></h4></td> 
	  <td align="right"><h4><b><font color='#FF3399'><?php echo number_format($summary_nbm,2);?></font></b></h4></td> 
      <td align="right"><h4><b><font color='#FF9999'><?php echo number_format($summary_all,2);?></font></b></h4></td> 

    </tr>
	 	  
	
  
</table>
<br><br>
<style>
	
.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#FF3399;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#330066;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}

</style>

<input  class="button3" style="width:40px;height:20px "> : ยอดขาย AWL &nbsp
<input  class="button2" style="width:40px;height:20px"> : ยอดขาย NBM &nbsp
<input  class="button1" style="width:40px;height:20px"> : ยอดขายทั้งหมด &nbsp;


<br><br>

<?php
 
$dataPoints = array( 
	array("y" => $sumawl_s11,"color" => "#330066", "label" => "S11" ),
	array("y" =>  $sumnbm_s11,"color" => "#FF3399", "label" => "S11" ),
	array("y" =>  $sumary_s11,"color" => "#FF9999", "label" => "S11" ),
	array("y" =>  $sumawl_s12,"color" => "#330066", "label" => "S12" ),
	array("y" =>  $sumnbm_s12,"color" => "#FF3399", "label" => "S12" ),
	array("y" => $sumary_s12,"color" => "#FF9999", "label" => "S12" ),
	array("y" =>  $sumawl_s13,"color" => "#330066", "label" => "S13" ),
	array("y" =>  $sumnbm_s13,"color" => "#FF3399", "label" => "S13" ),
	array("y" => $sumary_s13,"color" => "#FF9999", "label" => "S13" ),
	array("y" =>  $sumawl_s14,"color" => "#330066", "label" => "S14" ),
	array("y" =>  $sumnbm_s14,"color" => "#FF3399", "label" => "S14" ),
	array("y" => $sumary_s14,"color" => "#FF9999", "label" => "S14" ),
	array("y" =>  $sumawl_s15,"color" => "#330066", "label" => "S15" ),
	array("y" =>  $sumnbm_s15,"color" => "#FF3399", "label" => "S15" ),
	array("y" => $sumary_s15,"color" => "#FF9999", "label" => "S15" ),
	array("y" =>  $sumawl_s16,"color" => "#330066", "label" => "S16" ),
	array("y" =>  $sumnbm_s16,"color" => "#FF3399", "label" => "S16" ),
	array("y" => $sumary_s16,"color" => "#FF9999", "label" => "S16" ),
	array("y" =>  $sumawl_s17,"color" => "#330066", "label" => "S17" ),
	array("y" =>  $sumnbm_s17,"color" => "#FF3399", "label" => "S17" ),
	array("y" => $sumary_s17,"color" => "#FF9999", "label" => "S17" ),
	array("y" =>  $sumawl_s21,"color" => "#330066", "label" => "S21" ),
	array("y" =>  $sumnbm_s21,"color" => "#FF3399", "label" => "S21" ),
	array("y" => $sumary_s21,"color" => "#FF9999", "label" => "S21" ),
	array("y" =>  $sumawl_s22,"color" => "#330066", "label" => "S22" ),
	array("y" =>  $sumnbm_s22,"color" => "#FF3399", "label" => "S22" ),
	array("y" => $sumary_s22,"color" => "#FF9999", "label" => "S22" ),
	array("y" =>  $sumawl_s23,"color" => "#330066", "label" => "S23" ),
	array("y" =>  $sumnbm_s23,"color" => "#FF3399", "label" => "S23" ),
	array("y" => $sumary_s23,"color" => "#FF9999", "label" => "S23" ),
	array("y" =>  $sumawl_s24,"color" => "#330066", "label" => "S24" ),
	array("y" =>  $sumnbm_s24,"color" => "#FF3399", "label" => "S24" ),
	array("y" => $sumary_s24,"color" => "#FF9999", "label" => "S24" ),
	array("y" =>  $sumawl_s31,"color" => "#330066", "label" => "S31" ),
	array("y" =>  $sumnbm_s31,"color" => "#FF3399", "label" => "S31" ),
	array("y" => $sumary_s31,"color" => "#FF9999", "label" => "S31" ),
	array("y" =>  $sumawl_MM1,"color" => "#330066", "label" => "MM1" ),
	array("y" =>  $sumnbm_MM1,"color" => "#FF3399", "label" => "MM1" ),
	array("y" => $sumary_MM1,"color" => "#FF9999", "label" => "MM1" ),
	array("y" =>  $sumawl_SM1,"color" => "#330066", "label" => "SM1" ),
	array("y" =>  $sumnbm_SM1,"color" => "#FF3399", "label" => "SM1" ),
	array("y" => $sumary_SM1,"color" => "#FF9999", "label" => "SM1" ),
	array("y" =>  $sumawl_MM2,"color" => "#330066", "label" => "MM2" ),
	array("y" =>  $sumnbm_MM2,"color" => "#FF3399", "label" => "MM2" ),
	array("y" => $sumary_MM2,"color" => "#FF9999", "label" => "MM2" ),
	array("y" =>  $sumawl_EN,"color" => "#330066", "label" => "EN" ),
	array("y" =>  $sumnbm_EN,"color" => "#FF3399", "label" => "EN" ),
	array("y" => $sumary_EN,"color" => "#FF9999", "label" => "EN" )

);
 
?>
<!DOCTYPE HTML>


<?php } ?>


<html>
<head>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
title:{
		text: "รายงานยอดขายแบบกราฟ"
	},
	axisY: {
		suffix: ""
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## ฿",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
 <body>

<div id="chartContainer" style="height: 100%; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><input  class="button4" style="width:40px;height:20px">
</div>
<div id="cr_bar"> <?php include "foot.php"; ?> </div>
