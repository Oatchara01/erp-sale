<?php 

include('head.php');
include('dbconnect_sale.php');
include('dbconnect_acc.php');

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
<style>
/* modal ให้สูงไม่เกินจอ และเลื่อนใน modal ได้ */
#creditHistoryModal .w3-modal-content{
  width: 95vw;
  max-width: 1100px;
  max-height: 90vh;
  overflow: hidden;            /* กันล้น */
  border-radius: 10px;
}

/* ส่วนเนื้อหาใน modal ให้เลื่อนแนวตั้ง */
#creditHistoryModal .modal-body{
  max-height: calc(90vh - 120px); /* หักหัว+footer */
  overflow-y: auto;
  padding: 16px;
}

/* wrapper สำหรับตาราง: ถ้ากว้างเกินให้เลื่อนแนวนอน */
.table-scroll{
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}

/* ตาราง */
.credit-table{
  width: 100%;
  min-width: 900px;           /* ถ้าจอเล็ก จะเลื่อนแนวนอนแทนการบีบคอลัมน์ */
  border-collapse: collapse;
}
.credit-table th, .credit-table td{
  padding: 8px 10px;
  border-bottom: 1px solid #eee;
  font-size: 13px;
  vertical-align: top;
  white-space: nowrap;        /* ค่าเริ่มต้น: ไม่ตัดบรรทัด */
}

/* คอลัมน์หมายเหตุ: อนุญาตให้ตัดบรรทัดแบบปกติ */
.credit-table td.note-col, .credit-table th.note-col{
  white-space: normal !important;
  word-break: normal !important;     /* สำคัญ: กันแตกทีละตัว */
  overflow-wrap: anywhere;           /* ถ้ายาวมากให้ขึ้นบรรทัดได้ */
  min-width: 260px;                  /* กันแคบเกิน */
}

/* หัวสีม่วงพาสเทล */
.purple-header{
  background:#B8A2FF !important;
  color:#fff !important;
}
</style>

<body>
<form   method="GET" name="frmMain" enctype="multipart/form-data" >
<div class="w3-white">
		<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray">
	
<div class="w3-half"><h4>ข้อมูลวงเงินลูกค้า</h4></div>
			
<div class="w3-half">			
</div></div>

<div class="w3-container w3-bar w3-quarter">
			ชื่อลูกค้า : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo 	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : ''; ?>"></div>
	<div class="w3-container w3-bar w3-quarter">
			ชื่อออกบิล : <input name="bill_name" class="w3-input" style="width:90%;" type="text" id="bill_name" value="<?php echo 	$bill_name = isset($_GET['bill_name']) ? $_GET['bill_name'] : ''; ?>"></div>
	<div class="w3-container w3-bar w3-quarter">
			รหัสลูกค้า AWL : <input name="Keyword2" class="w3-input" style="width:90%;" type="text" id="Keyword2" value="<?php echo 	$Keyword2 = isset($_GET['Keyword2']) ? $_GET['Keyword2'] : ''; ?>"></div>
	<div class="w3-container w3-bar w3-quarter">
			รหัสลูกค้า NBM : <input name="Keyword3" class="w3-input" style="width:90%;" type="text" id="Keyword3" value="<?php echo 	$Keyword3 = isset($_GET['Keyword3']) ? $_GET['Keyword3'] : ''; ?>"></div>
	<div class="w3-container w3-bar w3-quarter">
			เบอร์โทรศัพท์ : <input name="Keyword1" class="w3-input" style="width:90%;" type="text" id="Keyword1" value="<?php echo 	$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : ''; ?>"></div>
		<div class="w3-container w3-bar w3-quarter">
			รหัสสมาชิก : <input name="Keyword4" class="w3-input" style="width:90%;" type="text" id="Keyword4" value="<?php echo 	$Keyword4 = isset($_GET['Keyword4']) ? $_GET['Keyword4'] : ''; ?>"></div>
			<div class="w3-container w3-bar w3-quarter">
						หมายเหตุ : <input name="Keyword5" class="w3-input" style="width:90%;" type="text" id="Keyword5" value="<?php echo 	$Keyword5 = isset($_GET['Keyword5']) ? $_GET['Keyword5'] : ''; ?>"></div>
			<div class="w3-container w3-bar w3-quarter">
						ID ลูกค้า : <input name="Keyword6" class="w3-input" style="width:90%;" type="text" id="Keyword6" value="<?php echo 	$Keyword6 = isset($_GET['Keyword6']) ? $_GET['Keyword6'] : ''; ?>"></div>
	
			
		<div class="w3-bar w3-quarter w3-padding-xsmall">
		<input type="submit" class="w3-button w3-teal" value="Search"></div>
		</div>


</p>
<?php
$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';
$Keyword2 = isset($_GET['Keyword2']) ? $_GET['Keyword2'] : '';
$Keyword3 = isset($_GET['Keyword3']) ? $_GET['Keyword3'] : '';
$Keyword4 = isset($_GET['Keyword4']) ? $_GET['Keyword4'] : '';
$Keyword5 = isset($_GET['Keyword5']) ? $_GET['Keyword5'] : '';
$Keyword6 = isset($_GET['Keyword6']) ? $_GET['Keyword6'] : '';
$bill_name = isset($_GET['bill_name']) ? $_GET['bill_name'] : '';
$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
include "dbconnect.php";
	
	

?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">ID ลูกค้า</th>
			<th width="5%">รหัสลูกค้า AWL</th>
			<th width="5%">รหัสลูกค้า NBM</th>
			<th width="8%">ประเภทลูกค้า</th>
			<th width="10%">ชื่อลูกค้า</th>
			<th width="10%">ชื่อออกบิล</th>
			<th width="5%">VIP</th>
			<th width="8%">การชำระเงิน</th>
			<th width="10%">วงเงิน</th>
			<th width="5%">แก้ไข</th>
			
			
	</thead>
<?php
		
		
$strSQL = "SELECT *  FROM tb_customer  where credit_thb !='0.00'";

if($Keyword !=""){ 
	$strSQL .= ' AND customer_name  LIKE "%'.$Keyword.'%"'; 
	
}
if($Keyword1 !=""){ 
	$strSQL .= ' AND cus_tel  LIKE "%'.$Keyword1.'%"'; 
	}

if($Keyword2 !=""){ 
	$strSQL .= ' AND customer_code  LIKE "%'.$Keyword2.'%"'; 
	}
if($Keyword6 !=""){ 
	$strSQL .= ' AND customer_id  = "'.$Keyword6.'"'; 
	}

if($Keyword3 !=""){ 
	$strSQL .= ' AND customer_coden  LIKE "%'.$Keyword3.'%"'; 
	}
	if($Keyword4 !=""){ 
	$strSQL .= ' AND customer_no  LIKE "%'.$Keyword4.'%"'; 
	}
	if($Keyword5 !=""){ 
	$strSQL .= ' AND remark_cus  LIKE "%'.$Keyword5.'%"'; 
	}
	if($bill_name !=''){
		$strSQL .= ' AND bill_name  LIKE "%'.$bill_name.'%"'; 
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


$strSQL .=" order  by customer_id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);
		
		
		
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$sql23 = "SELECT *   FROM tb_typecustomer where type_id  = '".$objResult["type_customer"]."'";
$qry23 = mysqli_query($conn,$sql23) or die(mysqli_error());
$rs23 = mysqli_fetch_assoc($qry23);	

	
$sql24 = "SELECT pay_in FROM tb_bank where id  = '".$objResult["credit_ckk"]."'";
$qry24 = mysqli_query($code,$sql24) or die(mysqli_error());
$rs24 = mysqli_fetch_assoc($qry24);	


?>
		<tbody>
			<tr>
				<?php if($objResult["close_ckk"]=='1'){ ?>
					<td bgcolor="#FF0000">
				<?php }else{ ?>
				<td>
					<?php } ?>
				<?php echo $objResult["customer_id"];?></td>
				
				<td><?php echo $objResult["customer_code"];?></td>
				<td><?php echo $objResult["customer_coden"];?></td>
			    <td><?php echo $rs23["type_name"];?></td>
				<td><?php echo $objResult["customer_name"];?></td>
				<td><?php echo $objResult["bill_name"];?></td>
								
				
				<?php  if($objResult["vip_ckk"]=='1'){ ?>
				<td  bgcolor="#00FF00">VIP</td>
				<?php }else{ ?>
				<td></td>
				<?php } ?>

                <td><?php echo $rs24["pay_in"]; ?></td>
<td>
  <a href="javascript:void(0)"
     onclick="openCreditHistoryModal('<?php echo $objResult['customer_id']; ?>')"
     class="w3-text-blue"
     style="text-decoration: underline;">
     <?php echo number_format($objResult["credit_thb"],2); ?>
  </a>
</td>	
<td><a href="edit_customer_credit.php?customer_id=<?php echo $objResult["customer_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>
				
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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&Keyword1=$Keyword1&Keyword2=$Keyword2&Keyword3=$Keyword3&Keyword4=$Keyword4&Keyword5=$Keyword5&bill_name=$bill_name&Keyword6=$Keyword6'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&Keyword1=$Keyword1&Keyword2=$Keyword2&Keyword3=$Keyword3&Keyword4=$Keyword4&bill_name=$bill_name&Keyword5=$Keyword5&Keyword6=$Keyword6'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&Keyword1=$Keyword1&Keyword2=$Keyword2&Keyword3=$Keyword3&Keyword4=$Keyword4&bill_name=$bill_name&Keyword5=$Keyword5&Keyword6=$Keyword6'><span class='style40'>Next>></span></a> ";
	}
	
	?>
</div></div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>

</form>

<div id="creditHistoryModal" class="w3-modal">
  <div class="w3-modal-content w3-animate-top w3-card-4" style="max-width:900px;">
<header class="w3-container purple-header">
  <span onclick="closeCreditHistoryModal()" class="w3-button w3-display-topright">&times;</span>
  <h3>ประวัติการแก้ไขวงเงิน</h3>
</header>

<div class="modal-body">
  <div id="creditHistoryInfo" class="w3-small w3-text-grey"></div>
  <div id="creditHistoryLoading" class="w3-padding">กำลังโหลด...</div>

  <div id="creditHistoryTableWrap" style="display:none;">
    <div class="table-scroll">
      <table class="credit-table">
        <thead class="w3-light-grey">
          <tr>
            <th style="width:6%;">ครั้งที่</th>
            <th style="width:12%;">วันที่ขอ</th>
            <th style="width:12%;">ขอโดย</th>
            <th style="width:10%;">สถานะ</th>
            <th style="width:12%;">วันอนุมัติ</th>
            <th style="width:12%;">ผู้อนุมัติ</th>
            <th style="width:12%; text-align:right;">วงเงิน</th>
            <th class="note-col">หมายเหตุ</th>
          </tr>
        </thead>
        <tbody id="creditHistoryTbody"></tbody>
      </table>
    </div>
  </div>
</div>

<footer class="w3-container" style="padding:16px;">
  <button class="w3-button w3-grey" onclick="closeCreditHistoryModal()">ปิด</button>
</footer>

<div id="creditHistoryModal" class="w3-modal">
  <div class="w3-modal-content w3-animate-top w3-card-4" style="max-width:1000px;">
    <header class="w3-container w3-teal">
      <span onclick="closeCreditHistoryModal()" class="w3-button w3-display-topright">&times;</span>
      <h3>ประวัติการแก้ไขวงเงิน</h3>
    </header>

    <div class="w3-container" style="padding:16px;">
      <div id="creditHistoryInfo" class="w3-small w3-text-grey"></div>

      <div id="creditHistoryLoading" class="w3-padding">กำลังโหลด...</div>

      <div id="creditHistoryTableWrap" style="display:none;">
        <table class="w3-table w3-bordered w3-small">
          <thead class="w3-light-grey">
            <tr>
              <th width="6%">#</th>
              <th width="10%">ID_CUS</th>
              <th width="16%">วันที่ขอ/แก้</th>
              <th width="16%">ผู้ขอ/ผู้เพิ่ม</th>
              <th width="12%">สถานะ</th>
              <th width="16%">วันที่อนุมัติ</th>
              <th width="16%">ผู้อนุมัติ</th>
              <th width="12%">วงเงิน</th>
              <th>หมายเหตุ (Reject)</th>
            </tr>
          </thead>
          <tbody id="creditHistoryTbody"></tbody>
        </table>
      </div>
    </div>

    <footer class="w3-container" style="padding:16px;">
      <button class="w3-button w3-grey" onclick="closeCreditHistoryModal()">ปิด</button>
    </footer>
  </div>
</div>

<script>
function firstNameOnly(full){
  if(!full) return '';
  return String(full).trim().split(/\s+/)[0]; // เอาคำแรก (ตัดนามสกุล)
}

function dateOnly(dt){
  if(!dt) return '';
  return String(dt).split(' ')[0]; // เอาแค่ YYYY-MM-DD
}

function closeCreditHistoryModal(){
  const m = document.getElementById('creditHistoryModal');
  if(m) m.style.display = 'none';
}

function openCreditHistoryModal(customer_id){
  const modal = document.getElementById('creditHistoryModal');
  if(!modal){
    alert('ไม่พบ creditHistoryModal (เช็ค id ของ div modal)');
    return;
  }

  modal.style.display = 'block';
  document.getElementById('creditHistoryLoading').style.display = 'block';
  document.getElementById('creditHistoryTableWrap').style.display = 'none';
  document.getElementById('creditHistoryTbody').innerHTML = '';
  document.getElementById('creditHistoryInfo').innerHTML = '';

  fetch('credit_history.php?customer_id=' + encodeURIComponent(customer_id))
    .then(r => r.json())
    .then(data => {
      document.getElementById('creditHistoryLoading').style.display = 'none';
      if (!data.ok) { alert(data.error || 'โหลดไม่สำเร็จ'); return; }

      const nameTxt = data.customer_name ? ('<b>' + data.customer_name + '</b>') : ('<b>' + customer_id + '</b>');
      const rows = data.rows || [];

      document.getElementById('creditHistoryInfo').innerHTML =
        'ลูกค้า: ' + nameTxt + ' | แก้ไข/ทำรายการทั้งหมด <b>' + rows.length + '</b> ครั้ง';

      if (rows.length === 0) return;

      const tbody = document.getElementById('creditHistoryTbody');
      rows.forEach((row, idx) => {
        const credit = Number(row.credit_thb || 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2});

        const addDate = dateOnly(row.add_date);
        const approveDate = dateOnly(row.approve_date);

        const addBy = firstNameOnly(row.add_by);
        const approveBy = firstNameOnly(row.approve_name);

        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td class="td-nowrap">${idx+1}</td>
          <td class="td-nowrap">${addDate}</td>
          <td class="td-nowrap" title="${row.add_by || ''}">${addBy}</td>
          <td class="td-nowrap">${row.status_credit || ''}</td>
          <td class="td-nowrap">${approveDate}</td>
          <td class="td-nowrap" title="${row.approve_name || ''}">${approveBy}</td>
          <td class="td-nowrap" style="text-align:right;">${credit}</td>
          <td class="note-col">${row.note_reject || ''}</td>
        `;
        tbody.appendChild(tr);
      });

      document.getElementById('creditHistoryTableWrap').style.display = 'block';
    })
    .catch(() => {
      document.getElementById('creditHistoryLoading').style.display = 'none';
      alert('เชื่อมต่อผิดพลาด');
    });
}

// ปิดเมื่อคลิกพื้นหลัง (นอกกล่อง)
window.addEventListener('click', function(e){
  const m = document.getElementById('creditHistoryModal');
  if(m && e.target === m) closeCreditHistoryModal();
});

// ปิดด้วยปุ่ม ESC
window.addEventListener('keydown', function(e){
  if(e.key === 'Escape') closeCreditHistoryModal();
});
</script>
<script>
function closeCreditHistoryModal(){
  const m = document.getElementById('creditHistoryModal');
  if (m) m.style.display = 'none';
}

window.addEventListener('click', function(e){
  const m = document.getElementById('creditHistoryModal');
  if (m && e.target === m) closeCreditHistoryModal();
});

window.addEventListener('keydown', function(e){
  if (e.key === 'Escape') closeCreditHistoryModal();
});
</script>
</body>
</html>


