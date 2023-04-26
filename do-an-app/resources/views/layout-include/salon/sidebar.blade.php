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
                    <a href="#" class="nav-link {{request()->is('salon/employee*') ? 'active' : ''}}">
                        <i class="nav-icon fa fa-people-group"></i>
                        <p>
                            Nhân viên
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('salon.employee.displayEmployees')}}" class="nav-link {{request()->is('salon/employee/displayEmployees') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách nhân viên</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('salon.employee.displayAdd')}}" class="nav-link {{request()->is('salon/employee/display-add') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm nhân viên</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('salon.employee.work-schedule')}}" class="nav-link {{request()->is('salon/employee/work-schedule') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Khung giờ làm việc</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Giờ làm việc --}}
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link {{request()->is('salon/schedule*') ? 'active' : ''}}">
                        <i class="nav-icon far fa-clock"></i>
                        <p>
                            Giờ làm việc
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('salon.schedule.work-schedule')}}" class="nav-link {{request()->is('salon/schedule/work-schedule') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Giờ làm việc salon</p>
                            </a>
                        </li>
                    </ul>
                </li>


                {{-- Profile --}}
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link {{request()->is('salon/profile*') ? 'active' : ''}}">
                        <i class="nav-icon far fa-address-card"></i>
                        <p>
                            Tài khoản
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('salon.profile.display-profile')}}" class="nav-link {{request()->is('salon/profile/display-profile') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cập nhật trang cá nhân</p>
                            </a>
                            <a href="{{route('salon.profile.display-images')}}" class="nav-link {{request()->is('salon/profile/display-images') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Chỉnh sửa ảnh salon</p>
                            </a>
                            <a href="{{route('salon.profile.time-desc')}}" class="nav-link {{request()->is('salon/profile/time-desc') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Miêu tả thời gian</p>
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
