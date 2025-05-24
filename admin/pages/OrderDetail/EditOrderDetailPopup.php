<div class="modal fade" id="editPopup_<?php echo $row['order_id']; ?>_<?php echo $row['product_id']; ?>_<?php echo $row['size_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="pages/OrderDetail/OrderDetailLogic.php?orderId=<?php echo $row['order_id']; ?>&productId=<?php echo $row['product_id']; ?>&sizeId=<?php echo $row['size_id']; ?>&quantity=<?php echo $row['quantity']; ?>" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="text-center text-white">Cập nhật sản phẩm trong đơn hàng: <?php echo $orderCode; ?></h5>

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
                                        <?php
                                        $getAllproductSql = "SELECT * FROM tbl_product WHERE id NOT IN (SELECT product_id FROM tbl_order_detail WHERE order_id = '$orderId') OR id = '" . $row['product_id'] . "';";
                                        $productData = mysqli_query($connect, $getAllproductSql);

                                        while ($rowproduct = mysqli_fetch_array($productData)) {
                                        ?>
                                            <option class="p-2" value="<?php echo $rowproduct['id'] ?>" <?php if ($row['product_id'] == $rowproduct['id']) echo "selected"; ?>>
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
                                        <?php
                                        $getAllSizeSql = "SELECT * FROM tbl_size";
                                        $sizeData = mysqli_query($connect, $getAllSizeSql);

                                        while ($rowSize = mysqli_fetch_array($sizeData)) {
                                        ?>
                                            <option class="p-2" value="<?php echo $rowSize['id'] ?>" <?php if ($sizeId == $rowSize['id']) echo "selected"; ?>>
                                                <?php echo $rowSize['name'] . ' - ' . $rowSize['code'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-2 col">
                                    <label for="quantity" class="form-label">Số lượng mua</label>
                                    <input name="quantity" type="number" class="form-control" id="quantity" value="<?php echo $row['quantity'] ?>">
                                </div>
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" name="updateOrderDetail">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>