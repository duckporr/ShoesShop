<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../styles/style_cart.css">
    <link rel="icon" type="image/png" href="./images/Ducklogonotbackground.png">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js" integrity="sha512-EKWWs1ZcA2ZY9lbLISPz8aGR2+L7JVYqBAYTq5AXgBkSjRSuQEGqWx8R1zAX16KdXPaCjOCaKE8MCpU0wcHlHA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../styles//UserStyles.css">
    <link rel="stylesheet" href="../../common//css//CommonStyle.css">
    <title>Thế giới giày đẹp DuckShop | Trần Văn Đức</title>
</head>

<body>

    <div class="flex-column mh-100vh mainApp">
        <?php
        session_start();

        function generateUuid()
        {
            $data = random_bytes(16);

            $data[6] = chr(ord($data[6]) & 0x0F | 0x40);
            $data[8] = chr(ord($data[8]) & 0x3F | 0x80);

            $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

            return $uuid;
        }

        include("../../common/config/Connect.php");


        $cartId = '';

        if (isset($_COOKIE['cartId'])) {
            // Cookie exists
            $cartId = $_COOKIE['cartId'];
        } else {
            // Cookie does not exist
            $cartId = generateUuid();
        }
        setcookie('cartId', $cartId, time() + (365 * 24 * 60 * 60), '/');

        include("./Header.php");
        include("./UserRouter.php");
        include("./Footer.php");
        ?>
    </div>

    <script type="text/javascript" src="../javascript//Modal.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="../common//javascript/PrintElement.js"></script>

</body>

</html>