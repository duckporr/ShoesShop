<?php
include "../../common/config/Connect.php";
session_start();
if(isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
}
$orderId = $_GET['orderId'];
$sql = "SELECT * FROM tbl_user WHERE id = '$userId'";
$query = mysqli_query($connect, $sql);
$result = mysqli_fetch_assoc($query);
$email = $result['email'];
$username = $result['username'];

$sql_order  = "SELECT * FROM tbl_order WHERE user_id = '$userId'";
$query_order = mysqli_query($connect, $sql_order);
$result_order = mysqli_fetch_assoc($query_order);


$getAllOrderSQL = "SELECT * FROM tbl_product
                    INNER JOIN tbl_order_detail ON tbl_order_detail.product_id = tbl_product.id
                    WHERE tbl_order_detail.order_id = '$orderId';";

$tableOrderData = mysqli_query($connect, $getAllOrderSQL);

date_default_timezone_set('Etc/GMT+7');
$currentDay = date('d');
$currentMonth = date('m');
$currentYear = date('Y');
?>

<?php
function GuiMail($email, $content, $username) {
    require "PHPMailer-master/src/PHPMailer.php"; 
    require "PHPMailer-master/src/SMTP.php"; 
    require 'PHPMailer-master/src/Exception.php'; 
    
    $mail = new PHPMailer\PHPMailer\PHPMailer(true); // true: enables exceptions
    $mail->SMTPDebug = 0; // 0,1,2: chế độ debug. khi chạy ngon thì chỉnh lại 0 nhé
    $mail->isSMTP();  
    $mail->CharSet  = "utf-8";
    $mail->Host = 'smtp.gmail.com';  // SMTP servers
    $mail->SMTPAuth = true; // Enable authentication
    $mail->Username = 'shopshoesland@gmail.com'; // SMTP username
    $mail->Password = 'ktnr mdiu ccwp pvzg';   // SMTP password
    $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
    $mail->Port = 465;  // port to connect to                
    $mail->setFrom('shopshoesland@gmail.com', 'ShoesLandShop'); 
    $mail->addAddress($email, $username); // mail và tên người nhận  
    $mail->isHTML(true);  // Set email format to HTML
    $mail->Subject = 'Shop giày ShoesLand kính gửi bạn!';
    $noidungthu = 'Đơn hàng của bạn'; 
    $mail->Body = $content;
    $mail->smtpConnect( array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
            "allow_self_signed" => true
        )
    ));
    $mail->send();
}
?>
<?php
if (isset($_POST['confirm'])) {
    ob_start(); 
    
        $content = "<div class='orderContainer display-flex' style='align-items: center; flex-direction: column;'>
    <div class='headerPrintOrder flex-center justify-between' style='padding: 0px 40px;'>
        <div class='logo w-300 h-300'>
            <img src='https://scontent.xx.fbcdn.net/v/t1.15752-9/385531793_665092928850659_9049026433017091781_n.jpg?stp=dst-jpg_p206x206&_nc_cat=111&ccb=1-7&_nc_sid=510075&_nc_ohc=lgHPtfIooO0AX9Lgia2&_nc_ad=z-m&_nc_cid=0&_nc_ht=scontent.xx&oh=03_AdSJ0IjzJmukql67fujDBhjSqxH66Y9EJQSe_IEKM58l9Q&oe=659C4C0D'>
        </div>
        <div class='storeInfo text-center'>
            <h1 style='text-align: center;'>HÓA ĐƠN BÁN HÀNG</h1>
            <h4><i class='fa-solid fa-square-phone'></i> HOTLINE: 01675984726</h4>
            <h4><i class='fa-solid fa-location-dot'></i> 210 Lê Trọng Tấn, Thanh Xuân, Hà Nội</h4>
            <h4></h4>
        </div>
    </div>
    <div class='bodyPrintOrder mb-20' style='font-size: 16px;'>
        <div class='orderInfo'>
            <div class='flex mb-3'>
                <p style='overflow: hidden; white-space: nowrap; text-overflow: ellipsis; display: inline-block; width: 100%; margin-bottom: 5px;'>
                    <strong>Mã Đơn Hàng: </strong>{$result_order['code']}; 
                </p>
                <p style='overflow: hidden; white-space: nowrap; text-overflow: ellipsis; display: inline-block; width: 100%; margin-bottom: 5px;' class='justify-right'>
                    <strong>Điện Thoại Nhận Hàng:</strong> {$result_order['receive_phone']};
                </p>
            </div>
            <p style='overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'><strong>Địa Chỉ Nhận:</strong> {$result_order['receive_address']}</p>
            <p><strong>Ghi chú đơn hàng:</strong> {$result_order['description']}</p>
        </div>
        <div class='product-table'>
            <table border='1' class='w-100 table'>
                <thead class='table-head w-100' style='background-color: white;'>
                    <tr>
                        <th class='col-1' style='text-align: center; vertical-align: middle;'>STT</th>
                        <th class='col-2' style='text-align: center; vertical-align: middle;'>Mã Sản Phẩm</th>
                        <th class='col-4' style='text-align: center; vertical-align: middle;'>Tên Sản Phẩm</th>
                        <th class='col-1' style='text-align: center; vertical-align: middle;'>Số Lượng</th>
                        <th class='col-2' style='text-align: center; vertical-align: middle;'>Đơn Giá</th>
                        <th class='col-3' style='text-align: center; vertical-align: middle;'>Thành Tiền</th>
                    </tr>
                </thead>
                <tbody class='table-body'>";

    $displayOrder = 0;
    $total = $result_order['delivery_cost'];

    while ($rowOrderData = mysqli_fetch_array($tableOrderData)) {
        $displayOrder++;
        $total += $rowOrderData['unit_price'];

        $content .= "<tr>
                        <td style='text-align: center; vertical-align: middle;'> $displayOrder </td>
                        <td style='text-align: center; vertical-align: middle;'> {$rowOrderData['code']} </td>
                        <td style='text-align: center; vertical-align: middle;'> {$rowOrderData['name']} </td>
                        <td style='text-align: center; vertical-align: middle;'> {$rowOrderData['quantity']} </td>
                        <td style='text-align: center; vertical-align: middle;'> {$rowOrderData['unit_price']} </td>
                        <td style='text-align: right; vertical-align: middle;'> ".($rowOrderData['quantity'] * $rowOrderData['unit_price']) . '(VNĐ) </td>
                    </tr>';
    }

    $content .= "</tbody>
            </table>
        </div>
        <div class='fbody flex justify-between'>
            <div class='createDate text-center'>
                <p> Ngày  $currentDay tháng  $currentMonth  năm  $currentYear  </p>
                <p><strong>Người viết hóa đơn</strong></p>
            </div>
            <div class='total'>
                <p><strong>Tiền Ship:</strong>  {$result_order['delivery_cost']} VNĐ </p>
                <p><strong>Tổng Tiền:</strong>  $total VNĐ</p>
            </div>
        </div>
    </div>
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Whisper&display=swap' rel='stylesheet'>
    <div class='footerPrintOrder text-center' style='position: fixed; bottom: 0; width: 100%; font-family: 'Whisper', cursive;'>
        <h1 style='font-size: 50px; font-family: 'Whisper', cursive;'><strong>♡ Thank You ♡</strong></h1>
    </div>
</div>";

    GuiMail($email, $content, $username);
    header('Location: ../../user/userCommon/UserIndex.php?usingPage=mail');
    
    
    ob_end_flush();
}
?>
