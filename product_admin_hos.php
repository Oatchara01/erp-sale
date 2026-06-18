<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script>
function OpenPopup(rows)
	{
		window.open('getData.php?Line='+rows,'myPopup','width=650,height=200,toolbar=0, menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
	}
</script>
<script type="text/javascript">
$(document).ready(function(){
	
	$pd = "select * from hos__subso where ref_id='$ref_id'";
	$qpd = mysqli_query($conn,$pd);
	while ($fpd = mysqli_fetch_array($qpd);){
		var rows = 1;
		$("#createRows").click(function(){
						var tr = "<tr>";
						tr = tr + "<td><input type='text' name='no"+rows+"' id='no"+rows+"' class='w3-input' value='"+rows+"'></td>";
						tr = tr + "<td><input type='text' name='access_code"+rows+"' id='access_code"+rows+"' class='w3-input' onclick=OpenPopup("+rows+")></td>";
						tr = tr + "<td><input type='hidden' name='product_id"+rows+"' id='product_id"+rows+"'><input type='text' name='access_name"+rows+"' id='access_name"+rows+"' class='w3-input'></td>";
						tr = tr + "<td><input type='text' name='count"+rows+"' id='count"+rows+"' class='w3-input' OnKeyup='IsNumerid(this.value,this)' OnChange='JavaScript:chkNum(this,"+rows+")' style='text-align:center' required></td>";
						tr = tr + "<td><input type='text' name='unit_name"+rows+"' id='unit_name"+rows+"' class='w3-input'></td>";
						tr = tr + "<td><input style='text-align:right' type='text' name='sol_price"+rows+"' id='sol_price"+rows+"' class='w3-input' OnChange='JavaScript:chkNum(this,"+rows+")' onKeyUp='IsNumerid(this.value,this)' ></td>";
						tr = tr + "<td><input type='text' name='discount"+rows+"' id='discount"+rows+"' class='w3-input' OnChange='JavaScript:chkNum(this,"+rows+")' onKeyUp='IsNumerid(this.value,this)' style='text-align:right'></td>";
						tr = tr + "<td><input type='text' name='amount"+rows+"' id='amount"+rows+"' class='w3-input' OnChange='JavaScript:chkNum(this,"+rows+")' style='text-align:right' readonly></td>";
						tr = tr + "<td><input type='text' name='warranty"+rows+"' id='warranty"+rows+"' class='w3-input'></td>";
						tr = tr + "<td><input type='text' name='cal"+rows+"' id='cal"+rows+"' class='w3-input'></td>";
						tr = tr + "<td><input type='text' name='pm"+rows+"' id='pm"+rows+"' class='w3-input'></td>";
						tr = tr + "<td><input type='text' name='sn"+rows+"' id='sn"+rows+"' class='w3-input' readonly></td>";
						tr = tr + "<td><input type='text' name='sale_remark"+rows+"' id='sale_remark"+rows+"' class='w3-input'></td>";
						tr = tr + "</tr>";
						$('#myTable > tbody:last').append(tr);
					
						$('#hdnCount').val(rows);
						rows = rows + 1;
			});
		}

		$("#deleteRows").click(function(){
				if ($("#myTable tr").length != 1) {
					 $("#myTable tr:last").remove();
				}
		});

		$("#clearRows").click(function(){
				rows = 1;
				$('#hdnCount').val(rows);
				$('#myTable > tbody:last').empty(); // remove all
		});

	});
</script>
<meta charset=utf-8 />
</head>
<body>
<div class="w3-bar w3-light-grey"><font size="5px"><b>ข้อมูลสินค้า</b></font> **สำหรับ CAL และ PM ใส่จำนวนครั้งต่อปี**</div>
<div style="overflow-x:auto;">
<table width="100%" border="0" id="myTable" class="w3-table">
<!-- head table -->
<thead class="w3-border w3-pale-blue">
  <tr>
    <td style='width:5%;'> <div align="center"># </div></td>
	<td style='width:10%;'> <div align="center">รหัส </div></td>
    <td style='width:15%;'> <div align="center">ชื่อสินค้า </div></td>
	<td style='width:5%;'> <div align="center">จำนวน </div></td>
    <td style='width:5%;'> <div align="center">หน่วย </div></td>
    <td style='width:5%;'> <div align="center">ราคา </div></td>
	<td style='width:5%;'> <div align="center">ส่วนลด </div></td>
	<td style='width:10%;'> <div align="center">ราคารวม </div></td>
	<td style='width:5%;'> <div align="center">รับประกัน </div></td>
	<td style='width:5%;'> <div align="center">CAL </div></td>
	<td style='width:5%;'> <div align="center">PM </div></td>
	<td style='width:10%;'> <div align="center">Serials </div></td>
	<td style='width:15%;'> <div align="center">หมายเหตุ </div></td>
  </tr>
</thead>
<!-- body dynamic rows -->
<tbody class="w3-border"></tbody>
</table>
</div>
<br />
<center>
<input type="button" id="createRows" class="w3-button w3-pale-green" value="Add">
<input type="button" id="deleteRows" class="w3-button w3-pale-red" value="Del">
<input type="button" id="clearRows" class="w3-button w3-pale-yellow" value="Clear">
 <center>
 <br>
 <input type="hidden" id="hdnCount" name="hdnCount">
</body>
</html>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script>
function addCommas(nStr)
        {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

               function chkNum(ele, rows)
        {

            var item_price1 = document.forms["frmMain"]["sol_price" + rows].value;
//                            product_price = item_price1.split(",");
//
//
            var extra_price1 = document.forms["frmMain"]["discount" + rows].value;
//                            discount_unit = extra_price1.replace(",","");


            price_per_unit = item_price1.replace(/\,/g, '')
            price_per_unit = Number(price_per_unit)
            discount_unit = extra_price1.replace(/\,/g, '')
            discount_unit = Number(discount_unit)
            //alert(price_per_unit);
            c = price_per_unit - discount_unit;

            var qty1 = document.forms["frmMain"]["count" + rows].value;
            sale_count = qty1.replace(",", "");


            t = Number(sale_count) * c;
            document.getElementById("sol_price" + rows).value = addCommas(price_per_unit);
            //alert(a.toPrecision(3));
            document.getElementById("discount" + rows).value = addCommas(discount_unit);
            document.getElementById("count" + rows).value = addCommas(sale_count);


            if (t > 0) {
                document.getElementById("amount" + rows).value = addCommas(t.toFixed(2));
            } else {
                document.getElementById("amount" + rows).value = 0
            }

        }
  	function chkNum_a(ele, no2)
        {

            var item_price2 = document.forms["frmMain"]["sol_price_a" + no2].value;
//                            product_price_a = item_price1.split(",");
//
//
            var extra_price2 = document.forms["frmMain"]["discount_a" + no2].value;
//                            discount_unit_a = extra_price1.replace(",","");


            product_price_a = item_price2.replace(/\,/g, '')
            product_price_a = Number(product_price_a)
            discount_unit_a = extra_price2.replace(/\,/g, '')
            discount_unit_a = Number(discount_unit_a)
            //alert(product_price_a);
            c = product_price_a - discount_unit_a;

            var qty2 = document.forms["frmMain"]["sale_a" + no2].value;
            sale_count_a = qty2.replace(",", "");no2


            t = Number(sale_count_a) * c;
            document.getElementById("sol_price_a" + no2).value = addCommas(product_price_a);
            //alert(a.toPrecision(3));
            document.getElementById("discount_a" + no2).value = addCommas(discount_unit_a);
            document.getElementById("count_a" + no2).value = addCommas(sale_count_a);


            if (t > 0) {
                document.getElementById("total_a" + no2).value = addCommas(t.toFixed(2));
            } else {
                document.getElementById("total_a" + no2).value = 0
            }

        }
</script>