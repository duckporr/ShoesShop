<?php
include "../../../common/config/Connect.php";
$code = $_POST['code'];
$name = $_POST['name'];
$discount = $_POST['discount'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$description = $_POST['description'];
//xử lý hình anh
$file = $_FILES['banner'];
$banner = $file['name'];
$banner_tmp = $_FILES['banner']['tmp_name'];

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

if (isset($_POST['addEvent'])) {
    if (isset($_FILES['banner'])) {
        if ($file['type'] == 'image/jpeg' || $file['type'] == 'imgae/jpg' || $file['type'] == 'image/png') {

            move_uploaded_file($banner_tmp, 'EventImages/' . $banner);

            $eventId =  generateUuid();
            $sql_addEvent = "INSERT INTO tbl_event(id, code, name, banner, discount, start_date, end_date, description) 
                VALUE ('" . $eventId . "','" . $code . "','" . $name . "','" . $banner . "','" . $discount . "','" . $start_date . "','" . $end_date . "','" . $description . "')";
            mysqli_query($connect, $sql_addEvent);
            header('Location:../../AdminIndex.php?workingPage=event');
        } else {
            $banner = '';
            header('Location:../../AdminIndex.php?workingPage=event');
        }
    }
} else if (isset($_POST['editEvent'])) {
    if ($banner != '') {
        $EventId = $_GET['id'];  // Assuming productId is passed through GET parameter
        $description_img = $_POST['des_img'];
        // Process image upload if a new image is provided
        if ($hinhanh != '') {
            move_uploaded_file($hinhanh_tmp, 'EventImages/' . $hinhanh);

            // Update tbl_product_image
            $sql_update_image = "UPDATE tbl_product_image SET description='$description_img', content='$hinhanh' WHERE id='$EventId'";
            mysqli_query($connect, $sql_update_image);
            header('Location: ../../AdminIndex.php?workingPage=event');
        }

        $sql_editEvent = "UPDATE tbl_event SET code='" . $code . "', name='" . $name . "', banner='" . $banner . "', discount='" . $discount . "', start_date='" . $start_date . "',end_date='" . $end_date . "',
        description='" . $description . "' WHERE id='$_GET[id]'";
        $sql = "SELECT*FROM tbl_event WHERE id='$_GET[id]'";
        $query = mysqli_query($connect, $sql);
        while ($row = mysqli_fetch_array($query)) {
            unlink('EventImages/' . $row['banner']);
        }
    } else {
        $sql_editEvent = "UPDATE tbl_event SET code='" . $code . "', name='" . $name . "', banner='" . $banner . "', discount='" . $discount . "', start_date='" . $start_date . "',end_date='" . $end_date . "',
        description='" . $description . "' WHERE id='$_GET[id]'";
    }
    mysqli_query($connect, $sql_editEvent);
    header('Location:../../AdminIndex.php?workingPage=event');
} else if (isset($_POST['deleteEvent'])) {
    $id = $_GET['id'];
    $sql = "SELECT *FROM tbl_event WHERE id = '$id'";
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
        unlink('EventtImages/' . $row['banner']);
    }
    $sql_deleteEvent = "DELETE FROM tbl_event WHERE id ='" . $id . "';";
    mysqli_query($connect, $sql_deleteEvent);
    header('Location:../../AdminIndex.php?workingPage=event');
}
