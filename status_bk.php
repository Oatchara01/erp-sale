<?php include "error_page.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sale Online</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/form_style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>


<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 14px; color: #000000; }
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

</head>
<body>

  <div id="header">
    <div id="site_title">
      <h1><a href="main_office.php"></a></h1>
	    

      <!-- end of site_title -->
    </div>
    
  </div>
  <div id="main_wrapper3"> <span class="top"></span>
    <div id="main">


<center>
      <h2><span class="style15">Sale Online</span></h2>
         </center>  
		 <form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<tr>
<th>

วันที่ :
<input name="start_date" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>">
ถึง :
<input name="end_date" type="date" id="end_date" value="<?php echo $_GET["end_date"];?>">

ค้นหา :

<input name="Keyword" type="text" id="Keyword" value="<?php echo $_GET["Keyword"];?>">
<input type="submit" value="Search"></th></p>
</tr>
</form>
<?php		  
  $keyword=$_GET["Keyword"];		
$start_date=$_GET["start_date"];	
$end_date=$_GET["end_date"];	
$name=$_SESSION[name_show];


include "dbconnect.php";

$strSQL = "SELECT
so__main.* ,so__submain.*,tb_salechannel.*  FROM ((so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)";

/*$strSQL = "SELECT *  FROM so__main "; where(running LIKE '%".$_GET["Keyword"]."%' or add_date LIKE '%".$_GET["Keyword"]."%'or add_by LIKE '%".$_GET["Keyword"]."%'or department LIKE '%".$_GET["Keyword"]."%' or product_sn  LIKE '%".$_GET["Keyword"]."%'or  between_date  LIKE '%".$_GET["Keyword"]."%'or address_name  LIKE '%".$_GET["Keyword"]."%'or product_name  LIKE '%".$_GET["Keyword"]."%'or status_comment  LIKE '%".$_GET["Keyword"]."%' )


if($start_date !=""){ 
    $strSQL .= ' AND start_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND start_date <= "'.$end_date.'"'; 
}

if($keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
    $strSQL .= ' AND running  LIKE "%'.$keyword.'%"'; 
	$strSQL .= ' or department  LIKE "%'.$keyword.'%"'; 

}
echo $strSQL;

exit();*/

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



$Per_Page = 10;   // Per Page

	$Page = $_GET["Page"];
	if(!$_GET["Page"])
	{
		$Page=1;
	}

	$Prev_Page = $Page-1;
	$Next_Page = $Page+1;

	$Page_Start = (($Per_Page*$Page)-$Per_Page);
	if($Num_Rows<=$Per_Page)
	{
		$Num_Pages =1;
	}
	else if(($Num_Rows % $Per_Page)==0)
	{
		$Num_Pages =($Num_Rows/$Per_Page) ;
	}
	else
	{
		$Num_Pages =($Num_Rows/$Per_Page)+1;
		$Num_Pages = (int)$Num_Pages;
	}


$strSQL .=" order  by ref_id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);



?>

</p>
<table border="1" width="100%">
<tr>
<td width="62" align="center" bgcolor="#0a152e">เลขที่อ้างอิง</td>
<td width="62" align="center" bgcolor="#0a152e">วันที่ลงทะเบียน</td>
<td width="72" align="center" bgcolor="#0a152e">เลขที่เอกสาร</td> 
<td width="62" align="center" bgcolor="#0a152e">วันที่ออกเอกสาร</td>

<td width="75" align="center" bgcolor="#0a152e">รายการสินค้า</td>
<td width="28" align="center" bgcolor="#0a152e">ชื่อลูกค้า</td>

<td width="42" align="center" bgcolor="#0a152e">ช่องทางการขาย</td>
<td width="65" align="center" bgcolor="#0a152e">Status</td>
<td width="28" align="center" bgcolor="#0a152e">แก้ไข</td>


</tr>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
<tr>




<td align="center" class="style39"><?php echo $objResult["ref_id"];?></td>
<td class="style39"><?php
	$date1 = explode('-' , $objResult["register_date"] );
$ydate = $date1[2].'-'.$date1[1].'-'.$date1[0];
 echo $ydate;?></td>
<td class="style39"><?php echo $objResult["doc_no"];?></td>
<td class="style39"><?php
	$date = explode('-' , $objResult["doc_release_date"] );
$xdate = $date[2].'-'.$date[1].'-'.$date[0];
 echo $xdate;?></td>


<td class="style39"><?php echo $objResult["product_name"];?></td>

<td class="style39"><?php echo $objResult["delivery_contact"];?></td>


<td align="center" class="style39"><?php echo $objResult["salechannel_nameshort"];?> <?php echo $objResult["salechannel_name"];?></td>
<td align="center" class="style39"><?php echo $objResult["status"];?></td>

<td align="center"><a href="register_office_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>








				
					</tr>
<?php
$i++;
}
?>

</table>

<p><br />
    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$_GET[Keyword]&start_date=$_GET[start_date]&end_date=$_GET[end_date]'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$_GET[Keyword]&start_date=$_GET[start_date]&end_date=$_GET[end_date]'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$_GET[Keyword]&start_date=$_GET[start_date]&end_date=$_GET[end_date]'><span class='style40'>Next>></span></a> ";
	}
	
	?>
      </p></br>
      
      </div>
    </div>
  </div>
</div>
<div id="cr_bar_wrapper">
  <div id="cr_bar"> Copyright © 2018 phar trillion co., ltd. </div>
</div>
</body>
</html>

