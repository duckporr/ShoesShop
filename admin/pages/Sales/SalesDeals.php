<?php
// File: pages/Sales/SalesDeals.php

// Biến $connect thường được khởi tạo từ AdminIndex.php
// session_start(); // Nếu chưa start ở AdminIndex.php
// include "../../../common/config/Connect.php";

// --- Xử lý Phân Trang và Tìm Kiếm ---
$search_sales = isset($_GET['search_sales']) ? trim($_GET['search_sales']) : '';
$page_sales = isset($_GET['page_sales']) ? (int)$_GET['page_sales'] : 1;
$limit_sales = isset($_GET['limit_sales']) ? (int)$_GET['limit_sales'] : 10;

if ($limit_sales <= 0) $limit_sales = 10;
if ($page_sales < 1) $page_sales = 1;

$start_record_sales = ($page_sales - 1) * $limit_sales;

// Xây dựng điều kiện tìm kiếm
$search_conditions_sales = [];
$search_params_sales = [];
$param_types_sales = "";

if (!empty($search_sales)) {
    $search_like_sales = "%" . $search_sales . "%";
    $search_conditions_sales[] = "(deal_name LIKE ? OR customer_name LIKE ? OR customer_contact LIKE ? OR deal_stage LIKE ? OR sales_rep_name LIKE ? OR source LIKE ? OR product_service_ids LIKE ?)";
    for($i=0; $i<7; $i++) $search_params_sales[] = $search_like_sales;
    $param_types_sales .= str_repeat('s', 7);
}

$where_clause_sales = "";
if (!empty($search_conditions_sales)) {
    $where_clause_sales = " WHERE " . implode(" AND ", $search_conditions_sales);
}

// Đếm tổng số bản ghi (có tìm kiếm)
$sql_count_total_sales = "SELECT COUNT(*) as total_records FROM sales_deals" . $where_clause_sales;
$stmt_count_sales = mysqli_prepare($connect, $sql_count_total_sales);
if (!empty($search_params_sales)) {
    mysqli_stmt_bind_param($stmt_count_sales, $param_types_sales, ...$search_params_sales);
}
mysqli_stmt_execute($stmt_count_sales);
$result_total_sales = mysqli_stmt_get_result($stmt_count_sales);
$row_total_sales = mysqli_fetch_assoc($result_total_sales);
$total_records_sales = $row_total_sales['total_records'];
mysqli_stmt_close($stmt_count_sales);

$total_pages_sales = ceil($total_records_sales / $limit_sales);
if ($page_sales > $total_pages_sales && $total_pages_sales > 0) $page_sales = $total_pages_sales;
if ($page_sales < 1) $page_sales = 1;

$start_record_sales = ($page_sales - 1) * $limit_sales;


// Lấy dữ liệu cho trang hiện tại
$sql_get_data_sales = "SELECT * FROM sales_deals" . $where_clause_sales . " ORDER BY created_at DESC, id DESC LIMIT ?, ?";
$stmt_data_sales = mysqli_prepare($connect, $sql_get_data_sales);

$current_params_sales = $search_params_sales;
$current_param_types_sales = $param_types_sales;

$current_params_sales[] = $start_record_sales;
$current_param_types_sales .= "i";
$current_params_sales[] = $limit_sales;
$current_param_types_sales .= "i";

if (!empty($current_params_sales)) {
     mysqli_stmt_bind_param($stmt_data_sales, $current_param_types_sales, ...$current_params_sales);
}

mysqli_stmt_execute($stmt_data_sales);
$tableDataSales = mysqli_stmt_get_result($stmt_data_sales);

$deals_data_for_popup = [];
if ($tableDataSales && mysqli_num_rows($tableDataSales) > 0) {
    mysqli_data_seek($tableDataSales, 0);
    while($r_deal = mysqli_fetch_assoc($tableDataSales)){
        $deals_data_for_popup[] = $r_deal;
    }
    mysqli_data_seek($tableDataSales, 0);
}
?>

<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Quản Lý Sales & Deals</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDealModal">
                <i class="fa-solid fa-plus me-1"></i> Thêm Deal Mới
            </button>
        </div>
        <div class="card-body">
            <!-- Thông báo Session -->
            <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
            <?php endif; ?>

            <!-- Form Tìm Kiếm -->
            <form method="GET" class="mb-3">
                <input type="hidden" name="workingPage" value="sales_deals">
                <input type="hidden" name="limit_sales" value="<?php echo $limit_sales; ?>">
                <input type="hidden" name="page_sales" value="1">
                <div class="input-group">
                    <input type="text" class="form-control" name="search_sales" 
                           placeholder="Tìm theo tên deal, KH, giai đoạn, NV sales, nguồn..." 
                           value="<?php echo htmlspecialchars($search_sales); ?>">
                    <button class="btn btn-outline-success" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i> Tìm Kiếm
                    </button>
                     <?php if (!empty($search_sales)): ?>
                        <a href="?workingPage=sales_deals&limit_sales=<?php echo $limit_sales; ?>&page_sales=1" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-times"></i> Xóa tìm kiếm
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Bảng Hiển Thị Dữ Liệu -->
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-success"> <!-- Hoặc table-dark -->
                        <tr>
                            <th class="text-center" style="width: 3%;">STT</th>
                            <th style="width: 20%;">Tên Deal</th>
                            <th style="width: 12%;">Khách Hàng</th>
                            <th class="text-center" style="width: 10%;">Giai Đoạn</th>
                            <th class="text-end" style="width: 10%;">Giá Trị (VNĐ)</th>
                            <th class="text-center" style="width: 8%;">Xác Suất (%)</th>
                            <th class="text-center" style="width: 8%;">Dự Kiến Chốt</th>
                            <th style="width: 10%;">NV Sales</th>
                            <th style="width: 10%;">Nguồn</th>
                            <th class="text-center" style="width: 7%;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($tableDataSales && mysqli_num_rows($tableDataSales) > 0) {
                            $stt_sales = $start_record_sales + 1;
                            mysqli_data_seek($tableDataSales, 0);
                            while ($row = mysqli_fetch_assoc($tableDataSales)) {
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $stt_sales++; ?></td>
                                <td><?php echo htmlspecialchars($row['deal_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['customer_name']); ?>
                                    <?php if(!empty($row['customer_contact'])): ?>
                                        <small class="d-block text-muted"><em><?php echo htmlspecialchars($row['customer_contact']); ?></em></small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                     <?php 
                                        $stage_class = 'secondary';
                                        if ($row['deal_stage'] == 'Won') $stage_class = 'success';
                                        else if (in_array($row['deal_stage'], ['Proposal', 'Negotiation'])) $stage_class = 'info';
                                        else if (in_array($row['deal_stage'], ['Lead', 'Contacted', 'Qualification'])) $stage_class = 'primary';
                                        else if ($row['deal_stage'] == 'Lost') $stage_class = 'danger';
                                        else if ($row['deal_stage'] == 'On Hold') $stage_class = 'warning';
                                    ?>
                                    <span class="badge bg-<?php echo $stage_class; ?>"><?php echo htmlspecialchars($row['deal_stage']); ?></span>
                                </td>
                                <td class="text-end"><?php echo $row['deal_value'] !== null ? number_format($row['deal_value'], 0, ',', '.') : '-'; ?></td>
                                <td class="text-center"><?php echo $row['probability'] !== null ? $row['probability'] . '%' : '-'; ?></td>
                                <td class="text-center"><?php echo $row['expected_close_date'] ? date("d/m/y", strtotime($row['expected_close_date'])) : '-'; ?></td>
                                <td><?php echo htmlspecialchars($row['sales_rep_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['source']); ?></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editDealModal_<?php echo $row['id']; ?>" title="Sửa">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteDealModal_<?php echo $row['id']; ?>" title="Xóa">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            } // end while
                        } else { // if mysqli_num_rows > 0
                        ?>
                            <tr>
                                <td colspan="10" class="text-center">Không tìm thấy Deal/Cơ hội bán hàng nào.
                                     <?php if (!empty($search_sales)) echo " với từ khóa bạn tìm."; ?>
                                </td>
                            </tr>
                        <?php
                        } // end else
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Phân Trang -->
            <?php if ($total_pages_sales > 1): ?>
            <nav aria-label="Page navigation for Sales Deals" class="mt-3">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-2 mb-md-0">
                        <form id="limitFormSales" method="GET" class="d-inline-block">
                            <input type="hidden" name="workingPage" value="sales_deals">
                            <?php if (!empty($search_sales)): ?>
                                <input type="hidden" name="search_sales" value="<?php echo htmlspecialchars($search_sales); ?>">
                            <?php endif; ?>
                            <input type="hidden" name="page_sales" value="1">
                            <label for="limitSelectSales" class="form-label-sm me-1">Hiển thị:</label>
                            <select name="limit_sales" id="limitSelectSales" onchange="document.getElementById('limitFormSales').submit();" class="form-select form-select-sm d-inline-block" style="width: auto;">
                                <option value="5" <?php if ($limit_sales == 5) echo 'selected'; ?>>5</option>
                                <option value="10" <?php if ($limit_sales == 10) echo 'selected'; ?>>10</option>
                                <option value="20" <?php if ($limit_sales == 20) echo 'selected'; ?>>20</option>
                                <option value="50" <?php if ($limit_sales == 50) echo 'selected'; ?>>50</option>
                            </select>
                            mục/trang.
                        </form>
                    </div>
                    <div class="col-md-8 d-flex justify-content-md-end">
                         <ul class="pagination mb-0">
                            <?php if ($page_sales > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?workingPage=sales_deals&limit_sales=<?php echo $limit_sales; ?>&page_sales=1<?php echo !empty($search_sales) ? '&search_sales='.urlencode($search_sales) : ''; ?>" title="Trang đầu">««</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="?workingPage=sales_deals&limit_sales=<?php echo $limit_sales; ?>&page_sales=<?php echo ($page_sales - 1); ?><?php echo !empty($search_sales) ? '&search_sales='.urlencode($search_sales) : ''; ?>" title="Trang trước">«</a>
                                </li>
                            <?php endif; ?>

                            <?php
                            $num_links_around_current_sales = 2;
                            $start_loop_sales = max(1, $page_sales - $num_links_around_current_sales);
                            $end_loop_sales = min($total_pages_sales, $page_sales + $num_links_around_current_sales);

                            if ($start_loop_sales > 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }

                            for ($i_sales = $start_loop_sales; $i_sales <= $end_loop_sales; $i_sales++): ?>
                                <li class="page-item <?php echo ($i_sales == $page_sales) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?workingPage=sales_deals&limit_sales=<?php echo $limit_sales; ?>&page_sales=<?php echo $i_sales; ?><?php echo !empty($search_sales) ? '&search_sales='.urlencode($search_sales) : ''; ?>"><?php echo $i_sales; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php
                            if ($end_loop_sales < $total_pages_sales) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            ?>

                            <?php if ($page_sales < $total_pages_sales): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?workingPage=sales_deals&limit_sales=<?php echo $limit_sales; ?>&page_sales=<?php echo ($page_sales + 1); ?><?php echo !empty($search_sales) ? '&search_sales='.urlencode($search_sales) : ''; ?>" title="Trang sau">»</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="?workingPage=sales_deals&limit_sales=<?php echo $limit_sales; ?>&page_sales=<?php echo $total_pages_sales; ?><?php echo !empty($search_sales) ? '&search_sales='.urlencode($search_sales) : ''; ?>" title="Trang cuối">»»</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                 <div class="row mt-2">
                    <div class="col-12 text-md-start">
                        <small>
                        <?php
                        $start_item_idx_sales = ($page_sales - 1) * $limit_sales + 1;
                        $end_item_idx_sales = min($page_sales * $limit_sales, $total_records_sales);
                        if ($total_records_sales > 0) {
                            echo "Hiển thị $start_item_idx_sales - $end_item_idx_sales trên tổng số $total_records_sales deal.";
                        }
                        ?>
                        </small>
                    </div>
                </div>
            </nav>
            <?php endif; // end if $total_pages_sales > 1 ?>
        </div> <!-- card-body -->
    </div> <!-- card -->
</div> <!-- container-fluid -->

<!-- Include Modals -->
<?php include "./pages/Sales/AddDealPopup.php"; ?>

<?php
if (!empty($deals_data_for_popup)) {
    foreach ($deals_data_for_popup as $row) {
        include "./pages/Sales/EditDealPopup.php";
        include "./pages/Sales/ConfirmDeleteDealPopup.php";
    }
}
mysqli_stmt_close($stmt_data_sales);
// mysqli_close($connect); // Chỉ đóng ở file chính
?>