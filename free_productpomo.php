<?php include('head.php'); ?>


<style type="text/css">
<!--
.style15 {
	font-size: 17px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #FF0000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
	
.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}
</style>

<body>
<?
include "dbconnect.php";
	
date_default_timezone_set("Asia/Bangkok");


$start_date = $_GET["start_date"];
$sale_channel = $_GET["sale_channel"];
$add_date = date('Y-m-d H:i:s');


		
if($sale_channel=='34'){	
	 //
$strSQL ="SELECT DISTINCT ref_id,select_type_doc FROM so__main WHERE  register_date ='".$start_date."' and sale_channel='".$sale_channel."' and send_erpst='0'";
$objQuery =mysqli_query($conn,$strSQL);
	
while($objResult = mysqli_fetch_array($objQuery))
{	

	
$strSQL51 = "SELECT SUM(sum_amount) AS sum_amount  FROM so__submain where ref_idd = '".$objResult["ref_id"]."' ";
$objQuery51 = mysqli_query($conn,$strSQL51) or die ("Error Query [".$strSQL51."]");
$objResult51= mysqli_fetch_array($objQuery51);
	
if($objResult51["sum_amount"] >= '1500'){	
	
if($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='3'){
		

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark,add_date)
values ('".$objResult["ref_id"]."','1','1','0.00','0.00','0.00','0.00','6198','6198','ซื้อครบ 1500 บาท แถมฟรีปฏิทิน ออลล์เวล 2026 1 เล่ม','".$add_date."')";
$objQuery2 = mysqli_query($conn,$strSQL2);	

			
}
if($objResult["select_type_doc"]=='2' or $objResult["select_type_doc"]=='4'){
		

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark,add_date)
values ('".$objResult["ref_id"]."','1','1','0.00','0.00','0.00','0.00','6198','6198','ซื้อครบ 1500 บาท แถมฟรีปฏิทิน ออลล์เวล 2026 1 เล่ม','".$add_date."')";
$objQuery2 = mysqli_query($conn,$strSQL2);	

		
		
		
}
	
}
	
	
}
}
	
	
if($sale_channel=='31'){	
	 //
$strSQL ="SELECT DISTINCT ref_id,select_type_doc FROM so__main WHERE  register_date ='".$start_date."' and sale_channel='".$sale_channel."' and send_erpst='0'";
$objQuery =mysqli_query($conn,$strSQL);
	
while($objResult = mysqli_fetch_array($objQuery))
{	

	
$strSQL51 = "SELECT SUM(sum_amount) AS sum_amount  FROM so__submain where ref_idd = '".$objResult["ref_id"]."' ";
$objQuery51 = mysqli_query($conn,$strSQL51) or die ("Error Query [".$strSQL51."]");
$objResult51= mysqli_fetch_array($objQuery51);
	
if($objResult51["sum_amount"] >= '900'){	
	
if($objResult["select_type_doc"]=='1' or $objResult["select_type_doc"]=='3'){
		

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark,add_date)
values ('".$objResult["ref_id"]."','1','1','0.00','0.00','0.00','0.00','5016','5016','ซื้อครบ 900 บาท แถมฟรีผ้าเปียก Allwell 1 แพ็ก (50 แผ่น)','".$add_date."')";
$objQuery2 = mysqli_query($conn,$strSQL2);	

			
}
if($objResult["select_type_doc"]=='2' or $objResult["select_type_doc"]=='4'){
		

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark,add_date)
values ('".$objResult["ref_id"]."','1','1','0.00','0.00','0.00','0.00','5138','5138','ซื้อครบ 900 บาท แถมฟรีผ้าเปียก Allwell 1 แพ็ก (50 แผ่น)','".$add_date."')";
$objQuery2 = mysqli_query($conn,$strSQL2);	

		
		
		
}
	
}
	
	
}
}	
	
	
	
	
if($sale_channel=='1' or $sale_channel=='20' or $sale_channel=='12'){	


$strSQL ="SELECT ref_so,order_num,date_today,sale_chan,close_cd FROM so__disecom WHERE  date_today ='".$start_date."' and sale_chan='".$sale_channel."' and close_cd='0'";
$objQuery =mysqli_query($conn,$strSQL);
while($objResult = mysqli_fetch_array($objQuery))
{		
		
$strSQL1 ="SELECT SUM(price_dis) As sum_amount FROM so__disecom WHERE  date_today ='".$start_date."' and sale_chan='".$sale_channel."' and close_cd='0' and order_num ='".$objResult["order_num"]."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);


$strSQL2 ="SELECT ref_id,select_type_doc FROM so__main WHERE  order_id ='".$objResult["order_num"]."' and sale_channel='".$sale_channel."'";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 = mysqli_fetch_array($objQuery2);

$i=0;
	
if($objResult1["sum_amount"] >= '5000'){	
	

	
if($objResult2["select_type_doc"]=='1' or $objResult2["select_type_doc"]=='3'){
		
		
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark)
values ('".$objResult2["ref_id"]."','1','1','0.00','0.00','0.00','0.00','5181','5181','โปร 15.8.67 ซื้อครบ 5000 บาท แถมฟรี แชมพู 250ml')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
			
$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark)
values ('".$objResult2["ref_id"]."','1','1','0.00','0.00','0.00','0.00','5182','5182','โปร 15.8.67 ซื้อครบ 5000 บาท แถมฟรี ครีมนวด 250ml')";
$objQuery2 = mysqli_query($conn,$strSQL2);	

$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark)
values ('".$objResult2["ref_id"]."','1','1','0.00','0.00','0.00','0.00','4555','4555','โปร 15.8.67 ซื้อครบ 5000 บาท แถมฟรี Lotion 250ml')";
$objQuery3 = mysqli_query($conn,$strSQL3);	
			
$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark)
values ('".$objResult2["ref_id"]."','1','1','0.00','0.00','0.00','0.00','5390','5390','โปร 15.8.67 ซื้อครบ 5000 บาท แถมฟรี ทิชชู่เปียก (เล็ก)')";
$objQuery4 = mysqli_query($conn,$strSQL4);			
					
$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark)
values ('".$objResult2["ref_id"]."','1','1','0.00','0.00','0.00','0.00','3610','3610','โปร 15.8.67 ซื้อครบ 5000 บาท แถมฟรี ถุงผ้าสีม่วง ALLWELL 2020')";
$objQuery5 = mysqli_query($conn,$strSQL5);			
		
		
}
	if($objResult2["select_type_doc"]=='2' or $objResult2["select_type_doc"]=='4'){
		

		
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark)
values ('".$objResult2["ref_id"]."','1','1','0.00','0.00','0.00','0.00','5324','5324','โปร 15.8.67 ซื้อครบ 5000 บาท แถมฟรี แชมพู 250ml')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
			
$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark)
values ('".$objResult2["ref_id"]."','1','1','0.00','0.00','0.00','0.00','5326','5326','โปร 15.8.67 ซื้อครบ 5000 บาท แถมฟรี ครีมนวด 250ml')";
$objQuery2 = mysqli_query($conn,$strSQL2);	

$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark)
values ('".$objResult2["ref_id"]."','1','1','0.00','0.00','0.00','0.00','4587','4587','โปร 15.8.67 ซื้อครบ 5000 บาท แถมฟรี Lotion 250ml')";
$objQuery3 = mysqli_query($conn,$strSQL3);	
			
$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark)
values ('".$objResult2["ref_id"]."','1','1','0.00','0.00','0.00','0.00','5486','5486','โปร 15.8.67 ซื้อครบ 5000 บาท แถมฟรี ทิชชู่เปียก (เล็ก)')";
$objQuery4 = mysqli_query($conn,$strSQL4);			
					
$strSQL5 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark)
values ('".$objResult2["ref_id"]."','1','1','0.00','0.00','0.00','0.00','4502','4502','โปร 15.8.67 ซื้อครบ 5000 บาท แถมฟรี ถุงผ้าสีม่วง ALLWELL 2020')";
$objQuery5 = mysqli_query($conn,$strSQL5);			
		
		
				
	
	}
	
//}
$i++;	
	
}
/*if($sale_channel=='1'){		
if($objResult1["sum_amount"] >= '600'){	
	
	
if($objResult2["select_type_doc"]=='1' or $objResult2["select_type_doc"]=='3'){
	
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark)
values ('".$objResult2["ref_id"]."','1','1','0.00','0.00','0.00','0.00','5568','5568','Pro พิเศษ แถมแบรนด์ วันที่ 1-3 ก.ค. 67')";
$objQuery1 = mysqli_query($conn,$strSQL1);	
			
	
}
	
if($objResult2["select_type_doc"]=='2' or $objResult2["select_type_doc"]=='4'){
	
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark)
values ('".$objResult2["ref_id"]."','1','1','0.00','0.00','0.00','0.00','5573','5573','Pro พิเศษ แถมแบรนด์ วันที่ 1-3 ก.ค. 67')";
$objQuery1 = mysqli_query($conn,$strSQL1);	


}

}
}	*/	
	
	
	
	

	


$save="Update  so__disecom set  close_cd = '1' where date_today ='".$start_date."' and order_num ='".$objResult["order_num"]."' and sale_chan='".$sale_channel."'";
$qsave=mysqli_query($conn,$save);
	
}
}
	
	

 if($objQuery2){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='main_admin.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	?>
		  
<?php include('foot.php'); ?>
</div>
</body>
</html>