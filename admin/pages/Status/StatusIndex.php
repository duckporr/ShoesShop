<link rel="stylesheet" href="./styles/StatusStyles.css">

<?php
$countAllSql = "SELECT * FROM tbl_status;";
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
    $getTableDataSql = "SELECT * FROM tbl_status
    WHERE
        tbl_status.name LIKE N'%" . $search . "%'
        OR tbl_status.code LIKE N'%" . $search . "%'
    ORDER BY tbl_status.name ASC
    LIMIT $start, $pageSize";
} else {
    $getTableDataSql = "SELECT * FROM tbl_status
    ORDER BY tbl_status.name ASC 
    LIMIT $start, $pageSize";
}

$tableData = mysqli_query($connect, $getTableDataSql);
?>

<div class="text-left flex justify-between">
    <button type="button" class="btn btn-primary mb-2 mt-3" data-bs-toggle="modal" data-bs-target="#addStatusModal">
        <i class="fa-solid fa-plus"></i>
        Thêm trạng thái
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
        <legend class="text-center"><b>Quản lý trạng thái</b></legend>

        <thead class="table-head w-100">
            <tr class="table-heading">
                <th class="noWrap">STT</th>
                <th class="noWrap">Mã trạng thái</th>
                <th class="noWrap">Tên trạng thái</th>
                <th class="noWrap">Mô tả</th>
                <th class="noWrap">Quản lý</th>
            </tr>
        </thead>

        <tbody class="table-body">
            <?php
            $displayOrder = 0;
            while ($row = mysqli_fetch_array($tableData)) {
                $displayOrder++;
            ?>
                <tr>
                    <td>
                        <?php echo  $displayOrder + ($pageIndex - 1) * $pageSize; ?>
                    </td>
                    <td class="code">
                        <?php echo $row['code'] ?>
                    </td>
                    <td class="name">
                        <?php echo $row['name'] ?>
                    </td>
                    <td class="description">
                        <?php echo $row['description'] ?>
                    </td>
                    <td>
                        <div style="min-width: 150px;">
                            <button type="button" class="btn btn-primary mb-2 mt-3 con-tooltip top" data-bs-toggle="modal" data-bs-target="#editStatusPopup_<?php echo $row['id']; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                <div class="tooltip">
                                <p>Chỉnh sửa trạng thái</p>
                            </div> 
                            </button>
                            <button type="button" class="btn btn-primary mb-2 mt-3 con-tooltip top" data-bs-toggle="modal" data-bs-target="#confirmDeleteStatusPopup_<?php echo $row['id']; ?>">
                                <i class="fa-solid fa-trash mr-1"></i>
                                <div class="tooltip">
                                <p>Xóa trạng thái</p>
                            </div> 
                            </button>
                        </div>
                    </td>
                </tr>
            <?php
            }
            if($total_records == 0){
            ?>
                <tr>
                    <td colspan="5">
                        <?php echo "Hiện không có trạng thái nào!"?>
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

                        // Tạo một URL mới với giá trị page và limit mới
                        const url = new URL(window.location.href);
                        url.searchParams.set("page", "1"); // Đặt page thành 1
                        url.searchParams.set("limit", selectedLimit);

                        // Chuyển hướng đến URL mới
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
                        echo '<a class="page-link text-reset text-black" aria-label="Previous" href="?workingPage=status&limit=' . ($pageSize) . '&page=' . ($pageIndex - 1) . '">
                        Previous
                        </a>';
                    }
                    ?>
                </li>

                <?php
                for ($i = 1; $i <= $total_page; $i++) {
                    if ($i == $pageIndex) {
                        echo '<li class="page-item light">
                        <span name="page" class="page-link text-reset text-white bg-dark" href="?workingPage=status&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </span>
                        </li>';
                    } else {
                        echo '<li class="page-item light">
                        <a name="page" class="page-link text-reset text-black" href="?workingPage=status&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
                        </li>';
                    }
                }
                ?>

                <?php
                if ($pageIndex < $total_page && $total_page > 1) {
                    echo '<li class="page-item light">
                    <a name="page" class="page-link text-reset text-black" aria-label="Next" href="?workingPage=status&limit=' . ($pageSize) . '&page=' . ($pageIndex + 1) . '">
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
    include "./pages/Status/EditStatusPopup.php";
}
?>

<!-- pre display all confirm delete popup -->
<?php
$tableData = mysqli_query($connect, $getTableDataSql);

while ($row = mysqli_fetch_array($tableData)) {
    include "./pages/Status/ConfirmDeleteStatusPopup.php";
}
?>

<script>
    function performSearch() {
        var searchValue = document.getElementById('search-input').value;
        var limit = <?php echo $pageSize; ?>;
        var page = <?php echo $pageIndex; ?>;
        var url = '?workingPage=status';
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