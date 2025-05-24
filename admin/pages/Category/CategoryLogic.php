<?php
include "../../../common/config/Connect.php";
$tendanhmuc = $_POST['tendanhmuc'];
$code=$_POST['code'];
$description=$_POST['description'];
//xử lý hình anh
$file = $_FILES['hinhanh'];
$hinhanh = $file['name'];
$hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
$hinhanhgio = time() . '_' . $hinhanh;




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

if (isset($_POST['themdanhmuc'])) {
    
    if (isset($_FILES['hinhanh'])) {
        if ($file['type'] == 'image/jpeg' || $file['type'] == 'imgae/jpg' || $file['type'] == 'image/png') {
            move_uploaded_file($hinhanh_tmp, 'CategoryImages/' . $hinhanh);
            $categoryId =  generateUuid();
            $sql_themdanhmuc = "INSERT INTO tbl_category(id,code,name,category_image,description) 
                VALUE ('" . $categoryId . "' ,'". $code ."' ,'" . $tendanhmuc . "','" . $hinhanh . "', '". $description. "' )";
            mysqli_query($connect, $sql_themdanhmuc);
            header('Location:../../AdminIndex.php?workingPage=category');
        } else {
            $hinhanh = '';
            header('Location:../../AdminIndex.php?workingPage=category');
        }
    }
} else if (isset($_POST['suadanhmuc'])) {
    if ($hinhanh != '') {
        move_uploaded_file($hinhanh_tmp, 'CategoryImages/' . $hinhanh);
        $sql_sua = "UPDATE tbl_category SET code='". $code ."', name='" . $tendanhmuc . "',category_image='" . $hinhanh . "', description='".$description."' WHERE id='$_GET[categoryId]'";
        $sql = "SELECT*FROM tbl_category WHERE id='$_GET[id]' LIMIT 1";
        $query = mysqli_query($connect, $sql);
        while ($row = mysqli_fetch_array($query)) {
            unlink('CategoryImages/' . $row['hinhanh']);   
        }
    } else {
        $sql_sua = "UPDATE tbl_category SET code='". $code ."', name ='" . $tendanhmuc . "', description='".$description."' WHERE id='$_GET[categoryId]'";
    }
    mysqli_query($connect, $sql_sua);
    header('Location:../../AdminIndex.php?workingPage=category');
}else if (isset($_POST['xoadanhmuc'])) {
    $id = $_GET['categoryId'];
    $sql = "SELECT *FROM tbl_category WHERE id = '$id'";
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
        unlink('CategoryImages/' . $row['category_image']);
    }
    $sql_xoa = "DELETE FROM tbl_category WHERE id ='" . $id . "';";
    mysqli_query($connect, $sql_xoa);

    header('Location:../../AdminIndex.php?workingPage=category');
}


