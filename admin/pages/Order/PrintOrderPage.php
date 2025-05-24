<?php
$getAllOrderSQL = "SELECT * FROM tbl_product INNER JOIN tbl_order_detail ON tbl_order_detail.product_id = tbl_product.id WHERE tbl_order_detail.order_id = '$row[id]';";

$tableOrderData = mysqli_query($connect, $getAllOrderSQL);

date_default_timezone_set('Etc/GMT+7');
$currentDay = date('d');
$currentMonth = date('m');
$currentYear = date('Y');
?>

<div class="display-none">
    <div id="printOrder_<?php echo $row['id']; ?>">
        <div class="orderContainer display-flex" style="align-items: center; flex-direction: column;">
            <div class="headerPrintOrder flex-center justify-between" style="padding: 0px 40px;">
                <div class="logo w-300 h-300">
                    <img src="https://scontent.xx.fbcdn.net/v/t1.15752-9/385531793_665092928850659_9049026433017091781_n.jpg?stp=dst-jpg_p206x206&_nc_cat=111&ccb=1-7&_nc_sid=510075&_nc_ohc=lgHPtfIooO0AX9Lgia2&_nc_ad=z-m&_nc_cid=0&_nc_ht=scontent.xx&oh=03_AdSJ0IjzJmukql67fujDBhjSqxH66Y9EJQSe_IEKM58l9Q&oe=659C4C0D" alt="logo">
                </div>
                <div class=" storeInfo text-center">
                    <h1 style="text-align: center;">HÓA ĐƠN BÁN HÀNG</h1>
                    <h4><i class="fa-solid fa-square-phone"></i> HOTLINE: 01675984726</h4>
                    <h4><i class="fa-solid fa-location-dot"></i> 210 Lê Trọng Tấn, Thanh Xuân, Hà Nội</h4>
                    <h4></h4>
                </div>
            </div>
            <div class="bodyPrintOrder mb-20" style="font-size: 16px;">
                <div class="orderInfo">
                    <div class="flex mb-3">
                        <p style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; display: inline-block; width: 100%; margin-bottom: 5px;">
                            <strong>Mã Đơn Hàng: </strong> <?php echo $row['code'] . str_repeat(' .', 100); ?>
                        </p>
                        <p style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; display: inline-block; width: 100%; margin-bottom: 5px;" class='justify-right'>
                            <strong>Điện Thoại Nhận Hàng:</strong> <?php echo $row['receive_phone'] . str_repeat(' .', 100); ?>
                        </p>
                    </div>
                    <p style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><strong>Địa Chỉ Nhận:</strong> <?php echo $row['receive_address'] . str_repeat(' .', 100); ?></p>
                    <p><strong>Ghi chú đơn hàng:</strong> <?php echo $row['description'] . str_repeat(' .', 200 - mb_strlen($row['description'])); ?></p>
                </div>
                <div class="product-table">
                    <table border="1" class="w-100 table">
                        <thead class="table-head w-100" style="background-color: black;">
                            <tr>
                                <th class='col-1' style="text-align: center; vertical-align: middle;">STT</th>
                                <th class='col-2' style="text-align: center; vertical-align: middle;">Mã Sản Phẩm</th>
                                <th class='col-4' style="text-align: center; vertical-align: middle;">Tên Sản Phẩm</th>
                                <th class='col-1' style="text-align: center; vertical-align: middle;">Số Lượng</th>
                                <th class='col-2' style="text-align: center; vertical-align: middle;">Đơn Giá</th>
                                <th class='col-3' style="text-align: center; vertical-align: middle;">Thành Tiền</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            <?php
                            $displayOrder = 0;
                            $total = $row['delivery_cost'];
                            while ($rowOrderData = mysqli_fetch_array($tableOrderData)) {
                                $displayOrder++;
                                $total += $rowOrderData['unit_price'];
                            ?>
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <?php echo $displayOrder ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <?php echo $rowOrderData['code']; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <?php echo $rowOrderData['name']; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <?php echo $rowOrderData['quantity']; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <?php echo $rowOrderData['unit_price']; ?>
                                    </td>
                                    <td style="text-align: right; vertical-align: middle;">
                                        <?php echo ($rowOrderData['quantity'] * $rowOrderData['unit_price']) . '(VNĐ)'; ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            if ($displayOrder == 0) {
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
                <div class="fbody flex justify-between">
                    <div class="createDate text-center">
                        <p>
                            Ngày <?php echo $currentDay ?> tháng <?php echo $currentMonth ?> năm <?php echo $currentYear ?>
                        </p>
                        <p><strong>Người viết hóa đơn</strong></p>
                    </div>
                    <div class="total">
                        <p><strong>Tiền Ship:</strong> <?php echo $row['delivery_cost'] . ' (VNĐ)' ?></p>
                        <p><strong>Tổng Tiền:</strong> <?php echo $total . ' (VNĐ)' ?></p>
                    </div>
                </div>
            </div>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Whisper&display=swap" rel="stylesheet">
            <div class="footerPrintOrder text-center" style="position: fixed; bottom: 0; width: 100%; font-family: 'Whisper', cursive;">
                <h1 style="font-size: 50px; font-family: 'Whisper', cursive;"><strong>♡ Thank You ♡</strong></h1>
            </div>
        </div>
    </div>
</div>