<?php
$eventId = isset($_GET['eventId']) ? $_GET['eventId'] : "";

//Phân trang
$countAllSql = "SELECT * FROM tbl_product WHERE tbl_product.event_id = '$eventId'";
$total_records = mysqli_num_rows(mysqli_query($connect, $countAllSql));

$pageIndex = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 16;

$total_page = ceil($total_records / $pageSize);

$start = ($pageIndex - 1) * $pageSize;

$findProductByEventIdSQL = "SELECT * FROM tbl_event WHERE tbl_event.id ='$eventId'";
$productData = mysqli_query($connect, $findProductByEventIdSQL);
$eventDetail =  mysqli_fetch_array($productData);

$findProductByEventIdSQL = "SELECT * FROM tbl_product WHERE tbl_product.event_id = '$eventId'  LIMIT $start, $pageSize";
$productByEvent = mysqli_query($connect, $findProductByEventIdSQL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .appCart1 {
            width: 100%;
            background-color: #fff;
            padding: 5px;
            border-radius: 15px;
            display: flex;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .img1 {
            max-width: 100%;
            height: auto;
            margin-left: -7px;
            border-radius: 10px;
            box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
        }

        .title {
            font-size: 1.5em;
            font-family: 'Montserrat', sans-serif;
            text-align: left;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .row {
            display: flex;
        }

        .title.col-4 ul {
            list-style: none;
            padding: 0;
        }

        .title.col-4 li {
            margin-bottom: 10px;
            font-size: 16px;
            color: #333;
        }

        .title.col-4 li:first-child {
            font-weight: bold;
        }

        .head-title {
            margin-bottom: 10px;
            font-size: 18px;
            transition: transform 0.3s ease;
        }
    </style>
    <!-- Hidden appCard1 when move to next page -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy thông tin về trang hiện tại từ URL
            const urlParams = new URLSearchParams(window.location.search);
            const currentPage = parseInt(urlParams.get('page')) || 1;

            // Lấy phần tử cần ẩn/hiện
            const appCard1 = document.querySelector('.appCard');
            const h5Element = document.querySelector('h5.enable-none');

            // Kiểm tra nếu trang hiện tại không phải là trang đầu tiên, thì ẩn appCard1 và h5
            if (currentPage > 1) {
                appCard1.classList.add('display-none');
                if (h5Element) {
                    h5Element.classList.add('display-none');
                }
            }
        });
    </script>
    </script>

</head>

<body>
    <div class="appCard">
        <h5 style="text-transform: uppercase; font-family: Arial, Helvetica, sans-serif;" class="enable_none mt-2 ml-2 mb-2"> Sự kiện <i class="fa-solid fa-chevron-right fa-2xs"></i>
            <?php
            if (isset($eventDetail['name'])) {
                echo $eventDetail['name'];
            }
            ?>
        </h5>
        <div class="row m-0 ml-1">
            <div class="col-8 mb-3">
                <div class="image_event">
                <img class="img1" src="./../../admin/pages/Event/EventImages/<?php echo $eventDetail['banner'] ?>" alt="">
                </div>
            </div>
            <div class="title col-4 ">
                <ul>
                    <li class="head-title">
                        <?php echo $eventDetail['code'] . " " . $eventDetail['name'] ?>
                    </li>
                    <li>
                        <p style="font-weight: bold;  color: #ff5733;  font-style: italic;">
                            <?php echo $eventDetail['description'] ?></p>
                    </li>
                    <li>
                        <p>Giảm giá toàn bộ sản phẩm lên đến: <?php echo $eventDetail['discount'] ?>% </p>
                    </li>
                    <?php
                    function formatEventDate($dateString)
                    {
                        // Tạo đối tượng DateTime từ chuỗi ngày tháng
                        $dateTime = new DateTime($dateString);

                        // Thiết lập ngôn ngữ và khu vực cho tiếng Việt
                        setlocale(LC_TIME, 'vi_VN');

                        // Mảng dịch tiếng Việt cho ngày
                        $days = [
                            'Sunday'    => 'Chủ Nhật',
                            'Monday'    => 'Thứ Hai',
                            'Tuesday'   => 'Thứ Ba',
                            'Wednesday' => 'Thứ Tư',
                            'Thursday'  => 'Thứ Năm',
                            'Friday'    => 'Thứ Sáu',
                            'Saturday'  => 'Thứ Bảy',
                        ];

                        // Mảng dịch tiếng Việt cho tháng
                        $months = [
                            'January'   => 'Tháng Một',
                            'February'  => 'Tháng Hai',
                            'March'     => 'Tháng Ba',
                            'April'     => 'Tháng Tư',
                            'May'       => 'Tháng Năm',
                            'June'      => 'Tháng Sáu',
                            'July'      => 'Tháng Bảy',
                            'August'    => 'Tháng Tám',
                            'September' => 'Tháng Chín',
                            'October'   => 'Tháng Mười',
                            'November'  => 'Tháng Mười Một',
                            'December'  => 'Tháng Mười Hai',
                        ];

                        $formattedDate = $days[$dateTime->format('l')] . ', ' . $dateTime->format('d') . ' ' . $months[$dateTime->format('F')] . ' ' . $dateTime->format('Y H:i:s');

                        return $formattedDate;
                    }
                    $startFormatted = formatEventDate($eventDetail['start_date']);
                    $endFormatted = formatEventDate($eventDetail['end_date']);
                    ?>
                    <li style="color: green; /* tên màu */color: rgb(0, 0, 255); color: #0000FF;">
                        Bắt đầu từ: <?php echo $startFormatted; ?>
                    </li>
                    <li style="color: blue; color: rgb(0, 0, 255); color: #0000FF; ">
                        Kết thúc lúc: <?php echo $endFormatted; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="appCard container">
        <h5 style="text-transform: uppercase; font-family: Arial, Helvetica, sans-serif;"  class="mt-2 ml-2 mb-2"> Các sản phẩm trong chương trình sự kiện:
            <span style="color: red;">
                <?php
                if (isset($eventDetail['name'])) {
                    echo $eventDetail['name'];
                }
                ?>
            </span>
        </h5>
        <ul class="product_list row">
            <?php
            while ($row_pro = mysqli_fetch_array($productByEvent)) {
                $sql_show_image = "SELECT * FROM tbl_product_image WHERE tbl_product_image.product_id = '$row_pro[id]'";
                $query_show_image = mysqli_query($connect, $sql_show_image);
                $row_image = mysqli_fetch_array($query_show_image);
            ?>

                <li class="product_item col-xs-12 col-sm-4 col-md-3 pb-6">
                    <div class="productClass br-10">
                        <a class="w-100" href="UserIndex.php?usingPage=product&id=<?php echo $row_pro['id'] ?>">
                            <div class="product-container over-hidden">
                                <?php
                                $imageSource = null;

                                if ($row_image !== null) {
                                    $imageSource = str_starts_with($row_image['content'], 'http') ? $row_image['content'] : "../../admin/pages/ProductImage/{$row_image['content']}";
                                }
                                
                                if ($imageSource === null) {
                                    $imageSource = 'https://cdn-icons-png.flaticon.com/512/4601/4601560.png';
                                }
                                
                                echo "<img src=\"{$imageSource}\" alt=\"{$row_pro['name']}\">";
                                

                                if ($eventDetail['discount'] > 0) :
                                ?>
                                    <div class="discount-overlay"><?php echo "-" . $eventDetail['discount'] . '%'; ?></div>
                                <?php endif; ?>
                            </div>

                            <h5 class="title_product pt-3"> <?php echo $row_pro['name'] ?></h5>
                            <div class="sold flex justify-between mt-2">
                                <span style="font-size: 15px;" class="ml-3">
                                    Mã sản phẩm: <?php echo $row_pro['code'] ?>
                                </span>
                            </div>
                            <div class="cdt-product-param"><span data-title="Loại Hàng"><i class="fa-solid fa-cart-arrow-down"></i> Like auth</span></div>
                            <div class="price pb-3">
                                <span style="text-decoration: line-through;" class="price_fake ml-3">
                                    <?php echo number_format($row_pro['price'] * ($eventDetail['discount'] / 100) + $row_pro['price'], 0, ',', '.') ?>
                                    đ
                                </span>
                                <span class="price_real ml-3">
                                    <?php echo number_format($row_pro['price'], 0, ',', '.') . ' đ' ?>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>
            <?php
            }
            ?>

        </ul>
        <form action="" method="GET">
            <nav class="row py-2" aria-label="Page navigation example">

                <div class="paganation-infor col py-2 ml-3">
                    <label class="mr-4">Hiển thị
                        <?php
                        $startItem = ($pageIndex - 1) * $pageSize + 1;
                        $endItem = min($pageIndex * $pageSize, $total_records);

                        echo "{$startItem} - {$endItem} trên {$total_records} kết quả";
                        ?>
                    </label>
                </div>

                <ul class="m-0 pagination justify-content-end py-2 col">
                    <li class="page-item">
                        <?php
                        if ($pageIndex > 1 && $total_page > 1) {
                            echo '<a class="page-link text-reset text-black" aria-label="Previous" href="?usingPage=event&eventId=' . ($eventId) . '&limit=' . ($pageSize) . '&page=' . ($pageIndex - 1) . '">
                        Previous
                        </a>';
                        }
                        ?>
                    </li>

                    <?php
                    $range = 3;
                    for ($i = 1; $i <= $total_page; $i++) {
                        if ($i == $pageIndex) {
                            echo '<li class="page-item light">
                        <span name="page" class="page-link text-reset text-white bg-success" href="?usingPage=event&eventId=' . ($eventId) . '&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </span>
                        </li>';
                        } else {
                            // Hiển thị trang đầu tiên
                            if ($i == 1) {
                                echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?usingPage=event&eventId=' . ($eventId) . '&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
                            </li>';
                            }
                            // Hiển thị các trang ở giữa
                            else if ($i > $pageIndex - $range && $i < $pageIndex + $range) {
                                echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?usingPage=event&eventId=' . ($eventId) . '&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
                            </li>';
                            }

                            // Hiển thị trang cuối cùng
                            else if ($i == $total_page) {
                                echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?usingPage=event&eventId=' . ($eventId) . '&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
                            </li>';
                            }

                            // Thêm dấu "..." nếu cần thiết
                            if (($i == $pageIndex - $range - 1 && $pageIndex - $range > 2) || ($i == $pageIndex + $range + 1 && $pageIndex + $range < $total_page - 1)) {
                                echo '<li class="page-item light">
                            <span class="page-link text-reset text-black"> ... </span>
                            </li>';
                            }
                        }
                    }
                    ?>

                    <?php
                    if ($pageIndex < $total_page && $total_page > 1) {
                        echo '<li class="page-item light">
                    <a name="page" class="page-link text-reset text-black" aria-label="Next" href="?usingPage=event&eventId=' . ($eventId) . '&limit=' . ($pageSize) . '&page=' . ($pageIndex + 1) . '">
                    Next
                    </a>
                    </li>';
                    }
                    ?>
                </ul>
    </nav>
    </form>
    </div>
</body>

</html>