@extends('layouts.customer')
@section('title', 'Salon')
@push('pushLink')
    <link rel="stylesheet" href="{{asset('lib/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/customer/search/styles.css')}}">
@endpush
@section('content')
   <x-loading-indicator />
   <header class="searchHeader">

   </header>

   <div class="container-fluid mb-3 mt-3">
       <div class="row flex-xl-nowrap">
           <div class="col-12 col-md-3 col-xl-3 bd-sidebar">
               <div class="card">
                   <div class="titleFilter">
                       <span id="nameFillterSalon">Tìm kiếm</span>
                   </div>
                   <div class="content-search">
                       <div class="findNameSalon">
                           <span class="searchFieldTitle">Tìm kiếm salon theo tên</span>
                           <div class="detailFindNameSalon">
                               <i class="fa-solid fa-magnifying-glass iconDetailFindNameSalon"></i>
                               <input type="text" id="salonName" class="inputDetailFindNameSalon" placeholder="Tìm kiếm theo tên Salon">
                           </div>
                       </div>
                       <div class="findNameSalon">
                           <span class="searchFieldTitle">Tìm kiếm salon theo dịch vụ</span>
                           <div class="detailFindNameSalon">
                               <i class="fa-solid fa-list iconDetailFindNameSalon"></i>
                               <select id="serviceName" class="browser-default custom-select">
                                   <option value="">Tất cả dịch vụ</option>
                                   @foreach($services as $service)
                                       <option value="{{$service->name}}">{{$service->name}}</option>
                                   @endforeach
                               </select>

                           </div>
                       </div>
                       <div class="findNameSalon">
                           <span class="searchFieldTitle">Tìm kiếm salon theo địa chỉ</span>
                           <div class="detailFindNameSalon">
                               <i class="fa-solid fa-city iconDetailFindNameSalon"></i>
                               <select id="province" class="browser-default custom-select">
                                   <option value="">Chọn tỉnh, thành phố</option>
                                   @foreach($provinces as $province)
                                       <option value="{{$province->code}}">{{$province->full_name}}</option>
                                   @endforeach
                               </select>
                           </div>
                           <br>
                           <div class="detailFindNameSalon">
                               <i class="fa-solid fa-school iconDetailFindNameSalon"></i>
                               <select id="district" class="browser-default custom-select">
                                   <option value="">Chọn quận, huyện</option>
                               </select>
                           </div>
                           <br>
                           <div class="detailFindNameSalon">
                               <i class="fa-solid fa-location-dot iconDetailFindNameSalon"></i>
                               <select id="ward" class="browser-default custom-select">
                                   <option value="">Chọn xã, thị trấn</option>
                               </select>
                           </div>
                       </div>
                       <div class="findStar findNameSalon">
                           <div>
                               <span class="searchFieldTitle">Xếp hạng sao</span>
                               <div class="con">
                                   <i class="fa-solid fa-star rate" data-value="1"></i>
                                   <i class="fa-solid fa-star rate" data-value="2"></i>
                                   <i class="fa-solid fa-star rate" data-value="3"></i>
                                   <i class="fa-solid fa-star rate" data-value="4"></i>
                                   <i class="fa-solid fa-star rate" data-value="5"></i>
                               </div>
                           </div>
                       </div>

                       <div class="boxBtn">
                           <button class="btn buttonSearch">
                               Tìm kiếm
                           </button>
                       </div>
                   </div>
               </div>
           </div>
           <main class="col-12 col-md-9 col-xl-9 bd-content" >
               <div class="row result-find">
                   <span id="resultSearch"></span>
               </div>
               <div class="row list-item-salon">

               </div>

{{--               <div class="mutiSalonBtn">--}}
{{--                   <button class="btn">--}}
{{--                       <span> Xem nhiều hơn</span>--}}
{{--                   </button>--}}
{{--               </div>--}}
           </main>
       </div>



   </div>


@endsection
@push('scripts')
    <script src="{{asset('lib/OwlCarousel2-2.3.4/dist/owl.carousel.min.js')}}"></script>
    <script type="module" src="{{asset('js/customer/home/carousel.js')}}"></script>
    <script type="module">
        import {searchResult} from './js/customer/searchable/search-item.js';
        import {getByProvince, getByDistrict} from '/js/common/vn-public-api.js'
        let star = 0;
        $(document).ready(function () {
            $(".rate").click(function () {
                let val = $(this).data("value");
                $(".rate").css("color", "#000");
                if (star !== val) {
                    for(let i = 1; i <= val; i++) {
                        $(`.rate[data-value=${i}]`).css("color", "#FFCC33");
                    }
                    star = val;
                } else {
                    star = 0;
                }
            })
        })

        $('#province').on('change',  function (event) {
            let selectedValue = $(this).val();
            $('#district').html('')
            $('#ward').html('')
            getByProvince(selectedValue)
                .then(data => {
                    const districts = data;
                    const optionDistricts = districts.map(district => {return `
                        <option value="${district.code}">${district.name}</option>
                    `
                    })

                    optionDistricts.unshift(`<option value="0" selected>CHỌN QUẬN HUYỆN</option>`)

                    // selectCity
                    $('#district').html(optionDistricts.join(''))
                })
                .catch(err => {
                    console.log('error', err)
                })
        })

        $('#district').on('change', function() {
            // Lấy giá trị đã chọn trong Select2
            let selectedValue = $(this).val();
            $('#ward').html('')
            getByDistrict(selectedValue)
                .then(data => {
                    const wards = data;
                    const optionWards = wards.map(ward => {
                        return `
                    <option value="${ward.code}">${ward.name}</option>
                `
                    })

                    optionWards.unshift(`<option value="0" selected>CHỌN QUẬN HUYỆN</option>`)

                    // selectCity
                    $('#ward').html(optionWards.join(''))
                })
                .catch(err => {
                    console.log('error', err)
                })
        });

        function loadData() {
            let newData = {
                'salonName': $('#salonName').val().trim() ?? null,
                'serviceName':  $('#serviceName').val() ?? null,
                'province': $('#province').val() ?? null,
                'district': $('#district').val() ?? null,
                'ward': $('#ward').val() ?? null,
                'star': star
            }
            console.log(newData)
            $.ajax({
                type: 'GET',
                url: '{{route('customer.salon.searchable')}}',
                data: newData,
                success: function (resp) {
                    $('.list-item-salon').html(searchResult(resp));
                    $('#resultSearch').html(`Có ${resp.length} kết quả tìm kiếm`)
                },
                error: function (err) {

                }

            });
        }
        loadData()

        $('.buttonSearch').on('click', function (event) {
           event.preventDefault();
            loadData()
        })
    </script>
@endpush
