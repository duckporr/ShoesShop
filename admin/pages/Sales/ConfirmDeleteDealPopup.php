<!-- Confirm Delete Sales Deal Modal -->
<div class="modal fade" id="confirmDeleteDealModal_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="confirmDeleteDealModalLabel_<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteDealModalLabel_<?php echo $row['id']; ?>">XÁC NHẬN XÓA DEAL</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa Deal/Cơ hội bán hàng này không?
                <p class="mt-2">
                    <strong>Tên Deal:</strong> <?php echo htmlspecialchars($row['deal_name']); ?><br>
                    <strong>Khách hàng:</strong> <?php echo htmlspecialchars($row['customer_name']); ?><br>
                    <strong>Giá trị:</strong> <?php echo $row['deal_value'] !== null ? number_format($row['deal_value'], 0, ',', '.') . ' VNĐ' : 'N/A'; ?>
                </p>
                <p class="text-danger">Hành động này không thể hoàn tác!</p>
            </div>
            <div class="modal-footer">
                <form action="./pages/Sales/SalesDealsLogic.php?id=<?php echo $row['id']; ?>" method="POST">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger" name="deleteDeal">Xác Nhận Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>