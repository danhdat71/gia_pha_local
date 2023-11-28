@extends('family_member.desktop.main')
@section('content')
<div class="row detail-user">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body">
                <div class="wrap-head-info">
                    <div class="wrap-background">
                        <div></div>
                        <img src="http://localhost/get-avatar/BcWJ0O3Geq1695138289.jpg" alt="BcWJ0O3Geq1695138289.jpg">
                    </div>
                    <div class="wrap-head position-relative">
                        <div class="left">
                            <div class="wrap-avatar">
                                <img
                                    @if ($user->avatar)
                                    src="{{route('get_avatar_image', $user->avatar)}}"
                                    @else
                                    src="img/fixed/default_avatar_1.png"
                                    @endif
                                    alt=""
                                >
                            </div>
                        </div>
                        <div class="right">
                            <div class="name">{{$user->full_name}}</div>
                            <div class="person-info-top">{{$user->role_name}}</div>
                            <div class="person-info-top">{{$user->extra['birthday']}}</div>
                            <div class="person-info-top">{{$user->extra['leaveday']}}</div>
                        </div>
                    </div>
                    <div class="wrap-info-main position-relative">
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
                            <div class="wrap-cccd-img">
                                <img src="{{route('get_cccd_image', $user->cccd_image_before)}}" alt="">
                            </div>
                            <div class="wrap-cccd-img">
                                <img src="{{route('get_cccd_image', $user->cccd_image_after)}}" alt="">
                            </div>
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
                </div>
                <div class="wrap-info-other">
                    <div>
                        <b class="section-title">THÔNG TIN KHÁC</b>
                    </div>
                    @if ($user->job)
                    <div class="info-main-item-dark">
                        <b><span class="icon"><i class="fas fa-briefcase"></i></span> Nghề nghiệp:</b>
                        <span>{{$user->job}}</span>
                    </div>
                    @endif
                    @if ($user->position)
                    <div class="info-main-item-dark">
                        <b><span class="icon"><i class="fas fa-user-tag"></i></span> Chức vụ:</b>
                        <span>{{$user->position}}</span>
                    </div>
                    @endif
                    @if ($user->organization)
                    <div class="info-main-item-dark">
                        <b><span class="icon"><i class="fas fa-building"></i></span> Tổ chức:</b>
                        <span>{{$user->organization}}</span>
                    </div>
                    @endif
                    @if ($user->rest_place)
                    <div class="info-main-item-dark">
                        <b><span class="icon"><i class="fas fa-tombstone-alt"></i></span> Vị trí an nghỉ:</b>
                        <span>{{$user->rest_place}}</span>
                    </div>
                    @endif
                </div>
                @if ($user->userInfo->cert_images)
                <div class="wrap-info-other">
                    <div>
                        <b class="section-title">HÌNH ẢNH CHỨNG CHỈ</b>
                    </div>
                    <div class="wrap-image-list">
                        @foreach (explode(',', $user->userInfo->cert_images) as $image)
                        <div class="item-image">
                            <img src="{{route('get_cert_image', $image)}}" alt="{{$image}}" loading="lazy">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @if ($user->userInfo->rest_images)
                <div class="wrap-info-other">
                    <div>
                        <b class="section-title">HÌNH ẢNH AN NGHỈ</b>
                    </div>
                    <div class="wrap-image-list">
                        @foreach (explode(',', $user->userInfo->rest_images) as $image)
                        <div class="item-image">
                            <img src="{{route('get_rest_image', $image)}}" alt="{{$image}}" loading="lazy">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @if ($user->story != "")
                <div class="wrap-info-other">
                    <div>
                        <b class="section-title">TIỂU SỬ</b>
                    </div>
                    <div class="wrap-story">
                        {!!$user->story!!}
                    </div>
                </div>
                @endif

                @php
                    $isNullData = $user->job == null && $user->position == null && $user->organization == null && $user->userInfo->rest_place == null && $user->userInfo->cert_images == null && $user->userInfo->rest_images == null && $user->story == "";
                @endphp
                @if ($isNullData)
                <div class="text-center">
                    <img class="empty-data" src="img/fixed/empty_data.jpg" alt="empty_media">
                    <div class="pt-3">Chưa có thông tin khác ...</div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-12">
        <a href="{{route('family_member.genealogy')}}" class="btn btn-secondary"><i class="fas fa-long-arrow-alt-left"></i> Quay lại</a>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="detailImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 800px;">
            <div class="modal-content">
                <img class="w-100" src="" alt="">
            </div>
        </div>
    </div>
    <script>
        $('.item-image').click(function(){
            let imgUrl = $(this).find('img').attr('src');
            console.log(imgUrl);
            $('#detailImageModal').find('img').attr('src', imgUrl);
            $('#detailImageModal').modal('show');
        });
    </script>
</div>
@endsection