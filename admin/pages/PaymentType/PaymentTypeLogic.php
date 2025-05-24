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

if (isset($_POST['addPaymentType'])) {
    $paymentTypeId =  generateUuid();
    $sql_addPaymentType = "INSERT INTO tbl_payment_type(id, code, name, description) 
                VALUE ('" . $paymentTypeId . "','" . $code . "','" . $name . "','" . $description . "')";
    mysqli_query($connect, $sql_addPaymentType);
    header('Location:../../AdminIndex.php?workingPage=payment_type');
} else if (isset($_POST['editPaymentType'])) {
    $PaymentTypeId = $_GET['id'];  // Assuming productId is passed through GET parameter
    $sql_editPaymentType = "UPDATE tbl_payment_type SET code='" . $code . "', name='" . $name . "', description='" . $description . "' WHERE id='$_GET[id]'";
    mysqli_query($connect, $sql_editPaymentType);
    header('Location:../../AdminIndex.php?workingPage=payment_type');
} else if (isset($_POST['deletePaymentType'])) {
    $id = $_GET['id'];
    $sql_deletePaymentType = "DELETE FROM tbl_payment_type WHERE id ='" . $id . "';";
    mysqli_query($connect, $sql_deletePaymentType);
    header('Location:../../AdminIndex.php?workingPage=payment_type');
}
