<?php
// GET id là lấy id từ bên MENU.php 

$sql_show_test = "SELECT * FROM tbl_product INNER JOIN tbl_product_image ON tbl_product.id = tbl_product_image.product_id
WHERE tbl_product_image.main_image = 1 LIMIT 4";
$query_show_test = mysqli_query($connect, $sql_show_test);
?>

<div class="container p-0">
    <ul class="product_list row">
        <?php
        while ($row_test = mysqli_fetch_array($query_show_test)) {
            $sql_show_event = "SELECT * FROM tbl_product INNER JOIN tbl_event ON tbl_product.event_id = tbl_event.id WHERE tbl_product.id = '$row_test[product_id]'";
            $query_show_event = mysqli_query($connect, $sql_show_event);
            $row_event = mysqli_fetch_array($query_show_event);
        ?>
            <li class="col-xs-12 col-sm-4 col-md-3 pb-4">
                <div class="productClass w-100 br-10">
                    <a href="UserIndex.php?usingPage=product&id=<?php echo $row_test['product_id'] ?>">
                        <div class="product-container over-hidden">
                            <?php
                            $imageSource = str_starts_with($row_test['content'], 'http') ? $row_test['content'] : "../../admin/pages/ProductImage/{$row_test['content']}";

                            echo "<img src=\"{$imageSource}\" alt=\"{$row_test['name']}\">";

                            ?>
                        </div>

                        <h5 class="title_product mt-2"> <?php echo $row_test['name'] ?></h5>
                        <div class="sold flex justify-between mt-2">
                            <span style="font-size: 15px;" class="ml-3">
                                Mã sản phẩm: <?php echo $row_test['code'] ?>
                            </span>
                        </div>
                        <div class="cdt-product-param"><span data-title="Loại Hàng"><i class="fa-solid fa-cart-arrow-down"></i> Like auth</span></div>
                        <span style="font-size: 16px; color: #000; opacity: 0.7;" class="ml-3">
                            <?php echo number_format($row_test['price'], 0, ',', '.') . ' đ' ?>
                        </span>
                    </a>
                </div>

            </li>
        <?php
        }
        ?>
    </ul>
</div>