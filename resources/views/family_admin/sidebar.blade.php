<aside class="main-sidebar sidebar-dark-primary elevation-4 bg-sidebar-template">
    <!-- Brand Logo -->
    <a href="#" class="brand-link border-theme-bottom border-bottom-1">
        <img src="img/fixed/logo.png" alt="AdminLTE Logo" class="brand-image elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Gia Phả Online</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex border-theme-bottom border-bottom-1">
            <div class="image">
                <img
                    @if (!empty(auth()->guard('family_member')->user()->full_avatar_path))
                    src="{{auth()->guard('family_member')->user()->full_avatar_path}}"
                    @else
                    src="img/fixed/default_avatar_1.png"
                    @endif
                    class="img-circle elevation-2"
                    alt="User Image"
                >
            </div>
            <div class="info">
                <a
                    href="{{route('family_admin.edit_user_view', auth()->guard('family_member')->user()->id)}}"
                    class="d-block font-color-2"
                >{{auth()->guard('family_member')->user()->full_name}}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('family_admin.dashboard')}}" class="font-color-1 nav-link @if($current_page == App\Constants\CurrentPage::DASHBOARD){{'active-nav-button'}}@endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('family_admin.contact_info')}}" class="font-color-1 nav-link @if($current_page == App\Constants\CurrentPage::CONTACT_INFO){{'active-nav-button'}}@endif">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Cấu hình
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('family_admin.genealogy')}}" class="font-color-1 nav-link @if($current_page == App\Constants\CurrentPage::GENEALOGY){{'active-nav-button'}}@endif">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Gia phả
                            {{-- <span class="right badge badge-danger">{{1}}</span> --}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('family_admin.events')}}" class="font-color-1 nav-link @if($current_page == App\Constants\CurrentPage::EVENT){{'active-nav-button'}}@endif">
                        <i class="nav-icon fas fa-calendar-week"></i>
                        <p>
                            Sự kiện
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('family_admin.blogs')}}" class="font-color-1 nav-link @if($current_page == App\Constants\CurrentPage::BLOG){{'active-nav-button'}}@endif">
                        <i class="nav-icon fas fa-blog"></i>
                        <p>
                            Bài viết
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('family_admin.funds')}}" class="font-color-1 nav-link @if($current_page == App\Constants\CurrentPage::FUND){{'active-nav-button'}}@endif">
                        <i class="nav-icon fas fa-funnel-dollar"></i>
                        <p>
                            Thu chi
                        </p>
                    </a>
                </li>
                @if (auth()->guard('family_member')->user()->type == App\Constants\UserType::FAMILY_ADMIN)
                <li class="nav-item">
                    <a href="{{route('family_admin.roles')}}" class="font-color-1 nav-link @if($current_page == App\Constants\CurrentPage::ROLE){{'active-nav-button'}}@endif">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                            Vai trò
                        </p>
                    </a>
                </li>
                @endif
                {{-- 
                @if (auth()->user()->user_type == App\Constants\UserType::ADMIN)
                <li class="nav-item">
                    <a href="{{route('users')}}" class="nav-link @if($current_page == App\Constants\CurrentPage::USER){{'active'}}@endif">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Quản lý thành viên
                        </p>
                    </a>
                </li>
                @endif --}}
                <li class="nav-header font-color-2">Tài khoản</li>
                <li class="nav-item">
                    <a href="{{route('family_admin.my_page')}}" class="font-color-1 nav-link @if($current_page == App\Constants\CurrentPage::MYPAGE){{'active-nav-button'}}@endif">
                        <i class="far fa-circle nav-icon text-info"></i>
                        <p>Tài khoản</p>
                    </a>
                </li>
                <form class="nav-item" action="{{route('family_admin.logout')}}" method="post" id="form-logout" style="cursor: pointer;">
                    @csrf
                    <a class="nav-link font-color-1" id="logout">
                        <i class="far fa-circle nav-icon text-danger"></i>
                        <p>Đăng xuất</p>
                    </a>
                    <script>
                        document.getElementById('logout').addEventListener('click', function(){
                            document.getElementById('form-logout').submit();
                        });
                    </script>
                </form>
            </ul>
        </nav>
    </div>
</aside>
