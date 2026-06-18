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

<div class="w3-container w3-white">
<div class="w3-panel w3-light-grey"><h3>ใบเบิกเครื่องและอะไหล่</h3></p>	
<h5>(Device and Spare Part Request)</h5>
</div>
<form action="register_engspr1.php" method="post" name="frmMain" enctype="multipart/form-data"  onSubmit="JavaScript:return fncSubmit();" >
		

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

$wo_no = $_GET["wo_no"];
$wo_no1 = substr($wo_no,0,2);

 if($_GET["company"]=='1'){ 

if($wo_no1=="IM"){

$sql1 = "SELECT product_sn,service_order_no,equipment_repaire1,per_no,symptoms_1,symptoms_2,symptoms_3 FROM tb_service_orderim where service_order_no = '".$_GET["wo_no"]."'";
$qry1 = mysqli_query($service,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);


}else{
$sql1 = "SELECT product_sn,service_order_no,equipment_repaire1,per_no,symptoms_1,symptoms_2,symptoms_3 FROM tb_service_order where service_order_no = '".$_GET["wo_no"]."'";
$qry1 = mysqli_query($service,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

}

$sql3 = "SELECT install_cus_title,install_cus_name,install_cus_address,install_cus_district_amphur,install_cus_province,install_cus_postal_code,product_sn,buy_date,out_insurance_date FROM tb_installation_data where product_sn = '".$rs1["product_sn"]."'";
$qry3 = mysqli_query($service,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);

$sql4 = "SELECT date_receive FROM tb_products_in_stock where product_sn = '".$rs1["product_sn"]."'";
$qry4 = mysqli_query($service,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_assoc($qry4);


 }else{

if($wo_no1=="IM"){

$sql1 = "SELECT product_sn,service_order_no,equipment_repaire1,per_no,symptoms_1,symptoms_2,symptoms_3 FROM tb_service_orderim where service_order_no = '".$_GET["wo_no"]."'";
$qry1 = mysqli_query($servicenb,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);


}else{
$sql1 = "SELECT product_sn,service_order_no,equipment_repaire1,per_no,symptoms_1,symptoms_2,symptoms_3 FROM tb_service_order where service_order_no = '".$_GET["wo_no"]."'";
$qry1 = mysqli_query($servicenb,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

}


$sql3 = "SELECT install_cus_title,install_cus_name,install_cus_address,install_cus_district_amphur,install_cus_province,install_cus_postal_code,product_sn,install_date,out_insurance_date FROM tb_installation_data where product_sn = '".$rs1["product_sn"]."'";
$qry3 = mysqli_query($servicenb,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);


$sql4 = "SELECT date_receive FROM tb_products_in_stock where product_sn = '".$rs1["product_sn"]."'";
$qry4 = mysqli_query($servicenb,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_assoc($qry4);



 }



$install_cus_title = $rs3["install_cus_title"];
$install_cus_name =$rs3["install_cus_name"];
$customer = "$install_cus_title $install_cus_name";

$install_cus_address = $rs3["install_cus_address"];
$install_cus_district_amphur = $rs3["install_cus_district_amphur"];
$install_cus_province = $rs3["install_cus_province"];
$install_cus_postal_code =$rs3["install_cus_postal_code"];
$address = "$install_cus_address $install_cus_district_amphur $install_cus_province $install_cus_postal_code";

		
$sql2 = "SELECT wo_no FROM hos__spr where wo_no='".$_GET["wo_no"]."'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($qry2);
$rs2 = mysqli_fetch_assoc($qry2);
		
if($Num_Rows2 > 0){

echo "<script language=\"JavaScript\">";
echo "alert('ได้ทำการบันทึกเลขใบงานบริการนี้ไปแล้วค่ะ');window.location='status_spr.php';";
echo "</script>";
exit();

}
		
		

		
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
				<?php if($_GET["company"]=='1'){ ?>
			<input type="radio" name="type_company"  checked ='checked' value="1">&nbsp;AWL
            <input type="radio" name="type_company"  value="2" >&nbsp;NBM
				<?php }else if($_GET["company"]=='2'){  ?>
				<input type="radio" name="type_company"   value="1">&nbsp;AWL
            <input type="radio" name="type_company" checked ='checked' value="2" >&nbsp;NBM
				<?php } ?>
				</div>


<div class="w3-bar w3-margin-bottom">
			W/O No. : 
			<input type="text" name="wo_no" id="wo_no" value="<?php echo $rs1["service_order_no"]; ?>" class="w3-input" style="width:90%;"  required>
</div>

		<div class="w3-bar w3-margin-bottom">
			วันที่  :<input type="date" name="spr_date" value = "<?php echo $today; ?>" style="width:30%;" class="w3-input"  required>
			
</div>
			<div class="w3-bar w3-margin-bottom">
ที่อยุ่ :<textarea name="address" id="address" class="w3-input" style="width:90%;"  required><?php echo $address; ?></textarea>
</div>
<div class="w3-bar w3-margin-bottom">
			Equipment : 
			<input type="text" name="equipment" id="equipment" value = "<?php echo $rs1["equipment_repaire1"]; ?>" class="w3-input" style="width:90%;"  required>
</div>
<div class="w3-bar w3-margin-bottom">
			Engineer : 
			<input type="text" name="engineer" id="engineer" class="w3-input" value = "<?php echo $_SESSION['name']; ?>  <?php echo $_SESSION['surname']; ?>" style="width:90%;"  required>
			<input type="hidden" name="sale_code" id="sale_code" value="<?php echo $_SESSION['code']; ?>" class="w3-input" style="width:90%;"  required>
</div>

<div class="w3-bar w3-margin-bottom">
			วันที่ หมดอายุ :<input type="date" name="date_exp" value = "<?php echo $rs3["out_insurance_date"]; ?>" style="width:30%;" class="w3-input"  required>
			
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
			<input type="text" name="customer" id="customer" value="<?php echo $customer; ?>" class="w3-input" style="width:90%;"  required>
</div>

<div class="w3-bar w3-margin-bottom">
			SN : 
			<input type="text" name="sn_num" id="sn_num" class="w3-input" value="<?php echo $rs3["product_sn"]; ?>" style="width:90%;"  required>
</div>


			
		<div class="w3-bar w3-margin-bottom">
			วันที่ ติดตั้ง :<input type="date" name="date_imstall" value="<?php echo $rs3["install_date"]; ?>" style="width:30%;" class="w3-input"  required>
	</div>	
	<div class="w3-bar w3-margin-bottom">
			วันที่ของเข้า :<input type="date" name="date_receive" value="<?php echo $rs4["date_receive"]; ?>" style="width:30%;" class="w3-input"  >
	</div>	

<div class="w3-bar w3-margin-bottom">
			PER : 
			<input type="text" name="per_no" id="per_no" value="<?php echo $rs1["per_no"]; ?>" class="w3-input" style="width:90%;"  >
</div>

<div class="w3-bar w3-margin-bottom">
			<input type="checkbox" name="clear_brnp" value ="1" > Clear ใบยืมกระดาษต่อเนื่องเลขที่ :<input type="text" name="brnp_no"  style="width:90%;" class="w3-input"  >
			
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


<?php
	 if($_GET["company"]=='1'){ 
		include ('detail_engspr.php');
	 }else if($_GET["company"]=='2'){
	include ('detail_engsprnb.php');	 
	 }
		?>

</div>



	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
	</div><br>
	</div>
	</form>
</div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	

		