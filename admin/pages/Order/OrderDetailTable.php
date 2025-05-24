<link rel="stylesheet" href="./styles/SizeStyles.css">

<?php
$getAllOwningSQL = "SELECT * FROM tbl_product INNER JOIN tbl_order_detail ON tbl_order_detail.product_id = tbl_product.id WHERE tbl_order_detail.order_id = '$row[id]';";

$tableOwningData = mysqli_query($connect, $getAllOwningSQL);
?>
<!-- Modal -->
<div class="modal fade" id="orderDetail_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="text-center text-white">Các sản phẩm được đặt trong đơn hàng: <?php echo $row['code'] ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="w-100">
                    <thead class="table-head w-100">
                        <tr class="table-heading">
                            <th class="noWrap">STT</th>
                            <th class="noWrap">Mã sản phẩm</th>
                            <th class="noWrap">Tên sản phẩm</th>
                            <th class="noWrap">Số lượng</th>
                            <th class="noWrap">Đơn giá</th>
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
                                    <?php echo $rowOwningData['name'] ?>
                                </td>
                                <td>
                                    <?php echo $rowOwningData['quantity'] ?>
                                </td>
                                <td>
                                    <?php echo $rowOwningData['unit_price'] ?>
                                </td>
                            </tr>
                        <?php
                        }
                        if (!$hasData) {
                        ?>
                            <tr>
                                <td colspan="5">
                                    <?php echo "Hiện không có sản phẩm nào trong đơn hàng này!" ?>
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
                    <a class='btn btn-primary text-white productSizeButton color-white display-block h-100 w-100' href="?workingPage=orderDetail&orderId=<?php echo $row['id']; ?>">
                        <i class="fa-solid fa-pen-to-square text-white mr-1"></i>
                        Chỉnh sửa các sản phẩm của đơn hàng <?php echo $row['code']; ?>
                    </a>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>