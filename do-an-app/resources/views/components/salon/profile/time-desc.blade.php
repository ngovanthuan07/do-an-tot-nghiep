@extends('layouts.salon')
@section('title', 'Miêu tả thời gian làm việc của salon')
@section('content')
    <div id="contentApp">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Miêu tả thời gian làm việc của salon</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Tài khoản</a></li>
                            <li class="breadcrumb-item active">Miêu tả thời gian làm việc của salon</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form id="myForm">
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Miêu tả thời gian*</label>
                                            <input
                                                type="text"
                                                name="time_working_desc"
                                                value="{{$salon->time_working_desc}}"
                                                class="form-control"
                                                id="time_working_desc"
                                                placeholder="Miêu ta thời gian">
                                            <div class="invalid-feedback message-error"> </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Miêu tả khung giờ*</label>
                                            <input
                                                type="text"
                                                name="time_slot_desc"
                                                value="{{$salon->time_slot_desc}}"
                                                class="form-control"
                                                id="time_slot_desc"
                                                placeholder="Miêu tả khung giờ">
                                            <div class="invalid-feedback message-error"> </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <button type="submit" class="btn btn-primary" id="saveBtn"><i class="fa fa-save mr-1"></i>Lưu thông tin</button>
                                    </div>
                                </div>


                            </div>
                        </form>
                    </div>
                </div>


                <!-- /.card -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
@endsection
@push('modalPage')
    @include('widgets.modal.confirmation-save-modal',
        [
            'title' => 'Lưu thông tin',
            'content' => 'Bạn có muốn lưu thông tin không?'
        ])
@endpush
@push('scripts')
    <script type="module">
        import {getByProvince, getByDistrict} from '/js/common/vn-public-api.js'
        import {logFormData, serializeFormToFormData} from '/js/helper/form-helper.js'
        import {modalDispatch, handleConfirmModal} from '/js/helper/modal-helper.js'
        let formData;

        handleConfirmModal(() => {
            $.ajax({
                type: "POST",
                url: "{{route('salon.profile.time-desc-update')}}",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('input').removeClass('is-invalid')
                    $('.message-error').text('')
                },
                success: function (response) {
                    if (response.success) {
                        toastr["success"]("Cập nhật thành công");
                        modalDispatch('save', 'hide');
                    }
                },
                error: function (error) {
                    toastr["error"]("Lỗi");
                    console.log(error)
                    let arrayErrors = [];
                    $.each(error.responseJSON.errors, function (prefix, val) {
                        $('#' + prefix).addClass("is-invalid");
                        $('#' + prefix).closest('.form-group').find('.message-error').text(val);
                        arrayErrors.push(prefix);
                    })
                    $('#' + arrayErrors[0]).focus();
                }
            });
        }, 'save')


        $("#saveBtn").on("click", function(event) {
            event.preventDefault();
            formData = serializeFormToFormData('myForm')

            $.ajax({
                type: "POST",
                url: "{{route('salon.profile.validate-time-desc-update')}}",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('input').removeClass('is-invalid')
                    $('.message-error').text('')
                },
                success: function (response) {
                    if (response.success) {
                        modalDispatch('save', 'show');
                    }
                },
                error: function (error) {
                    toastr["error"]("Lỗi");
                    console.log(error)
                    let arrayErrors = [];
                    $.each(error.responseJSON.errors, function (prefix, val) {
                        $('#' + prefix).addClass("is-invalid");
                        $('#' + prefix).closest('.form-group').find('.message-error').text(val);
                        arrayErrors.push(prefix);
                    })
                    $('#' + arrayErrors[0]).focus();
                }
            });
        })
    </script>
@endpush
