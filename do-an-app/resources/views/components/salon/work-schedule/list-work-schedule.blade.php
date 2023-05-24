@extends('layouts.salon')
@section('title', 'Khung giờ')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Khung giờ</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href=""></a>Khung giờ</li>
                        <li class="breadcrumb-item active">Giờ làm việc salon</li>
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
                        <input id="wsId" type="hidden" name="ws_id">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">KHUNG GIỜ</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button id="btnPlus" style="margin-right: 10px; margin-bottom: 10px;width: 7%" class="btn btn-success btn-sm float-left">+</button>
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <input id="btnWorkDate" type="date" class="form-control" name="work_date"  style="margin-bottom: 10px;" class="float-right">
                                        <button id="btnCreateTimeSlot" style="margin-right: 10px; margin-bottom: 10px;width: 7%" class="btn btn-warning btn-sm float-left ml-2"><i class="fa-solid fa-timer"></i></button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table-bordered" style="width: 100%" id="table-input-day-ghe">
                                            <thead>
                                            <tr>
                                                <th style="width: 40%" class="pl-2">KHUNG GIỜ</th>
                                                <th style="width: 40%" class="pl-2">TÌNH TRẠNG</th>
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
        .input-in-table {
            padding: 5px 10px 5px 10px !important;
            border-radius: 0;
            border: none !important;
        }
        .input-in-table:focus {
            box-shadow: 0 0 0 1px #80bdff inset;
        }
        .td-table-input{
            padding: 0 !important;
        }
        .select-appearance{
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .select-option-one {
            background-color: rgb(255, 255, 255);
        }
        .select-option-tow {
            background-color: rgba(255, 190, 1, 0.83);
        }
    </style>
@endpush
@push('modalPage')
    @include('widgets.modal.create-time-slot-modal')
@endpush
@push('pushLink')
    @include('shared.link-data-tables')
@endpush
@push('dataTableScript')
    @include('shared.script-data-tables')
@endpush
@push('scripts')
    <script type="module">
        import {modalDispatch, handleConfirmModal} from '/js/helper/modal-helper.js'
        import {logFormData, serializeFormToFormData} from '/js/helper/form-helper.js'
        import {addRowTr, addRowTrTwo} from '/js/common/work-schedule-inner-html.js'

        let formData;

        let dateItem;

        function loadDataSchedule(dateWord) {
            $.ajax({
                type: "GET",
                url: "{{route('salon.schedule.work-schedule-date')}}" + "?date_word=" + dateWord,
                dataType: "json",
                success: function (response) {
                    $('#tbody').html('');
                    console.log(response);
                    if(response.success) {
                        $('#wsId').val(response.ws_id);
                        $('#tbody').html(addRowTrTwo(response.hours));
                    }

                    datetimepickerLoad()
                },
                error: function (error) {
                    console.log(error);
                    toastr["error"]("Không thể load được dữ liệu!");
                }
            });
        }

        $('#btnModalTimeSlot').on('click', function() {
            let startTime = $('#modal_start_time_slot').val();
            let endTime = $('#modal_end_time_slot').val();
            let spaceTime = parseInt($('#modal_space_time_slot').val());

            let startDate = new Date();
            startDate.setHours(parseInt(startTime.split(':')[0]), parseInt(startTime.split(':')[1]), 0, 0);

            let endDate = new Date();
            endDate.setHours(parseInt(endTime.split(':')[0]), parseInt(endTime.split(':')[1]), 0, 0);

            let diffInMinutes = Math.floor((endDate - startDate) / 60000);

            let numIterations = Math.floor(diffInMinutes / spaceTime);

            let timeArray = [];
            for (let i = 0; i <= numIterations; i++) {
                let time = new Date(startDate.getTime() + (spaceTime * i * 60000));
                let hour = ('0' + time.getHours()).slice(-2) + ':' + ('0' + time.getMinutes()).slice(-2);
                let is_selected = 1; // Mặc định là được chọn

                // Kiểm tra nếu trong khoảng từ 12h đến 13h hoặc từ 17h30 đến 16h thì không được chọn
                if ( (hour >= '00:00' && hour < '07:00')
                    || (hour >= '12:00' && hour < '13:00')
                    || (hour >= '22:00' && hour <= '23:59')
                ) {
                    is_selected = 0;
                }

                let timeObj = {
                    time_slot: hour,
                    is_selected: is_selected
                };
                timeArray.push(timeObj);
            }

            $('#tbody').html(addRowTrTwo(timeArray));
            $('#createTimeSlotModal').modal('hide');
            loadSelect()
        });

        $('#btnWorkDate').on('change', function (event) {
            event.preventDefault();
            const dateWord = $(this).val();
            dateItem= dateWord;
            loadDataSchedule(dateWord)
        });

        $('#btnCreateTimeSlot').on('click', function (event) {
           event.preventDefault()
            $('#createTimeSlotModal').modal('show');
        });


        function loadSelect() {
            $(document).ready(function() {
                $('.select-appearance').on('change', function() {
                    let selectedValue = $(this).val();

                    // Xóa lớp hiện tại của các <option>
                    $(this).removeClass('select-option-one select-option-tow');

                    // Thêm lớp mới tương ứng với giá trị được chọn
                    if (selectedValue === '1') {
                        $(this).addClass('select-option-one');
                    } else if (selectedValue === '0') {
                        $(this).addClass('select-option-tow');
                    }
                });
            });
        }

        function datetimepickerLoad() {
            $('.datetimepicker-input').datetimepicker({
                format: 'HH:mm',
                pickDate: false,
                pickSeconds: false,
                pick12HourFormat: false,
            })
        }
        datetimepickerLoad()

        $(document).ready(function () {
            $(document).on('click', '.btn-delete-working-schedule', function () {
                $(this).closest('tr').remove();
            });
        })

        $('#btnPlus').on('click', function (event) {
            event.preventDefault();
            $('#tbody').append(addRowTr());

            datetimepickerLoad()
            loadSelect()
        });

        $('#btnSave').on('click', function (event) {
            event.preventDefault();
            formData = serializeFormToFormData('myForm');
            logFormData(formData);

            $.ajax({
                type: "POST",
                url: "{{route('salon.schedule.work-schedule-save')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    toastr["success"]("Lưu thành công!");
                    if(response.success) {
                        $('#wsId').val(response.ws_id);
                        loadDataSchedule(dateItem);
                    }

                },
                error: function (error) {
                    if(error?.responseJSON?.message) {
                        toastr["error"](error?.responseJSON?.message);
                    }
                    toastr["error"]("Không thể lưu được dữ liệu!");
                }
            });
        })
    </script>
@endpush
