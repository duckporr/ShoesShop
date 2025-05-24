<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="text-center text-white">Thêm sản phẩm</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productForm" method="POST" action="pages/Product/ProductLogic.php" enctype="multipart/form-data">
                    <table border="1" width="100%" padding="10px" style="border-collapse: collapse;">
                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="name" class="form-label">Tên sản phẩm</label>
                                    <input name="name" type="text" class="form-control" id="name">
                                </div>
                                <div class="mb-2 col">
                                    <label for="code" class="form-label">Mã sản phẩm</label>
                                    <input name="code" type="text" class="form-control" id="code">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="mb-2">
                                    <label for="price" class="form-label">Giá</label>
                                    <input name="price" type="number" step="0.01" class="form-control" id="price">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="mb-2 col-6">
                                    <label for="categoryId" class="form-label">Danh mục</label>
                                    <select name="categoryId" class="form-select" aria-label="Default select example">
                                        <option value="">Chưa chọn</option>
                                        <?php
                                        $getAllCategorySql = "SELECT * FROM tbl_category";
                                        $categoryData = mysqli_query($connect, $getAllCategorySql);

                                        while ($row_danhmuc = mysqli_fetch_array($categoryData)) {
                                        ?>
                                            <option value="<?php echo $row_danhmuc['id'] ?>">
                                                <?php echo $row_danhmuc['name'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-2 col-6">
                                    <label for="eventId" class="form-label">Sự kiện</label>
                                    <select name="eventId" class="form-select" aria-label="Default select example">
                                        <option value="">Chưa chọn</option>
                                        <?php
                                        $getAllEventSql = "SELECT * FROM tbl_event";
                                        $eventData = mysqli_query($connect, $getAllEventSql);

                                        while ($row_danhmuc = mysqli_fetch_array($eventData)) {
                                        ?>
                                            <option value="<?php echo $row_danhmuc['id'] ?>">
                                                <?php echo $row_danhmuc['name'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </td>
                        </tr>

                    </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-bs-dismiss="modal">Đóng</button>

                <button type="submit" class="btn btn-primary" name="addProduct">Thêm sản phẩm</button>
            </div>
            </form>
        </div>
    </div>
</div>