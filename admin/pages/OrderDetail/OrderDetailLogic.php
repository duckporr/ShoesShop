<?php
include "../../../common/config/Connect.php";

$orderId = "";

if (isset($_POST['addOrderDetail'])) {
    $quantity = $_POST['quantity'];
    $orderId = $_GET['orderId'];
    $sizeId = $_POST['sizeId'];
    $productId = $_POST['productId'];

    echo "checking: orderId: " . $orderId . "<br>";
    echo "checking: productId: " . $productId . "<br>";
    echo "checking: sizeId: " . $sizeId . "<br>";
    echo "checking: quantity: " . $quantity . "<br>";

    //at first check a similar record is stored in database or not,
    //that means an orderProduct with the same productId, sizeId and orderId having existed in the database
    $getSimilarSQL = "SELECT * FROM tbl_order_detail WHERE order_id = '" . $orderId . "' AND product_id = '" . $productId . "' AND size_id = '" . $sizeId . "'";
    $similarRecord = mysqli_query($connect, $getSimilarSQL);
    echo "sql: " . $getSimilarSQL;
    $similarRecordCount = mysqli_num_rows($similarRecord) or 0;

    if ($similarRecordCount > 0) {
        echo "<script>alert('Đã có bản ghi với cùng sản phẩm và cùng kích cỡ được đặt trong đơn hàng!')</script>";
    } else {
        //check what sizes are exist in specific product
        $getByProductIdAndSizeIdSQL = "SELECT * FROM tbl_product_size WHERE product_id = '" . $productId . "' AND size_id = '" . $sizeId . "'";
        $productSizeRecords = mysqli_query($connect, $getByProductIdAndSizeIdSQL);
        $count = mysqli_num_rows($productSizeRecords);

        if ($count > 0) {
            $productSizeData = mysqli_fetch_array($productSizeRecords);
            $available = $productSizeData['quantity'];

            if ($available < $quantity) {
                echo "<script>alert('Số lượng hiện có không đủ, đang có sẵn: " . $available . "!')</script>";
            } else {
                //execute main logic
                $getProductSQL = "SELECT * FROM tbl_product WHERE id = '$productId'";
                $productData = mysqli_query($connect, $getProductSQL);
                $countProduct = mysqli_num_rows($productData);

                if ($countProduct > 0) {
                    $unitPrice = 0;
                    $currentProduct = mysqli_fetch_array($productData);
                    $eventId = $currentProduct['event_id'];
                    $price = $currentProduct['price'];

                    if (trim($eventId) == "") {
                        $unitPrice = $price;
                    } else {
                        //check whether a product can be discount or not
                        $getProductSQL = "SELECT * FROM tbl_event WHERE id = '$eventId'";
                        $productData = mysqli_query($connect, $getProductSQL);
                        $countEvent = mysqli_num_rows($productData);

                        if ($countEvent > 0) {
                            $currentProduct = mysqli_fetch_array($productData);
                            $discount = $currentProduct['discount'];
                            $unitPrice = $price - $price * floatval($discount / 100);
                        } else {
                            echo "<script>alert('Dữ liệu sản phẩm có sẵn khoong hợp lệ!')</>";
                        }
                    }
                    //remain quantity in database
                    $remain = $available - $quantity;

                    //update quantity in tbl_produt_size
                    $updateQuantity = "UPDATE tbl_product_size SET quantity = '$remain' WHERE product_id ='$productId' AND size_id = '$sizeId' ";
                    $query = mysqli_query($connect, $updateQuantity);

                    //add new record into order detail table
                    $addOrderDetail = "INSERT INTO tbl_order_detail(order_id, product_id, size_id, quantity, unit_price) 
                VALUES ('" . $orderId . "','" . $productId . "','" . $sizeId . "','" . $quantity .  "','" . $unitPrice . "')";
                    mysqli_query($connect, $addOrderDetail);
                } else {
                    echo "<script>alert('Dữ liệu sản phẩm có sẵn khoong hợp lệ!')</>";
                }
            }
        } else {
            echo "<script>alert('Sản phẩm không có kích cỡ phù hợp!')</script>";
        }
    }
}

function handleDeleteOrderDetail($orderId, $productId, $sizeId, $quantity)
{
    // var_dump($GLOBALS['connect']);

    //delete from tbl_order_detail
    $sqlStatement = "DELETE FROM tbl_order_detail WHERE order_id = '" . $orderId . "' AND size_id = '" . $sizeId . "' AND product_id = '" . $productId . "' AND quantity = '" . $quantity . "'";
    mysqli_query($GLOBALS['connect'], $sqlStatement);

    //retake to tbl_product_size with specific quantity
    $updateQuantity = "UPDATE tbl_product_size SET quantity = quantity + " . $quantity . " WHERE product_id = '$productId' AND size_id = '$sizeId' ";
    echo "checking update sql: " . $updateQuantity;
    mysqli_query($GLOBALS['connect'], $updateQuantity);
}

if (isset($_POST['updateOrderDetail'])) {
    //get data of old record
    $orderId = $_GET['orderId'];
    $oldProductId = $_GET['productId'];
    $oldSizeId = $_GET['sizeId'];
    $oldQuantity = $_GET['quantity'];
    echo "checking: orderId: " . $orderId . "<br>";
    echo "checking: oldProductId: " . $oldProductId . "<br>";
    echo "checking: oldSizeId: " . $oldSizeId . "<br>";
    echo "checking: oldquantity: " . $oldQuantity . "<br>";

    //new record
    $productId = $_POST['productId'];
    $sizeId = $_POST['sizeId'];
    $quantity = $_POST['quantity'];
    echo "checking: orderId: " . $orderId . "<br>";
    echo "checking: productId: " . $productId . "<br>";
    echo "checking: sizeId: " . $sizeId . "<br>";
    echo "checking: quantity: " . $quantity . "<br>";

    $getByProductIdAndSizeIdSQL = "SELECT * FROM tbl_product_size WHERE product_id = '" . $productId . "' AND size_id = '" . $sizeId . "'";
    $productSizeRecords = mysqli_query($connect, $getByProductIdAndSizeIdSQL);
    $count = mysqli_num_rows($productSizeRecords);

    if ($count > 0) {
        $productSizeData = mysqli_fetch_array($productSizeRecords);
        $available = $productSizeData['quantity'];

        if ($available < $quantity) {
            echo "<script>alert('Số lượng hiện có không đủ, đang có sẵn: " . $available . "!')</script>";
        } else {
            //execute main logic
            $getProductSQL = "SELECT * FROM tbl_product WHERE id = '$productId'";
            $productData = mysqli_query($connect, $getProductSQL);
            $countProduct = mysqli_num_rows($productData);

            if ($countProduct > 0) {
                $unitPrice = 0;
                $currentProduct = mysqli_fetch_array($productData);
                $eventId = $currentProduct['event_id'];
                $price = $currentProduct['price'];

                if (trim($eventId) == "") {
                    $unitPrice = $price;
                } else {
                    $getProductSQL = "SELECT * FROM tbl_event WHERE id = '$eventId'";
                    $productData = mysqli_query($connect, $getProductSQL);
                    $countEvent = mysqli_num_rows($productData);

                    if ($countEvent > 0) {
                        $currentProduct = mysqli_fetch_array($productData);
                        $discount = $currentProduct['discount'];
                        $unitPrice = $price - $price * floatval($discount / 100);
                    } else {
                        echo "<script>alert('Dữ liệu sản phẩm có sẵn khoong hợp lệ!')</>";
                    }
                }

                //update quantity for old product
                handleDeleteOrderDetail($orderId, $oldProductId, $oldSizeId, $oldQuantity);

                $remain = $available - $quantity;

                //update quantity in tbl_produt_size
                $updateQuantity = "UPDATE tbl_product_size SET quantity = '$remain' WHERE product_id ='$productId' AND size_id = '$sizeId' ";
                $query = mysqli_query($connect, $updateQuantity);

                //add new record into order detail table
                $addOrderDetail = "INSERT INTO tbl_order_detail(order_id, product_id, size_id, quantity, unit_price) 
                VALUES ('" . $orderId . "','" . $productId . "','" . $sizeId . "','" . $quantity .  "','" . $unitPrice . "')";

                mysqli_query($connect, $addOrderDetail);
            } else {
                echo "<script>alert('Dữ liệu sản phẩm có sẵn khoong hợp lệ!')</>";
            }
        }
    } else {
        echo "<script>alert('Sản phẩm không có kích cỡ phù hợp!')</script>";
    }
}

if (isset($_POST['deleteOrderDetail'])) {
    //get data of old record
    $orderId = $_GET['orderId'];
    $productId = $_GET['productId'];
    $sizeId = $_GET['sizeId'];
    $quantity = $_GET['quantity'];
    echo "checking: orderId: " . $orderId . "<br>";
    echo "checking: ProductId: " . $productId . "<br>";
    echo "checking: SizeId: " . $sizeId . "<br>";
    echo "checking: quantity: " . $quantity . "<br>";

    handleDeleteOrderDetail($orderId, $productId, $sizeId, $quantity);
}

header("Location: ../../AdminIndex.php?workingPage=orderDetail&orderId=" . $orderId);
