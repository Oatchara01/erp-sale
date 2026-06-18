<?php include('head.php');
require_once __DIR__ . "/Methos_User.php"; 

// Pagination settings
$limit = 10; // Number of entries to show in a page.
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;

// Fetch total records
$total_records_query = "SELECT COUNT(*) FROM tb__rental WHERE ( status_key NOT IN ('0') ) ";
$total_records_result = mysqli_query($new, $total_records_query);
$total_records = mysqli_fetch_array($total_records_result)[0];
$total_pages = ceil($total_records / $limit);

// Fetch records with limit
$rental = "SELECT * FROM tb__rental WHERE ( status_key NOT IN ('0') ) ORDER BY status_key  ASC, ref_id DESC LIMIT $start_from, $limit";
$qrental = mysqli_query($new, $rental);
?>

<!-- ลำดับขั้นตอนที่ 5 -->
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        th,
        td {
            text-align: center;
            padding: 4px;
            border: 1px solid #ddd;
        }

        td:nth-child(4) {
            text-align: left;
        }
    </style>
</head>

<body>

    <div style="background-color: white; min-height: 150vh;">
        <div class="w3-container w3-padding-large">
            <div class="w3-panel w3-light-grey">
                <h3>อนุมัติใบเบิกเป็นสินค้าเช่า</h3>
            </div>
        </div>
        <div class="w3-container w3-padding-large">
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;  text-align: left;">
                <thead>
                    <tr>
                        <th>เลขที่อ้างอิง</th>
                        <th>เลขที่เอกสาร</th>
                        <th>วันที่ออกเอกสาร</th>
                        <th>รายการสินค้า</th>
                        <th>หมายเหตุ</th>
                        <th>ผู้บันทึก</th>
                        <th>สถานะ</th>
                        <th>อนุมัติ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($vrental = mysqli_fetch_array($qrental)) {
                        $items = rental_item($new, $vrental['ref_id']);
                        // แปลง array ให้เป็น string โดยคั่นด้วยลูกน้ำ
                        $items_string = implode('<br>', $items);
                    ?>
                        <tr>
                            <td><?php echo $vrental['ref_id']; ?></td>
                            <td><?php echo $vrental['ren_id']; ?></td>
                            <td><?php echo Date_thai_time($vrental['add_date']); ?></td>
                            <td><?php echo $items_string; ?></td>
                            <td><?php echo $vrental['remark_stock']; ?></td>
                            <td><?php echo username($new,$vrental['add_by']); ?></td>
                            <td><?php echo Status_name($vrental['status_key']); ?></td>
                            <td>
                                <?php if($vrental['status_key'] == '2') { ?>
                                <a href="rental_200_edit.php?ref_id=<?php echo $vrental['ref_id']; ?>" class="w3-button w3-padding-small "><img src="img/edit-icon.png" width="20" height="20" border="0"></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="pagination w3-margin-top">
                <?php
                echo '<div class="w3-bar w3-center">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        echo "<span class='w3-bar-item w3-button w3-green'>" . $i . "</span>";
                    } else {
                        echo "<a href='rental_200_main.php?page=" . $i . "' class='w3-bar-item w3-button w3-border'>" . $i . "</a>";
                    }
                }
                echo '</div>';
                ?>
            </div>
        </div>
    </div>

</body>

</html>