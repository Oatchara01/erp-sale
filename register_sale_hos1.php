<?php
	include("head.php");
	if($_POST["submit"]) {
		$qget=mysqli_query($conn,"select max(id) as mid from hos__so");
		$no=mysqli_fetch_array($qget);
		$ref_id_now="SO".substr(date("Y")+543,2,3).date("m").str_pad( $no["mid"]+1, 3, '0', STR_PAD_LEFT);

		$ref_id=$ref_id_now;
		$company = $_POST["company"];

		//product
		$hdnLine = $_POST['hdnCount'];
		for ($i = 1; $i<= $hdnLine; $i++){
			/*$sol_price = $_POST["sol_price$i"];
			$discount = $_POST["discount$i"];
			$amount = $_POST["amount$i"];
			$sol_priceA = str_replace(",","","$sol_price");
			$discountA = str_replace(",","","$discount");
			$amountA = str_replace(",","","$amount");*/
			if($_POST["product_id$i"]==0){
			}
			else {
				$pd = "insert into hos__subso (id,ref_id,product_id,unit,count,price,discount,amount,warranty,cal,pm,sale_remark) 
				values ('',
				'$ref_id',
				'".$_POST["product_id$i"]."',
				'".$_POST["unit_name$i"]."',
				'".$_POST["count$i"]."',
				'".$_POST["sol_price$i"]."',
				'".$_POST["discount$i"]."',
				'".$_POST["amount$i"]."',
				'".$_POST["warranty$i"]."',
				'".$_POST["cal$i"]."',
				'".$_POST["pm$i"]."',
				'".$_POST["sale_remark$i"]."')";
				
				$qpd = mysqli_query($conn,$pd);
				if (!$qpd)   {
				echo("Error description: " . mysqli_error($conn)); //เน€เธเธตเธขเธเธ”เธฑเธเธงเนเธฒเธกเธต error เธ—เธตเนเน€เธเธดเธ”
				}
			}
		} 

		//so
		$date = $_POST["date"];
		$suggest = $_POST["suggest"];
		$bill_name = $_POST["bill_name"];
		$bill_address = $_POST["bill_address"];
		$bill_tel = $_POST["bill_tel"];
		$payment = $_POST["payment"];
		$po_no = $_POST["po_no"];
		$delivery_contract = $_POST["delivery_contract"];
		$install_place = $_POST["install_place"];
		$sale_comment = $_POST["sale_comment"];
		$book_clear = $_POST["book_clear"];
		$book_no = $_POST["book_no"];
		$brn_clear = $_POST["brn_clear"];
		$brn_no = $_POST["brn_no"];
		$brnp_clear = $_POST["brnp_clear"];
		$brnp_no = $_POST["brnp_no"];
		$type_type = $_POST["type_type"];
		$type_detail = $_POST["type_detail"];
		$salename = $_POST["sale"];
		$split = preg_split("/\|/",$salename);
		$sale_code = $split[0];
		$sale_name = $split[1];
		$sale_date = $_POST["sale_date"];
		$with_pr = $_POST["with_pr"];
		$full_bill = $_POST["full_bill"];
		$delivery_type = $_POST["delivery_type"];
		$delivery_date = $_POST["delivery_date"];
		$delivery_time = $_POST["delivery_time"];
		$delivery_place = $_POST["delivery_place"];
		$delivery_contact = $_POST["delivery_contact"];

		move_uploaded_file($_FILES['slip1']['tmp_name'],"slip/".iconv("UTF-8", "TIS-620",$_FILES['slip1']['name']));
		move_uploaded_file($_FILES['slip2']['tmp_name'],"slip/".iconv("UTF-8", "TIS-620",$_FILES['slip2']['name']));
		move_uploaded_file($_FILES['slip3']['tmp_name'],"slip/".iconv("UTF-8", "TIS-620",$_FILES['slip3']['name']));
		move_uploaded_file($_FILES['slip4']['tmp_name'],"slip/".iconv("UTF-8", "TIS-620",$_FILES['slip4']['name']));
		move_uploaded_file($_FILES['slip5']['tmp_name'],"slip/".iconv("UTF-8", "TIS-620",$_FILES['slip5']['name']));
		
		$so = "insert into hos__so (id,ref_id,company,date,suggest,bill_name,bill_address,bill_tel,po_no,delivery_contract,payment,full_bill,with_pr,book_clear,book_no,brn_clear,brn_no,brnp_clear,brnp_no,type_type,type_detail,install_place,delivery_type,delivery_date,delivery_time,sale_comment,sale,sale_code,sale_date,slip1,slip2,slip3,slip4,slip5,status) values ('','$ref_id','$company','$date','$suggest','$bill_name','$bill_address','$bill_tel','$po_no','$delivery_contract','$payment','$full_bill','$with_pr','$book_clear','$book_no','$brn_clear','$brn_no','$brnp_clear','$brnp_no','$type_type','$type_detail','$install_place','$delivery_type','$delivery_date','$delivery_time','$sale_comment','$sale_name','$sale_code','$sale_date','".$_FILES['slip1']['name']."','".$_FILES['slip2']['name']."','".$_FILES['slip3']['name']."','".$_FILES['slip4']['name']."','".$_FILES['slip5']['name']."','0')";

		$qso = mysqli_query($conn,$so);
		if(!$qso) {
			echo "Error to Save Sale Order : ".mysqli_error($conn);
		}

		//cs
		if($delivery_type=="4") {
			$start_date = $_POST["start_date"];
			$date_requir = $_POST["date_requir"];
			$start_time = $_POST["start_time"];
			$end_time = $_POST["end_time"];
			$work_status = $_POST["work_status"];
			$status_comment = $_POST["status_comment"];
			$department_show = $_POST["department_show"];
			$customer_typename = $_POST["customer_typename"];
			$company_name = $_POST["company_name"];
			$department_name = $_POST["department_name"];
			$cash = $_POST["cash"];
			$unit_cash = $_POST["unit_cash"];
			$check_paper = $_POST["check_paper"];
			$unit_check = $_POST["unit_check"];
			$credit_card = $_POST["credit_card"];
			$unit_credit = $_POST["unit_credit"];
			$bill = $_POST["bill"];
			$unit_bill = $_POST["unit_bill"];
			$tran = $_POST["tran"];
			$unit_tran = $_POST["unit_tran"];
			$dep = $_POST["dep"];
			$dept = $_POST["dept"];
			$want_bus = $_POST["want_bus"];
			$fix_date = $_POST["fix_date"];
			$no_money = $_POST["no_money"];
			$call_customer = $_POST["call_customer"];
			$call_back = $_POST["call_back"];
			$have_map = $_POST["have_map"];
			$address_name = $_POST["address_name"];
			$address_send = $_POST["address_send"];
			$product_sn = $_POST["product_sn"];
			$product = $_POST["product"];
			$customer_name = $_POST["customer_name"];
			$customer_contact = $_POST["customer_contact"];
			$customer_tel = $_POST["customer_tel"];
			$description = $_POST["description"];

			move_uploaded_file($_FILES['mapfile1']['tmp_name'],"map/".iconv("UTF-8", "TIS-620",$_FILES['mapfile1']['name']));
			move_uploaded_file($_FILES['mapfile2']['tmp_name'],"map/".iconv("UTF-8", "TIS-620",$_FILES['mapfile2']['name']));
			move_uploaded_file($_FILES['mapfile3']['tmp_name'],"map/".iconv("UTF-8", "TIS-620",$_FILES['mapfile3']['name']));
			move_uploaded_file($_FILES['mapfile4']['tmp_name'],"map/".iconv("UTF-8", "TIS-620",$_FILES['mapfile4']['name']));
			move_uploaded_file($_FILES['mapfile5']['tmp_name'],"map/".iconv("UTF-8", "TIS-620",$_FILES['mapfile5']['name']));
			
			$cs = "insert into hos__cs (id,
			ref_id,company,date,date_requir,start_time,end_time,status,status_comment,fix_datetime,no_money,call_customer,call_back,want_bus,cash,unit_cash,check_paper,unit_check,credit_card,unit_credit,bill,unit_bill,tran,unit_tran,dep,dept,department_show,customer_typename,company_name,department_name,customer_name,customer_contact,customer_tel,address_name,address_send,product_sn,product,employee_name,add_by,employee_tel,description,have_map,mapfile1,mapfile2,mapfile3,mapfile4,mapfile5)
			values ('',
			'$ref_id',
			'$company',
			'$start_date',
			'$date_requir',
			'$start_time',
			'$end_time',
			'$work_status',
			'$status_comment',
			'$fix_date',
			'$no_money',
			'$call_customer',
			'$call_back',
			'$want_bus',
			'$cash',
			'$unit_cash',
			'$check_paper',
			'$unit_check',
			'$credit_card',
			'$unit_credit',
			'$bill',
			'$unit_bill',
			'$tran',
			'$unit_tran',
			'$dep',
			'$dept',
			'$department_show',
			'$customer_typename',
			'$company_name',
			'$department_name',
			'$customer_name',
			'$customer_contact',
			'$customer_tel',
			'$address_name',
			'$address_send',
			'$product_sn',
			'$product',
			'$employee_name',
			'$add_by',
			'$employee_tel',
			'$description',
			'$have_map',
			'".$_FILES['mapfile1']['name']."',
			'".$_FILES['mapfile2']['name']."',
			'".$_FILES['mapfile3']['name']."',
			'".$_FILES['mapfile4']['name']."',
			'".$_FILES['mapfile5']['name']."')";
			
			$qcs = mysqli_query($conn,$cs);
			if(!$qcs) {
				echo "Error to Save CS : ".mysqli_error($conn);
			}
		}

		//more
		if($_POST["more"]!="") {
			$runway = $_POST["runway"];
			$road = $_POST["road"];
			$soy = $_POST["soy"];
			$soy_big = $_POST["soy_big"];
			$height_ltd = $_POST["height_ltd"];
			$car_load = $_POST["car_load"];
			$no_car_road = $_POST["no_car_road"];
			$car_park = $_POST["car_park"];
			$car_road = $_POST["car_road"];
			$car_home = $_POST["car_home"];
			$door_long = $_POST["door_long"];
			$slope = $_POST["slope"];
			$bundai = $_POST["bundai"];
			$unit_bundai = $_POST["unit_bundai"];
			$door_bigger = $_POST["door_bigger"];
			$door_longer = $_POST["door_longer"];
			$room_bigger = $_POST["room_bigger"];
			$room_longer = $_POST["room_longer"];
			$type_door = $_POST["type_door"];
			$home_type = $_POST["home_type"];
			$install = $_POST["install"];
			$bundai_install = $_POST["bundai_install"];
			$bundai_big = $_POST["bundai_big"];
			$bundai_hug = $_POST["bundai_hug"];
			$type_bundai = $_POST["type_bundai"];
			$lip = $_POST["lip"];
			$lip_big = $_POST["lip_big"];
			$lip_long = $_POST["lip_long"];
			$lip_weight = $_POST["lip_weight"];
			$up = $_POST["up"];
			$no_up = $_POST["no_up"];
			$head_bad = $_POST["head_bad"];
			$want_employee = $_POST["want_employee"];
			$employee_unit = $_POST["employee_unit"];
			$ferniger_name = $_POST["ferniger_name"];
			$ferniter_address = $_POST["ferniter_address"];
			$want_ex = $_POST["want_ex"];
			$want_credit = $_POST["want_credit"];
			$bank = $_POST["bank"];
			$want_prem = $_POST["want_prem"];
			$description_ja = $_POST["description_ja"];
			
			$csmore = "insert into hos__csmore (id,ref_id,company,runway,road,soy,soy_big,height_ltd,car_load,no_car_road,car_park,car_road,car_home,door_long,slope,bundai,unit_bundai,door_bigger,door_longer,room_bigger,room_longer,type_door,home_type,install,bundai_install,bundai_big,bundai_hug,type_bundai,lip,lip_big,lip_long,lip_weight,up,no_up,head_bad,want_employee,employee_unit,ferniger_name,ferniter_address,want_ex,want_credit,bank,want_prem,description_ja) values ('','$ref_id','$company','$runway','$road','$soy','$soy_big','$height_ltd','$car_load','$no_car_road','$car_park','$car_road','$car_home','$door_long','$slope','$bundai','$unit_bundai','$door_bigger','$door_longer','$room_bigger','$room_longer','$type_door','$home_type','$install','$bundai_install','$bundai_big','$bundai_hug','$type_bundai','$lip','$lip_big','$lip_long','$lip_weight','$up','$no_up','$head_bad','$want_employee','$employee_unit','$ferniger_name','$ferniter_address','$want_ex','$want_credit','$bank','$want_prem','$description_ja')";

			$qcsmore = mysqli_query($conn,$csmore);
			if(!$qcsmore) {
			echo "Error to Save More : ".mysqli_error($conn);
			}
		}
		if($qpd&&$qso) {
			echo "Save Successfully!";
		}
	}
include("foot.php"); ?>