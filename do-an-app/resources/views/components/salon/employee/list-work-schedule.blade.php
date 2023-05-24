@extends('layouts.salon')
@section('title', 'Khung giờ làm việc')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Khung giờ làm việc</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href=""></a>Nhân viên</li>
                        <li class="breadcrumb-item active">Khung giờ làm việc</li>
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
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">KHUNG GIỜ LÀM VIỆC</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button id="btnPlus" style="margin-right: 10px; margin-bottom: 10px;width: 7%" class="btn btn-success btn-sm float-left">+</button>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="btnWorkDate" type="date" class="form-control" name="work_date"  style="margin-bottom: 10px;" class="float-right">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table-bordered" style="width: 100%" id="table-input-day-ghe">
                                            <thead>
                                            <tr>
{{--                                                <th style="width: 20%" class="pl-2">STT</th>--}}
                                                <th style="width: 30%" class="pl-2">NHÂN VIÊN</th>
                                                <th style="width: 20%" class="pl-2">BẮT ĐẦU</th>
                                                <th style="width: 20%" class="pl-2">KÊT THÚC</th>
                                                <th style="width: 30%" class="pl-2">CHỨC NĂNG</th>
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
        .input-in-table{
            padding: 10px !important;
            border-radius: 0;
            border: none !important;
        }
        .input-in-table:focus{
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
    </style>
@endpush
@push('modalPage')
    @include('widgets.modal.confirmation-delete-modal', ['title' => 'Xóa salon', 'content' => 'Bạn có xóa'])
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
        import {addRowTr, addRowTrTwo, emptyRowTr} from '/js/common/employee-work-schedule-inner-html.js'
        import {logFormData, serializeFormToFormData} from '/js/helper/form-helper.js'

        let employees = []

        let formData;

        let deletedID = [];

        loadDataEmployee()

        function loadDataEmployee() {
            $.ajax({
                type: "GET",
                url: "{{route('salon.employee.all')}}",
                dataType: "json",
                success: function (response) {
                    employees = response
                },
                error: function (error) {
                    console.log(error);
                    employees = []
                    toastr["error"]("Không thể load được dữ liệu!");
                }
            });
        }

        function loadDataSchedule(dateWord) {
            $.ajax({
                type: "GET",
                url: "{{route('salon.employee.work-schedule-date')}}" + "?date_word=" + dateWord,
                dataType: "json",
                success: function (response) {
                    $('#tbody').html('');
                    if(response.length > 0) {
                        $('#tbody').append(addRowTrTwo(response, employees));
                    }

                    datetimepickerLoad()
                },
                error: function (error) {
                    console.log(error);
                    employees = []
                    toastr["error"]("Không thể load được dữ liệu!");
                }
            });
        }

        $('#btnWorkDate').on('change', function (event) {
            event.preventDefault();
            const dateWord = $(this).val();

            loadDataSchedule(dateWord)
        });

        function datetimepickerLoad() {
            $('.datetimepicker-input').datetimepicker({
                format: 'HH:mm',
                pickDate: false,
                pickSeconds: false,
                pick12HourFormat: false,
            })
        }
        datetimepickerLoad()

        $('#btnPlus').on('click', function (event) {
            event.preventDefault();
            let rowCount = $('#tbody tr').length;
            if(rowCount > employees.length - 1) {
                alert('Số lượng nhân viên chỉ có ' + employees.length);
            } else {
                $('#tbody').append(addRowTr(employees));
                datetimepickerLoad()
            }

        });

        $(document).ready(function () {
            $(document).on('click', '.btn-delete-working-schedule', function () {
                $(this).closest('tr').remove();
                if ($(this).data('workingscheduleid') != null){
                    deletedID.push($(this).data('workingscheduleid'))
                }
                console.log(deletedID)
            });
        })

        $('#btnSave').on('click', function (event) {
            event.preventDefault();
            formData = serializeFormToFormData('myForm');
            formData.append('delete_ids', JSON.stringify(deletedID))
            logFormData(formData);

            let getIDEmployeeIDS = new FormData(document.getElementById('myForm'));

            $.ajax({
                type: "POST",
                url: "{{route('salon.employee.work-schedule-save')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    toastr["success"]("Lưu thành công!");
                    if(response.success) {
                        deletedID = [];
                        loadDataSchedule(response.work_date)
                    }

                },
                error: function (error) {
                    deletedID = [];
                    if(error?.responseJSON?.message) {
                        toastr["error"](error?.responseJSON?.message);
                    }
                    toastr["error"]("Không thể lưu được dữ liệu!");
                }
            });
        })
    </script>
@endpush
