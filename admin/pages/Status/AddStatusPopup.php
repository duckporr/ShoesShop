<!-- Modal -->
<div class="modal fade" id="addStatusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="text-center text-white">Thêm trạng thái</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="statusForm" method="POST" action="pages/Status/StatusLogic.php" enctype="multipart/form-data">
                    <table border="1" width="100%" padding="10px">
                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">Mã trạng thái</label>
                                    <input name="code" type="text" class="form-control" id="exampleFormControlInput1">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">Tên trạng thái</label>
                                    <input name="name" type="text" class="form-control" id="exampleFormControlInput1">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="exampleFormControlTextarea1" class="form-label">Mô tả</label>
                                    <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </td>
                        </tr>

                    </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary" name="addStatus">Thêm trạng thái</button>
            </div>
            </form>
        </div>
    </div>
</div>