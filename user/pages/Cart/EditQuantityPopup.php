<?php
$show_image_sql = "SELECT * FROM tbl_product_image WHERE product_id = '$row_cart[product_id]' AND main_image = 1;";
$show_image_query = mysqli_query($connect, $show_image_sql);
$row_image = mysqli_fetch_array($show_image_query);

$show_name = "SELECT * FROM tbl_product WHERE id = '$row_cart[product_id]'";
$show_name_query = mysqli_query($connect, $show_name);
$row_name = mysqli_fetch_array($show_name_query);

$sql_details_size = "SELECT * FROM tbl_product_size INNER JOIN tbl_size
                        ON tbl_size.id = tbl_product_size.size_id
                        WHERE product_id = '$row_cart[product_id]'";
$query_details_size = mysqli_query($connect, $sql_details_size);

$sql_get_size = "SELECT * FROM tbl_product_size INNER JOIN tbl_size
                        ON tbl_size.id = tbl_product_size.size_id
                        WHERE product_id = '$row_cart[product_id]'
                        AND size_id = '$row_cart[size_id]'";
$query_get_size = mysqli_query($connect, $sql_get_size);
$row_get_size = mysqli_fetch_array($query_get_size);

$show_image_sql = "SELECT * FROM tbl_product_image WHERE product_id = '$row_cart[product_id]' AND main_image = 1;";
$show_image_query = mysqli_query($connect, $show_image_sql);
$row_image = mysqli_fetch_array($show_image_query);

?>
<div class="modal fade" id="editPopup_<?php echo $row_cart['product_id']; ?>_<?php echo $row_cart['size_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form method="POST" action="../../user/pages/Cart/CartLogic.php?productId=<?php echo $row_cart['product_id']; ?>" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="text-center text-white">
                        <i class="fa-solid fa-pencil"></i>
                        Sửa sản phẩm
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table width="100%" padding="10px" style="border-collapse: collapse;">
                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="name" class="form-label">Tên sản phẩm</label>
                                    <input disabled name="name" type="text" class="form-control" id="name" value="<?php echo $row_name['name'] ?>">
                                </div>
                                <div class="mb-2 col">
                                    <label for="code" class="form-label">Mã sản phẩm</label>
                                    <input disabled name="code" type="text" class="form-control" id="code" value="<?php echo $row_name['code'] ?>">
                                </div>
                                <div class="mb-2 col">
                                    <label for="price" class="form-label">Giá</label>
                                    <input disabled name="price" type="text" step="0.01" class="form-control" id="price" value="<?php echo number_format($row_name['price'], 0, ',', '.') . ' đ' ?>">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="product_container">
                                    <?php
                                    $imageSource = str_starts_with($row_image['content'], 'http') ? $row_image['content'] : "../../admin/pages/ProductImage/{$row_image['content']}";

                                    echo "<img style=\"width: 150px; height: 150px\" src=\"{$imageSource}\">";
                                    ?>
                                </div>
                            </td>
                        </tr>

                        <tr class="row">
                            <td class="col">
                                <div>
                                    <label for="sizeId" class="form-label">Size</label>
                                    <select name="size" class="form-select" id="size">
                                        <option selected value="<?php echo $row_get_size['size_id'] ?>"><?php echo $row_get_size['name'] ?></option>
                                        <?php
                                        // Tạo các option từ danh sách size
                                        $max = 0;
                                        while ($size_row = mysqli_fetch_array($query_details_size)) {
                                            echo "<option value=\"{$size_row['id']}\" {$selected}>{$size_row['name']}</option>";
                                            $sql_get_size_new = "SELECT * FROM tbl_product_size INNER JOIN tbl_size
                                                ON tbl_size.id = tbl_product_size.size_id
                                                WHERE product_id = '$row_cart[product_id]'
                                                AND size_id = '$size_row[id]'";
                                            $query_get_size_new = mysqli_query($connect, $sql_get_size_new);
                                            $row_get_size_new = mysqli_fetch_array($query_get_size_new); 
                                            $max = $row_get_size['quantity'];
                                        }
                                        ?>
                                    </select>
                                </div>

                            </td>
                            <td class="col">
                                <div class="mb-2 col">
                                    <label for="quantity" class="form-label">Số lượng</label>
                                    
                                    <input name="quantity" type="number" min="1" max="<?php echo $max ?>" class="form-control" id="quantity" value="<?php echo $row_cart['quantity'] ?>">

                                </div>
                            </td>

                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" name="editCart">Sửa sản phẩm</button>
                </div>
            </div>
        </form>
    </div>
</div>