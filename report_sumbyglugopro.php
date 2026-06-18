<?php
include "head.php";
include "dbconnect.php";
include "dbconnect_sale.php";

// แสดง error ช่วย debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// รับค่าจาก GET
$start_date = $_GET["start_date"] ?? '';
$end_date = $_GET["end_date"] ?? '';
$sale_code = $_GET["sale_code"] ?? '';
$customer_name = $_GET["customer_name"] ?? '';
$h_bill_id = $_GET["h_bill_id"] ?? '';
$bill_id = $_GET["bill_id"] ?? '';

if($_SESSION["name"]=='พรรณิภา'){
$code = " AND sale_code REGEXP 'S14|S15|S16|S21|S22' ";	
}else if($_SESSION["name"]=='นรินทิพย์'){
$code = " AND sale_code REGEXP 'S11|S12|S13|S24' ";			
}else{
$code = "";		
}


?>

<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายงานยอดขาย Gluco All-Pro</h4></div>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
 <div class="w3-row" style="display: flex; gap: 10px;">
    <div class="w3-third" style="flex: 1;">
      วันที่ :
      <input name="start_date" class="w3-input" style="width:90%;" type="date" value="<?php echo $start_date; ?>" >
    </div>
    <div class="w3-third" style="flex: 1;">
      ถึง :
      <input name="end_date" class="w3-input" style="width:90%;" type="date" value="<?php echo $end_date; ?>" >
    </div>
    <div class="w3-third" style="flex: 1;">
      เขตการขาย :
		
		<?php 
	if ($_SESSION['code']=='SS1'){
	?>
		
		<select name="sale_code" style="width:90%;" class="w3-input">
        <option value="">**Please Select**</option>
        <?php
        $strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
        $objQuery5 = mysqli_query($com, $strSQL5);
        while($row = mysqli_fetch_assoc($objQuery5)) {
          $selected = ($sale_code == $row["sale_code"]) ? "selected" : "";
          echo "<option value='{$row["sale_code"]}' $selected>{$row["sale_code"]} - {$row["sale_name"]}</option>";
        }
        ?>
      </select>
		<?php
}else 	if ($_SESSION['code']=='SS2'){

	?>
		
      <select name="sale_code" style="width:90%;" class="w3-input">
        <option value="">**Please Select**</option>
        <?php
        $strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
        $objQuery5 = mysqli_query($com, $strSQL5);
        while($row = mysqli_fetch_assoc($objQuery5)) {
          $selected = ($sale_code == $row["sale_code"]) ? "selected" : "";
          echo "<option value='{$row["sale_code"]}' $selected>{$row["sale_code"]} - {$row["sale_name"]}</option>";
        }
        ?>
      </select>
		
		<?php }else{ ?>
		
		 <select name="sale_code" style="width:90%;" class="w3-input">
        <option value="">**Please Select**</option>
        <?php
        $strSQL5 = "SELECT * FROM tb_team_all where ckk='0' ORDER BY sale_code ASC";
        $objQuery5 = mysqli_query($com, $strSQL5);
        while($row = mysqli_fetch_assoc($objQuery5)) {
          $selected = ($sale_code == $row["sale_code"]) ? "selected" : "";
          echo "<option value='{$row["sale_code"]}' $selected>{$row["sale_code"]} - {$row["sale_name"]}</option>";
        }
        ?>
      </select>
		
		<?php } ?>
		
    </div>
<div class="w3-third" style="flex: 1;">
      ลูกค้า :
      <input name="bill_id" style="width:90%;" type="text" class="w3-input w3-light-gray" value="<?php echo $bill_id; ?>">
      <input type='hidden' name = "h_bill_id"  id = "h_bill_id" value="<?php echo $h_bill_id; ?>" class="button4" readonly>

    </div>
    <div class="w3-third" style="flex: 1;">
      <input type="submit" value="Search" class="w3-button w3-pale-red">
    </div>
  </div>
</form>

<?php
if($start_date || $end_date || $sale_code || $h_bill_id){
  $sql = "
    SELECT DISTINCT hos__so.ref_id 
    FROM hos__so 
    LEFT JOIN hos__subso ON hos__subso.ref_idd = hos__so.ref_id 
    LEFT JOIN tb_product ON tb_product.product_id = hos__subso.product_id 
    WHERE hos__so.status_doc = 'Approve' 
      AND group1 = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL' 
      AND (sol_name LIKE '%GLUCOALL-PRO%' OR sol_name LIKE '%ALLSAFE-PLUS%') $code
  ";

  if ($start_date) $sql .= " AND iv_date >= '$start_date'";
  if ($end_date) $sql .= " AND iv_date <= '$end_date'";
  if ($sale_code) $sql .= " AND sale_code = '$sale_code'";
  if ($h_bill_id) $sql .= " AND bill_id = '$h_bill_id'";

  $sql .= " ORDER BY iv_date ASC";
  $result = mysqli_query($conn, $sql) or die("Error Query: $sql");

  $total_amount = 0;
?>

<br>
<table border="1" width="100%" class="w3-table">
  <thead class="w3-gray">
    <tr>
      <th width="5%">เลขที่อ้างอิง</th>
      <th width="8%">วันที่ออกเอกสาร</th>
      <th width="8%">เลขที่เอกสาร</th> 
      <th width="10%">ชื่อลูกค้า</th>
      <th width="15%">รายการสินค้า</th>
      <th width="8%">ราคารวม</th>
      <th width="8%">เขตการขาย</th>
    </tr>
  </thead>

  <tbody>
<?php
  while($row = mysqli_fetch_assoc($result)) {
    $ref_id = $row["ref_id"];
    $q1 = mysqli_query($conn, "SELECT * FROM hos__so WHERE ref_id = '$ref_id'");
    $so = mysqli_fetch_assoc($q1);

    echo "<tr>";
    echo "<td>{$so["ref_id"]}</td>";
    echo "<td>" . Datethai($so["iv_date"]) . "</td>";
    echo '<td><a href="register_adminhos_edit.php?ref_id=' . $so["ref_id"] . '" target="_blank">' . $so["iv_no"] . '</a></td>';


    echo "<td><div align='left'>{$so["bill_name"]}</div></td>";

    // แสดงรายการสินค้า
    echo "<td><div align='left'>";
    $q2 = mysqli_query($conn, "
      SELECT sol_name 
      FROM hos__subso 
      LEFT JOIN tb_product ON hos__subso.product_ID = tb_product.product_id 
      WHERE ref_idd = '$ref_id' AND group1 = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL' 
    ");
    while($product = mysqli_fetch_assoc($q2)) {
      echo "{$product["sol_name"]}<br>";
    }
    echo "</div></td>";

    // คำนวณราคารวม
    $q3 = mysqli_query($conn, "
      SELECT SUM(amount) AS total 
      FROM hos__subso 
      LEFT JOIN tb_product ON hos__subso.product_ID = tb_product.product_id 
      WHERE ref_idd = '$ref_id' AND group1 = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL'
    ");
    $total = mysqli_fetch_assoc($q3)["total"];
    $total_amount += $total;
    ?><td ><div align="right"><?php echo number_format($total, 2); ?> </div></td>

<?php
	  
	     echo "<td>{$so["sale_code"]}</td>";
    echo "</tr>";
   }
?>
    <tr>
      <td colspan="4"></td>
      <td bgcolor="yellow"><strong>ยอดรวม</strong></td>
      <td bgcolor="yellow" ><div align="right"><strong><?php echo number_format($total_amount, 2); ?></strong></div></td>
      <td></td>
    </tr>
  </tbody>
</table>
<?php } ?>
</div>
</div>

<div id="cr_bar"><?php include "foot.php"; ?></div>

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
		return "data_billrp_name.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
make_autocom("bill_id","h_bill_id");
</script> 
