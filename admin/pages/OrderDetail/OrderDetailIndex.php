<link rel="stylesheet" href="./styles/EventStyles.css">

<?php
$orderId = '';
$orderCode = "";

if (isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];
}

$getTableDataSql = "SELECT * FROM tbl_order WHERE id = '$orderId'";

$tableData = mysqli_query($connect, $getTableDataSql);
while ($row = mysqli_fetch_array($tableData)) {
    $orderCode = $row['code'];
}
?>

<?php

$countAllSql = "SELECT * FROM tbl_order_detail WHERE order_id = '$orderId'";
$total_records = mysqli_num_rows(mysqli_query($connect, $countAllSql));

$pageIndex = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = isset($_GET['limit']) ? $_GET['limit'] : 5;

$total_page = ceil($total_records / $pageSize);

$start = ($pageIndex - 1) * $pageSize;

$getTableDataSql = "";

$getTableDataSql = "SELECT * FROM tbl_order_detail INNER JOIN tbl_product ON tbl_product.id = tbl_order_detail.product_id WHERE order_id = '$orderId'
    LIMIT $start, $pageSize";

$tableData = mysqli_query($connect, $getTableDataSql);
?>

<div class="text-left flex justify-between">
    <button type="button" class="btn btn-primary mb-2 mt-3" data-bs-toggle="modal" data-bs-target="#addOrderDetailModal">
        <i class="fa-solid fa-plus"></i>
        Thêm sản phẩm cho đơn hàng
    </button>
</div>

<div class="container p-0">
    <table class="w-100">
        <legend class="text-center"><b>Cập nhật sản phẩm cho đơn hàng <?php if (trim($orderCode) != "") echo $orderCode; ?></b></legend>

        <thead class="table-head w-100">
            <tr class="table-heading">
                <th class="noWrap">STT</th>
                <th class="noWrap">Mã sản phẩm</th>
                <th class="noWrap">Tên sản phẩm</th>
                <th class="noWrap">Kích cỡ</th>
                <th class="noWrap">Số lượng</th>
                <th class="noWrap">Đơn giá</th>
                <th class="noWrap">Quản lý</th>
            </tr>
        </thead>

        <tbody class="table-body">
            <?php
            $displayOrder = 0;
            $hasData = false;

            while ($rowOwningData = mysqli_fetch_array($tableData)) {
                $displayOrder++;
                $hasData = true;

                $getSizeSQL = "SELECT * FROM tbl_size WHERE id = '$rowOwningData[size_id]';";
                $sizeData = mysqli_query($connect, $getSizeSQL);
                $sizeCode = '';
                $sizeName = '';
                while ($sizeRow = mysqli_fetch_array($sizeData)) {
                    $sizeCode = $sizeRow['code'];
                    $sizeName = $sizeRow['name'];
                }
            ?>
                <tr>
                    <td>
                        <?php echo  $displayOrder + ($pageIndex - 1) * $pageSize; ?>
                    </td>
                    <td>
                        <?php echo $rowOwningData['code'] ?>
                    </td>
                    <td>
                        <?php echo $rowOwningData['name'] ?>
                    </td>
                    <td>
                        <?php echo $sizeName; ?>
                    </td>
                    <td>
                        <?php echo $rowOwningData['quantity'] ?>
                    </td>
                    <td>
                        <?php echo $rowOwningData['unit_price'] ?>
                    </td>
                    <td>
                        <div style="min-width: 150px;">
                            <button type="button" class="btn btn-primary mb-2 mt-3 con-tooltip top" data-bs-toggle="modal" data-bs-target="#editPopup_<?php echo $rowOwningData['order_id']; ?>_<?php echo $rowOwningData['product_id']; ?>_<?php echo $rowOwningData['size_id']; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                <div class="tooltip">
                                <p>Chỉnh sửa</p>
                            </div> 
                            </button>
                            <button type="button" class="btn btn-primary mb-2 mt-3 con-tooltip top" data-bs-toggle="modal" data-bs-target="#confirmDeletePopup_<?php echo $rowOwningData['order_id']; ?>_<?php echo $rowOwningData['product_id']; ?>_<?php echo $rowOwningData['size_id']; ?>">
                                <i class="fa-solid fa-trash mr-1"></i>
                                <div class="tooltip">
                                <p>Xóa</p>
                            </div> 
                            </button>
                        </div>
                    </td>
                </tr>
            <?php
            }
            if (!$hasData) {
            ?>
                <tr>
                    <td colspan="6">
                        Chưa có dữ liệu
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>

    </table>

    <form action="" method="GET">
        <nav class="row py-2" aria-label="Page navigation example">

            <div class="paganation-infor col py-2">
                <form action="" method="GET">
                    <label for="limitSelect">Rows per page:</label>
                    <select name="limit" id="limitSelect" onchange="updatePageAndLimit()">
                        <option value="5" <?php if ($pageSize == 5) echo 'selected'; ?>>5</option>
                        <option value="10" <?php if ($pageSize == 10) echo 'selected'; ?>>10</option>
                        <option value="15" <?php if ($pageSize == 15) echo 'selected'; ?>>15</option>
                    </select>
                </form>

                <script>
                    function updatePageAndLimit() {
                        const selectedLimit = document.getElementById("limitSelect").value;

                        const url = new URL(window.location.href);
                        url.searchParams.set("page", "1");
                        url.searchParams.set("limit", selectedLimit);

                        // Chuyển hướng đến URL mới
                        window.location.href = url.toString();
                    }
                </script>

                <label class="mr-4">Showing
                    <?php
                    $startItem = ($pageIndex - 1) * $pageSize + 1;
                    $endItem = min($pageIndex * $pageSize, $total_records);

                    echo "{$startItem} - {$endItem} of {$total_records} results";
                    ?>
                </label>
            </div>

            <ul class="m-0 pagination justify-content-end py-2 col">
                <li class="page-item">
                    <?php
                    if ($pageIndex > 1 && $total_page > 1) {
                        echo '<a class="page-link text-reset text-black" aria-label="Previous" href="?workingPage=orderDetail&limit=' . ($pageSize) . '&page=' . ($pageIndex - 1) . '">
                        Previous
                        </a>';
                    }
                    ?>
                </li>

                <?php
                $range = 3;
                for ($i = 1; $i <= $total_page; $i++) {
                    if ($i == $pageIndex) {
                        echo '<li class="page-item light">
                        <span name="page" class="page-link text-reset text-white bg-dark" href="?workingPage=orderDetail&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </span>
                        </li>';
                    } else {
                        // Hiển thị trang đầu tiên
                        if ($i == 1) {
                            echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?workingPage=orderDetail&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
                            </li>';
                        }
                        // Hiển thị các trang ở giữa
                        else if ($i > $pageIndex - $range && $i < $pageIndex + $range) {
                            echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?workingPage=orderDetail&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
                            </li>';
                        }

                        // Hiển thị trang cuối cùng
                        else if ($i == $total_page) {
                            echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?workingPage=orderDetail&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
                            </li>';
                        }

                        // Thêm dấu "..." nếu cần thiết
                        if (($i == $pageIndex - $range - 1 && $pageIndex - $range > 2) || ($i == $pageIndex + $range + 1 && $pageIndex + $range < $total_page - 1)) {
                            echo '<li class="page-item light">
                            <span class="page-link text-reset text-black"> ... </span>
                            </li>';
                        }
                    }
                }
                ?>

                <?php
                if ($pageIndex < $total_page && $total_page > 1) {
                    echo '<li class="page-item light">
                    <a name="page" class="page-link text-reset text-black" aria-label="Next" href="?workingPage=orderDetail&limit=' . ($pageSize) . '&page=' . ($pageIndex + 1) . '">
                    Next
                    </a>
                    </li>';
                }
                ?>
            </ul>
    </form>
    </nav>
</div>

<!-- pre display all edit popup -->
<?php
$tableData = mysqli_query($connect, $getTableDataSql);

while ($row = mysqli_fetch_array($tableData)) {
    $getSizeSQL = "SELECT * FROM tbl_size WHERE id = '$row[size_id]';";
    $sizeData = mysqli_query($connect, $getSizeSQL);
    $sizeCode = '';
    $sizeName = '';
    $sizeId = '';
    while ($sizeRow = mysqli_fetch_array($sizeData)) {
        $sizeCode = $sizeRow['code'];
        $sizeName = $sizeRow['name'];
        $sizeId = $sizeRow['id'];
    }

    include "./pages/OrderDetail/EditOrderDetailPopup.php";
}
?>

<!-- pre display all confirm delete popup -->
<?php
$tableData = mysqli_query($connect, $getTableDataSql);

while ($row = mysqli_fetch_array($tableData)) {
    include "./pages/OrderDetail/ConfirmDeleteOrderDetailPopup.php";
}
?>

<script>
    function performSearch() {
        var searchValue = document.getElementById('search-input').value;
        var limit = <?php echo $pageSize; ?>;
        var page = <?php echo $pageIndex; ?>;
        var url = '?workingPage=productSize';
        if (searchValue.trim() !== '') {
            url += '&search=' + encodeURIComponent(searchValue) + '&limit=' + limit + '&page=' + page;

        } else {
            url += '&limit=' + limit + '&page=' + page;

        }
        <?php
        ?>
        window.location.href = url;
    }
</script>