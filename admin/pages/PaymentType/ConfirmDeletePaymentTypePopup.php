<div class="modal fade" id="confirmDeletePaymentTypePopup_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="text-center text-white">XÁC NHẬN</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <form id="paymentForm" method="POST" action="pages/PaymentType/PaymentTypeLogic.php?id=<?php echo $row['id']; ?>" enctype="multipart/form-data">
                    <table border="1" width="100%" padding="10px" style="border-collapse: collapse;">
                        <p class="p-4 m-0">
                            Bạn có chắc chắn muốn xóa cách thức thanh toán này? <b><?php echo $row['name']; ?></b>
                        </p>
                    </table>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-bs-dismiss="modal">Hủy</button>

                        <button type="submit" class="btn btn-primary" name="deletePaymentType">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>