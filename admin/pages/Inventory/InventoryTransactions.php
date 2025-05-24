<?php
// admin/pages/Inventory/InventoryTransactions.php

if (!isset($connect)) {
    echo "<div class='alert alert-danger'>Lỗi: Không thể kết nối CSDL.</div>";
    return;
}

// Các tham số cho phân trang và tìm kiếm (dùng hậu tố _w để tránh xung đột với module khác)
$search_w = isset($_GET['search_w']) ? trim($_GET['search_w']) : '';
$page_w = isset($_GET['page_w']) ? (int)$_GET['page_w'] : 1;
$limit_w = isset($_GET['limit_w']) ? (int)$_GET['limit_w'] : 10;

if ($limit_w <= 0) $limit_w = 10;
if ($page_w < 1) $page_w = 1;

$start_record_index_w = ($page_w - 1) * $limit_w;

$search_conditions_w_array = [];
$search_params_w_array = [];
$param_types_w_string = "";

if (!empty($search_w)) {
    $search_like_term_w = "%" . $search_w . "%";
    // Tìm theo product_id trong tbl_warehouse hoặc notes
    $search_conditions_w_array[] = "(w.product_id LIKE ? OR w.notes LIKE ?)"; // Sử dụng alias 'w'
    $search_params_w_array[] = $search_like_term_w;
    $search_params_w_array[] = $search_like_term_w;
    $param_types_w_string .= "ss";
}

$where_clause_w_string = "";
if (!empty($search_conditions_w_array)) {
    $where_clause_w_string = " WHERE " . implode(" AND ", $search_conditions_w_array);
}

// Đếm tổng số bản ghi CHỈ từ tbl_warehouse
$sql_count_total_w = "SELECT COUNT(*) as total_records FROM tbl_warehouse w" . $where_clause_w_string; // Thêm alias 'w'
$stmt_count_w = mysqli_prepare($connect, $sql_count_total_w);
$total_records_w = 0;
if ($stmt_count_w) {
    if (!empty($search_params_w_array)) {
        mysqli_stmt_bind_param($stmt_count_w, $param_types_w_string, ...$search_params_w_array);
    }
    mysqli_stmt_execute($stmt_count_w);
    $result_total_w = mysqli_stmt_get_result($stmt_count_w);
    $row_total_w = mysqli_fetch_assoc($result_total_w);
    $total_records_w = $row_total_w['total_records'];
    mysqli_stmt_close($stmt_count_w);
}

$total_pages_w = ceil($total_records_w / $limit_w);
if ($total_records_w == 0) $total_pages_w = 1;
if ($page_w > $total_pages_w) $page_w = $total_pages_w;
if ($page_w < 1) $page_w = 1;

$start_record_index_w = ($page_w - 1) * $limit_w;

// Câu lệnh SQL để lấy dữ liệu CHỈ TỪ tbl_warehouse
$sql_get_data_w = "SELECT w.*
                   FROM tbl_warehouse w
                   " . $where_clause_w_string . "
                   ORDER BY w.transaction_date DESC, w.warehouse_log_id DESC
                   LIMIT ?, ?";

$stmt_data_w = mysqli_prepare($connect, $sql_get_data_w); // Dòng này sẽ không còn lỗi
$tableDataResult_w = null;

$current_params_for_data_w = $search_params_w_array; // Sử dụng lại params của search nếu có
$current_param_types_for_data_w = $param_types_w_string; // Sử dụng lại types của search nếu có

$current_params_for_data_w[] = $start_record_index_w;
$current_param_types_for_data_w .= "i";
$current_params_for_data_w[] = $limit_w;
$current_param_types_for_data_w .= "i";

if ($stmt_data_w) {
    if (!empty($current_params_for_data_w)) { // Chỉ bind nếu có params (kể cả khi chỉ có limit, offset)
         mysqli_stmt_bind_param($stmt_data_w, $current_param_types_for_data_w, ...$current_params_for_data_w);
    }
    mysqli_stmt_execute($stmt_data_w);
    $tableDataResult_w = mysqli_stmt_get_result($stmt_data_w);
}
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Quản Lý Giao Dịch Kho</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="AdminIndex.php?page=dashboard">Tổng Quan</a></li>
        <li class="breadcrumb-item active">Giao Dịch Kho</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-table me-1"></i> Danh Sách Giao Dịch Kho</span>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addInventoryTransactionModal">
                <i class="fas fa-plus me-1"></i> Thêm Giao Dịch
            </button>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['inventory_message'])): ?>
                <div class="alert alert-<?php echo htmlspecialchars($_SESSION['inventory_message_type']); ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_SESSION['inventory_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['inventory_message']); unset($_SESSION['inventory_message_type']); ?>
            <?php endif; ?>

            <form method="GET" class="mb-3">
                <input type="hidden" name="page" value="InventoryTransactions">
                <input type="hidden" name="limit_w" value="<?php echo htmlspecialchars($limit_w); ?>">
                <input type="hidden" name="page_w" value="1">
                <div class="input-group">
                    <input type="text" class="form-control" name="search_w"
                           placeholder="Tìm theo Product ID (trong kho), Ghi chú..."
                           value="<?php echo htmlspecialchars($search_w); ?>">
                    <button class="btn btn-outline-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Tìm</button>
                    <?php if (!empty($search_w)): ?>
                        <a href="?page=InventoryTransactions&limit_w=<?php echo htmlspecialchars($limit_w); ?>&page_w=1" class="btn btn-outline-secondary"><i class="fa-solid fa-times"></i> Xóa tìm</a>
                    <?php endif; ?>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Log ID</th>
                            <th>Ngày GD</th>
                            <th>Product ID (Trong Kho)</th> <!-- Đổi tên cột -->
                            <th>Loại</th>
                            <th>SL Nhập</th>
                            <th>SL Xuất</th>
                            <th>Giá Nhập</th>
                            <th>Giá Xuất</th>
                            <th>Tồn Sau GD</th>
                            <th>Ghi Chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($tableDataResult_w && mysqli_num_rows($tableDataResult_w) > 0) {
                            while ($transaction = mysqli_fetch_assoc($tableDataResult_w)) {
                        ?>
                            <tr>
                                <td><?php echo $transaction['warehouse_log_id']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($transaction['transaction_date'])); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($transaction['product_id']); ?> <!-- Hiển thị product_id từ tbl_warehouse -->
                                </td>
                                <td class="text-center">
                                    <?php
                                    if ($transaction['in_quantity'] > 0) {
                                        echo '<span class="badge bg-success">NHẬP</span>';
                                    } elseif ($transaction['out_quantity'] > 0) {
                                        echo '<span class="badge bg-danger">XUẤT</span>';
                                    } else {
                                        echo '<span class="badge bg-secondary">N/A</span>';
                                    }
                                    ?>
                                </td>
                                <td class="text-center"><?php echo $transaction['in_quantity'] > 0 ? $transaction['in_quantity'] : '-'; ?></td>
                                <td class="text-center"><?php echo $transaction['out_quantity'] > 0 ? $transaction['out_quantity'] : '-'; ?></td>
                                <td class="text-end"><?php echo $transaction['import_price'] !== null ? number_format($transaction['import_price'], 0, ',', '.') : '-'; ?></td>
                                <td class="text-end"><?php echo $transaction['export_price'] !== null ? number_format($transaction['export_price'], 0, ',', '.') : '-'; ?></td>
                                <td class="text-center"><?php echo $transaction['inventory_after_transaction']; ?></td>
                                <td><?php echo nl2br(htmlspecialchars($transaction['notes'])); ?></td>
                            </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="10" class="text-center">Không có giao dịch kho nào.
                                    <?php if (!empty($search_w)) echo " với từ khóa tìm kiếm."; ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Phân trang (giữ nguyên) -->
            <?php if ($total_pages_w > 1): ?>
            <nav aria-label="Page navigation for Warehouse Transactions" class="mt-3">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-2 mb-md-0">
                        <form id="limitFormWarehouse" method="GET" class="d-inline-block">
                            <input type="hidden" name="page" value="InventoryTransactions">
                            <?php if (!empty($search_w)): ?>
                                <input type="hidden" name="search_w" value="<?php echo htmlspecialchars($search_w); ?>">
                            <?php endif; ?>
                            <input type="hidden" name="page_w" value="1">
                            <label for="limitSelectWarehouse" class="form-label-sm me-1">Hiển thị:</label>
                            <select name="limit_w" id="limitSelectWarehouse" onchange="document.getElementById('limitFormWarehouse').submit();" class="form-select form-select-sm d-inline-block" style="width: auto;">
                                <option value="5" <?php if ($limit_w == 5) echo 'selected'; ?>>5</option>
                                <option value="10" <?php if ($limit_w == 10) echo 'selected'; ?>>10</option>
                                <option value="20" <?php if ($limit_w == 20) echo 'selected'; ?>>20</option>
                                <option value="50" <?php if ($limit_w == 50) echo 'selected'; ?>>50</option>
                            </select> mục/trang.
                        </form>
                    </div>
                    <div class="col-md-8 d-flex justify-content-md-end">
                        <ul class="pagination mb-0">
                            <?php if ($page_w > 1): ?>
                                <li class="page-item"><a class="page-link" href="?page=InventoryTransactions&limit_w=<?php echo $limit_w; ?>&page_w=1<?php echo !empty($search_w) ? '&search_w='.urlencode($search_w) : ''; ?>" title="Đầu">««</a></li>
                                <li class="page-item"><a class="page-link" href="?page=InventoryTransactions&limit_w=<?php echo $limit_w; ?>&page_w=<?php echo ($page_w - 1); ?><?php echo !empty($search_w) ? '&search_w='.urlencode($search_w) : ''; ?>" title="Trước">«</a></li>
                            <?php endif; ?>
                            <?php
                            $num_links_w = 2;
                            $start_loop_w = max(1, $page_w - $num_links_w);
                            $end_loop_w = min($total_pages_w, $page_w + $num_links_w);
                            if ($start_loop_w > 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            for ($i_w = $start_loop_w; $i_w <= $end_loop_w; $i_w++): ?>
                                <li class="page-item <?php echo ($i_w == $page_w) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=InventoryTransactions&limit_w=<?php echo $limit_w; ?>&page_w=<?php echo $i_w; ?><?php echo !empty($search_w) ? '&search_w='.urlencode($search_w) : ''; ?>"><?php echo $i_w; ?></a>
                                </li>
                            <?php endfor;
                            if ($end_loop_w < $total_pages_w) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            ?>
                            <?php if ($page_w < $total_pages_w): ?>
                                <li class="page-item"><a class="page-link" href="?page=InventoryTransactions&limit_w=<?php echo $limit_w; ?>&page_w=<?php echo ($page_w + 1); ?><?php echo !empty($search_w) ? '&search_w='.urlencode($search_w) : ''; ?>" title="Sau">»</a></li>
                                <li class="page-item"><a class="page-link" href="?page=InventoryTransactions&limit_w=<?php echo $limit_w; ?>&page_w=<?php echo $total_pages_w; ?><?php echo !empty($search_w) ? '&search_w='.urlencode($search_w) : ''; ?>" title="Cuối">»»</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                 <div class="row mt-2">
                    <div class="col-12 text-md-start">
                        <small>
                        <?php
                        $start_item_display_w = ($page_w - 1) * $limit_w + 1;
                        $end_item_display_w = min($page_w * $limit_w, $total_records_w);
                        if ($total_records_w > 0) {
                            echo "Hiển thị $start_item_display_w - $end_item_display_w trên tổng số $total_records_w giao dịch.";
                        } else if (empty($search_w)) {
                            echo "Chưa có giao dịch kho nào.";
                        }
                        ?>
                        </small>
                    </div>
                </div>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
// Include modal thêm
// Biến $product_table_name trong AddTransactionPopup.php sẽ cần được định nghĩa
// Nếu $product_table_name_main đã được định nghĩa ở trên, có thể dùng nó
// Hoặc định nghĩa lại trong AddTransactionPopup.php
include __DIR__ . "/AddTransactionPopup.php";

if ($stmt_data_w) {
    mysqli_stmt_close($stmt_data_w);
}
?>