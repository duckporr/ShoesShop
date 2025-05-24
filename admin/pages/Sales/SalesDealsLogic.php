<?php
session_start();
// Đảm bảo đường dẫn này chính xác đến file Connect.php của bạn
include "../../../common/config/Connect.php";

// --- Lấy dữ liệu từ POST ---
$deal_name = isset($_POST['deal_name']) ? trim(mysqli_real_escape_string($connect, $_POST['deal_name'])) : null;
$customer_name = isset($_POST['customer_name']) ? trim(mysqli_real_escape_string($connect, $_POST['customer_name'])) : null;
$customer_contact = isset($_POST['customer_contact']) ? trim(mysqli_real_escape_string($connect, $_POST['customer_contact'])) : null;
$deal_stage = isset($_POST['deal_stage']) ? mysqli_real_escape_string($connect, $_POST['deal_stage']) : 'Lead';
$expected_close_date = isset($_POST['expected_close_date']) && !empty($_POST['expected_close_date']) ? mysqli_real_escape_string($connect, $_POST['expected_close_date']) : NULL;
$actual_close_date = isset($_POST['actual_close_date']) && !empty($_POST['actual_close_date']) ? mysqli_real_escape_string($connect, $_POST['actual_close_date']) : NULL;

$deal_value_str = isset($_POST['deal_value']) ? preg_replace('/[^\d.]/', '', $_POST['deal_value']) : null;
$deal_value = !empty($deal_value_str) ? (float)$deal_value_str : NULL;

$probability_str = isset($_POST['probability']) ? preg_replace('/[^\d]/', '', $_POST['probability']) : null;
$probability = !empty($probability_str) ? (int)$probability_str : NULL;
if ($probability !== NULL && ($probability < 0 || $probability > 100)) { // Validate probability
    $probability = NULL; 
}

$sales_rep_name = isset($_POST['sales_rep_name']) ? trim(mysqli_real_escape_string($connect, $_POST['sales_rep_name'])) : null;
$product_service_ids = isset($_POST['product_service_ids']) ? trim(mysqli_real_escape_string($connect, $_POST['product_service_ids'])) : null;
$source = isset($_POST['source']) ? trim(mysqli_real_escape_string($connect, $_POST['source'])) : null;
$notes = isset($_POST['notes']) ? trim(mysqli_real_escape_string($connect, $_POST['notes'])) : null;


// --- Xử lý THÊM ---
if (isset($_POST['addDeal'])) {
    if (!empty($deal_name)) {
        $sql_add = "INSERT INTO sales_deals 
                        (deal_name, customer_name, customer_contact, deal_stage, expected_close_date, actual_close_date, deal_value, probability, sales_rep_name, product_service_ids, source, notes) 
                    VALUES 
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($connect, $sql_add);
        // s: string, d: double (float), i: integer
        mysqli_stmt_bind_param($stmt, "ssssssdsssss", 
            $deal_name, $customer_name, $customer_contact, $deal_stage, $expected_close_date, $actual_close_date,
            $deal_value, $probability, $sales_rep_name, $product_service_ids, $source, $notes
        );

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Thêm Deal/Cơ hội bán hàng thành công!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Lỗi khi thêm Deal: " . mysqli_stmt_error($stmt);
            $_SESSION['message_type'] = "danger";
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = "Tên Deal là bắt buộc.";
        $_SESSION['message_type'] = "warning";
    }
    header('Location:../../AdminIndex.php?workingPage=sales');
    exit();
}

// --- Xử lý SỬA ---
else if (isset($_POST['editDeal'])) {
    $deal_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

    if ($deal_id && !empty($deal_name)) {
        $sql_edit = "UPDATE sales_deals SET 
                        deal_name = ?, 
                        customer_name = ?, 
                        customer_contact = ?, 
                        deal_stage = ?, 
                        expected_close_date = ?, 
                        actual_close_date = ?, 
                        deal_value = ?, 
                        probability = ?, 
                        sales_rep_name = ?, 
                        product_service_ids = ?, 
                        source = ?, 
                        notes = ?
                    WHERE id = ?";
        
        $stmt = mysqli_prepare($connect, $sql_edit);
        mysqli_stmt_bind_param($stmt, "ssssssdsssssi", 
            $deal_name, $customer_name, $customer_contact, $deal_stage, $expected_close_date, $actual_close_date,
            $deal_value, $probability, $sales_rep_name, $product_service_ids, $source, $notes,
            $deal_id
        );

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Cập nhật Deal thành công!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Lỗi khi cập nhật Deal: " . mysqli_stmt_error($stmt);
            $_SESSION['message_type'] = "danger";
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = "Thiếu thông tin hoặc ID Deal không hợp lệ.";
        $_SESSION['message_type'] = "warning";
    }
    header('Location:../../AdminIndex.php?workingPage=sales');
    exit();
}

// --- Xử lý XÓA ---
else if (isset($_POST['deleteDeal'])) {
    $deal_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

    if ($deal_id) {
        $sql_delete = "DELETE FROM sales_deals WHERE id = ?";
        $stmt = mysqli_prepare($connect, $sql_delete);
        mysqli_stmt_bind_param($stmt, "i", $deal_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Xóa Deal thành công!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Lỗi khi xóa Deal: " . mysqli_stmt_error($stmt);
            $_SESSION['message_type'] = "danger";
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = "ID Deal không hợp lệ để xóa.";
        $_SESSION['message_type'] = "warning";
    }
    header('Location:../../AdminIndex.php?workingPage=sales');
    exit();
}

// Nếu không có action nào, chuyển hướng về trang chính của module
else {
    header('Location:../../AdminIndex.php?workingPage=sales');
    exit();
}

mysqli_close($connect);
?>