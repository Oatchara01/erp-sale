<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-grey"><h3>Status ใบยืมค้างเคลียร์ (AWL)</h3></div>

<div class="w3-bar w3-quarter">
ชื่อลุกค้า : 
<input type='text' name = "bill_id" value="<?php echo isset($_POST['bill_id']) ? $_POST['bill_id'] : ''; ?>" id = "bill_id" style="width:90%;" class="button4" placeholder="Search ชื่อลูกค้า..." > 
<input type='hidden' name = "h_bill_id" value="<?php echo $bill_id = isset($_POST['h_bill_id']) ? $_POST['h_bill_id'] : ''; ?>"   id = "h_bill_id"  class="button4" readonly>
</div>
<div class="w3-bar w3-quarter">
รหัสสินค้า :
<input type='text' name = "product_codet" style="width:100%;" value="<?php echo $product_codet = isset($_POST['product_codet']) ? $_POST['product_codet'] : ''; ?>" id = "product_codet" class="button4" placeholder="Search รหัสสินค้า" style="width:90%;" > 


</div>
<div class="w3-bar w3-quarter">
ชื่อสินค้า :
<input type='text' name = "product_c" style="width:100%;" value="<?php echo $product_c = isset($_POST['product_c']) ? $_POST['product_c'] : ''; ?>" id = "product_c" class="button4" placeholder="Search ชื่อสินค้า" style="width:90%;"> 

<input type='hidden' name = "product_id" value="<?php echo $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : ''; ?>" id = "product_id" class="w3-input" />
	
<input type='hidden' name = "type_doc" value="<?php echo"1"; ?>" id = "type_doc" class="w3-input" />	

</div>

<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div><br>
 <center>
		  <input type="button" name ="Submit" value="เปิดใบสั่งขาย" class = "w3-button w3-purple" onClick="this.form.action='register_salehos_any.php'; submit()">
		</center><br>
<?php	
	$bill_id = isset($_POST['h_bill_id']) ? $_POST['h_bill_id'] : '';
	$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$sale_code = $_SESSION['code'];
$user_type = $_SESSION['user_type'];

	
if($bill_id !='' or $product_id!=''){	
	
if($user_type=='Engineer'){
$strSQL = "SELECT ref_id_br,iv_no,iv_date,customer,sale_code,status_doc,sale,date_br  FROM hos__br  where sale_code LIKE '%EN%' and close_br = '0' and status_doc = 'Approve' and company='1'";
}else{
$strSQL = "SELECT ref_id_br,iv_no,iv_date,customer,sale_code,status_doc,sale,date_br FROM hos__br  where  close_br ='0' and status_doc ='Approve' and sale_code ='".$sale_code."' and company='1'";	
}

if($bill_id !=""){
	$strSQL .= ' AND customer_id = "'.$bill_id.'"'; 

}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

?>
<div class="w3-container">
	<div class="w3-responsive">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลือกข้อมูล</th>
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="10%">วันที่ลงทะเบียน</th>
			<th width="10%">เลขที่เอกสาร</th> 
			<th width="10%">วันที่ออกเอกสาร</th>
			<th width="23%">รายการสินค้า</th>
			<th width="8%">จำนวน</th>
			<th width="8%">หมายเลขเครื่อง</th>
			<th width="20%">ชื่อลูกค้า</th>
			<th width="10%">เขตการขาย</th>
			<th width="8%">สถานะ</th>
			
	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
	
$strSQL1 = "SELECT product_id,count,sn,sale_remark FROM hos__subbr WHERE ref_idd_br='".$objResult["ref_id_br"]."' and clear_ckk='0' and ckk_st='1'";

if($product_id !=""){ 
    $strSQL1 .= ' AND product_id = "'.$product_id.'"'; 
}	
//echo $strSQL1;	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL2."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
		
	

$strSQL4 = "SELECT sol_name,access_code,unit_name FROM tb_product WHERE product_ID = '".$objResult1["product_id"]."' ";
$objQuery4 = mysqli_query($conn,$strSQL4);
$objResult4 = mysqli_fetch_array($objQuery4);



if($objResult1["sn"] !=''){


$sn_number =  $objResult1["sn"];
$str_arr = explode("\n",$sn_number);
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
	
$sql5 = "SELECT sn  FROM   hos__subspr   where  product_id = '".$objResult1["product_id"]."' and clear_br = '1' and clear_ivno ='".$objResult["iv_no"]."' and sn ='".$product_sn1."' and status_spr ='Approve'";
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
<td align="center" width="10" valign="top" class="style37">
<input type="checkbox" name="chk[<?php echo $i;?>]" value="<?=$i;?>">
<input type="hidden" name="product_code[<?php echo $i;?>]" id="product_code[<?php echo $i;?>]" value="<?php echo $objResult1["product_id"];  ?>">				
<input type="hidden" name="iv_no[<?php echo $i;?>]" id="iv_no[<?php echo $i;?>]" value="<?php echo $objResult["iv_no"];  ?>">
<input type="hidden" name="count[<?php echo $i;?>]" id="count[<?php echo $i;?>]" value="<?php echo "1";  ?>">				
<input type="hidden" name="sn[<?php echo $i;?>]" id="sn[<?php echo $i;?>]" value="<?php echo $product_sn1;  ?>">

				</td>
<td><?php echo $objResult["ref_id_br"];?></td>
<td><?php echo DateThai($objResult["date_br"]);	?></td>
<td><?php echo $objResult["iv_no"];?></td>
<td><?php if ($objResult["iv_date"]=="0000-00-00") { echo "-"; 	}else{ echo DateThai($objResult["iv_date"]); } ?></td>
<td><div align="left"><?php echo $objResult4["sol_name"];  ?> <?php echo $objResult1["sale_remark"];  ?></div></td>
<td><div align="left"><?php echo "1";?> <?php echo $objResult4["unit_name"];  ?> </div></td>
<td><div align="left"><?php echo $product_sn1;?></div></td>
<td><div align="left"><?php echo $objResult["customer"];?></div></td>
<td><div align="left"><?php echo $objResult["sale_code"]; ?> <?php echo '-';?> <?php echo $objResult["sale"];?></div></td>
				
<?php if($objResult["status_doc"]=='Rejected'){	?>
<td bgcolor="#FF3030"><?php echo $objResult["status_doc"];?></td>
<?php }
else if ($objResult["status_doc"]=='Approve'){ ?>
<td bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
<?php }
else{ ?>
<td ><?php echo $objResult["status_doc"];?></td>
<?php } ?>
				
			</tr>

			<?php
}
}
$i++; 
}


}

else if($objResult1["sn"]==''){



$sql3 = "SELECT sum(sale_count) as count3   FROM   hos__subspr   where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult["iv_no"]."' and status_spr='Approve'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_array($qry3);
		
$sql13 = "SELECT sum(count) as count3   FROM   hos__subso  where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and clear_ivno ='".$objResult["iv_no"]."'  and status_so='Approve'";
$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
$rs13 = mysqli_fetch_array($qry13);
	
$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$objResult["iv_no"]."' ";
$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
$rs41 = mysqli_fetch_array($qry41);

$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '".$rs41['ref_id']."' and product_id = '".$objResult1['product_id']."'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_array($qry4);

$sql12 = "SELECT sum(sale_count) as count3   FROM   hos__subsmp  where  product_id = '".$objResult1['product_id']."' and clear_br = '1' and br_no ='".$objResult["iv_no"]."' and status_smp ='Approve'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$count3 =  $rs3["count3"]; 
$count13 = $rs13["count3"]; 
$count4 =  $rs4["count4"]; 
$count5 =  $rs12["count3"];

	
$count2 = $objResult1["count"] - ($count3+$count4+$count5+$count13);
	if($count2=='0' ){

}else{

?>
	
			<tr>
<td align="center" width="10" valign="top" class="style37">
<input type="checkbox" name="chk[<?php echo $i;?>]" value="<?=$i;?>">
<input type="hidden" name="product_code[<?php echo $i;?>]" id="product_code[<?php echo $i;?>]" value="<?php echo $objResult1["product_id"];  ?>">				
<input type="hidden" name="iv_no[<?php echo $i;?>]" id="iv_no[<?php echo $i;?>]" value="<?php echo $objResult["iv_no"];  ?>">
<input type="hidden" name="count[<?php echo $i;?>]" id="count[<?php echo $i;?>]" value="<?php echo $count2;  ?>">				
<input type="hidden" name="sn[<?php echo $i;?>]" id="sn[<?php echo $i;?>]" value="<?php echo $objResult1["sn"];  ?>">
			
				
				</td>
<td><?php echo $objResult["ref_id_br"];?></td>
<td><?php echo DateThai($objResult["date_br"]);	?></td>
<td><?php echo $objResult["iv_no"];?></td>
<td><?php if ($objResult["iv_date"]=="0000-00-00") { echo "-"; 	}else{ echo DateThai($objResult["iv_date"]); } ?></td>
<td><div align="left"><?php echo $objResult4["sol_name"];  ?> <?php echo $objResult["sale_remark"];  ?></div></td>
<td><div align="left"><?php echo $count2;?> <?php echo $objResult4["unit_name"];  ?> </div></td>
<td><div align="left"></div></td>
<td><div align="left"><?php echo $objResult["customer"];?></div></td>
<td><div align="left"><?php echo $objResult["sale_code"]; ?> <?php echo '-';?> <?php echo $objResult["sale"];?></div></td>
				
<?php if($objResult["status_doc"]=='Rejected'){	?>
<td bgcolor="#FF3030"><?php echo $objResult["status_doc"];?></td>
<?php }
else if ($objResult["status_doc"]=='Approve'){ ?>
<td bgcolor="#00FF00"><?php echo $objResult["status_doc"];?></td>
<?php }
else{ ?>
<td ><?php echo $objResult["status_doc"];?></td>
<?php } ?>
				
			</tr>
			<?php 
	}
$i++;	 
}
?>
			<?php
	
}
}
		?>
	
	</table>
<?php } ?>

<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>
</form>

<?php if($_SESSION['department']=="วิศวกรรม"){ ?>

 <script type="text/javascript">
function make_autocom(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_bill_name6.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("bill_id","h_bill_id");
</script> 


<script type="text/javascript">
function make_autocom(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_pro_notdemoeng5.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet","product_id");
        </script>


<script type="text/javascript">
function make_autocom(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_pro_notdemotheng5.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
make_autocom("product_c","product_id");
        </script>



<?php }else{ ?>



 <script type="text/javascript">
function make_autocom(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_bill_name5.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("bill_id","h_bill_id");
</script> 


<script type="text/javascript">
function make_autocom(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_pro_notdemo5.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet","product_id");
        </script>


<script type="text/javascript">
function make_autocom(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_pro_notdemoth5.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
make_autocom("product_c","product_id");
        </script>

<?php
}
?>


