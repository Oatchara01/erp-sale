<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 16px; color: #FF0000;}
.style17 {font-size: 16px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style30 {font-size: 14px; color: #000000;}
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

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];

include"dbconnect.php";



?>
<body>


<center>
<span class="style15">รายการสมาชิกที่มีการอัพเดทสถานะ</span></p>

</center>
</p>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่สมัครสมาชิก</td>
	<td width="10%" align="center" class="style30">รหัสสมาชิก</td>
<td width="25%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="10%" align="center" class="style30">เบอร์โทรลูกค้า</td> 
<td width="10%" align="center" class="style30">สถานะเดิม</td> 
<td width="10%" align="center" class="style30">สถานะใหม่</td> 
<td width="10%" align="center" class="style30">วันที่เปลี่ยน</td> 
<td width="10%" align="center" class="style30">ยอดเงินสะสมของการซื้อ</td> 


	</tr>


<?php

	
$strSQL10 ="SELECT  status_cus,customer_no,first_name,last_name,preface_name,cus_tel,status_cusold,point,add_date,date_update FROM tb_customer WHERE  customer_no != '' ";


if($start_date !=""){ 
    $strSQL10 .= ' AND date_update >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL10 .= ' AND date_update <= "'.$end_date.'"'; 
}

$strSQL10 .=" order  by customer_no ASC  ";

//echo $strSQL10;	
	
$objQuery10 =mysqli_query($conn,$strSQL10);
while($objResult10=mysqli_fetch_array($objQuery10)){

$summary17= number_format( $summary_17,2)."";



?>


<tr>
<td  align="center" class="style30"><?php echo  DateThai($objResult10["add_date"]); ?></td>
	<td  align="left" class="style30"><?php echo  $objResult10["customer_no"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult10["first_name"]; ?> <?php echo  $objResult10["last_name"]; ?></td>
	<td  align="left" class="style30"><?php echo  $objResult10["cus_tel"]; ?></td> 
<td  align="left" class="style30"><?php if($objResult10["status_cusold"]=='0'){echo "Gold Customer"; }else if($objResult10["status_cusold"]=='1'){ echo "Platinum Customer";  }else if($objResult10["status_cusold"]=='2'){ echo "Daimond Customer";  } ?>
</td> 
<td  align="left" class="style30"><?php if($objResult10["status_cus"]=='0'){echo "Gold Customer"; }else if($objResult10["status_cus"]=='1'){ echo "Platinum Customer";  }else if($objResult10["status_cus"]=='2'){ echo "Diamond Customer";  } ?></td> 

<td  align="center" class="style30"><?php echo  DateThai($objResult10["date_update"]); ?></td>
<td  align="right" class="style30"><?php echo  number_format($objResult10["point"],2).""; ?></td>


	</tr>
	<?php } ?>
</table>

</body>
</html>