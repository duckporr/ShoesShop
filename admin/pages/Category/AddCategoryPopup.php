<!-- Modal -->
<div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="text-center text-white">Thêm danh mục</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="categoryForm" method="POST" action="pages/Category/CategoryLogic.php" enctype="multipart/form-data">
                    <table border="1" width="100%" padding="10px" style="border-collapse: collapse;">
                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">Mã danh mục</label>
                                    <input name="code" type="text" class="form-control" id="exampleFormControlInput1">
                                </div>
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">Tên danh mục</label>
                                    <input name="tendanhmuc" type="text" class="form-control" id="exampleFormControlInput1">
                                </div>

                                <label for="exampleFormControlInput1" class="form-label">Hình ảnh</label>
                                <div class="input-group mb-2">
                                    <input name="hinhanh" type="file" class="form-control" id="inputGroupFile02">
                                </div>
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">Mô tả</label>
                                    <input name="description" type="text" class="form-control" id="exampleFormControlInput1">
                                </div>

                            </td>

                        </tr>

                    </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-bs-dismiss="modal">Đóng</button>

                <button type="submit" class="btn btn-primary" name="themdanhmuc">Thêm danh mục</button>
            </div>
            </form>
        </div>
    </div>
</div>