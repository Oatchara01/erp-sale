<?php 


include('head.php');
include('dbconnect_sale.php');

 
 
 ?>


<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 14px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 14px; color: #FF0000; }
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

.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}
</style>


<body>
<form   method="GET" name="frmMain" enctype="multipart/form-data" >
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>ADD : CUSTOMER</h4></div>

	<div class="w3-container w3-bar w3-quarter">
ค้นหาเดือนเกิด : <?php /*<input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>">*/ ?>
	
<select name="month" id="month" class="w3-input" style="width:100%;" >
<option class="w3-bar" value="">**โปรดเลือกเดือนเกิด**</option>
<?php
$province1="select * from tb_month order by month_id asc";
$prosql1=mysqli_query($conn,$province1);
while ($fepro1=mysqli_fetch_array($prosql1))
{ ?>
<option class="w3-bar" value="<?php echo $fepro1["month_id"]; ?>"><?php echo $fepro1["month_name"]; ?></option>
<?php } ?>
</select>
	
	</div>
<?php /*<div class="w3-container w3-bar w3-quarter">
ถึง :<input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value="<?php echo $_GET["end_date"];?>"></div>	*/ ?>
	<div class="w3-container w3-bar w3-quarter">
		
		อาชีพ :
	<select name="occupation" id="occupation" class="w3-input" style="width:100%;" >
<option class="w3-bar" value="">**โปรดเลือกอาชีพ**</option>
<?php
$province1="select * from tb_occupation order by occupation_id";
$prosql1=mysqli_query($conn,$province1);
while ($fepro1=mysqli_fetch_array($prosql1))
{ ?>
<option class="w3-bar" value="<?php echo $fepro1["occupation_name"]; ?>"><?php echo $fepro1["occupation_name"]; ?></option>
<?php } ?>
</select>
	</div>
<div class="w3-container w3-bar w3-quarter">	
	 รายได้ต่อเดือน

<select name="salary" id="salary" style="width:260px" class="w3-input"   >
<option  value="">**โปรดเลือก**</option>
<option  value="1"><?php echo "<30,000฿";?></option>
<option  value="2">30,001-50,000฿</option>
<option  value="3">50,001-100,000฿</option>
<option  value="4">100,001-200,000฿</option>
<option  value="5"><?php echo ">200,000฿";?></option>
	
</select>
	</div>
	
	<div class="w3-container w3-bar w3-quarter">	
	 สนใจสินค้าสำหรับ</p>

<input type='checkbox'  name='product_fer1' id = 'product_fer1' value='1' />  ผู้ป่วยพักฟื้น 
<input type='checkbox'  name='product_fer2' id = 'product_fer2' value='2' />  ผู้สูงอายุ </p>
<input type='checkbox'  name='product_fer3' id = 'product_fer3' value='3' />  ผู้ป่วยติดเตียง 
<input type='checkbox'  name='product_fer4' id = 'product_fer4' value='4' />  สินค้าดูแลสุขภาพ 

	</div>
	
	<div class="w3-container w3-bar w3-quarter">	
	 ท่านรู้จัก Allwell จาก

<select name="well_allwell" id="well_allwell" style="width:260px" class="w3-input"   >
<option  value="">**โปรดเลือก**</option>
<option  value="1">ผลการค้นหาบน Google</option>
<option  value="2">โฆษณา Banner บน Website</option>
<option  value="3">คนรู้จัก / บุคลากรทางการแพทย์แนะนำ</option>
<option  value="4">รู้จักจาก ฟาร์ ทริลเลียน</option>
<option  value="5">อื่นๆ</option>
	
</select>
	</div>
	
	<div class="w3-container w3-bar w3-quarter">	
	 สิ่งสำคัญในการเลือกซื้อสินค้า</p>

<input type='checkbox'  name='best_service1' id = 'best_service1' value='1' />  บริการก่อนและหลังการขาย </p>
<input type='checkbox'  name='best_service2' id = 'best_service2' value='2' />  ความน่าเชื่อถือของบริษัท 
<input type='checkbox'  name='best_service3' id = 'best_service3' value='3' />  สินค้าที่มีคุณภาพ 

	</div>

<div class="w3-container w3-bar w3-quarter">	
	 ท่านเคยซื่อสินค้าหรือไม่</p>

<input type='radio'  name='best_service4' id = 'best_service4' value='1' />  เคย 
<input type='radio'  name='best_service4' id = 'best_service4' value='0' />  ไม่เคย 

	</div>

<div class="w3-container w3-bar w3-quarter">	
	 สถานะลูกค้า</p>

<input type='radio'  name='status_cus' id = 'status_cus' value='0' />  Gold Customer </p>
<input type='radio'  name='status_cus' id = 'status_cus' value='1' />  Platinum Customer </p>
<input type='radio'  name='status_cus' id = 'status_cus' value='2' />  Daimond Customer </p>

	</div>

<div class="w3-container w3-bar w3-quarter">	
	 รหัสบัตรสมาชิก
<input type='text'  name='customer_no' id = 'customer_no' value = "<?php echo $_GET['customer_no']; ?>" class="w3-input" />
</div>
<div class="w3-container w3-bar w3-quarter">	
	 เบอร์โทร
<input type='text'  name='cus_tel' id = 'cus_tel'  value = "<?php echo $_GET['cus_tel']; ?>" class="w3-input" />
</div>

<a href="report_customer_regis.php?month=<?php echo $_GET["month"];?>&sale_code=<?php echo $_GET["sale_code"];?>&Keyword=<?php echo $_GET["Keyword"];?>&occupation=<?php echo $_GET["occupation"];?>&salary=<?php echo $_GET["salary"];?>&customer_no=<?php echo $_GET["customer_no"];?>&cus_tel=<?php echo $_GET["cus_tel"];?>&product_fer1=<?php echo $_GET["product_fer1"];?>&product_fer2=<?php echo $_GET["product_fer2"];?>&product_fer3=<?php echo $_GET["product_fer3"];?>&product_fer4=<?php echo $_GET["product_fer4"];?>&well_allwell=<?php echo $_GET["well_allwell"];?>&best_service1=<?php echo $_GET["best_service1"];?>&best_service2=<?php echo $_GET["best_service2"];?>&best_service3=<?php echo $_GET["best_service3"];?>&best_service4=<?php echo $_GET["best_service4"];?>&status_cus=<?php echo $_GET["status_cus"];?>"><img src="img/print_icon-2.png" align="right"  width="40" height="40" border="0" /></a>

<center>
		<div class="w3-bar w3-quarter w3-padding-xsmall">
		<input type="submit" class="w3-button w3-teal" value="Search"></div></center>
		</div></p>

<?php
	
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$occupation = isset($_GET['occupation']) ? $_GET['occupation'] : '';
    $month = isset($_GET['month']) ? $_GET['month'] : '';
		//$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	//$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	$salary  = isset($_GET['salary']) ? $_GET['salary'] : '';
   $customer_no  = isset($_GET['customer_no']) ? $_GET['customer_no'] : '';
   $cus_tel = isset($_GET['cus_tel']) ? $_GET['cus_tel'] : '';
$product_fer1  = isset($_GET['product_fer1']) ? $_GET['product_fer1'] : '';
$product_fer2  = isset($_GET['product_fer2']) ? $_GET['product_fer2'] : '';
$product_fer3  = isset($_GET['product_fer3']) ? $_GET['product_fer3'] : '';
$product_fer4  = isset($_GET['product_fer4']) ? $_GET['product_fer4'] : '';
$well_allwell = isset($_GET['well_allwell']) ? $_GET['well_allwell'] : '';	
$best_service1 = isset($_GET['best_service1']) ? $_GET['best_service1'] : '';	
$best_service2 = isset($_GET['best_service2']) ? $_GET['best_service2'] : '';
$best_service3 = isset($_GET['best_service3']) ? $_GET['best_service3'] : '';
$best_service4 = isset($_GET['best_service4']) ? $_GET['best_service4'] : '';
$status_cus = isset($_GET['status_cus']) ? $_GET['status_cus'] : '';

include "dbconnect.php";

$strSQL = "SELECT *  FROM tb_customer  where customer_no !=''";
	
if($month !=""){ 
    $strSQL .= ' AND month = "'.$month.'"'; 
}
/*if($end_date !=""){ 
    $strSQL .= ' AND brithday <= "'.$end_date.'"'; 
}*/

if($occupation !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND occupation  = "'.$occupation.'"'; 
}
if($salary !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND salary  = "'.$salary.'"'; 
}

if($product_fer1 !=''){
$strSQL .= ' AND product_fer1  = "'.$product_fer1.'"'; 
}
if($product_fer2 !=''){
$strSQL .= ' AND product_fer2  = "'.$product_fer2.'"'; 
}
if($product_fer3 !=''){
$strSQL .= ' AND product_fer3  = "'.$product_fer3.'"'; 
}
if($product_fer4 !=''){
$strSQL .= ' AND product_fer4  = "'.$product_fer4.'"'; 
}
if($well_allwell !=''){
$strSQL .= ' AND well_allwell  = "'.$well_allwell.'"'; 
}

if($best_service1 !=''){
$strSQL .= ' AND best_service1  = "'.$best_service1.'"'; 
}
if($best_service12!=''){
$strSQL .= ' AND best_service2  = "'.$best_service2.'"'; 
}
if($best_service3 !=''){
$strSQL .= ' AND best_service3  = "'.$best_service3.'"'; 
}
if($best_service4 !=''){
$strSQL .= ' AND best_service4  = "'.$best_service4.'"'; 
}

if($status_cus !=''){
$strSQL .= ' AND status_cus  = "'.$status_cus.'"'; 
}

if($customer_no !=''){
$strSQL .= ' AND customer_no  = "'.$customer_no.'"'; 	
}
if($cus_tel !=''){
$strSQL .= ' AND cus_tel  LIKE "%'.$cus_tel.'%"'; 		
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


$strSQL .=" order  by customer_no DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);
?>
<div class="w3-container"></p>
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">รหัสบัตรสามาชิก</th>
			<th width="15%">ชื่อลูกค้า</th>
			<th width="10%">วันเกิด</th>
			<th width="10%">อาชีพ</th>
			<th width="15%">ที่อยู่</th> 
			<th width="10%">จังหวัด</th>
			<th width="10%">เบอร์โทร</th>
			<th width="10%">Email</th>
			<th width="10%">เขตการขาย</th>
			<th width="10%">สถานะ</th>
			<th width="10%">วันที่สมัคร</th>
			<th width="2%">ดูรายละเอียด</th>
			<th width="2%">ข้อมูลการขาย</th>
	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
				<td><?php echo $objResult["customer_no"];?></td>
				<td><?php echo $objResult["first_name"];?> <?php echo $objResult["last_name"];?></td>
				<td><?php echo Datethai($objResult["brithday"]);?></td>
				<td><?php echo $objResult["occupation"];?></td>
				<td><?php echo $objResult["cus_address"];?></td>
				<td><?php echo $objResult["cus_province"];?></td>
				<td><?php echo $objResult["cus_tel"];?></td>
				<td><?php echo $objResult["email_cus"];?></td>
				<td><?php echo $objResult["sale_code"];?></td>
				<?php if($objResult["status_cus"]=='0'){ ?>
				<td bgcolor="#FFFF00">Gold Customer</td>
				<?php }else if($objResult["status_cus"]=='1'){ ?>
				<td  bgcolor="#CCFF99">Platinum Customer</td>
				<?php }else if($objResult["status_cus"]=='2'){ ?>
				<td  bgcolor="#00FF00">Daimond Customer</td>
				<?php }else{ ?>
				<td></td>
				<?php } ?>
				
				<td><?php echo Datethai($objResult["add_date"]);?></td>
				<td><a href="edit_customer_register.php?customer_id=<?php echo $objResult["customer_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>
<td><a href="status_customer_showromm.php?bill_id=<?php echo $objResult["customer_id"];?>" target="_blank"><img src="img/create.png" width="23" height="23" border="0" /></a></td>


</tr>
</tbody>
			

<?php
}
?>

</table>
<div class="w3-panel"><strong>พบทั้งหมด</strong> <?= $Num_Rows;?>
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
</div></div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>

</form>

</body>
</html>


