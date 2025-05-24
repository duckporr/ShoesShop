<?php
include "../../../common/config/Connect.php"; 

// Lấy dữ liệu từ POST (an toàn hơn với kiểm tra isset)
$expense_date = isset($_POST['expense_date']) ? $_POST['expense_date'] : null;
$description = isset($_POST['description']) ? trim($_POST['description']) : null;
$category = isset($_POST['category']) ? trim($_POST['category']) : null;
$amount = isset($_POST['amount']) ? $_POST['amount'] : null;
$notes = isset($_POST['notes']) ? trim($_POST['notes']) : null;



if (isset($_POST['addExpense'])) {
    if (!empty($expense_date) && !empty($description) && !empty($amount)) {
        // Nếu dùng INT AUTO_INCREMENT ID:
        $sql_addExpense = "INSERT INTO tbl_internal_expenses(expense_date, description, category, amount, notes) 
                           VALUES ('" . mysqli_real_escape_string($connect, $expense_date) . "',
                                   '" . mysqli_real_escape_string($connect, $description) . "',
                                   '" . mysqli_real_escape_string($connect, $category) . "',
                                   '" . mysqli_real_escape_string($connect, $amount) . "',
                                   '" . mysqli_real_escape_string($connect, $notes) . "')";
        

        if (mysqli_query($connect, $sql_addExpense)) {
            $_SESSION['message'] = "Thêm chi tiêu thành công!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Lỗi khi thêm chi tiêu: " . mysqli_error($connect);
            $_SESSION['message_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Vui lòng điền đầy đủ các trường bắt buộc.";
        $_SESSION['message_type'] = "warning";
    }
    header('Location:../../AdminIndex.php?workingPage=expenses'); 
    exit();

} else if (isset($_POST['editExpense'])) {
    $expenseId = isset($_GET['id']) ? $_GET['id'] : null;
    if ($expenseId && !empty($expense_date) && !empty($description) && !empty($amount)) {
        $sql_editExpense = "UPDATE tbl_internal_expenses 
                            SET expense_date='" . mysqli_real_escape_string($connect, $expense_date) . "', 
                                description='" . mysqli_real_escape_string($connect, $description) . "', 
                                category='" . mysqli_real_escape_string($connect, $category) . "', 
                                amount='" . mysqli_real_escape_string($connect, $amount) . "', 
                                notes='" . mysqli_real_escape_string($connect, $notes) . "' 
                            WHERE id='" . mysqli_real_escape_string($connect, $expenseId) . "'";

        if (mysqli_query($connect, $sql_editExpense)) {
            $_SESSION['message'] = "Cập nhật chi tiêu thành công!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Lỗi khi cập nhật chi tiêu: " . mysqli_error($connect);
            $_SESSION['message_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Thông tin không hợp lệ hoặc thiếu ID để cập nhật.";
        $_SESSION['message_type'] = "warning";
    }
    header('Location:../../AdminIndex.php?workingPage=expenses');
    exit();

} else if (isset($_POST['deleteExpense'])) {
    $expenseId = isset($_GET['id']) ? $_GET['id'] : null;
    if ($expenseId) {
        $sql_deleteExpense = "DELETE FROM tbl_internal_expenses WHERE id ='" . mysqli_real_escape_string($connect, $expenseId) . "'";
        if (mysqli_query($connect, $sql_deleteExpense)) {
            $_SESSION['message'] = "Xóa chi tiêu thành công!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Lỗi khi xóa chi tiêu: " . mysqli_error($connect);
            $_SESSION['message_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Thiếu ID để xóa.";
        $_SESSION['message_type'] = "warning";
    }
    header('Location:../../AdminIndex.php?workingPage=expenses');
    exit();
} else {
    // Nếu không có action nào được gọi, chuyển hướng về trang chính
    header('Location:../../AdminIndex.php?workingPage=expenses');
    exit();
}
?>