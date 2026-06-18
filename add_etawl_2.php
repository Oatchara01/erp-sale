<?php 


include('head.php');

 
 
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

<div class="w3-panel w3-light-gray"><h4>ADD : เลขที่เอกสาร ET</h4></div>

<div class=" w3-container w3-half">

วันที่ออกบิล
<input type = 'date' name="date_iv" class="w3-input" style="width:30%;">

</div>

<div class=" w3-container w3-half">

หมายเหตุ
<input type = 'text' name="description" class="w3-input" style="width:80%;">

</div>

<br>
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='add_etawl1.php'; submit()">
</center>

</p>


<div class="w3-container w3-third">

  เดือน
<select name="month_code" id="month_code" style="width:90%" class="w3-input" >
<option value="">**Please Select**</option>

<?php

$strSQL45 = "SELECT * FROM tb_month  order by month_id  ASC";

$objQuery45 = mysqli_query($conn,$strSQL45);
while($objResult45 = mysqli_fetch_array($objQuery45))
{
if($_GET["month_code"] == $objResult45["month_code"]){
$sel = "selected";
} else {
$sel = "";
}
?>
<option value="<?php echo $objResult45["month_code"];?>" <?php echo $sel;?>><?php echo $objResult45["month_name"];?></option>
<?php
}
?>
</select>

</div>

<div class="w3-container w3-third">

  ปี
<select name="year_no" id="year_no" style="width:90%" class="w3-input" >
<option value="">**Please Select**</option>

<?php

$strSQL56 = "SELECT * FROM tb_year where year_code!='' order by id_year  DESC";
$objQuery56 = mysqli_query($conn,$strSQL56);
while($objResult56 = mysqli_fetch_array($objQuery56))
{
if($_GET["year_code"] == $objResult56["year_code"]){
$sel = "selected";
} else {
$sel = "";
}
?>
<option value="<?php echo $objResult56["year_code"];?>" <?php echo $sel;?>><?php echo $objResult56["year_name"];?></option>
<?php
}
?>
</select>


</div>
		<div class="w3-container w3-third">
		<input type="submit" class="w3-button w3-teal" value="Search"></div>
		</div>

<?php
	if($_GET['year_no']!=''){
$year_no = isset($_GET['year_no']) ? $_GET['year_no'] : '';
	}else{
$year_no = 	date("y")+43;	
	}
	
if($_GET['month_code']!=''){
$month_code = isset($_GET['month_code']) ? $_GET['month_code'] : '';
	}else{
$month_code = date('m');		
	}	

	
include "dbconnect.php";
	
$strSQL1 = "SELECT * FROM tb_et_awl WHERE year_no='".$year_no."' and mount_no='".$month_code."' LIMIT 100 OFFSET 1200";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);	
	
$strSQL2 = "SELECT * FROM tb_et_awl WHERE year_no='".$year_no."' and mount_no='".$month_code."' LIMIT 100 OFFSET 1300";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);	
	
	
$strSQL3 = "SELECT * FROM tb_et_awl WHERE year_no='".$year_no."' and mount_no='".$month_code."' LIMIT 100  OFFSET 1400";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);	
	
	
$strSQL4 = "SELECT * FROM tb_et_awl WHERE year_no='".$year_no."' and mount_no='".$month_code."' LIMIT 100 OFFSET 1500";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);		
	
$strSQL5 = "SELECT * FROM tb_et_awl WHERE year_no='".$year_no."' and mount_no='".$month_code."' LIMIT 100 OFFSET 1600";
$objQuery5= mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rows5 = mysqli_num_rows($objQuery5);	
	
$strSQL6 = "SELECT * FROM tb_et_awl WHERE year_no='".$year_no."' and mount_no='".$month_code."' LIMIT 100 OFFSET 1700";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$Num_Rows6 = mysqli_num_rows($objQuery6);		

$strSQL7 = "SELECT * FROM tb_et_awl WHERE year_no='".$year_no."' and mount_no='".$month_code."' LIMIT 100 OFFSET 1800";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);		

/*$strSQL8 = "SELECT * FROM tb_et_awl WHERE year_no='".$year_no."' and mount_no='".$month_code."' LIMIT 100 OFFSET 1600";
$objQuery8 = mysqli_query($conn,$strSQL8) or die ("Error Query [".$strSQL8."]");
$Num_Rows8 = mysqli_num_rows($objQuery8);	
	
$strSQL9 = "SELECT * FROM tb_et_awl WHERE year_no='".$year_no."' and mount_no='".$month_code."' LIMIT 100 OFFSET 1700";
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);*/	
	
	
?>
<div class="w3-container">
	<div class="w3-half">
	<div class="w3-container w3-third">
	
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="2%">เลขที่เอกสาร</th>
			<th width="2%">เลขที่อ้างอิง</th>
			<th width="2%">วันที่ออกเอกสาร</th>
			
	</thead>
<?php

while($objResult1 = mysqli_fetch_array($objQuery1))
{	
	
$strSQL11 = "SELECT ref_id,doc_release_date FROM so__main WHERE doc_no = '".$objResult1["doc_no"]."' and cancel_ckk='0' and select_type_doc='3' ";
$objQuery11= mysqli_query($conn,$strSQL11) or die(mysqli_error());
$Num_Rows11 = mysqli_num_rows($objQuery11);		
$objResult11 = mysqli_fetch_array($objQuery11);

if($Num_Rows11 > 0){	
$strSQL22 =  "Update tb_et_awl Set ref_so='".$objResult11["ref_id"]."',iv_date='".$objResult11["doc_release_date"]."'  where  doc_no ='".$objResult1["doc_no"]."'";
 $objQuery22 = mysqli_query($conn,$strSQL22) or die(mysqli_error());	
}
	
	
$strSQL13 = "SELECT ref_id,iv_date FROM hos__so WHERE iv_no = '".$objResult1["doc_no"]."' and status_doc='Approve' and type_doc='3' ";
$objQuery13= mysqli_query($conn,$strSQL13) or die(mysqli_error());
$Num_Rows13 = mysqli_num_rows($objQuery13);			
$objResult13 = mysqli_fetch_array($objQuery13);

if($Num_Rows13 > 0){	
$strSQL23 =  "Update tb_et_awl Set ref_so='".$objResult13["ref_id"]."',iv_date='".$objResult13["iv_date"]."'  where  doc_no ='".$objResult1["doc_no"]."'";
 $objQuery23 = mysqli_query($conn,$strSQL23) or die(mysqli_error());	
}
?>
	
			<tr>
				<td><?php echo $objResult1["doc_no"];?></td>
					<?php if($objResult1["ref_so"]!=''){ ?>
				<td>	
					<?php }else{ ?>
				<td bgcolor="#FFFF00">
<?php } ?><a href="register_admin_edit.php?ref_id=<?php echo $objResult1["ref_so"];?>"  target="_blank"><?php echo $objResult1["ref_so"];?></a></td>
				<td><?php if($objResult1["iv_date"]=='0000-00-00'){  }else{ echo Datethai($objResult1["iv_date"]); } ?></td>
			<?php
}
		?>
				</tr>
			</table>
		</div><div class="w3-container w3-third">
		<table border="1" width="50%" class="w3-table">
		<thead class="w3-gray">
			<th width="2%">เลขที่เอกสาร</th>
			<th width="2%">เลขที่อ้างอิง</th>
			<th width="2%">วันที่ออกเอกสาร</th>
			
	</thead>
				<?php
		while($objResult2 = mysqli_fetch_array($objQuery2))
{
			
$strSQL11 = "SELECT ref_id,doc_release_date FROM so__main WHERE doc_no = '".$objResult2["doc_no"]."' and cancel_ckk='0' and select_type_doc='3' ";
$objQuery11= mysqli_query($conn,$strSQL11) or die(mysqli_error());
$Num_Rows11 = mysqli_num_rows($objQuery11);		
$objResult11 = mysqli_fetch_array($objQuery11);

if($Num_Rows11 > 0){	
$strSQL22 =  "Update tb_et_awl Set ref_so='".$objResult11["ref_id"]."',iv_date='".$objResult11["doc_release_date"]."'  where  doc_no ='".$objResult2["doc_no"]."'";
 $objQuery22 = mysqli_query($conn,$strSQL22) or die(mysqli_error());	
}
	
	
$strSQL13 = "SELECT ref_id,iv_date FROM hos__so WHERE iv_no = '".$objResult2["doc_no"]."' and status_doc='Approve' and type_doc='3' ";
$objQuery13= mysqli_query($conn,$strSQL13) or die(mysqli_error());
$Num_Rows13 = mysqli_num_rows($objQuery13);			
$objResult13 = mysqli_fetch_array($objQuery13);

if($Num_Rows13 > 0){	
$strSQL23 =  "Update tb_et_awl Set ref_so='".$objResult13["ref_id"]."',iv_date='".$objResult13["iv_date"]."'  where  doc_no ='".$objResult2["doc_no"]."'";
 $objQuery23 = mysqli_query($conn,$strSQL23) or die(mysqli_error());	
}		
?>	
<tr>
				<td><?php echo $objResult2["doc_no"];?></td>
					<?php if($objResult2["ref_so"]!=''){ ?>
				<td>	
					<?php }else{ ?>
				<td bgcolor="#FFFF00">
<?php } ?><a href="register_admin_edit.php?ref_id=<?php echo $objResult2["ref_so"];?>"  target="_blank"><?php echo $objResult2["ref_so"];?></a></td>
				<td><?php if($objResult2["iv_date"]=='0000-00-00'){  }else{ echo Datethai($objResult2["iv_date"]); } ?></td>
			<?php
}
			?>
	</tr>
			</table>
		</div><div class="w3-container w3-third">
		<table border="1" width="50%" class="w3-table">
		<thead class="w3-gray">
			<th width="2%">เลขที่เอกสาร</th>
			<th width="2%">เลขที่อ้างอิง</th>
			<th width="2%">วันที่ออกเอกสาร</th>
			
	</thead>
	<?php
		while($objResult3 = mysqli_fetch_array($objQuery3))
{
$strSQL11 = "SELECT ref_id,doc_release_date FROM so__main WHERE doc_no = '".$objResult3["doc_no"]."' and cancel_ckk='0' and select_type_doc='3' ";
$objQuery11= mysqli_query($conn,$strSQL11) or die(mysqli_error());
$Num_Rows11 = mysqli_num_rows($objQuery11);		
$objResult11 = mysqli_fetch_array($objQuery11);

if($Num_Rows11 > 0){	
$strSQL22 =  "Update tb_et_awl Set ref_so='".$objResult11["ref_id"]."',iv_date='".$objResult11["doc_release_date"]."'  where  doc_no ='".$objResult3["doc_no"]."'";
 $objQuery22 = mysqli_query($conn,$strSQL22) or die(mysqli_error());	
}
	
	
$strSQL13 = "SELECT ref_id,iv_date FROM hos__so WHERE iv_no = '".$objResult3["doc_no"]."' and status_doc='Approve' and type_doc='3' ";
$objQuery13= mysqli_query($conn,$strSQL13) or die(mysqli_error());
$Num_Rows13 = mysqli_num_rows($objQuery13);			
$objResult13 = mysqli_fetch_array($objQuery13);

if($Num_Rows13 > 0){	
$strSQL23 =  "Update tb_et_awl Set ref_so='".$objResult13["ref_id"]."',iv_date='".$objResult13["iv_date"]."'  where  doc_no ='".$objResult3["doc_no"]."'";
 $objQuery23 = mysqli_query($conn,$strSQL23) or die(mysqli_error());	
}			
?>				
				<tr>
				<td><?php echo $objResult3["doc_no"];?></td>
					<?php if($objResult3["ref_so"]!=''){ ?>
				<td>	
					<?php }else{ ?>
				<td bgcolor="#FFFF00">
<?php } ?>
					<a href="register_admin_edit.php?ref_id=<?php echo $objResult3["ref_so"];?>"  target="_blank"><?php echo $objResult3["ref_so"];?></a></td>
				<td><?php if($objResult3["iv_date"]=='0000-00-00'){  }else{ echo Datethai($objResult3["iv_date"]); } ?></td>
			<?php
}
			?>
					</tr>
			</table></div></div>
	
	<div class="w3-half">
	<div class="w3-container w3-third">
	
	<table border="1" width="50%" class="w3-table">
		<thead class="w3-gray">
			<th width="2%">เลขที่เอกสาร</th>
			<th width="2%">เลขที่อ้างอิง</th>
			<th width="2%">วันที่ออกเอกสาร</th>
			
	</thead>
					<?php
		while($objResult4 = mysqli_fetch_array($objQuery4))
{

$strSQL11 = "SELECT ref_id,doc_release_date FROM so__main WHERE doc_no = '".$objResult4["doc_no"]."' and cancel_ckk='0' and select_type_doc='3' ";
$objQuery11= mysqli_query($conn,$strSQL11) or die(mysqli_error());
$Num_Rows11 = mysqli_num_rows($objQuery11);		
$objResult11 = mysqli_fetch_array($objQuery11);

if($Num_Rows11 > 0){	
$strSQL22 =  "Update tb_et_awl Set ref_so='".$objResult11["ref_id"]."',iv_date='".$objResult11["doc_release_date"]."'  where  doc_no ='".$objResult4["doc_no"]."'";
 $objQuery22 = mysqli_query($conn,$strSQL22) or die(mysqli_error());	
}
	
	
$strSQL13 = "SELECT ref_id,iv_date FROM hos__so WHERE iv_no = '".$objResult4["doc_no"]."' and status_doc='Approve' and type_doc='3' ";
$objQuery13= mysqli_query($conn,$strSQL13) or die(mysqli_error());
$Num_Rows13 = mysqli_num_rows($objQuery13);			
$objResult13 = mysqli_fetch_array($objQuery13);

if($Num_Rows13 > 0){	
$strSQL23 =  "Update tb_et_awl Set ref_so='".$objResult13["ref_id"]."',iv_date='".$objResult13["iv_date"]."'  where  doc_no ='".$objResult4["doc_no"]."'";
 $objQuery23 = mysqli_query($conn,$strSQL23) or die(mysqli_error());	
}			
			
?>				
		<tr>
				<td><?php echo $objResult4["doc_no"];?></td>
					<?php if($objResult4["ref_so"]!=''){ ?>
				<td>	
					<?php }else{ ?>
				<td bgcolor="#FFFF00">
<?php } ?><a href="register_admin_edit.php?ref_id=<?php echo $objResult4["ref_so"];?>"  target="_blank"><?php echo $objResult4["ref_so"];?></a></td>
				<td><?php if($objResult4["iv_date"]=='0000-00-00'){  }else{ echo Datethai($objResult4["iv_date"]); } ?></td>
				
			<?php
}
		?>
			</tr>
		</table></div><div class="w3-container w3-third">
	
	<table border="1" width="50%" class="w3-table">
		<thead class="w3-gray">
			<th width="2%">เลขที่เอกสาร</th>
			<th width="2%">เลขที่อ้างอิง</th>
			<th width="2%">วันที่ออกเอกสาร</th>
			
	</thead>
		<?php
		while($objResult5 = mysqli_fetch_array($objQuery5))
{
			
$strSQL11 = "SELECT ref_id,doc_release_date FROM so__main WHERE doc_no = '".$objResult5["doc_no"]."' and cancel_ckk='0' and select_type_doc='3' ";
$objQuery11= mysqli_query($conn,$strSQL11) or die(mysqli_error());
$Num_Rows11 = mysqli_num_rows($objQuery11);		
$objResult11 = mysqli_fetch_array($objQuery11);

if($Num_Rows11 > 0){	
$strSQL22 =  "Update tb_et_awl Set ref_so='".$objResult11["ref_id"]."',iv_date='".$objResult11["doc_release_date"]."'  where  doc_no ='".$objResult5["doc_no"]."'";
 $objQuery22 = mysqli_query($conn,$strSQL22) or die(mysqli_error());	
}
	
	
$strSQL13 = "SELECT ref_id,iv_date FROM hos__so WHERE iv_no = '".$objResult5["doc_no"]."' and status_doc='Approve' and type_doc='3' ";
$objQuery13= mysqli_query($conn,$strSQL13) or die(mysqli_error());
$Num_Rows13 = mysqli_num_rows($objQuery13);			
$objResult13 = mysqli_fetch_array($objQuery13);

if($Num_Rows13 > 0){	
$strSQL23 =  "Update tb_et_awl Set ref_so='".$objResult13["ref_id"]."',iv_date='".$objResult13["iv_date"]."'  where  doc_no ='".$objResult5["doc_no"]."'";
 $objQuery23 = mysqli_query($conn,$strSQL23) or die(mysqli_error());	
}			
?>				<tr>
				<td><?php echo $objResult5["doc_no"];?></td>
					<?php if($objResult5["ref_so"]!=''){ ?>
				<td>	
					<?php }else{ ?>
				<td bgcolor="#FFFF00">
<?php } ?><a href="register_admin_edit.php?ref_id=<?php echo $objResult5["ref_so"];?>"  target="_blank"><?php echo $objResult5["ref_so"];?></a></td>
				<td><?php if($objResult5["iv_date"]=='0000-00-00'){  }else{ echo Datethai($objResult5["iv_date"]); } ?></td>
				
			<?php
}
		?>
		</tr></table>
		</div><div class="w3-container w3-third">
	
	<table border="1" width="50%" class="w3-table">
		<thead class="w3-gray">
			<th width="2%">เลขที่เอกสาร</th>
			<th width="2%">เลขที่อ้างอิง</th>
			<th width="2%">วันที่ออกเอกสาร</th>
			
	</thead>
		<?php
		while($objResult6 = mysqli_fetch_array($objQuery6))
{

$strSQL11 = "SELECT ref_id,doc_release_date FROM so__main WHERE doc_no = '".$objResult6["doc_no"]."' and cancel_ckk='0' and select_type_doc='3' ";
$objQuery11= mysqli_query($conn,$strSQL11) or die(mysqli_error());
$Num_Rows11 = mysqli_num_rows($objQuery11);		
$objResult11 = mysqli_fetch_array($objQuery11);

if($Num_Rows11 > 0){	
$strSQL22 =  "Update tb_et_awl Set ref_so='".$objResult11["ref_id"]."',iv_date='".$objResult11["doc_release_date"]."'  where  doc_no ='".$objResult6["doc_no"]."'";
 $objQuery22 = mysqli_query($conn,$strSQL22) or die(mysqli_error());	
}
	
	
$strSQL13 = "SELECT ref_id,iv_date FROM hos__so WHERE iv_no = '".$objResult6["doc_no"]."' and status_doc='Approve' and type_doc='3' ";
$objQuery13= mysqli_query($conn,$strSQL13) or die(mysqli_error());
$Num_Rows13 = mysqli_num_rows($objQuery13);			
$objResult13 = mysqli_fetch_array($objQuery13);

if($Num_Rows13 > 0){	
$strSQL23 =  "Update tb_et_awl Set ref_so='".$objResult13["ref_id"]."',iv_date='".$objResult13["iv_date"]."'  where  doc_no ='".$objResult6["doc_no"]."'";
 $objQuery23 = mysqli_query($conn,$strSQL23) or die(mysqli_error());	
}			
			
?>				
		<tr>
				<td><?php echo $objResult6["doc_no"];?></td>
					<?php if($objResult6["ref_so"]!=''){ ?>
				<td>	
					<?php }else{ ?>
				<td bgcolor="#FFFF00">
<?php } ?><a href="register_admin_edit.php?ref_id=<?php echo $objResult6["ref_so"];?>"  target="_blank"><?php echo $objResult6["ref_so"];?></a></td>
				<td><?php if($objResult6["iv_date"]=='0000-00-00'){  }else{ echo Datethai($objResult6["iv_date"]); } ?></td>
			<?php
}
		?>
		</tr></table>
		</div>
		
<div class="w3-container w3-third">
	
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="2%">เลขที่เอกสาร</th>
			<th width="2%">เลขที่อ้างอิง</th>
			<th width="2%">วันที่ออกเอกสาร</th>
			
	</thead>
		<?php
		while($objResult7 = mysqli_fetch_array($objQuery7))
{
			
			
$strSQL11 = "SELECT ref_id,doc_release_date FROM so__main WHERE doc_no = '".$objResult7["doc_no"]."' and cancel_ckk='0' and select_type_doc='3' ";
$objQuery11= mysqli_query($conn,$strSQL11) or die(mysqli_error());
$Num_Rows11 = mysqli_num_rows($objQuery11);		
$objResult11 = mysqli_fetch_array($objQuery11);

if($Num_Rows11 > 0){	
$strSQL22 =  "Update tb_et_awl Set ref_so='".$objResult11["ref_id"]."',iv_date='".$objResult11["doc_release_date"]."'  where  doc_no ='".$objResult7["doc_no"]."'";
 $objQuery22 = mysqli_query($conn,$strSQL22) or die(mysqli_error());	
}
	
	
$strSQL13 = "SELECT ref_id,iv_date FROM hos__so WHERE iv_no = '".$objResult7["doc_no"]."' and status_doc='Approve' and type_doc='3' ";
$objQuery13= mysqli_query($conn,$strSQL13) or die(mysqli_error());
$Num_Rows13 = mysqli_num_rows($objQuery13);			
$objResult13 = mysqli_fetch_array($objQuery13);

if($Num_Rows13 > 0){	
$strSQL23 =  "Update tb_et_awl Set ref_so='".$objResult13["ref_id"]."',iv_date='".$objResult13["iv_date"]."'  where  doc_no ='".$objResult7["doc_no"]."'";
 $objQuery23 = mysqli_query($conn,$strSQL23) or die(mysqli_error());	
}			
						
			
?>				
		<tr>
				<td><?php echo $objResult7["doc_no"];?></td>
				<td><a href="register_admin_edit.php?ref_id=<?php echo $objResult7["ref_so"];?>"  target="_blank"><?php echo $objResult7["ref_so"];?></a></td>
				<td><?php if($objResult7["iv_date"]=='0000-00-00'){  }else{ echo Datethai($objResult7["iv_date"]); } ?></td>
			<?php
}
		?>
		</tr></table>
		</div><!--div class="w3-container w3-third">
	
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="2%">เลขที่เอกสาร</th>
			<th width="2%">เลขที่อ้างอิง</th>
			<th width="2%">วันที่ออกเอกสาร</th>
			
	</thead>
		<?php
		
		while($objResult8 = mysqli_fetch_array($objQuery8))
{
			
			
$strSQL11 = "SELECT ref_id,doc_release_date FROM so__main WHERE doc_no = '".$objResult8["doc_no"]."' and cancel_ckk='0' and select_type_doc='3' ";
$objQuery11= mysqli_query($conn,$strSQL11) or die(mysqli_error());
$Num_Rows11 = mysqli_num_rows($objQuery11);		
$objResult11 = mysqli_fetch_array($objQuery11);

if($Num_Rows11 > 0){	
$strSQL22 =  "Update tb_et_awl Set ref_so='".$objResult11["ref_id"]."',iv_date='".$objResult11["doc_release_date"]."'  where  doc_no ='".$objResult8["doc_no"]."'";
 $objQuery22 = mysqli_query($conn,$strSQL22) or die(mysqli_error());	
}
	
	
$strSQL13 = "SELECT ref_id,iv_date FROM hos__so WHERE iv_no = '".$objResult8["doc_no"]."' and status_doc='Approve' and type_doc='3' ";
$objQuery13= mysqli_query($conn,$strSQL13) or die(mysqli_error());
$Num_Rows13 = mysqli_num_rows($objQuery13);			
$objResult13 = mysqli_fetch_array($objQuery13);

if($Num_Rows13 > 0){	
$strSQL23 =  "Update tb_et_awl Set ref_so='".$objResult13["ref_id"]."',iv_date='".$objResult13["iv_date"]."'  where  doc_no ='".$objResult8["doc_no"]."'";
 $objQuery23 = mysqli_query($conn,$strSQL23) or die(mysqli_error());	
}			
				
			
			
?>				
				<tr>
				<td><?php echo $objResult8["doc_no"];?></td>
				<td><a href="register_admin_edit.php?ref_id=<?php echo $objResult8["ref_so"];?>"  target="_blank"><?php echo $objResult8["ref_so"];?></a></td>
				<td><?php if($objResult8["iv_date"]=='0000-00-00'){  }else{ echo Datethai($objResult8["iv_date"]); } ?></td>
				
				
	<?php } ?>	
					</tr></table>
		</div> 
<div class="w3-container w3-third">
	
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="2%">เลขที่เอกสาร</th>
			<th width="2%">เลขที่อ้างอิง</th>
			<th width="2%">วันที่ออกเอกสาร</th>
			
	</thead>
		<?php
		
		while($objResult9 = mysqli_fetch_array($objQuery9))
{
			
			
$strSQL11 = "SELECT ref_id,doc_release_date FROM so__main WHERE doc_no = '".$objResult9["doc_no"]."' and cancel_ckk='0' and select_type_doc='3' ";
$objQuery11= mysqli_query($conn,$strSQL11) or die(mysqli_error());
$Num_Rows11 = mysqli_num_rows($objQuery11);		
$objResult11 = mysqli_fetch_array($objQuery11);

if($Num_Rows11 > 0){	
$strSQL22 =  "Update tb_et_awl Set ref_so='".$objResult11["ref_id"]."',iv_date='".$objResult11["doc_release_date"]."'  where  doc_no ='".$objResult9["doc_no"]."'";
 $objQuery22 = mysqli_query($conn,$strSQL22) or die(mysqli_error());	
}
	
	
$strSQL13 = "SELECT ref_id,iv_date FROM hos__so WHERE iv_no = '".$objResult9["doc_no"]."' and status_doc='Approve' and type_doc='3' ";
$objQuery13= mysqli_query($conn,$strSQL13) or die(mysqli_error());
$Num_Rows13 = mysqli_num_rows($objQuery13);			
$objResult13 = mysqli_fetch_array($objQuery13);

if($Num_Rows13 > 0){	
$strSQL23 =  "Update tb_et_awl Set ref_so='".$objResult13["ref_id"]."',iv_date='".$objResult13["iv_date"]."'  where  doc_no ='".$objResult9["doc_no"]."'";
 $objQuery23 = mysqli_query($conn,$strSQL23) or die(mysqli_error());	
}			
				
			
			
?>				
				<tr>
				<td><?php echo $objResult9["doc_no"];?></td>
				<td><a href="register_admin_edit.php?ref_id=<?php echo $objResult9["ref_so"];?>"  target="_blank"><?php echo $objResult9["ref_so"];?></a></td>
				<td><?php if($objResult9["iv_date"]=='0000-00-00'){  }else{ echo Datethai($objResult9["iv_date"]); } ?></td>
				
				
	<?php } ?>	
					</tr></table>
		</div--> </div>
				

<div class="w3-panel">
</div>

</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>

</form>

</body>
</html>
	

