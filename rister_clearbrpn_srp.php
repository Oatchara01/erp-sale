<?php include('head.php'); 
include('dbconnect.php');
?>


<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>

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

	
<style>
	.none {
    display:none;
	}
</style>

<div class="w3-white w3-container">
	<div class="w3-panel w3-light-grey"><h3>ใบเบิกเครื่องและอะไหล่</h3></p>	
	<h5>(Device and Spare Part Request)</h5>
	</div>
	<form action="rister_clearbrpn_srp1.php" method="post" name="frmMain" enctype="multipart/form-data"  onSubmit="JavaScript:return fncSubmit();" >
		

	<div class="w3-bar">
	
		<?php
			

$yearMonth = substr(date("Y")+543, -2).date("m");
$year_1 = substr(date("Y")+543, -2);
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__spr";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "SPR";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}


/*$sql1 = "SELECT MAX(spr) AS spr FROM hos__spr";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

$spr = $rs1["spr"]+1;*/

		
$ref_id_br =$_GET["ref_id_br"];

$strSQL = "SELECT *   FROM hos__br where ref_id_br ='".$ref_id_br."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_assoc($objQuery);


$strSQL1 = "SELECT * FROM  (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$ref_id_br."' ";

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


		?>
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $so; echo $nextId; ?></span>
		<input type="hidden" name="ref_idsmp" class="w3-input" value="<?php echo $so; echo $nextId; ?>">
	</div>

	<div class="w3-bar w3-padding-small"></div><!-- bar -->
		<div class="w3-half 1">
			<div class="w3-bar w3-margin-bottom">
			<?php if($objResult["company"]=='1'){ ?>
			<input type="radio" name="type_company"  checked ='checked' value="1">&nbsp;AWL
            <input type="radio" name="type_company"  value="2" >&nbsp;NBM

			<?php }else{ ?>

			<input type="radio" name="type_company"   value="1">&nbsp;AWL
            <input type="radio" name="type_company" checked ='checked' value="2" >&nbsp;NBM

				<?php } ?>
				</div>


<div class="w3-bar w3-margin-bottom">
			W/O No. : 
			<input type="text" name="wo_no" id="wo_no" class="w3-input" style="width:90%;"  required>
			<input type="hidden" name="ref_id_br" id="ref_id_br" value ="<?php echo $ref_id_br; ?>" class="w3-input" style="width:90%;"  required>
</div>

		<div class="w3-bar w3-margin-bottom">
			วันที่  :<input type="date" name="spr_date" value = "<?php echo $today; ?>" style="width:30%;" class="w3-input"  required>
			
</div>
			<div class="w3-bar w3-margin-bottom">
ที่อยุ่ :<textarea name="address" id="address" class="w3-input" style="width:90%;"  required><?php echo $objResult["address"]; ?></textarea>
</div>
<div class="w3-bar w3-margin-bottom">
			Equipment : 
			<input type="text" name="equipment" id="equipment" class="w3-input" style="width:90%;"  required>
</div>
<div class="w3-bar w3-margin-bottom">
			Engineer : 
			<input type="text" name="engineer" id="engineer" class="w3-input" value = "<?php echo $_SESSION['name']; ?>  <?php echo $_SESSION['surname']; ?>" style="width:90%;"  required>
			<input type="hidden" name="sale_code" id="sale_code" value="<?php echo $_SESSION['code']; ?>" class="w3-input" style="width:90%;"  required>
</div>

<div class="w3-bar w3-margin-bottom">
			วันที่ หมดอายุ :<input type="date" name="date_exp"  style="width:30%;" class="w3-input"  required>
			
</div>		

<div class="w3-bar w3-margin-bottom">
			<input type="checkbox" name="clear_brn" value ="1" > Clear ใบยืมติดเล่มเลขที่ :<input type="text" name="brn_no"  style="width:90%;" class="w3-input"  >
			
</div>		

</div>



<div class="w3-half 1">

<div class="w3-bar w3-margin-bottom">
			SPR : 
			<input type="text" name="spr_no" id="spr_no"  class="w3-input" style="width:90%;"  readonly>
</div>
			
<div class="w3-bar w3-margin-bottom">
			ชื่อลูกค้า 
			<input type="text" name="customer" id="customer" value="<?php echo $objResult["customer"]; ?>" class="w3-input" style="width:90%;"  required>
</div>

<div class="w3-bar w3-margin-bottom">
			SN : 
			<input type="text" name="sn_num" id="sn_num" class="w3-input" style="width:90%;"  required>
</div>


			
		<div class="w3-bar w3-margin-bottom">
			วันที่ ติดตั้ง :<input type="date" name="date_imstall"  style="width:30%;" class="w3-input"  required>
			
</div>	
<div class="w3-bar w3-margin-bottom">
			วันที่ของเข้า :<input type="date" name="date_receive"  style="width:30%;" class="w3-input"  >
	</div>	
<div class="w3-bar w3-margin-bottom">
			PER : 
			<input type="text" name="per_no" id="per_no" class="w3-input" style="width:90%;"  >
</div>

<div class="w3-bar w3-margin-bottom">
			<input type="checkbox" name="clear_brnp" checked='checked' value ="1" > Clear ใบยืมกระดาษต่อเนื่องเลขที่ :<input type="text" name="brnp_no"  value="<?php echo $objResult["iv_no"]; ?>" style="width:90%;" class="w3-input"  >
			
</div>	
<div class="w3-bar w3-margin-bottom">
			<input type="checkbox" name="clear_epe" value ="1" > ของเสียส่งไปต่างประเทศตาม EPE :<input type="text" name="epe_no"  style="width:90%;" class="w3-input"  >
		</div>	

<div class="w3-bar w3-margin-bottom">
<input type="radio" name="pro_ckk" value = '3' > ไม่มีอะไหล่คืน (โปรดกรอกรายละเอียด)
<input type="radio" name="pro_ckk" value = '1' > อะไหล่คืนใช้งานไม่ได้
<input type="radio" name="pro_ckk" value = '2' >  อะไหล่คืนใช้งานได้ แต่สภาพไม่สมบูรณ์ (โปรดกรอกรายละเอียด)
</div>	

<div class="w3-bar w3-margin-bottom">
อาการเสีย : 
<input type="text" name="pro_des" id="pro_des" class="w3-input" style="width:90%;"  >
</div>

</div>
		
		

	</p>
	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
</div>


<div id="pd" class="w3-container city1">
<font color='red'>**กรุณาเลือกสินค้าที่ต้องการเคลียร์เท่านั้น !!!</font>

<table width="100%" border="0" class="w3-table">

	<th>เลือกสินค้า</th>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>ราคาต่อหน่วย</th>
    <th>ยอดรวม</th>
	<th>หมายเหตุ</th>
	<th>หมายเลขเครื่อง</th>
    
<tbody>

<?php


while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
if($objResult1["sn"] !=''){


$sn_number =  $objResult1["sn"];
$str_arr = explode("\n",$sn_number);
$i = 1;
foreach ($str_arr as $test =>$value){
$product_sn = $str_arr[$test];
$product_sn1 =  trim($product_sn);

$strSQL2 = "SELECT sn FROM   hos__subso  WHERE clear_ivno = '".$objResult["iv_no"]."' and product_id = '".$objResult1['product_id']."' and sn = '".$product_sn1."' and status_so ='Approve'";

$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

$strSQL3 = "SELECT sn FROM  (hos__receive LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd) WHERE iv_no = '".$objResult["iv_no"]."' and product_id = '".$objResult1['product_id']."' and sn = '".$product_sn1."' ";

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);

$sql2 = "SELECT sn  FROM  hos__subsmp   where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and br_no ='".$objResult["iv_no"]."' and sn ='".$product_sn1."' and status_smp ='Approve'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows19 = mysqli_num_rows($qry2);
	
$sql5 = "SELECT sn  FROM hos__subspr where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and clear_ivno ='".$objResult["iv_no"]."' and sn ='".$product_sn1."' and status_spr='Approve'";
$qry5 = mysqli_query($conn,$sql5) or die(mysqli_error());
$Num_Rows20 = mysqli_num_rows($qry5);


if($Num_Rows2 > 0){

}else if ($Num_Rows3 > 0){

}else if ($Num_Rows19 > 0){

}else if ($Num_Rows20 > 0){

}else{

if($product_sn1 !=''){
?>

<tr>
<td style="width:5%;">
<input type='checkbox' name = "clear_br[<?php echo $i; ?>]" value="1" id = "clear_br[<?php echo $i; ?>]" >
</td>	
<td style="width:10%;">
<input type='hidden' name = "product_code[<?php echo $i; ?>]"  id = "product_code[<?php echo $i; ?>]" class="w3-input" value = "<?php echo $objResult1["access_code"]; ?>"  size="7" /> 
<input type='text'  value = "<?php echo $objResult1["access_code"]; ?>"  class="w3-input" />	
<input type='hidden' name = "product_id[<?php echo $i; ?>]" value = "<?php echo $objResult1["product_id"]; ?>" id = "product_id[<?php echo $i; ?>]" class="w3-input" />
<input type='hidden' name = "id[<?php echo $i; ?>]" value = "<?php echo $i; ?>" id = "id[<?php echo $i; ?>]" class="w3-input" />


</td>
<td  style="width:8%;">
<textarea  name = "product_name[<?php echo $i; ?>]"  id = "product_name[<?php echo $i; ?>]"   rows="2" class="w3-input" readonly><?php echo $objResult1["sol_name"]; ?></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name[<?php echo $i; ?>]"  id = "unit_name[<?php echo $i; ?>]" value = "<?php echo $objResult1["unit_name"]; ?>" class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count[<?php echo $i; ?>]" id = "sale_count[<?php echo $i; ?>]" value = "<?php echo '1'; ?>" class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price[<?php echo $i; ?>]"  id = "product_price[<?php echo $i; ?>]" value="<?php  $price=$objResult1["price"]; echo number_format( $price,2)."";?>" class="w3-input" size="7" style="color:black;text-align:right" />
</td >

<td style="width:8%;"><input type='text' name = "sum_amount[<?php echo $i; ?>]"  id = "sum_amount[<?php echo $i; ?>]" value="<?php  $sum_amount=$objResult1["amount"]; echo number_format( $sum_amount,2)."";?>"  class="w3-input" size="7" style="color:black;text-align:right" readonly/>
</td>

<td style="width:10%;">

<textarea name = "sale_remark[<?php echo $i; ?>]"  id = "sale_remark[<?php echo $i; ?>]" class="w3-input" ><?php echo $objResult1["sale_remark"];?></textarea>

</td>

	<td style="width:10%;">

<textarea name = "sn[<?php echo $i; ?>]"  id = "sn[<?php echo $i; ?>]" class="w3-input" ><?php echo $objResult1["sn"];?></textarea>

</td>
	
<!--td style="width:10%;" >
	<input type='checkbox' name = "clear_br1"  id = "clear_br1" value='1' class="w3-input"  >
	<input type='text' style="width:100%;" name = "clear_ivno1"  id = "clear_ivno1"  class="w3-input"   >
	</td-->
	

</tr>

<?php
}
}
$i++;	
}
}

else if($objResult1["sn"]==''){

$sql3 = "SELECT sum(sale_count) as count3   FROM hos__subspr where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult["iv_no"]."' and status_spr='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM hos__subso where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult["iv_no"]."' and status_so='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$objResult["iv_no"]."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
$rs41 = mysqli_fetch_array($qry41);

$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '".$rs41['ref_id']."' and product_id = '".$objResult1['product_id']."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM hos__subsmp where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and br_no ='".$objResult["iv_no"]."' and status_smp ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 =  $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];

	
$count2 = $objResult1["count"] - ($count3+$count4+$count5+$count13);


	
if($count2=='0' or $count2<'0'){

}else{

	?>



<tr>
<td style="width:5%;">
<input type='checkbox' name = "clear_br[<?php echo $objResult1["id"];?>]" value="1" id = "clear_br[<?php echo $objResult1["id"];?>]" >
</td>	
<td style="width:10%;">
<input type='text'  value = "<?php echo $objResult1["access_code"]; ?>"  class="w3-input" />	
<input type='hidden' name = "product_code[<?php echo $objResult1["id"];?>]"  id = "product_code[<?php echo $objResult1["id"];?>]" class="w3-input" value = "<?php echo $objResult1["access_code"]; ?>"  size="7" /> 
<input type='hidden' name = "product_id[<?php echo $objResult1["id"];?>]" value = "<?php echo $objResult1["product_id"]; ?>" id = "product_id[<?php echo $objResult1["id"];?>]" class="w3-input" />
<input type='hidden' name = "id[<?php echo $objResult1["id"];?>]" value = "<?php echo $objResult1["id"]; ?>" id = "id[<?php echo $objResult1["id"];?>]" class="w3-input" />


</td>
<td  style="width:8%;">
<textarea  name = "product_name[<?php echo $objResult1["id"];?>]"  id = "product_name[<?php echo $objResult1["id"];?>]"   rows="2" class="w3-input" readonly><?php echo $objResult1["sol_name"]; ?></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name[<?php echo $objResult1["id"];?>]"  id = "unit_name[<?php echo $objResult1["id"];?>]" value = "<?php echo $objResult1["unit_name"]; ?>" class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count[<?php echo $objResult1["id"];?>]" id = "sale_count[<?php echo $objResult1["id"];?>]" value = "<?php echo $count2; ?>" class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price[<?php echo $objResult1["id"];?>]"  id = "product_price[<?php echo $objResult1["id"];?>]" value="<?php  $price=$objResult1["price"]; echo number_format( $price,2)."";?>" class="w3-input" size="7" style="color:black;text-align:right" />
</td >

<td style="width:8%;"><input type='text' name = "sum_amount[<?php echo $objResult1["id"];?>]"  id = "sum_amount[<?php echo $objResult1["id"];?>]" value="<?php  $sum_amount=$objResult1["amount"]; echo number_format( $sum_amount,2)."";?>"  class="w3-input" size="7" style="color:black;text-align:right" readonly/>
</td>

<td style="width:10%;">

<textarea name = "sale_remark[<?php echo $objResult1["id"];?>]"  id = "sale_remark[<?php echo $objResult1["id"];?>]" class="w3-input" ><?php echo $objResult1["sale_remark"];?></textarea>

</td>
	
<td style="width:10%;">

<textarea name = "sn[<?php echo $objResult1["id"];?>]"  id = "sn[<?php echo $objResult1["id"];?>]" class="w3-input" ><?php echo $objResult1["sn"];?></textarea>

</td>
</tr>

<?php }
}
?>
<?php } ?>

</table>

</div>



	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
	</div><br>
	</div>
	</form>
</div>
<div id="cr_bar"><?php include "foot.php"; ?></div>

		