<style>
		body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font: 12pt "Angsana New";
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

<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #FF0000;
}
.style30 {font-size: 12; }
.style32 {font-size: 14px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #FF0000; }
-->
</style>
<?php error_reporting(~E_NOTICE);
/*include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorHTML.php";
include "src/BarcodeGeneratorPNG.php";

function barcode($code){
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $border = 1.5;//กำหนดความหน้าของเส้น Barcode
    $height = 20;//กำหนดความสูงของ Barcode
     return $generator->getBarcode($code , $generator::TYPE_CODE_128,$border,$height);
}*/
include"dbconnect.php";
include"head2.php";
$sale_code = $_SESSION['code'];
?>
<div class="Section2 page">

<body>
<center><font size="5">รายการใบยืมฝากขายคงค้าง</font></center>
<?php


$strSQL = "SELECT DISTINCT(customer_id) from hos__consig WHERE close_br ='0' and status_doc ='Approve'";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());

while($objResult = mysqli_fetch_array($objQuery)){

$strSQL3 = "SELECT * FROM tb_customer WHERE customer_id = '".$objResult["customer_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);

//
$strSQL1 = "SELECT ref_id,iv_no,iv_date FROM hos__consig WHERE close_br ='0' and status_doc ='Approve' and customer_id ='".$objResult["customer_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

?>


<br><div class="style15"><?php echo $objResult3["preface_name"]; ?> <?php echo $objResult3["customer_name"]; ?></div></p>

<table  border= "1" width="100%" class='w3-table'>
<tr >
<td width="8%" align="center"  ><div class="style32">วันที่</div></td>
<td width="8%" align="center" ><div class="style32">เลขที่ใบยืม</div></td>
<td width="10%" align="center" ><div class="style32">รหัสสินค้า</div></td>
<td width="20%" align="center" ><div class="style32">ชื่อสินค้า</div></td> 
<td width="10%" align="center" ><div class="style32">จำนวน</div></td> 
</tr>
<?php 
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
$strSQL2 = "SELECT id,product_id,count,sale_remark FROM hos__subconsig WHERE ref_idd='".$objResult1["ref_id"]."' and clear_ckk='0' and ckk_st='1'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);	
while($objResult2 = mysqli_fetch_array($objQuery2))
{
	
	
$strSQL4 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE product_ID = '".$objResult2["product_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4);
$objResult4 = mysqli_fetch_array($objQuery4);

$sql3 = "SELECT sum(sale_count) as count3   FROM   hos__subspr   where  product_id = '".$objResult2['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult1["iv_no"]."' and status_spr='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso  where  product_id = '".$objResult2['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult1["iv_no"]."'  and status_so='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$objResult1["iv_no"]."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
$rs41 = mysqli_fetch_array($qry41);

$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '".$rs41['ref_id']."' and product_id = '".$objResult2['product_id']."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM   hos__subsmp  where  product_id = '".$objResult2['product_id']."' and clear_br = '1' and br_no ='".$objResult1["iv_no"]."' and status_smp ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];

	
$count2 = $objResult2["count"] - ($count3+$count4+$count5+$count13);
	
if($count2=='0'){	

$save3="Update   hos__subconsig set clear_ckk = '1' where id='".$objResult2["id"]."' and ref_idd ='".$objResult1["ref_id"]."'";
$qsave3=mysqli_query($conn,$save3);	
	
}		
	
?>
<tr>
	
<td align="center" ><div class="style33"><?php echo Datethai($objResult1["iv_date"]);?></div></td>
<td align="center" ><div class="style33"><?php echo $objResult1["iv_no"]; ?></div></td>
<td ><div align="left"  class="style33"><?php echo $objResult4["access_code"]; ?></div></td>
<td ><div align="left" class="style33"><?php echo $objResult4["sol_name"]; ?> <?php echo $objResult2["sale_remark"]; ?></div></td>
<td><div align="right"  class="style33"><?php echo $count2; ?> <?php echo $objResult4["unit_name"]; ?></div></td>

<?php $i++; 

}
}
	?>
</tr>
</table>

<?php } ?>
<br><br>
</body>
</div>
</html>