@extends('layouts.admin')
@section('title', 'Danh sách salon nỗi bật')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh sách salon nỗi bật</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Cài đặt</a></li>
                        <li class="breadcrumb-item active">Danh sách salon nỗi bật</li>
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
                            <h3 class="card-title">Danh sách các tài khoản salon</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button id="addOutstanding" class="btn btn-success mb-2 float-right">Thêm salon nổi bật</button>
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>SALON ID</th>
                                    <th>TÊN SALON</th>
                                    <th>USERNAME</th>
                                    <th>SỐ ĐT</th>
                                    <th>Chức năng</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyOutstanding">
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
    @include('widgets.modal.outstanding-admin-modal');
@endpush
@push('pushLink')
    @include('shared.link-data-tables')
@endpush
@push('dataTableScript')
    @include('shared.script-data-tables')
@endpush
@push('scripts')
    <script type="module">
        const dataTableModal = $("#dataTableModal")
        const modal = $('#outstandingModal');

        $('#addOutstanding').on('click', function (event) {
            event.preventDefault();
            modal.modal('show')

            loadSalon()
        })

        dataTableModal.DataTable({
            "columns": [
                {data: "salon_id"},
                {data: "name"},
                {data: "username"},
                {data: "phone"},
                {
                    data: null,
                    render: function (data, type, row) {
                        const id = data.salon_id
                        return `
                           <button type="button" class="btn btn-success btn-sm btnHandleEventAdd" data-id="${id}">Thêm</button>
                        `;
                    }
                }
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

        $(document).on('click', '.btnHandleEventAdd', function (event) {
            event.preventDefault();

            $.ajax({
                type: 'POST',
                url: '{{route('admin.outstanding.addOutstanding')}}',
                data: {
                    'salon_id': $(this).data('id')
                },
                success: function (resp) {
                    loadSalon()
                    loadSalonOutstanding()
                },
                error: function (error) {
                    loadSalon()
                    loadSalonOutstanding()
                }
            })
        })

        function loadSalon() {
            $.ajax({
                type: "GET",
                url: "{{route('admin.outstanding.listSalonNotOutstanding')}}",
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    dataTableModal.DataTable().clear();
                    dataTableModal.DataTable().rows.add(response);
                    dataTableModal.DataTable().draw();
                },
                error: function (error) {
                    console.log(error);
                    dataTableModal.DataTable().clear();
                    dataTableModal.DataTable().rows.add({});
                    dataTableModal.DataTable().draw();
                    toastr["error"]("Không thể load được dữ liệu!");
                }
            });
        }

        loadSalonOutstanding()
        function loadSalonOutstanding() {
            $.ajax({
                type: "GET",
                url: "{{route('admin.outstanding.listSalonOutstanding')}}",
                dataType: "json",
                success: function (resp) {
                    const resultHTML = resp.map(salon => {
                        return `
                            <tr>
                                <td>${salon.salon_id}</td>
                                <td>${salon.name}</td>
                                <td>${salon.username}</td>
                                <td>${salon.phone}</td>
                                <td>
                                    <button class="btn btn-danger btnRemoveOutstanding" data-id='${salon.salon_id}'><i class="fa-solid fas fa-trash"></i></button>
                                </td>
                            </tr>
                        `
                    }).join('')
                    $('#tbodyOutstanding').html(resultHTML);
                },
                error: function (error) {

                }
            });
        }

        $(document).on('click', '.btnRemoveOutstanding', function (event) {
            event.preventDefault();
            const salonID = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: '{{route('admin.outstanding.removeOutstanding')}}',
                data: {
                    'salon_id': salonID
                },
                success: function (resp) {
                    loadSalonOutstanding()
                }
            })
        })
    </script>
@endpush
