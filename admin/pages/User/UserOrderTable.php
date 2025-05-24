<link rel="stylesheet" href="./styles/SizeStyles.css">
<?php
// Kiểm tra xem $row có tồn tại và không phải là null
if ($row && isset($row['id'])) {
    $getAllOwningSQL = "SELECT * FROM tbl_order WHERE tbl_order.user_id = '$row[id]';";
    // Tiếp tục xử lý
} else {
    // Xử lý khi $row không tồn tại hoặc có giá trị null
    $getAllOwningSQL = "SELECT * FROM tbl_order";
}

$tableOwningData = mysqli_query($connect, $getAllOwningSQL);
?>
<!-- Modal -->
<div class="modal fade" id="orderDetail_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="text-center text-white">Các đơn hàng của người dùng: <?php echo $row['username'] ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="w-100">
                    <thead class="table-head w-100">
                        <tr class="table-heading">
                            <th class="noWrap">STT</th>
                            <th class="noWrap">Mã đơn hàng</th>
                            <th class="noWrap">Điện thoại nhận</th>
                            <th class="noWrap">Địa chỉ nhận</th>
                            <th class="noWrap">Phí giao hàng</th>
                        </tr>
                    </thead>

                    <tbody class="table-body">
                        <?php
                        $displayOrder = 0;
                        $hasData = false;
                        while ($rowOwningData = mysqli_fetch_array($tableOwningData)) {
                            $displayOrder++;
                            $hasData = true;
                        ?>
                            <tr>
                                <td>
                                    <?php echo  $displayOrder + ($pageIndex - 1) * $pageSize; ?>
                                </td>

                                <td>
                                    <?php echo $rowOwningData['code'] ?>
                                </td>
                                <td>
                                    <?php echo $rowOwningData['receive_phone'] ?>
                                </td>
                                <td>
                                    <?php echo $rowOwningData['receive_address'] ?>
                                </td>
                                <td>
                                    <?php echo formatVND(floatval($rowOwningData['delivery_cost'])) ?>
                                </td>
                            </tr>
                        <?php
                        }
                        if (!$hasData) {
                        ?>
                            <tr>
                                <td colspan="5">
                                    <?php echo "Hiện không có đơn hàng nào của người dùng  này!" ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-bs-dismiss="modal">Đóng</button>

                <div class="col-12 col-md-6">
                    <a class='btn btn-primary text-white productSizeButton color-white display-block h-100 w-100' href="?workingPage=user_order&userId=<?php echo $row['id']; ?>">
                        <i class="fa-solid fa-pen-to-square text-white mr-1"></i>
                        Chỉnh sửa các đơn hàng của người dùng <?php echo $row['username']; ?>
                    </a>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>