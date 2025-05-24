<?php
$countAllSql = "SELECT COUNT(*) as total FROM tbl_internal_expenses";
$countResult = mysqli_query($connect, $countAllSql);
$total_records_row = mysqli_fetch_assoc($countResult);
$total_records = $total_records_row['total'];

$pageIndex = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pageSize = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
if ($pageSize <= 0) $pageSize = 5; // Đảm bảo pageSize > 0

$total_page = ceil($total_records / $pageSize);
if ($pageIndex > $total_page && $total_page > 0) $pageIndex = $total_page; // Giới hạn pageIndex
if ($pageIndex < 1) $pageIndex = 1; // Đảm bảo pageIndex >= 1


$start = ($pageIndex - 1) * $pageSize;

$search = '';
$search_query_part = "";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($connect, $_GET['search']);
    $search_query_part = " WHERE
        description LIKE N'%" . $search . "%'
        OR category LIKE N'%" . $search . "%'
        OR notes LIKE N'%" . $search . "%'
        OR DATE_FORMAT(expense_date, '%d/%m/%Y') LIKE N'%" . $search . "%' 
    "; // Thêm tìm kiếm theo ngày (dd/mm/yyyy)
}

// Lấy dữ liệu cho bảng
$getTableDataSql = "SELECT * FROM tbl_internal_expenses "
    . $search_query_part .
    " ORDER BY expense_date DESC, id DESC 
    LIMIT $start, $pageSize";

$tableData = mysqli_query($connect, $getTableDataSql);

// Lấy lại tổng số bản ghi nếu có tìm kiếm (để phân trang chính xác hơn)
if (!empty($search_query_part)) {
    $countSearchSql = "SELECT COUNT(*) as total FROM tbl_internal_expenses " . $search_query_part;
    $countSearchResult = mysqli_query($connect, $countSearchSql);
    $total_records_search_row = mysqli_fetch_assoc($countSearchResult);
    $total_records_for_pagination = $total_records_search_row['total'];
    $total_page = ceil($total_records_for_pagination / $pageSize);
    if ($pageIndex > $total_page && $total_page > 0) $pageIndex = $total_page;
    if ($pageIndex < 1) $pageIndex = 1;
} else {
    $total_records_for_pagination = $total_records;
}

?>


<div class="text-left flex justify-between items-center"> <!-- Thêm items-center cho căn giữa theo chiều dọc -->
    <button type="button" class="btn btn-primary mb-2 mt-3" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
        <i class="fa-solid fa-plus"></i>
        Thêm Chi Tiêu
    </button>

    <div class="input-group mb-3 mt-3" style="width: 40%;"> <!-- Điều chỉnh width nếu cần -->
        <input type="text" class="form-control" placeholder="Tìm kiếm mô tả, danh mục, ghi chú, ngày (dd/mm/yyyy)..." 
               aria-label="Tìm kiếm chi tiêu" name="search" id="search-input-expense" 
               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button class="btn btn-outline-secondary" id="search-button-expense" onclick="performExpenseSearch()">
            <i class="fa-solid fa-magnifying-glass"></i>
            Tìm kiếm
        </button>
    </div>
</div>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
<?php endif; ?>

<div class="container p-0">
    <table class="w-100 table table-striped table-hover table-bordered"> <!-- Thêm class table của Bootstrap -->
        <legend class="text-center"><b>Quản lý kế toán Duckshop</b></legend>

        <thead class="table-dark"> <!-- Sử dụng class table-dark của Bootstrap -->
            <tr>
                <th class="noWrap text-center" style="width: 5%;">STT</th>
                <th class="noWrap text-center" style="width: 10%;">Ngày</th>
                <th class="noWrap" style="width: 30%;">Mô tả</th>
                <th class="noWrap" style="width: 15%;">Danh mục</th>
                <th class="noWrap text-end" style="width: 15%;">Số tiền (VNĐ)</th>
                <th class="noWrap" style="width: 15%;">Ghi chú</th>
                <th class="noWrap text-center" style="width: 10%;">Quản lý</th>
            </tr>
        </thead>

        <tbody class="table-body">
            <?php
            $displayOrder = 0;
            if ($tableData && mysqli_num_rows($tableData) > 0) {
                while ($row = mysqli_fetch_assoc($tableData)) { // Sử dụng fetch_assoc để dễ truy cập cột
                    $displayOrder++;
            ?>
                <tr>
                    <td class="text-center">
                        <?php echo  $displayOrder + ($pageIndex - 1) * $pageSize; ?>
                    </td>
                    <td class="text-center">
                        <?php echo date("d/m/Y", strtotime($row['expense_date'])); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row['description']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row['category']); ?>
                    </td>
                    <td class="text-end">
                        <?php echo number_format($row['amount'], 0, ',', '.'); ?>
                    </td>
                    <td>
                        <?php echo nl2br(htmlspecialchars($row['notes'])); ?>
                    </td>
                    <td class="text-center">
                        <div style="min-width: 100px; display: flex; justify-content: center; gap: 5px;"> <!-- Điều chỉnh cách hiển thị nút -->
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editExpensePopup_<?php echo $row['id']; ?>" title="Chỉnh sửa">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteExpensePopup_<?php echo $row['id']; ?>" title="Xóa">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php
                }
            } else { // if (mysqli_num_rows($tableData) > 0)
            ?>
                <tr>
                    <td colspan="7" class="text-center">
                        <?php echo "Hiện không có chi tiêu nào!" . (!empty($search) ? " cho tìm kiếm của bạn." : ""); ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <!-- Phân trang -->
    <nav class="row py-2 align-items-center" aria-label="Page navigation">
        <div class="paganation-infor col-md-6 py-2">
            <form id="limitFormExpenses" method="GET" class="d-inline-block">
                <input type="hidden" name="workingPage" value="expenses">
                <?php if (!empty($search)): ?>
                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <?php endif; ?>
                <label for="limitSelectExpenses">Hiển thị:</label>
                <select name="limit" id="limitSelectExpenses" onchange="document.getElementById('limitFormExpenses').submit();" class="form-select form-select-sm d-inline-block" style="width: auto;">
                    <option value="5" <?php if ($pageSize == 5) echo 'selected'; ?>>5</option>
                    <option value="10" <?php if ($pageSize == 10) echo 'selected'; ?>>10</option>
                    <option value="15" <?php if ($pageSize == 15) echo 'selected'; ?>>15</option>
                    <option value="25" <?php if ($pageSize == 25) echo 'selected'; ?>>25</option>
                </select>
                 mục trên mỗi trang.
            </form>
            <span class="ms-3">
                <?php
                $start_record = ($pageIndex - 1) * $pageSize + 1;
                $end_record = $pageIndex * $pageSize;
                if ($end_record > $total_records_for_pagination) {
                    $end_record = $total_records_for_pagination;
                }
                if ($total_records_for_pagination > 0) {
                    echo "Hiển thị " . $start_record . " - " . $end_record . " trên tổng số " . $total_records_for_pagination . " mục.";
                } else {
                    echo "Không có mục nào để hiển thị.";
                }
                ?>
            </span>
        </div>

        <?php if ($total_page > 1): ?>
        <div class="col-md-6 py-2">
            <ul class="pagination justify-content-end m-0">
                <?php if ($pageIndex > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?workingPage=expenses&limit=<?php echo $pageSize; ?>&page=<?php echo ($pageIndex - 1); ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">«</span>
                    </li>
                <?php endif; ?>

                <?php
                // Logic hiển thị các trang (có thể làm gọn hơn, ví dụ hiển thị ... nếu quá nhiều trang)
                $num_links = 2; // Số link ở mỗi bên của trang hiện tại
                $start_loop = max(1, $pageIndex - $num_links);
                $end_loop = min($total_page, $pageIndex + $num_links);

                if ($start_loop > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?workingPage=expenses&limit='.$pageSize.'&page=1'.(!empty($search) ? '&search='.urlencode($search) : '').'">1</a></li>';
                    if ($start_loop > 2) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                }

                for ($i = $start_loop; $i <= $end_loop; $i++): ?>
                    <li class="page-item <?php echo ($i == $pageIndex) ? 'active' : ''; ?>">
                        <a class="page-link" href="?workingPage=expenses&limit=<?php echo $pageSize; ?>&page=<?php echo $i; ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php
                if ($end_loop < $total_page) {
                    if ($end_loop < $total_page - 1) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                    echo '<li class="page-item"><a class="page-link" href="?workingPage=expenses&limit='.$pageSize.'&page='.$total_page.(!empty($search) ? '&search='.urlencode($search) : '').'">'.$total_page.'</a></li>';
                }
                ?>

                <?php if ($pageIndex < $total_page): ?>
                    <li class="page-item">
                        <a class="page-link" href="?workingPage=expenses&limit=<?php echo $pageSize; ?>&page=<?php echo ($pageIndex + 1); ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>" aria-label="Next">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                <?php else: ?>
                     <li class="page-item disabled">
                        <span class="page-link">»</span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; // end if $total_page > 1 ?>
    </nav>
</div>

<!-- Popup thêm chi tiêu -->
<?php include "./pages/Expenses/AddExpensePopup.php"; ?>

<!-- pre display all edit popup -->
<?php

$tableDataForPopups = mysqli_query($connect, $getTableDataSql);
if ($tableDataForPopups) {
    while ($row = mysqli_fetch_assoc($tableDataForPopups)) {
        include "./pages/Expenses/EditExpensePopup.php";
        include "./pages/Expenses/ConfirmDeleteExpensePopup.php";
    }
}
?>

<script>
    function performExpenseSearch() {
        var searchValue = document.getElementById('search-input-expense').value;
        var limit = document.getElementById('limitSelectExpenses').value; // Lấy limit hiện tại
        var url = '?workingPage=expenses&limit=' + limit + '&page=1'; // Luôn về trang 1 khi tìm kiếm mới
        if (searchValue.trim() !== '') {
            url += '&search=' + encodeURIComponent(searchValue);
        }
        window.location.href = url;
    }

    // Nếu người dùng nhấn Enter trong ô tìm kiếm
    document.getElementById('search-input-expense').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            performExpenseSearch();
        }
    });
</script>