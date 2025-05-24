<?php
$categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : "";

//Phân trang
$countAllSql = "SELECT * FROM tbl_product WHERE tbl_product.category_id = '$categoryId'";
$total_records = mysqli_num_rows(mysqli_query($connect, $countAllSql));

$pageIndex = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 16;

$total_page = ceil($total_records / $pageSize);

$start = ($pageIndex - 1) * $pageSize;

$findProductBycategoryIdSQL = "SELECT * FROM tbl_category WHERE tbl_category.id ='$categoryId'";
$productData = mysqli_query($connect, $findProductBycategoryIdSQL);
$categoryDetail =  mysqli_fetch_array($productData);

$findProductByCategoryIdSQL = "SELECT * FROM tbl_product WHERE tbl_product.category_id = '$categoryId'  LIMIT $start, $pageSize";
$productByCategory = mysqli_query($connect, $findProductByCategoryIdSQL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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

        .des {
            margin-bottom: 10px;
            font-size: 15px;
        }

        .title ul {
            list-style: none;
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

            if (currentPage > 1) {
                appCard1.classList.add('display-none');
                if (h5Element) {
                    h5Element.classList.add('display-none');
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy phần tử cần thay đổi màu nền
            var productContainers = document.querySelectorAll('.product-container');

            // Duyệt qua mỗi phần tử và thay đổi màu nền
            productContainers.forEach(function(container) {
                // Tạo một ảnh ẩn để lấy màu nền
                var img = new Image();
                img.src = container.querySelector('img').src;

                // Khi ảnh được tải, lấy màu và áp dụng cho phần tử
                img.onload = function() {
                    var canvas = document.createElement('canvas');
                    var context = canvas.getContext('2d');
                    context.drawImage(img, 0, 0, 1, 1);

                    var color = context.getImageData(0, 0, 1, 1).data;
                    var rgbColor = 'rgb(' + color[0] + ',' + color[1] + ',' + color[2] + ')';

                    // Áp dụng màu nền cho phần tử
                    container.style.backgroundColor = rgbColor;
                };
            });
        });
    </script>

</head>

<body>
    <div class="appCard">
        <h5 style="text-transform: uppercase; font-family: Arial, Helvetica, sans-serif;" class="enable_none mt-2 ml-2 mb-2"> Danh mục <i class="fa-solid fa-chevron-right fa-2xs"></i>
            <?php
            if (isset($categoryDetail['name'])) {
                echo $categoryDetail['name'];
            }
            ?>
        </h5>
        <div class="row m-0 ml-1">
            <div class="col-4 mb-3">
                <div class="image_category">
                    <img class="img1" src="./../../admin/pages/category/categoryImages/<?php echo $categoryDetail['category_image'] ?>" alt="">
                </div>
            </div>
            <div class="title col-8 ">
                <ul>
                    <li class="head-title">
                        <?php echo $categoryDetail['code'] . " " . $categoryDetail['name'] ?>
                    </li>
                    <li class="des">
                        <p style="font-weight: bold;  color: #ff5733;  font-style: italic;">
                            <?php echo $categoryDetail['description'] ?></p>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <div class="appCard container">
        <h5 style="text-transform: uppercase; font-family: Arial, Helvetica, sans-serif;" class="mt-2 ml-2 mb-2"> Các sản phẩm trong danh mục:
            <span style="color: red;">
                <?php
                if (isset($categoryDetail['name'])) {
                    echo $categoryDetail['name'];
                }
                ?>
            </span>
        </h5>
        <ul class="product_list row">
            <?php
            while ($row_pro = mysqli_fetch_array($productByCategory)) {
                $sql_show_image = "SELECT * FROM tbl_product_image WHERE tbl_product_image.product_id = '$row_pro[id]'";
                $query_show_image = mysqli_query($connect, $sql_show_image);
                $row_image = mysqli_fetch_array($query_show_image);

                $sql_show_event = "SELECT * FROM tbl_product INNER JOIN tbl_event ON tbl_product.event_id = tbl_event.id WHERE tbl_product.id = '$row_pro[id]'";
                $query_show_event = mysqli_query($connect, $sql_show_event);
                $row_event = mysqli_fetch_array($query_show_event);
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
                                date_default_timezone_set('Asia/Ho_Chi_Minh');
                                $currentTime = date("Y-m-d H:i:s");
                                if ($row_event['discount'] > 0 && $row_event['end_date'] > $currentTime) :
                                    ?>
                                        <div class="discount-overlay"><?php echo "-" . $row_event['discount'] . '%'; ?></div>
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
                                <?php
                                if ($row_event['end_date'] > $currentTime) {
                                ?>
                                    <span style="text-decoration: line-through;" class="price_fake ml-3">
                                        <?php echo number_format($row_pro['price'] * ($row_event['discount'] / 100) + $row_pro['price'], 0, ',', '.') ?> đ
                                    </span>
                                    <span class="price_real ml-3">
                                        <?php echo number_format($row_pro['price'], 0, ',', '.') . ' đ' ?>
                                    </span>
                                <?php } else { ?>
                                    <span style="font-size: 16px; color: #000; opacity: 0.7;" class="ml-3">
                                        <?php echo number_format($row_pro['price'], 0, ',', '.') . ' đ' ?>
                                    </span>
                                <?php } ?>
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
                            echo '<a class="page-link text-reset text-black" aria-label="Previous" href="?usingPage=category&categoryId=' . ($categoryId) . '&limit=' . ($pageSize) . '&page=' . ($pageIndex - 1) . '">
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
                        <span name="page" class="page-link text-reset text-white bg-success" href="?usingPage=category&categoryId=' . ($categoryId) . '&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </span>
                        </li>';
                        } else {
                            // Hiển thị trang đầu tiên
                            if ($i == 1) {
                                echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?usingPage=category&categoryId=' . ($categoryId) . '&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
                            </li>';
                            }
                            // Hiển thị các trang ở giữa
                            else if ($i > $pageIndex - $range && $i < $pageIndex + $range) {
                                echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?usingPage=category&categoryId=' . ($categoryId) . '&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
                            </li>';
                            }

                            // Hiển thị trang cuối cùng
                            else if ($i == $total_page) {
                                echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?usingPage=category&categoryId=' . ($categoryId) . '&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
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
                    <a name="page" class="page-link text-reset text-black" aria-label="Next" href="?usingPage=category&categoryId=' . ($categoryId) . '&limit=' . ($pageSize) . '&page=' . ($pageIndex + 1) . '">
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