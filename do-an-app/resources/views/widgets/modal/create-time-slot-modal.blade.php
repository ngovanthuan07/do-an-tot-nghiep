<div class="modal fade" id="createTimeSlotModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Tạo khung giờ nhanh</h5>
            </div>

            <div class="modal-body">
                <input id="modal_start_time_slot" name="modal_start_time_slot" value="7:00" type="text" class="form-control datetimepicker-input mb-2" placeholder="Giờ bắt đầu">
                <input id="modal_end_time_slot" name="modal_end_time_slot" value="21:00" type="text" class="form-control datetimepicker-input mb-2" placeholder="Giờ kết thúc">
                <input id="modal_space_time_slot" name="modal_space_time_slot" value="60" type="number" class="form-control mb-2" placeholder="Khoảng thời gian giữa cách giờ">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i> Hủy bỏ</button>
                <button id="btnModalTimeSlot" class="btn btn-warning"><i class="fa-solid fa-folder-plus"></i>&ensp; Tạo khung giờ</button>
            </div>
        </div>
    </div>
</div>
