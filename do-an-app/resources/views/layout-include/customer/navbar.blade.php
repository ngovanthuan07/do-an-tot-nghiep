<nav class="navbar navbar-expand-lg navbar-light bg-white salonBar">
    <a class="navbar-brand font-weight-bold" href="{{route('customer.home')}}">VNSalon</a>
    <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto salonBarLeft">
            <li class="nav-item">
                <a class="nav-link {{request()->is('/*') ? 'active' : ''}}" href="{{route('customer.home')}}">Trang chủ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{request()->is('lam-dep*') ? 'active' : ''}}" href="{{route('customer.salon.search_view')}}">Salon </a>
            </li>

{{--            <li class="nav-item">--}}
{{--                <a class="nav-link {{request()->is('tin-tuc*') ? 'active' : ''}}" href="#">Tin tức</a>--}}
{{--            </li>--}}
        </ul>

        <ul class="navbar-nav salonBarRight my-2 my-lg-0">
            @if(\Illuminate\Support\Facades\Auth::guard('customer')->check())
                <li class="mr-2 text-center">
                    <a href="{{route('customer.profile')}}">
                        <img style="width: 35px; height: 35px; object-fit: cover; border-radius: 50%" src="{{\Illuminate\Support\Facades\Auth::guard('customer')->user()->image}}" alt="{{\Illuminate\Support\Facades\Auth::guard('customer')->user()->email}}">
                    </a>
                </li>
                <li>
                    <a href="{{route('customer.logout')}}" class="btn btn-warning">
                        <span class="font-weight-bold">Đăng xuất</span>
                    </a>
                </li>
            @else
                <li>
                    <button id="btnLogin" href="" class="btn btn-warning">
                        <span class="font-weight-bold">Đăng nhập</span>
                    </button>
                </li>
            @endif

        </ul>
    </div>
</nav>
