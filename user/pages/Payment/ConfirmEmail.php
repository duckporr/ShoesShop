<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Booking</title>
    <style>
        /**
 * Extracted from: SweetAlert
 * Modified by: Istiak Tridip
 */
        .success-checkmark {
            width: 80px;
            height: 115px;
            margin: 0 auto;

            .check-icon {
                width: 80px;
                height: 80px;
                position: relative;
                border-radius: 50%;
                box-sizing: content-box;
                border: 4px solid #4CAF50;

                &::before {
                    top: 3px;
                    left: -2px;
                    width: 30px;
                    transform-origin: 100% 50%;
                    border-radius: 100px 0 0 100px;
                }

                &::after {
                    top: 0;
                    left: 30px;
                    width: 60px;
                    transform-origin: 0 50%;
                    border-radius: 0 100px 100px 0;
                    animation: rotate-circle 4.25s ease-in;
                }

                &::before,
                &::after {
                    content: '';
                    height: 100px;
                    position: absolute;
                    background: #FFFFFF;
                    transform: rotate(-45deg);
                }

                .icon-line {
                    height: 5px;
                    background-color: #4CAF50;
                    display: block;
                    border-radius: 2px;
                    position: absolute;
                    z-index: 10;

                    &.line-tip {
                        top: 46px;
                        left: 14px;
                        width: 25px;
                        transform: rotate(45deg);
                        animation: icon-line-tip 0.75s;
                    }

                    &.line-long {
                        top: 38px;
                        right: 8px;
                        width: 47px;
                        transform: rotate(-45deg);
                        animation: icon-line-long 0.75s;
                    }
                }

                .icon-circle {
                    top: -4px;
                    left: -4px;
                    z-index: 10;
                    width: 80px;
                    height: 80px;
                    border-radius: 50%;
                    position: absolute;
                    box-sizing: content-box;
                    border: 4px solid rgba(76, 175, 80, .5);
                }

                .icon-fix {
                    top: 8px;
                    width: 5px;
                    left: 26px;
                    z-index: 1;
                    height: 85px;
                    position: absolute;
                    transform: rotate(-45deg);
                    background-color: #FFFFFF;
                }
            }
        }

        @keyframes rotate-circle {
            0% {
                transform: rotate(-45deg);
            }

            5% {
                transform: rotate(-45deg);
            }

            12% {
                transform: rotate(-405deg);
            }

            100% {
                transform: rotate(-405deg);
            }
        }

        @keyframes icon-line-tip {
            0% {
                width: 0;
                left: 1px;
                top: 19px;
            }

            54% {
                width: 0;
                left: 1px;
                top: 19px;
            }

            70% {
                width: 50px;
                left: -8px;
                top: 37px;
            }

            84% {
                width: 17px;
                left: 21px;
                top: 48px;
            }

            100% {
                width: 25px;
                left: 14px;
                top: 45px;
            }
        }

        @keyframes icon-line-long {
            0% {
                width: 0;
                right: 46px;
                top: 54px;
            }

            65% {
                width: 0;
                right: 46px;
                top: 54px;
            }

            84% {
                width: 55px;
                right: 0px;
                top: 35px;
            }

            100% {
                width: 47px;
                right: 8px;
                top: 38px;
            }
        }
    </style>
</head>

<body>
    <div class="appCard">
        <div class="container text-center">
            <h4 class="mt-5">Gửi về mail thành công!</h4>
            <div class="success-checkmark">
                <div class="check-icon">
                    <span class="icon-line line-tip"></span>
                    <span class="icon-line line-long"></span>
                    <div class="icon-circle"></div>
                    <div class="icon-fix"></div>
                </div>
            </div>
            <p>Hoá đơn đã được gửi về email của bạn, hãy kiểm tra hòm thư nhé.</p>

            <div class="button-container">
                <a href="../../user/userCommon/UserIndex.php" class="btn btn-success mr-2"><i class="fa-solid fa-house mr-2"></i>Trang chủ</a>
                <a href="https://mail.google.com/" target="_blank" class="btn btn-primary mr-2 text-white"><i class="fa-brands fa-google mr-2"></i>Gmail</a>
            </div>
        </div>
    </div>

</body>

</html>