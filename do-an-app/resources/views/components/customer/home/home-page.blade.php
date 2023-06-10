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

   <!-- Salong nổi bật  -->
   @if($outstanding)
       <section class="team recentMe container mt-5">
           <div class="card">
               <div class="sec-heading mt-3 ml-4">
                   <p style="font-weight: bold; font-size: 16px">SALON NỔI BẬT</p>
               </div>
               <div class="testimonial-box">
                   <div class="container">
                       <div class="col-lg-12 mb-4">
                           <div class="team-slider-recent owl-carousel">
                               @foreach($outstanding as $o)
                                   <div class="single-box">
                                       <div class="img-area">
                                           <a href="{{route("customer.salon-page.detail", $o->salon_id)}}">
                                               <img
                                                   src="{{asset('/media/salon/' . $o->images[0])}}"
                                                   class="img-fluid move-animation"
                                                   alt="{{$o->name}}"
                                               />
                                           </a>
                                       </div>
                                       <div class="info-area">
                                           <p>{{$o->name}}</p>
                                           <span><i class="fa-solid fa-location-dot" style="color: #c3c6d1;"></i>  {{$o->address}}, {{$o->location['address']}} </span>
                                           <span>
                                               @for($i = 0; $i < $o->stars; $i++)
                                                   <i class="fa-solid fa-star" style="color: #ffd43b; font-size: 15px;"></i>

                                               @endfor
                                           </span>
                                       </div>
                                   </div>
                               @endforeach

                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </section>
   @endif

    <!-- Salon tại Đà Nẵng -->
   @if($salonDaNang)
       <section class="team recentMe container mt-5">
           <div class="card">
               <div class="sec-heading mt-3 ml-4">
                   <p style="font-weight: bold; font-size: 16px">SALON TẠI ĐÀ NẴNG</p>
               </div>
               <div class="testimonial-box">
                   <div class="container">
                       <div class="col-lg-12 mb-4">
                           <div class="team-slider-recent owl-carousel">
                               @foreach($salonDaNang as $salon)
                                   <div class="single-box">
                                       <div class="img-area">
                                           <a href="{{route("customer.salon-page.detail", $o->salon_id)}}">
                                               <img
                                                   src="{{asset('/media/salon/'.$salon->images[0])}}"
                                                   class="img-fluid move-animation"
                                                   alt="{{$salon->name}}"
                                               />
                                           </a>

                                       </div>
                                       <div class="info-area">
                                           <p>{{$salon->name}}</p>
                                           <span><i class="fa-solid fa-location-dot" style="color: #c3c6d1;"></i> {{$salon->address}}, {{$salon->location['address']}} </span>
                                           <span>
                                               @for($i = 0; $i < $o->stars; $i++)
                                                   <i class="fa-solid fa-star" style="color: #ffd43b; font-size: 15px;"></i>
                                               @endfor
                                           </span>
                                       </div>
                                   </div>
                               @endforeach

                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </section>
   @endif



   <!-- Top Salon tại Đà Nẵng -->
   @if($top10SalonDaNang)
       <section class="team recentMe container mt-5">
           <div class="card">
               <div class="sec-heading mt-3 ml-4">
                   <p style="font-weight: bold; font-size: 16px">Top SALON TẠI ĐÀ NẴNG</p>
               </div>
               <div class="testimonial-box">
                   <div class="container">
                       <div class="col-lg-12 mb-4">
                           <div class="team-slider-recent owl-carousel">
                               @foreach($top10SalonDaNang as $salon)
                                   <div class="single-box">
                                       <div class="img-area">
                                           <a href="{{route("customer.salon-page.detail", $o->salon_id)}}">
                                               <img
                                                   src="{{asset('/media/salon/'.$salon->images[0])}}"
                                                   class="img-fluid move-animation"
                                                   alt="{{$salon->name}}"
                                               />
                                           </a>
                                       </div>
                                       <div class="info-area">
                                           <p>{{$salon->name}}</p>
                                           <span><i class="fa-solid fa-location-dot" style="color: #c3c6d1;"></i> {{$salon->address}}, {{$salon->location['address']}} </span>
                                           <span>
                                               @for($i = 0; $i < $o->stars; $i++)
                                                   <i class="fa-solid fa-star" style="color: #ffd43b; font-size: 15px;"></i>
                                               @endfor
                                           </span>
                                       </div>
                                   </div>
                               @endforeach

                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </section>
   @endif

   <!-- Bài viết -->
   @if($posts)
       <section class="team recentMe container mt-5 mb-5">
           <div class="card">
               <div class="sec-heading mt-3 ml-4">
                   <p style="font-weight: bold; font-size: 16px">BÀI VIẾT</p>
               </div>
               <div class="testimonial-box">
                   <div class="container">
                       <div class="col-lg-12">
                           <div class="team-slider-recent owl-carousel mb-3">
                               @foreach($posts as $post)
                                   <div class="single-box" style="height: 250px">
                                       <div class="img-area">
                                           <a href="{{route('customer.my-post', $post->post_id)}}">
                                               <img
                                                   style="
                                                        height: 200px;
                                                        object-fit: cover;
                                                      "
                                                   src="{{asset('media/post/' . $post->image)}}"
                                                   class="img-fluid move-animation"
                                                   alt=""
                                               />
                                           </a>
                                       </div>
                                       <div class="pl-2">
                                           <a href="{{route('customer.my-post', $post->post_id)}}"
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
                                               {{$post->title}}
                                           </a>
                                       </div>
                                   </div>
                               @endforeach

                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </section>
   @endif

@endsection
@push('scripts')
    <script src="{{asset('lib/OwlCarousel2-2.3.4/dist/owl.carousel.min.js')}}"></script>
    <script type="module" src="{{asset('js/customer/home/carousel.js')}}"></script>
@endpush
