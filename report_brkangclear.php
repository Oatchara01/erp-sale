<link rel="stylesheet" href="css/w32.css">
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



include"dbconnect.php";
$sale_code = $_GET["sale_code"];
?>
<div class="Section2 page">

<body>
<center>
<b>รวมรายการใบยืม</b>     <br> 

	<b>ณ วันที่ <?php echo Datethai(date("Y-m-d")); ?></b>      
</center>
<br>



<?php 
$strSQL1 = "SELECT distinct product_code FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id)  WHERE  type_br='1' and clear_ckk = '0' and ckk_st ='1'";

if($sale_code !=""){ 
    $strSQL1 .= ' AND sale_area = "'.$sale_code.'"'; 
}
$strSQL1 .=" order  by group1 ASC";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1)){

$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE  product_ID='".$objResult1["product_code"]."'";
//$strSQL2 = "SELECT sol_name,unit_name FROM tb_product WHERE  product_ID='4213'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
$objResult2 = mysqli_fetch_array($objQuery2);
?>
<span class="style32"><b><?php echo $objResult2["sol_name"]; ?></b></span>

<br>

	
	
<table border= "1" width="100%" class='w3-table'>
<tr>
<!--td width="10%" align="center" class="style39">ID สินค้า</td>	
<td width="10%" align="center" class="style39">ชื่อสินค้า</td-->	
<td width="10%" align="center" class="style39">วันที่ออกเอกสาร</td>
<td width="20%" align="center" class="style39">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style39">จำนวนคงเหลือ</td> 
<td width="10%" align="center" class="style39">หมายเลขเครื่อง</td>
<td width="10%" align="center" class="style39">หมายเหตุ</td> 
	</tr>

<?php 

$strSQL3 = "SELECT * FROM so__submain  WHERE  type_br='1' and clear_ckk = '0' and product_id = '".$objResult1["product_code"]."'  and ckk_st ='1' and status_sol='Approve'";
//$strSQL3 = "SELECT ref_idd,sale_count  FROM so__submain  WHERE  type_br='1' and clear_ckk = '0' and product_id = '4213'";
if($sale_code !=""){ 
    $strSQL3 .= ' AND sale_area = "'.$sale_code.'"'; 
}
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);

while($objResult3 = mysqli_fetch_array($objQuery3)){
	
$strSQL4 = "SELECT doc_no,doc_release_date,ref_id FROM so__main WHERE  ref_id='".$objResult3["ref_idd"]."' and cancel_ckk ='0' and approve_complete ='Approve'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);
	
////////////////
	
if($objResult3["sn_number"] !=''){
$sn_number =  $objResult3["sn_number"];
$str_arr = explode("\n",$sn_number);
foreach ($str_arr as $test =>$value){
$product_sn = $str_arr[$test];
$product_sn1 =  trim($product_sn);

	
$strSQL22 = "SELECT sn_number FROM  so__submain  WHERE clear_ivno ='".$objResult4["doc_no"]."' and product_id = '".$objResult1['product_code']."' and sn_number LIKE '%$product_sn1%' and clear_br = '1' and status_sol ='Approve'";
$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$Num_Rows22 = mysqli_num_rows($objQuery22);

$strSQL12 = "SELECT sn FROM  hos__subso  WHERE clear_ivno ='".$objResult4["doc_no"]."' and product_id = '".$objResult1['product_code']."' and sn LIKE '%$product_sn1%' and clear_br = '1' and status_so ='Approve'";
	
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$Num_Rows12 = mysqli_num_rows($objQuery12);
	
/*$strSQL31 = "SELECT ref_id FROM hos__receive  WHERE iv_no = '".$objResult4["doc_no"]."' ";

$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$objResult31 = mysqli_fetch_array($objQuery31);ref_idd = '".$objResult31["ref_id"]."' and*/
	
$strSQL6 = "SELECT sn FROM   (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$objResult4["doc_no"]."' and  product_id = '".$objResult1['product_code']."' and sn = '".$product_sn1."' ";

$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$Num_Rows6 = mysqli_num_rows($objQuery6);

$sql2 = "SELECT sn  FROM   hos__subsmp   where  product_id = '".$objResult1["product_code"]."' and clear_br = '1' and br_no ='".$objResult4["doc_no"]."'  and sn ='".$product_sn1."' and status_smp='Approve'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows19 = mysqli_num_rows($qry2);	
	
	
if($Num_Rows22 > 0){

}else if ($Num_Rows6 > 0){

}else if ($Num_Rows19 > 0){

}else if ($Num_Rows12 > 0){

}else{

if($product_sn1 !=''){	
?>
<tr>
<!--td width="10%" align="center" class="style39"><?php echo $objResult1["product_code"];  ?></td>	
<td width="10%" align="center" class="style39"><?php echo $objResult2["sol_name"];  ?></td-->		
<td width="20%" align="center" class="style39"><?php echo Datethai($objResult4["doc_release_date"]);  ?></td>
<td width="20%" align="center" class="style39"><?php echo $objResult4["doc_no"];  ?></td>
<td width="10%" align="right" class="style39"><?php  echo '1.00';  ?> <?php echo $objResult2["unit_name"];  ?></td>
<td width="10%" align="right" class="style39"><?php echo $product_sn1; ?></td>
<td width="10%" align="right" class="style39"></td>


	</tr>
<?php	
}
}
}
}
///////////////////	
	
	
$sql3 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '".$objResult1["product_code"]."' and clear_br = '1' and clear_ivno ='".$objResult4["doc_no"]."' and status_sol ='Approve'";
	
//$sql3 = "SELECT sum(sale_count) as count3   FROM   so__submain   where  product_id = '4213' and clear_br = '1' and clear_ivno ='".$objResult4["doc_no"]."'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);
	
$sql7 = "SELECT sum(count) as count   FROM   hos__subso   where  product_id = '".$objResult1["product_code"]."' and clear_br = '1' and clear_ivno ='".$objResult4["doc_no"]."'  and status_so ='Approve'";
	
//$sql7 = "SELECT sum(count) as count   FROM   hos__subso   where  product_id = '4213' and clear_br = '1' and clear_ivno ='".$objResult4["doc_no"]."'";	
	
$qry7 = mysqli_query($conn,$sql7) or die(mysqli_error());
$rs7 = mysqli_fetch_assoc($qry7);
	
$sql2 = "SELECT sum(sale_count) as count3   FROM   hos__subsmp   where  product_id = '".$objResult1["product_code"]."' and clear_br = '1' and br_no ='".$objResult4["doc_no"]."' and status_smp ='Approve'";
//$sql2 = "SELECT sum(sale_count) as count3   FROM   hos__subsmp   where  product_id = '4213' and clear_br = '1' and br_no ='".$objResult4["doc_no"]."'";

$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_assoc($qry2);
	
$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$objResult4["doc_no"]."' and product_id = '".$objResult1["product_code"]."' ";
//$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive  LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$objResult4["doc_no"]."' and product_id = '4213' ";	
	
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_assoc($qry4);

$count3 =  $rs3["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs2["count3"];
$count7 =  $rs7["count"];

//echo $count3+$count4+$count5+$count7;	
$count2 = $objResult3["sale_count"] - ($count3+$count4+$count5+$count7);	
	
if($count2=='0'){
$strSQL33 =  "Update so__submain SET clear_ckk='1'  where  id ='".$objResult3["id"]."'";
$objQuery33 = mysqli_query($conn,$strSQL33) or die(mysqli_error());	
}
	
$strSQL8 =  "Update so__submain SET count_kang='".$count2."'  where  id ='".$objResult3["id"]."'";
$objQuery8 = mysqli_query($conn,$strSQL8) or die(mysqli_error());
if($objResult3["sn_number"] ==''){	
?>	
	
<tr>
<!--td width="10%" align="center" class="style39"><?php echo $objResult1["product_code"];  ?></td>	
<td width="10%" align="center" class="style39"><?php echo $objResult2["sol_name"];  ?></td-->		
	
<td width="20%" align="center" class="style39"><?php echo Datethai($objResult4["doc_release_date"]);  ?></td>
<td width="20%" align="center" class="style39"><?php echo $objResult4["doc_no"];  ?></td>
<td width="10%" align="right" class="style39"><?php  echo number_format($count2,2)."";  ?> <?php echo $objResult2["unit_name"];  ?></td>
<td width="10%" align="right" class="style39"></td>
<td width="10%" align="right" class="style39"></td>

	</tr>

<?php
}
} 
	?>
	
	<?php
//echo SUM($count2);	
	
$strSQL9 = "SELECT SUM(count_kang) AS sale_count  FROM so__submain  WHERE type_br='1' and clear_ckk = '0' and product_id = '".$objResult1["product_code"]."' and ckk_st ='1'";
if($sale_code !=""){ 
    $strSQL9 .= ' AND sale_area = "'.$sale_code.'"'; 
}
	//echo $strSQL9;
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);
	
	

?>
<tr>
<td width="10%" align="center" class="style30"></td>
<td width="25%" align="left" class="style16">ยอดคงเหลือทั้งหมด</td> 
<td width="10%" align="right" class="style16"><?php echo $objResult9["sale_count"]; ?>  <?php echo $objResult2["unit_name"];  ?></td> 
<td width="10%" align="center" class="style30"></td> 
<td width="10%" align="center" class="style30"></td> 
	</tr>
	</table>	<br>
	<?php
  } 
?>



</body>
	</div>
</html>