<?php
// GET id là lấy id từ bên MENU.php 
$sql_show_category = "SELECT * FROM tbl_category ORDER BY name";
$query_show_category = mysqli_query($connect, $sql_show_category);
?>

<link rel="stylesheet" href="./../styles/CategorySlideStyles.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

<div class="containerCategorySlide">
    <div class="slider-wrapper">
        <button id="prev-slide" class="slide-button material-symbols-rounded">
            chevron_left
        </button>
        <div class="image-list">
            <?php
            while ($row = mysqli_fetch_array($query_show_category)) {
            ?>
                <div class="item">
                    <a href="UserIndex.php?usingPage=category&categoryId=<?php echo $row['id'] ?>">
                        <div class="card-image">
                            <img class="image-item" src="./../../admin/pages/Category/CategoryImages/<?php echo $row['category_image'] ?>" alt="img-1" />
                        </div>
                        <div class="card-content">
                            <h2 class="name"><?php echo $row['name'] ?></h2>
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>
            <button id="next-slide" class="slide-button material-symbols-rounded">
                chevron_right
            </button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        // Kích thước của mỗi item và khoảng cách giữa chúng
        var itemWidth = $(".item").outerWidth(true);
        var itemMargin = parseInt($(".item").css("margin-right"));

        // Số lượng item trên mỗi lần trượt
        var itemsPerSlide = 1;

        // Tính toán khoảng cách di chuyển
        var distanceToMove = (itemWidth + itemMargin) * itemsPerSlide;

        // Sự kiện khi nhấn nút "next"
        $("#next-slide").on("click", function() {
            // Di chuyển các item sang trái
            $(".image-list").animate({
                left: "-=" + distanceToMove
            }, 100, function() {
                // Đưa item đầu tiên về cuối nếu cần
                $(".item:lt(" + itemsPerSlide + ")").appendTo(".image-list");
                // Đặt lại vị trí left
                $(".image-list").css("left", "0");
            });
        });

        // Hàm tự động trượt
        function autoSlide() {
            // Di chuyển các item sang trái
            $(".image-list").animate({
                left: "-=" + distanceToMove
            }, 100, function() {
                // Đưa item đầu tiên về cuối nếu cần
                $(".item:lt(" + itemsPerSlide + ")").appendTo(".image-list");
                // Đặt lại vị trí left
                $(".image-list").css("left", "0");
            });
        }

        // Thiết lập tự động trượt sau 3 giây
        setTimeout(autoSlide, 3000);

        // Sự kiện khi nhấn nút "prev"
        // Số lượng item trong slider
        var totalItems = $(".item").length;

        // Sự kiện khi nhấn nút "prev"
        $("#prev-slide").on("click", function() {
            // Đưa item cuối cùng về đầu nếu cần
            $(".item:gt(" + (totalItems - itemsPerSlide - 1) + ")").prependTo(".image-list");
            // Đặt lại vị trí left để chuẩn bị di chuyển
            $(".image-list").css("left", "-" + distanceToMove + "px");
            // Di chuyển các item sang phải
            $(".image-list").animate({
                left: "+=" + distanceToMove
            }, 100);
        });

        // Dừng tự động trượt khi hover chuột vào slider
        var isHovered = false;
        var autoSlideInterval;

        $(".slider-wrapper").hover(
            function() {
                // Dừng auto-slide khi chuột hover vào slider
                isHovered = true;
                clearInterval(autoSlideInterval);
            },
            function() {
                // Khởi động lại auto-slide khi chuột rời khỏi slider
                isHovered = false;
                autoSlideInterval = setInterval(function() {
                    if (!isHovered) {
                        autoSlide();
                    }
                }, 3000);
            }
        );
    });
</script>