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
                        <li class="breadcrumb-item active">Thống kê tất cả</li>
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
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{$countAppointmentSuccess}}</h3>

                                    <p>Số lượng đặt lịch thành công</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{route('salon.appointment.lCompleted')}}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{$revenue}}<sup style="font-size: 20px">vnđ</sup></h3>

                                    <p>Doanh thu</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fas fa-??"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{$countEmployee}}</h3>

                                    <p>Nhân viên</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{route('salon.employee.displayEmployees')}}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{$countService}}</h3>

                                    <p>Dịch vụ</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{route('salon.service.displayServices')}}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><a href="/lam-dep/{{$salonID}}/chi-tiet-salon"><i class="fas fa-star"></i></a></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Sao</span>
                            <span class="info-box-number">{{number_format($star, 1)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><a href="/lam-dep/{{$salonID}}/chi-tiet-salon"><i class="fas fa-comment"></i></a></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Bình luận</span>
                            <span class="info-box-number">{{$commentCount}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
            </div>


            <div class="row">
               <div class="col-md-12">
                   <div class="row">
                        <div class="col-md-12">
                            <h4>Thông kê theo năm</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="revenue-year-datepicker" id="revenue-year-datepicker" />
                                </div>
                                <div class="col-md-3">
                                    <select id="chartSelectR" class="form-control">
                                        <option value="line">Biểu đồ đường</option>
                                        <option value="bar">Biểu đồ cột</option>
                                        <option value="pie">Biểu hình tròn</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="chartSelectB" class="form-control">
                                        <option value="bar">Biểu đồ cột</option>
                                        <option value="line">Biểu đồ đường</option>
                                        <option value="pie">Biểu hình tròn</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                   </div>
                   <div class="row mt-2">
                       <div class="col-md-6">
                           <p><b>Tổng doanh thu: </b> <span id="totalR">0  </span> VNĐ</p>
                       </div>
                       <div class="col-md-6">
                           <p><b>Số lượng đặt lịch: </b><span id="totalB">1</span> Cuộc hẹn thành công</p>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-12">
                           <h4>Biểu đồ doanh thu - số lượng đặt lịch theo từng tháng của năm</h4>
                       </div>
                       <div class="col-md-6">
                           <canvas id="charRevenueYear"></canvas>
                       </div>
                       <div class="col-md-6">
                           <canvas id="charBookYear"></canvas>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-6">
                           <table id="dataTableRevenueYear" class="table table-bordered table-striped">
                               <thead>
                               <tr>
                                   <th>Tháng</th>
                                   <th>Doanh thu</th>
                               </tr>
                               </thead>
                               <tbody>
                               </tbody>
                           </table>
                       </div>
                       <div class="col-md-6">
                           <table id="dataTableBookYear" class="table table-bordered table-striped">
                               <thead>
                               <tr>
                                   <th>Tháng</th>
                                   <th>Doanh thu</th>
                               </tr>
                               </thead>
                               <tbody>
                               </tbody>
                           </table>
                       </div>
                   </div>
                   <div class="row mt-2">
                       <h4>Top khách theo tháng</h4>

                       <div class="col-md-3">
                           <input type="text" class="form-control" name="employee-month-datepicker" id="employee-month-datepicker" />
                       </div>

                       <div class="col-md-12">
                            <table id="dataTableEmployeeMonth" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>HÌNH ẢNH</th>
                                    <th>TÊN KHÁCH HÀNG</th>
                                    <th>SỐ ĐIỆN THOẠI</th>
                                    <th>EMAIL</th>
                                    <th>LỊCH HẸN</th>
                                    <th>TỔNG SỐ TIỀN DỊCH VỤ</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                   </div>

                   <div class="row mt-2">
                       <h4>Top khách hàng theo năm</h4>

                       <div class="col-md-3">
                           <input type="text" class="form-control" name="employee-year-datepicker" id="employee-year-datepicker" />
                       </div>

                       <div class="col-md-12">
                           <table id="dataTableEmployeeYear" class="table table-bordered table-striped">
                               <thead>
                               <tr>
                                   <th>HÌNH ẢNH</th>
                                   <th>TÊN KHÁCH HÀNG</th>
                                   <th>SỐ ĐIỆN THOẠI</th>
                                   <th>EMAIL</th>
                                   <th>LỊCH HẸN</th>
                                   <th>TỔNG SỐ TIỀN DỊCH VỤ</th>
                               </tr>
                               </thead>
                               <tbody>
                               </tbody>
                           </table>
                       </div>
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
        const dataTableRevenueYear = $("#dataTableRevenueYear")
        const dataTableBookYear = $("#dataTableBookYear")
        let dataTableEmployeeMonth = $("#dataTableEmployeeMonth")
        let dataTableEmployeeYear = $("#dataTableEmployeeYear")

        dataTableEmployeeMonth.DataTable(
            {
                "columns": [
                    {data: "fullname"},
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                            <img width="100" height="100" style="object-fit: cover;" src="${data.image}" alt="${data.image}">
                        `;
                        }
                    },
                    {data: "phone"},
                    {data: "email"},
                    {data: "count"},
                    {data: "total"},
                ],
                "processing": false,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "language": {
                    "emptyTable": "Không có dữ liệu",
                },
                "searching": false,  // Hide the search box
                "info": false,  // Hide the information about the number of entries
                "paging": false  // Hide the pagination
            }
        );

        dataTableEmployeeYear.DataTable(
            {
                "columns": [
                    {data: "fullname"},
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                            <img width="100" height="100" style="object-fit: cover;" src="${data.image}" alt="${data.image}">
                        `;
                        }
                    },
                    {data: "phone"},
                    {data: "email"},
                    {data: "count"},
                    {data: "total"},
                ],
                "processing": false,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "language": {
                    "emptyTable": "Không có dữ liệu",
                },
                "searching": false,  // Hide the search box
                "info": false,  // Hide the information about the number of entries
                "paging": false  // Hide the pagination
            }
        );

        dataTableRevenueYear.DataTable({
            "columns": [
                {data: "month"},
                {data: "revenue"},
            ],
            "processing": false,
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "language": {
                "emptyTable": "Không có dữ liệu",
            },
            "searching": false,  // Hide the search box
            "info": false,  // Hide the information about the number of entries
            "paging": false  // Hide the pagination
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        dataTableBookYear.DataTable({
            "columns": [
                {data: "month"},
                {data: "book"},
            ],
            "processing": false,
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "language": {
                "emptyTable": "Không có dữ liệu",
            },
            "searching": false,  // Hide the search box
            "info": false,  // Hide the information about the number of entries
            "paging": false  // Hide the pagination
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        // Khởi tạo datepicker
        $(document).ready(function() {
            $("#revenue-year-datepicker").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose:true,
            });

            $('#revenue-year-datepicker').on('hide', function () {
                let nYear = $(this).val()
                console.log(nYear)
                loadDataRevenueYear(nYear)
            });
            $('#employee-month-datepicker').datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months"
            });
            $('#employee-month-datepicker').on('hide', function () {
                let [month, year] = $(this).val().split('-')
                loadDataEmployeeMonthAndYear({
                    'month': month,
                    'year': year,
                    'type': 'my'
                })
            });
            $('#employee-year-datepicker').datepicker({
                format: "yyyy",
                startView: "years",
                minViewMode: "years"
            });
            $('#employee-year-datepicker').on('hide', function () {
                let year = $(this).val().split('-')
                loadDataEmployeeMonthAndYear({
                    'month': null,
                    'year': year,
                    'type': 'y'
                })
            });
        });
        $('#revenue-year-datepicker').val(moment().year());
        const charRevenueYear = document.getElementById('charRevenueYear');
        const charBookYear = document.getElementById('charBookYear');

        function createChart(chartElement, myType, myLabel) {
            return new Chart(chartElement, {
                type: myType,
                data: {
                    labels: [],
                    datasets: [{
                        label: myLabel,
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
                }
            });
        }


        let revenueYearChart = createChart(charRevenueYear, 'line', 'Doanh Thu')

        let charBookYearChart = createChart(charBookYear, 'bar', 'Số lượng người đặt')

        $('#chartSelectR').on('change', function () {
            revenueYearChart.config.type = $(this).val()
            revenueYearChart.update()
        })

        $('#chartSelectB').on('change', function () {
            charBookYearChart.config.type = $(this).val()
            charBookYearChart.update()
        })

        loadDataRevenueYear($('#revenue-year-datepicker').val())

        function loadDataEmployeeMonthAndYear(data) {
            console.log(data)
            $.ajax({
                url: '{{route('salon.statistic.getEmployeeBookByMonthAndYear')}}',
                method: 'GET',
                data: data,
                success: function(response) {
                    if(data.month) {
                        console.log(response)
                        dataTableEmployeeMonth.DataTable().clear();
                        dataTableEmployeeMonth.DataTable().rows.add(response ?? []);
                        dataTableEmployeeMonth.DataTable().draw();
                    } else {
                        console.log(response)
                        dataTableEmployeeYear.DataTable().clear();
                        dataTableEmployeeYear.DataTable().rows.add( response ?? []);
                        dataTableEmployeeYear.DataTable().draw();
                    }

                },
                error: function(error) {
                    dataTableEmployeeMonth.DataTable().clear();
                    dataTableEmployeeMonth.DataTable().rows.add([]);
                    dataTableEmployeeMonth.DataTable().draw();
                    dataTableEmployeeYear.DataTable().clear();
                    dataTableEmployeeYear.DataTable().rows.add( response ?? []);
                    dataTableEmployeeYear.DataTable().draw();
                }
            });
        }


        // Hàm gọi Ajax và cập nhật biểu đồ
        function loadDataRevenueYear(data) {
            $.ajax({
                url: '{{route('salon.statistic.getRevenueAndBookByMonth')}}',
                method: 'GET',
                data: {'year': data},
                success: function(response) {
                    let {revenues, books} = response
                    console.log(response)
                    revenueYearChart.data.labels = revenues.flatMap((item) => (item.month));
                    revenueYearChart.data.datasets[0].data = revenues.flatMap((item) => (item.revenue));
                    revenueYearChart.data.datasets[0].backgroundColor = generateRandomColors(revenues);
                    revenueYearChart.update();

                    charBookYearChart.data.labels = books.flatMap((item) => (item.month));
                    charBookYearChart.data.datasets[0].data = books.flatMap((item) => (item.book));
                    charBookYearChart.data.datasets[0].backgroundColor = generateRandomColors(books);
                    charBookYearChart.update();

                    dataTableRevenueYear.DataTable().clear();
                    dataTableRevenueYear.DataTable().rows.add(revenues);
                    dataTableRevenueYear.DataTable().draw();

                    dataTableBookYear.DataTable().clear();
                    dataTableBookYear.DataTable().rows.add(books);
                    dataTableBookYear.DataTable().draw();

                    let r = revenues.flatMap((item) => (item.revenue));
                    let b = books.flatMap((item) => (item.book))
                    $('#totalR').text(r.length > 0 ? r.reduce( (acc, current) => acc + (current * 1), 0) : 0);
                    $('#totalB').text(b.length > 0 ? b.reduce( (acc, current) => acc + (current * 1), 0) : 0);

                },
                error: function(error) {
                    console.log(error)
                    revenueYearChart.data.labels = [];
                    revenueYearChart.data.datasets[0].data = [];
                    revenueYearChart.update();

                }
            });
        }
    </script>
@endpush
