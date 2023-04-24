@extends('layouts.salon')
@section('title', 'salon add')
@section('content')
    <div id="contentApp">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Thêm loại dịch vụ</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Loại dịch vụ</a></li>
                            <li class="breadcrumb-item active">Thêm loại dịch vụ</li>
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
                                            <label for="name">Tên loại dịch vụ*</label>
                                            <input
                                                type="text"
                                                name="name"
                                                class="form-control"
                                                id="name"
                                                placeholder="Tên salon">
                                            <div class="invalid-feedback message-error"> </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Tùy chọn dịch vụ*</label>
                                            <select class="form-control nice-select sort-select" name="isSelect">
                                                <option value="1">Chỉ chọn một</option>
                                                <option value="2">Cho phép chọn nhiều</option>
                                            </select>
                                            <div class="invalid-feedback message-error"> </div>
                                        </div>
                                    </div>

                                    <div class="">
                                        <button type="submit" class="btn btn-primary" id="saveBtn"><i class="fa fa-save mr-1"></i>Lưu
                                        </button>
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
        'content' => 'Bạn có muốn lưu thông tin loại dịch vụ không?'
    ])
@endpush
@push('scripts')
    <script type="module">
        import {getByProvince, getByDistrict} from '/js/common/vn-public-api.js'
        import {logFormData, serializeFormToFormData} from '/js/helper/form-helper.js'
        import {modalDispatch, handleConfirmModal} from '/js/helper/modal-helper.js'

        let formData;

        handleConfirmModal(()=> {
            $.ajax({
                type: "POST",
                url: "{{route('salon.categoryservice.store')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        modalDispatch('save', 'hide');
                        toastr['success']('Thêm thành công')
                    }
                },
                error: function (error) {
                    toastr["error"]("Lỗi");
                    console.log(error)
                }
            });
        }, 'save');

        $("#saveBtn").on("click", function(event) {
            event.preventDefault();
            formData = serializeFormToFormData('myForm')
            logFormData(formData);


            $.ajax({
                type: "POST",
                url: "{{route('salon.categoryservice.validated-category')}}",
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
