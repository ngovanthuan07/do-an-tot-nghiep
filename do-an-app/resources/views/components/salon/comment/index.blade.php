@extends('layouts.salon')
@section('title', 'Danh sách bình luận')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh sách bình luận</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bình luận</a></li>
                        <li class="breadcrumb-item active">Danh sách bình luận</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách bình luận</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>NGƯỜI BÌNH LUẬN</th>
                                    <th>THỜI GIAN</th>
                                    <th>SỐ SAO</th>
                                    <th>NỘI DUNG</th>
                                    <th></th>

                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
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
    <script src="<?php echo e(asset('lib/momentjs/moment.js')); ?>"></script>
    <script type="module">
        import {modalDispatch, handleConfirmModal} from '/js/helper/modal-helper.js'
        const dataTableDetail = $("#dataTable")
        let deleteId;
        function initDataTable() {
            dataTableDetail.DataTable({
                "columns": [
                    {
                        data: null,
                        render: function (data) {
                            return data.customer.fullname
                        }
                    },
                    {
                        data: "date",
                        render: function(data) {
                            return moment(data).format('DD-MM-YYYY HH:mm:ss'); // format ngày tháng hiển thị
                        }
                    },
                    {
                        data: "star",
                        render: function(data) {
                            return '<i class="fa-solid fa-star" style="color: #ffd43b;"></i>'.repeat(data);
                        }
                    },
                    {
                        data: "content",
                        render: function(data) {
                            return data; // format ngày tháng hiển thị
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            const id = data.comment_id;
                            return `
                            <a href="/salon/comment/xoa-binh-luan/${id}" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                        `;
                        }
                    }
                ],
                "columnDefs": [
                    // Thêm tính năng tìm kiếm cho cột appointment_date
                    { "type": 'datetime-moment', targets: 2 }
                ],
                "processing": true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "language": {
                    "emptyTable": "Không có dữ liệu", // Thay đổi chuỗi "No data available in table" thành "Không có dữ liệu"
                    "infoEmpty": "Hiển thị 0 đến 0 của 0 dòng", // Thay đổi chuỗi "Showing 0 to 0 of 0 entries" thành "Hiển thị 0 đến 0 của 0 dòng"
                    "zeroRecords": "Không tìm thấy",
                    "infoFiltered": "(được lọc từ tổng số _MAX_ dòng)", // Thay đổi chuỗi "filtered from _MAX_ total entries" thành "(được lọc từ tổng số _MAX_ dòng)"
                    "info": "Hiển thị _START_ đến _END_ của _TOTAL_ dòng", // Thay đổi chuỗi "Showing _START_ to _END_ of _TOTAL_ entries" thành "Hiển thị _START_ đến _END_ của _TOTAL_ dòng"
                    "search": "Tìm kiếm", // Thay đổi chuỗi "Search" thành "Tìm kiếm"
                    "paginate": {
                        "previous": "Trước", // Thay đổi chuỗi "previous" thành "Trước"
                        "next": "Sau" // Thay đổi chuỗi "next" thành "Sau"
                    }
                }
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            loadData()
        }
        initDataTable()

        handleConfirmModal(() => {
            $.ajax({
                url: '{{route('salon.categoryservice.updateStatus')}}',
                type: 'POST',
                data: {
                    'cse_id': deleteId,
                    'status': 'inactive'
                },
                success: function (response) {
                    console.log(response)
                    if(response.success) {
                        toastr["success"]("Xóa thành công!");
                    } else {
                        toastr["error"]("Xóa thất bại!");
                    }
                    modalDispatch('delete', 'hide');
                    loadData()
                },
                error: function (error) {
                    console.log(error);
                    toastr["error"]("Xóa tài khoản thất bại!");
                    modalDispatch('delete', 'hide');
                },
            });
        }, 'delete')

        $(document).on('click', '.btnHandleEventDelete', function() {
            const id = $(this).data('id');
            deleteId = id

            modalDispatch('delete', 'show');
        });



        function loadData() {
            $.ajax({
                type: "GET",
                url: "{{route('salon.comment.commentApi')}}",
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    dataTableDetail.DataTable().clear();
                    dataTableDetail.DataTable().rows.add(response);
                    dataTableDetail.DataTable().draw();
                },
                error: function (error) {
                    console.log(error);
                    dataTableDetail.DataTable().clear();
                    dataTableDetail.DataTable().rows.add({});
                    dataTableDetail.DataTable().draw();
                    toastr["error"]("Không thể load được dữ liệu!");
                }
            });
        }



    </script>
@endpush
