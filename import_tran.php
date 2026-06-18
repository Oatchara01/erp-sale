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
  
$files_url = $_POST['linkurl']; ////'uploads/installdata_test2.csv';
///เช็ค  error	file
//echo $files_url;
//exit();
$objCSV = fopen($files_url,'r');

///เช็คการอ่านไฟล์
$objArr = fgetcsv($objCSV, 1000, ",");

//echo '<br>'.$objArr[46] ;
//exit();
$MSG = "";
 	date_default_timezone_set("Asia/Bangkok");

		
//exit();


while(($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) { 


if($objArr[0]!=''){


$sql21 = "SELECT ref_id FROM so__main where order_id='".$objArr[0]."'";
$query21 = mysqli_query($conn,$sql21) or die(mysqli_error());
$Num_Rows21 = mysqli_num_rows($query21);
$fetch21 = mysqli_fetch_array($query21);


if($fetch21["ref_id"]!=''){

if($objArr[25]=='0'){
$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,sale_remark)
values ('".$fetch21["ref_id"]."','1','1','".$objArr[25]."','".$objArr[25]."','".$objArr[25]."','0.00','4392','4392','ค่าจัดส่งฟรี')";
$objQuery1 = mysqli_query($conn,$strSQL1);
	
}else{

$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code)
values ('".$fetch21["ref_id"]."','1','1','".$objArr[25]."','".$objArr[25]."','".$objArr[25]."','0.00','4392','4392')";
$objQuery1 = mysqli_query($conn,$strSQL1);



}

}


}


}

	 
fclose($objCSV);  
 //$objQuery = mysql_query($strSQL); 
 if($objQuery1){
	 echo '<br>
	 <br>
<br>
<br>
<br>
<br>

	 <center>
	 <table width=60% cellpadding="4" cellspacing="0" style="border:double 5px #330033	;"><tr><td style="border:double 5px #330033	;" background =http://www.yenta4.com/webboard/upload_images/81631_688240.gif>
	   <center>
	   <br>
	   <br>
	   <br>
	   <p><legend><b> Data import successful<b><legend></p> 
	   <br>
	   <br>
	   <br>
           <form action = "upload_tran.php" method ="post">
    
  <input type="submit" class="button button3""  value="กลับสู่หน้าหลัก">
  </center>
  <br>
	   <br>
	   <br>
           </form>
		   </td></tr></table>
          </center> ';
	  }else{
   echo 'ไม่สามารถ Import ข้อมูลได้';
 }
?>
<br>
	   <br>
	   <br>
	   <br>
	   <br>
	   <br>
 </center> 

 </br>

<?php include('foot.php'); ?>
</div>
</body>
</html>











