<div class="modal fade" id="addUserOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="text-center text-white">Thêm đơn hàng</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="categoryForm" method="POST" action="pages/UserOrderDetail/UserOrderLogic.php" enctype="multipart/form-data">
                    <table border="1" width="100%" padding="10px" style="border-collapse: collapse;">
                        <tr>
                            <td class="row">
                                <div class="mb-2 col-6">
                                    <label for="exampleFormControlInput1" class="form-label">Người đặt hàng</label>
                                    <select required name="userId" class="form-select" aria-label="Default select example">
                                        <?php
                                        $sql_user = "SELECT * FROM tbl_user where tbl_user.id =  '$userId'";
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
                            </td>
                        </tr>
                        <tr>
                            <td class="row">
                                <div class="mb-2 col-6">
                                    <label for="code" class="form-label">Mã đơn hàng</label>
                                    <input required name="code" type="text" class="form-control" id="code" value="<?php
                                                                                                                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                                                                                                    $code = '';

                                                                                                                    for ($i = 0; $i < 8; $i++) {
                                                                                                                        $code .= $characters[rand(0, strlen($characters) - 1)];
                                                                                                                    }

                                                                                                                    echo $code;
                                                                                                                    ?>">
                                </div>

                            </td>

                        </tr>
                        <tr>
                        <td>
                                <div class="mb-2 col-6">
                                    <label for="dienthoainhan" class="form-label">Điện thoại nhận hàng</label>
                                    <input required name="dienthoainhan" type="text" class="form-control" id="dienthoainhan">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="phigiaohang" class="form-label">Phí giao hàng</label>
                                    <input required name="phigiaohang" type="number" step="0.01" class="form-control" id="phigiaohang">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="diachinhan" class="form-label">Địa chỉ nhận</label>
                                    <textarea required name="diachinhan" class="form-control" id="diachinhan" rows="3"></textarea>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="mota" class="form-label">Mô tả</label>
                                    <textarea name="mota" class="form-control" id="mota" rows="3"></textarea>
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