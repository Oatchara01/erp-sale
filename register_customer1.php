<?php
include("dbconnect.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {
$last_name = $_POST["last_name"];
$first_name = $_POST["first_name"];
$customer_name = "คุณ$first_name  $last_name";
$cus_tel = $_POST["cus_tel"];
$date_brith= $_POST["date_brith"];	
$month_brith= $_POST["month_brith"];		
$year_brith= $_POST["year_brith"];	
$mount = $_POST["month_brith"];	
$brithday = "$year_brith-$month_brith-$date_brith";

$status = $_POST["status"];
$occupation = $_POST["occupation"];
//$salary = $_POST["salary"];
$cus_addno = $_POST["cus_addno"];
$cus_addtum = $_POST["cus_addtum"];
$cus_address = "$cus_addno $cus_addtum";
$cus_ampher = $_POST["cus_ampher"];
$cus_province = $_POST["cus_province"];
$email = $_POST["email"];
$product_fer1 = $_POST["product_fer1"];
$product_fer2 = $_POST["product_fer2"];
$product_fer3 = $_POST["product_fer3"];
$product_fer4 = $_POST["product_fer4"];
$well_allwell = $_POST["well_allwell"];
$best_service1 = $_POST["best_service1"];
$best_service2 = $_POST["best_service2"];
$best_service3 = $_POST["best_service3"];
$best_service4 = $_POST["best_service4"];
$description = $_POST["description"];
$type_customer = '6';
$bill_name = "$first_name  $last_name";
$bill_tel = $_POST["cus_tel"];
$bill_address = $_POST["cus_address"];
$preface_name ='คุณ';
$bill_ampher = $_POST["cus_ampher"];
$billl_province = $_POST["cus_province"];
$cus_postcode = $_POST["cus_postcode"];
$age = $_POST["age"];
$add_date = date('Y-m-d H:i:s');
	
/*$date = explode('-' ,$brithday);
$newDate = $date[2].'-'.$date[1].'-'.$date[0];
$mount = $date[1];*/
	


$sql1 = "SELECT cus_tel,customer_no,customer_id    FROM tb_customer where cus_tel  ='".$cus_tel."' ";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$Num_Rows1 = mysqli_num_rows($qry1);
$rs1 = mysqli_fetch_assoc($qry1);
$customer_no = $rs1["customer_no"];
$cus_tel5 = $rs1["cus_tel"];
if($Num_Rows1 >0 ){
if($rs1["customer_no"] !=''){
	
echo "<script language=\"JavaScript\">";
echo "alert('เบอร์โทร $cus_tel5 ท่านได้ทำการสมัครบัตรสมาชิกไปแล้วค่ะเลขที่ $customer_no');window.location='register_customer.php';";
echo "</script>";
exit();
	
}else{
	
$yearMonth = substr(date("Y")+543, -2);
$sql = "SELECT MAX(customer_no) AS MAXID FROM tb_customer";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-6);

$maxId1 = substr($maxId3,0,-4);

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}

$customer_no =$nextId;

//,salary='".$salary."'

$save="UPDATE tb_customer SET customer_no='".$customer_no."',brithday='".$brithday."',age='".$age."',status='".$status."',occupation='".$occupation."',email_cus='".$email."',product_fer1='".$product_fer1."',product_fer2='".$product_fer2."',product_fer3='".$product_fer3."',well_allwell='".$well_allwell."',best_service1='".$best_service1."',best_service2='".$best_service2."',best_service3='".$best_service3."',best_service4='".$best_service4."',description='".$description."',last_name='".$last_name."',first_name='".$first_name."',add_date='".$add_date."',product_fer4='".$product_fer4."',month='".$mount."',online='1',cus_addtum ='".$cus_addtum."',cus_addno ='".$cus_addno."',preface_name ='".$preface_name."',agree_ckk='1'  where customer_id = '".$rs1["customer_id"]."'";


$qsave=mysqli_query($conn,$save);
	
}

}else{
	
	
	
$yearMonth = substr(date("Y")+543, -2);
$sql = "SELECT MAX(customer_no) AS MAXID FROM tb_customer";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-6);

$maxId1 = substr($maxId3,0,-4);

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}

$customer_no =$nextId;


//,salary,'".$salary."'
	
$save="insert into tb_customer
(customer_no,customer_name,type_customer,cus_address,cus_ampher,cus_province,cus_postcode,cus_tel,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,bill_tel,sale_code,brithday,age,status,occupation,email_cus,product_fer1,product_fer2,product_fer3,well_allwell,best_service1,best_service2,best_service3,best_service4,description,last_name,first_name,add_date,product_fer4,month,online,cus_addno,cus_addtum,preface_name,agree_ckk)
values
('".$customer_no."','".$customer_name."','".$type_customer."','".$cus_address."','".$cus_ampher."','".$cus_province."','".$cus_postcode."','".$cus_tel."','".$bill_name."','".$bill_address."','".$bill_ampher."','".$billl_province."','".$bill_postcode."','".$bill_tel."','SOL3','".$brithday."','".$age."','".$status."','".$occupation."','".$email."','".$product_fer1."','".$product_fer2."','".$product_fer3."','".$well_allwell."','".$best_service1."','".$best_service2."','".$best_service3."','".$best_service4."','".$description."','".$last_name."','".$first_name."','".$add_date."','".$product_fer4."','".$mount."','1','".$cus_addno."','".$cus_addtum."','".$preface_name."','1')";


$qsave=mysqli_query($conn,$save);

}

/*$to = $email;

			$headers = "From: allwellonline@gmail.com\r\n";
			$headers .= "Reply-To: allwellonline@gmail.com\r\n";
			$headers .= "Return-Path: allwellonline@gmail.com\r\n";
			$headers .= "CC: allwellonline@gmail.com\r\n";
			$headers .= "BCC: allwellonline@gmail.com\r\n";
			$headers .= "X-Mailer: PHP/" . phpversion();
			$headers .= "'MIME-Version: 1.0' . \r\nContent-type: text/html; charset=utf-8\r\n";

			$subject = "=?UTF-8?B?".base64_encode("บัตรสมาชิก Allwell")."?=";

			$body = "บัตรสมาชิก Allwell เลขสมาชิก: ".$customer." <a href='https://sol.allwellhealthcare.com/register_customer2.php?customer_no=$customer_no'>กรณาคลิ๊กลิ้งค์นี้เพื่อดำเนินการต่อไป</a> ";
			 

			mail($to, $subject, $body, $headers);*/








 if($qsave){ ?>
 </p></p></p></p></p>
<?php
  echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_customer2.php?customer_no=$customer_no';";
echo "</script>";
?>

<?php	
  } else {
   echo "Cannot";
  }
	}
?>