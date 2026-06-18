<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 14px; color: #FF0000;}
.style17 {font-size: 14px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style30 {font-size: 12px; color: #000000;}
.style40 {font-size: 15px; color: #000000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#CCFF66;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#FF3333;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}



</style>



<?php


include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorHTML.php";
include "src/BarcodeGeneratorPNG.php";


function barcode($code){
    
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $border = 0.5;//กำหนดความหน้าของเส้น Barcode
    $height = 15;//กำหนดความสูงของ Barcode
 
    return $generator->getBarcode($code , $generator::TYPE_CODE_128,$border,$height);
 
}
 

date_default_timezone_set("Asia/Bangkok");
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

$id_year = $_GET["id_year"];

include"dbconnect.php";
include"dbconnect_sale.php";

$year =$id_year+543;

$jan = "$id_year-01-01";
$jan1 = "$id_year-01-31";
$feb = "$id_year-02-01";
$feb1 = "$id_year-02-29";
$mar = "$id_year-03-01";
$mar1 = "$id_year-03-31";
$apr = "$id_year-04-01";
$apr1 = "$id_year-04-30";
$may = "$id_year-05-01";
$may1 = "$id_year-05-31";
$jun = "$id_year-06-01";
$jun1 = "$id_year-06-30";
$jul = "$id_year-07-01";
$jul1 = "$id_year-07-31";
$aug = "$id_year-08-01";
$aug1 = "$id_year-08-31";
$sep = "$id_year-09-01";
$sep1 = "$id_year-09-30";
$oct = "$id_year-10-01";
$oct1 = "$id_year-10-31";
$nov = "$id_year-11-01";
$nov1 = "$id_year-11-30";
$dec = "$id_year-12-01";
$dec1 = "$id_year-12-31";


?>
<body>



<center>
<span class="style15">สรุปยอดขาย</span></p>


<span class="style15"><?php echo "Actual Phartrillion + Noble Med " ; echo $year; ?></span>
</center>
</p>


</p>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="6%" align="center" class="style30">Actual</td>
<td width="6%" align="center" class="style30">Jan</td>
<td width="6%" align="center" class="style30">Feb</td>
<td width="6%" align="center" class="style30">Mar</td> 
<td width="6%" align="center" class="style30">Apr</td> 
<td width="6%" align="center" class="style30">May</td> 
<td width="6%" align="center" class="style30">Jun</td> 
<td width="6%" bgcolor="#BEBEBE" align="center" class="style30">Total 1-6</td> 
<td width="6%" align="center" class="style30">Jul</td>
<td width="6%" align="center" class="style30">Aug</td>
<td width="6%" align="center" class="style30">Sep</td>
<td width="6%" align="center" class="style30">Oct</td> 
<td width="6%" align="center" class="style30">Nov</td> 
<td width="6%" align="center" class="style30">Dec</td> 
<td width="6%" bgcolor="#BEBEBE" align="center" class="style30">Total 7-12</td> 
<td width="6%" bgcolor="#9ACD32" align="center" class="style30">TOTAL 1-12</td> 



	</tr>


<?php


$strSQL ="SELECT * FROM tb_team_adm where ckk='0' ";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$sale_code = $objResult["sale_code"];

//S11

//มกราคม
$strSQL1 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0' ";

$strSQL1 .= ' AND iv_date >= "'.$jan.'"'; 

$strSQL1 .= ' AND iv_date <= "'.$jan1.'"'; 


$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



	$strSQL2 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2' ";

$strSQL2 .= ' AND iv_date >= "'.$jan.'"'; 

$strSQL2 .= ' AND iv_date <= "'.$jan1.'"'; 

$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");

$objResult2 = mysqli_fetch_array($objQuery2);


$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve'";

$strSQL5 .= ' AND date_credit >= "'.$jan.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$jan1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11jan_vat=($objResult1['total']+$objResult2['total1'])-$objResult5['sum_amount1'];

$S11jan = $S11jan_vat/1.07;

//กุมภา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0' ";

$strSQL3 .= ' AND iv_date >= "'.$feb.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$feb1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2' ";

$strSQL4 .= ' AND iv_date >= "'.$feb.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$feb1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve'";

$strSQL5 .= ' AND date_credit >= "'.$feb.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$feb1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);


$S11feb_vat =($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11feb = $S11feb_vat/1.07;
	
//มีนา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0' ";

$strSQL3 .= ' AND iv_date >= "'.$mar.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$mar1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2' ";

$strSQL4 .= ' AND iv_date >= "'.$mar.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$mar1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve'";

$strSQL5 .= ' AND date_credit >= "'.$mar.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$mar1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11mar_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11mar = $S11mar_vat/1.07;


//เมษา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0' ";

$strSQL3 .= ' AND iv_date >= "'.$apr.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$apr1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2' ";

$strSQL4 .= ' AND iv_date >= "'.$apr.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$apr1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve'";

$strSQL5 .= ' AND date_credit >= "'.$apr.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$apr1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11apr_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11apr = $S11apr_vat/1.07;
	
	
//พฤษภา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0' ";

$strSQL3 .= ' AND iv_date >= "'.$may.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$may1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2' ";

$strSQL4 .= ' AND iv_date >= "'.$may.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$may1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve'";

$strSQL5 .= ' AND date_credit >= "'.$may.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$may1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11may_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11may = $S11may_vat/1.07;

//มิถุนา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0' ";

$strSQL3 .= ' AND iv_date >= "'.$jun.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$jun1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2' ";

$strSQL4 .= ' AND iv_date >= "'.$jun.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$jun1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve'";

$strSQL5 .= ' AND date_credit >= "'.$jun.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$jun1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11jun_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11jun = $S11jun_vat/1.07;


$sums11_haft = $S11jun+$S11may+$S11apr+$S11mar+$S11feb+$S11jan;


//กรกฎา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0' ";

$strSQL3 .= ' AND iv_date >= "'.$jul.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$jul1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2' ";

$strSQL4 .= ' AND iv_date >= "'.$jul.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$jul1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve'";

$strSQL5 .= ' AND date_credit >= "'.$jul.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$jul1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11jul_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11jul = $S11jul_vat/1.07;


//สิงหาคม
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0' ";

$strSQL3 .= ' AND iv_date >= "'.$aug.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$aug1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2' ";

$strSQL4 .= ' AND iv_date >= "'.$aug.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$aug1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve'";

$strSQL5 .= ' AND date_credit >= "'.$aug.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$aug1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11aug_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11aug = $S11aug_vat/1.07;
	
	//กันยายน
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0' ";

$strSQL3 .= ' AND iv_date >= "'.$sep.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$sep1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2' ";

$strSQL4 .= ' AND iv_date >= "'.$sep.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$sep1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve'";

$strSQL5 .= ' AND date_credit >= "'.$sep.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$sep1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11sep_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11sep = $S11sep_vat/1.07;
	
	
		//ตุลาคม
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0' ";

$strSQL3 .= ' AND iv_date >= "'.$oct.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$oct1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2' ";

$strSQL4 .= ' AND iv_date >= "'.$oct.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$oct1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve'";

$strSQL5 .= ' AND date_credit >= "'.$oct.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$oct1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11oct_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11oct = $S11oct_vat/1.07;
	
		//พฤศจิกายน
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0' ";

$strSQL3 .= ' AND iv_date >= "'.$nov.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$nov1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2' ";

$strSQL4 .= ' AND iv_date >= "'.$nov.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$nov1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve'";

$strSQL5 .= ' AND date_credit >= "'.$nov.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$nov1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11nov_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11nov = $S11nov_vat/1.07;
	
		//ธันวาคม
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0' ";

$strSQL3 .= ' AND iv_date >= "'.$dec.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$dec1.'"'; 

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2' ";

$strSQL4 .= ' AND iv_date >= "'.$dec.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$dec1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve'";

$strSQL5 .= ' AND date_credit >= "'.$dec.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$dec1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11dec_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11dec = $S11dec_vat/1.07;
$sums11_haft1 = $S11jul+$S11aug+$S11sep+$S11oct+$S11nov+$S11dec;

$sums11_full = $sums11_haft1+$sums11_haft;


?>

<tr>
<td  align="right" class="style30"><?php echo $sale_code; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11jan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11feb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11mar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $S11apr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $S11may,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $S11jun,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sums11_haft,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $S11jul,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11aug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11sep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11oct,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $S11nov,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $S11dec,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sums11_haft1,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $sums11_full,2).""; ?></td> 

	</tr>

<?php } ?>

<?php

	//เดือนมกราSOL1
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL1)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$jan.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$jan1.'"'; 
 
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL1)'";

    $strSQL7 .= ' AND iv_date >= "'.$jan.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$jan1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL1)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$jan.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$jan1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL1)'";

    $strSQL9 .= ' AND iv_date >= "'.$jan.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$jan1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$jan.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$jan1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$jan.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$jan1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol1janf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol1janf = $sol1janf_vat/1.07;
	
$sol1jann_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol1jann = $sol1jann_vat/1.07;

$soljan_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol_jan = $soljan_vat/1.07;
	
	
	//เดือนกุมภา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL1)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$feb.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$feb1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL1)'";

    $strSQL7 .= ' AND iv_date >= "'.$feb.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$feb1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL1)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$feb.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$feb1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL1)'";

    $strSQL9 .= ' AND iv_date >= "'.$feb.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$feb1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$feb.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$feb1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$feb.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$feb1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol1febf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol1febf = $sol1febf_vat/1.07;
	
$sol1febn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol1febn = $sol1febn_vat/1.07;

$solfeb_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol_feb = $solfeb_vat/1.07;
	
	
	
	
	//เดือนมีนา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL1)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$mar.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$mar1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL1)'";

    $strSQL7 .= ' AND iv_date >= "'.$mar.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$mar1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL1)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$mar.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$mar1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL1)'";

    $strSQL9 .= ' AND iv_date >= "'.$mar.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$mar1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$mar.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$mar1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$mar.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$mar1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol1marf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol1marf = $sol1marf_vat/1.07;
	
$sol1marn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol1marn = $sol1marn_vat/1.07;

$solmar_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol_mar = $solmar_vat/1.07;
	
	
	
	//เดือนเมษา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL1)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$apr.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$apr1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL1)'";

    $strSQL7 .= ' AND iv_date >= "'.$apr.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$apr1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL1)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$apr.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$apr1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL1)'";

    $strSQL9 .= ' AND iv_date >= "'.$apr.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$apr1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$apr.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$apr1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$apr.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$apr1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol1aprf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol1aprf = $sol1aprf_vat/1.07;
	
$sol1aprn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol1aprn = $sol1aprn_vat/1.07;

$solapr_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol_apr = $solapr_vat/1.07;
	
	

	
//เดือนพฤษภา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL1)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$may.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$may1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL1)'";

    $strSQL7 .= ' AND iv_date >= "'.$may.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$may1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL1)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$may.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$may1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL1)'";

    $strSQL9 .= ' AND iv_date >= "'.$may.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$may1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$may.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$may1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$may.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$may1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol1mayf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol1mayf = $sol1mayf_vat/1.07;
	
$sol1mayn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol1mayn = $sol1mayn_vat/1.07;

$solmay_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol_may = $solmay_vat/1.07;
	
	
	
	//เดือนมิถุนา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL1)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$jun.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$jun1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL1)'";

    $strSQL7 .= ' AND iv_date >= "'.$jun.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$jun1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL1)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$jun.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$jun1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL1)'";

    $strSQL9 .= ' AND iv_date >= "'.$jun.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$jun1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$jun.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$jun1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$jun.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$jun1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol1junf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol1junf = $sol1junf_vat/1.07;
	
$sol1junn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol1junn = $sol1junn_vat/1.07;

$soljun_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol_jun = $soljun_vat/1.07;
	
	
	
$sumsol_haft = $sol_jun+$sol_may+$sol_apr+$sol_mar+$sol_feb+$sol_jan;
	
	
	
	//เดือนกรกฎา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL1)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$jul.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$jul1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL1)'";

    $strSQL7 .= ' AND iv_date >= "'.$jul.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$jul1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL1)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$jul.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$jul1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL1)'";

    $strSQL9 .= ' AND iv_date >= "'.$jul.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$jul1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$jul.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$jul1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$jul.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$jul1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol1julf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol1julf = $sol1julf_vat/1.07;
	
$sol1juln_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol1juln = $sol1juln_vat/1.07;

$soljul_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol_jul = $soljul_vat/1.07;
	
		
	
//เดือนสิงหา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL1)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$aug.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$aug1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL1)'";

    $strSQL7 .= ' AND iv_date >= "'.$aug.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$aug1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL1)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$aug.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$aug1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL1)'";

    $strSQL9 .= ' AND iv_date >= "'.$aug.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$aug1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$aug.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$aug1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$aug.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$aug1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol1augf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol1augf = $sol1augf_vat/1.07;
	
$sol1augn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol1augn = $sol1augn_vat/1.07;

$solaug_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol_aug = $solaug_vat/1.07;
	
	
//เดือนกันยา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL1)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$sep.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$sep1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL1)'";

    $strSQL7 .= ' AND iv_date >= "'.$sep.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$sep1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL1)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$sep.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$sep1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL1)'";

    $strSQL9 .= ' AND iv_date >= "'.$sep.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$sep1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$sep.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$sep1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$sep.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$sep1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol1sepf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol1sepf = $sol1sepf_vat/1.07;
	
$sol1sepn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol1sepn = $sol1sepn_vat/1.07;

$solsep_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol_sep = $solsep_vat/1.07;
	
	
	
//เดือนตุลาคม
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL1)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$oct.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$oct1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL1)'";

    $strSQL7 .= ' AND iv_date >= "'.$oct.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$oct1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL1)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$oct.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$oct1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL1)'";

    $strSQL9 .= ' AND iv_date >= "'.$oct.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$oct1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$oct.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$oct1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$oct.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$oct1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol1octf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol1octf = $sol1octf_vat/1.07;
	
$sol1octn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol1octn = $sol1octn_vat/1.07;

$soloct_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol_oct = $soloct_vat/1.07;
	
	
//เดือนพฤศจิ
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL1)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$nov.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$nov1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL1)'";

    $strSQL7 .= ' AND iv_date >= "'.$nov.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$nov1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL1)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$nov.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$nov1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL1)'";

    $strSQL9 .= ' AND iv_date >= "'.$nov.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$nov1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$nov.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$nov1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$nov.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$nov1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol1novf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol1novf = $sol1novf_vat/1.07;
	
$sol1novn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol1novn = $sol1novn_vat/1.07;

$solnov_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol_nov = $solnov_vat/1.07;
	
	
	
//เดือนธันวาคม
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL1)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$dec.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$dec1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL1)'";

    $strSQL7 .= ' AND iv_date >= "'.$dec.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$dec1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL1)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$dec.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$dec1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL1)'";

    $strSQL9 .= ' AND iv_date >= "'.$dec.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$dec1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$dec.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$dec1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL1)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$dec.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$dec1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol1decf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol1decf = $sol1decf_vat/1.07;
	
$sol1decn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol1decn = $sol1decn_vat/1.07;

$soldec_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol_dec = $soldec_vat/1.07;
	
$sumsol_haft1 = $sol_dec+$sol_jul+$sol_aug+$sol_sep+$sol_nov;
$sumsol_full	=$sumsol_haft1+$sumsol_haft;
	
	?>
	
	<tr>
<td  align="right" class="style30"><?php echo '(SOL1)'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol_jan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol_feb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol_mar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol_apr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol_may,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $sol_jun,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumsol_haft,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol_jul,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol_aug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol_sep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol_oct,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol_nov,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol_dec,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumsol_haft1,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $sumsol_full,2).""; ?></td> 

	</tr>
<?php

	//เดือนมกราSOL2
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL2)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$jan.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$jan1.'"'; 
 
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL2)'";

    $strSQL7 .= ' AND iv_date >= "'.$jan.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$jan1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL2)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$jan.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$jan1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL2)'";

    $strSQL9 .= ' AND iv_date >= "'.$jan.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$jan1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$jan.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$jan1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$jan.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$jan1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol2janf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol2janf = $sol2janf_vat/1.07;
	
$sol2jann_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol2jann = $sol2jann_vat/1.07;

$sol2jan_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol2_jan = $sol2jan_vat/1.07;
	
	
	//เดือนกุมภา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL2)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$feb.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$feb1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL2)'";

    $strSQL7 .= ' AND iv_date >= "'.$feb.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$feb1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL2)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$feb.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$feb1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL2)'";

    $strSQL9 .= ' AND iv_date >= "'.$feb.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$feb1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$feb.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$feb1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$feb.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$feb1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol2febf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol2febf = $sol2febf_vat/1.07;
	
$sol2febn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol2febn = $sol2febn_vat/1.07;

$sol2feb_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol2_feb = $sol2feb_vat/1.07;
	
	
	
	
	//เดือนมีนา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL2)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$mar.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$mar1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL2)'";

    $strSQL7 .= ' AND iv_date >= "'.$mar.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$mar1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL2)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$mar.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$mar1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL2)'";

    $strSQL9 .= ' AND iv_date >= "'.$mar.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$mar1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$mar.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$mar1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$mar.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$mar1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol2marf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol2marf = $sol2marf_vat/1.07;
	
$sol2marn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol2marn = $sol2marn_vat/1.07;

$sol2mar_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol2_mar = $sol2mar_vat/1.07;
	
	
	
	//เดือนเมษา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL2)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$apr.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$apr1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL2)'";

    $strSQL7 .= ' AND iv_date >= "'.$apr.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$apr1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL2)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$apr.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$apr1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL2)'";

    $strSQL9 .= ' AND iv_date >= "'.$apr.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$apr1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$apr.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$apr1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$apr.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$apr1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol2aprf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol2aprf = $sol2aprf_vat/1.07;
	
$sol2aprn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol2aprn = $sol2aprn_vat/1.07;

$sol2apr_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol2_apr = $sol2apr_vat/1.07;
	
	

	
//เดือนพฤษภา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL2)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$may.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$may1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL2)'";

    $strSQL7 .= ' AND iv_date >= "'.$may.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$may1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL2)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$may.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$may1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL2)'";

    $strSQL9 .= ' AND iv_date >= "'.$may.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$may1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$may.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$may1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$may.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$may1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol2mayf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol2mayf = $sol2mayf_vat/1.07;
	
$sol2mayn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol2mayn = $sol2mayn_vat/1.07;

$sol2may_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol2_may = $sol2may_vat/1.07;
	
	
	
	//เดือนมิถุนา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL2)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$jun.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$jun1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL2)'";

    $strSQL7 .= ' AND iv_date >= "'.$jun.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$jun1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL2)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$jun.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$jun1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL2)'";

    $strSQL9 .= ' AND iv_date >= "'.$jun.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$jun1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$jun.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$jun1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$jun.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$jun1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol2junf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol2junf = $sol2junf_vat/1.07;
	
$sol2junn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol2junn = $sol2junn_vat/1.07;

$sol2jun_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol2_jun = $sol2jun_vat/1.07;
	
	
	
$sumsol2_haft = $sol2_jun+$sol2_may+$sol2_apr+$sol2_mar+$sol2_feb+$sol2_jan;
	
	
	
	//เดือนกรกฎา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL2)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$jul.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$jul1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL2)'";

    $strSQL7 .= ' AND iv_date >= "'.$jul.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$jul1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL2)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$jul.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$jul1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL2)'";

    $strSQL9 .= ' AND iv_date >= "'.$jul.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$jul1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$jul.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$jul1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$jul.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$jul1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol2julf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol2julf = $sol2julf_vat/1.07;
	
$sol2juln_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol2juln = $sol2juln_vat/1.07;

$sol2jul_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol2_jul = $sol2jul_vat/1.07;
	
		
	
//เดือนสิงหา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL2)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$aug.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$aug1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL2)'";

    $strSQL7 .= ' AND iv_date >= "'.$aug.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$aug1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL2)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$aug.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$aug1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL2)'";

    $strSQL9 .= ' AND iv_date >= "'.$aug.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$aug1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$aug.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$aug1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$aug.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$aug1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol2augf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol2augf = $sol2augf_vat/1.07;
	
$sol2augn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol2augn = $sol2augn_vat/1.07;

$sol2aug_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol2_aug = $sol2aug_vat/1.07;
	
	
//เดือนกันยา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL2)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$sep.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$sep1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL2)'";

    $strSQL7 .= ' AND iv_date >= "'.$sep.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$sep1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL2)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$sep.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$sep1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL2)'";

    $strSQL9 .= ' AND iv_date >= "'.$sep.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$sep1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$sep.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$sep1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$sep.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$sep1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol2sepf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol2sepf = $sol2sepf_vat/1.07;
	
$sol2sepn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol2sepn = $sol2sepn_vat/1.07;

$sol2sep_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol2_sep = $sol2sep_vat/1.07;
	
	
	
//เดือนตุลาคม
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL2)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$oct.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$oct1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL2)'";

    $strSQL7 .= ' AND iv_date >= "'.$oct.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$oct1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL2)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$oct.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$oct1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL2)'";

    $strSQL9 .= ' AND iv_date >= "'.$oct.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$oct1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$oct.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$oct1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$oct.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$oct1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol2octf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol2octf = $sol2octf_vat/1.07;
	
$sol2octn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol2octn = $sol2octn_vat/1.07;

$sol2oct_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol2_oct = $sol2oct_vat/1.07;
	
	
//เดือนพฤศจิ
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL2)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$nov.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$nov1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL2)'";

    $strSQL7 .= ' AND iv_date >= "'.$nov.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$nov1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL2)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$nov.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$nov1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL2)'";

    $strSQL9 .= ' AND iv_date >= "'.$nov.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$nov1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$nov.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$nov1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$nov.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$nov1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol2novf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol2novf = $sol2novf_vat/1.07;
	
$sol2novn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol2novn = $sol2novn_vat/1.07;

$sol2nov_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol2_nov = $sol2nov_vat/1.07;
	
	
	
//เดือนธันวาคม
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL2)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$dec.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$dec1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL2)'";

    $strSQL7 .= ' AND iv_date >= "'.$dec.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$dec1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL2)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$dec.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$dec1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL2)'";

    $strSQL9 .= ' AND iv_date >= "'.$dec.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$dec1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$dec.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$dec1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL2)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$dec.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$dec1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol2decf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol2decf = $sol2decf_vat/1.07;
	
$sol2decn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol2decn = $sol2decn_vat/1.07;

$sol2dec_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol2_dec = $sol2dec_vat/1.07;
	
$sumsol2_haft1 = $sol2_dec+$sol2_jul+$sol2_aug+$sol2_sep+$sol2_nov;
$sumsol2_full	=$sumsol2_haft1+$sumsol2_haft;
	
	?>
	
	<tr>
<td  align="right" class="style30"><?php echo '(SOL2)'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2_jan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2_feb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2_mar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol2_apr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol2_may,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $sol2_jun,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumsol2_haft,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2_jul,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol2_aug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2_sep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2_oct,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2_nov,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol2_dec,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumsol2_haft1,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $sumsol2_full,2).""; ?></td> 

	</tr>


	

<?php

	//เดือนมกราSOL3
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = 'SOL3'";

    $strSQL5 .= ' AND doc_release_date >= "'.$jan.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$jan1.'"'; 
 
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = 'SOL3'";

    $strSQL7 .= ' AND iv_date >= "'.$jan.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$jan1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = 'SOL3'";

    $strSQL8 .= ' AND doc_release_date >= "'.$jan.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$jan1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = 'SOL3'";

    $strSQL9 .= ' AND iv_date >= "'.$jan.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$jan1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$jan.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$jan1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$jan.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$jan1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol3janf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol3janf = $sol3janf_vat/1.07;
	
$sol3jann_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol3jann = $sol3jann_vat/1.07;

$sol3jan_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol3_jan = $sol3jan_vat/1.07;
	
	
	//เดือนกุมภา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = 'SOL3'";

    $strSQL5 .= ' AND doc_release_date >= "'.$feb.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$feb1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = 'SOL3'";

    $strSQL7 .= ' AND iv_date >= "'.$feb.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$feb1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = 'SOL3'";

    $strSQL8 .= ' AND doc_release_date >= "'.$feb.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$feb1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = 'SOL3'";

    $strSQL9 .= ' AND iv_date >= "'.$feb.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$feb1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$feb.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$feb1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$feb.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$feb1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol3febf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol3febf = $sol3febf_vat/1.07;
	
$sol3febn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol3febn = $sol3febn_vat/1.07;

$sol3feb_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol3_feb = $sol3feb_vat/1.07;
	
	
	
	
	//เดือนมีนา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = 'SOL3'";

    $strSQL5 .= ' AND doc_release_date >= "'.$mar.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$mar1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = 'SOL3'";

    $strSQL7 .= ' AND iv_date >= "'.$mar.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$mar1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = 'SOL3'";

    $strSQL8 .= ' AND doc_release_date >= "'.$mar.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$mar1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = 'SOL3'";

    $strSQL9 .= ' AND iv_date >= "'.$mar.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$mar1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$mar.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$mar1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$mar.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$mar1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol3marf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol3marf = $sol3marf_vat/1.07;
	
$sol3marn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol3marn = $sol3marn_vat/1.07;

$sol3mar_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol3_mar = $sol3mar_vat/1.07;
	
	
	
	//เดือนเมษา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = 'SOL3'";

    $strSQL5 .= ' AND doc_release_date >= "'.$apr.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$apr1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = 'SOL3'";

    $strSQL7 .= ' AND iv_date >= "'.$apr.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$apr1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = 'SOL3'";

    $strSQL8 .= ' AND doc_release_date >= "'.$apr.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$apr1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = 'SOL3'";

    $strSQL9 .= ' AND iv_date >= "'.$apr.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$apr1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$apr.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$apr1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$apr.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$apr1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol3aprf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol3aprf = $sol3aprf_vat/1.07;
	
$sol3aprn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol3aprn = $sol3aprn_vat/1.07;

$sol3apr_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol3_apr = $sol3apr_vat/1.07;
	
	

	
//เดือนพฤษภา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = 'SOL3'";

    $strSQL5 .= ' AND doc_release_date >= "'.$may.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$may1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = 'SOL3'";

    $strSQL7 .= ' AND iv_date >= "'.$may.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$may1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = 'SOL3'";

    $strSQL8 .= ' AND doc_release_date >= "'.$may.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$may1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = 'SOL3'";

    $strSQL9 .= ' AND iv_date >= "'.$may.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$may1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$may.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$may1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$may.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$may1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol3mayf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol3mayf = $sol3mayf_vat/1.07;
	
$sol3mayn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol3mayn = $sol3mayn_vat/1.07;

$sol3may_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol3_may = $sol3may_vat/1.07;
	
	
	
	//เดือนมิถุนา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = 'SOL3'";

    $strSQL5 .= ' AND doc_release_date >= "'.$jun.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$jun1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = 'SOL3'";

    $strSQL7 .= ' AND iv_date >= "'.$jun.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$jun1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = 'SOL3'";

    $strSQL8 .= ' AND doc_release_date >= "'.$jun.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$jun1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = 'SOL3'";

    $strSQL9 .= ' AND iv_date >= "'.$jun.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$jun1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$jun.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$jun1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$jun.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$jun1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol3junf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol3junf = $sol3junf_vat/1.07;
	
$sol3junn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol3junn = $sol3junn_vat/1.07;

$sol3jun_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol3_jun = $sol3jun_vat/1.07;
	
	
	
$sumsol3_haft = $sol3_jun+$sol3_may+$sol3_apr+$sol3_mar+$sol3_feb+$sol3_jan;
	
	
	
	//เดือนกรกฎา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = 'SOL3'";

    $strSQL5 .= ' AND doc_release_date >= "'.$jul.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$jul1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = 'SOL3'";

    $strSQL7 .= ' AND iv_date >= "'.$jul.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$jul1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = 'SOL3'";

    $strSQL8 .= ' AND doc_release_date >= "'.$jul.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$jul1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = 'SOL3'";

    $strSQL9 .= ' AND iv_date >= "'.$jul.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$jul1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$jul.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$jul1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$jul.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$jul1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol3julf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol3julf = $sol3julf_vat/1.07;
	
$sol3juln_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol3juln = $sol3juln_vat/1.07;

$sol3jul_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol3_jul = $sol3jul_vat/1.07;
	
		
	
//เดือนสิงหา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = 'SOL3'";

    $strSQL5 .= ' AND doc_release_date >= "'.$aug.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$aug1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = 'SOL3'";

    $strSQL7 .= ' AND iv_date >= "'.$aug.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$aug1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = 'SOL3'";

    $strSQL8 .= ' AND doc_release_date >= "'.$aug.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$aug1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = 'SOL3'";

    $strSQL9 .= ' AND iv_date >= "'.$aug.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$aug1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$aug.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$aug1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$aug.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$aug1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol3augf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol3augf = $sol3augf_vat/1.07;
	
$sol3augn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol3augn = $sol3augn_vat/1.07;

$sol3aug_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol3_aug = $sol3aug_vat/1.07;
	
	
//เดือนกันยา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = 'SOL3'";

    $strSQL5 .= ' AND doc_release_date >= "'.$sep.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$sep1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = 'SOL3'";

    $strSQL7 .= ' AND iv_date >= "'.$sep.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$sep1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = 'SOL3'";

    $strSQL8 .= ' AND doc_release_date >= "'.$sep.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$sep1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = 'SOL3'";

    $strSQL9 .= ' AND iv_date >= "'.$sep.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$sep1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$sep.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$sep1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$sep.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$sep1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol3sepf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol3sepf = $sol3sepf_vat/1.07;
	
$sol3sepn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol3sepn = $sol3sepn_vat/1.07;

$sol3sep_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol3_sep = $sol3sep_vat/1.07;
	
	
	
//เดือนตุลาคม
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = 'SOL3'";

    $strSQL5 .= ' AND doc_release_date >= "'.$oct.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$oct1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = 'SOL3'";

    $strSQL7 .= ' AND iv_date >= "'.$oct.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$oct1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = 'SOL3'";

    $strSQL8 .= ' AND doc_release_date >= "'.$oct.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$oct1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = 'SOL3'";

    $strSQL9 .= ' AND iv_date >= "'.$oct.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$oct1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$oct.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$oct1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$oct.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$oct1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol3octf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol3octf = $sol3octf_vat/1.07;
	
$sol3octn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol3octn = $sol3octn_vat/1.07;

$sol3oct_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol3_oct = $sol3oct_vat/1.07;
	
	
//เดือนพฤศจิ
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = 'SOL3'";

    $strSQL5 .= ' AND doc_release_date >= "'.$nov.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$nov1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = 'SOL3'";

    $strSQL7 .= ' AND iv_date >= "'.$nov.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$nov1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = 'SOL3'";

    $strSQL8 .= ' AND doc_release_date >= "'.$nov.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$nov1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = 'SOL3'";

    $strSQL9 .= ' AND iv_date >= "'.$nov.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$nov1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$nov.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$nov1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$nov.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$nov1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol3novf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol3novf = $sol3novf_vat/1.07;
	
$sol3novn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol3novn = $sol3novn_vat/1.07;

$sol3nov_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol3_nov = $sol3nov_vat/1.07;
	
	
	
//เดือนธันวาคม
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = 'SOL3'";

    $strSQL5 .= ' AND doc_release_date >= "'.$dec.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$dec1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = 'SOL3'";

    $strSQL7 .= ' AND iv_date >= "'.$dec.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$dec1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = 'SOL3'";

    $strSQL8 .= ' AND doc_release_date >= "'.$dec.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$dec1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = 'SOL3'";

    $strSQL9 .= ' AND iv_date >= "'.$dec.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$dec1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$dec.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$dec1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = 'SOL3' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$dec.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$dec1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol3decf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol3decf = $sol3decf_vat/1.07;
	
$sol3decn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol3decn = $sol3decn_vat/1.07;

$sol3dec_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol3_dec = $sol3dec_vat/1.07;
	
$sumsol3_haft1 = $sol3_dec+$sol3_jul+$sol3_aug+$sol3_sep+$sol3_nov;
$sumsol3_full	=$sumsol3_haft1+$sumsol3_haft;
	
	?>
	
	<tr>
<td  align="right" class="style30"><?php echo 'SOL3'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3_jan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3_feb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3_mar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol3_apr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol3_may,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $sol3_jun,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumsol3_haft,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3_jul,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol3_aug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3_sep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3_oct,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3_nov,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol3_dec,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumsol3_haft1,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $sumsol3_full,2).""; ?></td> 

	</tr>

<?php

	//เดือนมกราSOL99
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL99)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$jan.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$jan1.'"'; 
 
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL99)'";

    $strSQL7 .= ' AND iv_date >= "'.$jan.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$jan1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL99)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$jan.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$jan1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL99)'";

    $strSQL9 .= ' AND iv_date >= "'.$jan.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$jan1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$jan.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$jan1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$jan.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$jan1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol9janf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol9janf = $sol9janf_vat/1.07;
	
$sol9jann_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol9jann = $sol9jann_vat/1.07;

$sol9jan_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol9_jan = $sol9jan_vat/1.07;
	
	
	//เดือนกุมภา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL99)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$feb.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$feb1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL99)'";

    $strSQL7 .= ' AND iv_date >= "'.$feb.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$feb1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL99)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$feb.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$feb1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL99)'";

    $strSQL9 .= ' AND iv_date >= "'.$feb.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$feb1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$feb.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$feb1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$feb.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$feb1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol9febf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol9febf = $sol9febf_vat/1.07;
	
$sol9febn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol9febn = $sol9febn_vat/1.07;

$sol9feb_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol9_feb = $sol9feb_vat/1.07;
	
	
	
	
	//เดือนมีนา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL99)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$mar.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$mar1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL99)'";

    $strSQL7 .= ' AND iv_date >= "'.$mar.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$mar1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL99)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$mar.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$mar1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL99)'";

    $strSQL9 .= ' AND iv_date >= "'.$mar.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$mar1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$mar.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$mar1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$mar.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$mar1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol9marf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol9marf = $sol9marf_vat/1.07;
	
$sol9marn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol9marn = $sol9marn_vat/1.07;

$sol9mar_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol9_mar = $sol9mar_vat/1.07;
	
	
	
	//เดือนเมษา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL99)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$apr.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$apr1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL99)'";

    $strSQL7 .= ' AND iv_date >= "'.$apr.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$apr1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL99)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$apr.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$apr1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL99)'";

    $strSQL9 .= ' AND iv_date >= "'.$apr.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$apr1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$apr.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$apr1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$apr.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$apr1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol9aprf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol9aprf = $sol9aprf_vat/1.07;
	
$sol9aprn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol9aprn = $sol9aprn_vat/1.07;

$sol9apr_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol9_apr = $sol9apr_vat/1.07;
	
	

	
//เดือนพฤษภา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL99)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$may.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$may1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL99)'";

    $strSQL7 .= ' AND iv_date >= "'.$may.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$may1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL99)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$may.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$may1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL99)'";

    $strSQL9 .= ' AND iv_date >= "'.$may.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$may1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$may.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$may1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$may.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$may1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol9mayf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol9mayf = $sol9mayf_vat/1.07;
	
$sol9mayn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol9mayn = $sol9mayn_vat/1.07;

$sol9may_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol9_may = $sol9may_vat/1.07;
	
	
	
	//เดือนมิถุนา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL99)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$jun.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$jun1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL99)'";

    $strSQL7 .= ' AND iv_date >= "'.$jun.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$jun1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL99)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$jun.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$jun1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL99)'";

    $strSQL9 .= ' AND iv_date >= "'.$jun.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$jun1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$jun.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$jun1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$jun.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$jun1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol9junf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol9junf = $sol9junf_vat/1.07;
	
$sol9junn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol9junn = $sol9junn_vat/1.07;

$sol9jun_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol9_jun = $sol9jun_vat/1.07;
	
	
	
$sumsol9_haft = $sol9_jun+$sol9_may+$sol9_apr+$sol9_mar+$sol9_feb+$sol9_jan;
	
	
	
	//เดือนกรกฎา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL99)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$jul.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$jul1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL99)'";

    $strSQL7 .= ' AND iv_date >= "'.$jul.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$jul1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL99)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$jul.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$jul1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL99)'";

    $strSQL9 .= ' AND iv_date >= "'.$jul.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$jul1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$jul.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$jul1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$jul.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$jul1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol9julf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol9julf = $sol9julf_vat/1.07;
	
$sol9juln_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol9juln = $sol9juln_vat/1.07;

$sol9jul_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol9_jul = $sol9jul_vat/1.07;
	
		
	
//เดือนสิงหา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL99)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$aug.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$aug1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL99)'";

    $strSQL7 .= ' AND iv_date >= "'.$aug.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$aug1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL99)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$aug.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$aug1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL99)'";

    $strSQL9 .= ' AND iv_date >= "'.$aug.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$aug1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$aug.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$aug1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$aug.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$aug1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol9augf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol9augf = $sol9augf_vat/1.07;
	
$sol9augn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol9augn = $sol9augn_vat/1.07;

$sol9aug_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol9_aug = $sol9aug_vat/1.07;
	
	
//เดือนกันยา
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL99)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$sep.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$sep1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL99)'";

    $strSQL7 .= ' AND iv_date >= "'.$sep.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$sep1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL99)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$sep.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$sep1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL99)'";

    $strSQL9 .= ' AND iv_date >= "'.$sep.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$sep1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$sep.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$sep1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$sep.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$sep1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol9sepf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol9sepf = $sol9sepf_vat/1.07;
	
$sol9sepn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol9sepn = $sol9sepn_vat/1.07;

$sol9sep_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol9_sep = $sol9sep_vat/1.07;
	
	
	
//เดือนตุลาคม
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL99)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$oct.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$oct1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL99)'";

    $strSQL7 .= ' AND iv_date >= "'.$oct.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$oct1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL99)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$oct.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$oct1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL99)'";

    $strSQL9 .= ' AND iv_date >= "'.$oct.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$oct1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$oct.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$oct1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$oct.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$oct1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol9octf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol9octf = $sol9octf_vat/1.07;
	
$sol9octn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol9octn = $sol9octn_vat/1.07;

$sol9oct_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol9_oct = $sol9oct_vat/1.07;
	
	
//เดือนพฤศจิ
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL99)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$nov.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$nov1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL99)'";

    $strSQL7 .= ' AND iv_date >= "'.$nov.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$nov1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL99)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$nov.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$nov1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL99)'";

    $strSQL9 .= ' AND iv_date >= "'.$nov.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$nov1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$nov.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$nov1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$nov.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$nov1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol9novf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol9novf = $sol9novf_vat/1.07;
	
$sol9novn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol9novn = $sol9novn_vat/1.07;

$sol9nov_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol9_nov = $sol9nov_vat/1.07;
	
	
	
//เดือนธันวาคม
	
	$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '3' and employee_name = '(SOL99)'";

    $strSQL5 .= ' AND doc_release_date >= "'.$dec.'"'; 
    $strSQL5 .= ' AND doc_release_date <= "'.$dec1.'"'; 
 
	//echo $strSQL5;
	//exit();
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);


$strSQL7 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '1'  and employee_name = '(SOL99)'";

    $strSQL7 .= ' AND iv_date >= "'.$dec.'"'; 
    $strSQL7.= ' AND iv_date <= "'.$dec1.'"'; 
    
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$objResult7 = mysqli_fetch_array($objQuery7);
	
	$strSQL8 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE cancel_ckk ='0' and select_type_doc = '4'  and employee_name = '(SOL99)'";

    $strSQL8 .= ' AND doc_release_date >= "'.$dec.'"'; 
    $strSQL8 .= ' AND doc_release_date <= "'.$dec1.'"'; 
     


$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$objResult8 = mysqli_fetch_array($objQuery8);


$strSQL9 = "SELECT SUM(sum_amount)  as total1  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE iv_no !='' and cancel_ckk ='0' and select_type_doc = '2'  and employee_name = '(SOL99)'";

    $strSQL9 .= ' AND iv_date >= "'.$dec.'"'; 
    $strSQL9.= ' AND iv_date <= "'.$dec1.'"'; 
    
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);

$strSQL6 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '3' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL6 .= ' AND date_credit >= "'.$dec.'"'; 

$strSQL6 .= ' AND date_credit <= "'.$dec1.'"'; 

$objQuery6 = mysqli_query($conn,$strSQL6);
$objResult6 = mysqli_fetch_array($objQuery6);
	
$strSQL61 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE company_type = '4' and sale_code = '(SOL99)' and status_doc = 'Approve'";

$strSQL61 .= ' AND date_credit >= "'.$dec.'"'; 

$strSQL61 .= ' AND date_credit <= "'.$dec1.'"'; 

$objQuery61 = mysqli_query($conn,$strSQL61);
$objResult61 = mysqli_fetch_array($objQuery61);

$sol9decf_vat = ($objResult5['total']+$objResult7['total1'])-$objResult6['sum_amount1'];
$sol9decf = $sol9decf_vat/1.07;
	
$sol9decn_vat = ($objResult8['total']+$objResult9['total1'])-$objResult61['sum_amount1'];
$sol9decn = $sol9decn_vat/1.07;

$sol9dec_vat = ($objResult5['total']+$objResult7['total1']+$objResult8['total']+$objResult9['total1'])-($objResult6['sum_amount1']+$objResult61['sum_amount1']);
$sol9_dec = $sol9dec_vat/1.07;
	
$sumsol9_haft1 = $sol9_dec+$sol9_jul+$sol9_aug+$sol9_sep+$sol9_nov;
$sumsol9_full	=$sumsol9_haft1+$sumsol9_haft;
	
	?>
	
	<tr>
<td  align="right" class="style30"><?php echo '(SOL99)'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9_jan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9_feb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9_mar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol9_apr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol9_may,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $sol9_jun,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumsol9_haft,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9_jul,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol9_aug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9_sep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9_oct,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9_nov,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol9_dec,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumsol9_haft1,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $sumsol9_full,2).""; ?></td> 

	</tr>

	
<?php 
	
	//มกรา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

$strSQL10 .= ' AND iv_date >= "'.$jan.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$jan1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	
$strSQL11 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '3124' and status_doc ='Approve' ";

$strSQL11 .= ' AND iv_date >= "'.$jan.'"'; 

$strSQL11 .= ' AND iv_date <= "'.$jan1.'"'; 


$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

$strSQL12 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '1023' and status_doc ='Approve' ";

$strSQL12 .= ' AND iv_date >= "'.$jan.'"'; 

$strSQL12 .= ' AND iv_date <= "'.$jan1.'"'; 

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	

$phar_jan = $objResult11["total"]/1.07;
$nb_jan = $objResult12["total"]/1.07;
$sumjan_ham = ($objResult11["total"]+$objResult12["total"])/1.07;
$sum_jan = $sol9_jan+$sol2_jan+$sol3_jan+$sol_jan+($objResult10["total"]/1.07);
$summary_jan = $sum_jan-$sumjan_ham;
	
		
			
//กุมภา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

$strSQL10 .= ' AND iv_date >= "'.$feb.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$feb1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	
$strSQL11 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '3124' and status_doc ='Approve' ";

$strSQL11 .= ' AND iv_date >= "'.$feb.'"'; 

$strSQL11 .= ' AND iv_date <= "'.$feb1.'"'; 


$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

$strSQL12 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '1023' and status_doc ='Approve' ";

$strSQL12 .= ' AND iv_date >= "'.$feb.'"'; 

$strSQL12 .= ' AND iv_date <= "'.$feb1.'"'; 

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	

$phar_feb = $objResult11["total"]/1.07;
$nb_feb = $objResult12["total"]/1.07;
$sumfeb_ham = ($objResult11["total"]+$objResult12["total"])/1.07;
$sum_feb = $sol9_feb+$sol2_feb+$sol3_feb+$sol_feb+($objResult10["total"]/1.07);
$summary_feb = $sum_feb-$sumfeb_ham;
	
		
//มีนา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

$strSQL10 .= ' AND iv_date >= "'.$mar.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$mar1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	
$strSQL11 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '3124' and status_doc ='Approve' ";

$strSQL11 .= ' AND iv_date >= "'.$mar.'"'; 

$strSQL11 .= ' AND iv_date <= "'.$mar1.'"'; 


$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

$strSQL12 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '1023' and status_doc ='Approve' ";

$strSQL12 .= ' AND iv_date >= "'.$mar.'"'; 

$strSQL12 .= ' AND iv_date <= "'.$mar1.'"'; 

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	

$phar_mar = $objResult11["total"]/1.07;
$nb_mar = $objResult12["total"]/1.07;
$summar_ham = ($objResult11["total"]+$objResult12["total"])/1.07;
$sum_mar = $sol9_mar+$sol2_mar+$sol3_mar+$sol_mar+($objResult10["total"]/1.07);
$summary_mar = $sum_mar-$summar_ham;
	
	
		
//เมษา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

$strSQL10 .= ' AND iv_date >= "'.$apr.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$apr1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	
$strSQL11 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '3124' and status_doc ='Approve' ";

$strSQL11 .= ' AND iv_date >= "'.$apr.'"'; 

$strSQL11 .= ' AND iv_date <= "'.$apr1.'"'; 


$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

$strSQL12 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '1023' and status_doc ='Approve' ";

$strSQL12 .= ' AND iv_date >= "'.$apr.'"'; 

$strSQL12 .= ' AND iv_date <= "'.$apr1.'"'; 

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	

$phar_apr = $objResult11["total"]/1.07;
$nb_apr = $objResult12["total"]/1.07;
$sumapr_ham = ($objResult11["total"]+$objResult12["total"])/1.07;
$sum_apr = $sol9_apr+$sol2_apr+$sol3_apr+$sol_apr+($objResult10["total"]/1.07);
$summary_apr = $sum_apr-$sumapr_ham;
				
	
//พฤษภา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

$strSQL10 .= ' AND iv_date >= "'.$may.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$may1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	
$strSQL11 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '3124' and status_doc ='Approve' ";

$strSQL11 .= ' AND iv_date >= "'.$may.'"'; 

$strSQL11 .= ' AND iv_date <= "'.$may1.'"'; 


$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

$strSQL12 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '1023' and status_doc ='Approve' ";

$strSQL12 .= ' AND iv_date >= "'.$may.'"'; 

$strSQL12 .= ' AND iv_date <= "'.$may1.'"'; 

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	

$phar_may = $objResult11["total"]/1.07;
$nb_may = $objResult12["total"]/1.07;
$summay_ham = ($objResult11["total"]+$objResult12["total"])/1.07;
$sum_may = $sol9_may+$sol2_may+$sol3_may+$sol_may+($objResult10["total"]/1.07);
$summary_may = $sum_may-$summay_ham;
			
//มิถุนา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

$strSQL10 .= ' AND iv_date >= "'.$jun.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$jun1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	
$strSQL11 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '3124' and status_doc ='Approve' ";

$strSQL11 .= ' AND iv_date >= "'.$jun.'"'; 

$strSQL11 .= ' AND iv_date <= "'.$jun1.'"'; 


$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

$strSQL12 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '1023' and status_doc ='Approve' ";

$strSQL12 .= ' AND iv_date >= "'.$jun.'"'; 

$strSQL12 .= ' AND iv_date <= "'.$jun1.'"'; 

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	

$phar_jun = $objResult11["total"]/1.07;
$nb_jun = $objResult12["total"]/1.07;
$sumjun_ham = ($objResult11["total"]+$objResult12["total"])/1.07;
$sum_jun = $sol9_jun+$sol2_jun+$sol3_jun+$sol_jun+($objResult10["total"]/1.07);
$summary_jun = $sum_jun-$sumjun_ham;

$sum_ham1 = $sumjun_ham+$sumjan_ham+$sumfeb_ham+$summar_ham+$sumapr_ham+$summay_ham;
$sum_1 = $sum_jun+$sum_jan+$sum_feb+$sum_mar+$sum_apr+$sum_may;	
$summary_1 = $summary_jun+$summary_jan+$summary_may+$summary_apr+$summary_mar+$summary_feb;
		
	
//กรกฎา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

$strSQL10 .= ' AND iv_date >= "'.$jul.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$jul1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	
$strSQL11 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '3124' and status_doc ='Approve' ";

$strSQL11 .= ' AND iv_date >= "'.$jul.'"'; 

$strSQL11 .= ' AND iv_date <= "'.$jul1.'"'; 


$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

$strSQL12 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '1023' and status_doc ='Approve' ";

$strSQL12 .= ' AND iv_date >= "'.$jul.'"'; 

$strSQL12 .= ' AND iv_date <= "'.$jul1.'"'; 

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	

$phar_jul = $objResult11["total"]/1.07;
$nb_jul = $objResult12["total"]/1.07;
$sumjul_ham = ($objResult11["total"]+$objResult12["total"])/1.07;
$sum_jul = $sol9_jul+$sol2_jul+$sol3_jul+$sol_jul+($objResult10["total"]/1.07);
$summary_jul = $sum_jul-$sumjul_ham;

	
//สิงหา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

$strSQL10 .= ' AND iv_date >= "'.$aug.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$aug1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	
$strSQL11 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '3124' and status_doc ='Approve' ";

$strSQL11 .= ' AND iv_date >= "'.$aug.'"'; 

$strSQL11 .= ' AND iv_date <= "'.$aug1.'"'; 


$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

$strSQL12 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '1023' and status_doc ='Approve' ";

$strSQL12 .= ' AND iv_date >= "'.$aug.'"'; 

$strSQL12 .= ' AND iv_date <= "'.$aug1.'"'; 

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	

$phar_aug = $objResult11["total"]/1.07;
$nb_aug = $objResult12["total"]/1.07;
$sumaug_ham = ($objResult11["total"]+$objResult12["total"])/1.07;
$sum_aug = $sol9_aug+$sol2_aug+$sol3_aug+$sol_aug+($objResult10["total"]/1.07);
$summary_aug = $sum_aug-$sumaug_ham;
	
	
//กันยา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

$strSQL10 .= ' AND iv_date >= "'.$sep.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$sep1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	
$strSQL11 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '3124' and status_doc ='Approve' ";

$strSQL11 .= ' AND iv_date >= "'.$sep.'"'; 

$strSQL11 .= ' AND iv_date <= "'.$sep1.'"'; 


$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

$strSQL12 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '1023' and status_doc ='Approve' ";

$strSQL12 .= ' AND iv_date >= "'.$sep.'"'; 

$strSQL12 .= ' AND iv_date <= "'.$sep1.'"'; 

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	

$phar_sep = $objResult11["total"]/1.07;
$nb_sep = $objResult12["total"]/1.07;
$sumsep_ham = ($objResult11["total"]+$objResult12["total"])/1.07;
$sum_sep = $sol9_sep+$sol2_sep+$sol3_sep+$sol_sep+($objResult10["total"]/1.07);
$summary_sep = $sum_sep-$sumsep_ham;
				
			
	
//ตุลาคม
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

$strSQL10 .= ' AND iv_date >= "'.$oct.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$oct1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	
$strSQL11 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '3124' and status_doc ='Approve' ";

$strSQL11 .= ' AND iv_date >= "'.$oct.'"'; 

$strSQL11 .= ' AND iv_date <= "'.$oct1.'"'; 


$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

$strSQL12 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '1023' and status_doc ='Approve' ";

$strSQL12 .= ' AND iv_date >= "'.$oct.'"'; 

$strSQL12 .= ' AND iv_date <= "'.$oct1.'"'; 

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	

$phar_oct = $objResult11["total"]/1.07;
$nb_oct = $objResult12["total"]/1.07;
$sumoct_ham = ($objResult11["total"]+$objResult12["total"])/1.07;
$sum_oct = $sol9_oct+$sol2_oct+$sol3_oct+$sol_oct+($objResult10["total"]/1.07);
$summary_oct = $sum_oct-$sumoct_ham;
				
	
//พฤศจิกา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

$strSQL10 .= ' AND iv_date >= "'.$nov.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$nov1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	
$strSQL11 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '3124' and status_doc ='Approve' ";

$strSQL11 .= ' AND iv_date >= "'.$nov.'"'; 

$strSQL11 .= ' AND iv_date <= "'.$nov1.'"'; 


$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

$strSQL12 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '1023' and status_doc ='Approve' ";

$strSQL12 .= ' AND iv_date >= "'.$nov.'"'; 

$strSQL12 .= ' AND iv_date <= "'.$nov1.'"'; 

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	

$phar_nov = $objResult11["total"]/1.07;
$nb_nov = $objResult12["total"]/1.07;
$sumnov_ham = ($objResult11["total"]+$objResult12["total"])/1.07;
$sum_nov = $sol9_nov+$sol2_nov+$sol3_nov+$sol_nov+($objResult10["total"]/1.07);
$summary_nov = $sum_nov-$sumnov_ham;
				

//ธันวา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' ";

$strSQL10 .= ' AND iv_date >= "'.$dec.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$dec1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	
$strSQL11 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '3124' and status_doc ='Approve' ";

$strSQL11 .= ' AND iv_date >= "'.$dec.'"'; 

$strSQL11 .= ' AND iv_date <= "'.$dec1.'"'; 


$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$objResult11 = mysqli_fetch_array($objQuery11);

$strSQL12 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE bill_id = '1023' and status_doc ='Approve' ";

$strSQL12 .= ' AND iv_date >= "'.$dec.'"'; 

$strSQL12 .= ' AND iv_date <= "'.$dec1.'"'; 

$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);
	

$phar_dec = $objResult11["total"]/1.07;
$nb_dec = $objResult12["total"]/1.07;
$sumdec_ham = ($objResult11["total"]+$objResult12["total"])/1.07;
$sum_dec = $sol9_dec+$sol2_dec+$sol3_dec+$sol_dec+($objResult10["total"]/1.07);
$summary_dec = $sum_dec-$sumdec_ham;
				
	
	
$sum_ham2 = $sumjul_ham+$sumaug_ham+$sumsep_ham+$sumoct_ham+$sumnov_ham+$sumdec_ham;
$sum_2 = $sum_jul+$sum_aug+$sum_sep+$sum_oct+$sum_nov+$sum_dec;	
$summary_2 = $summary_jul+$summary_aug+$summary_sep+$summary_oct+$summary_nov+$summary_dec;		

$sum_ham_all = $sum_ham2+$sum_ham1;
$sum_all = 	$sum_2+$sum_1;
$summary_all = $summary_2+$summary_1;
	
	
	?>
	
	<tr>
<td  align="right" class="style30"><?php echo 'Total'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_jan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_feb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_mar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sum_apr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sum_may,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $sum_jun,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sum_1,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_jul,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sum_aug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_sep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_oct,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_nov,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sum_dec,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sum_2,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $sum_all,2).""; ?></td> 

		
	</tr>
	
<tr>
<td  align="right" class="style30"><?php echo 'หัก'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumjan_ham,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumfeb_ham,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $summar_ham,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sumapr_ham,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $summay_ham,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $sumjun_ham,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sum_ham1,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumjul_ham,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sumaug_ham,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumsep_ham,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumoct_ham,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumnov_ham,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sumdec_ham,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sum_ham2,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $sum_ham_all,2).""; ?></td> 

	</tr>

	<tr>
<td  align="right" class="style30"><?php echo 'คงเหลือ'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $summary_jan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $summary_feb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $summary_mar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $summary_apr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $summary_may,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $summary_jun,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $summary_1,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $summary_jul,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $summary_aug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $summary_sep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $summary_oct,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $summary_nov,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $summary_dec,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $summary_2,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $summary_all,2).""; ?></td> 

	</tr>



</table>


</p></p>
	<center>
<span class="style15"><?php echo "Actual Phartrillion" ; echo $year; ?></span>
</center>
</p>


</p>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="6%" align="center" class="style30">Actual</td>
<td width="6%" align="center" class="style30">Jan</td>
<td width="6%" align="center" class="style30">Feb</td>
<td width="6%" align="center" class="style30">Mar</td> 
<td width="6%" align="center" class="style30">Apr</td> 
<td width="6%" align="center" class="style30">May</td> 
<td width="6%" align="center" class="style30">Jun</td> 
<td width="6%" bgcolor="#BEBEBE" align="center" class="style30">Total 1-6</td> 
<td width="6%" align="center" class="style30">Jul</td>
<td width="6%" align="center" class="style30">Aug</td>
<td width="6%" align="center" class="style30">Sep</td>
<td width="6%" align="center" class="style30">Oct</td> 
<td width="6%" align="center" class="style30">Nov</td> 
<td width="6%" align="center" class="style30">Dec</td> 
<td width="6%" bgcolor="#BEBEBE" align="center" class="style30">Total 7-12</td> 
<td width="6%" bgcolor="#9ACD32" align="center" class="style30">TOTAL 1-12</td> 



	</tr>

<?php


$strSQL ="SELECT * FROM tb_team_adm where ckk='0' ";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$sale_code = $objResult["sale_code"];

//S11

//มกราคม
$strSQL1 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0' and type_doc = '3'";

$strSQL1 .= ' AND iv_date >= "'.$jan.'"'; 

$strSQL1 .= ' AND iv_date <= "'.$jan1.'"'; 


$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



	$strSQL2 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '3'";

$strSQL2 .= ' AND iv_date >= "'.$jan.'"'; 

$strSQL2 .= ' AND iv_date <= "'.$jan1.'"'; 

$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");

$objResult2 = mysqli_fetch_array($objQuery2);


$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '3'";

$strSQL5 .= ' AND date_credit >= "'.$jan.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$jan1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11jan_vat=($objResult1['total']+$objResult2['total1'])-$objResult5['sum_amount1'];

$S11jan = $S11jan_vat/1.07;

//กุมภา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '3'";

$strSQL3 .= ' AND iv_date >= "'.$feb.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$feb1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '3'";

$strSQL4 .= ' AND iv_date >= "'.$feb.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$feb1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '3'";

$strSQL5 .= ' AND date_credit >= "'.$feb.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$feb1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);


$S11feb_vat =($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11feb = $S11feb_vat/1.07;
	
//มีนา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '3'";

$strSQL3 .= ' AND iv_date >= "'.$mar.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$mar1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '3'";

$strSQL4 .= ' AND iv_date >= "'.$mar.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$mar1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '3'";

$strSQL5 .= ' AND date_credit >= "'.$mar.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$mar1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11mar_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11mar = $S11mar_vat/1.07;


//เมษา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '3'";

$strSQL3 .= ' AND iv_date >= "'.$apr.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$apr1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '3'";

$strSQL4 .= ' AND iv_date >= "'.$apr.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$apr1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '3'";

$strSQL5 .= ' AND date_credit >= "'.$apr.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$apr1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11apr_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11apr = $S11apr_vat/1.07;
	
	
//พฤษภา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '3'";

$strSQL3 .= ' AND iv_date >= "'.$may.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$may1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '3'";

$strSQL4 .= ' AND iv_date >= "'.$may.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$may1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '3'";

$strSQL5 .= ' AND date_credit >= "'.$may.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$may1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11may_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11may = $S11may_vat/1.07;

//มิถุนา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '3'";

$strSQL3 .= ' AND iv_date >= "'.$jun.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$jun1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '3'";

$strSQL4 .= ' AND iv_date >= "'.$jun.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$jun1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '3'";

$strSQL5 .= ' AND date_credit >= "'.$jun.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$jun1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11jun_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11jun = $S11jun_vat/1.07;


$sums11_haft = $S11jun+$S11may+$S11apr+$S11mar+$S11feb+$S11jan;


//กรกฎา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '3'";

$strSQL3 .= ' AND iv_date >= "'.$jul.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$jul1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '3'";

$strSQL4 .= ' AND iv_date >= "'.$jul.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$jul1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '3'";

$strSQL5 .= ' AND date_credit >= "'.$jul.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$jul1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11jul_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11jul = $S11jul_vat/1.07;


//สิงหาคม
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '3'";

$strSQL3 .= ' AND iv_date >= "'.$aug.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$aug1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '3'";

$strSQL4 .= ' AND iv_date >= "'.$aug.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$aug1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '3'";

$strSQL5 .= ' AND date_credit >= "'.$aug.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$aug1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11aug_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11aug = $S11aug_vat/1.07;
	
	//กันยายน
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '3'";

$strSQL3 .= ' AND iv_date >= "'.$sep.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$sep1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '3'";

$strSQL4 .= ' AND iv_date >= "'.$sep.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$sep1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '3'";

$strSQL5 .= ' AND date_credit >= "'.$sep.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$sep1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11sep_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11sep = $S11sep_vat/1.07;
	
	
		//ตุลาคม
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '3'";

$strSQL3 .= ' AND iv_date >= "'.$oct.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$oct1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '3'";

$strSQL4 .= ' AND iv_date >= "'.$oct.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$oct1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '3'";

$strSQL5 .= ' AND date_credit >= "'.$oct.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$oct1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11oct_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11oct = $S11oct_vat/1.07;
	
		//พฤศจิกายน
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '3'";

$strSQL3 .= ' AND iv_date >= "'.$nov.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$nov1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '3'";

$strSQL4 .= ' AND iv_date >= "'.$nov.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$nov1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '3'";

$strSQL5 .= ' AND date_credit >= "'.$nov.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$nov1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11nov_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11nov = $S11nov_vat/1.07;
	
		//ธันวาคม
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '3'";

$strSQL3 .= ' AND iv_date >= "'.$dec.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$dec1.'"'; 

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '3'";

$strSQL4 .= ' AND iv_date >= "'.$dec.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$dec1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '3'";

$strSQL5 .= ' AND date_credit >= "'.$dec.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$dec1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11dec_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11dec = $S11dec_vat/1.07;
$sums11_haft1 = $S11jul+$S11aug+$S11sep+$S11oct+$S11nov+$S11dec;

$sums11_full = $sums11_haft1+$sums11_haft;


?>

<tr>
<td  align="right" class="style30"><?php echo $sale_code; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11jan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11feb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11mar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $S11apr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $S11may,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $S11jun,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sums11_haft,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $S11jul,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11aug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11sep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11oct,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $S11nov,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $S11dec,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sums11_haft1,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $sums11_full,2).""; ?></td> 

	</tr>

<?php } ?>
	<?php 
	
$phar_sol1 = $sol1janf+$sol1febf+$sol1marf+$sol1aprf+$sol1mayf+$sol1junf;
$phar_sol2 = $sol1julf+$sol1augf+$sol1sepf+$sol1octf+$sol1novf+$sol1decf;
$phar_solall = $phar_sol2+$phar_sol1;
	
?>
<tr>
<td  align="right" class="style30"><?php echo '(SOL1)'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol1janf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol1febf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol1marf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol1aprf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol1mayf,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $sol1junf,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $phar_sol1,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol1julf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol1augf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol1sepf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol1octf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol1novf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol1decf,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $phar_sol2,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $phar_solall,2).""; ?></td> 

	</tr>
	
<?php 
	
$phar_sol11 = $sol2janf+$sol2febf+$sol2marf+$sol2aprf+$sol2mayf+$sol2junf;
$phar_sol12 = $sol2julf+$sol2augf+$sol2sepf+$sol2octf+$sol2novf+$sol2decf;
$phar_solall2 = $phar_sol12+$phar_sol11;
	
?>
<tr>
<td  align="right" class="style30"><?php echo '(SOL2)'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2janf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2febf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2marf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol2aprf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol2mayf,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $sol2junf,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $phar_sol11,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2julf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol2augf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2sepf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2octf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2novf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol2decf,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $phar_sol12,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $phar_solall2,2).""; ?></td> 

	</tr>
	
<?php 
	
$phar_sol31 = $sol3janf+$sol3febf+$sol3marf+$sol3aprf+$sol3mayf+$sol3junf;
$phar_sol32 = $sol3julf+$sol3augf+$sol3sepf+$sol3octf+$sol3novf+$sol3decf;
$phar_solall3 = $phar_sol32+$phar_sol31;
	
?>
<tr>
<td  align="right" class="style30"><?php echo 'SOL3'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3janf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3febf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3marf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol3aprf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol3mayf,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $sol3junf,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $phar_sol31,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3julf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol3augf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3sepf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3octf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3novf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol3decf,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $phar_sol32,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $phar_solall3,2).""; ?></td> 

	</tr>
	
<?php 
	
$phar_sol91 = $sol9janf+$sol9febf+$sol9marf+$sol9aprf+$sol9mayf+$sol9junf;
$phar_sol92 = $sol9julf+$sol9augf+$sol9sepf+$sol9octf+$sol9novf+$sol9decf;
$phar_solall9 = $phar_sol92+$phar_sol91;
	
?>
<tr>
<td  align="right" class="style30"><?php echo '(SOL99)'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9janf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9febf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9marf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol9aprf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol9mayf,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $sol9junf,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $phar_sol91,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9julf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol9augf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9sepf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9octf,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9novf,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol9decf,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $phar_sol92,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $phar_solall9,2).""; ?></td> 

	</tr>
	
<?php 
	
	//มกรา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '3'";

$strSQL10 .= ' AND iv_date >= "'.$jan.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$jan1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$sum_pharjan = $sol9janf+$sol3janf+$sol2janf+$sol1janf+($objResult10["total"]/1.07);
$sumph_jan  = $sum_pharjan - $phar_jan;	
		
			
//กุมภา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '3'";

$strSQL10 .= ' AND iv_date >= "'.$feb.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$feb1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$sum_pharfeb = $sol9febf+$sol3febf+$sol2febf+$sol1febf+($objResult10["total"]/1.07);
$sumph_feb  = $sum_pharfeb - $phar_feb;	

		
//มีนา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '3'";

$strSQL10 .= ' AND iv_date >= "'.$mar.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$mar1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$sum_pharmar = $sol9marf+$sol3marf+$sol2marf+$sol1marf+($objResult10["total"]/1.07);
$sumph_mar  = $sum_pharmar - $phar_mar;	

	
	
		
//เมษา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '3'";

$strSQL10 .= ' AND iv_date >= "'.$apr.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$apr1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$sum_pharapr = $sol9aprf+$sol3aprf+$sol2aprf+$sol1aprf+($objResult10["total"]/1.07);
$sumph_apr  = $sum_pharapr - $phar_apr;	

				
	
//พฤษภา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '3'";

$strSQL10 .= ' AND iv_date >= "'.$may.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$may1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
$sum_pharmay = $sol9mayf+$sol3mayf+$sol2mayf+$sol1mayf+($objResult10["total"]/1.07);
$sumph_may  = $sum_pharmay - $phar_may;	


			
//มิถุนา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '3'";

$strSQL10 .= ' AND iv_date >= "'.$jun.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$jun1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$sum_pharjun = $sol9junf+$sol3junf+$sol2junf+$sol1junf+($objResult10["total"]/1.07);
	$sumph_jun  = $sum_pharjun - $phar_jun;	


		
	
//กรกฎา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '3'";

$strSQL10 .= ' AND iv_date >= "'.$jul.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$jul1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	$sum_pharjul = $sol9julf+$sol3julf+$sol2julf+$sol1julf+($objResult10["total"]/1.07);
$sumph_jul  = $sum_pharjul - $phar_jul;	


	
//สิงหา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '3'";

$strSQL10 .= ' AND iv_date >= "'.$aug.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$aug1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	$sum_pharaug = $sol9augf+$sol3augf+$sol2augf+$sol1augf+($objResult10["total"]/1.07);
	
$sumph_aug  = $sum_pharaug - $phar_aug;	

	
//กันยา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '3'";

$strSQL10 .= ' AND iv_date >= "'.$sep.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$sep1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$sum_pharsep = $sol9sepf+$sol3sepf+$sol2sepf+$sol1sepf+($objResult10["total"]/1.07);
	
$sumph_sep  = $sum_pharsep - $phar_sep;	

			
	
//ตุลาคม
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '3'";

$strSQL10 .= ' AND iv_date >= "'.$oct.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$oct1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);

$sum_pharoct = $sol9octf+$sol3octf+$sol2octf+$sol1octf+($objResult10["total"]/1.07);
	$sumph_oct  = $sum_pharoct - $phar_oct;	

	

	
//พฤศจิกา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '3'";

$strSQL10 .= ' AND iv_date >= "'.$nov.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$nov1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$sum_pharnov = $sol9novf+$sol3novf+$sol2novf+$sol1novf+($objResult10["total"]/1.07);
$sumph_nov  = $sum_pharnov - $phar_nov;	
	


//ธันวา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '3'";

$strSQL10 .= ' AND iv_date >= "'.$dec.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$dec1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);

$sum_phardec = $sol9decf+$sol3decf+$sol2decf+$sol1decf+($objResult10["total"]/1.07);
$sumph_dec  = $sum_phardec - $phar_dec;	

$sumf_1 = $sum_pharjan+$sum_pharfeb+$sum_pharmar+$sum_pharapr+$sum_pharmay+$sum_pharjun;
$sumf_2 = $sum_pharjul+$sum_pharaug+$sum_pharsep+$sum_pharoct+$sum_pharnov+$sum_phardec;
$sumf_all = $sumf_1+$sumf_2;
		
	?>

<tr>
<td  align="right" class="style30"><?php echo 'Total'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_pharjan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_pharfeb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_pharmar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sum_pharapr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sum_pharmay,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sum_pharjun,2).""; ?></td>
<td align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumf_1,2).""; ?></td> 

<td  align="right" class="style30"><?php echo number_format( $sum_pharjul,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sum_pharaug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_pharsep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_pharoct,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_pharnov,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sum_phardec,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumf_2,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $sumf_all,2).""; ?></td> 

	</tr>

<?php 
$phar_1 = $phar_jan+$phar_feb+$phar_mar+$phar_apr+$phar_may+$phar_jun;
$phar_2 = $phar_jul+$phar_aug+$phar_sep+$phar_oct+$phar_nov+$phar_dec;
$phar_all = $phar_1 + $phar_2;

?>
<tr>
<td  align="right" class="style30"><?php echo 'หัก NB'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $phar_jan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $phar_feb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $phar_mar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $phar_apr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $phar_may,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $phar_jun,2).""; ?></td>
<td align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $phar_1,2).""; ?></td> 

<td  align="right" class="style30"><?php echo number_format( $phar_jul,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $phar_aug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $phar_sep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $phar_oct,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $phar_nov,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $phar_dec,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $phar_2,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $phar_all,2).""; ?></td> 

	</tr>

	<?php 
$sumph_1 = $sumph_jan+$sumph_feb+$sumph_mar+$sumph_apr+$sumph_may+$sumph_jun;
$sumph_2 = $sumph_jul+$sumph_aug+$sumph_sep+$sumph_oct+$sumph_nov+$sumph_dec;
$sumph_all = $sumph_1+$sumph_2;

	?>

	<tr>
<td  align="right" class="style30"><?php echo 'คงเหลือ'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumph_jan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumph_feb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumph_mar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sumph_apr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sumph_may,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sumph_jun,2).""; ?></td>
<td align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumph_1,2).""; ?></td> 

<td  align="right" class="style30"><?php echo number_format( $sumph_jul,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sumph_aug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumph_sep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumph_oct,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumph_nov,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sumph_dec,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumph_2,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $sumph_all,2).""; ?></td> 

	</tr>


	
	
	</table>

	</p></p>
<center>
<span class="style15"><?php echo "Actual Noble Med" ; echo $year; ?></span>
</center>
</p>


</p>
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="6%" align="center" class="style30">Actual</td>
<td width="6%" align="center" class="style30">Jan</td>
<td width="6%" align="center" class="style30">Feb</td>
<td width="6%" align="center" class="style30">Mar</td> 
<td width="6%" align="center" class="style30">Apr</td> 
<td width="6%" align="center" class="style30">May</td> 
<td width="6%" align="center" class="style30">Jun</td> 
<td width="6%" bgcolor="#BEBEBE" align="center" class="style30">Total 1-6</td> 
<td width="6%" align="center" class="style30">Jul</td>
<td width="6%" align="center" class="style30">Aug</td>
<td width="6%" align="center" class="style30">Sep</td>
<td width="6%" align="center" class="style30">Oct</td> 
<td width="6%" align="center" class="style30">Nov</td> 
<td width="6%" align="center" class="style30">Dec</td> 
<td width="6%" bgcolor="#BEBEBE" align="center" class="style30">Total 7-12</td> 
<td width="6%" bgcolor="#9ACD32" align="center" class="style30">TOTAL 1-12</td> 



	</tr>

<?php


$strSQL ="SELECT * FROM tb_team_adm where ckk='0' ";

$objQuery =mysqli_query($com,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$sale_code = $objResult["sale_code"];

//S11

//มกราคม
$strSQL1 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0' and type_doc = '4'";

$strSQL1 .= ' AND iv_date >= "'.$jan.'"'; 

$strSQL1 .= ' AND iv_date <= "'.$jan1.'"'; 


$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);



	$strSQL2 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '4'";

$strSQL2 .= ' AND iv_date >= "'.$jan.'"'; 

$strSQL2 .= ' AND iv_date <= "'.$jan1.'"'; 

$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");

$objResult2 = mysqli_fetch_array($objQuery2);


$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '4'";

$strSQL5 .= ' AND date_credit >= "'.$jan.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$jan1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11jan_vat=($objResult1['total']+$objResult2['total1'])-$objResult5['sum_amount1'];

$S11jan = $S11jan_vat/1.07;

//กุมภา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '4'";

$strSQL3 .= ' AND iv_date >= "'.$feb.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$feb1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '4'";

$strSQL4 .= ' AND iv_date >= "'.$feb.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$feb1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '4'";

$strSQL5 .= ' AND date_credit >= "'.$feb.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$feb1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);


$S11feb_vat =($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11feb = $S11feb_vat/1.07;
	
//มีนา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '4'";

$strSQL3 .= ' AND iv_date >= "'.$mar.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$mar1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '4'";

$strSQL4 .= ' AND iv_date >= "'.$mar.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$mar1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '4'";

$strSQL5 .= ' AND date_credit >= "'.$mar.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$mar1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11mar_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11mar = $S11mar_vat/1.07;


//เมษา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '4'";

$strSQL3 .= ' AND iv_date >= "'.$apr.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$apr1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '4'";

$strSQL4 .= ' AND iv_date >= "'.$apr.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$apr1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '4'";

$strSQL5 .= ' AND date_credit >= "'.$apr.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$apr1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11apr_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11apr = $S11apr_vat/1.07;
	
	
//พฤษภา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '4'";

$strSQL3 .= ' AND iv_date >= "'.$may.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$may1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '4'";

$strSQL4 .= ' AND iv_date >= "'.$may.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$may1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '4'";

$strSQL5 .= ' AND date_credit >= "'.$may.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$may1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11may_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11may = $S11may_vat/1.07;

//มิถุนา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '4'";

$strSQL3 .= ' AND iv_date >= "'.$jun.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$jun1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '4'";

$strSQL4 .= ' AND iv_date >= "'.$jun.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$jun1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '4'";

$strSQL5 .= ' AND date_credit >= "'.$jun.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$jun1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11jun_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11jun = $S11jun_vat/1.07;


$sums11_haft = $S11jun+$S11may+$S11apr+$S11mar+$S11feb+$S11jan;


//กรกฎา
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '4'";

$strSQL3 .= ' AND iv_date >= "'.$jul.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$jul1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '4'";

$strSQL4 .= ' AND iv_date >= "'.$jul.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$jul1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '4'";

$strSQL5 .= ' AND date_credit >= "'.$jul.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$jul1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11jul_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11jul = $S11jul_vat/1.07;


//สิงหาคม
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '4'";

$strSQL3 .= ' AND iv_date >= "'.$aug.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$aug1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '4'";

$strSQL4 .= ' AND iv_date >= "'.$aug.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$aug1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '4'";

$strSQL5 .= ' AND date_credit >= "'.$aug.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$aug1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11aug_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11aug = $S11aug_vat/1.07;
	
	//กันยายน
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '4'";

$strSQL3 .= ' AND iv_date >= "'.$sep.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$sep1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '4'";

$strSQL4 .= ' AND iv_date >= "'.$sep.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$sep1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '4'";

$strSQL5 .= ' AND date_credit >= "'.$sep.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$sep1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11sep_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11sep = $S11sep_vat/1.07;
	
	
		//ตุลาคม
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '4'";

$strSQL3 .= ' AND iv_date >= "'.$oct.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$oct1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '4'";

$strSQL4 .= ' AND iv_date >= "'.$oct.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$oct1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '4'";

$strSQL5 .= ' AND date_credit >= "'.$oct.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$oct1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11oct_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11oct = $S11oct_vat/1.07;
	
		//พฤศจิกายน
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '4'";

$strSQL3 .= ' AND iv_date >= "'.$nov.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$nov1.'"'; 


$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '4'";

$strSQL4 .= ' AND iv_date >= "'.$nov.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$nov1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '4'";

$strSQL5 .= ' AND date_credit >= "'.$nov.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$nov1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11nov_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11nov = $S11nov_vat/1.07;
	
		//ธันวาคม
$strSQL3 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '0'  and type_doc = '4'";

$strSQL3 .= ' AND iv_date >= "'.$dec.'"'; 

$strSQL3 .= ' AND iv_date <= "'.$dec1.'"'; 

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);



	$strSQL4 = "SELECT SUM(amount)  as total1  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE sale_code = '".$sale_code."' and status_doc ='Approve' and have_order = '1' and have_product = '2'  and type_doc = '4'";

$strSQL4 .= ' AND iv_date >= "'.$dec.'"'; 

$strSQL4 .= ' AND iv_date <= "'.$dec1.'"'; 

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);

$strSQL5 = "SELECT SUM(sum_amount)  as sum_amount1  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) WHERE sale_code = '".$sale_code."' and status_doc = 'Approve' and company_type = '4'";

$strSQL5 .= ' AND date_credit >= "'.$dec.'"'; 

$strSQL5 .= ' AND date_credit <= "'.$dec1.'"'; 

$objQuery5 = mysqli_query($conn,$strSQL5);
$objResult5 = mysqli_fetch_array($objQuery5);

$S11dec_vat = ($objResult3['total']+$objResult4['total1'])-$objResult5['sum_amount1'];
$S11dec = $S11dec_vat/1.07;
$sums11_haft1 = $S11jul+$S11aug+$S11sep+$S11oct+$S11nov+$S11dec;

$sums11_full = $sums11_haft1+$sums11_haft;


?>

<tr>
<td  align="right" class="style30"><?php echo $sale_code; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11jan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11feb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11mar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $S11apr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $S11may,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $S11jun,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sums11_haft,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $S11jul,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11aug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11sep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $S11oct,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $S11nov,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $S11dec,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sums11_haft1,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $sums11_full,2).""; ?></td> 

	</tr>

<?php } ?>
	<?php 
	
$noble_sol1 = $sol1jann+$sol1febn+$sol1marn+$sol1aprn+$sol1mayn+$sol1junn;
$noble_sol2 = $sol1juln+$sol1augn+$sol1sepn+$sol1octn+$sol1novn+$sol1decn;
$noble_solall = $noble_sol2+$noble_sol1;
	
?>
<tr>
<td  align="right" class="style30"><?php echo '(SOL1)'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol1jann,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol1febn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol1marn,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol1aprn,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol1mayn,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $sol1junf,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $noble_sol1,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol1juln,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol1augn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol1sepn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol1octn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol1novn,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol1decn,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $noble_sol2,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $noble_solall,2).""; ?></td> 
 
	</tr>
	
<?php 
	
$noble_sol11 = $sol2jann+$sol2febn+$sol2marn+$sol2aprn+$sol2mayn+$sol2junn;
$noble_sol12 = $sol2juln+$sol2augn+$sol2sepn+$sol2octn+$sol2novn+$sol2decn;
$noble_solall1 = $noble_sol12+$noble_sol11;
	
?>
<tr>
<td  align="right" class="style30"><?php echo '(SOL2)'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2jann,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2febn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2marn,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol2aprn,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol2mayn,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $sol2junf,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $noble_sol11,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2juln,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol2augn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2sepn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2octn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol2novn,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol2decn,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $noble_sol12,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $noble_solall1,2).""; ?></td> 

	</tr>
	
<?php 
	
$noble_sol31 = $sol3jann+$sol3febn+$sol3marn+$sol3aprn+$sol3mayn+$sol3junn;
$noble_sol32 = $sol3juln+$sol3augn+$sol3sepn+$sol3octn+$sol3novn+$sol3decn;
$noble_solall3 = $noble_sol32+$noble_sol31;
	
?>
<tr>
<td  align="right" class="style30"><?php echo 'SOL3'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3jann,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3febn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3marn,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol3aprn,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol3mayn,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $sol3junf,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $noble_sol31,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3juln,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol3augn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3sepn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3octn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol3novn,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol3decn,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $noble_sol32,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $noble_solall3,2).""; ?></td> 

	</tr>
	
<?php 
	
$noble_sol91 = $sol9jann+$sol9febn+$sol9marn+$sol9aprn+$sol9mayn+$sol9junn;
$noble_sol92 = $sol9juln+$sol9augn+$sol9sepn+$sol9octn+$sol9novn+$sol9decn;
$noble_solall9 = $noble_sol92+$noble_sol91;
	
?>
<tr>
<td  align="right" class="style30"><?php echo '(SOL99)'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9jann,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9febn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9marn,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol9aprn,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol9mayn,2).""; ?></td> 
<td align="right" class="style30"><?php echo number_format( $sol9junf,2).""; ?></td> 
<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $noble_sol91,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9juln,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol9augn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9sepn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9octn,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sol9novn,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sol9decn,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $noble_sol92,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $noble_solall9,2).""; ?></td> 

	</tr>
	
<?php 
	
	//มกรา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '4'";

$strSQL10 .= ' AND iv_date >= "'.$jan.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$jan1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$sum_nbjan = $sol9jann+$sol3jann+$sol2jann+$sol1jann+($objResult10["total"]/1.07);
$sumnb_jan  = $sum_nbjan - $nb_jan;	
		
			
//กุมภา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '4'";

$strSQL10 .= ' AND iv_date >= "'.$feb.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$feb1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$sum_nbfeb = $sol9febn+$sol3febn+$sol2febn+$sol1febn+($objResult10["total"]/1.07);
$sumnb_feb  = $sum_nbfeb - $nb_feb;	

		
//มีนา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '4'";

$strSQL10 .= ' AND iv_date >= "'.$mar.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$mar1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$sum_nbmar = $sol9marn+$sol3marn+$sol2marn+$sol1marn+($objResult10["total"]/1.07);
$sumnb_mar  = $sum_nbmar - $nb_mar;	

	
	
		
//เมษา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '4'";

$strSQL10 .= ' AND iv_date >= "'.$apr.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$apr1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$sum_nbapr = $sol9aprn+$sol3aprn+$sol2aprn+$sol1aprn+($objResult10["total"]/1.07);
$sumnb_apr  = $sum_nbapr - $nb_apr;	

				
	
//พฤษภา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '4'";

$strSQL10 .= ' AND iv_date >= "'.$may.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$may1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
$sum_nbmay = $sol9mayn+$sol3mayn+$sol2mayn+$sol1mayn+($objResult10["total"]/1.07);
$sumnb_may  = $sum_nbmay - $nb_may;	


			
//มิถุนา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '4'";

$strSQL10 .= ' AND iv_date >= "'.$jun.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$jun1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$sum_nbjun = $sol9junn+$sol3junn+$sol2junn+$sol1junn+($objResult10["total"]/1.07);
	$sumnb_jun  = $sum_nbjun - $nb_jun;	


		
	
//กรกฎา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '4'";

$strSQL10 .= ' AND iv_date >= "'.$jul.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$jul1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	$sum_nbjul = $sol9juln+$sol3juln+$sol2juln+$sol1juln+($objResult10["total"]/1.07);
$sumnb_jul  = $sum_nbjul - $nb_jul;	


	
//สิงหา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '4'";

$strSQL10 .= ' AND iv_date >= "'.$aug.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$aug1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
	$sum_nbaug = $sol9augn+$sol3augn+$sol2augn+$sol1augn+($objResult10["total"]/1.07);
	
$sumnb_aug  = $sum_nbaug - $nb_aug;	

	
//กันยา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '4'";

$strSQL10 .= ' AND iv_date >= "'.$sep.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$sep1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$sum_nbsep = $sol9sepn+$sol3sepn+$sol2sepn+$sol1sepn+($objResult10["total"]/1.07);
	
$sumnb_sep  = $sum_nbsep - $nb_sep;	

			
	
//ตุลาคม
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '4'";

$strSQL10 .= ' AND iv_date >= "'.$oct.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$oct1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);

$sum_nboct = $sol9octn+$sol3octn+$sol2octn+$sol1octn+($objResult10["total"]/1.07);
	$sumnb_oct  = $sum_nboct - $nb_oct;	

	

	
//พฤศจิกา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '4'";

$strSQL10 .= ' AND iv_date >= "'.$nov.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$nov1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);
	
$sum_nbnov = $sol9novn+$sol3novn+$sol2novn+$sol1novn+($objResult10["total"]/1.07);
$sumnb_nov  = $sum_nbnov - $nb_nov;	
	


//ธันวา
	
$strSQL10 = "SELECT SUM(amount)  as total  FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE status_doc ='Approve' and type_doc = '4'";

$strSQL10 .= ' AND iv_date >= "'.$dec.'"'; 

$strSQL10 .= ' AND iv_date <= "'.$dec1.'"'; 

$objQuery10 = mysqli_query($conn,$strSQL10) or die ("Error Query [".$strSQL10."]");
$objResult10 = mysqli_fetch_array($objQuery10);

$sum_nbdec = $sol9decn+$sol3decn+$sol2decn+$sol1decn+($objResult10["total"]/1.07);
$sumnb_dec  = $sum_nbdec - $nb_dec;	

$sumn_1 = $sum_nbjan+$sum_nbfeb+$sum_nbmar+$sum_nbapr+$sum_nbmay+$sum_nbjun;
$sumn_2 = $sum_nbjul+$sum_nbaug+$sum_nbsep+$sum_nboct+$sum_nbnov+$sum_nbdec;
$sumn_all = $sumn_1+$sumn_2;
		
	?>

<tr>
<td  align="right" class="style30"><?php echo 'Total'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_nbjan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_nbfeb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_nbmar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sum_nbapr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sum_nbmay,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sum_nbjun,2).""; ?></td>
<td align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumn_1,2).""; ?></td> 

<td  align="right" class="style30"><?php echo number_format( $sum_nbjul,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sum_nbaug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_nbsep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_nboct,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sum_nbnov,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sum_nbdec,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumn_2,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $sumn_all,2).""; ?></td> 

	</tr>

<?php 
$nb_1 = $nb_jan+$nb_feb+$nb_mar+$nb_apr+$nb_may+$nb_jun;
$nb_2 = $nb_jul+$nb_aug+$nb_sep+$nb_oct+$nb_nov+$nb_dec;
$nb_all = $nb_1 + $nb_2;

?>
<tr>
<td  align="right" class="style30"><?php echo 'หัก PTL'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $nb_jan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $nb_feb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $nb_mar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $nb_apr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $nb_may,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $nb_jun,2).""; ?></td>
<td align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $nb_1,2).""; ?></td> 

<td  align="right" class="style30"><?php echo number_format( $nb_jul,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $nb_aug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $nb_sep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $nb_oct,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $nb_nov,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $nb_dec,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $nb_2,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $nb_all,2).""; ?></td> 

	</tr>

	<?php 
$sumnb_1 = $sumnb_jan+$sumnb_feb+$sumnb_mar+$sumnb_apr+$sumnb_may+$sumnb_jun;
$sumnb_2 = $sumnb_jul+$sumnb_aug+$sumnb_sep+$sumnb_oct+$sumnb_nov+$sumnb_dec;
$sumnb_all = $sumnb_1+$sumnb_2;

	?>

	<tr>
<td  align="right" class="style30"><?php echo 'คงเหลือ'; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumnb_jan,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumnb_feb,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumnb_mar,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sumnb_apr,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sumnb_may,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sumnb_jun,2).""; ?></td>
<td align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumnb_1,2).""; ?></td> 

<td  align="right" class="style30"><?php echo number_format( $sumnb_jul,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sumnb_aug,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumnb_sep,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumnb_oct,2).""; ?></td>
<td  align="right" class="style30"><?php echo number_format( $sumnb_nov,2).""; ?></td> 
<td  align="right" class="style30"><?php echo number_format( $sumnb_dec,2).""; ?></td> 

<td  align="right" bgcolor="#BEBEBE" class="style30"><?php echo number_format( $sumnb_2,2).""; ?></td> 
<td  align="right" bgcolor="#9ACD32" class="style30"><?php echo number_format( $sumnb_all,2).""; ?></td> 

	</tr>


	
	
	</table>

	</p></p>

</body>
</html>
