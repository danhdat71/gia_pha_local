<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="img/fixed/logo.png" alt="AdminLTE Logo" class="brand-image elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Gia Phả</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img
                    @if (!empty(auth()->guard('root_admin')->user()->full_avatar_path))
                    src="{{auth()->guard('root_admin')->user()->full_avatar_path}}"
                    @else
                    src="img/fixed/default_avatar_1.png"
                    @endif
                    class="img-circle elevation-2"
                    alt="User Image"
                >
            </div>
            <div class="info">
                <a href="" class="d-block">{{auth()->guard('root_admin')->user()->full_name}}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                {{-- <li class="nav-item">
                    <a href="{{route('family_admin.dashboard')}}" class="nav-link @if($current_page == App\Constants\CurrentPage::DASHBOARD){{'active'}}@endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a
                        href="{{route('root_admin.users')}}"
                        @if($current_page == App\Constants\CurrentPage::USER)
                        class="nav-link active"
                        @else
                        class="nav-link"
                        @endif
                    >
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Người dùng
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{route('root_admin.user_register_view')}}"
                        @if($current_page == App\Constants\CurrentPage::USER_REGISTER)
                        class="nav-link active"
                        @else
                        class="nav-link"
                        @endif
                        
                    >
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>
                            Đăng ký
                        </p>
                    </a>
                </li>
                
                <li class="nav-header">Tài khoản</li>
                <li class="nav-item">
                    <a href="{{route('root_admin.my_page')}}" class="nav-link @if($current_page == App\Constants\CurrentPage::MYPAGE){{'active'}}@endif">
                        <i class="far fa-circle nav-icon text-info"></i>
                        <p>Tài khoản</p>
                    </a>
                </li>
                <form class="nav-item" action="{{route('root_admin.logout')}}" method="post" id="form-logout" style="cursor: pointer;">
                    @csrf
                    <a class="nav-link" id="logout">
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
