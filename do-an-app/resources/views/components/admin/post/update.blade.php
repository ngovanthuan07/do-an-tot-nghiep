@extends('layouts.admin')
@section('title', 'Thêm bài viêt')
@section('content')
    <div id="contentApp">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Thêm bài viết</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Bài viết</a></li>
                            <li class="breadcrumb-item active">Thêm bài viêt</li>
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
                                    <input type="hidden" id="post_id" name="post_id" value="{{$post->post_id}}">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Tiêu đề bài viết*</label>
                                            <input
                                                type="text"
                                                name="title"
                                                class="form-control"
                                                id="title"
                                                value="{{$post->title}}"
                                                placeholder="Tiêu đề bài viết">
                                            <div class="invalid-feedback message-error"> </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Hình ảnh*</label>&emsp;
                                            <button id="btnImage" class="btn-sm btn-success float-right"><i class="fa-solid fa-upload"></i> Upload File</button>
                                            <input type="file" id="file" style="display:none">
                                            <div id="service-picture-container">
                                                <img id="service-picture" src="{{asset('/media/post/'.$post->image)}}">
                                            </div>

                                            <div class="invalid-feedback message-error"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Nội dung*</label>
                                            <textarea id="editor" class="form-control" name="content"></textarea>
                                            <div class="invalid-feedback message-error"> </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="ckeditorValue" name="ckeditorValue" value="{{$post->content}}">

                                    <div class="">
                                        <button type="submit" class="btn btn-primary" id="saveBtn"><i class="fa fa-save mr-1">Lưu</i>
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
    <script src="//cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script>
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
        'content' => 'Bạn có muốn lưu thông tin không?'
    ])
@endpush
@push('scripts')

    <script type="module">
        import {getByProvince, getByDistrict} from '/js/common/vn-public-api.js'
        import {logFormData, serializeFormToFormData} from '/js/helper/form-helper.js'
        import {modalDispatch, handleConfirmModal} from '/js/helper/modal-helper.js'
        let formData;
        let ward = '';
        let file = '';


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

        CKEDITOR.replace('editor');
        CKEDITOR.instances.editor.setData($('#ckeditorValue').val());

        $("#saveBtn").on("click", function(event) {
            event.preventDefault();
            if($('#title').val() == null || $('#title').val() == '') {
                toastr["error"]("Tiêu đề không được để trống");
                return;
            }
            if(CKEDITOR.instances.editor.getData() == null || CKEDITOR.instances.editor.getData() == '') {
                toastr["error"]("Vui lòng nhập nội dung");
                return;
            }
            let newFormData = new FormData();
            newFormData.append('post_id', $('#post_id').val());
            newFormData.append('title', $('#title').val());
            newFormData.append('file', file);
            newFormData.append('content',  CKEDITOR.instances.editor.getData());
            $.ajax({
                type: "POST",
                url: "{{route('admin.posts.update')}}",
                data: newFormData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('input').removeClass('is-invalid')
                    $('.message-error').text('')
                },
                success: function (response) {
                    if (response.success) {
                        toastr["success"]("Cập nhật thành công");
                    }
                },
                error: function (error) {
                    toastr["error"]("Thêm thất bại");
                }
            });
        })
    </script>
@endpush
