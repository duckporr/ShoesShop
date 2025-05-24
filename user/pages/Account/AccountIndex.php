<link rel="stylesheet" href="../styles/AccountStyles.css">

<?php
include "../../common/config/Connect.php";

$sql_user = "SELECT * FROM tbl_user WHERE id='$_SESSION[userId]'";

$query_user = mysqli_query($connect, $sql_user);
$row = mysqli_fetch_array($query_user);

if ($row['user_image']!="") {
    $userImage = $row['user_image'];
} else {
    $userImage = 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg';
}

$sql_order = "SELECT * FROM tbl_order INNER JOIN tbl_order_detail ON tbl_order.id = tbl_order_detail.order_id
WHERE tbl_order.user_id = '$_SESSION[userId]'";
$sql_order_query = mysqli_query($connect, $sql_order);
?>
<div class="appCard">
    <form method="Post" action="../../user/pages/Account/AccountLogic.php?userId=<?php echo $_SESSION['userId']; ?>"  enctype="multipart/form-data">
        <h4 class="text-left title_event">Thông tin cá nhân</h4>
        <div class="row">
            <div class="col-md-4 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="100px" <?php echo 'src=' . $imageLink . ' alt="UserImg"' ?>> <span class="font-weight-bold"><?php echo $row['username'] ?></span><span class="text-black-50">
                        <?php echo $row['email'] ?>
                    </span><span> </span></div>
            </div>
            <div class="col-md-8 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                    </div>
                    <?php if (!$row['user_image']) { ?>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="labels">Chọn ảnh đại diện mới</label>
                                <input required type="file" class="form-control" name="hinhanh" accept="image/*" onchange="displayImage(this)">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Ảnh đã chọn</label>
                                <br>
                                <img class="" id="selectedImage" style="max-width: 100%; max-height: 150px;" src="" alt="">
                            </div>
                        </div>
                        <script>
                            function displayImage(input) {
                                var file = input.files[0];
                                if (file) {
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        document.getElementById('selectedImage').src = e.target.result;
                                    };
                                    reader.readAsDataURL(file);
                                }
                            }
                        </script>
                    <?php } ?>
                    <div class="row mt-2">
                        <div class="col"><label class="labels">Tên</label><input required name="fullName" type="text" class="form-control" placeholder="Tên của bạn" value="<?php echo $row['fullname'] ?>"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Số điện thoại</label><input required name="phone" type="text" class="form-control" placeholder="Nhập số điện thoại" value="<?php if ($row['phonenumber']) {
                                                                                                                                                                                                    echo "0" . $row['phonenumber'];
                                                                                                                                                                                                } else echo "" ?>"></div>
                        <!--  -->
                        <div class="col-md-12"><label class="labels">Email</label><input required name="email" type="text" class="form-control" placeholder="Nhập email" value="<?php echo $row['email'] ?>"></div>

                        <div class="col-md-12"><label class="labels">Địa chỉ</label><input required name="address" type="text" class="form-control" placeholder="Địa chỉ" value="<?php echo $row['address'] ?>"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6"><label class="labels">Ngày sinh</label><input required name="birthDate" type="date" class="form-control" placeholder="Nhập ngày sinh của bạn" value="<?php echo $row['birthDate'] ?>"></div>
                        <div class="col-md-6">
                            <label class="labels">Giới tính</label>
                            <select name="gender" class="form-control">
                                <option value="0" <?php echo ($row['gender'] == '0') ? 'selected' : ''; ?>>Nam</option>
                                <option value="1" <?php echo ($row['gender'] == '1') ? 'selected' : ''; ?>>Nữ</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-5 text-center"><button class="btn btn-primary profile-button" name="changeInfor" type="submit">Cập nhật thông tin</button></div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="appCard">
    <h4 class="text-left title_event">Đơn hàng của bạn</h4>
    <?php if (mysqli_num_rows($sql_order_query) > 0) { ?>
        <form action="../../user/pages/Account/AccountLogic.php" method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center align-middle" scope="col">Mã đơn hàng</th>
                        <th class="text-center align-middle" scope="col">Mã</th>
                        <th scope="col">Sản phẩm</th>
                        <th class="text-center align-middle" scope="col">Tên sản phẩm</th>
                        <th class="text-center align-middle" scope="col">Size</th>
                        <th class="text-center align-middle" scope="col">Đơn giá</th>
                        <th class="text-center align-middle" scope="col">Số lượng</th>
                        <th class="text-center align-middle" scope="col">Số tiền</th>
                        <th class="text-center align-middle" scope="col">Trạng thái</th>
                        <th class="text-center align-middle" scope="col">Thao tác</th>
                    </tr>
                </thead>
                <?php
                while ($row_order = mysqli_fetch_array($sql_order_query)) {
                    $show_size_sql = "SELECT * FROM tbl_size
                    WHERE tbl_size.id = '$row_order[size_id]'";
                    $show_size_query = mysqli_query($connect, $show_size_sql);
                    $row_size = mysqli_fetch_array($show_size_query);

                    $show_image_sql = "SELECT * FROM tbl_product_image WHERE product_id = '$row_order[product_id]' AND main_image = 1;";
                    $show_image_query = mysqli_query($connect, $show_image_sql);
                    $row_image = mysqli_fetch_array($show_image_query);

                    $totalPrice = $row_order['unit_price'] * $row_order['quantity'];

                    $rowCartId = $_COOKIE['cartId'];
                    $rowProductId = $row_order['product_id'];
                    $rowSizeId = $row_order['size_id'];

                    $show_product_query = mysqli_query($connect, "SELECT * FROM tbl_product WHERE id = '$row_order[product_id]'");
                    $row_product = mysqli_fetch_array($show_product_query);

                    $show_status_query = mysqli_query($connect, "SELECT * FROM tbl_status WHERE id = '$row_order[status_id]'");
                    $row_status = mysqli_fetch_array($show_status_query);

                ?>
                    <tr>
                        <td class="text-center align-middle">
                            <?php echo $row_order['code'] ?>
                        </td>
                        <td class="text-center align-middle">
                            <?php echo $row_product['code']; ?>
                        </td>
                        <td class="text-center align-middle">
                            <a style="text-decoration: none;" href="UserIndex.php?usingPage=product&id=<?php echo $row_order['product_id'] ?>">
                                <div class="product_container flex">
                                    <?php
                                    $imageSource = str_starts_with($row_image['content'], 'http') ? $row_image['content'] : "../../admin/pages/ProductImage/{$row_image['content']}";

                                    echo "<img style=\"width: 150px; height: 150px\" src=\"{$imageSource}\">";
                                    ?>
                                </div>
                            </a>
                        </td>
                        <td style="max-width: 150px; font-size: 15px;" class="text-center align-middle">
                            <?php echo $row_product['name']; ?>
                        </td>
                        <td class="text-center align-middle">
                            <?php echo preg_replace('/\D/', '', $row_size['name']); ?>
                        </td>
                        <td class="text-center align-middle">
                            <span class="price_real">
                                <?php echo number_format($row_order['unit_price'], 0, ',', '.') . ' đ' ?>
                            </span>
                        </td>
                        <td class="text-center align-middle">
                            <?php echo $row_order['quantity'] ?>
                        </td>

                        <td class="text-center align-middle">
                            <span class="price_real" id="total_Price">
                                <?php echo number_format($totalPrice, 0, ',', '.') . ' đ' ?>
                            </span>
                        </td>
                        <td class="text-center align-middle">
                            <?php echo $row_status['name'] ?>
                        </td>
                        <td class="text-center align-middle">
                            <?php
                            if ($row_status['name'] == "Chờ xác nhận") {
                            ?>
                                <button name="cancel" type="submit" class="btn btn-danger remove-btn" data-bs-toggle="modal" data-bs-target="#confirmPopup_<?php echo $row_order['product_id']; ?>">
                                    <input type="hidden" name="order_id" value="<?php echo $row_order['order_id'] ?>">
                                    <input type="hidden" name="product_id" value="<?php echo $row_order['product_id'] ?>">
                                    <i class="fa-solid fa-trash"></i>
                                    Huỷ đơn hàng</button>
                            <?php } else { ?>
                                <button disabled name="cancel" type="submit" class="btn btn-danger remove-btn" data-bs-toggle="modal" data-bs-target="#confirmPopup_<?php echo $row_order['product_id']; ?>">
                                    <i class="fa-solid fa-trash"></i>
                                    Huỷ đơn hàng</button>
                            <?php } ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </form>
    <?php } else {
    ?>
        <div class="text-center">
            <img src="https://phongkhamdongxuan.com/assets/images/no-cart.png" alt="">
            <br>
            <span>
                Bạn chưa có đơn hàng nào, hãy quay lại mua sắm nhé!
            </span>
        </div>
    <?php
    } ?>
</div>
