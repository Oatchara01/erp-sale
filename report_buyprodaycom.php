
<?php
include "head.php";
include "dbconnect.php";


$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
?>
<div class="w3-white" ><br>
<?php /*<table width="90%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr> 
	
	 <th width="15%">เขต</th>
	 <th width="10%">AWL</th>
	  <th width="10%">NBN</th>
	  <th width="10%">รวม</th>
	  
	  </tr>
  </thead>

<?php
$strSQL ="SELECT distinct sale_code FROM tb__buypro WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_date <= "'.$end_date.'"'; 
}

$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 ="SELECT SUM(amount) as amount  FROM tb__buypro  WHERE company = '3'  and sale_code = '".$objResult["sale_code"]."'";

if($start_date !=""){ 
    $strSQL1 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_date <= "'.$end_date.'"'; 
}

$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);	
	
	
$strSQL2 ="SELECT SUM(amount) as amount  FROM tb__buypro  WHERE company = '4'  and sale_code = '".$objResult["sale_code"]."'";

if($start_date !=""){ 
    $strSQL2 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND doc_date <= "'.$end_date.'"'; 
}	
	
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 = mysqli_fetch_array($objQuery2);	
	
$strSQL3 ="SELECT SUM(amount) as amount  FROM tb__buypro  WHERE  sale_code = '".$objResult["sale_code"]."'";

if($start_date !=""){ 
    $strSQL3 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL3 .= ' AND doc_date <= "'.$end_date.'"'; 
}	
	

$objQuery3 =mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);		
	
	
	
//ลดหนี้

	$strSQL11 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE company = '3'  and sale_code = '".$objResult["sale_code"]."'";

if($start_date !=""){ 
    $strSQL11 .= ' AND date_cash >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND date_cash <= "'.$end_date.'"'; 
}

$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11 = mysqli_fetch_array($objQuery11);	
	
	
$strSQL12 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE company = '4'  and sale_code = '".$objResult["sale_code"]."'";

if($start_date !=""){ 
    $strSQL12 .= ' AND date_cash >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL12 .= ' AND date_cash <= "'.$end_date.'"'; 
}	
	
$objQuery12 =mysqli_query($conn,$strSQL12);
$objResult12 = mysqli_fetch_array($objQuery12);	
	
$strSQL13 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE  sale_code = '".$objResult["sale_code"]."'";

if($start_date !=""){ 
    $strSQL13 .= ' AND date_cash >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL13 .= ' AND date_cash <= "'.$end_date.'"'; 
}	
	

$objQuery13 =mysqli_query($conn,$strSQL13);
$objResult13 = mysqli_fetch_array($objQuery13);	
	?>

 <tr> 
	
	 <th width="15%"><?php echo $objResult["sale_code"]; ?></th>
	 <th width="10%"><?php echo number_format(($objResult1["amount"]-$objResult11["amount"])/1.07,2).""; ?></th>
	  <th width="10%"><?php echo number_format(($objResult2["amount"]-$objResult12["amount"])/1.07,2).""; ?></th>
	  <th width="10%"><?php echo number_format(($objResult3["amount"]-$objResult13["amount"])/1.07,2).""; ?></th>
	  
	  </tr>
	
	
	
	<?php

}
</table>*/
?>

<?php	
	
$strSQL ="SELECT distinct group_pro FROM tb__buypro WHERE 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_date <= "'.$end_date.'"'; 
}

$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 ="SELECT SUM(amount) as amount  FROM tb__buypro  WHERE company = '3'  and group_pro = '".$objResult["group_pro"]."'";

if($start_date !=""){ 
    $strSQL1 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_date <= "'.$end_date.'"'; 
}

$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);	
	
	
$strSQL2 ="SELECT SUM(amount) as amount  FROM tb__buypro  WHERE company = '4'  and group_pro = '".$objResult["group_pro"]."'";

if($start_date !=""){ 
    $strSQL2 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND doc_date <= "'.$end_date.'"'; 
}	
	
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 = mysqli_fetch_array($objQuery2);	
	
	
	
$strSQL3 ="SELECT SUM(amount) as amount  FROM tb__buypro  WHERE  group_pro = '".$objResult["group_pro"]."'";

if($start_date !=""){ 
    $strSQL3 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL3 .= ' AND doc_date <= "'.$end_date.'"'; 
}	
	

$objQuery3 =mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);		
	
	
	
//ลดหนี้

	$strSQL11 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE company = '3'  and group_1 = '".$objResult["group_pro"]."'";

if($start_date !=""){ 
    $strSQL11 .= ' AND date_cash >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND date_cash <= "'.$end_date.'"'; 
}

$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11 = mysqli_fetch_array($objQuery11);	
	
	
$strSQL12 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE company = '4'  and group_1 = '".$objResult["group_pro"]."'";

if($start_date !=""){ 
    $strSQL12 .= ' AND date_cash >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL12 .= ' AND date_cash <= "'.$end_date.'"'; 
}	
	
$objQuery12 =mysqli_query($conn,$strSQL12);
$objResult12 = mysqli_fetch_array($objQuery12);	
	
	
$strSQL13 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE  group_1 = '".$objResult["group_pro"]."'";

if($start_date !=""){ 
    $strSQL13 .= ' AND date_cash >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL13 .= ' AND date_cash <= "'.$end_date.'"'; 
}	
	

$objQuery13 =mysqli_query($conn,$strSQL13);
$objResult13 = mysqli_fetch_array($objQuery13);	

	
$sum_disall1 = $objResult3["amount"]-$objResult13["amount"];
$sum_disall = $sum_disall1/1.07;
	
$sum_disawl1 = $objResult1["amount"]-$objResult11["amount"];	
$sum_disawl = $sum_disawl1/1.07;

$sum_disnbm1 = $objResult2["amount"]-$objResult12["amount"];
$sum_disnbm = $sum_disnbm1/1.07;
	
$strSQL17 = "SELECT *  FROM tb__buypro_com   WHERE group_1 = '".$objResult["group_pro"]."'";
$objQuery17 = mysqli_query($conn,$strSQL17) or die ("Error Query [".$strSQL17."]");
$Num_Rows17 = mysqli_num_rows($objQuery17);
if($Num_Rows17 > 0){

$strSQL71 = "UPDATE tb__buypro_com SET sumary='".$sum_disall."',awl_sum='".$sum_disawl."',nbm_sum='".$sum_disnbm."' where group_1='".$objResult["group_pro"]."' ";

$objQuery71 = mysqli_query($conn,$strSQL71);	
	

}else{

	
$strSQL71 = "insert into tb__buypro_com
(group_1,company,sumary,awl_sum,nbm_sum)
values ('".$objResult["group_pro"]."','".$objResult["company"]."','".$sum_disall."','".$sum_disawl."','".$sum_disnbm."')";

$objQuery71 = mysqli_query($conn,$strSQL71);

}	
	
}
	
?>


<center>
<h3 align="center">รายงานยอดขายตามกลุ่มสินค้า แยกตามบริษัท</h3>
<h3 align="center">ตามช่วงวันที่ <?php echo Datethai($start_date); ?>&nbsp;&nbsp;<?php echo Datethai($end_date); ?></h3><br>
	
	

	
	
	
<table width="90%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr> 
	 <th width="5%">ลำดับ</th>
	 <th width="15%">กลุ่มสินค้า</th>
	  <th width="10%">AWL</th>
	 <th width="10%">NBM</th>
		  <th width="10%">รวม</th>
	  <th width="10%">%</th>
	  </tr>
  </thead>
	
	<?php 
	
$strSQL13 ="SELECT SUM(sumary) as sumary,SUM(awl_sum) AS awl_sum,SUM(nbm_sum) AS nbm_sum  FROM tb__buypro_com";
	
$objQuery13 =mysqli_query($conn,$strSQL13);
$objResult13 = mysqli_fetch_array($objQuery13);	
	
	
	
$strSQL7 = "SELECT *  FROM tb__buypro_com   Order by sumary DESC ";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);
	
	$i = 1;
while($objResult7=mysqli_fetch_array($objQuery7)){
	
	$percent = ($objResult7["sumary"]/$objResult13["sumary"])*100;
	?>
     
	<tr>
<td  align="center" class="style30"><?php echo  $i; ?></td>
<td  align="left" class="style30"><?php echo $objResult7["group_1"]; ?></td>
<td  align="left" class="style30"><?php echo  number_format($objResult7["awl_sum"],2).""; ?></td> 
<td  align="left" class="style30"><?php echo  number_format($objResult7["nbm_sum"],2).""; ?></td> 
<td  align="right" class="style30"><?php echo  number_format($objResult7["sumary"],2).""; ?></td> 
<td  align="right" class="style30"><?php echo  number_format($percent,2).""; ?>%</td> 
	
      
    </tr>
	  
	<?php 
$i++;
} 
	
$percent_all = ($objResult13["sumary"]/$objResult13["sumary"])*100;	
	?>
  
<tr>
<td  align="center" class="style30"></td>
<td  align="left" class="style30">รวม</td>
<td  align="left" class="style30"><?php echo  number_format($objResult13["awl_sum"],2).""; ?></td> 
<td  align="left" class="style30"><?php echo  number_format($objResult13["nbm_sum"],2).""; ?></td> 
<td  align="right" class="style30"><?php echo  number_format($objResult13["sumary"],2).""; ?></td> 
<td  align="right" class="style30"><?php echo  number_format($percent_all,2).""; ?>%</td> 
	
      
    </tr>	
	
	
</table>
	
	
<br><br>
	
<?php 
 $dataPoints = array();


 $sql = "SELECT *  FROM tb__buypro_com   Order by sumary DESC ";
$result = mysqli_query($conn,$sql) or die ("Error Query [".$sql."]");
$Num_Rows5 = mysqli_num_rows($result);

 while($row = mysqli_fetch_array($result))
 {            
     array_push($dataPoints, array("label"=> $row['group_1'], "y"=> $row['sumary']));
 }
	
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script>
    window.onload = function() {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            title: {
                text: "รายงานยอดขายตามกลุ่มสินค้า"
            },
            data: [{
                //type: "column", //change type to bar, line, area, pie, etc  
                // ถ้าต้องการเปลี่ยนจากกราฟแท่งเป็นกราฟแผนภูมิวงกลม ให้เปิด คอมเมนต์ ด้านล่างนี้และเปลี่ยน จาก type: "column" เป็น type: "pie"
                 type: "pie",
                // yValueFormatString: "#,##0.00\"%\"",
                // indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }
    </script>

</head>

<body>

    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


</body>
	<br><br>