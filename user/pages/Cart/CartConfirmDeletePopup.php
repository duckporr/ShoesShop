<?php
$show_image_sql = "SELECT * FROM tbl_product_image WHERE product_id = '$row_cart[product_id]' AND main_image = 1;";
$show_image_query = mysqli_query($connect, $show_image_sql);
$row_image = mysqli_fetch_array($show_image_query);

$show_name = "SELECT * FROM tbl_product WHERE id = '$row_cart[product_id]'";
$show_name_query = mysqli_query($connect, $show_name);
$row_name = mysqli_fetch_array($show_name_query);
?>
<div class="modal fade" id="confirmPopup_<?php echo $row_cart['product_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="text-center text-white">XÁC NHẬN</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <form method="POST" action="../../user/pages/Cart/CartLogic.php?productId=<?php echo $row_cart['product_id']; ?>" enctype="multipart/form-data">
                    <table border="1" width="100%" padding="10px" style="border-collapse: collapse;">
                        <p class="p-4 m-0">
                            Bạn có chắc chắn muốn xóa sản phẩm này?
                        </p>
                        <b class="p-4 m-0">
                            <?php echo $row_name['name'] ?>
                        </b>
                        <div class="product_container">
                            <?php
                            $imageSource = str_starts_with($row_image['content'], 'http') ? $row_image['content'] : "../../admin/pages/ProductImage/{$row_image['content']}";

                            echo "<img style=\"width: 150px; height: 150px\" src=\"{$imageSource}\">";
                            ?>
                        </div>
                    </table>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-bs-dismiss="modal">Hủy</button>

                        <button type="submit" class="btn btn-primary" name="deleteProduct">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>