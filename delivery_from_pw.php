<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 16px; color: #000000;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {font-size: 16px; color: #FF0000; }
.style39 {font-size: 14px; color: #000000;}
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

<style>
		body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font: 16pt "Angsana New";
    }
	table {
	  border-collapse: collapse;
	  font-size:14pt;
	}
	.tablel {
	  border-collapse: collapse;
	  font-size:10pt;
	}
	.tablepr {
	  border-collapse: collapse;
	  font-size:12pt;
	}
	.tablep, .tr, .td {
	  border: 1px solid black;
	}
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 210mm;
        max-height: 297mm;
        padding-left: 10mm;
		padding-right: 10mm;
		padding-top: 5mm;
		padding-bottom: 0mm;
        margin: 0mm auto;
        /*border: 0px #D3D3D3 solid;
        border-radius: 0px;*/
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0);
    }
    
    @page {
        size: A4;
        margin: 0;
    }
	@page Section1 {size:841.7pt 595.45pt; margin:1.0in 1.25in 1.0in 1.25in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
	div.Section1 {page:Section1;}
	@page Section2 {size:595.45pt 841.7pt;mso-page-orientation:landscape;margin:0.4in 0.4in 0.4in 0.4in;mso-header-margin:.4in;mso-footer-margin:.4in;mso-paper-source:0;}
	div.Section2 {page:Section2;}

	@media screen {
	  div.divFooter {
		display: none;
	  }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;
			margin: 0;
			 div.divFooter {
				position: fixed;
				bottom: 0;
			 }
        }
    }
	h1,h2,h3,h4,h5,h6 {
		font: 18pt "Angsana New";
	}
</style>

<?php
 

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

$ref_id=$_GET["ref_id"];



include"dbconnect.php";

$strSQL = "SELECT * FROM hos__rental  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$ref_id =$objResult["ref_id"];
$customer =$objResult["rental_name"];
$address =$objResult["rental_address"];
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



?>
<div class="Section2 page">
<body>

<table style="width:100%;">
	<tr>
		<td style="width:30%;text-align:left;">
			<div align="left">
			<b>บริษัท ออลล์เวล ไลฟ์ จำกัด</b><br>
			73,75 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ<br>
			เขตบางพลัด กรุงเทพมหานคร 10700<br>
			โทร : 0-2424-3555 (อัตโนมัติ)<br>
			แฟ็กซ์ : 0-2424-3322
			</div>
		 </td>
		<td style="width:40%;text-align:center;"><img src="img/allwell_logo.png" width="200" align="center" height="60" /><br><font size="5"><b>ใบรับส่งสินค้า</b></font><br><font size="4">(Delivery Order)</font></td>
		<td style="width:30%;text-align:right;"><span align="right">
			<div align="right">
			<b>ALLWELL LIFE CO., LTD.</b><br>
			73,75 Soi Charansanitwong 89/2,<br>
			Bang-Or, Bang-Plad,Bankok 10700<br>
			TEL : 0-2424-3555 (Auto)<br>
			FAX : 0-2424-3322	
			</div></span></td>
	</tr>
</table>

<table style="width:100%;" border="1">
	<tr>
		<td style="width:50%;text-align:left;">
			<b>ชื่อลูกค้า :</b> <?php echo $customer; ?><br>
			<b>ที่อยู่ :</b> <?php echo $address; ?><br>
			<b>เบอร์โทรศัพท์ :</b> <?php echo $rental_tel; ?><br>
		</td>
		<td style="width:30%;text-align:left;">
			<b>ชื่อผู้ติดต่อ</b> <?php echo $connect_name; ?><br>
			<b>เบอร์โทรศัพท์ :</b> <?php echo $connect_tel; ?><br>
		</td>
		<td  style="width:20%;">
		<b>เลขที่</b> <?php echo $doc_no; ?><br>
		<b>วันที่</b> <?php echo $promis_date; ?><br>
		<b>เลขที่สัญญา</b> <?php echo $promis_no; ?><br>
		</td>
		</tr>
</table>
	
<table style="width:100%;" border="1">
	<tr>
	<td style="width:50%;text-align:center;">รายการ</td>	
	<td style="width:30%;text-align:center;">หมายเลขเครื่อง</td>	
	<td style="width:10%;text-align:center;">จำนวน</td>	
	<td style="width:10%;text-align:center;">หน่วย</td>		
	</tr>	
	<tr>
	<td style="text-align:center;"><?php echo $product_name; ?></td>
		<td style="text-align:center;"><?php echo $sn; ?></td>
		<td  style="text-align:right;"><?php echo $count; ?></td>
		<td  style="text-align:right;"><?php echo $unit_name; ?></td>
		</tr>
</table>
	
<table style="width:100%;" border="1">
	<tr>
	<td style="width:40%;text-align:center;">รายการตรวจเช็ค</td>	
	<td style="width:2%;text-align:center;">Stock</td>	
	<td style="width:8%;text-align:center;">หมายเหตุ</td>		
	<td style="width:2%;text-align:center;">Engineer</td>
	<td style="width:8%;text-align:center;">หมายเหตุ</td>		
	<td style="width:2%;text-align:center;">Service</td>
	<td style="width:8%;text-align:center;">หมายเหตุ</td>		
	<td style="width:2%;text-align:center;">Service</td>
	<td style="width:8%;text-align:center;">หมายเหตุ</td>		
	<td style="width:2%;text-align:center;">Engineer</td>
	<td style="width:8%;text-align:center;">หมายเหตุ</td>		
	<td style="width:2%;text-align:center;">Stock</td>
	<td style="width:8%;text-align:center;">หมายเหตุ</td>		
		
	</tr>	
	
   <tr>
	<td ><?php echo $list_des1; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check1"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check1"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des1"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check1"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check1"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des1"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check1"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check1"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des1"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check1"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check1"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des1"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check1"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check1"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des1"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check1"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check1"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des1"]; ?></td>		
		
	</tr>		
	
 <tr>
	<td ><?php echo $list_des2; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check2"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check2"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des2"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check2"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check2"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des2"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check2"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check2"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des2"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check2"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check2"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des2"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check2"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check2"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des2"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check2"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check2"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des2"]; ?></td>		
		
	</tr>			
	
	
	
	 <tr>
	<td ><?php echo $list_des3; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check3"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check3"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des3"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check3"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check3"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des3"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check3"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check3"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des3"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check3"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check3"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des3"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check3"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check3"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des3"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check3"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check3"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des3"]; ?></td>		
		
	</tr>		
	
	 <tr>
	<td ><?php echo $list_des4; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check4"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check4"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des4"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check4"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check4"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des4"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check4"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check4"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des4"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check4"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check4"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des4"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check4"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check4"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des4"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check4"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check4"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des4"]; ?></td>		
		
	</tr>		
	
	
 <tr>
	<td ><?php echo $list_des5; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check5"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check5"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des5"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check5"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check5"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des5"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check5"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check5"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des5"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check5"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check5"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des5"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check5"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check5"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des5"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check5"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check5"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des5"]; ?></td>		
		
	</tr>			
	
 <tr>
	<td ><?php echo $list_des6; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check6"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check6"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des6"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check6"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check6"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des6"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check6"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check6"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des6"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check6"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check6"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des6"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check6"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check6"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des6"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check6"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check6"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des6"]; ?></td>		
		
	</tr>			
	
 <tr>
	<td ><?php echo $list_des7; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check7"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check7"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des7"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check7"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check7"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des7"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check7"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check7"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des7"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check7"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check7"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des7"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check7"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check7"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des7"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check7"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check7"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des7"]; ?></td>		
		
	</tr>			
	
 <tr>
	<td ><?php echo $list_des8; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check8"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check8"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des8"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check8"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check8"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des8"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check8"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check8"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des8"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check8"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check8"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des8"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check8"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check8"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des8"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check8"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check8"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des8"]; ?></td>		
		
	</tr>			
	
	 <tr>
	<td ><?php echo $list_des9; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check9"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check9"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des9"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check9"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check9"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des9"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check9"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check9"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des9"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check9"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check9"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des9"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check9"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check9"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des9"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check9"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check9"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des9"]; ?></td>		
		
	</tr>	
	
 <tr>
	<td ><?php echo $list_des10; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check10"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check10"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des10"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check10"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check10"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des10"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check10"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check10"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des10"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check10"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check10"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des10"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check10"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check10"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des10"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check10"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check10"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des10"]; ?></td>		
		
	</tr>	
	
 <tr>
	<td ><?php echo $list_des11; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check11"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check11"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des11"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check11"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check11"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des11"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check11"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check11"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des11"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check11"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check11"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des11"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check11"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check11"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des11"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check11"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check11"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des11"]; ?></td>		
		
	</tr>		
	
 <tr>
	<td ><?php echo $list_des12; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check12"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check12"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des12"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check12"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check12"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des12"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check12"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check12"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des12"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check12"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check12"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des12"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check12"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check12"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des12"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check12"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check12"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des12"]; ?></td>		
		
	</tr>			
	
	 <tr>
	<td ><?php echo $list_des13; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check13"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check13"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des13"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check13"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check13"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des13"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check13"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check13"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des13"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check13"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check13"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des13"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check13"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check13"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des13"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check13"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check13"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des13"]; ?></td>		
		
	</tr>		
	
	
	 <tr>
	<td ><?php echo $list_des14; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check14"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check14"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des14"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check14"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check14"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des14"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check14"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check14"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des14"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check14"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check14"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des14"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check14"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check14"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des14"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check14"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check14"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des14"]; ?></td>		
		
	</tr>		
	
	 <tr>
	<td ><?php echo $list_des15; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check15"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check15"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des15"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check15"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check15"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des15"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check15"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check15"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des15"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check15"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check15"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des15"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check15"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check15"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des15"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check15"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check15"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des15"]; ?></td>		
		
	</tr>		
	
	
	 <tr>
	<td ><?php echo $list_des16; ?></td>	
	<td style="text-align:center;">
	<?php if($rs1["check16"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs1["check16"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
	</td>	
	<td ><?php echo $rs1["des16"]; ?></td>		
	<td style="text-align:center;">
	  	<?php if($rs2["check16"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs2["check16"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>
</td>
	<td ><?php echo $rs2["des16"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs3["check16"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs3["check16"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs3["des16"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs4["check16"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs4["check16"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs4["des16"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs5["check16"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs5["check16"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs5["des16"]; ?></td>		
	<td style="text-align:center;">
	   	<?php if($rs6["check16"]=='1'){ ?><img src="img/small_compleate.gif" width="10" align="center" height="10" /><?php }else if($rs6["check16"]=='2'){ ?> <img src="img/false.png" width="10" align="center" height="10" /><?php } ?>

	   </td>
	<td ><?php echo $rs6["des16"]; ?></td>		
		
	</tr>	
	
	
	<tr>
	<td >ผู้ดำเนินการ</td>	
	<td ><?php echo $rs1["name_s"]; ?></td>	
	<td ></td>	
	<td ><?php echo $rs2["name_s"]; ?></td>	
	<td ></td>	
	<td ><?php echo $rs3["name_s"]; ?></td>	
	<td ></td>	
	<td ><?php echo $rs4["name_s"]; ?></td>	
	<td ></td>	
	<td ><?php echo $rs5["name_s"]; ?></td>	
	<td ></td>	
	<td ><?php echo $rs6["name_s"]; ?></td>	
	<td ></td>	
		
	</tr>	
	
	
	
</table>
<table style="width:100%;" border="1">
	
<?php
$cus_receive=$objResult3["cus_receive"];
$receive_date = Datethai($objResult3["receive_date"]);
$emp_send = $objResult3["emp_send"];
$emp_date = Datethai($objResult3["emp_date"]);	
	
	?>
	
	<tr>	
	<td >ส่งสินค้า<br>
		ผู้รับ : <?php if($cus_receive!=''){?><img src="<?php echo $cus_receive;?>" width="100" align="center" height="50" /> <?php } ?>
		วันที่ : <?php echo $receive_date; ?>
		<br>
		
		</td>
	<td >ผู้ส่ง : <?php if($emp_send!=''){?><img src="<?php echo $emp_send;?>" width="100" align="center" height="50" /> <?php } ?>
		วันที่ : <?php echo $emp_date; ?>
		<br></td>	
	</tr>	
	
		<tr>	
	<td >รับคืนสินค้า<br>
<?php if($objResult3["cs_ckk"]=='1'){ ?> <input type='checkbox' checked='checked'><?php }else{ ?><input type='checkbox' ><?php } ?>สินค้าสมบูรณ์
<?php if($objResult3["cs_ckk"]=='2'){ ?> <input type='checkbox' checked='checked'><?php }else{ ?><input type='checkbox' ><?php } ?>สินค้าไม่สมบูรณ์<br>
	<?php echo $objResult3["des_receive"]; ?><br>
		<?php
		$cus_send = $objResult3["cus_send"];
        $cus_datesend = Datethai($objResult3["cus_datesend"]);

		$emp_receive = $objResult3["emp_receive"];
$emp_redate = Datethai($objResult3["emp_redate"]);
		
		$stock_name = $objResult3["stock_name"];
$stock_date = Datethai($objResult3["stock_date"]);
		?>
		
		ผู้ส่งคืน : <?php if($cus_send!=''){?><img src="<?php echo $cus_send;?>" width="100" align="center" height="50" /> <?php } ?>
		วันที่ : <?php echo $cus_datesend; ?>
		<br>
	แผนกบริการลูกค้า : <?php if($emp_receive!=''){?><img src="<?php echo $emp_receive;?>" width="100" align="center" height="50" /> <?php } ?>
		วันที่ : <?php echo $emp_redate; ?>
		
		</td>
	<td >สินค้า<br>
		<?php if($objResult3["stock_ckk"]=='1'){ ?> <input type='checkbox' checked='checked'><?php }else{ ?><input type='checkbox' ><?php } ?>สมบูรณ์
<?php if($objResult3["stock_ckk"]=='2'){ ?> <input type='checkbox' checked='checked'><?php }else{ ?><input type='checkbox' ><?php } ?>ไม่สมบูรณ์<br>
		
		<?php echo $objResult3["stock_des"]; ?>
		<br>
		คลังสินค้า : <?php if($stock_name!=''){?><img src="<?php echo $stock_name;?>" width="100" align="center" height="50" /> <?php } ?>
		วันที่ : <?php if($objResult3["stock_date"]!='0000-00-00'){ echo $stock_date; } ?>
		<br></td>	
	</tr>	
	
	
	
</table>
<br> รูปแนบ	
<table style="width:100%;" border="1">
<tr>

	<td style="width:10%;text-align:center;">ส่ง Service</td>
	<td style="width:10%;text-align:center;">รับ Service</td>
	
</tr>	
	
	
	
<tr>
<td><a href="https://cs.allwellcenter.com/upload_sendpro/<?php echo $rs3['upload_img1']; ?>" target="_blank"><?php echo $rs3['upload_img1']; ?></a></td>	
<td><a href="https://cs.allwellcenter.com/upload_sendpro/<?php echo $rs4['upload_img1']; ?>" target="_blank"><?php echo $rs4['upload_img1']; ?></a></td>	
</tr>
	
<tr>
<td><a href="https://cs.allwellcenter.com/upload_sendpro/<?php echo $rs3['upload_img2']; ?>" target="_blank"><?php echo $rs3['upload_img2']; ?></a></td>	
<td><a href="https://cs.allwellcenter.com/upload_sendpro/<?php echo $rs4['upload_img2']; ?>" target="_blank"><?php echo $rs4['upload_img2']; ?></a></td>	
</tr>
	
<tr>
<td><a href="https://cs.allwellcenter.com/upload_sendpro/<?php echo $rs3['upload_img3']; ?>" target="_blank"><?php echo $rs3['upload_img3']; ?></a></td>	
<td><a href="https://cs.allwellcenter.com/upload_sendpro/<?php echo $rs4['upload_img3']; ?>" target="_blank"><?php echo $rs4['upload_img3']; ?></a></td>	
</tr>
	
	
<tr>
<td><a href="https://cs.allwellcenter.com/upload_sendpro/<?php echo $rs3['upload_img4']; ?>" target="_blank"><?php echo $rs3['upload_img4']; ?></a></td>	
<td><a href="https://cs.allwellcenter.com/upload_sendpro/<?php echo $rs4['upload_img4']; ?>" target="_blank"><?php echo $rs4['upload_img4']; ?></a></td>	
</tr>	
	
<tr>
<td><a href="https://cs.allwellcenter.com/upload_sendpro/<?php echo $rs3['upload_img5']; ?>" target="_blank"><?php echo $rs3['upload_img5']; ?></a></td>	
<td><a href="https://cs.allwellcenter.com/upload_sendpro/<?php echo $rs4['upload_img5']; ?>" target="_blank"><?php echo $rs4['upload_img5']; ?></a></td>	
</tr>	
	
	
</table>	

<table style="width:100%;" class="tablel">

	<tr>
		<td><span>อนุมัติวันที่ 15 พ.ค.2551 </span></td>
		<td style="text-align:right;"><span>FM-OF-20:Rev.0</span></td>
	</tr>
</table>	

<br>
	
	
<br><br><br>
</body>
</html>