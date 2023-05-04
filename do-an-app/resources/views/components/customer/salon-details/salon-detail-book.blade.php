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
    <header class="searchHeader mb-3">

    </header>
    <!-- carousel -->
    <div class="container card mt-3">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 working-date-container">
                <div class="working-date-item-1 mt-1">
                    <div class="d-flex align-items-center justify-content-center w-100">
                        <input type="text" id="workingDate" altInput="true" altFormat="F j, Y" hidden>
                    </div>
                </div>
                <div id="lWorkingDate" class="working-date-item-2 mt-2 mb-3">
                    <button class="button-working-date-value-empty">Không có khung giờ nào gần đây</button>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8">
                <div id="lEmployee" class="employee-container">
                    <div class="employee-item-empty">
                        <p>Không tìm thấy nhân viên nào ⚠️</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container cart-service-container card mb-2 mt-2 mb-1">
        <div class="cart-service-component-left ">
            <div class="cart-service-item mt-3 mb-3 ml-1 d-flex">
                <div class="cart-service-icon">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <div class="cart-service-price ml-3">
                    <span class="cart-service-price-item">0</span> đ
                </div>
                <div class="cart-service-desc ml-3">
                    <span class="cart-service-desc-item">0 </span> <span>có dịch vụ nào được chọn</span>
                </div>
            </div>
        </div>
        <div class="cart-service-component-right">
            <button id="btnAppointmentServiceContinue" class="cart-service-right-button">Thanh toán</button>
        </div>
    </div>


    @include('widgets.modal.create-service-choose-modal')



    <input type="hidden" id="salon_id" name="salon_id" value="{{$salon->salon_id}}">

@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{asset('lib/momentjs/moment.js')}}"></script>
    <script type="module">
        import {fetchCategoryService, loadModalServices} from '{{asset('js/customer/salon-detail/handleLoadHTML.js')}}'
        import {getServicesByIds, getTotalPrice, getAllServiceIDs, removeService, findIndexes} from '{{asset('js/customer/salon-detail/HandleService.js')}}'
        import {handleLocalStorage} from '{{asset('js/helper/local-storage.js')}}'
        import {loadWordDate, loadEmployeeWord} from '{{asset('js/customer/salon-detail/handleLoadAPIBook.js')}}'
        const LOCAL_NAME = 'APPOINTMENT';
        let salonID = $('#salon_id').val();
        let serviceIDs = [];
        let mServices = [];
        let storageLocal = handleLocalStorage(LOCAL_NAME) ?? null;
        let mDate = '';
        let mTimeSlot = '';
        let mEmployee = null;
        let isCheckLocalStorage = true;

        if(storageLocal) {
            if(storageLocal.salon_id === salonID) {
                if(Array.isArray(storageLocal.services) && storageLocal.services.length > 0) {
                    mServices = storageLocal.services;
                    serviceIDs = getAllServiceIDs(mServices)
                    $('.cart-service-price-item').text(getTotalPrice(mServices));
                    $('.cart-service-desc-item').text(serviceIDs.length);
                    isCheckLocalStorage = false;
                }
            }
        }

        if (isCheckLocalStorage) {
            handleLocalStorage(LOCAL_NAME, null)
        }

        var isDragging = false;
        var startPosition = null;

        function restartData() {
            mDate = '';
            mTimeSlot = '';
            mEmployee = '';
        }

        $('.employee-container').on('mousedown', function(e) {
            e.preventDefault();
            isDragging = true;
            startPosition = e.pageX;
        });

        $(document).on('mouseup', function(e) {
            if (isDragging) {
                e.preventDefault();
                isDragging = false;
            }
        });

        $(document).on('mousemove', function(e) {
            if (isDragging) {
                e.preventDefault();
                var distance = e.pageX - startPosition;
                $('.employee-container').scrollLeft($('.employee-container').scrollLeft() - distance);
                startPosition = e.pageX;
            }
        });

        const optional_config = {
            inline: true,
            static: true, // Thêm tùy chọn này để Flatpickr cập nhật lại kích thước khi kích thước của phần tử chứa thay đổi
            width: "100%", // Thiết lập chiều rộng mặc định của inline picker
            onReady: function(selectedDates, dateStr, instance) {
                // Lấy đối tượng div chứa picker
                const container = instance._input.parentNode.parentNode;

                // Đảm bảo rằng picker đáp ứng độ rộng của phần tử chứa của nó
                container.style.minWidth = instance._input.offsetWidth + "px";
            }
        };

        $("#workingDate").flatpickr(optional_config);


        $('#workingDate').on('change', function() {
            restartData()
            mDate = $(this).val();
            const date = moment(mDate, 'YYYY-MM-DD');
            if(date.isSameOrAfter(moment(), 'day')) {
                loadWordDate(mDate, salonID);
            } else {
                mDate = '';
                Swal.fire({
                    icon: 'info',
                    title: 'Vui lòng chọn ngày hiện tại trở về sau',
                })
            }
        })


        $('#lWorkingDate').on('click', '.button-working-date-value', function (event) {
            event.preventDefault();
            mEmployee = null;
            $('.button-working-date-value').removeClass('active');
            $(this).addClass('active');
            mTimeSlot = $(this).text()
            if(mDate) {
                loadEmployeeWord(mTimeSlot, mDate, salonID);
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Vui lòng chọn ngày đặt lịch',
                })
            }
        } )

        $('#lEmployee').on('click', '.button-employee-value', function (event) {
            event.preventDefault();
            $('.button-employee-value').removeClass('active');
            $(this).addClass('active');
            mEmployee = $(this).data('employee-id');
        })

        $('.cart-service-container').on('dblclick', function () {
            $('#serviceChooseModal').modal('show');
            $('#tbodyService').html(loadModalServices(mServices));
            $('#totalServiceTable').text(getTotalPrice(mServices));
        });

        $('#tbodyService').on('click', '.service-table', function (event) {
            event.preventDefault();

            mServices = removeService(mServices, $(this).data('service-table-id'));
            $('#tbodyService').html(loadModalServices(mServices));
            $('#totalServiceTable').text(getTotalPrice(mServices));
        });

        $('#serviceChooseModal').on('hidden.bs.modal', function (e) {
            serviceIDs = getAllServiceIDs(mServices)
            $('.cart-service-desc-item').text(serviceIDs.length);
            $('.cart-service-price-item').text(getTotalPrice(mServices));
            handleLocalStorage(LOCAL_NAME, {
                'salon_id': salonID,
                'services': mServices,
            });
        });

        $('#btnAppointmentServiceContinue').on('click', function () {
            if(mServices.length < 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cảnh báo',
                    text: 'Không có dịch vụ nào gần đây',
                    confirmButtonColor: "#fdc63c",
                })
                return;
            }
            if(!mDate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Vui lòng chọn ngày đặt lịch',
                })
                return;
            }
            if(!mTimeSlot) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Vui lòng chọn khung giờ đặt lịch',
                })
                return;
            }
            if(!mEmployee) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Vui lòng chọn nhân viên',
                })
                return;
            }
            $.ajax({
                url: '{{route('customer.salon-page.book.sessionPayment', $salon->salon_id)}}',
                type: 'POST',
                data: {
                    'service_ids': serviceIDs,
                    'employee_id': mEmployee,
                    'time_slot': mTimeSlot,
                    'date': mDate,
                    'salon_id': salonID
                },
                success: function (response) {
                    if(response.success) {
                        window.location.href = response.redirect;
                    }
                },
                error: function (error) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Lỗi',
                        text: 'Lỗi hệ thống',
                        confirmButtonColor: "#fdc63c",
                    })
                },
            });
        })
    </script>
@endpush
