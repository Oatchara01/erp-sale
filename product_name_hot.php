<!DOCTYPE html>
<html>
<head>
<title>SOL : ITEAMDEV</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="js/jquery-3.4.1.js"></script>
<script language="javascript">
function OpenPopup	
	{
		window.open("getData.php?Line=' + no1', 'myPopup', 'width=650,height=1500,toolbar=0, menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0");
}
</script>
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
                                                                <table id="myTbl" width="100%"  border="1" class="table  table-hover table-striped table-bordered w3-table">
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
                                                                <table id="myTbl" width="100%"  border="1" class="table  table-hover table-striped table-bordered w3-table ">

                                    <td height="35" colspan="16" align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;
                                                                                <button id="addRow" type="button" title="ADD" class="btn btn-primary btn-xs">+</button>   
                                        <button id="removeRow" title="DELETE" type="button" value="del" class="btn btn-primary btn-xs">-</button> &nbsp;&nbsp;&nbsp;
                                       
                                    </td>

                                </table>



                            </div>
                        </div><!-- /.panel-body -->
                    </div><!-- /.panel -->
                </div>
            </div>


<script type="text/javascript">



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
            NR += " <input type=\"text\" name=\"product_code[]\" id=\"product_code" + no1 + "\" readonly>";
            NR += "<span class=\"input-group-btn\" >";
            NR += "<button class=\"btn btn-default btn-sm w3-button\" type=\"button\" VALUE=\"...\" href=\"#Lowmodal\" data-toggle=\"modal\" data-target=\"#Lowmodal\" onClick=\"OpenPopup(" + no1 + ");\">";
            //OnClick=\"OpenPopup(" + no1 + ")\"
            NR += "<i class=\"fa fa-search\"></i>";
            NR += "</button>";
            NR += "</span>";
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
</html>