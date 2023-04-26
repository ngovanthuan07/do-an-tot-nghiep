@extends('layouts.salon')
@section('title', 'salon add')
@section('content')
    <div id="contentApp">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Thêm nhân viên</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Nhân viên</a></li>
                            <li class="breadcrumb-item active">Thêm nhân viên</li>
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
                            <input type="hidden" id="status" name="status" value="ON" id="status">
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Tên nhân viên*</label>
                                            <input
                                                type="text"
                                                name="fullname"
                                                class="form-control"
                                                id="fullname"
                                                placeholder="Tên nhân viên">
                                            <div class="invalid-feedback message-error"> </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Số điện thoại*</label>
                                            <input
                                                type="text"
                                                name="phone"
                                                class="form-control"
                                                id="phone"
                                                placeholder="Số điện thoại">
                                            <div class="invalid-feedback message-error"> </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Ngày sinh*</label>
                                            <input
                                                type="date"
                                                name="dob"
                                                class="form-control"
                                                value="1997-01-01"
                                                id="dob"
                                                placeholder="Ngày sinh*">
                                            <div class="invalid-feedback message-error"> </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Chứng minh nhân dân / Căn cước công dân*</label>
                                            <input
                                                type="text"
                                                name="cic"
                                                class="form-control"
                                                id="cic"
                                                placeholder="Chứng minh nhân dân / Căn cước công dân">
                                            <div class="invalid-feedback message-error"> </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Giời tính*</label>
                                            <select class="form-control nice-select sort-select" name="gender" id="gender">
                                                <option value="">-- CHỌN GIỚI TÍNH --</option>
                                                <option value="1">Nam</option>
                                                <option value="0">Nữ</option>
                                            </select>
                                            <div class="invalid-feedback message-error"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Miêu tả*</label>
                                            <textarea class="form-control" name="description" rows="10" placeholder="Miêu tả"></textarea>
                                            <div class="invalid-feedback message-error"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Hình ảnh*</label>&emsp;
                                            <button id="btnImage" class="btn-sm btn-success float-right"><i class="fa-solid fa-upload"></i> Upload File</button>
                                            <input type="file" id="file" style="display:none">
                                            <div id="service-picture-container">
                                                <img id="service-picture" src="">
                                            </div>

                                            <div class="invalid-feedback message-error"></div>
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
@push('styles')
    <style>
        #service-picture-container{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 30%;
            height: 200px;
            border-radius: 5px;
            border: 2px solid #f0f1f3;
            background-color: white;
        }
        #service-picture{
            width: 100%;
            height: 100%;
            border-radius: 5px;
            object-fit: cover;
        }
    </style>
@endpush
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
        let file = '';

        handleConfirmModal(()=> {
            $.ajax({
                type: "POST",
                url: "{{route('salon.employee.store')}}",
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

        $("#btnImage").on("click", function (event) {
            event.preventDefault();
            // Kích hoạt việc chọn file trên input file
            document.getElementById("file").click();
        });
        $("#file").on("change", function () {
            // Sử dụng FileReader để đọc dữ liệu của file được chọn
            let reader = new FileReader();
            reader.onload = function() {
                // Gán nội dung dữ liệu file vào thuộc tính "src" của thẻ img
                document.getElementById("service-picture").src = reader.result;
            };
            // Đọc dữ liệu của file
            file = event.target.files[0];
            reader.readAsDataURL(event.target.files[0]);
        })

        $("#saveBtn").on("click", function(event) {
            event.preventDefault();
            formData = serializeFormToFormData('myForm');
            formData.append('file', file);
            logFormData(formData);


            $.ajax({
                type: "POST",
                url: "{{route('salon.employee.validateStore')}}",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('input').removeClass('is-invalid')
                    $('select').removeClass('is-invalid')
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
