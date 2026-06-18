<?php
	include('dbconnect.php');
	if ($_POST['submit']) {
		$main_id = $_POST["main_id"];
		$ref_id = $_POST["ref_id"];
		$company = $_POST["company"];
		$suggest = $_POST["suggest"];
		$date = $_POST["date"];
		$ref_no = $_POST["ref_no"];
		$job_no = $_POST["job_no"];
		$dep_no = $_POST["dep_no"];
		$sale_channel = $_POST['sale_channel'];
		$bill_name = $_POST["bill_name"];
		$bill_address = $_POST["bill_address"];
		$bill_tel = $_POST["bill_tel"];
		$payment = $_POST['payment'];
		$delivery_place = $_POST["delivery_place"];
		$delivery_contact = $_POST["delivery_contact"];
		$po_no = $_POST['po_no'];
		$delivery_contract = $_POST['delivery_contract'];
		$free_items = $_POST['free_items'];
		$book_clear = $_POST['book_clear'];
		$book_no = $_POST['book_no'];
		$brn_clear = $_POST['brn_clear'];
		$brn_no = $_POST['brn_no'];
		$brnp_clear = $_POST['brnp_clear'];
		$brnp_no = $_POST['brnp_no'];
		$installed= $_POST['installed'];
		$bq = $_POST['bq'];
		$ot = $_POST['ot'];
		$with_pr = $_POST['with_pr'];
		$full_bill = $_POST['full_bill'];
		$type_type = $_POST['type_type'];
		$type_detail = $_POST['type_detail'];
		$delivery_choice = $_POST["delivery_choice"];
		$delivery_date = $_POST["delivery_date"];
		$delivery_time = $_POST["delivery_time"];
		$big_car = $_POST['big_car'];
		$map = $_POST['map'];
		$call_before = $_POST['call_before'];
		$assign = $_POST['assign'];
		$sale_comment = $_POST['sale_comment'];
		$sale = $_POST['sale'];
		$sale_date = $_POST['sale_date'];
		$status = 0;

		move_uploaded_file($_FILES['mapfile']['tmp_name'],"map/".iconv("UTF-8", "TIS-620",$_FILES['mapfile']['name']));

		echo $main_id '|' $ref_id '|' $company '|' $suggest '|' $date '|' $ref_no '|' $job_no '|' $dep_no '|' $sale_channel '|' $bill_name '|' $bill_address '|' $bill_tel '|' $payment '|' $delivery_place '|' $delivery_contact '|' $po_no '|' $delivery_contract '|' $free_items '|' $book_clear '|' $book_no '|' $brn_clear '|' $brn_no '|' $brnp_clear '|' $brnp_no '|' $installed '|' $bq '|' $ot '|' $with_pr '|' $full_bill '|' $type_type '|' $type_detail '|' $delivery_choice '|' $delivery_date '|' $delivery_time '|' $big_car '|' $map '|' .$_FILES["mapfile"]["tmp_name"]. '|' $call_before '|' $assign '|' $sale_comment '|' $sale '|' $sale_date '|' $status;

		if (!mysqli_query($conn,$save))   {
				echo("Error description: " . mysqli_error($conn)); //เขียนดักว่ามี error ที่เกิด
		}
		else {}

	}
mysqli_close($conn);		