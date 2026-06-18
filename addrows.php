<?php
require_once('dbconnect.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
</head>
  
<?php
/// ส่วนของการเพิ่ม ลบ แก้ไข ข้อมูล
if(isset($_POST['Submit'])){
      
    // ตรวจสอบค่า id หลักของข้อมูล ว่ามีข้อมูลหรือไม่
    if(isset($_POST['h_item_id']) && count($_POST['h_item_id'])>0){
        // แยกค่า id หลักของข้อมูลเดิม ถ้ามี เก็บเป็นตัวแปร array
        $h_data_id_arr=explode(",",$_POST['h_all_id_data']);
        foreach($_POST['h_item_id'] as $key_data=>$value_data){// วนลูป จัดการกับค่า id หลัก
            if($value_data==""){ // ถ้าไม่มีค่า แสดงว่า จะเป็นการเพิ่มข้อมูลใหม่
                $sql = "
                    INSERT INTO tbl_data (
                        data_id,
                        data_text,
                        data_select
                    )
                    VALUES (
                        NULL ,
                          '".$_POST['data2'][$key_data]."',
                            '".$_POST['data1'][$key_data]."'
                    );                      
                ";
                $mysqli->query($sql);
            }else{ // ถ้ามีค่าอยู่แล้ว ให้อัพเดท รายการข้อมูลเดิม โดยใช้ ค่า id หลัก
                $sql = "
                    UPDATE  tbl_data SET  
                    data_text =  '".$_POST['data2'][$key_data]."',
                    data_select =  '".$_POST['data1'][$key_data]."'
                    WHERE data_id='".$value_data."' ;                   
                ";
                $mysqli->query($sql);
            }
        }
          
        // ตรวจสอบ id หลัก ค่าเดิม และค่าใหม่ เพื่อหาค่าที่ถูกลบออกไป
        $h_data_id_arr_del = array_diff($h_data_id_arr, $_POST['h_item_id']);
        if(count($h_data_id_arr_del)>0){ // ถ้ามี array ค่า id หลัก ที่จะถูกลบ
            foreach($h_data_id_arr_del as $key_data=>$value_data){// วนลูป ลบรายการที่ไม่ต้องการ
                $sql = "
                    DELETE FROM tbl_data WHERE data_id='".$value_data."' ;   
                ";
                $mysqli->query($sql);
            }
        }
          
  
    }
}
?>
  
<br />
<br />
<br />
  
<div style="margin:auto;width:700px;">
<form id="form1" name="form1" method="post" action="">
<table id="myTbl" width="650" border="1" cellspacing="2" cellpadding="0">
<?php
$all_id_data = array();
$sql="SELECT * FROM sol__main WHERE 1 ORDER BY main_id ";
$result = mysqli_query($conn,$sql);
if(isset($result) && $result->num_rows>0){
?>
<?php
    while($row = $result->fetch_assoc()){
        $all_id_data[].=$row['data_id'];
?>
  <tr class="firstTr">
    <td width="119">
    <select name="data1[]" id="data1[]">
    <option value="">Please select</option>
    <option value="1" <?=($row['data_select']==1)?"selected":""?>>data1</option>
    <option value="2" <?=($row['data_select']==2)?"selected":""?>>data2</option>
    </select></td>
    <td width="519">
    <input name="h_item_id[]" type="hidden" id="h_item_id[]" value="<?=$row['data_id']?>" />
    <input type="text" class="text_data" name="data2[]" id="data2[]" value="<?=$row['data_text']?>" />
	<input type="text" class="text_data" name="data3[]" id="data3[]" />
	<input type="text" class="text_data" name="data4[]" id="data4[]" />
	<input type="text" class="text_data" name="data5[]" id="data5[]" />
    </td>
    </tr>
<?php } ?>    
<?php }else{ ?>
  <tr class="firstTr">
    <td width="119">
    <select name="data1[]" id="data1[]">
    <option value="">Please select</option>
    <option value="1">data1</option>
    <option value="2">data2</option>
    </select></td>
    <td width="519">
    <input name="h_item_id[]" type="hidden" id="h_item_id[]" value="" />
    <input type="text" class="text_data" name="data2[]" id="data2[]" />
	<input type="text" class="text_data" name="data3[]" id="data3[]" />
	<input type="text" class="text_data" name="data4[]" id="data4[]" />
	<input type="text" class="text_data" name="data5[]" id="data5[]" />
    </td>
    </tr>
 <?php } ?>   
</table>
<br />
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <button id="addRow" type="button">+</button>  
    &nbsp;
    <button id="removeRow" type="button">-</button>
    &nbsp;
    &nbsp;
    &nbsp;
    <input name="h_all_id_data" type="hidden" id="h_all_id_data" value="<?=implode(",",$all_id_data)?>" />    
    <input type="submit" name="Submit" id="Submit" value="Submit" /></td>
  </tr>
</table>
</form>
  
  
  
<br />
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>      
<script type="text/javascript">
$(function(){
      
    $("#addRow").click(function(){
        // ส่วนของการ clone ข้อมูลด้วย jquery clone() ค่า true คือ
        // การกำหนดให้ ไม่ต้องมีการ ดึงข้อมูลจากค่าเดิมมาใช้งาน
        // รีเซ้ตเป็นค่าว่าง ถ้ามีข้อมูลอยู่แล้ว ทั้ง select หรือ input
        $(".firstTr:eq(0)").clone(true) 
        .find("input").attr("value","").end()
        .find("select").attr("value","").end()
        .appendTo($("#myTbl"));
    });
    $("#removeRow").click(function(){
        // // ส่วนสำหรับการลบ
        if($("#myTbl tr").size()>1){ // จะลบรายการได้ อย่างน้อย ต้องมี 1 รายการ
            $("#myTbl tr:last").remove(); // ลบรายการสุดท้าย
        }else{
            // เหลือ 1 รายการลบไม่ได้
            alert("ต้องมีรายการข้อมูลอย่างน้อย 1 รายการ");
        }
    }); 
      
  
});

$("input[name='data4[]']").keyup(function() {
	var a = $("input[name='data3[]']").val();
	var b = $(this).val();
	$("input[name=\'data5[]'").val(a * b);
});

</script>
  
  
</body>
</html>