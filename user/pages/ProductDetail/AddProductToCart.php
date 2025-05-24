<?php
include "../../../common/config/Connect.php";

$cartId = '';
// Check if the cookie is set
if (isset($_COOKIE['cartId'])) {
    // Cookie exists
    $cartId = $_COOKIE['cartId'];
    echo "Cart ID exists: $cartId";
} else {
    // Cookie does not exist
    echo "Cart ID does not exist.";
    $cartId = generateUuid();
    setcookie('cartId', $cartId, time() + (365 * 24 * 60 * 60), '/');
}

function generateUuid()
{
    $data = random_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0F | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3F | 0x80);

    $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

    return $uuid;
}

if (isset($_POST['addToCart'])) {
    $productId = $_GET['productId'];
    $quantity = $_POST['quantity'];
    $selectedSize = $_POST['selectedSize'];
    $price = $_POST['price'];
    echo "\n cart id: " . $cartId;
    echo "\n product id: " . $productId;
    echo "\n size id: " . $selectedSize;
    echo "\n quantity: " . $quantity;
    echo "\n price: " . $price;
    $addProductToCart = "INSERT INTO tbl_cart_detail(cart_id, product_id, size_id, quantity, unit_price) VALUES ('$cartId','$productId','$selectedSize',$quantity,$price)";
         
    mysqli_query($connect, $addProductToCart);
}

header('Location:../../userCommon/UserIndex.php?usingPage=cart');
