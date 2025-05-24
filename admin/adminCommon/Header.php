<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<header>
    
    <div class="px-3 bg-dark text-white">
        <div class="container px-0">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center my-lg-0 me-lg-auto text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>

                <?php
                $workingPage = '';
                $query = '';

                if (isset($_GET['workingPage'])) {
                    $workingPage = $_GET['workingPage'];
                }

                if (isset($_GET['query'])) {
                    $query = $_GET['query'];
                }

                ?>

                <?php
                function getHeaderTextColor($currentPage)
                {
                    if ($currentPage == $GLOBALS['workingPage']) echo 'text-secondary';
                    else echo 'text-white';
                }
                ?>

                <ul class="nav my-1 col-12 col-lg-auto justify-content-center my-md-0 text-small flex-middle align-items-center">
                    <li class="flex-center">
                        <a href="AdminIndex.php" class="nav-link <?php getHeaderTextColor(''); ?> flex-column flex-center">
                            <i class="fa-solid fa-house text-white mb-2 "></i>
                            Home
                        </a>
                    </li>
                    <li class="flex-center">
                        <a href="AdminIndex.php?workingPage=order" class="nav-link <?php getHeaderTextColor('order'); ?> flex-column flex-center">
                            <i class="fa-solid fa-gauge-high text-white mb-2"></i>
                            Đơn hàng
                        </a>
                    </li>
                    <li class="flex-center">
                        <a href="AdminIndex.php?workingPage=product" class="nav-link <?php getHeaderTextColor('product'); ?> flex-column flex-center">
                            <i class="fa-solid fa-table text-white mb-2"></i>
                            Sản phẩm
                        </a>
                    </li>
                    <li class="flex-center">
                        <a href="AdminIndex.php?workingPage=category" class="nav-link <?php getHeaderTextColor('category'); ?> flex-column flex-center">
                            <i class="fa-solid fa-sitemap text-white mb-2"></i>
                            Danh mục
                        </a>
                    </li>
                    <li class="flex-center">
                        <a href="AdminIndex.php?workingPage=event" class="nav-link <?php getHeaderTextColor('event'); ?> flex-column flex-center">
                            <i class="fa-solid fa-calendar-days text-white mb-2"></i>
                            Sự kiện
                        </a>
                    </li>
                    <li class="flex-center">
                        <a href="AdminIndex.php?workingPage=user" class="nav-link <?php getHeaderTextColor('user'); ?> flex-column flex-center">
                            <i class="fa-solid fa-users-gear text-white mb-2"></i>
                            Người dùng
                        </a>
                    </li>
                    <!--<li class="flex-center">
                        <a href="AdminIndex.php?workingPage=status" class="nav-link <?php getHeaderTextColor('status'); ?> flex-column flex-center">
                            <i class="fa-solid fa-toggle-off text-white mb-2"></i>
                            Trạng thái
                        </a>
                    </li>
                    <li class="flex-center">
                        <a href="AdminIndex.php?workingPage=size" class="nav-link <?php getHeaderTextColor('size'); ?> flex-column flex-center">
                            <i class="fa-solid fa-ruler-horizontal text-white mb-2"></i>
                            Kích cỡ
                        </a>
                    </li> -->
                    <li class="flex-center">
                        <a href="AdminIndex.php?workingPage=expenses" class="nav-link <?php getHeaderTextColor('expenses'); ?> flex-column flex-center">
                            <i class="fa-solid fa-comments-dollar text-white mb-2"></i>
                            Chi tiêu
                        </a>
                    </li>
                     <li class="flex-center">
                        <a href="AdminIndex.php?workingPage=marketing" class="nav-link <?php getHeaderTextColor('marketing'); ?> flex-column flex-center">
                            <i class="fa-solid fa-chart-simple text-white mb-2"></i>
                            Marketing
                        </a>
                    </li>
                     <li class="flex-center">
                        <a href="AdminIndex.php?workingPage=sales" class="nav-link <?php getHeaderTextColor('sales'); ?> flex-column flex-center">
                            <i class="fa-solid fa-sack-dollar text-white mb-2"></i>
                            Doanh Thu
                        </a>
                    </li>
                     <li class="flex-center">
                        <a href="AdminIndex.php?workingPage=inventory" class="nav-link <?php getHeaderTextColor('inventory'); ?> flex-column flex-center">
                            <i class="fa-solid fa-warehouse text-white mb-2"></i>
                            Tồn Kho
                        </a>
                    </li>
                    <li class="flex-center">
                        <a href="AdminIndex.php?workingPage=payment_type" class="nav-link <?php getHeaderTextColor('payment_type'); ?> flex-column flex-center">
                            <i class="fa-solid fa-money-check-dollar text-white mb-2"></i>
                            Thanh toán
                        </a>
                    </li>
                    <li class="flex-center">
                        <div class="text-end">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i>
                                Đăng xuất
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa-solid fa-sign-out mr-2 ml-0"></i>Đăng xuất</h4>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có muốn đăng xuất không? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-dismiss="modal">Đóng</button>
                <a href="adminCommon/Login.php" class="pr-0 nav-link text-white flex-column flex-center">
                    <div class="text-end">
                        <?php
                        if (isset($_GET['logout']) && $_GET['logout'] == 1) {
                            unset($_SESSION['userId']);
                            header('Location: ./adminCommon/Login.php');
                        }
                        ?>
                        <button type="button" class="btn btn-primary">
                            <i class="fa-solid fa-right-from-bracket mr-1"></i>
                            Đăng xuất
                        </button>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    #myModal .modal-header {
        background-color: #28A745;
        /* Green background color */
        color: #fff;
        /* White text color */
    }

    #myModal .btn-primary {
        background-color: #28A745;
        /* Red background color */
        color: #fff;
        /* White text color */
    }
    #myModal .btn-primary:hover{
        background-color: greenyellow;
        color: green;
    }
</style>