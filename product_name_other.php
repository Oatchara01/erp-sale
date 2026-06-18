<!DOCTYPE html>
<html>
<head>
<title>SOL : ITEAMDEV</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="js/jquery-3.4.1.js"></script>
<script>



function myFunction() {
  var x = document.getElementById("mySelect").value;
  document.getElementById("demo").innerHTML = "You selected: " + x;
}
</script>

<!-- -->



   <div class="row">
  <div class="panel panel-default">
  <div class="panel-heading">
                            
 </div><!-- /.panel-heading -->
 <div class="panel-body">
<div class="dataTable_wrapper">
<table id="myTbl_a" width="100%"  border="1" class="table  table-hover table-striped table-bordered w3-table">
 <thead>
      <tr>

  <th>PRODUCT CODE</th>
<th>PRODUCT NANE</th>
  <th>DESCRIPTION</th>
  <th>QTY.</th>
  <th>UNIT NAME</th>
  <th>UNIT PRICE</th>
  <th>DISCOUNT / UNIT</th>
 <th>TOTAL</th>
</tr>
</thead>
 </table>
<table id="myTbl_a" width="100%"  border="1" class="table  table-hover table-striped table-bordered w3-table ">
<td height="35" colspan="16" align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;
 <button id="addRow_a" type="button" title="ADD" class="btn btn-primary btn-xs">+</button>   
<button id="removeRow_a" title="DELETE" type="button" value="del" class="btn btn-primary btn-xs">-</button> &nbsp;&nbsp;&nbsp;
</td>
</table>



                            </div>
                        </div><!-- /.panel-body -->
                    </div><!-- /.panel -->
                </div>
            </div>


<script type="text/javascript">



        function addCommas_a(nStr)
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



        function chkNum_a(ele, no2)
        {

            var item_price1 = document.forms["frmMain"]["product_price_a" + no2].value;
//                            product_price_a = item_price1.split(",");
//
//
            var extra_price1 = document.forms["frmMain"]["discount_unit_a" + no2].value;
//                            discount_unit_a = extra_price1.replace(",","");


            product_price_a = item_price1.replace(/\,/g, '')
            product_price_a = Number(product_price_a)
            discount_unit_a = extra_price1.replace(/\,/g, '')
            discount_unit_a = Number(discount_unit_a)
            //alert(product_price_a);
            c = product_price_a - discount_unit_a;

            var qty1 = document.forms["frmMain"]["sale_count_a" + no2].value;
            sale_count_a = qty1.replace(",", "");no2


            t = Number(sale_count_a) * c;
            document.getElementById("product_price_a" + no2).value = addCommas_a(product_price_a);
            //alert(a.toPrecision(3));
            document.getElementById("discount_unit_a" + no2).value = addCommas_a(discount_unit_a);
            document.getElementById("sale_count_a" + no2).value = addCommas_a(sale_count_a);


            if (t > 0) {
                document.getElementById("total_a" + no2).value = addCommas_a(t.toFixed(2));
            } else {
                document.getElementById("total_a" + no2).value = 0
            }

        }

    $(function() {
        $("#addRow_a").click(function() {
            //var c = document.frmMain.t.value;
            var no2 = $('#myTbl_a tr').length + 1;
            var no2 = no2 - 1;
            var NA = "";
            NA = "<tr>";
            NA += " <td>";
            NA += "<div class=\"form-group input-group\">";
            NA += " <input type=\"hidden\" name=\"product_code_a1[]\" id=\"product_code_a1" + no2 + "\"  class=\"form-control input-sm w3-input\" href=\"#Lowmodal\" data-toggle=\"modal\" data-target=\"#Lowmodal\" onClick=\"OpenPopupCA(" + no2 + ");\" readonly />";
            NA += " <input type=\"text\" name=\"product_code_a[]\" id=\"product_code_a" + no2 + "\" readonly>";
            NA += "<span class=\"input-group-btn\" >";
            NA += "<button class=\"btn btn-default btn-sm w3-button\" type=\"button\" VALUE=\"...\" href=\"#Lowmodal\" data-toggle=\"modal\" data-target=\"#Lowmodal\" onClick=\"OpenPopupCA(" + no2 + ");\">";
            //OnClick=\"OpenPopup(" + no2 + ")\"
            NA += "<i class=\"fa fa-search\"></i>";
            NA += "</button>";
            NA += "</span>";
            NA += "</div>";
            NA += "</td>";
            NA += " <td>";
            NA += "<input type=\"hidden\" name=\"model_id[]\" id=\"model_id" + no2 + "\">";
            NA += "<input type=\"text\" name=\"product_name_a[]\" id=\"product_name_a" + no2 + "\" class=\"form-control input-sm w3-input\"  />";
            NA += "</td>";
            NA += " <td>";
            NA += " <input type=\"text\" name=\"description_a[]\" id=\"description_a" + no2 + "\" class=\"form-control input-sm w3-input\" />";
            NA += "</td>";
            NA += " <td>";
            NA += " <input type=\"text\" name=\"sale_count_a[]\" id=\"sale_count_a" + no2 + "\" class=\"form-control input-sm w3-input\" onKeyUp=\"IsNumerid(this.value,this)\" OnChange=\"JavaScript:chkNum_a(this," + no2 + ")\" style=\"text-align:right\" />";
            NA += "</td>";
            NA += " <td>";
            NA += " <input type=\"text\" name=\"unit_name_a[]\" id=\"unit_name_a" + no2 + "\" class=\"form-control input-sm w3-input\" />";
            NA += "</td>";
            NA += " <td>";
            NA += " <input type=\"text\" name=\"product_price_a[]\" id=\"product_price_a" + no2 + "\" class=\"form-control input-sm w3-input\" OnChange=\"JavaScript:chkNum_a(this," + no2 + ")\" style=\"text-align:right\" onKeyUp=\"IsNumerid(this.value,this)\" />";
            NA += " <input type=\"hidden\" name=\"hdnInline[]\" id=\"hdnInline" + no2 + "\" value=\"" + no2 + "\" />";
            NA += "</td>";
            NA += "<td>";
            NA += " <input type=\"text\" name=\"discount_unit_a[]\" id=\"discount_unit_a" + no2 + "\" class=\"form-control input-sm w3-input\" OnChange=\"JavaScript:chkNum_a(this," + no2 + ")\" style=\"text-align:right\" onKeyUp=\"IsNumerid(this.value,this)\" />";
            NA += "</td>";
            NA += "<td>";
            NA += " <input type=\"text\" name=\"total_a[]\" id=\"total_a" + no2 + "\" class=\"form-control input-sm w3-input\" OnChange=\"JavaScript:chkNum_a(this," + no2 + ")\" style=\"text-align:right\" readonly />";
            NA += "</td>";
            NA += "</tr>";

			//alert(s);	
            $("#myTbl_a").append($(NA));
        });
       $("#removeRow_a").click(function() {
            if ($("#myTbl_a tr").size() > 1) {
                $("#myTbl_a tr:last").remove();
            } else {
                alert("ต้องมีรายการข้อมูลสินค้าอย่างน้อย 1 รายการ");
            }
        });
    });
</script>
<?php } ?>




</html>

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


function OpenPopupCA(window.open("getDataC.php?Line=' + no1', 'myPopup', 'width=650,height=800,toolbar=0, menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0");
)	{
	}






 

</script>
