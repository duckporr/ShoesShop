<div class="modal fade" id="editCategory<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="pages/Category/CategoryLogic.php?categoryId=<?php echo $row['id']; ?>" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="text-center text-white">Sửa danh mục</h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table border="1" width="100%" style="border-collapse: collapse;">

                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        Tên danh mục
                                    </label>
                                    <input type="text" value="<?php echo $row['name'] ?>" name="tendanhmuc" class="form-control" id="exampleFormControlInput1">

                                </div>
                                
                            </td>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        Mã danh mục
                                    </label>
                                    <input type="text" value="<?php echo $row['code'] ?>" name="code" class="form-control" id="exampleFormControlInput1">

                                </div>
                                
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="col-6">
                                    <img class="w-100" src="pages/Category/CategoryImages/<?php echo $row['category_image'] ?>">
                                </div>

                                <div class="col-6 flex-center flex-column">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        Hình ảnh
                                    </label>
                                    <input type="file" name="hinhanh" class="form-control" id="exampleFormControlInput1">
                                </div>
                            </td>
                            
                        </tr>


                        <tr>
                            <td class="row">
                               
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        Mô tả
                                    </label>
                                    <input type="text" name="description" value="<?php echo $row['description'] ?>" class="form-control" id="exampleFormControlInput1">
                                </div>
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" name="suadanhmuc">Sửa danh mục</button>
                </div>
            </div>
        </form>
    </div>
</div>