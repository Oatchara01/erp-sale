<?php
	
include("checksession.php");
include "dbconnect.php";


$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_product_snrun";
$qry = mysqli_query($com,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "SN";

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

$so = "SN";
$ref_id ="$so$nextId";


			$name = $_SESSION['name'];
			$surname = $_SESSION['surname'];
			$add_by = "$name $surname";
			$add_date = date('Y-m-d H:i:s');
			$add_code = $_SESSION['em_id'];
			$model_id = $_POST['model_id'];
			$po_no = $_POST['po_no'];
			$model_name = $_POST['model_name'];
			$date_save = date('Y-m-d');



$sql5 = "SELECT * FROM tb_model_des WHERE model_id = '$model_id' ";
$result5 = mysqli_query($com, $sql5);
$objResult5 = mysqli_fetch_array($result5);
			
$head1 = $objResult5["head1"];
$head2 = $objResult5["head2"];
$head3 = $objResult5["head3"];
$head4 = $objResult5["head4"];
$head5 = $objResult5["head5"];
$head6 = $objResult5["head6"];
$head7 = $objResult5["head7"];
$head8 = $objResult5["head8"];
$head9 = $objResult5["head9"];
$head10 = $objResult5["head10"];
$head11 = $objResult5["head11"];
$head12 = $objResult5["head12"];
$head13 = $objResult5["head13"];
$head14 = $objResult5["head14"];
$head15 = $objResult5["head15"];


$des1 = $objResult5["des1"];
$des2 = $objResult5["des2"];
$des3 = $objResult5["des3"];
$des4 = $objResult5["des4"];
$des5 = $objResult5["des5"];
$des6 = $objResult5["des6"];
$des7 = $objResult5["des7"];
$des8 = $objResult5["des8"];
$des9 = $objResult5["des9"];
$des10 = $objResult5["des10"];
$des11 = $objResult5["des11"];
$des12 = $objResult5["des12"];
$des13 = $objResult5["des13"];
$des14 = $objResult5["des14"];
$des15 = $objResult5["des15"];

$count_1 = $_POST["count_1"];	
$doc_no = $_POST["doc_no"];
$doc_no1 = $_POST["doc_no1"];

$sql1 = "insert into tb_ref_model (ref_id,model_id,model_name,add_date,add_by,po_no,date_save) values('".$ref_id."','".$model_id."','".$model_name."','".$add_date."','".$add_by."','".$po_no."','".$date_save."')";
$result1 = mysqli_query($com, $sql1);			



foreach ($count_1 as $key => $value) {

$yearMonth = substr(date("Y"), -2).date("m");
$sql2 = "SELECT MAX(running) AS MAXID FROM tb_product_snrun where year_no ='".$yearMonth."' and doc_no='".$doc_no."'";
$qry2 = mysqli_query($com,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_assoc($qry2);
$maxId = ($rs2['running'];
$maxId1 = $rs2['year_no'];

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

$product_sn = $doc_no.$yearMonth.$maxId1.$doc_no1;

$sql = "insert into tb_product_snrun (ref_id,product_sn,model_id,add_date,add_by,po_no,head1,head2,head3,head4,head5,head6,head7,head8,head9,head10,head11,head12,head13,head14,head15,des1,des2,des3,des4,des5,des6,des7,des8,des9,des10,des11,des12,des13,des14,des15) values('".$ref_id."','".$product_sn."','".$model_id."','".$add_date."','".$add_by."','".$po_no."','".$head1."','".$head2."','".$head3."','".$head4."','".$head5."','".$head6."','".$head7."','".$head8."','".$head9."','".$head10."','".$head11."','".$head12."','".$head13."','".$head14."','".$head15."','".$des1."','".$des2."','".$des3."','".$des4."','".$des5."','".$des6."','".$des7."','".$des8."','".$des9."','".$des10."','".$des11."','".$des12."','".$des13."','".$des14."','".$des15."')";
$result = mysqli_query($com, $sql);
							
						
						}


				
			}
			if($result && $result){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_barcode.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
			?>
		</div>
		<p align="center"><br />
</body>

</html>
	?>