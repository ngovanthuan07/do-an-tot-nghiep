<div class="tr-job-posted section-padding mt-4">
    <div class="container">
        <div class="job-tab text-center">
            <ul class="nav nav-tabs justify-content-center" role="tablist">
                <li role="presentation" class="active">
                    <a class="active show" href="#hot-jobs" aria-controls="hot-jobs" role="tab" data-toggle="tab" aria-selected="true">Chưa xác nhận</a>
                </li>
                <li role="presentation"><a href="#recent-jobs" aria-controls="recent-jobs" role="tab" data-toggle="tab" class="" aria-selected="false">Đã xác nhận</a></li>
                <li role="presentation"><a href="#popular-jobs" aria-controls="popular-jobs" role="tab" data-toggle="tab" class="" aria-selected="false">Đã hoàn thành</a></li>
                <li role="presentation"><a href="#cancel-jobs" aria-controls="popular-jobs" role="tab" data-toggle="tab" class="" aria-selected="false">Đã hủy</a></li>
            </ul>
            <div class="tab-content text-left">
                <div role="tabpanel" class="tab-pane fade active show" id="hot-jobs">
                    <div class="row mb-4">
                        @forelse($scheduled as $data)
                        <div class="col-md-6 col-lg-4">
                                <div class="job-item">
                                    <div class="job-info">
                                    <span class="tr-title">
										<a href="/lam-dep/{{$data->salon->salon_id}}/chi-tiet-salon"><h5>{{$data->salon->name}}</h5></a>
									</span>
                                        <ul class="tr-list job-meta">
                                            <li><span><i class="fa fa-location" aria-hidden="true"></i></span>{{$data->salon->address}}, {{$data->location['address']}}</li>
                                            <li><span><i class="fa fa-calendar" aria-hidden="true"></i></span>{{\App\Helpers\HandleDateTimePickerHelper::formatDD_MM_YY_Default($data->appointment_date)}}</li>
                                            <li><span><i class="fa fa-clock" aria-hidden="true"></i></span>{{$data->appointment_hour}}</li>
                                            <li><span><i class="fa fa-person" aria-hidden="true"></i></span>Nhân viên:  <b>{{$data->employee->fullname}}</b></li>
                                            <li>
                                                <span><i class="fa fa-list" aria-hidden="true"></i></span>Dịch vụ:
                                                <ul>
                                                    @foreach($data->services as $service)
                                                            <li>{{$service->name}}</li>
                                                    @endforeach
                                                </ul>
                                            </li>

                                            <li><span><i class="fa fa-money" aria-hidden="true"></i></span>{{$data->payment->total}} VNĐ</li>
                                        </ul>
                                        <div class="">
                                            <a href="{{route('customer.appointment.cancel', $data->appointment_id)}}" class="btn btn-warning text-center text-white">Hủy cuộc hẹn</a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        @empty
                            <div class="container text-center mb-4">Không có cuộc hẹn nào gần đây</div>
                        @endforelse
                    </div><!-- /.row -->
                </div><!-- /.tab-pane -->
                <div role="tabpanel" class="tab-pane fade in" id="recent-jobs">
                    <div class="row">
                        @forelse($confirmed as $data)
                            <div class="col-md-6 col-lg-4">
                                <div class="job-item">
                                    <div class="job-info">
                                    <span class="tr-title">
										<a href="/lam-dep/{{$data->salon->salon_id}}/chi-tiet-salon"><h5>{{$data->salon->name}}</h5></a>
									</span>
                                        <ul class="tr-list job-meta">
                                            <li><span><i class="fa fa-location" aria-hidden="true"></i></span>{{$data->salon->address}}, {{$data->location['address']}}</li>
                                            <li><span><i class="fa fa-calendar" aria-hidden="true"></i></span>{{\App\Helpers\HandleDateTimePickerHelper::formatDD_MM_YY_Default($data->appointment_date)}}</li>
                                            <li><span><i class="fa fa-clock" aria-hidden="true"></i></span>{{$data->appointment_hour}}</li>
                                            <li><span><i class="fa fa-person" aria-hidden="true"></i></span>Nhân viên:  <b>{{$data->employee->fullname}}</b></li>
                                            <li>
                                                <span><i class="fa fa-list" aria-hidden="true"></i></span>Dịch vụ:
                                                <ul>
                                                    @foreach($data->services as $service)
                                                        <li>{{$service->name}}</li>

                                                    @endforeach
                                                </ul>
                                            </li>

                                            <li><span><i class="fa fa-money" aria-hidden="true"></i></span>{{$data->payment->total}} VNĐ</li>
                                            @if(\App\Util\cancelAppointment::check($data->appointment_hour, $data->appointment_date))
                                                <div class="">
                                                    <a href="{{route('customer.appointment.cancel', $data->appointment_id)}}" class="btn btn-warning text-center text-white">Hủy cuộc hẹn</a>
                                                </div>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="container text-center mb-4">Không có cuộc hẹn nào gần đây</div>
                        @endforelse
                    </div><!-- /.row -->
                </div><!-- /.tab-pane -->
                <div role="tabpanel" class="tab-pane fade in" id="popular-jobs">
                    <div class="row">
                        @forelse($completed as $data)
                            <div class="col-md-6 col-lg-4">
                                <div class="job-item">
                                    <div class="job-info">
                                    <span class="tr-title">
										<a href="/lam-dep/{{$data->salon->salon_id}}/chi-tiet-salon"><h5>{{$data->salon->name}}</h5></a>
									</span>
                                        <ul class="tr-list job-meta">
                                            <li><span><i class="fa fa-location" aria-hidden="true"></i></span>{{$data->salon->address}}, {{$data->location['address']}}</li>
                                            <li><span><i class="fa fa-calendar" aria-hidden="true"></i></span>{{\App\Helpers\HandleDateTimePickerHelper::formatDD_MM_YY_Default($data->appointment_date)}}</li>
                                            <li><span><i class="fa fa-clock" aria-hidden="true"></i></span>{{$data->appointment_hour}}</li>
                                            <li><span><i class="fa fa-person" aria-hidden="true"></i></span>Nhân viên:  <b>{{$data->employee->fullname}}</b></li>
                                            <li>
                                                <span><i class="fa fa-list" aria-hidden="true"></i></span>Dịch vụ:
                                                <ul>
                                                    @foreach($data->services as $service)
                                                        <li>{{$service->name}}</li>

                                                    @endforeach
                                                </ul>
                                            </li>

                                            <li><span><i class="fa fa-money" aria-hidden="true"></i></span>{{$data->payment->total}} VNĐ</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="container text-center mb-4">Không có cuộc hẹn nào gần đây</div>
                        @endforelse
                    </div><!-- /.row -->
                </div><!-- /.tab-pane -->

                <div role="tabpanel" class="tab-pane fade in" id="cancel-jobs">
                    <div class="row">
                        @forelse($cancel as $data)
                            <div class="col-md-6 col-lg-4">
                                <div class="job-item">
                                    <div class="job-info">
                                    <span class="tr-title">
										<a href="/lam-dep/{{$data->salon->salon_id}}/chi-tiet-salon"><h5>{{$data->salon->name}}</h5></a>
									</span>
                                        <ul class="tr-list job-meta">
                                            <li><span><i class="fa fa-location" aria-hidden="true"></i></span>{{$data->salon->address}}, {{$data->location['address']}}</li>
                                            <li><span><i class="fa fa-calendar" aria-hidden="true"></i></span>{{\App\Helpers\HandleDateTimePickerHelper::formatDD_MM_YY_Default($data->appointment_date)}}</li>
                                            <li><span><i class="fa fa-clock" aria-hidden="true"></i></span>{{$data->appointment_hour}}</li>
                                            <li><span><i class="fa fa-person" aria-hidden="true"></i></span>Nhân viên:  <b>{{$data->employee->fullname}}</b></li>
                                            <li>
                                                <span><i class="fa fa-list" aria-hidden="true"></i></span>Dịch vụ:
                                                <ul>
                                                    @foreach($data->services as $service)
                                                        <li>{{$service->name}}</li>

                                                    @endforeach
                                                </ul>
                                            </li>

                                            <li><span><i class="fa fa-money" aria-hidden="true"></i></span>{{$data->payment->total}} VNĐ</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="container text-center mb-4">Không có cuộc hẹn nào gần đây</div>
                        @endforelse
                    </div><!-- /.row -->
                </div><!-- /.tab-pane -->

            </div>
        </div><!-- /.job-tab -->
    </div><!-- /.container -->
</div>
