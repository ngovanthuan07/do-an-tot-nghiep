@extends('layouts.salon')
@section('title', 'images')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tài khoản</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href=""></a>Hình ảnh</li>
                        <li class="breadcrumb-item active">Hình ảnh</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form id="myForm">
                        <input id="fileImage" style="display:none;" type="file" name="file">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Hình ảnh</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button id="btnPlus" style="margin-right: 10px; margin-bottom: 10px;width: 7%" class="btn btn-success btn-sm float-left">+</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table-bordered" style="width: 100%" id="table-input-day-ghe">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20%" class="pl-2">HÌNH ẢNH</th>
                                                    <th style="width: 20%" class="pl-2">CHỨC NĂNG</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btnSave">Lưu thông tin</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
@push('styles')
    <style>
        .image-salon-pic {
            width: 50%;
            object-fit: cover;
        }
    </style>
@endpush
@push('modalPage')
    @include('widgets.modal.create-time-slot-modal')
@endpush
@push('scripts')
<script type="module">
    import {modalDispatch, handleConfirmModal} from '/js/helper/modal-helper.js';
    import {logFormData, serializeFormToFormData} from '/js/helper/form-helper.js';
    import {addRowTr, emptyRowTr, loadRowTr} from '/js/common/salon-image-inner-html.js';
    import {checkAndRandomizeId} from '/js/helper/random.js';
    import { v4 as uuidv4 } from 'https://jspm.dev/uuid';

    let deletedID = [];

    let images = [];

    $("#fileImage").on("change", function (event) {
        let obj = {}
        let reader = new FileReader();
        reader.onload = function() {
            let fileURL = reader.result;
            let idImage = checkAndRandomizeId(images, uuidv4())
            images.push({
                ...obj,
                'id': idImage,
                'src': null,
                'file': event.target.files[0],
            });
            $('#tbody').append(addRowTr(fileURL, idImage));
        };

        reader.readAsDataURL(event.target.files[0]);
    })

    function deleteImageById(images, idToDelete) {
        const filteredImages = images.filter(image => image.id !== idToDelete);
        return filteredImages;
    }

    $(document).ready(function () {
        $(document).on('click', '.btn-delete-image', function (event) {
            event.preventDefault();
            if ($(this).data('image-id') != null){
                const id = $(this).data('image-id');
                $(this).closest('tr').remove();
                console.log(id)
                deletedID.push(id)
                images = deleteImageById(images, id);
            }
            console.log('DELETED:',deletedID)
            console.log('IMAGE:',images)
        });
    })

    $(document).ready(function () {
        $('#btnPlus').on('click', function (event) {
            event.preventDefault();
            document.getElementById("fileImage").click();
        });
    })

    $(document).ready(function() {
        $('#btnSave').on('click', function (event) {
            event.preventDefault();
            let formData = new FormData()
            for (let i = 0; i < images.length; i++) {
                let image = images[i];
                formData.append('images[' + i + '][id]', image['id']); // Thêm id của hình ảnh vào FormData
                formData.append('images[' + i + '][file]', image['file']); // Thêm dữ liệu nhị phân của hình ảnh vào FormData
                formData.append('images[' + i + '][src]', image['src']); // Thêm dữ liệu nhị phân của hình ảnh vào FormData
            }

            formData.append('deleted_id', JSON.stringify(deletedID));

            console.log('SAVE:', images);

            $.ajax({
                type: "POST",
                url: "{{route('salon.profile.images-save')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    toastr["success"]("Lưu thành công!");
                    if (response.success) {
                        console.log(response.images)
                        loadImages();
                    }
                },
                error: function (error) {
                    loadImages();
                    toastr["error"]("Lỗi");
                }
            });
        })
    })

    function loadImages() {
        $.ajax({
            type: "GET",
            url: "{{route('salon.profile.salon-images')}}",
            dataType: "json",
            success: function (response) {
                images = response;
                deletedID = [];
                $('#tbody').html(loadRowTr(images));
            },
            error: function (error) {
                images = [];
                toastr["error"]("Không thể load được dữ liệu!");
            }
        });
    }
    loadImages()
</script>
@endpush
