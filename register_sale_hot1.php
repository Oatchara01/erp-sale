<?php
	include("head.php");
	include("dbconnect.php");
	date_default_timezone_set("Asia/Bangkok");
	if ($_POST["submit"] = "บันทึกข้อมูล") {
		$main_id = $_POST["main_id"];
		$ref_id = $_POST["ref_id"];
		$register_date = date("Y/m/d");
		$register_time = date("H:i:s");
		$company = $_POST["company"];
		if ($company='21') {
			$select_br_ptl = '0';
			$select_br_nbm = '0';
			$select_so_ptl = '1';
			$select_so_nbm = '0';
		}
		else if ($company='22') {
			$select_br_ptl = '0';
			$select_br_nbm = '0';
			$select_so_ptl = '0';
			$select_so_nbm = '1';
		}
		$job_id = $_POST["job_id"];
		$put_id = $_POST["put_id"];
		$sale_channel = $_POST['sale_channel'];
		$billing_name = $_POST["billing_name"];
		$billing_address = $_POST["billing_address"];
		$billing_tel = $_POST["billing_tel"];
		$payment = $_POST['payment'];
		$delivery_place = $_POST["delivery_place"];
		$delivery_contact = $_POST["delivery_contact"];
		$po_no = $_POST['po_no'];
		$delivery_contract = $_POST['delivery_contract'];
		$free_item = $_POST['free_item'];
		$clear_book_ckk = $_POST['clear_book_ckk'];
		$clear_book_no = $_POST['clear_book_no'];
		$clear_brn_no_ckk = $_POST['clear_brn_no_ckk'];
		$clear_brn_no = $_POST['clear_brn_no'];
		$clear_brnp_no_ckk = $_POST['clear_brnp_no_ckk'];
		$clear_brnp_no = $_POST['clear_brnp_no'];
		$install_place = $_POST['install_place'];
		$bq = $_POST['bq'];
		$ot = $_POST['ot'];
		$with_pr = $_POST['with_pr'];
		$type_com = $_POST['type_com'];
		$type_po = $_POST['type_po'];
		$type_type_detail = $_POST['type_type_detail'];
		$delivery_company = $_POST["delivery_company"];
		$delivery_sale = $_POST["delivery_sale"];
		$delivery_engineer = $_POST["delivery_engineer"];
		$delivery_customer = $_POST["delivery_customer"];
		$delivery_date = $_POST['delivery_date'];
		$delivery_time = $_POST['delivery_time'];
		$big_car = $_POST['big_car'];
		$maps = $_POST['maps'];
		$call_before = $_POST['call_before'];
		$assign_date_time = $_POST['assign_date_time'];
		$sale_comment = $_POST['sale_comment'];
		$save="insert into so__main (main_id,ref_id,register_date,register_time,select_br_ptl,select_br_nbm,select_so_ptl,select_so_nbm,job_id,put_id,sale_channel,billing_name,billing_address,billing_tel,payment,delivery_place,delivery_contact,free_item,clear_book_ckk,clear_book_no,clear_brn_no_ckk,clear_brn_no,clear_brnp_no_ckk,clear_brnp_no,install_place,bq,ot,with_pr,type_com,type_po,type_type_detail,delivery_company,delivery_sale,delivery_engineer,delivery_customer,delivery_date,delivery_time,big_car,maps,call_before,assign_date_time,sale_comment)
		values ($main_id,$ref_id,$register_date,$register_time,$select_br_ptl,$select_br_nbm,$select_so_ptl,$select_so_nbm,$job_id,$put_id,$sale_channel,$billing_name,$billing_address,$billing_tel,$payment,$delivery_place,$delivery_contact,$free_item,$clear_book_ckk,$clear_book_no,$clear_brn_no_ckk,$clear_brn_no,$clear_brnp_no_ckk,$clear_brnp_no,$install_place,$bq,$ot,$with_pr,$type_com,$type_po,$type_type_detail,$delivery_company,$delivery_sale,$delivery_engineer,$delivery_customer,$delivery_date,$delivery_time,$big_car,$maps,$call_before,$assign_date_time,$sale_comment)";
		
		//echo $save;
		//exit();
		if ($company=='') {
			echo "Can't Save : No Data!";
		}
		$qsave=mysqli_query($conn,$save);
	
		$hdnLine = $_POST["hdnLine"];
		echo  $hdnLine;
		for ($i = 1; $i<= (int)$hdnLine; $i++){
			if(isset($_POST["product_code$i"])){
				$strSQL = "insert into so__submain (ref_idd,product_code,product_name,unit_name,sale_count,price_per_unit,discount_unit,sum_amount,warranty,cal,pm,sn,sale_remark)
				values ('$ref_id',
				'".$_POST["product_code$i"]."',
				'".$_POST["product_name$i"]."',
				'".$_POST["unit_name$i"]."',
				'".$_POST["sale_count$i"]."',
				'".$_POST["price_per_unit$i"]."',
				'".$_POST["discount_unit$i"]."',
				'".$_POST["sum_amount$i"]."',
				'".$_POST["warranty$i"]."',
				'".$_POST["cal$i"]."',
				'".$_POST["pm$i"]."',
				'".$_POST["sn$i"]."',
				'".$_POST["sale_remark$i"]."')";
				
				$objQuery = mysqli_query($conn,$strSQL);
				}
			if($qsave&&$objQuery) {
				//บันทึกเรียบร้อย
				/*print " <img src='img/small_compleate.gif' />Save Successfully <br />";	*/
				print " <img src='img/small_compleate.gif' /><span class='style10'>ref_id: </span><font color='0000ff'>".$ref_id." </font><span class='style10'>Save Successfully</span><br />";
				}
			else {
				//บันทึกไม่ได้
				print "<img src='img/false.png' /><span class='style9'> Error to save data </span><br />";
				}
			}
		}
?>

<p align="center"><a href="main_office.php"><span class="style18">กลับสู่หน้าหลัก</span></a></p>

</center>
</body>
</html>



