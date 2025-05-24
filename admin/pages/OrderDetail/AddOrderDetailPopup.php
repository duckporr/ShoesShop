<!-- Modal -->
<div class="modal fade" id="addOrderDetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="OrderDetailForm" method="POST" action="pages/OrderDetail/OrderDetailLogic.php?orderId=<?php echo $orderId; ?>" enctype="multipart/form-data">
                <div class="modal-header bg-dark">
                    <h5 class="text-center text-white">Thêm sản phẩm cho đơn hàng <?php echo $orderCode; ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table border="1" width="100%" padding="10px">
                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="code" class="form-label">Mã đơn hàng</label>
                                    <input name="orderCode" type="text" class="form-control" value="<?php echo $orderCode; ?>" disabled id="code">
                                </div>

                                <div class="mb-2 col">
                                    <label for="productId" class="form-label">Sản phẩm:</label>
                                    <select name="productId" class="form-select" required>
                                        <option class="p-2" value="">Chưa chọn</option>
                                        <?php
                                        $getAllproductSql = "SELECT * FROM tbl_product WHERE id NOT IN (SELECT product_id FROM tbl_order_detail WHERE order_id = '$orderId');";
                                        $productData = mysqli_query($connect, $getAllproductSql);

                                        while ($rowproduct = mysqli_fetch_array($productData)) {
                                        ?>
                                            <option class="p-2" value="<?php echo $rowproduct['id'] ?>">
                                                <?php echo $rowproduct['name'] . ' - ' . $rowproduct['code'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="sizeId" class="form-label">Kích cỡ:</label>
                                    <select name="sizeId" class="form-select" required>
                                        <option class="p-2" value="">Chưa chọn</option>
                                        <?php
                                        $getAllSizeSql = "SELECT * FROM tbl_size";
                                        $sizeData = mysqli_query($connect, $getAllSizeSql);

                                        while ($rowSize = mysqli_fetch_array($sizeData)) {
                                        ?>
                                            <option class="p-2" value="<?php echo $rowSize['id'] ?>">
                                                <?php echo $rowSize['name'] . ' - ' . $rowSize['code'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-2 col">
                                    <label for="quantity" class="form-label">Số lượng mua</label>
                                    <input name="quantity" type="number" class="form-control" id="quantity" value="0">
                                </div>
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" name="addOrderDetail">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>