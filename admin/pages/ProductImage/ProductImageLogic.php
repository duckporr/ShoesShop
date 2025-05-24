<?php
include "../../../common/config/Connect.php";
$productId = "";
$imageId = "";
function generateUuid()
{
    $data = random_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0F | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3F | 0x80);

    $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

    return $uuid;
}

$uploads_dir = 'Images/'; // Đường dẫn tới thư mục lưu trữ ảnh
$file = $_FILES['images'];
if (isset($_POST['addProductImage'])) {
    $productId = $_GET['productId'];
    $description = $_POST['description'];

    if (isset($_FILES['images'])) {
        $file = $_FILES['images'];
        // Kiểm tra loại file
        if ($file['type'] == 'image/jpeg' || $file['type'] == 'image/jpg' || $file['type'] == 'image/png') {
            $content = "";
            $imageId = generateUuid();
            $content = $uploads_dir . $file['name']; // Lưu đường dẫn của ảnh vào content
            $main_image = isset($_POST['main_image']) ? 1 : 0;
            if ($main_image == 1) {
                $updateMainImageSQL = "UPDATE tbl_product_image SET main_image = 0 WHERE product_id = '$productId'";
                mysqli_query($connect, $updateMainImageSQL);
            }
            move_uploaded_file($file['tmp_name'], $uploads_dir . $file['name']); // Di chuyển ảnh đến thư mục lưu trữ
            $addProductimageSQL = "INSERT INTO tbl_product_image(id, product_id, description, content, main_image) 
                        VALUES ('" . $imageId . "','" . $productId . "','" . $description . "','" . $content . "', '" . $main_image . "')";
            mysqli_query($connect, $addProductimageSQL);
        }
    } else {
        echo "Loại file không hợp lệ.";
    }
} else if (isset($_POST['editProductImage'])) {
    $productId = $_GET['productId'];
    $description = $_POST['description'];
    if (isset($_FILES['images'])) {
        $file = $_FILES['images'];
        // Kiểm tra loại file
        if ($file['type'] == 'image/jpeg' || $file['type'] == 'image/jpg' || $file['type'] == 'image/png') {
            $content = "";
            $content = $uploads_dir . $file['name']; // Lưu đường dẫn của ảnh vào content
            $main_image = isset($_POST['main_image']) ? 1 : 0;
            echo $main_image;
            echo $content;
            if ($main_image == 1) {
                $updateMainImageSQL = "UPDATE tbl_product_image SET main_image = 0 WHERE product_id = '$productId'";
                mysqli_query($connect, $updateMainImageSQL);
            }
            move_uploaded_file($file['tmp_name'], $uploads_dir . $file['name']);
            $productId = $_GET['productId'];
            $imageId = $_GET['imageId'];
            echo $imageId;
            $deleteProductImageSQL = "DELETE FROM tbl_product_image WHERE product_id ='$productId' AND id = '$imageId';";
            $imageIdNew = generateUuid();
            mysqli_query($connect, $deleteProductImageSQL);
            $addProductimageSQL = "INSERT INTO tbl_product_image(id, product_id, description, content, main_image) 
                        VALUES ('" . $imageIdNew . "','" . $productId . "','" . $description . "','" . $content . "', '" . $main_image . "')";
            mysqli_query($connect, $addProductimageSQL);
        } else if($file) {
            $productId = $_GET['productId'];
            $imageId = $_GET['imageId'];
            $main_image = isset($_POST['main_image']) ? 1 : 0;
            if ($main_image == 1) {
                $updateMainImageSQL = "UPDATE tbl_product_image SET main_image = 0 WHERE product_id = '$productId'";
                mysqli_query($connect, $updateMainImageSQL);
            }
            $updateNoImgSQL = "UPDATE tbl_product_image SET main_image = $main_image WHERE id = '$imageId'";
            mysqli_query($connect, $updateNoImgSQL);
        } else {
            echo "Loại file không hợp lệ.";
    } 
    }
} else if (isset($_POST['deleteProductImage'])) {
    $productId = $_GET['productId'];
    $imageId = $_GET['imageId'];
    $deleteProductImageSQL = "DELETE FROM tbl_product_image WHERE product_id ='$productId' AND id = '$imageId';";

    mysqli_query($connect, $deleteProductImageSQL);
}

header("Location: ../../AdminIndex.php?workingPage=productImage&productId=" . $productId);
