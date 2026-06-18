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

$files_url = $_POST['linkurl']; ////'uploads/installdata_test2.csv';
$objCSV = fopen($files_url,'r');

$objArr = fgetcsv($objCSV, 1000, ",");

while(($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) { 

	
$ref_id = $objArr[0];
$doc_noeng = $objArr[1];


$save=" Update  tb_register_eng set doc_noeng='".$doc_noeng."'  where  ref_id ='".$ref_id."'";
$qsave=mysqli_query($conn,$save);

	

}
	
	


	 
fclose($objCSV);  
 //$objQuery = mysql_query($strSQL); 
 if($qsave){
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
           <form action = "main_salehos.php" method ="post">
    
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