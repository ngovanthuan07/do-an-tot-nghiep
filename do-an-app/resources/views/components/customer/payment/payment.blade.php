@extends('layouts.customer')
@section('title', 'Chi tiết salon')
@push('pushLink')
    <link rel="stylesheet" href="{{asset('lib/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/load/a-ball-pulse-sync.css')}}">
    <link rel="stylesheet" href="{{asset('css/customer/salon-detail/styles-book.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('css/time-picker/custom-theme.css')}}">
@endpush
@section('content')
    <x-loading-indicator/>
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center pb-5">
                        <div class="col-md-7 col-xl-5 mb-4 mb-md-0">
                            <div class="py-4 d-flex flex-row">
                                <h5><span class="far fa-check-square pe-2"></span> &ensp; <b>Thanh toán</b></h5>
                            </div>

                            <div class="form-outline mb-4">
                                <label class="order-form-label">Số điện thoại:</label>
                                <input type="text" id="phone" name="phone" value="{{$customer->phone}}" class="form-control order-form-input" placeholder="Số điện thoại đặt lịch"/>
                            </div>

                            <div class="rounded d-flex" style="background-color: #f8f9fa;">
                                <div class="p-2">Chấp nhận thanh toán</div>
                                <div class="ms-auto p-2"></div>
                            </div>
                            <hr />
                            <div class="pt-2">
                                <form class="pb-3">
                                    <div class="d-flex flex-row pb-3">
                                        <div class="d-flex align-items-center pe-2">
                                            <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel1"
                                                   value="" aria-label="..." checked />
                                        </div>
                                        <div class="rounded border d-flex w-100 p-3 align-items-center">
                                            <p class="mb-0">
                                                <img src="{{asset('media/logo/momo.svg')}}" class="img-fluid"  alt="momo">
                                                Thanh toán bằng MOMO
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row pb-3">
                                        <div class="d-flex align-items-center pe-2">
                                            <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel2"
                                                   value="" aria-label="..." />
                                        </div>
                                        <div class="rounded border d-flex w-100 p-3 align-items-center">
                                            <p class="mb-0">
                                                <img src="{{asset('media/logo/vnpay.png')}}" class="img-fluid"  alt="vnpay">
                                                Thanh toán bằng VNPAY
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row">
                                        <div class="d-flex align-items-center pe-2">
                                            <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel3"
                                                   value="" aria-label="..." />
                                        </div>
                                        <div class="rounded border d-flex w-100 p-3 align-items-center">
                                            <p class="mb-0">
                                                <img src="{{asset('media/logo/contactless.png')}}" class="img-fluid"  alt="vnpay">
                                                Thanh toán khi hoàn thành dịch vụ
                                            </p>
                                        </div>
                                    </div>
                                </form>
                                <input type="button" value="Tiến hành thanh toán" class="btn btn-warning btn-block btn-lg text-white"/>
                            </div>
                        </div>

                        <div class="col-md-5 col-xl-4 offset-xl-1">
                            <div class="py-4 d-flex justify-content-end">
                                <h6><a href="{{url()->previous()}}">Quay trở lại</a></h6>
                            </div>
                            <div class="rounded d-flex flex-column p-2" style="background-color: #f8f9fa;">
                                    <div class="p-2 me-3">
                                        <h4>Chi tiết dịch vụ</h4>
                                    </div>
                                    <div class="border-top px-2 mx-2"></div>
                                    <div class="p-2 d-flex pt-3">
                                        <div class="col-8"><b>Ngày đặt lịch: </b></div>
                                        <div class="ms-auto"><b class="text-warning">{{$order['date']}}</b></div>
                                    </div>
                                    <div class="border-top px-2 mx-2"></div>
                                    <div class="p-2 d-flex pt-3">
                                        <div class="col-8"><b>Khung giờ: </b></div>
                                        <div class="ms-auto"><b class="text-warning">{{$order['time_slot']}}</b></div>
                                    </div>
                                    <div class="border-top px-2 mx-2"></div>
                                    <div class="p-2 d-flex pt-3">
                                        <div class="col-7"><b>Nhân viên: </b></div>
                                        <div class="ms-auto text-center">
                                            <img src="{{asset('media/employee/'.$order['employee']->image)}}"
                                                 style="object-fit: contain; width: 50px; height: 50px;"
                                                 alt="{{$order['employee']->fullname}}">
                                            <div class="ms-auto"><b class="text-warning">{{$order['employee']->fullname}}</b></div>
                                        </div>
                                    </div>
                                    <div class="border-top px-2 mx-2"></div>
                                    <div class="p-2 d-flex pt-3">
                                        <div class="col-8"><b>Dịch vụ: </b></div>
                                    </div>

                                    @foreach($order['services'] as $service)
                                        <div class="p-2 d-flex">
                                            <div class="col-8">{{$service->name}}</div>
                                            <div class="ms-auto">{{$service->price}}</div>
                                        </div>
                                    @endforeach
                                    <div class="p-2 d-flex pt-3">
                                        <div class="col-8"><b>Tổng tiền</b></div>
                                        <div class="ms-auto"><b class="text-warning">{{$order['total_price']}}</b></div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{asset('lib/momentjs/moment.js')}}"></script>
    <script type="module">
    </script>
@endpush
