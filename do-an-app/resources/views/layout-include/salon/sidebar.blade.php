<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('backend/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Admin</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font lib -->
                {{--  Loại dịch vụ--}}
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link {{request()->is('salon/category-service*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-cutlery"></i>
                        <p>
                            Loại dịch vụ
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('salon.categoryservice.display-all')}}" class="nav-link {{request()->is('salon/category-service/display-category-service-all') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách loại dịch vụ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('salon.categoryservice.displayAdd')}}" class="nav-link {{request()->is('salon/category-service/display-add') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm loại dịch vụ</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{--  Dịch vụ--}}

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link {{request()->is('salon/service*') ? 'active' : ''}}">
                        <i class="nav-icon far fa-solid fa-bell-concierge"></i>
                        <p>
                            Dịch vụ
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('salon.service.displayServices')}}" class="nav-link {{request()->is('salon/service/displayServices') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách dịch vụ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('salon.service.displayAdd')}}" class="nav-link {{request()->is('salon/service/display-add') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm dịch vụ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Nhân viên --}}
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link {{request()->is('salon/service*') ? 'active' : ''}}">
                        <i class="nav-icon far fa-people-group"></i>
                        <p>
                            Nhân viên
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('salon.service.displayServices')}}" class="nav-link {{request()->is('salon/service/displayServices') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách dịch vụ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('salon.service.displayAdd')}}" class="nav-link {{request()->is('salon/service/display-add') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm dịch vụ</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item menu-open">
                    <a href="{{route('salon.logout')}}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
