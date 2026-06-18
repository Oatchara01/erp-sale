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


if($maxId1 == $year)
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


$sql1 = "SELECT MAX(spr) AS spr FROM hos__spr where year='".$year_1."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);
		
$spr = $rs1["spr"]+1;

		
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
			<input type="radio" name="type_company"  checked ='checked' value="1">&nbsp;AWL
            
				</div>


<div class="w3-bar w3-margin-bottom">
			W/O No. : 
			<input type="text" name="wo_no" id="wo_no" class="w3-input" style="width:90%;"  required>
</div>

		<div class="w3-bar w3-margin-bottom">
			วันที่  :<input type="date" name="spr_date" value = "<?php echo $today; ?>" style="width:30%;" class="w3-input"  required>
			
</div>
			<div class="w3-bar w3-margin-bottom">
ที่อยุ่ :<textarea name="address" id="address" class="w3-input" style="width:90%;"  required></textarea>
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
			<input type="text" name="spr_no" id="spr_no" value = "<?php echo "$spr/$year_1"; ?>" class="w3-input" style="width:90%;"  readonly>
</div>
			
<div class="w3-bar w3-margin-bottom">
			ชื่อลูกค้า 
			<input type="text" name="customer" id="customer" class="w3-input" style="width:90%;"  required>
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
<?php include ('detail_engspr.php');  ?>
</div> 



	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
	</div><br>
	</div>
	</form>
</div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

		