<?php include('head.php'); ?>
<body>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
</script>

<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="libs/jquery.js"></script>
<script src="src/jSignature.js"></script>
	
<script>

(function($) {
	var topics = {};
	$.publish = function(topic, args) {
	    if (topics[topic]) {
	        var currentTopic = topics[topic],
	        args = args || {};
	
	        for (var i = 0, j = currentTopic.length; i < j; i++) {
	            currentTopic[i].call($, args);
	        }
	    }
	};
$.subscribe = function(topic, callback) {
	    if (!topics[topic]) {
	        topics[topic] = [];
	    }
	    topics[topic].push(callback);
	    return {
	        "topic": topic,
	        "callback": callback
	    };
	};
	/*$.unsubscribe = function(handle) {
	    var topic = handle.topic;
	    if (topics[topic]) {
	        var currentTopic = topics[topic];
	
	        for (var i = 0, j = currentTopic.length; i < j; i++) {
	            if (currentTopic[i] === handle.callback) {
	                currentTopic.splice(i, 1);
	            }
	        }
	    }
	};*/
})(jQuery);

</script>
	
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
#customer_signature_par {
		color:#000000;
		background-color:darkgrey;
		max-width:300px;
		padding:3px;
	}
	
	/*This is the div within which the signature canvas is fitted*/
	#customer_signature {
		border: 2px  black;
		background-color:#DCDCDC;

	}

	
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 14px; color: #FF0000; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px; color: #000000; }
.style40 {font-size: 12px; color: #FF0000; }
-->	

</style>
	
	
<form name="frmSearch" action ="report_kerrysol.php" method="POST"  enctype="multipart/form-data">
	
<script>
	
$(document).ready(function() {
	
	var $sigdiv = $("#customer_signature").jSignature({'UndoButton':true})
		, $tools = $('#tools_cus')
	, $extraarea = $('#displayarea')
, pubsubprefix = 'jSignature.demo.'


	
	var export_plugins = $sigdiv.jSignature('listPlugins','export')
	, chops = ['<span class ="style35"><b>***กรุณาเลือกเป็น  default </b></span><select>','<option value="">(select export format)</option>']
	, name
	for(var i in export_plugins){
		if (export_plugins.hasOwnProperty(i)){
			name = export_plugins[i]
			chops.push('<option value="' + name + '">' + name + '</option>')
		}
	}
	chops.push('</select><span><b> or: </b></span>')
	
	$(chops.join('')).bind('change', function(e){
		if (e.target.value !== ''){
			var data = $sigdiv.jSignature('getData', e.target.value)
			$.publish(pubsubprefix + 'formatchanged')
			if (typeof data === 'string'){
				$('textarea', $tools).val(data)
			} else if($.isArray(data) && data.length === 2){
				$('textarea', $tools).val(data.join(','))
				$.publish(pubsubprefix + data[0], data);
			} else {
				try {
					$('textarea', $tools).val(JSON.stringify(data))
				} catch (ex) {
					$('textarea', $tools).val('Not sure how to stringify this, likely binary, format.')
				}
			}
		}
	}).appendTo($tools)
$('<textarea  id="customer_signature_name"  name="customer_signature_name" style="display:none;"></textarea>').appendTo($tools)

	$('<input type="button" value="Reset">').bind('click', function(e){
		$sigdiv.jSignature('reset')
	}).appendTo($tools)


$.subscribe(pubsubprefix + 'image/png;base64', function(data) {
		var i = new Image()
		i.src = 'data:' + data[0] + ',' + data[1]
		/*$('<span><b>As you can see, one of the problems of "image" extraction (besides not working on some old Androids, elsewhere) is that it extracts A LOT OF DATA and includes all the decoration that is not part of the signature.</b></span>').appendTo($extraarea)*/
		$(i).appendTo($extraarea)
	});
	
})
	
</script>
	
	<div class="w3-white">
<div class="w3-container w3-padding-large">
	<div class="w3-panel w3-light-grey"><h3>รายการ Kerry รับเอง</h3></div>

	
	
	<div class="w3-container w3-third">
วันที่ : <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>"></div>
<div class="w3-container w3-third">

  บริษัท

<select name="company" id="company" style="width:90%;" class="w3-input"   required>
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="31">ออลล์เวล ไลฟ์ บจก.</option>
<option  value="42">โนเบิล เมด บจก.</option>

</select>

</div>
<div class="w3-container w3-third">
  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>


</p>

<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<td width="10%" align="center" class="style40">คลิ๊กในกรณีที่ไม่ได้ส่งของกับ Kerry</td>
	<td width="10%" align="center" class="style30">No.</td>
<td width="10%" align="center" class="style30">Recipient Name</td>
<td width="10%" align="center" class="style30">Mobile No.</td> 
<td width="10%" align="center" class="style30">Email</td> 
<td width="10%" align="center" class="style30">Address #1</td> 
<td width="10%" align="center" class="style30">Address #2</td> 
<td width="5%" align="center" class="style30">Zip Code</td> 
<td width="5%" align="center" class="style30">COD Amt (Baht)</td> 
<td width="5%" align="center" class="style30">Remark</td> 
<td width="5%" align="center" class="style30">Ref #1</td> 
<td width="5%" align="center" class="style30">Ref #2</td> 
<td width="5%" align="center" class="style30">Sender Ref</td> 
</thead>





<?php

if($_GET["start_date"] !=''){
$start_date = $_GET["start_date"];
$str_arr = $_GET["company"]; 
}else if($_POST["start_date"] !=''){
$start_date = $_POST["start_date"];
$str_arr = $_POST["company"]; 	
}
		
$company = substr($str_arr, 0,1);
$company1 = substr($str_arr,-1);	
	
if($start_date !='' and $str_arr !=''){
	


	 
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE sale_channel !='12' and  sale_channel !='1' and sale_channel !='20' and delivery ='1' and approve_complete ='Approve' and cb_send='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$n=1;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult["bill_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);
?>


<tr>
<td  align="center" class="style30">
	<a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
	<td  align="center" class="style30"><?php echo $n; ?></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["tel"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?> <?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>
<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";

$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>

<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
	<td  align="center" class="style30"><?php echo $n; ?></td>
<td  align="center" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult4["tel"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?> <?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>

<?php
}
$n++;
} 
?>


<?php

	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE   sale_channel !='12' and sale_channel !='1' and sale_channel !='20'  and delivery ='1' and approve_complete ='Approve' and cb_send='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
}
	
//echo $strSQL;
$objQuery =mysqli_query($conn,$strSQL);
$m=$n;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult["bill_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);
?>


<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
		<td  align="center" class="style30"><?php echo $m; ?></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["tel"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?> <?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>
<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";

$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>

<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
		<td  align="center" class="style30"><?php echo $m; ?></td>
<td  align="center" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult4["tel"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?> <?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>

<?php
}
$m++;
} 
?>




<?php
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel !='12'  and sale_channel !='1' and sale_channel !='20'  and delivery ='2' and approve_complete ='Approve' and cb_send='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);
$o=$m;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult["bill_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);

$strSQL2 ="SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE  ref_idd ='".$objResult["ref_id"]."'";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 =mysqli_fetch_array($objQuery2);


?>


<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
		<td  align="center" class="style30"><?php echo $o; ?></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["tel"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?> <?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="left" class="style30"><?php echo  number_format($objResult2["sum_amount"]); ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>

<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
		<td  align="center" class="style30"><?php echo $o; ?></td>
<td  align="center" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult4["tel"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?> <?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>



<?php

} 

$o++;
} 
?>
	
<?php
	
$strSQL ="SELECT customer_name,tel,address1,address2,province,postcode,bill_id,ref_id,doc_no FROM so__main WHERE  sale_channel !='12' and  sale_channel !='1' and sale_channel !='20'  and delivery ='2' and approve_complete ='Approve' and cb_send='0'";

if($start_date !=""){ 
    $strSQL .= ' AND delivery_date = "'.$start_date.'"'; 
}
if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company1.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);
$p=$o;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult["bill_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);

$strSQL2 ="SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE  ref_idd ='".$objResult["ref_id"]."'";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 =mysqli_fetch_array($objQuery2);


?>


<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
		<td  align="center" class="style30"><?php echo $p; ?></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["tel"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address1"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["address2"]; ?> <?php echo  $objResult["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["postcode"]; ?></td> 
<td  align="left" class="style30"><?php echo  number_format($objResult2["sum_amount"]); ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>
	
	<?php
$strSQL4 ="SELECT customer_name,tel,address1,address2,province,postcode,ref_id FROM so__extraaddress WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery4 =mysqli_query($conn,$strSQL4);
//$n=1;
while($objResult4=mysqli_fetch_array($objQuery4)){
?>

<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
		<td  align="center" class="style30"><?php echo $p; ?></td>
<td  align="center" class="style30"><?php echo $objResult4["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult4["tel"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult4["address1"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["address2"]; ?> <?php echo  $objResult4["province"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult4["postcode"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult["doc_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>



<?php

} 

$p++;
} 
?>
	
	
	


<?php


$strSQL ="SELECT customer_name,customer_tel,address_name,ref_id FROM tb_register_data WHERE  address_1 LIKE '%Kerry%' and cb_send='0'";

if($start_date !=""){ 
    $strSQL .= ' AND start_date = "'.$start_date.'"'; 
}
	
$objQuery =mysqli_query($conn,$strSQL);
$d=$p;
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL5 ="SELECT bill_id,iv_no FROM hos__so WHERE  ref_id ='".$objResult["ref_id"]."' and status_doc ='Approve'";
if($company !=""){ 
    $strSQL5 .= ' AND type_doc = "'.$company.'"'; 
}	
$objQuery5 =mysqli_query($conn,$strSQL5);
$Num_Rows5 = mysqli_num_rows($objQuery5);

$objResult5=mysqli_fetch_array($objQuery5);	
if($Num_Rows5 > 0){	
$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult5["bill_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);
?>


<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
		<td  align="center" class="style30"><?php echo $d; ?></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["customer_tel"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address_name"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">
<?php
	$strSQL31 ="SELECT sol_name,count,unit_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id)  WHERE  ref_idd='".$objResult["ref_id"]."'";
$objQuery31 =mysqli_query($conn,$strSQL31);
while($objResult31=mysqli_fetch_array($objQuery31)){
	echo $objResult31["sol_name"]; echo  $objResult31["count"]; echo  $objResult31["unit_name"];
	?>
	
	<br>
	<?php
}
	?>	
</td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>
	
<?php

$strSQL6 ="SELECT * FROM tb_delivery_print WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery6 =mysqli_query($conn,$strSQL6);
$Num_Rows6 = mysqli_num_rows($objQuery6);	
$objResult6=mysqli_fetch_array($objQuery6);
if($Num_Rows6 > 0){	
	?>
	
<?php if($objResult6["customer_name1"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
		<td  align="center" class="style30"><?php echo $d; ?></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name1"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel1"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name1"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name2"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name2"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel2"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name2"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name3"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name3"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel3"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name3"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name4"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name4"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel4"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name4"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>

<?php if($objResult6["customer_name5"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name5"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel5"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name5"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name6"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name6"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel6"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name6"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
<?php if($objResult6["customer_name7"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name7"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel7"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name7"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
<?php if($objResult6["customer_name8"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name8"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel8"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name8"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
				
<?php if($objResult6["customer_name9"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name9"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel9"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name9"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php
} 
}
	?>
	
<?php
	$d++;
}
?>
	
<?php

$strSQL5 ="SELECT customer,iv_no FROM hos__change WHERE  ref_id ='".$objResult["ref_id"]."' and status_doc ='Approve'";
if($company !=""){ 
    $strSQL5 .= ' AND company = "'.$company1.'"'; 
}	
$objQuery5 =mysqli_query($conn,$strSQL5);
$Num_Rows5 = mysqli_num_rows($objQuery5);

$objResult5=mysqli_fetch_array($objQuery5);	
if($Num_Rows5 > 0){	
$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult5["customer_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);
?>


<tr>
	<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $d; ?></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["customer_tel"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address_name"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="right" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>

	<?php
}
 
?>

<?php

$strSQL5 ="SELECT customer_id,iv_no FROM hos__br WHERE  ref_id_br ='".$objResult["ref_id"]."' and status_doc ='Approve'";
if($company !=""){ 
    $strSQL5 .= ' AND company = "'.$company1.'"'; 
}	
$objQuery5 =mysqli_query($conn,$strSQL5);
$Num_Rows5 = mysqli_num_rows($objQuery5);

$objResult5=mysqli_fetch_array($objQuery5);	
if($Num_Rows5 > 0){	
$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult5["customer_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);
?>


<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["customer_tel"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult["address_name"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>
	
<?php

$strSQL6 ="SELECT * FROM tb_delivery_print WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery6 =mysqli_query($conn,$strSQL6);
$Num_Rows6 = mysqli_num_rows($objQuery6);	
$objResult6=mysqli_fetch_array($objQuery6);
if($Num_Rows6 > 0){	
	?>
	
<?php if($objResult6["customer_name1"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name1"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel1"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name1"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name2"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name2"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel2"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name2"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name3"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name3"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel3"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name3"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name4"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name4"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel4"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name4"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>

<?php if($objResult6["customer_name5"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name5"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel5"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name5"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name6"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name6"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel6"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name6"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
<?php if($objResult6["customer_name7"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name7"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel7"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name7"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
<?php if($objResult6["customer_name8"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name8"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel8"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name8"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
				
<?php if($objResult6["customer_name9"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name9"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel9"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult1["email_cus"]; ?></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name9"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php
} 
}
	?>
	
<?php
}
?>



<?php

$strSQL5 ="SELECT smp_no FROM hos__smp WHERE  ref_idsmp ='".$objResult["ref_id"]."' and status_sup ='Approve'";
if($company !=""){ 
    $strSQL5 .= ' AND type_company = "'.$company1.'"'; 
}	
$objQuery5 =mysqli_query($conn,$strSQL5);
$Num_Rows5 = mysqli_num_rows($objQuery5);

$objResult5=mysqli_fetch_array($objQuery5);	
if($Num_Rows5 > 0){	
/*$strSQL1 ="SELECT email_cus FROM tb_customer WHERE  customer_id='".$objResult5["customer_id"]."'";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);*/
?>


<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult["customer_tel"]; ?></td>
<td  align="center" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult["address_name"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>
	
<?php

$strSQL6 ="SELECT * FROM tb_delivery_print WHERE  ref_id='".$objResult["ref_id"]."'";
$objQuery6 =mysqli_query($conn,$strSQL6);
$Num_Rows6 = mysqli_num_rows($objQuery6);	
$objResult6=mysqli_fetch_array($objQuery6);
if($Num_Rows6 > 0){	
	?>
	
<?php if($objResult6["customer_name1"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name1"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel1"]; ?></td>
<td  align="center" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name1"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name2"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name2"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel2"]; ?></td>
<td  align="center" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name2"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name3"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name3"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel3"]; ?></td>
<td  align="center" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name3"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name4"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name4"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel4"]; ?></td>
<td  align="center" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name4"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>

<?php if($objResult6["customer_name5"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name5"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel5"]; ?></td>
<td  align="center" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name5"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
	<?php if($objResult6["customer_name6"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name6"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel6"]; ?></td>
<td  align="center" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name6"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
	
<?php if($objResult6["customer_name7"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name7"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel7"]; ?></td>
<td  align="center" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name7"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
<?php if($objResult6["customer_name8"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name8"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel8"]; ?></td>
<td  align="center" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name8"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php } ?>
				
<?php if($objResult6["customer_name9"]!=''){ ?>
<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?ref_id=<?php echo $objResult["ref_id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $objResult6["customer_name9"]; ?></td>
<td  align="center" class="style30"><?php echo  $objResult6["customer_tel9"]; ?></td>
<td  align="center" class="style30"></td>
<td  align="left" class="style30"><?php echo  $objResult6["address_name9"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30">เลขที่อ้างอิง <?php echo  $objResult["ref_id"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"></td> 
</tr>	
	
	
	<?php
} 
}
	?>
	
<?php
}
	//$d++;
}
?>	

	
<?php

$strSQL5 ="SELECT * FROM tb_deloth WHERE  type_del='Kerry'";
if($start_date !=""){ 
    $strSQL5 .= ' AND del_date = "'.$start_date.'"'; 
}

	if($company !=""){ 
    $strSQL5 .= ' AND company = "'.$company1.'"'; 
}	
//echo $strSQL5;	
$objQuery5 =mysqli_query($conn,$strSQL5);
$Num_Rows5 = mysqli_num_rows($objQuery5);

$q=$d;	

while($objResult5=mysqli_fetch_array($objQuery5)){


?>


<tr>
<td  align="center" class="style30"><a href=javascript:if(confirm('!!!รายการนี้ยังไม่ได้จัดส่งใช่หรือไม่')==true){window.location='save_kerry.php?id=<?php echo $objResult5["id"];?>&start_date=<?php echo $start_date; ?>&str_arr=<?php echo $str_arr; ?>';}><img src="img/sticker.png" width="23" height="23" border="0" /></a></td>
<td  align="center" class="style30"><?php echo $q; ?></td>
<td  align="center" class="style30"></td>
<td  align="center" class="style30"></td>
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"><?php echo  $objResult5["pro_name"]; ?></td> 
<td  align="left" class="style30"></td> 
<td  align="left" class="style30"><?php echo  $objResult5["iv_no"]; ?></td> 
<td  align="left" class="style30"><?php echo  $objResult5["ref_no"]; ?></td> 
</tr>	







<?php
												  $q++;
}
}

	?>	



</table>



	
<?php if($start_date !='' and $str_arr !=''){ 

$qfirst = "select * from st__kerry where type_group = '1'";

if($start_date !=""){ 
    $qfirst .= ' AND date_kerry = "'.$start_date.'"'; 
}
if($company !=""){ 
    $qfirst .= ' AND type_company = "'.$company1.'"'; 
}	
	
$first = mysqli_query($conn,$qfirst);
$Num_Rows19 = mysqli_num_rows($first);
$ffirst = mysqli_fetch_array($first);	

?>
<center>
<br>&nbsp;&nbsp;&nbsp;ผู้รับสินค้า  :&nbsp;&nbsp; &nbsp;&nbsp;

<?php
if($ffirst["emy_receive"]!=''){
?>
<img src="data:<?php echo $ffirst["emy_receive"];?>" width="180" align="center" height="100" /></br></br>
<?php
}else{
?>


	<div id="customer_signature_par">
		<div name="customer_signature"  class="button4" id="customer_signature" cols="30" rows="2"></div>
		</div>
	<div id="tools_cus"></div>
	
	<?php } ?>
<br>
	 &nbsp;&nbsp;&nbsp;วันที่ :&nbsp;&nbsp;
	
	
	<?php 
	
$month = date('m');
$day = date('d');
$year = date('Y');

if($ffirst["date_kerry"]!=''){	
$today =$ffirst["date_kerry"];
}else{
$today = $year . '-' . $month . '-' . $day;
}
	
?>
	


	      <input name="date_kerry" style="width:90%;" type='date' id="date_kerry" value="<?php echo $today; ?>"  class="w3-input" readonly>&nbsp;&nbsp;&nbsp;<br>
	
	&nbsp;&nbsp;&nbsp;เบอร์โทร :&nbsp;&nbsp;

	      <input name="emy_tel" style="width:90%;" type='text' id="emy_tel" value="<?php echo $ffirst["emy_tel"]; ?>" class="w3-input"  />&nbsp;&nbsp;&nbsp;<br>
	&nbsp;&nbsp;&nbsp;ทะเบียนรถ :&nbsp;&nbsp;

	      <input name="num_bus" style="width:90%;" type='text' id="num_bus" value="<?php echo $ffirst["num_bus"]; ?>"  class="w3-input"  />&nbsp;&nbsp;&nbsp;
	<input name="type_company" style="width:90%;" value="<?php echo $company1 ?>" type='hidden' id="type_company"  class="w3-input"  />
	
	<br><br>
	<?php if($Num_Rows19 == '0'){ ?>
<input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='report_kerrysol1.php'; submit()">
	
<?php } ?>
</center>

<br>

<?php
}

?>
</div>
</div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>

</form>	
</body>
