<?php
include "../../../common/config/Connect.php";

if (isset($_POST['changeInfor'])) {
   
    //$file = $_FILES['avatarFile'];
    //$avatarFile = $_FILES['avatarFile'];
    //$upload_dir = "admin/pages/User/UserImages/";
    $fullName = $_POST["fullName"];
    $phone = $_POST["phone"];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $birthDate = $_POST["birthDate"];
    $gender = $_POST["gender"];
    $userId = $_GET["userId"];

    $file = $_FILES['hinhanh'];
$hinhanh = $file['name'] || "";
$hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
if (isset($_FILES['hinhanh']) && ($file['type'] == 'image/jpeg' || $file['type'] == 'image/jpg' || $file['type'] == 'image/png')) {
    move_uploaded_file($hinhanh_tmp, '../../../admin/pages/User/UserImages/' . $hinhanh);
}

    // Update user information in the database
    $updateUserSql = "UPDATE tbl_user 
                      SET 
                        user_image = '" . $hinhanh . "',
                            fullname = '$fullName', 
                          phonenumber = '$phone', 
                          email = '$email',
                          address = '$address', 
                          birthDate = '$birthDate', 
                          gender = '$gender'
                      WHERE id = '$userId'";

    $updateUserSql_query = mysqli_query($connect, $updateUserSql);

    header('Location:../../userCommon/UserIndex.php?usingPage=account');
} else if (isset($_POST["cancel"])) {
    // Lấy ID đơn hàng cần hủy
    $order_id = $_POST["order_id"];
    $product_id = $_POST['product_id'];
    $cancel_order_sql = "UPDATE tbl_order INNER JOIN tbl_order_detail ON tbl_order.id = tbl_order_detail.order_id SET status_id = '10dcaad2-8c9e-4078-85b4-8fbd6ed50c26' WHERE order_id = '$order_id' AND product_id = '$product_id'";
    $cancel_order_query = mysqli_query($connect, $cancel_order_sql);

    header('Location:../../userCommon/UserIndex.php?usingPage=account');
}

?>
