<?php
$order_id = $_GET['orderId'];
$show_order_detail = "SELECT * FROM tbl_order_detail WHERE order_id = '$order_id'";
$show_order_detail_query = mysqli_query($connect, $show_order_detail);

$product_ids = array();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>


<form action="../../user/pages/Payment/PaymentLogic.php?userId=<?php echo $_SESSION['userId'] ?>" method="POST">
    <div class="appCard">
        <h4 class="text-center mb-4">Thông Tin Người Nhận</h4>
        <!-- Tên -->
        <div class="row">
            <div class="mb-3 col">
                <label for="name" class="form-label">Họ và Tên</label>
                <input disabled type="text" value="<?php echo $_SESSION['username']; ?>" class="form-control" id="name" name="name" required>
            </div>

            <!-- Số Điện Thoại -->
            <div class="mb-3 col">
                <label for="phone" class="form-label">Số Điện Thoại</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
        </div>

        <!-- Địa Chỉ -->
        <div class="mb-3">
            <div class="row">
                <label for="city">Địa chỉ</label>
                <div class="col">
                    <select required name="province" class="form-select form-select mb-3" id="city" aria-label=".form-select">
                        <option value="" selected>Chọn tỉnh thành</option>
                    </select>
                </div>
                <div class="col">
                    <select required name="district" class="form-select form-select mb-3" id="district" aria-label=".form-select">
                        <option value="" selected>Chọn quận huyện</option>
                    </select>
                </div>

                <div class="col">
                    <select required name="ward" class="form-select form-select" id="ward" aria-label=".form-select">
                        <option value="" selected>Chọn phường xã</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="appCard">
        <h4 class="text-center mb-4">Thông Tin Sản Phẩm</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center align-middle" scope="col">Mã</th>
                        <th scope="col">Sản phẩm</th>
                        <th class="text-center align-middle" scope="col">Tên sản phẩm</th>
                        <th class="text-center align-middle" scope="col">Size</th>
                        <th class="text-center align-middle" scope="col">Đơn giá</th>
                        <th class="text-center align-middle" scope="col">Số lượng</th>
                        <th class="text-center align-middle" scope="col">Số tiền</th>
                    </tr>
                </thead>
                <?php
                $totalAmount = 0;

                while ($row_order = mysqli_fetch_array($show_order_detail_query)) {
                    $show_image_sql = "SELECT * FROM tbl_product_image WHERE product_id = '$row_order[product_id]' AND main_image = 1;";
                    $show_image_query = mysqli_query($connect, $show_image_sql);
                    $row_image = mysqli_fetch_array($show_image_query);

                    $show_product_query = mysqli_query($connect, "SELECT * FROM tbl_product WHERE id = '$row_order[product_id]'");
                    $row_product = mysqli_fetch_array($show_product_query);

                    $show_size_sql = "SELECT * FROM tbl_size
                    WHERE tbl_size.id = '$row_order[size_id]'";
                    $show_size_query = mysqli_query($connect, $show_size_sql);
                    $row_size = mysqli_fetch_array($show_size_query);

                    $productTotal = $row_order['unit_price'] * $row_order['quantity'];
                    $totalAmount += $productTotal;

                    $product_ids[] = $row_order['product_id'];

                ?>
                    <tr>
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
                        <td class="text-center align-middle">
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
                                <?php echo number_format($productTotal, 0, ',', '.') . ' đ' ?>
                            </span>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
    </div>

    <div class="appCard">
        <h4 class="text-center mb-4">Thông Tin Thanh Toán</h3>
            <div class="row">
                <div class="mb-3 col">
                    <label for="shippingMethod">Phương thức vận chuyển</label>
                    <select class="form-select form-select mb-3" id="shippingMethod" name="delivery" aria-label=".form-select" onchange="updateTotalPayment()">
                        <option value="30000" selected>Thường (30,000 đ)</option>
                        <option value="50000">Nhanh (50,000 đ)</option>
                        <option value="100000">Hoả tốc (100,000 đ)</option>
                    </select>
                </div>
                <div class="mb-3 col">
                    <label for="paymentMethod">Phương thức thanh toán</label>
                    <?php
                    $show_payment_query = mysqli_query($connect, "SELECT * FROM tbl_payment_type");
                    ?>
                    <select class="form-select form-select mb-3" id="paymentMethod" name="paymentMethod" aria-label=".form-select">
                        <?php
                        while ($payment_option = mysqli_fetch_array($show_payment_query)) {
                            if ($payment_option['code'] == "#TM") {
                                echo "<option selected value='{$payment_option['id']}'>{$payment_option['name']}</option>";
                                continue;
                            }
                            echo "<option value='{$payment_option['id']}'>{$payment_option['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>


            <!-- Hiển thị tổng số tiền cần thanh toán -->
            <div class="infor_payment text-end">
                Tổng tiền hàng: <span class="price_real" id="totalAmountText"><?php echo number_format($totalAmount, 0, ',', '.') . ' đ'; ?></span><br>
                <span>Phí vận chuyển: <span class="price_real" id="shippingFee">0 đ</span></span><br>
                <span>Tổng thanh toán: <span class="price_real" id="totalPayment"><?php echo number_format($totalAmount, 0, ',', '.') . ' đ'; ?></span></span><br>
                <!-- Thêm trường ẩn để lưu order_id -->
                <input type="hidden" name="orderId" value="<?php echo $order_id; ?>">
                <input type="hidden" name="totalAmount" id="totalAmountInput" value="">
                <!-- Add these hidden input fields inside your form -->
                <input type="hidden" name="selectedCity" id="selectedCity" value="">
                <input type="hidden" name="selectedDistrict" id="selectedDistrict" value="">
                <input type="hidden" name="selectedWard" id="selectedWard" value="">
                <input type="hidden" name="productIds" value="<?php echo implode(',', $product_ids); ?>">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3 mb-3">
                    <!-- Back button with Font Awesome icon -->
                    <a href="javascript:history.back()" class="btn back-btn btn-outline-success">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <!-- Đặt hàng ngay button -->
                    <button name="confirmBuy" type="submit" class="btn btn-success ml-2">
                        <i class="fas fa-cart-shopping"></i> Đặt hàng ngay
                    </button>
                   
                </div>
            </div>
    </div>
</form>
<script>
    function updateTotalPayment() {
        var totalAmount = <?php echo $totalAmount; ?>;
        var shippingFee = parseInt(document.getElementById("shippingMethod").value);
        var totalPayment = totalAmount + shippingFee;

        // Hiển thị phí vận chuyển và tổng thanh toán
        document.getElementById("shippingFee").innerText = numberFormat(shippingFee) + ' đ';
        document.getElementById("totalPayment").innerText = numberFormat(totalPayment) + ' đ';

        // Cập nhật giá trị của totalAmountInput
        document.getElementById("totalAmountInput").value = totalAmount;
    }

    function numberFormat(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Gọi hàm cập nhật tổng thanh toán khi trang được tải
    window.onload = updateTotalPayment;
</script>


<!-- Sử dụng thư viện Bootstrap JS (nếu cần) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua/C68L9LOoy5YF+pc/3p0GVAfiqxFxFrQE0HqsOpI/6qJ2L+UDDUJwoA" crossorigin="anonymous"></script>
<script>
    var citis = document.getElementById("city");
    var districts = document.getElementById("district");
    var wards = document.getElementById("ward");

    var selectedCityInput = document.getElementById("selectedCity");
    var selectedDistrictInput = document.getElementById("selectedDistrict");
    var selectedWardInput = document.getElementById("selectedWard");

    var Parameter = {
        url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
        method: "GET",
        responseType: "application/json",
    };
    var promise = axios(Parameter);
    promise.then(function(result) {
        renderCity(result.data);
    });

    function renderCity(data) {
        for (const x of data) {
            citis.options[citis.options.length] = new Option(x.Name, x.Name);
        }

        citis.onchange = function() {
            // Set the value of the hidden input
            selectedCityInput.value = this.value;

            district.length = 1;
            ward.length = 1;
            if (this.value != "") {
                const result = data.filter(n => n.Name === this.value);

                for (const k of result[0].Districts) {
                    district.options[district.options.length] = new Option(k.Name, k.Name);
                }
            }
        };

        district.onchange = function() {
            // Set the value of the hidden input

            ward.length = 1;
            const dataCity = data.filter((n) => n.Name === citis.value);
            if (this.value != "") {
                const dataWards = dataCity[0].Districts.filter(n => n.Name === this.value)[0].Wards;

                for (const w of dataWards) {
                    wards.options[wards.options.length] = new Option(w.Name, w.Name);
                }
            }
            selectedDistrictInput.value = this.value;
        };

        wards.onchange = function() {
            // Set the value of the hidden input
            selectedWardInput.value = this.value;
        };
    }
</script>