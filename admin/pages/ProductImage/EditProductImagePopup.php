<div class="modal fade" id="editPopup_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="pages/ProductImage/ProductImageLogic.php?productId=<?php echo $row['product_id']; ?>&imageId=<?php echo $row['id'] ?>" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="text-center text-white">Cập nhật ảnh của sản phẩm <?php echo $productCode; ?></h5>

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
                            <td>
                                <div>
                                    <label for="code" class="form-label">Mô tả hình ảnh</label>
                                    <textarea name="description" class="form-control" id="description" rows="3">
                                        <?php echo $row['description']; ?>
                                    </textarea>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="col-md-6">
                                    <label for="images">Ảnh đã chọn:</label>
                                    <img style="width: 150px; height: 150px" src="pages/ProductImage/<?php echo $row['content'] ?>" alt="">
                                </div>
                                <div class="col-md-6">
                                    <label for="images">Thay thế ảnh:</label>
                                    <input type="file" name="images" id="imageInput" class="form-control" accept="image/*"><br>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="main_image">Chọn là ảnh chính:</label>
                                <input type="checkbox" name="main_image" id="main_image_checkbox" value="1">
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" name="editProductImage">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>