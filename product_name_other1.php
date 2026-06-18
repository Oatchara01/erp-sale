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

               function chkNum(ele, no1)
        {

            var item_price1 = document.forms["frmMain"]["product_price" + no1].value;
//                            product_price = item_price1.split(",");
//
//
            var extra_price1 = document.forms["frmMain"]["discount_unit" + no1].value;
//                            discount_unit = extra_price1.replace(",","");


            product_price = item_price1.replace(/\,/g, '')
            product_price = Number(product_price)
            discount_unit = extra_price1.replace(/\,/g, '')
            discount_unit = Number(discount_unit)
            //alert(product_price);
            c = product_price - discount_unit;

            var qty1 = document.forms["frmMain"]["sale_count" + no1].value;
            sale_count = qty1.replace(",", "");


            t = Number(sale_count) * c;
            document.getElementById("product_price" + no1).value = addCommas(product_price);
            //alert(a.toPrecision(3));
            document.getElementById("discount_unit" + no1).value = addCommas(discount_unit);
            document.getElementById("sale_count" + no1).value = addCommas(sale_count);


            if (t > 0) {
                document.getElementById("sum_amount" + no1).value = addCommas(t.toFixed(2));
            } else {
                document.getElementById("sum_amount" + no1).value = 0
            }

        }




  	function chkNum_a(ele, no2)
        {

            var item_price2 = document.forms["frmMain"]["product_price_a" + no2].value;
//                            product_price_a = item_price1.split(",");
//
//
            var extra_price2 = document.forms["frmMain"]["discount_unit_a" + no2].value;
//                            discount_unit_a = extra_price1.replace(",","");


            product_price_a = item_price2.replace(/\,/g, '')
            product_price_a = Number(product_price_a)
            discount_unit_a = extra_price2.replace(/\,/g, '')
            discount_unit_a = Number(discount_unit_a)
            //alert(product_price_a);
            c = product_price_a - discount_unit_a;

            var qty2 = document.forms["frmMain"]["sale_count_a" + no2].value;
            sale_count_a = qty2.replace(",", "");no2


            t = Number(sale_count_a) * c;
            document.getElementById("product_price_a" + no2).value = addCommas(product_price_a);
            //alert(a.toPrecision(3));
            document.getElementById("discount_unit_a" + no2).value = addCommas(discount_unit_a);
            document.getElementById("sale_count_a" + no2).value = addCommas(sale_count_a);


            if (t > 0) {
                document.getElementById("total_a" + no2).value = addCommas(t.toFixed(2));
            } else {
                document.getElementById("total_a" + no2).value = 0
            }

        }



 </script>
   <div class="row">
 <div class="panel panel-default">
<div class="panel-heading">
 <i class="fa fa-shopping-cart fa-fw"></i> ข้อมูลสินค้า    
</div><!-- /.panel-heading -->
<div class="panel-body">
<div class="dataTable_wrapper">
<table id="myTbl" class="table  table-hover table-striped table-bordered" >
<thead> 
<tr>

<th width="10%">Product Code</th>
<th width="10%">Product Name</th>
<th width="18%">Unit Name</th>
<th width="8%">Sale Count</th>
<th width="8%">Product Price</th>
<th width="8%">Discount/Unit</th>
<th width="10%">Amount</th>
<th width="8%">รับประกัน(ปี)</th>
<th width="3%">Cal(ครั้ง/ปี)</th>
<th width="10%">PM(ครั้ง/ปี)</th>
<th width="10%">Sale Remark</th>
</tr>
</thead>       
</table>
<table width="100%"   border="1" cellpadding="1" cellspacing="0" class="two" bordercolor="#CCCCCC">

<td height="35" colspan="16" align="left" bgcolor="#FFFFFF">&nbsp;&nbsp; 
<button id="addRow" type="button" title="เพิ่มแถว" class="btn btn-primary btn-xs">+</button>      
<button id="removeRow" title="ลบแถว" type="button" value="del" class="btn btn-primary btn-xs">-</button>  
</td>

</table>
</div>
</div><!-- /.panel-body -->
</div><!-- /.panel -->
</div>


</br></br>
<?php if($_SESSION['user_type']=="stock" or $_SESSION['user_type']=="admin" or $_SESSION['user_type']=="it") { ?>
<div class="row">
<div class="panel panel-default">
<div class="panel-heading">
<i class="fa fa-shopping-cart fa-fw"></i> อุปกรณ์เสริม    
</div><!-- /.panel-heading -->
<div class="panel-body">
<div class="dataTable_wrapper">
<table id="myTblt" class="table  table-hover table-striped table-bordered" >
<thead> 
<tr>
<th width="10%">BRAND</th>
<th width="10%">MODEL/Pdt. Code</th>
<th width="18%">DESCRIPTION</th>
<th width="8%">QTY.</th>
<th width="8%">UNIT NAME</th>
<th width="8%">UNIT PRICE</th>
<th width="10%">DISCOUNT / UNIT</th>
<th width="8%">TOTAL</th>
<th width="3%">WARRANTY</th>
<th width="10%">Serial No.</th>
<th width="10%">Lot No.</th>
</tr>
</thead>       
</table>
<table width="100%"   border="1" cellpadding="1" cellspacing="0" class="two" bordercolor="#CCCCCC">
<td height="35" colspan="16" align="left" bgcolor="#FFFFFF">&nbsp;&nbsp; 
<button id="addRowt" type="button" title="เพิ่มแถว" class="btn btn-primary btn-xs">+</button>      
<button id="removeRowt" title="ลบแถว" type="button" value="delt" class="btn btn-primary btn-xs">-</button>  
</td>
</table>
</div>
</div><!-- /.panel-body -->
</div><!-- /.panel -->
</div>
<?php } ?>
<script type="text/javascript">
   $(function() {
        $("#addRow").click(function() {
            //var c = document.frmMain.t.value;
            var no1 = $('#myTbl tr').length + 1;
            var no1 = no1 - 1;
            var NR = "";
            NR = "<tr>";
            NR += " <td>";
            NR += "<div class=\"form-group input-group\">";
            NR += " <input type=\"hidden\" name=\"product_code1[]\" id=\"product_code1" + no1 + "\"  class=\"form-control input-sm w3-input\" href=\"#Lowmodal\" data-toggle=\"modal\" data-target=\"#Lowmodal\" onClick=\"OpenPopup(" + no1 + ");\" readonly />";
            NR += " <input type=\"text\" name=\"product_code[]\" id=\"product_code" + no1 + "\"  class=\"form-control input-sm w3-input\" onClick=\"OpenPopup(" + no1 + ");\" readonly>";
            
            NR += "</div>";
            NR += "</td>";
            NR += " <td>";
            NR += "<input type=\"hidden\" name=\"model_id[]\" id=\"model_id" + no1 + "\">";
            NR += "<input type=\"text\" name=\"product_name[]\" id=\"product_name" + no1 + "\" class=\"form-control input-sm w3-input\"  />";
            NR += "</td>";
            NR += " <td>";
            NR += " <input type=\"text\" name=\"description[]\" id=\"description" + no1 + "\" class=\"form-control input-sm w3-input\" />";
            NR += "</td>";
            NR += " <td>";
            NR += " <input type=\"text\" name=\"sale_count[]\" id=\"sale_count" + no1 + "\" class=\"form-control input-sm w3-input\" onKeyUp=\"IsNumerid(this.value,this)\" OnChange=\"JavaScript:chkNum(this," + no1 + ")\" style=\"text-align:right\" />";
            NR += "</td>";
            NR += " <td>";
            NR += " <input type=\"text\" name=\"unit_name[]\" id=\"unit_name" + no1 + "\" class=\"form-control input-sm w3-input\" />";
            NR += "</td>";
            NR += " <td>";
            NR += " <input type=\"text\" name=\"product_price[]\" id=\"product_price" + no1 + "\" class=\"form-control input-sm w3-input\" OnChange=\"JavaScript:chkNum(this," + no1 + ")\" style=\"text-align:right\" onKeyUp=\"IsNumerid(this.value,this)\" />";
            NR += " <input type=\"hidden\" name=\"hdnInline[]\" id=\"hdnInline" + no1 + "\" value=\"" + no1 + "\" />";
            NR += "</td>";
            NR += "<td>";
            NR += " <input type=\"text\" name=\"discount_unit[]\" id=\"discount_unit" + no1 + "\" class=\"form-control input-sm w3-input\" OnChange=\"JavaScript:chkNum(this," + no1 + ")\" style=\"text-align:right\" onKeyUp=\"IsNumerid(this.value,this)\" />";
            NR += "</td>";
            NR += "<td>";
            NR += " <input type=\"text\" name=\"sum_amount[]\" id=\"sum_amount" + no1 + "\" class=\"form-control input-sm w3-input\" OnChange=\"JavaScript:chkNum(this," + no1 + ")\" style=\"text-align:right\" readonly />";
            NR += "</td>";
           NR += "<td>";
            NR += " <input type=\"text\" name=\"warranty[]\" id=\"warranty" + no1 + "\" class=\"form-control input-sm w3-input\" OnChange=\"JavaScript:chkNum(this," + no1 + ")\" style=\"text-align:right\" />";
            NR += "</td>";
            NR += "<td>";
            NR += " <input type=\"text\" name=\"serialno[]\" id=\"serialno" + no1 + "\" class=\"form-control input-sm w3-input\"  style=\"text-align:right\"  />";
            NR += "</td>";
            NR += "<td>";
            NR += " <input type=\"text\" name=\"lot_no[]\" id=\"lot_no" + no1 + "\" class=\"form-control input-sm w3-input\"  style=\"text-align:right\"  />";
            NR += "</td>";

            NR += "</tr>";


            //alert(s);	
            $("#myTbl").append($(NR));
        });
       $("#removeRow").click(function() {
            if ($("#myTbl tr").size() > 1) {
                $("#myTbl tr:last").remove();
            } else {
                alert("ต้องมีรายการข้อมูลสินค้าอย่างน้อย 1 รายการ");
            }
        });
    });

</script>
<script type="text/javascript">
    $(function() {
        $("#addRowt").click(function() {
            //var c = document.frmMain.t.value;
            var no2 = $('#myTblt tr').length + 1;
            // var no2 = no2 - 1;
            var no2 = no2;
            var NR = "";
            NR = "<tr>";
            NR += " <td>";
            NR += "<div class=\"form-group input-group\">";
            NR += " <input type=\"text\" name=\"product_code_a[]\" id=\"product_code_a" + no2 + "\" class=\"form-control input-sm w3-input\" href=\"#Lowmodal2\" data-toggle=\"modal\" data-target=\"#Lowmodal2\" onClick=\"js_popup('getDataC.php?Line_a=" + no2 +"');\"  readonly />";
            NR += " <input type=\"hidden\" name=\"brand_idt[]\" id=\"brand_idt" + no2 + "\">";
            
            NR += "</div>";
            NR += "</td>";
            NR += " <td>";
            NR += "<input type=\"hidden\" name=\"model_idt[]\" id=\"model_idt" + no2 + "\">";
            NR += "<input type=\"text\" name=\"product_name_a[]\" id=\"product_name_a" + no2 + "\" class=\"form-control input-sm w3-input\"  />";
            NR += "</td>";
            NR += " <td>";
            NR += " <input type=\"text\" name=\"description_a[]\" id=\"description_a" + no2 + "\" class=\"form-control input-sm w3-input\" />";
            NR += "</td>";
            NR += " <td>";
            NR += " <input type=\"text\" name=\"sale_count_a[]\" id=\"sale_count_a" + no2 + "\" class=\"form-control input-sm w3-input\" onKeyUp=\"IsNumerid(this.value,this)\" OnChange=\"JavaScript:chkNum_a(this," + no2 + ")\" style=\"text-align:right\" />";
            NR += "</td>";
            NR += " <td>";
            NR += " <input type=\"text\" name=\"unit_name_a[]\" id=\"unit_name_a" + no2 + "\" class=\"form-control input-sm w3-input\" />";
            NR += "</td>";
            NR += " <td>";
            NR += " <input type=\"text\" name=\"product_price_a[]\" id=\"product_price_a" + no2 + "\" class=\"form-control input-sm w3-input\" OnChange=\"JavaScript:chkNum_a(this," + no2 + ")\" style=\"text-align:right\" onKeyUp=\"IsNumerid(this.value,this)\" />";
            NR += " <input type=\"hidden\" name=\"hdnInline[]\" id=\"hdnInline" + no2 + "\" value=\"" + no2 + "\" />";
            NR += "</td>";
            NR += "<td>";
            NR += " <input type=\"text\" name=\"discount_unit_a[]\" id=\"discount_unit_a" + no2 + "\" class=\"form-control input-sm w3-input\" OnChange=\"JavaScript:chkNum_a(this," + no2 + ")\" style=\"text-align:right\" onKeyUp=\"IsNumerid(this.value,this)\" />";
            NR += "</td>";
            NR += "<td>";
            NR += " <input type=\"text\" name=\"total_a[]\" id=\"total_a" + no2 + "\" class=\"form-control input-sm w3-input\" OnChange=\"JavaScript:chkNum_a(this," + no2 + ")\" style=\"text-align:right\" readonly />";
            NR += "</td>";
            NR += "<td>";
            NR += " <input type=\"text\" name=\"warranty_a[]\" id=\"warranty_a" + no2 + "\" class=\"form-control input-sm w3-input\" OnChange=\"JavaScript:chkNum2(this," + no2 + ")\" style=\"text-align:right\"  />";
            NR += "</td>";
            NR += "<td>";
            NR += " <input type=\"text\" name=\"serialno_a[]\" id=\"serialno_a" + no2 + "\" class=\"form-control input-sm w3-input\"  style=\"text-align:right\"  />";
            NR += "</td>";
            NR += "<td>";
            NR += " <input type=\"text\" name=\"lot_no_a[]\" id=\"lot_no_a" + no2 + "\" class=\"form-control input-sm w3-input\"  style=\"text-align:right\"  />";
            NR += "</td>";

            NR += "</tr>";



            //alert(s); 
            $("#myTblt").append($(NR));
        });
        $("#removeRowt").click(function() {
            if ($("#myTblt tr").size() > 1) {
                $("#myTblt tr:last").remove();
            } else {
                alert("ต้องมีรายการข้อมูลสินค้าอย่างน้อย 1 รายกา");
            }
        });
    });

</script>

<script language="javascript">
   function selData3(intLine) {
        // window.alert(intLine)
        document.getElementById("s1").value = intLine;

        var company = document.forms[0];
        var txt = "";
        var i;
        for (i = 0; i < company.length; i++) {
            if (company[i].checked) {
                txt = txt + company[i].value + "";
            }
        }
        document.getElementById("tcom").value = txt;
        //x = document.forms["frmMain"]["tcom"].value;
        //window.alert(x)
    }

    function selData1() {
        var company = document.forms[0];
        var txt = "";
        var i;
        for (i = 0; i < company.length; i++) {
            if (company[i].checked) {
                txt = txt + company[i].value + "";
            }
        }
        document.getElementById("tcom").value = txt;
        //x = document.forms["frmMain"]["tcom"].value;
        //window.alert(x)
    }

</script>



<script language="javascript">
  /* function OpenPopup(no1) {
        var company = document.forms[0];
        var txt = "";
        var i;
        for (i = 0; i < company.length; i++) {
            if (company[i].checked) {
                txt = txt + company[i].value + "";
            }
        }
        //alert(company.length);
        document.getElementById("tcom").value = txt;
        x = document.forms["frmMain"]["tcom"].value;
        //x = document.forms["frmMain"]["company"].value;
        window.open('getData.php?Line=' + no1 + '&com=' + x, 'myPopup', 'width=650,height=100,toolbar=0, menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
    }*/



function OpenPopup	
	{
		window.open("getData.php?Line=' + no1', 'myPopup', 'width=2000,height=2500,toolbar=0, menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0");
}

</script>

<script language="javascript">


function js_popup(theURL,width,height) { //v2.0
leftpos = (screen.availWidth - width) / 2;
     toppos = (screen.availHeight - height) / 2;
   window.open(theURL, "viewdetails","width=" + width + ",height=" + height + ",left=" + leftpos + ",top=" + toppos);
}
</script>
 
