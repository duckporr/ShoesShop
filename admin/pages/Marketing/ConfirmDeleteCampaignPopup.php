<!-- Confirm Delete Marketing Campaign Modal -->
<div class="modal fade" id="confirmDeleteCampaignModal_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="confirmDeleteCampaignModalLabel_<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteCampaignModalLabel_<?php echo $row['id']; ?>">XÁC NHẬN XÓA CHIẾN DỊCH</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa chiến dịch này không?
                <p class="mt-2">
                    <strong>Tên chiến dịch:</strong> <?php echo htmlspecialchars($row['campaign_name']); ?><br>
                    <strong>Kênh:</strong> <?php echo htmlspecialchars($row['channel']); ?><br>
                    <strong>Trạng thái:</strong> <?php echo htmlspecialchars($row['status']); ?>
                </p>
                <p class="text-danger">Hành động này không thể hoàn tác!</p>
            </div>
            <div class="modal-footer">
                <form action="./pages/Marketing/MarketingCampaignsLogic.php?id=<?php echo $row['id']; ?>" method="POST">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger" name="deleteCampaign">Xác Nhận Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>