<?php
$countAllEvent = "SELECT * FROM tbl_event WHERE end_date  >= CURDATE();";
$total_event = mysqli_num_rows(mysqli_query($connect, $countAllEvent));
if ($total_event > 0) {
?>
    <div class="show_event_slide appCard p-0">
        <?php
        include("../pages/Home/EventSlides.php");
        ?>
    </div>
<?php
}
?>

<style>
    /* Additional CSS for styling the countdown units */
    .countdown-section {
        display: flex;
        justify-content: space-around;
        align-items: center;
        font-size: 13px;
    }

    .countdown-unit {
        text-align: center;
        margin: 10px;
        padding: 4px;
        border: none;
        color: #000;
    }

    .title_event {
        color: green;
        font-weight: bold;
        font-size: 20px;
        margin-left: 10px;
        margin-top: 8px;
    }
</style>

<div class="show_category_slide appCard mt-5">
    <?php
    if (isset($_GET['usingPage'])) {
        $usingPage = $_GET['usingPage'];
    } else {
        $usingPage = "";
    }
    if ($usingPage == "") {
        include("../pages/Home/CategorySlide.php");
    }
    ?>
</div>

<div class="show_new appCard">
    <?php
    if (isset($_GET['usingPage'])) {
        $usingPage = $_GET['usingPage'];
    } else {
        $usingPage = "";
    }
    if ($usingPage == "") { ?>

        <div class="new_product">
            <h4 class="title_event">SẢN PHẨM MỚI</h4>
        </div>
    <?php
        include("../pages/Home/NewProductSection.php");
    }
    ?>

</div>
<div class="show_new appCard">
    <?php
    if (isset($_GET['usingPage'])) {
        $usingPage = $_GET['usingPage'];
    } else {
        $usingPage = "";
    }
    if ($usingPage == "") { ?>

        <div class="new_product">
            <div class="row flex-center p-0 m-0" style="border-radius: 5px; background: linear-gradient(to bottom, #006400, #00FF00);">
                <div class="col-8">
                    <span class="title_event mb-4">
                        <img src="https://tyhisneaker.com/wp-content/uploads/2021/08/giasoc.svg" alt="">
                        <img src="https://tyhisneaker.com/wp-content/uploads/2021/08/homnay.svg" alt="">
                    </span>
                </div>
                <div class="col-4">
                    <!-- Add the countdown timer div -->
                    <div id="countdown" class="countdown-section">
                        <!-- Countdown timer units will be displayed here -->
                    </div>
                </div>
            </div>

            <script>
                // JavaScript code for the countdown timer
                document.addEventListener('DOMContentLoaded', function() {
                    // Set the end date for the countdown (one month from now)
                    var endDate = new Date();
                    endDate.setDate(endDate.getDate() + 1);
                    endDate.setHours(23, 59, 59);

                    function updateCountdown() {
                        var currentTime = new Date();
                        var timeDifference = endDate - currentTime;

                        // Calculate days, hours, minutes, and seconds
                        var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

                        // Display the countdown in the specified div
                        document.getElementById('countdown').innerHTML =
                            '<div class="countdown-unit btn btn-light">' + days + ' Ngày</div>' +
                            '<div class="countdown-unit btn btn-light">' + hours + ' Giờ</div>' +
                            '<div class="countdown-unit btn btn-light">' + minutes + ' Phút</div>' +
                            '<div class="countdown-unit btn btn-light">' + seconds + ' Giây</div>';

                        // Update the countdown every second
                        setTimeout(updateCountdown, 1000);
                    }

                    // Initial call to set up the countdown
                    updateCountdown();
                });
            </script>
        </div>

    <?php
        include("../pages/Home/AllProductSection.php");
    }
    ?>

</div>