<link rel="stylesheet" href="./styles/ProductStyles.css">

<?php
$countAllSql = "SELECT * FROM tbl_order 
inner join tbl_user on tbl_order.user_id  = tbl_user.id
inner join tbl_status  on tbl_status.id = tbl_order.status_id;";
$total_records = mysqli_num_rows(mysqli_query($connect, $countAllSql));

$pageIndex = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = isset($_GET['limit']) ? $_GET['limit'] : 5;

$total_page = ceil($total_records / $pageSize);

$start = ($pageIndex - 1) * $pageSize;

$search = '';

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
}

$getTableDataSql = "";

if (isset($_GET['search'])) {
    $getTableDataSql = "SELECT * FROM tbl_order
    WHERE
        tbl_order.code LIKE N'%" . $search . "%'
    LIMIT $start, $pageSize";
} else {
    $getTableDataSql = "SELECT * FROM tbl_order
    LIMIT $start, $pageSize";
}

$tableData = mysqli_query($connect, $getTableDataSql);
?>

<div class="text-left flex justify-between">
    <button type="button" class="btn btn-primary mb-2 mt-3" data-bs-toggle="modal" data-bs-target="#addOrder">
        <i class="fa-solid fa-plus"></i>
        Thêm đơn hàng
    </button>


    <div class="input-group mb-3 align-center mt-3 w-40">
        <input type="text" class="form-control" placeholder="Search..." aria-label="Recipient's username" name="search" id="search-input" aria-describedby="button-addon2">
        <button class="btn btn-outline-secondary" id="search-button" onclick="performSearch()" name="ok">
            <i class="fa-solid fa-magnifying-glass"></i>
            Search
        </button>
    </div>

</div>

<div class="container p-0">
    <table class="w-100">
        <legend class="text-center"><b>Quản lý đơn hàng</b></legend>

        <thead class="table-head w-100">
            <tr class="table-heading">
                <th class="noWrap">STT</th>
                <th class="noWrap">Mã đơn hàng</th>
                <th class="noWrap">Điện thoại nhận hàng</th>
                <th class="noWrap">Địa chỉ nhận</th>
                <th class="noWrap">Phí giao hàng</th>
                <th class="noWrap">Mô tả</th>
                <th class="noWrap">Quản lý </th>
            </tr>
        </thead>

        <tbody class="table-body">
            <?php
            $displayOrder = 0;
            $hasData = false;
            while ($row = mysqli_fetch_array($tableData)) {
                $displayOrder++;
                $hasData = true;
            ?>
                <tr>
                    <td>
                        <?php echo $displayOrder + ($pageIndex - 1) * $pageSize; ?>
                    </td>
                    <td class="tensanpham">
                        <?php echo $row['code'] ?>
                    </td>
                    <td>
                        <?php echo $row['receive_phone'] ?>
                    </td>
                    <td>
                        <?php echo $row['receive_address'] ?>
                    </td>
                    <td>
                        <?php echo $row['delivery_cost'] ?>
                    </td>
                    <td>
                        <?php echo $row['description'] ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary mb-2 mt-3 con-tooltip top" data-bs-toggle="modal" data-bs-target="#editPopup_<?php echo $row['id']; ?>">
                            <i class="fa-solid fa-pencil"></i>
                            <div class="tooltip">
                                <p>Chỉnh sửa đơn hàng</p>
                            </div>
                        </button>
                        <button type="button" class="btn btn-primary mb-2 mt-3 con-tooltip top" data-bs-toggle="modal" data-bs-target="#confirmPopup_<?php echo $row['id']; ?>">
                            <i class="fa-solid fa-trash mr-1"></i>
                            <div class="tooltip">
                                <p>Xóa đơn hàng</p>
                            </div>
                        </button>
                        <button type="button" class="btn btn-primary mb-2 mt-3 con-tooltip top" data-bs-toggle="modal" data-bs-target="#orderDetail_<?php echo $row['id']; ?>">
                            <i class="fa-solid fa-circle-info"></i>
                            <div class="tooltip">
                                <p>Sản phẩm đơn hàng</p>
                            </div>
                        </button>
                        <button type="button" class="btn btn-primary mb-2 mt-3 con-tooltip top" onclick="printElement('printOrder_<?php echo $row['id']; ?>')">
                            <i class="fa-solid fa-print"></i>
                            <div class="tooltip">
                                <p>In hóa đơn</p>
                            </div>
                        </button>
                    </td>
                </tr>
            <?php
            }

            if (!$hasData) {
            ?>
                <tr>
                    <td colspan="8">
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
                        echo '<a class="page-link text-reset text-black" aria-label="Previous" href="?workingPage=order&limit=' . ($pageSize) . '&page=' . ($pageIndex - 1) . '">
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
                        <span name="page" class="page-link text-reset text-white bg-dark" href="?workingPage=order&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </span>
                        </li>';
                    } else {
                        // Hiển thị trang đầu tiên
                        if ($i == 1) {
                            echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?workingPage=order&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
                            </li>';
                        }
                        // Hiển thị các trang ở giữa
                        else if ($i > $pageIndex - $range && $i < $pageIndex + $range) {
                            echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?workingPage=order&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
                            </li>';
                        }

                        // Hiển thị trang cuối cùng
                        else if ($i == $total_page) {
                            echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?workingPage=order&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
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
                    <a name="page" class="page-link text-reset text-black" aria-label="Next" href="?workingPage=order&limit=' . ($pageSize) . '&page=' . ($pageIndex + 1) . '">
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
    include "./pages/Order/OrderDetailTable.php";
}
?>

<!-- pre display all confirm delete popup -->
<?php
$tableData = mysqli_query($connect, $getTableDataSql);
while ($row = mysqli_fetch_array($tableData)) {
    include "./pages/Order/OrderConfirmDelete.php";
}
?>

<?php
$tableData = mysqli_query($connect, $getTableDataSql);
while ($row = mysqli_fetch_array($tableData)) {
    include "./pages/Order/EditOrderPopup.php";
}
?>

<?php
$tableData = mysqli_query($connect, $getTableDataSql);
while ($row = mysqli_fetch_array($tableData)) {
    include "./pages/Order/PrintOrderPage.php";
}
?>

<script>
    function performSearch() {
        var searchValue = document.getElementById('search-input').value;
        var limit = <?php echo $pageSize; ?>;
        var page = <?php echo $pageIndex; ?>;
        var url = '?workingPage=order';
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