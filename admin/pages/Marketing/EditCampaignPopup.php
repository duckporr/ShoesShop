<!-- Edit Marketing Campaign Modal -->
<div class="modal fade" id="editCampaignModal_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editCampaignModalLabel_<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCampaignModalLabel_<?php echo $row['id']; ?>">Chỉnh Sửa Chiến Dịch Marketing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./pages/Marketing/MarketingCampaignsLogic.php?id=<?php echo $row['id']; ?>" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="edit_campaign_name_<?php echo $row['id']; ?>" class="form-label">Tên chiến dịch <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_campaign_name_<?php echo $row['id']; ?>" name="campaign_name" value="<?php echo htmlspecialchars($row['campaign_name']); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_start_date_<?php echo $row['id']; ?>" class="form-label">Ngày bắt đầu</label>
                            <input type="date" class="form-control" id="edit_start_date_<?php echo $row['id']; ?>" name="start_date" value="<?php echo htmlspecialchars($row['start_date']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_end_date_<?php echo $row['id']; ?>" class="form-label">Ngày kết thúc</label>
                            <input type="date" class="form-control" id="edit_end_date_<?php echo $row['id']; ?>" name="end_date" value="<?php echo htmlspecialchars($row['end_date']); ?>">
                        </div>

                        <div class="col-md-12">
                            <label for="edit_objective_<?php echo $row['id']; ?>" class="form-label">Mục tiêu chiến dịch</label>
                            <textarea class="form-control" id="edit_objective_<?php echo $row['id']; ?>" name="objective" rows="2"><?php echo htmlspecialchars($row['objective']); ?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_target_audience_<?php echo $row['id']; ?>" class="form-label">Đối tượng mục tiêu</label>
                            <input type="text" class="form-control" id="edit_target_audience_<?php echo $row['id']; ?>" name="target_audience" value="<?php echo htmlspecialchars($row['target_audience']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_channel_<?php echo $row['id']; ?>" class="form-label">Kênh triển khai</label>
                            <input type="text" class="form-control" id="edit_channel_<?php echo $row['id']; ?>" name="channel" value="<?php echo htmlspecialchars($row['channel']); ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="edit_budget_<?php echo $row['id']; ?>" class="form-label">Ngân sách dự kiến (VNĐ)</label>
                            <input type="number" class="form-control" id="edit_budget_<?php echo $row['id']; ?>" name="budget" value="<?php echo htmlspecialchars($row['budget']); ?>" step="100000">
                        </div>
                        <div class="col-md-4">
                            <label for="edit_actual_cost_<?php echo $row['id']; ?>" class="form-label">Chi phí thực tế (VNĐ)</label>
                            <input type="number" class="form-control" id="edit_actual_cost_<?php echo $row['id']; ?>" name="actual_cost" value="<?php echo htmlspecialchars($row['actual_cost']); ?>" step="100000">
                        </div>
                        <div class="col-md-4">
                            <label for="edit_leads_generated_<?php echo $row['id']; ?>" class="form-label">Số Leads tạo ra</label>
                            <input type="number" class="form-control" id="edit_leads_generated_<?php echo $row['id']; ?>" name="leads_generated" value="<?php echo htmlspecialchars($row['leads_generated']); ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="edit_status_marketing_<?php echo $row['id']; ?>" class="form-label">Trạng thái</label>
                            <select class="form-select" id="edit_status_marketing_<?php echo $row['id']; ?>" name="status">
                                <option value="Planned" <?php if($row['status'] == 'Planned') echo 'selected'; ?>>Planned (Kế hoạch)</option>
                                <option value="Ongoing" <?php if($row['status'] == 'Ongoing') echo 'selected'; ?>>Ongoing (Đang chạy)</option>
                                <option value="Completed" <?php if($row['status'] == 'Completed') echo 'selected'; ?>>Completed (Hoàn thành)</option>
                                <option value="Paused" <?php if($row['status'] == 'Paused') echo 'selected'; ?>>Paused (Tạm dừng)</option>
                                <option value="Cancelled" <?php if($row['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled (Đã hủy)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_manager_<?php echo $row['id']; ?>" class="form-label">Người quản lý</label>
                            <input type="text" class="form-control" id="edit_manager_<?php echo $row['id']; ?>" name="manager" value="<?php echo htmlspecialchars($row['manager']); ?>">
                        </div>

                        <div class="col-md-12">
                            <label for="edit_notes_marketing_<?php echo $row['id']; ?>" class="form-label">Ghi chú thêm</label>
                            <textarea class="form-control" id="edit_notes_marketing_<?php echo $row['id']; ?>" name="notes" rows="3"><?php echo htmlspecialchars($row['notes']); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" name="editCampaign">Cập Nhật Chiến Dịch</button>
                </div>
            </form>
        </div>
    </div>
</div>