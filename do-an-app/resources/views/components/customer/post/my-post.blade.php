@extends('layouts.customer')
@section('title', 'Bài viết')
@push('pushLink')
    <link rel="stylesheet" href="{{asset('lib/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/customer/home/styles.css')}}">
@endpush
@section('content')
    <x-loading-indicator />
    <header class="searchHeader mb-3"
            style=" width: 100%;
            height: 30px;
            background-color: #FFCC33;"
    >

    </header>
    <div class="container">
        <h1 class="text-center">{{$post->title}}</h1>

        <div class="content">
            {!! $post->content !!}
        </div>
    </div>

@endsection
