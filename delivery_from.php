<?php

define('FPDF_FONTPATH','font/');
 
require('fpdf1.php');

$ref_id=$_GET["ref_id"];

include"dbconnect.php";

date_default_timezone_set("Asia/Bangkok");
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
	    $strYear1 =substr( $strYear , 2 , 2 );
		return "$strDay $strMonthThai $strYear1";
	}

$pdf=new FPDF( 'P' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->AddFont('times','','times.php');


$strSQL = "SELECT * FROM hos__rental  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$ref_id =$objResult["ref_id"];
$customer =$objResult["rental_name"];
$address =$objResult["install_address"];
$rental_tel =$objResult["rental_tel"];
$iv_no =$objResult["iv_no"];
$type_doc =$objResult["type_doc"];
$connect_name = $objResult["connect_name"];
$connect_tel = $objResult["connect_tel"];
$promis_no = $objResult["promis_no"];
$promis_date = Datethai($objResult["promis_date"]);


$strSQL11 = "SELECT product_code,count,sn_number,remark_sale,sol_name,unit_name FROM  (hos__subrental LEFT JOIN tb_product ON hos__subrental.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";

$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rows11 = mysqli_num_rows($objQuery11);
$i = 1;
$objResult11 = mysqli_fetch_array($objQuery11);
/*while($objResult11 = mysqli_fetch_array($objQuery11))
{*/

$strSQL2 = "SELECT * FROM  tb_product_rentalref  WHERE ref_idrt = '".$ref_id."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$strSQL3 = "SELECT * FROM  tb_product_checklist  WHERE ref_id = '".$ref_id."' and product_id = '".$objResult11["product_code"]."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);


$sql1 = "SELECT *   FROM tb_product_checklis where ref_pcc = '".$objResult3["ref_pc"]."' and type_emp ='ST' and go_back ='1'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

$sql2 = "SELECT *   FROM tb_product_checklis where ref_pcc = '".$objResult3["ref_pc"]."' and type_emp ='EN' and go_back ='1'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_assoc($qry2);

$sql3 = "SELECT *   FROM tb_product_checklis where ref_pcc = '".$objResult3["ref_pc"]."' and type_emp ='CS' and go_back ='1'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);

$sql4 = "SELECT *   FROM tb_product_checklis where ref_pcc = '".$objResult3["ref_pc"]."' and type_emp ='CS' and go_back ='2'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_assoc($qry4);

$sql5 = "SELECT *   FROM tb_product_checklis where ref_pcc = '".$objResult3["ref_pc"]."' and type_emp ='EN' and go_back ='2'";
$qry5 = mysqli_query($conn,$sql5) or die(mysqli_error());
$rs5 = mysqli_fetch_assoc($qry5);

$sql6 = "SELECT * FROM tb_product_checklis where ref_pcc = '".$objResult3["ref_pc"]."' and type_emp ='ST' and go_back ='2'";
$qry6 = mysqli_query($conn,$sql6) or die(mysqli_error());
$rs6 = mysqli_fetch_assoc($qry6);
	
	
$doc_no = $objResult3["doc_no"];	
$product_code = $objResult11['product_code'];

$unit_name = $objResult11["unit_name"];
$sn = $objResult2["sn_number"];
$product_name = $objResult11["sol_name"];
$count = $objResult11["count"];
$list_des1 = $objResult2["list_des1"];
$list_des2 = $objResult2["list_des2"];
$list_des3 = $objResult2["list_des3"];
$list_des4 = $objResult2["list_des4"];
$list_des5 = $objResult2["list_des5"];
$list_des6 = $objResult2["list_des6"];
$list_des7 = $objResult2["list_des7"];
$list_des8 = $objResult2["list_des8"];
$list_des9 = $objResult2["list_des9"];
$list_des10 = $objResult2["list_des10"];
$list_des11 = $objResult2["list_des11"];
$list_des12 = $objResult2["list_des12"];
$list_des13 = $objResult2["list_des13"];
$list_des14 = $objResult2["list_des14"];
$list_des15 = $objResult2["list_des15"];
$list_des16 = $objResult2["list_des16"];


$des1_g = $rs1["des1"];
$des2_g = $rs1["des2"];
$des3_g = $rs1["des3"];
$des4_g = $rs1["des4"];
$des5_g = $rs1["des5"];
$des6_g = $rs1["des6"];
$des7_g = $rs1["des7"];
$des8_g = $rs1["des8"];
$des9_g = $rs1["des9"];
$des10_g = $rs1["des10"];
$des11_g = $rs1["des11"];
$des12_g = $rs1["des12"];
$des13_g = $rs1["des13"];
$des14_g = $rs1["des14"];
$des15_g = $rs1["des15"];
$des16_g = $rs1["des16"];

$des1_1g = $rs2["des1"];
$des2_1g = $rs2["des2"];
$des3_1g = $rs2["des3"];
$des4_1g = $rs2["des4"];
$des5_1g = $rs2["des5"];
$des6_1g = $rs2["des6"];
$des7_1g = $rs2["des7"];
$des8_1g = $rs2["des8"];
$des9_1g = $rs2["des9"];
$des10_1g = $rs2["des10"];
$des11_1g = $rs2["des11"];
$des12_1g = $rs2["des12"];
$des13_1g = $rs2["des13"];
$des14_1g = $rs2["des14"];
$des15_1g = $rs2["des15"];
$des16_1g = $rs2["des16"];

$des1_2g = $rs3["des1"];
$des2_2g = $rs3["des2"];
$des3_2g = $rs3["des3"];
$des4_2g = $rs3["des4"];
$des5_2g = $rs3["des5"];
$des6_2g = $rs3["des6"];
$des7_2g = $rs3["des7"];
$des8_2g = $rs3["des8"];
$des9_2g = $rs3["des9"];
$des10_2g = $rs3["des10"];
$des11_2g = $rs3["des11"];
$des12_2g = $rs3["des12"];
$des13_2g = $rs3["des13"];
$des14_2g = $rs3["des14"];
$des15_2g = $rs3["des15"];
$des16_2g = $rs3["des16"];


$des_all = "$des1_g $des2_g $des3_g $des4_g $des5_g $des6_g $des7_g $des8_g $des9_g $des10_g $des11_g $des12_g $des13_g $des14_g $des15_g $des16_g $des1_1g $des2_1g $des3_1g $des4_1g $des5_1g $des6_1g $des7_1g $des8_1g $des9_1g $des10_1g $des11_1g $des12_1g $des13_1g $des14_1g $des15_1g $des16_1g $des1_2g $des2_2g $des3_2g $des4_2g $des5_2g $des6_2g $des7_2g $des8_2g $des9_2g $des10_2g $des11_2g $des12_2g $des13_2g $des14_2g $des15_2g $des16_2g";




$des1_ = $rs4["des1"];
$des2_ = $rs4["des2"];
$des3_ = $rs4["des3"];
$des4_ = $rs4["des4"];
$des5_ = $rs4["des5"];
$des6_ = $rs4["des6"];
$des7_ = $rs4["des7"];
$des8_ = $rs4["des8"];
$des9_ = $rs4["des9"];
$des10_ = $rs4["des10"];
$des11_ = $rs4["des11"];
$des12_ = $rs4["des12"];
$des13_ = $rs4["des13"];
$des14_ = $rs4["des14"];
$des15_ = $rs4["des15"];
$des16_ = $rs4["des16"];

$des1_1 = $rs5["des1"];
$des2_1 = $rs5["des2"];
$des3_1 = $rs5["des3"];
$des4_1 = $rs5["des4"];
$des5_1 = $rs5["des5"];
$des6_1 = $rs5["des6"];
$des7_1 = $rs5["des7"];
$des8_1 = $rs5["des8"];
$des9_1 = $rs5["des9"];
$des10_1 = $rs5["des10"];
$des11_1 = $rs5["des11"];
$des12_1 = $rs5["des12"];
$des13_1 = $rs5["des13"];
$des14_1 = $rs5["des14"];
$des15_1 = $rs5["des15"];
$des16_1 = $rs5["des16"];

$des1_2 = $rs6["des1"];
$des2_2 = $rs6["des2"];
$des3_2 = $rs6["des3"];
$des4_2 = $rs6["des4"];
$des5_2 = $rs6["des5"];
$des6_2 = $rs6["des6"];
$des7_2 = $rs6["des7"];
$des8_2 = $rs6["des8"];
$des9_2 = $rs6["des9"];
$des10_2 = $rs6["des10"];
$des11_2 = $rs6["des11"];
$des12_2 = $rs6["des12"];
$des13_2 = $rs6["des13"];
$des14_2 = $rs6["des14"];
$des15_2 = $rs6["des15"];
$des16_2 = $rs6["des16"];


$des_all1 = "$des1_ $des2_ $des3_ $des4_ $des5_ $des6_ $des7_ $des8_ $des9_ $des10_ $des11_ $des12_ $des13_ $des14_ $des15_ $des16_ $des1_1 $des2_1 $des3_1 $des4_1 $des5_1 $des6_1 $des7_1 $des8_1 $des9_1 $des10_1 $des11_1 $des12_1 $des13_1 $des14_1 $des15_1 $des16_1 $des1_2 $des2_2 $des3_2 $des4_2 $des5_2 $des6_2 $des7_2 $des8_2 $des9_2 $des10_2 $des11_2 $des12_2 $des13_2 $des14_2 $des15_2 $des16_2";


 
$pdf->AddPage();

$pdf->SetFont('angsana','B',20);
$pdf->setXY(9.2,2.5);
$pdf->MultiCell(9.0,1.6, iconv( 'UTF-8','cp874' , "ใบรับส่งสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',18);
$pdf->setXY(9.2,3.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "(Delivery Order)"),0 ,'L' );


if($type_doc =='3'){
$pdf->SetFont('angsana','B',16);
$pdf->setXY(0.7,1.0);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "บริษัท ออลล์เวล ไลฟ์ จำกัด"),0 ,'L' );

$pdf->SetFont('angsa','',13);
$pdf->setXY(0.7,1.6);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "73,75 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ"),0 ,'L' );

$pdf->setXY(0.7,2.0);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "เขตบางพลัด กรุงเทพมหานคร 10700"),0 ,'L' );

$pdf->setXY(0.7,2.4);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "โทร : 0-2424-3555 (อัตโนมัติ)"),0 ,'L' );

$pdf->setXY(0.7,2.8);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "แฟ็กซ์ : 0-2424-3322"),0 ,'L' );

$pdf->Image("img/allwell_logo.png",8.0,1.0,5.0,1.5);

$pdf->SetFont('angsana','B',16);

$pdf->setXY(11.2,1.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ALLWELL LIFE CO., LTD."),0 ,'R' );

$pdf->SetFont('angsa','',13);

$pdf->setXY(11.2,1.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "73,75 Soi Charansanitwong 89/2,"),0 ,'R' );

$pdf->setXY(11.2,2.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Bang-Or, Bang-Plad,Bankok 10700"),0 ,'R' );

$pdf->setXY(11.2,2.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "TEL : 0-2424-3555 (Auto)"),0 ,'R' );

$pdf->setXY(11.2,2.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FAX : 0-2424-3322"),0 ,'R' );

}

if($type_doc =='4'){
$pdf->SetFont('angsana','B',16);

$pdf->setXY(0.7,1.0);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมด จำกัด"),0 ,'L' );

$pdf->SetFont('angsa','',13);
$pdf->setXY(0.7,1.6);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "73 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ"),0 ,'L' );

$pdf->setXY(0.7,2.0);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "เขตบางพลัด กรุงเทพมหานคร 10700"),0 ,'L' );

$pdf->setXY(0.7,2.4);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "โทร : 0-2880-5566 (อัตโนมัติ)"),0 ,'L' );

$pdf->setXY(0.7,2.8);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "แฟ็กซ์ : 0-2880-5533"),0 ,'L' );

$pdf->Image("img/nbm_select.png",8.5,1.0,4.0,2.0);

$pdf->SetFont('angsana','B',16);

$pdf->setXY(11.2,1.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "NOBLE MED CO.,LTD"),0 ,'R' );

$pdf->SetFont('angsa','',13);

$pdf->setXY(11.2,1.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "73 Soi Charansanitwong 89/2,"),0 ,'R' );
$pdf->setXY(11.2,2.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Bang-Or, Bang-Plad,Bankok 10700"),0 ,'R' );
$pdf->setXY(11.2,2.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "TEL : 0-2880-5566 (Auto)"),0 ,'R' );
$pdf->setXY(11.2,2.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FAX : 0-2880-5533"),0 ,'R' );

}


	
$pdf->setXY(0.5,4.6);
$pdf->Cell(10.5,3.0, "",1,1,"c" );

$pdf->setXY(11.0,4.6);
$pdf->Cell(5.0,3.0, "",1,1,"c" );

$pdf->setXY(16.0,4.6);
$pdf->Cell(4.5,1.0, "",1,1,"c" );

$pdf->setXY(16.0,5.6);
$pdf->Cell(4.5,1.0, "",1,1,"c" );	
	
$pdf->setXY(16.0,6.6);
$pdf->Cell(4.5,1.0, "",1,1,"c" );
	
$pdf->SetFont('angsa','',14); 

$pdf->setXY(0.7,4.7);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "ชื่อลูกค้า"),0 ,'L' );
$pdf->setXY(0.7,5.05);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Customer Name"),0 ,'L' );

$pdf->SetFont('angsana','B',14);
$pdf->setXY(2.8,4.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$customer"),0 ,'L' );

 
$pdf->SetFont('angsa','',14);	
$pdf->setXY(0.7,5.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ที่อยู่"),0 ,'L' );
$pdf->setXY(0.7,6.05);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Address"),0 ,'L' );
$pdf->SetFont('angsa','',13);
$pdf->setXY(1.9,5.5);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$address"),0 ,'L' );
	$pdf->SetFont('angsa','',14); 
$pdf->setXY(0.7,6.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "เบอร์โทรศัพท์"),0 ,'L' );
$pdf->setXY(0.7,7.05);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Telephone"),0 ,'L' );

$pdf->setXY(3.2,6.7);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$rental_tel"),0 ,'L' );
	
$pdf->setXY(11.2,4.7);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "ชื่อผู้ติดต่อ"),0 ,'L' );
$pdf->setXY(11.2,5.05);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Contact Name"),0 ,'L' );	
	
$pdf->setXY(11.5,5.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$connect_name"),0 ,'L' );	
	
$pdf->setXY(11.2,6.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "เบอร์โทรศัพท์"),0 ,'L' );
$pdf->setXY(11.2,7.05);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Telephone"),0 ,'L' );	
	
$pdf->setXY(13.2,6.7);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$connect_tel"),0 ,'L' );	

$pdf->setXY(16.2,4.7);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "เลขที่"),0 ,'L' );
$pdf->setXY(16.2,5.05);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "No."),0 ,'L' );	
	
$pdf->setXY(17.3,4.7);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8','cp874' , "$doc_no"),0 ,'L' );

$pdf->setXY(16.2,5.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(16.2,6.05);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(17.3,5.7);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8','cp874' , "$promis_date"),0 ,'L' );
	
$pdf->setXY(16.2,6.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "เลขที่สัญญา"),0 ,'L' );
$pdf->setXY(16.2,7.05);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Contract No."),0 ,'L' );

$pdf->setXY(18.0,6.7);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8','cp874' , "$promis_no"),0 ,'L' );	

$pdf->setXY(0.5,7.7);
$pdf->Cell(10.5,0.8, "",1,1,"c" );

$pdf->setXY(11.0,7.7);
$pdf->Cell(5.0,0.8, "",1,1,"c" );

$pdf->setXY(16.0,7.7);
$pdf->Cell(2.25,0.8, "",1,1,"c" );

$pdf->setXY(18.25,7.7);
$pdf->Cell(2.25,0.8, "",1,1,"c" );	
		
$pdf->setXY(5.3,7.7);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "รายการ"),0 ,'L' );

$pdf->setXY(5.0,8.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "Description"),0 ,'L' );	
	
$pdf->setXY(12.5,7.7);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "หมายเลขเครื่อง"),0 ,'L' );

$pdf->setXY(13.0,8.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "Serial No."),0 ,'L' );	

$pdf->setXY(16.75,7.7);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'L' );

$pdf->setXY(17.0,8.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "Qty"),0 ,'L' );	
	
$pdf->setXY(18.9,7.7);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "หน่วย"),0 ,'L' );

$pdf->setXY(19.0,8.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "Unit"),0 ,'L' );	


$pdf->setXY(0.5,8.5);
$pdf->Cell(10.5,0.8, "",1,1,"c" );

$pdf->setXY(11.0,8.5);
$pdf->Cell(5.0,0.8, "",1,1,"c" );

$pdf->setXY(16.0,8.5);
$pdf->Cell(2.25,0.8, "",1,1,"c" );

$pdf->setXY(18.25,8.5);
$pdf->Cell(2.25,0.8, "",1,1,"c" );		
	
$pdf->SetFont('angsa','',15); 

$pdf->setXY(0.6,8.5);
$pdf->MultiCell(13.0,0.6, iconv( 'UTF-8','cp874' , "$product_name"),0 ,'L' );

$pdf->setXY(11.5,8.5);
$pdf->MultiCell(13.0,0.6, iconv( 'UTF-8','cp874' , "$sn"),0 ,'L' );

$pdf->setXY(17.5,8.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$count"),0 ,'L' );

$pdf->setXY(19.0,8.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$unit_name"),0 ,'L' );


$pdf->SetFont('angsa','',13); 

$pdf->setXY(5.1,9.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รายการตรวจเช็ค"),0 ,'L' );

$pdf->setXY(5.6,9.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Checklist"),0 ,'L' );

$pdf->setXY(11.2,9.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Stock"),0 ,'L' );

$pdf->setXY(12.2,9.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Engineer"),0 ,'L' );

$pdf->setXY(13.5,9.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Service"),0 ,'L' );

$pdf->setXY(14.7,9.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Service"),0 ,'L' );

$pdf->setXY(15.8,9.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Engineer"),0 ,'L' );

$pdf->setXY(17.2,9.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Stock"),0 ,'L' );

$pdf->setXY(18.8,9.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );

$pdf->setXY(18.85,9.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Remarks"),0 ,'L' );

$pdf->setXY(0.5,9.3);
$pdf->Cell(10.5,0.8, "",1,1,"c" );

$pdf->setXY(11.0,9.3);
$pdf->Cell(1.2,0.8, "",1,1,"c" );

$pdf->setXY(12.2,9.3);
$pdf->Cell(1.2,0.8, "",1,1,"c" );

$pdf->setXY(13.4,9.3);
$pdf->Cell(1.2,0.8, "",1,1,"c" );

$pdf->setXY(14.6,9.3);
$pdf->Cell(1.2,0.8, "",1,1,"c" );

$pdf->setXY(15.8,9.3);
$pdf->Cell(1.2,0.8, "",1,1,"c" );

$pdf->setXY(17.0,9.3);
$pdf->Cell(1.2,0.8, "",1,1,"c" );

$pdf->setXY(18.2,9.3);
$pdf->Cell(2.3,0.8, "",1,1,"c" );	
	


$pdf->setXY(0.5,10.1);
$pdf->Cell(10.5,9.05, "",1,1,"c" );

$pdf->setXY(11.05,9.3);
$pdf->Cell(3.50,9.85, "",1,1,"c" );

$pdf->setXY(14.65,9.3);
$pdf->Cell(3.50,9.85, "",1,1,"c" );

$pdf->setXY(11.0,10.1);
$pdf->Cell(1.2,9.05, "",1,1,"c" );

$pdf->setXY(12.2,10.1);
$pdf->Cell(1.2,9.05, "",1,1,"c" );

$pdf->setXY(13.4,10.1);
$pdf->Cell(1.2,9.05, "",1,1,"c" );

$pdf->setXY(14.6,10.1);
$pdf->Cell(1.2,9.05, "",1,1,"c" );

$pdf->setXY(15.8,10.1);
$pdf->Cell(1.2,9.05, "",1,1,"c" );

$pdf->setXY(17.0,10.1);
$pdf->Cell(1.2,9.05, "",1,1,"c" );

$pdf->setXY(18.2,10.1);
$pdf->Cell(2.3,9.05, "",1,1,"c" );





$pdf->setXY(0.55,10.1);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "1.$list_des1"),0 ,'L' );

if($rs1["check1"]=='1'){
$pdf->Image("img/chk32.png",11.4,10.2,0.35,0.35);	
}else if($rs1["check1"]=='2'){
$pdf->Image("img/unc33.png",11.4,10.2,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,10.2,0.35,0.35);	
}


if($rs2["check1"]=='1'){
$pdf->Image("img/chk32.png",12.6,10.2,0.35,0.35);	
}else if($rs2["check1"]=='2'){
$pdf->Image("img/unc33.png",12.6,10.2,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,10.2,0.35,0.35);	
}


if($rs3["check1"]=='1'){
$pdf->Image("img/chk32.png",13.8,10.2,0.35,0.35);	
}else if($rs3["check1"]=='2'){
$pdf->Image("img/unc33.png",13.8,10.2,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,10.2,0.35,0.35);	
}



if($rs4["check1"]=='1'){
$pdf->Image("img/chk32.png",15.0,10.2,0.35,0.35);	
}else if($rs4["check1"]=='2'){
$pdf->Image("img/unc33.png",15.0,10.2,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,10.2,0.35,0.35);	
}


if($rs5["check1"]=='1'){
$pdf->Image("img/chk32.png",16.2,10.2,0.35,0.35);	
}else if($rs5["check1"]=='2'){
$pdf->Image("img/unc33.png",16.2,10.2,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,10.2,0.35,0.35);	
}

if($rs6["check1"]=='1'){
$pdf->Image("img/chk32.png",17.4,10.2,0.35,0.35);	
}else if($rs6["check1"]=='2'){
$pdf->Image("img/unc33.png",17.4,10.2,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,10.2,0.35,0.35);	
}

$pdf->setXY(0.5,10.65);
$pdf->Cell(17.6,0,'','T',0,'C',0);


$pdf->setXY(0.55,10.6);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "2.$list_des2"),0 ,'L' );

if($rs1["check2"]=='1'){
$pdf->Image("img/chk32.png",11.4,10.7,0.35,0.35);	
}else if($rs1["check2"]=='2'){
$pdf->Image("img/unc33.png",11.4,10.7,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,10.7,0.35,0.35);	
}


if($rs2["check2"]=='1'){
$pdf->Image("img/chk32.png",12.6,10.7,0.35,0.35);	
}else if($rs2["check2"]=='2'){
$pdf->Image("img/unc33.png",12.6,10.7,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,10.7,0.35,0.35);	
}


if($rs3["check2"]=='1'){
$pdf->Image("img/chk32.png",13.8,10.7,0.35,0.35);	
}else if($rs3["check2"]=='2'){
$pdf->Image("img/unc33.png",13.8,10.7,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,10.7,0.35,0.35);	
}



if($rs4["check2"]=='1'){
$pdf->Image("img/chk32.png",15.0,10.7,0.35,0.35);	
}else if($rs4["check2"]=='2'){
$pdf->Image("img/unc33.png",15.0,10.7,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,10.7,0.35,0.35);	
}


if($rs5["check2"]=='1'){
$pdf->Image("img/chk32.png",16.2,10.7,0.35,0.35);	
}else if($rs5["check2"]=='2'){
$pdf->Image("img/unc33.png",16.2,10.7,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,10.7,0.35,0.35);	
}

if($rs6["check2"]=='1'){
$pdf->Image("img/chk32.png",17.4,10.7,0.35,0.35);	
}else if($rs6["check2"]=='2'){
$pdf->Image("img/unc33.png",17.4,10.7,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,10.7,0.35,0.35);	
}

$pdf->setXY(0.5,11.15);
$pdf->Cell(17.6,0,'','T',0,'C',0);


$pdf->setXY(0.55,11.1);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "3.$list_des3"),0 ,'L' );

if($rs1["check3"]=='1'){
$pdf->Image("img/chk32.png",11.4,11.2,0.35,0.35);	
}else if($rs1["check3"]=='2'){
$pdf->Image("img/unc33.png",11.4,11.2,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,11.2,0.35,0.35);	
}


if($rs2["check3"]=='1'){
$pdf->Image("img/chk32.png",12.6,11.2,0.35,0.35);	
}else if($rs2["check3"]=='2'){
$pdf->Image("img/unc33.png",12.6,11.2,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,11.2,0.35,0.35);	
}


if($rs3["check3"]=='1'){
$pdf->Image("img/chk32.png",13.8,11.2,0.35,0.35);	
}else if($rs3["check3"]=='2'){
$pdf->Image("img/unc33.png",13.8,11.2,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,11.2,0.35,0.35);	
}



if($rs4["check3"]=='1'){
$pdf->Image("img/chk32.png",15.0,11.2,0.35,0.35);	
}else if($rs4["check3"]=='2'){
$pdf->Image("img/unc33.png",15.0,11.2,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,11.2,0.35,0.35);	
}


if($rs5["check3"]=='1'){
$pdf->Image("img/chk32.png",16.2,11.2,0.35,0.35);	
}else if($rs5["check3"]=='2'){
$pdf->Image("img/unc33.png",16.2,11.2,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,11.2,0.35,0.35);	
}

if($rs6["check3"]=='1'){
$pdf->Image("img/chk32.png",17.4,11.2,0.35,0.35);	
}else if($rs6["check3"]=='2'){
$pdf->Image("img/unc33.png",17.4,11.2,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,11.2,0.35,0.35);	
}

$pdf->setXY(0.5,11.65);
$pdf->Cell(17.6,0,'','T',0,'C',0);





$pdf->setXY(0.55,11.6);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "4.$list_des4"),0 ,'L' );

if($rs1["check4"]=='1'){
$pdf->Image("img/chk32.png",11.4,11.75,0.35,0.35);	
}else if($rs1["check4"]=='2'){
$pdf->Image("img/unc33.png",11.4,11.75,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,11.75,0.35,0.35);	
}


if($rs2["check4"]=='1'){
$pdf->Image("img/chk32.png",12.6,11.75,0.35,0.35);	
}else if($rs2["check4"]=='2'){
$pdf->Image("img/unc33.png",12.6,11.75,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,11.75,0.35,0.35);	
}


if($rs3["check4"]=='1'){
$pdf->Image("img/chk32.png",13.8,11.75,0.35,0.35);	
}else if($rs3["check4"]=='2'){
$pdf->Image("img/unc33.png",13.8,11.75,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,11.75,0.35,0.35);	
}



if($rs4["check4"]=='1'){
$pdf->Image("img/chk32.png",15.0,11.75,0.35,0.35);	
}else if($rs4["check4"]=='2'){
$pdf->Image("img/unc33.png",15.0,11.75,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,11.75,0.35,0.35);	
}


if($rs5["check4"]=='1'){
$pdf->Image("img/chk32.png",16.2,11.75,0.35,0.35);	
}else if($rs5["check4"]=='2'){
$pdf->Image("img/unc33.png",16.2,11.75,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,11.75,0.35,0.35);	
}

if($rs6["check4"]=='1'){
$pdf->Image("img/chk32.png",17.4,11.75,0.35,0.35);	
}else if($rs6["check4"]=='2'){
$pdf->Image("img/unc33.png",17.4,11.75,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,11.75,0.35,0.35);	
}

$pdf->setXY(0.5,12.20);
$pdf->Cell(17.6,0,'','T',0,'C',0);



$pdf->setXY(0.55,12.1);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "5.$list_des5"),0 ,'L' );

if($rs1["check5"]=='1'){
$pdf->Image("img/chk32.png",11.4,12.3,0.35,0.35);	
}else if($rs1["check5"]=='2'){
$pdf->Image("img/unc33.png",11.4,12.3,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,12.3,0.35,0.35);	
}


if($rs2["check5"]=='1'){
$pdf->Image("img/chk32.png",12.6,12.3,0.35,0.35);	
}else if($rs2["check5"]=='2'){
$pdf->Image("img/unc33.png",12.6,12.3,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,12.3,0.35,0.35);	
}


if($rs3["check5"]=='1'){
$pdf->Image("img/chk32.png",13.8,12.3,0.35,0.35);	
}else if($rs3["check5"]=='2'){
$pdf->Image("img/unc33.png",13.8,12.3,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,12.3,0.35,0.35);	
}



if($rs4["check5"]=='1'){
$pdf->Image("img/chk32.png",15.0,12.3,0.35,0.35);	
}else if($rs4["check5"]=='2'){
$pdf->Image("img/unc33.png",15.0,12.3,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,12.3,0.35,0.35);	
}


if($rs5["check5"]=='1'){
$pdf->Image("img/chk32.png",16.2,12.3,0.35,0.35);	
}else if($rs5["check5"]=='2'){
$pdf->Image("img/unc33.png",16.2,12.3,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,12.3,0.35,0.35);	
}

if($rs6["check5"]=='1'){
$pdf->Image("img/chk32.png",17.4,12.3,0.35,0.35);	
}else if($rs6["check5"]=='2'){
$pdf->Image("img/unc33.png",17.4,12.3,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,12.3,0.35,0.35);	
}

$pdf->setXY(0.5,12.7);
$pdf->Cell(17.6,0,'','T',0,'C',0);



$pdf->setXY(0.55,12.65);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "6.$list_des6"),0 ,'L' );

if($rs1["check6"]=='1'){
$pdf->Image("img/chk32.png",11.4,12.8,0.35,0.35);	
}else if($rs1["check6"]=='2'){
$pdf->Image("img/unc33.png",11.4,12.8,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,12.8,0.35,0.35);	
}


if($rs2["check6"]=='1'){
$pdf->Image("img/chk32.png",12.6,12.8,0.35,0.35);	
}else if($rs2["check6"]=='2'){
$pdf->Image("img/unc33.png",12.6,12.8,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,12.8,0.35,0.35);	
}


if($rs3["check6"]=='1'){
$pdf->Image("img/chk32.png",13.8,12.8,0.35,0.35);	
}else if($rs3["check6"]=='2'){
$pdf->Image("img/unc33.png",13.8,12.8,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,12.8,0.35,0.35);	
}



if($rs4["check6"]=='1'){
$pdf->Image("img/chk32.png",15.0,12.8,0.35,0.35);	
}else if($rs4["check6"]=='2'){
$pdf->Image("img/unc33.png",15.0,12.8,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,12.8,0.35,0.35);	
}


if($rs5["check6"]=='1'){
$pdf->Image("img/chk32.png",16.2,12.8,0.35,0.35);	
}else if($rs5["check6"]=='2'){
$pdf->Image("img/unc33.png",16.2,12.8,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,12.8,0.35,0.35);	
}

if($rs6["check6"]=='1'){
$pdf->Image("img/chk32.png",17.4,12.8,0.35,0.35);	
}else if($rs6["check6"]=='2'){
$pdf->Image("img/unc33.png",17.4,12.8,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,12.8,0.35,0.35);	
}


$pdf->setXY(0.5,13.2);
$pdf->Cell(17.6,0,'','T',0,'C',0);


$pdf->setXY(0.55,13.15);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "7.$list_des7"),0 ,'L' );

if($rs1["check7"]=='1'){
$pdf->Image("img/chk32.png",11.4,13.28,0.35,0.35);	
}else if($rs1["check7"]=='2'){
$pdf->Image("img/unc33.png",11.4,13.28,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,13.28,0.35,0.35);	
}


if($rs2["check7"]=='1'){
$pdf->Image("img/chk32.png",12.6,13.28,0.35,0.35);	
}else if($rs2["check7"]=='2'){
$pdf->Image("img/unc33.png",12.6,13.28,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,13.28,0.35,0.35);	
}


if($rs3["check7"]=='1'){
$pdf->Image("img/chk32.png",13.8,13.28,0.35,0.35);	
}else if($rs3["check7"]=='2'){
$pdf->Image("img/unc33.png",13.8,13.28,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,13.28,0.35,0.35);	
}



if($rs4["check7"]=='1'){
$pdf->Image("img/chk32.png",15.0,13.28,0.35,0.35);	
}else if($rs4["check7"]=='2'){
$pdf->Image("img/unc33.png",15.0,13.28,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,13.28,0.35,0.35);	
}


if($rs5["check7"]=='1'){
$pdf->Image("img/chk32.png",16.2,13.28,0.35,0.35);	
}else if($rs5["check7"]=='2'){
$pdf->Image("img/unc33.png",16.2,13.28,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,13.28,0.35,0.35);	
}

if($rs6["check7"]=='1'){
$pdf->Image("img/chk32.png",17.4,13.28,0.35,0.35);	
}else if($rs6["check7"]=='2'){
$pdf->Image("img/unc33.png",17.4,13.28,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,13.28,0.35,0.35);	
}


$pdf->setXY(0.5,13.7);
$pdf->Cell(17.6,0,'','T',0,'C',0);


$pdf->setXY(0.55,13.7);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "8.$list_des8"),0 ,'L' );

if($rs1["check8"]=='1'){
$pdf->Image("img/chk32.png",11.4,13.8,0.35,0.35);	
}else if($rs1["check8"]=='2'){
$pdf->Image("img/unc33.png",11.4,13.8,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,13.8,0.35,0.35);	
}


if($rs2["check8"]=='1'){
$pdf->Image("img/chk32.png",12.6,13.8,0.35,0.35);	
}else if($rs2["check8"]=='2'){
$pdf->Image("img/unc33.png",12.6,13.8,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,13.8,0.35,0.35);	
}


if($rs3["check8"]=='1'){
$pdf->Image("img/chk32.png",13.8,13.8,0.35,0.35);	
}else if($rs3["check8"]=='2'){
$pdf->Image("img/unc33.png",13.8,13.8,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,13.8,0.35,0.35);	
}



if($rs4["check8"]=='1'){
$pdf->Image("img/chk32.png",15.0,13.8,0.35,0.35);	
}else if($rs4["check8"]=='2'){
$pdf->Image("img/unc33.png",15.0,13.8,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,13.8,0.35,0.35);	
}


if($rs5["check8"]=='1'){
$pdf->Image("img/chk32.png",16.2,13.8,0.35,0.35);	
}else if($rs5["check8"]=='2'){
$pdf->Image("img/unc33.png",16.2,13.8,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,13.8,0.35,0.35);	
}

if($rs6["check8"]=='1'){
$pdf->Image("img/chk32.png",17.4,13.8,0.35,0.35);	
}else if($rs6["check8"]=='2'){
$pdf->Image("img/unc33.png",17.4,13.8,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,13.8,0.35,0.35);	
}

$pdf->setXY(0.5,14.25);
$pdf->Cell(17.6,0,'','T',0,'C',0);



$pdf->setXY(0.55,14.20);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "9.$list_des9"),0 ,'L' );

if($rs1["check9"]=='1'){
$pdf->Image("img/chk32.png",11.4,14.3,0.35,0.35);	
}else if($rs1["check9"]=='2'){
$pdf->Image("img/unc33.png",11.4,14.3,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,14.3,0.35,0.35);	
}


if($rs2["check9"]=='1'){
$pdf->Image("img/chk32.png",12.6,14.3,0.35,0.35);	
}else if($rs2["check9"]=='2'){
$pdf->Image("img/unc33.png",12.6,14.3,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,14.3,0.35,0.35);	
}


if($rs3["check9"]=='1'){
$pdf->Image("img/chk32.png",13.8,14.3,0.35,0.35);	
}else if($rs3["check9"]=='2'){
$pdf->Image("img/unc33.png",13.8,14.3,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,14.3,0.35,0.35);	
}



if($rs4["check9"]=='1'){
$pdf->Image("img/chk32.png",15.0,14.3,0.35,0.35);	
}else if($rs4["check9"]=='2'){
$pdf->Image("img/unc33.png",15.0,14.3,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,14.3,0.35,0.35);	
}


if($rs5["check9"]=='1'){
$pdf->Image("img/chk32.png",16.2,14.3,0.35,0.35);	
}else if($rs5["check9"]=='2'){
$pdf->Image("img/unc33.png",16.2,14.3,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,14.3,0.35,0.35);	
}

if($rs6["check9"]=='1'){
$pdf->Image("img/chk32.png",17.4,14.3,0.35,0.35);	
}else if($rs6["check9"]=='2'){
$pdf->Image("img/unc33.png",17.4,14.3,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,14.3,0.35,0.35);	
}

$pdf->setXY(0.5,14.75);
$pdf->Cell(17.6,0,'','T',0,'C',0);

$pdf->SetFont('angsa','',11);

$pdf->setXY(18.2,10.1);
$pdf->MultiCell(2.3,0.5, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "ขาไป : $des_all"),0 ,'L' );

$pdf->setXY(18.2,14.75);
$pdf->Cell(2.0,0.5, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "ขากลับ :"),0 ,'L' );
$pdf->setXY(18.2,15.0);
$pdf->MultiCell(2.3,0.4, iconv( 'UTF-8','cp874' , "$des_all1"),0 ,'L' );


$pdf->SetFont('angsa','',13);

$pdf->setXY(0.55,14.75);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "10.$list_des10"),0 ,'L' );

if($rs1["check10"]=='1'){
$pdf->Image("img/chk32.png",11.4,14.85,0.35,0.35);	
}else if($rs1["check10"]=='2'){
$pdf->Image("img/unc33.png",11.4,14.85,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,14.85,0.35,0.35);	
}


if($rs2["check10"]=='1'){
$pdf->Image("img/chk32.png",12.6,14.85,0.35,0.35);	
}else if($rs2["check10"]=='2'){
$pdf->Image("img/unc33.png",12.6,14.85,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,14.85,0.35,0.35);	
}


if($rs3["check10"]=='1'){
$pdf->Image("img/chk32.png",13.8,14.85,0.35,0.35);	
}else if($rs3["check10"]=='2'){
$pdf->Image("img/unc33.png",13.8,14.85,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,14.85,0.35,0.35);	
}



if($rs4["check10"]=='1'){
$pdf->Image("img/chk32.png",15.0,14.85,0.35,0.35);	
}else if($rs4["check10"]=='2'){
$pdf->Image("img/unc33.png",15.0,14.85,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,14.85,0.35,0.35);	
}


if($rs5["check10"]=='1'){
$pdf->Image("img/chk32.png",16.2,14.85,0.35,0.35);	
}else if($rs5["check10"]=='2'){
$pdf->Image("img/unc33.png",16.2,14.85,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,14.85,0.35,0.35);	
}

if($rs6["check10"]=='1'){
$pdf->Image("img/chk32.png",17.4,14.85,0.35,0.35);	
}else if($rs6["check10"]=='2'){
$pdf->Image("img/unc33.png",17.4,14.85,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,14.85,0.35,0.35);	
}

$pdf->setXY(0.5,15.3);
$pdf->Cell(17.6,0,'','T',0,'C',0);


$pdf->setXY(0.55,15.25);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "11.$list_des11"),0 ,'L' );

if($rs1["check11"]=='1'){
$pdf->Image("img/chk32.png",11.4,15.4,0.35,0.35);	
}else if($rs1["check11"]=='2'){
$pdf->Image("img/unc33.png",11.4,15.4,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,15.4,0.35,0.35);	
}


if($rs2["check11"]=='1'){
$pdf->Image("img/chk32.png",12.6,15.4,0.35,0.35);	
}else if($rs2["check11"]=='2'){
$pdf->Image("img/unc33.png",12.6,15.4,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,15.4,0.35,0.35);	
}


if($rs3["check11"]=='1'){
$pdf->Image("img/chk32.png",13.8,15.4,0.35,0.35);	
}else if($rs3["check11"]=='2'){
$pdf->Image("img/unc33.png",13.8,15.4,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,15.4,0.35,0.35);	
}



if($rs4["check11"]=='1'){
$pdf->Image("img/chk32.png",15.0,15.4,0.35,0.35);	
}else if($rs4["check11"]=='2'){
$pdf->Image("img/unc33.png",15.0,15.4,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,15.4,0.35,0.35);	
}


if($rs5["check11"]=='1'){
$pdf->Image("img/chk32.png",16.2,15.4,0.35,0.35);	
}else if($rs5["check11"]=='2'){
$pdf->Image("img/unc33.png",16.2,15.4,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,15.4,0.35,0.35);	
}

if($rs6["check11"]=='1'){
$pdf->Image("img/chk32.png",17.4,15.4,0.35,0.35);	
}else if($rs6["check11"]=='2'){
$pdf->Image("img/unc33.png",17.4,15.4,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,15.4,0.35,0.35);	
}

$pdf->setXY(0.5,15.85);
$pdf->Cell(17.6,0,'','T',0,'C',0);



$pdf->setXY(0.55,15.85);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "12.$list_des12"),0 ,'L' );

if($rs1["check12"]=='1'){
$pdf->Image("img/chk32.png",11.4,15.95,0.35,0.35);	
}else if($rs1["check12"]=='2'){
$pdf->Image("img/unc33.png",11.4,15.95,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,15.95,0.35,0.35);	
}


if($rs2["check12"]=='1'){
$pdf->Image("img/chk32.png",12.6,15.95,0.35,0.35);	
}else if($rs2["check12"]=='2'){
$pdf->Image("img/unc33.png",12.6,15.95,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,15.95,0.35,0.35);	
}


if($rs3["check12"]=='1'){
$pdf->Image("img/chk32.png",13.8,15.95,0.35,0.35);	
}else if($rs3["check12"]=='2'){
$pdf->Image("img/unc33.png",13.8,15.95,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,15.95,0.35,0.35);	
}



if($rs4["check12"]=='1'){
$pdf->Image("img/chk32.png",15.0,15.95,0.35,0.35);	
}else if($rs4["check12"]=='2'){
$pdf->Image("img/unc33.png",15.0,15.95,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,15.95,0.35,0.35);	
}


if($rs5["check12"]=='1'){
$pdf->Image("img/chk32.png",16.2,15.95,0.35,0.35);	
}else if($rs5["check12"]=='2'){
$pdf->Image("img/unc33.png",16.2,15.95,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,15.95,0.35,0.35);	
}

if($rs6["check12"]=='1'){
$pdf->Image("img/chk32.png",17.4,15.95,0.35,0.35);	
}else if($rs6["check12"]=='2'){
$pdf->Image("img/unc33.png",17.4,15.95,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,15.95,0.35,0.35);	
}


$pdf->setXY(0.5,16.4);
$pdf->Cell(17.6,0,'','T',0,'C',0);



$pdf->setXY(0.55,16.35);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "13.$list_des13"),0 ,'L' );

if($rs1["check13"]=='1'){
$pdf->Image("img/chk32.png",11.4,16.5,0.35,0.35);	
}else if($rs1["check13"]=='2'){
$pdf->Image("img/unc33.png",11.4,16.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,16.5,0.35,0.35);	
}


if($rs2["check13"]=='1'){
$pdf->Image("img/chk32.png",12.6,16.5,0.35,0.35);	
}else if($rs2["check13"]=='2'){
$pdf->Image("img/unc33.png",12.6,16.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,16.5,0.35,0.35);	
}


if($rs3["check13"]=='1'){
$pdf->Image("img/chk32.png",13.8,16.5,0.35,0.35);	
}else if($rs3["check13"]=='2'){
$pdf->Image("img/unc33.png",13.8,16.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,16.5,0.35,0.35);	
}



if($rs4["check13"]=='1'){
$pdf->Image("img/chk32.png",15.0,16.5,0.35,0.35);	
}else if($rs4["check13"]=='2'){
$pdf->Image("img/unc33.png",15.0,16.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,16.5,0.35,0.35);	
}


if($rs5["check13"]=='1'){
$pdf->Image("img/chk32.png",16.2,16.5,0.35,0.35);	
}else if($rs5["check13"]=='2'){
$pdf->Image("img/unc33.png",16.2,16.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,16.5,0.35,0.35);	
}

if($rs6["check13"]=='1'){
$pdf->Image("img/chk32.png",17.4,16.5,0.35,0.35);	
}else if($rs6["check13"]=='2'){
$pdf->Image("img/unc33.png",17.4,16.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,16.5,0.35,0.35);	
}


$pdf->setXY(0.5,16.9);
$pdf->Cell(17.6,0,'','T',0,'C',0);




$pdf->setXY(0.55,16.85);
$pdf->Cell(15,0.6, iconv( 'UTF-8','cp874' , "14.$list_des14"),0 ,'L' );

if($rs1["check14"]=='1'){
$pdf->Image("img/chk32.png",11.4,17.0,0.35,0.35);	
}else if($rs1["check14"]=='2'){
$pdf->Image("img/unc33.png",11.4,17.0,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,17.0,0.35,0.35);	
}


if($rs2["check14"]=='1'){
$pdf->Image("img/chk32.png",12.6,17.0,0.35,0.35);	
}else if($rs2["check14"]=='2'){
$pdf->Image("img/unc33.png",12.6,17.0,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,17.0,0.35,0.35);	
}


if($rs3["check14"]=='1'){
$pdf->Image("img/chk32.png",13.8,17.0,0.35,0.35);	
}else if($rs3["check14"]=='2'){
$pdf->Image("img/unc33.png",13.8,17.0,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,17.0,0.35,0.35);	
}



if($rs4["check14"]=='1'){
$pdf->Image("img/chk32.png",15.0,17.0,0.35,0.35);	
}else if($rs4["check14"]=='2'){
$pdf->Image("img/unc33.png",15.0,17.0,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,17.0,0.35,0.35);	
}


if($rs5["check14"]=='1'){
$pdf->Image("img/chk32.png",16.2,17.0,0.35,0.35);	
}else if($rs5["check14"]=='2'){
$pdf->Image("img/unc33.png",16.2,17.0,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,17.0,0.35,0.35);	
}

if($rs6["check14"]=='1'){
$pdf->Image("img/chk32.png",17.4,17.0,0.35,0.35);	
}else if($rs6["check14"]=='2'){
$pdf->Image("img/unc33.png",17.4,17.0,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,17.0,0.35,0.35);	
}


$pdf->setXY(0.5,17.4);
$pdf->Cell(17.6,0,'','T',0,'C',0);


$pdf->setXY(0.55,17.35);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "15.$list_des15"),0 ,'L' ); 

if($rs1["check15"]=='1'){
$pdf->Image("img/chk32.png",11.4,17.5,0.35,0.35);	
}else if($rs1["check15"]=='2'){
$pdf->Image("img/unc33.png",11.4,17.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,17.5,0.35,0.35);	
}


if($rs2["check15"]=='1'){
$pdf->Image("img/chk32.png",12.6,17.5,0.35,0.35);	
}else if($rs2["check15"]=='2'){
$pdf->Image("img/unc33.png",12.6,17.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,17.5,0.35,0.35);	
}


if($rs3["check15"]=='1'){
$pdf->Image("img/chk32.png",13.8,17.5,0.35,0.35);	
}else if($rs3["check15"]=='2'){
$pdf->Image("img/unc33.png",13.8,17.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,17.5,0.35,0.35);	
}



if($rs4["check15"]=='1'){
$pdf->Image("img/chk32.png",15.0,17.5,0.35,0.35);	
}else if($rs4["check15"]=='2'){
$pdf->Image("img/unc33.png",15.0,17.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,17.5,0.35,0.35);	
}


if($rs5["check15"]=='1'){
$pdf->Image("img/chk32.png",16.2,17.5,0.35,0.35);	
}else if($rs5["check15"]=='2'){
$pdf->Image("img/unc33.png",16.2,17.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,17.5,0.35,0.35);	
}

if($rs6["check15"]=='1'){
$pdf->Image("img/chk32.png",17.4,17.5,0.35,0.35);	
}else if($rs6["check15"]=='2'){
$pdf->Image("img/unc33.png",17.4,17.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,17.5,0.35,0.35);	
}


$pdf->setXY(0.55,17.85);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "16.$list_des16"),0 ,'L' ); 

if($rs1["check16"]=='1'){
$pdf->Image("img/chk32.png",11.4,18.0,0.35,0.35);	
}else if($rs1["check16"]=='2'){
$pdf->Image("img/unc33.png",11.4,18.0,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,18.0,0.35,0.35);	
}


if($rs2["check16"]=='1'){
$pdf->Image("img/chk32.png",12.6,18.0,0.35,0.35);	
}else if($rs2["check16"]=='2'){
$pdf->Image("img/unc33.png",12.6,18.0,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,18.0,0.35,0.35);	
}


if($rs3["check16"]=='1'){
$pdf->Image("img/chk32.png",13.8,18.0,0.35,0.35);	
}else if($rs3["check16"]=='2'){
$pdf->Image("img/unc33.png",13.8,18.0,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,18.0,0.35,0.35);	
}



if($rs4["check16"]=='1'){
$pdf->Image("img/chk32.png",15.0,18.0,0.35,0.35);	
}else if($rs4["check16"]=='2'){
$pdf->Image("img/unc33.png",15.0,18.0,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,18.0,0.35,0.35);	
}


if($rs5["check16"]=='1'){
$pdf->Image("img/chk32.png",16.2,18.0,0.35,0.35);	
}else if($rs5["check16"]=='2'){
$pdf->Image("img/unc33.png",16.2,18.0,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,18.0,0.35,0.35);	
}

if($rs6["check16"]=='1'){
$pdf->Image("img/chk32.png",17.4,18.0,0.35,0.35);	
}else if($rs6["check16"]=='2'){
$pdf->Image("img/unc33.png",17.4,18.0,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,18.0,0.35,0.35);	
}


$pdf->setXY(0.5,18.45);
$pdf->Cell(17.6,0,'','T',0,'C',0);

$pdf->setXY(0.55,18.35);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "17.$list_des17"),0 ,'L' ); 

if($rs1["check17"]=='1'){
$pdf->Image("img/chk32.png",11.4,18.5,0.35,0.35);	
}else if($rs1["check17"]=='2'){
$pdf->Image("img/unc33.png",11.4,18.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",11.4,18.5,0.35,0.35);	
}


if($rs2["check17"]=='1'){
$pdf->Image("img/chk32.png",12.6,18.5,0.35,0.35);	
}else if($rs2["check17"]=='2'){
$pdf->Image("img/unc33.png",12.6,18.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",12.6,18.5,0.35,0.35);	
}


if($rs3["check17"]=='1'){
$pdf->Image("img/chk32.png",13.8,18.5,0.35,0.35);	
}else if($rs3["check17"]=='2'){
$pdf->Image("img/unc33.png",13.8,18.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",13.8,18.5,0.35,0.35);	
}



if($rs4["check17"]=='1'){
$pdf->Image("img/chk32.png",15.0,18.5,0.35,0.35);	
}else if($rs4["check17"]=='2'){
$pdf->Image("img/unc33.png",15.0,18.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",15.0,18.5,0.35,0.35);	
}


if($rs5["check17"]=='1'){
$pdf->Image("img/chk32.png",16.2,18.5,0.35,0.35);	
}else if($rs5["check17"]=='2'){
$pdf->Image("img/unc33.png",16.2,18.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",16.2,18.5,0.35,0.35);	
}

if($rs6["check17"]=='1'){
$pdf->Image("img/chk32.png",17.4,18.5,0.35,0.35);	
}else if($rs6["check17"]=='2'){
$pdf->Image("img/unc33.png",17.4,18.5,0.35,0.35);	
}else{
$pdf->Image("img/unc32.png",17.4,18.5,0.35,0.35);	
}


$pdf->setXY(0.5,17.95);
$pdf->Cell(17.6,0,'','T',0,'C',0);

$pdf->SetFont('angsa','',12); 
$pdf->setXY(0.5,19.15);
$pdf->Cell(10.5,0.7, "",1,1,"c" );

$pdf->setXY(11.0,19.15);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(11.0,19.15);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs1["name_s"]),0,0,'C' );

$pdf->setXY(12.2,19.15);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(12.2,19.15);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs2["name_s"]),0,0,'C' );

$pdf->setXY(13.4,19.15);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(13.4,19.15);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs3["name_s"]),0,0,'C' );


$pdf->setXY(14.6,19.15);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,19.15);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs4["name_s"]),0,0,'C' );

$pdf->setXY(15.8,19.15);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(15.8,19.15);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs5["name_s"]),0,0,'C' );

$pdf->setXY(17.0,19.15);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(17.0,19.15);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs6["name_s"]),0,0,'C' );

$pdf->setXY(18.2,19.15);
$pdf->Cell(2.3,0.7, "",1,1,"c" );


$pdf->setXY(5.4,19.05);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ดำเนินการ"),0 ,'L' );


$pdf->setXY(0.5,19.8);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->SetFont('angsana','B',12);

$pdf->setXY(0.55,19.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ส่งสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',12); 

$pdf->setXY(2.0,19.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ได้รับสินค้าข้างต้นในสภาพเรียบร้อยสมบูรณ์"),0 ,'L' );

$pdf->setXY(2.0,20.2);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Received the above mentioned good order and condition"),0 ,'L' );

$cus_receive=$objResult3["cus_receive"];
$receive_date = Datethai($objResult3["receive_date"]);

if($objResult3["cus_receive"]!=''){
$pdf->Image("$cus_receive",2.5,20.8,1.5,0.5,'png');	

$pdf->setXY(7.5,20.8);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$receive_date),0 ,'L' );
}

$pdf->setXY(0.55,20.9);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้รับ...........................................................................วันที่.........................................................."),0 ,'L' );

$pdf->setXY(0.55,21.2);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Received by"),0 ,'L' );

$pdf->setXY(6.3,21.2);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$emp_send = $objResult3["emp_send"];
$emp_date = Datethai($objResult3["emp_date"]);

if($emp_send !=''){
	
$pdf->Image("$emp_send",12.5,20.2,2.5,1.0,'png');	

$pdf->setXY(17.5,20.8);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$emp_date),0 ,'L' );

}

$pdf->setXY(11.05,20.9);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่ง......................................................................วันที่................................................."),0 ,'L' );

$pdf->setXY(11.05,21.2);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Delivery by"),0 ,'L' );

$pdf->setXY(16.45,21.2);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );





$pdf->setXY(0.5,19.8);
$pdf->Cell(10.5,2.0, "",1,1,"c" );

$pdf->setXY(11.0,19.8);
$pdf->Cell(9.5,2.0, "",1,1,"c" );

$pdf->setXY(0.5,21.8);
$pdf->Cell(10.5,4.0,"",1,1,"c" );


$pdf->setXY(0.5,21.8);
$pdf->Cell(1.5,0.6, "",1,1,"c" );

$pdf->SetFont('angsana','B',12);

$pdf->setXY(0.55,21.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รับคืนสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',12); 

if($objResult3["cs_ckk"]=='1'){
$pdf->Image("img/chk32.png",3.2,21.9,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",3.2,21.9,0.4,0.4);	
}

$pdf->setXY(3.9,21.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สินค้าสมบูรณ์"),0 ,'L' );

if($objResult3["cs_ckk"]=='2'){
$pdf->Image("img/chk32.png",6.2,21.9,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",6.2,21.9,0.4,0.4);	
}

$pdf->setXY(6.9,21.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สินค้าไม่สมบูรณ์"),0 ,'L' );

$pdf->setXY(0.6,22.4);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "..................................................................................................................................................."),0 ,'L' );

$pdf->setXY(0.6,22.9);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "..................................................................................................................................................."),0 ,'L' );

$pdf->setXY(0.6,23.5);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "..................................................................................................................................................."),0 ,'L' );

$pdf->setXY(0.6,22.35);
$pdf->MultiCell(11.0,0.5, iconv( 'UTF-8','cp874' ,$objResult3["des_receive"]),0 ,'L' );


$cus_send = $objResult3["cus_send"];
$cus_datesend = Datethai($objResult3["cus_datesend"]);

if($cus_send !=''){
	
$pdf->Image("$cus_send",2.8,24.0,1.5,0.5,'png');	

$pdf->setXY(7.9,23.3);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$cus_datesend),0 ,'L' );

}

$pdf->setXY(0.55,24.1);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่งคืน...........................................................................วันที่......................................................"),0 ,'L' );	


$pdf->setXY(0.55,24.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Returned by"),0 ,'L' );

$pdf->setXY(6.6,24.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

	


$emp_receive = $objResult3["emp_receive"];
$emp_redate = Datethai($objResult3["emp_redate"]);

if($emp_receive !=''){
	
$pdf->Image("$emp_receive",3.2,24.5,2.0,0.7,'png');	

$pdf->setXY(7.9,24.8);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$emp_redate),0 ,'L' );

}

$pdf->setXY(0.55,24.9);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "แผนกบริการลูกค้า........................................................วันที่......................................................"),0 ,'L' );

$pdf->setXY(0.55,25.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Checked by"),0 ,'L' );

$pdf->setXY(6.6,25.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );



$pdf->setXY(11.0,21.8);
$pdf->Cell(9.5,4.0, "",1,1,"c" );

$pdf->setXY(11.0,21.8);
$pdf->Cell(1.5,0.6, "",1,1,"c" );

$pdf->SetFont('angsana','B',12);

$pdf->setXY(11.05,21.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สินค้า"),0 ,'L' );


$pdf->SetFont('angsa','',12); 

if($objResult3["stock_ckk"]=='1'){
$pdf->Image("img/chk32.png",13.6,21.9,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",13.6,21.9,0.4,0.4);	
}

$pdf->setXY(14.4,21.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สมบูรณ์"),0 ,'L' );

if($objResult3["stock_ckk"]=='2'){
$pdf->Image("img/chk32.png",16.2,21.9,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.2,21.9,0.4,0.4);	
}

$pdf->setXY(16.9,21.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ไม่สมบูรณ์"),0 ,'L' );



$pdf->setXY(11.05,22.4);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "......................................................................................................................................"),0 ,'L' );

$pdf->setXY(11.05,22.9);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "......................................................................................................................................"),0 ,'L' );

$pdf->setXY(11.05,23.5);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "......................................................................................................................................"),0 ,'L' );

$pdf->setXY(11.05,25.35);
$pdf->MultiCell(10.0,0.5, iconv( 'UTF-8','cp874' ,$objResult3["stock_des"]),0 ,'L' );

$stock_name = $objResult3["stock_name"];
$stock_date = Datethai($objResult3["stock_date"]);

if($emp_receive !=''){
	
$pdf->setXY(12.5,24.8);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$stock_name),0 ,'L' );	

$pdf->setXY(17.9,24.8);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$stock_date),0 ,'L' );
}


$pdf->setXY(11.05,24.9);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "คลังสินค้า..................................................................วันที่............................................"),0 ,'L' );

$pdf->setXY(11.05,25.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Stock"),0 ,'L' );

$pdf->setXY(16.9,25.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );








$pdf->SetFont('angsa','',11); 

$pdf->setXY(0.55,28.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 15 พ.ค.2551"),0 ,'L' );

$pdf->setXY(11.4,28.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FM-OF-20:Rev.0"),0 ,'R' );
//}


$pdf->Output();

?>


