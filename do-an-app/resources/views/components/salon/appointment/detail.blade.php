@extends('layouts.salon')
@section('title', 'Chi tiết cuộc hẹn')
@section('content')
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center pb-5">
                        <div class="col-md-10 col-xl-10 offset-xl-1">

                            <div class="rounded d-flex flex-column p-2" style="background-color: #f8f9fa;">
                                <div class="p-2 me-3">
                                    <h4>Chi tiết dịch vụ</h4>
                                </div>
                                <div class="border-top px-2 mx-2"></div>
                                <div class="p-2 d-flex pt-3">
                                    <div class="col-8"><b>Tên khách hàng </b></div>
                                    <div class="ms-auto"><b class="text-warning">{{$customer->fullname}}</b></div>
                                </div>
                                <div class="border-top px-2 mx-2"></div>
                                <div class="p-2 d-flex pt-3">
                                    <div class="col-8"><b>Số điện thoại </b></div>
                                    <div class="ms-auto"><b class="text-warning">{{$appointment->phone}}</b></div>
                                </div>
                                <div class="border-top px-2 mx-2"></div>
                                <div class="p-2 d-flex pt-3">
                                    <div class="col-8"><b>Ngày đặt lịch: </b></div>
                                    <div class="ms-auto"><b class="text-warning">{{$appointment->appointment_date}}</b></div>
                                </div>
                                <div class="border-top px-2 mx-2"></div>
                                <div class="p-2 d-flex pt-3">
                                    <div class="col-8"><b>Khung giờ: </b></div>
                                    <div class="ms-auto"><b class="text-warning">{{$appointment->appointment_hour}}</b></div>
                                </div>
                                <div class="border-top px-2 mx-2"></div>
                                <div class="p-2 d-flex pt-3">
                                    <div class="col-7"><b>Nhân viên: </b></div>
                                    <div class="ms-auto d-flex justify-content-center align-items-center">
                                        <img src="{{asset('media/employee/'.$employee->image)}}"
                                             style="object-fit: contain; width: 50px; height: 50px;"
                                             alt="{{$employee->fullname}}">
                                        &nbsp;
                                        <div class="ms-auto"><b class="text-warning">{{$employee->fullname}}</b></div>
                                    </div>
                                </div>
                                <div class="border-top px-2 mx-2"></div>
                                <div class="p-2 d-flex pt-3">
                                    <div class="col-8"><b>Dịch vụ: </b></div>
                                </div>

                                @foreach($services as $service)
                                    <div class="p-2 d-flex">
                                        <div class="col-8">{{$service->name}}</div>
                                        <div class="ms-auto">{{$service->price}}</div>
                                    </div>
                                @endforeach
                                <div class="p-2 d-flex pt-3">
                                    <div class="col-8"><b>Tổng tiền</b></div>
                                    <div class="ms-auto"><b class="text-warning">{{$payment->total}} VNĐ</b></div>
                                </div>

                                <div class="border-top px-2 mx-2"></div>
                                <div class="p-2 d-flex pt-3">
                                    <div class="col-8"><b>Hình thức thanh toán </b></div>
                                </div>
                                <div class="p-2 d-flex">
                                    <div class="col-8">{{$payment->type == 'cash' ? 'Thanh toán tại salon' : ''}}</div>
                                    <div class="ms-auto">Chưa thanh toán</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(in_array($appointment->status, [\App\Models\Appointment::$SCHEDULED]))
                    <div class="d-flex justify-content-around mb-4">
                        <a href="{{route("salon.appointment.lSchedule")}}" class="btn btn-primary">Quay trở lại</a>
                        <button class="btn btn-danger btnConfirm" data-appointment-status="cancel">Hủy lịch hẹn</button>
                        <button class="btn btn-success btnConfirm" data-appointment-status="confirmed">Xác nhận lịch hẹn</button>
                    </div>
                @endif

                @if(in_array($appointment->status, [\App\Models\Appointment::$CONFIRMED]))
                    <div class="d-flex justify-content-around mb-4">
                        <a href="{{route("salon.appointment.lConfirmed")}}" class="btn btn-primary">Quay trở lại</a>
                        <button class="btn btn-info btnConfirm" data-appointment-status="completed">Đã hoàn tất</button>
                    </div>
                @endif

                @if(in_array($appointment->status, [\App\Models\Appointment::$COMPLETED]))
                    <div class="d-flex justify-content-around mb-4">
                        <a href="{{route("salon.appointment.lCompleted")}}" class="btn btn-primary">Quay trở lại</a>
                    </div>
                @endif

                @if(in_array($appointment->status, [\App\Models\Appointment::$CANCEL]))
                    <div class="d-flex justify-content-around mb-4">
                        <a href="{{route("salon.appointment.lCancel")}}" class="btn btn-primary">Quay trở lại</a>
                    </div>
                @endif
            </div>
        </div>


    </section>


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
    <script type="module">

        $('.btnConfirm').on('click', function (event) {
            event.preventDefault();
            const status = $(this).data('appointment-status');
            $('.loading-indicator-manage').show();
            $.ajax({
                url: "{{route('salon.appointment.updateStatus')}}",
                type: 'POST',
                data: {
                    'appointment_id': '{{$appointment->appointment_id}}',
                    'status': status
                },
                success: function (resp) {
                    if(resp.success) {
                        $('.loading-indicator-manage').hide();
                        toastr["success"]("Cập nhật thành công!");
                        setTimeout(() => {
                            {{--window.location.href = '{{url()->previous()}}';--}}

                           window.location.reload();
                        }, 500)
                    } else {
                        toastr["error"]("Cập nhật thất bại!");
                    }
                },
                error: function (err) {
                    toastr["error"]("Cập nhật thất bại!");
                }
            })
        })
    </script>
@endpush
