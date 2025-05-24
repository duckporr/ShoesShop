<!-- Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="text-center text-white">Thêm sự kiện</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addEventForm" method="POST" action="pages/Event/EventLogic.php" enctype="multipart/form-data">
                <div class="modal-body">
                    <table border="1" width="100%" padding="10px">
                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">Tên sự kiện</label>
                                    <input name="name" type="text" class="form-control" id="exampleFormControlInput1">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">Mã sự kiện</label>
                                    <input name="code" type="text" class="form-control" id="exampleFormControlInput1">
                                </div>
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">Giảm giá</label>
                                    <input name="discount" type="text" class="form-control" id="exampleFormControlInput1">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="col-6 flex-column">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        Banner
                                    </label>
                                    <input type="file" name="banner" class="form-control" id="exampleFormControlInput1">
                                </div>
                                <div class="col-6">
                                    <img class="imageInPopup" src="pages/Event/EventImages/<?php echo $row['banner'] ?>" alt="">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="date" class="form-label">Ngày bắt đầu</label>
                                    <input name="start_date" type="datetime-local" class="form-control" id="datepicker_start">
                                </div>
                                <div class="mb-2 col">
                                    <label for="date" class="form-label">Ngày kết thúc</label>
                                    <input name="end_date" type="datetime-local" class="form-control" id="datepicker_end">
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
                    <button type="submit" class="btn btn-primary" name="addEvent">Thêm sự kiện</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$arrEventProducts = array();
$arrEventProducts["nathan"] = 20;
unset($arrEventProducts["nathan"]);
foreach ($arrEventProducts as $name => $age)
    echo $name;
?>