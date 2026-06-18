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
	<div class="w3-white">
<?php
include "dbconnect.php";
include "dbconnect_sale.php";		

date_default_timezone_set("Asia/Bangkok");

$files_url = $_POST['linkurl'];
$objCSV = fopen($files_url,'r');
$objArr = fgetcsv($objCSV, 1000, ",");

while(($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE){ 

	
/*$id_customer = trim($objArr[0]);
$customer_code = trim($objArr[1]);


//ปิด	
 if($id_customer !=''){	
	
$save=" Update  tb_customer_contact set customer_code='$customer_code'  where  id_customer ='$id_customer'";
$qsave=mysqli_query($com,$save);

	
	
}
*/	

//เปิด	
$order_id = $objArr[0];
$iv_no = $objArr[1];

if($order_id !=''){	
	
$date_arr = explode('/' , $objArr[2] );
$iv_date = $date_arr[2].'-'.$date_arr[1].'-'.$date_arr[0];

$save=" Update  so__main set iv_no='$iv_no',iv_date = '$iv_date',cancel_ckk='0'  where  order_id ='$order_id'";
$qsave=mysqli_query($conn,$save);
	
$strSQL1 ="SELECT ref_id,order_id,iv_no FROM so__main WHERE  order_id ='".$order_id."' and select_type_doc !='1' and select_type_doc !='2'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
$strSQL28 = "SELECT id_off FROM tb_register_data  WHERE ref_id = '".$objResult1["ref_id"]."' ";
$objQuery28 = mysqli_query($code,$strSQL28) or die(mysqli_error());
$objResult28 = mysqli_fetch_array($objQuery28);
		
if($iv_no!=''){	
		
$strSQL27="Update  tb_register_data set clear_iv = '".$objResult1["iv_no"]."',ckk_br = '1'  where id_off ='".$objResult28["id_off"]."'";
$objQuery27 = mysqli_query($code,$strSQL27);	
	
}
	
}	

	
$strSQL ="SELECT ref_id,order_id FROM st__main WHERE  order_id ='".$order_id."' and iv_no LIKE '%SOL%'";
$objQuery =mysqli_query($new,$strSQL);
$Num_Rows = mysqli_num_rows($objQuery);
while($objResult = mysqli_fetch_array($objQuery))
{


if($Num_Rows > 0){


$save1 = " Update  st__main set iv_no1 = '$iv_no',close_br = '1'  where  order_id ='".$order_id."'";
$qsave1 = mysqli_query($new,$save1);

$save2 = " Update  st__sbmain set stock_remark = '$iv_no',type_doc='1'  where  ref_idd ='".$objResult["ref_id"]."'";
$qsave2 = mysqli_query($new,$save2);

}
}

}
}
	
	


	 
fclose($objCSV);  
 //$objQuery = mysql_query($strSQL); 
 if($qsave){
echo "<script language=\"JavaScript\">";
echo "alert('Importข้อมูลของท่านเรียบร้อยแล้ว');window.location='main_admin.php';";
echo "</script>";
	  }else{
   echo 'ไม่สามารถ Import ข้อมูลได้';
 }
?>


</body>
</html>