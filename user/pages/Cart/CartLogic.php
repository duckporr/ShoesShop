<?php
include "../../../common/config/Connect.php";

if (isset($_POST['deleteProduct'])) {
    $productId = $_GET['productId'];

    $deleteProductSql = "DELETE FROM tbl_cart_detail WHERE product_id ='" . $productId . "';";
    mysqli_query($connect, $deleteProductSql);

    header('Location:../../userCommon/UserIndex.php?usingPage=cart');
} else if (isset($_POST['confirmBuy'])) {
    //viết logic để tạo ra 1 order
    // var_dump($_POST['selectedPro']);
    $selectedPro = $_POST['selectedPro'];
    function generateUuid()
    {
        $data = random_bytes(16);

        // Set the version (4) and variant bits (2)
        $data[6] = chr(ord($data[6]) & 0x0F | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3F | 0x80);

        // Format the UUID string
        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

        return $uuid;
    }
    $order_id = generateUuid();
    foreach ($selectedPro as $item) {
        echo "các dòng được chọn: \n";
        $tachChuoi = explode("diayti", $item);

        // Lấy các UUID từ mảng
        $cartId = $tachChuoi[0];
        $productId = $tachChuoi[1];
        $sizeId = $tachChuoi[2];
        $show_cart_sql = "SELECT * FROM tbl_cart_detail WHERE tbl_cart_detail.cart_id = '$cartId' AND product_id = '$productId' ";
        $show_cart_query = mysqli_query($connect, $show_cart_sql);
        $row_cart = mysqli_fetch_array($show_cart_query);
        $insertSql = "INSERT INTO tbl_order_detail(order_id, product_id, size_id, quantity, unit_price) 
                        VALUES ('$order_id', '$productId', '$sizeId', $row_cart[quantity], $row_cart[unit_price])";
        mysqli_query($connect, $insertSql);
    }
    header('Location:../../userCommon/UserIndex.php?usingPage=payment&orderId=' . $order_id);
} else if (isset($_POST['editCart'])) {
    $productId = $_GET['productId'];
    $newQuantity = $_POST['quantity'];
    $newSize = $_POST['size'];
    $updateSql = "
    UPDATE tbl_cart_detail
    SET 
    quantity = '$newQuantity',
    size_id = '$newSize'
    WHERE product_id='$productId' AND cart_id = '$_COOKIE[cartId]';
    ";

    mysqli_query($connect, $updateSql);

    header('Location:../../userCommon/UserIndex.php?usingPage=cart');
}
