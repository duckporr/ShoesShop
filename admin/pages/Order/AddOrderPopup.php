<div class="modal fade" id="addOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="text-center text-white">Thêm đơn hàng</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="categoryForm" method="POST" action="pages/Order/OrderLogic.php" enctype="multipart/form-data">
                    <table border="1" width="100%" padding="10px" style="border-collapse: collapse;">
                        <tr>
                            <td class="row">
                                <div class="mb-2 col-6">
                                    <label for="exampleFormControlInput1" class="form-label">Người đặt hàng</label>
                                    <select required name="userId" class="form-select" aria-label="Default select example">
                                        <option value="">Chưa chọn</option>
                                        <?php
                                        $sql_user = "SELECT * FROM tbl_user";
                                        $query_user = mysqli_query($connect, $sql_user);
                                        while ($row_user = mysqli_fetch_array($query_user)) {
                                        ?>
                                            <option class="p-2" value="<?php echo $row_user['id'] ?>">
                                                <?php
                                                if (trim($row_user['fullname']) == "") {
                                                    echo $row_user['username'];
                                                } else {
                                                    echo $row_user['fullname'] . ' - ' . $row_user['username'];
                                                }
                                                ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-2 col-6">
                                    <label for="exampleFormControlInput1" class="form-label">Trạng thái đơn hàng</label>
                                    <select name="statusId" class="form-select" aria-label="Default select example">
                                        <option value="">Chưa chọn</option>
                                        <?php
                                        $sql_status = "SELECT * FROM tbl_status";
                                        $query_status = mysqli_query($connect, $sql_status);
                                        while ($row_status = mysqli_fetch_array($query_status)) {
                                        ?>
                                            <option class="p-2" value="<?php echo $row_status['id'] ?>">
                                                <?php echo $row_status['name'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </td>

                            <td class="row">

                                <div class="mb-2 col-6">
                                    <label for="receivePhone" class="form-label">Điện thoại nhận hàng</label>
                                    <input required name="receivePhone" type="text" class="form-control" id="receivePhone">
                                </div>

                                <div class="mb-2 col-6">
                                    <label for="transferFee" class="form-label">Phí giao hàng (VND)</label>
                                    <input required name="transferFee" type="number" step="0.01" class="form-control" id="transferFee">
                                </div>
                            </td>

                        </tr>

                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="receiveAddress" class="form-label">Địa chỉ nhận</label>
                                    <textarea required name="receiveAddress" class="form-control" id="receiveAddress" rows="3"></textarea>
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
                    </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-bs-dismiss="modal">Đóng</button>

                <button type="submit" class="btn btn-primary" name="addOrder">Thêm đơn hàng</button>
            </div>
            </form>
        </div>
    </div>
</div>