@extends('layouts.salon')
@section('title', 'Thêm dịch vụ')
@section('content')
    <div id="contentApp">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Thêm dịch vụ</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dịch vụ</a></li>
                            <li class="breadcrumb-item active">Thêm dịch vụ</li>
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
                                            <label for="name">Tên dịch vụ*</label>
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
                                            <label for="name">Loại dịch vụ dịch vụ*</label>
                                            <select class="form-control nice-select sort-select" name="cse_id" id="cse_id">
                                                <option value="">-- CHỌN LOẠI DỊCH VỤ --</option>
                                                @foreach($categoryServices as $cs)
                                                    <option value="{{$cs->cse_id}}">{{$cs->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback message-error"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Giá dịch vụ*</label>
                                            <input
                                                type="number"
                                                name="price"
                                                class="form-control"
                                                id="price"
                                                placeholder="Tên salon">
                                            <div class="invalid-feedback message-error"> </div>
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
                url: "{{route('salon.service.store')}}",
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
                url: "{{route('salon.service.validateStore')}}",
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
