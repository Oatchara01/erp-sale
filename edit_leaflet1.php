<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$product_id = $_POST["product_id"];
$product_code = $_POST["product_code"];
$product_name = $_POST["product_name"];
$product_sn = $_POST["product_sn"];
$product_photo = $_POST["product_photo"];
$ingredient1 = $_POST["ingredient1"];
$ingredient2 = $_POST["ingredient2"];
$ingredient3 = $_POST["ingredient3"];
$ingredient4 = $_POST["ingredient4"];
$ingredient5 = $_POST["ingredient5"];
$ingredient6 = $_POST["ingredient6"];
$ingredient7 = $_POST["ingredient7"];
$ingredient8 = $_POST["ingredient8"];
$ingredient9 = $_POST["ingredient9"];
$ingredient10 = $_POST["ingredient10"];
$ingredient11 = $_POST["ingredient11"];
$ingredient12 = $_POST["ingredient12"];
$ingredient13 = $_POST["ingredient13"];
$ingredient14 = $_POST["ingredient14"];
$ingredient15 = $_POST["ingredient15"];
$ingredient16 = $_POST["ingredient16"];
$ingredient17 = $_POST["ingredient17"];
$ingredient18 = $_POST["ingredient18"];
$ingredient19 = $_POST["ingredient19"];
$ingredient20 = $_POST["ingredient20"];
$ingredient21 = $_POST["ingredient21"];
$ingredient22 = $_POST["ingredient22"];
$ingredient23 = $_POST["ingredient23"];
$ingredient24 = $_POST["ingredient24"];
$ingredient25 = $_POST["ingredient25"];
$ingredient26 = $_POST["ingredient26"];
$ingredient27 = $_POST["ingredient27"];
$ingredient28 = $_POST["ingredient28"];
$ingredient29 = $_POST["ingredient29"];
$leaflet_id = $_POST["leaflet_id"];
	
$add_date = date('Y-m-d H:i:s');
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
	
	
if($_FILES['img1']['size'] == 0){
$img1 = $_POST["up_img1"];
}else if($_FILES['img1']['size'] != 0){
$temp1 = explode(".", $_FILES["img1"]["name"]);
$img1 = "img1" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["img1"]["tmp_name"], "review/" . $img1);
}	
	
if($_FILES['img2']['size'] == 0){
$img2 = $_POST["up_img2"];
}else if($_FILES['img2']['size'] != 0){
$temp2 = explode(".", $_FILES["img2"]["name"]);
$img2 = "img2" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["img2"]["tmp_name"], "review/" . $img2);
}		
	
if($_FILES['img3']['size'] == 0){
$img3 = $_POST["up_img3"];
}else if($_FILES['img3']['size'] != 0){
$temp3 = explode(".", $_FILES["img3"]["name"]);
$img3 = "img3" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["img3"]["tmp_name"], "review/" . $img3);
}		

if($_FILES['img4']['size'] == 0){
$img4 = $_POST["up_img4"];
}else if($_FILES['img4']['size'] != 0){
$temp4 = explode(".", $_FILES["img4"]["name"]);
$img4 = "img4" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp4);
move_uploaded_file($_FILES["img4"]["tmp_name"], "review/" . $img4);
}		

if($_FILES['img5']['size'] == 0){
$img5 = $_POST["up_img5"];
}else if($_FILES['img5']['size'] != 0){
$temp5 = explode(".", $_FILES["img5"]["name"]);
$img5 = "img5" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp5);
move_uploaded_file($_FILES["img5"]["tmp_name"], "review/" . $img5);
}		
	
if($_FILES['img6']['size'] == 0){
$img6 = $_POST["up_img6"];
}else if($_FILES['img6']['size'] != 0){
$temp6 = explode(".", $_FILES["img6"]["name"]);
$img6 = "img6" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp6);
move_uploaded_file($_FILES["img6"]["tmp_name"], "review/" . $img6);
}		

if($_FILES['img7']['size'] == 0){
$img7 = $_POST["up_img7"];
}else if($_FILES['img7']['size'] != 0){
$temp7 = explode(".", $_FILES["img7"]["name"]);
$img7 = "img7" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp7);
move_uploaded_file($_FILES["img7"]["tmp_name"], "review/" . $img7);
}		
	
if($_FILES['img8']['size'] == 0){
$img8 = $_POST["up_img8"];
}else if($_FILES['img8']['size'] != 0){
$temp8 = explode(".", $_FILES["img8"]["name"]);
$img8 = "img8" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp8);
move_uploaded_file($_FILES["img8"]["tmp_name"], "review/" . $img8);
}		
	
if($_FILES['img9']['size'] == 0){
$img9 = $_POST["up_img9"];
}else if($_FILES['img9']['size'] != 0){
$temp9 = explode(".", $_FILES["img9"]["name"]);
$img9 = "img9" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp9);
move_uploaded_file($_FILES["img9"]["tmp_name"], "review/" . $img9);
}		

if($_FILES['img10']['size'] == 0){
$img10 = $_POST["up_img10"];
}else if($_FILES['img10']['size'] != 0){
$temp10 = explode(".", $_FILES["img10"]["name"]);
$img10 = "img10" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp10);
move_uploaded_file($_FILES["img10"]["tmp_name"], "review/" . $img10);
}			
	
if($_FILES['img11']['size'] == 0){
$img11 = $_POST["up_img11"];
}else if($_FILES['img11']['size'] != 0){
$temp11 = explode(".", $_FILES["img11"]["name"]);
$img11 = "img11" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp11);
move_uploaded_file($_FILES["img11"]["tmp_name"], "review/" . $img11);
}	
	
if($_FILES['img12']['size'] == 0){
$img12 = $_POST["up_img12"];
}else if($_FILES['img12']['size'] != 0){
$temp12 = explode(".", $_FILES["img12"]["name"]);
$img12 = "img12" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp12);
move_uploaded_file($_FILES["img12"]["tmp_name"], "review/" . $img12);
}		

if($_FILES['img13']['size'] == 0){
$img13 = $_POST["up_img13"];
}else if($_FILES['img13']['size'] != 0){
$temp13 = explode(".", $_FILES["img13"]["name"]);
$img13 = "img13" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp13);
move_uploaded_file($_FILES["img13"]["tmp_name"], "review/" . $img13);
}	
	
if($_FILES['img14']['size'] == 0){
$img14 = $_POST["up_img14"];
}else if($_FILES['img14']['size'] != 0){
$temp14 = explode(".", $_FILES["img14"]["name"]);
$img14 = "img14" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp14);
move_uploaded_file($_FILES["img14"]["tmp_name"], "review/" . $img14);
}	
	
if($_FILES['img15']['size'] == 0){
$img15 = $_POST["up_img15"];
}else if($_FILES['img15']['size'] != 0){
$temp15 = explode(".", $_FILES["img15"]["name"]);
$img15 = "img15" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp15);
move_uploaded_file($_FILES["img15"]["tmp_name"], "review/" . $img15);
}
	
if($_FILES['img16']['size'] == 0){
$img16 = $_POST["up_img16"];
}else if($_FILES['img16']['size'] != 0){
$temp16 = explode(".", $_FILES["img16"]["name"]);
$img16 = "img16" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp16);
move_uploaded_file($_FILES["img16"]["tmp_name"], "review/" . $img16);
}
	
if($_FILES['img17']['size'] == 0){
$img17 = $_POST["up_img17"];
}else if($_FILES['img17']['size'] != 0){
$temp17 = explode(".", $_FILES["img17"]["name"]);
$img17 = "img17" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp17);
move_uploaded_file($_FILES["img17"]["tmp_name"], "review/" . $img17);
}		
	
if($_FILES['img18']['size'] == 0){
$img18 = $_POST["up_img18"];
}else if($_FILES['img18']['size'] != 0){
$temp18 = explode(".", $_FILES["img18"]["name"]);
$img18 = "img18" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp18);
move_uploaded_file($_FILES["img18"]["tmp_name"], "review/" . $img18);
}		
	
if($_FILES['img19']['size'] == 0){
$img19 = $_POST["up_img19"];
}else if($_FILES['img19']['size'] != 0){
$temp19 = explode(".", $_FILES["img19"]["name"]);
$img19 = "img19" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp19);
move_uploaded_file($_FILES["img19"]["tmp_name"], "review/" . $img19);
}		
	
if($_FILES['img20']['size'] == 0){
$img20 = $_POST["up_img20"];
}else if($_FILES['img20']['size'] != 0){
$temp20 = explode(".", $_FILES["img20"]["name"]);
$img20 = "img20" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp20);
move_uploaded_file($_FILES["img20"]["tmp_name"], "review/" . $img20);
}	
	
if($_FILES['img21']['size'] == 0){
$img21 = $_POST["up_img21"];
}else if($_FILES['img21']['size'] != 0){
$temp21 = explode(".", $_FILES["img21"]["name"]);
$img21 = "img21" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp21);
move_uploaded_file($_FILES["img21"]["tmp_name"], "review/" . $img21);
}			
	
if($_FILES['img22']['size'] == 0){
$img22 = $_POST["up_img22"];
}else if($_FILES['img22']['size'] != 0){
$temp22 = explode(".", $_FILES["img22"]["name"]);
$img22 = "img22" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp22);
move_uploaded_file($_FILES["img22"]["tmp_name"], "review/" . $img22);
}	
	
if($_FILES['img23']['size'] == 0){
$img23 = $_POST["up_img23"];
}else if($_FILES['img23']['size'] != 0){
$temp23 = explode(".", $_FILES["img23"]["name"]);
$img23 = "img23" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp23);
move_uploaded_file($_FILES["img23"]["tmp_name"], "review/" . $img23);
}			

if($_FILES['img24']['size'] == 0){
$img24 = $_POST["up_img24"];
}else if($_FILES['img24']['size'] != 0){
$temp24 = explode(".", $_FILES["img24"]["name"]);
$img24 = "img24" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp24);
move_uploaded_file($_FILES["img24"]["tmp_name"], "review/" . $img24);
}			
	
	
if($_FILES['img25']['size'] == 0){
$img25 = $_POST["up_img25"];
}else if($_FILES['img25']['size'] != 0){
$temp25 = explode(".", $_FILES["img25"]["name"]);
$img25 = "img25" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp25);
move_uploaded_file($_FILES["img25"]["tmp_name"], "review/" . $img25);
}	
	
if($_FILES['img26']['size'] == 0){
$img26 = $_POST["up_img26"];
}else if($_FILES['img26']['size'] != 0){
$temp26 = explode(".", $_FILES["img26"]["name"]);
$img26 = "img26" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp26);
move_uploaded_file($_FILES["img26"]["tmp_name"], "review/" . $img26);
}	
	
if($_FILES['img27']['size'] == 0){
$img27 = $_POST["up_img27"];
}else if($_FILES['img27']['size'] != 0){
$temp27 = explode(".", $_FILES["img27"]["name"]);
$img27 = "img27" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp27);
move_uploaded_file($_FILES["img27"]["tmp_name"], "review/" . $img27);
}
	
if($_FILES['img28']['size'] == 0){
$img28 = $_POST["up_img28"];
}else if($_FILES['img28']['size'] != 0){
$temp28 = explode(".", $_FILES["img28"]["name"]);
$img28 = "img28" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp28);
move_uploaded_file($_FILES["img28"]["tmp_name"], "review/" . $img28);
}		

if($_FILES['img29']['size'] == 0){
$img29 = $_POST["up_img29"];
}else if($_FILES['img29']['size'] != 0){
$temp29 = explode(".", $_FILES["img29"]["name"]);
$img29 = "img29" . "_" . $product_id . "_" . round(microtime(true)) . '.' . end($temp29);
move_uploaded_file($_FILES["img29"]["tmp_name"], "review/" . $img29);
}		
	
	
	
if($leaflet_id!=''){	

$save="Update tb_product_leaflet set
product_id='".$product_id."',product_code='".$product_code."',product_name='".$product_name."',product_sn='".$product_sn."',product_photo='".$product_photo."',ingredient1='".$ingredient1."',ingredient2='".$ingredient2."',ingredient3='".$ingredient3."',ingredient4='".$ingredient4."',ingredient5='".$ingredient5."',ingredient6='".$ingredient6."',ingredient7='".$ingredient7."',ingredient8='".$ingredient8."',ingredient9='".$ingredient9."',ingredient10='".$ingredient10."',ingredient11='".$ingredient11."',ingredient12='".$ingredient12."',ingredient13='".$ingredient13."',ingredient14='".$ingredient14."',ingredient15='".$ingredient15."',ingredient16='".$ingredient16."',ingredient17='".$ingredient17."',ingredient18='".$ingredient18."',ingredient19='".$ingredient19."',ingredient20='".$ingredient20."',ingredient21='".$ingredient21."',ingredient22='".$ingredient22."',ingredient23='".$ingredient23."',ingredient24='".$ingredient24."',ingredient25='".$ingredient25."',ingredient26='".$ingredient26."',ingredient27='".$ingredient27."',ingredient28='".$ingredient28."',ingredient29='".$ingredient29."' ,img1 ='".$img1."',img2 ='".$img2."',img3 ='".$img3."',img4 ='".$img4."',img5 ='".$img5."',img6 ='".$img6."',img7 ='".$img7."',img8 ='".$img8."',img9 ='".$img9."',img10 ='".$img10."',img11 ='".$img11."',img12 ='".$img12."',img13 ='".$img13."',img14 ='".$img14."',img15 ='".$img15."',img16 ='".$img16."',img17 ='".$img17."',img18 ='".$img18."',img19 ='".$img19."',img20 ='".$img20."',img21 ='".$img21."',img22 ='".$img22."',img23 ='".$img23."',img24 ='".$img24."',img25 ='".$img25."',img26 ='".$img26."',img27 ='".$img27."',img28 ='".$img28."',img29 ='".$img29."',edit_by='".$add_by."',edit_date='".$add_date."'   where leaflet_id ='".$leaflet_id."'
";
$qsave=mysqli_query($conn,$save);


}else{
	
$qfirst = "select * from tb_product_leaflet ORDER BY leaflet_id DESC LIMIT 1";
$first = mysqli_query($conn,$qfirst);
$ffirst = mysqli_fetch_array($first);
	
$leaflet_id = $ffirst['leaflet_id']+1;
	

$save="insert into tb_product_leaflet
(product_id,product_code,product_name,product_sn,product_photo,ingredient1,ingredient2,ingredient3,ingredient4,ingredient5,ingredient6,ingredient7,ingredient8,ingredient9,ingredient10,ingredient11,ingredient12,ingredient13,ingredient14,ingredient15,ingredient16,ingredient17,ingredient18,ingredient19,ingredient20,ingredient21,ingredient22,ingredient23,ingredient24,ingredient25,ingredient26,ingredient27,ingredient28,ingredient29,img1,img2,img3,img4,img5,img6,img7,img8,img9,img10,img11,img12,img13,img14,img15,img16,img17,img18,img19,img20,img21,img22,img23,img24,img25,img26,img27,img28,img29,add_by,add_date)
values
('".$product_id."','".$product_code."','".$product_name."','".$product_sn."','".$product_photo."','".$ingredient1."','".$ingredient2."','".$ingredient3."','".$ingredient4."','".$ingredient5."','".$ingredient6."','".$ingredient7."','".$ingredient8."','".$ingredient9."','".$ingredient10."','".$ingredient11."','".$ingredient12."','".$ingredient13."','".$ingredient14."','".$ingredient15."','".$ingredient16."','".$ingredient17."','".$ingredient18."','".$ingredient19."','".$ingredient20."','".$ingredient21."','".$ingredient22."','".$ingredient23."','".$ingredient24."','".$ingredient25."','".$ingredient26."','".$ingredient27."','".$ingredient28."','".$ingredient29."','".$img1."','".$img2."','".$img3."','".$img4."','".$img5."','".$img6."','".$img7."','".$img8."','".$img9."','".$img10."','".$img11."','".$img12."','".$img13."','".$img14."','".$img15."','".$img16."','".$img17."','".$img18."','".$img19."','".$img20."','".$img21."','".$img22."','".$img23."','".$img24."','".$img25."','".$img26."','".$img27."','".$img28."','".$img29."','".$add_by."','".$add_date."')";
$qsave=mysqli_query($conn,$save);	
	
	
}









 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='edit_leaflet.php?leaflet_id=$leaflet_id'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>