@extends('family_member.main')
@section('content')
<div class="root-content profile-index">
    <div class="container-fluid">
        <div class="wrap-profile-items">
            <a href="{{route('family_member.mypage')}}" class="item mobile-profile-index">
                <div class="wrap-icon">
                    <div class="card-header-template"><i class="fal fa-user-alt"></i></div>
                </div>
                <div class="wrap-title-index">Thông tin cá nhân</div>
            </a>
            <a href="{{route('family_member.funds')}}" class="item mobile-profile-index">
                <div class="wrap-icon">
                    <div class="card-header-template"><i class="nav-icon fas fa-funnel-dollar"></i></div>
                </div>
                <div class="wrap-title-index">Quỹ thu chi</div>
            </a>
            <a href="{{route('family_member.fund_register_view')}}" class="item mobile-profile-index">
                <div class="wrap-icon">
                    <div class="card-header-template"><i class="far fa-plus-octagon"></i></div>
                </div>
                <div class="wrap-title-index">Đăng ký quỹ</div>
            </a>
            <a href="{{route('family_member.contact_info')}}" class="item mobile-profile-index">
                <div class="wrap-icon">
                    <div class="card-header-template"><i class="far fa-id-card"></i></div>
                </div>
                <div class="wrap-title-index">Liên hệ</div>
            </a>
            <a href="{{route('family_member.logout')}}" class="item mobile-profile-index">
                <div class="wrap-icon">
                    <div class="card-header-template"><i class="far fa-sign-out"></i></div>
                </div>
                <div class="wrap-title-index">Đăng xuất</div>
            </a>
        </div>
    </div>
</div>
@stop