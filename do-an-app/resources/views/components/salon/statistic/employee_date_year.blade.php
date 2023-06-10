@extends('layouts.salon')
@section('title', 'Thống kê nhân viên')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Thống kê</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href=""></a>Thống kê</li>
                        <li class="breadcrumb-item active">Thống kê nhân viên</li>
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
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                            </div>
                            <div class="row mt-2 mb-3 ml-2">
                                <div class="col-md-3">
                                    <input type="text" id="datepicker" class="form-control" name="datepicker" placeholder="Chọn tháng và năm">
                                </div>
                            </div>
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="card mt-2">
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID NHÂN VIÊN</th>
                                    <th>HÌNH ẢNH</th>
                                    <th>TÊN NHÂN VIÊN</th>
                                    <th>SỐ ĐT</th>
                                    <th>NGÀY SINH</th>
                                    <th>GIỚI TÍNH</th>
                                    <th>SỐ LƯỢNG CUỘC HẸN HOÀN TẤT</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
    <style>
        #myChart {
            width: 500px;
            height: 300px;
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
    <script src="{{asset('backend/plugins/moment/moment.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.min.js" integrity="sha512-mlz/Fs1VtBou2TrUkGzX4VoGvybkD9nkeXWJm3rle0DPHssYYx4j+8kIS15T78ttGfmOjH0lLaBXGcShaVkdkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>

    <script type="module">
        import {generateRandomColors} from '{{asset('/js/helper/random-color.js')}}';
        const ctx = document.getElementById('myChart');
        const dataTableDetail = $("#dataTable")
        function initDataTable() {
            dataTableDetail.DataTable({
                "columns": [
                    {data: "employee_id"},
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                            <img width="100" height="100" style="object-fit: cover;" src="/media/employee/${data.image}" alt="${data.name}">
                        `;
                        }
                    },
                    {data: "fullname"},
                    {data: "phone"},
                    {data: "dob"},
                    {
                        data: null,
                        render: function (data, type, row) {
                            const gender = data.gender === 1 ? 'Nam' : 'Nữ';
                            return `
                            <span>${gender}</span>
                        `;
                        }
                    },
                    {data: "number_of_appointments"}
                ],
                "processing": false,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "language": {
                    "emptyTable": "Không có dữ liệu", // Thay đổi chuỗi "No data available in table" thành "Không có dữ liệu"
                    "zeroRecords": "Không tìm thấy",
                    "search": "Tìm kiếm", // Thay đổi chuỗi "Search" thành "Tìm kiếm"
                },
                "searching": false,  // Hide the search box
                "info": false,  // Hide the information about the number of entries
                "paging": false,  // Hide the pagination,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        }
        initDataTable()
        // Khởi tạo datepicker
        $(document).ready(function() {
            $('#datepicker').datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months"
            });

            $('#datepicker').on('hide', function () {
                let [month, year] = $(this).val().split('-')
                loadData({
                    'month': month,
                    'year': year
                })
            });
        });



        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Số lượng đặt lịch ',
                    data: [],
                    backgroundColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    xAxes: [{
                        barPercentage: 0.3
                    }]
                }
            },
        });
        // Hàm gọi Ajax và cập nhật biểu đồ
        function loadData(data) {
            $.ajax({
                url: '{{route('salon.statistic.top_nhan_vien_api')}}',
                method: 'GET',
                data: data,
                success: function(response) {
                    console.log(response)
                    const myChartData = response.flatMap((item) => (item.number_of_appointments));
                    // Cập nhật dữ liệu cho biểu đồ
                    myChart.data.labels = response.flatMap((item) => (item.fullname));
                    myChart.data.datasets[0].data = myChartData;
                    myChart.data.datasets[0].backgroundColor = generateRandomColors(response);
                    myChart.update();

                    const hasNonZeroElement = array => array.some(Boolean);
                    let isCheck = false;
                    if(myChartData.length > 0) {
                        if(hasNonZeroElement(myChartData)) {
                            isCheck = true;
                        }
                    }

                    dataTableDetail.DataTable().clear();
                    dataTableDetail.DataTable().rows.add(isCheck ? response : []);
                    dataTableDetail.DataTable().draw();
                },
                error: function(error) {
                    console.log(error)
                    myChart.data.labels = [];
                    myChart.data.datasets[0].data = [];
                    myChart.update();
                    dataTableDetail.DataTable().clear();
                    dataTableDetail.DataTable().rows.add([]);
                    dataTableDetail.DataTable().draw();
                }
            });
        }
    </script>
@endpush
