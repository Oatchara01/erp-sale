
<?php
include("dbconnect.php");
include("dbconnect_acc.php");	
include("dbconnect_cs.php");
include("head.php");

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = trim($_POST["ref_id"]);
$bill_name = $_POST["bill_name"];
$date_so = $_POST["date_so"];
$bill_address = $_POST["bill_address"];
$bill_tel = $_POST["bill_tel"];
$full_bill = $_POST["full_bill"];
$type_doc = $_POST["type_doc"];	
$tax_id = $_POST["tax_id"];
$mode_cus = $_POST["mode_name"];
$date_so = $_POST["date_so"];
$suggest = $_POST["suggest"];
$payment = $_POST["payment"];
$sr_no = $_POST["sr_no"];
$sale = $_POST["sale"];
$sale_comment = $_POST["sale_comment"];
$po_no = $_POST["po_no"];
$que_ckk = $_POST["que_ckk"];
$delivery_contract = $_POST["delivery_contract"];
$book_clear = $_POST["book_clear"];
$book_no = $_POST["book_no"];
$brn_clear = $_POST["brn_clear"];
$brn_no = $_POST["brn_no"];
$brnp_clear = $_POST["brnp_clear"];
$brnp_no = $_POST["brnp_no"];
$sn_ckk = $_POST["sn_ckk"];
$sn_no = $_POST["sn_no"];
$pre_name = $_POST["pre_name"];
$install_place = $_POST["address_send"];
$with_pr = $_POST["with_pr"];
$type_type = $_POST["type_type"];
$type_detail = $_POST["type_detail"];
$delivery_type = $_POST["delivery_type"];
$delivery_date = $_POST["start_date"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$delivery_time = "$start_time $end_time";
$delivery_address = $_POST["address_name"];
$delivery_contact = $_POST["customer_name"];
$delivery_tel = $_POST["customer_tel"];
$payment_des  = $_POST["payment_des"];
$send_cs  = $_POST["send_cs"];
$bill_id  = $_POST["bill_id"];
$status_doc = $_POST["status_doc"];
$cash_ckk = $_POST["cash_ckk"];
$ckk_showwar = $_POST["ckk_showwar"];
$send_receipt = $_POST["send_receipt"];	
if($_POST["date_tranfer"] !=''){	
$date_tranfer = $_POST["date_tranfer"];	
}else{
$date_tranfer = "0000-00-00";	
}
$admin_date= date('Y-m-d H:i:s');
$admin =  $_SESSION['name'];
$admin_code =  $_SESSION['code'];
$send_stock = $_POST['send_stock'];
$sale_code = $_POST['sale_code'];
$have_order  = $_POST["have_order"];
$bill_send = $_POST["bill_send"];
$send_edit = $_POST["send_edit"];
$des_stock = $_POST["des_stock"];
$remark_cancel = $_POST["remark_cancel"];
$pr_no  = $_POST["pr_no"];
$add_date = date('Y-m-d H:i:s');
$date_edit = date('Y-m-d');
$surname =	$_SESSION['surname'];
$name =	$_SESSION['name'];
$add_by = "$name $surname";
$em_id =	$_SESSION['emid'];
$ckkwar_pro = $_POST["ckkwar_pro"];
$run_et = $_POST["run_et"];	
$email = $_POST["email"];
$desnew_bill = $_POST["desnew_bill"];	
$run_id = $_POST["run_id"];	
$complete_adckk = $_POST["complete_adckk"];	
$cls_desad = $_POST["cls_desad"];	
$iv_date = $_POST["iv_date"];	
$et_ckk = $_POST["et_ckk"];	
//echo $tax_id;
	//exit();
	
if($run_et=='1' and $email==''){	
echo "<script language=\"JavaScript\">";
echo "alert('กรุณากรอกข้อมูลอีเมลล์ให้เรียบร้อยก่อนรันเลขที่่เอกสารค่ะ!!!!!!!!! ขอบคุณค่ะ');window.location='register_adminhos_edit.php?ref_id=$ref_id';";
echo "</script>";	
exit();	
}	
	
if($run_et=='1' and $tax_id==''){	
echo "<script language=\"JavaScript\">";
echo "alert('กรุณากรอกข้อมูลเลขผู้เสียภาษีให้เรียบร้อยก่อนรันเลขที่่เอกสารค่ะ!!!!!!!!! ขอบคุณค่ะ');window.location='register_adminhos_edit.php?ref_id=$ref_id';";
echo "</script>";	
exit();	
}	
	
$doc = substr($_POST["iv_no"],0,2);	
	
if($doc=='ET' and $email==''){	
echo "<script language=\"JavaScript\">";
echo "alert('กรุณากรอกข้อมูลอีเมลล์ให้เรียบร้อยค่ะ!!!!!!!!! ขอบคุณค่ะ');window.location='register_adminhos_edit.php?ref_id=$ref_id';";
echo "</script>";	
exit();	
}	
	
if($doc=='ET' and $tax_id==''){	
echo "<script language=\"JavaScript\">";
echo "alert('กรุณากรอกข้อมูลเลขผู้เสียภาษีให้เรียบร้อยค่ะ!!!!!!!!! ขอบคุณค่ะ');window.location='register_adminhos_edit.php?ref_id=$ref_id';";
echo "</script>";	
exit();	
}	
		
/*if($po_no!=''){	
$strSQL23 = "SELECT * FROM hos__so WHERE po_no = '".$po_no."'";
$objQuery23 = mysqli_query($conn,$strSQL23);
$num = mysqli_num_rows($objQuery23);

if($num > 0){	
echo "<script language=\"JavaScript\">";
echo "alert('PO เลขที่ $po_no มีการบันทึกข้อมูลไปแล้วค่ะ');window.location='register_adminhos_edit.php?ref_id=$ref_id';";
echo "</script>";
exit();
	
}	
}*/
	
	

$head_1 = $_POST["head_1"];	
$ref_1 = $_POST["ref_1"];	
$ref_2 = $_POST["ref_2"];	
$ref_3 = $_POST["ref_3"];	
$ref_4 = $_POST["ref_4"];	
$ref_5 = $_POST["ref_5"];	
$ref_6 = $_POST["ref_6"];	
$ref_7 = $_POST["ref_7"];	
$ref_8 = $_POST["ref_8"];	
$ref_9 = $_POST["ref_9"];	
$ref_10 = $_POST["ref_10"];	
$ref_11 = $_POST["ref_11"];
$ref_12 = $_POST["ref_12"];	
$ref_13 = $_POST["ref_13"];
$ref_des = $_POST["ref_des"];	
$plan_ckk = $_POST["plan_ckk"];	
	
$ic_ckk = $_POST["ic_ckk"];	
	

$date_oldbill = $_POST["date_oldbill"];	
$new_bill = $_POST["new_bill"];	
	
 if ($_FILES['slip1']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip1']['name']!=''){
$temp1 = explode(".", $_FILES["slip1"]["name"]);
$slip1 = "slip1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["slip1"]["tmp_name"], "upload/" . $slip1);
}else{
 $slip1 = $_POST["slip1"];

}

 if ($_FILES['slip2']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip2']['name']!=''){
$temp2 = explode(".", $_FILES["slip2"]["name"]);
$slip2 = "slip2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["slip2"]["tmp_name"], "upload/" . $slip2);
}else{
 $slip2 = $_POST["slip2"];

}

 if ($_FILES['slip3']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip3']['name']!=''){
$temp3 = explode(".", $_FILES["slip3"]["name"]);
$slip3 = "slip3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["slip3"]["tmp_name"], "upload/" . $slip3);
}else{
 $slip3 = $_POST["slip3"];

}

 if ($_FILES['slip4']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip4']['name']!=''){
$temp4 = explode(".", $_FILES["slip4"]["name"]);
$slip4 = "slip4" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp4);
move_uploaded_file($_FILES["slip4"]["tmp_name"], "upload/" . $slip4);
}else{
 $slip4 = $_POST["slip4"];

}

 if ($_FILES['slip5']['size'] > 1100000) {
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}else if($_FILES['slip5']['name']!=''){
$temp5 = explode(".", $_FILES["slip5"]["name"]);
$slip5 = "slip5" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp5);
move_uploaded_file($_FILES["slip5"]["tmp_name"], "upload/" . $slip5);
}else{
 $slip5 = $_POST["slip5"];

}


$id = $_POST["id"];
$sale_count = $_POST["sale_count"];
$countref = $_POST["countref"];
$product_price = $_POST["product_price"];
$price_ref = $_POST["price_ref"];
$sum_amount = $_POST["sum_amount"];
$sale_remarkk = $_POST["sale_remarkk"];
$warranty =$_POST["warranty"];
 $pm=$_POST["pm"];
 $cal=$_POST["cal"];
 $sn=$_POST["sn"];
 $product_id = $_POST["product_id"];
 $discount_unit = $_POST["discount_unit"];
$clear_ivno  = $_POST["clear_ivno"];	
$clear_br  = $_POST["clear_br"];
$delete_ckk = $_POST["delete_ckk"];	
$run_ic = $_POST["run_ic"];	
	
	

	
	
if($run_ic=='1'){
	if($type_doc =='3'){
	
$date = explode('-' , $_POST["iv_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_ic_awl where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "IC";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;


$iv_no = $so.$year1.$mont.$nextId;	
		
$save5="insert into tb_ic_awl (doc_no,year_no,mount_no,run_no,iv_date) values ('".$iv_no."','".$year1."','".$mont."','".$nextId."','".$iv_date."')";
$qsave5=mysqli_query($conn,$save5);
		
		
	}else if($type_doc =='4'){
		
$date = explode('-' , $_POST["iv_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_ic_nbm where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "IC";
$so1 = "/";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$iv_no = $so.$year1.$so1.$mont.$nextId;

$save="insert into tb_ic_nbm (doc_no,year_no,mount_no,run_no,iv_date) values ('".$iv_no."','".$year1."','".$mont."','".$nextId."','".$iv_date."')";
$qsave=mysqli_query($conn,$save);
		
	}
}else if($run_et=='1'){
	if($type_doc =='3'){
	
$date = explode('-' , $_POST["iv_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_et_awl where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ET";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;


$iv_no = $so.$year1.$mont.$nextId;	
		
$save5="insert into tb_et_awl (doc_no,year_no,mount_no,run_no,iv_date) values ('".$iv_no."','".$year1."','".$mont."','".$nextId."','".$iv_date."')";
$qsave5=mysqli_query($conn,$save5);
		
		
	}else if($type_doc =='4'){
		
$date = explode('-' , $_POST["iv_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_et_nbm where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ET";
$so1 = "-";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$iv_no = $so.$year1.$so1.$mont.$nextId;

$save="insert into tb_et_nbm (doc_no,year_no,mount_no,run_no,iv_date) values ('".$iv_no."','".$year1."','".$mont."','".$nextId."','".$iv_date."')";
$qsave=mysqli_query($conn,$save);
		
	}
}else if($run_id=='1'){
	if($type_doc =='3'){
	
$date = explode('-' , $_POST["iv_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_doc_ptl where mount_no ='".$mont."' and year_no = '".$year1."'";
			
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "IE";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;


$iv_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_doc_ptl (doc_no,year_no,mount_no,run_no,iv_date,ref_so) values ('".$iv_no."','".$year1."','".$mont."','".$nextId."','".$_POST["iv_date"]."','".$ref_id."')";
$qsave5=mysqli_query($conn,$save5);
		
		
	}else if($type_doc =='4'){
		
$date = explode('-' , $_POST["iv_date"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_doc_nbm where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "IE";
$so1 = "/";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$iv_no = $so.$year1.$so1.$mont.$nextId;

$save="insert into tb_doc_nbm (doc_no,year_no,mount_no,run_no,iv_date,ref_so) values ('".$iv_no."','".$year1."','".$mont."','".$nextId."','".$_POST["iv_date"]."','".$ref_id."')";
$qsave=mysqli_query($conn,$save);
		
	}
}	else{
$iv_no = $_POST["iv_no"];
}	
	
if($type_doc =='3'){
$save19="UPDATE tb_et_awl SET ref_so ='".$ref_id."' where doc_no='".$iv_no."'";
$qsave19=mysqli_query($conn,$save19);	
	
}else if($type_doc =='4'){
	
$save19="UPDATE tb_et_nbm SET ref_so ='".$ref_id."' where doc_no='".$iv_no."'";
$qsave19=mysqli_query($conn,$save19);	
}
	
	
	

	
		
	

$iv_date = $_POST["iv_date"];
$dep_no  = $_POST["dep_no"];
$job_no  = $_POST["job_no"];
$order_no   = $_POST["order_no"];
$date_ker = $_POST["date_ker"];
$order_refer_code = $_POST["order_refer_code"];
$order_refer_code1 = $_POST["order_refer_code1"];
$ker_bath = $_POST["ker_bath"];
$cm_no = $_POST["cm_no"];	
$line_stock = $_POST["line_stock"];	
	
	if($line_stock !=''){
		
		
$save8 = "insert into tb_editdocline
(ref_id,line_stock,add_by,add_date) values ('".$ref_id."','".$line_stock."','".$add_by."','".$add_date."')";
$qsave8=mysqli_query($conn,$save8);
	}	
	

$save="Update  hos__so set
bill_name ='".$bill_name."',bill_address  ='".$bill_address."',full_bill ='".$full_bill."',date_so ='".$date_so."',suggest ='".$suggest."',payment ='".$payment."',sale_comment ='".$sale_comment."',po_no ='".$po_no."',delivery_contract ='".$delivery_contract."',book_clear ='".$book_clear."',book_no ='".$book_no."',brn_clear ='".$brn_clear."',brn_no ='".$brn_no."',brnp_clear ='".$brnp_clear."',brnp_no ='".$brnp_no."',sn_ckk ='".$sn_ckk."',sn_no ='".$sn_no."',install_place ='".$install_place."',with_pr ='".$with_pr."',type_type ='".$type_type."',type_detail ='".$type_detail."',delivery_type ='".$delivery_type."',delivery_date ='".$delivery_date."',delivery_time ='".$delivery_time."',delivery_address ='".$delivery_address."',delivery_contact ='".$delivery_contact."',delivery_tel ='".$delivery_tel."',pr_no ='".$pr_no."',payment_des ='".$payment_des."',slip1 = '".$slip1."',slip2 = '".$slip2."',slip3 = '".$slip3."',slip4 = '".$slip4."',slip5 = '".$slip5."',iv_no='".$iv_no."',iv_date='".$iv_date."',dep_no='".$dep_no."',job_no='".$job_no."',admin ='".$admin."',admin_date ='".$admin_date."',bill_id = '".$bill_id."',admin_code = '".$admin_code."',have_order='".$have_order."',order_no = '".$order_no."',sale_code='".$sale_code."',send_stock = '".$send_stock."',tax_id = '".$tax_id."',cash_ckk = '".$cash_ckk."',date_tranfer = '".$date_tranfer."',bill_send='".$bill_send."',sr_no='".$sr_no."',date_ker='".$date_ker."',order_refer_code='".$order_refer_code."',order_refer_code1='".$order_refer_code1."',ker_bath = '".$ker_bath."',cm_no='".$cm_no."',pre_name='".$pre_name."',que_ckk='".$que_ckk."',ckkwar_pro='".$ckkwar_pro."',ckk_showwar='".$ckk_showwar."',remark_cancel='".$remark_cancel."',head_2='".$head_1."',bill_tel='".$bill_tel."',mode_cus='".$mode_cus."',plan_ckk='".$plan_ckk."',new_bill='".$new_bill."',date_oldbill='".$date_oldbill."',email='".$email."',desnew_bill='".$desnew_bill."',ic_ckk='".$ic_ckk."',et_ckk='".$et_ckk."'  where ref_id='".$ref_id."'";

$qsave=mysqli_query($conn,$save);
	
	
if($complete_adckk=='1'){
	
/*$save57="Update tb_comment_so  SET $complete_adckk='2',name_ad='".$add_by."',date_ad='".$add_date."',cls_desad='".$cls_desad."' where  ref_id ='".$ref_id."'";
$qsave57=mysqli_query($conn,$save57);*/	
	
}
	
	
	
	
if($book_no !=''){
	
$strSQL = "SELECT ref_id FROM hos__jongproduct WHERE iv_no = '".$book_no."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
$remark_jong ="เปิดใบสั่งขายเลขที่อ้างอิง $ref_id";
	
$save2="UPDATE  hos__jongproduct SET close_jong='1',remark='".$remark_jong."'  where ref_id = '".$objResult["ref_id"]."'";
$qsave2=mysqli_query($conn,$save2);	
	
$save3="UPDATE hos__subjongpro SET close_ckk='1'  where ref_idd = '".$objResult["ref_id"]."'";
$qsave3=mysqli_query($conn,$save3);		

}	
	

if($cm_no !=''){
if($type_doc=='3'){
	
$save19="UPDATE tb_service_order SET iv_no ='".$iv_no."' where ref_so = '".$ref_id."'";
$qsave19=mysqli_query($service,$save19);	
}else if($type_doc=='4'){
	
$save19="UPDATE tb_service_order SET iv_no ='".$iv_no."' where ref_so = '".$ref_id."'";
$qsave19=mysqli_query($servicenb,$save19);		
}
}
	
	
	
$save56="Update tb_other_bill SET
head_1='".$head_1."',ref_1='".$ref_1."',ref_2='".$ref_2."',ref_3='".$ref_3."',ref_4='".$ref_4."',ref_5='".$ref_5."',ref_6='".$ref_6."',ref_7='".$ref_7."',ref_8='".$ref_8."',ref_9='".$ref_9."',ref_10='".$ref_10."',ref_11='".$ref_11."',ref_des='".$ref_des."',ref_12='".$ref_12."',ref_13='".$ref_13."' where  ref_id ='".$ref_id."'";
$qsave56=mysqli_query($conn,$save56);	
	
	
$id_ref = $_POST["id_ref"];	
$customer_nameb = $_POST["customer_nameb"];
$customer_telb = $_POST["customer_telb"];
$address_nameb = $_POST["address_nameb"];

if($id_ref!='' and $customer_nameb !=''){	
	
$save8="Update  tb_delivery_bill set customer_nameb='".$customer_nameb."',customer_telb='".$customer_telb."',address_nameb='".$address_nameb."'  where ref_id='".$ref_id."'";
$qsave8=mysqli_query($conn,$save8);	
}else if($customer_nameb !=''){

	
$save8 = "insert into tb_delivery_bill
(ref_id,customer_nameb,customer_telb,address_nameb) values ('".$ref_id."','".$customer_nameb."','".$customer_telb."','".$address_nameb."')";
$qsave8=mysqli_query($conn,$save8);	
	
}	
	
	
	/*if($send_edit !=''){
	$save2="Update  hos__so set  status_stock='0',stock='',des_stock = '".$des_stock."'  where ref_id='".$ref_id."'";
$qsave2=mysqli_query($conn,$save2);
	}*/
	
$strSQL72 = "SELECT ref_iddoc FROM hos__proreceive WHERE ref_iddoc = '".$ref_id."' ";
$objQuery72 = mysqli_query($conn,$strSQL72) or die ("Error Query [".$strSQL72."]");
$Num_Rows72 = mysqli_num_rows($objQuery72);
$rs72 = mysqli_fetch_assoc($objQuery72);	

	if($Num_Rows72 > 0){
	
$strSQL5 = "Update   hos__proreceive set iv_noref='".$iv_no."'   Where ref_iddoc = '".$ref_id."' ";
$objQuery5 = mysqli_query($conn,$strSQL5);		
		
	}
	



  foreach($id as $key =>$value)
	{
	  $id_new=$id[$key];
	  $countref_new = $countref[$key];
	  $sale_count_new=$sale_count[$key];
	  $product_price1=$product_price[$key];
	  $product_price_new=str_replace(',','', $product_price1);
	  $sale_remarkk_new=$sale_remarkk[$key];
	  $warranty_new=$warranty[$key];
	  $pm_new=$pm[$key];
	  $cal_new=$cal[$key];
	  $sn_new=$sn[$key];
	  $countref_new =$cal[$key];
	  $price_ref_new = $price_ref[$key];
      $product_id_new =$product_id[$key];
	  $clear_ivno_new =$clear_ivno[$key];
	  $clear_br_new=$clear_br[$key];
      $discount_unit1 =$discount_unit[$key];
	  $delete_ckk_new = $delete_ckk[$key];
      $discount_unit_new=str_replace(',','', $discount_unit1);
	  $sum_amount_new = ($product_price_new - $discount_unit_new)*$sale_count_new;
		 


$strSQL = "Update   hos__subso set ref_idd='$ref_id',count='$sale_count_new',countref = '$countref_new',price='$product_price_new',amount='$sum_amount_new',sale_remark='$sale_remarkk_new',warranty='$warranty_new',pm='$pm_new',cal='$cal_new',product_id='$product_id_new',product_code ='$product_id_new',discount ='$discount_unit_new',ckk_order='".$have_order."',clear_ivno='".$clear_ivno_new."',clear_br='".$clear_br_new."',sn='".$sn_new."'   Where id= '$id_new' ";

$objQuery = mysqli_query($conn,$strSQL);

if($delete_ckk_new=='1'){

$strSQL5 = "DELETE FROM hos__subso WHERE id = '".$id_new."'";
$objQuery5 = mysqli_query($conn,$strSQL5);
	
}	  
	  
	  
	  
$strSQL2 ="SELECT research_ckk FROM tb_product WHERE product_ID = '".$product_id_new."' ";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2=mysqli_fetch_array($objQuery2);
		  
$strSQL5 = "Update   hos__so set reseach_kk='".$objResult2["research_ckk"]."'   Where ref_id= '".$ref_id."' ";
$objQuery5 = mysqli_query($conn,$strSQL5);		
	  
}
	


$sql66 = "SELECT send_erpst   FROM hos__so where ref_id = '".$ref_id."'";
$qry66 = mysqli_query($conn,$sql66) or die(mysqli_error());
$rs66 = mysqli_fetch_assoc($qry66);
	
if($rs66['send_erpst']=='0'){

$product_name6 = $_POST["product_name6"];
$unit_name6 = $_POST["unit_name6"];
$product_id6 = $_POST["product_id6"];
$sale_count6 = $_POST["sale_count6"];
$product_price6 = $_POST["product_price6"];
$sale_remarkk6 = $_POST["sale_remarkk6"];
$sum_amountt6 = $_POST["sum_amount6"];
$sum_amount6= str_replace(',','', $sum_amountt6);
$discount_unit6 = $_POST["discount_unit6"];
$warranty6  = $_POST["warranty6"];
$cal6 = $_POST["cal6"];
$pm6 = $_POST["pm6"];
	
if($_POST["product_code6"]!=''){
$product_code6 = $_POST["product_code6"];
}else if($_POST["product_codet6"]!=''){
$product_code6 = $_POST["product_codet6"];
}else{
$product_code6 = $_POST["product_c6"];	
}


$product_name7 = $_POST["product_name7"];
$unit_name7 = $_POST["unit_name7"];
$product_id7 = $_POST["product_id7"];
$sale_count7 = $_POST["sale_count7"];
$product_price7 = $_POST["product_price7"];
$sale_remarkk7 = $_POST["sale_remarkk7"];
$sum_amountt7 = $_POST["sum_amount7"];
$sum_amount7= str_replace(',','', $sum_amountt7);
$discount_unit7 = $_POST["discount_unit7"];
$warranty7  = $_POST["warranty7"];
$cal7 = $_POST["cal7"];
$pm7 = $_POST["pm7"];

if($_POST["product_code7"]!=''){
$product_code7 = $_POST["product_code7"];
}else if($_POST["product_codet7"]!=''){
$product_code7 = $_POST["product_codet7"];
}else{
$product_code7 = $_POST["product_c7"];	
}
	
	
$product_id8 = $_POST["product_id8"];
$sale_count8 = $_POST["sale_count8"];
$product_price8 = $_POST["product_price8"];
$sale_remarkk8 = $_POST["sale_remarkk8"];
$sum_amountt8 = $_POST["sum_amount8"];
$sum_amount8= str_replace(',','', $sum_amountt8);
$discount_unit8 = $_POST["discount_unit8"];
$warranty8  = $_POST["warranty8"];
$cal8 = $_POST["cal8"];
$pm8 = $_POST["pm8"];
if($_POST["product_code8"]!=''){
$product_code8 = $_POST["product_code8"];
}else if($_POST["product_codet8"]!=''){
$product_code8 = $_POST["product_codet8"];
}else{
$product_code8 = $_POST["product_c8"];	
}


$product_id9 = $_POST["product_id9"];
$sale_count9 = $_POST["sale_count9"];
$product_price9 = $_POST["product_price9"];
$sale_remarkk9 = $_POST["sale_remarkk9"];
$sum_amountt9 = $_POST["sum_amount9"];
$sum_amount9= str_replace(',','', $sum_amountt9);
$discount_unit9 = $_POST["discount_unit9"];
$warranty9  = $_POST["warranty9"];
$cal9 = $_POST["cal9"];
$pm9 = $_POST["pm9"];
if($_POST["product_code9"]!=''){
$product_code9 = $_POST["product_code9"];
}else if($_POST["product_codet9"]!=''){
$product_code9 = $_POST["product_codet9"];
}else{
$product_code9 = $_POST["product_c9"];	
}

$product_id10 = $_POST["product_id10"];
$sale_count10 = $_POST["sale_count10"];
$product_price10 = $_POST["product_price10"];
$sale_remarkk10 = $_POST["sale_remarkk10"];
$sum_amountt10 = $_POST["sum_amount10"];
$sum_amount10= str_replace(',','', $sum_amountt10);
$discount_unit10 = $_POST["discount_unit10"];
$warranty10  = $_POST["warranty10"];
$cal10 = $_POST["cal10"];
$pm10 = $_POST["pm10"];

if($_POST["product_code10"]!=''){
$product_code10 = $_POST["product_code10"];
}else if($_POST["product_codet10"]!=''){
$product_code10 = $_POST["product_codet10"];
}else{
$product_code10 = $_POST["product_c10"];	
}


$product_id11 = $_POST["product_id11"];
$sale_count11 = $_POST["sale_count11"];
$product_price11 = $_POST["product_price11"];
$sale_remarkk11 = $_POST["sale_remarkk11"];
$sum_amountt11 = $_POST["sum_amount11"];
$sum_amount11= str_replace(',','', $sum_amountt11);
$discount_unit11 = $_POST["discount_unit11"];
$warranty11  = $_POST["warranty11"];
$cal11 = $_POST["cal11"];
$pm11 = $_POST["pm11"];
	
if($_POST["product_code11"]!=''){
$product_code11 = $_POST["product_code11"];
}else if($_POST["product_codet11"]!=''){
$product_code11 = $_POST["product_codet11"];
}else{
$product_code11 = $_POST["product_c11"];	
}

$product_id12 = $_POST["product_id12"];
$sale_count12 = $_POST["sale_count12"];
$product_price12 = $_POST["product_price12"];
$sale_remarkk12 = $_POST["sale_remarkk12"];
$sum_amountt12 = $_POST["sum_amount12"];
$sum_amount12= str_replace(',','', $sum_amountt12);
$discount_unit12 = $_POST["discount_unit12"];
$warranty12  = $_POST["warranty12"];
$cal12 = $_POST["cal12"];
$pm12 = $_POST["pm12"];
	
if($_POST["product_code12"]!=''){
$product_code12 = $_POST["product_code12"];
}else if($_POST["product_codet12"]!=''){
$product_code12 = $_POST["product_codet12"];
}else{
$product_code12 = $_POST["product_c12"];	
}

$product_id13 = $_POST["product_id13"];
$sale_count13 = $_POST["sale_count13"];
$product_price13 = $_POST["product_price13"];
$sale_remarkk13 = $_POST["sale_remarkk13"];
$sum_amountt13 = $_POST["sum_amount13"];
$sum_amount13= str_replace(',','', $sum_amountt13);
$discount_unit13 = $_POST["discount_unit13"];
$warranty13  = $_POST["warranty13"];
$cal13 = $_POST["cal13"];
$pm13 = $_POST["pm13"];
	
if($_POST["product_code13"]!=''){
$product_code13 = $_POST["product_code13"];
}else if($_POST["product_codet13"]!=''){
$product_code13 = $_POST["product_codet13"];
}else{
$product_code13 = $_POST["product_c13"];	
}

	
$product_id14 = $_POST["product_id14"];
$sale_count14 = $_POST["sale_count14"];
$product_price14 = $_POST["product_price14"];
$sale_remarkk14 = $_POST["sale_remarkk14"];
$sum_amountt14 = $_POST["sum_amount14"];
$sum_amount14= str_replace(',','', $sum_amountt14);
$discount_unit14 = $_POST["discount_unit14"];
$warranty14  = $_POST["warranty14"];
$cal14 = $_POST["cal14"];
$pm14 = $_POST["pm14"];
	
if($_POST["product_code14"]!=''){
$product_code14 = $_POST["product_code14"];
}else if($_POST["product_codet14"]!=''){
$product_code14 = $_POST["product_codet14"];
}else{
$product_code14 = $_POST["product_c14"];	
}
	
	
$product_id15 = $_POST["product_id15"];
$sale_count15 = $_POST["sale_count15"];
$product_price15 = $_POST["product_price15"];
$sale_remarkk15 = $_POST["sale_remarkk15"];
$sum_amountt15 = $_POST["sum_amount15"];
$sum_amount15= str_replace(',','', $sum_amountt15);
$discount_unit15 = $_POST["discount_unit15"];
$warranty15  = $_POST["warranty15"];
$cal15 = $_POST["cal15"];
$pm15 = $_POST["pm15"];
	
if($_POST["product_code15"]!=''){
$product_code15 = $_POST["product_code15"];
}else if($_POST["product_codet15"]!=''){
$product_code15 = $_POST["product_codet15"];
}else{
$product_code15 = $_POST["product_c15"];	
}







if($product_id6 !==''  ){
	
$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code6."' ";

$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count6*$objResult31["unit1"];
$unit2 =$sale_count6*$objResult31["unit2"];
$unit3 =$sale_count6*$objResult31["unit3"];
$unit4 =$sale_count6*$objResult31["unit4"];
$unit5 =$sale_count6*$objResult31["unit5"];
$unit6 =$sale_count6*$objResult31["unit6"];
$unit7 =$sale_count6*$objResult31["unit7"];
$unit8 =$sale_count6*$objResult31["unit8"];
$unit9 =$sale_count6*$objResult31["unit9"];
$unit10 =$sale_count6*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."','".$product_idb1."','".$product_idb1."','".$product_code6."','1','".$product_code6."','".$have_order."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code6."','".$have_order."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code6."','".$have_order."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code6."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code6."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code6."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code6."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code6."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code6."','".$have_order."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code6."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}			
}else{

$strSQL6 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,add_by,add_date)
values ('".$ref_id."','".$sale_count6."','".$sale_count6."','".$product_price6."','".$product_price6."','".$sum_amount6."','".$sale_remarkk6."','".$discount_unit6."','".$warranty6."','".$cal6."','".$pm6."','".$product_id6."','".$product_id6."','".$have_order."','".$add_by."','".$admin_date."')";

$objQuery6 = mysqli_query($conn,$strSQL6);
	
}
}


if($product_id7 !==''  ){
	
$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code7."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count7*$objResult31["unit1"];
$unit2 =$sale_count7*$objResult31["unit2"];
$unit3 =$sale_count7*$objResult31["unit3"];
$unit4 =$sale_count7*$objResult31["unit4"];
$unit5 =$sale_count7*$objResult31["unit5"];
$unit6 =$sale_count7*$objResult31["unit6"];
$unit7 =$sale_count7*$objResult31["unit7"];
$unit8 =$sale_count7*$objResult31["unit8"];
$unit9 =$sale_count7*$objResult31["unit9"];
$unit10 =$sale_count7*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."','".$product_idb1."','".$product_idb1."','".$product_code7."','1','".$product_code7."','".$have_order."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code7."','".$have_order."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code7."','".$have_order."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code7."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code7."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code7."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code7."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code7."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code7."','".$have_order."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code7."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
}else{

$strSQL7 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,add_by,add_date)
values ('".$ref_id."','".$sale_count7."','".$sale_count7."','".$product_price7."','".$product_price7."','".$sum_amount7."','".$sale_remarkk7."','".$discount_unit7."','".$warranty7."','".$cal7."','".$pm7."','".$product_id7."','".$product_id7."','".$have_order."','".$add_by."','".$admin_date."')";

$objQuery7 = mysqli_query($conn,$strSQL7);

}
}


if($product_id8 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code8."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count8*$objResult31["unit1"];
$unit2 =$sale_count8*$objResult31["unit2"];
$unit3 =$sale_count8*$objResult31["unit3"];
$unit4 =$sale_count8*$objResult31["unit4"];
$unit5 =$sale_count8*$objResult31["unit5"];
$unit6 =$sale_count8*$objResult31["unit6"];
$unit7 =$sale_count8*$objResult31["unit7"];
$unit8 =$sale_count8*$objResult31["unit8"];
$unit9 =$sale_count8*$objResult31["unit9"];
$unit10 =$sale_count8*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."','".$product_idb1."','".$product_idb1."','".$product_code8."','1','".$product_code8."','".$have_order."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code8."','".$have_order."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code8."','".$have_order."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code8."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code8."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code8."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code8."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code8."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code8."','".$have_order."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code8."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
}else{
	
	
$strSQL8 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,add_by,add_date)
values ('".$ref_id."','".$sale_count8."','".$sale_count8."','".$product_price8."','".$product_price8."','".$sum_amount8."','".$sale_remarkk8."','".$discount_unit8."','".$warranty8."','".$cal8."','".$pm8."','".$product_id8."','".$product_id8."','".$have_order."','".$add_by."','".$admin_date."')";

	$objQuery8 = mysqli_query($conn,$strSQL8);

}
}


if($product_id9 !==''  ){
	
$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code9."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count9*$objResult31["unit1"];
$unit2 =$sale_count9*$objResult31["unit2"];
$unit3 =$sale_count9*$objResult31["unit3"];
$unit4 =$sale_count9*$objResult31["unit4"];
$unit5 =$sale_count9*$objResult31["unit5"];
$unit6 =$sale_count9*$objResult31["unit6"];
$unit7 =$sale_count9*$objResult31["unit7"];
$unit8 =$sale_count9*$objResult31["unit8"];
$unit9 =$sale_count9*$objResult31["unit9"];
$unit10 =$sale_count9*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."','".$product_idb1."','".$product_idb1."','".$product_code9."','1','".$product_code9."','".$have_order."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code9."','".$have_order."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code9."','".$have_order."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code9."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code9."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code9."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code9."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code9."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code9."','".$have_order."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code10."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
}else{
	

$strSQL9 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,add_by,add_date)
values ('".$ref_id."','".$sale_count9."','".$sale_count9."','".$product_price9."','".$product_price9."','".$sum_amount9."','".$sale_remarkk9."','".$discount_unit9."','".$warranty9."','".$cal9."','".$pm9."','".$product_id9."','".$product_id9."','".$have_order."','".$add_by."','".$admin_date."')";

$objQuery9 = mysqli_query($conn,$strSQL9);


}
}


if($product_id10 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code10."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count10*$objResult31["unit1"];
$unit2 =$sale_count10*$objResult31["unit2"];
$unit3 =$sale_count10*$objResult31["unit3"];
$unit4 =$sale_count10*$objResult31["unit4"];
$unit5 =$sale_count10*$objResult31["unit5"];
$unit6 =$sale_count10*$objResult31["unit6"];
$unit7 =$sale_count10*$objResult31["unit7"];
$unit8 =$sale_count10*$objResult31["unit8"];
$unit9 =$sale_count10*$objResult31["unit9"];
$unit10 =$sale_count10*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."','".$product_idb1."','".$product_idb1."','".$product_code10."','1','".$product_code10."','".$have_order."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code10."','".$have_order."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code10."','".$have_order."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code10."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code10."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code10."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code10."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code10."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code10."','".$have_order."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code10."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
}else{
		

$strSQL10 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,add_by,add_date)
values ('".$ref_id."','".$sale_count10."','".$sale_count10."','".$product_price10."','".$product_price10."','".$sum_amount10."','".$sale_remarkk10."','".$discount_unit10."','".$warranty10."','".$cal10."','".$pm10."','".$product_id10."','".$product_id10."','".$have_order."','".$add_by."','".$admin_date."')";

$objQuery10 = mysqli_query($conn,$strSQL10);

}
}


////////////

if($product_id11 !==''  ){
	
$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code11."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count11*$objResult31["unit1"];
$unit2 =$sale_count11*$objResult31["unit2"];
$unit3 =$sale_count11*$objResult31["unit3"];
$unit4 =$sale_count11*$objResult31["unit4"];
$unit5 =$sale_count11*$objResult31["unit5"];
$unit6 =$sale_count11*$objResult31["unit6"];
$unit7 =$sale_count11*$objResult31["unit7"];
$unit8 =$sale_count11*$objResult31["unit8"];
$unit9 =$sale_count11*$objResult31["unit9"];
$unit10 =$sale_count11*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price11."','".$product_price11."','".$sum_amount11."','".$sale_remarkk11."','".$discount_unit11."','".$warranty11."','".$cal11."','".$pm11."','".$product_idb1."','".$product_idb1."','".$product_code11."','1','".$product_code11."','".$have_order."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code11."','".$have_order."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code11."','".$have_order."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code11."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code11."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code11."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code11."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code11."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code11."','".$have_order."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code11."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
}else{

$strSQL11 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order)
values ('".$ref_id."','".$sale_count11."','".$sale_count11."','".$product_price11."','".$product_price11."','".$sum_amount11."','".$sale_remarkk11."','".$discount_unit11."','".$warranty11."','".$cal11."','".$pm11."','".$product_id11."','".$product_id11."','".$have_order."')";

$objQuery11 = mysqli_query($conn,$strSQL11);
}
}

if($product_id12 !==''  ){
	
$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code12."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count12*$objResult31["unit1"];
$unit2 =$sale_count12*$objResult31["unit2"];
$unit3 =$sale_count12*$objResult31["unit3"];
$unit4 =$sale_count12*$objResult31["unit4"];
$unit5 =$sale_count12*$objResult31["unit5"];
$unit6 =$sale_count12*$objResult31["unit6"];
$unit7 =$sale_count12*$objResult31["unit7"];
$unit8 =$sale_count12*$objResult31["unit8"];
$unit9 =$sale_count12*$objResult31["unit9"];
$unit10 =$sale_count12*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price12."','".$product_price12."','".$sum_amount12."','".$sale_remarkk12."','".$discount_unit12."','".$warranty12."','".$cal12."','".$pm12."','".$product_idb1."','".$product_idb1."','".$product_code12."','1','".$product_code12."','".$have_order."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code12."','".$have_order."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code12."','".$have_order."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code12."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code12."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code12."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code12."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code12."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code12."','".$have_order."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code12."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
}else{	

$strSQL12 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order)
values ('".$ref_id."','".$sale_count12."','".$sale_count12."','".$product_price12."','".$product_price12."','".$sum_amount12."','".$sale_remarkk12."','".$discount_unit12."','".$warranty12."','".$cal12."','".$pm12."','".$product_id12."','".$product_id12."','".$have_order."')";

$objQuery12 = mysqli_query($conn,$strSQL12);
}
}

if($product_id13 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code13."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count13*$objResult31["unit1"];
$unit2 =$sale_count13*$objResult31["unit2"];
$unit3 =$sale_count13*$objResult31["unit3"];
$unit4 =$sale_count13*$objResult31["unit4"];
$unit5 =$sale_count13*$objResult31["unit5"];
$unit6 =$sale_count13*$objResult31["unit6"];
$unit7 =$sale_count13*$objResult31["unit7"];
$unit8 =$sale_count13*$objResult31["unit8"];
$unit9 =$sale_count13*$objResult31["unit9"];
$unit10 =$sale_count13*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price13."','".$product_price13."','".$sum_amount13."','".$sale_remarkk13."','".$discount_unit13."','".$warranty13."','".$cal13."','".$pm13."','".$product_idb1."','".$product_idb1."','".$product_code13."','1','".$product_code13."','".$have_order."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code13."','".$have_order."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code13."','".$have_order."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code13."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code13."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code13."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code13."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code13."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code13."','".$have_order."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code13."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
}else{		

$strSQL13 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order)
values ('".$ref_id."','".$sale_count13."','".$sale_count13."','".$product_price13."','".$product_price13."','".$sum_amount13."','".$sale_remarkk13."','".$discount_unit13."','".$warranty13."','".$cal13."','".$pm13."','".$product_id13."','".$product_id13."','".$have_order."')";

$objQuery13 = mysqli_query($conn,$strSQL13);
}
}

if($product_id14 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code14."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count14*$objResult31["unit1"];
$unit2 =$sale_count14*$objResult31["unit2"];
$unit3 =$sale_count14*$objResult31["unit3"];
$unit4 =$sale_count14*$objResult31["unit4"];
$unit5 =$sale_count14*$objResult31["unit5"];
$unit6 =$sale_count14*$objResult31["unit6"];
$unit7 =$sale_count14*$objResult31["unit7"];
$unit8 =$sale_count14*$objResult31["unit8"];
$unit9 =$sale_count14*$objResult31["unit9"];
$unit10 =$sale_count14*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price14."','".$product_price14."','".$sum_amount14."','".$sale_remarkk14."','".$discount_unit14."','".$warranty14."','".$cal14."','".$pm14."','".$product_idb1."','".$product_idb1."','".$product_code14."','1','".$product_code14."','".$have_order."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code14."','".$have_order."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code14."','".$have_order."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code14."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code14."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code14."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code14."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code14."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code14."','".$have_order."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code14."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
}else{		


$strSQL14 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order)
values ('".$ref_id."','".$sale_count14."','".$sale_count14."','".$product_price14."','".$product_price14."','".$sum_amount14."','".$sale_remarkk14."','".$discount_unit14."','".$warranty14."','".$cal14."','".$pm14."','".$product_id14."','".$product_id14."','".$have_order."')";
$objQuery14 = mysqli_query($conn,$strSQL14);
}
}

if($product_id15 !==''  ){

$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '".$product_code15."' ";
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);
$objResult31 = mysqli_fetch_array($objQuery31);

$product_idb1 =$objResult31["product_id1"];
$product_idb2 =$objResult31["product_id2"];
$product_idb3 =$objResult31["product_id3"];
$product_idb4 =$objResult31["product_id4"];
$product_idb5 =$objResult31["product_id5"];
$product_idb6 =$objResult31["product_id6"];
$product_idb7 =$objResult31["product_id7"];
$product_idb8 =$objResult31["product_id8"];
$product_idb9 =$objResult31["product_id9"];
$product_idb10 =$objResult31["product_id10"];
	
	
$unit1 =$sale_count15*$objResult31["unit1"];
$unit2 =$sale_count15*$objResult31["unit2"];
$unit3 =$sale_count15*$objResult31["unit3"];
$unit4 =$sale_count15*$objResult31["unit4"];
$unit5 =$sale_count15*$objResult31["unit5"];
$unit6 =$sale_count15*$objResult31["unit6"];
$unit7 =$sale_count15*$objResult31["unit7"];
$unit8 =$sale_count15*$objResult31["unit8"];
$unit9 =$sale_count15*$objResult31["unit9"];
$unit10 =$sale_count15*$objResult31["unit10"];
	
if($Num_Rows31 > 0){

	if($product_idb1!=''){
		
$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit1."','".$unit1."','".$product_price15."','".$product_price15."','".$sum_amount15."','".$sale_remarkk15."','".$discount_unit15."','".$warranty15."','".$cal15."','".$pm15."','".$product_idb1."','".$product_idb1."','".$product_code15."','1','".$product_code15."','".$have_order."')";
 
		$objQuery104 = mysqli_query($conn,$strSQL104);
		
	}
	
	if($product_idb2!=''){
		
$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit2."','".$unit2."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb2."','".$product_idb2."','1','".$product_code15."','".$have_order."')";
$objQuery100 = mysqli_query($conn,$strSQL100);
		
	}
	
	if($product_idb3!=''){
		
$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit3."','".$unit3."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb3."','".$product_idb3."','1','".$product_code15."','".$have_order."')";

$objQuery101 = mysqli_query($conn,$strSQL101);
	
	}
	
	if($product_idb4!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit4."','".$unit4."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb4."','".$product_idb4."','1','".$product_code15."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb5!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit5."','".$unit5."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb5."','".$product_idb5."','1','".$product_code15."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb6!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit6."','".$unit6."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb6."','".$product_idb6."','1','".$product_code15."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}
	
if($product_idb7!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit7."','".$unit7."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb7."','".$product_idb7."','1','".$product_code15."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		

if($product_idb8!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit8."','".$unit8."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb8."','".$product_idb8."','1','".$product_code15."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}		
	
if($product_idb9!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit9."','".$unit9."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb9."','".$product_idb9."','1','".$product_code15."','".$have_order."')";
$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
if($product_idb10!=''){
		
$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order)
values ('".$ref_id."','".$unit10."','".$unit10."','0.00','0.00','0.00','','0.00','0','0','0','".$product_idb10."','".$product_idb10."','1','".$product_code15."','".$have_order."')";

$objQuery102 = mysqli_query($conn,$strSQL102);
	
	}	
	
}else{		

	

$strSQL15 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order)
values ('".$ref_id."','".$sale_count15."','".$sale_count15."','".$product_price15."','".$product_price15."','".$sum_amount15."','".$sale_remarkk15."','".$discount_unit15."','".$warranty15."','".$cal15."','".$pm15."','".$product_id15."','".$product_id15."','".$have_order."')";

	$objQuery15 = mysqli_query($conn,$strSQL15);
}
}





}

 $start_date =$_POST["start_date"];
 $between_date =$_POST["between_date"];
 $start_time=$_POST["start_time"];
 $end_time=$_POST["end_time"];
 $status=$_POST["status"];
	
 if ($_POST["start_date"]!=''){
		$start_date =$_POST["start_date"];
	}else{
		$start_date='0000-00-00';
	}
	
	if ($_POST['fix_datetime']!=''){
		$fix_date=$_POST['fix_datetime'];
	}else{
		$fix_date='0';
	}
	
	if ($_POST['no_money']!=''){
        $no_price=$_POST['no_money'];
	}else{
		$no_price='0';
	}
	if ($_POST['call_customer']!=''){
		 $call_customer=$_POST['call_customer'];
	}else{
		$call_customer='0';
	}
	if ($_POST['credit_card']!=''){
		 $credit=$_POST['credit_card'];
	}else{
		$credit='0';
	}
	if ($_POST['call_back']!=''){
		 $call_employee=$_POST['call_back'];
	}else{
		$call_employee='0';
	}
	
	if ($_POST['cash']!=''){
		 $chash=$_POST['cash'];
	}else{
		$chash='0';
	}
	if ($_POST['check_paper']!=''){
	 $check_peper=$_POST['check_paper'];
	}else{
		$check_peper='0';
	}
	if ($_POST['check_paper']!=''){
		$check_peper=$_POST['check_paper'];
	}else{
		$check_peper='0';
	}
	if ($_POST['bill']!=''){
		 $bill=$_POST['bill'];
	}else{
		$bill='0';
	}
	if ($_POST['want_bus']!=''){
	$want_bus=$_POST['want_bus'];
	}else{
		$want_bus='0';
	}
	if ($_POST['tran']!=''){
		 $tran=$_POST["tran"];
	}else{
		$tran='0';
	}
	if ($_POST['more']!=''){
		 $check_detail=$_POST["more"];
	}else{
		$check_detail='0';
	}
	
		if ($_POST['dep']!=''){
		  $dep=$_POST["dep"];
	}else{
		$dep='0';
	}

	
 $department=$_POST["department_name"];
if($ic_ckk=='1'){	
$type_customer='8';	
}else{
 $type_customer=$_POST["customer_typename"];
}
	
 if($type_doc=='3'){
 	$type_company='ออลล์เวล ไลฟ์ บจก.';
	}else if($type_doc=='4'){
	$type_company='โนเบิล เมด บจก.';	
	}
	
 $customer_name=$_POST["customer_name"];
 $customer_tel=$_POST["customer_tel"];
  $province_name=$_POST["province_name"];
$address_name=$_POST["address_name"];

$customer_contact =$_POST["customer_contact"];
$bus_inter =$_POST["bus_inter"];	
 $on_time =$_POST["on_time"];
 $amphur_name=$_POST["amphur_name"];

 $product_name=$_POST["product"];
 $product_sn=$_POST["product_sn"];
 $unit_credit=$_POST["unit_credit"];
 $price=$_POST["unit_cash"];
 $employee_name=$_POST["employee_name"];
 $employee_tel=$_POST["employee_tel"];
 $description1=$_POST["description"];
$description = "$sale_comment $description1";
$count_box = $_POST["count_box"];
 
$unit_check=$_POST["unit_check"];
$unit_bill=$_POST["unit_bill"];
$unit_tran=$_POST["unit_tran"];
$department_show = $_POST["department_show"];
$unit_check1 = str_replace(',', '', $unit_check);
$unit_bill1 = str_replace(',', '', $unit_bill);
$dept =$_POST["dept"];
$status_comment =$_POST["status_comment"];

$address_1 =$_POST["address_1"]; 
$add_to ="$address_1 $province_name";
$address_send=$_POST["address_send"];
$add_code =$_POST["h_employee_name"];

	
$strSQL2 ="SELECT reseach_kk FROM hos__so WHERE ref_id = '".$ref_id."' ";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2=mysqli_fetch_array($objQuery2);
$mk_research = $objResult2["reseach_kk"];
	
	
if ($_POST['runway']!=''){
		$runway=$_POST["runway"];
	}else{
		$runway='0';
	}

if ($_POST['road']!=''){
		$road=$_POST["road"];
	}else{
		$road='0';
	}

if ($_POST['soy']!=''){
	$soy=$_POST["soy"];
	}else{
		$soy='0';
	}
	
	if ($_POST['car_load']!=''){
	$car_load=$_POST["car_load"];
	}else{
		$car_load='0';
	}

if ($_POST['no_car_road']!=''){
	$no_car_road=$_POST["no_car_road"];
	}else{
		$no_car_road='0';
	}
	
	if ($_POST['car_road']!=''){
	$car_road=$_POST["car_road"];
	}else{
		$car_road='0';
	}
if ($_POST['car_home']!=''){
	$car_home=$_POST["car_home"];
	}else{
		$car_home='0';
	}

	if ($_POST['slope']!=''){
	$slope=$_POST["slope"];	
	}else{
		$slope='0';
	}

	
	if ($_POST['bundai']!=''){
	$bundai=$_POST["bundai"];
	}else{
		$bundai='0';
	}

	if ($_POST['bundai_install']!=''){
	$bundai_install=$_POST["bundai_install"];
	}else{
		$bundai_install='0';
	}

	if ($_POST['lip']!=''){
	$lip=$_POST["lip"];
	}else{
		$lip='0';
	}

	
	if ($_POST['want_employee']!=''){
	$want_employee=$_POST["want_employee"];	
	}else{
		$want_employee='0';
	}

	if ($_POST['want_ex']!=''){
	$want_ex=$_POST["want_ex"];	
	}else{
		$want_ex='0';
	}

	
	if ($_POST['want_credit']!=''){
	$want_credit=$_POST["want_credit"];
	}else{
		$want_credit='0';
	}
if ($_POST['want_prem']!=''){
	$want_prem=$_POST["want_prem"];	
	}else{
		$want_prem='0';
	}
	
	if ($_POST['head_bad']!=''){
	$head_bad=$_POST["head_bad"];	
	}else{
		$head_bad='0';
	}

	
	if ($_POST['height_ltd']!=''){
	$height_ltd=$_POST["height_ltd"];	
	}else{
		$height_ltd='0';
	}
if ($_POST['up']!=''){
	$up=$_POST["up"];	
	}else{
		$up='0';
	}
if ($_POST['no_up']!=''){
	$no_up=$_POST["no_up"];	
	}else{
		$no_up='0';
	}

if ($_POST['more']!=''){
	$check_detail=$_POST["more"];	
	}else{
		$check_detail='0';
	}
	
	
	
$type_bundai=$_POST["type_bundai"];	
	
	
	
$soy_long = $_POST["soy_long"];
$soy_big = $_POST["soy_big"];
$car_park = $_POST["car_park"];
$door_long = $_POST["door_long"];
$unit_bundai = $_POST["unit_bundai"];
$door_big = $_POST["door_bigger"];
$door_longer = $_POST["door_longer"];
$type_door = $_POST["type_door"];
$home_type = $_POST["home_type"];
$install = $_POST["install"];
$bundai_big = $_POST["bundai_big"];
$lip_big = $_POST["lip_big"];
$lip_long = $_POST["lip_long"];
$lip_weight = $_POST["lip_weight"];
$employee_unit = $_POST["employee_unit"];
$ferniger_name = $_POST["ferniger_name"];
$ferniger_address = $_POST["ferniger_address"];
$number = $_POST["number"];
$status_comment=$_POST["status_comment"];

$dept = $_POST["dept"];
$room_bigger = $_POST["room_bigger"];
$room_longer = $_POST["room_longer"];
$bundai_hug = $_POST["bundai_hug"];
$bank = $_POST["bank"];

$department_show = $_POST["department_show"];
$description_ja = $_POST["description_ja"];
$sum_address = "$address_name $address_send";	

$sql = "SELECT *   FROM st__signature where ref_id = '".$ref_id."'";
$qry = mysqli_query($new,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
if($rs["cs_name"]==''){	
	

$strSQL66 =  "Update tb_register_data set start_date = '".$start_date."',between_date ='".$between_date."',start_time ='".$start_time."',end_time ='".$end_time."',status ='".$status."',fix_date ='".$fix_date."',no_price ='".$no_price."',call_customer ='".$call_customer."',credit ='".$credit."',call_employee ='".$call_employee."',cash ='".$chash."',check_peper ='".$check_peper."',bill = '".$bill."',department ='".$department."',type_customer ='".$type_customer."',type_company = '".$type_company."',customer_name ='".$customer_name."',customer_tel ='".$customer_tel."',address_name ='".$address_name."',address_send ='".$address_send."',want_bus ='".$want_bus."',product_name ='".$product_name."',product_sn ='".$product_sn."',unit_credit ='".$unit_credit."',price ='".$price."',employee_name ='".$employee_name."',employee_tel ='".$employee_tel."',add_by ='".$add_by."',description ='".$description."',add_date ='$add_date',unit_bill ='".$unit_bill."',unit_check ='".$unit_check."',unit_tran ='".$unit_tran."',tran ='".$tran."',check_detail ='".$check_detail."',dep ='".$dep."',dept ='".$dept."',department_show ='".$department_show."',customer_contact = '".$customer_contact."' ,status_comment = '".$status_comment."',on_time = '".$on_time."',address_1='".$address_1."',add_code = '".$add_code."',mk_research='".$mk_research."',bus_inter='".$bus_inter."',province_name='".$province_name."',count_box='".$count_box."'  where ref_id = '".$ref_id."'";

$objQuery66 = mysqli_query($conn,$strSQL66) or die(mysqli_error());

$strSQL33 =  "Update tb_transaction set runway='".$runway."',road='".$road."',soy='".$soy."',soy_long='".$soy_long."',soy_big='".$soy_big."',car_load='".$car_load."',car_park='".$car_park."',car_road='".$car_road."',no_car_road='".$no_car_road."',car_home='".$car_home."',door_long='".$door_long."',slope='".$slope."',bundai='".$bundai."',unit_bundai='".$unit_bundai."',door_big='".$door_big."',door_longer='".$door_longer."',type_door='".$type_door."',home_type='".$home_type."',install='".$install."',bundai_install='".$bundai_install."',bundai_big='".$bundai_big."',lip='".$lip."',lip_big='".$lip_big."',lip_long='".$lip_long."',lip_weight='".$lip_weight."',want_employee='".$want_employee."',employee_unit='".$employee_unit."',ferniger_name='".$ferniger_name."',ferniger_address='".$ferniger_address."',want_ex='".$want_ex."',want_credit='".$want_credit."',want_prem='".$want_prem."',add_date='$add_date',add_by='".$add_by."',room_bigger='".$room_bigger."',room_longer='".$room_longer."',bundai_hug='".$bundai_hug."',bank='".$bank."',description='".$description_ja."',type_bundai='".$type_bundai."',head_bad='".$head_bad."',height_ltd='".$height_ltd."',up='".$up."',no_up='".$no_up."'   where ref_id = '".$ref_id."' ";

$objQuery33 = mysqli_query($conn,$strSQL33) or die(mysqli_error());
	
	
if($job_no!=''){ 
	
$strSQLn =  "Update tb_register_data set start_date = '".$start_date."',between_date ='".$between_date."',start_time ='".$start_time."',end_time ='".$end_time."',status ='".$status."',fix_date ='".$fix_date."',no_price ='".$no_price."',call_customer ='".$call_customer."',credit ='".$credit."',call_employee ='".$call_employee."',cash ='".$chash."',check_peper ='".$check_peper."',bill = '".$bill."',department ='".$department."',type_customer ='".$type_customer."',type_company = '".$type_company."',customer_name ='".$customer_name."',customer_tel ='".$customer_tel."',address_name ='".$add_to."',address_send ='".$sum_address."',want_bus ='".$want_bus."',product_name ='".$product_name."',product_sn ='".$product_sn."',unit_credit ='".$unit_credit."',price ='".$price."',employee_name ='".$employee_name."',employee_tel ='".$employee_tel."',add_by ='".$add_by."',description ='".$description."',unit_bill ='".$unit_bill."',unit_check ='".$unit_check."',unit_tran ='".$unit_tran."',tran ='".$tran."',check_detail ='".$check_detail."',dep ='".$dep."',dept ='".$dept."',department_show ='".$department_show."',customer_contact = '".$customer_contact."' ,status_comment = '".$status_comment."',on_time = '".$on_time."',mk_research='".$mk_research."',province_name='".$province_name."'  where running = '".$job_no."'";

$objQueryn = mysqli_query($com1,$strSQLn) or die(mysqli_error());	
	
	
$strSQL33 =  "Update tb_transaction set runway='".$runway."',road='".$road."',soy='".$soy."',soy_long='".$soy_long."',soy_big='".$soy_big."',car_load='".$car_load."',car_park='".$car_park."',car_road='".$car_road."',no_car_road='".$no_car_road."',car_home='".$car_home."',door_long='".$door_long."',slope='".$slope."',bundai='".$bundai."',unit_bundai='".$unit_bundai."',door_big='".$door_big."',door_longer='".$door_longer."',type_door='".$type_door."',home_type='".$home_type."',install='".$install."',bundai_install='".$bundai_install."',bundai_big='".$bundai_big."',lip='".$lip."',lip_big='".$lip_big."',lip_long='".$lip_long."',lip_weight='".$lip_weight."',want_employee='".$want_employee."',employee_unit='".$employee_unit."',ferniger_name='".$ferniger_name."',ferniger_address='".$ferniger_address."',want_ex='".$want_ex."',want_credit='".$want_credit."',want_prem='".$want_prem."',add_date='$add_date',add_by='".$add_by."',room_bigger='".$room_bigger."',room_longer='".$room_longer."',bundai_hug='".$bundai_hug."',bank='".$bank."',description='".$description_ja."',type_bundai='".$type_bundai."',head_bad='".$head_bad."',height_ltd='".$height_ltd."',up='".$up."',no_up='".$no_up."'   where running = '".$job_no."' ";

$objQuery33 = mysqli_query($com1,$strSQL33) or die(mysqli_error());	
	
	
}	
}	
	
	
/*$strSQL22 = "SELECT job_no FROM hos__so WHERE ref_id = '".$ref_id."' ";
$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$rs2 = mysqli_fetch_assoc($objQuery22);
$job_no	= $rs2["job_no"];

	
if( $send_cs =='2'){
	
$save22="Update  tb_register_data set product_sn ='".$product_sn."',start_date='".$start_date."',start_time='".$start_time."',end_time='".$end_time."'  where running='".$job_no."'";
$qsave22=mysqli_query($com1,$save22);
	
$save21="Update  hos__so set delivery_date ='".$start_date."'  where ref_id ='".$ref_id."'";
$qsave21=mysqli_query($conn,$save21);

}*/



	
if( $send_cs =='1' and $job_no ==''){
		
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(running) AS MAXID FROM tb_register_data";
$qry = mysqli_query($com1,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId1 = substr($rs['MAXID'],0,-4);

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
	



$strSQL89 =  "insert into tb_register_data (running,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,amphur_name,province_name,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,number,status_comment,dep,dept,department_show,address_bus,customer_contact,on_time,add_code,mk_research,sale_code,bus_inter,ref_id,iv_date) 

values('".$nextId."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$add_to."','".$sum_address."','".$want_bus."','".$amphur_name."','".$province_name."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','$add_date','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$number."','".$status_comment."','".$dep."','".$dept."','".$department_show."','".$province_name."','".$customer_contact."','".$on_time."','".$add_code."','".$mk_research."','".$sale_code."','".$bus_inter."','".$ref_id."','".$iv_date."')";

$objQuery89 = mysqli_query($com1,$strSQL89) or die(mysqli_error());

$strSQL90 =  "insert into tb_transaction (running,runway,road,soy,soy_long,soy_big,car_load,car_park,car_road,no_car_road,car_home,door_long,slope,bundai,unit_bundai,door_big,door_longer,type_door,home_type,install,bundai_install,bundai_big,lip,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,ferniger_address,want_ex,want_credit,want_prem,add_date,add_by,room_bigger,room_longer,bundai_hug,bank,description,type_bundai,head_bad,height_ltd,up,no_up) 

values('".$nextId."','".$runway."','".$road."','".$soy."','".$soy_long."','".$soy_big."','".$car_load."','".$car_park."','".$car_road."','".$no_car_road."','".$car_home."','".$door_long."','".$slope."','".$bundai."','".$unit_bundai."','".$door_big."','".$door_longer."','".$type_door."','".$home_type."','".$install."','".$bundai_install."','".$bundai_big."','".$lip."','".$lip_big."','".$lip_long."','".$lip_weight."','".$want_employee."','".$employee_unit."','".$ferniger_name."','".$ferniger_address."','".$want_ex."','".$want_credit."','".$want_prem."','$add_date','".$add_by."','".$room_bigger."','".$room_longer."','".$bundai_hug."','".$bank."','".$description_ja."','".$type_bundai."','".$head_bad."','".$height_ltd."','".$up."','".$no_up."')";
$objQuery90 = mysqli_query($com1,$strSQL90) or die(mysqli_error());	
	
$strSQL26="Update  hos__so set job_no ='".$nextId."',send_cs ='2'  where ref_id='".$ref_id."'";
$objQuery26 = mysqli_query($conn,$strSQL26);
	
	}
	$doc_noo = substr($iv_no,0,3);
	
	if($doc_noo=="IV2"){
		$com ="บิลเงินสด";
}else if ($type_doc=='3'){
		$com ="ออลล์เวล ไลฟ์ บจก.";
	}else if ($type_doc=='4'){
	$com="โนเบิล เมด บจก.";	
	}
	
if($payment =='36' or $payment =='38' or $payment =='39' or $payment =='40' or $payment =='41' or $payment =='42'){
		$credit ='1';
	}else{
$credit ='0';
}

$cash = $payment;	

	
$qfirst = "select em_id from tb_user where code = '".$sale_code."'";
$first = mysqli_query($conn,$qfirst);
$ffirst = mysqli_fetch_array($first);
	
	
	if($delivery_type=='2'){
		$chang_name = $sale;
		$chang_code = $ffirst["em_id"];
	}else{
        $chang_name = "";
		$chang_code = "";
	}
	

	if($send_receipt=='1'){
		
$strSQL29 = "SELECT SUM(amount) AS unit_cash FROM hos__subso WHERE ref_idd = '".$ref_id."' ";
$objQuery29 = mysqli_query($conn,$strSQL29) or die ("Error Query [".$strSQL29."]");
$rs = mysqli_fetch_assoc($objQuery29);
/*if($payment=='2' or $payment=='3' or $payment=='4' or $payment=='5' ){
$unit_cash = "0.00";
}else{*/
$unit_cash = $rs["unit_cash"];
//}
		
if($_POST["iv_date"]!=''){
$date_inv = $_POST["iv_date"];	
}else{
 $date_inv= $add_date;	
}
		
if($bus_inter =='1'){
$defef = "ขนส่งอินเตอร์ $payment_des";
}else{
$defef = "";
}

	
$strSQL292="insert into   tb_register_data (IV_number,date_inv,company,customer_name,date_tranfer,employee_name,credit,cash,unit_cash,description,ref_id,doc_send,date_send,doc_send1,inv_return,date_inv_return,inv_return1,doc_receive,doc_receive1,bill_id) values ('".$iv_no."','".$iv_date."','".$com."','".$bill_name."','".$date_tranfer ."','บรรจบพร','".$credit."','$cash','".$unit_cash."','".$defef."','".$ref_id."','".$em_id."','".$add_date."','".$name."','".$em_id."','".$add_date."','".$name."','".$chang_code."','".$chang_name."','".$bill_id."')";

$objQuery292 = mysqli_query($code,$strSQL292);	
			

$strSQL262="Update  hos__so set send_receipt ='2'  where ref_id='".$ref_id."'";
$objQuery262 = mysqli_query($conn,$strSQL262);		

	}
	

if($send_receipt=='2'){
		
$strSQL29 = "SELECT SUM(amount) AS unit_cash FROM hos__subso WHERE ref_idd = '".$ref_id."' ";
$objQuery29 = mysqli_query($conn,$strSQL29) or die ("Error Query [".$strSQL29."]");
$rs = mysqli_fetch_assoc($objQuery29);
/*if($payment=='2' or $payment=='3' or $payment=='4' or $payment=='5' ){
$unit_cash = "0.00";
}else{*/
$unit_cash = $rs["unit_cash"];
//}
	
if($start_date !=''){
$date_inv = $_POST["start_date"];
}else if($_POST["iv_date"]!=''){
$date_inv = $_POST["iv_date"];	
}else{
 $date_inv= $add_date;	
}

if($bus_inter =='1'){
$defef = "ขนส่งอินเตอร์";
}else{
$defef = "";
}
	
$strSQL293="Update  tb_register_data Set date_inv ='".$iv_date."',company = '".$com."',customer_name = '".$bill_name."',date_tranfer = '".$date_tranfer ."',employee_name ='บรรจบพร',credit ='".$credit."',cash ='$cash',unit_cash = '".$unit_cash."',IV_number = '".$iv_no."',description='".$defef."',doc_receive='".$chang_code."',doc_receive1='".$chang_name."',bill_id='".$bill_id."' where ref_id = '".$ref_id."' and type_1 =''";
//echo $strSQL293;
//exit();
$objQuery293 = mysqli_query($code,$strSQL293);	
			

	}


$strSQL89="Update  st__main set iv_no = '".$iv_no."'  where ref_idsale='".$ref_id."'";
$objQuery89 = mysqli_query($conn,$strSQL89);

if($status_doc !=''){
	
if($remark_cancel==''){

echo "<script language=\"JavaScript\">";
echo "alert('กรุณาใส่หมายเหตุการยกเลิกเอกสาร');window.location='register_adminhos_edit.php?ref_id=$ref_id';";
echo "</script>";
exit();
	
}else{



$save1="Update  hos__so set status_doc = '".$status_doc."',send_receipt ='0'  where ref_id='".$ref_id."'";
$qsave1=mysqli_query($conn,$save1);
		
$save2="Update  hos__subso set ckk_order = '0',status_so='ยกเลิก'  where ref_idd='".$ref_id."'";
$qsave2=mysqli_query($conn,$save2);	
	
//$save4="DELETE  FROM  tb_register_data  where ref_id ='".$ref_id."'";
	//echo $save4;
//$qsave4=mysqli_query($code,$save4);
	
$save3="Update   tb_register_data set summary_sup='".$status_doc."',description_sup='".$remark_cancel."',status_comment='".$status_doc."',employee_send='',employee_code='',bus_number='',code_bus=''  where ref_id ='".$ref_id."'";
$qsave3=mysqli_query($com1,$save3);	




}
	}
	
//exit();
$customer_name1 = $_POST["customer_name1"];
$customer_tel1 = $_POST["customer_tel1"];
$address_name1 = $_POST["address_name1"];
	
$customer_name2 = $_POST["customer_name2"];
$customer_tel2 = $_POST["customer_tel2"];
$address_name2 = $_POST["address_name2"];

$customer_name3 = $_POST["customer_name3"];
$customer_tel3 = $_POST["customer_tel3"];
$address_name3 = $_POST["address_name3"];

$customer_name4 = $_POST["customer_name4"];
$customer_tel4 = $_POST["customer_tel4"];
$address_name4 = $_POST["address_name4"];
	
$customer_name5 = $_POST["customer_name5"];
$customer_tel5 = $_POST["customer_tel5"];
$address_name5 = $_POST["address_name5"];

$customer_name6 = $_POST["customer_name6"];
$customer_tel6 = $_POST["customer_tel6"];
$address_name6 = $_POST["address_name6"];

$customer_name7 = $_POST["customer_name7"];
$customer_tel7 = $_POST["customer_tel7"];
$address_name7 = $_POST["address_name7"];

$customer_name8 = $_POST["customer_name8"];
$customer_tel8 = $_POST["customer_tel8"];
$address_name8 = $_POST["address_name8"];

$customer_name9 = $_POST["customer_name9"];
$customer_tel9 = $_POST["customer_tel9"];
$address_name9 = $_POST["address_name9"];
	
$strSQL22 = "SELECT * FROM tb_delivery_print WHERE ref_id = '".$ref_id."' ";
$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$Num_Rows22 = mysqli_num_rows($objQuery22);

if($Num_Rows22 > 0){

$strSQL15 =  "UPDATE tb_delivery_print SET customer_name1='".$customer_name1."',customer_tel1='".$customer_tel1."',address_name1='".$address_name1."',customer_name2='".$customer_name2."',customer_tel2='".$customer_tel2."',address_name2='".$address_name2."',customer_name3='".$customer_name3."',customer_tel3='".$customer_tel3."',address_name3='".$address_name3."',customer_name4='".$customer_name4."',customer_tel4='".$customer_tel4."',address_name4='".$address_name4."',customer_name5='".$customer_name5."',customer_tel5='".$customer_tel5."',address_name5='".$address_name5."',customer_name6='".$customer_name6."',customer_tel6='".$customer_tel6."',address_name6='".$address_name6."',customer_name7='".$customer_name7."',customer_tel7='".$customer_tel7."',address_name7='".$address_name7."',customer_name8='".$customer_name8."',customer_tel8='".$customer_tel8."',address_name8='".$address_name8."',customer_name9='".$customer_name8."',customer_tel9='".$customer_tel9."',address_name9='".$address_name9."'  where ref_id ='".$ref_id."'";

$objQuery15 = mysqli_query($conn,$strSQL15) or die(mysqli_error());	

}else{

if($customer_name1!=''){

$strSQL15 =  "insert into tb_delivery_print (ref_id,customer_name1,customer_tel1,address_name1,customer_name2,customer_tel2,address_name2,customer_name3,customer_tel3,address_name3,customer_name4,customer_tel4,address_name4,customer_name5,customer_tel5,address_name5,customer_name6,customer_tel6,address_name6,customer_name7,customer_tel7,address_name7,customer_name8,customer_tel8,address_name8,customer_name9,customer_tel9,address_name9) 

values('".$ref_id."','".$customer_name1."','".$customer_tel1."','".$address_name1."','".$customer_name2."','".$customer_tel2."','".$address_name2."','".$customer_name3."','".$customer_tel3."','".$address_name3."','".$customer_name4."','".$customer_tel4."','".$address_name4."','".$customer_name5."','".$customer_tel5."','".$address_name5."','".$customer_name6."','".$customer_tel6."','".$address_name6."','".$customer_name7."','".$customer_tel7."','".$address_name7."','".$customer_name8."','".$customer_tel8."','".$address_name8."','".$customer_name9."','".$customer_tel9."','".$address_name9."')";

$objQuery15 = mysqli_query($conn,$strSQL15) or die(mysqli_error());

}	


	}
	
	
	
$sql04 = "SELECT clear_ivno FROM hos__subso WHERE ref_idd ='".$ref_id."' and clear_ivno !=''";
$result04 = mysqli_query($conn, $sql04);
$Num_Rows014 = mysqli_num_rows($result04);	
$output1 = "";
while($objResult10 = mysqli_fetch_array($result04))
{

	if($objResult10["clear_ivno"]!=''){
$output1 .=  "" .$objResult10["clear_ivno"]. "  "; 
	}	
}	
$hab = trim($output1);

$hab1 = "$hab";	
	
if($hab1!=''){	
	
$strSQL81 = "Update  hos__so set brnp_no='".$hab1."' WHERE ref_id ='".$ref_id."'";
$objQuery81 = mysqli_query($conn,$strSQL81);	 
	
}

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminhos_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


