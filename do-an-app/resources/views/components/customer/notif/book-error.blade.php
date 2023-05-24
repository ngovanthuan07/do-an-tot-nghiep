@extends('layouts.customer')
@section('title', 'Thông báo')
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


    <input type="hidden" id="salon_id" name="salon_id" value="{{$salon->salon_id}}">

@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="module" src="{{asset('js/customer/salon-detail/carousel.js')}}"></script>
    <script type="module" src="{{asset('js/customer/salon-detail/handleLoadHTML.js')}}"></script>
    <script type="module">
        Swal.fire({
            icon: "success",
            title: "Đặt lịch thành công",
            text: "Đăng nhập thành công!",
            allowOutsideClick: false

        })
    </script>
@endpush
