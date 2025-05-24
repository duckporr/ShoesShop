<!-- Add Marketing Campaign Modal -->
<div class="modal fade" id="addCampaignModal" tabindex="-1" aria-labelledby="addCampaignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCampaignModalLabel">Thêm Chiến Dịch Marketing Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./pages/Marketing/MarketingCampaignsLogic.php" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="add_campaign_name" class="form-label">Tên chiến dịch <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_campaign_name" name="campaign_name" placeholder="VD: Ra mắt BST Mùa Đông 2024" required>
                        </div>

                        <div class="col-md-6">
                            <label for="add_start_date" class="form-label">Ngày bắt đầu</label>
                            <input type="date" class="form-control" id="add_start_date" name="start_date">
                        </div>
                        <div class="col-md-6">
                            <label for="add_end_date" class="form-label">Ngày kết thúc</label>
                            <input type="date" class="form-control" id="add_end_date" name="end_date">
                        </div>

                        <div class="col-md-12">
                            <label for="add_objective" class="form-label">Mục tiêu chiến dịch</label>
                            <textarea class="form-control" id="add_objective" name="objective" rows="2" placeholder="VD: Tăng 20% nhận diện thương hiệu, đạt 500 leads..."></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="add_target_audience" class="form-label">Đối tượng mục tiêu</label>
                            <input type="text" class="form-control" id="add_target_audience" name="target_audience" placeholder="VD: Nữ, 25-40 tuổi, thu nhập A+, ở thành phố lớn">
                        </div>
                        <div class="col-md-6">
                            <label for="add_channel" class="form-label">Kênh triển khai</label>
                            <input type="text" class="form-control" id="add_channel" name="channel" placeholder="VD: Facebook Ads, Google Ads, Email, SEO, Event">
                        </div>

                        <div class="col-md-4">
                            <label for="add_budget" class="form-label">Ngân sách dự kiến (VNĐ)</label>
                            <input type="number" class="form-control" id="add_budget" name="budget" placeholder="Chỉ nhập số" step="100000">
                        </div>
                        <div class="col-md-4">
                            <label for="add_actual_cost" class="form-label">Chi phí thực tế (VNĐ)</label>
                            <input type="number" class="form-control" id="add_actual_cost" name="actual_cost" placeholder="Chỉ nhập số" step="100000">
                        </div>
                        <div class="col-md-4">
                            <label for="add_leads_generated" class="form-label">Số Leads tạo ra</label>
                            <input type="number" class="form-control" id="add_leads_generated" name="leads_generated" placeholder="Chỉ nhập số">
                        </div>

                        <div class="col-md-6">
                            <label for="add_status_marketing" class="form-label">Trạng thái</label>
                            <select class="form-select" id="add_status_marketing" name="status">
                                <option value="Planned" selected>Planned (Kế hoạch)</option>
                                <option value="Ongoing">Ongoing (Đang chạy)</option>
                                <option value="Completed">Completed (Hoàn thành)</option>
                                <option value="Paused">Paused (Tạm dừng)</option>
                                <option value="Cancelled">Cancelled (Đã hủy)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="add_manager" class="form-label">Người quản lý</label>
                            <input type="text" class="form-control" id="add_manager" name="manager" placeholder="VD: Nguyễn Văn A">
                        </div>

                        <div class="col-md-12">
                            <label for="add_notes_marketing" class="form-label">Ghi chú thêm</label>
                            <textarea class="form-control" id="add_notes_marketing" name="notes" rows="3" placeholder="Chi tiết thêm về chiến dịch..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" name="addCampaign">Lưu Chiến Dịch</button>
                </div>
            </form>
        </div>
    </div>
</div>