@extends('layouts.salon')
@section('title', 'Cập nhật trang cá nhân')
@section('content')
    <div id="contentApp">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Cập nhật trang cá nhân</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Tài khoản salon</a></li>
                            <li class="breadcrumb-item active">Cập nhật trang cá nhân</li>
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
                            <input type="hidden" name="salon_id" value="{{$salon->salon_id}}" >
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Tên salon*</label>
                                            <input
                                                type="text"
                                                name="name"
                                                value="{{$salon->name}}"
                                                class="form-control"
                                                id="name"
                                                placeholder="Tên salon">
                                            <div class="invalid-feedback message-error"> </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Số điện thoại*</label>
                                            <input
                                                type="text"
                                                name="phone"
                                                value="{{$salon->phone}}"
                                                class="form-control"
                                                id="phone"
                                                placeholder="Số điện thoại">
                                            <div class="invalid-feedback message-error"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tỉnh / Thành phố*</label>
                                                    <select class="form-control selectProvince select2bs4" style="width: 100%;">
                                                        <option value="">CHỌN TỈNH THÀNH PHỐ</option>
                                                        @foreach($provinces as $province)
                                                            <option value="{{$province->code}}" {{$province->code == $location['province']->code ? 'selected' : ''}}>{{$province->full_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Quận / Huyện*</label>
                                                    <select class="form-control selectDistrict select2bs4" style="width: 100%;">
                                                        <option value="">CHỌN TỈNH QUẬN HUYỆN</option>
                                                        @foreach($districts as $district)
                                                            <option value="{{$district->code}}" {{$district->code == $location['district']->code ? 'selected' : ''}}>{{$district->full_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ward">Xã / Thị trấn*</label>
                                                    <select class="form-control selectWard select2bs4" id="ward" style="width: 100%;">
                                                        <option value="">CHỌN TỈNH XÃ THỊ TRẤN</option>
                                                        @foreach($wards as $ward)
                                                            <option value="{{$ward->code}}" {{$ward->code == $location['ward']->code ? 'selected' : ''}}>{{$ward->full_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback message-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="address">Tòa nhà / Tên đường*</label>
                                                        <input
                                                            type="text"
                                                            name="address"
                                                            value="{{$salon->address}}"
                                                            class="form-control "
                                                            id="address"
                                                            placeholder="Tòa nhà / Tên đường">
                                                        <div class="invalid-feedback message-error"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">Username*</label>
                                            <input
                                                type="email"
                                                name="username"
                                                value="{{$salon->username}}"
                                                class="form-control"
                                                id="username"
                                                placeholder="Username">
                                            <div class="invalid-feedback message-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password*</label>
                                            <input
                                                type="password"
                                                name="password"
                                                class="form-control"
                                                id="password"
                                                placeholder="Password">
                                            <div class="invalid-feedback message-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Miêu tả*</label>
                                            <textarea class="form-control" name="description" rows="10" placeholder="Miêu tả">{{$salon->description}}</textarea>
                                            <div class="invalid-feedback message-error"></div>
                                        </div>
                                    </div>

                                    <div class="">
                                        <a href="{{route('admin.salons')}}" class="btn btn-info" ><i
                                                class="fa fa-backward mr-1"></i>
                                            Quay về
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="saveBtn"><i class="fa fa-save mr-1"></i> Lưu
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
            'content' => 'Bạn có muốn lưu thông tin không?'
        ])
@endpush
@push('scripts')
    <script type="module">
        import {getByProvince, getByDistrict} from '/js/common/vn-public-api.js'
        import {logFormData, serializeFormToFormData} from '/js/helper/form-helper.js'
        import {modalDispatch, handleConfirmModal} from '/js/helper/modal-helper.js'
        let formData;
        let ward = $('.selectWard').val();

        $('.selectProvince').select2()

        $('.selectDistrict').select2()

        $('.selectWard').select2()

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('.selectProvince').on('change', function() {
            // Lấy giá trị đã chọn trong Select2
            let selectedValue = $(this).val();
            ward = ''
            getByProvince(selectedValue)
                .then(data => {
                    const districts = data;
                    const optionDistricts = districts.map(district => {
                        return `
                    <option value="${district.code}">${district.name}</option>
                `
                    })

                    optionDistricts.unshift(`<option value="0" selected>CHỌN QUẬN HUYỆN</option>`)

                    // selectCity
                    $('.selectDistrict').html(optionDistricts.join(''))
                })
                .catch(err => {
                    console.log('error', err)
                })

        });

        $('.selectDistrict').on('change', function() {
            // Lấy giá trị đã chọn trong Select2
            let selectedValue = $(this).val();
            ward = ''
            getByDistrict(selectedValue)
                .then(data => {
                    const wards = data;
                    const optionWards = wards.map(ward => {
                        return `
                    <option value="${ward.code}">${ward.name}</option>
                `
                    })

                    optionWards.unshift(`<option value="0" selected>CHỌN QUẬN HUYỆN</option>`)

                    // selectCity
                    $('.selectWard').html(optionWards.join(''))
                })
                .catch(err => {
                    console.log('error', err)
                })
        });

        $('.selectWard').on('change', function() {
            // Lấy giá trị đã chọn trong Select2
            ward = $(this).val();
        });

        handleConfirmModal(() => {
            $.ajax({
                type: "POST",
                url: "{{route('salon.profile.update')}}",
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
            formData.append('ward', ward);

            $.ajax({
                type: "POST",
                url: "{{route('salon.profile.validate-update')}}",
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
