<?php
include "../../../common/config/Connect.php";
$productId = "";

if (isset($_POST['addProductSize'])) {
    $quantity = $_POST['quantity'];
    $productId = $_GET['productId'];
    $sizeId = $_POST['sizeId'];

    $addProductSizeSQL = "INSERT INTO tbl_product_size(product_id, size_id, quantity) 
                VALUES ('" . $productId . "','" . $sizeId . "','" . $quantity . "')";
    mysqli_query($connect, $addProductSizeSQL);
}

if (isset($_POST['editProductSize'])) {
    $quantity = $_POST['quantity'];
    $productId = $_GET['productId'];
    $newSizeId = $_POST['sizeId'];
    $oldSizeId = $_GET['sizeId'];

    $updateProductSizeSQL = "UPDATE tbl_product_size SET quantity = '$quantity', size_id = '$newSizeId' WHERE product_id = '$productId' AND size_id = '$oldSizeId'";

    mysqli_query($connect, $updateProductSizeSQL);
}

if (isset($_POST['deleteProductSize'])) {
    $productId = $_GET['productId'];
    $sizeId = $_GET['sizeId'];

    $deleteProductSizeSQL = "DELETE FROM tbl_product_size WHERE product_id ='" . $productId . "' AND size_id = '$sizeId';";

    mysqli_query($connect, $deleteProductSizeSQL);
}

header("Location: ../../AdminIndex.php?workingPage=productSize&productId=" . $productId);
