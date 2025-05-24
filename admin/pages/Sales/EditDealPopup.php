<!-- Edit Sales Deal Modal -->
<div class="modal fade" id="editDealModal_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editDealModalLabel_<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDealModalLabel_<?php echo $row['id']; ?>">Chỉnh Sửa Deal/Cơ Hội Bán Hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./pages/Sales/SalesDealsLogic.php?id=<?php echo $row['id']; ?>" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="edit_deal_name_sales_<?php echo $row['id']; ?>" class="form-label">Tên Deal/Cơ hội <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_deal_name_sales_<?php echo $row['id']; ?>" name="deal_name" value="<?php echo htmlspecialchars($row['deal_name']); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_customer_name_sales_<?php echo $row['id']; ?>" class="form-label">Tên khách hàng</label>
                            <input type="text" class="form-control" id="edit_customer_name_sales_<?php echo $row['id']; ?>" name="customer_name" value="<?php echo htmlspecialchars($row['customer_name']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_customer_contact_sales_<?php echo $row['id']; ?>" class="form-label">Liên hệ KH (SĐT/Email)</label>
                            <input type="text" class="form-control" id="edit_customer_contact_sales_<?php echo $row['id']; ?>" name="customer_contact" value="<?php echo htmlspecialchars($row['customer_contact']); ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="edit_deal_stage_sales_<?php echo $row['id']; ?>" class="form-label">Giai đoạn Deal <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_deal_stage_sales_<?php echo $row['id']; ?>" name="deal_stage" required>
                                <option value="Lead" <?php if($row['deal_stage'] == 'Lead') echo 'selected'; ?>>Lead (Tiềm năng)</option>
                                <option value="Contacted" <?php if($row['deal_stage'] == 'Contacted') echo 'selected'; ?>>Contacted (Đã liên hệ)</option>
                                <option value="Qualification" <?php if($row['deal_stage'] == 'Qualification') echo 'selected'; ?>>Qualification (Đánh giá)</option>
                                <option value="Proposal" <?php if($row['deal_stage'] == 'Proposal') echo 'selected'; ?>>Proposal Sent (Đã gửi báo giá)</option>
                                <option value="Negotiation" <?php if($row['deal_stage'] == 'Negotiation') echo 'selected'; ?>>Negotiation (Thương lượng)</option>
                                <option value="Won" <?php if($row['deal_stage'] == 'Won') echo 'selected'; ?>>Won (Thắng)</option>
                                <option value="Lost" <?php if($row['deal_stage'] == 'Lost') echo 'selected'; ?>>Lost (Thua)</option>
                                <option value="On Hold" <?php if($row['deal_stage'] == 'On Hold') echo 'selected'; ?>>On Hold (Tạm dừng)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_deal_value_sales_<?php echo $row['id']; ?>" class="form-label">Giá trị Deal (VNĐ)</label>
                            <input type="number" class="form-control" id="edit_deal_value_sales_<?php echo $row['id']; ?>" name="deal_value" value="<?php echo htmlspecialchars($row['deal_value']); ?>" step="100000">
                        </div>
                        <div class="col-md-4">
                            <label for="edit_probability_sales_<?php echo $row['id']; ?>" class="form-label">Xác suất chốt (%)</label>
                            <input type="number" class="form-control" id="edit_probability_sales_<?php echo $row['id']; ?>" name="probability" value="<?php echo htmlspecialchars($row['probability']); ?>" min="0" max="100">
                        </div>

                        <div class="col-md-6">
                            <label for="edit_expected_close_date_sales_<?php echo $row['id']; ?>" class="form-label">Ngày dự kiến chốt</label>
                            <input type="date" class="form-control" id="edit_expected_close_date_sales_<?php echo $row['id']; ?>" name="expected_close_date" value="<?php echo htmlspecialchars($row['expected_close_date']); ?>">
                        </div>
                         <div class="col-md-6">
                            <label for="edit_actual_close_date_sales_<?php echo $row['id']; ?>" class="form-label">Ngày chốt thực tế</label>
                            <input type="date" class="form-control" id="edit_actual_close_date_sales_<?php echo $row['id']; ?>" name="actual_close_date" value="<?php echo htmlspecialchars($row['actual_close_date']); ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="edit_sales_rep_name_sales_<?php echo $row['id']; ?>" class="form-label">Nhân viên Sales phụ trách</label>
                            <input type="text" class="form-control" id="edit_sales_rep_name_sales_<?php echo $row['id']; ?>" name="sales_rep_name" value="<?php echo htmlspecialchars($row['sales_rep_name']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_source_sales_<?php echo $row['id']; ?>" class="form-label">Nguồn Deal</label>
                            <input type="text" class="form-control" id="edit_source_sales_<?php echo $row['id']; ?>" name="source" value="<?php echo htmlspecialchars($row['source']); ?>">
                        </div>
                        
                        <div class="col-md-12">
                            <label for="edit_product_service_ids_sales_<?php echo $row['id']; ?>" class="form-label">Sản phẩm/Dịch vụ liên quan (IDs hoặc tên, cách nhau bởi dấu phẩy)</label>
                            <input type="text" class="form-control" id="edit_product_service_ids_sales_<?php echo $row['id']; ?>" name="product_service_ids" value="<?php echo htmlspecialchars($row['product_service_ids']); ?>">
                        </div>

                        <div class="col-md-12">
                            <label for="edit_notes_sales_<?php echo $row['id']; ?>" class="form-label">Ghi chú chi tiết</label>
                            <textarea class="form-control" id="edit_notes_sales_<?php echo $row['id']; ?>" name="notes" rows="3"><?php echo htmlspecialchars($row['notes']); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" name="editDeal">Cập Nhật Deal</button>
                </div>
            </form>
        </div>
    </div>
</div>