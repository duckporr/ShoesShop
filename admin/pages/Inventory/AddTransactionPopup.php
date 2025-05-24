<?php
// admin/pages/Inventory/AddTransactionPopup.php

// Giả sử các biến $page_w, $limit_w, $search_w đã được định nghĩa ở file gọi (InventoryTransactions.php)
// Không cần query bảng sản phẩm nữa
?>
<div class="modal fade" id="addInventoryTransactionModal" tabindex="-1" aria-labelledby="addInventoryTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInventoryTransactionModalLabel">Thêm Giao Dịch Kho Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addInventoryTransactionForm" action="./pages/Inventory/InventoryTransactionsLogic.php" method="POST">
                <input type="hidden" name="current_page_w" value="<?php echo htmlspecialchars(isset($page_w) ? $page_w : 1); ?>">
                <input type="hidden" name="current_limit_w" value="<?php echo htmlspecialchars(isset($limit_w) ? $limit_w : 10); ?>">
                <input type="hidden" name="current_search_w" value="<?php echo htmlspecialchars(isset($search_w) ? $search_w : ''); ?>">

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label for="add_inv_product_id_text" class="form-label">Product ID (Nhập tay) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_inv_product_id_text" name="product_id" placeholder="VD: SP001_RED_S, SKU12345" maxlength="50" required>
                            <small class="form-text text-muted">Nhập chính xác Product ID (tối đa 50 ký tự) sẽ được lưu trong kho.</small>
                        </div>
                        <div class="col-md-5">
                            <label for="add_inv_transaction_date" class="form-label">Ngày giờ giao dịch <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="add_inv_transaction_date" name="transaction_date" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="add_inv_transaction_type" class="form-label">Loại giao dịch <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_inv_transaction_type_no_prod" name="transaction_type" required>
                                <option value="IN">NHẬP KHO (IN)</option>
                                <option value="OUT">XUẤT KHO (OUT)</option>
                            </select>
                        </div>
                         <div class="col-md-6">
                            <label for="add_inv_quantity_no_prod" class="form-label">Số lượng <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="add_inv_quantity_no_prod" name="quantity" min="1" placeholder="VD: 10" required>
                            <small id="stock_warning_w_no_prod" class="text-danger d-none">Số lượng xuất có thể vượt quá tồn kho (kiểm tra ở server)!</small>
                        </div>

                        <div class="col-md-6">
                             <label for="add_inv_import_price_no_prod" class="form-label">Giá nhập (nếu là nhập kho)</label>
                             <input type="number" class="form-control" id="add_inv_import_price_no_prod" name="import_price" placeholder="Chỉ nhập số" step="any">
                        </div>
                        <div class="col-md-6">
                             <label for="add_inv_export_price_no_prod" class="form-label">Giá xuất (nếu là xuất kho)</label>
                             <input type="number" class="form-control" id="add_inv_export_price_no_prod" name="export_price" placeholder="Chỉ nhập số" step="any">
                        </div>

                        <div class="col-md-12">
                            <label for="add_inv_notes_no_prod" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="add_inv_notes_no_prod" name="notes" rows="2" placeholder="Chi tiết thêm..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" name="addInventoryTransaction">Lưu Giao Dịch</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Đặt tên biến script khác đi để tránh xung đột nếu có popup khác
if (typeof addInvTransModalNoProdScriptLoaded === 'undefined') {
    const addInvTransModalNoProdScriptLoaded = true;
    document.addEventListener('DOMContentLoaded', function () {
        const modalElNoProd = document.getElementById('addInventoryTransactionModal');
        if (!modalElNoProd) return;

        const transTypeSelectNoProd = modalElNoProd.querySelector('#add_inv_transaction_type_no_prod');
        const importPriceInputNoProd = modalElNoProd.querySelector('#add_inv_import_price_no_prod');
        const exportPriceInputNoProd = modalElNoProd.querySelector('#add_inv_export_price_no_prod');

        function togglePriceFieldsNoProd() {
            if (!transTypeSelectNoProd || !importPriceInputNoProd || !exportPriceInputNoProd) return;
            const type = transTypeSelectNoProd.value;
            if (type === 'IN') {
                importPriceInputNoProd.parentElement.classList.remove('d-none');
                exportPriceInputNoProd.parentElement.classList.add('d-none');
                exportPriceInputNoProd.value = '';
            } else if (type === 'OUT') {
                importPriceInputNoProd.parentElement.classList.add('d-none');
                exportPriceInputNoProd.parentElement.classList.remove('d-none');
                importPriceInputNoProd.value = '';
            } else { // Mặc định ẩn cả hai nếu không phải IN hoặc OUT
                importPriceInputNoProd.parentElement.classList.add('d-none');
                exportPriceInputNoProd.parentElement.classList.add('d-none');
            }
        }

        if(transTypeSelectNoProd) {
            transTypeSelectNoProd.addEventListener('change', togglePriceFieldsNoProd);
            togglePriceFieldsNoProd(); // Gọi lần đầu
        }
        
      
    });
}
</script>