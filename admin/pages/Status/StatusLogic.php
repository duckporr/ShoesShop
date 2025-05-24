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

if (isset($_POST['addStatus'])) {
    $statusId =  generateUuid();
    $sql_addStatus = "INSERT INTO tbl_status(id, code, name, description) 
                VALUE ('" . $statusId . "','" . $code . "','" . $name . "','" . $description . "')";
    mysqli_query($connect, $sql_addStatus);
    header('Location:../../AdminIndex.php?workingPage=status');
} else if (isset($_POST['editStatus'])) {
    $StatusId = $_GET['id'];  // Assuming productId is passed through GET parameter
    $sql_editStatus = "UPDATE tbl_status SET code='" . $code . "', name='" . $name . "', description='" . $description . "' WHERE id='$_GET[id]'";
    mysqli_query($connect, $sql_editStatus);
    header('Location:../../AdminIndex.php?workingPage=status');
} else if (isset($_POST['deleteStatus'])) {
    $id = $_GET['id'];
    $sql_deleteStatus = "DELETE FROM tbl_status WHERE id ='" . $id . "';";
    mysqli_query($connect, $sql_deleteStatus);
    header('Location:../../AdminIndex.php?workingPage=status');
}
