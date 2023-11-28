@extends('family_member.desktop.main')
@section('content')
<div class="row blog-detail">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body">
                <div class="head">
                    <div class="left">
                        <div class="wrap-blog-avatar">
                            <img src="{{route('get_blog_avatar_image', $blog->avatar)}}" alt="">
                        </div>
                    </div>
                    <div class="right">
                        <div class="title">{{$blog->title}}</div>
                        <div class="created-at">
                            Ngày tạo: 
                            {{date('d-m-Y', strtotime($blog->created_at))}}
                        </div>
                        <div class="viewer-count">
                            Lượt xem: 
                            {{$blog->blogs_viewers_count}} xem
                        </div>
                    </div>
                </div>
                <div class="text-title-3 pt-3 pb-2">Chi tiết bài viết</div>
                <div class="wrap-content">
                    {!!$blog->content!!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <a href="{{route('family_member.blogs')}}" class="btn btn-secondary"><i class="far fa-long-arrow-left"></i> Quay lại</a>
    </div>
</div>
@endsection