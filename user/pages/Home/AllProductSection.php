<?php
$sql_show_test = "SELECT * FROM tbl_product INNER JOIN tbl_product_image ON tbl_product.id = tbl_product_image.product_id
WHERE tbl_product_image.main_image = 1 and category_id = 'aa3166a2-6534-40a1-a1a6-cc6839cfa666' LIMIT 24";
$query_show_test = mysqli_query($connect, $sql_show_test);
?>

<div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $itemIndex = 0;
        while ($row_test = mysqli_fetch_array($query_show_test)) {
            $sql_show_event = "SELECT * FROM tbl_product INNER JOIN 
            tbl_event ON tbl_product.event_id = tbl_event.id
            INNER JOIN tbl_category ON tbl_product.category_id =  tbl_category.id 
             WHERE tbl_product.id = '$row_test[product_id]' ";
            $query_show_event = mysqli_query($connect, $sql_show_event);
            $row_event = mysqli_fetch_array($query_show_event);
        ?>

            <?php if ($itemIndex % 4 == 0) : ?>
                <div class="carousel-item <?php echo $itemIndex == 0 ? 'active' : ''; ?>">
                    <ul class="product_list row">
                    <?php endif; ?>

                    <li class="col-xs-12 col-sm-4 col-md-3 pb-4">
                        <div class="w-100 productClass br-10">
                            <a href="UserIndex.php?usingPage=product&id=<?php echo $row_test['product_id'] ?>">
                                <div class="product-container over-hidden">
                                    <?php
                                    $imageSource = str_starts_with($row_test['content'], 'http') ? $row_test['content'] : "../../admin/pages/ProductImage/{$row_test['content']}";
                                    echo "<img src=\"{$imageSource}\" alt=\"{$row_test['name']}\">";
                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                    $currentTime = date("Y-m-d H:i:s");
                                    if ($row_event['discount'] > 0 && $row_event['end_date'] > $currentTime) :
                                    ?>
                                        <div class="discount-overlay"><?php echo "-" . $row_event['discount'] . '%'; ?></div>
                                    <?php endif; ?>
                                </div>

                                <h5 class="title_product mt-2"> <?php echo $row_test['name'] ?></h5>
                                <div class="sold flex justify-between mt-2">
                                    <span style="font-size: 15px;" class="ml-3">
                                        Mã sản phẩm: <?php echo $row_test['code'] ?>
                                    </span>
                                </div>
                                <div class="cdt-product-param"><span data-title="Loại Hàng"><i class="fa-solid fa-cart-arrow-down"></i> Like auth</span></div>
                                <?php
                                if ($row_event['end_date'] > $currentTime) {
                                ?>
                                    <span style="text-decoration: line-through;" class="price_fake ml-3">
                                        <?php echo number_format($row_test['price'] * ($row_event['discount'] / 100) + $row_test['price'], 0, ',', '.') ?> đ
                                    </span>
                                    <span class="price_real ml-3">
                                        <?php echo number_format($row_test['price'], 0, ',', '.') . ' đ' ?>
                                    </span>
                                <?php } else { ?>
                                    <span style="font-size: 16px; color: #000; opacity: 0.7;" class="ml-3">
                                        <?php echo number_format($row_test['price'], 0, ',', '.') . ' đ' ?>
                                    </span>
                                <?php } ?>
                            </a>
                        </div>
                    </li>

                    <?php if ($itemIndex % 4 == 3) : ?>
                    </ul>
                </div>
            <?php endif; ?>

        <?php
            $itemIndex++;
        }
        ?>

        <?php if ($itemIndex % 4 != 0) : ?>
            </ul>
    </div>
<?php endif; ?>

</div>

<?php if ($itemIndex > 1) : ?>
    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
<?php endif; ?>
</div>
<div class="search__section bg-white br-10 over-hidden px-1 flex-center">
    <form method="POST" action="UserIndex.php?usingPage=search">
        <button type="submit" class="br-10 py-2 px-5 flex-grow-1" name="search">
            Xem tất cả
        </button>
    </form>
</div>
<style>
    .carousel-control-next, .carousel-control-prev {
    position: absolute;
    top: 0;
    bottom: 0;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 9%;
    padding: 0;
    color: #fff;
    text-align: center;
    background: 0 0;
    border: 0;
    opacity: .5;
    transition: opacity .15s ease;
}
</style>