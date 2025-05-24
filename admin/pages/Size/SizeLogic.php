<?php
include "../../../common/config/Connect.php";
$code = $_POST['code'];
$name = $_POST['name'];
$description = $_POST['description'];

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

// Example usage

if (isset($_POST['addSize'])) {
    $sizeId =  generateUuid();
    $sql_addSize = "INSERT INTO tbl_size(id, code, name, description) 
                VALUE ('" . $sizeId . "','" . $code . "','" . $name . "','" . $description . "')";
    mysqli_query($connect, $sql_addSize);
    header('Location:../../AdminIndex.php?workingPage=size');
} else if (isset($_POST['editSize'])) {
    $SizeId = $_GET['id'];  // Assuming productId is passed through GET parameter
    $sql_editSize = "UPDATE tbl_size SET code='" . $code . "', name='" . $name . "', description='" . $description . "' WHERE id='$_GET[id]'";
    mysqli_query($connect, $sql_editSize);
    header('Location:../../AdminIndex.php?workingPage=size');
} else if (isset($_POST['deleteSize'])) {
    $id = $_GET['id'];
    $sql_deleteSize = "DELETE FROM tbl_size WHERE id ='" . $id . "';";
    mysqli_query($connect, $sql_deleteSize);
    header('Location:../../AdminIndex.php?workingPage=size');
}
