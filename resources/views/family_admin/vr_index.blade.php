@extends('family_admin.main')
@section('content')
    <style>
        .btn-item {
            width: 100%;
            aspect-ratio: 10/6;
            margin: auto;
            display: block;
            border-radius: 20px;
        }
        .btn-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .btn-item span.title {
            display: block;
            padding-top: 5px;
            color: #363636;
            font-weight: 600;
            text-align: center;
        }
        .btn-item span.desc {
            font-size: 14px;
            color: #828282;
            line-height: 1.4;
            display: block;
            padding-top: 5px;
        }
    </style>
    <div class="content-wrapper">
        @include('global.content_head', [
            'title' => '3D & 360 độ an nghỉ ' . $user->full_name,
        ])
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-7 m-auto">
                        <div class="row pt-5">
                            <div class="col-md-6">
                                <a href="{{route('family_admin.index_video_360', $user->id)}}" class="btn-item">
                                    <img src="img/fixed/360_bg.jpg" alt="360_bg.jpg">
                                    <span class="title">Quản lý video 360 độ</span>
                                    <span class="desc">Bằng cách cung cấp các video được quay bởi định dạng 360 độ, hệ thống sẽ hiển thị thực tế hóa video đến người dùng.</span>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="" class="btn-item">
                                    <img src="img/fixed/3D_bg.jpg" alt="3D_bg.jpg">
                                    <span class="title">Quản lý 3D ngữ cảnh</span>
                                    <span class="desc">Hiển thị & thao tác đến nơi an nghỉ thông qua thực tế ảo 3D, giúp dịch chuyển ngữ cảnh dễ dàng.</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script></script>
@endsection
