
<?php

include ('head.php'); 
include "dbconnect.php";

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
	<div class="w3-panel w3-light-grey"><h3> รายการใบตรวจทาน (ขาไป)</h3></div>

<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo 	$keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
	
	<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
	
	

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">เลขที่อ้างอิง</td >
			<td width="10%">วันที่ใบตรวจทาน</td >
			<td width="10%">เลขที่ใบยืม</td > 
			<td width="25%">ชื่อลูกค้า</td >
			<td width="30%">รายการสินค้า</td >
			<td width="2%">ตรวจเช็ค</td >
			<td width="2%">ปิดใบตรวจทาน</td >	

	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");
$keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';		
		

$strSQL = "SELECT DISTINCT ref_pcc FROM (tb_product_checklis LEFT JOIN tb_product_checklist ON tb_product_checklis.ref_pcc=tb_product_checklist.ref_pc) where  tb_product_checklis.add_by = '' and type_emp ='EN' and go_back='1'";
		
if($keyword !=""){ 
	$strSQL .= ' AND doc_no  LIKE "%'.$keyword.'%"'; 
	$strSQL .= ' or sn  LIKE "%'.$keyword.'%"'; 
	$strSQL .= ' or br_no  LIKE "%'.$keyword.'%"'; 
}				
		
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]"); 
$Num_Rows = mysqli_num_rows($objQuery);


$Per_Page = '20';  
		$Page = isset($_GET['Page']) ? $_GET['Page'] : '';

	if(!isset($_GET['Page']))
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


$strSQL .=" order  by date_create DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$sql = "SELECT *   FROM tb_product_checklist where ref_pc = '".$objResult["ref_pcc"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$sql2 = "select sol_name from tb_product where product_ID = '".$rs["product_id"]."'";
$query2 = mysqli_query($conn,$sql2);
$fetch2 = mysqli_fetch_array($query2,MYSQLI_ASSOC); 


$ref_id = substr($rs["ref_id"],0,2);

if($ref_id=='BR'){

$sql1 = "select iv_no,customer from hos__br where ref_id_br = '".$rs["ref_id"]."'";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 

$customer = $fetch1["customer"];
$iv_no = $fetch1["iv_no"];
	
}else if($ref_id=='RT'){

$sql1 = "select iv_no,rental_name from hos__rental where ref_id = '".$rs["ref_id"]."'";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 

$customer = $fetch1["rental_name"];
$iv_no = $fetch1["iv_no"];
	
	
	

}else if($ref_id=='CH'){

$sql1 = "select iv_no,customer from hos__change where ref_id = '".$rs["ref_id"]."'";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 

$customer = $fetch1["customer"];
$iv_no = $fetch1["iv_no"];

}else{

$sql1 = "select doc_no,customer_name from so__main where ref_id = '".$rs["ref_id"]."'";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 

$customer = $fetch1["customer_name"];
$iv_no = $fetch1["doc_no"];

}

 $updateSQL = "UPDATE tb_product_checklist SET br_no ='" . $iv_no . "' WHERE ref_pc='" . $objResult["ref_pcc"] . "'";
 mysqli_query($conn, $updateSQL);
	
?>
		<tr>

<td  ><?php echo $rs["doc_no"];?>/<?php echo $rs["year_no"];?></td>
<td ><?php echo Datethai($rs["date_create"]);?></td>
<td ><?php echo $iv_no;		?></td>
<td ><?php echo $customer;?></td>
<td ><?php echo $fetch2["sol_name"];?></td>			
<td><a href="register_chken1.php?ref_pc=<?php echo $objResult["ref_pcc"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a></td>
<td>
	
<a href=javascript:if(confirm('!!!ต้องการปิดใบตรวจทานสินค้าใช่หรือไม่')==true){window.location='register_chkencls1.php?ref_pc=<?php echo $objResult["ref_pcc"];?>';}><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
								
				</td>					
				

			</tr>

			<?php $i++; 
				}

?>
		
	</table>
	

 <div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword'><span class='style40'>Next>></span></a> ";
	}

	
	?>
      <br></div></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>