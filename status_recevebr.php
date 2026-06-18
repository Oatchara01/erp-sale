<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายการรับจ่ายใบยืม (ค้างคืน)</h4></div>

<div class="w3-bar w3-quarter">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" ></div>
<div class="w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" ></div>
<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
	
	<div class="w3-bar w3-quarter">
	 บริษัท


<select name="company" id="company" style="width:160px" class="w3-input" >
<option  value="">**Please Select**</option>
<option  value="1">PTL</option>
<option  value="2">NBM</option>


</select>
		</div></div>
	</p>
	<center>
	<input type="submit" class="w3-button w3-teal" value="Search">
		</center>
	</p>
</form>
<?php	
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	$company = isset($_GET['company']) ? $_GET['company'] : '';
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$sale_code = $_SESSION['code'];

$strSQL = "SELECT *  FROM tb_register_br  where close_doc ='0' and doc_2 ='0'";

if($start_date !=""){ 
    $strSQL .= ' AND br_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 

    $strSQL .= ' AND br_date <= "'.$end_date.'"'; 
}
	if($company !=""){ 

    $strSQL .= ' AND company = "'.$company.'"'; 
}
if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	   $strSQL .= ' AND customer_name LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or iv_no  LIKE "%'.$Keyword.'%"'; 
$strSQL .= ' or ref_id  LIKE "%'.$Keyword.'%"'; 
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


$strSQL .=" order  by iv_no DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			
			<th width="8%">วันที่</th>
			<th width="8%">เลขที่เอกสาร</th> 
			<th width="10%">ชื่อลูกค้า</th> 
			<th width="5%">ผู้รับสินค้า</th>
			<th width="5%">ผู้รับเอกสาร</th>
			<th width="5%">ผู้คืนอกสาร</th>
			<th width="5%">ผู้จ่ายเอกสาร</th>
			<th width="5%">ผู้รับคืนเอกสาร</th>
			<th width="5%">เอกสาร</th>
			<th width="5%">ใบตรวจทาน</th>
			
			<th width="8%">ตามงานครั้งที่1</th>
			<th width="8%">ตามงานครั้งที่2</th>
			<th width="8%">แจ้ง SUP</th>
			<th width="8%">ใบ CAR</th>
			<th width="15%">หมายเหตุ</th>
			<th width="5%">แก้ไข</th>
			<th width="5%">Copy Page</th>
            <th width="5%">สถานะ</th>
			<th width="10%">หมายเหตุการยกเลิก</th>
	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			
	
			<tr>
				
<?php if($objResult["doc_2"] =='1'){	 ?>
				<td bgcolor="#FF99FF">
					<?php }else{ ?>
				<td>
					<?php } ?> <?php
 echo DateThai($objResult["br_date"]);
					?></td>
				<td><?php echo $objResult["iv_no"];?></td>
				
				<td><div align="left"><?php echo $objResult["customer_name"];?></div></td>

				<td  align="center" class="style39"> <a id="add" class="various iframe" href="receive_product.php?id_br=<?=$objResult["id_br"]?>"><img src="communication.png" width="30" height="30" border="0" /></a></p>
	<?php echo $objResult["product_receive1"];?></td>
				
								<td  align="center" class="style39"> <a id="add" class="various iframe" href="doc_receive.php?id_br=<?=$objResult["id_br"]?>"><img src="communication.png" width="30" height="30" border="0" /></a></p>
	<?php echo $objResult["doc_receive1"];?></td>
				
				<td  align="center" class="style39"> <a id="add" class="various iframe" href="doc_return.php?id_br=<?=$objResult["id_br"]?>"><img src="communication.png" width="30" height="30" border="0" /></a></p>
	<?php echo $objResult["doc_return1"];?></td>
				
				<td  align="center" class="style39"> <a id="add" class="various iframe" href="doc_send.php?id_br=<?=$objResult["id_br"]?>"><img src="communication.png" width="30" height="30" border="0" /></a></p>
	<?php echo $objResult["doc_send1"];?></td>
				
				<td  align="center" class="style39"> <a id="add" class="various iframe" href="doc_amd.php?id_br=<?=$objResult["id_br"]?>"><img src="communication.png" width="30" height="30" border="0" /></a></p>
	<?php echo $objResult["doc_adm1"];?></td>

		<td  align="center" class="style39"> 
	<?php 
	 if($objResult["company"]=='1'){
	if($objResult["doc_white"]=='1'){
			echo "สีขาว ได้รับเอกสารแล้ว";
		}
		 ?>
			</p>
			<?php
		 if($objResult["doc_green"]=='1'){
			echo "สีเขียว ได้รับเอกสารแล้ว";
		}
		}
	
	
	if($objResult["company"]=='2'){
	if($objResult["doc_purple"]=='1'){
			echo "สีม่วง ได้รับเอกสารแล้ว";
		}
		 ?>
			</p>
			<?php
		 if($objResult["doc_greenckk"]=='1'){
			echo "สีเขียว ได้รับเอกสารแล้ว";
		}
		}
			
			?></td>


				
				<td  align="center" class="style39"> 
	<?php  if($objResult["doc_check"]=='1'){
					echo "ได้รับเอกสารแล้ว";
				}else{
echo "NO";
				}
					
					;?>
	
	
	</td>
				

				

				<td >
					<?php if ($objResult["date_trace1"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{
						echo DateThai($objResult["date_trace1"]);
						?>
					</p>
					<?php
						echo $objResult["trace_des1"];
					}
					?> 
				</td>

				<td >
					<?php if ($objResult["date_trace2"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["date_trace2"]);
					 ?>
					</p>
					<?php
						echo $objResult["trace_des2"];
					}
					?> 
				</td>

				<td >
					<?php if ($objResult["sup_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["sup_date"]);
					 ?>
					</p>
					<?php
						echo $objResult["sup_des"];
					}
					?> 
				</td>

				<td >
					<?php if ($objResult["car_date"]=="0000-00-00") {
						echo "-"; 
					} 
					else 
					{ echo DateThai($objResult["car_date"]);
					 ?>
					</p>
					<?php
						echo $objResult["car_des"];
					}
					?> 
				</td>

				<td  align="center" class="style39"> 
	<?php echo $objResult["remark"];?></td>


<td>

				<a href="register_recevebr_edit.php?id_br=<?php echo $objResult["id_br"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
								
				</td>
				

<td>
<a href=javascript:if(confirm('!!!ต้องการเพิ่มเอกสารใหม่โดยCopyเอกสารเดิมใช่หรือไม่')==true){window.location='register_recevebr_create.php?id_br=<?php echo $objResult["id_br"];?>&start_date=<?php echo $_GET["start_date"];  ?>&end_date=<?php echo $_GET["end_date"];?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a>
	
</td>

<?php if($objResult["cancel"] =='1'){	 ?>
				<td bgcolor="#FF3030"><?php echo "ยกเลิก";?>
						</td>
					
					<?php }else{ ?>
					<td> </td>
					<?php } ?>
	<td><div align="left"><?php echo $objResult["cancel_des"];?></div></td>	
			</tr>
			<?php $i++; } ?>
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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&company=$company'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&company=$company'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&start_date=$start_date&end_date=$end_date&company=$company'><span class='style40'>Next>></span></a> ";
	}
	
	?>
      <br></div></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	

</body>
</html>