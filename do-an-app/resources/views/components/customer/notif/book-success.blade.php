@extends('layouts.customer')
@section('title', 'Thông báo')
@section('content')
    <x-loading-indicator/>
    <header class="searchHeader mb-3">
    </header>
    <div style="height: 1000px"></div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="module" src="{{asset('js/customer/salon-detail/carousel.js')}}"></script>
    <script type="module" src="{{asset('js/customer/salon-detail/handleLoadHTML.js')}}"></script>
    <script type="module">
        Swal.fire({
            icon: "success",
            title: "Đặt lịch thành công!",
            text: "Bấm nút bên dưới để trở về trang chủ",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{route('customer.home')}}";
            }
        });
    </script>
@endpush
