<link rel="stylesheet" href="./styles/EventStyles.css">

<?php
$productId = '';
$productName = "";
$productCode = "";

if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];
}


$getTableDataSql = "SELECT * FROM tbl_product WHERE id = '$productId'";
$tableData = mysqli_query($connect, $getTableDataSql);
while ($row = mysqli_fetch_array($tableData)) {
    $productName = $row['name'];
    $productCode = $row['code'];
}
?>

<?php

$countAllSql = "SELECT * FROM tbl_product_image WHERE product_id = '$productId'";
$total_records = mysqli_num_rows(mysqli_query($connect, $countAllSql));

$pageIndex = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = isset($_GET['limit']) ? $_GET['limit'] : 5;

$total_page = ceil($total_records / $pageSize);

$start = ($pageIndex - 1) * $pageSize;

$getTableDataSql = "";

$getTableDataSql = "SELECT * FROM tbl_product_image WHERE product_id = '$productId'
    LIMIT $start, $pageSize";

$tableData = mysqli_query($connect, $getTableDataSql);
?>

<div class="text-left flex justify-between">
    <button type="button" class="btn btn-primary mb-2 mt-3" data-bs-toggle="modal" data-bs-target="#addProductImageModal">
        <i class="fa-solid fa-plus"></i>
        Thêm ảnh
    </button>
</div>

<div class="container p-0">
    <table class="w-100">
        <legend class="text-center"><b>Quản lý ảnh của sản phẩm <?php echo $productName; ?> <?php if (trim($productCode) != "") echo '(Mã SP: ' . trim($productCode) . ')'; ?> </b></legend>

        <thead class="table-head w-100">
            <tr class="table-heading">
                <th class="noWrap">STT</th>
                <th class="noWrap">Các hình ảnh</th>
                <th class="noWrap">Mô tả hình ảnh</th>
                <th class="noWrap">Hình ảnh chính</th>
                <th class="noWrap">Tác vụ</th>
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
                        <?php echo  $displayOrder + ($pageIndex - 1) * $pageSize; ?>
                    </td>
                    <td>
                        <?php
                        $imageSource = str_starts_with($row['content'], 'http') ? $row['content'] : "../../admin/pages/ProductImage/{$row['content']}";

                        echo "<img style=\"width: 150px; height: 150px\" src=\"{$imageSource}\">";
                        ?>
                    </td>
                    <td>
                        <?php echo  $row['description']; ?>
                    </td>
                    <td>
                        <?php if ($row['main_image']) echo '<i class="fa-solid fa-check fa-lg"></i>';
                        else echo '<i class="fa-solid fa-xmark fa-lg"></i>'; ?>
                    </td>
                    <td>
                        <div style="min-width: 150px;">
                            <button type="button" class="btn btn-primary mb-2 mt-3 con-tooltip bottom" data-bs-toggle="modal" data-bs-target="#editPopup_<?php echo $row['id']; ?>">
                                <i class="fa-solid fa-pencil mr-1"></i>
                                <div class="tooltip ">
                                <p>Chỉnh sửa ảnh</p>
                            </div>
                            </button>
                            <button type="button" class="btn btn-primary mb-2 mt-3 con-tooltip bottom" data-bs-toggle="modal" data-bs-target="#confirmDeletePopup_<?php echo $row['id']; ?>">
                                <i class="fa-solid fa-trash mr-1"></i>
                                <div class="tooltip ">
                                <p>Xoá ảnh</p>
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
                    <td colspan="5">
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
                        url.searchParams.set("page", "1"); // Đặt page thành 1
                        url.searchParams.set("limit", selectedLimit);

                        window.location.href = url.toString();
                    }
                </script>

                <label class="mr-4">Showing
                    <?php
                    echo $pageSize . " of " . $total_records . " results";
                    ?>
                </label>
            </div>

            <ul class="m-0 pagination justify-content-end py-2 col">
                <li class="page-item">
                    <?php
                    if ($pageIndex > 1 && $total_page > 1) {
                        echo '<a class="page-link text-reset text-black" aria-label="Previous" href="?workingPage=productImage&productId=' . ($productId) . '&limit=' . ($pageSize) . '&page=' . ($pageIndex - 1) . '">
                        Previous
                        </a>';
                    }
                    ?>
                </li>

                <?php
                for ($i = 1; $i <= $total_page; $i++) {
                    if ($i == $pageIndex) {
                        echo '<li class="page-item light">
                        <span name="page" class="page-link text-reset text-white bg-dark" href="?workingPage=productImage&productId=' . ($productId) . '&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </span>
                        </li>';
                    } else {
                        echo '<li class="page-item light">
                        <a name="page" class="page-link text-reset text-black" href="?workingPage=productImage&productId=' . ($productId) . '&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
                        </li>';
                    }
                }
                ?>

                <?php
                if ($pageIndex < $total_page && $total_page > 1) {
                    echo '<li class="page-item light">
                    <a name="page" class="page-link text-reset text-black" aria-label="Next" href="?workingPage=productImage&productId=' . ($productId) . '&limit=' . ($pageSize) . '&page=' . ($pageIndex + 1) . '">
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
    include "./pages/ProductImage/EditProductImagePopup.php";
}
?>

<!-- pre display all confirm delete popup -->
<?php
$tableData = mysqli_query($connect, $getTableDataSql);

while ($row = mysqli_fetch_array($tableData)) {
    include "./pages/ProductImage/ConfirmDeleteProductImagePopup.php";
}
?>

<script>
    function performSearch() {
        var searchValue = document.getElementById('search-input').value;
        var limit = <?php echo $pageSize; ?>;
        var page = <?php echo $pageIndex; ?>;
        var url = '?workingPage=productImage';
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