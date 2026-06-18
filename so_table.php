<link rel="stylesheet" href="css/w3.css" type="text/css"/>
<script src="js/jquery-1.12.4.js"></script>
<script>
    $(document).ready(function(){
		var i=1;
        $(".add-row").click(function(){
            var access_code = $("#access_code").val();
            var product_id = $("#product_id").val();
			var count = $("#count").val();
			var unit_name = $("#unit_name").val();
			var sol_price = $("#sol_price").val();
			var discount = $("#discount").val();
			var amount = $("#amount").val();
			var warranty = $("#warranty").val();
			var cal = $("#cal").val();
			var pm = $("#pm").val();
			var sn = $("#sn").val();
			var sale_remark = $("#sale_remark").val();
            var markup = "<tr><td><input type='checkbox' name='record'><td><input type='text' name='access_code"+i+"' class='w3-input'></td><td><input type='text' name='product_id"+i+"' class='w3-input'></td><td><input type='text' name='count"+i+"' class='w3-input'></td><td><input type='text' name='unit_name"+i+"' class='w3-input'></td><td><input type='text' name='sol_price"+i+"' class='w3-input'></td><td><input type='text' name='discount"+i+"' class='w3-input'></td><td><input type='text' name='amount"+i+"' class='w3-input'></td><td><input type='text' name='warranty"+i+"' class='w3-input'></td><td><input type='text' name='cal"+i+"' class='w3-input'></td><td><input type='text' name='pm"+i+"' class='w3-input'></td></td><td><input type='text' name='sn"+i+"' class='w3-input'></td><td><input type='text' name='sale_remark"+i+"' class='w3-input'></td></tr>";
            $("table tbody").append(markup);
			i=i+1;
        });
        
        // Find and remove selected table rows
        $(".delete-row").click(function(){
            $("table tbody").find('input[name="record"]').each(function(){
            	if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                }
            });
        });
    });    
</script>
</head>
<body>
    <form>
    	<input type="button" class="add-row w3-button w3-pale-green" value="+">
    </form>
    <table style="width:100%;">
        <thead>
            <tr>
                <th>#</th>
				<th>รหัสสินค้า</th>
                <th>ชื่อสินค้า</th>
                <th>จำนวน</th>
				<th>หน่วย</th>
				<th>ราคา</th>
				<th>ส่วนลด</th>
				<th>สุทธิ</th>
				<th>ประกัน</th>
				<th>CAL</th>
				<th>PM</th>
				<th>SN</th>
				<th>หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <button type="button" class="delete-row w3-button w3-pale-red">-</button>
</body> 
</html>