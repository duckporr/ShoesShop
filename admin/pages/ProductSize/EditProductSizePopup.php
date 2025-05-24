<div class="modal fade" id="editPopup_<?php echo $row['product_id']; ?>_<?php echo $row['size_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="pages/ProductSize/ProductSizeLogic.php?productId=<?php echo $row['product_id']; ?>&sizeId=<?php echo $row['size_id']; ?>" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="text-center text-white">Cập nhật kích cỡ sản phẩm <?php echo $productCode; ?></h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table border="1" width="100%" padding="10px">
                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="code" class="form-label">Mã sản phẩm</label>
                                    <input name="code" type="text" class="form-control" value="<?php echo $productCode; ?>" disabled id="code">
                                </div>
                                <div class="mb-2 col">
                                    <label for="name" class="form-label">Tên sản phẩm</label>
                                    <input name="name" type="text" class="form-control" value="<?php echo $productName; ?>" disabled id="name">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="sizeId" class="form-label">Size</label>
                                    <select name="sizeId" class="form-select" required>
                                        <?php
                                        $getAllsizeSql = "SELECT * FROM tbl_size WHERE id = '$row[size_id]' OR id NOT IN (SELECT size_id FROM tbl_product_size WHERE product_id = '$productId');";
                                        $sizeData = mysqli_query($connect, $getAllsizeSql);

                                        while ($rowSize = mysqli_fetch_array($sizeData)) {
                                            $selected = ($rowSize['id'] == $row['size_id']) ? 'selected' : '';
                                        ?>
                                            <option value="<?php echo $rowSize['id'] ?>" <?php echo $selected; ?>>
                                                <?php echo $rowSize['name'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-2 col">
                                    <label for="quantity" class="form-label">Số lượng còn</label>
                                    <input name="quantity" type="number" class="form-control" id="quantity" value="<?php echo $row['quantity'] ?>">
                                </div>
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" name="editProductSize">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>