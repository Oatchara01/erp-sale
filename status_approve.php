<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-container w3-padding-large">
<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>"></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value="<?php echo $_GET["end_date"];?>"></div>
<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $_GET["Keyword"];?>"></div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php		  
$keyword=$_GET["Keyword"];		
$start_date=$_GET["start_date"];	
$end_date=$_GET["end_date"];	
$name=$_SESSION["name"];

include "dbconnect.php";

$strSQL = "SELECT
so__main.* ,tb_salechannel.*  FROM (so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)";

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
<div class="w3-container">
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%">เลขที่อ้างอิง</th>
<th width="10%">วันที่ลงทะเบียน</th>
<th width="10%">เลขที่เอกสาร</th> 
<th width="10%">วันที่ออกเอกสาร</th>
<th width="23%">รายการสินค้า</th>
<th width="22%">ชื่อลูกค้า</th>
<th width="20%">ช่องทางการขาย</th>
<th width="5%">Status</th>
<th width="5%">แก้ไข</th>
</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
<tbody>
<tr align="">
<td><?php echo $objResult["ref_id"];?></td>
<td><?php echo DateThai($objResult["register_date"]);?></td>
<td><?php echo $objResult["doc_no"];?></td>
<td>
<?php if ($objResult["doc_release_date"]=="0000-00-00") {
	echo "-"; 
	} 
	else 
	{ echo DateThai($objResult["doc_release_date"]);
	}
	?> 
</td>
<td><div align="left">
<?php
$strSQL1 = "SELECT * FROM so__submain WHERE ref_idd = '".$objResult["ref_id"]."' ";
///echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php echo $objResult1["product_name"];?><br />
<?php
}
?>
</div>
</td>
<td><div align="left"><?php echo $objResult["delivery_contact"];?></div></td>
<td><div align="left"><?php echo $objResult["salechannel_nameshort"];?> <?php echo $objResult["salechannel_name"];?></div></td>
<td><?php echo $objResult["status"];?></td>
<td><a href="register_approve_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>
</tr>
<?php
$i++;
}
?>
</tbody>
</table>
<div class="w3-panel">    <strong>พบทั้งหมด</strong>
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
</div>
<?php include('foot.php'); ?>
</div>
</body>
</html>