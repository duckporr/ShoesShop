<?php
// admin/pages/Inventory/InventoryTransactionsLogic.php
session_start();
require_once __DIR__ . '/../../../common/config/Connect.php';

if (!isset($connect)) {
    $_SESSION['inventory_message'] = "Lỗi kết nối CSDL.";
    $_SESSION['inventory_message_type'] = "danger";
    header('Location: ../../AdminIndex.php?page=InventoryTransactions');
    exit();
}

// Không còn $product_table_name_logic vì không tương tác với bảng sản phẩm nữa

$current_page_w = isset($_POST['current_page_w']) ? (int)$_POST['current_page_w'] : 1;
$current_limit_w = isset($_POST['current_limit_w']) ? (int)$_POST['current_limit_w'] : 10;
$current_search_w = isset($_POST['current_search_w']) ? trim($_POST['current_search_w']) : '';

$redirect_query_params_w = "page=InventoryTransactions"
                         . "&page_w=" . urlencode($current_page_w)
                         . "&limit_w=" . urlencode($current_limit_w);
if (!empty($current_search_w)) {
    $redirect_query_params_w .= "&search_w=" . urlencode($current_search_w);
}
$base_redirect_url_w = '../../AdminIndex.php?' . $redirect_query_params_w;


if (isset($_POST['addInventoryTransaction'])) {
    $product_id_for_warehouse = isset($_POST['product_id']) ? trim(mysqli_real_escape_string($connect, $_POST['product_id'])) : null;
    $transaction_date_sql = isset($_POST['transaction_date']) ? trim(mysqli_real_escape_string($connect, $_POST['transaction_date'])) : date('Y-m-d H:i:s');
    $transaction_type = isset($_POST['transaction_type']) ? trim($_POST['transaction_type']) : null;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
    
    $import_price_str = isset($_POST['import_price']) ? preg_replace('/[^\d.]/', '', $_POST['import_price']) : '';
    $import_price = ($import_price_str !== '') ? (float)$import_price_str : NULL;

    $export_price_str = isset($_POST['export_price']) ? preg_replace('/[^\d.]/', '', $_POST['export_price']) : '';
    $export_price = ($export_price_str !== '') ? (float)$export_price_str : NULL;
    
    $notes_sql = isset($_POST['notes']) ? trim(mysqli_real_escape_string($connect, $_POST['notes'])) : null;

    if (empty($product_id_for_warehouse) || empty($transaction_type) || $quantity <= 0) {
        $_SESSION['inventory_message'] = "Vui lòng điền Product ID, Loại GD, Số lượng > 0.";
        $_SESSION['inventory_message_type'] = "danger";
        header('Location: ' . $base_redirect_url_w);
        exit();
    }
    if (strlen($product_id_for_warehouse) > 50) {
        $_SESSION['inventory_message'] = "Product ID không được vượt quá 50 ký tự.";
        $_SESSION['inventory_message_type'] = "danger";
        header('Location: ' . $base_redirect_url_w);
        exit();
    }

    $in_quantity = 0;
    $out_quantity = 0;

    if ($transaction_type == 'IN') {
        $export_price = NULL;
    } elseif ($transaction_type == 'OUT') {
        $import_price = NULL;
    }

    mysqli_begin_transaction($connect);
    try {
        // Lấy tồn kho cuối cùng của product_id này từ tbl_warehouse
        $sql_last_stock = "SELECT inventory_after_transaction 
                           FROM tbl_warehouse 
                           WHERE product_id = ? 
                           ORDER BY transaction_date DESC, warehouse_log_id DESC 
                           LIMIT 1";
        $stmt_last_stock = mysqli_prepare($connect, $sql_last_stock);
        mysqli_stmt_bind_param($stmt_last_stock, "s", $product_id_for_warehouse);
        mysqli_stmt_execute($stmt_last_stock);
        $result_last_stock = mysqli_stmt_get_result($stmt_last_stock);
        
        $previous_inventory = 0;
        if ($row_last_stock = mysqli_fetch_assoc($result_last_stock)) {
            $previous_inventory = (int)$row_last_stock['inventory_after_transaction'];
        }
        mysqli_stmt_close($stmt_last_stock);

        $new_inventory_after_transaction = $previous_inventory;

        if ($transaction_type == 'IN') {
            $in_quantity = $quantity;
            $new_inventory_after_transaction = $previous_inventory + $quantity;
        } elseif ($transaction_type == 'OUT') {
            if ($quantity > $previous_inventory) {
                throw new Exception("Số lượng xuất ($quantity) vượt quá tồn kho hiện tại ($previous_inventory) của Product ID: " . htmlspecialchars($product_id_for_warehouse));
            }
            $out_quantity = $quantity;
            $new_inventory_after_transaction = $previous_inventory - $quantity;
        } else {
            throw new Exception("Loại giao dịch không hợp lệ.");
        }

        $sql_insert_warehouse = "INSERT INTO tbl_warehouse
                                    (product_id, transaction_date, in_quantity, out_quantity, import_price, export_price, inventory_after_transaction, notes)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($connect, $sql_insert_warehouse);
        mysqli_stmt_bind_param($stmt_insert, "ssiiddis",
            $product_id_for_warehouse, $transaction_date_sql, $in_quantity, $out_quantity,
            $import_price, $export_price, $new_inventory_after_transaction, $notes_sql
        );
        if (!mysqli_stmt_execute($stmt_insert)) {
            throw new Exception("Lỗi thêm vào kho: " . mysqli_stmt_error($stmt_insert));
        }
        mysqli_stmt_close($stmt_insert);

        // Không còn cập nhật bảng products nữa

        mysqli_commit($connect);
        $_SESSION['inventory_message'] = "Thêm giao dịch kho thành công cho Product ID: " . htmlspecialchars($product_id_for_warehouse);
        $_SESSION['inventory_message_type'] = "success";

    } catch (Exception $e) {
        mysqli_rollback($connect);
        $_SESSION['inventory_message'] = "Lỗi: " . $e->getMessage();
        $_SESSION['inventory_message_type'] = "danger";
    }
    header('Location:../../AdminIndex.php?workingPage=inventory');
    exit();

} else {
    $_SESSION['inventory_message'] = "Hành động không hợp lệ.";
    $_SESSION['inventory_message_type'] = "warning";
    header('Location:../../AdminIndex.php?workingPage=inventory');
    exit();
}
mysqli_close($connect);
?>