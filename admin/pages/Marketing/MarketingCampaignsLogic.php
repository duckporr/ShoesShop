<?php
session_start();
// Đảm bảo đường dẫn này chính xác đến file Connect.php của bạn
// Giả sử Connect.php nằm trong admin/common/config/Connect.php
// Và MarketingCampaignsLogic.php nằm trong admin/pages/Marketing/MarketingCampaignsLogic.php
// Vậy cần đi lên 2 cấp rồi vào common/config
include "../../../common/config/Connect.php";

// --- Lấy dữ liệu từ POST ---
// Luôn kiểm tra isset và làm sạch dữ liệu trước khi sử dụng
$campaign_name = isset($_POST['campaign_name']) ? trim(mysqli_real_escape_string($connect, $_POST['campaign_name'])) : null;
$start_date = isset($_POST['start_date']) && !empty($_POST['start_date']) ? mysqli_real_escape_string($connect, $_POST['start_date']) : NULL; // Cho phép NULL
$end_date = isset($_POST['end_date']) && !empty($_POST['end_date']) ? mysqli_real_escape_string($connect, $_POST['end_date']) : NULL; // Cho phép NULL
$objective = isset($_POST['objective']) ? trim(mysqli_real_escape_string($connect, $_POST['objective'])) : null;
$target_audience = isset($_POST['target_audience']) ? trim(mysqli_real_escape_string($connect, $_POST['target_audience'])) : null;
$channel = isset($_POST['channel']) ? trim(mysqli_real_escape_string($connect, $_POST['channel'])) : null;
$budget_str = isset($_POST['budget']) ? preg_replace('/[^\d.]/', '', $_POST['budget']) : null; // Chỉ giữ số và dấu chấm
$budget = !empty($budget_str) ? (float)$budget_str : NULL; // Cho phép NULL
$actual_cost_str = isset($_POST['actual_cost']) ? preg_replace('/[^\d.]/', '', $_POST['actual_cost']) : null;
$actual_cost = !empty($actual_cost_str) ? (float)$actual_cost_str : NULL; // Cho phép NULL
$leads_generated_str = isset($_POST['leads_generated']) ? preg_replace('/[^\d]/', '', $_POST['leads_generated']) : null; // Chỉ giữ số
$leads_generated = !empty($leads_generated_str) ? (int)$leads_generated_str : NULL; // Cho phép NULL
$status = isset($_POST['status']) ? mysqli_real_escape_string($connect, $_POST['status']) : 'Planned';
$manager = isset($_POST['manager']) ? trim(mysqli_real_escape_string($connect, $_POST['manager'])) : null;
$notes = isset($_POST['notes']) ? trim(mysqli_real_escape_string($connect, $_POST['notes'])) : null;

// Tính cost_per_lead nếu có thể
$cost_per_lead = NULL;
if ($actual_cost !== NULL && $leads_generated !== NULL && $leads_generated > 0) {
    $cost_per_lead = round($actual_cost / $leads_generated, 2);
}


// --- Xử lý THÊM ---
if (isset($_POST['addCampaign'])) {
    if (!empty($campaign_name)) {
        $sql_add = "INSERT INTO tbl_marketing
                        (campaign_name, start_date, end_date, objective, target_audience, channel, budget, actual_cost, leads_generated, cost_per_lead, status, manager, notes) 
                    VALUES 
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($connect, $sql_add);
        // s: string, d: double (float), i: integer
        mysqli_stmt_bind_param($stmt, "ssssssddissss", 
            $campaign_name, $start_date, $end_date, $objective, $target_audience, $channel, 
            $budget, $actual_cost, $leads_generated, $cost_per_lead, $status, $manager, $notes
        );

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Thêm chiến dịch marketing thành công!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Lỗi khi thêm chiến dịch: " . mysqli_stmt_error($stmt);
            $_SESSION['message_type'] = "danger";
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = "Tên chiến dịch là bắt buộc.";
        $_SESSION['message_type'] = "warning";
    }
    header('Location:../../AdminIndex.php?workingPage=marketing');
    exit();
}

// --- Xử lý SỬA ---
else if (isset($_POST['editCampaign'])) {
    $campaign_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

    if ($campaign_id && !empty($campaign_name)) {
        $sql_edit = "UPDATE tbl_marketing SET 
                        campaign_name = ?, 
                        start_date = ?, 
                        end_date = ?, 
                        objective = ?, 
                        target_audience = ?, 
                        channel = ?, 
                        budget = ?, 
                        actual_cost = ?, 
                        leads_generated = ?, 
                        cost_per_lead = ?, 
                        status = ?, 
                        manager = ?, 
                        notes = ?
                    WHERE id = ?";
        
        $stmt = mysqli_prepare($connect, $sql_edit);
        mysqli_stmt_bind_param($stmt, "ssssssddissssi", 
            $campaign_name, $start_date, $end_date, $objective, $target_audience, $channel, 
            $budget, $actual_cost, $leads_generated, $cost_per_lead, $status, $manager, $notes,
            $campaign_id
        );

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Cập nhật chiến dịch marketing thành công!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Lỗi khi cập nhật chiến dịch: " . mysqli_stmt_error($stmt);
            $_SESSION['message_type'] = "danger";
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = "Thiếu thông tin hoặc ID chiến dịch không hợp lệ.";
        $_SESSION['message_type'] = "warning";
    }
    header('Location:../../AdminIndex.php?workingPage=marketing');
    exit();
}

// --- Xử lý XÓA ---
else if (isset($_POST['deleteCampaign'])) {
    $campaign_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

    if ($campaign_id) {
        $sql_delete = "DELETE FROM tbl_marketing WHERE id = ?";
        $stmt = mysqli_prepare($connect, $sql_delete);
        mysqli_stmt_bind_param($stmt, "i", $campaign_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Xóa chiến dịch marketing thành công!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Lỗi khi xóa chiến dịch: " . mysqli_stmt_error($stmt);
            $_SESSION['message_type'] = "danger";
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = "ID chiến dịch không hợp lệ để xóa.";
        $_SESSION['message_type'] = "warning";
    }
    header('Location:../../AdminIndex.php?workingPage=marketing');
    exit();
}

// Nếu không có action nào, chuyển hướng về trang chính của module
else {
    header('Location:../../AdminIndex.php?workingPage=marketing');
    exit();
}

mysqli_close($connect);
?>