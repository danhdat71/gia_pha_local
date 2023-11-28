<header class="topbar">
    <style>
        .logo img {
            width: 50px;
        }

        .logo span {
            font-weight: bold;
            color:rgb(0, 169, 0);
        }
    </style>
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <b class="logo">
                    <img src="img/fixed/logo.png" alt="homepage" class="dark-logo" />
                    <span>Cây Gia Phả</span>
                </b>
            </a>
        </div>
        <div class="navbar-collapse">
            <ul class="navbar-nav me-auto">
            </ul>
            <ul class="navbar-nav my-lg-0">
                <li class="nav-item dropdown u-pro">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="{{route('family_member.mypage')}}">
                        <img
                            @if (!empty(auth()->guard('family_member')->user()->full_avatar_path))
                            src="{{auth()->guard('family_member')->user()->full_avatar_path}}"
                            @else
                            src="img/fixed/default_avatar_1.png"
                            @endif
                            alt="user" class="" />
                        <span
                            class="hidden-md-down">{{auth()->guard('family_member')->user()->full_name}}&nbsp;</span> </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown"></ul>
                </li>
            </ul>
        </div>
    </nav>
</header>