<?php

$search = isset($_GET['search_marketing']) ? trim($_GET['search_marketing']) : '';
$pageIndex = isset($_GET['page_marketing']) ? (int)$_GET['page_marketing'] : 1;
$pageSize = isset($_GET['limit_marketing']) ? (int)$_GET['limit_marketing'] : 10; 

if ($pageSize <= 0) $pageSize = 10;
if ($pageIndex < 1) $pageIndex = 1;

$start_record_index = ($pageIndex - 1) * $pageSize;

// Xây dựng điều kiện tìm kiếm
$search_conditions = [];
$search_params = [];
$param_types = "";

if (!empty($search)) {
    $search_like = "%" . $search . "%";
    $search_conditions[] = "(campaign_name LIKE ? OR objective LIKE ? OR target_audience LIKE ? OR channel LIKE ? OR status LIKE ? OR manager LIKE ?)";
    for($i=0; $i<6; $i++) $search_params[] = $search_like; // 6 placeholders cho LIKE
    $param_types .= str_repeat('s', 6);
}

$where_clause = "";
if (!empty($search_conditions)) {
    $where_clause = " WHERE " . implode(" AND ", $search_conditions);
}

// Đếm tổng số bản ghi (có tìm kiếm)
$sql_count_total = "SELECT COUNT(*) as total_records FROM tbl_marketing" . $where_clause;
$stmt_count = mysqli_prepare($connect, $sql_count_total);
if (!empty($search_params)) {
    mysqli_stmt_bind_param($stmt_count, $param_types, ...$search_params);
}
mysqli_stmt_execute($stmt_count);
$result_total = mysqli_stmt_get_result($stmt_count);
$row_total = mysqli_fetch_assoc($result_total);
$total_records = $row_total['total_records'];
mysqli_stmt_close($stmt_count);

$total_pages = ceil($total_records / $pageSize);
if ($pageIndex > $total_pages && $total_pages > 0) $pageIndex = $total_pages;
if ($pageIndex < 1) $pageIndex = 1; // Đảm bảo pageIndex >=1 sau khi tính total_pages

$start_record_index = ($pageIndex - 1) * $pageSize; // Tính lại start_record_index sau khi có pageIndex cuối cùng


// Lấy dữ liệu cho trang hiện tại
$sql_get_data = "SELECT * FROM tbl_marketing" . $where_clause . " ORDER BY start_date DESC, id DESC LIMIT ?, ?";
$stmt_data = mysqli_prepare($connect, $sql_get_data);

$current_params = $search_params; // Copy params để không ảnh hưởng lần bind trước
$current_param_types = $param_types;

$current_params[] = $start_record_index;
$current_param_types .= "i";
$current_params[] = $pageSize;
$current_param_types .= "i";

if (!empty($current_params)) {
     mysqli_stmt_bind_param($stmt_data, $current_param_types, ...$current_params);
}

mysqli_stmt_execute($stmt_data);
$tableData = mysqli_stmt_get_result($stmt_data);

$campaigns_data_for_popup = []; // Lưu dữ liệu để dùng cho popup, tránh query lại
if ($tableData && mysqli_num_rows($tableData) > 0) {
    mysqli_data_seek($tableData, 0); // Reset con trỏ về đầu
    while($r = mysqli_fetch_assoc($tableData)){
        $campaigns_data_for_popup[] = $r;
    }
    mysqli_data_seek($tableData, 0); // Reset lại để hiển thị bảng
}

?>
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Quản Lý Chiến Dịch Marketing</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCampaignModal">
                <i class="fa-solid fa-plus me-1"></i> Thêm Chiến Dịch
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
                <input type="hidden" name="workingPage" value="marketing_campaigns">
                <input type="hidden" name="limit_marketing" value="<?php echo $pageSize; ?>"> 
                <input type="hidden" name="page_marketing" value="1"> <!-- Luôn về trang 1 khi tìm kiếm mới -->
                <div class="input-group">
                    <input type="text" class="form-control" name="search_marketing" 
                           placeholder="Tìm theo tên, mục tiêu, kênh, trạng thái, người quản lý..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i> Tìm Kiếm
                    </button>
                    <?php if (!empty($search)): ?>
                        <a href="?workingPage=marketing_campaigns&limit_marketing=<?php echo $pageSize; ?>&page_marketing=1" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-times"></i> Xóa tìm kiếm
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Bảng Hiển Thị Dữ Liệu -->
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" style="width: 3%;">STT</th>
                            <th style="width: 15%;">Tên Chiến Dịch</th>
                            <th class="text-center" style="width: 7%;">Bắt Đầu</th>
                            <th class="text-center" style="width: 7%;">Kết Thúc</th>
                            <th style="width: 10%;">Kênh</th>
                            <th class="text-end" style="width: 10%;">Ngân Sách (VNĐ)</th>
                            <th class="text-end" style="width: 10%;">Chi Phí Thực (VNĐ)</th>
                            <th class="text-center" style="width: 5%;">Leads</th>
                            <th class="text-end" style="width: 8%;">Chi Phí/Lead</th>
                            <th class="text-center" style="width: 8%;">Trạng Thái</th>
                            <th style="width: 10%;">Người QL</th>
                            <th class="text-center" style="width: 7%;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($tableData && mysqli_num_rows($tableData) > 0) {
                            $stt = $start_record_index + 1;
                            mysqli_data_seek($tableData, 0); // Đảm bảo con trỏ ở đầu
                            while ($row = mysqli_fetch_assoc($tableData)) {
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $stt++; ?></td>
                                <td><?php echo htmlspecialchars($row['campaign_name']); ?>
                                    <?php if(!empty($row['objective'])): ?>
                                        <small class="d-block text-muted"><em>Mục tiêu: <?php echo htmlspecialchars(substr($row['objective'], 0, 50)) . (strlen($row['objective']) > 50 ? '...' : ''); ?></em></small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo $row['start_date'] ? date("d/m/y", strtotime($row['start_date'])) : '-'; ?></td>
                                <td class="text-center"><?php echo $row['end_date'] ? date("d/m/y", strtotime($row['end_date'])) : '-'; ?></td>
                                <td><?php echo htmlspecialchars($row['channel']); ?></td>
                                <td class="text-end"><?php echo $row['budget'] !== null ? number_format($row['budget'], 0, ',', '.') : '-'; ?></td>
                                <td class="text-end"><?php echo $row['actual_cost'] !== null ? number_format($row['actual_cost'], 0, ',', '.') : '-'; ?></td>
                                <td class="text-center"><?php echo $row['leads_generated'] !== null ? number_format($row['leads_generated'], 0, ',', '.') : '-'; ?></td>
                                <td class="text-end">
                                    <?php 
                                    if ($row['actual_cost'] !== null && $row['leads_generated'] !== null && $row['leads_generated'] > 0) {
                                        echo number_format(round($row['actual_cost'] / $row['leads_generated']), 0, ',', '.');
                                    } elseif ($row['cost_per_lead'] !== null) {
                                        echo number_format($row['cost_per_lead'], 0, ',', '.');
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php 
                                        $status_class = 'secondary';
                                        if ($row['status'] == 'Completed') $status_class = 'success';
                                        else if ($row['status'] == 'Ongoing') $status_class = 'info';
                                        else if ($row['status'] == 'Planned') $status_class = 'primary';
                                        else if ($row['status'] == 'Paused') $status_class = 'warning';
                                        else if ($row['status'] == 'Cancelled') $status_class = 'danger';
                                    ?>
                                    <span class="badge bg-<?php echo $status_class; ?>"><?php echo htmlspecialchars($row['status']); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($row['manager']); ?></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editCampaignModal_<?php echo $row['id']; ?>" title="Sửa">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteCampaignModal_<?php echo $row['id']; ?>" title="Xóa">
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
                                <td colspan="12" class="text-center">Không tìm thấy chiến dịch nào.
                                    <?php if (!empty($search)) echo " với từ khóa bạn tìm."; ?>
                                </td>
                            </tr>
                        <?php
                        } // end else
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Phân Trang -->
            <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation for Marketing Campaigns" class="mt-3">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-2 mb-md-0">
                        <form id="limitFormMarketing" method="GET" class="d-inline-block">
                            <input type="hidden" name="workingPage" value="marketing_campaigns">
                            <?php if (!empty($search)): ?>
                                <input type="hidden" name="search_marketing" value="<?php echo htmlspecialchars($search); ?>">
                            <?php endif; ?>
                            <input type="hidden" name="page_marketing" value="1"> <!-- Luôn về trang 1 khi đổi limit -->
                            <label for="limitSelectMarketing" class="form-label-sm me-1">Hiển thị:</label>
                            <select name="limit_marketing" id="limitSelectMarketing" onchange="document.getElementById('limitFormMarketing').submit();" class="form-select form-select-sm d-inline-block" style="width: auto;">
                                <option value="5" <?php if ($pageSize == 5) echo 'selected'; ?>>5</option>
                                <option value="10" <?php if ($pageSize == 10) echo 'selected'; ?>>10</option>
                                <option value="20" <?php if ($pageSize == 20) echo 'selected'; ?>>20</option>
                                <option value="50" <?php if ($pageSize == 50) echo 'selected'; ?>>50</option>
                            </select>
                            mục/trang.
                        </form>
                    </div>
                    <div class="col-md-8 d-flex justify-content-md-end">
                         <ul class="pagination mb-0">
                            <?php if ($pageIndex > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?workingPage=marketing&limit_marketing=<?php echo $pageSize; ?>&page_marketing=1<?php echo !empty($search) ? '&search_marketing='.urlencode($search) : ''; ?>" title="Trang đầu">««</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="?workingPage=marketing&limit_marketing=<?php echo $pageSize; ?>&page_marketing=<?php echo ($pageIndex - 1); ?><?php echo !empty($search) ? '&search_marketing='.urlencode($search) : ''; ?>" title="Trang trước">«</a>
                                </li>
                            <?php endif; ?>

                            <?php
                            $num_links_around_current = 2;
                            $start_loop = max(1, $pageIndex - $num_links_around_current);
                            $end_loop = min($total_pages, $pageIndex + $num_links_around_current);

                            if ($start_loop > 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }

                            for ($i = $start_loop; $i <= $end_loop; $i++): ?>
                                <li class="page-item <?php echo ($i == $pageIndex) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?workingPage=marketing&limit_marketing=<?php echo $pageSize; ?>&page_marketing=<?php echo $i; ?><?php echo !empty($search) ? '&search_marketing='.urlencode($search) : ''; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php
                            if ($end_loop < $total_pages) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            ?>

                            <?php if ($pageIndex < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?workingPage=marketing&limit_marketing=<?php echo $pageSize; ?>&page_marketing=<?php echo ($pageIndex + 1); ?><?php echo !empty($search) ? '&search_marketing='.urlencode($search) : ''; ?>" title="Trang sau">»</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="?workingPage=marketing&limit_marketing=<?php echo $pageSize; ?>&page_marketing=<?php echo $total_pages; ?><?php echo !empty($search) ? '&search_marketing='.urlencode($search) : ''; ?>" title="Trang cuối">»»</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 text-md-start">
                        <small>
                        <?php
                        $start_item_index = ($pageIndex - 1) * $pageSize + 1;
                        $end_item_index = min($pageIndex * $pageSize, $total_records);
                        if ($total_records > 0) {
                            echo "Hiển thị $start_item_index - $end_item_index trên tổng số $total_records chiến dịch.";
                        }
                        ?>
                        </small>
                    </div>
                </div>
            </nav>
            <?php endif; // end if $total_pages > 1 ?>
        </div> <!-- card-body -->
    </div> <!-- card -->
</div> <!-- container-fluid -->

<!-- Include Modals -->
<?php include "./pages/Marketing/AddCampaignPopup.php"; ?>

<?php
// Sử dụng mảng đã lưu trữ để tạo popup, không query lại
if (!empty($campaigns_data_for_popup)) {
    foreach ($campaigns_data_for_popup as $row) {
        include "./pages/Marketing/EditCampaignPopup.php";
        include "./pages/Marketing/ConfirmDeleteCampaignPopup.php";
    }
}
mysqli_stmt_close($stmt_data); // Đóng statement lấy data chính
// mysqli_close($connect); // Chỉ đóng kết nối ở cuối file AdminIndex.php hoặc file chính
?>