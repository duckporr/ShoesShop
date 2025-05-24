<!-- Add Expense Modal -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseModalLabel">Thêm Chi Tiêu Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./pages/Expenses/ExpensesLogic.php" method="POST">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="add_expense_date" class="form-label">Ngày chi tiêu <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="add_expense_date" name="expense_date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-8">
                            <label for="add_description" class="form-label">Mô tả <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_description" name="description" placeholder="VD: Mua vải lụa" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="add_category" class="form-label">Danh mục</label>
                            <input type="text" class="form-control" id="add_category" name="category" placeholder="VD: Nguyên vật liệu, Marketing, Vận hành">
                        </div>
                        <div class="col-md-6">
                            <label for="add_amount" class="form-label">Số tiền (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="add_amount" name="amount" placeholder="VD: 1500000" step="1000" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="add_notes" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="add_notes" name="notes" rows="3" placeholder="Chi tiết thêm về khoản chi..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" name="addExpense">Lưu Chi Tiêu</button>
                </div>
            </form>
        </div>
    </div>
</div>