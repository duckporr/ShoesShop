<?php
include "../../../common/config/Connect.php";
function generateCode()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';

    for ($i = 0; $i < 8; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $code;
}

if (isset($_POST['confirmBuy'])) {
    $get_payment = "SELECT * FROM tbl_payment_type WHERE id = '$_POST[paymentMethod]'";
    $row_payment = mysqli_fetch_array(mysqli_query($connect, $get_payment));
    $user_Id = $_GET['userId'];
    $order_id = $_POST['orderId'];
    $order_code = generateCode();
    $phone = $_POST['phone'];
    $province = $_POST['province'];
    $district = $_POST['district'];
    // id của chờ xác nhận
    $status_id = 'f1e30780-f494-477d-8fba-63d280843c91';
    $ward = $_POST['ward'];
    $address = $ward . ", " . $district . ", " . $province;
    $delivery_cost = $_POST['delivery'];
    $payment_method = $_POST['paymentMethod'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $currentTime = date("Y-m-d H:i:s");
    $sql = "INSERT INTO tbl_order (id, code, user_id, status_id, receive_phone, receive_address, delivery_cost, payment_id, description, createDate)
        VALUES ('$order_id', '$order_code', '$user_Id', '$status_id', '$phone', '$address', $delivery_cost, '$payment_method', '', '$currentTime')";

    mysqli_query($connect, $sql);

    $product_ids_str = $_POST['productIds'];
    $product_ids = explode(',', $product_ids_str);

    foreach ($product_ids as $productId) {
        $delSql = "DELETE FROM tbl_cart_detail WHERE product_id = '$productId'";
        mysqli_query($connect, $delSql);
    }
    if ($row_payment['code'] == "#CKNN") {
        header('Content-type: text/html; charset=utf-8');
        function execPostRequest($url, $data)
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data)
                )
            );
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            //execute post
            $result = curl_exec($ch);
            //close connection
            curl_close($ch);
            return $result;
        }

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $_POST['totalAmount'] + $_POST['delivery'];
        $orderId = $order_code;
        $redirectUrl = "http://localhost/sneaker-php/user/userCommon/UserIndex.php?usingPage=done";
        $ipnUrl = "http://localhost/sneaker-php/user/userCommon/UserIndex.php?usingPage=done";
        $extraData = "";

        $partnerCode = $partnerCode;
        $accessKey = $accessKey;
        $serectkey = $secretKey;
        $orderId = $orderId; // Mã đơn hàng
        $orderInfo = $orderInfo;
        $amount = $amount;
        $ipnUrl = $ipnUrl;
        $redirectUrl = $redirectUrl;
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        $extraData = "";
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $serectkey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there

        header('Location: ' . $jsonResult['payUrl']);
    } else if ($row_payment['code'] == "#TTD&GN") {
        header('Content-type: text/html; charset=utf-8');

        function execPostRequest($url, $data)
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data)
                )
            );
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            //execute post
            $result = curl_exec($ch);
            //close connection
            curl_close($ch);
            return $result;
        }


        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $_POST['totalAmount'] + $_POST['delivery'];
        $orderId = $order_code;
        $redirectUrl = "http://localhost/sneaker-php/user/userCommon/UserIndex.php?usingPage=done";
        $ipnUrl = "http://localhost/sneaker-php/user/userCommon/UserIndex.php?usingPage=done";
        $extraData = "";

        $partnerCode = $partnerCode;
        $accessKey = $accessKey;
        $serectkey = $secretKey;
        $orderId = $order_code; // Mã đơn hàng
        $orderInfo = $orderInfo;
        $amount = $amount;
        $ipnUrl = $ipnUrl;
        $redirectUrl = $redirectUrl;
        $extraData = $extraData;

        $requestId = time() . "";
        $requestType = "captureWallet";
        $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $serectkey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there
        header('Location: ' . $jsonResult['payUrl']);
    } else {
        header('Location:../../userCommon/UserIndex.php?usingPage=done&orderId=' . $order_id);
    }
}
?>
<script type="text/javascript" src="./statics/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="./statics/moment/min/moment.min.js"></script>