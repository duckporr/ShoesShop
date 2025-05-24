<?php
$keywordNew = isset($_GET['keyword']) ? $_GET['keyword'] : (isset($_POST['keyword']) ? $_POST['keyword'] : '');

//Phân trang
$countAllSql = "SELECT * FROM tbl_product WHERE tbl_product.name LIKE '%" . $keywordNew . "%'";

$total_records = mysqli_num_rows(mysqli_query($connect, $countAllSql));

$pageIndex = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 16;

$total_page = ceil($total_records / $pageSize);

$start = ($pageIndex - 1) * $pageSize;
$searchSql = "SELECT * FROM tbl_product WHERE tbl_product.name LIKE '%" . $keywordNew . "%' OR tbl_product.code LIKE '%" . $keywordNew . "%' LIMIT $start, $pageSize ";

$searchData = mysqli_query($connect, $searchSql);

?>

<h3>Từ khoá tìm kiếm : <?php echo $keywordNew; ?></h3>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="appCard container">
        <ul class="product_list mt-3 row">
            <?php
            while ($row_pro = mysqli_fetch_array($searchData)) {
                $sql_show_image = "SELECT * FROM tbl_product_image WHERE tbl_product_image.product_id = '$row_pro[id]'";
                $query_show_image = mysqli_query($connect, $sql_show_image);
                $row_image = mysqli_fetch_array($query_show_image);

                $sql_show_event = "SELECT * FROM tbl_event WHERE tbl_event.id = '$row_pro[event_id]'";
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
                            echo '<a class="page-link text-reset text-black" aria-label="Previous" href="?usingPage=search&keyword=' . ($keyword) . '&limit=' . ($pageSize) . '&page=' . ($pageIndex - 1) . '">
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
                        <span name="page" class="page-link text-reset text-white bg-success" href="?usingPage=search&keyword=' . ($keywordNew) . '&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </span>
                        </li>';
                        } else {
                            // Hiển thị trang đầu tiên
                            if ($i == 1) {
                                echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?usingPage=search&keyword=' . ($keywordNew) . '&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
                            </li>';
                            }
                            // Hiển thị các trang ở giữa
                            else if ($i > $pageIndex - $range && $i < $pageIndex + $range) {
                                echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?usingPage=search&keyword=' . ($keywordNew) . '&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
                            </li>';
                            }

                            // Hiển thị trang cuối cùng
                            else if ($i == $total_page) {
                                echo '<li class="page-item light">
                            <a name="page" class="page-link text-reset text-black" href="?usingPage=search&keyword=' . ($keywordNew) . '&limit=' . ($pageSize) . '&page=' . ($i) . '"> ' . ($i) . ' </a>
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
                    <a name="page" class="page-link text-reset text-black" aria-label="Next" href="?usingPage=search&keyword=' . ($keywordNew) . '&limit=' . ($pageSize) . '&page=' . ($pageIndex + 1) . '">
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