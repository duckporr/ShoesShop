<link rel="stylesheet" href="./styles/SizeStyles.css">

<?php
$getAllOwningSQL = "SELECT * FROM tbl_size INNER JOIN tbl_product_size ON tbl_product_size.size_id = tbl_size.id WHERE tbl_product_size.product_id = '$row[id]';";

$tableOwningData = mysqli_query($connect, $getAllOwningSQL);
?>
<!-- Modal -->
<div class="modal fade" id="exampleModalSize_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="text-center text-white">Các size của sản phẩm (Mã SP: <?php echo $row['code'] ?>)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="w-100">
                    <thead class="table-head w-100">
                        <tr class="table-heading">
                            <th class="noWrap">STT</th>
                            <th class="noWrap">Mã kích cỡ</th>
                            <th class="noWrap">Tên kích cỡ</th>
                            <th class="noWrap">Mô tả</th>
                            <th class="noWrap">Số lượng còn</th>
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
                                    <?php echo $rowOwningData['description'] ?>
                                </td>
                                <td>
                                    <?php echo $rowOwningData['quantity'] ?>
                                </td>
                            </tr>
                        <?php
                        }
                        if (!$hasData) {
                        ?>
                            <tr>
                                <td colspan="5">
                                    <?php echo "Hiện không có kích cỡ nào!" ?>
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
                    <a class='btn btn-primary text-white productSizeButton color-white display-block h-100 w-100' href="?workingPage=productSize&productId=<?php echo $row['id']; ?>">
                        <i class="fa-solid fa-pen-to-square text-white mr-1"></i>
                        Chỉnh sửa kích cỡ sản phẩm
                    </a>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>