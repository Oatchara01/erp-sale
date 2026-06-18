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

<?php
			include('dbconnect.php');

			$qfirst = "select * from hos__spr where ref_id = '".$_GET["ref_id"]."'";
			$first = mysqli_query($conn,$qfirst);
			$ffirst = mysqli_fetch_array($first);

			$strSQL1 = "SELECT * FROM  (hos__subspr LEFT JOIN tb_product ON hos__subspr.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";

		$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
		$Num_Rows1 = mysqli_num_rows($objQuery1);
		
date_default_timezone_set("Asia/Bangkok");


		?>
<form action="rejected_sprcm.php" method="POST" name="frmMain" enctype="multipart/form-data"  onSubmit="JavaScript:return fncSubmit();" >

<div class="w3-white w3-container">
	<div class="w3-panel w3-light-grey">
	<div class="w3-half 1">
	<h3>ใบเบิกเครื่องและอะไหล่</h3></p>	
	<h5>(Device and Spare Part Request)</h5>
	</div>
<div class="w3-half 1">

<input type="submit" name="submit" value="Rejected" class="w3-button w3-red w3-right" >
	<!--a href="rejected_sprcm.php?ref_id=<?php echo $_GET["ref_id"];?>&sale_code=<?php echo $_SESSION["code"]; ?>" target="_blank" class="w3-button w3-red w3-right"><font color="black">Rejected</font></a-->&nbsp;&nbsp;
	
<a href="approve_sprcm.php?ref_id=<?php echo $_GET["ref_id"];?>&sale_code=<?php echo $_SESSION["code"]; ?>" target="_blank" class="w3-button w3-green w3-right"><font color="black">Approve</font></a>



	&nbsp;&nbsp; 
<a href="report_spr.php?ref_id=<?php echo $_GET["ref_id"];?>" target="_blank" class="w3-button w3-yellow w3-right"><font color="black">Print Preview</font></a>
	</div>
	</div>
			

	<div class="w3-bar">
	
	
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $ffirst["ref_id"]; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $ffirst["ref_id"]; ?>">
	</div>

	<div class="w3-bar w3-padding-small"></div><!-- bar -->
		<div class="w3-half 1">
			<div class="w3-bar w3-margin-bottom">
			<?php if($ffirst["type_company"]=='1'){ ?>
			<input type="radio" name="type_company"  checked ='checked' value="1">&nbsp;PTL
            <input type="radio" name="type_company"  value="2" >&nbsp;NBM
			<?php }else if($ffirst["type_company"]=='1'){ ?>
			<input type="radio" name="type_company"   value="1">&nbsp;PTL
            <input type="radio" name="type_company" checked ='checked' value="2" >&nbsp;NBM
			<?php } ?>
				</div>


<div class="w3-bar w3-margin-bottom">
			W/O No. : 
			<input type="text" name="wo_no" id="wo_no" class="w3-input" value="<?php echo $ffirst["wo_no"]; ?>" style="width:90%;"  required>
</div>

		<div class="w3-bar w3-margin-bottom">
			วันที่  :<input type="date" name="spr_date" value="<?php echo $ffirst["spr_date"]; ?>" style="width:30%;" class="w3-input"  required>
			
</div>
			<div class="w3-bar w3-margin-bottom">
ที่อยุ่ :<textarea name="address" id="address" class="w3-input" style="width:90%;"  required><?php echo $ffirst["address"]; ?></textarea>
</div>
<div class="w3-bar w3-margin-bottom">
			Equipment : 
			<input type="text" name="equipment" id="equipment" class="w3-input" style="width:90%;" value="<?php echo $ffirst["equipment"]; ?>" required>
</div>
<div class="w3-bar w3-margin-bottom">
			Engineer : 
			<input type="text" name="engineer" id="engineer" class="w3-input" style="width:90%;" value="<?php echo $ffirst["engineer"]; ?>" required>
			<input type="hidden" name="sale_code" id="sale_code" value="EN" class="w3-input" style="width:90%;"  required>
</div>

<div class="w3-bar w3-margin-bottom">
			วันที่ หมดอายุ :<input type="date" name="date_exp"  style="width:30%;" class="w3-input"  value="<?php echo $ffirst["date_exp"]; ?>" required>
			
</div>		

<div class="w3-bar w3-margin-bottom">
<?php if($ffirst["clear_brn"]=='1'){ ?>
			<input type="checkbox" name="clear_brn" checked="checked" value ="1" >
			<?php }else{ ?>
			<input type="checkbox" name="clear_brn" value ="1" >
			<?php } ?>
			Clear ใบยืมติดเล่มเลขที่ :
			
			<input type="text" name="brn_no"  style="width:90%;" value="<?php echo $ffirst["brn_no"]; ?>" class="w3-input"  >
			
</div>	
			
		<div class="w3-bar w3-margin-bottom">
			<font color ="red">หมายเหตุการยกเลิก : </font>
			<textarea name="reject_remark" id="reject_remark" rows="2" class="w3-input" style="width:90%;"  required></textarea>

</div>	

</div>



<div class="w3-half 1">

<div class="w3-bar w3-margin-bottom">
			SPR : 
			<input type="text" name="spr_no" id="spr_no" value="<?php echo $ffirst["spr_no"]; ?>" class="w3-input" style="width:90%;"  readonly>
</div>
			
<div class="w3-bar w3-margin-bottom">
			ชื่อลูกค้า 
			<input type="text" name="customer" id="customer" class="w3-input" value="<?php echo $ffirst["customer"]; ?>" style="width:90%;"  required>
</div>

<div class="w3-bar w3-margin-bottom">
			SN : 
			<input type="text" name="sn_num" id="sn_num" class="w3-input" value="<?php echo $ffirst["sn_num"]; ?>" style="width:90%;"  required>
</div>


			
		<div class="w3-bar w3-margin-bottom">
			วันที่ ติดตั้ง :<input type="date" name="date_imstall"  style="width:30%;" class="w3-input" value="<?php echo $ffirst["date_imstall"]; ?>" required>
			
</div>	

<div class="w3-bar w3-margin-bottom">
			PER : 
			<input type="text" name="per_no" id="per_no" class="w3-input" style="width:90%;" value="<?php echo $ffirst["per_no"]; ?>" >
</div>

<div class="w3-bar w3-margin-bottom">
	
	<?php if($ffirst["clear_brnp"]=='1'){ ?>
			<input type="checkbox" name="clear_brnp" checked="checked" value ="1" > 
			<?php }else{ ?>
			<input type="checkbox" name="clear_brnp" value ="1" > 
			<?php } ?>

			Clear ใบยืมกระดาษต่อเนื่องเลขที่ :<input type="text" name="brnp_no" value="<?php echo $ffirst["brnp_no"]; ?>" style="width:90%;" class="w3-input"  >
			
</div>	
<div class="w3-bar w3-margin-bottom">
<?php if($ffirst["clear_epe"]=='1'){ ?>
			<input type="checkbox" name="clear_epe" checked="checked" value ="1" >
			<?php }else{ ?>
<input type="checkbox" name="clear_epe" value ="1" >
			<?php } ?>
			
			ของเสียส่งไปต่างประเทศตาม EPE :<input type="text" name="epe_no" value="<?php echo $ffirst["epe_no"]; ?>" style="width:90%;" class="w3-input"  >
		</div>	

<div class="w3-bar w3-margin-bottom">
<?php if($ffirst["pro_ckk"]=='1'){ ?>
			<input type="radio" name="pro_ckk" checked='checked' value = '1' > อะไหล่คืนใช้งานไม่ได้
			<input type="radio" name="pro_ckk" value = '2' >  อะไหล่คืนใช้งานได้ แต่สภาพไม่สมบูรณ์ (โปรดกรอกรายละเอียด)

<?php }else if($ffirst["pro_ckk"]=='2'){ ?>

	<input type="radio" name="pro_ckk" value = '1' > อะไหล่คืนใช้งานไม่ได้
	<input type="radio" name="pro_ckk" checked='checked' value = '2' >  อะไหล่คืนใช้งานได้ แต่สภาพไม่สมบูรณ์ (โปรดกรอกรายละเอียด)

<?php }else{ ?>
<input type="radio" name="pro_ckk" value = '1' > อะไหล่คืนใช้งานไม่ได้
<input type="radio" name="pro_ckk" value = '2' >  อะไหล่คืนใช้งานได้ แต่สภาพไม่สมบูรณ์ (โปรดกรอกรายละเอียด)
	<?php } ?>

</div>	

<div class="w3-bar w3-margin-bottom">
			อาการเสีย : 
			<input type="text" name="pro_des" id="pro_des" value="<?php echo $ffirst["pro_des"]; ?>" class="w3-input" style="width:90%;"  >
</div>

</div>
		
		

	</p>
	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
</div>


<div id="pd" class="w3-container city1">

<table width="100%" border="0" class="w3-table">

    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>ราคาต่อหน่วย</th>
    <th>ยอดรวม</th>
	<th>หมายเหตุ</th>
	<th>เคลียร์ยืม</th>

<tbody>

<?php

$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
?>

<tr>
<td style="width:10%;">


<input type='text' name = "product_code[]<?php echo $objResult1["id"]; ?>"  id = "product_code[]<?php echo $objResult1["id"]; ?>" class="w3-input" value = "<?php echo $objResult1["access_code"]; ?>"  size="7" /> 
<input type='hidden' name = "product_id[]<?php echo $objResult1["id"]; ?>" value = "<?php echo $objResult1["product_id"]; ?>" id = "product_id[]<?php echo $objResult1["id"]; ?>" class="w3-input" />
<input type='hidden' name = "id[]<?php echo $objResult1["id"]; ?>" value = "<?php echo $objResult1["id"]; ?>" id = "id[]<?php echo $objResult1["id"]; ?>" class="w3-input" />


</td>
<td  style="width:8%;">
<textarea  name = "product_name[]<?php echo $objResult1["id"]; ?>"  id = "product_name[]<?php echo $objResult1["id"]; ?>"   rows="2" class="w3-input" readonly><?php echo $objResult1["sol_name"]; ?></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name[]<?php echo $objResult1["id"]; ?>"  id = "unit_name[]<?php echo $objResult1["id"]; ?>" value = "<?php echo $objResult1["unit_name"]; ?>" class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count[]<?php echo $objResult1["id"]; ?>" id = "sale_count[]<?php echo $objResult1["id"]; ?>" value = "<?php echo $objResult1["sale_count"]; ?>" class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price[]<?php echo $objResult1["id"]; ?>"  id = "product_price[]<?php echo $objResult1["id"]; ?>" value="<?php  $price=$objResult1["unit_price"]; echo number_format( $price,2)."";?>" class="w3-input" size="7" style="color:black;text-align:right" />
</td >

<td style="width:8%;"><input type='text' name = "sum_amount[]<?php echo $objResult1["id"]; ?>"  id = "sum_amount[]<?php echo $objResult1["id"]; ?>" value="<?php  $sum_amount=$objResult1["sum_amount"]; echo number_format( $sum_amount,2)."";?>"  class="w3-input" size="7" style="color:black;text-align:right" readonly/>
</td>

<td style="width:10%;">
<textarea name = "sale_remark[]<?php echo $objResult1["id"];?>"  id = "sale_remark[]<?php echo $objResult1["id"];?>" class="w3-input" ><?php echo $objResult1["sale_remark"];?></textarea>
</td>
<td style="width:8%;"><input type='text' name = "clear_br[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["clear_br"];?>" id = "clear_br[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/>
	<input type='text' name = "clear_ivno[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["clear_ivno"];?>" id = "clear_ivno[]<?php echo $objResult1["id"];?>" placeholder="เลขที่ใบยืม"  class="w3-input"  />
	</td>	

</tr>
<?php } ?>

</table>



</div>



	
	</div>
	</form>
</div>
<div id="cr_bar"><?php include "foot.php"; ?></div>


		