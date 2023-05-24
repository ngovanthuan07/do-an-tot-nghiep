@extends('layouts.customer')
@section('title', 'Chi tiết salon')
@push('pushLink')
    <link rel="stylesheet" href="{{asset('lib/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/load/a-ball-pulse-sync.css')}}">
    <link rel="stylesheet" href="{{asset('css/customer/salon-detail/styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/customer/salon-detail/styles-resp.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('css/time-picker/custom-theme.css')}}">
@endpush
@section('content')
    <x-loading-indicator/>
    <header class="searchHeader mb-3">

    </header>
    <!-- carousel -->
    <div class="container">
        <div class="owl-carousel owl-theme">
            @if($salon->images != null && $salon->images != '')
                @foreach($salon->images as $index=>$image)
                    <div class="item">
                        <img
                            src="{{asset('media/salon/'.$image->src)}}"
                            alt="{{$salon->name . '-' . $index}}"
                        >
                    </div>
                @endforeach

            @else
                @for($i = 1; $i <= 10; $i++)
                    <div class="item">
                        <img
                            src="{{asset('media/empty/salon/' . $i . '.jpg')}}"
                            alt="{{'empty-img-' . $i}}"
                        >
                    </div>
                @endfor
            @endif

        </div>
    </div>
    <div class="container">
        <div class="salon-info">
            <div class="salon-info-name">
                <p>{{$salon->name}}</p>
            </div>
            <div class="location">
                <p class="location-address">{{$salon->address}}, {{$salon->location['address']}}</p>
                <p class="location-address-detail"><a href="">Chi tiết địa điểm</a></p>
            </div>

            <div class="time-work">
                <span>Thời gian mở</span>
                <span>{{$salon->time_working_desc}}</span>
                <span>{{$salon->time_slot_desc}}</span>
            </div>

            <div class="desc">
                <div class="btn-link intro" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                     aria-controls="collapseOne">
                    Giới thiệu <i class="fa-solid fa-arrow-down"></i>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        {{$salon->description}}
                    </div>
                </div>
            </div>

        </div>

    </div>
    </div>

    <div class="container card category-service-container mb-2">
        <div class="category-service-title">
            <div class="title-item">Dịch vụ</div>
        </div>
        <div class="category-service-menu button-category-services">
            @foreach($salon->categoryService as $cse)
                <button class="button-category-service-value"
                        data-category-service-id="{{$cse->cse_id}}">{{$cse->name}}</button>
            @endforeach
        </div>
    </div>

    <div id="list-services" class="container card services-container mb-2">
        <div class="services-container-empty">
            <p> Không có dữ liệu</p>
        </div>
    </div>

    <div class="container cart-service-container card mb-2">
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
            <button id="btnAppointmentServiceContinue" class="cart-service-right-button">Tiếp tục</button>
        </div>
    </div>

    @include('components.customer.salon-details.comment')

    @include('widgets.modal.create-service-choose-modal')



    <input type="hidden" id="salon_id" name="salon_id" value="{{$salon->salon_id}}">

@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{asset('lib/OwlCarousel2-2.3.4/dist/owl.carousel.min.js')}}"></script>
    <script type="module" src="{{asset('js/customer/salon-detail/carousel.js')}}"></script>
    <script type="module" src="{{asset('js/customer/salon-detail/handleLoadHTML.js')}}"></script>
    <script type="module">
        import {fetchCategoryService, loadModalServices} from '{{asset('js/customer/salon-detail/handleLoadHTML.js')}}'
        import {getServicesByIds, getTotalPrice, getAllServiceIDs, removeService, findIndexes} from '{{asset('js/customer/salon-detail/HandleService.js')}}'
        import {handleLocalStorage} from '{{asset('js/helper/local-storage.js')}}'
        import {loginForm, handleLoginForm} from '{{asset('js/customer/login/login-form.js')}}';
        const LOCAL_NAME = 'APPOINTMENT';
        let categorySerIDChoose = '';
        let salonID = $('#salon_id').val();
        let categoryServices = <?php echo $salon->categoryService ?>;
        let indexCategoryServices = null;
        let serviceIDs = [];
        let lServices = <?php echo $services ?>;
        let mServices = [];
        let storageLocal = handleLocalStorage(LOCAL_NAME) ?? null;

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

        categoryServices = categoryServices.map(item => {
            return {
                'cse_id': item.cse_id,
                'serviceIds': getAllServiceIDs(item.services),
                'isSelect': item.isSelect
            }
        });

        function findIndexByCseId(categoryServices, my_cse_id) {
            return categoryServices.findIndex(item => item.cse_id === my_cse_id);
        }

        $('.button-category-service-value').on('click', function (event) {
            event.preventDefault();
            $('.button-category-service-value').removeClass('active');
            $(this).addClass('active');
            categorySerIDChoose = $(this).data('category-service-id');
            indexCategoryServices = findIndexByCseId(categoryServices, categorySerIDChoose);
            fetchCategoryService(salonID, categorySerIDChoose,serviceIDs)
        })

        function selectCategoryServiceItem(me, isOneSelect) {
            let elementID = $(me).data('service-id');
            if (serviceIDs.includes(elementID)) {
                serviceIDs = serviceIDs.filter(item => item != elementID);
                $(me).removeClass('active');
            } else {
                $(me).addClass('active');
                if(isOneSelect) {
                    serviceIDs = serviceIDs.filter(element => !categoryServices[indexCategoryServices].serviceIds.includes(element));
                }
                serviceIDs = [...serviceIDs, elementID]
            }
        }

        $('#list-services').on('click', '.service-select', function (event) {
            if(categoryServices[indexCategoryServices].isSelect < 2) {
                $('.service-select').removeClass('active');
                selectCategoryServiceItem(this, true)
            } else {
                selectCategoryServiceItem(this, false)
            }
            console.log(serviceIDs)
            $('.cart-service-desc-item').text(serviceIDs.length);
            mServices = getServicesByIds(lServices, serviceIDs)
            $('.cart-service-price-item').text(getTotalPrice(mServices));

            handleLocalStorage(LOCAL_NAME, {
                'salon_id': salonID,
                'services': mServices,
            });
        });

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
            mServices = getServicesByIds(lServices, serviceIDs);
            $('.cart-service-price-item').text(getTotalPrice(mServices));
            fetchCategoryService(salonID, categorySerIDChoose,serviceIDs);
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
                    text: 'Vui lòng chọn dịch vụ',
                    confirmButtonColor: "#fdc63c",
                })
                return;
            }
            @if(\Illuminate\Support\Facades\Auth::guard('customer')->check())
                @if(!\Illuminate\Support\Facades\Auth::guard('customer')->user()->phone)
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cảnh báo',
                        text: 'Vui lòng cập nhật số điện thoại trong trang cá nhân',
                        confirmButtonColor: "#fdc63c",
                    })
                    return;
                @endif
            @else
                loginForm();
                return;
            @endif

                window.location.href = "{{route('customer.salon-page.book', $salon->salon_id)}}";
        })
    </script>
@endpush
