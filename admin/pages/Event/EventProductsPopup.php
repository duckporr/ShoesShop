<link rel="stylesheet" href="./styles/EventStyles.css">

<?php
$getAllEventProductsSQL = "SELECT * FROM tbl_product join tbl_product_image on tbl_product.id = tbl_product_image.product_id WHERE tbl_product_image.main_image = 1 and tbl_product.event_id = '$row[id]'; ";
$tableEventProductsData = mysqli_query($connect, $getAllEventProductsSQL);
?>
<!-- Modal -->
<div class="modal fade" id="eventProductsModal_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="text-center text-white">Các sản phẩm của sự kiện (Mã sự kiện: <?php echo $row['code'] ?>)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="w-100">
                    <thead class="table-head w-100">
                        <tr class="table-heading">
                            <th class="noWrap">STT</th>
                            <th class="noWrap">Mã sản phẩm</th>
                            <th class="noWrap">Tên sản phẩm</th>
                            <th class="noWrap">Ảnh</th>
                            <th class="noWrap">Giá</th>
                        </tr>
                    </thead>


                    <tbody class="table-body">
                        <?php
                        $displayOrder = 0;
                        $hasData = false;
                        while ($rowEventProductsData = mysqli_fetch_array($tableEventProductsData)) {
                            $displayOrder++;
                            $hasData = true;
                        ?>
                            <tr>
                                <td>
                                    <?php echo  $displayOrder ?>
                                </td>
                                <td>
                                    <?php echo $rowEventProductsData['code'] ?>
                                </td>
                                <td>
                                    <?php echo $rowEventProductsData['name'] ?>
                                </td>
                                <td>
                                    <img style="width: 150px; height: 150px" src="<?php
                                                                                    if (!str_contains($rowEventProductsData['content'], "http"))
                                                                                        echo "pages/ProductImage/" . $rowEventProductsData['content'];
                                                                                    else echo $rowEventProductsData['content'];
                                                                                    ?>" alt="">
                                </td>
                                <td>
                                    <?php echo $rowEventProductsData['price'] ?>
                                </td>
                            </tr>
                        <?php
                        }
                        if (!$hasData) {
                        ?>
                            <tr>
                                <td colspan="5">
                                    <?php echo "Chưa có dữ liệu" ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>