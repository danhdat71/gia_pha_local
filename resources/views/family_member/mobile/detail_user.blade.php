@extends('family_member.main')
@section('content')
<!-- Fancybox -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<div class="root-content detail-user">
    <div class="container-fluid">
        <div class="wrap-head">
            <div class="left">
                <a
                    class="wrap-avatar fancybox"
                    @if ($user->avatar)
                    href="{{route('get_avatar_image', $user->avatar)}}"
                    @else
                    href="img/fixed/default_avatar_1.png"
                    @endif
                >
                    <img
                        @if ($user->avatar)
                        src="{{route('get_avatar_image', $user->avatar)}}"
                        @else
                        src="img/fixed/default_avatar_1.png"
                        @endif
                        alt="avatar"
                    >
                </a>
            </div>
            <div class="right">
                <div class="name">{{$user->full_name}}</div>
                <div class="person-info-top">{{$user->role_name}}</div>
                <div class="person-info-top">{{$user->extra['birthday']}}</div>
                <div class="person-info-top">{{$user->extra['leaveday']}}</div>
            </div>
        </div>
        <div class="wrap-info-main">
            <div>
                <b>THÔNG TIN CHUNG</b>
            </div>
            <div class="info-main-item">
                <b><span class="icon"><i class="fal fa-envelope"></i></span> Email:</b>
                <span>{{$user->email}}</span>
            </div>
            @if ($user->phone)
            <div class="info-main-item">
                <b><span class="icon"><i class="fas fa-mobile-alt"></i></span> Số ĐT:</b>
                <span>{{$user->phone}}</span>
            </div>
            @endif
            @if ($user->cccd_number)
            <div class="info-main-item">
                <b><span class="icon"><i class="far fa-id-card"></i></span> Căn cước:</b>
                <span>{{$user->cccd_number}}</span>
            </div>
            @endif
            @if ($user->cccd_image_before && $user->cccd_image_after)
            <div class="wrap-cccd-imgs">
                <a href="{{route('get_cccd_image', $user->cccd_image_before)}}" class="wrap-cccd-img fancybox">
                    <img src="{{route('get_cccd_image', $user->cccd_image_before)}}" alt="image">
                </a>
                <a href="{{route('get_cccd_image', $user->cccd_image_after)}}" class="wrap-cccd-img fancybox">
                    <img src="{{route('get_cccd_image', $user->cccd_image_after)}}" alt="image">
                </a>
            </div>
            @endif
            @if ($user->address)
            <div class="info-main-item">
                <b>Địa chỉ:</b>
                <span>{{$user->address}}</span>
            </div>
            @endif
            @if ($user->domicile)
            <div class="info-main-item">
                <b>Nguyên quán:</b>
                <span>{{$user->domicile}}</span>
            </div>
            @endif
        </div>
        <div class="wrap-info-other">
            <div>
                <b>THÔNG TIN KHÁC</b>
            </div>
            @if ($user->job)
            <div class="info-main-item">
                <b><span class="icon"><i class="fas fa-briefcase"></i></span> Nghề nghiệp:</b>
                <span>{{$user->job}}</span>
            </div>
            @endif
            @if ($user->position)
            <div class="info-main-item">
                <b><span class="icon"><i class="fas fa-user-tag"></i></span> Chức vụ:</b>
                <span>{{$user->position}}</span>
            </div>
            @endif
            @if ($user->organization)
            <div class="info-main-item">
                <b><span class="icon"><i class="fas fa-building"></i></span> Tổ chức:</b>
                <span>{{$user->organization}}</span>
            </div>
            @endif
            @if ($user->rest_place)
            <div class="info-main-item">
                <b><span class="icon"><i class="fas fa-tombstone-alt"></i></span> Vị trí an nghỉ:</b>
                <span>{{$user->rest_place}}</span>
            </div>
            @endif
        </div>
        @if ($user->cert_images)
        <div class="wrap-info-other">
            <div>
                <b>HÌNH ẢNH CHỨNG CHỈ</b>
            </div>
            <div class="wrap-image-list">
                @foreach (explode(',', $user->cert_images) as $image)
                <a class="item-image fancybox" href="{{route('get_cert_image', $image)}}">
                    <img src="{{route('get_cert_image', $image)}}" alt="image">
                </a>
                @endforeach
            </div>
        </div>
        @endif
        @if ($user->rest_images)
        <div class="wrap-info-other">
            <div>
                <b>HÌNH ẢNH AN NGHỈ</b>
            </div>
            <div class="wrap-image-list">
                @foreach (explode(',', $user->rest_images) as $image)
                <a class="item-image fancybox" href="{{route('get_rest_image', $image)}}">
                    <img src="{{route('get_rest_image', $image)}}" alt="image">
                </a>
                @endforeach
            </div>
        </div>
        @endif
        @if ($user->story != "")
        <div class="wrap-info-other">
            <div>
                <b>TIỂU SỬ</b>
            </div>
            <div class="wrap-story">
                {!!$user->story!!}
            </div>
        </div>
        @endif
    </div>
    <div class="container-fluid pt-4">
        <a href="{{route('family_member.genealogy')}}" class="btn btn-sm btn-secondary"><i class="far fa-long-arrow-left"></i> Quay lại</a>
    </div>
</div>
<script>
    $('.fancybox').fancybox({
		transitionIn: 'elastic',
		transitionOut: 'elastic',
	});
</script>
@stop