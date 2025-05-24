<!-- Edit Expense Modal -->
<div class="modal fade" id="editExpensePopup_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editExpenseModalLabel_<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editExpenseModalLabel_<?php echo $row['id']; ?>">Chỉnh Sửa Chi Tiêu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./pages/Expenses/ExpensesLogic.php?id=<?php echo $row['id']; ?>" method="POST">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="edit_expense_date_<?php echo $row['id']; ?>" class="form-label">Ngày chi tiêu <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="edit_expense_date_<?php echo $row['id']; ?>" name="expense_date" value="<?php echo htmlspecialchars($row['expense_date']); ?>" required>
                        </div>
                        <div class="col-md-8">
                            <label for="edit_description_<?php echo $row['id']; ?>" class="form-label">Mô tả <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_description_<?php echo $row['id']; ?>" name="description" value="<?php echo htmlspecialchars($row['description']); ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_category_<?php echo $row['id']; ?>" class="form-label">Danh mục</label>
                            <input type="text" class="form-control" id="edit_category_<?php echo $row['id']; ?>" name="category" value="<?php echo htmlspecialchars($row['category']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_amount_<?php echo $row['id']; ?>" class="form-label">Số tiền (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_amount_<?php echo $row['id']; ?>" name="amount" value="<?php echo htmlspecialchars($row['amount']); ?>" step="1000" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_notes_<?php echo $row['id']; ?>" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="edit_notes_<?php echo $row['id']; ?>" name="notes" rows="3"><?php echo htmlspecialchars($row['notes']); ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" name="editExpense">Cập Nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>