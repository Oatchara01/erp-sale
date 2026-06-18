<?php
	include('dbconnect.php');
	
			$ref_id = '3';
			$sol_price = $_POST["sol_price$i"];
			$discount = $_POST["discount$i"];
			$amount = $_POST["amount$i"];
			$sol_replaceA = str_replace(",","","$sol_price");
			$discountA = str_replace(",","","$discount");
			$amountA = str_replace(",","","$amount");
			
				$pd = "insert into hos__subso (id,ref_id,no,product_id,unit,count,price,discount,amount,warranty,cal,pm,sn,sale_remark,stock_remark,admin_remark) 
				values ('',
				'$ref_id',
				'1',
				'4',
				'ชิ้น',
				'2',
				'100',
				'10',
				'180',
				'1',
				'1',
				'1',
				'',
				'test price',
				'',
				'')";
				
				$qpd = mysqli_query($conn,$pd);
				if (!$qpd)   {
				echo("Error description: " . mysqli_error($conn)); //เน€เธโฌเน€เธยเน€เธเธ•เน€เธเธเน€เธยเน€เธโ€เน€เธเธ‘เน€เธยเน€เธเธเน€เธยเน€เธเธ’เน€เธเธเน€เธเธ• error เน€เธโ€”เน€เธเธ•เน€เธยเน€เธโฌเน€เธยเน€เธเธ”เน€เธโ€
				}
				else if ($qpd) {
					echo ("It's OK!".mysqli_error($conn));
				}
			
mysqli_close($conn);		