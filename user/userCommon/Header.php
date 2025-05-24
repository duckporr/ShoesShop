
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
$queryCategorySQL = "SELECT * FROM tbl_category";
$categoryData = mysqli_query($connect, $queryCategorySQL);
$keyword = "";
if (isset($_POST['search']) && isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
}

if (isset($_GET['dangxuat']) && $_GET['dangxuat'] == "true") {
    unset($_SESSION['userId']);
    if (isset($_SESSION['userImage'])) unset($_SESSION['userId']);
}

$usingPage = "";

if (isset($_GET['usingPage'])) {
    $usingPage = $_GET['usingPage'];
}

$imageLink = "";
if (isset($_SESSION['userImage'])) {
    if (str_contains($_SESSION['userImage'], "http")) {
        $imageLink = $_SESSION['userImage'];
    } else {
        $imageLink = "../../admin/pages/User/UserImages/" . $_SESSION['userImage'];
    }
}

?>
<!-- Popup xác nhận -->
<header class="header w-100">
    <div class="container flex">
        <a href="UserIndex.php">
            <img class="header__logo" style="height:70px; scale: 1.2;" src="./images/Ducklogonotbackground.png" alt="logo">
        </a>

        <div class="flex-center justify-between py-2 w-100">
            <div class="header__logo__wrapper">
            </div>

            <div class="search__input__wrapper h-100 flex-center flex-grow-1">
                <div class="category__section pr-4 h-100">
                    <div class="category__button h-100 flex-center">
                        <i class="fa-solid fa-bars"></i>
                        <p class="m-0 px-2">
                            Danh mục
                        </p>
                        <i class="fa-solid fa-sort-down pb-1"></i>

                        <div class="sub__category br-10">
                            <ul class="m-0 p-0 w-100">
                                <?php
                                while ($rowData = mysqli_fetch_array($categoryData)) {
                                ?>
                                    <li class="sub__category__item w-100">
                                        <a href="UserIndex.php?usingPage=category&categoryId=<?php echo $rowData['id'] ?>" class="w-100 p-2 py-3">
                                            <div class="sub__category__image">
                                                <img class="" src="./../../admin/pages/Category/CategoryImages/<?php echo $rowData['category_image'] ?>" alt="">
                                            </div>
                                            <div class="sub__category__name">
                                                <?php echo $rowData['name'] ?>
                                            </div>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="search__section bg-white br-10 over-hidden px-1 flex-center">
                    <form method="POST" action="UserIndex.php?usingPage=search">
                        <input class="p-2" type="text" placeholder="Tìm kiếm nhanh sản phẩm...?" name="keyword" value="<?php echo $keyword; ?>" />
                        <button type="submit" class="br-10 py-1 px-3 flex-grow-1" name="search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="cart__wrapper flex-center">
                <?php
                if (isset($_SESSION['userId'])) {
                ?>
                    <div class="user__section">

                        <div class="display-block header__btn br-10 p-2 py-1 flex align-center userAction">
                            <?php
                            if (trim($_SESSION['userImage']) == "") {
                                echo '<i class="fa-solid fa-circle-user mr-1"></i>';
                            } else {
                                echo '<img class="userLogoImage mr-1" src=' . $imageLink . ' alt="UserImg">';
                            }
                            ?>
                            <span>
                                <?php   if (isset($_SESSION['username'])) {
                                            echo "Xin chào, " . $_SESSION['username'];
                                        } else {
                                        echo "Xin chào, Khách";

                                } ?>
                            </span>

                            <div class="subUserAction br-10 over-hidden">
                                <ul class="m-0 p-0 w-100">
                                    <li class="sub__category__item w-100">
                                        <a style="display: block;" href="UserIndex.php?usingPage=cart" class="w-100 p-2 py-3" style="text-decoration: none">
                                            <i class="fa-solid fa-cart-shopping mr-2 ml-0"></i>
                                            Giỏ hàng
                                        </a>
                                    </li>
                                    <li class="sub__category__item w-100">
                                        <a style="display: block;" href="UserIndex.php?usingPage=account" class="w-100 p-2 py-3" style="text-decoration: none">
                                        <i class="fa-solid fa-list mr-2 ml-0"></i>
                                            Đơn hàng
                                        </a>
                                    </li>

                                    <li class="sub__category__item w-100 w-100 p-2 py-3" data-toggle="modal" data-target="#myModal">
                                        <i class="fa-solid fa-sign-out mr-2 ml-0"></i>
                                        Đăng xuất
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                <?php
                } else {
                ?>
                    <div class="user__section">
                        <a class="header__btn br-10 p-2 py-1 over-hidden" href="UserIndex.php?usingPage=cart">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </div>
                    <div class="user__section">
                        <a class="header__btn br-10 p-2 py-1 over-hidden" href="UserLoginSignUp.php">
                            <i class="fa-solid fa-right-to-bracket"></i>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</header>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <i class="fa-solid fa-sign-out mr-2 ml-0"></i>Đăng xuất</h4>
                <button type="button" class="btn-close btn-close-white"  data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có muốn đăng xuất không? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Đóng</button>
                <a href="UserIndex.php?dangxuat=true" class="btn btn-primary">
                    <i class="fa-solid fa-sign-out mr-2" style="padding-top: 6px; padding-bottom: 6px;"></i>Đăng xuất
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    #myModal {
        padding:  0;
    }
    #myModal .modal-header {
        background-color: #28A745;
        /* Green background color */
        color: #fff;
        /* White text color */
    }

    #myModal .btn-primary {
        background-color: red;
        /* Red background color */
        color: #fff;
        font-weight: bold;
        border: 0;
        /* White text color */
    }
    #myModal .btn-primary:hover{
        background-color: coral;
        
    }
</style>