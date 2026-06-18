<?php 

include "dbconnect.php";
?>
<table style="width: 100%;">
<tr>
    <th>เลขที่เอกสาร</th>
    <th>ชื่อลูกค้า</th>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>จำนวน</th>
    <th>หน่วย</th>
    <th>สถานะ</th>
</tr>

<?php 
$strSQL = "
    SELECT 
        hos__br.ref_id_br,
        hos__br.iv_no,
        hos__br.customer,
        hos__br.status_doc,
        hos__subbr.ref_idd_br, 
        hos__subbr.count, 
        tb_product.sol_name,access_code,unit_name
    FROM 
        hos__br
    LEFT JOIN 
        hos__subbr ON hos__br.ref_id_br = hos__subbr.ref_idd_br
    LEFT JOIN 
        tb_product ON hos__subbr.product_ID = tb_product.product_id 
        WHERE hos__br.sale_code = 'MM2'  AND hos__br.customer like '%โอ%'
        LIMIT 200
";
$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");
while ($objResult = mysqli_fetch_array($objQuery)) {
    ?>


<tr>
    <td><?php echo $objResult['ref_id_br'];?></td>
    <td><?php echo $objResult['customer'];?></td>
    <td><?php echo $objResult['access_code'];?></td>
    <td><?php echo $objResult['sol_name'];?></td>
    <td><?php echo $objResult['count'];?></td>
    <td><?php echo $objResult['unit_name'];?></td>
    <td><?php echo $objResult['status_doc'];?></td>
</tr>


    <?php 
}

?>
</table>