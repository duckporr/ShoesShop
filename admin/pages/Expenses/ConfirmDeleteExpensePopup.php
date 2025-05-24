<!-- Confirm Delete Expense Modal -->
<div class="modal fade" id="confirmDeleteExpensePopup_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="confirmDeleteExpenseModalLabel_<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteExpenseModalLabel_<?php echo $row['id']; ?>">XÁC NHẬN XÓA CHI TIÊU</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa chi tiêu này không?
                <p class="mt-2">
                    <strong>Mô tả:</strong> <?php echo htmlspecialchars($row['description']); ?><br>
                    <strong>Ngày:</strong> <?php echo date("d/m/Y", strtotime($row['expense_date'])); ?><br>
                    <strong>Số tiền:</strong> <?php echo number_format($row['amount'], 0, ',', '.'); ?> VNĐ
                </p>
            </div>
            <div class="modal-footer">
                <form action="./pages/Expenses/ExpensesLogic.php?id=<?php echo $row['id']; ?>" method="POST">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger" name="deleteExpense">Xác Nhận Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>