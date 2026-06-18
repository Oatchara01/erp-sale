<?php include ("head.php"); ?>



<style type="text/css">

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 8px 10px;
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
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #FF0000; }
-->
</style>

<body>
<?php

$sql1 = "select * from hos__receive order by id_auto desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 



$ref_id =$_GET["ref_id"];

$strSQL = "SELECT *   FROM hos__consig where ref_id ='".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_assoc($objQuery);


	 ?>


	<!--action="register_office1.php"-->
	<form action='rister_clearbrpn_st1.php' method="post" name="frmMain" enctype="multipart/form-data"  onSubmit="JavaScript:return fncSubmit();">
		
		<?php /*<script language="javascript"> onSubmit="JavaScript:return fncSubmit();"
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
	
	if(document.frmMain.receive_ckk.value == "2" and document.frmMain.receive_name.value == ""){
			
		alert('กรุณาใส่ชื่อบุคคลที่ฝาก');
		document.frmMain.receive_name.focus();
		return false;
		}
		
	document.frmMain.submit();
}

</script>*/ ?>
		
		<div class="w3-white w3-container w3-padding-large">
			<div class="w3-panel w3-light-gray"><h4>Register Sale Order</h4></div>

<div class="w3-bar">
		
	<?php if ($objResult['company']=='1'){
		?>
<input type="radio" checked='checked' name="type_company" value = "3">&nbsp; AWL
<input type="radio" name="type_company"  value="4" >&nbsp;NBM
<?php }else{ ?>

<input type="radio"  name="type_company" value = "3">&nbsp; AWL
<input type="radio" name="type_company" checked='checked' value="4" >&nbsp;NBM

			<?php } ?>

		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $fetch1['ref_id']+1; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $fetch1['ref_id']+1; ?>">
	<input type="hidden" name="ref_id_br" id='ref_id_br' class="w3-input" value="<?php echo $objResult['ref_id_br']; ?>">
	</div>

</p>
<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


?>
<?php if ($objResult['receive_ckk']=='1'){
		?>
<input type="radio" checked='checked' name="receive_ckk" value = "1" required>&nbsp; คืนสินค้าด้วยตัวเอง
<input type="radio" name="receive_ckk"  value="2" required>&nbsp;ฝากบุคคลอื่นคืน คุณ &nbsp;
<?php }else if($objResult['receive_ckk']=='2'){ ?>

<input type="radio"  name="receive_ckk" value = "1" required>&nbsp; คืนสินค้าด้วยตัวเอง
<input type="radio" name="receive_ckk" checked='checked' value="2" required>&nbsp;ฝากบุคคลอื่นคืน คุณ &nbsp;

			<?php }else{ ?>

<input type="radio"  name="receive_ckk" value = "1" required>&nbsp; คืนสินค้าด้วยตัวเอง
<input type="radio" name="receive_ckk"  value="2" required>&nbsp;ฝากบุคคลอื่นคืน คุณ &nbsp;

			<?php } ?>
  : &nbsp;<input type="text" name="receive_name" class="button4" style="width:15%;" > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ช่วงวันที่ :&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="receive_between" value = '<?php echo $objResult['receive_between'];?>' class="button4" style="width:15%;" 	>
		&nbsp;&nbsp;&nbsp;ช่วงเวลา :&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="time_between" value = '<?php echo $objResult['time_between'];?>' class="button4" style="width:15%;" 	>
</p>
		วันที่ : 
<input type="date" name = "date_receive" id="date_receive" value="<?php echo $today; ?>" class = "button4"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

เลขที่ใบยืม :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="iv_no" value = '<?php echo $objResult['iv_no'];?>' class="button4" style="width:30%;" 	></p>
</p>

ชื่อลูกค้า  : &nbsp;<input type="text" name="customer_name" class="button4" value = '<?php echo $objResult['customer'];?>' style="width:30%;" required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	

ที่อยู่ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <textarea rows="2" name="customer_address" class="button4" style="width:30%"  ><?php echo $objResult["address"]; ?></textarea>
			
			



</p>

เขตการขาย : &nbsp;<input type="text" name="sale_code" class="button4" style="width:30%;" value = '<?php echo $objResult['sale_code'];?>' required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				
ชื่อผู้ยืม :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="sale_name" value = '<?php echo $objResult['add_by']; ?>' class="button4" style="width:30%;" 	></p>

	หมายเหตุ :</p> <textarea rows="2" name="remark_st" class="button4" style="width:30%"  ></textarea></p>


<div class="w3-bar w3-light-grey w3-border">
 <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>

</div>

<div id="pd" class="w3-container city1" >


	<?php //include ('product_rister_st.php') ?>

<table width="100%" border="0" class="w3-table">
	<font color='red'>**กรุณาเลือกสินค้าที่ต้องการเคลียร์เท่านั้น !!!</font>
<thead>
	<th>เลือกสินค้าคืน</th>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>หมายเลขเครื่อง</th>
    <th>หมายเหตุ</th>

</thead>
<tbody>
<?php



$strSQL1 = "SELECT * FROM  (hos__subconsig LEFT JOIN tb_product ON hos__subconsig.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' ";
//echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


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

$sql2 = "SELECT sn  FROM   hos__subsmp   where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and br_no ='".$objResult["iv_no"]."' and sn ='".$product_sn1."'  and status_smp ='Approve'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows19 = mysqli_num_rows($qry2);
	
$sql5 = "SELECT sn  FROM   hos__subspr   where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and clear_ivno ='".$objResult["iv_no"]."' and sn ='".$product_sn1."'  and status_spr ='Approve'";
$qry5 = mysqli_query($conn,$sql5) or die(mysqli_error());
$Num_Rows20 = mysqli_num_rows($qry5);


if($Num_Rows2 > 0){

}else if ($Num_Rows3 > 0){

}else if ($Num_Rows19 > 0){

}else if ($Num_Rows20 > 0){

}else{

if($product_sn1 !=''){

$q = $objResult1["id"];	
$o = "$q$i";		
	
?>
<tr>
<td style="width:5%;">
<input type='checkbox' name = "clear_br[<?php echo $o;?>]" checked='checked' value="1" id = "clear_br[<?php echo $o;?>]" >
</td>
	
	<td style="width:10%;">
<input type="text"  class="w3-input w3-center" size="1%" value="<?php echo $objResult1['access_code']; ?>">
<input type="hidden" name="id[<?php echo $o;?>]" class="w3-input w3-center" size="1%" value="<?php echo $o; ?>">
<input type="hidden" name="product_id[<?php echo $o;?>]" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

<input type='hidden' name ="product_code[<?php echo $o;?>]" value="<?php echo $objResult1["access_code"];?>" id ="product_code[<?php echo $o;?>]"  size="7"  class="button4"></td>

<td  style="width:12%;">
<textarea name = "product_name[<?php echo $o;?>]"   id = "product_name[<?php echo $o;?>]"  class="w3-input" readonly><?php echo $objResult1["sol_name"];  echo $objResult1["sale_remark"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[<?php echo $o;?>]" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[<?php echo $o;?>]"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "sale_count[<?php echo $o;?>]" value="<?php echo "1";?>" id = "sale_count[<?php echo $o;?>]"  class="w3-input" style="color:black;text-align:center"    /></td>


<td style="width:10%;">

<textarea name = "sn[<?php echo $o;?>]"  id = "sn[<?php echo $o;?>]"  class="w3-input" ><?php echo $product_sn1;?></textarea>
</td>


<td style="width:10%;">
<input type='text' name = "sale_remarkk[<?php echo $o;?>]"  id = "sale_remarkk[<?php echo $o;?>]" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input" />
</td>
</tr>

<?php
}
}
	
$i++;	
}
}

else if($objResult1["sn"]=='' ){

	$sql3 = "SELECT sum(sale_count) as count3   FROM   hos__subspr   where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult["iv_no"]."'  and status_spr ='Approve'";
	
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso   where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult["iv_no"]."'  and status_so ='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql4 = "SELECT sum(count) as count4   FROM  (hos__receive LEFT JOIN hos__subreceive ON hos__receive.ref_id=hos__subreceive.ref_idd)  where iv_no = '".$objResult["iv_no"]."' and product_id = '".$objResult1['product_id']."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);


$sql12 = "SELECT sum(sale_count) as count3   FROM   hos__subsmp   where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and br_no ='".$objResult["iv_no"]."'  and status_smp ='Approve'";
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
<input type='checkbox' name = "clear_br[<?php echo $objResult1["id"];?>]" checked='checked' value="1" id = "clear_br[<?php echo $objResult1["id"];?>]" >
			
			</td>
	<td style="width:10%;">

<input type="hidden" name="id[<?php echo $objResult1["id"];?>]" class="w3-input w3-center" size="1%" value="<?php echo $objResult1["id"]; ?>">
<input type="hidden" name="product_id[<?php echo $objResult1["id"];?>]" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">
		
		<input type="text"  class="w3-input w3-center" size="1%" value="<?php echo $objResult1['access_code']; ?>">

<input type='hidden' name ="product_code[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["access_code"];?>" id ="product_code[<?php echo $objResult1["id"];?>]"  size="7"  class="button4" ></td>

<td  style="width:12%;">
<textarea name = "product_name[<?php echo $objResult1["id"];?>]"   id = "product_name[<?php echo $objResult1["id"];?>]"  class="w3-input" readonly><?php echo $objResult1["sol_name"]; echo $objResult1["sale_remark"]; ?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[<?php echo $objResult1["id"];?>]"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "sale_count[<?php echo $objResult1["id"];?>]" value="<?php echo $count2;?>" id = "sale_count[<?php echo $objResult1["id"];?>]"  class="w3-input" style="color:black;text-align:center"    /></td>

<td style="width:10%;">

<textarea name = "sn[<?php echo $objResult1["id"];?>]"  id = "sn[<?php echo $objResult1["id"];?>]"  class="w3-input" ><?php echo $objResult1["sn"];?></textarea>
</td>


<td style="width:10%;">
<input type='text' name = "sale_remarkk[<?php echo $objResult1["id"];?>]"  id = "sale_remarkk[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input" />
</td>
</tr>
<?php }
}
?>




<?php
	
	

}


?>
</tbody>
</table>

</div>



<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>


</form></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>
  
  <!--/div-->

  
 





<script>
$('#more').click(function() {
  if($(this).is(":checked")){
   $("#more-2").show();
  }
  else{
   $("#more-2").hide();
  }
});
</script>