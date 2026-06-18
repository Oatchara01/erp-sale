<script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery-3.4.1.js" type="text/javascript"></script>



<link rel="stylesheet" href="css/w3.css">
<?php 
include('dbconnect.php');
$sql = "SELECT * FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";
$query = mysqli_query($conn,$sql) or die ("Error Query [".$sql."]");
?>
<table name="stock" id="stock" class="w3-table" border="0">
  <thead>

   <th>รหัสสินค้า</th>
   <th>รหัสจัดสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>รับประกัน (ปี)</th>
	<th>Cal(ครั้ง/ปี)</th>
	<th>PM (ครั้ง/ปี)</th>
    <th>หมายเหตุ</th>
	<th>หมายเลขเครื่อง</th>

  </thead>
  <tbody>
  <? 
  $i=1;
  while ($fetch=mysqli_fetch_array($query,MYSQLI_ASSOC)) { ?>
    <tr>
   <td style="width:10%;">   <input type="hidden" name="id[<?php echo $i?>]" class="w3-input w3-center" size="1%" value="<?php echo $fetch['id']; ?>">

   <input type="text" name="product_code<?=$i?>"  id="product_code<?php echo $i; ?>" class="w3-input" size="8%" value="<?php echo $fetch['sol_code'];?>" >
		
		<input type="hidden" name="product_id[<?php echo $i?>]" id="product_id[<?php echo $i?>]" class="w3-input w3-center" size="1%" value="<?php echo $fetch['product_id']; ?>">
		</td>
   <td style="width:10%;">
   <input type="hidden" name="product_code_1[<?php echo $i?>]"  id="product_code_1[<?php echo $i?>]" class="w3-input" size="8%" value="<?php echo $fetch['product_code'];?>" readonly>

   <input name="product_code_same[<? echo $i?>]" value="<?php echo $fetch['code_same'];?>" id="product_code_same<?=$i?>" type="text" class="w3-input" size="8%" onblur="JavaScript:fncAlert([<? echo $i?>]);"></td>



<td style="width:15%;"><textarea name = "product_name[<?php echo $i?>]"   id = "product_name[<?php echo $i?>]"  class="w3-input" readonly><?php echo $fetch["sol_name"];?> <?php echo $fetch["sale_remark"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[<?php echo $i?>]" value="<?php echo $fetch["unit_name"];?>" id = "unit_name[<?php echo $i?>]"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "sale_count[]<?php echo $fetch["id"];?>" value="<?php echo $fetch["count"];?>" id = "sale_count[]<?php echo $fetch["id"];?>"  class="w3-input" style="color:black;text-align:center"    readonly/></td>


<td style="width:5%;"><input type='text' name = "warranty[]<?php echo $fetch["id"];?>" value="<?php echo $fetch["warranty"];?>" id = "warranty[]<?php echo $fetch["id"];?>"  class="w3-input"  OnKeyPress="return chkNumber(this)" readonly/></td>

<td style="width:5%;"><input type='text' name = "cal[]<?php echo $fetch["id"];?>" value="<?php echo $fetch["cal"];?>" id = "cal[]<?php echo $fetch["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)" readonly/></td>

<td style="width:5%;"><input type='text' name = "pm[]<?php echo $fetch["id"];?>" value="<?php echo $fetch["pm"];?>" id = "pm[]<?php echo $fetch["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)" readonly/></td>

<td style="width:10%;">


<input type='text' name = "stock_remark[<? echo $i?>]"  id = "stock_remark[<? echo $i?>]" value="<?php echo $fetch["stock_remark"];?>" class="w3-input" />

</td>
<td style="width:10%;" >
<textarea name = "sn[<? echo $i?>]"  id = "sn[<? echo $i?>]"  class="w3-input" ><?php echo $fetch["sn"];?></textarea>

</td>
</tr>


 <?
   $i++;
      }
    ?>
            <input name="hdnCount2" id="hdnCount2" value="<?php echo $i; ?>" type="hidden"> 
			
  </tbody>
</table>

<script type="text/javascript">
   
    var i=1;
    var a = $('#hdnCount2').val();
    var b = $('#c2').val();

  for(i=b;i<=a;i++)
  {
   aa= i;
  }
  var test = aa;
            function ShowBrand(1) {
  alert('aa');
  
                var val1 = $('#product_code'+test).val();
       var val2 = $('#product_code_same'+test).val();
  if(val1 != val2){
       alert("ข้อมูลไม่ตรงค่ะ");
    $('#product_code_same'+test).focus();
    return false;
  }
  
             
   
        </script>
		<script language="javascript">
		    var i=1;
    var a = $('#hdnCount2').val();
    var b = $('#c2').val();

  for(i=b;i<=a;i++)
  {
   aa= i;
  }
   var test = aa;
function fncAlert(test)

{
	 var val1 = $('#product_code'+test).val();
       var val2 = $('#product_code_same'+test).val();
 if(val1 != val2){
	alert("ข้อมูลไม่ตรงค่ะ!");
$('#product_code_same'+test).val();
    return false;
 }
}
</script>