<?php
session_start();
include "../../../common/config/Connect.php";
//XÓA HẾT GIỎ HÀNG
if (isset($_GET['deleteAll']) && $_GET['deleteAll'] == 'true') {
  unset($_SESSION['cart']);
  header('Location: ../../userCommon/UserIndex.php?usingPage=cart');
}
