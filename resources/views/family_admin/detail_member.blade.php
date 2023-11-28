@extends('family_admin.main')
@section('content')
    <div class="content-wrapper">
        <link rel="stylesheet" href="css/detail_member.css">
        @include('global.content_head', [
            'title' => 'Thông tin của ' . $member->full_name,
        ])
        <style>

            .wrap-video-detail-content {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                grid-gap: 20px;
            }

            .video-item .vr-youtube-video{
                aspect-ratio: 16/9;
            }

            @media screen and (max-width: 1545px) {
                .wrap-image div {
                    left: 0;
                }

                .col-right .wrap-image {
                    aspect-ratio: 5/5;
                }
            }

            @media screen and (max-width: 1024px) {
                .wrap-image div {
                    left: 50%;
                    transform: translateX(-50%);
                }

                .wrap-content {
                    padding: 0;
                    text-align: center;
                    padding-top: 30px;
                }

                .wrap-relations {
                    justify-content: center;
                    flex-wrap: wrap;
                }

                .relation-member-item {
                    padding: 15px;
                }

                .wrap-content-detail .wrap-image-detail-content {
                    grid-template-columns: 1fr 1fr 1fr;
                }
            }

            @media screen and (max-width: 986px) {
                .col-left {
                    order: 2;
                }

                .col-right {
                    order: 1;
                }

                .relation-member-item {
                    padding: 10px;
                }
                
                .flex-info {
                    justify-content: center;
                }

                .col-left {
                    text-align: center;
                    padding-top: 20px;
                }
            }

            @media screen and (max-width: 730px) {
                .wrap-content-detail .wrap-image-detail-content,
                .wrap-video-detail-content {
                    grid-template-columns: 1fr;
                }
            }

            @media screen and (max-width: 425px) {
                .relation-member-item {
                    padding: 6px;
                }

                .full-name {
                    font-size: 30px;
                }

                .role-name {
                    font-size: 18px;
                }

                .info-item {
                    font-size: 15px;
                }
            }

        </style>
        <section class="content">
            <div class="container-fluid">
                <div class="card mb-0 card-info">
                    <div class="wrap-background">
                        <div></div>
                        <img
                            @if ($member->avatar)
                            src="{{ route('get_avatar_image', $member->avatar) }}"
                            @else
                            src="img/fixed/default_avatar_1.png"
                            @endif
                            alt="{{ $member->avatar }}"
                        >
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 col-left">
                                <div class="role-name">{{ $member->role_name }}</div>
                                <div class="full-name">{{ $member->full_name }}</div>
                                <div class="d-flex flex-info">
                                    <div class="wrap-content">
                                        @if (!$member->born_day && $member->born_year)
                                        <div class="info-item">
                                            <b>Năm sinh:</b>
                                            <span>{{$member->born_year}}</span>
                                        </div>
                                        @elseif ($member->born_day && $member->born_month && $member->born_year)
                                        <div class="info-item">
                                            <b>Ngày sinh:</b>
                                            <span>{{$member->born_day}}-{{$member->born_month}}-{{$member->born_year}}</span>
                                        </div>
                                        @endif

                                        @if (!$member->userInfo->leave_year && $member->userInfo->leave_day && $member->userInfo->leave_month)
                                            <div class="info-item">
                                                <b>Ngày giỗ:</b>
                                                <span>{{ $member->userInfo->leave_day }}-{{$member->userInfo->leave_month}}</span>
                                            </div>
                                        @elseif ($member->userInfo->leave_day && $member->userInfo->leave_month && $member->userInfo->leave_year)
                                            <div class="info-item">
                                                <b>Ngày mất:</b>
                                                <span>{{ $member->userInfo->leave_day }}-{{$member->userInfo->leave_month}}-{{$member->userInfo->leave_year}}</span>
                                            </div>
                                        @endif
                                        @if (!empty($member->phone))
                                            <div class="info-item">
                                                <b>Số điện thoại:</b>
                                                <span>{{ $member->phone }}</span>
                                            </div>
                                        @endif
                                        @if (!empty($member->email))
                                            <div class="info-item">
                                                <b>Email:</b>
                                                <span>{{ $member->email }}</span>
                                            </div>
                                        @endif
                                        <div class="info-item">
                                            <b>Giới tính:</b>
                                            @if ($member->gender == App\Constants\Gender::MALE)
                                                <span>Nam</span>
                                            @else
                                                <span>Nữ</span>
                                            @endif
                                        </div>
                                        @if (!empty($member->position_index))
                                            <div class="info-item">
                                                <b>Thứ tự:</b>
                                                <span>{{ $member->position_index }}</span>
                                            </div>
                                        @endif
                                        @if ($parent)
                                            <div class="info-item">
                                                <b>Phụ huynh:</b>
                                                <div class="wrap-relations">
                                                    <div class="relation-member-item">
                                                        <div class="relation-member-avatar">
                                                            <img
                                                                @if ($parent->avatar)
                                                                src="{{ route('get_avatar_image', $parent->avatar) }}"
                                                                @else
                                                                src="img/fixed/default_avatar_1.png"
                                                                @endif
                                                                alt="{{ $parent->avatar }}">
                                                        </div>
                                                        <div class="relation-member-fullname">{{ $parent->full_name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($couple && $couple->count() > 0)
                                            <div class="info-item">
                                                @if ($member->gender == App\Constants\Gender::MALE)
                                                    <b>Vợ:</b>
                                                @else
                                                    <b>Chồng:</b>
                                                @endif
                                                <div class="wrap-relations">
                                                    @foreach ($couple as $couple)
                                                        <div class="relation-member-item">
                                                            <div class="relation-member-avatar">
                                                                <img
                                                                    @if ($couple->avatar)
                                                                    src="{{ route('get_avatar_image', $couple->avatar) }}"
                                                                    @else
                                                                    src="img/fixed/default_avatar_1.png"
                                                                    @endif
                                                                    alt="{{ $couple->avatar }}"
                                                                >
                                                            </div>
                                                            <div class="relation-member-fullname">{{ $couple->full_name }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        @if ($child->count() > 0)
                                            <div class="info-item">
                                                <b>Con cái:</b>
                                                <div class="wrap-relations">
                                                    @foreach ($child as $child)
                                                        <div class="relation-member-item">
                                                            <div class="relation-member-avatar">
                                                                <img
                                                                    @if ($child->avatar)
                                                                    src="{{ route('get_avatar_image', $child->avatar) }}"
                                                                    @else
                                                                    src="img/fixed/default_avatar_1.png"
                                                                    @endif
                                                                    alt="{{ $child->avatar }}"
                                                                >
                                                            </div>
                                                            <div class="relation-member-fullname">{{ $child->full_name }}</div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="wrap-content">
                                        @if ($member->userInfo->job)
                                        <div class="info-item">
                                            <b>Nghề nghiệp:</b>
                                            <span>{{ $member->userInfo->job }}</span>
                                        </div>
                                        @endif
                                        @if ($member->userInfo->position)
                                        <div class="info-item">
                                            <b>Chức vụ:</b>
                                            <span>{{ $member->userInfo->position }}</span>
                                        </div>
                                        @endif
                                        @if ($member->userInfo->organization)
                                        <div class="info-item">
                                            <b>Tổ chức:</b>
                                            <span>{{ $member->userInfo->organization }}</span>
                                        </div>
                                        @endif
                                        @if ($member->userInfo->cccd_image_before || $member->userInfo->cccd_image_after)
                                        <div class="info-item">
                                            <b>Căn cước:</b>
                                            <div class="wrap-cccd-detail">
                                                @if ($member->userInfo->cccd_image_before)
                                                <div class="wrap-image-item">
                                                    <img src="{{route('get_cccd_image', $member->userInfo->cccd_image_before)}}" alt="">
                                                </div>
                                                @endif
                                                @if ($member->userInfo->cccd_image_after)
                                                <div class="wrap-image-item">
                                                    <img src="{{route('get_cccd_image', $member->userInfo->cccd_image_after)}}" alt="">
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-right">
                                <div class="wrap-image m-auto">
                                    <img
                                        @if ($member->avatar)
                                        src="{{ route('get_avatar_image', $member->avatar) }}"
                                        @else
                                        src="img/fixed/default_avatar_1.png"
                                        @endif
                                        alt="{{ $member->avatar }}"
                                    >
                                    <div>{{ $member->full_name }} @if ($member->born_year) - {{ $member->age() }} tuổi @endif</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($member->userInfo->cert_images)
                <div class="row mt-4 mb-4">
                    <div class="col-12">
                        <div class="wrap-content-detail">
                            <h2>Bằng cấp</h2>
                            @php
                                $certImageUrls = explode(',', $member->userInfo->cert_images);
                            @endphp
                            <div class="wrap-image-detail-content">
                                @foreach ($certImageUrls as $url)
                                    <div class="wrap-img-item">
                                        <img src="{{ route('get_cert_image', $url) }}" alt="{{ $url }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($member->userInfo->rest_images)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="wrap-content-detail">
                            <h2>Hình ảnh nơi an nghỉ</h2>
                            @php
                                $restImageUrls = explode(',', $member->userInfo->rest_images);
                            @endphp
                            <div class="wrap-image-detail-content">
                                @foreach ($restImageUrls as $url)
                                    <div class="wrap-img-item">
                                        <img src="{{ route('get_rest_image', $url) }}" alt="{{ $url }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($member->video360degrees->count() > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="wrap-content-detail">
                            <h2>Video nơi an nghỉ</h2>
                            <div class="wrap-video-detail-content">
                                @foreach ($member->video360degrees as $video)
                                <div class="video-item" data-url="{{$video->url}}">
                                    <div class="vr-youtube-video"></div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-12">
                <div class="text-right pb-3 pt-3">
                    <a href="{{route('family_admin.genealogy')}}" class="btn btn-secondary"><i class="fas fa-long-arrow-alt-left"></i> Quay lại</a>
                </div>
            </div>
        </section>
        <!-- Modal -->
        <div class="modal fade" id="detailImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 800px;">
                <div class="modal-content">
                    <img class="w-100" src="" alt="">
                </div>
            </div>
        </div>
        <script>
            $('.wrap-img-item').click(function(){
                let imgUrl = $(this).find('img').attr('src');
                console.log(imgUrl);
                $('#detailImageModal').find('img').attr('src', imgUrl);
                $('#detailImageModal').modal('show');
            });

            // Youtube render
            function getId(url)
            {
                const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
                const match = url.match(regExp);
                return (match && match[2].length === 11)
                    ? match[2]
                    : null;
            }
            function getUrl(url)
            {
                let videoId = getId(url);
                const iframeMarkup = `<iframe width="100%" height="100%" src="//www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
                return iframeMarkup;
            }
            $('.video-item').each(function(){
                let url = $(this).attr('data-url');
                let iframe = getUrl(url);
                $(this).find('.vr-youtube-video').html(iframe);
            });
        </script>
    </div>
@endsection
