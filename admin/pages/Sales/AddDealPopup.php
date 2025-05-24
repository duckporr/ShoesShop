<!-- Add Sales Deal Modal -->
<div class="modal fade" id="addDealModal" tabindex="-1" aria-labelledby="addDealModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDealModalLabel">Thêm Deal/Cơ Hội Bán Hàng Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./pages/Sales/SalesDealsLogic.php" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="add_deal_name_sales" class="form-label">Tên Deal/Cơ hội <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_deal_name_sales" name="deal_name" placeholder="VD: Hợp đồng cung cấp 100 áo thun cho công ty ABC" required>
                        </div>

                        <div class="col-md-6">
                            <label for="add_customer_name_sales" class="form-label">Tên khách hàng</label>
                            <input type="text" class="form-control" id="add_customer_name_sales" name="customer_name" placeholder="VD: Công ty TNHH ABC">
                        </div>
                        <div class="col-md-6">
                            <label for="add_customer_contact_sales" class="form-label">Liên hệ KH (SĐT/Email)</label>
                            <input type="text" class="form-control" id="add_customer_contact_sales" name="customer_contact" placeholder="VD: 090xxxxxxx hoặc contact@abc.com">
                        </div>

                        <div class="col-md-4">
                            <label for="add_deal_stage_sales" class="form-label">Giai đoạn Deal <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_deal_stage_sales" name="deal_stage" required>
                                <option value="Lead" selected>Lead (Tiềm năng)</option>
                                <option value="Contacted">Contacted (Đã liên hệ)</option>
                                <option value="Qualification">Qualification (Đánh giá)</option>
                                <option value="Proposal">Proposal Sent (Đã gửi báo giá)</option>
                                <option value="Negotiation">Negotiation (Thương lượng)</option>
                                <option value="Won">Won (Thắng)</option>
                                <option value="Lost">Lost (Thua)</option>
                                <option value="On Hold">On Hold (Tạm dừng)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="add_deal_value_sales" class="form-label">Giá trị Deal (VNĐ)</label>
                            <input type="number" class="form-control" id="add_deal_value_sales" name="deal_value" placeholder="Chỉ nhập số" step="100000">
                        </div>
                        <div class="col-md-4">
                            <label for="add_probability_sales" class="form-label">Xác suất chốt (%)</label>
                            <input type="number" class="form-control" id="add_probability_sales" name="probability" min="0" max="100" placeholder="0-100">
                        </div>

                        <div class="col-md-6">
                            <label for="add_expected_close_date_sales" class="form-label">Ngày dự kiến chốt</label>
                            <input type="date" class="form-control" id="add_expected_close_date_sales" name="expected_close_date">
                        </div>
                         <div class="col-md-6">
                            <label for="add_actual_close_date_sales" class="form-label">Ngày chốt thực tế</label>
                            <input type="date" class="form-control" id="add_actual_close_date_sales" name="actual_close_date">
                        </div>

                        <div class="col-md-6">
                            <label for="add_sales_rep_name_sales" class="form-label">Nhân viên Sales phụ trách</label>
                            <input type="text" class="form-control" id="add_sales_rep_name_sales" name="sales_rep_name" placeholder="VD: Nguyễn Văn B">
                        </div>
                        <div class="col-md-6">
                            <label for="add_source_sales" class="form-label">Nguồn Deal</label>
                            <input type="text" class="form-control" id="add_source_sales" name="source" placeholder="VD: Marketing Campaign, Referral, Cold Call...">
                        </div>
                        
                        <div class="col-md-12">
                            <label for="add_product_service_ids_sales" class="form-label">Sản phẩm/Dịch vụ liên quan (IDs hoặc tên, cách nhau bởi dấu phẩy)</label>
                            <input type="text" class="form-control" id="add_product_service_ids_sales" name="product_service_ids" placeholder="VD: SP001, DV003, Áo Thun XYZ...">
                        </div>

                        <div class="col-md-12">
                            <label for="add_notes_sales" class="form-label">Ghi chú chi tiết</label>
                            <textarea class="form-control" id="add_notes_sales" name="notes" rows="3" placeholder="Chi tiết về deal, yêu cầu của khách hàng..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" name="addDeal">Lưu Deal</button>
                </div>
            </form>
        </div>
    </div>
</div>