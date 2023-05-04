@extends('layouts.customer')
@section('title', 'Trang chủ')
@push('pushLink')
    <link rel="stylesheet" href="{{asset('lib/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/customer/home/styles.css')}}">
@endpush
@section('content')
   <x-loading-indicator />
    <div
        id="carouselExampleControls"
        class="carousel slide"
        data-ride="carousel"
    >
        <div class="carousel-inner">
            @for($i=1; $i <= 7; $i++)
                <div class="carousel-item {{$i==1 ? 'active' : ''}}">
                    <img
                        style="height: 436px; width:auto;object-fit: cover"
                        class="d-block w-100"
                        src="{{asset('media/empty/slide/' . $i . '.jpg' )}}"
                        alt="First slide"
                    />
                </div>
            @endfor


        </div>
        <a
            class="carousel-control-prev"
            href="#carouselExampleControls"
            role="button"
            data-slide="prev"
        >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a
            class="carousel-control-next"
            href="#carouselExampleControls"
            role="button"
            data-slide="next"
        >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Gần tôi nhất -->

    <section class="team recentMe container mt-5">
        <div class="card">
            <div class="sec-heading mt-3 ml-4">
                <p style="font-weight: bold; font-size: 16px">GẦN TÔI NHẤT</p>
            </div>
            <div class="testimonial-box">
                <div class="container">
                    <div class="col-lg-12">
                        <div class="team-slider-recent owl-carousel">
                            @for($i=0; $i < 8; $i++)
                                <div class="single-box">
                                    <div class="img-area">
                                        <img
                                            src="{{'/media/empty/salon/4.jpg'}}"
                                            class="img-fluid move-animation"
                                            alt=""
                                        />
                                    </div>
                                    <div class="info-area">
                                        <p>ThangLee Hair Salon</p>
                                        <span><i class="fa-solid fa-location-dot" style="color: #c3c6d1;"></i> 02 Thanh Sơn, Thanh Bình Hải Châu, Đà Nẵng </span>
                                        <span style="color: black;"><i class="fa-solid fa-street-view" style="color: black;"></i> 1 Km</span>
                                    </div>
                                </div>
                            @endfor

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Salon -->
    <section class="team recentMe container mt-5">
        <div class="card">
            <div class="sec-heading mt-3 ml-4">
                <p style="font-weight: bold; font-size: 16px">TOP SALON TẠI ĐÀ NẴNG</p>
            </div>
            <div class="testimonial-box">
                <div class="container">
                    <div class="col-lg-12">
                        <div class="team-slider-recent owl-carousel">
                            @for($i=0; $i < 8; $i++)
                                <div class="single-box">
                                <div class="img-area">
                                    <img
                                        src="{{asset('media/empty/salon/2.jpg')}}"
                                        class="img-fluid move-animation"
                                        alt=""
                                    />
                                </div>
                                <div class="info-area">
                                    <p>ThangLee Hair Salon</p>
                                    <span><i class="fa-solid fa-location-dot" style="color: #c3c6d1;"></i> 02 Thanh Sơn, Thanh Bình Hải Châu, Đà Nẵng </span>
                                    <span style="color: black;"><i class="fa-solid fa-street-view" style="color: black;"></i> 1 Km</span>
                                </div>
                            </div>
                            @endfor

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sản phẩm bán chạy -->
    <!-- Top Salon -->
    <section class="team product-section container mt-5">
        <div class="card">
            <div class="sec-heading mt-3 ml-4">
                <p style="font-weight: bold; font-size: 16px">TOP SẢN PHẨM BÁN CHẠY</p>
            </div>
            <div class="testimonial-box">
                <div class="container">
                    <div class="col-lg-12">
                        <div class="product-slider owl-carousel">
                            @for($i=0; $i < 8; $i++)
                                <div class="single-box">
                                <div class="img-area">
                                    <img src="{{asset('media/empty/product/4.png')}}" alt=""/>
                                    <span>30%</span>
                                </div>
                                <div class="info-area">
                                    <span class="productBrand">Brand</span>
                                    <span class="productName">Dầu gội Diamond chăm sóc tóc bóng mượt 2018</span>
                                    <div class="priceProceBox">
                                        <span class="productPrice">430,000 đ</span>
                                        <span class="productPriceRemove">430,000 đ</span>
                                    </div>
                                    <div class="buyProduct">
                                        <a  href="">
                                            Mua ngay
                                        </a>
                                        <i class="fa-solid fa-arrow-right" style="color: #000000;"></i>
                                    </div>
                                </div>
                            </div>
                            @endfor

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bài viết -->
    <section class="team recentMe container mt-5 mb-5">
        <div class="card">
            <div class="sec-heading mt-3 ml-4">
                <p style="font-weight: bold; font-size: 16px">BÀI VIẾT</p>
            </div>
            <div class="testimonial-box">
                <div class="container">
                    <div class="col-lg-12">
                        <div class="team-slider-recent owl-carousel mb-3">
                            @for($i=0; $i < 4; $i++)
                                <div class="single-box">
                                <div class="img-area">
                                    <img
                                        style="
                        height: 200px;
                        object-fit: cover;
                      "
                                        src="{{asset('media/empty/write/' . ($i + 1) . '.jpg')}}"
                                        class="img-fluid move-animation"
                                        alt=""
                                    />
                                </div>
                                <div class="pl-2">
                                    <a href=""
                                       style="
                          text-decoration: none;
                          color: inherit;
                          background-color: transparent;
                          font-weight: bold;
                          font-size: 13px;
                          line-height: 1.5em;
                          display: -webkit-box;
                          -webkit-line-clamp: 2;
                          -webkit-box-orient: vertical;
                         ">
                                        Fashion Reality Technical Seminar Farmagan sẽ được tổ chức tại Việt Nam vào tháng 5 tới
                                    </a>
                                </div>
                            </div>
                            @endfor

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{asset('lib/OwlCarousel2-2.3.4/dist/owl.carousel.min.js')}}"></script>
    <script type="module" src="{{asset('js/customer/home/carousel.js')}}"></script>
@endpush
